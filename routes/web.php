<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ReportController;

Route::resource('menu-items', MenuItemController::class);

Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index']);
    Route::get('/ventas', [ReportController::class, 'ventas']);
    Route::get('/inventario', [ReportController::class, 'inventario']);
    Route::get('/pedidos', [ReportController::class, 'pedidos']);
    Route::get('/tiempos', [ReportController::class, 'tiempos']);
});