$(document).ready(function() {
    $("#modal_historialclinico").on('show.bs.modal', function (e){ 
        $("#txtBuscar").focus();
    });
    $('#modal_historialclinico').on('hidden.bs.modal', function(e){ 
        $("#txtBuscar").val(); 
        $("#txtDv").val(); 
        $("#resultadoBusqueda_post").val(); 
    });
    $('#TURNOXMAQUINA').on('show.bs.modal', function (e){ 
        //$("#txtBuscar").focus();
    });
    $('#TURNOXMAQUINA').on('hidden.bs.modal', function(e){ 
        $("#BODYXMAQUINA").html(''); 
        $("#NOM_MAQUINA").html(''); 
    });
    $('#PACIENTEXCUPO').on('show.bs.modal', function (e){ 
    
    });
    $('#PACIENTEXCUPO').on('hidden.bs.modal', function(e){ 
        $("#NUEVOPACIENTEXCUPO").attr('onclick',''); 
        $("#HTML_PACIENE").html('');
    });
    $('#nuevoProfesional').on('hidden.bs.modal', function(e){ 
        $("#txtBuscar").val(''); 
        $("#txtDv").val(''); 
        $("#resultadoBusqueda_post").html('');
    });
    $('#MODAL_HD_ANTERIORES').on('show.bs.modal',     function(e){ });
    $('#MODAL_HD_ANTERIORES').on('hidden.bs.modal',   function(e){ 
        $("#BODY_HD_ANTERIORES").html(" "); 
        $("#busquedaMes").html("");
    });
    $('#MODAL_INFOHOJADIARIA').on('show.bs.modal',     function(e){ });
    
    $('#MODAL_INFOHOJADIARIA').on('hidden.bs.modal',   function(e){ 
        $("#BODY_INFOHOJADIARIA").html(""); 
        $("#busquedaMes").html("");
    });
    
    $('#modal_nuevo_prestador_rrhh').on('hidden.bs.modal',   function(e){ 
        $("#html_nuevo_prestador_rrhh").html('');
        $("#btn_guarda_infoxususario").attr('onclick','');
        $("#btn_guarda_infoxususario").prop('disabled',true);
    });

    //$(".content2").autocomplete_nn();
    //busquedaPacientes();
    //busquedaPacientesxMaquina();

    $('#modal_nuevo_ingreso_paciente').on('hidden.bs.modal',function(e){ 
        //$("#html_nuevo_ingreso_paciente").html('');
    });

    $('#rut_paciente').Rut({
        on_error : function(){
            jError("RUN no es correcto","CLINICA LIBRE CHILE");
        },
        on_success : function(){
            js_grabadatosPaciente();
        },
        format_on : 'keyup'
    });

});

function nuevoPacienteAgresado(){
    $("#modal_nuevo_ingreso_paciente").modal({backdrop:'static',keyboard:false}).modal("show");
}

function js_grabadatosPaciente(){    
    if ($("#rut_paciente").val() == ''){
        jAlert("RUN del paciente vacio","CLINICA LIBRE CHILE");
        return false;
    }
    let Rut_form    =    $("#rut_paciente").val().replace(/\./g,'').split("-");//11111111-0    
    let txtBuscar   =    Rut_form[0];
    let txtDv       =    Rut_form[1];
    let lficha      =    '';
    
    console.log("   -----------------------------   ");
    console.log("   txtBuscar   ->  ",txtBuscar);
    console.log("   txtDv       ->  ",txtDv);
    
    $.ajax({ 
        type		 :  "POST",
        url 		 :  "ssan_hdial_ingresoegresopaciente/busqueda_pacientes_parametos",
        dataType     :  "json",
        beforeSend   :   function(xhr){ $('#loadFade').modal('show'); },
        data 		 :  { 
                            OPCION  : 1,
                            RUTPAC  : txtBuscar,
                            RUTDV   : txtDv,
                            LFICHA  : lficha,
                        },
        error		:   function(errro) {  
                                            console.log(errro);
                                            jAlert("Comuniquese con el administrador","CLINICA LIBRE CHILE");
                                            $("#loadFade").modal('hide'); 
                                        },
        success		:   function(aData) {  
                                            $("#loadFade").modal('hide');
                                            console.log("busqueda_pacientes_parametos ->",aData); 
                                        }, 
    });

    //alatarde
    /*
    if(txtBuscar!=''){
        var variables   =   {"txtBuscar":txtBuscar,"ed":ed}; 
        var id          =   "respuesta";
        var funcion     =   "TraeDatIng"; 
        AjaxExt(variables, id, funcion);
    }
    */
}


function busquedaPacientes(){
    $("#LISTA_PACIENTES").append("<tr><td colspan='8' style='text-align:center'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i><span class='sr-only'>Cargando...</span></td></tr>");
    $(".btn_listado_paciente").attr('onclick','');

    $.ajax({ 
        type            :   "POST",
        url             :   "ssan_hdial_ingresoegresopaciente/BusquedaPacientesIngreso",
        dataType        :   "json",
        data            :   { },
        beforeSend      :   function(xhr)   { },
        beforeSend      :   function(xhr)   { $('#loadFade').modal('show'); },
        error           :   function(errro) { 
                                                console.log(errro.responseText); 
                                                jAlert("Comuniquese con el administrador ","CLINICA LIBRE CHILE");
                                                $('#loadFade').modal('hide'); 
                                            },
        success         :   function(aData) {
                                                $("#LISTA_PACIENTES").html(""); 
                                                $('#loadFade').modal('hide'); 
                                                console.log("aData  ->  ",aData);
                                                if(AjaxExtJsonAll(aData)){  
                                                    //busquedaMaquinasDeDiaslisis();
                                                };
                                            }, 
    });
}

