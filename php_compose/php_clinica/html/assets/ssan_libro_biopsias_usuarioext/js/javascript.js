$(document).ready(function(){
    var todayDate = new Date().getDate();
    $('#fecha_out').datetimepicker({
        useCurrent : false,
        inline : true,
        sideBySide : true,
        format : 'DD-MM-YYYY',
        locale : 'es-us',
        maxDate : new Date(),
        defaultDate : new Date(new Date().setDate((todayDate)-(0))), 
        icons : {
            time : 'fa fa-clock-o',
            date : 'fa fa-calendar',
            up : 'fa fa-chevron-up',
            down : 'fa fa-chevron-down',
            previous : 'fa fa-chevron-left',
            next : 'fa fa-chevron-right',
            today : 'fa fa-screenshot',
            clear : 'fa fa-trash',
            close : 'fa fa-remove',
        }
    }).on('dp.change',function(e){ 
        ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(0);
    });
    $(".timepicker").remove();

    $("#MODAL_INICIO_SOLICITUD_ANATOMIA").on("show.bs.modal",function(e){ 
       
    });
    $("#MODAL_INICIO_SOLICITUD_ANATOMIA").on("hidden.bs.modal",function(e){ 
        
    });
    $("#MODAL_PDF_ANATOMIA_PATOLOGICA").on("show.bs.modal",function(e){ 
       
    });
    $("#MODAL_PDF_ANATOMIA_PATOLOGICA").on("hidden.bs.modal",function(e){ 
       
    });
    $("#MODAL_CALENDARIO_RESUMENSOLICITUDES").on("show.bs.modal",function(e){ 
        //$('.modal .modal-body').css('overflow-y','auto'); 
        //var _height = $(window).height()*0.8;
        //$('.modal .modal-body').css('max-height',_height);
    });
    $("#MODAL_CALENDARIO_RESUMENSOLICITUDES").on("hidden.bs.modal",function(e){ 
        //console.log("HTML_PDF_ANATOMIA_PATOLOGICA->",e);
        //$("#HTML_CALENDARIO_RESUMENSOLICITUDES").html("");
    });
    $("#Dv_verdocumentos").on("show.bs.modal",function(e){ 
        //$('.modal .modal-body').css('overflow-y','auto'); 
        //var _height = $(window).height()*0.8;
        //$('.modal .modal-body').css('max-height',_height);
    });
    $('#Dv_verdocumentos').on('hidden.bs.modal',function(e){ 
        $("#PDF_VERDOC").html(''); 
    });
    $("#modal_nuevo_paciente").on("hidden.bs.modal",function(e){ 
        js_deshabilitarInputs();
        $("#txt_new_run").val('');
        habilitarInputPorId('btn_nuevo_paciente');
        $("#btn_nuevo_paciente").attr("onclick","js_agregapaciente()");
        deshabilitarInputPorId('btn_confirmanuevopaciente');
        $("#btn_confirmanuevopaciente").attr("onclick","");
        ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(2);
        $("#txtNombre").val('');
        $('#txtApellidoPaterno').val('');
        $('#txtApellidoMaterno').val('');
        $('#txtFechaNacimineto').val('');
        $("#estado_civil").val('');
        $('#txtDireccion').val('');
        $('#t_celular').val('');
        $("#txtNum_dire").val('');
        $('#cboTippac').val('T');
        $("#trRutTitular").hide();
    });
});

function js_deshabilitarInputs() {
    let elements = document.querySelectorAll('.table input, .table select, .table button');
    elements.forEach(function(element) {  element.disabled = true; });
    habilitarInputPorId('txt_new_run');
    habilitarInputPorId('btn_incribe_visita');
    deshabilitarInputPorId('btn_nuevo_paciente');
    $("#btn_nuevo_paciente").attr("onclick","");
}

function js_habilitarInputs() {
    let elements = document.querySelectorAll('.table input, .table select, .table button');
    elements.forEach(function(element) {  element.disabled = false; });
    deshabilitarInputPorId('txt_new_run');
    deshabilitarInputPorId('btn_incribe_visita');
    habilitarInputPorId('btn_nuevo_paciente');
}

