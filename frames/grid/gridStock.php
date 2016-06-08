<?php
header('Content-type: application/json');
require_once 'config.php';  
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
//echo "limit al empezar da $limit";



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
    return " WHERE $col {$ops[$oper]} '$val' AND stock.estado NOT LIKE 'EMB' ";
}

$where = " WHERE stock.estado NOT LIKE 'EMB' "; //if there is no search request sent by jqgrid, $where should be empty
$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
$searchOper = isset($_GET['searchOper']) ? $_GET['searchOper']: false;
$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;






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
                if($val=='id_tambor')$field="stock.id_tambor";
                if($val=='renapa')$field="provedores.c1";
                if($val=='sala_ext')$field='almacenes.razon_social';
                if($val=='lote')$field='deposito.num_lote';
                if($val=='peso')$field='deposito.peso';
                if($val=='tara')$field='deposito.tara' ;
                if($val=='peso_neto')$field='stock.peso_neto';
                if($val=='hmf')$field='laboratorio.hmf';
                if($val=='color')$field='laboratorio.color';
                if($val=='humedad')$field='laboratorio.humedad';
                if($val=='acidez')$field='laboratorio.acidez';
                if($val=='factura') $field='deposito.factura';
                if($val=='num_ingreso')$field='deposito.num_ingreso';
                if($val=='fecha_llegada')$field='deposito.fecha_llegada';
                if($val=='remito') $field='deposito.remito';
                if($val=='almacen') $field='deposito.almacen';
                if($val=='tipo_miel') $field='laboratorio.tipo_miel';
                if($val=='lote_export') $field='stock.lote_export';
                if($val=='rango') $field='stock.rango';   
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

$result = mysql_query("SELECT COUNT(*) AS count FROM stock  WHERE stock.estado NOT LIKE 'EMB' ");
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];
$totalrows =  $count;
//$limit = $totalrows;
if( $count >0 ) { 
    $total_pages = ceil($count/$limit);
    //echo "count da: $count";
    //echo "limit da: $limit";
    //echo "total pages(count/limit): $total_pages";
    //$total_pages = ceil($count/1);
} else {
    $total_pages = 0; 
} if ($page > $total_pages) 
    $page=$total_pages; 
    $start = $limit*$page - $limit; // do not put $limit*($page - 1)


 $SQL = 'SET character_set_results=utf8';
 $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
 $SQL = "SELECT stock.id_tambor, provedores.c1 as renapa, almacenes.razon_social as sala_ext, deposito.num_lote as lote, 
        deposito.peso, deposito.tara, stock.peso_neto, laboratorio.hmf, laboratorio.color, laboratorio.humedad, laboratorio.acidez,
        deposito.factura as factura, deposito.num_ingreso, deposito.fecha_llegada, deposito.remito, deposito.almacen, laboratorio.tipo_miel, stock.lote_export, stock.rango     
        FROM stock 
        INNER JOIN presupuestos ON stock.id_presupuesto = presupuestos.id_presupuesto
        INNER JOIN provedores ON presupuestos.id_productor = provedores.prov_id 
        INNER JOIN laboratorio ON stock.id_laboratorio = laboratorio.id_laboratorio
        INNER JOIN deposito ON stock.id_deposito = deposito.id_deposito
        INNER JOIN almacenes ON presupuestos.id_sala_ext = almacenes.almacen_id
        ".$where." ORDER BY ".$sidx." ".$sord." LIMIT ".$start." , ".$limit."  "; 
	
 //echo $SQL;	
 $result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
 $responce->page = $page;
 $responce->total = $total_pages;
 $responce->records = $count; 
 $i=0; 
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
 $responce->rows[$i]['id']=$row['id_tambor'];
 $responce->rows[$i]['cell']=array($row['id_tambor'],$row['renapa'],$row['sala_ext'],$row['lote'],$row['peso']
    ,$row['tara'],$row['peso_neto'],$row['hmf'],$row['color'],$row['humedad'],$row['acidez']
    ,$row['num_ingreso'],$row['fecha_llegada'],$row['factura'],$row['remito'],$row['almacen'],$row['tipo_miel'],$row['lote_export'],$row['rango'],""); 
 $i++;
 } 
 echo json_encode($responce);
?>