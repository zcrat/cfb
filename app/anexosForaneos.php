<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosForaneos extends Model
{
    protected $table = 'anexosforaneos';
    protected $fillable = [
        'd',
        'pVehiculos_id',
        'pGenerales_id',
        'descripcionMO',
        'fechaDeVigencia',
        'tiempo',
        'importe',
        'observaciones',
        'user_id',
        'factura_id',
        'listo',
        'status'
    ];

    public function detalles()
    {
        return $this->belongsTo('App\anexosFCarrito');
    }

    public function detalle()
    {
        return $this->belongsToMany(anexosFCarrito::class)->withTimestamps();
    }
}
