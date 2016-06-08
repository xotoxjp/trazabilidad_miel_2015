<?php
session_start();
include_once("funciones.php");

$logg = $_SESSION["acceso_logg"];
$pass =$_SESSION["acceso_pass"];
$nivel_dato=$_SESSION["acceso_acc"];


$id_usuario=$_SESSION["id_usuario"];
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$a='SELECT acceso,alta,baja,modifica FROM '.$_SESSION["tabla_acc_op"].' where id_usuario='.$id_usuario.' and proceso="Procesos" and orden=6 and acceso="on" and alta="on"';
$r=mysql_query($a,$cx_validar);
$i=0;
while ($v = mysql_fetch_array($r)){
  $acceso=$v[0];
  $alta=$v[1];
  $baja=$v[2];
  $modifica=$v[3];
  $i++;
  break;
}

/*********************************************************************************/



$a='SELECT marca1,marca2,valor1,valor2 FROM '.$_SESSION["tabla_respuesta"]." WHERE login='".$_SESSION["acceso_logg"]."' AND respuesta='exa'"; 
$r=mysql_query($a,$cx_validar);
while ($v = mysql_fetch_array($r)) {$tm=$v[0];$nro_mov_a=$v[1];$lote=$v[2];break;}

$a='SELECT sala_ext,fecha_vto,lote_ext,prov_id FROM '.$_SESSION["tabla_mov_cabecera"].' where nro_mov="'.$nro_mov_a.'"';
$r=mysql_query($a,$cx_validar);
while ($v = mysql_fetch_array($r)) {$a_sala_ext=$v[0];$a_fecha_vto=$v[1];$a_lote_ext=$v[2];$prov_id=$v[3];break;}


$a='select abrev,razon_social,c1 FROM '.$_SESSION["tabla_provedores"].' where prov_id='.$prov_id;
$r=mysql_query($a,$cx_validar);

