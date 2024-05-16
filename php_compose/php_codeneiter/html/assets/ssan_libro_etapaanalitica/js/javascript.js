$(document).ready(function(){
    var today			=   new Date();
    var dd                      =   today.getDate();
    var mm                      =   today.getMonth()+1; 
    var yyyy			=   today.getFullYear();
    if (dd<10)			{   dd='0'+dd; } 
    if (mm<10)			{   mm='0'+mm; } 
    var today			=   dd+'-'+mm+'-'+yyyy;
    var todayDate               =   new Date().getDate();
    
    //console.log("fecha_inicio");
    //console.log("fecha_final->",$(".info_userdata").data("fecha_final") );
    //var date_inicio                   =   moment($(".info_userdata").data("fecha_inicio"))._d;
    //console.log($(".info_userdata").data("fecha_inicio"),"->","date_inicio->",date_inicio);
    //var date_final                    =   moment($(".info_userdata").data("fecha_final"))._d;
    //console.log($(".info_userdata").data("fecha_final"),"->","date_final->",date_final);
    //tiempo
    //var date_inicio                   =   moment('22-03-2022 10:48',"DD-MM-YYYY HH:mm").valueOf();;
    //console.log("date_inicio          ->  ",date_inicio,"     <-                  ");
    //var date_final                    =   moment('22-03-2022 10:48',"DD-MM-YYYY HH:mm").valueOf();;
    //console.log("date_final           ->  ",date_final,"     <-                   ");
    //if (date_inicio === date_final)   {
    //console.log("YES SON IGUALES");
    //} else {
    //console.log("NO SON IGUALES");
    //}
    
    $('#fecha_out').datetimepicker({
        useCurrent              :   false,//esto es importante ya que las funciones establecen el valor de fecha predeterminado en el valor actual
        inline			:   true,
        sideBySide              :   true,
        format			:   'DD-MM-YYYY',
        locale			:   'es-us',
        //daysOfWeekDisabled	:   [0,6],
        maxDate                 :   moment($(".info_userdata").data("fecha_final"))._d, 
        //minDate		:   new Date(new Date().setDate((todayDate)-(5))), 
        defaultDate             :   moment($(".info_userdata").data("fecha_inicio"))._d,
        icons			:   {
                                        time        :   "fa fa-clock-o"         ,
                                        date        :   "fa fa-calendar"        ,
                                        up          :   "fa fa-chevron-up"      ,
                                        down        :   "fa fa-chevron-down"    ,
                                        previous    :   'fa fa-chevron-left'    ,
                                        next        :   'fa fa-chevron-right'   ,
                                        today       :   'fa fa-screenshot'      ,
                                        clear       :   'fa fa-trash'           ,
                                        close       :   'fa fa-remove'          ,
                                    }
    });
    $(".timepicker").remove();
    $("#fecha_out").on("dp.change",function(e){ 
        $('#fecha_out2').data("DateTimePicker").minDate($('#fecha_out').data().date);
        update_etapaanalitica();
    });
    $('#fecha_out2').datetimepicker({
        useCurrent              :   false,//esto es importante ya que las funciones establecen el valor de fecha predeterminado en el valor actual
        inline			:   true,
        sideBySide              :   true,
        format			:   'DD-MM-YYYY',
        locale			:   'es-us',
        //daysOfWeekDisabled	:   [0,6],
        //minDate               :   new Date(new Date().setDate((todayDate)-(5))), 
        minDate                 :   moment($(".info_userdata").data("fecha_inicio"))._d,
        maxDate                 :   new Date(),
        defaultDate             :   moment($(".info_userdata").data("fecha_final"))._d, 
        icons			:   {
                                        time        :   "fa fa-clock-o"         ,
                                        date        :   "fa fa-calendar"        ,
                                        up          :   "fa fa-chevron-up"      ,
                                        down        :   "fa fa-chevron-down"    ,
                                        previous    :   'fa fa-chevron-left'    ,
                                        next        :   'fa fa-chevron-right'   ,
                                        today       :   'fa fa-screenshot'      ,
                                        clear       :   'fa fa-trash'           ,
                                        close       :   'fa fa-remove'          ,
                                    }
    });
    $('#fecha_out2').on('dp.change',function(e){
        $('#fecha_out').data("DateTimePicker").maxDate($('#fecha_out2').data().date);
        update_etapaanalitica();
    });
    $(".timepicker").remove();
    $(".LOAD_CALENDARIO").hide();
    $('.lista_etapa_analitica li').on('click',function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    $('#MODAL_FORMULARIO_ANALITICA').on('show.bs.modal',function(e){ 
        $('.modal .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
        $('.modal .modal-body').css('min-height',_height);
    });
    
    $('#MODAL_FORMULARIO_ANALITICA').on('hidden.bs.modal',function(e){ 
        $("#HTML_FORMULARIO_ANALITICA").html(''); 
        $("#btn_finaliza_rce_anatomia").attr('onclick','');
        document.getElementById('btn_finaliza_rce_anatomia').disabled      =   true;
    });
    
    $('#modal_descipcion_muestras').on('show.bs.modal',function(e){ 
        $("#html_pdf_fullscreen").html(''); 
        $('.modal .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
        $('.modal .modal-body').css('min-height',_height);
    });
    $('#modal_descipcion_muestras').on('hidden.bs.modal',function(e){ 
        $("#html_descipcion_muestras").html(''); 
    });
    $('#modal_pdf_fullscreen').on('show.bs.modal',function(e){ 
        $("#html_pdf_fullscreen").html(''); 
        $('.modal .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
        $('.modal .modal-body').css('min-height',_height);
    });
    $('#modal_pdf_fullscreen').on('hidden.bs.modal',function(e){ 
        $("#html_pdf_fullscreen").html(''); 
    });
    $('#modal_star_sala_proceso').on('show.bs.modal',function(e){ 
        $("#html_sala_tecnicas").html('');
        $("#btn_star_sala_proceso").attr('onclick','');
        $('.modal .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
        $('.modal .modal-body').css('min-height',_height);
    });
    $('#modal_star_sala_proceso').on('hidden.bs.modal',function(e){ 
        $("#html_sala_tecnicas").html(''); 
        $("#btn_star_sala_proceso").attr('onclick','');
    });
    $('#modal_sala_tecnicas').on('show.bs.modal',function(e){ 
        $('.modal .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
        $('.modal .modal-body').css('min-height',_height);
    });
    $('#modal_sala_tecnicas').on('hidden.bs.modal',function(e){ 
        $("#html_sala_tecnicas").html(''); 
        $("#btn_graba_tecnicas").attr('onclick','');
        $("#btn_previo_sala_tecnicas").attr('onclick','');
    });
    $('#modal_perfil_administrativo').on('show.bs.modal',function(e){ 
        $('.modal .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.modal .modal-body').css('max-height',_height);
        $('.modal .modal-body').css('min-height',_height);
    });
    $('#modal_perfil_administrativo').on('hidden.bs.modal',function(e){ 
        $("#html_perfil_administrativo").html(''); 
        $("#btn_perfil_administrativo").attr('onclick','');
    });
    $('#modal_plantillas_macro_micro').on('hidden.bs.modal',function(e){ 
        $("#html_plantillas_macro_micro").html('');
        $("#btn_nueva_plantilla").attr('onclick','');
        $("#btn_guarda_descripcion").attr('onclick','');
        $(".main-panel").perfectScrollbar("destroy");
        document.getElementById("modal_plantillas_macro_micro").style.overflowY     =   'auto';
    });
    $('#modal_nueva_plantilla').on('hidden.bs.modal',function(e){ 
        $(".main-panel").perfectScrollbar("destroy");
        document.getElementById("modal_nueva_plantilla").style.overflowY            =   'auto';
    });
    $('#modal_gestion_firma_patologo').on('hidden.bs.modal',function(e){ 
        $("#html_gestion_firma_patologo").html(''); 
    });
    $('#Dv_verdocumentos').on('hidden.bs.modal',function(e){ 
        $("#PDF_VERDOC").html(''); 
    });

    //tabs busqueda principal
    //console.log("   ***********************************************************************  ");
    //console.log("   storange_tabs_main  ->  ",localStorage.getItem("storange_tabs_main"));

    localStorage.getItem("storange_tabs_main")===null?null_tabs():js_gestion();

    var tabElements = document.querySelectorAll('.tabs_main_analitica .nav-link');
    tabElements.forEach(function(tab) {
        tab.addEventListener('shown.bs.tab', function(event) {
            var target = event.target.getAttribute('data-bs-target') || event.target.getAttribute('href');
            $("#span_tipo_busqueda").html(target);
            $(".n_resultados_panel").html('0'); 
            $.ajax({ 
                type                :   "POST",
                url                 :   "ssan_libro_etapaanalitica/gestion_cookie",
                dataType            :   "json",
                beforeSend          :   function(xhr)   {   
                                                            console.log("ssan_libro_etapaanalitica/gestion_cookie   ->    ",xhr);   
                                                        },
                data                :                   { 
                                                            target          :   target,
                                                            date_inicio     :   $('#fecha_out').data().date,
                                                            date_final      :   $('#fecha_out2').data().date,
                                                        },
                error               :   function(errro) { 
                                                            console.log(errro);  
                                                            console.log(errro.responseText);    
                                                            jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                        },
                success             :   function(aData) { 
                                                            //console.log("return aData->",aData);
                                                            let txt_titulo = $("."+target.slice(1)).data().titulo;
                                                            //console.log("txt_titulo ->  ",txt_titulo);
                                                            $("#txt_busqueda_titulo").html('null');
                                                            li_busqueda_ver_oculta($("."+target.slice(1)).data().zona_li);
                                                            localStorage.setItem("storange_tabs_main",target);
                                                            js_visualizacion_menu_principal(target);
                                                            update_etapaanalitica();
                                                        }, 
            });
        });
    });

    $("#panel_bacode_1").click(function(){setTimeout(function(){$(".focus_etiqueta").focus();},500);});
    $(".focus_etiqueta").keypress(function(e){ if(e.which==13){ busqueda_etiquera_analitica(0,'',{}); } });
    SetFocus();
   //panel de busqueda
    $('#panel_altrapriopidad,#panel_casos,#panel_archivar,#panel_etiquetas').on('show.bs.collapse',function(e){
        e.target.id == 'panel_altrapriopidad'       ?   localStorage.setItem("memoria_altrapriopidad",true):'';
        e.target.id == 'panel_casos'                ?   localStorage.setItem("memoria_casos",true):'';
        e.target.id == 'panel_archivar'             ?   localStorage.setItem("memoria_archivar",true):'';
        e.target.id == 'panel_etiquetas'            ?   localStorage.setItem("memoria_etiquetas",true):'';
        e.target.id == 'panel_etiquetas'            ?   $("#header_menu_etiquetas").css('border-radius','0px 0px 0px 0px'):'';
        $("#icono_"+e.target.id).removeClass("fa fa-sort-asc").addClass("fa fa-sort-desc");
    });
    
    $('#panel_altrapriopidad,#panel_casos,#panel_archivar,#panel_etiquetas').on('hidden.bs.collapse',function(e){
        e.target.id == 'panel_altrapriopidad'       ?   localStorage.setItem("memoria_altrapriopidad",false):'';
        e.target.id == 'panel_casos'                ?   localStorage.setItem("memoria_casos",false):'';
        e.target.id == 'panel_archivar'             ?   localStorage.setItem("memoria_archivar",false):'';
        e.target.id == 'panel_etiquetas'            ?   localStorage.setItem("memoria_etiquetas",false):'';
        e.target.id == 'panel_etiquetas'            ?   $("#header_menu_etiquetas").css('border-radius','0px 0px 4px 4px'):'';
        $("#icono_"+e.target.id).removeClass("fa fa-sort-desc").addClass("fa fa-sort-asc"); 
    });
    localStorage.getItem("memoria_altrapriopidad")  ===     null?localStorage.setItem("memoria_altrapriopidad",true):   js_gestion_panel("altrapriopidad");
    localStorage.getItem("memoria_casos")           ===     null?localStorage.setItem("memoria_casos",true)         :   js_gestion_panel("casos");
    localStorage.getItem("memoria_archivar")        ===     null?localStorage.setItem("memoria_archivar",true)      :   js_gestion_panel("archivar");
    localStorage.getItem("memoria_etiquetas")       ===     null?localStorage.setItem("memoria_etiquetas",true)     :   js_gestion_panel("etiquetas");
    //busqueda rapida
    $('.radio_busqueda').click(function (){
        //console.log("$(this).val() radio_busqueda -> ",$(this).val());
        if($(this).val() == 1){
            $(".opcion_bsq_persona").hide();
            $(".opcion_bsq_etiqueta").show();
        } else {
            $(".opcion_bsq_persona").show();
            $(".opcion_bsq_etiqueta").hide();
        }
    });
    localStorage.getItem("html_busqueda_bacode")?$(".ul_lista_cod_encontrados").html('').append(localStorage.getItem("html_busqueda_bacode")):'';
    //boton de filtro // cambios
    $('#ind_filtro_busqueda_xfechas').on('changed.bs.select',function(e,clickedIndex,isSelected,previousValue){
        /*
        var ind_filtro                      =   $('#ind_filtro_busqueda_xfechas').val();
        var count_filtro                    =   $('#ind_filtro_busqueda_xfechas').val() == null ? 0 : $('#ind_filtro_busqueda_xfechas').val().length;
        console.log("ind_filtro     ->",ind_filtro);
        if (ind_filtro == null){
            js_desabilita_filtro_busqueda();
            localStorage.setItem("strorage_filtro_categorias","0");
        } else {
            if(js_opt_todas_las_categorias(count_filtro>0?true:false)){
                //cookie
               conf_cookie_filtro_estados($('#ind_filtro_busqueda_xfechas').val());
            }
            localStorage.setItem("strorage_filtro_categorias",$('#ind_filtro_busqueda_xfechas').val().toString());
        }
        */
    }).selectpicker();
    //console.log("-----------------------");
    //console.log("localStorage.getIte    ->  " , localStorage.getItem("strorage_filtro_categorias") );
    if (localStorage.getItem("strorage_filtro_categorias")===null || localStorage.getItem("strorage_filtro_categorias")=='0'){
        //console.log("SI");
        js_opt_todas_las_categorias(false);
    }  else {
        console.log("NO");
        $('#ind_filtro_busqueda_xfechas').selectpicker('val',localStorage.getItem("strorage_filtro_categorias").split(','));
    }
    
    //console.log("---------------------------------------------------------------------------------------------------------");
    //console.log("star storage_busqueda_por_n_biosia     ->  ",localStorage.getItem("storage_busqueda_por_n_biosia"));
    //console.log("star storange_ids_anatomia             ->  ",localStorage.getItem("storange_ids_anatomia"));
    //console.log("---------------------------------------------------------------------------------------------------------");
    
    //star check de _panel_por_gestion -> tipo_busqueda
    var ind_star_busq       =   1;
    if(localStorage.getItem("storage_busqueda_por_n_biosia")===null){
        document.getElementById("busqueda_por_paciente").checked    =   true;
    }  else  {
        var txt_busq        =   localStorage.getItem("storage_busqueda_por_n_biosia");
        document.getElementById(txt_busq).checked                   =   true;
        ind_star_busq       =   txt_busq == 'busqueda_por_n_biosia' ? 2 : 1;
    }
    //elimina la localStorage
    localStorage.removeItem("storange_ids_anatomia");
    //sessionStorage la localStorage
    sessionStorage.removeItem("arr_storange_ids_anatomia");
    sessionStorage.clear();
    //star buscador 
    star_automplete(ind_star_busq);
    //ws etapa analitica
    //desabilitado
    //ws_etapa_analitica();
});


function js_gestion(){
    //console.error("js_gestion     ->  localStorage   ->  ",localStorage.getItem("storange_tabs_main"));
    var tabs_active             =   localStorage.getItem("storange_tabs_main");
    var data_tabs               =   $("."+tabs_active.slice(1)).data();
    js_visualizacion_menu_principal(tabs_active);
    $("#txt_busqueda_titulo").html(data_tabs.titulo);
    li_busqueda_ver_oculta(data_tabs.zona_li);
    $('.tabs_main_analitica a[href="'+tabs_active+'"]').tab('show');
    return true;
}

function js_gestion_firma(){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_etapaanalitica/gestion_firma_patologo",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("ssan_libro_etapaanalitica/gestion_cookie   ->  ",xhr);   
                                                },
        data                :                   { },
        error               :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                    $('#loadFade').modal('hide'); 
                                                },
        success             :   function(aData) { 
                                                    $('#loadFade').modal('hide'); 
                                                    $("#html_gestion_firma_patologo").html(aData.html);
                                                    $("#modal_gestion_firma_patologo").modal({backdrop:'static',keyboard:false}).modal("show");
                                                }, 
    });
}

function js_img_default(){
    //$(".img_gestion").html();
}

function js_img_data(img_base){
    var txt         =   '<div class="card" style="margin-bottom:0px;text-align:-webkit-center;padding:6px;">'+
                            '<img '+
                                'alt                     =  "200x110"'+
                                'class                   =  "img-thumbnail" '+
                                'data-src                =  "200x110" '+
                                'src                     =  "'+img_base+'" '+ 
                                'data-holder-rendered    =  "true" '+
                                'style                   =  "width:200px;height:110px;" '+
                            '>'+
                            '<hr style="margin:2px">'+
                            '<a href="javascript:delete_img_x_muestra()">'+
                                '<i class="fa fa-trash-o" aria-hidden="true"></i>'+
                            '</a>'+
                        '</div>';
    $(".img_gestion").html(txt);
}

function js_test_ap(){
    $('#loadFade').modal('show');
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_etapaanalitica/return_ima_firma_patologo",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("ssan_libro_etapaanalitica/gestion_cookie ->",xhr);   
                                                },
        data                :                   { },
        error               :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                    $('#loadFade').modal('hide'); 
                                                },
        success             :   function(aData) { 
                                                    $('#loadFade').modal('hide'); 
                                                    console.log("aData  ->  ",aData);
                                                    //$('#loadFade').modal('hide'); 
                                                    //$("#html_gestion_firma_patologo").html(aData.html);
                                                    //$("#modal_gestion_firma_patologo").modal({backdrop:'static',keyboard:false}).modal("show");
                                                }, 
    });
}

function js_adjunto_firma(archivos){
    //ingreso de la imagen 
    var navegador       =   window.URL || window.webkitURL;
    var size            =   archivos[0].size;
    var type            =   archivos[0].type;
    var name            =   archivos[0].name;
    if(size>1024*1024){
            jAlert("El archivo "+name+" supera el m&aacute;ximo permitido 1MB","LISTA DE ERRORES");
            return false;
        } else if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' && type != 'image/gif'){
            jAlert("El archivo "+name+" no es del tipo de imagen permitida.","LISTA DE ERRORES");
            return false;
    } else {
        //console.log("archivos en js ->    ",archivos);
        var formData            =   new FormData();
        var reader              =   new FileReader();
        reader.onloadend        =   function(){
            const blob          =   new Blob([reader.result],{type:"image/jpeg"});
            formData.append("img_firma_get",blob,name);
            fetch('ssan_libro_etapaanalitica/return_ima_firma_patologo',{
                method          :   "POST",
                body            :   formData,
            }).then(function(response){
                console.log("response           ->",response);
                return response.json();
            }).then(function(data_return){
                console.log("---------------------------------");
                console.log("data_return    ->  ",data_return);
                console.log("---------------------------------");
                js_img_data(navegador.createObjectURL(archivos[0]))
                jAlert("Subida con &eacute;xito","Clinica Libre");
            }).catch(function(err){  
                console.log('Error:  ', err);  
                jError("Error al subir imagen","Clinica Libre");
            });
        };
        reader.readAsDataURL(archivos[0]);//base_64
    }
}

