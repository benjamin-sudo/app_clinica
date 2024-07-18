$(document).ready(function() {
    var todayDate       =   new Date().getDate();
    console.log("---------------------------------------");
    console.log("todayDate  =>  ",todayDate,"   <=      ");
    console.log("---------------------------------------");
    /*
    $("#datetimepicker1").datetimepicker({
       format          :   'DD-MM-YYYY',
       //minDate       :   new Date(new Date().setDate((todayDate)-(5))), 
       maxDate         :   new Date(),
       locale          :   'es-us',
       icons           : 
                           {
                               time        :   "fa fa-clock-o"       ,
                               date        :   "fa fa-calendar"      ,
                               up          :   "fa fa-chevron-up"    ,
                               down        :   "fa fa-chevron-down"  ,
                               previous    :   "fa fa-chevron-left"  ,
                               next        :   "fa fa-chevron-right" ,
                               today       :   "fa fa-screenshot"    ,
                               clear       :   "fa fa-trash"         ,
                               close       :   "fa fa-remove"        ,
                           }
    }).on('dp.change',function(e){ 
        var MKN                     =   $("#num_Maquina").val();;
        eventosBuscar(MKN);
        console.log("------------------datetimepicker----------------------");
        console.log("e              ->  ",e);
        var formatedValue           =   e.date.format(e.date._f);  
        console.log("formatedValue  ->  ",formatedValue); 
        console.log("               ->  ",$("#numFecha").val()); 
        console.log("------------------datetimepicker----------------------");
    });
    */

    $('#MODAL_PDF').on('show.bs.modal',                 function(e){ });
    $('#MODAL_PDF').on('hidden.bs.modal',               function(e){ 
        $('.main-panel').perfectScrollbar('destroy');
        document.getElementById("MODAL_HORADIARIA").style.overflowY = 'auto';
    });

    $('#MODAL_TOMADESIGNO').on('show.bs.modal',         function(e){ });
    $('#MODAL_TOMADESIGNO').on('hidden.bs.modal',       function(e){ 
        $("#BODY_TOMASIGNO").html(" "); 
        $("#BTN_GSIGNOS").attr('onclick',''); 
        $('.main-panel').perfectScrollbar('destroy');
        document.getElementById("MODAL_HORADIARIA").style.overflowY = 'auto';
    });

    $('#MODAL_CIERREHERMO').on('show.bs.modal',         function(e){ });
    $('#MODAL_CIERREHERMO').on('hidden.bs.modal',       function(e){ 
        $("#BODY_CIERREHERMO").html(" "); 
        $("#BTN_CIERREHERMO").attr('onclick',''); 
        $('.main-panel').perfectScrollbar('destroy');
        document.getElementById("MODAL_HORADIARIA").style.overflowY = 'auto';
    });
    $('#MODAL_HD_ANTERIORES').on('show.bs.modal',       function(e){ });
    $('#MODAL_HD_ANTERIORES').on('hidden.bs.modal',     function(e){ 
        $("#BODY_HD_ANTERIORES").html(" "); 
        $("#busquedaMes").html("");
        $('.main-panel').perfectScrollbar('destroy');
        document.getElementById("MODAL_HORADIARIA").style.overflowY = 'auto';
    });
    $('#MODAL_EXM_ANTERIORES').on('show.bs.modal',      function(e){ 
        console.log("e->",e); 
    });
    $('#MODAL_EXM_ANTERIORES').on('hidden.bs.modal',    function(e){ 
        $("#BODY_EXM_ANTERIORES").html(" "); 
        $("#busquedaMes_EXM").html("");
        $('.main-panel').perfectScrollbar('destroy');
        document.getElementById("MODAL_HORADIARIA").style.overflowY = 'auto';
    });
    $('#MODAL_HORADIARIA').on('show.bs.modal',          function(e){ 
        //$('.modal .modal-body').css('overflow-y','auto'); 
        //var _height     =   $(window).height()*0.8;
        //$('.modal .modal-body').css('max-height',_height);
        console.log("------> MODAL_HORADIARIA show<---------    -> ",$("#MODAL_HORADIARIA").data('hojaactiva'));
    });
        
    $('#MODAL_HORADIARIA').on('hidden.bs.modal',        function(e){
        $("#txt_prohoja").html(""); 
        $("#HTML_TRATAMIENTO").html(""); 
        $("#MODAL_HORADIARIA").data().hojaactiva        = '';
        console.log("------> MODAL_HORADIARIA hide <---------   ->",$("#MODAL_HORADIARIA").data('hojaactiva'));
        /*$("#Btn_guardar3").attr('onclick',''); */  
    });
    $('#MODAL_INICIODIALIS').on('show.bs.modal',        function(e){ 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
        $('.modal .modal-body').css('overflow-x','auto'); 
    });
    $('#MODAL_INICIODIALIS').on('hidden.bs.modal',      function(e){ 
        $("#BTN_INICIO").attr('onclick',''); 
        $("#HTML_INICIODEDIALISIS").html(" ");    
    });
    console.log("showNotification");
    //showNotification('top','center','RUN ingresado no existe como prestador en su establecimiento',4,'fa fa-times');
    $("#maquina_1").append('<tr><td colspan="6"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">&nbsp;&nbsp;CARGANDO PACIENTE ...</span></td></tr>');
    //cargaMaquinas(1);
    //star_websocket_hoja_dialisis();
    let v_fecha = $('#numFecha').val();
    cargaPacientes(v_fecha);
});

