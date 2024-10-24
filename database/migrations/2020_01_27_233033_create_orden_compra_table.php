<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ordenRegistro')->nullable();
            $table->integer('folio')->nullable();
            $table->date('fecha_creada')->nullable();
            $table->time('hora_creada',0)->nullable();
            $table->string('para',200)->nullable();
            $table->time('asignada_mensajero_hora',0)->nullable();
            $table->time('entrega_mensajero_hora')->nullable();
            $table->string('autorizado',200)->nullable();
            $table->string('firma_recibido',200)->nullable();
            $table->time('hora_firma')->nullable();
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
        Schema::dropIfExists('orden_compra');
    }
}
