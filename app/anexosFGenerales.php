<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFGenerales extends Model
{
    protected $table = 'anexosFGenerales';
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
