<?php

 error_reporting(0);
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
    return " WHERE $col {$ops[$oper]} '$val' ";
}
$where = ""; //if there is no search request sent by jqgrid, $where should be empty
$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
$searchOper = isset($_GET['searchOper']) ? $_GET['searchOper']: false;
$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
if ($_GET['_search'] == 'true') {
    $where = getWhereClause($searchField,$searchOper,$searchString);
}
// 
$a='SELECT mov_detalle.lote_env_sec,mov_detalle.tipo_mov,mov_cabecera.fecha,mov_detalle.nro_mov,mov_cabecera.almac_id_des,almacenes.razon_social,';
$a=$a.'mov_cabecera.sala_ext,mov_detalle.lote_ext,mov_detalle.lote_id,';
$a=$a.'mov_detalle.cosecha,mov_cabecera.fecha_vto,mov_detalle.sublote_id,mov_det_anal.analisis_id,';
$a=$a.'mov_detalle.tipo_campo,mov_detalle.cumple,mov_detalle.prov_id,provedores.razon_social FROM mov_detalle INNER JOIN ';
$a=$a.'mov_cabecera ON mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
$a=$a.'mov_det_anal ON mov_detalle.lote_id=mov_det_anal.lote_id  INNER JOIN ';
$a=$a.'provedores ON mov_cabecera.prov_id=provedores.prov_id  INNER JOIN ';
$a=$a.'almacenes ON mov_cabecera.almac_id_des=almacenes.almacen_id ';
 
 
 
 
 $result = mysql_query("SELECT COUNT(*) AS count FROM clientes");
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
 $SQL = 'SET character_set_results=utf8';
 $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
 $SQL = "SELECT * FROM clientes ".$where."ORDER BY $sidx $sord LIMIT $start , $limit"; 
 $result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
 $responce->page = $page;
 $responce->total = $total_pages;
 $responce->records = $count; 
 $i=0; 
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
 $responce->rows[$i]['id']=$row['cliente_id'];
 $responce->rows[$i]['cell']=array($row['lote_env_sec'],$row['razon_social'],$row['dir1'],$row['Localidad'],$row['pais'],$row['contacto'],$row['email'],$row['tel'],""); $i++;
 } 
 echo json_encode($responce);

?>