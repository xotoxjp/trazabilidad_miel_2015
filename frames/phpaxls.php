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
$let[]='K';
$let[]='L';
$let[]='M';
$let[]='N';
$let[]='O';
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
$let[]='AB';
$let[]='AC';
$let[]='AD';
$let[]='AE';
$let[]='AF';
$let[]='AG';
$let[]='AH';
$let[]='AI';
$let[]='AJ';
$let[]='AK';


$last_ing = date("Y-m-d H:i:s"); ;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='stock1.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);
$vista="Lote";
$lote_array[]=-1;$exclusivo="No";$dist_almacen="No";$or_alm=0;
$prov_id=0;$campo_id=0;$r='';$lote='';$litros='';
$sub=".";$forzar="NO";$leyforzar="";
$orden=$_REQUEST["orden"];
$exclusivo=$_REQUEST["exclusivo"];
$busca=$_REQUEST["BUSCA"];
$vista=$_REQUEST["v"];
$quees=$_REQUEST["q"];



// error_reporting(E_ALL);
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Juan Pablo Soto");
$objPHPExcel->getProperties()->setLastModifiedBy("Juan Pablo Soto");
$objPHPExcel->getProperties()->setTitle("Salida a Excel del Stock");
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
// Escribiendo los datos
if ($vista=="Lote"){$a='        STOCK DE PRODUCTOS';}else {$a='        PRODUCTOS EN PREEMBARQUE';}

$objPHPExcel->getActiveSheet()->setCellValue('F1',$a);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setSize(10);

$h=date("d-m-Y H:i:s");$hora=substr($h,-8);$fecha=substr($h,0,10);

$objPHPExcel->getActiveSheet()->setCellValue('I1','Emitido el:'.$fecha.' a las '.$hora);
$objPHPExcel->getActiveSheet()->mergeCells('I1:O1');
$objPHPExcel->getActiveSheet()->getStyle('I1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('fotos/l_arg_ch.JPG');
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
$objRichText->createText('Fecha');
$objPHPExcel->getActiveSheet()->getCell('B5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Donde Está');
$objPHPExcel->getActiveSheet()->getCell('C5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Lugar');
$objPHPExcel->getActiveSheet()->getCell('D5')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);//


$objRichText = new PHPExcel_RichText();
$objRichText->createText('N° de');
$objPHPExcel->getActiveSheet()->getCell('E4')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Tambor');
$objPHPExcel->getActiveSheet()->getCell('E5')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Nombre del');
$objPHPExcel->getActiveSheet()->getCell('F4')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Productor');
$objPHPExcel->getActiveSheet()->getCell('F5')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Fecha de');
$objPHPExcel->getActiveSheet()->getCell('G4')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Vencimiento');
$objPHPExcel->getActiveSheet()->getCell('G5')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Tipo de');
$objPHPExcel->getActiveSheet()->getCell('H4')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Flora');
$objPHPExcel->getActiveSheet()->getCell('H5')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Cumple');
$objPHPExcel->getActiveSheet()->getCell('I4')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText(' ');
$objPHPExcel->getActiveSheet()->getCell('I5')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('Peso');
$objPHPExcel->getActiveSheet()->getCell('J4')->setValue($objRichText);

$objRichText = new PHPExcel_RichText();
$objRichText->createText('en Kgr.');
$objPHPExcel->getActiveSheet()->getCell('J5')->setValue($objRichText);



$objPHPExcel->getActiveSheet()->getStyle('E4:E5')->applyFromArray(
  array('font'=> array('bold'=> true),
      'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      ),
    ),'E4:E5');
$objPHPExcel->getActiveSheet()->getStyle('F4:F5')->applyFromArray(
  array('font'=> array('bold'=> true),
      'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      ),
    ),'F4:F5');
$objPHPExcel->getActiveSheet()->getStyle('G4:G5')->applyFromArray(
  array('font'=> array('bold'=> true),
      'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      ),
    ),'G4:G5');
$objPHPExcel->getActiveSheet()->getStyle('H4:H5')->applyFromArray(
  array('font'=> array('bold'=> true),
      'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      ),
    ),'H4:H5');
$objPHPExcel->getActiveSheet()->getStyle('I4:I5')->applyFromArray(
  array('font'=> array('bold'=> true),
      'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      ),
    ),'I4:I5');
