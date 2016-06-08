<?php
$db = mysql_connect(localhost, root, root)
or die("Connection Error: " . mysql_error());

mysql_select_db(chmiel) or die("Error conecting to db.");

$SQL = 'SET character_set_results=utf8';
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
 
$cadena=$_GET["tambores"];
$vector=explode(",",$cadena);
$cantidad=count($vector);
 
for ( $a=0; $a < $cantidad; $a++){    
	$SQL = "SELECT id_tambor,color,hmf,humedad,acidez,resultado 
	    FROM laboratorio 
	    WHERE id_tambor = ".$vector[$a]."  GROUP BY id_tambor ";
	$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
		$response->lote_id = $row['id_tambor'];
		$response->colorN = $row['color'];
		$response->hmf = $row['hmf'];
		$response->humedad = $row['humedad'];
		$response->acidez = $row['acidez'];
		$response->cumple = $row['resultado'];
		$i++;
	}
}// fin for
echo json_encode($response);
?>