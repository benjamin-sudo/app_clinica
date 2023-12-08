/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function NumGuion(e) {
    // extranjero = document.getElementById('inp_ext');
    //if(extranjero.checked!=true){
    evt = e ? e : event;
    tcl = (window.Event) ? evt.which : evt.keyCode;
    // alert("key="+tcl);
    if ((tcl < 48 || tcl > 57) && (tcl != 8 && tcl != 9 && tcl != 0 && tcl != 46 && tcl != 107 && tcl != 75) && tcl != 45) {
        return false;
    }
    return true;
    /* }
     else {
     
     return true;
     }*/
}

function NumGuionSinK(e) {
    // extranjero = document.getElementById('inp_ext');
    //if(extranjero.checked!=true){
    evt = e ? e : event;
    tcl = (window.Event) ? evt.which : evt.keyCode;
    // alert("key="+tcl);
    if ((tcl < 48 || tcl > 57) && (tcl != 8 && tcl != 9 && tcl != 0 && tcl != 46) && tcl != 45) {
        return false;
    }
    return true;
    /* }
     else {
     
     return true;
     }*/
}

function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode;
    return (key >= 48 && key <= 57);
}

function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-39-46-32";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}


function alfanumericoSpace(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 1234567890áéíóúabcdefghijklmnopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNOPQRSTUVWXYZ_";
    especiales = "8-37-39-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

function alfanumericoCateg(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "'";
    especiales = "10-8-37-39-46-32";

    if (letras.indexOf(tecla) == -1) {
        return true;
    } else {
        return false;
    }

}


//permite alfanumerico - y ¿?
function alfanumericoPers(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ¿?-";
    especiales = "8-37-39-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

function soloEmail(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = ".-_1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@";
    especiales = "8-37-39-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

function soloDireccion(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#";
    especiales = "8-37-39-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}



function alfanumerico(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "1234567890áéíóúabcdefghijklmnopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNOPQRSTUVWXYZ_";
    especiales = "8-37-39-46-13";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

function alfanumericoRuta(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "1234567890abcdefghijklmnopqrstuvwxyz_";
    especiales = "8-37-39-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

function numericoPunto(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "1234567890.";
    especiales = "8-37-39-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}


//Validaciones onblur, etc.

//Solo deja caracteres numericos
function onValidNumber(event) {
    var id = event.target.id;
    var str = event.srcElement.value.toString();
    var char = '';
    for (var i = 0; i < str.length; i++) {
        var key = str.charCodeAt(i);
        if (key >= 48 && key <= 57) {
            char += str.charAt(i);
        }
    }
    $('#' + id).val(char);
}

//Solo deja numeros puntos y K
function onValidNumberGuion(event) {
    var id = event.target.id;
    var str = event.srcElement.value.toString();
    var char = '';
    for (var i = 0; i < str.length; i++) {
        var key = str.charCodeAt(i);
        if ((key >= 48 && key <= 57) || (key === 45) || (key === 46)) {
            char += str.charAt(i);
        }
    }
    $('#' + id).val(char);
}

//Solo deja caracteres y espacio
function onValidChar(event) {
    var id = event.target.id;
    var str = event.srcElement.value.toString();
    var char = '';
    for (var i = 0; i < str.length; i++) {
        var key = str.charCodeAt(i);
        if ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key >= 160 && key <= 165)) {
            char += str.charAt(i);
        }
    }
    $('#' + id).val(char);
}


function calcular_edad(fecha, years) {

    if (validate_fecha(fecha) == true) {
        // Si la fecha es correcta, calculamos la edad
        var values = fecha.split('/');
        var dia = values[0];
        var mes = values[1];
        var ano = values[2];

        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth() + 1;
        var ahora_dia = fecha_hoy.getDate();

        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if (ahora_mes < mes) {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }

        // calculamos los meses
        var meses = 0;
        if (ahora_mes > mes)
            meses = ahora_mes - mes;
        if (ahora_mes < mes)
            meses = 12 - (mes - ahora_mes);
        if (ahora_mes == mes && dia > ahora_dia)
            meses = 11;

        // calculamos los dias
        var dias = 0;
        if (ahora_dia > dia)
            dias = ahora_dia - dia;
        if (ahora_dia < dia) {
            ultimoDiaMes = new Date(ahora_ano, ahora_mes, 0);
            dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
        }

        if (years == true) {
            //solo retorna edad en anios
            return edad;
        }

        return edad + "A " + meses + "M " + dias + "D";

    } else {
        return "La fecha " + fecha + " es incorrecta";
    }
}

function validate_fecha(fecha) {
    var patron = new RegExp("^([0-9]{1,2})([/])([0-9]{1,2})([/])(19|20)+([0-9]{2})$");

    if (fecha.search(patron) == '0') {
        var values = fecha.split('/');
        if (isValidDate(values[0], values[1], values[2])) {
            return true;
        }
    }
    return false;
}

function isValidDate(day, month, year) {
    var dteDate;
    month = month - 1;
    dteDate = new Date(year, month, day);

    //Devuelva true o false...
    return ((day == dteDate.getDate()) && (month == dteDate.getMonth()) && (year == dteDate.getFullYear()));
}