<?session_start();
include_once("funciones.php");
$nivel_dato=$_SESSION["acceso_acc"];
$ccli=$_SESSION["acceso_sector"];
$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);

$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=12 and acceso="on"';
$r=mysql_query($a,$cx_validar);$i=0;
while ($v = mysql_fetch_array($r)) {
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;break;
}
if ($i<1) {$_SESSION["mensaje"]="NO TIENE ACCESO CON ESTA CLAVE";header("Location: ../index.php"); }
else { 

$last_ing = date("Y-m-d H:i:s"); ;
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='stockt.php'  where id_usuario=".$_SESSION["id_usuario"] ;
mysql_query($actualizar,$cx_validar);
$actualizar='DELETE FROM '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="stk"';
mysql_query($actualizar,$cx_validar);
$lote_array[]=-1;$exclusivo="No";$dist_almacen="No";$or_alm=0;
$prov_id=0;$campo_id=0;$r='';$lote='';$litros='';
$sub=".";$forzar="NO";$leyforzar="";
$orden=$_REQUEST["orden"];
$exclusivo=$_REQUEST["exclusivo"]; if (strlen($exclusivo)<2){$exclusivo="No";}
$busca=$_REQUEST["BUSCA"];if (strlen($busca)<1) {$busca=0;}
$vista=$_REQUEST["Vista"];if (strlen($vista)<1) {$vista="Lote";}

$quees=$_REQUEST["QUEES"];$num_sel=0;$anal_no_hay=0;
foreach ($_POST as $indice => $valor){
  //s echo $indice.".".$valor.'<br>';
  if (substr($indice,0,3)=='stk')
  { 
    $p=substr($indice,3);
    if ($p<> FALSE){
      $num_sel++;
      $l=strlen($p);$t=substr($p,0,3);$n=substr($p,3,13);$l=$l-16;$p=substr($p,-$l);
      if ( (($vista=="Lote") and !(($t=="PRE") or ($t=="EMB"))) or (($vista!="Lote") and (($t=="PRE") or ($t=="EMB") )  ) ) {      
        $a='SELECT almac_id_des FROM '.$_SESSION["tabla_mov_cabecera"].' where nro_mov="'.$n.'"';
        $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {$des=$v[0]; break;}
        if ($or_alm==0) {$or_alm=$des;}
        if ($or_alm!=$des) {$dist_almacen="Si";}       
        $actualizar='INSERT INTO '.$_SESSION["tabla_respuesta"].' (`login`,`respuesta`,`marca1`,`marca2`,`valor1`,`valor2`) ';
        $actualizar=$actualizar." VALUES ( '".$_SESSION["acceso_logg"]."','stk','".$t."','".$n."',".$p.",".$des.")"; 
        mysql_query($actualizar,$cx_validar);
        $lote_array[]=$p;
      }
    }
  }
  if ($indice=='ID'){$ID=$valor;}
}

if  ($ID=='NNULA') {
  // revierto el preembarque
  $a='select marca1,marca2,valor1,valor2 FROM '.$_SESSION["tabla_respuesta"]." where login='".$_SESSION["acceso_logg"]."' and respuesta='stk'"; 
  $r=mysql_query($a,$cx_validar);
  while ($v = mysql_fetch_array($r)) { $tm=$v[0];$nro_mov=$v[1];$lote=$v[2];break;}

  $a2='UPDATE '.$_SESSION["tabla_mov_cabecera"].' set tipo_mov="APR", estado="ANULADO" , nro_mov="AN"'.substr($nro_mov,2,11).'" where nro_mov="'.$nro_mov.'"';
  mysql_query($a2,$cx_validar);

  $a2='UPDATE '.$_SESSION["tabla_mov_detalle"].' set nro_mov_baja="             " where nro_mov_baja="'.$nro_mov.'"';
  mysql_query($a2,$cx_validar);

  $a2='DELETE FROM '.$_SESSION["tabla_mov_detalle"].' where nro_mov="'.$nro_mov.'"';
  mysql_query($a2,$cx_validar);
  
  $a2='DELETE FROM '.$_SESSION["tabla_mov_lotes"].' where nro_mov_des="'.$nro_mov.'"';
  mysql_query($a2,$cx_validar);
}


$a='SELECT mov_detalle.tipo_mov,mov_cabecera.fecha,mov_detalle.nro_mov,mov_cabecera.almac_id_ori,almacenes.razon_social,';
$a=$a.'mov_cabecera.sala_ext,mov_detalle.lote_ext,mov_detalle.lote_id,mov_detalle.cosecha,mov_cabecera.fecha_vto,';
$a=$a.'mov_det_anal.analisis_id,';
$a=$a.'mov_detalle.tipo_campo,mov_detalle.cumple FROM '.$_SESSION["tabla_mov_detalle"].' INNER JOIN ';
$a=$a.$_SESSION["tabla_mov_cabecera"].' on mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
$a=$a.$_SESSION["tabla_mov_det_anal"].' on (mov_detalle.lote_id=mov_det_anal.lote_id and mov_detalle.sublote_id=mov_det_anal.sublote_id ) INNER JOIN ';
$a=$a.$_SESSION["tabla_almacenes"].' on mov_cabecera.almac_id_ori=almacenes.almacen_id ';
if (strlen($quees)>1){
  if ($quees=="lote"){
    if ($busca>0){
      if ($vista=="Lote"){$a=$a.' where mov_detalle.lote_id='.$busca.' and (mov_detalle.tipo_mov="EXA") and not(mov_detalle.tipo_mov="PRE" or mov_detalle.tipo_mov="EMB")  and mov_detalle.nro_mov_baja="            " ';}
      else { $a=$a.'where mov_detalle.lote_id="'.$busca.'" and (mov_detalle.tipo_mov="PRE" or mov_detalle.tipo_mov="EMB")  and mov_detalle.nro_mov_baja="            " ';}
      $r=mysql_query($a,$cx_validar);$hay=0;
  
      while ($v = mysql_fetch_array($r)) {$hay++;$t=$v[0];$n=$v[2];
        $a1='select login  from '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="stk"  and valor1="'.$busca.'"';
        $r1=mysql_query($a1,$cx_validar);$i=0;
        while ($v1 = mysql_fetch_array($r1)) {$i++;break;}
        if ($i<1){
          $actualizar='INSERT INTO '.$_SESSION["tabla_respuesta"].' (`login`,`respuesta`,`marca1`,`marca2`,`valor1`) ';
          $actualizar=$actualizar." VALUES ( '".$_SESSION["acceso_logg"]."','stk','".$t."','".$n."',".$busca.")"; 
          mysql_query($actualizar,$cx_validar);
        }
        if (in_array($busca,$lote_array)){}
        else { $lote_array[]=$busca;}
    
        $a='SELECT COUNT(*) FROM '.$_SESSION["tabla_mov_det_anal"].' where lote_id='.$busca.' and nro_mov="'.$n.'" and analisis_id>0';
        $r=mysql_query($a,$cx_validar);while ($v = mysql_fetch_array($r)) {$anal_no_hay=$v[0]; break;}

        break;
      }
    }
    else {$quees='';}  
  }

  if ($quees=="nro_mov"){
    if (strlen($busca)>0){
      $bus='0003-'.substr('00000000'.$busca,-8);
      $anal_no_hay=0;
      if ($vista=="Lote"){ $a=$a.'where mov_detalle.lote_ext="'.$busca.'" and not(mov_detalle.tipo_mov="PRE" or mov_detalle.tipo_mov="EMB") and mov_detalle.nro_mov_baja="            " ';}
      else { $a=$a.'where mov_detalle.lote_ext="'.$busca.'"  and (mov_detalle.tipo_mov="EXA") and (mov_detalle.tipo_mov="PRE" or mov_detalle.tipo_mov="EMB") and mov_detalle.nro_mov_baja="            " ';}
      $r=mysql_query($a,$cx_validar);$hay=0;
      while ($v = mysql_fetch_array($r)) {$hay++;$lote=$v[7];$t=$v[0];$n=$v[2];
        if ($hay>0){
          $a1='SELECT login FROM '.$_SESSION["tabla_respuesta"].' WHERE login="'.$_SESSION["acceso_logg"].'" and respuesta="stk"  and valor1="'.$lote.'"';
          $r1=mysql_query($a1,$cx_validar);$i=0;
          while ($v1 = mysql_fetch_array($r1)) {$i++;break;}
          if ($i<1){
            $actualizar='INSERT INTO '.$_SESSION["tabla_respuesta"].' (`login`,`respuesta`,`marca1`,`marca2`,`valor1`) ';
            $actualizar=$actualizar." VALUES ( '".$_SESSION["acceso_logg"]."','stk','".$t."','".$n."',".$lote.")"; 
            mysql_query($actualizar,$cx_validar);
          }
          if (in_array($lote,$lote_array)){}
          else { $lote_array[]=$lote;}
          $a1='SELECT COUNT(*) FROM '.$_SESSION["tabla_mov_det_anal"].' where lote_id='.$lote.' and nro_mov="'.$bus.'" and analisis_id>0';
          $r1=mysql_query($a1,$cx_validar);while ($v1 = mysql_fetch_array($r1)) {$anal_no_hay=$v1[0]; break;}
        }
      }
    }
    else {$quees='';} 
  }
  if ($quees=="nro_anal"){
    if (strlen($busca)>0){
      if ($vista=="Lote"){ $a=$a.'where mov_det_anal.nro_anal="'.$busca.'" and (mov_detalle.tipo_mov="EXA") and not(mov_detalle.tipo_mov="PRE" or mov_detalle.tipo_mov="EMB") and mov_detalle.nro_mov_baja="            " ';}
      else { $a=$a.'where mov_det_anal.nro_anal="'.$busca.'" and (mov_detalle.tipo_mov="PRE" or mov_detalle.tipo_mov="EMB") and mov_detalle.nro_mov_baja="            " ';}
      $r=mysql_query($a,$cx_validar);$hay=0;
      while ($v = mysql_fetch_array($r)) {
        $hay++;$lote=$v[7];$t=$v[0];$n=$v[2];
        if ($hay>0){
          $a1='select login from '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="stk"  and valor1="'.$lote.'"';
          $r1=mysql_query($a1,$cx_validar);$i=0;
          while ($v1 = mysql_fetch_array($r1)) {$i++;}
          if ($i<1){
            $actualizar='INSERT INTO '.$_SESSION["tabla_respuesta"].' (`login`,`respuesta`,`marca1`,`marca2`,`valor1`) ';
            $actualizar=$actualizar." VALUES ( '".$_SESSION["acceso_logg"]."','stk','".$t."','".$n."',".$lote.")"; 
            mysql_query($actualizar,$cx_validar);
          }
          if (in_array($lote,$lote_array)){}
          else { $lote_array[]=$lote;}
  
          $af='SELECT COUNT(*) FROM '.$_SESSION["tabla_mov_det_anal"].' where lote_id='.$lote.' and nro_mov="'.$n.'" and analisis_id>0';
          $rf=mysql_query($a,$cx_validar);while ($vf = mysql_fetch_array($rf)) {$anal_no_hay=$vf[0]; break;}
        }
      }
    }
    else {$quees='';}  
  }
}
$num_sel=sizeof($lote_array)-1;

$prov_id=0;$campo_id=0;$r='';$lote='';$litros='';
$prov_id=$_REQUEST["prov_id"];
$campo_id=$_REQUEST["campo_id"];
$almacen_id=$_REQUEST["almacen_id"];
$lote=$_REQUEST["lote"];
$queveo=$_REQUEST["queveo"]; if (strlen($queveo)<2) {$queveo="TODO";}
$sub=".";$forzar="NO";$leyforzar="";
$orden=$_REQUEST["orden"];
$vista="Lote";
foreach ($_POST as $indice => $valor){
 // echo "$indice: $valor<br>";
   switch ($indice) {
    case 'filtro': $filtro=$valor; break;
    case 'campo': $campo=$valor ; break;
    case 'Submit': $sub=$valor; break;
    case 'ID': $ID=$valor;break;
    case 'Vista': $vista=$valor;break;
    case 'forzar': $forzar=$valor;break;
  }
}
if (strlen($vista)<1) {$vista="Lote";}
if (strlen($ID)>0){
  
  if ($ID=="ALTA"){

    if ($num_sel>0){
      if ($dist_almacen=="No")    {
        header("Location: alta_preemb1.php?r=ALTA"); echo '1';
      }
      else {
        if (strlen($busca)==6)
        {
          if ($busca=='FORZAR'){header("Location: alta_preemb1.php?r=ALTA"); echo '1';}
          else {  echo '<p class="rojo">Hay distintas almacenes en la selecci&oacute;n. Escriba FORZAR en buscar. Para Forzar la situaci&oacute;n</p>'; }
        }
        else {
          echo '<p class="rojo">Hay distintas almacenes en la selecci&oacute;n. Escriba FORZAR en buscar. Para Forzar la situaci&oacute;n</p>'; 
        }
      }
    }
    else {echo '<p class="rojo">Todav&iacutea no seleccion&oacute nada. No puedo procesar el Preembarque</p>';}
  }

  if ($ID=="MODI"){
    if ($num_sel>0){
      if ($dist_almacen=="No")    {
        header("Location: alta_preemb1.php?r=MODI"); echo '1';
      }
      else {
        if (strlen($busca)==6)
        {
          if ($busca=='FORZAR'){header("Location: alta_preemb1.php?r=ALTA"); echo '1';}
          else {  echo '<p class="rojo">Hay distintas almacenes en la selecci&oacute;n. Escriba FORZAR en buscar. Para Forzar la situaci&oacute;n</p>'; }
        }
        else {
          echo '<p class="rojo">Hay distintas almacenes en la selecci&oacute;n. Escriba FORZAR en buscar. Para Forzar la situaci&oacute;n</p>'; 
        }
      }
    }
    else {echo '<p class="rojo">Todav&iacutea no seleccion&oacute nada. No puedo Modificar el Preembarque</p>';}
  }

  if ($ID=="REGISTRO"){
    if ($num_sel>0){
      if ($dist_almacen=="No") {
        header("Location: alta_preemb2.php?r=ALTA"); echo '1';
      }
      else {echo '<p class="rojo">Hay distintas almacenes en la selecci&oacute;n. S&oacute;lo se Admite Mov. del Mimso Almac&eacute;n</p>';}
    }
   else {echo '<p class="rojo">Todav&iacutea no seleccion&oacute nada. No puedo Confirmar el Movimiento a Envasado</p>';}
  }
}

  $a='SELECT mov_detalle.tipo_mov,mov_cabecera.fecha,mov_detalle.nro_mov,mov_cabecera.almac_id_des,almacenes.razon_social,';
  $a=$a.'mov_cabecera.sala_ext,mov_detalle.lote_ext,mov_detalle.lote_id,mov_detalle.cosecha,mov_cabecera.fecha_vto,';
  $a=$a.'mov_det_anal.analisis_id,';
  $a=$a.'mov_detalle.tipo_campo,mov_detalle.cumple,mov_detalle.env_sec,env_secundario.abrev,mov_detalle.lote_env_sec,provedores.abrev,mov_cabecera.hora_cierre,mov_detalle.color,mov_detalle.lugar  FROM '.$_SESSION["tabla_mov_detalle"].' INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_cabecera"].' on mov_detalle.nro_mov=mov_cabecera.nro_mov INNER JOIN ';
  $a=$a.$_SESSION["tabla_provedores"].' on mov_detalle.prov_id=provedores.prov_id INNER JOIN ';
  $a=$a.$_SESSION["tabla_mov_det_anal"].' on (mov_detalle.lote_id=mov_det_anal.lote_id and mov_detalle.sublote_id=mov_det_anal.sublote_id ) INNER JOIN ';
  $a=$a.$_SESSION["tabla_env_secundario"].' on mov_detalle.env_sec=env_secundario.env_sec  INNER JOIN '; 
  $a=$a.$_SESSION["tabla_almacenes"].' on mov_cabecera.almac_id_des=almacenes.almacen_id where   (mov_detalle.tipo_mov="EXA") and  mov_detalle.tipo_mov!="PRE"  and mov_detalle.nro_mov_baja="            "  and mov_cabecera.hora_cierre="     " ' ;

  $b='';
   if ($queveo=="an_vacio") { $a=$a.' and mov_det_anal.analisis_id=0 ';}
  if ($queveo=="an_nak")   { $a=$a.' and mov_det_anal.analisis_id!=0  and mov_detalle.cumple="No" ';}
  if ($queveo=="an_ok")    { $a=$a.' and mov_det_anal.analisis_id!=0 and mov_detalle.cumple="Si" ';}

  if ($exclusivo=="No"){}
  else {
    if (strlen($quees)>1){
      if ($quees=="lote"){
        if ($busca>0){$a=$a.' and mov_detalle.lote_id='.$busca;}
      } 
  
      if ($quees=="nro_mov"){
        if ($busca>0){$a=$a.' and mov_detalle.lote_ext="'.$busca.'"';}
      } 
      if ($quees=="nro_anal"){
        if (strlen($busca)>0){$a=$a.' and mov_det_anal.nro_anal="'.$busca.'"';}
      } 
    }
  }
 


$color='';
IF (!empty($_SESSION["filtro_color"])){
  $c='SELECT valor_i,valor_f,color FROM '.$_SESSION["tabla_tipo_color"].' where color_id='.$_SESSION["filtro_color"];
  $rc=mysql_query($c,$cx_validar);while ($vc = mysql_fetch_array($rc)) {$valor_i=$vc[0];$valor_f=$vc[1];$color=$vc[2];break;}
}


if ($filtro !='   ')
{
  IF ( $campo == 'almacenes.razon_social' )   {$_SESSION["filtro_almacenes"]=$filtro; }
  IF ( $campo == 'productor.abrev' ) {$_SESSION["filtro_productor"]=$filtro; }
  IF ( $campo == 'sala_ext' ) {$_SESSION["filtro_sala_ext"]=$filtro; }
  IF ( $campo == 'lugar' ) {$_SESSION["filtro_lugar"]=$filtro; }
  IF ( $campo == 'color' ) {$_SESSION["filtro_color"]=$filtro; }

}



$Limite="";
?>
<!DOCTYPE html>
<head>
<TITLE>STOCK EN TRANSITO</TITLE>
<meta name="viewport" content="width=device-width,initial-scale=1">             
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="stock1.css" />
<link rel="shortcut icon" href="fotos/camion.ico">
<style type="text/css">
img {cursor: pointer;}
.cabecera {
  font: .8em Arial;
}
.cab1 {
  font: .8em Arial;
  cursor: pointer;
}
.rojo {color: red;}
#ent {display: none;}
</style>
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
    ele.onmouseover = function() {iluminarm(this,true)}
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
function seteom(obj,valor,i1,fo)
{ if (obj.id){
    fila = obj.parentNode;
    tilde=document.getElementById('stk'+fila.id.substring(3));
    if (tilde){
      tilde.checked=!(tilde.checked);
      if (tilde.checked) {
        tx=document.getElementById('num_sel');
        tx.value++;
      }
      else {
        tx=document.getElementById('num_sel');
        if (tx.value>0){tx.value--;}
      }
    }
  }
  poner1(i1);
}
function iluminarm(obj,l) { fi = obj.parentNode;
   ele = document.getElementById(fi.id);
   if (document.getElementById('stk'+fi.id.substring(3)).checked)
            {ele.style.background = 'Coral' ;}
       else {ele.style.background = 'Yellow' ;} }

function iluminarpm(obj) { fila = obj.parentNode; p=fila.id.substring(3);
      ele = document.getElementById(fila.id);

      if (document.getElementById('stk'+p).checked)
              {ele.style.background = 'Gold' ;}
         else {ele.style.background = 'LightSteelBlue' ;}}

function iluminarim(obj) {  fila = obj.parentNode;p=fila.id.substring(3);
      ele = document.getElementById(fila.id);
      if (document.getElementById('stk'+p).checked)
             {ele.style.background = 'Gold' ;}
        else {ele.style.background = 'LightCyan' ;}}


function poner1(colu){
  k1=colu;fi=0;
  tab=document.getElementById('tabla');
  for (i1=26; ele1=tab.getElementsByTagName('td')[i1]; i1=i1+k1) {
    fi = fi + 1;
    if (fi>=2) {fi=0;}
    switch(fi) {
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
for (x=1; document.getElementById('stk'+x) ; x++)
  {if (!(document.getElementById('stk'+x).checked)){document.getElementById('stk'+x).checked = !(document.getElementById('stk'+x).checked);}}
poner1(colu);
}
function desmarcar(colu){
for (x=1; document.getElementById('stk'+x) ; x++)
  {if (document.getElementById('stk'+x).checked){document.getElementById('stk'+x).checked = !(document.getElementById('stk'+x).checked);}}
poner1(colu);
}
function marco(elemento)
 {
  tx=document.getElementById('orden');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();}
function marcoq(elemento)
 {
  tx=document.getElementById('queveo');
  if (  tx.value==elemento) {tx.value='TODO';}
  else {tx.value=elemento;}
  btn=document.getElementById('ent');
  btn.click();}

function nueva_opcion(elemento)
 {
  tx=document.getElementById('QUEES');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();}

function nueva_nota(elemento)
 { 
  tx=document.getElementById('num_sel');
  tx.value=0;
  tx=document.getElementById('Eleccion');
  tx.value=elemento;
  btn=document.getElementById('ent');
  btn.click();}
-->
</script>
</head>
<?
echo "<body onload='ini(15); poner1(15);'>";
echo "<link rel='shortcut icon' href='fotos/icono1.ico'>";
echo "<form name='formulario' method='POST' action='stockt.php'>";
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
if ($orden == ".")
  {  }
else {
  $a=$a .' ORDER BY';

  switch ($orden) {
  case 'TIUP':$a=$a ." mov_detalle.lugar,mov_detalle.lote_id ";$xorden="Lugar en la Sala Ascendente"; break;
  case 'TIDN':$a=$a ." mov_detalle.lugar DESC,mov_detalle.lote_id DESC";$xorden="Lugar en la Sala Descendente";break;
 	case 'FDUP':$a=$a ." mov_cabecera.fecha ";$xorden="Fecha del Mov. Ascendente";break;
	case 'FDDN':$a=$a ." mov_cabecera.fecha DESC";$xorden="Fecha del Mov. Descendente";break;
	case 'NDUP':$a=$a ." mov_detalle.nro_mov  ";$xorden="N&ordm; Ultimo Documento Ascendente";break;
	case 'NDDN':$a=$a ." mov_detalle.nro_mov  DESC";$xorden="N&ordm; Ultimo Documento Descendente";break;
  case 'ALUP':$a=$a ." almacenes.razon_social ASC ";$xorden="Nombre del Almacen Ascendente";break;
  case 'ALDN':$a=$a ." almacenes.razon_social DESC";$xorden="Nombre del Almacen Descendente";break;
  case 'IPUP':$a=$a ." mov_cabecera.sala_ext ASC ";$xorden="Sala de Extracci&oacute;n Ascendente";break;
  case 'IPDN':$a=$a ." mov_cabecera.sala_ext DESC";$xorden="Sala de Extracci&oacute;n Descendente";break;
  case 'NPUP':$a=$a ." mov_detalle.lote_ext ASC , mov_detalle.lote_id ASC ";$xorden="Lote de Extracci&oacute; Ascendente";break;
  case 'NPDN':$a=$a ." mov_detalle.lote_ext DESC , mov_detalle.lote_id DESC";$xorden="Lote de Extracci&oacute; Descendente";break;
  case 'ACUP':$a=$a ." mov_detalle.cosecha ASC ";$xorden="A&ntilde;o de Cosecha Ascendente";break;
  case 'ACDN':$a=$a ." mov_detalle.cosecha DESC";$xorden="A&ntilde;o de Cosecha Descendente";break;
  case 'LOUP':$a=$a ." mov_detalle.lote_id ASC ";$xorden="Tambor Ascendente";break;
  case 'LODN':$a=$a ." mov_detalle.lote_id DESC";$xorden="Tambor Descendente";break;
  case 'SUUP':$a=$a ." mov_cabecera.fecha_vto ASC ";$xorden="Fecha de Vencimiento Ascendente";break;
  case 'SUDN':$a=$a ." mov_cabecera.fecha_vto DESC";$xorden="Fecha de Vencimiento Descendente";break;
  case 'AIUP':$a=$a ." mov_det_anal.analisis_id ASC ";$xorden="An&aacute;lisis ID Ascendente";break;
  case 'AIDN':$a=$a ." mov_det_anal.analisis_id DESC";$xorden="An&aacute;lisis ID Descendente";break;
  case 'NRUP':$a=$a ." mov_detalle.tipo_campo ASC ";$xorden="Tipo de Flora Ascendente";break;
  case 'NRDN':$a=$a ." mov_detalle.tipo_campo DESC";$xorden="Tipo de Flora Descendente";break;
  case 'CIUP':$a=$a ." env_secundario.nombre ASC ";$xorden="Envase Secundario Ascendente";break;
  case 'CIDN':$a=$a ." env_secundario.nombre DESC";$xorden="Envase Secundario Descendente";break;
  case 'CAUP':$a=$a ." mov_detalle.lote_env_sec ASC ";$xorden="Lote del Envase Secundario Ascendente";break;
  case 'CADN':$a=$a ." mov_detalle.lote_env_sec DESC";$xorden="Lote del Envase Secundario Descendente";break;
  case 'PRUP':$a=$a ." provedores.abrev ASC ";$xorden="Provedor Ascendente";break;
  case 'PRDN':$a=$a ." provedores.abrev DESC";$xorden="Provedor Descendente";break;
  default: $a=$a ." mov_detalle.nro_mov ASC";$xorden="Nro. de Mov.Ascendente"; break;
  }
}
$rs_validar = mysql_query($a,$cx_validar);

$busca='';
echo '<table border="0" id="cabeza">';
$a1="ALTA";$a2="REGISTRO";$a3="DETALLE";$a4="ANULA";$a5="MODI";
echo '<tr><td>Buscar&nbsp;&nbsp;&nbsp;&nbsp;Que es<br>';
echo "<INPUT TYPE='TEXT' NAME='BUSCA'  ID='BUSCA' VALUE='$busca' size=13";
if (strlen($quees)>1){echo ' autofocus ';}
echo " >";
echo '</td><td>';
echo '<span class="chico'; if ($quees=="nro_mov"){echo '_activo';}
echo '" onclick="nueva_opcion('."'nro_mov'".');">Lote</span>';
echo '<span class="chico'; if ($quees=="lote"){echo '_activo';}
echo '" onclick="nueva_opcion('."'lote'".');">Tambor</span>';
echo '<span class="chico'; if ($quees=="nro_anal"){echo '_activo';}
echo '" onclick="nueva_opcion('."'nro_anal'".');">N&ordm; An&aacute;.</span>';
echo '</td><td><span>Exclusivo<br>&nbsp;';
echo '<label><input name="exclusivo" type="radio" value="No"';
 if ($exclusivo!="Si"){echo ' checked ';}
echo' >No</label>&nbsp;&nbsp;';
echo '<label><input name="exclusivo" type="radio" value="Si"';
 if ($exclusivo=="Si"){echo ' checked ';}
 echo '>Si</label></span>';

echo '</td><td class="cabecera">Items&nbsp;<img src="fotos/s_okay.PNG" aling"left" width="12" height="12" border="0"><br>';
echo "<INPUT TYPE='TEXT' NAME='num_sel'  ID='num_sel' VALUE='$num_sel' size=3>";

echo '</td>';


echo '<td>';
echo "<a HREF='phpaxls.php?v=";echo $vista;echo "&q=$quees"."'"."' target='_blank'><img src='fotos/xls.JPG' alt='Salida a xls' title='Salida a XLS' aling'left' width='32' height='32' border='0'></a>";
echo "<a HREF='stapdf.php?v=";echo $vista;echo "&q=$quees"."'"."' target='_blank'><img src='fotos/pdf.JPG' alt='Salida a PDF' title='Salida a PDF' aling'left' width='32' height='32' border='0'></a>";
//echo "<a href='menu_1.php'><img src='fotos/reclamo_factura.JPG' alt='Vista Preliminar de lo Seleccionado' title='Vista Preliminar de lo Seleccionado' aling'left' width='32' height='32' border='0'></a>";
$ta='Vista Preliminar de lo Seleccionado';
echo "<img onclick='marco(".'"PREV"'.");' src='fotos/reclamo_factura.JPG' alt='".$ta."' title='".$ta."'  aling'left' width='32' height='32' border='0'>";

echo '</td>';



echo '</tr></table>';


echo "<table border='1' id='tabla' width='100%'>" ;
// coloco la linea de los filtros
echo "<tr class='cabecera' bgcolor='#FFFFFF'><td colspan='2'><a href='menu_1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='18' height='18' border='0'></a>";
echo '&nbsp;';

if ($vista!="Lote"){echo 'Mov. de Preembarque p/Confirmar';}
else { echo 'Datos del &Uacute;ltimo Movimiento';}

echo '</td><td align="CENTER"';
if (!empty($_SESSION["filtro_almacenes"])){
  echo " style='color: #F00'>".$_SESSION["filtro_almacenes"];
}
else {echo '>Donde Est&aacute';}

echo '</td><td align="CENTER">Lugar';
if (!empty($_SESSION["filtro_lugar"])){echo '<br>'.$filtro_lugar;}
echo '</td>';

echo '<td align="CENTER" colspan="2"';
if (!empty($_SESSION["filtro_sala_ext"])){
  echo " style='color: #F00'>".$_SESSION["filtro_sala_ext"].' y Lote';
}
else {echo '>Extracci&oacute;n<br>Sala y Lote';}



echo '</td><td>Tambor</td><td align="CENTER" >A&ntilde;o</td><td>Fecha Vto</td>';
echo '<td colspan="3">';
if ($vista=="Lote"){
  echo 'An&aacute;lisis Data';
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
}
else {
  echo 'Datos de Preembarque';
}

if (!empty($_SESSION["filtro_color"])){
  echo '<td><div  class="cab_cui">'.$color.'<br>'.$valor_i.'&nbsp;a&nbsp;'.$valor_f.'</div></td>';}
else {echo '<td align="CENTER">Color</td>';}





echo '<td align="CENTER">Envase</td><td align="CENTER" ';
if (!empty($_SESSION["filtro_productor"])){
  echo " style='color: #F00'>".$_SESSION["filtro_productor"];
}
else {echo '>Productor';}

echo '</td>';
echo '</tr><tr class="cabecera">';


$tb='Buscar una Fecha de Documento';
$ta='Ver x Fecha de Dto, Orden Ascendente';
$td='Ver x Fecha de Dto, Orden Descendente';
echo "<td><img onclick='marco(".'"FDUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
echo "&nbsp;Fec.<img onclick='marco(".'"FDDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
echo '</td>';

$tb='Buscar un Documento por su Nro.';
$ta='Ver x N&ordm de Dto., Orden Ascendente';
$td='Ver x N&ordm de Dto., Orden Descendente';
echo "<td><img onclick='marco(".'"NDUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
echo "&nbsp;Mov.N&ordm;</a>";
echo "&nbsp;<img onclick='marco(".'"NDDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
echo '</td>';

$tb='Buscar un Lugar de Acopio';
$ta='Ver x Lugar de Acopio, Orden Ascendente';
$td='Ver x Lugar de Acopio, Orden Descendente';
echo "<td>";
if (empty($_SESSION["filtro_almacenes"])){
  echo "<img onclick='marco(".'"ALUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
}
echo "&nbsp<a href='filtro.php?campo=almacenes.razon_social'><img src='fotos/busca.jpg' alt='".$tb."' title='".$tb."' aling'left' width='16' height='17' border='0'></a>";
if (empty($_SESSION["filtro_almacenes"])){
  echo "&nbsp;<img onclick='marco(".'"ALDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
}
echo '</td>';

$tb='Buscar un Lugar en la Sala';
$ta='Ver x Lugaren la sala  de Acopio, Orden Ascendente';
$td='Ver x Lugar en la sala de Acopio, Orden Descendente';
echo "<td>";
if (empty($_SESSION["filtro_lugar"])){
  echo "<img onclick='marco(".'"TIUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
}
echo "<a href='filtro.php?campo=lugar'><img src='fotos/busca.jpg' alt='".$tb."' title='".$tb."' aling'left' width='16' height='17' border='0'></a>";
if (empty($_SESSION["filtro_lugar"])){
  echo "<img onclick='marco(".'"TIDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
}
echo '</td>';


$tb='Buscar una Sala de Extraccion';
$ta='Ver x ID de Producto, Orden Ascendente';
$td='Ver x ID de Producto, Orden Descendente';
echo "<td>";
if (empty($_SESSION["filtro_sala_ext"])){
  echo "<img onclick='marco(".'"IPUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
}
echo "&nbsp<a href='filtro.php?campo=sala_ext'><img src='fotos/busca.jpg' alt='".$tb."' title='".$tb."' aling'left' width='16' height='17' border='0'></a>";
if (empty($_SESSION["filtro_sala_ext"])){
  echo "&nbsp;<img onclick='marco(".'"IPDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'></td>";
}

$tb='Buscar Lote de Extraccion ';
$ta='Ver x Producto Abrev., Orden Ascendente';
$td='Ver x Producto Abrev., Orden Descendente';
echo "<td>&nbsp;<img onclick='marco(".'"NPUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
echo '&nbsp;';
echo "<img onclick='marco(".'"NPDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
echo '</td>';

$tb='Buscar un Tambor ';
$ta='Ver x Lote, Orden Ascendente';
$td='Ver x Lote, Orden Descendente';
echo "<td><img onclick='marco(".'"LOUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
echo "&nbsp;<img onclick='marco(".'"LODN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
echo '</td>';

$tb='Buscar Cosecha ';
$ta='Ver x Sublote, Orden Ascendente';
$td='Ver x Sublote, Orden Descendente';
echo "<td><img onclick='marco(".'"ACUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
echo "&nbsp;<img onclick='marco(".'"ACDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
echo '</td>';

$tb='Buscar x Fecha de Vencimiento ';
$ta='Ver x Fecha de Vencimiento, Orden Ascendente';
$td='Ver x Fecha de Vencimiento, Orden Descendente';
echo "<td><img onclick='marco(".'"SUUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
echo "&nbsp;<img onclick='marco(".'"SUDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
echo '</td>';


if ($vista=="Lote"){

$tb='Buscar un An&aacute;lisis ID ';
$ta='Ver x An&aacute;lisis ID, Orden Ascendente';
$td='Ver x An&aacute;lisis ID, Orden Descendente';
echo "<td><img onclick='marco(".'"AIUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
echo '';
echo "<img onclick='marco(".'"AIDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
echo '</td>';

$tb='Buscar un N&uacute;mero de An&aacute;lisis  ';
$ta='Ver x N&uacute;mero de An&aacute;lisis, Orden Ascendente';
$td='Ver x N&uacute;mero de An&aacute;lisis, Orden Descendente';
echo "<td><img onclick='marco(".'"NRUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
echo "T.Flora</a>"; 
echo "&nbsp;<img onclick='marco(".'"NRDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
echo '</td>';
echo '<td>ok</td>';
}
else {
  echo '<td>Cliente</td><td>Pais</td><td>Exporta</td>';
}


$tb='Buscar un Color';
echo "<td>&nbsp;<a href='filtroc.php?v=stockt.php'><img src='fotos/busca.jpg' alt='".$tb."' title='".$tb."' aling'left' width='16' height='17' border='0'></a>";
echo '</td>';

$tb='Buscar un Envase';
$ta='Ver x Envase, Orden Ascendente';
$td='Ver x Envase, Orden Descendente';
echo '<td>';
if (empty($_SESSION["filtro_envase"])){
  echo "<img onclick='marco(".'"CIUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='8' height='12' border='0'>&nbsp;";
}
echo "<a href='filtro.php?campo=envase_sec.Abrev'><img src='fotos/busca.jpg' alt='".$tb."' title='".$tb."' aling'left' width='16' height='17' border='0'></a>";
if (empty($_SESSION["filtro_envase"])){
  echo "<img onclick='marco(".'"CIDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='8' height='12' border='0'>";
}
echo '</td>';

$tb='Buscar un Productor ';
$ta='Ver x Productor de Origen, Orden Ascendente';
$td='Ver x Productor de Origen, Orden Descendente';
echo "<td>";
if (empty($_SESSION["filtro_productor"])){
  echo "<img onclick='marco(".'"PRUP"'.");' src='fotos/up.ico' alt='".$ta."' title='".$ta."'  aling'left' width='12' height='12' border='0'>";
}
echo "&nbsp<a href='filtro.php?campo=productor.abrev'><img src='fotos/busca.jpg' alt='".$tb."' title='".$tb."' aling'left' width='16' height='17' border='0'></a>";
if (empty($_SESSION["filtro_productor"])){
  echo "&nbsp<img onclick='marco(".'"PRDN"'.");' src='fotos/down.ico' alt='".$td."' title='".$td."' aling'left' width='12' height='12' border='0'>";
}
echo '</td>';


echo '</tr>';

$j=0;$k=0; $illega=0;$ico0=0;$ico1=0;$ico2=0;$ico3=0;$ico4=0;$ico5=0;$ico6=0;
if (!empty($_SESSION["filtro_almacenes"])){$illega++;}
if (!empty($_SESSION["filtro_productor"])){$illega++;}
if (!empty($_SESSION["filtro_sala_ext"])){$illega++;}
if (!empty($_SESSION["filtro_color"])){$illega++;}
if (!empty($_SESSION["filtro_lugar"])){$illega++;}

while ($v_validar = mysql_fetch_array($rs_validar)) {

  $j++;$va="no"; $ico0=0;$ico1=0;$ico2=0;$ico3=0;$ico4=0;$ico5=0;$ico6=0;
  if ( empty($_SESSION["filtro_productor"]) && empty($_SESSION["filtro_almacenes"]) && empty($_SESSION["filtro_sala_ext"]) && empty($_SESSION["filtro_lugar"]) && empty($_SESSION["filtro_color"]) )
    {$va="si";}
  else {
    if (!empty($_SESSION["filtro_almacenes"])){
      if ( $v_validar[4] == $_SESSION["filtro_almacenes"]) {$ico2=1;}
    }
    if (!empty($_SESSION["filtro_productor"]) ){
      if ( $v_validar[16] == $_SESSION["filtro_productor"] ){$ico3=1;}
    }
    if (!empty($_SESSION["filtro_sala_ext"]) ){
      if ( $v_validar[5] == $_SESSION["filtro_sala_ext"] ){$ico1=1;}
    }
    if (!empty($_SESSION["filtro_color"]) ){
      if ( ($v_validar[18] >= $valor_i ) && ($v_validar[18] <= $valor_f ) ) {$ico4=1;}
    }
    if (!empty($_SESSION["filtro_lugar"]) ){
      if ( $v_validar[19] == $_SESSION["filtro_lugar"] ){$ico5=1;}
    }

    IF ($illega <= ($ico0+$ico1+$ico2+$ico3+$ico4+$ico5+$ico6 )) {$va="si";}
  }
  if ($va=="si"){
  $k++;
  if ( ($orden!='PREV') or ( ($orden=='PREV') and (in_array($v_validar[7], $lote_array))))
  {
  if (strlen($v_validar[3])<1) {$v_validar[3]='&nbsp;';}
  echo "<tr id='col".$k."'>";  
  echo "<td class='cab1' ALIGN='LEFT' id=".'A'.$v_validar[7].">";
  echo "<input type='checkbox' value='0' name='stk".$v_validar[0].$v_validar[2].$v_validar[7]."'  id='stk".$k."'"; 
  if (in_array($v_validar[7], $lote_array)){echo ' checked="checked" ';}
  echo ' />'.substr($v_validar[1],-2).substr($v_validar[1],4,4).substr($v_validar[1],2,2).'</td>';
  echo "<td class='cab1' align='LEFT' id=".'C'.$v_validar[7]."> $v_validar[2]</td>";
  echo "<td class='cab1'align='LEFT' id=".'D'.$v_validar[7].'>'.$v_validar[4];
  
  if ($vista=="Lote"){
    if (( $v_validar[0]!="EXT") and (strlen(trim($v_validar[17]))<2)) { echo '&nbsp;<img src="fotos/CAM_ING.JPG" width="25" height="22" border="0">';}   
  }
  echo '</td>';
  echo "<td class='cab1'align='RIGHT' id=".'B'.$v_validar[7].'>'.$v_validar[19].'</td>';

  echo "<td class='cab1' align='RIGHT' id=".'E'.$v_validar[7].">$v_validar[5]</td>";
  echo "<td class='cab1' align='RIGHT' id=".'F'.$v_validar[7].">$v_validar[6]</td>";

  echo "<td class='cab1' align='RIGHT' id=".'G'.$v_validar[7].">$v_validar[7]</td>";
  echo "<td class='cab1' align='RIGHT' id=".'H'.$v_validar[7].">$v_validar[8]</td>";

  echo "<td class='cab1' align='CENTER' id=".'I'.$v_validar[7].">".substr($v_validar[9],-2).substr($v_validar[9],4,4).substr($v_validar[9],2,2)."</td>";
  if ($vista=="Lote"){  
    echo "<td class='cab1' align='RIGHT' id=".'J'.$v_validar[7].">$v_validar[10]</td>";
    echo "<td class='cab1' id=".'K'.$v_validar[7].">$v_validar[11]</td>";
    echo "<td align='CENTER' id=".'L'.$v_validar[7].">$v_validar[12]</td>";
  }
  else {
    $ax='select razon_social FROM '.$_SESSION["tabla_clientes"].' where cliente_id='.$v_validar[18];
    $rx=mysql_query($ax,$cx_validar);
    while ($vx = mysql_fetch_array($rx)) {$t1=$vx[0];break;}
    $ax='select pais FROM '.$_SESSION["tabla_paises"].' where pais_id='.$v_validar[19];
    $rx=mysql_query($ax,$cx_validar);
    while ($vx = mysql_fetch_array($rx)) { $pais=$vx[0];break;}

    $ax='select abrev FROM '.$_SESSION["tabla_almacenes"].' where almacen_id='.$v_validar[20];
    $rx=mysql_query($ax,$cx_validar);   
    while ($vx = mysql_fetch_array($rx)) {$exp_abrev=$vx[0];break;}
    
    echo '<td class="cab1" id="'.'J'.$v_validar[7].'">'.$t1.'</td><td class="cab1"  id="'.'K'.$v_validar[7].'">'.$pais.'</td><td class="cab1" id="'.'L'.$v_validar[7].'">'.$exp_abrev.'</td>';
  }

  
  echo "<td align='RIGHT' class='cab1' id=".'M'.$v_validar[7].'>'.$v_validar[18].'</td>';

  echo "<td class='cab1' align='LEFT' id=".'N'.$v_validar[7].">$v_validar[14]</td>";
  echo "<td  class='cab1' align='LEFT' id=".'O'.$v_validar[7].">$v_validar[16]</td>";
  echo "</tr>" ;
  }
}
}

echo "<caption  color style='background:#99FF33'>";
if ($orden=='PREV'){
  echo 'PRODUCTOS EN TR&Aacute;NSITO SELECCIONADOS';
}
else {  
  echo 'Productos en Tr&aacute;nsito, Ordenados por '.$xorden;
  echo ".  .  . Se leyeron ".$j." registros";
  if ( ($k > 0) && ($k!=$j) ) {echo " y coinciden " .$k;}
}
echo "</caption></table>";
echo "<a href='menu_1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";
echo "<INPUT TYPE=HIDDEN NAME='almacen_id' id='almacen_id' VALUE='".$almacen_id."'>";
echo "<INPUT TYPE=HIDDEN NAME='orden' id='orden' VALUE='IDUP'>";
echo "<INPUT TYPE=HIDDEN NAME='queveo' id='queveo' VALUE='".$queveo."'>";
echo "<INPUT TYPE=HIDDEN NAME='QUEES' id='QUEES' VALUE='".$quees."'>";
echo "<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>";
echo "<INPUT TYPE='Submit' VALUE=''  id='ent' width='1'> ";
echo "</form>";
}
?>
</BODY>
</HTML>




