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
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }
 

$last_ing = date("Y-m-d H:i:s"); ;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='stock1.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);

//$actualizar='DELETE FROM '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="stk"';
//mysql_query($actualizar,$cx_validar);
$quees='';
$vista="Lote";
$lote_array[]=-1;$exclusivo="No";$dist_almacen="No";$or_alm=0;
$prov_id=0;$campo_id=0;$r='';$lote='';$litros='';
$sub=".";$forzar="NO";$leyforzar="";
$orden=$_REQUEST["orden"];
$exclusivo=$_REQUEST["exclusivo"];
$busca=$_REQUEST["BUSCA"];
$vista=$_REQUEST["v"];
$quees=$_REQUEST["q"];
$title=' ';
$meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul","Ago", "Sep", "Oct", "Nov", "Dic");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$last_ing = date("Y-m-d H:i:s");


define('FPDF_FONTPATH','fpdf/font/');
require_once('fpdf/fpdf.php');

class PDF extends FPDF
{
function Footer()
{
    //Go to 1.5 cm from bottom
//    $this->SetY(-10);
    //Select Arial italic 8
//    $this->SetFont('Arial','',8);
    //Print current and total page numbers
//    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
}
//Tabla simple


function Header()
{
   global $i1,$i2,$i3,$i4,$i5,$i6,$i7,$i8,$i9,$i10,$i11,$i12,$i13,$i14,$i15,$i16,$i17,$i18,$i19,$i20,$off1,$off2,$vista;
   $this->setxy(10,10);
 	$this->Image('fotos/l_arg_ch.JPG',1,1,15);

    global $title;
    if ($vista=="Lote"){$title='STOCK DE PRODUCTOS';}else {$title='PRODUCTOS EN PREEMBARQUE';}
    //Arial bold 15
    //$this->SetFont('Arial','B',14);
    $this->SetFont('Arial','B',11);
    //Calculamos ancho y posición del título.
    $w=$this->GetStringWidth($title)+6;
    $this->SetXY(70,5);
    //Colores de los bordes, fondo y texto
    $this->SetDrawColor(0,0,0);
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    //Ancho del borde (1 mm)
    $this->SetLineWidth(0);
    //Título     $w
    $this->SetXY(50,5);
    $this->Cell(80,9,$title,0,0,'C',true);
    $l = date("d-m-Y H:i:s"); 
    $title='Impreso el '.substr($l,0,10).' a las '.substr($l,-8);
    $this->SetFont('Arial','',8);
    $this->SetXY(150,5);
    $this->Cell(55,9,$title,0,0,'L',false);
    $this->SetTextColor(0,0,0);

    $this->SetFont('Arial','',8);

    $this->setxy(1,15);
    $title="Donde Está";
	  $this->Cell(40,5,$title,1,1,'C',true);

    $this->setxy(41,15);
    if ($vista=="Lote") {$title="Lugar";} else {$title="Destino";}
	  $this->Cell(10,5,$title,1,1,'C',true);

    $this->setxy(51,15);
    $title="Tambor";
    $this->Cell(15,5,$title,1,1,'C',true);

    $this->setxy(66,15);
    $title="Color";
    $this->Cell(13,5,$title,1,1,'C',true);

    $this->setxy(78,15);
    $title="Productor";
    $this->Cell(80,5,$title,1,1,'C',true);

    $this->setxy(158,15);
    $title="Fecha Vto";
    $this->Cell(14,5,$title,1,1,'C',true);


    $this->SetFont('Arial','',7);
    $this->setxy(172,15);
    $title="Flora Tipo";
    $this->Cell(25,5,$title,1,1,'C',true);

    $this->setxy(197,15);
    $title="Cumple";
    $this->Cell(12,5,$title,1,1,'C',true);

    $this->setxy(190,1);
    $this->SetFont('Arial','',6);
  	$this->Cell(17,5,'Página '.$this->PageNo().'/{nb}',1,1,'L',true);
    $this->setxy(1,25);

	$i=0;
}
}

$meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul","Ago", "Sep", "Oct", "Nov", "Dic");

$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->SetTitle($title);
$pdf->SetFont('Arial','',8);
$pdf->AddPage();
$vista=$_REQUEST["v"];


if ($vista=="Lote"){
  $a='SELECT almacenes.razon_social,mov_detalle.lugar,mov_detalle.lote_id,mov_detalle.color,provedores.razon_social,mov_cabecera.fecha_vto,';
  $a=$a.'mov_detalle.tipo_campo,mov_detalle.cumple  FROM '.$_SESSION["tabla_mov_detalle"].' INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_cabecera"].' on mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
  $a=$a.$_SESSION["tabla_provedores"].' on mov_detalle.prov_id=provedores.prov_id INNER JOIN ';
  $a=$a.$_SESSION["tabla_almacenes"].' on mov_cabecera.almac_id_des=almacenes.almacen_id where   (mov_detalle.tipo_mov="EXA") and  mov_detalle.tipo_mov!="PRE"  and mov_detalle.nro_mov_baja="            " ' ;
}  
else {
  $a='SELECT almacenes.razon_social,mov_detalle.lugar,mov_detalle.lote_id,mov_detalle.color,provedores.razon_social,mov_cabecera.fecha_vto,';
  $a=$a.'mov_detalle.tipo_campo,mov_detalle.cumple  FROM '.$_SESSION["tabla_mov_detalle"].' INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_cabecera"].' on mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
  $a=$a.$_SESSION["tabla_provedores"].' on mov_detalle.prov_id=provedores.prov_id INNER JOIN '; 
  $a=$a.$_SESSION["tabla_almacenes"].' on mov_cabecera.almac_id_ori=almacenes.almacen_id where  mov_detalle.tipo_mov="PRE" and mov_cabecera.hora_cierre="     " ' ;
}
$a=$a.' ORDER BY ';
if ($vista=="Lote"){
  switch ($orden) {
  case 'TIUP':$a=$a ." mov_detalle.lugar,mov_detalle.lote_id ";$xorden="Lugar en la Sala Ascendente"; break;
  case 'TIDN':$a=$a ." mov_detalle.lugar DESC,mov_detalle.lote_id DESC";$xorden="Lugar en la Sala Descendente";break;
  case 'FDUP':$a=$a ." mov_cabecera.fecha ";$xorden="Fecha del Mov. Ascendente";break;
  case 'FDDN':$a=$a ." mov_cabecera.fecha DESC";$xorden="Fecha del Mov. Descendente";break;
  case 'NDUP':$a=$a ." mov_detalle.nro_mov  ";$xorden="N&ordm; Ultimo Documento Ascendente";break;
  case 'NDDN':$a=$a ." mov_detalle.nro_mov  DESC";$xorden="N&ordm; Ultimo Documento Descendente";break;
  case 'ALUP':$a=$a ." almacenes.razon_social ASC ";$xorden="Nombre del Almacen Ascendente";break;
  case 'ALDN':$a=$a ." almacenes.razon_social DESC";$xorden="Nombre del Almacen Descendente";break;
  case 'IPUP':$a=$a ." mov_cabecera.sala_ext ASC ";$xorden="Sala de Extracci&oacute;n Ascendente";break;
  case 'IPDN':$a=$a ." mov_cabecera.sala_ext DESC";$xorden="Sala de Extracci&oacute;n Descendente";break;
  case 'NPUP':$a=$a ." mov_detalle.lote_ext ASC , mov_detalle.lote_id ASC ";$xorden="Lote de Extracci&oacute; Ascendente";break;
  case 'NPDN':$a=$a ." mov_detalle.lote_ext DESC , mov_detalle.lote_id DESC";$xorden="Lote de Extracci&oacute; Descendente";break;
  case 'ACUP':$a=$a ." mov_detalle.cosecha ASC ";$xorden="A&ntilde;o de Cosecha Ascendente";break;
  case 'ACDN':$a=$a ." mov_detalle.cosecha DESC";$xorden="A&ntilde;o de Cosecha Descendente";break;
  case 'LOUP':$a=$a ." mov_detalle.lote_id ASC ";$xorden="Tambor Ascendente";break;
  case 'LODN':$a=$a ." mov_detalle.lote_id DESC";$xorden="Tambor Descendente";break;
  case 'SUUP':$a=$a ." mov_cabecera.fecha_vto ASC ";$xorden="Fecha de Vencimiento Ascendente";break;
  case 'SUDN':$a=$a ." mov_cabecera.fecha_vto DESC";$xorden="Fecha de Vencimiento Descendente";break;
  case 'AIUP':$a=$a ." mov_det_anal.analisis_id ASC ";$xorden="An&aacute;lisis ID Ascendente";break;
  case 'AIDN':$a=$a ." mov_det_anal.analisis_id DESC";$xorden="An&aacute;lisis ID Descendente";break;
  case 'NRUP':$a=$a ." mov_detalle.tipo_campo ASC ";$xorden="Tipo de Flora Ascendente";break;
  case 'NRDN':$a=$a ." mov_detalle.tipo_campo DESC";$xorden="Tipo de Flora Descendente";break;
  case 'CIUP':$a=$a ." env_secundario.nombre ASC ";$xorden="Envase Secundario Ascendente";break;
  case 'CIDN':$a=$a ." env_secundario.nombre DESC";$xorden="Envase Secundario Descendente";break;
  case 'CAUP':$a=$a ." mov_detalle.lote_env_sec ASC ";$xorden="Lote del Envase Secundario Ascendente";break;
  case 'CADN':$a=$a ." mov_detalle.lote_env_sec DESC";$xorden="Lote del Envase Secundario Descendente";break;
  case 'PRUP':$a=$a ." provedores.abrev ASC ";$xorden="Provedor Ascendente";break;
  case 'PRDN':$a=$a ." provedores.abrev DESC";$xorden="Provedor Descendente";break;
  default: $a=$a ." mov_detalle.nro_mov ASC";$xorden="Nro. de Mov.Ascendente"; break;
  }
  }
