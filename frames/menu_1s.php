<?
session_start();
include_once("funciones.php");
$_SESSION["level_req"]="a";
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
validar ($logg,$pass);
$nivel_dato=$_SESSION["acceso_acc"];
$nivel_dato=$_SESSION["acceso_acc"];

$id_uauario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$cta1 = array('','','','','','','','','','','','');
$nta2 = array('','','','','','','','','','','','');

$ta1[1]="CLIENTES";$ta2[1]="Clientes";
$ta1[2]="PROVEDORES";$ta2[2]="Provedores";
$ta1[3]="ALMACENES";$ta2[3]="Almacenes";
$ta1[4]="PRODUCTOS";$ta2[4]="Productos";
$ta1[5]="PRIMARIOS";$ta2[5]="Envases Primarios";
$ta1[6]="SECUNDARIOS";$ta2[6]="Envases Secundarios";
$ta1[7]="TERCIARIOS";$ta2[7]="Envases Terciarios";
$ta1[8]="MOVIMIENTOS";$ta2[8]="Tipos de Movimientos";
$ta1[9]="ANALISIS";$ta2[9]="Tipos de Analisis";
$ta1[10]="TIPOALMA";$ta2[10]="Tipos de Almacenes";

$ItemsTablas=0;
$a='SELECT acceso,orden,proceso,pantalla FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Tablas" order by orden asc';
$r=mysql_query($a,$cx_validar);
while ($v = mysql_fetch_array($r)) {
  $ItemsTablas++;
  $cta[$ItemsTablas]=$ta1[$v[1]];
  $nta[$ItemsTablas]=$ta1[$v[1]];
}

$cim1 = array('','','','','','','','','','','','');
$nim2 = array('','','','','','','','','','','','');

$im1[1]="ACTA";$im2[1]="Libro de Actas";
$im1[2]="SENASA";$im2[2]="Certificados Senasa";
$im1[3]="CERTNAC";$im2[3]="Cert. Nacionales";
$im1[4]="CERTPROV"$;im2[4]="Cert. Provinciales";
$im1[5]="CERTLOC";$im2[5]="Cert. Locales";

$ItemsImprimir=0;
$a='SELECT acceso,orden,proceso,pantalla FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Imprime" order by orden asc';
$r=mysql_query($a,$cx_validar);
while ($v = mysql_fetch_array($r)) {
  $ItemsImprimir++;
  $cta[$ItemsImprimir]=$ta1[$v[1]];
  $nta[$ItemsImprimir]=$ta1[$v[1]];
}


$cpr1 = array('','','','','','','','','','','','');
$npr2 = array('','','','','','','','','','','','');

$pr1[1]="MOV_ENTRE_CAMPOS";    $pr2[1]="Mov.de Colmena entre Campos";
$pr1[2]="MOV_COL_EXT";         $pr2[2]='Colmenas a Sala de Extracci&oacute;n';
$pr1[3]="EXTRACCION";          $pr2[3]='Extracci&oacute;n';
$pr1[4]="MOV_ANALISIS";        $pr2[4]='An&aacute;lisis de Productos';
$pr1[5]="MOV_EXTR_ACOPIO";     $pr2[5]='Desde Extracci&oacute;n a Acopio';
$pr1[6]="MOV_EXTR_ENVASADO";   $pr2[6]='Desde Extracci&oacute;n a Envasado';
$pr1[7]="MOV_ACOPIO_EMBASADO"; $pr2[7]="Desde Acopios a Envasado";
$pr1[8]="REPROCESO";           $pr2[8]="Reprocesos de Productos";
$pr1[9]="MOV_PROD_TERMINADO";  $pr2[9]="Traslados de Producto Terminado";
$pr1[10]="ORD_EMBARQUE";       $pr2[10]="Ordenes de Embarque";
$pr1[11]="REMITOS";            $pr2[11]="Remitos";
$pr1[12]="STOCK";              $pr2[12]="Stock";
$ItemsProcesos=0;
$a='SELECT acceso,orden,proceso,pantalla FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" order by orden asc';
$r=mysql_query($a,$cx_validar);
while ($v = mysql_fetch_array($r)) {
  $ItemsProcesos++;
  $cta[$ItemsProcesos]=$ta1[$v[1]];
  $nta[$ItemsProcesos]=$ta1[$v[1]];
}




