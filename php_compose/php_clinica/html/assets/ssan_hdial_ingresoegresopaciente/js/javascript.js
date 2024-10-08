$(document).ready(function(){

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

    $('#MODAL_HD_ANTERIORES').on('show.bs.modal',     function(e){ 

    });

    $('#MODAL_HD_ANTERIORES').on('hidden.bs.modal',   function(e){ 
        $("#BODY_HD_ANTERIORES").html(" "); 
        $("#busquedaMes").html("");
    });

    $('#MODAL_INFOHOJADIARIA').on('show.bs.modal',     function(e){ 

    });
    
    $('#MODAL_INFOHOJADIARIA').on('hidden.bs.modal',   function(e){ 
        $("#BODY_INFOHOJADIARIA").html(""); 
        $("#busquedaMes").html("");
    });
    
    $('#modal_nuevo_prestador_rrhh').on('hidden.bs.modal',   function(e){ 
        $("#html_nuevo_prestador_rrhh").html('');
        $("#btn_guarda_infoxususario").attr('onclick','');
        $("#btn_guarda_infoxususario").prop('disabled',true);
    });

    $('#modal_nuevo_ingreso_paciente').on('hidden.bs.modal',function(e){ 
        js_limpiaingreso();
        $("#rut_paciente").val('');
    });

    $('#rut_paciente').Rut({
        format_on   :   'keyup',
        on_error    :   function(){ jError("RUN no es correcto","CLINICA LIBRE CHILE"); },
        on_success  :   function(){ 
            console.log("  this -> ",this);
            console.log(this.id);
            //js_grabadatosPaciente(); 
        },
    });

});

function nuevoPacienteAgresado(){
    $("#modal_nuevo_ingreso_paciente").modal({backdrop:'static',keyboard:false}).modal("show");
}

function js_limpiaingreso(){
    $(".div_pacienteindentificado,.formulario_ingreso").html('');
}

function js_grabadatosPaciente(){    
    if ($("#rut_paciente").val() == ''){ jAlert("RUN del paciente vacio","CLINICA LIBRE CHILE"); return false; }
    let Rut_form     =    $("#rut_paciente").val().replace(/\./g,'').split("-");//11111111-0    
    let txtBuscar    =    Rut_form[0];
    let txtDv        =    Rut_form[1];
    let lficha       =    '';
    //console.log("  -----------------------------   ");
    //console.log("  txtBuscar   ->  ",txtBuscar,"   ");
    //console.log("  txtDv       ->  ",txtDv,"       ");
    //console.log("  -----------------------------   ");
    $.ajax({ 
        type		:  "POST",
        url 		:  "ssan_hdial_ingresoegresopaciente/busqueda_pacientes_parametos",
        dataType    :  "json",
        beforeSend  :  function(xhr){ $('#loadFade').modal('show'); },
        data 		:  { 
                            OPCION  :   1,
                            RUTPAC  :   txtBuscar,
                            RUTDV   :   txtDv,
                            LFICHA  :   lficha,
                        },
        error		:   function(errro) {  
                                            console.log(errro);
                                            jAlert("Comuniquese con el administrador","CLINICA LIBRE CHILE");
                                            $("#loadFade").modal('hide'); 
                                        },
        success		:   function(aData) {  
                                            $("#loadFade").modal('hide');
                                            $(".formulario_ingreso,.div_pacienteindentificado").html('');
                                            console.log("aData  ->  ",aData);
                                            if(aData.status){
                                                if (aData.b_existe_ingreso){
                                                    jError("Paciente ya tiene ingreso activo","Clinica Libre");
                                                    $("#rut_paciente").val('');
                                                } else {
                                                    showNotification('top','center','<i class="fa fa-check" aria-hidden="true"></i>&nbsp; Nuevo ingreso de paciente a hermodialisis',2,'');
                                                    $(".div_pacienteindentificado").html(aData.html_card_paciente);
                                                    $(".formulario_ingreso").html(aData.html_card_formularioingreso);
                                                }
                                            } else {
                                                showNotification('top','center','<i class="bi bi-exclamation-square-fill"></i>&nbsp;Paciente no ingresado a su BDU pacientes',4,'');
                                            }
                                        }, 
    });
}

