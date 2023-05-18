
function comprobarDatosTarjeta() {
    
    if(document.getElementById("numCard").value != "" && document.getElementById("numSecCard").value != "" &&
     document.getElementById("tituCard").value != "" && document.getElementById("dateCard").value != ""){
        var text = "";
        var textAux = "";
        var hoy = new Date();
        var fecha = hoy.toLocaleDateString("es-EU");
        var fechaTar = document.getElementById("dateCard").value.substring(0,4);;

        if(!/[0-9]{15,16}/.test(document.getElementById("numCard").value)){
            textAux = "Número de tarjeta. "                   
            text += textAux;
        }
        if(!/[0-9]{3}/.test(document.getElementById("numSecCard").value)){
            textAux = "CCV. "                   
            text += textAux;
        }
        if(!/[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]{1,}/.test(document.getElementById("tituCard").value)){
            textAux = "Titular. "                   
            text += textAux;
        }
        if(hoy.getFullYear() > (fechaTar*1)){
            textAux = "Fecha de caducidad. ";
            text += textAux;
        }

        if(text != ""){
            return "Campos no válidos: " + text;
        }else {
            return text;
        }

    } else {
        text = "Rellena todos los campos";
        return text;
        
    }
}

function comprobarDatosDireccion() {

    if(document.getElementById("dirCalle").value != "" && document.getElementById("dirNumCalle").value != "" && document.getElementById("dirCodPostal").value != "") {
        var text = "";
        var textAux = "";
        if(!/[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]{1,}/.test(document.getElementById("dirCalle").value)) {
            textAux = "Calle. ";
            text += textAux;
        }
        if(!/[0-9]{1,}/.test(document.getElementById("dirNumCalle").value)) {
            textAux = "Número de calle";
            text += textAux;
        }
        if(!/^(?:0?[1-9]|[1-4]\d|5[0-2])\d{3}$/.test(document.getElementById("dirCodPostal").value)){
            textAux = "Código postal";
            text += textAux;
        }

        if(text != ""){
            return "Campos no válidos: " + text;
        }else {
            return text;
        }
    } else {
        text = "Rellena todos los campos";
        return text;
    }
}

/*function comprobarModificar() {

    if(document.getElementById("precioMod").value != "" && document.getElementById("nombreMod").value != ""){
        var text = "";
        var textAux = "";
        if(!/^\d+$/.test(document.getElementById("precioMod").value)){
            textAux= "Precio producto. "
            text += textAux;
        }
        if(!/[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]{3,}/.test(document.getElementById("nombreMod").value)){
            textAux = "Nombre producto. ";
            text += textAux;
        }

        if(text != ""){
            return "Campos no válidos: " + text;
        }else {
            return text;
        }

    } else {
        text = "Rellena todos los campos";
        return text;

    }
}*/



