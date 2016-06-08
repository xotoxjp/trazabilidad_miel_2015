<?php
session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];

$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=4 and acceso="on"';
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
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='abm.de productos'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);
$desorden='Listado de Productos';
if (empty($_SESSION[filtro_primario])){$_SESSION[filtro_primario]="";}
if (empty($_SESSION[filtro_secundario])){$_SESSION[filtro_secundario]="";}
if (empty($_SESSION[filtro_terciario])){$_SESSION[filtro_terciario]="";}
if (empty($_SESSION[filtro_nombre])){$_SESSION[filtro_nombre]="";}
if (empty($_SESSION[filtro_nomenclador])){$_SESSION[filtro_nomenclador]="";}
if (empty($_SESSION[filtro_prod_id])){$_SESSION[filtro_prod_id]="";}
if (empty($_SESSION[filtro_contiene])){$_SESSION[filtro_contiene]="";}
if (empty($_SESSION[filtro_unidad])){$_SESSION[filtro_unidad]="";}

$sub=".";
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
if ($filtro !='       ')
{ $filtro = strtoupper($filtro);
  IF ( $campo == 'primario' )    {   $_SESSION["filtro_primario"]=$filtro; }
  IF ( $campo == 'secundario' ) {   $_SESSION["filtro_secundario"]=$filtro; }
  IF ( $campo == 'terciario' ) {   $_SESSION["filtro_terciario"]=$filtro; }
  IF ( $campo == 'prod_id' ) {   $_SESSION["filtro_prod_id"]=$filtro; }
  IF ( $campo == 'nombre' ) {   $_SESSION["filtro_nombre"]=$filtro; }
  IF ( $campo == 'nomenclador' ) {   $_SESSION["filtro_nomenclador"]=$filtro; }
  IF ( $campo == 'contiene' ) {   $_SESSION["filtro_contiene"]=$filtro; }
  IF ( $campo == 'unidad' ) {   $_SESSION["filtro_unidad"]=$filtro; }
  }
if ($_SESSION["reg_desde"]==1) {$_SESSION["reg_desde"]=0;}
if (empty($_SESSION[filtro_terciario]) && empty($_SESSION[filtro_secundario]) && empty($_SESSION[filtro_primario]) &&
    empty($_SESSION[filtro_nomenclador]) &&  empty($_SESSION[filtro_nombre]) &&  empty($_SESSION[filtro_prod_id]) && empty($_SESSION[filtro_contiene]) && empty($_SESSION["filtro_unidad"]))
          { $t=0+$_SESSION["reg_desde"]+$_SESSION["reg_hasta"];
            $Limite= ' LIMIT '.$_SESSION["reg_desde"].','.$t ;}

