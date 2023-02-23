<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\Admin\usuariosController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [mainController::class, 'home'])->middleware(['auth', 'verified'])->name('home');

Route::get('/tablas', function () {
    return view('usuarios.tablas');
})->middleware(['auth', 'verified'])->name('tablas');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
});

//rutas de admin

//Retorna la vista de la tabla de usuarios
Route::get('/viewUsuarios',[usuariosController::class, 'viewUsuarios'])->middleware(['auth', 'verified'])->name('viewUsuarios');
//Insertar usuario
Route::post('/registerUser', [usuariosController::class, 'registerUser'])->middleware(['auth', 'verified'])->name('registerUser');
//Eliminar usuario
Route::get('/deleteUser/{id}', [usuariosController::class, 'deleteUser'])->middleware(['auth', 'verified']);

//Formulario de registro de usuarios para llamarlo con jquery
Route::get('/FormNewUser',[usuariosController::class, 'FormNewUser'])->middleware(['auth', 'verified'])->name('FormNewUser');
//Retorna la tabla de usuarios
Route::get('/tablaUsuarios',[usuariosController::class, 'tablaUsuarios'])->middleware(['auth', 'verified'])->name('tablaUsuarios');

require __DIR__.'/auth.php';
