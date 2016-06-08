<?php
session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];

$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=2 and acceso="on"';
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
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='colmenas1.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);
$prov_id=0;$campo_id=0;
$prov_id=$_REQUEST["prov_id"];
$campo_id=$_REQUEST["campo_id"];

if ($campo_id>0) {$_SESSION["filtro_campo_id"]=$campo_id;}
if ($prov_id>0) {$_SESSION["filtro_prov_id"]=$prov_id;}

if (($prov_id>0) and ($campo_id>0)){
  $actualizar="select count(*) as ss from  ".$_SESSION["tabla_colmenas"].' where prov_id='.$prov_id.' and campo_id='.$campo_id;
  $rs_validar = mysql_query($actualizar,$cx_validar);
  while ($v_validar = mysql_fetch_array($rs_validar)) { $p=0+$v_validar[0];}
  if ($p==0) {
    { // no tiene ninguna colmena este campo de este provedor agrego una y voy a editarlo
     $act="select max(colmena_id) from  ".$_SESSION["tabla_colmenas"];
    $rs_validar = mysql_query($act,$cx_validar);
    while ($v_validar = mysql_fetch_array($rs_validar)) { $colmena_id=1 + $v_validar[0];}
    $f=date("Y-m-d");
    $act="INSERT INTO ".$_SESSION["tabla_colmenas"]." (`campo_id`,`prov_id`, `colmena_id`, `tipo_colmena`, `fecha_alta`,";
    $act=$act." `tipo_abeja`, `estado`, `f_ult_visita`, `pers_id`, `cam_col_id`, `op` ) VALUES (".$campo_id.",".$prov_id.",";
    $act=$act. $colmena_id .",'Colmena','".$f."','".$tipo_abeja."','Bueno','".$f."',10,' ', 'enk' )";
    $rs_validar = mysql_query($act,$cx_validar);
    act_col_cam($prov_id,$campo_id);
    
    $a='A'.$campo_id.'-'.$prov_id.'/'.$colmena_id;
    header("Location: mod_colmenas1.php?&ID=$a") ;echo '1';}
  }
}





$sub=".";
$orden=$_REQUEST["orden"];

foreach ($_POST as $indice => $valor)
  {
 // echo "$indice: $valor<br>";
   switch ($indice) {
    case 'prov_id': $prov_id=$valor; break;
    case 'campo_id': $campo_id=$valor; break;
    case 'abrev': $abrev=$valor; break;
    case 'cam_col_id': $cam_col_id=$valor; break;
    case 'colmena_id': $colmena_id=$valor; break;
    case 'tipo_colmena': $tipo_colmena=$valor; break;
    case 'tipo_abeja': $tipo_abeja=$valor; break;
    case 'fecha_alta': $fecha_alta=$valor; break;
    case 'estado': $estado=$valor; break;
    case 'filtro': $filtro=$valor; break;
    case 'f_ult_visita': $f_ult_visita=$valor; break;
    case 'nro_ult_mov': $nro_ult_mov=$valor; break;
    case 'pers_id': $pers_id=$valor; break;
    case 'campo': $campo=$valor ; break;
  	case 'orden': $orden=$valor ; break;
	  case 'filtro': $filtro=$valor; break;
	  case 'Submit': $sub=$valor; break;
  }
  }

if ($filtro !='   ')
{ $filtro = strtoupper($filtro);
  IF ( $campo == 'abrev' )   {$_SESSION["filtro_abrev"]=$filtro; if (strlen($filtro)==0) {$campo_id=0;}}
  IF ( $campo == 'razon_social'){$_SESSION["filtro_nombre"]=$filtro; }
  IF ( $campo == 'estado'){$_SESSION["filtro_estado"]=$filtro; }
  IF ( $campo == 'colmena_id' )  {$_SESSION["filtro_colmena_id"]=$filtro; }
  IF ( $campo == 'tipo_colmena' )  {$_SESSION["filtro_tipo_colmena"]=$filtro; }
  IF ( $campo == 'fecha_alta' )  {$_SESSION["filtro_fecha_alta"]=$filtro; }
  IF ( $campo == 'tipo_abeja' )       {$_SESSION["filtro_tipo_abeja"]=$filtro; }
  IF ( $campo == 'op' )   {$_SESSION["filtro_contacto"]=$filtro; }
  IF ( $campo == 'estado' )   {$_SESSION["filtro_estado"]=$filtro; }
  IF ( $campo == 'prov_id' )    {$_SESSION["filtro_prov_id"]=$filtro; if (strlen($filtro)==0) {$prov_id=0;}}
  IF ( $campo == 'provedor' )   {$_SESSION["filtro_provedor"]=$filtro; }
  IF ( $campo == 'f_ult_visita' )    {$_SESSION["filtro_f_ult_visita"]=$filtro; }
  IF ( $campo == 'pers_id' )   {$_SESSION["filtro_pers_id"]=$filtro; }
  IF ( $campo == 'cam_col_id' )   {$_SESSION["filtro_cam_col_id"]=$filtro; }
}
$Limite="";
?>
<head>
<TITLE>COLMENAS</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
#ent {display: none;}
</style>