function cargaPacientes(fecha){
    if(fecha==''){  jError("Selecione Fecha valida ...","Clinica Libre");  return false;  }
    $("#maquina_1").html('');
    var loding      ='<tr><td colspan="6"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">&nbsp;&nbsp;CARGANDO PACIENTE ... </span></td></tr>';
    $("#maquina_1").append(loding);
    var txt =   txt_fecha(fecha);
    $("#fecha_busqueda").html('<b class="plomo">'+txt+'</b>');
    /*
    console.log(    "------------------------------------------------------");
    console.log(    "fecha              ->  ",fecha,"<-                    ");
    console.log(    "num_Maquina        ->  ",$("#num_Maquina").val(),"<-  ");
    console.log(    "id_templete        ->  ",$("#id_templete").val(),"<-  ");
    console.log(    "------------------------------------------------------");
    */
    $('#loadFade').modal('show'); 
    $.ajax({
        url         :   "ssan_hdial_hojatratamiento/cargaCalendarioPacientesHT",
        type        :   "POST",
        dataType    :   "json",
        data        :                   {
                                            ind_template    :   2,
                                            fecha           :   fecha,
                                            MesWork         :   '',
                                            num_Maquina     :   $("#num_Maquina").val(),
                                            templete        :   $("#id_templete").val(),
                                        },
        error       :   function(errro){ 
                                            console.log(errro.responseText); 
                                            console.log(errro); 
                                            jError("Comuniquese con el administrador ","E-SISSAN");
                                            $('#loadFade').modal('hide'); 
                                        },              
        success     :   function(xml)   {      
                                            if (AjaxExtJsonAll(xml)){
                                                $('#loadFade').modal('hide'); 
                                            }
                                        }
    });
}

function cargaMaquinas(i){
    var fecha       =   '';
    if($("#op_fecha_especial").val() == '' || $("#op_fecha_especial").val() == 'undefined' || $("#op_fecha_especial").val() == null){
       fecha       =   $('#numFecha').val();
    } else {
       fecha       =   $('#op_fecha_especial').val();  
    }
    console.log("------------------------------------------");
    console.log("fecha         -> ",fecha);
    console.log("cargaMaquinas -> ",i);
    $.ajax({
        url         :   "ssan_hdial_asignacionpaciente/cargaMaquinas",
        type        :   "POST",
        dataType    :   "json",
        data        :   {
                            ind_template    :   1,
                            val             :   i
                        },
        error       :   function(errro)     { 
                                                console.log(errro.responseText); 
                                                console.log(errro); 
                                                jError("Comuniquese con el administrador","E-SISSAN"); 
                                            },              
        success     :   function(xml)       { 
                                                console.log(xml); 
                                                if(AjaxExtJsonAll(xml)){ 
                                                    cargaPacientes(fecha); 
                                                }; 
                                            }
    });
 }
 

function checkA(id,value){
   if($("#"+id).prop('checked')){
       //console.log("CHECK");
       js_disabled_medica(true);
   } else {
       //console.log("NO CHECK");
       js_disabled_medica(false);
   }
}

function checkA(id,value){
   if($("#"+id).prop('checked')){
       //console.log("CHECK");
       js_disabled_medica(true);
   } else {
       //console.log("NO CHECK");
       js_disabled_medica(false);
   }
}

function js_disabled_medica(i){
   $("#TXT_ACCESOVAS_1").prop("disabled",i);
   $("#FEC_DIAS_1").prop("disabled",i);
   $("#TXT_ACCESOVAS_2").prop("disabled",i);
   $("#FEC_DIAS_2").prop("disabled",i);
   $("#NUM_ARTERIAL").prop("disabled",i);
   $("#NUM_VENOSO").prop("disabled",i);
   $("#NUM_INICIO").prop("disabled",i);
   $("#NUM_MANTENCION").prop("disabled",i);
   $("#NUM_QT").prop("disabled",i);
   $("#NUM_QB").prop("disabled",i);
   $("#NUM_QD").prop("disabled",i);
   $("#NUM_UFMAX").prop("disabled",i);
   $("#NUM_UFMAX_UM").prop("disabled",i);
   $("#NUM_K").prop("disabled",i);
   $("#NUM_NA").prop("disabled",i);
   $("#NUM_CONCENTRADO").prop("disabled",i);
   $("#OBS_MEDICAS").prop("disabled",i);
}

function txt_fecha(get_fecha){
    var arr_fecha               =   get_fecha.split('-');
    var nom_dias                =   [
                                       'DOMINGO',
                                       'LUNES',
                                       'MARTES',
                                       'MI&Eacute;RCOLES',
                                       'JUEVES',
                                       'VIERNES',
                                       'S&Aacute;BADO'
                                   ];
    var numeroDia               =   new Date(arr_fecha[0]+'-'+arr_fecha[1]+'-'+arr_fecha[2]+" 23:59:59").getDay();
    var nombreDia               =   nom_dias[numeroDia];
    var fecha                   =   new Date(arr_fecha[0],arr_fecha[1],arr_fecha[2]);
    var options                 =   {
                                       year    :   'numeric', 
                                       month   :   'long', 
                                       day     :   'numeric' 
                                   };
    return nombreDia+' '+fecha.toLocaleDateString("es-ES",options).toUpperCase();
}

