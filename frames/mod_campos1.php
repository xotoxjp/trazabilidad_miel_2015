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
{ header("Location: provedores1.php");}
else {
  $prov_id=substr($_POST["ID"],1);
  $p=substr($_POST["ID"],1);
  $p1=strrchr($p,'-');
  if ($p1<> FALSE){
    $l=strlen($p1);
    $l1=strlen($p);
    $l2=$l1-$l;
    $campo_id=  0 + substr($p,0,$l2);
    $prov_id= 0 + substr($p1,-($l - 1));   
  }
}

if ( $accion==1 ){header("Location: campos1.php") ;echo '1';}
if ( $accion==2 ){$boton="Salvar";}
if ( $accion==3 ){$boton="Imprimir";}
if ( $accion==4 ){$boton="Alta";}
if ( $accion==5 ){$boton="Baja";}
if ( $accion==6 ){$boton="Colmenas";}
   
foreach ($_POST as $indice => $valor)
  {//echo $indice . " " .$valor."<BR>";
   switch ($indice)
   {
    case 'login': $login=$valor ; break;
    case 'pers_id': $pers_id=$valor ; break;
    case 'campo_id': $campo_id=$valor ; break;
    case 'prov_id': if ($valor>0) {$prov_id=$valor;} break;
    case 'razon_social': $razon_social=$valor ; break;
    case 'nombre': $nombre=$valor ; break;
    case 'abrev': $abrev=$valor ; break;
    case 'dir1': $dir1=$valor ; break;
    case 'dir2': $dir2=$valor ; break;
    case 'localidad': $localidad=$valor ; break;
    case 'cod_postal': $cod_postal=$valor ; break;
    case 'provincia':$provincia=$valor;break;
    case 'pais':$pais=$valor;break;
    case 'cond_iva':$cond_iva=$valor;break;
    case 'nro_cuit':$nro_cuit=$valor;break;

    case 'reg_nac':$reg_nac=$valor;break;
    case 'f_alta_nac':$f_alta_nac=$valor;break;
    case 'f_vto_nac':$f_vto_nac=$valor;break;

    case 'reg_prov':$reg_prov=$valor;break;
    case 'f_alta_prov':$f_alta_prov=$valor;break;
    case 'f_vto_prov':$f_vto_prov=$valor;break;

    case 'reg_dep':$reg_dep=$valor;break;
    case 'f_alta_dep':$f_alta_dep=$valor;break;
    case 'f_vto_dep':$f_vto_dep=$valor;break;

    case 'reg_sen1':$reg_sen1=$valor;break;
    case 'f_alta_sen1':$f_alta_sen1=$valor;break;
    case 'f_vto_sen1':$f_vto_sen1=$valor;break;
    case 'reg_sen2':$reg_sen2=$valor;break;
    case 'f_alta_sen2':$f_alta_sen2=$valor;break;
    case 'f_vto_sen2':$f_vto_sen2=$valor;break;
    case 'reg_sen3':$reg_sen3=$valor;break;
    case 'f_alta_sen3':$f_alta_sec3=$valor;break;
    case 'f_vto_sen3':$f_vto_sen3=$valor;break;

    case 'contacto': $contacto=$valor ;break;
    case 'tel': $tel=$valor ;break;
    case 'cel': $cel=$valor ;break;
    case 'fax': $fax=$valor ;break;
    case 'nextel': $nextel=$valor ;break;
    case 'email': $email=$valor ;break;
    case 'sector': $sector=$valor ;break;
    
    case 'contacto1': $contacto1=$valor ;break;
    case 'tel1': $tel1=$valor ;break;
    case 'cel1': $cel1=$valor ;break;
    case 'email1': $email1=$valor ;break;
    case 'sector1': $sector1=$valor ;break;

    case 'contacto2': $contacto2=$valor ;break;
    case 'tel2': $tel2=$valor ;break;
    case 'cel2': $cel2=$valor ;break;
    case 'email2': $email2=$valor ;break;
    case 'sector2': $sector2=$valor ;break;

    case 'lat': $lat=$valor ;break;
    case 'lon': $lon=$valor ;break;

    case 'colmenas': $colmenas=$valor ;break;
    case 'nucleos': $nucleos=$valor ;break;
    case 'prod_anual': $prod_anual=$valor ;break;
   
    case 'contr': $contr=$valor ;break;

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
      
      $rs_validar = mysql_query($act,$cx_validar); header("Location: provedores1.php") ;echo '1';}
    else
    { echo "Para borrar este Item coloque en el C&oacute;digo de Seguridad la palabra BAJA";}
  }

