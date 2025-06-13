<style>
    ._CENTER_1 {
        display :   grid;
        justify-content :   center;
        align-items :   center;
    }
    .css_subgestion_eliminada {
        display :   grid;
        grid-template-columns :   1fr 1fr 10px;
        align-items :   center;
        margin-top :   8px;
        column-gap :   10px;
    }
    .css_informacion_log {
        display :   grid;
        grid-template-columns :   1fr 1fr 1fr;
        align-items :   center;
        margin-top :   8px;
        column-gap :   10px;
    }
    .CSS_GRID_HISTORIAL_ALL {
        display :   grid;
        grid-template-columns :   1fr 2fr;
        grid-row-gap :   5px;
        column-gap :   5px;
        padding :   5px;
    }
    .grid_popover_log {
        max-height : 150px !important;
        max-width : 600px !important;
        min-height : 150px;
        border : solid 1px black;
        margin : auto;
        display : flex;
        flex-wrap : wrap;
        justify-contend : center;
    }
    .popover {
        z-index : 3000;
    }
    .popover-content {
        height : 350px;
        overflow-y : auto;
    }
    .panel_a_log {
        display : grid;
        grid-template-columns : repeat(2,1fr);
        align-items : center;
        padding : 6px;
    }
    .grid_css_muestra_log {
        display : grid;
        grid-template-columns : 30px 1fr 2fr 30px;
    }
    .card_local {
        border-radius : 4px;
        box-shadow : 0 1px 2px rgb(0 0 0 / 5%), 0 0 0 1px rgb(63 63 68 / 10%);
        background-color : #FFFFFF;
    }

    .flex {
        display : flex;
        flex-wrap : wrap;
        align-items : stretch;
        align-content : center;
    }

    .grid_center {
        display : grid;
        justify-items : center;
        align-items : center;
    }
    
    .CSS_GRID_HEAD_MUESTRA {
        display : grid;
        grid-template-columns : repeat(4,1fr);
        grid-column-gap : 5px;
        grid-row-gap : 6px;
        justify-items : stretch;
        margin-bottom : 5px;
        grid-auto-rows : 90px;
        grid-template-areas : "mod1 mod1 mod1 mod2" ;
    }

    /* "mod3 mod4 mod4 mod4"*/ 
    .CSS_GRID_HEAD_MUESTRA1 { grid-area : mod1; }
    .CSS_GRID_HEAD_MUESTRA2 { grid-area : mod2; }
    .CSS_GRID_HEAD_MUESTRA3 { grid-area : mod3; }
    .CSS_GRID_HEAD_MUESTRA4 { grid-area : mod4; }
    .grid_item_center {
        display : grid;
        grid-template-columns : repeat(4,1fr);
        grid-gap : 10px;
        grid-auto-rows : 40px;
        grid-template-areas :   " . a a . "
                                " . a a . ";
    }
    
    .item_center {
        grid-area : a;
        align-self : center;
        justify-self : center;
    }

    .grid_table_anatomia {
        display : grid;
        grid-template-columns : repeat(4, 1fr);
        grid-gap : 1px;
        overflow : hidden;
        justify-items : stretch;
        grid-template-areas :   
            "nombre         nombre          nombre          rut"  
            "tipo_anatomia  tipo_anatomia   tipo_anatomia   tipo_anatomia"  
            "informacion1   informacion1    informacion1    informacion1";
    }
    
    .nombre { grid-area : nombre; }
    .rut { grid-area : rut; }
    .tipo_anatomia { grid-area : tipo_anatomia; }
    .informacion1 { grid-area : informacion1; }
    .grid_cell { position : relative; }
    
    .grid_cell::before {
        content : '';
        position : absolute;
        top : -1px;
        right : -1px;
        bottom : -1px;
        left : -1px;
        background-color : #ddd;
    }
    
    .cell_content {
        position : relative;
        background-color : #FFFFFF;
        padding : 6px;
    }
    
    .grid_views_casete {
        display :   grid;
        grid-template-columns : repeat(3,1fr);
        justify-items : start;
        align-items : center;
    }

    .grid_numero_interno {
        display :   grid;
        grid-template-columns : auto 30px 1fr 10px;
        align-items : center;
        justify-items : flex-start;
    }

    .grid_identificacion_paciente {
        display : grid;
        grid-template-columns : 4fr 4fr 1fr;
        gap : 8px;
        padding: 8px;
    }

    .grid_infopaciente {
        display : grid;
        grid-template-columns : 1fr 1fr;
        gap : 8px;
    }

    .grid_paciente_inicial {
        display : grid;
        grid-template-columns : 3fr 1fr;
        gap : 8px;
    }

    .grid_informacion_soli {
        display : grid;
        grid-template-columns : 1fr 1fr 1fr;
        gap : 8px;
    }

    .grid_btn_ultimonumero {
        display : grid;
        grid-template-columns : auto auto;
        gap : 8px;
    }

    .grid_new_numero_interno {
        display : grid;
        grid-template-columns : 0px auto 10px auto 1fr;
        align-items : center;
        justify-items : flex-start;
        padding: 8px;
        margin-top: -7px;
    }
