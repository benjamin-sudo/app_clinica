$(document).ready(function(){
    $('#modal_new_subrotulo').on('hidden.bs.modal',function(e){ 
        $("#html_new_subrotulo").html('');
        $("#btn_subrotulo").attr('onclick','');
    });
    //MODAL GLOBAL DE ETIQUETAS
    $("#MODAL_INFORMACION_ETIQUETA").on('show.bs.modal',function(e){ 
	    //$('.modal .modal-body').css('overflow-y','auto'); 
        //var _height = $(window).height()*0.8;
        //$('.modal .modal-body').css('max-height',_height);
        //$('.modal .modal-body').css('min-height',_height);
        //document.getElementById("get_etiqueta").disabled    =   true;
        //$('#get_etiqueta_modal').focus();
        //document.getElementById("get_etiqueta_modal").focus();
    });
    $('#MODAL_INFORMACION_ETIQUETA').on('hidden.bs.modal',function(e){ 
        console.log("e  ->  ",e);
        //document.getElementById("get_etiqueta").disabled    =   false;
        //$('.popover').popover('hide');
        $("#HTML_INFORMACION_ETIQUETA").html(''); 
    });
    $('#MODAL_INFORMACION_HISTORIAL').on('hidden.bs.modal',function(e){ 
        $("#HTML_INFORMACION_HISTORIAL").html(''); 
    });
    //MODAL SHOW
    $('#MODAL_INFORME_EVENTOS_ADVERSOS').on('show.bs.modal',function(e){ 
        $("#HTML_INFORME_EVENTOS_ADVERSOS").html(''); 
    });
    $('#MODAL_INFORME_EVENTOS_ADVERSOS').on('hidden.bs.modal',function(e){ 
        $("#HTML_INFORME_EVENTOS_ADVERSOS").html(''); 
    });
    $('#Dv_verdocumentos').on('hidden.bs.modal',function(e){ 
        $("#PDF_VERDOC").html(''); 
    });
    $('#modal_gestion_tomamuestraxuser').on('hidden.bs.modal',function(e){ 
        $("#html_gestion_tomamuestraxuser").html(''); 
    });
    
    $('#modal_new_userxtomamuestra').on('hidden.bs.modal',function(e){ 
        js_limpia_panel();
    });
    $('#modal_info_html').on('hidden.bs.modal',function(e){ 
        $("#html_info_html").html(''); 
    });
    $('#modal_info_html').on('show.bs.modal',function(e){ 
       
    });
    //****************** get_etiqueta ******************************************
    $("#get_etiqueta").keypress(function(e){ 
        if(e.which==13){ busqueda_etiquera(0,'',{}); } 
    });
    $("#get_etiqueta").click(function(){ 
        $('.popover').popover('hide'); 
    });
    //Uso de promesas
    var p1  = new Promise(function(resolve, reject) {
        resolve('Success');
        document.getElementById("get_etiqueta").focus();
    });
    p1.then(function(value) {
        //console.log(value); // "Success!"
        throw 'oh, no!';
    }).catch(function(e) {
        //console.log("->",e); // "oh, no!"
    }).then(function(){
        //console.log('despues de una captura, la cadena se restaura');
    },function(){
        //console.log('No disparada debido a la captura');
    });
    $('#ind_servicios').on('changed.bs.select',function(e,clickedIndex,isSelected,previousValue){ 
        js_cambio_punto_entrega();  
    });
    //conf frasco
    $('#MODAL_INFO_APLICATIVO').on('show.bs.modal',function(e){ 
        console.log("show       MODAL_INFO_APLICATIVO      ->   "+e);
        var value               =    localStorage.getItem("confi_frasco") == null ? 1 : localStorage.getItem("confi_frasco");
        console.log("star       ->  ",value);
        change_loalstrange(value);
    });
    $('#MODAL_INFO_APLICATIVO').on('hidden.bs.modal',function(e){ 
        var v_num_comuna = $("#num_comuna").val();
        var v_num_fila = $("#num_fila").val();
        //console.log("mandar a cookie en php -> ",v_num_comuna);
        //console.log("mandar a cookie en php -> ",v_num_fila);
        //console.log("MODAL_INFO_APLICATIVO -> ",e);
        $.ajax({ 
            type : "POST",
            url : "ssan_spab_gestionlistaquirurgica/get_genera_cookie",
            dataType : "json",
            beforeSend : function(xhr) {   
                console.log("xhr->",xhr);
            },
            data : {   
                v_num_comuna : v_num_comuna,
                v_num_fila : v_num_fila
            },
            error : function(errro) { 
                console.log(errro);  
                console.log(errro.responseText);    
                jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
            },
            success : function(aData) { 
                //console.log("Se creo cookie -> ",aData);
                localStorage.setItem("v_num_comuna",v_num_comuna);
                localStorage.setItem("v_num_fila",v_num_fila);
                update_main();
            }, 
        });
    });
    //CONFIGURACION DE MARGEN DEL FRASCO
    //console.log("------------------------------------------------------------");
    //console.log("   screen.width    ->",screen.width);
    //console.log("   screen.height   ->",screen.height);
    //console.log("------------------------------------------------------------");
    //console.log("------------------------------------------------------------");
    //console.log("$.fn.tooltip.Constructor.VERSION ->",$.fn.tooltip.Constructor.VERSION);
    //console.log("-------------------------------------------------------------");
    //console.log("CONFIG_FRASCO    ->  ",localStorage.getItem("confi_frasco"));
    //console.log("-------------------------------------------------------------");
    var ind_conf_frasco = localStorage.getItem("confi_frasco")===null?star_etiqueta():localStorage.getItem("confi_frasco");
    //console.log("CONFIG_FRASCO    ->  ",ind_conf_frasco);
    $("#CONFIG_FRASCO").val(ind_conf_frasco);
    //console.log("CONFIG_FRASCO -> ",$("#CONFIG_FRASCO").val()," ind_conf_frasco ->",ind_conf_frasco);
    $('[data-toggle="tooltip"]').tooltip();
});

function star_etiqueta(){
    localStorage.setItem("confi_frasco",1);
    return 1;
}

function change_loalstrange(value){
    console.log("value -> ",value);
    localStorage.setItem("confi_frasco",value);
    if (value == 8){
        $(".grid_fila_columna_etiqueta").show();
    } else {
        $(".grid_fila_columna_etiqueta").hide();
    }
}

function js_config_etiqueta(){
   $("#MODAL_INFO_APLICATIVO").modal({backdrop:'static',keyboard:false}).modal("show");
}

function js_cambio_punto_entrega(){
    var ind_servicios               =   $("#ind_servicios").val();
    //console.log("ind_servicios -> pre -> ",ind_servicios);
    $(".punto_toma_muestra").remove();
    if(ind_servicios == null){
        $(".sin_puntos_cargados").show();
    } else {
        var aux                     =   1;
        ind_servicios.forEach(function(value){
            //console.log("value    ->  ",value);
            var arr_info            =   $("#ind_servicios > option[value='"+value+"']").data("info");    
            //console.log("arr_info ->  ",arr_info);
            var btn_trash           =   '<button type="button" class="btn btn-xs btn-danger btn-fill" id="btn_valida_profesional" onclick="remove_lista_usuario('+value+')">'+
                                            '<i class="fa fa-trash-o" aria-hidden="true"></i>'+
                                        '</button>';
            var html                =   '<div class="grid_li_rotuloxsuario">'+
                                            '<div class="grid_li_rotuloxsuario1">'+aux+'</div>'+
                                            '<div class="grid_li_rotuloxsuario2">'+arr_info.TXT_OBSERVACION+'</div>'+
                                            '<div class="grid_li_rotuloxsuario3">'+btn_trash+'</div>'+
                                        '</div>';    
            $('.pto_entrega_x_usuario').append('<li class="list-group-item punto_toma_muestra ptn_muestra_'+value+'">'+html+'</li>');
            aux++;
        });
        $(".sin_puntos_cargados").hide();
    }
}

//REMOVE_LISTA_USUARIO
function remove_lista_usuario(id){
    //console.log("value      ->  ",id);
    $(".ptn_muestra_"+id).remove();
    var arr_organos = $("#ind_servicios").val();
    var indice = arr_organos.indexOf(id);
    arr_organos.splice(indice,1);
    $("#ind_servicios").selectpicker('val',arr_organos);
    js_cambio_punto_entrega();
}

//BUSQUEDA DEL CORRELATIVO SEGUN LA BIOPSIA
function busqueda_numero_disponible(tipo_biopsia){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_listaexterno1/ultimo_numero_disponible",
        dataType : "json",
        beforeSend : function(xhr) {    console.log("xhr->",xhr);  },
        data : { tipo_biopsia : tipo_biopsia },
        error : function(errro) { 
                                    console.log(errro);  
                                    setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
                                    jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                },
        success : function(aData){ 
                                    //console.log("ultimo_numero_disponible -> ",aData,"  <-  ");
                                    $("#num_interno").val('');
                                    let num_last = aData.data_numero.V_LAST_NUMERO;
                                    showNotification('top','center','N&deg; asignado:<b>'+num_last+'</b>',1,'fa fa-info');
                                    $("#num_interno").val(num_last);
                                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                }, 
    });
}

//SOLO BUSCA UN SEGUNDO CORRELATIVO
function busqueda_numero_disponible_citologia(tipo_biopsia){
    //console.log("tipo_biopsia   ->  ",tipo_biopsia);
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_listaexterno1/ultimo_numero_disponible_citologia",
        dataType : "json",
        beforeSend : function(xhr) { console.log("xhr->",xhr);  },
        data : {   tipo_biopsia : tipo_biopsia },
        error : function(errro) { 
                                    console.log(errro);  
                                    console.log(errro.responseText);    
                                    jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                },
        success : function(aData){ 
                                    //console.log("ultimo_numero_disponible citologia -> ",aData,"  <-  ");
                                    $("#num_interno_cito").val('');
                                    let num_last = aData.data_numero.V_LAST_NUMERO;
                                    showNotification('top','center','N&deg; asignado:<b>'+num_last+'</b>',1,'fa fa-info');
                                    $("#num_interno_cito").val(num_last);
                                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                }, 
    });
}

//UL_TABS_MUESTRA
function test_js_newtabs(){
    var valor = $('#UL_TABS_MUESTRA li').size()+1;
    $('#UL_TABS_MUESTRA').append('<li role="presentation" ><a href="#TABS_'+valor+'"  data-toggle="tab" role="tab" aria-controls="TABS_'+valor+'" aria-selected="false"> name -> '+valor+'</a></li>');
    $('#TABS_TAB_PANEL').append('<div role="tabpanel" class="tab-pane" id="TABS_'+valor+'" aria-labelledby="TABS_'+valor+'_1" > TABS_'+valor+' content</div>');
    $('#UL_TABS_MUESTRA').tab();
    $('#UL_TABS_MUESTRA li:last-child a').tab('show');
}

/*
    $('#UL_TABS_MUESTRA a[href="#profile"]').tab('show'); 
    $('#UL_TABS_MUESTRA li:first-child a').tab('show');
    $('#UL_TABS_MUESTRA li:last-child a').tab('show'); 
    $('#UL_TABS_MUESTRA li:nth-child(3) a').tab('show'); 
*/

function js_newtabs(valor){
    // create the tab
    $('#UL_TABS_MUESTRA').append('<li role="presentation" ><a href="#TABS_'+valor+'"  data-toggle="tab" role="tab" aria-controls="TABS_'+valor+'" aria-selected="false"> name -> '+valor+'</a></li>');
    // create the tab content
    $('#TABS_TAB_PANEL').append('<div role="tabpanel" class="tab-pane" id="TABS_'+valor+'" aria-labelledby="TABS_'+valor+'_1" > TABS_'+valor+' content</div>');
    // make the new tab active
    $('#UL_TABS_MUESTRA').tab();
    $('#UL_TABS_MUESTRA li:last-child a').tab('show');
}

function js_ver_info_fase_1(){
    $("#modal_info_fase_1").modal({backdrop:'static',keyboard:false}).modal("show");
}

function js_busqueda_pendiente(value,_this){
    console.log("-------------------------------");
    console.log("value  ->",value,"<-           "); 
    console.log("_this  ->",_this,"<-           "); 
    console.log("-------------------------------");
    $("#tabs_pendiente_"+value).remove();
    busqueda_etiquera(3,value,{});
}

function js_viwes_btn_masivo(){
    //console.log("COUNT -> ",$('#UL_TABS_MUESTRA li').size());
    var aux = 0;
    $('.btn_change').each(function(i,obj){ aux++; });
    if(aux>1){
        $("#btn_masivo").show();
    } else {
        $("#btn_masivo").hide();
    }
}

function js_from_ap_pospuesto(id){ 
    $.each(["TXT_DIAGNOSTICO","bio_extraInput","bio_ubicaInput","bio_tamannoInput","bio_lesionSelect","bio_aspectoSelect","bio_ant_previosSelect","bio_des_BiopsiaInput","bio_des_CitologiaInput","bio_observTextarea"],function(n,value){ 
        $("#"+value).prop("disabled",document.getElementById(id).checked); 
    }); 
}

function VER_PANEL_IMP_ETIQUETA(id){
    console.log("   id  =>  ",id);
}

//
function PLANTILLA_MANATOMIA(id,value){
    /*
        console.log("   ---------------------------------------------------------------------- ");
        console.log("   --------------------DATA PLANTILLA_MANATOMIA ------------------------- ");
        console.log("   --------------------->",value,"<-------------------------------------- ");
        console.log("   tabla_biopsia ->",$("#tabla_biopsia").data().arr_muestra,"<----------- ");
        console.log("   tabla_biopsia ->",$("#tabla_biopsia").data().arr_citologia,"<--------- ");
        console.log("   tabla_biopsia ->",$("#tabla_biopsia").data()),"<---------------------- ";
        console.log("   ---------------------------------------------------------------------- ");
    */
    var BOOLEANO_CASSETTE           =   document.getElementById("AP_USO_CASSETE").checked?true:false;   
    var IND_PLANTILLA               =   $("#IND_PLANTILLA_ANATOMIA").val();
    $("#tabla_biopsia").removeData();
    if(value == 0){
        $("#bio_ant_nMuestasSelect").val(1);
        js_htmlnummuestra('',1);
    }
    //**************************************************************************
    //************** PROTOCOLO SYDNEY ******************************************
    //**************************************************************************
    if(value == 1){
            //revisar que no sea el mismo id de protocolo
            var array_nmuestras  =   [
                                        {   ID_NMUESTRA:null, N_MUESTRA: "1",      TXT_MUESTRA: "ANTRO I",             IND_ETIQUETA: "2",      IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "2",      TXT_MUESTRA: "ANTRO II",            IND_ETIQUETA: "2",      IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "3",      TXT_MUESTRA: "&Aacute;NGULO",       IND_ETIQUETA: "2",      IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "4",      TXT_MUESTRA: "CUERPO I",            IND_ETIQUETA: "2",      IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "5",      TXT_MUESTRA: "CUERPO II",           IND_ETIQUETA: "2",      IND_TIPOMUESTRA: 1},
                                    ];  
            //console.log("array_nmuestras->",array_nmuestras);
        $("#tabla_biopsia").data({arr_muestra:array_nmuestras,arr_citologia:[]});
        $("#bio_ant_nMuestasSelect").val(5);
        js_htmlnummuestra('',5);
    }
    //**************************************************************************
    //************** ESTUDIO SERIADO COLON *************************************
    //**************************************************************************
    if(value == 2){
        var array_nmuestras     =  [
                                        {   ID_NMUESTRA:null, N_MUESTRA: "1",      TXT_MUESTRA:"ILE&Oacute;N",          IND_ETIQUETA: "2",     IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "2",      TXT_MUESTRA:"CIEGO",                 IND_ETIQUETA: "2",     IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "3",      TXT_MUESTRA:"COLON ASCENDENTE",      IND_ETIQUETA: "2",     IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "4",      TXT_MUESTRA:"COLON TRANSVERSO",      IND_ETIQUETA: "2",     IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "5",      TXT_MUESTRA:"COLON DESCENDENTE",     IND_ETIQUETA: "2",     IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "6",      TXT_MUESTRA:"SIGMOIDE",              IND_ETIQUETA: "2",     IND_TIPOMUESTRA: 1},
                                        {   ID_NMUESTRA:null, N_MUESTRA: "5",      TXT_MUESTRA:"RECTO",                 IND_ETIQUETA: "2",     IND_TIPOMUESTRA: 1},
                                    ];
        $("#tabla_biopsia").data({arr_muestra:array_nmuestras,arr_citologia:[]});
        $("#bio_ant_nMuestasSelect").val(7);
        js_htmlnummuestra('',7);
    }
}

//******************************************************************************
function js_eliminamuestra(op,value){
    $("#id_tr_"+value).remove();
    var array_nmuestras         =   new Array();
    $('[id^=n_muestra_]').each(function(){
        var arr_num             =   this.id.split("_");
        var DATA                =   $("#btn_muestra_"+arr_num[2]).data();
        var id_bd               =   DATA.ID_NMUESTRA;
        array_nmuestras.push({ 
            ID_NMUESTRA         :   id_bd,
            N_MUESTRA           :   arr_num[2], 
            TXT_MUESTRA         :   $("#n_muestra_"+arr_num[2]).val(),
            IND_ETIQUETA        :   $("#ind_equiqueta_"+arr_num[2]).val(),
            NUM_CASSETTE        :   document.getElementById("AP_USO_CASSETE").checked?$("#num_cassete_"+arr_num[2]).val():0, 
            IND_TIPOMUESTRA     :   1,
        });
    });
    
    var count                   =   array_nmuestras.length;
    if(count == 0){
        $("#tabla_biopsia").data().arr_muestra  =   {NUM_MUESTRA:i,IND_ETIQUETA:2};
        $("#IND_PLANTILLA_ANATOMIA").val(0);
        $("#bio_ant_nMuestasSelect").val(1);
        js_htmlnummuestra('',1);
    } else {
        $("#tabla_biopsia").data().arr_muestra  =   array_nmuestras;
        $("#bio_ant_nMuestasSelect").val(count);
        js_htmlnummuestra('',count);
    }
}

function js_eliminamuestra_cito(value){
    $("#id_tr_citologia_"+value).remove();
    var array_ncitologia        =    new Array();
    $('[id^=n_citologia_]').each(function(){
        var arr_num             =   this.id.split("_");
        var DATA                =   $("#btn_citologia_"+arr_num[2]).data();
        var id_bd               =   DATA.ID_NMUESTRA;
        array_ncitologia.push({ 
            ID_NMUESTRA         :   id_bd==null?'':id_bd,
            N_MUESTRA           :   arr_num[2], 
            TXT_MUESTRA         :   $("#n_citologia_"+arr_num[2]).val(),
            NUM_ML              :   $("#ml_citologia_"+arr_num[2]).val(),
            IND_ETIQUETA        :   $("#ind_cito_equiqueta_"+arr_num[2]).val(),
            IND_TIPOMUESTRA     :   2,
        });
    });
    var count                   =   array_ncitologia.length;
    /*
        console.log("-------------------------------------------------");
        console.log("array_ncitologia->",array_ncitologia);
        console.log("-------------------------------------------------");
    */
    if(count == 0){
        $("#bio_ant_nCitologia").val(1);
        $("#tabla_biopsia").data().arr_citologia    =   {N_MUESTRA:i,IND_ETIQUETA:2};
         ap_js_htmlcitologia("",1);
    } else {
        $("#bio_ant_nCitologia").val(count);
        $("#tabla_biopsia").data().arr_citologia    =   array_ncitologia;
        ap_js_htmlcitologia("",count);
    }
}

