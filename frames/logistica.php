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
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='logistica.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);
$actualizar='DELETE FROM '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="emb"';
mysql_query($actualizar,$cx_validar);
}
/****************************************************************************************************************/
?>
<html>
	<head>
  		<title>Logística</title>
	  	<meta name="viewport" content="width=device-width,initial-scale=1">
      <meta charset="UTF-8"> 
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  		<link rel="shortcut icon" href="fotos/caja.jpg">  
  		<link href='css/logistica.css' rel='stylesheet' type='text/css'/>
  		<link href='grid/css/jquery-ui-custom.css' rel='stylesheet' type='text/css'/>     
  		<link href='grid/css/ui.jqgrid.css' rel='stylesheet' type="text/css"/>	    
  		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  		<link href="css/easytabs.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="footer">   
			<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
		</div>
  		<h2>Logística</h2>	
	  	<div id="tab-container" class='tab-container'>
		    <ul class='etabs'>
		      <li class='tab'><a href="#tabcompras">Tambores Comprados</a></li>
		      <li class='tab'><a href="#tabmov">Pendientes de Ingreso</a></li>     
		    </ul>
	    <div class='panel-container'>
	    	<!--primer tab-->     
			<div id="tabcompras">
		        <div id='botonera_Analisis'>
		          <input type="button" class="boton" id="asignar_embarque" data-toggle="modal" data-target="#ModalAsignacion" value="Remitir Tambores"/>
              <input type="button" class="boton" id="reporte" value="Reporte de Pendientes"/>
		        </div>
		        <div id ='grilla'>
		          <table id="grillaTamboresComprados"></table>
		          <div id="pgrillaTamboresComprados"></div>
		        </div> 
		    </div> 
			<!--fin primer tab--> 

			<!--segundo tab-->     
			<div id="tabmov">
				<h2>Tambores en Movimiento</h2>
		        <div id='botonera_Analisis'>
              <input type="button" class="boton" id="planilla_ing" value="Generar Informe de Envío"/>           
		        </div>
		        <div id ='grilla'>
		          <table id="grillaEstadoTambores"></table>
		          <div id="pgrillaEstadoTambores"></div>
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
              <h4 class="modal-title" id="myModalLabel">Tambores a Remitir</h4>
            </div>            
            <div class="modal-body">
              <div id="datosenvio">                
                <h4>Datos de Remito </h4>
                <h4>Tambores Seleccionados</h4>
                <div class="form-group"> 
                  <label for="num_ingreso">Número de Ingreso:</label>
                  <input type="text" class="form-control" id="num_ingreso">
                  <!--span class="glyphicon glyphicon-remove form-control-feedback"></span-->
                </div>
                <!--label for='num_ingreso'>Número de Ingreso:</label>
                <input type='number' name='num_ingreso' id="num_ingreso" placeholder='Num Ingreso' size='10'/>
                <br><br-->
                <br>
                <p>Depósito:  
                <select name="slt_deposito" id="slt_deposito" style="width:12em">
                  <?  
                    $cx_validar = mysql_pconnect("localhost","root","root");
                    mysql_select_db("chmiel");
                    $actualizar1="SELECT razon_social FROM almacenes WHERE tipo_almacen=4" ;
                    $rs_validar1 = mysql_query($actualizar1,$cx_validar); 
                    while ($v_validar1 = mysql_fetch_array($rs_validar1)){
                      echo '<option value='.$v_validar1[0];
                      echo '>'.$v_validar1[0].'</option>';
                    }
                  ?>
                </select>   
                </p>                       
              </div>
              <br>   
              <div id="datostransport">
                <h4>Datos Transporte</h4>
                <p>Camion: <input type='text' name='patente' id='patente' placeholder='Num Patente' size='20' maxlength='20' /></p>
                <p>Chofer:  <input type='text' name='chofer' id='chofer' placeholder='Chofer' size='20' maxlength='20' /></p>     
                <p>Transporte:  <input type='text' name='transporte' id='transporte' placeholder='Tipo transporte' size='20' maxlength='20' /></p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Salir</button>
              <button type="button" id="enviarTambores" class="btn btn-primary btn-lg">Asignar</button>
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
    <script src="js/motorLogisticaPre.js" type="text/javascript"> </script>
    <script src="js/motorLogisticaMov.js" type="text/javascript"> </script>
 	  <script src="js/bootstrap.min.js"></script>
 	  <script>
 		  $('#tab-container').easytabs();		
 	  </script>
</html>