else {
  switch ($orden) {
  case 'TIUP':$a=$a ." mov_detalle.lugar,mov_detalle.lote_id ";$xorden="Lugar en la Sala Ascendente"; break;
  case 'TIDN':$a=$a ." mov_detalle.lugar DESC,mov_detalle.lote_id DESC";$xorden="Lugar en la Sala Descendente";break;
  case 'FDUP':$a=$a ." mov_cabecera.fecha ";$xorden="Fecha del Mov. Ascendente";break;
  case 'FDDN':$a=$a ." mov_cabecera.fecha DESC";$xorden="Fecha del Mov. Descendente";break;
  case 'NDUP':$a=$a ." mov_detalle.nro_mov  ";$xorden="N&ordm; Documento Ascendente";break;
  case 'NDDN':$a=$a ." mov_detalle.nro_mov  DESC";$xorden="N&ordm; Documento Descendente";break;
  case 'ALUP':$a=$a ." clientes.razon_social ASC ";$xorden="Nombre del CLiente Ascendente";break;
  case 'ALDN':$a=$a ." clientes.razon_social DESC";$xorden="Nombre del Cliente Descendente";break;
  case 'IPUP':$a=$a ." mov_cabecera.sala_ext ASC ";$xorden="Sala de Extracci&oacute;n Ascendente";break;
  case 'IPDN':$a=$a ." mov_cabecera.sala_ext DESC";$xorden="Sala de Extracci&oacute;n Descendente";break;
  case 'NPUP':$a=$a ." mov_detalle.lote_ext ASC ";$xorden="Lote de Extracci&oacute; Ascendente";break;
  case 'NPDN':$a=$a ." mov_detalle.lote_ext DESC";$xorden="Lote de Extracci&oacute; Descendente";break;
  case 'ACUP':$a=$a ." mov_detalle.cosecha ASC ";$xorden="A&ntilde;o de Cosecha Ascendente";break;
  case 'ACDN':$a=$a ." mov_detalle.cosecha DESC";$xorden="A&ntilde;o de Cosecha Descendente";break;
  case 'LOUP':$a=$a ." mov_detalle.lote_id ASC ";$xorden="Tambor Ascendente";break;
  case 'LODN':$a=$a ." mov_detalle.lote_id DESC";$xorden="Tambor Descendente";break;
  case 'SUUP':$a=$a ." mov_cabecera.fecha_vto ASC ";$xorden="Fecha de Vencimiento Ascendente";break;
  case 'SUDN':$a=$a ." mov_cabecera.fecha_vto DESC";$xorden="Fecha de Vencimiento Descendente";break;
  case 'AIUP':$a=$a ." mov_det_anal.analisis_id ASC ";$xorden="An&aacute;lisis ID Ascendente";break;
  case 'AIDN':$a=$a ." mov_det_anal.analisis_id DESC";$xorden="An&aacute;lisis ID Descendente";break;
  case 'NRUP':$a=$a ." mov_detalle.tipo_campo ASC ";$xorden="Tipo de Flora Ascendente";break;
  case 'NRDN':$a=$a ." mov_detalle.tipo_campo DESC";$xorden="Tipo de Flora Descendente";break;
  case 'CIUP':$a=$a ." env_secundario.nombre ASC ";$xorden="Envase Secundario Ascendente";break;
  case 'CIDN':$a=$a ." env_secundario.nombre DESC";$xorden="Envase Secundario Descendente";break;
  case 'CAUP':$a=$a ." mov_detalle.lote_env_sec ASC ";$xorden="Lote del Envase Secundario Ascendente";break;
  case 'CADN':$a=$a ." mov_detalle.lote_env_sec DESC";$xorden="Lote del Envase Secundario Descendente";break;
  case 'PRUP':$a=$a ." provedores.abrev ASC ";$xorden="Provedor Ascendente";break;
  case 'PRDN':$a=$a ." provedores.abrev DESC";$xorden="Provedor Descendente";break;
  default: $a=$a ." mov_detalle.nro_mov ASC";$xorden="Nro. de Mov.Ascendente"; break;
  }
}

