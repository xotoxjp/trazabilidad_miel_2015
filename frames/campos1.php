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
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='campos1.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);
$rid="";
$rid=$_GET["rid"];
$prov_id=$_GET["ar"];
if ($prov_id>0){$_SESSION["filtro_prov_id"]=$prov_id;
  $actualizar="select count(*) as ss from  ".$_SESSION["tabla_campos"].' where prov_id='.$prov_id;
  $rs_validar = mysql_query($actualizar,$cx_validar);
  while ($v_validar = mysql_fetch_array($rs_validar)) { $p=$v_validar[0];}
  if ($p==0) {
    { // no tiene ningun campo este provedor copio en principio los datos del provedor a un campo y voy a editarlo
    $act="select * from  ".$_SESSION["tabla_provedores"]. " where prov_id=".$prov_id ;

    $rs_validar = mysql_query($act,$cx_validar);
    while ($v_validar = mysql_fetch_array($rs_validar))
    {
    $prov_id= $v_validar[0];$nombre= $v_validar[1];$dir1= $v_validar[2];
    $dir2= $v_validar[3];$localidad=$v_validar[4];$cod_postal=$v_validar[5];
    $provincia=$v_validar[6];$pais=$v_validar[7];$cond_iva=$v_validar[8];
    $nro_cuit=$v_validar[9];
    $contacto=$v_validar[13];$tel=$v_validar[14];$cel=$v_validar[15];$fax=$v_validar[16];$nextel=$v_validar[17];$email=$v_validar[18];$sector=$v_validar[19];
    $contacto1=$v_validar[20];$tel1=$v_validar[21];$cel1=$v_validar[22];$email1=$v_validar[23];$sector1=$v_validar[24];
    $contacto2=$v_validar[25];$tel2=$v_validar[26];$cel2=$v_validar[27];$email2=$v_validar[28];$sector2=$v_validar[29];
    $lat=$v_validar[30];$lon=$v_validar[31];
    }
    $act="INSERT INTO ".$_SESSION["tabla_campos"]." (`prov_id`,`campo_id`, `razon_social`, `dir1`, `dir2`,";
    $act=$act." `localidad`, `cod_postal`, `provincia`, `pais`, `cond_iva`, `nro_cuit`,";
    $act=$act." `contacto`,`tel`, `cel`, `fax`, `nextel`, `email`, `sector`, `contacto1`,";
    $act=$act." `tel1`, `cel1`, `email1`, `sector1`, `contacto2`, `tel2`,";
    $act=$act." `cel2`, `email2`, `sector2`, `lat`, `lon` ) VALUES (".$prov_id.",1,";
    $act=$act." '" .$nombre . "', '" .$dir1;
    $act=$act."', '".$dir2."', '".$localidad."', ".$cod_postal. ", '".$provincia."', '".$pais. "', '" ;
    $act=$act.  $cond_iva."', '".$nro_cuit."','".$contacto."', '".$tel."',";
    $act=$act." '".$cel."', '".$fax."',";
    $act=$act." '".$nextel."', '".$email."', '".$sector."', '".$contacto1."', '".$tel1."', '".$cel1;
    $act=$act."', '".$email."', '".$sector1."', '".$contacto2;
    $act=$act."', '".$tel2."', '".$cel2."', '".$email2."', '".$sector2."', ".$lat.", ".$lon.")";
    $rs_validar = mysql_query($act,$cx_validar);

    $act="update ".$_SESSION["tabla_provedores"]. " set campos_reg=1 where prov_id=".$prov_id ;

    $rs_validar = mysql_query($act,$cx_validar);
    header("Location: mod_campos1.php?&ar=$prov_id") ;echo '1';}
  }
}

act_col_cam($prov_id,$campo_id);

$sub=".";
$orden=$_REQUEST["orden"];

foreach ($_POST as $indice => $valor)
  {
 // echo "$indice: $valor<br>";
   switch ($indice) {
    case 'campo': $campo=$valor ; break;
	case 'orden': $orden=$valor ; break;
	case 'filtro': $filtro=$valor; break;
	case 'Submit': $sub=$valor; break;}
  }

