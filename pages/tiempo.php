<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../assets/js/scripts.js"></script>
    <title>SimGreen</title>
</head>
<body class="bodyTiempo">
    <?php 
    require("../assets/plantillas/cabecera.php");
    ?>

<main class="mainTiempo">
<form class="formDelTiempo">
<h1>Pronóstico</h1>
<input type="text" id="localidad" class="localidad" placeholder="¿De dónde eres?">
<div id="errorTiempo" class="errorTiempo" style="color:red"></div>
<button id="botonTiempo" class="botonTiempo"><span class="fa fa-sun sol"></span><b>Ver el tiempo</b><span class="fa fa-cloud nube1"></span></button>
</form>

<section class="infoTiempo" id="infoTiempo">

</section>

<table id="tiempoTabla" class="tiempoTabla">
</table>
</main>


<script> 
            $(document).ready(function(){
                //Si se pulsa el botón del form se guarda en localStorage la localidad para poder usarla en el fetch de la api
                $("#botonTiempo").click(function(){
                    var localidad = document.getElementById("localidad").value;
                    if(localidad != ""){
                        localStorage.setItem("localidad", localidad);
                    } 

                });
            });

            //Si la variable localStorage no está vacía se hace el fetch con la localidad eligida por el usuario
            if(localStorage.getItem("localidad") != ""){
                var localidad = localStorage.getItem("localidad");
            fetch('https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/' + localidad + '?unitGroup=metric&key=B5X5HCVFWQN87B4T4JDLQLAUZ&contentType=json')
                        .then(response => response.json())
                        .then(data =>{

                            console.log(data);

                            //Se crean los elementos correspondientes y se van imprimiendo con append
                            var infoTiempo = document.getElementById("infoTiempo");
                            var tiempoTabla = document.getElementById("tiempoTabla");
                            var h4 = document.createElement("h4");

                            
                            h4.innerHTML = data.resolvedAddress;
                            infoTiempo.append(h4);
                            var tr = document.createElement("tr");
                            tiempoTabla.append(tr);
                                var th = document.createElement("th");
                                var th1 = document.createElement("th");
                                var th2 = document.createElement("th");
                                var th3 = document.createElement("th");
                                var mes = data.days[0].datetime;
                                var mesReal = mes.substring(5,7);
                                //Swithc para el nombre del mes
                                switch(mesReal){
                                    case '01': mesReal = "Enero";
                                            break;
                                    case '02': mesReal = "Febrero";
                                            break;
                                    case '03': mesReal = "Marzo";
                                            break;
                                    case '04': mesReal = "Abril";
                                            break;
                                    case '05': mesReal = "Mayo";
                                            break;
                                    case '06': mesReal = "Junio";
                                            break;
                                    case '07': mesReal = "Julio";
                                            break;
                                    case '08': mesReal = "Agosto";
                                            break;
                                    case '09': mesReal = "Octubre";
                                            break;
                                    case '10': mesReal = "Septiembre";
                                            break;
                                    case '11': mesReal = "Noviembre";
                                            break;
                                    case '12': mesReal = "Diciembre";
                                            break;
                                }
                                th.innerHTML = mesReal;
                                th1.innerHTML = "Máxima";
                                th2.innerHTML = "Temp";
                                th3.innerHTML = "Mínima";
                                tr.append(th);
                                tr.append(th1);
                                tr.append(th2);
                                tr.append(th3);
                            
                                //tabla con las temperaturas
                            for(var j = 0; j < 5; j++){
                                var tr2 = document.createElement("tr");
                                tiempoTabla.append(tr2);
                                var td = document.createElement("td");
                                var td1 = document.createElement("td");
                                var td2 = document.createElement("td");
                                var td3 = document.createElement("td");
                                var dia = data.days[j].datetime;
                                var diaReal = dia.substring(8.10);
                                td.innerHTML = "Día " + diaReal;
                                td1.innerHTML = data.days[j].tempmax + " º";
                                td2.innerHTML = data.days[j].temp + " º";
                                td3.innerHTML = data.days[j].tempmin + " º";
                                tr2.append(td);
                                tr2.append(td1);
                                tr2.append(td2);
                                tr2.append(td3);
                                
                            }

                            var p1 = document.createElement("p");
                            var p2 = document.createElement("p");
                            var p3 = document.createElement("p");
                            p1.innerHTML = "Humedad: " + data.currentConditions.humidity + "%";
                            infoTiempo.append(p1);
                            p2.innerHTML = "Velocidad del viento: " + data.currentConditions.windspeed + "km/h";
                            infoTiempo.append(p2);
                            p3.innerHTML = "Cobertura de nubes: " + data.currentConditions.cloudcover + "%";
                            infoTiempo.append(p3);

            })
            //Si hay algún error muestra mensaje por consola
            .catch(function (error) {
                console.log("Error");
            });
        }
    
</script>

<?php
   require("../assets/plantillas/pie.php");
?>

</body>
</html>