$(document).ready( function() {

	var data=[]; //list of RowIDs for rows which have been ticked onSelectRow
    var idsOfSelectedRows = [],
    updateIdsOfSelectedRows = function (id, isSelected) {
        //console.log("en el update");
        var index = $.inArray(id, idsOfSelectedRows);
        if (!isSelected && index >= 0) {
            idsOfSelectedRows.splice(index, 1); // remove id from the list
        } else if (index < 0) {
            idsOfSelectedRows.push(id);
        }
        //console.log(idsOfSelectedRows);
    };

	jQuery("#grillaExportOut").jqGrid({
		url:'grid/gridExportOut.php',
		datatype: "json",
		colNames:['Tambor','Renapa','Sala','Pais','Cliente','Peso Bruto','Tara','Peso Neto','Color','Fecha Salida','Tipo','GSB','Rango'],		
		colModel:[ 
			{name:'id_tambor',index:'id_tambor', width:80,align:"center",searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 				
			{name:'renapa',index:'renapa', width:90,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 
			{name:'sala_ext',index:'sala_ext', width:90,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'pais',index:'pais_destino', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 		 
			{name:'cliente',index:'razon_social', width:130, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 
			{name:'peso',index:'peso',formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 	   	   
			{name:'tara',index: 'tara',formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'peso_neto',index:'peso_neto',formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 	   	   
			{name:'color',index: 'color',formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'fecha_export',index: 'fecha_export',sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'tipo_miel',index: 'tipo_miel', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name:'lote_export',index: 'num_loteGSB', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
 		    {name:'rango',index: 'rango', sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}		],
		rowNum:10,
		rowList:[10,20,30,50,100,200],
		pager: '#pgrillaExportOut',
		sortname: 'id_tambor',
		multiselect: true,			
		viewrecords: true,
		width: 'auto',	
		height: 'auto',
		sortorder: 'desc',
		caption: "Exportado",
		footerrow:true, 
		userDataOnFooter:true, 

		onSelectRow: function(rowId) {
			data.push(rowId); 
			updateIdsOfSelectedRows(rowId);
			onRowSelect();
		},

		onSelectAll: function (aRowids, isSelected) {
        	var i, count, id;
	        for (i = 0, count = aRowids.length; i < count; i++) {
	            id = aRowids[i];
	            updateIdsOfSelectedRows(id, isSelected);
	        }
	        onRowSelect();
    	},
	    loadComplete: function () {
	        var $this = $(this), i, count;
	        for (i = 0, count = idsOfSelectedRows.length; i < count; i++) {
	            $this.jqGrid('setSelection', idsOfSelectedRows[i], false);
	        }
	    } 

	});
	jQuery("#grillaExportOut").jqGrid('filterToolbar', {stringResult:true, searchOperators:true, searchOnEnter:true});


	function onRowSelect() {
	    //var selRowsId = jQuery("#grillaExportOut").jqGrid("getGridParam", "selarrrow");
	    var selRowsId = idsOfSelectedRows;
	    console.log("seleccionados: "+selRowsId);
	    var grid = jQuery("#grillaExportOut");
	    var seleccionada=0;
	    var sumPeso = 0;
	    var sumTara = 0;
	    var sumPesoN = 0;	 
	    var promColor=0;
	    var sumColor=0;

	    for (var i = 0; i < selRowsId.length; i++) {
	        var rowId = selRowsId[i];
	        var rowData = grid.jqGrid('getRowData', rowId);
	        seleccionada=i+1;
	        sumPeso = parseInt(sumPeso) + parseInt(rowData.peso);
	        sumTara = parseInt(sumTara) + parseInt(rowData.tara);
	        sumPesoN = parseInt(sumPesoN) + parseInt(rowData.peso_neto);	        
	        sumColor = parseInt(sumColor) + parseInt(rowData.color);
	        promColor = sumColor/ (i+1) ;
	    }
    	jQuery("#grillaExportOut").jqGrid('footerData', 'set', { pais: 'Total:',cliente: seleccionada, peso: sumPeso, tara: sumTara, peso_neto: sumPesoN,color: promColor});
    	
	};

	jQuery("#generar_packingList").click(function(){     
		//selectedRowId = $("#grillaExportOut").jqGrid ('getGridParam', 'selarrrow');
	    var selectedRowId = idsOfSelectedRows;		   
		if (selectedRowId.length > 0) {
			//console.log("selectedRowId vacio!!!");
		   location.href="gen_packing_list.php?tambores="+selectedRowId;
		}
			
	});

	

	jQuery("#grillaExportOut").navGrid('#pgrillaExportOut',{edit:false,add:false,del:false,search:false})
		.navButtonAdd('#pgrillaExportOut',{caption:"", buttonicon:"ui-icon-trash", onClickButton: function(){     
		    var myGrid = $('#grillaExportOut'),
			selectedRowId = myGrid.jqGrid ('getGridParam', 'selrow'),
			cellValue = myGrid.jqGrid ('getCell', selectedRowId, 'id_tambor');		 
						 
			if (cellValue!==false){
			/*pasa el vinculo con el id que se guardo en cellValue de la fila seleccionada*/
							
			/* solo si se confirma la baja actua en consecuencia*/
				if(confirm("SEGURO DE VOLVER A ESTADO ANTERIOR ?")){                                    
					$.get('includes/bajaExport.php?ID='+cellValue,function(respuesta){
				        if(respuesta){
					        $("#grillaExportOut").trigger('reloadGrid');								   	                        
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