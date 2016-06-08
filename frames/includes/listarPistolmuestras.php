<?php 
	require_once("conexion.php");
	//$tipoMuestra2 = "EXT"; //TESTCASE
	$tipoMuestra2 = $_GET['tipoMuestra']; // tipo de muestra elegido ej EXT 
	$where = "WHERE stat ='$tipoMuestra2'"; //if there is no search request sent by jqgrid, $where should be empty
	$cn= Conectarse();
	$query="SELECT laboratorio.id_tambor, provedores.razon_social, provedores.Localidad, laboratorio.hmf, laboratorio.color, laboratorio.humedad, laboratorio.acidez, laboratorio.resultado, laboratorio.observaciones FROM laboratorio 
	      INNER JOIN provedores
	      ON laboratorio.id_productor=provedores.prov_id ".$where." GROUP BY id_tambor ORDER BY id_tambor ";
	$listado= mysql_query($query,$cn);
?>

<script type="text/javascript" language="javascript" src="js/jslistadoPistolmuestras.js"></script>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_muestras">
	<thead>
		<tr>
			<th>muestra</th><!–-Estado-–>
			<th>productor</th>
			<th>localidad</th>			
			<th>hmf</th>			
			<th>color</th>			
			<th>humedad</th>			
			<th>acidez</th>			
			<th>resultado</th>			
			<th>observaciones</th>			
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		while($reg= mysql_fetch_array($listado)){
			echo '<tr>';
			echo '<td>'.mb_convert_encoding($reg['id_tambor'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['razon_social'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['Localidad'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['hmf'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['color'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['humedad'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['acidez'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['resultado'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['observaciones'], "UTF-8").'</td>';
			echo '</tr>';
		}
		?>
	<tbody>
</table>

