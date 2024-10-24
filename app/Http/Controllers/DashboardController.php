<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sucursales;
use App\pCFECarrito;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $id = \Auth::user()->sucursal_id;

        $m = Sucursales::join('contratos','sucursales.contratos_id','=','contratos.id')
        ->select('contratos.id','contratos.nombre','contratos.monto','contratos.numero')
        ->where('sucursales.id','=',$id)->get();

        $idcontrato = $m[0]['id'];

        $compras = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','12')
            ->orderBy('pCFECarrito.id', 'desc')->get();

        $compras2 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','13')
            ->orderBy('pCFECarrito.id', 'desc')->get(); 
       
        $compras3 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','14')
            ->orderBy('pCFECarrito.id', 'desc')->get();   
        
        $compras4 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','15')
            ->orderBy('pCFECarrito.id', 'desc')->get();
            
        $compras5 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','17')
            ->orderBy('pCFECarrito.id', 'desc')->get();


        $compras6 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','18')
            ->orderBy('pCFECarrito.id', 'desc')->get();


        $compras7 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','19')
            ->orderBy('pCFECarrito.id', 'desc')->get();


        $compras8 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','20')
            ->orderBy('pCFECarrito.id', 'desc')->get();

        $compras9 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','21')
            ->orderBy('pCFECarrito.id', 'desc')->get();

        $compras10 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','22')
            ->orderBy('pCFECarrito.id', 'desc')->get();

        $compras11 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','23')
            ->orderBy('pCFECarrito.id', 'desc')->get();

        $compras12 = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEConceptos.pCFECategorias_id','=','24')
            ->orderBy('pCFECarrito.id', 'desc')->get();    

        $total = 0;
        $c=0;
        foreach($compras as $compra){
        $c= $compra->cantidad*$compra->precio_v;    
        $total = $c + $total;
        }

        $total2 = 0;
        $c2=0;
        foreach($compras2 as $compra2){
        $c2 = $compra2->cantidad*$compra2->precio_v;    
        $total2 = $c2 + $total2;
        }

        $total3 = 0;
        $c3=0;
        foreach($compras3 as $compra3){
        $c3 = $compra3->cantidad*$compra3->precio_v;    
        $total3 = $c3 + $total3;
        }

        $total4 = 0;
        $c4=0;
        foreach($compras4 as $compra4){
        $c4 = $compra4->cantidad*$compra4->precio_v;    
        $total4 = $c4 + $total4;
        }

        $total5 = 0;
        $c5=0;
        foreach($compras5 as $compra5){
        $c5 = $compra5->cantidad*$compra5->precio_v;    
        $total5 = $c5 + $total5;
        }

        $total6 = 0;
        $c6=0;
        foreach($compras6 as $compra6){
        $c6 = $compra6->cantidad*$compra6->precio_v;    
        $total6 = $c6 + $total6;
        }

        $total7 = 0;
        $c7=0;
        foreach($compras7 as $compra7){
        $c7 = $compra7->cantidad*$compra7->precio_v;    
        $total7 = $c7 + $total7;
        }

        $total8 = 0;
        $c8=0;
        foreach($compras8 as $compra8){
        $c8 = $compra8->cantidad*$compra8->precio_v;    
        $total8 = $c8 + $total8;
        }

        $total9 = 0;
        $c9=0;
        foreach($compras9 as $compra9){
        $c9 = $compra9->cantidad*$compra9->precio_v;    
        $total9 = $c9 + $total9;
        }

        $total10 = 0;
        $c10=0;
        foreach($compras10 as $compra10){
        $c10 = $compra10->cantidad*$compra10->precio_v;    
        $total10 = $c10 + $total10;
        }

        $total11 = 0;
        $c11=0;
        foreach($compras11 as $compra11){
        $c11 = $compra11->cantidad*$compra11->precio_v;    
        $total11 = $c11 + $total11;
        }

        $total12 = 0;
        $c12=0;
        foreach($compras12 as $compra12){
        $c12 = $compra12->cantidad*$compra12->precio_v;    
        $total12 = $c12 + $total12;
        }

 
        return [
            'contrato'=>$m,
            'totalmotor'=>$total,
            'totalenfriamiento'=>$total2,
            'totalembrague'=>$total3, 
            'totaltrasmision'=>$total4,
            'totalsuspencionydireccion'=>$total5,
            'totalfrenosyruedas'=>$total6,
            'totalelectrico'=>$total7,
            'totalescape'=>$total8,
            'totaltraslados'=>$total9,
            'totalfuera'=>$total10,
            'totalmayor'=>$total11,
            'totalmenor'=>$total12   
        ];      
 
    }
}
