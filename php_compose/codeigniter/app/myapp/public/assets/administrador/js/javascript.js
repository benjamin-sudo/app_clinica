$(document).ready(function(){
    //https://getbootstrap.com/docs/5.3/getting-started/introduction/

    console.log("   ---------------------------------------------------------------     ");
    console.log("                       Codeigniter 4                                   ");
    console.log("        bootstrap      -> ", bootstrap.Tooltip.VERSION,"               ");
    console.log("        jQuery         -> ", jQuery.fn.jquery,"                        ");
    console.log("   ---------------------------------------------------------------     ");

    $('#run_esissan').Rut({
        on_error    :   function()  { 
                                        console.log($("#run_esissan").val());  
                                        jAlert('El Rut ingresado es Incorrecto. '+$("#run_esissan").val(), 'RUN Incorrecto'); 
                                        $("#run_esissan").css('border-color','red'); 
                                        $("#run_esissan").val('') 
                                    },
        on_success  :   function()  {   
                                        $("#run_esissan").css('border-color',''); 
                                        valida_run_esissan(1); 
                                    },
        format_on   :   'keyup'
    });

    const triggerFirstTabEl = document.querySelector('#myTab li:first-child button');
    //console.log("triggerFirstTabEl   -> ",triggerFirstTabEl);
    if (triggerFirstTabEl) {
        let tab = bootstrap.Tab.getInstance(triggerFirstTabEl);
        if (!tab) {   
            tab =   new bootstrap.Tab(triggerFirstTabEl);
        }
        tab.show();
    } else {
        console.error("No se encontró el primer tab.");
    }
    $(".selectpicker").selectpicker();
    //*************************************************************************************************************************
    //showNotification('top','right','<i class="bi bi-database-fill-slash"></i> Conexi&oacute;n con instancia no iniciada',2);
    //$('.toast').toast('show');
    //var notify = $.notify('<strong>Saving</strong> Do not close this page...', { allow_dismiss: false });
    //notify.update({ type: 'success','<strong>Success</strong> Your page has been saved!' });
    //$.notify('actualizando',{ showProgressbar: true });
});

function valida_run_esissan(val) {
    var _rut = "";
    var rut_array = "";
    var rut2 = "";
    var rut = "";
    var dv = "";
    _rut = $("#run_esissan").val();
    $("#run_esissan").css('border-color', '');
    if (_rut == '') {
        jError("RUN vacío", "Clinica Libre");
        $("#run_esissan").css('border-color', 'red');
        return false;
    }
    rut_array = _rut.split("-");
    rut2 = rut_array[0].replace(".", "");
    rut = rut2.replace(".", "");
    dv = rut_array[1];
    $("#loadFade").modal("show");
    $.ajax({
        type: "POST",
        url: "Home/fn_valida_cuenta_esissan",
        dataType: "json",
        beforeSend: function(xhr) {
            console.log("Mostrar modal");
        },
        data: {
            run: rut,
            dv: dv
        },
        error: function(error) {
            console.log("Error:", error);
            jError("Error General, Consulte Al Administrador", "e-SISSAN");
            setTimeout(function() {
                $("#loadFade").modal("hide");
            }, 1000);
        },
        success: function(aData) {
            console.log(" ---------------------------- ");
            console.log("aData:", aData);

            if (aData.return_bd.status_existe) {
                showNotification('top', 'right', '<i class="fa fa-television" aria-hidden="true"></i>&nbsp;Editando usuario', 2);
                $("#txtNombres").val(aData.return_bd.getResultArray[0]["FIRST_NAME"]);
                $("#txtApePate").val(aData.return_bd.getResultArray[0]["MIDDLE_NAME"]);
                $("#txtApeMate").val(aData.return_bd.getResultArray[0]["LAST_NAME"]);
                $("#txtEmail").val(aData.return_bd.getResultArray[0]["EMAIL"]);
                $("#ind_id_uid").val(aData.return_bd.getResultArray[0]["ID_UID"]);
                if (aData.return_bd.getResultArray[0]["DISABLE"] == '0') {
                    document.getElementById('CheckboxUsu').checked = true;
                }
                if (aData.return_bd.getResultArray[0]["STATUS"] == '1') {
                    document.getElementById('checkTipo').checked = true;
                }
                let listItems1 = aData.return_bd.arr_privilegios.map(value => value.PER_ID);
                if (listItems1.length > 0) {
                    $("#destinoPriv").selectpicker('val', listItems1);
                    js_reload_previlegios();
                }
                let listItems = aData.return_bd.arr_empresa.map(value => {
                    return value.COD_ESTABL === "29" ? "0" + value.COD_ESTABL : value.COD_ESTABL;
                });
                if (listItems.length > 0) {
                    $("#establecimiento").selectpicker('val', listItems);
                    js_reload_establecimientos();
                }
                document.getElementById('ind_actualiza_pass').checked = false;
                $("#ind_actualiza_pass").attr('onclick', 'js_cambio_pass()');
                $("#txtPass,#txtPassRep").attr("disabled", true);
                default_gestionuser(false);
            } else {
                showNotification('top', 'right', '<i class="bi bi-person-add"></i>&nbsp;Nuevo usuario', 1);
                default_gestionuser(true);
            }

            
            setTimeout(function() {
                $("#loadFade").modal("hide");
            }, 1000);


            /*
            $('#loadFade').removeClass('show').hide()
            $('#loadFade').modal('hide'); // Método estándar
            $('#loadFade').removeClass('show'); // Remueve la clase show
            $('#loadFade').hide(); // Esconde el elemento modal
            $('#loadFade').modal('dispose'); // Dispose si Bootstrap 4
            */

        },
    });
}


