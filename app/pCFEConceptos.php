<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pCFEConceptos extends Model
{
    protected $table = 'pCFEConceptos';
    protected $with = ('tipodata');
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
        'id_anio_correspondiente'
    ];
    public function carrito()
{
    return $this->hasMany(pCFECarrito::class, 'pCFEConcepto_id','id');
}
    public function tipodata()
{
    return $this->belongsTo(pCFETipos::class, 'pCFETipos_id','id');
}
}
