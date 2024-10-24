<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaArchivos extends Model
{
    protected $table = 'caja_archivos';
    protected $fillable = [
        'id',
        'caja_id',
        'nombre',
        'tipo'
    ];
}
