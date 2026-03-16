<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'telefono',
        'rfc',
        'curp',
        'foto', // ← NUEVO CAMPO PARA LA FOTO
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Relación con la tabla puestos (asignaciones de puesto)
     */
    public function puestos(): HasMany
    {
        return $this->hasMany(Puesto::class, 'employee_id');
    }

    /**
     * Accessor para obtener el nombre completo del empleado
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim($this->nombres . ' ' . $this->apellido_paterno . ' ' . 
$this->apellido_materno);
    }

    /**
     * Accessor para obtener la URL de la foto
     */
    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
