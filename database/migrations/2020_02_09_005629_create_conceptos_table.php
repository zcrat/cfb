<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_hoja_conceptos');
            $table->integer('num_concepto');
            $table->integer('id_articulo');
            $table->string('remplazar',20)->nullable();
            $table->string('reparar',20)->nullable();
            $table->date('fecha_aplicacion');
            $table->integer('cantidad');
            $table->float('partes',8,2);
            $table->float('mano_obra',8,2);
            $table->float('subcontratado',8,2);
            $table->float('otros',8,2);
            $table->float('subtotal_costos');
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
        Schema::dropIfExists('conceptos');
    }
}
