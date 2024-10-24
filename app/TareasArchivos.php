<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TareasArchivos extends Model
{
    protected $table = 'tareas_archivos';
    protected $fillable = [
        'id',
        'tareas_id',
        'nombre',
        'tipo'
    ];
}