function star_automplete(_value){
    var opciones            =   {
        adjustWidth         :   false,
        url                 :   function(phrase){
                                    if (phrase!=="") {
                                        return "ssan_libro_etapaanalitica/get_busqueda_solicitudes_ap";
                                    } else {
                                        return "ssan_libro_etapaanalitica/get_busqueda_solicitudes_ap";
                                    }
                                },
        preparePostData     :   function(data){
                                    data.phrase                         =   $("#slc_automplete_biopsia").val();
                                    data.tipo_busqueda                  =   $("input[name='ind_tipo_busqueda']:checked").val();
                                    console.log("---------------------------------------------------------------");
                                    console.log("preparePostData data   ->  ",data,"    <                       ");
                                    console.log("---------------------------------------------------------------");
                                    return data;
                                },
        getValue            :   "name",
        template            :   {   
                                    type        :   "description",  
                                    fields      :   {   description     :   "type" , iconSrc: "icon"},
                                    method      :   function(value,item) {
                                                        return "<span class='fa fa-battery-empty'></span>" + value;
                                                    }
                            },                
        ajaxSettings        :   {
                                    dataType    :   "json",
                                    method      :   "POST",
                                    error       :   function(errro) { 
                                                        //console.log(errro.responseText);    
                                                        jError("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                    },
                                    data        :   {
                                                        dataType        :   "json",
                                                    }
                                },
        //theme             :   "dark",
        placeholder         :   _value == 1 ? "Ingrese paciente":"Numero Biopsia/citologico/pap",
        requestDelay        :   400,
        theme               :   "round",
        list                :   {
                                    showAnimation   :   {
                                        type        :   "fade", //normal|slide|fade
                                        time        :   400,
                                        callback    :   function(){}
                                    },
                                    hideAnimation   :   {
                                        type        :   "slide", //normal|slide|fade
                                        time        :   400,
                                        callback    :   function(){}
                                    }
                                },
        list                :   {
            onClickEvent        :   function(){
                                    console.log("-------------------------------------------------------------------------------------------------");
                                    console.log("---> Click ! de salid con datos    => ",$("#slc_automplete_biopsia").getSelectedItemData(),"  <-");
                                    var clic_arr                                    =   $("#slc_automplete_biopsia").getSelectedItemData();
                                    var v_new_id_anatomia                           =   $("#slc_automplete_biopsia").getSelectedItemData().id_anatomia;
                                    
                                    var arr_storange_ids_anatomia                   =   [];
                                    arr_storange_ids_anatomia                       =   localStorage.getItem("storange_ids_anatomia");
                                    console.log("----------------------------------------------------------------------------");
                                    console.log("original   =>    ",localStorage.getItem("storange_ids_anatomia"));
                                    console.log("val 2      =>    ",arr_storange_ids_anatomia == null);
                                    if( arr_storange_ids_anatomia == null ){
                                    //if(arr_storange_ids_anatomia.length > 0){
                                        localStorage.setItem("storange_ids_anatomia",v_new_id_anatomia);
                                    } else {
                                        var arr_storange_ids_anatomia_mod           =   localStorage.getItem("storange_ids_anatomia").split(',');
                                        console.log("---------------------------------------------------------------------------------------------");
                                        console.log("LISTA EN MEMORIA               ->  ",arr_storange_ids_anatomia_mod);
                                        console.log("NEW ID ANATOMIA                ->  ",v_new_id_anatomia);
                                        //para verificar si el array contiene valor en JavaScript - localstrnege
                                        console.log("indexOf                        ->  ",arr_storange_ids_anatomia_mod.indexOf(v_new_id_anatomia)); 
                                        console.log("---------------------------------------------------------------------------------------------");
                                        if(arr_storange_ids_anatomia_mod.indexOf(v_new_id_anatomia) == -1){
                                            arr_storange_ids_anatomia_mod.push(v_new_id_anatomia);
                                            localStorage.removeItem('storange_ids_anatomia');
                                            console.log("storange_ids_anatomia 2         =>  ",localStorage.getItem("storange_ids_anatomia"));
                                            console.log("   =>  Se agrega elemento  <=  ")
                                            console.log("arr_storange_ids_anatomia +  push  array   ->  ",arr_storange_ids_anatomia_mod);
                                            console.log("arr_storange_ids_anatomia +  join  string  ->  ",arr_storange_ids_anatomia_mod.join(","));
                                            localStorage.setItem("storange_ids_anatomia",arr_storange_ids_anatomia_mod.join(","));
                                        } else {
                                            console.log("-----------------------------------------------------------------------------------------------------------------------");
                                            console.log("   ->  Pasa como colectivo lleno   <-                                                                                  ");
                                            console.log("   El numero ",v_new_id_anatomia,", Ya existe en el array " ,localStorage.getItem("storange_ids_anatomia") ," Verdad?");
                                            showNotification('top','center','La busqueda ya se encuentra en la lista;',1,'fa fa-ban');
                                        }
                                    }
                                    
                                    console.error("-----------------------------------------------------------------------------");
                                    console.error(" busqueda de arrs  ->  ",localStorage.getItem("storange_ids_anatomia"),"  <-      ");
                                    //console.error("-----------------------------------------------------------------------------");
                                    update_etapaanalitica();
                                }
            //http://easyautocomplete.com/guide
        },
    };
    //console.log("_value     "+_value);
    document.getElementById('slc_automplete_biopsia').type = _value == 1 ? 'text':'number';
    $("#slc_automplete_biopsia").val('');
    //console.log("opciones    |   ",opciones);
    $("#slc_automplete_biopsia").easyAutocomplete(opciones);
}


function update_etapaanalitica(){
    var date_inicio             =   $('#fecha_out').data().date;
    var date_final              =   $('#fecha_out2').data().date;
    //return false;
    var v_storange_tabs_main    =   localStorage.getItem("storange_tabs_main");
    var v_get_sala              =   $("#get_sala").val();
    var v_filtro_fechas         =   $("#ind_filtro_busqueda_xfechas").val().join(",");
    var v_ids_anatomia          =   localStorage.getItem("storange_ids_anatomia");
    
    /*
    console.log("---------------------------------------------------------------------------------------------------");
    console.log("------------------------fata update_etapaanalitica ------------------------------------------------");
    console.log("storange_tabs_main                 ->  ",localStorage.getItem("storange_tabs_main"),"          <-  ");
    console.log("ind_filtro_busqueda_xfechas        ->  ",$("#ind_filtro_busqueda_xfechas").val(),"             <-  ");
    console.log("ind_filtro_busqueda_xfechas.join   ->  ",$("#ind_filtro_busqueda_xfechas").val().join(","),"   <-  ");
    console.log("storange_ids_anatomia              ->  ",localStorage.getItem("storange_ids_anatomia"),"       <-  ");
    console.log("---------------------------------------------------------------------------------------------------");
    console.log("date_inicio                        ->  ",date_inicio);
    console.log("date_final                         ->  ",date_final);
    console.log("v_storange_tabs_main               ->  ",v_storange_tabs_main);
    console.log("v_get_sala                         ->  ",v_get_sala);
    console.log("v_filtro_fechas                    ->  ",v_filtro_fechas);
    console.log("v_ids_anatomia                     ->  ",v_ids_anatomia);
    console.log("---------------------------------------------------------------------------------------------------");
    */

    $('#loadFade').modal('show');
    $.ajax({ 
        type        :   "POST",
        url         :   "ssan_libro_etapaanalitica/update_lista_etapaanalitica",
        dataType    :   "json",
        beforeSend  :   function(xhr)   {   
                                            //console.log("load load_etapa_analitica - update_lista_etapaanalitica -> ",xhr);  
                                            //setTimeout($('#loadFade').modal('show'),1000);
                                        },
        data        :                   { 
                                            date_inicio                     :   date_inicio,
                                            date_final                      :   date_final,
                                            tabs                            :   v_storange_tabs_main,
                                            txt_sala                        :   v_get_sala,             //to_string
                                            ind_filtro_busqueda_xfechas     :   v_filtro_fechas,        //to_string
                                            txt_ids_anatomia                :   v_ids_anatomia,         //to string
                                            ind_order_by                    :   $("#ind_order_by").val()
                                        },
        error       :   function(errro) { 
                                            console.log(errro);  
                                            console.log(errro.responseText);
                                            jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                            $('#loadFade').modal('hide'); 
                                        },
        success     :   function(aData) { 
                                            //console.log("   ------------------------------------    ");
                                            //console.log("   update_etapaanalitica   ->  ",aData);
                                            $('#loadFade').modal('hide');
                                            //console.log(aData.arr_ids_anatomia);
                                            //console.log("id_html_out              ->",    aData.id_html_out);
                                            //console.log("arr_ids_anatomia         ->",    aData.arr_ids_anatomia);
                                            //console.log("out_html                 ->",    aData.out_html);
                                            //console.log("html_li                  ->",    html_li);
                                            //console.log("html                     ->",    aData.out_html.return_html);
                                            //$("."+html_li).html('').html(aData.out_html.return_html;
                                            var html_li                             =   $("."+aData.id_html_out).data().zona_li;
                                            var html_out                            =   aData.out_html.return_html;
                                            //console.log("----------------------out result--------------------------------------------");
                                            //console.log("aData.V_DATA               ->  ", aData.return.V_DATA);
                                            //console.log("aData.html_li            ->  ",html_li);
                                            //console.log("aData.html_out           ->  ",html_out);
                                            $(".n_resultados_panel").html(aData.return.n_resultado);
                                            $("."+html_li).html('').html(html_out);
                                        }, 
    });
    //return false;
}

function js_vista_opcion_busqueda(_value){
    console.log("-----------------------------------------------");
    console.log("_value     ->      ",_value,"  <-              ");
    console.log("-----------------------------------------------");
    localStorage.setItem("storage_busqueda_por_n_biosia",_value);
    $("#slc_automplete_biopsia").val('');
    //console.log("storage_busqueda_por_n_biosia          ->  ",localStorage.getItem("storage_busqueda_por_n_biosia"));
    var num_value      =   _value == 'busqueda_por_paciente'?1:2;
    star_automplete(num_value);
}

function js_delete_list_gestion(new_id_anatomia){
    var new_id_anatomia                         =   new_id_anatomia.toString();
    var arr_storange_ids_anatomia               =   localStorage.getItem("storange_ids_anatomia").split(',');
    var v_return_indice                         =   arr_storange_ids_anatomia.indexOf(new_id_anatomia); 
    //console.log("------------------------------------------------------------------------------");
    //console.log("arr_storange_ids_anatomia    =>  ",arr_storange_ids_anatomia);
    //console.log("new_id_anatomia delete       =>  ",new_id_anatomia);
    //console.log("Existe                       :   ",arr_storange_ids_anatomia.indexOf(new_id_anatomia) >= 0);
    var indice                                  =   arr_storange_ids_anatomia.indexOf(new_id_anatomia);
    arr_storange_ids_anatomia.splice(indice,1);
    localStorage.removeItem('storange_ids_anatomia');
    if(arr_storange_ids_anatomia.length > 0){
        localStorage.setItem("storange_ids_anatomia",arr_storange_ids_anatomia.join(","));
        update_etapaanalitica();
    } else {
        $.ajax({ 
            type                :   "POST",
            url                 :   "ssan_libro_etapaanalitica/get_elimina_cookie_paciente",
            dataType            :   "json",
            beforeSend          :   function(xhr)   {   
                                                        console.log("ssan_libro_etapaanalitica/get_elimina_cookie_paciente   ->    ",xhr);   
                                                    },
            data                :                   {  },
            error               :   function(errro) { 
                                                        console.log(errro);  
                                                        console.log(errro.responseText);    
                                                        jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                    },
            success             :   function(aData) { 
                                                        console.log("return aData   ->  ",aData);
                                                        $(".solicitud_"+new_id_anatomia).remove();
                                                    }, 
        });
    }
}

function ver_cookie(){
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_etapaanalitica/ver_gestion_cookie",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("ssan_libro_etapaanalitica/gestion_cookie   ->    ",xhr);   
                                                },
        data                :                   {  },
        error               :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                },
        success             :   function(aData) { 
                                                    console.log("return aData   ->  ",aData);
                                                }, 
    });
}

function js_visualizacion_menu_principal(target){
    //console.log("---------------------------------");
    //console.log("target ->  ",target);
    //console.log("---------------------------------");
    if (target == '#_panel_por_fecha'){
        $(".grid_filtro_panel_por_fecha").show();
    }
    if (target == '#_panel_por_gestion'){
        $(".grid_filtro_panel_por_fecha").hide();
    }
    return true;
}

function conf_cookie_filtro_estados(_filtro_estados){
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_etapaanalitica/gestion_cookie_porfiltros",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("ssan_libro_etapaanalitica/gestion_cookie ->",xhr);   
                                                },
        data                :                   { 
                                                    data_for_cookie :   _filtro_estados,
                                                },
        error               :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                },
        success             :   function(aData) { 
                                                    console.log("aData  ->  ",aData);
                                                    console.log("localStorage   ->  ",localStorage.getItem("strorage_filtro_categorias"));
                                                    update_etapaanalitica();
                                                }, 
    });
}

function js_opt_todas_las_categorias(_booleano){
    //console.log("js_opt_todas_las_categorias -> _booleano          ->  ",_booleano);
    if(_booleano){
        //remueve la opcion todas las categorias
        var toRemove    =   '0';
        var arr         =   $('#ind_filtro_busqueda_xfechas').val();
        arr             =   arr.filter(function(item){ return item !== toRemove });
        console.log("arr    ->  ",arr); 
        $('#ind_filtro_busqueda_xfechas').selectpicker('deselectAll');
        $('#ind_filtro_busqueda_xfechas').selectpicker('val',arr);
    } else {
        $('#ind_filtro_busqueda_xfechas').selectpicker('val','0');
    }
    //deshabilita la opcion todas las categorias
    var selectobject                =   document.getElementById("ind_filtro_busqueda_xfechas").getElementsByTagName("option");
    //console.log("selectobject       ->  ",selectobject);
    selectobject[0].disabled        =   _booleano;
    //selectobject[0].checked       =    false;
    $('#ind_filtro_busqueda_xfechas').selectpicker('refresh');
    return true;
}

function js_desabilita_filtro_busqueda(){
    js_opt_todas_las_categorias(false);
    conf_cookie_filtro_estados([0]);
    localStorage.setItem("strorage_filtro_categorias","0");
    $('#ind_filtro_busqueda_xfechas').selectpicker('val','0').selectpicker('refresh');;
}

function js_views_historial_clinico_(numfichae){
    $("#li_histo_clinico").attr("onclick",'');
    $.ajax({
        url             :   "ssan_libro_etapaanalitica/viws_historial_clinico",
        type            :   "POST",
        dataType        :   "json",
        beforeSend      :   function(xhr)     { },
        data            :   {
                                numfichae : numfichae
                            },
        error           :   function(errro){  
                                console.log(errro);
                                console.log(errro.responseText);
                                jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                            },              
        success         :   function(aData){
                                console.log("IFRAME ->",aData['IFRAME']);
                                $("#HISTO_CLINICO_ELECTRONICO").html('<iframe src="'+aData['IFRAME']+'" style="overflow:hidden;height: 650px;width:100%;"></iframe>');
                            }
    }); 
}

function js_star_plantillas(opcion,num_muestras){
    $("#btn_guarda_descripcion").show();
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/star_gestor_plantillas",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        console.log("ssan_libro_etapaanalitica/star_gestor_plantillas");
                                                    },
        data 		:                           { 
                                                        opcion          :   opcion,
                                                        get_sala        :   $("#get_sala").val(),
                                                        num_muestras    :   num_muestras,
                                                        txt_muestra     :   $("#txt_descipcion_"+num_muestras).val(),
                                                    },
        error		:   function(errro)         { 
                                                        console.log("errro  -> ",errro," | ","error.responseText -> ",errro.responseText); 
                                                        $("#modal_plantillas_macro_micro").modal('hide');
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    },
        success		:   function(aData)         { 
                                                        console.log("aData -> ",aData);
                                                        
                                                        if(aData.status_session){
                                                            if(opcion == 1 || opcion == 0){
                                                                $('#html_plantillas_macro_micro').html(aData.html);
                                                                $("#modal_plantillas_macro_micro").modal({backdrop:'static',keyboard:false}).modal("show");
                                                                $("#btn_nueva_plantilla").attr('onclick','js_new_plantilla('+num_muestras+')');
                                                                if(opcion == 1){
                                                                    $("#btn_guarda_descripcion").attr('onclick','js_agrega_plantilla('+num_muestras+')');
                                                                } else {
                                                                    $("#btn_guarda_descripcion").hide();
                                                                }
                                                            } else {
                                                                $('#ul_resultado_plantillas').empty();
                                                                $("#ul_resultado_plantillas").append(aData.html);
                                                            }
                                                        } else {
                                                            jError("Sesi&oacute;n ha caducado","Clinica Libre");
                                                        } 
                                                    }, 
    });
}

function js_agrega_descripcion(num_plantilla){
    var num_muestras                    =   $(".data_plantilla_"+num_plantilla).data('num_muestra');
    var html_plantilla                  =   $(".data_plantilla_"+num_plantilla).data('data_plantilla').TXT_CUERPO;
    var ta                              =   document.getElementById('txt_descipcion_enplantilla');
    ta.value                            =   html_plantilla;
    ta.style.display                    =   'block';
    autosize.update(ta);
}

function js_agrega_plantilla(num_muestras){
    var txt_plantilla                   =   $("#txt_descipcion_enplantilla").val();
    $("#txt_descipcion_"+num_muestras).val(txt_plantilla);
    $("#modal_plantillas_macro_micro").modal('hide');
}

function js_elimina_plantilla(num_plantilla){
    var num_muestras = $(".data_plantilla_"+num_plantilla).data('num_muestra');
    //console.error("num_muestras   ->  ",num_muestras);
    jPrompt('Con esta acci&oacute;n se proceder&aacute; a eliminar plantilla de anatom&iacute;a patol&oacute;gica. N&deg;:'+num_plantilla+'<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function (r) {
        if(r) {
            $.ajax({ 
                type            :   "POST",
                url             :   "ssan_libro_etapaanalitica/get_elimina_plantilla",
                dataType        :   "json",
                beforeSend      :   function(xhr)           {   
                                                                console.log(xhr);
                                                                console.log("ssan_libro_etapaanalitica/get_elimina_nueva_plantilla");
                                                            },
                data            :                           { 
                                                                contrasena      :   r,
                                                                num_plantilla   :   num_plantilla,
                                                            },
                error           :   function(errro)         { 
                                                                console.log("errro  -> ",errro," | ","error.responseText -> ",errro.responseText); 
                                                                jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                            },
                success         :   function(aData)         { 
                                                                if(aData.status_contrasena){
                                                                    showNotification('top','center','Se ha eliminado plantilla N&deg;:'+num_plantilla,4,'fa fa-ban');
                                                                    js_star_plantillas(2,num_muestras);
                                                                } else {
                                                                    jError("Error en firma simple","Clinica Libre");
                                                                }
                                                            }, 
            }); 
        } else {
            jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
        }
    });
}