$_SESSION["filtro_cod_mov"]="";
$_SESSION["filtro_movil"]="";
$_SESSION["filtro_chapa"]="";
$_SESSION["filtro_chofer"]="";
$_SESSION[entrax]=".";
$_SESSION[id_tipo]=".";
$_SESSION[id_familia]=".";
$_SESSION[id_cliente]="";
$_SESSION[id_operador]=".";
$_SESSION[filtro_nombre]="";
$_SESSION[filtro_localidad]="";
$_SESSION[filtro_direccion]="";
$_SESSION[filtro_id_cli]="";
$_SESSION[filtro_cod_prov]="";
$_SESSION[filtro_provincia]="";
$_SESSION[filtro_codigo_postal]="";
$_SESSION[filtro_cod_localidad]="";
$_SESSION[filtro_localidad]="";
$_SESSION[reg_desde_cp]="0";
$_SESSION[reg_hasta_cp]="100";
$_SESSION[filtro_concepto]="";
$_SESSION[filtro_tipo]="";
$_SESSION[filtro_familia]="";
$_SESSION[filtro_producto]="";
$_SESSION[filtro_id_producto]="";
$_SESSION[filtro_capacidad]="";
$_SESSION[filtro_mescontrol]="";
$_SESSION[filtro_Descripcion]="";
$_SESSION[filtro_Abreviatura]="";
$_SESSION[filtro_id_familia]="";
$_SESSION[filtro_fec_fac]='';
$_SESSION[filtro_tipo_fac]='';
$_SESSION[filtro_nro_fact]='';
$_SESSION[filtro_operador]='';
$_SESSION[filtro_estado]='';
$_SESSION[filtro_servicio]='';
$_SESSION[filtro_cumplio]='';
$_SESSION[filtro_cubierta]='';
$_SESSION[filtro_suc]='';
$_SESSION[filtro_novedad]='';
$_SESSION[filtro_npcli]='';
$_SESSION[filtro_fpcli]='';
$_SESSION[respu]='';
$_SESSION[filtro_feci_fac]='';
$_SESSION[filtro_feci_avi]='';
$_SESSION[filtro_feci_pago]='';
$_SESSION[filtro_feci_vto]='';
$_SESSION[filtro_fecf_fac]='';
$_SESSION[filtro_fecf_avi]='';
$_SESSION[filtro_fecf_pago]='';
$_SESSION[filtro_fecf_vto]='';

$_SESSION[filtro_feci_ot]='';
$_SESSION[filtro_fecf_ot]='';
$_SESSION[filtro_ido]='';
$_SESSION[filtro_localidad]='';
$_SESSION[filtro_loc]='';
$_SESSION[filtro_ope]='';
$_SESSION[filtro_items]='';
$_SESSION[filtro_mes]='';
$_SESSION[filtro_id_cliente]='';
$_SESSION[filtro_suc]='';
$_SESSION[filtro_nombre]='';
$_SESSION[filtro_for_pago]='';
$_SESSION[filtro_for_pago]='';
$_SESSION[filtro_cubierta]='';
$_SESSION[filtro_recibo]='';
$_SESSION[filtro_fec_pago]='';
$_SESSION[filtro_fec_vto]='';
$_SESSION[filtro_fpclii]='';
$_SESSION[filtro_fpclif]='';
$_SESSION[filtro_id_operador]="";
$_SESSION[filtro_cod_prov]="";
$_SESSION[filtro_provincia]="";
$_SESSION[filtro_codigo_postal]="";
$_SESSION[filtro_cod_localidad]="";
$_SESSION[filtro_localidad]="";
$_SESSION[filtro_area]="";
$_SESSION[filtro_mes_arranque]="";
$_SESSION[filtro_campo_id]="";
$_SESSION[filtro_nombre]="";
$_SESSION[filtro_direccion]="";
$_SESSION[filtro_localidad]="";
$_SESSION[filtro_provincia]="";
$_SESSION[filtro_pais]="";
$_SESSION[filtro_contacto]="";
$_SESSION[filtro_prov_id]="";
$_SESSION[filtro_provedor]="";




$_SESSION["reg_desde"]=0;
$logg = $_SESSION["acceso_logg"];
$_SESSION[entrax]=" ";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <TITLE><?echo $_SESSION["acceso_logg"]."&nbsp&nbsp";?>MENU  </TITLE>
  <meta name="viewport" content="width=device-width,initial-scale=1">             
  <meta charset="utf-8" />
  <link rel="stylesheet" href="menu_1.css" />

<script type="text/javascript">
<!--
function nueva_nota(elemento)
 {tx=document.getElementById('Eleccion');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();}
-->
</script>




</head>


<body>
<link rel="shortcut icon" href="fotos/chmiel.ico">
<form name='formulario' method='POST' action='menu_1p.php'>

<?
$m=$_SESSION["acceso_nombre"];
if ($i>0) {echo "<FONT COLOR='#FF0000'>Tiene notas sin leer. Saludos</FONT>";}
?>

<table border=0 width="100%"><tr><td width=20%>&nbsp;</td><td align="center" width=60%>
  <img src="fotos/LGMIELCHACO.JPG" alt="Logo de la Empresa" width="180"/></td>

