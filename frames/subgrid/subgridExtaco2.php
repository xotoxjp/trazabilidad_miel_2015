<?php
header('Content-type: application/json');
require_once 'config.php';  
 
$examp = $_GET["q"]; //query number

$id = $_GET['id'];


mysql_select_db(chmiel) or die("Error conecting to db.");

    $SQL = 'SET character_set_results=utf8';
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());


 $SQL = "SELECT mov_detalle.lote_id, provedores.razon_social, mov_detalle.tipo_campo
	FROM mov_detalle
	INNER JOIN mov_cabecera ON mov_detalle.nro_mov=mov_cabecera.nro_mov 
	INNER JOIN mov_det_anal ON mov_detalle.lote_id=mov_det_anal.lote_id  
	INNER JOIN provedores ON mov_cabecera.prov_id=provedores.prov_id  
	INNER JOIN almacenes ON mov_cabecera.almac_id_des=almacenes.almacen_id
	WHERE mov_detalle.lote_env_sec =".$id."
	AND  (mov_detalle.cumple='Si' OR mov_detalle.cumple='No')
	GROUP BY mov_detalle.lote_id
	ORDER BY mov_detalle.lote_id";
	

$result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());

 $responce->page = $page;
 $responce->total = $total_pages;
 $responce->records = $count; 
 $i=0; 
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
 $responce->rows[$i]['id']=$row['lote_id'];
 $responce->rows[$i]['cell']=array($row['lote_id'],$row['razon_social'],$row['tipo_campo'],""); $i++;
 } 
 echo json_encode($responce);
?>				