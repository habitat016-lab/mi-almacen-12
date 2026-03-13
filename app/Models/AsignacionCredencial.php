<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class AsignacionCredencial extends Model
{
    protected $table = 'asignacion_credenciales';

    protected $fillable = [
        'id_empleado',
        'correo_electronico',
        'llave_acceso',
    ];

    protected $hidden = [
        'llave_acceso',
    ];

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
