<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        .cardProductosTienda {
            display: grid;
            grid-template-columns: 1fr 1fr ;
            grid-template-rows: auto;
        }

        .cardProducto {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            width: auto;
            border: 2px solid lightgray;
            padding: 0px 10px 0px 10px;
            box-shadow: 4px 4px 5px gray;
            height: 330px;
            border-radius: 10px;
        }

        .cardProducto {
            margin: 10px;
        }

        .cardProducto > p {
            margin: 0px;
            
        }

        .campoCard1 {
            font-size: 0em;
        }

        .campoCard1 > img {
            width: 130px;
            border-bottom: 1px solid black;
        }

        .campoCard2 {
            font-size: 1.1em;
            text-align: center;
        }

        .campoCard3 {
            font-size: 2em;
            
        }

        .campoCard0 {
            font-size: 0.8em;
            text-align: center;
        }

        .botones2 {
            align-self: flex-end;
        }

        .mensajeErrorBusqueda {
            grid-area: 1 / 1 / 2 / 3;
            text-align: center;
            margin: 100px 20px 100px 20px;
        }


    </style>
</head>
<body class="bodyTienda">

    <?php 
    require("../assets/plantillas/cabecera.php");
    ?>
<main class="mainTienda">
<section class="cardProductosTienda">
    <?php

        if(isset($_GET["producto"]) || isset($_GET["busqueda"])){
        //Conseguimos la categoría del producto de la url que se ha mandado através de pinchar en el menú de la página
        $sql = "";
        if(isset($_GET["producto"])){
            $pro = $_GET["producto"];
            $sql = "SELECT imagen_producto, nombre_producto, precio, descripción, cod_producto from productos where categoria = '{$pro}'";
        }
        if(isset($_GET["busqueda"])){
            $bus = $_GET["busqueda"];
            $sql = "SELECT imagen_producto, nombre_producto, precio, descripción, cod_producto from productos where nombre_producto like '%{$bus}%'";
        }
        
        $cod_productos = array();

        
            //Si hay categoría se hace la query con la información que queremos
            $html = "";
 
            $consulta = $conexion->query($sql);
            $totalFilas = $consulta->num_rows;
            
            $contadorCampos = 1;

                for($i = 0; $i < $totalFilas; $i++){
                    $fila = $consulta->fetch_assoc();
                    $html="<div class='cardProducto'>";
                    foreach($fila as $indice => $valor){
                        $html.="<p class='campoCard{$contadorCampos}'>";
                        
                        //Si no son el código del producto se imprimen
                        if($indice != "cod_producto"){
                            $contadorCampos++;
                            if($indice == "imagen_producto"){
                                $html.="<img src='{$valor}' alt='imagen1'>";
                            }
                            $html.= $valor;
                            if($indice == "precio"){
                                $html.="<span> €</span></p>";
                            }else {
                                $html.="</p>";
                                
                            }
                        //Si lo es se guarda en el array para usarlo como diferenciador en los botones y saber que producto
                        //estamos eligiendo para ver    
                        }else {
                            $cod_productos[] = $valor;
                        }
                        
                        
                        if($contadorCampos == 4){
                            $contadorCampos = 0;
                        }
                    }

                    
                    $html.="<form method='POST'><button class='botones2' name='botonTienda' value='{$cod_productos[$i]}'>Ver producto</button></form></div>";
                    echo $html;

                    if(isset($_POST['botonTienda'])){
                        echo "<script> window.location.replace('producto.php?codigo={$_POST['botonTienda']}'); </script>";
                        }
                }

                if($html == ""){
                    echo "<div class='mensajeErrorBusqueda'>
                    <h1>¡Ups!</h1>
                    <p>No hay ningún artículo por esta zona</p>
                    <p>!Echa un vistado a las categorías para encontrar lo que busca!</p>
                    </div>";
                }

                
        }

        

    ?>

    </section>
    </main>
    <?php 
    require("../assets/plantillas/pie.php");
    ?>
    
</body>
</html>