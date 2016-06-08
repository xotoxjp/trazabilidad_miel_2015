$(document).ready( function() {

	var sumPeso = 0;
	var sumTara = 0;
	var sumNeto = 0;
	var promColor=0;
	
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
    var datosPesoTara = {totalPesoBruto:0, totalPesoNeto:0, totalTara:0, promedioColor:0}, //object of valueable data sum of peso, tara and promedy of color
    updateDatosPesoTara = function (id,isSelected,sumPesoNew,sumTaraNew,sumNetoNew,promColorNew) {
        //console.log("en el update");
        var index = $.inArray(id, datosPesoTara);
        if (!isSelected && index >= 0) {
            datosPesoTara.splice(index, 1); // remove id from the list
        } else if (index < 0) {
            //datosPesoTara.push(id,sum);
            datosPesoTara.agregarPeso = function () {
    			return this.sumPeso=this.sumPeso + sumPesoNew;
			};
            datosPesoTara.agregarTara = function () {
    			return this.sumTara=this.sumTara + sumTaraNew;
			}; 
            datosPesoTara.agregarPesoNeto = function () {
    			return this.sumPesoNeto=this.sumPesoNeto + sumPesoNetoNew;
			}; 
            datosPesoTara.agregarPromColor = function () {
    			return this.promColor=(this.promColor + promColorNew)/2;
			};  
        }
    };
        //console.log(datosPesoTara);

	jQuery("#grillaStock").jqGrid({
		url:'grid/gridStock.php',
		datatype: "JSON",
		colNames:['Tambor','Renapa','Sala','Lote','Peso Bruto','Tara','Peso Neto','HMF','Color','Humedad','Acidez','Ingreso','Fecha Llegada','Factura','Remito','Depósito','Tipo','GSB','Rango'],		colModel:[ 
			{name:'id_tambor',index:'id_tambor', width:80,align:"center",searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,	}, 				
			{name:'renapa',index:'renapa', width:90,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 
			{name:'sala_ext',index:'sala_ext', width:90,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},								
			{name:'lote',index:'lote', width:80, sortable:true, editable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 
			{name:'peso',index:'peso', width:80, formatter: "number", sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 	   	   
			{name: 'tara',index: 'tara', formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'peso_neto',index: 'peso_neto', formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'hmf',index: 'hmf', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'color',index: 'color', formatter: "number", width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'humedad',index: 'humedad', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'acidez',index: 'acidez', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},			
			{name: 'num_ingreso',index: 'num_ingreso', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'fecha_llegada',index: 'fecha_llegada', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'factura',index: 'factura', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'remito',index: 'remito', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'almacen',index: 'almacen', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'tipo_miel',index: 'tipo_miel', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
			{name: 'lote_export',index: 'lote_export', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
 		    {name: 'rango',index: 'rango', width:80, sortable:true,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}
		],
		rowNum:20,
		rowList:[10,20,30,50,100,200,500,1000],
		pager: '#pgrillaStock',
		sortname: 'id_tambor',
		sortorder: 'desc',
		mtype: 'GET',
		'cellEdit': true,
		'cellsubmit':'clientArray',
		beforeSubmitCell: function(rowid, cellname, value, iRow, iCol){
            $.ajax({
			  url: '../frames/subgrid/upd_stock.php',
			  type: 'GET',
			  data: { ID: arguments[0], lote: arguments[2], }
			})						   
        },
		multiselect: true,	
		width: 'auto',	
		height: 'auto',
		caption: "Tambores en Stock",
		gridview:true,
		viewrecords:true,
		footerrow:true, 
		userDataOnFooter:true,

		onSelectRow: function(rowId) {
			data.push(rowId); 
			updateIdsOfSelectedRows(rowId);
			onRowSelect(sumPeso,sumTara,sumNeto,promColor);
		},

		onSelectAll: function (aRowids, isSelected) {
        	var i, count, id;
	        for (i = 0, count = aRowids.length; i < count; i++) {
	            id = aRowids[i];
	            updateIdsOfSelectedRows(id, isSelected);
	        }
	        onRowSelect(sumPeso,sumTara,sumNeto,promColor);
    	},
	    loadComplete: function () {
	        var $this = $(this), i, count;
	        for (i = 0, count = idsOfSelectedRows.length; i < count; i++) {
	            $this.jqGrid('setSelection', idsOfSelectedRows[i], false);
	        }
	    } 


	});
	jQuery("#grillaStock").navGrid('#pgrillaStock',{edit:false,add:false,del:false,search:false})
	jQuery("#grillaStock").jqGrid('filterToolbar', {stringResult:true, searchOnEnter: true , ignoreCase: true , searchOperators: true } );
    
    var postdata = $("#grillaStock").jqGrid('getGridParam', 'postData');
	var thesearchis = postdata.filters

	function onRowSelect(sumPeso,sumTara,sumNeto,promColor) {
	    //var selRowsId = jQuery("#grillaStock").jqGrid("getGridParam", "selarrrow");
	    var selRowsId = idsOfSelectedRows;
	    console.log("seleccionados: "+selRowsId);
	    var grid = jQuery("#grillaStock");
	    //var sumPeso = 0;
	    //var sumTara = 0;
	    //var sumNeto = 0;
	    //var promColor=0;
	    var sumColor=0;
	    var seleccionados=0;
	    for (var i = 0; i < selRowsId.length; i++) {
	        var rowId = selRowsId[i];
	        var rowData = grid.jqGrid('getRowData', rowId);
	        seleccionados=i+1;	
	        sumPeso = parseInt(sumPeso) + parseInt(rowData.peso);
	        sumTara = parseInt(sumTara) + parseInt(rowData.tara);
	        sumNeto = parseInt(sumNeto) + parseInt(rowData.peso_neto);
	        sumColor = parseInt(sumColor) + parseInt(rowData.color);
	        promColor = sumColor/ (i+1) ;
	    }
    	jQuery("#grillaStock").jqGrid('footerData', 'set', { sala_ext: 'Total:',lote: seleccionados, peso: sumPeso, tara: sumTara, peso_neto: sumNeto,color: promColor});
    	
	};



	$("#enviarStockNuevo").click(function(){
		var lote=$("#lote").val();
		//var tambores = $("#grillaStock").jqGrid('getGridParam', 'selarrrow');
	    var tambores = idsOfSelectedRows;
		cargarStock(lote,tambores);
		console.log(tambores);
	});

	function cargarStock(lote,tambores){ 	             
        $.ajax({
                url:'includes/cargarStock.php',
                type:'post',
                data: { 
				    "lote":lote,
				    "tambores":tambores			    
				},                     
                success:  function (response) {
                	window.location.href = "stock1.php";
                }
        });
	}


	$("#transferirDeposito").click(function(){
		var deposito=$("#slt_deposito  option:selected" ).text();
		//var tambores = $("#grillaStock").jqGrid('getGridParam', 'selarrrow');
	    var tambores = idsOfSelectedRows;
		cambiarDepot(deposito,tambores);
		console.log(tambores);
	});

	function cambiarDepot(deposito,tambores){ 	             
        $.ajax({
                url:'includes/cambiarDepot.php',
                type:'post',
                data: { 
				    "deposito":deposito,
				    "tambores":tambores			    
				},                     
                success:  function (response) {
                	window.location.href = "stock1.php";
                }
        });
	}

	$('#exportar_excel').click(function(){
		//var selectedRowId = $("#grillaStock").jqGrid ('getGridParam', 'selarrrow');
	    var selectedRowId = idsOfSelectedRows;		     
		if (selectedRowId.length > 0) {
			//console.log("selectedRowId vacio!!!");
		   location.href="stockaxls.php?tambores="+selectedRowId;
		}
	});

});