function deshabilitarInputPorId(id) {
    let element = document.getElementById(id);
    if (element) { element.disabled = true; }
}

function habilitarInputPorId(id) {
    let element = document.getElementById(id);
    if (element) { element.disabled = false; }
}

function js_agregapaciente(){
    let v_busq_rut = $("#busq_rut").val();
    console.log("v_busq_rut -> ",v_busq_rut);
    if (v_busq_rut != ''){  }
    $('#txt_new_run').Rut({
        format_on : 'keyup',
        on_error : function() {   
            console.log(this);
            jError("RUN. no es correcto","CLINICA LIBRE CHILE"); 
            $("#txt_new_run").css('border-color','red'); 
            $("#txt_new_run").val('');
            $("#btn_nuevo_paciente").attr("onclick","");
            $("#txt_new_run").focus();
        },
        on_success : function() { 
            $("#txt_new_run").css('border-color',''); 
            js_buscarpacientesiexiste();
            //habilitarInputPorId("btn_nuevo_paciente");
            //$("#btn_nuevo_paciente").attr("onclick","js_buscarpacientesiexiste()");
        },
    });
    js_deshabilitarInputs();
    $("#modal_nuevo_paciente").modal({backdrop:'static',keyboard:false}).modal("show");
}

function js_buscarpacientesiexiste(){
    let v_run = $("#txt_new_run").val();
    let textoSinPuntos = v_run.replace(/\./g, '');
    let arrayDividido = textoSinPuntos.split('-');
    $.ajax({ 
        type : "POST",
        url : "ssan_bdu_creareditarpaciente/busqueda_paciente_run",
        dataType : "json",
        beforeSend : function(xhr) { $('#loadFade').modal('show'); },
        data : { 'v_run' : arrayDividido[0], 'v_dv' : arrayDividido[1] },
        error : function(errro) {  
            console.log(errro);
            jAlert("Error General, Consulte Al Administrador"); 
            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
        },
        success : function(aData) {  
            console.error(" success -> ",aData);
            let arr_datos = aData.return_data.arr;
            if(aData.status){
                if (arr_datos.length>0){
                    jError("El Paciente ya existe","Clinica Libre");
                    $("#modal_nuevo_paciente").modal('hide');
                } else {
                    js_habilitarInputs();
                    habilitarInputPorId('btn_confirmanuevopaciente');
                    $("#btn_confirmanuevopaciente").attr("onclick","js_nuevopaciente()");
                }
            }
            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
        }, 
     });
}