<script type="text/javascript">
<!--
function ini(colu) {
 tx=document.getElementById('Eleccion');
  btn=document.getElementById('ent');
  tab=document.getElementById('tabla');
  j=0;
  z=0;
  k=0;
  for (i=66; ele=tab.getElementsByTagName('td')[i]; i++) {
    ele.onclick = function() {seteo(this,i,colu,tx );  }
    ele.onmouseover = function() {iluminar(this,true)}
    if (k==0) ele.onmouseout = function() {iluminari(this);}
    if (k==1) ele.onmouseout = function() {iluminarp(this);}
    j++;
    if (j==colu){
      j=0;
      if (k!=1) {k++;}
      else {k=0;}
    }
  }
}

function ilumi(obj,valor) {obj.style.background = (valor) ? 'yellow' : '';}

function seteo(obj,valor,i1,fo) { fila = obj.parentNode;
  for (i=0; ele = fila.getElementsByTagName('td')[i]; i++)
    {
     fo.value=ele.id;
     btn.click();
    }
}
function iluminar(obj,valor) { fila = obj.parentNode;
  for (i=0; ele = fila.getElementsByTagName('td')[i]; i++)
      ele.style.background = 'yellow' }
function iluminarp(obj) { fila = obj.parentNode;
    for (i=0; ele = fila.getElementsByTagName('td')[i]; i++)
      ele.style.background = 'LightSteelBlue' ;}
function iluminari(obj) {  fila = obj.parentNode;
    for (i=0; ele = fila.getElementsByTagName('td')[i]; i++)
      ele.style.background = 'LightCyan' ;}
function poner1(colu){
  k1=colu; j1=0;fi=0;
  tab=document.getElementById('tabla');
  for (i1=66; ele1=tab.getElementsByTagName('td')[i1]; i1=i1+k1) {
    fi = fi + 1
    if (fi==2) {fi=0;}
    switch(fi) {
    case 0:
      iluminarp(ele1);
       break;
    case 1:
      iluminari(ele1);
      break;
    default:
      break;
    }
  }
}
function nueva_nota(elemento)
 {tx=document.getElementById('Eleccion');
  tx.value="A1";
  btn=document.getElementById('ent');
  btn.click();}

function nueva_notx(elemento)
 {tx=document.getElementById('Eleccion');
  tx.value="XX";
  btn=document.getElementById('ent');
  btn.click();}


-->
</script>


</head>

<?
echo "<body onload='ini(13); poner1(13);'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='mod_colmenas1.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
if ($prov_id>0){
$actualizar="select razon_social from  ".$_SESSION["tabla_provedores"].' where prov_id='.$prov_id;
$rs_validar = mysql_query($actualizar,$cx_validar);$provedor_nam='';
while ($v_validar = mysql_fetch_array($rs_validar)) { $provedor_nam=$v_validar[0];}
}


$a="select colmenas.campo_id ,campos.razon_social,colmenas.colmena_id,colmenas.tipo_colmena,colmenas.fecha_alta,colmenas.tipo_abeja,";
$a=$a.'colmenas.estado,colmenas.f_ult_visita,colmenas.op,colmenas.prov_id,provedores.razon_social,colmenas.cam_col_id,colmenas.fec_ult_ext,campos.abrev from  ';
$a=$a.$_SESSION["tabla_colmenas"].' inner join ' .$_SESSION["tabla_provedores"].' on colmenas.prov_id=provedores.prov_id ';
$a=$a.' inner join ' .$_SESSION["tabla_campos"].' on colmenas.campo_id=campos.campo_id ';
if ($orden == ".")
  {  }