$objPHPExcel->getActiveSheet()->getStyle('J4:J5')->applyFromArray(
  array('font'=> array('bold'=> true),
      'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      ),
    ),'J4:J5');

$objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray(
  array('font'=> array('bold'=> true),
      'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      ),
    ),'B5');

$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'B4:D4' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'C5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'D5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'K5:AE5' );


$objRichText = new PHPExcel_RichText();
$objRichText->createText('Resultados de los Análisis');
$objPHPExcel->getActiveSheet()->getCell('K4')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->mergeCells('K4:AE4');
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'K4:AE4' );



$a='SELECT cod_anal_id,nomencl1,nomencl FROM '.$_SESSION["tabla_analitico_inf"].' order by 1';
$r=mysql_query($a,$cx_validar);$nro_de_nomen=0;$i=1;
while ($v = mysql_fetch_array($r)) {
  if ($v[1]=='  ') {$v1[1]=$v[2];}
  $objRichText = new PHPExcel_RichText();
  $objRichText->createText($v[1]);
  $cur=$let[$i];
  $objPHPExcel->getActiveSheet()->getCell($let[$i].'5')->setValue($objRichText);
  $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'),$let[$i].'5');
  $i++;
  $nro_de_nomen++;
}
$objRichText='';


if ($vista=="Lote") {
  $a='SELECT mov_detalle.tipo_mov,mov_cabecera.fecha,mov_detalle.nro_mov,mov_cabecera.almac_id_des,almacenes.razon_social,';
  $a=$a.'mov_cabecera.sala_ext,mov_detalle.lote_ext,mov_detalle.lote_id,mov_detalle.cosecha,mov_cabecera.fecha_vto,';
  $a=$a.'mov_det_anal.analisis_id,';
  $a=$a.'mov_detalle.tipo_campo,mov_detalle.cumple,mov_detalle.env_sec,env_secundario.abrev,mov_detalle.lote_env_sec,';
  $a=$a.'provedores.razon_social,mov_cabecera.hora_cierre,mov_detalle.color,mov_detalle.lugar,(mov_detalle.bruto-mov_detalle.tara) as peso  FROM '.$_SESSION["tabla_mov_detalle"].' INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_cabecera"].' on mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
  $a=$a.$_SESSION["tabla_provedores"].' on mov_detalle.prov_id=provedores.prov_id INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_det_anal"].' on (mov_detalle.lote_id=mov_det_anal.lote_id and mov_detalle.sublote_id=mov_det_anal.sublote_id ) INNER JOIN ';
  $a=$a.$_SESSION["tabla_env_secundario"].' on mov_detalle.env_sec=env_secundario.env_sec  INNER JOIN '; 
  $a=$a.$_SESSION["tabla_almacenes"].' on mov_cabecera.almac_id_des=almacenes.almacen_id where   (mov_detalle.tipo_mov="EXA") and  mov_detalle.tipo_mov!="PRE"  and mov_detalle.nro_mov_baja="            " ' ;

}
else {
  $a='SELECT mov_detalle.tipo_mov,mov_cabecera.fecha,mov_detalle.nro_mov,mov_cabecera.almac_id_ori,almacenes.razon_social,';
  $a=$a.'mov_cabecera.sala_ext,mov_detalle.lote_ext,mov_detalle.lote_id,mov_detalle.cosecha,mov_cabecera.fecha_vto,';
  $a=$a.'mov_det_anal.analisis_id,';
  $a=$a.'mov_det_anal.nro_anal,mov_detalle.cumple,mov_detalle.env_sec,env_secundario.abrev,mov_detalle.lote_env_sec,provedores.razon_social,mov_cabecera.hora_cierre,';
  $a=$a.'mov_cabecera.prov_id,mov_cabecera.campo_id,mov_cabecera.almac_id_des,mov_detalle.color,mov_detalle.lugar,(mov_detalle.bruto-mov_detalle.tara) as peso  FROM '.$_SESSION["tabla_mov_detalle"].' INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_cabecera"].' on mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
  $a=$a.$_SESSION["tabla_provedores"].' on mov_detalle.prov_id=provedores.prov_id INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_det_anal"].' on (mov_detalle.lote_id=mov_det_anal.lote_id and mov_detalle.sublote_id=mov_det_anal.sublote_id ) INNER JOIN ';
  $a=$a.$_SESSION["tabla_env_secundario"].' on mov_detalle.env_sec=env_secundario.env_sec  INNER JOIN '; 
  $a=$a.$_SESSION["tabla_almacenes"].' on mov_cabecera.almac_id_ori=almacenes.almacen_id where  mov_detalle.tipo_mov="PRE" and mov_cabecera.hora_cierre="     " ' ;
}

