<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\mailController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rules\Password;

class usuariosController extends Controller
{
    
    //////////////////////////////////servicios web////////////////////////////////
    //Devuelve los usuarios registrados menos el usuario autenticado en la sesion
    public function viewUsuarios(){
        if(auth()->user()->type==env('USER_ADMIN')){
            //$users = DataTables::of(User::where('id','!=',$idUserAuth))->results();
            return view('admin.Usuarios'); 
        }
        else{
            return view("home");
        }
        
    }


    //////////////////////////////////Formularios////////////////////////////////
    public function FormNewUser(){
        if(auth()->user()->type==env('USER_ADMIN')){
            $departments=DB::select("select * from departments");
            return view('admin.recursosUsuarios.formNewUser', ['departments'=>$departments]);
        }
        else{
            return view("home");
        }
    }
    public function FormEditUser($idUser){
        if(auth()->user()->type==env('USER_ADMIN')){
            $user = User::where('id','=',$idUser);
            $departments=DB::select("select * from departments");
            $user_types = DB::select("select * from users_type");
            return view('admin.recursosUsuarios.formEditUser',['user'=>$user,'departments'=>$departments, 'users_type'=>$user_types ]); 
        }
        else{
            return view("home");
        }        
    }

    //////////////////////////////////Vistas////////////////////////////////
    public function tablaUsuarios(){
        if(auth()->user()->type==env('USER_ADMIN')){
            $idUserAuth = auth()->user()->id;
            $users = User::where('id','!=',$idUserAuth)->get();
            return view('admin.recursosUsuarios.tablaUsuarios',['users'=>$users]);
        }
        else{
            return view("home");
        }
    }


    //////////////////////////////////CRUD Usuarios////////////////////////////////
    //Registra un nuevo usuario en la base de datos
    public function registerUser(Request $request)
    {
        if(auth()->user()->type==env('USER_ADMIN')){

            $password = $this->generaPassword();
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            ]);
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'department' => '0',
                'password' => Hash::make($password),
            ]);
            
            $mail = new mailController;
            $mail->sendMailRegister($request->email, $password);

            return true;
        }
        else{
            return view("home");
        }
        
    }

    //Edita usuario en la base de datos
    public function updateUser(Request $request)
    {
        if(auth()->user()->type==env('USER_ADMIN')){
            $user = User::find($request->id);
            if(isset($request->name)){
                $user->name = $request->name;
            }
            if(isset($request->email)){
                $user->email = $request->email;
            }
            if(isset($request->passwordreset)){
                if($request->passwordreset=='reset'){
                    $password = $this->generaPassword();
                    $user->password = Hash::make($password);
                    $mail = new mailController;
                    $mail->sendMailResetPassword($request->email, $password);
                }
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
        if(auth()->user()->type==env('USER_ADMIN')){
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
    function generaPassword(){
        $string = "";
        $possible = "*0+123456789bcdfg++1hj2k6mn3*p2*q8r9s0t0v6w7x2y*3z2";
        $i = 0;
        while ($i < 8) {
            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
            $string .= $char;
            $i++;
        }
        return $string;
    }
}