function js_new_plantilla(num_muestras){
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/html_nueva_plantilla",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        console.log("ssan_libro_etapaanalitica/html_nueva_plantilla");
                                                        $('#html_nueva_plantilla').html('');
                                                    },
        data 		:                           { 
                                                        get_sala        :   $("#get_sala").val(),
                                                    },
        error		:   function(errro)         { 
                                                        console.log("errro  -> ",errro," | ","error.responseText -> ",errro.responseText); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        $('#html_nueva_plantilla').html('');
                                                    },
        success		:   function(aData)         { 
                                                        console.log("aData->",aData);
                                                        if(aData.status_session){
                                                            $('#html_nueva_plantilla').html(aData.html); 
                                                            
                                                            var v_num_muestras  =  num_muestras === undefined ? '' : num_muestras;
                                                            
                                                            $("#btn_new_plantilla_individual").attr('onclick','js_crea_nueva_plantilla('+v_num_muestras+')');
                                                            $("#modal_nueva_plantilla").modal({backdrop:'static',keyboard:false}).modal("show");
                                                        } else {
                                                            jError("Sesi&oacute;n ha caducado","Clinica Libre");
                                                        } 
                                                    }, 
    });
}

function js_crea_nueva_plantilla(num_muestras){
    var vacio_error                 =   [];
    $("#titulo_plantilla").val()    ==  ''?vacio_error.push(' - Ingrese t&iacute;tulo plantilla'):'';
    $("#pb_motivo").val()           ==  ''?vacio_error.push(' - Ingrese cuerpo plantilla'):'';
    if(vacio_error.length!=0){
        showNotification('top','left',vacio_error.join("<br>"),4,'fa fa-ban');
        return false;
    } else {
        jPrompt('Con esta acci&oacute;n se proceder&aacute; a crear nueva plantilla de anatom&iacute;a patol&oacute;gica.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function (r) {
            if(r){
                $.ajax({ 
                    type            :   "POST",
                    url             :   "ssan_libro_etapaanalitica/get_graba_nueva_plantilla",
                    dataType        :   "json",
                    beforeSend      :   function(xhr)           {   
                                                                    console.log(xhr);
                                                                    console.log("ssan_libro_etapaanalitica/get_graba_nueva_plantilla");
                                                                    //$('#html_nueva_plantilla').html('');
                                                                },
                    data            :                           { 
                                                                    contrasena      :   r,
                                                                    get_sala        :   $("#get_sala").val(),
                                                                    txt_titulo      :   $("#titulo_plantilla").val(),
                                                                    txt_cuerpo      :   $("#pb_motivo").val(),
                                                                },
                    error           :   function(errro)         { 
                                                                    console.log("errro  -> ",errro," | ","error.responseText -> ",errro.responseText); 
                                                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                                    //$('#html_nueva_plantilla').html('');
                                                                },
                    success         :   function(aData)         { 
                                                                    //console.log("aData->",aData);
                                                                    if(aData.status_contrasena){
                                                                        showNotification('top','center','Se ha creado plantilla N&deg;:'+aData.return.n_plantilla,2,'fa fa-check');
                                                                        $("#modal_nueva_plantilla").modal('hide');
                                                                        js_star_plantillas(2,num_muestras);
                                                                    } else {
                                                                        jError("Error en firma simple","Clinica Libre");
                                                                    }
                                                                }, 
                }); 
            } else {
                jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
            }
        });
    }
}

function js_auto_grow(element) {
   autosize.update(document.querySelectorAll('txt_descipcion_enplantilla'));
}

//EXEPCION CITOLOGIA PAP
//1.- LOAD_SALA_PROCESO
function star_descrpcion_muestras(id_anatomia){
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/star_descripcion_anatomia",
        dataType    :   "json",
        beforeSend	:   function(xhr)       {   
                                                $('#loadFade').modal('show');
                                                $('#html_descipcion_muestras').html('');
                                            },
        data 		:                       { 
                                                id_anatomia :   id_anatomia,
                                                get_sala    :   $("#get_sala").val(),
                                            },
        error		:   function(errro)     { 
                                                console.log("quisas->",errro); 
                                                $('#loadFade').modal('hide');
                                                $('#html_descipcion_muestras').html('');
                                                jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                            },
        success		:   function(aData)     { 
                                                console.log("aData->",aData);
                                                $('#loadFade').modal('hide');
                                                if(aData.status_session){
                                                    $("#btn_graba_descipcion_muestras").attr('onclick','js_guarda_descripcion_muestras('+id_anatomia+')');
                                                    $("#html_descipcion_muestras").html(aData.out_html);
                                                    $("#modal_descipcion_muestras").modal({backdrop:'static',keyboard:false}).modal("show");
                                                } else {
                                                    jError("Sesi&oacute;n ha caducado","Clinica Libre");
                                                }
                                            }, 
    });
}








function js_deshabilitar_txt(){
    $('#txt_descipcion_general').removeClass("error_macroscopica");
    $("#txt_descipcion_general").html('');
    var booreane        =       document.getElementById("ind_deshabilitar_macro").checked
    if(booreane){
        document.getElementById('txt_descipcion_general').disabled              =   true;
        $('.grupo_descipcion_general').prop('disabled',true);
        $('.class_txt_macroscopia').css("color","#888888");
    } else {
        document.getElementById('txt_descipcion_general').disabled              =   false;
        $('.grupo_descipcion_general').prop('disabled',false);
        $(".class_txt_macroscopia").css("color","#333");
    }
}

function js_deshabilitar_txt_cito(){
    $('.grupo_macro_textarea_citologia').removeClass("error_macroscopica");
    var booreane            =   document.getElementById("ind_deshabilitar_macro_cito").checked
    //console.log("booreane   ->  ",booreane);
    if(booreane){
        $('.grupo_macro_microfono_citologia').prop('disabled',true);
        $('.grupo_macro_textarea_citologia').prop('disabled',true);
        $('.grupo_macro_img_citologia').css("color","#888888");
    } else {
        $('.grupo_macro_microfono_citologia').prop('disabled',false);
        $('.grupo_macro_textarea_citologia').prop('disabled',false);
        $(".grupo_macro_img_citologia").css("color","#333");
    }
}

function li_busqueda_ver_oculta(txtelemento){
    $('.lista_etapa_analitica').each(function(aux,obj){ txtelemento === obj.id ? $("#"+obj.id).show():$("#"+obj.id).hide(); });
}

//ESCANER CODIGO
function busqueda_etiquera_analitica(from,solicitud,array){
    var html_bsq_li                 =   '';
    var get_etiqueta                =   '';
    var txt_busq_muestra            =   false;
    if(from                        ===  0){
        get_etiqueta                =   $("#get_etiqueta").val();
        txt_busq_muestra            =   true;
        if(get_etiqueta            ===  ''){ document.getElementById("get_etiqueta").focus(); return false; }
    } else if(from                 ===  1){
        get_etiqueta                =   solicitud;
    } else if(from                 ===  3){
        get_etiqueta                =   'S'+solicitud;
    }
    /*
        console.log("----------------busqueda_etiquera------------------"); 
        console.log("false                  =>  ",from,"                    ");
        console.log("solicitud              =>  ",solicitud,"               ");
        console.log("get_etiqueta           =>  ",get_etiqueta,"            ");
        console.log("array                  =>  ",array,"                   ");
        console.log("txt_busq_muestra       =>  ",txt_busq_muestra,"        ");
        console.log("---------------------------------------------------");
    */
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_etapaanalitica/busqueda_individual_etapa_analitica",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("load informacion_x_muestra_grupal ->",xhr);   
                                                },
        data                :                   {
                                                    get_etiqueta    :   get_etiqueta,
                                                    from            :   from,
                                                    opcion          :   1,
                                                    vista           :   1,
                                                    NUM_FASE        :   4,//ETAPA ANALITICA
                                                    MODAL           :   false,
                                                    array_data      :   array,
                                                },
        error		    :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                },
        success             :   function(aData) { 
                                                    console.log("aData      ->  ",aData);
                                                    if(aData.status){
                                                        if(aData.arr_waring.length>0){   showNotification('top','left',aData.arr_waring.join('<br>'),3,'fa fa-times'); }
                                                        if(aData.arr_li_html.length>0){
                                                            $(".sin_resultados_busqueda_bacode").remove();
                                                            $(".sin_buq_x_codigo").remove();
                                                            var aux_li                                  =   $('.ul_lista_cod_encontrados li').size()+1;
                                                            html_bsq_li                                 =   '<li class="list-group-item" style="padding: 0px;">'+
                                                                                                                '<div class="grid_li_resultado_busqueda">'+
                                                                                                                    '<div class="grid_li_resultado_busqueda1">'+aux_li+'</div>'+
                                                                                                                    '<div class="grid_li_resultado_busqueda2">'+get_etiqueta+'</div>'+
                                                                                                                    '<div class="grid_li_resultado_busqueda3">'+
                                                                                                                        '<i class="fa fa-share fa-2x" aria-hidden="true" style="margin-right: 10px;"></i>'+
                                                                                                                    '</div>'+
                                                                                                                '</div>'+
                                                                                                            '</li>';
                                                            $(".ul_lista_cod_encontrados").append(html_bsq_li);
                                                            localStorage.setItem("html_busqueda_bacode",$(".ul_lista_cod_encontrados").html());
                                                            $(".busqueda_por_codigo").append(aData.arr_li_html.join('<br>'));
                                                        }
                                                    } else {
                                                        showNotification('top','left',aData.txt_error,4,'fa fa-times');
                                                        return false;
                                                    }
                                                    //focus
                                                    $("#get_etiqueta").val("");
                                                    document.getElementById("get_etiqueta").focus();
                                                }, 
    });
   return true;
}

function reload_focus(){
    console.log("reload_focus -> reload_focus");
    $(".focus_etiqueta").focus();
    $('#get_etiqueta').focus();
    document.getElementById("get_etiqueta").focus();
    //SetFocus();
}

function SetFocus(){
    //console.log("safety check, make sure its a post 1999 browser");
    if(!document.getElementById){ return; }
    var txtMyInputBoxElement                =   document.getElementById("get_etiqueta");
    //console.log("txtMyInputBoxElement     ->  ",txtMyInputBoxElement);
    if (txtMyInputBoxElement!=null){  
        txtMyInputBoxElement.focus();  
        return true; 
    } else  { 
        return false;
    }
}

function null_tabs(){
    console.log("null_tabs      ->  txt_busqueda_titulo");
    localStorage.setItem("storange_tabs_main","#_panel_por_fecha");
    js_visualizacion_menu_principal("#_panel_por_fecha");
    //localStorage.setItem("html_busqueda_bacode",null);
    localStorage.removeItem('html_busqueda_bacode');
    $('.tabs_main_analitica a[href="#_panel_por_fecha"]').tab('show');
    $(".n_resultados_panel").html('0');
    var data_tabs               =   $("._panel_por_fecha").data();
    $("#txt_busqueda_titulo").html(data_tabs.titulo);
    li_busqueda_ver_oculta(data_tabs.zona_li);
    return true;
}

function delete_cookie(){
    $.ajax({ 
        type                :   "POST",
        url                 :   "ssan_libro_etapaanalitica/fn_delete_cookie",
        dataType            :   "json",
        beforeSend          :   function(xhr)   {   
                                                    console.log("load ssan_libro_etapaanalitica/update_li_chat ->",xhr);   
                                                },
        data                :                   { 
        
                                                },
        error               :   function(errro) { 
                                                    console.log(errro);  
                                                    console.log(errro.responseText);    
                                                    jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                },
        success             :   function(aData) { 
                                                    $("#fecha_out").datetimepicker().data('DateTimePicker').date(aData.date);
                                                    $("#fecha_out2").datetimepicker().data('DateTimePicker').date(aData.date);
                                                    
                                                    $('.tabs_main_analitica a[href="#_panel_por_fecha"]').tab("show");
                                                    localStorage.removeItem('storange_ids_anatomia');
                                                    
                                                    null_tabs();
                                                    js_desabilita_filtro_busqueda();
                                                    update_etapaanalitica();
                                                }, 
    });
}

//ZONA DE CHAT
function actualiza_chat(){
    if ($("#id_anatomia").val() != undefined){
        $.ajax({ 
            type                :   "POST",
            url                 :   "ssan_libro_etapaanalitica/update_li_chat",
            dataType            :   "json",
            beforeSend          :   function(xhr)   {   
                                                        console.log("load ssan_libro_etapaanalitica/update_li_chat ->",xhr);   
                                                    },
            data                :                   { 
                                                        id_anatomia                 :   $("#id_anatomia").val(),
                                                    },
            error               :   function(errro) { 
                                                        console.log(errro);  
                                                        console.log(errro.responseText);    
                                                        jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                    },
            success             :   function(aData) { 
                                                        $("#lista_chat").html("");
                                                        var array                   =   aData.return.return_data;
                                                        $.each(array,function(i,field){
                                                            $("#lista_chat").append(get_add_lista_chat_final(field));
                                                        });
                                                        //final de scrol si existe
                                                        var div                     =   document.getElementById('body_chat');
                                                        div.scrollTop               =   $('#body_chat')[0].scrollHeight;
                                                    }, 
        });
    }
}

function focus_codigo_barras(){
    //Uso de promesas
    console.log("info Uso de promesas - Etapa analitica");
    var p1  = new Promise(function(resolve, reject) {
        document.getElementById("get_etiqueta").focus();
        resolve('Success');
    });
    p1.then(function(value) {
        console.log(value); // "Success!"
        throw 'oh, no!';
    }).catch(function(e) {
        console.log("->",e); // "oh, no!"
        console.log("no focus");
    }).then(function(){
        console.log('despues de una captura, la cadena se restaura');
    },function(){
        console.log('No disparada debido a la captura');
    });
}

function get_add_lista_chat_final(aData){
    $("#sin_chat").hide();
    var a_html      =   '<a href="#" class="list-group-item list-group-item-action" style="padding:0px;">'+
                            '<div class="grid_body_li_chat">'+
                                '<div class="grid_cell chat_user"><div class="cell_content"><small><b style="color:#888888;">'+aData["TXT_USER"]+'</b></small></div></div>'+
                                '<div class="grid_cell chat_time" style="text-align:end;"><div class="cell_content"><small><b style="color:#888888;">'+aData["CHAR_DATE_CREA"]+'</b></small></div></div>'+
                                '<div class="grid_cell chat_menj"><div class="cell_content">'+aData["TXT_CHAT_ANATOMIA"]+'</div></div>'+
                            '</div>'+
                        '</a>';
    return a_html;
}

function js_envia_chat(option){
    var id_anatomia         =   $("#id_anatomia").val();
    var txt_mensaje         =   '';
    
    if (option == 0){
        $("#txt_enviar_mensaje").css("border-color","");
        txt_mensaje         =   $("#txt_enviar_mensaje").val();
        if(txt_mensaje==''){
            $("#txt_enviar_mensaje").css("border-color","red");  
            showNotification('top','right','Debe indicar texto al chat',4,'fa fa-ban');
            return false;
        } else {
            $("#txt_enviar_mensaje").val('');
        }
    }
    if($("#id_anatomia").val() === undefined){
        console.log("->undefined<-");
    } else {
        $.ajax({ 
            type                :   "POST",
            url                 :   "ssan_libro_etapaanalitica/actualiza_chat_all",
            dataType            :   "json",
            beforeSend          :   function(xhr)   {   
                                                        console.log("load ssan_libro_etapaanalitica/actualiza_chat_all ->",xhr);   
                                                    },
            data                :                   { 
                                                        option          :   option,
                                                        id_anatomia     :   id_anatomia,
                                                        txt_mensaje     :   txt_mensaje,
                                                    },
            error               :   function(errro) { 
                                                        console.log(errro);  
                                                        console.log(errro.responseText);    
                                                        jAlert("Error en el aplicativo, Consulte Al Administrador","Clinica Libre"); 
                                                        $("#txt_enviar_mensaje").val('');
                                                    },
            success             :   function(aData) { 
                
                                                        console.log("---------------------------------------------------");
                                                        console.log(" success actualiza_chat_all     =>  ",aData,"<-    ");
                                                        console.log(" chat     =>  ",aData.out_bd.C_CHAT_ANATOMIA,"<-    ");
                                                        console.log("---------------------------------------------------");
                                                        $("#lista_chat").data().mensajes = aData.out_bd.C_CHAT_ANATOMIA;
                                                        update_mensajes_chat();
                                                        
                                                        /*
                                                            $("#txt_enviar_mensaje").val('');
                                                            //submit chat ws
                                                            localStorage.setItem("id_anatomia_x_chat",id_anatomia);
                                                            $("#update_chat_x_hoja").submit();
                                                            //update char local
                                                            //FINAL DE SCROL SI EXISTE
                                                            var div                     =   document.getElementById('body_chat');
                                                            div.scrollTop               =   $('#body_chat')[0].scrollHeight;
                                                        */
                                                    }, 
        });
    }
}

function update_mensajes_chat(){
    var arr_chat    =   $("#lista_chat").data('mensajes');
    var li_html     =   '';
    console.log("---------------------------------");
    console.log("arr_chat   =>  ",arr_chat,"    <=");
    console.log("---------------------------------");
    $.each(arr_chat,function(aux,row){
        li_html     +=  '<a href="#" class="list-group-item list-group-item-action" style="padding:0px;">'+
                            '<div class="grid_body_li_chat">'+
                                '<div class="grid_cell chat_user"><div class="cell_content"><small><b style="color:#888888;">'+row['TXT_USER']+'</b></small></div></div>'+
                                '<div class="grid_cell chat_time"><div class="cell_content"><small><b style="color:#888888;">'+row['CHAR_DATE_CREA']+'</b></small></div></div>'+
                                '<div class="grid_cell chat_menj"><div class="cell_content">'+row['TXT_CHAT_ANATOMIA']+'</div></div>'+
                            '</div>'+
                        '</a>';
    });
    $("#lista_chat").html('').html(li_html);
    
    setTimeout(function(){  
        js_end_scroll();    
    },1000);
}

function js_end_scroll(){
    var div                 =   document.getElementById('body_chat');
    //console.log("div->",div);
    div.scrollTop           =   $('#body_chat')[0].scrollHeight;
}


function js_gestion_panel(txt){
    if (txt=='etiquetas' &&  localStorage.getItem("memoria_"+txt)==="false"){ 
        //console.log("etiquetas cerrado");
        $("#header_menu_etiquetas").css('border-radius','0px 0px 4px 4px');
    }
    localStorage.getItem("memoria_"+txt)==="true"?$("#panel_"+txt).collapse("show"):$("#panel_"+txt).collapse("hide");
}

function ver_imagenes_min(){
    $(".grid_etapaanalitica_3").hide();
    $(".grid_etapaanalitica").css('grid-template-columns','1fr 4fr 0fr');
}