function js_formReacionesad(hd){
   $.ajax({
       url         :   "ssan_hdial_asignacionpaciente/cargahtmlRelacionesAdversas",
       type        :   "POST",
       dataType    :   "json",
       data        :   
                       {
                           ind_template    : 1,
                           hd              : hd
                       },
       error       :   function(errro){ 
                                           console.log(errro.responseText); 
                                           console.log(errro); 
                                           jError("Comuniquese con el administrador ","E-SISSAN"); 
                                       },              
       success     :   function(xml){ if (AjaxExtJsonAll(xml)){  }; }
   });
   $("#TURNO_REACIONESADVERSAS").modal("show");
}

function js_inicioProgama(NUMFICHAE,NUM_CITA,IDHOJADIARIA,OPMEDIC){
    var fecha       =   '';
    if($("#op_fecha_especial").val() == '' || $("#op_fecha_especial").val() == 'undefined' || $("#op_fecha_especial").val() == null){
       fecha       =   $('#numFecha').val();
    } else {
       fecha       =   $('#op_fecha_especial').val();  
    }
    $.ajax({
       url         :   "ssan_hdial_asignacionpaciente/cargahtmlHojaDiaria_new",
       type        :   "POST",
       dataType    :   "json",
       beforeSend  :   function(xhr)     {  $('#loadFade').modal('show');   },
       data        :   {
                           NUM_CITA        :   NUM_CITA,
                           NUMFICHAE       :   NUMFICHAE,
                           IDHOJADIARIA    :   IDHOJADIARIA,
                           namePaciente    :   $("#name_"+IDHOJADIARIA).val(),
                           num_Maquina     :   $("#num_Maquina").val(),
                           templete        :   $("#id_templete").val(),
                           OPMEDIC         :   OPMEDIC,
                           fechaHD         :   fecha,
                       },
       error       :   function(errro)     {   
                                               console.log(errro); 
                                               jError("Error en aplicativo","CLINICA LIBRE"); 
                                               $('#loadFade').modal('hide'); 
                                           },              
       success     :   function(aData)     {
                                                console.log("--------------------------------");
                                                console.log("aData => ",aData);
                                                $('#loadFade').modal('hide'); 
                                                $('#HTML_TRATAMIENTO').html(aData.html);
                                                $('#MODAL_HORADIARIA').modal({backdrop:'static',keyboard:false}).modal("show").data().hojaactiva = IDHOJADIARIA;
                                                /*
                                                if(AjaxExtJsonAll(aData)){
                                                   console.log("add numero activo");
                                                   $('#MODAL_HORADIARIA').data().hojaactiva = IDHOJADIARIA;
                                                }
                                                */
                                           }
   });
}

function js_primeraDatosProgramacion(NUMFICHAE){
    $('#loadFade').modal('show'); 
    $.ajax({
       url         :   "ssan_hdial_asignacionpaciente/cargahtmlcarga",
       type        :   "POST",
       dataType    :   "json",
       beforeSend  :   function(xhr) {    },
       data        :   {
                           NUMFICHAE       :   NUMFICHAE,
                           num_Maquina     :   $("#num_Maquina").val(),
                       },
       error       :   function(errro)     { 
                                               console.log(errro.responseText); /*$("#respuesta").html();*/ 
                                               jError("Comuniquese con el administrador ","CLINICA LIBRE"); 
                                               $('#loadFade').modal('hide'); 
                                            },              
       success     :   function(aData)     { 
                                                console.log("-------------------------------------");
                                                console.log("aData  ->  ",aData);
                                                console.log("-------------------------------------");
                                                $('#loadFade').modal('hide'); 
                                                if(AjaxExtJsonAll(aData['TABLA'])){
                                                   if(aData['STATUS']){
                                                        console.error("selectpicker");
                                                        $(".selectpicker").selectpicker();
                                                        $("#BTN_INICIO").attr('onclick','guardarPrimeraProgramacion('+NUMFICHAE+')');
                                                        $('#MODAL_INICIODIALIS').modal({backdrop:'static',keyboard:false}).modal("show");
                                                   } else {
                                                       eventosBuscar($("#num_Maquina").val());
                                                   }
                                                } 
                                           }
   });
}

