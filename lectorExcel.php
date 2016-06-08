<?
header('Content-Type: text/html; charset=UTF-8');
require_once 'frames/Classes/PHPExcel/IOFactory.php';
PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
$objPHPExcel = PHPExcel_IOFactory::load("StockRem4.xls");
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;
    echo "<br>The worksheet ".$worksheetTitle." has ";
    echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
    echo ' and ' . $highestRow . ' row.';
    echo '<br>Data: <table border="1"><tr>';
    for ($row = 1; $row <= $highestRow; ++ $row) {
        echo '<tr>';
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
            echo '<td>' . $val . '<br> </td>';
        }
        echo '</tr>';
    }
    echo '</table>';

    //servir los datos en la BD
    for ($row = 2; $row <= $highestRow; ++ $row) {  
            $cell = $worksheet->getCellByColumnAndRow(0, $row);
        $Tambor = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(1, $row);
        $Renapa = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(2, $row);
        $Sala = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(3, $row);
        $Lote = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(4, $row);
        $Peso_Bruto = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(5, $row);
        $Tara = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(6, $row);
        $Peso_Neto = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(7, $row);
        $Hmf = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(8, $row);
        $Color = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(9, $row);
        $Humedad = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(10, $row);
        $Acidez = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(11, $row);
        $Factura = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(12, $row);
        $Productor = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(13, $row);
        $fecha = $cell->getValue();
        $timestamp = PHPExcel_Shared_Date::ExcelToPHP($fecha);
        $Fecha_Ingreso = date("Y-m-d",$timestamp);  
            $cell = $worksheet->getCellByColumnAndRow(14, $row);
        $Remito_Ingreso = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(15, $row);
        $Deposito = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(16, $row);
        $Tipo = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(17, $row);
        $GSB = $cell->getValue();
            $cell = $worksheet->getCellByColumnAndRow(18, $row);
        $Rango = $cell->getValue();
        //echo "rango es: $Rango";
        //cargar querys
        $db = mysql_connect(localhost, root, root)or die("Error de Conexion: " . mysql_error());
        mysql_select_db(chmiel) or die("Error al conectarse a la DB.");
        $SQL = 'SET character_set_results=utf8';
        $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
        
        $SQL = "INSERT INTO xstockx VALUES ($Tambor,'$Renapa','$Sala',$Lote,$Peso_Bruto,$Tara,$Peso_Neto,'$Hmf',$Color,$Humedad,$Acidez,'$Factura','$Productor','$Fecha_Ingreso','$Remito_Ingreso','$Deposito','$Tipo','$GSB','$Rango')" ;
        //echo "$SQL";
        $result = mysql_query( $SQL ) or die("fallo en xstockx.".mysql_error());


/**************************************************************************************************************************/
/**************************************************************************************************************************/
/**************************************************************************************************************************/
        $prov_id=''; $sala_ext='';

        //busco datos de productor 
        $verProv="SELECT prov_id FROM provedores WHERE razon_social='$Productor' ";
        //echo $verProv;
        //echo '<br>';
        
        $Pprov_id= mysql_query( $verProv ) or die("No puedo ejecutar query de busqueda de productor.".mysql_error());
        $prov_id= mysql_fetch_row($Pprov_id);
        if(!$prov_id){echo "$Productor no fue dada de alta en BD"; $prov_id[0]=0; echo '<br>';}
        //echo "productor".$prov_id[0];
        
        

        //busco datos de sala de extraccion
        $verSala="SELECT almacen_id FROM almacenes  WHERE razon_social='$Sala' ";
        //echo $verSala;
        //echo '<br>';

        $Psala_ext= mysql_query( $verSala ) or die("No puedo ejecutar query de busqueda de id almacen.".mysql_error());        
        $sala_ext= mysql_fetch_row($Psala_ext);
        if(!$sala_ext){echo "$Sala no fue dada de alta en BD"; $sala_ext[0]=0; echo '<br>';}
        //echo $sala_ext;
        
        

        //inserto datos nuevos en la tabla presupuesto        
        $query11="INSERT INTO presupuestos (num_presupuesto,id_productor,id_sala_ext,id_tambor) 
            VALUES (0, $prov_id[0], $sala_ext[0], $Tambor)";
        //echo $query11;
        //echo '<br>';
        //echo '<br>';
        $result = mysql_query( $query11 ) or die("No puedo insertar presupuestos.".mysql_error());


        //inserto datos nuevos en la tabla laboratorio
        $query1="INSERT INTO laboratorio (num_presupuesto,fecha_muestreo,cosecha,id_tambor,id_productor,tipo_miel,hmf,color,humedad,acidez,stat) 
            VALUES (0,'0000-00-00','0000',$Tambor,$prov_id[0],'$Tipo','$Hmf',$Color,$Humedad,$Acidez,'MOV')";
        //echo $query1;
        $result = mysql_query( $query1 ) or die("No puedo insertar datos de laboratorio.".mysql_error());

        //busco id presupuesto correspondiente
        $presupuestos="SELECT id_presupuesto FROM presupuestos WHERE id_tambor='$Tambor' ";
        $pedidoIDPresup=mysql_query( $presupuestos ) or die("No puedo hacer select de presupuestos.".mysql_error());
        $Presupuesto = mysql_fetch_row($pedidoIDPresup);


        //inserto datos en tabla deposito
        $SQL2="INSERT INTO deposito (id_tambor,estado, id_productor, id_presupuesto,peso,tara,remito,num_lote,fecha_llegada,almacen) 
                   VALUES ($Tambor,'STOCK', $prov_id[0], $Presupuesto[0], $Peso_Bruto, $Tara,' $Remito_Ingreso',$Lote,'$Fecha_Ingreso','$Deposito')";
        //echo $SQL2;
        $result =mysql_query($SQL2) or die("No puedo insertar depositos.".mysql_error());


        //busco id deposito
        $SQL3="SELECT id_deposito FROM deposito WHERE id_tambor='$Tambor'";
        $pedidoIDDeposito=mysql_query( $SQL3 ) or die("No puedo hacer select de deposito.".mysql_error());
        $deposito_id = mysql_fetch_row($pedidoIDDeposito);
        //echo $SQL3;

        //busco id laboratorio
        $laboratorio="SELECT id_laboratorio FROM laboratorio WHERE id_tambor='$Tambor'";
        $pedidoIDLaboratorio=mysql_query( $laboratorio ) or die("No puedo hacer select de laboratorio.".mysql_error());
        $laboratorio_id = mysql_fetch_row($pedidoIDLaboratorio);
        //echo $laboratorio;

        //inserto datos en la tabla de stock
        $SQL = "INSERT INTO stock (id_tambor,peso_neto,id_presupuesto,id_deposito,id_laboratorio,rango) 
        VALUES ($Tambor,$Peso_Neto,$Presupuesto[0],$deposito_id[0],$laboratorio_id[0],'$Rango')"; 
        //echo "$SQL";

        $result = mysql_query( $SQL ) or die("No puedo insertar stock.".mysql_error());

        //busco id stock
        $SQL3="SELECT id_stock FROM stock WHERE id_tambor='$Tambor'";
        $pedidoIDStock=mysql_query( $SQL3 ) or die("No puedo hacer select de deposito.".mysql_error());
        $stock_id = mysql_fetch_row($pedidoIDStock);
        //echo $SQL3;
        if($GSB){
            //echo $row3[0];
            $SQL2 = "INSERT INTO export (id_tambor,id_stock,num_loteGSB) VALUES ($Tambor,$stock_id[0],$GSB)";   
            //echo "$SQL2";
            $result = mysql_query( $SQL2 ) or die("No puedo insertar exportacion con $Tambor.".mysql_error()); 
        }
    }
}
?>