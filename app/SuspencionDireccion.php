<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuspencionDireccion extends Model
{
    protected $table = 'suspencion_direccion';
    protected $fillable = [
        'amortiguadores_suspencion',
        'juntas_direccion_rotulas',
        'notas'
    ];
}
