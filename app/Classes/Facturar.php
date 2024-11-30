<?php 
/**
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * @version 1.0.0
 * @author Alberto Esquivias Flores
 */
namespace App\Classes;
use App\Classes\FPDF;

define('FPDF_FONTPATH', 'font/');



class PDF_MC_Table extends FPDF 
{ 
var $widths; 
var $aligns; 

function SetWidths($w) 
{ 
    //Set the array of column widths 
    $this->widths=$w; 
} 

function SetAligns($a) 
{ 
    //Set the array of column alignments 
    $this->aligns=$a; 
} 

function fill($f)
{
	//juego de arreglos de relleno
	$this->fill=$f;
}

function Row($data) 
{ 
    //Calculate the height of the row 
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=5*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect($x,$y,$w,$h,'D'); 
        //Print the text 
        $this->MultiCell($w,5,$data[$i],'LTR',$a,false); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h); 
} 

function CheckPageBreak($h) 
{ 
    //If the height h would cause an overflow, add a new page immediately 
    if($this->GetY()+$h>$this->PageBreakTrigger) 
        $this->AddPage($this->CurOrientation); 
} 

function NbLines($w,$txt) 
{ 
    //Computes the number of lines a MultiCell of width w will take 
    $cw=&$this->CurrentFont['cw']; 
    if($w==0) 
        $w=$this->w-$this->rMargin-$this->x; 
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize; 
    $s=str_replace("\r",'',$txt); 
    $nb=strlen($s); 
    if($nb>0 and $s[$nb-1]=="\n") 
        $nb--; 
    $sep=-1; 
    $i=0; 
    $j=0; 
    $l=0; 
    $nl=1; 
    while($i<$nb) 
    { 
        $c=$s[$i]; 
        if($c=="\n") 
        { 
            $i++; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
            continue; 
        } 
        if($c==' ') 
            $sep=$i; 
        $l+=$cw[$c]; 
        if($l>$wmax) 
        { 
            if($sep==-1) 
            { 
                if($i==$j) 
                    $i++; 
            } 
            else 
                $i=$sep+1; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
        } 
        else 
            $i++; 
    } 
    return $nl; 
} 
} 

class PDFP extends PDF_MC_Table
{
//Constructor (mandatory with PHP3)

//Page header
function Header()
{


$xml = new \SimpleXMLElement ($GLOBALS["nombrexml"],null,true);
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
        $cfdi = $cfdiComprobante['LugarExpedicion'];
        $cfdi1 = $cfdiComprobante['Serie'];
        $cfdi2 = $cfdiComprobante['Folio'];
        $cfdi3 = $cfdiComprobante['Total'];
        $cfdi4 = $cfdiComprobante['SubTotal'];
        $cfdi4211 = $cfdiComprobante['Total'];
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
    $this->Image(public_path().'/img/'.$GLOBALS["logo"],15,15,-250);
    //Line break
    
    $xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
 
    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
    $emisor1 = $Emisor['Nombre'];
    $emisor2 = $Emisor['Rfc'];
    $emisor3 = $Emisor['RegimenFiscal'];
    $texto1=" ".$Emisor['Nombre']." \n  RFC: ".$Emisor['Rfc']." \n Regimen: ".$emisor3;
    $this->SetXY(70, 13);
    $this->SetTextColor(0,0,0);
    $this->SetFont("Arial","",8);
    $this->MultiCell(130,8,$texto1,1,"L");
    
    
    $this->SetXY(150, 13);
    $this->SetTextColor(0,0,0);
    $this->SetFont("Arial","",8);
    $this->MultiCell(50,8,$GLOBALS['observaciones'],1,"L");
    
    
    $this->SetXY(10, 53);
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255,255,255);
    $this->Cell(0,8," DATOS DEL CLIENTE                                                                              EXPEDIDO EN",1,1,"L",true);
    
    $Receptor1 = $Receptor['Nombre'];
    $Receptor2 = $Receptor['Rfc'];
    $Receptor3 = $Receptor['UsoCFDI'];

    

    $texto1=" ".$Receptor1." \n RFC:".$Receptor2." \n Uso CFDI:".$Receptor3;
    $this->SetXY(10, 61);
    $this->SetTextColor(0,0,0);
    $this->SetFont("Arial","",8);
    $this->MultiCell(90,5,$texto1,1,"L");
    
    $texto2=" C.P.".$cfdi." \n ".utf8_decode("Fecha y hora de emisión:");
    $this->SetXY(100, 61);
    $this->SetTextColor(0,0,0);
    $this->SetFont("Arial","",8);
    $this->MultiCell(0,6,$texto2,0,"L");
    }
    }
  
    $this->SetXY(10, 80);
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255,255,255);
    $this->SetFont("Arial","B",5);
    $this->Cell(15,6,"ECO",1,0,"C",true);
    $this->Cell(15,6,"PLACAS",1,0,"C",true);
    $this->Cell(15,6,"NO. SOL.",1,0,"C",true);
    $this->Cell(15,6,"KM",1,0,"C",true);
    $this->Cell(90,6,"DESCRIPCION",1,0,"C",true);
    $this->Cell(20,6,"V. UNITARIO",1,0,"C",true);
    $this->Cell(20,6,"IMPORTE",1,1,"C",true);


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


class PDFPMAS extends PDF_MC_Table
{
//Constructor (mandatory with PHP3)

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
		 $result = "612 - Personas Fisicas con Actividades Empresariales y Profesionales";
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
		 $result = "607 - Regimen de Enajenación o Adquisición de Bienes";
	 }
	  if($identificador == "629"){
		 $result = "629 - De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales";
	 }
	  if($identificador == "630"){
		 $result = "630 - Enajenación de acciones en bolsa de valores";
	 }
	 if($identificador == "615"){
		 $result = "615 - Regimen de los ingresos por obtención de premios";
	 }
     if($identificador == "624"){
        $result = "624 - Coordinados";
    }
    if($identificador == "626"){
        $result = "626 - Regimen Simplificado de Confianza";
    }
	 
	 return $result;
}

function uso($identificador)
{
     if($identificador == "G01"){
		 $result = "G01 - Adquisicion de mercancias";
	 }

     if($identificador == "CP01"){
        $result = "CP01 - Pago";
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

//Page header
function Header()
{


$xml = new \SimpleXMLElement ($GLOBALS["nombrexml"],null,true);
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
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
    $this->Image(public_path().'/img/'.$GLOBALS["logo"],15,15,-250);
    //Line break
    
    $xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
        $sello4 = $tfd['NoCertificadoSAT'];
        $sello5 = $tfd['UUID'];
        }
 
    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
    $emisor1 = $Emisor['Nombre'];
    $emisor2 = $Emisor['Rfc'];
    $emisor3 = $Emisor['RegimenFiscal'];
    $regi1 = $this->rgmen($emisor3);
    $texto1=" ".$Emisor['Nombre']." \n  RFC: ".$Emisor['Rfc']." \n No de serie del Certificado del CSD:".$cfdi11."  \n Folio Fiscal: ".$sello5." \n Regimen: ".$regi1." \n Exportacion: 01";
    $this->SetXY(70, 13);
    $this->SetTextColor(0,0,0);
    $this->SetFont("Arial","",8);
    $this->MultiCell(130,6,$texto1,1,"L");
    
    
    $this->SetXY(150, 13);
    $this->SetTextColor(0,0,0);
    $this->SetFont("Arial","",8);
    $this->MultiCell(50,8,$GLOBALS['observaciones'],1,"L");
    
    
    $this->SetXY(10, 53);
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255,255,255);
    $this->Cell(0,8," DATOS DEL CLIENTE                                                                              EXPEDIDO EN",1,1,"L",true);
    
  
    $Receptor1 = utf8_decode($Receptor['Nombre']);
    $Receptor2 = $Receptor['Rfc'];
    $Regimen2 =  $this->rgmen($Receptor['RegimenFiscalReceptor']);
    $Domicilio2 = $Receptor['DomicilioFiscalReceptor'];
    $Receptor2 = $Receptor['Rfc'];
    $Receptor3 = $this->uso($Receptor['UsoCFDI']);

    $texto1=" ".$Receptor1." \n RFC:".$Receptor2." \n Domicilio Fiscal:".$Domicilio2.utf8_decode(" \n Régimen::").$Regimen2." \n Uso CFDI:".$Receptor3;
    $this->SetXY(10, 61);
    $this->SetTextColor(0,0,0);
    $this->SetFont("Arial","",8);
    $this->MultiCell(90,4,$texto1,1,"L");
    
    $texto2=" C.P.".$cfdi." \n ".utf8_decode("Fecha y hora de emisión:");
    $this->SetXY(100, 61);
    $this->SetTextColor(0,0,0);
    $this->SetFont("Arial","",8);
    $this->MultiCell(0,6,$texto2,0,"L");
    }
    }
  
    $this->SetXY(10, 83);
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255,255,255);
    $this->SetFont("Arial","B",5);
    $this->Cell(15,6,"CANT",1,0,"C",true);
    $this->Cell(15,6,"UNIDAD",1,0,"C",true);
    $this->Cell(120,6,"DESCRIPCION",1,0,"C",true);
    $this->Cell(20,6,"V. UNITARIO",1,0,"C",true);
    $this->Cell(20,6,"IMPORTE",1,1,"C",true);


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