function JS_GUARDAANATOMIA_EXTERNO(value){
    let ID_GESPAB = $("#ID_GESPAB").val();
    let data_get = $("#data_get").data();
    let num_fichae = $("#TEMPLATE_NUMFICHAE").val();
    if(num_fichae === ''){
        console.log("Sin num fichae");
        return false;
    }
    //console.log("-------------------------GET-----------------------------------");
    //console.table($("#data_get").data("get"));
    //console.table($("#data_get").data("get").GET.derivacionic);
    //console.log("num_fichae     ->  ",num_fichae,"  <---------------------------");
    //console.log("data_get       ->  ",data_get,"    <---------------------------");
    //console.log("---------------------------------------------------------------");
    let TEMPLATE_CALL_FROM      =   $('#TEMPLATE_CALL_FROM').val();
    document.getElementById("btn-finish").disabled            =   true;
    let aData_2                 =   $('#formulario_histo').serializeArray().concat($('#form_anatomia_nmuestras').serializeArray()).concat($('#form_muestras_citologia').serializeArray());
    let aData_3                 =   [
                                        {
                                            TABS    :   1,
                                            FORM    :   $('#formulario_histo').serializeArray()
                                        },
                                        {
                                            TABS    :   2,
                                            FORM    :   $('#form_anatomia_nmuestras').serializeArray()
                                        },
                                        {
                                            TABS    :   3,
                                            FORM    :   $('#form_muestras_citologia').serializeArray()
                                        },

                                    ];

    var aDatosVacios    =   new Array();
    for(var i = 0; i < aData_2.length; i++){
        $("#"+aData_2[i].name).css("border-color","");
        if(
            aData_2[i].name == 'bio_des_BiopsiaInput'    || 
            aData_2[i].name == 'bio_des_CitologiaInput'  ||
            aData_2[i].name == 'bio_observTextarea'
        ){ } else {
            if(aData_2[i].value == ''){  
                aDatosVacios.push(aData_2[i].name);  
                $("#"+aData_2[i].name).css("border-color","red");  
            }   
        }
    }
    //**************************************************************************
    if(aDatosVacios.length>0){
        jError('Existe informaci&oacute;n incompleta','Clinica Libre');
        if(TEMPLATE_CALL_FROM == 0){
            document.getElementById("btn-finish").disabled = false;
        }
    } else {
        var CreacionProtocolo                       =   { 
            deleteexamenhispatologico               :   [],
            examenHispatologico                     :   [], 
            DATA_TEMPLATE                           :   [],
        };
        var date_final                              =   $("#IND_IFRAME").val()==1?$("#data_get").data().get.GET.date:$("#DATE_SISTEMA").val();
        //console.log("date_final                     =>  ",date_final);
        var DATA                                    =   {
            ID_GESPAB                               :   ID_GESPAB,
            TXT_DIAGNOSTICO                         :   $("#TXT_DIAGNOSTICO").val(), 
            TEMPLATE_NUMFICHAE                      :   $("#TEMPLATE_NUMFICHAE").val(), 
            TEMPLATE_RUTPAC                         :   $("#TEMPLATE_RUTPAC").val(), 
            TEMPLATE_ID_PROFESIONAL                 :   $("#TEMPLATE_ID_PROFESIONAL").val(), 
            TEMPLATE_RUT_PROFESIONAL                :   $("#TEMPLATE_RUT_PROFESIONAL").val(), 
            TEMPLATE_IND_TIPO_BIOPSIA               :   $("#TEMPLATE_IND_TIPO_BIOPSIA").val(), 
            TEMPLATE_IND_ESPECIALIDAD               :   $("#TEMPLATE_IND_ESPECIALIDAD").val(), 
            TEMPLATE_PA_ID_PROCARCH                 :   $("#TEMPLATE_PA_ID_PROCARCH").val(), 
            TEMPLATE_AD_ID_ADMISION                 :   $("#TEMPLATE_AD_ID_ADMISION").val(), 
            TEMPLATE_DATE_SOLICITUD                 :   $("#TEMPLATE_DATE_SOLICITUD").val(), 
            TEMPLATE_HRS_SOLICITUD                  :   $("#TEMPLATE_HRS_SOLICITUD").val(),
            TEMPLATE_DATE_DMYHM                     :   date_final,
            TEMPLATE_CALL_FROM                      :   $("#TEMPLATE_CALL_FROM").val(), 
            TEMPLATE_EMPRESA                        :   $("#TEMPLATE_EMPRESA").val()===''?null:$("#TEMPLATE_EMPRESA").val(), 
            TEMPLATE_PLANTILLA                      :   document.getElementById('IND_PLANTILLA_ANATOMIA')   ===null?0:$("#IND_PLANTILLA_ANATOMIA").val(), 
            TEMPLATE_USODECASSETTE                  :   document.getElementById('AP_USO_CASSETE')           ===null?0:document.getElementById("AP_USO_CASSETE").checked?1:0,
            TEMPLATE_INFOPOST                       :   document.getElementById('form_pospuesto')           ===null?0:document.getElementById("form_pospuesto").checked?1:0, 
            TEMPLATE_IND_ROTULADO                   :   $("#ind_zona").val(),
            TEMPLATE_IND_ROTULADO_SUB               :   $("#sub_ind_zona").val(),
            //NEW DERIVACION
            //TEMPLATE_IND_DERIVACION               :   typeof $("#data_get").data("get").GET.derivacionic === 'undefined' ? '' : $("#data_get").data("get").GET.derivacionic  ,
            //TEMPLATE_IND_ID_SIC                   :   typeof $("#data_get").data("get").GET.id_sic === 'undefined' ? '' : $("#data_get").data("get").GET.id_sic  ,
            TEMPLATE_IND_DERIVACION                 :   null,
            TEMPLATE_IND_ID_SIC                     :   null,
        };
        
        
        //typeof $("#tabla_biopsia").data().arr_muestra=="undefined"?[]:$("#tabla_biopsia").data().arr_muestra;
        CreacionProtocolo.DATA_TEMPLATE.push({DATA:DATA});
        console.log("--------------------------------------------------------------------");
        console.log("CreacionProtocolo              ->  ",CreacionProtocolo,"   <--------");
        console.log("--------------------------------------------------------------------");
        //return false;
        var formulario1                             =   $('#formulario_histo').serializeArray();
        //console.log("formulario1                  =>  ",formulario1);
        //MUESTRA DE BIOPSIA
        var display_nmuestras                       =   true;
        var display_ncitologia                      =   true;
        var array_nmuestras                         =   new Array();
        var arreglo_ncasete                         =   new Array();
        //**************************************************************
        if(display_nmuestras){
            $('[id^=n_muestra_]').each(function(){
                var arr_num                         =   this.id.split("_");
                var DATA                            =   $("#btn_muestra_"+arr_num[2]).data();
                var id_bd                           =   DATA.ID_NMUESTRA;
                arreglo_ncasete.push(document.getElementById("AP_USO_CASSETE").checked?$("#num_cassete_"+arr_num[2]).val():[]);
                array_nmuestras.push({ 
                    ID_NMUESTRA         :   id_bd,
                    N_MUESTRA           :   arr_num[2], 
                    TXT_MUESTRA         :   $("#n_muestra_"+arr_num[2]).val(),
                    IND_ETIQUETA        :   $("#ind_equiqueta_"+arr_num[2]).val(),
                    IND_NUMCASSETTE     :   document.getElementById("AP_USO_CASSETE").checked?$("#num_cassete_"+arr_num[2]).val():0, 
                    IND_TIPOMUESTRA     :   1,
                });
            });
            //***********************************
            //ELIMINA REPETIDAS CASETE SI EXISTEN
            //***********************************
            for(var i = arreglo_ncasete.length -1; i >=0; i--){
                if(arreglo_ncasete.indexOf(arreglo_ncasete[i])!== i) arreglo_ncasete.splice(i,1);
            }
            //console.log("-------------------------------------------------------------------");
            //console.log("arreglo_ncasete--------------->",arreglo_ncasete);
            //console.log("-------------------------------------------------------------------");
            //return false;
        }
        //MUESTRA DE BIOPSIA

        //MUESTRA DE CITOLOGIA
        var array_ncitologia            =    new Array();
        if(display_ncitologia){
            $('[id^=n_citologia_]').each(function(){
                var arr_num             =   this.id.split("_");
                var DATA                =   $("#btn_citologia_"+arr_num[2]).data();
                var id_bd               =   DATA.ID_NMUESTRA;
                array_ncitologia.push({ 
                    ID_NMUESTRA         :   id_bd==null?'':id_bd,
                    N_MUESTRA           :   arr_num[2], 
                    TXT_MUESTRA         :   $("#n_citologia_"+arr_num[2]).val(),
                    NUM_ML              :   $("#ml_citologia_"+arr_num[2]).val(),
                    IND_ETIQUETA        :   $("#ind_cito_equiqueta_"+arr_num[2]).val(),
                    IND_TIPOMUESTRA     :   2,
                });
            });
        }
        //MUESTRA DE CITOLOGIA
        CreacionProtocolo.examenHispatologico.push({
            listadoHISPATO              :   formulario1,
            numero_muestas              :   array_nmuestras,
            arr_citologia               :   array_ncitologia,
        });
        var PIDE_FIRMA                  =   false;
        /*
        console.log("------------------DATA_HISPATOLOGICO-----------------------");
        console.log("   ->",CreacionProtocolo,"<-                               ");
        console.log("   ->",$("#TEMPLATE_CALL_FROM").val(),"                    ");
        */
        //return false;
        $.ajax({ 
            type : "POST",
            url : "ssan_libro_biopsias_usuarioext/RECORD_ANATOMIA_PATOLOGICA_EXT",
            dataType : "json",
            beforeSend : function(xhr) {   console.log(xhr);   },
            data : { 
                                                        contrasena      :   PIDE_FIRMA,
                                                        accesdata       :   CreacionProtocolo,
                                                    },
            error           :   function(errro)     { 
                                                        console.log("---------------------------------------------------------------");
                                                        console.log("quisas->",errro,"error->",errro.responseText);
                                                        console.log("---------------------------------------------------------------");
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre");
                                                        if (TEMPLATE_CALL_FROM == 0){
                                                            document.getElementById("btn-finish").disabled = false;
                                                        }
                                                    },
            success         :   function(aData)     {
                                                        console.log('%c retutn RECORD_ANATOMIA_PATOLOGICA_EXT','background:#222;color:#bada55');
                                                        if(aData['STATUS']){
                                                            if(TEMPLATE_CALL_FROM==0){
                                                                jAlert("Se realiz&oacute; solicitud de anatom&iacute;a patol&oacute;gica","Clinica Libre");
                                                                $("#MODAL_INICIO_SOLICITUD_ANATOMIA").modal("hide");
                                                                ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(2);
                                                            } else if (TEMPLATE_CALL_FROM == 2){
                                                                $("#MODAL_FORM_ANATOMIA_PATOLOGICA").modal("hide");
                                                                jAlert("La solicitud se ha editado realidado con &eacute;xito","Clinica Libre");
                                                                UPDATE_MAIN();
                                                                //agregar switch
                                                                //IMPRIME_ETIQUETA_ANATOMIA(aData['ID_ANATOMIA']);
                                                            } else {
                                                                if ($("#IND_IFRAME").val() == 1){
                                                                    GET_PDF_ANATOMIA(aData['ID_ANATOMIA']);
                                                                }
                                                                $("#DIV_FORMULARIO_ANATOMIAPATOLOGICA_EXT").hide();
                                                            }
                                                            if(aData['VIEWS_PDF']){
                                                                GET_PDF_ANATOMIA(aData['ID_ANATOMIA']);
                                                            }
                                                        } else { 
                                                            jError('Contrase&ntilde;a inv&aacute;lida',"Clinica Libre"); 
                                                        }
                                                    }, 
        });
    }
}
    
function GET_PDF_ANATOMIA_ETIQUETAS(id){
    $("#HTML_ANATOMIA_PATOLOGICA").html('');
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_usuarioext/BLOB_PDF_ANATOMIA_PATOLOGICA",
        dataType : "json",
        beforeSend : function(xhr) {   
                                        //console.log(xhr);
                                        console.log("generando PDF");
                                        $('#HTML_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF");
                                    },
        data : { id : id },
        error : function(errro)     { 
                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                        $("#protocoloPabellon").css("z-index","1500"); 
                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                        $('#HTML_ANATOMIA_PATOLOGICA').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                    },
        success :   function(aData) { 
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
                                            /*
                                            console.log("-------------------------------------");
                                            console.log("BlobURL        =>",blobURL);
                                            console.log("-------------------------------------");
                                            */
                                            Objpdf                  =   document.createElement('object');
                                            Objpdf.setAttribute('data',blobURL);
                                            Objpdf.setAttribute('width','100%');
                                            Objpdf.setAttribute('style','height:700px;');
                                            Objpdf.setAttribute('title','PDF');
                                            $('#HTML_ANATOMIA_PATOLOGICA').html(Objpdf);
                                            return true;
                                        }
                                    }, 
    });
}

// FROM PANEL EXTERNO 
// ssan_libro_biopsias_listagespab
function btn_delete_ap_externo(idanatomia){
    //firma simple 
    jPrompt('Con esta acci&oacute;n se proceder&aacute; eliminar solicitud de anatom&iacute;a patol&oacute;gica <br/>&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if(r){
            $.ajax({ 
                type : "POST",
                url : "ssan_libro_biopsias_usuarioext/desabilita_solicitud_simple_ext",
                dataType : "json",
                beforeSend : function(xhr) {   
                    console.log("xhr->",xhr);
                    $('#loadFade').modal('show');
                },
                data : {
                    contrasena : r,
                    idanatomia : idanatomia,
                },
                error : function(errro) { 
                    console.log(errro);  
                    console.log(errro.responseText);    
                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                },
                success : function(aData) { 
                    console.log("out desabilita_solicitud_simple_ext  -> ",aData);
                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                    if(aData.STATUS_PASS){
                        if(aData['STATUS_OUT'].STATUS){
                            jAlert("Se ha eliminado solicitud de anatom&iacute;a patol&oacute;gica","Clinica Libre"); 
                            ACTUALIZA_FECHA_ANATOMIAPATOLOGICA(1);
                        } else {
                            jError(aData['STATUS_OUT'].TXT_OUT,"Clinica Libre"); 
                        }
                    } else {
                        jError("Error en firma simple","Clinica Libre"); 
                    }
                }, 
            });
        } else {
            jError("Firma unica vac&iacute;a","Clinica Libre"); 
        }
    });
}

function imprimirEtiqueta2(op){
    /*
    console.log("--------------------imprimirEtiqueta2--------------");
    console.log("imprimirEtiqueta2      ->",op,"<-                  ");
    console.log("---------------------------------------------------");
    */
    $.ajax({ 
        type : "POST",
        url : op===2?"ssan_libro_biopsias_listagespab/test_etiquetas_frasco"
                        : op===1?"ssan_libro_biopsias_listagespab/test_etiquetas_5"
                        : "ssan_libro_biopsias_listagespab/test_etiquetas_frasco_centrado",
        dataType : "json",
        beforeSend : function(xhr){  console.log(xhr); },
        data : { ind_funtion:true },
        error : function(errro)	{  
            console.log(errro); 
            console.log(errro.responseText); 
            jError("Error Al Imprimir Etiqueta","Clinica Libre"); 
        },
        success : function(aData)	{
            console.log("------------------------------------------------");
            console.log(" aData =>",aData['TICKET_TEST_M'],"<=    ");
            console.log("------------------------------------------------");
            if(aData['STATUS']){
                checkPrinterStatus(function(text){
                    //console.log("TEST TEXT =>",text,"<-");
                    //console.log("TEST SELECTED_PRINTER =>",selected_printer);
                    if(text=="Listo para imprimir"){
                        //console.log("TEST SELECTED_PRINTER =>",selected_printer);
                        //console.log("TEST PRINTERERROR =>",printerError);
                        //selected_printer.send(aData['TICKET_1']+aData['TICKET_2'],printComplete, printerError);
                        selected_printer.sendThenRead(aData['TICKET_TEST_M'],printComplete, printerError);
                    } else {
                        printerError(text);
                    }
                });
            }
        }, 
    });
}

function hashtag_small(id){
    var zpl = $("#"+id).data().zpl.BODY_ZPL;
    console.log("id -> ",id," ");
    console.log("data -> ",zpl," ");
    //return false;
    checkPrinterStatus(function(text){
        //console.log("TEST TEXT =>",text,"<-");
        //console.log("TEST SELECTED_PRINTER =>",selected_printer);
        if(text=="Listo para imprimir"){
            //console.log("TEST   SELECTED_PRINTER =>",selected_printer);
            //console.log("TEST   PRINTERERROR =>",printerError);
            //selected_printer.send(aData['TICKET_1']+aData['TICKET_2'],printComplete, printerError);
            selected_printer.sendThenRead(zpl,printComplete, printerError);
        } else {
            printerError(text);
        }
    });
}

function PRE_GET_PDF_ANATOMIA(id){
    $("#MODAL_FORM_ANATOMIA_PATOLOGICA").modal({backdrop:'static',keyboard:false}).modal("show");
    GET_PDF_ANATOMIA(id);
}

function GET_PDF_ANATOMIA(id){
    $("#HTML_ANATOMIA_PATOLOGICA").html('');
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_usuarioext/BLOB_PDF_ANATOMIA_PATOLOGICA",
        dataType : "json",
        beforeSend : function(xhr) {   
            console.log(xhr);
            console.log("generando PDF");
            $('#HTML_ANATOMIA_PATOLOGICA').html("<div class='GENERA_PDF'><i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF</div>");
        },
        data : { id : id, },
        error : function(errro) { 
            console.log("quisas => ",errro," error => ",errro.responseText); 
            $("#protocoloPabellon").css("z-index","1500"); 
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
            $('#HTML_ANATOMIA_PATOLOGICA').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
        },
        success : function(aData) { 
            console.log(aData);
            if(!aData["STATUS"]){
                jError("error al cargar protocolo PDF","Clinica Libre");
                return false;
            } else {
                var base64str = aData["PDF_MODEL"];
                var binary = atob(base64str.replace(/\s/g,''));
                var len =   binary.length;
                var buffer = new ArrayBuffer(len);
                var view = new Uint8Array(buffer);
                for(var i=0;i<len;i++){ view[i] = binary.charCodeAt(i); }
                var blob = new Blob([view],{type:"application/pdf"});
                var blobURL = URL.createObjectURL(blob);
                Objpdf = document.createElement('object');
                Objpdf.setAttribute('data',blobURL);
                Objpdf.setAttribute('width','100%');
                Objpdf.setAttribute('style','height:700px;');
                Objpdf.setAttribute('title','PDF');
                $('#HTML_ANATOMIA_PATOLOGICA').html(Objpdf);
                return true;
            }
        }, 
    });
}

function opt_imprime(valor){
    setTimeout(function(){
        console.log("esperando el segundo");
        checkPrinterStatus(function(text){
            console.log("text ->  ",text," <-");
            console.log("selected_printer 1=>",selected_printer);
            console.log("selected_printer name 1=>",selected_printer.name);
            console.log("printerError 1=>",printerError);
            if(text == "Listo para imprimir"){
                console.log("selected_printer 2=>",selected_printer);
                console.log("selected_printer name  2=>",selected_printer.name);
                console.log("printerError 2=>",printerError);
                var return_ = selected_printer.sendThenRead(valor,printComplete, printerError);
                console.log("return_ 4=>",return_);
            } else {
                printerError(text);
            }
            console.log("selected_printer 3=>",selected_printer);
            console.log("selected_printer name 3=>",selected_printer.name);
            console.log("printerError 3=>",printerError);
        });
    },2000);
    return true;
}

