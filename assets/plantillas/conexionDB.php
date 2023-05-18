<?php

$conexion = new mysqli("localhost", "root", "root", "simgreen");
if(mysqli_connect_errno()){
    $conexion = new mysqli("localhost", "root", "root", "simgreen");
        if(mysqli_connect_errno()){
            echo "<div  class='mensajeErrorDB'>
                <h1>Error al establecer conexión con la base de datos.</h1>
                <img class='logoPrincipal' src='assets/images/logo.png' alt='logo'>
                <a href='#'><h4>Contacta con nosotros</h4></a>

                <h4>Social</h4>
                <ul>
                    <li><a href='https://twitter.com'><img src='assets/images/twitter.png'> Twitter</a></li>
                    <li><a href='https://facebook.com'><img src='assets/images/facebook.png'> Facebook</a></li>
                    <li><a href='https://web.whatsapp.com'><img src='assets/images/whatsapp.png'> Whatsapp</a></li>
                </ul>
                <p>Iconos sacados de www.iconos8.es</p>
                </div>";
        }
}

?>