<?php
session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];

$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=10 and acceso="on"';
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
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='tipoalma.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);

// si hay filtros no hay limite porque los proceso despues
$sub='';
$orden=$_REQUEST["orden"];
foreach ($_POST as $indice => $valor)
  {
//  echo "$indice: $valor<br>";
   switch ($indice) {
    case 'campo': $campo=$valor ; break;
	case 'orden': $orden=$valor ; break;
	case 'filtro': $filtro=$valor; break;
	case 'Submit': $sub=$valor; break;}
  }


if ($filtro !='   ')
{ $filtro = strtoupper($filtro);
  IF ( $campo == 'tipo_almacen' ) {$_SESSION["filtro_tipo_almacen"]=$filtro; }
  IF ( $campo == 'nombre' ) {$_SESSION["filtro_nombre"]=$filtro; }
}
if ($_SESSION["reg_desde"]==1) {$_SESSION["reg_desde"]=0;}
if ( $sub == 'Volver' )
    { $limite=' LIMIT 0,1';}
if ( empty($_SESSION[filtro_tipo_almacen]) && empty($_SESSION[filtro_nombre]) )
          { $Limite= '';}
?>
<head>
<TITLE>  TIPOS DE ALMACEN  </TITLE>
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
  for (i=13; ele=tab.getElementsByTagName('td')[i]; i++) {
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
  for (i1=13; ele1=tab.getElementsByTagName('td')[i1]; i1=i1+k1) {
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
echo "<body onload='ini(4); poner1(4);'>";
echo "<link rel='shortcut icon' href='fotos/chmiel.ico'>";
echo "<form name='formulario' method='POST' action='tipoalma.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$actualizar="select * from  ".$_SESSION["tabla_tipo_almacen"];
switch ($orden) {
	case 'RSUP':{$actualizar=$actualizar ." ORDER BY nombre ";break; }
	case 'RSDN':{$actualizar=$actualizar ." ORDER BY nombre DESC";break;}
	case 'IDUP':{$actualizar=$actualizar ." ORDER BY tipo_almacen ASC ";break;}
	case 'IDDN':{ $actualizar=$actualizar ." ORDER BY tipo_almacen DESC";break;}
  default:{$actualizar=$actualizar ." ORDER BY tipo_almacen ASC ";break;}
}


$rs_validar = mysql_query($actualizar,$cx_validar);

echo "<table border='1' id='tabla'>" ;
// coloco la linea de los filtros
echo "<tr bgcolor='#FFFFFF'><td><a href='menu_1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a></td>";
echo '<td>';
if (empty($_SESSION["filtro_nombre"])) {echo 'Filtro';} else { echo $_SESSION["filtro_nombre"];}
echo '</td><td ALIGN="CENTER" rowspan="2">Imagen</td><td ALIGN="CENTER"  rowspan="2">Abrev.</td>';
echo '</tr>';

$tb='B&uacute;squeda de un c&oacute;digo';
$ta='Ver x Tipo de Almacen,  Orden Ascendente';
$td='Ver x Tipo de Almacen, Orden Descendente';

echo '<td><table><td width=10%>';
echo "<a href='tipoalma.php?orden=IDUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='10' height='15' ></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=tipo_almacen'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='tipoalma.php?orden=IDDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';

$tb='Buscar un Nombre o parte del Nombre del Almacen';
$ta='Ver x Nombre del Almacen, Orden Ascendente';
$td='Ver x Nombre del Almacen, Orden Descendente';

echo "<td><table><td width=90% aling'center' >Nombre del Almacen</td>";
echo '<td width=10%>';
echo "<a href='tipoalma.php?orden=RSUP'><img src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=nombre'><img src='fotos/browse.gif' alt='".$tb."' title='".$tb."'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='tipoalma.php?orden=RSDN'><img src='fotos/down.ico' alt='".$td."' title='".$td."'  aling'left' width='20' height='20' border='0'></a>";
echo '</td></table></td>';
echo '</tr>';
$j=0;$k=0; $inom=0;$iidc;$illega=0;
if (!empty($_SESSION[filtro_nombre]))    {$illega++;}
if (!empty($_SESSION[filtro_tipo_almacen])) {$illega++;}

while ($v_validar = mysql_fetch_array($rs_validar))
   {
       $j++;$va="no"; $inom=0;$iidc=0;
       if (empty($_SESSION[filtro_nombre]) && empty($_SESSION[filtro_tipo_almacen]) )
          {$va="si";}
       else
       {
         if (!empty($_SESSION[filtro_nombre]))
         { if ( $v_validar[1] ==$_SESSION[filtro_nombre]) {$inom=1;}
           if (stristr($v_validar[1],$_SESSION[filtro_nombre])<> FALSE) {$inom=1;;} }

         if (!empty($_SESSION[filtro_tipo_almacen]))
         { if ( $v_validar[0] ==$_SESSION[filtro_tipo_almacen]) {$iidc=1;}}


         IF ($illega <= ($inom+$iidc )) {$va="si";}
       }

       IF ($va =="si" )
       { $k++;
          echo "<tr><td ALIGN='RIGHT' id="."A"."$v_validar[0]>$v_validar[0]</td>";
          echo "<td id="."B"."$v_validar[0]>$v_validar[1]</td>";
          echo "<td ALIGN='CENTER' id="."C"."$v_validar[0]><img src='fotos/".$v_validar[2].".jpg' with='70' height='70'></td>";
          echo "<td id="."D"."$v_validar[0]>".$v_validar[2]."</td>";
          echo "</tr>" ;
          $va="no";
         
       }
   }
echo "<caption  color style='background:#99FF33'>";
echo 'Lista de Almacenes Orden x ';
switch ($orden) {
  case 'RSUP': {echo "Nombre Ascendente";break;}
  case 'RSDN': {echo "Nombre Descendente";break;}
	case 'IDUP': {echo "C&oacute;digo Ascendente";break;}
	case 'IDDN': {echo "C&oacute;digo Descendente";break;}
  default:  {echo "C&oacute;digo Ascendente";break;}
}
echo "</caption></table>";
echo "<a href='menu_1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";
echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";
echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
?>
</BODY>
</HTML>

