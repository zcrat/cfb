<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportesEstimadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importes_estimados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numImporteEstimado');
            $table->integer('idOrdenReparacion');
            $table->float('tiempo',8,2);
            $table->float('por',8,2);
            $table->float('importeEstimado',8,2);
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
        Schema::dropIfExists('importes_estimados');
    }
}
