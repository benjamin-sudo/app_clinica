<?php $ID_SOLICITUD = $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>

<div class="lista_gestion_tecnologo">
    <ul class="nav nav-tabs" id="myTab">
        <?php if (count($data_bd[":P_ANATOMIA_PATOLOGICA_MUESTRAS"])>0){ ?>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabs_lista_muestras">
                    &nbsp;<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TIPO_BIOPSIA"] == 6 ? 'LAMINAS' : 'MUESTRAS'; ?>
                </button>
            </li>
        <?php } ?>
        <?php if (count($data_bd[":P_AP_MUESTRAS_CITOLOGIA"])>0){ ?>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabs_lista_citologia">&nbsp;CITOLOG&Iacute;A</button>
            </li>
        <?php } ?>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabs_informacion">&nbsp;INFORMACI&Oacute;N</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabs_tecnicas">&nbsp;T&Eacute;CNICAS</button>
        </li>
        <?php if($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TIPO_BIOPSIA"] != 6 && $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TIPO_BIOPSIA"] != 5){ ?>
            <li class="nav-item" onclick="js_load_line_pdf(0,<?php echo $ID_SOLICITUD;?>)" style="display:none">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabs_pdf">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </button>
            </li>
        <?php } ?>
    </ul>
    <div class="tab-content">
        <div id='tabs_pdf' class='tab-pane margin_panel_tabs'>
            <div class="panel_vistas_pdf" style="display: none">
                <div class="panel_vistas_pdf1">&nbsp;</div>
                <div class="panel_vistas_pdf2">&nbsp;</div>
                <div class="panel_vistas_pdf3">&nbsp;</div>
            </div>
            <hr style="margin: 0px">
            <div id="line_pdf_microscopia"></div>
        </div>
        <div id="tabs_lista_citologia" class="tab-pane margin_panel_tabs">

            <?php if(count($data_bd[":P_AP_MUESTRAS_CITOLOGIA"])>0){  ?>
                <h5 style="margin-bottom: 9px;margin-top: 16px;">
                    <i class="fa fa-align-justify" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">LISTADO DE MUESTRAS CITOL&Oacute;GICAS</b>
                </h5>
                <ul class="list-group">
                    <?php foreach($data_bd[":P_AP_MUESTRAS_CITOLOGIA"] as $i => $row){ ?>
                        <li style="padding:0px" data-bs-toggle="collapse" data-bs-parent="#accordion" aria-expanded="true"  class="list-group-item poiter lista_anatomia grupo_<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" id="<?php echo "A".$row['ID_NMUESTRA'];?>" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>" data-NUM_TABS="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                            <div class="grid_muestras_anatomia">
                                <div class="grid_muestras_anatomia1"><?php echo $i+1;?></div>
                                <div class="grid_muestras_anatomia2"><i><?php echo $row['TXT_MUESTRA']?></i></div>
                                <div class="grid_muestras_anatomia3"><?php echo $row['TXT_ETIQUETA'];?>&nbsp;|&nbsp;<?php echo $row['NUM_ML'];?>&nbsp;mL</div>
                                <div class="grid_muestras_anatomia4"><b><?php echo "A".$row['ID_NMUESTRA'];?></b></div>
                                <div class="grid_muestras_anatomia5" id="btn_<?php echo "A".$row['ID_NMUESTRA'];?>">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#muestracitolgica<?php echo $row['ID_NMUESTRA'];?>" aria-expanded="false" aria-controls="muestracitolgica">
                                        Mostrar/Ocultar Contenido
                                    </button>
                                </div>
                            </div>
                            <div id="muestracitolgica<?php echo $row['ID_NMUESTRA'];?>" class="collapse" aria-labelledby="headingOne<?php echo $row['ID_NMUESTRA'];?>" style="margin: 0px 5px 5px 5px;">
                                <div class="card" id="card_informacio_paciente" style="margin-bottom:5px;padding:10px;">
                                    <div class="header">
                                        <h5 class="title">
                                            <i class="fa fa-cog" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">T&Eacute;CNICAS APLICADAS</b>
                                        </h5>
                                    </div>
                                    <div class="content card-body">
                                        <div style="overflow:hidden;">
                                            <select data-width="100%" data-actions-box="true" data-container="body" class="selectpicker arr_muestras" data-selected-text-format="count" data-live-search="true" data-id_ap="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>" multiple name="prestaciones_<?php echo $row['ID_NMUESTRA'];?>" id="prestaciones_<?php echo $row['ID_NMUESTRA'];?>" title="Seleccione Prestaciones...">
                                            <?php
                                                if(count($data_bd[":P_TECNICAS_APLICADAS"])>0){
                                                    foreach($data_bd[":P_TECNICAS_APLICADAS"] as $i => $row){ ?>
                                                        <option value="<?php echo $row["ID_TECNICA_AP"];?>"  data-prestacion="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"><?php echo $row["TXT_TECNICA_AP"];?></option>
                                            <?php   } 
                                                } ?>
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php   }   ?>
                    <?php   }   ?>
                </ul>

        </div>
        <div id='tabs_lista_muestras' class='tab-pane margin_panel_tabs'>
            <div id="tecnicas_realizadas" data-prestacion="<?php echo htmlspecialchars(json_encode($data_bd[":P_TECNICAS_APLICADASXMUESTRA"]),ENT_QUOTES,'UTF-8');?>">
                <?php if(count($data_bd[":P_ANATOMIA_PATOLOGICA_MUESTRAS"])>0){ ?>
                    <h5 style="margin-bottom: 9px;margin-top: 16px;">
                        <i class="fa fa-align-justify" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">LISTADO DE MUESTRAS</b>
                    </h5>
                <?php
                    if($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]['IND_USOCASSETTE'] == 1){?>
                        <?php 
                            $ARR_CASETE_ORD = [];
                            foreach($data_bd[":P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ $ARR_CASETE_ORD[$row['NUM_CASSETTE']][] = $row; }   //ordenando x casete
                            $arr_li_casete = [];
                            $arr_div_content = [];
                            $aux = 0;
                            foreach ($ARR_CASETE_ORD as $_num => $row_all){
                                $html_muestra_casete        =   '<ul class="list-group" id="ul_muestras_'.$_num.'" style="margin-bottom:0px;">';
                                $active                     =   $aux == 0 ? 'active':'';
                                foreach($row_all as $x => $row_muestras){
                                    $numero                     =   $x + 1 ;
                                    $html_muestra_casete .= '
                                        <li style="padding: 0px" data-bs-toggle="collapse" data-bs-parent="#accordion" aria-expanded="true" aria-controls="nuestra_x_casete_'.$row_muestras['ID_NMUESTRA'].'" class="list-group-item lista_casete poiter"> 
                                            <div class="grid_muestras_anatomia">
                                                <div class="grid_muestras_anatomia1">'.$numero.'</div>
                                                <div class="grid_muestras_anatomia2"><i>'.$row_muestras['TXT_MUESTRA'].'</i></div>
                                                <div class="grid_muestras_anatomia3">'.$row_muestras['TXT_ETIQUETA'].'</div>
                                                <div class="grid_muestras_anatomia4"><b>'.$row_muestras['ID_NMUESTRA'].'</b></div>
                                                <div class="grid_muestras_anatomia5" id="btn_'.$row_muestras['ID_NMUESTRA'].'">
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#nuestra_x_casete_'.$row_muestras['ID_NMUESTRA'].'" aria-expanded="false" aria-controls="muestracitolgica">
                                                        Mostrar/Ocultar Contenido
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="nuestra_x_casete_'.$row_muestras['ID_NMUESTRA'].'" class="collapse" style="margin: 0px 10px 25px 10px;">
                                                <div class="card" id="card_informacio_paciente" style="margin-bottom: 5px">
                                                    <div class="header" style="margin-top: 7px;margin-left: 17px;">
                                                        <h5 class="title"><i class="fa fa-cog" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">T&Eacute;CNICAS APLICADAS</b></h5>
                                                    </div>
                                                    <div class="content card-body">
                                                        <div style="overflow:hidden;">
                                                            <select data-width="100%" data-actions-box="true" data-container="body" class="selectpicker arr_muestras" data-actions-box="true" data-selected-text-format="count" data-live-search="true" data-id_ap="'.$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"].'" data-id_muestra="'.$row_muestras['ID_NMUESTRA'].'" multiple name="prestaciones_'.$row_muestras['ID_NMUESTRA'].'" id="prestaciones_'.$row_muestras['ID_NMUESTRA'].'" title="Seleccione Tecnicas...">
                                    ';
                                    if(count($data_bd[":P_TECNICAS_APLICADAS"]) > 0) {
                                        foreach($data_bd[":P_TECNICAS_APLICADAS"] as $i => $row) {
                                            $html_muestra_casete .= '<option value="'.$row["ID_TECNICA_AP"].'" data-prestacion="'.htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8').'">'.$row["TXT_TECNICA_AP"].'</option>';
                                        }
                                    }
                                    $html_muestra_casete .= '
                                                            </select> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    ';
                                }
                                $html_muestra_casete.='</ul>';
                                array_push($arr_li_casete,'<li class="nav-item"><a class="nav-link '.$active.'" data-bs-toggle="tab" href="#home_'.$aux.'"><i class="fa fa-file" aria-hidden="true"></i> CASETE '.($aux+1).'</a></li>');
                                array_push($arr_div_content,'<div class="tab-pane container '.$active.'" id="home_'.$aux.'">'.$html_muestra_casete.'</div>');
                                $aux++;
                            }
                        ?>
                        <div class=" lista_ordenada_casete">
                            <ul class="nav nav-tabs" style=""><?php echo implode(" ",$arr_li_casete);?></ul>
                            <div class="tab-content" style="margin-top: 5px;"><?php echo implode(" ",$arr_div_content);?></div>
                        </div>
                    <?php } else { ?>
                        <ul class="list-group" id="ul_muestras" style="margin-bottom:0px;">
                            <?php foreach($data_bd[":P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ ?>

                                <li style="padding:0px"  data-bs-toggle="collapse" data-bs-parent="#accordion"  data-bs-target="#collapseOne<?php echo $row['ID_NMUESTRA'];?>" aria-expanded="true" aria-controls="collapseOne<?php echo $row['ID_NMUESTRA'];?>"   class="list-group-item poiter lista_anatomia grupo_<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" id="<?php echo "A".$row['ID_NMUESTRA'];?>" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>" data-NUM_TABS="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                    <div class="grid_muestras_anatomia">
                                        <div class="grid_muestras_anatomia1"><?php echo $i+1;?></div>
                                        <div class="grid_muestras_anatomia2"><i><?php echo $row['TXT_MUESTRA']?></i></div>
                                        <div class="grid_muestras_anatomia3"><?php echo $row['TXT_ETIQUETA'];?></div>
                                        <div class="grid_muestras_anatomia4"><b><?php echo "A".$row['ID_NMUESTRA'];?></b></div>
                                        <div class="grid_muestras_anatomia5" id="btn_<?php echo "A".$row['ID_NMUESTRA']; ?>">
                                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#muestrabiopsia<?php echo $row['ID_NMUESTRA'];?>" aria-expanded="false" aria-controls="muestrabiopsia">
                                                Mostrar/Ocultar Contenido
                                            </button>
                                        </div>
                                    </div>
                                    <div class="collapse" id="muestrabiopsia<?php echo $row['ID_NMUESTRA'];?>"  style="margin: 0px 5px 5px 5px;">
                                        <div class="card" id="card_informacio_paciente" style="margin-bottom:5px;padding:10px;">
                                            <div class="header" >
                                                <h5 class="title">
                                                    <i class="fa fa-cog" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">T&Eacute;CNICAS APLICADAS - N&deg; <?php echo $row['ID_NMUESTRA'];?></b>
                                                </h5>
                                            </div>
                                            <div class="content card-body">
                                                <div style="overflow:hidden;">
                                                    <select  class="selectpicker arr_muestras class_tecnicas_applicadas" data-width="100%" data-actions-box="true" data-container="body" data-selected-text-format="count" data-live-search="true" data-id_ap="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>" multiple name="prestaciones_<?php echo $row['ID_NMUESTRA'];?>" id="prestaciones_<?php echo $row['ID_NMUESTRA'];?>" title="Seleccione Prestaciones..." >
                                                    <?php
                                                        if(count($data_bd[":P_TECNICAS_APLICADAS"])>0){
                                                            foreach($data_bd[":P_TECNICAS_APLICADAS"] as $i => $row){ ?>
                                                                <option value="<?php echo $row["ID_TECNICA_AP"];?>" data-prestacion="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"><?php echo $row["TXT_TECNICA_AP"];?></option>
                                                    <?php   } 
                                                        } ?>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>


                            <?php } ?>
                        </ul>
                    <?php } ?>
                <?php } else { ?>
                    <b><i>SIN MUESTRAS CARGADAS</i></b>
                <?php } ?>
            </div>
        </div>
        <div id="tabs_informacion" class="tab-pane margin_panel_tabs">
            <div class="panel_info_geneal_up">
                    <div class="panel_info_geneal_tec1">
                        <div class="card" id="card_registro_medico4" style="margin-bottom:5px;padding:8px;margin-top: 15px;">
                            <h6 class="title" style="margin: 8px 0px 12px 0px;">
                                <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                                <b style="color:#888888;">INFORMACI&Oacute;N COMPLEMENTARIA</b>
                            </h6>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td style="width: 50%" class="padding-personalizado">
                                            <small><b style="color:#888888;">FECHA DE MACRO</b></small>
                                            <br>
                                            <div id="calendar_fecha_macro" class="input-group row_calendar star_calendar" style="width:140px;">
                                                <input id="date_fecha_macro" name="date_fecha_macro" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_FECHA_MACRO"]==''?date('d-m-Y'):$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_FECHA_MACRO"];?>">
                                                <span class="input-group-addon" style="cursor:pointer;margin-left: 9px;margin-top: 6px;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
                                            </div>
                                        </td>
                                        <td style="width: 50%" class="padding-personalizado">
                                            <small><b style="color:#888888;">FECHA DE CORTE</b></small>
                                            <br>
                                            <div id="calendar_fecha_corte" class="input-group row_calendar star_calendar" style="width:140px;">
                                                <input id="date_fecha_corte" name="date_fecha_corte" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_FECHA_CORTE"]==''?date('d-m-Y'):$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_FECHA_CORTE"];?>">
                                                <span class="input-group-addon" style="cursor:pointer;margin-left: 9px;margin-top: 6px;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
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
                                            <div id="calendar_interconsulta_ap" class="input-group row_calendar star_calendar" style="width:140px;">
                                                <input id="date_interconsulta_ap" name="date_interconsulta_ap" type="text" class="form-control input-sm" value="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_INTERCONSULTA"]==''?date('d-m-Y'):$data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["DATE_INTERCONSULTA"];?>">
                                                <span class="input-group-addon" style="cursor:pointer;margin-left: 9px;margin-top: 6px;"><span class="fa fa-calendar" aria-hidden="true"></span></span>
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
                                            <small><b style="color:#888888;">NUMERO DE FRAGMENTOS</b></small><br>
                                            <select class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true" name="num_fragmentos" id="num_fragmentos" data-width="98%" tabindex="-98">
                                                <option value=""> -- </option>
                                                <?php for($i = 1; $i < 21; ++$i) { 
                                                    $selected   =   $i == $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_FRAGMENTOS"]?'selected ':'';
                                                    echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';  
                                                }  ?>
                                            </select>
                                        </td>
                                        <td>
                                            <small><b style="color:#888888;">N&deg; TACOS CORTADOS</b></small><br>
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
                        <div class="card" id="card_registro_medico3" style="margin-bottom:5px;padding:8px;display:none">
                            <h6 class="title" style="margin: 8px 0px 12px 0px;">
                                <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                                <b style="color:#888888;">INFORMACI&Oacute;N ADICIONAL</b>
                            </h6>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td style="width: 50%">
                                            <small><b style="color:#888888;">AZUL ALCIAN SERIADA</b> </small>
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
        </div>
        <div id='tabs_tecnicas' class='tab-pane margin_panel_tabs'>
            <h5 style="margin-bottom:4px;margin-top:15px;">
                <i class="fa fa-align-justify" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">TECNICAS</b>
            </h5>
            <div class="grid_tecnicas_complementaria">
                <div class="grid_tecnicas_complementaria1">
                    <div class="grid_group_checkbox">
                        <div class="grid_group_checkbox1">
                            <input class="form-check-input pointer checked_tecnicas" type="checkbox" style="display: block" id="ind_inclusion" value="">
                        </div>
                        <div class="grid_group_checkbox2">
                            <label class="form-check-label pointer" for="ind_inclusion" style="margin-top: 3px;">INCLUSI&Oacute;N</label>
                        </div>
                    </div>
                    <?php   if($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TEC_INCLUCION"] == 1){ ?>
                        <!--
                            IND_TEC_INCLUCION = <?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TEC_INCLUCION"];?>
                        -->
                        <script>document.getElementById("ind_inclusion").checked = true;</script>
                    <?php   }   ?>
                </div>
                <div class="grid_tecnicas_complementaria2">
                    <div class="grid_group_checkbox">
                        <div class="grid_group_checkbox1">
                            <input class="form-check-input pointer checked_tecnicas" type="checkbox" style="display: block" id="ind_corte"  value="">
                        </div>
                        <div class="grid_group_checkbox2">
                            <label class="form-check-label pointer" for="ind_corte" style="margin-top: 3px;">CORTE</label>
                        </div>
                    </div>
                    <?php   if($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TEC_CORTE"] == 1){ ?>
                        <!--
                        IND_TEC_CORTE = <?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TEC_CORTE"];?>
                        -->
                        <script>document.getElementById("ind_corte").checked = true;</script>
                    <?php   }   ?>
                </div>
                <div class="grid_tecnicas_complementaria3">
                    <div class="grid_group_checkbox">
                        <div class="grid_group_checkbox1">
                            <input class="form-check-input pointer checked_tecnicas" type="checkbox" style="display: block" id="ind_tincion"  value="">
                        </div>
                        <div class="grid_group_checkbox2">
                            <label class="form-check-label pointer" for="ind_tincion" style="margin-top: 3px;">TINCI&Oacute;N</label>
                        </div>
                    </div>
                    <?php   if($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TEC_TINCION"] == 1){ ?>
                        <!--
                        IND_TEC_TINCION = <?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TEC_TINCION"];?>
                        -->
                        <script>document.getElementById("ind_tincion").checked = true;</script>
                    <?php   }   ?>
                </div>
            </div>
            <div class="callout callout_info" style="border-radius:4px;">
                <strong>
                    <i class="fa fa-info" aria-hidden="true"></i>&nbsp;INFORMACI&Oacute;N NECESARIA PARA PASAR AL FORMULARIO DEL PAT&Oacute;LOGO
                </strong>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var myTab = document.getElementById('myTab');
        var firstTab = new bootstrap.Tab(myTab.querySelector('.nav-link'));
        firstTab.show();
    });
</script>
