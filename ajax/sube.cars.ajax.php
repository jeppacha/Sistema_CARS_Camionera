<?php 

	require_once "../modelos/conexion.php";

	if($_FILES['cars']['size']>0){

		$cars = $_FILES['cars']['tmp_name'];

		$handle = fopen($cars, 'r'); 

		while ($data = fgetcsv($handle, 1000, ",","\n")){

			if($data[0]){

				mysql_query("INSERT INTO tb_cars (id,  codcli, sucadm, nombre, nguia, org, dst, nomrem, nomdes, frecib, fdeliv, pdf) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."')");

			}

		}
		
		echo "ok";

	}