function star_analitica(id_anatomia){
    $('#loadFade').modal('show');
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/formulario_main_analitico",
        dataType    :   "json",
        beforeSend	:   function(xhr)           {   
                                                    console.log(xhr);
                                                    console.log("load ssan_libro_etapaanalitica/formulario_main_analitico   ->  ",$("#get_sala").val());
                                                    $('#HTML_INFORMACION_HISTORIAL').html('');
                                                },
        data 		:                           { 
                                                    id_anatomia     :   id_anatomia,
                                                    get_sala        :   $("#get_sala").val(),
                                                },
        error		:   function(errro)         { 
                                                    console.log("quisas->",errro,"-error.responseText->",errro.responseText); 
                                                    jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    $('#HTML_FORMULARIO_ANALITICA').html('');
                                                    $('#loadFade').modal('hide'); 
                                                },
        success		:   function(aData)         { 
                                                    console.error("   salida star_analitica   ->  ",aData);
                                                    
                                                    $('#loadFade').modal('hide');
                                                    if(aData.status_session){
                                                        $("#btn_guardado_previo").attr('onclick','js_guardado_previo('+id_anatomia+')');
                                                        //console.log("BTN -> ",$(".btn_analitica_"+id_anatomia).data('rce_finaliza'));
                                                        if ($(".btn_analitica_"+id_anatomia).data('rce_finaliza')){
                                                            $("#btn_finaliza_rce_anatomia").attr('onclick','js_finaliza_rce('+id_anatomia+')');
                                                            document.getElementById('btn_finaliza_rce_anatomia').disabled      =   false;
                                                        }
                                                        $("#HTML_FORMULARIO_ANALITICA").html(aData.out_html);
                                                        $("#MODAL_FORMULARIO_ANALITICA").modal({backdrop:'static',keyboard:false}).modal("show");
                                                    } else {
                                                        jError("Session ha caducado","Clinica Libre");
                                                    } 
                                                },  
   });
   return true;
}

function js_informacion_administrativo(id_anatomia){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/gestion_perfil_administrativo",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        console.log("load ssan_libro_etapaanalitica/gestion_perfil_administrativo");
                                                        $('#html_star_sala_proceso').html('');
                                                        $('#loadFade').modal('hide'); 
                                                    },
        data 		:                           { 
                                                        id_anatomia     :   id_anatomia,
                                                        get_sala        :   $("#get_sala").val(),
                                                    },
        error		:   function(errro)         { 
                                                        $('#html_star_sala_proceso').html('');
                                                        $('#loadFade').modal('hide'); 
                                                        console.log("errro              ->",errro);
                                                        console.log("errro.responseText ->",errro.responseText);
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    },
        success		:   function(aData)         { 
                                                        
                                                        console.log("aData  ->  ",aData);
                                                        $('#loadFade').modal('hide');
                                                        if(aData.status_session){
                                                            $("#btn_perfil_administrativo").attr('onclick','js_data_administrativo('+id_anatomia+')');
                                                            $("#html_perfil_administrativo").html(aData.out_html);
                                                            $("#modal_perfil_administrativo").modal({backdrop:'static',keyboard:false}).modal("show");
                                                        } else {
                                                            jError("Session ha caducado","Clinica Libre");
                                                        }
                                                    }, 
   });
}


function js_data_administrativo(id_anatomia){
    var vacio_error                 =   [];
        vacio_error                 =   js_gestion_panel_administrativo();
        console.log("vacio_error    -> ",vacio_error);
    if(vacio_error.length!=0){
        showNotification('top','left',vacio_error.join("<br>"),4,'fa fa-ban');
        return false;
    } else {
        var obj_rce_anatomia                    =   { 
            formulario_administrativo           :   [],
        }; 
        var data_main_administrativo            =   {
            ind_profesional_acargo              :   $("#ind_profesional_acargo").val(),
            ind_profesional_acargo_citologico   :   $("#ind_profesional_acargo_citologico").val(),
            num_beneficiarios                   :   $("#n_beneficiarios").val(),
            ind_mes_critico                     :   $("#ind_mes_critico").val(),
            date_impresion_informe              :   $("#date_impresion_informe").val(),
            date_hora_fecha_entrga_informe      :   $("#date_fecha_entrga_informe").val()+" "+$("#hrs_entrega_informe").val(),
            ind_profesional_entrega_informe     :   $("#ind_profesional_entrega_informe").val(), 
            ind_profesional_recibe_informe      :   $("#ind_profesional_recibe_informe").val(),
            n_notificacion                      :   $("#n_notificacion").val(),
            date_revision_informe               :   $("#date_revision_informe").val(),  
            date_revision_bd                    :   $("#date_revision_bd").val(),  
            date_chequeo_some                   :   $("#date_chequeo_some").val(),
            date_archivada_en_ficha             :   $("#date_archivada_en_ficha").val(), 
        };
        obj_rce_anatomia.formulario_administrativo.push(data_main_administrativo);
        console.table("obj_rce_anatomia                 ->  ",obj_rce_anatomia);
        jPrompt('Con esta acci&oacute;n agregara informaci&oacute;n a solicitud histopatol&oacute;gico &iquest;desea continuar?','','Confirmaci\u00f3n',function (r) {
            console.error("password                    ->   ",r);
            if(r){ 
                $.ajax({ 
                    type                                :   "POST",
                    url                                 :   "ssan_libro_etapaanalitica/guardado_perfil_administrativo",
                    dataType                            :   "json",
                    beforeSend                          :   function(xhr)   {   console.log(xhr);   },
                    data                                :   { 
                                                                contrasena      :   r,
                                                                id_anatomia     :   id_anatomia,
                                                                accesdata       :   obj_rce_anatomia,
                                                            },
                    error                               :   function(errro) { 
                                                                                console.error("errro                  ->",errro); 
                                                                                console.error("error.responseText     ->",errro.responseText); 
                                                                                jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                                            },
                    success                             :   function(aData) { 
                                                                                console.table("out      ->  ",aData);
                                                                                if(aData.status_firma){
                                                                                    jAlert("Se grab&oacute; informaci&oacute;n con &eacute;xito","Clinica Libre");
                                                                                    
                                                                                    
                                                                                    localStorage.setItem("ind_tipo_mensaje",7);
                                                                                    localStorage.setItem("ind_estapa_analitica",0);
                                                                                    localStorage.setItem("num_fichae",null);
                                                                                    localStorage.setItem("id_anatomia",id_anatomia);
                                                                                    localStorage.setItem("txt_name_biopsia",get_numeros_asociados(id_anatomia).join(","));
                                                                                    localStorage.setItem("span_tipo_busqueda",$("#span_tipo_busqueda").html());
                                                                                    $("#load_anuncios_anatomia_patologica").submit();
                                                                                    
                                                                                    $("#modal_perfil_administrativo").modal("hide");
                                                                                    update_etapaanalitica();
                                                                                    
                                                                                } else {
                                                                                    jError("Error en la firma simple","Clinica Libre");
                                                                                }
                                                                            }, 
                });
            } else {
                console.log("---------------------------------------");
                console.log("   -> DIJO NO FIRMA SIMPLE <-          ");
                console.log("---------------------------------------");
            }
        });
    }
}

function js_gestion_panel_administrativo(){
    var vacio_error                             =   [];
    console.log("--------------- gestion perfil administrativo --------------------------------");
    $("#ind_profesional_acargo").val()          ==  ''  ?   vacio_error.push('Indicar quien realizo informe'):'';
    $("#n_beneficiarios").val()                 ==  ''  ?   vacio_error.push('Indicar N&deg; de beneficiarios'):'';
    $("#ind_mes_critico").val()                 ==  ''  ?   vacio_error.push('Indicar si es mes critico'):'';
    $("#date_impresion_informe").val()          ==  ''  ?   vacio_error.push('Indicar fecha de impresion de informe'):'';
    $("#num_plazo_biopsias").val()              ==  ''  ?   vacio_error.push('Indicar plazo de biopsia'):'';
    $("#date_fecha_entrga_informe").val()       ==  ''  ?   vacio_error.push('Indicar fecha entega de informe'):'';
    $("#hrs_entrega_informe").val()             ==  ''  ?   vacio_error.push('Indicar hora entega de informe'):'';
    $("#ind_profesional_entrega_informe").val() ==  ''  ?   vacio_error.push('Informar funcionario que entrega informe'):'';
    $("#ind_profesional_recibe_informe").val()  ==  ''  ?   vacio_error.push('Informar funcionario quien recibe informe'):'';
    return vacio_error;
}

function deshabilita_input_cancer(){
    var data_formc_cancer           =  $('#form_cancer_input').serializeArray();
    //$("#num_entrega_cancercritico").selectpicker().attr('disabled');
    //console.log("data_formc_cancer->",data_formc_cancer,"<-");
    $.each(data_formc_cancer, function(i,field){    
        $("#"+field.name).val('').prop("disabled",true);  
    });
}

function star_data_cancer(){
    //num_entrega_cancercritico
    $("#calendar_termino_cancer,#calendar_inicio_cancer").datetimepicker({
        format              :   'DD-MM-YYYY',
        //minDate           :   new Date(new Date().setDate((new Date().getDate())-(30))),
        maxDate             :   new Date(),
        locale              :   'es-us',
        icons               :   {
                                    time        :   "fa fa-clock-o"         ,
                                    date        :   "fa fa-calendar"        ,
                                    up          :   "fa fa-chevron-up"      ,
                                    down        :   "fa fa-chevron-down"    ,
                                    previous    :   "fa fa-chevron-left"    ,
                                    next        :   "fa fa-chevron-right"   ,
                                    today       :   "fa fa-screenshot"      ,
                                    clear       :   "fa fa-trash"           ,
                                    close       :   "fa fa-remove"          ,
                                }
    }).on('dp.change',function(e){  console.log("e  -> ",e);  });
}

function js_gestion_cancer(id_anatomia){
    var opcion          =   $(".panel_header_cancer").data().ind_caner;
    //console.log("opcion ->  ",opcion);
    
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/gestion_cancer_panel",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        console.log("ssan_libro_etapaanalitica/formulario_main_analitico");
                                                        $('#HTML_INFORMACION_HISTORIAL').html('');
                                                        $('#loadFade').modal('show'); 
                                                    },
        data 		:                           { 
                                                        id_anatomia   :   id_anatomia,
                                                        opcion        :   opcion,
                                                    },
        error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error.responseText->",errro.responseText); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        $('#HTML_FORMULARIO_ANALITICA').html('');
                                                        $('#loadFade').modal('hide'); 
                                                    },
        success		:   function(aData)         { 
                                                        //console.log("gestion_cancer_panel -> gestion_cancer_panel opcion->",opcion,"<-  ");
                                                        $('#loadFade').modal('hide'); 
                                                        if(aData.status){
                                                            if (opcion == 1){
                                                                //input
                                                                console.log("   ->  habilitado  <-  ");
                                                                $(".panel_header_cancer").data().ind_caner                      =   0;
                                                                document.getElementById('num_entrega_cancercritico').disabled   =   true;
                                                                document.getElementById('seg_horas_cancer').disabled            =   true;
                                                                document.getElementById('seg_minutos_cancer').disabled          =   true;
                                                                document.getElementById('seg_segundos_cancer').disabled         =   true;
                                                                document.getElementById('date_inicio_cancer').disabled          =   true;
                                                                document.getElementById('hrs_inicio_cancer').disabled           =   true;
                                                                document.getElementById('date_termino_cancer').disabled         =   true;
                                                                document.getElementById('hrs_termino_cancer').disabled          =   true;
                                                                $(".btn_cancer_habilita").hide();
                                                                $(".btn_cancer_desahabilita").show();
                                                                jAlert("Se ha <b>deshabilitado</b> registro de c&aacute;ncer","Clinica Libre");
                                                            } else {
                                                                //input
                                                                console.log("   ->  desabilitado    <-  ");
                                                                $(".panel_header_cancer").data().ind_caner                      =   1;
                                                                document.getElementById('num_entrega_cancercritico').disabled   =   false;
                                                                document.getElementById('seg_horas_cancer').disabled            =   false;
                                                                document.getElementById('seg_minutos_cancer').disabled          =   false;
                                                                document.getElementById('seg_segundos_cancer').disabled         =   false;
                                                                document.getElementById('date_inicio_cancer').disabled          =   false;
                                                                document.getElementById('hrs_inicio_cancer').disabled           =   false;
                                                                document.getElementById('date_termino_cancer').disabled         =   false;
                                                                document.getElementById('hrs_termino_cancer').disabled          =   false;
                                                                $(".btn_cancer_habilita").show();
                                                                $(".btn_cancer_desahabilita").hide();
                                                                jAlert("Se ha <b>habilitado</b> registro de c&aacute;ncer","Clinica Libre");
                                                            }
                                                        } else {
                                                            jError("Sesion ha caducado","Clinica Libre");
                                                        } 
                                                    }, 
   });
}

function js_guardado_previo(id_anatomia){
    js_gestion_patologo(1,id_anatomia);
}

function js_finaliza_rce(id_anatomia){
    var vacio_error                             =   [];
    //console.log("-----REGISTRO DE CANCER----------------------------------------");
    //console.log("       ",$(".panel_header_cancer").data('ind_caner'),"         ");
    //console.log("---------------------------------------------------------------");
    if($(".panel_header_cancer").data('ind_caner')  ==  1){
        $("#num_plazo_biopsias").val()          ==  ''?vacio_error.push(' - D&iacute;as entrega de biopsia vac&iacute;o'):'';
        $("#seg_horas_cancer").val()            ==  ''?vacio_error.push(' - Horas entrega de biopsia vac&iacute;o'):'';
        $("#seg_minutos_cancer").val()          ==  ''?vacio_error.push(' - Minutos entrega de biopsia vac&iacute;o'):'';
        $("#seg_segundos_cancer").val()         ==  ''?vacio_error.push(' - Segundos entrega de biopsia vac&iacute;o'):'';
        $("#date_inicio_cancer").val()          ==  ''?vacio_error.push(' - Fecha Inicio clinico cancer vac&iacute;o'):'';
        $("#hrs_inicio_cancer").val()           ==  ''?vacio_error.push(' - Hora Inicio clinico cancer vac&iacute;o'):'';
        $("#date_termino_cancer").val()         ==  ''?vacio_error.push(' - Fecha Final clinico cancer vac&iacute;o'):'';
        $("#hrs_termino_cancer").val()          ==  ''?vacio_error.push(' - Hora Final clinico cancer vac&iacute;o'):'';
    }
    console.log("--------------- OBSERVACIONES ---------------------------------");
    var IND_TIPO_BIOPSIA                        =   $("#IND_TIPO_BIOPSIA").val();
    console.log("IND_TIPO_BIOPSIA               ->  ",IND_TIPO_BIOPSIA);
    if (IND_TIPO_BIOPSIA == 4 || IND_TIPO_BIOPSIA == 5){
        $("#txt_diagnostico_citologico").val()  ==  ''?vacio_error.push(' - Sin Diagn&oacute;stico citol&oacute;gico'):'';
    }
    if (IND_TIPO_BIOPSIA == 2 || IND_TIPO_BIOPSIA == 3 || IND_TIPO_BIOPSIA == 4 ){
        $("#txt_diagnostico_ap").val()          ==  ''?vacio_error.push(' - Sin Diagn&oacute;stico histol&oacute;gico'):'';
    }
    console.log("--------------- PRESTACIONES  ---------------------------------");
    $("#select_lista_prestaciones").val()       ==  null?vacio_error.push(' - Sin prestaciones cargadas'):'';
    $("#select_lista_cod_main").val()           ==  null?vacio_error.push(' - Sin prestaciones fonasa cargadas'):'';
    $("#select_lista_organos").val()            ==  null?vacio_error.push(' - Sin selecci&oacute;n de tipo de muestras cargadas'):'';
    $("#select_lista_patologia").val()          ==  null?vacio_error.push(' - Sin patolog&iacute;a cargadas'):'';
    console.log("--------------- ADMINISTRATIVO --------------------------------");
    $("#ind_profesional_acargo").val()          ==  ''?vacio_error.push(' - Informar quien realiza informe'):'';
    $("#n_beneficiarios").val()                 ==  ''?vacio_error.push(' - Indicar N&deg; de beneficiarios'):'';
    $("#ind_mes_critico").val()                 ==  ''?vacio_error.push(' - Indicar si es mes critico'):'';
    $("#date_impresion_informe").val()          ==  ''?vacio_error.push(' - Indicar fecha de impresion de informe'):'';
    $("#num_plazo_biopsias").val()              ==  ''?vacio_error.push(' - Indicar plazo de biopsia'):'';
    $("#date_fecha_entrga_informe").val()       ==  ''?vacio_error.push(' - Indicar fecha entega de informe'):'';
    $("#hrs_entrega_informe").val()             ==  ''?vacio_error.push(' - Indicar hora entega de informe'):'';
    $("#ind_profesional_entrega_informe").val() ==  ''?vacio_error.push(' - Informar funcionario que entrega informe'):'';
    $("#ind_profesional_recibe_informe").val()  ==  ''?vacio_error.push(' - Informar funcionario quien recibe informe'):'';
    console.log("-------- DESCRIPCION MICROSCOPICA -----------------------------");
    $('.value_microscopia').each(function(){ 
        //console.log("DESCRIPCION MICROSCOPICA  -> ",this.id);
        var txt                                 =   $("#"+this.id).val();
        var num_muestas                         =   this.id.split("_");  
        var b_sin_descripcion                   =   !$('#ind_sin_descripcion_'+num_muestas[2]).is(':checked');
        console.log("Muestras -> ",num_muestas[2],' -> ',b_sin_descripcion);
        txt===''&&b_sin_descripcion?vacio_error.push(' - Indicar observaci&oacute;n microsc&oacute;pica N&deg;'+num_muestas[2]):'';
    }); 
    //console.log("-------- TECNOLOGO MEDICO -------------------------------------");
    /*
    $("#date_fecha_macro").val()                ==  ''?vacio_error.push(' - Indicar fecha de macro'):'';
    $("#date_fecha_corte").val()                ==  ''?vacio_error.push(' - Indicar fecha de corte'):'';
    $("#ind_color_taco").val()                  ==  ''?vacio_error.push(' - Indicar color de taco'):'';
    $("#ind_color_taco").val()                  ==  ''?vacio_error.push(' - Indicar estado logia'):'';
    $("#date_interconsulta_ap").val()           ==  ''?vacio_error.push(' - Indicar fecha de interconsulta'):'';
    $("#num_copia_inerconsulta").val()          ==  ''?vacio_error.push(' - Indicar copia interconsulta'):'';
    $("#num_fragmentos").val()                  ==  ''?vacio_error.push(' - Indicar N&deg; de fragmentos'):'';
    $("#num_tacos_cortados").val()              ==  ''?vacio_error.push(' - Indicar N&deg; tacos cortados'):'';
    $("#num_copia_inerconsulta").val()          ==  ''?vacio_error.push(' - Indicar N&deg; extendidos'):'';
    */
    console.table(vacio_error);
    //return false;
    if(vacio_error.length!=0){
        showNotification('top','left',vacio_error.join("<br>"),4,'fa fa-ban');
        return false;
    } else {
        js_gestion_patologo(2,id_anatomia);
    }
}
    
