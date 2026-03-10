<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatPuesto extends Model
{
    protected $table = 'cat_puestos';

    protected $fillable = [
        'nombre_puesto',
        'descripcion',
        'permisos',
        'activo',
    ];

    protected $casts = [
        'permisos' => 'array',
        'activo' => 'boolean',
    ];

    /**
     * Relación con la tabla puestos (asignaciones)
     */
    public function puestos(): HasMany
    {
        return $this->hasMany(Puesto::class, 'cat_puesto_id');
    }

    /**
     * Relación con la tabla roles
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Rol::class, 'cat_puesto_id');
    }

    /**
     * Verifica si el puesto tiene un permiso específico
     */
    public function tienePermiso(string $modelo, string $accion): bool
    {
        $permisos = $this->permisos ?? [];
        
        // Si es admin (todos los permisos activos)
        $esAdmin = true;
        foreach ($permisos as $modulo => $acciones) {
            foreach (['view', 'create', 'update', 'delete'] as $act) {
                if (!($acciones[$act] ?? false)) {
                    $esAdmin = false;
                    break 2;
                }
            }
        }
        
        if ($esAdmin) {
            return true;
        }
        
        return $permisos[$modelo][$accion] ?? false;
    }

    /**
     * Obtiene el nivel de permisos del puesto
     */
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