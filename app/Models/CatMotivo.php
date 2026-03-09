<?php
// app/Models/CatMotivo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatMotivo extends Model
{
    protected $table = 'cat_motivos';

    protected $fillable = [
        'nombre_motivo',
        'descripcion'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con la tabla puestos
     */
    public function puestos(): HasMany
    {
        return $this->hasMany(Puesto::class, 'motivo_id');
    }
}