?>
<head>
<TITLE>  TABLA DE PRODUCTOS  </TITLE>
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
  for (i=46; ele=tab.getElementsByTagName('td')[i]; i++) {
    ele.onclick = function() {seteo(this,i,colu,tx );}
    ele.onmouseover = function() {iluminar(this,true);}
    if (k==0) ele.onmouseout = function() {iluminari(this);}
    if (k==1) ele.onmouseout = function() {iluminarp(this);}
    j++
    if (j==colu)
     {j=0;
      if (k!=1)
       {k++;}
      else
       {k=0;}
     }
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
  for (i1=46; ele1=tab.getElementsByTagName('td')[i1]; i1=i1+k1) {
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
echo "<body onload='ini(9); poner1(9);'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='mod_productos1.php' >";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a="select * from  ".$_SESSION["tabla_productos"];
$d=$desorden.' ordernado x ';
switch ($orden) {
	case 'CAUP':{$a=$a." ORDER BY contiene "; $d=$d.'';$d=$d.'Contenido Ascendente';break;}
	case 'CADN':{$a=$a." ORDER BY contiene DESC";$d=$d.'Contenido Descendente';$d=$d.'';break;}
	case 'PRUP':{$a=$a." ORDER BY nombre ";$d=$d.'Nombre Ascendente';break;}
	case 'PRDN':{$a=$a." ORDER BY nombre DESC";$d=$d.'Nombre Descendente';break;}
  case 'NMUP':{$a=$a." ORDER BY nomenclador ";$d=$d.'Nomenclador Ascendente';break;}
  case 'NMDN':{$a=$a." ORDER BY nomenclador DESC";$d=$d.'Nomenclador Descendente';break;}
	case 'RSUP':{$a=$a." ORDER BY primario ";$d=$d.'Primario Ascendente';break;}
	case 'RSDN':{$a=$a." ORDER BY primario DESC ";$d=$d.'Primario Descendente';break;}
	case 'DIUP':{$a=$a." ORDER BY secundario ";$d=$d.'Secundario Ascendente';break;}
	case 'DIDN':{$a=$a." ORDER BY secundario DESC";$d=$d.'Secundario Descendente';break;}
	case 'LOUP':{$a=$a." ORDER BY terciario ";$d=$d.'Terciario Ascendente';break;}
  case 'LODN':{$a=$a." ORDER BY terciario DESC ";$d=$d.'Terciario Descendente';break;}
	case 'IDUP':{$a=$a." ORDER BY prod_id ";$d=$d.'Prod. ID Ascendente';break;}
	case 'IDDN':{$a=$a." ORDER BY prod_id DESC";$d=$d.'Prod. ID Descendente';break;}
	case 'UNUP':{$a=$a." ORDER BY unidad ";$d=$d.'Unidad Ascendente';break;}
	case 'UNDN':{$a=$a." ORDER BY unidad DESC ";$d=$d.'Unidad Descendente';break;}
  case 'COUP':{$a=$a." ORDER BY contiene ";$d=$d.'Contenido Ascendente';break;}
  case 'CODN':{$a=$a." ORDER BY contiene DESC ";$d=$d.'Contenido Descendente';break;}
  default:{$a=$a." ORDER BY prod_id ";$d=$d.'Prod. ID Ascendente';break;}
}
$actualizar=$a;$desorden=$d;
$rs_validar = mysql_query($actualizar,$cx_validar);
echo "<table border='1' id='tabla'>" ;
// coloco la linea de los filtros
echo "<tr bgcolor='#FFFFFF'><td><a href='menu_1.php'><img src='fotos/ARW03LT.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a></td>";
echo '<td>';
if (empty($_SESSION["filtro_nombre"])) { echo 'Filtro';} else { echo $_SESSION["filtro_nombre"];}
echo '</td><td>';
if (empty($_SESSION["filtro_nomenclador"])) { echo 'Filtro';} else { echo $_SESSION["filtro_nomenclador"];}
echo '</td><td align="center" colspan="3">Envases</td><td>Contiene</td><td>Unidad';
echo '</td><td rowspan="2">Peso<br>en Kgr.';
echo '</tr>';

echo '<td><table><td width=10%>';
echo "<a href='productos1.php?orden=IDUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=prod_id'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='productos1.php?orden=IDDN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';

echo "<td><table ><td width=90% aling'center' >Nombre del Producto</td>";
echo '<td width=10%>';
echo "<a href='productos1.php?orden=PRUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=nombre'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='productos1.php?orden=PRDN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='20' height='20' border='0'></a>";
echo '</td></table></td>';

echo "<td><table ><td width=90% aling'center' >Nomenclador</td>";
echo '<td width=10%>';
echo "<a href='productos1.php?orden=NMUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=nomenclador'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='productos1.php?orden=NMDN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='20' height='20' border='0'></a>";
echo '</td></table></td>';

echo "<td><table><td width=90% aling'center' >";
if (!empty($_SESSION[filtro_primario])) {echo $_SESSION[filtro_primario];}
else {echo "Primario";}
echo "</td>";
echo '<td width=10%>';
echo "<a href='productos1.php?orden=RSUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=primario'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='productos1.php?orden=RSDN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='10' height='15 border='0'></a>";
echo '</td></table></td>';

echo "<td><table><td width=90% aling'center' >";
if (!empty($_SESSION[filtro_secundario])) {echo $_SESSION[filtro_secundario];}
else {echo "Secundario";}
echo "</td>";
echo '<td width=10%>';
echo "<a href='productos1.php?orden=DIUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=secundario'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='productos1.php?orden=DIDN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';


echo "<td><table><td width=90% aling'center' >";
if (!empty($_SESSION[filtro_terciario])) {echo $_SESSION[filtro_terciario];}
else {echo "Terciario";}
echo "</td>";


echo '<td width=10%>';
echo "<a href='productos1.php?orden=LOUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=terciario'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='productos1.php?orden=LODN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';


echo "<td><table><td width=90% aling'center' >";
if (!empty($_SESSION[filtro_contiene])) {echo $_SESSION[filtro_contiene];}
echo "</td>";


echo '<td width=10%>';
echo "<a href='productos1.php?orden=COUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=contiene'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='productos1.php?orden=CODN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';

echo "<td><table><td width=90% aling'center' >";
if (!empty($_SESSION[filtro_unidad])) {echo $_SESSION[filtro_unidad];}
echo "</td>";



echo '<td width=10%>';
echo "<a href='productos1.php?orden=UNUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=unidad'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='productos1.php?orden=UNDN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';



echo '</tr>';


if (isset($SESSION[idc])){$i=$_SESSION[idc];}

$j=0;$k=0; $inom=0;$idir=0;$iloc=0;$iidc;$illega=0;;$ipro=0;;$icap=0;$icp=0;
if (!empty($_SESSION[filtro_primario]))    {$illega++;}
if (!empty($_SESSION[filtro_secundario]))        {$illega++;}
if (!empty($_SESSION[filtro_terciario]))     {$illega++;}
if (!empty($_SESSION[filtro_prod_id])) {$illega++;}
if (!empty($_SESSION[filtro_nombre]))    {$illega++;}
if (!empty($_SESSION[filtro_nomenclador]))    {$illega++;}
if (!empty($_SESSION[filtro_contiene]))   {$illega++;}
if (!empty($_SESSION[unidad]))   {$illega++;}

while ($v_validar = mysql_fetch_array($rs_validar))
   {   $j++;$va="no"; $inom=0;$idir=0;$iloc=0;$iidc=0;$ipro=0;;$icap=0;$inomcl=0;
       if (empty($_SESSION[filtro_unidad]) && empty($_SESSION[filtro_primario]) && empty($_SESSION[filtro_secundario]) && empty($_SESSION[filtro_terciario])&& empty($_SESSION[filtro_prod_id]) && empty($_SESSION[filtro_nomenclador])  && empty($_SESSION[filtro_nombre])  && empty($_SESSION[filtro_contiene]))
          {
          $va="si";}
       else
       {
         if (!empty($_SESSION[filtro_primario]))
         { if ( $v_validar[12] ==$_SESSION[filtro_primario]) {$inom=1;}
           if (stristr($v_validar[12],$_SESSION[filtro_primario])<> FALSE) {$inom=1;;} }

         if (!empty($_SESSION[filtro_secundario]))
         { if ( $v_validar[13] == $_SESSION[filtro_secundario]) {$idir=1;;}
           if (stristr($v_validar[13],$_SESSION[filtro_secundario])<> FALSE) {$idir=1;}}

         if (!empty($_SESSION[filtro_terciario]))
         { if ( $v_validar[14] ==$_SESSION[filtro_terciario]) {$iloc=1;}
           if (stristr($v_validar[14],$_SESSION[filtro_terciario])<> FALSE) {$iloc=1;} }

         if (!empty($_SESSION[filtro_prod_id]))
         { if ( $v_validar[0] ==$_SESSION[filtro_prod_id]) {$iidc=1;}}

         if (!empty($_SESSION[filtro_nombre]))
         { if ( $v_validar[2] ==$_SESSION[filtro_nombre]) {$ipro=1;}
           if (stristr($v_validar[2],$_SESSION[filtro_nombre])<> FALSE) {$ipro=1;} }

         if (!empty($_SESSION[filtro_nomenclador]))
         { if ( $v_validar[3] ==$_SESSION[filtro_nomenclador]) {$inomcl=1;}
           if (stristr($v_validar[3],$_SESSION[filtro_nomenclador])<> FALSE) {$inomcl=1;} }

         if (!empty($_SESSION[filtro_contiene]))
         { if ( $v_validar[11] ==$_SESSION[filtro_contiene]) {$icap=1;}
           if (stristr($v_validar[10],$_SESSION[filtro_contiene])<> FALSE) {$icap=1;} }

         if (!empty($_SESSION[filtro_unidad]))
         { if ( $v_validar[37] ==$_SESSION[filtro_unidad]) {$icp=1;}
           if (stristr($v_validar[11],$_SESSION[filtro_unidad])<> FALSE) {$icp=1;} }


         IF ($illega <= ($iloc+$idir+$inom+$iidc+$ipro+$icap+$icp+$inomcl )) {$va="si";}
       }

       IF ($va =="si" )
       { $k++;
          $va="no";
       }
   }
   echo "<caption  color style='background:#99FF33'>".$desorden;
echo "&nbsp;&nbsp;&nbsp;Datos Leídos&nbsp;".$j;
if ( ($k > 0) && ($k!=$j) ) { echo "&nbsp;&nbsp;Coinciden&nbsp;".$k;}


$rs_validar = mysql_query($actualizar,$cx_validar);

if (isset($SESSION[idc])){$i=$_SESSION[idc];}

$j=0;$k=0; $inom=0;$idir=0;$iloc=0;$iidc;$illega=0;;$ipro=0;;$icap=0;$icp=0;
if (!empty($_SESSION[filtro_primario]))    {$illega++;}
if (!empty($_SESSION[filtro_secundario]))        {$illega++;}
if (!empty($_SESSION[filtro_terciario]))     {$illega++;}
if (!empty($_SESSION[filtro_prod_id])) {$illega++;}
if (!empty($_SESSION[filtro_nombre]))    {$illega++;}
if (!empty($_SESSION[filtro_nomenclador]))    {$illega++;}
if (!empty($_SESSION[filtro_contiene]))   {$illega++;}
if (!empty($_SESSION[filtro_unidad]))   {$illega++;}

while ($v_validar = mysql_fetch_array($rs_validar))
   {   $j++;$va="no"; $inom=0;$idir=0;$iloc=0;$iidc=0;$ipro=0;;$icap=0; $icp=0;$inomcl=0;
       if (empty($_SESSION[filtro_unidad]) && empty($_SESSION[filtro_primario]) && empty($_SESSION[filtro_secundario]) && empty($_SESSION[filtro_terciario])&& empty($_SESSION[filtro_prod_id]) && empty($_SESSION[filtro_nomenclador]) && empty($_SESSION[filtro_nombre])  && empty($_SESSION[filtro_contiene]))
          {
          $va="si";}
       else
       {
         if (!empty($_SESSION[filtro_primario]))
         { if ( $v_validar[12] ==$_SESSION[filtro_primario]) {$inom=1;}
           if (stristr($v_validar[12],$_SESSION[filtro_primario])<> FALSE) {$inom=1;;} }

         if (!empty($_SESSION[filtro_secundario]))
         { if ( $v_validar[13] == $_SESSION[filtro_secundario]) {$idir=1;;}
           if (stristr($v_validar[13],$_SESSION[filtro_secundario])<> FALSE) {$idir=1;}}

         if (!empty($_SESSION[filtro_terciario]))
         { if ( $v_validar[14] ==$_SESSION[filtro_terciario]) {$iloc=1;}
           if (stristr($v_validar[14],$_SESSION[filtro_terciario])<> FALSE) {$iloc=1;} }

         if (!empty($_SESSION[filtro_prod_id]))
         { if ( $v_validar[0] ==$_SESSION[filtro_prod_id]) {$iidc=1;}}

         if (!empty($_SESSION[filtro_nombre]))
         { if ( $v_validar[2] ==$_SESSION[filtro_nombre]) {$ipro=1;}
           if (stristr($v_validar[2],$_SESSION[filtro_nombre])<> FALSE) {$ipro=1;} }

         if (!empty($_SESSION[filtro_nomenclador]))
         { if ( $v_validar[3] ==$_SESSION[filtro_nomenclador]) {$inomcl=1;}
           if (stristr($v_validar[3],$_SESSION[filtro_nomenclador])<> FALSE) {$inomcl=1;} }

         if (!empty($_SESSION[filtro_contiene]))
         { if ( $v_validar[11] ==$_SESSION[filtro_contiene]) {$icap=1;}
           if (stristr($v_validar[10],$_SESSION[filtro_contiene])<> FALSE) {$icap=1;} }

         if (!empty($_SESSION[filtro_unidad]))
         { if ( $v_validar[37] ==$_SESSION[filtro_unidad]) {$icp=1;}
           if (stristr($v_validar[11],$_SESSION[filtro_unidad])<> FALSE) {$icp=1;} }


         IF ($illega <= ($iloc+$idir+$inom+$iidc+$ipro+$icap+$icp+$inomcl )) {$va="si";}
       }

       IF ($va =="si" )
       { $k++;
         echo "<tr><td ALIGN='RIGHT' id="."A"."$v_validar[0]> $v_validar[0]</td>";
         echo "<td id="."B"."$v_validar[0]>$v_validar[1]</td>";
         echo "<td id="."C"."$v_validar[0]>$v_validar[3]</td>";
         echo "<td id="."D"."$v_validar[0]>$v_validar[12]</td>";
         echo "<td id="."E"."$v_validar[0]>$v_validar[13]</td>";
         echo "<td id="."F"."$v_validar[0]>$v_validar[14]</td>";
         echo "<td align='right' id="."G"."$v_validar[0]>".number_format($v_validar[10], 0, ",", ".")."</td>";
         echo "<td align='center' id="."H"."$v_validar[0]>$v_validar[11]</td>";
         echo "<td align='right' id="."I"."$v_validar[0]>".number_format($v_validar[9], 2, ",", ".")."</td>";
         echo "</td></tr>" ;
       }
          $va="no";
}
echo "</caption></table>";
echo "<a href='menu_1.php'><img src='fotos/ARW03LT.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";
echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";
echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
?>
</BODY>
</HTML>

