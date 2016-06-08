<?php
	$db = mysql_connect("localhost", "root", "root")
	or die("Connection Error: " . mysql_error());
	mysql_select_db("chmiel") or die("Error conecting to db.");
	$SQL = 'SET character_set_results=utf8';
	$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

	//Recibimos el Array y lo decodificamos desde json, para poder utilizarlo como objeto
	$array 	= json_decode(stripslashes($_POST['data']));

	//por cada uo de estos arrays vamos a crear una query para poder hacer un update en la base de datos. y para eso necesitamos recorrer el array por cada uno de sus posiciones
	foreach($array as  $key => $val) { 
		//una vez que recorremos cada posición entramos a esta donde tenemos cada array con la información necesaria para el update
			$tambor = $val->tambor;
			$color = ($val->color);
			$hmf = ($val->hmf);
			$humedad = ($val->humedad);
			$acidez = ($val->acidez);
			$resultado = ($val->resultado);
			$SQL ='UPDATE laboratorio SET stat="MOV" WHERE id_tambor ="'.$tambor.'"';
			$SQL2='INSERT INTO deposito (id_tambor,estado, id_productor, id_presupuesto)
			  		SELECT "'.$tambor.'","COMPRADO",id_productor, id_presupuesto FROM presupuestos WHERE id_tambor="'.$tambor.'" ';
			echo $SQL2;
		//EJECUCIÓN DE QUERYS CREADAS.
		$result =mysql_query($SQL)  or die("Couldn't execute query.".mysql_error());
		$result =mysql_query($SQL2) or die("Couldn't execute query.".mysql_error());
	}
?>