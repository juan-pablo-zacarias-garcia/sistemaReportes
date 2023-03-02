<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rules\Password;

class usuariosController extends Controller
{
    
    //////////////////////////////////servicios web////////////////////////////////
    //Devuelve los usuarios registrados menos el usuario autenticado en la sesion
    public function viewUsuarios(){
        if(auth()->user()->type==0){
            $idUserAuth = auth()->user()->id;
            $users = DataTables::of(User::where('id','!=',$idUserAuth))->results();
            return view('admin.Usuarios',['users'=>$users]);
        }
        else{
            return view("home");
        }
        
    }


    //////////////////////////////////Formularios////////////////////////////////
    public function FormNewUser(){
        if(auth()->user()->type==0){
            return view('admin.recursos.formNewUser');
        }
        else{
            return view("home");
        }
    }
    public function FormEditUser($idUser){
        if(auth()->user()->type==0){
            $user = User::where('id','=',$idUser);
            return view('admin.recursos.formEditUser',['user'=>$user]); 
        }
        else{
            return view("home");
        }        
    }

    //////////////////////////////////Vistas////////////////////////////////
    public function tablaUsuarios(){
        if(auth()->user()->type==0){
            return view('admin.recursos.tablaUsuarios');
        }
        else{
            return view("home");
        }
    }


    //////////////////////////////////CRUD Usuarios////////////////////////////////
    //Registra un nuevo usuario en la base de datos
    public function registerUser(Request $request)
    {
        if(auth()->user()->type==0){
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            return $this->viewUsuarios();
        }
        else{
            return view("home");
        }
        
    }

    //Edita usuario en la base de datos
    public function updateUser(Request $request)
    {
        if(auth()->user()->type==0){
            $user = User::find($request->id);
            if(isset($request->name)){
                $user->name = $request->name;
            }
            if(isset($request->email)){
                $user->email = $request->email;
            }
            if(isset($request->password)){
                $user->password = Hash::make($request->password);
            }
            if(isset($request->type)){
                $user->type = $request->type;
            }
            
            $user->save();

            return $request;

        }
        else{
            return view("home");
        }
        
    }


    //Elimina un usuario
    public function deleteUser($idUser){
        if(auth()->user()->type==0){
            $deletedUser=User::where('id',"=", $idUser)->delete();
            if($deletedUser){
                return true;
            }else{
                return false;
            }
        }
        else{
            return view("home");
        }
        
         
    }
}