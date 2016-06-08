<?session_start();
include_once("funciones.php");
require_once('fpdf/fpdf.php');
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
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
    $tipo_producto=$v1[27];
    $items_unit=$v1[28];
    break;}


  $a='SELECT provedores.c1,mov_cabecera.sala_ext,mov_cabecera.lote_ext,mov_detalle.cosecha,mov_cabecera.nro_factura,mov_cabecera.fecha_fact,';
  $a=$a.'mov_cabecera.tipo_fact,mov_cabecera.nro_remito,mov_cabecera.fecha_rto,provedores.razon_social,count(*) as tachos,sum(bruto),sum(tara) ';
  $a=$a.' FROM mov_detalle ';
  $a=$a.' INNER JOIN mov_cabecera on mov_cabecera.nro_mov=mov_detalle.nro_mov';
  $a=$a.' INNER JOIN provedores on provedores.prov_id=mov_cabecera.prov_id';
  $a=$a.' where mov_detalle.nro_mov_baja="'.$nro_preemb.'" group by 1,2,3,4,5,6,7,8,9 ';
  
  $r = mysql_query($a,$cx_validar);$cant_tambores=0;
  while ($v = mysql_fetch_array($r)) {$cant_tambores++;}
  
  // ahora comienza la generacion del pdf 

  class PDF extends FPDF
  {
  function Footer()
  {
  global $aut_senasa,$contenedor,$precinto_ad,$contrato,$color,$vagrilla,$cant_tambores,$tipo_producto,$items_unit,$meses,$offset;
  global $title;
  $offset=$offset+8;
  $this->SetFont('Courier','',8);
  $this->setxy(110,$offset);
  $this->Cell(60,5,'..................................',0,0,'C');
  $offset=$offset+4;
  $this->setxy(110,$offset);
  $this->Cell(60,5,'  Apoderado GRUAS SAN BLAS S.A.    ',0,0,'C');
  $this->SetFont('Arial','',8);
  $l=date("Y-m-d"); $d=0+substr($l,-2);$m=0+substr($l,5,2);
  $t='BUENOS AIRES '.$d.' DE '.strtoupper($meses[$m]).' DE '.substr($l,0,4);
  $offset=$offset+6;
  $this->setxy(30,$offset);
  $this->Cell(60,5,$t,0,0,'L');
  //Print current and total page numbers
  $t='Hoja '.$this->PageNo().' de '.'/{nb} Corresponde a la Solicitud de Autorizacipon de Exportación N° '.$aut_senasa;
  $offset=$offset+6;
  $this->setxy(30,$offset);
  $this->Cell(100,5,$t,0,0,'L');
  $t='INTERVENCION SENASA al embarque en depósito (firma y sello) . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . ';
  $offset=$offset+6;
  $this->setxy(30,$offset);
  $this->Cell(100,5,$t,0,0,'L');
  $offset=$offset+6;
  $this->setxy(30,$offset);
  $this->Cell(100,5,'Versión:-2-070809',0,0,'L');





  }
  //Tabla simple


  function Header()
  {
    global $aut_senasa,$contenedor,$precinto_ad,$contrato,$color,$vagrilla,$cant_tambores,$tipo_producto,$items_unit;
    global $title;


    $this->SetFont('Times','B',12);
    $this->setxy(165,5);
    $title='"DDJJ"';
    $this->Cell(17,5,$title,1,1,'L');

    $this->Image('fotos/senasa.jpg',43,15,10);
    $this->SetFont('Arial','',10);
    $this->setxy(40,13);
    $title="SECRETARIA DE AGRICULTURA GANADERÍA, PESCA Y";
    $this->Cell(130,5,$title,LTR,0,'C');
    $this->setxy(40,18);
    $title="ALIMENTACIÓN";
    $this->Cell(130,5,$title,LR,0,'C');
    $this->setxy(40,23);
    $title="S E N A S A";
    $this->Cell(130,5,$title,LR,0,'C');
    $this->setxy(40,28);
    $this->SetFont('Arial','B',8);
    $title="SERVICIO NACIONAL DE SANIDAD Y CALIDAD AGROALIMENTARIA";
    $this->Cell(130,5,$title,LR,0,'C');
    $this->setxy(40,31);
    $title="DIRECCION NACIONAL DE FISCALIZACION AGROALIMENTARIA";
    $this->Cell(130,5,$title,LRB,0,'C');



    $this->SetFont('Arial','BU',10);
    $title='DECLARACION JURADA DE CUMPLIMIENTO A LA RESOLUCION SENASA N° 186/2003';
    $this->SetXY(35,40);
    $this->Cell(150,5,$title,0,0,'C');

    $title='DE TRAZABILIDAD PARA TRAMITES DE EXPORTACION';
    $this->SetXY(35,44);
    $this->Cell(150,5,$title,0,0,'C');

    $this->SetFont('Arial','',9);
    $this->setxy(30,48);$t='Documento correspondiente a la SOLICITUD DE AUTORIZACION DE EXPORTACION que se adjunta.';
    $this->Cell(160,5,$t,0,0,'C');

    $this->SetFont('Arial','BU',10);
    $title='"UTILIZAR UNA DECLARACION JURADO POR CONTENEDOR"';
    $this->SetXY(35,52);
    $this->Cell(150,5,$title,0,0,'C');


    $this->SetFont('Courier','',8);
    $this->setxy(30,59);$t='El abajo firmante en carácter de APODERADO de la empresa GRUAS SAN BLAS S.A. DECLARA BAJO';
    $this->Cell(160,5,$t,0,1,'L');
    $this->setx(30);$t='JURAMENTO que los productos a exportar cuyos N° de RENAPA y SALA DE EXTRACCIÓN ( colocar';
    $this->Cell(160,5,$t,0,1,'L');
    $this->setx(30);$t='lote si corresponde y siempre el año de obtención ) se detallan a continuación son reales';
    $this->Cell(160,5,$t,0,1,'L');
    $this->setx(30);$t='y pertenecen a apicultores  titulares a los que se les ha comprado los productos apícolas,';
    $this->Cell(160,5,$t,0,1,'L');
    $this->setx(30);$t='para lo cual contamos con documentos y registros que avalan lo dicho,en cumplimiento de la';
    $this->Cell(160,5,$t,0,1,'L');
    $this->setx(30);$t='Resolución N° 186 de fecha 02 de mayo de 2003 del SENASA. En caso de falsedad de los datos,';
    $this->Cell(160,5,$t,0,1,'L');
    $this->setx(30);$t='o no poder demostrar fehacientemente el origen dela miel, nos hacemos responsables de las';
    $this->Cell(160,5,$t,0,1,'L');
    $this->setx(30);$t='dificultades que puedan surgir a partir de la presente autorización de exportación.';
    $this->Cell(160,5,$t,0,1,'L');
    $this->SetFont('Arial','B',10);
    $this->setx(30);$t='Miel a Exportar: A GRANEL / HOMOGENEIZADA / FRACCIONADA   o   PROPOLEO';
    $this->Cell(160,5,$t,0,1,'L');
    $tipo_producto=trim($tipo_producto); 
    if ($tipo_producto!='A GRANEL')     {$this->setxy(58,99); $t='========';      $this->Cell(20,5,$t,0,1,'');}
    if ($tipo_producto!='HOMOGENEIZADA'){$this->setxy(79,99); $t='==============';$this->Cell(33,5,$t,0,1,'');}
    if ($tipo_producto!='FRACCIONADA')  {$this->setxy(113,99);$t='============';  $this->Cell(30,5,$t,0,1,'');}
    if ($tipo_producto!='PROPOLEO'){$this->setxy(143,99);$t='============='; $this->Cell(35,5,$t,0,1,'');}
    
    $this->SetFont('Arial','',9);
    $this->setxy(30,103);$t='(Tachar o que no corresponda)';
    $this->Cell(160,5,$t,0,1,'C');

    IF ($items_unit!='Tambores'){$this->setxy(85,117); $t='========';      $this->Cell(10,5,$t,0,1,'L');}
    IF ($items_unit!='Frascos') {$this->setxy(100,117); $t='======';      $this->Cell(9,5,$t,0,1,'L');}
    IF ($items_unit!='Kilos')   {$this->setxy(88,122); $t='=====';      $this->Cell(7,5,$t,0,1,'L');}
    IF ($items_unit!='Cajas')   {$this->setxy(98,122); $t='=====';      $this->Cell(7,5,$t,0,1,'L');}
    


    $this->SetFont('Arial','',9);
    if(($vagrilla=='Si') and ($cant_tambores>0)){

      $this->setxy(30,112);
      $title='N°';
      $this->Cell(15,5,$title,LTR,0,'C');
      $title="N° de ";
      $this->Cell(8,5,$title,LT,0,'L');
      $this->SetFont('Arial','B',9);

      $title="Sala de Extracción";
      $this->Cell(32,5,$title,TR,0,'L');
      
      $this->SetFont('Arial','',9);
      $title="Cantidad de";
      $this->Cell(27,5,$title,LTR,0,'C');
      $title="N° de";
      $this->Cell(22,5,$title,LTR,0,'C');
      $title=" ";
      $this->Cell(53,5,$title,LTR,0,'C');

      $this->setxy(30,117);
      $title="RENAPA";
      $this->Cell(15,5,$title,LR,0,'C');

      $title="con N° de ";
      $this->Cell(16,5,$title,L,0,'L');
      $this->SetFont('Arial','B',9);
      $title="Lote";
      $this->Cell(8,5,$title,0,0,'L');
      $this->SetFont('Arial','',9);
      $title="(Resol.N°";
      $this->Cell(16,5,$title,R,0,'L');

      $title="Tambores/frascos";
      $this->Cell(27,5,$title,LR,0,'C');
      $title="Factura y/o";
      $this->Cell(22,5,$title,LR,0,'C');
      $title="Nombre emisor de la factura";
      $this->Cell(53,5,$title,LR,0,'C');
 
      $this->setxy(30,122);
      $title=" ";
      $this->Cell(15,5,$title,LR,0,'C');
      $title="186) y ";
      $this->Cell(10,5,$title,L,0,'L');
      $title="Año";
      $this->SetFont('Arial','B',9);
      $this->Cell(8,5,$title,0,0,'L');
      $this->SetFont('Arial','',9);
      $title=" de obtención";
      $this->Cell(22,5,$title,R,0,'L');



      $this->Cell(27,5,'Kilos/cajas',LR,0,'C');
      $title="Remito";
      $this->Cell(22,5,$title,LR,0,'C');
      $title="que avala la compra de la miel";
      $this->Cell(53,5,$title,LR,0,'C');

      $this->setxy(30,127);
      $title="";
      $this->Cell(15,5,$title,LBR,0,'C');
      $title="de la miel";
      $this->Cell(40,5,$title,LBR,0,'C');
      $title=" ";
      $this->Cell(27,5,$title,LBR,0,'C');
      $title="";
      $this->Cell(22,5,$title,LBR,0,'C');
      $title=" ";
      $this->Cell(53,5,$title,LBR,0,'C');
 
    }
    $this->SetFont('Arial','',8);
  }
  }


  $pdf=new PDF('P','mm','Legal');
  $pdf->AliasNbPages();
  $pdf->SetTitle($title);
  $pdf->SetFont('Arial','',8);
  $pdf->AddPage();
  $x=127;$cantt=$cant_tambores;
  $r = mysql_query($a,$cx_validar);
  $vuelta=0;$TotKB=0;$TotKT=0;$TotKN=0;$TotCN=0;
  while ($v = mysql_fetch_array($r)) {
    $x=$x+5; 
    $vuelta++;$cant_tambores--;
    $pdf->SetFont('Arial','',9);
    $pdf->setxy(30,$x);
    $pdf->Cell(15,9,$v[0],1,0,'C');
    $pdf->Cell(40,5,'SEF '.$v[1].' - LOTE N° '.$v[2],LTR,0,'L');
    $pdf->setxy(30+15,$x+5);
    $pdf->Cell(40,4,'- AÑO '.$v[3].'.',LBR,0,'C');
    $pdf->setxy(30+55,$x);
    $pdf->Cell(27,9,$v[10],1,0,'C');
    if (strlen(trim($v[4]))>8) {
      $pdf->Cell(22,5,$v[6].substr($v[4],0,5),LTR,0,'C');
      $pdf->setxy(30+82,$x+5);
      $pdf->Cell(22,4,substr($v[4],-8),LBR,0,'C');
    }
    else {
      $pdf->Cell(22,9,$v[7],1,0,'C');
    }
    $pdf->setxy(30+82+22,$x);
    $pdf->Cell(53,9,$v[9],1,0,'C');
    $TotCN =$TotCN+$v[10];
    $TotKB=$TotKB + $v[11];
    $TotKT=$TotKT + $v[12];
    $TotKN=$TotKN + $v[11]-$v[12];
    if ($vuelta>=43){
      $vuelta=0;$x=52;
      if ($cant_tambores<=0){
        $vagrilla='No';
      }
      $pdf->AddPage();
    }
  }
  $pdf->SetFont('Arial','B',8);
  if ($vuelta+9>42){ $pdf->AddPage();$x=127;}
  $x=$x+10; 
  $pdf->setxy(90,$x);

  switch ($items_unit) {
    case 'Tambores': $t=$TotCN; break;
    case 'Frascos': $t=$TotCN ; break;
    case 'Kilos': $TotKN; break;
    case 'Cajas': $t=$TotCN;break;
  }
  $t='TOTAL '.$t.' '.strtoupper($items_unit);
  $pdf->Cell(40,5,$t,0,0,'L');
  $x=$x+4; 
  $pdf->SetFont('Arial','',8);$pdf->setxy(30,$x);
  $pdf->Cell(120,5,'El presente documento tiene carácter de DECLARACION JURADA',0,0,'L');
  $offset=$x;

  $pdf->Output();


}
?>
</BODY>
</HTML>




