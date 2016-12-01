<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>LogIn</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    </head>
    <body>
        <?php
            // Conexión a la base de datos
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
            } catch (PDOException $e) {
                echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
                die ("Error: " . $e->getMessage());
            }
            
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $accion = $_POST["accion"];
            
            $existe = ("SELECT usuario FROM login WHERE usuario='$usuario' and clave='$clave'");
            $consulta = $conexion->query($existe);
            if($consulta->rowCount()>0){
                if($accion == "baja"){
                    $borrar = "DELETE FROM login WHERE usuario='$_POST[usuario]' AND clave='$_POST[clave]'";
                    $conexion->exec($borrar);
                    echo "Usuario dado de baja correctamente.";
                    header("refresh:3; url=indexUsuario.php");
                }
            }
        ?>
    <body>
        <div class="container">
            <div class="signin"> 
                <form method="post" name="login">
                    <input type="text" class="user" name="usuario" placeholder=Username required/>
                    <input type="password" class="pass" name="clave" placeholder=Password required/>
                    <input type="hidden" name="accion" value="baja">
                    <input type="submit" name="submit" value="Baja Usuario" />
                </form>
            </div>
        </div>
    </body>
</html>
