<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcategoria')->unsigned();
            $table->string('codigo_sat', 50)->nullable();
            $table->string('unidad_sat', 50)->nullable();
            $table->string('unidad', 50)->nullable();
            $table->string('codigo', 50)->nullable();
            $table->string('nombre', 100)->nullable();
            $table->string('descripcion', 256)->nullable();
            $table->decimal('precio_venta', 11, 2);
            $table->integer('stock')->default(1);
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            $table->foreign('idcategoria')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
