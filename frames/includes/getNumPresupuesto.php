<?php

$db = mysql_connect(localhost, root, root)
or die("Connection Error: " . mysql_error());

mysql_select_db(chmiel) or die("Error conecting to db.");

$SQL = 'SET character_set_results=utf8';
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

/*********** declaracion de variables *********/ 


$muestra=$_GET["muestra"];
$num_presupuesto=0;
//print_r($vector);
$SQL ='SELECT num_presupuesto FROM laboratorio WHERE id_tambor='.$muestra;
//echo "$SQL <br>";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
while($prov = mysql_fetch_array($result)){    
   $num_presupuesto = $prov[0];
}
echo json_encode($num_presupuesto);
?>