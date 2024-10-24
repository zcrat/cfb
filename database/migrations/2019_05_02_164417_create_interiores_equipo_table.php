<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterioresEquipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interiores_equipo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recepcion_vehicular_id');
            $table->char('puerta_interior_frontal');
            $table->char('puerta_interior_trasera');
            $table->char('puerta_delantera_frontal');
            $table->char('puerta_delantera_trasera');
            $table->char('asiento_interior_frontal');
            $table->char('asiento_interior_trasera');
            $table->char('asiento_delantera_frontal');
            $table->char('asiento_delantera_trasera');
            $table->char('consola_central');
            $table->char('claxon');
            $table->char('tablero');
            $table->char('quemacocos');
            $table->char('toldo');
            $table->char('elevadores_eletricos');
            $table->char('luces_interiores');
            $table->char('seguros_eletricos');
            $table->char('tapetes');
            $table->char('climatizador');
            $table->char('radio');
            $table->char('espejos_retrovizor');
            //todo cambiar referencia, esta deberia ser de la tabla recepcion
            $table->foreign('recepcion_vehicular_id')->references('id')->on('recepcion_vehicular');
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
        Schema::dropIfExists('interiores_equipo');
    }
}
