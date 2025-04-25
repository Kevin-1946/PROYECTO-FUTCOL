<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('encuentros', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger por defecto
            $table->string('sede', 50);
            $table->date('fecha');
            $table->time('hora');
            $table->string('local', 100);
            $table->string('visitante', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encuentros');
    }
};
