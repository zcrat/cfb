<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cotizaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empresa_id')->nullable();
            $table->unsignedInteger('idusuario')->nullable();
            $table->string('vehiculo')->nullable();
            $table->string('odes')->nullable();
            $table->string('id_text')->nullable();
            $table->string('ejecutivo')->nullable();
            $table->string('placas')->nullable();
            $table->string('vim')->nullable();
            $table->string('n_economico')->nullable();
            $table->string('km_odometro')->nullable();
            $table->string('tiempo_entrega')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('fecha')->nullable();
            $table->decimal('impuesto', 4, 2)->default(0.0);
            $table->decimal('total', 11, 2)->default(0.0);
            $table->string('estado', 20)->default('Registrado');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
}
