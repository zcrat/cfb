<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class archivoscaja extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $table ='archivoscaja';
    protected $fillable =[
        'movimiento_id','archivo',
    ];
}
