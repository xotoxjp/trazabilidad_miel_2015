<?php
	//valor por defecto del campo password
	$passw='incorrecto';
	//seteo el password con lo que se carga por UI
	if (isset( $_POST['password'])){
		 $passw=$_POST['password'];
	}

	//conexion a la BD
	$db = mysql_connect(localhost, root, root)
	or die("Connection Error: " . mysql_error());
	mysql_select_db(chmiel) or die("Error conecting to db.");
	$SQL = 'SET character_set_results=utf8';
	$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());


	//consultar el nombre de "login" con el password pasado por UI
	$SQL = "SELECT login FROM usuario WHERE password='".$passw."' ";
	$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
		$ingreso = $row['login'];
	} 

	//chequeo que el login sea de la forma password: 2387 resultado login:amt
	if ($ingreso=='aut'){
		$response->respuesta = "Correcta";
		echo json_encode($response);
	}else{
		$response->respuesta = "Incorrecta";
		echo json_encode($response);
	}
?>