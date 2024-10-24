<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{
    protected $table = 'tareas';
    protected $fillable = [
        'id',
        'id_user',
        'descripcion',
        'fecha_inicio',
        'fecha_termino',
        'status',
    ];
}
