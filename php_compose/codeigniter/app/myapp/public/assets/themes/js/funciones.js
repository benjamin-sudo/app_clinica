$(function() {
    $("#firmsimple").dialog({
        autoOpen: false,
        modal: true,
        height: 550,
        width: 700,
        hide: "scale",
        show: "fold",
        resizable: false,
        draggable: false
    });
    $("#idResetearClave").dialog({
        autoOpen: false,
        modal: true,
        height: 450,
        width: 650,
        hide: "scale",
        show: "fold",
        resizable: false,
        draggable: false,
        dialogClass: 'no-close'
    });
    $("#popRestabPass").dialog({
        autoOpen: false,
        modal: true,
        height: 310,
        width: 556,
        hide: "scale",
        show: "fold",
        resizable: false,
        draggable: false,
        closeOnEscape: false,
        dialogClass: 'no-close'
    });
    $("#validaDatos").dialog({
        autoOpen: false,
        modal: true,
        height: 690,
        width: 700,
        hide: "scale",
        show: "fold",
        resizable: false,
        draggable: false,
        closeOnEscape: false,
        dialogClass: 'no-close'
    });
    $("#imgPass").dialog({
        autoOpen: false,
        modal: true,
        height: 690,
        width: 1082,
        hide: "scale",
        show: "fold",
        resizable: false,
        draggable: false
    });
    setTimeout(function() {
        moverE();
    }, 10000);
});

function change_captcha() {
    AjaxExt({}, 'imgCaptcha', 'traeCod', '', 'inicio');
}

function validaPassChang() {
    var token = $_GET("tk");
    AjaxExt({ token: token }, 'respuesta', 'validaPassRestable', '', 'inicio');
}

function validaPass(idPass, idError) {
    $('#'.idError).hide('fast');
    var passNew = $('#' + idPass).val();
    var variables = { passNew: passNew, idError: idError };
    if (passNew != '') {
        AjaxExt(variables, 'respuesta', 'validaPass', '', 'inicio');
    }
}

function confirmDatPss() {
    var idUsrS = $('#idUsrS').val();
    var nombres = $('#nameUsr').val();
    var apePat = $('#apePatUsr').val();
    var apeMat = $('#apeMatUsr').val();
    var email = $('#emailUsr').val();
    var fono = $('#fonoUsr').val();
    var passActual = $('#passAcUsr').val();
    var passNew = $('#password1').val();
    var passNew2 = $('#passNew2Usr').val();
    var nivPass = $('#nivContr').val();
    var err = '';
    if (nombres === '') {
        err += 'Nombres\n';
    } else if (apePat === '') {
        err += 'Apellido Paterno\n';
    } else if (apeMat === '') {
        err += 'Apellido Materno\n';
    } else if (email === '') {
        err += 'Correo Electrónico de Contacto\n';
    } else if (fono === '') {
        err += 'Número Celular de Contacto\n';
    } else if (passActual === '') {
        err += 'Contraseña Actual\n';
    } else if (passNew === '') {
        err += 'Nueva Contraseña\n';
    } else if (passNew2 === '') {
        err += 'Repetir Contraseña\n';
    }
    if (err !== '') {
        $('#error_LPass').show('fast');
        $('#txtErrPss').html('Estimado Usuario, El Campo <b>' + err + '</b> es Requerido');
    } else if (nivPass === 'Pobre') {
        $('#error_LPass').show('fast');
        $('#txtErrPss').html('Estimado Usuario,\n En Nivel de Seguridad de la Nueva Contraseña es muy Bajo.');
    } else if (nivPass === 'Vulnerable') {
        $('#error_LPass').show('fast');
        $('#txtErrPss').html('La Contraseña Ingresada está dentro del registro de contraseñas vulnerables.');
    } else if (passNew !== passNew2) {
        $('#error_LPass').show('fast');
        $('#txtErrPss').html('Estimado Usuario,\n Las Contraseñas ingresadas con Coinciden.');
    } else {
        var variables = { idUsrS: idUsrS, nombres: nombres, apePat: apePat, apeMat: apeMat, email: email, fono: fono, passActual: passActual, passNew: passNew };
        AjaxExt(variables, 'respuesta', 'confirNewDat', '', 'inicio');
    }

}

function $_GET(param) {
    url = document.URL;
    url = String(url.match(/\?+.+/));
    url = url.replace("?", "");
    url = url.replace("#", "");
    url = url.split("&");
    x = 0;
    while (x < url.length) {
        p = url[x].split("=");
        if (p[0] == param) {
            return decodeURIComponent(p[1]);
        }
        x++;
    }
}

function moverE() {
    $("#Dv_cont").css("transform", "rotate(-360deg)");
    $("#Dv_cont").css("transition", "2s");
    setTimeout(function() {
        $("#Dv_cont").css("transform", "");
        $("#Dv_cont").css("transition", "");
    }, 2000);
    setTimeout(function() {
        moverE();
    }, 60000);
}


