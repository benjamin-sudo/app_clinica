<?php
    $img_all                        =   $row["N_IMAGE_VIEWS"]+$row["N_IMAGE_VIEWS_X_MUESTRA"];
    if($img_all==0){
        $n_image_views              =   'disabled';   
    } else {
        $n_image_views              =   'onclick="ver_imagenes('.$row["ID_SOLICITUD"].')"';   
    }
    #$n_image_views                 =   $row["N_IMAGE_VIEWS"]==0||$row["N_IMAGE_VIEWS_X_MUESTRA"]?'disabled':'onclick="ver_imagenes('.$row["ID_SOLICITUD"].')"';
    $txt_day                        =   $row["LAST_DATE_AUDITA_MOMENT"]===date("Ymd")?'hours':'day';
    $ID_SOLICITUD                   =   $row["ID_SOLICITUD"];
?>
<?php $v_border_star = $aux===1?'border-radius:4px 4px 0px 0px;':''; ?>
<a href="#" class="css_lista_ordenada <?php echo $row["STYLE_HISTO_ZONA"];?> list-group-item list-group-item-action  solicitud_<?php echo $row["ID_SOLICITUD"];?>" style="padding:0px;">
    <div class="grid_a_rce_anatomiapatologica css<?php echo substr($ind_opcion,1);?>" id="anatomia_<?php echo $row["ID_SOLICITUD"];?>" data-id_anatomia_pantalla='<?php echo $row["ID_SOLICITUD"];?>'>
        <div class="grid_a_rce_anatomiapatologica1" style="text-align:start">
            <div class="grid_elimina_registro_busqueda">
                <div class="grid_elimina_registro_busqueda1"><b><?php echo $aux;?></b></div>
                <div class="grid_elimina_registro_busqueda2">&nbsp;</div>
                <div class="grid_elimina_registro_busqueda3">&nbsp;</div>
            <?php if ($ind_opcion == '#_panel_por_gestion'){ ?>
                <div class="grid_elimina_registro_busqueda4">
                    <i class="fa fa-eraser"  style="text-align:start;color:#888888;" id="delete_list_panel_por_gestion" onclick="js_delete_list_gestion(<?php echo $row["ID_SOLICITUD"];?>)" aria-hidden="true"></i>
                </div>
            <?php } ?>
            </div>
        </div>
        <div class="grid_a_rce_anatomiapatologica2">
            <i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;<b><?php echo $row["RUTPACIENTE"];?></b>
            <br>
            <i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;<b><?php echo $row["NOMBRE_COMPLETO"];?></b>
            <br>
            <i class="fa fa-birthday-cake" aria-hidden="true"></i>&nbsp;<b><?php echo $row["NACIMIENTO"];?></b> 
        </div>
        <div class="grid_a_rce_anatomiapatologica3">
            <i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;<b><?php echo $row["COD_RUTPRO"];?>-<?php echo $row["DV"];?></b>
            <br>
            <i class="fa fa-user-md" aria-hidden="true"></i>&nbsp;<b><?php echo $row["NOM_PROFE_CORTO"];?></b>
        </div>
        <div class="grid_a_rce_anatomiapatologica5">
            <i class="fa fa-map-marker" aria-hidden="true"></i><b>&nbsp;<?php echo $row["TXT_HISTO_ZONA"];?></b> - <?php echo $row["ID_HISTO_ZONA"];?>
            <input type="hidden" id="id_zona_<?php echo $row["ID_SOLICITUD"];?>" value="<?php echo $row["ID_HISTO_ZONA"];?>"/>
        </div>
        <div class="grid_a_rce_anatomiapatologica8 class num_biospias_<?php echo $row["ID_SOLICITUD"];?>" style="text-align: justify;"  
                data-n_biopsia = "<?php echo $row['NUM_INTERNO_AP'];?>"
                data-n_citologia = "<?php echo $row['NUM_CO_CITOLOGIA'];?>"
                data-n_pap = "<?php echo $row['NUM_CO_PAP'];?>">
            <b class="ind_numeros_anatomia" style="font-size: 12px;">
                <?php echo $row['NUM_INTERNO_AP'] == ''?'':'N&deg; BIOPSIA: '.$row['NUM_INTERNO_AP'];?> 
                <?php echo $row['IND_TIPO_BIOPSIA'] == 4?'<br>':'';?> 
                <?php echo $row['NUM_CO_CITOLOGIA'] ==  ''?'':'N&deg; CITOL&Oacute;GICO: '.$row['NUM_CO_CITOLOGIA'];?> 
                <?php echo $row['NUM_CO_PAP'] == ''?'':'N&deg; PAP: '.$row['NUM_CO_PAP'];?> 
            </b>
            <?php echo $row['TXT_EMPRESA_DERIVADO'] ==  '' ? '' : '<br><span class="label label-info"><i class="fa fa-hospital-o" aria-hidden="true"></i>&nbsp;'.$row['TXT_EMPRESA_DERIVADO'].'</span>';?>
            <br>
            <i  style="text-align:CENTER;color:#888888;" id="<?php echo $row["ID_SOLICITUD"];?>" onclick="GET_PDF_ANATOMIA_PANEL(this.id)" aria-hidden="true">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i> <b>SOLICITUD</b>
            </i>
        </div>
        <div class="grid_a_rce_anatomiapatologica7">
            <div class="grid_li_pdfs">
                <div class="grid_li_pdfs1" style="display: none">
                <?php if ($row["INF_PDF_MACRO"]==1){ ?>
                    <?php if($get_sala=='administrativo'){ ?>
                        <div class="grid_li_pdfs1 btn-group-vertical">
                            <button 
                                type = "button" 
                                class = "btn btn-success btn-xs btn-fill" 
                                id = "btn_pdf_macro" 
                                name = "btn_pdf_macro"
                                <?php if ($row["ID_HISTO_ZONA"]==0){
                                    echo 'disabled';
                                } else {
                                    echo 'onclick="js_pdf_microscopica('.$row["ID_SOLICITUD"].')";';
                                } ?>
                                >
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            </button>
                        </div>
                    <?php   }   ?>
                <?php } ?>
                </div>
             </div>
        </div>
        <div class="grid_a_rce_anatomiapatologica4" style="text-align: end;">
            <b><?php echo $row["TIPO_DE_BIOPSIA"];?></b><br>
            <b>MUESTRAS:<?php echo $row["N_MUESTRAS_TOTAL"];?></b>
            <?php if($row["TXT_USOCASSETTE"]=='SI'){ echo '<span class="badge bg-light">CASETE</span>';}?><br>
            <b><?php echo $row["DATE_FECHA_REALIZACION"];?></b>
        </div>
        <div class="grid_a_rce_anatomiapatologica6" style="text-align: end;">
            
            <div class="btn-group">
                <?php if($get_sala=='analitica'){ ?>
                    <?php   if ($row["ID_HISTO_ZONA"]==7){  ?>
                        <button type="button" class="btn btn-info btn-fill btn_analitica_<?php echo $row["ID_SOLICITUD"];?>" id="btn_gestion_analitica" onclick="star_analitica(<?php echo $ID_SOLICITUD;?>)" data-rce_finaliza="true" >
                            <i class="fa fa-stethoscope" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-warning btn-fill ver_imagenes_central" id="vista_<?php echo $row["ID_SOLICITUD"];?>" <?php echo $n_image_views;?> data-visualizaimg="false">
                           <i class="fa fa-file-image-o" aria-hidden="true"></i>
                        </button>
                    <?php   }   else    if($row["ID_HISTO_ZONA"]==8){   ?>
                        <button type="button" class="btn btn-success btn-fill " id="btn_pdf_informe_macroscopica" onclick="js_pdf_microscopica(<?php echo $ID_SOLICITUD;?>)" >
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-fill btn_analitica_<?php echo $row["ID_SOLICITUD"];?>" onclick="star_analitica(<?php echo $ID_SOLICITUD;?>)" id="btn_gestion_analitica" data-rce_finaliza="true" >
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </button>
                    <?php   }   else    {   ?> 
                        <?php if($row["ID_HISTO_ZONA"]!=0){ ?>
                            <button type="button" class="btn btn-info btn-fill btn_analitica_<?php echo $row["ID_SOLICITUD"];?>" onclick="star_analitica(<?php echo $ID_SOLICITUD;?>)" id="btn_gestion_analitica" data-rce_finaliza="false" >
                                <i class="fa fa-database" aria-hidden="true"></i>
                            </button>
                        <?php } ?>
                        <?php if ($n_image_views == 'disabled'){    ?>
                            <button type="button" class="btn btn-defaulf btn-fill " disabled>
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-warning btn-fill ver_imagenes_central" id="vista_<?php echo $row["ID_SOLICITUD"];?>" <?php echo $n_image_views;?> data-visualizaimg="false">
                                <i class="fa fa-file-image-o" aria-hidden="true"></i>
                            </button>
                        <?php } ?>
                    <?php   }   ?>
                <?php } else if($get_sala=='sala_proceso'){ ?>
                    <?php   #PREPARADO PARA LA SALA DE PROCESO; ?>
                    <?php   if($row["ID_HISTO_ZONA"]==1){ ?>
                        <button type="button" class="btn btn-warning btn-fill " id="btn_play_sala_proceso" onclick="js_star_sala_proceso(<?php echo $ID_SOLICITUD;?>)">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-defaulf btn-fill ">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                        </button>
                    <?php   } else if($row["ID_HISTO_ZONA"]==5){ ?>
                        <button type="button" class="btn btn-warning  btn-fill " id="btn_play_sala_proceso"   onclick="js_star_sala_proceso(<?php echo $ID_SOLICITUD;?>)">
                            <i class="fa fa-stop" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-info btn-fill ">
                            <i class="fa fa-clock-o fa-pulse fa-fw" aria-hidden="true"></i>
                        </button>
                    <?php   } else if($row["IND_SALA_PROCESO"]==1){ ?>
                        <button type="button" class="btn btn-success btn-fill" >
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </button>
                    <?php   } else { ?>
                        <button type="button" class="btn btn-defaulf btn-fill " disabled>
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </button>
                    <?php } ?>
                <?php } else if($get_sala=='salamacroscopia'){ ?>
                    <?php   #SALA MACROSCOPIA;  ?>
                    <?php   if($row["ID_HISTO_ZONA"]==0){?>
                        
                        <button type="button" class="btn btn-warning btn-fill" id="btn_gestion_descripcion_muestras" onclick="star_descrpcion_muestras(<?php echo $ID_SOLICITUD;?>)">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-light" disabled>
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        </button>

                    <?php   }   else    {  ?>
                        <?php   if ($row["IND_TIPO_BIOPSIA"]==6 || $row["IND_TIPO_BIOPSIA"]==5){  ?>
                        <button type="button" class="btn btn-success btn-fill tooltip2" style="cursor:pointer;">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <span class="tooltiptext2">EN SALA INCLUSI&Oacute;N</span>
                        </button>
                        <?php   }  else  {   ?>
                        <button type="button" class="btn btn-info btn-fill " id="btn_pdf_informe_macroscopica" onclick="js_pdf_macroscopia(0,<?php echo $ID_SOLICITUD;?>)" >
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-fill " >
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </button>
                        <?php   }   ?>
                    <?php   }   ?>
                <?php } else if($get_sala=='sala_tecnologo') {   ?>
                    <?php #SALA TECNOLOGO; ?>
                    <?php if($row["ID_HISTO_ZONA"]==6 || $row["ID_HISTO_ZONA"]==4){?>
                        <button type="button" class="btn btn-danger btn-fill" id="star_sala_tecnicas" onclick="js_sala_tecnicas(<?php echo $ID_SOLICITUD;?>)">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-defaulf btn-fill">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                        </button>
                    <?php } else if($row["ID_HISTO_ZONA"]==7)   {   ?> 
                        <button type="button" class="btn btn-info btn-fill tooltip2" id="btn_pdf_sala_tecnicas" disabled>
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            <span class="tooltiptext2">PDF NO DISPONIBLE</span>
                        </button>
                        <button type="button" class="btn btn-success btn-fill " >
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </button>
                    <?php } else if($row["ID_HISTO_ZONA"]==8)   {   ?> 
                        <button type="button" class="btn btn-success btn-fill " id="btn_pdf_informe_macroscopica" onclick="js_pdf_microscopica(<?php echo $ID_SOLICITUD;?>)" >
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-fill tooltip2" >
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <span class="tooltiptext2">INFORME FINALIZADO</span>
                        </button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-defaulf btn-fill tooltip2">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                            <span class="tooltiptext2"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;NO DIPONIBLE</span>
                        </button>
                    <?php } ?>
                <?php } else if($get_sala=='administrativo') { ?>
                    <?php if ($row["ID_HISTO_ZONA"] == 8)       {   ?>
                        <button type="button" class="btn btn-success btn-fill " id="btn_pdf_informe_macroscopica" onclick="js_pdf_microscopica(<?php echo $ID_SOLICITUD;?>)" >
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-fill " >
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </button>
                    <?php  } else { ?> 
                        <button type="button" class="btn btn-info btn-fill" id="star_sala_tecnicas" onclick="js_informacion_administrativo(<?php echo $ID_SOLICITUD;?>)">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-defaulf btn-fill">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        </button>
                    <?php  } ?>
                <?php } else {  ?>
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-file-image-o fa-stack-1x"></i>
                        <i class="fa fa-ban fa-stack-2x text-danger"></i>
                    </span>
                <?php } ?>
            </div>
            <hr style="margin: 4px 0px 0px 10px;">
            <div class="grid_time_li">
                <div class="grid_time_li1" style="text-align:center;">
                    <!--
                    <small><i class="fa fa-refresh" aria-hidden="true"></i></small>
                    -->
                    <small id="txt_moment_<?php echo $row["ID_SOLICITUD"];?>"></small>
                    <script>
                        /*
                        setTimeout(function(){ 
                            $("#txt_moment_<?php echo $row["ID_SOLICITUD"];?>")
                                .html(moment("<?php echo $row["LAST_DATE_AUDITA"];?>","DD-MM-YYYY HH:mm")
                                .startOf("<?php echo $txt_day;?>")
                                .fromNow());
                        },1000);
                        */
                    </script>
                </div>
            </div>
        </div>
    </div>
</a>

