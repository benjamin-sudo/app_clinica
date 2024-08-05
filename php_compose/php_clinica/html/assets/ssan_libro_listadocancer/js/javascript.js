$(function(){
    var fecha = new Date();
    var ano = fecha.getFullYear();
    listado_notifica_cancer(ano);
 });
 
 function listado_notifica_cancer(ind_year){
    $('#loadFade').modal('show');
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_notificacancer/load_notificacion_cancer_por_year",
        dataType : "json",
        beforeSend : function(xhr) { },
        data : { ind_year : ind_year },
        error : function(errro) { 
                                    console.log(errro);
                                    jAlert("Error General, Consulte Al Administrador","Clinica Libre");   
                                    setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                                },
        success : function(aData) { 
                                    console.log("aData  ->",aData );    
                                    $(".return_table").html(aData.html);
                                    $(".lista_notificacion_cancer").hide();
                                    setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                                }, 
    });
 }
 
 function js_notificar_cancer(id_anatomia){
    $("#modal_listado_notificado").modal('hide');
    $('#loadFade').modal('show');
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_notificacancer/html_notificar_a_ususario",
        dataType : "json",
        data : {  id_anatomia : id_anatomia },
        error : function(errro) { 
                                    console.log(errro);  
                                    console.log(errro.responseText);
                                    jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                    setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                                },
        success : function(aData) { 
                                    console.log("aData                  ->  ",aData);
                                    //$("#btn_envia_correo").attr('onclick','js_confirma_envio('+id_anatomia+')');
                                    $("#btn_envia_correo").attr('onclick','js_confirma_notificacion_cancer('+id_anatomia+')');
                                    setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                                    $("#html_notificacion_cancer").html(aData.return_data.HTML_LI);
                                    $("#modal_notificacion_cancer").modal({backdrop:'static',keyboard:false}).modal("show");
                                }, 
    });
 }
 
 function GET_PDF_ANATOMIA_PANEL(id){
    $('#loadFade').modal('show'); 
    $.ajax({ 
       type : "POST",
       url : "ssan_libro_biopsias_usuarioext/BLOB_PDF_ANATOMIA_PATOLOGICA",
       dataType  : "json",
       beforeSend : function(xhr)   {   
                                        console.log("generando PDF");
                                    },
       data : {   id : id, },
       error : function(errro) { 
                                    console.log("quisas->",errro,"-error->",errro.responseText); 
                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                    setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                                },
       success : function(aData) { 
                                        console.log(aData);
                                        setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                                        $('#HTML_PDF_ANATOMIA_PATOLOGICA').html('');
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
 
 function js_pdf_microscopica(id_anatomia){
    /*
    jFirmaUnica('Con esta acc&oacute;n se proceder&aacute; a generar documento correspondiente a paciente con informe de c&aacute;ncer<br/>&iquest;Est&aacute; seguro de continuar?<br />','','Confirmaci\u00F3n',function(obj_salida){
        let v_error = []; //array validador
        let v_run = obj_salida.v_run; //run en formato 123.123.12-3
        let status_run = obj_salida.status_run; // si el formato del run es correcto
        let v_pass = obj_salida.v_pass; // texto de firma simple
        if (!status_run){ v_error.push("El RUN ingresado es incorrecto");  }
        if((v_run=='')||(v_run==null)){ v_error.push("Firma simple incorrecta"); }
        if (v_error.length>0){
            showNotification('top','center',v_error.join("<br>"),4,'fa fa-exclamation-triangle');
        } else {
            //aqui continuaria el ajax ya con la validacion del run  con la firma firma simple1
            console.log("v_run ->",v_run);
            console.log("v_pass ->",v_pass);
        }
    });
    */
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_etapaanalitica/pdf_macroscopia_parte2",
        dataType : "json",
        beforeSend : function(xhr) { console.log(xhr);  },
        data :   { id : id_anatomia  },
        error :   function(errro) { 
                                        jError("Error General, Consulte Al Administrador","Clinica Libre");
                                        setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                                        $("#html_pdf_notificacion_cancer").html('');
                                        $("#modal_pdf_notificacion_cancer").modal('hide');
                                    },
        success : function(aData) { 
                                    setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                                    $("#modal_pdf_notificacion_cancer").css("z-index","1500").modal({backdrop:'static',keyboard:false}).modal("show");
                                    $('#html_pdf_notificacion_cancer').html('');
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
                                    }
                                }, 
    });
}
 