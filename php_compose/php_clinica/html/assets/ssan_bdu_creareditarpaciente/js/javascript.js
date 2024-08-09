$(document).ready(function(){
    $('#rut').Rut({
        on_error : function(){ jAlert('El Rut ingresado es Incorrecto. '+$("#rut").val(), 'Rut Incorrecto'); console.log($("#rut").val());  $("#rut").css('border-color','red'); $("#rut").val('') },
        on_success : function(){  $("#rut").css('border-color','red'); console.log($("#rut").val()); },
        format_on : 'keyup'
    });
    $('#txRutTit').Rut({
        on_error    :	function(){ jAlert('El Rut ingresado es Incorrecto. '+$("#txRutTit").val(),'Rut Incorrecto'); console.log($("#txRutTit").val()); $("#txRutTit").css('border-color','red');  $("#txRutTit").val('')},
        on_success  :	function(){ console.log($("#txRutTit").val()); $("#txRutTit").css('border-color',''); },
        format_on   :	'keyup'
    });
    $("input[name=tipPac]:radio").change(function(){ 
        $("#result").hide(); 
        $("#formUser").hide();   
    });
    $("#modalExtranjero").on('hidden.bs.modal',function(e){ 
        $("#HTML_PDF").html(""); 
    });
    $("#modalPaciente").on('hidden.bs.modal',function(e){ 
        $("#HTML_DIALOGO").html(""); 
        $('#Btn_bdu').attr('onClick','');
        $("#Btn_bdu").addClass("disabled");
        $('#btn_rut').attr('disabled',false);
	    $('#Btn_bdu').attr("disabled",false);
        $("#respuesta").html("");
        //$('#Btn_bdu').prop("disabled",true);
        //$('#Btn_bdu').hide();
        //$("#Btn_bdu").removeClass("btn btn-primary btn-sm");
    });
    $("#new_paginacion").on('click','li',function (){
        if(!isNaN($(this).text())){ buscar(1,$(this).text()); }
    });
    //console.log(" -------------- TEMPLETE -> "+$("#indTemplateNum").val() +" <--------------");
    //ocMen();
    $('#modal_percapita').on('show.bs.modal',function(e){
        $("#HTML_PERCAPITA").html('');
        $("#modalPaciente").css("z-index","1000"); 
        $("#modal_percapita").css("z-index","11500");
    });
    $('#modal_percapita').on('hidden.bs.modal',function(e){
        $("#modal_percapita").css("z-index","100");
        $("#modalPaciente").css("z-index","1500"); 
        $("#HTML_PERCAPITA").html('');
    });
    console.log("   ----------------------------------------    ");
    console.log(" Codeigniter 3 ");
    console.log(" bootstrap -> ", bootstrap.Tooltip.VERSION," ");
    console.log(" jQuery -> ", jQuery.fn.jquery," ");
    console.log("   ----------------------------------------    ");
    $('.dropdown-toggle').dropdown();
});

function js_test(){
    $.ajax({ 
        type : "POST",
        url : "ssan_bdu_creareditarpaciente/function_test",
        beforeSend : function(xhr){ $('#loadFade').modal('show'); },
        dataType : "json",
        data : { },
        error :	function(errro,error2,error3) { 

                                                    console.log("--------------------------------"); 
                                                    console.log(errro.responseText); 
                                                    console.log(errro); 
                                                    console.log(error2);
                                                    console.log(error3);
                                                    jAlert("Error General, Consulte Al Administrador","Clinica libre"); 
                                                    $('#loadFade').modal('hide');
                                                },
        success : function(aData)   {	
                                        console.log(aData);
                                        $('#loadFade').modal('hide');
                                    }, 
    });
}

function FormModal(isNal,numFichae){
    $('.dropdown-toggle').dropdown('hide');
    $.ajax({ 
        type        :	"POST",
        url         :	"ssan_bdu_creareditarpaciente/CreaEditaPaciente",
        dataType    :	"json",
        data        :	{ 
                            numFichae   :   numFichae,
                            isNal       :   isNal,
                            template    :   $("#indTemplateNum").val(),
                            Numedad	    :   '0',
                        },
        error      :	function(errro){  
                                            console.log(errro);
                                            $("#HTML_DIALOGO").html('');	 
                                            jError("Error General, Consulte Al Administrador"); 
                                        },
        success    :	function(aData) {    
                                            console.log("aData  ->  ",aData);
                                            $("#HTML_DIALOGO").html('');
                                            if(AjaxExtJsonAll(aData)){
                                                $("#modalPaciente").modal({backdrop:'static',keyboard:false}).modal('show');
                                            } 
                                        }, 
    });
}

