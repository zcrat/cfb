<?php require_once('../Connections/sisnet.php'); ?>
<?php


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}



 
date_default_timezone_set('America/Mexico_City');
include("certificados.php");
include("numerosletras.php");

/**
 * Descripción: Ejemplo del uso de la clase FacturacionModerna, generando un
 * archivo XML de un CFDI 3.3 y enviandolo a certificar.
 *
 * Nota: Esté ejemplo pretende ilustrar de manera general el proceso de sellado y
 * timbrado de un XML que cumpla con los requerimientos del SAT.
 * 
 * Facturación Moderna :  (http://www.facturacionmoderna.com)
 * @author Ivan Aquino <ivan.aquino@facturacionmoderna.com>
 * @package FacturacionModerna
 * @version 1.0
 */

pruebaTimbrado();

/**
 * Prueba de timbrado con la conexion a Facturacion Moderna
 * @return void
 */
function pruebaTimbrado() {
	
	global $database_sisnet, $sisnet;
	mysql_select_db($database_sisnet, $sisnet);
$query_archivos = "SELECT * FROM tblarchivos WHERE idarchivo = 1";
$archivos = mysql_query($query_archivos, $sisnet) or die(mysql_error());
$row_archivos = mysql_fetch_assoc($archivos);
$totalRows_archivos = mysql_num_rows($archivos);
    /**
    * Niveles de debug:
    * 0 - No almacenar
    * 1 - Almacenar mensajes SOAP en archivo log.
    */
    
    $debug = 1;
    
    // RFC utilizado para el ambiente de pruebas
    $rfc_emisor = $row_archivos['rfc'];
    
    /**
     * Archivos del CSD de prueba proporcionados por el SAT.
     * Ver http://developers.facturacionmoderna.com/webroot/CertificadosDemo-FacturacionModerna.zip
     */
    $numero_certificado = $row_archivos['ncertificado'];
    $archivo_cer = "utilerias/certificados/".$row_archivos['archivocer'];
    $archivo_pem = "utilerias/certificados/".$row_archivos['archivokey'];
    

    // generar y sellar un XML con los CSD de pruebas
	$cfdi = generarXML($row_archivos['rfc']);
	$keypem = new Certificados();
	$keypem->generaKeyPem($archivo_pem,$row_archivos['clavekey']);



    $cfdi = sellarXML($cfdi, $numero_certificado, $archivo_cer,$archivo_pem.'.pem');
	file_put_contents('factura.xml',$cfdi);
	
	
	# Username and Password, assigned by FINKOK
$username = 'facturacion@aurumfixmotors.com';
$password = 'Akumas2019##';

# Read the xml file and encode it on base64
$invoice_path = "factura.xml";
$xml_file = fopen($invoice_path, "rb");
$xml_content = fread($xml_file, filesize($invoice_path));
fclose($xml_file);

 
# In newer PHP versions the SoapLib class automatically converts FILE parameters to base64, so the next line is not needed, otherwise uncomment it
#$xml_content = base64_encode($xml_content);

# Consuming the stamp service
$url = "https://facturacion.finkok.com/servicios/soap/stamp.wsdl";
$client = new SoapClient($url);
 
$params = array(
  "xml" => $xml_content,
  "username" => $username,
  "password" => $password
);
$response = $client->__soapCall("stamp", array($params));
#print_r($response);

# Generación de archivo .xml con la respuesta del web service
####mostrar el XML timbrado solamente, este se mostrara solo si el XML ha sido timbrado o recibido satisfactoriamente.
####mostrar el código de error en caso de presentar alguna incidencia
#print $response->stampResult->UUID;
####mostrar el mensaje de incidencia en caso de presentar alguna
#print $response->stampResult->Incidencias->Incidencia->MensajeIncidencia;

if ($response->stampResult->UUID == ""){
	echo $response->stampResult->Incidencias->Incidencia->MensajeIncidencia;
	} else {
		
global $database_sisnet, $sisnet;

		
$foliox = $row_archivos['folio']+1;		
$nombre = "comprobantes/".$row_archivos['serie']."".$foliox."-".$row_archivos['rfc']."-".$response->stampResult->UUID.".xml";
$file = fopen($nombre, "a");
fwrite($file, $response->stampResult->xml);
fclose($file);


mysql_select_db($database_sisnet, $sisnet);
$query_clientes = "SELECT * FROM tblclientes WHERE idcliente = ".$_SESSION['idcliente'];
$clientes = mysql_query($query_clientes, $sisnet) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);

 $insertSQL = sprintf("INSERT INTO tblfacturas (cliente, archivoxml, archivopdf) VALUES (%s, %s, %s)",
                       GetSQLValueString($row_clientes['strnombre']." ".$row_clientes['strrfc'], "text"),
                       GetSQLValueString($nombre, "text"),
                       GetSQLValueString(generarPDF($nombre), "text"));

  mysql_select_db($database_sisnet, $sisnet);
  $Result1 = mysql_query($insertSQL, $sisnet) or die(mysql_error());
  
  
  
  $insertSQL2 = sprintf("UPDATE tblarchivos SET folio=%s WHERE idarchivo=1",
                       GetSQLValueString($foliox, "int"));

  mysql_select_db($database_sisnet, $sisnet);
  $Result12 = mysql_query($insertSQL2, $sisnet) or die(mysql_error());
   
   
  
  $insertGoTo = "facturas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
	}
}

