<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class UserInfoHelper
{
    /**
     * Obtiene la información del usuario actual para el recuadro verde
     */
    public static function getCurrentUserInfo()
    {
        if (!Auth::check()) {
            return [
                'nombre' => 'Invitado',
                'email' => '',
                'foto_url' => null,
                'inicial' => '?',
                'rol' => 'Sin sesión',
                'empleado_id' => null
            ];
        }

        $credencial = Auth::user(); // Es una instancia de 
AsignacionCredencial
        $empleado = $credencial ? $credencial->empleado : null;

        if (!$empleado) {
            return [
                'nombre' => $credencial->correo_electronico ?? 'Usuario',
                'email' => $credencial->correo_electronico ?? '',
                'foto_url' => null,
                'inicial' => 
strtoupper(substr($credencial->correo_electronico ?? 'U', 0, 1)),
                'rol' => 'Sin empleado',
                'empleado_id' => null
            ];
        }

        // Obtener el rol a través de la relación (pendiente de 
implementar)
        $rolNombre = 'Sin rol';

        return [
            'nombre' => $empleado->nombre_completo ?? $empleado->nombres,
            'email' => $credencial->correo_electronico,
            'foto_url' => $empleado->foto_url,
            'inicial' => strtoupper(substr($empleado->nombres, 0, 1)),
            'rol' => $rolNombre,
            'empleado_id' => $empleado->id
        ];
    }

    /**
     * Verifica si el usuario tiene foto
     */
    public static function hasFoto()
    {
        if (!Auth::check()) {
            return false;
        }

        $empleado = Auth::user()->empleado;
        return $empleado && !empty($empleado->foto);
    }
}