<? echo '<td align="middle" width=20%><img src="fotos/'.$_SESSION["acceso_logg"].'.JPG" alt=" " width="28"/>&nbsp;&nbsp;';
   $l = date("Y-m-d H:i:s"); $l=0+substr($l,11,2); if (($l>=6) and ($l<12)) {echo 'Bu&eacute;n d&iacute;a '.$m;}
   if (($l>=12) and ($l<20)){echo 'Buenas tardes '.$m;} if ( (($l>=20) and ($l<=24)) or $l<6){echo 'Buenas Noches '.$m;}?>
</td></tr></table>

<table border="0" width="100%">
  <tr bgcolor="#192A48" style="font-family: Calibri"><div align="center"><span class="Estilo34" style="color: #FFFFFF; font-size: 24px">MENU DE ENTRADA</span> </tr></table>

<table id="menu_principal" border="1" width="100%">
<tr>
<?
if ($ItemsTablas>0){ echo '<TH width="34%">Tablas</TH>';}
if ($ItemsImprimir>0){ echo '<TH width="34%">Imprime</TH>';}
if ($ItemsProcesos>0){ echo '<TH width="34%">Registros/Procesos</TH>';}
echo '</tr>';
for($renglon=1,$renglon<13,$renglon++){
  
echo '<tr>';
if ($ac_clientes=='on'){ echo '<TD width="34%" onclick='."'".'nueva_nota("CLIENTES")'."'".'>Clientes</TD>';}
?>
  <TD width="33%" onclick='nueva_nota("ACTA")'>Libro de Actas</TD>
  <TD width="33%" onclick='nueva_nota("MOV_ENTRE_CAMPOS")'>Mov.de Colmena entre Campos</TD>
</tr>
<tr>
  <TD onclick='nueva_nota("PROVEDORES")'>Provedores</TD>
  <TD onclick='nueva_nota("SENASA")'>Certificados Senasa</TD>
  <TD onclick='nueva_nota("MOV_COL_EXT")'>Colmenas a Sala de Extracci&oacute;n</TD>
</tr>
<tr>
  <TD onclick='nueva_nota("ALMACENES")'>Almacenes</TD>
  <TD onclick='nueva_nota("CERTNAC")'>Cert.Nacionales</TD>
  <TD onclick='nueva_nota("EXTRACCION")'>Extracci&oacute;n</TD>
</tr>
<tr>
  <TD onclick='nueva_nota("PRODUCTOS")'>Productos</TD>
  <TD onclick='nueva_nota("CERTPROV")'>Cert.Provinciales</TD>
  <TD onclick='nueva_nota("MOV_ANALISIS")'>An&aacute;lisis de Productos</TD>
</tr>
<tr>
  <TD onclick='nueva_nota("PRIMARIOS")'>Envases Primarios</TD>
  <TD onclick='nueva_nota("CERTLOC")'>Cert.Locales</TD>
  <TD onclick='nueva_nota("MOV_EXTR_ACOPIO")'>Desde Extracci&oacute;n a Acopio</TD>
</tr>
<tr>
  <TD onclick='nueva_nota("SECUNDARIOS")'>Envases Secundarios</TD>
  <TD></TD>
  <TD onclick='nueva_nota("MOV_EXTR_ENVASADO")'>Desde Extracci&oacute;n a Envasado</TD>
</tr>
<tr>
  <TD onclick='nueva_nota("TERCIARIOS")'>Envases Terciarios</TD>
  <TD></TD>
  <TD onclick='nueva_nota("MOV_ACOPIO_EMBASADO")'>Desde Acopios a Envasado</TD> 
</tr>
<tr>
  <TD onclick='nueva_nota("MOVIMIENTOS")'>Tipos de Movimientos</TD>
  <TD></TD>
  <TD onclick='nueva_nota("REPROCESO")'>Reprocesos de Productos</TD>  
</tr>
<tr>
  <TD onclick='nueva_nota("ANALISIS")'>Tipos de An&aacutelisis</TD>
  <TD></TD>
  <TD onclick='nueva_nota("MOV_PROD_TERMINADO")'>Traslados de Producto Terminado</TD>  
</tr>
<tr>
  <TD onclick='nueva_nota("TIPOALMA")'>Tipos de Almacenes</TD>
  <TD></TD>
  <TD onclick='nueva_nota("ORD_EMBARQUE")'>Ordenes de Embarque</TD>
</tr>
<tr>
  <TD onclick='nueva_nota("USUARIOS")'>Operadores</TD>
  <TD></TD>
  <TD onclick='nueva_nota("REMITOS")'>Remitos</TD>  
</tr>

<tr>
  <TD></TD>
  <TD></TD>
  <TD onclick='nueva_nota("STOCK")'>Stock</TD>
</tr>


</table>
<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>
<INPUT TYPE='Submit' VALUE=''  id='ent' style='top: 100px;'>

</form>
</BODY>
</HTML>
