<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatDepartamento extends Model
{
    public $timestamps = false;
    
    protected $table = 'cat_departamentos';
    
    protected $fillable = [
        'nombre_departamento',
        'descripcion',
        'activo',
    ];

    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'cat_departamento_id');
    }
}
