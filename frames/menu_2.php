<?
session_start();
include_once("funciones.php");
$_SESSION["level_req"]="z";
$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
validar ($logg,$pass);
$nivel_dato=$_SESSION["acceso_acc"];
$nivel_dato=$_SESSION["acceso_acc"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$id_usuario=$_GET["i"];
$nombre=$_GET["n"];
$apellido=$_GET["a"];
if($id_usuario<1){
foreach ($_POST as $indice => $valor)
  {
//    echo "$indice: $valor<br>";
  switch ($indice) {
    case 'id_usuario': $id_usuario=$valor; break;
    case 'nombre': $nombre=$valor; break;
    case 'apellido': $apellido=$valor; break;

    case 'ac_clientes': $ac_clientes=$valor; break;
    case 'cli_alta': $cli_alta=$valor;$ac_clientes='on'; break;
    case 'cli_baja': $cli_baja=$valor;$ac_clientes='on'; break;
    case 'cli_modi': $cli_modi=$valor;$ac_clientes='on'; break;
    case 'ac_provedores': $ac_provedores=$valor; break;
    case 'prov_alta': $prov_alta=$valor;$ac_provedores='on'; break;
    case 'prov_baja': $prov_baja=$valor;$ac_provedores='on'; break;
    case 'prov_modi': $prov_modi=$valor;$ac_provedores='on'; break;
    case 'ac_almacenes': $ac_almacenes=$valor; break;
    case 'alma_alta': $alma_alta=$valor;$ac_almacenes='on'; break;
    case 'alma_baja': $alma_baja=$valor;$ac_almacenes='on'; break;
    case 'alma_modi': $alma_modi=$valor;$ac_almacenes='on'; break;
    case 'ac_productos': $ac_productos=$valor; break;
    case 'prod_alta': $prod_alta=$valor;$ac_productos='on'; break;
    case 'prod_baja': $prod_baja=$valor;$ac_productos='on'; break;
    case 'prod_modi': $prod_modi=$valor;$ac_productos='on'; break;
    case 'ac_primarios': $ac_primarios=$valor; break;
    case 'prim_alta': $prim_alta=$valor;$ac_primarios='on'; break;
    case 'prim_baja': $prim_baja=$valor;$ac_primarios='on'; break;
    case 'prim_modi': $prim_modi=$valor;$ac_primarios='on'; break;
    case 'ac_secundarios': $ac_secundarios=$valor; break;
    case 'secu_alta': $secu_alta=$valor;$ac_secundarios='on'; break;
    case 'secu_baja': $secu_baja=$valor;$ac_secundarios='on'; break;
    case 'secu_modi': $secu_modi=$valor;$ac_secundarios='on'; break;
    case 'ac_terciarios': $ac_terciarios=$valor; break;
    case 'terc_alta': $terc_alta=$valor;$ac_terciarios='on'; break;
    case 'terc_baja': $terc_baja=$valor;$ac_terciarios='on'; break;
    case 'terc_modi': $terc_modi=$valor;$ac_terciarios='on'; break;
    case 'ac_ti_mov': $ac_ti_mov=$valor; break;
    case 'timo_alta': $timo_alta=$valor;$ac_ti_mov='on'; break;
    case 'timo_baja': $timo_baja=$valor;$ac_ti_mov='on'; break;
    case 'timo_modi': $timo_modi=$valor;$ac_ti_mov='on'; break;
    case 'ac_ti_ana': $ac_ti_ana=$valor; break;
    case 'tian_alta': $tian_alta=$valor;$ac_ti_ana='on'; break;
    case 'tian_baja': $tian_baja=$valor;$ac_ti_ana='on'; break;
    case 'tian_modi': $tian_modi=$valor;$ac_ti_ana='on'; break;
    case 'ac_ti_alm': $ac_ti_alm=$valor; break;
    case 'tial_alta': $tian_alta=$valor;$ac_ti_alm='on'; break;
    case 'tial_baja': $tian_baja=$valor;$ac_ti_alm='on'; break;
    case 'tial_modi': $tian_modi=$valor;$ac_ti_alm='on'; break;

    case 'ac_despachantes': $ac_despachantes=$valor; break;
    case 'desp_alta': $desp_alta=$valor;$ac_despachantes='on'; break;
    case 'desp_baja': $desp_baja=$valor;$ac_despachantes='on'; break;
    case 'desp_modi': $desp_modi=$valor;$ac_despachantes='on'; break;
    case 'ac_aduanas': $ac_aduanas=$valor; break;
    case 'adu_alta': $adu_alta=$valor;$ac_aduanas='on'; break;
    case 'adu_baja': $adu_baja=$valor;$ac_aduanas='on'; break;
    case 'adu_modi': $adu_modi=$valor;$ac_aduanas='on'; break;
    case 'ac_pasos': $ac_pasos=$valor; break;
    case 'paso_alta': $paso_alta=$valor;$ac_pasos='on'; break;
    case 'paso_baja': $paso_baja=$valor;$ac_pasos='on'; break;
    case 'paso_modi': $paso_modi=$valor;$ac_pasos='on'; break;


    case 'ac_lib_act': $ac_ti_act=$valor; break;
    case 'liac_alta': $liac_alta=$valor;$ac_lib_act='on'; break;
    case 'liac_baja': $liac_baja=$valor;$ac_lib_act='on'; break;
    case 'liac_modi': $liac_modi=$valor;$ac_lib_act='on'; break;
    case 'ac_cer_sen': $ac_cer_sen=$valor; break;
    case 'cese_alta': $cese_alta=$valor;$ac_cer_sen='on'; break;
    case 'cese_baja': $cese_baja=$valor;$ac_cer_sen='on'; break;
    case 'cese_modi': $cese_modi=$valor;$ac_cer_sen='on'; break;
    case 'ac_cer_nac': $ac_cer_nac=$valor; break;
    case 'cena_alta': $cena_alta=$valor;$ac_cer_nac='on'; break;
    case 'cena_baja': $cena_baja=$valor;$ac_cer_nac='on'; break;
    case 'cena_modi': $cena_modi=$valor;$ac_cer_nac='on'; break;
    case 'ac_cer_prov': $ac_cer_prov=$valor; break;
    case 'cepr_alta': $cepr_alta=$valor;$ac_cer_prov='on'; break;
    case 'cepr_baja': $cepr_baja=$valor;$ac_cer_prov='on'; break;
    case 'cepr_modi': $cepr_modi=$valor;$ac_cer_prov='on'; break;
    case 'ac_cer_loc': $ac_cer_loc=$valor; break;
    case 'celo_alta': $celo_alta=$valor;$ac_cer_loc='on'; break;
    case 'celo_baja': $celo_baja=$valor;$ac_cer_loc='on'; break;
    case 'celo_modi': $celo_modi=$valor;$ac_cer_loc='on'; break;
    case 'ac_movcolcam': $ac_movcolcam=$valor; break;
    case 'mcolcam_alta': $mcolcam_alta=$valor;$ac_movcolcam='on'; break;
    case 'mcolcam_baja': $mcolcam_baja=$valor;$ac_movcolcam='on'; break;
    case 'mcolcam_modi': $mcolcam_modi=$valor;$ac_movcolcam='on'; break;
    case 'ac_movcolext': $ac_movcolext=$valor; break;
    case 'mcolext_alta': $mcolext_alta=$valor;$ac_movcolext='on'; break;
    case 'mcolext_baja': $mcolext_baja=$valor;$ac_movcolext='on'; break;
    case 'mcolext_modi': $mcolext_modi=$valor;$ac_movcolext='on'; break;
    case 'ac_extra': $ac_extra=$valor; break;

    case 'extra_alta': $extra_alta=$valor;$ac_extra='on'; break;
    case 'extra_baja': $extra_baja=$valor;$ac_extra='on'; break;
    case 'extra_modi': $extra_modi=$valor;$ac_extra='on'; break;

    case 'ac_muestra': $ac_muestra=$valor; break;
    case 'muestra_alta': $muestra_alta=$valor;$ac_muestra='on'; break;
    case 'muestra_baja': $muestra_baja=$valor;$ac_muestra='on'; break;
    case 'muestra_modi': $muestra_modi=$valor;$ac_muestra='on'; break;


    case 'ac_anali': $ac_anali=$valor; break;
    case 'anali_alta': $anali_alta=$valor;$ac_anali='on'; break;
    case 'anali_baja': $anali_baja=$valor;$ac_anali='on'; break;
    case 'anali_modi': $anali_modi=$valor;$ac_anali='on'; break;
    case 'ac_extacop': $ac_extacop=$valor; break;
    case 'extacop_alta': $extacop_alta=$valor;$ac_extacop='on'; break;
    case 'extacop_baja': $extacop_baja=$valor;$ac_extacop='on'; break;
    case 'extacop_modi': $extacop_modi=$valor;$ac_extacop='on'; break;
    case 'ac_extenv': $ac_extenv=$valor; break;
    case 'extenv_alta': $extenv_alta=$valor;$ac_extenv='on'; break;
    case 'extenv_baja': $extenv_baja=$valor;$ac_extenv='on'; break;
    case 'extenv_modi': $extenv_modi=$valor;$ac_extenv='on'; break;
    case 'ac_acoenv': $ac_acoenv=$valor; break;
    case 'acoenv_alta': $acoenv_alta=$valor;$ac_acoenv='on'; break;
    case 'acoenv_baja': $acoenv_baja=$valor;$ac_acoenv='on'; break;
    case 'acoenv_modi': $acoenv_modi=$valor;$ac_acoenv='on'; break;
    case 'ac_repro': $ac_repro=$valor; break;
    case 'repro_alta': $repro_alta=$valor;$ac_repro='on'; break;
    case 'repro_baja': $repro_baja=$valor;$ac_repro='on'; break;
    case 'repro_modi': $repro_modi=$valor;$ac_repro='on'; break;
    case 'ac_trasla': $ac_trasla=$valor; break;
    case 'trasla_alta': $trasla_alta=$valor;$ac_trasla='on'; break;
    case 'trasla_baja': $trasla_baja=$valor;$ac_trasla='on'; break;
    case 'trasla_modi': $trasla_modi=$valor;$ac_trasla='on'; break;
    case 'ac_ordemb': $ac_ordemb=$valor; break;
    case 'ordemb_alta': $ordemb_alta=$valor;$ac_ordemb='on'; break;
    case 'ordemb_baja': $ordemb_baja=$valor;$ac_ordemb='on'; break;
    case 'ordemb_modi': $ordemb_modi=$valor;$ac_ordemb='on'; break;
    case 'ac_rto': $ac_rto=$valor; break;
    case 'rto_alta': $rto_alta=$valor;$ac_rto='on'; break;
    case 'rto_baja': $rto_baja=$valor;$ac_rto='on'; break;
    case 'rto_modi': $rto_modi=$valor;$ac_rto='on'; break;
    case 'ac_stock': $ac_stock=$valor; break;
    case 'stk_alta': $stk_alta=$valor;$ac_stock='on'; break;
    case 'stk_baja': $stk_baja=$valor;$ac_stock='on'; break;
    case 'stk_modi': $stk_modi=$valor;$ac_stock='on'; break;
    case 'ac_stocklc': $ac_stocklc=$valor; break;
    case 'stklc_alta': $stklc_alta=$valor;$ac_stocklc='on'; break;
    case 'stklc_baja': $stklc_baja=$valor;$ac_stocklc='on'; break;
    case 'stklc_modi': $stklc_modi=$valor;$ac_stocklc='on'; break;
  }
}
if ($ac_movcolcam=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Mov_Col_Campos"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Mov_Col_Campos",1,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$mcolcam_alta.'",baja="'.$mcolcam_baja.'",modifica="'.$mcolcam_modi.'" where id_usuario='.$id_usuario.' and pantalla="Mov_Col_Campos"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Mov_Col_Campos"';mysql_query($a,$cx_validar);}

if ($ac_movcolext=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Mov_Col_Ext"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Mov_Col_Ext",2,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$mcolext_alta.'",baja="'.$mcolext_baja.'",modifica="'.$mcolext_modi.'" where id_usuario='.$id_usuario.' and pantalla="Mov_Col_Ext"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Mov_Col_Ext"';mysql_query($a,$cx_validar);}


if ($ac_extra=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Extraccion"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Extraccion",3,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$extra_alta.'",baja="'.$extra_baja.'",modifica="'.$extra_modi.'" where id_usuario='.$id_usuario.' and pantalla="Extraccion"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Extraccion"';mysql_query($a,$cx_validar);}


if ($ac_muestra=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Muestras"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Muestras",4,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$muestra_alta.'",baja="'.$muestra_baja.'",modifica="'.$muestra_modi.'" where id_usuario='.$id_usuario.' and pantalla="Muestras"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Muestras"';mysql_query($a,$cx_validar);}


if ($ac_anali=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Analisis"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Analisis",5,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$anali_alta.'",baja="'.$anali_baja.'",modifica="'.$anali_modi.'" where id_usuario='.$id_usuario.' and pantalla="Analisis"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Analisis"';mysql_query($a,$cx_validar);}

if ($ac_extacop=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Ext_Acop"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Ext_Acop",6,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$extacop_alta.'",baja="'.$extacop_baja.'",modifica="'.$extacop_modi.'" where id_usuario='.$id_usuario.' and pantalla="Ext_Acop"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Ext_Acop"';mysql_query($a,$cx_validar);}

if ($ac_extenv=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Ext_Env"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Ext_Env",7,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$extenv_alta.'",baja="'.$extenv_baja.'",modifica="'.$extenv_modi.'" where id_usuario='.$id_usuario.' and pantalla="Ext_Env"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Ext_Env"';mysql_query($a,$cx_validar);}


if ($ac_acoenv=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Aco_Env"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Aco_Env",8,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$acoenv_alta.'",baja="'.$acoenv_baja.'",modifica="'.$acoenv_modi.'" where id_usuario='.$id_usuario.' and pantalla="Aco_Env"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Aco_Env"';mysql_query($a,$cx_validar);}


if ($ac_repro=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Reprocesos"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Reprocesos",9,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$repro_alta.'",baja="'.$repro_baja.'",modifica="'.$repro_modi.'" where id_usuario='.$id_usuario.' and pantalla="Reprocesos"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Reprocesos"';mysql_query($a,$cx_validar);}


if ($ac_trasla=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Traslados"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Traslados",10,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$trasla_alta.'",baja="'.$trasla_baja.'",modifica="'.$trasla_modi.'" where id_usuario='.$id_usuario.' and pantalla="Traslados"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Traslados"';mysql_query($a,$cx_validar);}

if ($ac_rto=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Remitos"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Remitos",11,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$rto_alta.'",baja="'.$rto_baja.'",modifica="'.$rto_modi.'" where id_usuario='.$id_usuario.' and pantalla="Remitos"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Remitos"';mysql_query($a,$cx_validar);}

if ($ac_stock=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Stock"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Stock",12,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$stk_alta.'",baja="'.$stk_baja.'",modifica="'.$stk_modi.'" where id_usuario='.$id_usuario.' and pantalla="Stock"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Stock"';mysql_query($a,$cx_validar);}

if ($ac_stocklc=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Stocklc"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Stocklc",13,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$stklc_alta.'",baja="'.$stklc_baja.'",modifica="'.$stklc_modi.'" where id_usuario='.$id_usuario.' and pantalla="Stocklc"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Stocklc"';mysql_query($a,$cx_validar);}

if ($ac_ordemb=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="OrdEmb"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"OrdEmb",14,"Procesos")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$ordemb_alta.'",baja="'.$ordemb_baja.'",modifica="'.$ordemb_modi.'" where id_usuario='.$id_usuario.' and pantalla="OrdEmb"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="OrdEmb"';mysql_query($a,$cx_validar);}



if ($ac_cer_loc=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Loc"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Cert_Loc",5,"Imprime")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$celo_alta.'",baja="'.$celo_baja.'",modifica="'.$celo_modi.'" where id_usuario='.$id_usuario.' and pantalla="Cert_Loc"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Loc"';mysql_query($a,$cx_validar);}


