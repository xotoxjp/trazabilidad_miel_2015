<?php
$F= date(‘Y-m-d’, strtotime(‘-3 day’)) ; // resta 3 días
$Fechacuidado=substr($f,-2).substr($f,4,4).substr($f,0,4).' 00:00:00';

echo 'fecha de cuidado'.$Fechacuidado.'<br>';

$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
echo 'fecha    actual'.$fecha_actual.'<br>';


$fecha_entrada = strtotime("19-11-2008 21:00:00");


if($fecha_actual > $fecha_entrada){
echo "La fecha entrada ya ha pasado";
}else{
echo "Aun falta algun tiempo";
}
?>
