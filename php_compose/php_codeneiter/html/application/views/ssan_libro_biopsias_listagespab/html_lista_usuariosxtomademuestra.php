<ul class="list-group" style="margin-bottom: 0px">
   <?php if(count($DATA[':P_ALL_TOMAS_MUESTRA'])>0){
        foreach($DATA[':P_ALL_TOMAS_MUESTRA'] as $i => $row){?>
            <li class="list-group-item list-group-item-action data_rotulado_<?php echo $row['ID_ROTULADO'];?>" style="padding:0px" data-data_plantilla="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>" data-open="false">
                <div class="grid_serviciosxrotulo">
                    <div class="grid_serviciosxrotulo1"><?php echo ($i+1);?>.- <?php echo $row['TXT_OBSERVACION'];?></div>
                    <div class="grid_serviciosxrotulo4"> 
                        <input class="form-check-input" <?php echo $row['IND_ESTADISTICA']=="0"?"":"checked"?> type="checkbox" value="" id="estadistica_<?php echo $row['ID_ROTULADO'];?>" style="display:block;margin-bottom:10px;cursor:pointer;" onclick="js_marcaestadistica(this.id)">
                    </div>
                    <div class="grid_serviciosxrotulo2"> 
                        <label for="estadistica_<?php echo $row['ID_ROTULADO'];?>">ESTADISTICA</label>
                    </div>
                    <div class="grid_serviciosxrotulo3"> 
                        <?php if ($row['NUM_SUBGRUPO'] != 0){ ?>
                            <span class="badge n_resultados_panel" style="background-color:dodgerblue;"><?php echo $row['NUM_SUBGRUPO'];?></span>
                        <?php } ?>
                    </div>
                    <div class="grid_serviciosxrotulo3" style="text-align:end;">
                        <button type="button" class="btn btn-info btn-fill" id="BTN_UPDATE_PANEL_1" data-toggle="collapse" data-target="#collapse_<?php echo $row['ID_ROTULADO'];?>" onclick="js_add_hijo_tomamuestra(<?php echo $row['ID_ROTULADO'];?>)">
                            <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                </div>
                <div class="collapse" id="collapse_<?php echo $row['ID_ROTULADO'];?>">
                    <div class="grid_subroluto">
                        <div class="grid_subroluto1">
                            <input type="text" class="form-control" id="new_nombre_<?php echo $row['ID_ROTULADO'];?>" value="<?php echo $row['TXT_OBSERVACION'];?>">
                        </div>
                        <div class="grid_subroluto2">
                            <button type="button" class="btn btn-warning btn-fill" id="btn_newplanificacion" onclick="js_confirma_cambio(<?php echo $row['ID_ROTULADO'];?>)">
                                <i class="fa fa-check" aria-hidden="true"></i>&nbsp;EDITAR NOMBRE
                            </button>
                        </div>
                    </div>
                    <hr style="margin-bottom: 7px;margin-top: 7px;">
                    <button type="button" class="btn btn-info  btn-fill class_btn_newplanificacion0" id="btn_newplanificacion0" onclick="js_new_subrotulo(<?php echo $row['ID_ROTULADO'];?>)" style="margin-left: 15px;">
                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;<b>NUEVO SUB-GRUPO</b>
                    </button>
                    <hr style="margin-bottom: 7px;margin-top: 7px;">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><b>#</b></th>
                                    <th><b>OBSERVACI&Oacute;N</b></th>
                                    <th><b>CREACI&Oacute;N</b></th>
                                    <th style="text-align: end;"><b>OPT</b></th>
                                </tr>
                            </thead>
                            <tbody id="table_result_<?php echo $row['ID_ROTULADO'];?>"></tbody>
                        </table>
                    </div>
                </div>
            </li>
        <?php }
    } else { 
        ?>
        <b>SIN RESULTADOS</b>
    <?php  }  ?> 
</ul>
