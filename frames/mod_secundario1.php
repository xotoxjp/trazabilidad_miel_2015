<?php
session_start();
include_once("funciones.php");
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
$nivel_dato=$_SESSION["acceso_acc"];

$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=6 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }


$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$contr="";
$accion=0;
if ( ($_POST["ID"]=="NA") or ($accion==1))
{ $_SESSION[reg_desde]= $_POST["num_reg_desde"];
  $_SESSION[reg_hasta]= $_POST["num_reg_hasta"];
  header("Location: env_sec.php");}
else {
  $env_sec=substr($_POST["ID"],1);
}


foreach ($_GET as $indice => $valor){
 //  echo $indice.' '.$valor.'- en get<br>';
   switch ($indice) {
   case 'accion': $accion= $valor; break;
}}

foreach ($_POST as $indice => $valor){
  // echo $indice.' '.$valor.'- en post<br>';
   switch ($indice) {
   case 'accion': $accion= $valor; break;
   case 'ent': $ent= $valor; break;
   case 'env_sec': $env_sec=$valor; break;
   case 'nombre': $nombre=$valor; break;
   case 'abrev': $abrev= $valor; break;
   case 'en_sanitario': $en_sanitario= $valor; break;
   case 'en_autoriz': $en_autoriz= $valor; break;
   case 'contiene': $contiene=$valor; break;
   case 'contr': $contr=$valor; break;
   case 'unidad': $unidad=$valor; break;
   case 'peso_stand': $peso_stand=$valor; break;
   }
}
if ($ent>0){$env_sec=$ent;}
if ($accion==1)
{ $_SESSION[reg_desde]= $_POST["num_reg_desde"];
  $_SESSION[reg_hasta]= $_POST["num_reg_hasta"];
  header("Location: env_sec.php");
}

if ($accion==2){ 
  $id_unidad=0;
  $actualizar="SELECT id_unidad from ".$_SESSION["tabla_unidades"].' where unidad="'.$unidad.'"';
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$id_unidad= $v_validar[0] ;}


  $actualizar="update ".$_SESSION['tabla_env_secundario'].' set  nombre="'.$nombre ;
  $actualizar=$actualizar.'" ,abrev="'.$abrev;
  $actualizar=$actualizar.'" ,en_autoriz="'.$en_autoriz;
  $actualizar=$actualizar.'" ,en_sanitario="'.$en_sanitario;
  $actualizar=$actualizar.'" ,contiene="'.$contiene;
  $actualizar=$actualizar.'" ,unidad="'.$unidad;
  $actualizar=$actualizar.'" ,peso_stand='.$peso_stand;
  $actualizar=$actualizar.' ,id_unidad='.$id_unidad;
  $actualizar=$actualizar.' where env_sec='.$env_sec ;
  mysql_query($actualizar,$cx_validar);


}

if ($accion==3){
  $actualizar="SELECT max( env_sec ) from ".$_SESSION["tabla_env_secundario"];
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$env_sec= $v_validar[0] + 1;}

  $id_unidad=0;
  $actualizar="SELECT id_unidad from ".$_SESSION["tabla_unidades"].' where unidad="'.$unidad.'"';
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$id_unidad= $v_validar[0] ;}


  $actualizar='INSERT INTO '.$_SESSION["tabla_env_secundario"].' (`env_sec`, `nombre`, `abrev`, `contiene`,  `unidad` , `peso_stand`, `id_unidad`, `en_sanitario`, `en_autoriz` ';
  $actualizar=$actualizar.') VALUES (';
  $actualizar=$actualizar .$env_sec . ", '" .$nombre . "', '" .$abrev."',";
  $actualizar=$actualizar."'".$contiene."','".$unidad."','".$peso_stand."','".$id_unidad."','".$en_sanitario."','".$en_autoriz."')";
  mysql_query($actualizar,$cx_validar);
}

if ($accion==4){
  if ($contr=="BAJA"){
    $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
    mysql_select_db($_SESSION["base_acc"]);
    $actualizar="DELETE from  ".$_SESSION["tabla_env_secundario"]." where env_sec=".$env_sec ;
    $rs_validar = mysql_query($actualizar,$cx_validar);header("Location: env_sec.php");echo '1';}
  else {echo "Para borrar este Item coloque en el Código de Seguridad la palabra BAJA   ";}
}
include_once("funciones.php");
$sub=".";
$orden=$_REQUEST["orden"];
?>
<head>
<?
  echo "<TITLE>Editando la Familia ".$env_sec."</TITLE>";?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="viewport" content="width=device-width,initial-scale=1">             
  <link rel="stylesheet" href="botones.css" />

  <script type="text/javascript">
  <!--
  function oprimo(elemento)
  {
    tx=document.getElementById('accion');
    tx.value=elemento;
    btn=document.getElementById('ent');
    btn.click();
   }
   -->
  </script>