class NumLetras
{


function numletras($numero,$_moneda) 
/* 
$numero=valor a retornar en letras. 
$_moneda=1=Colones, 2=Dólares 3=Euros 
Las siguientes funciones (unidad() hasta milmillon() forman parte de ésta función 
*/ 
{ 
switch($_moneda) 
{ 
case 1: 
$_nommoneda='PESOS'; 
break; 
case 2: 
$_nommoneda='DÓLARES'; 
break; 
case 3: 
$_nommoneda='EUROS'; 
break; 
} 
//*** 
$tempnum = explode('.',$numero); 

if ($tempnum[0] !== ""){ 
$numf = $this->milmillon($tempnum[0]); 
if ($numf == "UNO") 
{ 
$numf = substr($numf, 0, -1); 
} 

$TextEnd = $numf.' '; 
$TextEnd .= $_nommoneda.' '; 
} 
if ($tempnum[1] == "" || $tempnum[1] >= 100) 
{ 
$tempnum[1] = "00" ; 
} 
$TextEnd .= $tempnum[1] ; 
$TextEnd .= "/100"; 
return $TextEnd; 
} 

function centena($numc){ 
if ($numc >= 100) 
{ 
if ($numc >= 900 && $numc <= 999) 
{ 
$numce = "NOVECIENTOS "; 
if ($numc > 900) 
$numce = $numce.($this->decena($numc - 900)); 
} 
else if ($numc >= 800 && $numc <= 899) 
{ 
$numce = "OCHOCIENTOS "; 
if ($numc > 800) 
$numce = $numce.($this->decena($numc - 800)); 
} 
else if ($numc >= 700 && $numc <= 799) 
{ 
$numce = "SETECIENTOS "; 
if ($numc > 700) 
$numce = $numce.($this->decena($numc - 700)); 
} 
else if ($numc >= 600 && $numc <= 699) 
{ 
$numce = "SEISCIENTOS "; 
if ($numc > 600) 
$numce = $numce.($this->decena($numc - 600)); 
} 
else if ($numc >= 500 && $numc <= 599) 
{ 
$numce = "QUINIENTOS "; 
if ($numc > 500) 
$numce = $numce.($this->decena($numc - 500)); 
} 
else if ($numc >= 400 && $numc <= 499) 
{ 
$numce = "CUATROCIENTOS "; 
if ($numc > 400) 
$numce = $numce.($this->decena($numc - 400)); 
} 
else if ($numc >= 300 && $numc <= 399) 
{ 
$numce = "TRESCIENTOS "; 
if ($numc > 300) 
$numce = $numce.($this->decena($numc - 300)); 
} 
else if ($numc >= 200 && $numc <= 299) 
{ 
$numce = "DOSCIENTOS "; 
if ($numc > 200) 
$numce = $numce.($this->decena($numc - 200)); 
} 
else if ($numc >= 100 && $numc <= 199) 
{ 
if ($numc == 100) 
$numce = "CIEN "; 
else 
$numce = "CIENTO ".($this->decena($numc - 100)); 
} 
} 
else 
$numce = $this->decena($numc); 

return $numce; 
} 


function decena($numdero){ 

    if ($numdero >= 90 && $numdero <= 99) 
    { 
    $numd = "NOVENTA "; 
    if ($numdero > 90) 

    $numd = $numd."Y ".($this->unidad($numdero - 90)); 
    } 
    else if ($numdero >= 80 && $numdero <= 89) 
    { 
    $numd = "OCHENTA "; 
    if ($numdero > 80) 
    $numd = $numd."Y ".($this->unidad($numdero - 80)); 
    } 
    else if ($numdero >= 70 && $numdero <= 79) 
    { 
    $numd = "SETENTA "; 
    if ($numdero > 70) 
    $numd = $numd."Y ".($this->unidad($numdero - 70)); 
    } 
    else if ($numdero >= 60 && $numdero <= 69) 
    { 
    $numd = "SESENTA "; 
    if ($numdero > 60) 
    $numd = $numd."Y ".($this->unidad($numdero - 60)); 
    } 
    else if ($numdero >= 50 && $numdero <= 59) 
    { 
    $numd = "CINCUENTA "; 
    if ($numdero > 50) 
    $numd = $numd."Y ".($this->unidad($numdero - 50)); 
    } 
    else if ($numdero >= 40 && $numdero <= 49) 
    { 
    $numd = "CUARENTA "; 
    if ($numdero > 40) 
    $numd = $numd."Y ".($this->unidad($numdero - 40)); 
    } 
    else if ($numdero >= 30 && $numdero <= 39) 
    { 
    $numd = "TREINTA "; 
    if ($numdero > 30) 
    $numd = $numd."Y ".($this->unidad($numdero - 30)); 
    } 
    else if ($numdero >= 20 && $numdero <= 29) 
    { 
    if ($numdero == 20) 
    $numd = "VEINTE "; 
    else 
    $numd = "VEINTI".($this->unidad($numdero - 20)); 
    } 
    else if ($numdero >= 10 && $numdero <= 19) 
    { 
    switch ($numdero){ 
    case 10: 
    { 
    $numd = "DIEZ "; 
    break; 
    } 
    case 11: 
    { 
    $numd = "ONCE "; 
    break; 
    } 
    case 12: 
    { 
    $numd = "DOCE "; 
    break; 
    } 
    case 13: 
    { 
    $numd = "TRECE "; 
    break; 
    } 
    case 14: 
    { 
    $numd = "CATORCE "; 
    break; 
    } 
    case 15: 
    { 
    $numd = "QUINCE "; 
    break; 
    } 
    case 16: 
    { 
    $numd = "DIECISEIS "; 
    break; 
    } 
    case 17: 
    { 
    $numd = "DIECISIETE "; 
    break; 
    } 
    case 18: 
    { 
    $numd = "DIECIOCHO "; 
    break; 
    } 
    case 19: 
    { 
    $numd = "DIECINUEVE "; 
    break; 
    } 
    } 
    } 
    else 
    $numd = $this->unidad($numdero); 
    return $numd; 
    } 


function unidad($numuero){ 
    switch ($numuero) 
    { 
    case 9: 
    { 
    $numu = "NUEVE"; 
    break; 
    } 
    case 8: 
    { 
    $numu = "OCHO"; 
    break; 
    } 
    case 7: 
    { 
    $numu = "SIETE"; 
    break; 
    } 
    case 6: 
    { 
    $numu = "SEIS"; 
    break; 
    } 
    case 5: 
    { 
    $numu = "CINCO"; 
    break; 
    } 
    case 4: 
    { 
    $numu = "CUATRO"; 
    break; 
    } 
    case 3: 
    { 
    $numu = "TRES"; 
    break; 
    } 
    case 2: 
    { 
    $numu = "DOS"; 
    break; 
    } 
    case 1: 
    { 
    $numu = "UNO"; 
    break; 
    } 
    case 0: 
    { 
    $numu = ""; 
    break; 
    } 
    } 
    return $numu; 
    } 
function miles($nummero){ 
if ($nummero >= 1000 && $nummero < 2000){ 
$numm = "MIL ".($this->centena($nummero%1000)); 
} 
if ($nummero >= 2000 && $nummero <10000){ 
$numm = $this->unidad(Floor($nummero/1000))." MIL ".($this->centena($nummero%1000)); 
} 
if ($nummero < 1000) 
$numm = $this->centena($nummero); 

return $numm; 
} 

function decmiles($numdmero){ 
if ($numdmero == 10000) 
$numde = "DIEZ MIL"; 
if ($numdmero > 10000 && $numdmero <20000){ 
$numde = $this->decena(Floor($numdmero/1000))."MIL ".($this->centena($numdmero%1000)); 
} 
if ($numdmero >= 20000 && $numdmero <100000){ 
$numde = $this->decena(Floor($numdmero/1000))." MIL ".($this->miles($numdmero%1000)); 
} 
if ($numdmero < 10000) 
$numde = $this->miles($numdmero); 

return $numde; 
} 

function cienmiles($numcmero){ 
if ($numcmero == 100000) 
$num_letracm = "CIEN MIL"; 
if ($numcmero >= 100000 && $numcmero <1000000){ 
$num_letracm = $this->centena(Floor($numcmero/1000))." MIL ".($this->centena($numcmero%1000)); 
} 
if ($numcmero < 100000) 
$num_letracm = $this->decmiles($numcmero); 
return $num_letracm; 
} 

function millon($nummiero){ 
if ($nummiero >= 1000000 && $nummiero <2000000){ 
$num_letramm = "UN MILLON ".($this->cienmiles($nummiero%1000000)); 
} 
if ($nummiero >= 2000000 && $nummiero <10000000){ 
$num_letramm = $this->unidad(Floor($nummiero/1000000))." MILLONES ".($this->cienmiles($nummiero%1000000)); 
} 
if ($nummiero < 1000000) 
$num_letramm = $this->cienmiles($nummiero); 

return $num_letramm; 
} 

function decmillon($numerodm){ 
if ($numerodm == 10000000) 
$num_letradmm = "DIEZ MILLONES"; 
if ($numerodm > 10000000 && $numerodm <20000000){ 
$num_letradmm = $this->decena(Floor($numerodm/1000000))."MILLONES ".($this->cienmiles($numerodm%1000000)); 
} 
if ($numerodm >= 20000000 && $numerodm <100000000){ 
$num_letradmm = $this->decena(Floor($numerodm/1000000))." MILLONES ".($this->millon($numerodm%1000000)); 
} 
if ($numerodm < 10000000) 
$num_letradmm = $this->millon($numerodm); 

return $num_letradmm; 
} 

function cienmillon($numcmeros){ 
if ($numcmeros == 100000000) 
$num_letracms = "CIEN MILLONES"; 
if ($numcmeros >= 100000000 && $numcmeros <1000000000){ 
$num_letracms = $this->centena(Floor($numcmeros/1000000))." MILLONES ".($this->millon($numcmeros%1000000)); 
} 
if ($numcmeros < 100000000) 
$num_letracms = $this->decmillon($numcmeros); 
return $num_letracms; 
} 

function milmillon($nummierod){ 
if ($nummierod >= 1000000000 && $nummierod <2000000000){ 
$num_letrammd = "MIL ".($this->cienmillon($nummierod%1000000000)); 
} 
if ($nummierod >= 2000000000 && $nummierod <10000000000){ 
$num_letrammd = $this->unidad(Floor($nummierod/1000000000))." MIL ".($this->cienmillon($nummierod%1000000000)); 
} 
if ($nummierod < 1000000000) 
$num_letrammd = $this->cienmillon($nummierod); 

return $num_letrammd; 
} 

}



use QrCode;



