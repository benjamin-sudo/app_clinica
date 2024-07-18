function star_websocket_hoja_dialisis(){
    console.log("-----------------------------------------------");
    var empresa                     =   $("#empresa").val();
    console.log("empresa            ->  ",empresa,"  <-             ");
    //var socket                    =   io.connect("https://qa.esissan.cl/ws_gespab_updatetablaiq",{transports:['polling'],secure:true,query:"empresa="+empresa}); 
    //var ruta                      =   "http://10.5.139.140:3000/ws_dialisis_hojadiaria";
    var ruta                        =   "https://qa.esissan.cl/ws_dialisis_hojadiaria";
    console.log("ruta               ->  ",ruta);
    var socket                      =   io.connect(ruta,{transports:['polling'],secure:true,query:"empresa="+$("#empresa").val()}); 
    //var socket                    =   io.connect(ruta,{secure:true,{transports:['polling']query:"empresa="+$("#empresa").val()}); 
    console.log("socket             ->  ",socket,"  <-              ");
    console.log("connected          ->  ",socket.connected,"  <-    ");
    console.log("-----------------------------------------------");
    ws_actualiza_hoja_diaria(socket);
}

function ws_actualiza_hoja_diaria(socket){
    console.log("-----------------------");
    console.log("       Star ws         ");
    $(document).on('submit','#actualizacion_hoja_diaria',function(){
        console.log("submit         ->  ","actualizacion_hoja_diaria");
        socket.emit('ssan_dialisis:inicio_hoja_diaria',{
            num_fichae              :   localStorage.getItem("num_fichae"),
            id_hoja                 :   localStorage.getItem("id_hoja"),
            ind_tipo_mensaje        :   localStorage.getItem("ind_tipo_mensaje"),
            ind_fecha               :   $("#numFecha").val(),
            num_Maquina             :   $("#num_Maquina").val(),
        });
        return false; 
    });
    
    //escuchando actualizacion de las hojas diarias
    socket.on('ssan_dialisis:actualizacion_hoja_diaria',function(data){
        console.log("----------------------------------------------------");
        console.log("ssan_dialisis:actualizacion_hoja_diaria");
        console.log("data               ->  ",data);
        var ind_actualizacion           =   false;
        //var hoja_diaria_abierta       =   false;
        var actualizacion_medico        =   false;
        var actualizacion_enfermero     =   false;
        var ind_hoja_activa             =   $("#MODAL_HORADIARIA").data('hojaactiva').toString();
        
        console.log("---------------------------------------------------------");
        console.log(" ind_hoja_activa   ->  ",ind_hoja_activa);
        if (data["ind_tipo_mensaje"]  == 0 )    {
            $.notify(" test ws  ");
        }
        if(data["ind_tipo_mensaje"]  == 8 )     {
            $.notify("Hoja diaria N&deg; "+data["id_hoja"]+", Se ha eliminado");
            ind_actualizacion           =   true;
        }
        if (data["ind_tipo_mensaje"]  == 1 )    {
            $.notify("Se inicio nueva hoja de tratamiento diario de hemodi&aacute;lisis");
            ind_actualizacion               =   true;
        }
        if(data["ind_tipo_mensaje"]  == 2 )     {
            $.notify("Se actualizo toma de signos vitales");
            if (ind_hoja_activa === data["id_hoja"]){
                cargaSignosVitales(ind_hoja_activa);  
            }
        }
        
        if(data["ind_tipo_mensaje"]  == 6 )     {
            $.notify("Se actualizo informaci&oacute;n de hoja diaria N&deg; "+data["id_hoja"]);
            console.log("ind_hoja_activa    ->",ind_hoja_activa);
            console.log("data[id_hoja]      ->",data["id_hoja"]);
            if (ind_hoja_activa === data["id_hoja"]){
                actualizacion_enfermero     =   true;
            }
        }
        if(data["ind_tipo_mensaje"]  == 5 )     {
            $.notify("Hoja diaria N&deg; "+data["id_hoja"]+", Se actualizo por enefermero");
            ind_actualizacion               =   true;
            console.log("ind_hoja_activa    ->",ind_hoja_activa);
            console.log("data[id_hoja]      ->",data["id_hoja"]);
            if (ind_hoja_activa === data["id_hoja"]){
                actualizacion_enfermero     =   true;
            }
        }
        if(data["ind_tipo_mensaje"]         == 7 )     {
            $.notify("Hoja diaria N&deg; "+data["id_hoja"]+", Se actualizo por m&eacute;dico");
            ind_actualizacion               =   true;
            console.log("ind_hoja_activa    ->",ind_hoja_activa);
            console.log("data[id_hoja]      ->",data["id_hoja"]);
            if (ind_hoja_activa === data["id_hoja"]){
                actualizacion_medico        =   true;
            }
        }
        console.log("actualizacion_enfermero || actualizacion_medico",actualizacion_enfermero || actualizacion_medico);
        
        var ind_hoja_abierta        =   false;
        if(actualizacion_enfermero || actualizacion_medico){
            ind_hoja_abierta        =   true;
            $.notify("Hoja diaria N&deg; "+data["id_hoja"]+", actualmente abierta, fue modificada");
            if (actualizacion_enfermero){
                js_actualiza_hoja_diaria(1,ind_hoja_activa);
            }
            if (actualizacion_medico){
                js_actualiza_hoja_diaria(2,ind_hoja_activa);
            }
        }
        
        if( !ind_hoja_abierta || ind_actualizacion){
            if ( (data["ind_fecha"] == $("#numFecha").val()) && (data["num_Maquina"] == $("#num_Maquina").val() ) ){
                console.log("Actualiza");
                eventosBuscar($("#num_Maquina").val());
            } else {
                console.log("No Actualiza");
            }
        }
        
        
        $('.main-panel').perfectScrollbar('destroy');
        document.getElementById("MODAL_HORADIARIA").style.overflowY = 'auto';
    });
}
     
     
function js_actualiza_hoja_diaria(op,id_hojadiaria){
    $.ajax({ 
        type            :   "POST",
        url             :   "ssan_hdial_asignacionpaciente/busca_informacion_hojadiaria",
        dataType        :   "json",
        data            :   { 
                                id_hojadiaria  :  id_hojadiaria,
                            },
        error           :   function(errro)     {    
                                                    console.log(errro.responseText);  
                                                    jAlert("Error General, Consulte Al Administrador"); 
                                                },
        success         :   function(aData)     {   
            
                                                    console.log("----------------------return data----------------------------");
                                                    console.log("--------------------------------------------------");
                                                    console.log("--------------------------------------------------");
                                                    console.log("--------------------------------------------------");
                                                    console.log("op             ->  ",op);
                                                    
                                                    $("#fecha_ultima_actualizacion").html(aData.out_data[0].TXT_FEC_AUDITA);
                                                    
                                                    if(op == 2){
                                                        console.log("actualiza hoja diaria deade hoja de medico a enfermero");
                                                        $('#optionAN').prop('checked',false);
                                                        js_disabled_medica(false);
                                                        $("#TXT_ACCESOVAS_1").val(aData.out_data[0].TXTACCESOVAS_1);
                                                        $("#FEC_DIAS_1").val(aData.out_data[0].FEC_DIASVAS_1);
                                                        $("#TXT_ACCESOVAS_2").val(aData.out_data[0].TXTACCESOVAS_2);
                                                        $("#FEC_DIAS_2").val(aData.out_data[0].FEC_DIASVAS_2);
                                                        $("#NUM_ARTERIAL").val(aData.out_data[0].NUM_TROCAR_ARTERIAL);
                                                        $("#NUM_VENOSO").val(aData.out_data[0].NUM_TROCAR_VENOSO);
                                                        $("#NUM_INICIO").val(aData.out_data[0].NUM_HEPARINA_INICIO);
                                                        $("#NUM_MANTENCION").val(aData.out_data[0].NUM_HEPARINA_MAN);
                                                        $("#NUM_QT").val(aData.out_data[0].NUM_QT);
                                                        $("#NUM_QB").val(aData.out_data[0].NUM_QB);
                                                        $("#NUM_QD").val(aData.out_data[0].NUM_QD);
                                                        $("#NUM_UFMAX").val(aData.out_data[0].NUM_UFMAX);
                                                        $("#NUM_UFMAX_UM").val(aData.out_data[0].NUM_UFMAX_UM);
                                                        $("#NUM_K").val(aData.out_data[0].NUM_K);
                                                        $("#NUM_NA").val(aData.out_data[0].NUM_NA);
                                                        $("#NUM_CONCENTRADO").val(aData.out_data[0].NUM_CONCENTRADO);
                                                        $("#OBS_MEDICAS").val(aData.out_data[0].TXT_OBSMEDICAS);
                                                    }
                                                    
                                                    if(op == 1){
                                                         console.log("actualiza hoja diaria deade hoja de ENFERMERO a MEDICO");
                                                        $("#OBS_ENFERMERIA").val(aData.out_data[0].TXT_ENFERMERIA);
                                                        //PAUSAS DE SEGURIDAD
                                                        $("#PAUSAS_PACIENTE_CORRECTO").val(aData.out_data[0].IND_PACIENTE_CORRECTO);
                                                        $("#PAUSAS_CIRCUITO_LINEAS").val(aData.out_data[0].IND_CLINEAS);
                                                        $("#PAUSAS_CIRCUITO_FILTRO").val(aData.out_data[0].IND_CFILTRO);
                                                        $("#NUM_T_MONITOR").val(aData.out_data[0].NUM_T_MONITOR);
                                                        $("#NUM_CONDUCTIVIDAD").val(aData.out_data[0].NUM_CONDUCTIVIDAD);
                                                        $("#NUM_TEST_RESIDUOS").val(aData.out_data[0].ID_TEST_RESIDUOS);
                                                        //Estado Circuitos
                                                        $("#SLT_FILTO").val(aData.out_data[0].NUM_CI_FILTRO);
                                                        $("#SLT_ARTERIAL").val(aData.out_data[0].NUM_CI_ARTERIAL);
                                                        $("#SLT_VENOSA").val(aData.out_data[0].NUM_CI_VENOSA);
                                                        $("#n_uso").val(aData.out_data[0].NUM_USO_FILTRO);
                                                        $("#v_residual").val(aData.out_data[0].NUM_V_RESIDUAL);
                                                        $("#uso_l_arterial").val(aData.out_data[0].NUM_V_ARTERIAL);
                                                        $("#uso_l_venosa").val(aData.out_data[0].NUM_V_VENOSA);
                                                        $("#SLT_R_RFIBRAS").val(aData.out_data[0].IND_R_RFIBRAS);
                                                        $("#SLT_C_RFIBRAS").val(aData.out_data[0].IND_C_RFIBRAS);
                                                        $("#SLT_R_PIROGENOS").val(aData.out_data[0].IND_R_PIROGENOS);
                                                    }
                                                    console.log("aData          ->  ",aData.out_data);
                                                    console.log("IND_HDESTADO   ->  ",aData.out_data[0].IND_HDESTADO);
                                                    //js_disabled_medica
                                                }, 
    });
}
     
