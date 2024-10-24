<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFCarrito extends Model
{
    protected $table = 'anexosfcarrito';
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
