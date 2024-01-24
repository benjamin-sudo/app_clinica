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
        format_on   :   'keyup'
    });
    $("[data-toggle='tooltip']").tooltip();
    //test
    //showNotification('top','center','<i class="fa fa-check" aria-hidden="true"></i> Conexi&oacute;n con instancia no iniciada ',2,'');
});

function buscar() {
    let rut = $('#rutPac').val();
    limpiar();
    if (rut === '') {
        jError("RUN ingresado incorrecto","Clinica Libre");
    } else {
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
                                                                console.log("function ->",aData);
                                                                $('#loadFade').modal('hide');
                                                                if (aData.status){

                                                                } else {
                                                                    showNotification('top','center','<i class="fa fa-check" aria-hidden="true"></i> Resgistro nuevo profesional',2,'');
                                                                }
                                                            }, 
        });
    }
}

function CARGAPROF() {
    let rut     =   $('#rutPac').val();
    if (rut === '') {
        $('#prof').val('SELECCIONE UNA PROFESI&Oacute;N');
    } else {
        let tprof       =   $('#tprof').val();
        document.getElementById('prof').innerHTML = '';
        $.ajax({ 
            type        :	"POST",
            url         :	"Ssan_pres_agregaeditaprestador/cargaprof",
            beforeSend  :   function(xhr){ $('#loadFade').modal('show'); },
            dataType    :	"json",
            data        :	{ tprof : tprof },
            error       :	function(errro,error2,error3)	{ 
                                                                console.log("--------------------------------"); 
                                                                console.log(errro); 
                                                                console.log(error2);
                                                                console.log(error3);
                                                                jAlert("Error General, Consulte Al Administrador","Clinica libre"); 
                                                            },
            success     :	function(aData)	                {	
                                                                //console.log("out -> carggaprof ->",aData);
                                                                let arr_return = aData.arr_return;
                                                                if (arr_return.length>0){
                                                                    var select = document.getElementById('prof');
                                                                    arr_return.forEach(function(item){
                                                                        var option          =   document.createElement('option');
                                                                        option.value        =   item.COD_TPROFE; // Establecer el valor del option
                                                                        option.textContent  =   item.NOM_TPROFE; // Establecer el texto del option
                                                                        select.appendChild(option);
                                                                    });
                                                                } 
                                                            }, 
            complete    :   function()                      {
                                                                // Código que se ejecuta después de success/error
                                                                $('#loadFade').modal('hide');
                                                            }                                                
        });
    }
}


//BOTON ELIMINAR
function limpiar() {
    $('#rutPac').val('');
    $('#nombres').val('');
    $('#appat').val('');
    $('#apmat').val('');
    $('#tprof').val('SELECCIONE EL TIPO DE PROFESIONAL');
    $('#email').val('');
    $('#telefono').val('');
    $("#respuesta1").hide();
    document.getElementById('prof').innerHTML = '';
}

function getSuper() {
    var rut = $('#rutPac').val();
    if (rut != '') {
        //$('#loadFade').modal('show');
        //AjaxExt({ 'rutProf': rut }, 'respSuper', 'buscaFuncSuper');
    }
}

function consultaprofxestab() {
    let rut     =   $('#rutPac').val();
    let codemp  =   $('#codemp').val();
    if (rut === '') {
        jError("El campo RUN se encuentra vac&iacute;o","Clinica Libre");
    } else {
        /*
            $('#loadFade').modal('show');
            var id          =   "respuesta1"; //Div o ID de los resultados
            var funcion     =   "consultaprofxestab"; //Funcion del Controlador a Ejecutar
            var variables   =   { 'rutPac': rut, 'codemp': codemp }; //Variables pasadas por ajax a la funcion
            AjaxExt(variables,id,funcion); //Funcion que Ejecuta la llamada del ajax
        */
        console.log("consultaprofxestab -> ");
    }
}

function prestador() {
    var rut         =   $('#rutPac').val();
    var nombres     =   $('#nombres').val();
    var appat       =   $('#appat').val();
    var apmat       =   $('#apmat').val();
    var tprof       =   $('#tprof').val();
    var prof        =   $('#prof').val();
    var email       =   $('#email').val();
    var codemp      =   $('#codemp').val();
    var telefono    =   $('#telefono').val();
    if (rut === '') {
        jError("EL CAMPO RUN SE ENCUENTRA VAC&Iacute;O","Clinica Libre");
    } else
    if (nombres === '') {
        jError("EL CAMPO NOMBRE SE ENCUENTRA VAC&Iacute;O","Clinica Libre");
    } else
    if (appat === '') {
        jError("EL CAMPO APELLIDO PATERNO SE ENCUENTRA VAC&Iacute;O","Clinica Libre");
    } else
    if (apmat === '') {
        jError("EL CAMPO APELLIDO MATERNO SE ENCUENTRA VAC&Iacute;O","Clinica Libre");
    } else
    if (tprof === 'SELECCIONE EL TIPO DE PROFESIONAL') {
        jError("POR FAVOR SELECCIONE EL TIPO DE PROFESIONAL","Clinica Libre");
    } else
    if (prof === 'SELECCIONE UNA PROFESIÓN') {
        jError("POR FAVOR SELECCIONE EL PROFESIONAL","Clinica Libre");
    } else
    if (email === '') {
        jError("EL CAMPO CORREO SE ENCUENTRA VAC&Iacute;O","Clinica Libre");
    } else
    if (telefono === '') {
        jError("EL CAMPO TELEFONO SE ENCUENTRA VAC&Iacute;O","Clinica Libre");
    } else {
        jPrompt('<b>SE GUARDAR&Aacute; LA INFORMACI&Oacute;N.</b> <br /><br />&iquest;Est&aacute; SEGURO DESEA CONTINUAR?', '', 'CONFIRMACIÓN', function(r) {
            if (r) {
                var id              =   "respuesta"; //Div o ID de los resultados
                var funcion         =   "PrestadorController"; //Funcion del Controlador a Ejecutar
                const variables     =   {
                                            clave       :   r,
                                            rut         :   rut,
                                            nombres     :   nombres,
                                            appat       :   appat,
                                            apmat       :   apmat,
                                            codemp      :   codemp,
                                            tprof       :   tprof,
                                            prof        :   prof,
                                            email       :   email,
                                            telefono    :   telefono
                                        }; 

                console.log("variables  ->  ",variables);
                

                //AjaxExt(variables, id, funcion); //Funcion que Ejecuta la llamada del ajax



            }
        });
    }
}