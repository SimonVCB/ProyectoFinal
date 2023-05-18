<?php
require_once("../assets/plantillas/conexionDB.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../assets/js/scripts.js"></script>
    <title>SimGreen</title>
    <style>

        body{
            height: auto;
        }

        table {
            width: 100%;
            
        }

        table > tr {
            margin: 20px;
        }

        table > *{
            text-align: center;
        }

        .datos {
            font-size: 0.8em;
            width: auto;
        }

        .borrarProducto, .modificarProducto {
            width: 100%;
            margin-bottom: 10px;
        }

        td,th {
            border-bottom: 1px solid black;
            padding: 10px 0px 10px 0px;
        }

        select {
            width: 200px;
            font-size: 1.4em;
        }

        #boton2 {
            font-size: 1.3em;
        }

        .modificarProductoSection {
            display: none;
        }

        .modificarProductoForm {
            display: flex;
            flex-direction: column;
            margin: 10px;
            border: 3px solid gray;
        }

        .modificarProductoForm > input {
            font-size: 1.4em;
        }

        .modificarProductoForm > p, .selectorMod {
            background-color: whitesmoke;
            width: auto;
        }

        .modificarProductoForm > * {
            margin: 3px;
        }

        .borrarProducto {
            background-color: rgba(233, 12, 12, 0.726);
            font-weight: bold;
        }

        .modificarProducto {
            background-color: rgba(27, 185, 212, 0.726);;
            font-weight: bold;
        }
    </style>
</head>
<body class="bodyListaProductos">


    <?php
    require("../assets/plantillas/cabecera.php");
    ?>
<main class="mainListaProductos">
<section class="listaProductos">
<?php
    $html = "";

 

            //Formulario par elegir el filtro de los productos antes de mostrarlos
            $html.="<h2>Elige un filtro para los productos</h2>";
            $html.= "<form id='formLista' method='POST'><select name='selector'>
                <option value='cod_producto' name='codigo'>Codigo</option>
                <option value='nombre_producto' name='nombre_producto'>Nombre</option>
                <option value='categoria' name='categoria'>Categoria</option>
                <option valie='precio' name='precio'>Precio</option>
                </select><input type='submit' name='boton2' id='boton2' value='Filtrar'></form>";
            
            if(isset($_POST["boton2"])){

                echo "<script> reload(); </script>";
                $opcion = $_POST["selector"];
                //Se hace la query con el filtro seleccionado
                $sql = "SELECT cod_producto, nombre_producto, categoria, precio from productos order by $opcion asc";
            
                $consulta = $conexion->query($sql);
                $totalFilas = $consulta->num_rows;
                
                $cod = "";
                

                //Se crea una tabla para que los datos de los productos aparezcan ordenados
                $html.="<table><tr> <th>Cod</th> <th>Nombre</th> <th>Categoria</th> <th>Precio</th> <th>Borrar/Mod</th></tr>";
                $html.="<tr>";
                for($i = 0; $i < $totalFilas; $i++){
                    $fila = $consulta->fetch_assoc();
                    foreach($fila as $indice => $valor){
                        if($indice == "cod_producto"){
                            $cod = $valor;
                        }
                        if($indice == "precio"){
                            $html.= "<td class='datos'>" . $valor . " €</td>";
                        }else{
                            $html.= "<td class='datos'>" . $valor . "</td>";
                        }
                    }   
                        //Estos dos botones manejan el borrado y el modificar de los productos
                        $html.="<td><form method='POST'><button class='borrarProducto' name='borrarProducto' value='{$cod}'>Borrar</button>
                        <button class='modificarProducto' name='modificarProducto' value='{$cod}'>Modificar</button></form></td></tr>";         
                }
                    $html.="</table>";
                    
        }
        echo $html;
            

    //Si se pulsa borrar se borrará ese producto de la base de datos
    if(isset($_POST["borrarProducto"])){
        
        $sql= "DELETE FROM productos WHERE cod_producto = '{$_POST['borrarProducto']}'";
        $consulta=$conexion->query($sql);
        unset($html);
        $html= "";

        if(isset($consulta)){
            $html.="Se ha borrado el producto con código: {$_POST['borrarProducto']}";
            echo $html;
        }
    }

    //Si se pusla el boton modificar se redirecciona a la misma página pero metiendo en la url el value del boton que es el código del producto para poder mostrarlo
    if(isset($_POST["modificarProducto"])){
        echo "<script> window.location.replace('lista-productos.php?codigo={$_POST["modificarProducto"]}'); </script>";   
    }

    //Si esta inicializado y es mayor que 0 se crea la query para sacar los datos del producto a modoficar y mostrarlos
    if(isset($_GET["codigo"]) && $_GET["codigo"] > 0){
        $sql="SELECT cod_producto, nombre_producto, categoria, precio from productos where cod_producto = '{$_GET['codigo']}'";
        $consulta=$conexion->query($sql);
        $totalFilas = $consulta->num_rows;
        unset($html);
        $html= "";

        $html.="<table><tr> <th>Cod</th> <th>Nombre</th> <th>Categoria</th> <th>Precio</th></tr>";
        $html.="<tr>";
        for($i = 0; $i < $totalFilas; $i++){
            $fila = $consulta->fetch_assoc();
            foreach($fila as $indice => $valor){
                if($indice == "precio"){
                    $html.= "<td class='datos'>" . $valor . " €</td>";
                }else{
                    $html.= "<td class='datos'>" . $valor . "</td>";
                }
            }
            $html.="</td></tr></table>";
            //Se muestra el formulario de modoficar
            $html.="<script> 
            $(document).ready(function(){
                $('.modificarProductoSection').css('display','inline'); 
            }); 
            </script>";        
        }
        echo "";
        echo $html;
    }

    

    ?>
