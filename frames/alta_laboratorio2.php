<?session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];

$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=4 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1)  {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }
$exclusivo="No"; $lote_ind=0;
$exclusivo=$_REQUEST["e"];
$como_ves=$_REQUEST["r"];
if (strlen($exclusivo)!=2) {$exclusivo="No"; }
if ( ($como_ves=='REGISTRO') and ($modifica!='on')) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }


$last_ing = date("Y-m-d H:i:s"); ;

$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='alta_laboratorio2.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);

$lote_array[]=-1;$hora_fin='';$minu_fin='';
$prov_id=0;$campo_id=0;$r='';$lote='';$litros='';
$sub=".";$forzar="NO";$leyforzar="";
$a='select cod_anal_id from  '.$_SESSION["tabla_analitico_inf"].' where aplica_ok="Si"';
$r=mysql_query($a,$cx_validar);
while ($v = mysql_fetch_array($r)) {$aplica[]=$v[0];}


$como_ves=$_REQUEST["r"];
if (strlen($como_ves)<1){
  $como_ves=$_REQUEST['como_ves'];
  if (strlen($como_ves)<1){
    $como_ves='DETALLE';
  }
}
foreach ($_POST as $indice => $valor){
//echo $indice.".".$valor.'<br>';
  switch ($indice) {
    case 'fecha_fin': $fecha_final=substr($valor,-4).substr($valor,2,4).substr($valor, 0,2) ; break;
    case 'hora_fin': $hora_fin=$valor ; break;
    case 'minu_fin': $minu_fin=$valor ; break;
    case 'hora_final': $hora_final=$valor ; break;
    case 'pers_fin': $pers_fin=$valor; break;
    case 'lab_anal_id': $lab_anal_id=$valor; break;
    case 'lab_nro_mov': $lab_nro_mov=$valor; break;
  }
}

$prov_id=0;$campo_id=0;$r='';$lote='';$litros='';
$prov_id=$_REQUEST["prov_id"];
$campo_id=$_REQUEST["campo_id"];
$almacen_id=$_REQUEST["almacen_id"];
$lote=$_REQUEST["lote"];
     
$a='select marca1,marca2,valor1 from  '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="ana"';
$r=mysql_query($a,$cx_validar);
while ($v = mysql_fetch_array($r)) {$nro_mov=$v[1];$lote=$v[2];}
if (exclusivo!="No"){$lote_ind=$lote; } else {$lote_ind=0;}


$analisis_id=0;
$a='select analisis_id from  '.$_SESSION["tabla_analitico"].' where nro_mov="'.$nro_mov.'" and lote_id='.$lote;
$r=mysql_query($a,$cx_validar);
while ($v = mysql_fetch_array($r)) {$analisis_id=$v[0];}

if ($analisis_id==0){header("Location: analisis1.php"); echo '1';}

$a='select almacen_id from  '.$_SESSION["tabla_analisis"].' where analisis_id='.$analisis_id;
$r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {$almacen_id=$v[0];}


$a='select razon_social,dir1,localidad,contacto,tel from  '.$_SESSION["tabla_almacenes"].' where almacen_id='.$almacen_id.' and tipo_almacen=2';
$r=mysql_query($a,$cx_validar);

while ($v = mysql_fetch_array($r)) {
  $razon_social=$v[0];$dir1==$v[1];$localidad=$v[2];$contacto=$v[3];$tel=$v[4];}

