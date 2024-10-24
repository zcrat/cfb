<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensajes extends Model
{
    protected $table = 'mensajes';
    protected $fillable = [
        'id',
        'user_id',
        'presupuesto_id',
        'mensaje'
    ];
}
