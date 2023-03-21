<?php
use App\Http\Controllers\Admin\departmentsController;
use App\Http\Controllers\Admin\documentsController;
use App\Http\Controllers\Archivos\archivosController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\Admin\usuariosController;
use App\Http\Controllers\Usuarios\usuariosComunController;



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
?>