<?php

include("mc_table.php");
define('FPDF_FONTPATH', 'font/');


class PDFP extends PDF_MC_Table
{
//Constructor (mandatory with PHP3)

//Page header
function Header()
{



}

//Page footer
function Footer()
{
$this->SetY(-15);


//Arial italic 8
$this->SetFont('Arial','I',8);
        
//Page number
$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}

$pdf = new PDFP();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 10); 
$pdf->SetAutoPageBreak(true, 10);

$pdf->SetFont('Arial','B',12);

foreach ($cotizacion as $c){

/* $pdf->Image('img/logo_akumas_fct.png',10,-10,-200);
$pdf->Image('img/logos-empresas/logo_cfe.png',140,2,-150); */
//$pdf->Image('img/logos-empresas/'.$c->logo,140,10,-200);

$pdf->SetLineWidth(0.7);

$pdf->SetXY(10, 10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(63,40,"",1,1,"LTRB",false);
$pdf->Image('img/LogoAkumas.png',16,26,-1100);

$pdf->SetXY(10, 50);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(63,8,'Folio: '.$c->folioNum,1,"C",false);


$pdf->SetXY(73, 10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(64,40,"RECEPCION ACUSE",1,1,"C",false);

$pdf->SetXY(137, 10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(63,40,"",1,1,"LTRB",false);
$pdf->Image('img/logo_cfb_fact.png',142,12,-250);

$pdf->SetXY(137, 50);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(63,8,'Fecha: '.$c->fecha,1,"C",false);


$pdf->SetXY(10, 50);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190,40,"DATOS DE LA UNIDAD",0,1,"C",false);




}

foreach ($cotizacion as $co){


$pdf->SetFont("Arial","",8);
$pdf->SetXY(10,77);
$pdf->Cell(95,12,utf8_decode(" Empresa: "),0,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(10,80);
$pdf->Cell(95,12,utf8_decode(" ".$co->nombre),1,1,"L");

$pdf->SetFont("Arial","",8);
$pdf->SetXY(105,77);
$pdf->Cell(95,12,utf8_decode(" No. economico: "),0,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(105,80);
$pdf->Cell(95,12,utf8_decode(" ".$co->no_economico),1,1,"L");


$pdf->SetFont("Arial","B",8);
$pdf->SetXY(10,92);
$pdf->Cell(95,8,utf8_decode(" Placas: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(30,92);
$pdf->Cell(75,8,utf8_decode($co->placas),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(105,92);
$pdf->Cell(95,8,utf8_decode(" Km: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(125,92);
$pdf->Cell(75,8,utf8_decode($co->km_entrada),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(10,100);
$pdf->Cell(63,8,utf8_decode(" Marca: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(30,100);
$pdf->Cell(43,8,utf8_decode($co->marca),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(73,100);
$pdf->Cell(64,8,utf8_decode(" Sub marca: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(93,100);
$pdf->Cell(44,8,utf8_decode($co->submarca),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(137,100);
$pdf->Cell(63,8,utf8_decode(" Modelo: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(157,100);
$pdf->Cell(43,8,utf8_decode($co->modelo),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(10,108);
$pdf->Cell(95,8,utf8_decode(" No. serie: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(30,108);
$pdf->Cell(75,8,utf8_decode($co->no_serie),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(105,108);
$pdf->Cell(95,8,utf8_decode(" Tipo de vehiculo: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(135,108);
$pdf->Cell(65,8,utf8_decode($co->tipo_de_vehiculo),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(10,116);
$pdf->Cell(95,8,utf8_decode(" ID: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(30,116);
$pdf->Cell(75,8,utf8_decode($co->orden_id),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(105,116);
$pdf->Cell(95,8,utf8_decode(" Orden de servicio: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(135,116);
$pdf->Cell(65,8,utf8_decode($co->orden_servicio),1,1,"C");



$pdf->SetXY(10, 134);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(57,10," TIPO DE SERVICIO: ",0,1,"L",false);


$pdf->SetFont("Arial","B",8);
$pdf->SetXY(21,144);
$pdf->Cell(21,7,utf8_decode(" PREVENTIVO"),0,1,"L");


$pdf->SetFont("Arial","B",8);
$pdf->SetXY(21,154);
$pdf->Cell(21,7,utf8_decode(" CORRECTIVO"),0,1,"L");


$pdf->SetFont("Arial","B",8);
$pdf->SetXY(21,164);
$pdf->Cell(21,7,utf8_decode(" NEUMATICOS"),0,1,"L");


$pdf->SetFont("Arial","B",8);
$pdf->SetXY(21,174);
$pdf->Cell(21,7,utf8_decode(" OTROS"),0,1,"L");



$pdf->SetXY(67, 134);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(133,10,"DETALLES DEL SERVICIO",0,1,"C",false);


$pdf->SetFont("Arial","B",8);
$pdf->SetXY(10,134);
$pdf->Cell(57,80,utf8_decode(""),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(67,134);
$pdf->Cell(133,80,utf8_decode(""),1,1,"L");


$pdf->SetFont("Arial","B",8);
$pdf->SetXY(70,150);
$pdf->MultiCell(125,6,utf8_decode($co->observaciones),0,"J",false);







$pdf->SetFont("Arial","B",8);
$pdf->SetXY(10,232);
$pdf->Cell(95,8,utf8_decode(" Nombre taller: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(40,232);
$pdf->Cell(65,8,utf8_decode($co->nombre_taller),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(105,232);
$pdf->Cell(95,8,utf8_decode(" Plaza: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(135,232);
$pdf->Cell(65,8,utf8_decode($co->usuario),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(10,240);
$pdf->Cell(95,8,utf8_decode(" Razón social: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(40,240);
$pdf->Cell(65,8,utf8_decode($co->razon_social),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(105,240);
$pdf->Cell(95,8,utf8_decode(" R.P.E: "),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(135,240);
$pdf->Cell(65,8,utf8_decode($co->rpe),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(10,248);
$pdf->Cell(95,24,utf8_decode(""),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(105,248);
$pdf->Cell(95,24,utf8_decode(""),1,1,"L");


$pdf->SetXY(25,260);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,8,"FIRMA ENTREGADO","T","C",false);

$pdf->SetXY(120,260);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,8,"FIRMA RECIBIDO","T","C",false); 


$pdf->SetLineWidth(0.3);
$pdf->SetDrawColor(0, 0, 128);

if($co->tipo_de_servicio == 'Correctivo'){

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(14,144);
$pdf->Cell(7,7,utf8_decode(""),1,1,"L");

$pdf->SetFont("Arial","B",14);
$pdf->SetXY(14,154);
$pdf->Cell(7,7,utf8_decode("X"),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(14,164);
$pdf->Cell(7,7,utf8_decode(""),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(14,174);
$pdf->Cell(7,7,utf8_decode(""),1,1,"L");
}

if($co->tipo_de_servicio == 'Preventivo'){

$pdf->SetFont("Arial","B",14);
$pdf->SetXY(14,144);
$pdf->Cell(7,7,utf8_decode("X"),1,1,"C");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(14,154);
$pdf->Cell(7,7,utf8_decode(""),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(14,164);
$pdf->Cell(7,7,utf8_decode(""),1,1,"L");

$pdf->SetFont("Arial","B",8);
$pdf->SetXY(14,174);
$pdf->Cell(7,7,utf8_decode(""),1,1,"L");
}

if($co->tipo_de_servicio == 'Neumaticos'){

    $pdf->SetFont("Arial","B",8);
    $pdf->SetXY(14,144);
    $pdf->Cell(7,7,utf8_decode(""),1,1,"L");
    
    $pdf->SetFont("Arial","B",8);
    $pdf->SetXY(14,154);
    $pdf->Cell(7,7,utf8_decode(""),1,1,"L");
    
    $pdf->SetFont("Arial","B",14);
    $pdf->SetXY(14,164);
    $pdf->Cell(7,7,utf8_decode("X"),1,1,"C");
    
    $pdf->SetFont("Arial","B",8);
    $pdf->SetXY(14,174);
    $pdf->Cell(7,7,utf8_decode(""),1,1,"L");
    }

    if($co->tipo_de_servicio == 'Otros'){

        $pdf->SetFont("Arial","B",8);
        $pdf->SetXY(14,144);
        $pdf->Cell(7,7,utf8_decode(""),1,1,"L");
        
        $pdf->SetFont("Arial","B",8);
        $pdf->SetXY(14,154);
        $pdf->Cell(7,7,utf8_decode(""),1,1,"L");
        
        $pdf->SetFont("Arial","B",8);
        $pdf->SetXY(14,164);
        $pdf->Cell(7,7,utf8_decode(""),1,1,"L");
        
        $pdf->SetFont("Arial","B",14);
        $pdf->SetXY(14,174);
        $pdf->Cell(7,7,utf8_decode("X"),1,1,"C");
        }




} 
  
// fin y entrega del pdf 
$pdf->Output();
exit;

function amoneda($numero)
{
    $number = $numero;
    setlocale(LC_MONETARY, 'en_US.UTF-8');
    return money_formato('%.2n', $number);
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

?>


 ?>