//************************************************
//********id=2 viene con datos********************
//*******LLAMADA DESDE PROTOCOLO INSITUCIONAL*****
//************************************************
function new_js_FormularioBio_modal(id){
    var value_biopsia                   =   $("#des_biopsia").val();
    var txt_biopsia                     =   $("#des_biopsia option:selected").text();
    //console.log("----------------------->",id);
    var solicitud                       =   '';
    var ubicacion                       =   '';
    var tamano                          =   '';
    var des_biop                        =   '';
    var des_cito                        =   '';
    var observac                        =   '';
    var bio_lesionSelect                =   '';
    var bio_aspectoSelect               =   '';
    var bio_ant_previosSelect           =   '';
    var html_nmuestras                  =   '';
    var html_ncitologia                 =   '';
    var bio_ant_nMuestasSelect          =   '';
    var display_nmuestras               =   false;
    var display_ncitologia              =   false;
    var bio_ant_nCitologia              =   1;
    var num_muestras_anatomia           =   1;
    var num_muesteas_citologia          =   1;
    var arr_tabla_bio                   =   '';
    var PLANTILLA_ANATOMIA              =   '';
    var USO_CASSETTE                    =   '';
    if(id == 2){
        solicitud                       =   $("#bio_extraInput_form").val();
        ubicacion                       =   $("#bio_ubicaInput_form").val();
        tamano                          =   $("#bio_tamannoInput_form").val();
        des_biop                        =   $("#bio_des_BiopsiaInput_form").val();
        des_cito                        =   $("#bio_des_CitologiaInput_form").val();
        observac                        =   $("#bio_observTextarea_form").val();
	bio_lesionSelect                =   $("#bio_lesionSelect_form").val();
        bio_aspectoSelect               =   $("#bio_aspectoSelect_form").val();;
        bio_ant_previosSelect           =   $("#bio_ant_previosSelect_form").val();
        bio_ant_nMuestasSelect          =   $("#bio_ant_nMuestasSelect_form").val();
        bio_ant_nCitologia              =   $("#bio_ant_nCitologia").val();
        PLANTILLA_ANATOMIA              =   $("#tabla_biopsia").data().MAIN_ANATOMIA_PLANTILLA;
        USO_CASSETTE                    =   $("#tabla_biopsia").data().MAIN_ANATOMIA_USOCASSET;
        var arr_tabla_bio               =   $("#tabla_biopsia").data().arr_muestra;
        //console.log("---------------------------------------------------------");
        //console.log("-----tabla_biopsia-data-------->",arr_tabla_bio,"<-------");
        //console.log("---------------------------------------------------------");
        if(arr_tabla_bio.length>0){
            var num_muestras_anatomia   =   arr_tabla_bio.length;  
            var aux_nmuestra            =   1;
            $.each(arr_tabla_bio,function(i,item){
                html_nmuestras	+=  html_tr_nummuestras({
                                            NUM_MUESTRA : aux_nmuestra,
                                            TXT_OBSERVACION : item['TXT_MUESTRA'],
                                            IND_ETIQUETA : item['IND_ETIQUETA']==null?'2':item['IND_ETIQUETA'],
                                            DATA : item,
                                            USO_CASSETTE : false,
                                        });
                aux_nmuestra++;
            });
            display_nmuestras = true;
        }
        //**********************************************************************
        var arr_tabla_cito              =   $("#tabla_biopsia").data().arr_citologia;
        if(arr_tabla_cito.length>0){
            var num_muesteas_citologia  =   arr_tabla_cito.length;   
            var aux_ncitologia          =   1;
            $.each(arr_tabla_cito,function(i,item){
                html_ncitologia         +=  html_tr_ncitologia({
                                            NUM_MUESTRA : aux_ncitologia,
                                            TXT_OBSERVACION : item['TXT_MUESTRA'],
                                            IND_ETIQUETA : item['IND_ETIQUETA']==null?'2':item['IND_ETIQUETA'],
                                            NUM_ML : item['NUM_ML'],
                                            DATA : item,
                                        }); 
                aux_ncitologia++;                        
            });
            display_ncitologia              =   true;
        } 
    } else {
        
        html_nmuestras                      +=  html_tr_nummuestras({NUM_MUESTRA:1,IND_ETIQUETA:2,USO_CASSETTE:false});
        html_ncitologia                     +=  html_tr_ncitologia({NUM_MUESTRA:1,IND_ETIQUETA:2}); 
        
        switch(value_biopsia){
            case "1":
                display_nmuestras           =   true;
                display_ncitologia          =   false;
            break;
            case "2":
                display_nmuestras           =   true;
                display_ncitologia          =   false;
            break;
            case "3":
                display_nmuestras           =   true;
                display_ncitologia          =   false;
            break;
            case "4":
                display_nmuestras           =   true;
                display_ncitologia          =   true;
            break;
            case "5":
               
                display_nmuestras           =   false;
                display_ncitologia          =   true;
            break;
            default:
                display_nmuestras           =   true;
                display_ncitologia          =   true;
            break;
        }
    }
    
    var display_none_li_muestras            =   '';
    var display_none_li_mcitologia          =   '';
    
    if(display_nmuestras){
        var checked_cassette                =   $("#tabla_biopsia").data().MAIN_ANATOMIA_USOCASSET==1?'checked':'';
        var views_cassette                  =   $("#tabla_biopsia").data().MAIN_ANATOMIA_USOCASSET==1?'':'display:none';
        var html_muestras_anatomia          =   '<div class="panel panel-success">'+
                                                    '<div class="panel-heading" style="padding: 2px 0px 5px 18px;">'+
                                                        '<div class="grid_panel_anatomia">'+
                                                            '<h3 class="panel-title">'+
                                                                '<b>&nbsp;IDENTIFICACI&Oacute;N MUESTRAS DE ANATOM&Iacute;A PATOL&Oacute;GICA</b>'+
                                                            '</h3>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<form id="form_anatomia_nmuestras" name="form_anatomia_nmuestras">'+
                                                        
                                                        '<table class="table table-striped" style="width:100%;margin-bottom:0px;">'+
                                                            '<thead>'+
                                                                '<tr>'+
                                                                    '<td style="width: 50%"><b>N&deg; DE MUESTRAS:</b></td>'+
                                                                    '<td style="width: 50%">'+
                                                                        '<select style="width: 65px;" class="form-control input-sm" name="bio_ant_nMuestasSelect" id="bio_ant_nMuestasSelect" onchange="js_htmlnummuestra(this.id,this.value)">' +
                                                                            '<option value="1" ';  if(num_muestras_anatomia == 1 ){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>1</option>'+
                                                                            '<option value="2" ';  if(num_muestras_anatomia == 2 ){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>2</option>'+
                                                                            '<option value="3" ';  if(num_muestras_anatomia == 3 ){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>3</option>'+
                                                                            '<option value="4" ';  if(num_muestras_anatomia == 4 ){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>4</option>'+
                                                                            '<option value="5" ';  if(num_muestras_anatomia == 5 ){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>5</option>'+
                                                                            '<option value="6" ';  if(num_muestras_anatomia == 6 ){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>6</option>'+
                                                                            '<option value="7" ';  if(num_muestras_anatomia == 7 ){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>7</option>'+
                                                                            '<option value="8" ';  if(num_muestras_anatomia == 8 ){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>8</option>'+
                                                                            '<option value="9" ';  if(num_muestras_anatomia == 9 ){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>9</option>'+
                                                                            '<option value="10" '; if(num_muestras_anatomia == 10){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>10</option>'+
                                                                            '<option value="11" '; if(num_muestras_anatomia == 11){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>11</option>'+
                                                                            '<option value="12" '; if(num_muestras_anatomia == 12){ html_muestras_anatomia+='selected'; } html_muestras_anatomia+='>12</option>'+
                                                                        '</select>'+
                                                                    '</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<td ><b>PLANTILLA:</b></td>'+
                                                                    '<td >'+
                                                                        '<select style="width:300px;" class="form-control input-sm" name="IND_PLANTILLA_ANATOMIA" id="IND_PLANTILLA_ANATOMIA" onchange="PLANTILLA_MANATOMIA(this.id,this.value)">'+
                                                                            '<option value="0"';    html_muestras_anatomia+=PLANTILLA_ANATOMIA==0?'selected':'';     html_muestras_anatomia+='>DEFAULT</option>'+
                                                                            '<option value="1"';    html_muestras_anatomia+=PLANTILLA_ANATOMIA==1?'selected':'';     html_muestras_anatomia+='>PROTOCOLO SYDNEY</option>'+
                                                                            '<option value="2"';    html_muestras_anatomia+=PLANTILLA_ANATOMIA==2?'selected':'';     html_muestras_anatomia+='>ESTUDIO SERIADO COLON</option>'+
                                                                        '</select>'+
                                                                    '</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<td style="height: 45px;"><b>USO DE CASSETE:</b></td>'+
                                                                    '<td >'+
                                                                        '<input type="checkbox" class="form-check-input" id="AP_USO_CASSETE" onchange="js_usocassete(this.id)"'; 
                                                                        //html_muestras_anatomia+=    USO_CASSETTE?'checked':''; 
                                                                        html_muestras_anatomia+=checked_cassette+'  value="">'+
                                                                    '</td>'+
                                                                '</tr>'+
                                                            '</thead>'+
                                                        '</table>'+
                                                        
                                                        '<table class="table table-striped" style="width:100%;margin-bottom:0px;">'+
                                                            '<thead>'+
                                                                '<tr id="head_nbipsia">'+
                                                                    '<td style="width:5%;   text-align:center; height:30px;"><b>N&deg;</b></td>'+
                                                                    '<td style="width:50%;  text-align:center;"><b>OBSERVACI&Oacute;N</b></td>'+
                                                                    '<td style="width:30%;  text-align:center;"><b>TAMA&Ntilde;O EQUIQUETA</b></td>'+
                                                                    '<td style="width:5%;   text-align:center;'+views_cassette+'" class="row_cassete"><b>N&deg;</b></td>'+
                                                                    '<td style="width:5%;   text-align:center;"><i class="fa fa-cog" aria-hidden="true"></i></td>'+
                                                                '</tr>'+
                                                            '</thead>'+
                                                            '<tbody id="TBODY_NUM_MUESTRAS">'+html_nmuestras+'</tbody>'+
                                                        '</table>'+
                                                        
                                                    '</form>'+        
                                                '</div>';
        
    } else {
        display_none_li_muestras        =   'style="display:none"';
    }
    
    if(display_ncitologia){
        var html_muestras_citologia    =    '<div class="panel panel-success">'+
                                            '<div class="panel-heading" style="padding: 2px 0px 5px 18px;">'+
                                                '<div class="grid_panel_anatomia">'+
                                                    '<div class="div1_panel">'+ 
                                                        '<h3 class="panel-title">'+
                                                            '<b>&nbsp;IDENTIFICACI&Oacute;N DE N&deg; DE MUESTRA CITOLOGIA</b>'+
                                                        '</h3>'+
                                                    '</div>'+
                                                    '<div class="div1_pane2" style="justify-self: center;">'+
                                                        '<div class="input-group">'+
                                                            '<span class="input-group-addon" style="width:auto;text-align:left"><b>N&deg;</b></span>'+ 
                                                                '<select style="width: 65px;" class="form-control input-sm" name="bio_ant_nCitologia" id="bio_ant_nCitologia" onchange="js_htmlcitologia(this.id,this.value)"> ' +
                                                                    '<option value="1" ';  if(num_muesteas_citologia == 1 ){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>1</option>'+
                                                                    '<option value="2" ';  if(num_muesteas_citologia == 2 ){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>2</option>'+
                                                                    '<option value="3" ';  if(num_muesteas_citologia == 3 ){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>3</option>'+
                                                                    '<option value="4" ';  if(num_muesteas_citologia == 4 ){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>4</option>'+
                                                                    '<option value="5" ';  if(num_muesteas_citologia == 5 ){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>5</option>'+
                                                                    '<option value="6" ';  if(num_muesteas_citologia == 6 ){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>6</option>'+
                                                                    '<option value="7" ';  if(num_muesteas_citologia == 7 ){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>7</option>'+
                                                                    '<option value="8" ';  if(num_muesteas_citologia == 8 ){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>8</option>'+
                                                                    '<option value="9" ';  if(num_muesteas_citologia == 9 ){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>9</option>'+
                                                                    '<option value="10" '; if(num_muesteas_citologia == 10){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>10</option>'+
                                                                    '<option value="11" '; if(num_muesteas_citologia == 11){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>11</option>'+
                                                                    '<option value="12" '; if(num_muesteas_citologia == 12){ html_muestras_citologia+='selected'; } html_muestras_citologia+='>12</option>'+
                                                                '</select>' +
                                                            '<span class="input-group-addon" style="width:auto;text-align:left"><i class="fa fa-info" aria-hidden="true"></i></span>'+ 
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                            '<form id="form_muestras_citologia" name="form_muestras_citologia">'+
                                                '<table class="table table-striped" style="width:100%;margin-bottom:0px;">'+
                                                    '<thead>'+
                                                        '<tr id="head_nbipsia2">'+
                                                            '<td width="10%" style="height:30px;text-align:center;"><b>N&deg;</b></td>'+
                                                            '<td width="40%" style="text-align:center;"><b>OBSERVACI&Oacute;N</b></td>'+
                                                            '<td width="10%" style="text-align:center;"><b>ml.</b></td>'+
                                                            '<td width="30%" style="text-align:center;"><b>EQUIQUETA TAMA&Ntilde;O</b></td>'+
                                                            '<td width="10%" style="text-align:center;"><i class="fa fa-cog" aria-hidden="true"></i></td>'+
                                                        '</tr>' +
                                                    '</thead>'+
                                                    '<tbody id="TBODY_MUESTRAS_CITOLOGIA">'+html_ncitologia+'</tbody>'+
                                                '</table>'+
                                            '</form>'+        
                                        '</div>';
    } else {
         display_none_li_mcitologia        =   'style="display:none"';
    }
    
    var form = ''+
            '<div class="panel panel-success" style="margin-bottom:0px;">'+
                '<div class="panel-heading">'+
                    '<h3 class="panel-title" style="padding-top:0px;"><b>INFORMACI&Oacute;N PRINCIPAL ANATOMIA PATOLOGIA - ('+txt_biopsia+')</b></h3>'+
                '</div>'+
                '<form id="formulario_histo" name="formulario_histo">'+
                    '<table class="table table-striped" style="width:100%;margin-bottom: 0px;">'+
                        '<tbody>'+
                            '<tr>'+
                                '<td >SITIO DE EXTRACCI&Oacute;N</td>'+
                                '<td colspan="3"><input type="text" class="form-control input-sm" name="bio_extraInput" id="bio_extraInput" size="60" maxlength="200" value="'+solicitud+'"></td>'+
                            '</tr>'+  
                            '<tr>'+
                                '<td >UBICACI&Oacute;N</td>'+
                                '<td colspan="3"><input type="text" class="form-control input-sm" name="bio_ubicaInput" id="bio_ubicaInput" size="60" value="'+ubicacion+'" ></td></td>'+
                            '</tr>'+  
                            '<tr>'+
                                '<td >TAMA&Ntilde;O</td>'+
                                '<td colspan="3"><input type="text" class="form-control input-sm" name="bio_tamannoInput"  id="bio_tamannoInput" size="60" maxlength="200" value="'+tamano+'"></td>'+
                            '</tr>'+ 
                            '<tr>'+
                                '<td width="20%">TIPO DE LESI&Oacute;N</td>'+
                                '<td width="30%">'+ 
                                    '<select class="form-control input-sm" name="bio_lesionSelect" id="bio_lesionSelect"> ' +
                                        '<option value="">SELECCIONE...</option> ' +
                                        '<option value="1"'; if(bio_lesionSelect == 1 ){ form+='selected'; } form+='>LIQUIDO</option>'+
                                        '<option value="2"'; if(bio_lesionSelect == 2 ){ form+='selected'; } form+='>&Oacute;RGANO</option>'+
                                        '<option value="3"'; if(bio_lesionSelect == 3 ){ form+='selected'; } form+='>TEJIDO</option>'+
                                    '</select>'+
                                '</td>'+
                                '<td width="20%">'+
                                    'ASPECTO'+
                                '</td>'+    
                                '<td width="30%">'+ 
                                    '<select class="form-control input-sm" name="bio_aspectoSelect" id="bio_aspectoSelect"> ' +
                                        '<option value="">SELECCIONE...</option> ' +
                                        '<option value="1"'; if(bio_aspectoSelect == 1 ){ form+='selected'; } form+='>INFLAMATORIA</option> ' +
                                        '<option value="2"'; if(bio_aspectoSelect == 2 ){ form+='selected'; } form+='>BENIGNA</option> ' +
                                        '<option value="3"'; if(bio_aspectoSelect == 3 ){ form+='selected'; } form+='>NEOPLÃƒÂSICA</option> ' +
                                    '</select>' +
                                '</td>'+
                            '</tr>'+  
                            '<tr>'+
                                '<td>'+
                                    'ANT. PREVIOS'+
                                '</td>'+
                                '<td colspan="3">'+
                                    '<select class="form-control input-sm" name="bio_ant_previosSelect" id="bio_ant_previosSelect"> ' +
                                        '<option value="">SELECCIONE...</option> ' +
                                        '<option value="1" '; if(bio_ant_previosSelect == 1 ){ form+='selected'; } form+='>NO</option>' +
                                        '<option value="2" '; if(bio_ant_previosSelect == 2 ){ form+='selected'; } form+='>BIOPSIA </option>' +
                                        '<option value="3" '; if(bio_ant_previosSelect == 3 ){ form+='selected'; } form+='>CITOLOG&Iacute;A</option> ' +
                                    '</select>  ' +
                                '</td>'+
                            '</tr>'+ 
                            '<tr>'+
                                '<td >DESC. BIOPSIA:</td>'+
                                '<td colspan="3">'+
                                    '<input type="text" class="form-control input-sm" name="bio_des_BiopsiaInput" id="bio_des_BiopsiaInput" size="60" maxlength="200" value="'+des_biop+'">'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td >DESC. CITOLOG&Iacute;A:</td>'+
                                '<td colspan="3">'+
                                    '<input type="text" class="form-control input-sm" name="bio_des_CitologiaInput"  id="bio_des_CitologiaInput" size="60" maxlength="200" value="'+des_cito+'">'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td valign="top">'+
                                    'OBSERVACIONES'+
                                '</td>'+
                                '<td colspan="3">'+
                                    '<textarea  class="form-control input-sm" id="bio_observTextarea" name="bio_observTextarea" cols="4" rows="2" style="margin: 0px; width: 517px; height: 91px;" maxlength="500">'+observac+'</textarea> ' +
                                '</td>'+
                            '</tr>'+ 
                        '</tbody>'+
                    '</table>'+    
                '</form>'+    
            '</div>';
    
    var nav_form    =   '';
    nav_form        =   '<div id="nav_anatomia_patologia">'+
                            '<ul class="nav nav-tabs nav-justified" role="tablist">'+
                                '<li class="nav-item active" id="LI_MAIN_ANATOMIA">'+
                                    '<a class="nav-link" data-toggle="tab" href="#ID_MAIN_ANATOMIA" role="tab" aria-expanded="true">'+
                                        '<i class="fa fa-file-text-o" aria-hidden="true"></i><b>&nbsp;INFORMACI&Oacute;N ANATOMIA</b>'+
                                    '</a>'+
                                '</li>'+
                                '<li class="nav-item" id="LI_MUESTRAS" '+display_none_li_muestras+'>'+
                                    '<a class="nav-link" data-toggle="tab" href="#ID_MUESTRAS_PRINCIPAL" role="tab" aria-expanded="false">'+
                                        '<i class="fa fa-list-ol" aria-hidden="true"></i>&nbsp;<b>MUESTRAS ANATOMIA</b>&nbsp;<span class="badge" id="num_ic_0">'+num_muestras_anatomia+'</span>'+
                                    '</a>'+
                                '</li>'+
                                '</li><li class="nav-item" id="LI_MUESTRAS_CITOLOGIA" '+display_none_li_mcitologia+'>'+
                                    '<a class="nav-link" data-toggle="tab" href="#ID_MUESTRAS_CITOLOGIA" role="tab" aria-expanded="false">'+
                                        '<i class="fa fa-list-ol" aria-hidden="true"></i>&nbsp;<b>MUESTRAS CITOLOGIA</b>&nbsp;<span class="badge" id="num_ic_1">'+num_muesteas_citologia+'</span>'+
                                    '</a>'+
                                '</li>'+
                            '</ul>'+
                            '<div class="tab-content">'+
                                '<div class="tab-pane active"    id="ID_MAIN_ANATOMIA"       role="tabpanel">'+form+'</div>'+
                                '<div class="tab-pane"           id="ID_MUESTRAS_PRINCIPAL"  role="tabpanel">'+html_muestras_anatomia+'</div>'+
                                '<div class="tab-pane"           id="ID_MUESTRAS_CITOLOGIA"  role="tabpanel">'+html_muestras_citologia+'</div>'+
                            '</div>'+
                        '</div>'; 
    $("#HTML_ANATOMIAPATOLOGICA").html(nav_form);
    $("#MODAL_ANATOMIAPATOLOGICA").modal("show");
    $("#BTN_ANATOMIAPATOLOGICA").attr('onclick','js_guardaanatomia()').data({
        value_biopsia : value_biopsia,
        txt_biopsia : txt_biopsia,
        display_nmuestras : display_nmuestras,
        display_ncitologia : display_ncitologia 
    });
}

//EDITANDO EL FORMULARIO DE ANATOMIA PATOLOGICA
function FORM_ANATOMIA_PATOLOGICA_GESPAB(id){
    /*
        console.log("-----------------------------------");
        console.log("id         ->",id,"<-              ");
        console.log("-----------------------------------");
    */
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_listagespab/html_solicitud_anatomia_pre_gespab",
        dataType : "json",
        beforeSend : function(xhr) { },
        data : { id : id, },
        error : function(errro) { 
            console.log(errro);  
            console.log(errro.responseText); 
            jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
        },
        success : function(aData) { 
            if(aData['STATUS']){
                $("#HTML_ANATOMIA_PATOLOGICA").html(aData['GET_HTML']);
                $("#MODAL_FORM_ANATOMIA_PATOLOGICA").modal({backdrop:'static',keyboard:false}).modal("show");
            } else {
                jAlert(aData['TXT_SALIDA'],"Clinica Libre");
                UPDATE_MAIN();
            }
        }, 
    });
}

function nuevo_form_apatologica(fichae){
    var msj                                 =   [];
    //console.log("fichae                   =>  ",fichae);
    $('#IND_TIPO_BIOPSIA').selectpicker('setStyle','btn-danger btn-fill','remove');
    if($("#IND_TIPO_BIOPSIA").val()         ==  ''){
        $('#IND_TIPO_BIOPSIA').selectpicker('setStyle','btn-danger btn-fill','add');
        msj.push("<li>Indicar <b>Tipo de biopsia</b></li>");
    }
    if(msj.length>0){
        jAlert("Se Han Detectado Falta De Informaci&oacute;n <br>"+msj.join(""),"Clinica Libre");
        return false;
    } else {
        var data = {
            ID_GESPAB : $("#GESTOR_PROTOCOLO_"+fichae).data().paciente.ID,
            NUM_FICHAE : $("#GESTOR_PROTOCOLO_"+fichae).data().paciente.FICHAE,
            RUT_PACIENTE : $("#GESTOR_PROTOCOLO_"+fichae).data().paciente.COD_RUTPAC,
            ID_MEDICO : null,
            RUT_MEDICO : $("#GESTOR_PROTOCOLO_"+fichae).data().ciru1.COD_RUTPRO,
            IND_TIPO_BIOPSIA : $("#IND_TIPO_BIOPSIA").val(),// 
            IND_ESPECIALIDAD : $("#GESTOR_PROTOCOLO_"+fichae).data().paciente.ID_SERDEP,
            PA_ID_PROCARCH : 36,
            AD_ID_ADMISION : null,
            TXT_BIOPSIA : $("#IND_TIPO_BIOPSIA option:selected").text(),
            CALL_FROM : 2, 
            ZONA_PAB : $("#ZONA_PABELLON").val(),
            IND_GESPAB : 1,
        }
        load_form_histopatologico(data);                                                
    }                                      
}

function load_form_histopatologico(data){
    $.ajax({ 
        type : "POST",
        url : "ssan_spab_gestionlistaquirurgica/FORMULARIO_ANATOMIA_PATOLOGICA_V2",
        dataType : "json",
        beforeSend : function(xhr) { },
        data : data,
        error : function(errro) {   
            console.log(" =>  ",errro," ");
            console.log(" =>  ",errro.responseText," ");
            $("#HTML_TEMPLATE_3_PASEQUIRUGICO").html(''); 
            $("#MODAL_INICIO_SOLICITUD_ANATOMIA").modal("hide"); 
            jAlert("<b> Error General, Consulte Al Administrador</b>","Clinica Libre"); 
        },
        success : function(aData) { 
            console.log("aData -> ",aData);
            $("#HTML_ANATOMIA_PATOLOGICA").html("").html(aData["HTML_FINAL"]);
        }, 
    });
} 

function popover_etiquetas(id,num){
    //console.log("--------popover_etiquetas----------------");
    //console.log("id           ->  BTN_ZPL_",id);
    //console.log("num          ->  BTN_ZPL_",num);
    //console.log("data         -> ",$("#BTN_ZPL_"+num).data());
    var V_TAMANO_ETIQUETA   =   '';
    //console.log("V_TAMANO_ETIQUETA->",V_TAMANO_ETIQUETA);
    $(".popover").popover("hide");
    var ind_conf_frasco     =   localStorage.getItem("confi_frasco");
    //console.log(" CONFIG_FRASCO     ->      ",ind_conf_frasco);
    var num_comuna          =   localStorage.getItem("v_num_comuna")==null?'5':localStorage.getItem("v_num_comuna");
    var num_fila            =   localStorage.getItem("v_num_fila")==null?'5':localStorage.getItem("v_num_fila");
    console.log("num_fila       ->",num_fila,"num_comuna     ->",num_comuna);
    
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_spab_gestionlistaquirurgica/visualizacion_etiqueta_cu",
        dataType            :   "json",
        beforeSend          :   function(mientras)  {   
                                                        console.log("xhr->",mientras);
                                                    },
        data                :                       {   
                                                        id                  :   num,
                                                        CONFIG_FRASCO       :   ind_conf_frasco,
                                                        V_TAMANO_ETIQUETA   :   V_TAMANO_ETIQUETA,
                                                        num_comuna          :   num_comuna,
                                                        num_fila            :   num_fila,
    
                                                    },
        error               :   function(errro)     {  
                                                        console.log(errro);
                                                        console.log("errro.responseText:",errro.responseText);
                                                        jAlert("<b>Error general, Consulte al administrador</b>","Clinica Libre"); 
                                                    },
        success             :   function(aData)     { 
            
                                                        console.log(aData);
                                                        $("#"+id).popover({
                                                            html            :   true,
                                                            container       :   'body',
                                                            content         :   aData['GET_HTML'],
                                                            title           :   '<b>ETIQUETAS</b>&nbsp;<button type="button" id="close" class="close" onclick="$(&quot;.popover&quot;).popover(&quot;hide&quot;);">&times;</button',
                                                            trigger         :   'manual',   //hover //focus //click //manual
                                                        }).popover('show');
                                                    }, 
    });
}



function IMPRIME_ETIQUETA_ANATOMIA(id){
    //console.log("id         ->  ",id);
    var num_comuna          =   localStorage.getItem("v_num_comuna")==null?'5':localStorage.getItem("v_num_comuna");
    var num_fila            =   localStorage.getItem("v_num_fila")==null?'5':localStorage.getItem("v_num_fila");
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_spab_gestionlistaquirurgica/imprime_etiqueta_gespab",
        dataType            :   "json",
        beforeSend          :   function(xhr)       {   console.log("xhr->",xhr);   },
        data                :                       {
                                                        id_anatomia         :   id,
                                                        ind_centrado        :   localStorage.getItem("confi_frasco"),
                                                        num_comuna          :   num_comuna,
                                                        num_fila            :   num_fila,
                                                    },
        error		    :   function(errro)     { 
                                                        console.log(errro);  
                                                        console.log(errro.responseText);    
                                                        jAlert("Error General, Consulte Al Administrador","Clinica Libre");
                                                    },
        success             :   function(aData)     { 
                                                        console.log("       imprime_etiqueta_gespab         ");
                                                        console.log("       ->  ",aData,"   <-              ");
                                                        if(opt_imprime(aData['ZPL_FINAL_OUT'])){
                                                            console.log("imprime");
                                                            showNotification('top','left','Se imprimio etiquetas',1,'fa fa-print');
                                                        } else {
                                                            console.log("no imprime");
                                                        }
                                                    }, 
    });
}

function js_recorre_zpl(){
    $('#loadFade').modal('show');
    var valor                   =   0;
    var arr                     =   [];
    var ul_nav_tabs             =   [];
    var tabs_tab_panel          =   [];
    $("#ul_nav_tabs").html('');
    $("#tabs_tab_panel").html('');
    $(".arr_zpl").each(function(index,value){
        var V_NUMERO_MUESTRA    =   $("#"+value.id).data('zpl').NUMERO_MUESTRA;
        var V_BODY_ZPL          =   $("#"+value.id).data('zpl').BODY_ZPL;
        var TAMANO_ETIQUETA     =   $("#"+value.id).data('zpl').TAMANO_ETIQUETA;
        arr.push({
            code_zpl            :   V_BODY_ZPL,
            num_muestra         :   V_NUMERO_MUESTRA,
            TAMANO_ETIQUETA     :   TAMANO_ETIQUETA,
        });
        var html_onclick        =   valor == 0 ? '' : 'onclick="js_vista_etiqueta_pdf('+V_NUMERO_MUESTRA+')"';
        ul_nav_tabs.push('<li role="presentation" id="ind_onclick_'+V_NUMERO_MUESTRA+'" '+html_onclick+' data-zpl="'+V_BODY_ZPL+'" data-TAMANO_ETIQUETA="'+TAMANO_ETIQUETA+'" ><a href="#TABS_'+valor+'" data-toggle="tab" role="tab" aria-controls="TABS_'+valor+'" aria-selected="false">N&deg;: '+V_NUMERO_MUESTRA+'</a></li>');
        tabs_tab_panel.push('<div role="tabpanel" class="tab-pane" id="TABS_'+valor+'" aria-labelledby="TABS_'+valor+'_1"><div id="pdf_to_'+V_NUMERO_MUESTRA+'"></div></div>');
        valor++;
    });
    
    $("#ul_nav_tabs").append(ul_nav_tabs.join(""));
    $("#tabs_tab_panel").append(tabs_tab_panel.join(""));
    $('#ul_nav_tabs li:first-child a').tab('show');
    $("#modal_vista_zpl_to_pdf").modal({backdrop:'static',keyboard:false}).modal("show");
    generar_zpl_to_pdf(arr[0].code_zpl,arr[0].num_muestra,arr[0].TAMANO_ETIQUETA);
    //$('#loadFade').modal('hide');
    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
}

function js_vista_etiqueta_pdf(V_NUMERO_MUESTRA){
    //console.log("V_NUMERO_MUESTRA   ->  ",V_NUMERO_MUESTRA);
    var V_BODY_ZPL                      =   $("#ind_onclick_"+V_NUMERO_MUESTRA).data("zpl");
    var TAMANO_ETIQUETA                 =   $("#ind_onclick_"+V_NUMERO_MUESTRA).data("tamano_etiqueta");
    $("#ind_onclick_"+V_NUMERO_MUESTRA).attr('onclick','');
    generar_zpl_to_pdf(V_BODY_ZPL,V_NUMERO_MUESTRA,TAMANO_ETIQUETA);
}

function generar_zpl_to_pdf(txt_zpl,num_muestra,V_TAMANO_ETIQUETA){
    var ind_conf_frasco                 =   localStorage.getItem("confi_frasco");
    /*
    console.log("generar_zpl_to_pdf     ->   ");
    console.log("INTO                   ->  ",txt_zpl);
    console.log("num_muestra            ->  ",num_muestra);
    console.log("V_TAMANO_ETIQUETA      ->  ",V_TAMANO_ETIQUETA);
    */
    $(".popover").popover("hide");
    /*
    console.log("-------------------------------------------------------------------------------");
    console.log("http://api.labelary.com/v1/printers/8dpmm/labels/4x6/0/"+txt_zpl);
    console.log("-------------------------------------------------------------------------------");
    */
    $.ajax({ 
        type : "POST",
        url : "ssan_spab_gestionlistaquirurgica/php_generar_zpl_to_pdf",
        dataType : "html",//SOLO PARA PDF
        beforeSend : function(mientras) { console.log("xhr->",mientras);  $('#loadFade').modal('show'); },
        data : {   
            txt_zpl : txt_zpl,
            V_TAMANO_ETIQUETA : V_TAMANO_ETIQUETA,
        },
        error : function(errro) {  
            console.log("errro      :   ",errro,"                               ");
            console.log("errro      :   ",errro.responseText,"                  ");
            jAlert("<b>Error general, Consulte al administrador</b>","Clinica Libre"); 
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
        },
        success : function(aData) { 
            var base64str = aData;
            console.log("base64str -> ",base64str);
            //decode base64 string, 
            //Eliminar espacio para compatibilidad con IE
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
            $('#pdf_to_'+num_muestra).html(Objpdf);
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
        }, 
    });
}

function js_vista_log(id){
    /*
        console.log("---------------------------------------------------------------");
        console.log("id             ->  ",id,"  <-                                  ");
        console.log("data_bd_form   ->  ",$("#data_bd_form").data(),"   <-          ");
        console.log("---------------------------------------------------------------");
    */
    var css_grid_logs = '<div class="grid_popover_log">'+
                            '<div class="grid_popover_log1">'+JSON.stringify($("#data_bd_form").data().log)+'</div>'+
                        '</div>';
    //console.log("-----------------------");                
    //console.log("->",css_grid_logs);
    //console.log("-----------------------");
    $("#BTN_INFO_LOGS_"+id).popover({
        html : true,
        container : "#grid_popover_log",
        title : '<b>logs</b>&nbsp;<button type="button" id="close" class="close" onclick="$(&quot;.popover&quot;).popover(&quot;hide&quot;);">&times;</button',
        trigger : 'manual',   //hover //focus //click //manual
        content : 'hola', 
    });
}

//solo informacion panel de gestion de muestras
function js_viwes_popover(id,name){
    var txt_id = id.split("_")[3];
    var txt_titulo = '';
            if  (name == 'BTN_INFO_HISPATOLOGICO'){
        $('#BTN_INFO_LOGS_'+txt_id).popover('hide');
        txt_titulo = 'FORMULARIO';
    } else  if  (name == 'BTN_INFO_LOGS'){
        txt_titulo = 'LOGS';
        $('#BTN_INFO_HISPATOLOGICO_'+txt_id).popover('hide');
    }
    $("#"+id).popover({
        html : true,
        container : 'body',
      //content : " -> "+id,
        title : '<b style="font-size:12px;">'+txt_titulo+'</b>&nbsp;<button type="button" id="close" class="close" onclick="$(&quot;.popover&quot;).popover(&quot;hide&quot;);">&times;</button>',
        trigger : 'manual', //hover //focus //click //manual
    }).popover('toggle');
}

function js_fist_marcado(value){
    $("#get_etiqueta_modal").val(value);
    busqueda_etiquera_modal(0);
}

function return_arr(busq){
    var array_nmuestras2        =   new Array();
    var ind_encontrado          =   false;
    $('.lista_anatomia').each(function(i,obj){
        //INDICA SI SE ENCONTRO ALGUNA EN LA LISTA DISPONIBLE
        if(busq === obj.id )        {   ind_encontrado = true;  }
        array_nmuestras2.push({
            VALUE   :   obj.id,
            CHECK   :   document.getElementById("CHEK_"+obj.id).checked,
            FOUND   :   busq===obj.id?true:false,
            TABS    :   $("#"+obj.id).data().num_tabs
        });
        
    });
    //**************************************************************************
    var IDs                     =   new Object();
    IDs['ARR2']                 =   array_nmuestras2;
    IDs['STATUS']               =   ind_encontrado;
    //**************************************************************************
    return IDs;
}

function busqueda_etiquera_modal(from){
    var get_etiqueta_modal      =   from === 0 ? $("#get_etiqueta_modal").val() : from;
    /*
        console.log("---------------------------------------------------------------");
        console.log("from               ->  ",from,"                                ");
        console.log("get_etiqueta_modal ->  ",get_etiqueta_modal,"                  ");
        console.log("---------------------------------------------------------------");
    */
    if  (get_etiqueta_modal === null || get_etiqueta_modal ==''){ document.getElementById("get_etiqueta_modal").focus(); return false;  }
    var array_list              =   return_arr(get_etiqueta_modal);
    if  (array_list.STATUS)     {
        showNotification('top','right',"Se agreg&oacute; nueva etiqueta "+get_etiqueta_modal,2,'fa fa-check');
        var arr                 =   array_list.ARR2;
        arr.forEach(function(VALUE){
            /*
                console.log("***********************************************");
                console.log("VALUE      =>  ",VALUE,"   <=                  ");
                console.log("***********************************************");
            */
            if(VALUE.CHECK===true||VALUE.FOUND===true){
                document.getElementById("CHEK_"+VALUE.VALUE).checked = true;
                $("#"+VALUE.VALUE).addClass("list-group-item-success");
                $("#btn_"+VALUE.VALUE).html('<span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i></span>');
                if (VALUE.FOUND===true){
                    $('#UL_TABS_MUESTRA a[href="#TABS_'+VALUE.TABS+'"]').tab('show');
                }
            }
        });
    } else {
        console.log("   get_etiqueta_modal      ->  ",get_etiqueta_modal);
        showNotification('top','right','No se encontro etiqueta',4,'fa fa-times');
        jConfirm('Muestra selecci&oacute;nala <b>'+get_etiqueta_modal+'</b> corresponde a otra solicitud. &iquest;Desea Agregar?','Clinica Libre',function(r) {
            if(r){ 
                //console.log("------------------------------------------------------------");
                //console.log("get_etiqueta_modal     =>  ",get_etiqueta_modal);
                //console.log("------------------------------------------------------------");
                busqueda_etiquera(1,get_etiqueta_modal,{});
            } else {
                console.log("-------------");
                console.log("-> DIJO NO <-");
                console.log("-------------");
            }
        });
    }
    $("#get_etiqueta_modal").val('').focus();
}

function add_muestra(value){
    console.log("---------------------------------------");
    console.log("BUSCAR  y hacer tabs =>  ",value,"   ");
    console.log("---------------------------------------");
}

function BTN_MARCA_ALL(id){
    var estados                     =   $('.BTN_CHECKED_ALL_'+id).data().toggle;
    console.log("estados            ->  ",estados);
    $('.BTN_CHECKED_ALL_'+id).data().toggle = !estados;
    $('.grupo_'+id).each(function(i,obj){
        if(!estados){
            $("#"+obj.id).removeClass("list-group-item-danger");
            $("#"+obj.id).addClass("list-group-item-success");
            document.getElementById("CHEK_"+obj.id).checked     =   true;
            $("#btn_"+obj.id).html('<span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i></span>');
            var id_muestra                                      =   $("#"+obj.id).data().id_muestra;
            $("#collapseOne"+id_muestra).collapse('hide');
            $("#SEL_MOTIVO_"+id_muestra).prop("disabled",true).val('');
            $("#txt_observacion_"+id_muestra).prop("disabled",true).val('');
            
        } else {
            $("#"+obj.id).removeClass("list-group-item-success");
            $("#"+obj.id).addClass("list-group-item");
            document.getElementById("CHEK_"+obj.id).checked     =   false;
            $("#btn_"+obj.id).html('<span class="label label-danger"><i class="fa fa-times" aria-hidden="true"></i></span>');
            var id_muestra                                      =   $("#"+obj.id).data().id_muestra;
            $("#collapseOne"+id_muestra).collapse('hide');
            $("#SEL_MOTIVO_"+id_muestra).prop("disabled",false).val('');
            $("#txt_observacion_"+id_muestra).prop("disabled",false).val('');
        }
    });
}

function js_muestra_indivual(get_etiqueta_modal){
        //console.log("---------------------------------------------------");
        //console.log(" js_muestra_indivual -> ",get_etiqueta_modal);
        //console.log("---------------------------------------------------");
        $("#"+get_etiqueta_modal).removeClass("list-group-item-danger");
    if( document.getElementById("CHEK_"+get_etiqueta_modal).checked ){
        $("#"+get_etiqueta_modal).addClass("list-group-item-success");
        $("#btn_"+get_etiqueta_modal).html('<span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i></span>');
        //disabled
        $("#collapseOne"+get_etiqueta_modal).collapse('hide').collapse('dispose');
        $("#SEL_MOTIVO_"+document.getElementById("CHEK_"+get_etiqueta_modal).value).prop("disabled",true).val('');
        $("#txt_observacion_"+document.getElementById("CHEK_"+get_etiqueta_modal).value).prop("disabled",true).val('');
    } else {
        console.log("get_etiqueta_modal ->",get_etiqueta_modal);
        $("#"+get_etiqueta_modal).removeClass("list-group-item-success");
        $("#btn_"+get_etiqueta_modal).html('<span class="label label-danger"><i class="fa fa-times" aria-hidden="true"></i></span>');
        $("#SEL_MOTIVO_"+document.getElementById("CHEK_"+get_etiqueta_modal).value).prop("disabled",false);
        $("#txt_observacion_"+document.getElementById("CHEK_"+get_etiqueta_modal).value).prop("disabled",false);
    }
    $("#get_etiqueta_modal").val('');
    return true;
} 

//VALIDA Y RECUPERA LA INFORMACION
function get_lista_activos(id_anatomia){
    
    console.log("star get_lista_activos");
    console.log("id_anatomia            -> ",id_anatomia);
    
    var ARRAY_NMUESTRAS                 =   new Array();
    var arr_adverso_no_constado         =   new Array();
    var NUM_CHECKED                     =   0;
    var NUM_CHECKED_NO                  =   0;
    var NUM_ANTEC_ADVERSOS              =   0;
    var LIST_BUSQ                       =   id_anatomia===''?'.lista_anatomia':'.grupo_'+id_anatomia;
    
    console.log("LIST_BUSQ              ->  ",LIST_BUSQ);
    
    $(LIST_BUSQ).each(function(index,value){
        /*
        console.log("-------------------------LIST_BUSQ-------------------------");
        console.log("index              ->",index);
        console.log("-----------------------------------------------------------");
        console.log("value              ->",value);
        console.log("-----------------------------------------------------------");
        console.log("this.id.data       ->  ",$("#"+this.id).data());
        console.log("-----------------------------------------------------------");
        */
        var id_muestra                  =   $("#"+this.id).data().id_muestra;
        var ind_casete                  =   $("#"+this.id).data().casete;
        NUM_CHECKED                     =   document.getElementById("CHEK_"+this.id).checked?1:0;
        NUM_CHECKED_NO                  =   document.getElementById("CHEK_"+this.id).checked?0:1;
        var no_checked_no_constado      =   false;
        var array_adversos              =   new Array();
        if(!document.getElementById("CHEK_"+this.id).checked && ($("#SEL_MOTIVO_"+id_muestra).val()=='' || $("#txt_observacion_"+id_muestra).val()=='')){
            no_checked_no_constado      =   true;
            arr_adverso_no_constado.push({id_muestra:id_muestra});
            $("#"+this.id).addClass("list-group-item-danger");
            $("#collapseOne"+id_muestra).collapse('show');
        } else {
            $("#"+this.id).removeClass("list-group-item-danger");
            $("#"+this.id).addClass("list-group-item-default");
        }
        /*
            console.log("----------------------------------------------------------");
            console.log("no_checked_no_constado => ",no_checked_no_constado);
            console.log("----------------------------------------------------------");
        */
        //ANTENCEDENTES ADVERSOS
        if(!document.getElementById("CHEK_"+this.id).checked && ($("#SEL_MOTIVO_"+id_muestra).val()!=''||$("#txt_observacion_"+id_muestra).val()!='')){
            array_adversos.push({
                "TXT_MOTIVO"        :   $("#SEL_MOTIVO_"+id_muestra+" option:selected").text(),
                "IND_MOTIVO"        :   $("#SEL_MOTIVO_"+id_muestra).val(),
                "TXT_OBSERVACION"   :   $("#txt_observacion_"+id_muestra).val()
            });
            NUM_ANTEC_ADVERSOS++;
        }
        /*
            console.log("array_adversos     ->  ",array_adversos);
            console.log("data               ->  ",$("#"+this.id).data().data_muestra.TXT_MUESTRA);
        */
        ARRAY_NMUESTRAS.push({ 
            TXT_MUESTRA                 :   $("#"+this.id).data().data_muestra.TXT_MUESTRA,
            ID_HISTO                    :   $("#"+this.id).data().id_solicitud,
            ID_NMUESTRA                 :   id_muestra,
            IND_CASETE                  :   ind_casete,
            NUM_NMUESTRA                :   this.id,
            CHECKED                     :   document.getElementById("CHEK_"+this.id).checked,
            IN_CHECKED                  :   document.getElementById("CHEK_"+this.id).checked?1:0,
            NO_CHECKED_CON_DATOS        :   no_checked_no_constado,
            V_IND_EVENTO_ADVERSO        :   $("#SEL_MOTIVO_"+id_muestra).val(),
            V_TXT_EVENTO_OBSERVACION    :   $("#txt_observacion_"+id_muestra).val(),
            ARR_EVENTOS_ADVERSOS        :   array_adversos,
        });
        /*
            console.log("-----------------------------------------------------------");
            console.log("--------------------",id_histo,"---------------------------");
            console.log("ARRAY_NMUESTRAS     ",ARRAY_NMUESTRAS,"                    ");
            console.log("-----------------------------------------------------------");
        */
    });
    var _return     =   {
                    "NUM_HISTO"             :   id_anatomia,
                    "NUM_CHECKED"           :   NUM_CHECKED,//contado para restricion
                    "NUM_CHECKED_NO"        :   NUM_CHECKED_NO,
                    "ALL_OK_SAMPLES"        :   NUM_CHECKED_NO===0?true:false,
                    "NUM_OK_SAMPLES"        :   NUM_CHECKED_NO===0?1:0,
                    "NUM_MUESTRAS"          :   ARRAY_NMUESTRAS.length,
                    "ARRAY_NMUESTRAS"       :   ARRAY_NMUESTRAS,
                    "NO_CHECKED_SIN_DATOS"  :   arr_adverso_no_constado.length>0?true:false, 
                    "INFO_PENDIENTE"        :   arr_adverso_no_constado,
                    "NUM_ANTEC_ADVERSOS"    :   NUM_ANTEC_ADVERSOS,
                };
    console.log("_return    ->  ",_return);
    console.log("star get_lista_activos");
    return _return;
}


//******************************************************************************
//********************* fase 1 a custodia **************************************
//********************* CUSTODIA INDIVIDUAL ************************************
//******************************************************************************
function confirma_custodia(id_anatomia){
    var STATUS_MUESTRAS             =   get_lista_activos(id_anatomia);
    /*
        console.log("-------------------------------------------------------");
        console.log("LISTA_ANATOMIA -> ",LISTA_ANATOMIA,"<- ");
        console.log("-------------------------------------------------------");
    */
    if(STATUS_MUESTRAS.NO_CHECKED_SIN_DATOS){   
        jError("Existe informaci&oacute;n incompleta en la solicitud","Clinica Libre");  
        return false;   
    }
    var LISTA_ANATOMIA              =   {   RESUL   :   []  };
    LISTA_ANATOMIA.RESUL.push(STATUS_MUESTRAS);
    if(!STATUS_MUESTRAS.NUM_CHECKED){
        jConfirm('No todas las muestras fueron marcadas. la solicitud quedara en <b>estado incompleta</b> para custoria. &iquest;Desea Agregar?','Clinica Libre',function(r){
            if(r){ 
                _envios(id_anatomia,0,LISTA_ANATOMIA);
            } else {
                console.log(" -> DIJO NO <- ");
            }
        });
        return false;
    } else {
        _envios(id_anatomia,0,LISTA_ANATOMIA);
    }
}

//CUSTODIA ALL
function confirma_custodia_all(fase){
    var LISTA_ANATOMIA          =   {   RESUL   :   []  };
    var traffic_all             =   true;
    var txt_busuqeda            =   fase == 1 ? '.all_solicitudes_custodia':'.all_solicitudes_custodia';
    //console.log(" txt_busuqeda  ->",txt_busuqeda);
    $(txt_busuqeda).each(function(index,value){
        
        console.log("-----------------------------------");
        console.log("value.id->     ",value.id,"<-      ");
        console.log("-----------------------------------");
        
        var RETURN_ACTIVOS              =   get_lista_activos(value.id);
        var STATUS_MUESTRAS             =   RETURN_ACTIVOS;
        if(!STATUS_MUESTRAS.ALL_OK_SAMPLES){ traffic_all =  false;} 
        LISTA_ANATOMIA.RESUL.push(STATUS_MUESTRAS);
    });
    console.log("traffic_all->",traffic_all);
    if(!traffic_all){
        jError("Para la custodia masiva, se requiere que el 100% de las muestras se encuentren marcadas.","Clinica Libre");
        return false;
    }
    _envios('',0,LISTA_ANATOMIA);
}
//******************************************************************************
//************************ fase 2 a trasporte **********************************
//TRASPORTE INDIVIAL
function confirma_trasporte(id_anatomia){
    var STATUS_MUESTRAS = get_lista_activos(id_anatomia);
    if(STATUS_MUESTRAS.NUM_CHECKED  == 0){ jError("No se ha marcado muestras para trasporte","Clinica Libre");  return false;  }
    var LISTA_ANATOMIA = {  RESUL : [] };
    LISTA_ANATOMIA.RESUL.push(STATUS_MUESTRAS);
    if(!STATUS_MUESTRAS.ALL_OK_SAMPLES){
        jConfirm('No todas las muestras fueron marcadas. la solicitud quedara en <b>estado incompleta</b> para trasporte. &iquest;Desea Agregar?','Clinica Libre',function(r){
            if(r){ 
                _envios(id_anatomia,1,LISTA_ANATOMIA);
            } else {
                console.log("DIJO NO");
            }
        });
        return false;
    } else {
        _envios(id_anatomia,1,LISTA_ANATOMIA);
    }
}

//**************//
//TRASPORTE ALL

function confirma_trasporte_all(fase){
    var LISTA_ANATOMIA                  =   {   RESUL : [] };
    var traffic_all                     =   true;
    var txt_busuqeda                    =   fase == 1 ? '.all_solicitudes_trasporte':'.all_solicitudes_trasporte';
    $(txt_busuqeda).each(function(index,value){
        console.log("-----------------------------------");
        console.log("value.id->     ",value.id,"<-      ");
        console.log("-----------------------------------");
        var RETURN_ACTIVOS              =   get_lista_activos(value.id);
        var STATUS_MUESTRAS             =   RETURN_ACTIVOS;
        if(!STATUS_MUESTRAS.ALL_OK_SAMPLES){ traffic_all =  false;} 
        LISTA_ANATOMIA.RESUL.push(STATUS_MUESTRAS);
    });
    //console.log("traffic_all->",traffic_all);
    if(!traffic_all){
        jError("Para la trasporte masiva, se requiere que el 100% de las muestras se encuentren marcadas.","Clinica Libre");
        return false;
    }
    //return false;
    _envios('',1,LISTA_ANATOMIA);
}

//FASE 3 - RECEPCION 
//RECEPCION INDIVIAL 
function confirma_recepcion(id_anatomia){
    var errores                         =   [];
    var firma_simple_trasporte          =   $("#firma_simple_trasporte").val();
    var firma_simple_recepcion          =   $("#firma_simple_recepcion").val();
    var v_num_interno                   =   $("#num_interno").val();
    var num_interno_cito                =   $("#num_interno_cito").val(); 
    //console.log("-----------------------------------------------------------------");
    //console.log("1.-firma_simple_trasporte  ->    ",firma_simple_trasporte,"<-    ");
    //console.log("2.-firma_simple_recepcion  ->    ",firma_simple_recepcion,"<-    ");
    //console.log("-----------------------------------------------------------------");
    console.log("V_IND_TIPO_BIOPSIA     ->  ",$("#V_IND_TIPO_BIOPSIA").val());
    console.log("num_interno_cito       ->  ",num_interno_cito);
    firma_simple_trasporte  === ''?errores.push({"txt":"Falta firma simple de quien trasporto muestras","id":"#firma_simple_trasporte"}):$("#firma_simple_trasporte").css("border-color","");
    firma_simple_recepcion  === ''?errores.push({"txt":"Falta firma simple de quien recepciona las muestras","id":"#firma_simple_recepcion"}):$("#firma_simple_recepcion").css("border-color","");
    errores.length>0 ? '' : firma_simple_trasporte === firma_simple_recepcion ? errores.push({"txt":"Firmas Iguales","id":"#firma_simple_trasporte,#firma_simple_recepcion"}) : $("#firma_simple_trasporte,#firma_simple_recepcion").css("border-color","");
    v_num_interno           === ''?errores.push({"txt":"Indicar N&deg; interno de anatom&iacute;a patol&oacute;gica","id":"#num_interno"}):$("#num_interno").css("border-color","");
    //num_interno_cito === '' && $("#V_IND_TIPO_BIOPSIA").val() === 4  ? errores.push({"txt":"Indicar N&deg; citologico vacio","id":"#num_interno_cito"}):$("#num_interno_cito").css("border-color","");
    if (num_interno_cito === '' && $("#V_IND_TIPO_BIOPSIA").val() == 4 ){
        errores.push({"txt":"Indicar N&deg; citologico vacio","id":"#num_interno_cito"});
    } else {
        $("#num_interno_cito").css("border-color","");
    }
    console.log("Errores  -> ",errores);
    if(errores.length>0){
        errores.forEach(function(value,index){
            showNotification('top','right',value.txt,4,'fa fa-times');
            $(value.id).css("border-color","red");
        });
        return false;
    } 
    var STATUS_MUESTRAS                 =   get_lista_activos(id_anatomia);
    if(STATUS_MUESTRAS.NUM_CHECKED      ==  0){ 
        jError("No se ha marcado muestras para recepci&oacute;n","Clinica Libre");  
        return false;  
    }
    var LISTA_ANATOMIA                  =   {  RESUL : [] };
    LISTA_ANATOMIA.RESUL.push(STATUS_MUESTRAS);
    if(!STATUS_MUESTRAS.ALL_OK_SAMPLES){
        jConfirm('No todas las muestras fueron marcadas. la solicitud quedara en <b>estado incompleta</b> para la recepci&oacute;n. &iquest;Desea Agregar?','Clinica Libre - ANATOM&Iacute;A PATOL&Oacute;GICA',function(r){
            if(r){ 
                _envios(id_anatomia,3,LISTA_ANATOMIA);
            } else {
                console.log("DIJO NO");
            }
        });
        return false;
    } else {
        _envios(id_anatomia,3,LISTA_ANATOMIA);
    }
}

//RECEPCION ALL
function confirma_recepcion_all(fase){
    var LISTA_ANATOMIA                  =   {   RESUL : [] };
    var traffic_all                     =   true;
    $('.all_solicitudes_recepcion').each(function(index,value){
        var RETURN_ACTIVOS              =   get_lista_activos(value.id);
        var STATUS_MUESTRAS             =   RETURN_ACTIVOS;
        if(!STATUS_MUESTRAS.ALL_OK_SAMPLES){ traffic_all =  false;} 
        LISTA_ANATOMIA.RESUL.push(STATUS_MUESTRAS);
    });
    if (!traffic_all){
        jError("Para la recepci&oacute;n masiva, se requiere que el 100% de las muestras se encuentren marcadas.","Clinica Libre");
        return false;
    }
    //return false;
    _envios('',2,LISTA_ANATOMIA);
}

//******************************************************************************
function _envios(id_anatomia,post,LISTA_ANATOMIA){
    //console.table([{"id_anatomia":id_anatomia,"_post":post}]);
    //console.table(LISTA_ANATOMIA.RESUL);
    //console.table(LISTA_ANATOMIA.RESUL.ARRAY_NMUESTRAS);
    var txt_accion = post==0?'CUSTODIA':post==1?'TRASPORTE':'RECEPCI&Oacute;N';
    console.log("txt_accion->",txt_accion);
    if (post === 3 ){
        jConfirm('Con esta acci&oacute;n se proceder&aacute; a editar las solicitud de anatom&iacute;a patol&oacute;gica <b>RECEPCI&Oacute;N</b>&nbsp;&nbsp;&nbsp;<br />&iquest;Est&aacute; seguro de continuar?','Clinica Libre',function(r){
            if(r){
                var pass =  new Array({
                                "pass1" : $("#firma_simple_trasporte").val(),
                                "pass2" : $("#firma_simple_recepcion").val()
                            });

                $('#loadFade').modal('show'); 
                $.ajax({ 
                        type : "POST",
                        url : "ssan_libro_biopsias_listaexterno1/confirma_recepcion",
                        dataType : "json",
                        beforeSend : function(xhr)   {   
                                                                   
                                                                },
                        data                :                   {
                                                                    id_anatomia         :   id_anatomia,
                                                                    array_muestras      :   LISTA_ANATOMIA, 
                                                                    pass                :   pass,
                                                                    n_interno           :   $("#num_interno").val(),
                                                                    n_interno_2         :   $("#num_interno_cito").val(),
                                                                    ind_tipo_biopsia    :   $("#ind_tipo_biopsia").val(),
                                                                },
                        error		:   function(errro)     { 
                                                                    console.log(errro);  
                                                                    console.log(errro.responseText);    
                                                                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                                    jAlert("Error en aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                                },
                        success             :   function(aData) { 
                            
                                                                    console.log("   -----------------------------------------------------       ");
                                                                    console.log("   return aData        ->  ",aData,"    <-                     ");
                                                                    console.log("   FIRMAS aData        ->  ",aData.STATUS,"<-                  ");
                                                                    console.log("   GET_BD STATUS       ->  ",aData["GET_BD"].STATUS,"<-        ");
                                                                    console.log("   GET_BD STATUS_BD    ->  ",aData["GET_BD"].STATUS_BD,"<-     ");
                                                                    console.log("   TXT_ERROR           ->  ",aData["GET_BD"].TXT_ERROR,"<-     ");
                                                                    console.log("   close_modal         ->  ",aData["GET_BD"].close_modal,"<-   ");
                                                                    console.log("   --------------------------------------------------------    ");

                                                                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                                    if(aData.STATUS){
                                                                        var var_status_bd               =   aData["GET_BD"].STATUS;
                                                                        if(var_status_bd === false){
                                                                            showNotification('top','right',aData["GET_BD"].TXT_ERROR,4,'fa fa-times');
                                                                            if (aData["GET_BD"].close_modal == 1){
                                                                                $('#MODAL_INFORMACION_ETIQUETA').modal("hide");
                                                                                UPDATE_PANEL();
                                                                            }
                                                                        } else {
                                                                            //console.log(" exito ");
                                                                            aData.GET_BD.HISTO_OK.forEach(function(idhisto){
                                                                                $(".li_histo_"+idhisto).remove();
                                                                                $(".tab_histo_"+idhisto).remove();
                                                                            });
                                                                            if($('#UL_TABS_MUESTRA li').size()===0){
                                                                                $('#MODAL_INFORMACION_ETIQUETA').modal("hide"); 
                                                                            } else {
                                                                                $('#UL_TABS_MUESTRA').tab();
                                                                                $('#UL_TABS_MUESTRA li:last-child a').tab('show');
                                                                            }
                                                                            
                                                                            UPDATE_PANEL();
                                                                            /*
                                                                                localStorage.setItem("ind_tipo_mensaje",1);
                                                                                localStorage.setItem("ind_estapa_analitica",0);
                                                                                localStorage.setItem("num_fichae",null);
                                                                                localStorage.setItem("id_anatomia",id_anatomia);
                                                                                $("#load_anuncios_anatomia_patologica").submit();
                                                                            */
                                                                            jConfirm("La solicitud N&deg; "+aData.GET_BD.HISTO_OK.join(",")+", ha sido recepcionada con &eacute;xito &iquest;Desea ver pdf de recepcion?",'Clinica Libre',function(r) {
                                                                                if(r){ 
                                                                                    pdf_recepcion_ok(id_anatomia);
                                                                                } else {
                                                                                    console.log("-------------------------------");
                                                                                    console.log("       -> DIJO NO <-           ");
                                                                                    console.log("-------------------------------");
                                                                                }
                                                                            });
                                                                        } 
                                                                    } else {
                                                                        jError(aData['TXT_ERROR'],"Clinica Libre");
                                                                    }
                                                                }, 
                    });
            } else {
                console.log(" -> RECEPCION NO <- ");
            }
        });
        
    } else {
        jPrompt('Con esta acci&oacute;n se proceder&aacute; a editar las solicitud de anatom&iacute;a patol&oacute;gica.<b>'+txt_accion+'</b><br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
            if((r == '') || (r == null)){
                jError("Firma simple Vacia","Clinica Libre");
            } else {
                var pass = new Array({"pass1":r});
                $('#loadFade').modal('show'); 
                $.ajax({ 
                        type :   "POST",
                        url :   post==0 ? "ssan_libro_biopsias_usuarioext/fn_confirma_custodia":
                                post==1 ? "ssan_libro_biopsias_usuarioext/confirma_trasporte":"",
                                            //"ssan_spab_gestionlistaquirurgica/confirma_recepcion",
                        dataType :   "json",
                        beforeSend :   function(xhr) { console.log("xhr->",xhr); },
                        data : {
                                    id_anatomia     :   id_anatomia,
                                    array_muestras  :   LISTA_ANATOMIA, 
                                    password        :   r,
                                    pass            :   pass,
                                },
                        error : function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText); 
                                                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                    jAlert("Error en aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                },
                        success : function(aData){ 
                                                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                    if(aData.STATUS){
                                                        aData.GET_BD.HISTO_OK.forEach(function(idhisto){
                                                            $(".li_histo_"+idhisto).remove();
                                                            $(".tab_histo_"+idhisto).remove();
                                                        });
                                                        if( $('#UL_TABS_MUESTRA li').size()===0){
                                                            $('#MODAL_INFORMACION_ETIQUETA').modal("hide"); 
                                                        } else {
                                                            $('#UL_TABS_MUESTRA').tab();
                                                            $('#UL_TABS_MUESTRA li:last-child a').tab('show');
                                                        }
                                                        jAlert("La solicitud N&deg; "+aData.GET_BD.HISTO_OK.join(",")+", ha cambiado de estado","Clinica Libre");
                                                        //distintas cookie
                                                        if( $("#IND_FROM").val() == 'GESPAB' ){
                                                            UPDATE_MAIN();
                                                        } else {
                                                            update_main();
                                                        }
                                                        if(post==1){
                                                            console.log(" load_confirma_envio_recepcion ");
                                                            $("#load_confirma_envio_recepcion").submit();
                                                        }
                                                    } else {
                                                        jError(aData['TXT_ERROR'],"Clinica Libre");
                                                    }
                                                }, 
                    });
            }
        });
    }
}

function js_vista_opcion(ind_id){
    $("#firma_simple_trasporte,#firma_simple_recepcion,#firma_simple_rechaza,#txt_observacion_rechazo").val('');
    $("#firma_simple_trasporte,#firma_simple_recepcion,#firma_simple_rechaza,#txt_observacion_rechazo").css("border-color","");
    
    if(ind_id === 'ind_rechazo'){
        $(".css_grid_password_recepcion").hide();
        $(".css_panel_rechazo").show();
    }   else    {
        $(".css_grid_password_recepcion").show();
        $(".css_panel_rechazo").hide();
    }
}

function js_confirma_rechazo_recepcion(id_anatomia){
    var error   =   [];
        $("#firma_simple_rechaza").css("border-color",""); 
    if($("#firma_simple_rechaza").val()===''){
        $("#firma_simple_rechaza").css("border-color","red"); 
        error.push(" - Firma simple vacia");
    }
        $("#txt_observacion_rechazo").css("border-color",""); 
    if($("#txt_observacion_rechazo").val()===''){
        $("#txt_observacion_rechazo").css("border-color","red"); 
        error.push(" - Indicar observaci&oacute;n de rechazo de muestras");
    }
    if(error.length === 0){
        var STATUS_MUESTRAS                     =   get_lista_activos(id_anatomia);
        var html_li                             =   '';
        if(STATUS_MUESTRAS.NUM_ANTEC_ADVERSOS   ==  0){
            showNotification('top','right','Debe indicar evento adverso y su observaci&oacute;n en alguna de las muestras',4,'fa fa-times');
            return false;
        }
        //LOAD HTML
        html_li+='<ul class="list-group" style="margin-bottom:-11px;">'; 
        $.each(STATUS_MUESTRAS.ARRAY_NMUESTRAS,function(i,item){
            if(item.ARR_EVENTOS_ADVERSOS.length>0){
                $.each(item.ARR_EVENTOS_ADVERSOS,function(x,row_adverso){
                    //var aux = i+1;
                    html_li+='<li class="list-group-item">';
                        html_li+='- '+row_adverso.TXT_MOTIVO+' - '+row_adverso.TXT_OBSERVACION;
                    html_li+='</li>'; 
                });
            }
        });
        html_li+='</ul>';
        jPrompt('Con esta acci&oacute;n se proceder&aacute; rechazar solicitud de anatom&iacute;a patol&oacute;gica <br/>'+html_li+'<br/>&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
            if(r){
                var LISTA_ANATOMIA  = {RESUL:[]};
                LISTA_ANATOMIA.RESUL.push(STATUS_MUESTRAS);
                $.ajax({ 
                     type           :   "POST",
                     url            :   "ssan_spab_gestionlistaquirurgica/get_confirma_rechazo_muestras",
                     dataType       :   "json",
                     data           :   {
                                            contrasena          :   r,
                                            array_muestras      :   LISTA_ANATOMIA, 
                                            TXT_GLOBAL          :   $("#txt_observacion_rechazo").val(),
                                        },
                     error          :   function(errro)         {  
                                                                    console.log(errro.responseText); 
                                                                    jError("Error en el aplicativo","Clinica Libre");
                                                                },
                     success        :   function(aData)         { 
                         
                                                                    console.table("aData    ->  ",aData);
                                                                    if(aData.status){
                                                                        jAlert("Se ha rechazado muestra anatom&iacute;a patol&oacute;gica","Clinica Libre");
                                                                        $('#MODAL_INFORMACION_ETIQUETA').modal("hide"); 
                                                                        if(pdf_rechazomuestra(id_anatomia)){
                                                                            UPDATE_PANEL();
                                                                        }
                                                                    } else {
                                                                        jError("Error Firma simple","Clinica Libre");
                                                                    }
                                                                }, 
                });
            } else {
                jError("Firma simple vac&Iacute;a","Clinica Libre"); 
            }
        });
    } else {
        showNotification('top','right',error.join("<br>"),4,'fa fa-times');
    }
}

function pdf_rechazomuestra(id_anatomia){
    //cerrar todos los modal anterior
    console.log("rechazada id_anatomia->",id_anatomia);
    //return false;
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_spab_gestionlistaquirurgica/pdf_informerechazo_ap",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        console.log("generando PDF");
                                                        $('#PDF_VERDOC').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF");
                                                    },
        data 		:                           { 
                                                        id : id_anatomia,
                                                    },
        error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        $('#PDF_VERDOC').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                                    },
        success		:   function(aData)         { 
                                                        console.log("-----------------------");
                                                        console.log("aData  ->",aData,"<-   ");
                                                        
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
                                                            $("#Dv_verdocumentos").modal("show");
                                                            $('#PDF_VERDOC').html(Objpdf);
                                                        }
                                                   }, 
   });
   return true;
}



function GET_PDF_ANATOMIA_PANEL(id){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_usuarioext/BLOB_PDF_ANATOMIA_PATOLOGICA",
        dataType : "json",
        beforeSend : function(xhr) {   
            $('#HTML_PDF_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF");
        },
        data : { id : id },
        error : function(errro) { 
            console.log(errro,); 
            console.log(errro.responseText); 
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
        },
        success : function(aData){ 
            console.error(aData);
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
                $('#PDF_VERDOC').html(Objpdf);
            }
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
            $("#Dv_verdocumentos").modal("show");
        }, 
   });
}

function valida_cambio_estado_muestras(){
    
}

function viws_historial(id_anatomia){
    $.ajax({ 
        type : "POST",
        url : "ssan_spab_gestionlistaquirurgica/vista_historial",
        dataType : "json",
        beforeSend	: function(xhr) {   
                                        console.log(xhr);
                                        console.log("generando PDF");
                                        $('#HTML_INFORMACION_HISTORIAL').html('');
                                    },
        data :  {  id_anatomia : id_anatomia  },
        error : function(errro) { 
                                    console.log("quisas->",errro,"-error->",errro.responseText); 
                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                    $('#HTML_INFORMACION_HISTORIAL').html('');
                                },
        success : function(aData) { 
                                    /*
                                    console.log("-----------------------------------------------");
                                    console.log(aData);
                                    console.log("ORDENADO       ->",aData.ORDENADO,"            ");
                                    console.log("NO_ORDENADO    ->",aData.NO_ORDENADO,"         ");
                                    console.log("-----------------------------------------------");
                                    */
                                    $("#HTML_INFORMACION_HISTORIAL").html(aData.HTML_OUT);
                                    $("#MODAL_INFORMACION_HISTORIAL").modal({backdrop:'static',keyboard:false}).modal("show");
                                }, 
   });
}

function fecha_cale(name){
    //console.log("name->",name);
    var date_array = $("#"+name).find(".active").data("day").split('/');
    return date_array[1]+'-'+date_array[0]+'-'+date_array[2];
}

function busqueda_etiquera2(){
    //console.log("setItem          ----------->",  window.localStorage.setItem('search'));
    //console.log("getItem          ----------->",  window.localStorage.getItem('search'));
    //console.log("key              ----------->",  window.localStorage.key('search'));
    //console.log("removeItem       ----------->",  window.localStorage.removeItem('search'));
    //console.log("clear            ----------->",  window.localStorage.clear('search'));
    var data_return                 =               window.localStorage.getItem('search'); 
    $("#JSON_RETURN").html(data_return===null?[]:data_return);
}

function marca_no_resagadas_recepcion(id_anatomia){
    console.log("id_anatomia->",id_anatomia);
    $(".data_lista").each(function(index,value){
        console.log("index.id       ->",value.id);
        console.log("index          ->",index);
        console.log("value          ->",value);
        console.log("data           ->",$("#"+value.id).data());
        console.log("data.lista     ->",$("#"+value.id).data().lista);
        //console.log("value.data()   ->",value);
    });
} 

function marca_no_enviadasentrasporte(id_anatomia){
    $(".lista_anatomia").each(function(index,value){
        //console.log("marca_no_enviadasentrasporte           ->",$("#"+value.id).data());
        if($("#"+value.id).data().data_muestra.IND_ESTADO_CU == 0){
            $("#"+value.id).addClass("disabled");
            document.getElementById("CHEK_"+value.id).disabled = true;
        }
    });
}

function marcadas_recepcionadas_resagadas(id_anatomia){
    $(".lista_anatomia").each(function(index,value){
        console.log("marcadas_recepcionadas_resagadas      ->",$("#"+value.id).data());
        if($("#"+value.id).data().data_muestra.IND_ESTADO_CU == 0){
            $("#"+value.id).addClass("disabled");
            document.getElementById("CHEK_"+value.id).disabled = true;
        }
        if($("#"+value.id).data().data_muestra.IND_ESTADO_CU == 1){
            $("#"+value.id).addClass("list-group-item-success");
            document.getElementById("CHEK_"+value.id).checked = true;
            document.getElementById("CHEK_"+value.id).disabled = true;
        }
    });
}

function js_htmlnummuestra(id,value){
    $("#num_ic_0").html(value);
    var aux_lista           =   0;
    var html                =   '';
    var arr_muestras        =   typeof $("#tabla_biopsia").data().arr_muestra=="undefined"?[]:$("#tabla_biopsia").data().arr_muestra;
    //*********************************************
    //console.log("arr_muestras->",arr_muestras);
    //$("#tabla_biopsia").removeData();
    //*********************************************
    if(arr_muestras.length>0){
        var value_const     =   arr_muestras.length;
        var value_get       =   value;
        var aux             =   1;
        var resta           =   (value_get-value_const);
        if(resta<=-1){
            for(y=1;y<=value_get;y++){
                html        +=  html_tr_nummuestras({
                                    NUM_MUESTRA         :   y,
                                    IND_ETIQUETA        :   arr_muestras[y-1].IND_ETIQUETA,
                                    TXT_OBSERVACION     :   arr_muestras[y-1].TXT_MUESTRA,
                                    NUM_CASSETTE        :   arr_muestras[y-1].NUM_CASSETTE,
                                    DATA                :   arr_muestras[y-1], 
                                });
            }
        } else {
            $.each(arr_muestras,function(i,value){
                html        +=  html_tr_nummuestras({
                                    NUM_MUESTRA         :   aux,
                                    IND_ETIQUETA        :   value['IND_ETIQUETA'],
                                    TXT_OBSERVACION     :   value['TXT_MUESTRA'],
                                    NUM_CASSETTE        :   value['NUM_CASSETTE'],
                                    DATA                :   value, 
                                });
                aux++;                        
            });
            for(i=aux;i<=value;i++){
                html        +=  html_tr_nummuestras({NUM_MUESTRA:i,IND_ETIQUETA:2}); 
            };
        }
    } else {
        for(i=1;i<=value;i++){
            html            +=  html_tr_nummuestras({NUM_MUESTRA:i,IND_ETIQUETA:2}); 
        };
    }
    $("#TBODY_NUM_MUESTRAS").html(html);
    //**************************************************************************
    if($("#AP_USO_CASSETE").val()=='undefined'){
        $(".row_cassete").hide();
    } else {
        js_usocassete("AP_USO_CASSETE");
    }
    
    //js_load_easyAutocomplete(value);
    js_load_autocomple_data(value);
}

function js_load_autocomple_data(value){
    var data_autocomplete           =   $("#data_autocomplete").data().autocomplete;
    var TXT_ETIQUETAS               =   new Array();
    for(var z=1;z<=value;z++)       {   TXT_ETIQUETAS.push("#n_muestra_"+z);    }
    
    /*
        console.log("-------------------------------------------------------------------");
        console.log("data_autocomplete              -> ",data_autocomplete,"        <-  ");
        console.log("data_autocomplete.length       -> ",data_autocomplete.length," <-  ");
        console.log("TXT_ETIQUETASh                 -> ",TXT_ETIQUETAS,"            <-  ");
        console.log("TXT_ETIQUETAS.join()           -> ",TXT_ETIQUETAS.join(","),"  <-  ");
        console.log("-------------------------------------------------------------------");
    */
    
    /*    
    $(TXT_ETIQUETAS.join(",")).easyAutocomplete({
        data            :   data_autocomplete,
        categories      :   [{
                                listLocation                :   "NOMBRE_ANATOMIA",
                                maxNumberOfElements         :   6,
                                header                      :   "&nbsp;EXAMEN HISTOPATOL&Oacute;GICO",
                            }],
        getValue        :   function(element)               {   return element.character; },
        list            :   {
                                maxNumberOfElements         :   data_autocomplete.length,
                                match                       :   {   enabled :   true    },
                                sort                        :   {   enabled :   true    },
                                onClickEvent                :   function(this_1){
                                    
                                                                }
                            },
    });
    $(".easy-autocomplete").width('100%');
    */
}

function js_load_easyAutocomplete(value){
    var TXT_ETIQUETAS               =    new Array();
    for(var z=1;z<=value;z++){   TXT_ETIQUETAS.push("#n_muestra_"+z);  }
    console.log("TXT_ETIQUETAS      ->  ",TXT_ETIQUETAS);
    $.ajax({ 
        type            :   "POST",
        url             :   "ssan_libro_biopsias_listagespab/get_data_easyautocomplete",
        dataType        :   "json",
        beforeSend      :   function(xhr)           {   
                                                        //console.log(xhr);
                                                        //console.log("BUSCANDO EL EASYAUTOCOMPLETE");
                                                    },
        data 		:                           { },
        error		:   function(errro)         { 
                                                        console.log("errro          =>",errro);
                                                        console.log("responseText   =>",errro.responseText);
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    },
        success		:   function(aData)         { 
                                                        console.log("---------------------------------------------------------------");
                                                        console.log("get_data_easyautocomplete  ->---<-                             ");
                                                        console.log("aData                      ->",aData,"<-                       ");
                                                        console.log("aData.BD_RETURN            ->",aData.BD_RETURN,"<-             ");
                                                        console.log("aData.COUNT_AUTOCOMPLETE   ->",aData.COUNT_AUTOCOMPLETE,"<-    ");
                                                        console.log("---------------------------------------------------------------");
                                                        $(TXT_ETIQUETAS.join(",")).easyAutocomplete({
                                                            data            :   aData.BD_RETURN,
                                                            categories      :   [{
                                                                                    listLocation                :   "NOMBRE_ANATOMIA",
                                                                                    maxNumberOfElements         :   6,
                                                                                    header                      :   "&nbsp;EXAMEN HISTOPATOL&Oacute;GICO",
                                                                                }],
                                                            getValue        :   function(element)               {   return element.character; },
                                                            list            :   {
                                                                                    maxNumberOfElements         :   aData.COUNT_AUTOCOMPLETE,
                                                                                    match                       :   {   enabled :   true    },
                                                                                    sort                        :   {   enabled :   true    },
                                                                                    onClickEvent                :   function(this_1){
                                                                                                                        /*
                                                                                                                        console.log("-----------------------------------");                            
                                                                                                                        console.log("-- THIS VALUE -->",this,"<---------");
                                                                                                                        console.log("-----------------------------------"); 
                                                                                                                        console.log("---------------->",this_1,"--------"); 
                                                                                                                        console.log("-----------------------------------"); 
                                                                                                                        */
                                                                                                                    }
                                                                                },
                                                        });
                                                        $(".easy-autocomplete").width('100%');
                                                    }, 
    });
}


function html_tr_nummuestras(MAINDATA){
    var html_nmuestras                  =   '';
    var x                               =   MAINDATA.NUM_MUESTRA;
    //var etiqueta                      =   MAINDATA.IND_ETIQUETA;
    var etiqueta                        =   typeof $("#ind_equiqueta_1").val() === 'undefined'?MAINDATA.IND_ETIQUETA:$("#ind_equiqueta_1").val();
    //**************************************************************************
    var NEW_TXT_OBSERVACION             =   typeof MAINDATA.TXT_OBSERVACION                     === "undefined"?'':MAINDATA.TXT_OBSERVACION;
    var DATA                            =   typeof MAINDATA.DATA                                === "undefined"?[]:MAINDATA.DATA;
    var ID_NMUESTRA                     =   typeof DATA.ID_NMUESTRA                             === "undefined"?null:DATA.ID_NMUESTRA;
    //var view_cassete                  =   typeof DATA.USO_CASSETE                             === "undefined"?"display:none":'';
    var num_cassete                     =   typeof DATA.NUM_CASSETTE                            === "undefined"?1:DATA.NUM_CASSETTE;
    var view_cassete                    =   $("#tabla_biopsia").data().MAIN_ANATOMIA_USOCASSET  === 0?'display:none':'';
    /*
    console.log("---------------------------------------------------------------------------");
    console.log("----------------------view_cassete ----------------------------------------");
    console.log("view_cassete -------- ",view_cassete," ----------------------------------- ");
    console.log("---------------------------------------------------------------------------");
    console.log("---------------------------------------------------------------------------");
    */
    /*
    console.log("---------------------------------------------------------------------------");
    console.log("---------------------------------------------------------------------------");
    console.log("---------- >   html_tr_nummuestras <---------------------------------------");
    console.log("---------- >   DATA                :   ",MAINDATA,"            <-----------");
    console.log("---------- >   DATA                :   ",MAINDATA.DATA,"       <-----------");
    console.log("---------- >   DATA.NUM_CASSETTE   :   ",DATA.NUM_CASSETTE,"   <-----------");
    console.log("---------- >   num_cassete         :   ",num_cassete,"         <-----------");
    console.log("---------------------------------------------------------------------------");
    console.log("---------------------------------------------------------------------------");
    console.log("---------------------------------------------------------------------------");
    */
    /*
    console.log("---------- >   DATAID_NMUESTRA     :   ",typeof DATA.ID_NMUESTRA,"<--------");
    console.log("---------- >   x                   :   ",x,"<------------------------------");
    console.log("---------- >   etiqueta            :   ",etiqueta,"<-----------------------");
    console.log("---------- >   txt_obs             :   ",NEW_TXT_OBSERVACION,"<------------");
    console.log("---------- >   html_tr_nummuestras <---------------------------------------");
    console.log("---------------------------------------------------------------------------");
    */
        html_nmuestras		=       '<tr id="id_tr_'+x+'"> ' +
                                            '<td width="5%" style="text-align:center;"><b>'+x+'</b></td>'+
                                            '<td width="50%" >'+
                                                '<input type="text" name="n_muestra_'+x+'" id="n_muestra_'+x+'" size="60" class="form-control input-sm" maxlength="60" value="'+NEW_TXT_OBSERVACION+'">'+
                                            '</td>'+
                                            '<td width="30%" style="text-align:center;">'+
                                                '<select id="ind_equiqueta_'+x+'" name="ind_equiqueta_'+x+'" class="form-control input-sm" onchange="js_cambio_tamano_all2(this.value)">'+
                                                    '<option value="2">MEDIO</option>'+
                                                    //'<option value="3">GRANDE</option>'+
                                                    '<option value="1">PEQUE&Ntilde;O</option>'+
                                                '</select>'+
                                                '<script>'+
                                                    '$("#ind_equiqueta_'+x+'").val('+etiqueta+');'+
                                                '</script>'+
                                            '</td>'+
                                            '<td width="5%" style="text-align: center;'+view_cassete+'" class="row_cassete">'+
                                                '<input type="number" class="form-control input-sm" min="1" pattern="^[0-9]+" id="num_cassete_'+x+'" name="num_cassete_'+x+'" maxlength="3" style="width:65px;height:auto" value="'+num_cassete+'">'+
                                            '</td>';
        html_nmuestras                  +=  '<td width="5%" style="text-align: center;">';                            
        html_nmuestras		+=              '<button type="button" class="btn btn-xs btn-danger btn-fill" id="btn_muestra_'+x+'" onClick="js_eliminamuestra(1,'+x+')">'+
                                                    '<i class="fa fa-eraser" aria-hidden="true"></i>'+
                                                '</button>';
        html_nmuestras		+=          '</td>'; 
        
        if (ID_NMUESTRA === ''){
            html_nmuestras		+=  '<script>$("#btn_muestra_'+x+'").data({ID_HTML:1,NUM_MUESTRA:'+x+',ID_NMUESTRA:""});</script>'; 
        } else {
            html_nmuestras		+=  '<script>$("#btn_muestra_'+x+'").data({ID_HTML:1,NUM_MUESTRA:'+x+',ID_NMUESTRA:'+ID_NMUESTRA+'});</script>';
        }
        html_nmuestras		+=          '</tr>';
    return html_nmuestras;
}

function ap_js_htmlcitologia(id,value){
    var html                =   '';
    $("#num_ic_1").html(value);
    var arr_citologia       =   typeof $("#tabla_biopsia").data().arr_citologia==="undefined"?[]:$("#tabla_biopsia").data().arr_citologia;
    /*
    console.log("---------------------------------------------------------------");
    console.log("   arr_citologia   2   ->",arr_citologia,"<-                    ");
    console.log("---------------------------------------------------------------");
    */
    if (arr_citologia.length>0){
        var aux             =   1;
        var value_const     =   arr_citologia.length;
        var value_get       =   value;
        var resta           =   (value_get-value_const);
        if(resta<=-1){
            for(y=1;y<=value_get;y++){
                html        +=  ap_html_tr_ncitologia({
                                    N_MUESTRA       :   y,
                                    IND_ETIQUETA    :   arr_citologia[y-1].IND_ETIQUETA,
                                    TXT_OBSERVACION :   arr_citologia[y-1].TXT_MUESTRA,
                                    NUM_ML          :   arr_citologia[y-1].NUM_ML,
                                    DATA            :   arr_citologia[y-1], 
                                });
            }
        } else {
            $.each(arr_citologia,function(i,value){
                html        +=  ap_html_tr_ncitologia({
                                    N_MUESTRA       :   aux,
                                    IND_ETIQUETA    :   value['IND_ETIQUETA'],
                                    TXT_OBSERVACION :   value['TXT_MUESTRA'],
                                    NUM_ML          :   value['NUM_ML'],
                                    DATA            :   value, 
                                });
                aux++;                        
            });
            for(i=aux;i<=value;i++){
                html        +=  ap_html_tr_ncitologia({N_MUESTRA:i,IND_ETIQUETA:2}); 
            };
        }
    } else {
        for(i=1;i<=value;i++){
            html            +=  ap_html_tr_ncitologia({N_MUESTRA:i,IND_ETIQUETA:2}); 
        };
    }
    $("#TBODY_MUESTRAS_CITOLOGIA").html(html);
}

function ap_html_tr_ncitologia(MAINDATA){
    var html_ncitologia                 =   '';
    var x                               =   '';
    var txt_obs                         =   '';
    var num_ml                          =   '';
    var etiqueta_pre                    =   '';
    var ID_NMUESTRA                     =   null;
    var x                               =   MAINDATA.N_MUESTRA;
    //var etiqueta                      =   MAINDATA.IND_ETIQUETA;
    var etiqueta                        =   typeof $("#ind_cito_equiqueta_1").val() === 'undefined'?MAINDATA.IND_ETIQUETA:$("#ind_cito_equiqueta_1").val();
    //console.log("-------------------------------------------------------------");
    //console.log("etiqueta                 ->  ",etiqueta,"                    ");
    //console.log("-------------------------------------------------------------");
    //console.log("-------------------------------------------------------------");
    //console.log("OBJET1                   ->  ",MAINDATA);
    //console.log("OBJET2                   ->  ",MAINDATA.DATA);
    //console.log("OBJET3                   ->  ",MAINDATA["DATA"]);
    //var DATA                              =>  typeof MAINDATA.DATA  ===  "undefined"?console.log("undefined"):console.log("data",MAINDATA.DATA) ;
    //console.log("DATA3                    ->  ",DATA);
    //console.log("-------------------------------------------------------------");
    if(MAINDATA["DATA"] === undefined){
        
    } else {
        if(MAINDATA["DATA"].DATA === undefined){
            ID_NMUESTRA                     =   MAINDATA["DATA"].ID_NMUESTRA;
            txt_obs                         =   MAINDATA["DATA"].TXT_MUESTRA;
            num_ml                          =   MAINDATA["DATA"].NUM_ML ;
        } else {
            
            ID_NMUESTRA                     =   MAINDATA["DATA"].DATA.ID_NMUESTRA;
            txt_obs                         =   MAINDATA["DATA"].DATA.TXT_MUESTRA;
            num_ml                          =   MAINDATA["DATA"].DATA.NUM_ML ;
        }
    }
    
    return  '<tr id="id_tr_citologia_'+x+'"> ' +
                '<td width="5%" style="text-align:center;"><b>'+x+'</b></td>'+
                '<td width="40%" style="text-align:center;">'+
                    '<input type="text" name="n_citologia_'+x+'" id="n_citologia_'+x+'" size="60" class="form-control input-sm" maxlength="60" value="'+txt_obs+'">'+
                '</td>'+
                '<td width="15%" style="text-align: center;">'+
                    '<input type="number" min="1" pattern="^[0-9]+" class="form-control input-sm" id="ml_citologia_'+x+'" name="ml_citologia_'+x+'" value="'+num_ml+'" maxlength="10" style="height:auto">'+
                '</td>'+
                '<td width="30%" style="text-align: center;">'+
                    '<select id="ind_cito_equiqueta_'+x+'" name="ind_cito_equiqueta_'+x+'" class="form-control input-sm" onchange="js_cambio_tamano_all(this.value)">'+
                        '<option value="2">MEDIO</option>'+
                        //'<option value="3">GRANDE</option>'+
                        '<option value="1">PEQUE&Ntilde;O</option>'+
                    '</select>'+
                    '<script>'+
                        '$("#ind_cito_equiqueta_'+x+'").val('+etiqueta+');'+
                    '</script>'+
                '</td>'+
                '<td width="10%" style="text-align:center;">'+
                    '<button type="button" class="btn btn-xs btn-danger btn-fill"" id="btn_citologia_'+x+'" onClick="js_eliminamuestra_cito('+x+')">'+
                        '<i class="fa fa-trash-o" aria-hidden="true"></i>'+
                    '</button>'+
                '</td>'+
                '<script>'+
                    '$("#btn_citologia_'+x+'").data({ID_HTML:2,NUM_MUESTRA:'+x+',ID_NMUESTRA:'+ID_NMUESTRA+'});'+
                '</script>'+
            '</tr>';
}

function js_cambio_tamano_all(value)    {   
    $('[id^=ind_cito_equiqueta_]').each(function(){ 
        $("#"+this.id).val(value); 
    }); 
}

function js_cambio_tamano_all2(value)   {   
    $('[id^=ind_equiqueta_]').each(function(){ 
        $("#"+this.id).val(value); 
    }); 
    js_deshabilitar_casete(value); 
}

function js_deshabilitar_casete(value)  {
    var id                  =   "AP_USO_CASSETE";
    /*
    console.log("-----------------------------------");
    console.log("       js_deshabilitar_casete      ");
    console.log("id         =   ",id,"              ");
    console.log("value      =   ",value,"           ");
    console.log("-----------------------------------");
    */
    if(value == 1){
        //console.log("TAMANO FRASCO      ->",value);
        document.getElementById("AP_USO_CASSETE").disabled      =   false;
    } else {
        //console.log("TAMANO MEDIANO     ->",value);
        //$("#AP_USO_CASSETE").prop("disabled",false);
        document.getElementById("AP_USO_CASSETE").checked       =   false;
        document.getElementById("AP_USO_CASSETE").disabled      =   true;
    }
    js_usocassete(id);
}

function js_usocassete(id){
    if(document.getElementById(id).checked){
        $(".row_cassete").show();
    } else {
        $(".row_cassete").hide();
    }
}

//document.getElementById("check").setAttribute('disabled', 'disabled');
//document.getElementById("check").removeAttribute('disabled');
/*
function old_busqueda_etiquera(from,solicitud,array){
    var get_etiqueta            =   '';
    if (from                    ==  0){
        get_etiqueta            =   $("#get_etiqueta").val();
        //console.log("get_etiqueta->",get_etiqueta);
        if(get_etiqueta         ==  '') {  document.getElementById("get_etiqueta").focus(); return false; }
    } else if (from             ==  1){
        get_etiqueta            =   solicitud;
    } else if (from             ==  3){
        //ID SOLICITUD MAIN
        get_etiqueta            =   'S'+solicitud;
    }
    //************************************************************
    console.log("-----------------------------------------------"); 
    console.log("false          =>  ",from,"                    ");
    console.log("solicitud      =>  ",solicitud,"               ");
    console.log("get_etiqueta   =>  ",get_etiqueta,"            ");
    console.log("array          =>  ",array,"                   ");
    console.log("NUM_FASE       =>  ",$("#NUM_FASE").val(),"    ");
    console.log("-----------------------------------------------"); 
    //************************************************************
    //return false;
    $.ajax({ 
        type                    :   "POST",
        //url                   :   "ssan_spab_gestionlistaquirurgica/informacion_x_muestra",
        url                     :   "ssan_spab_gestionlistaquirurgica/informacion_x_muestra",
        dataType                :   "json",
        beforeSend              :   function(xhr)   {   
                                                    console.log("xhr->",xhr);   
                                                },
        data                    :                   {
                                                    get_etiqueta    :   get_etiqueta,
                                                    from            :   from,
                                                    opcion          :   1,
                                                    vista           :   1,
                                                    NUM_FASE        :   $("#NUM_FASE").val(),
                                                    MODAL           :   $('#UL_TABS_MUESTRA li').size()?true:false,
                                                    array_data      :   array,
                                                },
        error                   :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                },
        success                 :   function(aData) { 
                                                    console.log("------------informacion_x_muestra----------------------");
                                                    console.log("               ",aData,"                               ");
                                                    //console.log("             ",aData["DATA"],"                       ");
                                                    console.log("-------------------------------------------------------");
                                                    if(aData.STATUS){
                                                        //var num_atanomia                  =   aData['DATA']['P_STATUS'][0].V_AP_MAIN_PATROLOGICO;
                                                        
                                                        if ($('#UL_TABS_MUESTRA li').size()==0){
                                                            //console.log("-> ABRE MODAL <-   HTML_INFORMACION_ETIQUETA");
                                                            $("#get_etiqueta,#get_etiqueta_modal").val('');
                                                            $("#HTML_INFORMACION_ETIQUETA").html(aData.HTML_OUT);
                                                            $("#MODAL_INFORMACION_ETIQUETA").modal({backdrop:'static',keyboard:false}).modal("show");
                                                        } else {
                                                            //console.log("-> AGREGA TABS <- UL_TABS_MUESTRA");
                                                            $('#UL_TABS_MUESTRA').append('<li role="presentation" id="LI_TABS_'+aData.NUM_ANAT+'" ><a href="#TABS_'+aData.NUM_ANAT+'"  data-toggle="tab" role="tab" aria-controls="TABS_'+aData.NUM_ANAT+'" aria-selected="false">N&deg;&nbsp;'+aData.NUM_ANAT+'</a></li>');
                                                            $('#TABS_TAB_PANEL').append('<div role="tabpanel" class="tab-pane" id="TABS_'+aData.NUM_ANAT+'" aria-labelledby="TABS_'+aData.NUM_ANAT+'_1">'+aData.HTML_VIWE+'</div>');
                                                            $('#UL_TABS_MUESTRA').tab();
                                                            $('#UL_TABS_MUESTRA li:last-child a').tab('show');
                                                        }
                                                        js_viwes_btn_masivo();
                                                    } else {
                                                        jError(aData['DATA']['P_ERROR'][0].TXT_ERROR,"Clinica Libre");
                                                    }
                                                    //$("#RETURN").html('').html(JSON.stringify(aData));
                                                }, 
    });
    return true;
}
*/

//custoria o recepcoin masivo
function recepcion_custodia_masiva(){
    var aux = 0;
    var arr_solicitudes = new Array();
    var NUM_FASE = $("#NUM_FASE").val();
    $('.marcado_custoria_trasporte').each(function(i,obj){ 
        if(document.getElementById(obj.id).checked){ 
            aux++; 
            arr_solicitudes.push(obj.value);
            document.getElementById(obj.id).checked = false;
        } 
    });
    if (arr_solicitudes.length != 1){
        jError("Debe marcar solo una solicitud de anatom&iacute;a patol&oacute;gica","Clinica Libre");
        return false;
    } else if(aux   === 0){
        jError("Debe marcar solicitud de anatom&iacute;a patol&oacute;gica","Clinica Libre");
        return false;
    } else if(aux==1 || NUM_FASE == 1){
        /*
        console.log("-----------------------------------------------------------");
        console.log("aux                    ->  ",aux,"<-                       ");
        console.log("arr_solicitudes        ->  ",arr_solicitudes,"<-           ");
        */
        var num_fist = arr_solicitudes[0];
        var return_val = busqueda_etiquera(3,num_fist,{array_anatomia:arr_solicitudes.length===0?{}:arr_solicitudes});
        //console.log("return_val -> ",return_val);
        if (return_val){ 
            //UPDATE_PANEL();  
        }
    } else {    
        jError("S&oacute;lo se puede recepcionar una muestra a la vez","Clinica Libre");
        return false;
    }
}

function pre_busqueda(from,solicitud){
    busqueda_etiquera(from,solicitud,{array_anatomia:[solicitud]});
}

//busqueda principal = individual
function busqueda_etiquera(from,solicitud,array){
    /*
    console.log("-------------------busqueda_etiquera----------------------");
    console.log("from               ->  ",from);
    console.log("solicitud          ->  ",solicitud);
    console.log("array              ->  ",array);
    */
    var get_etiqueta = '';
    var txt_busq_muestra = false;
    if(from === 0){
        get_etiqueta = $("#get_etiqueta").val();
        txt_busq_muestra =   true;
        if(get_etiqueta === ''){ document.getElementById("get_etiqueta").focus(); return false; }
    } else if(from === 1){
        get_etiqueta =   solicitud;
    } else if(from === 3){
        get_etiqueta = 'S'+solicitud;
    }
    /*
        console.log("   ----------------------------------------------------    ");
        console.log("   ----------------    busqueda_etiquera   ------------    "); 
        console.log("   from               =>  ",from,"                         ");
        console.log("   solicitud          =>  ",solicitud,"                    ");
        console.log("   get_etiqueta       =>  ",get_etiqueta,"                 ");
        console.log("   array              =>  ",array,"                        ");
        console.log("   NUM_FASE           =>  ",$("#NUM_FASE").val(),"         ");
        console.log("   txt_busq_muestra   =>  ",txt_busq_muestra,"             ");
        console.log("   ----------------------------------------------------    ");
    */
    //return false;
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_listaexterno1/informacion_x_muestra_grupal",
        dataType : "json",
        beforeSend : function(xhr){  $('#loadFade').modal('show');},
        data : {
            get_etiqueta : get_etiqueta,
            from : from,
            opcion : 1,
            vista : 1,
            NUM_FASE : $("#NUM_FASE").val(),
            MODAL : $('#UL_TABS_MUESTRA li').size()?true:false,
            array_data : array,
        },
        error : function(errro) { 
            console.log(errro);  
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
            jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
        },
        success : function(aData) { 

            console.log("aData  ->",aData);

            setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
            if(aData.STATUS){
                if ($('#UL_TABS_MUESTRA li').size()==0){
                    $('#get_etiqueta,#get_etiqueta_modal').val('');
                    $('#HTML_INFORMACION_ETIQUETA').html(aData.HTML_OUT);
                    $('#MODAL_INFORMACION_ETIQUETA').modal({backdrop:'static',keyboard:false}).modal("show");
                } else {
                    $('#UL_TABS_MUESTRA').append('<li role="presentation" id="LI_TABS_'+aData.NUM_ANAT+'" ><a href="#TABS_'+aData.NUM_ANAT+'"  data-toggle="tab" role="tab" aria-controls="TABS_'+aData.NUM_ANAT+'" aria-selected="false">N&deg;&nbsp;'+aData.NUM_ANAT+'</a></li>');
                    $('#TABS_TAB_PANEL').append('<div role="tabpanel" class="tab-pane" id="TABS_'+aData.NUM_ANAT+'" aria-labelledby="TABS_'+aData.NUM_ANAT+'_1">'+aData.HTML_VIWE+'</div>');
                    $('#UL_TABS_MUESTRA').tab();
                    $('#UL_TABS_MUESTRA li:last-child a').tab('show');
                }
            } else {
                jError(aData['DATA']['P_ERROR'][0].TXT_ERROR,"Clinica Libre");
            }
        }, 
    });
    return true;
}

function informar_x_correo(id_anatomia){
    //console.log("id_anatomia >",id_anatomia);
    $.ajax({ 
        type : "POST",
        url : "ssan_spab_gestionlistaquirurgica/informa_x_correo",
        dataType : "json",
        beforeSend	: function(xhr) {   
            console.log(xhr);
            console.log("Enviando Correo");
            $('#loadFade').modal('show');
        },
        data : {  id : id_anatomia, },
        error : function(errro) { 
            console.log("quisas->",errro,"-error->",errro.responseText); 
            $("#protocoloPabellon").css("z-index","1500"); 
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
        },
        success : function(aData) { 
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
            console.log("aData ->",aData);
            showNotification('top','center','Se ha enviado correo '+aData.IND_MAIL,1,'fa fa-info');
        }, 
   });
}

function js_gestion_tomademuestraxuser(){
    $.ajax({ 
      type :   "POST",
      url :   "ssan_spab_gestionlistaquirurgica/fn_gestion_tomamuestraxuser",
      dataType :   "json",
      beforeSend : function(xhr) {   
        //console.log(xhr);
        //console.log("Enviando Correo");
        $('#loadFade').modal('show');
        },
        data : { },
        error : function(errro) { 
            console.log("quisas->",errro,"-error->",errro.responseText); 
            $("#protocoloPabellon").css("z-index","1500"); 
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
        },
        success : function(aData) { 
            //console.log("aData ->",aData);
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
            $("#html_gestion_tomamuestraxuser").html(aData.html_out);
            $("#modal_gestion_tomamuestraxuser").modal({backdrop:'static',keyboard:false}).modal("show");
        }, 
   });
}

function validar(e){
    var tecla = (document.all) ? e.keyCode : e.which;
    if(tecla==13) {
	    $("#rut").css("border-color","");  
        if($("#rut").val() == ''){
            jError("RUN del paciente esta vacio.","Clinica Libre Error");
            $("#rut").css("border-color","red");  
            return false;
        } else {
            var _rut = $("#rut").val();
            var rut_array = _rut.split("-");
            var rut2 = rut_array[0].replace(".","");
            var rut = rut2.replace(".","");
            var dv = rut_array[1];
            if(!valida_rut_dos_variables(rut,dv)){
                jError(" El rut del paciente no es v&aacute;lido.","Clinica Libre Error");
                $("#rut").css("border-color","red");  
                return false;
            } else {
                buscar_Paciente(1);
            }
        }
    } 
}

function js_new_userx(){
    $("#modal_gestion_tomamuestraxuser").modal('hide');
    $("#modal_new_userxtomamuestra").modal({backdrop:'static',keyboard:false}).modal("show");
    $('#rut_profesional').Rut({
        on_error    :   function(){   jAlert('El Run ingresado es Incorrecto. '+$("#rut_profesional").val(), 'Rut Incorrecto'); console.log($("#rut_profesional").val());  $("#rut_profesional").css('border-color','red'); $("#rut_profesional").val('') },
        on_success  :   function(){   $("#rut_profesional").css('border-color','');   },
        format_on   : 'keyup'
    });
    //console.log("   ------------------  ");
    //console.log("   ->  24.01.2023  <-  ");
    $("#btn_valida_profesional").prop('disabled',false);
}

function valida_profesional(){
    var _rut = "";
    var rut_array = "";
    var rut2 = "";
    var rut = "";
    var dv = "";
    _rut = $("#rut_profesional").val();
    if(_rut == ''){
        jError("RUN vac&iacute;o","Cl&iacute;nica Libre");
        return false;
    }
    rut_array = _rut.split("-");
    rut2 = rut_array[0].replace(".","");
    rut = rut2.replace(".","");
    dv = rut_array[1];
    $.ajax({ 
        type : "POST",
        url : "ssan_spab_gestionlistaquirurgica/fn_valida_profesional",
        dataType : "json",
        beforeSend : function(xhr) {   
            console.log(xhr);
            $('#loadFade').modal('show');
        },
        data : { run : rut, dv : dv, },
        error : function(errro) { 
            console.log("quisas->",errro,"-error->",errro.responseText); 
            $("#protocoloPabellon").css("z-index","1500"); 
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
        },
        success : function(aData)         {   
            console.log("aData  =   ",aData);
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
            if(aData.info_prof.length  == 0){
                showNotification('top','center','RUN ingresado no existe como prestador en su establecimiento',4,'fa fa-times')
                js_limpia_panel();
            } else {
                $("#numidentificador").html(aData.info_prof[0]['COD_RUTPRO']+'-'+aData.info_prof[0]['COD_DIGVER']);
                $("#nombreLabel").html(aData.info_prof[0]['NOM_PROFE']);
                $("#profesionLabel").html(aData.info_prof[0]['DES_TIPOATENCION']);
                $(".info_profesional_x_toma").data().data = aData.info_prof;
                $("#btn_guarda_infoxususario").attr('onclick','js_guarda_usuarioxrotulo()');
                $("#rut_profesional").prop('disabled',true);
                $("#ind_servicios").html('').append(aData.option);
                var arr     =   [];
                if(aData.data_rotulo.length>0){
                    aData.data_rotulo.forEach(function(value){  arr.push(value.ID_ROTULADO);  });
                    //console.log("value -> ",arr);
                    $("#ind_servicios").selectpicker('val',arr);
                    js_cambio_punto_entrega();
                }
                $("#ind_servicios").selectpicker('refresh');
            }
        }, 
    });
}

function js_guarda_usuarioxrotulo(){
    var ind_servicios = $("#ind_servicios").val();
    var info_prof = $(".info_profesional_x_toma").data('data')[0];
    if(ind_servicios === null){
        showNotification('top','center','No punto de toma de muestra cargadas',4,'fa fa-times');
        return false;
    }
    //console.log("---------------------------------------------------");
    //console.log("   ind_servicios  ->  ",ind_servicios,"        <-  ");
    //console.log("   info_prof      ->  ",info_prof,"            <-  ");
    jPrompt('Con esta acci&oacute;n se proceder&aacute; a editar punto de toma de muestras por usuario.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
        if((r == '') || (r == null)){
            jError("Firma simple vac&iacute;a","Clinica Libre");
        } else { 
            $.ajax({ 
                type : "POST",
                url : "ssan_spab_gestionlistaquirurgica/record_rotulos_por_usuario",
                dataType : "json",
                beforeSend	: function(xhr) {   
                    console.log(xhr);
                    $('#loadFade').modal('show');
                },
                data : {  
                    contrasena : r,
                    ind_servicios : ind_servicios,
                    info_prof : info_prof,
                },
                error : function(errro) { 
                    console.log("quisas->",errro,"-error->",errro.responseText); 
                    $("#protocoloPabellon").css("z-index","1500"); 
                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                },
                success : function(aData) {   
                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                    console.log("aData -> ",aData);
                    if(aData.status_firma){
                        showNotification('top','center','Se actualizo permisos',1,'fa fa-info');
                        js_limpia_panel();
                    }   else  {
                        jError('Contrase&ntilde;a inv&aacute;lida',"Clinica Libre"); 
                    }
                }, 
            });
        }
    });
}

function js_limpia_panel(){
    $("#rut_profesional").val('');
    $("#numidentificador,#nombreLabel,#profesionLabel").html('');
    $(".punto_toma_muestra").remove();
    $(".sin_puntos_cargados").show();
    $(".info_profesional_x_toma").data().data   =   [];
    $("#btn_guarda_infoxususario").attr('onclick','');
    $("#rut_profesional").prop('disabled',false);
    $("#ind_servicios").html('');
    $("#ind_servicios").selectpicker('refresh');                                      
}

function js_validafirma(txt_firma_simple){
    var txt_valida_firma = $("#"+txt_firma_simple).val();
    
    //console.log("----------------------------------------");
    //console.log("txt_valida_firma   ->  ",txt_valida_firma);
    //console.log("txt_firma_simple   ->  ",txt_firma_simple);

    if(txt_valida_firma == ''){
        showNotification('top','center','Firma simple vacia',4,'fa fa-info');
        return false;
    }
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_listaexterno1/ver_valida_firma_simple",
        dataType : "json",
        beforeSend	: function(xhr) {   
            console.log(xhr);
            $('#loadFade').modal('show');
        },
        data : { contrasena :   txt_valida_firma,   },
        error : function(errro) { 
            console.log("quisas->",errro,"-error->",errro.responseText); 
            $("#protocoloPabellon").css("z-index","1500"); 
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
        },
        success : function(aData) {   
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
            //console.log("aData -> ",aData);
            if (aData.status){
                let data_user = aData.valida[0];
                showNotification('top','center','<i class="fa fa-info"></i>&nbsp;Firma simple ->'+data_user.NAME+' - '+data_user.USERNAME,1,'');
            } else {
                jError("Firma &uacute;nica. no tiene usuario asignado","Clinica Libre");
            }
        }, 
    });
}

function js_gestion_html(){
    $.ajax({ 
        type            :   "POST",
        url             :   "ssan_spab_gestionlistaquirurgica/get_prestadores",
        dataType        :   "json",
        //url           :   "ssan_spab_gestionlistaquirurgica/get_prestadores2",
        //dataType      :   "html",
        beforeSend      :   function(xhr)           {   
                                                        console.log(xhr);
                                                        console.log("load -> ssan_spab_gestionlistaquirurgica/get_prestadores");
                                                    },
        data            :                           {   },
        error           :   function(errro)         { 
                                                        console.log("errro | ",errro," | ","error.responseText -> ",errro.responseText); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    },
        success         :   function(aData)         { 
                                                        console.log("   -------------------     ");
                                                        console.log("   aData ->   ",aData,"    ");
                                                        //console.log("   -------------------     ");
                                                        $('#html_info_html').html('').html(aData.html);
                                                        $("#respuesta").html('');
                                                        //$('#html_info_html').html('').html(aData);
                                                        $('#modal_info_html').modal({backdrop:'static',keyboard:false}).modal("show");
                                                    }, 
    }); 
}

function CARGATIPO() {
    var id              =   "respuesta";        
    var funcion         =   "cargatipo";        
    var variables       =   {};                 
    AjaxExt(variables,id,funcion);              
}


function js_permiso_zebra(){
    var v_ruta                  =   "https://localhost:9101/default?type=printer";
    console.log("js_permiso_zebra   ",v_ruta);
    //window.location.href      =   'https://localhost:9101/ssl_support';
    //window.location.href      =   'https://localhost:9101/default?type=printer';
    //var win = window.open(v_ruta, '_blank');
    // Cambiar el foco al nuevo tab (punto opcional)
    //win.focus();
    window.open(v_ruta,'_blank');
}



function js_min_clavesesissan(){
    $("#html_clave_esissan_ap").html("");
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_spab_gestionlistaquirurgica/fn_gestion_clave_esissan",
        dataType    :   "json",
        beforeSend	:   function(xhr)           {   
                                                    console.log(xhr);
                                                    console.log("Enviando Correo");
                                                    $('#loadFade').modal('show');
                                                },
        data 		:                           {  },
        error		:   function(errro)         { 
                                                    console.log("quisas->",errro,"-error->",errro.responseText); 
                                                    $("#protocoloPabellon").css("z-index","1500"); 
                                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                },
        success		:   function(aData)         { 
                                                    console.log("aData ->",aData);
                                                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                    $("#html_clave_esissan_ap").html(aData.html_out);
                                                    $("#modal_clave_esissan_ap").modal({backdrop:'static',keyboard:false}).modal("show");
                                                }, 
     });
}

function js_vetrifica_pass(){
    if (document.getElementById("ind_actualiza_pass").checked){
        $("#txtPass,#txtPassRep").prop('disabled',false);
    } else {
        $("#txtPass,#txtPassRep").prop('disabled',true);
    }
}

function valida_run_esissan()   {
    var _rut            =   "";
    var rut_array       =   "";
    var rut2            =   "";
    var rut             =   "";
    var dv              =   "";
    _rut                =   $("#run_esissan").val();
    $("#run_esissan").css('border-color','');
    if(_rut == ''){
        jError("RUN vac&iacute;o","Clinica Libre");
        $("#run_esissan").css('border-color','red');
        return false;
    }

    rut_array		    =   _rut.split("-");
    rut2		        =   rut_array[0].replace(".","");
    rut			        =   rut2.replace(".","");
    dv			        =   rut_array[1];
    
    $.ajax({ 
        type		    :   "POST",
        url 		    :   "ssan_spab_gestionlistaquirurgica/fn_valida_cuenta_esissan",
        dataType        :   "json",
        beforeSend	    :   function(xhr)           {   
                                                        console.log(xhr);
                                                        $('#loadFade').modal('show');
                                                    },
        data 		    :                           {  
                                                        run :   rut,
                                                        dv  :   dv,
                                                    },
        error		    :   function(errro)         { 

                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                        
                                                    },
        success		    :   function(aData)         {   
                                                        const resul_request         =   aData.return_bd.return_bd;
                                                        console.log("aData          =   ",aData);
                                                        if(resul_request[":C_GETUSERS"].length>0){
                                                          $("#ind_id_uid").val(resul_request[":C_GETUSERS"][0]["ID_UID"]);
                                                            $("#txtNombres").val(resul_request[":C_GETUSERS"][0]["FIRST_NAME"]);
                                                            $("#txtApePate").val(resul_request[":C_GETUSERS"][0]["MIDDLE_NAME"]);
                                                            $("#txtApeMate").val(resul_request[":C_GETUSERS"][0]["LAST_NAME"]);
                                                            $("#txtEmail").val(resul_request[":C_GETUSERS"][0]["EMAIL"]);
                                                            $("#CheckboxUsu").prop("checked",resul_request[":C_GETUSERS"][0]["DISABLE"] == 0 ? true :false);
                                                            $("#checkTipo").prop("checked",resul_request[":C_GETUSERS"][0]["STATUS"] == 1 ? true : false);
                                                            $("#ind_actualiza_pass").prop('disabled',false).attr('onclick','js_vetrifica_pass()');
                                                            $("#txtPass,#txtPassRep").prop('disabled',true);
                                                            $("#CheckboxUsu").prop("checked",true).prop('disabled',true);
                                                        } else {
                                                            showNotification('top','center','RUN ingresado no tiene cuenta Clinica Libre',4,'fa fa-times');
                                                            $("#ind_id_uid").val(0);
                                                            $("#txt_acceso_contraena").html("<b>Nueva contrase&ntilde;a<b>");
                                                            $("#CheckboxUsu").prop("checked",true);

                                                            $("#ind_actualiza_pass").prop("checked",true);
                                                            $(".check_contrasena").hide();
                                                            $("#txtPass,#txtPassRep").prop('disabled',false);
                                                        }
                                                        
                                                        $("#btn_edicion_ususario").attr('onclick','grabarUsu()');
                                                        $(".class_superusuario").hide();

                                                        let arr_privilegios_user            =   [];
                                                        if(resul_request[":C_PRIVILEGIOS_USER"].length>0){
                                                            $(".privilegios_ususario_sin_items").remove();
                                                            resul_request[":C_PRIVILEGIOS_USER"].forEach(function(row,index){
                                                                arr_privilegios_user.push(row.PER_ID);
                                                                $(".privilegios_ususario").append(html_li_previlegios(row));
                                                            });
                                                            //$("#destinoPriv").selectpicker('val',arr_privilegios_user);
                                                        }

                                                        let arr_permisos_no_editables       =   [];
                                                        if(resul_request[":C_PRIVILEGIOS"].length>0){
                                                            let arr_option_selecionables    =   [];
                                                            let arr_option_disabled         =   [];
                                                            resul_request[":C_PRIVILEGIOS"].forEach(function(row,index){
                                                                let disabled;
                                                                let txt_checked;
                                                                row.OPTION_EDITION  ==  '0' &&  arr_privilegios_user.includes(row.PER_ID)?arr_permisos_no_editables.push(row.PER_ID):'';
                                                                disabled            =   row.OPTION_EDITION == '0' ? 'disabled':'';
                                                                txt_checked         =   arr_privilegios_user.includes(row.PER_ID)?' selected ':'';
                                                                let txt_option      =   "<option value='"+row.PER_ID+"' "+disabled+" "+txt_checked+"  class='permiso_"+row.PER_ID+"' data-privilegios='"+JSON.stringify(row)+"' >"+row.PER_NOMBRE+"</option>";
                                                                row.OPTION_EDITION  ==  '0' ? arr_option_disabled.push(txt_option) : arr_option_selecionables.push(txt_option);
                                                            });
                                                            arr_option_selecionables.length>0?$("#destinoPriv").append('<optgroup label="PERMISOS EDITABLES">'+arr_option_selecionables.toString()+"</optgroup"):'';
                                                            arr_option_disabled.length>0?$("#destinoPriv").append('<optgroup label="PERMISOS NO EDITABLES">'+arr_option_disabled.toString()+"</optgroup"):'';
                                                            $("#data_privilegios").data().permisos_no_editable = arr_permisos_no_editables;
                                                        }
                                                        $("#destinoPriv").selectpicker('render');

                                                        let arr_establecimientos            =   [];
                                                        if(resul_request[":C_ESTABLECIMIENTOS_USER"].length>0){
                                                            $(".privilegios_empresa_sin_items").remove();
                                                            resul_request[":C_ESTABLECIMIENTOS_USER"].forEach(function(row, index){
                                                                arr_establecimientos.push(row.COD_ESTABL);
                                                                $(".privilegios_empresa").append(html_li_empresa(row));
                                                            });
                                                            //$('#destinoEstab').selectpicker('val', arr_establecimientos);
                                                        }

                                                        //establecimientos
                                                        let arr_establecimientos_no_editable =  [];
                                                        if(resul_request[":C_ESTABLECIMIENTOS"].length>0){
                                                            let arr_empesas_selecionables    =   [];
                                                            let arr_empresas_disabled        =   [];
                                                            resul_request[":C_ESTABLECIMIENTOS"].forEach(function(row, index) {
                                                                let disabled_empresa;
                                                                let txt_checked;
                                                                disabled_empresa    =   row.OPTION_EDITION == '0' ? 'disabled':'';
                                                                txt_checked         =   arr_establecimientos.includes(row.COD_ESTABL)?' selected ':'';
                                                                row.OPTION_EDITION  ==  '0' &&  arr_establecimientos.includes(row.COD_ESTABL) ? arr_establecimientos_no_editable.push(row.COD_ESTABL) :'';
                                                                let txt_option      =   "<option "+disabled_empresa+" "+txt_checked+" value='"+row.COD_ESTABL+"' class='empresa_"+row.COD_ESTABL+"' data-establecimiento='"+JSON.stringify(row)+"'>"+row.NOM_ESTABL+"</option>"
                                                                row.OPTION_EDITION  ==  '0' ? arr_empresas_disabled.push(txt_option) : arr_empesas_selecionables.push(txt_option);
                                                                //$("#destinoEstab").append("<option "+disabled_empresa+" "+txt_checked+" value='"+row.COD_ESTABL+"' data-establecimiento='"+JSON.stringify(row)+"'>"+row.NOM_ESTABL+"</option>");
                                                            });
                                                            arr_empesas_selecionables.length>0?$("#destinoEstab").append('<optgroup label="ESTABLECIMIENTOS EDITABLES">'+arr_empesas_selecionables.toString()+"</optgroup"):'';
                                                            arr_empresas_disabled.length>0?$("#destinoEstab").append('<optgroup label="ESTABLECIMIENTOS NO EDITABLES">'+arr_empresas_disabled.toString()+"</optgroup"):'';
                                                            //add
                                                            /*
                                                            const arr_029       =   {
                                                                                        COD_ESTABL      :   "029",
                                                                                        NOM_ESTABL      :   "DSSAN",
                                                                                        OPTION_EDITION  :   "1"
                                                                                    };
                                                            $("#destinoEstab").append('<option value="029" data-establecimiento="'+JSON.stringify(arr_029)+'">DSSAN</option>');
                                                            */
                                                            $("#data_establecimientos").data().permisos_no_editable = arr_establecimientos_no_editable;
                                                        }

                                                        $(".class_checkbox").prop('disabled',false);
                                                        $(".selectpicker").selectpicker("refresh");
                                                        $("#run_esissan,#btn_valida_profesional").prop('disabled',true);
                                                        $(".class_input_cuenta").prop('disabled',false);
                                                        $("#btn_edicion_ususario").attr('onclick','grabarUsu()');
                                                        $("#btn_volver_atras,#btn_cancelar_user").attr('onclick','js_function_vuelve()');

                                                        $("#loadFade").modal('hide');
                                                        
                                                        var _height = $(window).height()*0.8;
                                                        $('.class_clave_esissan_ap .modal-body').css('max-height',_height);
                                                        $('.class_clave_esissan_ap .modal-body').css('min-height',_height);
                                                        $(".main-panel").perfectScrollbar("destroy");
                                                        document.getElementById("html_clave_esissan_ap").style.overflowY = 'auto';
                                                    }, 
    });
}


function return_permisos(){
    let arr_id_permisos = [];
    if($("#destinoPriv").val() != null || $("#destinoPriv").val().length>0){
        $("#destinoPriv").val().forEach(function(row,index){
            arr_id_permisos.push(row);
        });
    }
    if($("#data_privilegios").data('permisos_no_editable') != undefined || $("#data_privilegios").data('permisos_no_editable').length>0){
        $("#data_privilegios").data('permisos_no_editable').forEach(function(row,index){
            arr_id_permisos.push(row);
        });
    }
    return arr_id_permisos;
}

function js_reload_previlegios(_this){
    let arr_destinoPriv = return_permisos();
    $(".privilegios_ususario").html("");
    if(arr_destinoPriv.length>0){
        arr_destinoPriv.forEach(function(row,indice,array){
            const arr_info        =   $(".permiso_"+row).data("privilegios");
            $(".privilegios_ususario").append(html_li_previlegios(arr_info));
        });
    } else {
        $(".privilegios_ususario").append('<li class="list-group-item li_priveligos privilegios_ususario_sin_items"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;SIN PRIVILEGIOS</li>');
    }
}

function html_li_previlegios(_row){
    var txt_return;
    txt_return  = '<li class="list-group-item li_priveligos privilegios_item_'+_row.PER_ID+'" id="'+_row.PER_ID+'">'+
                    '<div class="grid_li_item">'+
                        '<div class="grid_li_item1">'+_row.PER_ID+'</div>'+
                        '<div class="grid_li_item2">'
                            +_row.PER_NOMBRE+
                        '</div>'+
                        '<div class="grid_li_item3">';
                        if (_row.OPTION_EDITION == '1'){
                            txt_return  +=  '<i class="fa fa-unlock" style="color:#87CB16;" aria-hidden="true"></i>';
                        } else {
                            txt_return  +=  '<i class="fa fa-lock" aria-hidden="true"></i>';
                        }

    txt_return  +=  '</div>'+
                '</div>'+
            '</li>';
        return txt_return;
}

function return_establecimientos(){
    let arr_id_establecimientos = [];
    if($("#destinoEstab").val() != null || $("#destinoEstab").val().length>0){
        $("#destinoEstab").val().forEach(function(row, index){
            arr_id_establecimientos.push(row);
        });
    }
    if($("#data_establecimientos").data('permisos_no_editable') != undefined || $("#data_establecimientos").data('permisos_no_editable').length>0){
        $("#data_establecimientos").data('permisos_no_editable').forEach(function(row, index){
            arr_id_establecimientos.push(row);
        });
    }
    return arr_id_establecimientos;
}

function js_reload_establecimientos(_this){
    let arr_destinoEstab        =   return_establecimientos();
    console.log("js_reload_establecimientos ->  ",arr_destinoEstab);
    $(".privilegios_empresa").html("");
    if(arr_destinoEstab.length>0){
        arr_destinoEstab.forEach(function(row,indice,array) {
            const arr_info        =   $(".empresa_"+row).data("establecimiento");
            $(".privilegios_empresa").append(html_li_empresa(arr_info));
        });
    } else {
        $(".privilegios_empresa").html('<li class="list-group-item li_priveligos privilegios_empresa_sin_items"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;SIN ESTABLECIMIENTO ASIGNADO</li>');
    }
}

function html_li_empresa(_row){
    var txt_return;
    txt_return  =   '<li class="list-group-item li_empresa privilegios_item_'+_row.COD_ESTABL+'" id="'+_row.COD_ESTABL+'">'+
                        '<div class="grid_li_item">'+
                            '<div class="grid_li_item1">'+_row.COD_ESTABL+'</div>'+
                            '<div class="grid_li_item2">'
                                +_row.NOM_ESTABL+
                            '</div>'+
                            '<div class="grid_li_item3">';
                                if (_row.OPTION_EDITION == '1'){
                                    txt_return  +=  '<i class="fa fa-unlock" style="color:#87CB16;" aria-hidden="true"></i>';
                                } else {
                                    txt_return  +=  '<i class="fa fa-lock" aria-hidden="true"></i>';
                                }
    txt_return          +=  '</div>'+
                        '</div>'+
                    '</li>';
    return txt_return;
}

function js_function_vuelve(){
    //reload
    js_min_clavesesissan();
}

function grabarUsu() {
    var user = $('#run_esissan').val();
    var nombres = $('#txtNombres').val();
    var apepate = $('#txtApePate').val();
    var apemate = $('#txtApeMate').val();
    var email = $('#txtEmail').val();
    var pass = $('#txtPass').val();
    var pass2 = $('#txtPassRep').val();
    var uID = $('#ind_id_uid').val();
    var ok = 0;
    var actualiza_pass  = document.getElementById("ind_actualiza_pass").checked ? true : false;
    var errores = [];

    if (user == '') {
        errores.push("Debe ingresar el RUN del usuario");
    } 
    
    if ($('#error').is(':visible')) {
        errores.push("El RUN Ingresado no es Valido");
    }  
    
    if (nombres == '') {
        errores.push("Debe Ingresar el Nombre del Usuario");
    }  
    
    if (apepate == '') {
       errores.push("Debe Ingresar el Apellido Paterno del Usuario");
    } 
    
    if (apemate == '') {
        errores.push("Debe Ingresar el Apellido Materno");
    }  
    
    if (email == '') {
        errores.push("Debe Ingresar el Email del Usuario");
    }  
   
    if (actualiza_pass){
        if (pass == '' && pass2 == '') {
            errores.push("Contrase&ntilde;a del ususario vac&iacute;a");
        }   else {
            if (pass != pass2){
                errores.push("Contrase&ntilde;a no son iguales");
            }
        }
    }
    
    //console.log("   errores ->  ",errores);
    //return false;
    /*
    if (pass == '' && pass2 == '' && uID == 0) {
        var rest        =   user.split('.');
        var rut         =   rest[0] + rest[1] + rest[2];
        var resto       =   rut.split('-');
        pass            =   resto[0];
    }
    */

    let arrPrivilegios      =   [];
    $('.li_priveligos').each(function(index,row) {
        var objPrivilegios          =   new Object();
        objPrivilegios.vDestino     =   row.id;
        arrPrivilegios.push(objPrivilegios);
    });
    if (arrPrivilegios.length == 0) {
        errores.push("Debe asignar a lo menos un privilegio para el usuario");
        ok = 0;
    }

    let arrEmpresas = [];
    $('.li_empresa').each(function(index,row) {
        var objEmpresas             =   new Object();
        objEmpresas.vDestinoEstab   =   row.id;
        arrEmpresas.push(objEmpresas);
    });

    var activo;
    if ($("#CheckboxUsu").is(':checked')) {
        activo      =   0;
    } else {
        activo      =   1;
    }

    var superUser;
    if ($("#checkTipo").is(':checked')) {
        superUser   =   1;
    } else {
        superUser   =   0;
    }

    if (errores.length > 0) {

        console.log("---------------------------------------------");
        console.error("   errores     ->  ",errores);
        jError(errores.join("<br>"),"Clinica Libre - ERRORES")

    } else {
        const variables = { 
            "user"              :   user, 
            "nombres"           :   nombres, 
            "apepate"           :   apepate, 
            "apemate"           :   apemate, 
            "email"             :   email, 
            "pass"              :   pass, 
            "arrPrivilegios"    :   arrPrivilegios, 
            "arrEmpresas"       :   arrEmpresas, 
            "uID"               :   uID, 
            "activo"            :   activo, 
            "superUser"         :   superUser,
            "actualiza_pass"    :   document.getElementById("ind_actualiza_pass").checked ? 1 : 0, 
        }; //Variables pasadas por ajax a la funcion
        //console.error("   variables   ->  ",variables);
        //console.log("pasa");
        //return false;
        jPrompt('Con esta acci&oacute;n se proceder&aacute; a editar cuenta Clinica Libre <br/>&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
            if(r){

                $.ajax({ 
                    type		:   "POST",
                    url 		:   "ssan_spab_gestionlistaquirurgica/fn_gestion_perfil",
                    dataType    :   "json",
                    beforeSend	:   function(xhr) {   
                        console.log(xhr);
                        console.log("Enviando Correo");
                        $('#loadFade').modal('show');
                    },
                    data 		:                            { 
                                                                "contrasena"        :   r,
                                                                "user"              :   user, 
                                                                "nombres"           :   nombres, 
                                                                "apepate"           :   apepate, 
                                                                "apemate"           :   apemate, 
                                                                "email"             :   email, 
                                                                "pass"              :   pass, 
                                                                "arrPrivilegios"    :   arrPrivilegios, 
                                                                "arrEmpresas"       :   arrEmpresas, 
                                                                "uID"               :   uID, 
                                                                "activo"            :   activo, 
                                                                "superUser"         :   superUser,
                                                                "actualiza_pass"    :   document.getElementById("ind_actualiza_pass").checked ? 1 : 0, 
                                                            },
                    error		:   function(errro)         { 
                                                                console.log("quisas->",errro,"-error->",errro.responseText); 
                                                                $("#protocoloPabellon").css("z-index","1500"); 
                                                                jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                                setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                            },
                    success		:   function(aData)         { 
                                                                console.log("return  ->",aData);
                                                                setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                                if (aData.status_firma){
                                                                    showNotification('top','center','Se ha modificado perfil :<b>'+user+'</b>',1,'fa fa-info');
                                                                } else {
                                                                    jError("Error en la firma simple","Clinica Libre"); 
                                                                }
                                                            }, 
                });
            } else {
                jError("Firma simple vac&iacute;a","Clinica Libre"); 
            }
        });
    }   
}

function js_add_hijo_tomamuestra(ID_ROTULADO){
    let open = $(".data_rotulado_"+ID_ROTULADO).data('open');
    if (!open){
        $(".data_rotulado_"+ID_ROTULADO).data().open = true;
        $.ajax({ 
            type		:   "POST",
            url 		:   "ssan_spab_gestionlistaquirurgica/busqueda_lista_sub",
            dataType    :   "json",
            beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        $('#loadFade').modal('show');
                                                    },
            data 		:                           { 
                                                        ID_ROTULADO : ID_ROTULADO,
                                                    },
            error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                    },
            success		:   function(aData)         { 
                                                        console.log("aData      ->",aData);
                                                        setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                        if(aData.return_bd.length>0){
                                                            aData.return_bd.forEach(function(row,index){
                                                                let num = index+1;
                                                                $("#table_result_"+ID_ROTULADO).append(`
                                                                    <tr>
                                                                        <td style="height:41px;">`+num+`</td>
                                                                        <td>`+row.TXT_OBSERVACION+`</td>
                                                                        <td>`+row.DATE_CREACION+`</td>  
                                                                        <td style="text-align: end;">
                                                                            <button type="button" class="btn btn-danger btn-xs btn-fill" id="btn_delete_sug" onclick="delete_muestra(`+row.ID_ROTULADO_SUB+`)">
                                                                                <i class="fa fa-window-close" aria-hidden="true"></i>
                                                                            </button>
                                                                        </td>        
                                                                    </tr>
                                                                `);
                                                            });
                                                        } else {
                                                            $("#table_result_"+ID_ROTULADO).html(`<tr><td colspan="4" style="text-align:center;padding:15px;"><i class="fa fa-times" aria-hidden="true" style="color:#888888;"></i><em><b style="color:#888888;"><i>SIN SUB-GRUPO</i></b></em></td></tr>`);
                                                        }
                                                        //showNotification('top','center','Se ha enviado correo '+aData.IND_MAIL,1,'fa fa-info');
                                                        $('#collapse_'+ID_ROTULADO).collapse();
                                                    }, 
       });
    }
}

