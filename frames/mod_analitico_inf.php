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
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }

$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$contr="";
$accion=0;
if ( ($_POST["ID"]=="NA") or ($accion==1))
{ $_SESSION[reg_desde]= $_POST["num_reg_desde"];
  $_SESSION[reg_hasta]= $_POST["num_reg_hasta"];
  header("Location: analitico_inf.php");}
else {
  $cod_anal_id=substr($_POST["ID"],1);
}
//se agrego
$cod_anal_id=$_GET["ID"];

foreach ($_GET as $indice => $valor){
 //  echo $indice.' '.$valor.'- en get<br>';
   switch ($indice) {
   case 'accion': $accion= $valor; break;
   case 'cod_anal_id': $cod_anal_id=$valor; break;
   }
}

foreach ($_POST as $indice => $valor){
   //echo $indice.' '.$valor.'- en post<br>';
   switch ($indice) {
   case 'accion': $accion= $valor; break;
   case 'ent': $ent= $valor; break;
   case 'contr': $contr= $valor; break;
   case 'cod_anal_id': $cod_anal_id=$valor; break;
   case 'nomencl': $nomencl=$valor; break;
   case 'nomencl1': $nomencl1= $valor; break;
   case 'unidad': $unidad=$valor; break;
   case 'esp_inf': $esp_inf=$valor; break;
   case 'esp_sup': $esp_sup=$valor; break;
   case 'leyenda3': $leyenda3=$valor; break;
   case 'leyenda1': $leyenda1=$valor; break;
   case 'leyenda2': $leyenda2=$valor; break;
   case 'aplica_ok': $aplica_ok=$valor; break;
   }
}
if ($ent>0){$cod_anal_id=$ent;}
if ($accion==1){
 $_SESSION[reg_desde]= $_POST["num_reg_desde"];
  $_SESSION[reg_hasta]= $_POST["num_reg_hasta"];
  header("Location: analitico_inf.php");
}

if ($accion==2){ 
  $actualizar="UPDATE ".$_SESSION['tabla_analitico_inf'].' SET  nomencl="'.$nomencl ;
  $actualizar=$actualizar.'" ,nomencl1="'.$nomencl1;
  $actualizar=$actualizar.'" ,cod_anal_id="'.$cod_anal_id;
  $actualizar=$actualizar.'" ,unidad="'.$unidad;
  $actualizar=$actualizar.'" ,esp_inf="'.$esp_inf;
  $actualizar=$actualizar.'" ,esp_sup="'.$esp_sup;
  $actualizar=$actualizar.'" ,leyenda3="'.$leyenda3;
  $actualizar=$actualizar.'" ,leyenda1="'.$leyenda1;
  $actualizar=$actualizar.'" ,leyenda2="'.$leyenda2;
  $actualizar=$actualizar.'" ,aplica_ok="'.$aplica_ok;
  $actualizar=$actualizar.'" WHERE cod_anal_id='.$cod_anal_id ;
  mysql_query($actualizar,$cx_validar);
}

if ($accion==3){
  $actualizar="SELECT max( cod_anal_id ) from ".$_SESSION["tabla_analitico_inf"];
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$cod_anal_id= $v_validar[0] + 1;}

  $actualizar='INSERT INTO '.$_SESSION["tabla_analitico_inf"].' (`cod_anal_id`, `nomencl`, `nomencl1`, `esp_inf`,`esp_sup`,  `unidad` , `leyenda1`, `leyenda2`, `leyenda3`, `aplica_ok`  ';
  $actualizar=$actualizar.') VALUES (';
  $actualizar=$actualizar .$cod_anal_id . ", '" .$nomencl . "', '" .$nomencl1."',";
  $actualizar=$actualizar."'".$esp_inf."','".$esp_sup."','".$unidad."','".$leyenda1."','".$leyenda2."','".$leyenda3."','".$aplica_ok."')";
  mysql_query($actualizar,$cx_validar);

  
}

if ($accion==4){
  if ($contr=="BAJA"){
    $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
    mysql_select_db($_SESSION["base_acc"]);
    $actualizar="DELETE from  ".$_SESSION["tabla_analitico_inf"]." where cod_anal_id=".$cod_anal_id ;
  
    $rs_validar = mysql_query($actualizar,$cx_validar);header("Location: analitico_inf.php");echo '1';}
  else {echo "Para borrar este Item coloque en el Código de Seguridad la palabra BAJA   ";}
}
include_once("funciones.php");
$sub=".";
$orden=$_REQUEST["orden"];
?>
<head>
<?
  echo "<TITLE>Editando la Familia ".$cod_anal_id."</TITLE>";?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="viewport" content="width=device-width,initial-scale=1">             
  <link rel="stylesheet" href="css/botones.css" />
  <link rel='shortcut icon' href='fotos/icono1.ico'>
  <link rel="stylesheet" href="css/pantalla_edit.css" />
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
echo "<BODY onLoad='this.document.formulario.nomencl.focus()'>";
echo "<form name='formulario' method='POST' action='mod_analitico_inf.php'>";
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
   
