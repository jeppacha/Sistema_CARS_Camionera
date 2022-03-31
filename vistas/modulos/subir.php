<?php

    function subir(){

        require_once "conexion.php";

        if (isset($_POST['subir'])) {

            if (is_uploaded_file($_FILES['filename']['tmp_name'])) {

                echo "<h1>" . "File ". $_FILES['filename']['name'] ." subido." . "</h1>";

                echo "<h2>Datos subidos:</h2>";

                readfile($_FILES['filename']['tmp_name']);

            }
         
            //Import uploaded file to Database
            $handle = fopen($_FILES['filename']['tmp_name'], "r");
         
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                
                $import="insert into susursales (id,codoff,denom) values ('".$data[0]."','".$data[1]."','".$data[2]."')";
         
                mysql_query($import) or die(mysql_error());

            }
         
            fclose($handle);
         
            print "Import hecho!";
         
            //view upload form
        }
     
    }