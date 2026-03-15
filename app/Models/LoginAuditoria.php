<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginAuditoria extends Model
{
    protected $table = 'login_auditoria';

    protected $fillable = [
        'credencial_id',
        'ip_address',
        'user_agent',
        'device_fingerprint',
        'login_at',
        'last_activity_at',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    public function credencial(): BelongsTo
    {
        return $this->belongsTo(AsignacionCredencial::class, 
'credencial_id');
    }
}
