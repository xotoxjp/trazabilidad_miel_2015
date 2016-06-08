<?php
$db = mysql_connect("localhost", "root", "root")
or die("Connection Error: " . mysql_error());
mysql_select_db("chmiel") or die("Error conecting to db.");
$SQL = 'SET character_set_results=utf8';
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

$tambor = $_GET["tam"];

//Recibimos el Array y lo decodificamos desde json, para poder utilizarlo como objeto
$array 	= json_decode(stripslashes($_POST['data']));
//print_r($array);

$resultado = array();
$codigoAnalisis = array();

foreach($array as  $key => $val) { 
	
	// INFO IMPORTANTE  0 : resultado  1 : codigo analisis
	
	switch($key){
		case 0:
		    for($i=5; $i<=25;$i++){	
		        $codigoAnalisis[$i] = $val->$i;
		           //echo "para : ". $i . "resultado : " . $codigoAnalisis[$i]."<br>";
		    }
		    break;
		case 1:		    
		    for($j=5; $j<=25;$j++){
		            $resultado[$j] = $val->$j;     
		            //echo "para : ". $j ." codigoAnalisis : ". $resultado[$j]."<br>";
		    }
		    break;
    }
}// fin foreach 

	
	
	$a=0;
	while($a <= count($resultado)){
	    if(!empty($codigoAnalisis[$a])){    
	        $SQL = 'UPDATE analisis SET resultado ="'.$resultado[$a].'" 
	        WHERE (id_tambor ="'.$tambor.'" AND cod_analisis_id ="'.$codigoAnalisis[$a].'")';
	        //echo $SQL."<br>";
	        $result =mysql_query($SQL) or die("Couldn't execute query.".mysql_error());
	    }
	    $a++;        
	}	

?>