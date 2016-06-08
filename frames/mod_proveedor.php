<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include_once("funciones.php");
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

/**************************************************************************************************/

$cod_postal = 0; $lat=0;  $lon=0; $ret_iva = 'No' ;$ret_ib = 'No';  $ret_gan= 'No'; 

$prov_id = $_GET["ID"];
// $edit = $_GET["EDIT"];

/**************************************************************************************************/
// solo va a funcionar si es nuevo cliente
$agrego_cliente = $_GET["nuevocliente"];

if ($agrego_cliente== "si"){
  $act="SELECT max( prov_id ) FROM ".$_SESSION["tabla_provedores"];
  $rs_validar = mysql_query($act,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){
    $num_cliente_proximo = 1 + $v_validar[0];
  }
  // con esta dato engaño de que se esta mostrando el prov_id 
  // del posible nuevo cliente aunque todavia no lo haya agregado a la BD   
  $prov_id = $num_cliente_proximo;
}
/********************************************************************************************************/
 
  $edit = $_GET["EDIT"];
  if( $edit =='edit'){

    $conexion = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
    mysql_select_db($_SESSION["base_acc"]);
    $consulta ="SELECT * FROM  ".$_SESSION["tabla_provedores"]. " WHERE prov_id=".$prov_id ;
    $respuesta = mysql_query($consulta,$conexion);

    while ($v_validar = mysql_fetch_array($respuesta)){
      $prov_id= $v_validar[0]; 
      $nombre= $v_validar[1];
      $dir1= $v_validar[2];
      //$dir2= $v_validar[3];
      $localidad=$v_validar[4];
      $cod_postal=$v_validar[5];
      $provincia=$v_validar[6];
      $pais=$v_validar[7];
      $cond_iva=$v_validar[8];
      $nro_cuit=$v_validar[9];
      $ret_iva=$v_validar[10];
      $ret_gan=$v_validar[11];
      $ret_bru=$v_validar[12];
      $contacto=$v_validar[13];
      $tel=$v_validar[14];
      $cel=$v_validar[15];
      $fax=$v_validar[16];
      $nextel=$v_validar[17];
      $email=$v_validar[18];
      //$sector=$v_validar[19];
      $contacto1=$v_validar[20];
      $tel1=$v_validar[21];
      $cel1=$v_validar[22];
      $email1=$v_validar[23];  
      //$contacto2=$v_validar[25];
      //$tel2=$v_validar[26];
      //$cel2=$v_validar[27];
      //$email2=$v_validar[28];  
      //$lat=$v_validar[30];
      //$lon=$v_validar[31];
      $c1=$v_validar[32];//renapa
      $c2=$v_validar[33];// sala de ext
      //$c3=$v_validar[34];
      //$num_campos=$v_validar[35];
      //$ncol=$v_validar[36];  
      $fecha_inicial=$v_validar[38];  
      $fecha_ini=substr($fecha_inicial,-2).substr($fecha_inicial,4,4).substr($fecha_inicial,0,4);
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
   	<? echo '<TITLE>Editando el Productor '.$prov_id.'</TITLE>';?>
   	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="fotos/chmiel.ico">    
    <script src="js/jquery-1.11.1.js"></script>    
    <link rel="stylesheet" href="css/estilo_mod_prov.css">
	</head>

	<body>

  <form id="idFormulario" name='formulario'>
	    <div id="general">

	    <h1 id="titulo">DATOS DEL PRODUCTOR <? echo "$prov_id"; ?> </h1>
        
        <div id="contenedor1">  
			    <?
            echo "<p id='fecha'>FECHA DE ALTA:<input type='date' name='fecha_ini' id='fecha_ini' value='".$fecha_ini."' placeholder ='al Sistema'/></p>";                    
            echo "NOMBRE PRODUCTOR:<input id='razon' name='nombre' type='text'  value='$nombre' size='50' maxlength='50' required/>";
  	        echo "&nbsp;&nbsp;RENAPA:<input name='c1' type='text' id='renapa'  value='$c1' size='13' maxlength='13' required />";
    		    
            echo"<p>SALA DE EXTRACCIÓN:";
            
            $cx_validar = mysql_pconnect("localhost","root","root");
            mysql_select_db("chmiel");
            $actualizar1="SELECT razon_social FROM almacenes WHERE tipo_almacen=1 ORDER BY razon_social" ;
            $rs_validar1 = mysql_query($actualizar1,$cx_validar);

            echo '<select name="c2" id="c2">';
            while ($v_validar1 = mysql_fetch_array($rs_validar1)){
              echo  '<option value='.$v_validar1[0];
              if ($v_validar1[0]==$c2){
                echo ' SELECTED ';
                $c2=$v_validar1[0];
                //echo " $c2 ";
              }
              echo '>'.$v_validar1[0].'</option>'; 
            }
            echo '</select></p> ';// fin datos de sala de ext

            echo "<p>DIRECCI&Oacute;N: <input name='dir1' type='text' id='dir1'  value='$dir1' size='50' maxlength='50' required /></p>";
  			    echo"<p>LOCALIDAD <input name='localidad' type='text' id='localidad'  value='$localidad'  size='30' maxlength='30' />&nbsp;&nbsp;";
  			    echo"&nbsp;&nbsp;C&Oacute;DIGO POSTAL&nbsp;<input name='cod_postal' type='text' id='cod_postal'  value="."'".$cod_postal."'"."  size='8' maxlength='10' /></p>";  		   
            echo"PROVINCIA<input name='provincia' type='text' id='provincia'  value='$provincia'  size='20' maxlength='20' required />";
  			    echo"&nbsp;&nbsp;PAIS<input name='pais' type='text' id='pais' value='$pais'  size='20' maxlength='20' /></p>";
  	      ?>			
			</div>
      <!-- fin contenedor 1 -->
      <h4><img id="abrir_contenedor2" src="fotos/desplegar0.png"/> DATOS ADICIONALES </h4>

      <div id="contenedor2">
        <?
           // comienzo de los datos adicionales
          echo"<p>Contacto&nbsp;<input name='contacto' type='text' id='contacto'  value='$contacto' size='50' maxlength='80' />";          
          echo"&nbsp;&nbsp;Telefono&nbsp;<input name='tel' type='text' id='tel'  value='$tel' size='30' maxlength='30' /></p>";

          echo"<p>Celular&nbsp;<input name='cel' type='text' id='cel' value='$cel'  size='15' maxlength='15' />";
          echo"&nbsp;&nbsp;Nextel&nbsp;<input name='nextel' type='text' id='nextel' value='$nextel'  size='10' maxlength='30' /></p>";

          echo"<p>&nbsp;&nbsp;email&nbsp;<input name='email' type='text' id='email'  value='$email' size='50' maxlength='80' />";
          echo"&nbsp;&nbsp;Fax<input name='fax' type='text' id='fax'  value='$fax' size='15' maxlength='15' /></p>";
        ?>
      </div><!--fin contenedor2-->
      <br>      
      
      <h4><img id="abrir_contenedor3" src="fotos/desplegar0.png"/> DATOS ADICIONALES </h4>
      
      <div id="contenedor3">
        <?
          // comienzo de los datos adicionales 
          echo"<p>Contacto&nbsp;<input name='contacto1' type='text' id='contacto1'  value='".$contacto1."' size='50' maxlength='80' />";
          echo"&nbsp;&nbsp;Telefono&nbsp;<input name='tel1' type='text' id='tel1'  value='".$tel1."' size='30' maxlength='30' /></p>";
          
          echo"<p>Celular<input name='cel1' type='text' id='cel1' value="."'".$cel1."'"."  size='15' maxlength='15' />";
          echo"&nbsp;&nbsp;email<input name='email1' type='text' id='email1' value="."'".$email1."'"."  size='30' maxlength='80' /></p>";
       ?> 
      </div><!--fin contenedor3-->
      <br>
      <h4> DATOS FISCALES </h4> 
      <div id="contenedor4">
      <?
         /* agregue esta llamada a BD para habilitar el selector de tipo de iva ya que sin ella quedaba indefinido 10-11-2014 */
          $actualizar1="select cod_iva from  ".$_SESSION["tabla_iva"]." where cod_iva<>"."'".$cond_iva."'" ;
          $rs_validar1 = mysql_query($actualizar1,$cx_validar); 
          /* fin llamada a BD para habiilitar el selector de tipo de iva */
          echo  '<p id="datosFiscales">&nbsp;&nbsp;&nbsp;Condici&oacute;n de Iva:'."&nbsp";
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
          echo "<input name='nro_cuit' ID='nro_cuit' type='text'  value='$nro_cuit'  size='13' maxlength='13' />";
                             
          echo "&nbsp;&nbsp;&nbsp;Agente de retenci&oacute;n de IVA&nbsp";

          echo  '<select name="ret_iva" id="ret_iva">';
          echo  "<option ";   
          if ($ret_iva=="Si") {
            echo ' selected ';
            echo "value='Si'>Si</option>";
            echo  "<option value='No'>No</option>";}
          else    {
            echo ' selected ';
            echo "value='No'>No</option>";
            echo  "<option value='Si'>Si</option>";}
          echo "</select></p>";
          
          echo"<p id='datosFiscales'>&nbsp&nbsp&nbsp&nbspIngresos Brutos&nbsp";

          echo  "<select name='ret_bru' id='ret_bru'>";
          echo  "<option ";   
          if ($ret_bru=="Si") {
            echo ' selected ';
            echo "value='Si'>Si</option>";
            echo  "<option value='No'>No</option>";}
          else    {
            echo ' selected ';
            echo "value='No'>No</option>";
            echo  "<option value='Si'>Si</option>";}

          echo "</select>&nbsp&nbsp&nbsp&nbspGanancias&nbsp";

          echo  '<select name="ret_gan" id="ret_gan">';
          echo  "<option ";   
          if ($ret_gan=="Si") {
            echo ' selected ';
            echo "value='Si'>Si</option>";
            echo  "<option value='No'>No</option>";}
          else    {
            echo ' selected ';
            echo "value='No'>No</option>";
            echo  "<option value='Si'>Si</option>";}
          
          echo "</select></p>";
      ?>          
      </div><!--fin contenedor4 --> 
      <br>
      <div id="contenedor5"> 
        <button id="btnvolver"  name="volver" value"volver">VOLVER</button>
        <button id="btnguardar" name="guardar" value"guardar">GUARDAR</button>
        <!--button id="btnimprimir" name="imprimir" value"imprimir">IMPRIMIR</button-->        
      </div><!--fin contenedor5 -->  
     
	  </div><!--fin contenedor general -->
	</form>   
  
  <?
    echo "<input id='prov_id' type='hidden' name='' value='".$prov_id."'>";  
    // solo funciona si se edita el archivo
    if($edit=="edit"){
     echo "<input id='accion' type='hidden' name='' value='edit'>";
    }
    // solo funciona si es nuevo el archivo
    if ($agrego_cliente=="si"){
      echo "<input id='accion' type='hidden' name='' value='nuevo'>";        
    }
  ?>
      
	</body>
  <script src="../frames/js/botoneraProvedores.js" type="text/javascript"> </script>     
</html>