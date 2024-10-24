<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escape extends Model
{
    protected $table = 'escape';
    protected $fillable = [
        'mofle_convertidor_catlitico',
        'sensores_soporte_tubos',
        'escape_notas'
    ];
}
