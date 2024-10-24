<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecnicosArchivos extends Model
{
    protected $table = 'tecnicos_archivos';
    protected $fillable = [
        'id',
        'tareas_id',
        'nombre',
        'tipo'
    ];
}
