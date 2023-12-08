$(function(){ 


   const triggerFirstTabEl = document.querySelector('#myTab li:first-child button');
   //console.log("triggerFirstTabEl   -> ",triggerFirstTabEl);
   if (triggerFirstTabEl) {
      let tab = bootstrap.Tab.getInstance(triggerFirstTabEl);
      if (!tab) {   tab = new bootstrap.Tab(triggerFirstTabEl);}
      tab.show();
   } else {
      console.error("No se encontró el primer tab.");
   }

   $('#run_esissan').Rut({
      on_error    :   function() {   
                                    jAlert('El Rut ingresado es Incorrecto. '+$("#run_esissan").val(), 'Rut Incorrecto'); 
                                    console.log($("#run_esissan").val());  
                                    $("#run_esissan").css('border-color','red'); 
                                    $("#run_esissan").val('') 
                                 },
      on_success  :   function(){   
                                    $("#run_esissan").css('border-color',''); valida_run_esissan(1); 
                                 },
      format_on   :   'keyup'
   });

   //https://getbootstrap.com/docs/5.3/getting-started/introduction/
   console.log("  ---------------------------------------------------------------   ");
   console.log("        bootstrap      -> ", bootstrap.Tooltip.VERSION,"            ");
   console.log("        jQuery         -> ", jQuery.fn.jquery,"                     ");
   console.log("        Codeigniter 4                                               ");
   console.log("  ---------------------------------------------------------------   ");

   $(".selectpicker").selectpicker();
   //showNotification('top','center','Conexi&oacute;n con instancia no iniciada',4,'fa fa-thumbs-down');
});


