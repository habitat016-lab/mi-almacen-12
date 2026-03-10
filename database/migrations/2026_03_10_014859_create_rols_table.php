<?php

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
        Schema::create('rols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cat_puesto_id')
                ->nullable()
                ->constrained('cat_puestos')
                ->nullOnDelete()
                ->comment('ID del puesto del catálogo (cat_puestos)');
            $table->text('observaciones')->nullable();
            $table->json('permisos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rols');
    }
};