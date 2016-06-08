$(document).ready( function() {
    //$('#tab-container').easytabs();
	jQuery("#grillaIngresos").jqGrid({
		url:'subgrid/gridIngresos.php?q=3',
		datatype: "json",
		colNames:['Num Ingreso', 'Fecha', 'Transporte', 'Camión'], 
		colModel:[ 
			{name:'num_ingreso',index:'num_ingreso', width:200,align:"center",}, 				
			{name:'fecha',index:'fecha_llegada', width:190,},
			{name:'transporte',index:'transporte', width:190,},
			{name:'camion',index:'camion', width:190,}				
		],
		rowNum:10,
		rowList:[10,20,30],
		pager: '#pgrillaIngresos',
		sortname: 'num_ingreso',			
		viewrecords: true,
		width: 950,	
		height: 'auto',
		sortorder: 'desc',	
		subGrid: true,
		caption: "Ingresos",

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
				url:"subgrid/subgridIngresos.php?id="+row_id,
				datatype: "JSON",
				colNames: ['Tambor','Renapa','Lote','Productor','Remito'],
				colModel: [
					{name:"tambor",index:"id_tambor",width:80, align: 'center', },					
					{name:"renapa",index:"c1",width:90, align: 'center', },
					{name:"lote",index:"num_lote",width:90, align: 'center', },				
					{name:"razon_social",index:"razon_social",width:300, align: 'center', },
					{name:"remito",index:"remito",width:150, align: 'center', },							
				],			
				rowNum:300,		   	
			   	sortname: 'id_tambor',
			    sortorder: 'asc',
				multiselect: true,
				viewrecords: true,
				width:920,
			    height:'auto',
			    pager:pager_id	
			});
			
			jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:false});
	        
			jQuery("#planilla_ing").click(function(){     
			 var myGrid = $("#"+subgrid_table_id);
			 selectedRowId = myGrid.jqGrid ('getGridParam', 'selarrrow');
     	 	 location.href="depotaxls.php?tambores="+selectedRowId;
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