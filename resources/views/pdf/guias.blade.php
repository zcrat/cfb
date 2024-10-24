<?php

include("mc_table.php");
define('FPDF_FONTPATH', 'font/');
$pdf = new PDF_Mc_Table();
$pdf->AddPage();

foreach ($sucursal as $s){

$pdf->SetFont('Arial','',9);
$pdf->SetXY(40, 51);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,4,utf8_decode($s->calle." ".$s->numero_ext." ".$s->numero_int."
COL. "." ".$s->colonia."
".$s->ciudad.",".$s->estado." C.P. ".$s->cp."
TEL. ".$s->telefono),0,"L",false);
}

$pdf->SetFont('Arial','',6);


foreach ($venta as $c){

$pdf->Image('img/logo.png',25,20,-400);
$pdf->SetXY(100,14);
$pdf->SetTextColor(0,0,0);
date_default_timezone_set('America/Mexico_City');
$pdf->Cell(20,6,"No. GUIA:".$c->fecha,0,1,"R",false);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(120,14);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(30,6,$c->num_guia,0,1,"C",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(150,14);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(15,5,"FECHA:",0,"R",false);
$pdf->SetXY(165,14);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(25,5,fechaCastellano($c->created_at),0,"C",false);

$pdf->SetXY(100, 20);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,6,"Track:",0,"R",false);
$pdf->SetXY(120, 20);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,6,"",1,"R",false);

$pdf->SetXY(100,26);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"PIEZAS",1,"R",false);
$pdf->SetXY(120,26);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(30,5,$c->piezas,1,"C",false);
$pdf->SetXY(150,26);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(15,5,"TIPO:",1,"R",false);
$pdf->SetXY(165,26);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(25,5,$c->tipo,1,"C",false);

$pdf->SetXY(100,31);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"VALOR",1,"R",false);
$pdf->SetXY(120,31);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(30,5,"",1,"C",false);
$pdf->SetXY(150,31);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(15,5,"SERVICIO:",1,"R",false);
$pdf->SetXY(165,31);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(25,5,$c->servicio,1,"C",false);

$pdf->SetXY(100,36);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"PESO (Kg):",1,"R",false);
$pdf->SetXY(120,36);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(30,5,$c->pesokg,1,"C",false);

$pdf->SetXY(100,41);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"MEDIDAS (cm):",1,"R",false);
$pdf->SetXY(120,41);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(10,5,$c->largo,1,"C",false);
$pdf->SetXY(130,41);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(10,5,$c->ancho,1,"C",false);
$pdf->SetXY(140,41);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(10,5,$c->alto,1,"C",false);
$pdf->SetXY(150,41);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(15,5,"PESO VOL:",1,"R",false);
$pdf->SetXY(165,41);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(25,5,$c->pesovol,1,"C",false);


if ($c->tarifaseguro == '0'){
    $seguro_text = 'No';
} else {
    $seguro_text = 'Si';
}

$pdf->SetXY(130,46);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(35,5,"SEGURO CONTRATADO:",0,"R",false);
$pdf->SetXY(165,46);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(25,5,$seguro_text,1,"C",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(100, 51);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,12,"CONTENIDO:",1,"R",false);
$pdf->SetXY(120, 51);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,12,"",1,"L",false);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(120, 51);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,6,$c->descripcion,0,"L",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,63);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"SERVICIO:",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,63);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(30,5,amoneda($c->tarifadeservicio),1,"C",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,68);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"SEGURO:",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,68);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(30,5,amoneda($c->tarifaseguro),1,"C",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,73);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"EMBALAJE:",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,73);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(30,5,amoneda($c->embalaje),1,"C",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,78);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"OTRO:",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,78);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(30,5,amoneda($c->otrocobro),1,"C",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,83);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"TOTAL:",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,83);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(30,5,amoneda($c->total),1,"C",false);


