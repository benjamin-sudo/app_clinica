<?php 
    $ID_SOLICITUD   =   $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];
    $NUM_FICHAE     =   $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_FICHAE"];
?>
<ul class="nav nav-tabs" id="tabs_rce_analitica" role="tablist">
    <li class="nav-item" role="tab">
        <a class="nav-link active" id="rce-tab" data-bs-toggle="tab" href="#pabel_principal" role="tab" aria-controls="pabel_principal" aria-selected="true"><i class="fa fa-user-md" aria-hidden="true"></i>&nbsp;RCE</a>
    </li>
    <li class="nav-item" role="tab">
        <a class="nav-link" id="prestaciones-tab" data-bs-toggle="tab" href="#panel_prestaciones" role="tab" aria-controls="panel_prestaciones" aria-selected="false"><i class="fa fa-list-ul" aria-hidden="true"></i>&nbsp;PRESTACIONES</a>
    </li>
    <li class="nav-item" role="tab">
        <a class="nav-link" id="microscopica-tab" data-bs-toggle="tab" href="#panel_muestras" role="tab" aria-controls="panel_muestras" aria-selected="false"><i class="fa fa-columns" aria-hidden="true"></i>&nbsp;MICROSC&Oacute;PICA</a>
    </li>
    <li class="nav-item" role="tab">
        <a class="nav-link" id="administrativo-tab" data-bs-toggle="tab" href="#registro_administrativo" role="tab" aria-controls="registro_administrativo" aria-selected="false"><i class="fa fa-wpforms" aria-hidden="true"></i>&nbsp;ADMINISTRATIVO</a>
    </li>
    <li class="nav-item" onclick="js_load_line_pdf(0,<?php echo $ID_SOLICITUD;?>)" role="tab" style="display:none">
        <a class="nav-link" id="pdf-tab" data-bs-toggle="tab" href="#tabs_pdf" role="tab" aria-controls="tabs_pdf" aria-selected="false"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
    </li>
    <li class="nav-item" id="li_histo_clinico" onclick="js_views_historial_clinico_(<?php echo $NUM_FICHAE;?>)" role="tab" style="display:none">
        <a class="nav-link" href="#historial_clinico" data-bs-toggle="tab" role="tab" aria-controls="historial_clinico" aria-selected="false">
            <i class="fa fa-heartbeat" aria-hidden="true"></i>
        </a>
    </li>
    <li class="nav-item" role="tab">
        <a class="nav-link" id="archivos-ap-tab" data-bs-toggle="tab" href="#add_archivos_ap" role="tab" aria-controls="add_archivos_ap" aria-selected="false"><i class="fa fa-cloud-upload" aria-hidden="true"></i></a>
    </li>
