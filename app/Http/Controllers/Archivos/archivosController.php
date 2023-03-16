<?php

namespace App\Http\Controllers\Archivos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class archivosController extends Controller
{
    //////Vista Documentos////////////
    public function documentos(Request $request){
        
        //Devuelve solo los archivos de la carpeta del departamento
        $listaArchivos=Storage::disk('documentos',)->allFiles($request->department);
        //Filtramos solo los pdf
       $listaArchivos =  array_filter($listaArchivos, function($v, $k) {
            return substr($v, -4)==".pdf";
        }, ARRAY_FILTER_USE_BOTH);

        return view('usuarios.documento',['listaArchivos'=>$listaArchivos, 'department'=>$request->department]);
    }

    ///////función para cargar archivos
    public function uploadFile(Request $request){
        //Se guarda el nombre original del archivo
        $fileName = $request->file->getClientOriginalName();

        // Si el archivo ya existe no se puede  subir
        if(Storage::disk('documentos') ->exists($request->department.'/'.$fileName)){
            $path="#";
        }else{
            $path = Storage::disk('documentos')->putFileAs($request->department, $request->file, $fileName);
        }

        return $path;
    }

    ///////////////Devuelve la url de un documento, podemos agregar permisos////////////
    public function getFile(Request $request){
        $deps=DB::select("select * from departments where id='".auth()->user()->department."'");
         
        // Verificamos que el usuario que el usuario pertenezca al departamento del cual solicita el archivo
        //Y que el departamento esté habilitado
        if($deps[0]->name==$request->department && $deps[0]->status==1){
            $path=$request->department.'/'.$request->file;
            abort_if(
            !Storage::disk('documentos') ->exists($path),
            404,
            "El archivo no existe"
            );
        return  Storage::disk('documentos')->response($path);
        }
        else{
            //Si es admin puede ingresar a ver cualquier archivo
            if(auth()->user()->type==env('USER_ADMIN')){
                $path=$request->department.'/'.$request->file;
                abort_if(
                !Storage::disk('documentos') ->exists($path),
                404,
                "El archivo no existe"
                );
            return  Storage::disk('documentos')->response($path);
            }
            else{
                //Si el usuario no pertenece al departamento del cual solicita el archivo entonces lo retorna al home
            return abort_if(true,
                404,
                "El archivo no existe"
                );
            }
        }
    }

    ///////////////función para eliminar archivos del servidor
    public function deleteFile(Request $request){
        //Si es admin puede eliminar archivos
        if(auth()->user()->type==env('USER_ADMIN')){
            $path=$request->department.'/'.$request->file;
            abort_if(
            !Storage::disk('documentos') ->exists($path),
            404,
            "El archivo no existe"
            );
            Storage::disk('documentos')->delete($path);
        return  'Archivo eliminado';
        }
        else{
            //Si el usuario no pertenece al departamento del cual solicita el archivo entonces lo retorna al home
        return 'Error al eliminar archivo';
        }
    }
}