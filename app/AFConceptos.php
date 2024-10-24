<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AFConceptos extends Model
{
    protected $table = 'AFConceptos';
    protected $fillable = [
        'id',
        'pCategorias_id',
        'pTipos_id',
        'num',
        'descripcion',
        'p_refaccion',
        'tiempo',
        'p_mo',
        'pnuevo',
        'p_total',
        'codigo_sat',
        'codigo_unidad',
        'unidad_text',
    ];
}
