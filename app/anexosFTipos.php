<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFTipos extends Model
{
    protected $table = 'anexosFTipos';
    protected $fillable = [
        'id',
        'tipo', 
    ];
}
