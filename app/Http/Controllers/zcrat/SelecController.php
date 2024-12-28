<?php

namespace App\Http\Controllers\zcrat;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Articulo;
use App\Models\Color;
use App\RecepcionVehicular;

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
    public function select2rr(Request $request){
            $term = str_replace(' ', '%', $request->input('term'));
            $rr=RecepcionVehicular::select('id','folioNum')->where('folioNum', 'like', '%' . $term . '%')->orderby("folioNum","desc")->take(15)->get();
            return response()->json($rr);
            }
    public function select2clientes(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Empresa::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(10)->get();
        return response()->json($s2empresas);
    }
    public function select2vehiculos(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Empresa::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(10)->get();
        return response()->json($s2empresas);
    }
    public function select2marcasvehiculo(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Empresa::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(10)->get();
        return response()->json($s2empresas);
    }
    public function select2modelosvehiculo(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Empresa::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(10)->get();
        return response()->json($s2empresas);
    }
    public function select2tipovehiculo(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Empresa::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(10)->get();
        return response()->json($s2empresas);
    }
    public function select2coloresvehiculo(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $colores=Color::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(10)->get();
        return response()->json($colores);
    }
}
