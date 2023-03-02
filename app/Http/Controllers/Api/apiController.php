<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class apiController extends Controller
{

    //Retorna un JSON con los datos de la bd en la propiedad data
    public function getTablasJSON(){
        if(auth()->user()->type==1){
            $jsonString= datatables()->query(DB::table('tablas')->where('CODIGO1','!=', '0'))->toJson();
            return $jsonString;
        }else{
            return view("home");
        }
        
    }
    //retorna un JSON con los usuarios de la bd
    public function getUsersJSON(){
        if(auth()->user()->type==0){
            $id = Auth::user()->id;
            $jsonString= DataTables::of(User::where("id","!=",$id))->toJson();
            return $jsonString;
        }else{
            return view("home");
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}