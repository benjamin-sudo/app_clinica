$(function(){
    $('#modal_notificacion_cancer').on('hidden.bs.modal',function(e){ 
        $("#btn_envia_correo").attr('onclick','');
        $("#html_notificacion_cancer").html(''); 
    });
    $('#modal_edicion_numero_biopsia').on('hidden.bs.modal',function(e){ 
        $("#btn_confirma_edicion_biopsia").attr('onclick','');
        $("#html_edicion_numero_biopsia").html(''); 
    });
    $('#modal_listado_notificado').on('show.bs.modal',function(e){ });
    $('#modal_listado_notificado').on('hidden.bs.modal',function(e){ 
        $("#html_edicion_numero_biopsia").html(''); 
    });
    $('#modal_pdf_notificacion_cancer').on('hidden.bs.modal',function(e){ 
        $("#html_pdf_notificacion_cancer").html(''); 
    });
    if(localStorage.getItem("storage_busqueda_por_n_biosia_cancer")===null){
        document.getElementById("busqueda_por_paciente").checked                =   true;
    }  else  {
        document.getElementById("busqueda_por_paciente").checked                =   true;
    }
    localStorage.removeItem('storange_ids_anatomia');
    star_automplete(1,$("#ind_pagina").val());
});


function star_automplete(ind_value,_name_template){
    var _value = ind_value;
    var opciones = {
        adjustWidth         :   false,
        url                 :   function(phrase){
                                    var ind_ruta = _name_template == "notificacancer"?
                                        "ssan_libro_notificacancer/get_busqueda_solicitudes_ap_cancer":
                                        "ssan_libro_notificacancer/get_busqueda_solicitudes_ap_edicion";
                                    console.log("-----------------------------------------------");
                                    console.log("phrase ->  ",phrase," | ind_ruta ->",ind_ruta);
                                    return  phrase!=="" ?  ind_ruta :   ind_ruta;
                                },
        preparePostData     :   function(data){
                                    data.phrase             =   $("#slc_automplete_biopsia").val();
                                    data.tipo_busqueda      =   $("input[name='ind_tipo_busqueda']:checked").val();
                                    data.template           =   $("#ind_pagina").val();
                                    console.log("data  ->  ",data);
                                    return data;
                                },
        getValue            :   "name",
        template            :   {   
                                    type        :   "description",  
                                    fields      :   {   
                                                        description     :   "type" , 
                                                        iconSrc         :   "icon"
                                                    },
                                    method      :   function(value,item) {
                                                        console.log("->",value,item);
                                                        return "<span class='fa fa-battery-empty'></span>" + value;
                                                    }
                                },                
        ajaxSettings        :   {
                                    dataType    :   "json",
                                    method      :   "POST",
                                    error       :   function(errro) { 
                                                        console.log("errro              |   ->  ",errro);
                                                        console.log("responseText       |   ->  ",errro.responseText);    
                                                        jError("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                    },
                                    data        :   {
                                                        dataType        :   "json",
                                                    }
                                },
        placeholder         :   _value == 1 ? "Ingrese paciente":"Numero Biopsia/citologico/pap",
        requestDelay        :   400,
        //theme             :   "round",
        //theme               :   "square",
        list                :   {
                                  
            onClickEvent        :   function(){
                                    var v_new_id_anatomia                           =   $("#slc_automplete_biopsia").getSelectedItemData().id_anatomia;
                                    var v_not_cancer                                =   $("#slc_automplete_biopsia").getSelectedItemData().not_cancer;
                                    //var v_cod_establref                           =   $("#slc_automplete_biopsia").getSelectedItemData().cod_establref;
                                    var arr_storange_ids_anatomia                   =   [];
                                    arr_storange_ids_anatomia                       =   localStorage.getItem("storange_ids_anatomia");
                                    //filtro si tiene notificacion de cancer
                                    if(v_not_cancer == null && $("#ind_pagina").val() == "notificacancer"){
                                        showNotification('top','center',"Solicitud n&uacute;mero "+v_new_id_anatomia+" no cuenta con notificaci&oacute;n de c&aacute;ncer",4,'fa fa-ban');
                                        return false;
                                    }
                                    if(arr_storange_ids_anatomia                    ==  null){
                                        localStorage.setItem("storange_ids_anatomia",v_new_id_anatomia);
                                    } else {
                                        var arr_storange_ids_anatomia_mod           =   localStorage.getItem("storange_ids_anatomia").split(',');
                                        if(arr_storange_ids_anatomia_mod.indexOf(v_new_id_anatomia) == -1){
                                            arr_storange_ids_anatomia_mod.push(v_new_id_anatomia);
                                            localStorage.removeItem('storange_ids_anatomia');
                                            localStorage.setItem("storange_ids_anatomia",arr_storange_ids_anatomia_mod.join(","));
                                        } else {
                                            showNotification('top','center','La busqueda ya se encuentra en la lista;',1,'fa fa-ban');
                                        }
                                    }
                                    update_etapaanalitica_cancer_edicion();
                                },       
                },
            //http://easyautocomplete.com/guide
    };
    document.getElementById('slc_automplete_biopsia').type = _value == 1 ? 'text':'number';
    $("#slc_automplete_biopsia").val('').prop('disabled',false).easyAutocomplete(opciones);
}

function js_vista_opcion_busqueda(_value){
    $("#slc_automplete_biopsia").val('');
    localStorage.setItem("storage_busqueda_por_n_biosia_cancer",_value);
    var num_value = _value == 'busqueda_por_paciente'?1:2;
    star_automplete(num_value,$("#ind_pagina").val());
}

function update_etapaanalitica_cancer_edicion(){
    var v_tipo_de_busqueda = "#_panel_por_gestion";
    var v_get_sala = $("#ind_pagina").val();
    var v_filtro_consulta = '0';
    var v_ids_anatomia = localStorage.getItem("storange_ids_anatomia");
    $('#loadFade').modal('show');
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_notificacancer/load_lista_anatomiapatologica",
        dataType : "json",
        beforeSend : function(xhr)   {   
                                        //console.log("load load_etapa_analitica - update_lista_etapaanalitica -> ",xhr);  
                                        //setTimeout($('#loadFade').modal('show'),1000);
                                    },
        data : { 
                    v_ids_anatomia      :   v_ids_anatomia,         
                    v_tipo_de_busqueda  :   v_tipo_de_busqueda,
                    v_get_sala          :   v_get_sala,             
                    v_filtro_consulta   :   v_filtro_consulta,     
                },
        error : function(errro) { 
                                    console.log(errro);  
                                    console.log(errro.responseText);
                                    jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                    $('#loadFade').modal('hide'); 
                                },
        success : function(aData) { 
                                        console.log("aData -> ",aData);
                                        $('#loadFade').modal('hide');
                                        $(".get_table_gestion").html('').html(aData.return_data.HTML_LI);
                                    }, 
    });
}

