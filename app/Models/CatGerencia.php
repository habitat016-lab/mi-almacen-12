<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatGerencia extends Model
{
    protected $table = 'cat_gerencias';
    
    protected $fillable = [
        'nombre_gerencia',
        'descripcion',
    ];

    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'id_gerencia');
    }
}