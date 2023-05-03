<?php
namespace App\Http\Controllers\Usuarios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
require __DIR__ . '/consultas.php';

class tablasController extends Controller
{
    //////////////////////////////////Vistas////////////////////////////////
    //Retorna la vista principal de tablas
    public function tablas()
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            $anios = DB::select("SELECT DISTINCT ANIO from horizontal WHERE CODIGO!='0' ");
            //mandamos los datos para formar la tabla
            return view('usuarios.tablas', ['anios' => $anios]);
        } else {
            return view("home");
        }
    }
    //Retorna la tabla horizontal
    public function tablaHorizontal(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {

            //Si se envía el año = 0 entonces devuelve todos los años
            //la query recibe el año, un arreglo de meses y un arreglo de semanas para hacer la consulta
            $datos = DB::select(queryHorizontal($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();

            while (current($datos[0]) != null) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }
            //mandamos los datos y encabezados para formar la tabla
            return view('usuarios.recursosTablas.horizontal', ['datos' => $datos, 'headers' => $headers]);
        } else {
            return view("home");
        }
    }

    //Retorna la tabla costoXHa
    public function tablaCostoXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            $datos = DB::select(queryCostoXHa($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));
            //almacenamos los valores de los encabezados de la tabla
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(queryCostoPromedioXHa($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));
            //almacenamos los valores de los encabezados de la tabla
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            
            //Definimos las columnas involucradas en la consulta del detalle
            $cols="FORMAT(PLANTULA,'$#,##0.00') AS [PLANTULA],
            FORMAT(AGROQUIMICOS,'$#,##0.00') AS [AGROQUIMICOS],
            FORMAT(FERTILIZANTES,'$#,##0.00') AS [FERTILIZANTES],
            FORMAT(MANO_DE_OBRA1,'$#,##0.00') AS [MANO DE OBRA],
            FORMAT(FLETES1,'$#,##0.00') AS [FLETES],
            FORMAT(RENTA,'$#,##0.00') AS [RENTA],
            FORMAT(MAQUILA1,'$#,##0.00') AS [MAQUILA],
            FORMAT(EMPAQUE1,'$#,##0.00') AS [EMPAQUE],
            FORMAT(TOTAL_COSTO,'$#,##0.00') AS [COSTO TOTAL],
            FORMAT(TOTAL_COSTO/HECTAREAS,'$#,##0.00') AS [COSTO POR HECTAREA]";

            //mandamos los datos para formar la tabla
            //$datos: Los datos de la consulta para la primer tabla
            //$headers: Los encabezados para formar la primer tabla
            //$datos2: Los datos de la consulta para la segunda tabla
            //$headers2: Los encabezados para formar la segunda tabla
            //$anio, $meses, $semanas
            //$cols: las columnas para la tabla detalle. Las invoucradas en la consulta de datos.
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Costos por hectarea',
            'rutaTabla'=>'tablaCostoXHa',
            'datos' => $datos, 'headers' => $headers,
             'datos2' => $datos2, 'headers2' => $headers2,
             'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
             'cols'=>$cols,
             'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }

    //Retorna la tabla ventas x hectarea
    public function tablaVentasXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());

            $datos = DB::select(queryVentasXHa($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }
            $datos2 = DB::select(queryVentasPromedioXHa($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));
            //almacenamos los valores de los encabezados de la tabla
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols="FORMAT(VENTAS_TOTALES,'$#,##0.00') AS [VENTAS TOTALES], FORMAT(VENTAS_TOTALES/HECTAREAS,'$#,##0.00') AS [VENTAS POR HECTAREA]";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Ventas por hectarea',
            'rutaTabla'=>'tablaVentasXHa',
            'datos' => $datos, 'headers' => $headers,
             'datos2' => $datos2, 'headers2' => $headers2,
             'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
             'cols'=>$cols,
             'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }
    //Retorna la tabla rendimiento x hectarea
    public function tablaRendimientoXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());

            $datos = DB::select(queryRendimientoXHa($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }


            $datos2 = DB::select(queryRendimientoPromedioXHa($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols="FORMAT(KGS_TOTALES,'#,##0.00 KG') AS [KGS TOTALES],FORMAT((KGS_TOTALES/HECTAREAS)/6,'#,##0.00') AS [CAJAS POR HECTAREA] ,FORMAT(KGS_TOTALES/HECTAREAS,'#,##0.00 KG') AS [KGS POR HECTAREA]";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Rendimiento por hectarea',
            'rutaTabla'=>'tablaRendimientoXHa',
            'datos' => $datos, 'headers' => $headers,
             'datos2' => $datos2, 'headers2' => $headers2,
             'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
             'cols'=>$cols,
             'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }
    public function tablaResultadosXCultivo(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            
            $datos = DB::select(queryResultadosXCultivo($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(queryResultadosPromedioXCultivo($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols="FORMAT(UTILIDAD_O_PERDIDA/HECTAREAS,'$#,##0.00') AS [UTILIDAD O PERDIDA POR HECTAREA], FORMAT(UTILIDAD_O_PERDIDA,'$#,##0.00') AS [UTILIDAD O PERDIDA]";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Resultados por cultivo',
            'rutaTabla'=>'tablaResultadosXHa',
            'datos' => $datos, 'headers' => $headers,
             'datos2' => $datos2, 'headers2' => $headers2,
             'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
             'cols'=>$cols,
             'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }
    public function tablaAgroquimicosXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            

            $datos = DB::select(queryAgroquimicosXHa($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(queryAgroquimicosPromedioXHa($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols="FORMAT(AGROQUIMICOS,'$#,##0.00') AS AGROQUIMICOS, FORMAT(AGROQUIMICOS/HECTAREAS,'$#,##0.00') AS [AGROQUIMICOS POR HECTAREA]";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Agroquímicos por hectarea',
            'rutaTabla'=>'tablaAgroquimicosXHa',
            'datos' => $datos, 'headers' => $headers,
             'datos2' => $datos2, 'headers2' => $headers2,
             'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
             'cols'=>$cols,
             'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }

    public function tablaFertilizantesXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            
            $datos = DB::select(fertilizantesXHa($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(fertilizantesPromedioXHa($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));
            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols="FORMAT(FERTILIZANTES,'$#,##0.00') AS FERTILIZANTES, FORMAT(FERTILIZANTES/HECTAREAS,'$#,##0.00') AS [FERTILIZANTES POR HECTAREA]";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Fertilizantes por hectarea',
            'rutaTabla'=>'tablaFertilizantesXHa',
            'datos' => $datos, 'headers' => $headers,
             'datos2' => $datos2, 'headers2' => $headers2,
             'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
             'cols'=>$cols,
             'tipoCultivo'=>$request->tipoCultivo]);
        } else{
            return view("home");
        }
    }

    public function tablaPlantulaXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            

            $datos = DB::select(queryPlantulaXHa($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(queryPlantulaPromedioXHa($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols="FORMAT(PLANTULA,'$#,##0.00') AS PLANTULA, FORMAT(PLANTULA/HECTAREAS,'$#,##0.00') AS [PLANTULA POR HECTAREA]";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Plántula por hectarea',
            'rutaTabla'=>'tablaPlantulaXHa',
            'datos' => $datos, 'headers' => $headers,
             'datos2' => $datos2, 'headers2' => $headers2,
             'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
             'cols'=>$cols,
             'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }

    public function tablaFletesXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            $datos = DB::select(queryFletesXHa($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }
            $datos2 = DB::select(queryFletesPromedioXHa($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols=" FORMAT(FLETES1,'$#,##0.00') AS [FLETES],FORMAT(FLETES1/HECTAREAS,'$#,##0.00') AS [FLETES POR HA] ";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Fletes por hectarea', 
            'rutaTabla'=>'tablaFletesXHa',
            'datos' => $datos, 'headers' => $headers,  
            'datos2' => $datos2, 'headers2' => $headers2,
            'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
            'cols'=>$cols,
            'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }

    public function tablaManoDeObraXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            $datos = DB::select(queryManoDeObraXHa($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }
            $datos2 = DB::select(queryManoDeObraPromedioXHa($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols=" FORMAT(MANO_DE_OBRA1,'$#,##0.00') AS [MANO DE OBRA], FORMAT(MANO_DE_OBRA1/HECTAREAS,'$#,##0.00') AS [MANO DE OBRA POR HA] ";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Mano de obra por hectarea', 
            'rutaTabla'=>'tablaManoDeObraXHa',
            'datos' => $datos, 'headers' => $headers,  
            'datos2' => $datos2, 'headers2' => $headers2,
            'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
            'cols'=>$cols,
            'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }

    public function tablaMaquilaXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            $datos = DB::select(queryMaquilaXHa($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }
            $datos2 = DB::select(queryMaquilaPromedioXHa($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols=" FORMAT(MAQUILA1,'$#,##0.00') AS [MAQUILA], FORMAT((MAQUILA1/HECTAREAS),'$#,##0.00') AS [MAQUILA POR HA] ";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Maquila por hectarea', 
            'rutaTabla'=>'tablaMaquilaXHa',
            'datos' => $datos, 'headers' => $headers,  
            'datos2' => $datos2, 'headers2' => $headers2,
            'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
            'cols'=>$cols,
            'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }

    public function tablaEmpaque(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            $datos = DB::select(queryEmpaque($Ranchos, $request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }
            $datos2 = DB::select(queryEmpaquePromedio($request->anio, explode(',',$request->meses), explode(',',$request->semanas), explode(',',$request->tipoCultivo)));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            $cols=" FORMAT(EMPAQUE1,'$#,##0.00') AS [EMPAQUE] ";
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantillaTabla', 
            ['nombre'=>'Costos de empaque', 
            'rutaTabla'=>'tablaEmpaque',
            'datos' => $datos, 'headers' => $headers,  
            'datos2' => $datos2, 'headers2' => $headers2,
            'anio' => $request->anio, 'meses'=>$request->meses, 'semanas'=>$request->semanas, 
            'cols'=>$cols,
            'tipoCultivo'=>$request->tipoCultivo]);
        } else {
            return view("home");
        }
    }


    public function tablaDetalle(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {            
            $datos = DB::select(queryDetalle($request->anio,explode(',',$request->meses), explode(',',$request->semanas),$request->producto, $request->rancho, $request->cols, explode(',',$request->tipoCultivo)));            
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0]) != null) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.detallesTablas.detallesTablas', ['datos' => $datos, 'headers' => $headers]);
        } else {
            return view("home");
        }
    }

    //retorna un arreglo de objetos
    function getMeses(Request $request){
        if (auth()->user()->type == env('USER_COMUN')) {
            $meses = DB::select(queryMesesAnio($request->anio));
        return  $meses;
        }else{
            return [];
        }
    }

    //retorna un arreglo de objetos
    function getSemanas(Request $request){
        if (auth()->user()->type == env('USER_COMUN')) {
            //recibe los meses como un string separados con comas, los convertimos a un arreglo con la función explode
            $semanas = DB::select(querySemanasMes($request->anio,explode(',',$request->meses)));
        return  $semanas;
        }else{
            return [];
        }
    }
}