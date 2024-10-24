<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 'modelos';
    protected $fillable = [
        'nombre',
        'marca_id',
    ];

    function marca(){
        return $this->hasOne(Marca::class);
    }
}