//inicio js_signovitales
function guardarPrimeraProgramacion(NUMFICHAE){
   var aDatosVacios        = new Array();
   if($("#hd_anterior").val()          == '-'){    $("#hd_anterior").val('0');         };
   if($("#pesopredialisis").val()      == '-'){    $("#pesopredialisis").val('0');     };
   if($("#alza_interdialisis").val()   == '-'){    $("#alza_interdialisis").val('0');  };
   var aData1                          =           $('#formulario_histo').serializeArray();
   //**************************************************************************
   for(var i=0; i<aData1.length; i++){
       if(aData1[i].name == 'txtperdidasdepeso' || aData1[i].name == 'prsopostdialisis' || aData1[i].name == 'hd_anterior'){
           
       } else {
           $('#'+aData1[i].name).css('border-color','');
           if(aData1[i].value == ''){  
               aDatosVacios.push(aData1[i].name);  
               $("#"+aData1[i].name).css("border-color","RED");  
           }
       }
   }
   //**************************************************************************
   var aDatosVacios        =   new Array();
   var aData2              =   $('#formulario_histo_pre').serializeArray();
   for(var i = 0; i < aData2.length; i++){
       $("#"+aData2[i].name).css("border-color","");
       var cod_empresa     =  $("#cod_empresa").val();
           if  (   
                   aData2[i].name == 'txttpaciente'    || 
                   aData2[i].name == 'txttemmonitor'   ||
                   aData2[i].name == 'Q_B_PROG'        ||
                   aData2[i].name == 'Q_B_EFEC'        ||
                   aData2[i].name == 'Q_B_EFEC'        ||
                   aData2[i].name == 'TXTPV'           ||
                   aData2[i].name == 'TXTPA'           ||
                   aData2[i].name == 'TXTPTM'          ||
                   aData2[i].name == 'TXTCOND'         ||
                   aData2[i].name == 'TXTUFH'          ||
                   aData2[i].name == 'TXTUFACOMULADA' 
               ){
               //showNotification('top','right');
           } else  if(aData2[i].value == ""){  
               aDatosVacios.push(aData2[i].name);  
               $("#"+aData2[i].name).css("border-color","RED");  
           }
   }
          
   var arr_error_rrhh          =   new Array();
   $("#slc_enfermeria").val()  ==  null ? arr_error_rrhh.push("Falta enfermera/o"):'';
   $("#slc_tecpara").val()     ==  null ? arr_error_rrhh.push("Falta Tecnico Paramedico"):'';
   $("#slc_medico").val()      ==  null ? arr_error_rrhh.push("Falta Medico"):'';
   
   if(arr_error_rrhh.length>0){
       jError(arr_error_rrhh.join("<br>"),"e-SISSAN");
       return false;
   }
   
   if($("#txtHoraIngresoPre").val() == '' ){
       jError("Falta hora de conexi&oacute;n","e-SISSAN");
       return false;
   }
   //*********************************************************
   var CreacionDialisis=                           {   datosProgramacion      :    [] , datosPresion  : [] , rrhh_conexion : [] };
       CreacionDialisis.datosProgramacion.push(    {   FormProgramacion       :    $('#formulario_histo').serializeArray()});
       CreacionDialisis.datosPresion.push(         {   FormdatosPresion       :    $('#formulario_histo_pre').serializeArray()});
       CreacionDialisis.rrhh_conexion.push(        {   FormdrrhhConexion      :    $('#rrhhConexion').serializeArray()});
   //**************************************************************************
   
    var fecha       =   '';
    if($("#op_fecha_especial").val() == '' || $("#op_fecha_especial").val() == 'undefined' || $("#op_fecha_especial").val() == null){
        fecha       =   $('#numFecha').val();
    } else {
        fecha       =   $('#op_fecha_especial').val();  
    }
   
    if(aDatosVacios.length == '0'){
       jPrompt('Se envian datos para inicio Programaci&oacute;n.</b><br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
           if (r == null){
               jError("Contrase&ntilde;a vacia","e-SISSAN");
           } else {
               //console.log(CreacionDialisis); 
               $('#BTN_INICIO').prop('disabled',true);
               $.ajax({
                   url         :   "ssan_hdial_asignacionpaciente/guardaInfdormacionDialisis",
                   type        :   "POST",
                   dataType    :   "json",
                   beforeSend  :   function(xhr)     { },
                   data        :   {
                                       fechaHerno              :   fecha,
                                       HrsIngreso              :   $("#txtHoraIngresoPre").val(),
                                       contrasena              :   r,
                                       NUMFICHAE               :   NUMFICHAE,
                                       num_Maquina             :   $("#num_Maquina").val(),
                                       datosDialisis           :   CreacionDialisis,
                                       hojatra                 :   '',
                                   },
                   error       :   function(errro)     {   
                                                           console.log(errro.responseText); 
                                                           jError("Comuniquese con el administrador","Clinica Libre"); 
                                                           $('#BTN_INICIO').prop('disabled',false);

                                                       },              
                   success     :   function(aData)     { 
                                                           //console.log(aData[3]['sql']);
                                                           $('#BTN_INICIO').prop('disabled',false);
                                                           if(aData[0]['validez']){
                                                               jAlert('Se ha Realizado con &eacute;xito','Restricci\u00f3n',function(r){
                                                                   if(r){
                                                                       $("#MODAL_INICIODIALIS").modal('hide'); 
                                                                       localStorage.setItem("ind_tipo_mensaje",1);
                                                                       localStorage.setItem("num_fichae",NUMFICHAE);
                                                                       localStorage.setItem("id_hoja",null);
                                                                       $("#actualizacion_hoja_diaria").submit();
                                                                       cargaPacientes(fecha);
                                                                  }
                                                               });
                                                           } else {
                                                               jError("Firma Simple Incorrecta","Clinica Libre - Restricci\u00f3n");
                                                           }
                                                       }
               });   
           }
       });
   } else {
       jError("Existe informaci&oacute;n incompleta","Clinica Libre");
   }
}

function js_indicacionENFE(IDHOJADIARIA,NUMFICHAE,NUMCITA){
   //$("#MODAL_INICIODIALIS").css("z-index","900"); 
   $("#MODAL_TOMADESIGNO").modal("show");
   $.ajax({
       url         : "ssan_hdial_asignacionpaciente/HTML_addSignosVitales",
       type        : "POST",
       dataType    : "html",
       beforeSend  : function(xhr) {    },
       data        : { },
       error       : function(errro)   {   
                                           console.log(errro.responseText); 
                                           jError("Comuniquese con el administrador ","E-SISSAN"); 
                                       },              
       success     : function(aData)   { 
                                           $("#BODY_TOMASIGNO").html(aData); 
                                           $("#BTN_GSIGNOS").attr('onclick','enviaSignoVitales('+IDHOJADIARIA+','+NUMFICHAE+','+NUMCITA+')'); 
                                       }
   });
}

