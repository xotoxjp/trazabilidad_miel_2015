<?php
	//if(isset($_POST["idsala"])){
		$hmf = $_POST["valorHmf"];
		echo "$hmf";
	    $opciones = '<option value="0" SELECTED>'.$hmf.'</option>';
	    //$conexion= new mysqli("servidor","usuario","password","base",3306);
	    //$conexion= new mysqli("localhost","root","root","chmiel",3306);
	    //SELECT almacen_id,razon_social,localidad FROM  ".$_SESSION["tabla_almacenes"] .' WHERE tipo_almacen=1 Order by razon_social '
	    //$strConsulta = "select id, modelo from modelo where idmarca = ".$_POST["idmarca"];
	    //$strConsulta =" SELECT almacen_id as id ,razon_social as nombre FROM almacenes WHERE tipo_almacen=1 Order by razon_social " ;
	    //echo "$strConsulta";
	    //$sala = $_POST["idsala"];
	 	//echo "$sala";
	    //$result = $conexion->query($strConsulta);
	    //while( $fila = $result->fetch_array() )
	    //{
	    //   if ($fila["nombre"]==$sala) {
	    //   		echo "entro al if";
	    //   		$opciones.='<option value="'.$fila["id"].'" SELECTED >'.$fila["nombre"].'</option>';
	    //   		$sala_ext = $fila["id"];
	    //   }	   	
	    //   $opciones.='<option value="'.$fila["id"].'" >'.$fila["nombre"].'</option>';
	    //}
	    echo $opciones;
	//}
?>