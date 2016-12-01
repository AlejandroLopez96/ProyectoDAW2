<?php
session_start();

if(!isset($_SESSION['loginUsuario'])){
  
    $_SESSION['nombreUsuario']="";
}

// Conexión a la base de datos
    try {
        $conexion = new PDO("mysql:host=localhost;dbname=tiendaCamisetas;charset=utf8", "root", "root");
    } catch (PDOException $e) {
        echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
        die ("Error: " . $e->getMessage());
    }
    
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $consulta = $conexion->query("SELECT * FROM login WHERE usuario='$usuario' and clave='$clave'");
    $mensajeError = "";
    $datosItroducidos = $consulta->fetchObject();
    if($consulta->rowCount() == 1){
        if($datosItroducidos -> tipo == "usuario"){
            $_SESSION['usuarioLogueado']=true;
            $_SESSION['nombreUsuario']= $usuario;
            header("location:indexUsuario.php");
        }
    }else if(($consulta->rowCount() == 0) && isset ($_POST['usuario']) && isset ($_POST['clave'])){
      $mensajeError = "<h2 id='error'>Usuario o Clave incorrectos</h2>";
      header("refresh:3; url=indexUsuario.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>LogIn</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    </head>
    <body>
        <div class="container">
            <div class="signin"> 
                <form method="post" name="login">
                    <input type="text" class="user" name="usuario" placeholder=Username required/>
                    <input type="password" class="pass" name="clave" placeholder=Password required/>
                    <?=$mensajeError?>
                    <input type="submit" name="submit" value="LOGIN" />
                </form>
                <form action="registrarUsuario.php" method="post">
                    <input name="submit" type="submit" id="submit" value="REGISTRARSE"/>
                </form>
                <form action="bajaUsuario.php" method="post">
                    <input name="submit" type="submit" id="submit" value="BAJA USUARIO">
                </form>
            </div>
        </div>
    </body>
</html>