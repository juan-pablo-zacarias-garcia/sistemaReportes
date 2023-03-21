<?php

use App\Http\Controllers\Admin\departmentsController;
use App\Http\Controllers\Admin\documentsController;
use App\Http\Controllers\Archivos\archivosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\usuariosController;


/////////////////////////////////////rutas de admin///////////////////////////////////////////


// Usuarios
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

// Departamentos
//Retorna la vista primcipal de departamentos
Route::get('viewDepartamentos',[departmentsController::class, 'viewDepartamentos'])->middleware(['auth', 'verified'])->name('viewDepartamentos');

//Retorna la lista de departamentos con usuarios
Route::get('listDepartments',[departmentsController::class, 'listDepartments'])->middleware(['auth', 'verified'])->name('listDepartments');
//Formulario de registro de usuarios para llamarlo con jquery
Route::get('FormNewDepartment',[departmentsController::class, 'FormNewDepartment'])->middleware(['auth', 'verified'])->name('FormNewDepartment');
//Formulario de editar usuarios para llamarlo con jquery
Route::get('FormEditDepartment/{id}',[departmentsController::class, 'FormEditDepartment'])->middleware(['auth', 'verified'])->name('FormEditDepartment');


//Insertar departamento
Route::post('registerDepartment', [departmentsController::class, 'registerDepartment'])->middleware(['auth', 'verified'])->name('registerDepartment');
//Actualizar departamento
Route::post('updateDepartment', [departmentsController::class, 'updateDepartment'])->middleware(['auth', 'verified'])->name('updateDepartment');
//Eliminar departamento
Route::get('deleteDepartment/{id}', [departmentsController::class, 'deleteDepartment'])->middleware(['auth', 'verified']);


///Documentos
//Retorna la vista principal de documents
Route::get('viewDocuments',[documentsController::class, 'viewDocuments'])->middleware(['auth', 'verified'])->name('viewDocuments');
//Retorna la lista de directorios y documentos
Route::get('listDocuments',[documentsController::class, 'listDocuments'])->middleware(['auth', 'verified'])->name('listDocuments');
//Carga un documento al servidor
Route::post('uploadFile', [archivosController::class, 'uploadFile'])->middleware(['auth', 'verified'])->name('uploadFile');
//elimina un documento
Route::get('deleteFile/{department}/{file}',[archivosController::class, 'deleteFile'])->middleware(['auth', 'verified'])->name('deleteFile');


?>