function test_ws(){
    console.log("-> test ws <- ");
    localStorage.setItem("ind_tipo_mensaje",0);
    localStorage.setItem("num_fichae",0);
    $("#actualizacion_hoja_diaria").submit();
}
    
function js_HistorialClinico(fichae,id,RUT_PAC){
    var TOKEN       =   $("#TOKEN_ONE").val();
    //console.log("   --------------------------------    ");
    //console.log("   TOKEN --->",TOKEN,"<------------    ");
    //console.log("   --------------------------------    ");
    jPrompt('Con esta acc&oacute;n se proceder&aacute; a ver historial clinico del paciente.<br/>&iquest;Est&aacute; seguro de continuar?<br />', '',
        'Confirmaci\u00F3n', function (r) {
        if (r) {
                $.ajax({ 
                    type            :   "POST",
                    url             :   "ssan_hdial_asignacionpaciente/iframeHistorialClinico",
                    dataType        :   "json",
                    data            :   { 
                                            contrasena  :   r,
                                            fichae      :   fichae,
                                            RUT_PAC     :   RUT_PAC,
                                            id          :   id,
                                            TOKEN       :   TOKEN,
                                        },
                    error           :   function(errro)     {    
                                                                console.log(errro.responseText);  
                                                                jAlert("Error General, Consulte Al Administrador"); 
                                                            },
                    success         :   function(aData)     {   
                                                                AjaxExtJsonAll(aData);
                                                            }, 
                });      
        }
    });
}

