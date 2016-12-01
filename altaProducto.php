<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alta de productos</title>
    </head>
    <body>
        <h2>Alta Producto</h2>
        <?php
            // Conexión a la base de datos
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
            } catch (PDOException $e) {
                echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
                die ("Error: " . $e->getMessage());
            }
            $existe = ("SELECT codProducto FROM producto WHERE codProducto=".$_POST["codProducto"]);
            $consulta = $conexion->query($existe);
            if($consulta->rowCount()>0){
               header("refresh:3; url=indexAdmin.php"); 
        ?>
            Ya existe un producto con el Código <?= $_POST['codProducto']?><br>
        <?php
            }else{
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "images/" . $_FILES["imagen"]["name"]);
            $insercion = "INSERT INTO producto (codProducto, nombre, precio, imagen, detalle) VALUES ('". $_POST['codProducto']."', '". $_POST['nombre']."', '". $_POST['precio']."', '". 'images/' . $_FILES['imagen']['name']."', '". $_POST['detalle']."')";
            $conexion->exec($insercion);
            echo "Producto dado de alta correctamente.";
            header("refresh:3; url=indexAdmin.php"); 
            }
        ?>
    </body>
</html>
