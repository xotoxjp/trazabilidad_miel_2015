include_once("funciones.php");
$nom="---";$sub="---";$id_usuario="---";

foreach ($_GET as $indice => $valor)
 {  switch ($indice) {
	case 'id_usuario': $id_usuario=$valor; $_SESSION["id_usu"] = $valor   ; break;
 }}

foreach ($_POST as $indice => $valor)
 {  switch ($indice) {
	case 'id_usuario': $id_usuario=$valor; $_SESSION["id_usu"] = $valor   ; break;
	case 'nom':        $nom=$valor;break;
	case 'ape':        $ape=$valor;break;
	case 'ema':        $ema=$valor ; break;
    case 'lo':         $lo=$valor ; break;
    case 'pa':         $pa=$valor ; break;
	case 'niv':        $niv=$valor;break;
	case 'idc':        $idc=$valor;break;
	case 'cli':        $cli=$valor ; break;
    case 'dir':        $dir=$valor ; break;
    case 'fec':        $fec=$valor ; break;
	case 'pgu':        $pgu=$valor;break;
	case 'out':        $out=$valor;break;
	case 'sec':        $sec=$valor ; break;
    case 'tel':        $tel=$valor ; break;
    case 'cel':        $cel=$valor ; break;
    case 'int':        $int=$valor ; break;
    case 'Submit':     $sub=$valor ; break;
 }}

if ( $sub == "Volver") {      header("Location: usuarios.php") ; }
if ( $id_usuario == "---" ) {$id_usuario = $_SESSION["id_usu"];}
if ($nom <> "---") {
  $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
  mysql_select_db($_SESSION["base_acc"]);
  $actualizar=" ";
  switch ($sub) {
  case 'Alta':
  {
    $actualizar1="select cliente , web  from  ".$_SESSION["tabla_empresa"].' where id_cliente='.$idc ;
    
    $rs_validar1 = mysql_query($actualizar1,$cx_validar);
    while ($v_validar1 = mysql_fetch_array($rs_validar1))
      { $cli=$v_validar1[0]; $dir=$v_validar1[1];}

    $actualizar="insert into ".$_SESSION['tabla_acc']."(nombre , apellido , email , login , password , nivel,id_cliente,cliente,dir_cliente,fec_ult_ut,prog_util,salio_ok,sector,tel,cel,interno )";
    $actualizar=$actualizar." values ("."'". "$nom"."'," ."'". "$ape"."'," ."'". "$ema"."'," ."'"."$lo"."',"."'". "$pa"."'," ."'". "$niv"."'," ."'". "$idc"."'," ."'". "$cli"."'," ."'". "$dir"."'," ."'". "$fec"."'," ."'". "$pgu"."'," ."'". "$out"."'," ."'". "$sec"."'," ."'". "$tel"."'," ."'". "$cel"."'," ."'". "$int"."')" ;
    header("Location: usuarios.php") ;    break;}
  case 'Salvar':
  {
    $actualizar1="select cliente , web  from  ".$_SESSION["tabla_empresa"].' where id_cliente='.$idc ;
    
    $rs_validar1 = mysql_query($actualizar1,$cx_validar);
    while ($v_validar1 = mysql_fetch_array($rs_validar1))
      { $cli=$v_validar1[0]; $dir=$v_validar1[1];}
    $actualizar="update ".$_SESSION['tabla_acc']." set nombre="."'"."$nom"."'" ;
    $actualizar=$actualizar." ,apellido   =" ."'"."$ape"."'";
    $actualizar=$actualizar." ,email      =" ."'"."$ema"."'";
    $actualizar=$actualizar." ,login      =" ."'"."$lo"."'";
    $actualizar=$actualizar." ,password   =" ."'"."$pa"."'";
    $actualizar=$actualizar." ,nivel      =" ."'"."$niv"."'";
    $actualizar=$actualizar." ,id_cliente =" ."'"."$idc"."'";
    $actualizar=$actualizar." ,cliente    =" ."'"."$cli"."'";
    $actualizar=$actualizar." ,dir_cliente=" ."'"."$dir"."'";
    $actualizar=$actualizar." ,fec_ult_ut =" ."'"."$fec"."'";
    $actualizar=$actualizar." ,prog_utl   =" ."'"."$pgu"."'";
    $actualizar=$actualizar." ,salio_ok   =" ."'"."$out"."'";
    $actualizar=$actualizar." ,sector     =" ."'"."$sec"."'";
    $actualizar=$actualizar." ,tel        =" ."'"."$tel"."'";
    $actualizar=$actualizar." ,cel        =" ."'"."$cel"."'";
    $actualizar=$actualizar." ,interno    =" ."'"."$int"."' where id_usuario=$id_usuario ";
    break;}
  case 'Borrar':
  { $actualizar="delete from  ".$_SESSION["tabla_acc"]." where id_usuario=".$id_usuario ;
    header("Location: usuarios.php") ;  break;}}
  mysql_query($actualizar,$cx_validar);
}