$falla="No";
$sub=".";$forzar="NO";$leyforzar="";
$ID=$_REQUEST["ID"];
if (substr($ID,0,6)=="Volver") {header('Location: analisis1.php'); echo '1';}
if (substr($ID,0,6)=="Grabar") {$l=strlen($ID)-6;$hay=0+substr($ID,6,$l); 

  for ($i=1;$i<=$hay;$i++){
    $n='res'.$i;
    $m=$_REQUEST[$n];
    if (strlen($m)<1) {$falla="Si";break;}
  }
//  if ($falla=="Si") { echo "<p class='rojo'>No complet&oacute; Todos los Items. Verifique por favor.</p>";}
//  else{
    if ($como_ves!='DETALLE'){
      $a='SELECT analitico.prod_id,producto.abrev,analitico.lote_id,analitico.analisis_id,analitico.cod_anal_id,';
      $a=$a.'analitico_inf.nomencl,analitico_inf.esp_inf,analitico_inf.esp_sup,analitico_inf.unidad,';
      $a=$a.'analitico.resultado,analitico.cumple FROM '.$_SESSION["tabla_analitico"].' INNER JOIN ';
      $a=$a.$_SESSION["tabla_productos"].' on analitico.prod_id=producto.prod_id INNER JOIN ';
      $a=$a.$_SESSION["tabla_analitico_inf"].' on (analitico.cod_anal_id=analitico_inf.cod_anal_id)';
      $a=$a.' where analitico.analisis_id='.$analisis_id.' order by 3,5';
      $r= mysql_query($a,$cx_validar); $i=0;$cumplegral='Si';$nl=0;$cl='Si';
      while ($v = mysql_fetch_array($r)) { $i++;$lote=$v[2];$cod_anal_id=$v[4];
        if($nl<1){$nl=$lote;}
        $m1='res'.$i;
        $j1='cum'.$i;
        $m=$_REQUEST[$m1];

        if ($nl!=$lote){$nl=$lote;$cl='Si';}
        $j=$_REQUEST[$j1];if ($j!='Si') {$cumplegral='No';$cl='No';}       
        
        $a1='UPDATE '.$_SESSION["tabla_analitico"].' set resultado="'.$m.'",cumple="'.$j.'" where analisis_id='.$analisis_id.' and lote_id='.$lote.' and cod_anal_id='.$cod_anal_id;
        $r1=mysql_query($a1,$cx_validar);
        $a1='UPDATE '.$_SESSION["tabla_mov_det_anal"].' set cumple="'.$cl.'",nro_anal="'.$lab_nro_mov.'" where analisis_id='.$analisis_id.' and lote_id='.$lote;
        $r1=mysql_query($a1,$cx_validar);

        if ($cod_anal_id==3){
          $a1='UPDATE '.$_SESSION["tabla_mov_detalle"].' set color='.$m.' where lote_id='.$lote;
          $r1=mysql_query($a1,$cx_validar);
        }
      }
      $a1="select login from  ".$_SESSION["tabla_acc"].' where id_usuario='.$pers_fin;
      $r1 = mysql_query($a1,$cx_validar);
      while ($v1 = mysql_fetch_array($r1)){$d= $v1[0];break;}

      $a1='UPDATE '.$_SESSION["tabla_analisis"].' set cumple="'.$cumplegral.'",fecha_fin="'.$fecha_final.'",hora_fin="'.$hora_final.'",lab_an_id='.$lab_anal_id.',lab_nro_mov="'.$lab_nro_mov.'",login_fin="'.$d.'"   where analisis_id='.$analisis_id;
      $r1=mysql_query($a1,$cx_validar);

      $a2='SELECT DISTINCT lote_id FROM '.$_SESSION["tabla_analitico"];
      $a2=$a2.' where analitico.analisis_id='.$analisis_id.' order by 1';
      $r2= mysql_query($a2,$cx_validar); 
      while ($v2 = mysql_fetch_array($r2)) { 
        $lote=$v2[0];
        $a3='SELECT analitico.lote_id FROM analitico INNER JOIN analitico_inf on analitico.cod_anal_id = analitico_inf.cod_anal_id';
        $a3=$a3.' where analitico.lote_id='.$lote.' and analitico.cumple="No" and analitico_inf.aplica_ok="Si"';
        $r3= mysql_query($a3,$cx_validar);$i=0;$c="Si"; 
        while ($v3 = mysql_fetch_array($r3)) {$c="No";break;}    
          
        $a3='UPDATE '.$_SESSION["tabla_mov_detalle"].' set cumple="'.$c.'" where lote_id='.$lote;
        
        $r3=mysql_query($a3,$cx_validar);
      }
      header('Location: analisis1.php'); echo '1';
//    }
  }
}



