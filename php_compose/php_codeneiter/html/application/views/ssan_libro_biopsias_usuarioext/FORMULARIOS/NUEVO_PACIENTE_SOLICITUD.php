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
</style>

<input type="hidden" id="PA_ID_PROCARCH" name="PA_ID_PROCARCH" value="">

<div class="card card-wizard" id="WIZARDCARD" style="margin-bottom: 0px"> 
    <div class="content" style="margin-bottom: -13PX;">
        <ul class="nav" style="margin-top:-15px">
            <li><a href="#tab1" data-toggle="tab">B&Uacute;SQUEDA DE PACIENTE</a></li>
            <li><a href="#tab2" data-toggle="tab">INFORMACI&Oacute;N ADICIONAL</a></li>
            <li><a href="#tab3" data-toggle="tab"><i class="fa fa-wpforms" aria-hidden="true"></i>&nbsp;A.PATOLOGICA</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="tab1" style="margin: 0px 0px -15px 0px;">
                
                        <!-- PANEL BUSQUEDA DEL PACIENTE -->
                        <!-- nav-justified -->
                        <div class="card" style="margin-bottom: 10px;margin-top: -12px">
                            <div class="card-body content">
                                <div id="TABS_BUSQUEDAPACIENTE" style="width:100%;padding:0px;" >
                                    <ul class="nav nav-tabs main_busqueda_paciente" role="tablist">
                                        <li role="presentation" class="active"> 
                                            <a href="#DIV_BUSQUEDA_PAC_NUMERO" aria-controls="DIV_BUSQUEDA_PAC_NUMERO" role="tab" data-toggle="tab"> 
                                                <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;N&deg; DOCUMENTO/FICHA
                                                <span class="badge" id="num_ic_5"></span> 
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#DIV_BUSQUEDA_PARAMETROS" aria-controls="DIV_BUSQUEDA_PARAMETROS" role="tab" id="4" data-toggle="tab">
                                                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;POR PARAMETROS
                                                <span class="badge" id="num_ic_4"></span> 
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- <div class="card" style="padding: 12px;"> </div> -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="DIV_BUSQUEDA_PAC_NUMERO" style="padding: 10px;margin-bottom: -37px;">
                                        <div class="form-group" id="tip_paciente">
                                            <label class="control-label">TIPO&nbsp;PACIENTE<star>*</star></label>
                                            <div class="row">
                                                <div class="form-group label-floating col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <label class="radio checked" id="label_tipPac_nac" onclick="cambiaTip(0)">
                                                        <span class="icons">
                                                            <span class="first-icon fa fa-circle-o"></span>
                                                            <span class="second-icon fa fa-dot-circle-o"></span>
                                                        </span>
                                                        <input type="radio" data-toggle="radio" name="tipPac" id="tipPac_0" value="0"  checked>
                                                        <div id="txt_nacion" style="position: inherit;top: 2px;">NACIONAL</div>
                                                    </label>
                                                </div>
                                                <div class="form-group label-floating col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <label class="radio"  onclick="cambiaTip(1)" id="label_tipPac_ext">
                                                        <span class="icons">
                                                            <span class="first-icon fa fa-circle-o"></span>
                                                            <span class="second-icon fa fa-dot-circle-o"></span>
                                                        </span>
                                                        <input type="radio" data-toggle="radio" name="tipPac" id="tipPac_1" value="1">
                                                        <div id="txt_nomexj" style="position: inherit;top: 2px;">EXTRANJERO</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="trEx" style="margin-bottom: 0px; display: none;">
                                            <label class="control-label">TIPO&nbsp;DOCUMENTO<star>*</star></label>
                                            <div class="row">
                                                <div class="form-group label-floating col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <label class="radio checked" onclick="cambiaDoc(1)" id="label_tipoEx_dni">
                                                        <span class="icons">
                                                            <span class="first-icon fa fa-circle-o"></span>
                                                            <span class="second-icon fa fa-dot-circle-o"></span>
                                                        </span>
                                                        <input type="radio" name="tipoEx" id="tipoEx_1" data-toggle="radio" value="1" checked>
                                                        <div id="txtdoc" style="position: inherit;top: 2px;">DNI&nbsp;/&nbsp;PASAPORTE</div> 
                                                    </label>
                                                </div>
                                                <div class="form-group label-floating col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <label class="radio" onclick="cambiaDoc(2)" id="label_tipoEx_fonasa">
                                                        <span class="icons">
                                                            <span class="first-icon fa fa-circle-o"></span>
                                                            <span class="second-icon fa fa-dot-circle-o"></span>
                                                        </span>
                                                        <input type="radio" name="tipoEx" id="tipoEx_2" data-toggle="radio" value="2">
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
                                        <div class="form-group" id="iden_chileno" style="margin-bottom: 2px;margin-top: -15px;">
                                            <label class="control-label">RUN&nbsp;<star>*</star></label>
                                            <input type="text" id="busq_rut" name="busq_rut" class="form-control input-sm" style="width:101px;">
                                        </div>
                                        <div class="text-center">
                                            <div class="form-group">
                                                <div class="btn-group" style="margin-top: 12px;  margin-bottom: 13px;">
                                                    <button type="button" class="btn btn-small btn-primary btn-sm btn-fill btn_buscar_paciente" onclick="buscar(0,1);" id="BTN_BUSQ_PAC_1">
                                                        <i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR&nbsp;
                                                    </button>
                                                    <button type="button" class="btn btn-small btn-danger btn-sm btn-fill btn_limpiar_busq_pac" onclick="limpiar_card_busqueda(1);" id="BTN_DELETE_PAC_1">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;LIMPAR&nbsp;
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="DIV_BUSQUEDA_PARAMETROS" style="padding: 10px;margin-bottom: -37px;">
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
                            <div style="text-align:center;" align="center">  
                                <div id="new_paginacion" style="display: none;"></div>
                            </div>
                                
                        </div><!-- END PANEL BUSQUEDA DEL PACIENTE -->

            </div>
            <div class="tab-pane" id="tab2" style="margin: 0px 0px -31px 0px;">

                    <div class="card" id="CARD_SEGUNDO_PANEL" style="margin-bottom:7px;margin-top: -11px;">
                        <div class="header" style="padding-top: 12px;margin-bottom: -10px;">
                            <h4 class="title"><i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;<b>PACIENTE</b></h4>
                            <p>Informaci&oacute;n Basica Del Paciente.</p>
                        </div>
                        <div class="content card-body">
                            <div class="table-responsive" style="margin-top: -15px;">
                                <table class="table table-striped">
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
                                        <!--
                                        <tr>
                                            <td>
                                                <div>
                                                    <h6 class="my-0">INSCRITO:</h6>
                                                    <small class="text-muted" id="inscritoLabel"></small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <h6 class="my-0">N&deg; FICHA LOCAL:</h6>
                                                    <small class="text-muted" id="FichaLabel"></small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <h6 class="my-0">C&Oacute;D. DE FAMILIA:</h6>
                                                    <small class="text-muted" id="codigoFamilia"></small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <h6 class="my-0">SECTOR:</h6>
                                                    <small class="text-muted" id="sector"></small>
                                                </div>
                                            </td>
                                        </tr>
                                        -->
                                    </tbody>
                                </table>
                            </div>

                    </div>
                    <div class="content card-footer text-center" id="footer_btn_new_busqueda" style="display: none; margin-top:-24px;">
                        <button type="button" class="btn btn-danger btn-sm btn-fill" id="btn_buscaRut" name="btn_buscaRut" onclick="volver_a_busqueda(1)">
                            <i class="fa fa-reply" aria-hidden="true"></i>&nbsp;NUEVA BUSQUEDA PACIENTE
                        </button>
                    </div>
                </div>
                                
                <div class="card" style="margin-bottom: 10px;"> 
                    <div class="header" style="padding-top: 12px;margin-bottom: -22px;">
                        <h4 class="title">
                            <i class="fa fa-hospital-o" aria-hidden="true"></i>&nbsp;<b>TIPO DE BIOPSIA</b>
                            <p>Seleccione tipo de biopsia</p>
                        </h4>
                    </div>
                    <hr style="margin: 10px 0px 0px 0px">
                    <div class="card-body content">
                        <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="IND_TIPO_BIOPSIA" id="IND_TIPO_BIOPSIA">
                            <option value="">SELECIONE</option>
                            <!--<option value="0" data-subtext="DEFAULT">NO</option>-->
                            <!--<option value="1" data-subtext="Formulario + Lista De Muestras Anatom&iacute;a Patol&oacute;gica">SI</option> -->
                            <option value="2" data-subtext="Formulario + Lista De Muestras Anatom&iacute;a Patol&oacute;gica">CONTEMPORANEA</option>
                            <option value="3" data-subtext="Formulario + Lista De Muestras Anatom&iacute;a Patol&oacute;gica">DIFERIDA</option>
                            <option value="4" data-subtext="Formulario + Lista De Muestras Anatom&iacute;a Patol&oacute;gica + Lista Muestras Citolog&iacute;cas">BIOPSIA + CITOLOG&Iacute;A</option>
                            <option value="5" data-subtext="Formulario + Lista De Muestras Citolog&iacute;cas">CITOLOG&Iacute;A</option>
                            <option value="6" data-subtext="Formulario + Lista De Muestras PAP">CITOLOG&Iacute;A PAP</option>
                        </select>
                    </div>
                </div>
                <div class="card" style="margin-bottom: 10px;"> 
                    <div class="header" style="padding-top : 12px;margin-bottom: -22px;">
                        <h4 class="title">
                            <i class="fa fa-user-md" aria-hidden="true"></i>&nbsp;<b>PROFESIONAL</b>
                            <p>Seleccione Profesional</p>
                        </h4>
                    </div>
                    <hr style="margin: 10px 0px 0px 0px">
                    <div class="card-body content">
                        <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="LISTADO_PROFESIONALES" id="LISTADO_PROFESIONALES">
                            <?php 
                                echo '<option value="">SELECIONE</option>';
                                if (count($C_LISTADOMEDICOS)>0){
                                    foreach($C_LISTADOMEDICOS as $i => $row){
                                        $JSON2              =   htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');
                                        //$row["ID_PRO"]    =   $row["COD_RUTPRO"]
                                        echo '<option data-icon="fa-user-md" value="'.$row["COD_RUTPRO"].'"  data-PROFESIONAL="'.$JSON2.'" >'.$row["NOM_PROFE"].'</option>'; 
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="card" style="margin-bottom: 30px;"> 
                    <div class="header" style="padding-top: 12px;margin-bottom: -22px;">
                        <h4 class="title">
                            <i class="fa fa-hospital-o" aria-hidden="true"></i>&nbsp;<b>ESPECIALIDAD</b>
                            <p>Seleccione Especialidad asociada a la solicitud</p>
                        </h4>
                    </div>
                    <hr style="margin: 10px 0px 0px 0px">
                    <div class="card-body content">
                        <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="LISTADO_ESPECIALIDAD" id="LISTADO_ESPECIALIDAD">
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
            </div>
            <div class="tab-pane" id="tab3" style="margin:-25PX -15PX 0PX -15PX;">
                <div id="HTML_TEMPLATE_3_PASEQUIRUGICO"></div>
            </div>
        </div>
    </div>
    <div class="footer">
        <hr style="margin: 0px 0px 12px 0px">
            <button type="button" id="btn-back"     class="btn btn-default    btn-back    btn-fill btn-wd  pull-left"     >
                <i class="fa fa-reply" aria-hidden="true"></i>&nbsp;<b>VOLVER</b>
            </button>
            <button type="button" id="btn-next"     class="btn btn-info       btn-next    btn-fill btn-wd  pull-right"    disabled="disabled">
                &nbsp;<b id="TXT_BONT2">SIGUIENTE</b>&nbsp;<i class="fa fa-share" aria-hidden="true"></i>&nbsp;
            </button>
            <button type="button" id="btn-finish"   class="btn btn-info       btn-finish  btn-fill btn-wd  pull-right" id="ENVIA_FORMULARIO"  onclick="JS_GUARDAANATOMIA_EXTERNO()">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;ENVIAR ANATOMIA PATOLOGICA
            </button>
        <div class="clearfix"></div>
    </div>
</div>
    
<script type="text/javascript">
    
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
        
        var tipoEx		=   $("input[name='tipoEx']:checked").val();
        var tipoPac		=   $("input[name='tipPac']:checked").val();
        var rut                 =   tipoPac=='0'?$("#busq_rut").val():$("#busq_rutfonasa").val();
        var pasaporte           =   $("#busq_dni").val();
        var nombre		=   $("#busq_name").val();
        var apellidoP           =   $("#busq_apellidoP").val();
        var apellidoM           =   $("#busq_apellidoM").val();
        var numxpag		=   10;
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
        if (valida === 0){
            
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
            //$("#icoLoa").css('display','inline-block');
            //$("#txBusc").html('Buscando');
            console.log("->","ssan_bdu_creareditarpaciente/buscarPac_resumido","<-");
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
                error           :	function(errro) {  

                                                            $("#msj_load").remove(); 
                                                            $("#resultados").html(''); 
                                                            $("#msj_busqueda").hide();
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
                success         :	function(aData) { 
                                                            /*
                                                                console.log("----------------------------");
                                                                console.log("aData -> ",aData," <-       "); 
                                                                console.log("----------------------------");
                                                            */
                                                            $("#msj_busqueda").hide();
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

<script type="text/javascript">
    $(document).ready(function(){
        /*
        if(localStorage.getItem("storange_tabs_main")===null){
            localStorage.setItem("ind_tipo_busqueda_paciente","#DIV_BUSQUEDA_PAC_NUMERO");
        } else {
            localStorage.setItem("ind_tipo_busqueda_paciente","#DIV_BUSQUEDA_PAC_NUMERO");
        }
        */
        localStorage.setItem("ind_tipo_busqueda_paciente","#DIV_BUSQUEDA_PAC_NUMERO");
        $(".main_busqueda_paciente").on("shown.bs.tab",function(e){
            localStorage.setItem("ind_tipo_busqueda_paciente",$(e.target).attr("href"));
        });
        $('#WIZARDCARD').bootstrapWizard({
            tabClass            :   'nav nav-pills',
            nextSelector        :   '.btn-next',
            previousSelector    :   '.btn-back',
            onNext              :   function(tab,navigation,index){
                    /*
                        console.log("---------------------------------------------------");
                        console.log("tab            -> ",tab,"<-                        ");
                        console.log("navigation     -> ",navigation,"<-                 ");
                        console.log("index          -> ",index,"<-                      ");
                        console.log("---------------------------------------------------");
                    */
                    if(index == 1){
                        var PACIENTE_SEL                            =   $("input[name='SELECCIONA_PACIENTE']:checked").val();
                        //console.log("PACIENTE_SEL -> ",PACIENTE_SEL);
                        if(PACIENTE_SEL === undefined) {
                            jAlert("Seleccione Paciente","e-SISSAN");
                            return false;
                        } else {
                            var DATA_PACIENTE       =   $("#DATA_"+PACIENTE_SEL).data().bloque;
                            //console.log("DATA_PACIENTE ->",DATA_PACIENTE);
                            $("#numidentificador").html(DATA_PACIENTE.COD_RUTPAC+" "+DATA_PACIENTE.COD_DIGVER);
                            $("#nombreLabel").html(DATA_PACIENTE.NOM_NOMBRE+" "+DATA_PACIENTE.APEPATPAC+" "+DATA_PACIENTE.APEMATPAC);
                            $("#sexoLabel").html(DATA_PACIENTE.TIPO_SEXO);
                            $("#direccionLabel").html(DATA_PACIENTE.DIRECLOCAL+" "+DATA_PACIENTE.NCASAL);
                            $("#edadLabel").html(DATA_PACIENTE.FECHANACTO);
                            $("#fonoLabel").html(DATA_PACIENTE.NUM_CELULAR);
                            $("#previsionLabel").html("<b><i>NO INFORMADO</i></b>");
                        }
                    } else if(index == 2){
                        var msj                                     =   [];
                        $('#LISTADO_PROFESIONALES,#IND_TIPO_BIOPSIA,#LISTADO_ESPECIALIDAD').selectpicker('setStyle','btn-danger btn-fill','remove');
                        if($("#IND_TIPO_BIOPSIA").val()=='')        {
                            $('#IND_TIPO_BIOPSIA').selectpicker('setStyle','btn-danger btn-fill','add');
                            msj.push("<li>Indicar <b>Tipo de biopsia</b></li>");
                        }
                        if($("#LISTADO_PROFESIONALES").val()=='')   {
                            $('#LISTADO_PROFESIONALES').selectpicker('setStyle','btn-danger btn-fill','add');
                            msj.push("<li>Indicar profesional a cargo</li>");
                        }
                        if($("#LISTADO_ESPECIALIDAD").val()=='')    {
                            $('#LISTADO_ESPECIALIDAD').selectpicker('setStyle','btn-danger btn-fill','add');
                            msj.push("<li>Indicar especialidad en la solicitud</li>");
                        }
                        if (msj.length>0){
                            jAlert("Se han detectado falta de informaci&oacute;n <br>"+msj.join(""),"e-SISSAN");
                            return false;
                        } else {
                            //$(".btn-finish").show();
                            $("#HTML_TEMPLATE_3_PASEQUIRUGICO").html("");
                            //console.log("LISTADO_ESPECIALIDAD   ->  ",$("#LISTADO_ESPECIALIDAD").val());
                            $.ajax({ 
                                type                :   "POST",
                                url                 :   "ssan_spab_gestionlistaquirurgica/FORMULARIO_ANATOMIA_PATOLOGICA_V2",
                                dataType            :   "json",
                                beforeSend          :   function(xhr)       {
                                    //console.log("------------------------------");
                                    //console.log("       xhr->",xhr,"<-         ");
                                    //console.log("------------------------------");
                                    var HTML_BEFORESEND     =   '<tbody id="msj_busqueda" style="display: none">'+
                                                                    '<tr id="msj_load_body">'+
                                                                        '<td style="text-align:center" colspan="11">'+
                                                                            '<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>'+
                                                                            '<span class="sr-only"></span><b> CARGANDO ...</b>'+
                                                                        '</td>'+
                                                                    '</tr>'+
                                                                '</tbody>';
                                    $("#HTML_TEMPLATE_3_PASEQUIRUGICO").html(HTML_BEFORESEND); 
                                },
                                data                :                   {
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
                                error		:   function(errro)     {  
                                                                            jAlert("<b>Error General, Consulte Al Administrador</b>"); 
                                                                            console.log(errro);
                                                                            console.log(errro.responseText);
                                                                            $("#HTML_TEMPLATE_3_PASEQUIRUGICO").html(''); 
                                                                            $("#MODAL_INICIO_SOLICITUD_ANATOMIA").modal("hide"); 
                                },
                                success             :   function(aData) {
                                                                            console.log("success -> ",aData);
                                                                            $("#HTML_TEMPLATE_3_PASEQUIRUGICO").html(aData["HTML_FINAL"]);
                                                                            if(aData["HTML_FINAL"]){
                                                                                $(".btn-finish").show();
                                                                            } else {
                                                                                $(".btn-finish").hide();
                                                                            }
                                                                        }, 
                            });
                        }
                } else if(index == 3){

                } 
            },
            onInit              :   function(tab,navigation,index)  {
                                                                        console.log("------------------------------------");
                                                                        console.log("---------- js_  show  onInit -------");
                                                                        console.log("------------------------------------");
                                                                        //verifique el número de pestañas y llene toda la fila
                                                                        var $total              =   navigation.find('li').length;
                                                                        $width                  =   100/$total;
                                                                        $display_width          =   $(document).width();
                                                                        if($display_width<600 && $total>3){
                                                                           $width               =   50;
                                                                        }
                                                                        navigation.find('li').css('width',$width + '%');
            },
            onTabClick          :   function(tab,navigation,index)  {
                                                                        // Desactive la posibilidad de hacer clic en pestañas
                                                                        console.log("----------------------------------------");
                                                                        console.log("---------- js_  show  onTabClick -------");
                                                                        console.log("----------------------------------------");
                                                                        return false;
                                                                    },
            onTabShow   :   function(tab,navigation,index)          {
                                                                        var $total          =   navigation.find('li').length;
                                                                        var $current        =   index+1;
                                                                        var wizard          =   navigation.closest('.card-wizard');
                                                                        // Si es la ultima pestana, oculta el ultimo boton y muestra el acabado.
                                                                        if($current>= $total) {
                                                                            $(wizard).find('.btn-next').hide();
                                                                            $(wizard).find('.btn-finish').show();
                                                                        } else if($current == 1){
                                                                            $(wizard).find('.btn-back').hide();
                                                                        } else {
                                                                            $(wizard).find('.btn-back').show();
                                                                            $(wizard).find('.btn-next').show();
                                                                            $(wizard).find('.btn-finish').hide();
                                                                        }
            }
        });
        
        $('#busq_rut').Rut({
            on_error    :   function(){ jAlert('El Rut ingresado es Incorrecto. '+$("#busq_rut").val(),'RUN Incorrecto'); console.log($("#busq_rut").val());  $("#busq_rut").css('border-color','red'); $("#busq_rut").val(''); },
            on_success  :   function(){ console.log($("#busq_rut").val()); $("#busq_rut").css('border-color',''); },
            format_on   :   'keyup'
        });
        $('#busq_rutfonasa').Rut({
            on_error    :   function(){ jAlert('El Rut ingresado es Incorrecto. '+$("#busq_rutfonasa").val(),'RUN Incorrecto'); console.log($("#busq_rutfonasa").val()); $("#busq_rutfonasa").css('border-color','red'); $("#busq_rutfonasa").val(''); },
            on_success  :   function(){ console.log("this -> ",this.id); $("#busq_rutfonasa").css('border-color',''); },
            format_on   :   'keyup'
        });
        $("#new_paginacion").on('click','li',function(){
            if(!isNaN($(this).text())){ buscar(1,$(this).text()); }
        });
        $('#LISTADO_PROFESIONALES').selectpicker();
        $('#LISTADO_ESPECIALIDAD').selectpicker();
        $('#IND_TIPO_BIOPSIA').selectpicker();
    });
</script>
                    
<script type="text/javascript">
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