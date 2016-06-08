<?php
	$response='no existe';
	//if(isset($_POST["tambor"])){

		$envio=$_POST['enviono'];
	    $conexion= new mysqli("localhost","root","root","chmiel",3306);

	    $strConsulta ="SELECT COUNT( DISTINCT num_ingreso ) AS count FROM deposito WHERE num_ingreso=$envio ";
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