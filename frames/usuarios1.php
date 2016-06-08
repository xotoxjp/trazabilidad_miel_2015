<?php
session_start();
include_once("funciones.php");
if (empty($_SESSION["reg_desde"])) {$_SESSION["reg_desde"]="0";}
if (empty($_SESSION["reg_hasta"])) {$_SESSION["reg_hasta"]="100";}

// si hay filtros no hay limite porque los proceso despues
$Registros=$_REQUEST["Registros"];
if ($registros==0) {$registros=120;}
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
  IF ( $campo == 'nombre' ) {$_SESSION["filtro_nombre"]=$filtro; }
  IF ( $campo == 'apellido' ) {$_SESSION["filtro_apellido"]=$filtro; }
  IF ( $campo == 'id_usuario' )  {$_SESSION["filtro_id_usuario"]=$filtro; }
}
if ( $sub == 'Volver' )
    { }
else {
if ($_SESSION["reg_desde"]==1) {$_SESSION["reg_desde"]=0;}
if (empty($_SESSION[filtro_mes_arranque]) &&  empty($_SESSION[filtro_nombre]) && empty($_SESSION[filtro_direccion]) && empty($_SESSION[filtro_localidad])&& empty($_SESSION[filtro_id_cliente]) && empty($_SESSION[filtro_id_operador]))
          { $t=0+$_SESSION["reg_desde"]+$_SESSION["reg_hasta"];
            $Limite= ' LIMIT '.$_SESSION["reg_desde"].','.$t ;}}