function buscar(OP,LIM_INI){
    $("#rut").css("border-color","");
    $("#dni").css("border-color","");
    $("#name").css("border-color","");
    $("#resultados").html('');
    $("#apellidoP").css("border-color","");
    $("#apellidoM").css("border-color","");
    $("#resultados").append('<tr id="msj_load"><td style="text-align:center" colspan="11"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i> <span class="sr-only"></span><b>BUSCANDO...</b></td></tr>');
    if(OP==0){ $("#paginacion_bdu").html(''); }
    document.getElementById("btn_buscageneral").disabled = true;

    console.log("   ##############################  ");
    console.log("   OP ->",OP);
    console.log("   LIM_INI ->",LIM_INI);

    var rut = $("#rut").val();
    var pasaporte =	$("#dni").val();
    var nombre = $("#name").val();
    var apellidoP = $("#apellidoP").val();
    var apellidoM =	$("#apellidoM").val();
    var tipoPac = $('input:radio[name=tipPac]:checked').val();
    var tipoEx = $("#tipoEx").val();
    var numxpag = 10;
    
    if (rut!=''){
        rut = rut.replace(/\./g, '');
        rut = rut.split('-');
        rut = rut[0];
    }

    let valida = 0;

    console.error(" ##############################################");
    console.error(" nombre       ->  ",nombre);
    console.error(" apellidoP    ->  ",apellidoP);
    console.error(" apellidoM    ->  ",apellidoM);
    console.error(" ##############################################");

    if ((rut!= '' || nombre != '' || apellidoP != '' || apellidoM != '') && (tipoPac == 0)) {
        valida = 1;
    } else if ((rut != '' || pasaporte != '' || nombre != '' || apellidoP != '' || apellidoM != '') && (tipoPac == 1)){
        valida = 1;
    }
    
    if (valida == 0){
        jError("Debe ingresar a lo menos un par&aacute;metro para la b&uacute;squeda ", "Restricci\u00f3n");
        $("#rut").css("border-color","red");
        $("#dni").css("border-color","red");
        $("#name").css("border-color","red");
        $("#apellidoP").css("border-color","red");
        $("#apellidoM").css("border-color","red");
        $("#resultados").html('');
        $("#new_paginacion").hide();
        document.getElementById("btn_buscageneral").disabled = false;
    } else {
        $("#icoSe").hide();
        $("#respuesta").hide();
        $("#icoLoa").css('display','inline-block');
        $("#txBusc").html('Buscando');
        $("#resultados").html('');
        $("#new_paginacion").hide();   
        $.ajax({ 
            type : "POST",
            url : "ssan_bdu_creareditarpaciente/buscarPac",
            dataType : "json",
            data : { 
                        numFichae : '',
                        rut : rut,
                        tipoEx : tipoEx,
                        tipoPac : tipoPac,
                        pasaporte : pasaporte,
                        nombre : nombre,
                        apellidoP : apellidoP,
                        apellidoM : apellidoM,
                        LIM_INI : LIM_INI,
                        numxpag : numxpag,
                        OP : OP,
                        templete : $("#indTemplateNum").val(),
                        USERNAME : $("#USERNAME").val(),
                        COD_ESTAB : $("#COD_ESTAB").val(),
                    },
            error :	function(errro) {  
                                        console.log(errro); 
                                        $("#resultados").html(''); 
                                        document.getElementById("btn_buscageneral").disabled = false; 
                                        jAlert("Error General, Consulte Al Administrador"); 
                                    },
            success : function(aData){ 
                                        $("#resultados").html(''); 
                                        console.error("salida de busqueda ->  ",aData);
                                        document.getElementById("btn_buscageneral").disabled = false; 
                                        if(AjaxExtJsonAll(aData.json)){
                                            //console.log("dropdown-toggle");
                                            let NUM_COUNT = aData.count; 
                                            let itemsPerPage = 10;
                                            let PageN = Math.ceil(NUM_COUNT/itemsPerPage);
                                            console.log("Num :", PageN);
                                            if (PageN != 0){
                                                if (OP == 0){
                                                    $('.dropdown-toggle').dropdown();
                                                    $("#new_paginacion").bootpag({total:PageN,page:1,maxVisible:itemsPerPage});
                                                    $("#new_paginacion").show("fast");
                                                } else {
                                                    if (PageN > 0){
                                                        $("#new_paginacion").show("fast");
                                                    }
                                                }
                                            }
                                        }
                                    }, 
        });
    }
}

function nuevo_reciennacido(value){
    $.ajax({ 
        type : "POST",
        url : "ssan_bdu_creareditarpaciente/new_paciente_rn",
        dataType : "json",
        data : { },
        error :	function(errro) { 
                    console.log(errro.responseText); 
                    jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                },
        success : function(aData) {	
            console.log(aData);
            if(AjaxExtJsonAll(aData)){
                $("#MODAL_RECIEN_NACIDO").modal("show");
            } 
        }, 
    });
}

//********************************** 10.02.2020 ********************************
function ver_infopercapita(RUN){
    console.log("-------------------");
    console.log(RUN);
    $.ajax({ 
        type        :	"POST",
        url         :	"ssan_bdu_creareditarpaciente/apipercapita",
        dataType    :	"json",
        data        :	{ 
                            rutPac	:   RUN,
                        },
        error       :	function(errro)	    { 
						console.log(errro.responseText); 
						jAlert("Error General, Consulte Al Administrador","e-SISSAN"); 
					    },
        success     :	function(aData)	    {	
                            console.log("-------------");
                            console.log(aData);
                            if(AjaxExtJsonAll(aData)){
                                
                            } 
					    }, 
    });
}

function js_cambia(id,value){
    if (value == 1){
        $("#formulario_provisionales").show();
    } else {
        $("#formulario_provisionales").hide();
    }
}

function Add_Agenda(numFichae){
    
    $.ajax({ 
        type        :   "POST",
        url         :   "ssan_bdu_creareditarpaciente/CreaCOOKEE",
        dataType    :   "json",
        data        :   { numFichae : numFichae,  },
        error       :   function(errro){ console.log(errro.responseText); jAlert("Error General, Consulte Al Administrador"); },
        success     :   function(aData) { 
                                            AjaxExtJsonAll(aData); 
                                        }, 
    });
    
        //window.addEventListener('message', function(evt) { 
            window.addEventListener('message', function(evt) { 
        // IMPORTANT: Check the origin of the data! 
        if(event.origin.indexOf('http://10.5.183.123/sidra/')==0){
            //Read and elaborate the received data
            console.log(evt.data);
            //Send a response back to the main window
            window.parent.postMessage(console.log(1), '*');
        }
    });
    //window.parent.cierraVentana(numFichae);
    //window.parent.function(cierraVentana(numFichae));
}

function nuevafichalocal(){
        $("#txtFichaFisicaLocal").css('border-color','');
        $("#txtFichaFisicaLocal").val('');
    if ($('#newFichaL').is(':checked')) {
        $("#hdnNLocal").val('1');
        $("#txtFichaFisicaLocal").attr('readonly', true);
        $('#txtFichaFisicaLocal').prop('disabled', true);
    } else {
        $('#txtFichaFisicaLocal').attr('readonly', false);
        $('#txtFichaFisicaLocal').prop('disabled', false);
        $("#hdnNLocal").val('0');
    }
}

