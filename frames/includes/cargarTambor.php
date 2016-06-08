<?php
if (isset( $_POST['notambor'])){
   $tambor=$_POST['notambor'];
   //echo"Tambor Llega a php y es: ".$tambor;


	if (isset( $_POST['peso'])){   
	   $peso=$_POST['peso'];
	   //echo"Peso Llega a php y es:".$peso;
	}

	if (isset($_POST['tipotambor'])){
		$tipotambor=$_POST['tipotambor'];
	}

	if (isset( $_POST['tara'])){
	   	$tara= $_POST['tara'];
	    //echo"Tara Llega a php".$tara;
	
	  	$db = mysql_connect(localhost, root, root)
		or die("Connection Error: " . mysql_error());

		mysql_select_db(chmiel) or die("Error conecting to db.");

		$SQL = 'SET character_set_results=utf8';
		$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
		 	    
		$SQL = "UPDATE deposito SET peso='".$peso."', tara='".$tara."', tipo_tambor='".$tipotambor."' estado='PESADO' WHERE id_tambor='".$tambor."' " ;

		//echo "$SQL";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
	}
} 
?>