$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="select nombre , apellido , email , login , password , nivel , id_cliente , cliente , dir_cliente , fec_ult_ut , prog_utl , salio_ok , sector , tel , cel , interno from  ".$_SESSION["tabla_acc"]." where id_usuario=".$id_usuario ;
$rs_validar = mysql_query($actualizar,$cx_validar);



echo "<HTML>";
echo "<HEAD>";
echo "<TITLE>Acceso a la Tabla de Usuarios del Sistema</TITLE>";
echo "</HEAD>";
echo "<BODY>";



while ($v_validar = mysql_fetch_array($rs_validar))
  {
    $nom= $v_validar[0];
    $ape= $v_validar[1];
    $ema= $v_validar[2];
    $lo = $v_validar[3];
    $pa = $v_validar[4];
    $niv= $v_validar[5];
    $idc= $v_validar[6];
    $cli= $v_validar[7];
    $dir= $v_validar[8];
    $fec= $v_validar[9];
    $pgu= $v_validar[10];
    $out= $v_validar[11];
    $sec= $v_validar[12];
    $tel= $v_validar[13];
    $cel= $v_validar[14];
    $int= $v_validar[15];
      }
    $actualizar1="select cliente , web  from  ".$_SESSION["tabla_empresa"].' where id_cliente='.$idc ;
    
    $rs_validar1 = mysql_query($actualizar1,$cx_validar);
    while ($v_validar1 = mysql_fetch_array($rs_validar1))
      { $cli=$v_validar1[0]; $dir=$v_validar1[1];}





    $actualizar1="select id_cliente from  ".$_SESSION["tabla_empresa"]." where id_cliente<>"."'".$idc."'" ;
    $rs_validar1 = mysql_query($actualizar1,$cx_validar);
    echo "<form name='formulario' method='POST' action='mod_usuario.php'>";
    echo '<table border="1" ><tr><td>';
    echo '<table border="1" >';
    echo "<caption color style='background:#99FF33'> Datos del Usario ".$id_usuario."</caption>"     ;
    echo '<tr>';
    echo  '<td>Nombre</td>';
    echo "<td><input name='nom' type='text'  id=nom  value="."'".$nom."'"."  size='30' maxlength='255' > </td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Apellido</td>';
    echo "<td><input name='ape' type='text' id=ape  value="."'".$ape."'"." size='20' maxlength='20' > </td><td></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>email</td>';
    echo "<td><input name='ema' type='text' id=ema  value="."'".$ema."'"." size='40' maxlength='40'  >"."</td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Login</td>';
    echo "<td><input name='lo' type='text' id=lo  value="."'".$lo."'"." size='8' maxlength='8'> "."</td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Password</td>';
    echo "<td><input name='pa' type='text' id=pa  value="."'".$pa."'"." size='8' maxlength='8'> "."</td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Nivel</td>';
    echo "<td><input name='niv' type='text' id=niv  value="."'".$niv."'"." size='27' maxlength='27'> "."</td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Id_Empresa</td>';
