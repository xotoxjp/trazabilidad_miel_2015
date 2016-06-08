<?php
include_once("funciones.php");;?>
 <TITLE>MENU</TITLE>
</head>
<body>
<form name="formulario" method="POST" action="mod_usuario.php">
<?
$cx_validar = mysql_pconnect($_SESSION["host_acc"],$_SESSION["user_acc"],$_SESSION["pass_acc"]);
mysql_select_db($_SESSION["base_acc"]);
$actualizar="select * from  ".$_SESSION["tabla_acc"] ;
//echo $actualizar;
$rs_validar = mysql_query($actualizar,$cx_validar);
echo "<table border='1' width='100%'>" ;
echo "<a href='menu_1.php'><img src='fotos/ARW03LT.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";
echo '<tr><td>Ver</td><td>C&oacute;digo</td><td>Nombre</td><td>Apellido</td><td>email</td><td>login</td><td>clave</td>';
echo '<td>nivel</td><td>Empresa</td><td>sector</td><td>t&eacute;lefono</td><td>celular</td><td>interno</td>';

if (isset($_SESSION["id_usu"])){
$i=$_SESSION["id_usu"];
}
else {
$i=0;
}
while ($v_validar = mysql_fetch_array($rs_validar))
   {
   if ( $i == 0) { $i=-1; echo "<tr bgcolor='#99FF33'><td><a  href='mod_usuario.php?id_usuario=".$v_validar[0]."'><img src='fotos/ok.gif' width='20' height='20' border='0'></a></td>";}
   else
    { if ($i == $v_validar[0])
      { echo "<tr bgcolor='#99FF33'><td><a  href='mod_usuario.php?id_usuario=".$v_validar[0]."'><img src='fotos/ok.gif' width='20' height='20' border='0'></a></td>";}
      else
       { echo "<tr bgcolor='#FFFFFF'><td><a  href='mod_usuario.php?id_usuario=".$v_validar[0]."'><img src='fotos/ok.gif' width='20' height='20' border='0'></a></td>";}
    }
   echo " <td> $v_validar[0] </td> <td> $v_validar[1] </td> <td> $v_validar[2] </td> <td> $v_validar[3] </td><td> $v_validar[4] </td><td> $v_validar[5] </td>" ;
   echo " <td> $v_validar[6] </td> <td> $v_validar[8] </td> <td> $v_validar[13] </td> <td> $v_validar[14] </td> <td> $v_validar[15] </td><td> $v_validar[16] </td>" ;
   echo '</tr>';
   }
   echo "</table>";
   echo "<a href='menu_1.php'><img src='fotos/ARW03LT.ico' alt='Volver' aling'left' width='20' height='20' border='0'></a>";

//$valor=$v_validar["nivel"];
//$srchstrng = $_SESSION["level_req"];
//if (stristr($valor, $srchstrng)== FALSE)
?>
</BODY>
</HTML>
