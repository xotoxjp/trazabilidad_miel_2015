<?session_start();
include_once("funciones.php");
//  echo "La variable de sesi&oacute;n es: " . session_id();
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$id_usuario=$_SESSION["id_usuario"];
$i = $id_usuario + 0;
if ($i<1)  {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); echo '1';}
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=5 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)){
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }
$Nmes[]='Ene';$Nmes[]='Feb';$Nmes[]='Mar';$Nmes[]='Abr';$Nmes[]='May';$Nmes[]='Jun';
$Nmes[]='Jul';$Nmes[]='Ago';$Nmes[]='Sep';$Nmes[]='Oct';$Nmes[]='Nov';$Nmes[]='Dic';
$last_ing = date("Y-m-d H:i:s"); ;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='analisis1.php'  where id_usuario=".$_SESSION["id_usuario"];
mysql_query($actualizar,$cx_validar);
$actualizar='DELETE FROM '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="ana" and com1="'.session_id().'"' ;
mysql_query($actualizar,$cx_validar);

$lote_array[]=-1;$exclusivo="No";
$prov_id=0;$campo_id=0;$r='';$lote='';$litros='';
$sub=".";$forzar="NO";$leyforzar="";
$orden=$_REQUEST["orden"];
$exclusivo=$_REQUEST["exclusivo"];
$busca=$_REQUEST["BUSCA"];if ($busca>0) {} else {$busca=0;}
$quees=$_REQUEST["QUEES"];$num_sel=0;$anal_no_hay=0;
foreach ($_POST as $indice => $valor){
//echo $indice.".".$valor.'<br>';
//if (($busca==0) and (strlen($quees)>1) and $exclusivo=="Si"){
//}
//else{
  if (substr($indice,0,3)=='ana'){ 
    $p=substr($indice,3);
    if ($p<> FALSE){
      $l=strlen($p);$t=substr($p,0,3);$n=substr($p,3,13);$l=$l-16;$p=substr($p,-$l);
      $actualizar='INSERT INTO '.$_SESSION["tabla_respuesta"].' (`login`,`respuesta`,`marca1`,`marca2`,`valor1`,`com1`) ';
      $actualizar=$actualizar." VALUES ( '".$_SESSION["acceso_logg"]."','ana','".$t."','".$n."',".$p.",'".session_id()."')"; 
      mysql_query($actualizar,$cx_validar);
      if (in_array($p,$lote_array)){}
      else { $lote_array[]=$p;}
      $a='SELECT count(*) FROM '.$_SESSION["tabla_mov_det_anal"].' where lote_id='.$p.' and nro_mov="'.$n.'" and analisis_id>0';
      $r=mysql_query($a,$cx_validar);
      while ($v = mysql_fetch_array($r)) {$anal_no_hay=$v[0]; break;}
    }
  }
//}

}
$num_sel=0;$anal_no_hay=0;


$num_sel=sizeof($lote_array)-1;

$prov_id=0;$campo_id=0;$r='';$lote='';$litros='';
$prov_id=$_REQUEST["prov_id"];
$campo_id=$_REQUEST["campo_id"];
$almacen_id=$_REQUEST["almacen_id"];
$lote=$_REQUEST["lote"];
$queveo=$_REQUEST["queveo"]; if (strlen($queveo)<2) {$queveo="TODO";}


if ($campo_id>0) {$_SESSION["filtro_campo_id"]=$campo_id;}
if ($prov_id>0) {$_SESSION["filtro_prov_id"]=$prov_id;}

$sub=".";$forzar="NO";$leyforzar="";
$orden=$_REQUEST["orden"];

foreach ($_POST as $indice => $valor){
 // echo "$indice: $valor<br>";
   switch ($indice) {
    case 'filtro': $filtro=$valor; break;
    case 'campo': $campo=$valor ; break;
    case 'Submit': $sub=$valor; break;
    case 'ID': $ID=$valor;break;
    case 'forzar': $forzar=$valor;break;
  }
}

