$(document).ready(function(){
    //console.log("   ->  ");
    var todayDate = new Date().getDate();
    $('#fecha_out').datetimepicker({
        useCurrent		        :   false,
        inline			        :   true,
        sideBySide		        :   true,
        format			        :   'DD-MM-YYYY',
        locale			        :   'es-us',
        maxDate                 :   new Date(),
        defaultDate		        :   new Date(new Date().setDate((todayDate)-(0))), 
        icons			        :   {
                                        time        :   'fa fa-clock-o',
                                        date        :   'fa fa-calendar',
                                        up          :   'fa fa-chevron-up',
                                        down        :   'fa fa-chevron-down',
                                        previous    :   'fa fa-chevron-left',
                                        next        :   'fa fa-chevron-right',
                                        today       :   'fa fa-screenshot',
                                        clear       :   'fa fa-trash',
                                        close       :   'fa fa-remove',
                                    }
    }).on('dp.change',function(e){ 
        ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(0);
    });

    $(".timepicker").remove();

    $("#MODAL_INICIO_SOLICITUD_ANATOMIA").on("show.bs.modal",function(e){ 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
    });
    $("#MODAL_INICIO_SOLICITUD_ANATOMIA").on("hidden.bs.modal",function(e){ 
        console.log("HTML_SOLICITUD_ANATOMIA->",e);
        $("#HTML_SOLICITUD").html("");
    });
    $("#MODAL_PDF_ANATOMIA_PATOLOGICA").on("show.bs.modal",function(e){ 
        $('.modal .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
    });
    $("#MODAL_PDF_ANATOMIA_PATOLOGICA").on("hidden.bs.modal",function(e){ 
        console.log("HTML_PDF_ANATOMIA_PATOLOGICA->",e);
        $("#HTML_PDF_ANATOMIA_PATOLOGICA").html("");
    });
    $("#MODAL_CALENDARIO_RESUMENSOLICITUDES").on("show.bs.modal",function(e){ 
        $('.modal .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
    });
    $("#MODAL_CALENDARIO_RESUMENSOLICITUDES").on("hidden.bs.modal",function(e){ 
        console.log("HTML_PDF_ANATOMIA_PATOLOGICA->",e);
        $("#HTML_CALENDARIO_RESUMENSOLICITUDES").html("");
    });
    $("#Dv_verdocumentos").on("show.bs.modal",function(e){ 
        $('.modal .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
    });
    $('#Dv_verdocumentos').on('hidden.bs.modal',function(e){ 
        $("#PDF_VERDOC").html(''); 
    });
    //$("#li_panel_rectificacion").show();
});

function nueva_solicitud_anatomia(NUM_FICHAE,ADMISION){
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_biopsias_usuarioext/new_nueva_solicitud_anatomia_ext",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    $("#loadFade").modal('show'); 
                                                },
        data                :                   {
                                                    NUM_FICHAE  :   NUM_FICHAE,
                                                    ADMISION    :   ADMISION,
                                                },
        error		        :   function(errro) { 
                                                    console.log(errro);
                                                    $("#loadFade").modal('hide');  
                                                    jAlert("Error General, Consulte Al Administrador","Clinica libre"); 
                                                },
        success             :   function(aData) { 
                                                    console.log("   ----------------------     ");
                                                    console.log("   aData   ->  ",aData);
                                                    console.log("   ----------------------     ");
                                                    $("#loadFade").modal('hide'); 
                                                    $("#HTML_SOLICITUD_ANATOMIA").html(aData["GET_HTML"]);
                                                    $("#MODAL_INICIO_SOLICITUD_ANATOMIA").modal({backdrop:'static',keyboard:false}).modal("show"); 
                                                    $("#PA_ID_PROCARCH").val('65');
                                                }, 
    });
}

