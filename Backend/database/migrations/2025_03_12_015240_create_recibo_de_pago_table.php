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
        Schema::create('recibo_de_pago', function (Blueprint $table) {
            $table->id();
            $table->string('confirmacion_de_pago');
            $table->string('fecha_emision');
            $table->string('monto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibo_de_pago');
    }
};