function busquedaMaquinasDeDiaslisis(){
    $.ajax({ 
        type            :   "POST",
        url             :   "ssan_hdial_ingresoegresopaciente/BusquedaMaquinasDeDialisis",
        dataType        :   "json",
        data            :   { },
        beforeSend      :   function(xhr)       { $('#loadFade').modal('show'); },
        error           :   function(errro)     {   
            
                                                    console.log(errro.responseText); 
                                                    jAlert("Comuniquese con el administrador ","CLINICA LIBRE CHILE");
                                                    $('#loadFade').modal('hide'); 
            
                                                },
        success         :   function(aData)     { 
                                                    $('#loadFade').modal('hide'); 
                                                    $("#LISTA_MAQUINA").html(""); 




                                                    if(AjaxExtJsonAll(aData)){  

                                                    }; 
                                                }, 
    });
}

function js_nuevo_prestador_dialisis(){
    $.ajax({ 
        type            :   "POST",
        url             :   "ssan_hdial_ingresoegresopaciente/get_nuevo_prestador_dialisis",
        dataType        :   "json",
        data            :   { },
        beforeSend      :   function(xhr)       {   $('#loadFade').modal('show');   },
        error           :   function(errro)     {     
                                                    console.log(errro.responseText); 
                                                    jAlert("Comuniquese con el administrador ","CLINICA LIBRE CHILE"); 
                                                    $('#loadFade').modal('hide');
                                                },
        success         :   function(aData)     {     
                                                    console.log("aData  ->  ",aData);
                                                    $('#loadFade').modal('hide');
                                                    $('#html_nuevo_prestador_rrhh').html(aData.out_html);
                                                    $("#modal_nuevo_prestador_rrhh").modal({backdrop:'static',keyboard:false}).modal("show");
                                                    $("#rut_profesional").focus();
                                                }, 
    });
}

function js_busqueda_rrhh(){
    $.ajax({ 
       type            :   "POST",
       url             :   "ssan_hdial_ingresoegresopaciente/html_lista_rrhhdialisis",
       dataType        :   "json",
       data            :   { },
       beforeSend      :   function(xhr)       {  $('#loadFade').modal('show'); },
       error           :   function(errro)     {     
                                                   console.log(errro);
                                                   console.log(errro.responseText); 
                                                   jAlert("Comuniquese con el administrador","CLINICA LIBRE CHILE"); 
                                                   $('#loadFade').modal('hide');
                                               },
       success         :   function(aData)     {
                                                   console.log("---------------------------------------");
                                                   console.log("aData      ->  ",aData);
                                                   console.log("---------------------------------------");

                                                   $('#loadFade').modal('hide');
                                                   $("#li_busqueda_rrhh").attr('onclick',''); 
                                                   $("#IND_RRHH").html(aData.html); 
                                                }, 
   });
}

function delete_profesional(cod_rutpro){
   //console.log("cod_rutpro     ->  ",cod_rutpro);
   jPrompt('Con esta acci&oacute;n eliminar&aacute; el RRHH de di&aacute;lisis &iquest;desea continuar? <br>','','Confirmaci\u00f3n',function (r) {
       console.error("password                    ->   ",r);
       if(r){ 
           $.ajax({ 
               type                                :   "POST",
               url                                 :   "ssan_hdial_ingresoegresopaciente/get_eliminar_user",
               dataType                            :   "json",
               beforeSend                          :   function(xhr)   {   console.log(xhr);   },
               data                                :   { 
                                                           contrasena      :   r,
                                                           cod_rutpro      :   cod_rutpro,
                                                       },
               error                               :   function(errro) { 
                                                                           console.error("errro                  ->",errro); 
                                                                           console.error("error.responseText     ->",errro.responseText);
                                                                           jError("Error General, Consulte Al Administrador","CLINICA LIBRE CHILE"); 
                                                                       },
               success                             :   function(aData) { 
                                                                           console.table("out      ->  ",aData);
                                                                           if(aData.status_firma){
                                                                               jAlert("Se elimin&oacute; RRHH","CLINICA LIBRE CHILE");
                                                                               js_busqueda_rrhh();
                                                                           } else {
                                                                               jError("Error en la firma simple","CLINICA LIBRE CHILE");
                                                                           }
                                                                       }, 
           });
       } else {
           //console.log("---------------------------------------");
           //console.log("   -> DIJO NO FIRMA SIMPLE <-          ");
           //console.log("---------------------------------------");
       }
   });
}

function js_nuevo_prestador_rrhh(){
   console.log("nuevo presta");
}

function valida_profesional(){
    var _rut        =   "";
    var rut_array   =   "";
    var rut2        =   "";
    var rut         =   "";
    var dv          =   "";
    _rut            =   $("#rut_profesional").val();
    if(_rut == ''){
       jError("RUN Vac&iacute;o","Clinica Libre");
       return false;
    }
    rut_array       =   _rut.split("-");
    rut2		    =   rut_array[0].replace(".","");
    rut			    =   rut2.replace(".","");
    dv			    =   rut_array[1];
    $.ajax({ 
       type		    :   "POST",
       url 		    :   "ssan_hdial_ingresoegresopaciente/fn_valida_profesional",
       dataType     :   "json",
       beforeSend	:   function(xhr)           {   
                                                    console.log(xhr);
                                                    $('#loadFade').modal('show');
                                                },
       data 		:                           {  
                                                    run : rut,
                                                    dv  : dv,
                                                },
       error		:   function(errro)         { 
                                                    console.log("quisas->",errro,"-error->",errro.responseText); 
                                                    $("#protocoloPabellon").css("z-index","1500"); 
                                                    jError("Error General, Consulte Al Administrador","CLINICA LIBRE CHILE"); 
                                                    $('#loadFade').modal('hide');
                                                },
       success		:   function(aData)         { 
                                                    $('#loadFade').modal('hide');
                                                    console.log("aData -> ",aData);
                                                    if(aData.ind_existe.length  > 0){
                                                        showNotification('top','center','Profesional RUN <b>'+$("#rut_profesional").val()+'</b>, Ya existe en RRHH',4,'fa fa-times');
                                                        $("#rut_profesional").val('');
                                                        return false;
                                                    } else {
                                                        $(".alert_profesional_no_existe").show();
                                                    }
                                                    if(aData.info_prof.length  == 0){
                                                        showNotification('top','center','RUN ingresado no existe como prestador en su establecimiento',4,'fa fa-times')
                                                        js_limpia_panel();
                                                    } else {
                                                        $("#numidentificador").html(aData.info_prof[0]['COD_RUTPRO']+'-'+aData.info_prof[0]['COD_DIGVER']);
                                                        $("#nombreLabel").html(aData.info_prof[0]['NOM_PROFE']);
                                                        $("#profesionLabel").html(aData.info_prof[0]['DES_TIPOATENCION']);
                                                        $(".grid_busqueda_rrhh").data().data = aData.info_prof;
                                                        $("#btn_guarda_infoxususario").attr('onclick','js_guarda_dialisis()');
                                                        $("#btn_guarda_infoxususario").prop('disabled',false);
                                                        $("#rut_profesional").prop('disabled',true);
                                                    }
                                                }, 
   });
}