//    echo "<td><input name='idc' type='text' id=idc  value="."'".$idc."'"." size='11' maxlength='11'> "."</td>";

//   primero pongo el que tiene el elemento y luegos los distintos a el en la tabla de unidades
    echo  '<td><select name="idc" id="idc">';
    echo       "<option value="."'".$idc."'>".$idc."</option>";
     while ($v_validar1 = mysql_fetch_array($rs_validar1))
     { echo  "<option value="."'".$v_validar1[0]."'>".$v_validar1[0]."</option>"; }
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Empresa</td>';
//    echo "<td><input name='cli' type='text' id=cli  value="."'".$cli."'"." size='30' maxlength='30'> "."</td>";
    echo "<td>$cli</td>";
    echo '</tr>';
//    echo '<tr>';
//    echo  '<td>Direccion</td>';
//    echo "<td><input name='dir' type='text' id=dir  value="."'".$dir."'"." size='30' maxlength='30'> "."</td>";
//    echo '</tr>';
//    echo '<tr>';
//    echo  '<td>Ultimo Ingreso</td>';
//    echo "<td><input name='fec' type='text' id=fec  value="."'".$fec."'"." size='16' maxlength='16'> "."</td>";
//    echo '</tr>';
//    echo '<tr>';
//    echo  '<td>Ultimo Programa</td>';
//    echo "<td><input name='pgu' type='text' id=pgu  value="."'".$pgu."'"." size='30' maxlength='30'> "."</td>";
//    echo '</tr>';
//    echo '<tr>';
//    echo  '<td>Salio ok</td>';
//    echo "<td><input name='out' type='text' id=out  value="."'".$out."'"." size='2' maxlength='2'> "."</td>";
//    echo '</tr>';
    echo '<tr>';
    echo  '<td>Sector</td>';
    echo "<td><input name='sec' type='text' id=sec  value="."'".$sec."'"." size='20' maxlength='20'> "."</td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Telefono</td>';
    echo "<td><input name='tel' type='text' id=tel  value="."'".$tel."'"." size='15' maxlength='15'> "."</td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Celular</td>';
    echo "<td><input name='cel' type='text' id=cel  value="."'".$cel."'"." size='15' maxlength='15'> "."</td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Interno</td>';
    echo "<td><input name='int' type='text' id=int  value="."'".$int."'"." size='10' maxlength='10'> "."</td>";
    echo '</tr>';
    echo "</table>";
    echo "<tr><td><table border='0'  width='100%'><tr>";
    echo "<caption color style='background:#99FF33'> Acciones Definidas para el Usuario </caption>"     ;
    echo "<td>&nbsp;</td>";
    echo "<td><input type='submit' name='Submit' value='Volver' ALIGN='center' > </td>";
    echo "<td><input type='submit' name='Submit' value='Salvar' ALIGN='center' ></td>";
    echo "<td><input type='submit' name='Submit' value='Alta'></td>";
    echo "<td><input type='submit' name='Submit' value='Borrar'></td></tr><tr>";
    echo "<td>&nbsp;</td>";
    echo "<td><img src='fotos/exit.jpg' alt='Volver sin Salvar'  width='40' height='40' ALIGN='center ' ></td>";
    echo "<td><img src='fotos/grabar.jpg' alt='Salvar'  width='40' height='40' ALIGN='center' ></td>";
    echo "<td><img src='fotos/conver2.ico' alt='Alta'  width='40' height='40' ALIGN='center' ></td>";
    echo "<td><img src='fotos/face04.ico' alt='Borrar'  width='40' height='40' ALIGN='middle'></td>";
    echo "</tr></table></td></tr></table>";
?>
</BODY>
</HTML>
