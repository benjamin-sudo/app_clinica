<style>
    ._CENTER_1                      {
        display                     :   grid;
        justify-content             :   center;
        align-items                 :   center;
    }
    .css_subgestion_eliminada           {
        display                         :   grid;
        grid-template-columns           :   1fr 1fr 10px;
        align-items                     :   center;
        margin-top                      :   8px;
        column-gap                      :   10px;
    }
    .css_informacion_log                {
        display                         :   grid;
        grid-template-columns           :   1fr 1fr 1fr;
        align-items                     :   center;
        margin-top                      :   8px;
        column-gap                      :   10px;
    }
    .CSS_GRID_HISTORIAL_ALL             {
        display                         :   grid;
        grid-template-columns           :   1fr 2fr;
        grid-row-gap                    :   5px;
        column-gap                      :   5px;
        padding                         :   5px;
    }
    .grid_popover_log                   {
        max-height                      :   150px !important;
        max-width                       :   600px !important;
        min-height                      :   150px;
        border                          :   solid 1px black;
        margin                          :   auto;
        display                         :   flex;
        flex-wrap                       :   wrap;
        justify-contend                 :   center;
    }
    .popover                            {
        z-index                         :   3000;
    }
    .popover-content                    {
        height                          :   350px;
        overflow-y                      :   auto;
    }
    .panel_a_log                        {
        display                         :   grid;
        grid-template-columns           :   repeat(2,1fr);
        align-items                     :   center;
        padding                         :   6px;
    }
    .grid_css_muestra_log               {
        display                         :   grid;
        grid-template-columns           :   30px 1fr 2fr 30px;
    }
    .card_local                         {
        border-radius                   :   4px;
        box-shadow                      :   0 1px 2px rgb(0 0 0 / 5%), 0 0 0 1px rgb(63 63 68 / 10%);
        background-color                :   #FFFFFF;
    }
    .flex                               {
        display                         :   flex;
        align-items                     :   stretch;
        align-content                   :   center;
        flex-wrap                       :   wrap;
    }
    .grid_center                        {
        display                         :   grid;
        justify-items                   :   center;
        align-items                     :   center;
    }
    .CSS_GRID_HEAD_MUESTRA              {
        display                         :   grid;
        grid-template-columns           :   repeat(4,1fr);
        grid-column-gap                 :   5px;
        grid-row-gap                    :   6px;
        justify-items                   :   stretch;
        margin-bottom                   :   5px;
        grid-auto-rows                  :   90px;
        grid-template-areas             :   "mod1 mod1 mod1 mod2" ;
    }
    /* "mod3 mod4 mod4 mod4"*/ 
    .CSS_GRID_HEAD_MUESTRA1             {   grid-area : mod1; }
    .CSS_GRID_HEAD_MUESTRA2             {   grid-area : mod2; }
    .CSS_GRID_HEAD_MUESTRA3             {   grid-area : mod3; }
    .CSS_GRID_HEAD_MUESTRA4             {   grid-area : mod4; }
    .grid_item_center                   {
        display                         :   grid;
        grid-template-columns           :   repeat(4,1fr);
        grid-gap                        :   10px;
        grid-auto-rows                  :   40px;
        grid-template-areas             :   " . a a . "
                                            " . a a . ";
    }
    .item_center                        {
        grid-area                       :   a;
        align-self                      :   center;
        justify-self                    :   center;
    }
    .grid_table_anatomia                {
        display                         :   grid;
        grid-template-columns           :   repeat(4, 1fr);
        grid-gap                        :   1px;
        overflow                        :   hidden;
        justify-items                   :   stretch;
        grid-template-areas             :   
                                            "nombre         nombre          nombre          rut"  
                                            "tipo_anatomia  tipo_anatomia   tipo_anatomia   tipo_anatomia"  
                                            "informacion1   informacion1    informacion1    informacion1";
    }
    
    .nombre                             {   grid-area   :   nombre;         }
    .rut                                {   grid-area   :   rut;            }
    .tipo_anatomia                      {   grid-area   :   tipo_anatomia;  }
    .informacion1                       {   grid-area   :   informacion1;   }
    .grid_cell                          {   position    :   relative;       }
    
    .grid_cell::before                  {
        content                         :   '';
        position                        :   absolute;
        top                             :   -1px;
        right                           :   -1px;
        bottom                          :   -1px;
        left                            :   -1px;
        background-color                :   #ddd;
    }
    
    .cell_content                       {
        position                        :   relative;
        background-color                :   #FFFFFF;
        padding                         :   6px;
    }
    
    .grid_views_casete                  {
        display                         :   grid;
        grid-template-columns           :   repeat(3,1fr);
        justify-items                   :   start;
        align-items                     :   center;
    }

    .grid_numero_interno                {
        display                         :   grid;
        grid-template-columns           :   auto 30px 1fr 10px;
        align-items                     :   center;
        justify-items                   :   flex-start;
        margin-top: 25px;
    }

