<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/consultas.php';

class graficasController extends Controller
{
    //
    function graficaPromedios(Request $request){
        if (auth()->user()->type == env('USER_COMUN')) {

            $datos = DB::select(queryGraficaPromedios($request->anio, explode(',',$request->meses), explode(',',$request->semanas),explode(',',$request->tipoCultivo)));
            //almacenamos los valores de los encabezados de la tabla que seran las labels de la tabla (X)
            $labels=array();
            foreach($datos as $dato){
                array_push($labels, $dato->PRODUCTO);
            }

            //almacenamos las labels del conjunto de datos
            $datasets_labels = array();
            while (current($datos[0])) {
                $datasets_labels[] = key($datos[0]);
                next($datos[0]);
            }
            //Eliminamos el encabezado de PRODUCTO
            unset($datasets_labels[0]);
            //se reinicia el index del arreglo con la siguiente instrucción
            $datasets_labels = array_values($datasets_labels);

            //Almacenamos los valores cada dataset_label
            $datasets_datas = array();


            foreach($datasets_labels as $key=>$label){
                $index=0;
                $dataset_data = new dataset;
                $dataset_data->setLabel($label);
                foreach($datos as $fila){
                    $dataset[$key]['label'][$key]=$label;
                    $dataset[$key]['data'][$index]=$fila->$label;
                    $index++;
                }
                $dataset_data->setData($dataset[$key]['data']);
                array_push($datasets_datas, $dataset_data);
            }
            //mandamos los datos para formar la tabla de la tabla
            return view('usuarios.recursosGraficas.graficaPromedios', ['labels'=>$labels,'datasets'=>json_encode($datasets_datas)]);
        } else {
            return view("home");
        }
        
    }
}


class dataset
{
    var String $label;
    var $data = array();

    function setLabel($label){
        $this->label=$label;
    }
    function setData($data){
        $this->data=$data;
    }
}