function removeMenu() {
    var idGet = $_GET('m');
    $('[id^=menu_]').each(function() {
        var id = $(this).attr('id');
        if ('menu_' + idGet != id && 'menu_0' != id) {
            $('#' + id).hide();
        }
    });
    if (idGet != '') {
        $('#txtMen2').append('<span style="float:right;padding: 7px 9px 0 0;font-size: 12px;"><i class="fa fa-undo"></i></span>');
    }

}

//Funcion General de Ajax
function AjaxExt(variables, id, funcion, tipDest, extension) {
    var imagens = '<img src="assets/themes/frontend/img/loadings.gif" style="width:100%; height:4px">';
    if (extension == undefined || extension == '') {
        var URLactual = jQuery(location).attr('href');
        var res = URLactual.split("/");
        var cont = res.length;
        cont = cont - 1;
        var nombreExt = res[cont];
        var res = nombreExt.split("#");
        nombreExt = res[0];
        var res = nombreExt.split("?");
        nombreExt = res[0];
    } else {
        var nombreExt = extension;
    }
    if (tipDest == undefined || tipDest == '') {
        $("#" + id).html("");
    }
    $("#carga").html(imagens);
    $("#cargaSecundaria").html(imagens);
    var post_llamada = $.post(nombreExt + "/" + funcion, variables, function(data) {
    }).done(function(data) {
        //hace lo que quieres cuando sale correctamente
        switch (tipDest) {
            case 'append':
                $("#" + id).append(data);
                break;
            case 'last':
                $("#" + id).last(data);
                break;
            case 'first':
                $("#" + id).first(data);
                break;
            case 'after':
                $("#" + id).after(data);
                break;
            case 'val':
                $("#" + id).val(data);
                break;
            default:
                $("#" + id).html(data);
                break;
        }
        $("#carga").html("");
        $("#cargaSecundaria").html("");
    }).fail(function(jqXhr, textStatus, errorThrown) {
        post_llamada.abort();
        // hace lo que quieras cuando sale con problemas.
        //$("#" + id).text("Problema al Procesar su Solicitud. " + errorThrown);
        //
        if (errorThrown != 'Internal Server Error' && errorThrown != '') {
            jError("Problema al Procesar su Solicitud.<br>" + errorThrown, 'Error Detectado');
            var URLactual = nombreExt + "/" + funcion;
            var variables = { error: errorThrown, URLactual: URLactual };
            AjaxExt(variables, 'respuesta', 'errorMail', '', 'frontend');
        }
    });
    return false;
}

var state = 0;

function menOc() {
    if (state == 0) {
        $('#panelIzq').hide('fast');
        $('#icoM').removeClass('fa-chevron-left');
        $('#icoM').addClass('fa-chevron-right');
        state = 1;
    } else {
        $('#panelIzq').show('fast');
        $('#icoM').removeClass('fa-chevron-right');
        $('#icoM').addClass('fa-chevron-left');
        state = 0;
    }
}

function vistaMenTop() {

}

var stateM = 0;

function ocMen() {
    if (stateM == 0) {
        $('#panelIzq').hide('fast');
        $('#menXu').removeClass('fa-chevron-left');
        $('#menXu').addClass('fa-bars');
        stateM = 1;
    } else {
        $('#panelIzq').show('fast');
        $('#menXu').removeClass('fa-bars');
        $('#menXu').addClass('fa-chevron-left');
        stateM = 0;
    }
}


// function selectM(ext, idPrin, idMen) {
//     window.location = ext + '?id=' + idMen + '&m=' + idPrin;
// }

function selectM(ext, idPrin, idMen, isToken, param) {
    if (isToken) {
        var variables = { ext: ext, idPrinP: idPrin, idMen: idMen, param: param };
        AjaxExt(variables, 'respuesta', 'getTokMenu', '', 'inicio');
    } else {
        if (param == undefined) {
            param = '';
        }
        window.location = ext + '?id=' + idMen + '&m=' + idPrin + param;
    }

}

function ocultMen() {

    if ($('#txtMen0').is(":visible")) {

        $("#formMenu").animate({
            width: "40px"
        }, 500);
        $("#contorno").animate({
            width: "1035px"
        }, 500);
        $("#DivBienvenido").height('20px');
        $("#DivBienvenido").css('padding', '4px');
        $("#txtMen0").hide('fast');
        $("#txtMen01").hide('fast');
        $('[class^=item]').each(function() {
            var idElement = $(this).attr('class');
            $("." + idElement).hide('fast');
        });
    } else {

        $("#formMenu").animate({
            width: "296px"
        }, 500);
        $("#contorno").animate({
            width: "1300px"
        }, 500);
        $("#DivBienvenido").height('20px');
        $("#DivBienvenido").css('padding-left', '5px');
        $("#txtMen0").show('fast');
        $("#txtMen01").show('fast');
        $("#icoOcl").attr('class', 'fa fa-caret-square-o-left icon-large');
        $('[class^=item]').each(function() {
            var idElement = $(this).attr('class');
            $("." + idElement).show('fast');
        });
    }

}

var timer

function timeclose() {
    if (timer != '') {
        clearTimeout(timer);
        timer = setTimeout("window.open('logout.php','_top');", 3666666);
    } else {
        timer = setTimeout("window.open('logout.php','_top');", 3666666);
    }
}


