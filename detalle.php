<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <title></title>
        <link rel="stylesheet" href="css/styleUsuario.css" type="text/css" media="all" />
    </head>
    <body>
        
        <?php
        try {
            $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
        } catch (PDOException $e) {
            echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
            die ("Error: " . $e->getMessage());
        }

            
      
            session_start();

            $codigo = $_POST["codigo"];
            $consulta = $conexion->query("SELECT * FROM producto WHERE codProducto = '$codigo'");
            $producto = $consulta->fetchObject();
        ?>
            <header>
            <div id="sesion">
                <div id="camionTexto">
                    <img class="imgCamion" src="images/camion.png"><span>DEVOLUCIONES GRATIS, ENVÍOS GRATIS DESDE 45€</span>
                </div>
                <div id="identificar">
                    <img class="carritoCompra" src="images/carrito.png"><a class="linkIdentificar" href="login.php">Identifícate</a><img class="imgUsuario" src="images/user.png">
                </div>
            </div>
            <div id="logoBusqueda">
                <div id="logo">
                    <img src="images/logo1.png" class="imgLogo">
                </div>
                <div id="buscador">
                    <form action="">
                        <input type="search" name="nombre" placeholder="buscar">
                    </form>
                </div>
            </div>
        </header>
            <h1><?= $producto->nombre?></h1>
            <img class="imgDetalle" src="<?= $producto->imagen?>"/><br>
            Precio: <?= $producto->precio?>€<br>
            <?= $producto->detalle?>
            <form action="indexUsuario.php" method="post">
                <input type="submit" value="Volver">
            </form>
    </body>
</html>
