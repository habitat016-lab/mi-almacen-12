<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AsignacionCredencial extends Authenticatable
{
    protected $table = 'asignacion_credenciales';
    
    protected $fillable = [
        'id_empleado',
        'id_puesto',
        'correo_electronico',
        'id_asignacion_puesto',
        'llave_acceso',
    ];

    protected $hidden = [
        'llave_acceso',
    ];

    protected $casts = [
        'llave_acceso' => 'hashed',
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Employee::class, 'id_empleado');
    }

    public function puesto()
    {
        return $this->belongsTo(CatPuesto::class, 'id_puesto');
    }

    public function asignacionPuesto()
    {
        return $this->belongsTo(Puesto::class, 'id_asignacion_puesto');
    }

    // Accessors para UI
    public function getNombreCompletoAttribute()
    {
        if (!$this->empleado) return 'Sin empleado';
        return trim(
            $this->empleado->nombres . ' ' . 
            $this->empleado->apellido_paterno . ' ' . 
            $this->empleado->apellido_materno
        );
    }

    public function getNombrePuestoAttribute()
    {
        return $this->puesto ? $this->puesto->nombre_puesto : 'Sin puesto';
    }

    public function getNumeroEmpleadoAttribute()
    {
        return $this->asignacionPuesto ? $this->asignacionPuesto->numero_empleado : 'Sin asignación';
    }
}