function js_limpia_regustros(){
    localStorage.removeItem('storange_ids_anatomia');
}

function js_notificar_cancer(id_anatomia){
    $("#modal_listado_notificado").modal('hide');
    $('#loadFade').modal('show');
    $.ajax({ 
        type        :   "POST",
        url         :   "ssan_libro_notificacancer/html_notificar_a_ususario",
        dataType    :   "json",
        beforeSend  :   function(xhr)   {   
                                            //console.log("load load_etapa_analitica - update_lista_etapaanalitica -> ",xhr);  
                                            //setTimeout($('#loadFade').modal('show'),1000);
                                        },
        data        :                   { 
                                            id_anatomia      :   id_anatomia,         //to string
                                        },
        error       :   function(errro) { 
                                            console.log(errro);  
                                            //console.log(errro.responseText);
                                            jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                            $('#loadFade').modal('hide'); 
                                        },
        success     :   function(aData) { 
                                            console.log("aData -> ",aData);
                                            $("#btn_envia_correo").attr('onclick','js_confirma_notificacion_cancer('+id_anatomia+')');
                                            $('#loadFade').modal('hide');
                                            $("#html_notificacion_cancer").html(aData.return_data.HTML_LI);
                                            $("#modal_notificacion_cancer").modal({backdrop:'static',keyboard:false}).modal("show");
                                        }, 
    });
}

