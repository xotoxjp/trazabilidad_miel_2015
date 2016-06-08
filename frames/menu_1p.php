<?
session_start();
include_once("funciones.php");
$ID=" ";
$ID=$_POST["ID"];
$_SESSION["mensaje"]='';
switch ($ID) {
    case 'PRIMARIOS' :header("Location: env_prim.php");echo '1';break;
    case 'SECUNDARIOS' :header("Location: env_sec.php");echo '1';break;
    case 'TERCIARIOS' :header("Location: env_terc.php");echo '1';break;
    case 'ANALISIS' :header("Location: analitico_inf.php");echo '1';break;
    case 'PRESUPUESTO' :header("Location: presupuesto1.php");echo '1';break;
    case 'COBRANZAS' :header("Location: cobra.php");echo '1';break;
    case 'MOV_ENTRE_CAMPOS' :header("Location: colmenas2.php");echo '1';break;
    case 'MOV_COL_EXT' :header("Location: colmenas3.php");echo '1';break;
    case 'DESPACHANTE' :header("Location: despachante.php");echo '1';break;
    case 'ADUANA' :header("Location: aduana.php");echo '1';break;
    case 'PASOS' :header("Location: paso.php");echo '1';break;

    case 'TIPO' :header("Location: tipos1.php");echo '1';break;
    case 'DPS' :header("Location: librodps.php");echo '1';break;
    case 'CP' :header("Location: control1.php");echo '1';break;
    case 'GASTOS' :header("Location: wap_gastos1.php");echo '1';break;

    case 'MARCAPOLVO' :header("Location: marcasp.php");echo '1';break;
    case 'CERTGCBA' :header("Location: librocf.php");echo '1';break;
    case 'OR' :header("Location: retiro1.php");echo '1';break;
    case 'COMPRAS' :header("Location: wap_gastos.php");echo '1';break;

    case 'MARCAEXTINT' :header("Location: marcas1.php");echo '1';break;
    case 'IVAVENTA' :header("Location: wap_i_ventas.php");echo '1';break;
    case 'OT' :header("Location: trabajo1.php");echo '1';break;
    case 'EMBARQUE' :header("Location: embarque1.php");echo '1';break;
    case 'STOCK' :header("Location: stock1.php");echo '1';break;
    case 'STOCKLC' :header("Location: stocklc1.php");echo '1';break;

    case 'PRODUCTOS' :header("Location: productos1.php");echo '1';break;
    case 'IVACOMPRA' :header("Location: wap_i_compras.php");echo '1';break;
    case 'RTO' :header("Location: remito1.php");echo '1';break;
    case 'MOVIMIENTOS' :header("Location: movimiento.php");echo '1';break;

    case 'CLIENTES' :header("Location: clientes1.php");echo '1';break;
    case 'REGDPS' :header("Location: reg_ins_dps.php");echo '1';break;
    case 'FAC' :header("Location: factura1.php");echo '1';break;
    case 'CAJA' :header("Location: wap_Presupuestos.php");echo '1';break;

    case 'PROVEDORES' :header("Location: provedores1.php");echo '1';break;
    case 'REGGCBA' :header("Location: reg_ins_gcba.php");echo '1';break;
    case 'INST' :header("Location: inst.php");echo '1';break;

    case 'PERVENTAS' :header("Location: operadores1.php");echo '1';break;
    case 'NOTAS' :header("Location: notas.php");echo '1';break;
    case 'SEGUIMIENTOS' :header("Location: pr.php");echo '1';break;

    case 'PERTALLER' :header("Location: operadoresT.php");echo '1';break;
    case 'PREFERENCIAS' :header("Location: usuarios2.php");echo '1';break;
    case 'PROGOR' :header("Location: prog_or.php");echo '1';break;

    case 'USUARIOS' :header("Location: usuarios1.php");echo '1';break;

    case 'TXTPRESUPU' :header("Location: tab_tex_pre.php");echo '1';break;

    case 'TRANSPORTE' :header("Location: transporte.php");echo '1';break;
    case 'TIPOALMA' :header("Location: tipoalma.php");echo '1';break;
    case 'ALMACENES' :header("Location: almacenes1.php");echo '1';break;
    case 'EXTRACCION' :header("Location: alta_extr1.php");echo '1';break;
    case 'MOV_ANALISIS' :header("Location: analisis1.php");echo '1';break;
    case 'MOV_EXTR_ACOPIO' :header("Location: extaco1.php");echo '1';break;
    case 'MOV_EXTR_ENVASADO' :header("Location: extenv1.php");echo '1';break;
    case 'MOV_ACOPIO_EMBASADO' :header("Location: acoenv1.php");echo '1';break;
    case 'MUESTRAS_CAMPO' :header("Location: muencampo1.php");echo '1';break;
    case 'REPROCESO' :header("Location: reproceso1.php");echo '1';break;
}
