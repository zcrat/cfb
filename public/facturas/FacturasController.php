<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Classes\Facturar;
use App\User;
use App\presupuestosCFE;
use App\presupuestos;
use DB;
use App\DetalleFactura;
use App\pCFEConceptos;
use App\FacturasEmisor;
use App\Classes\Certificados;
use App\Classes\CvHandler;
use App\Empresa;
use App\FacturasSave;
use App\FacturasSaveDetalle;
use App\Pagos;
use App\DetallePagos;
use App\Contratos;

use Carbon\Carbon;

class FacturasController extends Controller
{

    public function index(Request $request)
    {

        
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $facturas = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
            ->select('facturas.id','facturas.xml','facturas.pdf','facturas.acuse','facturas.estado',
            'facturas.movimiento','facturas.n_movimiento','facturas.created_at','facturas.pago')
            ->orderBy('facturas.id', 'desc')->paginate(1000);
        }
        else{
            $facturas = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
            ->select('facturas.id','facturas.xml','facturas.pdf','facturas.acuse','facturas.estado',
            'facturas.movimiento','facturas.n_movimiento','facturas.created_at','facturas.pago')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('facturas.id', 'desc')->paginate(1000);
        }


    

         foreach($facturas as $fac){

         $archivoname = public_path().'/facturas/'.$fac->xml;

         $xml = new \SimpleXMLElement ($archivoname,null,true);
         $ns = $xml->getNamespaces(true);
         $xml->registerXPathNamespace('c', $ns['cfdi']);
         $xml->registerXPathNamespace('t', $ns['tfd']);
         foreach ($xml->xpath('//cfdi:Comprobante') as $comp){ 
         foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
         $xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
         foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
         $receptor2 = $Receptor['Rfc'];
         $serie = $comp['Serie'];
         $folio = $comp['Folio'];
         $fecha = $comp['Fecha'];
         $total = $comp['Total'];
         $receptor3 = $Receptor['Nombre'];
         $sello5 = $tfd['UUID'];

         $fac->rfc_receptor = $receptor2;
         $fac->nombre_receptor = $receptor3;
         $fac->folio_fact = $serie.$folio;
         $fac->total_fact = $total;

         }}}
         
         }

        

   
        return [
            'pagination' => [
                'total'        => $facturas->total(),
                'current_page' => $facturas->currentPage(),
                'per_page'     => $facturas->perPage(),
                'last_page'    => $facturas->lastPage(),
                'from'         => $facturas->firstItem(),
                'to'           => $facturas->lastItem(),
            ],
            'facturas' => $facturas
        ];
    }

    public function porcobrar(Request $request)
    {

        
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $facturas = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
            ->select('facturas.id','facturas.xml','facturas.pdf','facturas.acuse','facturas.estado',
            'facturas.movimiento','facturas.n_movimiento','facturas.created_at','facturas.pago')
            ->where('facturas.pago', '=', 'No')
            ->orderBy('facturas.id', 'desc')->paginate(1000);
        }
        else{
            $facturas = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
            ->select('facturas.id','facturas.xml','facturas.pdf','facturas.acuse','facturas.estado',
            'facturas.movimiento','facturas.n_movimiento','facturas.created_at','facturas.pago')
            ->where('facturas.pago', '=','No')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('facturas.id', 'desc')->paginate(1000);
        }


    

         foreach($facturas as $fac){

         $archivoname = public_path().'/facturas/'.$fac->xml;

         $xml = new \SimpleXMLElement ($archivoname,null,true);
         $ns = $xml->getNamespaces(true);
         $xml->registerXPathNamespace('c', $ns['cfdi']);
         $xml->registerXPathNamespace('t', $ns['tfd']);
         foreach ($xml->xpath('//cfdi:Comprobante') as $comp){ 
         foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
         $xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
         foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
         $receptor2 = $Receptor['Rfc'];
         $serie = $comp['Serie'];
         $folio = $comp['Folio'];
         $fecha = $comp['Fecha'];
         $total = $comp['Total'];
         $receptor3 = $Receptor['Nombre'];
         $sello5 = $tfd['UUID'];

         $fac->rfc_receptor = $receptor2;
         $fac->nombre_receptor = $receptor3;
         $fac->folio_fact = $serie.$folio;
         $fac->total_fact = $total;

         }}}
         
         }

        

   
        return [
            'pagination' => [
                'total'        => $facturas->total(),
                'current_page' => $facturas->currentPage(),
                'per_page'     => $facturas->perPage(),
                'last_page'    => $facturas->lastPage(),
                'from'         => $facturas->firstItem(),
                'to'           => $facturas->lastItem(),
            ],
            'facturas' => $facturas
        ];
    }

    public function porcontrato(Request $request)
    {

        
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $contra = $request->contra;
        $contratos = Contratos::get();
         

        if ($contra == '1'){

            $facturas = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->join('facturas','presupuestosCFE.factura_id','=','facturas.id')
            ->select('facturas.id','facturas.xml','facturas.pdf','facturas.acuse','facturas.estado',
            'facturas.movimiento','facturas.n_movimiento','facturas.created_at','facturas.pago')
            ->where('presupuestosCFE.factura_id', '!=','0')
            ->where('contratos.id','=',$buscar)->orderBy('presupuestosCFE.factura_id', 'desc')->groupBy('presupuestosCFE.factura_id')->paginate(1000);
         } else {
 
        if ($buscar==''){
            $facturas = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
            ->select('facturas.id','facturas.xml','facturas.pdf','facturas.acuse','facturas.estado',
            'facturas.movimiento','facturas.n_movimiento','facturas.created_at','facturas.pago')
            ->orderBy('facturas.id', 'desc')->paginate(1000);
        }
        else{
            $facturas = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
            ->select('facturas.id','facturas.xml','facturas.pdf','facturas.acuse','facturas.estado',
            'facturas.movimiento','facturas.n_movimiento','facturas.created_at','facturas.pago')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('facturas.id', 'desc')->paginate(1000);
         }
         }


    

         foreach($facturas as $fac){

         $archivoname = public_path().'/facturas/'.$fac->xml;

         $xml = new \SimpleXMLElement ($archivoname,null,true);
         $ns = $xml->getNamespaces(true);
         $xml->registerXPathNamespace('c', $ns['cfdi']);
         $xml->registerXPathNamespace('t', $ns['tfd']);
         foreach ($xml->xpath('//cfdi:Comprobante') as $comp){ 
         foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
         $xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
         foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
         $receptor2 = $Receptor['Rfc'];
         $serie = $comp['Serie'];
         $folio = $comp['Folio'];
         $fecha = $comp['Fecha'];
         $total = $comp['Total'];
         $receptor3 = $Receptor['Nombre'];
         $sello5 = $tfd['UUID'];

         $fac->rfc_receptor = $receptor2;
         $fac->nombre_receptor = $receptor3;
         $fac->folio_fact = $serie.$folio;
         $fac->total_fact = $total;

         }}}
         
         }

         
        

   
        return [
            'pagination' => [
                'total'        => $facturas->total(),
                'current_page' => $facturas->currentPage(),
                'per_page'     => $facturas->perPage(),
                'last_page'    => $facturas->lastPage(),
                'from'         => $facturas->firstItem(),
                'to'           => $facturas->lastItem(),
            ],
            'facturas' => $facturas,
            'contratos' => $contratos,
        ];
    }

    public function selectFacturas(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $facturas = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
        ->select('facturas.id','facturas.xml','facturas.pdf','facturas.acuse','facturas.estado',
        'facturas.movimiento','facturas.n_movimiento','facturas.created_at','facturas.pago', 'empresas.nombre')
        ->where('empresas.nombre', 'like', '%'. $filtro . '%')
        ->orderBy('facturas.id', 'desc')->get();

        foreach($facturas as $fac){

            $archivoname = public_path().'/facturas/'.$fac->xml;
   
            $xml = new \SimpleXMLElement ($archivoname,null,true);
            $ns = $xml->getNamespaces(true);
            $xml->registerXPathNamespace('c', $ns['cfdi']);
            $xml->registerXPathNamespace('t', $ns['tfd']);
            foreach ($xml->xpath('//cfdi:Comprobante') as $comp){ 
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
            $xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
            $receptor2 = $Receptor['Rfc'];
            $serie = $comp['Serie'];
            $folio = $comp['Folio'];
            $fecha = $comp['Fecha'];
            $total = $comp['Total'];
            $receptor3 = $Receptor['Nombre'];
            $sello5 = $tfd['UUID'];

        
            $fac->rfc_receptor = $receptor2."";
            $fac->nombre_receptor = $receptor3."";
            $fac->folio_fact = $serie.$folio.' '.$fac->nombre;
            $fac->total_fact = $total."";
            $fac->folio_fiscal = $sello5."";
            $fac->serie_folio = $serie."";
            $fac->folio = $folio."";
   
            }}}
            
            }
   
        return ['empresas' => $facturas];
    }

    public function indexSave(Request $request)
    {

        
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $facturas = FacturasSave::orderBy('facturas_save.id', 'desc')->paginate(1000);
        }
        else{
            $facturas = FacturasSave::where('facturas_save.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('facturas_save.id', 'desc')->paginate(1000);
        }


        return [
            'pagination' => [
                'total'        => $facturas->total(),
                'current_page' => $facturas->currentPage(),
                'per_page'     => $facturas->perPage(),
                'last_page'    => $facturas->lastPage(),
                'from'         => $facturas->firstItem(),
                'to'           => $facturas->lastItem(),
            ],
            'facturas' => $facturas
        ];
    }

    public function store(Request $request)
    {

        
       
        $dato = [];

        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
 
            
            $factura = new Factura();
            $factura->empresa_id = $request->factura['empresa_id'];
            $factura->emisor_id = '1';
            $factura->idusuario = \Auth::user()->id;
            $factura->xml = '';
            $factura->pdf = '';
            $factura->estado = 'Registrado';
            $factura->movimiento = 'Facturacion';
            $factura->n_movimiento = '0';
            $factura->save();               
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            $presupuesto = 0;
       
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleFactura();
                $detalle->factura_id = $factura->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
                $detalle->save();

                $presupuesto = $det['presupuestoCFE_id'];  
                
            }  

  
            $dato['tipo_comprobante'] = $request->factura['tipo_comprobante'];
            $dato['uso_cfdi'] = $request->factura['uso_cfdi'];
            $dato['moneda'] = $request->factura['moneda'];
            $dato['fpago'] = $request->factura['fpago'];
            $dato['mpago'] = $request->factura['mpago'];

            $pres = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega')
            ->where('presupuestosCFE.id','=',$presupuesto)->first();

            
            $texto1="CONTRATO: ".$request->factura['contrato']." \n ECONOMICO: ".$pres->identificador." \n  PLACAS: ".$pres->placas." \n KILOMETRAJE: ".$pres->kilometraje;

            $empresa = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
            ->select('empresas.id','empresas.nombre as nombre','empresas.rfc as rfc','empresas.logo','empresas.cp','empresas.regimen')
            ->where('facturas.id', '=', $factura->id)->first();

           

            $factura_emisor = Factura::join('facturas_emisor','facturas.emisor_id','=','facturas_emisor.id')
            ->select('facturas_emisor.id','facturas_emisor.n_certificado','facturas_emisor.archivo_cer',
            'facturas_emisor.archivo_key','facturas_emisor.clave_key',
            'facturas_emisor.rfc_emisor as rfc','facturas_emisor.nombre_emisor as nombre',
            'facturas_emisor.regimen_emisor as regimen','facturas_emisor.codigo_emisor as codigo',
            'facturas_emisor.serie_factura as serie','facturas_emisor.folio_factura as folio')
            ->where('facturas.id','=',$factura->id)->first();

           

            $detalles_todo = DetalleFactura::join('pCFEConceptos','detalle_facturas.idarticulo','=','pCFEConceptos.id')
            ->select('pCFEConceptos.id','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad as unidad_sat','pCFEConceptos.unidad_text as unidad',
            'pCFEConceptos.descripcion','detalle_facturas.cantidad','detalle_facturas.precio')
            ->where('detalle_facturas.factura_id','=',$factura->id)->orderBy('detalle_facturas.id', 'desc')
            ->paginate(100);

           
         
            $numero_certificado = $factura_emisor->n_certificado;
            $archivo_cer = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_cer;
            $archivo_key = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_key;
            
          
        
            // generar y sellar un XML con los CSD de pruebas
            $cfdi = new Facturar();
            $docxml = $cfdi->crearXML($empresa, $factura_emisor, $detalles_todo, $dato);          
            $keypem = new Certificados();
            $keypem->generaKeyPem($archivo_key,$factura_emisor->clave_key);
            $selladoxml = $cfdi->satxmlsv40_sella($docxml, $numero_certificado, $archivo_cer.'.pem',$archivo_key.'.pem');
            file_put_contents(public_path().'/facturas/factura.xml',$selladoxml);
            $nombrearchivoxml = public_path().'/facturas/factura.xml';

            $username = 'facturacion@aurumfixmotors.com';
            $password = 'Akumas2019##';
                  
            $invoice_path = $nombrearchivoxml;
            $xml_file = fopen($invoice_path, "rb");
            $xml_content = fread($xml_file, filesize($invoice_path));
            fclose($xml_file);
             
 
            $url = "https://facturacion.finkok.com/servicios/soap/stamp.wsdl";
            $client = new \SoapClient($url);
            $params = array(
            "xml" => $xml_content,
            "username" => $username,
            "password" => $password
            );

           
            $response = $client->__soapCall("stamp", array($params));
            //print_r($response);
            //$response = \Response::json($response);
            //return $response;
          
           if ($response->stampResult->UUID == ''){
           return $response->stampResult->Incidencias->Incidencia->MensajeIncidencia;
        	} else {
                 
           $folionvo = $factura_emisor->folio + 1;		
           $nombre = public_path().'/facturas/'.$factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.".xml";

          
         
           $file = fopen($nombre, "a");
           fwrite($file, $response->stampResult->xml);
           fclose($file);

           $pdfarch = $cfdi->generarPDF($nombre,'logo_akumas_fct.png',$texto1);

           $napdf = $factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.'.pdf';
           $naxml = $factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.'.xml';
           
           $factAct = Factura::findOrFail($factura->id);
           $factAct->xml = $naxml;
           $factAct->pdf = $napdf;
           $factAct->save();
       
           $facteAct = FacturasEmisor::findOrFail($factura_emisor->id);
           $facteAct->folio_factura = $folionvo;
           $facteAct->save();

           $cotizacion = new presupuestosCFE();
           $cotizacion = $cotizacion->find($presupuesto);
           $cotizacion->factura_id = $factura->id;
           $cotizacion->save();    
          
        	}
           
            DB::commit();
            return [
                'id'=> $factura->id 
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function storePago(Request $request)
    {
        
       
        $dato = [];

        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
 
            
            $factura = new Factura();
            $factura->empresa_id = $request->empresa_id;
            $factura->emisor_id = '1';
            $factura->idusuario = \Auth::user()->id;
            $factura->xml = '';
            $factura->pdf = '';
            $factura->estado = 'Registrado';
            $factura->movimiento = 'Facturacion';
            $factura->n_movimiento = '0';
            $factura->save();          

            $pagos = new Pagos();
            $pagos->fecha = $request->pagos[0]['fecha'];
            $pagos->hora = $request->pagos[0]['hora'];
            $pagos->rfc_receptor = $request->pagos[0]['rfc_receptor'];
            $pagos->fpago = $request->pagos[0]['fpago'];
            $pagos->moneda = $request->pagos[0]['moneda'];
            $pagos->monto = $request->pagos[0]['monto'];
            $pagos->n_operacion = $request->pagos[0]['n_operacion'];
            $pagos->mpago = $request->pagos[0]['mpago'];
            $pagos->proceso = '1';
            $pagos->user_id = \Auth::user()->id;
            $pagos->save();          
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            
       
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetallePagos();
                $detalle->factura_id = $factura->id;
                $detalle->pago_id = $pagos->id;
                $detalle->uuid = $det['uuid'];
                $detalle->folio = $det['folio'];   
                $detalle->serie = $det['serie'];   
                $detalle->total = $det['total'];   
                $detalle->mpago = $det['mpago'];   
                $detalle->moneda = $det['moneda'];
                $detalle->pago = $det['impuestopago'];
                $detalle->impuestosa = $det['impuestosa'];
                $detalle->impuestosi = $det['impuestosi']; 
                $detalle->impuestopago = $det['impuestopago']; 
                $detalle->nparcialidades = $det['nparcialidades'];          
                $detalle->save();
                
            }  

  
            $dato['tipo_comprobante'] ="P";
            $dato['uso_cfdi'] = "CP01";
            $dato['moneda'] = "XXX";

           
            
            $texto1="";

            $empresa = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
            ->select('empresas.id','empresas.nombre as nombre','empresas.rfc as rfc','empresas.logo','empresas.cp','empresas.regimen')
            ->where('facturas.id', '=', $factura->id)->first();

           

            $factura_emisor = Factura::join('facturas_emisor','facturas.emisor_id','=','facturas_emisor.id')
            ->select('facturas_emisor.id','facturas_emisor.n_certificado','facturas_emisor.archivo_cer',
            'facturas_emisor.archivo_key','facturas_emisor.clave_key',
            'facturas_emisor.rfc_emisor as rfc','facturas_emisor.nombre_emisor as nombre',
            'facturas_emisor.regimen_emisor as regimen','facturas_emisor.codigo_emisor as codigo',
            'facturas_emisor.serie_p_factura as serie','facturas_emisor.folio_p_factura as folio')
            ->where('facturas.id','=',$factura->id)->first();

           
            $pago_todo = Pagos::select('fecha','hora','rfc_receptor','fpago',
            'moneda','monto','n_operacion','mpago')
            ->where('id','=',$pagos->id)->get();

            $detalles_todo = DetallePagos::select('uuid','folio','serie','total',
            'mpago','moneda','pago','impuestosa','impuestosi','impuestopago','nparcialidades')
            ->where('pago_id','=',$pagos->id)->orderBy('id', 'desc')
            ->paginate(100);

           
         
            $numero_certificado = $factura_emisor->n_certificado;
            $archivo_cer = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_cer;
            $archivo_key = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_key;
            
          
        
            // generar y sellar un XML con los CSD de pruebas
            $cfdi = new Facturar();
            $docxml = $cfdi->crearXMLPagos($empresa, $factura_emisor,$pago_todo, $detalles_todo, $dato);  
            $keypem = new Certificados();
            $keypem->generaKeyPem($archivo_key,$factura_emisor->clave_key);
            $selladoxml = $cfdi->satxmlsv40_sella($docxml, $numero_certificado, $archivo_cer.'.pem',$archivo_key.'.pem');
            file_put_contents(public_path().'/facturas/factura_pago.xml',$selladoxml);
            $nombrearchivoxml = public_path().'/facturas/factura_pago.xml';
            

            $username = 'facturacion@aurumfixmotors.com';
            $password = 'Akumas2019##';
                  
            $invoice_path = $nombrearchivoxml;
            $xml_file = fopen($invoice_path, "rb");
            $xml_content = fread($xml_file, filesize($invoice_path));
            fclose($xml_file);
             
 
            $url = "https://facturacion.finkok.com/servicios/soap/stamp.wsdl";
            $client = new \SoapClient($url);
            $params = array(
            "xml" => $xml_content,
            "username" => $username,
            "password" => $password
            );

           
            $response = $client->__soapCall("stamp", array($params));
            //print_r($response);
            //$response = \Response::json($response);
            //return $response;
          
           if ($response->stampResult->UUID == ''){
           return $response->stampResult->Incidencias->Incidencia->MensajeIncidencia;
        	} else {
                 
           $folionvo = $factura_emisor->folio + 1;		
           $nombre = public_path().'/facturas/'.$factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.".xml";

          
         
           $file = fopen($nombre, "a");
           fwrite($file, $response->stampResult->xml);
           fclose($file);

           $pdfarch = $cfdi->generarPDFPagos($nombre,'logo_akumas_fct.png',$texto1);

           $napdf = $factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.'.pdf';
           $naxml = $factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.'.xml';
           
           $factAct = Factura::findOrFail($factura->id);
           $factAct->xml = $naxml;
           $factAct->pdf = $napdf;
           $factAct->save();
       
           $facteAct = FacturasEmisor::findOrFail($factura_emisor->id);
           $facteAct->folio_p_factura = $folionvo;
           $facteAct->save(); 
          
        	}
           
            DB::commit();
            return [
                'id'=> $factura->id 
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function storeprevia(Request $request)
    {


        $dato = [];

        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            $presupuesto = 0;
            $z = [];
            $i = 0;

           
            foreach($detalles as $ep=>$det)
            {

                $detalles_todo = pCFEConceptos::select('id','codigo_sat','codigo_unidad as unidad_sat','unidad_text as unidad',
                'descripcion')
                ->where('id','=',$det['idarticulo'])->first();

                $presupuesto = $det['presupuestoCFE_id'];  


                $z[$i] = [
                    'id' => $detalles_todo['id'],
                    'codigo_sat' => $detalles_todo['codigo_sat'],
                    'unidad_sat' => $detalles_todo['unidad_sat'],
                    'unidad' => $detalles_todo['unidad'],
                    'descripcion' => $detalles_todo['descripcion'],
                    'cantidad' => $det['cantidad'],
                    'precio' => $det['precio']
                  ];
                  $i += 1;
               
                  array_push($z);
                
            } 
       
            

  
            $dato['tipo_comprobante'] = $request->factura['tipo_comprobante'];
            $dato['uso_cfdi'] = $request->factura['uso_cfdi'];
            $dato['moneda'] = $request->factura['moneda'];
            $dato['fpago'] = $request->factura['fpago'];
            $dato['mpago'] = $request->factura['mpago'];

            $pres = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega')
            ->where('presupuestosCFE.id','=',$presupuesto)->first();

            
            $texto1="CONTRATO: ".$request->factura['contrato']." \n ECONOMICO: ".$pres->identificador." \n  PLACAS: ".$pres->placas." \n KILOMETRAJE: ".$pres->kilometraje;

            $empresa = Empresa::select('id','nombre as nombre','rfc as rfc','logo','cp','regimen')
            ->where('id', '=', $request->factura['empresa_id'])->first();
            
            $factura_emisor = FacturasEmisor::select('id','n_certificado','archivo_cer',
            'archivo_key','clave_key','rfc_emisor as rfc','nombre_emisor as nombre',
            'regimen_emisor as regimen','codigo_emisor as codigo','serie_factura as serie',
            'folio_factura as folio')->where('id','=','1')->first();

           

          

          
        
            // generar y sellar un XML con los CSD de pruebas
            $cfdi = new Facturar();
            //if($request->factura['servicio_id']=='2'){
            //    $docxml = $cfdi->crearXML4($empresa, $factura_emisor, $detalles_todo, $dato, $sucursal->folio, $sucursal->clave );        
            //} else {
            //    $docxml = $cfdi->crearXML($empresa, $factura_emisor, $detalles_todo, $dato, $sucursal->folio, $sucursal->clave );          
            //}

            
            $docxml = $cfdi->crearXMLprueba($empresa, $factura_emisor, $z, $dato,'1','CFE'); 
            file_put_contents(public_path().'/facturas/factura_vista.xml',$docxml);
            $nombrearchivoxml = public_path().'/facturas/factura_vista.xml';
            $invoice_path = $nombrearchivoxml;
            $xml_file = fopen($invoice_path, "rb");
            $xml_content = fread($xml_file, filesize($invoice_path));
            fclose($xml_file);
	
            $nombre = public_path().'/facturas/factura_vista.xml';
            $pdfarch = $cfdi->generarPDFprueba($nombre,'logo_akumas_fct.png',''); 
        
           
            DB::commit();
            return [
                'id'=> '1' 
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function storepreviamas(Request $request)
    {

        
       
        $dato = [];

        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

         
            $presupuesto = 0;
            $contrato = '';
            $z = [];
            $i = 0;
            foreach($detalles as $ep=>$det)
            {

                $contrato = $det['contrato'];   
                $z[$i] = [
                    'id' => $det['id'],
                    'codigo_sat' => '78181500',
                    'unidad_sat' => 'E48',
                    'unidad' => 'Unidad de servicio',
                    'economico' => $det['economico'],
                    'placas' => $det['placas'],
                    'kilometraje' => $det['kilometraje'],
                    'nsolicitud' => $det['NSolicitud'],
                    'descripcion' => $det['descripcionMO'],
                    'cantidad' => '1',
                    'precio' => $det['importep']
                  ];
                  $i += 1;
               
                  array_push($z);
                
            } 
       
            

  
            $dato['tipo_comprobante'] = $request->factura['tipo_comprobante'];
            $dato['uso_cfdi'] = $request->factura['uso_cfdi'];
            $dato['moneda'] = $request->factura['moneda'];
            $dato['fpago'] = $request->factura['fpago'];
            $dato['mpago'] = $request->factura['mpago'];

            
            $texto1="CONTRATO: ".$contrato;

            $empresa = Empresa::select('id','nombre as nombre','rfc as rfc','logo','cp','regimen')
            ->where('id', '=', $request->factura['empresa_id'])->first();
            
            $factura_emisor = FacturasEmisor::select('id','n_certificado','archivo_cer',
            'archivo_key','clave_key','rfc_emisor as rfc','nombre_emisor as nombre',
            'regimen_emisor as regimen','codigo_emisor as codigo','serie_factura as serie',
            'folio_factura as folio')->where('id','=','1')->first();

            // generar y sellar un XML con los CSD de pruebas
            $cfdi = new Facturar();
            //if($request->factura['servicio_id']=='2'){
            //    $docxml = $cfdi->crearXML4($empresa, $factura_emisor, $detalles_todo, $dato, $sucursal->folio, $sucursal->clave );        
            //} else {
            //    $docxml = $cfdi->crearXML($empresa, $factura_emisor, $detalles_todo, $dato, $sucursal->folio, $sucursal->clave );          
            //}

            
            $docxml = $cfdi->crearXMLprueba($empresa, $factura_emisor, $z, $dato,'1','CFE'); 
            file_put_contents(public_path().'/facturas/factura_vista.xml',$docxml);
            $nombrearchivoxml = public_path().'/facturas/factura_vista.xml';
            $invoice_path = $nombrearchivoxml;
            $xml_file = fopen($invoice_path, "rb");
            $xml_content = fread($xml_file, filesize($invoice_path));
            fclose($xml_file);
	
            $nombre = public_path().'/facturas/factura_vista.xml';
            $pdfarch = $cfdi->generarPDFprueba($nombre,'logo_akumas_fct.png',$texto1); 
        
           
            DB::commit();
            return [
                'id'=> '1' 
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function storemas(Request $request)
    {

        
       
        $dato = [];

        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

         
            $presupuesto = 0;
            $contrato = '';
            $z = [];
            $i = 0;
            foreach($detalles as $ep=>$det)
            {

                $contrato = $det['contrato'];   
                $z[$i] = [
                    'id' => $det['id'],
                    'codigo_sat' => '78181500',
                    'unidad_sat' => 'E48',
                    'unidad' => 'Unidad de servicio',
                    'economico' => $det['economico'],
                    'placas' => $det['placas'],
                    'kilometraje' => $det['kilometraje'],
                    'nsolicitud' => $det['NSolicitud'],
                    'descripcion' => $det['descripcionMO'],
                    'cantidad' => '1',
                    'precio' => $det['importep']
                  ];
                  $i += 1;
               
                  array_push($z);
                
            } 

            $factura = new Factura();
            $factura->empresa_id = $request->factura['empresa_id'];
            $factura->emisor_id = '1';
            $factura->idusuario = \Auth::user()->id;
            $factura->xml = '';
            $factura->pdf = '';
            $factura->estado = 'Registrado';
            $factura->movimiento = 'Facturacion';
            $factura->n_movimiento = '0';
            $factura->save();   
       
            

  
            $dato['tipo_comprobante'] = $request->factura['tipo_comprobante'];
            $dato['uso_cfdi'] = $request->factura['uso_cfdi'];
            $dato['moneda'] = $request->factura['moneda'];
            $dato['fpago'] = $request->factura['fpago'];
            $dato['mpago'] = $request->factura['mpago'];

            
            $texto1="CONTRATO: ".$contrato;

            $empresa = Empresa::select('id','nombre as nombre','rfc as rfc','logo','cp','regimen')
            ->where('id', '=', $request->factura['empresa_id'])->first();
            
            $factura_emisor = FacturasEmisor::select('id','n_certificado','archivo_cer',
            'archivo_key','clave_key','rfc_emisor as rfc','nombre_emisor as nombre',
            'regimen_emisor as regimen','codigo_emisor as codigo','serie_factura as serie',
            'folio_factura as folio')->where('id','=','1')->first();

            $numero_certificado = $factura_emisor->n_certificado;
            $archivo_cer = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_cer;
            $archivo_key = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_key;

            // generar y sellar un XML con los CSD de pruebas
            $cfdi = new Facturar();
            //if($request->factura['servicio_id']=='2'){
            //    $docxml = $cfdi->crearXML4($empresa, $factura_emisor, $detalles_todo, $dato, $sucursal->folio, $sucursal->clave );        
            //} else {
            //    $docxml = $cfdi->crearXML($empresa, $factura_emisor, $detalles_todo, $dato, $sucursal->folio, $sucursal->clave );          
            //}

            
            $docxml = $cfdi->crearXMLmas($empresa, $factura_emisor, $z, $dato);
            $keypem = new Certificados();
            $keypem->generaKeyPem($archivo_key,$factura_emisor->clave_key); 
            $selladoxml = $cfdi->satxmlsv40_sella($docxml, $numero_certificado, $archivo_cer.'.pem',$archivo_key.'.pem');
            file_put_contents(public_path().'/facturas/factura.xml',$selladoxml);
            $nombrearchivoxml = public_path().'/facturas/factura.xml';

            $username = 'facturacion@aurumfixmotors.com';
            $password = 'Akumas2019##';
                  
            $invoice_path = $nombrearchivoxml;
            $xml_file = fopen($invoice_path, "rb");
            $xml_content = fread($xml_file, filesize($invoice_path));
            fclose($xml_file);
             
 
            $url = "https://facturacion.finkok.com/servicios/soap/stamp.wsdl";
            $client = new \SoapClient($url);
            $params = array(
            "xml" => $xml_content,
            "username" => $username,
            "password" => $password
            );

           
            $response = $client->__soapCall("stamp", array($params));
            //print_r($response);
            //$response = \Response::json($response);
            //return $response;
          
           if ($response->stampResult->UUID == ''){
           return $response->stampResult->Incidencias->Incidencia->MensajeIncidencia;
        	} else {
                 
           $folionvo = $factura_emisor->folio + 1;		
           $nombre = public_path().'/facturas/'.$factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.".xml";

          
         
           $file = fopen($nombre, "a");
           fwrite($file, $response->stampResult->xml);
           fclose($file);

           $pdfarch = $cfdi->generarPDFmas($nombre,'logo_akumas_fct.png',$texto1);

           $napdf = $factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.'.pdf';
           $naxml = $factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.'.xml';
           
           $factAct = Factura::findOrFail($factura->id);
           $factAct->xml = $naxml;
           $factAct->pdf = $napdf;
           $factAct->save();
       
           $facteAct = FacturasEmisor::findOrFail($factura_emisor->id);
           $facteAct->folio_factura = $folionvo;
           $facteAct->save();

          

           foreach($detalles as $ep=>$det)
            {

                $cotizacion = new presupuestosCFE();
                $cotizacion = $cotizacion->find($det['id']);
                $cotizacion->factura_id = $factura->id;
                $cotizacion->save();  
                
            } 

             }
        
           
            DB::commit();
            return [
                'id'=> '1' 
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function storepreviasave(Request $request)
    {

        
       
        $dato = [];

        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');


            $factura = new FacturasSave();
            $factura->empresa_id = $request->factura['empresa_id'];
            $factura->user_id = \Auth::user()->id;
            $factura->fpago = $request->factura['fpago'];
            $factura->moneda = $request->factura['moneda'];
            $factura->mpago = $request->factura['mpago'];
            $factura->tipo_comprobante = $request->factura['tipo_comprobante'];
            $factura->tipo_impuesto_local = $request->factura['tipo_impuesto_local'];
            $factura->uso_cfdi = $request->factura['uso_cfdi'];
            $factura->save();       
            
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

         
            $presupuesto = 0;
            $contrato = '';
            $z = [];
            $i = 0;
            foreach($detalles as $ep=>$det)
            {
               
                $facturaD = new FacturasSaveDetalle();
                $facturaD->facturas_save_id = $factura->id;
                $facturaD->contrato = $det['contrato'];
                $facturaD->presupuesto_id = $det['id'];
                $facturaD->economico = $det['economico'];
                $facturaD->placas = $det['placas'];
                $facturaD->kilometraje = $det['kilometraje'];
                $facturaD->NSolicitud = $det['NSolicitud'];
                $facturaD->descripcionMO = $det['descripcionMO'];
                $facturaD->importep = $det['importep'];
                $facturaD->save();   
                
            } 
            
            DB::commit();
            return [
                'id'=> '1' 
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function storemulti(Request $request)
    {

        
       
        $dato = [];

        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

         
            $presupuesto = 0;
            $contrato = '';
            $z = [];
            $i = 0;
            foreach($detalles as $ep=>$det)
            {

                $contrato = $det['contrato'];   
                $z[$i] = [
                    'id' => $det['id'],
                    'codigo_sat' => '78181500',
                    'unidad_sat' => 'E48',
                    'unidad' => 'Unidad de servicio',
                    'economico' => $det['economico'],
                    'placas' => $det['placas'],
                    'kilometraje' => $det['kilometraje'],
                    'nsolicitud' => $det['NSolicitud'],
                    'descripcion' => $det['descripcionMO'],
                    'cantidad' => '1',
                    'precio' => $det['importep']
                  ];
                  $i += 1;
               
                  array_push($z);
                
            } 
       
            

  
            $dato['tipo_comprobante'] = $request->factura['tipo_comprobante'];
            $dato['uso_cfdi'] = $request->factura['uso_cfdi'];
            $dato['moneda'] = $request->factura['moneda'];
            $dato['fpago'] = $request->factura['fpago'];
            $dato['mpago'] = $request->factura['mpago'];

            
            $texto1="CONTRATO: ".$contrato;

            $empresa = Empresa::select('id','nombre as nombre','rfc as rfc','logo','cp','regimen')
            ->where('id', '=', $request->factura['empresa_id'])->first();
            
            $factura_emisor = FacturasEmisor::select('id','n_certificado','archivo_cer',
            'archivo_key','clave_key','rfc_emisor as rfc','nombre_emisor as nombre',
            'regimen_emisor as regimen','codigo_emisor as codigo','serie_factura as serie',
            'folio_factura as folio')->where('id','=','1')->first();

            // generar y sellar un XML con los CSD de pruebas
            $cfdi = new Facturar();
            //if($request->factura['servicio_id']=='2'){
            //    $docxml = $cfdi->crearXML4($empresa, $factura_emisor, $detalles_todo, $dato, $sucursal->folio, $sucursal->clave );        
            //} else {
            //    $docxml = $cfdi->crearXML($empresa, $factura_emisor, $detalles_todo, $dato, $sucursal->folio, $sucursal->clave );          
            //}

            
            $docxml = $cfdi->crearXMLmulti($empresa, $factura_emisor, $z, $dato,'1','CFE'); 
            file_put_contents(public_path().'/facturas/factura_vista.xml',$docxml);
            $nombrearchivoxml = public_path().'/facturas/factura_vista.xml';
            $invoice_path = $nombrearchivoxml;
            $xml_file = fopen($invoice_path, "rb");
            $xml_content = fread($xml_file, filesize($invoice_path));
            fclose($xml_file);
	
            $nombre = public_path().'/facturas/factura_vista.xml';
            $pdfarch = $cfdi->generarPDFmulti($nombre,'logo_akumas_fct.png',$texto1); 
        
           
            DB::commit();
            return [
                'id'=> '1' 
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
        $articulo = Factura::findOrFail($request->id);
        $articulo->pago = $request->pago;
        $articulo->save();
    }


    public function store2(Request $request)
    {
       
        $dato = [];

        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
 
            
            $factura = new Factura();
            $factura->empresa_id = $request->factura['empresa_id'];
            $factura->emisor_id = '1';
            $factura->idusuario = \Auth::user()->id;
            $factura->xml = '';
            $factura->pdf = '';
            $factura->estado = 'Registrado';
            $factura->movimiento = 'Facturacion';
            $factura->n_movimiento = '0';
            $factura->save();               
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            $presupuesto = 0;
       
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleFactura();
                $detalle->factura_id = $factura->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
                $detalle->save();

                $presupuesto = $det['presupuesto_id'];  
                
            }  

  
            $dato['tipo_comprobante'] = $request->factura['tipo_comprobante'];
            $dato['uso_cfdi'] = $request->factura['uso_cfdi'];
            $dato['moneda'] = $request->factura['moneda'];
            $dato['fpago'] = $request->factura['fpago'];
            $dato['mpago'] = $request->factura['mpago'];

            $pres = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega')
            ->where('presupuestos.id','=',$presupuesto)->first();

            if ($request->factura['empresa_id'] == '305') {
                $texto1=utf8_decode("AUTORIZACIÓN: ").$request->factura['contrato']." \n FOLIO: ".$pres->NSolicitud." \n  ID: ".$pres->OrdenServicio." \n ECONOMICO: ".$pres->identificador." \n KILOMETRAJE: ".$pres->kilometraje;
            } else if ($request->factura['empresa_id'] == '335') {
                $texto1=utf8_decode("AUTORIZACIÓN: ").$request->factura['contrato']." \n FOLIO: ".$pres->NSolicitud." \n  ID: ".$pres->OrdenServicio." \n ECONOMICO: ".$pres->identificador." \n KILOMETRAJE: ".$pres->kilometraje;
            } else if ($request->factura['empresa_id'] == '315') {
                $texto1=utf8_decode("AUTORIZACIÓN: ").$request->factura['contrato']." \n FOLIO: ".$pres->NSolicitud." \n  ID: ".$pres->OrdenServicio." \n ECONOMICO: ".$pres->identificador." \n KILOMETRAJE: ".$pres->kilometraje;
            } else if ($request->factura['empresa_id'] == '93') {
                $texto1=utf8_decode("AUTORIZACIÓN: ").$request->factura['contrato']." \n FOLIO: ".$pres->NSolicitud." \n  ID: ".$pres->OrdenServicio." \n ECONOMICO: ".$pres->identificador." \n KILOMETRAJE: ".$pres->kilometraje;
            } else if ($request->factura['empresa_id'] == '12') {
                $texto1=utf8_decode("AUTORIZACIÓN: ").$request->factura['contrato']." \n FOLIO: ".$pres->NSolicitud." \n  ID: ".$pres->OrdenServicio." \n ECONOMICO: ".$pres->identificador." \n KILOMETRAJE: ".$pres->kilometraje;
            } else if ($request->factura['empresa_id'] == '7') {
                $texto1=utf8_decode("AUTORIZACIÓN: ").$request->factura['contrato']." \n FOLIO: ".$pres->NSolicitud." \n  ID: ".$pres->OrdenServicio." \n ECONOMICO: ".$pres->identificador." \n KILOMETRAJE: ".$pres->kilometraje;
            } else if ($request->factura['empresa_id'] == '332') {
                $texto1=utf8_decode("AUTORIZACIÓN: ").$request->factura['contrato']." \n ECONOMICO: ".$pres->identificador." \n  PLACAS: ".$pres->placas." \n KILOMETRAJE: ".$pres->kilometraje;
            } else {
                $texto1=utf8_decode("AUTORIZACIÓN: ").$request->factura['contrato']." \n ECONOMICO: ".$pres->identificador." \n  PLACAS: ".$pres->placas." \n SERIE: ".$pres->vin." \n KILOMETRAJE: ".$pres->kilometraje;
            }
            $empresa = Factura::join('empresas','facturas.empresa_id','=','empresas.id')
            ->select('empresas.id','empresas.nombre as nombre','empresas.rfc as rfc','empresas.logo','empresas.cp','empresas.regimen')
            ->where('facturas.id', '=', $factura->id)->first();


            $factura_emisor = Factura::join('facturas_emisor','facturas.emisor_id','=','facturas_emisor.id')
            ->select('facturas_emisor.id','facturas_emisor.n_certificado','facturas_emisor.archivo_cer',
            'facturas_emisor.archivo_key','facturas_emisor.clave_key',
            'facturas_emisor.rfc_emisor as rfc','facturas_emisor.nombre_emisor as nombre',
            'facturas_emisor.regimen_emisor as regimen','facturas_emisor.codigo_emisor as codigo',
            'facturas_emisor.serie_factura as serie','facturas_emisor.folio_factura as folio')
            ->where('facturas.id','=',$factura->id)->first();

           

            $detalles_todo = DetalleFactura::join('pConceptos','detalle_facturas.idarticulo','=','pConceptos.id')
            ->select('pConceptos.id','pConceptos.codigo_sat','pConceptos.codigo_unidad as unidad_sat','pConceptos.unidad_text as unidad',
            'pConceptos.descripcion','detalle_facturas.cantidad','detalle_facturas.precio')
            ->where('detalle_facturas.factura_id','=',$factura->id)->orderBy('detalle_facturas.id', 'desc')
            ->paginate(100);

           
         
            $numero_certificado = $factura_emisor->n_certificado;
            $archivo_cer = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_cer;
            $archivo_key = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_key;
            
          
        
            // generar y sellar un XML con los CSD de pruebas
            $cfdi = new Facturar();
            $docxml = $cfdi->crearXML($empresa, $factura_emisor, $detalles_todo, $dato);          
            $keypem = new Certificados();
            $keypem->generaKeyPem($archivo_key,$factura_emisor->clave_key);
            $selladoxml = $cfdi->satxmlsv40_sella($docxml, $numero_certificado, $archivo_cer.'.pem',$archivo_key.'.pem');
            file_put_contents(public_path().'/facturas/factura.xml',$selladoxml);
            $nombrearchivoxml = public_path().'/facturas/factura.xml';

            $username = 'facturacion@aurumfixmotors.com';
            $password = 'Akumas2019##';
                  
            $invoice_path = $nombrearchivoxml;
            $xml_file = fopen($invoice_path, "rb");
            $xml_content = fread($xml_file, filesize($invoice_path));
            fclose($xml_file);
             
 
            $url = "https://facturacion.finkok.com/servicios/soap/stamp.wsdl";
            $client = new \SoapClient($url);
            $params = array(
            "xml" => $xml_content,
            "username" => $username,
            "password" => $password
            );

           
            $response = $client->__soapCall("stamp", array($params));
            //print_r($response);
            //$response = \Response::json($response);
            //return $response;
          
            
            if ($response->stampResult->UUID == ''){
                return $response->stampResult->Incidencias->Incidencia->MensajeIncidencia;
           } else {
                 
           $folionvo = $factura_emisor->folio + 1;		
           $nombre = public_path().'/facturas/'.$factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.".xml";

          
         
           $file = fopen($nombre, "a");
           fwrite($file, $response->stampResult->xml);
           fclose($file);

           $pdfarch = $cfdi->generarPDF($nombre,'logo_akumas_fct.png',$texto1);

           $napdf = $factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.'.pdf';
           $naxml = $factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.'.xml';
           
           $factAct = Factura::findOrFail($factura->id);
           $factAct->xml = $naxml;
           $factAct->pdf = $napdf;
           $factAct->save();
       
           $facteAct = FacturasEmisor::findOrFail($factura_emisor->id);
           $facteAct->folio_factura = $folionvo;
           $facteAct->save();

           $cotizacion = new presupuestos();
           $cotizacion = $cotizacion->find($presupuesto);
           $cotizacion->factura_id = $factura->id;
           $cotizacion->save();    
          
        	}
           
            DB::commit();
            return '1';
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function cancelar(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
            DB::commit();

            $factura_emisor = Factura::join('facturas_emisor','facturas.emisor_id','=','facturas_emisor.id')
            ->select('facturas_emisor.id','facturas_emisor.n_certificado','facturas_emisor.archivo_cer',
            'facturas_emisor.archivo_key','facturas_emisor.clave_key',
            'facturas_emisor.rfc_emisor as rfc','facturas_emisor.nombre_emisor as nombre',
            'facturas_emisor.regimen_emisor as regimen','facturas_emisor.codigo_emisor as codigo',
            'facturas_emisor.serie_factura as serie','facturas_emisor.folio_factura as folio','facturas.xml')
            ->where('facturas.id','=',$request['factura_id'])->first();


           

            $numero_certificado = $factura_emisor->n_certificado;
            $archivo_cer = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_cer;
            $archivo_key = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_key;

            $username = 'facturacion@aurumfixmotors.com';
            $password = 'Akumas2019##';
            # Generar el certificado y llave en formato .pem
            shell_exec("openssl x509 -inform DER -outform PEM -in ".$archivo_cer." -pubkey -out ".public_path()."/utilerias/certificados/certificado.pem");
            shell_exec("openssl pkcs8 -inform DER -in ".$archivo_key." -passin pass:".$factura_emisor->clave_key." -out ".public_path()."/utilerias/certificados/llave.key.pem");
            shell_exec("openssl rsa -in ".public_path()."/utilerias/certificados/llave.key.pem -des3 -out ".public_path()."/utilerias/certificados/llave.enc -passout pass:".$password);


            $cer_path = public_path()."/utilerias/certificados/certificado.pem"; 
            $cer_file = fopen($cer_path, "r");
            $cer_content = fread($cer_file, filesize($cer_path));
            fclose($cer_file);

            $key_path = public_path()."/utilerias/certificados/llave.enc";
            $key_file = fopen($key_path, "r");
            $key_content = fread($key_file,filesize($key_path));
            fclose($key_file);  

           
           
            $xml = new \SimpleXMLElement (public_path().'/facturas/'.$factura_emisor->xml,null,true);
            $ns = $xml->getNamespaces(true);
            $xml->registerXPathNamespace('c', $ns['cfdi']);
            $xml->registerXPathNamespace('t', $ns['tfd']);

           
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
            $xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
            $emisor2 = $Emisor['Rfc'];
            $sello5 = $tfd['UUID'];


            $taxpayer_id = $emisor2; # The RFC of the Emisor
            $invoices = array($sello5); # A list of UUIDs

            }
            }
            

        
            $relacion = "";
            if (isset($request['factura']['relacion'])){
                $relacion = $request['factura']['relacion'];
            } else {
                $relacion = "";
            }

            

            $idvoc =  $invoices[0];

            $url = "https://facturacion.finkok.com/servicios/soap/cancel.wsdl";
            $client = new \SoapClient($url, array('trace' => 1));
            $uuids = array("UUID" => "$idvoc", "Motivo" => $request['factura']['motivo'], "FolioSustitucion" => $relacion);
            $uuid_ar = array('UUID' => $uuids);
             
            $params = array("UUIDS"=>$uuid_ar,
                            "username" => $username,
                            "password" => $password,
                            "taxpayer_id" => "$taxpayer_id",
                            "cer" => $cer_content,
                            "key" => $key_content);
             
         
      
            $response = $client->__soapCall("cancel", array($params));
            //$response = \Response::json($response);
            //return $response;
           

            # Generación de archivo .xml con el Request de timbrado
            $file = fopen(public_path().'/facturas/'."Cancel-$idvoc.xml", "a");
            fwrite($file, $client->__getLastRequest() . "\n");
            fclose($file);


            if ($response->cancelResult->Folios->Folio->EstatusUUID == 202){
                $resp = "202 - Cancelacion exitosa";
                $factAct = Factura::findOrFail($request['factura_id']);
                $factAct->acuse = "Cancel-$idvoc.xml";
                $factAct->estado = $resp;
                $factAct->save();
	        } else {
	            $resp = $response->cancelResult->CodEstatus;
	            $factAct = Factura::findOrFail($request['factura_id']);
                $factAct->estado = $resp;
                $factAct->save();
            }


            return [
                'id'=> $request['factura_id'] 
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
}
