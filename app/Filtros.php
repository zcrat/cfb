<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filtros extends Model
{
    protected $table = 'filtros';
    protected $fillable = [
        'aire',
        'combustible',
        'aceite',
        'notas'
    ];
}
