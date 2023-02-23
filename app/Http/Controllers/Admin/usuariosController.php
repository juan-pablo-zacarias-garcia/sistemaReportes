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
    //Devuelve los usuarios registrados menos el usuario autenticado en la sesion
    public function viewUsuarios(){
        $idUserAuth = auth()->user()->id;
        $users = DataTables::of(User::where('id','!=',$idUserAuth))->results();
        return view('admin.Usuarios',['users'=>$users]);
    }
    public function FormNewUser(){
        return view('admin.recursos.formNewUser');
    }
    public function tablaUsuarios(){
        return view('admin.recursos.tablaUsuarios');
    }

    //Registra un nuevo usuario en la base de datos
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->viewUsuarios();
    }

    public function deleteUser($idUser){
        $user = User::where('id', $idUser);
        $deletedUser=User::where('id',"=", $idUser)->delete();
        if($deletedUser){
            return response()->json(null);
        }else{
            return response()->json(error);
        }
         
    }
}
