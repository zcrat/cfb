<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trasladistas extends Model
{
    protected $table = 'trasladistas';
    protected $fillable = [
        'id',
        'nombre'
    ];
}
