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
    $("#rutPac").focus();
});

function buscar_prestador(){
    //limpiar();
    let rut = $('#rutPac').val();
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
                                                                
                                                                console.log("--------------------------------");
                                                                console.log("function -> ",aData);

                                                                if (aData.status){
                                                                   
                                                                    let data_prestador = aData.arr.prestador[0];
                                                                    
                                                                    $("#nombres").val(data_prestador.NOM_NOMBRE);
                                                                    $("#appat").val(data_prestador.NOM_APEPAT);
                                                                    $("#apmat").val(data_prestador.NOM_APEMAT);
                                                                    $("#email").val(data_prestador.EMAILMED);
                                                                    $("#telefono").val(data_prestador.NUM_TELEFOMED);
                                                                    $("#tprof").val(data_prestador.IND_TIPOATENCION);

                                                                    CARGAPROF(data_prestador.COD_TPROFE);
                                                                    
                                                                    setTimeout(() => {
                                                                        console.log("Retrasado por 1 segundo ->",data_prestador.COD_TPROFE);
                                                                        $("#prof").val(data_prestador.COD_TPROFE);
                                                                    },"1000");

                                                                } else {
                                                                    showNotification('top','center','<i class="fa fa-check" aria-hidden="true"></i> Resgistro nuevo profesional',2,'');
                                                                }
                                                                $('#loadFade').modal('hide');
                                                            }, 
        });
    }
}

function CARGAPROF(_value){
    let rut             =   $('#rutPac').val();

    console.log("_value ->",_value);


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
                                                                $('#loadFade').modal('hide');
                                                            }, 
            complete    :   function()                      {
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

        jConfirm('Con esta acci&oacute;n se proceder&aacute; a a&ntilde;adir profesional a su establecimiento - Clinica libre. <br/>&iquest;Est&aacute; seguro de continuar?<br />','Confirmaci\u00F3n',function(r){
            if (r) {
                let textoSinPuntos  =   rut.replace(/\./g, '');
                let arrayDividido   =   textoSinPuntos.split('-');
                const variables     =   {
                                            clave       :   r,
                                            rut         :   rut,
                                            v_run       :   arrayDividido[0],
                                            v_dv        :   arrayDividido[1],
                                            nombres     :   nombres,
                                            appat       :   appat,
                                            apmat       :   apmat,
                                            codemp      :   codemp,
                                            tprof       :   tprof,
                                            prof        :   prof,
                                            email       :   email,
                                            telefono    :   telefono
                                        }; 

                console.log("----------------------------------------------");                        
                console.log("variables  ->  ",variables);
                console.log("----------------------------------------------");                        
                
                $.ajax({ 
                    type        :	"POST",
                    url         :	"Ssan_pres_agregaeditaprestador/PrestadorController",
                    beforeSend  :   function(xhr){ $('#loadFade').modal('show'); },
                    dataType    :	"json",
                    data        :	{ 
                                        clave       :   r,
                                        rut         :   rut,
                                        v_run       :   arrayDividido[0],
                                        v_dv        :   arrayDividido[1],
                                        nombres     :   nombres,
                                        appat       :   appat,
                                        apmat       :   apmat,
                                        codemp      :   codemp,
                                        tprof       :   tprof,
                                        prof        :   prof,
                                        email       :   email,
                                        telefono    :   telefono
                                    },
                    error       :	function(errro,error2,error3)	{ 
                                                                        console.log("--------------------------------"); 
                                                                        console.log(errro); 
                                                                        console.log(error2);
                                                                        console.log(error3);
                                                                        console.log("--------------------------------");
                                                                        jAlert("Error General, Consulte Al Administrador","Clinica libre"); 
                                                                    },
                    success     :	function(aData)	    {	
                                                            console.log("success aData ->",aData);
                                                            if (aData.status){
                                                                showNotification('top','center','<i class="fa fa-check" aria-hidden="true"></i> Profesional granado exitosamente. ',2,'');
                                                                limpiar();
                                                            }
                                                        }, 
                    complete    :   function()          {
                                                            $('#loadFade').modal('hide');
                                                        }                                                
                });
            }
        });
    }
}