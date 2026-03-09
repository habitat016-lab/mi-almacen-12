<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    // Relación con Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Relación con CatPuesto
    public function catPuesto()
    {
        return $this->belongsTo(CatPuesto::class, 'cat_puesto_id');
    }

    // Relación con CatDepartamento
    public function catDepartamento()
    {
        return $this->belongsTo(CatDepartamento::class, 'cat_departamento_id');
    }

    // Relación con CatArea
    public function area()
    {
        return $this->belongsTo(CatArea::class, 'id_area');
    }

    // Relación con CatGerencia
    public function gerencia()
    {
        return $this->belongsTo(CatGerencia::class, 'id_gerencia');
    }

    // Relación con CatMotivo
    public function motivo()
    {
        return $this->belongsTo(CatMotivo::class, 'motivo_id');
    }
}