function UPDATE_PANEL(){
    var v_num_Maquina   = $("#num_Maquina").val();
    eventosBuscar(v_num_Maquina);
}

function eventosBuscar(MKN){
    if($("#op_fecha_especial").val() == '' || $("#op_fecha_especial").val() == 'undefined' | $("#op_fecha_especial").val() == null){
        cargaPacientes($('#numFecha').val());
    } else {
        cargaPacientes($("#op_fecha_especial").val());
    }
}

function js_pdfHTML(IDHOJADIARIA){
    var histo ='<iframe src="pabellon_classpdf/formatohojadiaria?id='+IDHOJADIARIA+$("#TOKEN_PDF").val()+'" frameborder="0" style="overflow:hidden;height: 650px;width:100%;"></iframe>';
    $("#PDF_HTML").html(histo);
    $("#MODAL_PDF").modal("show");
}

function js_pdfHTML2(IDHOJADIARIA){
    var histo ='<iframe src="pabellon_classpdf/formatohojadiaria?id='+IDHOJADIARIA+$("#TOKEN_PDF").val()+'" frameborder="0" style="overflow:hidden;height:500px;width:100%;"></iframe>';
    $("#li_hoja_finalizadas2").show();
    $("#div_TERMINO_HOJADIARIAS").html(histo);
}

