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
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" and orden=2 and acceso="on"';
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
$accion=0;$pers_id=0;$login='';
$prov_id=0;$campo_id=0;
$accion=$_POST["accion"];
if ( ($_POST["ID"]=="NA") or ($accion==1))
{ header("Location: colmenas1.php");}
else {
  
  $p=substr($_POST["ID"],1);
  $p1=strrchr($p,'-');
  $px=strrchr($p,'/');

//   campo - prov / colmena
// echo 'p'.$p.'<br>';
// echo 'p1'.$p1.'<br>';
// echo 'px'.$px.'<br>';

  if ($p1<> FALSE){
    $l=strlen($p);
    $l1=strlen($p1);
    $lx=strlen($px);

// echo 'l'.$l.'<br>';
// echo 'l1'.$l1.'<br>';
// echo 'lx'.$lx.'<br>';

    $l2=$l-$l1;
    $campo_id=  0 + substr($p,0,$l2);
    $l3= $l1 -$lx -1 ;
    $prov_id= 0 + substr($p, $l2+1 ,$l3);   
    $colmena_id = 0 + substr($px,-($lx - 1));   

  }
}

if ( $accion==1 ){header("Location: colmenas1.php") ;echo '1';}
if ( $accion==2 ){$boton="Salvar";}
if ( $accion==3 ){$boton="Imprimir";}
if ( $accion==4 ){$boton="Alta";}
if ( $accion==5 ){$boton="Baja";}

   
foreach ($_POST as $indice => $valor)
  { //echo $indice . " " .$valor."<BR>";
   switch ($indice)
   {
    case 'prov_id'     : if (($valor>0) and ($prov_id==0)) {$prov_id=$valor;} break;
    case 'campo_id'    : if (($valor>0)  and ($campo_id==0)){$campo_id=$valor;}; break;
    case 'colmena_id'  : $colmena_id=$valor ; break;
    case 'tipo_colmena': $tipo_colmena=$valor ; break;
    case 'fecha_alta'  : $fecha_alta=$valor ; break;
    case 'tipo_abeja'  : $tipo_abeja=$valor ; break;
    case 'estado'      : $estado=$valor ; break;
    case 'f_ult_visita': $f_ult_visita=$valor ; break;
    case 'pers_id'     : $pers_id=$valor ; break;
    case 'nro_ult_mov' : $nro_ult_mov=$valor ; break;
    case 'cam_col_id'  : $cam_col_id=$valor ; break;
    case 'op'          : $op=$valor ; break;
   case 'campo': $campo=$valor ; break;
   case 'orden': $orden=$valor ; break;
   case 'filtro': $filtro=$valor; break;
   case 'Submit': $sub=$valor; break; 
  }
}


$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);


if ($boton=="Imprimir"){ header("Location: imp1.php?&ar=$prov_id");}
if ($boton=="Colmenas"){ header("Location: colmenas1.php?&prov_id=$prov_id&campo_id=$campo_id");}


if ($boton=="Baja")
  { if ($contr=="BAJA")
    { $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
      mysql_select_db($_SESSION["base_acc"]);
      $act="DELETE from  ".$_SESSION["tabla_provedores"]." where prov_id=".$prov_id ;
      
      $rs_validar = mysql_query($act,$cx_validar); header("Location: colmenas1.php") ;echo '1';}
    else
    { echo "Para borrar este Item coloque en el C&oacute;digo de Seguridad la palabra BAJA";}
  }




// si hay filtros no hay limite porque los proceso despues
$Registros=$_REQUEST["Registros"];
$sub=".";
$orden=$_REQUEST["orden"];
$Limite="";
?>
<head>
<?
echo "<TITLE>Editando Colmena ".$colmena_id."</TITLE>";?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="viewport" content="width=device-width,initial-scale=1">             
  <link rel="stylesheet" href="botones.css" />
  <link rel="stylesheet" type="text/css" href="examples.css" />
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="lang/calendar-es.js"></script>
<script type="text/javascript" src="js/calendar-setup.js"></script>

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
</script>

<?
echo "<body onload='ini();'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='mod_colmenas1.php'>";
$_SESSION[idc]=$prov_id;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);