</ul>
<div class="tab-content">
    <div id='tabs_pdf' class='tab-pane margin_panel_tabs'>
        <div class="panel_vistas_pdf" style="display: none">
            <div class="panel_vistas_pdf1">&nbsp;</div>
            <div class="panel_vistas_pdf2">&nbsp;</div>
            <div class="panel_vistas_pdf3">&nbsp;</div>
        </div>
        <br>
        <hr style="margin: 0px">
        <div id="line_pdf_microscopia"></div>
    </div>
    <div id="pabel_principal" class="tab-pane margin_panel_tabs active">
        <div class="panel_info_geneal">
            <div class="panel_info_geneal1_left">
                
                <div class="card" id="card_registro_medico" style="margin-bottom:5px;padding:8px;">
                    
                    <div class="panel_header_cancer" data-ind_caner="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_NOTIF_CANCER"];?>">
                        <div class="panel_header_cancer1">
                            <h6 class="title">
                                <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                                <b style="color:#888888;">REGISTRO DE C&Aacute;NCER</b>
                            </h6>
                        </div>
                        <div class="panel_header_cancer2"  style="text-align:end;">
                            <label for="ind_gestion_panel_cancer" class="pointer" style="color:#888888;margin-bottom:0px;">HABILITADO&nbsp;</label>
                        </div>
                        <div class="panel_header_cancer2"  style="text-align:end;">
                            <input <?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_NOTIF_CANCER"]==1?'checked':'';?> type="checkbox" style="display:initial;margin-top:0px;" class="form-check-input pointer"  id="ind_gestion_panel_cancer" onclick="js_gestion_cancer(<?php echo $ID_SOLICITUD;?>)" value="1">
                        </div>
                    </div>
                    
                    <form id="form_cancer_input" name="form_cancer_input">
                        <table class="table table-striped table_cancer table-sm" id="table_cancer" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <td style="width: 50%">
                                        <small><b style="color:#888888;">ENTREGA BIOPSIAS CRITICAS</b></small>
                                        <br>
                                        <select class="form-control input-sm group_input_cancer" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_entrega_cancercritico" id="num_entrega_cancercritico" data-width="98%" tabindex="-98">
                                            <option value=""> -- </option>
                                            <?php   for($i = 1; $i < 21; ++$i) { 
                                                $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_DIAS_ENTCANCER"]?'selected ':'';
                                                echo '<option value="'.$i.'" '.$selected.'>'.$i.' D&Iacute;AS</option>';  
                                            }  ?>
                                        </select>
                                    </td>
                                    <td style="width: 50%">
                                        <?php 
                                            if($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_ASIGNACION96HRS"]!= ''){
                                                $arr_time=conversorSegundosHoras($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_ASIGNACION96HRS"]);
                                            }
                                        ?>
                                        <small><b style="color:#888888;">HORAS ASIGNADAS&nbsp;(HH:MM:SS)</b></small>
                                        <br>
                                        <div class="input-group">
                                            <select class="form-control input-sm group_input_cancer" style="width:57px;" name="seg_horas_cancer" id="seg_horas_cancer">
                                                <option value=""> -- </option>
                                                <?php for($aux1 = 0; $aux1 < 100; ++$aux1){ 
                                                    $selected   =   isset($arr_time)?$arr_time["horas"]==$aux1?'selected':'':'';
                                                    echo '<option value="'.(3600*$aux1).'" '.$selected.'>'.$aux1.'</option>';  
                                                } ?>
                                            </select>
                                            <select class="form-control input-sm group_input_cancer" style="width:57px;" name="seg_minutos_cancer" id="seg_minutos_cancer">
                                                <option value=""> -- </option>
                                                <?php for($aux2 = 0; $aux2 < 60; ++$aux2) { 
                                                    $selected   =   isset($arr_time)?$arr_time["minutos"]==$aux2?'selected':'':'';
                                                    echo '<option value="'.(60*$aux2).'" '.$selected.'>'.$aux2.'</option>';  
                                                } ?>
                                            </select>
                                            <select class="form-control input-sm group_input_cancer" style="width:57px;" name="seg_segundos_cancer" id="seg_segundos_cancer">
                                                <option value=""> -- </option>
                                                <?php   for($aux3 = 0; $aux3 < 60; ++$aux3) { 
                                                    $selected   =  isset($arr_time)?$arr_time["segundos"]==$aux3?'selected':'':'';
                                                    echo '<option value="'.$aux3.'" '.$selected.'>'.$aux3.'</option>';  
                                                } ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <small><b style="color:#888888;">INICIO BP DG CL&Iacute;NICO DE C&Aacute;NCER</b></small>
                                        <br>
                                        <div id="calendar_inicio_cancer" class="input-group row_calendar" style="width:140px;">
                                            <input id="date_inicio_cancer" name="date_inicio_cancer" type="text" class="form-control input-sm group_input_cancer" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_REALIZACION2"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_REALIZACION2"];?>">
                                            <span class="input-group-addon" style="cursor:pointer;padding:6px;margin-left:6px;">
                                                <span class="fa fa-calendar" aria-hidden="true"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <small><b style="color:#888888;">HORA BP DG CL&Iacute;NICO DE C&Aacute;NCER</b></small>
                                        <br>
                                        <input style="width: 90px;" type="time" class="form-control input-sm input_cancer" id="hrs_inicio_cancer" name="hrs_inicio_cancer" style="couse" maxlength="5" size="5" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_REALIZACION21"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_REALIZACION21"];?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <small><b style="color:#888888;">TERMINO BP CRITICAS</b></small>
                                        <br>
                                        <div id="calendar_termino_cancer" class="input-group row_calendar" style="width:140px;">
                                            <input id="date_termino_cancer" name="date_termino_cancer" type="text" class="form-control input-sm group_input_cancer" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_REALIZACION3"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_REALIZACION3"];?>">
                                            <span class="input-group-addon" style="cursor:pointer;padding:6px;margin-left:6px;">
                                                <span class="fa fa-calendar" aria-hidden="true"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <small><b style="color:#888888;">HORA TERMINO BP CRITICAS</b></small>
                                        <br>
                                        <input style="width: 90px;" type="time" class="form-control input-sm group_input_cancer" id="hrs_termino_cancer" name="hrs_termino_cancer" style="couse" maxlength="5" size="5"  value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_REALIZACION32"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_REALIZACION32"];?>">
                                    </td>
                                </tr>
                            </tbody>    
                        </table>
                    </form>
                </div>
                
                <div class="card" id="card_registro_medico3" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin-top: 4px;margin-bottom: 10px;">
                        <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">NOTIFICACI&Oacute;N DE C&Aacute;NCER</b>
                    </h6>
                    <table class="table table-striped table_cancer table-sm" id="table_informe_final" style="margin-bottom: 0px;">
                        <tbody>
                            <tr>
                                <td style="width: 50%">
                                    <small><b style="color:#888888;">INDICACI&Oacute;N DE CANCER</b></small>
                                </td>
                                <td style="width: 50%">
                                    <select class="selectpicker" data-title="Elige una opción" onchange="js_busqueda_num_cancer(this.value)"  name="ind_confirma_cancer" id="ind_confirma_cancer" data-width="98%" tabindex="-98" >
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </td>
                            </tr>
                            <tr style="display: none" id="tr_num_cancer">
                                <td style="width: 50%">
                                    <small><b style="color:#888888;">N&deg; NOTIFICACI&Oacute;N CANCER</b></small>
                                </td>
                                <td style="width: 50%">
                                    <input type="number" min="0" class="form-control input-sm" name="n_notificacion_cancer" id="n_notificacion_cancer" size="10" maxlength="10" style="width: 75px;" value="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <?php if ( $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] == 4 || $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] == 5 || $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] == 6 ){ ?>
                    <div class="card" id="card_registro_medico3" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">DIAGN&Oacute;STICO CITOL&Oacute;GICO</b>
                    </h6>
                    <textarea class="form-control input-sm" 
                        name        =   "txt_diagnostico_citologico" 
                        id          =   "txt_diagnostico_citologico" 
                        cols        =   "65" 
                        rows        =   "5" 
                        style       =   "width:100%;"
                        oninput     =   "js_auto_grow(this)"
                        maxlength   =   "4000"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_DIAG_CITOLOGICO"];?></textarea>
                    </div>
                    <div class="card" id="card_registro_medico3" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">DESCRIPCI&Oacute;N CITOL&Oacute;GICO</b>
                    </h6>
                    <textarea class="form-control input-sm" 
                        name        =   "txt_citologico" 
                        id          =   "txt_citologico" 
                        cols        =   "65" 
                        rows        =   "5" 
                        style       =   "width:100%;"
                        oninput     =   "js_auto_grow(this)"
                        maxlength   =   "4000"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_CITOLOGICO"];?></textarea>
                    </div>
                <?php } else {  ?>
                    <input type="hidden" id="txt_diagnostico_citologico" name="txt_diagnostico_citologico" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_DIAG_CITOLOGICO"];?>"/>
                    <input type="hidden" id="txt_citologico" name="txt_citologico" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_CITOLOGICO"];?>"/>
                <?php } ?>
                
            </div>
            <div class="panel_info_geneal2_right">
                
                <div class="card" id="card_registro_medico3" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 2px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">CONFIGURACI&Oacute;N INFORME FINAL</b>
                    </h6>
                    <table class="table table-striped table_cancer table-sm" id="table_informe_final" style="margin-bottom: 0px;">
                        <tbody>
                            <tr>
                                <td style="width: 50%">
                                    <small><b style="color:#888888;">TIPO CONFIGURACI&Oacute;N PDF</b></small>
                                </td>
                                <td style="width: 50%">
                                    <select class="selectpicker" data-size="2" name="ind_conf_informepdf" id="ind_conf_informepdf" data-width="98%" tabindex="-98">
                                        <option value="1">CONF. 1 HOJAS</option>
                                        <option value="0">CONF. 2 HOJAS</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] != 5){ ?>
                   <div class="card" id="card_registro_medico3" style="margin-bottom:5px;padding:8px;">
                        <h6 class="title" style="margin: 8px 0px 12px 0px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">DIAGN&Oacute;STICO HISTOL&Oacute;GICO</b>
                        </h6>
                        <textarea class="form-control input-sm" name="txt_diagnostico_ap" id="txt_diagnostico_ap" cols="65" rows="5" style="width:100%;" maxlength="4000" oninput="js_auto_grow(this)" ><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_DIADNOSTICO_AP"];?></textarea>
                        <hr style="margin: 0px">
                        <div class="panel_microscopia_voces"  style="display:none">
                            <div class="panel_microscopia_voces1">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-fill btn-primary btn-xs btn-success" data-sufijo="btn_microfono" onclick="empezar_a_escuchar()">
                                        <i class="fa fa-microphone" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="btn btn-fill btn-primary btn-xs btn-danger" data-sufijo="btn_microfono" onclick="terminar()">
                                        <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="btn btn-fill btn-primary btn-xs btn-warning" data-sufijo="btn_microfono" onclick="js_procesar()">
                                        <i class="fa fa-file-audio-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="panel_microscopia_voces2">&nbsp;</div>
                            <div class="panel_microscopia_voces3">&nbsp;</div>
                        </div>
                        <div class="panel_star_apivoz">
                            <div class="panel_star_apivoz2">
                                <input type="hidden" id="textActive2" name="textActive2" value="txt_diagnostico_ap">
                                <div id="areaResult" class="areaResult"></div>
                            </div>
                            <div class="panel_star_apivoz3" id="mic_btn_microfono"></div>
                            <div class="panel_star_apivoz1" id="procesar" class="areaResult"></div>
                        </div>
                    </div>
                <?php } else {  ?>
                    <input type="hidden" id="txt_diagnostico_ap" name="txt_diagnostico_ap" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_DIADNOSTICO_AP"];?>"/>
                <?php } ?>
                
                <?php if (  
                            $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA']  ==  4 || 
                            $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA']  ==  5 || 
                            $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA']  ==  6 
                        ){ ?>
                    <div class="card" id="card_registro_medico3" style="margin-bottom:5px;padding:8px;">
                        <h6 class="title" style="margin: 8px 0px 12px 0px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">DESCRIPCI&Oacute;N MACROSCOPICA</b>
                        </h6>
                        <textarea class="form-control input-sm" 
                            name        =   "txt_macroscopia" 
                            id          =   "txt_macroscopia"
                            oninput     =   "js_auto_grow(this)"
                            cols        =   "65" 
                            rows        =   "5" 
                            style       =   "width:100%;" 
                            maxlength   =   "4000"><?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_DESC_MACROSCOPICA"];?></textarea>
                    </div>
                <?php } else {  ?>
                    <input type="hidden" id="txt_macroscopia" name="txt_macroscopia" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_DESC_MACROSCOPICA"];?>"/>
                <?php } ?>
                
            </div>
        </div>
        <hr style="margin: 0px 0px 5px 0px;display: none">
        <div class="panel_microscopia_footer" style="display:none">
            <div class="panel_microscopia_footer1">&nbsp;</div>
            <div class="panel_microscopia_footer2">&nbsp;</div>
            <div class="panel_microscopia_footer3" style="text-align:end;"></div>
        </div>
    </div>
    <!-- FINAL DE PANEL -->
    <div id="historial_clinico" class="tab-pane margin_panel_tabs"> 
        <div id="HISTO_CLINICO_ELECTRONICO"></div>
    </div>
    <div id="registro_tecnologo" class="tab-pane margin_panel_tabs">
        <div class="panel_info_geneal">
            <div class="panel_info_geneal_tec1">
                <div class="card" id="card_registro_medico4" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">INFORMACI&Oacute;N COMPLEMENTARIA</b>
                    </h6>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td style="width: 50%">
                                    <small><b style="color:#888888;">FECHA DE MACRO</b></small>
                                    <br>
                                    <div id="calendar_fecha_macro" class="input-group row_calendar" style="width:140px;">
                                        <input id="date_fecha_macro" name="date_fecha_macro" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_FECHA_MACRO"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_FECHA_MACRO"];?>">
                                        <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                                    </div>
                                </td>
                                <td style="width: 50%">
                                    <small><b style="color:#888888;">FECHA DE CORTE</b></small>
                                    <br>
                                    <div id="calendar_fecha_corte" class="input-group row_calendar" style="width:140px;">
                                        <input id="date_fecha_corte" name="date_fecha_corte" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_FECHA_CORTE"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_FECHA_CORTE"];?>">
                                        <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small><b style="color:#888888;">COLOR DE TACO</b></small><br>
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="ind_color_taco" id="ind_color_taco" data-width="98%" tabindex="-98">
                                        <option value=""> -- </option>
                                        <option value="1" data-icon="fa-heart" data-content='<i class="fa fa-circle" style="color:#FFA534" aria-hidden="true"></i>&nbsp;AMARILLO'>AMARILLO</option>
                                        <option value="2" data-icon="fa-heart" data-content='<i class="fa fa-circle" style="color:#0000ff" aria-hidden="true"></i>&nbsp;AZUL'>AZUL</option>
                                        <option value="3" data-icon="fa-heart" data-content='<i class="fa fa-circle" style="color:#FFFFFF;" aria-hidden="true"></i>&nbsp;BLANCO'>BLANCO</option>
                                        <option value="4" data-icon="fa-heart" data-content='<i class="fa fa-circle" style="color:#C8A2C8" aria-hidden="true"></i>&nbsp;LILA'>LILA</option>
                                    </select> 
                                </td>
                                <td>
                                    <small><b style="color:#888888;">ESTADIO OLGA</b></small><br>
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="ind_estado_olga" id="ind_estado_olga" data-width="98%" tabindex="-98">
                                        <option value=""> -- </option>
                                        <option value="1" data-icon="fa fa-check">BUENO</option>
                                        <option value="2" data-icon="fa fa-times">MALO</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small><b style="color:#888888;">INTERCONSULTA</b></small>
                                    <br>
                                    <div id="calendar_interconsulta_ap" class="input-group row_calendar" style="width:140px;">
                                        <input id="date_interconsulta_ap" name="date_interconsulta_ap" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_INTERCONSULTA"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_INTERCONSULTA"];?>">
                                        <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                                    </div>
                                </td>
                                <td>
                                    <small><b style="color:#888888;">COPIA INTERC</b></small>
                                    <br>
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_copia_inerconsulta" id="num_copia_inerconsulta" data-width="98%" tabindex="-98">
                                        <option value=""> -- </option>
                                        <?php   for($i = 1; $i < 21; ++$i) { 
                                            $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_CP_INTERCONSULTA"]?'selected ':'';
                                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                        }  ?>
                                    </select>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <small><b style="color:#888888;">NUMERO DE FRAGMENTOS</b></small>
                                    <br>
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_fragmentos" id="num_fragmentos" data-width="98%" tabindex="-98">
                                        <option value=""> -- </option>
                                        <?php for($i = 1; $i < 21; ++$i) { 
                                            $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_FRAGMENTOS"]?'selected ':'';
                                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                        }  ?>
                                    </select>
                                </td>
                                <td>
                                    <small><b style="color:#888888;">N&deg; TACOS CORTADOS</b></small>
                                    <br>
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_tacos_cortados" id="num_tacos_cortados" data-width="98%" tabindex="-98">
                                        <option value=""> -- </option>
                                        <?php for($i = 1; $i < 51; ++$i) { 
                                            $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_TACOS_CORTADOS"]?'selected ':'';
                                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                        }  ?>
                                    </select>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                    <small><b style="color:#888888;">N&deg; EXTENDIDOS</b></small>
                                    <br>
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_extendidos" id="num_extendidos" data-width="98%" tabindex="-98">
                                        <option value=""> -- </option>
                                        <?php for($i = 1; $i < 51; ++$i) { 
                                            $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_EXTENDIDOS"]?'selected ':'';
                                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                        }  ?>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel_info_geneal_tec2">
                INFORMACI&Oacute;N REGISTRADA POR EL TECN&Oacute;LOGO MEDICO
                <!--
                <div class="card" id="card_registro_medico3" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">INFORMACI&Oacute;N ADICIONAL</b>
                    </h6>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td style="width: 50%">
                                    <small><b style="color:#888888;">AZUL ALCIAN SERIADA</b></small>
                                    <br>
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_azul_alcian_seriada" id="num_azul_alcian_seriada" data-width="98%" tabindex="-98">
                                        <option value=""> -- </option>
                                        <?php for($i = 1; $i < 5; ++$i) { 
                                            $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_AZUK_ALCIAN_S"]?'selected':'';
                                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                        }  ?>
                                    </select>
                                </td>
                                <td style="width: 50%">
                                    <small><b style="color:#888888;">PAS SERIADA</b></small>
                                    <br>
                                    <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_pas_seriada" id="num_pas_seriada" data-width="98%" tabindex="-98">
                                        <option value=""> -- </option>
                                        <?php for($i = 1; $i < 5; ++$i) { 
                                            $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_PAS_SERIADA"]?'selected':'';
                                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                        }  ?>
                                    </select>
                                </td>
                                <tr>
                                    <td>
                                        <small><b style="color:#888888;">DIFF 3 SERIADA</b></small>
                                        <br>
                                        <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_diff_seriada" id="num_diff_seriada" data-width="98%" tabindex="-98">
                                            <option value=""> -- </option>
                                            <?php for($i = 1; $i < 5; ++$i) { 
                                                $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_DIFF_SERIADA"]?'selected ':'';
                                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                            }  ?>
                                        </select>
                                    </td>
                                    <td>
                                        <small><b style="color:#888888;">H/E SERIADA</b></small>
                                        <br>
                                        <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_he_seriada" id="num_he_seriada" data-width="98%" tabindex="-98">
                                            <option value=""> -- </option>
                                            <?php for($i = 1; $i < 5; ++$i) { 
                                                $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_HE_SERIADA"]?'selected ':'';
                                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                            }  ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <small><b style="color:#888888;">TOTAL L&Aacute;MINAS SERIADAS</b></small>
                                        <br>
                                        <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_all_laminas_seriadas" id="num_all_laminas_seriadas" data-width="98%" tabindex="-98">
                                            <option value=""> -- </option>
                                            <?php for($i = 1; $i < 5; ++$i) { 
                                                $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_LAMINAS_SERIADAS"]?'selected ':'';
                                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                            }  ?>
                                        </select>
                                    </td>
                                    <td>
                                        <small><b style="color:#888888;">H/E R&Aacute;PIDA</b></small>
                                        <br>
                                        <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_he_rapida" id="num_he_rapida" data-width="98%" tabindex="-98">
                                            <option value=""> -- </option>
                                            <?php for($i = 1; $i < 5; ++$i) { 
                                                $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_HE_RAPIDA"]?'selected ':'';
                                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                            }  ?>
                                        </select>
                                    </td>
                                </tr> 
                        </tbody>
                   </table>    
                </div>
                -->
            </div>
        </div>
    </div>
    <div id="registro_administrativo" class="tab-pane margin_panel_tabs"> 
        <?php echo $this->load->view("ssan_libro_etapaanalitica/html_panel_administrativo",[],true); ?>
    </div>
    <div id="add_archivos_ap" class="tab-pane margin_panel_tabs"> 
        <br>
        <?php echo $this->load->view("ssan_libro_etapaanalitica/html_views_imagenes_micro",[],true);  ?>
    </div>
    <div id="panel_prestaciones" class="tab-pane margin_panel_tabs">
        <div class="panel_main_prestaciones">
            <div class="panel_main_prestaciones7">
                <div class="card" id="card_fonasa" style="margin-bottom:5px;padding:8px;">
                    <div class="grid_btn_buspab">
                        <div class="grid_btn_buspab1">
                            <h6 class="title" style="margin: 8px 0px 12px 0px;">
                                <i style="color:#888888;" class="fa fa-search" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">B&Uacute;SQUEDA CODIFICACI&Oacute;N FONASA</b>
                            </h6>
                        </div>
                        <div class="grid_btn_buspab1">
                            <!--
                            <button type="button" class="btn btn-xs btn-info btn-fill" id="btn_guardado_previo" onclick="js_busqueda_pab(851)">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </button>
                            -->
                        </div>
                    </div>
                    <div style="overflow:hidden;">
                        <select data-width="100%" data-container="body" class="selectpicker" data-selected-text-format="count" data-live-search="true" multiple name="select_lista_cod_main" id="select_lista_cod_main" title="Seleccione codigo fonasa...">
                            <?php
                                if(count($data_bd[":P_LIS_COD_MAI"])>0){
                                    foreach($data_bd[":P_LIS_COD_MAI"] as $i => $row){ ?>
                                        <option value="<?php echo $row["COD_PRESTACION"];?>" <?php echo $row["SELECTED"];?> data-prestacion='<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>' data-subtext="<?php echo $row["COD_PRESTACION"];?> - <?php echo $row["FAMILIA_INTERVENCION"];?>"><?php echo $row["NOM_PRESTACION"];?></option>
                                    <?php    
                                    }
                                }
                            ?>
                        </select> 
                    </div>
                </div>
            </div>
            <div class="panel_main_prestaciones8">
                <div class="card" id="card_fonasa_resultado" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-th-list" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">LISTADO CODIFICACI&Oacute;N FONASA</b>
                    </h6>
                    <div class="card-body" style="padding:1px;">
                        <ul class="list-group" id="ul_sin_resultados_codigo_fonasa" style="margin-bottom:0px;">
                            <li class="list-group-item lista_sin_cod_fonasa" style="padding: 0px;">
                                <div class="grid_sin_informacion">
                                    <div class="grid_sin_informacion1"></div>
                                    <div class="grid_sin_informacion2"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b>SIN C&Oacute;DIGOS DE CODIFICACI&Oacute;N FONASA CARGADOS</b></div>
                                    <div class="grid_sin_informacion3"></div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group" id="ul_codificacion_mai" style="margin-bottom:0px;"></ul>
                    </div>
                </div>
            </div>
            
            <div class="panel_main_prestaciones1">
                <div class="card" id="card_prestaciones" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-search" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">B&Uacute;SQUEDA DE PRESTACI&Oacute;NES</b>
                    </h6>
                    <div>
                        <select data-width="100%" data-container="body"  data-dropup-auto="false" class="selectpicker" data-selected-text-format="count" data-live-search="true" multiple name="select_lista_prestaciones" id="select_lista_prestaciones" title="Seleccione Prestaciones...">
                            <?php
                                if(count($data_bd[":P_LISTA_PRESTACIONES"])>0){
                                    foreach($data_bd[":P_LISTA_PRESTACIONES"] as $i => $row){ ?>
                                        <option value="<?php echo $row["COD_PRESTA"];?>" <?php echo $row["SELECTED"];?> data-prestacion='<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>' data-subtext="<?php echo $row["NOM_CORTOS"];?>"><?php echo $row["NOM_LARGOS"];?></option>
                                    <?php    
                                    }
                                }
                            ?>
                        </select> 
                    </div>
                </div>
            </div>
            
            <div class="panel_main_prestaciones2">
                <div class="card" id="card_prestaciones" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-th-list" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">LISTADO DE PRESTACI&Oacute;NES</b>
                    </h6>
                    <div class="card-body" style="padding: 1px;">
                        <ul class="list-group" id="ul_sin_resultados" style="margin-bottom:0px;">
                            <li class="list-group-item lista_sinprestaciones" style="padding:0px;">
                                <div class="grid_sin_informacion">
                                    <div class="grid_sin_informacion1"></div>
                                    <div class="grid_sin_informacion2"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b>SIN PRESTACI&Oacute;NES CARGADAS</b></div>
                                    <div class="grid_sin_informacion3"></div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group" id="ul_perstaciones" style="margin-bottom:0px;"></ul>
                    </div>
                </div>
            </div>
            
            <div class="panel_main_prestaciones3">
                <div class="card" id="card_prestaciones" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-search" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">B&Uacute;SQUEDA TIPO DE MUESTRA</b>
                    </h6>
                    <div style="overflow:hidden;">
                        <select data-width="100%" data-container="body" class="selectpicker" data-selected-text-format="count" data-live-search="true" multiple name="select_lista_organos" id="select_lista_organos" title="Seleccione tipo de muestra...">
                            <?php
                                if(count($data_bd[":P_LIS_CODORGANO"])>0){
                                    foreach($data_bd[":P_LIS_CODORGANO"] as $i => $row){ ?>
                                        <option value="<?php echo $row["ID_ORGANO_AP"];?>" <?php echo $row["SELECTED"];?> data-prestacion='<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>' data-subtext="<?php echo $row["COD_ORGANO"];?>"><?php echo $row["TXT_NOMBRE_ORGANO"];?></option>
                                    <?php    
                                    }
                                }
                            ?>
                        </select> 
                    </div>
                </div>
            </div>
            
            <div class="panel_main_prestaciones4">
                <div class="card" id="card_prestaciones" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-th-list" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">LISTADO C&Oacute;DIGOS TIPO DE MUESTRA</b>
                    </h6>
                    <div class="card-body" style="padding: 1px;">
                        <ul class="list-group" id="ul_sin_resultados_organos" style="margin-bottom:0px;">
                            <li class="list-group-item lista_sin_organos_cargados" style="padding:0px;">
                                <div class="grid_sin_informacion">
                                    <div class="grid_sin_informacion1"></div>
                                    <div class="grid_sin_informacion2"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b>SIN C&Oacute;DIGOS DE TIPO DE MUESTRA</b></div>
                                    <div class="grid_sin_informacion3"></div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group" id="ul_organos" style="margin-bottom:0px;"></ul>
                    </div>
                </div>
            </div>
            
            <div class="panel_main_prestaciones5">
                <div class="card" id="card_prestaciones" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-search" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">B&Uacute;SQUEDA PATOLOG&Iacute;AS</b>
                    </h6>
                    <div style="overflow:hidden;">
                        <select data-width="100%" data-container="body" class="selectpicker" data-selected-text-format="count" data-live-search="true" multiple name="select_lista_patologia" id="select_lista_patologia" title="Seleccione Patologia...">
                            <?php
                                if(count($data_bd[":P_LIS_CODPATOLOGIA"])>0){
                                    foreach($data_bd[":P_LIS_CODPATOLOGIA"] as $i => $row){ ?>
                                        <option value="<?php echo $row["ID_PATOLOGIA_AP"];?>" <?php echo $row["SELECTED"];?> data-prestacion='<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>' data-subtext="<?php echo $row["COD_PATOLOGIA"];?>"><?php echo $row["TXT_PATOLOGIA"];?></option>
                                    <?php    
                                    }
                                }
                            ?>
                        </select> 
                    </div>
                </div>
            </div>

            <div class="panel_main_prestaciones6">
                <div class="card" id="card_prestaciones" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-th-list" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">LISTADO PATOLOG&Iacute;AS</b>
                    </h6>
                    <div class="card-body" style="padding: 1px;">
                        <ul class="list-group" id="ul_sin_resultados_patologia" style="margin-bottom:0px;">
                            <li class="list-group-item lista_sin_patologicas" style="padding: 0px;">
                                <div class="grid_sin_informacion">
                                    <div class="grid_sin_informacion1"></div>
                                    <div class="grid_sin_informacion2"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b>SIN C&Oacute;DIGOS DE PATOLOG&Iacute;A CARGADOS</b></div>
                                    <div class="grid_sin_informacion3"></div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group" id="ul_patologias" style="margin-bottom:0px;"></ul>
                    </div>
                </div>
            </div>
            <!--
            <div class="panel_main_prestaciones9">
                <div class="card" id="card_fonasa" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-search" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">B&Uacute;SQUEDA CODIFICACI&Oacute;N FONASA (PROCEDIMIENTOS) </b>
                    </h6>
                    <div style="overflow:hidden;">
                        <select data-width="100%" data-container="body" class="selectpicker" data-selected-text-format="count" data-live-search="true" multiple name="select_lista_mai_procedimiento" id="select_lista_mai_procedimiento" title="Seleccione codigo fonasa...">
                            <?php
                                if(count($data_bd[":P_LIS_MAI_PROCEDIMIENTO"])>0){
                                    foreach($data_bd[":P_LIS_MAI_PROCEDIMIENTO"] as $i => $row){ ?>
                                        <option value="<?php echo $row["COD_PRESTA"];?>" <?php echo $row["SELECTED"];?> data-prestacion='<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>' data-subtext="<?php echo $row["NOM_CORTOS"];?> - <?php echo $row["COD_PRESTA"];?>"><?php echo $row["NOM_LARGOS"];?></option>
                                    <?php    
                                    }
                                }
                            ?>
                        </select> 
                    </div>
                </div>
            </div>
            <div class="panel_main_prestaciones10">
                <div class="card" id="card_fonasa_resultado" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-th-list" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">LISTADO CODIFICACI&Oacute;N FONASA (PROCEDIMIENTOS)</b>
                    </h6>
                    <div class="card-body">
                        <ul class="list-group" id="ul_sin_resultados_mai_procedimiento" style="margin-bottom:0px;">
                            <li class="list-group-item lista_sin_patologicas" style="padding: 0px;">
                                <div class="grid_sin_informacion">
                                    <div class="grid_sin_informacion1"></div>
                                    <div class="grid_sin_informacion2"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b>SIN C&Oacute;DIGOS DE CODIFICACI&Oacute;N FONASA CARGADOS</b></div>
                                    <div class="grid_sin_informacion3"></div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group" id="ul_codificacion_mai_procedimiento" style="margin-bottom:0px;"></ul>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
    <div id="panel_muestras" class="tab-pane margin_panel_tabs">
        <?php
        $conf_panel_muestras        =   0;
        $conf_panel_citologia       =   0;
        ?>
        <div class="panel_body_muestras">
            <div class="panel_body_muestras1 muestras_iquierda">
                <div class="card" id="card_muestra_anatomicas" style="margin-top:13px;margin-bottom:5px;padding:8px;">
                    
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-th-list" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">LISTADO MUESTRAS <?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]['IND_USOCASSETTE']==1?'(CASETE)':'';?></b>
                    </h6>

                    <?php if(count($data_bd[":P_ANATOMIA_PATOLOGICA_MUESTRAS"])>0){
                        $conf_panel_muestras        =   1;
                        if($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]['IND_USOCASSETTE'] == 1){?>
                            <?php 
                                $ARR_CASETE_ORD     =   [];
                                foreach($data_bd[":P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ 
                                    $ARR_CASETE_ORD[$row['NUM_CASSETTE']][]     =   $row; 
                                }   //ordenando x casete
                            ?>
                            <?php 
                                $arr_li_casete      =   [];
                                $arr_div_content    =   [];
                                $aux                =   0;
                                foreach ($ARR_CASETE_ORD as $_num => $row_all){
                                    $html_muestra_casete            =   '<ul class="list-group" id="ul_muestras_'.$_num.'" style="margin-bottom:0px;">';
                                    $active                         =   $aux == 0 ? 'active':'';
                                    foreach ($row_all as $x => $row_muestras){
                                        $numero                     =   $x + 1 ;
                                        $html_muestra_casete       .=   '
                                        <li style="padding: 0px" class="list-group-item lista_casete"> 
                                            <div class="grid_muestras_anatomia">
                                                <div class="grid_muestras_anatomia1"><b class="color_muestra">'.$numero.'</b></div>
                                                <div class="grid_muestras_anatomia2 panel-heading"><b class="color_muestra">'.$row_muestras['TXT_MUESTRA'].'</b></div>
                                                <div class="grid_muestras_anatomia3">
                                                    <div class="grid_sin_descripcion">
                                                        <div class="grid_sin_descripcion1"><b class="color_muestra">SIN DESCRIPCI&Oacute;N</b></div>
                                                        <div class="grid_sin_descripcion2">
                                                            <input 
                                                                type    =   "checkbox" 
                                                                class   =   "form-check-input" 
                                                                id      =   "ind_sin_descripcion_'.$row_muestras['ID_NMUESTRA'].'" 
                                                                onclick =   "con_descripciom_num(this.value)" 
                                                                value   =   "'.$row_muestras['ID_NMUESTRA'].'">
                                                        </div>
                                                    </div>
                                                    
                                                '; 
                                        $html_muestra_casete       .=   '
                                                </div>
                                                <div class="grid_muestras_anatomia4" style="text-align: end;">';
                                        $html_muestra_casete       .=   $row_muestras['ID_IMAGEN']==''?'':'<i class="fa fa-file-image-o color_muestra" aria-hidden="true"></i>';
                                        $html_muestra_casete       .=   '
                                                <b class="color_muestra">A'.$row_muestras['ID_NMUESTRA'].'</b>
                                                </div>
                                                <div class="grid_muestras_anatomia5" id="btn_'.$row_muestras['ID_NMUESTRA'].'" style="text-align: center;">
                                                    <button type="button" class="btn btn-info btn-xs btn-fill" data-toggle="collapse" data-parent="#accordion"  href="#nuestra_x_casete_'.$row_muestras['ID_NMUESTRA'].'" aria-expanded="true" aria-controls="nuestra_x_casete_'.$row_muestras['ID_NMUESTRA'].'" class="li_acordion_muestras_x_casete">
                                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="nuestra_x_casete_'.$row_muestras['ID_NMUESTRA'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne'.$row_muestras['ID_NMUESTRA'].'" style="margin: 0px 10px 25px 10px;">
                                                <div class="grid_body_heard_microcospica">
                                                    <div class="grid_body_heard_microcospica1">
                                                        <input type="radio" style="display: block" name="name_radio_'.$row_muestras['ID_NMUESTRA'].'" id="radio_micro_'.$row_muestras['ID_NMUESTRA'].'" class="style_panel_micro" value="1" checked />
                                                    </div>
                                                    <div class="grid_body_heard_microcospica2">
                                                        <label for="radio_micro_'.$row_muestras['ID_NMUESTRA'].'" class="class_label" style="color:#23CCEF;">MICROSC&Oacute;PICA</label>
                                                    </div>
                                                    <div class="grid_body_heard_microcospica3">';
                                                        if($row_muestras['IND_DESC_MACROSCOPICA']!=''){
                                                        $html_muestra_casete    .=  '
                                                            <input type="radio" style="display:block" name="name_radio_'.$row_muestras['ID_NMUESTRA'].'" id="radio_macro_'.$row_muestras['ID_NMUESTRA'].'"  class="style_panel_micro" value="2"  />
                                                        ';
                                                        } 
                                                        $html_muestra_casete    .=  '    
                                                    </div>
                                                    <div class="grid_body_heard_microcospica4">';
                                                        if($row_muestras['IND_DESC_MACROSCOPICA']!=''){
                                                        $html_muestra_casete    .=  '    
                                                        <label for="radio_macro_'.$row_muestras['ID_NMUESTRA'].'" class="class_label" style="color:#87CB16;">MACROSC&Oacute;PICA</label>';
                                                        } 
                                                        $html_muestra_casete    .=  '  
                                                    </div>
                                                    <div class="grid_body_heard_microcospica5">';
                                                        if($row_muestras['ID_IMAGEN']!=''){
                                                        $html_muestra_casete    .=  '    
                                                        <input type="radio" style="display:block" name="name_radio_'.$row_muestras['ID_NMUESTRA'].'" id="radio_img_'.$row_muestras['ID_NMUESTRA'].'"  class="style_panel_micro" value="3"  />
                                                        ';
                                                        }
                                                        $html_muestra_casete    .=  '        
                                                    </div>
                                                    <div class="grid_body_heard_microcospica6">';
                                                        if($row_muestras['ID_IMAGEN']!=''){
                                                        $html_muestra_casete    .=  '    
                                                        <label for="radio_img_'.$row_muestras['ID_NMUESTRA'].'" class="class_label" style="color:#555;">
                                                            <i class="fa fa-file-image-o color_muestra" aria-hidden="true" style="cursor:pointer;"></i>
                                                        </label>';
                                                        }
                                                        $html_muestra_casete    .=  '        
                                                    </div>
                                                </div>
                                                <div class="grid_informacion_microscopia class_descripcion_micro_'.$row_muestras['ID_NMUESTRA'].' ">
                                                    <div class="grid_informacion_microscopia1">
                                                        <textarea 
                                                            class               =   "form-control input-sm value_microscopia" 
                                                            name                =   "txt_descipcion_'.$row_muestras['ID_NMUESTRA'].'" 
                                                            id                  =   "txt_descipcion_'.$row_muestras['ID_NMUESTRA'].'" 
                                                            data-muestra        =   "'.$row_muestras['ID_NMUESTRA'].'" 
                                                            cols                =   "65" 
                                                            rows                =   "5" 
                                                            style               =   "width:100%;" 
                                                            maxlength           =   "4000" 
                                                            onkeyup             =   "">'.$row_muestras['TXT_DESC_MICROSCOPICA'].'</textarea>
                                                        <div class="grid_texto_main_macroscopia">
                                                            <div class="grid_texto_main_macroscopia1">&nbsp;</div>
                                                            <div class="grid_texto_main_macroscopia2"></div>
                                                            <div class="grid_texto_main_macroscopia3"></div>
                                                            <div class="grid_texto_main_macroscopia4">
                                                                <i class="fa fa-stop-circle-o parpadea icon_grabando_'.$row_muestras['ID_NMUESTRA'].'" style="color:#FB404B;display:none" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid_informacion_microscopia2" style="text-align:center;">
                                                        <div class="grid_div_microfono_plantillas">
                                                            <div class="grid_div_microfono_plantillas1">
                                                                <div class="btn-group-vertical">
                                                                    <button 
                                                                        type            =   "button" 
                                                                        class           =   "btn btn-success btn-xs btn-fill" 
                                                                        id              =   "microfono_'.$row_muestras['ID_NMUESTRA'].'" 
                                                                        data-id_area    =   "txt_descipcion_'.$row_muestras['ID_NMUESTRA'].'"
                                                                        data-ind_tipo   =   "muestra"
                                                                        data-icongrab   =   "icon_grabando_'.$row_muestras['ID_NMUESTRA'].'"
                                                                        onclick         =   "star_microfono_general(this.id)"
                                                                        >
                                                                        <i class="fa fa-microphone" aria-hidden="true"></i>
                                                                    </button>
                                                                    <button 
                                                                        type            =   "button" 
                                                                        class           =   "btn btn-danger btn-xs btn-fill" 
                                                                        id              =   "btn_termina_mic_'.$row_muestras['ID_NMUESTRA'].'" 
                                                                        onclick         =   "mic_terminar(this.id)"
                                                                        >
                                                                        <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="grid_div_microfono_plantillas2">
                                                                <button 
                                                                    type                =   "button" 
                                                                    class               =   "btn btn-warning btn-xs btn-fill" 
                                                                    id                  =   "btn_termina_mic_'.$row_muestras['ID_NMUESTRA'].'" 
                                                                    onclick             =   "js_star_plantillas(1,'.$row_muestras['ID_NMUESTRA'].')"
                                                                    >
                                                                    <i class="fa fa-comment" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="class_descripcion_macro_'.$row_muestras['ID_NMUESTRA'].'" style="display: none">
                                                    <div class="grid_informacion_microscopia">
                                                        <div class="grid_informacion_microscopia1">
                                                            <textarea 
                                                                class           =   "form-control input-sm" 
                                                                id              =   "txt_muestra_macroscopica_'.$row_muestras['ID_NMUESTRA'].'" 
                                                                cols            =   "65" 
                                                                rows            =   "5" 
                                                                style           =   "width:100%;" 
                                                                maxlength       =   "4000" 
                                                                >'.$row_muestras['TXT_DESC_MACROSCOPICA'].'</textarea>
                                                        </div>
                                                        <div class="grid_informacion_microscopia2">
                                                            <button 
                                                                type            =   "button" 
                                                                class           =   "btn btn-danger btn-xs btn-fill" 
                                                                id              =   "btn_edita_macroscopica'.$row_muestras['ID_NMUESTRA'].'" 
                                                                onclick         =   "edita_txt_macroscopica('.$row_muestras['ID_NMUESTRA'].')"
                                                                >
                                                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="grid_informacion_imagenes_vista class_descripcion_img_'.$row_muestras['ID_NMUESTRA'].'" style="display: none">
                                                    <img src="'.$row_muestras['IMG_DATA'].'" style="max-width:100%;width:auto;height:auto;" class="img-thumbnail" alt="">
                                                    <div class="grid_panel_download">
                                                        <div class="grid_panel_download1"></div>
                                                        <div class="grid_panel_download2" style="text-align: end;">
                                                            <a href="'.$row_muestras['IMG_DATA'].'" download="'.$row_muestras['NAME_IMG'].'"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        ';
                                    }
                                    $html_muestra_casete.='</ul>';
                                    array_push($arr_li_casete,"<li role='presentation' class='$active'><a href='#casete_$_num' data-toggle='tab'><i class='fa fa-file' aria-hidden='true'></i>&nbsp;CASETE $_num/".$row_muestras["ID_CASETE"]."</a></li>");
                                    array_push($arr_div_content,"<div id='casete_$_num' ' class='tab-pane margin_panel_tabs $active' style='margin-bottom:-13px;'>$html_muestra_casete</div>");
                                    $aux++;
                                }
                            ?>
                            <div class="lista_ordenada_casete">
                                <ul role="tablist" class="nav nav-tabs"><?php echo implode("",$arr_li_casete);?></ul>
                                <div class="tab-content"><?php echo implode("",$arr_div_content);?></div>
                            </div>
                    <?php   }   else    {   ?>
                    
                            <ul class="list-group" id="ul_muestras" style="margin-bottom:0px;">
                                <?php foreach($data_bd[":P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ ?>
                                    <li style="padding: 0px" class="list-group-item lista_anatomia grupo_<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" id="<?php echo "A".$row['ID_NMUESTRA'];?>" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>"    data-NUM_TABS="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                        <div class="grid_muestras_anatomia">
                                            <div class="grid_muestras_anatomia1"><b class="color_muestra"><?php echo $i+1;?></b></div>
                                            <div class="grid_muestras_anatomia2"><b class="color_muestra"><?php echo $row['TXT_MUESTRA']?></b></div>
                                            <div class="grid_muestras_anatomia3">
                                                <div class="grid_sin_descripcion">
                                                    <div class="grid_sin_descripcion1"><b class="color_muestra" style="font-size: 12px;">SIN DESCRIPCI&Oacute;N</b></div>
                                                    <div class="grid_sin_descripcion2">
                                                        <input 
                                                            type    =   "checkbox" 
                                                            class   =   "form-check-input" 
                                                            id      =   "ind_sin_descripcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                                            onclick =   "con_descripciom_num(this.value)" 
                                                            value   =   "<?php echo $row['ID_NMUESTRA'];?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid_muestras_anatomia4" style="text-align:end;">
                                                <?php   if($row['ID_IMAGEN']!=''){  ?> 
                                                    <i class="fa fa-file-image-o color_muestra" class="color_muestra" aria-hidden="true"></i>
                                                <?php   }   ?>
                                                <b class="color_muestra"><?php echo "A".$row['ID_NMUESTRA'];?></b>
                                            </div>
                                            <div class="grid_muestras_anatomia5" id="btn_<?php echo "A".$row['ID_NMUESTRA'];?>" style="text-align:center;">
                                                
                                            </div>
                                        </div>


                                        <div id="collapseOne<?php echo $row['ID_NMUESTRA'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $row['ID_NMUESTRA'];?>" style="margin: 0px 10px 25px 10px;">
                                            <div class="grid_body_heard_microcospica">
                                                <div class="grid_body_heard_microcospica1">
                                                    <input type="radio" style="display: block" name="name_radio_<?php echo $row['ID_NMUESTRA'];?>" id="radio_micro_<?php echo $row['ID_NMUESTRA'];?>" class="style_panel_micro" value="1" checked />
                                                </div>
                                                <div class="grid_body_heard_microcospica2">
                                                    <label for="radio_micro_<?php echo $row['ID_NMUESTRA'];?>" class="class_label" style="color:#23CCEF;">MICROSC&Oacute;PICA</label>
                                                </div>
                                                <div class="grid_body_heard_microcospica3">
                                                    <?php   if($row['IND_DESC_MACROSCOPICA']!=''){ ?> 
                                                    <input type="radio" style="display:block" name="name_radio_<?php echo $row['ID_NMUESTRA'];?>" id="radio_macro_<?php echo $row['ID_NMUESTRA'];?>"  class="style_panel_micro" value="2"  />
                                                    <?php   }   ?>
                                                </div>
                                                <div class="grid_body_heard_microcospica4">
                                                    <?php   if($row['IND_DESC_MACROSCOPICA']!=''){ ?> 
                                                    <label for="radio_macro_<?php echo $row['ID_NMUESTRA'];?>" class="class_label" style="color:#87CB16;">MACROSC&Oacute;PICA</label>
                                                    <?php   }   ?>
                                                </div>
                                                <div class="grid_body_heard_microcospica5">
                                                    <?php if($row['ID_IMAGEN']!=''){ ?> 
                                                    <input type="radio" style="display:block" name="name_radio_<?php echo $row['ID_NMUESTRA'];?>" id="radio_img_<?php echo $row['ID_NMUESTRA'];?>"  class="style_panel_micro" value="3"  />
                                                    <?php   }   ?>
                                                </div>
                                                <div class="grid_body_heard_microcospica6">
                                                    <?php if($row['ID_IMAGEN']!=''){ ?> 
                                                    <label for="radio_img_<?php echo $row['ID_NMUESTRA'];?>" class="class_label" style="color:#555;">
                                                        <i class="fa fa-file-image-o" aria-hidden="true" style="cursor:pointer;"></i>
                                                    </label>
                                                    <?php   }   ?>
                                                </div>
                                            </div>
                                            <div class="grid_informacion_microscopia class_descripcion_micro_<?php echo $row['ID_NMUESTRA'];?>">
                                                <div class="grid_informacion_microscopia1">
                                                    <textarea 
                                                        class               =   "form-control input-sm value_microscopia" 
                                                        name                =   "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                                        id                  =   "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                                        data-muestra        =   "<?php echo $row['ID_NMUESTRA'];?>" 
                                                        cols                =   "65" 
                                                        rows                =   "5" 
                                                        style               =   "width:100%;" 
                                                        maxlength           =   "4000" 
                                                        onkeyup             =   ""><?php echo $row['TXT_DESC_MICROSCOPICA'];?></textarea>
                                                    <div class="grid_texto_main_macroscopia">
                                                        <div class="grid_texto_main_macroscopia1">&nbsp;</div>
                                                        <div class="grid_texto_main_macroscopia2"></div>
                                                        <div class="grid_texto_main_macroscopia3"></div>
                                                        <div class="grid_texto_main_macroscopia4">
                                                            <i class="fa fa-stop-circle-o parpadea icon_grabando_<?php echo $row['ID_NMUESTRA'];?>" style="color:#FB404B;display:none" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="grid_informacion_microscopia2" style="text-align:center;">
                                                    <div class="grid_div_microfono_plantillas">
                                                        <div class="grid_div_microfono_plantillas1">
                                                            <div class="btn-group-vertical">
                                                                <button 
                                                                    type            =   "button" 
                                                                    class           =   "btn btn-success btn-xs btn-fill" 
                                                                    id              =   "microfono_<?php echo $row['ID_NMUESTRA'];?>" 
                                                                    data-id_area    =   "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>"
                                                                    data-ind_tipo   =   "muestra"
                                                                    data-icongrab   =   "icon_grabando_<?php echo $row['ID_NMUESTRA'];?>"
                                                                    onclick         =   "star_microfono_general(this.id)"
                                                                    >
                                                                    <i class="fa fa-microphone" aria-hidden="true"></i>
                                                                </button>
                                                                <button 
                                                                    type            =   "button" 
                                                                    class           =   "btn btn-danger btn-xs btn-fill" 
                                                                    id              =   "btn_termina_mic_<?php echo $row['ID_NMUESTRA'];?>" 
                                                                    onclick         =   "mic_terminar(this.id)"
                                                                    >
                                                                    <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="grid_div_microfono_plantillas2">
                                                            <button 
                                                                type            =   "button" 
                                                                class           =   "btn btn-warning btn-xs btn-fill" 
                                                                id              =   "btn_termina_plantilla_<?php echo $row['ID_NMUESTRA'];?>" 
                                                                onclick         =   "js_star_plantillas(1,<?php echo $row['ID_NMUESTRA'];?>)"
                                                                >
                                                                <i class="fa fa-comment" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="class_descripcion_macro_<?php echo $row['ID_NMUESTRA'];?>" style="display: none">
                                                <div class="grid_informacion_microscopia">
                                                    <div class="grid_informacion_microscopia1">
                                                        <textarea 
                                                            class               =   "form-control input-sm" 
                                                            id                  =   "txt_muestra_macroscopica_<?php echo $row['ID_NMUESTRA'];?>" 
                                                            cols                =   "65" 
                                                            rows                =   "5" 
                                                            style               =   "width:100%;" 
                                                            maxlength           =   "4000" 
                                                           ><?php echo $row['TXT_DESC_MACROSCOPICA'];?></textarea>
                                                    </div>
                                                    <div class="grid_informacion_microscopia2">
                                                        <button 
                                                            type            =   "button" 
                                                            class           =   "btn btn-danger btn-xs btn-fill" 
                                                            id              =   "btn_edita_macroscopica<?php echo $row['ID_NMUESTRA'];?>" 
                                                            onclick         =   "edita_txt_macroscopica(<?php echo $row['ID_NMUESTRA'];?>)"
                                                            >
                                                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="grid_informacion_imagenes_vista class_descripcion_img_<?php echo $row['ID_NMUESTRA'];?>" style="display: none">
                                                <img src="<?php echo $row['IMG_DATA'];?>" style="max-width:100%;width:auto;height:auto;"  class="img-thumbnail" alt="">
                                                <div class="grid_panel_download">
                                                    <div class="grid_panel_download1"></div>
                                                    <div class="grid_panel_download2" style="text-align: end;">
                                                        <a href="<?php echo $row['IMG_DATA'];?>" download="<?php echo $row['NAME_IMG'];?>"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    <?php } else { ?>
                        <b>SIN MUESTRAS CARGADAS</b>
                    <?php } ?>
                </div>
            </div>
            <div class="panel_body_muestras2">
                <div class="card" id="card_muestra_citologica" style="margin-bottom:5px;padding:8px;">
                    <h6 class="title" style="margin: 8px 0px 12px 0px;">
                        <i style="color:#888888;" class="fa fa-th-list" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">LISTADO MUESTRAS CITOLOG&Iacute;CA</b>
                    </h6>
                    <div style="text-align: center">
                        <?php if(count($data_bd[":P_AP_MUESTRAS_CITOLOGIA"])>0){  
                            $conf_panel_citologia       =   1;
                            ?>
                            <ul class="list-group" id="ul_muestras" style="margin-bottom:0px;">
                            <?php foreach($data_bd[":P_AP_MUESTRAS_CITOLOGIA"] as $i => $row){ ?>
                                <li style="padding: 0px" class="list-group-item lista_anatomia grupo_<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" id="<?php echo "A".$row['ID_NMUESTRA'];?>" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>"    data-NUM_TABS="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                    <div class="grid_muestras_anatomia">
                                        <div class="grid_muestras_anatomia1"><b class="color_muestra"><?php echo $i+1;?></b></div>
                                        <div class="grid_muestras_anatomia2 panel-heading"><b class="color_muestra"><?php echo $row['TXT_MUESTRA']?> | <?php echo $row['NUM_ML']?> mL</b></div>
                                        <div class="grid_muestras_anatomia3">
                                            <div class="grid_sin_descripcion">
                                                <div class="grid_sin_descripcion1"><b class="color_muestra" style="font-size:12px;">SIN DESCRIPCI&Oacute;N</b></div>
                                                <div class="grid_sin_descripcion2">
                                                    <input 
                                                        type    =   "checkbox" 
                                                        class   =   "form-check-input" 
                                                        id      =   "ind_sin_descripcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                                        onclick =   "con_descripciom_num(this.value)" 
                                                        value   =   "<?php echo $row['ID_NMUESTRA'];?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_muestras_anatomia4" style="text-align:end;"><b class="color_muestra"><?php echo "A".$row['ID_NMUESTRA'];?></b></div>
                                        <div class="grid_muestras_anatomia5" id="btn_<?php echo "A".$row['ID_NMUESTRA'];?>" style="text-align:center;"></div>
                                    </div>
                                    <div id="collapseOne<?php echo $row['ID_NMUESTRA'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $row['ID_NMUESTRA'];?>" style="margin: 0px 10px 25px 10px;text-align: initial;">
                                        <div class="grid_body_heard_microcospica">
                                            <div class="grid_body_heard_microcospica1">
                                                <input type="radio" style="display: block" name="name_radio_<?php echo $row['ID_NMUESTRA'];?>" id="radio_micro_<?php echo $row['ID_NMUESTRA'];?>" class="style_panel_micro" value="1" checked />
                                            </div>
                                            <div class="grid_body_heard_microcospica2">
                                                <label for="radio_micro_<?php echo $row['ID_NMUESTRA'];?>" class="class_label" style="color:#23CCEF;">MICROSC&Oacute;PICA</label>
                                            </div>
                                            <div class="grid_body_heard_microcospica3">
                                                <?php if($row['IND_DESC_MACROSCOPICA']!=''){ ?> 
                                                <input type="radio" style="display:block" name="name_radio_<?php echo $row['ID_NMUESTRA'];?>" id="radio_macro_<?php echo $row['ID_NMUESTRA'];?>"  class="style_panel_micro" value="2"  />
                                                <?php } ?>
                                            </div>
                                            <div class="grid_body_heard_microcospica4">
                                                <?php if($row['IND_DESC_MACROSCOPICA']!=''){ ?> 
                                                <label for="radio_macro_<?php echo $row['ID_NMUESTRA'];?>" class="class_label" style="color:#87CB16;">MACROSC&Oacute;PICA</label>
                                                <?php } ?>
                                            </div>
                                            <div class="grid_body_heard_microcospica5">
                                                <?php if($row['ID_IMAGEN']!=''){ ?> 
                                                <input type="radio" style="display:block" name="name_radio_<?php echo $row['ID_NMUESTRA'];?>" id="radio_img_<?php echo $row['ID_NMUESTRA'];?>"  class="style_panel_micro" value="3"  />
                                                <?php } ?>
                                            </div>
                                            <div class="grid_body_heard_microcospica6">
                                                <?php if($row['ID_IMAGEN']!=''){ ?> 
                                                <label for="radio_img_<?php echo $row['ID_NMUESTRA'];?>" class="class_label" style="color:#555;">
                                                    <i class="fa fa-file-image-o" aria-hidden="true" style="cursor:pointer;"></i>
                                                </label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="grid_informacion_microscopia class_descripcion_micro_<?php echo $row['ID_NMUESTRA'];?>">
                                            <div class="grid_informacion_microscopia1">
                                                <textarea 
                                                    class               =   "form-control input-sm value_microscopia" 
                                                    name                =   "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                                    id                  =   "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                                    data-muestra        =   "<?php echo $row['ID_NMUESTRA'];?>" 
                                                    cols                =   "65" 
                                                    rows                =   "5" 
                                                    style               =   "width:100%;" 
                                                    maxlength           =   "4000" 
                                                    onkeyup             =   ""><?php echo $row['TXT_DESC_MICROSCOPICA'];?></textarea>
                                                <div class="grid_texto_main_macroscopia">
                                                    <div class="grid_texto_main_macroscopia1">&nbsp;</div>
                                                    <div class="grid_texto_main_macroscopia2"></div>
                                                    <div class="grid_texto_main_macroscopia3"></div>
                                                    <div class="grid_texto_main_macroscopia4">
                                                        <i class="fa fa-stop-circle-o parpadea icon_grabando_<?php echo $row['ID_NMUESTRA'];?>" style="color:#FB404B;display:none" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid_informacion_microscopia2" style="text-align:center;">
                                                <div class="btn-group-vertical">
                                                    <button 
                                                        type            =   "button" 
                                                        class           =   "btn btn-success btn-xs btn-fill" 
                                                        id              =   "microfono_<?php echo $row['ID_NMUESTRA'];?>" 
                                                        data-id_area    =   "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>"
                                                        data-ind_tipo   =   "muestra"
                                                        data-icongrab   =   "icon_grabando_<?php echo $row['ID_NMUESTRA'];?>"
                                                        onclick         =   "star_microfono_general(this.id)"
                                                        >
                                                        <i class="fa fa-microphone" aria-hidden="true"></i>
                                                    </button>
                                                    <button 
                                                        type            =   "button" 
                                                        class           =   "btn btn-danger btn-xs btn-fill" 
                                                        id              =   "btn_termina_mic_<?php echo $row['ID_NMUESTRA'];?>" 
                                                        onclick         =   "mic_terminar(this.id)"
                                                        >
                                                        <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="class_descripcion_macro_<?php echo $row['ID_NMUESTRA'];?>" style="display: none">
                                            <div class="grid_informacion_microscopia">
                                                <div class="grid_informacion_microscopia1">
                                                    <textarea 
                                                        class               =   "form-control input-sm" 
                                                        id                  =   "txt_muestra_macroscopica_<?php echo $row['ID_NMUESTRA'];?>" 
                                                        cols                =   "65" 
                                                        rows                =   "5" 
                                                        style               =   "width:100%;" 
                                                        maxlength           =   "4000"
                                                        ><?php echo $row['TXT_DESC_MACROSCOPICA'];?></textarea>
                                                </div>
                                                <div class="grid_informacion_microscopia2">
                                                    <button 
                                                        type            =   "button" 
                                                        class           =   "btn btn-danger btn-xs btn-fill" 
                                                        id              =   "btn_edita_macroscopica<?php echo $row['ID_NMUESTRA'];?>" 
                                                        onclick         =   "edita_txt_macroscopica(<?php echo $row['ID_NMUESTRA'];?>)"
                                                        >
                                                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="grid_informacion_imagenes_vista class_descripcion_img_<?php echo $row['ID_NMUESTRA'];?>" style="display: none">
                                            <img src="<?php echo $row['IMG_DATA'];?>" style="max-width:100%;width:auto;height:auto;"  class="img-thumbnail" alt="">
                                            <div class="grid_panel_download">
                                                <div class="grid_panel_download1"></div>
                                                <div class="grid_panel_download2" style="text-align: end;">
                                                    <a href="<?php echo $row['IMG_DATA'];?>" download="<?php echo $row['NAME_IMG'];?>"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <b>SIN MUESTRAS CARGADAS</b>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>


<style>
    <?php if ($conf_panel_muestras == 1 && $conf_panel_citologia == 1 ){ ?>
        .panel_body_muestras                    {
            display                             :   grid;
            grid-template-columns               :   repeat(2,1fr);
            grid-column-gap                     :   5px;
            grid-row-gap                        :   5px;
            margin-top                          :   14px;
        }
    <?php } else { ?>
        <?php echo $conf_panel_muestras         == 0 ? '.panel_body_muestras1   {   display:none;  }':''; ?>
        <?php echo $conf_panel_citologia        == 0 ? '.panel_body_muestras2   {   display:none;  }':''; ?>
        .panel_body_muestras                    {
            display                             :   grid;
            grid-template-columns               :   repeat(1,1fr);
            grid-column-gap                     :   5px;
            grid-row-gap                        :   5px;
        }
    <?php } ?>
</style>


<script>
$(document).ready(function(){
    $('.style_panel_micro').click(function(){
        var panel_select                =   $(this).val();
        //console.log("panel_select     ->  ",panel_select);
        //console.log("name             ->  ",this.name);
        //console.log("id               ->  ",this.id);
        var arr_muestra                 =   this.id.split('_');
        //console.log("arr_muestra      ->  ",arr_muestra);
        if  (panel_select == 1){
            $(".class_descripcion_micro_"+arr_muestra[2]).show();
            $(".class_descripcion_macro_"+arr_muestra[2]).hide();
            $(".class_descripcion_img_"+arr_muestra[2]).hide();
        }

        if  (panel_select == 2){
            $(".class_descripcion_micro_"+arr_muestra[2]).hide();
            $(".class_descripcion_macro_"+arr_muestra[2]).show();
            $(".class_descripcion_img_"+arr_muestra[2]).hide();
        }

        if  (panel_select == 3){
            $(".class_descripcion_micro_"+arr_muestra[2]).hide();
            $(".class_descripcion_macro_"+arr_muestra[2]).hide();
            $(".class_descripcion_img_"+arr_muestra[2]).show();
        }
    });
    
    $(".row_calendar").datetimepicker({
        format              :   'DD-MM-YYYY',
        //minDate           :   new Date(new Date().setDate((new Date().getDate())-(30))),
        maxDate             :   new Date(),
        locale              :   'es-us',
        icons               :   {
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
        console.log("e  -> ",e);  
    });
    $("#ind_confirma_cancer").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_CONF_CANCER"];?>');
    $("#ind_conf_informepdf").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_CONF_PAG"];?>');
    <?php if ( $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_CONF_CANCER"] == 1) { ?>
        <?php if ($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_NOF_CANCER"] == '' ){ ?>
            js_busqueda_num_cancer('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_CONF_CANCER"];?>');
        <?php } else { ?>
            $("#tr_num_cancer").show();
            $("#n_notificacion_cancer").val(<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_NOF_CANCER"];?>);
        <?php } ?>
    <?php }?>
    <?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_NOTIF_CANCER"]=='SI'?'star_data_cancer();':'deshabilita_input_cancer();'?>
        
    $("#ind_mes_critico").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_MES_CRITICO"];?>');
    $("#ind_asignadas96horas").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_ASIGNACION96HRS"];?>');
    $("#ind_estado_olga").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_ESTADIO_OLGA_TEC"];?>');
    $("#ind_color_taco").val('<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_COLOR_TACO"];?>');
    
    $('#ind_confirma_cancer,#num_tacos_cortados,#num_extendidos,#num_pas_seriada,#num_he_rapida,#num_all_laminas_seriadas,#num_he_seriada,#num_diff_seriada,#pas_seriada,#num_azul_alcian_seriada,#num_fragmentos,#num_copia_inerconsulta,#ind_profesional_acargo,#ind_mes_critico,#ind_profesional_entrega_informe,#ind_profesional_entrega_informe,#ind_profesional_recibe_informe,#num_plazo_biopsias,#ind_asignadas96horas,#ind_estado_olga,#ind_color_taco').selectpicker({title:'--'});

    //------------
    //selectpicker
    $("#ind_conf_informepdf,#select_lista_organos,#select_lista_patologia,#select_lista_prestaciones,#select_lista_cod_main").selectpicker({title:'--'});
    
    //BUSQUEDA CODIFICACION FONASA
    $('#select_lista_cod_main').on('changed.bs.select',function(e,clickedIndex,isSelected,previousValue){  js_select_lista_cod_main();  });
    js_select_lista_cod_main();
    
    //BUSQUEDA DE PRESTACIONES
    $('#select_lista_prestaciones').on('changed.bs.select',function(e,clickedIndex,isSelected,previousValue){  js_select_presta();  });
    js_select_presta();
    
    //BUSQUEDA TIPO DE MUESTRA
    $('#select_lista_organos').on('changed.bs.select',function(e,clickedIndex,isSelected,previousValue){  js_select_organos();  });
    js_select_organos();
    
    //BUSQUEDA PATOLOGIAS
    $('#select_lista_patologia').on('changed.bs.select',function(e,clickedIndex,isSelected,previousValue){  js_select_patologias();  });
    js_select_patologias();
    
    //**************************************************************************
    $('.tabs_main_rce_patologo a[href="#pabel_principal"]').tab('show');
    //$('.tabs_main_rce_patologo a[href="#panel_prestaciones"]').tab('show');
    //$('.tabs_main_rce_patologo a[href="#panel_muestras"]').tab('show');
    //$('.tabs_main_rce_patologo a[href="#historial_clinico"]').tab('show');
    //js_views_historial_clinico_(<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_FICHAE"];?>);
    //$('.tabs_main_rce_patologo a[href="#add_archivos_ap"]').tab('show');
    js_sin_descripcion();
    //js_collapse_muestras();

    var myTab = document.getElementById('tabs_rce_analitica');
    var firstTab = new bootstrap.Tab(myTab.querySelector('.nav-link'));
    firstTab.show();

    setTimeout(function(){ 
        autosize($('#txt_diagnostico_ap'));
        autosize($('#txt_macroscopia'));
        autosize($('#txt_diagnostico_citologico'));
        autosize($('#txt_citologico'));
    },1000);
});
</script>