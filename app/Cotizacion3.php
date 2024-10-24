<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion3 extends Model
{
    protected $table = 'cotizacion3';
    protected $fillable = [
        'id',
        'strodes',
        'strid',
        'strejecutivo',
        'strubicacion',
        'iduser',
        'idautorizo',
        'strfirma',
        'idreporterv',
        'fecha',
        'tentrega',
        'observa',
        'idompra',
        'vehiculo',
        'placas',
        'vin',
        'kmo',
        'economico',
        'idcliente',
        'status',
        'tecnico_id',
        'niveles'

    ];

    public function detalles()
    {
        return $this->belongsTo('App\DetalleCotizacion');
    }

    public function detalle()
    {
        return $this->belongsToMany(DetalleCotizacion::class)->withTimestamps();
    }
}