$(document).ready(function() {

    jQuery.browser = {};
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }



});
$.maxZIndex = $.fn.maxZIndex = function(opt) {
    /// <summary>
    /// Returns the max zOrder in the document (no parameter)
    /// Sets max zOrder by passing a non-zero number
    /// which gets added to the highest zOrder.
    /// </summary>    
    /// <param name="opt" type="object">
    /// inc: increment value, 
    /// group: selector for zIndex elements to find max for
    /// </param>
    /// <returns type="jQuery" />
    var def = { inc: 10, group: "*" };
    $.extend(def, opt);
    var zmax = 0;
    $(def.group).each(function() {
        var cur = parseInt($(this).css('z-index'));
        zmax = cur > zmax ? cur : zmax;
    });
    if (!this.jquery)
        return zmax;
    return this.each(function() {
        zmax += def.inc;
        $(this).css("z-index", zmax);
    });
}

function IsNumDigVer(e) //SOLO numeros y letra k
{
    tecla = (document.all) ? e.keyCode : e.which;
    patron = /[0-9]/; //patron	
    if (tecla == 75)
        return true; //K
    if (tecla == 107)
        return true; //k 
    te = String.fromCharCode(tecla);
    return patron.test(te); // prueba de patron	
}

function login() {
    var errores = '';
    var error = 0;
    var user = $("#user").val();
    var pass = $("#pass").val();
    if (user == '') {
        error = 1;
        errores += '- Debe completar el Rut de acceso \n';
    }

    if (pass == '') {
        error = 1;
        errores += '- Debe completar la Contraseña de acceso \n';
    }
    var access = $_GET('access');
    if (access == undefined) {
        access = '';
    }
    if (error == 0) {
        var id = "test2";
        var funcion = 'login';
        var variables = { "user": user, "pass": pass, "access": access };
        ajaxLog(variables, id, funcion);
        $('#logC').hide('fast');
        $('#cargando').show('fast');
    } else {
        jAlert(errores, "Listado de errores");
    }
}

function sesiones() {

    $('#iconSes').attr('class', 'fa fa-spinner fa-spin');
    var funcion = 'arraymenu';
    var id = "ocultosesion";
    var establecimiento = $("#listarestab option:selected").val();
    establecimiento = establecimiento.split('#');
    var variables = { "establecimiento": establecimiento[0], "tipoEstabl": establecimiento[1] }
    ajaxLog(variables, id, funcion);
}

function load() {
    var idSel = $_GET('m');
    var idMen = $_GET('id');

    var controller = traeController();

    var funcion = 'llenamenu';
    var variables = { idSel: idSel, idMen: idMen, controller: controller };
    var id = "formMenu";
    ajax(variables, id, funcion);
}

function loadDash() {
    var idSel = $_GET('m');
    var idMen = $_GET('id');

    // var controller = traeController();

    //    var funcion = 'loadMenuDashBoard';
    var funcion = 'loadMenuMaterial';
    var variables = { idSel: idSel, idMen: idMen, controller: 'frontend' };
    var id = "menuDash";
    ajax(variables, id, funcion);
}



function abrirVentanaCambioClave() {
    $('#idResetearClave').dialog('open');
}

function traeController() {
    var URLactual = jQuery(location).attr('href');
    var res = URLactual.split("/");
    var cont = res.length;
    cont = cont - 1;
    var nombreExt = res[cont];
    var res = nombreExt.split("#");
    nombreExt = res[0];
    var res = nombreExt.split("?");
    return nombreExt = res[0];
}

function getGET() {
    // capturamos la url
    var loc = document.location.href;
    // si existe el interrogante
    if (loc.indexOf('?') > 0) {
        // cogemos la parte de la url que hay despues del interrogante
        var getString = loc.split('?')[1];
        // obtenemos un array con cada clave=valor
        var GET = getString.split('&');
        var get = {};
        // recorremos todo el array de valores
        for (var i = 0, l = GET.length; i < l; i++) {
            var tmp = GET[i].split('=');
            get[tmp[0]] = unescape(decodeURI(tmp[1]));
        }
        return get;
    }
}

function obtGet() {
    // Cogemos los valores pasados por get
    var valores = getGET();
    if (valores) {
        var i = 0;
        var id = {};
        // hacemos un bucle para pasar por cada indice del array de valores
        for (var index in valores) {
            id[i] = valores[index];
            i++;
        }
    }

    return id;
}

function ConfirmCambioPass() {
    var pass1 = $("#newPass").val();
    var pass2 = $("#newPass2").val();
    var idUsu = $("#uIdS").val();
    if (pass1 == '' || pass2 == '') {
        jWarning('Debe llenar todos los campos', 'Restricción');
    } else if (pass1 != pass2) {
        jWarning('Las Contraseñas no coinciden', 'Alerta');
    } else if (pass1.length < 6) {
        jWarning('La Contraseña debe contener a lo menos 6 caracteres', 'Restricción');
    } else {

        var variables = { pass: pass1, idUsu: idUsu }
        AjaxExt(variables, 'respuesta', 'ConfirmCambioPass', '', 'inicio');
    }
}

