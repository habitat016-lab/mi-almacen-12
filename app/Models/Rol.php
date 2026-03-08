<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    
    protected $fillable = [
        'cat_puesto_id',
        'observaciones',
        'permisos',
    ];

    protected $casts = [
        'permisos' => 'array',
    ];

    public function catpuesto()
    {
        return $this->belongsTo(catpuesto::class);
    }
    
    // Accessor para mostrar el nombre del puesto
    public function getNombrePuestoAttribute()
    {
        if ($this->puesto && $this->puesto->catPuesto) {
            return $this->puesto->catPuesto->nombre_puesto;
        }
        return 'Puesto #' . $this->puesto_id;
    }
    
    // Verificar si tiene permiso para un modelo y acción
    public function tienePermiso($modelo, $accion)
    {
        $permisos = $this->permisos ?? [];
        return isset($permisos[$modelo]) && in_array($accion, $permisos[$modelo]);
    }
}