if (strlen($ID)>0){
  /*if ($ID=="ALTA"){
    if ($num_sel>0){
      if ($anal_no_hay==0) {header("Location: alta_laboratorio1.php?r=ALTA"); echo '1';}
      else {echo '<p class="rojo">Hay un lote con an&aacutelisis Verifique x favor. No puedo procesar el alta del an&aacutelisis</p>';}
    }
    else {echo '<p class="rojo">Todav&iacutea no seleccion&oacute nada. No puedo procesar el alta del an&aacutelisis</p>';}
  }
  
  if ($ID=="REGISTRO"){
    if ($num_sel>0){
      header("Location: alta_laboratorio3.php?r=REGISTRO&e=$exclusivo"); echo '1';
      // if ($anal_no_hay>0) {header("Location: alta_laboratorio3.php?r=REGISTRO&e=$exclusivo"); echo '1';}
      // else {echo '<p class="rojo">Hay un lote sin an&aacutelisis Verifique x favor.';}
    }  
    else {echo '<p class="rojo">Todav&iacutea no seleccion&oacute nada. No puedo procesar el registro del an&aacutelisis</p>';}
  }
  if ($ID=="DETALLE"){
    if ($num_sel>0){
      if ($anal_no_hay == $anal_no_hay ) {header("Location: alta_laboratorio3.php?r=DETALLE&e=$exclusivo"); echo '1';}
      else {echo '<p class="rojo">Hay un lote sin an&aacutelisis Verifique x favor.Imposible ver el Detalle del An&aacutelisis.</p>';}
    }  
    else {echo '<p class="rojo">Todav&iacutea no seleccion&oacute nada. No puede ver el registro del an&aacutelisis</p>';}*/  
  }
  if ($ID=="RECHAZO"){
    if ($num_sel>0){
      header("Location: rech_laboratorio2.php?r=RECHAZO&e=$exclusivo"); echo '1';
    }  
    else {echo '<p class="rojo">Todav&iacutea no seleccion&oacute nada. No puedo rechazar nada</p>';}
  }
  if ($ID=="ANULA"){
    if ($num_sel>0){
      header("Location: rech_laboratorio3.php?r=ANULA&e=$exclusivo"); echo '1';
    }  
    else {echo '<p class="rojo">Todav&iacutea no seleccion&oacute nada. No puedo Borrar nada</p>';}
  }
}
$a=$tronco;
$b='';
if ($queveo=="an_vacio") { $b=' mov_det_anal.analisis_id=0 ';}
if ($queveo=="an_nak")   { $b=' mov_det_anal.analisis_id!=0  and mov_detalle.cumple="No" ';}
if ($queveo=="an_ok")    { $b=' mov_det_anal.analisis_id!=0 and mov_detalle.cumple="Si" ';}
if ($queveo=="an_ne")   { $b='  mov_det_anal.analisis_id!=0 and mov_det_anal.entro="No" ';}
$i=0;
if ((strlen($quees)>1) and ($exclusivo=="Si")) {
  if ($quees=="lote"){
    if ($busca>0){$a=$a.' where mov_detalle.tipo_mov="EXT" and mov_detalle.lote_id='.$busca ;$i++;}
  } 
  if ($quees=="nro_mov"){
    if ($busca>0){$a=$a.' where mov_detalle.tipo_mov="EXT" and mov_detalle.nro_mov="'.$bus.'"';$i++;}
  } 
  if ($quees=="nro_anal"){
    if ($busca>0){$a=$a.' where mov_detalle.tipo_mov="EXT" and mov_det_anal.analisis_id="'.$busca.'"';$i++;} 
  } 
}
if (strlen($b)>0){
  if ($i>0){ $a=$a.' and '.$b.' and mov_detalle.tipo_mov="EXT" and mov_detalle.nro_mov!=mov_detalle.nro_mov_baja';}
  else {$a=$a.' where '.$b.' and mov_detalle.tipo_mov="EXT"  and mov_detalle.nro_mov!=mov_detalle.nro_mov_baja';}
}

