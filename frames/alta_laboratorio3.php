<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1"> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="fotos/chmiel.ico">  
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href='../frames/grid/css/jquery-ui-custom.css' rel='stylesheet' type='text/css'/> 
    <link href='../frames/css/alta_extaco1N.css' rel='stylesheet' type="text/css"/>
    <script src='../frames/grid/js/jquery-1.11.1.js'></script>
    <script src='../frames/js/jquery.numeric.min.js'></script>         
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootbox.min.js"></script>
  </head>
 <body> 
  <div id="tambores_seleccionados">
    <h2>Análisis de Muestras</h2>
    <h4>Tambores Seleccionados</h4>
    <div id="analisis">
      <p>Fecha de Análisis <input type="date" id="fecha_analisis" tabindex="1">    
      </p>
      <div id="datos">    
        <table id="tablaAnaRestantes">        
        </table>
        </div>
        <div>
  <div>  
  <div id="botonera">                 
    <input type="button" class="boton" id="volver" value="Volver"/>
    <input type="button" class="boton" id="guardar" value="Guardar"/>     
    <input type="button" class="boton" id="exportarExcel" value="Exportar a Excel"/>          
  </div>   
   
   <div id="aviso">
   </div> 

  <div style="display:none" id="dialog" title="Aviso">Operación Exitosa!</div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Aviso</h4>
          </div>
          <div class="modal-body">
              <p>Operación Exitosa!</p>
          </div>
          <div class="modal-footer">
              <button type="button" id="modalClick"class="btn btn-default" data-dismiss="modal">Aceptar</button>
          </div>
        </div>
    </div>
  </div>
  
    
  
 </body>
 <?
   $accion = $_GET["quiero"];
   echo "<input type='hidden' name ='' id ='accion' value=".$accion.">"; 
   $tam=$_GET["tambores"];
   echo "<input type='hidden' name ='' id ='tam' value=".$tam.">"; 
 ?>
 <script>
    $(document).ready(function(){       
           
        var accion = $("#accion").val();
        //oculto el botón de guardar si estoy en modo accion=ver
        if (accion=='ver'){
          $('#guardar').hide();
        }else{
          $('#guardar').show();
        }

        var tam = $("#tam").val();
        var temp = new Array();
        // this will return an array with strings "1", "2", etc.
        temp = tam.split(",");      
        var largo = temp.length;
        var p=0;        

        var cont_analisis = [];
        var resultado = [];
        
        var result = [];
        var nomencl = [];
        var codigos = [];
        // crea las cabeceras
        var cabecera ='<th id="muestra">muestra</th><th>productor</th>';
        var result = MinAndMaxCabecera($("#tam").val());    
        
        var bandera = 0;
        var otraParte = '';
        var paso = 0;        
        var tab=1;
      
        while (p < largo){
          
        $.ajax({
        url: '../frames/includes/otrasMuestras.php?tambores='+temp[p],
        dataType: 'json',
        async:false,
                success:  function (data) {           
                    
                    
                var hayAlgo =data.length;
                if(hayAlgo!=0){                   

                    // esto se repetira por cada fila del sql por eso lo saco del for  
                    var tambor = data[0].id_tambor;                                      
                    var conclusion = $.trim(data[0].conclusion);
                    
                    var fecha = data[0].fecha_analisis;              
                    $("#fecha_analisis").val(fecha);                                 
                            
                   // la idea es que voy a llenar los vectores resultado, nomencl y cont_analisis ambos tendran
                   // la misma cantidad de datos, por lo tanto los puedo presentar en pantalla sin problemas 
                          
                    for (var i in data){
                        var r = data[i].resultado;                          
                        resultado.push(r);                        
                        var idAna = data[i].cod_analisis_id;
                        cont_analisis.push(idAna);
                    }                                      
                    
                    /**** Desde ahora la nomeclatura la busco de acá *****/

                    for (var i in result){
                      var n = result[i].titulos;
                      nomencl.push(n);
                      var c = result[i].codigos                
                      codigos.push(c);// carga los codigos segun el max de analisis para la tabla                    
                    }                    

                    /***************************************************/ 
                    // todoOrdenado es una matriz ya que la funcion codigoOrdena ordena 
                    // tanto los codigo como los resultados 
                    // codigo: todoOrdenado[0][i]  y ressultado todoOrdenado[1][i] posicion 0 ó 1
                    
                    var todoOrdenado = ordenador(codigos,cont_analisis,resultado);
                    var prod = productores(tambor);              
                    

                    var fila='<tr id='+tambor+'><td>'+tambor+'</td><td name="productor" id="p'+tambor+'">'+prod[0]+'</td>';
                    var filaEspecial = '<tr id ="oculto"><td >vacio</td><td >vacio</td>';
                    
                    var hastaAca = codigos.length;                         
                    for(var k=0; k < hastaAca ;k++){  
                         
                        if(bandera==0){
                          cabecera += '<th>'+nomencl[k]+'</th>';
                          filaEspecial +='<td id="oculto"><input type="text" id="ana" value="'+codigos[k]+'" size=10 /></td>';
                        }
                        // necesito una funcion que compare los vectores de manera correcta
                        if(todoOrdenado[0][k]!=-1){  
                                                   
                            if(accion=='ver'){ 
                              
                              fila += '<td><p id="etiquetaVer">'+todoOrdenado[1][k]+'</p></td>';
                              otraParte='<td>'+conclusion+'</td>';
                            }
                            else{                              
                              
                              fila += '<td><input onfocus="validar(this)" tabindex="'+tab+'" type="text" id="ana"'+cont_analisis[k]+'" value="'+todoOrdenado[1][k]+'" size=10 /></td>';                                                                                                       
                              otraParte='<td><select id="resultado'+tambor+'"><option value=" "></option><option value="cumple">Cumple</option><option value="no cumple">No Cumple</option></select></td>';
                              tab+=largo;
                            }
                        }
                        else{
                          fila +='<td><b><img src="fotos/tubeno.png" width=30px height=30px /></b></td>';
                          
                        }    
                      }//fin for codigos
                      // cambia al cargar la segun muestra
                      tab=1;                      

                      fila += '</td>'+otraParte+'<td id="espacioBlanco"></td></tr>';                        
                      if(bandera==0){
                          cabecera+= '<th>RESULTADO</th>' 
                         $('#tablaAnaRestantes').append(cabecera);
                         filaEspecial += '<td >vacio</td></tr>';
                         //console.log(filaEspecial);
                         $('#tablaAnaRestantes').append(filaEspecial);

                      }
                      $('#tablaAnaRestantes').append(fila);         
                      
                      // sumo 1 a la bandera para limitar el ingreso en donde solo debe entrar una vez
                      bandera++;
                      
                      // cambio el dato del select y coloco el option correspondiente
                      $("#resultado"+tambor).val(conclusion); 

                      // limpio los vectores para cargar con los datos del siguiente
                      resultado.length = 0; 
                      cont_analisis.length = 0;
                      nomencl.length = 0; 

                      codigos.length = 0;

                    }
                    else{
                        
                    var tam = $("#tam").val();
                    var temp = new Array();
                    // this will return an array with strings "1", "2", etc.
                    temp = tam.split(",");
                      if(paso==0){
                          $("#aviso").append("<p id='informe'>EXISTE/N MUESTRA/S SIN DEFINICION DE ANALISIS</b></p><br>");  
                      }                       
                      paso++;
                    }    
              }//fin success
          });//fin Ajax                 
        p++;// contador para muestra

        }// end of while      
    });// fin click funcion manejadora     
         