function js_confirma_notificacion_cancer(id_anatomia){
    //ARREGLANDO EN LA TARDE
    var errores =   [];
    var firma_simple_trasporte = $("#firma_simple_trasporte").val();
    var firma_simple_recepcion = $("#firma_simple_recepcion").val();
    firma_simple_trasporte  === ''?errores.push({"txt":"Falta firma simple de quien trasporto muestras","id":"#firma_simple_trasporte"}):$("#firma_simple_trasporte").css("border-color","");
    firma_simple_recepcion  === ''?errores.push({"txt":"Falta firma simple de quien recepciona las muestras","id":"#firma_simple_recepcion"}):$("#firma_simple_recepcion").css("border-color","");
    errores.length>0 ? '' : firma_simple_trasporte === firma_simple_recepcion ? errores.push({"txt":"Firmas Iguales","id":"#firma_simple_trasporte,#firma_simple_recepcion"}) : $("#firma_simple_trasporte,#firma_simple_recepcion").css("border-color","");
    console.log("Errores  -> ",errores);
    if(errores.length>0){
        errores.forEach(function(value,index){
            showNotification('top','right',value.txt,4,'fa fa-times');
            $(value.id).css("border-color","red");
        });
        return false;
    } else {
        var pass = new Array({
            "pass1" : $("#firma_simple_trasporte").val(),
            "pass2" : $("#firma_simple_recepcion").val()
        });
        //console.log("pass           =>  ",pass);
        $('#loadFade').modal('show'); 
        $.ajax({ 
            type : "POST",
            url : "ssan_libro_notificacancer/confirma_notificacion_cancer",
            dataType : "json",
            beforeSend : function(xhr) { },
            data : {
                        id_anatomia : id_anatomia,
                        pass : pass,
                    },
            error :   function(errro)   { 
                                            console.log(errro);  
                                            console.log(errro.responseText);    
                                            jAlert("Error en aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                            $('#loadFade').modal('hide'); 
                                        },
            success :   function(aData) { 
                                            console.log(" return aData -> ",aData,);
                                            $('#loadFade').modal('hide'); 
                                            if(aData.STATUS){
                                                var var_status_bd = aData["GET_BD"].STATUS;
                                                if(var_status_bd === false){
                                                    showNotification('top','right',aData["GET_BD"].TXT_ERROR,4,'fa fa-times');
                                                } else {
                                                    update_etapaanalitica_cancer_edicion();
                                                    $('#modal_notificacion_cancer').modal('hide');
                                                    jConfirm('Notificacion realizada con exito - &iquest;desea ver PDF informe?','Clinica Libre - ANATOM&Iacute;A PATOL&Oacute;GICA',function(r) {
                                                        if(r){
                                                            pdf_notificacion_cancer_ok(id_anatomia);
                                                        } else {
                                                            //console.log("-> DIJO NO PDF <-");
                                                        }
                                                    });
                                                } 
                                            } else {
                                                jError(aData['TXT_ERROR'],"Clinica Libre");
                                            }
                                        }, 
        });
    } 
}

function js_confirma_envio(id_anatomia){
    $('#loadFade').modal('show');
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_notificacancer/informa_x_correo",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        console.log("Enviando Correo");
                                                        $('#loadFade').modal('show');
                                                    },
        data 		:                           { 
                                                        id : id_anatomia,
                                                    },
        error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        $('#loadFade').modal('hide');
                                                    },
        success		:   function(aData)         { 
                                                        $('#loadFade').modal('hide');
                                                        console.log("aData      ->",aData);
                                                        showNotification('top','center','Se ha enviado correo '+aData.IND_MAIL,1,'fa fa-info');
                                                    }, 
   });
}



function js_validafirma(txt_firma_simple){
    var txt_valida_firma = $("#"+txt_firma_simple).val();
    if(txt_valida_firma == ''){  showNotification('top','center','Firma simple vacia',4,'fa fa-info');  return false; }
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_biopsias_listaexterno1/ver_valida_firma_simple",
        dataType    :   "json",
        beforeSend	:   function(xhr)           {   
                                                    console.log(xhr);
                                                    $('#loadFade').modal('show');
                                                },
        data 		:                           {  
                                                    contrasena      :   txt_valida_firma,
                                                },
        error		:   function(errro)         { 
                                                    console.log("quisas->",errro,"-error->",errro.responseText); 
                                                    $("#protocoloPabellon").css("z-index","1500"); 
                                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    $('#loadFade').modal('hide');
                                                },
        success		:   function(aData)         {   
                                                    $('#loadFade').modal('hide');
                                                    if (aData.status){
                                                        let data_user = aData.valida[0];
                                                        showNotification('top','center','<i class="fa fa-info"></i>&nbsp;Firma simple ->'+data_user.NAME+' - '+data_user.USERNAME,1,'');
                                                    } else {
                                                        jError("Firma &uacute;nica. no tiene usuario asignado","Clinica Libre");
                                                    }
                                                }, 
    });
}

function pdf_notificacion_cancer_ok(id_anatomia){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_notificacancer/pdf_notificacion_cancer_ok",
        dataType : "json",
        beforeSend	: function(xhr) { },
        data : { id : id_anatomia },
        error : function(errro) { 
                                    console.log("quisas->",errro); 
                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                    $('#loadFade').modal('hide'); 
                                },
        success : function(aData) { 
                                        console.log(" aData -> ",aData);
                                        $('#loadFade').modal('hide'); 
                                        if(!aData["STATUS"]){
                                            jError("error al cargar protocolo PDF","Clinica Libre");
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
                                            $('#html_pdf_notificacion_cancer').html(Objpdf);
                                            $("#modal_pdf_notificacion_cancer").modal({backdrop:'static',keyboard:false}).modal("show");
                                        }
                                    }, 
   });
}

function js_edita_numero_biopsia(id_biopsia){
    $('#loadFade').modal('show');
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_notificacancer/html_gestion_numero_biopsia",
        dataType : "json",
        beforeSend : function(xhr) { console.log(xhr); },
        data : { id_biopsia : id_biopsia },
        error :   function(errro){ 
                                            console.log("quisas->",errro,"-error->",errro.responseText); 
                                            $("#protocoloPabellon").css("z-index","1500"); 
                                            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                            $('#loadFade').modal('hide');
                                        },
        success		:   function(aData){   
                                            $('#loadFade').modal('hide');
                                            console.log("aData -> ",aData);
                                            //$("#btn_confirma_edicion_biopsia").attr('onclick','js_confirma_notificacion_cancer('+id_biopsia+')');
                                            $("#html_edicion_numero_biopsia").html(aData.html_out);
                                            $("#modal_edicion_numero_biopsia").modal({backdrop:'static',keyboard:false}).modal("show");
                                        }, 
    });
}

