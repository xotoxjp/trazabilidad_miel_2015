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
$actualizar="UPDATE ".$_SESSION["tabla_acc"]." SET fec_ult_ut='$last_ing' ,prog_utl='depotaxls.php'  WHERE id_usuario=".$_SESSION["id_usuario"];
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
$objPHPExcel = $objReader->load("docs/compra.xls");
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
$otra = $_GET['tambores'];
$otra2 = explode(",", $otra);
$largo = count($otra2);
$vueltas = 0;
$i=0; 
$fila = 10;
  
while($vueltas < $largo) {
    $col = 0;
    
    $SQL="SELECT laboratorio.id_tambor,provedores.razon_social,laboratorio.color,laboratorio.hmf,laboratorio.humedad,laboratorio.acidez,laboratorio.resultado 
          FROM laboratorio
          INNER JOIN provedores ON laboratorio.id_productor = provedores.prov_id 
          WHERE id_tambor = ".$otra2[$i]." 
          GROUP BY id_tambor ";
    //echo "$SQL";

    $respu = mysql_query($SQL,$cx_validar);

    while($datosTabla = mysql_fetch_array($respu)){
      $tambor = $datosTabla[0];
      $productor = $datosTabla[1];
      $color = $datosTabla[2];
      $hmf = $datosTabla[3];
      $humedad = $datosTabla[4];
      $acidez = $datosTabla[5];
      $cumple = $datosTabla[6];
    }
    



    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $tambor);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $productor);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $hmf);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $color);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $humedad);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $acidez);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $cumple);
    $fila++;
    
  $vueltas++;
  $i++; 
}



//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save("planilla_Ingreso.xls");
//header("Location: docs/planilla_Ingreso.xls");


//prepare download
$filename='orden_compra.xls'; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
?>