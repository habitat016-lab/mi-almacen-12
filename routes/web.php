<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CredencialLoginController;
use App\Http\Controllers\RoleController;

// ========== RUTAS DE AUTENTICACIÓN ==========
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/test-matriz', function () {
    return view('test-matriz');
});

Route::get('/login', [CredencialLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CredencialLoginController::class, 'login']);
Route::post('/logout', [CredencialLoginController::class, 'logout'])->name('logout');

Route::any('/register', function () {
    abort(403);
});

Route::get('/admin/login', function () {
    return redirect('/login');
});

// ========== RUTA DE PRUEBA PARA LA MATRIZ ==========
Route::get('/test-permisos', function () {
    return view('filament.forms.components.tabla-permisos', [
        'getState' => fn() => [],
    ]);
});

// ========== RUTAS DEL MÓDULO DE ROLES ==========
Route::resource('roles', RoleController::class);
