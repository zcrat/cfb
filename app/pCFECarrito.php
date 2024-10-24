<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pCFECarrito extends Model
{
    protected $table = 'pCFECarrito';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'pCFEConcepto_id',
        'cantidad',
        'precio',
        'usuario_id',
        'retencion_iva',
        'retencion_isr'
    ];
}
