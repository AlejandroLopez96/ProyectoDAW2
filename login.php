<?php
session_start();

if(!isset($_SESSION['loginAdmin'])){
    $_SESSION['adminLogueado']=false;
    $_SESSION['nombreAdmin']="";
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
        if($datosItroducidos -> tipo == "administrador"){
            $_SESSION['adminLogueado']=true;
            $_SESSION['nombreAdmin']= $usuario;
            header("location:indexAdmin.php");
        } 
    }else if(($consulta->rowCount() == 0) && isset ($_POST['usuario']) && isset ($_POST['clave'])){
      $mensajeError = "<h2 id='error'>Usuario o Clave incorrectos</h2>";
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
                <form action="indexUsuario.php" method="post"><input name="submit" type="submit" id="submit" value="INGRESAR COMO USUARIO"/></form>
            </div>
        </div>
    </body>
</html>