function js_new_subrotulo(ID_ROTULADO){
    let txt_punto_padre = $(".data_rotulado_"+ID_ROTULADO).data("data_plantilla").TXT_OBSERVACION;
    //console.log("txt_punto_padre    ->  ",txt_punto_padre);
    $("#modal_gestion_tomamuestraxuser").modal("hide");
    var nuevaTarjeta        = `
                                <div class="form-group">
                                    <label for="txt_nombresubtuoi">NOMBRE SUB-TIPO</label>
                                    <input type="text" class="form-control" id="txt_nombresubtuoi" aria-describedby="emailHelp" placeholder="Nombre Sub-Tipo de `+txt_punto_padre+`">
                                    <small id="emailHelp" class="form-text text-muted">El nuevo subtipo ser&aacute; agregado a punto de toma de muestra: <b>`+txt_punto_padre+`</b></small>
                                </div>
                                `;
    $("#html_new_subrotulo").html(nuevaTarjeta);
    $("#btn_subrotulo").attr('onclick','js_guardaanatomia('+ID_ROTULADO+')')
    $("#modal_new_subrotulo").modal({backdrop:'static',keyboard:false}).modal("show");
}

function js_guardaanatomia(ID_ROTULADO){
    let  txt_nombresubtuoi          =   $("#txt_nombresubtuoi").val().toUpperCase();
    //console.log("--------------------------------------------");
    //console.log("exampleInputEmail1 :   ",txt_nombresubtuoi);
    //console.log("ID_ROTULADO        :   ",ID_ROTULADO);
    if(txt_nombresubtuoi == ''){
        jError("Nombre no puede ir vac&iacute;o","Clinica Libre");
        return false;
    }
    jPrompt('Con esta acci&oacute;n proceder&aacute;a crear un nuevo sub-punto de toma de muestra','','Confirmaci\u00f3n Clinica Libre',function(r){
      if(r){      
         $('#loadFade').modal('show');
         $.ajax({ 
            type           :  "POST",
            url            :  "ssan_spab_gestionlistaquirurgica/nuevo_punto_toma_muestra",
            dataType       :  "json",
            beforeSend     :  function(xhr)     {     },
            data		      :  { 
                                 clave              :   r,
                                 txt_nombresubtuoi  :   txt_nombresubtuoi,
                                 ID_ROTULADO        :   ID_ROTULADO
                              },
            error		      :  function(errro)  {  
                                                   console.log(errro);
                                                   console.log(errro.responseText);  
                                                   jAlert("Error General, Consulte Al Administrador"); 
                                                   setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                },
            success		   :   function(aData)  {  
                                                    console.error("aData -> ",aData);
                                                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                    if (aData.esissan){
                                                        showNotification('top','left',"Se creo sub-grupo a punto de rotulado",2,'fa fa-check-square');
                                                        $("#modal_new_subrotulo").modal('hide');
                                                        js_gestion_tomademuestraxuser();
                                                    } else {
                                                      jError("Error en la firma simple","Clinica Libre");
                                                    }
                                                }, 
         });
      } else {  
         //console.log("No Confirmado");   
      }  
   });
}

