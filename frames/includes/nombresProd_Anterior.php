<?php

$db = mysql_connect(localhost, root, root)
or die("Connection Error: " . mysql_error());

mysql_select_db(chmiel) or die("Error conecting to db.");

$SQL = 'SET character_set_results=utf8';
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

/*********** declaracion de variables *********/ 

$array = array(); 
$cadena=$_GET["muestra"];
$vector=explode(",",$cadena);
$cantidad=count($vector);

$presu=$_GET["presu"];

//print_r($vector);
for($i=0; $i< $cantidad; $i++){    

	$SQL ='SELECT provedores.razon_social FROM provedores
           INNER JOIN laboratorio ON laboratorio.id_productor = provedores.prov_id 
           WHERE laboratorio.num_presupuesto = '.$presu.' AND laboratorio.id_tambor ='.$vector[$i];

	//echo "$SQL <br>";
	$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
	$j=0;
	while($prov = mysql_fetch_array($result)){    
	    // $array contendra todos los nombre de los analisis
	    $array[$j]=$prov[$j];	    
	    $j++;

	};
}  
//print_r($array);
echo json_encode($array);
?>