if ($ac_cer_prov=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Prov"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Cert_Prov",4,"Imprime")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$cepr_alta.'",baja="'.$cepr_baja.'",modifica="'.$cepr_modi.'" where id_usuario='.$id_usuario.' and pantalla="Cert_Prov"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Prov"';mysql_query($a,$cx_validar);}

if ($ac_cer_nac=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Nac"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Cert_Nac",3,"Imprime")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$cena_alta.'",baja="'.$cena_baja.'",modifica="'.$cena_modi.'" where id_usuario='.$id_usuario.' and pantalla="Cert_Nac"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Nac"';mysql_query($a,$cx_validar);}

if ($ac_cer_sen=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Senasa"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Cert_Senasa",2,"Imprime")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$cese_alta.'",baja="'.$cese_baja.'",modifica="'.$cese_modi.'" where id_usuario='.$id_usuario.' and pantalla="Cert_Senasa"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Senasa"';mysql_query($a,$cx_validar);}

if ($ac_lib_act=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Actas"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Actas",1,"Imprime")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$liac_alta.'",baja="'.$liac_baja.'",modifica="'.$liac_modi.'" where id_usuario='.$id_usuario.' and pantalla="Actas"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Actas"';mysql_query($a,$cx_validar);}


if ($ac_ti_alm=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Tipos_Almacenes"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Tipos_Almacenes",10,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$tial_alta.'",baja="'.$tial_baja.'",modifica="'.$tial_modi.'" where id_usuario='.$id_usuario.' and pantalla="Tipos_Almacenes"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Tipos_Almacenes"';mysql_query($a,$cx_validar);}