function delete_muestra(id_sub_grupo){
    jPrompt('Con esta acci&oacute;n proceder&aacute; a eliminar un nuevo sub-punto de toma de muestra','','Confirmaci\u00f3n Clinica Libre',function(r){
        if(r){      
           $('#loadFade').modal('show');
           $.ajax({ 
              type :  "POST",
              url :  "ssan_spab_gestionlistaquirurgica/delete_sub_punto",
              dataType :  "json",
              beforeSend :  function(xhr)     {     },
              data :   { 
                            clave : r,
                            id_sub_grupo : id_sub_grupo,
                        },
              error : function(errro)  {  
                                        console.log(errro);
                                        console.log(errro.responseText);  
                                        jAlert("Error General, Consulte Al Administrador"); 
                                        setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                        },
              success : function(aData){  
                                            console.error("aData -> ",aData);
                                            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                            if (aData.esissan){
                                                showNotification('top','left',"Se elimino sub-grupo a punto de rotulado",2,'fa fa-check-square');
                                                $("#modal_gestion_tomamuestraxuser").modal('hide');
                                                setTimeout(function() {
                                                    // CÃ³digo que se ejecutarÃ¡ despuÃ©s de 3 segundos
                                                    console.log("Han pasado 3 segundos!");
                                                    js_gestion_tomademuestraxuser();
                                                }, 2000);
                                            } else {
                                                jError("Error en la firma simple","Clinica Libre");
                                            }
                                        }, 
           });
        } else {  
           //console.log("No Confirmado");   
        }  
     });

}

