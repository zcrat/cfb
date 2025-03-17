<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipomovimineto extends Model
{
    protected $table = 'tiposmovimiento';
    protected $fillable = [
        'descripcion',
    ];

    function cajaadmin(){
        return $this->HasMany(CajaModel::class, 'movimiento_id','id'); 
    }
}
