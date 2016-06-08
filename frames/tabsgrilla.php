
<!DOCTYPE HTML>
<html>
<head>
  <title>EasyTabs </title>
    <link href='grid/css/jquery-ui-custom.css' rel='stylesheet' type="text/css"/>
    <link href='grid/css/ui.jqgrid.css' rel='stylesheet' type="text/css"/>
    <link href='css/clientes1.css' rel="stylesheet" type="text/css"/> 
    <script src='grid/js/jquery-1.9.0.min.js'></script>    
    <script src='grid/js/grid.especial-locale-es.js'></script>
    <script src='grid/js/jquery.jqGrid.min.js'></script>
 
    <script src="js/jquery.hashchange.min.js" type="text/javascript"></script>
    <script src="js/jquery.easytabs.min.js" type="text/javascript"></script>

    <style>
        /* Example Styles for Demo */
        *{  font-family: sans-serif;}
        .etabs { margin: 0; padding: 0; }
        .tab { display: inline-block; zoom:1; *display:inline; background: #eee; border: solid 1px #999; border-bottom: none; -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; }
        .tab a { font-size: 14px; line-height: 2em; display: block; padding: 0 10px; outline: none; }
        .tab a:hover { text-decoration: underline; }
        .tab.active { background: #fff; padding-top: 6px; position: relative; top: 1px; border-color: #666; }
        .tab a.active { font-weight: bold; }
        .tab-container .panel-container { background: #fff; border: solid #666 1px; padding: 10px; -moz-border-radius: 0 4px 4px 4px; -webkit-border-radius: 0 4px 4px 4px; }
        .panel-container { margin-bottom: 10px; }
    </style>
    
</head>

<body>

 
    <div id="tab-container" class='tab-container'>
    <ul class='etabs'>
      <li class='tab'><a href="#tabs1-html">HTML Markup</a></li>
      <li class='tab'><a href="#tabs1-js">Required JS</a></li> 
    </ul>
    <div class='panel-container'>
      <div id="tabs1-html">
        <h2>HTML Markup for these tabs</h2>
        <p>The HTML markup for your tabs and content can be arranged however you want. At the minimum, you need a container, a collection of links for your tabs (an unordered list by default), and matching divs for your tabbed content. Make sure the tab <code>href</code> attributes match the
        <code>id</code> of the target panel. This is standard semantic markup for in-page anchors.</p>
        <p>The class names above are just to make it easy to style. You can make them whatever you want, there's no magic here.</p>
      </div>        
      <div id="tabs1-js">
        <h2>JqGrid tab</h2> 
        <div class='wrapper'>
          <table id="rowed2"></table> 
          <div id="prowed2"></div>  
        </div> 
      </div>        
    </div> 


    <script type="text/javascript">
      $(document).ready( function() {
        $('#tab-container').easytabs();


       jQuery("#rowed2").jqGrid({
            url:'grid/servercliente.php?q=3',
          datatype: "json",
            colNames:['CLIENTE','RAZON SOCIAL', 'DIRECCION', 'LOCALIDAD','PAIS','CONTACTO','E-MAIL','TELEFONO'], 
          colModel:[ 
            {name:'cliente_id',index:'cliente_id', width:90,align:"center",classes: 'cvteste'}, 
            {name:'razon_social',index:'razon_social', width:190,classes: 'cvteste',editable:true}, 
            {name:'dir1',index:'dir1', width:220,classes: 'cvteste',editable:true},
            {name:'Localidad',index:'Localidad', width:160,classes: 'cvteste',editable:true},
            {name:'pais',index:'pais', width:100, sortable:false,classes: 'cvteste',editable:true},
            {name:'contacto',index:'contacto', width:180, sortable:false,classes: 'cvteste',editable:true},
            {name:'email',index:'email', width:200, sortable:false,classes: 'cvteste',editable:true},
            {name:'tel',index:'tel', width:120, sortable:false,classes: 'cvteste',editable:true}       
          ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#prowed2',
            sortname: 'cliente_id',
          autoencode:true,
          viewrecords: true,
          height:'100%',
          width:'100%',
          sortorder: "asc"        
          });
          jQuery("#rowed2").jqGrid('navGrid',"#prowed2",{edit:false,add:false,del:false,search:true},
            {url:'grid/updatecliente.php'},{url:'grid/addcliente.php'},{url:'grid/deletecliente.php'},{}
          );     
          /*custom edit button */
          jQuery("#rowed2").navGrid('#prowed2',{edit:false,add:false,del:false,search:false})
            .navButtonAdd('#prowed2',{caption:"", buttonicon:"ui-icon-pencil", onClickButton: function(){     
                 var myGrid = $('#rowed2'),
                 selectedRowId = myGrid.jqGrid ('getGridParam', 'selrow'),
                 cellValue = myGrid.jqGrid ('getCell', selectedRowId, 'cliente_id');     
                 if (cellValue!==false){
                  /*pasa el vinculo con el id que se guardo en cellValue de la fila seleccionada*/
                  location.href='mod_clientes.php?ID='+cellValue;
                 }else{
                  alert("Por favor seleccione una fila");
                 }
                 }, 
             position:"last"
          }); 
          /*custom add button */
          jQuery("#rowed2").navGrid('#prowed2',{edit:false,add:false,del:false,search:false})
            .navButtonAdd('#prowed2',{caption:"", buttonicon:"ui-icon-plus", onClickButton: function(){     
                 location.href='mod_clientes2.php'; 
                 }, 
             position:"last"
          });     












        
      });
    </script>    

  


</body>
</html>