function js_busquedapacientes(val){
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_bdu_editarficha/panel_buscador_paciente_ssan",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("xhr->",xhr);   
                                                    $("#loadFade").modal('show'); 
                                                },
        data                :                   {
                                                    opciones    : val,
                                                },
        error		    :   function(errro) { 
                                                    console.log(errro);
                                                    console.log(errro.responseText);  
                                                    jAlert("Error General, Consulte Al Administrador"); 
                                                    $("#loadFade").modal('hide'); 
                                                },
        success             :   function(aData) { 
                                                    $("#loadFade").modal('hide'); 
                                                    console.log("---------------------------------------------");
                                                    console.log("----------",aData["GET_HTML"],"--------------");
                                                    console.log("---------------------------------------------");
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
    var fecha               =   fecha_cale("fecha_out");
    var idtabs              =   1; 
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_biopsias_usuarioext/recarga_html_listaanatomiapatologica",
        dataType            :   "json",
        beforeSend          :   function(xhr)       {   
                                                        $("#loadFade").modal('show');
                                                    },
        data                :                       {
                                                        fecha           :   fecha,
                                                        fecha_from      :   fecha,
                                                        fecha_to        :   fecha,
                                                        idtabs          :   idtabs,
                                                        value           :   value
                                                    },
        error		        :   function(errro)     {  
                                                        $("#GESTION_PASEAPENDIENTE").modal("hide"); 
                                                        console.log("----------------------------------------------------");
                                                        console.log("errro          -> ",errro,"                         ");  
                                                        $("#loadFade").modal('hide'); 
                                                        jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    },
        success             :   function(aData)     {
                                                        $("#loadFade").modal('hide'); 
                                                        
                                                        console.log("   -----------------------------------------------------------------------------   ");
                                                        console.log("   aData               ->  ",aData);
                                                        //console.log("   NUEVAS_SOLICITUDES  ->  ",aData["HTML_LISTAS"].HTML_SOLICITUDEAP.NUEVAS_SOLICITUDES);
                                                        //console.log("   VISTA_SOLICITUDES   ->  ",aData["HTML_LISTAS"].HTML_SOLICITUDEAP.VISTA_SOLICITUDES);
                                                        $("#RETURN_DATA_5").html('').html(aData["HTML_LISTAS"].HTML_SOLICITUDEAP.NUEVAS_SOLICITUDES);
                                                        $("#RETURN_DATA_4").html('').html(aData["HTML_LISTAS"].HTML_SOLICITUDEAP.VISTA_SOLICITUDES);
                                                    }, 
    });
}

function change_day_anatomia(date_from,date_to){
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_spab_gestionlistaquirurgica/NUEVA_SOLICITUD_ANATOMIA3",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   console.log("xhr->",xhr);   },
        data                :                   {
                                                    date_from  : date_from,
                                                    date_to    : date_to,
                                                },
        error		        :   function(errro) { 
                                                    console.log(errro);  
                                                    jAlert(" Error General, Consulte Al Administrador"); 
                                                },
        success             :   function(aData) { 
                                                    
                                                    console.log("----------",aData,"--------------------------");
                                                }, 
    });
}

