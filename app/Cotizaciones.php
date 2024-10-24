<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizaciones extends Model
{
    protected $table = 'cotizaciones';
    protected $fillable = [
        'empresa_id',
        'vehiculo',
        'idusuario',
        'odes',
        'id_text',
        'ejecutivo',
        'placas',
        'vim',
        'n_economico',
        'km_odometro',
        'tiempo_entrega',
        'observaciones',
        'fecha',
        'impuesto',
        'total',
        'estado'
    ];

    function empresa(){
        return $this->hasOne(Empresa::class);
    }

    function vehiculo(){
        return $this->hasOne(Vehiculo::class);
    }
}