/*********************************************************************************************************************/
  function validar(elemento){
    //no deja ingresar ningun char que sea distinto de numero o el punto ".""
    $(elemento).numeric({ decimal : ".",  negative : true, scale: 3 }); 
  }
  

/*********************************************************************************************************************/  
    function MinAndMaxCabecera(muestras){    
      var result = [];
      $.ajax({         
          url: 'includes/MinAndMaxCabecera.php?muestras='+muestras,          
          dataType: 'json',
          async: false,
          success:  function (data) { 
              result = data              
          }          
      });
      return result;
    }
/***************** productores *******************/
    
    function productores(muestra){       
      var prod = [];
      $.ajax({         
          url: 'includes/nombresProd.php?muestra='+muestra,          
          dataType: 'json',
          async: false,
          success:  function (data) { 
              prod = data
              //console.log(prod);              
          }          
      });
      return prod;
    }

/************************ codigos ordenados *********************/

    function ordenador(v1,v2,res){
      
      var codOrd = [];
      var resultado = [];
      var i = 0;
      var j =0;
      var corte = v1.length;
      while( i < corte){       
          //console.log(v1[i]+"|"+v2[j]);
          if(v1[i]==v2[j]){
             codOrd[i]=v2[j];
             resultado[i]=res[j];
             //console.log(ord[i]);
             i++;
             j++;
          }//fin if
          else{            
             codOrd[i]=-1;
             resultado[i]='no requerido';
             i++;             
             //console.log(ord[i]);            
           }// fin else       
      }// while externo
      console.log(codOrd);
      console.log(resultado);
      return [codOrd,resultado];
    } 

