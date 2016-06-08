<?session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=8 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }
$Nmes[]='Ene';$Nmes[]='Feb';$Nmes[]='Mar';$Nmes[]='Abr';$Nmes[]='May';$Nmes[]='Jun';
$Nmes[]='Jul';$Nmes[]='Ago';$Nmes[]='Sep';$Nmes[]='Oct';$Nmes[]='Nov';$Nmes[]='Dic';
foreach ($_GET as $indice => $valor) {
 // echo $indice.".".$valor.'<br>';
  switch ($indice) {
    case 'lote_ext': $lote_ext=$valor ; break;
    case 'lote_id': $lote_id=$valor ; break;
  }
}

$l=date("Y-m-d");
$al='UPDATE '.$_SESSION["tabla_mov_detalle"].' set etiqueta="'.$l.'" where lote_id='.$lote_id.' and lote_ext='.$lote_ext.' and nro_mov_baja="             "';
mysql_query($al,$cx_validar); 


$al='SELECT  cosecha,tapa,precinto,bruto,tara,nro_mov FROM '.$_SESSION["tabla_mov_detalle"].' where lote_id='.$lote_id.' and lote_ext='.$lote_ext.' and nro_mov_baja="             "';
$rl=mysql_query($al,$cx_validar);$i=0;
while ($vl = mysql_fetch_array($rl)) {$i++;
  $cosecha=$vl[0];
  $tapa=$vl[1];
  $precinto=$vl[2];
  $bruto=$vl[3];
  $tara=$vl[4];
  $neto=$bruto-$tara;
  $nro_mov=$vl[5];
}
if ($i<1){header("Location: reproceso1.php"); echo '1';}
$al='SELECT  fecha_vto,sala_ext,prov_id FROM '.$_SESSION["tabla_mov_cabecera"].' where nro_mov="'.$nro_mov.'"';
$rl=mysql_query($al,$cx_validar);$i=0;
while ($vl = mysql_fetch_array($rl)) {$i++;
  $fecha_vto=$vl[0];
  $sala_ext=$vl[1];
  $prov_id=$vl[2];
}  
if ($i<1){header("Location: reproceso1.php"); echo '1';}
$al='SELECT c1 FROM '.$_SESSION["tabla_provedores"].' where prov_id="'.$prov_id.'"';
$rl=mysql_query($al,$cx_validar);$i=0;
while ($vl = mysql_fetch_array($rl)) {$i++;
  $renapa=$vl[0];
}  
if ($i<1){header("Location: reproceso1.php"); echo '1';}

define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/i25.php');
$pdf = new PDF_i25('P', 'mm', array(200,145));
$t='00000000'.$lote_id;
$pdf->AddPage();
$pdf->i25(160,10,$t);
$pdf->i25(130,110,$t);

//$pdf->Image('fotos/gsbl.jpg',10,12,30,0,'','fotos/gsbl.jpg');
$pdf->Image('fotos/gsbl.jpg',1,2,50,0,'','');

$t='Colectora Este km 2703333 - B1611GEM - Don Torcuato - Bs.As. Argentina';
$pdf->SetXY(1,15);$pdf->Cell(1,0,$t);
$pdf->SetFont('Arial','B',16);
$t='RENAPA';
$pdf->SetXY(10,35);$pdf->Cell(1,0,$t);
$t='EXTRACTION ROOM';
$pdf->SetXY(54,33);$pdf->Cell(1,0,$t);
$t='EXPIRY DATA';
$pdf->SetXY(120,33);$pdf->Cell(1,0,$t);
$t='COSECHA';
$pdf->SetXY(170,33);$pdf->Cell(1,0,$t);


$pdf->SetXY(1,40);$pdf->Cell(44,10,$renapa,1,0,'C');
$pdf->SetXY(61,40);$pdf->Cell(44,10,$sala_ext,1,0,'C');
$t=substr($fecha_vto,5,2).'/'.substr($fecha_vto,0,4);
$pdf->SetXY(126,40);$pdf->Cell(25,10,$t,1,0,'C');
$pdf->SetXY(176,40);$pdf->Cell(17,10,$cosecha,1,0,'C');


$t='LOTE Nro.';
$pdf->SetXY(8,65);$pdf->Cell(1,0,$t);
$t='GROSS WEIGHT';
$pdf->SetXY(59,65);$pdf->Cell(1,0,$t);
$t='WEIGHT';
$pdf->SetXY(125,65);$pdf->Cell(1,0,$t);
$t='TARE';
$pdf->SetXY(175,65);$pdf->Cell(1,0,$t);


$pdf->SetXY(1,70);$pdf->Cell(44,10,$lote_ext,1,0,'C');
$t=intval($bruto);
$pdf->SetXY(61,70);$pdf->Cell(44,10,$t,1,0,'C');
$t=intval($bruto - $tara);
$pdf->SetXY(126,70);$pdf->Cell(25,10,$t,1,0,'C');
$t=intval($tara);
$pdf->SetXY(176,70);$pdf->Cell(17,10,$t,1,0,'C');

$t='TAMBOR';
$pdf->SetXY(40,88);$pdf->Cell(1,0,$t);
$pdf->SetFont('Arial','',14);
$t='TAPA';
$pdf->SetXY(125,85);$pdf->Cell(1,0,$t);
$t='PRECINTO';
$pdf->SetXY(162,85);$pdf->Cell(1,0,$t);

$pdf->SetFont('Arial','B',88);

$pdf->SetXY(1,84);$pdf->Cell(110,40,$lote_id,1,0,'C');
$pdf->SetFont('Arial','',14);

$pdf->SetXY(113,88);$pdf->Cell(40,10,$tapa,1,0,'C');
$pdf->SetXY(156,88);$pdf->Cell(40,10,$precinto,1,0,'C');

$pdf->Output();
//$pdf->Output('LPT1:',F);
// $pdf->Output('IP_10.0.0.109',F);
$pdf->Close;
?>