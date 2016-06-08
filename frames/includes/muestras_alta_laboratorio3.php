<?php
$db = mysql_connect(localhost, root, root)
or die("Connection Error: " . mysql_error());

mysql_select_db(chmiel) or die("Error conecting to db.");

$SQL = 'SET character_set_results=utf8';
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
 
$cadena=$_GET["tambores"];
$vector=explode(",",$cadena);
$cantidad=count($vector);
console.log($cadena); 
for ( $a=0; $a < $cantidad; $a++){    
	$SQL = "SELECT laboratorio.id_tambor, provedores.razon_social, laboratorio.color, laboratorio.hmf, laboratorio.humedad, laboratorio.acidez, laboratorio.resultado, laboratorio.fecha_analisis FROM laboratorio 
		INNER JOIN provedores
		ON laboratorio.id_productor=provedores.prov_id		 
		WHERE laboratorio.id_tambor = ".$vector[$a]." GROUP BY id_tambor";
	$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
		$response->id_tambor = $row['id_tambor'];
		$response->productor = $row['razon_social'];
		$response->colorN = $row['color'];
		$response->hmf = $row['hmf'];
		$response->humedad = $row['humedad'];
		$response->acidez = $row['acidez'];
		$response->resultado = $row['resultado'];
		$response->fecha = $row['fecha_analisis'];
		$i++;
	} 
}// fin for
echo json_encode($response);
?>