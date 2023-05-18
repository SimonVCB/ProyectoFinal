<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/style.css" rel="stylesheet">
    <title>SimGreen</title>
    <style>

        .producto_tienda {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 3px solid rgba(125,215,101);
            background-color: rgb(250, 250, 250);
            margin: 15px;
            padding: 10px;
            border-radius: 10px;
        }

        .producto_tienda > p {
            margin: 12px;
        }

        .campoCardProducto1 {
            font-size: 0em;
        }

        .campoCardProducto1 > img {
            width: 170px;
        }

        .campoCardProducto2 {
            font-size: 1.5em;
        }

        .campoCardProducto3 {
            font-size: 2em;
        }

        .campoCardProducto4 {
            text-align: center;
        }

        #botonPro1, #botonPro2 {
            width: 200px;
            font-size: 1.3em;
            margin: 30px 0px 0px 0px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items:center;
        }

        

        
    </style>
</head>
<body class="bodyProducto">



<?php 
require("../assets/plantillas/cabecera.php");
?>
<main class="mainProducto">
<section class='producto_tienda' id='producto_tienda'>

<?php 

    /*$conexion = new mysqli("localhost", "root", "", "simgreen");
    if(mysqli_connect_errno()){
        echo "<h1>Error al establecer conexión</h1>";
    } else {*/

        //Conseguimos el codigo que se ha mandado a la url através de tienda.php para saber al producto que hemos pinchado y luego hacemos la query con el contenido que queremos
        if(isset($_GET["codigo"])){
        $codigo = $_GET["codigo"];
        $sql= "SELECT imagen_producto, nombre_producto, precio, descripción from productos where cod_producto = '{$codigo}'";
        $consulta = $conexion->query($sql);
        $totalFilas = $consulta->num_rows;
        $html = "";
        $contadorCampos = 1;
        $productos = [];
        
        for($i = 0; $i < $totalFilas; $i++){
            $fila = $consulta->fetch_assoc();
            
            foreach($fila as $indice => $valor){
                $html.="<p class='campoCardProducto{$contadorCampos}'>";

                    $contadorCampos++;
                    //Si el indice es que queremos le agregamos lo necesario para que funcione
                    if($indice == "imagen_producto"){
                        $html.="<img src='{$valor}' alt='imagen1'>";
                    }
                    $html.= $valor;
                    if($indice == "precio"){
                        $html.="<span> €</span></p>";
                    }else {
                        $html.="</p>";
                        
                    }
            }
        }
        
        //Si el cliente no está registrado/no tiene cuenta saldrá este mensaje indicando que no puede relizar ni compras ni agregarlo al carrito sin antes registrado
        if(!isset($_SESSION['usuario']) && !isset($_SESSION['contraseña'])){

            $html.="<section class='mensajeProducto'>
            <span class='fa fa-info info'></span>
            <p>Para realizar comprar o añadir productos al carrito es necesario registrarse o crear una cuenta.</p>
            </section>";
            
        
        }else {

            //Si la tiene aparecen dos botones
            $html.= "<form method='POST'><button class='botones2 botonComprar' id='botonPro1' name='botonPro1'>Comprar producto</button>
                <button class='botones2 botonAñadir' id='botonPro2' name='botonPro2'>Añadir al carrito</button></form>";

        }

        //Si se pulsa el botón de comprar se alm
        if(isset($_POST["botonPro1"])){

            //$_SESSION["codProducto"] = $_GET["codigo"];

            //Se inicializa el array para que no de problemas
            $_SESSION["misProductos"] = [];
            //Se hace un echo con jquery para hacer un slideDown del formulario de compra
            echo "<script>
            $(document).ready(function(){
                    $('.producto_tienda').slideUp('slow');
                    $('.comprarProducto').slideDown('slow');         
            });
            </script>";
        //Si se pulsa el boton de agregar al carrito
        } else if(isset($_POST["botonPro2"])){
            //Si esta inicializado el array se hace y se hace un push del código del producto, si no lo está se inicializa y se hace el push
            if(isset($_SESSION["misProductos"])){
                array_push($_SESSION["misProductos"], $codigo);
                echo "<h4 style='margin:0px'>Se ha añadido al carrito</h4>";
            }else {
                $_SESSION["misProductos"] = [];
                array_push($_SESSION["misProductos"], $codigo);
            }
            
        }

        

        echo $html;
    }
//}


?>

</section>
<!-- Formulario 1/3 de datos para comprar-->
<section id="comprarProducto" class="comprarProducto">

<h1 class="tituloDatosTarjeta">Datos tarjeta 1/3</h1>
<p id=mensajeError class="mensajeError" style="color:red"></p>
<form class="datosTarjeta" method="POST">
    <input type="number" class="numCard"  id="numCard" placeholder="Número de tarjeta">
    <input type="date" class="dateCard" id="dateCard" placeholder="Fecha caducidad">
    <input type="number" class="numSecCard" id="numSecCard" placeholder="CCV">
    <input type="text" class="tituCard" id="tituCard" name="tituCard" placeholder="Titular tarjeta">
    <p class="botonCard botonSiguientePro" id="botonSi" name="botonSi">Siguiente</p>
    <p class="botonCard botonVerPro" id="botonVer">Ver produdcto</p>
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
    <h1> Se ha completado la compra 3/3 </h1>
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

        $("#botonVer").click(function(){
            $('.producto_tienda').slideToggle('slow');
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

        $(".botonVolverPro").click(function() {
            $(".direccion_entrega").slideToggle("slow");
            $(".comprarProducto").slideToggle("slow");
        });

        $('.botonOK').click(function(){
            window.location.replace("pagina-principal.php");
        });

        //Vamos a factura.php pero lo metemos el código para que luego se imprima
        $(".botonFactura").click(function() {
            window.open("factura.php?codigo=<?php echo $_GET['codigo']?>", "_blank")
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