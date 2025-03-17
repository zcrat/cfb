<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\presupuestosCFE;
class Mensajes extends Model
{
    protected $table = 'mensajes';
    protected $fillable = [
        'id',
        'user_id',
        'presupuesto_id',
        'mensaje',
    ];
    function usuarios(){
        return $this->belongsTo(User::class, 'user_id','id'); 
    }
    function presupuesto(){
        return $this->belongsTo(presupuestosCFE::class, 'presupuesto_id','id'); 
    }
}
