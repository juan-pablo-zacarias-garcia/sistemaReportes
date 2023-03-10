<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\Admin\usuariosController;
use App\Http\Controllers\Usuarios\usuariosComunController;

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

/////////////////////////////////////rutas de usaurios comunes///////////////////////////////////////////

//Retorna la vista principal de tablas
Route::get('tablas',[usuariosComunController::class, 'tablas'])->middleware(['auth', 'verified'])->name('tablas');
//Retorna la tabla horizontal
Route::get('tablaHorizontal/{anio}',[usuariosComunController::class, 'tablaHorizontal'])->middleware(['auth', 'verified'])->name('tablaHorizontal');
//retorna la tabla de costos por hectarea
Route::get('tablaCostoXHa/{anio}',[usuariosComunController::class, 'tablaCostoXHa'])->middleware(['auth', 'verified'])->name('tablaCostoXHa');
//retorna la tabla de ventas por hectarea
Route::get('tablaVentasXHa/{anio}',[usuariosComunController::class, 'tablaVentasXHa'])->middleware(['auth', 'verified'])->name('tablaVentasXHa');
//retorna la tabla de rendimiento por hectarea
Route::get('tablaRendimientoXHa/{anio}',[usuariosComunController::class, 'tablaRendimientoXHa'])->middleware(['auth', 'verified'])->name('tablaRendimientoXHa');
//retorna la tabla de resultados por cultivo
Route::get('tablaResultadosXCultivo/{anio}',[usuariosComunController::class, 'tablaResultadosXCultivo'])->middleware(['auth', 'verified'])->name('tablaResultadosXCultivo');
//retorna la tabla de agroquímicos por hectarea
Route::get('tablaAgroquimicosXHa/{anio}',[usuariosComunController::class, 'tablaAgroquimicosXHa'])->middleware(['auth', 'verified'])->name('tablaAgroquimicosXHa');
//retorna la tabla de fertilizantes por hectarea
Route::get('tablaFertilizantesXHa/{anio}',[usuariosComunController::class, 'tablaFertilizantesXHa'])->middleware(['auth', 'verified'])->name('tablaFertilizantesXHa');
//retorna la tabla de plantula por hectarea
Route::get('tablaPlantulaXHa/{anio}',[usuariosComunController::class, 'tablaPlantulaXHa'])->middleware(['auth', 'verified'])->name('tablaPlantulaXHa');
//retorna la tabla de detalles
Route::post('detallesTablas',[usuariosComunController::class, 'tablaDetalle'])->middleware(['auth', 'verified'])->name('detallesTablas');

//retorna la vista de documentos
Route::get('documentos',[usuariosComunController::class, 'documentos'])->middleware(['auth', 'verified'])->name('documentos');

//retorna un documento
Route::get('getFile/{path}',[usuariosComunController::class, 'getFile'])->middleware(['auth', 'verified'])->name('getFile');
/////////////////////////////////////rutas de admin///////////////////////////////////////////

//Retorna la vista de la tabla de usuarios
Route::get('viewUsuarios',[usuariosController::class, 'viewUsuarios'])->middleware(['auth', 'verified'])->name('viewUsuarios');
//Insertar usuario
Route::post('registerUser', [usuariosController::class, 'registerUser'])->middleware(['auth', 'verified'])->name('registerUser');
//Actualizar usuario
Route::post('updateUser', [usuariosController::class, 'updateUser'])->middleware(['auth', 'verified'])->name('updateUser');
//Eliminar usuario
Route::get('deleteUser/{id}', [usuariosController::class, 'deleteUser'])->middleware(['auth', 'verified']);

//Formulario de registro de usuarios para llamarlo con jquery
Route::get('FormNewUser',[usuariosController::class, 'FormNewUser'])->middleware(['auth', 'verified'])->name('FormNewUser');
//Formulario de editar usuarios para llamarlo con jquery
Route::get('FormEditUser/{id}',[usuariosController::class, 'FormEditUser'])->middleware(['auth', 'verified'])->name('FormEditUser');
//Retorna la tabla de usuarios
Route::get('tablaUsuarios',[usuariosController::class, 'tablaUsuarios'])->middleware(['auth', 'verified'])->name('tablaUsuarios');


//Rutas de la API
//Usuarios comunes
//Ruta para DataTable
Route::get('datosTablas', [apiController::class,'getTablasJSON'])->middleware(['auth', 'verified'])->name('datosTablas');

//Admin
//Ruta para DataTable usuarios
Route::get('datosUsuarios', [apiController::class,'getUsersJSON'])->middleware(['auth', 'verified'])->name('datosUsuarios');




require __DIR__.'/auth.php';