if (($i<1) and (strlen($b)<1)){ $a=$a.' where  mov_detalle.tipo_mov="EXT"  and mov_detalle.nro_mov!=mov_detalle.nro_mov_baja';}

$color='';
IF (!empty($_SESSION["filtro_color"])){
  $c='SELECT valor_i,valor_f,color FROM '.$_SESSION["tabla_tipo_color"].' where color_id='.$_SESSION["filtro_color"];
  $rc=mysql_query($c,$cx_validar);while ($vc = mysql_fetch_array($rc)) {$valor_i=$vc[0];$valor_f=$vc[1];$color=$vc[2];break;}
}

if ($filtro !='   '){
  IF ( $campo == 'tipo_mov' )        {$_SESSION["filtro_tipo_mov"]=$filtro; }
  IF ( $campo == 'almacenes.razon_social' )   {$_SESSION["filtro_almacenes"]=$filtro; }
  IF ( $campo == 'sala_ext' )        {$_SESSION["filtro_sala_ext"]=$filtro; }
  IF ( $campo == 'cosecha' )         {$_SESSION["filtro_cosecha"]=$filtro; }
  IF ( $campo == 'fecha_nece')       {$_SESSION["filtro_fecha_nece"]=$filtro; }
  IF ( $campo == 'prioridad' )       {$_SESSION["filtro_prioridad"]=$filtro; }
  IF ( $campo == 'localidad' )       {$_SESSION["filtro_localidad"]=$filtro; }
  IF ( $campo == 'provincia' )       {$_SESSION["filtro_provincia"]=$filtro; }
  IF ( $campo == 'productor.abrev' ) {$_SESSION["filtro_productor"]=$filtro; }
}
$Limite="";
?>
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1">             
<TITLE>Laboratorio</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="fotos/laboratorio.gif">
<link rel="stylesheet" href="analisis.css" />
<style type="text/css"> #ent {display: none;} .rojo {color: red;} </style>
<script type="text/javascript">
<!--
function ini(colu) {
  mar=true;
 tx=document.getElementById('Eleccion');
  btn=document.getElementById('ent');
  tab=document.getElementById('tabla');
  j=0;
  z=0;
  k=0;
  for (i=26; ele=tab.getElementsByTagName('td')[i]; i++) {
    ele.onclick = function() {seteom(this,i,colu,tx );  }
    ele.ondblclick = function(){
      seteom(this,i,colu,tx );
      nueva_nota('DETALLE');
    }
    ele.onmouseover = function(){iluminarm(this,true)}
    if (k==0) ele.onmouseout = function() {iluminarim(this);}
    if (k==1) ele.onmouseout = function() {iluminarpm(this);}
    j++;
    if (j==colu){
      j=0;
      if (k!=1) {k++;}
      else {k=0;}
    }
  }
}

function seteom(obj,valor,i1,fo){
	if (obj.id){
    fila = obj.parentNode;
    tilde=document.getElementById('ana'+fila.id.substring(3));
    if (tilde){
      tilde.checked=!(tilde.checked);
      if (tilde.checked){
        tx=document.getElementById('num_sel');
        tx.value++;
      }
      else{
        tx=document.getElementById('num_sel');
        if (tx.value>0){tx.value--;}
      }
    }
  }
  poner1(i1);
}

function iluminarm(obj,l){
   fi = obj.parentNode;
   ele = document.getElementById(fi.id);
   if (document.getElementById('ana'+fi.id.substring(3)).checked){
		ele.style.background='Coral';}
		else {ele.style.background='Yellow';} 
}

function iluminarpm(obj){
	fila = obj.parentNode; p=fila.id.substring(3);
    ele = document.getElementById(fila.id);
    if (document.getElementById('ana'+p).checked){
		ele.style.background = 'Gold' ;}
    else {ele.style.background = 'LightSteelBlue' ;}
}

