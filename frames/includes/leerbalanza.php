<?php
  $tipoAlmacen = $_GET['almacen']; // tipo de almacen elegido: Central - CHACO 
  //echo $tipoAlmacen;

	$bruto=88;
	//$linea=99;
	/*$descriptor = fopen("c:\moretti\peso\peso.txt","r");*/
	  
    //$nombre="c:\moretti\peso\pesoDT.txt";
    if ($tipoAlmacen!='CHACO')
      $nombre="c:\moretti\peso\pesoDT.txt";
    else
      $nombre="c:\moretti\peso\pesoCH.txt";

  	$descriptor = @fopen($nombre,r) or die("Error al abrir el archivo: $nombre");	  

  	//$archivo = " " ;
  	$i=0;
  	$linea = fgets($descriptor,4096);

    //para nuevo lector de balanza 
    //eliminar "" y kg
    $cadena_format2 = trim($linea,'"');    
    $cadena_format2 = str_replace ( 'Kg"' , ' ' , $cadena_format2);
    $cadena_format2 = trim($cadena_format2);
    $linea=$cadena_format2;
    //echo $cadena_format2;
  	
    if (strlen($linea)>1) {
      //$u=$bruto;
      $bruto= 0 + $linea ;
  	}

    $response->peso = $bruto;
    
    echo json_encode($response);
?>  