else {
  $a=$a .' ORDER BY';
  switch ($orden) {
  case 'IDUP':{$a=$a ."  campos.abrev  ";$xorden="Campo ID Ascendente"; break;}
  case 'IDDN':{ $a=$a ."  campos.abrev  DESC";$xorden="Campo ID Descendente";break;}
	case 'RSUP':{$a=$a ." campos.razon_social ";$xorden="Raz&oacute;n Social del Campo Ascendente";break;}
	case 'RSDN':{ $a=$a ." campos.razon_social DESC";$xorden="Raz&oacute;n Social del Campo Descendente";break;}
	case 'CIUP':{$a=$a ."  colmenas.colmena_id  ";$xorden="Colmena ID Ascendente";break;}
	case 'CIDN':{ $a=$a ."  colmenas.colmena_id  DESC";$xorden="Colmena ID Descendente";break;}
	case 'TCUP':{$a=$a ." colmenas.tipo_colmena ";$xorden="Tipo de Colmena Ascendente";break;}
	case 'TCDN':{ $a=$a ." colmenas.tipo_colmena DESC";$xorden="Tipo de Colmena Descendente";break;}
  case 'FAUP':{$a=$a ." colmenas.fecha_alta ";$xorden="Fecha de Alta Ascendente";break;}
  case 'FADN':{ $a=$a ." colmenas.fecha_alta DESC";$xorden="Fecha de Alta Descendente";break;}
	case 'TAUP':{$a=$a ." colmenas.tipo_abeja ";$xorden="el Tipo de Abejas Ascendente"; break; }
	case 'TADN':{ $a=$a ." colmenas.tipo_abeja DESC";$xorden="el Tipo de Abejas Descendente"; break;}
  case 'ESUP':{$a=$a ." colmenas.estado "; $xorden="el Estado de las Colmenas Ascendente";break; }
  case 'ESDN':{ $a=$a ." colmenas.estado DESC";$xorden="Estado de las Colmenas Descendente";break;}
	case 'UVUP':{$a=$a ." colmenas.f_ult_visita ASC ";$xorden="la Fecha de la Ultima Visita Ascendente";break;}
	case 'UVDN':{ $a=$a ." colmenas.f_ult_visita DESC";$xorden="la Fecha de la Ultimo Visita Descendente";break;}
  case 'UEUP':{$a=$a ." colmenas.fec_ult_ext ASC ";$xorden="la Fecha de la Ultima Extraccion Ascendente";break;}
  case 'UEDN':{ $a=$a ." colmenas.fec_ult_ext DESC";$xorden="la Fecha de la Ultima Extraccion Descendente";break;}
  case 'PIUP':{$a=$a ." colmenas.op ASC ";$xorden="Personal de Campo Ascendente";break;}
  case 'PIDN':{ $a=$a ." colmenas.op DESC";$xorden="Personal de Campo Descendente";break;}
  case 'IPUP':{$a=$a ." colmenas.prov_id ASC ";$xorden="Provedor ID Ascendente";break;}
  case 'IPDN':{ $a=$a ." colmenas.prov_id DESC";$xorden="Provedor ID Descendente";break;}
  case 'RPUP':{$a=$a ." provedores.razon_social ASC ";$xorden="Raz&oacute;n Social del Provedor Ascendente";break;}
  case 'RPDN':{ $a=$a ." provedores.razon_social DESC";$xorden="Raz&oacute;n Social del Provedor Descendente";break;}
  case 'NIUP':{$a=$a ." colmenas.cam_col_id ASC ";$xorden="Numero de Colmena Interno del Campo Ascendente";break;}
  case 'NIDN':{ $a=$a ." colmenas.cam_col_id DESC";$xorden="Numero de Colmena Interno del Campo Descendente";break;}
  default: { $a=$a ." colmena_id ASC";$xorden="Colmena ID Ascendente"; break;}
  }
}


