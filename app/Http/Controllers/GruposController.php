<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupos; 

class GruposController extends Controller
{
    public function selectGrupos(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Grupos::select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['categorias' => $categorias];
    }
}