//*VER HD_ANTERIORES DE EXAMENES
function cargaCalendario(num_fichae){
    js_cBUSQUEDAHANTERIOR(num_fichae,2);
}

function js_cBUSQUEDAHANTERIOR(num_fichae,val){
    $.ajax({
        url         : "ssan_hdial_asignacionpaciente/cargaHDanteriores",
        type        : "POST",
        dataType    : "json",
        data        :   
                        {
                            num_fichae      : num_fichae,
                            historico       : 1,
                            nuevo           : val,
                            fecha           : $("#sel_busquedaMes").val()
                        },
        error       : function(errro){ console.log(errro.responseText); console.log(errro); jError("Comuniquese con el administrador ","E-SISSAN"); },              
        success     : function(xml) { if (AjaxExtJsonAll(xml)){ $("#MODAL_HD_ANTERIORES").modal("show");  }; }
    });
}

//*VER SOLICITUD DE EXAMENES
function cargaCalendarioExamenes(num_fichae){
    js_cSOLICITUDEEXAMENES(num_fichae,2);
}

function js_cSOLICITUDEEXAMENES(num_fichae,val){
    $.ajax({
        url         : "ssan_hdial_asignacionpaciente/cargaEXAMENESanteriores",
        type        : "POST",
        dataType    : "json",
        data        :   
                        {
                            num_fichae      : num_fichae,
                            nuevo           : val,
                            fecha           : $("#sel_busquedaMes").val()
                        },
        error       : function(errro){ console.log(errro.responseText); console.log(errro); jError("Comuniquese con el administrador ","E-SISSAN"); },              
        success     : function(xml) { if (AjaxExtJsonAll(xml)){ $("#MODAL_EXM_ANTERIORES").modal("show");  }; }
    });
}

function js_solicitudEXM(id,numfichae,fecha){
    $.ajax({ 
       type                :    "POST",
       url                 :    "ssan_hdial_asignacionpaciente/verEXAMENESanteriores",
       dataType            :    "HTML",
       data                :    { numfichae : numfichae ,fecha : fecha  },
       beforeSend          :    function(res)   {  },
       error               :    function(res)   { console.log(res); $("#respuesta").html(res.responseText); /*jAlert(res.responseText);*/  },
       success             :    function(aData) {
                                                    $("#"+id).popover({
                                                        html        : true,
                                                        trigger     : "hover",
                                                        content     : aData,
                                                    }).popover('show');
                                                }, 
    });
}

