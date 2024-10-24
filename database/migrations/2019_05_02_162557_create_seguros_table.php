<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSegurosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguros', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recepcion_vehicular_id');
            $table->string('cia_seg');
            $table->string('tel_seg');
            $table->string('no_siniestro');
            $table->string('ajustador');
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
        Schema::dropIfExists('seguros');
    }
}