function resetearClaves() {
    $("#m1").hide(500);
    $("#m2").hide(500);
    $("#m3").hide(500);
    $("#m4").hide(500);
    $("#m5").hide(500);
    $("#m6").hide(500);
    var correo = $("#txtEmail").val();
    var variables = { "correo": correo };
    var id = "m1";
    var codigo = $("#code").val();
    var captcha = $("#codeCap").val();
    if (correo == '') {
        $("#m2").show(500);
    } else if (codigo.toLowerCase() != captcha) {
        $("#m1").show(500);
    } else {
        ajax(variables, id, 'recuperaPassAccess');
        $("#m4").show(500);
    }
}

function logoutSes() {

    var id = "respuesta";
    var funcion = 'cierresesion';
    var variables = {}
    ajax(variables, id, funcion);
}

function guardacontra() {

    var txtPassNueva = $("#txtPassNueva").val();
    var txtRePassNueva = $("#txtRePassNueva").val();
    if ($('#txtPassNueva').val() != $('#txtRePassNueva').val()) {
        $("#mensaje2").html('Contraseñas no coinciden.');
        $("#TDtxtRePassNueva").attr("style", "background-color:#FA5858;");
    } else {


        var variables = { "funcion": 6, "txtPassNueva": txtPassNueva, "txtRePassNueva": txtRePassNueva }
        var id = "guardaUsu";
        ajax(variables, id);
    }
}

function rellenadatos() {

    var funcion = "rellenadatos";
    var variables = {}
    var id = "datosusu";
    ajax(variables, id, funcion);
}

function enter(valor) {
    if (valor == 'enterreseteapw') {
        $(window).keypress(function(e) {
            if (e.keyCode == 13) {
                resetearClaves();
            }
        });
    } else if (valor == 'enternewpass') {
        $(window).keypress(function(e) {
            if (e.keyCode == 13) {
                CambioPassEmail();
            }
        });
    } else if (valor == 'enterlogin') {
        $(window).keypress(function(e) {
            if (e.keyCode == 13) {
                login();
            }
        });
    }
}

function CambioPass() {

    var txtPassOLD = $("#txtPassOLD").val();
    var txtPassNueva = $("#txtPassNueva1").val();
    var txtRePassNueva = $("#txtRePassNueva1").val();
    var nivelPass = $("#nivContr0").val();

    if (txtPassNueva == '' || txtRePassNueva == '') {
        jWarning("La Contraseña no puede estar vacia", "Restricción");
    } else if (nivelPass == 'Pobre') {
        jWarning("El Nivel de seguridad de la contraseña es muy bajo", "Restricción");
    } else {
        var funcion = "cambiopass";
        var id = "guardaUsuu";
        var variables = { "txtPassNueva": txtPassNueva, "txtRePassNueva": txtRePassNueva, "txtPassOLD": txtPassOLD, "txtPassOLD": txtPassOLD }
        ajax(variables, id, funcion);
    }
}

function CambioPassEmail() {
    var txtPassNueva = $("#txtPassNueva").val();
    var txtRePassNueva = $("#txtRePassNueva").val();
    if (txtPassNueva === '' || txtRePassNueva === '') {
        jAlert('La Contraseña no puede estar vacia', 'ATENCION');
    } else {
        if (txtPassNueva <= 4) {
            jAlert('La Contraseña no cumple con los requisitos minimos (4 Digitos)', 'ATENCION');
        } else {
            var id = "guardaUsuu";
            var variables = { "funcion": 10, "txtPassNueva": txtPassNueva, "txtRePassNueva": txtRePassNueva }
            ajax(variables, id);
        }
    }
}

function guardausu() {
    if ($('#txtRut').val() === '' || $('#txtRutDig').val() === '' || $('#txtNombresUsu').val() === '' || $('#txtApellidoP').val() === '' || $('#txtApellidoM').val() === '' || $('#txtCorreo').val() === '' || $('#txtFono').val() === '' || $('#txtPassNueva').val() === '' || $('#txtRePassNueva').val() === '') {
        alert('Rellene los campos vacios');
    } else {


        var rut = $("#txtRut").val();
        var txtRutDig = $("#txtRutDig").val();
        var Nombre = $("#txtNombresUsu").val();
        var apellidoP = $("#txtApellidoP").val();
        var apellidoM = $("#txtApellidoM").val();
        var nombrescOMPLETO = Nombre + apellidoP + apellidoM;
        var correo = $("#txtCorreo").val();
        var celular = $("#txtFono").val();
        var variables = { "rut": rut, "txtRutDig": txtRutDig, "nombrescOMPLETO": nombrescOMPLETO.toUpperCase(), "Nombre": Nombre.toUpperCase(), "apellidoP": apellidoP.toUpperCase(), "apellidoM": apellidoM.toUpperCase(), "correo": correo, "celular": celular }
        var id = "guardaUsu";
        var funcion = "guardaUsu_"; //Funcion del Controlador a Ejecutar
        AjaxExt(variables, id, funcion);
    }
}

