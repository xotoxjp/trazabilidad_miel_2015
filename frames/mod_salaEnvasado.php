<?php
session_start();
include_once("funciones.php");
$_SESSION["level_req"]="f";
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
$nivel_dato=$_SESSION["acceso_acc"];
$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' WHERE id_usuario='.$id_usuario.' AND proceso="Tablas" AND orden=2 AND acceso="on"';
$r=mysql_query($a,$cx_validar);

$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;
  break;
}

if ($i<1){
   $_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";
   header("Location: ../index.php");
 }

$cod_postal = 0; $lat=0;  $lon=0; $ret_iva = 'No' ;$ret_ib = 'No';  $ret_gan= 'No'; 

$almacen_id = $_GET["ID"];
// $edit = $_GET["EDIT"];

/**************************************************************************************************/
// solo va a funcionar si es nuevo cliente
$agrego_almacen = $_GET["nuevoalmacen"];

if ($agrego_almacen== "si"){
  $act="SELECT max( almacen_id ) FROM ".$_SESSION["tabla_almacenes"];
  $rs_validar = mysql_query($act,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){
    $num_almacen_proximo = 1 + $v_validar[0];    
  }
  // con esta dato engaño de que se esta mostrando el prov_id 
  // del posible nuevo cliente aunque todavia no lo haya agregado a la BD   
  $almacen_id = $num_almacen_proximo;
}
/********************************************************************************************************/
 
  $edit = $_GET["EDIT"];
  if( $edit =='edit'){

    $conexion = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
    mysql_select_db($_SESSION["base_acc"]);
    $consulta ="SELECT * FROM  ".$_SESSION["tabla_almacenes"]. " WHERE almacen_id=".$almacen_id ;
    $respuesta = mysql_query($consulta,$conexion);
 

    while ($v_validar = mysql_fetch_array($respuesta)){
      $almacen_id= $v_validar[0];
      $nombre= $v_validar[1];
      $dir1= $v_validar[2];
      //$dir2= $v_validar[3];
      $localidad=$v_validar[4];
      $cod_postal=$v_validar[5];
      $provincia=$v_validar[6];
      $pais=$v_validar[7];
      $cond_iva=$v_validar[8];
      $nro_cuit=$v_validar[9];
      $contacto=$v_validar[10];
      $tel=$v_validar[11];
      $cel=$v_validar[12];
      $fax=$v_validar[13];
      $nextel=$v_validar[14];
      $email=$v_validar[15];
      //$sector=$v_validar[16];
      $contacto1=$v_validar[17];
      $tel1=$v_validar[18];
      $cel1=$v_validar[19];
      $email1=$v_validar[20];      
      //$lat=$v_validar[22];
      //$lon=$v_validar[23];
      $hora1 = $v_validar[24];
      $hora2 = $v_validar[25];          
      $tipo_almacen=$v_validar[26];      
      $hab_senasa=$v_validar[28];
    }
      
    $cod_postal = 0 + $cod_postal;
       
    // para que se pueda ver la fecha en el calendario porque en la base esta dsitinto que en el formato de html
    // si es 0000-00-00 queda dd/mm/YYYY 
    $date=date_create($fecha_ini);
    $fecha_ini = date_format($date,"Y-m-d");
    // 
  }
?>

