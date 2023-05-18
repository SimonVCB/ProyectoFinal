<?php 

require_once("../assets/plantillas/conexionDB.php");

session_start();

//Si hay sesión iniciada el mismo boton te llevará a perfil.php envez de a cuentas.php
if(isset($_SESSION['usuario']) && isset($_SESSION['contraseña'])){
    
    header('Location: perfil.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>SimGreen</title>
    <script src="../assets/js/scripts.js" type="text/JavaScript"></script>
    <script src="../assets/js/jquery/JQuery-3.6.3.min.js"></script>
    <style>

        
    </style>
</head>
<body class="bodyCuenta">
    <section>
        <form action="cuentas.php" class="formularioCuentas" method="POST">
            <a href="pagina-principal.php"><img class="logoPrincipalCuentas" src="../assets/images/logo.png" alt="logo"></a>
            <h4>Iniciar sesión</h4>
            <input id="usuario" name="usuario" type="text" placeholder="Usuario">
            <input id="contra" name="contra" type="password" placeholder="Contraseña">
            <p style="color:red" id="error"> </p>
            <input type="submit" id="boton1" name="boton1" class="botones" value="Iniciar Sesión">
            <h4>¿Eres nuevo?</h4>
            <input type="button" id="boton2" class="botones" value="Crear cuenta" onclick="location.href='alta-cuenta.php'">
        </form>

        <?php 
        
        if(isset($_POST["boton1"])){
            //Se guarda los datos de el form
            $usuario = $_POST["usuario"];
            $contraseña = $_POST["contra"];
            
            //Esta consulta se encarga de buscar el usuario y contrasña en la base de datos
            $sql = "SELECT usuario, contraseña from cuentas where usuario = '{$usuario}' and contraseña = '{$contraseña}'";
            $consulta = $conexion->query($sql);
            $totalFilas = $consulta->num_rows;
            $html = "";

            //Si no encuentra nada da error, si existe se crea dos variables de sesion y te lleva a la página principal
            if($totalFilas == 0){
                echo "<script>document.getElementById('error').innerHTML = 'Usuario/Contraseña erróneos';</script>";
            }else {
                echo "<script>document.getElementById('error').innerHTML = ' ';</script>";
                $_SESSION['usuario'] = $usuario;
                $_SESSION['contraseña'] = $contraseña;
                header('Location: pagina-principal.php');
            }

            echo $html;
        }
        
        ?>
    </section>
</body>
</html>