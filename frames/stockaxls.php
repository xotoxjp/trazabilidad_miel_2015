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
$actualizar="UPDATE ".$_SESSION["tabla_acc"]." SET fec_ult_ut='$last_ing' ,prog_utl='stockaxls.php'  WHERE id_usuario=".$_SESSION["id_usuario"];
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
$objPHPExcel = $objReader->load("docs/stock.xls");
// Indicamos que se pare en la hoja uno del libro
$objPHPExcel->setActiveSheetIndex(0);

/**********************************************  consulta a BD ********************************************************/

$otra = $_GET['tambores'];
$otra2 = explode(",", $otra);
$largo = count($otra2);
$vueltas = 0;
$i=0; 
$fila = 2;
  
while($vueltas < $largo) {
    $col = 0;

    $SQL = "SELECT stock.id_tambor, provedores.c1 as renapa, almacenes.razon_social as sala_ext, deposito.num_lote as lote, 
    deposito.peso, deposito.tara, stock.peso_neto, laboratorio.hmf, laboratorio.color, laboratorio.humedad, laboratorio.acidez,
    deposito.factura as factura, provedores.razon_social as productor, deposito.fecha_llegada, deposito.remito, 
    deposito.almacen, laboratorio.tipo_miel, stock.lote_export, stock.rango 
    FROM stock 
    INNER JOIN presupuestos ON stock.id_presupuesto = presupuestos.id_presupuesto 
    INNER JOIN provedores ON presupuestos.id_productor = provedores.prov_id 
    INNER JOIN laboratorio ON stock.id_laboratorio = laboratorio.id_laboratorio 
    INNER JOIN deposito ON stock.id_deposito = deposito.id_deposito 
    INNER JOIN almacenes ON presupuestos.id_sala_ext = almacenes.almacen_id 
    WHERE stock.id_tambor =".$otra2[$i]." 
      ORDER BY stock.id_tambor"; 

    //echo "$SQL";

    $respu = mysql_query($SQL,$cx_validar);

    while($datosTabla = mysql_fetch_array($respu)){
      $tambor = $datosTabla[0];
      $renapa = $datosTabla[1];
      $sala = $datosTabla[2];
      $lote = $datosTabla[3];
      $peso_bruto = $datosTabla[4];
      $tara = $datosTabla[5];
	    $peso_neto = $datosTabla[6];
      $hmf = $datosTabla[7];
      $color = $datosTabla[8];
      $humedad = $datosTabla[9];
      $acidez = $datosTabla[10];
      $factura = $datosTabla[11];
      $productor = $datosTabla[12];
      $fecha_ingreso = $datosTabla[13];
      $remito = $datosTabla[14];
      $deposito = $datosTabla[15];
      $tipo_miel= $datosTabla[16];
      $gsb= $datosTabla[17];
      $rango= $datosTabla[18];
    }
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $tambor);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $renapa);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $sala);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $lote);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $peso_bruto);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $tara);
    $col++;
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $peso_neto);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $hmf);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $color);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $humedad);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $acidez);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $factura);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $productor);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $fecha_ingreso);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $remito );
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $deposito);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $tipo_miel);
    $col++;     
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $gsb);
    $col++;    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $rango);
    $col++;      

    $fila++;
    
  $vueltas++;
  $i++; 
}

/***************************************** fin del while *****************************************/

//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');


//prepare download
$filename='datos_stock.xls'; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
?>