$rs_validar = mysql_query($a,$cx_validar);$k=5;
while ($v_validar = mysql_fetch_array($rs_validar)) {
  // el $v[8] tacho 
  $l=strlen($quees);
  if ($l>0){
    $si=0;
    $aq='SELECT valor1 FROM '.$_SESSION["tabla_respuesta"]." where login='".$_SESSION["acceso_logg"]."' and respuesta='stk' and valor1=".$v_validar[8]   ; 
    $rq = mysql_query($aq,$cx_validar);while ($vq = mysql_fetch_array($rq)) {$si++;}
  }
  if ( ($l==0) or (($l>0) and ($si>0)) ){
    $k++;
    if (strlen($v_validar[3])<1) {$v_validar[3]='&nbsp;';}

    $objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 

    $objPHPExcel->getActiveSheet()->setCellValue('B'.$k, substr($v_validar[1],-2).substr($v_validar[1],4,4).substr($v_validar[1],2,2) );
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$k, $v_validar[4]);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$k, $v_validar[19]);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$k, $v_validar[7]);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$k, $v_validar[16]);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$k, $v_validar[9]);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$k, $v_validar[11]);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$k, $v_validar[12]);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$k, $v_validar[20]);

  

    $a='SELECT resultado,cod_anal_id FROM '.$_SESSION["tabla_analitico"].' where analisis_id="'.$v_validar[10].'" and lote_id='.$v_validar[7].' and cod_anal_id<13  ORDER BY cod_anal_id ';
    $r=mysql_query($a,$cx_validar);$i=0;
    while ($v = mysql_fetch_array($r)) {$i++;
      $m=number_format($v[0], 1, ".", ",");
      $objPHPExcel->getActiveSheet()->setCellValue($let[$i].$k, $m);
      $objPHPExcel->getActiveSheet()->getStyle($let[$i].$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
    //>6 
    
    if ($k!=$k){
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'B'.$k.':AE'.$k );
     
      $l=$k-1;
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B'.$l), 'B'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('C'.$l), 'C'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('D'.$l), 'D'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('E'.$l), 'E'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('F'.$l), 'F'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('G'.$l), 'G'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('G'.$l), 'H'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('I'.$l), 'I'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('J'.$l), 'J'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('K'.$l), 'K'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('L'.$l), 'L'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('M'.$l), 'M'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('N'.$l), 'N'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('O'.$l), 'O'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('P'.$l), 'P'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('Q'.$l), 'Q'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('R'.$l), 'R'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('S'.$l), 'S'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('T'.$l), 'T'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('U'.$l), 'U'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('V'.$l), 'V'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('W'.$l), 'W'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('X'.$l), 'X'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('Y'.$l), 'Y'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('Z'.$l), 'Z'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('AA'.$l), 'AA'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('AB'.$l), 'AB'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('AC'.$l), 'AC'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('AD'.$l), 'AD'.$k );
      $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('AE'.$l), 'AE'.$k );
    }
  }

}





$k++;$m='B'.$k.':AE'.$k;
$objPHPExcel->getActiveSheet()->getStyle($m)->applyFromArray(
array('borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))),$m);


$objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray(
  array('font'=> array('bold'=> true),
      'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
      ),
    ),'B5');

$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'B4:D4' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'C5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'D5' );
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('B5'), 'K5:AE5' );



//Y tambien podemos utilizar formulas
// $objPHPExcel->getActiveSheet()->setCellValue('B12', 'con Datos a sumar');
// $objPHPExcel->getActiveSheet()->setCellValue('B16', '=SUM(B13:B15)');
// Nombramos la hoja

$objPHPExcel->getActiveSheet()->setTitle('Stock de Productos');
// Activamos para que al abrir el excel nos muestre la primer hoja


$objPHPExcel->setActiveSheetIndex(0);
// Guardamos el archivo, en este caso lo guarda con el mismo nombre del php
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$a=__FILE__ ;

$l=strlen($a) - 11; $a=substr($a,0,$l).'stock.xls';

$objWriter->save(str_replace('.php', '.xls', $a));
header("Location: stock.xls"); echo '1';
?>