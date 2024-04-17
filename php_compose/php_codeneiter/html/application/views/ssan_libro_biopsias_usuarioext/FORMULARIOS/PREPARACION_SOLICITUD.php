<?php

/*
    $string     =   '{"indice_uno": 12345,"indice_2": 2}';
    $string     =   str_replace('\n', '', $string);
    $string     =   rtrim($string, ',');
    $string     =   "[" . trim($string) . "]";
    $json       =   json_decode($string, true);
    var_dump($json[0]["indice_uno"]);
    var_dump($json[0]["indice_2"]);
*/

?>

<style>
.PANEL_BUSQUEDAPACIENTE         {
    display                     :   grid;
    grid-template-columns       :   32.5% 35% 32.5%;
    grid-column-gap             :   5px;
    grid-row-gap                :   20px;
    margin-top                  :   0px;
    margin-bottom               :   0px;
}
</style>

<div class="card card-wizard" id="wizardCard">
    <form id="wizardForm" method="" action="">
        <div class="header text-center">
            <h4 class="title" style="color:#e34f49;margin-left:20px;margin-top: 10px;">
                <b>PANEL DE SOLICITUD DE ANATOM&Iacute;A PATOL&Oacute;GICA</b>
                <p class="category">Divida un flujo complicado en varios pasos</p>
            </h4>
        </div>
        <div class="content">
            <ul class="nav">
                <li><a href="#tab1" data-toggle="tab">B&Uacute;SQUEDA DE PACIENTE</a></li>
                <li><a href="#tab2" data-toggle="tab">INFORMACI&Oacute;N ADICIONAL</a></li>
                <li><a href="#tab3" data-toggle="tab">FORMULARIO ANATOM&Iacute;A PATOL&Oacute;GICA</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="tab1">
 
                    <!-- INICIO TABS -->
                        <div class="PANEL_BUSQUEDAPACIENTE">
                            <div class="PANEL_LEFT_NULL_1">
                                &nbsp; 
                            </div>
                            <div class="PANEL_LEFT_BDU">

                               <div class="card" style="margin-bottom: 10px;">
                                    <div class="card-body content">
                                        <div id="TABS_BUSQUEDAPACIENTE" style="width:100%;padding:0px;">
                                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                                <li role="presentation" class="active">
                                                    <a href="#DIV_BUSQUEDA_PAC_NUMERO" aria-controls="DIV_BUSQUEDA_PAC_NUMERO" role="tab" data-toggle="tab"> 
                                                        <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;NUMERO IDENTIFICADOR
                                                        <span class="badge" id="num_ic_5"></span> 
                                                    </a>
                                                </li>
                                                <li role="presentation">
                                                    <a href="#DIV_BUSQUEDA_PARAMETROS" aria-controls="DIV_BUSQUEDA_PARAMETROS" role="tab" id="4" data-toggle="tab">
                                                        <i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;BUSQUEDA POR PARAMETROS
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
                                                            <label class="radio checked" onclick="cambiaTip(0)" id="label_tipPac_nac">
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
                                                            <button type="button" class="btn btn-small btn-primary btn-sm btn-fill btn_buscar_paciente" onclick="buscar(0,1);" id="btn_buscageneral_1">
                                                                 <i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR
                                                             </button>
                                                             <button type="button" class="btn btn-small btn-danger btn-sm btn-fill btn_limpiar_busq_pac" onclick="limpiar_card_busqueda(1);" id="btn_limpiageneral_1">
                                                                 <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;LIMPAR
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
                                                            <button type="button" class="btn btn-small btn-primary btn-sm btn-fill btn_buscar_paciente" onclick="buscar(0,1);" id="btn_buscageneral_2">
                                                                 <i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR
                                                             </button>
                                                             <button type="button" class="btn btn-small btn-danger btn-sm btn-fill btn_limpiar_busq_pac" onclick="limpiar_card_busqueda(1);" id="btn_limpiageneral_2">
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
                                    <div class="card" id="card_busquedablobalpaciente">
                                        <div class="header">
                                            <h4 class="title"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;&nbsp;<b>RESULTADO DE B&Uacute;SQUEDA PACIENTE</b></h4>
                                            <p>Busqueda de pacientes registrado SSAN.</p>
                                        </div>
                                        <div class="content card-body">
                                            <table class="table table-striped" style="width: 100%; margin-top: -26px;">
                                                <thead>
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
                                                    <tr id="msj_load_body"><td style="text-align:center" colspan="11"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><b>BUSCANDO...</b></td></tr>
                                                </tbody>
                                                <tbody id="resultados"></tbody>
                                                <tbody id="mensajeSinresultados_1"></tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer bg-transparent border-success">
                                            <div style="text-align:center;" align="center">  
                                                <div id="new_paginacion" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="PANEL_LEFT_NULL_2">
                                &nbsp; 
                            </div>
                        </div>
                    <!-- FINAL TABS -->
                    
                </div>
                <div class="tab-pane" id="tab2">
                    
                    <div class="PANEL_BUSQUEDAPACIENTE">
                        <div class="PANEL_LEFT_NULL_1">
                            &nbsp; 
                        </div>
                        <div class="PANEL_LEFT_BDU">
                            
                            
                            <div class="card" id="CARD_SEGUNDO_PANEL" style="margin-bottom: 15px;">
                                 <div class="header" style="padding-top: 12px;margin-bottom: -10px;">
                                <h4 class="title"><i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;<b>PACIENTE A CITAR</b></h4>
                                <p>Informaci&oacute;n basica del paciente.</p>
                            </div>
                            <div class="content card-body">

                                <div class="table-responsive" style="margin-top: -15px;">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <h6 class="my-0">NOMBRE DEL PACIENTE:</h6>
                                                        <small class="text-muted" id="nombreLabel">BENJAMIN NELSON CASTILLO</small>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <h6 class="my-0">SEXO:</h6>
                                                        <small class="text-muted" id="sexoLabel">MASCULINO</small>
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
                          
                            
                            <div class="card" id="CARD_SEGUNDO_PANEL" style="margin-bottom: 15px;">
                                <div class="header" style="padding-top: 12px;margin-bottom: -22px;">
                                    <h4 class="title">
                                        <i class="fa fa-hospital-o" aria-hidden="true"></i>&nbsp;<b>SERVICIO ASOCIADO</b>
                                        <p>Seleccione Servicio</p>
                                    </h4>
                                </div>
                                <hr style="margin: 10px 0px 0px 0px">
                                <div class="card-body content">
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="LISTADO_SERVICIOS" id="LISTADO_SERVICIOS" >
                                        <?php 
                                            echo '<option value="">SELECIONE</option>';
                                            if (count($C_LISTADOSERVICIOS)>0){
                                                foreach ($C_LISTADOSERVICIOS as $i => $row){
                                                    echo '<option value="'.$row["ID"].'">'.$row["TXT_DES"].'</option>'; 
                                                }
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="header" style="padding-top: 12px;margin-bottom: -22px;">
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
                                                foreach ($C_LISTADOMEDICOS as $i => $row){
                                                    echo '<option value="'.$row["ID_PRO"].'">'.$row["NOM_PROFE"].'</option>'; 
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="PANEL_LEFT_NULL_2">
                            &nbsp; 
                        </div>
                    </div>
                
                </div>
                <div class="tab-pane" id="tab3">
                    
                    <div id="HTML_TEMPLATE_ANATOMIA"></div>
                    
                </div>
            </div>
        </div>
        <div class="footer">
            <button type="button" id="btn-back"     class="btn btn-default    btn-back    btn-fill btn-wd  pull-left"     ><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;<b>VOLVER</b></button>
            <button type="button" id="btn-next"     class="btn btn-info       btn-next    btn-fill btn-wd  pull-right"    disabled="disabled"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;<b>SIGUIENTE</b></button>
            <button type="button" id="btn-finish"   class="btn btn-info       btn-finish  btn-fill btn-wd  pull-right"    onclick="onFinishWizard()">ENVIAR SOLICITUD</button>
            <div class="clearfix"></div>
        </div>
    </form>
</div>
    
<script type="text/javascript">
function selecionapaciente(this_){
    var DATA_PACIENTE           =   $("#"+this_.id).data().bloque;
    console.log("this_          ->",this_);
    console.log("this_id        ->",this_.id);
    console.log("BLOQUE         ->",DATA_PACIENTE);
    document.getElementById("btn-next").disabled = false;
}
    
function buscar(OP,LIM_INI){
    
    console.log("---------------------------------------------------------------");
    console.log("OP->",OP,"LIM_INI->",LIM_INI);
    console.log("---------------------------------------------------------------");
    
    $("#busq_rut").css("border-color","");
    $("#busq_rutfonasa").css("border-color","");
    $("#busq_dni").css("border-color","");
    $("#busq_name").css("border-color","");
    $("#busq_apellidoP").css("border-color","");
    $("#busq_apellidoM").css("border-color","");
    
    $("#resultados_busquedapac,#new_paginacion").hide();
    $("#msj_busqueda").show();
    document.getElementById("btn_buscageneral_1").disabled = true;
    document.getElementById("btn_buscageneral_2").disabled = true;
    
    var tipoEx		=   $("input[name='tipoEx']:checked").val();
    var tipoPac		=   $("input[name='tipPac']:checked").val();
    var rut		=   tipoPac=='0'?$("#busq_rut").val():$("#busq_rutfonasa").val();
    var pasaporte	=   $("#busq_dni").val();
    var nombre		=   $("#busq_name").val();
    var apellidoP	=   $("#busq_apellidoP").val();
    var apellidoM	=   $("#busq_apellidoM").val();
    var numxpag		=   10;
    
    /*
        console.log(" --------> rut         -----> ",rut);
        console.log(" --------> nombre      -----> ",nombre);
        console.log(" --------> apellidoP   -----> ",apellidoP);
        console.log(" --------> apellidoM   -----> ",apellidoM);
        console.log(" --------> tipoPac     -----> ",tipoPac);
        console.log(" --------> tipoEx      -----> ",tipoEx);
        console.log(" --------> pasaporte   -----> ",pasaporte);
    */
   
   
    //FORMATEO RUT PUNTOS
    if (rut!=''){
        rut             =   rut.replace(/\./g,'');
        rut             =   rut.split('-');
        rut             =   rut[0];
    }
    
    var valida          =   0;
    if ((rut!= '' || nombre != '' || apellidoP != '' || apellidoM != '') && (tipoPac == 0)) {
        valida          =   1;
    } else if ((rut != '' || pasaporte != '' || nombre != '' || apellidoP != '' || apellidoM != '') && (tipoPac == 1)){
        valida          =   1;
    }
   
    if (valida      == 0){
        
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
        
        document.getElementById("btn_buscageneral_1").disabled = false;
        document.getElementById("btn_buscageneral_2").disabled = false;
    
    } else {
        
        //$("#icoLoa").css('display','inline-block');
        //$("#txBusc").html('Buscando');
        
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
                                                        templete    :   6 //anatomia
                                                    },
            error           :	function(errro)     {  
		
                                                        $("#msj_load").remove(); 
                                                        $("#resultados").html(''); 
                                                        $("#msj_busqueda").hide();
                                                        console.log(errro.responseText); 
                                                        console.log(errro); 
                                                        document.getElementById("btn_buscageneral_1").disabled = false;
                                                        document.getElementById("btn_buscageneral_2").disabled = false;
                                                        jAlert("Error General, Consulte Al Administrador"); 
                                                    },
            success         :	function(aData)     { 
                                                        console.log("aData -> ",aData," <-  "); 
                                                        $("#msj_busqueda").hide();
                                                        $("#msj_load").remove();
                                                        $("#resultados").html('');
                                                        $("#new_paginacion").show("slow");
                                                        document.getElementById("btn_buscageneral_1").disabled = false;
                                                        document.getElementById("btn_buscageneral_2").disabled = false;
                                                        
                                                        if(AjaxExtJsonAll(aData)){
                                                            
                                                        } 
                                                    }, 
        });
	$("#resultados").html('');
    }
}
</script>

    <script type="text/javascript">
        $().ready(function(){
            
            $('#wizardCard').bootstrapWizard({
            	tabClass            :   'nav nav-pills',
                nextSelector        :   '.btn-next',
                previousSelector    :   '.btn-back',
                onNext              :   function(tab,navigation,index){
                    
                                            console.log(" ------------------------------------------------------- ");
                                            console.log(" tab               -> ",tab);
                                            console.log(" navigation        -> ",navigation);
                                            console.log(" index             -> ",index);
                                            console.log(" ------------------------------------------------------- ");
                                            
                                            if(index == 1){
                                                console.log("Primera impresoin next");
                                            }
                                            
                                            if(index == 2){
                                                var msj         =   [];
                                                $("#LISTADO_SERVICIOS").css('border-color','');  
                                                
                                                if($("#LISTADO_SERVICIOS").val()==''){
                                                    $("#LISTADO_SERVICIOS").css('border-color','red');
                                                    msj.push("<li>Indicar Servicio Asociado</li>");
                                                }
                                                
                                                $("#LISTADO_PROFESIONALES").css('border-color','');  
                                                if($("#LISTADO_PROFESIONALES").val()==''){
                                                    msj.push("<li>Indicar profesional a cargo</li>");
                                                }
                                                console.log("----------------------------------------");
                                                console.log("msj            -----------> ",msj);
                                                console.log("msj.length     -----------> ",msj.length);
                                                console.log("----------------------------------------");
                                                if (msj.length>0){
                                                    jAlert("Se Han Detectado Falta De Informaci&oacute;n <br>"+msj.join(""),"e-SISSAN");
                                                    return false;
                                                } else {
                                                    
                                                    $.ajax({ 
                                                        type                :   "POST",
                                                        url                 :   "ssan_libro_biopsias_usuarioext/HTML_SOLICITUD_ANATOMIA",
                                                        dataType            :   "json",
                                                        beforeSend          :   function(xhr)       {   
                                                                                                        console.log("xhr->",xhr);
                                                                                                    },
                                                        data                :                       {
                                                                                                        NUM_FICHAE      :   124768,
                                                                                                        ID_SERV         :   $("#LISTADO_SERVICIOS").val(),
                                                                                                        ID_MEDICO       :   $("#LISTADO_PROFESIONALES").val(),
                                                                                                    },
                                                        error		    :   function(errro)     {  
                                                                                                        $("#MODAL_INICIO_SOLICITUD_ANATOMIA").modal("hide"); 
                                                                                                        jAlert("<b> Error General, Consulte Al Administrador</b>"); 
                                                                                                        console.log(errro);
                                                                                                        console.log(errro.responseText);
                                                                                                    },
                                                        success             :   function(aData)     { 
                                                                                                        console.log("----------------------------------------------------------------------");
                                                                                                        console.log("------------------",aData,"-------------------------------------------");
                                                                                                        console.log("----------------------------------------------------------------------");
                                                                                                        //$("#HTML_SOLICITUD_ANATOMIA").html(aData["GET_HTML_ANATOMIA"]);
                                                                                                    }, 
                                                    });
                                                }
                                            }
                },
                onInit              :   function(tab,navigation,index){
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
                
                onTabClick          :   function(tab,navigation,index){
                    // Desactive la posibilidad de hacer clic en pestañas
                    console.log("----------------------------------------");
                    console.log("---------- js_  show  onTabClick -------");
                    console.log("----------------------------------------");
                    return false;
                },
                
                onTabShow           :   function(tab,navigation,index){
                    
                        console.log("----------------------------------------");
                        console.log("---------- js_  show  onTabShow --------");
                        console.log("----------------------------------------");
                        
                        var $total          =   navigation.find('li').length;
                        var $current        =   index+1;
                        var wizard          =   navigation.closest('.card-wizard');
                        // Si es la última pestaña, oculta el último botón y muestra el acabado.
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
                        
                    //}
                }
            });
            
            
            $('#busq_rut').Rut({
                on_error    :   function(){ jAlert('El Rut ingresado es Incorrecto. '+$("#busq_rut").val(),'Rut Incorrecto'); console.log($("#busq_rut").val());  $("#busq_rut").css('border-color','red'); $("#busq_rut").val('') },
                on_success  :   function(){ console.log($("#busq_rut").val()); $("#busq_rut").css('border-color',''); },
                format_on   :   'keyup'
            });
            $('#busq_rutfonasa').Rut({
                on_error    :   function(){ jAlert('El Rut ingresado es Incorrecto. '+$("#busq_rutfonasa").val(),'Rut Incorrecto'); console.log($("#busq_rutfonasa").val());  $("#busq_rutfonasa").css('border-color','red'); $("#busq_rutfonasa").val('') },
                on_success  :   function(){ console.log("this -> ",this.id); $("#busq_rutfonasa").css('border-color',''); },
                format_on   :   'keyup'
            });
            $("#new_paginacion").on('click','li',function(){
                if(!isNaN($(this).text())){ buscar(1,$(this).text()); }
            });


            $('#LISTADO_SERVICIOS').selectpicker();
            $('#LISTADO_PROFESIONALES').selectpicker();
    
        });
        
        function onFinishWizard(){
            //here you can do something, sent the form to server via ajax and show a success message with swal
            swal("Good job!", "You clicked the finish button!", "success");
        }
        
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
            $("#tipPac_0").prop("checked", true);
        } else {
            $("#tipPac_1").prop("checked",true);
            $("#iden_dni").show();
            $("#iden_idfonasa").hide();
            $("#trEx").show();
        }
    }
    function cambiaDoc(tipoDoc){
        //	1   -	DNI / PASAPORTE
        //	2   -	ID FONASA
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

</script>








