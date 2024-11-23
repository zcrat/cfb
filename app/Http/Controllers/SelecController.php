<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Articulo;

class SelecController extends Controller
{
    public function select2empresas(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Empresa::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(10)->get();
        return response()->json($s2empresas);
    }
    public function obtenerarticulos(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $articulos=Articulo::select('id','descripcion')->where('descripcion', 'like', '%' . $term . '%')->take(15)->get();
        
        return response()->json($articulos);
        }
}
