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

	jQuery("#grillaEstadoTambores").jqGrid({
		url:'subgrid/gridEstadoTambores.php',
		datatype: "json",
		colNames:['Num Ingreso', 'Fecha','Transporte', 'Camión', 'Destino','Estado','Cant. Tambores'], 
		colModel:[ 
			{name:'num_ingreso',index:'num_ingreso', width:120,align:"center",}, 				
			{name:'fecha',index:'fecha_llegada', width:150,align:"center",},
			{name:'transporte',index:'transporte', width:150,align:"center",},
			{name:'camion',index:'camion', width:150,align:"center",},
			{name:'destino',index:'almacen', width:150,align:"center",},
			{name:'estado',index:'estado', width:150,align:"center",},
			{name:'cantidad',index:'cant', width:130,align:"center",}				
		],
		rowNum:10,
		rowList:[10,20,30,50,100,200],
		pager: '#pgrillaEstadoTambores',
		sortname: 'id_tambor',
		viewrecords: true,
		width:1200,	
		height: 'auto',
		sortorder: 'desc',	
		subGrid: true,
		caption: "Estado de Tambores Remitidos",

		subGridRowExpanded: function(subgrid_id, row_id) {
			// we pass two parameters
			// subgrid_id is a id of the div tag created whitin a table data
			// the id of this elemenet is a combination of the "sg_" + id of the row
			// the row_id is the id of the row
			// If we wan to pass additinal parameters to the url we can use
			// a method getRowData(row_id) - which returns associative array in type name-value
			// here we can easy construct the flowing
			var subgrid_table_id;
			var pager_id;
			subgrid_table_id = subgrid_id+"_t";
			pager_id = "p_"+subgrid_table_id;
			$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
			jQuery("#"+subgrid_table_id).jqGrid({
				url:"subgrid/subgridEstado.php?id="+row_id,
				datatype: "JSON",
				colNames: ['Tambor','Renapa','Productor','ATA'],
				colModel: [
					{name:"tambor",index:"id_tambor",width:100, align: 'center', },					
					{name:"renapa",index:"c1",width:100, align: 'center', },			
					{name:"razon_social",index:"razon_social",width:300, align: 'center', },
					{name:"provincia",index:"provincia",width:360, align: 'center', },							
				],			
				rowNum:300,		   	
			   	sortname: 'id_tambor',
			    sortorder: 'asc',
				multiselect: true,
				viewrecords: true,
				width:1000,
			    height:'auto',
			    pager:pager_id	
			});
			
			jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:false});
	        
			$("#planilla_ing").click(function(){     
			 	var myGrid = $(grillaEstadoTambores);
			 	selRowId = myGrid.jqGrid ('getGridParam', 'selrow'),
		    	celValue = myGrid.jqGrid ('getCell', selRowId, 'num_ingreso');
			 	//console.log(celValue);     
				location.href="logisticaxls.php?ingreso="+celValue;	
			});

		},
	
		subGridRowColapsed:function(subgrid_id, row_id) {
		// this function is called before removing the data
		//var subgrid_table_id;
		//subgrid_table_id = subgrid_id+"_t";
		//jQuery("#"+subgrid_table_id).remove();
		}     
	});
	jQuery("#grillaIngresos").jqGrid('navGrid','#pgrillaIngresos',{add:false,edit:false,del:false});
});