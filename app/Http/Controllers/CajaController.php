<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caja;
use App\CajaArchivos;
use App\FacturasCaja;
use App\FacturasPDFEfectivo;
use App\FacturasXMLEfectivo;
use Illuminate\Support\Carbon;

class CajaController extends Controller
{
    public function index(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');

        $finicio = $request->finicio;
        $ffinal = $request->ffinal;


        $cajacount = Caja::count();
        if($cajacount == 0){
            $saldo = '0';  
        } else {   
        $caja = Caja::select('caja.id','caja.fecha','caja.concepto','caja.ingreso','caja.egreso','caja.saldo')
            ->orderBy('id', 'desc')->get();

        
        $saldo = $caja[0]['saldo'];  

        }
        
        if ($finicio==''){
            $categorias = Caja::select('caja.id','caja.fecha','caja.concepto','caja.ingreso','caja.egreso','caja.saldo')
            ->orderBy('id', 'desc')->paginate(50);
        }
        else{
            $categorias = Caja::select('caja.id','caja.fecha','caja.concepto','caja.ingreso','caja.egreso','caja.saldo')
            ->whereBetween('caja.fecha', [$finicio, $ffinal])
            ->orderBy('id', 'desc')->paginate(50);
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
        ];
    }


    public function selectFacturas(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;

        $categorias = FacturasCaja::join('facturas_xml_efectivo','facturas_caja.id','=','facturas_xml_efectivo.facturas_caja_id')
        ->join('facturas_pdf_efectivo','facturas_caja.id','=','facturas_pdf_efectivo.facturas_caja_id')
        ->select('folio','numero','monto', 'facturas_xml_efectivo.archivo as archivoxml', 'facturas_pdf_efectivo.archivo as archivopdf')
            ->where('caja_id','=',$id)->paginate(50);
        
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

    public function guardarFacturaXMLEfectivo(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FacturasXMLEfectivo();
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

    public function guardarFacturaPDFEfectivo(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FacturasPDFEfectivo();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');
        $cajacount = Caja::count();
        if($cajacount == 0){
            $saldo = '0';  
        } else {   
        $caja = Caja::select('caja.id','caja.fecha','caja.concepto','caja.ingreso','caja.egreso','caja.saldo')
            ->orderBy('id', 'desc')->get();
        $saldo = $caja[0]['saldo'];  
        }  

        $categoria = new Caja();
        $categoria->fecha = Carbon::parse($request->fecha)->timezone('America/Mexico_City')->toDateTimeString();
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

    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Cuentas::findOrFail($request->id);
        $categoria->noCuenta = $request->noCuenta;
        $categoria->bancos_id = $request->bancos_id;
        $categoria->tiposCuenta_id = $request->tiposCuenta_id;
        $categoria->monedas_id = $request->monedas_id;
        $categoria->domicilioBanco = $request->domicilioBanco;
        $categoria->telefonoBanco = $request->telefonoBanco;
        $categoria->nombreEjecutivo = $request->nombreEjecutivo;
        $categoria->emailEjecutivo = $request->emailEjecutivo;
        $categoria->telefonoEjecutivo = $request->telefonoEjecutivo;
        $categoria->save();
    }

    public function delete(Request $request)
    {

        $cotizacion = Caja::findOrFail($request->id);
        $ca22 = FacturasCaja::where('caja_id','=',$request->id)->count();
        if($ca22 == 0){

        } else {
        $so = FacturasCaja::select('id')->where('caja_id','=',$request->id)->get();
        $so1 = FacturasCaja::findOrFail($so[0]['id']);
        $estado0= $so1->delete();
        }
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }

    public function eliminar(Request $request){

 
        $sucursal = CajaArchivos::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
    public function subir(Request $request)
    {
        

        if($request->hasFile('files')){
            $files = $request->file('files');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extencion = $file->getClientOriginalExtension();
                $path = public_path().'/img/archivos/';
                $file->move($path, $filename);
                $user = new CajaArchivos();
                $user->caja_id = $request->id;
                $user->nombre = $filename;
                $user->tipo = $extencion;     
                $user->save();
                
            }
        }

        return count($files);
         

    }
    public function downloadFile($file){
        $pathtoFile = public_path().'/img/archivos/'.$file;
        return response()->download($pathtoFile);
      }

      public function indexarchivos(Request $request)
      {
         
          if (!$request->ajax()) return redirect('/');
  
          $buscar = $request->buscar;
          
          
              $tareas = CajaArchivos::select('id','caja_id','nombre','tipo')
              ->where('caja_id','=', $buscar)
              ->orderBy('id', 'desc')->paginate(20);
  
         
          
          return [
              'pagination' => [
                  'total'        => $tareas->total(),
                  'current_page' => $tareas->currentPage(),
                  'per_page'     => $tareas->perPage(),
                  'last_page'    => $tareas->lastPage(),
                  'from'         => $tareas->firstItem(),
                  'to'           => $tareas->lastItem(),
              ],
              'archivos' => $tareas
          ];
      }
}
