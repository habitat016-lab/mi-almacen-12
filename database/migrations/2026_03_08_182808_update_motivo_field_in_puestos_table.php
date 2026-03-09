<?php
// database/migrations/2026_03_09_XXXXXX_update_motivo_field_in_puestos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            // Eliminar el campo motivo actual (texto libre)
            $table->dropColumn('motivo');
            
            // Agregar el nuevo campo motivo_id como FK
            $table->foreignId('motivo_id')
                  ->nullable()
                  ->after('gerencia') // o después del campo que prefieras
                  ->constrained('cat_motivos')
                  ->nullOnDelete()
                  ->comment('ID del motivo seleccionado del catálogo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            // Eliminar la FK y el campo motivo_id
            $table->dropForeign(['motivo_id']);
            $table->dropColumn('motivo_id');
            
            // Restaurar el campo motivo original
            $table->text('motivo')->nullable()->after('gerencia');
        });
    }
};