function validaTxt(e, Num) { // rut usu-
    tecla = (document.all) ? e.keyCode : e.which;
    if (Num == 1) //rut usuario solonume
    {
        patron = /[0-9]/; //patron
    } else if (Num == 1.1) //DIGITO DEL RUT
    {
        patron = /[0-9]/; //patron
        if (tecla == 75)
            return true; //K
        if (tecla == 107)
            return true; //k 
    } else if (Num == 2) //txtnombre usu
    {
        patron = /[a-zA-Z]/; //patron
        if (tecla == 32)
            return true; // espacio			
        if (e.ctrlKey && tecla == 86) {
            return true;
        } //Ctrl v
        if (e.ctrlKey && tecla == 67) {
            return true;
        } //Ctrl c
        if (e.ctrlKey && tecla == 88) {
            return true;
        } //Ctrl x				
    } else if (Num == 2.1) {
        patron = /[a-zA-Z]/; //patron
        if (tecla == 64)
            return true; //@
        if (tecla == 46)
            return true; //.
    } else if (Num == 6) {
        patron = /[a-zA-Z0-9]/; //patron
        if (tecla == 46)
            return true; //.
        if (e.ctrlKey && tecla == 64)
            return true; //Ctrl @
        if (e.ctrlKey && tecla == 86)
            return true; //Ctrl v
        if (e.ctrlKey && tecla == 67)
            return true; //Ctrl c
        if (e.ctrlKey && tecla == 88)
            return true; //Ctrl x		

        if (tecla == 32)
            return false; // espacio			
    } else if (Num == 3) //txtpriv
    {
        if (tecla == 8)
            return true; // backspace
        if (tecla == 45)
            return true; // -
        if (tecla == 32)
            return true; // espacio
        if (tecla == 62)
            return true; // >
        if (e.ctrlKey && tecla == 86) {
            return true;
        } //Ctrl v
        if (e.ctrlKey && tecla == 67) {
            return true;
        } //Ctrl c
        if (e.ctrlKey && tecla == 88) {
            return true;
        } //Ctrl x	 
        patron = /[a-zA-Z]/; //patron				
    } else if (Num == 4) {
        if (tecla == 8)
            return true; // backspace
        if (tecla == 32)
            return true; // espacio
        if (e.ctrlKey && tecla == 86) {
            return true;
        } //Ctrl v
        if (e.ctrlKey && tecla == 67) {
            return true;
        } //Ctrl c
        if (e.ctrlKey && tecla == 88) {
            return true;
        } //Ctrl x	
        patron = /[a-zA-Z0-9]/; //patron

    } else if (Num == 7) {
        patron = /[]/; //patron
        if (e.ctrlKey && tecla == 127) {
            return false;
        } //Ctrl x	
    }

    te = String.fromCharCode(tecla);
    return patron.test(te); // prueba de patron

}

function ValPassIguales() {
    if ($('#txtPassNueva1').val() != $('#txtRePassNueva1').val()) {
        $("#mensaje2").html('Contraseñas no coinciden.');
        $("#txtPassNueva1").css("border-color", "#FA5858");
        $("#txtRePassNueva1").css("border-color", "#FA5858");
    } else {
        $("#mensaje2").html('');
        $("#txtPassNueva1").css("border-color", "#CCC");
        $("#txtRePassNueva1").css("border-color", "#CCC");
    }
}

function LimpiarUsu(num) {

    if (num == 1) {
        $("#txtPassNueva1").val('');
        $("#txtRePassNueva1").val('');
    }
}

function idactualizar(id2) {
    var variables = { "funcion": 11, "id2": id2 }
    var id = "";
    ajax(variables, id);
}

function idactualizar1(id1) {
    var variables = { "funcion": 12, "id1": id1 }
    var id = "";
    ajax(variables, id);
}

function firmasimple() {

    $('#firmsimple').dialog('open');
    var html_ = '<div class="mensajeAlerta">Sr.Usuario';
    html_ += '<br>Favor mantener su Contraseña de Firma Digital Simple en forma confidencial debido a que su uso tiene implicancia legal.<br>';
    html_ += '<div> Si desea recuperar la Firma Digital a su correo electrónico, presionar botón enviar ';
    html_ += '<center><br><a class="btn btn-success" href="#" onclick="firmasimplexemail()"><i class="fa fa-envelope-o"></i> Enviar Firma Simple</a>';
    html_ += '</center>';
    html_ += '</div>';
    html_ += '<br>Si desea cambiar su firma digital puede hacerlo en el siguiente formulario: </div>';
    html_ += '<table class="table table-striped" style="border 1px; width:100%;">';
    html_ += '<tr><td colspan="2" class="info"><b>Formulario Cambio de Firma simple</b></td></tr>';
    html_ += '<tr><td colspan="2">*Su Nueva firma simple debe tener un minimo de 4 caracteres </td></tr>';
    html_ += '<tr><td>NUEVA FIRMA SIMPLE :</td><td><input name="txtPassFirmaS1pop" id="txtPassFirmaS1pop" type="password" onblur="minimo4()" ></td></tr>';
    html_ += '<tr><td> REINGRESAR FIRMA SIMPLE :</td><td><input name="txtPassFirmaS2pop" id="txtPassFirmaS2pop" type="password" onblur="ValPassFirmaIgualesFs()"><br><span id="mensaje2pop"></span></td></tr>';
    html_ += '<tr><td colspan="2"><a class="btn btn-success" href="#" onclick="CambioFirma()"><i class="fa fa-floppy-o"></i> Guardar Firma Simple</a> &nbsp; &nbsp;   <a class="btn btn-danger" href="#" onclick="salirpopupfirmasimple()()"><i class="fa fa-ban"></i> Cancelar</a> </td></tr>';
    html_ += '</table>';
    $('#firmsimple').html(html_);
}

