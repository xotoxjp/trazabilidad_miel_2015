$(document).ready(function(){
	var editor; // use a global for the submit and return data rendering

	$('#tabla_lista_muestras').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
		"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
	} );

	
	
	var table = $('#tabla_lista_muestras').DataTable();
 
	$('#tabla_lista_muestras tbody').on( 'click', 'tr', function () {
		$(this).toggleClass('selected');		
	} );
 	
	/***
	editor = new $.fn.dataTable.Editor( {
        ajax: 'includes/upd_observ_datatables.php',
        table: '#tabla_lista_muestras',
        fields: [ {
                label: "Start date:",
                name: "start_date",
                type: "date"
            }, {
                label: "observaciones:",
                name: "observaciones"
            }
        ]
    });    

 	$('#tabla_lista_muestras').on( 'click', 'tbody td:not(:first-child)', function (e) {
        editor.inline( this );
    } );
	****/



	//analizar muestras donde se setean los tipos de analisis a realizar
	jQuery("#analizar").click(function(){     
		var myGrid = $("#gridanalisisp");
		selectedRowId = myGrid.jqGrid ('getGridParam', 'selarrrow');
		location.href='alta_laboratorio1.php?tambores='+selectedRowId;
	});
	
	
	//grabar envia muestras seleccionadas para su edicion de analisis
	$("#editar_analisis").click( function () {
		var seleccion=[];
		var cantidad =  table.rows('.selected').data().length;
		for(var i =0; i <cantidad; i++){
		    var algo =  table.rows('.selected').data()[i][0];
			seleccion.push(algo);				
	    }
		console.log(seleccion);
		var registrar = "registrar";
	 	location.href='alta_laboratorio3.php?quiero='+registrar+'&tambores='+ seleccion ;	
	} );

	
	
    //ver
	$("#ver_analisis").click( function () {
		var seleccion=[];
		var cantidad =  table.rows('.selected').data().length;
		for(var i =0; i <cantidad; i++){
		    var algo =  table.rows('.selected').data()[i][0];
			seleccion.push(algo);				
	    }
		console.log(seleccion);
		var ver = "ver";
	 	location.href='alta_laboratorio3.php?quiero='+ver+'&tambores='+ seleccion ;	
	} );
})	