function js_nuevopaciente(){
    var strMsg='';
    var prevision = 'V';
    var num_ficha = '0000';
        $("#txtNombre").css( "border-color","" );
    if($("#txtNombre").val()==''){
        strMsg += '\n - Nombres Vacio';
        $("#txtNombre" ).css( "border-color","red" );
    }
    $("#txtApellidoPaterno").css( "border-color","" );
    if($("#txtApellidoPaterno" ).val()==''){
        strMsg += '\n - Apellido Paterno Vacio';
        $("#txtApellidoPaterno" ).css( "border-color","red" );
    }

    $("#txtApellidoMaterno").css( "border-color","" );
    if($("#txtApellidoMaterno").val()=='') {
        strMsg += '\n - Apellido Materno Vacio';
        $("#txtApellidoMaterno" ).css( "border-color","red" );
    }

    $("#txtFechaNacimineto").css( "border-color","" );
    if($("#txtFechaNacimineto").val()=='') {
        strMsg += '\n - Fecha De Nacimiento Vacia';
        $("#txtFechaNacimineto" ).css( "border-color","red" );
    }

    $("#estado_civil").css( "border-color","" );
    if($("#estado_civil").val()=='0'){
        strMsg += '\n - Seleccione Estado Civil';
        $("#estado_civil" ).css( "border-color","red" );
    }

    $("#txtDireccion").css( "border-color","" );
    if($("#txtDireccion").val()==''){
        strMsg += '\n - Direccion Vacia';
        $("#txtDireccion" ).css( "border-color","red" );
    }

    $("#t_celular").css( "border-color","" );
    if($("#t_celular").val()=='') {
        strMsg += '\n - Describir Telefono Movil';
        $("#t_celular").css( "border-color","red");
    }

    $("#txtNum_dire").css( "border-color","" );
    if($("#txtNum_dire").val()=='') {
        strMsg += '\n - Describir Numero de Direccion';
        $("#txtNum_dire" ).css( "border-color","red");
    }

    $("#txtRuttit").css( "border-color","");
    $("#txtDvtit").css( "border-color","");
    if($("#cboTippac").val()=='D') {
    if ($("#txtRuttit" ).val()=='' || $("#txtDvtit" ).val()==''){
        strMsg += '\n - Dependiente O Carga';
            $("#txtRuttit" ).css( "border-color","red");
            $("#txtDvtit").css( "border-color","red");
        }
    }
            
    if(strMsg!= ''){
        jError(strMsg,"Error");   
        return false;
    } else {

        let txt_new_run = $("#txt_new_run").val();
        let textoSinPuntos = txt_new_run.replace(/\./g, '');
        let arrayDividido = textoSinPuntos.split('-');

        var rut_titul='';	
        var dv_titul='';
        if($("#cboTippac").val()=='D') {
            rut_titul = $("#txtRuttit").val();
            dv_titul = $("#txtDvtit").val();
        } else {
            rut_titul =  arrayDividido[0];
            dv_titul =  arrayDividido[1];
        }
       
        console.log("arrayDividido  ->  ",arrayDividido);
        $('#loadFade').modal('show'); 
        $.ajax({ 
            type : "POST",
            url : "ssan_bdu_creareditarpaciente/creanuevoPacienteSSAN",
            dataType : "json",
            data : {
                //contrasena : r,
                rut_pac : arrayDividido[0],
                rut_dv : arrayDividido[1],
                txtNombre : $("#txtNombre").val(),
                txtApellidoPaterno : $('#txtApellidoPaterno').val(),
                txtApellidoMaterno : $('#txtApellidoMaterno').val(),
                txtFechaNacimineto : $('#txtFechaNacimineto').val(),
                estado_civil : $("#estado_civil").val(),
                txtDireccion : $('#txtDireccion').val(),
                t_celular : $('#t_celular').val(),
                txtNum_dire : $("#txtNum_dire").val(),
                rdosexo : $('input:radio[name=rdosexo]:checked').val(),
                cboTippac : $('#cboTippac').val(),
                txtRuttit : rut_titul,
                dv_titul : dv_titul,
            },
            error : function(errro){  
                console.log("errro  ->",errro);
                jError("Error en la transaccion ","Clinica Libre"); 
                setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
            },
            success : function(aData){
                        //console.log("aData -> ",aData);
                        setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                        if (aData.validez){
                            $('#modal_nuevo_paciente').modal('hide');
                            jAlert('Paciente ha sido creado con éxito ',"Confirmac\u00f3on",function (r){
                                if(r){ 
                                    buscar(0,1);
                                }
                            });
                        } else {


                        }
                        /*
                        if (aData[0]['validez']){
                            
                            jAlert('Su solicitud ha sido Creada',"Confirmac\u00f3on",function (r){
                                if(r){ 
                                    busqueda_parametros(2); 
                                }
                            });
                        } else { 
                            jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
                        }
                        */
            }, 
        });
    }
}

function revisaTitular(){
    if (document.getElementById("cboTippac").value=='D'){
        $('#trRutTitular').show();
    } else {
        $('#trRutTitular').hide();
    }
}
	
function nueva_solicitud_anatomia(NUM_FICHAE,ADMISION){
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_usuarioext/new_nueva_solicitud_anatomia_ext",
        dataType : "json",
        beforeSend : function(xhr) { $("#loadFade").modal('show'); },
        data : {
            NUM_FICHAE : NUM_FICHAE,
            ADMISION : ADMISION,
        },
        error : function(errro) { 
            console.log(errro);
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
            jAlert("Error General, Consulte Al Administrador","Clinica libre"); 
        },
        success : function(aData) { 
            //console.log("aData , ",aData);
            $("#HTML_SOLICITUD_ANATOMIA").html(aData["GET_HTML"]);
            $("#PA_ID_PROCARCH").val('65');
            $("#MODAL_INICIO_SOLICITUD_ANATOMIA").modal({backdrop:'static',keyboard:false}).modal("show");
            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
        }, 
    });
}