function enviaSignoVitales(IDHOJADIARIA,NUMFICHAE,NUMCITA){
   var aDatosVacios    = new Array();
   var aData2          = $('#formulario_histo_pre').serializeArray();
   for(var i = 0; i < aData2.length; i++){
       $("#"+aData2[i].name).css("border-color","");
       if (aData2[i].name == 'txttpaciente'){
               showNotification('top','right');
       } else  if(aData2[i].value == ""){  
           aDatosVacios.push(aData2[i].name);  
           $("#"+aData2[i].name).css("border-color","RED");  
       }       
   }
   //**************************************************************************
   if(aDatosVacios.length=='0'){
       var CreacionDialisis             = 
                                           {    
                                           datosProgramacion   : [] , 
                                           datosPresion        : [] 
                                           };
                                           
       CreacionDialisis.datosPresion.push({    FormdatosPresion    : $('#formulario_histo_pre').serializeArray() });
       jPrompt('Se grabara informacion.</b><br /><br />&iquest;Est&aacute; seguro de continuar?', '', 'Confirmaci\u00f3n', function (r) {
           if (r == null){
               jError("Contrase&ntilde;a Vacia","e-SISSAN");
           } else {
               //console.log(CreacionDialisis); 
               //return false;
               $.ajax({
                   url         :   "ssan_hdial_asignacionpaciente/guardaInfdormacionDialisis",
                   type        :   "POST",
                   dataType    :   "json",
                   beforeSend  :   function(xhr)     { console.log(xhr); },
                   data        :   
                                                   {
                                                       contrasena              : r,
                                                       NUM_CITA                : NUMCITA,
                                                       NUMFICHAE               : NUMFICHAE,
                                                       num_Maquina             : $("#num_Maquina").val(),
                                                       datosDialisis           : CreacionDialisis,
                                                       hojatra                 : IDHOJADIARIA,

                                                   },
                   error       :   function(errro)   { console.log(errro.responseText); jError("Comuniquese con el administrador ","E-SISSAN"); },              
                   success     :   function(aData)   { 
                                                       if (aData[0]['validez']){
                                                           jAlert('Se ha Realizado con exito', "Restricci\u00f3n",function(r){
                                                               if(r){
                                                                   
                                                                   localStorage.setItem("ind_tipo_mensaje",2);
                                                                   localStorage.setItem("num_fichae",NUMFICHAE);
                                                                   localStorage.setItem("id_hoja",IDHOJADIARIA);
                                                                   $("#actualizacion_hoja_diaria").submit();
                                                                   cargaSignosVitales(IDHOJADIARIA);  
                                                                   $("#MODAL_TOMADESIGNO").modal("hide");
                                                               }
                                                           });
                                                       } else {
                                                           jError("Firma Simple Erronea","e-SISSAN Restricci\u00f3n");
                                                       }
                                                   }
               });   
           }
       });
   
   } else {
       jError("Existen Campos Incompletos","e-SISSAN");
   }
}

function cargaSignosVitales(IDHOJADIARIA){
   $("#htmlSignosvitales").html('');
   $.ajax({
       url         : "ssan_hdial_asignacionpaciente/busquedaNuevosVitales",
       type        : "POST",
       dataType    : "json",
       beforeSend  : function(xhr)     { },
       data        :                   { IDHOJADIARIA : IDHOJADIARIA,},
       error       : function(errro)   { console.log(errro.responseText); jError("Comuniquese con el administrador ","E-SISSAN"); },              
       success     : function(aData)   { AjaxExtJsonAll(aData); }
   });
}
//final js_signovitales

function showNotification(from, align){
   /*
   console.log("------------------");
   var color       = Math.floor((Math.random()*4)+1);
   $.notify({
      icon        : "pe-7s-gift",
      message     : "Welcome to <b>Light Bootstrap Dashboard</b> - a beautiful freebie for every web developer."
   },{
       type        : type[color],
       timer       : 4000,
       placement   : {
           from    : from,
           align   : align
       }
   });
   */
}

