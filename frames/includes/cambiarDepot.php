<?php
if (isset( $_POST['tambores'])){ 
	$cadena=$_POST["tambores"];
	//$vector=explode(",",$cadena);
	$cantidad=count($cadena);
	//echo "$cantidad"; 
	for ( $a=0; $a < $cantidad; $a++){
		$deposito=$_POST['deposito'];
		$tambor=$_POST['tambores'];
		//echo "Tambor Llega a php y es: ".$tambor[$a];
		$db = mysql_connect(localhost, root, root)or die("Connection Error: " . mysql_error());
		mysql_select_db(chmiel) or die("Error conecting to db.");
		$SQL = 'SET character_set_results=utf8';
		$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
		$SQL = "UPDATE deposito SET almacen='".$deposito."' WHERE id_tambor='".$tambor[$a]."' " ;
		//echo "$SQL";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
	}
}
?>