//BUSQUEDA DEL CORRELATIVO SEGUN LA BIOPSIA
function busqueda_numero_disponible(tipo_biopsia){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_listaexterno1/ultimo_numero_disponible",
        dataType : "json",
        beforeSend : function(xhr) { console.log("xhr->",xhr);   },
        data : {   tipo_biopsia : tipo_biopsia },
        error :   function(errro) { 
                                        console.log(errro);  
                                        console.log(errro.responseText);    
                                        jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                        $('#loadFade').modal('hide'); 
                                    },
        success : function(aData) { 
                                        console.log("ultimo_numero_disponible -> ",aData,"  <-  ");
                                        $("#num_interno").val('');
                                        $('#loadFade').modal('hide'); 
                                        var num_last    =   aData.data_numero.DATA_NUMBER[0]['V_LAST_NUMERO'];
                                        showNotification('top','center','N&deg; asignado:<b>'+num_last+'</b>',1,'fa fa-info');
                                        $("#num_interno").val(num_last);
                                    }, 
    });
}

//SOLO BUSCA UN SEGUNDO CORRELATIVO
function busqueda_numero_disponible_citologia(tipo_biopsia){
    c$('#loadFade').modal('show'); 
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_biopsias_listaexterno1/ultimo_numero_disponible_citologia",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("xhr->",xhr);
                                                },
        data                :                   {   tipo_biopsia : tipo_biopsia },
        error		    :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error General, Consulte Al Administrador","Clinica Libre");
                                                    $('#loadFade').modal('hide');  
                                                },
        success             :   function(aData) { 
                                                    console.log("ultimo_numero_disponible citologia -> ",aData,"  <-  ");
                                                    $("#num_interno_cito").val('');
                                                    $('#loadFade').modal('hide'); 
                                                    var num_last    =   aData.data_numero.DATA_NUMBER[0]['V_LAST_NUMERO'];
                                                    showNotification('top','center','N&deg; asignado:<b>'+num_last+'</b>',1,'fa fa-info');
                                                    $("#num_interno_cito").val(num_last);
                                                }, 
    });
}

function js_pdf_microscopica(id_anatomia){
    $("#modal_pdf_notificacion_cancer").css("z-index","1500").modal({backdrop:'static',keyboard:false}).modal("show");
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/pdf_macroscopia_parte2",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        //console.log("generando");
                                                        $('#html_pdf_fullscreen').html("<i class='fa fa-spinner fa-spin fa-3x fa-fw' aria-hidden='true'></i>&nbsp;GENERANDO PDF <- ");
                                                    },
        data 		:                           { 
                                                        id  :   id_anatomia,
                                                    },
        error		:   function(errro)         { 
                                                      
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre");
                                                        
                                                        $("#html_pdf_notificacion_cancer").html();
                                                        $("#modal_pdf_notificacion_cancer").modal('hide');
                                                    },
        success		:   function(aData)         { 
                                                        console.log("-------------------------------------------");
                                                        console.log("   aData   ->",aData,"<-                   ");
                                                        
                                                        if(!aData["STATUS"]){
                                                            jError("error al cargar protocolo PDF","Clinica Libre");
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
                                                            //create the blob object with content-type "application/pdf"  
                                                            var blob                =   new Blob([view],{type:"application/pdf"});
                                                            var blobURL             =   URL.createObjectURL(blob);
                                                            //console.log("BlobURL->",blobURL);
                                                            Objpdf                  =   document.createElement('object');
                                                            Objpdf.setAttribute('data',blobURL);
                                                            Objpdf.setAttribute('width','100%');
                                                            Objpdf.setAttribute('style','height:700px;');
                                                            Objpdf.setAttribute('title','PDF');
                                                            $('#html_pdf_notificacion_cancer').html(Objpdf);
                                                        }
                                                   }, 
   });
}

function GET_PDF_ANATOMIA_PANEL(id){
    $('#loadFade').modal('show'); 
    $.ajax({ 
       type :   "POST",
       url :   "ssan_libro_biopsias_usuarioext/BLOB_PDF_ANATOMIA_PATOLOGICA",
       dataType :   "json",
       beforeSend	:   function(xhr)           {   
                                                    console.log(xhr);
                                                    console.log("generando PDF");
                                                    
                                                },
       data 		:                           { 
                                                    id  :   id,
                                                },
       error		:   function(errro)         { 
                                                    console.log("quisas->",errro,"-error->",errro.responseText); 
                                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    $('#loadFade').modal('hide'); 
                                                },
       success		:   function(aData)         { 
                                                        console.log("---------------------------------------------");
                                                        console.log(aData);
                                                        $('#loadFade').modal('hide'); 
                                                        $('#HTML_PDF_ANATOMIA_PATOLOGICA').html('');
                                                        if(!aData["STATUS"]){
                                                           jError("error al cargar protocolo PDF","Clinica Libre");
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
                                                            //create the blob object with content-type "application/pdf"  
                                                            var blob                =   new Blob([view],{type:"application/pdf"});
                                                            var blobURL             =   URL.createObjectURL(blob);
                                                            //console.log("BlobURL->",blobURL);
                                                            Objpdf                  =   document.createElement('object');
                                                            Objpdf.setAttribute('data',blobURL);
                                                            Objpdf.setAttribute('width','100%');
                                                            let windowHeight = window.innerHeight;
                                                            let adjustedHeight = windowHeight - 200;
                                                            Objpdf.setAttribute('style', `height:${adjustedHeight}px;`);
                                                            Objpdf.setAttribute('title','PDF');
                                                            $('#html_pdf_notificacion_cancer').html(Objpdf);
                                                            $("#modal_pdf_notificacion_cancer").modal({backdrop:'static',keyboard:false}).modal("show");

                                                        }
                                                    }, 
   });
}