</style>

    <div class="CSS_GRID_HEAD_MUESTRA">
        <div class="card_local CSS_GRID_HEAD_MUESTRA1">
            <div class="card grid_table_anatomia">
                <div class="grid_cell nombre">
                    <div class="cell_content"><b style="color:#888888;"><?php echo $DATA['TXTNOMCIRUSMALL'];?></b></div>
                </div>
                <div class="grid_cell rut">
                    <div class="cell_content"><b style="color:#888888;"><?php echo $DATA['RUTPACIENTE'];?></b></div>
                </div>
                <div class="grid_cell tipo_anatomia">
                    <div class="cell_content"><b style="color:#888888;"><?php echo $DATA['TIPO_DE_BIOPSIA'];?><?php echo $DATA['IND_USOCASSETTE']==1?'&nbsp;|&nbsp;USO CASETE':'';?></b></div>
                </div>
                <div class="grid_cell informacion1">
                    <div class="cell_content"><b style="color:#888888;"><?php echo $DATA["TXT_HISTO_ESTADO"]."&nbsp;(".$DATA["ID_HISTO_ESTADO"].")";?></b></div>
                </div>
            </div>
        </div>

        <div class="card_local CSS_GRID_HEAD_MUESTRA2">
            
            <div class="grid_item_center">
                <div class="item_center">
                    <div class="btn-group-vertical ">
                        <button 
                            type                    =   "button" 
                            class                   =   "btn btn-success btn-fill" 
                            id                      =   "BTN_INFO_HISPATOLOGICO_<?php echo $DATA["ID_SOLICITUD"];?>" 
                            name                    =   "BTN_INFO_HISPATOLOGICO"
                            onclick                 =   "js_viwes_popover(this.id,this.name)"
                            data-toggle             =   "popover" 
                            data-placement          =   "right" 
                            data-html               =   "true"
                            data-content            =   "<table width='100%' class='table table-striped table-sm' style='margin-bottom:7px;margin-top:-5px;'> 
                                                            <tbody id='tabla_biopsia'>
                                                                <tr>
                                                                    <td colspan='2' style='height:40px;'><b>SITIO DE EXTRACCI&Oacute;N</b></td>
                                                                    <td colspan='2'><?php echo $DATA['DES_SITIOEXT'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan='2' style='height:40px;'><b>UBICACI&Oacute;N</b></td>
                                                                    <td colspan='2'><?php echo $DATA['DES_UBICACION'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan='2' style='height:40px;'><b>TAMA&Ntilde;O</b></td>
                                                                    <td colspan='2'><?php echo $DATA['DES_TAMANNO'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width='25%' style='height: 40px;'><b>TIPO DE LESI&Oacute;N</b></td>
                                                                    <td width='25%'><?php echo $DATA['TXT_TIPOSESION'];?></td>
                                                                    <td width='25%'><b>ASPECTO:</b></td>
                                                                    <td width='25%'><?php echo $DATA['TXT_ASPECTO'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='height:40px;'><b>ANT. PREVIOS</b></td>
                                                                    <td><?php echo $DATA['TXT_ANT_PREVIOS'];?></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='height:40px;'><b>DESC. BIOPSIA:</b></td> 
                                                                    <td colspan='3'><?php echo $DATA['DES_BIPSIA'];?></td> 
                                                                </tr> 
                                                                <tr> 
                                                                    <td style='height:40px;' colspan='1'><b>DESC. CITOLOG&Iacute;A:</b></td> 
                                                                    <td colspan='3'><?php echo $DATA['DES_CITOLOGIA'];?></td> 
                                                                </tr> 
                                                                <tr>
                                                                    <td style='height:40px;'><b>OBSERVACIONES:</b></td>
                                                                    <td colspan='3'><?php echo $DATA['DES_OBSERVACIONES'];?></td>
                                                                </tr>
                                                        </table>"
                            >
                        <i class="fa fa-info" aria-hidden="true"></i>
                        </button>
                        <button 
                                type                    =   "button" 
                                class                   =   "btn btn-primary btn-fill" 
                                id                      =   "BTN_INFO_LOGS_<?php echo $DATA["ID_SOLICITUD"];?>"  
                                name                    =   "BTN_INFO_LOGS"
                                onclick                 =   "js_viwes_popover(this.id,this.name)"
                                data-toggle             =   "popover" 
                                data-placement          =   "left"
                                data-content            =   "<?php echo htmlspecialchars($HTML_LOGS);?>"
                                data-html               =   "true"
                            >
                            <i class="fa fa-database" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <br>

    <?php if($FASE == 2) {  ?>
        <input type="hidden" id="V_IND_TIPO_BIOPSIA" name="V_IND_TIPO_BIOPSIA"  value="<?php echo $DATA['IND_TIPO_BIOPSIA'];?>"/>
        <div class="grid_numero_interno">
            <div class="grid_numero_interno1">
                <fieldset class="fieldset_local" style="padding: 10px 10px 0px 10px;">
                    <h5 style="color:#888888;">
                        <?php if ($DATA['IND_TIPO_BIOPSIA'] == 2 || $DATA['IND_TIPO_BIOPSIA'] == 3 || $DATA['IND_TIPO_BIOPSIA'] == 4){ ?>
                            &nbsp;N&deg; DE BIOPSIA
                        <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 5 ){?>
                            &nbsp;N&deg; CITOLOG&Iacute;A
                        <?php } else if ($DATA['IND_TIPO_BIOPSIA'] == 6 ){?>
                            &nbsp;N&deg; PAP
                        <?php } ?>
                    </h5>
                    <div class="input-group mb-3"  id="date_tabla2">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" id="num_interno" name="num_interno"  value="">
                    </div>
                </fieldset>
            </div>
            <div class="grid_numero_interno2">&nbsp;
                <input type="hidden" id="ind_tipo_biopsia" name="ind_tipo_biopsia" value="<?php echo $DATA['IND_TIPO_BIOPSIA'];?>"/>
            </div>
            <div class="grid_numero_interno3">
                <button type="button" class="btn btn-info btn-fill" id="btn_last_number_diponible" onclick="busqueda_numero_disponible(<?php echo $DATA['IND_TIPO_BIOPSIA'];?>)">
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
            <div class="grid_numero_interno4">
                &nbsp;
            </div>
        </div>

        <?php if ($DATA['IND_TIPO_BIOPSIA'] == 4) { ?>
            <div class="grid_numero_interno">
                <div class="grid_numero_interno1">
                    <fieldset class="fieldset_local" style="padding: 10px 10px 0px 10px;">
                        <h5 style="color:#888888;">&nbsp;N&deg; CITOLOG&Iacute;A</h5>
                        <div class="input-group mb-3"  id="date_tabla2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" id="num_interno_cito" name="num_interno_cito"  value="">
                        </div>
                    </fieldset>
                </div>
                <div class="grid_numero_interno2">&nbsp;
                    <input type="hidden" id="ind_tipo_biopsia" name="ind_tipo_biopsia" value="<?php echo $DATA['IND_TIPO_BIOPSIA'];?>"/>
                </div>
                <div class="grid_numero_interno3">
                    <button type="button" class="btn btn-info btn-fill" id="btn_last_number_diponible" onclick="busqueda_numero_disponible_citologia(<?php echo $DATA['IND_TIPO_BIOPSIA'];?>)">
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;ULTIMO N&deg; CITOLOGICO 
                    </button>
                </div>
                <div class="grid_numero_interno4">
                    &nbsp;
                </div>
            </div>
        <?php } else { ?>
            <input type="hidden" class="form-control input-sm" id="num_interno_cito" name="num_interno_cito"  value=""/>
        <?php }  ?>
    <?php   }   ?>
   
    <br>
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
                        $IND_USOCASSETTE        =   $DATA['IND_USOCASSETTE'];
                        if($IND_USOCASSETTE     == 1){
                            //ordenando x casete
                            foreach($ARR_CASETE_ORD  as $y => $data_casete){
                                $li_muestras        =   '';
                                $grid_array         =   [];
                                $aux                =   1;
                                foreach($data_casete as $z => $row){ 
                                    $li_muestras    .=  $aux.".-".$row['TXT_MUESTRA']."";
                                    //array_push($grid_array,$aux.".-".$row['TXT_MUESTRA']);
                                    array_push($grid_array,'<div class="grid_cell2" style="color:#888888;"><b>'.$aux.'.-'.$row['TXT_MUESTRA'].'</b></div>');
                                    $aux++;
                                }
                                ?>
                                <li class="list-group-item sin_padding lista_anatomia grupo_<?php echo $DATA["ID_SOLICITUD"];?>" id="<?php echo "C".$data_casete[0]['ID_CASETE'];?>" data-id_muestra="<?php echo $data_casete[0]['ID_CASETE'];?>" data-CASETE="1" data-id_solicitud="<?php echo $DATA["ID_SOLICITUD"];?>" data-NUM_TABS="<?php echo $row['ID_CASETE'];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                    <div class="CSS_GRID_MUESTRA_CASETE">
                                        <div class="CSS_GRID_MUESTRA_CASETE_1">
                                             <?php echo $y;?>
                                        </div>
                                        <div class="CSS_GRID_MUESTRA_CASETE_3">
                                            <a role="button" style="padding: 0px" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $data_casete[0]['ID_CASETE'];?>" aria-expanded="true" aria-controls="collapseOne<?php echo $data_casete[0]['ID_CASETE'];?>" class="li_acordion_mtuestras">
                                                <div class="grid_views_casete">
                                                    <?php echo implode("",$grid_array);?>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="CSS_GRID_MUESTRA_CASETE_4" style="text-align: end;">
                                            <b style="color:#888888;"><?php echo "N&deg;".$row['NUM_CASSETTE'];?>&nbsp;|&nbsp;<?php echo "C".$data_casete[0]['ID_CASETE'];?></b>
                                        </div>
                                        <div class="CSS_GRID_MUESTRA_CASETE_6 _CENTER_1">
                                            <input 
                                                type        =   "checkbox" 
                                                class       =   "form-check-input checkbox_<?php echo $row['ID_NMUESTRA'];?>" 
                                                id          =   "CHEK_<?php echo 'C'.$data_casete[0]['ID_CASETE'];?>" 
                                                style       =   "display:block;cursor:pointer;margin:0px" 
                                                onchange    =   "js_muestra_indivual('C<?php echo $data_casete[0]['ID_CASETE'];?>');"
                                                value       =   "<?php echo $data_casete[0]['ID_CASETE'];?>"
                                            />
                                        </div>
                                        <div  class="CSS_GRID_MUESTRA_CASETE_5" id="btn_<?php echo "C".$data_casete[0]['ID_CASETE'];?>">
                                            <span class="label label-danger">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div id="collapseOne<?php echo $data_casete[0]['ID_CASETE'];?>" class="panel-collapse collapse padding_collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $data_casete[0]['ID_CASETE'];?>">
                                        <div class="css_subgestion_eliminada">
                                            <div class="css_subgestion_eliminada1">
                                                <b style="color:#888888;">EVENTO ADVERSOS:</b><br>
                                                <select class="form-control input-sm" id="SEL_MOTIVO_<?php echo $data_casete[0]['ID_CASETE'];?>" name="SEL_MOTIVO_<?php echo $data_casete[0]['ID_CASETE'];?>">
                                                    <option value="">Seleccione...</option>
                                                    <option value="1">MUESTRA NO ENCONTRADA</option>
                                                    <option value="2">MUESTRA EN MAL ESTADO</option>
                                                    <option value="3">MUESTRA RECHAZADA</option>
                                                </select>
                                            </div>
                                            <div class="css_subgestion_eliminada2">
                                                <b style="color:#888888;">OBSERVACI&Oacute;N:</b><br>
                                                <input type="text" class="form-control input-sm" id="txt_observacion_<?php echo $data_casete[0]['ID_CASETE'];?>" name="txt_observacion_<?php echo $data_casete[0]['ID_CASETE'];?>" value="">
                                            </div>
                                            <div class="css_subgestion_eliminada3">&nbsp;</div>
                                        </div>
                                    </div>
                                    
                                </li>
                                <?php    
                            }
                        } else {
                            foreach($P_ANATOMIA_PATOLOGICA_MUESTRAS as $i => $row){
                                ?>    
                                    <li class="list-group-item lista_anatomia grupo_<?php echo $DATA["ID_SOLICITUD"];?>" id="<?php echo "A".$row['ID_NMUESTRA'];?>" data-CASETE="0" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>" data-id_solicitud="<?php echo $DATA["ID_SOLICITUD"];?>" data-NUM_TABS="<?php echo $DATA["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                        <div class="CSS_GRID_MUESTRA">
                                            <div class="CSS_GRID_MUESTRA_1"><?php echo $i+1;?></div>
                                            <div class="CSS_GRID_MUESTRA_2 panel-heading"  role="tab" id="headingOne<?php echo $row['ID_NMUESTRA'];?>">
                                                <a role="button" style="padding: 0px" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $row['ID_NMUESTRA'];?>" aria-expanded="true" aria-controls="collapseOne<?php echo $row['ID_NMUESTRA'];?>" class="li_acordion_mtuestras">
                                                    <i><?php echo $row['TXT_MUESTRA']?></i>
                                                </a>
                                            </div>
                                            <div class="CSS_GRID_MUESTRA_4" style="text-align: end"><b><?php echo $row['TXT_ETIQUETA'];?>&nbsp;|&nbsp;<?php echo "A".$row['ID_NMUESTRA'];?></b></div>
                                            <div class="CSS_GRID_MUESTRA_6 _CENTER_1">
                                                <input 
                                                    type        =   "checkbox" 
                                                    class       =   "form-check-input checkbox_<?php echo $DATA["ID_SOLICITUD"];?>" 
                                                    id          =   "CHEK_<?php echo 'A'.$row['ID_NMUESTRA'];?>" 
                                                    style       =   "display:block;cursor:pointer;margin:0px" 
                                                    onchange    =   "js_muestra_indivual('A<?php echo $row['ID_NMUESTRA'];?>');"
                                                    value       =   "<?php echo $row['ID_NMUESTRA'];?>"
                                                >
                                            </div>
                                            <div class="CSS_GRID_MUESTRA_5" id="btn_<?php echo "A".$row['ID_NMUESTRA']; ?>">
                                                <span class="label label-danger">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div id="collapseOne<?php echo $row['ID_NMUESTRA'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $row['ID_NMUESTRA'];?>">
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
    <?php   }   ?>
    
    <?php   if(count($P_AP_MUESTRAS_CITOLOGIA)>0){  ?>

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
                        <div class="GRID_HEARD_CHECK_MUESTRA3">
                            &nbsp;  
                        </div>
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
                                        <?php echo $row['TXT_MUESTRA'];?>&nbsp;|&nbsp;<?php echo $row['NUM_ML'];?>&nbsp;mL
                                    </a>
                                </div>
                                <div class="CSS_GRID_MUESTRA_4" style="text-align: end;">
                                    <b><?php echo $row['TXT_ETIQUETA'];?></b>&nbsp;|&nbsp;<b><?php echo "A".$row['ID_NMUESTRA'];?></b>
                                </div>
                                <div class="CSS_GRID_MUESTRA_6 _CENTER_1">
                                    <input 
                                        type        =   "checkbox" 
                                        class       =   "form-check-input checkbox_<?php echo $DATA["ID_SOLICITUD"];?>" 
                                        id          =   "CHEK_<?php echo 'A'.$row['ID_NMUESTRA'];?>" 
                                        style       =   "display:block;cursor:pointer;margin:0px" 
                                        onchange    =   "js_muestra_indivual('A<?php echo $row['ID_NMUESTRA'];?>');"
                                        value       =   "<?php echo $row['ID_NMUESTRA'];?>"
                                    >
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
                            <p><label for="size_2">ESPERANDO A RECEPCION DE SOLICITUD</label></p>
                        <?php  } ?>
                        <script> 
                            $("#BTN_INFO_HISPATOLOGICO_<?php echo $DATA["ID_SOLICITUD"];?>").hide();
                            $(".checkbox_<?php echo $DATA["ID_SOLICITUD"];?>").hide();
                        </script>
                <?php  }  ?>
            <?php
            break;
        case 2:
            ?>
                <style>
                    .css_option_recepcion           {
                        display                     :   grid;
                        grid-template-columns       :   2fr 1fr 1fr 2fr;
                        align-items                 :   center;
                        justify-content             :   center;
                        column-gap                  :   6px;
                        padding                     :   8px;
                    }

                    .css_panel_rechazo              {
                        display                     :   grid;
                        grid-template-columns       :   4fr 1fr;
                        align-items                 :   center;
                        justify-content             :   center;
                        column-gap                  :   6px;
                        padding                     :   8px;
                   }
                </style>
                
                <?php if ($DATA["ID_HISTO_ESTADO"] == 4 && $DATA['IND_ESTADO_MUESTRAS']==1) { ?>
                        <p><label for="size_2">SOLICITUD YA RECEPCIONADA | <?php echo $DATA["IND_ESTADO_MUESTRAS"];?> </label></p>
                        <script>$(".checkbox_<?php echo $DATA["ID_SOLICITUD"];?>").hide();</script>
                <?php } else { ?>
                        <div class="css_option_recepcion">
                            <div class="css_option_recepcion1" style="text-align: end;">
                                <i class="fa fa-check" aria-hidden="true" style="cursor:pointer;color:#87CB16;"></i>&nbsp;<label for="ind_recepciona" style="cursor:pointer;color:#87CB16;">RECEPCI&Oacute;N</label>
                            </div>
                            <div class="css_option_recepcion2">
                                <input type="radio"  name="fav_language" id="ind_recepciona" style="display:block;cursor:pointer;margin: 0px 0px 5px 0px;" checked onclick="js_vista_opcion(this.id)" value="1" >
                            </div>
                            <div class="css_option_recepcion3" style="text-align: end;">
                                <label for="ind_rechazo" style="cursor:pointer;color:#d9534f;">&nbsp;<i class="fa fa-times" aria-hidden="true"></i>RECHAZO</label>
                            </div>
                            <div class="css_option_recepcion3">
                                <input type="radio" name="fav_language" id="ind_rechazo" style="display:block;cursor:pointer;margin: 0px 0px 5px 0px;" onclick="js_vista_opcion(this.id)" value="1">
                            </div>
                        </div>
                        <div class="css_grid_password_recepcion">
                            <div class="css_grid_password_recepcion1">
                                <fieldset class="fieldset_local" style="padding: 10px 10px 0px 10px;">
                                    <h5 style="color:#888888;">FIRMA UNICA TRASPORTE</h5>
                                    <div class="input-group mb-3"  id="date_tabla2">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" placeholder="Firma Quien Trasporta" aria-label="Username" aria-describedby="basic-addon1" id="firma_simple_trasporte" name="firma_simple_trasporte"  value="">
                                    </div>
                                </fieldset>
                            </div>
                            <div class="css_grid_password_recepcion4">
                                
                            
                            
                                <button class="btn BTN-XS btn-success" onclick="js_validafirma('firma_simple_trasporte')">
                                    <i class="fa fa-id-card-o" aria-hidden="true"></i> VERIFICACION
                                </button>




                            </div>
                            <div class="css_grid_password_recepcion2">
                                <fieldset class="fieldset_local" style="padding: 10px 10px 0px 10px;">
                                    <h5 style="color:#888888;">FIRMA UNICA RECEPCI&Oacute;N</h5>
                                    <div class="input-group mb-3"  id="date_tabla2">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" placeholder="Firma quien recepciona" aria-label="Username" aria-describedby="basic-addon1" id="firma_simple_recepcion" name="firma_simple_recepcion"  value="">
                                    </div>
                                </fieldset>
                            </div>
                            <div class="css_grid_password_recepcion3">
                                <div class="btn-group">
                                    <button class="btn btn-fill btn-success all_solicitudes_recepcion toolpit_local" onclick="confirma_recepcion(<?php echo $DATA["ID_SOLICITUD"];?>)">
                                        <i class="fa fa-check" aria-hidden="true"></i><span class="toolpit_local_txt"><i class="fa fa-question-circle-o" aria-hidden="true"></i>&nbsp;Confirma recepci&oacute;n de muestras</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- OTRA OPT -->
                        <div class="css_panel_rechazo" style="display:none">
                            <div class="css_panel_rechazo1">
                                <fieldset class="fieldset_local">
                                    <legend class="legend" style="margin-left:8px;">OBSERVACI&Oacute;N GENERAL</legend>
                                    <div id="date_tabla2" class="input-group center-block" style="width:410px;padding:6px;">
                                        <span class="input-group-addon"><span class="fa fa-comment-o"></span></span>
                                        <input type="text" class="form-control input-sm" id="txt_observacion_rechazo" name="txt_observacion_rechazo" value="">
                                    </div>
                                </fieldset> 
                            </div>
                            <div class="css_panel_rechazo3" style="text-align:center;">
                                <button class="btn btn-xs btn-fill btn-danger all_solicitudes_recepcion toolpit_local" onclick="js_confirma_rechazo_recepcion(<?php echo $DATA["ID_SOLICITUD"];?>)">
                                    <i class="fa fa-times" aria-hidden="true"></i><span class="toolpit_local_txt"><i class="fa fa-question-circle-o" aria-hidden="true"></i>&nbsp;Confirma rechazo de muestras</span>
                                </button>
                            </div>
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
            echo    "<b>EN TRASPORTE A 1)RECEPCI&Oacute;N</b>";
            break;
        default:
            echo    "<b>NO SE HA IDENTIFICADO</b>";
            break;    
    }
    ?>