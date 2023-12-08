/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {

    $('#user').Rut({
        on_error: function() {
            $('#error').html('Rut Ingresado Incorrecto');
            $("#error").show('slow').fadeOut('slow').fadeIn('slow');

        },
        on_success: function() {
            $('#error').html('');
            $("#error").hide('slow');

        },
        format_on: 'keyup'
    });

    $('#pass').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            loginAd();
        }
    });

});

function loginAd() {
    $("#error").hide('slow');
    var user = $("#user").val();
    var pass = $("#pass").val();
    var id = "error";
    var funcion = 'login';
    var variables = { "user": user, "pass": pass };
    $("#iconLog").attr('class', 'fa fa-spinner  fa-spin');
    AjaxLZx(variables, id, funcion);
}

function AjaxLZx(variables, id, funcion) {

    $.ajax({
        type: "POST",
        dataType: "text",
        url: "admin/" + funcion,
        data: variables,
        beforeSend: function() {
            //$("#" + id).html('<img src="assets/themes/esissan/img/cargando.gif">');
        },
        success: function(datos) {
            $("#" + id).html(datos);
        },
        timeout: 4000,
        cache: false,
        error: $("#" + id).text('Problemas en el servidor.')

    });

}