/**
 * Sellar el comprobante
 * @param  string $cfdi               XML a sellar
 * @param  string $numero_certificado Numero del certificado
 * @param  string $archivo_cer        Ruta del archivo .cer
 * @param  string $archivo_pem        Ruta del archivo .pem
 * @return string                     XML sellado
 */
 

 
function sellarXML($cfdi, $numero_certificado, $archivo_cer, $archivo_pem) {
	
    $private = openssl_pkey_get_private(file_get_contents($archivo_pem));
    $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($archivo_cer)));

    $xdoc = new DomDocument();
    $xdoc->loadXML($cfdi) or die("XML invalido");

    $c = $xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0); 
    $c->setAttribute('Certificado', $certificado);
    $c->setAttribute('NoCertificado', $numero_certificado);

    $XSL = new DOMDocument();
    $XSL->load('utilerias/xslt33/cadenaoriginal_3_3.xslt');
    
    $proc = new XSLTProcessor;
    $proc->importStyleSheet($XSL);

    $cadena_original = $proc->transformToXML($xdoc);
    openssl_sign($cadena_original, $sig, $private, OPENSSL_ALGO_SHA256);
    $sello = base64_encode($sig);

    $c->setAttribute('Sello', $sello);
    
		return $xdoc->saveXML();
}


/**
 * Generar el xml basico para el trimbrado
 * @param  string $rfc_emisor RFC del emisor
 * @return string XML valido
 */
 
 
 
 
function generarXML ($rfc_emisor) {
	
if (!isset($_SESSION)) {
  session_start();
}

global $database_sisnet, $sisnet;


mysql_select_db($database_sisnet, $sisnet);
$query_clientes = "SELECT * FROM tblclientes WHERE idcliente =".$_SESSION['idcliente'];
$clientes = mysql_query($query_clientes, $sisnet) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);


mysql_select_db($database_sisnet, $sisnet);
$query_archivos = "SELECT * FROM tblarchivos WHERE idarchivo = 1";
$archivos = mysql_query($query_archivos, $sisnet) or die(mysql_error());
$row_archivos = mysql_fetch_assoc($archivos);
$totalRows_archivos = mysql_num_rows($archivos);




mysql_select_db($database_sisnet, $sisnet);
$query_sucursales = "SELECT * FROM tblsucursales WHERE tblsucursales.idsucursal = 1";
$sucursales = mysql_query($query_sucursales, $sisnet) or die(mysql_error());
$row_sucursales = mysql_fetch_assoc($sucursales);
$totalRows_sucursales = mysql_num_rows($sucursales);
	
$colname_compra = "-1";
if (isset($_GET['id'])) {
  $colname_compra = $_GET['id'];
}
mysql_select_db($database_sisnet, $sisnet);
$query_compra = sprintf("SELECT * FROM presupuestoCFE WHERE id = %s", GetSQLValueString($colname_compra, "int"));
$compra = mysql_query($query_compra, $sisnet) or die(mysql_error());
$row_compra = mysql_fetch_assoc($compra);
$totalRows_compra = mysql_num_rows($compra);


$colname_conceptos = $row_compra['id'];

mysql_select_db($database_sisnet, $sisnet);
$query_conceptos = sprintf("SELECT ca.id, se.num,ca.pCFEConcepto_id, ca.cantidad, ca.precio, ca.retencion_iva, ca.retencion_isr, se.descripcion, se.pCFECategorias_id, c.titulo, c.num, se.codigo_sat, se.codigo_unidad, se.unidad_text   FROM pCFECarrito as ca INNER JOIN pCFEConceptos as se ON ca.pCFEConcepto_id = se.id INNER JOIN pCFECategorias as c ON se.pCFECategorias_id = c.id  WHERE ca.presupuestoCFE_id =%s ORDER BY se.pCFECategorias_id ", GetSQLValueString($colname_conceptos, "int"));
$conceptos = mysql_query($query_conceptos, $sisnet) or die(mysql_error());
$row_conceptos = mysql_fetch_assoc($conceptos);
$totalRows_conceptos = mysql_num_rows($conceptos);	
	
	
$fecha_actual = substr( date('c'), 0, 19);


	
$noCertificado = $row_archivos['ncertificado'];
$fact_serie = $row_archivos['serie'];
$fact_folio = $row_archivos['folio'];
$NoFac = $fact_serie.$fact_folio;
$fact_tipcompr = $_GET['tipo_comprobante'];
$tasa_iva = 16;	
$descuento = "0.00";
$fecha_fact = date("Y-m-d")."T".date("H:i:s");
$NumCtaPago = "6473";
$condicionesDePago = "CONDICIONES";
$formaDePago = $_GET['fpago'];
$metodoDePago = $_GET['mpago'];
$TipoCambio = 1;
$LugarExpedicion = $row_archivos['codigo'];
$moneda = $_GET['moneda'];
	
  
$xml = new DOMDocument('1.0', 'utf-8');
$root = $xml->createElement("cfdi:Comprobante");
$root = $xml->appendChild($root);

$cadena_original='||';
$noatt=array();

cargaAtt($root,array("xmlns:cfdi" => "http://www.sat.gob.mx/cfd/3",
                     "xmlns:xs" => "http://www.w3.org/2001/XMLSchema-instance",
					 "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
                     "xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd"
		
         )
);