function js_busquedapacientes(val){
    $.ajax({ 
        type : "POST",
        url : "ssan_bdu_editarficha/panel_buscador_paciente_ssan",
        dataType : "json",
        beforeSend : function(xhr) {   
            $("#loadFade").modal('show'); 
        },
        data : { opciones : val },
        error : function(errro) { 
            console.log(errro);
            jAlert("Error General, Consulte Al Administrador"); 
            $("#loadFade").modal('hide'); 
        },
        success : function(aData) { 
            $("#loadFade").modal('hide'); 
            //console.log("---------------------------------------------");
            //console.log("----------",aData["GET_HTML"],"--------------");
            //console.log("---------------------------------------------");
            $("#HTML_BUSQUEDA_PACIENTE").html(aData["GET_HTML"]);
            $("#MODAL_BUSQUEDA_PACIENTE").modal({backdrop:'static',keyboard:false}).modal("show"); 
        }, 
    });
}

function ver_calendario(val){
    //$("#MODAL_CALENDARIO_RESUMENSOLICITUDES").modal();
    /*
    console.log("VER_CALENDARIO PANEL DE SOLICITUD DE ANATOMIA PATOLOGICA");
    const socket    =   io('http://10.5.183.184:5000');
    console.log("------------>",socket);
    socket.emit('socket_pasequirugico:paseqx_new_request',{
        message     :   1,
        id          :   2
    });
    */
}

//funcion que actualiza listado de mis solicitudes anatomia patologica
function ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(value){
    var fecha = fecha_cale("fecha_out");
    var idtabs = 1;
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_usuarioext/recarga_html_listaanatomiapatologica",
        dataType : "json",
        data : {
            fecha : fecha,
            fecha_from : fecha,
            fecha_to : fecha,
            idtabs : idtabs,
            value : value
        },
        error : function(errro) {  
            $("#GESTION_PASEAPENDIENTE").modal("hide"); 
            //console.log("----------------------------------------------------");
            console.log("errro -> ",errro); 
            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
            jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
        },
        success : function(aData) {
            //console.log(aData);
            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
            $("#RETURN_DATA_5").html('').html(aData["HTML_LISTAS"].HTML_SOLICITUDEAP.NUEVAS_SOLICITUDES);
            $("#RETURN_DATA_4").html('').html(aData["HTML_LISTAS"].HTML_SOLICITUDEAP.VISTA_SOLICITUDES);
        }, 
    });
}

function change_day_anatomia(date_from,date_to){
    $.ajax({ 
        type : "POST",
        url : "ssan_spab_gestionlistaquirurgica/NUEVA_SOLICITUD_ANATOMIA3",
        dataType : "json",
        beforeSend : function(xhr) { console.log("xhr->",xhr);   },
        data : {
            date_from : date_from,
            date_to : date_to,
        },
        error : function(errro) { 
            console.log(errro);  
            jAlert(" Error General, Consulte Al Administrador"); 
        },
        success : function(aData) { 
            console.log("----------",aData,"--------------------------");
        }, 
    });
}

