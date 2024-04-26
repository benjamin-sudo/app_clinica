<div class="grid_clave_esissan">
    <div class="grid_clave_esissan1"> 
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1" style=""><i class="fa fa-user" aria-hidden="true"></i><b>&nbsp;RUN</b></span>
            <input type="text" id="run_esissan" name="run_esissan" class="form-control input-sm" style="width:101px;" onkeypress="validar(event)">
        </div>
    </div>
    <div class="grid_clave_esissan2">
        <div class="btn-group">
            <button type="button" class="btn btn-success btn-fill" id="btn_valida_profesional" onclick="valida_run_esissan()">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-danger btn-fill class_input_cuenta" id="btn_volver_atras">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="grid_clave_esissan3">&nbsp;</div>
</div>

<div class="grid_datos_ususario">
    <div class="grid_datos_ususario1">
        <table class="table table-striped">
           <tbody>
                <tr style="height: 36px;">
                    <th scope="col" colspan="2">
                        <div class="grid_info_usuarios">
                            <div class="grid_info_usuarios1">Datos del Usuario</div>
                            <div class="grid_info_usuarios5 class_superusuario" style="display:none">&nbsp;Super Usuario&nbsp;</div>
                            <div class="grid_info_usuarios4 class_superusuario" style="display:none"><input type="checkbox" id="checkTipo" class="class_checkbox" style="display: block;margin-top: 0px;" disabled></div>
                            <div class="grid_info_usuarios3">&nbsp;Habilitado&nbsp;</div>
                            <div class="grid_info_usuarios2"><input type="checkbox" id="CheckboxUsu" class="class_checkbox" style="display: block;margin-top: 0px;" disabled> </div>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th scope="row">Nombres</th>
                    <td><input type="text" id="txtNombres" onkeypress="return soloLetras(event);" class="form-control input-sm class_input_cuenta"></td>
                </tr>
                <tr>
                    <th scope="row">Apellido Paterno</th>
                    <td><input type="text" id="txtApePate" onkeypress="return soloLetras(event);" class="form-control input-sm class_input_cuenta"></td>
                </tr>
                <tr>
                    <th scope="row">Apellido Materno</th>
                    <td><input type="text" id="txtApeMate" onkeypress="return soloLetras(event);" class="form-control input-sm class_input_cuenta"></td>
                </tr>
                <tr>
                    <th scope="row">Correo Electr&oacute;nico</th>
                    <td><input type="text" id="txtEmail" onkeypress="return soloEmail(event);"  class="form-control input-sm class_input_cuenta" style="text-transform: none;"></td>
                </tr>
                <tr style="height: 36px;">
                    <th scope="col" colspan="2">
                        <div class="grid_nueva_contraena">
                            <div class="grid_nueva_contraena1">Contrase&ntilde;a de Acceso</div>
                            <div class="grid_nueva_contraena2">
                                <label style="margin-bottom: 0px;" for="ind_actualiza_pass" id="txt_acceso_contraena">Reiniciar contrase&ntilde;a</label>
                            </div>
                            <div class="grid_nueva_contraena3 check_contrasena">
                                <input type="checkbox" id="ind_actualiza_pass" name="ind_actualiza_pass" class="class_checkbox" style="display: block;margin-top: 0px;" disabled>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th scope="row">Nueva Contrase&ntilde;a:</th>
                    <td><input type="password" id="txtPass" onkeypress="return alfanumerico(event);" onblur="validaPass()" class="form-control input-sm class_input_pass"></td>
                </tr>
                <tr>
                    <th scope="row">Repetir Contrase&ntilde;a:</th>
                    <td><input type="password" id="txtPassRep" onkeypress="return alfanumerico(event);" onblur="validaPass2()" class="form-control input-sm class_input_pass"></td>
                </tr>
            </tbody>
        </table>

    </div>

    <!--
        Privilegios de Usuario<br>
        Establecimiento<br>
        <div class="grid_privilegios_ususaior1 padding_esissan">Puntos de entrega<br>
        <select class="selectpicker" name="ind_pto_entrega" id="ind_pto_entrega" data-width="100%" data-container="body"  data-selected-text-format="count" data-live-search="true" multiple title="Seleccione puntos de entrega ..." onclick="js_cambio_punto_entrega(this)"></select> 
        </div>
        <div class="grid_privilegios_ususaior2">&nbsp;</div>
        <div class="grid_privilegios_ususaior3">&nbsp;</div>
    -->

    <div class="grid_datos_ususario2">
        <h4 style="MARGIN: 0PX;"><b>EDICI&Oacute;N DE PRIVILEGIOS</b></h4>
        <div class="grid_privilegios_ususaior">
            <div class="grid_privilegios_ususaior1 padding_esissan" id="data_privilegios">
                <select class="selectpicker" name="destinoPriv" id="destinoPriv" data-width="100%" data-container="body" data-selected-text-format="count" data-live-search="true" multiple  title="Seleccione privilegios..." onchange="js_reload_previlegios(this)"></select>
            </div>
            <div class="grid_privilegios_ususaior2">&nbsp;</div>
            <div class="grid_privilegios_ususaior3">
                <ul class="list-group privilegios_ususario" style="margin-bottom:4px;">
                    <li class="list-group-item li_priveligos privilegios_ususario_sin_items">
                        <i class="fa fa-times" aria-hidden="true"></i>&nbsp;SIN PRIVILEGIOS
                    </li>
                </ul>
            </div>
        </div>
        
        <h4 style="MARGIN: 0PX;"><b>EDICI&Oacute;N DE ESTABLECIMIENTOS</b></h4>
        <div class="grid_privilegios_ususaior">
            <div class="grid_privilegios_ususaior1 padding_esissan" id="data_establecimientos">
                <select class="selectpicker" name="destinoEstab" id="destinoEstab" data-width="100%" data-container="body" data-selected-text-format="count" data-live-search="true" multiple  title="Seleccione establecimiento..." onchange="js_reload_establecimientos(this)"></select> 
            </div>
            <div class="grid_privilegios_ususaior2">&nbsp;</div>
            <div class="grid_privilegios_ususaior3">
                <ul class="list-group privilegios_empresa" style="margin-bottom:4px;">
                    <li class="list-group-item li_priveligos privilegios_empresa_sin_items">
                        <i class="fa fa-times" aria-hidden="true"></i>&nbsp;SIN ESTABLECIMIENTO ASIGNADO
                    </li>
                </ul>
            </div>
        </div>


    </div>

