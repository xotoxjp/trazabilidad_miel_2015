<?php
if (isset( $_GET['ID'])){
   $tambor= $_GET['ID'];
   //echo"Tambor Llega a php y es: ".$tambor;

	$db = mysql_connect(localhost, root, root)
	or die("Connection Error: " . mysql_error());

	mysql_select_db(chmiel) or die("Error al conectar con la BD.");

	$SQL = 'SET character_set_results=utf8';
	$result = mysql_query( $SQL ) or die("No se pudo ejecutar la sentencia.".mysql_error());
	 	    
	$SQL = "UPDATE deposito SET peso='0', tara='0', estado='TRANSITO' WHERE id_tambor='".$tambor."' " ;
	//echo "$SQL";
	$result = mysql_query( $SQL ) or die("No se puede ejecutar  la sentencia.".mysql_error());
}
header("Location: ../reproceso1.php"); 
?>