<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    
    protected $fillable = [
        'nombre_departamento',
        'descripcion',
        'responsable',
        'activo',
    ];

    // Relación con empleados (opcional, para después)
    public function employees()
    {
        return $this->hasMany(Employee::class, 'departamento_id');
    }
}
