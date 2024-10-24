<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pCFETipos extends Model
{
    protected $table = 'pCFETipos';
    protected $fillable = [
        'id',
        'tipo',
    ];
}