function js_pdf_informe_final(id_anatomia){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_etapaanalitica/pdf_macroscopia_parte2",
        dataType : "json",
        beforeSend : function(xhr) { },
        data : {  id : id_anatomia },
        error : function(errro) { 
                                    console.log("quisas->",errro,"-error->",errro.responseText); 
                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                    $('#loadFade').modal('hide'); 
                                },
        success : function(aData) { 
                                    console.log("aData -> ",aData);
                                    $('#loadFade').modal('hide'); 
                                    if(!aData["STATUS"]){
                                        jError("error al cargar protocolo PDF","Clinica Libre");
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
                                        $('#html_pdf_notificacion_cancer').html(Objpdf);
                                        $("#modal_pdf_notificacion_cancer").modal({backdrop:'static',keyboard:false}).modal("show");
                                    }
                                }, 
   });
}

function js_cambio_numero_biopsia(id_biopsia){
    var ind_tipo_biopsia = $("#ind_tipo_biopsia").val();
    var new_num_interno = $("#num_interno").val();
    var old_num_interno = $("#old_num_interno").val(); 
    var error = [];
    new_num_interno == old_num_interno ? error.push("Nuevo numero es igual anterior") : '' ;
    new_num_interno == '' ? error.push("Numero de biopsia vac&iacute;o") : '';
    error.length>0 ? showNotification('top','center',error.join("<br>"),4,'fa fa-ban') : load_cambio_numero_biopsia({
        ind_tipo_biopsia : ind_tipo_biopsia,
        id_biopsia : id_biopsia,         
        new_num_interno : new_num_interno,
        ind_cambio : '1',
    });
}

function js_cambio_numero_biopsia_citologico(id_biopsia){
    var ind_tipo_biopsia = $("#ind_tipo_biopsia").val();
    var num_interno_cito = $("#num_interno_cito").val();
    var old_num_interno = $("#old_num_interno_cito").val(); 
    var error = [];
    num_interno_cito == old_num_interno ? error.push("Nuevo numero es igual anterior") : '' ;
    num_interno_cito == '' ? error.push("numero citol&oacute;gico vac&iacute;o") : '';
    error.length>0 ? showNotification('top','center',error.join("<br>"),4,'fa fa-ban') : load_cambio_numero_biopsia({
        ind_tipo_biopsia : ind_tipo_biopsia,
        id_biopsia : id_biopsia,         
        new_num_interno : num_interno_cito,
        ind_cambio : '2',
    });
}