class Facturar
{

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
		 $result = "612 - Personas Fisicas con Actividades Empresariales y Profesionales";
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
		 $result = "607 - Regimen de Enajenación o Adquisición de Bienes";
	 }
	  if($identificador == "629"){
		 $result = "629 - De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales";
	 }
	  if($identificador == "630"){
		 $result = "630 - Enajenación de acciones en bolsa de valores";
	 }
	 if($identificador == "615"){
		 $result = "615 - Regimen de los ingresos por obtención de premios";
	 }
     if($identificador == "624"){
        $result = "624 - Coordinados";
    }
    if($identificador == "626"){
        $result = "626 - Regimen Simplificado de Confianza";
    }
	 
	 return $result;
}
   
      
    function crearXML($empresa, $factura_emisor, $detalles, $datos){
          
         
          date_default_timezone_set('America/Mexico_City');
         
          $fecha_actual = substr( date('c'), 0, 19); 
                       
          $noCertificado = $factura_emisor->n_certificado;
         
          $fact_serie = $factura_emisor->serie;
         
          $fact_folio = $factura_emisor->folio;
         
          $NoFac = $fact_serie.$fact_folio;
         
          $fact_tipcompr = $datos['tipo_comprobante'];
         
          $tasa_iva = 16;	
          $descuento = "0.00";
          $fecha = date('H:i:s'); //inicializo la fecha con la hora
          $nuevafecha = strtotime ( '-1 hour' , strtotime ( $fecha ) ) ;
          $nuevafecha = date ( 'H:i:s' , $nuevafecha );
          $fecha_fact = date("Y-m-d")."TTT".$nuevafecha;
          $NumCtaPago = "6473";
          $condicionesDePago = "CONDICIONES";
          $formaDePago = $datos['fpago'];
     
          $metodoDePago = $datos['mpago'];
          $TipoCambio = 1;
          $LugarExpedicion = $factura_emisor->codigo;
          $moneda = $datos['moneda'];
         
       
          $xml = new \DOMDocument;
          $root = $xml->createElement("cfdi:Comprobante");
          $root = $xml->appendChild($root);
       
          $cadena_original='||';
          $noatt=array();

       
         
          $this->cargaAtt($root,array("xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/4",
          "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
          "xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd"
          )
          );

         
         
     
                 
          if ($datos['tipo_comprobante']=='E'){
          
              foreach ($datos['atiporelacion']  as $key => $value) {
              $tipo = $value;
                  $uuid = $datos['auuid'][$key]; 
                  
          
              $relacionados = $xml->createElement("cfdi:CfdiRelacionados");
              $relacionados = $root->appendChild($relacionados);
              $this->cargaAtt($relacionados, array("TipoRelacion" => $tipo
                                  )
                              );
          
          
                              $relacionado = $xml->createElement("cfdi:CfdiRelacionado");
                              $relacionado = $relacionados->appendChild($relacionado);
                              $this->cargaAtt($relacionado, array("UUID" => $uuid
                                                  )
                                              );		
                                              
                                          }
          
          }
          
              $emisor = $xml->createElement("cfdi:Emisor");
              $emisor = $root->appendChild($emisor);
              $this->cargaAtt($emisor, array("Rfc" => $factura_emisor->rfc,
                                      "Nombre" => $factura_emisor->nombre,
                                      "RegimenFiscal" => $factura_emisor->regimen
                                      )
                                  );
              
                                 
                                  
              $receptor = $xml->createElement("cfdi:Receptor");
              $receptor = $root->appendChild($receptor);
              //$emisor->appendChild($expedido);
              $this->cargaAtt($receptor, array
              ("Rfc"=>$empresa->rfc,
                "Nombre"=>utf8_decode($empresa->nombre),
                  "UsoCFDI"=>$datos['uso_cfdi'],
                  "RegimenFiscalReceptor"=>$empresa->regimen,
		          "DomicilioFiscalReceptor"=>$empresa->cp,
                  )
               );
              
          
              $conceptos1 = $xml->createElement("cfdi:Conceptos");  //Crear arreglo de conceptos para agregar al documento, reemplazar los valores en la cargaAtt
              $conceptos1 = $root->appendChild($conceptos1);
              $subtotal = 0;
             foreach($detalles as $detalle) {
               
                 $pproducto = number_format($detalle->precio, 2, '.', ''); 
                 $cantidad =  number_format($detalle->cantidad, 6, '.', '');
                 $tp = number_format($cantidad*$pproducto, 2, '.', '');
                 $subtotal += $tp;
                 
                     
                  $concepto = $xml->createElement("cfdi:Concepto");
                  $concepto = $conceptos1->appendChild($concepto);
                  $this->cargaAtt($concepto, array(
                    "ClaveProdServ"=> $detalle->codigo_sat,
                    "NoIdentificacion"=> $detalle->id,
                    "Cantidad"=> $cantidad,
                     "ClaveUnidad"=> $detalle->unidad_sat,
                     "Unidad"=> $detalle->unidad,
                     "Descripcion"=>  $detalle->descripcion,
                     "ValorUnitario"=> $pproducto ,
                     "Importe"=>$tp,
                     "ObjetoImp" => "02",
                     "Descuento"=> 0));
                   $impuestos = $xml->createElement("cfdi:Impuestos");
                   $impuestos = $concepto->appendChild($impuestos);
                        $traslados = $xml->createElement("cfdi:Traslados");
                        $traslados = $impuestos->appendChild($traslados);
                             $traslado = $xml->createElement("cfdi:Traslado");
                             $traslado = $traslados->appendChild($traslado);
                             $this->cargaAtt($traslado,array(
                                 "Base"=>$tp,
                                 "Impuesto"=>"002",
                                 "TipoFactor"=>"Tasa",
                                 "TasaOCuota"=>"0.160000",
                                 "Importe"=>$tp*0.16)
                                 );
             
            } ;

           
                
                $foliox = $factura_emisor->folio+1;
                $fecha = date('H:i:s'); //inicializo la fecha con la hora
                $nuevafecha = strtotime ( '-1 hour' , strtotime ( $fecha ) ) ;
                $nuevafecha = date ( 'H:i:s' , $nuevafecha );
                
                
                $this->cargaAtt($root, array(
                  "Version" => "4.0", 
                  "Serie" => $factura_emisor->serie,
                  "Folio" => $foliox, 
                  "Fecha" =>date("Y-m-d")."T".$nuevafecha,
                  "Sello" => "@",
                  "FormaPago" => $formaDePago,
                  "NoCertificado" => $noCertificado, 
                  "Certificado" => "@", 
                  "CondicionesDePago" => $condicionesDePago,
                  "SubTotal" => number_format($subtotal, 2, '.', ''),
                  "Descuento" => 0.0,
                  "Moneda" => $moneda,
                  "Total" => number_format($subtotal*1.160000, 2, '.', ''),
                  "TipoDeComprobante" => $fact_tipcompr,
                  "Exportacion"=> "01",
                  "MetodoPago" => $metodoDePago,
                  "LugarExpedicion" => $LugarExpedicion
                  )
          ); 

       
                
           
            
                $impuestos1 = $xml->createElement("cfdi:Impuestos");
                $impuestos1 = $root->appendChild($impuestos1);
                $this->cargaAtt($impuestos1,array(
                         "TotalImpuestosTrasladados"=>number_format($subtotal*0.160000, 2, '.', ''))
                         );
                   $traslados1 = $xml->CreateElement("cfdi:Traslados");
                   $traslados1 = $impuestos1->appendChild($traslados1);
                       $traslado1 = $xml->CreateElement("cfdi:Traslado");
                       $traslado1 = $traslados1->appendChild($traslado1);
                       $this->cargaAtt($traslado1,array(
                                "Base" => $subtotal,
                                "Impuesto"=>"002",
                                "TipoFactor"=>"Tasa",
                                "TasaOCuota"=>"0.160000",
                                "Importe"=>number_format($subtotal*0.160000, 2, '.', ''))
                               );
               

             
             return $xml->saveXML();
   }

   function crearXMLPagos($empresa, $factura_emisor, $pago, $detalles, $datos){ 

    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = substr( date('c'), 0, 19); 
    $noCertificado = $factura_emisor->n_certificado;
    $fact_serie = $factura_emisor->serie;
    $fact_folio = $factura_emisor->folio;
    $NoFac = $fact_serie.$fact_folio;
    $fact_tipcompr = $datos['tipo_comprobante'];
    $tasa_iva = 16;	
    $descuento = "0.00";
    $fecha = date('H:i:s'); //inicializo la fecha con la hora
    $nuevafecha = strtotime ( '-1 hour' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'H:i:s' , $nuevafecha );
    $fecha_fact = date("Y-m-d")."TT".$nuevafecha;
    $NumCtaPago = "6473";
    $condicionesDePago = "CONDICIONES";
    $TipoCambio = 1;
    $LugarExpedicion = $factura_emisor->codigo;
    $moneda = $datos['moneda'];
    $xml = new \DOMDocument;
    $root = $xml->createElement("cfdi:Comprobante");
    $root = $xml->appendChild($root);
    $cadena_original='||';
    $noatt=array();


    $this->cargaAtt($root,array("xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/4",
    "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
    "xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd",
    "xmlns:pago20" => "http://www.sat.gob.mx/Pagos20",
   )
);

       
        if($datos['tipo_comprobante']=='E'){
    
        foreach ($datos['atiporelacion']  as $key => $value) {
        $tipo = $value;
        $uuid = $datos['auuid'][$key]; 
        $relacionados = $xml->createElement("cfdi:CfdiRelacionados");
        $relacionados = $root->appendChild($relacionados);
        $this->cargaAtt($relacionados, array("TipoRelacion" => $tipo)
        );
            $relacionado = $xml->createElement("cfdi:CfdiRelacionado");
            $relacionado = $relacionados->appendChild($relacionado);
            $this->cargaAtt($relacionado, array("UUID" => $uuid)
            );
         }
    
       }
    
        $emisor = $xml->createElement("cfdi:Emisor");
        $emisor = $root->appendChild($emisor);
        $this->cargaAtt($emisor, array("Rfc" => $factura_emisor->rfc,
                                "Nombre" => $factura_emisor->nombre,
                                "RegimenFiscal" => $factura_emisor->regimen)
                            );
        
                           
                            
        $receptor = $xml->createElement("cfdi:Receptor");
        $receptor = $root->appendChild($receptor);
        //$emisor->appendChild($expedido);
        $this->cargaAtt($receptor, array
        ("Rfc"=>$empresa->rfc,
          "Nombre"=>utf8_decode($empresa->nombre),
            "UsoCFDI"=>$datos['uso_cfdi'],
            "RegimenFiscalReceptor"=>$empresa->regimen,
            "DomicilioFiscalReceptor"=>$empresa->cp)
        );
        
    
        $conceptos1 = $xml->createElement("cfdi:Conceptos");  //Crear arreglo de conceptos para agregar al documento, reemplazar los valores en la cargaAtt
        $conceptos1 = $root->appendChild($conceptos1);
        $subtotal = 0;
      
        $concepto = $xml->createElement("cfdi:Concepto");
        $concepto = $conceptos1->appendChild($concepto);
        $this->cargaAtt($concepto, array(
                "ClaveProdServ"=> "84111506",
                "Cantidad"=> "1",
                 "ClaveUnidad"=> "ACT",
                 "Descripcion"=>  "Pago",
                 "ValorUnitario"=> "0",
                 "Importe"=>"0",
                 "ObjetoImp" => "01"));
        

        $complemento1 = $xml->createElement("cfdi:Complemento");  //Crear arreglo de conceptos para agregar al documento, reemplazar los valores en la cargaAtt
        $complemento1 = $root->appendChild($complemento1);
       
       foreach($pago as $pagod) {

       

        $pagos1 = $xml->createElement("pago20:Pagos");  //Crear arreglo de conceptos para agregar al documento, reemplazar los valores en la cargaAtt
        $pagos1 = $complemento1->appendChild($pagos1);
        $this->cargaAtt($pagos1, array("Version" => "2.0"));

        $vari = $pagod['monto'];
        $a = number_format(floatval($vari), 2, '.', '');
        $b = 0.160000;
        $base = number_format($a, 2, '.', '');
        $ivatotal=number_format($base*$b, 2, '.', '');
       
        $total = number_format($base+$ivatotal, 2, '.', '');

         //creamos el nodo TOTALES
         $totales = $xml->createElement("pago20:Totales");
         $totales = $pagos1->appendChild($totales);
         $this->cargaAtt($totales, array(
             "TotalRetencionesIVA"=>false,
             "TotalRetencionesISR"=>false,
             "TotalRetencionesIEPS"=>false,
             "TotalTrasladosBaseIVA16"=>$base,
             "TotalTrasladosImpuestoIVA16"=>$ivatotal,
             "TotalTrasladosBaseIVA8"=>false,
             "TotalTrasladosImpuestoIVA8"=>false,
             "TotalTrasladosBaseIVA0"=>false,
             "TotalTrasladosImpuestoIVA0"=>false,
             "TotalTrasladosBaseIVAExento"=>false,
             "MontoTotalPagos"=>$a,
         ));
 
        $pago = $xml->createElement("pago20:Pago");
        $pago = $pagos1->appendChild($pago);
        $this->cargaAtt($pago, array(
                   "FechaPago"=> $pagod['fecha']."T".$pagod['hora'],
                   "MonedaP"=> $pagod['moneda'],
                   "TipoCambioP"=>"1",
                   "FormaDePagoP"=> $pagod['fpago'],
                   "Monto"=> $a));  

        foreach($detalles as $detalle) {

        $bdr= number_format(floatval($detalle['impuestopago']), 2, '.', '');

        $pagodr = $xml->createElement("pago20:DoctoRelacionado");
        $pagodr = $pago->appendChild($pagodr);
        $this->cargaAtt($pagodr, array(
                   "IdDocumento"=> $detalle['uuid'],
                   "Serie"=> $detalle['serie'],
                   "Folio"=> $detalle['folio'],
                   "EquivalenciaDR"=>"1",
                   "NumParcialidad"=> $detalle['nparcialidades'],
                   "MonedaDR"=> $detalle['moneda'],
                   "ImpSaldoAnt"=> $detalle['impuestosa'],
                   "ImpSaldoInsoluto"=> $detalle['impuestosi'],
                   "ImpPagado"=> $detalle['impuestopago'],
                   "ObjetoImpDR"=>"02"));
         $impuestosDR = $xml->createElement("pago20:ImpuestosDR");
         $impuestosDR = $pagodr->appendChild($impuestosDR);    
         
       
          

        $trasladosDR = $xml->createElement("pago20:TrasladosDR");
        $trasladosDR = $impuestosDR->appendChild($trasladosDR);
        
          $trasladoDR = $xml->createElement("pago20:TrasladoDR");
          $trasladoDR = $trasladosDR->appendChild($trasladoDR);
          $this->cargaAtt($trasladoDR, array(
            "BaseDR"=>$bdr,
            "ImpuestoDR"=>"002",
            "TipoFactorDR"=>"Tasa",
            "TasaOCuotaDR"=>"0.160000",
            "ImporteDR"=>number_format($bdr*$b, 2, '.', ''),
          ));

         } 
         $impuestosP = $xml->createElement("pago20:ImpuestosP");
         $impuestosP = $pago->appendChild($impuestosP);


         $trasladosP = $xml->createElement("pago20:TrasladosP");
         $trasladosP = $impuestosP->appendChild($trasladosP);

         $trasladoP = $xml->createElement("pago20:TrasladoP");
         $trasladoP = $trasladosP->appendChild($trasladoP);
         $this->cargaAtt($trasladoP, array(
           "BaseP"=>$base,
           "ImpuestoP"=>"002",
           "TipoFactorP"=>"Tasa",
           "TasaOCuotaP"=>"0.160000",
           "ImporteP"=>$ivatotal,
         ));
        
        } 

     
          
        $foliox = $factura_emisor->folio+1; 
        $fecha = date('H:i:s'); //inicializo la fecha con la hora
        $nuevafecha = strtotime ( '-1 hour' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'H:i:s' , $nuevafecha );
        
        $this->cargaAtt($root, array(
                   "Version" => "4.0", 
                   "Serie" => $factura_emisor['serie'],
                   "Folio" => $foliox, 
                   "Fecha" =>date("Y-m-d")."T".$nuevafecha,
                   "Sello" => "@",
                   "NoCertificado" => $noCertificado, 
                   "Certificado" => "@", 
                   "SubTotal" => "0",
                   "Moneda" => "XXX",
                   "Total" => "0",
                   "TipoDeComprobante" => "P",
                   "Exportacion"=> "01",
                   "LugarExpedicion" => $LugarExpedicion)); 
       
       return $xml->saveXML();
    }

   function crearXMLprueba($empresa, $factura_emisor, $detalles, $datos, $folio, $clave){ 
  
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = substr( date('c'), 0, 19); 
    $noCertificado = $factura_emisor->n_certificado;
    $fact_serie = $clave;
    $fact_folio = $folio;
    $NoFac = $fact_serie.$fact_folio;
    $fact_tipcompr = $datos['tipo_comprobante'];
    $tasa_iva = 16;	
    $descuento = "0.00";
    $fecha = date('H:i:s'); //inicializo la fecha con la hora
    $nuevafecha = strtotime ( '-1 hour' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'H:i:s' , $nuevafecha );
    $fecha_fact = date("Y-m-d")."TTTTTT".$nuevafecha;
    $NumCtaPago = "6473";
    $condicionesDePago = "CONDICIONES";
    $formaDePago = $datos['fpago'];
    $metodoDePago = $datos['mpago'];
    $TipoCambio = 1;  
    $LugarExpedicion = $factura_emisor->codigo;
    $moneda = $datos['moneda'];
   
 
    $xml = new \DOMDocument('1.0', 'utf-8');
    $root = $xml->createElement("cfdi:Comprobante");
    $root = $xml->appendChild($root);
    $cadena_original='||';
    $noatt=array();
   
    $this->cargaAtt($root,array("xmlns:cfdi" => "http://www.sat.gob.mx/cfd/3",
                         "xmlns:xs" => "http://www.w3.org/2001/XMLSchema-instance",
                         "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
                         "xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd"
            
             )
    );

   

           
    if ($datos['tipo_comprobante']=='E'){
    
        foreach ($datos['atiporelacion']  as $key => $value) {
        $tipo = $value;
            $uuid = $datos['auuid'][$key]; 
            
    
        $relacionados = $xml->createElement("cfdi:CfdiRelacionados");
        $relacionados = $root->appendChild($relacionados);
        $this->cargaAtt($relacionados, array("TipoRelacion" => $tipo
                            )
                        );
    
    
                        $relacionado = $xml->createElement("cfdi:CfdiRelacionado");
                        $relacionado = $relacionados->appendChild($relacionado);
                        $this->cargaAtt($relacionado, array("UUID" => $uuid
                                            )
                                        );		
                                        
                                    }
    
    }
    
        $emisor = $xml->createElement("cfdi:Emisor");
        $emisor = $root->appendChild($emisor);
        $this->cargaAtt($emisor, array("Rfc" => $factura_emisor->rfc,
                                "Nombre" => $factura_emisor->nombre,
                                "RegimenFiscal" => $factura_emisor->regimen
                                )
                            );
        
                           
                            
        $receptor = $xml->createElement("cfdi:Receptor");
        $receptor = $root->appendChild($receptor);
        //$emisor->appendChild($expedido);
        $this->cargaAtt($receptor, array
        (   "Rfc"=>$empresa->rfc,
            "Nombre"=>$empresa->nombre,
            "UsoCFDI"=>$datos['uso_cfdi'],
            "RegimenFiscalReceptor"=>$empresa->regimen,
		    "DomicilioFiscalReceptor"=>$empresa->cp,
            )
         );
        
    
        $conceptos1 = $xml->createElement("cfdi:Conceptos");  //Crear arreglo de conceptos para agregar al documento, reemplazar los valores en la cargaAtt
        $conceptos1 = $root->appendChild($conceptos1);
        $subtotal = 0;
       foreach($detalles as $detalle) {
         
           $pproducto = number_format($detalle['precio'], 2, '.', ''); 
           $cantidad =  number_format($detalle['cantidad'], 6, '.', '');
           $tp = number_format($cantidad*$pproducto, 2, '.', '');
           echo $cantidad;
           echo "<br />";
           echo $tp;
           echo "<br />";
           $subtotal += $tp;
           
               
            $concepto = $xml->createElement("cfdi:Concepto");
            $concepto = $conceptos1->appendChild($concepto);
            $this->cargaAtt($concepto, array(
              "ClaveProdServ"=> $detalle['codigo_sat'],
              "NoIdentificacion"=> $detalle['id'],
              "Cantidad"=> $cantidad,
               "ClaveUnidad"=> $detalle['unidad_sat'],
               "Economico"=> $detalle['economico'],
               "Placas"=> $detalle['placas'],
               "Kilometraje"=> $detalle['kilometraje'],
               "NSolicitud"=> $detalle['nsolicitud'],
               "Unidad"=> $detalle['unidad'],
               "Descripcion"=>  $detalle['descripcion'],
               "ValorUnitario"=> $pproducto ,
               "Importe"=>$tp,
               "ObjetoImp" => "02",
               "Descuento"=> 0));
             $impuestos = $xml->createElement("cfdi:Impuestos");
             $impuestos = $concepto->appendChild($impuestos);
                  $traslados = $xml->createElement("cfdi:Traslados");
                  $traslados = $impuestos->appendChild($traslados);
                       $traslado = $xml->createElement("cfdi:Traslado");
                       $traslado = $traslados->appendChild($traslado);
                       $this->cargaAtt($traslado,array(
                           "Base"=>$tp,
                           "Impuesto"=>"002",
                           "TipoFactor"=>"Tasa",
                           "TasaOCuota"=>"0.160000",
                           "Importe"=>$tp*0.16)
                           );
       
      } ;

     
          
          $foliox = $folio+1;
          $fecha = date('H:i:s'); //inicializo la fecha con la hora
          $nuevafecha = strtotime ( '-1 hour' , strtotime ( $fecha ) ) ;
          $nuevafecha = date ( 'H:i:s' , $nuevafecha );
          
          
          $this->cargaAtt($root, array(
            "Version" => "4.0", 
            "Serie" => $clave,
            "Folio" => $foliox, 
            "Fecha" =>date("Y-m-d")."T".$nuevafecha,
            "Sello" => "@",
            "FormaPago" => $formaDePago,
            "NoCertificado" => $noCertificado, 
            "Certificado" => "@", 
            "CondicionesDePago" => $condicionesDePago,
            "SubTotal" => number_format($subtotal, 2, '.', ''),
            "Descuento" => 0.0,
            "Moneda" => $moneda,
            "Total" => number_format($subtotal*1.160000, 2, '.', ''),
            "TipoDeComprobante" => $fact_tipcompr,
            "Exportacion"=> "01",
            "MetodoPago" => $metodoDePago,
            "LugarExpedicion" => $LugarExpedicion
            )
    ); 

 
          
     
      
          $impuestos1 = $xml->createElement("cfdi:Impuestos");
          $impuestos1 = $root->appendChild($impuestos1);
          $this->cargaAtt($impuestos1,array(
                   "TotalImpuestosTrasladados"=>number_format($subtotal*0.160000, 2, '.', ''))
                   );
             $traslados1 = $xml->CreateElement("cfdi:Traslados");
             $traslados1 = $impuestos1->appendChild($traslados1);
                 $traslado1 = $xml->CreateElement("cfdi:Traslado");
                 $traslado1 = $traslados1->appendChild($traslado1);
                 $this->cargaAtt($traslado1,array(
                          "Base" => $subtotal,
                          "Impuesto"=>"002",
                          "TipoFactor"=>"Tasa",
                          "TasaOCuota"=>"0.160000",
                          "Importe"=>number_format($subtotal*0.160000, 2, '.', ''))
                         );
         

       
       return $xml->saveXML();
        
}


