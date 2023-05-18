<?php 
require_once("../assets/plantillas/conexionDB.php");
session_start();

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>SimGreen</title>
    <script src="../assets/js/scripts.js" type="text/JavaScript"></script>
    <script src="../assets/js/jquery/JQuery-3.6.3.min.js"></script>
    <link href="../assets/webfonts/fontawesome/css/all.css" rel="stylesheet">
    <style>
        .formularioCuentas {
            padding-top: 80px;
            padding-bottom: 50px;
            margin-bottom: 0px;
        }
    </style>
</head>
<body class="bodyAltaCuenta">
    <section>
    
        <form class="formularioCuentas" method="POST" action="alta-cuenta.php">
            <a href="pagina-principal.php"><img class="logoPrincipalCuentas" src="../assets/images/logo.png" alt="logo"></a>
            <h4>Creación de cuenta</h4>
            <div class="fa fa-info info">
                <ul id="informacion" class="informacion">
                    <li>Usuario: No puede estar repetido</li>
                    <li>Email: ejemplo@gmail.com</li>
                    <li>Contraseña: Mínimo 8 máximo 16 caracteres, un dígito, minúsculas y mayúsculas</li>
                </ul>
            </div>
            <input id="usuario" name="usuario" type="text" placeholder="Usuario">
            <input id="correo" name="email" type="email" placeholder="Email">
            <input id="contra" name="contra" type="password" placeholder="Contraseña">
            <input id="repContra" name="repContra" type="password" placeholder="Repetir contraseña">
            <p style="color:red" id="error"> </p>
            <p style="color:red" id="error2"> </p>
            <input type="submit" id="boton1" name="boton1" class="botones" value="Crear cuenta"><br>
            <input type="button" id="boton2" class="botones" value="Volver" onclick="location.href='cuentas.php'">
        </form>
    </section>

    <?php 
    
    //Si se pulsa en el boton1
    if(isset($_POST['boton1'])) {

        //Guardamos las variales del formulario
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $contra = $_POST['contra'];
        $repContra = $_POST['repContra'];

        //Si todas las variables no están vacías se sigue con el programa
        if($usuario != "" && $email != "" && $contra != "" && $repContra != ""){

                    //Variable para contar si hay algún error
                    $cont = 0;
                    $textError = "";
                    $text1 = "Contraseña no válida. ";
                    $text2 = "Contraseña no coincide. ";

                    //Consulta para saber si el nombre de usuario está repetido
                    $sql = "SELECT usuario from cuentas where usuario = '{$usuario}'";
                    $consulta = $conexion->query($sql);

                    //Si no se encuentran resultados, no está repetido
                    if($consulta->num_rows == 0){
                        echo "<script> document.getElementById('error').innerHTML = ''; </script>";
                    } else {
                        echo "<script> document.getElementById('error').innerHTML = 'Ese usuario ya existe'; </script>";
                        $cont++;
                    }

                    //Exprexión regular para comprobar la contraseña
                    $contra_regex = "/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/";
                    //Se comprueba que ambos campos de contraseña cumplan la expresión
                    if(preg_match($contra_regex, $contra) && preg_match($contra_regex, $repContra)){
                        //Que ambas sean iguales
                        if($contra != $repContra){
                            $cont++;
                            $textError = $text2;
                        }
                    }else {
                        $cont++;
                        $textError = $text1;
                    }

                    echo "<script> document.getElementById('error2').innerHTML = '{$textError}'; </script>";

                    //Si el cont de errores es 0 se mete el usuario en la base de datos, se inician variables de sesión y se le lleva al perfil
                    if($cont == 0){
                        
                        $sql = "INSERT INTO cuentas VALUES ('$usuario', '$email', '$contra')";
                        $consulta=$conexion->query($sql);
                        $_SESSION['usuario'] = $usuario;
                        $_SESSION['contraseña'] = $contra;
                        header("Location: perfil.php");
                        
                    }
        }else {
            echo "<script> document.getElementById('error').innerHTML = 'Rellena todos los campos.'</script>";
        }
    }
    
    ?>
    

    <script>
    
        
        //Script para que al pinchar sobre la i salga información
        $(document).ready(function() {

            $('.info').click(function() {

                $('.informacion').slideToggle("slow");
            });

        });
    
    </script>

    

</body>
</html>