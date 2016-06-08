<?php
if (isset( $_POST['tambores'])){ 
	$cadena=$_POST["tambores"];
	//$vector=explode(",",$cadena);
	$cantidad=count($cadena);
	//echo "$cantidad"; 
	for ( $a=0; $a < $cantidad; $a++){
		$deposito=$_POST['deposito'];
		$ingreso=$_POST['num_ing'];
		
		$remito=$_POST['noremito'];
		$factura=$_POST['nofactura'];

		$rof=$_POST['rof'];
		$valorfr=$_POST['valorfr'];

		$patente=$_POST['nopatente'];
		$chofer=$_POST['chofer'];
		$transport=$_POST['transporte'];
		$tambor=$_POST['tambores'];
		echo "Tambor Llega a php y es: ".$tambor[$a];	
		$f_llegada=$_POST['fechall'];
		$fecha = date("Y-m-d", strtotime($f_llegada));

		echo "Fecha Llega a php y es:".$fecha;

		
		if ($rof=="factura") {
			$factura=$valorfr;
		} else {
			$remito=$valorfr;
		}
		
		
		//falta definir transporte en BD y poder escribir el numero de ingreso desde UI, para llenar la BD

		$db = mysql_connect(localhost, root, root)or die("Connection Error: " . mysql_error());
		mysql_select_db(chmiel) or die("Error conecting to db.");
		$SQL = 'SET character_set_results=utf8';
		$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
		//hay que sacar "num_ing": ingreso, "nopatente":patente, "chofer":chofer, "transporte":transporte, "tambores":tambores	 	    
		$SQL = "UPDATE deposito SET num_ingreso='".$ingreso."', remito='".$remito."',factura='".$factura."', transporte='".$transport."', camion='".$patente."', chofer='".$chofer."', almacen='".$deposito."', fecha_llegada='".$fecha."', estado='STOCK' WHERE id_tambor='".$tambor[$a]."' " ;
		echo "$SQL";
		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
		
		$presupuestos='SELECT id_presupuesto FROM presupuestos WHERE id_tambor='.$tambor[$a];
		$pedidoIDPresup=mysql_query( $presupuestos ) or die("Couldn't execute query.".mysql_error());
		$row = mysql_fetch_row($pedidoIDPresup);
		//echo $row[0];
		$deposito='SELECT id_deposito FROM deposito WHERE id_tambor='.$tambor[$a];
		$pedidoIDDeposito=mysql_query( $deposito ) or die("Couldn't execute query.".mysql_error());
		$row2 = mysql_fetch_row($pedidoIDDeposito);
		//echo $row2[0];
		$laboratorio='SELECT id_laboratorio FROM laboratorio WHERE id_tambor='.$tambor[$a];
		$pedidoIDLaboratorio=mysql_query( $laboratorio ) or die("Couldn't execute query.".mysql_error());
		$row3 = mysql_fetch_row($pedidoIDLaboratorio);
		//echo $row3[0];

		$color='SELECT color FROM laboratorio WHERE id_tambor='.$tambor[$a];
		$pedidoColor=mysql_query( $color ) or die("Couldn't execute query.".mysql_error());
		$row4 = mysql_fetch_row($pedidoColor);
		//echo $row4[0];
		if ($row4[0]<=34){
			$rango="inferior a 34";
		}else if ($row4[0]<=40){
			$rango="hasta 40";
		}else if ($row4[0]<=50){
			$rango="hasta 50";
		}else if ($row4[0]<=65){
			$rango="hasta 65";
		}else if ($row4[0]>=66){
			$rango="superior a 66";
		}else{
			$rango="indeterminado";
		}

		//obtengo peso bruto y tara y conformo el peso neto
		$pedirDatosPyT='SELECT peso, tara FROM deposito WHERE id_tambor='.$tambor[$a];
		$result = mysql_query( $pedirDatosPyT ) or die("Couldn t execute query.".mysql_error());
		$data = mysql_fetch_array($result,MYSQL_ASSOC);
		$pesoBruto = $data['peso'];
		$tara = $data['tara'];

		$pesoNeto=$pesoBruto-$tara;
		//echo "$pesoBruto";
		//echo "$tara";
		//echo "$pesoNeto";

		$SQL = "INSERT INTO stock (id_tambor,peso_neto,id_presupuesto,id_deposito,id_laboratorio,rango) VALUES ($tambor[$a],$pesoNeto,$row[0],$row2[0],$row3[0],'".$rango."')";	
		//echo "$SQL";

		$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
	}
}
?>