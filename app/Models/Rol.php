<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rol extends Model
{
    protected $fillable = [
        'cat_puesto_id',
        'observaciones',
        'permisos',
    ];

    protected $casts = [
        'permisos' => 'array',
    ];

    public function catPuesto(): BelongsTo
    {
        return $this->belongsTo(CatPuesto::class, 'cat_puesto_id');
    }

    public function getNivelPermisosAttribute(): string
    {
        $permisos = $this->permisos ?? [];

        if (empty($permisos)) {
            return 'sin_permisos';
        }

        $esAdmin = true;
        $todosView = true;

        foreach ($permisos as $modulo => $acciones) {
            foreach (['view', 'create', 'update', 'delete'] as $accion) {
                if (!($acciones[$accion] ?? false)) {
                    $esAdmin = false;
                }
            }
            if (!($acciones['view'] ?? false)) {
                $todosView = false;
            }
        }

        if ($esAdmin) {
            return 'admin';
        }

        if ($todosView) {
            return 'consultor';
        }

        return 'personalizado';
    }
}
