<?php
$db = mysql_connect("localhost", "root", "root")
or die("Connection Error: " . mysql_error());
mysql_select_db("chmiel") or die("Error conecting to db.");
$SQL = 'SET character_set_results=utf8';
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());


//Recibimos el Array y lo decodificamos desde json, para poder utilizarlo como objeto
$accion = $_GET["accion"];
$array = new stdClass();
$array = json_decode(stripslashes($_POST['data']));

//por cada uno de estos arrays vamos a crear una query para poder hacer un update en la base de datos. y para eso necesitamos recorrer el array por cada uno de sus posiciones

foreach($array as  $key => $val) { 
	//echo "$key : $val->fecha_ini";
	//una vez que recorremos cada posición entramos a esta donde tenemos cada array con la información necesaria para el update
    $razon = ($val->razon);
    $dir1 = ($val->dir1);
    //$lon = ($val->lon);
    //$lat = ($val->lat);
    $localidad = ($val->localidad);
    $cod_postal = ($val->cod_postal);
    $provincia =($val->provincia); 
    $pais = ($val->pais);
    $contacto =($val->contacto); 
    $tel =($val->tel); 
    $cel = ($val->cel);    
    $email = ($val->email);
    $fax = ($val->fax);
    $nextel = ($val->nextel); 
    $contacto1 =($val->contacto1);
    $tel1 = ($val->tel1);
    $cel1 = ($val->cel1);
    $email1 = ($val->email1);
    $cond_iva = ($val->cond_iva);
    $nro_cuit = ($val->nro_cuit);
    $ret_iva = ($val->ret_iva); 
    $ret_bru = ($val->ret_bru);
    $ret_gan = ($val->ret_gan);
    $cliente_id =($val->cliente_id);   
      
if($accion=="edit"){        
    $SQL = 'UPDATE clientes SET razon_social="'.$razon.'", dir1="'.$dir1.'", localidad="'.$localidad.'", cod_postal="'.$cod_postal.'", provincia="'.$provincia.'", pais="'.$pais.'", cond_iva="'.$cond_iva.'",
        nro_cuit="'.$nro_cuit.'", ret_iva="'.$ret_iva.'", ret_bru="'.$ret_bru.'", ret_gan="'.$ret_gan.'", contacto="'.$contacto.'",tel="'.$tel.'", cel="'.$cel.'",
        fax="'.$fax.'", nextel = "'.$nextel.'", email="'.$email.'",contacto1="'.$contacto1.'", tel1="'.$tel1.'",cel1="'.$cel1.'", email1="'.$email1.'"
        WHERE prov_id = "'.$cliente_id.'"';
}
else{
    $SQL = "INSERT INTO clientes (cliente_id, razon_social, dir1, localidad, cod_postal, provincia, pais, cond_iva, nro_cuit, ret_iva, ret_bru, ret_gan, contacto, tel, cel, fax, nextel, email, contacto1, tel1, cel1, email1)
        VALUES ('$cliente_id','$razon', '$dir1', '$localidad','$cod_postal','$provincia','$pais','$cond_iva', '$nro_cuit','$ret_iva', '$ret_bru','$ret_gan','$contacto','$tel','$cel','$fax','$nextel','$email', '$contacto1', '$tel1','$cel1','$email1')";
}        
echo $SQL;

//EJECUCIÓN DE QUERYS CREADAS.

$result =mysql_query($SQL) or die("Couldn't execute query.".mysql_error());

$response = new stdClass();

if($result){
   $response->mensaje = "todo OK!";
}
else{
   $response->mensaje = " errorrrr verifique";
}
echo json_encode($response);

}
?>