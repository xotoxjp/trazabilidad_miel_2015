<?session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=4 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1)  {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }

/*****************************************************************************************************************************************/

$last_ing = date("Y-m-d H:i:s"); ;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="UPDATE ".$_SESSION["tabla_acc"]." SET fec_ult_ut='$last_ing' ,prog_utl='labaxls.php'  WHERE id_usuario=".$_SESSION["id_usuario"];
mysql_query($actualizar,$cx_validar);

error_reporting(E_ALL);
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);


// Escribiendo los datos
$a='LABORATORIO DE CONTROL DE CALIDAD';
$objPHPExcel->getActiveSheet()->setCellValue('B2',$a);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(75);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
$objPHPExcel->getActiveSheet()->getStyle('B2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);



$fecha='Fecha de Ingreso: '.date("d/m/Y");
$objPHPExcel->getActiveSheet()->setCellValue('F1',$fecha);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
$objPHPExcel->getActiveSheet()->mergeCells('F1:G2');
$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('F1:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F1:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('fotos/laborat.png');
$objDrawing->setWidth(150);

//To add the above drawing to the worksheet, use the following snippet of code. PHPExcel creates the link between the drawing and the worksheet:
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);


$text='Informe de Resultados';
$objPHPExcel->getActiveSheet()->setCellValue('A4',$text);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->mergeCells('A4:G5');
$objPHPExcel->getActiveSheet()->getStyle('A4:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:G5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$text1='Productores:';
$objPHPExcel->getActiveSheet()->setCellValue('A6',$text1);
$objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);

$text2='Zona:';
$objPHPExcel->getActiveSheet()->setCellValue('A8',$text2);
$objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);

$text3='Toma de muestra en campo:';
$objPHPExcel->getActiveSheet()->setCellValue('A10',$text3);
$objPHPExcel->getActiveSheet()->getStyle('A10')->getFont()->setBold(true);


// Ahora texto con propiedades
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$theaderA0='ANÁLISIS';
$objPHPExcel->getActiveSheet()->setCellValue('C12',$theaderA0);
$objPHPExcel->getActiveSheet()->mergeCells('C12:F12');
$theaderA1='IDENTIFICACIÓN';
$objPHPExcel->getActiveSheet()->setCellValue('A13',$theaderA1);
$objPHPExcel->getActiveSheet()->mergeCells('A13:A14');
$theaderA2='PRODUCTOR';
$objPHPExcel->getActiveSheet()->setCellValue('B13',$theaderA2);
$objPHPExcel->getActiveSheet()->mergeCells('B13:B14');
$theaderA31='HMF';
$objPHPExcel->getActiveSheet()->setCellValue('C13',$theaderA31);
$theaderA32='mm/Kg';
$objPHPExcel->getActiveSheet()->setCellValue('C14',$theaderA32);
$theaderA41='COLOR';
$objPHPExcel->getActiveSheet()->setCellValue('D13',$theaderA41);
$theaderA42='mm/Pfund';
$objPHPExcel->getActiveSheet()->setCellValue('D14',$theaderA42);
$theaderA51='HUMEDAD';
$objPHPExcel->getActiveSheet()->setCellValue('E13',$theaderA51);
$theaderA52='%';
$objPHPExcel->getActiveSheet()->setCellValue('E14',$theaderA52);
$theaderA61='ACIDEZ';
$objPHPExcel->getActiveSheet()->setCellValue('F13',$theaderA61);
$theaderA62='meq/Kg';
$objPHPExcel->getActiveSheet()->setCellValue('F14',$theaderA62);
$theaderA7='RESULTADO';
$objPHPExcel->getActiveSheet()->setCellValue('G13',$theaderA7);
$objPHPExcel->getActiveSheet()->mergeCells('G13:G14');

$objPHPExcel->getActiveSheet()->getStyle('A13:A14')->getFont()->setBold(true);