if ($ac_ti_ana=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Tipos_Analisis"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Tipos_Analisis",9,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$tian_alta.'",baja="'.$tian_baja.'",modifica="'.$tian_modi.'" where id_usuario='.$id_usuario.' and pantalla="Tipos_Analisis"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Tipos_Analisis"';mysql_query($a,$cx_validar);}



if ($ac_ti_mov=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Tipos_movimientos"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Tipos_movimientos",8,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$timo_alta.'",baja="'.$timo_baja.'",modifica="'.$timo_modi.'" where id_usuario='.$id_usuario.' and pantalla="Tipos_movimientos"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Tipos_movimientos"';mysql_query($a,$cx_validar);}

if ($ac_terciarios=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Terciarios"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Terciarios",7,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$terc_alta.'",baja="'.$terc_baja.'",modifica="'.$terc_modi.'" where id_usuario='.$id_usuario.' and pantalla="Terciarios"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Terciarios"';mysql_query($a,$cx_validar);}

if ($ac_secundarios=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Secundarios"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Secundarios",6,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$secu_alta.'",baja="'.$secu_baja.'",modifica="'.$secu_modi.'" where id_usuario='.$id_usuario.' and pantalla="Secundarios"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Secundarios"';mysql_query($a,$cx_validar);}



if ($ac_primarios=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Primarios"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Primarios",5,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$prim_alta.'",baja="'.$prim_baja.'",modifica="'.$prim_modi.'" where id_usuario='.$id_usuario.' and pantalla="Primarios"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Primarios"';mysql_query($a,$cx_validar);}


