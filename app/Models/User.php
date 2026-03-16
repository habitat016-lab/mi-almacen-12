<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'credencial_id',
        'session_token',
        'last_activity',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con credenciales
    public function credencial()
    {
        return $this->belongsTo(Credencial::class);
    }

    // Obtener empleado a través de credencial
    public function empleado()
    {
        return $this->hasOneThrough(
            Empleado::class,
            Credencial::class,
            'id', // Foreign key en credenciales
            'id', // Foreign key en empleados
            'credencial_id', // Local key en users
            'empleado_id' // Local key en credenciales
        );
    }

    // Obtener datos completos para el recuadro verde
    public function getDisplayData()
    {
        if (!$this->credencial || !$this->credencial->empleado) {
            return [
                'nombre' => 'Usuario',
                'email' => '',
                'rol' => 'Sin rol',
                'foto' => null
            ];
        }

        $empleado = $this->credencial->empleado;
        $puestoActual = $empleado->puestoActual();
        $rol = null;

        if ($puestoActual) {
            $asignacionPermiso = $puestoActual->asignacionPermisoActual();
            $rol = $asignacionPermiso ? $asignacionPermiso->role : null;
        }

        return [
            'nombre' => $empleado->nombre_completo ?? 
                       trim($empleado->nombre . ' ' . 
$empleado->apellido_paterno . ' ' . $empleado->apellido_materno),
            'email' => $this->credencial->email,
            'rol' => $rol->nombre ?? 'Sin rol asignado',
            'foto' => $empleado->foto,
            'empleado_id' => $empleado->id
        ];
    }
}
