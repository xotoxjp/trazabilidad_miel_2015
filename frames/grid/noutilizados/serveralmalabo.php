<?php
/*
author : muni 
*/
 error_reporting(0);
 require_once 'config.php';
 
 $page = $_GET['page']; // get the requested page
 $limit = $_GET['rows']; // get how many rows we want to have into the grid
 $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
 $sord = $_GET['sord']; // get the direction
 if(!$sidx) $sidx =1; // connect to the database
 
 //array to translate the search type
	$ops = array(
    'bw'=>'LIKE', //begins with
    'bn'=>'NOT LIKE', //doesn't begin with
	'eq'=>'=', //equal
    'ne'=>'<>',//not equal
    'lt'=>'<', //less than
    'le'=>'<=',//less than or equal
    'gt'=>'>', //greater than
    'ge'=>'>=',//greater than or equal
    'in'=>'LIKE', //is in
    'ni'=>'NOT LIKE', //is not in
    'ew'=>'LIKE', //ends with
    'en'=>'NOT LIKE', //doesn't end with
    'cn'=>'LIKE', // contains
    'nc'=>'NOT LIKE'  //doesn't contain
	);
function getWhereClause($col, $oper, $val){
    global $ops;
    if($oper == 'bw' || $oper == 'bn') $val .= '%';
    if($oper == 'ew' || $oper == 'en' ) $val = '%'.$val;
    if($oper == 'cn' || $oper == 'nc' || $oper == 'in' || $oper == 'ni') $val = '%'.$val.'%';
    return " WHERE $col {$ops[$oper]} '$val' ";
}
$where = ""; //if there is no search request sent by jqgrid, $where should be empty
$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
$searchOper = isset($_GET['searchOper']) ? $_GET['searchOper']: false;
$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
if ($_GET['_search'] == 'true') {
    $where = getWhereClause($searchField,$searchOper,$searchString);
}
 
 
 $result = mysql_query("SELECT COUNT(*) AS count FROM almacenes WHERE tipo_almacen=2");
 $row = mysql_fetch_array($result,MYSQL_ASSOC);
 $count = $row['count'];
 
 if( $count >0 ) { 
 $total_pages = ceil($count/$limit);
 //$total_pages = ceil($count/1);
 } else {
 $total_pages = 0; 
 } if ($page > $total_pages) 
 $page=$total_pages; 
 $start = $limit*$page - $limit; // do not put $limit*($page - 1) 
 $SQL = "SELECT almacenes.almacen_id,almacenes.razon_social,almacenes.dir1,almacenes.Localidad,almacenes.provincia,almacenes.contacto,tipo_almacen.tipo,almacenes.tel FROM almacenes INNER JOIN tipo_almacen ON almacenes.tipo_almacen=tipo_almacen.tipo_almacen AND almacenes.tipo_almacen=2 ".$where." ORDER BY $sidx $sord LIMIT $start,$limit"; 

  

 $result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
 $responce->page = $page;
 $responce->total = $total_pages;
 $responce->records = $count; 
 $i=0;
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
 $responce->rows[$i]['id']=$row['almacen_id'];
 $responce->rows[$i]['cell']=array($row['almacen_id'],$row['razon_social'],$row['dir1'],$row['Localidad'],$row['provincia'],$row['contacto'],$row['tel'],""); $i++;
 } 
 echo json_encode($responce);

?>