act_col_cam($prov_id,$campo_id);



// si hay filtros no hay limite porque los proceso despues
$Registros=$_REQUEST["Registros"];
$sub=".";
$orden=$_REQUEST["orden"];
$Limite="";
?>
<head>
<?
echo "<TITLE>Editando el Campo ".$campo_id."</TITLE>";?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="viewport" content="width=device-width,initial-scale=1">             
  <link rel="stylesheet" href="botones.css" />
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script type="text/javascript" src="../gmaps.js"></script>
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


  <script type="text/javascript">
    var map;
    $(document).ready(function(){
     var la = document.getElementById("lat").value;
     var lo = document.getElementById("lon").value;

      map = new GMaps({
        article: '#map',
        lat: la,
        lng: lo,
        zoomControl : true,
        zoomControlOpt: {
            style : 'LARGE',
            position: 'TOP_LEFT'
        },
        panControl : true,
        streetViewControl : true,
        mapTypeControl: true,
        overviewMapControl: true

    });
      map.addMarker({
        lat: la,
        lng: lo,
        title: 'UNO',
        details: {
          database_id: 1,
          author: 'Edu'
        },
        click: function(e){
          if(console.log)
            console.log(e);
          alert('You clicked in this marker');
        }
      });
    });
  </script>
<?
echo "<body onload='ini();'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='mod_campos1.php'>";
$_SESSION[idc]=$prov_id;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);




if ($boton=="Salvar"){

  $act="SELECT login from ".$_SESSION["tabla_acc"].' where id_usuario='.$pers_id;
  $rs_validar = mysql_query($act,$cx_validar); 
  while ($v_validar = mysql_fetch_array($rs_validar)){$opera= $v_validar[0];}

  $act="update ".$_SESSION['tabla_campos']." set  prov_id=".$prov_id.", razon_social='".$nombre."'" ;
  $act=$act." ,abrev='".$abrev."'";
  $act=$act." ,dir1='".$dir1."'";
  $act=$act." ,dir2='".$dir2."'";
  $act=$act." ,localidad='".$localidad."'";
  $act=$act." ,cod_postal=".$cod_postal;
  $act=$act." ,provincia='".$provincia."'";
  $act=$act." ,pais='".$pais."'";
  $act=$act." ,cond_iva='".$cond_iva."'";
  $act=$act." ,nro_cuit='".$nro_cuit."'";
  $act=$act." ,contacto='".$contacto."'";
  $act=$act." ,tel='".$tel."'";
  $act=$act." ,cel='".$cel."'";
  $act=$act." ,fax='".$fax."'";
  $act=$act." ,nextel='".$nextel."'";
  $act=$act." ,email='".$email."'";
  $act=$act." ,sector='".$sector."'";
  $act=$act." ,contacto1='".$contacto1."'";
  $act=$act." ,tel1='".$tel1."'";
  $act=$act." ,cel1='".$cel1."'";
  $act=$act." ,email1='".$email1."'";
  $act=$act." ,sector1='".$sector1."'";
  $act=$act." ,contacto2='".$contacto2."'";
  $act=$act." ,tel2='".$tel2."'";
  $act=$act." ,cel2='".$cel2."'";
  $act=$act." ,email2='".$email2."'";
  $act=$act." ,sector2='".$sector2."'";
  $act=$act." ,lat=".$lat;
  $act=$act." ,lon=".$lon;
  $act=$act." ,colmenas=".$colmenas;
  $act=$act." ,nucleos=".$nucleos;
  $act=$act." ,pers_id=".$pers_id;
  $act=$act." ,op='".$opera."'";
  $act=$act." ,prod_anual=".$prod_anual;
  $act=$act." ,reg_nac='".$reg_nac."' ,reg_prov='".$reg_prov."' ,reg_dep='".$reg_dep."' ,reg_sen1='".$reg_sen1."'";

  $act=$act." ,f_alta_nac='".substr($f_alta_nac,6,4).substr($f_alta_nac,2,4).substr($f_alta_nac,0,2)."'";
  $act=$act." ,f_alta_prov='".substr($f_alta_prov,6,4).substr($f_alta_prov,2,4).substr($f_alta_prov,0,2)."'";
  $act=$act." ,f_alta_dep='".substr($f_alta_dep,6,4).substr($f_alta_dep,2,4).substr($f_alta_dep,0,2)."'";
  $act=$act." ,f_alta_sen1='".substr($f_alta_sen1,6,4).substr($f_alta_sen1,2,4).substr($f_alta_sen1,0,2)."'";

  $act=$act." ,f_vto_nac='".substr($f_vto_nac,6,4).substr($f_vto_nac,2,4).substr($f_vto_nac,0,2)."'";
  $act=$act." ,f_vto_prov='".substr($f_vto_prov,6,4).substr($f_vto_prov,2,4).substr($f_vto_prov,0,2)."'";
  $act=$act." ,f_vto_dep='".substr($f_vto_dep,6,4).substr($f_vto_dep,2,4).substr($f_vto_dep,0,2)."'";
  $act=$act." ,f_vto_sen1='".substr($f_vto_sen1,6,4).substr($f_vto_sen1,2,4).substr($f_vto_sen1,0,2)."'";

  $act=$act."  where campo_id=".$campo_id.' and prov_id='.$prov_id ;

  mysql_query($act,$cx_validar);
  act_col_cam($prov_id,$campo_id);  
}

