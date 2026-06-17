<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LogisticaController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders-history', [OrderHistoryController::class, 'index']);
Route::put('/orders/{order}/status', [OrderHistoryController::class, 'updateStatus']);


// 👇 INVENTARIO FUERA DEL AUTH
Route::resource('inventario', InventarioController::class);
Route::post('/cierre-ventas', [InventarioController::class, 'cierreVentas']);


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Logística
    Route::get('/logistica', [
        LogisticaController::class,
        'index'
    ])->name('logistica.index');

    Route::post('/logistica/asignar/{id}', [
        LogisticaController::class,
        'asignar'
    ])->name('logistica.asignar');

    Route::put('/logistica/estado/{id}', [
        LogisticaController::class,
        'cambiarEstado'
    ]);
});

require __DIR__ . '/auth.php';
