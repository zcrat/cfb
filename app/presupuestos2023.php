<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class presupuestos2023 extends Model
{
    protected $table = 'presupuestos2023';
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
        return $this->belongsTo('App\pCarrito2023');
    }

    public function detalle()
    {
        return $this->belongsToMany(pCarrito2023::class)->withTimestamps();
    }
}
