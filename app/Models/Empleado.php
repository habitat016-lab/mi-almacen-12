<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'employees'; // Nombre real de la tabla en BD

    protected $fillable = [
        'numero_empleado',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'telefono',
        'fecha_nacimiento',
        'fecha_ingreso',
        'activo',
        'foto'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date'
    ];

    // Relación con credenciales
    public function credenciales()
    {
        return $this->hasMany(AsignacionCredencial::class, 'id_empleado');
    }

    // Accesor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . 
$this->apellido_materno);
    }
}
