<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFCategorias extends Model
{
    protected $table = 'anexosFCategorias';
    protected $fillable = [
        'id',
        'num',
        'titulo',
    ];
}
