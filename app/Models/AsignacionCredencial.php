<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignacionCredencial extends Model
{
    protected $table = 'asignacion_credenciales';

    protected $fillable = [
        'id_empleado',
        'id_puesto',
        'id_asignacion_puesto',
        'correo_electronico',
        'llave_acceso',
    ];

    // Relación con empleados (para nombre completo)
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id_empleado');
    }

    // Relación con catálogo de puestos (para nombre del puesto)
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(CatPuesto::class, 'id_puesto');
    }

    // Relación con tabla puestos (para número de empleado)
    public function asignacionPuesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class, 'id_asignacion_puesto');
    }
}