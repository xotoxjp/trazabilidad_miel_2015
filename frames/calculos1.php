<?
$fecha = date_create('2000-01-01');
date_add($fecha, date_interval_create_from_date_string('10 days'));
echo date_format($fecha, 'Y-m-d');




?>