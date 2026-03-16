<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotoController;

Route::middleware('auth')->group(function () {
    Route::post('/foto/subir', [FotoController::class, 'subir']);
    Route::delete('/foto/eliminar', [FotoController::class, 'eliminar']);
});
