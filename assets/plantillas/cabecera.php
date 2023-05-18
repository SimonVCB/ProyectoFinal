<?php 
require_once("conexionDB.php");
session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/webfonts/fontawesome/css/all.css" rel="stylesheet">
    <?php 
        if(basename($_SERVER['SCRIPT_NAME']) != "pagina-principal.php"){
            echo "<script src='../assets/js/jquery/JQuery-3.6.3.min.js'></script>";
        }
    ?>
    <script src="../assets/js/scripts.js"></script>
    <link rel="icon" type="image/ico" href="../assets/images/TabIcon/favicon.ico" sizes="16x16"/>
    <title>SimGreen</title>
    <style>
        .menuAdmin {
            border-bottom: 1px solid black;
            list-style:none
        }

        .menuAdmin > li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header >     
        <nav class="cabecera">
        <nav class="menu">
            <!-- Hice el menú con botones para saber cual se pulsaba -->
                <ul>
                    <li ><a  href="#"><span class="fa fa-bars barrasMenu"></span></a>
                        <ul>
                            <li><h3 class="menuTitu menuSemillas">Semillas</h3></li>
                            <li><!--<a href="#">Flores</a>--><button id="botonFlores" class="botonesTienda">Flores</button></li>
                            <li><!--<a href="#">Frutos</a>--><button id="botonFrutos" class="botonesTienda">Frutos</button></li>
                            <li><!--<a href="#">Bulbos</a>--><button id="botonBulbos" class="botonesTienda">Bulbos</button></li>
                            <li><h3 class="menuTitu menuHerramientas">Herramientas</h3></li>
                            <li><!--<a href="#">Manual</a>--><button id="botonManual" class="botonesTienda">Manual</button></li>
                            <li><!--<a href="#">Maquinaria</a>--><button id="botonMaquinaria" class="botonesTienda">Maquinaria</button></li>
                            <li><h3 class="menuTitu menuDecoracion">Decoración</h3></li>
                            <li><!--<a href="#">Jardín</a>--><button id="botonJardin" class="botonesTienda">Jardín</button></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <a href="pagina-principal.php"><img class="logoPrincipal" src="../assets/images/logo.png" alt="logo"></a>
                <form method="POST" class="barraBusquedaForm">
                <input  class="barraBusqueda" name="barraBusqueda" type="text" placeholder="Nombre de un producto...">
                <button class="botonBuscar" name="botonBuscar">Buscar</button>
                </form>
                <div class="iconosUno">
                <a href="cuentas.php" ><?php if(isset($_SESSION['usuario']) && isset($_SESSION['contraseña'])) {
                                            echo "<span style='color:green' class='fa fa-user usuario'>";
                                        }else {
                                            echo "<span style='color:red' class='fa fa-user usuario'>"; 
                                        }?></span></a>
                <a href="carrito.php"><span class="fa fa-cart-arrow-down carrito"><?php /*if(sizeof($_SESSION["misProductos"]) != null){ echo sizeof($_SESSION["misProductos"]); }*/ ?></span></a>
                </div>
            
        </nav>
        <?php 

        $usu = "admin";
        $contra = "Admin1234";
        //Si se conecta el admin con su cuenta aparecerá este menú de administración para ver los productos/cuentas y modificarlos
        if(isset($_SESSION['usuario']) && isset($_SESSION['contraseña'])){
            if($_SESSION['usuario'] == $usu && $_SESSION['contraseña'] == $contra){
                echo "<ul class='menuAdmin'>
                <li><h3>Menú de administración</h3></li>
                <li><a href='lista-productos.php'>Ver/Modificar/Borrar productos</a></li>
                <li><a href='alta-producto.php'>Crear un producto</a></li>
                <li><a href='lista-usuarios.php'>Lista de usuarios</a></li>
                <ul>";
            }
        }

        //Si se pulsa el botón de añadir al carrito se realizará esta pequeña animación 
        if(isset($_POST["botonPro2"])) {
            echo "<script>
            $(document).ready(function(){

                $('.carrito').addClass('animarCarrito');
                setTimeout(() => {
                    $('.carrito').toggleClass('animarCarrito');
                }, 500); 
            });
            </script>";
        }

        if(isset($_POST["botonBuscar"])){
            $buscar = $_POST["barraBusqueda"];
            /*if(basename($_SERVER['SCRIPT_NAME']) != "tienda.php" ){
            header("Location: tienda.php?busqueda={$buscar}");
            echo "<script> window.location.replace('tienda.php?busqueda={$buscar}'); </script>";
            }else {*/
            echo "<script> window.location.replace('tienda.php?busqueda={$buscar}'); </script>";
            //}
            
        }
        ?>

        <script>

            $(document).ready(function(){
                //Según el boton del menú pulsado se envia a la url una categoría de producto
                $("#botonFlores").click(function(){
                    window.location.replace("tienda.php?producto=flores");
                    localStorage.setItem("productos", "pro1");
                });

                $("#botonFrutos").click(function(){
                    window.location.replace("tienda.php?producto=frutos");
                    localStorage.setItem("productos", "pro2");
                });

                $("#botonBulbos").click(function(){
                    window.location.replace("tienda.php?producto=bulbos");
                    localStorage.setItem("productos", "pro3");
                });

                $("#botonManual").click(function(){
                    window.location.replace("tienda.php?producto=manual");
                    localStorage.setItem("productos", "pro4");
                });

                $("#botonMaquinaria").click(function(){
                    window.location.replace("tienda.php?producto=maquinaria");
                    localStorage.setItem("productos", "pro5");
                });

                $("#botonJardin").click(function(){
                    window.location.replace("tienda.php?producto=jardin");
                    localStorage.setItem("productos", "pro6");
                });
            });

        </script>
    </header>
</body>
</html>