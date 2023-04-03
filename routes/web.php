<?php

use App\Http\Controllers\Archivos\archivosController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\Api\apiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/////////////////////////////////////rutas para todos los usuarios///////////////////////////////////////////
Route::get('/', function () {
    return view('auth.login');
});

Route::get('home', [mainController::class, 'home'])->middleware(['auth', 'verified'])->name('home');
Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
});
Route::get('error', [mainController::class, 'error'])->name('error');
/////////////////////////////////////rutas de admin///////////////////////////////////////////
require __DIR__.'/routes_admin.php';

/////////////////////////////////////rutas de usaurios comunes///////////////////////////////////////////
require __DIR__.'/routes_user.php';

//////////////////////////////////////Rutas para control de archivos///////////////
//retorna la vista de documentos
Route::post('documentos',[archivosController::class, 'documentos'])->middleware(['auth', 'verified'])->name('documentos');
//retorna un documento
Route::get('getFile/{department}/{file}',[archivosController::class, 'getFile'])->middleware(['auth', 'verified'])->name('getFile');



///////////////////////////////////////Rutas de la API//////////////////////////////
//Usuarios comunes
//Ruta para DataTable
Route::get('datosTablas', [apiController::class,'getTablasJSON'])->middleware(['auth', 'verified'])->name('datosTablas');

//Admin
//Ruta para DataTable usuarios
Route::get('datosUsuarios', [apiController::class,'getUsersJSON'])->middleware(['auth', 'verified'])->name('datosUsuarios');




require __DIR__.'/auth.php';
