<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignacion_permisos', function (Blueprint $table) 
{
            $table->id();
            $table->foreignId('cat_puesto_id')
                ->nullable()
                ->constrained('cat_puestos')
                ->nullOnDelete()
                ->comment('ID del puesto del catálogo (se muestra el 
nombre)');
            $table->text('observaciones')->nullable();
            $table->json('permisos')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignacion_permisos');
    }
};
