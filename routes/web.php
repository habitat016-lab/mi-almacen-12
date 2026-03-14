<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CredencialLoginController;

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
