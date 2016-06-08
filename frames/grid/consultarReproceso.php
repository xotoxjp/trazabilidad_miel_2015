<?php

$elemento = $_GET["element"];

//$page = $_GET['page']; // get the requested page
//$limit = $_GET['rows']; // get how many rows we want to have into the grid
$limit = 15;
//$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction

  
$conexion = mysql_pconnect("localhost","root","root");  
mysql_select_db("chmiel");

$sql = "SELECT lote_id FROM mov_detalle WHERE  mov_detalle.lote_id =".$elemento." AND tipo_mov= 'EXA'";
$respuesta = mysql_query($sql, $conexion);

while ($dato = mysql_fetch_array($respuesta)){
       $tambor = $dato[0];
}

$sql2 = "SELECT lote_id FROM mov_detalle WHERE mov_detalle.tipo_mov = 'EXA' ORDER BY lote_id ".$sord." ";//devuelve los numeros de tambor
$respuesta2 = mysql_query($sql2, $conexion);

$sql3 = "SELECT COUNT(*) AS count FROM mov_detalle WHERE mov_detalle.tipo_mov='EXA'";// devuelve 710
$result = mysql_query($sql3,$conexion);

$row = mysql_fetch_array($result,MYSQL_ASSOC);
$total_pages = $row['count'];

$posicionGrilla =1;
while ($res = mysql_fetch_array($respuesta2)){
	//echo print_r($res);
	//$tambor = $res[0];
	if ($res[0] == $tambor){
	   break;
    } 
	$posicionGrilla++;
}

// obtenemos la pagina dividiendo la posicion en la grilla por la cantidad registro spor hoja asignada en en la grid

//$page= variant_int($posicionGrilla/$limit);

$page = 1; // $limit = 10 esta al cominezo
while ($limit <= $total_pages){// ej 10 <= 39
   if ( $posicionGrilla > $limit){
           //echo " page : $page";
           $page++;   
           //break; 
   }// fin if
   $limit= $limit + 15;   
}//fin while

$response->nro = $tambor;
$response->page = $page;
echo json_encode($response);
?>