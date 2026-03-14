<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class AsignacionCredencial extends Authenticatable
{
    use Notifiable;

    protected $table = 'asignacion_credenciales';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_empleado',
        'correo_electronico',
        'llave_acceso',
    ];

    protected $hidden = [
        'llave_acceso',
    ];

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthPassword()
    {
        return $this->llave_acceso;
    }

    public function getNameAttribute()
    {
        if ($this->empleado) {
            return trim($this->empleado->nombres . ' ' . 
$this->empleado->apellido_paterno . ' ' . 
$this->empleado->apellido_materno);
        }

        return 'Usuario';
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id_empleado');
    }

    public function puestoActual(): HasOneThrough
    {
        return $this->hasOneThrough(
            Puesto::class,
            Employee::class,
            'id',
            'employee_id',
            'id_empleado',
            'id'
        )->latest();
    }
}
