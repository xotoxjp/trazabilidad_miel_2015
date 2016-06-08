<?php
session_start();
include_once("funciones.php");
flag();
$_SESSION["level_req"]="z";
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
validar ($logg,$pass);
$nivel_dato=$_SESSION["acceso_acc"];
$contr="";
$boton="NO";
if ($_POST["ID"]=="NA")
{ $_SESSION[reg_desde]= $_POST["num_reg_desde"];
  $_SESSION[reg_hasta]= $_POST["num_reg_hasta"];
  header("Location: usuarios1.php");}

if ($_POST["Submit"]== "Volver") {      header("Location: usuarios1.php") ; }

foreach ($_POST as $indice => $valor)
  { //echo $indice . " " .$valor;
   switch ($indice) {
    case 'ID': $id_usuario=$valor; break;
    }
  }
if (strlen($id_usuario)>1) {
  if (substr($id_usuario,0,1)>':') {$id_usuario=substr($id_usuario,1); $_SESSION[id_usuario]=$id_usuario; }}

foreach ($_POST as $indice => $valor){
 //echo "$indice: $valor"."()";
   if ($indice=="Volver_x")  {header("Location: usuarios1.php") ;}
   if ($indice=="Salvar_x")  {$boton="Salvar";}
   if ($indice=="Imprimir_x"){$boton="Imprimir";}
   if ($indice=="Alta_x")    {$boton="Alta";}
   if ($indice=="Baja_x")    {$boton="Baja";}
   if ($indice=="Acceso_x")    {$boton="Acceso";}
   switch ($indice) {
   case 'op_campo': $op_campo=$valor ; break;
   case 'campo': $campo=$valor ; break;
   case 'orden': $orden=$valor ; break;
   case 'filtro': $filtro=$valor; break;
   case 'Submit': $sub=$valor; break;
   case 'nombre': $nombre=$valor; break;
   case 'apellido': $apellido= $valor; break;
   case 'email': $email= $valor; break;
   case 'login': $login= $valor; break;
   case 'password': $password=$valor; break;
   case 'nivel': $nivel=$valor; break;
   case 'menu': $menu=$valor; break;
   case 'id_empresa': $id_empresa=$valor; break;
   case 'empresa': $empresa=$valor; break;
   case 'dir_cliente': $dir_cliente=$valor; break;
   case 'fec_ult_ut': $fec_ult_ut=$valor; break;
   case 'prog_utl': $prog_utl=$valor; break;
   case 'salio_ok': $salio_ok=$valor; break;
   case 'sector': $sector=$valor; break;
   case 'tel': $tel=$valor; break;
   case 'cel': $cel=$valor; break;
   case 'interno': $interno=$valor; break;
   case 'id_usuario': $id_usuario=$valor; break;
   case 'contr': $contr=$valor; $contr=substr($contr,0,4); $contr=trim($contr);$contr=strtoupper($contr); break;
   }
}
if ($boton=="Baja")
  {  if ($contr=="BAJA")
      {  $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
         mysql_select_db($_SESSION["base_acc"]);
         $actualizar="DELETE from  ".$_SESSION["tabla_acc"]." where id_usuario=".$id_usuario ;
         $rs_validar = mysql_query($actualizar,$cx_validar); header("Location: usuarios1.php") ;
      }
       else
      {  echo "Para borrar este Item coloque en el Código de Seguridad la palabra BAJA   ";  }
  
  }

if ($boton=="Acceso") {
  header("Location: menu_2.php?i=$id_usuario&n=$nombre&a=$apellido") ;
  }



// si hay filtros no hay limite porque los proceso despues
$Registros=$_REQUEST["Registros"];
$sub=".";
$Limite="";
?>
<head>
<TITLE>Editando</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
.hide {display:none;}
.show {display:block;}
#ent  {display: none;}
th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
}

body {
  font-family:Arial;
  font-size:12pt;     
}

table{float: left;
  border: 0px;
}
</style>