function iluminarim(obj){
	fila = obj.parentNode;p=fila.id.substring(3);
    ele = document.getElementById(fila.id);
    if (document.getElementById('ana'+p).checked){
		ele.style.background = 'Gold' ;}
    else {ele.style.background = 'LightCyan' ;}
}

function poner1(colu){
  k1=colu;fi=0;
  tab=document.getElementById('tabla');
  for (i1=26; ele1=tab.getElementsByTagName('td')[i1]; i1=i1+k1){
    fi = fi + 1;
    if (fi>=2) {fi=0;}
    switch(fi){
    case 0:
		iluminarpm(ele1);
		break;
    case 1:
		iluminarim(ele1);
		break;
    default:
		break;
    }
  }
}

function marcar(colu){
	for (x=1; document.getElementById('ana'+x) ; x++){
		if (!(document.getElementById('ana'+x).checked)){
			document.getElementById('ana'+x).checked = !(document.getElementById('ana'+x).checked);}
	}
poner1(colu);
}

function desmarcar(colu){
for (x=1; document.getElementById('ana'+x) ; x++)
  {if (document.getElementById('ana'+x).checked){document.getElementById('ana'+x).checked = !(document.getElementById('ana'+x).checked);}}
poner1(colu);
}

function marco(elemento){
  tx=document.getElementById('orden');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();
}

function marcoq(elemento){
  tx=document.getElementById('queveo');
  if (  tx.value==elemento) {tx.value='TODO';}
  else {tx.value=elemento;}
  btn=document.getElementById('ent');
  btn.click();
}

function nueva_opcion(elemento){
  tx=document.getElementById('QUEES');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();
}

function nueva_nota(elemento){
  tx=document.getElementById('Eleccion');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();
}

-->
</script>


</head>

<?
echo "<body onload='ini(14); poner1(14);'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='analisis1.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);



$busca='';
echo '<table border="0" id="cabeza">';
$a1="ALTA";$a2="REGISTRO";$a3="DETALLE";

if ($alta=='on'){ echo '<tr><td><span onclick="nueva_nota('."'".$a1."'".');">Lotes a<br>Analizar</span>';}

if ($modifica=='on'){echo '<span onclick="nueva_nota('."'".$a2."'".');">Grabar un<br>An&aacutelisis</span>';}

echo '<span onclick="nueva_nota('."'".$a3."'".');">Ver un<br>An&aacutelisis</span></td>';
// caja de texto buscar
echo"<td>Seleccionar Nro: <br>";
echo "<INPUT TYPE='TEXT' NAME='BUSCA'  ID='BUSCA' VALUE='$busca' size=8";

if (strlen($quees)>1){echo ' autofocus ';}
echo " >";
echo '</td><td>';
echo '<span class="chico'; if ($quees=="nro_mov"){echo '_activo';}
echo '" onclick="nueva_opcion('."'nro_mov'".');">Lote</span>';
echo '<span class="chico'; if ($quees=="lote"){echo '_activo';}
echo '" onclick="nueva_opcion('."'lote'".');">Tambor</span>';
echo '<span class="chico'; if ($quees=="nro_anal"){echo '_activo';}
echo '" onclick="nueva_opcion('."'nro_anal'".');">An&aacute;l.<br>ID</span>';
echo '</td><td><span class="exclusivo">&nbsp;Exclusivo&nbsp;<br>&nbsp;';
echo '<label><input name="exclusivo" type="radio" value="No"';
 if ($exclusivo!="Si"){echo ' checked ';}
echo' >No</label>&nbsp;';
echo '<label><input name="exclusivo" type="radio" value="Si"';
 if ($exclusivo=="Si"){echo ' checked ';}
 echo '>Si</label></span>';

echo '</td><td>It.Sel.<br>';
echo "<INPUT TYPE='TEXT' NAME='num_sel'  ID='num_sel' VALUE='$num_sel' size=4>";

