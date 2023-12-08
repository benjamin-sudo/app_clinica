/*
 To change this license header, choose License Headers in Project Properties.
 To change this template file, choose Tools | Templates
 and open the template in the editor.
 */
/* 
 Created on : 09-feb-2016, 11:27:02
 Author     : nicolas.villagra
 */


$(function () {
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
});

//detecta version movil
var device = navigator.userAgent

if (device.match(/Iphone/i) || device.match(/Ipod/i) || device.match(/Android/i) || device.match(/J2ME/i) || device.match(/BlackBerry/i) || device.match(/iPhone|iPad|iPod/i) || device.match(/Opera Mini/i) || device.match(/IEMobile/i) || device.match(/Mobile/i) || device.match(/Windows Phone/i) || device.match(/windows mobile/i) || device.match(/windows ce/i) || device.match(/webOS/i) || device.match(/palm/i) || device.match(/bada/i) || device.match(/series60/i) || device.match(/nokia/i) || device.match(/symbian/i) || device.match(/HTC/i))
{
    window.location = "movil";

} else
{

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



        $('[class^=item]').each(function () {
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

        $("#icoOcl").attr('class', 'icon-double-angle-left icon-large');


        $('[class^=item]').each(function () {
            var idElement = $(this).attr('class');

            $("." + idElement).show('fast');
        });

    }

}

function cron() {
    var variables = {"funcion": 0};
    var id = "stat";

    ajaxCR(variables, id);
    $('.stat').css('display', '');
}


function ajaxCR(variables, id) {

    timeclose(); //Actualiza timer cierre de Sesion

    var grl = 'carga';
    var imagens = '<img src="ext/ImprimirFichaClinica/img/loadings.gif">';

    var url = 'cron.php';

    $.ajax({
        async: true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url: url,
        data: variables,
        beforeSend: function () {
            $("#" + id).html('');
            $("#" + grl).html(imagens);
        },
        success: function (datos) {
            $("#" + id).html(datos);
            $("#" + grl).html('');
        },
        timeout: 4000,
        error: $("#" + id).text('Problemas en el servidor.')
    });
    return false;
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


$(document).ready(function () {
    //load();
    jQuery.browser = {};
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }



});

function IsNumDigVer(e)//SOLO numeros y letra k
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

    if (error == 0) {
        var id = "test2";
        var funcion = 'login';
        var variables = {"user": user, "pass": pass}
        ajax(variables, id, funcion);
    } else {
        jAlert(errores, "Listado de errores");
    }
}

function sesiones() {
    
    var funcion = 'arraymenu';
    var id = "ocultosesion";
    var establecimiento = $("#listarestab option:selected").val();
    establecimiento = establecimiento.split('#');
    var variables = {"establecimiento": establecimiento[0], "tipoEstabl": establecimiento[1]}
    ajax(variables, id, funcion);
}

function abrirVentanaCambioClave(){
	$('#idResetearClave').dialog('open');
}

