<?php
if (isset( $_POST['tambores'])){ 
	$cadena=$_POST["tambores"];
	
	//$vector=explode(",",$cadena);
	
	$cantidad=count($cadena);
	
	//echo "$cantidad"; 
	
	for ( $a=0; $a < $cantidad; $a++){
		$deposito=$_POST['deposito'];
		$ingreso=$_POST['num_ing'];
		
		//$remito=$_POST['noremito'];
		//$factura=$_POST['nofactura'];
		//$rof=$_POST['rof'];
		//$valorfr=$_POST['valorfr'];

		$patente=$_POST['nopatente'];
		$chofer=$_POST['chofer'];
		$transport=$_POST['transporte'];
		$tambor=$_POST['tambores'];
		echo "Tambor Llega a php y es: ".$tambor[$a];

		//$f_llegada=$_POST['fechall'];
		//$fecha = date("Y-m-d", strtotime($f_llegada));
		//echo "Fecha Llega a php y es:".$fecha;
		/*
		if ($rof=="factura") {
			$factura=$valorfr;
		} else {
			$remito=$valorfr;
		}
		*/

		$db = mysql_connect(localhost, root, root)or die("Connection Error: " . mysql_error());
		mysql_select_db(chmiel) or die("Error conecting to db.");
		$SQL = 'SET character_set_results=utf8';
		$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
		
		//"num_ing": ingreso, "nopatente":patente, "chofer":chofer, "transporte":transporte, "tambores":tambores				 	    
		
		$SQL = "UPDATE deposito SET num_ingreso='".$ingreso."', almacen='".$deposito."', transporte='".$transport."', camion='".$patente."', chofer='".$chofer."', estado='TRANSITO' WHERE id_tambor='".$tambor[$a]."' " ;
		echo "$SQL";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
	}
}
?>