function js_gestion_patologo(id_salida,id_anatomia){
    
    console.log("---------------------------------------------------");
    console.log("id_salida                  ->",id_salida,"     <-  ");
    console.log("id_anatomia                ->",id_anatomia,"   <-  ");
    console.log("---------------------------------------------------");
    
    //return false;
    var obj_rce_anatomia                    =   { 
        formulario_main                     :   [],
        formulario_administrativo           :   [],
        formulario_tecnologo_med            :   [],
        arr_prestaciones                    :   [],
        arr_organos                         :   [],
        arr_patologias                      :   [],
        arr_data_img                        :   [],
        arr_info_microscopia                :   [],
        arr_fonasa                          :   [],
        arr_fonasa_procedimiento            :   [],
    };
    var errores                             =   [];
    var data_form_registro                  =   [];
    $('.input_error').each(function(){ $("#"+this.id).removeClass('input_error'); });
    if(($("#date_fecha_entrga_informe").val()==''&&$("#hrs_entrega_informe").val()!='')||($("#date_fecha_entrga_informe").val()!=''&&$("#hrs_entrega_informe").val()=='')){
        errores.push('Indicar fecha de entrega de informe');
        $("#date_fecha_entrga_informe,#hrs_entrega_informe").addClass('input_error');
    }
    
    //REGISTRO DE CANCER
    var boolean_cancer_inicio               =  $("#date_inicio_cancer").val()==''||$("#hrs_inicio_cancer").val()==''?false:true;
    var boolean_termino_cancer              =  $("#date_termino_cancer").val()==''||$("#hrs_termino_cancer").val()==''?false:true;
    if(($("#date_inicio_cancer").val()==''&&$("#hrs_inicio_cancer").val()!='')||($("#date_inicio_cancer").val()!=''&&$("#hrs_inicio_cancer").val()=='')){
        errores.push('Indicar fecha inicio cancer');
        $("#date_inicio_cancer,#hrs_inicio_cancer").addClass('input_error');
    }
    
    if(($("#date_termino_cancer").val()==''&&$("#hrs_termino_cancer").val()!='')||($("#date_termino_cancer").val()!=''&&$("#hrs_termino_cancer").val()=='')){
        errores.push('Indicar fecha termino cancer');
        $("#date_termino_cancer,#hrs_termino_cancer").addClass('input_error');
    }
    
    if(boolean_cancer_inicio&&boolean_termino_cancer){
        var from1                           =   $("#date_inicio_cancer").val().split("-");
        var to2                             =   $("#date_termino_cancer").val().split("-");
        var primera                         =   Date.parse(from1[1]+"/"+from1[0]+"/"+from1[2]+" "+$("#hrs_inicio_cancer").val()+":00"); 
        var segunda                         =   Date.parse(to2[1]+"/"+to2[0]+"/"+to2[2]+" "+$("#hrs_termino_cancer").val()+":00"); 
        if(primera == segunda)              {
            errores.push('Fechas de inicio y fin en registro de c&aacute;ncer son iguales ');
            $("#date_inicio_cancer,#hrs_inicio_cancer,#date_termino_cancer,#hrs_termino_cancer").addClass('input_error');
        }
        if(primera>segunda)                 {
            errores.push('Fecha final es superior a la fecha de inicio (registro cancer)');
            $("#date_inicio_cancer,#hrs_inicio_cancer,#date_termino_cancer,#hrs_termino_cancer").addClass('input_error');
        }
    }
    
    var boolean_horas_cancer                =   $("#seg_horas_cancer").val()        ==  ''  ?   false   :   true;
    var boolean_minutos_cancer              =   $("#seg_minutos_cancer").val()      ==  ''  ?   false   :   true;
    var boolean_segundos_cancer             =   $("#seg_segundos_cancer").val()     ==  ''  ?   false   :   true;
    if(boolean_horas_cancer&&boolean_minutos_cancer&&boolean_segundos_cancer){
        var seg_horas_cancer                =   $("#seg_horas_cancer").val();
        var seg_minutos_cancer              =   $("#seg_minutos_cancer").val();
        var seg_segundos_cancer             =   $("#seg_segundos_cancer").val();
        var seg_resultado_cancer            =   parseInt(seg_horas_cancer)+parseInt(seg_minutos_cancer)+parseInt(seg_segundos_cancer);
        data_form_registro.push({ind_asignadas96horas:seg_resultado_cancer});
    } else {
        //$("#seg_horas_cancer,#seg_minutos_cancer,#seg_segundos_cancer").addClass('input_error');
    }
    
    if(errores.length>0)                    {   jError(errores.join('<br>'),'Clinica Libre');    return  false;      }
    data_form_registro.push({
        /* CAMBIO DE DISTRIBUCION DE PANELES */
        /*
        ind_profesional_acargo              :   $("#ind_profesional_acargo").val(),
        num_beneficiarios                   :   $("#n_beneficiarios").val(),
        ind_mes_critico                     :   $("#ind_mes_critico").val(),
        date_impresion_informe              :   $("#date_impresion_informe").val(),
        date_hora_fecha_entrga_informe      :   $("#date_fecha_entrga_informe").val()+" "+$("#hrs_entrega_informe").val(),
        ind_profesional_entrega_informe     :   $("#ind_profesional_entrega_informe").val(), 
        ind_profesional_recibe_informe      :   $("#ind_profesional_recibe_informe").val(),
        */
        num_plazo_biopsias                  :   $("#num_plazo_biopsias").val(), 
        num_entrega_cancercritico           :   $("#num_entrega_cancercritico").val(), 
        ind_asignadas96horas                :   $("#ind_asignadas96horas").val(), 
        date_hora_fecha_inicio_cancer       :   boolean_cancer_inicio?$("#date_inicio_cancer").val()+" "+$("#hrs_inicio_cancer").val():'',
        date_hora_fecha_final_cancer        :   boolean_termino_cancer?$("#date_termino_cancer").val()+" "+$("#hrs_termino_cancer").val():'',
        txt_diagnostico_ap                  :   $("#txt_diagnostico_ap").val(),
        ind_cancer                          :   $("#ind_confirma_cancer").val(),
        num_ind_cancer                      :   $("#n_notificacion_cancer").val(),
        ind_conf_informepdf                 :   $("#ind_conf_informepdf").val(), 
        txt_macroscopia                     :   $("#txt_macroscopia").val(),
        txt_citologico                      :   $("#txt_citologico").val(),
        txt_diagnostico_citologico          :   $("#txt_diagnostico_citologico").val(),
        /*
        date_fecha_macro                    :   $("#date_fecha_macro").val(),   
        date_fecha_corte                    :   $("#date_fecha_corte").val(), 
        ind_color_taco                      :   $("#ind_color_taco").val(),
        ind_estado_olga                     :   $("#ind_estado_olga").val(), 
        date_interconsulta_ap               :   $("#date_interconsulta_ap").val(), 
        num_copia_inerconsulta              :   $("#num_copia_inerconsulta").val(),  
        num_fragmentos                      :   $("#num_fragmentos").val(), 
        num_tacos_cortados                  :   $("#num_tacos_cortados").val(), 
        num_extendidos                      :   $("#num_extendidos").val(), 
        num_azul_alcian_seriada             :   $("#num_azul_alcian_seriada").val(),
        num_pas_seriada                     :   $("#num_pas_seriada").val() ,
        num_diff_seriada                    :   $("#num_diff_seriada").val(),
        num_he_seriada                      :   $("#num_he_seriada").val(),
        num_all_laminas_seriadas            :   $("#num_all_laminas_seriadas").val(),
        num_he_rapida                       :   $("#num_he_rapida").val(),
        */
    });
    obj_rce_anatomia.formulario_main.push(data_form_registro);
    //**************************************************************************
    var data_main_administrativo            =   {
        ind_profesional_acargo              :   $("#ind_profesional_acargo").val(),
        ind_profesional_acargo_citologico   :   $("#ind_profesional_acargo_citologico").val(),
        num_beneficiarios                   :   $("#n_beneficiarios").val(),
        ind_mes_critico                     :   $("#ind_mes_critico").val(),
        date_impresion_informe              :   $("#date_impresion_informe").val(),
        date_hora_fecha_entrga_informe      :   $("#date_fecha_entrga_informe").val()+" "+$("#hrs_entrega_informe").val(),
        ind_profesional_entrega_informe     :   $("#ind_profesional_entrega_informe").val(), 
        ind_profesional_recibe_informe      :   $("#ind_profesional_recibe_informe").val(),
        n_notificacion                      :   $("#n_notificacion").val(),
        date_revision_informe               :   $("#date_revision_informe").val(),  
        date_revision_bd                    :   $("#date_revision_bd").val(),  
        date_chequeo_some                   :   $("#date_chequeo_some").val(),
        date_archivada_en_ficha             :   $("#date_archivada_en_ficha").val(), 
    };
    obj_rce_anatomia.formulario_administrativo.push(data_main_administrativo);
    //**************************************************************************
    var data_main_tecnologo_medico          =   {
        date_fecha_macro                    :   $("#date_fecha_macro").val(),   
        date_fecha_corte                    :   $("#date_fecha_corte").val(), 
        ind_color_taco                      :   $("#ind_color_taco").val(),
        ind_estado_olga                     :   $("#ind_estado_olga").val(), 
        date_interconsulta_ap               :   $("#date_interconsulta_ap").val(), 
        num_copia_inerconsulta              :   $("#num_copia_inerconsulta").val(),  
        num_fragmentos                      :   $("#num_fragmentos").val(), 
        num_tacos_cortados                  :   $("#num_tacos_cortados").val(), 
        num_extendidos                      :   $("#num_extendidos").val(), 
        num_azul_alcian_seriada             :   $("#num_azul_alcian_seriada").val(),
        num_pas_seriada                     :   $("#num_pas_seriada").val() ,
        num_diff_seriada                    :   $("#num_diff_seriada").val(),
        num_he_seriada                      :   $("#num_he_seriada").val(),
        num_all_laminas_seriadas            :   $("#num_all_laminas_seriadas").val(),
        num_he_rapida                       :   $("#num_he_rapida").val(),
     };
    obj_rce_anatomia.formulario_tecnologo_med.push(data_main_tecnologo_medico);
    var lista_observaciones_img             =   [];
    $('.lista_imagenes').each(function(){  
        console.log("->",this.id);
        var txt                             =   $("#texto_img_"+this.id).val();
        lista_observaciones_img.push({'id':this.id,'txt':txt});
    });
    if(lista_observaciones_img.length>0){
        obj_rce_anatomia.arr_data_img.push(lista_observaciones_img);
    }
    //console.log("lista_observaciones_img    ->",obj_rce_anatomia);
    //return false;
    //**************************************************************************
    var arr_prestaciones                    =   $("#select_lista_prestaciones").val();
    if(arr_prestaciones!=null){
        obj_rce_anatomia.arr_prestaciones.push(arr_prestaciones);
    }
    var arr_fonasa_mai                      =   $("#select_lista_cod_main").val();
    if(arr_fonasa_mai!=null){
        obj_rce_anatomia.arr_fonasa.push(arr_fonasa_mai);
    }
    var arr_organos                         =   $("#select_lista_organos").val();
    if(arr_organos!=null){
        obj_rce_anatomia.arr_organos.push(arr_organos);
    }
    var arr_patologias                      =   $("#select_lista_patologia").val();
    if(arr_patologias!=null){
        obj_rce_anatomia.arr_patologias.push(arr_patologias);
    }
    //descripcion de muestras
    $('.value_microscopia').each(function(){
        var txt                             =   $("#"+this.id).val();
        var num                             =   $("#"+this.id).data('muestra');
        console.log("---value_microscopia-----------");
        console.log("->",txt);
        console.log("->",num);
        obj_rce_anatomia.arr_info_microscopia.push({'txt':txt,'num':num});
        //txt===''?'':obj_rce_anatomia.arr_info_microscopia.push({'txt':txt,'num':num});
    });
    
    console.log("---------------------------------------------------------------------------------------");
    console.log("   add txt_macroscopia     ");
    console.log("---------------------------------------------------------------------------------------");
    console.log("   id_salida   ->  ",id_salida ," || obj_rce_anatomia ||    ->",obj_rce_anatomia,"<----");
    console.log("---------------------------------------------------------------------------------------");
    
    //return false;
    if(id_salida == 1){
        $.ajax({ 
            type        :   "POST",
            url         :   "ssan_libro_etapaanalitica/guardado_previo_anatomiapatologica",
            dataType    :   "json",
            beforeSend  :   function(xhr)       {    
                                                    $('#loadFade').modal('show');    
                                                },
            data        :                       { 
                                                    id_anatomia     :   id_anatomia,
                                                    accesdata       :   obj_rce_anatomia,
                                                    id_salida       :   id_salida,
                                                },
            error       :   function(errro)     { 
                                                    console.log(" quisas->",errro," error->",errro.responseText); 
                                                    jError("Error General, Consulte Al Administrador","Clinica Libre");
                                                    $('#loadFade').modal('hide'); 
                                                },
            success                             :   function(aData)     { 
                                                        console.log("guardado_previo_anatomiapatologica ->  ",aData);
                                                        $('#loadFade').modal('hide'); 
                                                        jAlert(id_salida==1?"Guardado previo grabado con &eacute;xito":"Se ha finalizado reporte","Clinica Libre");
                                                        console.log("id_salida  ->  ",id_salida);
                                                        if(id_salida==2){
                                                            update_etapaanalitica();
                                                            $("#MODAL_FORMULARIO_ANALITICA").modal("hide");
                                                        }
                                                    }, 
        });
    } else {
        jPrompt('Con esta acci&oacute;n se proceder&aacute; a cerrar  la solicitud de anatomia patologica .<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
            if(r){
               $.ajax({ 
                    type                                :   "POST",
                    url                                 :   "ssan_libro_etapaanalitica/finaliza_reporte_anatomia_patologica",
                    dataType                            :   "json",
                    beforeSend                          :   function(xhr)       {    $('#loadFade').modal('show');    },
                    data                                :   { 
                                                                id_anatomia     :   id_anatomia,
                                                                accesdata       :   obj_rce_anatomia,
                                                                id_salida       :   id_salida,
                                                                contrasena      :   r,
                                                            },
                    error                               :   function(errro) { 
                                                                                console.log(" quisas->",errro," error->",errro.responseText); 
                                                                                jError("Error General, Consulte Al Administrador","Clinica Libre");
                                                                                $('#loadFade').modal('hide'); 
                                                                            },
                    success                             :   function(aData) {   
                                                                                $('#loadFade').modal('hide'); 
                                                                                if(aData.status_pass){
                                                                                    console.log("guardado_previo_anatomiapatologica ->  ",aData);
                                                                                    //jAlert(id_salida==1?"Guardado previo grabado con &eacute;xito":"Se ha finalizado reporte 2 ","Clinica Libre");
                                                                                    if(id_salida==2){
                                                                                        console.log("----------------------------------");
                                                                                        console.log("ws final");
                                                                                        localStorage.setItem("ind_tipo_mensaje",6);
                                                                                        localStorage.setItem("ind_estapa_analitica",0);
                                                                                        localStorage.setItem("num_fichae",null);
                                                                                        localStorage.setItem("id_anatomia",id_anatomia);
                                                                                        localStorage.setItem("txt_name_biopsia",get_numeros_asociados(id_anatomia).join(","));
                                                                                        localStorage.setItem("span_tipo_busqueda",$("#span_tipo_busqueda").html());
                                                                                        $("#load_anuncios_anatomia_patologica").submit();
                                                                                        update_etapaanalitica();
                                                                                        $("#MODAL_FORMULARIO_ANALITICA").modal("hide");
                                                                                    } 
                                                                                    jConfirm('Se ha finalizado reporte - &iquest;desea Impimir informe?','Clinica Libre - ANATOM&Iacute;A PATOL&Oacute;GICA',function(r) {
                                                                                        if(r){
                                                                                            js_pdf_microscopica(id_anatomia);
                                                                                        } else {
                                                                                            //console.log("-> DIJO NO PDF <-");
                                                                                        }
                                                                                    });
                                                                                } else {
                                                                                    jError("Error Firma simple","Clinica Libre");
                                                                                }
                                                                            }, 
                });
            } else {
                jError("Firma simple vac&iacute;a","Error - Clinica Libre");
                return false;
            }
        });
    }
}

function js_viwes_popover(id,name){
    //console.log("btn_microfono ->");
    $("#btn_microfono").popover({
        html            :   true,
        container       :   'body',
      //content         :   " -> "+id,
        title           :   '<b style="font-size:12px;">escuchando</b>&nbsp;<button type="button" id="close" class="close" onclick="$(&quot;.popover&quot;).popover(&quot;hide&quot;);">&times;</button>',
        trigger         :   'manual',   //hover //focus //click //manual
    }).popover('show');
}

function star_collapse(){
    /*
    console.log("---------------------------------------");
    console.log("           star_collapse               ");
    console.log("---------------------------------------");
    */
    $('#collapse_main_rce').collapse({toggle:false});
    $('.no_collapsable').on('click', function (e) {
        e.stopPropagation();
    });
    /*
    $('#collapse_main_rce').on('show.bs.collapse',function(e){
        console.log("do show                                    ->",    e);
        console.log("e.target           newly activated tab     ->",    e.target);
        console.log("e.relatedTarget    previous active tab     ->",    e.relatedTarget);
    });
    $('#collapse_main_rce').on('hidden.bs.collapse',function(e){
        console.log("do hidden                                  ->",    e);
        console.log("e.target           newly activated tab     ->",    e.target);
        console.log("e.relatedTarget    previous active tab     ->",    e.relatedTarget);
    });
    */
    /*
    $("#collapse_main_rce").hover(function(_this) {
        console.log("_this          ->  ",_this);
        console.log("this           ->  ",this); 
    });
    */
}

function js_termino_microscopia(){
    /*
    accordion_body_microscopia
        icon_estado_microscopia
        viwes_estado_microscopia
    */
}

function get_excel(){
    //var ID_BD       =   121321;
    //*********************************************************
    //**************** RUTA DEL CONTROLLER ********************
    //*********************************************************
    var date_inicio         =   $('#fecha_out').data().date;
    var date_final          =   $('#fecha_out2').data().date;
    console.log("date_inicio    ->",date_inicio);
    console.log("date_final     ->",date_final);
    //return false;
    var link                =   "https://www.esissan.cl/ssan_libro_etapaanalitica/load_excel_final?date_inicio="+date_inicio+"&date_final="+date_final;
    window.location.href    =   link;
}

function consulta(){
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/consulta2",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        $('#HTML_INFORMACION_HISTORIAL').html('');
                                                    },
        data 		:                           { 
                                                        fecha_1     :   $('#fecha_out').data().date,
                                                        fecha_2     :   $('#fecha_out2').data().date,
                                                    },
        error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        $('#HTML_FORMULARIO_ANALITICA').html('');
                                                    },
        success		:   function(aData)         { 
                
                                                        /*
                                                        console.log("consulta  familia -> ",aData);
                                                        $("#respuesta_familia").html(aData.html);
                                                        */
                                                        
                                                    }, 
   });
}

