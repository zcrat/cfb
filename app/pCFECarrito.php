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
        'precio_v',
        'usuario_id',
        'retencion_iva',
        'retencion_isr'
    ];

public function concepto()
    {
        return $this->belongsTo(pCFEConceptos::class,'pCFEConcepto_id','id');
    }
}