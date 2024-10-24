<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicaciones extends Model
{
    protected $table = 'ubicaciones';
    protected $fillable = [
        'nombre',
    ];
}