$a1="select fecha_fin,hora_fin,lab_an_id,lab_nro_mov,login_fin from  ".$_SESSION["tabla_analisis"].'  where analisis_id='.$analisis_id;
$r1 = mysql_query($a1,$cx_validar);
while ($v1 = mysql_fetch_array($r1)){
  if (strlen($fecha_fin)<2){ $fecha_fin=substr($v1[0],-2).substr($v1[0],4,4).substr($v1[0], 0,4);}
  if (strlen($hora_fin)<1) {$hora_fin=substr($v1[1],0,2);}
  if (strlen($minu_fin)<1) {$minu_fin=substr($v1[1],3,2);}
  if ($lab_anal_id>0) {} else {$lab_anal_id=$v1[2];}
  if (strlen($lab_nro_mov)<1) {$lab_nro_mov=$v1[3];} 
  break;
}

foreach ($_GET as $indice => $valor){
  //echo "$indice: $valor<br>";
   switch ($indice) {
    case 'ID': $ID=$valor;break;
  }
}

foreach ($_POST as $indice => $valor){
  //echo "$indice: $valor<br>";
   switch ($indice) {
    case 'ID': $ID=$valor;break;
  }
}


if ($ID == 'XLS'){
  header("Location: labaxls.php?analisis_id=$analisis_id"); echo '1';
}

$a='SELECT analitico.prod_id,producto.abrev,analitico.lote_id,analitico.analisis_id,analitico.cod_anal_id,';
$a=$a.'analitico_inf.nomencl,analitico_inf.esp_inf,analitico_inf.esp_sup,analitico_inf.unidad,';
$a=$a.'analitico.resultado,analitico.cumple,analitico_inf.aplica_ok FROM '.$_SESSION["tabla_analitico"].' INNER JOIN ';
$a=$a.$_SESSION["tabla_productos"].' on analitico.prod_id=producto.prod_id INNER JOIN ';
$a=$a.$_SESSION["tabla_analitico_inf"].' on (analitico.cod_anal_id=analitico_inf.cod_anal_id) where analitico.analisis_id='.$analisis_id;
if ($exclusivo!="No"){
  $a=$a.' and lote_id='.$lote_ind ;
}
$a=$a.' order by 3,5';

$Limite="";
?>
<head>
<TITLE>ANALISIS</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="lang/calendar-es.js"></script>
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" href="analisis.css" />
<style type="text/css">
#ent {display: none;}
.rojo {color: red;}
</style>

<script type="text/javascript">
<!--
function ini(colu) {
  tx=document.getElementById('Eleccion');
  btn=document.getElementById('ent');
  tab=document.getElementById('tabla');
  j=0;
  z=0;
  k=0;
  for (i=16; ele=tab.getElementsByTagName('td')[i]; i++) {
//    ele.onclick = function() {seteo(this,i,colu,tx );  }
    ele.onmouseover = function() {iluminar(this,true)}
    if (k==0) ele.onmouseout = function() {iluminari(this);}
    if (k==1) ele.onmouseout = function() {iluminarp(this);}
    j++
    if (j==colu)
     {j=0;
      if (k!=1)
       {k++;}
      else
       {k=0;}}
  }
}


function seteo(obj,valor,i1,fo) { fila = obj.parentNode;
  for (i=0; ele = fila.getElementsByTagName('td')[i]; i++)
    {
     fo.value=ele.id;
     btn.click();
    }
}
function iluminar(obj,valor) { fila = obj.parentNode;
  for (i=0; ele = fila.getElementsByTagName('td')[i]; i++)
      ele.style.background = 'yellow' }
function iluminarp(obj) { fila = obj.parentNode;
    for (i=0; ele = fila.getElementsByTagName('td')[i]; i++)
      ele.style.background = 'LightSteelBlue' ;}
