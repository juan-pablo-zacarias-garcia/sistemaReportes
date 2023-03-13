<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class departmentsController extends Controller
{
    ///////////////////////vistas///////////////////////
    // retorna la vista principal de departamentos
    public function viewDepartamentos(){
        if(auth()->user()->type==1){

            return view('admin.Departments');
        }
        else{
            return view("home");
        }
        
    }

    //retorna la lista de departamentos 
    public function listDepartments(){
        if(auth()->user()->type==1){
            $departments=DB::select("select * from departments");
            return view('admin.recursosDepartments.listDepartments', ['departments'=>$departments]);
        }
        else{
            return view("home");
        }   
    }

    ///////////////////////////////Formularios////////////////////
    // Retorna el formulario para un nuevo departamento
    public function FormNewDepartment(){
        if(auth()->user()->type==1){
            $aux = Department::all();
            return view('admin.recursosDepartments.formNewDepartment',['aux'=>$aux]);
        }
        else{
            return view("home");
        }   
    }
    // Retorna el formulario para editar un departamento
    public function FormEditDepartment(){
        if(auth()->user()->type==1){
            return view('admin.recursosDepartments.formEditDepartment');
        }
        else{
            return view("home");
        }   
    }

    ///////////////////////////////////CRUD Departamentos///////////////////////////////
    
    public function registerDepartment(Request $request)
    {
        if(auth()->user()->type==1){
    
            Department::create([
                'name' => $request->name,
            ]);
    
            return $this->viewDepartamentos();
        }
        else{
            return view("home");
        }
        
    }

    //Edita usuario en la base de datos
    public function updateDepartment(Request $request)
    {
        if(auth()->user()->type==1){
            $depa = Department::find($request->id);
            if(isset($request->name)){
                $depa->name = $request->name;
            }
            $depa->save();
            return $request;

        }
        else{
            return view("home");
        }
        
    }


    //Elimina un usuario
    public function deleteDepartment($id){
        if(auth()->user()->type==1){
            $deleted=Department::where('id',"=", $id)->delete();
            if($deleted){
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