function js_marcaestadistica(_id){
    console.log(_id);
    let id_toma_muestras = _id.split("_")[1];
    let ind_marca = '';
    let txt_titulo = '';
    var checkbox = document.getElementById(_id);
    if(checkbox.checked){
        ind_marca = 1;
        txt_titulo = "con esta acci&oacute;n proceder&aacute a <b>marcar</b> en estadistica el punto de toma de muestra";
    } else {
        ind_marca = 0;
        txt_titulo = "con esta acci&oacute;n proceder&aacute a <b>desmarcar</b> en estadistica el punto de toma de muestra";
    }
    jPrompt(txt_titulo,'','Confirmaci\u00f3n Clinica Libre',function(r){
        if(r){      
           $('#loadFade').modal('show');
            //alert("MandAR A AJAX");
            $.ajax({ 
                type           :  "POST",
                url            :  "ssan_spab_gestionlistaquirurgica/marca_pto_toma_muestra",
                dataType       :  "json",
                beforeSend     :  function(xhr)     {     },
                data		      :  { 
                                        clave               :   r,
                                        id_toma_muestras    :   id_toma_muestras,
                                        ind_marca           :   ind_marca,
                                    },
                error		      :  function(errro)  {  
                                                       console.log(errro);
                                                       console.log(errro.responseText);  
                                                       jAlert("Error General, Consulte Al Administrador"); 
                                                       setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                    },
                success		   :   function(aData)  {  
                                                        console.error("aData -> ",aData);
                                                        setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                                                        if (aData.esissan){
                                                          showNotification('top','left',"Se modifico marcado de estadistica",4,'fa fa-check-square');

                                                        } else {
                                                            revertir_marcado(ind_marca,_id);
                                                            jError("Error en la firma simple","Clinica Libre");
                                                      }
                                                    }, 
             });



        } else {  
            revertir_marcado(ind_marca,_id);
        }  
    });
}


