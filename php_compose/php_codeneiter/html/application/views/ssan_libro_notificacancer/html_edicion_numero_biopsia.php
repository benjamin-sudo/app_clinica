
<?php

$DATA = $cursor["P_ANATOMIA_PATOLOGICA_MAIN"][0];
?>



<input type="hidden" id="V_IND_TIPO_BIOPSIA" name="V_IND_TIPO_BIOPSIA"  value="<?php echo $DATA['IND_TIPO_BIOPSIA'];?>"/>
<div class="grid_edicion_biopsia">
    <div class="grid_edicion_biopsia1">
        <div class="card" id="card_informacio_paciente" style="margin-bottom: 5px">
            <div class="header" style="margin-bottom: 18px;">
                <h5 class="title"><i class="fa fa-user-o" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">PACIENTE</b></h5>
            </div>
            <div class="content card-body">
                <div class="table-responsive" style="margin-bottom:-5px;margin-top:-20px;">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <small><b style="color:#888888;">NOMBRE DEL PACIENTE</b></small><br>
                                    <small class="text-muted" id="nombreLabel"><?php echo $DATA["TXTNOMCIRUSMALL"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small><b style="color:#888888;">RUN</b></small><br>
                                    <small class="text-muted" id="rutLabel"><?php echo $DATA["RUTPACIENTE"];?></small>
                                </td>
                                <td>
                                    <small><b style="color:#888888;">SEXO</b></small><br>
                                    <small class="text-muted" id="sexoLabel"><?php echo $DATA["IND_TISEXO"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <small><b style="color:#888888;">F.&nbsp;NACIMIENTO</b></small><br>
                                    <small class="text-muted" id="edadLabel"><?php echo $DATA["NACIMIENTO"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <small><b style="color:#888888;">N°&nbsp;FICHA LOCAL</b></small><br>
                                    <small class="text-muted" id="FichaLabel"><?php echo $DATA["FICHAL"];?></small>
                                </td>
                            </tr>
                            <tr> 
                                <td colspan="2">
                                    <small><b style="color:#888888;">PREVISI&Oacute;N</b></small><br>
                                    <small class="text-muted" id="previsionLabel"><?php echo $DATA["TXT_PREVISION"];?></small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="grid_edicion_biopsia2">
        <div class="card" id="card_tiempos_anatomia_patologica" style="margin-bottom:5px">
            <div class="header" style="margin-bottom: 18px;">
                <h5 class="title"><i class="fa fa-id-card" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">SOLICITUD</b></h5>
            </div>
            <div class="content card-body">
                <table width="100%" class="table table-striped table-sm" style="margin-bottom:-5px;margin-top:-20px;"> 
                    <tbody id="tabla_biopsia">
                         <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">TIPO DE BIOPSIA</b></small><br>
                                <small class="text-muted" id="nombreLabel3">
                                    <?php echo $DATA["TIPO_DE_BIOPSIA"];?>                           
                                    <input type="hidden" id="IND_TIPO_BIOPSIA" name="IND_TIPO_BIOPSIA" value="<?php echo $DATA['IND_TIPO_BIOPSIA'];?>">
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">FECHA TOMA MUESTRA</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $DATA["FECHA_TOMA_MUESTRA"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">SOLICITANTE</b></small>
                                <br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $DATA["PROFESIONAL"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">SERVICIO</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $DATA["NOMBRE_SERVICIO"];?></small>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <small><b style="color:#888888;">ORIGEN SISTEMA</b></small><br>
                                <small class="text-muted" id="nombreLabel3"><?php echo $DATA["TXT_PROCEDENCIA"];?></<small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid_edicion_biopsia3">
        <div class="card" id="card_tiempos_anatomia_patologica" style="margin-bottom:5px">
            <div class="header">
                <h5 class="title">
                    <i class="fa fa-calendar" aria-hidden="true" style="color:#888888;"></i>&nbsp;
                    <b style="color:#888888;">EDICI&Oacute;N DE NUMERO BIOPSIA</b>
                </h5>
            </div>
            <div class="content card-body">
                <input type="hidden" id="ind_tipo_biopsia" name="ind_tipo_biopsia" value="<?php echo $DATA['IND_TIPO_BIOPSIA'];?>"/>
                <div class="grid_edicion_biopsia_opciones">
                    <div class="grid_edicion_biopsia_opciones1">
                        <fieldset class="fieldset_local">
                            <legend class="legend"><i class="fa fa-cog" aria-hidden="true"></i>
                                <?php   $txt_numero_editar = 0;
                                        if ($DATA['IND_TIPO_BIOPSIA'] == 2 || $DATA['IND_TIPO_BIOPSIA'] == 3 || $DATA['IND_TIPO_BIOPSIA'] == 4){ 
                                        $txt_numero_editar =  $DATA['NUM_INTERNO_AP'];  ?>
                                    &nbsp;N&deg; DE BIOPSIA
                                <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 5 ){
                                        $txt_numero_editar =  $DATA['NUM_CO_CITOLOGIA'];
                                    ?>
                                    &nbsp;N&deg; CITOLOG&Iacute;A
                                <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 6 ){
                                    $txt_numero_editar =  $DATA['NUM_CO_PAP'];
                                    ?>
                                    &nbsp;N&deg; PAP
                                <?php } ?>
                            </legend>
                            <div id="date_tabla2" class="input-group" style="width:200px;padding:8px;">
                                <span class="input-group-addon"><span class="fa fa-info-circle"></span></span>
                                <input type="number" class="form-control input-sm" id="num_interno" name="num_interno"  value="<?php echo $txt_numero_editar;?>"/>
                            </div>
                        </fieldset>
                        <input type="hidden" class="form-control input-sm" id="old_num_interno" name="old_num_interno"  value="<?php echo $txt_numero_editar;?>"/>
                    </div>
                    <div class="grid_edicion_biopsia_opciones2">
                        <button type="button" class="btn btn-info btn-fill" id="btn_last_number_diponible" style="width: 200px;margin-top: 10px;" onclick="busqueda_numero_disponible(<?php echo $DATA['IND_TIPO_BIOPSIA'];?>)">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;ULTIMO N&deg; 
                            <?php if ($DATA['IND_TIPO_BIOPSIA'] == 2 || $DATA['IND_TIPO_BIOPSIA'] == 3 || $DATA['IND_TIPO_BIOPSIA'] == 4){ ?>
                                &nbsp;BIOPSIA
                            <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 5 ){?>
                                &nbsp;CITOLOG&Iacute;A
                            <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 6 ){?>
                                &nbsp;PAP
                            <?php } ?>
                        </button>
                    </div>
                    <div class="grid_edicion_biopsia_opciones3">
                        <button type="button" class="btn btn-success btn-fill"  id="btn_cambia_numero_biopsia" style="margin-top: 10px;" onclick="js_cambio_numero_biopsia(<?php echo $DATA['ID_SOLICITUD'];?>)">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <?php if ($DATA['IND_TIPO_BIOPSIA'] == 4) { ?>
                    <br>
                    <div class="grid_edicion_biopsia_opciones">
                        <div class="grid_edicion_biopsia_opciones1">
                            <fieldset class="fieldset_local">
                                <legend class="legend"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;N&deg; CITOLOG&Iacute;A</legend>
                                <div id="date_tabla2" class="input-group" style="width:200px;padding:8px;">
                                    <span class="input-group-addon"><span class="fa fa-info-circle"></span></span>
                                    <input type="number" class="form-control input-sm" id="num_interno_cito" name="num_interno_cito"  value="<?php echo $DATA['NUM_CO_CITOLOGIA'];?>"/>
                                </div>
                            </fieldset>
                            <input type="hidden" class="form-control input-sm" id="old_num_interno_cito" name="old_num_interno_cito"  value="<?php echo $DATA['NUM_CO_CITOLOGIA'];?>"/>
                        </div>
                        <div class="grid_edicion_biopsia_opcione3">
                            <button type="button" class="btn btn-info btn-fill"  style="width: 200px;margin-top: 10px;" id="btn_last_number_diponible" onclick="busqueda_numero_disponible_citologia(<?php echo $DATA['IND_TIPO_BIOPSIA'];?>)">
                                <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;ULTIMO N&deg; CITOLOGICO 
                            </button>
                        </div>
                        <div class="grid_numero_interno4">
                            <button type="button" class="btn btn-success btn-fill" id="btn_cambia_numero_biopsia" style="margin-top: 10px;" onclick="js_cambio_numero_biopsia_citologico(<?php echo $DATA['ID_SOLICITUD'];?>)">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                <?php } ?>

                    <hr>

                    <h5 class="title" style="margin-bottom: 12px;"><i class="fa fa-calendar" aria-hidden="true" style="color:#888888;"></i>
                        &nbsp;<b style="color:#888888;">FECHA TOMA DE MUESTRA</b>
                    </h5>
                    <div class="grid_fecha_hora">
                        <div class="grid_fecha_hora1">
                            <div class="input-group class_fecha_emision" style="width: 125px;" id="fecha_emision">
                                <input type="text" class="form-control input-sm grupo_time_pab" id="fecha_solicitud" name="fecha_solicitud"  value="<?php echo explode(" ",$cursor["P_ANATOMIA_PATOLOGICA_MAIN"][0]['FECHA_TOMA_MUESTRA'])[0];?>">
                                <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                            </div>
                        </div>
                        <div class="grid_fecha_hora2">
                            <input type="time" class="form-control input-sm" style="width: 115px;" id="hora_solicitud" name="hora_solicitud" maxlength="5" size="5"  value="<?php echo explode(" ",$cursor["P_ANATOMIA_PATOLOGICA_MAIN"][0]['FECHA_TOMA_MUESTRA'])[1];?>">
                        </div>
                        <div class="grid_fecha_hora3">
                            <button type="button" class="btn btn-success btn-fill" id="btn_update_analitica" onclick="js_edicion_fecha_informe(<?php echo $DATA['ID_SOLICITUD'];?>)">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> CONFIRMA CAMBIO 
                            </button>
                        </div>
                    </div>
            </div>
        </div>
        <hr>
        <div style="text-align:center;">
            <button 
                type    =   "button" 
                class   =   "btn btn-danger btn-fill" 
                id      =   "btn_last_number_diponible" 
                onclick =   "elimina_biopsia_desde_anatomia(<?php echo $DATA['ID_SOLICITUD'];?>)">
                    <i class="fa fa-times" aria-hidden="true"></i>&nbsp;ARCHIVAR BIOPSIA POR ERROR 
            </button>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $(".class_fecha_emision").datetimepicker({
            format              :   'DD-MM-YYYY',
            //minDate           :   new Date(new Date().setDate((new Date().getDate())-(30))),
            //maxDate           :   new Date(),
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
            //console.log("-----------change------------>",e.currentTarget.id);
        }).on('dp.show',function(e) { 
            //console.log("-----------show-------------->",e.currentTarget.id);
        });
    });
</script>