function getGET()
{
    // capturamos la url
    var loc = document.location.href;
    // si existe el interrogante
    if (loc.indexOf('?') > 0)
    {
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

function obtGet()
{
    // Cogemos los valores pasados por get
    var valores = getGET();
    if (valores)
    {
        var i = 0;
        var id = {};
        // hacemos un bucle para pasar por cada indice del array de valores
        for (var index in valores)
        {
            id[i] = valores[index];
            i++;
        }
    }

    return id;
}

function load() {

    var ids = obtGet();
    if (ids) {
        var idSel = ids[0];
    } else {
        var idSel = '';
    }
    var variables = {"funcion": 2, "idSel": idSel}
    var id = "formMenu";
    ajax(variables, id);
}
;


function resetearClaves() {
    var correo = $("#txtEmail").val();
    
    var funcion = "resetearClaves";
    var variables = {"correo": correo}
    var id = "m1";
    ajax(variables, id, funcion);
    $("#m4").show(500);
}
function btnenviar() {
    var id = "tablaResp";
    var variables = {"funcion": 2}
    //ajax(variables,id);

}
;
function logout() {
    window.location = "logout.php";
}
function guardacontra() {

    var txtPassNueva = $("#txtPassNueva").val();
    var txtRePassNueva = $("#txtRePassNueva").val();

    if ($('#txtPassNueva').val() != $('#txtRePassNueva').val())
    {
        $("#mensaje2").html('Contraseñas no coinciden.');
        $("#TDtxtRePassNueva").attr("style", "background-color:#FA5858;");
    } else
    {


        var variables = {"funcion": 6, "txtPassNueva": txtPassNueva, "txtRePassNueva": txtRePassNueva}
        var id = "guardaUsu";
        ajax(variables, id);

    }
}
function rellenadatos() {
    var variables = {"funcion": 4}
    var id = "datosusu";
    ajax(variables, id);
}
function enter(valor) {
    if (valor == 'enterreseteapw') {
        $(window).keypress(function (e) {
            if (e.keyCode == 13) {
                resetearClaves();
            }
        });
    } else if (valor == 'enternewpass') {
        $(window).keypress(function (e) {
            if (e.keyCode == 13) {
                CambioPassEmail();
            }
        });
    } else if (valor == 'enterlogin') {
        $(window).keypress(function (e) {
            if (e.keyCode == 13) {
                login();
            }
        });
    }
}
function CambioPass() {

    var txtPassNueva = $("#txtPassNueva1").val();
    var txtRePassNueva = $("#txtRePassNueva1").val();
    if (txtPassNueva == '' || txtRePassNueva == '') {
        jAlert("La Contraseña no puede estar vacia", "Error");
    } else {
        var id = "guardaUsuu";
        var variables = {"funcion": 7, "txtPassNueva": txtPassNueva, "txtRePassNueva": txtRePassNueva}
        ajax(variables, id);
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
            var variables = {"funcion": 10, "txtPassNueva": txtPassNueva, "txtRePassNueva": txtRePassNueva}
            ajax(variables, id);
        }
    }
}

function guardausu() {
    if ($('#txtRut').val() === '' || $('#txtRutDig').val() === '' || $('#txtNombresUsu').val() === '' || $('#txtApellidoP').val() === '' || $('#txtApellidoM').val() === '' || $('#txtCorreo').val() === '' || $('#txtFono').val() === '' || $('#txtPassNueva').val() === '' || $('#txtRePassNueva').val() === '') {
        alert('Rellene campos vacios');

    } else {


        var rut = $("#txtRut").val();
        var txtRutDig = $("#txtRutDig").val();
        var nombres = $("#txtNombresUsu").val();
        var FirstName = $("#txtNombresUsu").val();
        FirstName = FirstName.split(" ");
        FirstName = FirstName[0];
        var apellidoP = $("#txtApellidoP").val();
        var apellidoM = $("#txtApellidoM").val();
        var correo = $("#txtCorreo").val();
        var celular = $("#txtFono").val();


        var variables = {"funcion": 5, "rut": rut, "txtRutDig": txtRutDig, "nombres": nombres, "FirstName": FirstName, "apellidoP": apellidoP, "apellidoM": apellidoM, "correo": correo, "celular": celular}
        var id = "guardaUsu";
        ajax(variables, id);
    }
}

function validaTxt(e, Num) { // rut usu-
    tecla = (document.all) ? e.keyCode : e.which;

    if (Num == 1)//rut usuario solonume
    {
        patron = /[0-9]/; //patron
    } else if (Num == 1.1)//DIGITO DEL RUT
    {
        patron = /[0-9]/; //patron
        if (tecla == 75)
            return true; //K
        if (tecla == 107)
            return true; //k 
    } else if (Num == 2)//txtnombre usu
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
    } else if (Num == 2.1)
    {
        patron = /[a-zA-Z]/; //patron
        if (tecla == 64)
            return true; //@
        if (tecla == 46)
            return true; //.
    } else if (Num == 6)
    {
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
    } else if (Num == 3)//txtpriv
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
    } else if (Num == 4)
    {
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

    } else if (Num == 7)
    {
        patron = /[]/; //patron
        if (e.ctrlKey && tecla == 127) {
            return false;
        } //Ctrl x	
    }

    te = String.fromCharCode(tecla);
    return patron.test(te); // prueba de patron

}
function ValPassIguales() {
    if ($('#txtPassNueva').val() != $('#txtRePassNueva').val())
    {
        $("#mensaje2").html('Contraseñas no coinciden.');
        $("#TDtxtRePassNueva").attr("style", "background-color:#FA5858;");
    } else
    {
        $("#mensaje2").html('');
        $("#TDtxtRePassNueva").attr("style", "none");
    }
}
function mostrarpagina(idmenu, idm) {

    window.location = "index2.php?id=" + idmenu + "&ref=" + idm;

//    var variables={"funcion": 8, "idmenu":idmenu}
//		var id="muestrapagina";
//		ajax(variables,id);
}
function LimpiarUsu(num) {

    if (num == 1) {
        $("#txtPassNueva1").val('');
        $("#txtRePassNueva1").val('');
    }
}
function idactualizar(id2) {
    var variables = {"funcion": 11, "id2": id2}
    var id = "";
    ajax(variables, id);
}
function idactualizar1(id1) {
    var variables = {"funcion": 12, "id1": id1}
    var id = "";
    ajax(variables, id);
}

