<div class="grid_busqueda_rrhh">
    <div class="grid_busqueda_rrhh1">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1" style=""><i class="fa fa-user"></i><b>RUN</b></span>
            <input type="text" id="rut_profesional" name="rut_profesional" class="form-control input-sm" style="width:101px;" onkeypress="validar(event)">
        </div>
    </div>
    <div class="grid_busqueda_rrhh3">
        <button type="button" class="btn btn-xs btn-success btn-fill" id="btn_valida_profesional" onclick="valida_profesional()">
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>
    </div>
    <div class="grid_busqueda_rrhh2 card">
        <table class="table table-striped">
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
<script>
    //$("#modal_new_userxtomamuestra").modal({backdrop:'static',keyboard:false}).modal("show");
    $('#rut_profesional').Rut({
        on_error    :   function()  {   
                                            jAlert('El Run ingresado es Incorrecto. '+$("#rut_profesional").val(),'Rut Incorrecto'); 
                                            console.log($("#rut_profesional").val());  
                                            $("#rut_profesional").css('border-color','red'); 
                                            $("#rut_profesional").val('') 
                                        },
        on_success  :   function()  {   
                                            $("#rut_profesional").css('border-color','');   
                                        },
        format_on   : 'keyup'
        });
</script>