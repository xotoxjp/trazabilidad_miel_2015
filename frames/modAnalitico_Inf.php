<?php
session_start();
include_once("funciones.php");
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
$nivel_dato=$_SESSION["acceso_acc"];

$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=9 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";
  header("Location: ../index.php"); }

/*******************************************************************************************************/
$unidad =''; 
$cod_anal_id = $_GET["ID"];
$unidad = $_GET["unidad"];

/**************************************************************************************************/
// solo va a funcionar si es nuevo cliente
$agrego_analisis = $_GET["nuevoAnalisis"];

if ($agrego_analisis== "si"){
  $act="SELECT max( cod_anal_id ) FROM ".$_SESSION["tabla_analitico_inf"];
  $rs_validar = mysql_query($act,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){
    $num_analisis_proximo = 1 + $v_validar[0];    
  }
  // con esta dato engaño de que se esta mostrando el prov_id 
  // del posible nuevo cliente aunque todavia no lo haya agregado a la BD   
  $cod_anal_id = $num_analisis_proximo;
}
/********************************************************************************************************/
  $edit = $_GET["EDIT"];  
  if( $edit =='edit'){

   $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
   mysql_select_db($_SESSION["base_acc"]);

   $actualizar="select * from  ".$_SESSION["tabla_analitico_inf"]. " where cod_anal_id=".$cod_anal_id;

   $rs_validar = mysql_query($actualizar,$cx_validar);

    while ($v_validar = mysql_fetch_array($rs_validar)) {
	  $cod_anal_id= $v_validar[0];
	  $nomencl= $v_validar[1];
	  $nomencl1= $v_validar[2];
	  $esp_inf=$v_validar[3];
	  $esp_sup=$v_validar[4];
	  $unidad=$v_validar[5];
	  $leyenda1=$v_validar[6];
	  $leyenda2=$v_validar[7];
	  $leyenda3=$v_validar[8];
    }    
  }
  
  $actualizar1="SELECT unidad FROM  ".$_SESSION["tabla_unidades"]." WHERE unidad<>"."'".$unidad."'" ;
  $rs_validar1 = mysql_query($actualizar1,$cx_validar);
?>
<html>
  <head>    
    <? 
      echo "<TITLE>Editando la Familia ".$cod_anal_id."</TITLE>";
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery-1.11.1.js"></script>    
    <link rel="stylesheet" href="css/estilo_AnaliticoInf.css">
  </head>

  <body>

  <form id="idFormulario" name='formulario'>
    <div id="general" >

    <h1 id="titulo">DATOS DEL ANALISIS <? echo "$cod_anal_id"; ?> </h1>
    <div id="contenedor1">
    <?    
	    echo "<p>NOMENCLADOR&nbsp;<input type='text' name='nomencl' id='nomencl'  value="."'".$nomencl."'"."  size='40' maxlength='40' /></p>";
	    echo "<p>DETALLE&nbsp;<input type='text' name ='nomencl1' id='nomencl1'  value="."'".$nomencl1."'"." size='20' maxlength='10' /></p>";
	    echo "<p>LIMITE INFERIOR&nbsp;<input type='text' name='esp_inf'  id='esp_inf' value="."'".$esp_inf."'"." size='20' maxlength='8' /></p>";
	    echo "<p>LIMITE SUPERIOR&nbsp;<input type='text' name='esp_sup'  id='esp_sup' value="."'".$esp_sup."'"." size='20' maxlength='8' /></p>";
	    echo"<br>";
	    echo "<hr></hr>";
	    echo"<br>";
	    echo "<p>UNIDAD&nbsp";
        echo "<select name='unidad' id='unidad'>";
        echo  "<option value="."'".$unidad."'>".$unidad."</option>";
            while ($v_validar1 = mysql_fetch_array($rs_validar1)){ 
     	      echo  "<option value="."'".$v_validar1[0]."'>".$v_validar1[0]."</option>";
            }	    
        echo"</select></p>";
        echo "<p id='leyendas1'>LEYENDAS<input type='text' name='leyenda1' id='leyenda1' value="."'".$leyenda1."'"." size='30' maxlength='30' /></p>";
	    echo "<p id='leyendas2'><input type='text' name='leyenda2' id='leyenda2' value="."'".$leyenda2."'"." size='30' maxlength='30' /></p>";    
	    echo "<p id='leyendas3'><input type='text' name='leyenda3' id='leyenda3' value="."'".$leyenda3."'"." size='30' maxlength='30' /></p>";
        echo '&nbsp;<p>APLICA PARA RECHAZO&nbsp;';
        echo  '<select name="aplica_ok" id="aplica_ok">';
        if ($aplica_ok=='No') {
            echo   '<option value=No selected="selected">No</option>';
            echo   '<option value=Si >Si</option>';
        }
        else {
            echo   '<option value=Si selected="selected">Si</option>';
            echo   '<option value=No >No</option>';      
        }
        echo"</select></p>";
        
     ?>
    </div><!-- fin contenedor1 -->
    <br>        
    <hr></hr>
    <br>
    <div id="contenedor5"> 
      <button id="btnvolver"  name="volver" value"volver">VOLVER</button>
      <button id="btnguardar" name="guardar" value"guardar">GUARDAR</button>       
    </div><!--fin contenedor5 -->  
 
    </div><!--fin contenedor general -->
    
    <!-- para crear el fondo oscuro -->
    <!-- <div id="contenedorFondo">
    </div>	 -->

  </form>   
  
  <?
    echo "<input id='cod_anal_id' type='hidden' name='' value='".$cod_anal_id."'>";  
    
    // solo funciona si se edita el archivo
    if($edit=="edit"){
     echo "<input id='accion' type='hidden' name='' value='edit'>";
    }
    // solo funciona si es nuevo el archivo
    if ($agrego_Analisis=="si"){
      echo "<input id='accion' type='hidden' name='' value='nuevo'>";        
    }

  ?>
    
  </body>
  <script src="../frames/js/botoneraAnaliticoInf.js" type="text/javascript"> </script>     
</html>