$r = mysql_query($a,$cx_validar);
$k=0;$pag1=1;$y=15;
$pdf->SetFont('Arial','',7);
while ($v = mysql_fetch_array($r)) {
  // el $v[8] tacho 
  $l=strlen($quees);
  if ($l>0){
    $si=0;
    $aq='SELECT valor1 FROM '.$_SESSION["tabla_respuesta"]." where login='".$_SESSION["acceso_logg"]."' and respuesta='stk' and valor1=".$v[2]   ; 
    $rq = mysql_query($aq,$cx_validar);while ($vq = mysql_fetch_array($rq)) {$si++;}
  }
  if ( ($l==0) or (($l>0) and ($si>0)) ){
  $y=$y+5;
  $pdf->setXY(1,$y);
  
  $pdf->Cell(40,5,$v[0],LRTB,0,'L');
  $pdf->Cell(10,5,$v[1],LRTB,0,'R');
  $pdf->Cell(15,5,$v[2],LRTB,0,'R');
  $pdf->Cell(12,5,$v[3],LRTB,0,'R');
  $pdf->Cell(80,5,$v[4],LRTB,0,'L');
  $f=substr($v[5],5,3).substr($v[5],0,4);
  $pdf->Cell(14,5,$f,LRTB,0,'C');
  $pdf->Cell(25,5,$v[6],LRTB,0,'L');
  $pdf->Cell(12,5,$v[7],LRTB,0,'C');
  $k++;
  if ($k>50){
    $y=$y+15;$pdf->setXY(1,$y);  $pdf->Cell(2,1,' ',LRTB,0,'L');
    $y=15;$k=0;$pag1++;
  }
  }
}
$pdf->Output();
//header("Location: stock1.php");
//header("Location: dcontrol1.php?nro_presupuesto=$nro_presupuesto&ID=A$nro_presupuesto");
?>

