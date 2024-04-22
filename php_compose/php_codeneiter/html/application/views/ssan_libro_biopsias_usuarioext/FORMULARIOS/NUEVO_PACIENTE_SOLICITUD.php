<style>
    .PANEL_BUSQUEDAPACIENTE         {
        display                     :   grid;
        grid-template-columns       :   32.5% 35% 32.5%;
        grid-column-gap             :   5px;
        grid-row-gap                :   20px;
        margin-top                  :   0px;
        margin-bottom               :   0px;
    }
    .pagination                     {
        margin                      :   12px 0px;
    }
    .grid_footer_button             {
        display                     :   grid;
        grid-template-columns       :   1fr auto;
    }

    .grid_radio_tipopaciente        {
        display                     :   grid;
        grid-template-columns       :   1fr 1fr;
        margin-left                 :   23px;
    }
</style>

<input type="hidden" id="PA_ID_PROCARCH" name="PA_ID_PROCARCH" value="">

<div class="container">
    <div id="myWizard" class="wizard">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="nav-item">
                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Paso 1" class="nav-link active">
                        <span class="round-tab">B&Uacute;QUEDA DE PACIENTE</span>
                    </a>
                </li>
                <li role="presentation" class="nav-item">
                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Paso 2" class="nav-link">
                        <span class="round-tab">INFORMACI&Oacute;N ADICIONAL</span>
                    </a>
                </li>
                <li role="presentation" class="nav-item">
                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Paso 3" class="nav-link">
                        <span class="round-tab"><i class="fa fa-wpforms" aria-hidden="true"></i>&nbsp;A.PATOLOGICA</span>
                    </a>
                </li>
            </ul>
        </div>
        <form role="form">
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <div class="margenes" style="margin-top: 5px;">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;N&deg; DOCUMENTO/FICHA</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;POR PARAMETROS</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="card" style="margin-top: 10px;">
                                <div class="card-body">
                                    <h5 class="card-title"><b>TIPO&nbsp;PACIENTE</b><star>*</star></h5>
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <label class="control-label"></label>
                                <div class="grid_radio_tipopaciente" id="tip_paciente">
                                    <div class="grid_radio_tipopaciente1"> 
                                        <label class="radio checked" id="label_tipPac_nac" onclick="cambiaTip(0)">
                                            <input type="radio" class="form-check-input" data-toggle="radio" name="tipPac" id="tipPac_0" value="0" checked>
                                            <div id="txt_nacion" style="position: inherit;top: 2px;">NACIONAL</div>
                                        </label>
                                    </div>
                                    <div class="grid_radio_tipopaciente1"> 
                                        <label class="radio"  onclick="cambiaTip(1)" id="label_tipPac_ext">
                                            <input type="radio" class="form-check-input" data-toggle="radio" name="tipPac" id="tipPac_1" value="1">
                                            <div id="txt_nomexj" style="position: inherit;top: 2px;">EXTRANJERO</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" id="trEx" style="margin-bottom: 0px; display: none;">
                                    <label class="control-label">TIPO&nbsp;DOCUMENTO<star>*</star></label>
                                    <div class="row" style="margin-left:14px;">
                                        <div class="form-group label-floating col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <label class="radio checked" onclick="cambiaDoc(1)" id="label_tipoEx_dni">
                                                <input type="radio" class="form-check-input" name="tipoEx" id="tipoEx_1" data-toggle="radio" value="1" checked>
                                                <div id="txtdoc" style="position: inherit;top: 2px;">DNI&nbsp;/&nbsp;PASAPORTE</div> 
                                            </label>
                                        </div>
                                        <div class="form-group label-floating col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <label class="radio" onclick="cambiaDoc(2)" id="label_tipoEx_fonasa">
                                                <input type="radio" class="form-check-input" name="tipoEx" id="tipoEx_2" data-toggle="radio" value="2">
                                                <div id="txtidfonasa" style="position: inherit;top: 2px;">ID&nbsp;FONASA</div> 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="iden_idfonasa" style="display: none">
                                    <label class="control-label">ID&nbsp;PROVISORIO&nbsp;FONASA<star>*</star></label>
                                    <input type="text" id="busq_rutfonasa" name="busq_rutfonasa" class="form-control input-sm" style="width:101px;">
                                </div>
                                <div class="form-group" id="iden_dni" style="display: none">
                                    <label class="control-label">PASAPORTE/DNI&nbsp;PA&Iacute;S&nbsp;ORIGEN<star>*</star></label>
                                    <input type="text" id="busq_dni" name="busq_dni" class="form-control input-sm">
                                </div>
                                <div class="form-group" id="iden_chileno" style="margin-bottom: 2px;margin-top: 0px;">
                                    <label class="control-label">RUN&nbsp;<star>*</star></label>
                                    <input type="text" id="busq_rut" name="busq_rut" class="form-control input-sm" style="width:101px;">
                                </div>
                                <div class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm btn-fill btn_buscar_paciente" onclick="buscar(0,1);" id="BTN_BUSQ_PAC_1">
                                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR&nbsp;
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-fill btn_limpiar_busq_pac" onclick="limpiar_card_busqueda(1);" id="BTN_DELETE_PAC_1">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;LIMPAR&nbsp;
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                <div class="form-group">
                                    <label class="control-label">NOMBRE&nbsp;<star>*</star></label>
                                    <input class="form-control input-sm" type="text" name="busq_name" id="busq_name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">APELLIDO&nbsp;PATERNO&nbsp;<star>*</star></label>
                                    <input class="form-control input-sm"  type="text"  name="busq_apellidoP" id="busq_apellidoP">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">APELLIDO&nbsp;MATERNO&nbsp;<star>*</star></label>
                                    <input class="form-control input-sm" type="text"  name="busq_apellidoM" id="busq_apellidoM">
                                </div>
                                <div class="text-center">
                                    <div class="form-group">
                                        <div class="btn-group" style="margin-top: 12px;  margin-bottom: 13px;">
                                            <button type="button" class="btn btn-small btn-primary btn-sm btn-fill btn_buscar_paciente" onclick="buscar(0,1);" id="BTN_BUSQ_PAC_2">
                                                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR
                                            </button>
                                            <button type="button" class="btn btn-small btn-danger btn-sm btn-fill btn_limpiar_busq_pac" onclick="limpiar_card_busqueda(1);" id="BTN_DELETE_PAC_2">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;LIMPAR
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <hr style="margin: 0px 0px 15px 0px">
                    <h4 class="title" style="margin-left: 25px;"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;&nbsp;<b>RESULTADO DE B&Uacute;SQUEDA PACIENTE</b></h4>
                    <p style="margin-left: 25px;">B&uacute;squeda De Pacientes Registrado SSAN</p>
                    <hr style="margin: 0px 0px 25px 0px">
                    <table class="table table-striped" style="width: 100%; margin-top: -26px;margin-bottom: 19px;">
                        <thead style="border: hidden;">
                            <tr>
                                <th style="text-align:center;height: 40px;">N&deg;</th>
                                <th style="text-align:center;">IDENTIFICADOR</th>
                                <th style="text-align:center;">F.LOCAL</th>
                                <th style="text-align:center;">NOMBRE COMPLETO</th>
                                <th style="text-align:center;">NACIMIENTO</th>
                                <th style="text-align:center;"><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody id="resultados_busquedapac">
                            <tr style="height:50px;">
                                <td colspan="10" style="text-align:center;"><b>SIN RESULTADO</b></td>
                            </tr>
                        </tbody>
                        <tbody id="msj_busqueda" style="display: none">
                            <tr id="msj_load_body">
                                <td style="text-align:center" colspan="11">
                                    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
                                    <span class="sr-only"></span><b> BUSCANDO...</b>
                                </td>
                            </tr>
                        </tbody>
                        <tbody id="resultados"></tbody>
                        <tbody id="mensajeSinresultados_1"></tbody>
                    </table>


                    <hr style="margin: 0px 0px 0px 0px">
                    <div style="text-align:center;">  
                        <div id="new_paginacion" style="display: none;"></div>
                    </div>



                    <div class="grid_footer_button">
                        <div class="grid_footer_button1">&nbsp;</div>
                        <div class="grid_footer_button2"> 
                            <button type="button" class="btn btn-primary next-step"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;Siguiente</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="step2">

                    <h4>Paso 2</h4>
                    <p>Aquí van los detalles del paso 2.</p>
                    
                    <div class="grid_footer_button">
                        <div class="grid_footer_button1">&nbsp;</div>
                        <div class="grid_footer_button2"> 
                            <button type="button" class="btn btn-default prev-step">Anterior</button>
                            <button type="button" class="btn btn-primary next-step"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;Siguiente</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="step3">
                    <h4>Paso 3</h4>
                    <p>Aquí van los detalles del paso 3.</p>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-default prev-step">Anterior</button></li>
                        <li><button type="button" class="btn btn-default next-step">Finalizar</button></li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
