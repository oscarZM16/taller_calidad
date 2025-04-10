<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

// Mostrar login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Proteger las rutas de usuarios
Route::middleware('auth')->group(function () {
    Route::resource('users', \App\Http\Controllers\UserController::class);
});
