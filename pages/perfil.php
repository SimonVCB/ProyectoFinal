<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body class="bodyPerfil">
<?php 
    require("../assets/plantillas/cabecera.php");
?>

<main class="mainPerfil">
<section class="contenidoPerfil">

<section class="datosCuenta">
<h1 class="perfilTitulo">Datos de la cuenta</h1>
            <!-- Se imprimen los datos de usuario -->    
            <p>Usuario: <?php echo $_SESSION['usuario'] ?></p>
            <p>Email: <?php 
                
                    $usuario = $_SESSION['usuario'];
                    $sql = "SELECT email from cuentas where usuario = '{$usuario}'";
                    $consulta=$conexion->query($sql);
                    $totalFilas = $consulta->num_rows;
                    if($totalFilas > 0){
                        for($i = 0; $i < $totalFilas; $i++){
                            $fila = $consulta->fetch_assoc();
                            foreach($fila as $indice => $valor){
                                echo $valor;
                            }  
                        }
                    }
                          
            ?></p>
            <p>Contraseña: <?php echo $_SESSION['contraseña'] ?></p>
        
        
        <p name="boton2" class="botonCard botonCerrarSesion">Cerrar sesión</p>
        <p name="boton2" class="botonCard botonBorrarCuenta">Borrar cuenta</p>
</section>

<section class="mensajeBorrarCuenta">
            <h4>¿Seguro que quieres borrar la cuenta?</h4>
            <span>(Esta acción no se puede deshacer)</span>
            <form class="perfilForm" name="perfilForm" method="POST" action="perfil.php">
            <input type="submit" class="botonBorrarSi" name="botonBorrarSi" value="SI">
            <input type="button" class="botonBorrarNo" name="botonBorrarNo" value="NO">
            </form>
</section>



</section>

<picture>
    <source media="(min-width:501px)" srcset="../assets/images/pie_perfil.png">
    <img src="../assets/images/pie_perfil_movil.png" alt="pie" class="imagenPiePerfil">
</picture>

<script>
//Script para la sección de "mensajeBorrarCuenta"
$(document).ready(function(){
        
        $(".botonBorrarCuenta").click(function() {
             $(".mensajeBorrarCuenta").slideDown("slow");
        });

        $(".botonBorrarNo").click(function(){
            $(".mensajeBorrarCuenta").slideToggle("slow");
        });

        $(".botonCerrarSesion").click(function(){
            window.location.replace('cerrar_sesion.php');
        });
     
    });

</script>


<?php 
//Si se pulsa que sí, se hará la query, aparecerá un alert indicando que se ha borrado y te llevará a cerrar_sesion.php
if(isset($_POST["botonBorrarSi"])){

    $sql= "DELETE FROM cuentas WHERE usuario = '{$_SESSION['usuario']}'";
    $consulta=$conexion->query($sql);

    if(isset($consulta)){
    echo "<script>
    alert('Se ha borrado la cuenta. Volviendo al inicio');
    window.location.replace('cerrar_sesion.php');
    </script>";
    }

}

?>

</main>

<?php 

require("../assets/plantillas/pie.php");
?> 


</body>
</html>