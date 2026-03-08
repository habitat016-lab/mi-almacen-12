<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatPuesto extends Model
{
    protected $table = 'cat_puestos';
    
    protected $fillable = [
        'nombre_puesto',
        'descripcion',
        'activo',
    ];

    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'cat_puesto_id');
    }
}
