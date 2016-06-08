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
//if ($i<1)  {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }

/*****************************************************************************************************************************************/


$last_ing = date("Y-m-d H:i:s"); ;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="UPDATE ".$_SESSION["tabla_acc"]." SET fec_ult_ut='$last_ing' ,prog_utl='pendaxls.php'  WHERE id_usuario=".$_SESSION["id_usuario"];
mysql_query($actualizar,$cx_validar);

// Camino a los include

// PHPExcel
require_once 'Classes/PHPExcel.php';
// PHPExcel_IOFactory
include 'Classes/PHPExcel/IOFactory.php';
// Creamos un objeto PHPExcel
$objPHPExcel = new PHPExcel();
// Leemos un archivo Excel 2003 -- 'Excel2007' para xlsx
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("docs/pendientesing.xls");
// Indicamos que se pare en la hoja uno del libro
$objPHPExcel->setActiveSheetIndex(0);

/**********************************************  agregado por nosotros ********************************************************/
$fecha='Fecha: '.date("d/m/Y");
$objPHPExcel->getActiveSheet()->setCellValue('F1',$fecha);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
$objPHPExcel->getActiveSheet()->mergeCells('F1:G2');
$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('F1:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F1:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

/**********************************************  agregado por nosotros ********************************************************/
$vuelta = 1;
$fila = 10;
$col = 0;

$SQL="SELECT deposito.id_tambor,presupuestos.num_presupuesto,laboratorio.color,provedores.razon_social as productor, provedores.Localidad,provedores.c1, almacenes.razon_social as sala_ext  
       FROM deposito 
       INNER JOIN provedores ON deposito.id_productor = provedores.prov_id 
       INNER JOIN presupuestos ON deposito.id_presupuesto = presupuestos.id_presupuesto
       INNER JOIN almacenes ON presupuestos.id_sala_ext = almacenes.almacen_id
       INNER JOIN laboratorio ON presupuestos.id_tambor = laboratorio.id_tambor
       WHERE deposito.estado='COMPRADO'";

//echo "$SQL";

$respu = mysql_query($SQL,$cx_validar);

while($datosTabla = mysql_fetch_array($respu)){
  $tambor = $datosTabla[0];
  $numpresupuesto = $datosTabla[1];
  $color = $datosTabla[2];
  $productor = $datosTabla[3];
  $localidad = $datosTabla[4];
  $renapa = $datosTabla[5];
  $salaextract = $datosTabla[6];

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $vuelta);
  $col++;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $tambor);
  $col++;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $productor);
  $col++;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $numpresupuesto);
  $col++;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $color);
  $col++;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $localidad);
  $col++;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $renapa);
  $col++;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $salaextract);
  $fila++;
  $col=0;
  $vuelta++;
  if($fila>=10){
    //You can insert/remove rows/columns at a specific position. The following code inserts 1 new rows, right before row 10:
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($fila, 1);
  }
}
$fila=$fila+4;    
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+3,$fila,$vuelta-1);

//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

//prepare download
$filename='tambores_pendientes.xls'; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
?>