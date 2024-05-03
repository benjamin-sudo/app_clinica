function ws_etapa_analitica(option){
    //console.log("*************************************************************");
    //console.log("**** function ws_etapa_analitica ****");
    var sala_analitica              =   $("#get_sala").val();
    var getws                       =   [];
    getws.push("option="+option);
    getws.push("empresa="+$(".info_userdata").data("userdata").COD_ESTAB);
    getws.push("unique="+$(".info_userdata").data("userdata").unique);
    getws.push("get_sala="+sala_analitica);
    var ruta                        =   '';
    var obj_socket                  =   '';
    //const socket                  =   [];
    //if($("#SERVER_NAME").val() == '10.5.183.210'){
        //ruta                      =   "http://10.5.139.140:3000/ws_anatomia_etapaanalitica";
    //} else {
        ruta                        =   "https://qa.esissan.cl/ws_anatomia_etapaanalitica";
    //}
    //console.log("---------------------------------------------------------------------------");
    //console.log("ruta             ->  ",ruta);
    obj_socket                      =   io.connect(ruta,{secure:true,query:getws.join("&")});
    //console.log("-----------------------------------------------");
    //console.log("---------ws_etapa_analitica--------------------");
    //console.log("ruta             ->  ",ruta,"        <-      ");
    //console.log("socket           ->  ",ruta,obj_socket);
    //console.log("-----------------------------------------------");
    ws_cambios_estados_anatomia_patologica(obj_socket);
    //ws_load_ingreso_etapa_analitica(socket);
    //ws_update_chat_analitico(socket);
}

function js_test_ws(){
    localStorage.setItem("ind_tipo_mensaje",0);
    localStorage.setItem("ind_estapa_analitica",0);
    localStorage.setItem("num_fichae",null);
    localStorage.setItem("id_anatomia",null);
    localStorage.setItem("txt_name_biopsia",null);
    localStorage.setItem("span_tipo_busqueda",null);
    $("#load_anuncios_anatomia_patologica").submit();
}

