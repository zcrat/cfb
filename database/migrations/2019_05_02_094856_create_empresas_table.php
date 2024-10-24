<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',120);
            $table->string('rfc',120);
            $table->string('logo',500);
            $table->string('email',120);
            $table->string('direccion',120);
            $table->string('ciudad',15)->nullable();
            $table->string('estado',15)->nullable();
            $table->string('cp',15)->nullable();
            $table->string('tel_negocio',15);
            $table->string('tel_casa',15)->nullable();
            $table->string('tel_celular',15)->nullable();
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
        Schema::dropIfExists('empresas');
    }
}
