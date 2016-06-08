<html>
	<head>
		  	<meta name="viewport" content="width=device-width,initial-scale=1"> 
	        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link rel="shortcut icon" href="fotos/chmiel.ico">	
			<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	       	<link href='../frames/grid/css/jquery-ui-custom.css' rel='stylesheet' type='text/css'/>	
			<link href='../frames/css/alta_extaco1.css' rel='stylesheet' type="text/css"/>
			<script src='../frames/grid/js/jquery-1.11.1.js'></script>				
			<script src="js/bootstrap.min.js"></script>
			<script src="js/bootbox.min.js"></script>
	</head>
 <body>	
 	<div id="tambores_seleccionados">
 		<h3>Tambores Seleccionados</h3>
 		<div id="seleccion">
	 		<h4>Datos de Envio</h4>
	 		<table id="tablaconfirm" class="table table-bordered table-hover">
	 			<tr>
	 				<th>Tambor</th><th>Color</th><th>HMF</th><th>Humedad</th><th>Acidez</th><th>Resultado</th>
	 			</tr>
	 		</table>
		</div>
		<div id="botonera">							    
			<input type="button" class="boton" id="confirmar" value="confirmar"/>
			<input type="button" class="boton" id="imprimir" value="imprimir"/>
			<input type="button" class="boton" id="cancelar" value="cancelar"/>
		</div>		
 	</div>
 </body>
 <?
   $tam=$_GET["tambores"];
   echo "<input type='hidden' name ='' id ='tam' value=".$tam.">";
 ?>
 <script>
 	
    //lee los tambores que vienen en GET y los transforma en tabla pidiendo info a BD con ajax
    $(document).ready(function(){
        var tam = $("#tam").val();
        var temp = new Array();
        // this will return an array with strings "1", "2", etc.
        temp = tam.split(",");
        temp.sort();
        console.log(temp);        
        var largo = temp.length; 
        var p=0;
		while (p < largo){ 
			$.ajax({
				url: '../frames/includes/tamboresExtaco.php?tambores='+temp[p],
				dataType: 'json',
				success:  function (response) {																								 				
					var tambor = response.lote_id;
					var color = response.colorN;
					var hmf = response.hmf;
					var humedad = response.humedad;
					var acidez = response.acidez;
					var cumple = response.cumple;
					$("#tablaconfirm").append('<tr id="fila"><td>'+tambor+'</td><td>'+color+'</td><td>'+hmf+'</td><td>'+humedad+'</td><td>'+acidez+'</td><td>'+cumple+'</td><td class="bordetransp"  id="del"><a href="#"><img src="fotos/Trash_Can.png" width="20" height="20"/></a></td></tr>');
		        }               
		    });
		    p++;		    
	    }// end of while	
	});


	//si (habilitar=si) entonces no apareceria el modal de bootbox
 	$("#confirmar").click(function() {
 	    modal ={"propiedad":"no"};
 	    //var modal ='no';
 	  	chequearmodal(modal);
 	  	console.log("el modal es "+modal["propiedad"]+" ");
		if(modal["propiedad"]=='si'){ 
			bootbox.setDefaults({
		      /**
		       * @optional String
		       * @default: en
		       * which locale settings to use to translate the three
		       * standard button labels: OK, CONFIRM, CANCEL
		       */
		      	locale: "es"
			});

		    bootbox.prompt({
		    	size: 'small',
		        title: "Existen muestras sin Aprobación, confirme por favor ",
		        locale: 'es',
		        inputType: 'password',
		        onEscape: 'true',
		        buttons: {
		            confirm: {
		                label: 'Confirmar'
		            }
		        },
		        callback: function(value){  
			        $.ajax({
						url: '../frames/includes/confirmarCompra.php',
						type: "POST", 
						dataType: "json",
	                    data: { 
					       "password":value , 				        
					    },
						success:  function (response){																								 				
							var respuesta = response.respuesta;
							alert('Clave ' + respuesta);
							if	(respuesta=="Correcta"){
								//console.log('Cargando en BD...............');
								grabaTodoTabla(tablaconfirm);
								location.href="menu_1.php";
							}
				        }               
				    })
		        },
		    });
    	}else{
	      	grabaTodoTabla(tablaconfirm);
			location.href="menu_1.php";
      	};
    });


 	//si hace click en cancelar me redirige a la parte de grillas
    $("#cancelar").click(function() {	    	
		location.href="extaco1.php";
	});


    $("#imprimir").click(function(){
      var tam = $("#tam").val();
      location.href="compaxls.php?tambores="+tam;
    }); 


	// Evento que selecciona la fila y la elimina 
	$(document).on("click","#del",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
	});

	function chequearmodal(modal){
		var TABLA 	= $("#tablaconfirm tr");
	    //console.log( TABLA + ": es lo que tiene la var tabla ");
		//una vez que tenemos la tabla recorremos esta misma recorriendo cada TR y por cada uno de estos se ejecuta el siguiente codigo
		TABLA.each(function(){
			//por cada fila o TR que encuentra rescatamos 3 datos, el ID de cada fila, la Descripción que tiene asociada en el input text, y el valor seleccionado en un select
            var resultado;
            $(this).children("td").each(function (index2){
            	switch (index2){
                	case 5: resultado = $(this).text();
                            break;					              
                }
            });
            if (resultado =='no cumple'){
            	modal["propiedad"]='si';
            }   
        });
        console.log("el modal dentro es "+modal["propiedad"]+" ");
        //return aConfirmar;
	}

	// Actualiza de manera masiva todos los archivos cargados en la tercera pestaña.
	function grabaTodoTabla(TABLAID){
		//tenemos 2 variables, la primera será el Array principal donde estarán nuestros datos y la segunda es el objeto tabla
		var DATA 	= [];
		var TABLA 	= $("#tablaconfirm tr");
	    //console.log( TABLA + ": es lo que tiene la var tabla ");
		//una vez que tenemos la tabla recorremos esta misma recorriendo cada TR y por cada uno de estos se ejecuta el siguiente codigo
		TABLA.each(function(){
			//por cada fila o TR que encuentra rescatamos 3 datos, el ID de cada fila, la Descripción que tiene asociada en el input text, y el valor seleccionado en un select
            var tambor,color,hmf,humedad,acidez,resultado;
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 0: tambor = $(this).text();
                            break;
                    case 1: color = $(this).text();
                            break;
                    case 2: hmf = $(this).text();
                            break;
                    case 3: humedad = $(this).text();
                            break;
                    case 4: acidez = $(this).text();
                            break;
                    case 5: resultado = $(this).text();
                            break;					              
                }
                $(this).css("background-color", "#ECF8E0");
            })    
            //if (tambor !=null){
            //	alert(tambor + ' - ' + productor + ' - ' + color+ ' - ' + hmf + ' - ' + humedad + ' - ' + acidez + ' - ' + resultado);
        	//}	            
			//entonces declaramos un array para guardar estos datos, lo declaramos dentro del each para así reemplazarlo y cada vez
			item = {};			
			//si miramos el HTML vamos a ver un par de TR vacios y otros con el titulo de la tabla, por lo que le decimos a la función que solo se ejecute y guarde estos datos cuando exista la variable ID, si no la tiene entonces que no anexe esos datos.
			if(tambor !=null){
				//alert(tambor + ' - ' + color+ ' - ' + hmf + ' - ' + humedad + ' - ' + acidez + ' - ' + resultado);
		        item["tambor"] = tambor;
		        item["color"] = color; 
		        item["hmf"] = hmf;
		        item["humedad"] = humedad;
		        item["acidez"] = acidez;
                item["resultado"] = resultado;
		        //una vez agregados los datos al array "item" declarado anteriormente hacemos un .push() para agregarlos a nuestro array principal "DATA".
		        DATA.push(item);		        
			}		
		});			 
		//eventualmente se lo vamos a enviar por PHP por ajax y además convertiremos el array en json para evitar cualquier incidente con compativilidades.
		INFO = new FormData();
		aInfo = JSON.stringify(DATA);
	 	//alert(aInfo);
		INFO.append('data', aInfo);
		$.ajax({
			data: INFO,
			type: 'POST',
			dataType: 'json',
		    url:'includes/guardar_datos_orden_compra.php',
			processData: false, 
			contentType: false,
			success: function(r){
				//Una vez que se haya ejecutado de forma exitosa hacer el código para que muestre esto mismo.
			}
		});
	}
 </script>
</html>/