function default_gestionuser(bool_new){
    $("#btn_creaedita_user").attr('onclick','grabarUsu()').attr("disabled",false);
    $("#btn_valida_profesional").attr("disabled",true).attr('onclick','');
    $("#run_esissan").attr("disabled",true);
    $(".class_checkbox").attr("disabled",false);
    if (bool_new){
        $("#ind_id_uid").val('');
        document.getElementById('CheckboxUsu').checked = true;
        $("#establecimiento").selectpicker('val',[]);
        js_reload_previlegios();
        $("#destinoPriv").selectpicker('val',[]);
        js_reload_establecimientos();
    }
}

function js_cambio_pass(){
    let bool_checked = document.getElementById('ind_actualiza_pass').checked;
    $("#txtPass,#txtPassRep").attr("disabled",!bool_checked);
}

function btn_defaultuser(){
    $("#btn_creaedita_user").attr('onclick','').attr('disabled',true);
    $("#run_esissan").val('').attr("disabled",false);
    $("#btn_valida_profesional").attr("disabled",false).attr('onclick','valida_run_esissan(0)');
    $('#txtNombres').val('');
    $('#txtApePate').val('');
    $('#txtApeMate').val('');
    $('#txtEmail').val('');
    $('#txtPass').val('');
    $('#txtPassRep').val('');
    $('#ind_id_uid').val('');
    $("#establecimiento").selectpicker('val',[]);
    $("#destinoPriv").selectpicker('val',[]);
    js_reload_previlegios();
    js_reload_establecimientos();
}