function js_select_presta(){
    var arr_prestaciones            =   $("#select_lista_prestaciones").val();
    if(arr_prestaciones             !=  null){
        $("#ul_sin_resultados").hide();
        var html        =   '';
        arr_prestaciones.forEach(function(valor,indice,array) {
            var txt     =   $("#select_lista_prestaciones > option[value='"+valor+"']").data().subtext;
            html        +=  '<li class="list-group-item lista_prestaciones_'+valor+'" style="padding: 0px;" id="li_'+valor+'">'+
                                '<div class="panel_li_prestaciones">'+
                                    '<div class="panel_li_prestaciones1" style="text-align:left;">'+
                                        '<b style="margin-left: 6px;">'+valor+'</b>'+
                                    '</div>'+
                                    '<div class="panel_li_prestaciones2">'+
                                        txt+
                                    '</div>'+
                                    '<div class="panel_li_prestaciones5" style="text-align: right;">'+
                                        '<button id="'+valor+'" style="margin-right: 6px;" type="button" class="btn btn-xs btn-danger btn-fill" onclick="js_elimina_presta(this.id)">'+
                                            '<i class="fa fa-trash-o" aria-hidden="true"></i>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>'+
                            '</li>';
        });
        $("#ul_perstaciones").html(html);
    }  else {
        $("#ul_sin_resultados").show();
        $("#ul_perstaciones").html('');
    }
}

function js_elimina_presta(id){
    $("#li_"+id).remove();
    var arr_prestaciones            =   $("#select_lista_prestaciones").val();
    var indice                      =   arr_prestaciones.indexOf(id);
    arr_prestaciones.splice(indice,1);
    $("#select_lista_prestaciones").selectpicker('val',arr_prestaciones);
    js_select_presta();
}

function js_select_organos(){
    var arr_organos            =   $("#select_lista_organos").val();
    if(arr_organos             !=  null){
        $("#ul_sin_resultados_organos").hide();
        var html                =   '';
        arr_organos.forEach(function(valor,indice,array) {
            var arr_info        =   $("#select_lista_organos > option[value='"+valor+"']").data("prestacion");
            html                +=  '<li class="list-group-item lista_organos_'+valor+'" style="padding: 0px;" id="li_organos_'+valor+'">'+
                                        '<div class="panel_li_prestaciones">'+
                                            '<div class="panel_li_prestaciones1" style="text-align:left;">'+
                                                '<b style="margin-left: 6px;">'+arr_info.COD_ORGANO+'</b>'+
                                            '</div>'+
                                            '<div class="panel_li_prestaciones2">'+
                                                arr_info.TXT_NOMBRE_ORGANO+
                                            '</div>'+
                                            '<div class="panel_li_prestaciones5" style="text-align: right;">'+
                                                '<button id="'+valor+'" style="margin-right:6px;" type="button" class="btn btn-xs btn-danger btn-fill" onclick="js_elimina_organos(this.id)">'+
                                                    '<i class="fa fa-trash-o" aria-hidden="true"></i>'+
                                                '</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</li>';
        });
        $("#ul_organos").html(html);
    }  else {
        $("#ul_sin_resultados_organos").show();
        $("#ul_organos").html('');
    }
}

function js_elimina_organos(id){
    $("#li_organos_"+id).remove();
    var arr_organos            =   $("#select_lista_organos").val();
    var indice                 =   arr_organos.indexOf(id);
    arr_organos.splice(indice,1);
    $("#select_lista_organos").selectpicker('val',arr_organos);
    js_select_organos();
}

function js_select_patologias(){
    var arr_patologias         =   $("#select_lista_patologia").val();
    if(arr_patologias          !=  null){
        $("#ul_sin_resultados_patologia").hide();
        var html                =   '';
        arr_patologias.forEach(function(valor,indice,array) {
            var arr_info        =   $("#select_lista_patologia > option[value='"+valor+"']").data("prestacion");
            html                +=  '<li class="list-group-item lista_organos_'+valor+'" style="padding: 0px;" id="li_patologia_'+valor+'">'+
                                        '<div class="panel_li_prestaciones">'+
                                            '<div class="panel_li_prestaciones1" style="text-align:left;">'+
                                                '<b style="margin-left: 6px;">'+arr_info.COD_PATOLOGIA+'</b>'+
                                            '</div>'+
                                            '<div class="panel_li_prestaciones2">'+
                                                arr_info.TXT_PATOLOGIA+
                                            '</div>'+
                                            '<div class="panel_li_prestaciones5" style="text-align: right;">'+
                                                '<button id="'+valor+'" style="margin-right:6px;" type="button" class="btn btn-xs btn-danger btn-fill" onclick="js_elimina_patologia(this.id)">'+
                                                    '<i class="fa fa-trash-o" aria-hidden="true"></i>'+
                                                '</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</li>';
        });
        $("#ul_patologias").html(html);
    }  else {
        $("#ul_sin_resultados_patologia").show();
        $("#ul_patologias").html('');
    }
}

function js_elimina_patologia(id){
    $("#li_patologia_"+id).remove();
    var arr_patologia          =   $("#select_lista_patologia").val();
    var indice                 =   arr_patologia.indexOf(id);
    arr_patologia.splice(indice,1);
    $("#select_lista_patologia").selectpicker('val',arr_patologia);
    js_select_patologias();
}

function js_select_lista_cod_main(){
    var arr_cod_main            =   $("#select_lista_cod_main").val();
    if(arr_cod_main             !=  null){
        $("#ul_sin_resultados_codigo_fonasa").hide();
        var html                =   '';
        arr_cod_main.forEach(function(valor,indice,array) {
            var arr_info        =   $("#select_lista_cod_main > option[value='"+valor+"']").data("prestacion");
            html                +=  '<li class="list-group-item lista_organos_'+valor+'" style="padding: 0px;" id="li_cod_fonasa_'+valor+'">'+
                                        '<div class="panel_li_prestaciones">'+
                                            '<div class="panel_li_prestaciones1" style="text-align:left;">'+
                                                '<b style="margin-left: 6px;">'+arr_info.COD_PRESTACION+'</b>'+
                                            '</div>'+
                                            '<div class="panel_li_prestaciones2">'+
                                                arr_info.NOM_PRESTACION+
                                            '</div>'+
                                            '<div class="panel_li_prestaciones5" style="text-align: right;">'+
                                                '<button id="'+valor+'" style="margin-right:6px;" type="button" class="btn btn-xs btn-danger btn-fill" onclick="js_elimina_cod_mai(this.id)">'+
                                                    '<i class="fa fa-trash-o" aria-hidden="true"></i>'+
                                                '</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</li>';
        });
        $("#ul_codificacion_mai").html(html);
    }  else {
        $("#ul_sin_resultados_codigo_fonasa").show();
        $("#ul_codificacion_mai").html('');
    }
}

function js_elimina_cod_mai(id){
    $("#li_cod_fonasa_"+id).remove();
    var arr_cod_fonasa         =   $("#select_lista_cod_main").val();
    var indice                 =   arr_cod_fonasa.indexOf(id);
    arr_cod_fonasa.splice(indice,1);
    $("#select_lista_cod_main").selectpicker('val',arr_cod_fonasa);
    js_select_lista_cod_main();
}

function js_select_mai_procedimiento(){
    var arr_cod_main            =   $("#select_lista_mai_procedimiento").val();
    if(arr_cod_main             !=  null){
        $("#ul_sin_resultados_mai_procedimiento").hide();
        var html                =   '';
        arr_cod_main.forEach(function(valor,indice,array) {
            var arr_info        =   $("#select_lista_mai_procedimiento > option[value='"+valor+"']").data("prestacion");
            html                +=  '<li class="list-group-item lista_organos_'+valor+'" style="padding: 0px;" id="li_mai_procedimiento_'+valor+'">'+
                                        '<div class="panel_li_prestaciones">'+
                                            '<div class="panel_li_prestaciones1" style="text-align:left;">'+
                                                '<b style="margin-left: 6px;">'+arr_info.COD_PRESTA+'</b>'+
                                            '</div>'+
                                            '<div class="panel_li_prestaciones2">'+
                                                arr_info.NOM_LARGOS+
                                            '</div>'+
                                            '<div class="panel_li_prestaciones5" style="text-align: right;">'+
                                                '<button id="'+valor+'" style="margin-right:6px;" type="button" class="btn btn-xs btn-danger btn-fill" onclick="js_elimina_mai_procedimiento(this.id)">'+
                                                    '<i class="fa fa-trash-o" aria-hidden="true"></i>'+
                                                '</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</li>';
        });
        $("#ul_codificacion_mai_procedimiento").html(html);
    }  else {
        $("#ul_sin_resultados_codigo_fonasa").show();
        $("#ul_codificacion_mai_procedimiento").html('');
    }
}

function js_elimina_mai_procedimiento(id){
    $("#li_mai_procedimiento_"+id).remove();
    var arr_cod_fonasa         =   $("#select_lista_mai_procedimiento").val();
    var indice                 =   arr_cod_fonasa.indexOf(id);
    arr_cod_fonasa.splice(indice,1);
    $("#select_lista_mai_procedimiento").selectpicker('val',arr_cod_fonasa);
    js_select_mai_procedimiento();
}

function ver_imagenes(id_solicitud){
    var visualiza                                       =   !$("#vista_"+id_solicitud).data("visualizaimg");
    if(visualiza){
        $(".grid_etapaanalitica").css('grid-template-columns','1fr 3fr 2fr');
        $(".grid_etapaanalitica_3").show();
        get_carrusel_img(id_solicitud);
    } else {
        $(".grid_etapaanalitica_3").hide();
        $(".grid_etapaanalitica").css('grid-template-columns','1fr 4fr 0fr');
    }
    $("#vista_"+id_solicitud).data().visualizaimg       =   visualiza;
}

function get_carrusel_img(id_anatomia){
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/visualiza_carrusel",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log("load ssan_libro_etapaanalitica/visualiza_carrusel");
                                                        $('#html_imagenes').html('');
                                                    },
        data 		:                           { 
                                                        id_anatomia     :   id_anatomia,
                                                    },
        error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        $('#html_imagenes').html('');
                                                    },
        success		:   function(aData)         { 
                                                        console.log("consulta       ->  ",aData);
                                                        console.log("html           ->  ",aData.html);
                                                        $('#html_imagenes').html(aData.html);
                                                        $('#carousel_example_generic').carousel({interval:2000});
                                                        $('#carousel_example_generic').on('slide.bs.carousel',function(){
                                                            //console.log("do something   ->  ",this);
                                                        });
                                                    }, 
   });
}

function js_update_img(id_anatomia){
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/get_update_img_etapas",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log("ssan_libro_etapaanalitica/get_update_img_etapas");
                                                        $('.update_img_microscopia').html('');
                                                    },
        data 		:                           { 
                                                        id_anatomia     :   id_anatomia,
                                                    },
        error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        $('.update_img_microscopia').html('');
                                                    },
        success		:   function(aData)         { 
                                                        //console.log("consulta -> ",aData,"  <-  ");
                                                        //console.log("html -> ",aData.html);
                                                        $(".update_img_microscopia").html(aData.html);
                                                    }, 
   });
}

function js_adjunto_ap_multiple(id, archivos) {
    var config = $("#" + id).data('config');
    var navegador = window.URL || window.webkitURL;
    var archivo = archivos[0];

    if (archivo.size > 1024 * 1024) { // 1MB
        jError("El archivo " + archivo.name + " supera el máximo permitido de 1MB", "e-SISSAN - ANATOMÍA PATOLÓGICA");
        return false;
    } else if (!['image/jpeg', 'image/jpg', 'image/png', 'image/gif'].includes(archivo.type)) {
        jAlert("El archivo " + archivo.name + " no es del tipo de imagen permitida.", "LISTA DE ERRORES");
        return false;
    }
    var formData = new FormData();
    var reader = new FileReader();
    reader.onloadend = function() {
        const base64String = reader.result;
        formData.append("IMG_PROTOCOLO_BASE64", base64String);
        formData.append("ID_ANATOMIA", config.id_anatomia);
        formData.append("id_muestra", config.id_muestra);
        formData.append("id_casete", config.id_casete);
        formData.append("ind_zona", config.ind_zona);
        formData.append("tipo_muestra", config.tipo_muestra);
        fetch('ssan_libro_etapaanalitica/gestor_imagenes_x_muestras', {
            method : "POST",
            body : formData,
        }).then(response => response.json())
        .then(return_bd => {
            const ID_IMG = return_bd["ID_IMAGEN"]["RETURN_CURSOR"][0].ID_IMAGE;
            const objeto_url = navegador.createObjectURL(archivo);
            var html = `
                <div class="card" style="margin-bottom:0px;text-align:-webkit-center;padding:6px;">
                    <img alt="64x64" class="img-thumbnail" src="${objeto_url}" style="width:64px;height:64px;">
                    <hr style="margin:2px">
                    
                    <a href="javascript:delete_img_x_muestra(${ID_IMG}, ${config.id_muestra}, ${config.id_anatomia})">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </a>
                    
                    <a href="javascript:down_img_x_muestra(${ID_IMG})">
                        <i class="fa fa-cloud-download" aria-hidden="true"></i>
                    </a>


                </div>`;
            $("#" + config.return_div).html(html);
        }).catch(err => {
            console.error('Error:', err);
            jError("error al subir imagen", "e-SISSAN");
        });
    };
    reader.readAsDataURL(archivo); // base64
}



function delete_img_x_muestra(ID_IMG,ID_MUESTRA,ID_SOLICITUD){
    jConfirm('Con esta acci&oacute;n eliminara la imagen desde el registro de anatom&Iacute;a patol&oacute;gica &iquest;desea continuar?','Clinica Libre - ANATOM&Iacute;A PATOL&Oacute;GICA',function(r) {
        if(r){ 
            $.ajax({ 
                type		:   "POST",
                url 		:   "ssan_libro_etapaanalitica/delete_img_x_muestra",
                dataType        :   "json",
                beforeSend	:   function(xhr)           {   
                                                               //console.log(xhr);
                                                                console.log("load ssan_libro_etapaanalitica/delete_img_x_muestra");
                                                            },
                data 		:                           { 
                                                                ID_IMG          :   ID_IMG,
                                                                ID_MUESTRA      :   ID_MUESTRA,
                                                                ID_SOLICITUD    :   ID_SOLICITUD,
                                                            },
                error		:   function(errro)         { 
                                                                console.log("quisas     -> ",errro);
                                                                console.log("error      -> ",errro.responseText);
                                                                jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                            },
                success		:   function(aData)         {
                                                                jAlert("Se ha eliminado la imagen","Clinica Libre");
                                                                $("#vista_x_muestra_"+ID_MUESTRA).html(aData.html);
                                                            }, 
           });
        } else {
            console.log("---------------------------------------");
            console.log("           -> DIJO NO <-               ");
            console.log("---------------------------------------");
        }
    });
}


function main_js_adjunto_ap(id_anatomia, archivos) {
    toggleModal(true); // Abstrae la lógica del modal en una función
    if (!validarArchivo(archivos[0])) return;
    const formData = new FormData();
    const reader = new FileReader();
    reader.onloadend = () => {
        procesarImagen(reader, formData, archivos[0], id_anatomia);
    };
    reader.readAsArrayBuffer(archivos[0]);
}

function validarArchivo(archivo) {
    if (archivo.size > 1024 * 1024) {
        jError("El archivo " + archivo.name + " supera el máximo permitido de 1MB", "Clinica Libre - Error");
        toggleModal(false);
        return false;
    } else if (!['image/jpeg', 'image/jpg', 'image/png', 'image/gif'].includes(archivo.type)) {
        jError("El archivo " + archivo.name + " no es del tipo de imagen permitida.", "Clinica Libre - Error");
        toggleModal(false);
        return false;
    }
    return true;
}

function procesarImagen(reader, formData, archivo, id_anatomia) {
    // Crear un FileReader para leer el contenido del archivo como base64
    var base64Reader = new FileReader();
    base64Reader.onload = function(event) {
        const base64String = event.target.result;  // Base64 string
        //console.log("Imagen en formato base64:", base64String);
        // Agregar datos al formData
        formData.append("IMG_PROTOCOLO_BASE64", base64String);
        formData.append("ID_ANATOMIA", id_anatomia);
        formData.append("get_sala", $("#get_sala").val() === 'salamacroscopia' ? 2 : 5);
        // Enviar la solicitud al servidor
        fetch('ssan_libro_etapaanalitica/new_gestiondeimagenes_fetch_json', {
            method: "POST",
            body: formData,
        }).then(response => response.json())
          .then(return_bd => actualizarUI(return_bd, archivo))
          .catch(err => manejarError(err));
    };
    // Leer el contenido del archivo como base64
    base64Reader.readAsDataURL(archivo);
}

function toggleModal(show) {
    $('#loadFade').modal(show ? 'show' : 'hide');
}

function manejarError(err) {
    console.error('Error:->', err);
    jError("Error al subir imagen", "Clinica Libre");
    toggleModal(false);
}

function actualizarUI(return_bd, archivo) {
    toggleModal(false); // Oculta el modal independientemente del resultado
    const navegador = window.URL || window.webkitURL; // Definir 'navegador' usando la API estándar o la API de WebKit
    // Asegúrate de que todos los datos necesarios estén presentes
    if (return_bd && return_bd["ID_IMAGEN"] && return_bd["ID_IMAGEN"]["RETURN_CURSOR"] && return_bd["ID_IMAGEN"]["RETURN_CURSOR"].length > 0) {
        const ID_IMG = return_bd["ID_IMAGEN"]["RETURN_CURSOR"][0].ID_IMAGE;
        const objeto_url = navegador.createObjectURL(archivo); // Asegúrate de que 'navegador' esté definido en este contexto
        const html = `<div class="card img_sala_macroscopia img_${ID_IMG}" style="margin-bottom:0px;text-align:-webkit-center;padding:6px;">
                        <img alt="64x64" class="img-thumbnail" data-src="64x64" src="${objeto_url}" data-holder-rendered="true" style="width:64px;height:64px;">
                        <hr style="margin:2px">
                        <a href="javascript:delete_img_x_main({img:${ID_IMG}, id:${id_anatomia}})" id="img_${ID_IMG}">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:down_img_x_muestra(${ID_IMG})">
                            <i class="fa fa-cloud-download" aria-hidden="true"></i>
                        </a>
                    </div>`;
        $("#imagen_main").append(html);
        $("#imagen_sala_macroscopia").hide();
    } else {
        console.error('No se pudo obtener el ID de la imagen o la estructura de datos es incorrecta:', return_bd);
        jError("No se pudo cargar la imagen correctamente.", "Error de carga");
    }
}

function delete_img(ID_IMG){
    jConfirm('Con esta acci&oacute;n eliminara la imagen desde el registro de anatom&Iacute;a patol&oacute;gica &iquest;desea continuar?','Clinica Libre - ANATOM&Iacute;A PATOL&Oacute;GICA',function(r) {
        if(r){ 
            $.ajax({ 
                type		:   "POST",
                url 		:   "ssan_libro_etapaanalitica/delete_img",
                dataType        :   "json",
                beforeSend	:   function(xhr)           {   
                                                               //console.log(xhr);
                                                                console.log("load ssan_libro_etapaanalitica/delete_img");
                                                            },
                data 		:                           { 
                                                                ID_IMG     :   ID_IMG,
                                                            },
                error		:   function(errro)         { 
                                                                console.log("quisas     -> ",errro);
                                                                console.log("error      -> ",errro.responseText);
                                                                jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                            },
                success		:   function(aData)         {
                                                                console.log("consulta   -> ",aData.html);
                                                                jAlert("Se ha eliminado la imagen","Clinica Libre");
                                                                $(".imagen_"+ID_IMG).remove();
                                                                
                                                                //update delete
                                                                $("#get_sala").val() == 'analitica'?'':'';
                                                                $("#get_sala").val() == 'salamacroscopia'?'':'';
                                                                
                                                            }, 
           });
        } else {
            console.log("-------------");
            console.log("-> DIJO NO <-");
            console.log("-------------");
        }
    });
}

