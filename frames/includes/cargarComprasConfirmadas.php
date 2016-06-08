<?php
	//valor por defecto de tambor
	$tambor=0;
	//seteo el password con lo que se carga por UI
	if (isset( $_POST['tambor'])){
		 $tambor=$_POST['tambor'];
	}


	if ($tambor!=0 or $tambor!='' ){
		//conexion a la BD
		$db = mysql_connect(localhost, root, root)
		or die("Connection Error: " . mysql_error());
		mysql_select_db(chmiel) or die("Error conecting to db.");

		$SQL = 'SET character_set_results=utf8';
		$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

		//cambio el estado del tipo_mov segun el tambor o lote_id para la tabla mov_det_anal
		$SQL = "UPDATE mov_det_anal SET tipo_mov='MOV' WHERE lote_id='".$tambor."' ";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
		echo "$SQL";

		//cambio el estado del tipo_mov segun el tambor o lote_id para la tabla mov_detalle
		$SQL = "UPDATE mov_detalle SET tipo_mov='MOV' WHERE lote_id='".$tambor."' ";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
		echo "$SQL";

		$SQL = "SELECT nro_mov FROM mov_detalle WHERE lote_id='".$tambor."' ";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$mov = $row['nro_mov'];
		echo "$mov";


		//cambio el estado del tipo_mov segun el tambor o lote_id para la tabla mov_cabecera
		$SQL = "UPDATE mov_cabecera SET tipo_mov='MOV' WHERE nro_mov='".$mov."' ";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
		echo "$SQL";
	}
/****************************************************************************************
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
		$ingreso = $row['login'];
	} 

	//chequeo que el login sea de la forma password: 2387 resultado login:amt
	if ($ingreso=='amt'){
		$response->respuesta = "Correcta";
		echo json_encode($response);
	}else{
		$response->respuesta = "Incorrecta";
		echo json_encode($response);
	}
	*******************************************************************/
?>