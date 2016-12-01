<?php
session_start();

if(isset($_POST['logout'])){

    session_destroy();
    
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <title>Camisetas Baratas</title>
  </head>

  <body style="background-color: #ff6666;">
     <?php 
        if($_SESSION['adminLogueado']){
     ?> 
      <div><h3>Bienvenido <?= $_SESSION["nombreAdmin"] ?></h3></div>
      <form method="post" name="logout" style="position:absolute; left:90%; margin:8px;">
            <input type="submit" name="logout" value="Cerrar sesion">
      </form>
      <div class="container" style="width: 100%;">
        <br><br>			
      <div class="panel panel-info">
        <div class="panel-heading text-center" ><h2>Camisetas</h2></div>
        <?php
            // Conexión a la base de datos
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
            } catch (PDOException $e) {
                echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
                die ("Error: " . $e->getMessage());
            }
            $consulta = $conexion->query("SELECT * FROM producto");//query es para sacar datos
        ?>

        <table class="table table-striped table-hover table-condensed" >
        <tr><th>Imagen</th><th>Código</th><th>Nombre</th><th>Precio</th><th>Detalle</th><th></th><th></th></tr>
        <form action="altaProducto.php" method="post" enctype="multipart/form-data">
                <tr>
                    <td>
                        <input type="file" name="imagen">
                    </td>
                    <td>
                        <input type="text" name="codProducto">
                    </td>
                    <td>
                        <input type="text" name="nombre">
                    </td>
                    <td>
                        <input type="number" name="precio" step="0.05">
                    </td>
                    <td>
                        <input type="text" name="detalle">
                    </td>
                    <td>
                        <button type="submit" value="Añadir" class="btn btn-primary"  style="border-radius: 20px 20px 20px 20px;"><span class="glyphicon glyphicon-plus-sign"></span> &nbsp;&nbsp;Añadir&nbsp;&nbsp;</button>
                    </td>
                </tr>
            </form>
        <?php
            while ($producto = $consulta->fetchObject()) {
        ?>
            <tr>
                <td><img style="width:100px; height: 100px;" src="<?= $producto->imagen?>"/></td>
                <td><?= $producto->codProducto ?></td>
                <td><?= $producto->nombre ?></td>
                <td><?= $producto->precio ?></td>
                <td><?= $producto->detalle ?></td>
                <td>
                    <form action="eliminarProducto.php" method="post">
                        <input type="hidden" name="codProducto" value="<?= $producto->codProducto ?>">
                        <button type="submit" class="btn btn-danger" value="Eliminar" style="border-radius: 20px 20px 20px 20px;"><span class="glyphicon glyphicon-trash"></span> &nbsp;Eliminar&nbsp;</button>
                    </form>
                </td>
                <td>
                    <form action="modificaProducto.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="codProducto" value="<?= $producto->codProducto ?>">
                        <input type="hidden" name="detalle" value="<?= $producto->detalle ?>">
                        <input type="hidden" name="precio" value="<?= $producto->precio ?>">
                        <input type="hidden" name="nombre" value="<?= $producto->nombre ?>">
                        <input type="hidden" name="imagen" value="<?= $producto->imagen ?>">
                        <button type="submit"  class="btn btn-warning"  style="border-radius: 20px 20px 20px 20px;" value="Modificar"><span class="glyphicon glyphicon-edit"></span> Modificar</button>
                    </form>
                </td>
            </tr>
        <?php
            }
        ?>
            <form action="altaProducto.php" method="post" enctype="multipart/form-data">
                <tr><th>Imagen</th><th>Código</th><th>Nombre</th><th>Precio</th><th>Detalle</th><th></th><th></th></tr>
                <tr>
                    <td>
                        <input type="file" name="imagen">
                    </td>
                    <td>
                        <input type="text" name="codProducto">
                    </td>
                    <td>
                        <input type="text" name="nombre">
                    </td>
                    <td>
                        <input type="number" name="precio" step="0.05">
                    </td>
                    <td>
                        <input type="text" name="detalle">
                    </td>
                    <td>
                        <button type="submit" value="Añadir" class="btn btn-primary"  style="border-radius: 20px 20px 20px 20px;"><span class="glyphicon glyphicon-plus-sign"></span> &nbsp;&nbsp;Añadir&nbsp;&nbsp;</button>
                    </td>
                </tr>
            </form>
        </table>
      </div>
        
      <div class="text-center">&copy; Alejandro López Ortiz</div>
    </div>
    <?php 
        } else {
            header('location:login.php');
        }
    ?>
  </body>
</html>