function grabarUsu(){
    var ok              =   0;
    var user            =   $('#run_esissan').val();
    var nombres         =   $('#txtNombres').val();
    var apepate         =   $('#txtApePate').val();
    var apemate         =   $('#txtApeMate').val();
    var email           =   $('#txtEmail').val();
    var pass            =   $('#txtPass').val();
    var pass2           =   $('#txtPassRep').val();
    var uID             =   $('#ind_id_uid').val();
    //console.log("uID -> ",uID);
    var actualiza_pass  =   document.getElementById("ind_actualiza_pass").checked ? true : false;
    var errores         =   [];
    
    if (user == '') {
        errores.push("Debe Ingresar el RUN del Usuario");
    } 
    
    if ($('#error').is(':visible')) {
        errores.push("  -   El RUN Ingresado no es Valido");
    }  
    
    if (nombres == '') {
        errores.push("  -   Debe Ingresar el Nombre del Usuario");
    }  
    
    if (apepate == '') {
       errores.push("   -   Debe Ingresar el Apellido Paterno del Usuario");
    } 
    
    if (apemate == '') {
        errores.push("  -   Debe Ingresar el Apellido Materno");
    }  
    
    if (email == '') {
        errores.push("  -   Debe Ingresar el Email del Usuario");
    }  else {
        if (!validarEmail()){
            errores.push("- Mail no valido");
        }
    }
    //console.log("actualiza_pass -> ",actualiza_pass);
    if (actualiza_pass || uID == ''){
        if (pass == '' && pass2 == '') {
            errores.push("  -   Contrase&ntilde;a del ususario vac&iacute;a");
        }   else {
            if (pass != pass2){
                errores.push("  -   Contrase&ntilde;a no son iguales");
            }
        }
    }
    let arrPrivilegios      =   $("#destinoPriv").val()  || [];
    //console.log("arrPrivilegios  -> ",arrPrivilegios);
    if (arrPrivilegios.length == 0) {
        errores.push("  -   Debe asignar a lo menos un privilegio para el usuario");
        ok = 0;
    }
    let arrEmpresas         =   $("#establecimiento").val() || [];
    if (arrEmpresas.length == 0) {
        errores.push("  -   Debe asignar a lo menos una empresa al ususario");
        ok = 0;
    }
    var activo;
    if ($("#CheckboxUsu").is(':checked')){
        activo              =   0;
    } else {
        activo              =   1;
    }
    var superUser;
    if ($("#checkTipo").is(':checked')){
        superUser           =   1;
    } else {
        superUser           =   0;
    }
    if (errores.length > 0) {
        //console.log("---------------------------------------------");
        //console.error("   errores     ->  ",errores);
        jError(errores.join("<br>"),"   CLINICA LIBRE - errores")
    } else {
        //validar correo
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
        //console.log("       ------------------------    ");
        //console.log("       pasa                        ");
        //console.log("       enviando -> ",variables,"   ");
        jConfirm('Con esta acci&oacute;n se proceder&aacute; a editar cuenta CLINICA LIBRE <br/>&iquest;Est&aacute; seguro de continuar?','Confirmaci\u00f3n',function(r){
            if(r){
                console.log(" r -> ",r);
                $.ajax({ 
                    type        :   "POST",
                    url         :   "Home/fn_gestion_perfil",
                    dataType    :   "json",
                    beforeSend  :   function(xhr)           {   
                                                                console.log(xhr);
                                                                $('#loadFade').modal('show');
                                                            },
                    data        :                            { 
                                                                "contrasena"        :   r,
                                                                "user"              :   user, 
                                                                "nombres"           :   nombres, 
                                                                "apepate"           :   apepate, 
                                                                "apemate"           :   apemate, 
                                                                "email"             :   email, 
                                                                "pass"              :   pass, 
                                                                "uID"               :   uID, 
                                                                "activo"            :   activo, 
                                                                "superUser"         :   superUser,
                                                                "actualiza_pass"    :   document.getElementById("ind_actualiza_pass").checked ? 1 : 0, 
                                                                "arrPrivilegios"    :   arrPrivilegios, 
                                                                "arrEmpresas"       :   arrEmpresas, 
                                                            },
                    error       :   function(errro)         { 
                                                                console.log("quisas->",errro,"-error->",errro.responseText); 
                                                                $("#protocoloPabellon").css("z-index","1500"); 
                                                                jError("Error General, Consulte Al Administrador","e-SISSAN"); 
                                                                setTimeout(function() {
                                                                    $("#loadFade").modal("hide");
                                                                }, 1000);
                                                            },
                    success     :   function(aData)         { 
                                                                console.log("return  ->",aData);
                                                                setTimeout(function() {
                                                                    $("#loadFade").modal("hide");
                                                                }, 1000);
                                                                showNotification('top','center','<i class="bi bi-check-square-fill"></i> Se ha modificado perfil :<b>'+user+'</b>, numero : '+aData.data_return.last_id+'</b>',2);
                                                                btn_defaultuser();
                                                            }, 
                });
            } else {
                //jError("Firma simple vac&iacute;a","Error - ESSISAN"); 
            }
        });
    }   
}

