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
        ?>
            Ya existe un usuario con el nombre <?= $_POST['usuario']?><br>
        <?php
            }else{
                if($accion == "alta"){
                    $insercion = "INSERT INTO login (usuario, clave, tipo) VALUES ('". $_POST['usuario']."', '". $_POST['clave']."', 'usuario')";
                    $conexion->exec($insercion);
                    echo "Usuario dado de alta correctamente.";
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
                    <input type="hidden" name="accion" value="alta">
                    <input type="submit" name="submit" value="ALTA" />
                </form>
            </div>
        </div>
    </body>
</html>
