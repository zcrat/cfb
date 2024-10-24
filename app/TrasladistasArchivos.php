<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrasladistasArchivos extends Model
{
    protected $table = 'trasladistas_archivos';
    protected $fillable = [
        'id',
        'tareas_id',
        'nombre',
        'tipo'
    ];
}