function crearXMLmas($empresa, $factura_emisor, $detalles, $datos){ 
  
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = substr( date('c'), 0, 19); 
    $noCertificado = $factura_emisor->n_certificado;
    $fact_serie = $factura_emisor->serie;
    $fact_folio = $factura_emisor->folio;
    $NoFac = $fact_serie.$fact_folio;
    $fact_tipcompr = $datos['tipo_comprobante'];
    $tasa_iva = 16;	
    $descuento = "0.00";
    $fecha = date('H:i:s'); //inicializo la fecha con la hora
    $nuevafecha = strtotime ( '-1 hour' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'H:i:s' , $nuevafecha );
    $fecha_fact = date("Y-m-d")."TTTT".$nuevafecha;
    $NumCtaPago = "6473";
    $condicionesDePago = "CONDICIONES";
    $formaDePago = $datos['fpago'];
    $metodoDePago = $datos['mpago'];
    $TipoCambio = 1;
    $LugarExpedicion = $factura_emisor->codigo;
    $moneda = $datos['moneda'];
   
 
    $xml = new \DOMDocument('1.0', 'utf-8');
    $root = $xml->createElement("cfdi:Comprobante");
    $root = $xml->appendChild($root);
    $cadena_original='||';
    $noatt=array();
   
    $this->cargaAtt($root,array("xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/4",
    "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
    "xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd"
    )
    );

   

           
    if ($datos['tipo_comprobante']=='E'){
    
        foreach ($datos['atiporelacion']  as $key => $value) {
        $tipo = $value;
            $uuid = $datos['auuid'][$key]; 
            
    
        $relacionados = $xml->createElement("cfdi:CfdiRelacionados");
        $relacionados = $root->appendChild($relacionados);
        $this->cargaAtt($relacionados, array("TipoRelacion" => $tipo
                            )
                        );
    
    
                        $relacionado = $xml->createElement("cfdi:CfdiRelacionado");
                        $relacionado = $relacionados->appendChild($relacionado);
                        $this->cargaAtt($relacionado, array("UUID" => $uuid
                                            )
                                        );		
                                        
                                    }
    
    }
    
        $emisor = $xml->createElement("cfdi:Emisor");
        $emisor = $root->appendChild($emisor);
        $this->cargaAtt($emisor, array("Rfc" => $factura_emisor->rfc,
                                "Nombre" => $factura_emisor->nombre,
                                "RegimenFiscal" => $factura_emisor->regimen
                                )
                            );
        
                           
                            
        $receptor = $xml->createElement("cfdi:Receptor");
        $receptor = $root->appendChild($receptor);
        //$emisor->appendChild($expedido);
        $this->cargaAtt($receptor, array
        (   "Rfc"=>$empresa->rfc,
            "Nombre"=>$empresa->nombre,
            "UsoCFDI"=>$datos['uso_cfdi'],
            "RegimenFiscalReceptor"=>$empresa->regimen,
		    "DomicilioFiscalReceptor"=>$empresa->cp,
            )
         );
        
    
        $conceptos1 = $xml->createElement("cfdi:Conceptos");  //Crear arreglo de conceptos para agregar al documento, reemplazar los valores en la cargaAtt
        $conceptos1 = $root->appendChild($conceptos1);
        $subtotal = 0;
       foreach($detalles as $detalle) {
         
           $pproducto = number_format($detalle['precio'], 2, '.', ''); 
           $cantidad =  number_format($detalle['cantidad'], 6, '.', '');
           $tp = number_format($cantidad*$pproducto, 2, '.', '');
           echo $cantidad;
           echo "<br />";
           echo $tp;
           echo "<br />";
           $subtotal += $tp;
           
               
            $concepto = $xml->createElement("cfdi:Concepto");
            $concepto = $conceptos1->appendChild($concepto);
            $this->cargaAtt($concepto, array(
              "ClaveProdServ"=> $detalle['codigo_sat'],
              "NoIdentificacion"=> $detalle['id'],
              "Cantidad"=> $cantidad,
               "ClaveUnidad"=> $detalle['unidad_sat'],
               "Unidad"=> $detalle['unidad'],
               "Descripcion"=>  'Economico:'.$detalle['economico'].' '.'Placas:'.$detalle['placas'].' '.'Kilometraje:'.$detalle['kilometraje'].' '.'N. Solicitud:'.$detalle['nsolicitud'].' '.'Descripcion: '.$detalle['descripcion'],
               "ValorUnitario"=> $pproducto ,
               "Importe"=>$tp,
               "ObjetoImp" => "02",
               "Descuento"=> 0));
             $impuestos = $xml->createElement("cfdi:Impuestos");
             $impuestos = $concepto->appendChild($impuestos);
                  $traslados = $xml->createElement("cfdi:Traslados");
                  $traslados = $impuestos->appendChild($traslados);
                       $traslado = $xml->createElement("cfdi:Traslado");
                       $traslado = $traslados->appendChild($traslado);
                       $this->cargaAtt($traslado,array(
                           "Base"=>$tp,
                           "Impuesto"=>"002",
                           "TipoFactor"=>"Tasa",
                           "TasaOCuota"=>"0.160000",
                           "Importe"=>$tp*0.16)
                           );
       
      } ;

     
          
           $foliox = $factura_emisor->folio+1;
           $fecha = date('H:i:s'); //inicializo la fecha con la hora
           $nuevafecha = strtotime ( '-1 hour' , strtotime ( $fecha ) ) ;
           $nuevafecha = date ( 'H:i:s' , $nuevafecha );
          
          
          $this->cargaAtt($root, array(
            "Version" => "4.0", 
            "Serie" => $factura_emisor->serie,
            "Folio" => $foliox, 
            "Fecha" =>date("Y-m-d")."T".$nuevafecha,
            "Sello" => "@",
            "FormaPago" => $formaDePago,
            "NoCertificado" => $noCertificado, 
            "Certificado" => "@", 
            "CondicionesDePago" => $condicionesDePago,
            "SubTotal" => number_format($subtotal, 2, '.', ''),
            "Descuento" => 0.0,
            "Moneda" => $moneda,
            "Total" => number_format($subtotal*1.160000, 2, '.', ''),
            "TipoDeComprobante" => $fact_tipcompr,
            "Exportacion"=> "01",
            "MetodoPago" => $metodoDePago,
            "LugarExpedicion" => $LugarExpedicion
            )
    ); 

 
          
     
      
          $impuestos1 = $xml->createElement("cfdi:Impuestos");
          $impuestos1 = $root->appendChild($impuestos1);
          $this->cargaAtt($impuestos1,array(
                   "TotalImpuestosTrasladados"=>number_format($subtotal*0.160000, 2, '.', ''))
                   );
             $traslados1 = $xml->CreateElement("cfdi:Traslados");
             $traslados1 = $impuestos1->appendChild($traslados1);
                 $traslado1 = $xml->CreateElement("cfdi:Traslado");
                 $traslado1 = $traslados1->appendChild($traslado1);
                 $this->cargaAtt($traslado1,array(
                          "Base" => $subtotal,
                          "Impuesto"=>"002",
                          "TipoFactor"=>"Tasa",
                          "TasaOCuota"=>"0.160000",
                          "Importe"=>number_format($subtotal*0.160000, 2, '.', ''))
                         );
         

       
       return $xml->saveXML();
        
}

