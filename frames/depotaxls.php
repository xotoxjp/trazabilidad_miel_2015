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
$objPHPExcel = $objReader->load("docs/planilla_Ingreso.xls");
// Indicamos que se pare en la hoja uno del libro
$objPHPExcel->setActiveSheetIndex(0);



/**********************************************  agregado por nosotros ********************************************************/

$otra = $_GET['tambores'];
$otra2 = explode(",", $otra);
$largo = count($otra2);
$vueltas = 0;
$i=0; 
$fila = 12;
  
while($vueltas < $largo) {
    $col = 1;
    
    $SQL="SELECT deposito.id_tambor as tambor, 
                 provedores.c1 as renapa,
                 almacenes.razon_social as sala,
                 deposito.num_lote as lote,
                 deposito.peso ,
                 deposito.tara,
                 laboratorio.color,                 
                 provedores.razon_social                
            FROM deposito
            INNER JOIN stock ON stock.id_deposito = deposito.id_deposito
            INNER JOIN provedores ON provedores.prov_id = deposito.id_productor
            INNER JOIN presupuestos ON presupuestos.id_presupuesto = deposito.id_presupuesto
            INNER JOIN almacenes ON almacenes.almacen_id = presupuestos.id_sala_ext
            INNER JOIN laboratorio ON laboratorio.id_tambor = deposito.id_tambor
            WHERE deposito.id_tambor =".$otra2[$i]." 
            ORDER BY deposito.id_tambor ";
    //echo "$SQL";

    $respu = mysql_query($SQL,$cx_validar);

    while($datosTabla = mysql_fetch_array($respu)){
      $tambor = $datosTabla[0];
      $renapa = $datosTabla[1];
      $sala = $datosTabla[2];
      $lote = $datosTabla[3];
      $peso = $datosTabla[4];
      $tara = $datosTabla[5];
      $color = $datosTabla[6];
      $productor = $datosTabla[7];
    }
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $tambor);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $renapa);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $sala);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $lote);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila, $peso);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $tara);
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $color);
    $col++;
    $col++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $fila , $productor);
    $col++;
    $fila++;
    
  $vueltas++;
  $i++; 
}

"UPDATE deposito SET remito='".$remito."', camion='".$patente."', chofer='".$chofer."', fecha_llegada='".$fecha."',num_lote='".$lote."' , estado='STOCK' WHERE id_tambor='".$tambor[$a]."' " ;
    

$SQL="SELECT remito, chofer, fecha_llegada, camion, transporte, num_ingreso
    FROM deposito WHERE deposito.id_tambor =".$otra2[0]." 
    ORDER BY deposito.id_tambor ";
//echo "$SQL";
$respu = mysql_query($SQL,$cx_validar);

while($datosTabla = mysql_fetch_array($respu)){
  $remito = $datosTabla[0];
  $chofer = $datosTabla[1];
  $llegada = $datosTabla[2];
  $camion = $datosTabla[3];
  $transporte = $datosTabla[4];
  $ingreso = $datosTabla[5];
}

$objPHPExcel->getActiveSheet()->setCellValue('C6',$remito);
$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
$objPHPExcel->getActiveSheet()->getStyle('C6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setCellValue('C7',$chofer);
$objPHPExcel->getActiveSheet()->mergeCells('C7:D7');
$objPHPExcel->getActiveSheet()->getStyle('C7:D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet()->setCellValue('H5',$llegada);
$objPHPExcel->getActiveSheet()->setCellValue('H6',$transporte);
$objPHPExcel->getActiveSheet()->setCellValue('H7',$camion);

$numeroIngreso='Ingreso Nº'.$ingreso;//variable de numero de ingreso
$objPHPExcel->getActiveSheet()->setCellValue('G4',$numeroIngreso);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('G4:H4');
$objPHPExcel->getActiveSheet()->getStyle('G4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



/***************************************** fin del while de Yety *****************************************/

//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save("planilla_Ingreso.xls");
//header("Location: docs/planilla_Ingreso.xls");


//prepare download
$filename='deposito.xls'; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
?>