</div>

<hr>

<div class="grid_btn_edita"> 
    <div class="grid_btn_edita1">&nbsp;</div>
    <div class="grid_btn_edita2">
        <div class="btn-group">
            <button type="button" class="btn btn-success btn-fill class_input_cuenta"  id="btn_edicion_ususario"   name="btn_edicion_ususario" disabled>
                <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;NUEVO/EDICI&Oacute;N DE USUARIO
            </button>
            <button type="button" class="btn btn-danger btn-fill class_input_cuenta"   id="btn_cancelar_user"      name="btn_cancelar_user" disabled>
                <i class="fa fa-times" aria-hidden="true"></i>&nbsp;CANCELAR
            </button>
        </div>
    </div>
    <div class="grid_btn_edita3">&nbsp;</div>
</div>


<input type="hidden"  id="ind_id_uid" name="ind_id_uid" value=""/>

<script>
    $(document).ready(function(){
        $('#run_esissan').Rut({
            on_error    :   function(){   jAlert('El RUN ingresado es Incorrecto. '+$("#run_esissan").val(), ''); console.log($("#run_esissan").val());  $("#run_esissan").css('border-color','red'); $("#run_esissan").val('') },
            on_success  :   function(){   $("#run_esissan").css('border-color','');   },
            format_on   :   'keyup'
        });
        $(".selectpicker").selectpicker();
        $(".class_input_cuenta,.class_input_pass").prop('disabled',true);
        $("#run_esissan").focus();
    });
</script>
