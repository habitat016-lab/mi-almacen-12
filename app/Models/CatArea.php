<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatArea extends Model
{
    protected $table = 'cat_areas';
    
    protected $fillable = [
        'nombre_area',
        'descripcion',
    ];

    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'id_area');
    }
}