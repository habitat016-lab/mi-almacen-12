<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asignacion_permisos', function (Blueprint $table) {
            // Agregar role_id
            $table->foreignId('role_id')
                ->nullable()
                ->after('cat_puesto_id')
                ->constrained('roles')
                ->nullOnDelete()
                ->comment('ID del rol seleccionado');
        });
    }

    public function down(): void
    {
        Schema::table('asignacion_permisos', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