$(document).ready(function () {
  
    $('#myWizard').bootstrapWizard({
        'nextSelector'      :   '.next-step',
        'previousSelector'  :   '.prev-step',
        'onNext'            :   function(tab, navigation, index) {
 
            console.log("   ##############################      ");
            console.log("   tab         ->  ",tab);
            console.log("   navigation  ->  ",navigation);
            console.log("   index       ->  ",index);

            var form = $('#myWizard form');
            // Supongamos que tienes una función de validación que devuelve true si el formulario es válido
            if (!validarPasoActual(index)) {
                return false; // detiene la navegación al siguiente paso si la validación falla
            }
            return true; // continúa al siguiente paso si todo está correcto
        },
        'onTabShow': function(tab, navigation, index) {
            // Se puede ajustar la interfaz de usuario aquí si es necesario, como actualizar un indicador de progreso
            var $total = navigation.find('li').length;
            var $current = index + 1;
            var $percent = ($current / $total) * 100;
            $('#myWizard').find('.progress-bar').css({width:$percent+'%'});
        }
    });
});

function validarPasoActual(index) {
    // Simplemente devuelve true en este ejemplo. Aquí debes implementar tu lógica de validación.
    return true;
}

function cambiaTip(tipo){
    //console.log(tipo);
    //0 NACIONAL
    //1 EXTRANJERO
    $("#iden_chileno").hide();
    $("#iden_dni").hide();
    $("#iden_idfonasa").hide();
    $("#trEx").hide();
    if (tipo == 0) {
        $("#iden_chileno").show();
        $("#tipPac_0").prop("checked",true);
    } else {
        $("#tipPac_1").prop("checked",true);
        $("#iden_dni").show();
        $("#iden_idfonasa").hide();
        $("#trEx").show();
    }
}

function cambiaDoc(tipoDoc){
    //1   -	DNI / PASAPORTE
    //2   -	ID FONASA
    console.log("tipoDoc->",tipoDoc);
    $("#iden_idfonasa").hide();
    $("#iden_dni").hide();
    if(tipoDoc == 1) {
        $("#iden_dni").show();
        $("#tipoEx_1").prop("checked",true);
    } else {
        $("#iden_idfonasa").show();
        $("#tipoEx_2").prop("checked",true);
    }
}

function limpiar_card_busqueda(){
    //console.log("----------limpiar_card_busqueda-------------");
    localStorage.setItem("ind_tipo_busqueda_paciente","#DIV_BUSQUEDA_PAC_NUMERO");
    $('.main_busqueda_paciente a[href="#DIV_BUSQUEDA_PAC_NUMERO"]').tab('show');
}

</script>
