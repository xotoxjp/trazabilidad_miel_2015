<?php
session_start();
include_once("funciones.php");
$_SESSION["level_req"]="f";
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
validar ($logg,$pass);
$nivel_dato=$_SESSION["acceso_acc"];
$orden='-';
$contr="";$respuesta="";$xLote='off'; $accion=' ';
$salto='Si';$crear='-'; $alta=' ';
 $_SESSION[reg_desde]= $_POST["num_reg_desde"];
 $_SESSION[reg_hasta]= $_POST["num_reg_hasta"];
$si_marca='on';

$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='alta_acoenv1.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);
$items_unit=' ';$tipo_producto=' ';
$trae='';$respue='-';$igual_prov="SI";$prov_ant=0;$num_sel=0;$campo_ant=0;
$lote_array[]=-1;$c_ana=0;
$pasax_ue='Si';$pasa='No';
foreach ($_GET as $indice => $valor) {
  switch ($indice) {
    case 'r': $accion=$valor;
      $a='select distinct marca2 FROM '.$_SESSION["tabla_respuesta"]." where login='".$_SESSION["acceso_logg"]."' and respuesta='emb'"; 
      $r=mysql_query($a,$cx_validar);
      while ($v = mysql_fetch_array($r)) {
        $nro_emb=$v[0];
      }

      $a='select doc_transp,nombre_transp,validez,temperatura,pasax_ue,especie_id,items_unit,tipo_producto,mu_nitro_xcon,dire_veri,marca,precio_fob,';
      $a=$a.'fecha_ana,lugar_ana,aut_senasa,contenedor,precinto_ad,contrato,color,fecha_emb,fecha_soli,hora_emb,nro_preemb,puerto,lote_emb  from ';
      $a=$a.$_SESSION["tabla_mov_embarque"].' where nro_emb="'.$nro_emb.'"' ;
      $r=mysql_query($a,$cx_validar);
      while ($v = mysql_fetch_array($r)) {
         $doc_transp=$v[0];
         $nombre_transp=$v[1];
         $validez=$v[2];
         $temperatura=$v[3];
         $pasax_ue=$v[4];
         $especie_id=$v[5];
         $items_unit=$v[6];
         $tipo_producto=$v[7];
         $mu_nitro_xcon=$v[8];
         $dire_veri=$v[9];
         $marca=$v[10];
         $precio_fob=$v[11];
         $fecha_ana=$v[12];
         $lugar_ana=$v[13];
         $aut_senasa=$v[14];
         $contenedor=$v[15];
         $precinto_ad=$v[16];
         $contrato=$v[17];
         $color=$v[18];
         $fecha_inicial=$v[19];$fecha_emb=$v[19];
         $fecha_soli=$v[20];
         $hora_inicio=$v[21];
         $nro_mov_a=$v[22];
         $puerto=$v[23];
         $lote_emb=$v[24];
         
         $fecha_ini=substr($v[19],-2).substr($v[19],4,4).substr($v[19],0,4);
         $hora_ini=substr($v[21],0,2);$minu_ini=substr($v[21],3,2);
         $fecha_analisis=substr($fecha_ana,-2).substr($fecha_ana,4,4).substr($fecha_ana,0,4) ; 
         $fecha_solicitud=substr($fecha_soli,-2).substr($fecha_soli,4,4).substr($fecha_soli,0,4) ; 
      }
      break;
  }
}


