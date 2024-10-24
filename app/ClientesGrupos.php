<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientesGrupos extends Model
{
    protected $table = 'clientes_grupos';
    protected $fillable = [
        'id',
        'empresas_id',
        'grupos_id',
    ];
}