$actualizar1="SELECT unidad FROM  ".$_SESSION["tabla_unidades"]." WHERE unidad<>"."'".$unidad."'" ;
$rs_validar1 = mysql_query($actualizar1,$cx_validar);

echo '<div id=contenedorForm>';
echo '<table border="1" ><tr><td>';
    echo '<table border="1">';
    echo "<caption color style='background:#99FF33'> Datos del An&aacute;lisis ".$cod_anal_id." </caption>";
    echo '<tr>';
    echo  '<td>Nomenclador</td>';
    echo "<td><input type='text' name='nomencl' id='nomencl'  value="."'".$nomencl."'"."  size='40' maxlength='40'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Detalle</td>';
    echo "<td><input type='text' name ='nomencl1' id='nomencl1'  value="."'".$nomencl1."'"." size='40' maxlength='40'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Lïmite Inferior</td>';
    echo "<td><input type='text' name='esp_inf'  id='esp_inf' value="."'".$esp_inf."'"." size='8' maxlength='8'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Lïmite Superior</td>';
    echo "<td><input type='text' name='esp_sup'  id='esp_sup' value="."'".$esp_sup."'"." size='8' maxlength='8'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Unidad</td>';
    echo  '<td><select name="unidad" id="unidad">';
    echo       "<option value="."'".$unidad."'>".$unidad."</option>";
     while ($v_validar1 = mysql_fetch_array($rs_validar1))
     { echo  "<option value="."'".$v_validar1[0]."'>".$v_validar1[0]."</option>"; }
    echo '</td></tr>';
    
    echo '<tr>';
    echo  '<td>Aplica para Rechazo</td>';
    echo  '<td><select name="aplica_ok" id="aplica_ok">';
    if ($aplica_ok=='No') {
      echo   '<option value=No selected="selected">No</option>';
      echo   '<option value=Si >Si</option>';
    }
    else {
      echo   '<option value=Si selected="selected">Si</option>';
      echo   '<option value=No >No</option>';      
    }
    echo '</td></tr>';

    echo '<tr>';
    echo  '<td>Leyendas</td>';
    echo "<td><input type='text' name='leyenda1' id='leyenda1' value="."'".$leyenda."'"." size='30' maxlength='30'></td>";
    echo '</td></tr>';
    echo '<tr>';
    echo  '<td></td>';
    echo "<td><input type='text' name='leyenda2' id='leyenda2' value="."'".$leyenda1."'"." size='30' maxlength='30'></td>";
    echo '</td></tr>';
    echo '<tr>';
    echo  '<td></td>';
    echo "<td><input type='text' name='leyenda3' id='leyenda3' value="."'".$leyenda2."'"." size='30' maxlength='30'></td>";
    echo '</td></tr>';
    echo '<tr>'; 
    
   echo "</table>";  
   if ($accion==4){   echo "<br>Código de Seguridad "."<INPUT TYPE=INPUT name='contr' value=" ."'".$contr."'>"; }
   echo "<INPUT TYPE=HIDDEN name='num_reg_desde'  value="."'".$_SESSION[reg_desde]."'>";
   echo "<INPUT TYPE=HIDDEN name='num_reg_hasta'  value="."'".$_SESSION[reg_hasta]."'>";
   echo "<INPUT TYPE=HIDDEN name='cod_anal_id'  value='".$cod_anal_id."''>";
   echo "<INPUT TYPE=HIDDEN name='accion' id='accion' value='".$accion."'>";
   echo "<INPUT TYPE=SUBMIT name='ent'  id='ent'>";
echo "<table border='2'  width='100%'><tr>";
echo "<caption color style='background:#99FF33'> Acciones Definidas para el Usuario </caption></table>";
echo '<div id=botonera>';  
echo '<span onclick="oprimo(1);">Volver</span>';
if ($modifica=='on'){echo '<span onclick="oprimo(2);">Guardar</span>';}
if ($alta=='on'){echo '<span onclick="oprimo(3);">Alta</span>';}
if ($baja=='on'){echo '<span onclick="oprimo(4);">Borrar</span>';}
echo '</div>';
echo '</table>';

?>
    </form>
	  </div>
  </BODY>
</HTML>