$rs_validar = mysql_query($a,$cx_validar);
if (strlen($provedor_nam)>2) {echo "Campos Registrados al Provedor:&nbsp;&nbsp;".$provedor_nam;}
echo "<table border='1' id='tabla'>" ;
// coloco la linea de los filtros
echo "<tr bgcolor='#FFFFFF'><td><a href='campos1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";
if (empty($_SESSION["filtro_abrev"])) {echo ' ';} else { echo $_SESSION["filtro_abrev"];}
echo "</td>";

echo '<td>';
if (empty($_SESSION["filtro_nombre"])) {echo 'Filtro';} else { echo $_SESSION["filtro_nombre"];}echo '</td><td>';
if (empty($_SESSION["filtro_colmena_id"])) { echo 'Col.ID';} else { echo $_SESSION["filtro_colmena_id"] ;}echo '</td><td>';
if (empty($_SESSION["filtro_tipo_colmena"])) { echo 'Tipo';} else { echo $_SESSION["filtro_tipo_colmena"];}echo '</td><td>';
if (empty($_SESSION["filtro_fecha_alta"])) { echo 'Fecha Alta';} else { echo $_SESSION["filtro_fecha_alta"];}echo '</td><td>';
if (empty($_SESSION["filtro_tipo_abeja"])) { echo 'Abeja Tipo';} else { echo $_SESSION["filtro_tipo_abeja"];}echo '</td><td>';
if (empty($_SESSION["filtro_estado"])) { echo 'Estado';} else { echo $_SESSION["filtro_estado"];}echo '</td><td>';
if (empty($_SESSION["filtro_f_ult_visita"])) { echo 'Fec.Ult.Vis';} else { echo $_SESSION["filtro_f_ult_visita"];}echo '</td><td>';
if (empty($_SESSION["filtro_fec_ult_ext"])) { echo 'Fec.Ult.Extr.';} else { echo $_SESSION["filtro_fec_ult_ext"];}echo '</td><td>';
if (empty($_SESSION["filtro_pers_id"])) { echo 'Pers.Campo';} else { echo $_SESSION["filtro_pers_id"];}echo '</td><td>';
if (empty($_SESSION["filtro_prov_id"])) { echo 'Prov.Id';} else { echo $_SESSION["filtro_prov_id"];}echo '</td><td>';
if (empty($_SESSION["filtro_provedor"])) { echo 'Provedor';} else { echo $_SESSION["filtro_provedor"];}echo '</td><td>';
if (empty($_SESSION["filtro_cam_col_id"])) { echo 'N.Col.Campo';} else { echo $_SESSION["filtro_cam_col_id"];}echo '</td>';

