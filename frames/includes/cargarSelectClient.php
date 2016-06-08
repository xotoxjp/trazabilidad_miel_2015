<?php
$db = mysql_connect(localhost, root, root)
or die("Connection Error: " . mysql_error());

mysql_select_db(chmiel) or die("Error conecting to db.");

$SQL = 'SET character_set_results=utf8';
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
 
//$cadena=$_GET["tambores"];
//$vector=explode(",",$cadena);
//$cantidad=count($vector);
//console.log($cadena); 
//for ( $a=0; $a < $cantidad; $a++){    
$SQL = "SELECT `cliente_id`, `razon_social` FROM `clientes`";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 		
	$response->id = $row['cliente_id'];		
	$response->cliente = $row['razon_social'];		
	$i++;
} 
//}// fin for
echo json_encode($response);
?>