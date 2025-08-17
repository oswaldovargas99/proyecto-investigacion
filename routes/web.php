<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Dashboard dinámico (redirige según rol)
Route::get('/dashboard', RedirectController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Perfil de usuario (editar, actualizar, eliminar)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Usuario (rol 1)
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/usuario', fn() => view('usuario.dashboard'))
        ->name('usuario.dashboard');
});

// Coordinador (rol 2)
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/coordinador', fn() => view('coordinador.dashboard'))
        ->name('coordinador.dashboard');
});

// Administrador (rol 3)
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/admin', fn() => view('administrador.dashboard'))
        ->name('admin.dashboard');
});

// Autenticación (Breeze/Jetstream)
require __DIR__.'/auth.php';