if ($boton=="Alta") {
  $act="SELECT login from ".$_SESSION["tabla_acc"].' where id_usuario='.$pers_id;
  $rs_validar = mysql_query($act,$cx_validar); while ($v_validar = mysql_fetch_array($rs_validar)){$opera= $v_validar[0];}


  $act="SELECT max( campo_id ) from ".$_SESSION["tabla_campos"];
  $rs_validar = mysql_query($act,$cx_validar) ;
  while ($v_validar = mysql_fetch_array($rs_validar)){$campo_id= 1+ $v_validar[0];}

  $act="INSERT INTO ".$_SESSION["tabla_campos"]." (`campo_id`,`prov_id`, `razon_social`, `abrev`, `dir1`, `dir2`,";
  $act=$act." `localidad`, `cod_postal`, `provincia`, `pais`, `cond_iva`, `nro_cuit`, `contacto`,";
  $act=$act." `tel`, `cel`, `fax`, `nextel`, `email`, `sector`, `contacto1`,";
  $act=$act." `tel1`, `cel1`, `email1`, `sector1`, `contacto2`, `tel2`,";
  $act=$act." `cel2`, `email2`, `sector2`, `lat`, `lon`, `reg_nac`, `reg_prov`, `reg_dep`, `reg_sen1`, ";
  $act=$act." `f_alta_nac`,`f_alta_prov`,`f_alta_dep`,`f_alta_sen1`,`f_vto_nac`,`f_vto_prov`,`f_vto_dep`,`f_vto_sen1`,`colmenas`,`nucleos`,`prod_anual`,`pers_id`,`op` ) VALUES (".$campo_id.",".$prov_id.",";
  $act=$act." '" .$nombre . "', '" .$abrev . "', '" .$dir1;
  $act=$act."', '".$dir2."', '".$localidad."', ".$cod_postal. ", '".$provincia."', '".$pais. "', '" ;
  $act=$act.  $cond_iva."', '".$nro_cuit."', '".$contacto."', '".$tel."',";
  $act=$act." '".$cel."', '".$fax."',";
  $act=$act." '".$nextel."', '".$email."', '".$sector."', '".$contacto1."', '".$tel1."', '".$cel1;
  $act=$act."', '".$email1."', '".$sector1."', '".$contacto2;
  $act=$act."', '".$tel2."', '".$cel2."', '".$email2."', '".$sector2."', ".$lat.", ".$lon.", '".$reg_nac."', '".$reg_prov."', '".$reg_dep."', '".$reg_sen1."','";
  $act=$act.substr($f_alta_nac,6,4).substr($f_alta_nac,2,4).substr($f_alta_nac,0,2)."', '".substr($f_alta_prov,6,4).substr($f_alta_prov,2,4).substr($f_alta_prov,0,2)."', '".substr($f_alta_dep,6,4).substr($f_alta_dep,2,4).substr($f_alta_dep,0,2)."', '".substr($f_alta_sen1,6,4).substr($f_alta_sen1,2,4).substr($f_alta_sen1,0,2)."','";
  $act=$act.substr($f_vto_nac,6,4) .substr($f_vto_nac,2,4) .substr($f_vto_nac,0,2) ."', '".substr($f_vto_prov,6,4) .substr($f_vto_prov,2,4) .substr($f_vto_prov,0,2) ."', '".substr($f_vto_dep,6,4) .substr($f_vto_dep,2,4) .substr($f_vto_dep,0,2) ."', '".substr($f_vto_sen1,6,4) .substr($f_vto_sen1,2,4) .substr($f_vto_sen1,0,2)."',";
  $act=$act.$colmenas.",".$nucleos.",".$prod_anual.",".$pers_id.",".$opera."  )"; 
  $rs_validar = mysql_query($act,$cx_validar);
   act_col_cam($prov_id,$campo_id);
}
$act="select * from  ".$_SESSION["tabla_campos"]. " where prov_id=".$prov_id.' and campo_id='.$campo_id ;
$rs_validar = mysql_query($act,$cx_validar);
while ($v_validar = mysql_fetch_array($rs_validar))
  {
    $campo_id= $v_validar[0];
    $prov_id= $v_validar[1];
    $nombre= $v_validar[2];
    $dir1= $v_validar[3];
    $dir2= $v_validar[4];
    $localidad=$v_validar[5];
    $cod_postal=$v_validar[6];
    $provincia=$v_validar[7];
    $pais=$v_validar[8];
    $lat=$v_validar[9];
    $lon=$v_validar[10];

    $reg_nac=$v_validar[11];

    $f=$v_validar[12];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_alta_nac=$f;

    $f=$v_validar[13];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_vto_nac=$f;



    $reg_prov=$v_validar[14];

    $f=$v_validar[15];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_alta_prov=$f;

    $f=$v_validar[16];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_vto_prov=$f;


    $reg_dep=$v_validar[17];

    $f=$v_validar[18];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_alta_dep=$f;

    $f=$v_validar[19];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_vto_dep=$f;



    $reg_sen1=$v_validar[20];

    $f=$v_validar[21];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_alta_sen1=$f;

    $f=$v_validar[12];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_vto_sen1=$f;


    $reg_sen2=$v_validar[23];

    $f=$v_validar[24];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_alta_sen2=$f;

    $f=$v_validar[25];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_vto_sen2=$f;
    



    $reg_sen3=$v_validar[26];

    $f=$v_validar[27];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_alta_sen3=$f;

    $f=$v_validar[28];
    $f=substr($f,-2).substr($f,4,4).substr($f,0,4);
    $f_vto_sen3=$f;



    $contacto=$v_validar[29];
    $tel=$v_validar[30];
    $cel=$v_validar[31];
    $fax=$v_validar[32];
    $nextel=$v_validar[33];
    $email=$v_validar[34];
    $sector=$v_validar[35];
    $contacto1=$v_validar[36];
    $tel1=$v_validar[37];
    $cel1=$v_validar[38];
    $email1=$v_validar[39];
    $sector1=$v_validar[40];
    $contacto2=$v_validar[41];
    $tel2=$v_validar[42];
    $cel2=$v_validar[43];
    $email2=$v_validar[44];
    $sector2=$v_validar[45];
    $cond_iva=$v_validar[46];
    $nro_cuit=$v_validar[47];
    $colmenas=$v_validar[48];
    $nucleos=$v_validar[49];
    $prod_anual=$v_validar[50];
    $fecha_ult_mov=$v_validar[51];
    $nro_mov=$v_validar[52];
    $tipo_mov=$v_validar[53];
    $pers_id=$v_validar[54];
    $op=$v_validar[55];
    $abrev=$v_validar[56];
  }
