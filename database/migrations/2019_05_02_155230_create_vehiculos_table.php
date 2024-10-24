<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tipo_id');
            $table->unsignedInteger('marca_id');
            $table->unsignedInteger('modelo_id');
            $table->unsignedInteger('color_id');
            $table->string('placas',15);
            $table->integer('anio');
            $table->string('no_economico');
            $table->string('vim',30);
            $table->foreign('tipo_id')->references('id')->on('tipo_auto');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('modelo_id')->references('id')->on('modelos');
            $table->foreign('color_id')->references('id')->on('colores');
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
        Schema::dropIfExists('vehiculos');
    }
}
