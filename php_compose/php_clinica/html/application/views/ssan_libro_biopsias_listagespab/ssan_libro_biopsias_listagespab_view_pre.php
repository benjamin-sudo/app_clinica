    <?php
        $logs                       =   [];
        $log_adverso                =   [];
        $html_li_logs               =   '';
        if(count($DATA['P_AP_INFORMACION_ADICIONAL'])>0){ 
            $log_adverso            =   [];
            if(count($DATA['P_INFO_LOG_ADVERSOS'])>0){
                foreach($DATA['P_INFO_LOG_ADVERSOS'] as $i => $log_adv){ 
                    $log_adverso[$log_adv['ID_NUM_CARGA'].'_'.$log_adv['ID_NMUESTRA']] = $log_adv;
                }
            }
            foreach($DATA['P_AP_INFORMACION_ADICIONAL'] as $i => $row){
                $id_logs            =   $row['ID_NUM_CARGA'].'_'.$row['TXT_BACODE'];
                $log_adv            =   array_key_exists($id_logs,$log_adverso)?$log_adverso[$id_logs]:[];
                $logs[$row['ID_NUM_CARGA']][$row['TXT_BACODE']]   =   array('LOGS'=>$row,'LOG_ADVERSOS'=>$log_adv);
            }
            $html_li_logs           .=   '<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">';
            $html_li_logs           .=   '<ul class="list-group" id="ul_log_'.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"].'" style="margin-bottom:0px;">';
            foreach($logs as $id_log => $r_log){
                $html_table             =   "<table width='100%' class='table table-striped table-sm' style='margin-bottom:-11px;margin-top:-12px;margin-left:-5px;margin-right:-12px;'>";
                foreach($r_log as $y => $_r_log){                     
                    $aux                =   $y+1;
                    $txt                =   $_r_log["LOGS"]["TXT_MUESTRA"];
                    $txt_estado_adv     =   '';
                    if(count($_r_log["LOG_ADVERSOS"])>0){
                        $txt_estado_adv.='<ul style="padding-left: 2px;">';
                        //foreach ($_r_log["LOG_ADVERSOS"] as $f => $log_adv_row){
                            $txt_estado_adv     .='<li>'.$_r_log["LOG_ADVERSOS"]["DESCRIPCION"].' | '.$_r_log["LOG_ADVERSOS"]["TXT_EVENTO_OBSERVACION"].'</li>';
                        //}
                        $txt_estado_adv         .='</ul>';
                    } else {
                        $txt_estado_adv         =   'ok';
                    }
                    $html_table      .=   "
                                            <tr>
                                                <td width='10%' style='height:40px'>$aux</td>
                                                <td width='45%'>$txt</td>
                                                <td width='40%'>$txt_estado_adv</td>
                                            </tr>
                                        ";
                }
                $html_table      .=   "</table>";
                //$momento            =   moment().endOf('day').fromNow();
                $html_li_logs       .=  '
                                            <li class="list-group-item"> 
                                                <a role="button" style="padding:0px" data-toggle="collapse" data-parent="#accordion2" aria-controls="collapse_log_'.$id_log.'" href="#collapse_log_'.$id_log.'" aria-expanded="true"  class="li_acordion_logs">
                                                    LOG -> '.$_r_log["LOGS"]["TXT_FASE"].' | '.$_r_log["LOGS"]["FECHA_CREACION_LOG"].'
                                                </a>
                                            </li>
                                            <div id="collapse_log_'.$id_log.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne'.$id_log.'">
                                                <div class="CSS_GRID_HISTORIAL_ALL">
                                                    <div class="CSS_GRID_HISTORIAL1">
                                                        <div class="card" style="margin-bottom:0px;">
                                                            <div class="content">
                                                                <div>
                                                                    <div class="font_15"><b>INFORMACI&Oacute;N</b></div>
                                                                </div>
                                                                <hr style="margin-top:10px;margin-bottom:10px">
                                                                <div>
                                                                    '.$_r_log["LOGS"]["TXT_EDITA"].'<br>
                                                                    '.$_r_log["LOGS"]["TXT_USER"].'<br>
                                                                    '.$_r_log["LOGS"]["FECHA_CREACION_LOG"].'
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="CSS_GRID_HISTORIAL2">
                                                        <div class="card" style="margin-bottom:0px;">
                                                            <div class="content">
                                                                <div>
                                                                    <div class="font_15"><b>MUESTRAS</b></div>
                                                                </div>
                                                                <hr style="margin-top:10px;margin-bottom:10px">
                                                                <div>
                                                                    '.htmlspecialchars($html_table,ENT_QUOTES,'UTF-8').'
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                
                                            </div>    
                                        ';
            }
            $html_li_logs           .=   '</ul>';
            $html_li_logs           .=   '</div>';
        } else {
            $html_li_logs           =   '<b>SIN INFORMACI&Oacute;N</b>';
        }
    ?>

    <div id="data_bd_form" 
        data-bd                         =   "<?php echo htmlspecialchars(json_encode($DATA),ENT_QUOTES,'UTF-8');?>" 
        data-log                        =   "<?php echo htmlspecialchars(json_encode($logs),ENT_QUOTES,'UTF-8');?>"
        data-log_adv                    =   "<?php echo htmlspecialchars(json_encode($log_adverso),ENT_QUOTES,'UTF-8');?>"
    ></div>

    <style>
        ._CENTER_1                      {
            display                     :   grid;
            justify-content             :   center;
            align-items                 :   center;
        }
        
        .css_subgestion_eliminada       {
            display                     :   grid;
            grid-template-columns       :   1fr 1fr 10px;
            align-items                 :   center;
            margin-top                  :   8px;
            column-gap                  :   10px;
        }
        
        .css_informacion_log            {
            display                     :   grid;
            grid-template-columns       :   1fr 1fr 1fr;
            align-items                 :   center;
            margin-top                  :   8px;
            column-gap                  :   10px;
        }
        
        .CSS_GRID_HISTORIAL_ALL             {
            display                     :   grid;
            grid-template-columns       :   1fr 2fr;
            grid-row-gap                :   5px;
            column-gap                  :   5px;
            padding                     :   5px;
        }

        .grid_popover_log               {
            max-height                  :   150px !important;
            max-width                   :   600px !important;
            min-height                  :   150px;
            border                      :   solid 1px black;
            margin                      :   auto;
            display                     :   flex;
            flex-wrap                   :   wrap;
            justify-contend             :   center;
        }
        
        .popover                        {
            z-index                     :   3000;
        }
        
        .popover-content {
            height                      :   350px;
            overflow-y                  :   auto;
        }
    </style>
    
    <div class="grid_popover_log" style="display: none">
        <div class="grid_popover_log1"></div>
    </div>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            //console.log("-------------------------------------------------------");
            console.log("data_bd_form   ->",$("#data_bd_form").data(),"         ");
            //console.log("moment ->",moment().endOf('day').fromNow());
            //console.log("-------------------------------------------------------");
            //js_vista_log(<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>);
        });
    </script>
   
    <div class="CSS_GRID_HEAD_MUESTRA">
        
        <div class="CSS_GRID_HEAD_MUESTRA1 _CENTER">
            <div class="card" style="margin-bottom: 0px;">
                <div class="content">
                    <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TIPO_DE_BIOPSIA'];?> 
                    <hr style="margin:0px 0px 0px 0px;">
                    USO CASETE : <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_USOCASSETTE']==1?'SI':'NO';?>
                    <hr style="margin:0px 0px 0px 0px;">
                    ESTADO : <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["TXT_HISTO_ESTADO"]."&nbsp;(".$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_HISTO_ESTADO"].")";?> 
                    | ID:<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>
                </div>
            </div>
        </div>
        
        <div class="CSS_GRID_HEAD_MUESTRA2 _CENTER">
            <fieldset class="fieldset_local">
                <legend class="legend">INFORMACI&Oacute;N&nbsp;&nbsp;&nbsp;</legend>
                <div class="btn-group" style="padding:6px;">
                    <button 
                            type                    =   "button" 
                            class                   =   "btn btn-success btn-fill" 
                            id                      =   "BTN_INFO_HISPATOLOGICO_<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>" 
                            name                    =   "BTN_INFO_HISPATOLOGICO"
                            onclick                 =   "js_viwes_popover(this.id,this.name)"
                            data-toggle             =   "popover" 
                            data-placement          =   "bottom" 
                            data-html               =   "true"
                            data-content            =   "<table width='100%' class='table table-striped table-sm' style='margin-bottom:7px;margin-top:-5px;'> 
                                                            <tbody id='tabla_biopsia'>
                                                                <tr>
                                                                    <td colspan='2' style='height:40px;'><b>SITIO DE EXTRACCI&Oacute;N</b></td>
                                                                    <td colspan='2'><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_SITIOEXT'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan='2' style='height:40px;'><b>UBICACI&Oacute;N</b></td>
                                                                    <td colspan='2'><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_UBICACION'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan='2' style='height:40px;'><b>TAMA&Ntilde;O</b></td>
                                                                    <td colspan='2'><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_TAMANNO'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width='25%' style='height: 40px;'><b>TIPO DE LESI&Oacute;N</b></td>
                                                                    <td width='25%'><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_TIPOSESION'];?></td>
                                                                    <td width='25%'><b>ASPECTO:</b></td>
                                                                    <td width='25%'><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_ASPECTO'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='height:40px;'><b>ANT. PREVIOS</b></td>
                                                                    <td><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_ANT_PREVIOS'];?></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='height:40px;'><b>DESC. BIOPSIA:</b></td> 
                                                                    <td colspan='3'><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_BIPSIA'];?></td> 
                                                                </tr> 
                                                                <tr> 
                                                                    <td style='height:40px;' colspan='1'><b>DESC. CITOLOG&Iacute;A:</b></td> 
                                                                    <td colspan='3'><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_CITOLOGIA'];?></td> 
                                                                </tr> 
                                                                <tr>
                                                                    <td style='height:40px;'><b>OBSERVACIONES:</b></td>
                                                                    <td colspan='3'><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_OBSERVACIONES'];?></td>
                                                                </tr>
                                                        </table>"
                            >
                        <i class="fa fa-info" aria-hidden="true"></i>
                    </button>
                    <button 
                            type                    =   "button" 
                            class                   =   "btn btn-warning btn-fill" 
                            id                      =   "BTN_INFO_LOGS_<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>"  
                            name                    =   "BTN_INFO_LOGS"
                            onclick                 =   "js_viwes_popover(this.id,this.name)"
                            data-toggle             =   "popover" 
                            data-placement          =   "bottom" 
                            data-html               =   "true"
                            data-content            =   '<?php echo $html_li_logs;?>'
                        >
                        <i class="fa fa-history" aria-hidden="true"></i>
                    </button>
                </div>
            </fieldset>
        </div>
    </div>
    
        <!--  data-content            =   "SIN INFORMACI&Oacute;N", -->
        <?php
        if(count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"])>0){
            ?>    
            <div class="card" style="margin-bottom: 5px;">
                <div class="header">
                    <div class="GRID_HEARD_CHECK_MUESTRA">
                        <div class="GRID_HEARD_CHECK_MUESTRA1">
                            <h4 class="title" style="margin-bottom:15px;margin-left:10px;">
                                <b style="color:#888888;">MUESTRA ANATOMICA | <?php echo count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"]);?></b>
                            </h4>
                        </div>
                        <div class="GRID_HEARD_CHECK_MUESTRA1">
                            <button type="button" class="btn btn-xs btn-info btn-fill" id="BTN_INFO_HISPATOLOGICO_<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>" onclick="BTN_MARCA_ALL(<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>)">
                                <i class="fa fa-check-square" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="content" style="margin-top:-20px;">
                    <ul class="list-group" id="UL_RESULTADOS_<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>" style="margin-bottom:0px;">
                    <?php    
                        $IND_USOCASSETTE    =   $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_USOCASSETTE'];
                        if($IND_USOCASSETTE == 1){
                            foreach($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'] as $i => $row){ $ARR_CASETE_ORD[$row['NUM_CASSETTE']][] = $row; }
                            foreach($ARR_CASETE_ORD  as $y => $data_casete){
                                $li_muestras         =  '';
                                foreach($data_casete as $z => $row){    
                                    $li_muestras    .=  " - ".$row['TXT_MUESTRA']; 
                                }
                                ?>    
                                <li class="list-group-item lista_anatomia grupo_<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" id="<?php echo "C".$data_casete[0]['ID_CASETE'];?>"  data-NUM_TABS="<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                    <div class="CSS_GRID_MUESTRA_CASETE">
                                        <div class="CSS_GRID_MUESTRA_CASETE_1"><?php echo $y;?></div>
                                        <!--
                                            <div class="CSS_GRID_MUESTRA_CASETE_2"><?php echo $data_casete[0]['NUM_CASSETTE'];?></div>
                                        -->
                                        <div class="CSS_GRID_MUESTRA_CASETE_3"><?php echo $li_muestras;?></div>
                                        <div class="CSS_GRID_MUESTRA_CASETE_4"><b><?php echo "C".$data_casete[0]['ID_CASETE'];?></b></div>
                                        <div class="CSS_GRID_MUESTRA_CASETE_6">
                                            <input 
                                                    type        =   "checkbox" 
                                                    class       =   "form-check-input checkbox_<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" 
                                                    id          =   "CHEK_<?php echo 'C'.$data_casete[0]['ID_CASETE'];?>" 
                                                    style       =   "display:block;cursor:pointer;" 
                                                    onchange    =   "js_muestra_indivual('C<?php echo $data_casete[0]['ID_CASETE'];?>');"
                                                    value       =   "<?php echo $data_casete[0]['ID_CASETE'];?>"
                                                >
                                        </div>
                                        <div class="CSS_GRID_MUESTRA_CASETE_5" id="btn_<?php echo "C".$data_casete[0]['ID_CASETE'];?>">
                                            <span class="label label-danger">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <?php    
                            }
                        } else {
                            foreach($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){
                                ?>    
                                    <li class="list-group-item lista_anatomia grupo_<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" id="<?php echo "A".$row['ID_NMUESTRA'];?>" data-id_muestra="<?php echo $row['ID_NMUESTRA'];?>"    data-NUM_TABS="<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                                        <div class="CSS_GRID_MUESTRA">
                                            <div class="CSS_GRID_MUESTRA_1"><?php echo $i+1;?></div>
                                            <div class="CSS_GRID_MUESTRA_2 panel-heading"  role="tab" id="headingOne<?php echo $row['ID_NMUESTRA'];?>">
                                                <a role="button" style="padding: 0px" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $row['ID_NMUESTRA'];?>" aria-expanded="true" aria-controls="collapseOne<?php echo $row['ID_NMUESTRA'];?>" class="li_acordion_mtuestras">
                                                    <i><?php echo $row['TXT_MUESTRA']?></i>
                                                </a>
                                            </div>
                                            <div class="CSS_GRID_MUESTRA_3"><?php echo $row['TXT_ETIQUETA'];?></div>
                                            <div class="CSS_GRID_MUESTRA_4"><b><?php echo "A".$row['ID_NMUESTRA'];?></b></div>
                                            <div class="CSS_GRID_MUESTRA_6 _CENTER_1">
                                                <input 
                                                    type        =   "checkbox" 
                                                    class       =   "form-check-input checkbox_<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" 
                                                    id          =   "CHEK_<?php echo 'A'.$row['ID_NMUESTRA'];?>" 
                                                    style       =   "display:block;cursor:pointer;" 
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
        <?php } ?>
    
        <?php if(count($DATA["P_AP_MUESTRAS_CITOLOGIA"])>0){ ?>
    
        <?php echo '<div class="data_lista" id="'.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"].'" data-lista="'.htmlspecialchars(json_encode($DATA["P_AP_MUESTRAS_CITOLOGIA"]),ENT_QUOTES,'UTF-8').'"></div>';?>
            <div class="card" style="margin-bottom: 5px;">
                <div class="header">
                    <h4 class="title" style="margin-bottom:15px"><b>MUESTRA CITOL&Oacute;GICA | <?php echo count($DATA["P_AP_MUESTRAS_CITOLOGIA"]);?> </b></h4>
                </div>
                <div class="content" style="margin-top:-20px;">
                    <ul class="list-group " id="UL_RESULTADOS_<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>" style="margin-bottom:0px;">
                    <?php foreach($DATA["P_AP_MUESTRAS_CITOLOGIA"] as $i => $row){ ?>     
                        <li class="list-group-item lista_anatomia grupo_<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" id="<?php echo "A".$row['ID_NMUESTRA'];?>" data-NUM_TABS="<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" data-data_muestra="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"> 
                            <div class="CSS_GRID_MUESTRA2" >
                                <div class="CSS_GRID_MUESTRA_1"><?php echo $i+1; ?> </div>
                                <div class="CSS_GRID_MUESTRA_2"><?php echo $row['TXT_MUESTRA'];?>&nbsp;|&nbsp;<?php echo $row['NUM_ML'];?>ml</div>
                                <!--<div class="CSS_GRID_MUESTRA_2"><?php echo $row['NUM_ML'];?>ml</div>-->
                                <div class="CSS_GRID_MUESTRA_3"><?php echo $row['TXT_ETIQUETA'];?></div>
                                <div class="CSS_GRID_MUESTRA_4"><b><?php echo "A".$row['ID_NMUESTRA'];?></b></div>
                                
                                <div class="CSS_GRID_MUESTRA_6 _CENTER_1">
                                    <input 
                                        type        =   "checkbox" 
                                        class       =   "form-check-input checkbox_<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>" 
                                        id          =   "CHEK_<?php echo 'A'.$row['ID_NMUESTRA'];?>" 
                                        style       =   "display:block;cursor:pointer;" 
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
                        </li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>    
     
<!-- *********************************************************************** -->    
<?php if(substr($FIRST,0,1)!='S'){ ?>
    <script>js_fist_marcado("<?php echo strtoupper(substr($FIRST,0,1)).substr($FIRST,1);?>");</script>
<?php } ?>
<!-- *********************************************************************** -->  

<?php 
switch($FASE){
    case 0:
        echo "SOLO VISUALIZACI&Oacute;N |".$FASE."|";
        break;
    case 1:
        ?>
            <?php   if($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_HISTO_ESTADO"] == 1 || $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_HISTO_ESTADO"] == 2){   ?>
                <div class="_CENTER_1">
                    <div class="_CENTER_11">
                        <div class="btn-group btn_change">
                            <button class="btn btn-xs btn-fill btn-warning" onclick="confirma_custodia(<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>)" style="width:auto;height:35px;">
                                <i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;CONFIRMA CUSTODIA | N&deg;<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>
                            </button>
                            <button class="btn btn-xs btn-fill btn-info" onclick="confirma_trasporte(<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>)" style="width:auto;height:35px;display:none">
                                <i class="fa fa-truck" aria-hidden="true"></i>&nbsp;ENVIO A RECEPCI&Oacute;N A.P | N&deg;<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php   } else {   ?>
                    <?php if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_HISTO_ESTADO"] == 4) { ?>
                        <p><label for="size_2">YA RECEPCIONADA</label></p>
                    <?php } else { ?>
                        <p><label for="size_2">ESPERANDO A RECEPCION DE SOLICITUD</label></p>
                    <?php  } ?>
                    <script> 
                        $("#BTN_INFO_HISPATOLOGICO_<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>").hide();
                        $(".checkbox_<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>").hide();
                    </script>
            <?php  }  ?>
        <?php
        break;
    case 2:
        ?>
            <?php if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_HISTO_ESTADO"] == 4 && $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_ESTADO_MUESTRAS']==1) { ?>
                    <p><label for="size_2">SOLICITUD YA RECEPCIONADA | <?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_ESTADO_MUESTRAS"];?> </label></p>
                    <script>$(".checkbox_<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>").hide();</script>
            <?php } else {  ?>
                <div class="_CENTER_1">
                    <div class="_CENTER_11 btn_change">
                        <div class="btn-group">
                            <button class="btn btn-xs btn-fill btn-success" onclick="confirma_recepcion(<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>)" style="width:auto;height:35px;">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                &nbsp;CONFIRMA RECEPCI&Oacute;N | N&deg;<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?> | <?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_ESTADO_MUESTRAS"];?>
                            </button>
                        </div>
                    </div>
                </div>
                <?php if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_HISTO_ESTADO"] == 4) {?>
                    <script>marcadas_recepcionadas_resagadas(<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>);</script> 
                <?php } else { ?>
                    <script>marca_no_enviadasentrasporte(<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];?>);</script>  
                <?php } ?>
            <?php } ?>
        <?php
        break;
    case 3:
        echo "<b>EN TRASPORTE A 1) RECEPCION</b>";
        break;
    default:
        echo "<b>NO SE HA IDENFICADO</b>";
}
?>

<!-- array muestras de anatomia  -->
<div class="data_lista" id="<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]["ID_SOLICITUD"];?>" data-lista="<?php echo htmlspecialchars(json_encode($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_USOCASSETTE']==1?$ARR_CASETE_ORD:$DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"]),ENT_QUOTES,'UTF-8');?>"></div>

<!--
<hr>
<ul class="list-group" id="ul_resultados_cie10" style="margin-bottom: 0px;">
    <li class="gespab_group list-group-item list-group-item-primary">primary</li>
    <li class="gespab_group list-group-item list-group-item-secondary">secondary</li>
    <li class="gespab_group list-group-item list-group-item-success">success</li>
    <li class="gespab_group list-group-item list-group-item-danger">danger</li>
    <li class="gespab_group list-group-item list-group-item-warning">warning</li>
    <li class="gespab_group list-group-item list-group-item-info">info</li>
    <li class="gespab_group list-group-item list-group-item-light">light</li>
    <li class="gespab_group list-group-item disabled">disabled</li>
    <li class="gespab_group list-group-item list-group-item-dark">dark</li>
</ul>
-->