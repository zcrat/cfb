<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table = 'detalle_facturas';
    protected $fillable = [
        'factura_id', 
        'idarticulo',
        'cantidad',
        'precio'
    ];
    public $timestamps = false;
}