date_default_timezone_set('America/Mexico_City');
       
if ($_GET['tipo_comprobante']=='E'){

	foreach ($_POST['atiporelacion']  as $key => $value) {
    $tipo = $value;
		$uuid = $_POST['auuid'][$key]; 
		

	$relacionados = $xml->createElement("cfdi:CfdiRelacionados");
	$relacionados = $root->appendChild($relacionados);
	cargaAtt($relacionados, array("TipoRelacion" => $tipo
						)
					);


					$relacionado = $xml->createElement("cfdi:CfdiRelacionado");
					$relacionado = $relacionados->appendChild($relacionado);
					cargaAtt($relacionado, array("UUID" => $uuid
										)
									);		
									
								}

}

    $emisor = $xml->createElement("cfdi:Emisor");
    $emisor = $root->appendChild($emisor);
    cargaAtt($emisor, array("Rfc" => $row_archivos['rfc'],
							"Nombre" => $row_archivos['nombre'],
							"RegimenFiscal" => $row_archivos['regimen']
							)
						);
	
  
						
    $receptor = $xml->createElement("cfdi:Receptor");
    $receptor = $root->appendChild($receptor);
	//$emisor->appendChild($expedido);
    cargaAtt($receptor, array
	("Rfc"=>$row_clientes['strrfc'],
	  "Nombre"=>$row_clientes['strnombre'],
	    "UsoCFDI"=>$_GET['uso_cfdi']
	    )
	 );
    // }}}

    $conceptos1 = $xml->createElement("cfdi:Conceptos");  //Crear arreglo de conceptos para agregar al documento, reemplazar los valores en la cargaAtt
    $conceptos1 = $root->appendChild($conceptos1);
	$subtotal = 0;
   do{  
     
       $pproducto = number_format($row_conceptos['precio'], 2, '.', ''); 
	   $cantidad =  number_format($row_conceptos['cantidad'], 6, '.', '');
	   $tp = number_format($cantidad*$pproducto, 2, '.', '');
	   echo $cantidad;
	   echo "<br />";
	   echo $tp;
	   echo "<br />";
	   $subtotal += $tp;
	   $triva = number_format($triva + ($tp*$row_conceptos['retencion_iva']), 2, '.', '');
	   $trisr = number_format($trisr + ($tp*$row_conceptos['retencion_isr']), 2, '.', '');
	   
		   
	   $concepto = $xml->createElement("cfdi:Concepto");
	   $concepto = $conceptos1->appendChild($concepto);
	   cargaAtt($concepto, array(
		"ClaveProdServ"=> $row_conceptos['codigo_sat'],
		"NoIdentificacion"=> $row_conceptos['pCFEConcepto_id'],
		"Cantidad"=> $cantidad,
		 "ClaveUnidad"=> $row_conceptos['codigo_unidad'],
		 "Unidad"=> $row_conceptos['unidad_text'],
		 "Descripcion"=>  $row_conceptos['descripcion'],
		 "ValorUnitario"=> $pproducto ,
		 "Importe"=>$tp,
		 "Descuento"=> 0));
		  $impuestos = $xml->createElement("cfdi:Impuestos");
		  $impuestos = $concepto->appendChild($impuestos);
			   $traslados = $xml->createElement("cfdi:Traslados");
			   $traslados = $impuestos->appendChild($traslados);
					$traslado = $xml->createElement("cfdi:Traslado");
					$traslado = $traslados->appendChild($traslado);
					cargaAtt($traslado,array(
						"Base"=>$tp,
						"Impuesto"=>"002",
						"TipoFactor"=>"Tasa",
						"TasaOCuota"=>"0.160000",
						"Importe"=>$tp*0.16)
						);
			   $retenciones = $xml->createElement("cfdi:Retenciones");
			   $retenciones = $impuestos->appendChild($retenciones);
 
						$retencion = $xml->createElement("cfdi:Retencion");
						$retencion = $retenciones->appendChild($retencion);
						cargaAtt($retencion,array(
						   "Base"=>$tp,
						   "Impuesto"=>"001",
						   "TipoFactor"=>"Tasa",
						   "TasaOCuota"=>$row_conceptos['retencion_isr'],
						   "Importe"=>number_format($tp*$row_conceptos['retencion_isr'], 2, '.', ''))
						  );	   
 
						$retencion2 = $xml->createElement("cfdi:Retencion");
						$retencion2 = $retenciones->appendChild($retencion2);
						cargaAtt($retencion2,array(
							"Base"=>$tp,
							"Impuesto"=>"002",
							"TipoFactor"=>"Tasa",
							"TasaOCuota"=>$row_conceptos['retencion_iva'],
							"Importe"=>number_format($tp*$row_conceptos['retencion_iva'], 2, '.', ''))
						   );	
   
  } while ($row_conceptos = mysql_fetch_assoc($conceptos));
	  
	  $foliox = $row_archivos['folio']+1;
	  
	  
	 cargaAtt($root, array(
		"Version" => "3.3", 
		"Serie" => $row_archivos['serie'],
		"Folio" => $foliox, 
		"Fecha" =>date("Y-m-d")."T".date("H:i:s"),
		"Sello" => "@",
		"FormaPago" => $formaDePago,
		"NoCertificado" => $noCertificado, 
		"Certificado" => "@", 
		"CondicionesDePago" => $condicionesDePago,
		"SubTotal" => number_format($subtotal, 2, '.', ''),
		"Descuento" => 0.0,
		"Moneda" => $moneda,
		"Total" => number_format(($subtotal*1.160000)-$triva-$trisr, 2, '.', ''),
		"TipoDeComprobante" => $fact_tipcompr,
		"MetodoPago" => $metodoDePago,
		"LugarExpedicion" => $LugarExpedicion
		)
); 
	  
 
  
