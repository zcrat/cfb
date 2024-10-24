<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuentas extends Model
{
    protected $table = 'cuentas';
    protected $fillable = [
        'id',
        'noCuenta',
        'bancos_id',
        'tiposCuenta_id',
        'monedas_id',
        'domicilioBanco',
        'telefonoBanco',
        'nombreEjecutivo',
        'emailEjecutivo',
        'telefonoEjecutivo'
    ];
}