function local_pdf_rechazomuestra(id_anatomia){
    $("#MODAL_PDF_ANATOMIA_PATOLOGICA").modal("show");
    $.ajax({ 
        type : "POST",
        url : "ssan_spab_gestionlistaquirurgica/pdf_informerechazo_ap",
        dataType : "json",
        beforeSend : function(xhr) {   
            console.log(xhr);
            console.log("generando PDF");
            $('#HTML_PDF_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF ");
        },
        data : { id : id_anatomia, },
        error : function(errro) { 
            console.log("quisas->",errro,"-error->",errro.responseText); 
            $("#protocoloPabellon").css("z-index","1500"); 
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
            $('#HTML_PDF_ANATOMIA_PATOLOGICA').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
        },
        success : function(aData) { 
            //console.log("aData  ->",aData,"<-   ");
            if(!aData["STATUS"]){
                jError("error al cargar protocolo PDF","Clinica Libre");
                return false;
            } else {
                var base64str = aData["PDF_MODEL"];
                //decode base64 string, Eliminar espacio para compatibilidad con IE
                var binary = atob(base64str.replace(/\s/g,''));
                var len = binary.length;
                var buffer = new ArrayBuffer(len);
                var view = new Uint8Array(buffer);
                for(var i=0;i<len;i++){ view[i] = binary.charCodeAt(i); }
                //console.log("view -> ",view);
                //create the blob object with content-type "application/pdf"  
                var blob = new Blob([view],{type:"application/pdf"});
                var blobURL = URL.createObjectURL(blob);
                //console.log("BlobURL->",blobURL);
                Objpdf = document.createElement('object');
                Objpdf.setAttribute('data',blobURL);
                Objpdf.setAttribute('width','100%');
                Objpdf.setAttribute('style','height:700px;');
                Objpdf.setAttribute('title','PDF');
                //$("#Dv_verdocumentos").modal("show");
                $('#HTML_PDF_ANATOMIA_PATOLOGICA').html(Objpdf);
            }
        }, 
   });
}

function load_exel() {
    var ID_BD = 121321;
    //var link = "http://10.5.183.210/ssan_spab_gestionlistaquirurgica/load_excel?id="+ID_BD;
    window.location.href = link;
}

function js_cambio_fecha(id){
    let fecha_hora = $("#DATA_"+id).data('paciente').FECHA_TOMA_MUESTRA;
    //console.log("fecha_hora",fecha_hora);
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //Enero es 0
    let yyyy = today.getFullYear();
    let currentDate = yyyy + '-' + mm + '-' + dd;
    let _fecha_rest = restarDiasAFecha(fecha_hora,5);
    let fecha_partes = fecha_hora.split(" ");
    let solo_fecha = fecha_partes[0].split("-");
    document.getElementById("date").value = solo_fecha[2]+"-"+solo_fecha[1]+"-"+solo_fecha[0];
    document.getElementById("date").min = _fecha_rest;
    document.getElementById("date").max = currentDate;
    $("#btn_confirmar_fecha").attr('onclick','js_confirma_new_fecha('+id+')');
    $("#modal_edita_fecha").modal({backdrop:'static',keyboard:false}).modal("show"); 
}

function restarDiasAFecha(fechaStr, diasARestar) {
    const partes = fechaStr.split('-');
    const dia = parseInt(partes[0],10);
    const mes = parseInt(partes[1],10) - 1; 
    const anio = parseInt(partes[2],10);
    const fecha = new Date(anio, mes, dia);
    fecha.setDate(fecha.getDate() - diasARestar);
    const diaResultado = String(fecha.getDate()).padStart(2, '0');
    const mesResultado = String(fecha.getMonth() + 1).padStart(2, '0');
    const anioResultado = fecha.getFullYear();
    return `${anioResultado}-${mesResultado}-${diaResultado}`;
}

function js_confirma_new_fecha(id){
    //console.log("--------------");
    //console.log($("#date").val());
    if ($("#date").val() == ''){
        jError("Indique fecha valida","Clinica Libre");
        return false;
    }
    let fecha_hora          =   $("#DATA_"+id).data('paciente').FECHA_TOMA_MUESTRA;
    let arr_fecha           =   $("#date").val().split("-");
    let new_arr_fecha_hora  =   arr_fecha[2]+"-"+arr_fecha[1]+"-"+arr_fecha[0]+" "+fecha_hora.split(" ")[1];
    //console.log("new_arr_fecha  >",new_arr_fecha_hora);
    jPrompt('Con esta acci&oacute;n se proceder&aacute; editar fecha de biopsia.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if(r){
            //console.log("datasend ->  ",datasend);
            $.ajax({ 
                type : "POST",
                url : "ssan_libro_biopsias_usuarioext/get_cambio_fecha",
                dataType : "json",
                beforeSend : function(xhr) { $('#loadFade').modal('show'); },
                data : { 
                    id : id,
                    pass : r,
                    fecha : new_arr_fecha_hora
                },
                error : function(errro) { 
                    console.log(errro);  
                    console.log(errro.responseText);
                    jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                    setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                },
                success : function(aData) { 
                    setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                    console.log("retun  -> ",aData);
                    if (aData.status){
                        showNotification('top','center','El cambio de fecha de biopsia se ha realizado con &eacute;xito',2,'fa fa-check');
                        $("#modal_edita_fecha").modal('hide');
                        ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(2);
                    } else {
                        jError(aData.txt_error ,"Clinica Libre");
                    }
                }, 
            });
        } else {
            jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
        }
    });
}

