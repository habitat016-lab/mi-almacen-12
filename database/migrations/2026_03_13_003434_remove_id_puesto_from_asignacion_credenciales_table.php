<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asignacion_credenciales', function (Blueprint $table) {
            $table->dropForeign(['id_puesto']); // eliminar FK si existe
            $table->dropColumn('id_puesto');
        });
    }

    public function down(): void
    {
        Schema::table('asignacion_credenciales', function (Blueprint $table) {
            $table->foreignId('id_puesto')->nullable()->constrained('puestos');
        });
    }
};