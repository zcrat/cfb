<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosViejas extends Model
{
    protected $table = 'fotos_viejas';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'archivo',
    ];
}
