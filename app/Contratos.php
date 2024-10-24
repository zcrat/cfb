<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratos extends Model
{
    protected $table = 'contratos';
    protected $fillable = [
      'nombre',  
      'numero',
      'monto'
    ];
}
