$(document).ready( function() {

	jQuery("#grillaComprar").jqGrid({
		url:'subgrid/gridExtaco1.php?q=3',
		datatype: "json",
		colNames:['Num Presupuesto', 'Fecha', 'Cosecha','Vence','Cant. Tambores'], 
		colModel:[ 
				{name:'nro_presupuesto',index:'num_presupuesto', width:200,align:"center",}, 				
				{name:'fecha',index:'fecha_analisis', width:190,}, 
				{name:'cosecha',index:'cosecha', width:160,},								
				{name:'vence',index:'fecha_vencimiento', width:180, sortable:true,},
				{name:'cantidad',index:'cantidad', width:180, sortable:true,}    	   	   
		],
		rowNum:10,
		rowList:[10,20,30],
		pager: '#pgrillaComprar',
		sortname: 'num_presupuesto',			
		viewrecords: true,
		width: 850,	
		height: 'auto',
		sortorder: 'desc',	
		subGrid: true,
		caption: "Tambores Analizados",

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
			url:"subgrid/subgridExtaco1.php?q=2&id="+row_id,
			datatype: "JSON",
			colNames: ['Tambor','HMF','Color','Humedad','Acidez','Productor','Tipo Flora','Aprobado'],
			colModel: [
				{name:"lote_id",index:"id_tambor",width:80, align: 'center', key:true,},					
				{name:"hmf",index:"hmf",width:60, align: 'center', },
				{name:"color",index:"color",width:60, align: 'center', },				
				{name:"humedad",index:"humedad",width:90, align: 'center', },
				{name:"acidez",index:"acidez",width:70, align: 'center', },							
				{name:"razon_social",index:"razon_social",width:200, align: 'center', },
				{name:"tipo_campo",index:"tipo_miel",width:100, align: 'center', },				
				{name:"resultado",index:"resultado",width:100, align: 'center', },
			],			
			rowNum:300,		   	
		   	sortname: 'id_tambor',
		    sortorder: 'asc',
			multiselect: true,
			viewrecords: true,
			width:'auto',
		    height:'auto',
		    pager:pager_id
		});
		
		jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:false});
        
		jQuery("#analizar").click(function(){     
		 var myGrid = $("#"+subgrid_table_id);
		 selectedRowId = myGrid.jqGrid ('getGridParam', 'selarrrow');     
		 location.href='alta_extaco1.php?tambores='+selectedRowId;
		});

		},
	
		subGridRowColapsed:function(subgrid_id, row_id) {
		// this function is called before removing the data
		//var subgrid_table_id;
		//subgrid_table_id = subgrid_id+"_t";
		//jQuery("#"+subgrid_table_id).remove();
		}     
	});
	jQuery("#grillaComprar").jqGrid('navGrid','#pgrillaComprar',{add:false,edit:false,del:false});
});