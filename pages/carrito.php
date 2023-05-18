<?php 
require_once("../assets/plantillas/conexionDB.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/webfonts/fontawesome/css/all.css" rel="stylesheet">
    <script src="../assets/js/jquery/JQuery-3.6.3.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <title>SimGreen</title>
    <style>

        .carritoProducto {
            display:flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            width: 300px;
            margin: 5px 0px 5px 0px;
        }

        .campoCarrito1 {
            font-size: 0em;
        }

        .campoCarrito1 > img {
            width: 50px;
        }

        .precioTotal {
            padding-top: 10px;
            border-top: 1px solid black;
            margin-top: 10px;
        }

        .botonEliminar {
            font-weight: bold;
            font-size: 1.3em;
            border: none;
            border-left: 1px solid black;
            background-color:white;
            color: red;
        }


    </style>
</head>
<body class="bodyCarrito">

<?php 
   require("../assets/plantillas/cabecera.php");
?>
<main class="mainCarrito">
<section id="carritoCompra" class="carritoCompra" style="height:50vh">

    <?php
    

        $html = "";
        $html2 = "";
        $dinero = [];

        //Si el array no se ha inicializado o si esta vacio sale un mensaje indicandolo, si hay algún producto continúa
        if(!isset($_SESSION['misProductos']) || sizeof($_SESSION["misProductos"]) == 0){
            $html.= "<div class='carritoInfo'><h3>No has agregado nigún artículo al carrito aún.</h3><span class='fa fa-long-arrow-alt-down carritoFlecha'></span><p>¡Para agregar productos al carrito visite la tienda!</div>";
            echo $html;
        }else {

            $productos = [];
            $total = 0;

            //Si se pulsa sobre el boton, se elimina el producto del array
            if(isset($_POST["botonEliminar"])){
                echo "<script> var borrar = document.getElementById('carritoItem{$_POST['botonEliminar']}');
                                borrar.remove();
                    </script>";

                //Borramos el producto
                unset($_SESSION["misProductos"][$_POST["botonEliminar"]]);
                //Reindexamos el array para que las posiciones coincidan
                $_SESSION["misProductos"] = array_values($_SESSION["misProductos"]);
                //También se borra el precio del producto para que se reste del total
                unset($dinero[$_POST["botonEliminar"]]);    
            }

                //Por cada producto del array se da una vuelta
                for($h = 0; $h < sizeof($_SESSION["misProductos"]); $h++){
                    //Con esta consulta sacamos lo necesario para mostrarlo en el carrito
                    $sql = "SELECT imagen_producto, nombre_producto, precio from productos where cod_producto = '{$_SESSION['misProductos'][$h]}'";
                    $consulta = $conexion->query($sql);
                    $totalFilas = $consulta->num_rows;
                    $html = "";
                    $contadorCampos = 1;
                    
                    //Por cada producto hacemos un div con un id que va aumentando, por cada valor del producto una clase que va aumentando
                    $_SESSION["misProductos"] = array_values($_SESSION["misProductos"]);
                    for($i = 0; $i < $totalFilas; $i++){
                        $fila = $consulta->fetch_assoc();
                        $html.="<div class='carritoProducto' id='carritoItem{$h}'>";
                        foreach($fila as $indice => $valor){
                            $html.="<p class='campoCarrito{$contadorCampos}'>";

                                //Si el indice es que queremos le agregamos lo necesario para que funcione
                                $contadorCampos++;
                                if($indice == "imagen_producto"){
                                    $html.="<img src='{$valor}' alt='imagen1'>";
                                }
                                $html.= $valor;
                                if($indice == "precio"){
                                    $html.="<span> €</span></p>";
                                    //Se mete el precio de cada artículo en un array para tenerlo controlado
                                    array_push($dinero, $valor);
                                }else {
                                    $html.="</p>";
                                    
                                }
                                
                        }
                        $html.="<form method='POST'><button class='botonEliminar' name='botonEliminar' value='{$h}'>X</button></form></div>";
                        
                        
                        echo $html;
                        
                    }
                    
                    
                }

                    //El total es la suma del array de dinero
                    foreach($dinero as $valor){
                        $total += $valor;
                    }

                $html2.= "<p class='precioTotal'>Total precio de producto/s " . $total . " €</p>";

                //Si hay artículos aparece un botón
                if($total > 0){

                    $html2.="<button id='botonCarrito' class='botones2'>Comprar ahora</button>";
                    echo $html2;
                
                //Si no aparece el mismo mensaje que al principio
                }else {
                    unset($html2);
                    $html2="";
                    $html2.= "<div class='carritoInfo'><h3>No has agregado nigún artículo al carrito aún.</h3><span class='fa fa-long-arrow-alt-down carritoFlecha'></span><p>¡Para agregar productos al carrito visite la tienda!</div>";
                    echo $html2;
                }
               
            }
    
    ?>

</section>


<!-- Formulario 1/3 de datos para comprar-->
<section class="comprarProducto">
<h1 class="tituloDatosTarjeta">Datos tarjeta 1/3</h1>
<p id=mensajeError class="mensajeError" style="color:red"></p>
<form class="datosTarjeta" method="POST">
    <input type="number" class="numCard"  id="numCard" placeholder="Número de tarjeta">
    <input type="date" class="dateCard" id="dateCard" placeholder="Fecha caducidad">
    <input type="number" class="numSecCard" id="numSecCard" placeholder="CCV">
    <input type="text" class="tituCard" id="tituCard" name="tituCard" placeholder="Titular tarjeta">
    <p class="botonCard botonSiguientePro" id="botonSi" name="botonSi">Siguiente</p>
    <p class="botonCard botonVolverTienda" id="botonVolverTienda">Ver produdcto</p>
</form>
</section>
<!-- Formulario 2/3 de datos para comprar-->
<section id="direccion_entrega" class="direccion_entrega">
    <h1 class="tituloDatosDireccion">Dirección de entrega 2/3</h1>
    <p id=mensajeError2 class="mensajeError" style="color:red"></p>
    <form class="datosDireccion">
    <input type="text" id="dirCalle" placeholder="Calle">
    <input type="number" id="dirNumCalle" placeholder="Nº">
    <input type="text" id="dirPiso" placeholder="Piso/Letra">
    <input type="number" id="dirCodPostal" placeholder="Código postal">

    <p class="botonCard botonComprarPro" id="botonCo">Comprar</p>
    <p class="botonCard botonVolverPro" id="botonVolver">Volver</p>
    </form>
</section>
<!-- Formulario 3/3 de datos para comprar-->
<section id="mensajeCompra" class="mensajeCompra">
    <h1> Se ha completado la compra 3/3</h1>
    <p>Vea la factura para ver los detalles.</p>
    <form method="POST">
    <input type="text" name="dir" id="dir">
    <input type="submit" class="botonFactura" id="botonFactura" name="botonFactura" value="Ver factura">
    </form>
    <p class="botonOK" id="botonOK">¡OK!</p>
</section>
</main>
<script>

    $(document).ready(function(){
        
        $('#botonCarrito').click(function(){
            $('.comprarProducto').slideDown('slow');
        });

        $("#botonSi").click(function(){
            //Esta función está en assets/js/scripts.js es la encarga de comprobar los datos de la tarjeta y devuelve texto según el resultado
            var text = comprobarDatosTarjeta();
            if(text == ""){
                $(".comprarProducto").slideToggle("slow");
                $(".direccion_entrega").slideDown("slow");
            }else {
                document.getElementById("mensajeError").innerHTML = text;
            }
            
        });

        $("#botonCo").click(function(){
            //Esta función está en assets/js/scripts.js es la encarga de comprobar los datos de la tarjeta y devuelve texto según el resultado
            var text = comprobarDatosDireccion();
            if(text == ""){
                 //Junta todos los datos de la dirección para hacer un solo string
                var text = "C/";
                text+= document.getElementById("dirCalle").value + " Num: ";
                text+= document.getElementById("dirNumCalle").value + " Piso: ";
                text+= document.getElementById("dirPiso").value + " CP: ";
                text+= document.getElementById("dirCodPostal").value;
                document.getElementById("dir").value = text;
                $(".direccion_entrega").slideToggle("slow");
                $(".mensajeCompra").slideDown("slow"); 
            }else {
                document.getElementById("mensajeError2").innerHTML = text;
            }
        });

        $('#botonVolverTienda').click(function(){
            window.location.replace("tienda.php?producto=flores");
        });

        $(".botonVolverPro").click(function() {
            $(".direccion_entrega").slideToggle("slow");
            $(".comprarProducto").slideToggle("slow");
        });

        $('.botonOK').click(function(){
            window.location.replace("pagina-principal.php");
        });

        $(".botonFactura").click(function() {
            window.open("factura.php", "_blank")
        });

    });
</script>

<?php 
if(isset($_POST["botonFactura"])){
    if(!isset($_SESSION["dir"])){
        $_SESSION["dir"] = $_POST["dir"];
    }else {
        $_SESSION["dir"] = $_POST["dir"]; 
    }
}
   require("../assets/plantillas/pie.php");
?>
    
</body>
</html>