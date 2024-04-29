$(document).ready(function(){
    console.log("-----------------------------------------------------------");
    console.log("   e                   ->  ssan_libro_biopsias_i_fase      ");
    console.log("   f                   ->  ssan_libro_biopsias_ii_fase     ");
    console.error("NUM_FASE->",$("#NUM_FASE").val());
    console.log("-----------------------------------------------------------");
    //console.log("     RESOLUCION DE PANTALLA                              ");
    //console.log("     width       ->  ",screen.width,"                    ");
    //console.log("     height      ->  ",screen.height,"                   ");
    //console.log("---------------------------------------------------------");
    //RECEPCION DE MUESTRAS - VENTANILLAS
    if($("#NUM_FASE").val()             ==  2){
        var todayDate                   =   new Date().getDate();
        var date_inicio                 =   $("#date_inicio").val();
        console.log("date_inicio        ->  ",date_inicio);
        $('#fecha_out').datetimepicker({
            useCurrent                  :   false,//esto es importante ya que las funciones establecen el valor de fecha predeterminado en el valor actual
            inline			:   true,
            sideBySide                  :   true,
            format			:   'DD-MM-YYYY',
            locale			:   'es-us',
            maxDate                     :   new Date(),
            defaultDate                 :   moment(date_inicio)._d,
            icons			: 
                                        {
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
        $('#fecha_out').on('dp.change',function(e){ 
            $('#fecha_out2').data("DateTimePicker").minDate($('#fecha_out').data().date);
            UPDATE_PANEL();
        });
        var date_final                  =   $("#date_final").val();
        console.log("date_final         ->  ",date_final);
        $('#fecha_out2').datetimepicker({
            useCurrent                  :   false,//esto es importante ya que las funciones establecen el valor de fecha predeterminado en el valor actual
            inline			:   true,
            sideBySide                  :   true,
            format			:   'DD-MM-YYYY',
            locale			:   'es-us',
            defaultDate                 :   moment(date_final)._d,
            maxDate                     :   new Date(),
            minDate                     :   moment(date_inicio)._d,
            icons			: 
                                        {
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
            UPDATE_PANEL();
        });
        $(".timepicker").remove();
    } else {
        var todayDate               =   new Date().getDate();
        $("#date_txt_fec_inicio").datetimepicker({
            format                  :   'DD-MM-YYYY',
            minDate                 :   new Date(new Date().setDate((todayDate)-(30))), 
            //maxDate               :   new Date(),
            locale                  :   'es-us',
            icons                   :   
                                        {
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
        }).on('dp.change',function(e){
            UPDATE_PANEL();
        });
        $("#date_txt_fec_fin").datetimepicker({
            format                  :   'DD-MM-YYYY',
            minDate                 :   new Date(new Date().setDate((todayDate)-(30))), 
            //maxDate               :   new Date(),
            locale                  :   'es-us',
            icons                   :   
                                        {
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
        }).on('dp.change',function(e){
            UPDATE_PANEL();
        });
    }

    $('#busq_rutpac').Rut({
                                            on_error                    :   function(){
                                                $('#ErrorRutBUSQUEDA_').html('Rut Incorrecto');
                                                $("#ErrorRutBUSQUEDA_").show('slow').fadeOut('slow').fadeIn('slow');
                                                //$("#Corr").val('1');
                                                swal("Run No Valido", "SOLICITUDES", 'error');
                                            },
                                            on_success              :   function(){
                                                $('#ErrorRutBUSQUEDA_').html('');
                                                $("#ErrorRutBUSQUEDA_").hide('slow');
                                                Buscador_();
                                            },
                                            format_on               :   'keyup'
    });
    $("#modal_encustodia_ap").on('hidden.bs.modal',function(e){ 
        $("#html_modal_encustodia_ap").html(''); 
    });
    if($("#NUM_FASE").val() == 2){
        //$("#LOAD_CALENDARIO").hide();
        $(".LOAD_CALENDARIO").hide();
        $('#MAIN_NAV a[href="#tabs_listado"]').tab('show');
        console.log("star ws -> RECEPCION DE MUESTRAS <- ");
        //load_envio_a_recepcion_ws(1);
    }
    
    //console.log("-----------------------------------------------");
    //console.log("       cambios para victoria 12.01.2023        ");

    $('#modal_gestion_tomamuestraxuser').on('show.bs.modal',function(e){ 
        $('.class_gestion_tomamuestraxuser .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.class_gestion_tomamuestraxuser .modal-body').css('max-height',_height);
        $('.class_gestion_tomamuestraxuser .modal-body').css('min-height',_height);
    });

    $('#modal_clave_esissan_ap').on('show.bs.modal',function(e){ 
        $('.class_gestion_tomamuestraxuser .modal-body').css('overflow-y','auto'); 
        var _height = $(window).height()*0.8;
        $('.class_clave_esissan_ap .modal-body').css('max-height',_height);
        $('.class_clave_esissan_ap .modal-body').css('min-height',_height);
    });
    //ws_etapa_analitica(0);
});

function js_ws_test(){
    console.log("load_confirma_envio_recepcion  ->  submit");
    $("#load_confirma_envio_recepcion").submit();
}


//UPDATE ANTES DE LA RECEPCION
function UPDATE_PANEL(){
    var fecha_form          =   $("#NUM_FASE").val()==1?$("#txt_fec_inicio").val():fecha_cale('fecha_out');
    var fecha_to            =   $("#NUM_FASE").val()==1?$("#txt_fec_fin").val():fecha_cale('fecha_out2');
    console.log("NUM_FASE   ->  ",$("#NUM_FASE").val());
    $('#loadFade').modal('show');
    /*
    console.log("-------------------------------------------------------");
    console.log("   NUM_FASE        ->",$("#NUM_FASE").val(),"<-        ");
    console.log("   IND_TEMPLETE    ->",$("#IND_TEMPLETE").val(),"<-    ");
    console.log("   fecha_form      ->",fecha_form,"<-                  ");
    console.log("   fecha_to        ->",fecha_to,"<-                    ");
    console.log("-------------------------------------------------------");
    */
    if($("#IND_TEMPLETE").val() == 'ssan_libro_biopsias_i_fase'){
        console.log("ssan_libro_biopsias_i_fase");
        //BUSQUEDA LISTA ANTES DE RECEPCION
        $.ajax({ 
            type            :   "POST",
            url             :   "ssan_libro_biopsias_i_fase/update_fase1",
            dataType        :   "json",
            beforeSend      :   function(xhr)           { 
                                                            //console.log(xhr); 
                                                        },
            data		:                       { 
                                                            fecha_form      :   fecha_form,
                                                            fecha_to        :   fecha_to,
                                                            NUM_FASE        :   $("#NUM_FASE").val(),
                                                        },
            error		:   function(errro)	{  
                                                            console.log(errro); 
                                                            console.log(errro.responseText);
                                                            jError("Error del aplicativo","e-SISSAN"); 
                                                            $('#loadFade').modal('hide');
                                                        },
            success		:   function(aData)     {   
                                                            $('#loadFade').modal('hide');
                                                            $(".LISTA_BODY_1,.LISTA_BODY_2,.NO_INFORMACION").remove();
                                                            $("#LI_LISTA_MAIN").append(aData["HTML"]);
                                                            $('[data-toggle="tooltip"]').tooltip();
                                                        }, 
        });
    } else {
        console.log("ssan_libro_biopsias_ii_fase");
        $.ajax({ 
            type            :   "POST",
            url             :   "ssan_libro_biopsias_listaexterno1/update_main",
            dataType        :   "json",
            beforeSend      :   function(xhr)       { 
                                                        //console.log(xhr);
                                                    },
            data		:                       { 
                                                        fecha_inicio        :   fecha_form,
                                                        fecha_final         :   fecha_to,
                                                        OPTION              :   1,
                                                        pto_entrega         :   0 ,
                                                        origen_sol          :   0,
                                                        ind_template        :   $("#IND_TEMPLETE").val(),
                                                        NUM_FASE            :   $("#NUM_FASE").val(),
                                                    },
            error		:   function(errro)	{  
                                                        console.log(errro); 
                                                        console.log(errro.responseText);
                                                        jError("Error del aplicativo","e-SISSAN");
                                                        $('#loadFade').modal('hide');
                                                    },
            success		:   function(aData) {   
                                                        console.log("-------------------------------");
                                                        console.log("---------our update_main ------");
                                                        console.log(aData);
                                                        console.log("-------------------------------");
                                                        
                                                        $('#loadFade').modal('hide');
                                                        $(".LISTA_BODY_1,.LISTA_BODY_2,.NO_INFORMACION,.li_lista_externo_rce").remove();
                                                        $("#LI_LISTA_MAIN").append(aData.STATUS_OUT);
                                                        $("[data-toggle='tooltip']").tooltip();
                                                    }, 
        });
    }
}

function js_encustodia(){
    $.ajax({ 
        type		:   "POST",
        url		:   "ssan_libro_biopsias_i_fase/en_custodia_anatomiapatologica",
        dataType	:   "json",
	beforeSend      :   function(xhr)       { 
                                                    //console.log(xhr); 
                                                },
	data		:                       { 
                                                    fecha       :   $("#numFecha").val(),
                                                    OPTION      :   $("#TIPO_PABELLON").val(),
                                                },
        error		:   function(errro)	{  
                                                    console.log(errro); 
                                                    console.log(errro.responseText);
                                                    jError("Error del aplicativo","e-SISSAN"); 
                                                },
        success		:   function(aData)	{   
                                                    $("#modal_encustodia_ap").modal({backdrop:'static',keyboard:false}).modal("show");
                                                    $("#html_modal_encustodia_ap").html('');
                                                    $("#html_modal_encustodia_ap").html(aData.HTML);
                                                }, 
    });
}

function activar_pist(){
   $('#comenzar_nsolicitud_pistola').keypress(function(e) {
      if(e.which == 13){  
            console.log('enterr'); 
            num_solicitud_pistoleada();
        }
    });
    $('#comenzar_nmuestra_pistola').keypress(function(e) {
        if(e.which == 13){  
            console.log('enterr'); 
            num_muestra_pistoleada();
        }
    });
}

function num_muestra_pistoleada(){
    var errores='';
    var comenzar_nmuestra_pistola           =   $("#comenzar_nmuestra_pistola").val();
    comenzar_nmuestra_pistola               =   comenzar_nmuestra_pistola.replace("  ","_");///esto ya ke las muestras vendran con idsolicitud(espacio)idmuestra
    var  Sl_accion_a_realizar               =   $("#Sl_accion_a_realizar").val();
    if(comenzar_nmuestra_pistola==''){
        errores+="Falta indicar numero de muestra";   
    }
    if(Sl_accion_a_realizar==''){
        errores+="<br>Falta indicar tipo de proceso a realizar";   
    }
    if(errores!=''){ 
        showNotification('top', 'center', errores, 3, 'fa fa-times');
        return false;
    }else{
        //si todo esta ok entonces debo marcar
        $("#comenzar_nmuestra_pistola").val("");
        $("#ch_muestra_"+comenzar_nmuestra_pistola).prop("checked",true);
        $(".trs_muestras").removeClass("success");   
        $("#tr_data_de_muestra_"+comenzar_nmuestra_pistola).addClass("success");
    }
}

function num_solicitud_pistoleada(){
    var errores='';
    var comenzar_nmuestra_pistola           =   '';
    var comenzar_nsolicitud_pistola         =   $("#comenzar_nsolicitud_pistola").val();//MARCARA LAS MUESTRAS  IDSOLICITUD(ESPACIO ESPACIO)IDMUESTRA
    var Sl_accion_a_realizar                =   $("#Sl_accion_a_realizar").val();

    if(comenzar_nsolicitud_pistola==''){
       errores                              +=  "Falta indicar numero de solicitud";   
    }
    if(Sl_accion_a_realizar==''){
       errores                              +=  "<br>Falta indicar tipo de proceso a realizar";   
    }

    if(Sl_accion_a_realizar==100 || Sl_accion_a_realizar==''){
       $("#tr_btn_guardar_1").hide();
    } else {
       $("#tr_btn_guardar_1").show();
    }

    ///AGREGAR NUEVO PARA ID SOLICITUD
    var pistoleada                          =   comenzar_nsolicitud_pistola.split("  ");
    
    if($("#dv_pistoleada_solicitud_"+pistoleada[0]).length){
        /*
        console.log("---------------------------------------------------------");
        console.log("_existe y estoy buscando la muestra    :   "+pistoleada[1]);
        console.log("---------------------------------------------------------");
        */ 
        //si el id solicitud ya existe entonces debo mnarcar radiod e la mustra
        //si el id solicitud ya existe entonces debo mnarcar radiod e la mustra
        $("#ch_muestra_"+pistoleada[0]+"_"+pistoleada[1]).prop("checked",true);   
        $(".trs_muestras").removeClass("verde"); //resalta solo la ke pistolie  
        $("#tr_data_de_muestra_"+pistoleada[0]+"_"+pistoleada[1]).removeClass("rojo");

        $("#tr_data_de_muestra_"+pistoleada[0]+"_"+pistoleada[1]).addClass("success");
        $("#tr_data_de_muestra_"+pistoleada[0]+"_"+pistoleada[1]).addClass("verde");

        //si el id solicitud ya existe entonces debo mnarcar radiod e la mustra
        //si el id solicitud ya existe entonces debo mnarcar radiod e la mustra
    }

    comenzar_nsolicitud_pistola     =   pistoleada[0]; 
    comenzar_nmuestra_pistola       =   pistoleada[1]; 
    
    var id                          =   "dv_pistoleada_solicitud_"+pistoleada[0]; //Div o ID de los resultados
    var funcion                     =   "trae_muestras_x_solicitud"; //Funcion del Controlador a Ejecutar
    var variables                   =   {
                                            comenzar_nsolicitud_pistola     :   comenzar_nsolicitud_pistola,
                                            Sl_accion_a_realizar            :   Sl_accion_a_realizar,
                                            comenzar_nmuestra_pistola       :   comenzar_nmuestra_pistola
                                        };
            
    if(errores!=''){ 
        showNotification('top','center',errores,3,'fa fa-times');
        return false;
    } else {
  
            $("#comenzar_nsolicitud_pistola").val("");
        if ($("#dv_pistoleada_solicitud_"+pistoleada[0]).length  ) {
            //si existe no busco en base   
            console.log("existeeeeeee2");
        } else {//si no esta entonces busco en base
            console.log("no exisstee222");
            $( "<div id='dv_pistoleada_solicitud_"+pistoleada[0]+"' style='border: solid 2px #7b7b7b;'></div>" ).appendTo("#html_modal_comenzar");
            AjaxExt(variables,id,funcion); //Funcion que Ejecuta la llamada del ajax
        }
    }
}

function pop_comenzar(){
   $('#modal_comenzar').modal('show'); 
   $("#comenzar_nsolicitud_pistola").focus();
   $("#html_modal_comenzar").html("");
   $("#headd2").hide();
   $("#headd3").hide();
   $("#cls_preg_2").hide();
   $("#Sl_accion_a_realizar").val("");
   $("#comenzar_nsolicitud_pistola").val("");
   $('.selectpicker').selectpicker('refresh');
   $("#tr_btn_guardar_1").hide("slow");
}

function Sl_accion_a_realizar(){
    $("#tr_btn_guardar_1").hide("slow");
    var Sl_accion_a_realizar=$("#Sl_accion_a_realizar").val();
    $("#headd2").hide();
    $("#html_modal_comenzar").html("");
    if(Sl_accion_a_realizar!=''){
        // $("#headd2").show("slow");
        // $("#headd3").hide();
        $("#headd3").show("slow");
        // $("#headd2").html('<h5 class="modal-title">FAVOR PISTOLEAR NUMERO DE SOLICITUD</h5><center><input style="width:50%" type="text" id="comenzar_nsolicitud_pistola" class="form-control"  ></center>');
        $("#headd3").html('<h5 class="modal-title">FAVOR PISTOLEAR NUMERO DE MUESTRAS</h5><center><input style="width:50%" type="text" id="comenzar_nsolicitud_pistola" class="form-control"  ></center>');
        activar_pist();
        setTimeout(function(){ $("#comenzar_nsolicitud_pistola").focus(); }, 1000);
    } else {
      $("#headd2").hide("slow");
      $("#headd3").hide("slow");
      $("#html_modal_comenzar").html("");
   }
}

function marcar_check(idsoicitud,idmuestra){

    if ($("#ch_muestra_"+idsoicitud+"_"+idmuestra).prop('checked') == true) {

        console.log("esta marcado");
        $(".trs_muestras").removeClass("verde"); //resalta solo la ke pistolie  
        $("#tr_data_de_muestra_"+idsoicitud+"_"+idmuestra).removeClass("rojo");

        $("#tr_data_de_muestra_"+idsoicitud+"_"+idmuestra).addClass("success");
        $("#tr_data_de_muestra_"+idsoicitud+"_"+idmuestra).addClass("verde");

        $("#sl_mot_rech_"+idmuestra).val("");
        $("#sl_mot_rech_"+idmuestra).prop("disabled",true);
        $('#sl_mot_rech_'+idmuestra).selectpicker('refresh');

    } else {  
        console.log("NO ESTA esta marcado");
        $(".trs_muestras").removeClass("verde"); //resalta solo la ke pistolie  
        $("#tr_data_de_muestra_"+idsoicitud+"_"+idmuestra).removeClass("success");    
        $("#tr_data_de_muestra_"+idsoicitud+"_"+idmuestra).addClass("rojo");

        $("#sl_mot_rech_"+idmuestra).prop("disabled",false);
        $('#sl_mot_rech_'+idmuestra).selectpicker('refresh');
    }
}

function Ver_historial_muestra(ID_SOLICITUD_HISTO,idmuestra){
    $("#txt_pop_num_muestra_hist").html(idmuestra);//NUMERITO EN EL TITULO DEL MODAL
    $('#modal_historial_MUESTRA').modal('show');    
   
    var id="html_modal_historial_MUESTRA"; //Div o ID de los resultados
    var funcion = "historial_recepciones_nohabil_x_muestra"; //Funcion del Controlador a Ejecutar
    var variables={ID_SOLICITUD_HISTO:ID_SOLICITUD_HISTO,idmuestra:idmuestra};
    AjaxExt(variables,id,funcion); //Funcion que Ejecuta la llamada del ajax
}

function desplega_td(num){
    if(num==1){
        $("#td_contenido_archivos").show('slow');
        $("#td_contenido_historial").hide('slow');
    }
    if(num==2){
        $("#td_contenido_archivos").hide('slow');
        $("#td_contenido_historial").show('slow');
    }
}

function Adjunta_img(ID_SOLICITUD_HISTO,idmuestra){
    $('#Adjuntaimg_modal').modal('show');
    var variables={ID_SOLICITUD_HISTO:ID_SOLICITUD_HISTO,idmuestra:idmuestra};
    var id="html_Adjuntaimg"; //Div o ID de los resultados
    var funcion = "Adjunta_img"; //Funcion del Controlador a Ejecutar
    AjaxExt(variables,id,funcion); //Funcion que Ejecuta la llamada del ajax
}

function subirImgsOtroArchivo(formulario,id_registro,ID_SOLICITUD_HISTO,idmuestra) {
   //numeroT=1 primera parte(verifica si tenemos registro)
   //numeroT=2 segunda parte.. directo a guardar la carpetaimagenPerfilOTRODOC

    console.log("_________idliubro:"+ID_SOLICITUD_HISTO);
    console.log("_________idmuestra:"+idmuestra);

    $("#idCorrelMUESTRA_idreg").val(id_registro);

    var nomarchivo      =   $("#nombre_archivo_asubir_img").val();

    if(nomarchivo==''){
       showNotification('top', 'center', 'Favor indicar nombre de archivo', 3, 'fa fa-times');
       return false;
    }

    if( $("#imagenPerfilOTRODOC").val()=='') {
        showNotification('top', 'center', 'Sin archivo para subir', 3, 'fa fa-times');
        return false;
    } else {
   
        var file = $("#imagenPerfilOTRODOC")[0].files[0];
        if (file != undefined){

        $('#id_btn_subirdoc').hide();
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensiÃƒÆ’Ã‚Â³n del archivo
        var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaÃƒÆ’Ã‚Â±o del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la informaciÃƒÆ’Ã‚Â³n del archivo
        //showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
        //$("#docs").append("<tr>><td>"+fileName+"</td><td>"+fileSize+" bytes.</td></tr>");

               //obtenemos un array con los datos del archivo

               //informaciÃƒÆ’Ã‚Â³n del formulario
               var formData = new FormData($("." + formulario)[0]);

               var message = "";
               //hacemos la peticiÃƒÆ’Ã‚Â³n ajax  
               $.ajax({
                   url: 'assets/ssan_libro_biopsias_i_fase/recibe_muestra.php',
                   type: 'POST',
                   // Form data
                   //datos del formulario
                   data: formData,
                   //necesario para subir archivos via ajax
                   cache: false,
                   contentType: false,
                   processData: false,
                   //mientras enviamos el archivo
                   beforeSend: function () {
                       message = "<span style='background-color:#68ff73;font-size:20px;'>Subiendo Archivos Adjuntos, por favor espere...</span>";
                       $("#dv_Mensaje_SUBIDAS_msj2").html(message);
                   },
                   //una vez finalizado correctamente
                   success: function (data) {
                       message = data;
                       //  jAlert(message);

                       if (message != "error") {
                           // console.log(message);
                         

                          RegistrarOtroArchSubida(message, id_registro,ID_SOLICITUD_HISTO,idmuestra,nomarchivo);///id_registro 196_249
                       } else {
                           // alert("ERROR AL CREAR EL ARCHIVO") 
                         
                             showNotification('top', 'center', 'ARCHIVO NO SUBIDO!!', 3, 'fa fa-times');
                           //$("#dv_Mensaje_SUBIDAS2").show();
                          
                       }

                   },
                   //si ha ocurrido un error
                   error: function () {
                    
                        showNotification('top', 'center', 'Ha ocurrido un error al subir el archivo', 3, 'fa fa-times');
                      
                       //jAlert(message);
                   }
               });
        } else {
            showNotification('top', 'center', 'EL USUARIO NO SELECCIONO UN ARCHIVO', 2, 'fa fa-check');
        }
    }
}

function RegistrarOtroArchSubida(message,id_reg,ID_SOLICITUD_HISTO,id_muestra,nomarchivo) {
    var id = "respuesta"; //Div o ID de los resultados
    var funcion = "GuardaSubidaOtroArch"; //Funcion del Controlador a Ejecutar
    var variables = {message: message, id_reg: id_reg,id_muestra:id_muestra,ID_SOLICITUD_HISTO:ID_SOLICITUD_HISTO,nomarchivo:nomarchivo}; //Variables pasadas por ajax a la funcion
    AjaxExt(variables, id, funcion);
}

function Ver_documentos_adjuntos(idlibro,idmuestra,nom_archivo){
    $('#pdf_modal').modal('show');   
    $('#html_adjuntos').html('<iframe src="assets/ssan_libro_biopsias_i_fase/upload_muestra/'+idlibro+'_'+idmuestra+'/'+nom_archivo+'" frameborder="0" style="overflow:hidden;height: 650px;width:100%;" width="100%"></iframe>');
}

function Guardar_proceso(op) {
    var algunosno_marcados      =   0;
    var algun_motivo_sinmarcar  =   0;
    var Sl_accion_a_realizar= $("#Sl_accion_a_realizar").val();
    //1 RECEPCIONAR MUESTRAS EN HORARIO NO HABIL
    //2 TRASLADAR MEUSTRAS A ANATOMIA PATOLOGICA
    var alguno=0;
    var Datos_MUESTRA = new Array();
    $('[id^=tr_data_de_muestra_]').each(function () {//tr_data_de_muestra_ idsolicitud_idmuestra
    alguno++;
    // arrpreg
    var objProducto             =   new Object();
    objProducto.h               =   $(this).attr('id');
    objProducto.h               =   objProducto.h.replace('tr_data_de_muestra_', '');
    var id_solicitud_idmuestra  =   objProducto.h.split("_");
    objProducto.idsolicitud     =   id_solicitud_idmuestra[0]; 
    objProducto.idmuestra       =   id_solicitud_idmuestra[1];

    //objProducto.id_muestra = $("#tr_data_de_muestra_"+idsolicitud+"_" + objProducto.h).data("id_muestra");
    objProducto.num_fichae = $("#tr_data_de_muestra_" + objProducto.idsolicitud+"_"+objProducto.idmuestra).data("num_fichae"); 
    objProducto.data_text_obs_ = $("#text_obs_" + objProducto.idmuestra).val(); 
    objProducto.sl_mot_rech = $("#sl_mot_rech_" + objProducto.idmuestra).val(); 

    if( $('#ch_muestra_'+objProducto.idsolicitud+"_"+objProducto.idmuestra).prop('checked') ) {
        objProducto.Resp =1;//marcado    
        if(objProducto.sl_mot_rech=='' && op==2){//si estan todos marcados pero el susuario indico RECHAZO SOLICITUD COMPLETA entonces deben poner motivo rechazo a todas
           algun_motivo_sinmarcar++;
        }
    } else {
        objProducto.Resp =2;  //no marcado
        algunosno_marcados++;
        console.log("nomarcado______________id_solicitud_idmuestra:"+objProducto.idsolicitud+"_"+objProducto.idmuestra);
        if(objProducto.sl_mot_rech==''){
          algun_motivo_sinmarcar++;
        }
    }     
        Datos_MUESTRA.push(objProducto);
    });


    //_solo encabezado
    //_solo encabezado
    //_solo encabezado
        
    var Datos_ENC       =   new Array();

    var Datos_det       =   new Array();
    
    $('[id^=dv_pistoleada_solicitud_]').each(function () {//tr_data_de_muestra_ idsolicitud_idmuestra
        // arrpreg
        var mRCADA_check        =   0;
        var objProducto         =   new Object();
        objProducto.h           =   $(this).attr('id');//ID_SOLICITUD
        objProducto.id_soli     =   objProducto.h.replace('dv_pistoleada_solicitud_', '');        
        //recorro todas las muestras de esta solicitud para ver que estado debotener para el ENCABEZADO
        $('[id^=tr_data_de_muestra_'+objProducto.id_soli+'_]').each(function () {//tr_data_de_muestra_ idsolicitud_idmuestra
        //arrpreg
            var objProductod = new Object();
            objProductod.hD = $(this).attr('id');
            objProductod.idmuestra_DD = objProductod.hD.replace('tr_data_de_muestra_'+objProducto.id_soli+'_', '');        
            if( $('#ch_muestra_'+objProducto.id_soli+'_'+objProductod.idmuestra_DD).prop('checked') ) {
               mRCADA_check++;
            }else{
               //no marca
            }     
            Datos_det.push(objProductod);
        });


        objProducto.mRCADA_check=mRCADA_check;
        Datos_ENC.push(objProducto);
    });
    
    //_solo encabezado
    //_solo encabezado
    //_solo encabezado
    
    if(alguno==0){
        swal("Falta indicar alguna muestra.", "SISTEMA", 'error');
        return false;
    }

    if(algunosno_marcados>0 && op==0){//hay algunos no marcados y no eh hecho la pregunta
        $("#cls_preg_2").show("slow");
        $("#tr_btn_guardar_1").hide("slow");
        return false;
    }

    if(op!=0 && algun_motivo_sinmarcar>0){//rechaza solicitud completa
       swal("Falta indicar motivo de rechazo en las muestras a rechazar.", "SISTEMA", 'error');
       return false;
    }

    //si todo sale bien a la primera y no hay cuadros sin marcar entonces guardo con la opciÃƒÂ³n (1) PROCESAR SOLICITUD
    if(op==0){
       op=1;//(1) PROCESAR SOLICITUD
    }
 
    jPrompt('Con esta acci&oacute;n se proceder&aacute; a realizar el registro de datos.<br /><br />&iquest;Est&aacute; seguro de continuar?', '', 'Confirmaci\u00f3n', function (r) {
    if(r) {
        var id = "respuesta"; //Div o ID de los resultados
        var funcion = "guardar_proceso"; //Funcion del Controlador a Ejecutar
        var variables = {Datos_MUESTRA:Datos_MUESTRA,Sl_accion_a_realizar:Sl_accion_a_realizar,op:op,Datos_ENC:Datos_ENC,Clave:r}; //Variables pasadas por ajax a la funcion
        AjaxExt(variables, id, funcion);
        $('#confirmar').prop('disabled', true);
    }});
}

function Buscador_(){
   $('#modal_busqueda').modal('show');
}

function buscar_buscador(){
    var num_solicitud       =   $("#busq_numsolicitud").val();
    var busq_nummuestra     =   $("#busq_nummuestra").val();
    var busq_rutpac         =   $("#busq_rutpac").val();
    var id                  =   "div_html_buscador"; //Div o ID de los resultados
    var funcion             =   "buscar_buscador"; //Funcion del Controlador a Ejecutar
    var variables           =   {num_solicitud:num_solicitud,busq_nummuestra:busq_nummuestra,busq_rutpac:busq_rutpac};
    AjaxExt(variables,id,funcion); //Funcion que Ejecuta la llamada del ajax
}

function pdf_solicitud(idsolicitud,idtabla){
    $('#pdf_modalSOLICITUD').modal('show');
    var nulsl               =   '';
    //src="assets/ssan_libro_biopsias_i_fase/upload_muestra/'+idlibro+'_'+idmuestra+'/'+nom_archivo+'"    http://10.5.183.210/pabellon_classpdf/solicitudHISTO_PAGINAS?id=null&idTabla=2813&letra=9
    $('#tb_TAB_PDF_SOLICITUD').html('<iframe src="http://10.5.183.210/pabellon_classpdf/pdf2?id='+idtabla+'&letra=9" frameborder="0" style="overflow:hidden;height: 650px;width:100%;" width="100%">PDF SOLICITUD + CODIGOS</iframe>');
    $('#tb_TAB_PDF_SOLICITUD2').html('<iframe src="http://10.5.183.210/pabellon_classpdf/solicitudHISTO_PAGINAS?id='+nulsl+'&idTabla='+idtabla+'&letra=9" frameborder="0" style="overflow:hidden;height: 650px;width:100%;" width="100%">PDF SOLICITUD + CODIGOS</iframe>');
}

function Carga_listado_pabellon(){
    var txt_fec_inicio      =   $("#txt_fec_inicio").val();
    var txt_fec_fin         =   $("#txt_fec_fin").val();
    var id                  =   "dv_para_tablapabellon"; //Div o ID de los resultados
    var funcion             =   "Carga_listado_pabellon"; //Funcion del Controlador a Ejecutar
    var variables           =   {txt_fec_inicio:txt_fec_inicio,txt_fec_fin:txt_fec_fin};
    //AjaxExt(variables,id,funcion); //Funcion que Ejecuta la llamada del ajax
}

function GET_PDF_ANATOMIA_PANEL(id){
   $("#Dv_verdocumentos").modal("show");
   $.ajax({ 
       type		:   "POST",
       url 		:   "ssan_spab_gestionlistaquirurgica/BLOB_PDF_ANATOMIA_PATOLOGICA",
       dataType        :   "json",
       beforeSend	:   function(xhr)           {   
                                                       console.log(xhr);
                                                       console.log("generando PDF");
                                                       $('#HTML_PDF_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF");
                                                   },
       data 		:       
                                                   { 
                                                       id  :   id,
                                                   },
       error		:   function(errro)         { 
                                                       console.log("quisas->",errro,"-error->",errro.responseText); 
                                                       $("#protocoloPabellon").css("z-index","1500"); 
                                                       jError("Error General, Consulte Al Administrador","e-SISSAN"); 
                                                       $('#HTML_PDF_ANATOMIA_PATOLOGICA').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
                                                   },
       success		:   function(aData)         { 

                                                       console.log("---------------------------------------------");
                                                       console.log(aData);
                                                       console.log("---------------------------------------------");

                                                       if(!aData["STATUS"]){
                                                           jError("error al cargar protocolo PDF","e-SISSAN");
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

                                                   }, 
   });
}

function PDF_NORECEP(correl){
   var rnadd    =   Math.floor((Math.random() * 900) + 1);
   var html     =   '<iframe src="pdf/pdf_comprobante_norecep?correl='+correl+'&r='+rnadd+'" frameborder="0" style="overflow:hidden;height: 650px;width:100%;" width="100%"></iframe>';
   $("#PDF_VERDOC").html(html);
   $("#Dv_verdocumentos").modal("show");
}

function Solicitar_activacion(idmues){
    var errores='';
    if(idmues==''){errores='<br>falta ingresar muestra';}
    var text_obs_=  $('#text_obs_'+idmues).val();
    if(text_obs_==''){errores='falta ingresar observaciÃƒÂ³n';}
    if(errores!=''){
       swal(errores, "SISTEMA", 'error');
    } else {
        jPrompt('Con esta acci&oacute;n se proceder&aacute; a realizar el registro de datos.<br /><br />&iquest;Est&aacute; seguro de continuar?', '', 'Confirmaci\u00f3n', function (r) {
            if (r) {
            var id="respuesta"; //Div o ID de los resultados
            var funcion = "Solicitar_activacion"; //Funcion del Controlador a Ejecutar
            var variables={idmues:idmues,text_obs_:text_obs_,Clave:r};
            AjaxExt(variables,id,funcion); //Funcion que Ejecuta la llamada del ajax
            $('#confirmar').prop('disabled', true);
        }});
    }
}

