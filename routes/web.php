<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CredencialLoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-matriz', function () {
    return view('test-matriz');
});

Route::get('/login', [CredencialLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CredencialLoginController::class, 'login']);
Route::post('/logout', [CredencialLoginController::class, 'logout'])->name('logout');

Route::any('/register', function () {
    abort(403, 'El registro de usuarios está deshabilitado');
});

Route::get('/admin/login', function () {
    return redirect('/login');
});

// Si no tienes rutas protegidas, elimina este bloque
// Route::middleware(['auth.credenciales'])->group(function () {
//     // Aquí van las rutas protegidas
// });