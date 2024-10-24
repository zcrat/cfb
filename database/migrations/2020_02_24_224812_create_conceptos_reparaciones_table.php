<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptosReparacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptos_reparaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numConceptoReparacion');
            $table->integer('idOrdenReparacion');
            $table->integer('cantidad');
            $table->integer('idArticulo');
            $table->float('importePieza',8,2);
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
        Schema::dropIfExists('conceptos_reparaciones');
    }
}
