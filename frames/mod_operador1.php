<?php
session_start();
include_once("funciones.php");
$_SESSION["level_req"]="f";
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
validar ($logg,$pass);
$nivel_dato=$_SESSION["acceso_acc"];

$contr="";
$boton="NO";
if ($_POST["ID"]=="NA")
{ $_SESSION[reg_desde]= $_POST["num_reg_desde"];
  $_SESSION[reg_hasta]= $_POST["num_reg_hasta"];
  header("Location: operadores1.php");}

if ($_POST["Submit"]== "Volver") {      header("Location: operadores1.php") ; }
foreach ($_POST as $indice => $valor)
  {// echo $indice . " " .$valor;
   switch ($indice) {
    case 'ID': $id_operador=$valor; break;
    }
  }
if (strlen($id_operador)>1) {
  if (substr($id_operador,0,1)>':') {$id_operador=substr($id_operador,1); $_SESSION[id_operador]=$id_operador; }}

foreach ($_POST as $indice => $valor){
 //echo "$indice: $valor"."()";
   if ($indice=="Volver_x")  {header("Location: operadores1.php") ;}
   if ($indice=="Salvar_x")  {$boton="Salvar";}
   if ($indice=="Imprimir_x"){$boton="Imprimir";}
   if ($indice=="Alta_x")    {$boton="Alta";}
   if ($indice=="Baja_x")    {$boton="Baja";}
   switch ($indice) {
   case 'ID': $id_operador=$valor; break;
   case 'campo': $campo=$valor ; break;
   case 'orden': $orden=$valor ; break;
   case 'filtro': $filtro=$valor; break;
   case 'Submit': $sub=$valor; break;
   case 'descripcion': $descripcion=$valor; break;
   case 'abreviatura': $abreviatura= $valor; break;
   case 'contr': $contr=$valor; $contr=substr($contr,0,4);$contr=trim($contr);$contr=strtoupper($contr); break;
   case 'p_rec_otro': $p_rec_otro=$valor; break;
   case 'p_rec_viejo': $p_rec_viejo=$valor; break;
   case 'p_rec_nuevo': $p_rec_nuevo=$valor; break;
   case 'p_vta_otro': $p_vta_otro=$valor; break;
   case 'p_vta_viejo': $p_vta_viejo=$valor; break;
   case 'p_vta_nuevo': $p_vta_nuevo=$valor; break;
   }
}

if ($boton=="Baja")
  {  if ($contr=="BAJA")
      {  $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
         mysql_select_db($_SESSION["base_acc"]);
         $actualizar="DELETE from  ".$_SESSION["tabla_operadores"]." where id_operador=".$id_operador ;
         $rs_validar = mysql_query($actualizar,$cx_validar); header("Location: operadores1.php") ;
      }
       else
      {  echo "Para borrar este Item coloque en el Código de Seguridad la palabra BAJA   ";  }
  
  }

include_once("funciones.php");
// si hay filtros no hay limite porque los proceso despues
$Registros=$_REQUEST["Registros"];
$sub=".";
$orden=$_REQUEST["orden"];
foreach ($_GET as $indice => $valor)
{ //echo "$indice: $valor<br>";
  switch ($indice) {
   case 'descripcion': $descripcion=$valor; break;
   case 'abreviatura': $abreviatura=$valor ; break;
   case 'p_rec_otro': $p_rec_otro=$valor ; break;
   case 'p_rec_viejo': $p_rec_viejo=$valor ; break;
   case 'p_rec_nuevo': $p_rec_nuevo=$valor ; break;
   case 'p_vta_otro': $p_rec_otro=$valor ; break;
   case 'p_vta_viejo': $p_rec_viejo=$valor ; break;
   case 'p_vta_nuevo': $p_rec_nuevo=$valor ; break;
}}

if (strlen($id_operador)>1) {
  if (substr($id_operador,0,1)>':') {$id_operador=substr($id_operador,1);}}
$Limite="";
?>
<head>
<?
echo "<TITLE>Editando Operador".$id_operador."</TITLE>";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
.hide {display:none;}
.show {display:block;}
</style>

