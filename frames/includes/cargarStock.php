<?php
if (isset( $_POST['tambores'])){ 
	$cadena=$_POST["tambores"];
	//$vector=explode(",",$cadena);
	$cantidad=count($cadena);
	//echo "$cantidad"; 
	for ( $a=0; $a < $cantidad; $a++){
		$lote=$_POST['lote'];
		$tambor=$_POST['tambores'];
		//echo "Tambor Llega a php y es: ".$tambor[$a];
		//echo "lote es: ".$lote;		
		//falta definir transporte en BD y poder escribir el numero de ingreso desde UI, para llenar la BD

		$db = mysql_connect(localhost, root, root)or die("Connection Error: " . mysql_error());
		mysql_select_db(chmiel) or die("Error connecting to db.");
		$SQL = 'SET character_set_results=utf8';
		$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

		
		$SQL = "UPDATE stock SET lote_export='".$lote."', estado='PREEMB' WHERE id_tambor='".$tambor[$a]."' " ;
		//echo "$SQL";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());


		$stock='SELECT id_stock FROM stock WHERE id_tambor='.$tambor[$a];
		$pedidoIDStock=mysql_query($stock) or die("Couldn't execute query.".mysql_error());
		$row = mysql_fetch_row($pedidoIDStock);		

		
		//echo $row3[0];
		$SQL2 = "INSERT INTO export (id_tambor,id_stock,num_loteGSB) VALUES ($tambor[$a],$row[0],$lote)";	
		//echo "$SQL2";
		$result = mysql_query( $SQL2 ) or die("Couldn't execute query.".mysql_error());	
	}
}
?>