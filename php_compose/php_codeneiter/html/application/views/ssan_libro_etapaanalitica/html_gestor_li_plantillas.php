<?php
    $display_sincita            =   1;
    if(count($data_main[':P_LISTA_PLANTILLAS'])>0){
    $display_sincita            =   0;
        foreach($data_main[':P_LISTA_PLANTILLAS'] as $i => $row){   ?>
            <li class="list-group-item list-group-item-action data_plantilla_<?php echo $row['ID_TPLANTILLA'];?>" style="padding:0px" data-num_muestra='<?php echo $num_muestra?>' data-data_plantilla="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>">
                <div class="grid_li_plantillas_muestra">
                    <div class="grid_li_plantillas_muestra1"><?php echo $i+1;?> </div>
                    <div class="grid_li_plantillas_muestra2"><?php echo $row['TXT_TITULO'];?></div>
                    <div class="grid_li_plantillas_muestra3">
                        <FONT SIZE=1><?php echo $row['DATE_CREA'];?></font>
                    </div>
                    <div class="grid_li_plantillas_muestra4" style="text-align: end;">
                        <div class="btn-group">
                            <button 
                                type            =   "button" 
                                class           =   "btn btn-danger btn-xs btn-fill" 
                                id              =   "btn_elimina_plantilla" 
                                onclick         =   "js_elimina_plantilla(<?php echo $row['ID_TPLANTILLA'];?>)"
                                >
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                            <button 
                                type            =   "button" 
                                class           =   "btn btn-success btn-xs btn-fill" 
                                id              =   "btn_agrega_plantilla" 
                                onclick         =   "js_agrega_descripcion(<?php echo $row['ID_TPLANTILLA'];?>)"
                                >
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </li>
<?php            
        }
    } 
?>
            
<li class="list-group-item list-group-item-action sin_resultado_plantillas" <?php echo $display_sincita==0?'style="display:none"':'';?> >
   <i class="fa fa-times color_muestra" aria-hidden="true"></i>&nbsp;<b class="color_muestra">SIN PLANTILLAS CREADAS</b>
</li>