function js_eliminaSV(id,IDHOJADIARIA){
    jPrompt('Con esta acci&oacute;n procedera a borrar la toma de signos vitales <br/><br/>&iquest;Est&aacute; seguro de continuar?', '', 'Confirmaci\u00f3n', function (r) {
        if (r == null){
            jError("Contrase&ntilde;a vacia","e-SISSAN");
        } else {
            $.ajax({
                url         : "ssan_hdial_asignacionpaciente/borraSignosVitales",
                type        : "POST",
                dataType    : "json",
                beforeSend  : function(xhr)     { },
                data        :                   {
                                                    contrasena  : r,
                                                    id          : id,
                                                },
                error       : function(errro)   {   console.log(errro.responseText); jError("Comuniquese con el administrador ","E-SISSAN"); },              
                success     : function(aData)   { 
                                                    //console.log(aData[3]['sql']);
                                                    if(aData[0]['validez']){
                                                        jAlert('Se ha borrado con exito', "Restricci\u00f3n",function(r){
                                                            if(r){  
                                                                cargaSignosVitales(IDHOJADIARIA);   
                                                                if($("#id_templete").val() == '3' ){  console.log("ELIMINA"); cargaPermisos_hd($("#num_correcionhd").val()); }
                                                            }
                                                        });
                                                    } else {
                                                        jError("Firma Simple erronea","e-SISSAN Restricci\u00f3n");
                                                    }
                                                }
            });   
        }
    });
}

function js_cierramodal(){
    $('#MODAL_HORADIARIA').modal("hide");
}

function js_atcreacionesad(id,value){
    var arrinput = id.split("_"); 
    if(value == '0'){
        $("#txt_"+arrinput[1]).prop("disabled",true);
        $("#txt_"+arrinput[1]).val("");
    } else {
        $("#txt_"+arrinput[1]).prop("disabled",false);
    }
}

function cal_fecha(value,i){
    //console.log(value);
    var f               = new Date();
    var fechaAlrevez    = value.split("-");
    var fecha           = fechaAlrevez[2]+"-"+fechaAlrevez[1]+"-"+fechaAlrevez[0];
    var fecha1          = moment(fecha);
    var fecha2          = moment(f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate() );
    $("#num_dias_"+i).html(fecha2.diff(fecha1,'days'), ' d');
}

function num(e){
    var key = window.Event ? e.which : e.keyCode;
    return (key >= 48 && key <= 57);
}

function num_coma(e,field){
  //console.log(e);  
  //console.log(field);
  var key = e.keyCode ? e.keyCode : e.which;
  //console.log(key);
  // retroceso
  if (key == 8) return true
  // 0-9
  if (key > 47 && key < 58) {
    if (field.value == "") return true
    regexp = /.[0-9]{2}$/
    return !(regexp.test(field.value))
  }
  // .
  if (key == 44 || key == 45) {
    if (field.value == "") return false
    regexp = /^[0-9]+$/
    return regexp.test(field.value)
  }
  // other key
  return false
}

 function soloNumeros(e,id){
    // capturamos la tecla pulsada
    var teclaPulsada            =   window.event ? window.event.keyCode:e.which;
    //console.log(teclaPulsada);
    // capturamos el contenido del input
    var valor                   =   document.getElementById(id).value;
    // 45 = tecla simbolo menos (-)
    // Si el usuario pulsa la tecla menos, y no se ha pulsado anteriormente
    // Modificamos el contenido del mismo aÃ±adiendo el simbolo menos al
    // inicio
    if(teclaPulsada==45 && valor.indexOf("-")==-1){ document.getElementById(id).value="-"+valor;  }
    // 13 = tecla enter
    // 44 = tecla punto (,)
    // Si el usuario pulsa la tecla enter o el punto y no hay ningun otro
    // punto
    if(teclaPulsada==13 || (teclaPulsada==44 && valor.indexOf(",")==-1)){
        return true;
    }
    //devolvemos true o false dependiendo de si es numerico o no
    return /\d/.test(String.fromCharCode(teclaPulsada));
}
    
function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        status = "This field accepts numbers only."
        return false
    }
    status = ""
    return true
}


