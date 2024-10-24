<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExterioresEquipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exteriores_equipo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recepcion_vehicular_id');
            $table->char('antena_radio');
            $table->char('antena_telefono');
            $table->char('antena_cb');
            $table->char('estribos');
            $table->char('espejos_laterales');
            $table->char('guardafangos');
            $table->char('parabrisas');
            $table->char('sistema_alarma');
            $table->char('limpia_parabrisas');
            $table->char('luces_exteriores');
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
        Schema::dropIfExists('exteriores_equipo');
    }
}
