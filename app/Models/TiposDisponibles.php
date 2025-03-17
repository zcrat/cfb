<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposDisponibles extends Model
{
    protected $table = 'Tipos_disponibles';
    protected $fillable = [
        'id_tipo',
        'id_modulo',
        'id_sucursal',
        'id_anio',
    ];
}
