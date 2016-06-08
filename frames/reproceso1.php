<?
session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=9 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
	$acceso=$v[0];
	$alta=$v[1];
 	$baja=$v[2];
 	$modifica=$v[3];
 	$i++;
 	break;
}
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }


$last_ing = date("Y-m-d H:i:s"); ;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='reproceso1.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);


?>
<html>
	<head>
	  	<title>Ingreso a Depósito</title>
	  	<meta name="viewport" content="width=device-width,initial-scale=1">
	  	<meta charset="UTF-8">
		<link rel="shortcut icon" href="fotos/chmiel.ico">	
	    <link href='grid/css/jquery-ui-custom.css' rel='stylesheet' type='text/css'/>	    
		<link href='grid/css/ui.jqgrid.css' rel='stylesheet' type="text/css"/>
		<link href='css/analisis1.css' rel='stylesheet' type='text/css'/>
		<link href='css/reproceso1.css' rel='stylesheet' type='text/css'/>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	</head>
 <body>
	<div id="footer">   
		<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
	</div>
	<h2>Ingreso a Depósito</h2>
	<div id="seleccionAlmacen">
    	<h3 id="">Almacén de Recepción 		    								
		<select name='' id='selAlmacen'>
			<option value=' '>Selecciona una Opción</option>			
			<option value='CASA CENTRAL'>Casa Central Don Torcuato</option>
			<option value='CHACO'>Sucursal Chaco</option>
		</select>
		</h3>
	</div>		 	
  	<div id="tab-container" class='tab-container'>
	    <ul class='etabs'>
	      <li class='tab'><a href="#tabpendientes">Tambores pendientes de Ingreso</a></li>
	      <li class='tab'><a href="#tabingresos">Tambores a Ingresar a Stock</a></li>       
	      <li class='tab'><a href="#tabhistoricos">Ingresos de Stock</a></li>       
	    </ul>
    <div class='panel-container'>
    	<!--primer tab-->     
		<div id="tabpendientes">
			<div id ='subgrid'>
		        <table id="grillaPesos"></table>
				<div id="pgrillaPesos"></div>
			</div>
			<div id="pesajes">			
				<h4>Datos de Balanza</h4>			
		    	<p id="titulo">Tambor Seleccionado:</p> <input type='number' name='tambor_select' id="tSeleccionado">
				<p class="botonesHoriz">Peso Bruto: <input type='number' name='bruto'  id='pesobruto' value=0 min=0 max=2000 size='4' maxlength='4'></p>
				<p class="botonesHoriz">Tara: <input type='number' name='tara'  id='tara' value=15 min=0 max=400 size='4' maxlength='4'> </p>
				<div class="selectTipoTambor"><p id="titulo">Seleccione Tipo de Tambor:</p> <select id="tipotambor"  name="tipotambor"><option value="N">NUEVO</option><option value="R">RECICLADO</option></select></div>
				<input type="button" class="boton" id="leerbalanza" value="Leer Balanza"/>
				<input type="button" class="boton" id="cargarpeso" value="Ingresar Tambor"/>
			</div>
		</div> 
		<!--fin primer tab-->              
        <!--segundo tab-->
	    <div id="tabingresos">
		    <div id ="subgridPesos">
	           <table id="grillaConPesos"></table>
	           <div id="pgrillaConPesos"></div>
	        </div>	    	 		
	 		<div id="botonera">		
	 			<!-- Button trigger modal -->					    
				<input type="button" class="boton" id="confirmar" data-toggle="modal" data-target="#myModal" value="confirmar"/>
				<input type="button" class="boton" id="cancelar" value="cancelar"/>
			</div>			 
	    </div>
        <!--fin segundo tab-->
        <!--tercer tab-->
	    <div id="tabhistoricos">
	 		<div id="botonera">	
				<input type="button" class="boton" id="planilla_ing" value="Obtener Planilla"/>
			</div>
		    <div id ="subgridIngresos">
	           <table id="grillaIngresos"></table>
	           <div id="pgrillaIngresos"></div>
	        </div>	    	 		
	    </div>
        <!--fin tercer tab-->
    </div>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Ingreso a Depósito</h4>
	      </div>
	      <div class="modal-body">			       
			<label for='num_ingreso'>Número de Ingreso:</label>
				<input type='number' name='num_ingreso' id='num_ingreso' placeholder='Num Ingreso' size='10'/>
