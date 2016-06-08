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

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=4 and acceso="on"';
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
$env_prim=0;$env_sec=0;$env_terc=0;
$primario='';$secundario='';$terciario='';
$accion=0;
if ( ($_POST["ID"]=="NA") or ($accion==1))
{ header("Location: productos1.php");}
else {
  $prod_id=substr($_POST["ID"],1);
}


foreach ($_GET as $indice => $valor){
 //  echo $indice.' '.$valor.'- en get<br>';
   switch ($indice) {
   case 'accion': $accion= $valor; break;
}}

foreach ($_POST as $indice => $valor){
   //echo $indice.' '.$valor.'- en post<br>';
   switch ($indice) {
   case 'prod_id': $prod_id= $valor; break;
   case 'accion': $accion= $valor; break;
   case 'contr': $contr= $valor; break;
   case 'ent': $ent= $valor; break;
   case 'nombre': $nombre=$valor; break;
   case 'nombre1': $nombre1=$valor; break;
   case 'nomenclador': $nomenclador=$valor; break;
   case 'nomencl1': $nomencl1=$valor; break;
   case 'abrev': $abrev= $valor; break;  
   case 'ean': $ean= $valor; break;  
   case 'contiene': $contiene=$valor; break;
   case 'unidad': $unidad=$valor; break;
   case 'peso_kgr': $peso_kgr=$valor; break;
   case 'env_prim': $env_prim=$valor; 
     $actualizar1="select nombre from  ".$_SESSION["tabla_env_primario"].' where env_prim='.$env_prim ;
     $rs_validar1 = mysql_query($actualizar1,$cx_validar);
     while ($v_validar1 = mysql_fetch_array($rs_validar1)){$primario=$v_validar1[0];}
     break;
   case 'env_sec': $env_sec=$valor;
     $actualizar1="select nombre from  ".$_SESSION["tabla_env_secundario"].' where env_sec='.$env_sec ;
     $rs_validar1 = mysql_query($actualizar1,$cx_validar);
     while ($v_validar1 = mysql_fetch_array($rs_validar1)){$secundario=$v_validar1[0];}
     break;
   case 'env_terc': $env_terc=$valor; 
     $actualizar1="select nombre from  ".$_SESSION["tabla_env_terciario"].' where env_terc='.$env_terc ;
     $rs_validar1 = mysql_query($actualizar1,$cx_validar);
     while ($v_validar1 = mysql_fetch_array($rs_validar1)){$terciario=$v_validar1[0];}
    break;

   }
}
if ($ent>0){$prod_id=$ent;}
if ($accion==1)
{ header("Location: productos1.php");
}

if ($accion==2){ 
  $id_unidad=0;
  $actualizar="SELECT id_unidad from ".$_SESSION["tabla_unidades"].' where unidad="'.$unidad.'"';
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$id_unidad= $v_validar[0] ;}


  $actualizar="update ".$_SESSION['tabla_productos'].' set  nombre="'.$nombre ;
  $actualizar=$actualizar.'",nombre1="'.$nombre1.'",nomenclador="'.$nomenclador.'",nomencl1="'.$nomencl1.'" ,ean='.$ean.',abrev="'.$abrev;
  $actualizar=$actualizar.'" ,contiene="'.$contiene;
  $actualizar=$actualizar.'" ,unidad="'.$unidad;
  $actualizar=$actualizar.'" ,primario="'.$primario;
  $actualizar=$actualizar.'" ,secundario="'.$secundario;
  $actualizar=$actualizar.'" ,terciario="'.$terciario;
  $actualizar=$actualizar.'" ,peso_kgr='.$peso_kgr;
  $actualizar=$actualizar.' ,id_unidad='.$id_unidad;
  $actualizar=$actualizar.' ,env_prim='.$env_prim;
  $actualizar=$actualizar.' ,env_sec='.$env_sec;
  $actualizar=$actualizar.' ,env_terc='.$env_terc;
  $actualizar=$actualizar.' where prod_id='.$prod_id ;
  mysql_query($actualizar,$cx_validar);


}

