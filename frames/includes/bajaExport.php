<?php
require_once 'config.php';  
 
$id = $_GET['ID'];


$sql = 'UPDATE stock SET estado="",lote_export="" WHERE id_tambor="'.$id.'"';
$r=mysql_query($sql);

//echo $sql;
 
$sql1 = 'DELETE FROM export WHERE id_tambor="'.$id.'" ';
$s=mysql_query($sql1);

//echo $sql1;
if ($s){
  header("Location: ../embarque1.php");
}
?>				