<script type="text/javascript">
<!--
function ini() {
 var IdAry=['boton1','boton2','boton3','boton4','boton5'];
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


function changeText(obj,cl1,cl2) {
   obj.getElementsByTagName('SPAN')[0].className=cl1;
   obj.getElementsByTagName('SPAN')[1].className=cl2;
}


function muestrol(elemento)
 {
  tx=document.getElementById('Eleccion');
  tx.value="CHCL";
  btn=document.getElementById('ent');
  btn.click();
 }
function muestro(elemento)
 {
  tx=document.getElementById('Eleccion');
  tx.value="CHCP";
  btn=document.getElementById('ent');
  btn.click();
 }
 
 function  validacion(){
   var elemento = document.getElementById("NRO_CUIT").value;
   var lista = document.getElementById("COD_IVA");
   var indiceSeleccionado = lista.selectedIndex;
   var iva = lista.options[indiceSeleccionado];
   return true;
   }
function vd(){
   if (iva.text=="CF"){elemento.value="99-99999999-9"; return true;}
   if (iva.text=="SIN"){elemento.value="99-99999999-9";return true;}
   }
-->
</script>
<?

echo "<body onload='ini();'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='mod_operador1.php'>";

$_SESSION[idc]=$id_operador;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

if ($boton=="Salvar"){
  $actualizar="update ".$_SESSION['tabla_operadores']." set  Descripcion='".$descripcion."'" ;
  $actualizar=$actualizar." ,Abreviatura='".$abreviatura."'";
  $actualizar=$actualizar." ,p_rec_otro='".$p_rec_otro."'";
  $actualizar=$actualizar." ,p_rec_viejo='".$p_rec_viejo."'";
  $actualizar=$actualizar." ,p_rec_nuevo='".$p_rec_nuevo."'";
  $actualizar=$actualizar." ,p_vta_otro='".$p_vta_otro."'";
  $actualizar=$actualizar." ,p_vta_viejo='".$p_vta_viejo."'";
  $actualizar=$actualizar." ,p_vta_nuevo='".$p_vta_nuevo."'";
  $actualizar=$actualizar."  where id_operador=".$id_operador ;

  mysql_query($actualizar,$cx_validar);
}

if ($boton=="Alta") {
  $actualizar="INSERT INTO ".$_SESSION["tabla_operadores"]." (`Descripcion`, `Abreviatura`, ";
  $actualizar=$actualizar." `p_rec_otro`, `p_rec_viejo`, `p_rec_nuevo`, ";
  $actualizar=$actualizar." `p_vta_otro`, `p_vta_viejo`, `p_vta_nuevo` ) ";
  $actualizar=$actualizar." VALUES ('" .$descripcion . "', '" .$abreviatura."',";
  $actualizar=$actualizar." '" .$p_rec_otro . "', '" .$p_rec_viejo . "', '" .$p_rec_nuevo . "',  ";
  $actualizar=$actualizar." '" .$p_vta_otro . "', '" .$p_vta_viejo . "', '" .$p_vta_nuevo . "' )";
  echo $actualizar;
  $rs_validar = mysql_query($actualizar,$cx_validar);
  $actualizar="SELECT max( id_operador ) from ".$_SESSION["tabla_operadores"];
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$id_operador= $v_validar[0];}
}

