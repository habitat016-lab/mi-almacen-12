<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Notifications\Notifiable;

class AuthUser extends Authenticatable implements FilamentUser
{
    use Notifiable;

    protected $table = 'asignacion_credenciales';
    
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
    protected $fillable = [
        'id_empleado',
        'correo_electronico',
        'llave_acceso',
    ];
    
    protected $hidden = [
        'llave_acceso',
    ];
    
    protected $casts = [
        'llave_acceso' => 'hashed',
    ];
    
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    
    public function getAuthPassword()
    {
        return $this->llave_acceso;
    }
    
    public function empleado()
    {
        return $this->belongsTo(Employee::class, 'id_empleado');
    }
}
