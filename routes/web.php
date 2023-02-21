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
    return view('welcome');
});

Route::get('/home', [mainController::class, 'home'])->middleware(['auth', 'verified'])->name('home');

Route::get('/tablas', function () {
    return view('usuarios.recursos.tablas');
})->middleware(['auth', 'verified'])->name('tablas');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//rutas de admin
Route::get('/viewUsuarios',[usuariosController::class, 'viewUsuarios'])->middleware(['auth', 'verified'])->name('viewUsuarios');

require __DIR__.'/auth.php';
