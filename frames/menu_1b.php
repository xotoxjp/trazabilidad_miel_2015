<?php
session_start();
include_once("funciones.php");
$_SESSION["level_req"]="a";
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];

validar($logg,$pass);

$nivel_dato=$_SESSION["acceso_acc"];
$id_usuario=$_SESSION["id_usuario"];
$id_menu=$_SESSION["menu"];

if ($id_menu!="Botones"){
	header("Location: menu_1.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	 <title><?php echo $_SESSION["acceso_logg"]."&nbsp&nbsp";?>MENU </title>
	 <meta name="viewport" content="width=device-width,initial-scale=1">             
	 <meta charset="utf-8" />
	 <link rel="shortcut icon" href="fotos/menu.ico"> 
	 <link rel="stylesheet" href="css/index_style.css" /> 
 </head>
 
<body>

<header>
	<div id="menuOperaciones">		
			<div class="contenedor" id="anaMuestras">
				<img class="icon" src="fotos/tagger.png">
				<p class="texto"><a href="muencampo1.php" id="Muestras" >Compras</a></p>
			</div>
			<div class="contenedor" id="anaAnalisis">
				<img class="icon" src="fotos/labo.png">
				<p class="texto"><a href="analisis1.php" id="Analisis" >Laboratorio</a></p>
			</div>
			<div class="contenedor" id="anaExt_Acop">
				<img class="icon" src="fotos/ordencompra.png">
				<p class="texto"><a href="extaco1.php" id="Ext_Acop" >Orden de Compra</a></p>
			</div>
			<div class="contenedor" id="anaLogistica">
				<img class="icon" src="fotos/exportacion.png">
				<p class="texto"><a href="logistica.php" id="Logistica" >Logistica</a></p>
			</div>
			<div class="contenedor" id="anaReprocesos">
				<img class="icon" src="fotos/deposito.png">
				<p class="texto"><a href="reproceso1.php" id="Reprocesos" >Depósito</a></p>
			</div>
			<div class="contenedor" id="anaStock">
				<img class="icon" src="fotos/boxes.png">
				<p class="texto"><a href="stock1.php" id="Stock" >Stock</a></p>
			</div>
			<div class="contenedor" id="anaOrdEmb">
				<img class="icon" src="fotos/exportbarco.png">
				<p class="texto"><a href="embarque1.php" id="OrdEmb" >Exportación</a></p>
			</div>			
	</div>
</header>
	
<header>	
	<div id="menu">		
		<div class="contenedor" id="anaClientes">
			<img class="icon" src="fotos/clientes.png">
			<p class="texto"><a  href="clientes1.php" id="Clientes" >Clientes</a></p>
		</div>

		<div class="contenedor" id="anaProvedores">
			<img class="icon" src="fotos/honeycomb.png">
			<p class="texto"><a  href="provedores1.php" id="Provedores" >Productores</a></p>
		</div>

		<div class="contenedor" id="anaAlmacenes">
			<img class="icon" src="fotos/depositos2.png">
			<p class="texto"><a href="almacenes1.php" id="Almacenes" >Depósitos y Salas</a></p>
		</div>

		<div class="contenedor" id="anaTipos_Analisis">
			<img class="icon" src="fotos/laboratorio.png">
			<p class="texto"><a  href="analitico_inf.php" id="Tipos_Analisis" >Tipos de Analisis</a></p>
		</div>
		<!--  no forma parte de la base de datos, asi que lo agrego a mano bajo una condicion con JQuery -->
		<div class="contenedor" id="anaUsuario">
			<img class="icon" src="fotos/users.png">
			<p class="texto"><a href="controlador/usuario.php" id='usuario'>Usuarios</a></p>
		</div>
	</div>
</header>

    
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript" >
	var id_usuario = "<?php echo $id_usuario; ?>"; 
    // esta funcion en su callback regresa un dato de tipo json  
	$.getJSON("consultaMenu.php?id="+id_usuario, function(data){
        //console.log(data);   
		for(var i in data){
			// el dato es de tipo json es accesible mediante el punto y la palabra pantalla que es el nombre de la columna 
			//que esta en la tabla accesos_op en BD
			var id = data[i].pantalla;
			//console.log(id);
			//ACLARACION:
			// El if que agregue pregunta por el acceso porque es en el mismo momento,
			// o sea en el la misma variable i (del for) que recorre cuando obtengo la pantalla y
			// tambiem obtengo el acceso.
			// El acceso pertenece a la misma fila obtenida de la BD con lo cual si el acceso no esta 
			// encendido ('on') en la BD, no mostrara la puerta de acceso a la pantalla.    
			var acceso = data[i].acceso;				
			console.log(acceso);
            if(acceso=='on'){
				/* divs */
				$("#ana"+id).css("display","inline");
	            /* enlaces*/
				$("#"+id).css("display","inline");
				if (i == 4){
					if (id_usuario == 25){
						/* divs */
						$("#anaUsuario").css("display","inline");
						/* enlaces*/
						$("#usuario").css("display","inline");
					}
				}
			}	
		}	
   });
	
	
	$(".contenedor").click(function() {
		var currentId = $(this).attr('id');
		window.location = $(this).find("a").attr("href"); 
		return false;
	});
</script>

</body>    
</html>