function validaPass2(){

}

function validarEmail() {
    var email = document.getElementById('txtEmail').value;
    //console.log(email);
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (regex.test(email)) {
        // El formato del correo electrónico es correcto
        //console.log("Correo válido");
        return true;
    } else {
        // El formato del correo electrónico no es correcto
        //console.log("Correo inválido");
        return false;
    }
}

function js_reload_previlegios() {
    let arr_destinoPriv = $("#destinoPriv").val() || [];
    $(".li_priveligos").empty();
    if (arr_destinoPriv.length > 0) {
        let listItems = arr_destinoPriv.map((value, index) => {
            let arr = $('#destinoPriv > option[value="' + value + '"]').data('info');
            return `<li class="list-group-item li_priveligos_${arr['PER_ID']}">
                        <div class="grid_privilegios_establecimiento">
                            <div class="grid_privilegios_establecimiento1">${index + 1}</div>
                            <div class="grid_privilegios_establecimiento2">${arr['PER_NOMBRE']}</div>
                            <div class="grid_privilegios_establecimiento3">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="js_delete_privilegios(${arr['PER_ID']})">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>    
                    </li>`;
        });

        $(".li_priveligos").html(listItems.join(''));
    } else {
        $(".li_priveligos").html(`<li class="list-group-item" style="cursor:pointer;text-align:center;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;SIN PRIVILEGIOS</li>`);
    }
}

function js_delete_privilegios(id){
    $(".li_priveligos_"+id).remove();
    let arr_priveligos        =   $("#destinoPriv").val();
    let indice                =   arr_priveligos.indexOf(id);
    arr_priveligos.splice(indice,1);
    $("#destinoPriv").selectpicker('val',arr_priveligos);
    js_reload_previlegios();
}

function js_reload_establecimientos() {
    let arr_establecimiento = $("#establecimiento").val() || [];
    $(".privilegios_empresa").empty();
    if (arr_establecimiento.length > 0) {
        let listItems = arr_establecimiento.map((value, index) => {
            let arr = $('#establecimiento > option[value="' + value + '"]').data('info');
            return `<li class="list-group-item li_empresa_${arr['COD_EMPRESA']}">
                        <div class="grid_privilegios_establecimiento">
                            <div class="grid_privilegios_establecimiento1">${index + 1}</div>
                            <div class="grid_privilegios_establecimiento2">${arr['NOM_RAZSOC']} <b>(${arr['COD_EMPRESA']})</b></div>
                            <div class="grid_privilegios_establecimiento3">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="js_delete_empresa(${arr['COD_EMPRESA']})">
                                     <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>    
                    </li>`;
        });
        $(".privilegios_empresa").html(listItems.join(''));
    } else {
        $(".privilegios_empresa").html(`<li class="list-group-item" style="cursor:pointer;text-align:center;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;SIN ESTABLECIMIENTO</li>`);
    }
}

function js_delete_empresa(id){
    $(".li_empresa_"+id).remove();
    let arr_priveligos        =   $("#establecimiento").val();
    let indice                =   arr_priveligos.indexOf(id);
    arr_priveligos.splice(indice,1);
    $("#establecimiento").selectpicker('val',arr_priveligos);
    js_reload_establecimientos();
}

