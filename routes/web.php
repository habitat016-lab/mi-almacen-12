<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CredencialLoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeePhotoController;

// ========== RUTA RAÍZ REDIRIGE AL LOGIN ==========
Route::get('/', function () {
    return redirect('/login');
});

// ========== RUTAS DE AUTENTICACIÓN ==========
Route::get('/login', [CredencialLoginController::class, 
'showLoginForm'])->name('login');
Route::post('/login', [CredencialLoginController::class, 'login']);
Route::post('/logout', [CredencialLoginController::class, 
'logout'])->name('logout');

// ========== RUTAS DEL MÓDULO DE ROLES ==========
Route::resource('roles', RoleController::class);

// ========== RUTAS PARA GESTIÓN DE FOTOS DE EMPLEADOS ==========
Route::prefix('employees')->name('employees.')->group(function () {
    // Formulario para editar foto
    Route::get('{employee}/photo/edit', [EmployeePhotoController::class, 
'edit'])
        ->name('photo.edit');
    
    // Actualizar foto (subir nueva)
    Route::put('{employee}/photo', [EmployeePhotoController::class, 
'update'])
        ->name('photo.update');
    
    // Eliminar foto
    Route::delete('{employee}/photo', [EmployeePhotoController::class, 
'destroy'])
        ->name('photo.destroy');
});

// ========== RUTA DE PRUEBA (OPCIONAL) ==========
Route::get('/test-permisos', function () {
    return view('filament.forms.components.tabla-permisos', [
        'getState' => fn() => [],
    ]);
});
