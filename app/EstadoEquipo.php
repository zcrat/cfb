<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoEquipo extends Model
{
    protected $table = 'estado_equipo';
    protected $fillable = [
      'nombre'
    ];
}
