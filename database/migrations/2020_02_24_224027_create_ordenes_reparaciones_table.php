<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenesReparacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes_reparaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idOrdenRegistro');
            $table->string('piezaQueSeDebenGuardar',200)->nullable();
            $table->float('materiales',8,2);
            $table->float('totalManoObra',8,2);
            $table->float('totalPiezas',8,2);
            $table->float('subcontratado',8,2);
            $table->float('subtotal',8,2);
            $table->float('iva',8,2);
            $table->float('total',8,2);
            $table->string('firma',200);
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
        Schema::dropIfExists('ordenes_reparaciones');
    }
}