function js_limpia_panel(){
    $("#numidentificador").html('');
    $("#nombreLabel").html('');
    $("#profesionLabel").html('');
    $(".grid_busqueda_rrhh").data().data = [];
    $("#btn_guarda_infoxususario").attr('onclick','');
    $("#btn_guarda_infoxususario").prop('disabled',true);
    $("#rut_profesional").prop('disabled',false);
    $(".alert_profesional_no_existe").hide();
}

function js_guarda_dialisis(){
   var info_prof               =   $(".grid_busqueda_rrhh").data('data')[0];
   jPrompt('Con esta acci&oacute;n se proceder&aacute; agregar RRHH en dialisis <br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if((r == '') || (r == null)){
            jError("Firma simple vac&iacute;a","CLINICA LIBRE CHILE");
        } else { 
           $.ajax({ 
               type		    :   "POST",
               url 		    :   "ssan_hdial_ingresoegresopaciente/record_rotulos_por_usuario",
               dataType     :   "json",
               beforeSend	:   function(xhr)       {   
                                                        console.log(xhr);
                                                        $('#loadFade').modal('show');
                                                    },
               data 		:                       {  
                                                        contrasena  :   r,
                                                        info_prof   :   info_prof,
                                                    },
               error		:   function(errro)     { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","CLINICA LIBRE CHILE"); 
                                                        $('#loadFade').modal('hide');
                                                    },
               success		:   function(aData)     {   
                                                        $('#loadFade').modal('hide');
                                                        console.log("aData -> ",aData);
                                                        if(aData.status_firma){
                                                            showNotification('top','center','Se agrego al RRHH de di&aacute;lisis',1,'fa fa-info');
                                                            $("#modal_nuevo_prestador_rrhh").modal("hide");
                                                            js_busqueda_rrhh();
                                                        }   else  {
                                                            jError('Contrase&ntilde;a inv&aacute;lida',"CLINICA LIBRE CHILE"); 
                                                        }
                                                    }, 
           });
       }
   });
}

//********************************************************************************
//code old
function busquedaPacientesxMaquina(){
   $("#PACIENTEXMAQUINA").html("");
   $.ajax({ 
       type            :   "POST",
       url             :   "ssan_hdial_ingresoegresopaciente/pacientexMaquina",
       dataType        :   "json",
       data            :   { },
       beforeSend      :   function(xhr)       { },
       error           :   function(errro)     {     
                                                   console.log(errro.responseText); 
                                                   jAlert("Comuniquese con el administrador ","CLINICA LIBRE CHILE"); 
                                               },
       success         :   function(aData)     {     
                                                   $("#PACIENTEXMAQUINA").html(""); 
                                                   if(AjaxExtJsonAll(aData)){  
                                                   }; 
                                               }, 
   });
}


function js_imprimiringeg(RSIND){
   $("#imp_Cod_cie10_1").html("");
   var variables       =   {"txtBuscar":RSIND}; //Variables pasadas por ajax a la funcion
   var id              =   "respuesta";
   var funcion         =   "TraeDatIng_IMP"; //Funcion del Controlador a Ejecutar 
   AjaxExt(variables,id,funcion);
}

