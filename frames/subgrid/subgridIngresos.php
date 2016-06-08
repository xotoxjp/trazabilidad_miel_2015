<?php
header('Content-type: application/json');
require_once 'config.php';  
 
$id = $_GET['id'];



$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx =1;


$result = mysql_query("SELECT COUNT( DISTINCT id_tambor ) AS count FROM deposito WHERE num_ingreso =".$id."  ");
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
if ($start < 0) $start = 0;



$SQL = 'SET character_set_results=utf8';
$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

$SQL = "SELECT deposito.id_tambor,provedores.c1,deposito.num_lote,provedores.razon_social,deposito.remito FROM deposito 
INNER JOIN provedores ON deposito.id_productor=provedores.prov_id  
WHERE deposito.num_ingreso =".$id." ORDER BY ".$sidx." ".$sord." LIMIT ".$start." , ".$limit."  ";

//echo "$SQL";

 $result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());
 //echo "$result[0]";
 $responce->page = $page;
 $responce->total = $total_pages;
 $responce->records = $count; 
 $i=0; 
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
 	$responce->rows[$i]['id']=$row['id_tambor'];
 	$responce->rows[$i]['cell']=array($row['id_tambor'],$row['c1'],$row['num_lote'],$row['razon_social'],$row['remito'],""); 
 	$i++;
 } 
 echo json_encode($responce);
?>				