<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('puesto_id')->unique();
            $table->text('observaciones')->nullable();
            $table->json('permisos')->nullable();
            $table->timestamps();
            
            $table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};