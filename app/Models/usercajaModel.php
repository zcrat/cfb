<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usercajaModel extends Model
{public $timestamps = false;
    protected $table = 'usuarioscaja';
    protected $fillable = [
        'name',
    ];

    function cajaadmin(){
        return $this->HasMany(CajaModel::class, 'user_id','id'); 
    }
}
