<?session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];

$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=13 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
//if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }
$let[]=-1 ;
$let[]='P';
$let[]='Q';
$let[]='R';
$let[]='S';
$let[]='T';
$let[]='U';
$let[]='V';
$let[]='W';
$let[]='X';
$let[]='Y';
$let[]='Z';
$let[]='AA';


$last_ing = date("Y-m-d H:i:s"); ;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='stock1.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);

$actualizar='DELETE FROM '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="stk"';
mysql_query($actualizar,$cx_validar);

$vista="Lote";
$lote_array[]=-1;$exclusivo="No";$dist_almacen="No";$or_alm=0;
$prov_id=0;$campo_id=0;$r='';$lote='';$litros='';
$sub=".";$forzar="NO";$leyforzar="";
$orden=$_REQUEST["orden"];
$exclusivo=$_REQUEST["exclusivo"];
$busca=$_REQUEST["BUSCA"];
$vista=$_REQUEST["v"];



error_reporting(E_ALL);
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
// Escribiendo los datos
if ($vista=="Lote"){$a='        STOCK DE PRODUCTOS';}else {$a='        PRODUCTOS EN PREEMBARQUE';}

$objPHPExcel->getActiveSheet()->setCellValue('B1',$a);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->setCellValue('J1','Emitido el:');
$objPHPExcel->getActiveSheet()->setCellValue('N1','a las:');

$h=date("d-m-Y H:i:s");$hora=substr($h,-8);$fecha=substr($h,0,10);
$objPHPExcel->getActiveSheet()->setCellValue('K1',$fecha);
$objPHPExcel->getActiveSheet()->setCellValue('O1',$hora);


$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('fotos/LGMIELCHACO.JPG');
$objDrawing->setHeight(47);

//To add the above drawing to the worksheet, use the following snippet of code. PHPExcel creates the link between the drawing and the worksheet:
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());





// Ahora texto con propiedadeS
$objRichText = new PHPExcel_RichText();
$objRichText->createText('Datos del Ultimo Movimiento');
$objPHPExcel->getActiveSheet()->getCell('B4')->setValue($objRichText);
//combinando celdas
 $objPHPExcel->getActiveSheet()->mergeCells('B4:D4');
 $objPHPExcel->getActiveSheet()->getStyle('B4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Tipo');
$objPHPExcel->getActiveSheet()->getCell('B5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Fecha');
$objPHPExcel->getActiveSheet()->getCell('C5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Numero');
$objPHPExcel->getActiveSheet()->getCell('D5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);//

$objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray(
	array('font'=> array('bold'=> true),
 	    'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 	  	'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 	  	'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 	  	'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
 	  	),
 	  ),'B5');

$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'B4:D4' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'E4:E5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'F4:H4' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'I4:K4' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'L4:M4' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'N4:O4' );

$objRichText = new PHPExcel_RichText();
if ($vista=="Lote") {$objRichText->createText('Ubicacion');} else  {$objRichText->createText('Destino');} 
$objPHPExcel->getActiveSheet()->getCell('E4')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);