function edita_img(ID_IMG){
    console.log("edita_img      ->",ID_IMG);
}

function descarga_img(ID_IMG){
    console.log("descarga_img   ->",ID_IMG);
}

function star_microfono_1(){
    jError("Micr&oacute;fono no iniciado","Clinica Libre");
}

function js_guarda_descripcion_muestras(id_anatomia){
    //console.log("               ->  ", get_numeros_asociados(id_anatomia).join(","));
    var array_main              =   new Array();
    var array_nmuestras         =   new Array();
    var error                   =   new Array();
    $('.error_macroscopica').each(function(i,obj){  /*   console.log("  ->  ",obj.id);   */ $("#"+obj.id).removeClass("error_macroscopica"); });
    if($("#txt_descipcion_general").val() == '' && !document.getElementById('txt_descipcion_general').disabled ){
        error.push({txt:"Descripci&oacute;n Macrosc&oacute;pica general vac&iacute;a",value:"#txt_descipcion_general"});
    } else {
        array_main.push({txt:$("#txt_descipcion_general").val()});
    }
    //**************************************************************************
    $(".lista_anatomia").each(function(index,value){
        //console.log(index,value);
        $("#txt_descipcion_"+value.id).val() == '' ? error.push({ txt : "Descripci&oacute;n Macroscopia N&deg; "+ value.id +" vacia" , value : "#txt_descipcion_"+value.id }) : '';
        array_nmuestras.push({
            "tipo"  :   "muestra",
            "id"    :   value.id,
            "txt"   :   $("#txt_descipcion_"+value.id).val(),
        });
    });
    $(".lista_casete_x_muestra").each(function(index,value){
        $("#txt_descipcion_"+value.id).val() == '' ? error.push({ txt : "Descripci&oacute;n Macroscopia N&deg; "+ value.id +" vacia" , value : "#txt_descipcion_"+value.id }) : '';
        array_nmuestras.push({
            "tipo"  :   "casete",
            "id"    :   value.id,
            "txt"   :   $("#txt_descipcion_"+value.id).val(),
        });
    });
    //console.log("array_nmuestras                ->  ",array_nmuestras,"<-       ");
    //descripcion macro de citologia
    var booreane        =   document.getElementById("ind_deshabilitar_macro_cito").checked;
    console.log("booreane   ->  no aplica para citologia o talvez si    <-  " , booreane);
    if(!booreane){
        $(".lista_citologia").each(function(index,value){
            $("#txt_descipcion_"+value.id).val() == '' ? error.push({ txt : "(Citologia) Descripci&oacute;n Macroscopia N&deg; "+ value.id +" vacia" , value : "#txt_descipcion_"+value.id }) : '';
            array_nmuestras.push({
                "tipo"  :   "citologia",
                "id"    :   value.id,
                "txt"   :   $("#txt_descipcion_"+value.id).val(),
            });
        }); 
    }
    
    console.log("---------------------------------");
    console.log("array_nmuestras->",array_nmuestras);
    if(error.length === 0 ){
        jPrompt('Con esta acci&oacute;n se proceder&aacute; agregar informe macrosc&oacute;pica.<br /><br />&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
            if(r) {
                    $('#loadFade').modal('hide'); 
                    $.ajax({ 
                        type		:   "POST",
                        url 		:   "ssan_libro_etapaanalitica/get_informr_macroscopica",
                        dataType    :   "json",
                        data        :   {
                                            id_anatomia     :   id_anatomia,
                                            contrasena      :   r,
                                            array_main      :   array_main,
                                            accesdata       :   array_nmuestras,
                                        },
                        error		:   function(errro)     {  
                                                                console.log(error);
                                                                console.log(errro.responseText); 
                                                                $('#loadFade').modal('hide'); 
                                                                jError("Error en el aplicativo","Clinica Libre"); 
                                                            },
                        success     :   function(aData)     { 
                                                                console.log("   aData   ->  ",aData);
                                                                $('#loadFade').modal('hide');     
                                                                if(aData.status){
                                                                    $("#modal_descipcion_muestras").modal("hide");
                                                                    localStorage.setItem("ind_tipo_mensaje",2);
                                                                    localStorage.setItem("ind_estapa_analitica",0);
                                                                    localStorage.setItem("num_fichae",null);
                                                                    localStorage.setItem("id_anatomia",id_anatomia);
                                                                    localStorage.setItem("txt_name_biopsia",get_numeros_asociados(id_anatomia).join(","));
                                                                    localStorage.setItem("span_tipo_busqueda",$("#span_tipo_busqueda").html());
                                                                    //$("#load_anuncios_anatomia_patologica").submit();
                                                                    update_etapaanalitica();
                                                                    jConfirm('Se ha grabado con &eacute;xito - &iquest;desea Impimir informe?','Clinica Libre - ANATOM&Iacute;A PATOL&Oacute;GICA',function(r) {
                                                                        if(r){
                                                                            //js_pdf_macroscopia(0,id_anatomia);
                                                                        } else {
                                                                            //console.log("-> DIJO NO PDF <-");
                                                                        }
                                                                    });
                                                                } else {
                                                                    jError("Error en la firma simple","Clinica Libre");
                                                                }
                                                            }, 
                     });
            } else {
                jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
            }
        });
    } else {
        //console.log("error -----------------> ",error);
        var txt_error   = '';
        error.forEach(function(value,index){ $(value.value).addClass("error_macroscopica"); txt_error+=value.txt+"<br>"; });
        showNotification('top','left',txt_error,4,'fa fa-exclamation-triangle');
    }
}

function delete_img_x_main(data){
    console.table(data);
    var html_img        =   '';
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/elimina_imagen",
        dataType        :   "json",
        data            :   {
                                img         :   data.img,
                            },
        error		:   function(errro)     {  
                                                    console.log(error);
                                                    console.log(errro.responseText); 
                                                    jError("Error en el aplicativo","Clinica Libre"); 
                                                },
        success        :   function(aData)     { 
                                                    if(aData.status){
                                                        if ( $("#get_sala").val()=='analitica'){
                                                            showNotification('top','center','Se ha eliminado imagen N&deg;:'+data.img,2,'fa fa-check');
                                                            js_update_img(data.id);
                                                        } else {
                                                            $(".img_"+data.img).remove('');
                                                            var aux =   0;
                                                            $('.img_sala_macroscopia').each(function(i,obj){ aux++;});
                                                            if (aux === 0){
                                                                html_img    =   '<div class="card" style="margin-bottom:0px;padding:8px;" id="imagen_sala_macroscopia">'+
                                                                                    '<div style="background-color:transparent !important; text-align:center"><div class="font_15"><b>SUBIR</b></div></div>'+
                                                                                    '<hr style="margin-top:10px;margin-bottom:10px">'+
                                                                                    '<div class="flex_box_center">'+
                                                                                        '<label class="custom-file-label pointer" for="imagen_macroscopia_'+data.id+'"><i class="fa fa-cloud-upload fa-4x" aria-hidden="true"></i></label>'+
                                                                                        '<input type="file" data-get_sala="salamacroscopia" id="imagen_macroscopia_'+data.id+'" onchange="main_js_adjunto_ap('+data.id+',this.files)">'+
                                                                                    '</div>'+
                                                                                '</div>';
                                                                $("#imagen_main").html(html_img);
                                                            } 
                                                        }
                                                    } 
                                                }, 
    });
}

function js_pdf_microscopica(id_anatomia){
    $("#modal_pdf_fullscreen").modal({backdrop:'static',keyboard:false}).modal("show");
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
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        //$('#html_pdf_fullscreen').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                                        $("#modal_pdf_fullscreen").modal("hide");
                                                    },
        success		:   function(aData)         { 
                                                        console.log("---------------------------------------");
                                                        console.log("   aData   ->",aData,"<-           ");
                                                      
                                                        //$('#html_pdf_fullscreen').html(aData["GET_HTML2"]);
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
                                                            $('#html_pdf_fullscreen').html(Objpdf);
                                                        }
                                                   }, 
   });
}

function js_load_line_pdf(option,id_anatomia){
    $(".class_tabs_template").attr('onclick','');
    js_pdf_macroscopia(1,id_anatomia);
}

function js_pdf_macroscopia(option,id_anatomia){
    if (option == 1){
        var html_body       =   "line_pdf_microscopia";
    } else {
        var html_body       =   "html_pdf_fullscreen";
        $("#modal_pdf_fullscreen").modal({backdrop:'static',keyboard:false}).modal("show");
    }
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/pdf_macroscopia_parte1",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        var html_load = '<div class="grid_espera_pdf">'+
                                                                            '<div class="grid_espera_pdf1"></div>'+    
                                                                            '<div class="grid_espera_pdf2"><i class="fa fa-spinner fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;GENERANDO PDF</div>'+    
                                                                            '<div class="grid_espera_pdf3"></div>'+
                                                                        '</div>';
                                                        $('#'+html_body).html(html_load);
                                                    },
        data 		:                           { 
                                                        id:id_anatomia,
                                                    },
        error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        //$('#html_pdf_fullscreen').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                                        $('#'+html_body).modal("hide");
                                                    },
        success		:   function(aData)         { 
                                                        console.log("success aData      ->      ",aData);
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
                                                            $('#'+html_body).html(Objpdf);
                                                            console.log(aData['GET_HTML']);
                                                            //$("#get_html_macroscopica").html(aData["GET_HTML"]);
                                                            //console.log(aData['GET_HTML']);
                                                            //$("#html_pdf_fullscreen").html(aData['GET_HTML']);
                                                        }
                                                   }, 
   });
}

function js_star_sala_proceso(id_anatomia){
    $('#loadFade').modal('show'); 
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/get_star_sala_proceso",
        dataType        :   "json",
        data            :   {
                                id_anatomia     :   id_anatomia,
                                get_sala        :   $("#get_sala").val(),
                                opcion          :   1,
                            },
        error		:   function(errro)     {  
                                                    console.log(errro.responseText); 
                                                    $("#modal_star_sala_proceso").modal("hide");
                                                    $('#loadFade').modal('hide'); 
                                                    jError("Error en el aplicativo","Clinica Libre"); 
                                                },
        success		:   function(aData)     { 
                                                    console.log("---------------------------------------------------------");
                                                    console.log(" -> ",aData);
                                                    //console.log("out_cursores -> ",aData.out_cursores);
                                                    //console.log("aData.id_zona ------------------->  ",aData.id_zona,"<-     ");
                                                    $('#loadFade').modal('hide'); 
                                                    $("#modal_star_sala_proceso").modal({backdrop:'static',keyboard:false}).modal("show");
                                                    $("#html_star_sala_proceso").html(aData.html);
                                                    $("#btn_star_sala_proceso").attr('onclick',aData.id_zona==1?'js_inicia_sala_procesos('+id_anatomia+')':'js_inicia_final_procesos('+id_anatomia+')');
                                                    /*
                                                    console.error("---------------------------------------");
                                                    console.error(" ind_proceso     ->  ",aData.ind_proceso);
                                                    console.error("---------------------------------------");
                                                    */
                                                    if(aData.ind_proceso!=0){
                                                        $("#ind_tipo_proceso").val(aData.ind_proceso).selectpicker('refresh');
                                                    }
                                                    if(aData.id_zona==5){
                                                        document.getElementById('date_fecha_inicio_sala_proceso').disabled      =   true;
                                                        document.getElementById('hrs_star_sala_proceso').disabled               =   true;
                                                        document.getElementById('ind_tipo_proceso').disabled                    =   true;
                                                    }
                                                }, 
    });
}

function js_inicia_sala_procesos(id_anatomia){
    var errores                                     =   [];
    if ($("#date_fecha_inicio_sala_proceso").val()  === '') {   errores.push("&#8226;&nbsp;Fecha de inicio vac&iacute;a");     }
    if ($("#hrs_star_sala_proceso").val()           === '') {   errores.push("&#8226;&nbsp;Hora vac&iacute;a");                }
    if ($("#ind_tipo_proceso").val()                === '') {   errores.push("&#8226;&nbsp;Falta tipo de proceso");            }
    if (errores.length === 0 ){
        var obj_rce_anatomia                        =   { 
            form_star_sala_proceso                  :   [],
        };
        obj_rce_anatomia.form_star_sala_proceso.push({
            date_fecha_star_salaproceso             :   $("#date_fecha_inicio_sala_proceso").val()+" "+$("#hrs_star_sala_proceso").val(),
            ind_proceso_sala                        :   $("#ind_tipo_proceso").val(),
        });
        //console.log("---------------------------------------------------------------------------");
        //console.log("obj_rce_anatomia           -> ",obj_rce_anatomia,"<-                       ");
        //console.log("---------------------------------------------------------------------------");
        jPrompt('Con esta acci&oacute;n se proceder&aacute; a marcar el tiempo inicio en sala de proceso<br/><br/>&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
            if (r){
                    $('#loadFade').modal('show'); 
                    $.ajax({ 
                         type		:   "POST",
                         url 		:   "ssan_libro_etapaanalitica/get_guardar_info_sala_proceso",
                         dataType   :   "json",
                         data       :   {
                                            contrasena          :   r,
                                            id_anatomia         :   id_anatomia,
                                            accesdata           :   obj_rce_anatomia,
                                            opcion              :   1,
                                        },
                         error		:   function(errro){  
                                                            console.log(errro.responseText); 
                                                            jError("Error en el aplicativo","Clinica Libre");
                                                            $('#loadFade').modal('hide'); 
                                                        },
                         success    :   function(aData) { 
                                                            console.log("-------------------------------------------");
                                                            console.log("   return get_guardar_info_sala_proceso    ");
                                                            console.log("   ->",aData,"<-                           ");
                                                            console.log("-------------------------------------------");
                                                            $('#loadFade').modal('hide'); 
                                                            if(aData.status){
                                                                jAlert("Se inici&oacute; tiempo en sala de proceso","Clinica Libre");
                                                                $("#modal_star_sala_proceso").modal('hide');
                                                                localStorage.setItem("ind_tipo_mensaje",3);
                                                                localStorage.setItem("ind_estapa_analitica",0);
                                                                localStorage.setItem("num_fichae",null);
                                                                localStorage.setItem("id_anatomia",id_anatomia);
                                                                //localStorage.setItem("txt_name_biopsia",get_numeros_asociados(id_anatomia).join(","));
                                                                localStorage.setItem("span_tipo_busqueda",$("#span_tipo_busqueda").html());
                                                                //$("#load_anuncios_anatomia_patologica").submit();
                                                                update_etapaanalitica();
                                                            } else {
                                                                jError("Error Firma simple","Clinica Libre");
                                                            }
                                                        }, 
                    });
            } else {
                jError("Firma simple vac&iacute;a","Error - Clinica Libre"); 
            }
        });
    } else {
        showNotification('top','left',errores.join("<br>"),4,'fa fa-ban');
    }
}

function js_inicia_final_procesos(id_anatomia){
    var errores                                 =   [];
    if ($("#date_fecha_final_sala_proceso").val()  ==='')  {   errores.push("&#8226;&nbsp;Fecha de final vacia");   }
    if ($("#hrs_end_sala_proceso").val()           ==='')  {   errores.push("&#8226;&nbsp;Hora final vacia");       }
    if(errores.length === 0 )                   {
        var obj_rce_anatomia                    =   { 
            form_star_sala_proceso              :   [],
        };
        //TIME UNIX
        var date_inicio                         =   $("#date_fecha_inicio_sala_proceso").val()+" "+$("#hrs_star_sala_proceso").val();
        var date_final                          =   $("#date_fecha_final_sala_proceso").val()+" "+$("#hrs_end_sala_proceso").val();
        var v_date_inicio                       =   time_unix($("#date_fecha_inicio_sala_proceso").val(),$("#hrs_star_sala_proceso").val());
        var v_date_final                        =   time_unix($("#date_fecha_final_sala_proceso").val(),$("#hrs_end_sala_proceso").val());
        console.log("v_date_inicio   UNIX       ->  ",v_date_inicio.UNIX,"   <_        ");
        console.log("v_date_final    UNIX       ->  ",v_date_final.UNIX,"    <-        ");
        console.log("=",v_date_inicio.UNIX === v_date_final.UNIX);
        console.log(">",v_date_inicio.UNIX > v_date_final.UNIX);
        console.log("<",v_date_inicio.UNIX < v_date_final.UNIX);
        if (v_date_inicio.UNIX === v_date_final.UNIX)     {
            showNotification('bottom','right','Fecha y hora de la sala de proceso son iguales',4,'fa fa-ban');  
            return false;
        }
        if (v_date_inicio.UNIX > v_date_final.UNIX)   {
            showNotification('bottom','right','Fecha inicio no puede ser menor a la fecha final de sala de proceso',4,'fa fa-ban');  
            return false;
        } else {
            console.log("todo ok");
        }
        obj_rce_anatomia.form_star_sala_proceso.push({
            date_fecha_final_salaproceso         :   $("#date_fecha_final_sala_proceso").val()+" "+$("#hrs_end_sala_proceso").val(),   
        });
        //console.tabla("obj_rce_anatomia     ->  ",obj_rce_anatomia);
        jPrompt('Con esta acci&oacute;n se proceder&aacute; a marcar el tiempo <b>Final</b> en sala de proceso<br/><br/>&iquest;Est&aacute; seguro de continuar?','','Confirmaci\u00f3n',function(r){
            if (r){
                $('#loadFade').modal('show');
                $.ajax({ 
                     type       :   "POST",
                     url        :   "ssan_libro_etapaanalitica/get_guardar_final_sala_proceso",
                     dataType   :   "json",
                     data       :   {
                                        contrasena          :   r,
                                        id_anatomia         :   id_anatomia,
                                        accesdata           :   obj_rce_anatomia,
                                        opcion              :   1,
                                    },
                     error		:   function(errro) {  
                                                        console.log(errro.responseText); 
                                                        jError("Error en el aplicativo","Clinica Libre");
                                                        $('#loadFade').modal('hide'); 
                                                    },
                     success    :   function(aData) { 
                                                        $('#loadFade').modal('hide'); 
                                                        console.log("---------------------------");
                                                        console.log("aData  ->  ",aData);
                                                        if(aData.status_fecha){
                                                            if(aData.status){
                                                                
                                                                jAlert("Se finalizo en sala de proceso","Clinica Libre");
                                                                $("#modal_star_sala_proceso").modal('hide');
                                                                
                                                                localStorage.setItem("ind_tipo_mensaje",4);
                                                                localStorage.setItem("ind_estapa_analitica",0);
                                                                localStorage.setItem("num_fichae",null);
                                                                localStorage.setItem("id_anatomia",id_anatomia);
                                                                //localStorage.setItem("txt_name_biopsia",get_numeros_asociados(id_anatomia).join(","));
                                                                localStorage.setItem("span_tipo_busqueda",$("#span_tipo_busqueda").html());
                                                                //$("#load_anuncios_anatomia_patologica").submit();
                                                                
                                                                update_etapaanalitica();
                                                            } else {
                                                                jError("Error Firma simple","Clinica Libre");
                                                            }
                                                        } else {
                                                            showNotification('bottom','right',aData.v_txt_error,4,'fa fa-ban');  
                                                        }
                                                    }, 
                });
            } else {
                jError("firma simple vac&iacute;a","Error - Clinica Libre"); 
            }
        });
    } else {
        showNotification('top','left',errores.join("<br>"),4,'fa fa-ban');
    }
}

