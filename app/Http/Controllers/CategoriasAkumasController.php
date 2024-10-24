<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pCategorias;
use DB;

class CategoriasAkumasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $ubicaciones = pCategorias::get();
         
        return [
            'categorias' => $ubicaciones
        ];
    }
    
    public function store(Request $request)
    {
            
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new pCategorias();
            $cotizacion->titulo = $request->nombre;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = pCategorias::findOrFail($request->id);
        $categoria->titulo = $request->nombre;
        $categoria->save();
    }
    public function desactivar(Request $request)
    {

        $cotizacion = pCategorias::findOrFail($request->id);
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }
}
