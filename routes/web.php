<?php

use App\Http\Controllers\Admin\departmentsController;
use App\Http\Controllers\Admin\documentsController;
use App\Http\Controllers\Archivos\archivosController;
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

//////////////////////////////////////Archivos///////////////

//retorna la vista de documentos
Route::post('documentos',[archivosController::class, 'documentos'])->middleware(['auth', 'verified'])->name('documentos');

//retorna un documento
Route::get('getFile/{department}/{file}',[archivosController::class, 'getFile'])->middleware(['auth', 'verified'])->name('getFile');


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


//////////////////fin admin/////////////////

//Rutas de la API
//Usuarios comunes
//Ruta para DataTable
Route::get('datosTablas', [apiController::class,'getTablasJSON'])->middleware(['auth', 'verified'])->name('datosTablas');

//Admin
//Ruta para DataTable usuarios
Route::get('datosUsuarios', [apiController::class,'getUsersJSON'])->middleware(['auth', 'verified'])->name('datosUsuarios');




require __DIR__.'/auth.php';
