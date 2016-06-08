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





if (isset( $_GET['filters'])){
    $json = $_GET['filters']; // get the requested field
    $jsonArray=stripslashes($json);
    //$filtro= json_decode($jsonArray,true);
    //echo $jsonArray;
    //echo $filtro['groupOp'];
    $jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($jsonArray, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);
    foreach ($jsonIterator as $key => $val) {
        if(is_array($val)) {
            //echo "$key:\n";
        } else {
            //echo "$key => $val\n";
            if($key=='groupOp')$conector=$val;
            if($key=='op')$op=$val;
            if($key=='data')$data=$val;
            if($key=='field'){
                if($val=='id_tambor')$field="deposito.id_tambor";
                if($val=='num_presupuesto')$field='presupuestos.num_presupuesto';
                if($val=='productor')$field='provedores.razon_social';
                if($val=='localidad')$field='provedores.Localidad';
                if($val=='renapa')$field="provedores.c1";
                if($val=='sala_ext')$field='almacenes.razon_social';   
            }
        }
    }
    if ($data) {
       $where = getWhereClause($field,$op,$data);
    }
    //echo $where;
}

//echo $op ;
//echo $conector;
//echo $field ;
//echo $data ;


$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
if($totalrows) {
    $limit = $totalrows;
}

$result = mysql_query("SELECT COUNT(*) AS count FROM deposito WHERE estado='COMPRADO'");
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];
$totalrows =  $count;

if( $count >0 ) { 
    $total_pages = ceil($count/$limit);
} else {
    $total_pages = 0; 
} 
if ($page > $total_pages) $page = $total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
//if ($start < 0) $start = 0;

 $SQL = 'SET character_set_results=utf8';
 $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
 //'Tambor','Presupuesto','Productor','Color','Localidad','Renapa','Sala','Peso Bruto','Tara','Peso Neto'
 $SQL = "SELECT deposito.id_tambor,presupuestos.num_presupuesto,laboratorio.color,provedores.razon_social as productor,provedores.Localidad,provedores.c1, almacenes.razon_social as sala_ext  
 		FROM deposito 
        INNER JOIN provedores ON deposito.id_productor = provedores.prov_id 
        INNER JOIN presupuestos ON deposito.id_presupuesto = presupuestos.id_presupuesto
        INNER JOIN almacenes ON presupuestos.id_sala_ext = almacenes.almacen_id
        INNER JOIN laboratorio ON presupuestos.id_tambor = laboratorio.id_tambor
        ".$where." deposito.estado='COMPRADO' ORDER BY ".$sidx." ".$sord." LIMIT ".$start." , ".$limit." "; 

 //echo "$SQL";
 $result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
 $responce->page = $page;
 $responce->total = $total_pages;
 $responce->records = $count; 
 $i=0; 
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
	$responce->rows[$i]['id']=$row['id_tambor'];
	$responce->rows[$i]['cell']=array($row['id_tambor'],$row['num_presupuesto'],$row['color'],$row['Localidad'],$row['productor'],$row['c1'],$row['sala_ext'],""); 
	$i++;
 } 
 echo json_encode($responce);
?>