</head>

<?
echo "<BODY onLoad='this.document.formulario.nombre.focus()'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='mod_secundario1.php'>";

$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);



$actualizar="select * from  ".$_SESSION["tabla_env_secundario"]. " where env_sec=".$env_sec ;
$rs_validar = mysql_query($actualizar,$cx_validar);

while ($v_validar = mysql_fetch_array($rs_validar)) {
  $env_sec= $v_validar[0];
  $nombre= $v_validar[1];
  $abrev= $v_validar[2];
  $contiene=$v_validar[3];
  $unidad=$v_validar[4];
  $peso_stand=$v_validar[5];
}

$actualizar1="select unidad from  ".$_SESSION["tabla_unidades"]." where unidad<>"."'".$unidad."'" ;
$rs_validar1 = mysql_query($actualizar1,$cx_validar);
echo '<table border="1" ><tr><td>';
    echo '<table border="1">';
    echo "<caption color style='background:#99FF33'> Datos del Envase Secundario ".$env_sec." </caption>";
    echo '<tr>';
    echo  '<td>Nombre</td>';
    echo "<td><input type='text' name='nombre' id='nombre'  value="."'".$nombre."'"."  size='40' maxlength='40'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Abreviatura</td>';
    echo "<td><input type='text' name ='abrev' id='abrev'  value="."'".$abrev."'"." size='10' maxlength='10'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Contiene</td>';
    echo "<td><input type='text' name='contiene'  id='contiene' value="."'".$contiene."'"." size='8' maxlength='8'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Unidad</td>';
    echo  '<td><select name="unidad" id="unidad">';
    echo       "<option value="."'".$unidad."'>".$unidad."</option>";
     while ($v_validar1 = mysql_fetch_array($rs_validar1))
     { echo  "<option value="."'".$v_validar1[0]."'>".$v_validar1[0]."</option>"; }
    echo '</td></tr>';
    echo '<tr>';
    echo  '<td>Peso Estandar</td>';
    echo "<td><input type='text' name='peso_stand' id='peso_stand' value="."'".$peso_stand."'"." size='12' maxlength='12'></td>";
    echo '</td></tr>';
    echo '<tr>';
    echo  '<td>Texto en Sanitario</td>';
    echo "<td><input type='text' name='en_sanitario' id='en_sanitario' value="."'".$en_sanitario."'"." size='12' maxlength='12'></td>";
    echo '</td></tr>';
    echo  '<td>Texto en Autorizaci&oacute;n</td>';
    echo "<td><input type='text' name='en_autoriz' id='en_autoriz' value="."'".$en_autoriz."'"." size='15' maxlength='15'></td>";
    echo '</td></tr>';



    echo '<tr>'; 
    
   echo "</table>";  
   if ($accion==4){   echo "<br>Código de Seguridad "."<INPUT TYPE=INPUT name='contr' value=" ."'".$contr."'>"; }
   echo "<INPUT TYPE=HIDDEN name='num_reg_desde'  value="."'".$_SESSION[reg_desde]."'>";
   echo "<INPUT TYPE=HIDDEN name='num_reg_hasta'  value="."'".$_SESSION[reg_hasta]."'>";
   echo "<INPUT TYPE=HIDDEN name='env_sec'  value='".$env_sec."''>";
   echo "<INPUT TYPE=HIDDEN name='accion' id='accion' value='".$accion."'>";
   echo "<INPUT TYPE=SUBMIT name='ent'  id='ent'>";
echo "<table border='2'  width='100%'><tr>";
echo "<caption color style='background:#99FF33'> Acciones Definidas para el Usuario </caption>"     ;  
echo '<td><span onclick="oprimo(1);">Volver</span>';
if ($modifica=='on'){echo '<span onclick="oprimo(2);">Guardar</span>';}
if ($alta=='on'){echo '<span onclick="oprimo(3);">Alta</span>';}
if ($baja=='on'){echo '<span onclick="oprimo(4);">Borrar</span>';}
echo '</td></tr></table>';

?>
    </form>
  </BODY>
</HTML>

