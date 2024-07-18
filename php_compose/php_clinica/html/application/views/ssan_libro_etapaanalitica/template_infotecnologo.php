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
    </div>
</div>