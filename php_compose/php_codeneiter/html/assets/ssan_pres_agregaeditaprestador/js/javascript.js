$(function() {
    CARGATIPO();
    $('#rutPac').Rut({
        on_error: function() {
            swal("Aviso", "RUN ingresado incorrecto", "info");
            limpiar();
            $('#btnSuper').hide();
        },
        on_success: function() {
            $('#btnSuper').show();
        },
        format_on: 'keyup'
    });
});

$(function() {
    $("[data-toggle='tooltip']").tooltip();
});


//BOTON ELIMINAR
function limpiar() {
    $('#rutPac').val('');
    $('#nombres').val('');
    $('#appat').val('');
    $('#apmat').val('');
    $('#tprof').val('SELECCIONE EL TIPO DE PROFESIONAL');
    $('#prof').val('SELECCIONE UNA PROFESIÓN');
    $('#email').val('');
    $('#telefono').val('');
    $("#respuesta1").hide();
}

function CARGATIPO() {
    /*
    var id = "respuesta"; //Div o ID de los resultados
    var funcion = "cargatipo"; //Funcion del Controlador a Ejecutar
    var variables = {}; //Variables pasadas por ajax a la funcion
    AjaxExt(variables, id, funcion); //Funcion que Ejecuta la llamada del ajax
    */
}


function CARGAPROF() {
    var rut = $('#rutPac').val();
    if (rut === '') {
        $('#prof').val('SELECCIONE UNA PROFESIÓN');
    } else {
        // var rut = $('#rutPac').val();//envio el 
        var tprof = $('#tprof').val();
        var id = "prof"; //Div o ID de los resultados
        var funcion = "cargaprof"; //Funcion del Controlador a Ejecutar
        var variables = { tprof: tprof }; //Variables pasadas por ajax a la funcion
        AjaxExt(variables, id, funcion); //Funcion que Ejecuta la llamada del ajax
    }
}

function buscar() {
    var rut = $('#rutPac').val();
    if (rut === '') {
        swal("Aviso", "El campo RUN se encuentra vacio", "info");
    } else {
        $('#loadFade').modal('show');
        var id = "respuesta"; //Div o ID de los resultados
        var funcion = "buscar"; //Funcion del Controlador a Ejecutar
        var variables = { 'rutPac': rut }; //Variables pasadas por ajax a la funcion
        AjaxExt(variables, id, funcion); //Funcion que Ejecuta la llamada del ajax
    }

}

function getSuper() {
    var rut = $('#rutPac').val();
    if (rut != '') {
        $('#loadFade').modal('show');
        AjaxExt({ 'rutProf': rut }, 'respSuper', 'buscaFuncSuper');
    }
}

function consultaprofxestab() {
    var rut = $('#rutPac').val();
    var codemp = $('#codemp').val();
    if (rut === '') {
        swal("Aviso", "El campo RUN se encuentra vacio", "info");
    } else {
        //$('#loadFade').modal('show');
        var id = "respuesta1"; //Div o ID de los resultados
        var funcion = "consultaprofxestab"; //Funcion del Controlador a Ejecutar
        var variables = { 'rutPac': rut, 'codemp': codemp }; //Variables pasadas por ajax a la funcion
        AjaxExt(variables, id, funcion); //Funcion que Ejecuta la llamada del ajax

    }

}

function prestador() {
    var rut = $('#rutPac').val();
    var nombres = $('#nombres').val();
    var appat = $('#appat').val();
    var apmat = $('#apmat').val();
    var tprof = $('#tprof').val();
    var prof = $('#prof').val();
    var email = $('#email').val();
    var codemp = $('#codemp').val();
    var telefono = $('#telefono').val();
    if (rut === '') {
        swal("Aviso", "EL CAMPO RUN SE ENCUENTRA VACIO", "info");
    } else
    if (nombres === '') {
        swal("Aviso", "EL CAMPO NOMBRE SE ENCUENTRA VACIO", "info");
    } else
    if (appat === '') {
        swal("Aviso", "EL CAMPO APELLIDO PATERNO SE ENCUENTRA VACIO", "info");
    } else
    if (apmat === '') {
        swal("Aviso", "EL CAMPO APELLIDO MATERNO SE ENCUENTRA VACIO", "info");
    } else
    if (tprof === 'SELECCIONE EL TIPO DE PROFESIONAL') {
        swal("Aviso", "POR FAVOR SELECCIONE EL TIPO DE PROFESIONAL", "info");
    } else
    if (prof === 'SELECCIONE UNA PROFESIÓN') {
        swal("Aviso", "POR FAVOR SELECCIONE EL PROFESIONAL", "info");
    } else
    if (email === '') {
        swal("Aviso", "EL CAMPO CORREO SE ENCUENTRA VACIO", "info");
    } else
    if (telefono === '') {
        swal("Aviso", "EL CAMPO TELEFONO SE ENCUENTRA VACIO", "info");
    } else {
        jPrompt('<B>SE GUARDARÁ LA INFORMACIÓN.</B><br /><br />&iquest;Est&aacute; SEGURO DESEA CONTINUAR?', '', 'CONFIRMACIÓN', function(r) {
            if (r) {
                var id = "respuesta"; //Div o ID de los resultados
                var funcion = "PrestadorController"; //Funcion del Controlador a Ejecutar
                var variables = {
                    clave: r,
                    rut: rut,
                    nombres: nombres,
                    appat: appat,
                    apmat: apmat,
                    codemp: codemp,
                    tprof: tprof,
                    prof: prof,
                    email: email,
                    telefono: telefono
                }; //Variables pasadas por ajax a la funcion

                AjaxExt(variables, id, funcion); //Funcion que Ejecuta la llamada del ajax

            }
        });
    }
}