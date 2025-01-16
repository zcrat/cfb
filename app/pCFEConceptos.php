<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pCFEConceptos extends Model
{
    protected $table = 'pCFEConceptos';
    protected $fillable = [
        'id',
        'pCFEConceptos_id',
        'pCFETipos_id',
        'num',
        'descripcion',
        'p_refaccion',
        'tiempo',
        'p_mo',
        'p_total',
        'codigo_sat',
        'codigo_unidad',
        'unidad_text',
    ];

    public function carrito()
{
    return $this->hasMany(pCFECarrito::class, 'pCFEConcepto_id','id');
}
}
