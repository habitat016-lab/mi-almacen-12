<?php
// database/migrations/[fecha]_modify_users_table_for_session.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Verificar y eliminar columnas redundantes si existen
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
            if (Schema::hasColumn('users', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('users', 'remember_token')) {
                $table->dropColumn('remember_token');
            }

            // 2. Agregar nuevas columnas para sesión activa
            if (!Schema::hasColumn('users', 'credencial_id')) {
                $table->foreignId('credencial_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('users', 'session_token')) {
                $table->string('session_token')->nullable()->index();
            }

            if (!Schema::hasColumn('users', 'last_activity')) {
                $table->timestamp('last_activity')->nullable();
            }

            if (!Schema::hasColumn('users', 'ip_address')) {
                $table->string('ip_address', 45)->nullable();
            }

            if (!Schema::hasColumn('users', 'user_agent')) {
                $table->text('user_agent')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restaurar columnas originales
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // Eliminar nuevas columnas
            $table->dropConstrainedForeignId('credencial_id');
            $table->dropColumn([
                'session_token',
                'last_activity',
                'ip_address',
                'user_agent'
            ]);
        });
    }
};