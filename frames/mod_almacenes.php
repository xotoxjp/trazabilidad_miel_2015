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

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=3 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }

$boton="NO";
$lat=0;$lon=0;
$contr="";$indice="";
$ret_iva='No';$ret_ib='No';$ret_gan='No';
$accion=0;
$accion=$_POST["accion"];

$almacen_id= $_GET["ID"];
if ($almacen_id>0){
}
else {

if ( ($_POST["ID"]=="NA") or ($accion==1))
{ header("Location: almacenes1.php");}
else {
  $almacen_id=substr($_POST["ID"],1);
}
}
if ( $accion==1 ){$boton="volver";}//header("Location: almacenes1.php") ;echo '1';}
if ( $accion==2 ){$boton="Salvar";}
if ( $accion==3 ){$boton="Imprimir";}
if ( $accion==4 ){$boton="Alta";}
if ( $accion==5 ){$boton="Baja";}

/************************************************* codigo añadido - Mejoramiento -********************************************************/ 
/************************** codigo para el guardado de formulario - condicion: campos obligatorios - ********************************************/
   if(($_POST["abrev"]!="")or($_POST["nombre"]!="")or($_POST["hor1"]!="")or($_POST["dir1"]!="")
	or($_POST["localidad"]!="")or($_POST["contacto"]!="")or($_POST["tel"]!="")){     
	 $formulario=$_SESSION["guarde"];
}
else{
      $formulario="formulario_vacio";
}
/****************************************************************************************************************************************/
   
foreach ($_POST as $indice => $valor)
  {
   //echo $indice . " " .$valor."<BR>";
   switch ($indice)
   {
    case 'tipo_almacen': $tipo_almacen=$valor ; break;
    case 'almacen_id': $almacen_id=$valor ; break;
    case 'abrev': $abrev=$valor ; break;
    case 'razon_social': $razon_social=$valor ; break;
    case 'nombre': $nombre=$valor ; break;
    case 'dir1': $dir1=$valor ; break;
    case 'dir2': $dir2=$valor ; break;
    case 'localidad': $localidad=$valor ; break;
    case 'cod_postal': $cod_postal=$valor ; break;
    case 'provincia':$provincia=$valor;break;
    case 'pais':$pais=$valor;break;
    case 'cond_iva':$cond_iva=$valor;break;
    case 'nro_cuit':$nro_cuit=$valor;break;


    case 'contacto': $contacto=$valor ;break;
    case 'tel': $tel=$valor ;break;
    case 'cel': $cel=$valor ;break;
    case 'fax': $fax=$valor ;break;
    case 'nextel': $nextel=$valor ;break;
    case 'email': $email=$valor ;break;
    
    case 'contacto1': $contacto1=$valor ;break;
    case 'tel1': $tel1=$valor ;break;
    case 'cel1': $cel1=$valor ;break;
    case 'email1': $email1=$valor ;break;
    case 'sector1': $sector1=$valor ;break;


    case 'lat': $lat=$valor ;break;
    case 'lon': $lon=$valor ;break;
    case 'hor1': $hor1=$valor ;break;
    case 'hor2': $hor2=$valor ;break;
   
    case 'contr': $contr=$valor ;break;

   case 'campo': $campo=$valor ; break;
   case 'orden': $orden=$valor ; break;
   case 'filtro': $filtro=$valor; break;
   case 'Submit': $sub=$valor; break; 
  }
}

if ($tipo_almacen<1){$tipo_almacen=1;} 
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);


if ($boton=="Imprimir")
{
{ header("Location: imp1.php?&ar=$almacen_id");}
}


if ($boton=="Baja")
  { if ($contr=="BAJA")
    { $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
      mysql_select_db($_SESSION["base_acc"]);
      $actualizar="DELETE from  ".$_SESSION["tabla_almacenes"]." where almacen_id=".$almacen_id ;
      $rs_validar = mysql_query($actualizar,$cx_validar); header("Location: almacenes1.php") ;echo '1';}
    else
    { echo "Para borrar este Item coloque en el Código de Seguridad la palabra BAJA";}
  }

//echo $_SESSION["filtro_almacen_id"];