$impuestos1 = $xml->createElement("cfdi:Impuestos");
$impuestos1 = $root->appendChild($impuestos1);
cargaAtt($impuestos1,array(
		 "TotalImpuestosRetenidos"=>number_format($triva+$trisr, 2, '.', ''),
		 "TotalImpuestosTrasladados"=>number_format($subtotal*0.160000, 2, '.', ''))
		 );

		 $retenciones1 = $xml->createElement("cfdi:Retenciones");
		 $retenciones1 = $impuestos1->appendChild($retenciones1);

				  $retencion1 = $xml->createElement("cfdi:Retencion");
				  $retencion1 = $retenciones1->appendChild($retencion1);
				  cargaAtt($retencion1,array(
					 "Impuesto"=>"001",
					 "Importe"=>$trisr)
					);	   

				  $retencion3 = $xml->createElement("cfdi:Retencion");
				  $retencion3 = $retenciones1->appendChild($retencion3);
				  cargaAtt($retencion3,array(
					  "Impuesto"=>"002",
					  "Importe"=>$triva)
					 );	   


   $traslados1 = $xml->CreateElement("cfdi:Traslados");
   $traslados1 = $impuestos1->appendChild($traslados1);
	   $traslado1 = $xml->CreateElement("cfdi:Traslado");
	   $traslado1 = $traslados1->appendChild($traslado1);
	   cargaAtt($traslado1,array(
				"Impuesto"=>"002",
				"TipoFactor"=>"Tasa",
				"TasaOCuota"=>"0.160000",
				"Importe"=>number_format($subtotal*0.160000, 2, '.', ''))
			   );
	 
    

    return $xml->saveXML();
}


function cargaAtt(&$nodo, $attr) {
global $xml, $sello;
$quitar = array('sello'=>1,'noCertificado'=>1,'certificado'=>1);
foreach ($attr as $key => $val) {
    for ($i=0;$i<strlen($val); $i++) {
        $a = substr($val,$i,1);
        if ($a > chr(127) && $a !== chr(219) && $a !== chr(211) && $a !== chr(209)) {
            $val = substr_replace($val, ".", $i, 1);
        }
    }
    $val = preg_replace('/\s\s+/', ' ', $val);   // Regla 5a y 5c
    $val = trim($val);                           // Regla 5b
    if (strlen($val)>0) {   // Regla 6
        $val = str_replace(array('"','>','<'),"'",$val);  // &...;
        $val = utf8_encode(str_replace("|","/",$val)); // Regla 1
        $nodo->setAttribute($key,$val);
    }
}
}

function generarPNG($nombre,$requiere){
	
include 'phpqrcode/qrlib.php';

$file = $nombre.'.png';
// Los datos del CFDI que llevará (Revisar anexo 20 para los detalles del texto del codigo QR).
$data = $requiere;
 
// Y generamos la imagen (Revisar el Anexo 20 para verificar los detalles del archivo de imagen).
QRcode::png($data, $file,4,3);
	
	
	}


