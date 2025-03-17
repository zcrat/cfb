<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposDisponibles2 extends Model
{
    protected $table = 'Tipos_disponibles2';
    protected $fillable = [
        'id_tipo',
        'id_modulo',
        'id_sucursal',
        'id_contrato',
        'anio',
    ];
}