echo '<td><span class="rechazo" onclick="nueva_nota('."'RECHAZO'".');">Rechazo</span>';

if ($baja=='on'){
  echo '</td><td><span class="rechazo" onclick="nueva_nota('."'ANULA'".');">BORRA</span>';
}
echo '</td></tr></table>';


echo "<table border='1' id='tabla' width='100%'>" ;
// coloco la linea de los filtros
echo "<tr class='cabecera' bgcolor='#FFFFFF'><td><a href='menu_1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='18' height='18' border='0'></a>";
echo '&nbsp;Fecha</td>';
echo '<td>&nbsp;Localidad';
if (!empty($_SESSION["filtro_localidad"])){echo '<div  class="cab_cui">'.$_SESSION["filtro_localidad"].'</div>';}
echo '</td>';

echo '<td>&nbsp;Provincia';
if (!empty($_SESSION["filtro_provincia"])){echo '<div  class="cab_cui">'.$_SESSION["filtro_provincia"].'</div>';}
echo '</td>';

echo '<td align="LEFT">Tambor</td>';

if (!empty($_SESSION["filtro_color"])){
  echo '<td><div  class="cab_cui">'.$color.'<br>'.$valor_i.'&nbsp;a&nbsp;'.$valor_f.'</div></td>';}
else {echo '<td>Color</td>';}

echo '<td>Sala Ext.';
if (!empty($_SESSION["filtro_sala_ext"])){echo '<br><div  class="cab_cui">'.$_SESSION["filtro_sala_ext"].'</div>';} 
echo '</td>';

echo '<td colspan="3">';

$ta='Históricos de los Análisis';
echo "<a href='histolab.php' target='_blank'><img src='fotos/microscopio.JPG' alt='".$ta."' title='".$ta."' align='middle' height='34'></a>";


$ta='Solo se ve LOTES SIN ANALISIS';
echo "<img onclick='marcoq(".'"an_vacio"'.");' src='fotos/an_vacio.JPG' alt='".$ta."' title='".$ta."' align='middle' height='30' style='border: solid 2px ";
if ($queveo=="an_vacio") { echo "#000;'>";}
else {echo "#FFF;'>";}

$ta='Solo se ve LOTES CON ANALISIS NO APTOS';
echo "<img onclick='marcoq(".'"an_nak"'.");' src='fotos/an_nak.JPG' alt='".$ta."' title='".$ta."' align='middle' height='30' style='border: solid 2px ";
if ($queveo=="an_nak") {echo "#F00;'>";}
else {echo "#FFF;'>";}

$ta='Solo se ve LOTES CON ANALISIS OK';
echo "<img onclick='marcoq(".'"an_ok"'.");' src='fotos/an_ok.JPG' alt='".$ta."' title='".$ta."'  align='middle' height='30' style='border: solid 2px ";
if ($queveo=="an_ok") {echo "#0F0;'>";}
else {echo "#FFF;'>";}

$ta='Solo se ve LOTES QUE NO EXISTEN, Nunca entraron al LAB';
echo "<img onclick='marcoq(".'"an_ne"'.");' src='fotos/an_novino.JPG' alt='".$ta."' title='".$ta."'  align='middle' height='30' style='border: solid 2px ";
if ($queveo=="an_ne") {echo "#0F0;'>";}
else {echo "#FFF;'>";}

echo '</td>';


echo '<td>Antes del';
if (!empty($_SESSION["filtro_fecha_nece"])){echo '<br><div  class="cab_cui">'.$_SESSION["filtro_fecha_nece"].'</div>';}
echo '</td><td>Prioridad';
if (!empty($_SESSION["filtro_prioridad"])){echo '<br><div  class="cab_cui">'.$_SESSION["filtro_prioridad"].'</div>';}
echo '</td>';
echo '<td>Productor';
if (!empty($_SESSION["filtro_productor"])){echo '<br><div  class="cab_cui">'.$_SESSION["filtro_productor"].'</div>';}
echo '</td>';
echo '<td align="CENTER" >Cosecha';
if (!empty($_SESSION["filtro_cosecha"])){echo '<br><div  class="cab_cui">'.$_SESSION["filtro_cosecha"].'</div>';}