function iluminari(obj) {  fila = obj.parentNode;
    for (i=0; ele = fila.getElementsByTagName('td')[i]; i++)
      ele.style.background = 'LightCyan' ;}
function poner1(colu){
  k1=colu; j1=0;fi=0;
  tab=document.getElementById('tabla');
  for (i1=16; ele1=tab.getElementsByTagName('td')[i1]; i1=i1+k1) {
    fi = fi + 1
    if (fi==2) {fi=0;}
    switch(fi) {
    case 0:
      iluminarp(ele1);
       break;
    case 1:
      iluminari(ele1);
      break;
    default:
      break;
    }
  }
}


function nueva_opcion(elemento)
 {
  tx=document.getElementById('QUEES');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();}

function nueva_nota(elemento) {

  if (elemento=='Volver'){
    listahi=document.getElementById('hora_fin');listahi.value=01;
    listami=document.getElementById('minu_fin');listami.value=01;
    listami1=document.getElementById('lab_nro_mov');listami1.value='---';
    tx=document.getElementById('Eleccion');
    tx.value=elemento;
    btn=document.getElementById('ent');
    btn.click(); 
  }
  else {
    if (elemento=='Vuelve'){
      tx=document.getElementById('Eleccion');
      tx.value='Volver';
      btn=document.getElementById('ent');
      btn.click(); 
    }
    else {
    listahi=document.getElementById('hora_fin');var vhi = 1*listahi.value;
    listami=document.getElementById('minu_fin');var vmi = 1*listami.value;
    var tx3="";
    if (vhi>9) {tx3=vhi+":";} else {tx3="0"+vhi+":";}
    if (vmi>9) {tx3=tx3+vmi;} else {tx3=tx3+"0"+vmi;}
    tx31=document.getElementById('hora_final');tx31.value=tx3;
    tx=document.getElementById('Eleccion');
    tx.value=elemento;
    btn=document.getElementById('ent');
    btn.click(); 
    }
  }
}




function nueva_opc(e) {
  tx1=document.getElementById('valk');
  i1=tx1.value;
  for (j=1;j<=i1;j++){
    if (e==0){var tx="cumn";} else {var tx="cums";}
    tx=tx+j;
    var t1=document.getElementById(tx);
     if (!(t1.checked)){t1.checked=!t1.checked ;}
    
  }
}
-->
</script>


</head>

<?
echo "<body onload='ini(11); poner1(11);'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='alta_laboratorio2.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$rs_validar = mysql_query($a,$cx_validar);

echo '<table border="0" id="cabeza">';
//echo '<tr><td><span onclick="nueva_nota('."'Volver'".');">Volver</span>';
if ($como_ves!='DETALLE'){
  echo '<tr><td><span onclick="nueva_nota('."'Volver'".');">Volver</span>';
  echo '<span onclick="nueva_nota('."'Grabar".$k."'".');">Grabar el Resultado</span>';}
else
{
  echo '<tr><td><span onclick="nueva_nota('."'Vuelve'".');">Volver</span>';
}
echo '<td><span onclick="nueva_nota('."'XLS'".');">Salida</span>';

echo '</td></tr></table>';

if (strlen($fecha_fin)<3){$fecha_fin = date("d-m-Y");}
if ($hora_fin<1){$l = date("Y-m-d H:i:s"); $h=substr($l,-8);
  $hora_fin = 0 + substr($h,0,2);
  $minu_fin = 0 + substr($h,3,2);
}

echo "<table border='0' width='90%'>" ;
echo '<tr><td>Laboratorio:</td><td>'.$razon_social.'</td>';
echo '<td>Entra el d&iacutea:</td><td>';
if ($como_ves!='DETALLE'){ echo "<INPUT TYPE=TEXT NAME='fecha_fin'  id='fecha_fin' size=10 autofocus value='".$fecha_fin."' placeholder='  -  -    ' required>";}
else{ echo $fecha_fin;}
echo '</td><td align="RIGHT">a las</td><td>';