$sharedStyleTitles = new PHPExcel_Style();
$sharedStyleTitles->applyFromArray(
  array('borders' => array(
    'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    )
 ));
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyleTitles, 'A13:G14');
$objPHPExcel->getActiveSheet()->getStyle('A13:G14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A13:G14')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A13:G14')->getFill()->applyFromArray(
  array(
    'type'       => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => array('rgb' => 'D2D5D6'),
    'endcolor'   => array('rgb' => 'D2D5D6')
  )
);

/*****************************  agregado por nosotros ********************************************************/

$otra = $_GET['muestras'];
$otra2 = explode(",", $otra);
$largo = count($otra2);
$vueltas = 0;
$i=0; 
$fila = 15;
  
while($vueltas < $largo) {
    $col = 0;
    
    $SQL="SELECT laboratorio.num_presupuesto, provedores.razon_social, laboratorio.hmf, laboratorio.color, laboratorio.humedad,laboratorio.acidez, laboratorio.resultado, laboratorio.fecha_analisis
            FROM laboratorio
            INNER JOIN provedores ON laboratorio.id_productor = provedores.prov_id
            WHERE laboratorio.id_tambor =".$otra2[$i]."
            GROUP BY laboratorio.id_tambor
            ORDER BY laboratorio.id_tambor ";
    $respu = mysql_query($SQL,$cx_validar);

    while($datosTabla = mysql_fetch_array($respu)){
      $numpres = $datosTabla[0];
      $razon = $datosTabla[1];
      $hmf = $datosTabla[2];
      $color = $datosTabla[3];
      $humedad = $datosTabla[4];
      $acidez = $datosTabla[5];
      $cumple = $datosTabla[6];
      $fecha = $datosTabla[7];
    }
    
    $fecha = new DateTime($fecha);
    $formattedfecha = date_format($fecha, 'd/m/Y');
    $fechaTit="Fecha de Ingreso: $formattedfecha";
    $objPHPExcel->getActiveSheet()->setCellValue('F1',$fechaTit);
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $otra2[$i]);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $razon);
    $col++;

    //ver decimales de 3 digitos
    $objPHPExcel->getActiveSheet()->getStyle($col, $fila)->getNumberFormat()->setFormatCode('#,##0.000');
    //ver decimales de 3 digitos   

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $hmf);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $color);
    $col++;

    //ver decimales de 3 digitos
    $objPHPExcel->getActiveSheet()->getStyle($col, $fila)->getNumberFormat()->setFormatCode('#,##0.000');
    //ver decimales de 3 digitos   

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $humedad);
    $col++;

    //ver decimales de 3 digitos
    $objPHPExcel->getActiveSheet()->getStyle($col, $fila)->getNumberFormat()->setFormatCode('#,##0.000');
    //ver decimales de 3 digitos   

    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $acidez);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $cumple);
    $col++;
    $fila++;
    
  $vueltas++;
  $i++; 
} 
/***************************************** fin del while *****************************************/
$objPHPExcel->getActiveSheet()->getStyle('A15:G44')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



$numeroPresupuest='P.M.:'.$numpres;//variable de numero de presuuesto
$objPHPExcel->getActiveSheet()->setCellValue('B3',$numeroPresupuest);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
$objPHPExcel->getActiveSheet()->getStyle('B3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$hora='Hora:';//.$numpres;//variable de hora
$objPHPExcel->getActiveSheet()->setCellValue('F3',$hora);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
$objPHPExcel->getActiveSheet()->getStyle('F3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setTitle('ANALISIS');
// Activamos para que al abrir el excel nos muestre la primer hoja
$objPHPExcel->setActiveSheetIndex(0);


// Guardamos el archivo, en este caso lo guarda con el mismo nombre del php
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$a=__FILE__ ;
$l=strlen($a) - 11; 
$a=substr($a,0,$l).'docs/lab.xls';
$objWriter->save(str_replace('.php', '.xls', $a));
header("Location: docs/lab.xls");
?>