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
	//$resultado = ($val->resultado);
	echo " hmf es: $hmf ";
	echo " acid es: $acidez ";
	echo " humed es: $humedad ";
	$resultado = chequearRango($hmf,$humedad,$acidez);
	$fecha=($val->fecha);
	echo date_format($fecha, 'Y-m-d');
	$SQL = 'UPDATE laboratorio 
			SET color="'.$color.'", hmf="'.$hmf.'", fecha_analisis="'.$fecha.'" ,humedad="'.$humedad.'", stat="LAB", acidez="'.$acidez.'", resultado="'.$resultado.'" 
			WHERE id_tambor ="'.$tambor.'"';
	

	//echo $SQL;
	//EJECUCIÓN DE QUERYS CREADAS.
   $result =mysql_query($SQL) or die("Couldn't execute query.".mysql_error());
}





function chequearRango($valHMF,$valAC,$valHUME){
	//echo " hmf es: $valHMF ";
	//echo " acid es: $valAC ";
	//echo " humed es: $valHUME ";

	//*************************************LIMITES********************************************************************//

	$traerLimitesHMF= 'SELECT esp_inf, esp_sup FROM analitico_inf WHERE cod_anal_id=1';
	$limitHMF =mysql_query($traerLimitesHMF) or die("Couldn't execute query.".mysql_error());
	while ($v = mysql_fetch_array($limitHMF)){
	  $hmfINF=$v[0];
	  $hmfSUP=$v[1];
	  //echo $hmfINF;
	  //echo $hmfSUP;
	}
	$traerLimitesHUMEDAD= 'SELECT esp_inf, esp_sup FROM analitico_inf WHERE cod_anal_id=2';
	$limitHUMEDAD =mysql_query($traerLimitesHUMEDAD) or die("Couldn't execute query.".mysql_error());
	while ($v = mysql_fetch_array($limitHUMEDAD)){
	  $humedadINF=$v[0];
	  $humedadSUP=$v[1];
	  //echo $humedadINF;
	  //echo $humedadSUP;
	}
	$traerLimitesACID= 'SELECT esp_inf, esp_sup FROM analitico_inf WHERE cod_anal_id=4';
	$limitACID =mysql_query($traerLimitesACID) or die("Couldn't execute query.".mysql_error());
	while ($v = mysql_fetch_array($limitACID)){
	  $acidINF=$v[0];
	  $acidSUP=$v[1];
	  //echo $acidINF;
	  //echo $acidSUP;
	}

	//*************************************LIMITES********************************************************************//
	$valido="NO CUMPLE";
	$pass1="false";
	$pass2="false";
	$pass3="false";
	if ($valHMF>$hmfINF and $valHMF<$hmfSUP) {
		$pass1="true";		
		if ($valAC>$acidINF and $valAC<$acidSUP){
			$pass2="true";			
			if ($valHUME> $humedadINF and $valHUME<$humedadSUP){
				$pass3="true";
				$valido="CUMPLE";
			}
		} 
	}	
	$resultado=$valido;
	//echo "valido es: $valido";
	//echo "pass es: $pass1";
	//echo "pass es: $pass2";
	//echo "pass es: $pass3";
	return $resultado;
};

?>