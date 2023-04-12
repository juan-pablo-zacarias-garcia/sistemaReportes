<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuarios\tablasController;
use App\Http\Controllers\Usuarios\graficasController;



//Retorna la vista principal de tablas
Route::get('tablas',[tablasController::class, 'tablas'])->middleware(['auth', 'verified'])->name('tablas');
//Retorna la tabla horizontal
Route::get('tablaHorizontal/{anio}',[tablasController::class, 'tablaHorizontal'])->middleware(['auth', 'verified'])->name('tablaHorizontal');
//retorna la tabla de costos por hectarea
Route::get('tablaCostoXHa/{anio}',[tablasController::class, 'tablaCostoXHa'])->middleware(['auth', 'verified'])->name('tablaCostoXHa');
//retorna la tabla de ventas por hectarea
Route::get('tablaVentasXHa/{anio}',[tablasController::class, 'tablaVentasXHa'])->middleware(['auth', 'verified'])->name('tablaVentasXHa');
//retorna la tabla de rendimiento por hectarea
Route::get('tablaRendimientoXHa/{anio}',[tablasController::class, 'tablaRendimientoXHa'])->middleware(['auth', 'verified'])->name('tablaRendimientoXHa');
//retorna la tabla de resultados por cultivo
Route::get('tablaResultadosXCultivo/{anio}',[tablasController::class, 'tablaResultadosXCultivo'])->middleware(['auth', 'verified'])->name('tablaResultadosXCultivo');
//retorna la tabla de agroquímicos por hectarea
Route::get('tablaAgroquimicosXHa/{anio}',[tablasController::class, 'tablaAgroquimicosXHa'])->middleware(['auth', 'verified'])->name('tablaAgroquimicosXHa');
//retorna la tabla de fertilizantes por hectarea
Route::get('tablaFertilizantesXHa/{anio}',[tablasController::class, 'tablaFertilizantesXHa'])->middleware(['auth', 'verified'])->name('tablaFertilizantesXHa');
//retorna la tabla de plantula por hectarea
Route::get('tablaPlantulaXHa/{anio}',[tablasController::class, 'tablaPlantulaXHa'])->middleware(['auth', 'verified'])->name('tablaPlantulaXHa');
//retorna la tabla de detalles
Route::post('detallesTablas',[tablasController::class, 'tablaDetalle'])->middleware(['auth', 'verified'])->name('detallesTablas');
//retorna las graficas de los promedio
Route::get('graficas/{anio}',[graficasController::class, 'graficaPromedios'])->middleware(['auth', 'verified'])->name('graficas');
?>