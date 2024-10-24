<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiposCuenta extends Model
{
    protected $table = 'tiposCuenta';
    protected $fillable = [
        'nombre'
    ];
}
