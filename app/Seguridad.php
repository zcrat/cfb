<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguridad extends Model
{
    protected $table = 'seguridad';
    protected $fillable = [
        'frenos_emergencia',
        'limpiaparabrisas_izquierdo_derecho',
        'limpiaparabrisas_trasero',
        'notas'
    ];
}
