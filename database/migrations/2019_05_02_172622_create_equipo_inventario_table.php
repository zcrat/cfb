<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipoInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_inventario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('recepcion_vehicular_id');
            $table->boolean('llanta');
            $table->boolean('cubreruedas');
            $table->boolean('cables_corriente');
            $table->boolean('candado_ruedas');
            $table->boolean('estuche_herramientas');
            $table->boolean('gato');
            $table->boolean('llave_tuercas');
            $table->boolean('tarjeta_circulacion');
            $table->boolean('triangulo_seguridad');
            $table->boolean('extinguidor');
            $table->boolean('placas');
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
        Schema::dropIfExists('equipo_inventario');
    }
}
