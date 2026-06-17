<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EntregaController;

Route::resource('menu-items', MenuItemController::class);

Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index']);
    Route::get('/ventas', [ReportController::class, 'ventas']);
    Route::get('/inventario', [ReportController::class, 'inventario']);
    Route::get('/pedidos', [ReportController::class, 'pedidos']);
    Route::get('/tiempos', [ReportController::class, 'tiempos']);
});

Route::prefix('entregas')->name('entregas.')->group(function () {
    Route::get('/', [EntregaController::class, 'index'])->name('index');
    Route::get('/{id}', [EntregaController::class, 'show'])->name('show');
    Route::post('/{id}/en-ruta', [EntregaController::class, 'enRuta'])->name('enRuta');
    Route::post('/{id}/confirmar', [EntregaController::class, 'confirmar'])->name('confirmar');
});
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
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
