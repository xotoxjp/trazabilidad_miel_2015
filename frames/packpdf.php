<?session_start();
include_once("funciones.php");
require_once('fpdf/fpdf.php');
$meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul","Ago", "Sep", "Oct", "Nov", "Dic");
//define('FPDF_FONTPATH','fpdf/font/');
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=14 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
$vagrilla='Si';
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }
else { 
  $last_ing = date("Y-m-d H:i:s"); ;
  $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
  mysql_select_db($_SESSION["base_acc"]);
  $a1='select login,respuesta,marca1,marca2,valor1  from '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="emb"';
  $r1=mysql_query($a1,$cx_validar);$i=0;
  while ($v1 = mysql_fetch_array($r1)) {$i++;$marca1=$v1[2];$nro_emb=$v1[3];$valor1=$v1[4];break;}
  $a1='select * from '.$_SESSION["tabla_mov_embarque"].' where nro_emb="'.$nro_emb.'"';
  $r1=mysql_query($a1,$cx_validar);$i=0;

  while ($v1 = mysql_fetch_array($r1)) {
    $nro_preemb=$v1[0];
    $pais_id=$v1[2];
    $cliente_id=$v1[3];
    $expotador_id=$v1[4];
    $exportador=$v1[5];
    $despachante_id=$v1[6];
    $transporte=$v1[7];
    $aduana_id=$v1[8];
    $paso_id=$v1[9];
    $fecha_emb=$v1[10];
    $hora_emb=$v1[11];
    $almac_id_ori=$v1[12];
    $donde_esta=$v1[13];
    $aut_senasa=$v1[14];
    $contenedor=$v1[15];
    $precinto_ad=$v1[16];
    $contrato=$v1[17];
    $color=$v1[18];
    $hab_senasa=$v1[19];
    $marca=$v1[20];
    $precio_fob=$v1[21];
    $fecha_ana=$v1[22];
    $lugar_ana=$v1[23];
    $dire_veri=$v1[24];
    $mu_nitro_xcon=$v1[25];
    $fecha_soli=$v1[26];
    break;}


  $a='SELECT DISTINCT mov_detalle.lote_id,provedores.c1,almacenes.hab_senasa,mov_cabecera.lote_ext,mov_detalle.bruto,mov_detalle.tara ';
  $a=$a.' FROM mov_detalle ';
  $a=$a.' INNER JOIN mov_cabecera on mov_cabecera.nro_mov=mov_detalle.nro_mov';
  $a=$a.' INNER JOIN provedores on provedores.prov_id=mov_detalle.prov_id';
  $a=$a.' INNER JOIN almacenes on almacenes.abrev=mov_detalle.sala_ext';
  $a=$a.' where mov_detalle.nro_mov="'.$nro_preemb.'" order by mov_detalle.lote_id ';
  $r = mysql_query($a,$cx_validar);$cant_tambores=0;

  while ($v = mysql_fetch_array($r)) {$cant_tambores++;}
  
  // ahora comienza la generacion del pdf 

  class PDF extends FPDF
  {
  function Footer()
  {
    //Go to 1.5 cm from bottom
    $this->SetY(-15);
    //Select Arial italic 8
    $this->SetFont('Arial','',8);
    //Print current and total page numbers
    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');

  }
  //Tabla simple


  function Header()
  {
    global $aut_senasa,$contenedor,$precinto_ad,$contrato,$color,$vagrilla,$cant_tambores;
    global $title;
    $this->Image('fotos/logogsb.jpg',60,0,80);
    $this->SetFont('Arial','',8);
    $this->setxy(60,15);
    $title="Colectora Panamericana Este Km 27.333";
    $this->Cell(80,5,$title,0,0,'C');
    $this->setxy(60,18);
    $title="B1611GEM - Don Torcuato - Buenos Aires - Argentina";
    $this->Cell(80,5,$title,0,0,'C');
    $this->setxy(60,21);
    $title="Teléfono +54(11) 4846-7020 - Email:export@gsb.com.ar";
    $this->Cell(80,5,$title,0,0,'C');
    $this->SetFont('Arial','B',11);

    $title='PACKING LIST';
    $this->SetXY(60,26);
    $this->Cell(80,5,$title,0,0,'C');
    $this->SetFont('Arial','',8);

    $this->setxy(60,31);$t='Autorización SENASA N°:'.$aut_senasa;
    $this->Cell(80,5,$t,0,0,'C');

    $this->setxy(60,35);$t='Contenedor N°:'.$contenedor;
    $this->Cell(80,5,$t,0,0,'C');

    $this->setxy(60,39);$t='Precintos Aduana N°:'.$precinto_ad;
    $this->Cell(80,5,$t,0,0,'C');

    $this->setxy(60,43);$t='Contrato N°:'.$contrato;
    $this->Cell(80,5,$t,0,0,'C');

//    $this->setxy(60,47);$t='Color:'.$color;
//    $this->Cell(80,5,$t,0,0,'C');

    $this->SetFont('Arial','B',8);
    if(($vagrilla=='Si') and ($cant_tambores>0)){
      $this->setxy(35,52);
      $title="N° TAMBOR";
      $this->Cell(20,5,$title,1,0,'C');
      $title="RENAPA";
      $this->Cell(20,5,$title,1,0,'C');
      $title="SALA";
      $this->Cell(20,5,$title,1,0,'C');
      $title="LOTE";
      $this->Cell(20,5,$title,1,0,'C');
      $title="BRUTO (Kg)";
      $this->Cell(20,5,$title,1,0,'C');
      $title="TARA (Kg)";
      $this->Cell(20,5,$title,1,0,'C');
      $title="NETO (Kg)";
      $this->Cell(20,5,$title,1,0,'C');
    }
    $this->SetFont('Arial','',8);
  }
  }

  $meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul","Ago", "Sep", "Oct", "Nov", "Dic");

  $pdf=new PDF('P','mm','Legal');
  $pdf->AliasNbPages();
  $pdf->SetTitle($title);
  $pdf->SetFont('Arial','',8);
  $pdf->AddPage();
  $x=52;$cantt=$cant_tambores;
  $r = mysql_query($a,$cx_validar);
  $vuelta=0;$TotKB=0;$TotKT=0;$TotKN=0;
  
  while ($v = mysql_fetch_array($r)) {
    $x=$x+5; 
    $vuelta++;$cant_tambores--;
    $pdf->setxy(35,$x);
    $pdf->Cell(20,5,$v[0],1,0,'C');
    $pdf->Cell(20,5,$v[1],1,0,'C');
    $pdf->Cell(20,5,$v[2],1,0,'C');
    $pdf->Cell(20,5,$v[3],1,0,'C');
    $pdf->Cell(20,5,$v[4],1,0,'C');
    $pdf->Cell(20,5,$v[5],1,0,'C');$t=$v[4]-$v[5];
    $pdf->Cell(20,5,$t,1,0,'C');
    $TotKB=$TotKB + $v[4];
    $TotKT=$TotKT + $v[5];
    $TotKN=$TotKN + $t;
    if ($vuelta>=43){
      $vuelta=0;$x=52;
      if ($cant_tambores<=0){
        $vagrilla='No';
      }
      $pdf->AddPage();
    }
  }
  $pdf->SetFont('Arial','B',8);
  if ($vuelta+9>42){ $pdf->AddPage();$x=60;}
  $x=$x+10; 
  $pdf->setxy(35,$x);
  $pdf->Cell(70,5,'TOTAL TAMBORES',1,0,'C');
  $pdf->Cell(70,5,$cantt,1,0,'C');
  $x=$x+5; 
  $pdf->setxy(35,$x);
  $pdf->Cell(70,5,'TOTAL PESO BRUTO(Kg)',1,0,'C');
  $pdf->Cell(70,5,$TotKB,1,0,'C');
  $x=$x+5; 
  $pdf->setxy(35,$x);
  $pdf->Cell(70,5,'TARA(Kg)',1,0,'C');
  $pdf->Cell(70,5,$TotKT,1,0,'C');
  $x=$x+5; 
  $pdf->setxy(35,$x);
  $pdf->Cell(70,5,'TOTAL PESO NETO(Kg)',1,0,'C');
  $pdf->Cell(70,5,$TotKN,1,0,'C');
  
  $pdf->SetFont('Courier','',8);
  $x=$x+18; 
  $pdf->setxy(110,$x);
  $pdf->Cell(60,5,'..................................',0,0,'C');
  $x=$x+8;
  $pdf->setxy(110,$x);
  $pdf->Cell(60,5,'     Firma Grúas San Blas S.A.    ',0,0,'C');

  $pdf->Output();


}
?>
</BODY>
</HTML>




