<style>
    .PANEL_BUSQUEDAPACIENTE         {
        display                     :   grid;
        grid-template-columns       :   60% 40%;
        grid-column-gap             :   5px;
        justify-items               :   stretch;
        align-items                 :   center;
        margin-bottom               :   30px;
        margin-top                  :   10px;
    }

    .grid_center_paginacion         {
        display                     :   grid;
        grid-template-columns       :   1fr auto 1fr;
        gap                         :   8px;
        justify-items               :   center;
        align-items                 :   center;
    }

    .pagination                     {
        margin                      :   12px 0px;
    }

    .grid_footer_button             {
        display                     :   grid;
        grid-template-columns       :   1fr auto;
        margin-top                  :   10px;
    }

    .grid_radio_tipopaciente        {
        display                     :   grid;
        grid-template-columns       :   1fr 1fr;
        margin-left                 :   23px;
    }

    .border-red                     {
        border                      :   1px solid red;
    }

    .control-label                  {
        margin-bottom               :   2px;
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
                        <span class="round-tab"><i class="fa fa-wpforms" aria-hidden="true"></i>&nbsp;FOMULARIO&nbsp;PATOLOGICA</span>
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
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="card" style="margin-top: 10px;">
                                    <div class="card-header">
                                        <h4 class="title"><i class="fa fa-search" aria-hidden="true"></i></i>&nbsp;<b>B&Uacute;SQUEDA PACIENTE</b></h4>
                                        <p style="margin-bottom: 0px;">Paciente debe estar en lista de pacientes correspondiente a su establecimiento</p>
                                    </div>
                                    <div class="card-body">
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
                                            <input type="text" id="busq_rutfonasa" name="busq_rutfonasa" class="form-control input-sm" style="width:120px;">
                                        </div>
                                        <div class="form-group" id="iden_dni" style="display: none">
                                            <label class="control-label">PASAPORTE/DNI&nbsp;PA&Iacute;S&nbsp;ORIGEN<star>*</star></label>
                                            <input type="text" id="busq_dni" name="busq_dni" class="form-control input-sm">
                                        </div>
                                        <div class="form-group" id="iden_chileno" style="margin-bottom: 2px;margin-top: 0px;">
                                            <label class="control-label">RUN&nbsp;<star>*</star></label>
                                            <input type="text" id="busq_rut" name="busq_rut" class="form-control input-sm" style="width:120px;">
                                        </div>
                                        <div class="text-center">
                                            <div class="btn-group" style="">
                                                <button type="button" class="btn btn-primary btn_buscar_paciente" onclick="buscar(0,1);" id="BTN_BUSQ_PAC_1">
                                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR&nbsp;
                                                </button>
                                                <button type="button" class="btn btn-danger btn_limpiar_busq_pac" onclick="limpiar_card_busqueda(1);" id="BTN_DELETE_PAC_1">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;LIMPAR&nbsp;
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="card" style="margin-top: 10px;">
                                    <div class="card-body">
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
                                            <div class="btn-group" style="">
                                                <button type="button" class="btn btn-primary btn_buscar_paciente" onclick="buscar(0,1);" id="BTN_BUSQ_PAC_2">
                                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR
                                                </button>
                                                <button type="button" class="btn btn-danger btn_limpiar_busq_pac" onclick="limpiar_card_busqueda(1);" id="BTN_DELETE_PAC_2">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;LIMPAR
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="title">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;&nbsp;<b>RESULTADO DE B&Uacute;SQUEDA PACIENTE</b>
                            </h4>
                            <p style="margin-bottom: 0px;">B&uacute;squeda De Pacientes Registrado en aplicativo</p>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" style="width:100%;margin-bottom: 0px;">
                                <thead style="border: hidden;">
                                    <tr>
                                        <th style="text-align:center;height: 40px;">N&deg;</th>
                                        <th style="text-align:center;">IDENTIFICADOR</th>
                                        <th style="text-align:center;">F.LOCAL</th>
                                        <th style="text-align:center;">NOMBRE COMPLETO</th>
                                        <th style="text-align:center;">NACIMIENTO</th>
                                        <th style=""><i class="fa fa-info-circle" aria-hidden="true"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="resultados_busquedapac">
                                    <tr style="height:50px;">
                                        <td colspan="10" style="text-align:center;"><b>SIN RESULTADO</b></td>
                                    </tr>
                                </tbody>
                                
                                <tbody id="msj_busqueda" style="display: none">
                                    
                                </tbody>

                                <tbody id="resultados"></tbody>
                                <tbody id="mensajeSinresultados_1"></tbody>
                            </table>
                            <hr style="margin: 0px 0px 0px 0px">
                            <div class="grid_center_paginacion">
                                <div class="grid_center_paginacion1">&nbsp;</div>
                                <div class="grid_center_paginacion2">
                                    <div style="text-align:center;">  
                                        <div id="new_paginacion" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="grid_center_paginacion3">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                    <div class="grid_footer_button">
                        <div class="grid_footer_button1">&nbsp;</div>
                        <div class="grid_footer_button2"> 
                            <button type="button" class="btn btn-primary next-step"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;Siguiente</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="step2">
                    <div class="card" style="margin-top: 10px;">
                        <div class="card-header">
                            <h4 class="title"><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;&nbsp;<b>PACIENTE SELECCIONADO</b></h4>
                            <p style="margin-bottom: 0px;">B&uacute;squeda De Pacientes Registrado en aplicativo</p>
                        </div>
                        <div class="card-body" style="padding: 7px;">
                            <table class="table table-sm table-striped">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="my-0">IDENTIFICACI&Oacute;N PACIENTE:</h6>
                                                <small class="text-muted" id="numidentificador"></small>
                                                <div id="DATA_PACIENTE_TEMPLATE"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="my-0">NOMBRE DEL PACIENTE:</h6>
                                                <small class="text-muted" id="nombreLabel"></small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="my-0">SEXO:</h6>
                                                <small class="text-muted" id="sexoLabel"></small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="my-0">DIRECCI&Oacute;N:</h6>
                                                <small class="text-muted" id="direccionLabel"></small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="my-0">F. NACIMIENTO:</h6>
                                                <small class="text-muted" id="edadLabel"></small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="my-0">TEL&Eacute;FONO:</h6>
                                                <small class="text-muted" id="fonoLabel"></small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="my-0">PREVISI&Oacute;N:</h6>
                                                <small class="text-muted" id="previsionLabel"></small>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="title"><i class="fa fa-list-ul" aria-hidden="true"></i>&nbsp;<b>TIPO DE BIOPSIA</b></h4>
                            <p style="margin-bottom: 0px;">Seleccione el tipo de biopsia</p>
                        </div>
                        <div class="card-body">
                            <select class="selectpicker" data-selected-text-format="count" data-width="100%" data-live-search="true" name="IND_TIPO_BIOPSIA" id="IND_TIPO_BIOPSIA">
                                <option value="">SELECIONE</option>
                                <option value="2" data-subtext="Formulario + Lista De Muestras Anatom&iacute;a Patol&oacute;gica">CONTEMPORANEA</option>
                                <option value="3" data-subtext="Formulario + Lista De Muestras Anatom&iacute;a Patol&oacute;gica">DIFERIDA</option>
                                <option value="4" data-subtext="Formulario + Lista De Muestras Anatom&iacute;a Patol&oacute;gica + Lista Muestras Citolog&iacute;cas">BIOPSIA + CITOLOG&Iacute;A</option>
                                <option value="5" data-subtext="Formulario + Lista De Muestras Citolog&iacute;cas">CITOLOG&Iacute;A</option>
                                <option value="6" data-subtext="Formulario + Lista De Muestras PAP">CITOLOG&Iacute;A PAP</option>
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="title"><i class="fa fa-user-md" aria-hidden="true"></i>&nbsp;<b>PROFESIONAL</b></h4>
                            <p style="margin-bottom: 0px;">Seleccione Profesional responsable de la biopsia</p>
                        </div>
                        <div class="card-body">
                            <select class="selectpicker" data-selected-text-format="count" data-width="100%" data-size="8" data-live-search="true" name="LISTADO_PROFESIONALES" id="LISTADO_PROFESIONALES">
                                <?php 
                                    echo '<option value="">SELECIONE</option>';
                                    if (count($C_LISTADOMEDICOS)>0){
                                        foreach($C_LISTADOMEDICOS as $i => $row){
                                            $JSON2  =   htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');
                                            echo '<option data-icon="fa fa-user-md" value="'.$row["COD_RUTPRO"].'"  data-PROFESIONAL="'.$JSON2.'" >'.$row["NOM_PROFE"].'</option>'; 
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="title"><i class="fa fa-hospital-o" aria-hidden="true"></i>&nbsp;<b>ESPECIALIDAD</b></h4>
                            <p style="margin-bottom: 0px;">Seleccione Especialidad asociada a la solicitud</p>
                        </div>
                        <div class="card-body">
                            <select class="selectpicker" data-selected-text-format="count" data-width="100%" data-size="8" data-live-search="true" name="LISTADO_ESPECIALIDAD" id="LISTADO_ESPECIALIDAD">
                                <?php 
                                    echo '<option value="">SELECIONE</option>';
                                    if (count($C_LISTADOSERVICIOS)>0){
                                        foreach ($C_LISTADOSERVICIOS as $i => $row){
                                            echo '<option data-icon="fa fa-hospital-o" value="'.$row["ID"].'">'.$row["TXT_DES"].'</option>'; 
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="grid_footer_button">
                        <div class="grid_footer_button1">&nbsp;</div>
                        <div class="grid_footer_button2"> 
                            <button type="button" class="btn btn-default prev-step"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;Nueva Busqueda</button>
                            <button type="button" class="btn btn-primary next-step"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;Inicio Formulario Anatomia Patologica</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="step3">
                    <div id="HTML_TEMPLATE_3_PASEQUIRUGICO"></div>
                    <div class="grid_footer_button">
                        <div class="grid_footer_button1">&nbsp;</div>
                        <div class="grid_footer_button2"> 
                            <button type="button" class="btn btn-default prev-step"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;Volver</button>
                            <!--
                            <button type="button" class="btn btn-success next-step btn_envia_form " onclick="JS_GUARDAANATOMIA_EXTERNO()"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;ENVIAR ANATOMIA PATOLOGICA</button>
                            -->
                            <button type="button" id="btn-finish" class="btn btn-success btn-finish pull-right" onclick="JS_GUARDAANATOMIA_EXTERNO()" style="display: inline-block;margin-left:7px;">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;ENVIAR ANATOMIA PATOLOGICA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
$(document).ready(function () {
    $('#busq_rut').Rut({
        format_on   :   'keyup',
        on_error    :   function()  {   
                                        jError("RUN. no es correcto","CLINICA LIBRE CHILE"); 
                                        console.log(this);
                                        $("#busq_rut").val('');
                                    },
        on_success  :   function()  { 
                                        console.log("  this -> ",this);
                                        console.log(this.id);
                                    },
    });
    $('#busq_rutfonasa').Rut({
        format_on   :   'keyup',
        on_error    :   function()  {   
                                        jError("RUN. no es correcto","CLINICA LIBRE CHILE"); 
                                        console.log(this);
                                        $("#busq_rutfonasa").val('');
                                    },
        on_success  :   function()  { 
                                        console.log("  this -> ",this);
                                        console.log(this.id);
                                    },
    });

    $('#myWizard').bootstrapWizard({
        'nextSelector'      :   '.next-step',
        'previousSelector'  :   '.prev-step',
        'onNext'            :   function(tab, navigation, index) {
            
            console.log("   ##############################      ");
            console.log("   tab         ->  ",tab,"             ");
            console.log("   navigation  ->  ",navigation,"      ");
            console.log("   index       ->  ",index,"           ");
            console.log("   ##############################      ");
            
            if (index == 1){
                let PACIENTE_SEL    =   $("input[name='SELECCIONA_PACIENTE']:checked").val();
                if(PACIENTE_SEL === undefined) {
                    jAlert("Seleccione Paciente","Clinica Libre");
                    return false;
                } else {
                    let DATA_PACIENTE =   $("#DATA_"+PACIENTE_SEL).data().bloque;
                    $("#DATA_PACIENTE_TEMPLATE").removeData();
                    $("#DATA_PACIENTE_TEMPLATE").data(DATA_PACIENTE);
                    $("#numidentificador").html(DATA_PACIENTE.COD_RUTPAC+" "+DATA_PACIENTE.COD_DIGVER);
                    $("#nombreLabel").html(DATA_PACIENTE.NOM_NOMBRE+" "+DATA_PACIENTE.APEPATPAC+" "+DATA_PACIENTE.APEMATPAC);
                    $("#sexoLabel").html(DATA_PACIENTE.TIPO_SEXO);
                    $("#direccionLabel").html(DATA_PACIENTE.DIRECLOCAL+" "+DATA_PACIENTE.NCASAL);
                    $("#edadLabel").html(DATA_PACIENTE.FECHANACTO);
                    $("#fonoLabel").html(DATA_PACIENTE.NUM_CELULAR);
                    $("#previsionLabel").html("<b><i>NO INFORMADO</i></b>");
                }
                $('#LISTADO_PROFESIONALES').selectpicker();
                $('#LISTADO_ESPECIALIDAD').selectpicker();
                $('#IND_TIPO_BIOPSIA').selectpicker();
            }


            if (index == 2){
                var msj                                     =   [];
                $('#LISTADO_PROFESIONALES,#IND_TIPO_BIOPSIA,#LISTADO_ESPECIALIDAD').selectpicker('setStyle','border-red','remove');
                if($("#IND_TIPO_BIOPSIA").val()=='')        {
                    $('#IND_TIPO_BIOPSIA').selectpicker('setStyle','border-red', 'add');
                    msj.push("<li>Indicar <b>Tipo de biopsia</b></li>");
                }

                if($("#LISTADO_PROFESIONALES").val()=='')   {
                    $('#LISTADO_PROFESIONALES').selectpicker('setStyle','border-red', 'add');
                    msj.push("<li>Indicar profesional a cargo</li>");
                }
                if($("#LISTADO_ESPECIALIDAD").val()=='')    {
                    $('#LISTADO_ESPECIALIDAD').selectpicker('setStyle','border-red', 'add');
                    msj.push("<li>Indicar especialidad en la solicitud</li>");
                }
                if (msj.length>0){
                    jAlert("Se han detectado falta de informaci&oacute;n <br>"+msj.join(""),"Clinica Libre");
                    return false;
                } else {
                    
                    //
                    $("#HTML_TEMPLATE_3_PASEQUIRUGICO").html("Cargando formulario...");
                    
                    $.ajax({ 
                        type        :   "POST",
                        url         :   "Ssan_libro_biopsias_usuarioext/FORMULARIO_ANATOMIA_PATOLOGICA_V2",
                        dataType    :   "json",
                        beforeSend  :   function(xhr)   {
                                                            var HTML_BEFORESEND =   '<tbody id="msj_busqueda" style="display: none">'+
                                                                                        '<tr id="msj_load_body">'+
                                                                                            '<td style="text-align:center" colspan="11">'+
                                                                                                '<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>'+
                                                                                                '<span class="sr-only"></span><b> CARGANDO ...</b>'+
                                                                                            '</td>'+
                                                                                        '</tr>'+
                                                                                    '</tbody>';
                                                            $("#HTML_TEMPLATE_3_PASEQUIRUGICO").html(HTML_BEFORESEND); 
                                                        },
                        data        :           {
                                                    NUM_FICHAE          :   $("#DATA_PACIENTE_TEMPLATE").data().NUM_FICHAE,
                                                    RUT_PACIENTE        :   $("#DATA_PACIENTE_TEMPLATE").data().COD_RUTPAC,
                                                    ID_MEDICO           :   null,
                                                    RUT_MEDICO          :   $("#LISTADO_PROFESIONALES").val(),
                                                    IND_TIPO_BIOPSIA    :   $("#IND_TIPO_BIOPSIA").val(),// 
                                                    IND_ESPECIALIDAD    :   $("#LISTADO_ESPECIALIDAD").val(),
                                                    PA_ID_PROCARCH      :   $("#PA_ID_PROCARCH").val(),
                                                    AD_ID_ADMISION      :   null,
                                                    TXT_BIOPSIA         :   $("#IND_TIPO_BIOPSIA option:selected").text(),
                                                    CALL_FROM           :   0,
                                                    IND_GESPAB          :   0
                                                },
                        error       :   function(errro) {  
                                                            jAlert("Error General, Consulte Al Administrador","Clinica Libre"); 
                                                            console.log(errro);
                                                            //console.log(errro.responseText);
                                                            $("#HTML_TEMPLATE_3_PASEQUIRUGICO").html(''); 
                                                            $("#MODAL_INICIO_SOLICITUD_ANATOMIA").modal("hide"); 
                                                        },
                        success     :   function(aData) {
                                                            console.log("success -> ",aData);
                                                            $("#HTML_TEMPLATE_3_PASEQUIRUGICO").html(aData.HTML_FINAL);
                                                            setTimeout(function() {
                                                                $(".btn_envia_form").prop('disabled', false);
                                                                document.getElementById("btn-finish").disabled = false;
                                                            }, 1000); // 1000 milisegundos = 1 segundo
                                                        }, 
                    });
                }
            }
            if (index == 3){
                jAlert("Valida Formulario","Clinica Libre");


            }

            var form = $('#myWizard form');
            console.log("   form    ->  ",form);
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

function selecionapaciente(this_){
    var DATA_PACIENTE                                   =   $("#"+this_.id).data().bloque;
    //console.log("--------------------------------------------");
    console.log("DATA_PACIENTE  ->",DATA_PACIENTE);
    console.log("this_          ->",this_);
    console.log("this_id        ->",this_.id);
    //console.log("--------------------------------------------");
    $("#DATA_PACIENTE_TEMPLATE").removeData();
    $("#DATA_PACIENTE_TEMPLATE").data(DATA_PACIENTE);
    document.getElementById("btn-next").disabled        =   false;
}

function buscar(OP,LIM_INI){
    $("#busq_rut").css("border-color","");
    $("#busq_rutfonasa").css("border-color","");
    $("#busq_dni").css("border-color","");
    $("#busq_name").css("border-color","");
    $("#busq_apellidoP").css("border-color","");
    $("#busq_apellidoM").css("border-color","");
    
    $("#resultados_busquedapac,#new_paginacion").hide();
    $("#msj_busqueda").show();

    document.getElementById("BTN_BUSQ_PAC_1").disabled          =   true;
    document.getElementById("BTN_DELETE_PAC_1").disabled        =   true;
    document.getElementById("BTN_BUSQ_PAC_2").disabled          =   true;
    document.getElementById("BTN_DELETE_PAC_2").disabled        =   true;
    
    var tipoEx		    =   $("input[name='tipoEx']:checked").val();
    var tipoPac		    =   $("input[name='tipPac']:checked").val();
    var rut             =   tipoPac=='0'?$("#busq_rut").val():$("#busq_rutfonasa").val();
    var pasaporte       =   $("#busq_dni").val();
    var nombre		    =   $("#busq_name").val();
    var apellidoP       =   $("#busq_apellidoP").val();
    var apellidoM       =   $("#busq_apellidoM").val();
    var numxpag		    =   10;
    /*
        console.log("-------------------------------------------------------");
        console.log(" --------> rut         -----> ",rut);
        console.log(" --------> nombre      -----> ",nombre);
        console.log(" --------> apellidoP   -----> ",apellidoP);
        console.log(" --------> apellidoM   -----> ",apellidoM);
        console.log(" --------> tipoPac     -----> ",tipoPac);
        console.log(" --------> tipoEx      -----> ",tipoEx);
        console.log(" --------> pasaporte   -----> ",pasaporte);
        console.log("-------------------------------------------------------");
    */
    //FORMATEO RUT PUNTOS EN INPUT
    if(rut!=''){
        rut                 =   rut.replace(/\./g,'');
        rut                 =   rut.split('-');
        rut                 =   rut[0];
    }
    var tabs_activado       =   localStorage.getItem("ind_tipo_busqueda_paciente"); 
    //console.log("-----------------------------------------------------------");
    //console.log("tabs     ->  ",tabs_activado);
    //console.log("-----------------------------------------------------------");
    var valida              =   0;
    if(tabs_activado        ==  '#DIV_BUSQUEDA_PARAMETROS'){
        if (nombre != '' || apellidoP != '' || apellidoM != '') {
            valida          =   1;
        } 
        rut                 =   '';
        pasaporte           =   '';
    } else {
        if (rut != '' || pasaporte != '') {
            valida          =   1;
        }
        nombre              =   '';
        apellidoP           =   '';
        apellidoM           =   '';
    }
    /*
    if ((rut!= '' || nombre != '' || apellidoP != '' || apellidoM != '') && (tipoPac == 0)) {
        valida              =   1;
    } else if ((rut != '' || pasaporte != '' || nombre != '' || apellidoP != '' || apellidoM != '') && (tipoPac == 1)){
        valida              =   1;
    }
    */

    if (valida === 0)   {
   
        jError("Debe Ingresar a lo menos un par&aacute;metro para la b&uacute;squeda","Restricci\u00f3n");
   
        $("#busq_rut").css("border-color","red");
        $("#busq_rutfonasa").css("border-color","red");
        $("#busq_dni").css("border-color","red");
        $("#busq_name").css("border-color","red");
        $("#busq_apellidoP").css("border-color","red");
        $("#busq_apellidoM").css("border-color","red");
        $("#resultados_bdu").html('');
        $("#msj_load_body,#result").hide();
        $("#msj_load").remove();
        $("#resultados_busquedapac").show();
        $("#resultados").html('');

        document.getElementById("BTN_BUSQ_PAC_1").disabled          =   false;
        document.getElementById("BTN_DELETE_PAC_1").disabled        =   false;
        document.getElementById("BTN_BUSQ_PAC_2").disabled          =   false;
        document.getElementById("BTN_DELETE_PAC_2").disabled        =   false;

    } else {
        $("#msj_busqueda").html(`<tr id="msj_load_body">
                                        <td style="text-align:center" colspan="11">
                                            <i class="fa fa-cog fa-spin fa-2x fa-fw"></i>
                                            <span class="sr-only"></span><b> BUSCANDO...</b>
                                        </td>
                                    </tr>`);
        $.ajax({ 
            type            :	"POST",
            url             :	"ssan_bdu_creareditarpaciente/buscarPac_resumido",
            dataType        :	"json",
            data            : 
                                                    { 
                                                        numFichae   :   '',
                                                        rut         :   rut,
                                                        tipoEx      :   tipoEx,
                                                        tipoPac     :   tipoPac,
                                                        pasaporte   :   pasaporte,
                                                        nombre      :   nombre,
                                                        apellidoP   :   apellidoP,
                                                        apellidoM   :   apellidoM,
                                                        LIM_INI     :   LIM_INI,
                                                        numxpag     :   numxpag,
                                                        OP          :   OP,
                                                        templete    :   6 //anatomia ext
                                                    },
            error           :	function(errro)     {  
                                                        $("#msj_load").remove(); 
                                                        $("#msj_busqueda").html('');
                                                        console.log(errro.responseText); 
                                                        console.log(errro); 
                                                        //***********************************************************
                                                        document.getElementById("BTN_BUSQ_PAC_1").disabled          =   false;
                                                        document.getElementById("BTN_DELETE_PAC_1").disabled        =   false;
                                                        document.getElementById("BTN_BUSQ_PAC_2").disabled          =   false;
                                                        document.getElementById("BTN_DELETE_PAC_2").disabled        =   false;
                                                        //***********************************************************
                                                        jAlert("Error General, Consulte Al Administrador"); 
                                                        //("#resultados_busquedapac")
                                                    },
            success         :	function(aData)     {
                                                        console.log("----------------------------");
                                                        console.log("aData -> ",aData);

                                                        $("#msj_busqueda").html('');
                                                        $("#msj_load").remove();
                                                        $("#resultados").html('');
                                                        $("#new_paginacion").show("slow");
                                                        
                                                        document.getElementById("BTN_BUSQ_PAC_1").disabled          =   false;
                                                        document.getElementById("BTN_DELETE_PAC_1").disabled        =   false;
                                                        document.getElementById("BTN_BUSQ_PAC_2").disabled          =   false;
                                                        document.getElementById("BTN_DELETE_PAC_2").disabled        =   false;

                                                        if(AjaxExtJsonAll(aData)){

                                                        }
                                                    }, 
        });
        $("#resultados").html('');
    }
}
</script>