function generarPDF($nombrexml){

	$GLOBALS["nombrexml"] = $nombrexml;

	require('mc_table2.php');
class PDF extends PDF_MC_Table
{
//Constructor (mandatory with PHP3)

//Page header
function Header()
{

	
	$xml = new SimpleXMLElement ($GLOBALS["nombrexml"],null,true);
	$ns = $xml->getNamespaces(true);
	$xml->registerXPathNamespace('c', $ns['cfdi']);
	$xml->registerXPathNamespace('t', $ns['tfd']);
	foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
			$cfdi = $cfdiComprobante['LugarExpedicion'];
			$cfdi1 = $cfdiComprobante['Serie'];
			$cfdi2 = $cfdiComprobante['Folio'];
			$cfdi3 = $cfdiComprobante['Total'];
			$cfdi4 = $cfdiComprobante['SubTotal'];
			$cfdi8 = $cfdiComprobante['Moneda'];
			$cfdi9 = $cfdiComprobante['MetodoPago'];
			$cfdi10 = $cfdiComprobante['FormaPago'];
			$cfdi11 = $cfdiComprobante['NoCertificado'];

		}


        $this->SetFont('Arial','B',15);
		$this->SetXY(10, 5);
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255,255,255);
		$this->Cell(0,8,"Factura  ".$cfdi1." ".$cfdi2,1,1,"C",true);
		
		// Imprimimos el logo a 300 ppp
		$this->Image('../img/logo_akumas_fct.png',15,15,-250);
		//Line break
		
		$xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
		foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
		$sello4 = $tfd['NoCertificadoSAT'];
		$sello5 = $tfd['UUID'];
		
		foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
		foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
		$emisor1 = $Emisor['Nombre'];
		$emisor2 = $Emisor['Rfc'];
		$emisor3 = $Emisor['RegimenFiscal'];
		$texto1=" ".$Emisor['Nombre']." \n  RFC: ".$Emisor['Rfc']." \n No de serie del Certificado del CSD:".$cfdi11."  \n Folio Fiscal: ".$sello5." \n Regimen: ".rgmen($emisor3);
		$this->SetXY(70, 13);
		$this->SetTextColor(0,0,0);
		$this->SetFont("Arial","",8);
		$this->MultiCell(130,8,$texto1,1,"L");
		
		
		$this->SetXY(150, 13);
		$this->SetTextColor(0,0,0);
		$this->SetFont("Arial","",8);
		$this->MultiCell(50,8,$_GET['observaciones'],1,"L");
		
		
		$this->SetXY(10, 53);
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255,255,255);
		$this->Cell(0,8," DATOS DEL CLIENTE                                                                              EXPEDIDO EN",1,1,"L",true);
		
		$Receptor1 = $Receptor['Nombre'];
		$Receptor2 = $Receptor['Rfc'];
		$Receptor3 = uso($Receptor['UsoCFDI']);
		 $sello1 = $tfd['SelloCFD'];
		 $sello2 = $tfd['SelloSAT'];
		
		$cfdi99 = $tfd['FechaTimbrado'];
		$texto1=" ".$Receptor1." \n RFC:".$Receptor2." \n Uso CFDI:".$Receptor3;
		$this->SetXY(10, 61);
		$this->SetTextColor(0,0,0);
		$this->SetFont("Arial","",8);
		$this->MultiCell(90,5,$texto1,1,"L");
		
		$texto2=" C.P.".$cfdi." \n ".utf8_decode("Fecha y hora de emisión:").$cfdi99;
		$this->SetXY(100, 61);
		$this->SetTextColor(0,0,0);
		$this->SetFont("Arial","",8);
		$this->MultiCell(0,6,$texto2,0,"L");
		}
		}
	  }
		$this->SetXY(10, 80);
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255,255,255);
		$this->SetFont("Arial","B",5);
		$this->Cell(20,6,"CANTIDAD",1,0,"C",true);
		$this->Cell(25,6,"U. MEDIDA",1,0,"C",true);
		$this->Cell(70,6,"DESCRIPCION",1,0,"C",true);
		$this->Cell(25,6,"V. UNITARIO",1,0,"C",true);
		$this->Cell(25,6,"% DESCUENTO",1,0,"C",true);
		$this->Cell(25,6,"IMPORTE",1,1,"C",true);
	

}

