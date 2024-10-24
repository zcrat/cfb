<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenReparacion extends Model
{
    protected $table = 'ordenes_reparaciones';
    protected $fillable = [
        'idOrdenRegistro',
        'piezaQueSeDebenGuardar',
        'materiales',
        'totalManoObra',
        'totalPiezas',
        'subcontratado',
        'subtotal',
        'iva',
        'total',
        'firma'
    ];
}
