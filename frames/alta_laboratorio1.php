<?php
session_start();
//include_once("funciones.php");
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
$nivel_dato=$_SESSION["acceso_acc"];

$id_usuario=$_SESSION["id_usuario"];
// CONEXION A LA BASE DE DATOS
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$i = $id_usuario + 0;

/*
if ($i<1)  {
  $_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php");
  echo '1';
}
*/


$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' WHERE id_usuario='.$id_usuario.' AND proceso="Procesos" AND orden=4 AND acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}

/*
if (($alta!='on') or ($i<1) ){
    $_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php");
  echo '1';
}
*/

$cadena=$_GET["tambores"];//son los numeros de tambores en un vector ej: 371,372 (los separo sacandole la coma)
$vector=explode(",",$cadena);
$cantidad=count($vector);


/***********************************************************************************************************************************/
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <title>Laboratorio</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="fotos/matraz.jpg">  
  <link rel="stylesheet" href="css/estiloFormu.css">
  <script src="js/jquery-1.11.1.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
  <div id="afuera">
    <h2 id="cabecera2">MUESTRAS SELECCIONADAS</h2>
    <?php 
      /*$cx_validar = mysql_pconnect("localhost","root","root");
      mysql_select_db("chmiel");
      for ($i=0; $i<count($vector);$i++){
         echo "<b id='texto'>".$vector[$i]." / </b>";
      }*/      
      ?>
  </div>
  <form class="miform"  method="POST" action="guarda_alta_lab1.php">  
  <div id="general">
  <h2 id="cabecera2">DEFINICI&Oacute;N DE ANALISIS</h2>
    <div id="contenedor1" >
        <!--b id="titulo">LUGAR DE INSPECCI&Oacute;N Y TOMA DE MUESTRAS:</b-->
        <?php
        //$cx_validar = mysql_pconnect("localhost","root","root");
        //mysql_select_db("chmiel");
        //$a= "SELECT almacen_id,razon_social,dir1,localidad FROM  almacenes WHERE tipo_almacen<>2 AND tipo_almacen<6" ;
        //$r1 = mysql_query($a,$cx_validar);
        ?>
        <!--select name="alm_toma"--> 
        <?
        //while ($v1 = mysql_fetch_array($r1)){ 
        //  echo  "<option value="."'".$v1[0]."'";
        //  if ($alm_toma==0){
        //    echo ' SELECTED ';
        //    $alm_toma=$v1[0];
        //  }
        // echo ">".$v1[0].'-'.$v1[1].'-'.$v1[3].'-'."</option>"; 
        //}
        //echo '</select>';
        ?>

        <!--/**********************************/-->         
        
        <br><br><b id="titulo">LUGAR DE INSPECCI&Oacute;N</b>
        <?php
        $cx_validar = mysql_pconnect("localhost","root","root");
        mysql_select_db("chmiel");
        $a="SELECT almacen_id,razon_social,dir1,localidad FROM  almacenes WHERE tipo_almacen=2" ;
        $r1 = mysql_query($a,$cx_validar);
        ?>
        <select name="almacen_id" id="almacen_id"> 
        <?
        while ($v1 = mysql_fetch_array($r1)){ 
          echo  "<option value="."'".$v1[0]."'";
          if ($almacen_id==0) {
          echo ' SELECTED ';
          $almacen_id=$v1[0];
          }
          echo ">".$v1[0].'-'.$v1[1].'-'.$v1[2].'-'.$v1[3].'-'."</option>";
        }
        echo '</select>';
        ?>
            
       
    </div><!-- contenedor1 -->

    <div id="contenedor2">
      <img src="fotos/microscopio.jpg" alt="microscopio">
      <div id="tituloeleccion"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Datos de Env&iacute;o&nbsp;</b></div><br><br>
        <b>Fecha:&nbsp;<input type="date" name="fecha" /></b><br><br>   
        <!-- En nuestra tabla no tenemos la hora pero lo dejo por si hay un posible cambio -->
        <!--b>Hora:&nbsp;<input type="time" name ="hora" value="'.$hora_ini.'"/></b--><br><br> 
          
        <!-- prioridad -->
        <br><div id="prioridad">
            <b>Prioridad:</b>
            <?php
              $cx_validar = mysql_pconnect("localhost","root","root");
              mysql_select_db("chmiel");
              $a2="SELECT prioridad FROM  prioridad";
              $r2 = mysql_query($a2,$cx_validar);

              echo '<select name="prioridad" id="prioridad">';
              while ($v2 = mysql_fetch_array($r2)){ 
                echo  "<option value="."'".$v2[0]."'";
                if (($prioridad==$v2[0]) or (strlen($prioridad)==0)){
                  echo ' SELECTED ';
                  $prioridad=$v2[0];
                }
                echo '>'.$v2[0].'</option>'; 
              } 
              echo '</select>';
              ?>
          <br>
          <br>
        </div><!--prioridad-->
        
        <!-- operador --> 
        <br><div id="quienOp">
        <!--?php
        // ACÁ SE ELIGE QUIEN ES EL USUARIO QUE INGRESO
          echo '<label><b>&nbsp;Qui&eacute;n Oper&oacute&nbsp;</b></label>';
          //recibire el dato de quien es el que en ese momento esta operando el form
          $actualizar1="SELECT id_usuario,login FROM usuario WHERE op_campo='Si'";
          $rs_validar1 = mysql_query($actualizar1,$cx_validar);

          echo  '<select name="operador">';
          while ($v_validar1 = mysql_fetch_array($rs_validar1)){ 
            echo  "<option value="."'".$v_validar1[1]."'"; // selecciona quien opera 
            if ($v_validar1[1]==$logg){
              echo ' SELECTED ';
            }
            echo ">".$v_validar1[1]."</option>"; 
          } 
          echo '</select>';
        ?-->
       </div> 
    </div><!--  fin contenedor2 -->
    
    <div id="contenedor3">
      <div id="btneleccion">
        <br><div id="tituloeleccion"><b>AN&Aacute;LISIS PARA LAS MUESTRAS</b></div><br>
        
        <button type="button" id="todos" class="btn" value="">TODOS</button>
        <button type="button" id="ninguno" class="btn" value="">NINGUNO</button>
        <button type="button" id="principales" class="btn" value="">AN&Aacute;LISIS PRINCIPALES</button>
      </div>
      <!-- col1 -->  
      <div id="col1">
        <?php        
        
        $cx_validar = mysql_pconnect("localhost","root","root");
        mysql_select_db("chmiel");
        $act="SELECT max( cod_anal_id ) FROM analitico_inf";
        $rs_validar = mysql_query($act,$cx_validar) ;
        while ($v_validar = mysql_fetch_array($rs_validar)){
          $cantidadAnalisis = $v_validar[0];    
        }
        echo "<h3 id='cabecera3'> CANTIDAD DE TIPOS DE ANALISIS ".$cantidadAnalisis."</h3>";
 
        $a1="SELECT cod_anal_id,nomencl FROM analitico_inf ORDER BY cod_anal_id"; //WHERE cod_anal_id < 13";
        $r1 = mysql_query($a1,$cx_validar);
        $i=0;
        while ($v1 = mysql_fetch_array($r1)){ //echo print_r($v1)."</br>"; TRAE LOS CODIGOS DE LOS ANALISIS       
           
          //CHECK DESDE EL 1 AL 12 QUE SALE POR PATALLA
          // este if deja checked los analisis principales pero con posibilidad de cambio y los demas libres de eleccion
          if($v1[0] <= 4 ){
            echo '<label><input id="analisis'.$v1[0].'" type="checkbox"  name="ch[]" value="'.$v1[0].'" checked >'.$v1[0].'&nbsp'.$v1[1].'</label><br>';             
         }
         else{     
            
            echo '<label><input id="analisis'.$v1[0].'" type="checkbox" name="ch[]" value="'.$v1[0].'">'.$v1[0].'&nbsp'.$v1[1].'</label><br>';
         }
         // no borrar cuenta la cantidad de analisis         
         $i++; 
        }// fin while 
        

        ?>
      </div> <!-- fin col1 -->
      
      <!-- col1 -->
      <!-- <div id="col2">      
        <?php
           // $a1="SELECT cod_anal_id,nomencl FROM  analitico_inf WHERE cod_anal_id > 12 ";
            //$r1 = mysql_query($a1,$cx_validar);

            //$j=0;
            //while ($v1 = mysql_fetch_array($r1)){
              //$i++;  
              //$j++;
              //if ($j==1){
               // echo '<h3 id="cabecera3">An&aacute;lisis B&aacute;sicos</h3>';
              //}
              //if ($j==5){
                //echo '<h3 id="cabecera3">An&aacute;lisis Espec&iacute;ficos</h3>';
              //}
              //if ($j==9){
                //echo '<h3 id="cabecera3">Quinonas</h3>';
              //}
              
              // CHECK DESDE EL 13 AL 21 QUE SALE POR PATALLA   
              //echo '<label><input id="analisis'.$v1[0].'" type="checkbox" name="ch[]" value="'.$v1[1].'"/>'.$v1[0].'&nbsp'.$v1[1].'</label><br>';
             //}
         ?>
      </div><fin col2--> 
    </div><!-- fin contenedor3 --> 
     <?php
   /* agrego esta parte de php para poder enviar los tambores que luego seran guardados*/
     echo '<input id="cadena" type="hidden" name="tamborescadena" value="'.$cadena.'">';
    ?>
    <br><div id="accion">
      <a href="analisis1.php"><button type="button" class="btn" title="volver">VOLVER</button></a>
      <button id="procesa" class="btn" value="procesa">PROCESA</button>
    </div>
