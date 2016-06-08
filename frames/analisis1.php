<?php
	session_start();
	include_once("funciones.php");
	  //echo "La variable de sesi&oacute;n es: " . session_id();
	$nivel_dato=$_SESSION["acceso_acc"];
	$ccli=$_SESSION["acceso_sector"];
	$id_usuario=$_SESSION["id_usuario"];
	$i = $id_usuario + 0;
	if ($i<1)  {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); echo '1';}
	$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
	mysql_select_db($_SESSION["base_acc"]);
	$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=5 and acceso="on"';
	$r=mysql_query($a,$cx_validar);$i=0;
	while ($v = mysql_fetch_array($r)){
	  $acceso=$v[0];
	  $alta=$v[1];
	  $baja=$v[2];
	  $modifica=$v[3];
	  $i++;break;
	}
	if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }

	$last_ing = date("Y-m-d H:i:s"); ;
	$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
	mysql_select_db($_SESSION["base_acc"]);
	$actualizar="UPDATE ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='analisis1.php'  where id_usuario=".$_SESSION["id_usuario"];
	mysql_query($actualizar,$cx_validar);
	$actualizar='DELETE FROM '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="ana" and com1="'.session_id().'"' ;
	mysql_query($actualizar,$cx_validar);

	$login=$_SESSION["acceso_logg"];
?>

<!DOCTYPE html>
<head>
	<title>Laboratorio</title>
  	<meta name="viewport" content="width=device-width,initial-scale=1">
  	<meta charset="UTF-8"> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="fotos/matraz.jpg">
   	<link href='grid/css/jquery-ui-custom.css' rel='stylesheet' type='text/css'/>	    
	<link href='grid/css/ui.jqgrid.css' rel='stylesheet' type="text/css"/>
	<link href='css/analisis1.css' rel='stylesheet' type='text/css'/>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id ="main">
		<div id="footer">   
			<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
		</div>
		<h2>Datos de Laboratorio</h2>
		<div style="padding:30px;border:2px solid darkgrey;width:40rem;height:5rem;background:skyblue;display:none;" id ="c">
			NO HA SELECCIONADO NINGUNA MUESTRA AUN!
		</div>	    
		<div id='botonera_Analisis'>
			<ul>
			<?php if (($login=='amt') || ($login=='lab')){  ?>
				<li id='analizar'>
				   <a  class="tooltip-bottom" data-tooltip="Define los analisis a realizar para los elementos seleccionados">Definir Analisis</a>
		        </li>
			
				<li id='editar_analisis'>
				   <a  class="tooltip-bottom" data-tooltip="Edita los valores de analisis para los elementos seleccionados">Editar Valores</a>
				</li>
			<? } ?>	
				<li id='ver_analisis'>
				   <a  class="tooltip-bottom" data-tooltip="Visualiza los valores de analisis para los elementos seleccionados">Ver Resultados</a>
				</li>			
			</ul>      
		</div>
	    <div id="seleccion">
	    	<h3 id=""> Seleccion tipo de Muestra </h3>	
	    								
			<select name='' id='selMuestra'>
				<option value='0'>Selecciona una Opción</option>			
				<option value='EXT'>ESPERANDO DEFINICION DE ANALISIS</option>
				<option value='LAB'>MUESTRAS A ANALIZAR</option>
				<option value='EXA'>COMPRAS SIN MUESTRA</option>
				<option value='MOV'>EN STOCK</option>
			</select>
	    </div>			
	  	<div id="tab-container" class='tab-container'>
	    	<ul class='etabs'>
	      		<li class='tab'><a href="#tabgrillapresupuesto">Muestras por Presupuesto</a></li>
	      		<li class='tab'><a href="#tabgrillamuestras">Muestras por Número</a></li>       
	    	</ul>
	    	<div class='panel-container'>
				<div id='tabgrillapresupuesto'>
					<div id ='subgrid'>
	         			<table id="listsg11"></table>
		     			<div id="pagersg11"></div>
					</div>
				</div>
				<div id='tabgrillamuestras'>
					<div id ='subgrid'>
	         			<table id="gridanalisisp"></table>
		     			<div id="pgridanalisisp"></div>
					</div>
					<!--div id="contenido"></div-->
				</div>
			</div>
		</div>	
		<div id="footer">   
			<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
		</div>
    </div>
	<input type='hidden' id="currentUser" value='<?php echo $login ?>'>	
</body>
	<script src='grid/js/jquery-1.11.1.js'></script>
	<script src='grid/js/jquery.jqGrid.min.js'></script>
	<script src='grid/js/grid.locale-es.js'></script>
    <script src="js/jquery.hashchange.min.js" type="text/javascript"></script>
    <script src="js/jquery.easytabs.min.js" type="text/javascript"></script>
    <script src="js/motorAnalisis1.js" type="text/javascript"> </script>
    <script src="js/motorAnalisisPistol.js" type="text/javascript"> </script> 
    <script src="js/bootstrap.min.js"></script>
    <script> 	
    	$('#tab-container').easytabs();
    	$(document).ready(function(){
	    	var User = $('#currentUser').val();
	    	//console.log(User);
	    	
	    	if (User == 'com'){
	    		$("#selMuestra option[value=EXT]").attr('disabled','disabled');
	    		$("#selMuestra").val('LAB');
		        // ejecutamos el evento change()
		        $("#selMuestra").change();
		        $("#seleccion").css("left","-200px");
	    	}
	    	if (User == 'com'){
	    		$("#selMuestra").val('EXT');
		        // ejecutamos el evento change()
		        $("#selMuestra").change();
	    	}
			
	    	/*****************************************************************************************/	
	    	/*************************habilitar o deshabilitar botones segun select*******************/	
	    	/*****************************************************************************************/	
	    	$("#selMuestra").change(function(){
	    		var estado=$(this).val();
	    		if (estado=='0'){
	    			$("#botonera_Analisis").attr('disabled');
	    		}
	    		else{
	    			$("#botonera_Analisis").removeAttr('disabled');	
	    		}
	    		console.log(estado);
	    	}).change();;

	    });	
    </script>
</html>