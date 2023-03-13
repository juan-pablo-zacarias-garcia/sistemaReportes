<?php

namespace App\Http\Controllers\Archivos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class archivosController extends Controller
{
    //////Vista Documentos////////////
    public function documentos(Request $request){
        
        $listaArchivos=Storage::disk('documentos')->allFiles();
        //Filtramos solo los pdf
       $listaArchivos =  array_filter($listaArchivos, function($v, $k) {
            return substr($v, -4)==".pdf";
        }, ARRAY_FILTER_USE_BOTH);

        return view('usuarios.documento',['listaArchivos'=>$listaArchivos, 'department'=>$request->department]);
    }

        ///////////////Devuelve la url de un documento, podemos agregar permisos////////////
        public function getFile(Request $request, $path){
            abort_if(
                !Storage::disk('documentos') ->exists($path),
                404,
                "The file doesn't exist. Check the path."
                );
            $url = Storage::disk('documentos')->response($path);
            return $url;
        }
}
