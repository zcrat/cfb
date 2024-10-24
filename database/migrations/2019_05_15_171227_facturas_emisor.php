<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacturasEmisor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas_emisor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('n_certificado');
            $table->string('archivo_cer');
            $table->string('archivo_key');
            $table->string('clave_key');
            $table->string('rfc_emisor');
            $table->string('nombre_emisor');
            $table->string('regimen_emisor');
            $table->string('codigo_emisor');
            $table->string('serie_factura');
            $table->string('folio_factura');
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
        Schema::dropIfExists('facturas_emisor');
    }
}
