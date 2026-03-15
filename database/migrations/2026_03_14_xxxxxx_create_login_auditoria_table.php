<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_auditoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credencial_id')
                  ->constrained('asignacion_credenciales')
                  ->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_fingerprint', 64)->nullable()->index();
            $table->timestamp('login_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            
            $table->index('credencial_id');
            $table->index('device_fingerprint');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_auditoria');
    }
};
