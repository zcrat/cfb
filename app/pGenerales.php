<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pGenerales extends Model
{
    protected $table = 'pGenerales';
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