function valida_run_esissan(val)   {
   var _rut            =   "";
   var rut_array       =   "";
   var rut2            =   "";
   var rut             =   "";
   var dv              =   "";
   _rut                =   $("#run_esissan").val();
   $("#run_esissan").css('border-color','');
   if(_rut == ''){
        jError("RUN vac&iacute;o","e-SISSAN");
        $("#run_esissan").css('border-color','red');
        return false;
   }
   rut_array           =   _rut.split("-");
   rut2                =   rut_array[0].replace(".","");
   rut                 =   rut2.replace(".","");
   dv                  =   rut_array[1];
   console.log("rut    -> ",rut);
   console.log("dv     ->  ",dv);
   return false;
 
   $.ajax({ 
        type          :   "POST",
        url           :   "ssan_spab_gestionlistaquirurgica/fn_valida_cuenta_esissan",
        dataType      :   "json",
        beforeSend    :   function(xhr)           {   
                                                        console.log(xhr);
                                                        $('#loadFade').modal('show');
                                                    },
        data          :                           {  
                                                        run :   rut,
                                                        dv  :   dv,
                                                    },
        error         :   function(errro)         { 

                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","e-SISSAN"); 
                                                        $('#loadFade').modal('hide');
                                                        
                                                    },
        success          :   function(aData)         {   
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
                                                            showNotification('top','center','RUN ingresado no tiene cuenta e-SISSAN',4,'fa fa-times');
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











var normalize = (function() {
   var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
       to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
       mapping = {};
   for (var i = 0, j = from.length; i < j; i++)
       mapping[from.charAt(i)] = to.charAt(i);
   return function(str) {
       var ret = [];
       for (var i = 0, j = str.length; i < j; i++) {
           var c = str.charAt(i);
           if (mapping.hasOwnProperty(str.charAt(i)))
               ret.push(mapping[c]);
           else
               ret.push(c);
       }
       return ret.join('');
   }
})();


function test(val){
   $('#loadFade').modal('show');
   let arr_diagnisticos    =  [];
   //let ruta              =  "";
   $.ajax({ 
      type           :  "POST",
      url            :  "ssan_hl7_hlviifhir/test_hl7",
      dataType       :  "json",
      beforeSend     :  function(xhr)     {     },
      data		      :  { token : $("#token").val() },
      error		      :  function(errro)  {  
                                             console.log(errro);
                                             console.log(errro.responseText);  
                                             jAlert("Error General, Consulte Al Administrador"); 
                                             $('#loadFade').modal('hide');
                                          },
      success		   :   function(aData)  {  
                                             $('#loadFade').modal('hide');
                                             console.log("------------------------------------------");
                                             console.log("aData         -> ",aData);
                                             console.log("aData         -> ",aData.patient)
                                             if( aData && aData.respuesta && Array.isArray(aData.respuesta.issue) ){
                                                aData.respuesta.issue.forEach((row, index) => {
                                                   console.log("--------------------------------------------");
                                                   console.error("error          -> ",index);
                                                   console.error("row            -> ",row);
                                                   console.error("diagnostics    -> ",row.diagnostics);
                                                   arr_diagnisticos.push(index+" - "+row.diagnostics);
                                                   //$("#respuesta_hl7").append(aData.respuesta.text.div);
                                                });
                                            } else {
                                                console.log("SIn errores");
                                            }
                                             console.log(aData.jsonData);
                                             console.log("------------------------------------------");
                                             console.log(arr_diagnisticos.join("\n") );
                                             //*********************************************************** */
                                             //$("#respuesta_hl7").html(aData.respuesta.text.div);
                                             //showNotification('top','left',"Return",2,'fa fa-check-square');
                                          }, 
   });
}

function validaExt() {
   let nomExt     = $('#nomExt').val()
   let res        =  nomExt.trim();
   let ext        =  normalize(res);
   $('#nomArch').val(ext.replace(/\s+/g, ''));
   buscaExtArch();
}

function buscaExtArch() {
   var rutaactual    =  $('#nomArch').val();
   if (rutaactual    ==  "" || $('#nomExt').val() == ""){ return false; }
   //console.log("rutaactual ->",rutaactual);
   $('#loadFade').modal('show');
   $.ajax({ 
      type           : "POST",
      url            : "Home/buscaExtArch",
      dataType       : "json",
      beforeSend     :  function(xhr){ },
      data           :  { "rutaactual": rutaactual },
      error          :  function(errro)   {  
                                             console.log(errro);
                                             console.log(errro.responseText);  
                                             jAlert("Error General, Consulte Al Administrador"); 
                                             $('#loadFade').modal('hide');
                                          },
      success        :   function(aData)  {  
                                             $('#loadFade').modal('hide');
                                             console.log(aData);
                                             if (aData.status){
                                                $("#existeExt").val(0);
                                                muestraDirAr();
                                             } else {
                                                jError("El Nombre de la Extensión ya Existe<br>Favor Busque otro Nombre","Restricción");
                                                $("#nomExt").val('');
                                                $("#nomArch").val('');
                                                $("#existeExt").val(1);
                                                muestraDirAr();
                                             }
                                          }, 
   });
}

function js_pasardestino(){
   let origen = $("#origen").val();
   console.log("origen -> ",origen);
}

function muestraDirAr(){
   var ext = $('#nomExt').val();
   var idExt = $('#idExt').val();
   ext = ext.trim();
   //console.log("ext ->",ext.replace(/\s+/g,''));
   //console.log("idExt ->",idExt);
   var html = '<b>La extension generarÃ¡ los siguentes directorios y archivos:</b><br>'
         + '/application/controllers/' + ext + '.php<br>'
         + '/application/models/' + ext + '_model.php<br>'
         + '/application/view/' + ext + '_view/index.php<br>'
         + '/assets/' + ext + '/css/style.css<br>'
         + '/assets/' + ext + '/js/javascript.js<br>'
         + '/assets/' + ext + '/img';

   var listMenu = $('#listarMenup').val();
   var res = listMenu.split("#");
   if (idExt == '') {
     if (listMenu != '' && res[0] == 2) {
         $('#dirAr').html(html);
     } else {
         $('#dirAr').html('<b>Esta Extension no GenerarÃ¡ Directorios o Archivos</b>');
     }
   }
}


function grabarExt(opt){
   let const_error = [];
   if ($("#nomExt").val() == ''){
      const_error.push("Falta nombre del menu");
   }
   if ($("#nomArch").val() == ''){
      const_error.push("Falta nombre de la Extensión");
   }
   let arr_permisos = [];
   $(".checked_id").each(function(index){
      let ck_permiso = document.getElementById(this.id).checked;
      if (ck_permiso){
         arr_permisos.push(this.id.split("_")[2]);
      }
   });

   if (arr_permisos.length==0){ const_error.push("Falta permisos"); }
   if (const_error.length>0){
      jError(const_error.join("<br>"),"ERROR - CLINICA WALDO ORELLANA");
      return false;
   } else {

      let bool_checked        = document.getElementById('habilitado').checked; // menu habilitado
      let listarMenup         = [];
      let extension_principal = 1;

      if($("#listarMenup").val() == "0"){
         listarMenup          =  0;
      } else {
         let value            =  $("#listarMenup").val();
         listarMenup          =  parseInt(value);
         num_tipo             =  $('option[value="'+value+'"]').data('tipo');
         extension_principal  =  parseInt(num_tipo) + 1;
      }
      //console.log("  ------------------------------------------------   ");
      //console.log("  extension_principal  -> ",extension_principal);
      //console.log("  listarMenup          -> ",listarMenup); 
      //console.log("  arr_permisos         -> ",arr_permisos);
      //return false;
      $("#loadFade").modal("show");
      $.ajax({ 
         type           : "POST",
         url            : "Home/grabraExt",
         dataType       : "json",
         beforeSend     :  function(xhr){ },
         data           :  { 
                              opt                  : opt,
                              bool_checked         : bool_checked,
                              nomExt               : $("#nomExt").val(),
                              nomArch              : $("#nomArch").val(),
                              listarMenup          : listarMenup,
                              extension_principal  : extension_principal,
                              arr_permisos         : arr_permisos,
                           },
         error          :  function(errro)   {  
                                                console.log(errro);
                                                //console.log(errro.responseText);  
                                                jAlert("Error General, Consulte Al Administrador"); 
                                                $('#loadFade').modal('hide');
                                                js_limpia_panel();
                                             },
         success        :   function(aData)  {  
                                                $('#loadFade').modal('hide');
                                                //console.log("--------- Exito  ------------- ");
                                                //console.log(aData);
                                                if (aData.status){
                                                   jAlert("Se creo extensi&oacute;n","Clinica online Maria Zabala");
                                                   js_limpia_panel();
                                                }
                                             }, 
      });
   }

}

function js_limpia_panel(){
   $("#listarMenup").val('');
   $("#nomExt").val('');
   $("#nomArch").val('');
   document.getElementById('habilitado').checked = true;
   document.querySelectorAll('input[type=checkbox][name="ck_permiso"]').forEach(function(checkElement){ checkElement.checked = false; });
}

function crearPriv() {
   let nombre = $('#nomProv').val();
   if (nombre == ""){
      jError("Nombre del privilegio vac&iacute;o","Clinica online Maria Zabala");
      return false;
   }
   $("#loadFade").modal("show");
   $.ajax({ 
      type           : "POST",
      url            : "Home/creaPrivilegio",
      dataType       : "json",
      beforeSend     :  function(xhr){ },
      data           :  {
                           "nombre": nombre.toUpperCase() 
                        },
      error          :  function(errro)   {  
                                             console.log(errro);
                                             jAlert("Error General, Consulte Al Administrador"); 
                                             $('#loadFade').modal('hide');
                                          },
      success        :   function(aData)  {  
                                             $('#loadFade').modal('hide');
                                             console.log(aData);
                                             if(aData.status){
                                                $("#nomProv").val("");
                                                jAlert('Privilegio creado correctamente', "Confirmac\u00f3on", function (r) {
                                                   if (r) { location.reload(true);   }
                                                });
                                             }
                                          }, 
   });
}

function js_estado_r(PER_ID){
   let v_bool  =  document.getElementById(PER_ID).checked?1:0;
   let b_bool  =  document.getElementById(PER_ID).checked?true:false;
   /*   
   console.log("  js_estado_r   ");
   console.log("  bool           :",v_bool);
   console.log("  b_bool         :",b_bool);
   console.log("  PER_ID         :",PER_ID);
   */
   jConfirm('Se aplicaran cambios', 'Confirmation Dialog', function(r) {
      if (r){
         $('#loadFade').modal('show');
         $.ajax({ 
            type           : "POST",
            url            : "Home/actualiza_privilegio",
            dataType       : "json",
            beforeSend     :  function(xhr){ },
            data           :  {
                                 "PER_ID" : PER_ID,
                                 "v_bool" : v_bool,
                              },
            error          :  function(errro)   {  
                                                   console.log(errro);
                                                   jAlert("Error General, Consulte Al Administrador"); 
                                                   $('#loadFade').modal('hide');
                                                },
            success        :   function(aData)  {  
                                                   $('#loadFade').modal('hide');
                                                   //console.log("actualiza_privilegio   -> ",aData);
                                                   jAlert('Se modifico información', "Confirmac\u00f3on", function (r) {
                                                      if (r) { location.reload(true);   }
                                                   });
                                                }, 
         });
      } else {
         document.getElementById(PER_ID).checked = !b_bool;
      }
   });
}


function validar(e){
   var tecla         = (document.all) ? e.keyCode : e.which;
   if(tecla==13)     {
      $("#rut").css("border-color","");  
      if($("#rut").val() == ''){
         jError("RUN del paciente esta vacio.","e-SISSAN Error");
         $("#rut").css("border-color","red");  
         return false;
      } else {
         var _rut       =   $("#rut").val();
         var rut_array  =   _rut.split("-");
         var rut2       =   rut_array[0].replace(".","");
         var rut        =   rut2.replace(".","");
         var dv         =   rut_array[1];
         if(!valida_rut_dos_variables(rut,dv)){
            jError(" El rut del paciente no es v&aacute;lido.","e-SISSAN Error");
            $("#rut").css("border-color","red");  
            return false;
         } else {
            buscar_Paciente(1);
         }
      }
   } 
}

