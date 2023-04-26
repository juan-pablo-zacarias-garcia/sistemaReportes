<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuarios\tablasController;
use App\Http\Controllers\Usuarios\graficasController;



//Retorna la vista principal de tablas
Route::get('tablas',[tablasController::class, 'tablas'])->middleware(['auth', 'verified'])->name('tablas');
//Retorna la tabla horizontal
Route::post('tablaHorizontal',[tablasController::class, 'tablaHorizontal'])->middleware(['auth', 'verified'])->name('tablaHorizontal');
//retorna la tabla de costos por hectarea
Route::post('tablaCostoXHa',[tablasController::class, 'tablaCostoXHa'])->middleware(['auth', 'verified'])->name('tablaCostoXHa');
//retorna la tabla de ventas por hectarea
Route::post('tablaVentasXHa',[tablasController::class, 'tablaVentasXHa'])->middleware(['auth', 'verified'])->name('tablaVentasXHa');
//retorna la tabla de rendimiento por hectarea
Route::post('tablaRendimientoXHa',[tablasController::class, 'tablaRendimientoXHa'])->middleware(['auth', 'verified'])->name('tablaRendimientoXHa');
//retorna la tabla de resultados por cultivo
Route::post('tablaResultadosXCultivo',[tablasController::class, 'tablaResultadosXCultivo'])->middleware(['auth', 'verified'])->name('tablaResultadosXCultivo');
//retorna la tabla de agroquímicos por hectarea
Route::post('tablaAgroquimicosXHa',[tablasController::class, 'tablaAgroquimicosXHa'])->middleware(['auth', 'verified'])->name('tablaAgroquimicosXHa');
//retorna la tabla de fertilizantes por hectarea
Route::post('tablaFertilizantesXHa',[tablasController::class, 'tablaFertilizantesXHa'])->middleware(['auth', 'verified'])->name('tablaFertilizantesXHa');
//retorna la tabla de plantula por hectarea
Route::post('tablaPlantulaXHa',[tablasController::class, 'tablaPlantulaXHa'])->middleware(['auth', 'verified'])->name('tablaPlantulaXHa');
//retorna la tabla de detalles
Route::post('detallesTablas',[tablasController::class, 'tablaDetalle'])->middleware(['auth', 'verified'])->name('detallesTablas');
//retorna las graficas de los promedio
Route::post('graficas',[graficasController::class, 'graficaPromedios'])->middleware(['auth', 'verified'])->name('graficas');


Route::get('getMeses/{anio}',[tablasController::class, 'getMeses'])->middleware(['auth', 'verified'])->name('getMeses');
Route::post('getSemanas',[tablasController::class, 'getSemanas'])->middleware(['auth', 'verified'])->name('getSemanas');
?>