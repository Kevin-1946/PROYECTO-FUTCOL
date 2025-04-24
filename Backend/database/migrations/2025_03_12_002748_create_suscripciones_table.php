<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {

        Schema::create('suscripcion', function (Blueprint $table) {

            $table->id();
            $table->string('tipo_documento');
            $table->string('numero_documento')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->integer('edad')->nullable();
            $table->string('genero');           
            $table->string('email')->unique();
            $table->string('contrasena');
            $table->string('tipo_torneo');
            $table->string('forma_pago');
            $table->timestamps();
        });
    }

    public function down()
    {

        Schema::dropIfExists('suscripcion');
    }
};
