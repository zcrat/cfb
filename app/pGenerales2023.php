<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pGenerales2023 extends Model
{
    protected $table = 'pGenerales2023';
    protected $fillable = [
        'id',
        'NSolicitud',
        'FechaAlta',
        'OrdenServicio',
        'KmDeIngreso',
        'ClienteYRazonSocial',
        'Mail',
        'Telefono',
        'Conductor',
        'Fecha'
    ];
}
