<?php
session_start();
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
  $actualizar="update ".$_SESSION["tabla_acc"]." set fec_ult_ut='$last_ing' ,prog_utl='stock1.php'  where id_usuario=".$_SESSION["id_usuario"] ;
  mysql_query($actualizar,$cx_validar);
  $actualizar='DELETE FROM '.$_SESSION["tabla_respuesta"].' where login="'.$_SESSION["acceso_logg"].'" and respuesta="stk"';
  mysql_query($actualizar,$cx_validar);
}

/*****************************************************************************************************************************
******************************************************************************************************************/
?>

<!DOCTYPE html>
<head>
  <title>Stock de Productos</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">             
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="shortcut icon" href="fotos/envasado.jpg">
  <link href='../frames/grid/css/jquery-ui-custom.css' rel='stylesheet' type='text/css'/>     
  <link href='../frames/grid/css/ui.jqgrid.css' rel='stylesheet' type="text/css"/>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
  <link rel="stylesheet" href="css/stock.css" />
</head>
<body>
  <div id="footer">   
    <img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
  </div>
  <h2>Datos en Stock</h2>
  
  <div  id='botonera_Analisis'>
    <input type="button" class="boton" id="asignar_embarque" data-toggle="modal" data-target="#ModalAsignacion" value="Asignar Preembarque"/>
    <input type="button" class="boton" id="transf_depot" data-toggle="modal" data-target="#ModalTransferencia" value="Transferir Depósito"/>
    <button type="button" class="boton" id="exportar_excel">Exportar a xls</button>   
  </div>

  <div id ='grilla'>
    <table id="grillaStock"></table>
    <div id="pgrillaStock"></div>
  </div>
  <div id="footer">   
    <img src="fotos/salir.png" width="20" height="20"/><a href="menu_1.php" title="volver">Volver al men&uacute principal</a>
  </div>

  <!-- Modal 1-->
  <div class="modal fade" id="ModalAsignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Detalles de Preembarque</h4>
        </div>
        <div class="modal-body">             
      
        <div id="datosenvio">
          <h4>Numero de Lote para tambores seleccionados</h4>
          <p>Lote:  GSB<input type='number' name='lote' id='lote' placeholder='Número de Lote' size='10'/></p>                
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Salir</button>
          <button type="button" id="enviarStockNuevo" class="btn btn-primary btn-lg">Agrupar</button>
        </div>
      </div>
    </div>
  </div>     

  <!-- Modal 2-->
  <div class="modal fade" id="ModalTransferencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Transferir a Depósito</h4>
        </div>
        <div class="modal-body">             
      
        <div id="datosenvio">
          <h4>Seleccione lugar de transferencia para tambores seleccionados</h4>
          <label for="slt-deposito">Depósito:</label>  
          <select name="slt_deposito" id="slt_deposito" style="width:12em">
            <?  
              $cx_validar = mysql_pconnect("localhost","root","root");
              mysql_select_db("chmiel");
              $actualizar1="SELECT razon_social FROM almacenes WHERE tipo_almacen=4" ;
              $rs_validar1 = mysql_query($actualizar1,$cx_validar); 
              while ($v_validar1 = mysql_fetch_array($rs_validar1)){
                echo '<option value='.$v_validar1[0];
                echo '>'.$v_validar1[0].'</option>';
              }
            ?>
          </select>             
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Salir</button>
          <button type="button" id="transferirDeposito" class="btn btn-primary btn-lg">Transferir</button>         
        </div>
      </div>
    </div>
  </div>    

</body>
  <script src='../frames/grid/js/jquery-1.11.1.js'></script>
  <script src='../frames/grid/js/jquery.jqGrid.min.js'></script>
  <script src='../frames/grid/js/grid.locale-es.js'></script>
  <script src="js/motorStock.js"> </script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.validate.js"></script>
</html>