$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,90);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"ORIGEN:",0,"L",false);
$pdf->SetXY(100,90);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"DESTINO:",0,"L",false);


$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,95);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,8,"EMPRESA:",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,95);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,8,$c->empresa,1,"L",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,95);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,8,"EMPRESA:",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,95);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,8,$c->dest_empresa,1,"L",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,103);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,8,"REMITENTE",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,103);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,8,$c->nombre,1,"L",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,103);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,8,"DESTINATARIO:",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,103);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,8,$c->destinatario,1,"L",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,111);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,8,"CALLE No.",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,111);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,8,$c->calle." ".$c->numero_ext." ".$c->numero_int,1,"L",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,111);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,8,"CALLE No.:",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,111);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,8,$c->dest_calle." ".$c->dest_numero_ext." ".$c->dest_numero_int,1,"L",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,119);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"COL.",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,119);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,5,$c->colonia,1,"L",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,119);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"COL.",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,119);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,5,$c->dest_colonia,1,"L",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,124);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"POBLACION.",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,124);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,5,$c->ciudad.",".$c->estado,1,"L",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,124);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"POBLACION.",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,124);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,5,$c->dest_ciudad.",".$c->dest_estado,1,"L",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,129);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"C.P.",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,129);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,5,$c->cp,1,"L",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,129);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"C.P.",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,129);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,5,$c->dest_cp,1,"L",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,134);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"TEL.",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,134);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,5,$c->telefono,1,"L",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,134);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,5,"TEL.",1,"R",false);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,134);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,5,$c->dest_telefono,1,"L",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,139);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(80,36,"",1,"R",false);
$pdf->SetXY(100,139);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,8,"REFERENCIAS:",1,"R",false);
$pdf->SetFont('Arial','',6);
$pdf->SetXY(120,139);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(70,8,$c->dest_referencia,1,"L",false);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(100,147);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(90,7,"CONFIRMACION DE ENTREGA:",1,"C",false);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(100,154);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(90,7,"RECIBIO:",1,"L",false);


$pdf->SetXY(100,161);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(90,7,"FECHA:",1,"L",false);

$pdf->SetXY(40,168);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(50,7,"FIRMA DEL REMITENTE:","T","C",false);
$pdf->SetXY(100,168);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(90,7,"HORA:",1,"L",false);


$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,176);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(170,10,"HE LEIDO Y ESTOY CONFORME CON LAS CLAUSULAS DEL CONTRATO INSERTADO EN LA MISMA PAGINA.",0,"L",false);


$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,186);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(170,4,"CONTRATO DE SERVICIO DE MENSAJERIA Y PAQUETERIA QUE CELEBRAN ALIANZA PACK CUYOS DATOS APARECEN EN EL ENCABEZADO DE LA PAGINA Y POR OTRA EL CLIENE CUYOS DATOS APARECEN EN LA PARTE DEL REMITENTE.",0,"L",false);

$pdf->SetFont('Arial','B',6);
$pdf->SetXY(20,196);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(170,4,"CLAUSULAS",0,"C",false);

