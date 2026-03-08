<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    
    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'curp',
        'fecha_nacimiento',
        'telefono',
        'puesto_id',
    ];

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }
}
