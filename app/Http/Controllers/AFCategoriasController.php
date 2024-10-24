<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\anexosFCategorias;
use DB;

class AFCategoriasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $ubicaciones = anexosFCategorias::get();
         
        return [
            'categorias' => $ubicaciones
        ];
    }
    
    public function store(Request $request)
    {
            
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new anexosFCategorias();
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
        $categoria = anexosFCategorias::findOrFail($request->id);
        $categoria->titulo = $request->nombre;
        $categoria->save();
    }
    public function desactivar(Request $request)
    {

        $cotizacion = anexosFCategorias::findOrFail($request->id);
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }
}
