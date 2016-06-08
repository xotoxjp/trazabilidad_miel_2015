$(document).ready( function() {
	var eleccionAlmacen = $("#selAlmacen").val();  
	//console.log(eleccionAlmacen);

	$( "#seleccionAlmacen" ).change(function () {
    	$( "#seleccionAlmacen option:selected" ).each(function() {
	      	eleccionAlmacen = $( this ).val();
	        console.log(eleccionAlmacen);
    	});
    	$("#grillaPesos").setGridParam({url:'grid/pesajeGrid.php?almacen='+eleccionAlmacen});
    	$("#grillaPesos").trigger("reloadGrid");     
  	}).change();


	jQuery("#grillaPesos").jqGrid({
		url:'grid/pesajeGrid.php?almacen='+eleccionAlmacen,
		datatype: "JSON",
		colNames:['Tambor','Núm. Ingreso','Productor','Renapa', 'Sala de Extraccion'],
		colModel:[
	   		{name:'lote_id',index:'id_tambor', align: 'center', width:'10%', resizable: true}, 
	   		{name:'num_ingreso',index:'num_ingreso', width:'10%', align: 'center', resizable: true},
	    	{name:'razon_social',index:'productor',width:'25%', align: 'center'},   		
			{name:'c1',index:'c1', width:'20%', align: 'center', resizable: true},
			{name:'sala_ext',index:'sala_ext', width:'25%', align: 'center',  resizable: true},			
		],
		rowNum:15,
		rowList:[15,20,30],
		gridview: true,
		pager: '#pgrillaPesos',
		sortname: 'id_tambor',
		viewrecords: true,
		width:1200,	
		height: 'auto',	
		sortorder: "desc",			
		caption: "Seleccione Tambores a Pesar",
	});
    
	jQuery("#grillaPesos").jqGrid('filterToolbar', {searchOperators: true }, {searchOnEnter:true} );
    
    // trae el numero de tambor seleccionado en la grilla 
    jQuery("#grillaPesos").dblclick(function(){     
    	var myGrid = $("#grillaPesos");
     	selectedRowId = myGrid.jqGrid ('getGridParam', 'selrow');
     	cellValue = myGrid.jqGrid ('getCell', selectedRowId, 'lote_id');
     	if (cellValue!==false){
      		/*pasa el vinculo con el id que se guardo en cellValue de la fila seleccionada*/
        	jQuery("#tSeleccionado").val(cellValue);
     	}else{
      		alert("Por favor seleccione una fila");
     	}
    });
	
});