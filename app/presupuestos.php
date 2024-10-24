<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class presupuestos extends Model
{
    protected $table = 'presupuestos';
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
        return $this->belongsTo('App\pCarrito');
    }

    public function detalle()
    {
        return $this->belongsToMany(pCarrito::class)->withTimestamps();
    }
}
