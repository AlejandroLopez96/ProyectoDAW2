<?php
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/cssFin.css"/>
    </head>
    <body>
        <h2>Productos que has comprado</h2>
        <?php
        try {
          $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
      } catch (PDOException $e) {
          echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
          die ("Error: " . $e->getMessage());
      }
        $codigo = $_POST["codigo"];
        $accion = $_POST["accion"];
        $cantidad = $_POST["cantidad"];
        $estadoCompra = $_POST["estadoCompra"];
        
        
        if($estadoCompra == "comprado" || $_SESSION['compraRealizada']){
        $_SESSION['compraRealizada'] = true;
        
        if($estadoCompra == "comprado"){
            $_SESSION['comprado'] = $_SESSION["carrito"];
            foreach ($_SESSION["carrito"] as $codigo => $cantidad) {
              $_SESSION["carrito"][$codigo] = 0;
            }
        }
        
        $consulta = $conexion->query("SELECT * FROM producto");
        $indice = 0;
        while($producto = $consulta->fetchObject()){
            $codigoProducto[$indice]=$producto->codProducto;
            $imgProducto[$indice]=$producto->imagen;
            $precioProducto[$indice]=$producto->precio;
            $nombreProducto[$indice]=$producto->nombre;
            $indice++;
        }

        foreach ($_SESSION["comprado"] as $codigo => $cantidad) {
        if($cantidad > 0){
          $vacio = false;
            
          for($i = 0; $i < count($codigoProducto); $i++){
              
              if($codigoProducto[$i] == $codigo){
                  $total += $precioProducto[$i]*$cantidad;
          ?>

            <a id="<?=compra.$codigo?>">
            <img class="imgProductoCarrito" src="<?= $imgProducto[$i]?>"/><br>
            <?= $nombreProducto[$i]?><br>
            <span><?= $precioProducto[$i]?>€</span><br>
            Cantidad:<?= $cantidad?>
            
          <?php
          }
          }
        }   
      }
        ?>
            <form action="indexUsuario.php" method="post">
                <input type="submit" value="Volver">
            </form>
        <?php
      }else{
          ?>
            <p>Todavía no has realizado ninguna compra</p>
        <form action="indexUsuario.php" method="post">
                <input type="submit" value="Volver">
            </form>
        <?php
      }
        ?>
    </body>
</html>
