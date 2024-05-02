<div class="panel_info_geneal">
    <div class="panel_info_geneal_administrativo2">
        <div class="card" id="card_registro_medico" style="margin-bottom:5px;padding:8px;">
            <h6 class="title" style="margin: 8px 0px 12px 0px;">
                <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">REGISTRO DE ANATOM&Iacute;A PATOL&Oacute;GICA</b>
            </h6>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td colspan="2">
                            <small><b style="color:#888888;">INFORME <?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TIPO_BIOPSIA"]==4?'BIOPSIA ':'';?>REALIZADO POR</b></small>
                            <br>
                            <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="ind_profesional_acargo" id="ind_profesional_acargo" data-width="98%" tabindex="-98">
                                <option value="">Seleccione .... </option>
                                <?php
                                    foreach ($data_bd[":P_LISTA_PATOLOGOS"] as $num => $row_prof){
                                        $selected   =   $row_prof["ID_PROFESIONAL"] == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_PROFESIONAL"]?'selected ':'';
                                        echo '<option value="'.$row_prof["ID_PROFESIONAL"].'" '.$selected.' data-subtext="'.$row_prof["RUT_PROFESIONAL"].'">'.$row_prof["TXT_PROFESIONAL"].'</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?php if ($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TIPO_BIOPSIA"] == 4){ ?>
                    <tr>
                        <td colspan="2">
                            <small><b style="color:#888888;">INFORME CITOL&Oacute;GICO REALIZADO POR</b></small>
                            <br>
                            <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="ind_profesional_acargo_citologico" id="ind_profesional_acargo_citologico" data-width="98%" tabindex="-98">
                                <option value="">Seleccione .... </option>
                                <?php
                                    foreach ($data_bd[":P_LISTA_PATOLOGOS"] as $num => $row_prof){
                                        $selected   =   $row_prof["ID_PROFESIONAL"] == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_PROFESIONAL_CITOLOGICO"]?'selected ':'';
                                        echo '<option value="'.$row_prof["ID_PROFESIONAL"].'" '.$selected.' data-subtext="'.$row_prof["RUT_PROFESIONAL"].'">'.$row_prof["TXT_PROFESIONAL"].'</option>';
                                    }
                                ?>
                            </select>
                            <script> $("#ind_profesional_acargo_citologico").selectpicker();</script>
                        </td>
                    </tr>
                    <?php } else {?>
                        <input type="hidden" id="ind_profesional_acargo_citologico" name="ind_profesional_acargo_citologico" value=""/>
                    <?php } ?>
                    <tr>
                        <td style="width:50%">
                            <small><b style="color:#888888;">N&deg; BENEFICIARIOS</b></small>
                            <br>
                            <input type="number" min="0" class="form-control input-sm" name="n_beneficiarios" id="n_beneficiarios" size="10" maxlength="10" style="width: 75px;" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_BENEFICIARIOS"];?>">
                        </td>
                        <td style="width:50%">
                            <small><b style="color:#888888;">MES CRITICO</b></small><br>
                            <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="ind_mes_critico" id="ind_mes_critico" data-width="98%" tabindex="-98">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <small><b style="color:#888888;">FECHA DE IMPRESI&Oacute;N INFORME</b></small>
                            <br>
                            <div id="calendar_impresion_informe" class="input-group row_calendar" style="width:140px;">
                                <input id="date_impresion_informe" name="date_impresion_informe" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_IMPRESION_INFORME"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_IMPRESION_INFORME"];?>">
                                <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                            </div>
                        </td>
                        <td>
                            <small><b style="color:#888888;">PLAZO BIOPSIAS (D&Iacute;AS)</b></small>
                            <br>
                            <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_plazo_biopsias" id="num_plazo_biopsias" data-width="98%" tabindex="-98">
                                <option value="6">6 D&Iacute;AS</option>
                                <option value="7">7 D&Iacute;AS</option>
                                <option value="8">8 D&Iacute;AS</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <small><b style="color:#888888;">FECHA ENTREGA INFORME</b></small>
                            <br>
                            <div id="calendar_fecha_entrga_informe" class="input-group row_calendar" style="width:140px;">
                                <input id="date_fecha_entrga_informe" name="date_fecha_entrga_informe" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_ENTREGA_INFORME"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_FECHA_ENTREGA_INFORME"];?>">
                                <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                            </div>
                        </td>
                        <td>
                            <small><b style="color:#888888;">HORA ENTREGA INFORME</b></small><br>
                            <input style="width: 90px;" type="time" class="form-control input-sm" id="hrs_entrega_informe" name="hrs_entrega_informe" style="couse" maxlength="5" size="5"  value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_HORA_ENTREGA_INFORME"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_HORA_ENTREGA_INFORME"];?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <small><b style="color:#888888;">NOMBRE FUNCIONARIO QUE ENTREGA INFORME</b></small>
                            <br>
                            <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="ind_profesional_entrega_informe" id="ind_profesional_entrega_informe" data-width="98%" tabindex="-98">
                                <option value="">Seleccione .... </option>
                                <?php
                                    foreach ($data_bd[":P_LISTA_PATOLOGOS"] as $num => $row_prof){
                                        $selected   =   $row_prof["ID_PROFESIONAL"] == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_PROFESIONAL_ENTREGA_INFO"]?'selected ':'';
                                        echo '<option value="'.$row_prof["ID_PROFESIONAL"].'" '.$selected.' data-subtext="'.$row_prof["RUT_PROFESIONAL"].'">'.$row_prof["TXT_PROFESIONAL"].'</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <small><b style="color:#888888;">NOMBRE FUNCIONARIO QUE RECIBE INFORME</b></small>
                            <br> 
                            <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="ind_profesional_recibe_informe" id="ind_profesional_recibe_informe" data-width="98%" tabindex="-98">
                                <option value="">Seleccione .... </option>
                                <?php
                                    foreach ($data_bd[":P_LISTA_PATOLOGOS"] as $num => $row_prof){
                                        $selected   =   $row_prof["ID_PROFESIONAL"] == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_PROFESIONAL_RECIBE_INFO"]?'selected ':'';
                                        echo '<option value="'.$row_prof["ID_PROFESIONAL"].'" '.$selected.' data-subtext="'.$row_prof["RUT_PROFESIONAL"].'">'.$row_prof["TXT_PROFESIONAL"].'</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="panel_info_geneal_administrativo1">
        <div class="card" id="card_registro_administrativo" style="margin-bottom:5px;padding:8px;">
            <h6 class="title" style="margin: 8px 0px 12px 0px;">
                <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<b style="color:#888888;">INFORMACI&Oacute;N COMPLEMENTARIA</b>
            </h6>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td style="width: 50%">
                            <small><b style="color:#888888;">N&deg; MEMO NOTIFICACI&Oacute;N</b></small><br>
                            <input type="number" min="0" class="form-control input-sm" name="n_notificacion" id="n_notificacion" size="10" maxlength="10" style="width: 75px;" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_NOTIFICACION"];?>">
                        </td>
                        <td style="width: 50%">
                            <small><b style="color:#888888;">REVISI&Oacute;N INFORME</b></small><br>
                            <div id="calendar_revision_informe" class="input-group row_calendar" style="width:140px;">
                                <input id="date_revision_informe" name="date_revision_informe" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_REVISION_INFORME"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_REVISION_INFORME"];?>">
                                <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <small><b style="color:#888888;">REVISI&Oacute;N BASE DATOS</b></small><br>
                            <div id="calendar_revision_bd" class="input-group row_calendar" style="width:140px;">
                                <input id="date_revision_bd" name="date_revision_bd" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_REVISION_BD"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_REVISION_BD"];?>" >
                                <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                            </div>
                        </td>
                        <td>
                            <small><b style="color:#888888;">CHEQUEO SISTEMA SOME</b></small><br>
                            <div id="calendar_chequeo_some" class="input-group row_calendar" style="width:140px;">
                                <input id="date_chequeo_some" name="date_chequeo_some" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_CHEQUEO_SOME"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_CHEQUEO_SOME"];?>" >
                                <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                            </div>
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <small><b style="color:#888888;">ARCHIVADA EN FICHA</b></small><br>
                            <div id="calendar_archivada_en_ficha" class="input-group row_calendar" style="width:140px;">
                                <input id="date_archivada_en_ficha" name="date_archivada_en_ficha" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_ARCHIVADA_EN_FICHA"]==''?'':$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_ARCHIVADA_EN_FICHA"];?>" >
                                <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                            </div>
                        </td>
                        <td>&nbsp;</td>
                     </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>