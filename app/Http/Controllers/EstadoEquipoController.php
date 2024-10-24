<?php

namespace App\Http\Controllers;

use App\EstadoEquipo;
use Illuminate\Http\Request;

class EstadoEquipoController extends Controller
{
    public function index(){
        $estadoEquipo = EstadoEquipo::select('id as code','nombre as label')->get();
        return $estadoEquipo;
    }
}
