<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CajaBancos;
use App\FacturasCajaBancos;
use App\FacturasXMLBancos;
use App\FacturasPDFBancos;
use App\Cuentas;
use DB;
use Illuminate\Support\Carbon;

class CajaBancosController extends Controller
{
    public function index(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');

        $finicio = $request->finicio;
        $ffinal = $request->ffinal;
        $cuentas = Cuentas::get();

        $cuentas = Cuentas::join('bancos','cuentas.bancos_id','=','bancos.id')
        ->select('cuentas.id','cuentas.noCuenta','bancos.nombre as banco')
        ->orderBy('id', 'desc')->get();


        $cajacount = CajaBancos::count();
        if($cajacount == 0){
            $saldo = '0';  
        } else {   
            $caja = CajaBancos::select('caja_bancos.id','caja_bancos.fecha','caja_bancos.concepto','caja_bancos.ingreso','caja_bancos.egreso','caja_bancos.saldo')
            ->orderBy('id', 'desc')->get();
        $saldo = $caja[0]['saldo'];  

        }

   
        
        if ($finicio==''){
            $categorias = CajaBancos::select('caja_bancos.id','caja_bancos.fecha','caja_bancos.concepto','caja_bancos.ingreso','caja_bancos.egreso','caja_bancos.saldo')
            ->orderBy('id', 'asc')->paginate(50);
        }
        else{
            $categorias = CajaBancos::select('caja_bancos.id','caja_bancos.fecha','caja_bancos.concepto','caja_bancos.ingreso','caja_bancos.egreso','caja_bancos.saldo')
            ->whereBetween('caja_bancos.fecha', [$finicio, $ffinal])
            ->orderBy('id', 'asc')->paginate(50);
        }
        

        return [
            'pagination' => [
                'total'        => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page'     => $categorias->perPage(),
                'last_page'    => $categorias->lastPage(),
                'from'         => $categorias->firstItem(),
                'to'           => $categorias->lastItem(),
            ],
            'caja' => $categorias,
            'saldo' => $saldo,
            'cuentas' => $cuentas,
        ];
    }

    public function updatearchivoPDF(Request $request)
    {

        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/facturas_clientes_pdf/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'pdf';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/facturas_clientes_pdf/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }
        return collect(['nombre' => $fileName]);
        
    }

    public function updatearchivoXML(Request $request)
    {

        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/facturas_clientes_xml/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'xml'))
                $extension = 'xml';
            else 
                $extension = 'xml';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/facturas_clientes_xml/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }
        return collect(['nombre' => $fileName]);
        
    }

    public function guardarFacturaXMLBancos(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FacturasXMLBancos();
            $cotizacion->caja_bancos_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarFacturaPDFBancos(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FacturasPDFBancos();
            $cotizacion->caja_bancos_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function selectFacturas(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $id = $request->id;

            $categorias = FacturasCajaBancos::join('facturas_xml_bancos','facturas_caja_bancos.id','=','facturas_xml_bancos.facturas_caja_bancos_id')
            ->join('facturas_pdf_bancos','facturas_caja_bancos.id','=','facturas_xml_bancos.facturas_caja_bancos_id')
            ->select('facturas_caja_bancos.id','facturas_caja_bancos.folio','facturas_caja_bancos.numero','facturas_caja_bancos.monto', 'facturas_xml_bancos.archivo as archivoxml', 'facturas_pdf_bancos.archivo as archivopdf')
            ->where('facturas_caja_bancos.caja_bancos_id','=',$id)->distinct()->paginate(50);
          
           
            DB::commit();
            return [
                'pagination' => [
                    'total'        => $categorias->total(),
                    'current_page' => $categorias->currentPage(),
                    'per_page'     => $categorias->perPage(),
                    'last_page'    => $categorias->lastPage(),
                    'from'         => $categorias->firstItem(),
                    'to'           => $categorias->lastItem(),
                ],
                'facturas' => $categorias
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');


        $cajacount = CajaBancos::where('cuenta_id','=',$request->cuenta_id)->count();
        
        if($cajacount == 0){
            $saldo = '0';  
        } else {   
           
        $caja = CajaBancos::select('caja_bancos.cuenta_id','caja_bancos.id','caja_bancos.fecha','caja_bancos.concepto','caja_bancos.ingreso','caja_bancos.egreso','caja_bancos.saldo')
            ->where('cuenta_id','=',$request->cuenta_id)
            ->orderBy('id', 'desc')->get();
        $saldo = $caja[0]['saldo'];   
         
        }
        $categoria = new CajaBancos();
        $categoria->fecha = Carbon::parse($request->fecha)->timezone('America/Mexico_City')->toDateTimeString();
        $categoria->cuenta_id = $request->cuenta_id;
        $categoria->concepto = $request->concepto;
        if ($request->ingreso == '0'){
            $categoria->ingreso = $request->importe;
            $saldo = $saldo + $request->importe;
        } else {
            $categoria->egreso = $request->importe;
            $saldo = $saldo - $request->importe;
        }
        $categoria->saldo = $saldo;
        $categoria->save();

        
       
        if($request->facturas!=null){
            $detalles = $request->facturas;//Array de detalles
            foreach($detalles as $ep=>$det)
            {
                $detalle = new FacturasCajaBancos();
                $detalle->caja_bancos_id = $categoria->id;
                $detalle->folio = $det['folio'];
                $detalle->numero = $det['numero'];
                $detalle->monto = $det['monto'];     
                $detalle->save();

                $detalle1 = new FacturasXMLBancos();
                $detalle1->facturas_caja_bancos_id = $detalle->id;
                $detalle1->archivo = $det['archivoxml'];   
                $detalle1->save();

                $detalle2 = new FacturasPDFBancos();
                $detalle2->facturas_caja_bancos_id = $detalle->id;
                $detalle2->archivo = $det['archivopdf'];   
                $detalle2->save();
            }  
        }
        

    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function delete(Request $request)
    {

        $cotizacion = CajaBancos::findOrFail($request->id);
        $ca22 = FacturasCajaBancos::where('caja_bancos_id','=',$request->id)->count();
        if($ca22 == 0){

        } else {
        $so = FacturasCajaBancos::select('id')->where('caja_bancos_id','=',$request->id)->get();
        $so1 = FacturasCajaBancos::findOrFail($so[0]['id']);
        $estado0= $so1->delete();
        }
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }
}
