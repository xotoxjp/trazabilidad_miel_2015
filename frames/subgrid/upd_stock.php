<?php
require_once 'config.php';  
 
$id = $_GET['ID'];

$num_lote = $_GET['lote'];

$obs = $_GET['otro'];

echo "id : $id || obs : $obs";

$sql = 'UPDATE deposito SET num_lote="'.$num_lote.'" WHERE id_tambor="'.$id.'"';

$r=mysql_query($sql);

if ($r){
  header("Location: ../stock1.php");
}
?>	