echo '</tr>';
$tb='Búsqueda de un código';
$ta='Ver x Codigo de Campo, Orden Ascendente';
$td='Ver x Codigo de Campo, Orden Descendente';
echo '<td><table><td width=10%>';
echo "<a href='colmenas1.php?orden=IDUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=abrev'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='colmenas1.php?orden=IDDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Nombre o parte del Nombre del Campo';
$ta='Ver x Nombre del Campo, Orden Ascendente';
$td='Ver x Nombre del Campo, Orden Descendente';
echo "<td><table><td width=90% aling'center' >Campo</td>";
echo '<td width=10%>';
echo "<a href='colmenas1.php?orden=RSUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=razon_social'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='colmenas1.php?orden=RSDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='20' height='20' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un ID de colmena solamente';
$ta='Ver x ID de colmena, Orden Ascendente';
$td='Ver x ID de colmena, Orden Descendente';
echo "<td><table>";
echo '<td width=10%>';
echo "<a href='colmenas1.php?orden=CIUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=colmena_id'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='colmenas1.php?orden=CIDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un tipo de colmena solamente';
$ta='Ver x tipo de colmena, Orden Ascendente';
$td='Ver x tipo de colmena, Orden Descendente';
echo "<td><table>";
echo '<td width=10%>';
echo "<a href='colmenas1.php?orden=TCUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=tipo_colmena'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='colmenas1.php?orden=TCDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar una Fecha de Alta de la Colmena';
$ta='Ver x Fecha de Alta, Orden Ascendente';
$td='Ver x Fecha de Alta, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='colmenas1.php?orden=FAUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=fecha_alta'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='colmenas1.php?orden=FADN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Tipo de Abeja';
$ta='Ver x Tipo de Abeja, Orden Ascendente';
$td='Ver x Tipo de Abeja, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='colmenas1.php?orden=TAUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=tipo_abeja'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='colmenas1.php?orden=TADN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Estado de Colmena';
$ta='Ver x Estado de Colmena, Orden Ascendente';
$td='Ver x Estado de Colmena, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='colmenas1.php?orden=ESUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=estado'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='colmenas1.php?orden=ESDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar una Fecha de Ultima Visita';
$ta='Ver x Fecha de Ult.Visita, Orden Ascendente';
$td='Ver x Fecha de Ult.Visita, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='colmenas1.php?orden=UVUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=f_ult_visita'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='colmenas1.php?orden=UVDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar una Fecha de Ultima Extraccion';
$ta='Ver x Fecha de Ult.Extraccion, Orden Ascendente';
$td='Ver x Fecha de Ult.Extraccion, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='colmenas1.php?orden=UEUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=fec_ult_ext'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='colmenas1.php?orden=UEDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Personal de Campo ';
$ta='Ver x Personal de campo, Orden Ascendente';
$td='Ver x Personal de campo, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='colmenas1.php?orden=PIUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=op'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='colmenas1.php?orden=PIDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Provedor ';
$ta='Ver x ID de Provedor, Orden Ascendente';
$td='Ver x ID de Provedor, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='colmenas1.php?orden=IPUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=prov_id'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='colmenas1.php?orden=IPDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Provedor ';
$ta='Ver x Provedor, Orden Ascendente';
$td='Ver x Provedor, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='colmenas1.php?orden=RPUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=provedor'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='colmenas1.php?orden=RPDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar una Colmena por N&uacturemero Interno en el Campo ';
$ta='Ver x N&uacturemero Interno, Orden Ascendente';
$td='Ver x N&uacturemero Interno, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='colmenas1.php?orden=NIUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=cam_col_id'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='colmenas1.php?orden=NIDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

echo '</tr>';

$j=0;$k=0; $inom=0;$idir=0;$iloc=0;$iidc;$illega=0;$iest=0;
if (!empty($_SESSION[filtro_abrev])) {$illega++;}
if (!empty($_SESSION[filtro_nombre]))    {$illega++;}
if (!empty($_SESSION[filtro_colmena_id])) {$illega++;}
if (!empty($_SESSION[filtro_cam_col_id])) {$illega++;}
if (!empty($_SESSION[filtro_tipo_colmena])) {$illega++;}
if (!empty($_SESSION[filtro_tipo_abeja])) {$illega++;}
if (!empty($_SESSION[filtro_contacto])) {$illega++;}
if (!empty($_SESSION[filtro_prov_id])) {$illega++;}
if (!empty($_SESSION[filtro_provedor])) {$illega++;}
if (!empty($_SESSION[filtro_estado])) {$illega++;}