</style>
    <div class="grid_identificacion_paciente">
        <div class="grid_identificacion_paciente1 card">
            <div class="card-header">
                <h6 style="margin-bottom: 0px;"><i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;Informaci&oacute;n Basica del paciente</h6>
            </div>
            <div class="card-body">
                <div class="grid_paciente_inicial">
                    <div class="grid_paciente_inicial1">
                        <h5 class="card-title">Nombre</h5><br>
                        <?php echo $DATA['NOMBRE_COMPLETO'];?> 
                    </div>
                    <div class="grid_paciente_inicial2">
                        <h5 class="card-title">Identificaci&oacute;n</h5><br>
                        <?php echo $DATA['COD_RUTPAC'];?>-<?php echo $DATA['COD_DIGVER'];?> 
                    </div>
                </div>
            </div>
        </div>
        <div class="grid_identificacion_paciente2 card">
            <div class="card-header"><h6 style="margin-bottom: 0px;"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Informaci&oacute;n de la solicitud</h6></div>
            <div class="card-body">
                <div class="grid_informacion_soli">
                    <div class="grid_informacion_soli1">
                        <h5 class="card-title">Fecha de solicitud</h5>  <br>
                        <?php echo $DATA['FECHA_SOLICITUD'];?> 
                    </div>
                    <div class="grid_informacion_soli2">
                        <h5 class="card-title">Fecha de traslado</h5><br>
                        <?php echo $DATA['FECHA_TRASLADO'];?> <?php echo $DATA['HORA_TRASLADO'];?> 
                    </div>
                    <div class="grid_informacion_soli3">
                        <h5 class="card-title">Tipo de biopsia</h5><br>
                        <?php echo $DATA['TIPO_DE_BIOPSIA'];?><?php echo $DATA['IND_USOCASSETTE']==1?'&nbsp;|&nbsp;USO CASETE':'';?>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid_identificacion_paciente3 card">
            <div class="card-header"><h6 style="margin-bottom: 0px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</h6></div>
            <div class="card-body" style="text-align: center;">
                <button type="button" data-toggle="false" class="btn btn-danger btn-fill" id="pdf_solicitud" onclick="GET_PDF_ANATOMIA_PANEL_LOCAL(<?php echo $DATA['ID_SOLICITUD'];?>)">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    <?php if($FASE == 2) { ?>
        <div class="grid_new_numero_interno">
            <div class="grid_new_numero_interno0">&nbsp;</div>
            <div class="grid_new_numero_interno1 card">
                <input type="hidden" id="V_IND_TIPO_BIOPSIA" name="V_IND_TIPO_BIOPSIA"  value="<?php echo $DATA['IND_TIPO_BIOPSIA'];?>"/>
                <div class="card-header">
                    <h6 style="margin-bottom: 0px;"><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Asignaci&oacute;n
                        <?php if ($DATA['IND_TIPO_BIOPSIA'] == 2 || $DATA['IND_TIPO_BIOPSIA'] == 3 || $DATA['IND_TIPO_BIOPSIA'] == 4){ ?>
                            &nbsp;N&deg; de biopsia
                        <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 5 ){?>
                            &nbsp;N&deg; citolog&iacute;a
                        <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 6 ){?>
                            &nbsp;N&deg; PAP
                        <?php } ?>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="grid_btn_ultimonumero">
                        <div class="grid_btn_ultimonumero1">
                            <div class="input-group mb-3" style="margin-bottom: 0rem !important;" >
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" id="num_interno" name="num_interno"  value="">
                            </div>
                        </div>
                        <div class="grid_btn_ultimonumero1">
                            <button type="button" class="btn btn-info btn-fill" id="btn_last_number_diponible" onclick="busqueda_numero_disponible(<?php echo $DATA['IND_TIPO_BIOPSIA'];?>)">
                                <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;Buscar ultimo N&deg;
                                <?php if ($DATA['IND_TIPO_BIOPSIA'] == 2 || $DATA['IND_TIPO_BIOPSIA'] == 3 || $DATA['IND_TIPO_BIOPSIA'] == 4){ ?>
                                    &nbsp;Biopsia
                                <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 5 ){?>
                                    &nbsp;citolog&iacute;co
                                <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 6 ){?>
                                    &nbsp;PAP
                                <?php } ?>
                            </button>
                            <input type="hidden" id="ind_tipo_biopsia" name="ind_tipo_biopsia" value="<?php echo $DATA['IND_TIPO_BIOPSIA'];?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid_new_numero_interno0">&nbsp;</div>
            <div class="grid_new_numero_interno2 card">
                <?php if ($DATA['IND_TIPO_BIOPSIA'] == 4) { ?>
                    <div class="card-header">
                        <h6 style="margin-bottom: 0px;"><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Asignaci&oacute;n&nbsp;N&deg;&nbsp;citolog&iacute;co</h6>
                    </div>
                    <div class="card-body">
                        <div class="grid_btn_ultimonumero">
                            <div class="grid_btn_ultimonumero1">
                                <div class="input-group mb-3" style="margin-bottom: 0rem !important;">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" id="num_interno_cito" name="num_interno_cito"  value="">
                                </div>
                            </div>
                            <div class="grid_btn_ultimonumero2">
                                <button type="button" class="btn btn-info btn-fill" id="btn_last_number_diponible" onclick="busqueda_numero_disponible_citologia(<?php echo $DATA['IND_TIPO_BIOPSIA'];?>)">
                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;Buscar ultimo N&deg; citolog&iacute;co 
                                </button>
                                <input type="hidden" id="ind_tipo_biopsia" name="ind_tipo_biopsia" value="<?php echo $DATA['IND_TIPO_BIOPSIA'];?>"/>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <input type="hidden" class="form-control input-sm" id="num_interno_cito" name="num_interno_cito"  value=""/>
                <?php } ?>
            </div>
            <div class="grid_new_numero_interno0">&nbsp;</div>
        </div>
    <?php } ?>

    <!-- GESTION DE MUESTRAS ANATOMIA -->
    <?php if(count($P_ANATOMIA_PATOLOGICA_MUESTRAS)>0){  ?>    
            <div class="card" style="margin-bottom: 5px;padding: 16px;">
                <div class="header">
                    <div class="GRID_HEARD_CHECK_MUESTRA">
                        <div class="GRID_HEARD_CHECK_MUESTRA1">
                            <h4 class="title" style="margin-bottom:30px;margin-left:10px;">
                                <?php
                                    if($DATA['IND_USOCASSETTE'] == 1){
                                        foreach($P_ANATOMIA_PATOLOGICA_MUESTRAS as $i => $row){ 
                                            $ARR_CASETE_ORD[$row['NUM_CASSETTE']][] = $row; 
                                        }
                                        echo "&nbsp;<b style='color:#888888;'> N&deg; CASETE:".count($ARR_CASETE_ORD).'&nbsp;|&nbsp;</b> ';
                                    }
                                ?>
                                <b style="color:#888888;">N&deg; MUESTAS:<?php echo count($P_ANATOMIA_PATOLOGICA_MUESTRAS);?></b>
                            </h4>
                        </div>
                        <div class="GRID_HEARD_CHECK_MUESTRA2">
                            <button type="button" data-toggle="false" class="btn btn-info btn-fill BTN_CHECKED_ALL_<?php echo $DATA["ID_SOLICITUD"];?>" id="BTN_CHECKED_ALL_<?php echo $DATA["ID_SOLICITUD"];?>" onclick="BTN_MARCA_ALL(<?php echo $DATA["ID_SOLICITUD"];?>)">
                                <i class="fa fa-check-square" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="GRID_HEARD_CHECK_MUESTRA3">
                            &nbsp;  
                        </div>
                    </div>
                </div>
                <div class="content" style="margin-top:-10px;">
                    <ul class="list-group" id="UL_RESULTADOS_<?php echo $DATA["ID_SOLICITUD"];?>" style="margin-bottom:0px;">
                    <?php    
                        $IND_USOCASSETTE = $DATA['IND_USOCASSETTE'];
                        if($IND_USOCASSETTE == 1){
                            #ordenando x casete
                            foreach($ARR_CASETE_ORD  as $y => $data_casete){
                                $li_muestras = '';
                                $grid_array = [];
                                $aux = 1;
                                $v_identificador_casete = $y . '_'. $DATA["ID_SOLICITUD"];
                                foreach ($data_casete as $z => $row) {  
                                    $li_muestras .=  $aux.".-".$row['TXT_MUESTRA']."";
                                    #array_push($grid_array,$aux.".-".$row['TXT_MUESTRA']);
                                    array_push($grid_array,'<div class="grid_cell2" style="color:#888888;"><b>'.$aux.'.-'.$row['TXT_MUESTRA'].'</b></div>');
                                    $aux++;
                                }
                                ?>
                                <li class="list-group-item sin_padding lista_anatomia grupo_<?php echo $DATA["ID_SOLICITUD"];?>" id="<?php echo "C".$v_identificador_casete;?>" data-id_muestra="<?php echo $v_identificador_casete;?>" data-CASETE="1" data-id_solicitud="<?php echo $DATA["ID_SOLICITUD"];?>" data-NUM_TABS="<?php echo $row['ID_CASETE'];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                    <div class="CSS_GRID_MUESTRA_CASETE">
                                        <div class="CSS_GRID_MUESTRA_CASETE_1">
                                            <b style="color:#888888;"><?php echo $y;?></b>
                                        </div>
                                        <div class="CSS_GRID_MUESTRA_CASETE_3">
                                            <a role="button" style="padding: 0px" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $v_identificador_casete;?>" aria-expanded="true" aria-controls="collapseOne<?php echo $v_identificador_casete;?>" class="li_acordion_mtuestras">
                                                <div class="grid_views_casete">
                                                    <?php echo implode("",$grid_array);?>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="CSS_GRID_MUESTRA_CASETE_4" style="text-align: end;">
                                            <b style="color:#888888;"><?php echo "N&deg;".$row['NUM_CASSETTE'];?>&nbsp;|&nbsp;<?php echo "C".$v_identificador_casete;?></b>
                                        </div>
                                        <div class="CSS_GRID_MUESTRA_CASETE_6 _CENTER_1">
                                            <input 
                                                type = "checkbox" 
                                                class = "form-check-input checkbox_<?php echo $row['ID_NMUESTRA'];?>" 
                                                id = "CHEK_<?php echo 'C'.$v_identificador_casete;?>" 
                                                style = "display:block;cursor:pointer;margin:0px" 
                                                onchange = "js_muestra_indivual('C<?php echo $v_identificador_casete;?>');"
                                                value = "<?php echo $v_identificador_casete;?>"
                                            />
                                        </div>
                                        <div  class="CSS_GRID_MUESTRA_CASETE_5" id="btn_<?php echo "C".$v_identificador_casete;?>">
                                            <span class="label label-danger">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="collapseOne<?php echo $v_identificador_casete;?>" class="panel-collapse collapse padding_collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $v_identificador_casete;?>">
                                        <div class="css_subgestion_eliminada">
                                            <div class="css_subgestion_eliminada1">
                                                <b style="color:#888888;">EVENTO ADVERSOS:</b><br>
                                                <select class="form-control input-sm" id="SEL_MOTIVO_<?php echo $v_identificador_casete;?>" name="SEL_MOTIVO_<?php echo $v_identificador_casete;?>">
                                                    <option value="">Seleccione...</option>
                                                    <option value="1">MUESTRA NO ENCONTRADA</option>
                                                    <option value="2">MUESTRA EN MAL ESTADO</option>
                                                    <option value="3">MUESTRA RECHAZADA</option>
                                                </select>
                                            </div>
                                            <div class="css_subgestion_eliminada2">
                                                <b style="color:#888888;">OBSERVACI&Oacute;N:</b><br>
                                                <input type="text" class="form-control input-sm" id="txt_observacion_<?php echo $v_identificador_casete;?>" name="txt_observacion_<?php echo $v_identificador_casete;?>" value="">
                                            </div>
                                            <div class="css_subgestion_eliminada3">&nbsp;</div>
                                        </div>
                                    </div>
                                </li>


                            <?php    
                            }
                        } else {
                            foreach($P_ANATOMIA_PATOLOGICA_MUESTRAS as $i => $row){  ?>    
                                <li class="list-group-item lista_anatomia grupo_<?php echo $DATA["ID_SOLICITUD"];?>" id="<?php echo "A".$row['ID_NMUESTRA'];?>" data-CASETE="0" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>" data-id_solicitud="<?php echo $DATA["ID_SOLICITUD"];?>" data-NUM_TABS="<?php echo $DATA["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                    <div class="CSS_GRID_MUESTRA">
                                        <div class="CSS_GRID_MUESTRA_1"><?php echo $i+1;?></div>
                                        <div class="CSS_GRID_MUESTRA_2 panel-heading"  role="tab" id="headingOne<?php echo $row['ID_NMUESTRA'];?>">
                                            <button class="accordion-button collapsed"   type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $row['ID_NMUESTRA'] ?>"   aria-expanded="false"  aria-controls="collapse<?= $row['ID_NMUESTRA'] ?>"   >
                                                <i><?= htmlspecialchars($row['TXT_MUESTRA'], ENT_QUOTES, 'UTF-8') ?></i>
                                            </button>
                                        </div>
                                        <div class="CSS_GRID_MUESTRA_4" style="text-align: end"><b><?php echo $row['TXT_ETIQUETA'];?>&nbsp;|&nbsp;<?php echo "A".$row['ID_NMUESTRA'];?></b></div>
                                        <div class="CSS_GRID_MUESTRA_6 _CENTER_1">
                                            <input 
                                                type="checkbox" 
                                                class="form-check-input checkbox_<?php echo $DATA["ID_SOLICITUD"];?>" 
                                                id="CHEK_<?php echo 'A'.$row['ID_NMUESTRA'];?>" 
                                                style="display:block;cursor:pointer;margin:0px" 
                                                onchange= "js_muestra_indivual('A<?php echo $row['ID_NMUESTRA'];?>');"
                                                value="<?php echo $row['ID_NMUESTRA'];?>">
                                        </div>
                                        <div class="CSS_GRID_MUESTRA_5" id="btn_<?php echo "A".$row['ID_NMUESTRA']; ?>">
                                            <span class="label label-danger">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="collapse<?= $row['ID_NMUESTRA'] ?>" class="accordion-collapse collapse"  aria-labelledby="heading<?= $row['ID_NMUESTRA'] ?>"  data-bs-parent="#UL_RESULTADOS_<?= $DATA["ID_SOLICITUD"]?>">
                                        <div class="css_subgestion_eliminada">
                                            <div class="css_subgestion_eliminada1">
                                                <b style="color:#888888;">EVENTO ADVERSOS:</b><br>
                                                <select class="form-control input-sm" id="SEL_MOTIVO_<?php echo $row['ID_NMUESTRA'];?>" name="SEL_MOTIVO_<?php echo $row['ID_NMUESTRA'];?>">
                                                    <option value="">Seleccione...</option>
                                                    <option value="1">MUESTRA NO ENCONTRADA</option>
                                                    <option value="2">MUESTRA EN MAL ESTADO</option>
                                                    <option value="3">MUESTRA RECHAZADA</option>
                                                </select>
                                            </div>
                                            <div class="css_subgestion_eliminada2">
                                                <b style="color:#888888;">OBSERVACI&Oacute;N:</b><br>
                                                <input type="text" class="form-control input-sm" id="txt_observacion_<?php echo $row['ID_NMUESTRA'];?>" name="txt_observacion_<?php echo $row['ID_NMUESTRA'];?>" value="">
                                            </div>
                                            <div class="css_subgestion_eliminada3">&nbsp;</div>
                                        </div>
                                    </div>
                                </li>
                            <?php
                            }
                        } ?>
                    </ul>
                </div>
            </div>
    <?php } ?>
    
    <?php if(count($P_AP_MUESTRAS_CITOLOGIA)>0){  ?>

            <div class="card" style="margin-bottom:5px;padding: 16px;">
                <div class="header">
                    <div class="GRID_HEARD_CHECK_MUESTRA">
                        <div class="GRID_HEARD_CHECK_MUESTRA1">
                            <h4 class="title" style="margin-bottom:15px">
                                <b style="color:#888888;">MUESTRA CITOL&Oacute;GICA&nbsp;:&nbsp;<?php echo count($P_AP_MUESTRAS_CITOLOGIA);?></b>
                            </h4>
                        </div>
                        <div class="GRID_HEARD_CHECK_MUESTRA2">
                            <button type="button" data-toggle="false" class="btn btn-info btn-fill BTN_CHECKED_ALL_<?php echo $DATA["ID_SOLICITUD"];?>" id="BTN_CHECKED_ALL_<?php echo $DATA["ID_SOLICITUD"];?>" onclick="BTN_MARCA_ALL(<?php echo $DATA["ID_SOLICITUD"];?>)">
                                <i class="fa fa-check-square" aria-hidden="true"></i> 
                            </button>
                        </div>
                        <div class="GRID_HEARD_CHECK_MUESTRA3">&nbsp;</div>
                    </div>
                </div>
                
                <div class="content">
                    <ul class="list-group " id="UL_RESULTADOS_<?php echo $DATA["ID_SOLICITUD"];?>" style="margin-bottom:0px;">
                    <?php foreach($P_AP_MUESTRAS_CITOLOGIA as $i => $row){ ?>
                        
                        
                        <li class="list-group-item sin_padding lista_anatomia grupo_<?php echo $DATA["ID_SOLICITUD"];?>" id="<?php echo "A".$row['ID_NMUESTRA'];?>" data-CASETE="0" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>" data-id_solicitud="<?php echo $DATA["ID_SOLICITUD"];?>" data-NUM_TABS="<?php echo $DATA["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                            <div class="CSS_GRID_MUESTRA2" >
                                <div class="CSS_GRID_MUESTRA_1"><?php echo $i+1; ?> </div>
                                <div class="CSS_GRID_MUESTRA_2">
                                    <a role="button" style="padding: 0px" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $row['ID_NMUESTRA'];?>" aria-expanded="true" aria-controls="collapseOne<?php echo $row['ID_NMUESTRA'];?>" class="li_acordion_mtuestras">
                                        <i><?php echo $row['TXT_MUESTRA'];?>&nbsp;|&nbsp;<?php echo $row['NUM_ML'];?>&nbsp;mL</i>
                                    </a>
                                </div>
                                <div class="CSS_GRID_MUESTRA_4" style="text-align: end;">
                                    <b><?php echo $row['TXT_ETIQUETA'];?></b>&nbsp;|&nbsp;<b><?php echo "A".$row['ID_NMUESTRA'];?></b>
                                </div>
                                <div class="CSS_GRID_MUESTRA_6 _CENTER_1">
                                    <input 
                                        type = "checkbox" 
                                        class = "form-check-input checkbox_<?php echo $DATA["ID_SOLICITUD"];?>" 
                                        id = "CHEK_<?php echo 'A'.$row['ID_NMUESTRA'];?>" 
                                        style = "display:block;cursor:pointer;margin:0px" 
                                        onchange = "js_muestra_indivual('A<?php echo $row['ID_NMUESTRA'];?>');"
                                        value = "<?php echo $row['ID_NMUESTRA'];?>">
                                </div>
                                <div class="CSS_GRID_MUESTRA_5" id="btn_<?php echo "A".$row['ID_NMUESTRA']; ?>">
                                    <span class="label label-danger">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div id="collapseOne<?php echo $row['ID_NMUESTRA'];?>" class="panel-collapse collapse padding_collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $row['ID_NMUESTRA'];?>">
                                <div class="css_subgestion_eliminada">
                                    <div class="css_subgestion_eliminada1">
                                        <b style="color:#888888;">EVENTO ADVERSOS:</b><br>
                                        <select class="form-control input-sm" id="SEL_MOTIVO_<?php echo $row['ID_NMUESTRA'];?>" name="SEL_MOTIVO_<?php echo $row['ID_NMUESTRA'];?>">
                                            <option value="">Seleccione...</option>
                                            <option value="1">MUESTRA NO ENCONTRADA</option>
                                            <option value="2">MUESTRA EN MAL ESTADO</option>
                                            <option value="3">MUESTRA RECHAZADA</option>
                                        </select>
                                    </div>
                                    <div class="css_subgestion_eliminada2">
                                        <b style="color:#888888;">OBSERVACI&Oacute;N:</b><br>
                                        <input type="text" class="form-control input-sm" id="txt_observacion_<?php echo $row['ID_NMUESTRA'];?>" name="txt_observacion_<?php echo $row['ID_NMUESTRA'];?>" value="">
                                    </div>
                                    <div class="css_subgestion_eliminada3">&nbsp;</div>
                                </div>
                            </div>
                        </li>



                    <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>   
    
    <hr style="margin: 4px 0px 0px 0px">

    <?php 
    switch($FASE){
        case 0:
            echo "SOLO VISUALIZACI&Oacute;N |".$FASE."|";
            break;
        case 1:
            $V_ID_SOLICITUD = $DATA["ID_SOLICITUD"];
            ?>
                <?php if($DATA["ID_HISTO_ESTADO"] == 1 || $DATA["ID_HISTO_ESTADO"] == 2){ ?>
                    <div class="_CENTER_1">
                        <div class="_CENTER_11">
                            <div class="btn-group btn_change">
                                <button class="btn btn-fill btn-warning" onclick="confirma_custodia(<?php echo $V_ID_SOLICITUD;?>)" style="width:auto; color: white;" id="<?php echo $DATA['ID_SOLICITUD'];?>">
                                    <i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;CUSTODIA SOLO DE N&deg;<?php echo $DATA["ID_SOLICITUD"];?>
                                </button>
                                <button class="btn btn-fill btn-info all_solicitudes_trasporte" onclick="confirma_trasporte(<?php echo $V_ID_SOLICITUD;?>)" style="width:auto;" id="<?php echo $DATA["ID_SOLICITUD"];?>">
                                    <i class="fa fa-truck" aria-hidden="true"></i>&nbsp;TRASPORTE SOLO DE N&deg;<?php echo $DATA["ID_SOLICITUD"];?>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php   } else {   ?>
                        <?php if ($DATA["ID_HISTO_ESTADO"] == 4) { ?>
                            <p><label for="size_2">YA RECEPCIONADA</label></p>
                        <?php } else { ?>
                            <p><label for="size_2">ESPERANDO A RECEPCI&Oacute;N DE SOLICITUD</label></p>
                        <?php  } ?>
                        <script> 
                            $("#BTN_INFO_HISPATOLOGICO_<?php echo $DATA["ID_SOLICITUD"];?>").hide();
                            $(".checkbox_<?php echo $DATA["ID_SOLICITUD"];?>").hide();
                        </script>
                <?php  }  ?>
            <?php
            break;
        case 2: ?>
                <style>
                    .css_option_recepcion {
                        display : grid;
                        grid-template-columns : 1fr auto auto 1fr auto auto 1fr;
                        align-items : center;
                        justify-content : center;
                        column-gap : 6px;
                        padding : 8px;
                    }
                    .css_panel_rechazo {
                        display : grid;
                        grid-template-columns : 1fr 2fr auto 1fr;
                        align-items : center;
                        justify-content : center;
                        column-gap : 6px;
                        padding : 8px;
                   }
                   .grid_new_fimarrecepcion {
                        display : grid;
                        grid-template-columns : 2fr auto 1fr auto 2fr;
                        gap : 8px;
                        align-items : center;
                        justify-content : center;
                        text-align: center;
                    }
                </style>
                
                <?php if ($DATA["ID_HISTO_ESTADO"] == 4 && $DATA['IND_ESTADO_MUESTRAS']==1) { ?>
                        <p><label for="size_2">SOLICITUD YA FUE RECEPCIONADA. | <?php echo $DATA["IND_ESTADO_MUESTRAS"];?></label></p>
                        <script>$(".checkbox_<?php echo $DATA["ID_SOLICITUD"];?>").hide();</script>
                <?php } else { ?>

                        <div class="css_option_recepcion">
                            <div class="css_option_recepcion0">&nbsp;</div>
                            <div class="css_option_recepcion1" style="text-align: end;">
                                <label for="ind_recepciona" style="cursor:pointer;color:#87CB16;font-size:30px;"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;RECEPCI&Oacute;N DE MUESTRAS</label>
                            </div>
                            <div class="css_option_recepcion2">
                                <input type="radio"  name="fav_language" id="ind_recepciona" style="display:block;cursor:pointer;margin: 0px 0px 5px 0px;" checked onclick="js_vista_opcion(this.id)" value="1" >
                            </div>
                            <div class="css_option_recepcion3">&nbsp;</div>
                            <div class="css_option_recepcion4" style="text-align: end;">
                                <label for="ind_rechazo" style="cursor:pointer;color:#d9534f;font-size:30px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;RECHAZO DE MUESTRAS</label>
                            </div>
                            <div class="css_option_recepcion5">
                                <input type="radio" name="fav_language" id="ind_rechazo" style="display:block;cursor:pointer;margin: 0px 0px 5px 0px;" onclick="js_vista_opcion(this.id)" value="1">
                            </div>
                            <div class="css_option_recepcion6">&nbsp;</div>
                        </div>

                        <div class="grid_new_fimarrecepcion css_grid_password_recepcion">
                            <div class="grid_new_fimarrecepcion1">&nbsp;</div>
                            <div class="card grid_new_fimarrecepcion2">
                                <div class="card-header">
                                    <h6 style="margin-bottom: 0px;"><i class="fa fa-key" aria-hidden="true"></i>&nbsp;Firma &uacute;nica transporte</h6>
                                </div>
                                <div class="card-body"> 
                                    <div class="input-group mb-3" id="date_tabla2" style="margin-bottom: 0rem !important;">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" placeholder="Firma quien trasporta" aria-label="Username" aria-describedby="basic-addon1" id="firma_simple_trasporte" name="firma_simple_trasporte"  value="">
                                    </div>
                                </div>
                            </div>
                            <div class="grid_new_fimarrecepcion3">
                                <button class="btn btn-info" onclick="js_validafirma('firma_simple_trasporte')">
                                    <i class="fa fa-id-card-o" aria-hidden="true"></i>&nbsp;Verificaci&oacute;n de firma &uacute;nica
                                </button>
                            </div>
                            <div class="card grid_new_fimarrecepcion4">
                                <div class="card-header">
                                    <h6 style="margin-bottom: 0px;"><i class="fa fa-key" aria-hidden="true"></i>&nbsp;firma &uacute;nica recepci&oacute;n</h6>
                                </div>
                                <div class="card-body"> 
                                    <div class="input-group mb-3" id="date_tabla2" style="margin-bottom: 0rem !important;">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" placeholder="Firma quien recepciona" aria-label="Username" aria-describedby="basic-addon1" id="firma_simple_recepcion" name="firma_simple_recepcion"  value="">
                                    </div>
                                </div>
                            </div>
                            <div class="grid_new_fimarrecepcion5">&nbsp;
                                <button class="btn btn-fill btn-success all_solicitudes_recepcion toolpit_local" onclick="confirma_recepcion(<?php echo $DATA["ID_SOLICITUD"];?>)">
                                    <i class="fa fa-check" aria-hidden="true"></i><span class="toolpit_local_txt"><i class="fa fa-question-circle-o" aria-hidden="true"></i>&nbsp;Confirma recepci&oacute;n de muestras</span>
                                </button>
                            </div>
                        </div>
                        <!-- OTRA OPCIONES -->
                        <div class="css_panel_rechazo" style="display:none;">
                            <div class="css_panel_rechazo0">&nbsp;</div>
                            <div class="css_panel_rechazo1">
                                <h5 style="color:#888888;">OBSERVACI&Oacute;N GENERAL DE RECHAZO</h5>
                                <div class="mb-3">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="txt_observacion_rechazo" name="txt_observacion_rechazo"></textarea>
                                </div>
                            </div>
                            <div class="css_panel_rechazo3" style="text-align:center;">
                                <button class="btn btn-fill btn-danger all_solicitudes_recepcion toolpit_local" onclick="js_confirma_rechazo_recepcion(<?php echo $DATA["ID_SOLICITUD"];?>)">
                                    <i class="fa fa-times" aria-hidden="true"></i><span class="toolpit_local_txt"><i class="fa fa-question-circle-o" aria-hidden="true"></i>&nbsp;Confirma rechazo de muestras</span>
                                </button>
                            </div>
                            <div class="css_panel_rechazo0">&nbsp;</div>
                        </div>
                    <?php if ($DATA["ID_HISTO_ESTADO"] == 4) {?>
                        <script>marcadas_recepcionadas_resagadas(<?php echo $DATA["ID_SOLICITUD"];?>);</script> 
                    <?php } else { ?>
                        <script>marca_no_enviadasentrasporte(<?php echo $DATA["ID_SOLICITUD"];?>);</script>  
                    <?php } ?>
                <?php } ?>
            <?php
            break;
        case 3:
            echo    "<b>EN TRASPORTE A 1) RECEPCI&Oacute;N</b>";
            break;
        default:
            echo    "<b>NO SE HA IDENTIFICADO</b>";
            break;    
    }
    ?>