function load_cambio_numero_biopsia(datasend){
    jPrompt('Con esta acci&oacute;n se proceder&aacute; editar numero de biopsia.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if(r){
            $('#loadFade').modal('show');
            datasend["pass"] = r;
            $.ajax({ 
                type : "POST",
                url : "ssan_libro_notificacancer/get_cambio_numero_biopsia",
                dataType : "json",
                beforeSend : function(xhr) { console.log("xhr->",xhr); },
                data : datasend,
                error : function(errro) { 
                                            console.log(errro);  
                                            jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                            $('#loadFade').modal('hide');
                                        },
                success : function(aData) { 
                                            $('#loadFade').modal('hide');
                                            console.log("retun -> ",aData);
                                            if (aData.status){
                                                showNotification('top','center','El cambio de numero de biopsia se ha realizado con &eacute;xito',2,'fa fa-check');
                                                $(aData.ind_cambio == 1 ? "#old_num_interno": "#old_num_interno_cito").val(aData.nun_biopsia) ;
                                                update_etapaanalitica_cancer_edicion();
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

function js_vista_historial_cambios(id_biopsia){
    $("#html_historial_cambios").html('');
    $("#modal_historial_cambios").modal({backdrop:'static',keyboard:false}).modal("show");
    /*
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_notificacancer/vista_historial_cambios",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("xhr->",xhr);
                                                },
        data                :                   {   id_biopsia : id_biopsia },
        error		    :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                },
        success             :   function(aData) { 
                                                    console.log("",aData,"  <-  ");
                                                }, 
    });
    */
}

function listado_notifica_cancer(ind_year){
    $('#loadFade').modal('show');
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_notificacancer/load_notificacion_cancer_por_year",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("xhr->",xhr);
                                                },
        data                :                   {   ind_year : ind_year },
        error		    :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    $('#loadFade').modal('hide');
                                                },
        success             :   function(aData) { 
                                                    $('#loadFade').modal('hide');
                                                    console.log("aData      ->  ",aData);
                                                    $("#html_listado_notificado").html(aData.html);
                                                    !$("#modal_listado_notificado").is(":visible") ? $("#modal_listado_notificado").modal({backdrop:'static',keyboard:false}).modal("show") : '' ;
                                                }, 
    });
}



//new
//solo en estado:8
function js_edita_fecha_notificacion(ind_opcion,id_biopsia){
    console.log("tipo_biopsia           ->  ",id_biopsia);
    var arr_info                        =   $("#biopsia_"+id_biopsia).data('info');
    console.log("   ----------------------------------------------------------------      ");
    console.log("   arr_info            ->  ",arr_info);
    //
//console.log("TXT_FECHA_DIAGNOSTICO  ->  ",arr_info.TXT_FECHA_DIAGNOSTICO);
    //console.log("TXT_HORA_DIAGNOSTICO   ->  ",arr_info.TXT_HORA_DIAGNOSTICO);
    //return false;
    
    
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_notificacancer/load_edicion_fechas",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("xhr->",xhr);
                                                },
        data                :                   {   
                                                    id_biopsia              :   id_biopsia,
                                                    ind_opcion              :   ind_opcion,
                                                    arr_info                :   arr_info,
                                                    txt_fecha_diag          :   arr_info.TXT_FECHA_DIAGNOSTICO,
                                                    txt_hora_diagnostico    :   arr_info.TXT_HORA_DIAGNOSTICO,
                                                },
        error		    :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                },
        success             :   function(aData) { 
                                                    console.log("load_edicion_fechas citologia -> ",aData,"  <-  ");
                                                    $("#html_modifica_fechas").html(aData.html);
                                                    $("#modal_modifica_fechas").modal({backdrop:'static',keyboard:false}).modal("show");
                                                }, 
    });
}


function js_edita_fecha_emision_informe(id_biopsia){
   var new_fecha_diagnostico                =   $("#new_fecha_diagnostico").val();
   var new_hora_diagnostico                 =   $("#new_hora_diagnostico").val();
   console.log("    --------------------------------------------------------    ");
   console.log("    id_biopsia              ->  ",id_biopsia);
   console.log("    new_fecha_diagnostico   ->  ",new_fecha_diagnostico);
   console.log("    new_hora_diagnostico    ->  ",new_hora_diagnostico);
   if (new_fecha_diagnostico == '' || new_hora_diagnostico == ''){
       jAlert("Fecha/hora vacia","Clinica Libre");
       return false;
   }
    jPrompt('Con esta acci&oacute;n se proceder&aacute; editar fecha de diagnostico.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if(r){
            $('#loadFade').modal('show');
            $.ajax({ 
                type                :   "POST",
                url                 :   "ssan_libro_notificacancer/record_fecha_diagnostico",
                dataType            :   "json",
                beforeSend          :   function(xhr)   {   
                                                            console.log("xhr->",xhr);
                                                        },
                data                :                   {   
                                                            constrasena             :   r,
                                                            id_biopsia              :   id_biopsia,
                                                            ind_opcion              :   0,
                                                            new_fecha_diagnostico   :   new_fecha_diagnostico,
                                                            new_hora_diagnostico    :   new_hora_diagnostico
                                                        },
                error		    :   function(errro) { 
                                                            console.log(errro);  
                                                            console.log(errro.responseText);    
                                                            jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                            $('#loadFade').modal('hide');
                                                        },
                success             :   function(aData) { 
                                                            $('#loadFade').modal('hide');
                                                            console.log("lrecord_fecha_diagnostico -> ",aData,"  <-  ");
                                                            if (aData.status){
                                                                //jError("Exito","Clinica Libre");
                                                                showNotification('top','center','Se ha modificado la fecga de diagnostico',1,'fa fa-info');
                                                                $('#modal_modifica_fechas').modal('hide');
                                                                update_etapaanalitica_cancer_edicion();
                                                            } else {
                                                                jError(aData.txt_error,"Clinica Libre");
                                                            }
                                                        }, 
            });
        } else {
            jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
        }
    });
}

