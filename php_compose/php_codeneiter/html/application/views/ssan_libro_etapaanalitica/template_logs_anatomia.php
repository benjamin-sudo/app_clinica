<?php if (count($P_AP_INFORMACION_ADICIONAL)>0){ ?>
    <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true" style="margin-bottom: 0px;">
        <ul class="list-group" id="ul_log_<?php echo $ID_SOLICITUD;?>" style="margin-bottom:0px;">
            <?php foreach($P_AP_INFORMACION_ADICIONAL as $id_carga => $r_log){ ?>
                <li class="list-group-item" style="padding: 0px;"> 
                    <a  href="#collapse_log_<?php echo $id_carga;?>" role="button" style="padding:0px;color: black;" data-toggle="collapse" data-parent="#accordion2" aria-controls="collapse_log_<?php echo $id_carga;?>"  aria-expanded="true"  class="li_acordion_logs">
                        <?php
                            $TXT_FASE               =   reset($r_log)[0]["MAIN"]["TXT_FASE"];
                            $TXT_EDITA              =   reset($r_log)[0]["MAIN"]["TXT_EDITA"];
                            $ID_LINETIMEHISTO       =   reset($r_log)[0]["MAIN"]["ID_LINETIMEHISTO"];
                            $FECHA_CREACION_LOG     =   reset($r_log)[0]["MAIN"]["FECHA_CREACION_LOG"];
                            $FECHA_CREACION_MOMENT  =   reset($r_log)[0]["MAIN"]["FECHA_CREACION_MOMENT"];
                            $ID_CASETE              =   reset($r_log)[0]["MAIN"]["ID_CASETE"];
                            $IND_COLOR              =   reset($r_log)[0]["MAIN"]["IND_COLOR"]; 
                        ?>
                        <div class="panel_a_log">
                            <div class="panel_a_log1">
                                <i class="fa fa-circle" style="color:<?php echo $IND_COLOR;?>" aria-hidden="true"></i>&nbsp;<b style="color:#888888;"><i><?php echo $TXT_FASE;?></i></b>
                                <br>
                                <small><b style="color:#888888;"><i><?php echo $TXT_EDITA;?></i></b></small>
                            </div>
                            <div class="panel_a_log1" style="text-align: end;">
                                <small><b style="color:#888888;"><i><?php echo $FECHA_CREACION_LOG;?></i></b></small>
                                <br>
                                <small><i class="fa fa-refresh" aria-hidden="true" style="color:#888888;"></i></small>
                                <small  style="color:#888888;" id="txt_moment_<?php echo $ID_LINETIMEHISTO;?>"></small> 
                                <script>$("#txt_moment_<?php echo $ID_LINETIMEHISTO;?>").html(moment("<?php echo $FECHA_CREACION_LOG.":00";?>","DD-MM-YYYY hh:mm:ss").startOf("<?php echo $FECHA_CREACION_MOMENT==date("Ymd")?'hours':'day';?>").fromNow());</script>
                            </div>
                        </div>
                    </a>
                    <div id="collapse_log_<?php echo $id_carga;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $id_carga;?>">
                        <div class="grid_css_muestra_log">
                            <div class="grid_cell">
                                <div class="cell_content" style="text-align: center;"><b style="color:#888888;">#</b></div>
                            </div>
                            <div class="grid_cell">
                                <div class="cell_content" style="text-align: center;"><i class="fa fa-barcode" aria-hidden="true" style="color:#888888;"></i></div>
                            </div>
                            <div class="grid_cell">
                                <div class="cell_content"><b style="color:#888888;">TEXTO</b></div>
                            </div>
                            <div class="grid_cell">
                                <div class="cell_content" style="text-align: center;"><i class="fa fa-info" aria-hidden="true" style="color:#888888;"></i></div>
                            </div>
                        </div>
                        <?php
                            $aux=1;
                            foreach($r_log as $aux_muestra => $row_muestra){ 
                                //falta ver si viene 
                                $txt_estado     =   '<i class="fa fa-check-circle" style="color:#87CB16;" aria-hidden="true"></i>';
                                //$txt_estado   =   '<i class="fa fa-times" aria-hidden="true"  style="color:#FB404B;"></i>';
                                $txt_bacode     =   $row_muestra[0]["MAIN"]["ID_CASETE"]==''?'A':'C';
                            ?>
                            <div class="grid_css_muestra_log">
                                <div class="grid_cell">
                                    <div class="cell_content" style="text-align: center;"><b style="color:#888888;"><?php echo ($aux++);?></b></div>
                                </div>
                                <div class="grid_cell">
                                    <div class="cell_content" style="text-align: center;"><b style="color:#888888;"><?php echo $txt_bacode.$row_muestra[0]["MAIN"]["TXT_BACODE"]?></b></div>
                                </div>
                                <div class="grid_cell">
                                    <div class="cell_content"><b style="color:#888888;"><?php echo $row_muestra[0]["MAIN"]["TXT_MUESTRA"];?></b></div>
                                </div>
                                <div class="grid_cell">
                                    <div class="cell_content" style="text-align: center;"><?php echo $txt_estado?></div>
                                </div>
                            </div>
                            <?php
                            }
                        ?>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?> 

<?php return false; ?>

<?php if (count($P_AP_INFORMACION_ADICIONAL)>0){ ?>
    <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true" style="margin-bottom: 0px;">
        <ul class="list-group" id="ul_log_<?php echo $ID_SOLICITUD;?>" style="margin-bottom:0px;">
                <?php 
                foreach($P_AP_INFORMACION_ADICIONAL as $id_log => $r_log){
                    $TXT_FASE               =   $r_log[0]["MAIN"]["TXT_FASE"];
                    $TXT_EDITA              =   $r_log[0]["MAIN"]["TXT_EDITA"];
                    $ID_LINETIMEHISTO       =   $r_log[0]["MAIN"]["ID_LINETIMEHISTO"];
                    $FECHA_CREACION_LOG     =   $r_log[0]["MAIN"]["FECHA_CREACION_LOG"];
                    $FECHA_CREACION_MOMENT  =   $r_log[0]["MAIN"]["FECHA_CREACION_MOMENT"];
                    $ID_CASETE              =   $r_log[0]["MAIN"]["ID_CASETE"];
                    //echo "ID->".$ID_CASETE."<br>";
                ?>
                <li class="list-group-item" style="padding: 0px;"> 
                    <a  href="#collapse_log_<?php echo $id_log;?>" role="button" style="padding:0px;color: black;" data-toggle="collapse" data-parent="#accordion2" aria-controls="collapse_log_<?php echo $id_log;?>"  aria-expanded="true"  class="li_acordion_logs">
                        <div class="panel_a_log">
                            <div class="panel_a_log1">
                                <b style="color:#888888;"><i><?php echo $TXT_FASE;?></i></b>
                                <br>
                                <small><b style="color:#888888;"><i><?php echo $TXT_EDITA;?></i></b></small>
                            </div>
                            <div class="panel_a_log1" style="text-align: end;">
                                <small><b style="color:#888888;"><i><?php echo $FECHA_CREACION_LOG;?></i></b></small>
                                <br>
                                <small><i class="fa fa-refresh" aria-hidden="true" style="color:#888888;"></i></small>
                                <small  style="color:#888888;" id="txt_moment_<?php echo $ID_LINETIMEHISTO;?>"></small> 
                                <script>$("#txt_moment_<?php echo $ID_LINETIMEHISTO;?>").html(moment("<?php echo $FECHA_CREACION_LOG.":00";?>","DD-MM-YYYY hh:mm:ss").startOf("<?php echo $FECHA_CREACION_MOMENT==date("Ymd")?'hours':'day';?>").fromNow());</script>
                            </div>
                        </div>
                    </a>
                    <div id="collapse_log_<?php echo $id_log;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $id_log;?>">
                        <hr style="margin: 0px">
                        <table class="table table-striped" style="margin-top:4px;margin-bottom:3px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width:5%;">#</th>
                                    <th scope="col" style="width:60%;">NOMBRE</th>
                                    <th scope="col" style="width:30%;">ESTADO</th>
                                    <th scope="col" style="width:5%;"><i class="fa fa-info" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php    
                                    foreach ($r_log as $aux => $row){
                                        $_info                  =   $row["MAIN"]["IND_CHECKED"]==1?'OK':'EVENTO';
                                        $txt_evento             =   '';
                                        if(count($row["ERROR_LOG"])>0){
                                            //foreach ($row["ERROR_LOG"] as $aux2 => $row3){
                                                $txt_evento     .=  $row["ERROR_LOG"]["DESCRIPCION"].'<br>'.$row["ERROR_LOG"]["TXT_EVENTO_OBSERVACION"];
                                            //}
                                            //<a href="#" class="color:crimson;" data-toggle="tooltip" data-placement="right" title=\''.$txt_evento.'\' data-html="true"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                        } ?>
                                        <tr>
                                            <td><small><?php echo ($aux+1);?></small></td>
                                            <td><small><?php echo $row["MAIN"]["TXT_MUESTRA"];?></small></td>
                                            <td><small><?php echo $_info;?></small></td>
                                            <td><small><?php echo $txt_evento==''?'':''?> </small>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </li>
            <?php 
            }    
            ?>
        </ul>
    </div>
<?php } else { ?>
    <div style="padding:15px;text-align: center">
        <b>SIN INFORMACI&Oacute;N</b>    
    </div>
<?php } ?>

