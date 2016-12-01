<?php
session_start();

if(isset($_POST['logout'])){

    session_destroy();
    
    header('location:indexUsuario.php');
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <title></title>
        <link rel="stylesheet" href="css/styleUsuario.css" type="text/css" media="all" />
        <script src="jquery/jquery-3.1.1.min.js"></script>
        <script src="jquery/jqueryCarrito.js"></script>
        <script src="jquery/jqueryUsuario.js"></script>
    </head>
    <body>
        <?php 
        try {
          $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
      } catch (PDOException $e) {
          echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
          die ("Error: " . $e->getMessage());
      }
        ?>
        <header>
            <div id="sesion">
                <div id="camionTexto">
                    <img class="imgCamion" src="images/camion.png"><span>DEVOLUCIONES GRATIS, ENVÍOS GRATIS DESDE 45€</span>
                </div>
                <div id="menuIdentificarCarrito">
                    <div id="menuResponsive">
                        <input type="checkbox" id="btn-menu">
                        <label for="btn-menu"><img src="images/list.png"></label>
                        <nav class="menu">
                            <ul>
                                <li><a href="">Inicio</a></li>
                                <li><a href="">Servicios</a></li>
                                <li><a href="">Productos</a></li>
                                <li><a href="comprasRealizadas.php">Compras</a></li>
                                <li><a href="">Contacto</a></li>
                            </ul>
                        </nav>
                    </div>
                    <a href="#" id="contenidoCarrito"><img class="carritoCompra" src="images/carrito.png"></a>
                    <div class="contenidoCarrito">
                    <?php
                    $consulta = $conexion->query("SELECT * FROM producto");
      //recuperamos valores del formulario
      $codigo = $_POST["codigo"];
      $accion = $_POST["accion"];
      $cantidad = $_POST["cantidad"];

      if (!isset($_SESSION["carrito"])){
        //Primera visita
        $cuentaConsultaCarrito = $consulta->rowCount();
        $_SESSION["carrito"] = [];
        for ($i = 0; $i <= $cuentaConsultaCarrito; $i++){
            $_SESSION["carrito"][$i] = 0;//Código => Cantidad
       }
      }
     
      //Si mando por formulario acción comprar, 
      if($accion == "comprar" && isset($cantidad) && is_numeric($cantidad) && $cantidad > 0){
        $_SESSION["carrito"][$codigo]+=$cantidad;
      }else if($accion == "actualizar"){
        $_SESSION["carrito"][$codigo]=$cantidad;
      }

      if($accion == "eliminar"){
        $_SESSION["carrito"][$codigo] = 0;
      }
      
      if($accion == "eliminarTodo"){
        foreach ($_SESSION["carrito"] as $codigo => $cantidad) {
          $_SESSION["carrito"][$codigo] = 0;
        }
      }
     
      // Mostrar carrito
      $vacio = true;
      $total = 0;
      foreach ($_SESSION["carrito"] as $codigo => $cantidad) {
        if($cantidad > 0){
          $vacio = false;
          $consulta2 = $conexion->query("SELECT * FROM producto WHERE codProducto = '$codigo'");
          $producto2 = $consulta2->fetchObject();
          $total += $producto2->precio*$cantidad;
          ?>

            <a id="<?=$producto2->codProducto?>">
            <img class="imgProductoCarrito" src="<?= $producto2->imagen?>"/>
            <?= $producto2->nombre?><span style="font-size: 1.2rem;float:right;"><?= $producto2->precio?>€</span><br>
            Cantidad:<?= $cantidad?>
            <div style="float:right;">
            <form action="indexUsuario.php" method="post">  
              <input type="hidden" name="codigo" value="<?= $codigo?>"/>
              <input type="hidden" name="accion" value="eliminar"/>
              <input type="submit" value="Eliminar"/>
            </form>
            </div>
            <br><br>
          <?php
        }   
      }
     
      if($vacio){
          echo " <h3> El carrito está vacio </h3>";
      }else{
        ?>
            <br>
            <p style="text-align:center;">TOTAL: <?= $total ?>€</p>
            <div class="finalizarCompra">
                <form action="finalizarCompra.php" method="post">  
                  <input type="submit" id="finCompra" value="Finalizar Compra"/>
                </form>
            </div>
       <?php
     }
    ?> 
            </div>
                    <?php 
                        if(!$_SESSION['usuarioLogueado']){
                    ?> 
                    <a class="linkIdentificar" href="loginUsuario.php"><img class="imgUsuario" src="images/user.png" style="float:left; margin-top:-5px;">Identifícate</a>
                    <?php 
                        }
                    ?>    
                    <?php 
                        if($_SESSION['usuarioLogueado']){
                     ?> 
                     <div class="linkIdentificar" style="display:flex;">
                        <span style="color: white; font-family: Oswald-Light; margin-right: 22px ">Bienvenido <?=$_SESSION["nombreUsuario"] ?></span>
                        <form method="post" name="logout">
                            <input type="submit" name="logout" value="Cerrar sesion">
                        </form>
                    </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
            <div id="logoBusqueda">
                <div id="logo">
                    <a href="indexUsuario.php"><img src="images/logo1.png" class="imgLogo"></a>
                </div>
                <div id="buscador">
                    <form action="">
                        <input type="search" name="nombre" placeholder="Buscar...">
                    </form>
                </div>
            </div>
            <div id="menuResponsive2">
                        <nav class="menu2">
                            <ul>
                                <li><a href="">Inicio</a></li>
                                <li><a href="">Servicios</a></li>
                                <li><a href="">Productos</a></li>
                                <li><a href="comprasRealizadas.php">Compras</a></li>
                                <li><a href="">Contacto</a></li>
                            </ul>
                        </nav>
                    </div>
        </header>
        <div id="contenedor">
            <div class="galeria">
                <ul>
                    <li><img src="images/1.png"></li>
                    <li><img src="images/2.png"></li>
                    <li><img src="images/3.jpg"></li>
                    <li><img src="images/4.jpg"></li>  
                </ul>
            </div>
            <div id="compraProducto">
                <div id="productos">
    <?php
          while ($producto = $consulta->fetchObject()) {
          ?>
            <div class="productoIndividual">        
                <a id="<?= $producto->codProducto?>"></a>
                <img src="<?= $producto->imagen?>"/><br>
                <p class="nombreProducto"><?= $producto->nombre?></p>
                <p class="precioProducto"><?= $producto->precio?>€</p>
                <form action="indexUsuario.php" method="post"> <!--Formulario de compra-->
                    <input type="number" min="1" name="cantidad" value="1" required="true"/>
                    <br><br>
                    <input type="hidden" name="codigo" value="<?= $producto->codProducto?>"/>
                    <input type="hidden" name="accion" value="comprar"/>
                    <input type="hidden" name="vacio" value="vaciar"/>
                    <input type="submit"  value="Añadir al carrito"/>
                </form>
                <form action="detalle.php" method="post">  <!--Formulario de detalles-->
                  <input type="hidden" name="codigo" value="<?= $producto->codProducto?>"/>
                  <input type="submit"  value="Ver producto"/>
                </form>
            </div>
          <?php
        }
        ?>
                </div>
            </div>    
        </div>
        <footer>
            <ul>
                <li class="facebook"><a href="http://facebook.com"></a></li>
                <li class="twitter"><a href="http://twiter.com"></a></li>
                <li class="google"><a href="http://google.com"></a></li>
                <li class="email"><a href="http://gmail.com"></a></li>
            </ul>
            <div class="informacion">
               <div class="direccion">
                <p>Calle Marie Curie, 10</p>
                <p>Campanillas,Málaga</p>
                </div>
                <div class="numTel"><p>962323232</p></div>
            </div>
        </footer>
    </body>
</html>