echo '<input type="number" name ="hora_fin" id ="hora_fin" min="0" max="24" size="3" value="'.$hora_fin.'" maxlength="3" placeholder ="08" required/>';
echo ':<input type="number" name ="minu_fin" id ="minu_fin"min=0 max=59 size="3" value="'.$minu_fin.'" maxlength="3" placeholder ="30"required/>';
echo '</td></tr>';
echo '<tr><td>Direcci&oacute;n:</td><td>'.$dir1.'-'.$localidad.'</td>';
echo '<td>N&ordm Interno del An&aacutelisis:</td><td>';
if ($como_ves!='DETALLE'){ echo "<INPUT TYPE=TEXT NAME='lab_anal_id' size=10 id='lab_anal_id' placeholder='Orden Interna' VALUE=". $lab_anal_id.'>';}
else{ echo $lab_anal_id;}
echo '</td></tr>';
echo '<tr><td>Contacto:</td><td>'.$tel.'/'.$contacto.'</td><td>N&ordm de Remito:</td><td>';
if (strlen($lab_nro_mov)<8){ $lab_nro_mov='    -        ';}
if ($como_ves!='DETALLE'){ echo "<INPUT TYPE=TEXT NAME='lab_nro_mov' size=13 id='lab_nro_mov' required placeholder='Dto.de Envio' VALUE=". $lab_nro_mov.'>';}
else{ echo $lab_nro_mov;}
echo '</td><td align="RIGHT">Responsable:<td>';
$actualizar1="select id_usuario,login from  ".$_SESSION["tabla_acc"]." where op_campo='Si'" ;
$rs_validar1 = mysql_query($actualizar1,$cx_validar);
echo  '<select name="pers_fin" id="pers_fin">';
while ($v_validar1 = mysql_fetch_array($rs_validar1)){ 
  echo  "<option value="."'".$v_validar1[0]."'>".$v_validar1[1]."</option>"; 
}
echo '</select>';

echo '</td></tr>';

echo '</table>';
echo "<table border='1' id='tabla' width='100%'>" ;
echo '<tr bgcolor="#FFFFFF"><td colspan="3">&nbsp;&nbsp;&nbsp;Producto</td>';
echo '<td align="CENTER" colspan="2">Datos del An&aacute;lisis&nbsp;';
echo '</td><td align="CENTER" colspan="4">Datos de Referencia</td><td align="CENTER" colspan="2">Resultado</td>';
echo '</tr><tr>';
echo '<td align="CENTER">ID</td><td align="CENTER">Nombre</td><td align="CENTER">Tacho</td><td align="CENTER">C&oacuted.</td><td>Nomenclador</td><td align="CENTER">Inferior</td><td align="CENTER">Superior</td><td align="CENTER">Unidad</td><td align="CENTER">Rechaza</td><td align="CENTER">Resultado</td><td align="CENTER">';
echo '<img src="fotos/s_error.PNG"  onclick="nueva_opc(0);" title="NINGUNO CUMPLE" widht=15px height=15px>';
echo '&nbsp;Cumple&nbsp;';
echo '<img src="fotos/s_okay.PNG" onclick="nueva_opc(1);" title="TODOS CUMPLEN" widht=15px height=15px>';
echo '</td></tr>';

$j=0;$k=0; $illega=0;$ico0=0;$ico1=0;$ico2=0;$ico3=0;$ico4=0;$ico5=0;$ico6=0;

