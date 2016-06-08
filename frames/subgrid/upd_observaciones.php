<?php

 
$id = $_GET['ID'];

$obs = $_GET['obs'];

//echo"id : $id || obs : $obs";
$cx_validar = mysql_pconnect("localhost","root","root");
mysql_select_db("chmiel");

$sql = 'UPDATE laboratorio SET observaciones="'.$obs.'" WHERE id_tambor="'.$id.'"';
//echo $sql;
$r=mysql_query($sql,$cx_validar);

if ($r){
  header("Location: ../analisis1.php");
}
?>				