while ($v = mysql_fetch_array($r)) {$abrev=$v[0];$rs=$v[1];$renapa=$v[2];break;}


  // proceso el pedido del analisis actualizo las tablas y salgo

  $a='select valor2 FROM '.$_SESSION["tabla_respuesta"]." where login='".$_SESSION["acceso_logg"]."' and respuesta='exa'"; 
  $nl=0;
  $r=mysql_query($a,$cx_validar); while ($v = mysql_fetch_array($r)) {$almac_id_ori=$v[0];$nl++;}


  $a='SELECT boca,numero,tipo from '.$_SESSION["tabla_numeros"].' where id_documento=6';
  $rb = mysql_query($a,$cx_validar);
  while ($vb = mysql_fetch_array($rb)) {$boca=$vb[0];$numero=$vb[1];$tipo_mov=$vb[2]; break;}  
  $numero++; $num='00000000'.$numero; $nro_mov=$boca.'-'.substr($num,-8);
  $l=date("Y-m-d"); 
  $a1='UPDATE '.$_SESSION["tabla_numeros"]." set numero=".$numero.',fecha_ult_doc="'.$l.'" where id_documento=6';
  mysql_query($a1,$cx_validar);

  $h=date("Y-m-d H:i:s");$h=substr($h,-8);$h=substr($h,0,5);
   
  // alta en mov_cabecera,mov_detalle,mov_lotes
  // actualizo mov_detalle, 
  $a='INSERT INTO '.$_SESSION["tabla_mov_cabecera"].' (`fecha`,`hora`,`tipo_mov`,`nro_mov`,`almac_id_ori`, `almac_id_des`,';
  $a=$a.'`pers_id_ini`, `fecha_inicio`, `hora_inicio`,`cant_inic` ';
  $a=$a.") VALUES ('".$l."','".$h."','".$tipo_mov."','".$nro_mov."',".$almac_id_ori.',';
  $a=$a.$almacen_id.",".$pers_ini.",'".$fecha_inicial."','".$hora_inicio."',".$nl.')'; 
  mysql_query($a,$cx_validar);
    $n_nro_mov=$nro_mov;
  //echo $a;

    $a='select marca1,marca2,valor1,valor2 FROM '.$_SESSION["tabla_respuesta"]." where login='".$_SESSION["acceso_logg"]."' and respuesta='exa'"; 
    $r=mysql_query($a,$cx_validar);
    // actualizo los registros anteriores en el mov_detalle y luego doy de alta nuevos registros en mov_detalle y mov_lotes
  //echo  $a;

    while ($v = mysql_fetch_array($r)) {
      $tm=$v[0];$nro_mov_a=$v[1];$lote=$v[2];

      $ac='select sala_ext,fecha_vto,lote_ext,prov_id,env_sec,lote_env_sec FROM '.$_SESSION["tabla_mov_cabecera"].' where nro_mov="'.$nro_mov_a.'"';
      $rc=mysql_query($ac,$cx_validar);
      while ($vc = mysql_fetch_array($rc)) {$a_sala_ext=$vc[0];$a_fecha_vto=$vc[1];$a_lote_ext=$vc[2];$prov_id=$vc[3];$env_sec=$vc[4];$lote_env_sec=$vc[5];break;}
  //echo $ac;

      $a2='UPDATE '.$_SESSION["tabla_mov_detalle"].' set nro_mov_baja="'.$n_nro_mov.'" where lote_id='.$lote.' and nro_mov_baja="             "';
      mysql_query($a2,$cx_validar);
  //echo $a2;

      $a2='UPDATE '.$_SESSION["tabla_mov_cabecera"].' set lote_env_sec="'.$lote_env_sec.'",sala_ext="'.$a_sala_ext.'",fecha_vto="'.$a_fecha_vto.'",lote_ext='.$a_lote_ext.',prov_id='.$prov_id;
      $a2=$a2.',tipo_fact="'.$tipo_fact.'",fecha_rto="'.$fecha_rto.'",fecha_fact="'.$fecha_fact.'",nro_remito="'.$nro_remito.'",nro_factura="'.$nro_factura.'",env_sec='.$env_sec.'  where nro_mov="'.$nro_mov.'"';
      mysql_query($a2,$cx_validar);

  // echo $a2;
      $a2='select prod_id,prov_id,campo_id,cosecha,env_sec,lote_env_sec,tapa,precinto,bruto,tara,lote_ext';
      $a2=$a2.',sala_ext,tipo_campo,almac_id_ori,almac_id_des,color,cumple,lugar FROM '.$_SESSION["tabla_mov_detalle"].' where  lote_id='.$lote.' and tipo_mov="EXT"';
      $r2=mysql_query($a2,$cx_validar);
      while ($v2 = mysql_fetch_array($r2)) {$prod_id=$v2[0];$prov_id=$v2[1];$campo_id=$v2[2];$cosecha=$v2[3];$env_sec=$v2[4];$lote_env_sec=$v2[5];
        $tapa=$v2[6];$precinto=$v2[7];$bruto=$v2[8];$tara=$v2[9];$lote_ext=$v2[10];
        $sala_ext=$v2[11];$tipo_campo=$v2[12];$almac_id_ori=$v2[13];$almac_id_des=$v2[14];$color=$v2[15];$cumple=$v2[16];$lugar=$v2[17];
        break;}
  //echo $a2;

      $lugar=0+$lugar;
      $a2='INSERT INTO '.$_SESSION["tabla_mov_detalle"].' (`tipo_mov`,`nro_mov`,`prod_id`,`prov_id`,`campo_id`,`cosecha`,`lote_id`,`env_sec`,`lote_env_sec`,`tapa`,`precinto`,`bruto`,`tara`,`lote_ext` ';
      $a2=$a2.',`sala_ext`,`tipo_campo`,`almac_id_ori`,`almac_id_des`,`color`,`cumple`,`lugar`';
      $a2=$a2.") VALUES ('".$tipo_mov."','".$nro_mov."',".$prod_id.','.$prov_id.','.$campo_id.','.$cosecha.','.$lote.','.$env_sec.',"'.$lote_env_sec.'",'.$tapa.','.$precinto.','.$bruto.','.$tara.','.$lote_ext;
      $a2=$a2.',"'.$sala_ext.'","'.$tipo_campo.'",'.$almac_id_ori.','.$almac_id_des.','.$color.',"'.$cumple.'",'.$lugar ;
      $a2=$a2.')'; 

      mysql_query($a2,$cx_validar);
  //echo $a2;

      $a2='select prod_id,cosecha,tipo_mov_des,nro_mov_des,almac_id_des  FROM '.$_SESSION["tabla_mov_lotes"].' where  lote_id='.$lote.' and nro_mov_des="'.$nro_mov_a.'"';;
      $r2=mysql_query($a2,$cx_validar);
      while ($v2 = mysql_fetch_array($r2)) 
      {$prod_id=$v2[0];$cosecha=$v2[1];$tipo_mov_ori=$v2[2];$nro_mov_ori=$v2[3];$almac_id_ori=$v2[4];break;}
  //echo $a2;

      $a2='INSERT INTO '.$_SESSION["tabla_mov_lotes"].' (`prod_id`,`cosecha`,`tipo_mov_ori`,`nro_mov_ori`,`almac_id_ori`,`tipo_mov_des`,`nro_mov_des`,`almac_id_des`,`lote_id`,`lote_ext` ';
      $a2=$a2.") VALUES ($prod_id,".$cosecha.",'".$tipo_mov_ori."','".$nro_mov_ori."',".$almac_id_ori.",'".$tipo_mov."','".$nro_mov."',".$almacen_id.",".$lote.",".$lote_ext.')'; 
      mysql_query($a2,$cx_validar);
  //echo $a2;

  }
  
?>