function validarFL(val){
    //Funcion para validar que ficha local no esta asignada a otro paciente
    var error       = '';
    var fLPaciente  = $('#txtFichaFisicaLocal').val();
    var nfichaE     = $('#numFichae').val();
    if(fLPaciente   == ''){
        error += "- Sr. Usuario, favor no dejar en blanco el N&#176; de Ficha\n";
        $('#txtFichaFisicaLocal').css('border-color','red');
    }
    if(error        != ''){
       jAlert('Listado de Campos Obligatorios <br>'+error,'Informacion');
    } else {
       $('#txtFichaFisicaLocal').css('border-color','');
       $.ajax({ 
            type        :   "POST",
            url         :   "ssan_bdu_creareditarpaciente/validaFichaLocal",
            dataType    :   "json",
            data        :   { 
                                val         :   val,
                                fLPaciente  :   fLPaciente,
                                nfichaE     :   nfichaE,
                                COD_ESTAB   :   $("#COD_ESTAB").val(),
                            },
            error       :   function(errro){ console.log(errro.responseText); jAlert("Error General, Consulte Al Administrador"); },
            success     :   function(aData) { 

                                                AjaxExtJsonAll(aData); 

                                            }, 
        });
    }
}

function cargaInfoFonasa(rut,dv){
    $('body').Toasts('create',{
        position    :   'bottomRight',
        imageHeight :   '130px',
        title       :   'Clinica libre',
        icon        :   'fas fa-exclamation-triangle',
        autohide    :   true,
        delay       :   3000,
        body        :   'NUEVO PACIENTE- INGRESAR INFORMACI&Oacute;N',
    });
    /*
    jConfirm("Estimado Usuario:<br>El paciente seleccionado no est&aacute; incluido en la base de SSAN &iquestDesea buscarlo los datos generales en registros de Fonasa? ", 'ESISSAN', function (r) {   
        if (r){
	    $.ajax({ 
		type        :	"POST",
		url         :	"ssan_bdu_creareditarpaciente/buscarPrevision",
		dataType    :	"json",
		data        : 
				{ 
				    msjFonasa	:    1,
				    tabFonasa   :    1,
				    cDataGen	:    1,
				    cDataPrv	:    1,
				    txtRuttit	:    rut,
				    txtDvtit	:    dv,
				},
		error       :	function(errro){    console.log(errro.responseText); jAlert("Error General, Consulte Al Administrador"); },
		success     :	function(aData){    AjaxExtJsonAll(aData); }, 
	    });
        } 
    });
    */
}

//inicio
function cargaInfoApi(rut,dv){
    jAlert("Ingreso de nuevo paciente- ingresar informaci&oacute;n minima","Clinica Libre");
    $("#txtRuttit").val(rut).prop("disabled",true);
    $("#txtDvtit").val(dv).prop("disabled",true);
    $("#txtNombretit,#txtApellidoPaternotit,#txtApellidoMaternotit").prop("disabled",true);
    $("#cboEtnia1").val('0');
    $("#cboEtnia2").val('0');
    $("#cboPais").val('CL');
    $("#cboNacionalidad").val('CL');
}

function copiarnombre(){
    let textoOriginal   =   document.getElementById('txtNombre').value;
    $("#txtNombretit").val(textoOriginal);
}

function copiaapellidopaterno(){
    let textoOriginal   =   document.getElementById('txtApellidoPaterno').value;
    $("#txtApellidoPaternotit").val(textoOriginal);
}

function copiaapellidomaterno(){
    let textoOriginal   =   document.getElementById('txtApellidoMaterno').value;
    $("#txtApellidoMaternotit").val(textoOriginal);
}

function buscaTitular(val){
    var RUTMALO = '';
    if(($("#txtRuttit").val()!=''&&$("#txtDvtit").val()!='')){
        RUTMALO = valida_rut($("#txtRuttit").val(),$("#txtDvtit").val());
        if (RUTMALO == 0){ jError("RUN Titular No valido","e-SISSAN");  return false;  }
    } else {
        jError("RUN Titular ","e-SISSAN"); return false;
    }
    $.ajax({ 
        type        :   "POST",
        url         :   "ssan_bdu_creareditarpaciente/buscarPrevision",
        beforeSend  :   function(xhr)       { 
                                                console.log("load ssan_bdu_creareditarpaciente/buscarPrevision ");
                                                $("#buscando_fonasa").show();
                                                $("#msjFonasa").hide();
                                            },
        dataType    :                       "json",
        data        : 
                                            {   
                                                txtRuttit  :    $("#txtRuttit").val(),
                                                txtDvtit   :    $("#txtDvtit").val(),
                                                msjFonasa  :    1,
                                                tabFonasa  :    1,
                                                cDataGen   :    0,
                                                cDataPrv   :    1,
                                            },
        error       : function(errro)       { 
                                                console.log(errro);
                                                console.log(errro.responseText);
                                                $("#buscando_fonasa").hide();
                                                $("#msjFonasa").hide();
                                                jAlert("Error General, Consulte Al Administrador"); 
                                            },
        success     : function(aData)       { 
                                                $("#buscando_fonasa").hide();
                                                
                                                console.log("-------------------------------------------");
                                                console.log("return fn  buscarPrevision  -> ",aData,"<- ");
                                                console.log("-------------------------------------------");
                                                
                                                if(AjaxExtJsonAll(aData.arr_out)){
                                                    if(aData.ind_load_datosXws==1){
                                                        $("#txtNombretit").val(aData.datosXws.AfiliadoNombres);
                                                        $("#txtApellidoPaternotit").val(aData.datosXws.AfiliadoApell1);
                                                        $("#txtApellidoMaternotit").val(aData.datosXws.AfiliadoApell2);
                                                        if (aData.update_prevision){
                                                            if (aData.ind_actualizo_fonasa == 1){
                                                                if (aData.pac_fallecido == 1){
                                                                    jError("Seg&uacute;n la informaci&oacute;n proporcionada por Fonasa. el paciente se encuentra fallecido ","Clinica Libre");
                                                                } else {
                                                                    jAlert("Se actualizo previsi&oacute;n del paciente","Clinica Libre");
                                                                }
                                                            }
                                                        }
                                                    }
                                                };
                                            }, 
    });
}

function editar(numFichae,isNal){
    $.ajax({ 
        type            : "POST",
        url             : "ssan_bdu_creareditarpaciente/EditaPaciente",
        dataType        : "json",
        data            : 
                            { 
                                numFichae   : numFichae,
                                isNal       : isNal,
                            },
        error           : function(errro){ console.log(errro); jAlert("Error General, Consulte Al Administrador"); },
        success         : function(aData){ console.log(aData); AjaxExtJsonAll(aData); }, 
    });
}

