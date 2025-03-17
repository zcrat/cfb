<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TecnicoTaller extends Model
{
    use  SoftDeletes;

    protected $table = 'TecnicosTaller';

    protected $fillable = ['Nombre'];
}
