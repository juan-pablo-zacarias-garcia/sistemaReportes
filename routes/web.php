<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\Admin\usuariosController;
use App\Http\Controllers\Usuarios\usuariosComunController;

use App\Http\Controllers\Api\apiController;
use Illuminate\Http\Request;

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

Route::get('/home', [mainController::class, 'home'])->middleware(['auth', 'verified'])->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
});

/////////////////////////////////////rutas de usaurios comunes///////////////////////////////////////////

Route::get('/tablas', function () {
    return view('usuarios.tablas');
})->middleware(['auth', 'verified'])->name('tablas');

//Retorna la tabla horizontal
Route::get('/tablaHorizontal',[usuariosComunController::class, 'tablaHorizontal'])->middleware(['auth', 'verified'])->name('tablaHorizontal');
//retorna la tabla de costos por hectarea
Route::get('/tablaCostoXHa',[usuariosComunController::class, 'tablaCostoXHa'])->middleware(['auth', 'verified'])->name('tablaCostoXHa');




/////////////////////////////////////rutas de admin///////////////////////////////////////////

//Retorna la vista de la tabla de usuarios
Route::get('/viewUsuarios',[usuariosController::class, 'viewUsuarios'])->middleware(['auth', 'verified'])->name('viewUsuarios');
//Insertar usuario
Route::post('/registerUser', [usuariosController::class, 'registerUser'])->middleware(['auth', 'verified'])->name('registerUser');
//Actualizar usuario
Route::post('/updateUser', [usuariosController::class, 'updateUser'])->middleware(['auth', 'verified'])->name('updateUser');
//Eliminar usuario
Route::get('/deleteUser/{id}', [usuariosController::class, 'deleteUser'])->middleware(['auth', 'verified']);

//Formulario de registro de usuarios para llamarlo con jquery
Route::get('/FormNewUser',[usuariosController::class, 'FormNewUser'])->middleware(['auth', 'verified'])->name('FormNewUser');
//Formulario de editar usuarios para llamarlo con jquery
Route::get('/FormEditUser/{id}',[usuariosController::class, 'FormEditUser'])->middleware(['auth', 'verified'])->name('FormEditUser');
//Retorna la tabla de usuarios
Route::get('/tablaUsuarios',[usuariosController::class, 'tablaUsuarios'])->middleware(['auth', 'verified'])->name('tablaUsuarios');


//Rutas de la API
//Usuarios comunes
//Ruta para DataTable
Route::get('/datosTablas', [apiController::class,'getTablasJSON'])->middleware(['auth', 'verified'])->name('datosTablas');

//Admin
//Ruta para DataTable usuarios
Route::get('/datosUsuarios', [apiController::class,'getUsersJSON'])->middleware(['auth', 'verified'])->name('datosUsuarios');




require __DIR__.'/auth.php';