function js_cambiaNID(id,val){
    /*console.log(id);console.log(val);*/
    if (val == '2'){
        $("#numFonasa").show();
        $("#numExtranjero").hide();
        $("#txtMenjajefonasa").show();
    } else {
        $("#numFonasa").hide();   
        $("#numExtranjero").show();
        $("#txtMenjajefonasa").hide();
    }
    $("#txtBuscarFonasa").val('');
    $("#txtDvFoonasa").val('');
    $("#txtNumIdentiExtra").val('');
    $("#txtNumIdentiExtra").css("border-color","");
    $("#txtBuscarFonasa").css("border-color","");
    $("#txtNumIdentiExtra").css("border-color","");
}
        
function validaNumeroExtranjero(val,numfichae){
    var numExt  = $("#txtNumIdentiExtra").val();
    $("#txtNumIdentiExtra").css("border-color","");
    var id_Select       = $("#cboNumIdentifica").val();
    var RUTMALO         = '';
    var valida          = 0;
    
    if (id_Select == '2'){
        if(($("#txtBuscarFonasa").val()!=''&&$("#txtDvFoonasa").val()!='')){
            RUTMALO = valida_rut($("#txtBuscarFonasa").val(),$("#txtDvFoonasa").val());
            if(RUTMALO == 1){
                valida = 1;
            } else {
                valida = 1;
            }
        } else {
                valida=0;
        }
    } else {
        if(numfichae == null){  
            if(numExt==''){ valida = 0; } else {   valida = 1;}  
        } else { 
                valida = 1;   
        }
    }
   
    if(valida == 1){
        $.ajax({ 
            type        :   "POST",
            url         :   "ssan_bdu_creareditarpaciente/buscaPacienteExtranjero",
            dataType    :   "json",
            cache       :   false,
            data        : 
                                        { 
                                            numfichae   : numfichae,
                                            IDselect    : $("#cboNumIdentifica").val(),
                                            txtNumero   : $("#txtNumIdentiExtra").val(),
                                            NumFonasa   : $("#txtBuscarFonasa").val(),
                                            DvFonasa    : $("#txtDvFoonasa").val()
                                        },
            error       :   function(errro) { console.log(errro.responseText); jError("Error General, Consulte Al Administrador"); },
            success     :   function(aData) {  
                                                $('#cboNumIdentifica').prop("disabled",true);
                                                $('#txtNumIdentiExtra').prop("disabled",true);
                                                $('#btnNumExtranjero').addClass("disabled");
                                                $("#Btn_bdu").removeClass("disabled");
                                                if (AjaxExtJsonAll(aData)){ }; 
                                            }, 
        }); 
    } else {
        jError("Numero Identificador Vac&Iacute;o","e-SISSAN");
            $("#txtNumIdentiExtra").css("border-color","red");
            $("#txtBuscarFonasa").css("border-color","red");
            $("#txtDvFoonasa").css("border-color","red");
        return false;
    }
}

function buscaOtroSSAN(val){
    $("#cboNumIdentifica").prop("disabled",false);
    $("#txtNumIdentiExtra").prop("disabled",false);
    $("#btnNumExtranjero").removeClass("disabled");
    $("#txt_bdu").addClass("disabled");
    $("#Btn_bdu").attr('onClick',"");
}

function nif(dni) {
    var numero                  = '';
    var letr                    = '';
    var letra                   = '';
    var expresion_regular_dni   = /^\d{8}[a-zA-Z]$/;
    if(expresion_regular_dni.test(dni)== true){
        numero                  = dni.substr(0,dni.length-1);
        letr                    = dni.substr(dni.length-1,1);
        numero                  = numero % 23;
        letra                   = 'TRWAGMYFPDXBNJZSQVHLCKET';
        letra                   = letra.substring(numero,numero+1);
        if(letra!=letr.toUpperCase()){
            jError('Dni erroneo, la letra del NIF no se corresponde','e-SISSAN');
        }else{
            jError('Dni correcto','e-SISSAN');
        }
    }else{
       jError('Dni erroneo, formato no v&aacute;lido','e-SISSAN');
    }
}

function cambiaTip(tipo) {
    if (tipo == 1) {
        $('#trEx').show('fast');
        $('#dni').show('fast');
        $('#rut').hide('fast');
        $('#rut').val('');
        $('#nameType').html('Pasaporte/DNI Pa&iacute;s Origen:');
    } else {
        $('#trEx').hide('fast');
        $('#dni').hide('fast');
        $('#rut').show('fast');
        $('#dni').val('');
        $('#nameType').html('R.U.N:');
    }
}

function cambiaDoc(){
    var tipoDoc = $('#tipoEx').val();
    if(tipoDoc == 1) {
        $('#nameType').html('Pasaporte / DNI Pa&iacute;s Origen:');
        $('#dni').show('fast');
        $('#dni').val('');
        $('#rut').hide('fast');
        $('#rut').val('');
    } else {
        $('#nameType').html('ID Provisorio Fonasa:');
        $('#dni').hide('fast');
        $('#dni').val('');
        $('#rut').show('fast');
        $('#rut').val('');
    }
}


//RUT FONASA
function validExtrangero(desde,numFichae){
    $.ajax({ 
        type            : "POST",
        url             : "ssan_bdu_creareditarpaciente/validaPacienteBDU",
        dataType        : "json",
        cache           : false,
        data            : 
                            { 
                                desdeEXT    : desde,    
                                numFichae   : numFichae,
                                isNal       : 0,
                                rut         : null,
                            },
        error           : function(errro){ console.log(errro.responseText); jError("Error General, Consulte Al Administrador"); },
        success         : function(aData){  
                                            $('#txtNumIdentiExtra').prop("disabled",true).addClass("disabled");
                                            $('#btnNumExtranjero').attr('disabled', true);
                                            $("#Btn_bdu").removeClass("disabled");
                                            if (AjaxExtJsonAll(aData)){  
                                                $("#txtNombretit,#txtApellidoPaternotit,#txtApellidoMaternotit").prop("disabled",true);
                                                copiarnombre();
                                                copiaapellidopaterno();
                                                copiaapellidomaterno();
                                            }; 
                                        }, 
    });
}