if ($boton=="Salvar"){


  $act="update ".$_SESSION['tabla_colmenas']." set " ;
  $act=$act." tipo_colmena='".$tipo_colmena."'";
  $act=$act." ,fecha_alta='".substr($fecha_alta,6,4).substr($fecha_alta,2,4).substr($fecha_alta,0,2)."'";

  $act=$act." ,tipo_abeja='".$tipo_abeja."'";
  $act=$act." ,estado='".$estado."'";
  $act=$act." ,f_ult_visita='".substr($f_ult_visita,6,4).substr($f_ult_visita,2,4).substr($f_ult_visita,0,2)."'";
  $act=$act." ,pers_id='".$pers_id."'";
  $act=$act." ,nro_ult_mov='".$nro_ult_mov."'";
  $act=$act." ,cam_col_id='".$cam_col_id."'";
  $act=$act." ,op='".$op."'";
  $act=$act."  where campo_id=".$campo_id.' and prov_id='.$prov_id.' and colmena_id='.$colmena_id ;

  mysql_query($act,$cx_validar);
      act_col_cam($prov_id,$campo_id);
}

if ($boton=="Alta") {
  $act="SELECT max( colmena_id ) from ".$_SESSION["tabla_colmenas"];
  $rs_validar = mysql_query($act,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$colmena_id= 1+ $v_validar[0];}

  $act="INSERT INTO ".$_SESSION["tabla_colmenas"]." (`campo_id`,`prov_id`, `colmena_id`, `tipo_colmena`, `fecha_alta`,";
  $act=$act." `tipo_abeja`, `estado`, `f_ult_visita`, `pers_id`, `cam_col_id`, `op` ) VALUES (".$campo_id.",".$prov_id.",";
  $act=$act. $colmena_id .",'" .$tipo_colmena."','".substr($fecha_alta,6,4).substr($fecha_alta,2,4).substr($fecha_alta,0,2)."','".$tipo_abeja."','".$estado. "','".substr($f_ult_visita,6,4).substr($f_ult_visita,2,4).substr($f_ult_visita,0,2)."',".$pers_id. ",'" ;
  $act=$act. $cam_col_id."', '".$op."' )";
  $rs_validar = mysql_query($act,$cx_validar);
  act_col_cam($prov_id,$campo_id);

}
$act="select * from  ".$_SESSION["tabla_colmenas"]. " where prov_id=".$prov_id.' and campo_id='.$campo_id .' and colmena_id='.$colmena_id ;
$rs_validar = mysql_query($act,$cx_validar);
while ($v_validar = mysql_fetch_array($rs_validar))
  {
    $prov_id= $v_validar[0];
    $campo_id= $v_validar[1];
    $colmena_id= $v_validar[2];
    $tipo_colmena= $v_validar[3];

    $f=$v_validar[4];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $fecha_alta=$f;

    $tipo_abeja=$v_validar[5];
    $estado=$v_validar[6];
    
    $f=$v_validar[7];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_ult_visita=$f;

    $pers_id=$v_validar[8];
    $nro_ult_mov=$v_validar[9];
    $cam_col_id=$v_validar[10];

    $op=$v_validar[11];
  }
$provedor='';
$actualizar='select razon_social from  ' .$_SESSION["tabla_provedores"].' where prov_id='.$prov_id;
$rs_validar = mysql_query($actualizar,$cx_validar);
while ($v_validar = mysql_fetch_array($rs_validar)) { $provedor= $v_validar[0];}

$campo='';
$actualizar='select razon_social from  ' .$_SESSION["tabla_campos"].' where campo_id='.$campo_id;

$rs_validar = mysql_query($actualizar,$cx_validar);
while ($v_validar = mysql_fetch_array($rs_validar)) { $campo= $v_validar[0];}


