<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\anexosFTipos;
use DB;

class AFTiposController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $ubicaciones = anexosFTipos::get();
         
        return [
            'categorias' => $ubicaciones
        ];
    }
    
    public function store(Request $request)
    {
            
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new anexosFTipos();
            $cotizacion->tipo = $request->nombre;
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
        $categoria = anexosFTipos::findOrFail($request->id);
        $categoria->tipo = $request->nombre;
        $categoria->save();
    }
    public function desactivar(Request $request)
    {

        $cotizacion = anexosFTipos::findOrFail($request->id);
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }
}