foreach ($_POST as $indice => $valor) {
  switch ($indice) {
    case 'fecha_ini': $fecha_ini=$valor;$fecha_inicial=substr($valor,-4).substr($valor,2,4).substr($valor, 0,2) ; break;
    case 'hora_ini': $hora_ini=$valor ; break;
    case 'minu_ini': $minu_ini=$valor ; break;
    case 'hora_inicio': $hora_inicio=$valor ; break;
    case 'pers_ini': $pers_ini=$valor;
    case 'contr': $contr=$valor; break;
    case 'ID' : $ID=$valor; break ;
    case 'aut_senasa': $aut_senasa=$valor; break;
    case 'contenedor': $contenedor=$valor; break;
    case 'precinto_ad': $precinto_ad=$valor; break;
    case 'contrato': $contrato=$valor; break;
    case 'color': $color=$valor; break;
    case 'puerto': $puerto=$valor; break;
    case 'lote_emb': $lote_emb=$valor; break;
    case 'marca': $marca=$valor; break;
    case 'precio_fob': $precio_fob=$valor; break;
    case 'fecha_analisis': $fecha_analisis=$valor; $fecha_ana  =substr($valor,-4).substr($valor,2,4).substr($valor, 0,2) ; break;
    case 'fecha_solicitud': $fecha_solicitud=$valor;$fecha_soli=substr($valor,-4).substr($valor,2,4).substr($valor, 0,2) ; break;
    case 'lugar_ana': $lugar_ana=$valor; break;
    case 'dire_veri': $dire_veri=$valor; break;
    case 'mu_nitro_xcon': $mu_nitro_xcon=$valor; break;
    case 'tipo_producto': $tipo_producto=$valor; break;
    case 'items_unit': $items_unit=$valor; break;
    case 'especie_id': $especie_id=$valor; break;
    case 'validez': $validez=$valor; break;
    case 'temperatura': $temperatura=$valor; break;
    case 'validez':$validez=$valor;break;
    case 'pasax_ue': $pasa='Si';break;
    case 'nombre_transp': $nombre_transp=$valor ;break;
    case 'doc_transp': $doc_transp=$valor ;break;
    case 'nro_emb' : $nro_emb=$valor; break ;
    case 'nro_mov' : $nro_mov=$valor; break ;
    case 'accion' : $accion=$valor; break ;
  }
}
if ($pasa=='No') { $pasax_ue=$pasa;}

$a='select marca1,marca2,valor1,valor2 FROM '.$_SESSION["tabla_respuesta"]." where login='".$_SESSION["acceso_logg"]."' and respuesta='emb'"; 
$r=mysql_query($a,$cx_validar);
// actualizo los registros anteriores en el mov_detalle y luego doy de alta nuevos registros en mov_detalle y mov_lotes
while ($v = mysql_fetch_array($r)) {
  $tm=$v[0];$nro_mov_a=$v[1];$lote=$v[2];break;}

$a='SELECT transporte from '.$_SESSION["tabla_mov_embarque"].' where nro_preemb="'.$nro_mov_a.'"';
$r=mysql_query($a,$cx_validar);
while ($v = mysql_fetch_array($r)) {$transporte=$v[0];break;}



if ($ID=="A1"){

  if (strlen($dire_veri)<2){
    $a="select dir1,localidad,provincia from  ".$_SESSION["tabla_almacenes"] .' where almacen_id='.$lugar_ana ;
    $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {$dire_veri=$v[0].'-'.$v[1].'-'.$v[2];break;}
  }

  $a2='UPDATE '.$_SESSION["tabla_mov_embarque"].' set  doc_transp="'.$doc_transp.'",nombre_transp="'.$nombre_transp.'", validez='.$validez.',temperatura="'.$temperatura.'",pasax_ue="'.$pasax_ue.'",especie_id='.$especie_id.'    ,items_unit="'.$items_unit.'",tipo_producto="'.$tipo_producto.'", mu_nitro_xcon="'.$mu_nitro_xcon.'",dire_veri="'.$dire_veri.'", marca="'.$marca.'",precio_fob='.$precio_fob.',fecha_ana="'.$fecha_ana.'",lugar_ana='.$lugar_ana.',aut_senasa="'.$aut_senasa.'",contenedor="';
  $a2=$a2.$contenedor.'",precinto_ad="'.$precinto_ad.'",contrato='.$contrato.',color="'.$color.'",puerto="'.$puerto.'",lote_emb="'.$lote_emb.'",fecha_emb="'.$fecha_inicial.'",fecha_soli="'.$fecha_soli.'",hora_emb="'.$hora_inicio.'"';
  $a2=$a2.' where nro_emb="'.$nro_emb.'"';
  mysql_query($a2,$cx_validar);
  header("Location: embarque1.php"); echo '1';
}

?>
<head>
<TITLE>DATOS DE EMBARQUE</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="botones.css" />
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="lang/calendar-es.js"></script>
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="shortcut icon" href="fotos/barco.jpg">
<style type="text/css">
.a {display: none;}
#ent {display: none;}
.oculto {display: none;}
.visible {display: inline;color: red;}

