<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>SimGreen</title>
    <style>
        .mensajeErrorDB {
            border: 3px solid rgba(125,215,101);
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            margin: 10px;
        }

        .mensajeErrorDB > ul {
            list-style:none;
            display: flex;
            flex-direction: row;
        }

        .mensajeErrorDB > p {
            font-size: 0.7em;
        }
    </style>
</head>
<body class="bodyIndex">


<?php 

//Si antes de entrar a la página hay un error con la base de datos aparecerá este mensaje de error, si todo está bien se ingresa a la página
$conexion = new mysqli("localhost", "root", "root", "simgreen");
if(mysqli_connect_errno()){
    $conexion = new mysqli("localhost", "root", "root", "simgreen");
        if(mysqli_connect_errno()){
            echo "<div  class='mensajeErrorDB'>
                <h1>Error al establecer conexión con la base de datos.</h1>
                <img class='logoPrincipal' src='assets/images/logo.png' alt='logo'>
                <h4>Social</h4>
                <ul>
                    <li><a href='https://twitter.com'><img src='assets/images/twitter.png'> Twitter</a></li>
                    <li><a href='https://facebook.com'><img src='assets/images/facebook.png'> Facebook</a></li>
                    <li><a href='https://web.whatsapp.com'><img src='assets/images/whatsapp.png'> Whatsapp</a></li>
                </ul>
                <p>Iconos sacados de www.iconos8.es</p>
                </div>";
        }
    }else {
        header("Location: pages/pagina-principal.php");
    }

?>
    
</body>
</html>
