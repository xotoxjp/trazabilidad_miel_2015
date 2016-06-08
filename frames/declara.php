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


  $a='SELECT tipo_almacen FROM '.$_SESSION["tabla_almacenes"].' where almacen_id='.$lugar_ana;
  $r = mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {$tipo_almacen=$v[0];break;}

  $a='SELECT mov_detalle.lote_id,provedores.c1,almacenes.hab_senasa,mov_cabecera.lote_ext,mov_detalle.bruto,mov_detalle.tara ';
  $a=$a.' FROM mov_detalle ';
  $a=$a.' INNER JOIN mov_cabecera on mov_cabecera.nro_mov=mov_detalle.nro_mov';
  $a=$a.' INNER JOIN provedores on provedores.prov_id=mov_cabecera.prov_id';
  $a=$a.' INNER JOIN almacenes on almacenes.abrev=mov_cabecera.sala_ext';
  $a=$a.' where mov_detalle.nro_mov="'.$nro_preemb.'" order by mov_detalle.lote_id ';
  $r = mysql_query($a,$cx_validar);$cant_tambores=0;
  while ($v = mysql_fetch_array($r)) {$cant_tambores++;}
  $solicita=strtoupper(trim($_SESSION["acceso_nombre"])).' '.strtoupper(trim($_SESSION["acceso_apellido"]));
  
  // ahora comienza la generacion del pdf 

  class PDF extends FPDF
  {
  function Footer()
  {
    // //Go to 1.5 cm from bottom
    // $this->SetY(-15);
    // //Select Arial italic 8
    // $this->SetFont('Arial','',8);
    // //Print current and total page numbers
    // $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');

  }
  //Tabla simple


  function Header()
  {
    global $aut_senasa,$contenedor,$precinto_ad,$contrato,$color,$vagrilla,$cant_tambores,$solicita,$donde_esta,$fecha_soli,$aut_senasa;
    global $title;
    $meses = array("ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO","AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");

    $this->Image('fotos/LOG_DEJU.JPG',30,10,60);
    
    $this->SetFont('Times','B',12);
    $this->setxy(23,38);
    $t='DECLARACION JURADA DE MIEL A GRANEL SIN PROCESAR';
    $this->Cell(169,5,$t,0,0,'C');

    $this->SetFont('Arial','',11);
    $t='El que suscribe, propietario, responsable físico ó jurídico de la miel que consta en la Solicitud de';
    $this->setxy(23,48);
    $this->Cell(169,7,$t,0,1,'C');

    $this->setx(23);
    $l=$fecha_soli;
    $d=0+substr($l,-2);$m=0+substr($l,5,2);
    $t1=$d.' DE '.$meses[$m].' DE '.substr($l,0,4);
    $t='Autorización de Exportación N° _____________, de fecha__________________,';
    $this->Cell(169,7,$t,0,1,'L');
    
    $this->setx(23);
    $t='acompañada junto a la Declaración Jurada de Miel a Granel, presentada ante la Coordinación de';
    $this->Cell(169,7,$t,0,1,'L');

    $this->setx(23);
    $t='Lácteos y Apicolas,';
    $this->Cell(35,7,$t,0,0,'L');
    
    $this->SetFont('Arial','',12);
    $t='DECLARA BAJO JURAMENTO QUE LA MIEL ES DE PRODUCCION';
    $this->Cell(137,7,$t,0,1,'L');

    $this->setx(23);
    $t='PRIMARIA Y NO HA  SIDO  SOMETIDA A  NINGUN  TIPO  DE TRANSFORMACION,';
    $this->Cell(164,7,$t,0,0,'L');

    $this->SetFont('Arial','',11);
    $t='y';
    $this->Cell(10,7,$t,0,1,'L');

    $this->setx(23);
    $t='conserva los mismos envases e identificaciones que le fueron colocados durante su extracción en';
    $this->Cell(169,7,$t,0,1,'L');
    $this->setx(23);
    $t='la Sala de Extracción. Concuerda a su vez con el ANEXO IV(1)(2) de la Resolución N° 186/2003';
    $this->Cell(169,7,$t,0,1,'L');
    $this->setx(23);
    $t='que se encuentra archivada en el establecimiento donde se encuentran depositados los tambores.';
    $this->Cell(169,7,$t,0,1,'L');
    $this->setx(23);
    $t='La presente se encuentra sujeta al artículo 293 del Código Penal.---------------------------------';
    $this->Cell(169,7,$t,0,1,'L');


    $this->setxy(23,120);
    $l=date("Y-m-d");
    $d=0+substr($l,-2);$m=0+substr($l,5,2);
    $t1=$d.' de '.$meses[$m].' de '.substr($l,0,4);
    $t='BUENOS AIRES,'.$t1;
    $this->Cell(169,7,$t,0,1,'L');
    $this->setx(48);
    $t='(lugar y fecha)';
    $this->Cell(50,7,$t,0,1,'L');

    $this->setxy(105,140);
    $t='.............................................................';
    $this->Cell(60,7,$t,0,1,'L');
    $this->setxy(105,145);
    $t='Firma y sello de Gruas San Blas S.A.';
    $this->Cell(60,7,$t,0,1,'L');
    $this->setxy(23,155);
    $t='___________________________________________________________________________';
    $this->Cell(169,7,$t,0,1,'L');

    $this->setxy(23,165);
    $t='El abajo firmante, funcionario del SENASA deja constancia que el responsable de la miel posee la';
    $this->setx(23);
    $this->Cell(169,7,$t,0,1,'L');
    $t='cocumentación en regla y la identificación de los tambores concuerdan con la Declaración Jurada';
    $this->setx(23);
    $this->Cell(169,7,$t,0,1,'L');
    $t='procedente y con el ANEXO  ';
    if ($tipo_almacen==1){$t=$t.'II';} else {$t=$t.'IV';}
    $t=$t.'  (1)(2) de la Resolución N°186/2003.-------------------------------';
    $this->setx(23);
    $this->Cell(169,7,$t,0,1,'L');

    $this->setxy(23,190);
    $t='. . . . . . . . . . . . . . . . . . . . , . . . de . . . . . . . . . . . . . . de 20 . . . . . . . .';
    $this->Cell(169,7,$t,0,1,'L');
    $this->setx(48);
    $t='(lugar y fecha)';
    $this->Cell(50,7,$t,0,1,'L');

    $this->setxy(105,215);
    $t='.............................................................';
    $this->Cell(60,7,$t,0,1,'L');
    $this->setxy(105,222);
    $t='Firma y sello agente del SENASA';
    $this->Cell(60,7,$t,0,1,'L');

    $this->setxy(23,232);
    $t='Referencias:';
    $this->Cell(60,5,$t,0,1,'L');
    $this->setx(28);
    $t='(1) Si la miel se encuentra en depósito va: ANEXO IV';
    $this->Cell(60,5,$t,0,1,'L');
    $this->setx(28);
    $t='(2) Si la miel se encuentra en Sala de Extracción va: ANEXO II';
    $this->Cell(60,5,$t,0,1,'L');

    $this->setxy(23,250);
    $t='VERSION-2008';
    $this->Cell(60,5,$t,0,1,'L');



  }
  }

  $meses = array("Enero", "Febrero", "Marzo", "Abri", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

  $pdf=new PDF('P','mm','Legal');
  $pdf->AliasNbPages();
  $pdf->SetTitle($title);
  $pdf->SetFont('Arial','',8);
  $pdf->AddPage();

  $pdf->Output();


}

?>
</BODY>
</HTML>