function js_grdCierre(IDHOJADIARIA,opcion){
   //COMPROBAR QUE TODA LA HOJA DIARIA ESTE COMPLETA//
   var aDatosVacios    =   new Array();
   var aData1          =   $('#FORM_MEDICO').serializeArray();
   for(var i=0; i<aData1.length; i++){
       if(aData1[i].name == 'TXT_ACCESOVAS_2' || aData1[i].name == 'FEC_DIAS_2' || aData1[i].name == 'OBS_MEDICAS_'){
           if (aData1[i].name == 'OBS_MEDICAS_'){
               showNotification('top','right');
           }
       } else {
           $('#'+aData1[i].name).css('border-color','');
           if(aData1[i].value == ''){  
               aDatosVacios.push(aData1[i].name);  
               $("#"+aData1[i].name).css("border-color","RED");  
           }
       }
   }
   
   var aData1 = $('#FORM_ENFERMERIA').serializeArray();
   for(var i=0; i<aData1.length; i++){
       if(aData1[i].name == 'SIN_INPUT'){
           
       } else {
           $('#'+aData1[i].name).css('border-color','');
           if(aData1[i].value == ''){  
               aDatosVacios.push(aData1[i].name);  
               $("#"+aData1[i].name).css("border-color","RED");  
           }
       }
   }
   
   var aData1 = $('#FORM_ECIRCUITO').serializeArray();
   for(var i=0; i<aData1.length; i++){
       if(aData1[i].name == 'SIN_INPUT'){
           
       } else {
           $('#'+aData1[i].name).css('border-color','');
           if(aData1[i].value == ''){  
               aDatosVacios.push(aData1[i].name);  
               $("#"+aData1[i].name).css("border-color","RED");  
           }
       }
   }
   
   var aData1 = $('#FORM_PAUSASEGURIDAD').serializeArray();
   for(var i=0; i<aData1.length; i++){
       if(aData1[i].name == 'SIN_INPUT'){
           
       } else {
           $('#'+aData1[i].name).css('border-color','');
           if(aData1[i].value == ''){  
               aDatosVacios.push(aData1[i].name);  
               $("#"+aData1[i].name).css("border-color","RED");  
           }
       }
   }
   
   var aData1 = $('#FORM_FILTRO').serializeArray();
   for(var i=0; i<aData1.length; i++){
       if(aData1[i].name == 'SIN_INPUT'){
           
       } else {
           $('#'+aData1[i].name).css('border-color','');
           if(aData1[i].value == ''){  
               aDatosVacios.push(aData1[i].name);  
               $("#"+aData1[i].name).css("border-color","RED");  
           }
       }
   }
   
   if(aDatosVacios.length!='0'){  
       jError("Para cerrar la hoja de tratamiento, debe completar los datos obligatorios","e-ESSIAN");  
       return false;  
   }
   $.ajax({
       url         :   "ssan_hdial_asignacionpaciente/HtmlCierrehemodialisis",
       type        :   "POST",
       dataType    :   "json",
       beforeSend  :   function(xhr)       {   $('#loadFade').modal('show');   },
       data        :   { 
                           IDHOJADIARIA    :   IDHOJADIARIA,
                           name            :   $("#txt_name_"+IDHOJADIARIA).val(),
                           rut             :   $("#txt_run_"+IDHOJADIARIA).val(),
                           fono            :   $("#txt_fono_"+IDHOJADIARIA).val(),
                           cump            :   $("#txt_nac_"+IDHOJADIARIA).val(),
                       },
       error       :   function(errro)     { 
                                               console.log(errro.responseText); 
                                               $('#loadFade').modal('hide'); 
                                               jError("Comuniquese con el administrador ","E-SISSAN"); 
                                           },              
       success     :   function(aData)     { 
                                               $('#loadFade').modal('hide'); 
                                               if (AjaxExtJsonAll(aData)){
                                                   $(".selectpicker").selectpicker();
                                                   $("#BTN_CIERREHERMO").attr('onclick','js_guardadoPrevio('+IDHOJADIARIA+','+opcion+')'); 
                                                   $('#MODAL_CIERREHERMO').modal({backdrop:'static',keyboard:false}).modal("show");
                                               } 
                                           }
   });
   
}

