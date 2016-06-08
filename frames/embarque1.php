<?php
session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=14 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }
else { 
/***************************************************************************************************************/
$last_ing = date("Y-m-d H:i:s"); ;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='embarque1.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);
$actualizar='DELETE FROM '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="emb"';
mysql_query($actualizar,$cx_validar);
}
/****************************************************************************************************************/
?>
<html>
	<head>
  		<title>Embarques</title>
	  	<meta name="viewport" content="width=device-width,initial-scale=1"> 
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  		<link rel="shortcut icon" href="fotos/caja.jpg">  
  		<link href='css/embarque.css' rel='stylesheet' type='text/css'/>
  		<link href='grid/css/jquery-ui-custom.css' rel='stylesheet' type='text/css'/>     
  		<link href='grid/css/ui.jqgrid.css' rel='stylesheet' type="text/css"/>	    
  		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  		<link href="css/easytabs.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="footer">   
			<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
		</div>
  		<h2>Detalle de Embarques</h2>	
	  	<div id="tab-container" class='tab-container'>
		    <ul class='etabs'>
		      <li class='tab'><a href="#tabemb">Preembarques</a></li>
		      <li class='tab'><a href="#tabexport">Exportados</a></li>     
		    </ul>
	    <div class='panel-container'>
	    	<!--primer tab-->     
			<div id="tabemb">
				<h2>Embarques</h2>
		        <div id='botonera_Analisis'>
		          <input type="button" class="boton" id="asignar_embarque" data-toggle="modal" data-target="#ModalAsignacion" value="Confirmar Embarque"/>
		          <input type="button" class="boton" id="generar_packingList" value="Generar Packing List"/>
		        </div>
		        <div id ='grilla'>
		          <table id="grillaExportEmb"></table>
		          <div id="pgrillaExportEmb"></div>
		        </div> 
		    </div> 
			<!--fin primer tab--> 
			<!--segundo tab-->     
			<div id="tabexport">
				<h2>Exportados</h2>
		        <div id='botonera_Analisis'>

		        </div>
		        <div id ='grilla'>
		          <table id="grillaExportOut"></table>
		          <div id="pgrillaExportOut"></div>
		        </div> 
		    </div> 
			<!--fin segundo tab--> 
		</div>	
		<div id="footer">   
			<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
		</div>



       <!-- Modal -->
      <div class="modal fade" id="ModalAsignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Detalles de Embarque</h4>
            </div>
            <div class="modal-body">         
              <div id="datosenvio">
                <h4>Datos de Embarque para tambores seleccionados</h4>
                  <label for="slt-clientes">Cliente</label>  
                  <select id="cliente" class="form-control">
                    <?  
                        $cx_validar = mysql_pconnect("localhost","root","root");
                        mysql_select_db("chmiel");
                        $actualizar1="SELECT `cliente_id`, `razon_social` FROM clientes ORDER BY cliente_id" ;
                        $rs_validar1 = mysql_query($actualizar1,$cx_validar); 
                        while ($v_validar1 = mysql_fetch_array($rs_validar1)){
                          echo '<option value='.$v_validar1[0];
                          echo '>'.$v_validar1[1].'</option>'; 
                        }
                    ?>
                  </select>
                <br>          
                <p>Pais:  <input type='text' name='pais' id='pais' placeholder='Pais' size='10'/></p>          
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Salir</button>
              <button type="button" id="enviarExportNuevo" class="btn btn-primary btn-lg">Asignar</button>
            </div>

          </div>
        </div>
      </div>
      <!-- Fin Modal --> 
	</body>
    <script src='../frames/grid/js/jquery-1.11.1.js'></script>      
    <script src='../frames/grid/js/jquery.jqGrid.min.js'></script>
    <script src='../frames/grid/js/grid.locale-es.js'></script>
    <script src="js/jquery.hashchange.min.js" type="text/javascript"></script>
    <script src="js/jquery.easytabs.min.js" type="text/javascript"></script> 
    <script src="js/motorExportEmba.js" type="text/javascript"> </script>
    <script src="js/motorExportOut.js" type="text/javascript"> </script>
 	  <script src="js/bootstrap.min.js"></script>
 	  <script>
 		  $('#tab-container').easytabs();		
 	  </script>
</html>