$pdf->SetFont('Arial','',5);
$pdf->SetXY(20,200);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(170,4,"1a. ALIANZA PACK PRESTA EL SRVICIO AL CLINE NO SIN ANTES EXPLICAR TIEMPOS DE ENTREGA, COSTOS Y SERVICIOS COMPLEMENTARIOS.
2a. PARA EL MEJOR SERVICO O PREVIA CONVENIENCIA ALIANZA PACK PUEDE SUBCONTRATAR A UN TRCERO PARA EL TRANSPORTE DEL ENVIO.
3a. EN CASO DE PERDIDA O MENOSCAVO DEL ENVIO ALIANZA PACK SE RESPONSABILIZA HASTA POR $1,000.00 (MIL PESOS M.N.) POR ENVIO. EN SU CASO, EL CLIENTE TENDRA QUE HACER SU RECLAMACION POR ESCRITO DENTRO DE LOS PRIMEROS 15 DIAS DESPUES DE FECHA ENVIO.
4a.  LAS PARTES CONVIENEN QUE EN CASO DE PERDIDA O DEMORA IMPUTABLE A ALIANZA PACK E STA (ALIANZA PACK) NO SERA RESPONSABLE DE LOS PERJUICIOS DIRECTOS O INDIRECTOS CAUSADOS AL REMITNTE (EL CLIENTE), AL DSTINATARIO O A CUALQUIER TERCERO QUEDANDO AMBAS PARTES DE ACUERDO EN LO PREVISTO EN LA CLAUSULA 3a.
5a. ES DE CONOCIMIENTO DEL CLIENTE QUE ALIANZA PACK OFRECE UN SEGURO PARA ENVIO QUE ES DEL 8% POR CADA $,1000.00 (MIL PESOS M.N.) DECLARADOS DEL VALOR DE ENVIO, SIENDO EL MONTO MAXIMO ASEGURADO POR ENVIO DE $4,000.00 (CUATRO MIL PESOS M.N.)
6a. EL CLIENTE BAJO PROTESTA DE DECIR LA VERDAD DEBE DECLARAR EL CONTENIDO DEL ENVIO Y QUE LA FALSEDAD EN LA DECLARACION DE CONTENIDO DE ENVIO ES RESPONSABILIDAD DEL CLIENTE.
7a. EL CLIENTE CONVIENE CON ALIANZA PACK A NO REALIZAR ENVIOS QUE CONTENGAN SUSTANCIAS DE LAS SEÑALADAS COMO PELIGROSAS POR LA LEY GENERAL DE VIAS DE COMUNICACIÓN O DISPOSICIONES DE AUTORIDAD, LA IATA Y/O REGLAMENTO DE OPERACIÓN DE AEREONAVES, ASI COMO NINGUNA CLASE DE DROGAS O ESTUPEFACIENTES DE LOS CONSIDERADOS POR LA LEY GENERAL DE SALUD EN SU ARTICULO No.234.QUE PUEDAN POR SU NATURALEZA PONER EN PELIGRO LA SEGURIDAD Y LEGALIDAD DE LA AEREONAVE Y SERVICIO QUE BRINDE ALIANZA PACK, POR LO QUE ALIANZA PACK  NO SERA RESPONSABLE EN CASO DE QUE EL CLIENTE VIOLE LAS DISPOSICIONES LEGALES ANTES MENCIONADAS.
8a. EN CASO DE NO ASEGURAR QUEDA SUJETO A LA CLAUSULA 3a.
9a. PARA LA INTERPRETACION Y CUMPLIMIENTO DEL PRESENTE CONTRATO, ESTARAN SUJETAS LAS PARTES A LA COMPTENCIA Y JURISDICCION DE LOS ORGANOS JUDICIALES DE ESTA CIUDAD DE MORELIA, MICHOACAN, MEXICO.ESTANDO SUJETOS A LA COMPETENCIA DE LAS NORMAS JURIDICAS REGULADORAS DEL PRESENTE CONTRATO, RENUNCIANDO EL CLIENTE A CUALQUIER FUERO EN LO FUTURO LLE GUE A TENER POR RAZON DE DOMICILIO O DENOMINACION SOCIAL.
",0,"j",false);

$pdf->AddFont('code128','','code128.php');
$pdf->SetFont('code128','',40);
$pdf->SetXY(40,75);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(60,8,$c->num_guia,0,"C",false);

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(40,85);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(60,6,$c->num_guia,0,1,"C",false);



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

function fechaCastellano ($fecha) {
    $fecha = substr($fecha, 0, 20);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $hora = date('H', strtotime($fecha));
    $min = date('i', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
  $meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sept", "Oct", "Nov", "Dic");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $numeroDia."/".$nombreMes."/".$anio.". ".$hora.":".$min;
  }

?>


 ?>