echo '</td><td>&nbsp;Vence</td>';

echo '</tr><tr class="cabecera">';


$fecha_actual = floor(strtotime(date("d-m-Y H:i:00",time())));
$fec_a= floor($fecha_actual/(24*60*60));


$j=0;$k=0; $illega=0;$ico0=0;$ico1=0;$ico2=0;$ico3=0;$ico4=0;$ico5=0;$ico6=0;$ico7=0;$ico8=0;$ico9=0;
if (!empty($_SESSION["filtro_tipo_mov"])){$illega++;}
if (!empty($_SESSION["filtro_localidad"])){$illega++;}
if (!empty($_SESSION["filtro_provincia"])){$illega++;}
if (!empty($_SESSION["filtro_sala_ext"])) {$illega++;}
if (!empty($_SESSION["filtro_cosecha"])) {$illega++;}
if (!empty($_SESSION["filtro_fecha_nece"])) {$illega++;}
if (!empty($_SESSION["filtro_prioridad"])) {$illega++;}
if (!empty($_SESSION["filtro_productor"])) {$illega++;}
if (!empty($_SESSION["filtro_color"])) {$illega++;}

//$s=0;
/*acá comienza la tabla*/
while ($v_validar = mysql_fetch_array($rs_validar)) {
  //sergio
   //echo " validar[8]:" .$v_validar[8]."</br>";
  //$s++;
  //
  //echo var_dump($v_validar)."</br>";
  $esta_en='';
  
  $ax='SELECT almacenes.razon_social,mov_cabecera.hora_cierre,mov_detalle.tipo_mov FROM '.$_SESSION["tabla_mov_detalle"].' INNER JOIN ';
  $ax=$ax.$_SESSION["tabla_mov_cabecera"].' on mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
  $ax=$ax.$_SESSION["tabla_almacenes"].' on mov_detalle.almac_id_des=almacenes.almacen_id';
  $ax=$ax.' where mov_detalle.lote_id='.$v_validar[8].' and mov_detalle.nro_mov_baja="            "';
  $rx=mysql_query($ax,$cx_validar);
  while ($vx = mysql_fetch_array($rx)) {
    $esta_en=$vx[0];
    $hora_cierre=$vx[1]; 
    if ( $vx[2]=="EXT") {$hora_cierre="11:11";}
    break;
  }
  
  
  i
 /* acá muestra desde fecha iconos de analisis */ 
  if ($va=="si"){
  $k++;
  if (strlen($v_validar[3])<1) {$v_validar[3]='&nbsp;';}
  echo "<tr id='col".$k."'>";  
  echo "<td class='cabecera' ALIGN='LEFT' id=".'A'.$v_validar[8].">";
  
  echo "<input type='checkbox' value='0' name='ana".$v_validar[0].$v_validar[2].$v_validar[8]."' id='ana".$k."'"; 
  if (in_array($v_validar[8], $lote_array)){echo ' checked="checked" ';}
  echo "/>".substr($v_validar[1],-2).substr($v_validar[1],4,4).substr($v_validar[1],2,2).'</td>';

  echo "<td class='cabecera' align='LEFT' id=".'B'.$v_validar[8].'>'.$v_validar[21].'</td>';
  echo "<td class='cabecera' align='LEFT' id=".'D'.$v_validar[8].'>'.$v_validar[22].'</td>';

  echo "<td align='RIGHT' id=".'G'.$v_validar[8].">$v_validar[8]</td>";
  echo "<td align='RIGHT' class='cabecera' id=".'Q'.$v_validar[8].'>'.$v_validar[20].'</td>';
  
  echo "<td class='cabecera' align='LEFT' id=".'E'.$v_validar[8].">$v_validar[16]</td>";
//  echo "<td align='RIGHT' id=".'F'.$v_validar[8].">$v_validar[17]</td>";
// ? x la fecha y cambio color en funcion de lo que falta a la necesidad
  // el ID en $v_validar[10]
  echo "<td align='RIGHT' id=".'J'.$v_validar[8].">$v_validar[10]</td>";
  echo "<td class='cabecera' id=".'K'.$v_validar[8].'>'.substr($v_validar[11],0,10).'</td>';
  echo "<td align='CENTER' id=".'L'.$v_validar[8].">$v_validar[12]</td>";

  /*sin este if no se muestra desde la columna "antes del"*/
 if (substr($v_validar[14],0,4)>"2000" ) {
    if (strlen(trim($v_validar[11]))<2 ) { // cuidado o alerta
      $ftes = strtotime($v_validar[14]." 21:00:00");
      $fecha_alerta = floor( ($ftes - 1*(24*60*60)) /(24*60*60));
      $fecha_cuidado = floor( ($ftes - 3*(24*60*60)) /(24*60*60));
      if ($fec_a>=$fecha_alerta) {echo "<td class='cab_ale' ";}
      else {
        if ($fec_a>=$fecha_cuidado){ echo "<td class='cab_cui' "; } else {echo "<td class='cabecera' ";}
      }
      echo "id=".'M'.$v_validar[8].">$v_validar[14]</td>"; 
    }
    else {echo "<td class='cabecera' id=".'M'.$v_validar[8].">$v_validar[14]</td>";}}
  else {echo '<td>&nbsp</td>';}
  echo "<td class='cabecera' id=".'N'.$v_validar[8].">$v_validar[15]</td>";
  echo "<td class='cabecera' id=".'O'.$v_validar[8].">$v_validar[13]</td>";

  echo "<td align='CENTER' id=".'H'.$v_validar[8].">$v_validar[7]</td>";
  echo "<td align='LEFT' id=".'I'.$v_validar[8].'>';
  $io=-1+substr($v_validar[18],5,2);
  echo $Nmes[$io].'-'.substr($v_validar[18],2,2);
  echo '</td>';
 echo "</tr>" ;
}
}
echo "<caption  color style='background:#99FF33'>An&aacutelisis, Ordenados por ".$xorden;
echo ".  .  . Se leyeron ".$j." registros";
if ( ($k > 0) && ($k!=$j) ) {echo " y coinciden " .$k;}
echo "</caption></table>";
echo "<a href='menu_1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";

