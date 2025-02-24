<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\RoleMiddleware;

// Rutas de autenticación
Auth::routes();

// Página de inicio (pública)
// Route::get('/', function () {return view('home');
// })->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    
    // Dashboard del usuario
    // Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // Rutas de ventas (crear, almacenar)
    Route::middleware(['auth'])->group(function () {
        Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    });
    
    // Las ventas del usuario
    Route::get('/my-sales', [SaleController::class, 'mySales'])->name('sales.mySales')->middleware('auth');

    // Ver venta específica
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');

    // Comprar una venta
    Route::post('/sales/{sale}/buy', [SaleController::class, 'buy'])->name('sales.buy');

    // Editar, actualizar y eliminar ventas
    Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
    Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
    Route::post('/sales/{sale}/relist', [SaleController::class, 'relist'])->name('sales.relist');

    // Página de inicio para usuarios autenticados
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Rutas de administración (solo accesibles para usuarios con el rol 'admin')
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
