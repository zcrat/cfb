<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pCFECategorias extends Model
{
    protected $table = 'pCFECategorias';
    protected $fillable = [
        'id',
        'num',
        'titulo',
    ];
}
