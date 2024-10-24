<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pCarrito extends Model
{
    protected $table = 'pCarrito';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'pConcepto_id',
        'cantidad',
        'precio',
        'usuario_id',
        'retencion_iva',
        'retencion_isr'
    ];
    public $timestamps = false;
}
