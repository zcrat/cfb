<?php

namespace App\Http\Controllers;
use App\pCFETipos;
use DB;

use Illuminate\Http\Request;

class TiposCFEController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $ubicaciones = pCFETipos::orderBy('tipo', 'asc')->get();
         
        return [
            'categorias' => $ubicaciones
        ];
    }
    
    public function store(Request $request)
    {
            
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new pCFETipos();
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
        $categoria = pCFETipos::findOrFail($request->id);
        $categoria->tipo = $request->nombre;
        $categoria->save();
    }
    public function desactivar(Request $request)
    {

        $cotizacion = pCFETipos::findOrFail($request->id);
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }
}