if ($accion==3){
  $actualizar="SELECT max( prod_id ) from ".$_SESSION["tabla_productos"];
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$prod_id= $v_validar[0] + 1;}

  $id_unidad=0;
  $actualizar="SELECT id_unidad from ".$_SESSION["tabla_unidades"].' where unidad="'.$unidad.'"';
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$id_unidad= $v_validar[0] ;}
  $actualizar='INSERT INTO '.$_SESSION["tabla_productos"].' (`prod_id`) VALUES ('.$prod_id .')';
  mysql_query($actualizar,$cx_validar);
  $actualizar="update ".$_SESSION['tabla_productos'].' set  nombre="'.$nombre ;
  $actualizar=$actualizar.'",nombre1="'.$nombre1.'",nomenclador="'.$nomenclador.'",nomencl1="'.$nomencl1.'",ean='.$ean.' ,abrev="'.$abrev;
  $actualizar=$actualizar.'" ,contiene="'.$contiene;
  $actualizar=$actualizar.'" ,unidad="'.$unidad;
  $actualizar=$actualizar.'" ,primario="'.$primario;
  $actualizar=$actualizar.'" ,secundario="'.$secundario;
  $actualizar=$actualizar.'" ,terciario="'.$terciario;
  $actualizar=$actualizar.'" ,peso_kgr='.$peso_kgr;
  $actualizar=$actualizar.' ,id_unidad='.$id_unidad;
  $actualizar=$actualizar.' ,env_prim='.$env_prim;
  $actualizar=$actualizar.' ,env_sec='.$env_sec;
  $actualizar=$actualizar.' ,env_terc='.$env_terc;
  $actualizar=$actualizar.' where prod_id='.$prod_id ;
  mysql_query($actualizar,$cx_validar);

}

if ($accion==4){
  if ($contr=="BAJA"){
    $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
    mysql_select_db($_SESSION["base_acc"]);
    $actualizar="DELETE from  ".$_SESSION["tabla_productos"]." where prod_id=".$prod_id ;
    $rs_validar = mysql_query($actualizar,$cx_validar);header("Location: productos1.php");echo '1';}
  else {echo "Para borrar este Item coloque en el Código de Seguridad la palabra BAJA   ";}
}
include_once("funciones.php");
$sub=".";
$orden=$_REQUEST["orden"];
?>
<head>
<?
  echo "<TITLE>Editando el Producto ".$prod_id."</TITLE>";?>
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
echo "<form name='formulario' method='POST' action='mod_productos1.php'>";

$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);



$actualizar="select * from  ".$_SESSION["tabla_productos"]. " where prod_id=".$prod_id ;
$rs_validar = mysql_query($actualizar,$cx_validar);

while ($v_validar = mysql_fetch_array($rs_validar)) {
  $prod_id= $v_validar[0];
  $nombre= $v_validar[1];
  $abrev= $v_validar[2];
  $nomenclador= $v_validar[3];
  $nomencl1= $v_validar[4];
  $nombre1= $v_validar[5];
  $env_prim= $v_validar[6];
  $env_sec= $v_validar[7];
  $env_terc= $v_validar[8];
  $peso_kgr=$v_validar[9];
  $contiene=$v_validar[10];
  $unidad=$v_validar[11];
  $primario=$v_validar[12];
  $secundario=$v_validar[13];
  $terciario=$v_validar[14];
  $id_unidad=$v_validar[15];
  $ean=$v_validar[16];
}

$actualizar1="select unidad from  ".$_SESSION["tabla_unidades"]." where unidad<>"."'".$unidad."'" ;
$rs_validar1 = mysql_query($actualizar1,$cx_validar);
echo '<table border="1" ><tr><td>';
    echo '<table border="1">';
    echo "<caption color style='background:#99FF33'> Datos del Producto ".$prod_id." </caption>";
    echo '<tr>';
    echo  '<td rowspan="2">Nombre</td>';
    echo "<td><input type='text' name='nombre' id='nombre'  value="."'".$nombre."'"."  size='40' maxlength='50'></td>";
    echo '</tr><tr>';
    echo "<td><input type='text' name='nombre1' id='nombre1'  value="."'".$nombre1."'"."  size='40' maxlength='50'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Abreviatura</td>';
    echo "<td><input type='text' name ='abrev' id='abrev'  value="."'".$abrev."'"." size='10' maxlength='10'>";
    echo "&nbsp&nbsp&nbspC&oacuted.EAN13<input type='text' name ='ean' id='ean'  value="."'".$ean."'"." size='13' maxlength='13'>";
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo  '<td rowspan="2">Nomenclador</td>';
    echo "<td><input type='text' name='nomenclador' id='nomenclador'  value="."'".$nomenclador."'"."  size='20' maxlength='20'></td>";
    echo '</tr><tr>';
    echo "<td><input type='text' name='nomencl1' id='nomencl1'  value="."'".$nomencl1."'"."  size='20' maxlength='20'></td>";
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
    echo "<td><input type='text' name='peso_kgr' id='peso_kgr' value="."'".$peso_kgr."'"." size='12' maxlength='12'></td>";
    echo '</td></tr>';
    echo '<tr>'; 
   
   echo "</table>";  
   if ($accion==4){   echo "<br>Código de Seguridad "."<INPUT TYPE=INPUT name='contr' value=" ."'".$contr."'>"; }
   echo "<INPUT TYPE=HIDDEN name='prod_id'  value='".$prod_id."''>";
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

