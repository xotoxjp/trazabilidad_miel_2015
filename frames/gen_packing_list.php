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
$actualizar="UPDATE ".$_SESSION["tabla_acc"]." SET fec_ult_ut='$last_ing' ,prog_utl='gen_packing_list.php'  WHERE id_usuario=".$_SESSION["id_usuario"];
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
$objPHPExcel = $objReader->load("docs/packing_list_GSB.xls");
// Indicamos que se pare en la hoja uno del libro
$objPHPExcel->setActiveSheetIndex(0);

/**********************************************  consulta a BD ********************************************************/

$otra = $_GET['tambores'];
$otra2 = explode(",", $otra);
$largo = count($otra2);
$vueltas = 0;
$i=0; 
$fila = 15;
  
while($vueltas < $largo) {
    $col = 0;
    
    $SQL="SELECT export.id_tambor as drum, 
                 provedores.c1 as producer,
                 almacenes.razon_social as extraction_room,
                 deposito.num_lote as lot,
                 deposito.tara as tare,
				         deposito.peso as gross_weight,
                 stock.peso_neto as net_weight  
            FROM export
            INNER JOIN stock ON stock.id_stock = export.id_stock
            INNER JOIN presupuestos ON presupuestos.id_presupuesto = stock.id_presupuesto
            INNER JOIN provedores ON provedores.prov_id = presupuestos.id_productor
            INNER JOIN almacenes ON almacenes.almacen_id = presupuestos.id_sala_ext
            INNER JOIN deposito ON deposito.id_deposito = stock.id_deposito
            WHERE export.id_tambor =".$otra2[$i]." 
            ORDER BY export.id_tambor ";
    //echo "$SQL";

    $respu = mysql_query($SQL,$cx_validar);

    while($datosTabla = mysql_fetch_array($respu)){
      $tambor = $datosTabla[0];
      $productor = $datosTabla[1];
      $sala = $datosTabla[2];
      $lote = $datosTabla[3];
      $tara = $datosTabla[4];
      $peso = $datosTabla[5];
	    $peso_net = $datosTabla[6];
    }
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $tambor);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $productor);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $sala);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $lote);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $peso);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $tara);
    $col++;
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $peso_net);
    $col++;
   
    $fila++;
    
  $vueltas++;
  $i++; 
}

$SQL="SELECT num_loteGSB
    FROM export WHERE id_tambor =".$otra2[0]." 
    ORDER BY id_tambor ";
//echo "$SQL";
$respu = mysql_query($SQL,$cx_validar);

while($datosTabla = mysql_fetch_array($respu)){
  $lote = $datosTabla[0];
}


$numeroLote='Lot: GSB'.$lote;//variable de numero de ingreso
$objPHPExcel->getActiveSheet()->setCellValue('B12',$numeroLote);
$objPHPExcel->getActiveSheet()->mergeCells('B12:F12');
$objPHPExcel->getActiveSheet()->getStyle('B12:F12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

/***************************************** fin del while *****************************************/

//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save("planilla_Ingreso.xls");
//header("Location: docs/planilla_Ingreso.xls");


//prepare download
$filename='packing_list.xls'; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
?>