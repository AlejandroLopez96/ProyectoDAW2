<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Modificación de Producto</title>
    </head>
    <body>
        <h1>Modificación del producto</h1>
        <?php
            // Conexión a la base de datos
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
            } catch (PDOException $e) {
                echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
                die ("Error: " . $e->getMessage());
            }
            
            $accion = $_POST['accion'];//recojo lo que meto en accion por fomulario y guardo el value que es modificar
            if($accion == "modificar"){ //al ser igual se actualizan los datos
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "images/" . $_FILES["imagen"]["name"]);
                $modificacion= "UPDATE producto SET codProducto='". $_POST['codProducto']."', nombre='". $_POST['nombre']."', precio='". $_POST['precio']."', imagen='". 'images/' . $_FILES['imagen']['name']."', detalle='". $_POST['detalle']."' WHERE codProducto='". $_POST[codProducto]."'";
                                                                                                                                                                //imagen='images/'
                $conexion->exec($modificacion);//lo ejecuta
                echo "Producto actualizado correctamente.";
                header( "refresh:3;url=indexAdmin.php" );//y el refresh que los segundo para que se recargue al index
                $conexion->close();
            }else{
        ?>
        <form method="post" action="modificaProducto.php" enctype="multipart/form-data">
            <div> 
              <label>&nbsp;&nbsp;Código de Producto:&nbsp;</label><input type="text" size="5" name="codProducto" value="<?= $_POST['codProducto'] ?>">
            </div>
            <div>
                <label>&nbsp;&nbsp;Nombre:&nbsp;</label><input type="text" size="30" name="nombre" value="<?= $_POST['nombre']?>">
            </div>
            <div>
                <label>&nbsp;&nbsp;Precio:&nbsp;</label><input type="number" step="0.05" name="precio" value="<?= $_POST['precio'] ?>">
            </div>
            <div>
                <label>&nbsp;&nbsp;Detalle:&nbsp;</label><input type="text" name="detalle" value="<?= $_POST['detalle'] ?>">
            </div>
            <div>
                <label>&nbsp;&nbsp;Imagen:&nbsp;</label><input type="file" name="imagen">
            </div>
            <div>
                <input type="hidden" name="accion" value="modificar">
            </div>
            <hr>
            
            &nbsp;&nbsp;<a href="indexAdmin.php"><span></span>Cancelar</a>
            <button type="submit"><span ></span>Aceptar</button><br><br>
        </form>
        <?php
            }
        ?>
    </body>
</html>
