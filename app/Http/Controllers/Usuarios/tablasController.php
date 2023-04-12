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
            //mandamos los datos para formar la tabla de la tabla
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
            $datos = DB::select(queryHorizontal($request->anio));
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
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio == "0") ? "" : "AND ANIO=" . $request->anio;
            $datos = DB::select(queryCostoXHa($Ranchos, $anio));
            //almacenamos los valores de los encabezados de la tabla
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(queryCostoPromedioXHa($anio));
            //almacenamos los valores de los encabezados de la tabla
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.costosxha', ['datos' => $datos, 'headers' => $headers,'datos2' => $datos2, 'headers2' => $headers2, 'anio' => $request->anio]);
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
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio == "0") ? "" : "AND ANIO=" . $request->anio;

            $datos = DB::select(queryVentasXHa($Ranchos, $anio));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(queryVentasPromedioXHa($anio));
            //almacenamos los valores de los encabezados de la tabla
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.ventasxha', ['datos' => $datos,'datos2' => $datos2, 'headers' => $headers,'headers2' => $headers2, 'anio' => $request->anio]);
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
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio == "0") ? "" : "AND ANIO=" . $request->anio;

            $datos = DB::select(queryRendimientoXHa($Ranchos, $anio));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }


            $datos2 = DB::select(queryRendimientoPromedioXHa($anio));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.rendimientoxha', ['datos' => $datos,'datos2' => $datos2, 'headers' => $headers, 'headers2' => $headers2, 'anio' => $request->anio]);
        } else {
            return view("home");
        }
    }

    public function tablaResultadosXCultivo(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio == "0") ? "" : "AND ANIO=" . $request->anio;
            $datos = DB::select(queryResultadosXCultivo($Ranchos, $anio));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(queryResultadosPromedioXCultivo($anio));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.resultadosxcultivo', ['datos' => $datos,'datos2' => $datos2, 'headers' => $headers,'headers2' => $headers2, 'anio' => $request->anio]);
        } else {
            return view("home");
        }
    }

    public function tablaAgroquimicosXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio == "0") ? "" : "AND ANIO=" . $request->anio;

            $datos = DB::select(queryAgroquimicosXHa($Ranchos, $anio));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(queryAgroquimicosPromedioXHa($anio));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.agroquimicosxha', ['datos' => $datos, 'headers' => $headers,'datos2' => $datos2, 'headers2' => $headers2, 'anio' => $request->anio]);
        } else {
            return view("home");
        }
    }

    public function tablaFertilizantesXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio == "0") ? "" : "AND ANIO=" . $request->anio;
            $datos = DB::select(fertilizantesXHa($Ranchos, $anio));
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(fertilizantesPromedioXHa($anio));
            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.fertilizantesxha', ['datos' => $datos, 'headers' => $headers,'datos2' => $datos2, 'headers2' => $headers2, 'anio' => $request->anio]);
        } else{
            return view("home");
        }
    }

    public function tablaPlantulaXHa(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //consulta para obtener todos los ranchos que existen
            $Ranchos = DB::select(queryRanchos());
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio == "0") ? "" : "AND ANIO=" . $request->anio;

            $datos = DB::select(queryPlantulaXHa($Ranchos, $anio));

            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0])) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }

            $datos2 = DB::select(queryPlantulaPromedioXHa($anio));

            //almacenamos los valores de los encabezados de la tabla 
            $headers2 = array();
            while (current($datos2[0])) {
                $headers2[] = key($datos2[0]);
                next($datos2[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.plantulaxha', ['datos' => $datos, 'headers' => $headers,'datos2' => $datos2, 'headers2' => $headers2, 'anio' => $request->anio]);
        } else {
            return view("home");
        }
    }

    public function tablaDetalle(Request $request)
    {
        if (auth()->user()->type == env('USER_COMUN')) {
            //Si se envía el año = 0 entonces devuelve todos los años
            $anio = ($request->anio == "0") ? "" : "AND ANIO=" . $request->anio;
            //Si el rancho es TOTAL entonces muestra todos los datos del producto
            if ($request->rancho != 'all') {
                $datos = DB::select("SELECT * from horizontal WHERE CODIGO!='0' and PRODUCTO='" . $request->producto . "' and RANCHO='" . $request->rancho . "' " . $anio);
            }
            //Si no, muestra filtrado por PRODUCTO, RANCHO y AÑO
            else {
                $datos = DB::select("SELECT * from horizontal WHERE CODIGO!='0' and PRODUCTO='" . $request->producto . "' " . $anio);
            }
            //almacenamos los valores de los encabezados de la tabla 
            $headers = array();
            while (current($datos[0]) != null) {
                $headers[] = key($datos[0]);
                next($datos[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosTablas.detallesTablas.detallesTablas', ['datos' => $datos, 'headers' => $headers, 'anio' => $anio]);
        } else {
            return view("home");
        }
    }

}