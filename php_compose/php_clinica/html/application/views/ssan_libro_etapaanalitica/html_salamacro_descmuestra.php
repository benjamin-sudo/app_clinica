<div class="grid_head_descripcion_muestras" style="">
    <div class="grid_head_descripcion_muestras1">
        <div class="card" id="card_descripcion_general_mactoscopia" style="margin-bottom:5px;padding:8px;">
            <div class="grid_opcion_descri_titulo">
                <div class="grid_opcion_descri_titulo1"> <h5  style="margin: 0px 0px 0px 0px;"><b style="color:#888888;">&#8226;&nbsp;DESCRIPCI&Oacute;N MACROSC&Oacute;PICA</b></h5>  </div>
                <div class="grid_opcion_descri_titulo1"> 
                    <label for="ind_deshabilitar_macro" class="pointer" style="color:#888888;">&nbsp;NO APLICA&nbsp;</label>
                </div>
                <div class="grid_opcion_descri_titulo1"> 
                    <input class="form-check-input pointer pointer" type="checkbox" style="display:initial" id="ind_deshabilitar_macro" onclick="js_deshabilitar_txt()" value="1"/>
                </div>
            </div>

            <div class="grid_opcion_descripcion_muestra">
                <div class="grid_opcion_descripcion_muestra1">
                    <textarea 
                        class       =   "form-control input-sm" 
                        name        =   "txt_descipcion_general" 
                        id          =   "txt_descipcion_general" 
                        cols        =   "65" 
                        rows        =   "5" 
                        style       =   "width:100%;" 
                        maxlength   =   "4000" 
                        onkeyup     =   ""><?php echo $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA'];?></textarea>
                    <div class="grid_texto_main_macroscopia">
                        <div class="grid_texto_main_macroscopia1">&nbsp;</div>
                        <div class="grid_texto_main_macroscopia2">&nbsp;</div>
                        <div class="grid_texto_main_macroscopia3">&nbsp;</div>
                        <div class="grid_texto_main_macroscopia4">
                            <i class="fa fa-stop-circle-o parpadea icon_grabando_<?php echo $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?>" style="color:#FB404B;display:none" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="grid_opcion_descripcion_muestra2" style="text-align: center">
                    <div class="btn-group-vertical" style="display:none">
                        <button type            =   "button"
                            class           =   "btn btn-success btn-xs btn-fill grupo_descipcion_general" 
                            id              =   "microfono_<?php echo $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?>"
                            data-id_area    =   "txt_descipcion_general"
                            data-ind_tipo   =   "global_main"
                            data-icongrab   =   "icon_grabando_<?php echo $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?>"
                            data-proce      =   "proce_descipcion_general_<?php echo $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?>"
                            onclick         =   "star_microfono_general(this.id)">
                            <i class="fa fa-microphone" aria-hidden="true"></i>
                        </button>
                        <button 
                            type            =   "button" 
                            class           =   "btn btn-danger btn-xs btn-fill grupo_descipcion_general" 
                            id              =   "btn_termina_mic_<?php echo $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?>" 
                            onclick         =   "mic_terminar(this.id)">
                            <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="grid_opcion_descripcion_muestra3" id="imagen_main">

                    <?php if(count($data_bd[':C_IMAGENES_BLOB_MUESTRAS'])>0){ ?>
                        <?php foreach($data_bd[':C_IMAGENES_BLOB_MUESTRAS'] as $i => $row){ ?>
                            <div class="card img_sala_macroscopia img_<?php echo $row['ID_IMAGEN'];?>" style="margin-bottom:0px;text-align:-webkit-center;padding:6px;">
                                <img 
                                    class                   =   "img-thumbnail"
                                    id                      =   "img_macro_main_<?php echo $row['ID_IMAGEN'];?>"
                                    data-src                =   "<?php echo $row["NAME_IMG"];?>" 
                                    alt                     =   "64x64" 
                                    src                     =   "<?php echo $row["IMG_DATA"];?>" 
                                    data-holder-rendered    =   "true" 
                                    style                   =   "width:64px;height:64px;"/>
                                <hr style="margin:4px">
                                    <div class="grid_btn_image">
                                        <div class="grid_btn_image1">
                                            <a href="javascript:delete_img_x_main({img:'<?php echo $row['ID_IMAGEN'];?>',id:'<?php echo $row['ID_IMAGEN'];?>'})" id="img_<?php echo $row['ID_IMAGEN'];?>">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="grid_btn_image1">
                                        <a href="javascript:down_img_x_main(<?php echo $row['ID_IMAGEN'];?>)">
                                            <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>

                               


                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="card" style="margin-bottom:0px; padding:8px;" id="imagen_sala_macroscopia">
                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                <label for="imagen_macroscopia_<?php echo $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?>" style="margin-top:20px;" class="form-label d-flex flex-column justify-content-center align-items-center">
                                    <i class="fa fa-cloud-upload fa-4x" aria-hidden="true" style="margin-top: -19px;"></i> 
                                    <i>Subir</i>
                                </label>
                                <input
                                    type        =   "file"
                                    id          =   "imagen_macroscopia_<?php echo $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?>"
                                    class       =   "form-control"
                                    onchange    =   "main_js_adjunto_ap(<?php echo $data_bd[':P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?>, this.files)"
                                    style       =   "display: none;">
                            </div>
                        </div>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="grid_head_descripcion_muestras2">&nbsp;</div>
</div>

<div id="id_tabs_muestras_macroscopia">
    <ul class="nav nav-tabs" style="cursor:pointer;" id="tabs_muestras_macroscopica">
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#_anatomia_macroscopia"><i class="fa fa-th-list" aria-hidden="true"></i>&nbsp;MUESTRAS ANATOMIA</button>
        </li>
        <li class="nav-item" style="<?php echo count($data_bd[":P_AP_MUESTRAS_CITOLOGIA"])>0?'':'display:none;'?>">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#_anatomia_citologia"><i class="fa fa-th-list" aria-hidden="true"></i>&nbsp;MUESTRAS CITOLOG&Iacute;A</button>
        </li>
    </ul>
    <div class="tab-content" style="">
        <div id="_anatomia_macroscopia" class="tab-pane fade ">
            <div class="card2" id="card_muestra_anatomicas" style="margin-bottom:5px;padding:8px;">
                <h6 class="title" style="margin: 15px 0px 12px 0px;">
                    <i style="color:#888888;" class="fa fa-th-list" aria-hidden="true"></i>&nbsp;
                    <b style="color:#888888;">MUESTRAS ANATOMIA <?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]['IND_USOCASSETTE']==1?'(CASETE)':'';?> | DESCRIPCI&Oacute;N MACROSC&Oacute;PIA</b>
                </h6>
                <?php if(count($data_bd[":P_ANATOMIA_PATOLOGICA_MUESTRAS"])>0){ 
                    if($data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]['IND_USOCASSETTE'] == 1){?>
                        <?php 
                            $ARR_CASETE_ORD = [];
                            foreach($data_bd[":P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ 
                                $ARR_CASETE_ORD[$row['NUM_CASSETTE']][] = $row; 
                            }

                            $arr_li_casete = [];
                            $arr_div_content = [];
                            $aux = 0;
                            
                            foreach ($ARR_CASETE_ORD as $_num => $row_all) {
                                $html_muestra_casete = '<ul class="list-group" id="ul_muestras_' . $_num . '" style="margin-bottom:0px;">';
                                $active = $aux == 0 ? 'active' : '';
                                $n_biopsias = count($row_all);
                                $html_muestra_casete .= '
                                    <li style="padding:8px" class="list-group-item lista_casete" id="' . $row_all[0]['ID_CASETE'] . '"> 
                                        <div class="grid_opcion_descripcion_muestra" style="padding:4px;margin-bottom:6px;">
                                            <div class="grid_opcion_descripcion_muestra4 text-start">
                                                <b style="color:#888888;">&#8226; CASETE ' . $row_all[0]['NUM_CASSETTE'] . ' | C' . $row_all[0]['ID_CASETE'] . '  N&deg; MUESTRAS:' . $n_biopsias . '</b>
                                            </div>
                                            <div class="grid_opcion_descripcion_muestra5">&nbsp;</div>
                                            <div class="grid_opcion_descripcion_muestra6">&nbsp;</div>
                                        </div>';
                                
                                foreach ($row_all as $i => $row_casete) {
                                    $html_muestra_casete .= '<div class="card lista_casete_x_muestra" id="' . $row_casete['ID_NMUESTRA'] . '" style="margin-bottom:5px;padding:8px;">';
                                    $html_muestra_casete .= '<div class="grid_opcion_descripcion_muestra">
                                                                <div class="grid_opcion_descripcion_muestra4 text-start">
                                                                    <b style="color:#888888;">&#8226;&nbsp;N&deg;&nbsp;' . ($i + 1) . ' | ' . $row_casete['TXT_MUESTRA'] . ' | ID : ' . $row_casete['ID_NMUESTRA'] . ' | ' . $row['TXT_ETIQUETA'] . '</b>
                                                                </div>
                                                                <div class="grid_opcion_descripcion_muestra5">&nbsp;</div>
                                                                <div class="grid_opcion_descripcion_muestra6">&nbsp;</div>
                                                            </div>
                                                            <div class="grid_opcion_descripcion_muestra">
                                                                <div class="grid_opcion_descripcion_muestra1">
                                                                    <textarea 
                                                                        class       =   "form-control" 
                                                                        name        =   "txt_descipcion_' . $row_casete['ID_NMUESTRA'] . '" 
                                                                        id          =   "txt_descipcion_' . $row_casete['ID_NMUESTRA'] . '" 
                                                                        cols        =   "65" 
                                                                        rows        =   "5" 
                                                                        style       =   "width:100%;" 
                                                                        maxlength   =   "4000" 
                                                                        onkeyup     =   "">' . $row_casete['TXT_DESC_MACROSCOPICA'] . '</textarea>
                                                                    <div class="grid_texto_main_macroscopia">
                                                                        <div class="grid_texto_main_macroscopia1">&nbsp;</div>
                                                                        <div class="grid_texto_main_macroscopia2"></div>
                                                                        <div class="grid_texto_main_macroscopia3"></div>
                                                                        <div class="grid_texto_main_macroscopia4">
                                                                            <i class="fa fa-stop-circle-o parpadea icon_grabando_' . $row_casete['ID_NMUESTRA'] . '" style="color:#FB404B;display:none" aria-hidden="true"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid_opcion_descripcion_muestra2 text-center">
                                                                    <div class="btn-group-vertical" style="display:none;">
                                                                        <button 
                                                                            type            =   "button" 
                                                                            class           =   "btn btn-success btn-sm btn-fill" 
                                                                            id              =   "microfono_' . $row_casete['ID_NMUESTRA'] . '" 
                                                                            data-id_area    =   "txt_descipcion_' . $row_casete['ID_NMUESTRA'] . '"
                                                                            data-ind_tipo   =   "muestra"
                                                                            data-icongrab   =   "icon_grabando_' . $row_casete['ID_NMUESTRA'] . '"
                                                                            onclick         =   "star_microfono_general(this.id)"
                                                                            >
                                                                            <i class="fa fa-microphone" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button 
                                                                            type            =   "button" 
                                                                            class           =   "btn btn-danger btn-sm btn-fill" 
                                                                            id              =   "btn_termina_mic_' . $row_casete['ID_NMUESTRA'] . '" 
                                                                            onclick         =   "mic_terminar(this.id)"
                                                                            >
                                                                            <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                                                        </button>
                                                                        <button 
                                                                            type                =   "button" 
                                                                            class               =   "btn btn-warning btn-sm btn-fill" 
                                                                            id                  =   "btn_termina_plantillas_' . $row_casete['ID_NMUESTRA'] . '" 
                                                                            onclick             =   "js_star_plantillas(1,' . $row_casete['ID_NMUESTRA'] . ')"
                                                                            >
                                                                            <i class="fa fa-comment" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>';
                                    $html_muestra_casete .= '<div class="grid_opcion_descripcion_muestra3" id="vista_x_muestra_' . $row_casete['ID_NMUESTRA'] . '">';
                                    if ($row_casete['ID_IMAGEN'] == '') {
                                        $json = htmlspecialchars(json_encode([
                                            'return_div'    => 'card_img_' . $row_casete['ID_NMUESTRA'],
                                            'return_div2'   => 'vista_x_muestra_' . $row_casete['ID_NMUESTRA'],
                                            'txt_zona'      => 'salamacroscopia',
                                            'ind_zona'      => '1',
                                            'tipo_muestra'  => 'anatomica',
                                            'id_anatomia'   => $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"],
                                            'id_muestra'    => $row_casete['ID_NMUESTRA'],
                                            'id_casete'     => null,
                                        ]), ENT_QUOTES, 'UTF-8');
                                        $html_muestra_casete .= '
                                            <div class="card" style="margin-bottom:0px" id="card_img_' . $row_casete['ID_NMUESTRA'] . '">
                                                <div style="padding: 10px;">
                                                    <div style="background-color: transparent !important; text-align: center">
                                                        <div class="font_15"><b>SUBIR</b></div>
                                                    </div>
                                                    <hr style="margin-top:10px;margin-bottom:10px">
                                                    <div class="text-center">
                                                        <div class="custom-file" style="cursor:pointer;">
                                                            <label for="img_macro_a_' . $row_casete['ID_NMUESTRA'] . '">
                                                                <i class="fa fa-file-image-o fa-4x" aria-hidden="true" style=" width:100px;"></i>
                                                            </label>
                                                            <input 
                                                                type        =   "file"
                                                                data-config =   "' . $json . '"
                                                                id          =   "img_macro_a_' . $row_casete['ID_NMUESTRA'] . '" 
                                                                name        =   "img_macro_a_' . $row_casete['ID_NMUESTRA'] . '" 
                                                                onchange    =   "js_adjunto_ap_multiple(this.id,this.files);"
                                                                accept      =   "image/png,image/jpeg">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                    } else {
                                        $html_muestra_casete .= '
                                            <div class="card" style="margin-bottom:0px;text-align:center;padding:6px;" >
                                                <img 
                                                   class="img-thumbnail"
                                                   id="img_macro_' . $row_casete['ID_IMAGEN'] . '"
                                                   data-src="' . $row_casete['NAME_IMG'] . '" 
                                                   alt="64x64" 
                                                   src="' . $row_casete['IMG_DATA'] . '" 
                                                   data-holder-rendered="true" 
                                                   style="width:64px;height:64px;"
                                                >
                                                <hr style="margin:2px">
                                                <a href="javascript:delete_img_x_muestra(' . $row_casete['ID_IMAGEN'] . ',' . $row_casete['ID_NMUESTRA'] . ',' . $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"] . ')">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </div>';
                                    }
                                    $html_muestra_casete .= '</div>';  
                                    $html_muestra_casete .= '</div>'; // END GRID
                                    $html_muestra_casete .= '</div>'; // END CARD
                                }
                                $html_muestra_casete .= '</li>';
                                $html_muestra_casete .= '</ul>';
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
                                <li style="padding:8px" class="list-group-item lista_anatomia grupo_<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" id="<?php echo $row['ID_NMUESTRA'];?>" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>"    data-NUM_TABS="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                    <div class="grid_opcion_descripcion_muestra">
                                        <div class="grid_opcion_descripcion_muestra4" style="text-align:left;">
                                            <b style="color:#888888;">&#8226;&nbsp;N&deg;&nbsp;<?php echo $i+1;?> | <?php echo $row['TXT_MUESTRA'];?> | <?php echo "A".$row['ID_NMUESTRA'];?> | <?php echo $row['TXT_ETIQUETA'];?></b>
                                        </div>
                                        <div class="grid_opcion_descripcion_muestra5">&nbsp;</div>
                                        <div class="grid_opcion_descripcion_muestra6">&nbsp;</div>
                                    </div>
                                    <div class="grid_opcion_descripcion_muestra">
                                        <div class="grid_opcion_descripcion_muestra1">
                                            <textarea 
                                                class = "form-control input-sm" 
                                                name = "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                                id = "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                                cols = "65" 
                                                rows = "5" 
                                                style = "width:100%;" 
                                                maxlength = "4000"><?php echo $row['TXT_DESC_MACROSCOPICA'];?></textarea>
                                            <div class="grid_texto_main_macroscopia">
                                                <div class="grid_texto_main_macroscopia1">&nbsp;</div>
                                                <div class="grid_texto_main_macroscopia2">&nbsp;</div>
                                                <div class="grid_texto_main_macroscopia3">&nbsp;</div>
                                                <div class="grid_texto_main_macroscopia4">
                                                    <i class="fa fa-stop-circle-o parpadea icon_grabando_<?php echo $row['ID_NMUESTRA'];?>" style="color:#FB404B;display:none" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_opcion_descripcion_muestra2" style="text-align:center">
                                            <div class="btn-group-vertical" style="display:none">
                                                <button 
                                                    type = "button" 
                                                    class = "btn btn-success btn-xs btn-fill" 
                                                    id = "microfono_<?php echo $row['ID_NMUESTRA'];?>" 
                                                    data-id_area = "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>"
                                                    data-ind_tipo = "muestra"
                                                    data-icongrab = "icon_grabando_<?php echo $row['ID_NMUESTRA'];?>"
                                                    onclick = "star_microfono_general(this.id)"
                                                    >
                                                    <i class="fa fa-microphone" aria-hidden="true"></i>
                                                </button>
                                                <button 
                                                    type = "button" 
                                                    class = "btn btn-danger btn-xs btn-fill" 
                                                    id = "btn_termina_mic_<?php echo $row['ID_NMUESTRA'];?>" 
                                                    onclick =   "mic_terminar(this.id)"
                                                    >
                                                    <i class="fa fa-microphone-slash" aria-hidden="true"></i> 
                                                </button>
                                                <button 
                                                    type = "button" 
                                                    class = "btn btn-warning btn-xs btn-fill" 
                                                    id = "btn_termina_plantilla_<?php echo $row['ID_NMUESTRA'];?>" 
                                                    onclick = "js_star_plantillas(1,<?php echo $row['ID_NMUESTRA'];?>)"
                                                    >
                                                    <i class="fa fa-comment" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="grid_opcion_descripcion_muestra3" id="vista_x_muestra_<?php echo $row['ID_NMUESTRA'];?>"> 
                                            <?php   if ($row['ID_IMAGEN'] == ''){?> 
                                                <div class="card" style="margin-bottom:0px" id="card_img_<?php echo $row['ID_NMUESTRA'];?>">
                                                    <div style="padding: 10px;">
                                                        <div style="background-color: transparent !important; text-align: center">
                                                            <div class="font_15"><b>SUBIR</b></div>
                                                        </div>
                                                        <hr style="margin-top:10px;margin-bottom:10px">
                                                        <div class="text-center">
                                                            <div class="custom-file" style="cursor:pointer;">
                                                                <label for="img_macro_a_<?php echo $row['ID_NMUESTRA'];?>">
                                                                    <i class="fa fa-file-image-o fa-4x" aria-hidden="true" style=" width:100px;"></i>
                                                                </label>
                                                                <input type         =   "file"
                                                                       data-config  =   "<?php echo htmlspecialchars(json_encode([
                                                                                            'return_div'    =>  'card_img_'.$row['ID_NMUESTRA'],
                                                                                            'return_div2'   =>  'vista_x_muestra_'.$row['ID_NMUESTRA'],
                                                                                            'txt_zona'      =>  'salamacroscopia',
                                                                                            'ind_zona'      =>  '1',
                                                                                            'tipo_muestra'  =>  'anatomica',
                                                                                            'id_anatomia'   =>  $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"],
                                                                                            'id_muestra'    =>  $row['ID_NMUESTRA'],
                                                                                            'id_casete'     =>  null,
                                                                                        ]),ENT_QUOTES,'UTF-8');?>"
                                                                       id           =   "img_macro_a_<?php echo $row['ID_NMUESTRA'];?>" 
                                                                       name         =   "img_macro_a_<?php echo $row['ID_NMUESTRA'];?>" 
                                                                       onchange     =   "js_adjunto_ap_multiple(this.id,this.files);"
                                                                       accept       =   "image/png,image/jpeg">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php   }   else    {   ?>
                                                <div class="card" style="margin-bottom:0px;text-align:-webkit-center;padding:6px;" >
                                                    <img 
                                                        class                   =   "img-thumbnail"
                                                        id                      =   "img_macro_<?php echo $row['ID_IMAGEN'];?>"
                                                        data-src                =   "<?php echo $row["NAME_IMG"];?>" 
                                                        alt                     =   "64x64" 
                                                        src                     =   "<?php echo $row["IMG_DATA"];?>" 
                                                        data-holder-rendered    =   "true" 
                                                        style                   =   "width:64px;height:64px;"
                                                    >
                                                    <hr style="margin:2px">

                                                    <div class="grid_btn_image">
                                                        <div class="grid_btn_image1">
                                                            <a href="javascript:delete_img_x_muestra(<?php echo $row['ID_IMAGEN'];?>,<?php echo $row['ID_NMUESTRA'];?>,<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>)">
                                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                        <div class="grid_btn_image1">
                                                            <a href="javascript:down_img_x_muestra(<?php echo $row['ID_IMAGEN'];?>)">
                                                                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php   }   ?>
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
        <div id="_anatomia_citologia" class="tab-pane fade">
            <div class="card2" id="card_muestra_citologica" style="margin-bottom:5px;padding:8px;">
                <div class="grid_opcion_descri_titulo">
                    <div class="grid_opcion_descri_titulo1">
                        <h6  style="margin: 7px 0px 10px 0px;">
                            <b style="color:#888888;">&#8226;&nbsp;DESCRIPCI&Oacute;N CITOLOG&Iacute;CA</b>
                        </h6>
                    </div>
                    <div class="grid_opcion_descri_titulo1">
                        <label for="ind_deshabilitar_macro_cito" class="pointer" style="color:#888888;">&nbsp;NO APLICA</label>
                    </div>
                    <div class="grid_opcion_descri_titulo1">
                        <input class="form-check-input pointer pointer" type="checkbox" style="display:initial" id="ind_deshabilitar_macro_cito" onclick="js_deshabilitar_txt_cito()" value="1"/>
                    </div>
                </div>

                <div style="text-align:center">
                    <?php if(count($data_bd[":P_AP_MUESTRAS_CITOLOGIA"])>0){ ?>
                        <ul class="list-group" id="ul_muestras" style="margin-bottom:0px;">
                        <?php foreach($data_bd[":P_AP_MUESTRAS_CITOLOGIA"] as $i => $row){ ?>
                            <li style="padding:8px" class="list-group-item lista_citologia grupo_<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" id="<?php echo $row['ID_NMUESTRA'];?>" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>"    data-NUM_TABS="<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                <div class="grid_opcion_descripcion_muestra">
                                    <div class="grid_opcion_descripcion_muestra4" style="text-align:left;">
                                        <b style="color:#888888;">&#8226;&nbsp;N&deg;&nbsp;<?php echo $i+1;?> | <?php echo $row['TXT_MUESTRA'];?> | <?php echo "A".$row['ID_NMUESTRA'];?> | <?php echo $row['NUM_ML']?> mL | <?php echo $row['TXT_ETIQUETA'];?></b>
                                    </div>
                                    <div class="grid_opcion_descripcion_muestra5">&nbsp;</div>
                                    <div class="grid_opcion_descripcion_muestra6">&nbsp;</div>
                                </div>
                                <hr style="margin:4px">
                                <div class="grid_opcion_descripcion_muestra" style="">
                                    <div class="grid_opcion_descripcion_muestra1">
                                        <textarea 
                                            class = "form-control input-sm grupo_macro_textarea_citologia" 
                                            name = "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                            id = "txt_descipcion_<?php echo $row['ID_NMUESTRA'];?>" 
                                            cols = "65" 
                                            rows = "5" 
                                            style = "width:100%;" 
                                            maxlength = "4000" 
                                            onkeyup =   ""><?php echo $row['TXT_DESC_MACROSCOPICA'];?></textarea>
                                        <div class="grid_texto_main_macroscopia">
                                            <div class="grid_texto_main_macroscopia1">&nbsp;</div>
                                            <div class="grid_texto_main_macroscopia2"></div>
                                            <div class="grid_texto_main_macroscopia3"></div>
                                            <div class="grid_texto_main_macroscopia4">
                                                <i class="fa fa-stop-circle-o parpadea icon_grabando_<?php echo $row['ID_NMUESTRA'];?>" style="color:#FB404B;display:none" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid_opcion_descripcion_muestra2" style="text-align: center">
                                        <div class="btn-group-vertical" style="display:none">
                                            <button 
                                                type            =   "button" 
                                                class           =   "btn btn-success btn-xs btn-fill grupo_macro_microfono_citologia" 
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
                                                class           =   "btn btn-danger btn-xs btn-fill grupo_macro_microfono_citologia" 
                                                id              =   "btn_termina_mic_<?php echo $row['ID_NMUESTRA'];?>" 
                                                onclick         =   "mic_terminar(this.id)"
                                                >
                                                <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                            </button>
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
                                    <div class="grid_opcion_descripcion_muestra3" id="vista_x_muestra_<?php echo $row['ID_NMUESTRA'];?>"> 
                                        <?php   if ($row['ID_IMAGEN'] == ''){?> 
                                            <div class="card" style="margin-bottom:0px" id="card_img_<?php echo $row['ID_NMUESTRA'];?>">
                                                <div style="padding: 10px;">
                                                    <div style="background-color: transparent !important; text-align: center">
                                                        <div class="font_15 grupo_macro_img_citologia"><b>SUBIR</b></div>
                                                    </div>
                                                    <hr style="margin-top:10px;margin-bottom:10px">
                                                    <div class="text-center">
                                                        <div class="custom-file" style="cursor:pointer;">
                                                            <label for="img_macro_a_<?php echo $row['ID_NMUESTRA'];?>">
                                                                <i class="fa fa-file-image-o fa-4x grupo_macro_img_citologia" aria-hidden="true" style=" width:100px;"></i>
                                                            </label>
                                                            <input type         =   "file"
                                                                   data-config  =   "<?php echo htmlspecialchars(json_encode([
                                                                                                                        'return_div'    =>  'card_img_'.$row['ID_NMUESTRA'],
                                                                                                                        'return_div2'   =>  'vista_x_muestra_'.$row['ID_NMUESTRA'],
                                                                                                                        'txt_zona'      =>  'salamacroscopia',
                                                                                                                        'ind_zona'      =>  '1',
                                                                                                                        'tipo_muestra'  =>  'anatomica',
                                                                                                                        'id_anatomia'   =>  $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"],
                                                                                                                        'id_muestra'    =>  $row['ID_NMUESTRA'],
                                                                                                                        'id_casete'     =>  null,
                                                                                                                    ]),ENT_QUOTES,'UTF-8');?>"

                                                                   id           =   "img_macro_a_<?php echo $row['ID_NMUESTRA'];?>" 
                                                                   name         =   "img_macro_a_<?php echo $row['ID_NMUESTRA'];?>" 
                                                                   onchange     =   "js_adjunto_ap_multiple(this.id,this.files);"
                                                                   accept       =   "image/png,image/jpeg">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php   }   else    {   ?>
                                            <div class="card" style="margin-bottom:0px;text-align:-webkit-center;padding:6px;" >
                                                <img 
                                                    class                   =   "img-thumbnail"
                                                    id                      =   "img_macro_<?php echo $row['ID_IMAGEN'];?>"
                                                    data-src                =   "<?php echo $row["NAME_IMG"];?>" 
                                                    alt                     =   "64x64" 
                                                    src                     =   "<?php echo $row["IMG_DATA"];?>" 
                                                    data-holder-rendered    =   "true" 
                                                    style                   =   "width:64px;height:64px;"
                                                >
                                                <hr style="margin:2px">
                                                <a href="javascript:delete_img_x_muestra(<?php echo $row['ID_IMAGEN'];?>,<?php echo $row['ID_NMUESTRA'];?>,<?php echo $data_bd[":P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>)">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                <a href="javascript:down_img_x_muestra(<?php echo $row['ID_IMAGEN'];?>)">
                                                    <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        <?php   }   ?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                        </ul>
                    <?php } else { ?>
                    <ul class="list-group" id="ul_muestras" style="margin-bottom:0px;">
                        <a href="#" class="list-group-item list-group-item-action">
                            <b>SIN MUESTRAS CARGADAS</b>
                        </a>
                    </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var firstTabEl = document.querySelector('#tabs_muestras_macroscopica .nav-link');
        var firstTab = new bootstrap.Tab(firstTabEl);
        firstTab.show();
        //$('.tabs_muestras_macroscopia a[href="#_anatomia_citologia"]').tab('show');
    });
</script>