function js_guardadoPrevio(IDHOJADIARIA,opcion){
   /*
       console.log("FORM_MEDICO");
       console.log($("#FORM_MEDICO").serializeArray());
       console.log("------------------------------");
       console.log("FORM_ENFERMERIA");
       console.log($("#FORM_ENFERMERIA").serializeArray());
       console.log("------------------------------");
       console.log("FORM_ECIRCUITO");
       console.log($("#FORM_ECIRCUITO").serializeArray());
       console.log("------------------------------");
       console.log("FORM_PAUSASEGURIDAD");
       console.log($("#FORM_PAUSASEGURIDAD").serializeArray());
       console.log("------------------------------");
       console.log("FORM_FILTRO");
       console.log($("#FORM_FILTRO").serializeArray());
   */
   //console.log("OPCION ---->"+opcion);
   
   var CreacionDialisis            =   { 
       datosProgramacion           :   [], 
       finalizacionHemodialisis    :   [], 
       datosPresion                :   [], 
       reacionesAdversas           :   [] 
   };
   
   var msjErro             =   '';
   var aDatosReacionesAd   =   new Array();
   var ExisteDatos         =   new Array();
   var aData2              =   $('#FORM_RADVERSAS').serializeArray();
   for(var i=0;i<aData2.length;i++){
       var name            =   aData2[i].name;
       var ivalue          =   aData2[i].value;
       var value           =   name.split("_");
       if (value[0]=='sl'){
           //console.log(value);
           //console.log(value[1]);
           //console.log($("#txt_"+value[1]).val());
           //console.log(ivalue);
           $("#txt_"+value[1]).css("border-color","");
           if(($("#txt_"+value[1]).val()=='')&&(ivalue=='1')){
               $("#txt_"+value[1]).css("border-color","red");
               aDatosReacionesAd.push($("#txt_"+value[1]));  
           } else if(ivalue=='1'){
               ExisteDatos.push(i);   
           }
       } 
   }
   //console.log(ExisteDatos);
   if(ExisteDatos.length!='0'){
       CreacionDialisis.reacionesAdversas.push({ Form_ReacionesAd  : $('#FORM_RADVERSAS').serializeArray() });
   }
   
   if(aDatosReacionesAd.length!='0'){  msjErro+="<li>Existen Opciones en el &igrave;tem reacciones adversas marcadas si, que no tienes observaciones</li>";  }
           var textPrompt  = '';
           var FORM_MEDICO = $('#FORM_MEDICO').serializeArray();
               FORM_MEDICO.push({name : 'TipoViaDial',                 value : $("#TipoViaDial").val() });
           
           if (opcion      == '0'){
           //*******************************************************************************    
           var ind_medico  = 0;
           if($("#optionAN").prop('checked')){ ind_medico  = 0; } else { ind_medico  = 1; }
           FORM_MEDICO.push({name : 'ind_pmedico',                 value : ind_medico });
           textPrompt      = '<b> - Se guardaran datos de hora diaria (Guardado Previo)</b>';
           //*******************************************************************************
   } else  if (opcion      == '1'){
           textPrompt      = '<b> - Con esta acci&oacute;n finalizara la hora diaria.</b>';
           
           var ind_medico  = 0;
           if($("#optionAN").prop('checked')){ ind_medico  = 0; } else { ind_medico  = 1; }
           FORM_MEDICO.push({name : 'ind_pmedico',                 value : ind_medico });
           
           $("#txtHoraEgreso").css("border-color","");  
           if( $("#txtHoraEgreso").val() == ''){
               $("#txtHoraEgreso").css("border-color","RED");  
               msjErro+="<li>Ingrese Hora Valida</li>";
           }
           
           $("#prsopostdialisis_term").css("border-color","");
           if( $("#prsopostdialisis_term").val() == ''){
               $("#prsopostdialisis_term").css("border-color","RED");  
               msjErro+="<li>Ingrese peso post-di&aacute;lisis</li>";
           }
           
           $("#txtperdidasdepeso_term").css("border-color",""); 
           if( $("#txtperdidasdepeso_term").val() == ''){
               $("#txtperdidasdepeso_term").css("border-color","RED");  
               msjErro+="<li>Ingrese perdida de peso interdialisis</li>";
           }
           
           $("#txttotalufconseguida").css("border-color",""); 
           $("#txttotalufconseguida").css("border-color",""); 
           if( $("#txttotalufconseguida").val() == ''){
               $("#txttotalufconseguida").css("border-color","RED");  
               msjErro+="<li>Ingrese total UF conseguida</li>";
           }
           
           $("#volsangreacomulado").css("border-color","");  
           $("#volsangreacomulado_").css("border-color",""); 
           if( $("#volsangreacomulado").val() == ''){
               $("#volsangreacomulado").css("border-color","RED");  
               msjErro+="<li>Ingrese vol. de sangre acumulado</li>";
           }
           
           $("#pesopostdialisis").css("border-color","");  
           $("#pesopostdialisis").css("border-color",""); 
           if( $("#pesopostdialisis").val() == ''){
               $("#pesopostdialisis").css("border-color","RED");  
               msjErro+="<li>Ingrese peso post-di&aacute;lisis</li>";
           }
           
           //****************************************POST DIALISIS********************************************
           FORM_MEDICO.push({name : 'prsopostdialisis_term',       value : $("#prsopostdialisis_term").val()   }); 
           FORM_MEDICO.push({name : 'txtperdidasdepeso_term',      value : $("#txtperdidasdepeso_term").val()  }); 
           FORM_MEDICO.push({name : 'txttotalufconseguida',        value : $("#txttotalufconseguida").val()    }); 
           //new 30.06.2022
           FORM_MEDICO.push({name : 'txttotalufconseguida_um',     value : $("#txttotalufconseguida_um").val() }); 
           FORM_MEDICO.push({name : 'volsangreacomulado',          value : $("#volsangreacomulado").val()      }); 
           FORM_MEDICO.push({name : 'pesopostdialisis',            value : $("#pesopostdialisis").val()        }); 
           FORM_MEDICO.push({name : 'SL_DESIFCACCIONMAQUINA',      value : $("#SL_DESIFCACCIONMAQUINA").val()  }); 
           FORM_MEDICO.push({name : 'SL_DIALIZADORDIAL',           value : $("#SL_DIALIZADORDIAL").val()       }); 
           //**ADD 05.02.2018
           FORM_MEDICO.push({name : 'num_kt_b',                    value : $("#num_kt_b").val()       });
           
           console.log("FORM_MEDICO    ->  ",FORM_MEDICO);
           
           //************************************************************************************
           
           //Comprobar signos vitales postdialisis
           var aDatosVacios    = new Array();
           var aData2          = $('#formulario_histo_pre').serializeArray();
           for(var i = 0; i < aData2.length; i++){
               $("#"+aData2[i].name).css("border-color","");
               var cod_empresa =  $("#cod_empresa").val();
               if(cod_empresa == '107' || cod_empresa == '100' || cod_empresa == '106' || cod_empresa == '104' ){
                   if  (   
                           aData2[i].name == 'txttpaciente'    || 
                           aData2[i].name == 'txttemmonitor'   ||
                           aData2[i].name == 'Q_B_PROG'        ||
                           aData2[i].name == 'Q_B_EFEC'        ||
                           aData2[i].name == 'Q_B_EFEC'        ||
                           aData2[i].name == 'TXTPV'           ||
                           aData2[i].name == 'TXTPA'           ||
                           aData2[i].name == 'TXTPTM'          ||
                           aData2[i].name == 'TXTCOND'         ||
                           aData2[i].name == 'TXTUFH'          ||
                           aData2[i].name == 'TXTUFACOMULADA' 
                       ){
                       //showNotification('top','right');
                   } else  if(aData2[i].value == ""){  
                       aDatosVacios.push(aData2[i].name);  
                       $("#"+aData2[i].name).css("border-color","RED");  
                   }
               } else {//otros establecimientos
                   if(aData2[i].name == 'txttpaciente'){
                       //showNotification('top','right');
                   } else  if(aData2[i].value == ""){  
                       aDatosVacios.push(aData2[i].name);  
                       $("#"+aData2[i].name).css("border-color","RED");  
                   }  
               }
           
           }
           
           if(aDatosVacios.length!='0'){
               msjErro+="<li>Datos Incompletos signos vitales post</li>";
           }
          
           var teminoHermodialisis = $('#terminoDialisis').serializeArray();
               teminoHermodialisis.push({name : 'txtHoraEgreso',   value : $("#txtHoraEgreso").val() });
               teminoHermodialisis.push({name : 'txtPCargo',       value : $("#slc_enfermeria option:selected").text()     });
               teminoHermodialisis.push({name : 'idAdmision',      value : $("#idAdmision_"+IDHOJADIARIA).val()            });
               
           CreacionDialisis.finalizacionHemodialisis.push({ form_teminodialisis : teminoHermodialisis , form_etapa  : '3'  });
           CreacionDialisis.datosPresion.push({    FormdatosPresion    : $('#formulario_histo_pre').serializeArray()       });
           
   } else  if (opcion == '2'){
           textPrompt  = '<b>Se env&iacute;an datos para inicio Programaci&oacute;n.</b>';
   } else  if (opcion == '3'){
       
           var aDatosVacios = new Array();
           var aData1 = $('#FORM_MEDICO').serializeArray();
           for(var i=0; i<aData1.length; i++){
               if(aData1[i].name == 'TXT_ACCESOVAS_2' || aData1[i].name == 'FEC_DIAS_2' || aData1[i].name == 'OBS_MEDICAS_'){
                   if (aData1[i].name == 'OBS_MEDICAS_'){
                       //showNotification('top','right');
                   }
               } else {
                   $('#'+aData1[i].name).css('border-color','');
                   if(aData1[i].value == ''){  
                       aDatosVacios.push(aData1[i].name);  
                       $("#"+aData1[i].name).css("border-color","RED");  
                   }
               }
           }
           
       if(aDatosVacios.length!='0'){  
           FORM_MEDICO.push({name : 'ind_pmedico',                 value : 0 });
           textPrompt  = '<b>Se guardar&aacute; datos desde el perfil del m&eacute;dico estado "SIN CIERRE" </b>';
       } else {
           textPrompt  = '<b>Se guardar&aacute; datos desde el perfil del m&eacute;dico estado "CERRADO" </b>';
           FORM_MEDICO.push({name : 'ind_pmedico',                 value : 1 });
       }
   }
  
   CreacionDialisis.datosProgramacion.push({ 
       Form_Programacion:FORM_MEDICO.concat($('#FORM_ENFERMERIA').serializeArray())
           .concat($('#FORM_ECIRCUITO').serializeArray())
           .concat($('#FORM_PAUSASEGURIDAD').serializeArray())
           .concat($('#FORM_FILTRO').serializeArray())
   });
   
   var fecha       =   '';
   if($("#op_fecha_especial").val() == '' || $("#op_fecha_especial").val() == 'undefined' || $("#op_fecha_especial").val() == null){
       fecha       =   $('#numFecha').val();
   } else {
       fecha       =   $('#op_fecha_especial').val();  
   }
   
   if (msjErro == ''){
       
           console.log("datos de envio     ->  ",CreacionDialisis);
       
           jPrompt(textPrompt+'<br/><br/>&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n', function (r) {
               if (r == null){
                   jError("Contrase&ntilde;a vacia","e-SISSAN");
               } else {
                   $.ajax({
                       url         :   "ssan_hdial_asignacionpaciente/guardaInformacionPrevio",
                       type        :   "POST",
                       dataType    :   "json",
                       beforeSend  :   function(xhr)   {  console.log(CreacionDialisis);   },
                       data        :                   {
                                                           contrasena          :   r,
                                                           IDHOJADIARIA        :   IDHOJADIARIA,
                                                           opcion              :   opcion,
                                                           CreacionDialisis    :   CreacionDialisis,
                                                           fecha_aplicado      :   fecha,
                                                       },
                       error       :   function(errro) {   
                                                           console.log(errro.responseText); 
                                                           jError("Comuniquese con el administrador","E-SISSAN"); 
                                                       },              
                       success     :   function(aData) { 
                                                           console.log("existo guardado previo");
                                                           $('.main-panel').perfectScrollbar('destroy');
                                                           document.getElementById("MODAL_HORADIARIA").style.overflowY = 'auto';
                                                           //console.log(aData[3]['sql']);
                                                           if(aData[0]['validez']){
                                                               localStorage.setItem("num_fichae",null);
                                                               localStorage.setItem("id_hoja",IDHOJADIARIA);
                                                               //cierre enfermeria
                                                               if (opcion == '1')  {   localStorage.setItem("ind_tipo_mensaje",5);  }
                                                               //guardado previo
                                                               if (opcion == '0')  {   localStorage.setItem("ind_tipo_mensaje",6);  }  
                                                               //cierre medico
                                                               if (opcion == '3')  {   localStorage.setItem("ind_tipo_mensaje",7);  }
                                                               $("#actualizacion_hoja_diaria").submit();
                                                               jAlert('Se ha guardado se ha Realizado con &eacute;xito', "Restricci\u00f3n",function(r){
                                                                   if(r){
                                                                       if (opcion == '1'){
                                                                           $("#MODAL_HORADIARIA").modal('hide');
                                                                           $("#MODAL_CIERREHERMO").modal('hide');
                                                                       }  
                                                                       cargaPacientes(fecha); 
                                                                   }
                                                               });
                                                           } else {
                                                               jError("Firma Simple erronea","e-SISSAN Restricci\u00f3n");
                                                           }
                                                           
                                                       }
                   });   
               }
       });
   } else {
       jError("Se han encontrado los siguente errores<br>"+msjErro,"e-SISSAN");
       return false;
   }
}