function busquedaPacientes(){
    $.ajax({ 
        type            :   "POST",
        url             :   "ssan_hdial_ingresoegresopaciente/BusquedaPacientesIngreso_v2",
        dataType        :   "json",
        data            :   { },
        beforeSend      :   function(xhr)   {   $("#LISTA_PACIENTES").html("<tr><td colspan='8' style='text-align:center'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i><span class='sr-only'>Cargando...</span></td></tr>"); },
        beforeSend      :   function(xhr)   {   $('#loadFade').modal('show');   },
        error           :   function(errro) { 
                                                console.log(errro.responseText); 
                                                jAlert("Comuniquese con el administrador","CLINICA LIBRE CHILE");
                                                $('#loadFade').modal('hide'); 
                                            },
        success         :   function(aData) {
                                                console.log("aData -> ",aData);
                                                $('#loadFade').modal('hide'); 
                                                $("#LISTA_PACIENTES").html(aData.html); 
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

//********
//code old
//********
function busquedaPacientesxMaquina(){
    //$("#PACIENTEXMAQUINA").html("");
    $("#loadFade").modal('show');
    $.ajax({ 
       type            :   "POST",
       url             :   "ssan_hdial_ingresoegresopaciente/pacientexMaquina",
       dataType        :   "json",
       data            :   { },
       beforeSend      :   function(xhr)       { },
       error           :   function(errro)     {     
                                                   console.log(errro.responseText); 
                                                   jAlert("Comuniquese con el administrador ","CLINICA LIBRE CHILE"); 
                                                   $("#loadFade").modal('hide');
                                               },
       success         :   function(aData)     {     
                                                    console.log("aData  ->  ",aData);
                                                    $("#loadFade").modal('hide');
                                                    $("#listado_maquinasporpaciente").html(aData.html); 
                                                    //if(AjaxExtJsonAll(aData)){ };
                                               }, 
   });
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
    $("#modal_egresa_paciente").modal({backdrop:'static',keyboard:false}).modal("show"); 
    $.ajax({ 
       type		    :   "POST",
       url 		    :   "ssan_hdial_ingresoegresopaciente/controller_egresopaciente",
       dataType     :   "json",
       beforeSend   :   function(xhr) { },
       data 		:   { 
                               ID          :    id, 
                               numfichae   :    numfichae,
                               NOMBRE_PAC  :    $("#nombre_"+id).val(),
                               EDAD        :    $("#edad_"+id).val(),
                               RUT_PAC     :    $("#rut_"+id).val(),
                               CELULAR     :    $("#telefono_"+id).val(),
                           },
       error		:   function(errro)     {   jAlert(errro.responseText); },
       success		:   function(aData)     { 
                                                console.log("aData  ->  ",aData);
                                                $("#html_egresa_paciente").html(aData.html);
                                            }, 
    });
}

function asigarCupo(MKN,GRP,TRN){
    //  MAQUINA UNICA MKN
    //  GRP = TURNO UNICO
    //  TRN = GRUPO MANANA - TARDE
    $("#PACIENTEXCUPO").modal({backdrop:'static',keyboard:false}).modal("show"); 
    $.ajax({ 
       type		        :   "POST",
       url 		        :   "ssan_hdial_ingresoegresopaciente/addcupoPaciente",
       dataType         :   "json",
       beforeSend       :   function(xhr) { $('#HTML_PACIENE').html('<div class="spinner-border text-primary" role="status"></div>'); },
       data 		    :   { MKN : MKN , GRP : GRP },
       error		    :   function(errro){    jAlert(errro.responseText); },
       success		    :   function(aData){ 
                                                $("#NUEVOPACIENTEXCUPO").attr('onclick','NUEVOPACIENTEXCUPO('+MKN+','+GRP+','+TRN+')'); 
                                                $("#HTML_PACIENE").html(aData.html);
                                            }, 
    });
}


function NUEVOPACIENTEXCUPO(MKN,GRP,TRN){
    var arreglo_dias   = new Array();
        $("#idPaciente").css("border-color","");
    if ($("#idPaciente").val()=='0'){
        $("#idPaciente").css("border-color","red");
        jError("Asignar Paciente","E-sissan");
        return false;
    }
    var idval       = "MKN_"+MKN+"_"+TRN;
    $('[id^='+idval+']').each(function(index,value){
       // console.log("---------------");
        console.log(value.value);
        arreglo_dias.push({txtdia: value.value});        
    });

    jPrompt('Con esta acc&oacute;n se proceder&aacute; a ingresar nuevo paciente al cupo designado <br/>&iquest;Est&aacute; seguro de continuar?<br />','','Confirmaci\u00F3n',function(r){
        if((r=='')||(r==null)){
            console.log("-----------");
        } else {
            $.ajax({ 
                type            :   "POST",
                url             :   "ssan_hdial_ingresoegresopaciente/guardaPacientexCupo",
                dataType        :   "json",
                beforeSend      :   function(xhr)   { 
                                                        $('#NUEVOPACIENTEXCUPO').prop('disabled',true);
                                                        $(".spinner_btn").show();
                                                    },
                data            :   {   
                                        password    :   r,
                                        datoPac     :   $("#idPaciente").val(),
                                        MKN         :   MKN,
                                        GRP         :   GRP,
                                        DIAS        :   arreglo_dias
                                    },
                error           :   function(errro){    
                                                        console.log(errro); 
                                                        jAlert("Error General, Consulte Al Administrador");  
                                                        $('#NUEVOPACIENTEXCUPO').prop('disabled',false);
                                                        $(".spinner_btn").hide();
                                                    },
                success         :   function(aData){ 
                                                        $('#NUEVOPACIENTEXCUPO').prop('disabled',false);
                                                        $(".spinner_btn").hide();
                                                        if(aData.status){
                                                            $("#PACIENTEXCUPO").modal("hide");   
                                                            busquedaPacientesxMaquina();
                                                            jAlert("Se ha realizado con &eacute;xito","Clinica Libre",function(r){ });
                                                        } else {
                                                            jError("Error de contrase&ntilde;a","Clinica Libre");
                                                        }
                                                    }, 
            });
        }
    });
}

function iEnfermeria(ID_INGRESO,NUM_FICHAE){
    console.log(ID_INGRESO);
    console.log(NUM_FICHAE);
}
 
function NUEVOPACIENTEXCUPO_OLD(MKN,GRP,TRN){
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
    jFirmaUnica('Con esta acc&oacute;n se proceder&aacute; a ingresar nuevo paciente al cupo designado <br/>&iquest;Est&aacute; seguro de continuar?<br />','','Confirmaci\u00F3n',function(obj_salida){
        console.log("obj_salida   -> ",obj_salida);
        let txt_firma               =   obj_salida.v_run;
        let v_pass                  =   obj_salida.v_pass;
        let status_run              =   obj_salida.status_run;
        console.log("txt_firma      ->  ",txt_firma);
        console.log("v_pass         ->  ",v_pass);
        console.log("status_run     ->  ",status_run);
        if((txt_firma=='')||(txt_firma==null)){
            console.log("-----------");
        } else {
            console.log(" obj_salida ");
                /*
                $.ajax({ 
                    type            :    "POST",
                    url             :    "ssan_hdial_ingresoegresopaciente/guardaPacientexCupo",
                    dataType        :    "json",
                    beforeSend      :    function(xhr) { console.log(xhr); },
                    data            :    {   
                                            password    :   r,
                                            datoPac     :   $("#idPaciente").val(),
                                            MKN         :   MKN,
                                            GRP         :   GRP,
                                            DIAS        :   arreglo_dias
                                        },
                    error           :    function(errro)    {   
                                                                console.log(errro); 
                                                                jAlert("Error General, Consulte Al Administrador"); 
                                                            },
                   success         :    function(aData) { 
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
               */
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
   jPrompt('Con esta acc&oacute;n se proceder&aacute; a egresar paciente <br/>&iquest;Est&aacute; seguro de continuar?<br />','','Confirmaci\u00F3n',function(r){
           if((r=='')||(r==null)){
               console.log("-----------");
           } else {
               $.ajax({ 
                   type            :    "POST",
                   url             :    "ssan_hdial_ingresoegresopaciente/EgresaPaciente",
                   dataType        :    "json",
                   beforeSend      :    function(xhr) { console.log(xhr); },
                   data            :    {   
                                           password    :    r,
                                           numIgreso   :    numIgreso,
                                           numfichae   :    numfichae,
                                           id_egreso   :    id_egreso,
                                        },
                   error           :    function(errro)    {   
                                                            console.log(errro); 
                                                            jAlert("Error General, Consulte Al Administrador"); 
                                                        },
                   success         :    function(aData)    {
                                                            console.log("aData  ->  ",aData);
                                                            if(aData.validez){
                                                                jAlert("Se ha realizado con exito","CLINICA LIBRE CHILE",function(r){  
                                                                    console.log("--->"); console.log(r);
                                                                    $("#modal_egresa_paciente").modal("hide");   
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
    
    console.log("   ------------------------------------------  ");
    console.log("   ID_CUPO    ->  ",ID_CUPO,"                  ");
    console.log("   MKN        ->  ",MKN,"                      ");
    console.log("   TRN        ->  ",TRN,"                      ");
    console.log("   ------------------------------------------  ");

    jPrompt('Con esta acc&oacute;n se proceder&aacute; a eliminar cupo designado <br/>&iquest;Est&aacute; seguro de continuar?<br />','','Confirmaci\u00F3n',function(r){
        if((r=='')||(r==null)){
            console.log("-----------");
        } else {
            $.ajax({ 
                type            : "POST",
                url             : "ssan_hdial_ingresoegresopaciente/eliminaPacientexCupo",
                dataType        : "json",
                beforeSend      : function(xhr) {     $("#loadFade").modal('show');  console.log(xhr); },
                data            :   {   
                                        password :   r,
                                        ID_CUPO  :   ID_CUPO,
                                        MKN      :   MKN,
                                        TRN      :   TRN
                                    },
                error           : function(errro){ jAlert("Error General, Consulte Al Administrador"); console.log(errro);  $("#loadFade").modal('hide');},
                success         : function(aData){ 
                                        console.log(aData);
                                        $("#loadFade").modal('hide');
                                        busquedaPacientesxMaquina();
                                        if(aData.validez){
                                            jAlert("Se ha realizado con &eacute;xito","CLINICA LIBRE CHILE",function(r){ });
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
    $('#loadFade').modal('show'); 
    $.ajax({
       url         :   "ssan_hdial_ingresoegresopaciente/calendario_hermodialisis",
       type        :   "POST",
       dataType    :   "json",
       data        :    {
                            num_fichae  :   num_fichae,
                            historico   :   1,
                            nuevo       :   val,
                            //fecha     :   $("#sel_busquedaMes").val()
                        },
       error       :   function(errro)  { 
                                            console.log(errro);
                                            $('#loadFade').modal('hide');  
                                            jError("Comuniquese con el administrador ","CLINICA LIBRE CHILE"); 
                                        },              
       success     :   function(aData)  { 
                                            $('#loadFade').modal('hide');
                                            console.log("aData  ->  ",aData);
                                            if (aData.status){

                                            } else {
                                                showNotification('top','center','<i class="bi bi-exclamation-square-fill"></i>&nbsp;&nbsp;Paciente no cuenta con hojas iniciadas',4,'');
                                            }
                                        }
    });
}

function iPesoseco(numfichae){
    console.log("numfichae  ->  ",numfichae);
    $('#loadFade').modal('show'); 
    $.ajax({
       url         :   "ssan_hdial_ingresoegresopaciente/iMedico_PesoSeco",
       type        :   "POST",
       dataType    :   "json",
       data        :   {
                           numfichae      : numfichae,
                       },
       error       :   function(errro)  { 
                                            console.log(errro); 
                                            $('#loadFade').modal('hide'); 
                                            jError("Comuniquese con el administrador ","CLINICA LIBRE CHILE"); 
                                        },              
       success     :   function(aData) {
                                            console.log("   ->  ",aData);
                                            $('#loadFade').modal('hide'); 
                                            if (aData.status){
                                                $("#MODAL_INFOHOJADIARIA").modal({backdrop:'static',keyboard:false}).modal("show"); 
                                                $("#BODY_INFOHOJADIARIA").html(aData.html);
                                                $("#btn_guardar").attr('onclick','guardarInfo('+numfichae+')');
                                            }
                                        }
   });

}

function guardarInfo(numfichae){
    let arr_infomedico = $("#Formimedico").serializeArray();
    console.log("arr_infomedico  -> ",arr_infomedico);
    jPrompt('Con esta acc&oacute;n se proceder&aacute; a guardar informacion para que aparezca en hoja diaria del paciente <br/>&iquest;Est&aacute; seguro de continuar?<br />', '','Confirmaci\u00F3n',function(r){
        console.log(" - ",r);
        if((r=='')||(r==null)){
            console.log("-----------");
        } else {
            $('#loadFade').modal('show'); 
            $.ajax({ 
                type        :   "POST",
                url         :   "Ssan_hdial_ingresoegresopaciente/guardaInformacionimedico_2",
                dataType    :   "json",
                beforeSend  :   function(xhr) { console.log(xhr); },
                data        :   {   
                                    contrasena   :   r,
                                    numfichae    :   numfichae,
                                    form         :   arr_infomedico,
                                },
                error       :   function(errro) {   console.log(errro);  jAlert("Error General, Consulte Al Administrador");  $('#loadFade').modal('hide');  },
                success     :   function(aData) {
                                                    console.log("   --------------------------  ");
                                                    console.log("   aData  ->  ",aData);
                                                    $('#loadFade').modal('hide');
                                                    if(aData.status){
                                                        jAlert("Se ha realizado con &eacute;xito","CLINICA LIBRE CHILE",function(r){  
                                                            $("#MODAL_INFOHOJADIARIA").modal("hide"); 
                                                        });
                                                    } else {
                                                        showNotification('top','center','<i class="bi bi-exclamation-square-fill"></i>&nbsp;&nbsp;Firma simple incorrecta',4,'');
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
   //console.log(value);
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

function js_cambio_atencedentes(){
    let value = $("#ingreso_enfe_antenecentealergia").val();
    if (value == 1){
        $("#txt_alimento_alergia,#txt_medicamento_alergia,#txt_otro_alergia").prop('disabled',false);
    } else {
        $("#txt_alimento_alergia,#txt_medicamento_alergia,#txt_otro_alergia").prop('disabled',true).val('');
    }
}

function js_imprimiringeg(ID_FORMULARIO,ID_INGRESO){
    $("#modal_informes_pdf").modal({backdrop:'static',keyboard:false}).modal("show");
    //return false;
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_hdial_ingresoegresopaciente/pdf_ingresoenfermeria",
        dataType    :   "json",
        beforeSend  :   function(xhr)       {   
                                                console.log("generando PDF");
                                                $('#html_informes_pdf').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span>');
                                            },
        data 		:                       { 
                                                ID_FORMULARIO : ID_FORMULARIO,
                                                ID_INGRESO : ID_INGRESO
                                            },
        error		:   function(errro)     { 
                                                console.log("quisas->",errro,"-error->",errro.responseText); 
                                                $("#protocoloPabellon").css("z-index","1500"); 
                                                jError("Error General, Consulte Al Administrador","e-SISSAN"); 
                                                $('#html_informes_pdf').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                            },
        success		:   function(aData)     { 
                                                console.log("aData  ->  ",aData);
                                                if(aData.status){
                                                    var base64str = aData.base64_pdf;
                                                    var binary = atob(base64str.replace(/\s/g, ''));
                                                    var len = binary.length;
                                                    var buffer = new ArrayBuffer(len);
                                                    var view = new Uint8Array(buffer);
                                                    for (var i = 0; i < len; i++) { view[i] = binary.charCodeAt(i); }
                                                    var blob = new Blob([view], { type: "application/pdf" });
                                                    var blobURL = URL.createObjectURL(blob);
                                                    // Crear el elemento 'object' para visualizar el PDF
                                                    var Objpdf = document.createElement('object');
                                                    Objpdf.data = blobURL;
                                                    Objpdf.width = '100%';
                                                    Objpdf.style.height = '700px';
                                                    Objpdf.title = 'PDF';
                                                    // Crear un enlace para descargar
                                                    var downloadLink = document.createElement('a');
                                                    downloadLink.href = blobURL;
                                                    downloadLink.download = "nombre_personalizado.pdf"; // Asignar un nombre de archivo personalizado aquí
                                                    downloadLink.textContent = 'Descargar PDF';
                                                    downloadLink.className = 'btn btn-primary'; // Añadir clases de estilos si es necesario
                                                    // Limpiar el contenedor y agregar el objeto PDF y el enlace de descarga
                                                    var container = $('#html_informes_pdf');
                                                    container.html(''); // Limpiar el contenido anterior
                                                    container.append(Objpdf);
                                                    container.append('<br>'); // Añadir un espacio entre el PDF y el botón
                                                    container.append(downloadLink);
                                                } else {
                                                    jError("error al cargar protocolo PDF","e-SISSAN");
                                                }
                                            }, 
    });
}

function ini_form_ingreso(){
    let timer;
    $("#resultadosBusqueda").autocomplete({
        source      :   [], // Fuente inicial vacía
        autoFocus   :   true,
        minLength   :   3,
        select      :   function(event,ui)  {
                                                console.log("ui.item        :   ",ui.item);
                                                $(".sin_resultadocie10").remove();
                                                let html_li = add_li_diagnostico(ui.item);
                                                $("#ind_ciediez_selecionados").append(html_li);
                                                setTimeout(function(){ $("#resultadosBusqueda").val(''); },0);
                                            },
    }).autocomplete("instance")._renderItem = function(ul,item){
        var term    =   this.term.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
        var re      =   new RegExp("(" + term + ")", "gi");
        var t       =   item.label.replace(re, "<b>$1</b>");
        return $("<li>").append("<div>" + t + "</div>").appendTo(ul);
    };
    $('#resultadosBusqueda').on('keyup',function(e){
        let valorInput  = $(this).val().trim();
        if (valorInput.length >= 3) {
            realizarBusqueda(valorInput);
        } else {
            $("#resultadosBusqueda").autocomplete("option", "source", []);
        }
    });
}

function add_li_diagnostico(_value){
    //console.log("***********************************");
    //console.log("_value -> ",_value);
    var nuevaTarjeta    =   `<li class="list-group-item item_cie10 item_`+_value.value+`" id="`+_value.value+`">
                                <div class="grid_cieselecionados">
                                    <div class="grid_cieselecionados2">`+_value.label+`</div>
                                    <div class="grid_cieselecionados3">
                                        <button type="button" class="btn btn-danger btn-xs btn_small" id="item_`+_value.value+`" onclick="js_deletecie(this.id)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>`;
    return nuevaTarjeta;
}

function js_deletecie(_id){
    console.log("delete -> ",_id);
    $("."+_id).remove();
    let v_aux = 0;
    $("#ind_ciediez_selecionados li").each(function(index, element) {  console.log(index + ": " + $(element).text());  v_aux++;  });
    if (v_aux == 0){ $("#ind_ciediez_selecionados").append('<li class="list-group-item sin_resultadocie10"><b><i>SIN CIE-10 SELECCIONADOS</i></b></li>');  }
}

function realizarBusqueda(query) {
    $.ajax({
        type        :   "POST",
        url         :   "ssan_hdial_ingresoegresopaciente/busqueda_informacion_cie10",
        dataType    :   "json",
        data        :   { query: query },
        error       :   function(error) {
                                            console.log(error);
                                            jAlert("Comuniquese con el administrador", "CLINICA LIBRE CHILE");
                                            $('#resultadosBusqueda').prop('disabled', false);
                                        },
        success     :   function(aData) {
                                            console.log("busqueda_informacion_cie10 ->", aData);
                                            if (aData.status && aData.resultados.length > 0) {
                                                let datosAutocomplete = aData.resultados.map(function(item) {
                                                    return {
                                                        label : item.CODIGO_DG_BASE + ' : ' + item.DESCRIPCION,
                                                        value : item.ID
                                                    };
                                                });
                                                $("#resultadosBusqueda").autocomplete("option", "source", datosAutocomplete);
                                                $("#resultadosBusqueda").autocomplete("search", $("#resultadosBusqueda").val().trim());
                                            } else {
                                                $("#resultadosBusqueda").autocomplete("option", "source", []);
                                            }
                                        },
    });
}

function clearTimeout(){
    setTimeout(function() {
        //console.log("Este mensaje se muestra después de 2 segundos");
    }, 300);
}

var idsDeElementos = [
    'fecha_ingreso',
    'cboFactorSangre',
    'cboGrupoSangre',
    'fecha_diuresis',
    'fecha_fav',
    'fecha_gorotex',
    'fecha_hbsag',
    'fecha_hiv',
    'ingreso_enfe_antenecentealergia',
    'num_frecuenciacardiaca',
    'num_kilogramos',
    'num_presionsistolica',
    'nun_presiondistolica',
    'txt_talla',
    'slc_diuresis',
    'txt_2da_dosis_hvb',
    'txt_3da_dosis_hvb',
    'txt_alimento_alergia',
    'txt_antecedente_qx',
    'txt_antecenteshermo_concentrado',
    'txt_antecenteshermo_pesoseco',
    'txt_antecenteshermo_qb',
    'txt_antecenteshermo_qd',
    'txt_bano_kna',
    'txt_cateter',
    'fecha_cateter',
    'txt_dosis_refuerzo_hvb',
    'txt_dosisi_hvb',
    'txt_ef_conjuntivas',
    'txt_ef_estadodelapiel',
    'txt_ef_extremidades',
    'txt_ef_gradoconciencia',
    'txt_ef_movilidad',
    'txt_ef_nutricion',
    'txt_ef_yugulares',
    'txt_fav',
    'txt_gorotex',
    'txt_hbsag',
    'txt_hepatina_i',
    'txt_hepatina_m',
    'txt_hiv',
    'txt_hvc',
    'fecha_hvc',
    'txt_medicamento_alergia',
    'txt_observaciones_finales',
    'txt_otro_alergia',
    'txt_persona_urgencia'
];

function js_guarda_ingreso(){
    let arr_envio       =   {};
    let arr_codcie10    =   [];
    let v_error         =   [];
    let v_num_fichae    =   $("#num_fichae").val();
    idsDeElementos.forEach(function(id) {
        let elemento    =   document.getElementById(id);
        $("#" + id).removeClass('class_input_error');
        if (elemento && elemento.disabled) {
            // Elemento deshabilitado, no se agrega.
        } else {
            if (elemento && elemento.value.trim() === "") {
                $("#" + id).addClass('class_input_error');
                v_error.push(id);
            } else {
                let v_texto     =   '';
                if (elemento.type === 'date'){
                    let arr_fecha = $("#" + id).val().split("-");
                    v_texto     =   arr_fecha[2]+'-'+arr_fecha[1]+'-'+arr_fecha[0];
                } else {
                    v_texto     =   $("#" + id).val();
                }
                arr_envio[id]   =   v_texto;
            }
        }
    });
    $(".item_cie10").each(function(index, element){ arr_codcie10.push(element.id); });
    if (v_error.length > 0 || arr_codcie10.length == 0) {
        showNotification('top', 'center','<i class="bi bi-clipboard-x-fill"></i>&nbsp;Existe informaci&oacute;n incompleta en el registro',4,'');
    } else {
        
        console.log("   ---------------------------------------------       ");
        console.log("       formulario entrada  ->   ", arr_envio,"         ");
        console.log("       arr_codcie10        ->   ", arr_codcie10,"      ");
        console.log("       v_num_fichae        ->   ", v_num_fichae,"      ");
        console.log("   ---------------------------------------------       ");

        jPrompt('Con esta acc&oacute;n se proceder&aacute; a ingresar nuevo paciente al sistema de di&aacute;lisis <br/>&iquest;Est&aacute; seguro de continuar?<br />','','Confirmaci\u00F3n',function(r){
            if((r=='')||(r==null)){
                console.log("   ------  ");
            } else {
                $.ajax({
                    type        :   "POST",
                    url         :   "ssan_hdial_ingresoegresopaciente/fn_guarda_ingresohermodialisis",
                    dataType    :   "json",
                    beforeSend  :   function(xhr) { $('#loadFade').modal('show'); },
                    data        :   {
                                        contrasena          :   r,
                                        v_num_fichae        :   v_num_fichae,
                                        arr_envio           :   arr_envio, 
                                        arr_codificacion    :   arr_codcie10,
                                    },
                    error       :   function(error) {
                                                        $("#loadFade").modal('hide');
                                                        console.log(error);
                                                        jAlert("Comun&iacute;quese con el administrador", "CLINICA LIBRE CHILE");
                                                    },
                    
                    success     :   function(aData) {
                                                        $("#loadFade").modal('hide');
                                                        console.log("fn_guarda_ingresohermodialisis ->", aData);
                                                        let v_numero_unico = aData.v_num_unico;
                                                        if(aData.status){
                                                            //showNotification('top','center','<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Realizado con &eacute;xito',2,'');
                                                            $("#modal_nuevo_ingreso_paciente").modal('hide');
                                                            busquedaPacientes()
                                                            jConfirm('<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Realizado con &eacute;xito - &iquest;desea Impimir informe?','ANATOM&Iacute;A PATOL&Oacute;GICA',function(r) {
                                                                if(r){
                                                                    js_imprimiringeg(v_numero_unico);
                                                                } else {

                                                                }
                                                            });
                                                        } else {
                                                            showNotification('top','center','<i class="bi bi-exclamation-square-fill"></i>&nbsp;&nbsp;Firma simple incorrecta',4,'');
                                                        }
                                                    },
                });

            }
        });
    }
}


