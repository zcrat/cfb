<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tecnicos extends Model
{
    protected $table = 'tecnicos';
    protected $fillable = [
        'id',
        'nombre'
    ];
}
