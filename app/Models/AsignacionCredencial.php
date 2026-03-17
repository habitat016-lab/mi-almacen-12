<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Notifications\Notifiable;

class AsignacionCredencial extends Model implements Authenticatable
{
    use AuthenticatableTrait, Notifiable;

    protected $table = 'asignacion_credenciales';

    protected $fillable = [
        'id_empleado',
        'correo_electronico',
        'llave_acceso',
    ];

    protected $hidden = [
        'llave_acceso',
    ];

    public function getAuthPassword()
    {
        return $this->llave_acceso;
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'credencial_id');
    }

    // Relación para notificaciones (opcional pero útil)
    public function notifications()
    {
        return 
$this->morphMany('Illuminate\Notifications\DatabaseNotification', 
'notifiable')
                    ->orderBy('created_at', 'desc');
    }
}