</style>

<script type="text/javascript">

function nueva_nota(elemento){

  listahi=document.getElementById('hora_ini');var vhi = 1*listahi.value;
  listami=document.getElementById('minu_ini');var vmi = 1*listami.value;
  var tx3="";
  if (vhi>9) {tx3=vhi+":";} else {tx3="0"+vhi+":";}
  if (vmi>9) {tx3=tx3+vmi;} else {tx3=tx3+"0"+vmi;}
  tx31=document.getElementById('hora_inicio');tx31.value=tx3;
 
  tx=document.getElementById('Eleccion');tx.value="A1";
  btn=document.getElementById('ent');
  btn.click();
}



function marcar(elemento)
 {btn=document.getElementById('vuelta');
  btn.click();}

-->
</script>
</head>
<?
echo "<body>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='alta_emb2.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
echo '<table border="1"><tr><th colspan="3">CARGA DE EMBARQUE:'.$nro_emb.'</th></tr>';

echo '<tr><td>&nbsp;Autorizaci&oacute;n SENASA&nbsp;</td><td><input type="TEXT" NAME="aut_senasa" id="aut_senasa" value="'.$aut_senasa.'"  placeholder ="A1653" size="7" maxlength="7" required/>';
echo '</td><td>Fecha de la Solicitud&nbsp;<input type="TEXT" NAME="fecha_solicitud" id="fecha_solicitud"  value="'.$fecha_solicitud.'" size="10" maxlength="10" required/>';

echo '<tr><td rowspan="2">&nbsp;Servicio Requerido&nbsp;</td><td>';
echo '<LABEL class="sele"><input name="validez" type="radio" value="24"';
if ($validez==24){echo ' checked ';}
echo '>24&nbsp;</LABEL>';
echo '<LABEL class="sele"><input name="validez" type="radio" value="48"';
if ($validez==48){echo ' checked ';}
echo '>48&nbsp;</LABEL>';
echo '<LABEL class="sele"><input name="validez" type="radio" value="72"';
if ($validez==72){echo ' checked ';}
echo '>72&nbsp;</LABEL>';
echo '&nbsp;&nbsp;&nbsp;</LABEL>';
echo '</td><td>Temperatura&nbsp;';
echo '<LABEL class="sele"><input name="temperatura" type="radio" value="A"';
if ($temperatura=="A"){echo ' checked ';}
echo '>Ambiente&nbsp;</LABEL>';
echo '<LABEL class="sele"><input name="temperatura" type="radio" value="R"';
if ($temperatura=="R"){echo ' checked ';}
echo '>De Regrigeraci&oacute;n&nbsp;</LABEL>';

echo "</td></tr><td colspan='2'><LABEL class='sele'>&nbsp;<input NAME='pasax_ue' type='checkbox' ";
if ($pasax_ue=='Si') {echo 'checked';} else {$pasax_ue="NO";}
echo '>&nbsp;';
echo 'Para importaci&oacute;n o admisi&oacute;n en UE</LABEL></td></tr>';

echo '<tr><td colspan="3"></td></tr>';
echo '<tr><td colspan="3"></td></tr>';
echo '<tr><td>Identificaci&oacute;n del '.$transporte.'</td><td><input type="TEXT" NAME="nombre_transp" id="nombre_transp"  value="'.$nombre_transp.'" placeholder ="Nombre del Transp." size="20" maxlength="20" required/>';
echo '</td><td>Referencia Documental&nbsp;<input type="TEXT" NAME="doc_transp" id="doc_transp"  value="'.$doc_transp.'" placeholder ="Documentos de Referencia" size="22" maxlength="22" required/>';

echo '<tr><td>&nbsp;Contenedor Nro.&nbsp;</td><td><input type="TEXT" NAME="contenedor" id="contenedor"  value="'.$contenedor.'" placeholder ="Contenedor Nro." size="16" maxlength="16" required/>';
echo '</td><td>Precinto de Aduana&nbsp;<input type="TEXT" NAME="precinto_ad" id="precinto_ad"  value="'.$precinto_ad.'" placeholder ="Nro.Precinto" size="18" maxlength="18" required/>';
echo '<tr><td>&nbsp;Contrato&nbsp;</td><td><input type="TEXT" NAME="contrato" id="contrato"  value="'.$contrato.'" placeholder ="1301203" size="8" maxlength="8" required/>';