//Page footer
function Footer()
{
	$this->SetY(-15);

	
    //Arial italic 8
		$this->SetFont('Arial','I',8);
		$this->Line(10,275,200,275);
				
		$this->Text(10,280,utf8_decode("Este documento es una representación impresa de un CFDI"));
    //Page number
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}
		
		
   $xml = new SimpleXMLElement ($nombrexml,null,true);
	 $ns = $xml->getNamespaces(true);
	 $xml->registerXPathNamespace('c', $ns['cfdi']);
	 $xml->registerXPathNamespace('t', $ns['tfd']);
							
		// Queremos hacer en pdf la factura numero 1 de la tipica BBDD de facturacion
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetMargins(10, 50); 
        $pdf->SetAutoPageBreak(true, 50);
		$pdf->SetFont('Arial','B',12);
		
		
		
		$total=0;
		
		// Los datos (en negro)
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont("Arial","B",5);
	
		
		// aquí le decimos que busque el nodo padre Comprobante y dentro de el busque el nodo Emisor para
		// así encontrar los atributos.
		
			foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Conceptos){  // SECCION EMISOR
			$claveser           = $Conceptos['ClaveProdServ'];
			$claveser           = $Conceptos['ClaveProdServ'];
			$descripcion        = $Conceptos['Descripcion'];
			$claveunidad        = $Conceptos['ClaveUnidad'];
			$unidad        = $Conceptos['Unidad'];
			$cantidad        = $Conceptos['Cantidad'];
			$vunit        = $Conceptos['ValorUnitario'];
			$import        = $Conceptos['Importe'];
		 
			$pdf->SetX(10);
			$pdf->SetWidths(array(20,25,70,25,25,25));
			//un arreglo con alineacion de cada celda
			$pdf->SetAligns(array('C','C','L','C','C','C'));
			//OTro arreglo pero con el contenido
			//utf8_decode es para que escriba bien
			//los acentos. 
			$pdf->Row(array($cantidad,$claveunidad." - ".$unidad,utf8_decode($claveser." - ".$descripcion),amoneda($vunit,"pesos"),0,amoneda($import,"pesos"))); 
			$pdf->ln(2);
			
			}

			foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
					$cfdi = $cfdiComprobante['LugarExpedicion'];
					$cfdi1 = $cfdiComprobante['Serie'];
					$cfdi2 = $cfdiComprobante['Folio'];
					$cfdi3p = $cfdiComprobante['Total'];
					$cfdi4p = $cfdiComprobante['SubTotal'];
					$cfdi8 = $cfdiComprobante['Moneda'];
					$cfdi9 = $cfdiComprobante['MetodoPago'];
					$cfdi10 = $cfdiComprobante['FormaPago'];
					$cfdi11 = $cfdiComprobante['NoCertificado'];
			$xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
			foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
			$sello1 = $tfd['SelloCFD'];
			$sello2 = $tfd['SelloSAT'];
			$sello4 = $tfd['NoCertificadoSAT'];
			$sello5 = $tfd['UUID'];
			$cfdi99 = $tfd['FechaTimbrado'];
			foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Conceptos){  // SECCION EMISOR
					$claveser           = $Conceptos['ClaveProdServ'];
						$claveser           = $Conceptos['ClaveProdServ'];
						$descripcion        = $Conceptos['Descripcion'];
						$claveunidad        = $Conceptos['ClaveUnidad'];
						$unidad        = $Conceptos['Unidad'];
						$cantidad        = $Conceptos['Cantidad'];
						$vunit        = $Conceptos['ValorUnitario'];
						$import        = $Conceptos['Importe'];
				 
				  	}
		   	  	} 	 
						
						}


						foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos') as $C55){  // SECCION EMISOR
							$iva55           = $C55['TotalImpuestosTrasladados'];
							$isr55           = $C55['TotalImpuestosRetenidos'];
						 
							  }		
						
				$pdf->ln(3);
				$ivas = $cfdi3p-$cfdi4p;


				$pdf->SetFont("Arial","B",10);	
				// 4º Los totales, IVAs y demás
				$pdf->SetX(150);
				$pdf->Cell(25,5,"Subtotal:",1,0,"C");
				$pdf->Cell(25,5,amoneda($cfdi4p,"pesos"),1,1,"R");
				$pdf->SetX(150);
				$pdf->Cell(25,5,"IVA (16%): ",1,0,"C");
				$pdf->Cell(25,5,amoneda($iva55,"pesos"),1,1,"R");
				$pdf->SetX(150);
				$pdf->Cell(25,5,"Retenciones: ",1,0,"C");
				$pdf->Cell(25,5,amoneda($isr55,"pesos"),1,1,"R");
				$pdf->SetX(150);
				$pdf->Cell(25,5,"Total:",1,0,"C");
				$pdf->Cell(25,5,amoneda($cfdi3p,"pesos"),1,1,"R");
				
				$pdf->ln(3);
				$texto1 = numletras($cfdi3p,1);
				$pdf->SetX(10);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont("Arial","B",10);
				$pdf->Cell(45,4,"CANTIDAD CON LETRA: ",0,0,"L");
				$pdf->SetFont("Arial","",10);
				$pdf->Cell(145,4,$texto1." ".mone($cfdi8),0,1,"L");

				$pdf->SetX(10);
				$pdf->SetFont("Arial","B",10);
				$pdf->Cell(18,4,"MONEDA: ",0,0,"L");
				$pdf->SetFont("Arial","",10);
				$pdf->Cell(25,4,mone($cfdi8),0,0,"L");
				$pdf->SetFont("Arial","B",10);
				$pdf->Cell(38,4," |   METODO DE PAGO: ",0,0,"L");
				$pdf->SetFont("Arial","",10);
				$pdf->Cell(58,4,metodope($cfdi9),0,1,"L");
				$pdf->SetFont("Arial","B",10);
				$pdf->Cell(29,4,"FORMA PAGO: ",0,0,"L");
				$pdf->SetFont("Arial","",10);
				$pdf->Cell(30,4,formap($cfdi10)." ",0,1,"L");
				$pdf->SetX(10);
				$pdf->SetFont("Arial","B",10);
				$pdf->Cell(35,4,"FECHA TIMBRADO: ",0,0,"L");
				$pdf->SetFont("Arial","",10);
				$pdf->Cell(155,4,$cfdi99,0,1,"L");
				$pdf->SetX(10);
				$pdf->SetFont("Arial","B",10);
				$pdf->Cell(65,4,"No. de Serie del Certificado del SAT: ",0,0,"L");
				$pdf->SetFont("Arial","",10);
				$pdf->Cell(125,4,$sello4,0,1,"L");

				$Receptor1 = $Receptor['Nombre'];
				$Receptor2 = $Receptor['Rfc'];
				$Receptor3 = uso($Receptor['UsoCFDI']);
				 $sello1 = $tfd['SelloCFD'];
				 $sello2 = $tfd['SelloSAT'];
				generarPNG($nombrexml,"https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=".$sello5."&re=".$emisor2."&rr=".$Receptor2."&tt=".number_format(floatval($cfdi3),6)."&fe=".substr($sello1,-8));
				
				
				$pdf->ln(3);
				$texto1 = "Sello Digital del CFDi ";
				$pdf->SetX(10);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont("Arial","B",10);
				$pdf->MultiCell(190,4,$texto1,0,"L");
				$pdf->SetFont("Arial","",8);
				$pdf->MultiCell(190,4,$sello1,0,"L");
				

				$pdf->ln(3);
				$texto1 = "Sello Digital del SAT ";
				$pdf->SetX(10);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont("Arial","B",10);
				$pdf->MultiCell(190,4,$texto1,0,"L");
				$pdf->SetFont("Arial","",8);
				$pdf->MultiCell(190,4,$sello2,0,"L");

				$pdf->ln(3);
				$texto1 = utf8_decode("Cadena Original del complemento de certificación digital del SAT ");
				$pdf->SetX(10);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont("Arial","B",10);
				$pdf->MultiCell(190,4,$texto1,0,"L");
				$pdf->SetFont("Arial","",8);
				$pdf->MultiCell(190,4,satxmlsv33_genera_cadena_original($xml),0,"L");
								
				$pdf->Image($nombrexml.'.png',10,220,-85);
				
			
		
		// El documento enviado al navegador
		$pdf->Output('comprobantes/'.$cfdi1.''.$cfdi2.'-'.$emisor2.'-'.$sello5.'.pdf',"F");	
		
		return 'comprobantes/'.$cfdi1.''.$cfdi2.'-'.$emisor2.'-'.$sello5.'.pdf';
			
		}