function validaRutChileno(val,numfichae){
    //console.log("----------->"+numfichae);
    $('#txtBuscar').css("border-color","");
    $('#txtDv').css("border-color","");
    var valida      =	'';
    var RUTMALO     =	'';
    if((numfichae=='')||(numfichae == null)){
        if(($("#txtBuscar").val()!=''&&$("#txtDv").val()!='')){  RUTMALO = valida_rut($("#txtBuscar").val(),$("#txtDv").val());  } else {  valida=0;  }
    } else {
        valida      =	1;
    }
    if(valida == 1 || RUTMALO == 1){
        $.ajax({ 
            type        :   "POST",
            url         :   "ssan_bdu_creareditarpaciente/validaPacienteBDU",
            dataType    :   "json",
            cache       :   false,
            data        : 
                        { 
                            numFichae   :   numfichae,
                            isNal       :   val,
                            rut         :   $("#txtBuscar").val(),
                            dv          :   $("#txtDv").val(),
                            templete    :   $("#indTemplateNum").val(),
                        },
            error       : function(errro){ 
                                            console.log(errro.responseText); 
                                            jError("Error General, Consulte Al Administrador"); 
                                        },
            success     : function(aData){ 
                                            console.log(aData);
                                            
                                            $('#txtBuscar').prop("disabled",true);
                                            $('#txtDv').prop("disabled",true);
                                            
                                            $('#txtBuscar').addClass("disabled");
                                            $('#btn_rut').attr('disabled',true);
                                            $("#Btn_bdu").removeClass("disabled");

                                            if(AjaxExtJsonAll(aData)){ 
                                                $('#myTab .nav-link:first').tab('show');
                                                $("#txtNombretit,#txtApellidoPaternotit,#txtApellidoMaternotit").prop("disabled",true);
                                                copiarnombre();
                                                copiaapellidopaterno();
                                                copiaapellidomaterno();
                                            };
                                        }, 
        });
    } else {
        jError("R.U.N CON CAMPOS VAC&Iacute;OS O ERR&Oacute;NEOS","e-SISSAN");  
        $('#txtBuscar').css("border-color","red");
        $('#txtDv').css("border-color","red"); 
    }
}


function buscaCiudades(Region,select,idSelect){
    //console.log(Region);console.log(select);console.log(idSelect);
    $("#"+select).find('option').remove().end().append('<option value="" selected >SELECCIONE ... </option>').val('');
    if(Region!=''){
        $.ajax({ 
            type        : "POST",
            url         : "ssan_bdu_creareditarpaciente/cont_buscaCiudades",
            dataType    : "json",
            cache       : false,
            data        :   { 
                                Region      : Region,
                                select      : select,
                                idSelect    : idSelect, 
                            },
            error       : function(errro){ console.log(errro); jError("Error General, Consulte Al Administrador"); },
            success     : function(aData){ 
                
                /*console.log(aData);*/ 
                AjaxExtJsonAll(aData); 
            } 
        });  
    }
}

function buscaComunas(Region,select,idSelect){
    //console.log(Region);console.log(select);console.log(idSelect);
    $('#'+select).find('option').remove().end().append('<option value="" selected >SELECCIONE ... </option>').val('');
    if(Region!= ''){
        $.ajax({ 
            type        : "POST",
            url         : "ssan_bdu_creareditarpaciente/Cont_buscaComunas",
            dataType    : "json",
            cache       : false,
            data        : 
                            {   
                                Region      : Region,
                                select      : select,
                                idSelect    : idSelect,
                            },
            error       : function(errro){ console.log(errro); jError("Error General, Consulte Al Administrador"); },
            success     : function(aData){ /*console.log(aData);*/ AjaxExtJsonAll(aData); } 
        });  
    }
}

function nuevoPaciente(isNal){
    var valor =  validacionDatos(isNal);
    if(valor== true){
        alert("envia");
    } else {
        jError(valor,"e-SISSAN");
        return false;
    }
}

function nuevoExtranjero(IDselect,txtNumero){
    var valor =  validacionDatos(0);
    if(valor== true){
        enviaDatosBDU(1,0,0,IDselect,txtNumero,'','','');
    } else {
        jError(valor,"e-SISSAN");
        return false;
    }
}

function editapaciente(isNal,RN,numFichae){
    var valor   =  validacionDatos(isNal);
    if(valor    == true){
        /*
        if ($("#indTemplateNum").val() == '1'){
            enviaDatosBDU(0,isNal,RN,numFichae,'','','','');    
        } else if ( $("#indTemplateNum").val() == '2'){
            //enviaDatoFichaLocal(0,isNal,RN,numFichae,'','','','');   
            enviaDatosBDU(0,isNal,RN,numFichae,'','','','');   
        }
        */
        enviaDatosBDU(0,isNal,RN,numFichae,'','','','');   
    } else {
        jError(valor,"e-SISSAN");
        return false;
    }
}

function NuevoPacienteChileno(isNal,RN){
    var valor   =   validacionDatos(isNal);
    if(valor    ==  true){
        enviaDatosBDU(1,isNal,RN,'','','','','');
    } else {
        jError(valor,"e-SISSAN");
        return false;
    }
}

//function enviaDatoFichaLocal(isNew,isNal,RN,numFichae,IDselect,txtNumero,RutMon){ }