function time_unix(TXTFECHA,TXTHORA){
    console.log(TXTFECHA,TXTHORA);
    var from1       =   TXTFECHA.split("-");
    var horalive    =   TXTHORA.split(":");
    var fecha       =   from1[2]+'-'+from1[0]+'-'+from1[1]+' '+horalive[0]+':'+horalive[1]+':00';
    var match       =   fecha.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
    var date        =   new Date(match[1]+"-"+match[3]+"-"+match[2]+" "+match[4]+":"+match[5]+":00");
    var valor       =   (date.getTime()/1000);
    return { TXTFECHA : TXTFECHA, TXTHORA : TXTHORA,  match : match, date : date, UNIX : valor };
}

function js_sala_tecnicas(id_anatomia){
    $('#loadFade').modal('show'); 
    let v_get_sala = $("#get_sala").val();

    
    $.ajax({ 
         type       :   "POST",
         url        :   "ssan_libro_etapaanalitica/gestion_sala_tecnicas",
         dataType   :   "json",
         data       :   {   
                            id_anatomia     :   id_anatomia,
                            get_sala        :   v_get_sala,
                        },
         error      :   function(errro) {  
                                            console.log(errro.responseText); 
                                            jError("Error en el aplicativo","Clinica Libre");
                                            $('#loadFade').modal('hide'); 
                                        },
         success    :   function(aData) { 
                                            console.log("-----------------------------------------------");
                                            console.log("v_get_sala                 ->  ",v_get_sala);
                                            console.log("id_anatomia                ->  ",id_anatomia);
                                            console.log("out gestion_sala_tecnicas  ->  ",aData);
                                            console.log("-----------------------------------------------");

                                            $('#loadFade').modal('hide'); 
                                            if(aData.status){
                                                $("#btn_previo_sala_tecnicas").attr('onclick','js_guarda_sala_tecnicas(1,'+id_anatomia+')');
                                                //$("#btn_previo_sala_tecnicas").prop("disabled",true);
                                                $("#btn_graba_tecnicas").attr('onclick','js_guarda_sala_tecnicas(2,'+id_anatomia+')');
                                                $("#html_sala_tecnicas").html(aData.out_html);
                                                $("#modal_sala_tecnicas").modal({backdrop:'static',keyboard:false}).modal("show");
                                            }
                                        }, 
    });
}

function js_guarda_sala_tecnicas(op,id_anatomia){
    //op=1 //guardado previo
    //op=2 //finaliza reporte
    var val_cierre                          =   document.getElementById("ind_inclusion").checked&&document.getElementById("ind_corte").checked&&document.getElementById("ind_tincion").checked?true:false;
    var errores                             =   [];
    var lis_checked                         =   [];
    var obj_rce_anatomia                    =   { 
        formulario_sala_tecnica             :   [],
        check_tecnicas_tecnologo            :   [],
        valida_cambio                       :   [],
    };
    //--------------------------------------------------------------------------
    var data_form_registro                  =   [];
    data_form_registro.push({
        date_fecha_macro                    :   $("#date_fecha_macro").val(),   
        date_fecha_corte                    :   $("#date_fecha_corte").val(), 
        ind_color_taco                      :   $("#ind_color_taco").val(),
        ind_estado_olga                     :   $("#ind_estado_olga").val(), 
        date_interconsulta_ap               :   $("#date_interconsulta_ap").val(), 
        num_copia_inerconsulta              :   $("#num_copia_inerconsulta").val(),
        num_fragmentos                      :   $("#num_fragmentos").val(), 
        num_tacos_cortados                  :   $("#num_tacos_cortados").val(), 
        num_extendidos                      :   $("#num_extendidos").val(),
        //num_azul_alcian_seriada           :   $("#num_azul_alcian_seriada").val(),
        //num_pas_seriada                   :   $("#num_pas_seriada").val() ,
        //num_diff_seriada                  :   $("#num_diff_seriada").val(),
        //num_he_seriada                    :   $("#num_he_seriada").val(),
        //num_all_laminas_seriadas          :   $("#num_all_laminas_seriadas").val(),
        //num_he_rapida                     :   $("#num_he_rapida").val(),
        checked_inclusion                   :   document.getElementById("ind_inclusion").checked,
        checked_corte                       :   document.getElementById("ind_corte").checked,
        checked_tincion                     :   document.getElementById("ind_tincion").checked,
        checked_tenicas_all                 :   val_cierre,
    });
    obj_rce_anatomia.formulario_sala_tecnica.push(data_form_registro);
    console.table(obj_rce_anatomia)
    //MUESTAS X TECNICAS APLICADAS
    var aux                 =    0;
    $('.arr_muestras').each(function(){
        if(this.id          !=  ''){
            console.log("-------------------------------------------------------------------");
            console.log("this.id            ->  ",this.id,"                     <-          ");
            console.log("this.id val        ->  ",$("#"+this.id).val(),"        <-          ");
            $("#"+this.id).val()===null?
                errores.push($("#"+this.id).data('id_muestra')):
                lis_checked.push({
                    'ap'    :   $("#"+this.id).data('id_ap'),
                    'id'    :   $("#"+this.id).data('id_muestra'),
                    'txt'   :   $("#"+this.id).val()
                });
            aux++;
        }
    });
    
    console.log("---------------------------------------------------------------");
    console.log("   lis_checked         ->  ",lis_checked,"         <-          ");
    console.log("   obj_rce_anatomia    ->  ",obj_rce_anatomia,"    <-          ");
    console.log("   val_cierre          ->  ",val_cierre,"          <-          ");
    console.log("   errores             ->  ",errores,"             <-          ");
    console.log("   aux                 ->  ",aux,"                             ");
    console.log("---------------------------------------------------------------");
    
    if (op  ==  1){
        var r = '';
        $('#loadFade').modal('show'); 
        $.ajax({ 
            type        :   "POST",
            url         :   "ssan_libro_etapaanalitica/get_guardadoprevio_tec_tecnologo",
            dataType    :   "json",
            data        :   {
                                op              :   op,
                                contrasena      :   r,
                                id_anatomia     :   id_anatomia,
                                lis_checked     :   lis_checked,
                                val_cierre      :   val_cierre?1:0,
                                accesdata       :   obj_rce_anatomia,
                            },
            error       :    function(errro)    {  
                                                    console.log(errro);
                                                    $('#loadFade').modal('hide'); 
                                                    jError("Error en el aplicativo","Clinica Libre");
                                                },
            success     :    function(aData)     { 
                                                    console.table("aData->",aData);
                                                    $('#loadFade').modal('hide');
                                                    if(aData.status){
                                                         jAlert("Se ha realizado el guardado previo.","Clinica Libre");
                                                    } else {
                                                        jError("Error en la firma simple","Clinica Libre");  
                                                    }
                                                }, 
        });
        
    } else {
        if((errores.length>0)||(lis_checked>0)){
            var txt =   'Sin tecnicas  aplicadas a muestras '+errores.length>0?errores.join("<br>"):'Sin Datos';
            showNotification('top','left',txt,4,'fa fa-ban');
        }   else  {
            //ind cierre
            //console.log("val_cierre     ->  ",val_cierre);
            var txt_estado                  =   val_cierre?'&nbsp;<b>CERRADO</b>':'&nbsp;<b>NO CERRADO</b>';
            
            //console.log("ws");

            jPrompt('Con esta acci&oacute;n agregara informaci&oacute;n a solicitud histopatol&oacute;gico <br>Estado:'+txt_estado+'<br>&iquest;Desea continuar?','','Confirmaci\u00f3n',function (r) {
                console.log("password       ->  ",r);
                if(r){
                    $.ajax({ 
                        type        :   "POST",
                        url         :   "ssan_libro_etapaanalitica/get_record_tec_tecnologo",
                        dataType    :   "json",
                        data        :   {
                                            op              :   op,
                                            contrasena      :   r,
                                            id_anatomia     :   id_anatomia,
                                            lis_checked     :   lis_checked,
                                            val_cierre      :   val_cierre?1:0,
                                            accesdata       :   obj_rce_anatomia,
                                        },
                        error       :    function(errro)    {  
                                                                console.log(errro.responseText);
                                                                jError("Error en el aplicativo","Clinica Libre");
                                                            },
                        success     :    function(aData)     { 
                                                                console.table("aData->",aData);
                                                                if(aData.status_firma){
                                                                    if(aData.status){
                                                                        
                                                                        localStorage.setItem("ind_tipo_mensaje",5);
                                                                        localStorage.setItem("ind_estapa_analitica",0);
                                                                        localStorage.setItem("num_fichae",null);
                                                                        localStorage.setItem("id_anatomia",id_anatomia);
                                                                        localStorage.setItem("txt_name_biopsia",get_numeros_asociados(id_anatomia).join(","));
                                                                        localStorage.setItem("span_tipo_busqueda",$("#span_tipo_busqueda").html());
                                                                        $("#load_anuncios_anatomia_patologica").submit();
                                                                        
                                                                        jAlert("T&eacute;cnicas agregadas a la solicitud","Clinica Libre");
                                                                        update_etapaanalitica();
                                                                        $("#modal_sala_tecnicas").modal('hide');
                                                                    }
                                                                } else {
                                                                    jError("Error en la firma simple","Clinica Libre");  
                                                                }
                                                            }, 
                    });
                } else {
                    showNotification('top','left','Firma simple vac&iacute;a',4,'fa fa-times');
                }
            });
        }
    }
}

function js_historial(id_anatomia){
    console.log("id_anatomia    ->  ",id_anatomia);
}

function js_historial_panel(id_anatomia){
    console.log("id_anatomia    ->  ",id_anatomia);
}

function load_sala_tecnicas(){
    //console.error("load_sala_tecnicas   ->  ",404);
    $('.lista_gestion_tecnologo a[href="#tabs_lista_muestras"]').tab('show');
    //$("#ind_estado_olga").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_ESTADIO_OLGA"];?>');
    //$("#ind_color_taco").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_COLOR_TACO"];?>');
    $(".selectpicker").selectpicker();
    $(".star_calendar").datetimepicker({
        format              :   'DD-MM-YYYY',
        //minDate           :   new Date(new Date().setDate((new Date().getDate())-(30))),
        //maxDate           :   new Date(),
        locale              :   'es-us',
        icons               :   {
                                    time        :   "fa fa-clock-o"         ,
                                    date        :   "fa fa-calendar"        ,
                                    up          :   "fa fa-chevron-up"      ,
                                    down        :   "fa fa-chevron-down"    ,
                                    previous    :   "fa fa-chevron-left"    ,
                                    next        :   "fa fa-chevron-right"   ,
                                    today       :   "fa fa-screenshot"      ,
                                    clear       :   "fa fa-trash"           ,
                                    close       :   "fa fa-remove"          ,
                                }
    }).on('dp.change',function(e){  console.log("e  -> ",e);  });
    var arr_tecnicas                    =   $("#tecnicas_realizadas").data("prestacion");
    if(arr_tecnicas.length>0){
        var arr_x_muestra               =   [];
        let json                        =   arr_tecnicas.reduce((acc,fila)=>{ !acc[fila.ID_NMUESTRA]?acc[fila.ID_NMUESTRA]=[]:'';acc[fila.ID_NMUESTRA].push(fila); return acc; },{});
        for(let i in json) {
            var arr_tecnicas            =   [];
            json[i].forEach(function(fila,indice,array){ arr_tecnicas.push(fila.ID_TECNICA_AP);});
            $('#prestaciones_'+i).selectpicker('val',arr_tecnicas);
        }
    }
}

function js_sin_descripcion(){
   $('.value_microscopia').each(function(){ 
        var txt                 =   $("#"+this.id).val();
        var num                 =   $("#"+this.id).data('muestra');
        /*
        console.log("-------------------------------------");
        console.log("this.id    ->  ",this.id);
        console.log("txt        ->  ",txt);
        console.log("num        ->  ",num);
        */
        $("#collapseOne"+num).collapse('show');
        $("#nuestra_x_casete_"+num).collapse('show');
        if(txt  ==  ''){
            document.getElementById("ind_sin_descripcion_"+num).checked = true;
            $('#txt_descipcion_'+num).prop('disabled',true);
        }
        $("#collapseOne"+num).collapse('show');
        $("#nuestra_x_casete_"+num).collapse('show');
    });
}

function con_descripciom_num(num){
    //console.log("--------------------------------------------");
    //console.log("num    ->  ",num," <-  ");
    var ind_cheked = document.getElementById("ind_sin_descripcion_"+num).checked;
    //console.log("ind_cheked    ->  ",ind_cheked," <-  ");
    //console.log("--------------------------------------------");
    if (ind_cheked){
        document.getElementById("ind_sin_descripcion_"+num).checked = true;
        $('#txt_descipcion_'+num).val('').prop('disabled',true);
    } else {
        document.getElementById("ind_sin_descripcion_"+num).checked = false;
        $('#txt_descipcion_'+num).prop('disabled',false);
    }
}

function edita_txt_macroscopica(num_muestra){
    var txt_anatomia = $("#txt_muestra_macroscopica_"+num_muestra).val();
    $.ajax({ 
        type        :   "POST",
        url         :   "ssan_libro_etapaanalitica/get_update_txt_macroscopica",
        dataType    :   "json",
        data        :   {
                            num_muestra     :   num_muestra,
                            txt_update      :   txt_anatomia,
                        },
        error       :    function(errro)    {  
                                                console.log(errro.responseText);
                                                jError("Error en el aplicativo","Clinica Libre");
                                            },
        success     :    function(aData)     { 
                                                console.table("aData->",aData);
                                                if(aData.status){
                                                    jAlert("Se actualizo informacion macroscopica","Clinica Libre");
                                                }
                                            }, 
    });
}


function js_busqueda_num_cancer(ind_nof_cancer){
    console.log("ind_nof_cancer -> ",ind_nof_cancer);
    if (ind_nof_cancer == 1){
        $("#tr_num_cancer").show();
        $('#loadFade').modal('show');
        $.ajax({ 
            type                :   "POST",
            url                 :   "ssan_libro_etapaanalitica/ultimo_numero_disponible_cancer",
            dataType            :   "json",
            beforeSend          :   function(xhr)   {   
                                                        console.log("xhr->",xhr);
                                                    },
            data                :                   {   id_biopsia : $("#id_anatomia").val() },
            error		    :   function(errro) { 
                                                        console.log(errro);  
                                                        console.log(errro.responseText);    
                                                        $('#loadFade').modal('hide');
                                                        jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                    },
            success             :   function(aData) { 
                                                        
                                                        $('#loadFade').modal('hide');
                                                        $("#num_interno").val('');
                                                        var num_last    =   aData.data_numero.DATA_NUMBER[0]['V_LAST_NUMERO'];
                                                        showNotification('top','center','Ultimo N&deg; disponible notificaci&oacute;n cancer <b>'+num_last+'</b>',1,'fa fa-info');
                                                        $("#n_notificacion_cancer").val(num_last);
                                                    }, 
        });
    } else {
        $("#tr_num_cancer").hide();
    }
}


function test_pdf(id_anatomia){
   $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/pdf_test_anatomia",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        $("#modal_pdf_fullscreen").modal({backdrop:'static',keyboard:false}).modal("show");
                                                        var html_load = '<div class="grid_espera_pdf">'+
                                                                            '<div class="grid_espera_pdf1"></div>'+    
                                                                            '<div class="grid_espera_pdf2"><i class="fa fa-spinner fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;GENERANDO PDF</div>'+    
                                                                            '<div class="grid_espera_pdf3"></div>'+
                                                                        '</div>';
                                                        $('#html_pdf_fullscreen').html(html_load);
                                                    },
        data 		:                           { 
                                                        id:id_anatomia,
                                                    },
        error		:   function(errro)         { 
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                        //$('#html_pdf_fullscreen').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                                        $('#'+html_body).modal("hide");
                                                    },
        success		:   function(aData)         { 
                                                        console.log("success aData      ->      ",aData);
                                                        
                                                        
                                                        if(!aData["STATUS"]){
                                                            jError("error al cargar protocolo PDF","Clinica Libre");
                                                            return false;
                                                        } else {
                                                            var base64str           =   aData["PDF_MODEL"];
                                                            var binary              =   atob(base64str.replace(/\s/g,''));
                                                            var len                 =   binary.length;
                                                            var buffer              =   new ArrayBuffer(len);
                                                            var view                =   new Uint8Array(buffer);
                                                            for(var i=0;i<len;i++){ view[i] = binary.charCodeAt(i); }
                                                            var blob                =   new Blob([view],{type:"application/pdf"});
                                                            var blobURL             =   URL.createObjectURL(blob);
                                                            Objpdf                  =   document.createElement('object');
                                                            Objpdf.setAttribute('data',blobURL);
                                                            Objpdf.setAttribute('width','100%');
                                                            Objpdf.setAttribute('style','height:700px;');
                                                            Objpdf.setAttribute('title','PDF');
                                                            $('#html_pdf_fullscreen').html(Objpdf);
                                                        }
                                                   }, 
   });
}

//console.log("--------------------------------------------------------------------------------------------");
//console.log("storange_ids_anatomia              =>  ",localStorage.getItem("storange_ids_anatomia"));
//console.log("--------------------------------------------------------------------------------------------");
//local stronge vacio
//grid_a_rce_anatomiapatologica
//$(".css_#_panel_por_gestion").each(function(index,value){
    //console.log("---------------------------");
    //console.log(value.id);
    //console.log(index,value);
    //console.log($("#"+value.id).data("id_anatomia_pantalla"));
    //arr_storange_ids_anatomia.push($("#"+value.id).data("id_anatomia_pantalla"));
//});

/*
function js_collapse_muestras(){
    //Descripcion de muestras
    console.log("---------------->  js_collapse_muestras    <-------------------");
    console.log("   Descripcion de muestras ");
    $('.value_microscopia').each(function(){
        var txt     =   $("#"+this.id).val();
        var num     =   $("#"+this.id).data('muestra');
        console.log("---------------------------------");
        console.log("txt    ->  ",txt);
        console.log("num    ->  ",num);
    });
}
*/  

function GET_PDF_ANATOMIA_PANEL(id){
    $("#Dv_verdocumentos").modal("show");
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica_model/BLOB_PDF_ANATOMIA_PATOLOGICA",
        dataType    :   "json",
        beforeSend	:   function(xhr)       {   
                                                        console.log(xhr);
                                                console.log("generando PDF");
                                                $('#HTML_PDF_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF");
                                            },
        data 		:                       { 
                                                id  :   id,
                                            },
        error		:   function(errro)     { 
                                                console.log("quisas->",errro,"-error->",errro.responseText); 
                                                $("#protocoloPabellon").css("z-index","1500"); 
                                                jError("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                $('#PDF_VERDOC').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                            },
        success		:   function(aData)     { 
                                                console.log("---------------------------------------------");
                                                console.log(aData);
                                                console.log("---------------------------------------------");
                                                /*
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
                                                    $('#PDF_VERDOC').html(Objpdf);
                                                }
                                                */
                                            }, 
    });
}