<script type="text/javascript">
<!--
function ini() {
 var IdAry=['boton1','boton2','boton3','boton4','boton5'];
 for (var zxc0=0;zxc0<IdAry.length;zxc0++){
 var el=document.getElementById(IdAry[zxc0]);
 if (el){
   el.onmouseover=function() {
    changeText(this,'hide','show')
    }
   el.onmouseout=function() {
     changeText(this,'show','hide');
    }
  }
 }
}


function changeText(obj,cl1,cl2) {
   obj.getElementsByTagName('SPAN')[0].className=cl1;
   obj.getElementsByTagName('SPAN')[1].className=cl2;
}


function muestrol(elemento)
 {
  tx=document.getElementById('Eleccion');
  tx.value="CHCL";
  btn=document.getElementById('ent');
  btn.click();
 }
function muestro(elemento)
 {
  tx=document.getElementById('Eleccion');
  tx.value="CHCP";
  btn=document.getElementById('ent');
  btn.click();
 }

 function  validacion(){
   var elemento = document.getElementById("NRO_CUIT").value;
   var lista = document.getElementById("COD_IVA");
   var indiceSeleccionado = lista.selectedIndex;
   var iva = lista.options[indiceSeleccionado];
   return true;
   }
function vd(){
   if (iva.text=="CF"){elemento.value="99-99999999-9"; return true;}
   if (iva.text=="SIN"){elemento.value="99-99999999-9";return true;}
   }
-->
</script>


<?

echo "<body onload='ini();'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='mod_usuario1.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

if ($boton=="Salvar"){
  $actualizar="update ".$_SESSION['tabla_acc']." set  nombre='".$nombre."'" ;
  $actualizar=$actualizar." ,apellido='".$apellido."'";
  $actualizar=$actualizar." ,email='".$email."'";
  $actualizar=$actualizar." ,login='".$login."'";
  $actualizar=$actualizar." ,password='".$password."'";
  $actualizar=$actualizar." ,nivel='".$nivel."'";
  $actualizar=$actualizar." ,menu='".$menu."'";
  $actualizar=$actualizar." ,id_empresa='".$id_empresa."'";
  $actualizar=$actualizar." ,empresa='".$empresa."'";
  $actualizar=$actualizar." ,dir_cliente='".$dir_cliente."'";
  $actualizar=$actualizar." ,fec_ult_ut='".$fec_ult_ut."'";
  $actualizar=$actualizar." ,prog_utl='".$prog_utl."'";
  $actualizar=$actualizar." ,salio_ok='".$salio_ok."'";
  $actualizar=$actualizar." ,sector='".$sector."'";
  $actualizar=$actualizar." ,tel='".$tel."'";
  $actualizar=$actualizar." ,cel='".$cel."'";
  $actualizar=$actualizar." ,op_campo='".$op_campo."'";
  $actualizar=$actualizar." ,interno='".$interno."'";
  $actualizar=$actualizar."  where id_usuario=".$id_usuario ;
  mysql_query($actualizar,$cx_validar);
}

