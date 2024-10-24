<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $table = 'conceptos';
    protected $fillable = [
        'orden_compra_id',
        'proveedor',
        'clave',
        'descripcion',
        'cantidad',
        'precio',
    ];
}
