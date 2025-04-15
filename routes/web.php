<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\PrestamoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Ruta raíz: redirige al login (para evitar error 404 en tests)
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔐 Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔒 Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('insumos', InsumoController::class);
    Route::get('/bandeja', [InsumoController::class, 'bandeja'])->name('insumos.bandeja');

Route::middleware(['auth'])->group(function () {
    Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');
    Route::get('/prestamos/create', [PrestamoController::class, 'create'])->name('prestamos.create');
    Route::post('/prestamos', [PrestamoController::class, 'store'])->name('prestamos.store');
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/prestamos', [PrestamoController::class, 'adminIndex'])->name('prestamos.admin');
        Route::post('/admin/prestamos/{prestamo}/estado', [PrestamoController::class, 'cambiarEstado'])->name('prestamos.estado');
});
});
});