function mone($identificador)
{
     if($identificador == "MXN"){
		 $result = "MXN - PESOS";
	 }
	 
	 if($identificador == "USD"){
		 $result = "USD - DOLARES";
	 }
	  if($identificador == "EUR"){
		 $result = "EUR - EUROS";
	 }
	 
	 return $result;
}

function metodope($identificador)
{
     if($identificador == "PUE"){
		 $result = "PUE - Pago en una sola exhibicion";
	 }
	 
	 if($identificador == "PPD"){
		 $result = "PPD - Pago en parcialidades o diferidos";
	 }
	 
	 return $result;
}

function uso($identificador)
{
     if($identificador == "G01"){
		 $result = "G01 - Adquisicion de mercancias";
	 }
	 
	 if($identificador == "G02"){
		 $result = "G02 - Devoluciones, descuentos o bonificaciones";
	 }
	  if($identificador == "G03"){
		 $result = "G03 - Gastos en general";
	 }
	  if($identificador == "I01"){
		 $result = "I01 - Construcciones";
	 }
	  if($identificador == "I02"){
		 $result = "I02 - Mobilario y equipo de oficina por inversiones";
	 }
	  if($identificador == "I03"){
		 $result = "I03 - Equipo de transporte";
	 }
	  if($identificador == "I04"){
		 $result = "I04 - Equipo de computo y accesorios";
	 }
	  if($identificador == "I05"){
		 $result = "I05 - Dados, troqueles, moldes, matrices y herramental	";
	 }
	  if($identificador == "I06"){
		 $result = "I06 - Comunicaciones telefónicas	";
	 } 
	 if($identificador == "I07"){
		 $result = "I07 - Comunicaciones satelitales";
	 }
	  if($identificador == "I08"){
		 $result = "I08 - Otra maquinaria y equipo";
	 }
	  if($identificador == "D01"){
		 $result = "D01 - Honorarios médicos, dentales y gastos hospitalarios.";
	 }
	  if($identificador == "D02"){
		 $result = "D02 - Gastos médicos por incapacidad o discapacidad";
	 }
	  if($identificador == "D03"){
		 $result = "D03 - Gastos funerales.";
	 }
	  if($identificador == "D04"){
		 $result = "D04 - Donativos.";
	 }
	  if($identificador == "D05"){
		 $result = "D05 - Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).";
	 }
	  if($identificador == "D06"){
		 $result = "D06 - Aportaciones voluntarias al SAR.";
	 }
	  if($identificador == "D07"){
		 $result = "D07 - Primas por seguros de gastos médicos.";
	 }
	  if($identificador == "D08"){
		 $result = "D08 - Gastos de transportación escolar obligatoria.";
	 }
	  if($identificador == "D09"){
		 $result = "D09 - Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.";
	 }
	 
	 if($identificador == "D10"){
		 $result = "D10 - Pagos por servicios educativos (colegiaturas)";
	 }
	 
	 if($identificador == "P01"){
		 $result = "P01 - Por definir";
	 }
	 
	 return $result;
}


function formap($identificador)
{
     if($identificador == "01"){
		 $result = "01 - Efectivo";
	 }
	 
	 if($identificador == "02"){
		 $result = "02 - Cueque nominativo";
	 }
	  if($identificador == "03"){
		 $result = "03 - Transferencia electronica de fondos";
	 }
	  if($identificador == "04"){
		 $result = "04 - Tarjeta de credito";
	 }
	  if($identificador == "05"){
		 $result = "05 - Monedero electronico";
	 }
	  if($identificador == "06"){
		 $result = "06 - Dienero electronico";
	 }
	  if($identificador == "08"){
		 $result = "08 - Vales de despensa";
	 }
	  if($identificador == "12"){
		 $result = "12 - Dacion de pago";
	 }
	  if($identificador == "13"){
		 $result = "13 - Pago por subrogacion";
	 } 
	 if($identificador == "14"){
		 $result = "14 - Pago por consignacion";
	 }
	  if($identificador == "15"){
		 $result = "15 - Condonacion";
	 }
	  if($identificador == "17"){
		 $result = "17 - Compensacion";
	 }
	  if($identificador == "23"){
		 $result = "23 - Novacion";
	 }
	  if($identificador == "24"){
		 $result = "24 - Confusion";
	 }
	  if($identificador == "25"){
		 $result = "25 - Remision de deuda";
	 }
	  if($identificador == "26"){
		 $result = "26 - Prescripcion o caducidad";
	 }
	  if($identificador == "27"){
		 $result = "27 - A satisfaccion del acreedor";
	 }
	  if($identificador == "28"){
		 $result = "28 - Tarjeta de debito";
	 }
	  if($identificador == "29"){
		 $result = "29 - Tarjeta de servicios";
	 }
	  if($identificador == "99"){
		 $result = "99 - Por definir.";
	 }
	 
	 return $result;
}