if ($ac_productos=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Productos"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Productos",4,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$prod_alta.'",baja="'.$prod_baja.'",modifica="'.$prod_modi.'" where id_usuario='.$id_usuario.' and pantalla="Productos"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Productos"';mysql_query($a,$cx_validar);}

if ($ac_clientes=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Clientes"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Clientes",1,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$cli_alta.'",baja="'.$cli_baja.'",modifica="'.$cli_modi.'" where id_usuario='.$id_usuario.' and pantalla="Clientes"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Clientes"';mysql_query($a,$cx_validar);}

if ($ac_provedores=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Provedores"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Provedores",2,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set acceso="on",alta="'.$prov_alta.'",baja="'.$prov_baja.'",modifica="'.$prov_modi.'" where id_usuario='.$id_usuario.' and pantalla="Provedores"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Provedores"';mysql_query($a,$cx_validar);}

if ($ac_almacenes=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Almacenes"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Almacenes",3,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set  acceso="on",alta="'.$alma_alta.'",baja="'.$alma_baja.'",modifica="'.$alma_modi.'" where id_usuario='.$id_usuario.' and pantalla="Almacenes"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Almacenes"';mysql_query($a,$cx_validar);}
}


if ($ac_despachantes=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Despachantes"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Despachantes",11,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set  acceso="on",alta="'.$desp_alta.'",baja="'.$desp_baja.'",modifica="'.$desp_modi.'" where id_usuario='.$id_usuario.' and pantalla="Despachantes"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Despachantes"';mysql_query($a,$cx_validar);}


if ($ac_aduanas=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Aduanas"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Aduanas",12,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set  acceso="on",alta="'.$adu_alta.'",baja="'.$adu_baja.'",modifica="'.$adu_modi.'" where id_usuario='.$id_usuario.' and pantalla="Aduanas"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Aduanas"';mysql_query($a,$cx_validar);}


if ($ac_pasos=='on'){
  $a='SELECT acceso FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Pasos"';
  $r=mysql_query($a,$cx_validar);$i=0;while ($v = mysql_fetch_array($r)) {$i++;}
  if ($i<1){
    $a='INSERT INTO '.$_SESSION["tabla_acc_op"].' (`id_usuario` ,`pantalla`,`orden`,`proceso`) VALUES ('.$id_usuario.',"Pasos",13,"Tablas")'; mysql_query($a,$cx_validar);
  }
  $a='UPDATE '.$_SESSION["tabla_acc_op"].' set  acceso="on",alta="'.$paso_alta.'",baja="'.$paso_baja.'",modifica="'.$paso_modi.'" where id_usuario='.$id_usuario.' and pantalla="Pasos"';
  $r=mysql_query($a,$cx_validar);
}
else{ $a='DELETE FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Pasos"';mysql_query($a,$cx_validar);}



   
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <TITLE><?echo $_SESSION["acceso_logg"]."&nbsp&nbsp";?>DEFINIR ACCESOS AL SISTEMA </TITLE>
  <meta name="viewport" content="width=device-width,initial-scale=1">             
  <meta charset="utf-8" />
  <link rel="stylesheet" href="menu_2.css" />

<script type="text/javascript">
<!--
-->
</script>
</head>
<body>
<link rel="shortcut icon" href="fotos/chmiel.ico">
<form name='formulario' method='POST' action='menu_2.php'>
<?
echo "<a href='menu_1.php'><img src='fotos/arw03lt.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>&nbsp;&nbsp;";
echo 'DEFINICION DE LOS ACCESOS DEL USUARIO('.$id_usuario.'):'.$nombre.'&nbsp;'.$apellido;

echo '<table border="1">';
echo '<tr><TH colspan="5">Tablas</TH></tr>';




$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Clientes"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Clientes</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_clientes'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='cli_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='cli_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='cli_modi'>&nbsp;Modifica</label></TD></TR>";

$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Provedores"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Productores</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_provedores'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox' ";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='prov_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='prov_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='prov_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Almacenes"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Depósitos y Salas</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_almacenes'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='alma_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='alma_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='alma_modi'>&nbsp;Modifica</label></TD></TR>";
//
$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Almacenes"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Juan</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_almacenes'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='alma_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='alma_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='alma_modi'>&nbsp;Modifica</label></TD></TR>";

$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Productos"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Productos</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_productos'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='prod_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='prod_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='prod_modi'>&nbsp;Modifica</label></TD></TR>";




$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Tipos_movimientos"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Tipo de Movimientos</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_ti_mov'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo" name='timo_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='timo_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='timo_modi'>&nbsp;Modifica</label></TD></TR>";



$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Tipos_Analisis"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Tipos de An&aacute;lisis</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_ti_ana'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='tian_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo "name='tian_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='tian_modi'>&nbsp;Modifica</label></TD></TR>";



$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Tipos_Almacenes"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Tipos de Almacenes</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_ti_alm'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='tial_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='tial_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='tial_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Despachantes"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Despachantes</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_despachantes'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='desp_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='desp_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='desp_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Aduanas"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Aduanas</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_aduanas'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='adu_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='adu_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='adu_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Pasos"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Pasos Fronterizos</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_pasos'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='paso_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='paso_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='paso_modi'>&nbsp;Modifica</label></TD></TR>";




// echo '<tr><TH colspan="5">Imprime</TH></tr>';

// $a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Actas"';
// $r=mysql_query($a,$cx_validar);
// $v1="off";$v2="off";$v3="off";$v4="off";
// while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
// echo '<tr>';
// echo '<TD>Certificado Senasa</TD>';
// echo "<TD><label><input type='checkbox'";
// if ($v1=="on"){echo ' CHECKED ';}
// echo " name='ac_lib_act'>&nbsp;Acceso</label></TD>";
// echo "<TD><label><input type='checkbox'";
// if ($v2=="on"){echo ' CHECKED ';}
// echo " name='liac_alta'>&nbsp;Alta</label></TD>";
// echo "<TD><label><input type='checkbox'";
// if ($v3=="on"){echo ' CHECKED ';}
// echo " name='liac_baja'>&nbsp;Baja</label></TD>";
// echo "<TD><label><input type='checkbox'";
// if ($v4=="on"){echo ' CHECKED ';}
// echo " name='liac_modi'>&nbsp;Modifica</label></TD></TR>";


// $a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Senasa"';
// $r=mysql_query($a,$cx_validar);
// $v1="off";$v2="off";$v3="off";$v4="off";
// while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
// echo '<tr>';
// echo '<TD>Packing List</TD>';
// echo "<TD><label><input type='checkbox'";
// if ($v1=="on"){echo ' CHECKED ';}
// echo " name='ac_cer_sen'>&nbsp;Acceso</label></TD>";
// echo "<TD><label><input type='checkbox'";
// if ($v2=="on"){echo ' CHECKED ';}
// echo " name='cese_alta'>&nbsp;Alta</label></TD>";
// echo "<TD><label><input type='checkbox'";
// if ($v3=="on"){echo ' CHECKED ';}
// echo " name='cese_baja'>&nbsp;Baja</label></TD>";
// echo "<TD><label><input type='checkbox'";
// if ($v4=="on"){echo ' CHECKED ';}
// echo " name='cese_modi'>&nbsp;Modifica</label></TD></TR>";



// // $a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Nac"';
// // $r=mysql_query($a,$cx_validar);
// // $v1="off";$v2="off";$v3="off";$v4="off";
// // while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
// // echo '<tr>';
// // echo '<TD>Certificados Nacionales</TD>';
// // echo "<TD><label><input type='checkbox'";
// // if ($v1=="on"){echo ' CHECKED ';}
// // echo " name='ac_cer_nac'>&nbsp;Acceso</label></TD>";
// // echo "<TD><label><input type='checkbox'";
// // if ($v2=="on"){echo ' CHECKED ';}
// // echo " name='cena_alta'>&nbsp;Alta</label></TD>";
// // echo "<TD><label><input type='checkbox'";
// // if ($v3=="on"){echo ' CHECKED ';}
// // echo " name='cena_baja'>&nbsp;Baja</label></TD>";
// // echo "<TD><label><input type='checkbox'";
// // if ($v4=="on"){echo ' CHECKED ';}
// // echo " name='cena_modi'>&nbsp;Modifica</label></TD></TR>";



// // $a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Prov"';
// // $r=mysql_query($a,$cx_validar);
// // $v1="off";$v2="off";$v3="off";$v4="off";
// // while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
// // echo '<tr>';
// // echo '<TD>Certificados Provinciales</TD>';
// // echo "<TD><label><input type='checkbox'";
// // if ($v1=="on"){echo ' CHECKED ';}
// // echo " name='ac_cer_prov'>&nbsp;Acceso</label></TD>";
// // echo "<TD><label><input type='checkbox'";
// // if ($v2=="on"){echo ' CHECKED ';}
// // echo " name='cepr_alta'>&nbsp;Alta</label></TD>";
// // echo "<TD><label><input type='checkbox'";
// // if ($v3=="on"){echo ' CHECKED ';}
// // echo " name='cepr_baja'>&nbsp;Baja</label></TD>";
// // echo "<TD><label><input type='checkbox'";
// // if ($v4=="on"){echo ' CHECKED ';}
// // echo " name='cepr_modi'>&nbsp;Modifica</label></TD></TR>";


// // $a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Cert_Loc"';
// // $r=mysql_query($a,$cx_validar);
// // $v1="off";$v2="off";$v3="off";$v4="off";
// // while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
// // echo '<tr>';
// // echo '<TD>Certificados Locales</TD>';
// // echo "<TD><label><input type='checkbox'";
// // if ($v1=="on"){echo ' CHECKED ';}
// // echo " name='ac_cer_loc'>&nbsp;Acceso</label></TD>";
// // echo "<TD><label><input type='checkbox'";
// // if ($v2=="on"){echo ' CHECKED ';}
// // echo " name='celo_alta'>&nbsp;Alta</label></TD>";
// // echo "<TD><label><input type='checkbox'";
// // if ($v3=="on"){echo ' CHECKED ';}
// // echo " name='celo_baja'>&nbsp;Baja</label></TD>";
// // echo "<TD><label><input type='checkbox'";
// // if ($v4=="on"){echo ' CHECKED ';}
// // echo " name='celo_modi'>&nbsp;Modifica</label></TD></TR>";




echo '<tr><TH colspan="5">Registros/Procesos</TH></tr>';

$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Mov_Col_Campos"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Movimiento de Colmenas entre Campos</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_movcolcam'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='mcolcam_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='mcolcam_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='mcolcam_modi'>&nbsp;Modifica</label></TD></TR>";



$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Mov_Col_Ext"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Colmenas a Sala de Extracci&oacute;n</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_movcolext'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='mcolext_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='mcolext_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='mcolext_modi'>&nbsp;Modifica</label></TD></TR>";



$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Extraccion"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Extracci&oacute;n</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_extra'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='extra_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='extra_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='extra_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Muestras"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Personal de Campo</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_muestra'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='muestra_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='muestra_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='muestra_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Analisis"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>An&aacute;lisis de Muestras</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_anali'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='anali_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='anali_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='anali_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Ext_Acop"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Compra y Acopio</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_extacop'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='extacop_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='extacop_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='extacop_modi'>&nbsp;Modifica</label></TD></TR>";



$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Ext_Env"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Desde Extracci&oacute;n a Envasado</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_extenv'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='extenv_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='extenv_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='extenv_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Aco_Env"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Desde Acopio a Envasado</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_acoenv'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='acoenv_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='acoenv_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='acoenv_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Reprocesos"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Reprocesos de Productos</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_repro'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='repro_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='repro_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='repro_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Traslados"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Traslados de Producto Terminado</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_trasla'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='trasla_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='trasla_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='trasla_modi'>&nbsp;Modifica</label></TD></TR>";



// $a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Remitos"';
// $r=mysql_query($a,$cx_validar);
// $v1="off";$v2="off";$v3="off";$v4="off";
// while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
// echo '<tr>';
// echo '<TD>Remitos</TD>';
// echo "<TD><label><input type='checkbox'";
// if ($v1=="on"){echo ' CHECKED ';}
// echo " name='ac_rto'>&nbsp;Acceso</label></TD>";
// echo "<TD><label><input type='checkbox'";
// if ($v2=="on"){echo ' CHECKED ';}
// echo " name='rto_alta'>&nbsp;Alta</label></TD>";
// echo "<TD><label><input type='checkbox'";
// if ($v3=="on"){echo ' CHECKED ';}
// echo " name='rto_baja'>&nbsp;Baja</label></TD>";
// echo "<TD><label><input type='checkbox'";
// if ($v4=="on"){echo ' CHECKED ';}
// echo " name='rto_modi'>&nbsp;Modifica</label></TD></TR>";


$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Stock"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Stock</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_stock'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='stk_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='stk_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='stk_modi'>&nbsp;Modifica</label></TD></TR>";

$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="Stocklc"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Stock x Lugar/Acopio</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_stocklc'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='stklc_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='stklc_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='stklc_modi'>&nbsp;Modifica</label></TD></TR>";
$a='SELECT pantalla,acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and pantalla="OrdEmb"';
$r=mysql_query($a,$cx_validar);
$v1="off";$v2="off";$v3="off";$v4="off";
while ($v = mysql_fetch_array($r)) {$v1=$v[1] ;$v2=$v[2] ;$v3=$v[3] ;$v4=$v[4] ;break;}
echo '<tr>';
echo '<TD>Ordenes de Embarque</TD>';
echo "<TD><label><input type='checkbox'";
if ($v1=="on"){echo ' CHECKED ';}
echo " name='ac_ordemb'>&nbsp;Acceso</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v2=="on"){echo ' CHECKED ';}
echo " name='ordemb_alta'>&nbsp;Alta</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v3=="on"){echo ' CHECKED ';}
echo " name='ordemb_baja'>&nbsp;Baja</label></TD>";
echo "<TD><label><input type='checkbox'";
if ($v4=="on"){echo ' CHECKED ';}
echo " name='ordemb_modi'>&nbsp;Modifica</label></TD></TR>";



?>


</table>
<?
echo "<INPUT TYPE=HIDDEN NAME='id_usuario' id='id_usuario' VALUE=$id_usuario>";
echo "<INPUT TYPE=HIDDEN NAME='nombre' id='nombre' VALUE='".$nombre."'>";
echo "<INPUT TYPE=HIDDEN NAME='apellido' id='apellido' VALUE='".$apellido."'>";
?>
<INPUT TYPE=HIDDEN NAME='ID' id='Eleccion' VALUE='NA'>
<INPUT TYPE='submit' NAME='Submit' VALUE='Grabar'>

</form>
</BODY>
</HTML>