</section>
<!-- Donde van los mensajes de exito -->
<p id="mensajeExito" style="color:blue"></p>

<section class="modificarProductoSection" id="modificarProductoSection">
<!-- Formulario de modificación de producto, oculto de primeras-->
<form class='modificarProductoForm' method='POST'>
<p class="modificarError" id="modificarError" style="color:red"></p>
<input type='number' id="precioMod" name="precioMod" placeholder='Precio producto'>
<select class='selectorMod' id='selectorMod' name='selectorMod'>
    <option value='' name='categoria'>Categoría</option>
    <option value='flores' name='flores'>Flores</option>
    <option value='frutos' name='frutos'>Frutos</option>
    <option value='bulbos' name='bulbos'>Bulbos</option>
    <option value='manual' name='manual'>Manual</option>
    <option value='Maquinaria' name='Maquinaria'>Maquinaria</option>
    <option value='jardin' name='jardin'>Jardín</option>
</select>
<input class='nombre' id="nombreMod" name="nombreMod" type='text' placeholder='Nombre producto'>
<textarea name="descripcion" rows=4 cols=50 placeholder = "Descripción..."></textarea>
<button name='botonModificar' class="botonCard botonModificar" >Modificar</button>
</form>
</section>
</main>

<?php
//Si se pulda el boton del formulario de modificar 
if(isset($_POST["botonModificar"])){
    //Guardamos los datos
    $precio = $_POST["precioMod"];
    $nombre = $_POST["nombreMod"];
    $select = $_POST["selectorMod"];
    $descripcion = $_POST["descripcion"];
    //Borramos la clase de la seccion del form para que no desaparezca si hay algún error
    echo "<script> 
        var element = document.getElementById('modificarProductoSection');
        element.classList.remove('modificarProductoSection');</script>";

    //Si no ninguna variable está vacía se sigue con el programa
    if($precio != "" && $nombre != "" && $descripcion != "" && $select != ""){

        //Se controlan los datos que se meten en el form por expresiones regulares
        $text = "";
        $textAux = "";
        $contra_regex = "/^\d+$/";
        if(!preg_match($contra_regex, $precio)){
            $textAux= "Precio producto. ";
            $text += $textAux;
        }
        $contra_regex2 = "/[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]{3,}/";
        if(!preg_match($contra_regex2, $nombre)){
            $textAux = "Nombre producto. ";
            $text += $textAux;
        }
        //Si el texto no está vacio se vuelva en la zona de error
        if($text != ""){
            echo "<script> document.getElementById('modificarError').innerHTML = 'Campos no válidos: ' + {$text}; </script>";
        }else {
            //Si lo está significa que no hay ningún error y se modifica el producto
            echo "<script> document.getElementById('modificarError').innerHTML = ''; 
                    </script>";
            $sql = "UPDATE productos SET precio='{$precio}', nombre_producto='{$nombre}', categoria='{$select}', descripción='{$descripcion}' where cod_producto = '{$_GET['codigo']}'"; 
            $consulta=$conexion->query($sql);
            if(isset($consulta)){
                //Este script da un mensaje de exito y recarga la página para que el formulario vuelva a tener la clase y así ocultarse
                echo "<script> 
                document.getElementById('mensajeExito').innerHTML = '¡Se ha actualizado el producto con éxito!';
                setTimeout(() => {
                    window.location.replace('lista-productos.php');   
                }, 2000);</script>";
            }
        }

    }else {
        echo "<script> document.getElementById('modificarError').innerHTML = 'Rellena todos los campos.'; </script>";
    }
}
?>

</body>
</html>