//*********************************************************
//LEYENDA
//0 MENSAJE TEST
//1 RECEPCION DE MUESTRAS
//2 TERMINO DE PROCESO MACROSCOPICA
//3 INICIO TIEMPO EN SALA DE INCLUSION
//4 TERMINO TIEMPO EN SALA DE INCLUSION - INICIO SALA TECNICAS
//5 TERMINO SALA TECNICAS - INICIO DE SALA DE PATOLOGO
//6 FINALIZA SALA DE PATOLOGO
//*********************************************************
function ws_cambios_estados_anatomia_patologica(socket){
    socket.on('ssan_anatomia_patologica:recibe_anuncio_analitica',function(data){
        console.log("----------------------------------------------------");
        console.log("ssan_anatomia_patologica:recibe_anuncio_analitica");
        console.log("data       ->      ",data);
        //console.log("----------------------------------------------------");
        var get_sala                            =   $("#get_sala").val();
        var v_tabs_open                         =   get_sala == 'sala_recepcion_muestras'?'':localStorage.getItem("storange_tabs_main");
        //console.log("v_tabs_open                ->  ",v_tabs_open);
        //var txt_num_anatomis                  =   data['txt_name_biopsia'];
        if(data['ind_tipo_mensaje']             ==  1){
            showNotification('top','left','Nueva recepci&oacute;n de muestras anatom&iacute;a',1,'fa fa-check-circle');
            if(get_sala == 'sala_recepcion_muestras'){  
                UPDATE_PANEL(); 
            } else { 
                //PREGUNTAR SI BUSCANDO POR FECHAS O POR BUSQUEDA INDIVUAL
                if (v_tabs_open == '#_panel_por_fecha'){
                    update_etapaanalitica();
                }
            }
        } else if(data['ind_tipo_mensaje']      ==  2){
            var txt_numeros_update              =   data['txt_name_biopsia'];
            showNotification('top','left', txt_numeros_update+', ha cambiado de estado (Sala macrosc&oacute;pica a sala de proceso)',2,'fa fa-check-circle');
            if (  $(".css_lista_ordenada").hasClass("solicitud_"+data['id_anatomia']) && data['span_tipo_busqueda']  ==  v_tabs_open ){
                showNotification('top','left','Se actualizo listado de biopsias',1,'fa fa-refresh');
                //solo rango de fechas
                update_etapaanalitica();
            }
        } else if(data['ind_tipo_mensaje']      ==  3){
            var txt_numeros_update      =   data['txt_name_biopsia'];
            showNotification('top','left', txt_numeros_update+', Se ha iniciado tiempo en sala de proceso',2,'fa fa-check-circle');
            if (  $(".css_lista_ordenada").hasClass("solicitud_"+data['id_anatomia']) && data['span_tipo_busqueda']  ==  v_tabs_open ){
                showNotification('top','left','Se actualizo listado de biopsias',1,'fa fa-refresh');
                //solo rango de fechas
                update_etapaanalitica();
            }
        } else if(data['ind_tipo_mensaje']      ==  4){
            var txt_numeros_update      =   data['txt_name_biopsia'];
            showNotification('top','left', txt_numeros_update+', Se finaliz&oacute; en sala de proceso y paso a sala de inclusi&oacute;n',2,'fa fa-check-circle');
            if (  $(".css_lista_ordenada").hasClass("solicitud_"+data['id_anatomia']) && data['span_tipo_busqueda']  ==  v_tabs_open ){
                showNotification('top','left','Se actualizo listado de biopsias',1,'fa fa-refresh');
                //solo rango de fechas
                update_etapaanalitica();
            }
        } else if(data['ind_tipo_mensaje']      ==  5){
            var txt_numeros_update      =   data['txt_name_biopsia'];
            showNotification('top','left', txt_numeros_update+', Se finaliz&oacute; en sala de tecnicas y pasa a oficina de patologo',2,'fa fa-check-circle');
            if (  $(".css_lista_ordenada").hasClass("solicitud_"+data['id_anatomia']) && data['span_tipo_busqueda']  ==  v_tabs_open ){
                showNotification('top','left','Se actualizo listado de biopsias',1,'fa fa-refresh');
                //solo rango de fechas
                update_etapaanalitica();
            }
        } else if(data['ind_tipo_mensaje']      ==  6){
            var txt_numeros_update      =   data['txt_name_biopsia'];
            showNotification('top','left', txt_numeros_update+', Se finaliz&oacute; gesti&oacute;n oficina de pat&oacute;logo, ya disponible informe final',2,'fa fa-check-circle');
             if (  $(".css_lista_ordenada").hasClass("solicitud_"+data['id_anatomia']) && data['span_tipo_busqueda']  ==  v_tabs_open ){
                showNotification('top','left','Se actualizo listado de biopsias',1,'fa fa-refresh');
                //solo rango de fechas
                update_etapaanalitica();
            }
        } else if(data['ind_tipo_mensaje']      ==  7){
            var txt_numeros_update      =   data['txt_name_biopsia'];
            showNotification('top','left', txt_numeros_update+', Se actualizo informaci&oacute; por perfil administrativo',2,'fa fa-check-circle');
            if (  $(".css_lista_ordenada").hasClass("solicitud_"+data['id_anatomia']) && data['span_tipo_busqueda']  ==  v_tabs_open ){
                showNotification('top','left','Se actualizo listado de biopsias',1,'fa fa-refresh');
                //solo rango de fechas
                update_etapaanalitica();
            }
        } else {
            showNotification('top','left','test ws',1,'fa fa-bell-o');
        }
    });
    $(document).on('submit','#load_anuncios_anatomia_patologica',function(event){
        //console.log("event  -> ",event);
        event.preventDefault();
        console.log("submit         ->  ","actualizacion_hoja_diaria    ->  ",event);
        socket.emit('ssan_anatomia_patologica:envio_anuncio_analitica',{
            ind_tipo_mensaje        :   localStorage.getItem("ind_tipo_mensaje"),
            ind_estapa_analitica    :   localStorage.getItem("ind_estapa_analitica"),
            num_fichae              :   localStorage.getItem("num_fichae"),
            id_anatomia             :   localStorage.getItem("id_anatomia"),
            txt_name_biopsia        :   localStorage.getItem("txt_name_biopsia"),
            span_tipo_busqueda      :   localStorage.getItem("span_tipo_busqueda") 
        });
        localStorage.removeItem('ind_tipo_mensaje');
        localStorage.removeItem('ind_estapa_analitica');
        localStorage.removeItem('num_fichae');
        localStorage.removeItem('id_anatomia');
        localStorage.removeItem('txt_name_biopsia');
        localStorage.removeItem('span_tipo_busqueda');
        return false; 
    });
}

