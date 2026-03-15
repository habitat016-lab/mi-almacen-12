<?php

use Illuminate\Support\Facades\Route;

// Ruta para obtener los datos del usuario actual
Route::middleware('auth')->get('/usuario-actual', function () {
    $user = auth()->user();
    
    $nombre = 'Usuario';
    $puesto = 'Sin puesto asignado';
    
    if ($user && $user->empleado) {
        $empleado = $user->empleado;
        $nombre = trim($empleado->nombres . ' ' . 
$empleado->apellido_paterno . ' ' . $empleado->apellido_materno);
        
        $ultimoPuesto = $empleado->puestos()->latest()->first();
        $puesto = $ultimoPuesto?->catPuesto?->nombre_puesto ?? 'Sin puesto 
asignado';
    }
    
    return response()->json([
        'nombre' => $nombre,
        'puesto' => $puesto
    ]);
});