echo '<table border="1" ><tr><td>';
  echo '<table border="1" width="100%">';
    echo '<caption color style="background:#99FF33"><table><tr><td width="10%"><img src="fotos/colmena.jpg"></td><td align="center">&nbsp;&nbsp;&nbsp;&nbsp;Datos de la Colmena '.$colmena_id.'</td></tr></table></caption>';
    echo '<tr><td colspan="2">Provedor:&nbsp;'.$provedor.'</td></tr>';
    echo '<tr><td colspan="2">Campo:&nbsp;&nbsp;&nbsp;'.$campo.'</td></tr>';
    
    echo  '<tr><td><br>N&uacutemero Interno en el Campo</td><td>';
    echo "<br><input name='cam_col_id' type='text' id=cam_col_id placeholder='Ejemplo: J-001'  value="."'".$cam_col_id."' size='12' maxlength='8'></td></tr>";
    

    echo "<tr><td>Fecha de Alta</td><td><input name='fecha_alta' type='text' id=fecha_alta  value="."'".$fecha_alta."' ></td></tr>";


    echo  '<tr><td><br>Tipo de Colmena:</td><td><br>';

    $act1="select tipo from  ".$_SESSION["tabla_tipo_colmenas"];
    $rs_validar1 = mysql_query($act1,$cx_validar); 
    echo  '<select name="tipo_colmena" id="tipo_colmena">';
    while ($v_validar1 = mysql_fetch_array($rs_validar1)) {
      echo  "<option value='".$v_validar1[0]."'";
      if ($v_validar1[0]==$tipo_colmena){echo ' selected ';}
      echo ">".$v_validar1[0]."</option>";
    }
    echo '</select>';    
    echo '</td></tr>';

    echo  '<tr><td>Tipo de Abeja:</td><td><br>'; 
    $act1="select tipo from  ".$_SESSION["tabla_tipo_abejas"];
    $rs_validar1 = mysql_query($act1,$cx_validar); 
    echo  '<select name="tipo_abeja" id="tipo_abeja">';
    while ($v_validar1 = mysql_fetch_array($rs_validar1)) {
      echo  "<option value='".$v_validar1[0]."'";
      if ($v_validar1[0]==$tipo_abeja){echo ' selected ';}
      echo ">".$v_validar1[0]."</option>";
    }
    echo '</select>';    


    echo '</td></tr>';

    


    echo  '<tr><td>Estado de la Colmena</td><td>';
    $act1="select tipo from  ".$_SESSION["tabla_tipo_estado"];
    $rs_validar1 = mysql_query($act1,$cx_validar); 
    echo  '<select name="estado" id="estado">';
    while ($v_validar1 = mysql_fetch_array($rs_validar1)) {
      echo  "<option value='".$v_validar1[0]."'";
      if ($v_validar1[0]==$estado){echo ' selected ';}
      echo ">".$v_validar1[0]."</option>";
    }
    echo '</select>';    

    
    echo '</td></tr>';


    echo "<tr><td><br>Fecha de &Uacute;ltima Visita</td><td><br><input name='f_ult_visita' type='text' id=f_ult_visita  value="."'".$f_ult_visita."' ></td></tr>";
    echo "<tr><td>N&uacute;mero de &Uacute;ltimo Mov.</td><td><input name='nro_ult_mov' type='text' id=nro_ult_mov  value="."'".$nro_ult_mov."' ></td></tr>";




    echo  '<tr><td><br>&nbsp;&nbsp;&nbsp;Lo Atendi&oacute;</td><td><br>';
    $actualizar1="select login from  ".$_SESSION["tabla_acc"]." where op_campo='Si' and id_usuario=".$pers_id ;
    $rs_validar1 = mysql_query($actualizar1,$cx_validar);$op='';
    while ($v_validar1 = mysql_fetch_array($rs_validar1)){ $op=$v_validar1[0];;break;}


    $actualizar1="select id_usuario,login from  ".$_SESSION["tabla_acc"]." where op_campo='Si' and id_usuario<>".$pers_id ;
    $rs_validar1 = mysql_query($actualizar1,$cx_validar);

    echo  '<select name="pers_id" id="pers_id">';
    if ($pers_id!=0) {
      echo       "<option value="."'".$pers_id."'>".$op."</option>";
    }
    while ($v_validar1 = mysql_fetch_array($rs_validar1)){ 
      echo  "<option value="."'".$v_validar1[0]."'>".$v_validar1[1]."</option>"; 
    }
 
     

echo "</table></td></tr><tr><td>";

   echo "<INPUT TYPE=HIDDEN name='num_reg_desde'  value="."'".$_SESSION[reg_desde]."'>";
   echo "<INPUT TYPE=HIDDEN name='num_reg_hasta'  value="."'".$_SESSION[reg_hasta]."'>";
   echo "<INPUT TYPE=HIDDEN name='prov_id'  value="."'".$prov_id."'>";
   echo "<INPUT TYPE=HIDDEN name='campo_id'  value="."'".$campo_id."'>";
   echo "<INPUT TYPE=HIDDEN name='colmena_id'  value="."'".$colmena_id."'>";

   if ($boton=="Baja"){   echo "<br>C&oacute;digo de Seguridad "."<INPUT TYPE=INPUT name='contr' ID='contr'  value='".$contr."'>"; }
   
  
echo "<table border='2'  width='100%'><tr>";
echo "<caption color style='background:#99FF33'> Acciones Definidas para el Usuario </caption>"     ;  
echo '<td><span onclick="oprimo(1);">Volver</span>';
if ($modifica=='on'){echo '<span onclick="oprimo(2);">Guardar</span>';}
echo'<span onclick="oprimo(3);">Imprimir</span>';
if ($alta=='on'){echo '<span onclick="oprimo(4);">Alta</span>';}
if ($baja=='on'){echo '<span onclick="oprimo(5);">Borrar</span>';}
echo '</td></tr></table>';

   echo "<INPUT TYPE=HIDDEN name='accion' id='accion' value='".$accion."'>";
   echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'>";?>
  </form>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_alta",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
      timeFormat     :    "24"  });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_ult_visita",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
      timeFormat     :    "24"  });
</script>
</BODY>
</HTML>

