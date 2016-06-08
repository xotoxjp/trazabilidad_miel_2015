<?php
header('Content-type: application/json');
require_once 'config.php';  

$tipoAlmacen = $_GET['almacen']; // tipo de almacen elegido: Central - CHACO 

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


if (isset( $_GET['id_tambor'])){
	$id_tambor= $_GET['id_tambor'];
    $id_tambor = ltrim($id_tambor, '0');
	$where = " WHERE deposito.id_tambor LIKE '".$id_tambor."%' AND" ; 
}

if (isset( $_GET['productor'])){
	$productor= $_GET['productor'];
	$where = " WHERE provedores.razon_social LIKE '".$productor."%' AND" ; 
}

if (isset( $_GET['c1'])){
	$c1= $_GET['c1'];
	$where = " WHERE provedores.c1 LIKE '".$c1."%' AND" ; 
}

if (isset( $_GET['sala_ext'])){
	$sala_ext= $_GET['sala_ext'];			
	$where = " WHERE almacenes.razon_social  LIKE '".$sala_ext."%' AND" ; 
}



$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
if($totalrows) {
    $limit = $totalrows;
}

$query0="SELECT COUNT(*) AS count FROM deposito WHERE estado='TRANSITO' AND deposito.almacen='$tipoAlmacen' ";
$result = mysql_query($query0);
//echo $query0;
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];
$totalrows =  $count;
//$limit = $totalrows;
if( $count >0 ) { 
    $total_pages = ceil($count/$limit);
    //$total_pages = ceil($count/1);
} else {
    $total_pages = 0; 
} if ($page > $total_pages) $page=$total_pages; 
 $start = $limit*$page - $limit; # do not put $limit*($page - 1)
if ($start<0) {
    $start=0;
}
#query para llenar la grilla de tambores a recibir para pesar
 $SQL = 'SET character_set_results=utf8';
 $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
 $SQL = "SELECT deposito.id_tambor,deposito.num_ingreso,provedores.razon_social as productor ,provedores.c1, almacenes.razon_social as sala_ext FROM deposito 
        INNER JOIN provedores ON deposito.id_productor = provedores.prov_id 
        INNER JOIN presupuestos ON deposito.id_presupuesto = presupuestos.id_presupuesto
        INNER JOIN almacenes ON presupuestos.id_sala_ext = almacenes.almacen_id
        ".$where." deposito.estado='TRANSITO' AND deposito.almacen='$tipoAlmacen'
        ORDER BY ".$sidx." ".$sord." LIMIT ".$start." , ".$limit." "; 
 //echo $SQL;
 $result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
 $responce->page = $page;
 $responce->total = $total_pages;
 $responce->records = $count; 
 $i=0; 
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
    $responce->rows[$i]['id']=$row['id_tambor'];
    $responce->rows[$i]['cell']=array($row['id_tambor'],$row['num_ingreso'],$row['productor'],$row['c1'],$row['sala_ext'],""); 
    $i++;
 } 
 echo json_encode($responce);
?>