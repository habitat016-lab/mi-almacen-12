<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            // Agregar id_gerencia después de id_area
            $table->foreignId('id_gerencia')
                ->nullable()
                ->after('id_area')
                ->constrained('cat_gerencias')
                ->onDelete('set null');
            
            // Podemos eliminar el campo 'gerencia' después de migrar datos
            // $table->dropColumn('gerencia');
        });
    }

    public function down(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            $table->dropForeign(['id_gerencia']);
            $table->dropColumn('id_gerencia');
        });
    }
};