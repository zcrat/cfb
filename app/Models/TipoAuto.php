<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehiculo;
class TipoAuto extends Model
{
    protected $table = 'tipo_auto';
    protected $fillable = [
        'nombre'
    ];

    function vehiculos(){
        return $this->hasMany(Vehiculo::class, 'tipo_id','id'); 
    }
}