function revertir_marcado(ind_marca,_id){
    var checkbox = document.getElementById(_id);
    if (ind_marca == 1){
        checkbox.checked = false;
    } else {
        checkbox.checked = true;
    }
}

function js_editanombre(id){
    const data_rotulado = $(".data_rotulado_"+id).data('data_plantilla');
    console.log("data_rotulado  ->  ",data_rotulado);
    //ver la edicion de nombre
}

function js_confirma_cambio(id){
    let nombre = $("#new_nombre_"+id).val().toUpperCase();
    jPrompt('Con esta acci&oacute;n proceder&aacute; a editar nombre de punto de toma de muestra','','Confirmaci\u00f3n Clinica Libre',function(r){
        if(r){      
           $('#loadFade').modal('show');
           $.ajax({ 
                type : "POST",
                url : "ssan_spab_gestionlistaquirurgica/update_nombre_pto",
                dataType : "json",
                beforeSend : function(xhr) { },
                data : { 
                    clave : r,
                    id : id,
                    nombre : nombre,
                },
                error : function(errro) {  
                    console.log(errro);
                    console.log(errro.responseText);  
                    jAlert("Error General, Consulte Al Administrador"); 
                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                },
                success : function(aData) {  
                    console.error("aData -> ",aData);
                    setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
                    if (aData.esissan){
                        showNotification('top','left',"Se edit&oacute; nombre de toma de muestra",4,'fa fa-check-square');
                        $("#modal_gestion_tomamuestraxuser").modal('hide');
                        setTimeout(function() {
                            
                            console.log("Han pasado 3 segundos!");
                            js_gestion_tomademuestraxuser();
                        }, 2000);
                    } else {
                        jError("Error en la firma simple","Clinica Libre");
                    }
                }, 
           });
        } 
    });
}

