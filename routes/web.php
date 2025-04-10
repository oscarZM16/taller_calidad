<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Ruta raíz: redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔐 Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔒 Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Gestión de usuarios
    Route::resource('users', UserController::class);

    // Gestión de productos
    Route::resource('productos', ProductoController::class);
});