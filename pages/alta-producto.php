<?php
require_once("../assets/plantillas/conexionDB.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimGreen</title>
    <style>
        .altaProductoForm {
            display: flex;
            flex-direction: column;
            border: 3px solid gray;
            margin: 10px;
        }

        .altaProductoForm > * {
            padding: 5px;
            margin: 3px;
        }
    </style>
</head>
<body class="bodyAltaProducto">
    
<?php
    require("../assets/plantillas/cabecera.php");
?>
<main class="mainAltaProducto">
    <form action="alta-producto.php" method="POST" name="altaProductoForm" class="altaProductoForm" enctype="multipart/form-data">
    <h4>Introduce los datos del nuevo producto</h4>
    <p id="exitoAlta" style="color:blue"></p>
    <p id="errorAlta" style="color:red"></p>
    <input type="number" name="codigoAlta" placeholder="Código producto">
    <input type="number" name="precioAlta" placeholder="Precio producto">
    <input type="text" name="nombreAlta" placeholder="Nombre producto">
    <textarea name="descripcionAlta" rows="4" cols="50" placeholder="Descripción..."></textarea>
    <select class='selectorMod' id='selectorMod' name='selectorAlta'>
        <option value='' name='categoria'>Categoría</option>
        <option value='flores' name='flores'>Flores</option>
        <option value='frutos' name='frutos'>Frutos</option>
        <option value='bulbos' name='bulbos'>Bulbos</option>
        <option value='manual' name='manual'>Manual</option>
        <option value='Maquinaria' name='Maquinaria'>Maquinaria</option>
        <option value='jardin' name='jardin'>Jardín</option>
    </select>
    <input type="file" name="imagenProducto">
    <input type="submit" name="submit" value="Crear producto">
    </form>
</main>

<?php
//Si se pulda el boton de crear producto se guardan las variables del formulario
if(isset($_POST['submit'])){
    $categoria = $_POST["selectorAlta"];
    $codigo = $_POST["codigoAlta"];
    $precio = $_POST["precioAlta"];
    $nombre = $_POST["nombreAlta"];
    $descripcion = $_POST["descripcionAlta"];
    $nombreImg = $_FILES['imagenProducto']['name'];

    //Si ninguna está vacía
    if($categoria != "" && $codigo != "" && $precio != "" && $descripcion != "" && $nombreImg != "" && $nombre != ""){

        $text = "";
        $textAux = "";
        
        //Se guarda la imagen en la ruta de las carpetas, donde categoria también sirve para saber donde se guarda
        move_uploaded_file($_FILES['imagenProducto']['tmp_name'], "../assets/images/productos/{$categoria}/{$nombreImg}");
        //Se guarda la ruta en una variable
        $imagenProducto = "../assets/images/productos/{$categoria}/{$nombreImg}";

        //Se busca si existe el código de producto
        $sql = "SELECT cod_producto from productos where cod_producto = {$codigo}";
        $consulta = $conexion->query($sql);

        if($consulta->num_rows != 0){
            $textAux = "Código ya existe. ";
            $text =$text . $textAux;
            
        }

        //Expresión regular para que el nombre de producto
        $contra_regex = "/[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]{3,}/";
        if(!preg_match($contra_regex, $nombre)){
            $textAux = "Nombre producto. ";
            $text =$text . $textAux;
            
        }

        //Si la variable text no está vacia se vuelva en "errorAlta" con los errores acumulados
        if($text != ""){
            echo "<script> document.getElementById('errorAlta').innerHTML = 'Campos no válidos: ' + '{$text}'; </script>";
        } else {
            //Si está vacia se hace la query para introducir el nuevo producto y se imprime un mensaje indicando que se ha creado el producto
            $sql = "INSERT INTO productos VALUES ('$imagenProducto','$categoria','$nombre','$precio','$descripcion','$codigo')";
            $consulta=$conexion->query($sql);
            if(isset($consulta)){
                echo "<script> document.getElementById('exitoAlta').innerHTML = 'Se ha creado el producto con código {$codigo}'; </script>";
            }
        }
            
       //Si falta un campo por rellanar te lo indica
    }else {
        echo "<script> document.getElementById('errorAlta').innerHTML = 'Rellena todos los campos'; </script>";
    }
}



?>
 


</body>
</html>