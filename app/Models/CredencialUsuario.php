<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CredencialUsuario extends Model
{
    protected $table = 'asignacion_credenciales';

    protected $fillable = [
        'id_empleado',
        'correo_electronico',
        'llave_acceso',
    ];

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id_empleado');
    }
}