// si hay filtros no hay limite porque los proceso despues
$Registros=$_REQUEST["Registros"];
$sub=".";
$orden=$_REQUEST["orden"];
$Limite="";
?>
<head>
<?
echo "<TITLE>Editando el almacen ".$almacen_id."</TITLE>";?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="viewport" content="width=device-width,initial-scale=1">             
  <link rel='shortcut icon' href='fotos/icono1.ico'>
  <link rel="stylesheet" href="css/botones.css" />
  <link rel="stylesheet" href="css/pantalla_edit.css" />

<style type="text/css">
#ent{display: none;}
.hide {display:none;}
.show {display:block;}
</style>

<script type="text/javascript">
<!--
function ini() {
  var IdAry=['Ley1','Ley2','Ley3','Ley4'];
  for (var zxc0=0;zxc0<IdAry.length;zxc0++){
     if (el=document.getElementById(IdAry[zxc0])){
     el.onmouseover=function() { ilumi(this,true) }
     el.onmouseout=function() { ilumi(this,false) }}
  }

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

function ilumi(obj,valor) {obj.style.background = (valor) ? 'yellow' : '';}

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

function muestrob(elemento)
 {
  tx=document.getElementById('Eleccion');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();
 }


function muestrof()
 {
  btn=document.getElementById('ent');
  btn.click();
 }

 function  validacion(){
   var elemento = document.getElementById("NRO_CUIT").value;
   var lista = document.getElementById("cond_iva");
   var indiceSeleccionado = lista.selectedIndex;
   var iva = lista.options[indiceSeleccionado];
   return true;
   }
function vd(){
   if (iva.text=="CF"){elemento.value="99-99999999-9"; return true;}
   if (iva.text=="SIN"){elemento.value="99-99999999-9";return true;}
   }

function oprimo(elemento)
{
  tx=document.getElementById('accion');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();
}
-->
</script>
<?
echo "<body onload='ini();'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='mod_almacenes.php'>";
$_SESSION[idc]=$almacen_id;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

if ($boton=="Salvar"){

  $actualizar="update ".$_SESSION['tabla_almacenes']." set  almacen_id=".$almacen_id.", razon_social='".$nombre."'" ;
  $actualizar=$actualizar." ,abrev='".$abrev."'";
  $actualizar=$actualizar." ,hab_senasa='".$hab_senasa."'";
  $actualizar=$actualizar." ,dir1='".$dir1."'";
  $actualizar=$actualizar." ,dir2='".$dir2."'";
  $actualizar=$actualizar." ,localidad='".$localidad."'";
  $actualizar=$actualizar." ,cod_postal='".$cod_postal."'";
  $actualizar=$actualizar." ,provincia='".$provincia."'";
  $actualizar=$actualizar." ,pais='".$pais."'";
  $actualizar=$actualizar." ,cond_iva='".$cond_iva."'";
  $actualizar=$actualizar." ,nro_cuit='".$nro_cuit."'";
  $actualizar=$actualizar." ,contacto='".$contacto."'";
  $actualizar=$actualizar." ,tel='".$tel."'";
  $actualizar=$actualizar." ,cel='".$cel."'";
  $actualizar=$actualizar." ,fax='".$fax."'";
  $actualizar=$actualizar." ,nextel='".$nextel."'";
  $actualizar=$actualizar." ,email='".$email."'";
  $actualizar=$actualizar." ,sector='".$sector."'";
  $actualizar=$actualizar." ,contacto1='".$contacto1."'";
  $actualizar=$actualizar." ,tel1='".$tel1."'";
  $actualizar=$actualizar." ,cel1='".$cel1."'";
  $actualizar=$actualizar." ,email1='".$email1."'";
  $actualizar=$actualizar." ,sector1='".$sector1."'";
  $actualizar=$actualizar." ,lat=".$lat;
  $actualizar=$actualizar." ,lon=".$lon;
  $actualizar=$actualizar." ,tipo_almacen=".$tipo_almacen;
  $actualizar=$actualizar." ,hor1='".$hor1."'";
  $actualizar=$actualizar." ,hor2='".$hor2."'";
  $actualizar=$actualizar."  where almacen_id=".$almacen_id ;
  
  mysql_query($actualizar,$cx_validar);
  
}

if ($boton=="Alta") {
  $actualizar="SELECT max( almacen_id ) from ".$_SESSION["tabla_almacenes"];
  $rs_validar = mysql_query($actualizar,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$almacen_id= 1+ $v_validar[0];}
  $actualizar="INSERT INTO ".$_SESSION["tabla_almacenes"]." (`almacen_id`, `razon_social`, `abrev`, `hab_senasa`, `dir1`, `dir2`,";
  $actualizar=$actualizar." `localidad`, `cod_postal`, `provincia`, `pais`, `cond_iva`, `nro_cuit`, `contacto`,";
    $actualizar=$actualizar." `tel`, `cel`, `fax`, `nextel`, `email`, `sector`, `contacto1`,";
  $actualizar=$actualizar." `tel1`, `cel1`, `email1`, `sector1`,`lat`, `lon`, `hor1`, `hor2`, `tipo_almacen`) VALUES (".$almacen_id.",";
  $actualizar=$actualizar." '" .$nombre . "','".$abrev."','".$hab_senasa."','" .$dir1;
  $actualizar=$actualizar."', '".$dir2."', '".$localidad."', ".$cod_postal. ", '".$provincia."', '".$pais. "', '" ;
  $actualizar=$actualizar.  $cond_iva."', '".$nro_cuit."', '".$contacto."', '".$tel."',";
  $actualizar=$actualizar." '".$cel."', '".$fax."',";
  $actualizar=$actualizar." '".$nextel."', '".$email."', '".$sector."', '".$contacto1."', '".$tel1."', '".$cel1;
  $actualizar=$actualizar."', '".$email."', '".$sector1."',".$lat.", ".$lon." , '".$hor1."', '".$hor2."', ".$tipo_almacen.")";
  $rs_validar = mysql_query($actualizar,$cx_validar);
}
$a="select * from  ".$_SESSION["tabla_almacenes"]. " where almacen_id=".$almacen_id ;
$r = mysql_query($a,$cx_validar);
while ($v_validar = mysql_fetch_array($r)){
    $almacen_id= $v_validar[0];
    $nombre= $v_validar[1];
    $dir1= $v_validar[2];
    $dir2= $v_validar[3];
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
    $sector=$v_validar[16];
    $contacto1=$v_validar[17];
    $tel1=$v_validar[18];
    $cel1=$v_validar[19];
    $email1=$v_validar[20];
    $sector1=$v_validar[21];
    $lat=$v_validar[22];
    $lon=$v_validar[23];
    $hor1=$v_validar[24];
    $hor2=$v_validar[25];
    $tipo_almacen=$v_validar[26];
    $abrev=$v_validar[27];
    $hab_senasa=$v_validar[28];
  }
  
  /*************************************** codigo que elimina el formulario vacio *****************************************/
 
 if($boton=="volver"){
   if($formulario=="formulario_vacio"){
     $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
      mysql_select_db($_SESSION["base_acc"]);
      
	  $actualizar="DELETE from  ".$_SESSION["tabla_almacenes"]." where almacen_id=".$almacen_id ;
      $rs_validar = mysql_query($actualizar,$cx_validar);
	  header("Location: almacenes1.php") ;
       
    }
 }
  /******************************************************************************************************************/

  /**********************codigo que pinta los datos del formulario que resultan obligatorios***********************************/
  if ($boton=="Salvar"){
  if ($formulario=="formulario_vacio"){
      $pinta="border:2px solid red";
            $aviso="campos obligatorios marcados en rojo complételos para guardar";
 }
}
 /******************************************************************************************************************/
  
  $a1="select tipo from  ".$_SESSION["tabla_tipo_almacen"]." where tipo_almacen=".$tipo_almacen  ;$tipo="acopio";
  $r = mysql_query($a1,$cx_validar);
  while ($v1 = mysql_fetch_array($r)) 
    {$tipo= $v1[0];}

  $actualizar1="select cod_iva from  ".$_SESSION["tabla_iva"]." where cod_iva<>"."'".$cond_iva."'" ;  
  $rs_validar1 = mysql_query($actualizar1,$cx_validar);
	echo '<div id=contenedorForm>';
    echo '<table border="1" witdh="100%" ><tr><td>';

    echo '<table border="1" witdh="100%">';
    echo "<tr><caption color style='background:#99FF33'> Datos del almacen ".$almacen_id."</caption></tr>";

    echo '<tr><td><table><tr><td rowspan="3" width="10%"><img src="fotos/'.$tipo.'.jpg" height="80"></td><td width="90%">Raz&oacute;n Social:';
    //razon social
	echo "&nbsp"."<input style="."'".$pinta."'"." name='nombre' type='text'  value="."'".$nombre."'"."  size='45' maxlength='50'>";
    echo 'C&oacutedigo:';
    //codigo - abrev
	echo "<input style="."'".$pinta."'"." name='abrev' type='text'  value="."'".$abrev."'"."  size='12' maxlength='12'>";
    echo '</td></tr>';

    echo "<tr><td>NUMERO DE HABILITACION DE SENASA:&nbsp<img src='fotos/senasa.JPG' width='20' height='20'>&nbsp<input name='hab_senasa' type='text'  value="."'".$hab_senasa."'"."  size='20' maxlength='20'>";
    echo '</td></tr>';
    
    echo  '<tr><td>Cond.de Iva:'."&nbsp";

    echo  '<select name="cond_iva" id="cond_iva">';
    echo  "<option value="."'".$cond_iva."'>".$cond_iva."</option>";


     while ($v_validar1 = mysql_fetch_array($rs_validar1))
     { if ($v_validar1[0]==$cond_iva){}
       else { echo  "<option value="."'".$v_validar1[0]."'>".$v_validar1[0]."</option>"; }
     }
    echo  "&nbsp".'Cuit N&uacute;mero'."&nbsp";
    echo "<input name='nro_cuit' ID='nro_cuit' type='text'  value="."'".$nro_cuit."'"."  size='13' maxlength='13'>";

    $actualizar1="select tipo_almacen,nombre from  ".$_SESSION["tabla_tipo_almacen"].' order by tipo_almacen' ;
    $rs_validar1 = mysql_query($actualizar1,$cx_validar);

    echo '&nbsp;Almac&eacute;n Tipo<select name="tipo_almacen" id="tipo_almacen">';
    while ($v_validar1 = mysql_fetch_array($rs_validar1)){
      echo  '<option value='.$v_validar1[0];
      if ($v_validar1[0]==$tipo_almacen){echo " selected='selected' ";}
      echo '>'.substr('   '.$v_validar1[0],-3) .' - '.$v_validar1[1].'</option>'; 
    }
    echo '</select>';

  echo '</td></table></td></tr>';



    echo '<tr><td><table border="0" width="100%">';
    echo '<tr>';
    echo  "<td witdh='1%'>Dirección</td>";
    //direccion
	echo "<td><input style="."'".$pinta."'"." name='dir1' type='text' id=dir1  value="."'".$dir1."' size='50' maxlength='50'>&nbsp;&nbsp;Latitud&nbsp;&nbsp;";
    //
	echo "<input name='lat' type='text' id='lat'  value="."'".$lat."' size='10' maxlength='15'>";

    echo '</tr><tr>';
    echo  "<td></td>";
    echo "<td><input name='dir2' type='text' id=dir2  value='".$dir2."' size='50' maxlength='50'>&nbsp;&nbsp;Longitud&nbsp;";
    echo "<input name='lon' type='text' id='lon'  value="."'".$lon."' size='10' maxlength='15'>";

    echo "</tr>";


    echo '</tr><tr>';
    echo  "<td align='right'>Localidad</td>";
    //localidad
	echo "<td><input style="."'".$pinta."'"." name='localidad' type='text' id='localidad'  value="."'".$localidad."'"."  size='30' maxlength='30'>";

	echo "&nbsp;Cód.Postal&nbsp;<input name='cod_postal' type='text' id=cod_postal  value="."'".$cod_postal."'"."  size='8' maxlength='10'></td></tr>";
    
	echo "<tr><td>Prov.&nbsp;</td><td><input name='provincia' type='text' id='provincia'  value="."'".$provincia."'"."  size='20' maxlength='20'>";
    echo "&nbsp;Pais.&nbsp;<input name='pais' type='text' id='pais'  value="."'".$pais."'"."  size='20' maxlength='20'></td></tr>";

    echo '<tr><td colspan=2><hr></td></tr>';
    
    echo '<tr><td>Contacto</td>';
    //contacto
	echo "<td><input style="."'".$pinta."'"." name='contacto' type='text' id='contacto'  value='".$contacto."' size='30' maxlength='30'>";
    //sector-equivale a tipo de almacen
	echo "&nbsp;&nbsp;&nbsp;Sector&nbsp;<input name='sector' type='text' id='sector'  value='".$sector."' size='15' maxlength='20'></td>";
    echo '</tr>';
    echo "<tr><td align='right'>Telefono</td>";
    //telefono 
	echo "<td><table><td><input style="."'".$pinta."'"." name='tel' type='text' id='tel'  value='".$tel."' size='30' maxlength='30'></td>";
    //
	echo  '<td>Cel</td>';
    echo "<td><input name='cel' type='text' id='cel' value="."'".$cel."'"."  size='15' maxlength='15'></td>";
    echo "<td>Nextel</td><td><input name='nextel' type='text' id='nextel' value="."'".$nextel."'"."  size='8' maxlength='8'></td>";
    echo "</table>";
    echo '</tr>';

    echo '<tr>';
    echo  "<td align='right'>email</td>";
    echo "<td><table><td><input name='email' type='text' id='email'  value='".$email."' size='30' maxlength='30'></td>";
    echo  '<td>Fax</td>';
    echo "<td><input name='fax' type='text' id='fax'  value='".$fax."' size='15' maxlength='15'></td></table>";
  echo '</tr><tr><td colspan=2><hr></td>';

    echo '</tr><tr>';
    echo '<tr><td>Contacto</td>';
    echo "<td><input name='contacto1' type='text' id='contacto1'  value='".$contacto1."' size='30' maxlength='30'>";
    echo "&nbsp;&nbsp;&nbsp;Sector&nbsp;<input name='sector1' type='text' id='sector1'  value='".$sector1."' size='15' maxlength='20'></td>";
    echo '</tr>';
    echo "<tr><td align='right'>Telefono</td>";
    echo "<td><table><td><input name='tel1' type='text' id='tel1'  value='".$tel1."' size='15' maxlength='15'></td>";
    echo  '<td>Cel</td>';
    echo "<td><input name='cel1' type='text' id='cel1' value="."'".$cel1."'"."  size='15' maxlength='15'></td>";
    echo "<td>email</td><td><input name='email1' type='text' id='email1' value="."'".$email1."'"."  size='12' maxlength='30'></td>";
    echo "</table>";
   echo '</tr><tr><td colspan=2><hr></td></tr>';
 

    echo '<tr><td rowspan="2">Horarios de<br>Atenci&oacute;n</td><td>';
    //horario de atencion
	echo "<input name='hor1' type='text' id='hor1'  value='".$hor1."' size='50' maxlength='50'></td></tr><tr><td>";
    echo "<input name='hor2' type='text' id='hor2'  value='".$hor2."' size='50' maxlength='50'></td></tr>";
    //
    echo "</table>";
 


echo "</table>";

   echo "<INPUT TYPE=HIDDEN name='num_reg_desde'  value="."'".$_SESSION[reg_desde]."'>";
   echo "<INPUT TYPE=HIDDEN name='num_reg_hasta'  value="."'".$_SESSION[reg_hasta]."'>";
   echo "<INPUT TYPE=HIDDEN name='almacen_id'  value="."'".$almacen_id."'>";

   if ($boton=="Baja"){   echo "<br>Código de Seguridad "."<INPUT TYPE=INPUT name='contr' ID='contr'  value='".$contr."'>"; }
   
//botones del formulario

echo "<table border='2'  width='100%'><tr>";

/* luego de Acciones definidas por el usuario </br><strong><font size='4' color= 'red'> ".$aviso."</font></strong> que es codigo para que aparezca el aviso*/
echo "<caption color style='background:#99FF33'> Acciones Definidas para el Usuario</br><strong><font size='4' color= 'red'> ".$aviso."</font></strong></caption>";  
echo '<td>';
echo '<div id=botonera>';
echo '<span onclick="oprimo(1);">Volver</span>';
if ($modifica=='on'){echo '<span onclick="oprimo(2);">Guardar</span>';}
echo'<span onclick="oprimo(3);">Imprimir</span>';

if ($baja=='on'){echo '<span onclick="oprimo(5);">Borrar</span>';}
echo '</div>';
echo '</td></tr></table>';

   echo "<INPUT TYPE=HIDDEN name='accion' id='accion' value='".$accion."'>";
   echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'>";

echo "</form>";
echo "</div>";
?>
</BODY>
</HTML>