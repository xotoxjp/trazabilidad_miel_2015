<?php
header('Content-type: application/json');
require_once 'config.php';  

$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx =1;


//array to translate the search type
$ops = array(
    'eq'=>'=', //equal
    'ne'=>'<>',//not equal
    'lt'=>'<', //less than
    'le'=>'<=',//less than or equal
    'gt'=>'>', //greater than
    'ge'=>'>=',//greater than or equal
    'bw'=>'LIKE', //begins with
    'bn'=>'NOT LIKE', //doesn't begin with
    'in'=>'LIKE', //is in
    'ni'=>'NOT LIKE', //is not in
    'ew'=>'LIKE', //ends with
    'en'=>'NOT LIKE', //doesn't end with
    'cn'=>'LIKE', // contains
    'nc'=>'NOT LIKE'  //doesn't contain
);

function getWhereClause($col, $oper, $val){
    if($col == 'id_tambor') $col = 'laboratorio.id_tambor';
    global $ops;
    if($oper == 'bw' || $oper == 'bn') $val .= '%';
    if($oper == 'ew' || $oper == 'en' ) $val = '%'.$val;
    if($oper == 'cn' || $oper == 'nc' || $oper == 'in' || $oper == 'ni') $val = '%'.$val.'%';
	  $p=" WHERE $col {$ops[$oper]} '$val' ";
    return $p;
	echo $p;
}
$where = ""; //if there is no search request sent by jqgrid, $where should be empty
$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
$searchOper = isset($_GET['searchOper']) ? $_GET['searchOper']: false;
$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
if ($_GET['_search'] == 'true') {
  $where = getWhereClause($searchField,$searchOper,$searchString);
}

$result = mysql_query("SELECT COUNT( DISTINCT num_ingreso ) AS count FROM deposito WHERE estado='STOCK' ");
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


$SQL = "SELECT num_ingreso, fecha_llegada, transporte, camion FROM deposito WHERE estado = 'STOCK'
GROUP BY num_ingreso ORDER BY ".$sidx." ".$sord." LIMIT ".$start." , ".$limit." ";

$result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count; 
$i=0; 
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
  $responce->rows[$i]['id']=$row['num_ingreso'];
  $responce->rows[$i]['cell']=array($row['num_ingreso'],$row['fecha_llegada'],$row['transporte'],$row['camion'],"");
  $i++;
} 
echo json_encode($responce);
?>