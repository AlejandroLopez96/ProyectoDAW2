<?php
session_start();

if(!isset($_SESSION['compraFinalizada'])){
    $_SESSION['compraRealizada']=false;
}
?>
<!DOCTYPE html>
 
<html>
  <head>
    <title>Tienda de Móviles</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/cssFin.css"/>
  </head>
  <body>    
      <div id="contenedor">
          <div id="compraProducto">
        <div id="carrito">
          
        <?php
        try {
          $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
      } catch (PDOException $e) {
          echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
          die ("Error: " . $e->getMessage());
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
      //recuperamos valores del formulario
      $codigo = $_POST["codigo"];
      $accion = $_POST["accion"];
      $cantidad = $_POST["cantidad"];
      $zona = $_POST["zona"];
      
      //Si mando por formulario acción comprar, 
      if($accion == "comprar" && isset($cantidad) && is_numeric($cantidad) && $cantidad > 0){
        $_SESSION["carrito"][$codigo]+=$cantidad;
      }
      if($accion == "actualizar"){
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
      echo "<h1> CARRITO DE LA COMPRA</h1>";
      foreach ($_SESSION["carrito"] as $codigo => $cantidad) {
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
            
            <form action="finalizarCompra.php" method="post">  
              Cantidad: <input type="number" min="1" name="cantidad" value="<?= $cantidad?>" required="true"/> <br>
              <input type="hidden" name="codigo" value="<?= $codigo?>"/>
              <input type="hidden" name="accion" value="actualizar"/>
              <input type="submit" value="Actualizar"/>
            </form>
            <form action="finalizarCompra.php" method="post">  
              <input type="hidden" name="codigo" value="<?= $codigo?>"/>
              <input type="hidden" name="accion" value="eliminar"/>
              <input type="submit" value="Eliminar"/>
            </form>

          <?php
          }
          }
        }   
      }
     
      if($vacio){
          echo " <h3> El carrito está vacio </h3>";
          header("refresh:3; url=indexUsuario.php");
      }else{
        echo "<br><br>total: ", $total, "€";
        ?>
          <form action="indexUsuario.php" method="post">  
            <input type="hidden" name="accion" value="eliminarTodo"/>
          <input type="submit" id="vaciarCarrito" value="Vaciar carrito"/>
          </form>
          <form action="finalizarCompra.php" method="post">  
              <select name="zona">
                <option value="espania">España</option>
                <option value="paisesEuropa">Otros países de Europa</option>
                <option value="resto">Resto del mundo</option>
              </select>
            <input type="hidden" name="accion" value="finCompra"/>
          <input type="submit" id="finCompra" value="Seleccionar Zona Envío"/>
          </form>
      <?php
            if($zona == "espania"){
                echo "<br><br>Total + gastos de envío: ", $total+9, "€ ";
            } else if ($zona == "paisesEuropa"){
                echo "<br><br>Total + gastos de envío: ", $total+14, "€";
            } else if ($zona == "resto"){
                echo "<br><br>Total + gastos de envío: ", $total+21, "€";
            } else if ($total >= 60 && $total < 200) {
                echo "<br>No se incluyen gastos de envío, gracias por confiar en nosotros";
                echo "<script>document.getElementById(\"finCompra\").disabled = true;</script>";
            } else if ($total >= 200) {
                echo "<br>No se incluyen gastos de envío, gracias por confiar en nosotros. ";
                echo "Le aplicaremos también un 5% de descuento del total";
                echo "<script>document.getElementById(\"finCompra\").disabled = true;</script>";
                echo "<br>Total con descuento: ", $total*0.95, "€";
            }
            
            if($_SESSION['usuarioLogueado']){
        ?>
       
            <div class="finalizarCompra">
                <form action="comprasRealizadas.php" method="post">
                    <input type="hidden" name="accion" value="eliminarTodo"/>
                    <input type='hidden' name="estadoCompra" value="comprado">
                    <input type="submit" id="vaciarCarrito" value="Comprar">
                </form>
            </div>
            <?php
            } else {
                ?>
                <div class="finalizarCompra">
                <form action="loginUsuario.php" method="post">
                    <input type="submit" value="Comprar">
                </form>
            </div>
             <?php   
            }
     }
    ?>
            </div>
          </div>
      </div>
  </body>
</html>