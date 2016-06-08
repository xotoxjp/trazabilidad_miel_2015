<?php

$elemento = $_GET["element"];

//$page = $_GET['page']; // get the requested page
//$limit = $_GET['rows']; // get how many rows we want to have into the grid
$limit = 10;
//$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
//$sord = $_GET['sord']; // get the direction

  
$conexion = mysql_pconnect("localhost","root","root");  
mysql_select_db("chmiel");

$sql = "SELECT lote_env_sec FROM mov_detalle WHERE  mov_detalle.lote_id =".$elemento." GROUP BY lote_env_sec";
$respuesta = mysql_query($sql, $conexion);

while ($dato = mysql_fetch_array($respuesta)){
       $nro = $dato[0];
}

$sql2 = "SELECT lote_env_sec FROM mov_detalle GROUP BY lote_env_sec ORDER BY lote_env_sec DESC ";

$respuesta2 = mysql_query($sql2, $conexion);

$result = mysql_query("SELECT COUNT( DISTINCT mov_detalle.lote_env_sec ) AS total_pages FROM mov_detalle ");
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$total_pages = $row['total_pages'];

$posicionGrilla =1;
while ($res = mysql_fetch_array($respuesta2)){
	//echo print_r($res);
	//$presupuesto = $res[0];
	if ($res[0] == $nro){
	   break;
    } 
	$posicionGrilla++;
}
// obtenemos la pagina dividiendo la posicion en la grilla por la cantidad registro spor hoja asignada en en la grid

//$page= variant_int($posicionGrilla/$limit);

$page = 1; // $limit = 10 esta al cominezo
while ($limit <= $total_pages){// ej 10 <= 39
   if ($posicionGrilla > $limit){
           $page++;   
           break; 
    }// fin if
   $limit= $limit + 10;
}//fin while

$response->nro = $nro;
$response->page = $page;
echo json_encode($response);


?>