<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehiculo;
class Modelo extends Model
{
    protected $table = 'modelos';
    protected $fillable = [
        'nombre',
        'marca_id',
    ];

    function vehiculos(){
        return $this->hasMany(Vehiculo::class, 'modelo_id','id'); 
    }
}
