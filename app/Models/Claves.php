<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claves extends Model
{
    protected $table = 'claves';
    protected $fillable = [
        'id',
        'modulo_id',
        'zona_id',
        'clave',
    ];
}