//******************************************************************************
function js_eliminahoja(NUMFICHAE,AD_ID_ADMISION,IDHOJADIARIA){
    jPrompt('Con esta acci&oacute;n procedera a eliminar el ingreso de un paciente hoja diaria numero <b>'+IDHOJADIARIA+'</b> <br/><br/>&iquest;Est&aacute; seguro de continuar?', '', 'Confirmaci\u00f3n', function (r) {
        if (r == null){
            jError("Contrase&ntilde;a vacia","e-SISSAN");
        } else {
            $.ajax({
                url         :   "ssan_hdial_eliminacionhojadiara/eliminarhojadiaria",
                type        :   "POST",
                dataType    :   "json",
                beforeSend  :   function(xhr)   {   console.log("xhr->",xhr);   },
                data        :                   {
                                                    contrasena          :   r,
                                                    NUMFICHAE           :   NUMFICHAE,
                                                    AD_ID_ADMISION      :   AD_ID_ADMISION,
                                                    IDHOJADIARIA        :   IDHOJADIARIA,
                                                    IND_MOTIVO          :   1//
                                                },
                error       :   function(errro){   
                                                        console.log(errro.responseText); 
                                                        jError("Comuniquese con el administrador ","E-SISSAN"); },              
                success     :   function(aData){ 
                                                        console.log("--------------------------");
                                                        console.log("aData->",aData);
                                                        console.log("--------------------------");
                                                        if(aData['STATUS']){
                                                            eventosBuscar(3);
                                                            localStorage.setItem("ind_tipo_mensaje",8);
                                                            localStorage.setItem("num_fichae",NUMFICHAE);
                                                            localStorage.setItem("id_hoja",IDHOJADIARIA);
                                                            $("#actualizacion_hoja_diaria").submit();
                                                            jAlert('Se ha borrado con &eacute;xito', "Restricci\u00f3n",function(r){
                                                                if(r){  
                                                                    //eventosBuscar(3);
                                                                }
                                                            });
                                                        } else {
                                                            jError(aData['TXT_STATUS'],"e-SISSAN Restricci\u00f3n");
                                                        }
                                                        
                                                }
            });   
        }
    });
}

//1.- 
function js_views_receta_hd(IDHOJADIARIA,NUMFICHAE){
     $("#li_receta_medica").attr('onclick','');
    var num_fichae              =   NUMFICHAE;
    var ficha_local             =   0;
    var empresa                 =   $("#empresa").val();
    
    console.log("-----------------------------------------------------");
    console.log("num_fichae     ->  ",num_fichae,"      <-------------");
    console.log("ficha_local    ->  ",ficha_local,"     <-------------");
    console.log("empresa-       ->  ",empresa,"         <-------------");
    console.log("ind_admision-  ->  ",IDHOJADIARIA,"    <-------------");
    console.log("-----------------------------------------------------");
    
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_spab_recetaanestesiologo/genera_token_pabellon",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    $('#loadFade').modal('show'); 
                                                },
        data                :                   { 
                                                    "ind_opcion"        :   0,
                                                    "id_tabla"          :   null,
                                                    "idHospitaliza"     :   null, 
                                                    "id_admision"       :   IDHOJADIARIA,
                                                    "fichae"            :   num_fichae,
                                                    "fichalocal"        :   ficha_local,
                                                    "empresa"           :   empresa
                                                },
        error               :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error en el aplicativo, Consulte Al Administrador","e-SISSAN"); 
                                                    $('#loadFade').modal('hide'); 
                                                },
        success             :   function(aData) { 
                                                    $('#loadFade').modal('hide'); 
                                                    console.log("aData    ->    ",aData,"   <-   ");
                                                    //popNewReceta(aData.token);
                                                    var dataGet = [];
                                                    dataGet.push('huella=0');
                                                    dataGet.push('ind_pab=0');
                                                    dataGet.push('ind_dial=1');
                                                    dataGet.push('ws=0');
                                                    dataGet.push('id_opcion=1');
                                                    dataGet.push('id_tabla=null');
                                                    dataGet.push('ind_admision='+IDHOJADIARIA);
                                                    if(aData.status){
                                                        popNewReceta_tabla(aData.token+"&"+dataGet.join("&"));
                                                    } else {
                                                        showNotification('top','left','Problemas al cargar receta',4,'fa fa-times');
                                                    }
                                                }, 
    });
}

//2.- se agrega 
function popNewReceta_tabla(token){
    console.log("   token   ->  ",token);
    //return false;
    //width="100%" height="100%"
    var ind_estandar_  = $(window).height()*0.7;
    //console.log("ind_estandar_  ->  ",ind_estandar_);
    //$(".pabel_recetas_iframe").html('guallando');
    $(".pabel_recetas_iframe").html('<iframe src="/op_ssan_newreceta?token=' + token + '" style="width:100%;min-height:'+ind_estandar_+'px;"  frameborder="0" scrolling="auto"></iframe>');
}
