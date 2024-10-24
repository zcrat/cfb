<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pConceptos extends Model
{
    protected $table = 'pConceptos';
    protected $fillable = [
        'id',
        'pConceptos_id',
        'pTipos_id',
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
}
