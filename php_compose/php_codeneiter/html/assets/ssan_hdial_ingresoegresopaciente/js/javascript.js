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
      showNotification('top','center',' Error en la conexi&oacute;n al nodo - error',4,'fa fa-server');
   });
   obj_socket.on('connect_error',(error)=>{
      console.log("  error -> ",error);
      showNotification('top','center',' Error en la conexi&oacute;n al nodo - connect_error ',4,'fa fa-server');
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
   //localStorage.removeItem("arr_hospitalizado");
   //localStorage.removeItem("arr_visita");
   //localStorage.removeItem("arr_id_persona");
   localStorage.setItem("arr_hospitalizado",NUM_HOSPITALIZA);
   localStorage.setItem("arr_visita",VISITA_ID);
   localStorage.setItem("arr_id_persona",ID_PERSONA);
   localStorage.setItem("ind_opcion_print",2);
   $("#get_mandar_a_imprimir").submit();
}


function ws_manda_imprimir(obj_socket){
   $(document).on('submit','#get_mandar_a_imprimir',function(e){
      e.preventDefault();
      const _room                         =  $("#ind_disponitivos_llamada").val();
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
                                                txt_room    :  _room,
                                                v_id_uid    :  '342',
                                                v_name_s    :  'NAMESESSION', 
                                                arr_hosp    :  NUM_HOSPITALIZA,
                                                arr_visita  :  VISITA_ID,
                                                ind_print   :  localStorage.getItem("ind_opcion_print"),
                                                info_hosp   :  arr_hospitalizado,
                                                info_visi   :  arr_visita
                                             };
      console.log("v_call_llamada -> ",v_call_llamada);
      showNotification('top','center','Se envi&oacute; impresi&oacute;n',1,'fa fa-print');   
      obj_socket.emit('ws_hall_central:print_hospitalizado',v_call_llamada);
   });
}