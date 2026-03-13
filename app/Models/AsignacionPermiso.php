<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignacionPermiso extends Model
{
    protected $table = 'asignacion_permisos';

    protected $fillable = [
        'cat_puesto_id',
        'role_id',
        'observaciones',
    ];

    public function catPuesto(): BelongsTo
    {
        return $this->belongsTo(CatPuesto::class, 'cat_puesto_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}