echo '</td><td>Precio FOB (U$S)<input type="TEXT" NAME="precio_fob" id="precio_fob"  value="'.$precio_fob.'" placeholder ="2.675" size="6" maxlength="6" required/></td></tr>';

echo '<tr><td>&nbsp;Puerto de Destino</td><td colspan="2"><input type="TEXT" NAME="puerto" id="puerto"  value="'.$puerto.'" placeholder ="Philadelphia" size="25" maxlength="25" required/>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lote del Embarque&nbsp;<input type="TEXT" NAME="lote_emb" id="lote_emb"  value="'.$lote_emb.'" placeholder ="Nro.de Lote" size="12" maxlength="12" required/>';
echo '</td></tr>';

echo '<tr><td colspan="3"></td></tr>';
echo '<tr><td colspan="3"></td></tr>';

echo '<tr><td colspan="3">Esp.&nbsp;';
$a="select * from  ".$_SESSION["tabla_especie"];  //11  1 + 3 + 7
$r1 = mysql_query($a,$cx_validar);
echo  '<select name="especie_id" id="especie_id">';
while ($v1 = mysql_fetch_array($r1)){ 
  echo  "<option value="."'".$v1[0]."'";
  if ($especie_id==0) {echo ' SELECTED ';$especie_id=$v1[0];}
  echo ">".trim($v1[1].' '.$v1[2].' '.$v1[3]).' - '.trim($v1[4].' '.$v1[5].' '.$v1[6].' '.$v1[7].' '.$v1[8].' '.$v1[9].' '.$v1[10] )."</option>"; 
}
echo '</select></td></tr>';

echo '<tr><td>&nbsp;Color&nbsp;</td><td><input type="TEXT" NAME="color" id="color"  value="'.$color.'" placeholder ="AMBAR CLARO" size="20" maxlength="20" required/>';
echo '</td><td>Tipo de Producto:&nbsp;';

$a="select tipo from  ".$_SESSION["tabla_tipo_producto"];
$r1 = mysql_query($a,$cx_validar);
echo  '<select name="tipo_producto" id="tipo_producto">';
while ($v1 = mysql_fetch_array($r1)){ 
  echo  "<option value="."'".$v1[0]."'";
  if (($tipo_producto==' ') or ($tipo_producto==$v1[0])) {echo ' SELECTED ';$tipo_producto=$v1[0];}
  echo ">".$v1[0]."</option>"; 
}
echo '</select></td></tr>';

echo '<tr><td>&nbsp;Marca</td><td><input type="TEXT" NAME="marca" id="marca" value="'.$marca.'" placeholder ="S/M" size="15" maxlength="15" required/>';

echo '</td><td>Items a Embarcar:&nbsp;';
$a="select tipo from  ".$_SESSION["tabla_tipo_items"];
$r1 = mysql_query($a,$cx_validar);
echo  '<select name="items_unit" id="items_unit">';
while ($v1 = mysql_fetch_array($r1)){ 
  echo  "<option value="."'".$v1[0]."'";
  if (($items_unit==' ') or ($items_unit==$v1[0])) {echo ' SELECTED ';$items_unit=$v1[0];}
  echo ">".$v1[0]."</option>"; 
}
echo '</select></td></tr>';

echo '<tr><td colspan="3"></td></tr>';
echo '<tr><td colspan="3"></td></tr>';

echo '<tr><td colspan="3" align="CENTER">Datos del An&aacute;lisis<br>';
echo '<tr><td>&nbsp;Fecha</td><td colspan="2"><input type="TEXT" NAME="fecha_analisis" id="fecha_analisis"   value="'.$fecha_analisis.'" size="10" maxlength="10" required/>';
echo '&nbsp;&nbsp;&nbsp;Muestras Nitrofurano x Contenedor (0=no toma):';
echo '<input type="number" name ="mu_nitro_xcon" id ="mu_nitro_xcon" min=0 max=3 size="1" maxlength="1"  value="'.$mu_nitro_xcon.'"  placeholder ="1" required/>';

