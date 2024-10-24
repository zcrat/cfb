<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReparacionesSubcontratadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reparaciones_subcontratadas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idOrdenReparacion');
            $table->string('reparaciones');
            $table->float('importe');
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
        Schema::dropIfExists('reparaciones_subcontratadas');
    }
}
