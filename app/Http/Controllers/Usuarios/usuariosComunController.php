<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class usuariosComunController extends Controller
{
    //////////////////////////////////Vistas////////////////////////////////
    //Retorna la tabla horizontal
    public function tablaHorizontal(){
        if(!auth()->user()->isAdmin){
            return view('usuarios.recursos.horizontal');
        }
        else{
            return view("home");
        }
    }
    

    //////////////////////////////////servicios web////////////////////////////////
    
    //devuelve la tabla Costo x Hectarea
    


}
