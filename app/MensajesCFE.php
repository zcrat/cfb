<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajesCFE extends Model
{
    protected $table = 'mensajes_cfe';
    protected $fillable = [
        'id',
        'user_id',
        'presupuestoCFE_id',
        'mensaje'
    ];
}
