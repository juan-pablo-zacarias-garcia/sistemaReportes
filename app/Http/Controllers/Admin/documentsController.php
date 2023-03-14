<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class documentsController extends Controller
{
    /////////////////////////vistas///////////////////////
    // retorna la vista principal de documentos
    public function viewDocuments(){
        if(auth()->user()->type==env('USER_ADMIN')){
            return view('admin.Documents');
        }
        else{
            return view("home");
        }
    }
    //retorna la lista de directorios y documentos
    public function listDocuments(){
        if(auth()->user()->type==env('USER_ADMIN')){
            $dirs = Storage::disk('documentos')->directories();

            return view('admin.recursosDocuments.listDocuments',['directories'=>$dirs]);
        }
        else{
            return view("home");
        }
    }
    
}
