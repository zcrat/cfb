<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pCategorias extends Model
{
    protected $table = 'pCategorias';
    protected $fillable = [
        'id',
        'num',
        'titulo',
    ];
}
