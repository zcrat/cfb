<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoSat extends Model
{
    protected $table = 'codigo_sat';
    protected $fillable = [
        'code',
        'descripcion'
    ];
}
