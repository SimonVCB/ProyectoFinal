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
        .datos {
            font-size: 0.9em;
            width: auto;
            text-align: center;
        }

        td,th {
            border-bottom: 1px solid black;
            padding: 10px 0px 10px 0px;
        }

        .borrarCuenta {
            background-color: rgba(233, 12, 12, 0.726);
            font-weight: bold;
        }
    </style>
</head>
<body class="bodyListaUsuarios">

<?php
    require("../assets/plantillas/cabecera.php");
    ?>

<p id="mensajeExito" style="color:blue"></p>
<main class="mainListaUsuarios">
<section class="listaUsuarios">
<?php
    $html = "";
    //Si no eres admin on puedes entrar a esta página
    if(isset($_SESSION["usuario"]) != "admin" && isset($_SESSION["contraseña"]) != "Admin1234") {
        echo "<h1>No tienes permiso para entrar a esta página</h1>";
    }else {
        //Se hace la query que selecciona todo en cuentas y luego las vuelca en una tabla con un boton que tiene como value el nombre de la cuenta para saber que botón está relacionado con qué
        $sql = "SELECT * from cuentas";
        $consulta = $conexion->query($sql);
        $totalFilas = $consulta->num_rows;
        $nombre = "";

        $html.="<table><tr> <th>Usuario</th> <th>Email</th> <th>Contraseña</th> <th>Borrar</th></tr>";
        $html.="<tr>";
        for($i = 0; $i < $totalFilas; $i++){
        $fila = $consulta->fetch_assoc();
            foreach($fila as $indice => $valor){
                    if($indice == "usuario"){
                        $nombre = $valor;
                    }
                    $html.= "<td class='datos'> " . $valor . " </td>";
            }
                $html.="<td><form method='POST'><button class='borrarCuenta' name='borrarCuenta' value='{$nombre}'>Borrar</button></form></td></tr>";         
            }
            $html.="</table>";
            echo $html;

        //Si se pulsa borrar se borra la cuenta con la query, aparece un mensaje y se recarga la página. Para que se vea reflejad la acción
        if(isset($_POST["borrarCuenta"])){
            
            $sql = "DELETE FROM cuentas WHERE usuario = '{$_POST["borrarCuenta"]}'";
            $consulta=$conexion->query($sql);
            if(isset($consulta)){
                echo "<script> document.getElementById('mensajeExito').innerHTML = '¡Se ha borrado la cuenta con éxito!'; 
                setTimeout(() => {
                    reload();  
                }, 2000);</script>";
                
            }
        }
    }

?>
</section>
</main>
 
</body>
</html>