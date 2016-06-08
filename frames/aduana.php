<?php
session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];

$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=8 and acceso="on"';
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
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='movimiento.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);

// si hay filtros no hay limite porque los proceso despues
$sub='';
$orden=$_REQUEST["orden"];

if ($_SESSION["reg_desde"]==1) {$_SESSION["reg_desde"]=0;}
if ( $sub == 'Volver' )
    { $limite=' LIMIT 0,1';}
?>
<head>
<TITLE> ADUANAS </TITLE>
<meta name="viewport" content="width=device-width,initial-scale=1">             
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
.seleccion{   border-color: #FFF;
  border-top-color: #F00;}
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
  for (i=1; ele=tab.getElementsByTagName('td')[i]; i++) {
    ele.onclick = function() {seteo(this,i,colu,tx );  }
    ele.onmouseover = function() {iluminar(this,true)}
    if (k==0) ele.onmouseout = function() {iluminari(this);}
    if (k==1) ele.onmouseout = function() {iluminarp(this);}
    j++
    if (j==colu)
     {j=0;
      if (k!=1)
       {k++;}
      else
       {k=0;}}
  }
}


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
  for (i1=1; ele1=tab.getElementsByTagName('td')[i1]; i1=i1+k1) {
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
-->
</script>
</head>
<?
echo "<body onload='ini(1); poner1(1);'>";
echo "<link rel='shortcut icon' href='fotos/chmiel.ico'>";
echo "<form name='formulario' method='POST' action='mod_aduana.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$actualizar="select * from  ".$_SESSION["tabla_aduanas"];
switch ($orden) {
	case 'RSUP':{$actualizar=$actualizar ." ORDER BY aduana_sal ";break; }
	case 'RSDN':{$actualizar=$actualizar ." ORDER BY aduana_sal  DESC";break;}
  default:{$actualizar=$actualizar ." ORDER BY aduana_sal ASC ";break;}
}


$rs_validar = mysql_query($actualizar,$cx_validar);

echo "<table border='1' id='tabla'>" ;

$ta='Ver x aduana_sal,  Orden Ascendente';
$td='Ver x aduana_sal, Orden Descendente';

echo "<td align='CENTER'><a href='aduana.phporden=IDUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='15' ></a>";
echo '&nbsp;&nbsp;Nombre&nbsp;&nbsp;';
echo "<a href='aduana.phporden=IDDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='15' border='0'></a>";
echo '</td>';
echo '</tr>';
$k=0;
while ($v_validar = mysql_fetch_array($rs_validar)){
  $k++;
  echo "<tr><td ALIGN='LEFT' id="."A"."$v_validar[0]> $v_validar[1]</td>";
  echo "</tr>" ;
}
echo "<caption  color style='background:#99FF33'>Aduanas Definidas";
echo "</caption></table>";
echo "<a href='menu_1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";
echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";
echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
?>
</BODY>
</HTML>

