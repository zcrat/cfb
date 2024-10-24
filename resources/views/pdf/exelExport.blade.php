<?php
ini_set('error_reporting', E_ALL);

include("PHPExcel/Classes/PHPExcel.php");

$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->getActiveSheet();
$sheet->setCellValueByColumnAndRow(0, 1, "REPORTE PRESUPUESTOS");
$sheet->setCellValueByColumnAndRow(0, 2, "");
$sheet->mergeCells('A1:J1');
$sheet->mergeCells('A2:J2');

$sheet->getStyle('A1:G1000')->getAlignment()->applyFromArray(
  array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
);


$sheet->getStyle('A1:D2')->applyFromArray(array(
  'font' => array(
    'bold' => true,
    'color' => array('rgb' => '000000'),
    'size' => 18,
    'name' => 'Arial'
  )
)
);





$objPHPExcel->
 getProperties()
     ->setCreator("viverosmihogar.com")
     ->setLastModifiedBy("viverosmihogar.com")
     ->setTitle("Reporte estadistico")
     ->setSubject("Reporte estadistico")
     ->setDescription("Reportes estadistico de la calidad en el servicio")
     ->setKeywords("Reporte estadistico en calidad de servicio")
     ->setCategory("Estadistica de calidad");


     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A3', 'Economico');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('B3', 'Placas');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('C3', 'No. Sol.');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('D3', 'Km');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('E3', 'Servicio');    
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('F3', 'Costo ');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('G3', 'IVA');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('H3', 'Total');     


//Getting data from $database


$cel = 4;
foreach ($detalles as $s){
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A' . $cel, $s->identificador);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('B' . $cel, $s->placas);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('C' . $cel, $s->NSolicitud);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('D' . $cel, $s->kilometraje);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('E' . $cel, $s->descripcionMO);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('F' . $cel, $s->importe);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('G' . $cel, $s->importe*0.16);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('H' . $cel, $s->importe*1.16);

$cel++;
}

     header('Content-Type: application/vnd.ms-excel');
     header('Content-Disposition: attachment;filename="reporte.xlsx"');
     header('Cache-Control: max-age=0');

     $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
     $objWriter->save('php://output');

 ?>
