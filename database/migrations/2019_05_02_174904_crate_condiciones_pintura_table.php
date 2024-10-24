<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateCondicionesPinturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condiciones_pintura', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recepcion_vehicular_id');
            $table->boolean('decolorada');
            $table->boolean('emblemas_completos');
            $table->boolean('color_no_igual');
            $table->boolean('logos');
            $table->boolean('exeso_rayones');
            $table->boolean('exeso_rociado');
            $table->boolean('pequenias_grietas');
            $table->boolean('danios_granizado');
            $table->boolean('carroceria_golpes');
            $table->boolean('lluvia_acido');
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
        Schema::dropIfExists('condiciones_pintura');
    }
}
