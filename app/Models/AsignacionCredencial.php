<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class AsignacionCredencial extends Authenticatable
{
    use Notifiable;

    protected $table = 'asignacion_credenciales';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_empleado',
        'correo_electronico',
        'llave_acceso',
    ];

    protected $hidden = [
        'llave_acceso',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->llave_acceso;
    }

    /**
     * Get the remember token for the user.
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the remember token for the user.
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the remember token.
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Relación con el empleado
     */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id_empleado');
    }

    /**
     * Obtener el puesto actual del empleado
     */
    public function puestoActual(): HasOneThrough
    {
        return $this->hasOneThrough(
            Puesto::class,
            Employee::class,
            'id',
            'employee_id',
            'id_empleado',
            'id'
        )->latest();
    }

    /**
     * Accessor para el nombre del puesto
     */
    public function getPuestoNombreAttribute(): string
    {
        $puesto = $this->puestoActual?->first();
        return $puesto?->catPuesto?->nombre_puesto ?? 'Sin puesto 
asignado';
    }

    /**
     * Accessor para el nombre completo del empleado
     */
    public function getNameAttribute(): string
    {
        if (!$this->empleado) {
            return 'Usuario';
        }
        return trim($this->empleado->nombres . ' ' . 
$this->empleado->apellido_paterno . ' ' . 
$this->empleado->apellido_materno);
    }
}
