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
$actualizar="UPDATE ".$_SESSION["tabla_acc"]." SET fec_ult_ut='$last_ing' ,prog_utl='logisticaxls.php'  WHERE id_usuario=".$_SESSION["id_usuario"];
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
$objPHPExcel = $objReader->load("docs/planilla_Logistica.xls");
// Indicamos que se pare en la hoja uno del libro
$objPHPExcel->setActiveSheetIndex(0);



/**********************************************  consulta de datos en BD ********************************************************/
$no_ingreso = $_GET['ingreso'];

$filaEscribirExcel = 12;

$resultado = mysql_query("SELECT 
    deposito.id_tambor as tambor,
    provedores.c1 as renapa,
    almacenes.razon_social as sala_ext,    
    deposito.num_lote as lote,
    provedores.razon_social as productor
    FROM deposito 
    INNER JOIN presupuestos ON deposito.id_presupuesto = presupuestos.id_presupuesto
    INNER JOIN provedores ON deposito.id_productor=provedores.prov_id 
    INNER JOIN almacenes ON presupuestos.id_sala_ext = almacenes.almacen_id 
    WHERE deposito.num_ingreso =".$no_ingreso."
    ORDER BY deposito.id_tambor");

while ($fila = mysql_fetch_array($resultado, MYSQL_ASSOC)) {
    $tambor = $fila["tambor"];
    $renapa = $fila["renapa"];
    $sala = $fila["sala_ext"];
    $lote = $fila["lote"];
    $productor = $fila["productor"];
    //echo "$tambor, $renapa, $sala, $lote,$productor";
    //ubico en hoja excel
    $col = 1;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $filaEscribirExcel, $tambor);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $filaEscribirExcel, $renapa);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $filaEscribirExcel, $sala);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $filaEscribirExcel, $lote);
    $col=9;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $filaEscribirExcel, $productor);
    $filaEscribirExcel++; 
}

mysql_free_result($resultado);

  

$SQL="SELECT DISTINCT chofer, fecha_llegada, camion, transporte, num_ingreso
    FROM deposito WHERE deposito.num_ingreso =".$no_ingreso." ";
//echo "$SQL";
$respu = mysql_query($SQL,$cx_validar);

while($datosTabla = mysql_fetch_array($respu, MYSQL_ASSOC)){
  $chofer = $datosTabla["chofer"];
  $llegada = $datosTabla["fecha_llegada"];
  $camion = $datosTabla["camion"];
  $transporte = $datosTabla["transporte"];
  $ingreso = $datosTabla["num_ingreso"];
}

$objPHPExcel->getActiveSheet()->setCellValue('C7',$chofer);
$objPHPExcel->getActiveSheet()->mergeCells('C7:D7');
$objPHPExcel->getActiveSheet()->getStyle('C7:D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet()->setCellValue('H5',$llegada);
$objPHPExcel->getActiveSheet()->setCellValue('H6',$transporte);
$objPHPExcel->getActiveSheet()->setCellValue('H7',$camion);

//variable de numero de ingreso
$numeroIngreso='Ingreso Nº'.$ingreso;
$objPHPExcel->getActiveSheet()->setCellValue('G4',$numeroIngreso);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('G4:H4');
$objPHPExcel->getActiveSheet()->getStyle('G4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



/***************************************** fin del while  *****************************************/

//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save("planilla_Logistica.xls");
//header("Location: docs/planilla_Logistica.xls");


//prepare download
$filename='deposito.xls'; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
?>