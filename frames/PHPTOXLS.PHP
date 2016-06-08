<?php

/* http://ProgramarEnPHP.wordpress.com */

/** En caso de errores… */

error_reporting(E_ALL);

 

/** PHPExcel */

require_once 'Classes/PHPExcel.php';

 

// Creamos nueva instancia de PHPExcel

$objPHPExcel = new PHPExcel();

 

// Seleccionando la fuente a utilizar

$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');

$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

 

// Escribiendo los datos

$objPHPExcel->getActiveSheet()->setCellValue('A1','Este es un Ejemplo Sencillo de como crear un documento en Excel');

 

// Ahora texto con propiedades

$objRichText = new PHPExcel_RichText();

$objRichText->createText('Y como puedes ver puedes poner texto en celdas combinadas y con texto ajustado');

$objPHPExcel->getActiveSheet()->getCell('A5')->setValue($objRichText);

 

//combinando celdas

$objPHPExcel->getActiveSheet()->mergeCells('A5:E10');

$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

 

//Y tambien podemos utilizar formulas

$objPHPExcel->getActiveSheet()->setCellValue('B12', 'Datos a sumar');

$objPHPExcel->getActiveSheet()->setCellValue('B13', 2);

$objPHPExcel->getActiveSheet()->setCellValue('B14', 8);

$objPHPExcel->getActiveSheet()->setCellValue('B15', 10);

$objPHPExcel->getActiveSheet()->setCellValue('B16', '=SUM(B13:B15)');

// Nombramos la hoja

$objPHPExcel->getActiveSheet()->setTitle('ProgramarEnPHP');

// Activamos para que al abrir el excel nos muestre la primer hoja

$objPHPExcel->setActiveSheetIndex(0);

 

// Guardamos el archivo, en este caso lo guarda con el mismo nombre del php

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

?>