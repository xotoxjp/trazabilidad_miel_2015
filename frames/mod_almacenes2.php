<?php
session_start();
include_once("funciones.php");
$_SESSION["level_req"]="f";
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
$nivel_dato=$_SESSION["acceso_acc"];

$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=3 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }

  $actualizar="SELECT max( almacen_id ) from ".$_SESSION["tabla_almacenes"];
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$almacen_id= 1+ $v_validar[0];}
  $actualizar="INSERT INTO ".$_SESSION["tabla_almacenes"]." (`almacen_id`,`cod_postal`) VALUES (".$almacen_id.",0)";
  $rs_validar = mysql_query($actualizar,$cx_validar);

header("Location: mod_almacenes.php?ID=$almacen_id");echo '1';