$actualizar="select * from  ".$_SESSION["tabla_operadores"]. " where id_operador=".$id_operador ;
$rs_validar = mysql_query($actualizar,$cx_validar);
while ($v_validar = mysql_fetch_array($rs_validar))
  {
    $id_operador= $v_validar[0];
    $descripcion= $v_validar[1];
    $abreviatura= $v_validar[2];
    $p_rec_otro= $v_validar[3];
    $p_rec_viejo= $v_validar[4];
    $p_rec_nuevo= $v_validar[5];
    $p_vta_otro= $v_validar[6];
    $p_vta_viejo= $v_validar[7];
    $p_vta_nuevo= $v_validar[8];

}

    echo '<table border="1" ><tr><td>';
    echo '<table border="1">';
    echo "<caption color style='background:#99FF33'> Datos del Operador ".$id_operador." </caption>";
    echo '<tr>';
    echo  '<td>Nombre del Operador</td>';
    echo "<td><input name='descripcion' type='text'  value="."'".$descripcion."'"."  size='40' maxlength='40' > </td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Abreviatura</td>';
    echo "<td><input name='abreviatura' type='text' id=abrev  value="."'".$abreviatura."'"." size='10' maxlength='10' > </td>";
    
    echo '<tr>';
    echo  '<td>Porcentaje Recarga Otro</td>';
    echo "<td><input name='p_rec_otro' type='text' id=p_rec_otro value="."'".$p_rec_otro."'"." size='10' maxlength='10' > </td>";
    echo '<tr>';
    echo  '<td>Porcentaje Recarga Viejo</td>';
    echo "<td><input name='p_rec_viejo' type='text' id=p_rec_viejo  value="."'".$p_rec_viejo."'"." size='10' maxlength='10' > </td>";
    echo '<tr>';
    echo  '<td>Porcentaje Recarga Nuevo</td>';
    echo "<td><input name='p_rec_nuevo' type='text' id=p_rec_nuevo  value="."'".$p_rec_nuevo."'"." size='10' maxlength='10' > </td>";
    echo '<tr>';
    echo  '<td>Porcentaje Venta Otro</td>';
    echo "<td><input name='p_vta_otro' type='text' id=p_vta_otro  value="."'".$p_vta_otro."'"." size='10' maxlength='10' > </td>";
    echo '<tr>';
    echo  '<td>Porcentaje Venta Viejo</td>';
    echo "<td><input name='p_vta_viejo' type='text' id=p_vta_viejo  value="."'".$p_vta_viejo."'"." size='10' maxlength='10' > </td>";
    echo '<tr>';
    echo  '<td>Porcentaje Venta Nuevo</td>';
    echo "<td><input name='p_vta_nuevo' type='text' id=p_vta_nuevo  value="."'".$p_vta_nuevo."'"." size='10' maxlength='10' > </td>";

    echo '</tr>';
   echo "</table>";
   if ($boton=="Baja"){echo "<br>Código de Seguridad "."<INPUT TYPE=INPUT name='contr' value=" ."'".$contr."'>";}


   echo "<INPUT TYPE=HIDDEN name='num_reg_desde'  value="."'".$_SESSION[reg_desde]."'>";
   echo "<INPUT TYPE=HIDDEN name='num_reg_hasta'  value="."'".$_SESSION[reg_hasta]."'>";
   echo "<INPUT TYPE=HIDDEN name='id_operador'  value="."'".$id_operador."'>";

   echo "<table border='2'  width='30%'><tr>";
   echo "<caption color style='background:#99FF33'> Acciones Definidas para el Usuario </caption>"     ;

   echo "<td><p id='boton1'>";
   echo "<span id='span1'>  <input name='Volver' type='image' img src='fotos/cerrar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Volver' type='image' img src='fotos/cerrar_activo_ch.jpg'  alt='Cierra la Pantalla y Vuelve a la Pantalla de Selección de Tipos'></a></span>";
   echo "</p></td>";
   echo "<td><p id='boton2'>";
   echo "<span id='span1'>  <input name='Salvar' type='image' img src='fotos/guardar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Salvar' type='image' img src='fotos/guardar_activo_ch.jpg'  alt='Se Actualizan los Datos de la Tipo. Por favor Verifique antes de hacerlo'></a></span>";
   echo "</p></td>";
   echo "<td><p id='boton3'>";
   echo "<span id='span1'>  <input name='Alta'  type='image'  img src='fotos/insertar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Alta'  type='image' img src='fotos/insertar_activo_ch.jpg' alt='Se dará de Alta una Nueva Tipo con los Datos Presentes en Pantalla'></a></span>";
   echo "</p></td>";
   echo "<td><p id='boton4'>";
   echo "<span id='span1'>  <input name='Baja' type='image' img src='fotos/eliminar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Baja' type='image' img src='fotos/eliminar_activo_ch.jpg'  alt='Atención Usted va a sacar la Tipo de la Base de Datos. Verifique.'></a></span>";
   echo "</p></td>";
   echo "<td width='1'><INPUT TYPE='Submit' VALUE=''  id='ent' width='1'></td>";
   echo "</table>";
   echo "</form>";?>
</BODY>
</HTML>

