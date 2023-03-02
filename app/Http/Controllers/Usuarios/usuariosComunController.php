<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class usuariosComunController extends Controller
{
    //////////////////////////////////Vistas////////////////////////////////
    //Retorna la tabla horizontal
    public function tablaHorizontal(){
        if(auth()->user()->type==1){
            return view('usuarios.recursos.horizontal');
        }
        else{
            return view("home");
        }
    }

     //Retorna la tabla costoXHa
     public function tablaCostoXHa(){
        if(auth()->user()->type==1){
            //consulta para obtener todos los ranchos que existen
            $queryRanchos=DB::select("Select DISTINCT RANCHO1 as RANCHOS from tablas where RANCHO1!='0' order by RANCHO1 ASC;");
            
            

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
            $query="with tablaTotalCostoXHa as (select PRODUCTO1,RANCHO1,  sum(TOTAL_COSTO1)/sum(HECTAREAS1) CostoXHa from tablas where RANCHO1!='0' group by  PRODUCTO1, RANCHO1)
            select tablaTotalCostoXHa.PRODUCTO1 as PRODUCTO,".$queryP1.", sum(tablaTotalCostoXHa.CostoXHa) Total from tablaTotalCostoXHa
            join
            (SELECT PRODUCTO1,
            ".$queryP2."
            FROM (select RANCHO1, PRODUCTO1,  sum(TOTAL_COSTO1)/sum(HECTAREAS1) CostoXHa from tablas where RANCHO1!='0' group by RANCHO1, PRODUCTO1) as tabla PIVOT (
                sum(CostoXHa) FOR RANCHO1 IN (".$queryP3.")
            ) as tabla2) as tablaCostoXHa 
            on tablaTotalCostoXHa.PRODUCTO1 = tablaCostoXHa.PRODUCTO1 
            group by tablaTotalCostoXHa.PRODUCTO1, ".$queryP1.";";

            $datos = DB::select($query);
                        
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[]= key($datos[0]);
                next($datos[0]);
            }
            
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursos.costosxha',['datos'=>$datos, 'headers'=>$headers]); 
        }
        else{
            return view("home");
        }
    }
    
    //Retorna la tabla ventas x hectarea
    public function tablaVentasXHa(){
        if(auth()->user()->type==1){
            //consulta para obtener todos los ranchos que existen
            $queryRanchos=DB::select("Select DISTINCT RANCHO1 as RANCHOS from tablas where RANCHO1!='0' order by RANCHO1 ASC;");
            
            

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
            $query="with tablaTotalVentasXHa as (select PRODUCTO1,RANCHO1,  sum(VENTAS_TOTALES1)/sum(HECTAREAS1) VentasXHa from tablas where RANCHO1!='0' group by  PRODUCTO1, RANCHO1)
            select tablaTotalVentasXHa.PRODUCTO1 as PRODUCTO,".$queryP1.", sum(VentasXHa) TotalVentasXHa from tablaTotalVentasXHa
            join(
            SELECT PRODUCTO1,
            ".$queryP2."
            FROM (select RANCHO1, PRODUCTO1,  sum(VENTAS_TOTALES1)/sum(HECTAREAS1) VentasXHa from tablas where RANCHO1!='0' group by RANCHO1, PRODUCTO1) as tabla PIVOT (
                sum(VEntasXHa) FOR RANCHO1 IN (".$queryP3.")
                ) as tabla2 ) as tablaVentasXHa
                on tablaTotalVentasXHa.PRODUCTO1 = tablaVentasXHa.PRODUCTO1 
                group by tablaTotalVentasXHa.PRODUCTO1, ".$queryP1.";";

            $datos = DB::select($query);
                        
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[]= key($datos[0]);
                next($datos[0]);
            }
            
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursos.ventasxha',['datos'=>$datos, 'headers'=>$headers]); 
        }
        else{
            return view("home");
        }
    }

    //////////////////////////////////servicios web////////////////////////////////
    
    


}