$provedor='';
$actualizar='select razon_social from  ' .$_SESSION["tabla_provedores"].' where prov_id='.$prov_id;
$rs_validar = mysql_query($actualizar,$cx_validar);
while ($v_validar = mysql_fetch_array($rs_validar)) { $provedor= $v_validar[0];}

  $act1="select cod_iva from  ".$_SESSION["tabla_iva"]." where cod_iva<>"."'".$cond_iva."'" ;  ;
  $rs_validar1 = mysql_query($act1,$cx_validar); 
//   border="3" cellspacing="3" cellpadding="5"
    echo '<table border="1" ><tr><td>';

    echo '<table border="1">';
    echo "<caption color style='background:#99FF33'> Datos del Campo ".$campo_id.'&nbsp;&nbsp;-&nbsp;&nbsp;Provedor:'.$provedor.'  </caption>';
    echo '<tr><td>Raz&oacute;n Social:';
    echo "&nbsp;"."<input name='abrev' type='text'  value="."'".$abrev."'"."  size='7' maxlength='7'>";
    echo "&nbsp;"."<input name='nombre' type='text'  value="."'".$nombre."'"."  size='50' maxlength='50'>";
    echo "</td></tr>";
    
    echo  '<tr><td>Condici&oacute;n de Iva:'."&nbsp";

    echo  '<select name="cond_iva" id="cond_iva">';
    echo  "<option value="."'".$cond_iva."'>".$cond_iva."</option>";
     while ($v_validar1 = mysql_fetch_array($rs_validar1))
     { if ($v_validar1[0]==$cond_iva){}
       else { echo  "<option value="."'".$v_validar1[0]."'>".$v_validar1[0]."</option>"; }
     }
    echo  "&nbsp".'N&uacute;mero  de Cuit:'."&nbsp";
    echo "<input name='nro_cuit' ID='nro_cuit' type='text'  value="."'".$nro_cuit."'"."  size='13' maxlength='13'>";

    echo  "&nbsp;&nbsp;&nbsp;Lo Atendi&oacute;&nbsp";
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
 
    echo '</td></tr>';

    echo  "<tr><td witdh='1%'>N&uacutemero de Colmenas";
    echo "<input name='colmenas' type='text' id=colmenas  value="."'".$colmenas."' size='5' maxlength='5'>&nbsp;&nbsp;N&uacutecleos&nbsp;";
    echo "<input name='nucleos' type='text' id='nucleos'  value="."'".$nucleos."' size='5' maxlength='5'>&nbsp;&nbsp;Producci&oacuten Anual&nbsp;";
    echo "<input name='prod_anual' type='text' id='prod_anual'  value="."'".$prod_anual."' size='8' maxlength='8'>&nbsp;en Kgr.</td></tr>";

    echo  "<tr><td witdh='1%'>&Uacuteltimo Movimiento:&nbsp;Fecha:".substr($fecha_ult_mov,-2).substr($fecha_ult_mov,4,4).substr($fecha_ult_mov, 0,4);
    echo "&nbsp;&nbsp;Tipo&nbsp;".$tipo_mov."&nbsp;&nbsp;N&uacute;mero:".$nro_mov."</td></tr>";


    echo '<tr><td><table border="0" width="100%">';
    echo '<tr>';
    echo  "<td witdh='1%'>Dirección</td>";
    echo "<td><input name='dir1' type='text' id=dir1  value="."'".$dir1."' size='50' maxlength='50'>&nbsp;&nbsp;Latitud&nbsp;&nbsp;";
    echo "<input name='lat' type='text' id='lat'  value="."'".$lat."' size='10' maxlength='15'>";

    echo '</tr><tr>';
    echo  "<td></td>";
    echo "<td><input name='dir2' type='text' id=dir2  value='".$dir2."' size='50' maxlength='50'>&nbsp;&nbsp;Longitud&nbsp;";
    echo "<input name='lon' type='text' id='lon'  value="."'".$lon."' size='10' maxlength='15'>";

    echo "</tr>";


    echo '<tr>';
    echo  "<td align='right'>Localidad</td>";
    echo "<td><input name='localidad' type='text' id='localidad'  value="."'".$localidad."'"."  size='30' maxlength='30'>";
    echo "&nbsp;C&oacute;d.Postal&nbsp;<input name='cod_postal' type='text' id=cod_postal  value="."'".$cod_postal."'"."  size='5' maxlength='5'></td></tr>";
    echo "<tr><td align='right'>Provincia&nbsp;</td><td><input name='provincia' type='text' id='provincia'  value="."'".$provincia."'"."  size='20' maxlength='20'>";
    echo "&nbsp;Pais.&nbsp;<input name='pais' type='text' id='pais'  value="."'".$pais."'"."  size='20' maxlength='20'></td></tr>";

    echo '<tr><td colspan=2><hr></td></tr>';
    
    echo '<tr><td>Contacto</td>';
    echo "<td><input name='contacto' type='text' id='contacto'  value='".$contacto."' size='30' maxlength='30'>";
    echo "&nbsp;&nbsp;&nbsp;Sector&nbsp;<input name='sector' type='text' id='sector'  value='".$sector."' size='15' maxlength='20'></td>";
    echo '</tr>';
    echo "<tr><td align='right'>Telefono</td>";
    echo "<td><table><td><input name='tel' type='text' id='tel'  value='".$tel."' size='30' maxlength='30'></td>";
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
   echo '</tr><tr><td colspan=2><hr></td>';
 
   echo '</tr><tr>';
    echo '<tr><td>Contacto</td>';
    echo "<td><input name='contacto2' type='text' id='contacto2'  value='".$contacto2."' size='30' maxlength='30'>";
    echo "&nbsp;&nbsp;&nbsp;Sector&nbsp;<input name='sector2' type='text' id='sector2'  value='".$sector2."' size='15' maxlength='15'></td>";
    echo '</tr>';
    echo "<tr><td align='right'>Telefono</td>";
    echo "<td><table><td><input name='tel2' type='text' id='tel2'  value='".$tel2."' size='15' maxlength='15'></td>";
    echo  '<td>Cel</td>';
    echo "<td><input name='cel2' type='text' id='cel2' value="."'".$cel2."'"."  size='15' maxlength='15'></td>";
    echo "<td>email</td><td><input name='email2' type='text' id='email2' value="."'".$email2."'"."  size='12' maxlength='30'></td>";
    echo "</table>";
 
