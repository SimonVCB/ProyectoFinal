<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/webfonts/fontawesome/css/all.css" rel="stylesheet">
    <!-- Recursos para el slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <title>SimGreen</title>

</head>
<body class="bodyPaginaPrincipal">
<?php 
   require("../assets/plantillas/cabecera.php");
?>

   
   <main class="mainPaginaPrincipal">

<div class="slider">

    <picture>
        <source media="(min-width:500px)" srcset="../assets/images/imagenPrincipal_pc.png">
        <img src="../assets/images/imagenPrincipal.jpg" alt="imagen1" style="width:auto;">
    </picture>

    <picture>
        <source media="(min-width:500px)" srcset="../assets/images/imagenPrincipal2_pc.png">
        <img src="../assets/images/imagenPrincipal2.png" alt="imagen2" style="width:auto;">
    </picture>

    <picture>
        <source media="(min-width:500px)" srcset="../assets/images/imagenPrincipal3_pc.png">
        <img src="../assets/images/imagenPrincipal3.png" alt="imagen2" style="width:auto;">
    </picture>
</div>  
    
    <section class="verTiempo">
        <h2>¿Quieres saber que tiempo va a hacer?</h2>
        <p>
            <span class="fa fa-sun sol"></span>
            <span class="fa fa-cloud nube1"></span>
            <span class="fa fa-cloud-rain nube2"></span>
            <span class="fa fa-cloud-sun-rain nube2"> </span>
            <span class="fa fa-wind viento"></span>
            <span class="fa fa-snowflake nieve"></span>
        </p>
        <h3><a  href="tiempo.php">¡Pincha aquí!</a></h3>
    </section>

    <div class="tituloNoticias">
    <h1>¿Eres nuevo?</h1>
    <p> ¡Lee estos artículos para empezar en el mundo de la jardinería! </p>
    </div>
    

    <section class="noticias">

        <article>
            <picture>
                <source media="(min-width:500px)" srcset="../assets/images/art1_tablet.jpg">
                <img class="imagenArt" src="../assets/images/art1_movil.jpg" alt="Articulo1">
            </picture>
            <p>Mejores flores para plantar</p>
            <input type="submit" class="botones2" id="botonArt1" value="Leer más">
        </article>

        <article>
            <picture>
                <source media="(min-width:500px)" srcset="../assets/images/art2_tablet.jpg">
                <img class="imagenArt" src="../assets/images/art2_movil.jpg" alt="Articulo2">
            </picture>
            <p>Aprende a cuidar tu jardín</p>
            <button class="botones2" id="botonArt2">Leer más</button>
        </article>

        <article>
            <picture>
                <source media="(min-width:500px)" srcset="../assets/images/art3_tablet.jpg">
                <img class="imagenArt" src="../assets/images/art3_movil.jpg" alt="Artículo3">
            </picture>
            <p>Trucos para mejorar en jardinería</p>
            <button class="botones2" id="botonArt3">Leer más</button>
        </article>

        <article>
            <picture>
                <source media="(min-width:500px)" srcset="../assets/images/art4_tablet.jpg">
                <img class="imagenArt" src="../assets/images/art4_movil.jpg" alt="Artículo4">
            </picture>
            <p>Mejores herramientas para empezar</p>
            <button class="botones2" id="botonArt4">Leer más</button>
        </article>
    </section>

    <script>
        
        $(document).ready(function(){

            //Funcionamiento del slider
            $('.slider').bxSlider({
            autoControls: true,
            auto: true,
            pager: true,
            slideWidth: 800,
            mode: 'horizontal',
            speed: 1000
            });

            //Script que guarda con localStorage el boton que se ha pulsado para corresponderlo en blog.php
            $("#botonArt1").click(function(){
                window.location.replace("blog.php");
                localStorage.setItem("articulo", "Art1");
            });

            $("#botonArt2").click(function(){
                window.location.replace("blog.php");
                localStorage.setItem("articulo", "Art2");
            });

            $("#botonArt3").click(function(){
                window.location.replace("blog.php");
                localStorage.setItem("articulo", "Art3");
            });

            $("#botonArt4").click(function(){
                window.location.replace("blog.php");
                localStorage.setItem("articulo", "Art4");
            });
        });
    </script>

    

   </main>

   <?php
   require("../assets/plantillas/pie.php");
   ?>
</body>
</html>