function generarPDFpruebaX($nombrexml, $logo, $observaciones){
    
    
    $xml = new \SimpleXMLElement ($nombrexml,null,true);   
    $ns = $xml->getNamespaces(true);
    $xml->registerXPathNamespace('c', $ns['cfdi']);
   

    // Queremos hacer en pdf la factura numero 1 de la tipica BBDD de facturacion
    $pdf = new PDF_Mc_Table2();     
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
  
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
 
    $pdf->SetXY(10, 5);
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(0,8,"Factura  ".$cfdi1." ".$cfdi2,1,1,"C",true);
  
    // Imprimimos el logo a 300 ppp
    $pdf->Image(public_path().'/img/'.$logo,15,15,-250);
    
    // Consulta a la base de datos para sacar cosas de la factura 1
   
   
    
    // 1º Datos del cliente
    
   
   
    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
    $emisor1 = $Emisor['Nombre'];
    $emisor2 = $Emisor['Rfc'];
    $emisor3 = $Emisor['RegimenFiscal'];
  
    $regi1 = $this->rgmen($emisor3);
    $texto1=" ".$Emisor['Nombre']." \n  RFC: ".$Emisor['Rfc']." \n No de serie del Certificado del CSD:".$cfdi11."  \n Folio Fiscal: "." \n Regimen: ".$regi1;
    $pdf->SetXY(70, 13);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",8);
    $pdf->MultiCell(130,8,$texto1,1,"L");

    $pdf->SetXY(150, 13);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",8);
    $pdf->MultiCell(50,6,$observaciones,1,"L");
    
   
    $pdf->SetXY(10, 53);
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(0,8," DATOS DEL CLIENTE                                                                              EXPEDIDO EN",1,1,"L",true);

    $Receptor1 = $Receptor['Nombre'];
    $Receptor2 = $Receptor['Rfc'];
    $Receptor3 = $this->uso($Receptor['UsoCFDI']);

    
   
    $texto1=" ".$Receptor1." \n RFC:".$Receptor2." \n Uso CFDI:".$Receptor3;
    $pdf->SetXY(10, 61);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",8);
    $pdf->MultiCell(90,5,$texto1,1,"L");
   
    $texto2=" C.P.".$cfdi." \n ".utf8_decode("Fecha y hora de emisión:");
    $pdf->SetXY(100, 61);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",8);
    $pdf->MultiCell(0,6,$texto2,0,"L");
    }
    }
    $pdf->SetXY(10, 80);
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont("Arial","B",5);
    $pdf->Cell(20,6,"CANTIDAD",1,0,"C",true);
    $pdf->Cell(25,6,"U. MEDIDA",1,0,"C",true);
    $pdf->Cell(70,6,"DESCRIPCION",1,0,"C",true);
    $pdf->Cell(25,6,"V. UNITARIO",1,0,"C",true);
    $pdf->Cell(25,6,"% DESCUENTO",1,0,"C",true);
    $pdf->Cell(25,6,"IMPORTE",1,1,"C",true);
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
    $c1 = $this->amoneda($vunit,"pesos");
    $t1 = $this->amoneda($import,"pesos");
    $pdf->Row(array($cantidad,$claveunidad." - ".$unidad,utf8_decode($claveser." - ".$descripcion),$c1,0,$t1)); 
    
   
        }
      
    
    $ivas = $cfdi4*0.16;
    $pdf->SetFont("Arial","B",8);	

    // 4º Los totales, IVAs y demás
    $pdf->Line(10,175,200,175);
    $pdf->SetXY(150,180);
    $sub = $this->amoneda($cfdi4,"pesos");
    $pdf->Cell(25,5,"Subtotal:",1,0,"C");
    $pdf->Cell(25,5,$sub,1,1,"R");
    $pdf->SetXY(150,186);
    $ivan = $this->amoneda($ivas,"pesos");
    $pdf->Cell(25,5,"IVA (16%): ",1,0,"C");
    $pdf->Cell(25,5,$ivan,1,1,"R");
    $pdf->SetXY(150,192);
    $tt =$this->amoneda($cfdi3,"pesos");
    $pdf->Cell(25,5,"Total:",1,0,"C");
    $pdf->Cell(25,5,$tt,1,1,"R");
    
    $numl = new NumLetras();   
    
    $texto1=$numl->numletras($cfdi3,1);
 
    $pdf->SetXY(10, 181);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",8);
    $pdf->MultiCell(135,3,"CANTIDAD CON LETRA: ".$texto1." ".$this->mone($cfdi8),0,"L");
    $pdf->SetXY(10, 185);
    $pdf->MultiCell(135,3,"MONEDA: ".$this->mone($cfdi8)." | METODO DE PAGO: ".$this->metodope($cfdi9)." | FORMA PAGO: ".$this->formap($cfdi10)." ",0,"L");
    $pdf->SetXY(10, 193);
   
  
  
    
    
     }
    

    
    $pdf->Line(10,275,200,275);
    
    $pdf->Text(10,280,utf8_decode("Este documento es una representación impresa de un CFDI de prueba sin ningun valor "));
    
    // El documento enviado al navegador
    $pdf->Output(public_path().'/facturas/factura_prueba.pdf',"F");	
    
    return public_path().'/facturas/factura_prueba.pdf';
        
    }

   function sellarXML($cfdi, $numero_certificado, $archivo_cer, $archivo_pem) {
	
    $private = openssl_pkey_get_private(file_get_contents($archivo_pem));
    $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($archivo_cer)));
    
    $xdoc = new \DomDocument();
    $xdoc->loadXML($cfdi) or die("XML invalido");
   
    $c = $xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0); 
    $c->setAttribute('Certificado', $certificado);
    $c->setAttribute('NoCertificado', $numero_certificado);
    
    $XSL = new \DOMDocument();
    $XSL->load(public_path().'/utilerias/xslt33/cadenaoriginal_3_3.xslt');
   
    $proc = new \XSLTProcessor;
    $proc->importStyleSheet($XSL);

    $cadena_original = $proc->transformToXML($xdoc);
    openssl_sign($cadena_original, $sig, $private, OPENSSL_ALGO_SHA256);
    $sello = base64_encode($sig);

    $c->setAttribute('Sello', $sello);
    
		return $xdoc->saveXML();
}

