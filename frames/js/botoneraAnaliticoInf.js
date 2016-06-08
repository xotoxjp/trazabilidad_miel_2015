    // si pasa por el archivo de edit  carga la variable accion
    var accion = $("#accion").val();
    //console.log(accion);    
    if (accion == 'edit'){
      var ruta = 'includes/guardar_Analitico_inf.php?accion='+accion;
      //console.log(ruta);
    }
    else{
      ruta = 'includes/guardar_Analitico_inf.php?accion='+accion;
    }  

    $("#btnvolver").click(function(){
      event.preventDefault();
      location.href="analitico_inf.php";
    });

    
    $("#btnguardar").click(function(){ 
      var form = $("form");
      if(form[0].checkValidity()){
         guardarDatos();
       }   
     });

    function guardarDatos(){
       //event.preventDefault();
      // dato aparte de los necesarios, el id proximo
      var cod_anal_id = $("#cod_anal_id").val();
           
      var nomencl = $("#nomencl").val();
      var nomencl1 = $("#nomencl1").val();
      var esp_inf = $("#esp_inf").val();
      var esp_sup = $("#esp_sup").val();
      var unidad = $("#unidad").val();
      var aplica_ok = $("#aplica_ok").val();
      var leyenda1 = $("#leyenda1").val();
      var leyenda2 = $("#leyenda2").val();
      var leyenda3 = $("#leyenda3").val();
      
      var DATA = [];
      var item = {}
      
      item["nomencl"] = nomencl;
      item["nomencl1"] = nomencl1;
      item["esp_inf"] =esp_inf;
      item["esp_sup"] = esp_sup;
      item["unidad"] = unidad;
      item["aplica_ok"] = aplica_ok;
      item["leyenda1"] = leyenda1;
      item["leyenda2"] = leyenda2;
      item["leyenda3"] = leyenda3;
      item["cod_anal_id"] = cod_anal_id;
      
      DATA.push(item);
      var aInfo = JSON.stringify(DATA);
      INFO  = new FormData();
      INFO.append('data', aInfo);      
      //console.log(INFO);     
      //console.log(aInfo);
      
      event.preventDefault();     
      $.ajax({
              data: INFO,
              type: 'POST',
              dataType: 'json',
              url: ruta,
              processData: false, 
              contentType: false,
              success: function(response){
                //Una vez que se haya ejecutado de forma exitosa hacer el código para que muestre esto mismo.
                consoloe.log(response.mensaje);
              }
      });               
      location.href="analitico_inf.php"; 
    }