<!-- 				<select name='num_ingreso' id='num_ingreso' style="width:12em">
	              <?  
	                $cx_validar = mysql_pconnect("localhost","root","root");
	                mysql_select_db("chmiel");
	                $actualizar1="SELECT DISTINCT num_ingreso FROM deposito WHERE estado='PESADO'" ;
	                $rs_validar1 = mysql_query($actualizar1,$cx_validar); 
	                while ($v_validar1 = mysql_fetch_array($rs_validar1)){
	                  echo '<option value='.$v_validar1[0];
	                  echo '>'.$v_validar1[0].'</option>';
	                }
	              ?>
	            </select> -->
	 		<br>  
	 		<label for="slt-deposito">Depósito:</label>  
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
	 		<div id="datosenvio">
		 		<h4>Datos de Envío</h4>
		 		<!--p>Remito:  <input type='text' name='remito' id='remito' placeholder='Num Remito' size='20' maxlength='20' /></p-->
		 		<!--p>Factura:  <input type='text' name='factura' id='factura' placeholder='Num Factura' size='20' maxlength='20' /></p-->
		 		<p>Remito/Factura:</p>
		 		<p><select id='selectfr'><option value="remito">R</option><option value="factura">F</option></select><input type='text' name='remfac' id='remfac' placeholder='Número' size='14' maxlength='20'/></p>
				
				<p>Fecha de llegada: <input type="date" id="datepicker" name='dateOrigen' placeholder='fecha de llegada'/></p>
			    </br>		 		
			</div>
	 		<div class="modal-footer">
				<button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Salir</button>
	        	<button type="button" id="enviarStockNuevo" class="btn btn-primary btn-lg">Guardar</button>
	      	</div>
	      </div><!--modal body end-->
	    </div><!--modal content end-->
	  </div><!--modal dialog end-->
	</div><!--modalfade end-->
	<!-- End of Modal -->  

	<div id="footer">   
		<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
	</div>

 </body>
<script src='grid/js/jquery-1.11.1.js'></script>			
<script src='grid/js/jquery.jqGrid.min.js'></script>
<script src='grid/js/grid.locale-es.js'></script>
<script src="js/jquery.hashchange.min.js" type="text/javascript"></script>
<script src="js/jquery.easytabs.min.js" type="text/javascript"></script>
<script src="js/motorTamboresPesar.js" type="text/javascript"></script>
<script src="js/motorTamboresIngresar.js" type="text/javascript"></script>
<script src="js/motorIngresos.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootbox.min.js"></script>
 <script>
	$('#tab-container').easytabs();
		$("#leerbalanza").click(function(){
		var almacen = $('#selAlmacen').val();
		//console.log(almacen);		
		realizaProceso(almacen);        
	});

	function realizaProceso(almacen){ 	             
        $.ajax({
            url:'includes/leerbalanza.php?almacen='+almacen,
            dataType:'json',                     
            beforeSend: function () {
                $("#resultado").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                $("#resultado").html("  ");
                var pesoresult = response.peso;
                $("#pesobruto").val(pesoresult);	                    	                	                        
            }
        });
	}


	$("#cargarpeso").click(function(){
		var tambor=$("#tSeleccionado").val();
		var peso=$("#pesobruto").val();
		var tara=$("#tara").val();
		var tipotambor=$("#tipotambor option:selected").val(); 
		console.log(tambor, peso, tara, tipotambor);
		//alert(tambor);
		if(tambor>0){   
			//alert("paso el if");
			moverTambor(tambor,peso,tara,tipotambor);
				location.reload();
		}else{
				alert("Seleccione un Tambor haciendo doble click en la grilla");
		}
	});	

	$("#tipotambor").change(function() {
		// body...
		var valor=$("#tipotambor option:selected").val();
		console.log(valor);
		if(valor=="R") {
			$("#tara").val(16);
		} else{
			$("#tara").val(15);
		};
		
	})

	function moverTambor(tambor,peso,tara,tipotambor){ 	             
        $.ajax({
            url:'includes/cargarTambor.php',
            type:'post',
            data: { 
			    "notambor":tambor, 
			    "peso":peso,
			    "tara":tara,
			    "tipotambor":tipotambor,
			},                     
            success:  function (response) {
            	alert("Tambor Pesado");	                    
            }
        });
	}

	$("#selAlmacen").change(function() {
		var opt=$(this).val();
		console.log("valor opcion "+opt);
	    $("#slt_deposito").val(opt);
	});

	$("#enviarStockNuevo").click(function(){
		//primeras lineas del modal número de ingreso y déposito
		var ingreso=$("#num_ingreso").val();
		var deposito=$("#slt_deposito  option:selected" ).text();
		//datos de envío
		var sltfr=$("#selectfr").val();		
		//valor de remito o factura
		var valremfac=$("#remfac").val();

		/**
		var remito=$("#remito").val();
		var factura=$("#factura").val();
		**/

		var fllegada=$("#datepicker").val();
		
		/*
		var patente=$("#patente").val();
		var chofer=$("#chofer").val();
		var transporte=$("#transporte").val();
		*/

		var tambores = $("#grillaConPesos").jqGrid ('getGridParam', 'selarrrow');		
		//var tambores=JSON.stringify(indices_tam);
		console.log(tambores);

		//proceso si no existe modulo logistica --cargarStock(valremfac,sltfr,deposito,ingreso,remito,factura,fllegada,patente,chofer,transporte,tambores);
		cargarStock(valremfac,sltfr,deposito,ingreso,fllegada,tambores);
	});

	function cargarStock(valorfr,rof,deposito,ingreso,fllegada,tambores){ 	             
        $.ajax({
            url:'includes/cargarDeposito.php',
            type:'post',
            data: { 
            	"valorfr":valorfr,
            	"rof":rof,
            	"deposito": deposito,
            	"num_ing": ingreso,
			    //"noremito": remito,
			    //"nofactura": factura,
			    "fechall":fllegada,
			    //"nopatente":patente,
			    //"chofer":chofer,
			    //"transporte":transporte,
			    "tambores":tambores					    
			},                     
            success:  function (response) {
            	//alert("Tambor Guardado");	
            	location.href="reproceso1.php";                    
            }
        });
	}
</script>
</html>