function A_INGRESODIAL(numFichae){    
    $("#formulario_ing_enf").validate();
    //1. ANTECEDENTES PERSONALES_______________________________________
    var text_ant_qui            =   $("#text_ant_qui").val();
    var Rdo_infenf_Ant_Alerg    =   $('input[name="Rdo_infenf_Ant_Alerg"]:checked').val();
    var txt_Alimn               =   $("#txt_Alimn").val();
    var txt_Medicamnt           =   $("#txt_Medicamnt").val();
    var txt_Otrs                =   $("#txt_Otrs").val();
    var agrupadascie10          =   "";
    var Cie10Agrupados          =   new Array();
    $('[id^=Hd_Cie10_]').each(function () {  //Obtener valores de Diagnostico
        // arrpreg
        var objProducto         =   new Object();
        objProducto.h           =   $(this).attr('id');
        objProducto.h           =   objProducto.h.replace('Hd_Cie10_', '');
        objProducto.RespCie     =   $("#Hd_Cie10_" + objProducto.h).val();//lo que contesto
        agrupadascie10          +=  $("#Hd_Cie10_" + objProducto.h).val()+',';//lo que contesto
        Cie10Agrupados.push(objProducto);
    });
   
    //jAlert(agrupadascie10);
    var ERROR               =   '';
    var txt_Est_derUrg      =   $("#txt_Est_derUrg").val();                    
    var txt_grup_sang       =   $("#txt_grup_sang").val();                         
    var txt_eRre_H          =   $("#txt_eRre_H").val();                               
    
    //2.EXAMEN FISICO GENERAL
    var text_Pso            =   $("#text_Pso").val();                                      
    var text_eFeC           =   $("#text_eFeC").val();                                 
    var text_PeASis         =   $("#text_PeASis").val();                             
    var text_PeADis         =   $("#text_PeADis").val();                             
    var text_Tlla           =   $("#text_Tlla").val();                                 
    var text_Movlidad       =   $("#text_Movlidad").val();                        
    var text_Nutrcion       =   $("#text_Nutrcion").val();
    var text_Grad_conci     =   $("#text_Grad_conci").val();
    var text_Est_Pel        =   $("#text_Est_Pel").val();
    var text_Conjvas        =   $("#text_Conjvas").val();
    var text_Yugues         =   $("#text_Yugues").val();
    var text_Extrdes        =   $("#text_Extrdes").val();
    var text_Favv           =   $("#text_Favv").val();
    var text_Fech_Favv      =   $("#text_Fech_Favv").val();
    var text_Gortex         =   $("#text_Gortex").val();
    var text_Fech_Gortex    =   $("#text_Fech_Gortex").val();
    var text_Catter         =   $("#text_Catter").val();
    var text_Fech_Catter    =   $("#text_Fech_Catter").val();
    var Rdo_Diuesis         =   $('input[name="Rdo_Diuesis"]:checked').val();
    var text_Volmen_Diuesis =   $("#text_Volmen_Diuesis").val();
    var text_Hvvc           =   $("#text_Hvvc").val();
    var text_Fech_Hvvc      =   $("#text_Fech_Hvvc").val();
    var text_Hiiv           =   $("#text_Hiiv").val();
    var text_Fech_Hiiv      =   $("#text_Fech_Hiiv").val();
    var text_Hbssag         =   $("#text_Hbssag").val();
    var text_Fech_Hbssag    =   $("#text_Fech_Hbssag").val();
    
    //3. ANTECEDENTES HEMODIALISIS____________________________
    var text_QQB            =   $("#text_QQB").val();
    var Rdo_QQB             =   $('input[name="Rdo_QQB"]:checked').val();
    var text_1Dos_hvb       =   $("#text_1Dos_hvb").val();
    var text_QQD            =   $("#text_QQD").val();
    var text_Banno_QD       =   $("#text_Banno_QD").val();
    var text_2Dos_hvb       =   $("#text_2Dos_hvb").val();
    var text_PesoSco        =   $("#text_PesoSco").val();
    var text_Banno_QD       =   $("#text_Banno_QD").val();
    var text_3Dos_hvb       =   $("#text_3Dos_hvb").val();
    var text_1ref_hvb       =   $("#text_1ref_hvb").val();
    
    //4. OBSERVACIONES_____________________________________
    var text_4Obss          =   $("#text_4Obss").val();
    var text_Enfera         =   $("#text_Enfera").val();
    var text_Fech_Enfra     =   $("#text_Fech_Enfra").val();
   
   
   jPrompt('Con esta acc&oacute;n se proceder&aacute; a ingresar nuevo paciente al sistema de dialisis <br/>&iquest;Est&aacute; seguro de continuar?<br />', '',
       'Confirmaci\u00F3n',function(r){
           if((r=='')||(r==null)){

           } else {
               $.ajax({ 
                   type         :   "POST",
                   url          :   "ssan_hdial_ingresoegresopaciente/guardaNuevoPacienteIngreso",
                   dataType     :   "json",
                   beforeSend   :   function(xhr) { console.log(xhr);},
                   data         :   {   
                                        password    :   r,
                                        NumFichae   :   numFichae,
                                    },
                   error        :   function(errro) { 
                                                        jAlert("Error General, Consulte Al Administrador"); 
                                                        console.log(errro.responseText);  
                                                    },
                   success      :   function(aData) { 
                                                        if(aData[0]['validez']){
                                                            jAlert("Se ha realizado con exito","CLINICA LIBRE CHILE");
                                                        } else {
                                                            jError("Error de contraseña","CLINICA LIBRE CHILE");
                                                        }
                                                    }, 
               });      
           }
   });
   return false;
}

function js_turnosxmaquina(id){
   $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_hdial_ingresoegresopaciente/gestormaquinaxturno",
        dataType    :   "json",
        beforeSend  :   function(xhr){ },
        data 		:   { ID_MAQUINA : id },
        error		:   function(errro){ alert(errro.responseText); },
        success		:   function(aData){ 
                                            if(AjaxExtJsonAll(aData)){ 
                                                $("#TURNOXMAQUINA").modal("show"); 
                                                $("#NOM_MAQUINA").html("TURNO->"+$("#nom_"+id).val()); 
                                            };
                                        }, 
   });
}

function egresar(id,numfichae){
   $("#TURNOXMAQUINA").modal("show");
   $.ajax({ 
       type		:   "POST",
       url 		:   "ssan_hdial_ingresoegresopaciente/controller_egresopaciente",
       dataType        :   "json",
       beforeSend      :   function(xhr) { },
       data 		:   { 
                               ID          : id, 
                               numfichae   : numfichae,
                               NOMBRE_PAC  : $("#nombre_"+id).val(),
                               EDAD        : $("#edad_"+id).val(),
                               RUT_PAC     : $("#rut_"+id).val(),
                               CELULAR     : $("#telefono_"+id).val(),
                           },
       error		:   function(errro){ alert(errro.responseText); },
       success		:   function(aData){ 
                               if(AjaxExtJsonAll(aData)){  
                                   $("#NOM_MAQUINA").html("EGRESO PACIENTE"); 
                               }; 
                           }, 
   });
}

function asigarCupo(MKN,GRP,TRN){
   //MAQUINA UNICA MKN
   //GRP = TURNO UNICO
   //TRN = GRUPO MANANA - TARDE
   $.ajax({ 
       type		:   "POST",
       url 		:   "ssan_hdial_ingresoegresopaciente/addcupoPaciente",
       dataType        :   "json",
       beforeSend      :   function(xhr) { console.log(xhr); },
       data 		:   { MKN : MKN , GRP : GRP },
       error		:   function(errro){ alert(errro.responseText); },
       success		:   function(aData){ 
                               if(AjaxExtJsonAll(aData)){
                                   
                               }; 
                           }, 
   });
   $("#NUEVOPACIENTEXCUPO").attr('onclick','NUEVOPACIENTEXCUPO('+MKN+','+GRP+','+TRN+')'); 
   $("#PACIENTEXCUPO").modal("show");
}

function iEnfermeria(ID_INGRESO,NUM_FICHAE){
   console.log(ID_INGRESO);
   console.log(NUM_FICHAE);
}