function minimo4() {
    var str = $('#txtPassFirmaS1pop').val().length;
    if (str < 4) {
        jAlert("La firma simple debe tener un minimo de 4 caracteres", "Listado de Errores");
    }
}


function ValPassFirmaIgualesFs() {
    if ($('#txtPassFirmaS1pop').val() != $('#txtPassFirmaS2pop').val()) {
        $("#mensaje2pop").html('Contraseñas no coinciden.');
        $("#txtPassFirmaS1pop").css("border-color", "#FA5858");
        $("#txtPassFirmaS2pop").css("border-color", "#FA5858");
    } else {
        $("#mensaje2pop").html('');
        $("#txtPassFirmaS1pop").css("border-color", "#CCC");
        $("#txtPassFirmaS2pop").css("border-color", "#CCC");
    }
}



function salirpopupfirmasimple() {
    $('#firmsimple').dialog('close');
}

function CambioFirma() {

    if ($('#txtPassFirmaS1pop').val() != $('#txtPassFirmaS2pop').val()) {
        $("#mensaje2pop").html('Contraseñas no coinciden.');
        $("#txtPassFirmaS1pop").css("border-color", "#FA5858");
        $("#txtPassFirmaS2pop").css("border-color", "#FA5858");
    } else {
        var error = 0;
        var errores = '';
        var firma1 = $('#txtPassFirmaS1pop').val();
        var firma2 = $('#txtPassFirmaS2pop').val();
        if (firma1 == '') {
            error = 1;
            errores = '- La firma simple no puede estar vacia\n';
        }

        if (firma2 == '') {
            error = 1;
            errores = '- La firma simple no puede estar vacia\n';
        }

        if (error == 0) {

            var funcion = "cambioPassFirmaSimple0";
            var id = "respuesta";
            var variables = { "firma1": firma1 }
            ajax(variables, id, funcion);
        } else {
            jAlert(errores, "Listado de Errores");
        }
    }

}




function ValPassFirmaIguales() {
    if ($('#txtPassFirmaS1').val() != $('#txtPassFirmaS2').val()) {
        $("#mensaje2").html('Contraseñas no coinciden.');
        $("#TDtxtRePassNueva").attr("style", "background-color:#FA5858;");
    } else {
        $("#mensaje2").html('');
        $("#TDtxtRePassNueva").attr("style", "none");
    }
}

function firmasimplexemail() {
    var variables = {};
    var id = "respuesta";
    var funcion = "RecuerdaContrasena";
    ajax(variables, id, funcion);
}

function confirmafirmasimple() {

    var funcion = "cambioPassFirmaSimple";
    var id = "respuesta";
    var variables = {}
    ajax(variables, id, funcion);
}

function firmasimplexemail2(idusu, token) {

    var variables = { "funcion": 17, "idusu": idusu, "token": token }
    var id = "muestrapagina";
    ajax(variables, id);
}