function enviaDatosBDU(isNew,isNal,RN,numFichae,IDselect,txtNumero,RutMon){
    
    var tienePreviExtra     = '';
    var actualizacionDatos  = {DatosGenerales:[],DatosLocales:[],DatosPrevisionales:[]}; /*,DatosExtrangero:[]*/
    var FormGenerales       = [];
    var FormLocales         = [];
    
    if($("#fromDatosGenerales").serializeArray().length != '0'){ //SI EXISTE FORMULARIO DE DATOS GENERALES
                FormGenerales   = $("#fromDatosGenerales").serializeArray();
                FormGenerales.push({name : 'txtFechaNacimineto',    value       : $("#txtFechaNacimineto").val() });

        var tienerdoprais  = $('input[name="rdoprais"]:checked').val();
                FormGenerales.push({name : 'rdoprais',              value       : tienerdoprais });

        var tienerdotrans  = $('input[name="rdotrans"]:checked').val();
                FormGenerales.push({name : 'rdotrans ',             value       : tienerdotrans });
                        
        if(isNal == '1'){   console.log("ES NACIONAL");
                FormGenerales.push({name : 'txtruttitular',         value       : $("#txtRuttit").val() });
            if (isNew == 1){
                FormGenerales.push({name : 'txtrutpac',             value       : $("#txtBuscar").val() });
                FormGenerales.push({name : 'txtdvpac',              value       : $("#txtDv").val() });
                FormGenerales.push({name : 'txt_extranjero',        value       : 0 });
                FormLocales.push({name   : 'txtrutpac',             value       : $("#txtBuscar").val() }); 
                console.log("NACIONAL - ES NUEVO");
            } else {
                console.log("NACIONAL - EDITANDO");
                FormLocales.push({name   : 'txtrutpac',             value       : $("#txtBuscar").val() }); 
            }
                tienePreviExtra         =  1;
        } else {            
                    console.log("ES EXTRANJERO");
            if(isNew == 1){ 
                    console.log("EXTRANJERO - ES NUEVO");
                var num = $("#cboNumIdentifica").val();
                if (num == 2){
                    FormGenerales.push({name : 'txtrutpac',             value       : $("#txtRuttit").val() });
                    FormGenerales.push({name : 'txtdvpac',              value       : $("#txtDvtit").val() });
                } else {
                    FormGenerales.push({name : 'txtNumIdentiExtra',     value       : $("#txtNumIdentiExtra").val() });
                }

                    FormGenerales.push({name : 'ind_extranjero',        value       : num });
                    FormGenerales.push({name : 'txt_extranjero',        value       : 1 });
            } else {
                console.log(" EXTRANJERO - ESTA EDITANDO");
                
                if(($("#txtRuttit").val()!=''&&$("#txtDvtit").val()!='')){
                    FormGenerales.push({name : 'txtrutpac',             value       : $("#txtRuttit").val() });
                    FormGenerales.push({name : 'txtdvpac',              value       : $("#txtDvtit").val() });
                    FormLocales.push({name   : 'txtrutpac',             value       : $("#txtRuttit").val() }); 
                }
              
            }
                
            var tienePreviExtra  = $('input[name="tienePreviExtra"]:checked').val();
            if (tienePreviExtra  == 1){
                    FormGenerales.push({name : 'txtrutpac',         value       : $("#txtRuttit").val() });
                    FormGenerales.push({name : 'txtdvpac',          value       : $("#txtDvtit").val() });
                    FormGenerales.push({name : 'txtruttitular',     value       : $("#txtRuttit").val() });
                      FormLocales.push({name : 'txtrutpro',         value       : $("#txtRuttit").val() }); 
            }
        }
    } else if($("#indTemplateNum").val() == '2'){ //templete 2 actualiza esos 2 datos locales
                    FormGenerales.push({name : 'txtRepLegal',       value       : $("#txtRepLegalL").val() });
                    FormGenerales.push({name : 'txtOcupacion',      value       : $("#txtOcupacionL").val() });
                        
    }
    
    if($("#Form_datos_extranjero").serializeArray().length != '0'){//SI EXISTE FORMULARIO DE DATOS EXTRANJERO
        if (isNal == 0){
            var Form_datos_extranjero   = $("#Form_datos_extranjero").serializeArray();
            if(Form_datos_extranjero.length != 0){
                //FormGenerales.push({name : 'IND_TIPOIDENTIFICA', value        : txtNumero });
                //FormGenerales.push({name : 'TIP_IDENTIFICACION', value        : IDselect });
                FormGenerales.push({name : 'txtFecvencePasport',   value        : $("#txtFecvencePasport").val() });
                FormGenerales.push({name : 'txtFecvence_fonasa',   value        : $("#txtFecvence_fonasa").val() });
            }      
        } 
    }
    
    if($("#from_datos_locales").serializeArray().length != '0'){//SI EXISTE FORMULARIO DE DATOS LOCALES
            FormLocales = FormLocales.concat($("#from_datos_locales").serializeArray());
            actualizacionDatos.DatosLocales.push({FormDatoslocales              :   FormLocales });
    } 
    
    if($("#From_datos_previsiones").serializeArray().length != '0'){//SI EXISTE FORMULARIO DE DATOS PREVISIONALES
        if(tienePreviExtra == 1){
            actualizacionDatos.DatosPrevisionales.push({From_Previsiones        : $("#From_datos_previsiones").serializeArray()});
        }
    }
    actualizacionDatos.DatosGenerales.push({Form_Datosgenerales                 : FormGenerales });
    
    //************************************************************************** 
    var rutTitul            = $("#txtRuttit").val();
    var txtBuscarFonasa     = $("#txtBuscarFonasa").val(); 
    var txtDvFoonasa        = $("#txtDvFoonasa").val(); 
    var nuevaNFicha         = 0;
    if($('#newFichaL').is(':checked')){
        nuevaNFicha         = 'NUEVA';
    } else {
        nuevaNFicha         = $("#txtFichaFisicaLocal").val();
    }
    console.log(rutTitul);
    console.log(actualizacionDatos);
    //return false;
    $('#Btn_bdu').attr("disabled",true);
    //jPrompt
    jConfirm('Con esta acci&oacute;n se proceder&aacute; a a&ntilde;adir o actualizar informaci&oacute;n paciente en BDU - Clinica libre. <br/>&iquest;Est&aacute; seguro de continuar?<br />','Confirmaci\u00F3n',function(r){
        if(r){
            
            $.ajax({ 
                type        :	"POST",
                url         :	"ssan_bdu_creareditarpaciente/guardaInformacionBDU",
                dataType    :	"json",
                cache       :	false,
                data        :                   
						    { 
                                isNew       :   isNew,
                                isNal       :   isNal,
                                RN          :   RN,
                                numFichae   :   numFichae,
                                IDselect    :   IDselect,
                                txtNumero   :   txtNumero,
                                RutMon      :   RutMon,
                                FORM        :   actualizacionDatos,
                                rutTitul    :   rutTitul,
                                contrasena  :   r,
                                Previ       :   tienePreviExtra,
                                nuevaNFicha :   nuevaNFicha,
						    },
                error       :	function(errro)	    {	
                                                        $('#Btn_bdu').attr("disabled",false); 
                                                        console.log(errro); 
                                                        console.log(errro.responseText); 
                                                        jError("Error General, Consulte Al Administrador"); 
                                                    },
                success     :	function(aData)	    {   
							/*
							console.log(aData);
							console.log(num_fichae);
							*/
                                $("#Btn_bdu").attr("disabled",false);
                                if(aData[0]['validez']){
                                    var num_fichae = aData[4]['id'];
                                    $("#modalPaciente").modal('hide');
                                    if(isNal == 1){
                                    jAlert("Se ha creado/Editado el usuario","e-SISSAN");
                                    } else {
                                    jConfirm('Se ha creado con exito, Desea Imprimir Credencial Extranjero.','e-SISSAN',function(r){  if (r){ CertificadoExtranjero(num_fichae); } else { }});
                                    }
                                } else {
                                    jError("Error Contrase&ntilde;a","eSISSAN");
                                }
						    }, 
                });
        } else {
	    $("#Btn_bdu").attr("disabled",false);
            jAlert("Se espera confirmacion para a&ntilde;adir/editar paciente","Informaci&oacute;n - SSAN - e-SISAN");
        }
    });
}

