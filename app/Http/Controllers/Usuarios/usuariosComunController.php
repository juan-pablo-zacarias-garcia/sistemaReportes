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
        if(auth()->user()->isAdmin==0){
            return view('usuarios.recursos.horizontal');
        }
        else{
            return view("home");
        }
    }
     //Retorna la tabla costoXHa
     public function tablaCostoXHa(){
        if(auth()->user()->isAdmin==0){
            
            $datos = DB::select("
            SELECT PRODUCTO1,
            CASE WHEN [BUENA VISTA] IS NULL THEN 0
                ELSE [BUENA VISTA]
            END AS [BUENA VISTA],
            CASE WHEN [EL PINO] IS NULL THEN 0
                ELSE [EL PINO]
            END AS [EL PINO],
            CASE WHEN [FLORENCIA] IS NULL THEN 0
                ELSE [FLORENCIA]
            END AS [FLORENCIA],
            CASE WHEN [LA CANTERA] IS NULL THEN 0
                ELSE [LA CANTERA]
            END AS [LA CANTERA],
            CASE WHEN [LA ESTACADA] IS NULL THEN 0
                ELSE [LA ESTACADA]
            END AS [LA ESTACADA],
            CASE WHEN [LABRADORES] IS NULL THEN 0
                ELSE [LABRADORES]
            END AS [LABRADORES],
            CASE WHEN [PUERTO DE SOSA] IS NULL THEN 0
                ELSE [PUERTO DE SOSA]
            END AS [PUERTO DE SOSA],
            CASE WHEN [SAN ANDRES] IS NULL THEN 0
                ELSE [SAN ANDRES]
            END AS [SAN ANDRES]
            FROM (select RANCHO1, PRODUCTO1,  sum(TOTAL_COSTO1)/sum(HECTAREAS1) CostoXHa from tablas where RANCHO1!='0' group by RANCHO1, PRODUCTO1) as tabla PIVOT (
                sum(CostoXHa) FOR RANCHO1 IN ([BUENA VISTA],[EL PINO],[FLORENCIA],[LA CANTERA],[LA ESTACADA],[LABRADORES],[PUERTO DE SOSA],[SAN ANDRES])
            ) as tabla2;");

            //Sacamos los encabezados de la tabla
            $headers = [];
            while (current($datos[0])) {
                $headers = key($datos[0]);
                next($datos[0]);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursos.costosxha',['datos'=>$datos]);
        }
        else{
            return view("home");
        }
    }
    

    //////////////////////////////////servicios web////////////////////////////////
    
    //devuelve la tabla Costo x Hectarea
    


}