function NUEVOPACIENTEXCUPO(MKN,GRP,TRN){
   var arreglo_dias   = new Array();
       $("#idPaciente").css("border-color","");
   if ($("#idPaciente").val()=='0'){
       $("#idPaciente").css("border-color","red");
       jError("Asignar Paciente","CLINICA LIBRE CHILE");
       return false;
   }
   //console.log(MKN);
   //console.log(GRP);
   //console.log(TRN);
   var idval       = "MKN_"+MKN+"_"+TRN;
   //console.log(idval);
   $('[id^='+idval+']').each(function(index,value){
      // console.log("---------------");
       console.log(value.value);
       arreglo_dias.push({txtdia: value.value});        
   });
 
   //**************************************************************************
   jPrompt('Con esta acc&oacute;n se proceder&aacute; a ingresar nuevo paciente al cupo designado <br/>&iquest;Est&aacute; seguro de continuar?<br />', '',
           'Confirmaci\u00F3n',function(r){
           if((r=='')||(r==null)){
               console.log("-----------");
           } else {
               $.ajax({ 
                   type            : "POST",
                   url             : "ssan_hdial_ingresoegresopaciente/guardaPacientexCupo",
                   dataType        : "json",
                   beforeSend      : function(xhr) { console.log(xhr); },
                   data            :   {   
                                           password    : r,
                                           datoPac     : $("#idPaciente").val(),
                                           MKN         : MKN,
                                           GRP         : GRP,
                                           DIAS        : arreglo_dias
                                       },
                   error           : function(errro){ jAlert("Error General, Consulte Al Administrador"); console.log(errro.responseText);  },
                   success         : function(aData){ 
                                           //console.log(aData[3]['sql']);
                                           if(aData[0]['validez']){
                                               jAlert("Se ha realizado con exito","CLINICA LIBRE CHILE",function(r){  
                                                   console.log("--->"); console.log(r);
                                                   $("#PACIENTEXCUPO").modal("hide");   
                                                   busquedaPacientes(2);
                                               });
                                           } else {
                                               jError("Error de contrase&ntilde;a","CLINICA LIBRE CHILE");
                                           }
                                       }, 
               });      
           }
   });
}

function E_INGRESODIAL(numIgreso,numfichae){
   var id_egreso = $("#num_egreso").val();
       $("#num_egreso").css("border-color","");
   if (id_egreso==''){
       $("#num_egreso").css("border-color","red");
       jError("Seleccione Tipo de Egreso","CLINICA LIBRE CHILE");
       return false;
   }
   
   jPrompt('Con esta acc&oacute;n se proceder&aacute; a egresar paciente <br/>&iquest;Est&aacute; seguro de continuar?<br />', '',
           'Confirmaci\u00F3n',function(r){
           if((r=='')||(r==null)){
               console.log("-----------");
           } else {
               $.ajax({ 
                   type            : "POST",
                   url             : "ssan_hdial_ingresoegresopaciente/EgresaPaciente",
                   dataType        : "json",
                   beforeSend      : function(xhr) { console.log(xhr); },
                   data            :   {   
                                           password    : r,
                                           numIgreso   : numIgreso,
                                           numfichae   : numfichae,
                                           id_egreso   : id_egreso,
                                       },
                   error           : function(errro){ jAlert("Error General, Consulte Al Administrador"); console.log(errro.responseText);  },
                   success         : function(aData){ 
                                           //console.log(aData[3]['sql']);
                                           if(aData[0]['validez']){
                                               jAlert("Se ha realizado con exito","CLINICA LIBRE CHILE",function(r){  
                                                   console.log("--->"); console.log(r);
                                                   $("#TURNOXMAQUINA").modal("hide");   
                                                   busquedaPacientes(2);
                                               });
                                           } else {
                                               jError("Error de contrase&ntilde;a","CLINICA LIBRE CHILE");
                                           }
                                       }, 
               });      
           }
   });
}

function liberarCupo(ID_CUPO,MKN,TRN){
   jPrompt('Con esta acc&oacute;n se proceder&aacute; a eliminar cupo designado <br/>&iquest;Est&aacute; seguro de continuar?<br />', '',
           'Confirmaci\u00F3n',function(r){
           if((r=='')||(r==null)){
               console.log("-----------");
           } else {
               $.ajax({ 
                   type            : "POST",
                   url             : "ssan_hdial_ingresoegresopaciente/eliminaPacientexCupo",
                   dataType        : "json",
                   beforeSend      : function(xhr) { console.log(xhr); },
                   data            :   {   
                                           password    : r,
                                           ID_CUPO     : ID_CUPO,
                                           MKN         : MKN,
                                           TRN         : TRN
                                       },
                   error           : function(errro){ jAlert("Error General, Consulte Al Administrador"); console.log(errro.responseText);  },
                   success         : function(aData){ 
                                           //console.log(aData[3]['sql']);
                                           if(aData[0]['validez']){
                                               jAlert("Se ha realizado con exito","CLINICA LIBRE CHILE",function(r){  
                                                   console.log("--->"); console.log(r);
                                                   //$("#PACIENTEXCUPO").modal("hide");   
                                                   busquedaPacientes(2);
                                               });
                                           } else {
                                               jError("Error de contrase&ntilde;a","CLINICA LIBRE CHILE");
                                           }
                                       }, 
               });      
           }
   });
}

function asigarTurno(MKN,GRP){
   console.log(MKN);
   console.log(GRP);
}

function js_idPac(value){
   console.log(value);
}


function Cod_o_Text(num){
    if(num == 1){
        var nomcie10    =   $('#nomcie10').val(); 
        if(nomcie10==""){
            $('#resp_Cancer_59').val('');  
        }
    }
    if(num == 2){//diagnostico cie10
        var nomcie102   =   $('#nomcie102').val(); 
        if(nomcie102==""){
            $('#resp_Cancer_60').val('');  
        }
    }
}

function onClickDiagnostico2(codigo, descripcion,cod,gs) {
 var ges='<img  style="width: 30px;padding-bottom: 3px;" src="assets/ssan_seleccionarinterconsulta/img/ges.png"><input type="hidden" value="1" id="1s_g_es">';
    if( $("#Hd_Cie10_"+cod).val() ){
        //alert("siiii");
    }else{
        if(gs==0){ ges='';}
        $("<tr id='TR_Cie10_"+cod+"'><td style='background-color: #bff1ff; border: solid 1px #7bc2d6;'> "+descripcion+ges+"  <input type='hidden' value='"+cod+"'  id='Hd_Cie10_"+cod+"'> </td><td><a style='padding: 1px;background-color: #c91f25;' class='btn btn-small btn-success' onclick='EliminaFilaCie10("+cod+");select_2();'><i class='fa fa-times icon-large'></i></a></td></tr>"  ).appendTo("#Cod_cie10_1");
        $('.autocompletar2').val('');
        $('.autocomplete-jquery-results').hide();
    }
}