function get_numeros_asociados(id_anatomia){
    var get_num     = [];
    $(".num_biospias_"+id_anatomia).data('n_biopsia')   ==''?'':get_num.push("N&deg; Biopsia "+$(".num_biospias_"+id_anatomia).data('n_biopsia'));
    $(".num_biospias_"+id_anatomia).data('n_citologia') ==''?'':get_num.push("N&deg; Cit&oacute;logico "+$(".num_biospias_"+id_anatomia).data('n_citologia'));
    $(".num_biospias_"+id_anatomia).data('n_pap')       ==''?'':get_num.push("N&deg; PAP "+$(".num_biospias_"+id_anatomia).data('n_pap'));
    //console.log("   ------------------------------  ");
    //console.log("   get_num     ->  ",get_num);
    return get_num;
}

function ws_update_chat_analitico(socket){
    $(document).on('submit','#update_chat_x_hoja',function(event){
        event.preventDefault();
        var id_anatomia             =   localStorage.getItem("id_anatomia_x_chat");
        console.log("id_anatomia    =>  ",id_anatomia);
        var load_informacion    =   [{
                                        id_anatomia         :   id_anatomia,
                                        style               :   1,
                                        user                :   $(".info_userdata").data().userdata.NAMESESSION,
                                        ip                  :   $(".info_userdata").data().userdata.IP,
                                        unique              :   $(".info_userdata").data().userdata.unique,
                                        empresa             :   $(".info_userdata").data().userdata.COD_ESTAB,
                                    }];
        socket.emit('ssan_anatomia_patologica:update_chat_anatomia',load_informacion);
        return false;
    });
    socket.on('ssan_anatomia_patologica:actualiza_lista_chat',function(data){
        console.log("data   ->  ",data);
        //showNotification('bottom','right','Ingreso nueva solicitud a etapa analÃ­tica',1,'fa fa-paper-plane-o');
    });
}

function ws_load_ingreso_etapa_analitica(socket){
    socket.on('ssan_anatomia_patologica:ingreso_etapa_analitica',function(data){
        console.log("data->",data);
        showNotification('bottom','right','Ingreso nueva solicitud a etapa analÃ­tica',1,'fa fa-paper-plane-o');
        update_etapaanalitica();
    });
}

//ws envio y recepcion
function load_envio_a_recepcion_ws(option){
    //console.log("function load_envio_a_recepcion_ws -> ",option);
    var getws   =   [];
    getws.push("option="+option);
    getws.push("empresa="+$(".info_userdata").data("userdata").COD_ESTAB);
    getws.push("unique="+$(".info_userdata").data("userdata").unique);
    var socket = io.connect("http://10.5.139.140:3000/ssan_anatomia_patologica_recepcion_muestras",{secure:true,query:getws.join("&")}); 
    //leyenda | option
    //0 - ssan_libro_biopsias_listaexterno1 (clientes)
    //1 - ssan_libro_biopsias_ii_fase (recepcion)
    option===0?
    conf_envio_solicitud_recepcion(socket):
    conf_recepcion_solicitud(socket);
}

function conf_envio_solicitud_recepcion(socket){
    //*************************
    //ESCUCHANDO CONFIRMA ENVIO
    //*************************
    $(document).on('submit','#load_confirma_envio_recepcion',function(event){
        event.preventDefault();
        var load_informacion    =   [{
                                        style               :   1,
                                        user                :   $(".info_userdata").data().userdata.NAMESESSION,
                                        ip                  :   $(".info_userdata").data().userdata.IP,
                                        unique              :   $(".info_userdata").data().userdata.unique,
                                        empresa             :   $(".info_userdata").data().userdata.COD_ESTAB,
                                        /*
                                        ind_profesional     :   $("#ListProfesionales_Select_1").val(),
                                        txt_profesional     :   $("#ListProfesionales_Select_1 option:selected").text(),
                                        txt_name_citado     :   txt_name_citado,
                                        fecha_citacion      :   fecha_citacion,
                                        hora_citacion       :   hora_citacion,
                                        */
                                    }];
        //console.log("   submit -> load_confirma_envio_recepcion ->",load_informacion);
        socket.emit('ssan_anatomia_patologica:envio_recepcion_anatomia',load_informacion);
        return false;
    });
}

function conf_recepcion_solicitud(socket){
    //escuchando
    //mensaje con broadcast
    //console.log("conf_recepcion_solicitud -> escuchando -> ssan_anatomia_patologica:conf_recepcion_solicitud");
    socket.on('ssan_anatomia_patologica:conf_recepcion_solicitud',function(data){
        showNotification('bottom','right','Nueva solicitud',1,'fa fa-paper-plane-o');
        UPDATE_PANEL();
    });
}