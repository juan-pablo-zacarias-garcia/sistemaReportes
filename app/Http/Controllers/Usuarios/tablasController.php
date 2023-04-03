<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class tablasController extends Controller
{
        //////////////////////////////////Vistas////////////////////////////////

    //Retorna la vista principal de tablas
    public function tablas(){
        if(auth()->user()->type==env('USER_COMUN')){
            $anios = DB::select("SELECT DISTINCT ANIO from horizontal WHERE CODIGO!='0' ");
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.tablas',['anios'=>$anios]); 
        }
        else{
            return view("home");
        }
    }

    //Retorna la tabla horizontal
    public function tablaHorizontal(Request $request){
        if(auth()->user()->type==env('USER_COMUN')){
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio=="0")?"":"AND ANIO=".$request->anio;

            $datos = DB::select("SELECT * from horizontal WHERE CODIGO!='0' ".$anio);
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();

            while (current($datos[0])!=null) {
                $headers[]= key($datos[0]);
                next($datos[0]);
            }
                      
            //mandamos los datos y encabezados para formar la tabla
            return view('usuarios.recursosTablas.horizontal',['datos'=>$datos, 'headers'=>$headers]); 
        }
        else{
            return view("home");
        }
    }

     //Retorna la tabla costoXHa
     public function tablaCostoXHa(Request $request){
        if(auth()->user()->type==env('USER_COMUN')){
            //consulta para obtener todos los ranchos que existen
            $queryRanchos=DB::select("Select DISTINCT RANCHO as RANCHOS from horizontal where RANCHO!='0' order by RANCHO ASC;");
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio=="0")?"":"AND ANIO=".$request->anio;
            
            

            //Definimos las partes de la consulta
            $queryP1='';
            $queryP2='';
            $queryP3='';

            foreach($queryRanchos as $r){
                foreach($r as $d){
                    $queryP1 = $queryP1.'tablaCostoXHa.['.$d.'],';
                    $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
                    $queryP3 = $queryP3.'['.$d.'],';
                }
            }
            
            //Quitamos la última coma que se le agrega
            $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
            $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
            $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

            //formamos la parte de casos de la consulta para que los nulos los cambie por cero
            $query="with tablaTotalCostoXHa as (select PRODUCTO,RANCHO,  sum(TOTAL_COSTO)/sum(HECTAREAS) CostoXHa from horizontal where RANCHO!='0' ".$anio." group by  PRODUCTO, RANCHO)
            select tablaTotalCostoXHa.PRODUCTO as PRODUCTO,".$queryP1.", sum(tablaTotalCostoXHa.CostoXHa) TOTAL from tablaTotalCostoXHa
            join
            (SELECT PRODUCTO,
            ".$queryP2."
            FROM (select RANCHO, PRODUCTO,  sum(TOTAL_COSTO)/sum(HECTAREAS) CostoXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
                sum(CostoXHa) FOR RANCHO IN (".$queryP3.")
            ) as tabla2) as tablaCostoXHa 
            on tablaTotalCostoXHa.PRODUCTO = tablaCostoXHa.PRODUCTO 
            group by tablaTotalCostoXHa.PRODUCTO, ".$queryP1.";";

            $datos = DB::select($query);
                        
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[]= key($datos[0]);
                next($datos[0]);
            }
            
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.costosxha',['datos'=>$datos, 'headers'=>$headers,'anio'=>$request->anio]); 
        }
        else{
            return view("home");
        }
    }
    
    //Retorna la tabla ventas x hectarea
    public function tablaVentasXHa(Request $request){
        if(auth()->user()->type==env('USER_COMUN')){
            //consulta para obtener todos los ranchos que existen
            $queryRanchos=DB::select("Select DISTINCT RANCHO as RANCHOS from horizontal where RANCHO!='0' order by RANCHO ASC;");
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio=="0")?"":"AND ANIO=".$request->anio;
            //Definimos las partes de la consulta
            $queryP1='';
            $queryP2='';
            $queryP3='';

            foreach($queryRanchos as $r){
                foreach($r as $d){
                    $queryP1 = $queryP1.'tablaVentasXHa.['.$d.'],';
                    $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
                    $queryP3 = $queryP3.'['.$d.'],';
                }
            }
            
            //Quitamos la última coma que se le agrega
            $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
            $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
            $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

            //formamos la parte de casos de la consulta para que los nulos los cambie por cero
            $query="with tablaTotalVentasXHa as (select PRODUCTO,RANCHO,  sum(VENTAS_TOTALES)/sum(HECTAREAS) VentasXHa from horizontal where RANCHO!='0' ".$anio." group by  PRODUCTO, RANCHO)
            select tablaTotalVentasXHa.PRODUCTO as PRODUCTO,".$queryP1.", sum(VentasXHa) TOTAL from tablaTotalVentasXHa
            join(
            SELECT PRODUCTO,
            ".$queryP2."
            FROM (select RANCHO, PRODUCTO,  sum(VENTAS_TOTALES)/sum(HECTAREAS) VentasXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
                sum(VEntasXHa) FOR RANCHO IN (".$queryP3.")
                ) as tabla2 ) as tablaVentasXHa
                on tablaTotalVentasXHa.PRODUCTO = tablaVentasXHa.PRODUCTO 
                group by tablaTotalVentasXHa.PRODUCTO, ".$queryP1.";";

            $datos = DB::select($query);
                        
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[]= key($datos[0]);
                next($datos[0]);
            }  
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.ventasxha',['datos'=>$datos, 'headers'=>$headers, 'anio'=>$request->anio]); 
        }
        else{
            return view("home");
        }
    }

    //Retorna la tabla rendimiento x hectarea
    public function tablaRendimientoXHa(Request $request){
            if(auth()->user()->type==env('USER_COMUN')){
                //consulta para obtener todos los ranchos que existen
                $queryRanchos=DB::select("Select DISTINCT RANCHO as RANCHOS from horizontal where RANCHO!='0' order by RANCHO ASC;");
                //Si se envía el año = 0 entonces devuelve todos los años
                $anio = ($request->anio=="0")?"":"AND ANIO=".$request->anio;
                //Definimos las partes de la consulta
                $queryP1='';
                $queryP2='';
                $queryP3='';
    
                foreach($queryRanchos as $r){
                    foreach($r as $d){
                        $queryP1 = $queryP1.'tablaRendimientoXHa.['.$d.'],';
                        $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
                        $queryP3 = $queryP3.'['.$d.'],';
                    }
                }
                
                //Quitamos la última coma que se le agrega
                $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
                $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
                $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);
    
                //formamos la parte de casos de la consulta para que los nulos los cambie por cero
                $query="with tablaTotalRendimientoXHa as (select PRODUCTO,RANCHO,  sum(KGS_TOTALES)/sum(HECTAREAS) RendimientoXHa from horizontal where RANCHO!='0' ".$anio." group by  PRODUCTO, RANCHO)
                select tablaTotalRendimientoXHa.PRODUCTO,".$queryP1.",sum(RendimientoXHa) TOTAL from tablaTotalRendimientoXHa
                join (
                SELECT PRODUCTO,
                ".$queryP2."
                FROM (select RANCHO, PRODUCTO,  sum(KGS_TOTALES)/sum(HECTAREAS) RendimientoXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
                    sum(RendimientoXHa) FOR RANCHO IN (".$queryP3.")
                    ) as tabla2 ) as tablaRendimientoXHa
                    on tablaTotalRendimientoXHa.PRODUCTO = tablaRendimientoXHa.PRODUCTO 
                    group by tablaTotalRendimientoXHa.PRODUCTO,".$queryP1.";";
    
                $datos = DB::select($query);
                            
                //almacenamos los valores de los encabezados de la tabla 
                $headers = array();
                while (current($datos[0])) {
                    $headers[]= key($datos[0]);
                    next($datos[0]);
                }  
                //mandamos los datos para formar la tabla de la tabla
                return view('usuarios.recursosTablas.rendimientoxha',['datos'=>$datos, 'headers'=>$headers, 'anio'=>$request->anio]); 
            }
            else{
                return view("home");
            }
    }

   public function tablaResultadosXCultivo(Request $request){
    if(auth()->user()->type==env('USER_COMUN')){
        //consulta para obtener todos los ranchos que existen
        $queryRanchos=DB::select("Select DISTINCT RANCHO as RANCHOS from horizontal where RANCHO!='0' order by RANCHO ASC;");
        //Si se envía el año = 0 entonces devuelve todos los años
        $anio = ($request->anio=="0")?"":"AND ANIO=".$request->anio;
        //Definimos las partes de la consulta
        $queryP1='';
        $queryP2='';
        $queryP3='';

        foreach($queryRanchos as $r){
            foreach($r as $d){
                $queryP1 = $queryP1.'tablaResultadosXCultivo.['.$d.'],';
                $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
                $queryP3 = $queryP3.'['.$d.'],';
            }
        }
        
        //Quitamos la última coma que se le agrega
        $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
        $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
        $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

        //formamos la parte de casos de la consulta para que los nulos los cambie por cero
        $query="with tablaTotalResultadosXCultivo as (select PRODUCTO,RANCHO,  sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS) ResultadosXCultivo from horizontal where RANCHO!='0' ".$anio." group by  PRODUCTO, RANCHO)
        select tablaTotalResultadosXCultivo.PRODUCTO,".$queryP1.",sum(ResultadosXCultivo) TOTAL from tablaTotalResultadosXCultivo
        join (
        SELECT PRODUCTO,
        ".$queryP2."
        FROM (select RANCHO, PRODUCTO,  sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS) ResultadosXCultivo from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
            sum(ResultadosXCultivo) FOR RANCHO IN (".$queryP3.")
            ) as tabla2 ) as tablaResultadosXCultivo
            on tablaTotalResultadosXCultivo.PRODUCTO = tablaResultadosXCultivo.PRODUCTO 
            group by tablaTotalResultadosXCultivo.PRODUCTO,".$queryP1.";";

        $datos = DB::select($query);
                    
        //almacenamos los valores de los encabezados de la tabla 
        $headers = array();
        while (current($datos[0])) {
            $headers[]= key($datos[0]);
            next($datos[0]);
        }  
        //mandamos los datos para formar la tabla de la tabla
        return view('usuarios.recursosTablas.resultadosxcultivo',['datos'=>$datos, 'headers'=>$headers, 'anio'=>$request->anio]); 
    }
    else{
        return view("home");
    }
   }

   public function tablaAgroquimicosXHa(Request $request){
    if(auth()->user()->type==env('USER_COMUN')){
        //consulta para obtener todos los ranchos que existen
        $queryRanchos=DB::select("Select DISTINCT RANCHO as RANCHOS from horizontal where RANCHO!='0' order by RANCHO ASC;");
        //Si se envía el año = 0 entonces devuelve todos los años
        $anio = ($request->anio=="0")?"":"AND ANIO=".$request->anio;
        //Definimos las partes de la consulta
        $queryP1='';
        $queryP2='';
        $queryP3='';

        foreach($queryRanchos as $r){
            foreach($r as $d){
                $queryP1 = $queryP1.'tablaAgroquimicosXHa.['.$d.'],';
                $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
                $queryP3 = $queryP3.'['.$d.'],';
            }
        }
        
        //Quitamos la última coma que se le agrega
        $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
        $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
        $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

        //formamos la parte de casos de la consulta para que los nulos los cambie por cero
        $query="with tablaTotalAgroquimicosXHa as (select PRODUCTO,RANCHO,  sum(AGROQUIMICOS)/sum(HECTAREAS) AgroquimicosXHa from horizontal where RANCHO!='0' ".$anio." group by  PRODUCTO, RANCHO)
        select tablaTotalAgroquimicosXHa.PRODUCTO,".$queryP1.",sum(AgroquimicosXHa) TOTAL from tablaTotalAgroquimicosXHa
        join (
        SELECT PRODUCTO,
        ".$queryP2."
        FROM (select RANCHO, PRODUCTO,  sum(AGROQUIMICOS)/sum(HECTAREAS) AgroquimicosXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
            sum(AgroquimicosXHa) FOR RANCHO IN (".$queryP3.")
            ) as tabla2 ) as tablaAgroquimicosXHa
            on tablaTotalAgroquimicosXHa.PRODUCTO = tablaAgroquimicosXHa.PRODUCTO 
            group by tablaTotalAgroquimicosXHa.PRODUCTO,".$queryP1.";";

        $datos = DB::select($query);
                    
        //almacenamos los valores de los encabezados de la tabla 
        $headers = array();
        while (current($datos[0])) {
            $headers[]= key($datos[0]);
            next($datos[0]);
        }  
        //mandamos los datos para formar la tabla de la tabla
        return view('usuarios.recursosTablas.agroquimicosxha',['datos'=>$datos, 'headers'=>$headers, 'anio'=>$request->anio]); 
    }
    else{
        return view("home");
    }
   }
    
   public function tablaFertilizantesXHa(Request $request){
    if(auth()->user()->type==env('USER_COMUN')){
        //consulta para obtener todos los ranchos que existen
        $queryRanchos=DB::select("Select DISTINCT RANCHO as RANCHOS from horizontal where RANCHO!='0' order by RANCHO ASC;");
        //Si se envía el año = 0 entonces devuelve todos los años
        $anio = ($request->anio=="0")?"":"AND ANIO=".$request->anio;
        //Definimos las partes de la consulta
        $queryP1='';
        $queryP2='';
        $queryP3='';

        foreach($queryRanchos as $r){
            foreach($r as $d){
                $queryP1 = $queryP1.'tablaFertilizantesXHa.['.$d.'],';
                $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
                $queryP3 = $queryP3.'['.$d.'],';
            }
        }
        
        //Quitamos la última coma que se le agrega
        $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
        $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
        $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

        //formamos la parte de casos de la consulta para que los nulos los cambie por cero
        $query="with tablaTotalFertilizantesXHa as (select PRODUCTO,RANCHO,  sum(FERTILIZANTES)/sum(HECTAREAS) FertilizantesXHa from horizontal where RANCHO!='0' ".$anio." group by  PRODUCTO, RANCHO)
        select tablaTotalFertilizantesXHa.PRODUCTO,".$queryP1.",sum(FertilizantesXHa) TOTAL from tablaTotalFertilizantesXHa
        join (
        SELECT PRODUCTO,
        ".$queryP2."
        FROM (select RANCHO, PRODUCTO,  sum(FERTILIZANTES)/sum(HECTAREAS) FertilizantesXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
            sum(FertilizantesXHa) FOR RANCHO IN (".$queryP3.")
            ) as tabla2 ) as tablaFertilizantesXHa
            on tablaTotalFertilizantesXHa.PRODUCTO = tablaFertilizantesXHa.PRODUCTO 
            group by tablaTotalFertilizantesXHa.PRODUCTO,".$queryP1.";";

        $datos = DB::select($query);
                    
        //almacenamos los valores de los encabezados de la tabla 
        $headers = array();
        while (current($datos[0])) {
            $headers[]= key($datos[0]);
            next($datos[0]);
        }  
        //mandamos los datos para formar la tabla de la tabla
        return view('usuarios.recursosTablas.fertilizantesxha',['datos'=>$datos, 'headers'=>$headers, 'anio'=>$request->anio]); 
    }
    else{
        return view("home");
    }
   }

   public function tablaPlantulaXHa(Request $request){
    if(auth()->user()->type==env('USER_COMUN')){
        //consulta para obtener todos los ranchos que existen
        $queryRanchos=DB::select("Select DISTINCT RANCHO as RANCHOS from horizontal where RANCHO!='0' order by RANCHO ASC;");
        //Si se envía el año = 0 entonces devuelve todos los años
        $anio = ($request->anio=="0")?"":"AND ANIO=".$request->anio;
        //Definimos las partes de la consulta
        $queryP1='';
        $queryP2='';
        $queryP3='';

        foreach($queryRanchos as $r){
            foreach($r as $d){
                $queryP1 = $queryP1.'tablaPlantulaXHa.['.$d.'],';
                $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
                $queryP3 = $queryP3.'['.$d.'],';
            }
        }
        
        //Quitamos la última coma que se le agrega
        $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
        $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
        $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

        //formamos la parte de casos de la consulta para que los nulos los cambie por cero
        $query="with tablaTotalPlantulaXHa as (select PRODUCTO,RANCHO,  sum(PLANTULA)/sum(HECTAREAS) PlantulaXHa from horizontal where RANCHO!='0' ".$anio." group by  PRODUCTO, RANCHO)
        select tablaTotalPlantulaXHa.PRODUCTO,".$queryP1.",sum(PlantulaXHa) TOTAL from tablaTotalPlantulaXHa
        join (
        SELECT PRODUCTO,
        ".$queryP2."
        FROM (select RANCHO, PRODUCTO,  sum(PLANTULA)/sum(HECTAREAS) PlantulaXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
            sum(PlantulaXHa) FOR RANCHO IN (".$queryP3.")
            ) as tabla2 ) as tablaPlantulaXHa
            on tablaTotalPlantulaXHa.PRODUCTO = tablaPlantulaXHa.PRODUCTO 
            group by tablaTotalPlantulaXHa.PRODUCTO,".$queryP1.";";

        $datos = DB::select($query);
                    
        //almacenamos los valores de los encabezados de la tabla 
        $headers = array();
        while (current($datos[0])) {
            $headers[]= key($datos[0]);
            next($datos[0]);
        }  
        //mandamos los datos para formar la tabla de la tabla
        return view('usuarios.recursosTablas.plantulaxha',['datos'=>$datos, 'headers'=>$headers, 'anio'=>$request->anio]); 
    }
    else{
        return view("home");
    }
   }

   public function tablaDetalle(Request $request){
    if(auth()->user()->type==env('USER_COMUN')){
         //Si se envía el año = 0 entonces devuelve todos los años
        $anio = ($request->anio=="0")?"":"AND ANIO=".$request->anio;
        
        //Si el rancho es TOTAL entonces muestra todos los datos del producto
        if($request->rancho!='TOTAL'){
            $datos = DB::select("SELECT * from horizontal WHERE CODIGO!='0' and PRODUCTO='".$request->producto."' and RANCHO='".$request->rancho."' ".$anio);
        }
        //Si no, muestra filtrado por PRODUCTO, RANCHO y AÑO
        else{
            $datos = DB::select("SELECT * from horizontal WHERE CODIGO!='0' and PRODUCTO='".$request->producto."' ".$anio);
        }
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            
            while (current($datos[0])!=null) {
                $headers[]= key($datos[0]);
                next($datos[0]);
            }
                      
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.detallesTablas.detallesTablas',['datos'=>$datos, 'headers'=>$headers, 'anio'=>$anio]); 
    }
    else{
        return view("home");
    }
   }

}