function EliminaFilaCie10(idcod){
    $("#TR_Cie10_"+idcod).remove();
    if( $("#1s_g_es").val() ){
        //alert("siiii");
    }else{
        // alert("noooooou");
        $("#Rdo_Ges_0").prop("checked", true);
    }
}

function grabaform(){//segundo formularpo
    $("#Frm_notif_reac_adv").validate();
                   
    var Sl_Hipo_sion1= $("#Sl_Hipo_sion1").val();       console.log("-"+Sl_Hipo_sion1); 
    var Sl_Hipo_sion2= $("#Sl_Hipo_sion2").val();       console.log("-"+Sl_Hipo_sion2);     
    var Sl_Hipo_sion3= $("#Sl_Hipo_sion3").val();       console.log("-"+Sl_Hipo_sion3);
    var Sl_Ca_frio1= $("#Sl_Ca_frio1").val();           console.log("-"+Sl_Ca_frio1);
    var Sl_Ca_frio2= $("#Sl_Ca_frio2").val();           console.log("-"+Sl_Ca_frio2);
    var Sl_Ca_frio3= $("#Sl_Ca_frio3").val();           console.log("-"+Sl_Ca_frio3);
    var Sl_F_bre1= $("#Sl_F_bre1").val();               console.log("-"+Sl_F_bre1);
    var Sl_F_bre2= $("#Sl_F_bre2").val();               console.log("-"+Sl_F_bre2);
    var Sl_F_bre3= $("#Sl_F_bre3").val();               console.log("-"+Sl_F_bre3);
    var Sl_Inf_catt1= $("#Sl_Inf_catt1").val();         console.log("-"+Sl_Inf_catt1);
    var Sl_Inf_catt2= $("#Sl_Inf_catt2").val();         console.log("-"+Sl_Inf_catt2);
    var Sl_Inf_catt3= $("#Sl_Inf_catt3").val();         console.log("-"+Sl_Inf_catt3);
    var Sl_Bact_meia1= $("#Sl_Bact_meia1").val();       console.log("-"+Sl_Bact_meia1);
    var Sl_Bact_meia2= $("#Sl_Bact_meia2").val();       console.log("-"+Sl_Bact_meia2);
    var Sl_Bact_meia3= $("#Sl_Bact_meia3").val();       console.log("-"+Sl_Bact_meia3);
    var Sl_Hep_b1= $("#Sl_Hep_b1").val();               console.log("-"+Sl_Hep_b1);
    var Sl_Hep_b2= $("#Sl_Hep_b2").val();               console.log("-"+Sl_Hep_b2);
    var Sl_Hep_b3= $("#Sl_Hep_b3").val();               console.log("-"+Sl_Hep_b3);
    var Sl_Hep_c1= $("#Sl_Hep_c1").val();               console.log("-"+Sl_Hep_c1);
    var Sl_Hep_c2= $("#Sl_Hep_c2").val();               console.log("-"+Sl_Hep_c2);
    var Sl_Hep_c3= $("#Sl_Hep_c3").val();               console.log("-"+Sl_Hep_c3);
    var Sl_mrtes_pro1= $("#Sl_mrtes_pro1").val();       console.log("-"+Sl_mrtes_pro1);
    var Sl_mrtes_pro2= $("#Sl_mrtes_pro2").val();       console.log("-"+Sl_mrtes_pro2);
    var Sl_mrtes_pro3= $("#Sl_mrtes_pro3").val();       console.log("-"+Sl_mrtes_pro3);
    
    jPrompt('Con esta acci&oacute;n se proceder&aacute; a realizar el registro de datos.<br /><br />&iquest;Est&aacute; seguro de continuar?', '', 'Confirmaci\u00f3n', function (r) {
       if (r) {  
           var variables = {"Clave": r,
               "Sl_Hipo_sion1":Sl_Hipo_sion1,
               "Sl_Hipo_sion2":Sl_Hipo_sion2,
               "Sl_Hipo_sion3":Sl_Hipo_sion3,
               "Sl_Ca_frio1":Sl_Ca_frio1,
               "Sl_Ca_frio2":Sl_Ca_frio2,
               "Sl_Ca_frio3":Sl_Ca_frio3,
               "Sl_F_bre1":Sl_F_bre1,
               "Sl_F_bre2":Sl_F_bre2,
               "Sl_F_bre3":Sl_F_bre3,
               "Sl_Inf_catt1":Sl_Inf_catt1,
               "Sl_Inf_catt2":Sl_Inf_catt2,
               "Sl_Inf_catt3":Sl_Inf_catt3,
               "Sl_Bact_meia1":Sl_Bact_meia1,
               "Sl_Bact_meia2":Sl_Bact_meia2,
               "Sl_Bact_meia3":Sl_Bact_meia3,
               "Sl_Hep_b1":Sl_Hep_b1,
               "Sl_Hep_b2":Sl_Hep_b2,
               "Sl_Hep_b3":Sl_Hep_b3,
               "Sl_Hep_c1":Sl_Hep_c1,
               "Sl_Hep_c2":Sl_Hep_c2,
               "Sl_Hep_c3":Sl_Hep_c3,
               "Sl_mrtes_pro1":Sl_mrtes_pro1,
               "Sl_mrtes_pro2":Sl_mrtes_pro2,
               "Sl_mrtes_pro3":Sl_mrtes_pro3
           }
            var id          =   "respuesta";
            var funcion     =   "Graba_Respuesta_2"; //Funcion del Controlador a Ejecutar
            AjaxExt(variables, id, funcion);
            $('#confirmar').prop('disabled', true);
       }});
    return false;
}