/*************************************** guardado de la informacion ********************************************/
  
  function grabarTodoTabla(){
        
        var DATA = [];
        var tam = $("#tam").val();
        var temp = new Array();

        // this will return an array with strings "1", "2", etc.
        temp = tam.split(",");
        var largo = temp.length;
                    
        var TABLA = $("#tablaAnaRestantes tr");            
        // de esta forma puedo obtener la cantidad de tds que tiene mi tabla
        var cantidad_TDS = TABLA.find('input[id="ana"]').length;        
        //console.log(cantidad_TDS);
        var cantidad_TRS = TABLA.length;
        cantidad_TRS--;       
        
        // declaracion de algunas variables
        DATA = [];
        var item1 = {};
        var item2 = {};  
        var item3 = {};
        var item4 = {};
        

        // cargo item1
        item1['columnas']=cantidad_TDS; 
        item1['filas']=cantidad_TRS;                   
        
        // cargo item2
        for (var i in temp){
           item2[i]=temp[i];           
        }
          
        
        // cargo item3
        var k=0;        
        for (var i=0; i<=cantidad_TRS;i++ ){ 
            var FILA = $('#tablaAnaRestantes tr:eq('+i+')');          
            // atrapo los elemento que es esten seleccionados en los opccion
            var option = FILA.find('select :selected('+k+')').val();
          if (option!=undefined){
            item3[k] = option;
            k++;
          //console.log(item1);               
           }
      }
       
        
        // cargo DATA con los objetos anteriores
        DATA.push(item1);
        DATA.push(item2);
        DATA.push(item3);        
        
        for (var i=0; i<=cantidad_TRS;i++ ){ 
            var FILA = $('#tablaAnaRestantes tr:eq('+i+')');
            var item={};           
            //aca guardo los resultados 
            for (var j=0; j<cantidad_TDS;j++ ){ 
              var input = FILA.find('input:eq('+j+')').val();             
              item[j]=input;
            }
          // carga especial del objeto item, ya que son varios 
          DATA.push(item);
        } 
        //esta fecha sera la misma para cada muestra en la lista elegida 
        // la envio por get en la url del AJax 
        
        var fechaAnalisis = $("#fecha_analisis").val();     
        
        
        aInfo   = JSON.stringify(DATA);   
        INFO  = new FormData();
        INFO.append('data', aInfo); 
        //console.log(item4);
        $.ajax({
          data: INFO,
          type: 'POST',
          dataType: 'json',
          url:'includes/guardarAnaSeleccionados.php?fecha='+fechaAnalisis,
          processData: false, 
          contentType: false,
          success: function(r){
            //Una vez que se haya ejecutado de forma exitosa hacer el código para que muestre esto mismo.
          },
          timeout: 300000 
          //tiempo maximo de espera 300 segundos - 5 minutos
        });       
                  
    }// fin function

/*****************************************************************************************************************/
      
    // todos los botones

    $("#volver").click(function() {       
      location.href="analisis1.php";
    });
    //$("#fecha_analisis").datepicker({ format:'yyyy-mm-dd'});
    $("#exportarExcel").click(function(){
      var tam = $("#tam").val();
      location.href="labaxls.php?muestras="+tam;
    }); 

    $("#guardar").click(function(){        
        grabarTodoTabla();
        $('#myModal').modal();
        $('#modalClick').click(function() {
             location.reload(); 
        });
    }); 
 
 </script>
</html>