echo '</tr><tr><td colspan=2><hr></td>';
 
   echo '</tr>';
   echo '<tr><table><td colspan="2" align="right">Registros RENAPA</td><td align="right">Provincial</td><td align="right">Municipal</td><td align="right">Senasa</td></tr>';
    echo '<tr><td>N&uacute;mero</td>';
    echo "<td><input name='reg_nac' type='text' id='reg_nac'  value='".$reg_nac."' size='13' maxlength='13'></td>";
    echo "<td><input name='reg_prov' type='text' id='reg_prov'  value='".$reg_prov."' size='13' maxlength='13'></td>";
    echo "<td><input name='reg_dep' type='text' id='reg_dep'  value='".$reg_dep."' size='13' maxlength='13'></td>";
    echo "<td><input name='reg_sen1' type='text' id='reg_sen1'  value='".$reg_sen1."' size='13' maxlength='13'></td>";
   echo '</tr><tr>';
    echo '<tr><td>Fec.Alta</td>';
    echo "<td align='right'><input name='f_alta_nac' type='text' id='f_alta_nac'  value='".$f_alta_nac."' size='10' maxlength='10'></td>";
    echo "<td align='right'><input name='f_alta_prov' type='text' id='f_alta_prov'  value='".$f_alta_prov."' size='10' maxlength='10'></td>";
    echo "<td align='right'><input name='f_alta_dep' type='text' id='f_alta_dep'  value='".$f_alta_dep."' size='10' maxlength='10'></td>";
    echo "<td align='right'><input name='f_alta_sen1' type='text' id='f_alta_sen1'  value='".$f_alta_sen1."' size='10' maxlength='10'></td>";
   echo '</tr><tr>';
    echo '<tr><td>Fec.Vto.</td>';
    echo "<td align='right'><input name='f_vto_nac' type='text' id='f_vto_nac'  value='".$f_vto_nac."' size='10' maxlength='10'></td>";
    echo "<td align='right'><input name='f_vto_prov' type='text' id='f_vto_prov'  value='".$f_vto_prov."' size='10' maxlength='10'></td>";
    echo "<td align='right'><input name='f_vto_dep' type='text' id='f_vto_dep'  value='".$f_vto_dep."' size='10' maxlength='10'></td>";
    echo "<td align='right'><input name='f_vto_sen1' type='text' id='f_vto_sen1'  value='".$f_vto_sen1."' size='10' maxlength='10'></td>";

   echo '</tr>';
    
    echo '</table>';
      echo '</tr>';
 

