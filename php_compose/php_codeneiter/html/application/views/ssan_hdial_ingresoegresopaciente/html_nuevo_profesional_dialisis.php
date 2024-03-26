<div class="grid_busqueda_rrhh">
    <div class="grid_busqueda_rrhh1">
        <span class="input-group-addon" id="basic-addon1" style=""><i class="fa fa-user-md"></i> <b>RUN</b></span>
        <input type="text" id="rut_profesional" name="rut_profesional" class="form-control input-sm" style="width:115px;"/>
    </div>
    <div class="grid_busqueda_rrhh3">
        <button type="button" class="btn btn-success btn-fill" id="btn_valida_profesional" onclick="valida_profesional()" style="margin-top: 23px;">
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>
    </div>
    <div class="grid_busqueda_rrhh2 card">
        <table class="table table-striped"  style="margin-bottom: 0px;">
            <tbody>
                <tr>
                    <td style="height: 40px">
                        <div>
                            <h6 class="my-0">RUN PROFESIONAL:</h6>
                            <small class="text-muted" id="numidentificador"></small>
                        </div>
                    </td>
                </tr>
                <tr style="height: 40px">
                    <td>
                        <div>
                            <h6 class="my-0">NOMBRE PROFESIONAL:</h6>
                            <small class="text-muted" id="nombreLabel"></small>
                        </div>
                    </td>
                </tr>
                <tr style="height: 40px">
                    <td>
                        <div>
                            <h6 class="my-0">PROFESI&Oacute;N:</h6>
                            <small class="text-muted" id="profesionLabel"></small>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="alert alert-success alert_profesional_existe" role="alert" style="display:none">
    <i class="bi bi-exclamation-triangle"></i>&nbsp;Profesional existe como recurso humano correspondiente al sistema de di&aacute;lisis 
</div>

<div class="alert alert-warning alert_profesional_no_existe" role="alert" style="display:none;">
    <p style="color:white;margin: 0;"><i class="bi bi-check-square"></i>&nbsp;Profesional no existe en RRHH del sistema de di&aacute;lisis. Para agregar presione guardar RRHH</p>
</div>

<script>
    $('#rut_profesional').Rut({
        on_error    :   function()  {   
                                        jAlert('El Run ingresado es Incorrecto. '+$("#rut_profesional").val(),'Rut Incorrecto'); 
                                        $("#rut_profesional").css('border-color','red'); 
                                        $("#rut_profesional").val('');
                                        console.log($("#rut_profesional").val()); 
                                    },
        on_success  :   function()  {   
                                        $("#rut_profesional").css('border-color','');   
                                    },
        format_on   : 'keyup'
    });
</script>