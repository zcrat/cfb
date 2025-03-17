<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $fillable = [
        'id', 
        'empresa_id',
        'emisor_id',
        'idusuario',
        'xml',
        'pdf',
        'estado',
        'movimiento',
        'n_movimiento'
     ];
}