<html>
  <head>    
    <? echo '<TITLE>Editando el Sala de Envasado '.$almacen_id.'</TITLE>';?>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery-1.11.1.js"></script>    
    <link rel="stylesheet" href="css/estilo_mod_prov.css">
  </head>

  <body>

  <form id="idFormulario" name='formulario'>
    <div id="general">

    <h1 id="titulo">DATOS DEL ALMACEN <? echo "$almacen_id"; ?> </h1>
    
    <div id="contenedor1Envasado">  
      <?
        echo "NOMBRE&nbsp;<input id='razon' name='nombre' type='text'  value='$nombre' size='50' maxlength='50' required/><br>";      
        echo "NUMERO DE HABILITACION DE SENASA&nbsp<img src='fotos/senasa.JPG' width='20' height='20'><input name='hab_senasa' type='text' id='senasa' value="."'".$hab_senasa."'"."  size='20' maxlength='20' />";
        echo "<p>DIRECCI&Oacute;N&nbsp;<input name='dir1' type='text' id='dir1'  value='$dir1' size='50' maxlength='50' required /></p>";
        echo"<p>LOCALIDAD&nbsp;<input name='localidad' type='text' id='localidad'  value='$localidad'  size='30' maxlength='30' />&nbsp;&nbsp;";
        echo"&nbsp;&nbsp;C&Oacute;DIGO POSTAL&nbsp;<input name='cod_postal' type='text' id='cod_postal'  value="."'".$cod_postal."'"."  size='8' maxlength='10' /></p>";         
        echo"PROVINCIA&nbsp;<input name='provincia' type='text' id='provincia'  value='$provincia'  size='20' maxlength='20' required />";
        echo"&nbsp;&nbsp;PAIS&nbsp;<input name='pais' type='text' id='pais' value='$pais'  size='20' maxlength='20' /></p>";
        echo"<br>";
        echo"<hr></hr>";                
        echo"<br>"; 
        echo"<p>CONTACTO&nbsp;<input name='contacto' type='text' id='contacto'  value='$contacto' size='30' maxlength='10' />";          
        echo"&nbsp;&nbsp;TELEFONO&nbsp;<input name='tel' type='text' id='tel'  value='$tel' size='30' maxlength='30' /></p>";

        echo"<p>CELULAR&nbsp;<input name='cel' type='text' id='cel' value='$cel'  size='15' maxlength='15' />";
        echo"&nbsp;&nbsp;NEXTEL&nbsp;<input name='nextel' type='text' id='nextel' value='$nextel'  size='8' maxlength='8' /></p>";

        echo"<p>&nbsp;&nbsp;EMAIL&nbsp;<input name='email' type='text' id='email'  value='$email' size='30' maxlength='30' />";
        echo"&nbsp;&nbsp;FAX&nbsp;<input name='fax' type='text' id='fax'  value='$fax' size='15' maxlength='15' /></p>";
      ?>
    </div><!-- fin contenedor1 -->
      <br>      
      
      <h4> <img id="abrir_contenedor3" src="fotos/desplegar0.png"/> DATOS ADICIONALES</h4>
      
      <div id="contenedor3Envasado">
        <?
          // comienzo de los datos adicionales 
          echo"<p>CONTACTO&nbsp;<input name='contacto1' type='text' id='contacto1'  value='".$contacto1."' size='30' maxlength='30' />";
          echo"&nbsp;&nbsp;TELEFONO&nbsp;<input name='tel1' type='text' id='tel1'  value='".$tel1."' size='15' maxlength='15' /></p>";
          
          echo"<p>CELULAR&nbsp;<input name='cel1' type='text' id='cel1' value="."'".$cel1."'"."  size='15' maxlength='15' />";
          echo"&nbsp;&nbsp;EMAIL&nbsp;<input name='email1' type='text' id='email1' value="."'".$email1."'"."  size='12' maxlength='30' /></p>";
       ?> 
      </div><!--fin contenedor3-->
      <br>
      <h4> DATOS FISCALES </h4> 
      <div id="contenedor4Envasado">
      <?
         /* agregue esta llamada a BD para habilitar el selector de tipo de iva ya que sin ella quedaba indefinido 10-11-2014 */
          $actualizar1="select cod_iva from  ".$_SESSION["tabla_iva"]." where cod_iva<>"."'".$cond_iva."'" ;
          $rs_validar1 = mysql_query($actualizar1,$cx_validar); 
          /* fin llamada a BD para habiilitar el selector de tipo de iva */
          echo  '<p id="datosFiscales">&nbsp;&nbsp;&nbsp;CONDICI&Oacute;N DE IVA:'."&nbsp";
          echo  '<select name="cond_iva" id="cond_iva">';
          echo  "<option value=".$cond_iva.">".$cond_iva."</option>";
          while ($v_validar1 = mysql_fetch_array($rs_validar1)){
            if ($v_validar1[0]==$cond_iva){
              echo "<option value=".$v_validar1[0]." selected >".$v_validar1[0]."</option>";
            }
            else {
              echo  "<option value="."'".$v_validar1[0]."'>".$v_validar1[0]."</option>"; 
            }
           }
           echo  "&nbsp;".'N&uacute;mero  de Cuit:'."&nbsp";
           echo "<input name='nro_cuit' id='nro_cuit' type='text'  value='$nro_cuit'  size='13' maxlength='13' />";
        ?>    
      </div><!--fin contenedorEnv4 -->       
      <br>
      <div id="contenedor5"> 
        <button id="btnvolver"  name="volver" value"volver">VOLVER</button>
        <button id="btnguardar" name="guardar" value"guardar">GUARDAR</button>
        <!--button id="btnimprimir" name="imprimir" value"imprimir">IMPRIMIR</button-->        
      </div><!--fin contenedor5 -->  
 
    </div><!--fin contenedor general -->
  </form>   
  
  <?
    // este dato del $tipo_almacen lo seteo fijo, ya que si no lo tiene la tabla no recoge nada
    // porque la condicion where toma los datos segun tipo de almacen
    $tipo_almacen = 3;
    echo "<input id='tipo_almacen' type='hidden' name='' value='".$tipo_almacen."'>";   
    echo "<input id='almacen_id' type='hidden' name='' value='".$almacen_id."'>";  
    
    // solo funciona si se edita el archivo
    if($edit=="edit"){
     echo "<input id='accion' type='hidden' name='' value='edit'>";
    }
    // solo funciona si es nuevo el archivo
    if ($agrego_almacen=="si"){
      echo "<input id='accion' type='hidden' name='' value='nuevo'>";        
    }

  ?>
      
  </body>
  <script src="../frames/js/botoneraSalaEnvasado.js" type="text/javascript"> </script>     
</html>