function pdf_recepcion_ok(id_anatomia){
	$('#loadFade').modal('show');
    $.ajax({ 
        type : "POST",
        url : "ssan_libro_biopsias_usuarioext/pdf_recepcion_anatomia_pat_ok",
        dataType : "json",
        beforeSend : function(xhr) {   
            console.log(xhr);
            console.log("generando PDF recepcion ok");
            $('#HTML_PDF_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF");
        },
        data : { id : id_anatomia, },
        error : function(errro) { 
            console.log("quisas->",errro,"-error->",errro.responseText); 
            $("#protocoloPabellon").css("z-index","1500"); 
            jError("Error General, Consulte Al Administrador","Clinica Libre"); 
            $('#HTML_PDF_ANATOMIA_PATOLOGICA').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
            setTimeout(function(){ $('#loadFade').modal('hide');  }, 1000);
        },
        success : function(aData) { 
            if(!aData["STATUS"]){
                jError("error al cargar protocolo PDF","Clinica Libre");
                setTimeout(function(){ $('#loadFade').modal('hide'); }, 1000);
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
                Objpdf.setAttribute('style','height:700px;');
                Objpdf.setAttribute('title','PDF');
                $('#PDF_VERDOC').html(Objpdf);
                setTimeout(function(){ $('#loadFade').modal('hide'); $("#Dv_verdocumentos").modal("show");}, 1000);
            }
        }, 
   });
}