function satxmlsv40_sella($cfdi, $numero_certificado, $archivo_cer, $archivo_pem) {


	$pkeyid = openssl_get_privatekey(file_get_contents($archivo_pem));
	$xdoc = new \DOMDocument("1.0","UTF-8");
    $xdoc->loadXML($cfdi) or die("XML invalido");

	openssl_sign($this->satxmlsv40_genera_cadena_original($xdoc), $crypttext, $pkeyid, OPENSSL_ALGO_SHA256);
	openssl_free_key($pkeyid);
	$c = $xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/4', 'Comprobante')->item(0);  
	$sello = base64_encode($crypttext);      // lo codifica en formato base64
	$c->setAttribute("Sello",$sello);
	 
	$datos = file($archivo_cer);
	$certificado = ""; $carga=false;
	for ($i=0; $i<sizeof($datos); $i++) {
		if (strstr($datos[$i],"END CERTIFICATE")) $carga=false;
		if ($carga) $certificado .= trim($datos[$i]);
		if (strstr($datos[$i],"BEGIN CERTIFICATE")) $carga=true;
	}
	// El certificado como base64 lo agrega al XML para simplificar la validacion
	$c->setAttribute("Certificado",$certificado);
	$c->setAttribute('NoCertificado', $numero_certificado);
	return $xdoc->saveXML();
	}

function generarPDFprueba($nombrexml, $logo, $observaciones){

    $GLOBALS["nombrexml"] = $nombrexml;
    $GLOBALS["logo"] = $logo;
    $GLOBALS["observaciones"] = $observaciones;
            
       $xml = new \SimpleXMLElement ($nombrexml,null,true);
         $ns = $xml->getNamespaces(true);
         $xml->registerXPathNamespace('c', $ns['cfdi']);
                                
            // Queremos hacer en pdf la factura numero 1 de la tipica BBDD de facturacion
            $pdf = new PDFP();
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
                $economico        = $Conceptos['Economico'];
                $placas        = $Conceptos['Placas'];
                $kilometraje        = $Conceptos['Kilometraje'];
                $nsolicitud        = $Conceptos['NSolicitud'];
                $vunit        = $Conceptos['ValorUnitario'];
                $import        = $Conceptos['Importe'];
             
                $pdf->SetX(10);
                $pdf->SetWidths(array(15,15,15,15,90,20,20));
                //un arreglo con alineacion de cada celda
                $pdf->SetAligns(array('C','C','C','C','L','C','C'));
                //OTro arreglo pero con el contenido
                //utf8_decode es para que escriba bien
                //los acentos. 
                $pdf->Row(array($economico,$placas,$nsolicitud,$kilometraje,utf8_decode($claveser." - ".$descripcion),$this->amoneda($vunit,"pesos"),$this->amoneda($import,"pesos"))); 
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
                    $pdf->Cell(25,5,$this->amoneda($cfdi4p,"pesos"),1,1,"R");
                    $pdf->SetX(150);
                    $pdf->Cell(25,5,"IVA (16%): ",1,0,"C");
                    $pdf->Cell(25,5,$this->amoneda($iva55,"pesos"),1,1,"R");
                    $pdf->SetX(150);
                    $pdf->Cell(25,5,"Retenciones: ",1,0,"C");
                    $pdf->Cell(25,5,$this->amoneda($isr55,"pesos"),1,1,"R");
                    $pdf->SetX(150);
                    $pdf->Cell(25,5,"Total:",1,0,"C");
                    $pdf->Cell(25,5,$this->amoneda($cfdi3p,"pesos"),1,1,"R");
                    $numl = new NumLetras();  
                    $pdf->ln(3);
                    $texto1 = $numl->numletras($cfdi3p,1);
                    $pdf->SetX(10);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont("Arial","B",10);
                    $pdf->Cell(45,4,"CANTIDAD CON LETRA: ",0,0,"L");
                    $pdf->SetFont("Arial","",10);
                    $pdf->Cell(145,4,$texto1." ".$this->mone($cfdi8),0,1,"L");
    
                    $pdf->SetX(10);
                    $pdf->SetFont("Arial","B",10);
                    $pdf->Cell(18,4,"MONEDA: ",0,0,"L");
                    $pdf->SetFont("Arial","",10);
                    $pdf->Cell(25,4,$this->mone($cfdi8),0,0,"L");
                    $pdf->SetFont("Arial","B",10);
                    $pdf->Cell(38,4," |   METODO DE PAGO: ",0,0,"L");
                    $pdf->SetFont("Arial","",10);
                    $pdf->Cell(58,4,$this->metodope($cfdi9),0,1,"L");
                    $pdf->SetFont("Arial","B",10);
                    $pdf->Cell(29,4,"FORMA PAGO: ",0,0,"L");
                    $pdf->SetFont("Arial","",10);
                    $pdf->Cell(30,4,$this->formap($cfdi10)." ",0,1,"L");
                    $pdf->SetX(10);
                    $pdf->SetFont("Arial","B",10);
                    $pdf->Cell(35,4,"FECHA TIMBRADO: ",0,0,"L");
                    $pdf->SetFont("Arial","",10);
                    $pdf->Cell(155,4,'',0,1,"L");
                    $pdf->SetX(10);
                    $pdf->SetFont("Arial","B",10);
                   
                    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
                        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
                        $emisor1 = $Emisor['Nombre'];
                        $emisor2 = $Emisor['Rfc'];
                        $emisor3 = $Emisor['RegimenFiscal'];
                    $Receptor1 = $Receptor['Nombre'];
                    $Receptor2 = $Receptor['Rfc'];
                    $Receptor3 = $this->uso($Receptor['UsoCFDI']);
                        }}
                  
                    
                    $pdf->ln(3);
                    $texto1 = "Sello Digital del CFDi ";
                    $pdf->SetX(10);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont("Arial","B",10);
                    $pdf->MultiCell(190,4,$texto1,0,"L");
                    $pdf->SetFont("Arial","",8);
                    $pdf->MultiCell(190,4,'',0,"L");
                    
    
            
                    
                
            
            // El documento enviado al navegador
            $pdf->Output(public_path().'/facturas/factura_prueba.pdf',"F");	
    
            return public_path().'/facturas/factura_prueba.pdf';
                
}  

function generarPDFmas($nombrexml, $logo, $observaciones){

    $GLOBALS["nombrexml"] = $nombrexml;
    $GLOBALS["logo"] = $logo;
    $GLOBALS["observaciones"] = $observaciones;
            
       $xml = new \SimpleXMLElement ($nombrexml,null,true);
         $ns = $xml->getNamespaces(true);
         $xml->registerXPathNamespace('c', $ns['cfdi']);
                                
            // Queremos hacer en pdf la factura numero 1 de la tipica BBDD de facturacion
            $pdf = new PDFPMAS();
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
                $pdf->SetWidths(array(15,15,120,20,20));
                //un arreglo con alineacion de cada celda
                $pdf->SetAligns(array('C','C','L','C','C'));
                //OTro arreglo pero con el contenido
                //utf8_decode es para que escriba bien
                //los acentos. 
                $pdf->Row(array($cantidad,$unidad.'-'.$claveunidad,utf8_decode($claveser." - ".$descripcion),$this->amoneda($vunit,"pesos"),$this->amoneda($import,"pesos"))); 
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
                    $pdf->Cell(25,5,$this->amoneda($cfdi4p,"pesos"),1,1,"R");
                    $pdf->SetX(150);
                    $pdf->Cell(25,5,"IVA (16%): ",1,0,"C");
                    $pdf->Cell(25,5,$this->amoneda($iva55,"pesos"),1,1,"R");
                    $pdf->SetX(150);
                    $pdf->Cell(25,5,"Retenciones: ",1,0,"C");
                    $pdf->Cell(25,5,$this->amoneda($isr55,"pesos"),1,1,"R");
                    $pdf->SetX(150);
                    $pdf->Cell(25,5,"Total:",1,0,"C");
                    $pdf->Cell(25,5,$this->amoneda($cfdi3p,"pesos"),1,1,"R");
                    $numl = new NumLetras();  
                    $pdf->ln(3);
                    $texto1 = $numl->numletras($cfdi3p,1);
                    $pdf->SetX(10);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont("Arial","B",10);
                    $pdf->Cell(45,4,"CANTIDAD CON LETRA: ",0,0,"L");
                    $pdf->SetFont("Arial","",10);
                    $pdf->Cell(145,4,$texto1." ".$this->mone($cfdi8),0,1,"L");
    
                    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
                        $sello4 = $tfd['NoCertificadoSAT'];
                        $sello5 = $tfd['UUID'];
                        $sello1 = $tfd['SelloCFD'];
                        $sello2 = $tfd['SelloSAT'];
                        $cfdi99 = $tfd['FechaTimbrado'];
                    }

                    $pdf->SetX(10);
                    $pdf->SetFont("Arial","B",10);
                    $pdf->Cell(18,4,"MONEDA: ",0,0,"L");
                    $pdf->SetFont("Arial","",10);
                    $pdf->Cell(25,4,$this->mone($cfdi8),0,0,"L");
                    $pdf->SetFont("Arial","B",10);
                    $pdf->Cell(38,4," |   METODO DE PAGO: ",0,0,"L");
                    $pdf->SetFont("Arial","",10);
                    $pdf->Cell(58,4,$this->metodope($cfdi9),0,1,"L");
                    $pdf->SetFont("Arial","B",10);
                    $pdf->Cell(29,4,"FORMA PAGO: ",0,0,"L");
                    $pdf->SetFont("Arial","",10);
                    $pdf->Cell(30,4,$this->formap($cfdi10)." ",0,1,"L");
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
                    
                        
                    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
                        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
                        $emisor1 = $Emisor['Nombre'];
                        $emisor2 = $Emisor['Rfc'];
                        $emisor3 = $Emisor['RegimenFiscal'];
                    $Receptor1 = $Receptor['Nombre'];
                    $Receptor2 = $Receptor['Rfc'];
                    $Receptor3 = $this->uso($Receptor['UsoCFDI']);
                        }}
                  
                    
                        
                       $this->generarPNG($nombrexml,"https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=".$sello5."&re=".$emisor2."&rr=".$Receptor2."&tt=".number_format(floatval($cfdi3p),6)."&fe=".substr($sello1,-8));
                       
                       
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
                       $pdf->MultiCell(190,4,$this->satxmlsv40_genera_cadena_original($xml),0,"L");
                                       
                       $pdf->Image($nombrexml.'.png',10,220,-85);
                    
    
            
                    
                
            
            // El documento enviado al navegador
            $pdf->Output(public_path().'/facturas/'.$cfdi1.''.$cfdi2.'-'.$emisor2.'-'.$sello5.'.pdf',"F");	
    
            return public_path().'/facturas/'.$cfdi1.''.$cfdi2.'-'.$emisor2.'-'.$sello5.'.pdf';
                
}  

