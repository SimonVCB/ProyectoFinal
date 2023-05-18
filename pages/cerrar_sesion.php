<?php
//Página que cierra sesión y te devuelva a la principal
session_start();

if(isset($_SESSION['usuario']) && isset($_SESSION['contraseña'])) {
    session_destroy();
    header("Location: pagina-principal.php");
}

?>