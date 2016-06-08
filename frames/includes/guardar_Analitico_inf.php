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
//print_r($array);
//por cada uno de estos arrays vamos a crear una query para poder hacer un update en la base de datos. y para eso necesitamos recorrer el array por cada uno de sus posiciones

foreach($array as  $key => $val){ 
  //echo "$key : $val->nomencl";
  //una vez que recorremos cada posición entramos a esta donde tenemos cada array con la información necesaria para el update
   
    $nomencl = ($val->nomencl);
    $nomencl1 = ($val->nomencl1);
    $esp_inf = ($val->esp_inf);
    $esp_sup = ($val->esp_sup);
    $unidad = ($val->unidad);
    $aplica_ok = ($val->aplica_ok);
    $leyenda1 = ($val->leyenda1);
    $leyenda2 = ($val->leyenda2);
    $leyenda3 = ($val->leyenda3);
    $cod_anal_id =($val->cod_anal_id);        

if($accion=="edit"){        
    
    $SQL= 'UPDATE analitico_inf 
    SET  nomencl="'.$nomencl.'", nomencl1="'.$nomencl1.'", unidad="'.$unidad.'", esp_inf="'.$esp_inf.'", esp_sup="'.$esp_sup.'", leyenda1="'.$leyenda1.'", leyenda2="'.$leyenda2.'",leyenda3="'.$leyenda3.'", aplica_ok="'.$aplica_ok.'"
    WHERE cod_anal_id=  "'.$cod_anal_id.'"';    
}
else{
    $SQL = " INSERT INTO analitico_inf (cod_anal_id, nomencl,nomencl1, esp_inf, esp_sup, unidad, leyenda1, leyenda2, leyenda3, aplica_ok)
    VALUES ('$cod_anal_id','$nomencl','$nomencl1','$esp_inf','$esp_sup','$unidad','$leyenda1','$leyenda2','$leyenda3','$aplica_ok')";
}

echo $SQL;
 
//EJECUCIÓN DE QUERYS CREADAS.

$result =mysql_query($SQL) or die("Couldn't execute query.".mysql_error());

$response = new stdClass();

if($result){
  
   $response->mensaje = "todo OK!"; 
}
else{
   $response->mensaje = "errorrr verifique";  
} 
echo json_encode($response);

}
?>