function local_pdf_rechazomuestra(id_anatomia){
    $("#MODAL_PDF_ANATOMIA_PATOLOGICA").modal("show");
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_spab_gestionlistaquirurgica/pdf_informerechazo_ap",
        dataType    :   "json",
        beforeSend	:   function(xhr)           {   
                                                    console.log(xhr);
                                                    console.log("generando PDF");
                                                    $('#HTML_PDF_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF ");
                                                },
        data 		:                           { 
                                                    id  :   id_anatomia,
                                                },
        error		:   function(errro)         { 
                                                    console.log("quisas->",errro,"-error->",errro.responseText); 
                                                    $("#protocoloPabellon").css("z-index","1500"); 
                                                    jError("Error General, Consulte Al Administrador","e-SISSAN"); 
                                                    $('#HTML_PDF_ANATOMIA_PATOLOGICA').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                                },
        success		:   function(aData)         { 
                                                    console.log("-----------------------");
                                                    console.log("aData  ->",aData,"<-   ");
                                                    if(!aData["STATUS"]){
                                                        jError("error al cargar protocolo PDF","e-SISSAN");
                                                        return false;
                                                    } else {
                                                        var base64str           =   aData["PDF_MODEL"];
                                                        //decode base64 string, Eliminar espacio para compatibilidad con IE
                                                        var binary              =   atob(base64str.replace(/\s/g,''));
                                                        var len                 =   binary.length;
                                                        var buffer              =   new ArrayBuffer(len);
                                                        var view                =   new Uint8Array(buffer);
                                                        for(var i=0;i<len;i++){ view[i] = binary.charCodeAt(i); }
                                                        //console.log("view     ->  ",view);
                                                        //create the blob object with content-type "application/pdf"  
                                                        var blob                =   new Blob([view],{type:"application/pdf"});
                                                        var blobURL             =   URL.createObjectURL(blob);
                                                        //console.log("BlobURL->",blobURL);
                                                        Objpdf                  =   document.createElement('object');
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

function GET_PDF_ANATOMIA_PANEL(id){
    $("#MODAL_PDF_ANATOMIA_PATOLOGICA").modal("show");
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_spab_gestionlistaquirurgica/BLOB_PDF_ANATOMIA_PATOLOGICA",
        dataType    :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        console.log("generando PDF");
                                                        $('#HTML_PDF_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF&nbsp;");
                                                    },
        data 		:                           {  id  :   id },
        error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","e-SISSAN"); 
                                                        $('#HTML_PDF_ANATOMIA_PATOLOGICA').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                                    },
        success		:   function(aData)         { 
                                                        console.log("---------------------------------------------");
                                                        console.log(aData);
                                                        console.log(aData.DATA_RETURN.HTML_QR);
                                                        console.log("---------------------------------------------");
                                                        //$('#HTML_PDF_ANATOMIA_PATOLOGICA').html(aData.HTML_BIOPSIAS);
                                                        if(!aData["STATUS"]){
                                                            jError("error al cargar protocolo PDF","e-SISSAN");
                                                            return false;
                                                        } else {
                                                            var base64str           =   aData["PDF_MODEL"];
                                                            //decode base64 string, Eliminar espacio para compatibilidad con IE
                                                            var binary              =   atob(base64str.replace(/\s/g,''));
                                                            var len                 =   binary.length;
                                                            var buffer              =   new ArrayBuffer(len);
                                                            var view                =   new Uint8Array(buffer);
                                                            for(var i=0;i<len;i++){ view[i] = binary.charCodeAt(i); }
                                                            //console.log("view->",view);
                                                            //create the blob object with content-type : "application/pdf"  
                                                            var blob                =   new Blob([view],{type:"application/pdf"});
                                                            var blobURL             =   URL.createObjectURL(blob);
                                                            //console.log("BlobURL->",blobURL);
                                                            Objpdf                  =   document.createElement('object');
                                                            Objpdf.setAttribute('data',blobURL);
                                                            Objpdf.setAttribute('width','100%');
                                                            Objpdf.setAttribute('style','height:700px;');
                                                            Objpdf.setAttribute('title','PDF');
                                                            //$('#HTML_PDF_ANATOMIA_PATOLOGICA').html(aData.DATA_RETURN.HTML_QR);
                                                            $('#HTML_PDF_ANATOMIA_PATOLOGICA').html(Objpdf);
                                                        }
                                                    }, 
    });
}
 
function load_exel()        {
    var ID_BD               =   121321;
    var link                =   "http://10.5.183.210/ssan_spab_gestionlistaquirurgica/load_excel?id="+ID_BD;
    window.location.href    =   link;
}

function js_cambio_fecha(id){
    let fecha_hora      =   $("#DATA_"+id).data('paciente').FECHA_TOMA_MUESTRA;
    //console.log("fecha_hora",fecha_hora);
    let today           =   new Date();
    let dd              =   String(today.getDate()).padStart(2, '0');
    let mm              =   String(today.getMonth() + 1).padStart(2, '0'); //Enero es 0
    let yyyy            =   today.getFullYear();
    let currentDate     =   yyyy + '-' + mm + '-' + dd;
    let _fecha_rest     =   restarDiasAFecha(fecha_hora,5);
    let fecha_partes    =   fecha_hora.split(" ");
    let solo_fecha      =   fecha_partes[0].split("-");
    document.getElementById("date").value   =   solo_fecha[2]+"-"+solo_fecha[1]+"-"+solo_fecha[0];
    document.getElementById("date").min     =   _fecha_rest;
    document.getElementById("date").max     =   currentDate;
    
    $("#btn_confirmar_fecha").attr('onclick','js_confirma_new_fecha('+id+')');
    $("#modal_edita_fecha").modal({backdrop:'static',keyboard:false}).modal("show"); 
}

function restarDiasAFecha(fechaStr, diasARestar) {
    const partes = fechaStr.split('-');
    const dia = parseInt(partes[0],10);
    const mes = parseInt(partes[1],10) - 1; // Los meses en JavaScript estÃ¡n indexados desde 0
    const anio = parseInt(partes[2],10);
    const fecha = new Date(anio, mes, dia);
    fecha.setDate(fecha.getDate() - diasARestar);
    const diaResultado = String(fecha.getDate()).padStart(2, '0');
    const mesResultado = String(fecha.getMonth() + 1).padStart(2, '0'); // Sumamos 1 porque los meses estÃ¡n indexados desde 0
    const anioResultado = fecha.getFullYear();
    return `${anioResultado}-${mesResultado}-${diaResultado}`;
}

function js_confirma_new_fecha(id){
    console.log($("#date").val());
    if ($("#date").val() == ''){
        jError("Indique fecha valida","e-SISSAN");
        return false;
    }
    let fecha_hora  = $("#DATA_"+id).data('paciente').FECHA_TOMA_MUESTRA;
    let arr_fecha  = $("#date").val().split("-");
    let new_arr_fecha_hora = arr_fecha[2]+"-"+arr_fecha[1]+"-"+arr_fecha[0]+" "+fecha_hora.split(" ")[1];
    console.log("new_arr_fecha  >",new_arr_fecha_hora);
    jPrompt('Con esta acci&oacute;n se proceder&aacute; editar fecha de biopsia.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if(r){
            $('#loadFade').modal('show');
            //console.log("datasend ->  ",datasend);
            $.ajax({ 
                type                :   "POST",
                url                 :   "ssan_libro_biopsias_usuarioext/get_cambio_fecha",
                dataType            :   "json",
                beforeSend          :   function(xhr)   {   console.log("xhr->",xhr);   },
                data                :   { 
                                            id : id,
                                            pass : r,
                                            fecha : new_arr_fecha_hora
                                        },
                error		    :   function(errro) { 
                                                            console.log(errro);  
                                                            console.log(errro.responseText);
                                                            jAlert("Error General, Consulte Al Administrador","e-SISSAN"); 
                                                            $('#loadFade').modal('hide');
                                                        },
                success             :   function(aData) { 
                                                            $('#loadFade').modal('hide');
                                                            console.log("retun  -> ",aData);
                                                            if (aData.status){
                                                                showNotification('top','center','El cambio de fecha de biopsia se ha realizado con &eacute;xito',2,'fa fa-check');
                                                                $("#modal_edita_fecha").modal('hide');
                                                                ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(2);
                                                            } else {
                                                                jError(aData.txt_error ,"e-SISSAN");
                                                            }
                                                        }, 
            });
        } else {
            jError("Firma simple vac&iacute;a","Error - ESSISAN"); 
        }
    });
}