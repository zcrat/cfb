<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosNuevas extends Model
{
    protected $table = 'fotos_nuevas';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'archivo',
    ];
}