function js_edita_fecha_notificacion_cancar(id_biopsia){
    var new_fecha_notifica_cancer                =   $("#new_fecha_notifica_cancer").val();
    var new_hora_notifica_cancer                 =   $("#new_hora_notifica_cancer").val();
    console.log("    --------------------------------------------------------       ");
    console.log("    id_biopsia              ->  ",id_biopsia,"                     ");
    console.log("    new_fecha_diagnostico   ->  ",new_fecha_notifica_cancer,"      ");
    console.log("    new_hora_diagnostico    ->  ",new_hora_notifica_cancer,"       ");
    console.log("    --------------------------------------------------------       ");
    if (new_fecha_notifica_cancer == '' || new_hora_notifica_cancer == ''){
       jAlert("Fecha/hora vac&iacute;a","Clinica Libre");
       return false;
    }
    jPrompt('Con esta acci&oacute;n se proceder&aacute; editar fecha notificaci&oacute;n de c&aacute;ncer.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if(r){
            $('#loadFade').modal('show');
            $.ajax({ 
                type                :   "POST",
                url                 :   "ssan_libro_notificacancer/record_fecha_notificacancer",
                dataType            :   "json",
                beforeSend          :   function(xhr)   {   
                                                            console.log("xhr->",xhr);
                                                        },
                data                :                   {   
                                                            constrasena                 :   r,
                                                            id_biopsia                  :   id_biopsia,
                                                            ind_opcion                  :   0,
                                                            new_fecha_notifica_cancer   :   new_fecha_notifica_cancer,
                                                            new_hora_notifica_cancer    :   new_hora_notifica_cancer
                                                        },
                error		    :   function(errro) { 
                                                            console.log(errro);  
                                                            console.log(errro.responseText);    
                                                            jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                            $('#loadFade').modal('hide');
                                                        },
                success             :   function(aData) { 
                                                            $('#loadFade').modal('hide');
                                                            console.log("lrecord_fecha_diagnostico -> ",aData,"  <-  ");
                                                            if (aData.status){
                                                                //jError("Exito","Clinica Libre");
                                                                showNotification('top','center','Se ha modificado fecha de notificaci&oacute;n de c&aacute;ncer',1,'fa fa-info');
                                                                $('#modal_modifica_fechas').modal('hide');
                                                                update_etapaanalitica_cancer_edicion();
                                                            } else {
                                                                jError(aData.txt_error,"Clinica Libre");
                                                            }
                                                        }, 
            });
        } else {
            jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
        }
    });
}

function elimina_biopsia_desde_anatomia(id_biopsia){
    jPrompt('Con esta acci&oacute;n se proceder&aacute; a archivar la biopsia por alg&uacute;n error. quedar&aacute; libre n&uacute;mero de recepci&oacute;n asignados a esta biopsia para otorgar seg&uacute;n lo estime conveniente.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if(r){
            $('#loadFade').modal('show');
            $.ajax({ 
                type                :   "POST",
                url                 :   "ssan_libro_notificacancer/record_elimina_definitivamente",
                dataType            :   "json",
                beforeSend          :   function(xhr)   {   
                                                            console.log("xhr->",xhr);
                                                        },
                data                :                   {   
                                                            constrasena             :   r,
                                                            id_biopsia              :   id_biopsia,

                                                        },
                error		    :   function(errro)     { 
                                                            console.log(errro);  
                                                            console.log(errro.responseText);    
                                                            jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                            $('#loadFade').modal('hide');
                                                        },
                success             :   function(aData) { 
                                                            $('#loadFade').modal('hide');
                                                            
                                                        
                                                            console.log("record_elimina_definitivamente  -> ",aData,"  <-  ");
                                                            if (aData.status){
                                                                jAlert('Con esta acci&oacute;n se proceder&aacute; a archivar la biopsia por alg&uacute;n error. quedar&aacute; libre n&uacute;mero de recepci&oacute;n asignados a esta biopsia para otorgar seg&uacute;n lo estime conveniente.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
                                                                if(r){   location.reload();    }});
                                                                $('#modal_edicion_numero_biopsia').modal('hide');
                                                                jAlert('Se ha eliminado la biopsia', "Confirmac\u00f3on", function (r) {
                                                                    if (r) {
                                                                        location.reload(true);
                                                                    }
                                                                });
                                                                //showNotification('top','center','',1,'fa fa-info');
                                                                //update_etapaanalitica_cancer_edicion();
                                                            } else {
                                                                jError(aData.txt_error,"Clinica Libre");
                                                            }
                                                            
                                                            
                                                        }, 
            });
        } else {
            jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
        }
    });
}