?>
<head>
<TITLE>OPERADORES</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
#ent {display: none;}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
}
body {
  font-family:Arial;
  font-size:12pt;     
}
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
  for (i=25; ele=tab.getElementsByTagName('td')[i]; i++) {
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
  for (i1=25; ele1=tab.getElementsByTagName('td')[i1]; i1=i1+k1) {
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

<link rel='shortcut icon' href='fotos/icono1.ico'>
</head>

<?
echo "<body onload='ini(7); poner1(7);'>";
echo "<form name='formulario' method='POST' action='mod_usuario1.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
if ($orden == ".")
  { $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ; }
else {
   switch ($orden) {
	case 'RSUP':{$actualizar="ALTER TABLE ".$_SESSION["tabla_acc"] ." ORDER BY nombre ";
       $rs_validar = mysql_query($actualizar,$cx_validar);
       $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ;
       break;
	  }
	case 'RSDN':{ $actualizar="ALTER TABLE ".$_SESSION["tabla_acc"] ." ORDER BY nombre DESC";
       $rs_validar = mysql_query($actualizar,$cx_validar);
       $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ;
       break;}
	case 'DIUP':{$actualizar="ALTER TABLE ".$_SESSION["tabla_acc"] ." ORDER BY apellido ";
       $rs_validar = mysql_query($actualizar,$cx_validar);
       $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ;
       break;
	  }
	case 'DIDN':{ $actualizar="ALTER TABLE ".$_SESSION["tabla_acc"] ." ORDER BY apellido DESC";
       $rs_validar = mysql_query($actualizar,$cx_validar);
       $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ;
       break;}
	case 'LOUP':{$actualizar="ALTER TABLE ".$_SESSION["tabla_acc"] ." ORDER BY email ";
       $rs_validar = mysql_query($actualizar,$cx_validar);
       $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ;
       break;
	  }
	case 'LODN':{ $actualizar="ALTER TABLE ".$_SESSION["tabla_acc"] ." ORDER BY email DESC";
       $rs_validar = mysql_query($actualizar,$cx_validar);
       $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ;
       break;}
	case 'IDUP':{$actualizar="ALTER TABLE ".$_SESSION["tabla_acc"] ." ORDER BY id_usuario ASC ";
       $rs_validar = mysql_query($actualizar,$cx_validar);
       $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ;
       break;
	  }
	case 'IDDN':{ $actualizar="ALTER TABLE ".$_SESSION["tabla_acc"] ." ORDER BY id_usuario DESC";
       $rs_validar = mysql_query($actualizar,$cx_validar);
       $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ;
       break;}

    default:
       { $actualizar="ALTER TABLE ".$_SESSION["tabla_acc"] ." ORDER BY id_usuario ASC";
       $rs_validar = mysql_query($actualizar,$cx_validar);
       $actualizar="select * from  ".$_SESSION["tabla_acc"].$Limite ;
       break;}
 }}

$rs_validar = mysql_query($actualizar,$cx_validar);

echo "<table border='0' id='tabla'>" ;
// coloco la linea de los filtros
echo "<tr bgcolor='#FFFFFF'><td><a href='menu_1.php'><img src='fotos/salir.png' alt='Volver' aling'left' width='20' height='20' border='0'></a></td>";
echo '<td>';
if (empty($_SESSION["filtro_nombre"])) {echo 'Nombre del usuario';} else { echo $_SESSION["filtro_nombre"];}
echo '</td><td>';
if (empty($_SESSION["filtro_apellido"])) { echo 'Apellido';} else { echo $_SESSION["filtro_apellido"] ;}
echo "</td><td>&nbsp</td>";

echo  '<td>Desde el  ';
echo "<input name='num_reg_desde' type='text'  value="."'".$_SESSION[reg_desde]."'"."  SIZE='4'  maxlength='5' aling='RIGHT'> </td>";
echo  '<td>tomo  ';
echo "<input name='num_reg_hasta' type='text'  value="."'".$_SESSION[reg_hasta]."'"."  SIZE='4'  maxlength='5' ></td>";
echo '<td>Operador</td></tr>';

echo '<td><table><td width=10%>';
echo "<a href='usuarios1.php?orden=IDUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=id_usuario'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='10' height='15' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='usuarios1.php?orden=IDDN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='10' height='15' border='0'></a>";
echo '</td></table></td>';

echo "<td><table><td width=90% aling'center' >Filtro</td>";
echo '<td width=10%>';
echo "<a href='usuarios1.php?orden=RSUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=nombre'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='usuarios1.php?orden=RSDN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='20' height='20' border='0'></a>";
echo '</td></table></td>';

echo "<td><table><td width=90% aling'center' >Filtro</td>";
echo '<td width=10%>';
echo "<a href='usuarios1.php?orden=DIUP'><img src='fotos/up.ico' alt='Ver x Orden Ascendente'  aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a  href='filtro.php?campo=apellido'><img src='fotos/browse.gif' alt='Busqueda' aling'left' width='20' height='20' border='0'></a>";
echo '</td><td width=10%>';
echo "<a href='usuarios1.php?orden=DIDN'><img src='fotos/down.ico' alt='Ver x Orden Descendente' aling'left' width='20' height='20' border='0'></a>";
echo '</td></table></td>';

echo "<td>email</td>";
echo "<td>login</td>" ;
echo "<td>Entró el</td><td>de Campo</td></tr>" ;



if (isset($_SESSION["id_cli"])){
$i=$_SESSION["id_cli"];
}
else {
$i=0;
}
if (isset($SESSION[idc])){$i=$_SESSION[idc];}

$j=0;$k=0; $inom=0;$idir=0;$iloc=0;$iidc;$illega=0;
if (!empty($_SESSION[filtro_nombre]))    {$illega++;}
if (!empty($_SESSION[filtro_apellido])) {$illega++;}
if (!empty($_SESSION[filtro_id_usuario])) {$illega++;}

while ($v_validar = mysql_fetch_array($rs_validar))
   {
       $j++;$va="no"; $inom=0;$idir=0;$iloc=0;$iidc=0;
       if (empty($_SESSION[filtro_nombre]) && empty($_SESSION[filtro_apellido]) && empty($_SESSION[filtro_id_usuario]))
          {$va="si";}
       else
       {
         if (!empty($_SESSION[filtro_nombre]))
         { if ( $v_validar[1] ==$_SESSION[filtro_nombre]) {$inom=1;}
           if (stristr($v_validar[1],$_SESSION[filtro_nombre])<> FALSE) {$inom=1;;} }

         if (!empty($_SESSION[filtro_apellido]))
         { if ( $v_validar[2] == $_SESSION[filtro_apellido]) {$idir=1;;}
           if (stristr($v_validar[2],$_SESSION[filtro_apellido])<> FALSE) {$idir=1;}}

         if (!empty($_SESSION[filtro_id_usuario]))
         { if ( $v_validar[0] ==$_SESSION[filtro_id_usuario]) {$iidc=1;}}


         IF ($illega <= ($iloc+$idir+$inom+$iidc )) {$va="si";}
       }

       IF ($va =="si" )
       { $k++;
         if ($k<($_SESSION[reg_desde]+ $_SESSION[reg_hasta])) {
           if ($k>=$_SESSION[reg_desde]) {
             echo "<tr><td ALIGN='RIGHT' id="."A"."$v_validar[0]> $v_validar[0]</td>";
             echo "<td id="."B"."$v_validar[0]> $v_validar[1]</td><td id="."C"."$v_validar[0]> $v_validar[2]</td><td id="."D"."$v_validar[0]> $v_validar[3] </td><td id="."E"."$v_validar[0]> $v_validar[4] </td></td><td id="."F"."$v_validar[0]> $v_validar[10] </td><td id="."G"."$v_validar[0] align='center'> $v_validar[21] </td></tr>" ;
           $va="no";}
         }
       }
   }
echo "<caption  color style='background:#99FF33'>";
   switch ($orden) {
    case 'RSUP': {echo "Listado de usuarios Ordenado por Descripción Ascendente";break;}
    case 'RSDN': {echo "Listado de usuarios Ordenado por Descripción Descendente";break;}
    case 'DIUP': {echo "Listado de usuarios Ordenado por apellido Ascendente";break;}
	case 'DIDN': {echo "Listado de usuarios Ordenado por apellido Descendente";break;}
	case 'LOUP': {echo "Listado de usuarios Ordenado por Vencimiento Recarga Ascendente";break;}
	case 'LODN': {echo "Listado de usuarios Ordenado por Vencimiento Recarga Descendente";break;}
    default:  {echo "Listado de usuario Ordenado por C&oacute;digo de usuario Ascendente";break;}}
echo ".  .  . Se leyeron ".$j." registros";
if ( ($k > 0) && ($k!=$j) ) {echo " y coinciden " .$k;}
echo "</caption></table>";
echo "<a href='menu_1.php'><img src='fotos/salir.png' alt='Volver' aling'left' width='20' height='20' border='0'></a>";
echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";
echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
?>
</BODY>
</HTML>

