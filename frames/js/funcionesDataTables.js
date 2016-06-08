$(document).ready(function(){
	var eleccionTipoMuestra2 = $("#selMuestra").val();  
 	//console.log("eleccionTipoMuestra2");
   	//console.log(eleccionTipoMuestra2);

   	$( "#seleccion" ).change(function () {
	    $( "#seleccion option:selected" ).each(function() {
	      eleccionTipoMuestra2 = $( this ).val();
	      //console.log(eleccionTipoMuestra);
	      verlistado(eleccionTipoMuestra2);
	    });
    }).change();
	//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO


})

function verlistado(eleccion){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
 	console.log("trae eleccion");
   	console.log(eleccion);	
	var randomnumber=Math.random()*11;
	$.post("includes/listarPistolmuestras.php?tipoMuestra="+eleccion+"", {
	randomnumber:randomnumber
	}, function(data){
		$("#contenido").html(data);
	});
}