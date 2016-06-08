$(document).ready( function() {

	jQuery("#grillaExport").jqGrid({
		url:'grid/gridExport.php',
		datatype: "json",
		colNames:['Tambor','Renapa','Sala','Pais','Cliente','Peso Bruto','Tara','Color','Factura','Fecha Ingreso','Remito','Depósito','Tipo','GSB','Rango','Estado'],		
		colModel:[ 
			{name:'id_tambor',index:'id_tambor', width:80,align:"center",searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 				
			{name:'renapa',index:'renapa', width:90,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 
			{name:'sala_ext',index:'sala_ext', width:90,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'pais',index:'pais_destino', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 		 
			{name:'cliente',index:'razon_social', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 
			{name:'peso',index:'peso',formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 	   	   
			{name:'tara',index: 'tara',formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'color',index: 'color',formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'factura',index: 'factura', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'fecha_llegada',index: 'fecha_llegada', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'remito',index: 'remito', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'almacen',index: 'almacen', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'tipo_miel',index: 'tipo_miel', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'lote_export',index: 'num_loteGSB', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
 		    {name:'rango',index: 'rango', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
 		    {name:'estado',index: 'estado', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}
		],
		rowNum:10,
		rowList:[10,20,30],
		pager: '#pgrillaExport',
		sortname: 'id_tambor',
		multiselect: true,			
		viewrecords: true,
		width: 'auto',	
		height: 'auto',
		sortorder: 'desc',
		caption: "Tambores a Exportar",
		footerrow:true, 
		userDataOnFooter:true, 
		onSelectRow: function(rowId) {onRowSelect();},	
	});
	jQuery("#grillaExport").jqGrid('filterToolbar', {stringResult:true, searchOperators:true, searchOnEnter:true});


	$("#enviarExportNuevo").click(function(){
		var pais=$("#pais").val();
		var cliente=$("#cliente").val();
		var tambores = $("#grillaExport").jqGrid('getGridParam', 'selarrrow');
		cargarExpor(pais,cliente,tambores);
		console.log(tambores);
	});

	function cargarExpor(pais,cliente,tambores){ 	             
        $.ajax({
            url:'includes/cargarExport.php',
            type:'post',
            data: { 
			    "pais":pais,
			    "cliente":cliente,
			    "tambores":tambores			    
			},                     
            success:  function (response) {
            	location.href = "embarque1.php";
            }
        });
	};

	function onRowSelect() {
	    var selRowsId = jQuery("#grillaExport").jqGrid("getGridParam", "selarrrow");
	    var grid = jQuery("#grillaExport");
	    var seleccionada=0;
	    var sumPeso = 0;
	    var sumTara = 0;	 
	    var promColor=0;
	    var sumColor=0;

	    for (var i = 0; i < selRowsId.length; i++) {
	        var rowId = selRowsId[i];
	        var rowData = grid.jqGrid('getRowData', rowId);
	        seleccionada=i+1;
	        sumPeso = parseInt(sumPeso) + parseInt(rowData.peso);
	        sumTara = parseInt(sumTara) + parseInt(rowData.tara);	        
	        sumColor = parseInt(sumColor) + parseInt(rowData.color);
	        promColor = sumColor/ (i+1) ;
	    }
    	jQuery("#grillaExport").jqGrid('footerData', 'set', { pais: 'Total:',cliente: seleccionada, peso: sumPeso, tara: sumTara, color: promColor});
    	
	};

	jQuery("#generar_packingList").click(function(){     
		selectedRowId = $("#grillaExport").jqGrid ('getGridParam', 'selarrrow');     
		if (selectedRowId.length > 0) {
			//console.log("selectedRowId vacio!!!");
		   location.href="gen_packing_list.php?tambores="+selectedRowId;
		}
			
	});

	

	jQuery("#grillaExport").navGrid('#pgrillaExport',{edit:false,add:false,del:false,search:false})
		.navButtonAdd('#pgrillaExport',{caption:"", buttonicon:"ui-icon-trash", onClickButton: function(){     
		    var myGrid = $('#grillaExport'),
			selectedRowId = myGrid.jqGrid ('getGridParam', 'selrow'),
			cellValue = myGrid.jqGrid ('getCell', selectedRowId, 'id_tambor');		 
						 
			if (cellValue!==false){
			/*pasa el vinculo con el id que se guardo en cellValue de la fila seleccionada*/
							
			/* solo si se confirma la baja actua en consecuencia*/
				if(confirm("SEGURO DE VOLVER A ESTADO ANTERIOR ?")){                                    
					$.get('includes/bajaExport.php?ID='+cellValue,function(respuesta){
				        if(respuesta){
					        $("#grillaExport").trigger('reloadGrid');								   	                        
				        }
				    });
				}/* fin if confirm*/
			}
			else{
				alert("Por favor seleccione una fila");
			}						
		}, 
		position:"last",
	

	});	
});