<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CajaModel extends Model
{use SoftDeletes;
    public $timestamps = false;
    protected $table = 'CajaAdmin';
    protected $fillable = [
        'movimiento_id',
        'cantidad',
        'user_id',
        'fecha',
        'descripcion'
        
    ];

    function tipomovimiento(){
        return $this->belongsTo(tipomovimineto::class, 'movimiento_id','id'); 
    }
    function usuarios(){
        return $this->belongsTo(usercajaModel::class, 'user_id','id'); 
    }
}
