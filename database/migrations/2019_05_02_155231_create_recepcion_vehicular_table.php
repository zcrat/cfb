<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecepcionVehicularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcion_vehicular', function (Blueprint $table) {
     
            $table->increments('id');
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('empresa_id');
            $table->Integer('customer_id')->nullable();
            $table->unsignedInteger('vehiculo_id');
            $table->string('orden_seguimiento');
            $table->string('folio')->nullable();
            $table->string('notas_adicionales')->nullable();
            $table->string('indicaciones_del_cliente')->nullable();
            $table->string('km_entrada');
            $table->string('km_salida');
            $table->string('gas_entrada');
            $table->string('gas_salida');
            $table->dateTime('fecha');
            $table->string('firma');
            $table->dateTime('fecha_compromiso');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
            $table->timestamps('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recepcion_vehicular');
    }
}
