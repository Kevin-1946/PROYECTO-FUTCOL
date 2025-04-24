<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('torneo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_torneo')->unique();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('categoria')->unique();
            $table->string('modalidad')->unique();
            $table->string('organizador')->unique();
            $table->string('sedes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('torneo');
    }
};
