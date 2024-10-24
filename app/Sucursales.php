<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    protected $table = 'sucursales';
    protected $fillable =[
        'clave',
        'folio',
        'numero',
        'nombre',
        'calle',
        'numero_ext',
        'numero_int',
        'colonia',
        'cp',
        'ciudad',
        'estado',
        'telefono',
        'email'
    ];
}
