<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class departmentsController extends Controller
{
    ///////////////////////vistas///////////////////////
    // retorna la vista principal de departamentos
    public function viewDepartamentos(){
        if(auth()->user()->type==env('USER_ADMIN')){

            return view('admin.Departments');
        }
        else{
            return view("home");
        }
    }

    //retorna la lista de departamentos 
    public function listDepartments(){
        if(auth()->user()->type==env('USER_ADMIN')){
            //Recupera los departamentos de la BD y genera un directorio para cada departamento
            //Si el directorio ya existe, no lo crea
            $departments=DB::select("select * from departments");
            foreach($departments as $department){
                Storage::disk('documentos')->makeDirectory($department->name);
            }
            return view('admin.recursosDepartments.listDepartments', ['departments'=>$departments]);
        }
        else{
            return view("home");
        }   
    }

    ///////////////////////////////Formularios////////////////////
    // Retorna el formulario para un nuevo departamento
    public function FormNewDepartment(){
        if(auth()->user()->type==env('USER_ADMIN')){
            
            return view('admin.recursosDepartments.formNewDepartment');
        }
        else{
            return view("home");
        }   
    }
    // Retorna el formulario para editar un departamento
    public function FormEditDepartment(Request $request){
        if(auth()->user()->type==env('USER_ADMIN')){
            $dept = Department::find($request->id);
            return view('admin.recursosDepartments.formEditDepartment', ['dept'=>$dept]);
        }
        else{
            return view("home");
        }   
    }

    ///////////////////////////////////CRUD Departamentos///////////////////////////////
    
    public function registerDepartment(Request $request)
    {
        if(auth()->user()->type==env('USER_ADMIN')){
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
        if(auth()->user()->type==env('USER_ADMIN')){
            $depa = Department::find($request->id);
            if(isset($request->name)){
                // En lugar de cambiar el nombre del directorio, creamos uno con el nuevo nombre
                // y movemos los archivos al nuevo directorio
                Storage::disk('documentos')->makeDirectory($request->name);
                
                //Devuelve solo los archivos de la carpeta del departamento
                $listaArchivos=Storage::disk('documentos',)->allFiles($depa->name);

                foreach($listaArchivos as $archivo){
                    //divide la ruta del archivo para obtener el directorio y el nombre del archivo
                    $datosRuta= explode("/", $archivo);
                    Storage::disk('documentos')->move($archivo, $request->name.'/'.$datosRuta[1]);
                }


                Storage::disk('documentos')->move($depa->name.'/ejemplo.pdf', $request->name.'/');
                //Actualizamos el nombre del departamento
                $depa->name = $request->name;
            }
            if(isset($request->status)){
                $depa->status = $request->status;
            }
            $depa->save();
            return "Datos actualizados";

        }
        else{
            return view("home");
        }
        
    }


    //Elimina un usuario
    public function deleteDepartment($id){
        if(auth()->user()->type==env('USER_ADMIN')){
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