function js_edicion_fecha_informe(id_biopsia){
    var fecha_solicitud   =   $("#fecha_solicitud").val();
    var hora_solicitud    =   $("#hora_solicitud").val();
    /*
    console.log("    -----------------------------------------------------  ");
    console.log("    id_biopsia              ->  ",id_biopsia,"             ");
    console.log("    new_fecha_diagnostico   ->  ",fecha_solicitud,"        ");
    console.log("    new_hora_diagnostico    ->  ",hora_solicitud,"         ");
    console.log("    -----------------------------------------------------  ");
    */
    if (fecha_solicitud == '' || hora_solicitud == ''){
       jAlert("Fecha/hora vac&iacute;a","Clinica Libre");
       return false;
    }
    jPrompt('Con esta acci&oacute;n se proceder&aacute; editar fecha de toma de muestra <br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if(r){
            $('#loadFade').modal('show');
            $.ajax({ 
                type                :   "POST",
                url                 :   "ssan_libro_notificacancer/record_fecha_toma_muestra",
                dataType            :   "json",
                beforeSend          :   function(xhr)   {   
                                                            console.log("xhr->",xhr);
                                                        },
                data                :                   {   
                                                            constrasena       :   r,
                                                            id_biopsia        :   id_biopsia,
                                                            ind_opcion        :   0,
                                                            fecha_solicitud   :   fecha_solicitud,
                                                            hora_solicitud    :   hora_solicitud
                                                        },
                error		    :   function(errro) { 
                                                            console.log(errro);  
                                                            console.log(errro.responseText);    
                                                            jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                            $('#loadFade').modal('hide');
                                                        },
                success             :   function(aData) { 
                                                            $('#loadFade').modal('hide');
                                                            console.log("record_fecha_toma_muestra -> ",aData,"  <-  ");
                                                            if (aData.status){
                                                                //jError("Exito","Clinica Libre");
                                                                showNotification('top','center','Se ha modificado fecha',1,'fa fa-info');
                                                                $('#modal_edicion_numero_biopsia').modal('hide');
                                                                update_etapaanalitica_cancer_edicion();
                                                            } else {
                                                                jError(aData.txt_error,"Clinica Libre");
                                                            }
                                                        }, 
            });
        } else {
            jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
        }
    });
}

//24.05.2024
function js_edita_macrocopica(id_biopsia){
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_edicionsolicitudbiopsia/html_edicion_macrocopica",
        dataType    :   "json",
        beforeSend	:   function(xhr)           {   
                                                    console.log(xhr);
                                                    $('#loadFade').modal('show');
                                                },
        data 		:                           {  
                                                    id_biopsia      :   id_biopsia,
                                                },
        error		:   function(errro)         { 
                                                    console.log("quisas->",errro,"-error->",errro.responseText); 
                                                    $("#protocoloPabellon").css("z-index","1500"); 
                                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    $('#loadFade').modal('hide');
                                                },
        success		:   function(aData)         {   
                                                    $('#loadFade').modal('hide');
                                                    console.error("aData -> ",aData);
                                                    $("#new_fecha_macrocopica").val('');
                                                    $("#new_hora_macrocopica").val('');
                                                    $("#btn_update_macrocopica").attr('onclick','js_update_macrocopica('+id_biopsia+')');
                                                    $("#modal_edita_macro").modal({backdrop:'static',keyboard:false}).modal("show");
                                                }, 
    });
}

function js_update_macrocopica(id_biopsia){
    let error = [];
    let v_date_fecha                    =   $("#new_fecha_macrocopica").val();
    let v_hora_macrocopica              =   $("#new_hora_macrocopica").val();
    if (v_date_fecha == '' )            {   error.push("-   Falta fecha");  }
    if (v_hora_macrocopica == '' )      {   error.push("-   Falta hora");   }
    if (error.length  === 0 ){
        jPrompt('Con esta acci&oacute;n se proceder&aacute; editar el tiempo de toma sala de macrosocopia. seguro de continuar?','','Confirmaci\u00f3n',function(r){
            if(r){
                let v_newfecha = convertDateFormat(v_date_fecha);
                //console.log("v_newfecha ->",v_newfecha);
                $('#loadFade').modal('show');
                $.ajax({ 
                    type                :   "POST",
                    url                 :   "ssan_libro_edicionsolicitudbiopsia/record_macrocopica",
                    dataType            :   "json",
                    beforeSend          :   function(xhr)   {   
                                                                console.log("xhr->",xhr);
                                                            },
                    data                :                   {   
                                                                constrasena         :   r,
                                                                id_biopsia          :   id_biopsia,
                                                                v_date_fecha_hora   :   v_newfecha+' '+v_hora_macrocopica,
                                                            },
                    error		    :   function(errro)     { 
                                                                console.log(errro);  
                                                                console.log(errro.responseText);    
                                                                jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                                $('#loadFade').modal('hide');
                                                            },
                    success             :   function(aData) { 
                                                                $('#loadFade').modal('hide');
                                                                console.log("record_elimina_definitivamente  -> ",aData,"  <-  ");
                                                                if (aData.status){
                                                                    jAlert('Se ha editado la biopsia', "Confirmac\u00f3on", function (r) {
                                                                        if (r) {
                                                                            location.reload(true);
                                                                        }
                                                                    });
                                                                } else {
                                                                    jError(aData.txt_error,"Clinica Libre");
                                                                }
                                                            }, 
                });
            } else {
                jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
            }
        });
    } else {
        jError(error.join("<br>"),"Clinica Libre");
    }
}


function convertDateFormat(dateString) {
    // Dividir la cadena en partes
    let parts = dateString.split('-');
    let year = parts[0];
    let month = parts[1];
    let day = parts[2];
    // Formatear la fecha en DD-MM-YYYY
    return `${day}-${month}-${year}`;
}