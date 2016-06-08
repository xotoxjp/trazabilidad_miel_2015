<?php
if (isset( $_POST['tambores'])){ 
	$cadena=$_POST["tambores"];
	//$vector=explode(",",$cadena);
	$cantidad=count($cadena);
	//echo "$cantidad"; 
	for ( $a=0; $a < $cantidad; $a++){
		$pais=$_POST['pais'];
		$cliente=$_POST['cliente'];
		$tambor=$_POST['tambores'];
		//echo "Tambor Llega a php y es: ".$tambor[$a];
		//echo "lote es: ".$lote;		
		$db = mysql_connect(localhost, root, root)or die("Connection Error: " . mysql_error());
		mysql_select_db(chmiel) or die("Error conecting to db.");
		$SQL = 'SET character_set_results=utf8';
		$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

		
		$SQL = "UPDATE stock SET estado='EMB' WHERE id_tambor='".$tambor[$a]."' " ;
		echo "$SQL";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());


		//echo $row3[0];
		$SQL2 = "UPDATE export SET id_cliente=$cliente, pais_destino='$pais', estado='SALIDA' WHERE id_tambor='".$tambor[$a]."' " ;;	
		echo "$SQL2";
		$result = mysql_query( $SQL2 ) or die("Couldn't execute query.".mysql_error());	
	}
}
?>