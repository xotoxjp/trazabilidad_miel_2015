	jQuery("#grillaConPesos").jqGrid({
	url:'grid/pesajeResultGrid.php?q=1',
	datatype: "JSON",
	colNames:['Tambor','Productor','Peso','Tara','Tipo','Renapa', 'Sala de Extraccion'],
	colModel:[
	   	{name:'id_tambor',index:'id_tambor', align: 'center', width:100, resizable: true},
	    {name:'razon_social',index:'productor',width:300, align: 'center', }, 
	    {name:'peso',index:'peso',width:100, align: 'center', }, 
	    {name:'tara',index:'tara',width:100, align: 'center', },
	    {name:'tipo',index:'tipo',width:50, align: 'center', },   		
		{name:'c1',index:'c1', width:100, align: 'center', resizable: true},
		{name:'sala_ext',index:'sala_ext', width:200, align: 'center',  resizable: true},			
	],
	rowNum:100,	
	rowList:[15,20,30],
	gridview: true,
	pager: '#pgrillaConPesos',
	sortname: 'id_tambor',
	viewrecords: true,
	multiselect: true,
	loadonce:true,
	sortorder: "desc",
	width: 'auto',	
	height: 'auto',	
	caption: "Grilla con Pesos",
	});
	jQuery("#grillaConPesos").jqGrid('navGrid',"#pgrillaConPesos",{edit:false,add:false,del:false,search:true},{},{},{},{sopt :['cn','eq']}
	);


	jQuery("#grillaConPesos").navGrid("#pgrillaConPesos",{edit:false,add:false,del:false,search:false})
		.navButtonAdd("#pgrillaConPesos",{caption:"", buttonicon:"ui-icon-trash", onClickButton: function(){     
			var myGrid = $("#grillaConPesos"),
			selectedRowId = myGrid.jqGrid ('getGridParam', 'selrow'),
			cellValue = myGrid.jqGrid ('getCell', selectedRowId, 'id');		 
			if (selectedRowId!==false){
				/*pasa el vinculo con el id que se guardo en cellValue de la fila seleccionada*/
				location.href='includes/baja_ingresar_tambor.php?ID='+selectedRowId;
			}else{ alert("Por favor seleccione una fila"); }
		}, 
	    position:"last"
	});	