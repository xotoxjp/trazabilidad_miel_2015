<?php
session_start();
include_once("funciones.php");

$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$vista="Lote";
$id_usuario=$_SESSION["id_usuario"];

$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$i=0;

if ($id_usuario<1){}
else{
  $a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' WHERE id_usuario='.$id_usuario.' AND proceso="Procesos" AND orden=6 AND acceso="on"';
  $r=mysql_query($a,$cx_validar);
  while ($v = mysql_fetch_array($r)){
    $acceso=$v[0];
    $alta=$v[1];
    $baja=$v[2];
    $modifica=$v[3];
    $i++;break;
  }
}

if ($i<1){
  $_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";
  header("Location: ../index.php"); 
}


$last_ing = date("Y-m-d H:i:s");

$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$actualizar="UPDATE".$_SESSION["tabla_acc"]." SET fec_ult_ut='$last_ing' ,prog_utl='extaco1.php'  WHERE id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);

$actualizar='DELETE FROM '.$_SESSION["tabla_respuesta"].' WHERE login="'.$_SESSION["acceso_logg"].'" AND respuesta="exa"';
mysql_query($actualizar,$cx_validar);

/*********************************************************************************************************************************/
 ?>
 <html>
 <head>
    <title>Orden de Compra</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta charset="UTF-8"> 
    <link rel="shortcut icon" href="../frames/fotos/basket37.png">
		<link href='../frames/grid/css/jquery-ui-custom.css' rel='stylesheet' type='text/css'/>	    
		<link href='../frames/grid/css/ui.jqgrid.css' rel='stylesheet' type="text/css"/>
		<link href='../frames/css/extaco1.css' rel='stylesheet' type='text/css'/>
		<script src='../frames/grid/js/jquery-1.11.1.js'></script>			
		<script src='../frames/grid/js/jquery.jqGrid.min.js'></script>
		<script src='../frames/grid/js/grid.especial-locale-es.js'></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>  
</head>
<body>
	<div id="footer">   
			<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
	</div>
  
  <div id="tab-container" class='tab-container'>
    <h1>Tambores a Confirmar</h1>     
      <div id="tabcompra">
        <div  id='botonera_Analisis'>
          <ul> 
            <li id='analizar'>
              <a  class="tooltip-right" data-tooltip="Ejecutar proceso de compra de los elementos seleccionados">COMPRAR</a>
            </li>
          </ul> 
        </div>   
        <div id ='subgrid'>
           <table id="grillaComprar"></table>
           <div id="pgrillaComprar"></div>
       </div>     
      </div> 
  </div> 

	<div id="footer">   
			<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
	</div>	


</body>	
		<script src="../frames/js/motorExtaco1.js" type="text/javascript"> </script>   
</html>