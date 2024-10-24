<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pTipos extends Model
{
    protected $table = 'pTipos';
    protected $fillable = [
        'id',
        'tipo',
    ];
}
