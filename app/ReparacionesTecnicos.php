<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReparacionesTecnicos extends Model
{
    protected $table = 'reparaciones_tecnicos1';
    protected $fillable = [
        'id',
        'marca_modelo',
        'economico_placas',
        'r_r',
        'descripcion',
        'id_tecnico',
        'fecha',
        'fecha_entrega',
        'recibio',
        'entrego',
        'status'

    ];
}
