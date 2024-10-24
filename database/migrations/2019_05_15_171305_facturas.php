<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Facturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empresa_id')->nullable();
            $table->unsignedInteger('emisor_id')->nullable();
            $table->unsignedInteger('idusuario')->nullable();
            $table->string('xml');
            $table->string('pdf');
            $table->string('estado', 20);
            $table->string('movimiento');
            $table->string('n_movimiento');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('emisor_id')->references('id')->on('facturas_emisor');
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
        Schema::dropIfExists('facturas');
    }
}
