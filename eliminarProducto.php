<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Borrado Productos</title>
    </head>
    <body>
        <h2>Borrar producto</h2>
        <?php
            // Conexión a la base de datos
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
            } catch (PDOException $e) {
                echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
                die ("Error: " . $e->getMessage());
            }
           $accion = $_POST['accion'];
            if ($accion == "eliminar"){
            // Comprueba si ya existe un cliente con el DNI introducido
            $borrar = "DELETE FROM producto WHERE codProducto='$_POST[codProducto]'";
            $conexion -> exec($borrar);
            echo "Producto borrado correctamente";
            header( "refresh:3;url=indexAdmin.php" );
            $conexion->close();
            } else {
        ?>
        <h3>¿Seguro que quieres eliminar el producto?</h3>
            <form action="eliminarProducto.php" method="post">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" name="codProducto" value="<?=$_POST['codProducto']?>">
                <input type="submit" value="Eliminar">
            </form> 
            <form action="indexAdmin.php" method="post">
                <input type="submit" value="Volver">
            </form>
        <?php
            }
        ?>
    </body>
</html>