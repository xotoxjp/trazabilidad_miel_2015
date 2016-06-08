<?php
session_start();
include_once("funciones.php");
flag();
$_SESSION["level_req"]="z";
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
validar ($logg,$pass);
$nivel_dato=$_SESSION["acceso_acc"];


$contr="";
$boton="NO";


if ($_POST["Submit"]== "Volver") {      header("Location: menu_1.php") ; }
foreach ($_POST as $indice => $valor)
  {
   switch ($indice) {
    case 'ID': $id_usuario=$valor; break;
    }
  }
// $_SESSION[id_usuario]=$id_usuario;

$respuesta=$_SESSION["acceso_nombre"]=$tt;
$pref_imp=$respuesta;
$pref_imp=$_SESSION["pref_imp"];
$Respuesta=$pref_imp;
$Respu=$_SESSION["pref_co"];


foreach ($_POST as $indice => $valor){
   //echo "$indice: $valor"."()";
   if ($indice=="Volver_x")  {header("Location: menu_1.php") ;}
   if ($indice=="Salvar_x")  {$boton="Salvar";}
   switch ($indice) {
   case 'campo': $campo=$valor ; break;
   case 'orden': $orden=$valor ; break;
   case 'Respu': $Respu=$valor; break;
   case 'Respuesta': $respuesta=$valor; break;
   case 'filtro': $filtro=$valor; break;
   case 'Submit': $sub=$valor; break;
   case 'pref_imp': $pref_imp=$valor; break;
   }
}
// si hay filtros no hay limite porque los proceso despues
$Registros=$_REQUEST["Registros"];
$sub=".";
$Limite="";
?>
<head>
<TITLE>Editando</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
.hide {display:none;}
.show {display:block;}
</style>

<script type="text/javascript">
<!--
function ini() {
  var IdAry=['Ley1','Ley2'];
  for (var zxc0=0;zxc0<IdAry.length;zxc0++){
     if (el=document.getElementById(IdAry[zxc0])){
       el.onmouseover=function() { ilumi(this,true) }
       el.onmouseout=function() { ilumi(this,false) }}
  }


 var IdAry=['boton1','boton2'];
 for (var zxc0=0;zxc0<IdAry.length;zxc0++){
 var el=document.getElementById(IdAry[zxc0]);
 if (el){
   el.onmouseover=function() {
    changeText(this,'hide','show')
    }
   el.onmouseout=function() {
     changeText(this,'show','hide');
    }
  }
 }
}

function ilumi(obj,valor) {obj.style.background = (valor) ? 'yellow' : '';}
function ilumig(obj,valor) {obj.style.background = (valor) ? 'silver' : '';}

function changeText(obj,cl1,cl2) {
   obj.getElementsByTagName('SPAN')[0].className=cl1;
   obj.getElementsByTagName('SPAN')[1].className=cl2;
}


-->
</script>


<?

echo "<body onload='ini();'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='usuarios2.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

if ($boton=="Salvar"){
  $actualizar="update ".$_SESSION['tabla_acc']." set  pref_imp='".$respuesta."', pref_cp='".$Respu."'"  ;
  $actualizar=$actualizar."  where login='".$_SESSION["acceso_logg"]."'" ;
  mysql_query($actualizar,$cx_validar);
  echo $actualizar;
  $_SESSION["pref_imp"]=$respuesta;
  $_SESSION["pref_co"]=$Respu;
}


$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="select id_usuario,nombre,apellido,pref_imp from  ".$_SESSION["tabla_acc"]. " where login='".$_SESSION["acceso_logg"]."'" ;
$v1_validar = mysql_query($actualizar,$cx_validar);


while ($v_validar = mysql_fetch_array($v1_validar))
  {
    $id_usuario= $v_validar[0];
    $nombre= $v_validar[1];
    $apellido= $v_validar[2];
    $respuesta=$v_validar[3];
}
    echo '<table border="1" ><tr><td>';
    echo '<table border="1">';
    echo "<caption color style='background:#99FF33'> Preferencias del Operador ".$id_usuario." </caption>";
    echo "<tr><td colspan='2'>Hola ".$nombre.' '.$apellido."</td></tr>";
    echo  "<tr><td colspan='2'>Cuando seleccione Imprimir dentro del Programa desea que la salida vaya</td></tr>";
    echo  "<tr><td>";
    if ($respuesta=='Imp') {$t1=' CHECKED ';$t2='';} else {$t1='';$t2=' CHECKED ';}
    echo "<label id='Ley1'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT NAME='Respuesta' $t1 TYPE=RADIO VALUE='Imp' >Directamente a la Impresora</LABEL>";
    echo "</td><td rowspan='2'>";
    if ($respuesta=='Imp')
      {echo '<IMG SRC="fotos/impresora.gif" ALT="" WIDTH=80 HEIGHT=80>';}
    else
      {echo '<IMG SRC="fotos/display.jpg" ALT="" WIDTH=80 HEIGHT=80>';}
    echo "</td></tr>";
    echo  '<tr><td>';

    echo "<label id='Ley2'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT NAME='Respuesta' $t2 TYPE=RADIO VALUE='Pan' >Primero al Monitor</LABEL>";
    echo '</td><td></td></tr>';

    echo "<tr><td>";
    $t1='';$t2='';$t3='';$t4='';$ts=" SELECTED='SELECTED' ";
    switch ($Respu) {
      case 'codifica': $t1=$ts;break;
      case 'liberado': $t2=$ts;break;
      case 'contifa': $t3=$ts;break;
      case 'ayuda': $t4=$ts;break; }
    echo "&nbspComo se arma el renglon :&nbsp</td><td>";
    echo "<select name='Respu' id='Respu' onblur='muestro(this)'>";
    echo "<option value='codifica'$t1>Ingresando el Código de Producto</option>";
//    echo "<option value='liberado'$t2>Libre sólo se coloca precio y la descripción</option>";
    echo "<option value='contifa'$t3>Seleccionando el Proceso, Tipo y Familia</option>";
    echo "<option value='ayuda'$t4>con Ayuda para el Nombre del Producto y Código</option>";
    echo "</select></td></tr>";


    echo "</table>";



   echo "<INPUT TYPE=HIDDEN name='num_reg_desde'  value="."'".$_SESSION[reg_desde]."'>";
   echo "<INPUT TYPE=HIDDEN name='num_reg_hasta'  value="."'".$_SESSION[reg_hasta]."'>";
   echo "<INPUT TYPE=HIDDEN name='id_usuario'  value="."'".$id_usuario."'>";

   echo "<table border='2'  width='30%'><tr>";
   echo "<caption color style='background:#99FF33'> Acciones Definidas para el Usuario </caption>"     ;

   echo "<td><p id='boton1'>";
   echo "<span id='span1'>  <input name='Volver' type='image' img src='fotos/cerrar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Volver' type='image' img src='fotos/cerrar_activo_ch.jpg'  alt='Cierra la Pantalla y Vuelve a la Pantalla de Selección de Familias'></a></span>";
   echo "</p></td>";
   echo "<td><p id='boton2'>";
   echo "<span id='span1'>  <input name='Salvar' type='image' img src='fotos/guardar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Salvar' type='image' img src='fotos/guardar_activo_ch.jpg'  alt='Se Actualizan las Preferencias. Por favor Verifique antes de hacerlo'></a></span>";
   echo "</p></td>";
   echo "<td width='1'><INPUT TYPE='Submit' VALUE=''  id='ent' width='1'></td>";
   echo "</table>";
   echo "</form>";?>
</BODY>
</HTML>