function validacionDatos(isNal){
    var strMsg              = '';
    var contador_errores    = 0;
    var aData               = $("#fromDatosGenerales").serializeArray();
    
    $("#num_ic_5").html('');
    $("#num_ic_4").html('');
    $("#num_ic_3").html('');
    $("#num_ic_2").html('');
    
    //console.log($("#fromDatosGenerales").serializeArray());
    for (var i = 0; i < aData.length; i++){
            $("#"+aData[i].name).css("border-color","");
            if (
                    aData[i].name=='ind_nivel_educacional'      || 
                    aData[i].name=='ind_poblacion_migrante'     || 
                    aData[i].name=='txtNombreSocial'            || 
                    aData[i].name=='txtPareja'                  || 
                    aData[i].name=='txtPadre'                   || 
                    aData[i].name=='txtMadre'                   || 
                    aData[i].name=='txtdire_resto'              || 
                    aData[i].name=='txtEmail'                   || 
                    aData[i].name=='txtTelefono'                ||
                    aData[i].name=='txtRepLegal'                ||
                    aData[i].name=='txtOcupacion' 
                ){
                //console.log(aData[i].name);
            } else {
                if(aData[i].value == ""){  
                    $("#"+aData[i].name).css("border-color","RED");
                    contador_errores++;
                }  else {
                    $("#"+aData[i].name).css("border-color","");
                } 
            }
    }
    
    //**************************************************************************
        $("#txtFechaNacimineto").css("border-color","");
    if($("#txtFechaNacimineto").val() == ''){
        $("#txtFechaNacimineto").css("border-color","red");
        contador_errores++;
    }
    //**************************************************************************
    
    if (contador_errores!=0){ 
        $("#num_ic_5").append(contador_errores);
        strMsg+='<li> Datos que Completar datos de  pesta&ntilde;a <b>DATOS GENERALES</b> </li>';
    }

    var contador_errores2   = 0;
    var aData               = $("#from_datos_locales").serializeArray();
    console.log("   *********************************************   ");
    console.log("   from_datos_locales -> aData  ->  ",aData);
    for (var i = 0; i < aData.length; i++){
        $("#"+aData[i].name).css("border-color","");
        if  (
                aData[i].name=='newFichaL'    || 
                aData[i].name=='txtTelefonoContacto'    || 
                aData[i].name=='txtTelefonoLocal'       ||
                aData[i].name=='txtRepLegalL'           ||
                aData[i].name=='txtOcupacionL'
            ){
            //console.log(aData[i].name);
        } else {
            if(aData[i].value == ""){  
            $("#"+aData[i].name).css("border-color","RED");
            contador_errores2++;
            }  else {
                $("#"+aData[i].name).css("border-color","");
            } 
        }
    }
    if (contador_errores2!=0){ 
        $("#num_ic_4").append(contador_errores2);
        strMsg+='<li> Datos que Completar datos de pesta&ntilde;a <b>DATOS LOCALES</b> </li>';
    }
   
    //**************************************************************************
    var PreviExtranjero = $("input[name='tienePreviExtra']:checked").val();
    //console.log(PreviExtranjero);
    
    var indTemplateNum      = $("#indTemplateNum").val();
    if (PreviExtranjero != '0'){
        var contador_errores3   = 0;
        var aData               = $("#From_datos_previsiones").serializeArray();
        for (var i = 0; i < aData.length; i++){
            $("#"+aData[i].name).css("border-color","");
            if (aData[i].name   =='sinndatos'){
                //console.log(aData[i].name);
            } else {
                if(aData[i].value == ""){  
                $("#"+aData[i].name).css("border-color","RED");
                contador_errores3++;
                } else {
                    $("#"+aData[i].name).css("border-color","");
                } 
            }
        }
        if (indTemplateNum == '1'){
            if (contador_errores3!=0){ 
                $("#num_ic_3").append(contador_errores3);
                strMsg+='<li> Datos que Completar datos de pesta&ntilde;a <b>DATOS PREVISIONALES</b> </li>';
            }     
        }
    }
    //**************************************************************************
    
    //VALIDA SOLO PARA EXTRANJEROS
    if(isNal == 0){
        var contador_errores4   = 0;
        var aData               = $("#Form_datos_extranjero").serializeArray();
        var fonasaTramite       = '';
        if($('#fonasaTramite').is(':checked')) {  fonasaTramite = '1';  } else {  fonasaTramite = '0';  }
        for (var i = 0; i < aData.length; i++){
            $("#"+aData[i].name).css("border-color","");
            if ( (aData[i].name=='txtfonasaRUT' && fonasaTramite =='1')  ||  ( aData[i].name=='txtfonasaDV' && fonasaTramite =='1' ) ){
                //console.log(aData[i].name);
            } else {
                if(aData[i].value == ""){  
                    $("#"+aData[i].name).css("border-color","red");
                contador_errores4++;
                }  else {
                    $("#"+aData[i].name).css("border-color","");
                } 
            }
        }
        if (contador_errores4!=0){ 
            $("#num_ic_2").append(contador_errores4);
            strMsg+='<li>Datos que Completar datos de pesta&ntilde;a <b>INFORMACI&Oacute;N DE EXTRANJERO</b> </li>';
        }
        
        var RUTMALO = '';
        if(($("#txtRuttit").val()!=''&&$("#txtDvtit").val()!='')){
            RUTMALO = valida_rut($("#txtRuttit").val(),$("#txtDvtit").val());
            if (RUTMALO == 0){ 
                $("#txtRuttit").css("border-color","RED");
                $("#txtDvtit").css("border-color","RED");
                strMsg+='<li>RUN Titular No valido</b> </li>';  
            }
        }
    
    }
    
    if (strMsg == ''){
        return true;
    } else {
        return strMsg;
    }
}

