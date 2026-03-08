<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Ruta para listar empleados en la página pública
Route::get('/empleados', [EmpleadoController::class, 'index']);

// Ruta para ver detalle de un empleado (opcional, si quieres después)
// Route::get('/empleados/{id}', [EmpleadoController::class, 'show']);

