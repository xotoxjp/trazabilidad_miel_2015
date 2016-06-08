<?php
	$response='no existe';
	//if(isset($_POST["tambor"])){

		$tambor=$_POST['tambor'];
	    $conexion= new mysqli("localhost","root","root","chmiel",3306);

	    $strConsulta ="SELECT COUNT( DISTINCT id_tambor ) AS count FROM presupuestos WHERE id_tambor=$tambor ";
	    //echo "$strConsulta";
	    $result = $conexion->query($strConsulta);	    
  		$row =  $result->fetch_array();
 		$count = $row['count'];

  		if( $count >0 ){
  			$response='existe';
  		}

	    echo $response;
	//}
?>