var normalize = (function() {
   var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
       to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
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
      data		     :  { token : $("#token").val() },
      error		     :  function(errro)  {  
                                             console.log(errro);
                                             console.log(errro.responseText);  
                                             jAlert("Error General, Consulte Al Administrador"); 
                                             setTimeout(function() {
                                                $("#loadFade").modal("hide");
                                            }, 1000);
                                            },
      success		   :   function(aData)  {  
                                             setTimeout(function() {
                                                $("#loadFade").modal("hide");
                                            }, 1000);

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
                                             console.log(arr_diagnisticos.join("\n"));
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
                                            
                                             setTimeout(function() {
                                                $("#loadFade").modal("hide");
                                            }, 1000);


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
    let const_error          =   [];
    if ($("#nomExt").val()   == ''){
        const_error.push("Falta nombre del menu");
    }
    if ($("#nomArch").val()  == ''){
        const_error.push("Falta nombre de la Extensión");
    }
    let arr_permisos = [];
    $(".checked_id").each(function(index){
      let ck_permiso = document.getElementById(this.id).checked;
      if (ck_permiso){
         arr_permisos.push(this.id.split("_")[2]);
      }
    });
    if(arr_permisos.length==0){ 
        const_error.push("Falta permisos"); 
    }
    
    if(const_error.length>0){
        jError(const_error.join("<br>")," - ERROR - ");
        return false;
    } else {

        let bool_checked          =     document.getElementById('habilitado').checked; // menu habilitado
        let listarMenup           =     [];
        let extension_principal   =     1;

        if($("#listarMenup").val() == "0"){
            listarMenup            =    0;
        } else {
            let value              =    $("#listarMenup").val();
            listarMenup            =    parseInt(value);
            num_tipo               =    $('option[value="'+value+'"]').data('tipo');
            extension_principal    =    parseInt(num_tipo) + 1;
        }

        //console.log("  ------------------------------------------------   ");
        //console.log("  extension_principal  -> ",extension_principal);
        //console.log("  listarMenup          -> ",listarMenup); 
        //console.log("  arr_permisos         -> ",arr_permisos);
        //return false;

        $.ajax({ 
            type           : "POST",
            url            : "Home/grabraExt",
            dataType       : "json",
            beforeSend     :  function(xhr){  $("#loadFade").modal("show"); },
            data           :  { 
                              opt                  : opt,
                              bool_checked         : bool_checked,
                              nomExt               : $("#nomExt").val(),
                              nomArch              : $("#nomArch").val(),
                              listarMenup          : listarMenup,
                              extension_principal  : extension_principal,
                              arr_permisos         : arr_permisos,
                           },
            error          :  function(errro)  {  
                                                console.log(errro);
                                                //console.log(errro.responseText);  
                                                jAlert("Error General, Consulte Al Administrador"); 
                                                
                                                setTimeout(function() {
                                                    $("#loadFade").modal("hide");
                                                }, 1000);


                                                js_limpia_panel();
                                            },
            success        :   function(aData) {  
                                                
                                                setTimeout(function() {
                                                    $("#loadFade").modal("hide");
                                                }, 1000);

                                                //console.log("--------- Exito  ------------- ");
                                                //console.log(aData);
                                                if (aData.status){
                                                    jAlert('Se creo extensi&oacute;n', "Confirmac\u00f3on", function (r) {
                                                        if (r) { location.reload(true);   }
                                                    });
                                                    js_limpia_panel();
                                                }
                                            }, 
      });
   }
}

function js_limpia_panel(){
    $("#listarMenup").val('0');
    $("#nomExt").val('');
    $("#nomArch").val('').attr("disabled",false);
    $("#grabarExt").html('<i class="bi bi-floppy-fill"></i>&nbsp;CREAR EXTENSI&Oacute;N').attr('onclick','grabarExt(0)');
    document.getElementById('habilitado').checked = true;
    document.querySelectorAll('input[type=checkbox][name="ck_permiso"]').forEach(function(checkElement){ 
        checkElement.checked = false; 
    });
}

function crearPriv() {
    let nombre = $('#nomProv').val();
    if (nombre == ""){
        jError("Nombre del privilegio vac&iacute;o","Clinica online Maria Zabala");
        return false;
    }
   $.ajax({ 
      type : "POST",
      url : "Home/creaPrivilegio",
      dataType : "json",
      beforeSend : function(xhr){  $("#loadFade").modal("show"); },
      data :   {
                    "nombre": nombre.toUpperCase() 
                },
      error : function(errro)   {  
                    console.log(errro);
                    jAlert("Error General, Consulte Al Administrador"); 
                    
                    setTimeout(function() {
                        $("#loadFade").modal("hide");
                    }, 1000);

                },
      success : function(aData){  
                                    
                                    setTimeout(function() {
                                        $("#loadFade").modal("hide");
                                    }, 1000);


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
    let v_bool = document.getElementById(PER_ID).checked?1:0;
    let b_bool = document.getElementById(PER_ID).checked?true:false;
    jConfirm('Se aplicar&aacute;n los cambios', 'Clinica libre ', function(r) {
      if (r){
        $.ajax({ 
            type           : "POST",
            url            : "Home/actualiza_privilegio",
            dataType       : "json",
            beforeSend     :  function(xhr){ $('#loadFade').modal('show'); },
            data           :  {
                                 "PER_ID" : PER_ID,
                                 "v_bool" : v_bool,
                              },
            error          :  function(errro)   {  
                                                    console.log(errro);
                                                    jAlert("Error General, Consulte Al Administrador"); 
                                                    setTimeout(function() {
                                                        $("#loadFade").modal("hide");
                                                    }, 1000);

                                                },
            success        :   function(aData)  {  
                                                    setTimeout(function() {
                                                        $("#loadFade").modal("hide");
                                                    }, 1000);
                                                    //console.log("actualiza_privilegio   -> ",aData);
                                                    jAlert('Se modifico informaci&aacute;n', "Confirmac\u00f3on", function (r) {
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

function alfanumerico(e) {
    key             =   e.keyCode || e.which;
    tecla           =   String.fromCharCode(key).toLowerCase();
    letras          =   "1234567890Ã¡Ã©Ã­Ã³ÃºabcdefghijklmnopqrstuvwxyzÃÃ‰ÃÃ“ÃšABCDEFGHIJKLMNOPQRSTUVWXYZ_";
    especiales      =   "8-37-39-46-13";
    tecla_especial  =   false;
    for (var i in especiales) {
        if (key     ==  especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    
    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}


//ind_tipo_menu 
// 0 : Abuelo - Menu principal 
// 1 : hijo - Sub Menu 
// 2 : nieto - Extension 


function editarExt(idMen, ind_tipo_menu) {
    console.log("********************************");
    console.log("idMen          ->  ", idMen);
    console.log("ind_tipo_menu  ->  ", ind_tipo_menu);
    console.log("********************************");

    document.querySelectorAll('input[name="ck_permiso"]').forEach(function(checkbox) {
        checkbox.checked = false;
    });

    $.ajax({ 
        type: "POST",
        url: "Home/buscaEditar",
        dataType: "json",
        beforeSend: function(xhr) { 
            $('#loadFade').modal('show'); 
        },
        data: { 
            "idMen": idMen, 
            "ind_tipo_menu": ind_tipo_menu 
        },
        error: function(error) {  
            console.log(error);
            jAlert("Error General, Consulte Al Administrador"); 
            setTimeout(function() {
                $("#loadFade").modal("hide");
            }, 1000);
        },
        success: function(aData) {  
            console.log("editarExt -> ", aData);
            setTimeout(function() {
                $("#loadFade").modal("hide");
            }, 1000);
            let data_menu = aData.arr_bd.gu_tmenuprincipal[0];
            if (data_menu) {
                $("#nomExt").val(data_menu.MENP_NOMBRE);
                $("#nomArch").val(data_menu.MENP_RUTA).attr("disabled", true);
                $("#listarMenup").val(data_menu.MENP_ID).attr("disabled", true);
                $("#grabarExt").html('<i class="bi bi-floppy-fill"></i>&nbsp;EDITANDO EXTENSI&Oacute;N').attr('onclick', 'js_editarextension(' + idMen + ',' + ind_tipo_menu + ')');
            }
            // 
            if (aData.arr_bd.arr_permisos.length > 0) {
                aData.arr_bd.arr_permisos.forEach((row) => {
                    document.getElementById('ck_permiso_' + row.PER_ID).checked = true;
                });
            }
            // Heredar permisos de los padres
            if (aData.arr_bd.herencia_permisos && aData.arr_bd.herencia_permisos.length > 0) {
                aData.arr_bd.herencia_permisos.forEach((row) => {
                    document.getElementById('ck_permiso_' + row.PER_ID).checked = true;
                });
            }
        }
    });
}

function js_editarextension(idMen,ind_tipo_menu) {

    console.log("idMen          -> ",idMen);
    console.log("ind_tipo_menu  -> ",ind_tipo_menu);
    
    let const_error = [];
    let check = document.getElementById('habilitado').checked ? 1 : 0; // menú habilitado
    if ($("#nomExt").val() == '') {
        const_error.push("Falta nombre del menú");
    }

    let arr_permisos = [];
    $(".checked_id").each(function(index) {
        let ck_permiso = document.getElementById(this.id).checked;
        if (ck_permiso) {
            arr_permisos.push(this.id.split("_")[2]);
        }
    });

    if (arr_permisos.length == 0) { 
        const_error.push("Faltan privilegios"); 
    }

    if (const_error.length > 0) {
        jError(const_error.join("<br>"), "ERROR - CLinica libre");
        return false;
    } else {
        let bool_checked = document.getElementById('habilitado').checked; // menú habilitado
        let ind_extension_padre = 0;
        let tipo_de_extension = 0;
        if (ind_tipo_menu != 0) {
            ind_extension_padre = parseInt($("#listarMenup").prop("value"));
            tipo_de_extension = ind_tipo_menu;
        }
       

        console.log("       ----------------------------------------------------------  ");
        console.error("     ind_tipo_menu          ->   ", ind_tipo_menu);
        console.log("       idMen                  ->   ", idMen);
        console.log("       idMen_extension_padre  ->   ", ind_extension_padre);
        console.log("       tipo_de_extension      ->   ", tipo_de_extension);
        console.log("       check                  ->   ", check);
        console.log("       arr_permisos           ->   ", arr_permisos);
        console.log("       bool_checked           ->   ", bool_checked);
        console.log("       ----------------------------------------------------------  ");
        
        //return false;
        jConfirm('Con esta acci&oacute;n se proceder&aacute; a editar cuenta <b>CLINICA LIBRE</b> <br/>&iquest;Est&aacute; seguro de continuar?', 'Confirmaci&oacute;n', function(r) {
            if (r) {
                $.ajax({ 
                    type: "POST",
                    url: "Home/editExtension",
                    dataType: "json",
                    beforeSend: function(xhr) { $('#loadFade').modal('show'); },
                    data: { 
                        "idMen": idMen,
                        "nombre": $("#nomExt").val(),
                        "nomArch" : $("#nomExt").val(),
                        "ind_extension_padre": ind_extension_padre,
                        "tipo_de_extension": tipo_de_extension,
                        "check": check,
                        "arrPrivilegios": arr_permisos,
                        "bool_checked": bool_checked,
                        "ind_tipo_menu" : ind_tipo_menu,
                    },
                    error: function(error) {  
                        console.log(error);
                        jAlert("Error General, Consulte Al Administrador"); 
                        setTimeout(function() {
                            $("#loadFade").modal("hide");
                        }, 1000);
                    },
                    success: function(aData) {  
                        setTimeout(function() {
                            $("#loadFade").modal("hide");
                        }, 1000);
                        console.log("editando_estensiones_privilegios   -> ", aData);
                        showNotification('top', 'right', '<i class="bi bi-database-fill-slash"></i> Se editaron privilegios', 2);
                      
                    }, 
                });
            } else {
                // jError("Firma simple vac&iacute;a", "Error - CLINICA LIBRE"); 
            }
        });
    }
}


/*
function cargaPrivOrigen() {
    var id          =   "origen";
    var funcion     =   'selectOrigen';
    var variables   =   {}
    AjaxExt(variables,id,funcion);
}
*/
