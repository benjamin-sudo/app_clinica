$(document).ready(function() {
   
   console.log( "ready!" );
   star_ws_general(1);

});


function star_ws_general(option){
   let getws = [];
   getws.push("unique=543");
   getws.push("empresa=100");
   getws.push("ID_UID=65");
   //console.log("-------------------------------------------------");
   //console.log("REMOTE_ADDR   -> " , $("#REMOTE_ADDR").val());
   //console.log(getws);
   //console.log("-------------------------------------------------");
   let conn_ws                      =  "";
   //let conn_proxy                 =  "";
   localStorage.removeItem('ind_origen_instancia');
   
   conn_ws                       =  "https://192.168.1.14:3000/instancia_hall_central";
    localStorage.setItem("ind_origen_instancia",1);

   /*
   console.log("  -----------------------------------------------   ");
   console.log("  -----    10.68.159.13   zona_program   --------   ");
   console.log("  -----    10.69.76.39    producion      --------   ");
   console.log("  ------   conn_ws        -> ",conn_ws);
   console.log("  ------   origen         -> ",localStorage.getItem("ind_origen_instancia"));
   console.log("  -----------------------------------------------   ");
   */

    console.log("holaaa");
    console.log("conn_ws ->",conn_ws);



   const obj_socket           =  io(conn_ws,{
      reconnection            :  true,
      reconnectionDelay       :  50000,
      transports              :  ["websocket"],
      secure                  :  false,
      //rejectUnauthorized    :  false, 
      //forceNew              :  true,
      query                   :  getws.join("&"),
   });

   obj_socket.on('connect',()=>{
      //console.log("---------------------------------------------");
      //console.log("obj_socket    -> ",obj_socket);
      //console.log("---------------------------------------------");
      let txt_localhost_instancia   =  "";
      if(localStorage.getItem("ind_origen_instancia") == 1){
         txt_localhost_instancia    =  conn_ws;
      }
      showNotification('top','center','Conexi&oacute;n con instancia de de hall central : '+txt_localhost_instancia,2,'fa fa-plug');
      //ws_escucha_entrada(obj_socket);
      ws_manda_imprimir(obj_socket);
      
      /*
      ws_avisa_cambio_pacientes(obj_socket);
      ws_escucha_cambios_hospi(obj_socket);
      ws_print_otrasvisitas(obj_socket);
      ws_emite_cambio_visitante(obj_socket);
      ws_escucha_cambios_visitantes(obj_socket);
      ws_emite_cambio_encurso(obj_socket);
      ws_escuha_cambio_encurso(obj_socket);
      ws_cambio_estado_visitantes(obj_socket);
      ws_escuchando_estado_visitantes(obj_socket);
      */
   });
   obj_socket.on('error',(error)=>{
      console.log("  error -> ",error);
      showNotification('top','center',conn_ws+' <br> Error en la conexi&oacute;n al nodo - error',4,'fa fa-server');
   });
   obj_socket.on('connect_error',(error)=>{
      console.log("  error -> ",error);
      showNotification('top','center',' Error en la conexi&oacute;n al nodo - connect_error <br>'+conn_ws,4,'fa fa-server');
   });
   obj_socket.io.on("reconnect", (error) => {
      console.log("  error -> ",error);
      showNotification('top','center',' Error en la conexi&oacute;n al nodo  - reconnect',4,'fa fa-server');
   });
   obj_socket.io.on("reconnect_failed", (error) => {
      console.log("  error -> ",error);
   });
   obj_socket.io.on("reconnect_error", (error) => {
      console.log("  error -> ",error);
   });
}

function js_mandaraimprimir(VISITA_ID,NUM_HOSPITALIZA,ID_PERSONA){
   const id_print = $("#ind_disponitivos_llamada").val();
   if(id_print === null){
      showNotification('top','center','Debe seleccionar tÃ³tem con impresora',4,'fa fa-thumbs-down');
      return false;
   }
   localStorage.setItem("arr_hospitalizado",NUM_HOSPITALIZA);
   localStorage.setItem("arr_visita",VISITA_ID);
   localStorage.setItem("arr_id_persona",ID_PERSONA);
   localStorage.setItem("ind_opcion_print",2);
   $("#get_mandar_a_imprimir").submit();
}


function ws_manda_imprimir(obj_socket){
   $(document).on('submit','#get_mandar_a_imprimir',function(e){
      e.preventDefault();
      let _room                         =  [];
      _room.push($("#ind_disponitivos_llamada").val());
      
      if (_room === null) {
         showNotification('top','center','Debe seleccionar t&oacute;tem con impresora',4,'fa fa-thumbs-down');
         return false;
      }
      let NUM_HOSPITALIZA                 =  localStorage.getItem("arr_hospitalizado");
      let VISITA_ID                       =  localStorage.getItem("arr_visita");
      let arr_id_persona                  =  localStorage.getItem("arr_id_persona");
      console.log("NUM_HOSPITALIZA        -> ",NUM_HOSPITALIZA);
      console.log("VISITA_ID              -> ",VISITA_ID);
      console.log("arr_id_persona         -> ",arr_id_persona);
      let arr_hospitalizado               =  $("#en_curso_"+NUM_HOSPITALIZA).data('vista');
      let arr_visita                      =  $("#data_visita_"+arr_id_persona).data('info');
      let num_tarjeta                     =  $("#num_tarjeta_"+arr_id_persona).val()==""?"0":$("#num_tarjeta_"+arr_id_persona).val();
      arr_visita.NUM_TARJETA              =  num_tarjeta;
      const v_call_llamada                =  {
                                              txt_room : _room,
                                              nombre_paciente : "BENJAMIN NELSON CASTILLO SEPULVEDA",
                                              run_paciente : '16869726-0',
                                              v_piso : 'ZOCALO',
                                              v_cama : 'CAMA 1',
                                              v_servicio : 'UTI PEDIATRICA',
                                              v_id_ticke : '123',
                                              v_nombre_visitante : 'DANIELA BARRIA JARA',
                                              v_run_visita : '12312312-3',
                                              v_date_llegada : '12-12-1212 12:11:34',
                                              v_inicio_visita : '12-12-1212 12:11:35',
                                              v_final_visita : '12-12-1212 12:11:35',
                                              v_hospitalizado : '123',
                                              v_tiempo_aprox : '00:12:00',
                                              NUM_TARJETA :'4',
                                              name_sesion : 'TETE CASTILLO BARRIA',
                                          };
      console.error("v_call_llamada = ",v_call_llamada);
      showNotification('top','center','Se envi&oacute; impresi&oacute;n',1,'fa fa-print');   
      obj_socket.emit('ws_hall_central:print_hospitalizado',v_call_llamada);
      deshabilitarYCambiarIconos();
    });
}

function deshabilitarYCambiarIconos() {
    var botones = document.querySelectorAll('.txt_manda_imprimir');
    botones.forEach(function(boton) {
        boton.disabled = true;
        boton.innerHTML = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';
    });
    setTimeout(function() {
        botones.forEach(function(boton) {
            boton.disabled = false;
            boton.innerHTML = '<i class="fa fa-print" aria-hidden="true"></i>';
        });
    }, 5000);
}