function GET_PDF_ANATOMIA_PANEL(id){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_usuarioext/BLOB_PDF_ANATOMIA_PATOLOGICA",
        dataType : "json",
        beforeSend : function(xhr) {   
            //console.log(xhr);
            //console.log("generando PDF");
            $('#HTML_PDF_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF&nbsp;");
        },
        data : { id : id },
        error : function(errro) { 
            console.log("quisas->",errro,"-error->",errro.responseText); 
            $("#protocoloPabellon").css("z-index","1500"); 
            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
            $('#HTML_PDF_ANATOMIA_PATOLOGICA').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
        },
        success : function(aData) { 
            console.log(aData);
            if(!aData["STATUS"]){
                jError("error al cargar protocolo PDF","Clinica Libre");
            } else {
                var base64str = aData["PDF_MODEL"];
                //decode base64 string, Eliminar espacio para compatibilidad con IE
                var binary = atob(base64str.replace(/\s/g,''));
                var len = binary.length;
                var buffer = new ArrayBuffer(len);
                var view = new Uint8Array(buffer);
                for(var i=0;i<len;i++){ view[i] = binary.charCodeAt(i); }
                var blob = new Blob([view],{type:"application/pdf"});
                var blobURL = URL.createObjectURL(blob);
                Objpdf = document.createElement('object');
                Objpdf.setAttribute('data',blobURL);
                Objpdf.setAttribute('width','100%');
                let windowHeight = window.innerHeight;
                let adjustedHeight = windowHeight - 200;
                Objpdf.setAttribute('style', `height:${adjustedHeight}px;`);
                Objpdf.setAttribute('title','PDF');
                $("#HTML_PDF_ANATOMIA_PATOLOGICA").html(Objpdf);
                $("#MODAL_PDF_ANATOMIA_PATOLOGICA").modal({backdrop:'static',keyboard:false}).modal("show"); 
            }
            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
        }, 
    });
}

function js_pdf_microscopica(id_anatomia){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_etapaanalitica/pdf_macroscopia_parte2",
        dataType : "json",
        beforeSend :   function(xhr){ },
        data : { id : id_anatomia },
        error : function(errro) { 
            console.log("quisas->",errro,"-error->",errro.responseText); 
            $("#protocoloPabellon").css("z-index","1500"); 
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
        },
        success : function(aData) { 
            console.log("aData  ->  ",aData);
            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
            if(!aData["STATUS"]){
                jError("Error al cargar protocolo PDF","Clinica Libre");
                return false;
            } else {
                var base64str = aData["PDF_MODEL"];
                var binary = atob(base64str.replace(/\s/g,''));
                var len = binary.length;
                var buffer = new ArrayBuffer(len);
                var view = new Uint8Array(buffer);
                for(var i=0;i<len;i++){ view[i] = binary.charCodeAt(i); }
                var blob = new Blob([view],{type:"application/pdf"});
                var blobURL = URL.createObjectURL(blob);
                Objpdf = document.createElement('object');
                Objpdf.setAttribute('data',blobURL);
                Objpdf.setAttribute('width','100%');
                let windowHeight = window.innerHeight;
                let adjustedHeight = windowHeight - 200;
                Objpdf.setAttribute('style', `height:${adjustedHeight}px;`);
                Objpdf.setAttribute('title','PDF');
                $('#HTML_PDF_ANATOMIA_PATOLOGICA').html(Objpdf);
                $("#MODAL_PDF_ANATOMIA_PATOLOGICA").modal({backdrop:'static',keyboard:false}).modal("show");
            }
        }, 
   });
}