function generarPDF($nombrexml, $logo, $observaciones){
    
    
     
    $xml = new \SimpleXMLElement ($nombrexml,null,true);
   
    $ns = $xml->getNamespaces(true);
   
    $xml->registerXPathNamespace('c', $ns['cfdi']);
   
    $xml->registerXPathNamespace('t', $ns['tfd']);
   


    // Queremos hacer en pdf la factura numero 1 de la tipica BBDD de facturacion
    $pdf = new PDF_Mc_Table();
  
    $pdf->AddPage();
  
    $pdf->SetFont('Arial','B',12);
  
    
    foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
    $cfdi = $cfdiComprobante['LugarExpedicion'];
    $cfdi1 = $cfdiComprobante['Serie'];
    $cfdi2 = $cfdiComprobante['Folio'];
    $cfdi3 = $cfdiComprobante['Total'];
    $cfdi4 = $cfdiComprobante['SubTotal'];
    $cfdi4211 = $cfdiComprobante['Total'];
    $cfdi8 = $cfdiComprobante['Moneda'];
    $cfdi9 = $cfdiComprobante['MetodoPago'];
    $cfdi10 = $cfdiComprobante['FormaPago'];
    $cfdi11 = $cfdiComprobante['NoCertificado'];
 
    $pdf->SetXY(10, 5);
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(0,8,"Factura  ".$cfdi1." ".$cfdi2,1,1,"C",true);
  
    // Imprimimos el logo a 300 ppp
    $pdf->Image(public_path().'/img/'.$logo,15,15,-250);
    
    // Consulta a la base de datos para sacar cosas de la factura 1
   
   
    
    // 1º Datos del cliente
    $xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
    $sello4 = $tfd['NoCertificadoSAT'];
    $sello5 = $tfd['UUID'];
   
    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
    foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
    $emisor1 = $Emisor['Nombre'];
    $emisor2 = $Emisor['Rfc'];
    $emisor3 = $Emisor['RegimenFiscal'];
  
    $regi1 = $this->rgmen($emisor3);
    $texto1=" ".$Emisor['Nombre']." \n  RFC: ".$Emisor['Rfc']." \n No de serie del Certificado del CSD:".$cfdi11."  \n Folio Fiscal: ".$sello5." \n Regimen: ".$regi1." \n Exportacion: 01";
    $pdf->SetXY(70, 13);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",8);
    $pdf->MultiCell(130,6,$texto1,1,"L");
    
   
    $pdf->SetXY(150, 13);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",8);
    $pdf->MultiCell(50,6,$observaciones,1,"L");
    }
   
    $pdf->SetXY(10, 53);
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(0,8," DATOS DEL CLIENTE                                                                              EXPEDIDO EN",1,1,"L",true);

    $Receptor1 = utf8_decode($Receptor['Nombre']);
    $Receptor2 = $Receptor['Rfc'];
    $Regimen2 =  $this->rgmen($Receptor['RegimenFiscalReceptor']);
    $Domicilio2 = $Receptor['DomicilioFiscalReceptor'];
    $Receptor2 = $Receptor['Rfc'];
    $Receptor3 = $this->uso($Receptor['UsoCFDI']);
     $sello1 = $tfd['SelloCFD'];
     $sello2 = $tfd['SelloSAT'];

    
    $rec = $this->generarPNG($nombrexml,"https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=".$sello5."&re=".$emisor2."&rr=".$Receptor2."&tt=".number_format(floatval($cfdi3),6)."&fe=".substr($sello1,-8));
   
    $cfdi99 = $tfd['FechaTimbrado'];
    $texto1=" ".$Receptor1." \n RFC:".$Receptor2." \n Domicilio Fiscal:".$Domicilio2.utf8_decode(" \n Régimen::").$Regimen2." \n Uso CFDI:".$Receptor3;
    $pdf->SetXY(10, 61);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",8);
    $pdf->MultiCell(90,4,$texto1,1,"L");
   
    $texto2=" C.P.".$cfdi." \n ".utf8_decode("Fecha y hora de emisión:").$cfdi99;
    $pdf->SetXY(100, 61);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",8);
    $pdf->MultiCell(0,6,$texto2,0,"L");
    }
    }
    $pdf->SetXY(10, 83);
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont("Arial","B",5);
    $pdf->Cell(15,6,"CANTIDAD",1,0,"C",true);
    $pdf->Cell(25,6,"U. MEDIDA",1,0,"C",true);
    $pdf->Cell(70,6,"DESCRIPCION",1,0,"C",true);
    $pdf->Cell(20,6,"V. UNITARIO",1,0,"C",true);
    $pdf->Cell(20,6,"% DESCUENTO",1,0,"C",true);
    $pdf->Cell(20,6,"IMPORTE",1,0,"C",true);
    $pdf->Cell(20,6,"OBJ. DE IMPUESTO",1,1,"C",true);
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
        $obj = $Conceptos['ObjetoImp'];
     
    $pdf->SetX(10);
    $pdf->SetWidths(array(15,25,70,20,20,20,20));
    //un arreglo con alineacion de cada celda
    $pdf->SetAligns(array('C','C','L','C','C','C','C'));
    //OTro arreglo pero con el contenido
    //utf8_decode es para que escriba bien
    //los acentos. 
    $c1 = $this->amoneda($vunit,"pesos");
    $t1 = $this->amoneda($import,"pesos");
    $pdf->Row(array($cantidad,$claveunidad." - ".$unidad,utf8_decode($claveser." - ".$descripcion),$c1,0,$t1,$obj)); 
    
   
        }

        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos') as $Impuestos){  // SECCION EMISOR
            $ivafactura  = $Impuestos['TotalImpuestosTrasladados'];
        }   
      
    
    $ivas = $ivafactura;
    $pdf->SetFont("Arial","B",8);	

    // 4º Los totales, IVAs y demás
    $pdf->Line(10,198,200,198);
    $pdf->SetXY(150,200);
    $sub = $this->amoneda($cfdi4,"pesos");
    $pdf->Cell(25,5,"Subtotal:",1,0,"C");
    $pdf->Cell(25,5,$sub,1,1,"R");
    $pdf->SetXY(150,206);
    $ivan = $this->amoneda($ivas,"pesos");
    $pdf->Cell(25,5,"IVA (16%): ",1,0,"C");
    $pdf->Cell(25,5,$ivan,1,1,"R");
    $pdf->SetXY(150,212);
    $tt =$this->amoneda($cfdi3,"pesos");
    $pdf->Cell(25,5,"Total:",1,0,"C");
    $pdf->Cell(25,5,$tt,1,1,"R");
    
    $numl = new NumLetras();   
    
    $texto1=$numl->numletras($cfdi3,1);
 
    $pdf->SetXY(10, 201);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",6);
    $pdf->MultiCell(135,3,"CANTIDAD CON LETRA: ".$texto1." ".$this->mone($cfdi8),0,"L");
    $pdf->SetXY(10, 209);
    $pdf->MultiCell(135,3,"MONEDA: ".$this->mone($cfdi8)." | METODO DE PAGO: ".$this->metodope($cfdi9)." | FORMA PAGO: ".$this->formap($cfdi10)." ",0,"L");
    $pdf->SetXY(10, 217);
    $pdf->MultiCell(135,2,"FECHA TIMBRADO: ".$cfdi99,0,"L");
    $pdf->SetXY(10, 221);
    $pdf->MultiCell(135,2,"No. de Serie del Certificado del SAT: ".$sello4,0,"L");
  
  
    $texto1="Sello Digital del CFDi ".$sello1;
    $pdf->SetXY(10, 225);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",4);
    $pdf->MultiCell(135,3,$texto1,0,"L");
    
    $texto1="Sello Digital del SAT ".$sello2;
    $pdf->SetXY(10, 240);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",4);
    $pdf->MultiCell(135,3,$texto1,0,"L");
    
    $texto1=utf8_decode("Cadena Original del complemento de certificación digital del SAT ").$this->satxmlsv40_genera_cadena_original($xml);
    $pdf->SetXY(10, 255);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont("Arial","",4);
    $pdf->MultiCell(135,3,$texto1,0,"L");
    
     }
    
    $pdf->Image($nombrexml.'.png',143,225,-85);
    
    $pdf->Line(10,275,200,275);
    
    $pdf->Text(10,280,utf8_decode("Este documento es una representación impresa de un CFDI"));
    
    // El documento enviado al navegador
    $pdf->Output(public_path().'/facturas/'.$cfdi1.''.$cfdi2.'-'.$emisor2.'-'.$sello5.'.pdf',"F");	
    
    return public_path().'/facturas/'.$cfdi1.''.$cfdi2.'-'.$emisor2.'-'.$sello5.'.pdf';
        
    }

    function generarPDFPagos($nombrexml, $logo, $observaciones){
    
    
     
        $xml = new \SimpleXMLElement ($nombrexml,null,true);
        $ns = $xml->getNamespaces(true);
        $xml->registerXPathNamespace('c', $ns['cfdi']);
        $xml->registerXPathNamespace('t', $ns['tfd']);
       
    
    
        // Queremos hacer en pdf la factura numero 1 de la tipica BBDD de facturacion
        $pdf = new PDF_Mc_Table();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
      
        
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
     
        $pdf->SetXY(10, 5);
        $pdf->SetFillColor(255,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(0,8,"Factura Pagos ".$cfdi1." ".$cfdi2,1,1,"C",true);
      
        // Imprimimos el logo a 300 ppp
        $pdf->Image(public_path().'/img/'.$logo,15,15,-250);
        
        // Consulta a la base de datos para sacar cosas de la factura 1
       
       
        
        // 1º Datos del cliente
        $xml->registerXPathNamespace("tfd", "http://www.sat.gob.mx/TimbreFiscalDigital");
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital') as $tfd){
        $sello4 = $tfd['NoCertificadoSAT'];
        $sello5 = $tfd['UUID'];
       
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
        $emisor1 = $Emisor['Nombre'];
        $emisor2 = $Emisor['Rfc'];
        $emisor3 = $Emisor['RegimenFiscal'];
      
        $regi1 = $this->rgmen($emisor3);
        $texto1=" ".$Emisor['Nombre']." \n  RFC: ".$Emisor['Rfc']." \n No de serie del Certificado del CSD:".$cfdi11."  \n Folio Fiscal: ".$sello5." \n Regimen: ".$regi1." \n Exportacion: 01";
        $pdf->SetXY(70, 13);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont("Arial","",8);
        $pdf->MultiCell(130,6,$texto1,1,"L");
        
       
        $pdf->SetXY(150, 13);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont("Arial","",8);
        $pdf->MultiCell(50,6,$observaciones,1,"L");
        }
       
        $pdf->SetXY(10, 53);
        $pdf->SetFillColor(255,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(0,8," DATOS DEL CLIENTE                                                                              EXPEDIDO EN",1,1,"L",true);
    
        $Receptor1 = utf8_decode($Receptor['Nombre']);
        $Receptor2 = $Receptor['Rfc'];
        $Regimen2 =  $this->rgmen($Receptor['RegimenFiscalReceptor']);
        $Domicilio2 = $Receptor['DomicilioFiscalReceptor'];
        $Receptor2 = $Receptor['Rfc'];
        $Receptor3 = $this->uso($Receptor['UsoCFDI']);
         $sello1 = $tfd['SelloCFD'];
         $sello2 = $tfd['SelloSAT'];
    
        
        $rec = $this->generarPNG($nombrexml,"https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=".$sello5."&re=".$emisor2."&rr=".$Receptor2."&tt=".number_format(floatval($cfdi3),6)."&fe=".substr($sello1,-8));
       
        $cfdi99 = $tfd['FechaTimbrado'];
        $texto1=" ".$Receptor1." \n RFC:".$Receptor2." \n Domicilio Fiscal:".$Domicilio2.utf8_decode(" \n Régimen::").$Regimen2." \n Uso CFDI:".$Receptor3;
        $pdf->SetXY(10, 61);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont("Arial","",8);
        $pdf->MultiCell(90,4,$texto1,1,"L");
       
        $texto2=" C.P.".$cfdi." \n ".utf8_decode("Fecha y hora de emisión:").$cfdi99;
        $pdf->SetXY(100, 61);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont("Arial","",8);
        $pdf->MultiCell(0,6,$texto2,0,"L");
        }
        }
        $pdf->SetXY(10, 83);
        $pdf->SetFillColor(255,0,0);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont("Arial","B",5);
        $pdf->Cell(15,6,"CANTIDAD",1,0,"C",true);
        $pdf->Cell(25,6,"U. MEDIDA",1,0,"C",true);
        $pdf->Cell(70,6,"DESCRIPCION",1,0,"C",true);
        $pdf->Cell(20,6,"V. UNITARIO",1,0,"C",true);
        $pdf->Cell(20,6,"% DESCUENTO",1,0,"C",true);
        $pdf->Cell(20,6,"IMPORTE",1,0,"C",true);
        $pdf->Cell(20,6,"OBJ. DE IMPUESTO",1,1,"C",true);
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
            $obj = $Conceptos['ObjetoImp'];
         
        $pdf->SetX(10);
        $pdf->SetWidths(array(15,25,70,20,20,20,20));
        //un arreglo con alineacion de cada celda
        $pdf->SetAligns(array('C','C','L','C','C','C','C'));
        //OTro arreglo pero con el contenido
        //utf8_decode es para que escriba bien
        //los acentos. 
        $c1 = $this->amoneda($vunit,"pesos");
        $t1 = $this->amoneda($import,"pesos");
        $pdf->Row(array($cantidad,$claveunidad." - ".$unidad,utf8_decode($claveser." - ".$descripcion),$c1,0,$t1,$obj)); 
        
       
            }
          
        
            $pdf->SetX(10);
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('L'));
            $pdf->Row(array('CFDI RELACIONADOS')); 
            $pdf->SetX(10);
            $pdf->SetFillColor(96,133,195);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFont("Arial","",7); 
            $pdf->Cell(45,6,"UUID",1,0,"C",true);
            $pdf->Cell(20,6,"Folio",1,0,"C",true);
            $pdf->Cell(20,6,"Metodo",1,0,"C",true);
            $pdf->Cell(30,6,"Total",1,0,"C",true);
            $pdf->Cell(25,6,"Saldo Anterior",1,0,"C",true);
            $pdf->Cell(25,6,"Saldo Pendiente",1,0,"C",true);
            $pdf->Cell(25,6,"Monto Pagado",1,1,"C",true);
        
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont("Arial","",7);
        
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//pago20:Pagos//pago20:Pago//pago20:DoctoRelacionado') as $pagos){  // SECCION EMISOR
                  $uuidp           = $pagos['IdDocumento'];
                  $foliop           = $pagos['Serie'].$pagos['Folio'];
                  $mpagop           = $pagos['MetodoDePagoDR'];
                  $totalp           = $this->amoneda($pagos['ImpSaldoAnt'],"pesos")." ".$pagos['MonedaDR'];
                  $sant           = $this->amoneda($pagos['ImpSaldoAnt'],"pesos");
                  $sins           = $this->amoneda($pagos['ImpSaldoInsoluto'],"pesos");
                  $spago           = $this->amoneda($pagos['ImpPagado'],"pesos");
        
                 
               
              $pdf->SetX(10);
              $pdf->SetWidths(array(45,20,20,30,25,25,25));
              //un arreglo con alineacion de cada celda
              $pdf->SetAligns(array('C','C','C','C','C','C','C'));
              //OTro arreglo pero con el contenido
              //utf8_decode es para que escriba bien
              //los acentos. 
              $pdf->Row(array($uuidp,$foliop,$mpagop,$totalp,$sant,$sins,$spago)); 
              
                  
                  }
        
        
                  $pdf->SetX(10);
                  $pdf->SetWidths(array(190));
                  $pdf->SetAligns(array('L'));
                  $pdf->Row(array('')); 
                  $pdf->SetX(10);
                  $pdf->SetFillColor(96,133,195);
                  $pdf->SetTextColor(255,255,255);
                  $pdf->SetFont("Arial","",7); 
                  $pdf->Cell(30,6,"Fecha y hora de pago",1,0,"C",true);
                  $pdf->Cell(110,6,"Forma de pago",1,0,"C",true);
                  $pdf->Cell(50,6,"Total del pago",1,1,"C",true);
              
                  $pdf->SetTextColor(0,0,0);
                  $pdf->SetFont("Arial","",7);
              
                  foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//pago20:Pagos//pago20:Pago') as $pago){  // SECCION EMISOR
                        $fpago           = $pago['FechaPago'];
                        $fpagof           = $pago['FormaDePagoP'];
                        $mpago           = $this->amoneda($pago['Monto'],"pesos");
                        $mpagos           = $pago['Monto'];
        
                       
              
                       
                     
                    $pdf->SetX(10);
                    $pdf->SetWidths(array(30,110,50));
                    //un arreglo con alineacion de cada celda
                    $pdf->SetAligns(array('C','C','C'));
                    //OTro arreglo pero con el contenido
                    //utf8_decode es para que escriba bien
                    //los acentos. 
                    $pdf->Row(array($fpago,$fpagof,$mpago)); 
                    
                        
                        }      
                        $numl = new NumLetras();   
    
                        $montocl=$numl->numletras($mpagos,1);
                    
                    
                        $pdf->SetX(10);
                        $pdf->SetFillColor(96,133,195);
                        $pdf->SetTextColor(255,255,255);
                        $pdf->SetFont("Arial","",7); 
                        $pdf->Cell(30,6,"Cantidad con letra:",1,0,"C",true);
                        
                        $pdf->SetFillColor(255,255,255);
                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetFont("Arial","B",5);
                        $pdf->Cell(110,6,$montocl,1,0,"C",true);
                        $pdf->Cell(50,6," ",1,1,"C",true);        
        
        
            
                        $pdf->SetFont("Arial","",7); 
                        $pdf->ln(3);
        
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
$pdf->MultiCell(190,4,utf8_decode($this->satxmlsv40_genera_cadena_original($xml)),0,"L");
				