while ($v_validar = mysql_fetch_array($rs_validar)) {

  $j++;$va="no"; $ico0=0;$ico1=0;$ico2=0;$ico3=0;$ico4=0;$ico5=0;$ico6=0;
  $k++;
  echo "<tr id='col".$k."'>";  
  echo "<td ALIGN='RIGHT' id=".'A'.$v_validar[8].">$v_validar[0]</td>";
  echo "<td id=".'B'.$v_validar[8].'>'.$v_validar[1].'</td>';
  echo "<td align='RIGHT' id=".'C'.$v_validar[8]."> $v_validar[2]</td>";
  
  //echo "<td align='CENTER' id=".'E'.$v_validar[8].'>'.$v_validar[3].'</td>';
  
  echo "<td align='RIGHT' id=".'F'.$v_validar[8].">$v_validar[4]</td>";
  echo "<td id=".'G'.$v_validar[8].">$v_validar[5]</td>";

  echo "<td align='RIGHT' id=".'I'.$v_validar[8].">$v_validar[6]</td>";
  echo "<td align='RIGHT' id=".'J'.$v_validar[8].">$v_validar[7]</td>";

  echo "<td align='CENTER' id=".'H'.$v_validar[8].">$v_validar[8]</td>";
  echo "<td align='CENTER' id=".'K'.$v_validar[8].">$v_validar[11]</td>";

  echo "<td ALIGN='CENTER'>";
  if ($como_ves!='DETALLE'){ echo "<INPUT TYPE=TEXT NAME='res".$k."' id='res".$k."'  SIZE='12' VALUE=". $v_validar[9].'>';}
  else{ echo  $v_validar[9];}
?>
</td>
<td ALIGN='CENTER'>
<?  if ($como_ves!='DETALLE'){
    echo '<label><input type="radio" value="No" name="cum'.$k.'" id="cumn'.$k.'"';
    if ($v_validar[10]=="No") {echo ' checked ';}
    echo '/> No</label>&nbsp;&nbsp;';
    echo '<label><input type="radio" value="Si" name="cum'.$k.'" id="cums'.$k.'"';
    if ($v_validar[10]!="No") {echo ' checked ';}
      echo '/> Si</label>&nbsp;&nbsp;'; }
  else{ echo  $v_validar[10];}
?>  
  </td></tr>
<?
}
echo "<caption color style='background:#99FF33'>Complete los Resultados del An&aacutelisis ID=".$analisis_id." por favor</caption></table>";

echo '<table border="0" id="cabeza">';
//echo '<tr><td><span onclick="nueva_nota('."'Volver'".');">Volver</span>';
if ($como_ves!='DETALLE'){
  echo '<tr><td><span onclick="nueva_nota('."'Volver'".');">Volver</span>';
  echo '<span onclick="nueva_nota('."'Grabar".$k."'".');">Grabar el Resultado</span>';}
else
{
  echo '<tr><td><span onclick="nueva_nota('."'Vuelve'".');">Volver</span>';
}
echo '<td><span onclick="nueva_nota('."'XLS'".');">Salida</span>';

echo '</td></tr></table>';

echo "<INPUT TYPE=HIDDEN NAME='prov_id' id='prov_id' VALUE='".$prov_id."'>";
echo "<INPUT TYPE=HIDDEN NAME='campo_id' id='campo_id' VALUE='".$campo_id."'>";
echo "<INPUT TYPE=HIDDEN NAME='almacen_id' id='almacen_id' VALUE='".$almacen_id."'>";
echo "<INPUT TYPE=HIDDEN NAME='lote' id='lote' VALUE='".$lote."'>";


echo "<INPUT TYPE=HIDDEN NAME='hora_final' id='hora_final' VALUE=''>";
echo "<INPUT TYPE=HIDDEN NAME='como_ves' id='como_ves' VALUE='".$como_ves."'>";
echo "<INPUT TYPE=HIDDEN NAME='valk' id='valk' VALUE='".$k."'>";
echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";
echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
if ($como_ves!='DETALLE'){
  echo '<script type="text/javascript">';
  echo 'Calendar.setup({';
  echo ' inputField     :    "fecha_fin", ';
  echo ' ifFormat       :    "%d-%m-%Y",  ';
  echo '       showsTime      :    false,';
  echo '       disableDateBefore: "4-10-2012",';
  echo '     timeFormat     :    "24"  });';
echo ' </script>';
}
?>
</BODY>
</HTML>