while ($v_validar = mysql_fetch_array($rs_validar)) {
  $j++;$va="no"; $iicam=0;$inom=0;$idir=0;$iloc=0;$iprov=0;$ipai=0;$icon=0;$iiprov=0;$inprov=0;
  if ( empty($_SESSION[filtro_estado]) && empty($_SESSION[filtro_abrev]) &&  empty($_SESSION[filtro_provedor]) && 
       empty($_SESSION[filtro_tipo_abeja]) &&  empty($_SESSION[filtro_nombre]) && empty($_SESSION[filtro_colmena_id]) && 
       empty($_SESSION[filtro_tipo_colmena]) &&  empty($_SESSION[filtro_cam_col_id])&& empty($_SESSION[filtro_prov_id]) && empty($_SESSION[filtro_contacto])
    )
    {$va="si";}
  else {
    if (!empty($_SESSION[filtro_abrev])){
      if ( $v_validar[13] ==$_SESSION[filtro_abrev]) {$iicam=1;}
      if (stristr(strtoupper($v_validar[13]),strtoupper($_SESSION[filtro_abrev]))<> FALSE) {$iicam=1;;}
    }
    if (!empty($_SESSION[filtro_nombre])){
      if ( strtoupper($v_validar[1]) ==strtoupper($_SESSION[filtro_nombre])) {$inom=1;}
      if (stristr(strtoupper($v_validar[1]),strtoupper($_SESSION[filtro_nombre]))<> FALSE) {$inom=1;;}
    }
    if (!empty($_SESSION[filtro_estado])){
      if ( strtoupper($v_validar[6]) ==strtoupper($_SESSION[filtro_estado])) {$iest=1;}
      if (stristr(strtoupper($v_validar[6]),strtoupper($_SESSION[filtro_estado]))<> FALSE) {$iest=1;;}
    }
    if (!empty($_SESSION[filtro_tipo_abeja])){
      if ( strtoupper($v_validar[5]) == strtoupper($_SESSION[filtro_tipo_abeja])) {$idir=1;;}
      if (stristr(strtoupper($v_validar[5]),strtoupper($_SESSION[filtro_tipo_abeja]))<> FALSE) {$idir=1;}
    }
    if (!empty($_SESSION[filtro_tipo_colmena])){
      if ( strtoupper($v_validar[3]) ==strtoupper($_SESSION[filtro_tipo_colmena])){$iloc=1;}
      if (stristr(strtoupper($v_validar[3]),strtoupper($_SESSION[filtro_tipo_colmena]))<> FALSE) {$iloc=1;} 
    }
    if (!empty($_SESSION[filtro_colmena_id]))
        { if ( strtoupper($v_validar[2]) ==strtoupper($_SESSION[filtro_colmena_id])) {$iprov=1;}}

    if (!empty($_SESSION[filtro_cam_col_id]))
        { if ( strtoupper($v_validar[11]) ==strtoupper($_SESSION[filtro_cam_col_id])) {$ipai=1;}}

    if (!empty($_SESSION[filtro_contacto])){
      if ( strtoupper($v_validar[8]) ==strtoupper($_SESSION[filtro_contacto])) {$icon=1;}
      if (stristr(strtoupper($v_validar[8]),strtoupper($_SESSION[filtro_contacto]) )<> FALSE) {$icon=1;}
    }
    if (!empty($_SESSION[filtro_prov_id])){
      if ( $v_validar[9] ==$_SESSION[filtro_prov_id]) {$iiprov=1;}
    }
    if (!empty($_SESSION[filtro_provedor])){
      if ( strtoupper($v_validar[10]) ==strtoupper($_SESSION[filtro_provedor])) {$inprov=1;}
      if (stristr(strtoupper($v_validar[10]),strtoupper($_SESSION[filtro_provedor]) )<> FALSE) {$inprov=1;}
    }

    IF ($illega <= ($iicam + $inom + $idir + $iloc + $iprov + $ipai + $icon + $iiprov + $inprov +$iest )) {$va="si";}
  }
  if ($va=="si"){
  $k++;
  echo "<tr><td ALIGN='RIGHT' id=".'A'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].">$v_validar[13]</td>";
  echo "<td id=".'B'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].">$v_validar[1]</td>";
  echo "<td id=".'C'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2]."> $v_validar[2]</td>";
  echo "<td id=".'D'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].">$v_validar[3]</td>";
  echo "<td id=".'E'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].'>'.substr($v_validar[4],-2).substr($v_validar[4],4,4).substr($v_validar[4],0,4).'</td>';
  echo "<td id=".'F'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].">$v_validar[5]</td>";
  echo "<td id=".'G'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].">$v_validar[6]</td>";
  echo "<td id=".'H'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].'>'.substr($v_validar[7],-2).substr($v_validar[7],4,4).substr($v_validar[7],0,4).'</td>';
  echo "<td id=".'M'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].'>'.substr($v_validar[12],-2).substr($v_validar[12],4,4).substr($v_validar[12],0,4).'</td>';
  echo "<td id=".'I'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].">$v_validar[8]</td>";
  echo "<td id=".'J'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].">$v_validar[9]</td>";
  echo "<td id=".'K'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].">$v_validar[10]</td>";
  echo "<td id=".'L'.$v_validar[0].'-'.$v_validar[9].'/'.$v_validar[2].">$v_validar[11]</td>";
  echo "</tr>" ;
}
}
echo "<caption  color style='background:#99FF33'>Listado de Colmenas Ordenado por ".$xorden;
echo ".  .  . Se leyeron ".$j." registros";
if ( ($k > 0) && ($k!=$j) ) {echo " y coinciden " .$k;}
echo "</caption></table>";
echo "<a href='campos1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";
echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";

echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
?>
</BODY>
</HTML>