$pdf->Image($nombrexml.'.png',10,220,-85);

 }



$pdf->Line(10,275,200,275);

$pdf->Text(10,280,utf8_decode("Este documento es una representación impresa de un CFDI"));


        
        // El documento enviado al navegador
        $pdf->Output(public_path().'/facturas/'.$cfdi1.''.$cfdi2.'-'.$emisor2.'-'.$sello5.'.pdf',"F");	
        
        return public_path().'/facturas/'.$cfdi1.''.$cfdi2.'-'.$emisor2.'-'.$sello5.'.pdf';
            
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

    function generarPNG($nombre,$requiere){

     
        QrCode::format('png')->size(180)->generate($requiere,$nombre.'.png');
            
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

     if($identificador == "CP01"){
        $result = "CP01 - Pago";
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



function amoneda($numero)
{
    $number = $numero;
    setlocale(LC_MONETARY, 'en_US.UTF-8');
    
    $m = $this->money_formato('%.2n', $number);
    return $m;
}

function satxmlsv40_genera_cadena_original($xml) {
    $paso = new \DOMDocument("1.0","UTF-8");
    $paso->loadXML($xml->saveXML());
    $xsl = new \DOMDocument("1.0","UTF-8");
    $file=public_path().'/utilerias/xslt33/cadenaoriginal4.xslt';      // Ruta al archivo
    $xsl->load($file);
    $proc = new \XSLTProcessor;
    libxml_use_internal_errors(true);
    $result = $proc->importStyleSheet($xsl);
    if (!$result) {
        foreach (libxml_get_errors() as $error) {
            return "Libxml error: {$error->message}\n";
        }
    }
    libxml_use_internal_errors(false);

    if ($result) {
        return $proc->transformToXML($paso);
    }
    
    }
    


}



?>