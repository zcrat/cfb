<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    protected $table = 'pagos';
    protected $fillable = [
        'id',
        'fecha',
        'hora',
        'rfc_receptor',
        'fpago',
        'moneda',
        'monto',
        'n_operacion',
        'mpago',
        'proceso',
        'user_id'
    ];
}
