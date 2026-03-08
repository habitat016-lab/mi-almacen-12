<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignacion_credenciales', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('id_empleado')
                ->constrained('employees')
                ->onDelete('cascade');
                
            $table->foreignId('id_puesto')
                ->constrained('cat_puestos')
                ->onDelete('cascade');
                
            $table->string('correo_electronico')->unique();
            
            $table->foreignId('id_asignacion_puesto')
                ->constrained('puestos')
                ->onDelete('cascade');
                
            $table->string('llave_acceso');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignacion_credenciales');
    }
};
