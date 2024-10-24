<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosForaneosRecepcionAcuse extends Model
{
    protected $table = 'anexosFRAcuse';
    protected $fillable = [
        'd',
        'folioNum',
        'user_id',
        'empresa_id',
        'fecha',
        'no_economico',
        'placas',
        'marca',
        'submarca',
        'modelo',
        'no_serie',
        'tipo_de_vehiculo',
        'tipo_de_servicio',
        'observaciones',
        'nombnre_taller',
        'razon_social',
        'usuario',
        'rpe',
        'km_entrada',
        'orden_servicio',
        'orden_id'
    ];
}
