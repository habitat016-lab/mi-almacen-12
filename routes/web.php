<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CredencialLoginController;

// ========== RUTAS PÚBLICAS ==========
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-matriz', function () {
    return view('test-matriz');
});

// ========== RUTAS DE AUTENTICACIÓN ==========
Route::get('/login', [CredencialLoginController::class, 
'showLoginForm'])->name('login');
Route::post('/login', [CredencialLoginController::class, 'login']);
Route::post('/logout', [CredencialLoginController::class, 
'logout'])->name('logout');

// Bloquear registro público
Route::any('/register', function () {
    abort(403, 'El registro de usuarios está deshabilitado');
});

// Redirigir login de Filament al nuestro
Route::get('/admin/login', function () {
    return redirect('/login');
});
