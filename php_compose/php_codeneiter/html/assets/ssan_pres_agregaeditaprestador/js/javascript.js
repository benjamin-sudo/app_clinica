$(function(){
    $('#rutPac').Rut({
        on_error    :   function() {
                                        jError("RUN ingresado incorrecto","Clinica Libre");
                                        limpiar();
                                        $('#btnSuper').hide();
                                    },
        on_success  :   function()  {
                                        $('#btnSuper').show();
                                    },
        format_on: 'keyup'
    });
    $("[data-toggle='tooltip']").tooltip();
});


function buscar() {
    let rut = $('#rutPac').val();
    if (rut === '') {
        jError("RUN ingresado incorrecto","Clinica Libre");
    } else {

        /*
            $('#loadFade').modal('show');
            var id          = "respuesta"; //Div o ID de los resultados
            var funcion     = "buscar"; //Funcion del Controlador a Ejecutar
            var variables   = { 'rutPac': rut }; //Variables pasadas por ajax a la funcion
            AjaxExt(variables, id, funcion); //Funcion que Ejecuta la llamada del ajax
        */

        $.ajax({ 
            type        :	"POST",
            url         :	"Ssan_pres_agregaeditaprestador/buscar",
            beforeSend  :   function(xhr){ $('#loadFade').modal('show'); },
            dataType    :	"json",
            data        :	{ rutPac : rut },
            error       :	function(errro,error2,error3)	{ 

                                                                console.log("--------------------------------"); 
                                                                console.log(errro); 
                                                                console.log(error2);
                                                                console.log(error3);
                                                                console.log(errro.responseText); 
                                                                $('#loadFade').modal('hide');
                                                                jAlert("Error General, Consulte Al Administrador","Clinica libre"); 
                                                                
                                                            },
            success     :	function(aData)	                {	
                                                                $('#loadFade').modal('hide');
                                                                console.log("function ->",aData);
                                                               
                                                            }, 
        });
    }
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

function getSuper() {
    var rut = $('#rutPac').val();
    if (rut != '') {
        $('#loadFade').modal('show');
        AjaxExt({ 'rutProf': rut }, 'respSuper', 'buscaFuncSuper');
    }
}

function consultaprofxestab() {
    let rut     =   $('#rutPac').val();
    let codemp  =   $('#codemp').val();
    if (rut === '') {
        swal("Aviso", "El campo RUN se encuentra vacio", "info");
    } else {
        /*
            $('#loadFade').modal('show');
            var id = "respuesta1"; //Div o ID de los resultados
            var funcion = "consultaprofxestab"; //Funcion del Controlador a Ejecutar
            var variables = { 'rutPac': rut, 'codemp': codemp }; //Variables pasadas por ajax a la funcion
            AjaxExt(variables, id, funcion); //Funcion que Ejecuta la llamada del ajax
        */
        console.log("consultaprofxestab -> ");
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