function selec_(rdo,num){
    $("#Resp_IngEnf_Dial_"+rdo).val(num);
    
    if(rdo==542 && num==1){//si
        //$("#TR_Aliments").show();
        //$("#TR_Medicamnts").show();
        //$("#Tr_Otrss").show();
        //         
        //$("#Resp_IngEnf_Dial_543").show();
        //$("#Resp_IngEnf_Dial_544").show();
        //$("#Resp_IngEnf_Dial_545").show();
        var res543=$("#r_espuesta_543_old").val();
        var res544=$("#r_espuesta_544_old").val();
        var res545=$("#r_espuesta_545_old").val();
        $("#Resp_IngEnf_Dial_543").removeAttr('disabled');    $("#Resp_IngEnf_Dial_543").val(res543);   
        $("#Resp_IngEnf_Dial_544").removeAttr('disabled');     $("#Resp_IngEnf_Dial_544").val(res544);
        $("#Resp_IngEnf_Dial_545").removeAttr('disabled');      $("#Resp_IngEnf_Dial_545").val(res545);
    }
   
    if(  (rdo==542 && (num==2 || num==3)) ){//no  - no sabe
        //$("#Resp_IngEnf_Dial_543").hide();
        //$("#Resp_IngEnf_Dial_544").hide();
        //$("#Resp_IngEnf_Dial_545").hide();
        //$("#TR_Aliments").hide();
        //$("#TR_Medicamnts").hide();
        //$("#Tr_Otrss").hide();
        $("#Resp_IngEnf_Dial_543").val("");   $("#Resp_IngEnf_Dial_543").attr('disabled', 'disabled');
        $("#Resp_IngEnf_Dial_544").val("");       $("#Resp_IngEnf_Dial_544").attr('disabled', 'disabled');
        $("#Resp_IngEnf_Dial_545").val("");      $("#Resp_IngEnf_Dial_545").attr('disabled', 'disabled');
    }
}

function select_2(){
    var Tiene='';
    $('[id^=TR_Cie10_]').each(function () {  //Obtener valores de Diagnostico   
        var objProducto = new Object();
        objProducto.h = $(this).attr('id');
        objProducto.h = objProducto.h.replace('TR_Cie10_', '');
        objProducto.Resp_IngEnf_Dial_ = $("#TR_Cie10_" + objProducto.h).val();//lo que contesto       
        Tiene=1;
    });  
    if(Tiene==1){
        $("#Resp_IngEnf_Dial_546").val(1);
    } else {
        $("#Resp_IngEnf_Dial_546").val(0);
    }
}

function grab(ed){
    $("#formulario_ing_enf").validate();
    var fic_e= $("#fic_e").val();     
    console.log("-"+fic_e);
    var mensaje='';
    var Resp_IngEnf_Dial = new Array();
    $('[id^=Resp_IngEnf_Dial_]').each(function(){  //Obtener valores de Diagnostico   
    var objProducto = new Object();
        objProducto.h = $(this).attr('id');
        objProducto.h = objProducto.h.replace('Resp_IngEnf_Dial_', '');
        objProducto.Resp_IngEnf_Dial_ = $("#Resp_IngEnf_Dial_" + objProducto.h).val();//lo que contesto     
        mensaje+="<br>N: "+objProducto.h+" ---> RESPUESTA: "+$("#Resp_IngEnf_Dial_" + objProducto.h).val();
        Resp_IngEnf_Dial.push(objProducto);
    });  

    //jAlert(mensaje);
    //return false;
    //var agrupadascie10="";
    var Cie10Agrupados = new Array();
    $('[id^=Hd_Cie10_]').each(function () {  //Obtener valores de Diagnostico
        // arrpreg
        var objProducto = new Object();
        objProducto.h = $(this).attr('id');
        objProducto.h = objProducto.h.replace('Hd_Cie10_', '');
        objProducto.RespCie = $("#Hd_Cie10_" + objProducto.h).val();//lo que contesto
        //agrupadascie10+=$("#Hd_Cie10_" + objProducto.h).val()+',';//lo que contesto
        Cie10Agrupados.push(objProducto);
    });     
    //console.log("-"+agrupadascie10);


    jPrompt('Con esta acci&oacute;n se proceder&aacute; a realizar el registro de datos.<br /><br />&iquest;Est&aacute; seguro de continuar?', '', 'Confirmaci\u00f3n', function (r) {
        if (r){
            var variables = {
                "ed":ed,
                "Clave"             :   r,
                "fic_e"             :   fic_e,
                "Resp_IngEnf_Dial"  :   Resp_IngEnf_Dial,
                "Cie10Agrupados"    :   Cie10Agrupados,     
                "fec_histo"         :   $("#numFecha").val(),
            }
        var id          =   "respuesta";
        var funcion     =   "Graba_Respuesta"; //Funcion del Controlador a Ejecutar
        AjaxExt(variables, id, funcion);
        $('#confirmar').prop('disabled', true);
    }});
   return false;
}

function Limpiar1(){  
    // $("#Rut_form").val("");
    $("#fic_e").val("");
    //$("#resultadoBusqueda_post").html('');
    $("#nomcie10").val('');
    $("#Cod_cie10_1").html('');
    $("#Resp_IngEnf_Dial_546").val(0);

    //1. ANTECEDENTES PERSONALES_______________________________________
    $(".limp").val("");//todos los cuadros de texto          
    $("#Rdo_infenf_Ant_Alerg_1").prop('checked', false);
    $("#Rdo_infenf_Ant_Alerg_2").prop('checked', false);
    $("#Rdo_infenf_Ant_Alerg_3").prop('checked', false);
    $("#Rdo_Diuesis_1").prop('checked', false);
    $("#Rdo_Diuesis_2").prop('checked', false);
    $("#Rdo_QQB_1").prop('checked', false);
    $("#Rdo_QQB_2").prop('checked', false);
}

