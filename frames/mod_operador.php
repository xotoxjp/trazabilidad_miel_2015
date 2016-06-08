include_once("funciones.php");
$des="---";$sub="---";$id_operador="---";

foreach ($_GET as $indice => $valor)
 {  switch ($indice) {
	case 'id_operador': $id_operador=$valor; $_SESSION["id_ope"] = $valor   ; break;
 }}

foreach ($_POST as $indice => $valor)
 {  switch ($indice) {
	case 'id_operador': $id_operador=$valor; $_SESSION["id_ope"] = $valor   ; break;
	case 'Des':         $des=$valor   ; break;
	case 'Abrev':       $abrev=$valor ; break;
	case 'preco':       $preco=$valor ; break;
	case 'precv':       $precv=$valor ; break;
    case 'precn':       $precn=$valor ; break;
	case 'pvtao':       $pvtao=$valor ; break;
	case 'pvtav':       $pvtav=$valor ; break;
    case 'pvtan':       $pvtan=$valor ; break;
    case 'Submit':      $sub=$valor   ; break;
 }}
if ( $sub == "Volver") {      header("Location: operadores.php") ; }
if ( $id_operador == "---" ) {$id_operador = $_SESSION["id_ope"];}
if ($des <> "---") {
  $cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
  mysql_select_db($_SESSION["base_acc"]);
  $actualizar=" ";
  switch ($sub) {
  case 'Alta':
  { $actualizar="insert into ".$_SESSION['tabla_operadores']."(descripcion , abreviatura , p_rec_otro , p_rec_viejo , p_rec_nuevo , p_vta_otro , p_vta_viejo , p_vta_nuevo )";
    $actualizar=$actualizar." values ("."'". "$des"."'," ."'". "$Abrev"."'," ."'". "$preco"."'," ."'"."$precv"."',"."'". "$precn"."',"."'". "$pvtan"."',"."'". "$pvtan"."',"."'". "$pvtan"       ."')" ;
    header("Location: operadores.php") ;    break;}
  case 'Salvar':
  { $actualizar="update ".$_SESSION['tabla_operadores']." set descripcion="."'"."$des"."'" ;
    $actualizar=$actualizar." ,abreviatura =" ."'"."$abrev"."'";
    $actualizar=$actualizar." ,p_rec_otro  =" ."'"."$preco"."'";
    $actualizar=$actualizar." ,p_rec_viejo =" ."'"."$precv"."'";
    $actualizar=$actualizar." ,p_rec_nuevo =" ."'"."$precn"."'";
    $actualizar=$actualizar." ,p_vta_otro  =" ."'"."$pvtao"."'";
    $actualizar=$actualizar." ,p_vta_viejo =" ."'"."$pvtav"."'";
    $actualizar=$actualizar." ,p_vta_nuevo =" ."'"."$pvtan". "' where id_operador=$id_operador ";
    break;}
  case 'Borrar':
  { $actualizar="delete from  ".$_SESSION["tabla_operadores"]." where id_operador=".$id_operador ;
    header("Location: operadores.php") ;  break;}}
  mysql_query($actualizar,$cx_validar);
}
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="select descripcion ,abreviatura,p_rec_otro,p_rec_viejo,p_rec_nuevo,p_vta_otro,p_vta_viejo,p_vta_nuevo from  ".$_SESSION["tabla_operadores"]." where id_operador=".$id_operador ;
$rs_validar = mysql_query($actualizar,$cx_validar);
echo "<HTML>";
echo "<HEAD>";
echo "<TITLE>Acceso a Operadores del Taller y Ventas</TITLE>";
echo "</HEAD>";
echo "<BODY>";
while ($v_validar = mysql_fetch_array($rs_validar))
  { $des= $v_validar[0];
    $abrev= $v_validar[1];
    $preco= $v_validar[2];
    $precv=$v_validar[3];
    $precn= $v_validar[4];
    $pvtao= $v_validar[5];
    $pvtav=$v_validar[6];
    $pvtan= $v_validar[7];  }
    echo "<form name='formulario' method='POST' action='mod_operador.php'>";
    echo '<table border="1" ><tr><td>';
    echo '<table border="1" >';
    echo "<caption color style='background:#99FF33'> Datos del Operador ".$id_operador."</caption>"     ;
    echo '<tr>';
    echo  '<td>Nombre</td>';
    echo "<td><input name='Des' type='text'  value="."'".$des."'"."  size='40' maxlength='40' > </td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>Abrev.</td>';
    echo "<td><input name='Abrev' type='text' id=abrev  value="."'".$abrev."'"." size='10' maxlength='10' > </td><td></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>% en Recarga Equipos a Clientes de Otro</td>';
    echo "<td><input name='preco' type='text' id=preco  value="."'".$preco."'"." size='6' maxlength='6'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>% en Recarga Equipos a Clientes Viejos</td>';
    echo "<td><input name='precv' type='text' id=precv  value="."'".$precv."'"." size='6' maxlength='6'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>% en Recarga Equipos a Clientes Nuevos</td>';
    echo "<td><input name='precn' type='text' id=precn  value="."'".$precn."'"." size='6' maxlength='6'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>% en Venta Equipos a Clientes de Otro</td>';
    echo "<td><input name='pvtao' type='text' id=pvtao  value="."'".$pvtao."'"." size='6' maxlength='6'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>% en Venta Equipos a Clientes Viejos</td>';
    echo "<td><input name='pvtav' type='text' id=pvtav  value="."'".$pvtav."'"." size='6' maxlength='6'></td>";
    echo '</tr>';
    echo '<tr>';
    echo  '<td>% en Venta Equipos a Clientes Nuevos</td>';
    echo "<td><input name='pvtan' type='text' id=pvtan  value="."'".$pvtan."'"." size='6' maxlength='6'></td>";
    echo '</tr>';
    echo "</tr></table>";
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