echo "</table>";

   echo "<INPUT TYPE=HIDDEN name='num_reg_desde'  value="."'".$_SESSION[reg_desde]."'>";
   echo "<INPUT TYPE=HIDDEN name='num_reg_hasta'  value="."'".$_SESSION[reg_hasta]."'>";
   echo "<INPUT TYPE=HIDDEN name='prov_id'  value="."'".$prov_id."'>";
   echo "<INPUT TYPE=HIDDEN name='campo_id'  value="."'".$campo_id."'>";

   if ($boton=="Baja"){   echo "<br>C&oacute;digo de Seguridad "."<INPUT TYPE=INPUT name='contr' ID='contr'  value='".$contr."'>"; }
   



echo "<table border='2'  width='100%'><tr>";
echo "<caption color style='background:#99FF33'> Acciones Definidas para el Usuario </caption>"     ;  
echo '<td><span onclick="oprimo(1);">Volver</span>';
if ($modifica=='on'){echo '<span onclick="oprimo(2);">Guardar</span>';}
echo'<span onclick="oprimo(3);">Imprimir</span>';
if ($alta=='on'){echo '<span onclick="oprimo(4);">Alta</span>';}
if ($baja=='on'){echo '<span onclick="oprimo(5);">Borrar</span>';}
echo '<span onclick="oprimo(6);">Colmenas</span>';
echo '</td></tr></table>';


   echo "<INPUT TYPE=HIDDEN name='accion' id='accion' value='".$accion."'>";
   echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'>";?>
  <article class="row">
    <article class="span11">
      <article id="map"></article>
    </article>
  </article></td></table>
  </form>
<script type="text/javascript">
  Calendar.setup({
      inputField     :    "f_alta_nac",   // id of the input field
      ifFormat       :    "%d-%m-%Y",       // format of the input field
      showsTime      :    false,
    timeFormat     :    "24"  });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_alta_prov",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
      timeFormat     :    "24"  });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_alta_dep",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
      timeFormat     :    "24"  });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_alta_sen1",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
      timeFormat     :    "24"  });
</script>
<script type="text/javascript">
  Calendar.setup({
      inputField     :    "f_vto_nac",   // id of the input field
      ifFormat       :    "%d-%m-%Y",       // format of the input field
      showsTime      :    false,
    timeFormat     :    "24"  });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_vto_prov",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
      timeFormat     :    "24"  });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_vto_dep",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
      timeFormat     :    "24"  });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_vto_sen1",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
      timeFormat     :    "24"  });
</script>

</BODY>
</HTML>

