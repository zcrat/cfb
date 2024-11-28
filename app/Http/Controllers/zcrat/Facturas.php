<?php

namespace App\Http\Controllers\zcrat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Empresa;
use App\Models\Articulo;

class Facturas extends Controller
{

    public function facturas(){
        $empresas = Empresa::select('id','nombre')->get();
        $articulos=Articulo::select('id','descripcion')->get();
        $elementostotales = Factura::with(['empresa:id,nombre'])->has('empresa')->count();
        $cfdi = [
            ['id' => "G01", 'nombre' => "G01 - Adquisición de mercancías"],
            ['id' => "G02", 'nombre' => "G02 - Devoluciones, descuentos o bonificaciones"],
            ['id' => "G03", 'nombre' => "G03 - Gastos en general"],
            ['id' => "I01", 'nombre' => "I01 - Construcciones"],
            ['id' => "I02", 'nombre' => "I02 - Mobiliario y equipo de oficina por inversiones"],
            ['id' => "I03", 'nombre' => "I03 - Equipo de transporte"],
            ['id' => "I04", 'nombre' => "I04 - Equipo de cómputo y accesorios"],
            ['id' => "I05", 'nombre' => "I05 - Dados, troqueles, moldes, matrices y herramental"],
            ['id' => "I06", 'nombre' => "I06 - Comunicaciones telefónicas"],
            ['id' => "I07", 'nombre' => "I07 - Comunicaciones satelitales"],
            ['id' => "I08", 'nombre' => "I08 - Otra maquinaria y equipo"],
            ['id' => "D01", 'nombre' => "D01 - Honorarios médicos, dentales y gastos hospitalarios"],
            ['id' => "D02", 'nombre' => "D02 - Gastos médicos por incapacidad o discapacidad"],
            ['id' => "D03", 'nombre' => "D03 - Gastos funerales"],
            ['id' => "D04", 'nombre' => "D04 - Donativos"],
            ['id' => "D05", 'nombre' => "D05 - Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación)"],
            ['id' => "D06", 'nombre' => "D06 - Aportaciones voluntarias al SAR"],
            ['id' => "D07", 'nombre' => "D07 - Primas por seguros de gastos médicos"],
            ['id' => "D08", 'nombre' => "D08 - Gastos de transportación escolar obligatoria"],
            ['id' => "D09", 'nombre' => "D09 - Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensión"],
            ['id' => "D10", 'nombre' => "D10 - Pagos por servicios educativos (colegiaturas)"],
            ['id' => "P01", 'nombre' => "P01 - Por definir"]
        ];
        $formapago= [
            ['id' => '01', 'nombre' => '01 - Efectivo'],
            ['id' => '02', 'nombre' => '02 - Cheque nominativo'],
            ['id' => '03', 'nombre' => '03 - Transferencia electrónica de fondos'],
            ['id' => '04', 'nombre' => '04 - Tarjeta de crédito'],
            ['id' => '05', 'nombre' => '05 - Monedero Electrónico'],
            ['id' => '06', 'nombre' => '06 - Dinero electrónico'],
            ['id' => '08', 'nombre' => '08 - Vales de despensa'],
            ['id' => '12', 'nombre' => '12 - Dación en pago'],
            ['id' => '13', 'nombre' => '13 - Pago por subrogación'],
            ['id' => '14', 'nombre' => '14 - Pago por consignación'],
            ['id' => '15', 'nombre' => '15 - Condonación'],
            ['id' => '17', 'nombre' => '17 - Compensación'],
            ['id' => '23', 'nombre' => '23 - Novación'],
            ['id' => '24', 'nombre' => '24 - Confusión'],
            ['id' => '25', 'nombre' => '25 - Remisión de deuda'],
            ['id' => '26', 'nombre' => '26 - Prescripción o caducidad'],
            ['id' => '27', 'nombre' => '27 - A satisfacción del acreedor'],
            ['id' => '28', 'nombre' => '28 - Tarjeta de débito'],
            ['id' => '29', 'nombre' => '29 - Tarjeta de servicios'],
            ['id' => '99', 'nombre' => '99 - Por definir.']
        ];
        $tcomprobante = [
            ['id' => 'I', 'nombre' => 'I - Factura'],
            ['id' => 'E', 'nombre' => 'E - Nota de crédito'],
            ['id' => 'N', 'nombre' => 'N - Nómina']
        ];
        $timpuesto = [
            ['id' => '1', 'nombre' => 'Sin Impuesto Local'],
            ['id' => '2', 'nombre' => 'Inspección, Vigilancia, Control'],
            ['id' => '3', 'nombre' => 'Impuesto Cedular'],
            ['id' => '4', 'nombre' => 'Impuesto Sobre Remuneraciones al Trabajo Personal No Subordinado (RTP)'],
            ['id' => '5', 'nombre' => 'Impuesto Sobre Nómina']
        ];
        $moneda = [
            ['id' => 'MXN', 'nombre' => 'MXN - PESOS'],
            ['id' => 'USD', 'nombre' => 'USD - DÓLARES'],
            ['id' => 'EUR', 'nombre' => 'EUR - EUROS']
        ];
        $metodopago = [
            ['id' => 'PUE', 'nombre' => 'PUE - Pago en una sola exhibición'],
            ['id' => 'PPD', 'nombre' => 'PPD - Pago en parcialidades o diferidos']
        ];
        
        
        return view('facturacion.facturas', compact('elementostotales','empresas','cfdi','formapago','tcomprobante','timpuesto','moneda','metodopago','articulos'));    
    }
    public function obtenerfacturas(){
        $facturas = Factura::has('empresa')->get();
        libxml_use_internal_errors(true); // Manejo interno de errores XML

        $cfdiNamespace = 'http://www.sat.gob.mx/cfd/3';
        $tfdNamespace = 'http://www.sat.gob.mx/TimbreFiscalDigital';

        foreach ($facturas as $fac) {
            $archivoname = public_path() . '/facturas/' . $fac->xml;
            try {
                $xml = new \SimpleXMLElement($archivoname, null, true);
                // Registrar namespaces para las consultas XPath
                $xml->registerXPathNamespace('cfdi', $cfdiNamespace);
                $xml->registerXPathNamespace('tfd', $tfdNamespace);

                // Extraer información relevante
                $comprobante = $xml->xpath('//cfdi:Comprobante')[0] ?? null;
                $receptor = $xml->xpath('//cfdi:Comprobante//cfdi:Receptor')[0] ?? null;
                $timbre = $xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital')[0] ?? null;

                if (!$comprobante || !$receptor || !$timbre) {
                    // Información incompleta en el XML, asignar valores de error
                    $fac->rfc = 'ERROR';
                    $fac->razon_social = 'ERROR';
                    $fac->folio = '0';
                    $fac->total= '0';
                    continue;
                }else{

                // Asignar valores extraídos
                $fac->rfc = (string) $receptor['Rfc'];
                $fac->razon_social = (string) $receptor['Nombre'];
                $fac->folio = (string) ($comprobante['Serie'] . $comprobante['Folio']);
                $fac->total = (float) $comprobante['Total'];}
                } catch (\Exception $e) {
                    $fac->rfc = 'ERROR';
                    $fac->razon_social = 'ERROR';
                    $fac->folio = '0';
                    $fac->total= '0';
                continue;
            }

            
        }
        return response()->json(['facturas'=>$facturas]);
    }
    public function obtenerproductos(){
        
        $productos=Articulo::get();
        
        return response()->json($productos);
        }
    public function obtenerarticulo(Request $request){
        $id =$request->input('id');
        $articulo=Articulo::where('id',$id)->first();
        
        return response()->json($articulo);
    }
}