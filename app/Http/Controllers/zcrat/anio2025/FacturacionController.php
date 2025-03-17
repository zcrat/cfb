<?php

namespace App\Http\Controllers\zcrat\anio2025;

use Illuminate\Http\Request;
use App\Factura;
use App\Classes\Facturar;
use App\User;
use App\presupuestosCFE;
use App\presupuestos;
use App\presupuestos2023;
use App\anexosForaneos;
use DB;
use App\DetalleFactura;
use App\FacturasEmisor;
use App\Classes\Certificados;
use App\Classes\CvHandler;
use App\Pagos;
use App\DetallePagos;
use App\Contratos;
use App\Empresa;
use App\FacturasSave;
use App\FacturasSaveDetalle;
use App\pCFEConceptos;
use App\Sucursales;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class FacturacionController extends Controller
{
    public function store(Request $request)
    {
        
        $logotipo = '';
        $emisorid = $request->emisor_id; 

        if($emisorid == 2){
            $logotipo = 'logo_akumas_fct.png';
        } 
        else if($emisorid == 3){
            $logotipo = 'logo_kmg.jpeg';
        }
        else {
            $logotipo = 'logo_cfb_fact.png';
            $emisorid = 1;
        }

        $dato = [];

        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            $factura = new Factura();
            $factura->empresa_id = $request->factura['empresa_id'];
            $factura->emisor_id = $emisorid;
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

               
                
            }  

            $presupuesto = $request->presupuesto;
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

            
            $texto1="CONTRATO: ".$request->factura['contrato']." \n ECONOMICO: ".$pres->identificador." \n  PLACAS: ".$pres->placas." \n KILOMETRAJE: ".$pres->kilometraje." \n FOLIO: ".$pres->NSolicitud;

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
            ->where('detalle_facturas.factura_id','=',$factura->id)->orderBy('detalle_facturas.id', 'asc')
            ->paginate(100);

            Log::info($detalles_todo);
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
             
 
            try {

                $client = new \SoapClient('https://facturacion.finkok.com/servicios/soap/stamp.wsdl');
            } catch (SoapFault $e) {
                return response()->json(['error' => 'No se pudo conectar con el servicio.'], 500);
            }
            $params = array(
            "xml" => $xml_content,
            "username" => $username,
            "password" => $password
            );

            LOG::INFO('empiesa la facturacion');
            LOG::INFO($params);
            $response = $client->__soapCall("stamp", array($params));
            //print_r($response);
            $response2 = \Response::json($response);
            //return $response;
          LOG::INFO($response2);
           if ($response->stampResult->UUID == ''){
           return $response->stampResult->Incidencias->Incidencia->MensajeIncidencia;
        	} else {
                 
           $folionvo = $factura_emisor->folio + 1;		
           $nombre = public_path().'/facturas/'.$factura_emisor->serie."".$folionvo."-".$factura_emisor->rfc."-".$response->stampResult->UUID.".xml";

          
         
           $file = fopen($nombre, "a");
           fwrite($file, $response->stampResult->xml);
           fclose($file);

           $pdfarch = $cfdi->generarPDF($nombre,$logotipo,$texto1);

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
           $cotizacion->status = 5;
           $cotizacion->save();    
          
        	}
           
            DB::commit();
            return response()->json(['success' => 'Se Facturo Correctamente'], 200);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Los Datos No Coinciden Con El Formato'], 499);
        }
    }
    public function storemas(Request $request)
    {
        $logotipo = '';
        $emisorid = $request->emisor_id; 

        if($emisorid == 2){
            $logotipo = 'logo_akumas_fct.png';
        } 
        else if($emisorid == 3){
            $logotipo = 'logo_kmg.jpeg';
        }
        else {
            $logotipo = 'logo_cfb_fact.png';
            $emisorid = 1;
        }

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
               
                  //array_push($z);
                
            } 

            $factura = new Factura();
            $factura->empresa_id = $request->factura['empresa_id'];
            $factura->emisor_id = $emisorid;
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

           $pdfarch = $cfdi->generarPDFmas($nombre,$logotipo,$texto1);

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
                $cotizacion->status = 5;
                $cotizacion->save();
                
                log::info($cotizacion->id);
            } 

             }
           
            DB::commit();
            ob_clean();
            return response()->json(['success' => 'Se Facturo todos los presupuestos Correctamente'], 200);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e], 500);
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
            $factura->id_anio_correspondiente = $request->anio_id;
            $factura->sucursal_id = $request->sucursal_id;
            $factura->modulo_id = $request->modulo_id;
            $factura->contrato_id = Sucursales::where('id',$request->sucursal_id)->value('contratos_id');
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
            return response()->json(['success' => 'Se Guardo La Prefactura'], 200);
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function Obtenermultipledetalles(Request $request){

        if (!$request->ajax()) return redirect('/');

        $ids = $request->ids;

         $detalles = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.identificador as economico','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->whereIn('presupuestosCFE.id',$ids)->get();

            if($request->has('contrato')){
                $contrato=Contratos::where('id',Sucursales::where('nombre', $request->contrato)->value('contratos_id'))->value('numero');
                return response()->json(['detalles' => $detalles,'contrato'=>$contrato],200);
            }
            return response()->json(['detalles' => $detalles], 200);
    }
    public function Obtenermultipledetallesprefactura(Request $request){

        if (!$request->ajax()) return redirect('/');
        $id = $request->id ;
        $prefactura=FacturasSave::find($id);
        $empresa=Empresa::find($prefactura->empresa_id);
        $detalles = FacturasSaveDetalle::select('*', 'importep as importe')
    ->where('facturas_save_id', $id)
    ->get();

        $contrato=Contratos::find($prefactura->contrato_id)->value('numero');
        return response()->json(['detalles' => $detalles,'prefactura'=>$prefactura,'empresa'=>$empresa,'contrato'=>$contrato],200);
    }
    public function deleteprefactura(Request $request)
    {
        $cotizacion = FacturasSave::findOrFail($request->id);
        $cotizacion->delete();
        return response()->json(['success' => "Se Elimino Correctamente La Prefactura"]);
    }
    public function facturapdf(Request $request)
    {
        try {
            $pdf=Factura::findorfail($request->id);
        
        return response()->json(['success' => $pdf->pdf]);
        } catch (\Exception $e) {
            return response()->json(['errors' => "No Se Pudo Encontrar El PDF de La Factura"],500);
        }
    
    }
    public function facturaxml(Request $request)
    {
        try {
            $xml=Factura::findorfail($request->id);
        return response()->json(['success' => $xml->xml]);
        } catch (\Exception $e) {
            return response()->json(['errors' => "No Se Pudo Encontrar El PDF de La Factura"],500);
        }
    
    }


    public function obtenerprefacturas(Request $request)
    {
        $prefacturas = FacturasSave::with('usuario','cliente')->where('modulo_id',$request->modulo)->where('id_anio_correspondiente',$request->anio)->where('sucursal_id',$request->sucursal)->where('contrato_id',Sucursales::where('id',$request->sucursal)->value('contratos_id'))->get();
 
        return collect(['prefacturas' => $prefacturas]);
    }

    public function cancelarfactura(Request $request)
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
            Log::info($factura_emisor);

            $numero_certificado = $factura_emisor->n_certificado;
            $archivo_cer = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_cer;
            $archivo_key = public_path().'/utilerias/certificados/'.$factura_emisor->archivo_key;
            Log::info($archivo_cer);
            Log::info($archivo_key);
            $username = 'facturacion@aurumfixmotors.com';
            $password = 'Akumas2019##';
            # Generar el certificado y llave en formato .pem
            shell_exec("openssl x509 -inform DER -outform PEM -in ".$archivo_cer." -pubkey -out ".public_path()."/utilerias/certificados/certificado.pem");
            shell_exec("openssl pkcs8 -inform DER -in ".$archivo_key." -passin pass:".$factura_emisor->clave_key." -out ".public_path()."/utilerias/certificados/llave.key.pem");
            shell_exec("openssl rsa -in ".public_path()."/utilerias/certificados/llave.key.pem -des3 -out ".public_path()."/utilerias/certificados/llave.enc -passout pass:".$password);


            $cer_path = public_path()."/utilerias/certificados/certificado.pem"; 
            Log::info($cer_path);
            $cer_file = fopen($cer_path, "r");
            $cer_content = fread($cer_file, filesize($cer_path));
            fclose($cer_file);
            log::info("Certificado generado correctamente");
            $key_path = public_path()."/utilerias/certificados/llave.enc";
            Log::info($cer_path);
            $key_file = fopen($key_path, "r");
            $key_content = fread($key_file,filesize($key_path));
            fclose($key_file);  

           
           
            $xml = new \SimpleXMLElement (public_path().'/facturas/'.$factura_emisor->xml,null,true);
            Log::info($xml);
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
            

            Log::info($request['factura']);
            $relacion = "";
            if (isset($request['factura']['relacion'])){
                $relacion = $request['factura']['relacion'];
            } else {
                $relacion = "";
            }
          
            log::INFO("EMPIEZA EL PROCESO");
            $idvoc =  $invoices[0];
            Log::info($invoices);
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
             
         
            log::info($params);
            Log::info($uuids);
            $response = $client->__soapCall("cancel", array($params));
            $response2 = \Response::json($response);
            //return $response;
           

            # Generación de archivo .xml con el Request de timbrado
            $file = fopen(public_path().'/facturas/'."Cancel-$idvoc.xml", "a");
            fwrite($file, $client->__getLastRequest() . "\n");
            fclose($file);


          
               log::info($file);
               log::info($response2);
	            $resp = $response->cancelResult->Folios->Folio->EstatusCancelacion;
                $factAct = Factura::findOrFail($request['factura_id']);
                $factAct->acuse = "Cancel-$idvoc.xml";
                $factAct->estado = $resp;
                $factAct->save();

                $ids = presupuestosCFE::where('factura_id', $request['factura_id'])->pluck('id');
                presupuestosCFE::whereIn('id', $ids)->update(['status' => 4]);
                
            return [
                'id'=> $request['factura_id'] 
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

}
