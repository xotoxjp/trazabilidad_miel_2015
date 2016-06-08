<?php
header('Content-type: application/json');
require_once 'config.php';  
 
 $page = $_GET['page']; // get the requested page
 $limit = $_GET['rows']; // get how many rows we want to have into the grid
 $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
 $sord = $_GET['sord']; // get the direction
 if(!$sidx) $sidx =1; // connect to the database 
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
    global $ops;
    if($oper == 'bw' || $oper == 'bn') $val .= '%';
    if($oper == 'ew' || $oper == 'en' ) $val = '%'.$val;
    if($oper == 'cn' || $oper == 'nc' || $oper == 'in' || $oper == 'ni') $val = '%'.$val.'%';
    return " WHERE $col {$ops[$oper]} '$val' AND";
}
$where = " WHERE "; //if there is no search request sent by jqgrid, $where should be empty
$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
$searchOper = isset($_GET['searchOper']) ? $_GET['searchOper']: false;
$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
if ($_GET['_search'] == 'true') {
    $where = getWhereClause($searchField,$searchOper,$searchString);
}


// ver que onda 
$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
if($totalrows) {
    $limit = $totalrows;
}

$result = mysql_query("SELECT COUNT(*) AS count FROM deposito WHERE estado='PESADO' "); 
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];
 
$totalrows =  $count;
$limit = $totalrows;

if( $count >0 ) { 
    $total_pages = ceil($count/$limit);
    //$total_pages = ceil($count/1);
} else {
    $total_pages = 0; 
} if ($page > $total_pages) 
    $page=$total_pages; 
    $start = $limit*$page - $limit; // do not put $limit*($page - 1)
    $SQL = 'SET character_set_results=utf8';
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

    $SQL = "SELECT deposito.id_tambor, provedores.razon_social as productor,deposito.peso,deposito.tara,deposito.tipo_tambor as tipo,provedores.c1, almacenes.razon_social as sala_ext FROM deposito 
        INNER JOIN provedores ON deposito.id_productor = provedores.prov_id 
        INNER JOIN presupuestos ON deposito.id_presupuesto = presupuestos.id_presupuesto
        INNER JOIN almacenes ON presupuestos.id_sala_ext = almacenes.almacen_id
        ".$where." deposito.estado='PESADO' ORDER BY ".$sidx." ".$sord." LIMIT ".$start." , ".$limit." "; 

 $result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
 $responce->page = $page;
 $responce->total = $total_pages;
 $responce->records = $count; 
 $i=0; 
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
    $responce->rows[$i]['id']=$row['id_tambor'];
    $responce->rows[$i]['cell']=array($row['id_tambor'],$row['productor'],$row['peso'],$row['tara'],$row['tipo'],$row['c1'],$row['sala_ext'],""); 
    $i++;
 } 
 echo json_encode($responce);
?>