function firmasimple() {

    $('#firmsimple').dialog('open');

    var variables = {"funcion": 13}
    var id = "firmsimple";
    ajax(variables, id);
}

function salirpopupfirmasimple() {
    $('#firmsimple').dialog('close');
}

function CambioFirma() {
    var error = 0;
    var errores = '';

    var firma1 = $('#txtPassFirmaS1').val();
    var firma2 = $('#txtPassFirmaS2').val();

    if (firma1 == '') {
        error = 1;
        errores = '- La firma simple no puede estar vacia\n';
    }

    if (firma2 == '') {
        error = 1;
        errores = '- La firma simple no puede estar vacia\n';
    }

    if (error == 0) {
        var variables = {"funcion": 14, "firma1": firma1, "firma2": firma2}
        var id = "mensaje2";
        ajax(variables, id);

    } else {
        jAlert(errores, "Listado de Errores");
    }
}

function ValPassFirmaIguales() {
    if ($('#txtPassFirmaS1').val() != $('#txtPassFirmaS2').val())
    {
        $("#mensaje2").html('Contraseñas no coinciden.');
        $("#TDtxtRePassNueva").attr("style", "background-color:#FA5858;");
    } else
    {
        $("#mensaje2").html('');
        $("#TDtxtRePassNueva").attr("style", "none");
    }
}

function firmasimplexemail() {

    var variables = {"funcion": 15}
    var id = "mensaje2";
    ajax(variables, id);
}

function confirmafirmasimple() {

    var variables = {"funcion": 16}
    var id = "mensaje2";
    ajax(variables, id);
}

function firmasimplexemail2(idusu, token) {

    var variables = {"funcion": 17, "idusu": idusu, "token": token}
    var id = "muestrapagina";
    ajax(variables, id);
}

////Funcion Global para consultas Ajax

function ajax(variables, id, funcion) {
    $.ajax({
        type: "POST",
        dataType: "text",
        url: "inicio/" + funcion,
        data: variables,
        beforeSend: function () {
            $("#" + id).html('<img src="assets/themes/esissan/img/cargando.gif">');
        },
        success: function (datos) {
            $("#" + id).html(datos);
        },
        timeout: 4000,
        cache: false,
        error: $("#" + id).text('Problemas en el servidor.')
    });
}































