<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programacion_juez', function (Blueprint $table) {
            $table->id();
            
            // Cambia programacion_id por programacion_encuentros_id
            $table->unsignedBigInteger('programacion_encuentros_id');
            
            // Referencia a programacion_encuentros en lugar de programacion
            $table->foreign('programacion_encuentros_id')
                  ->references('id')
                  ->on('programacion_encuentros')
                  ->onDelete('cascade');
            
            $table->timestamps();
            
            // Versión alternativa más limpia:
            // $table->foreignId('programacion_encuentros_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programacion_juez');
    }
};
