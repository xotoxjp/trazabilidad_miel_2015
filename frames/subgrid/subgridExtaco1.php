<?php
header('Content-type: application/json');
require_once 'config.php'; 


$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx =1;



 
$examp = $_GET["q"]; //query number

$id = $_GET['id'];








    $SQL = 'SET character_set_results=utf8';
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

    $condicion= "SELECT stat FROM laboratorio WHERE num_presupuesto =".$id." GROUP BY stat ";
    $resultcond = mysql_query( $condicion ) or die ("Couldn't execute query.".mysql_error());


    $row = mysql_fetch_array($resultcond,MYSQL_ASSOC);
    //echo $row['stat'];
    
    if ($row['stat'] == 'EXA' ){

    	$result = mysql_query("SELECT COUNT( DISTINCT id_tambor ) AS count FROM laboratorio WHERE laboratorio.num_presupuesto =".$id."
		AND (stat!='MOV') ");
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


    	

		$SQL = "SELECT laboratorio.id_tambor, laboratorio.hmf, laboratorio.color, laboratorio.humedad,laboratorio.acidez, laboratorio.tipo_miel, laboratorio.resultado, provedores.razon_social
		FROM laboratorio
		INNER JOIN provedores ON laboratorio.id_productor=provedores.prov_id  
		WHERE laboratorio.num_presupuesto =".$id."
		ORDER BY laboratorio.id_tambor   ";




    }else{

    	$result = mysql_query("SELECT COUNT( DISTINCT id_tambor ) AS count FROM laboratorio WHERE laboratorio.num_presupuesto =".$id."
		AND  (laboratorio.resultado='cumple' OR laboratorio.resultado='no cumple') AND (stat!='MOV') ");
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



	 	$SQL = "SELECT laboratorio.id_tambor, laboratorio.hmf, laboratorio.color, laboratorio.humedad,laboratorio.acidez, laboratorio.tipo_miel, laboratorio.resultado, provedores.razon_social
		FROM laboratorio
		INNER JOIN provedores ON laboratorio.id_productor=provedores.prov_id  
		WHERE laboratorio.num_presupuesto =".$id."
		AND  (laboratorio.resultado='cumple' OR laboratorio.resultado='no cumple') AND (stat!='MOV')
		GROUP BY laboratorio.id_tambor
		ORDER BY ".$sidx." ".$sord." LIMIT ".$start." , ".$limit." ";


		//echo "$SQL";
	};







 
 $result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());
 $responce->page = $page;
 $responce->total = $total_pages;
 $responce->records = $count; 
 $i=0; 
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
 	$responce->rows[$i]['id']=$row['id_tambor'];
 	$responce->rows[$i]['cell']=array($row['id_tambor'],$row['hmf'],$row['color'],$row['humedad'],$row['acidez'],$row['razon_social'],$row['tipo_miel'],$row['resultado'],""); $i++;
 } 
 echo json_encode($responce);
 ?>		