function rgmen($identificador)
{
     if($identificador == "601"){
		 $result = "601 - General de Ley Personas Morales";
	 }
	 if($identificador == "603"){
		 $result = "603 - Personas Morales con Fines no Lucrativos";
	 }
	  if($identificador == "605"){
		 $result = "605 - Sueldos y Salarios e Ingresos Asimilados a Salarios";
	 }
	  if($identificador == "606"){
		 $result = "606 - Arrendamiento";
	 }
	  if($identificador == "608"){
		 $result = "608 - Demás ingresos";
	 }
	  if($identificador == "609"){
		 $result = "609 - Consolidación";
	 }
	  if($identificador == "610"){
		 $result = "610 - Residentes en el Extranjero sin Establecimiento Permanente en México";
	 }
	  if($identificador == "611"){
		 $result = "611 - Ingresos por Dividendos (socios y accionistas)";
	 }
	  if($identificador == "612"){
		 $result = "612 - Personas Físicas con Actividades Empresariales y Profesionales";
	 } 
	 if($identificador == "614"){
		 $result = "614 - Ingresos por intereses";
	 }
	  if($identificador == "616"){
		 $result = "616 - Sin obligaciones fiscales";
	 }
	  if($identificador == "620"){
		 $result = "620 - Sociedades Cooperativas de Producción que optan por diferir sus ingresos";
	 }
	  if($identificador == "621"){
		 $result = "621 - Incorporación Fiscal";
	 }
	  if($identificador == "622"){
		 $result = "622 - Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras";
	 }
	  if($identificador == "623"){
		 $result = "623 - Opcional para Grupos de Sociedades";
	 }
	  if($identificador == "624"){
		 $result = "624 - Coordinados";
	 }
	  if($identificador == "628"){
		 $result = "628 - Hidrocarburos";
	 }
	  if($identificador == "607"){
		 $result = "607 - Régimen de Enajenación o Adquisición de Bienes";
	 }
	  if($identificador == "629"){
		 $result = "629 - De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales";
	 }
	  if($identificador == "630"){
		 $result = "630 - Enajenación de acciones en bolsa de valores";
	 }
	 if($identificador == "615"){
		 $result = "615 - Régimen de los ingresos por obtención de premios";
	 }
	 
	 return $result;
}

function amoneda($numero,$n)
{
    $number = $numero;
    setlocale(LC_MONETARY, 'en_US.UTF-8');
    
    $m = money_formato('%.2n', $number);
    return $m;
}
function money_formato($format, $number) 
    { 
        $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'. 
                  '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/'; 
        if (setlocale(LC_MONETARY, 0) == 'C') { 
            setlocale(LC_MONETARY, ''); 
        } 
        $locale = localeconv(); 
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER); 
        foreach ($matches as $fmatch) { 
            $value = floatval($number); 
            $flags = array( 
                'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ? 
                               $match[1] : ' ', 
                'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0, 
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ? 
                               $match[0] : '+', 
                'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0, 
                'isleft'    => preg_match('/\-/', $fmatch[1]) > 0 
            ); 
            $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0; 
            $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0; 
            $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits']; 
            $conversion = $fmatch[5]; 
    
            $positive = true; 
            if ($value < 0) { 
                $positive = false; 
                $value  *= -1; 
            } 
            $letter = $positive ? 'p' : 'n'; 
    
            $prefix = $suffix = $cprefix = $csuffix = $signal = ''; 
    
            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign']; 
            switch (true) { 
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+': 
                    $prefix = $signal; 
                    break; 
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+': 
                    $suffix = $signal; 
                    break; 
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+': 
                    $cprefix = $signal; 
                    break; 
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+': 
                    $csuffix = $signal; 
                    break; 
                case $flags['usesignal'] == '(': 
                case $locale["{$letter}_sign_posn"] == 0: 
                    $prefix = '('; 
                    $suffix = ')'; 
                    break; 
            } 
            if (!$flags['nosimbol']) { 
                $currency = $cprefix . 
                            ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) . 
                            $csuffix; 
            } else { 
                $currency = ''; 
            } 
            $space  = $locale["{$letter}_sep_by_space"] ? ' ' : ''; 
    
            $value = number_format($value, $right, $locale['mon_decimal_point'], 
                     $flags['nogroup'] ? '' : $locale['mon_thousands_sep']); 
            $value = @explode($locale['mon_decimal_point'], $value); 
    
            $n = strlen($prefix) + strlen($currency) + strlen($value[0]); 
            if ($left > 0 && $left > $n) { 
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0]; 
            } 
            $value = implode($locale['mon_decimal_point'], $value); 
            if ($locale["{$letter}_cs_precedes"]) { 
                $value = $prefix . $currency . $space . $value . $suffix; 
            } else { 
                $value = $prefix . $value . $space . $currency . $suffix; 
            } 
            if ($width > 0) { 
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ? 
                         STR_PAD_RIGHT : STR_PAD_LEFT); 
            } 
    
            $format = str_replace($fmatch[0], $value, $format); 
        } 
        return $format; 
    } 

function satxmlsv33_genera_cadena_original($xml) {
$paso = new DOMDocument("1.0","UTF-8");
$paso->loadXML($xml->saveXML());
$xsl = new DOMDocument("1.0","UTF-8");
$ruta = "utilerias/xslt33/";
$file=$ruta."cadenaoriginal_3_3.xslt";      // Ruta al archivo
$xsl->load($file);
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); 
return $proc->transformToXML($paso);
}

?>