echo "<INPUT TYPE=HIDDEN NAME='almacen_id' id='almacen_id' VALUE='".$almacen_id."'>";

echo "<INPUT TYPE=HIDDEN NAME='fecha_ini' id='fecha_ini' VALUE='".$fecha_ini."'>";
echo "<INPUT TYPE=HIDDEN NAME='fecha_fin' id='fecha_fin' VALUE='".$fecha_fin."'>";

echo "<INPUT TYPE=HIDDEN NAME='hora_inicio' id='hora_inicio' VALUE='".$hora_inicio."'>";
echo "<INPUT TYPE=HIDDEN NAME='hora_final' id='hora_final' VALUE='".$hora_final."'>";

echo "<INPUT TYPE=HIDDEN NAME='pers_ini' id='pers_ini' VALUE='".$pers_ini."'>";
echo "<INPUT TYPE=HIDDEN NAME='pers_fin' id='pers_fin' VALUE='".$pers_fin."'>";
echo "<INPUT TYPE=HIDDEN NAME='orden' id='orden' VALUE='IDUP'>";
echo "<INPUT TYPE=HIDDEN NAME='queveo' id='queveo' VALUE='".$queveo."'>";
echo "<INPUT TYPE=HIDDEN NAME='QUEES' id='QUEES' VALUE='".$quees."'>";

echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";

echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
?>
</BODY>
</HTML>




