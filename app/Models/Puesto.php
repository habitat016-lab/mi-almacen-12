<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Puesto extends Model
{
    protected $table = 'puestos';
    
    protected $fillable = [
        'numero_empleado',
        'employee_id',
        'cat_puesto_id',
        'id_gerencia',
        'cat_departamento_id',
        'id_area',
        'fecha_ingreso',
        'nss',
        'motivo_id',
        'activo',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'activo' => 'boolean',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function catPuesto(): BelongsTo
    {
        return $this->belongsTo(CatPuesto::class, 'cat_puesto_id');
    }

    public function gerencia(): BelongsTo
    {
        return $this->belongsTo(CatGerencia::class, 'id_gerencia');
    }

    public function catDepartamento(): BelongsTo
    {
        return $this->belongsTo(CatDepartamento::class, 'cat_departamento_id');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(CatArea::class, 'id_area');
    }

    public function motivo(): BelongsTo
    {
        return $this->belongsTo(CatMotivo::class, 'motivo_id');
    }
}