<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class usuariosController extends Controller
{
    //
    public function viewUsuarios(){
        $users = DataTables::of(User::all())->results();
        return view('admin.recursos.tablaUsuarios',['users'=>$users]);
    }
}
