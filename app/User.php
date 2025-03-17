<?php

namespace App;

use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Mensajes;
use App\Models\RecepcionGeneralModel;
class User extends Authenticatable
{
    use Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'sucursal_id','name','email', 'password','condicion'
    ];
    
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    function prefactura(){
        return $this->hasMany(FacturasSave::class, 'user_id','id'); 
    }
    function mensaje(){
        return $this->hasMany(Mensajes::class, 'user_id','id'); 
    }

    function RecepcionGeneral(){
        return $this->hasMany(RecepcionGeneralModel::class,'usuario_id','id');
    }
    
}
