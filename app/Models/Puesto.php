<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = 'puestos';
    
    protected $fillable = [
        'numero_empleado',
        'id_gerencia',
        'id_area',
        'employee_id',
        'cat_puesto_id',
        'cat_departamento_id',
        'rol_id',
        'fecha_ingreso',
        'nss',
        'area',
        'gerencia',
        'motivo',
        'activo',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function catPuesto()
    {
        return $this->belongsTo(CatPuesto::class);
    }

    // 🔥 ESTA ES LA RELACIÓN QUE FALTA
    public function catDepartamento()
    {
        return $this->belongsTo(CatDepartamento::class);
    }

    public function rol()
    {
        return $this->hasOne(Rol::class, 'puesto_id');
    }
    
    public function area()
    {
        return $this->belongsTo(CatArea::class, 'id_area');
    }

    public function gerencia()
{
    return $this->belongsTo(CatGerencia::class, 'id_gerencia');
}

}