</div><!--fin general--> 

<!-- mecanismo de los botones -->
    <script type="text/javascript">
        
        var largo = "<?php echo $i; ?>";

        $("#todos").click(function(){
         // la variable i es la que cuenta los analisis que encuentra en la llamada sql
                            
          for (var i=1; i <=largo; i++){
            $("#analisis"+i).prop("checked",true);             
          }
        });
        $("#ninguno").click(function(){
         for (var i=1; i<=largo; i++){
            $("#analisis"+i).prop("checked",false); 
          }
        });
        $("#principales").click(function(){         
             for (var i=1; i <=4; i++){
            $("#analisis"+i).prop("checked",true); 
          }
        });
        var tam = new Array();
        var cadena = $("#cadena").val()        
        var vector = cadena.split(',');
        //lo uso para saber cuantos entraran en en contenedor
		    /*vector = ["1023","1231","5285","2685","1596","1235","1023","1231","5285","2685","1596","1235","1023","1231","5285","2685","1596","1235"]*/ 
        
        // si llega a cargarse muchas muestras genero saltos para que queden dentro del div de tambores seleccionados
        var salto = 8;
        if (vector.length!='undefined'){ 
          for(var i = 0; i < vector.length;i++){          
            if (i == salto){
              $("#afuera").append('<br>');
              salto+=8;        
            }
            $("#afuera").append('<td id="texto">&nbsp;'+vector[i]+'&nbsp; -</td>');
          }
        }        
        $("#procesa").click(function(event){
            // si llega a presionar el boton de procesa sin elegir nada, enviaria datos vacios a la base entonces...
          for (var i=1; i <=largo; i++){
              var cantidadchequedos = $(":input[type=checkbox]").filter(":checked").length;             
          }     
          //alert(cantidadchequedos);      
          if (cantidadchequedos == 0){
            alert("NO SE HA SELECCIONADO NADA");// ver alguna otra opccion! 
          }                
          else{       
            var formulario = $(".miform").submit();
          }
          event.preventDefault();
        });                   
      </script>
</form>
</body>
</html>