function valida_rut(rut,dv_rut){
    
    $("#txtDv").css("border-color","");
    $("#txtBuscar").css("border-color",""); 
    $("#txtBuscarFonasa").css("border-color","");
    $("#txtDvFoonasa").css("border-color",""); 
    
    var Numeros    = "0123456789";
    var allValid   = true;
    var allNum     = "";

    for (i=0;i<rut.length; i++) {
        var Digito = rut.charAt(i);
        for (var j = 0; j < Numeros.length; j++)
            if (Digito == Numeros.charAt(j))  break;
            if (j == Numeros.length){
                     allValid = false;
                     break;
                 }
            allNum += Digito;
    }

    if (!allValid){
        jAlert("Escriba solo digitos en el campo R.U.T.",'GESPAB - SSAN');
        $("#txtDv").css("border-color","red");
        $("#txtBuscar").css("border-color","red"); 
        return (false);
    }

    if((rut!="")&&(dv_rut=="")){
        $("#txtDv").css("border-color","red");
        $("#txtBuscar").css("border-color","red"); 
        jAlert("No ha ingresado el digito verificador",'GESPAB - SSAN');          
        return false;
    } else {
        if(dv_rut != "K" && dv_rut != "k" ){
        var numerico1 = dv_rut.search( /[^0-9]/i );
        if(numerico1!= -1){
            jAlert("El digito verificador no es valido","e-SISSAN - SSAN");      
            return false;
        }
    }
    //**************************************************************************
    var rut_aux     = rut;
    var i           = 0;
    var suma        = 0;
    var mult        = 2;
    var c           = 0;
    var modulo11    = 0;
    var largo       = rut_aux.length;

    for(i=largo-1;i>=0;i--){
        suma = suma + rut_aux.charAt(i) * mult;
        mult++;
        if(mult > 7){mult = 2;}
    }

           modulo11 = 11 - suma % 11;
        if(modulo11 == 10) { modulo11 = "K"; }
        if(modulo11 == 11 ){ modulo11 = "0"; }
        if(modulo11!=dv_rut.toUpperCase()) {
            jAlert('Rut Invalido',"Error e-SISSAN");
            $("#txtDv").css("border-color","red");
            $("#txtBuscar").css("border-color","red"); 
            
            $("#txtBuscarFonasa").css("border-color","red");
            $("#txtDvFoonasa").css("border-color","red"); 
            return 0;  
        } else { 
            return 1;   
        }
    }
}

function limpiar(){
    $("#rut").css("border-color","");
    $("#dni").css("border-color","");
    $("#name").css("border-color","");
    $("#apellidoP").css("border-color","");
    $("#apellidoM").css("border-color","");
    $("#rut").val('');
    $("#dni").val('');
    $("#name").val('');
    $("#apellidoP").val('');
    $("#apellidoM").val('');
    $("#tipoEx").val('1');
    $("#resultados").html('');
    $("#result").hide('fast');
}

function CertificadoExtranjero(numfichae){
    var html='<iframe src="pabellon_classpdf/certificadoExtranjero?numFichae='+numfichae+'" frameborder="0" style="overflow:hidden;height: 650px;width:100%;" width="100%"></iframe>';
    $("#HTML_PDF").html(html);
    $("#modalExtranjero").modal("show"); 
}

function editor_extranjero(numfichae){
    $.ajax({ 
        type        : "POST",
        url         : "ssan_bdu_creareditarpaciente/editaextranjero",
        dataType    : "json",
        cache       : false,
        data        :   { 
                            numfichae   :   numfichae,
                        },
        error       : function(errro){ console.log(errro); jError("Error General, Consulte Al Administrador"); },
        success     : function(aData){ /*console.log(aData);*/ AjaxExtJsonAll(aData); } 
    }); 
        
    $("#modalExtranjero").modal("show"); 
}

function agregar_rut_ext(numfichae){
    var rut = $("#new_busq_rut").val();
    var dv = rut.split('-')[1];
    if (rut!=''){
        rut = rut.replace(/\./g, '');
        rut = rut.split('-');
        rut =	 [0];
        //dv = $("#new_busq_rut").val().split('-')[1];
    } else {
        jAlert("RUN Vacio","e-SISSAN ");
        return false;
    }
    //console.log("rut->",rut);
    //console.log("dv->",dv);
    jPrompt('Con esta acci&oacute;n se proceder&aacute; a a&ntilde;adir o actualizar informaci&oacute;n paciente en BDU SSAN. <br/>&iquest;Est&aacute; seguro de continuar?<br />','','Confirmaci\u00F3n',function(r){
        if(r){
            $.ajax({ 
                type : "POST",
                url : "ssan_bdu_creareditarpaciente/get_editaextranjero",
                dataType : "json",
                cache : false,
                data :  { 
                            numfichae : numfichae,
                            rut : rut,
                            dv : dv,
                        },
                error :	function(errro) { $('#Btn_bdu').attr("disabled",false); console.log(errro); console.log(errro.responseText); jError("Error General, Consulte Al Administrador"); },
                success : function(aData) {   
                            console.log(aData);
                            //console.log(num_fichae);
                            jAlert("Se ha creado/Editado el usuario","e-SISSAN");
                            $("#modalExtranjero").modal("hide");
                            buscar(0,1);
                }, 
            });
        } else {
	    //$("#Btn_bdu").attr("disabled",false);
            jAlert("Se espera confirmacion para a&ntilde;adir/editar paciente","Informaci&oacute;n - SSAN - e-SISAN");
        }
    });
}



