<?php
session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=1 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
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
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='abm.clientes'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Datos de Clientes</title>
		<!--link href="css/clientes1.css" rel="stylesheet" type="text/css" -->
		<link href='grid/css/jquery-ui-custom.css' rel='stylesheet' type="text/css"/>
		<link href='grid/css/ui.jqgrid.css' rel='stylesheet' type="text/css"/>
		<script src='grid/js/jquery-1.11.1.js'></script>	
		<script src='grid/js/grid.locale-es.js'></script>
		<script src='grid/js/jquery.jqGrid.min.js'></script>
		<link rel="shortcut icon" type="image/x-icon" href="fotos/icono1.ico">
        <style>
		  @import 'css/clientes1.css';
        </style>
	</head>
	<body> 
		<div id="footer">   
			<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al menú principal</a>
		</div>
		<h1>Clientes</h1>
		<div class='wrapper'>
			<table id="rowed2"></table> 
			<div id="prowed2"></div>	
		</div>	
		<div id="footer">   
			<img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al menú principal</a>
		</div>
		<?php
		  
		?>
       	<script>
			jQuery("#rowed2").jqGrid({
   			url:'grid/servercliente.php?q=3',
			datatype: "json",
   			colNames:['NO CLIENTE','RAZON SOCIAL', 'DIRECCION', 'LOCALIDAD','PAIS','CONTACTO','E-MAIL','TELEFONO'], 
			colModel:[ 
				{name:'cliente_id',index:'cliente_id', width:90,align:"center",classes: 'cvteste'}, 
				{name:'razon_social',index:'razon_social', width:190,classes: 'cvteste',editable:true}, 
				{name:'dir1',index:'dir1', width:220,classes: 'cvteste',editable:true},
				{name:'Localidad',index:'Localidad', width:160,classes: 'cvteste',editable:true},
				{name:'pais',index:'pais', width:100, sortable:false,classes: 'cvteste',editable:true},
				{name:'contacto',index:'contacto', width:180, sortable:false,classes: 'cvteste',editable:true},
				{name:'email',index:'email', width:200, sortable:false,classes: 'cvteste',editable:true},
				{name:'tel',index:'tel', width:120, sortable:false,classes: 'cvteste',editable:true}   	   
			],
   			rowNum:10,
   			rowList:[10,20,30],
   			pager: '#prowed2',
   			sortname: 'razon_social',			
			viewrecords: true,
			height:'100%',
			width:'100%',
			sortorder: "asc"        
			});
			jQuery("#rowed2").jqGrid('navGrid',"#prowed2",{edit:false,add:false,del:false,search:true},
				{url:'grid/updatecliente.php'},{url:'grid/addcliente.php'},{url:'grid/deletecliente.php'},{sopt : ['cn','eq']}
			);	   
		    /*custom edit button */
			jQuery("#rowed2").navGrid('#prowed2',{edit:false,add:false,del:false,search:false})
				.navButtonAdd('#prowed2',{caption:"", buttonicon:"ui-icon-pencil", onClickButton: function(){     
						var myGrid = $('#rowed2'),
						selectedRowId = myGrid.jqGrid ('getGridParam', 'selrow'),
						cellValue = myGrid.jqGrid ('getCell', selectedRowId, 'cliente_id');		 
						if (cellValue!==false){
						  /*pasa el vinculo con el id que se guardo en cellValue de la fila seleccionada*/
					   	  location.href='mod_clientes.php?ID='+cellValue+'&EDIT=edit';
						}else{
							alert("Por favor seleccione una fila");
						}
						}, 
			   position:"last"
			});	
			/*custom add button */
			jQuery("#rowed2").navGrid('#prowed2',{edit:false,add:false,del:false,search:false})
				.navButtonAdd('#prowed2',{caption:"", buttonicon:"ui-icon-plus", onClickButton: function(){     
						 location.href='mod_clientes.php?nuevocliente=si';	
						}, 
			   position:"last"
			});
			jQuery("#rowed2").navGrid('#prowed2',{edit:false,add:false,del:false,search:false})
				.navButtonAdd('#prowed2',{caption:"", buttonicon:"ui-icon-trash", onClickButton: function(){     
						var myGrid = $('#rowed2'),
						selectedRowId = myGrid.jqGrid ('getGridParam', 'selrow'),
						cellValue = myGrid.jqGrid ('getCell', selectedRowId, 'cliente_id');		 
						
						if (cellValue!==false){
							/*pasa el vinculo con el id que se guardo en cellValue de la fila seleccionada*/
						    if(confirm("SEGURO DE BORRAR ESTE CLIENTE ?")){
							    $.get('includes/baja_X_elemento.php?ID='+cellValue+'&datoRuta=clientes1',function(respuesta){
			    	                        if(respuesta){
				    	                        $("#rowed2").trigger('reloadGrid');								   	                        
			                                }
			    	                    });
							}// fin if confirm
						}
						else{
						   alert("Por favor seleccione una fila"); 
						}
						}, 
			   position:"last"
			});	

		</script>      
	</body>
</html>