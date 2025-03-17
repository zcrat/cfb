<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdministradorTransporte extends Model
{
    use  SoftDeletes;

    protected $table = 'AdministradoresdeTrasporte';

    protected $fillable = ['Nombre'];
}
