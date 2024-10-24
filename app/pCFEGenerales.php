<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pCFEGenerales extends Model
{
    protected $table = 'pCFEGenerales';
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
