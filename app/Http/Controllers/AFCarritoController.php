<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\anexosFCarrito;
use App\User;
use DB;

class AFCarritoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        
            $cotizaciones = anexosFCarrito::join('AFConceptos','anexosfcarrito.pConcepto_id','=','AFConceptos.id')
            ->join('anexosforaneos','anexosfcarrito.presupuesto_id','=','anexosforaneos.id')
            ->select('anexosfcarrito.id','AFConceptos.descripcion','anexosfcarrito.cantidad','anexosfcarrito.precio','anexosfcarrito.precio_v')
            ->where('anexosfcarrito.presupuesto_id','=',$id)
            ->orderBy('anexosfcarrito.id', 'desc')->get();
         
        return [
            'detalleconceptos' => $cotizaciones,
        ];
    }

    public function store(Request $request)
    {

       
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
            $preciov = $request->precio_nuevo*1.82;
            $vehiculo = new anexosFCarrito();
            $vehiculo->presupuesto_id = $request->presupuestoCFE_id;
            $vehiculo->pConcepto_id = $request->pCFEConcepto_id;
            $vehiculo->cantidad = $request->cantidad;
            $vehiculo->precio = $request->precio_nuevo;
            $vehiculo->precio_v = $preciov;
            $vehiculo->usuario_id = \Auth::user()->id;
            $vehiculo->save();

            DB::commit();
            return [
                'id'=> $vehiculo->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function delete(Request $request){

 
            $sucursal = anexosFCarrito::findOrFail($request->id);
            $sucursal->delete();
    
            $estado = true;
            return collect(['estado' => $estado]);
        
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = anexosFCarrito::findOrFail($request->id);
        $articulo->cantidad = $request->cantidad;
        $articulo->precio = $request->precio;
        $articulo->precio_v = $request->precio_v;
        $articulo->save();
    }
}