$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);
//validaciones
function IsNumber(e) { //SOLO NUMEROS				
    tecla = (document.all) ? e.keyCode : e.which;
    patron = /[0-9]/; //patron		

    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function validarLetras(e) { //SOLOLETRAS
    tecla = (document.all) ? e.keyCode : e.which;
    patron = /[A-Z-a-z]/; //patron
    if (tecla == 32)
        return true; // espacio						
    te = String.fromCharCode(tecla);
    return patron.test(te); // prueba de patron	

}


function IsDigitoVerificador(e) //SOLO K Y NUMEROS EN DIGITO VERIFICADOR
{
    tecla = (document.all) ? e.keyCode : e.which;
    patron = /[0-9]/; //patron	
    if (tecla == 75)
        return true; //K
    if (tecla == 107)
        return true; //k 
    te = String.fromCharCode(tecla);
    return patron.test(te); // prueba de patron	
}

var _utf8c = {
    '&aacute;': '\u00e1',
    '&eacute;': '\u00e9',
    '&iacute;': '\u00ed',
    '&oacute;': '\u00f3',
    '&uacute;': '\u00fa',
    '&Aacute;': '\u00c1',
    '&Eacute;': '\u00c9',
    '&Iacute;': '\u00cd',
    '&Oacute;': '\u00d3',
    '&Uacute;': '\u00da',
    '&ntilde;': '\u00f1',
    '&Ntilde;': '\u00d1',
    '&iquest;': '\u00bf'
};

function botX() {
    $("#quitaProfUsuDel").attr("disabled", false);
    $("#quitaEstabUsuDel").attr("disabled", false);
}

function desplegar(val) {


    if (val == 3) {
        $('#firmasimple').hide(500);
        $("#formContenido").show(500);
        $("#cambiopassnueva").hide(500);
        $("#creamenu").hide(500);
        $("#creaprivilegios").hide(500);
        $("#CreaUsu").show(500);
        $("#frmguardarUsu").show(500);
        $("#muestrapagina").hide(500);
        $("#quitaProfUsuDel").attr("disabled", true);
    } else if (val == 1) {
        $("#formContenido").show(500);
        $("#muestrapagina").show(500);
    } else if (val == 4) {
        $("#formContenido").show(500);
        $("#cambiopassnueva").show(500);
    } else if (val == 5) {
        $("#formContenido").hide(500);
        $('#firmasimple').show(500);
        $("#cambiopassnueva").hide(500);
        $("#creamenu").hide(500);
        $("#creaprivilegios").hide(500);
        $("#muestrapagina").hide(500);
        $("#quitaProfUsuDel").attr("disabled", true);
    }
}

function limpiar() {
    $("#formContenido").hide(500);
}

function ocultar() {

    setTimeout(function() {
        $("#texto").attr("style", "width:378px; -webkit-transition: width .4s;");
        $("#texto").hide("fast");
    }, 3000);
}

function abrir() {
    $("#opcionCierre").dialog('open');
}

function cerrar() {
    $("#opcionCierre").dialog('close');
}


$().ready(function() {
    $('.pasar').click(function() {
        return !$('#origen option:selected').clone().appendTo('#destino');
    });
    $('#quitarizq').click(function() {
        borrarprivilegio();
        return !$('#destino option:selected').remove();
    });
    $('#quitarPriv').click(function() {
        return !$('#destino option:selected').remove();
    });
    $('#quitaProfUsuDel').click(function() {
        borrarprivilegio2();
        return !$('#destinoUsu option:selected').remove();
    });
    $('#quitaProfUsu').click(function() {
        return !$('#destinoUsu option:selected').remove();
    });
    $('#quitaEstabUsuDel').click(function() {
        borrarprivilegio3();
        return !$('#destinoEstabUsu option:selected').remove();
    });
    $('#quitaEstabUsu').click(function() {
        return !$('#destinoEstabUsu option:selected').remove();
    });
    $('#privHab').click(function() {

        existe = 0;
        $('#destino1 option').each(function() {
            vDestino = $(this).attr('value');
            vOrigen = $('#origen1 option:selected').val();
            if (vOrigen == vDestino) {
                existe = 1;
            }

        });
        if (existe != 1) {
            valor = $('#origen1 option:selected').val();
            rellenazan(1, valor);
            return !$('#origen1 option:selected').appendTo('#destino1');
            return !$('#origen1 option:selected').remove();
        }

    });
    $('#privDes').click(function() {
        existe = 0;
        $('#origen1 option').each(function() {
            vDestino = $(this).attr('value');
            vOrigen = $('#destino1 option:selected').val();
            if (vOrigen == vDestino) {
                existe = 1;
            }

        });
        if (existe != 1) {
            valor = $('#destino1 option:selected').val();
            rellenazan(2, valor);
            return !$('#destino1 option:selected').appendTo('#origen1');
            return !$('#destino1 option:selected').remove();
        }

    });
    $('#origen').dblclick(function() {
        varSelect = $('#destino > option').length;
        if (varSelect == 0) {
            return !$('#origen option:selected').clone().appendTo('#destino');
        } else {
            existe = 0;
            $('#destino option').each(function() {
                vDestino = $(this).attr('value');
                vOrigen = $('#origen option:selected').val();
                if (vOrigen == vDestino) {
                    existe = 1;
                }

            });
            if (existe != 1) {
                return !$('#origen option:selected').clone().appendTo('#destino');
            }
        }

    });
    $('#origenUsu').dblclick(function() {
        varSelect = $('#destinoUsu > option').length;
        if (varSelect == 0) {
            return !$('#origenUsu option:selected').clone().appendTo('#destinoUsu');
        } else {
            existe = 0;
            $('#destinoUsu option').each(function() {
                vDestino = $(this).attr('value');
                vOrigen = $('#origenUsu option:selected').val();
                if (vOrigen == vDestino) {
                    existe = 1;
                }

            });
            if (existe != 1) {
                return !$('#origenUsu option:selected').clone().appendTo('#destinoUsu');
            }

        }

    });
    $('#origenEstabUsu').dblclick(function() {
        varSelect = $('#destinoEstabUsu > option').length;
        if (varSelect == 0) {
            return !$('#origenEstabUsu option:selected').clone().appendTo('#destinoEstabUsu');
        } else {
            existe = 0;
            $('#destinoEstabUsu option').each(function() {
                vDestino = $(this).attr('value');
                vOrigen = $('#origenEstabUsu option:selected').val();
                if (vOrigen == vDestino) {
                    existe = 1;
                }

            });
            if (existe != 1) {
                return !$('#origenEstabUsu option:selected').clone().appendTo('#destinoEstabUsu');
            }
        }

    });
});

function mensaje(num) {

    if (num == 1) {
        $('#oculto').val(1);
    } else if (num == 2) {
        $('#oculto').val(2);
    } else if (num == 3) {
        $('#oculto').val(3);
    }
}


function ValidaBloqueo(num) {

    if (num == 1) {
        $("#btnEditarMenu").attr("disabled", true);
    } else if (num == 0) {
        $("#btnEditarMenu").attr("disabled", false);
    }


}

////Funcion Global para consultas Ajax

function ajax(variables, id, funcion) {

    var imagens = '<img src="assets/themes/frontend/img/loadings.gif" style="width:100%; height:4px">';
    $.ajax({
        type: "POST",
        dataType: "text",
        url: "frontend/" + funcion,
        data: variables,
        beforeSend: function() {
            //$("#carga").html(imagens);
            $("#" + id).html(imagens);
        },
        success: function(datos) {
            $("#" + id).html(datos);
        },
        timeout: 4000,
        cache: false,
        error: $("#" + id).text('Problemas en el servidor.')
    });
}




function ajaxLog(variables, id, funcion) {

    $.ajax({
        type: "POST",
        dataType: "text",
        url: "inicio/" + funcion,
        data: variables,
        beforeSend: function() {
            $("#" + id).html('<img src="assets/themes/esissan/img/cargando.gif">');
        },
        success: function(datos) {
            $("#" + id).html(datos);
        },
        timeout: 4000,
        cache: false,
        error: $("#" + id).text('Problemas en el servidor.')
    });
}

function expan() {
    $("#tabUsu_2").toggle("fast");
}

function verificaFinal_0(ius, tok) {
    var funcion = "verificaFinal";
    var id = "respuesta";
    var variables = { "ius": ius, "tok": tok }
    AjaxExt(variables, id, funcion);
}

function AjaxExtJsonAll(datos) {
    $.each(datos, function(i, item) {
        if (item.opcion == 'hide') {
            $('#' + item.id_html).hide();
        } else if (item.opcion == 'after') {
            $('#' + item.id_html).after(item.contenido);
        } else if (item.opcion == 'show') {
            $('#' + item.id_html).show();
        } else if (item.opcion == 'append') {
            $('#' + item.id_html).append(item.contenido);
        } else if (item.opcion == 'prepend') {
            $('#' + item.id_html).prepend(item.contenido);
        } else if (item.opcion == 'last') {
            $('#' + item.id_html).last(item.contenido);
        } else if (item.opcion == 'html') {
            $('#' + item.id_html).html(item.contenido);
        } else if (item.opcion == 'val') {
            $('#' + item.id_html).val(item.contenido);
        } else if (item.opcion == 'text') {
            $('#' + item.id_html).text(item.contenido);
        } else if (item.opcion == 'remove') {
            $('#' + item.id_html).remove();
        } else if (item.opcion == 'attrSelect') {
            $('#' + item.id_html + ' option[value="' + item.contenido + '"]').attr('selected', 'selected');
        } else if (item.opcion == 'jAlert') {
            jAlert(item.contenido, "SSAN - e-SISSAN");
        } else if (item.opcion == 'jConfirm') {
            jConfirm(item.contenido, 'Confirmation Dialog', function(r) {
                location.reload();
            });
        } else if (item.opcion == 'rmvSelect') {
            $("select#" + item.id_html + " option[value='" + item.contenido + "']").remove();
        } else if (item.opcion == 'console') {
            console.log(item.contenido);
        } else if (item.opcion == 'dialogClose') {
            $("#" + item.contenido).dialog('close');
        } else if (item.opcion == 'location') {
            location.reload();
        } else if (item.opcion == 'script') {
            item.contenido;
        } else if (item.opcion == 'jAlertOK') {
            jAlert(item.contenido, 'E-SISSAN', function(r) {
                location.reload();
            });
        } else if (item.opcion == 'jAlertDiagC') {
            jAlert(item.contenido, 'E-SISSAN', function(r) {
                $('#' + item.id_html).dialog('close');
            });
        } else if (item.opcion == 'swalOK') {
            swal("Se ha realizado con éxito", item.contenido, "success", function(r) {});
        } else if (item.opcion == 'modalClose') {
            $('#' + item.id_html).modal('hide');
        } else if (item.opcion == 'modalShow') {
            $('#' + item.id_html).modal('show');
        } else if (item.opcion == 'chosenUpd') {
            $('#' + item.id_html).trigger("chosen:updated").chosen({ width: "100%" });
        } else if (item.opcion == 'find_rm') {
            $('#' + item.id_html).find("option[value='" + item.contenido + "']").remove();
        } else if (item.opcion == 'jError') {
            jError(item.contenido, 'ERROR - E-SISSAN', function(r) {});
        } else if (item.opcion == 'onclick') {
            $('#' + item.id_html).attr('onClick', item.contenido);
        } else if (item.opcion == 'outonclick') {
            $('#' + item.id_html).attr('onClick', "");
        } else if (item.opcion == 'onchange') {
            document.getElementById(item.id_html).onchange();
        } else if (item.opcion == 'disabled') {
            $('#' + item.id_html).prop('disabled', false);
        } else if (item.opcion == 'swal-success') {
            swal('Realizado correctamente', "'" + item.contenido + "'", 'success');
        } else if (item.opcion == 'change_panel') {
            $('#' + item.id_html).removeClass("panel panel-default").addClass(item.contenido);
        }
    });
    return true;

}