if ($filtro !='   ')
{ $filtro = strtoupper($filtro);
  IF ( $campo == 'abrev' )   {$_SESSION["filtro_abrev"]=$filtro; }
  IF ( $campo == 'razon_social'){$_SESSION["filtro_nombre"]=$filtro; }
  IF ( $campo == 'direccion' )  {$_SESSION["filtro_direccion"]=$filtro; }
  IF ( $campo == 'localidad' )  {$_SESSION["filtro_localidad"]=$filtro; }
  IF ( $campo == 'provincia' )  {$_SESSION["filtro_provincia"]=$filtro; }
  IF ( $campo == 'op' )       {$_SESSION["filtro_op"]=$filtro; }
  IF ( $campo == 'contacto' )   {$_SESSION["filtro_contacto"]=$filtro; }
  IF ( $campo == 'prov_id' )    {$_SESSION["filtro_prov_id"]=$filtro; if (strlen($filtro)==0) {$prov_id=0;}}
  IF ( $campo == 'provedor' )   {$_SESSION["filtro_provedor"]=$filtro; }
}
$Limite="";
?>
<head>
<TITLE>CAMPOS</TITLE>
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
  for (i=60; ele=tab.getElementsByTagName('td')[i]; i++) {
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
  for (i1=60; ele1=tab.getElementsByTagName('td')[i1]; i1=i1+k1) {
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
echo "<body onload='ini(11); poner1(11);'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='mod_campos1.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
if ($prov_id>0){
$actualizar="select razon_social from  ".$_SESSION["tabla_provedores"].' where prov_id='.$prov_id;
$rs_validar = mysql_query($actualizar,$cx_validar);$provedor_nam='';
while ($v_validar = mysql_fetch_array($rs_validar)) { $provedor_nam=$v_validar[0];}
}


$actualizar="select campos.campo_id ,campos.razon_social,campos.dir1,campos.localidad,campos.provincia,campos.op,campos.contacto,campos.colmenas,";
$actualizar=$actualizar."campos.nucleos,campos.prov_id,provedores.razon_social,campos.abrev from  ".$_SESSION["tabla_campos"].' inner join ' .$_SESSION["tabla_provedores"].' on campos.prov_id=provedores.prov_id ';
$desorden='';
if ($orden == ".")
  {  }
else {

  switch ($orden) {
	case 'RSUP':{$actualizar=$actualizar ." ORDER BY campos.razon_social ";$desorden='Nombre del Campo Ascendente';  break;}
	case 'RSDN':{ $actualizar=$actualizar ." ORDER BY campos.razon_social DESC";$desorden='Nombre del Campo Descendente';break;}
	case 'DIUP':{$actualizar=$actualizar ." ORDER BY  campos.dir1  ";$desorden='Direccion Ascendente';break;}
	case 'DIDN':{ $actualizar=$actualizar ." ORDER BY  campos.dir1  DESC";$desorden='Direccion Descendente';break;}
	case 'LOUP':{$actualizar=$actualizar ." ORDER BY campos.localidad ";$desorden='Localidad Ascendente';break;}
	case 'LODN':{ $actualizar=$actualizar ." ORDER BY campos.localidad DESC";$desorden='Localidad Descendente';break;}
  case 'PRUP':{$actualizar=$actualizar ." ORDER BY campos.provincia ";$desorden='Provincia Ascendente';break;}
  case 'PRDN':{ $actualizar=$actualizar ." ORDER BY campos.provincia DESC";$desorden='Provincia Descendente';break;}
	case 'OPUP':{$actualizar=$actualizar ." ORDER BY campos.contacto ";$desorden='Contacto del Campo Ascendente'; break; }
	case 'OPDN':{ $actualizar=$actualizar ." ORDER BY campos.contacto DESC";$desorden='Contacto del Campo Descendente'; break;}
  case 'PAUP':{$actualizar=$actualizar ." ORDER BY campos.op "; $desorden='Operador del Campo Ascendente';break; }
  case 'PADN':{ $actualizar=$actualizar ." ORDER BY campos.op DESC";$desorden='Operador del Campo Descendente';break;}

  case 'COUP':{$actualizar=$actualizar ." ORDER BY campos.colmenas ";$desorden='Cant. de Colmenas Ascendente'; break; }
  case 'CODN':{ $actualizar=$actualizar ." ORDER BY campos.colmenas DESC";$desorden='Cant. de Colmenas Descendente';break;}

  case 'NUUP':{$actualizar=$actualizar ." ORDER BY campos.nucleos ";$desorden='Cant. de N&uacute;cleos Ascendente'; break; }
  case 'NUDN':{ $actualizar=$actualizar ." ORDER BY campos.nucleos DESC";$desorden='Cant. de N&uacute;cleos Descendente';break;}


	case 'IDUP':{$actualizar=$actualizar ." ORDER BY campos.abrev ASC ";$desorden='ID del Campo Ascendente';break;}
	case 'IDDN':{ $actualizar=$actualizar ." ORDER BY campos.abrev DESC";$desorden='ID del Campo Ascendente';break;}
  case 'IPUP':{$actualizar=$actualizar ." ORDER BY campos.prov_id ASC ";$desorden='Prov. ID Ascendente';break;}
  case 'IPDN':{ $actualizar=$actualizar ." ORDER BY campos.prov_id DESC";$desorden='Prov. ID Descendente';break;}
  case 'RPUP':{$actualizar=$actualizar ." ORDER BY provedores.razon_social ASC ";$desorden='Nombre del Provedor Ascendente';break;}
  case 'RPDN':{ $actualizar=$actualizar ." ORDER BY provedores.razon_social DESC";$desorden='Nombre del Provedor Descendente';break;}
  default: { $actualizar=$actualizar ." ORDER BY campo_id ASC";$desorden='ID del Campo Ascendente'; break;}
  }
}

$rs_validar = mysql_query($actualizar,$cx_validar);
if (strlen($provedor_nam)>2) {echo "Campos Registrados al Provedor:&nbsp;&nbsp;".$provedor_nam;}
echo "<table border='1' id='tabla'>" ;
// coloco la linea de los filtros
echo "<tr bgcolor='#FFFFFF'><td><a href='provedores1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a></td>";
echo '<td>';
if (empty($_SESSION["filtro_nombre"])) {echo 'Filtro';} else { echo $_SESSION["filtro_nombre"];}
echo '</td><td>';
if (empty($_SESSION["filtro_direccion"])) { echo 'Filtro';} else { echo $_SESSION["filtro_direccion"] ;}
echo '</td><td>';
if (empty($_SESSION["filtro_localidad"])) { echo 'Filtro';} else { echo $_SESSION["filtro_localidad"];}
echo '</td>';          //&nbsp
echo '<td>';
if (empty($_SESSION["filtro_provincia"])) { echo 'Filtro';} else { echo $_SESSION["filtro_provincia"];}
echo '</td>';
echo '<td>';
if (empty($_SESSION["filtro_op"])) { echo 'Filtro';} else { echo $_SESSION["filtro_op"];}
echo '</td>';

echo '<td>';
if (empty($_SESSION["filtro_contacto"])) { echo 'Filtro';} else { echo $_SESSION["filtro_contacto"];}
echo '</td>';
echo  '<td>Colmenas</td><td>N&uacute;cleos</td>';

echo '<td>';
if (empty($_SESSION["filtro_prov_id"])) { echo 'Filtro';} else { echo $_SESSION["filtro_prov_id"];}
echo '</td>';

echo '<td>';
if (empty($_SESSION["filtro_provedor"])) { echo 'Filtro';} else { echo $_SESSION["filtro_provedor"];}
echo '</td>';

echo '</tr>';
$tb='Búsqueda de un código';
$ta='Ver x Codigo de Campo, Orden Ascendente';
$td='Ver x Codigo de Campo, Orden Descendente';
echo '<td><table><td width=10%>';
echo "<a href='campos1.php?orden=IDUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=abrev'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='campos1.php?orden=IDDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Nombre o parte del Nombre del Campo';
$ta='Ver x Nombre del Campo, Orden Ascendente';
$td='Ver x Nombre del Campo, Orden Descendente';
echo "<td><table><td width=90% aling'center' >Campo</td>";
echo '<td width=10%>';
echo "<a href='campos1.php?orden=RSUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=razon_social'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='campos1.php?orden=RSDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='20' height='20' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar una dirección o parte de la dirección del Campo';
$ta='Ver x Direccion, Orden Ascendente';
$td='Ver x Direccion, Orden Descendente';
echo "<td><table><td width=90% aling'center' >Direcci&oacute;n</td>";
echo '<td width=10%>';
echo "<a href='campos1.php?orden=DIUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=direccion'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='campos1.php?orden=DIDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='20' height='20' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar una localidad o parte de una localidad de Campos';
$ta='Ver x Localidad, Orden Ascendente';
$td='Ver x Localidad, Orden Descendente';
echo "<td><table ><td width=90% aling'center' >Localidad</td>";
echo '<td width=10%>';
echo "<a href='campos1.php?orden=LOUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=localidad'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='campos1.php?orden=LODN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='20' height='20' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar una Provincia o parte de una Provincia de Campos';
$ta='Ver x Provincias, Orden Ascendente';
$td='Ver x Provincias, Orden Descendente';
echo "<td><table><td width=90% aling'center' >Prov.</td>";
echo '<td width=1%>';
echo "<a href='campos1.php?orden=PRUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=provincia'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='campos1.php?orden=PRDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Operador o parte del Operador de Campos';
$ta='Ver x Operador, Orden Ascendente';
$td='Ver x Operador, Orden Descendente';
echo "<td><table><td width=90% aling'center' >Opera</td>";
echo '<td width=1%>';
echo "<a href='campos1.php?orden=PAUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=op'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='campos1.php?orden=PADN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Contacto de Campo';
$ta='Ver x Contacto, Orden Ascendente';
$td='Ver x Contacto, Orden Descendente';
echo "<td><table><td width=90% aling'center' >Contacto</td>";
echo '<td width=1%>';
echo "<a href='campos1.php?orden=OPUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=contacto'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='campos1.php?orden=OPDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$ta='Ver x Cantidad de Colmenas, Orden Ascendente';
$td='Ver x Cantidad de Colmenas, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='campos1.php?orden=COUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='campos1.php?orden=CODN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$ta='Ver x Cantidad de Nucleos, Orden Ascendente';
$td='Ver x Cantidad de Nucleos, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='campos1.php?orden=NUUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='campos1.php?orden=NUDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Provedor ';
$ta='Ver x ID de Provedor, Orden Ascendente';
$td='Ver x ID de Provedor, Orden Descendente';
echo "<td><table>";
echo '<td width=1%>';
echo "<a href='campos1.php?orden=IPUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=prov_id'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='campos1.php?orden=IPDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Provedor ';
$ta='Ver x Provedor, Orden Ascendente';
$td='Ver x Provedor, Orden Descendente';
echo "<td><table><td width=90% aling'center' >Provedor</td>";
echo '<td width=1%>';
echo "<a href='campos1.php?orden=RPUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a  href='filtro.php?campo=provedor'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='14' border='0'></a>";
echo '</td><td width=1%>';
echo "<a href='campos1.php?orden=RPDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='14' border='0'></a>";
echo '</td></table></td>';

echo '</tr>';

$j=0;$k=0; $inom=0;$idir=0;$iloc=0;$iidc;$illega=0;
if (!empty($_SESSION[filtro_abrev])) {$illega++;}
if (!empty($_SESSION[filtro_nombre]))    {$illega++;}
if (!empty($_SESSION[filtro_direccion])) {$illega++;}
if (!empty($_SESSION[filtro_localidad])) {$illega++;}
if (!empty($_SESSION[filtro_provincia])) {$illega++;}
if (!empty($_SESSION[filtro_op])) {$illega++;}
if (!empty($_SESSION[filtro_contacto])) {$illega++;}
if (!empty($_SESSION[filtro_prov_id])) {$illega++;}
if (!empty($_SESSION[filtro_provedor])) {$illega++;}


while ($v_validar = mysql_fetch_array($rs_validar)) {
  $j++;$va="no"; $iicam=0;$inom=0;$idir=0;$iloc=0;$iprov=0;$ipai=0;$icon=0;$iiprov=0;$inprov=0;
  if ( empty($_SESSION[filtro_provincia]) && empty($_SESSION[filtro_abrev]) &&  empty($_SESSION[filtro_provedor]) && 
       empty($_SESSION[filtro_op]) &&  empty($_SESSION[filtro_nombre]) && empty($_SESSION[filtro_direccion]) && 
       empty($_SESSION[filtro_localidad])&& empty($_SESSION[filtro_prov_id]) && empty($_SESSION[filtro_contacto])
    )
    {$va="si";}
  else {
    if (!empty($_SESSION[filtro_abrev])){
      if ( $v_validar[11] ==$_SESSION[filtro_abrev]) {$iicam=1;}
      if (stristr(strtoupper($v_validar[11]),strtoupper($_SESSION[filtro_abrev]))<> FALSE) {$iicam=1;;}
    }
    if (!empty($_SESSION[filtro_nombre])){
      if ( strtoupper($v_validar[1]) ==strtoupper($_SESSION[filtro_nombre])) {$inom=1;}
      if (stristr(strtoupper($v_validar[1]),strtoupper($_SESSION[filtro_nombre]))<> FALSE) {$inom=1;;}
    }
    if (!empty($_SESSION[filtro_direccion])){
      if ( strtoupper($v_validar[2]) == strtoupper($_SESSION[filtro_direccion])) {$idir=1;;}
      if (stristr(strtoupper($v_validar[2]),strtoupper($_SESSION[filtro_direccion]))<> FALSE) {$idir=1;}
    }
    if (!empty($_SESSION[filtro_localidad])){
      if ( strtoupper($v_validar[3]) ==strtoupper($_SESSION[filtro_localidad])){$iloc=1;}
      if (stristr(strtoupper($v_validar[3]),strtoupper($_SESSION[filtro_localidad]))<> FALSE) {$iloc=1;} 
    }
    if (!empty($_SESSION[filtro_provincia]))
        { if ( strtoupper($v_validar[4]) ==strtoupper($_SESSION[filtro_provincia])) {$iprov=1;}}

    if (!empty($_SESSION[filtro_op]))
        { if ( strtoupper($v_validar[5]) ==strtoupper($_SESSION[filtro_op])) {$ipai=1;}}

    if (!empty($_SESSION[filtro_contacto])){
      if ( strtoupper($v_validar[6]) ==strtoupper($_SESSION[filtro_contacto])) {$icon=1;}
      if (stristr(strtoupper($v_validar[6]),strtoupper($_SESSION[filtro_contacto]) )<> FALSE) {$icon=1;}
    }
    if (!empty($_SESSION[filtro_prov_id])){
      if ( $v_validar[9] ==$_SESSION[filtro_prov_id]) {$iiprov=1;}
    }
    if (!empty($_SESSION[filtro_provedor])){
      if ( strtoupper($v_validar[10]) ==strtoupper($_SESSION[filtro_provedor])) {$inprov=1;}
      if (stristr(strtoupper($v_validar[10]),strtoupper($_SESSION[filtro_provedor]) )<> FALSE) {$inprov=1;}
    }

    IF ($illega <= ($iicam + $inom + $idir + $iloc + $iprov + $ipai + $icon + $iiprov + $inprov )) {$va="si";}
  }
  if ($va=="si"){
  $k++;
  echo "<tr><td ALIGN='RIGHT' id="."A"."$v_validar[0]-$v_validar[9]>$v_validar[11]</td>";
  echo "<td id="."B".$v_validar[0]."-$v_validar[9]>$v_validar[1]</td>";
  echo "<td id="."C".$v_validar[0]."-$v_validar[9]> $v_validar[2]</td>";
  echo "<td id="."D".$v_validar[0]."-$v_validar[9]>$v_validar[3]</td>";
  echo "<td id="."E".$v_validar[0]."-$v_validar[9]>$v_validar[4]</td>";
  echo "<td id="."F".$v_validar[0]."-$v_validar[9]>$v_validar[5]</td>";
  echo "<td id="."G".$v_validar[0]."-$v_validar[9]>$v_validar[6]</td>";
  echo "<td ALIGN='RIGHT' id="."H".$v_validar[0]."-$v_validar[9]>$v_validar[7]</td>";
  echo "<td ALIGN='RIGHT' id="."I".$v_validar[0]."-$v_validar[9]>$v_validar[8]</td>";
  echo "<td ALIGN='RIGHT' id="."J".$v_validar[0]."-$v_validar[9]>$v_validar[9]</td>";
  echo "<td id="."K".$v_validar[0]."-$v_validar[9]>$v_validar[10]</td>";
  echo "</tr>" ;
}
}
echo "<caption  color style='background:#99FF33'>Listado de Campos Ordenado x ".$desorden;

echo ".  .  . Se leyeron ".$j." registros";
if ( ($k > 0) && ($k!=$j) ) {echo " y coinciden " .$k;}
echo "</caption></table>";
echo "<a href='provedores1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";
echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";
echo "<INPUT TYPE=HIDDEN NAME='prov_id' id='prov_id' VALUE=".$prov_id.'>';

echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
?>
</BODY>
</HTML>

