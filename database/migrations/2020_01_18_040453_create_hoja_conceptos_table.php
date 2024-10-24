<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHojaConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_conceptos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_recepcion');  
            $table->integer('id_tecnico');    
            $table->integer('odes');
            $table->string('r_r', 200)->nullable(); 
            $table->float('subtotal_partes',8,2);
            $table->float('subtotal_mano_obra',8,2);
            $table->float('subtotal_subcontratado',8,2);
            $table->float('subtotal_otros',8,2);
            $table->float('subtotal_subtotal_costos',8,2);
            $table->float('iva_subtotal_partes',8,2);
            $table->float('iva_subtotal_mano_obra',8,2);
            $table->float('iva_subtotal_subcontratado',8,2);
            $table->float('iva_subtotal_otros',8,2);
            $table->float('iva_subtotal_subtotal_costos',8,2);
            $table->float('total_partes',8,2);
            $table->float('total_mano_obra',8,2);
            $table->float('total_subcontratado',8,2);
            $table->float('total_otros',8,2);
            $table->float('total_subtotal_costos',8,2);
            $table->string('autorizacion',100)->nullable();
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
        Schema::dropIfExists('hoja_conceptos');
    }
}