if ($boton=="Alta") {
  $actualizar="INSERT INTO ".$_SESSION["tabla_acc"]." (`nombre`, `apellido`, `email`, `login`, ";
  $actualizar=$actualizar." `password` ,`nivel` ,`menu`, `id_empresa`, `empresa`, `dir_cliente`,  `fec_ult_ut` , `prog_utl` , ";
  $actualizar=$actualizar." `salio_ok` ,`sector`, `tel`, `cel`, `interno`, `op_campo` )";
  $actualizar=$actualizar." VALUES (";
  $actualizar=$actualizar." '".$nombre."', '".$apellido."', '".$email."', '".$login."', '".$password."',";
  $actualizar=$actualizar." '".$nivel."','".$menu."','".$id_empresa."', '".$empresa."', '".$dir_cliente."', '".$fec_utl_ul."',";
  $actualizar=$actualizar." '".$prog_utl."', '".$salio_ok."', '".$sector."', '".$tel."', '".$cel."', '".$interno."', '".$op_campo."')";
 
  $rs_validar = mysql_query($actualizar,$cx_validar);
  $actualizar="SELECT max( id_usuario ) from ".$_SESSION["tabla_acc"];
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$id_usuario= $v_validar[0];}

  
}
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="select * from  ".$_SESSION["tabla_acc"]. " where id_usuario=".$id_usuario ;
$v1_validar = mysql_query($actualizar,$cx_validar);
while ($v_validar = mysql_fetch_array($v1_validar))
  {
    $id_usuario= $v_validar[0];
    $nombre= $v_validar[1];
    $apellido= $v_validar[2];
    $email= $v_validar[3];
    $login=$v_validar[4];
    $password=$v_validar[5];
    $nivel= $v_validar[6];
    $id_empresa= $v_validar[7];
    $empresa= $v_validar[8];
    $dir_cliente=$v_validar[9];
    $fec_ult_ut=$v_validar[10];
    $prog_utl= $v_validar[11];
    $salio_ok= $v_validar[12];
    $sector= $v_validar[13];
    $tel=$v_validar[14];
    $cel=$v_validar[15];
    $interno=$v_validar[16];
    $op_campo=$v_validar[21];
    $menu=$v_validar[22];
}
    echo '<table border="1" ><tr><td>';
    echo '<table border="1">';
    echo "<caption color style='background:#99FF33'> Datos del Operador ".$id_usuario." </caption>";
    echo '<tr>';
    echo  '<td>Nombre</td>';
    echo "<td><input name='nombre' type='text'  value="."'".$nombre."'"."  size='40' maxlength='255' > </td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Apellido</td>';
    echo "<td><input name='apellido' type='text' id=email  value="."'".$apellido."'"." size='15' maxlength='20' > </td><td></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>email</td>';
    echo "<td><input name='email' type='text' id=email  value="."'".$email."'"." size='20' maxlength='40'  ></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Login</td>';
    echo "<td><input name='login' type='text' id=login  value="."'".$login."'"." size='3' maxlength='3'>";
    echo "&nbsp;&nbsp;".'Contraseña'."&nbsp;&nbsp;";
    echo "<input name='password' type='text' id=password  value="."'".$password."'"." size='8' maxlength='8'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Nivel</td>';
    echo "<td><input name='nivel' type='text' id=nivel  value="."'".$nivel."'"." size='8' maxlength='27'>";

    echo "&nbsp;&nbsp;&nbsp;Usa Men&uacute; Tipo&nbsp;";


    echo  '<select name="menu" id="menu">';
    echo  "<option value='Estandar'";
    if ($menu=="Estandar") {echo ' selected ';}
    echo ">Estandar</option>";
    echo  "<option value='Botones'";
    if ($menu=="Botones") {echo ' selected ';}
    echo ">Botones</option>";
    echo '/<select>';

    

    echo "</td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Id.empresa</td>';
    echo "<td><input name='id_empresa' type='text' id=id_empresa  value="."'".$id_empresa."'"." size='6' maxlength='11'>&nbsp;&nbsp;";
    echo "<input name='empresa' type='text' id=empresa  value="."'".$empresa."'"." size='30' maxlength='30'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Direccion</td>';
    echo "<td><input name='dir_cliente' type='text' id=dir_cliente  value="."'".$dir_cliente."'"." size='30' maxlength='30'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Ult.Fecha de Uso</td>';
    echo "<td><input name='fec_ult_ut' type='text' id=fec_ult_ut  value="."'".$fec_ult_ut."'"." size='20' maxlength='20'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Ult.Prog.Usado</td>';
    echo "<td><input name='prog_utl' type='text' id=prog_utl  value="."'".$prog_utl."'"." size='20' maxlength='30'>&nbsp;&nbsp;";
    echo  'Salió OK&nbsp;&nbsp;';
    echo "<input name='salio_ok' type='text' id=salio_ok  value="."'".$salio_ok."'"." size='2' maxlength='2'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Sector</td>';
    echo "<td><input name='sector' type='text' id=sector  value="."'".$sector."'"." size='20' maxlength='20'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Teléfono</td>';
    echo "<td><input name='tel' type='text' id=tel  value="."'".$tel."'"." size='15' maxlength='15'>&nbsp;&nbsp;&nbsp;";
    echo  'Interno&nbsp;&nbsp;';
    echo "<input name='interno' type='text' id=interno  value="."'".$interno."'"." size='10' maxlength='10'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Celular</td>';
    echo "<td><input name='cel' type='text' id=cel  value="."'".$cel."'"." size='15' maxlength='15'>&nbsp;&nbsp;&nbsp;Opera en el Campo&nbsp;";


    echo  '<select name="op_campo" id="op_campo">';
    echo  "<option value='Si'";
    if ($op_campo=="Si") {echo ' selected ';}
    echo ">Si</option>";
    echo  "<option value='No'";
    if ($op_campo=="No") {echo ' selected ';}
    echo ">No</option>";
    echo '/<select>';
    echo "</td>";
    echo '</tr>';

   echo "</table>";
   
   if ($boton=="Baja"){   echo "<br>Código de Seguridad "."<INPUT TYPE=INPUT name='contr' value=" ."'".$contr."'>"; }


   echo "<INPUT TYPE=HIDDEN name='num_reg_desde'  value="."'".$_SESSION[reg_desde]."'>";
   echo "<INPUT TYPE=HIDDEN name='num_reg_hasta'  value="."'".$_SESSION[reg_hasta]."'>";
   echo "<INPUT TYPE=HIDDEN name='id_usuario'  value="."'".$id_usuario."'>";

   echo "<table border='2'  width='30%'><tr>";
   echo "<caption color style='background:#99FF33'> Acciones Definidas para el Usuario </caption>"     ;

   echo "<td><p id='boton1'>";
   echo "<span id='span1'>  <input name='Volver' type='image' img src='fotos/cerrar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Volver' type='image' img src='fotos/cerrar_activo_ch.jpg'  alt='Cierra la Pantalla y Vuelve a la Pantalla de Selección de Familias'></a></span>";
   echo "</p></td>";
   echo "<td><p id='boton2'>";
   echo "<span id='span1'>  <input name='Salvar' type='image' img src='fotos/guardar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Salvar' type='image' img src='fotos/guardar_activo_ch.jpg'  alt='Se Actualizan los Datos del Operador. Por favor Verifique antes de hacerlo'></a></span>";
   echo "</p></td>";
   echo "<td><p id='boton3'>";
   echo "<span id='span1'>  <input name='Alta'  type='image'  img src='fotos/insertar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Alta'  type='image' img src='fotos/insertar_activo_ch.jpg' alt='Se dará de Alta una Nuevo Operador con los Datos Presentes en Pantalla'></a></span>";
   echo "</p></td>";
   echo "<td><p id='boton4'>";
   echo "<span id='span1'>  <input name='Baja' type='image' img src='fotos/eliminar_desactivo_ch.jpg'></span>";
   echo "<span class='hide'><input name='Baja' type='image' img src='fotos/eliminar_activo_ch.jpg'  alt='Atención Usted va a sacar Operador de la Base de Datos. Verifique.'></a></span>";
   echo "</p></td>";
   echo "<td><p id='boton5'>";
   echo "<span id='span1'>  <input name='Acceso' type='image' img src='fotos/HERR_DESACTIVO.JPG'></span>";
   echo "<span class='hide'><input name='Acceso' type='image' img src='fotos/HERR_ACTIVO.JPG'  alt='Atención Usted va a Modificar accesos del Operador. Verifique.'></a></span>";
   echo "</p></td>";
   echo "<td width='1'><INPUT TYPE='Submit' VALUE=''  id='ent' width='1'></td>";
   echo "</table>";
   echo "</form>";?>
</BODY>
</HTML>