function imprimePdrf() {   
   $("#imp__imprimePdfIng").show();
   $("#imp__imprimePdfIng").printArea();
   $("#imp__imprimePdfIng").hide();
   return false;
   var fe=$("#fic_e").val();
   //aparecer el boton de firmar///
   var id          = "respuesta"; //Div o ID de los resultados
   var funcion     = "index"; //Funcion del Controlador a Ejecutar
   var variables   = {"fe":fe}; //Variables pasadas por ajax a la funcion
   AjaxExt(variables,id, funcion, '', 'Pdf_ing_paciente'); //Funcion que Ejecuta la llamada del ajax 
}

function js_pdfHTML2(IDHOJADIARIA){
   var histo ='<iframe src="pabellon_classpdf/formatohojadiaria?id='+IDHOJADIARIA+$("#TOKEN_PDF").val()+'" frameborder="0" style="overflow:hidden;height:500px;width:100%;"></iframe>';
   $("#li_hoja_finalizadas2").show();
   $("#div_TERMINO_HOJADIARIAS").html(histo);
}

function cargaCalendario(num_fichae){
   js_cBUSQUEDAHANTERIOR(num_fichae,2);
}

function js_cBUSQUEDAHANTERIOR(num_fichae,val){
   //console.log($("#busquedaMes").val());
   $.ajax({
       url         :   "ssan_hdial_asignacionpaciente/cargaHDanteriores",
       type        :   "POST",
       dataType    :   "json",
       data        :   
                       {
                           num_fichae      : num_fichae,
                           historico       : 1,
                           nuevo           : val,
                           fecha           : $("#sel_busquedaMes").val()
                       },
       error       :   function(errro){ console.log(errro.responseText); console.log(errro); jError("Comuniquese con el administrador ","CLINICA LIBRE CHILE"); },              
       success     :   function(xml) { if (AjaxExtJsonAll(xml)){ 
                           $("#MODAL_HD_ANTERIORES").modal("show");  
                           }; 
                       }
   });
}

function iPesoseco(numfichae){
   $.ajax({
       url         :   "ssan_hdial_asignacionpaciente/iMedico_PesoSeco",
       type        :   "POST",
       dataType    :   "json",
       data        :   {
                           numfichae      : numfichae,
                       },
       error       :   function(errro){ 
                           console.log(errro.responseText); 
                           console.log(errro); 
                           jError("Comuniquese con el administrador ","CLINICA LIBRE CHILE"); 
                       },              
       success     :   function(xml) { 
                           if (AjaxExtJsonAll(xml)){ 
                               $("#MODAL_INFOHOJADIARIA").modal("show");  
                               $("#btn_guardar").attr('onclick','guardarInfo('+numfichae+')');   
                           }; 
                       }
   });
}

function guardarInfo(numfichae){
   jPrompt('Con esta acc&oacute;n se proceder&aacute; a guardar informacion para que aparezca en hoja diaria del paciente <br/>&iquest;Est&aacute; seguro de continuar?<br />', '',
           'Confirmaci\u00F3n',function(r){
           if((r=='')||(r==null)){
               console.log("-----------");
           } else {
               $.ajax({ 
                   type            :   "POST",
                   url             :   "ssan_hdial_asignacionpaciente/guardaInformacionimedico",
                   dataType        :   "json",
                   beforeSend      :   function(xhr) { console.log(xhr); },
                   data            :   {   
                                           password    : r,
                                           numfichae   : numfichae,
                                           form        : $("#Formimedico").serializeArray(),
                                       },
                   error           :   function(errro){ jAlert("Error General, Consulte Al Administrador"); console.log(errro.responseText);  },
                   success         :   function(aData){ 
                                           //console.log(aData[3]['sql']);
                                           if(aData[0]['validez']){
                                               jAlert("Se ha realizado con exito","CLINICA LIBRE CHILE",function(r){  
                                                  $("#MODAL_INFOHOJADIARIA").modal("hide"); 
                                               });
                                           } else {
                                               jError("Error de contrase&ntilde;a","CLINICA LIBRE CHILE");
                                           }
                                       }, 
               });      
           }
   });
}

function num(e){
   var key = window.Event ? e.which : e.keyCode;
   return (key >= 48 && key <= 57);
}

function num_coma(e, field) {
   var key = e.keyCode ? e.keyCode : e.which
   ///console.log(key);
   // backspace
   if (key == 8) return true
   // 0-9
   if (key > 47 && key < 58) {
     if (field.value == "") return true
     regexp = /.[0-9]{2}$/
     return !(regexp.test(field.value))
   }
 // .
 if (key == 44) {
   if (field.value == "") return false
   regexp = /^[0-9]+$/
   return regexp.test(field.value)
 }
 // other key
 return false
}

function cal_fecha(value,i){
   console.log(value);
   var f               =   new Date();
   var fechaAlrevez    =   value.split("-");
   var fecha           =   fechaAlrevez[2]+"-"+fechaAlrevez[1]+"-"+fechaAlrevez[0];
   var fecha1          =   moment(fecha);
   var fecha2          =   moment(f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate() );
   $("#num_dias_"+i).html(fecha2.diff(fecha1,'days'), ' d');
}

function checkDecimals(fieldName, fieldValue) {
   decallowed          =   2; // how many decimals are allowed?
   if (isNaN(fieldValue) || fieldValue == "") {
       console("El número no es válido. Prueba de nuevo.");
       fieldName.select();
       fieldName.focus();
   } else {
   if (fieldValue.indexOf('.') == -1) fieldValue += ".";
   dectext = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);

   if (dectext.length > decallowed)  {
       alert ("Por favor, entra un número con " + decallowed + " números decimales.");
       fieldName.select();
   fieldName.focus();
   } else {
       console.log("Número validado satisfactoriamente.");
       }
   }
}

function doSearch(num) {
   var tableReg = document.getElementById('LISTA_PACIENTES');//donde muestra
   var searchText = document.getElementById('searchTermIng2').value.toLowerCase();//txt a buscar
   for (var i = 0; i < tableReg.rows.length; i++) {
       var cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
       var found = false;
       for (var j = 0; j < cellsOfRow.length && !found; j++) {
           var compareWith = cellsOfRow[j].innerHTML.toLowerCase();
           if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1)) {
               found = true;
           }
       }
       if (found) {
           tableReg.rows[i].style.display = '';
       } else {
           tableReg.rows[i].style.display = 'none';
       }
   }
}