$objRichText = new PHPExcel_RichText();
$objRichText->createText('Producto');
$objPHPExcel->getActiveSheet()->getCell('F4')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->mergeCells('F4:H4');
$objPHPExcel->getActiveSheet()->getStyle('F4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objRichText = new PHPExcel_RichText();
$objRichText->createText('Nombre');
$objPHPExcel->getActiveSheet()->getCell('F5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Lote');
$objPHPExcel->getActiveSheet()->getCell('G5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Cosecha');
$objPHPExcel->getActiveSheet()->getCell('H5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);


$objRichText = new PHPExcel_RichText();
$objRichText->createText('Analisis');
$objPHPExcel->getActiveSheet()->getCell('I4')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->mergeCells('I4:K4');
$objPHPExcel->getActiveSheet()->getStyle('I4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('ID');
$objPHPExcel->getActiveSheet()->getCell('I5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Nro.del Anal.');
$objPHPExcel->getActiveSheet()->getCell('J5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Cumple');
$objPHPExcel->getActiveSheet()->getCell('K5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);





$objRichText = new PHPExcel_RichText();
$objRichText->createText('Envase');
$objPHPExcel->getActiveSheet()->getCell('L4')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->mergeCells('L4:M4');
$objPHPExcel->getActiveSheet()->getStyle('L4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Descripcion');
$objPHPExcel->getActiveSheet()->getCell('L5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Lote');
$objPHPExcel->getActiveSheet()->getCell('M5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objRichText = new PHPExcel_RichText();
$objRichText->createText('Representa');
$objPHPExcel->getActiveSheet()->getCell('N4')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->mergeCells('N4:O4');
$objPHPExcel->getActiveSheet()->getStyle('N4:O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Lts.');
$objPHPExcel->getActiveSheet()->getCell('N5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Kgr.');
$objPHPExcel->getActiveSheet()->getCell('O5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Resultados de Analisis');
$objPHPExcel->getActiveSheet()->getCell('P4')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->mergeCells('P4:Z4');

$objPHPExcel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$a='SELECT cod_anal_id,nomencl1 FROM '.$_SESSION["tabla_analitico_inf"].' order by 1';
$r=mysql_query($a,$cx_validar);$nro_de_nomen=0;$i=1;
while ($v = mysql_fetch_array($r)) {
  $objRichText = new PHPExcel_RichText();
  $objRichText->createText($v[1]);
  $cur=$let[$i];
  $objPHPExcel->getActiveSheet()->getCell($let[$i].'5')->setValue($objRichText);
  $i++;
  $nro_de_nomen++;
}


$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'P4' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'C5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'D5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'F5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'G5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'H5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'I5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'J5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'K5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'L5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'M5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'N5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'O5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'P5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'Q5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'R5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'S5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'T5' );

$objPHPExcel->getActiveSheet()->getStyle('P5:Z5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P:Z')->setAutoSize(true);

 $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);



if ($vista=="Lote") {
  $a='SELECT mov_detalle.tipo_mov,mov_cabecera.fecha,mov_detalle.nro_mov,mov_cabecera.almac_id_des,almacenes.razon_social,mov_detalle.prod_id,';
  $a=$a.'producto.abrev,mov_detalle.cosecha,mov_detalle.lote_id,mov_detalle.sublote_id,';
  $a=$a.'mov_det_anal.analisis_id,';
  $a=$a.'mov_det_anal.nro_anal,mov_det_anal.cumple,mov_detalle.env_sec,env_secundario.nombre,mov_detalle.lote_env_sec,env_secundario.contiene,';
  $a=$a.'env_secundario.unidad,env_secundario.peso_stand FROM '.$_SESSION["tabla_mov_detalle"].' INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_cabecera"].' on mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_det_anal"].' on (mov_detalle.lote_id=mov_det_anal.lote_id and mov_detalle.sublote_id=mov_det_anal.sublote_id ) INNER JOIN ';
  $a=$a.$_SESSION["tabla_almacenes"].' on mov_cabecera.almac_id_des=almacenes.almacen_id  INNER JOIN ';
  $a=$a.$_SESSION["tabla_env_secundario"].' on mov_detalle.env_sec=env_secundario.env_sec  INNER JOIN '; 
  $a=$a.$_SESSION["tabla_productos"].' on mov_detalle.prod_id=producto.prod_id where mov_detalle.tipo_mov!="PRE"  and mov_detalle.nro_mov_baja="            " ' ;
}
else {
  $a='SELECT mov_detalle.tipo_mov,mov_cabecera.fecha,mov_detalle.nro_mov,mov_cabecera.almac_id_des,clientes.razon_social,mov_detalle.prod_id,';
  $a=$a.'producto.abrev,mov_detalle.cosecha,mov_detalle.lote_id,mov_detalle.sublote_id,';
  $a=$a.'mov_det_anal.analisis_id,mov_det_anal.nro_anal,mov_det_anal.cumple,';
  $a=$a.'mov_detalle.env_sec,env_secundario.nombre,mov_detalle.lote_env_sec,env_secundario.contiene,';
  $a=$a.'env_secundario.unidad,env_secundario.peso_stand FROM '.$_SESSION["tabla_mov_detalle"].' INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_cabecera"].' on mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_det_anal"].' on (mov_detalle.lote_id=mov_det_anal.lote_id and mov_detalle.sublote_id=mov_det_anal.sublote_id ) INNER JOIN ';
  $a=$a.$_SESSION["tabla_clientes"].' on mov_cabecera.almac_id_des=clientes.cliente_id  INNER JOIN ';
  $a=$a.$_SESSION["tabla_env_secundario"].' on mov_detalle.env_sec=env_secundario.env_sec  INNER JOIN '; 
  $a=$a.$_SESSION["tabla_productos"].' on mov_detalle.prod_id=producto.prod_id where mov_detalle.tipo_mov="PRE"  and mov_cabecera.hora_cierre="     " ' ;
}


 $objPHPExcel->getActiveSheet()->getStyle('O6')->applyFromArray(
  array('borders' => array('right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))),'O6');
 $objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray(
  array('borders' => array('left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))),'B6');
 
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B6'), 'E6' );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B6'), 'F6' );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B6'), 'I6' );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B6'), 'L6' );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B6'), 'N6' );
 
$rs_validar = mysql_query($a,$cx_validar);$k=5;
while ($v_validar = mysql_fetch_array($rs_validar)) {

  $k++;
  if (strlen($v_validar[3])<1) {$v_validar[3]='&nbsp;';}

  $objPHPExcel->getActiveSheet()->setCellValue('B'.$k, $v_validar[0] );
  $objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 

  $objPHPExcel->getActiveSheet()->setCellValue('C'.$k, substr($v_validar[1],-2).substr($v_validar[1],4,4).substr($v_validar[1],2,2) );
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$k, $v_validar[2]);
  $objPHPExcel->getActiveSheet()->setCellValue('E'.$k, $v_validar[4]);
  $objPHPExcel->getActiveSheet()->setCellValue('F'.$k, $v_validar[6]);
  $objPHPExcel->getActiveSheet()->setCellValue('G'.$k, $v_validar[8]);
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$k, $v_validar[7]);
  $objPHPExcel->getActiveSheet()->setCellValue('I'.$k, $v_validar[10]);
  $objPHPExcel->getActiveSheet()->setCellValue('J'.$k, $v_validar[11]);
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$k, $v_validar[12]);
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$k, $v_validar[14]);
  $objPHPExcel->getActiveSheet()->setCellValue('M'.$k, $v_validar[15]);
  $m=number_format($v_validar[16], 0, ",", ".");
  $objPHPExcel->getActiveSheet()->setCellValue('N'.$k,$m .' '.$v_validar[17]);
  $objPHPExcel->getActiveSheet()->getStyle('N'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $m=number_format($v_validar[18], 1, ",", ".");
  $objPHPExcel->getActiveSheet()->setCellValue('O'.$k, $m);
  $objPHPExcel->getActiveSheet()->getStyle('O'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  //if (strlen($v_validar[10])>3){
    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=1 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);
  //  echo $a;
    while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('P'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('P'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'P'.$k);


    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=2 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('Q'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('Q'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'Q'.$k);
 
    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=3 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('R'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('R'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'R'.$k);

    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=4 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('S'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('S'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'S'.$k);

    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=5 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'T'.$k);

    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=6 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'U'.$k);
    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=7 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'V'.$k);
    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=8 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'W'.$k);


    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=9 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'X'.$k);

    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=10 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'Y'.$k);

    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=11 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'Z'.$k);

    $a='SELECT resultado FROM '.$_SESSION["tabla_analitico"].' where cod_anal_id=12 and analisis_id="'.$v_validar[10].'"';
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),'AA'.$k);






  //}







  if ($k>6){
    $l=$k-1;
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('O'.$l), 'O'.$k );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B'.$l), 'B'.$k );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('E'.$l), 'E'.$k );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('E'.$l), 'F'.$k );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('E'.$l), 'I'.$k );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('E'.$l), 'L'.$k );
    $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('O'.$l), 'M'.$k );
  }
}
$k++;$m='B'.$k.':O'.$k;
$objPHPExcel->getActiveSheet()->getStyle($m)->applyFromArray(
array('borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))),$m);
//Y tambien podemos utilizar formulas
// $objPHPExcel->getActiveSheet()->setCellValue('B12', 'con Datos a sumar');
// $objPHPExcel->getActiveSheet()->setCellValue('B16', '=SUM(B13:B15)');
// Nombramos la hoja
$objPHPExcel->getActiveSheet()->setTitle('Stock de Productos');
// Activamos para que al abrir el excel nos muestre la primer hoja
$objPHPExcel->setActiveSheetIndex(0);
// Guardamos el archivo, en este caso lo guarda con el mismo nombre del php
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$a=__FILE__ ;$l=strlen($a) - 11; $a=substr($a,0,$l).'docs/stock.xls';
$objWriter->save(str_replace('.php', '.xls', $a));
header("Location: docs/stock.xls"); echo '1';
?>