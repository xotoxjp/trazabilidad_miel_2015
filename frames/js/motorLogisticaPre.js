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

	jQuery("#grillaTamboresComprados").jqGrid({
		url:'grid/gridTamboresComprados.php',
		datatype: "json",
		colNames:['Tambor','Presupuesto','Color','Localidad','Productor','Renapa','Sala'],		
		colModel:[ 
			{name:'id_tambor',index:'id_tambor', width:80,align:"center",searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 				
			{name:'num_presupuesto',index:'num_presupuesto', width:150,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 			
			{name:'color',index:'color', width:90,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 			
			{name:'localidad',index:'localidad', width:150,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 
			{name:'productor',index:'productor', width:150,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 
			{name:'renapa',index:'renapa', width:90,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,}, 
			{name:'sala_ext',index:'sala_ext', width:100,searchoptions:{searchOperators: true,sopt: ['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'],} ,},
		   	],
		rowNum:200,
		rowList:[10,20,30,50,100,200,300,500,1000],
		pager: '#pgrillaTamboresComprados',
		sortname: 'id_tambor',
		multiselect: true,			
		viewrecords: true,
		width: '100%',	
		height: 'auto',
		sortorder: 'desc',
		caption: "Tambores Comprados con envío a Definir",


		onSelectRow: function(rowId) {
			data.push(rowId); 
			updateIdsOfSelectedRows(rowId);
			
		},

		onSelectAll: function (aRowids, isSelected) {
        	var i, count, id;
	        for (i = 0, count = aRowids.length; i < count; i++) {
	            id = aRowids[i];
	            updateIdsOfSelectedRows(id, isSelected);
	        }
	        
    	},
	    loadComplete: function () {
	        var $this = $(this), i, count;
	        for (i = 0, count = idsOfSelectedRows.length; i < count; i++) {
	            $this.jqGrid('setSelection', idsOfSelectedRows[i], false);
	        }
	    } 

	});
	jQuery("#grillaTamboresComprados").jqGrid('filterToolbar', {stringResult:true, searchOperators:true, searchOnEnter:true});


/****************************************************************************/
/****************************************************************************/

$("#enviarTambores").click(function(){
		//var valremfac=$("#remfac").val();
		//var sltfr=$("#selectfr").val();
		var deposito=$("#slt_deposito  option:selected" ).text();
		var ingreso=$("#num_ingreso").val();
		//var remito=$("#remito").val();
		//var factura=$("#factura").val();
		//var fllegada=$("#datepicker").val();
		var patente=$("#patente").val();
		var chofer=$("#chofer").val();
		var transporte=$("#transporte").val();
		var tambores = idsOfSelectedRows;
		//var tambores = $("#grillaConPesos").jqGrid('getDataIDs');		
		//var tambores=JSON.stringify(indices_tam);
		cargarRemito(ingreso,deposito,patente,chofer,transporte,tambores);
		console.log(tambores);		
	});

	function cargarRemito(ingreso,deposito,patente,chofer,transporte,tambores){ 	             
        $.ajax({
            url:'includes/cargarRemito.php',
            type:'post',
            data: { 
            	"num_ing": ingreso,
            	"deposito":deposito,
			    "nopatente":patente,
			    "chofer":chofer,
			    "transporte":transporte,
			    "tambores":tambores					    
			},                     
            success:  function (response) {
            	//alert("Tambor Guardado");	
            	location.href="logistica.php#tabmov";                    
            }
        });
	}
});

$("#reporte").click(function(){
	location.href="pendaxls.php";
});