echo '<tr><td>&nbsp;Dep&oacute;sito</td><td colspan="2">';
$a="select almacen_id,razon_social,dir1,localidad from  ".$_SESSION["tabla_almacenes"] .' where tipo_almacen=2 or tipo_almacen=4' ;
$r1 = mysql_query($a,$cx_validar);
echo  '<select name="lugar_ana" id="lugar_ana">';
while ($v1 = mysql_fetch_array($r1)){ 
  echo  "<option value="."'".$v1[0]."'";
  if (($lugar_ana==0) or ($lugar_ana==$v1[0])) {echo ' SELECTED ';$lugar_ana=$v1[0];}
  echo ">".$v1[0].'-'.$v1[1].'-'.$v1[2].'-'.$v1[3].'-'."</option>"; 
}
echo '</select></td></tr>';
echo '<tr><td>&nbsp;Direcci&oacute;n de Verificaci&oacute;n</td><td colspan="2"><input type="TEXT" NAME="dire_veri" id="dire_veri"  value="'.$dire_veri.'" placeholder ="Si no coloca nada toma la del lugar" size="60" maxlength="60">';



echo '<tr><td colspan="3" align="CENTER">Por Favor. Complete los Datos del Embarque<br>';
echo 'Cuando se Embarca, la Hora estimada y el responsable</td></tr>';
echo '<tr><td>&nbsp;Fecha&nbsp;</td><td colspan="2"><input type="TEXT" NAME="fecha_ini" id="fecha_ini"   size="10" maxlength="10"  value="'.$fecha_ini.'"  placeholder ="Se enviar&aacute el" required/>';
echo '&nbsp;&nbsp;&nbsp;Hora:(HH:MM)&nbsp;';
echo '<input type="number" name ="hora_ini" id ="hora_ini" min=7 max=20 size="2" maxlength="2" value="'.$hora_ini.'" placeholder ="08" required/>';
echo ':<input type="number" name ="minu_ini" id ="minu_ini"min=0 max=59 size="2" maxlength="2" value="'.$minu_ini.'" placeholder ="30"required/>';
echo '&nbsp;&nbsp;&nbsp;Responsable&nbsp;';

$actualizar1="select id_usuario,login from  ".$_SESSION["tabla_acc"]." where op_campo='Si'" ;
$rs_validar1 = mysql_query($actualizar1,$cx_validar);
echo  '<select name="pers_ini" id="pers_ini">';
while ($v_validar1 = mysql_fetch_array($rs_validar1)){ 
  echo  "<option value="."'".$v_validar1[0]."'";
  if (($pers_ini==0) or ($pers_ini==$v1[0])) {echo ' SELECTED ';$lugar_ana=$v1[0];}
  echo '>'.$v_validar1[1].'</option>'; 
}
echo '</select>';
echo '</td></tr>';

echo '<tr><td>&nbsp;</td><td colspan="2"><span onclick="marcar(1);">Vuelve</span><span onclick="nueva_nota(this);">Procesa</span></td></tr></table>';
echo "<a href='embarque1.php' id='vuelta'></a>";
echo "<INPUT TYPE=HIDDEN NAME='hora_inicio' id='hora_inicio' VALUE=''>";
echo "<INPUT TYPE=HIDDEN NAME='hora_final' id='hora_final' VALUE=''>";
echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";
echo "<INPUT TYPE=HIDDEN NAME='nro_emb' id='nro_emb' VALUE='".$nro_emb."'>";

echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
?>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_ini",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
        disableDateBefore: "4-10-2012",
      timeFormat     :    "24"  });
    Calendar.setup({
        inputField     :    "fecha_analisis",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
        disableDateBefore: "4-10-2012",
      timeFormat     :    "24"  });
    Calendar.setup({
        inputField     :    "fecha_solicitud",   // id of the input field
        ifFormat       :    "%d-%m-%Y",       // format of the input field
        showsTime      :    false,
        disableDateBefore: "4-10-2012",
      timeFormat     :    "24"  });

</script>
</BODY>
</HTML>

