<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    
    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'curp',
        'foto',
        'fecha_nacimiento',
        'telefono'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    protected $appends = ['foto_url', 'nombre_completo'];

    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return null;
        }

        // Forzar puerto 8000 para desarrollo local
        $baseUrl = 'http://localhost:8000';

        Log::info('Procesando foto:', ['foto' => $this->foto]);

        // Caso 1: La foto ya tiene ruta completa (empleados/xxxx.jpg)
        if (strpos($this->foto, 'empleados/') === 0) {
            return $baseUrl . '/storage/' . $this->foto;
        }

        // Caso 2: La foto ya tiene ruta completa (fotos/xxxx.jpg)
        if (strpos($this->foto, 'fotos/') === 0) {
            return $baseUrl . '/storage/' . $this->foto;
        }

        if (file_exists(storage_path('app/public/empleados/' . 
        $this->foto))) {
            return $baseUrl . '/storage/empleados/' . $this->foto;
        }
        
        if (file_exists(storage_path('app/public/fotos/' . $this->foto)))
            {
            return $baseUrl . '/storage/fotos/' . $this->foto;
        }
        return $baseUrl . '/storage/fotos/' . $this->foto;
    }
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombres . ' ' . $this->apellido_paterno . ' ' . 
$this->apellido_materno);
    }
    public function credenciales()
    {
        return $this->hasMany(AsignacionCredencial::class, 'id_empleado');
    }

    public function scopeActivos($query)
    {
        return $query;
        }
}
