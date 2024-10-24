<?php
ini_set('error_reporting', E_ALL);

include("PHPExcel/Classes/PHPExcel.php");

$objPHPExcel = new PHPExcel();
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
         ->setCellValue('A1', 'ID');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('B1', 'IDCATEGORIA');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('C1', 'IDTIPOS');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('D1', 'NUM');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('E1', 'DESCRIPCION');    
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('F1', 'PRECIOREFACCION');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('G1', 'TIEMPO');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('H1', 'PRECIOMANODEOBRA');  
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('I1', 'PRECIONUEVO');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('J1', 'PRECIOTOTAL');  
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('K1', 'CODIGOSAT');
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('L1', 'CODIGOUNIDAD');   
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('M1', 'UNIDADTEXTO');            


//Getting data from $database


$cel = 2;
foreach ($conceptos as $c){
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A' . $cel, $c->id);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('B' . $cel, $c->pCategorias_id);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('C' . $cel, $c->pTipos_id);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('D' . $cel, $c->num);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('E' . $cel, $c->descripcion);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('F' . $cel, $c->p_refaccion);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('G' . $cel, $c->tiempo);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('H' . $cel, $c->p_mo);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('I' . $cel, $c->pnuevo);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('J' . $cel, $c->p_total);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('K' . $cel, $c->codigo_sat);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('L' . $cel, $c->codigo_unidad);
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('M' . $cel, $c->unidad_text);


$cel++;
}

     header('Content-Type: application/vnd.ms-excel');
     header('Content-Disposition: attachment;filename="reporte.xlsx"');
     header('Cache-Control: max-age=0');

     $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
     $objWriter->save('php://output');

 ?>
