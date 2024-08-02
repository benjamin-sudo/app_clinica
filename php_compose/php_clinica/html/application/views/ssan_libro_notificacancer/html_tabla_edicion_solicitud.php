<div class="card">
    <table class="table table-striped" style="margin-bottom: 0px;">
        <thead>
            <tr>
                <th scope="row" style="height: 40px;" colspan="7">
                    <h5 style="margin: 0px 0px 0px 0px;">
                        <b style="color:#888888;">RESULTADOS PARA EDICI&Oacute;N</b>
                        <span class="badge n_resultados_panel" style="background-color:dodgerblue;margin-bottom: 2PX;"><?php echo count($cursor[":C_LISTA_ANATOMIA"]);?></span>
                    </h5> 
                </th>
            </tr>
            <tr>
                <th scope="col" style="height: 40px;">#</th>
                <th scope="col" >Paciente</th>
                <th scope="col" >Profesional</th>
                <th scope="col" >Tipo biopsia</th>
                <th scope="col" >N&deg; Biopsia</th>
                <th scope="col" style="text-align:center"><i class="fa fa-info-circle" aria-hidden="true"></i></th>
                <th scope="col" style="text-align:center"><i class="fa fa-cog" aria-hidden="true"></i></th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($cursor[":C_LISTA_ANATOMIA"])){ 
            foreach ($cursor[":C_LISTA_ANATOMIA"] as $i => $row){ 
                $numero = ($i+1);  
            ?>
            <tr >
                <th scope="row" style="height: 40px;">
                    <?php echo $numero++;?>
                    <div style="display: none" id="qrcode_<?php echo $row["ID_SOLICITUD"];?>"></div>
                    <div style="display: none" id="biopsia_<?php echo $row['ID_SOLICITUD'];?>" data-info="<?php echo htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');?>"></div>
                </th>
                <td><?php echo $row["NOMBRE_COMPLETO"];?></td>
                <td><?php echo $row["PROFESIONAL2"];?></td>
                <td><?php echo $row["TIPO_DE_BIOPSIA"];?></td>
                <td>
                    <?php echo $row['NUM_INTERNO_AP']   =='0' ? '':'N&deg; BIOPSIA: '.$row['NUM_INTERNO_AP'];?> 
                    <?php echo $row['IND_TIPO_BIOPSIA'] == 4 ? '<br>':'';?> 
                    <?php echo $row['NUM_CO_CITOLOGIA'] =='' ? '':'N&deg; CITOL&Oacute;GICO: '.$row['NUM_CO_CITOLOGIA'];?> 
                    <?php echo $row['NUM_CO_PAP']       =='' ? '':'N&deg; PAP: '.$row['NUM_CO_PAP'];?> 
                </td>
                <td>
                    <span class="badge bg-warning"><?php echo $row["TXT_SOLICITUD_EDITADA"]?></span>
                </td>
                <td style="text-align:center">

                    <div class="btn-group">
                        <a class="btn btn-fill btn-primary dropdown-toggle dropdown-menu-end" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                            <span class="sr-only"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="margin-top:0px;min-width:240px;">
                            <li><h6 class="dropdown-header" style="border-left:1px solid #ececec;text-align:justify;">&nbsp;HERRAMIENTAS</h6></li>
                            <li>
                                <a class="dropdown-item" href="javascript:js_edita_numero_biopsia(<?php echo $row["ID_SOLICITUD"];?>)">
                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;EDITAR NUMERACI&Oacute;N DE BIOPSIA
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:js_edita_macrocopica(<?php echo $row["ID_SOLICITUD"];?>)">
                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;EDITAR FECHA <b>MARCOSCOPIA</b>
                                </a>
                            </li>
                            <?php if($row["ID_HISTO_ZONA"]=='8'){ ?>
                                <li>
                                    <a class="dropdown-item" href="javascript:js_edita_fecha_notificacion(0,<?php echo $row["ID_SOLICITUD"];?>)">
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;EDITAR FECHA Y HORA EMISI&Oacute;N INFORME
                                    </a>
                                </li>
                                <?php if($row["IND_CONF_CANCER"]=='1'){ ?>
                                    <li>
                                        <a class="dropdown-item" href="javascript:js_edita_fecha_notificacion(1,<?php echo $row["ID_SOLICITUD"];?>)">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;EDITAR FECHA Y HORA NOTIFICACI&Oacute;N DE CANCER
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($row["IND_SOLICITUD_EDITADA"] == 1) { ?>
                            <!--
                            <li>
                                <a class="dropdown-item" href="javascript:js_vista_historial_cambios(<?php echo $row["ID_SOLICITUD"];?>)">
                                    <i class="fa fa-database" aria-hidden="true"></i>VER HISTORIAL DE CAMBIOS
                                </a>
                            </li>
                            -->
                            <?php } ?>
                            <li><h6 class="dropdown-header" style="border-left:1px solid #ececec;text-align: justify;">&nbsp;INFORMES PDF</h6></li>
                            <li>
                                <a class="dropdown-item" href="javascript:GET_PDF_ANATOMIA_PANEL(<?php echo $row["ID_SOLICITUD"];?>);">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF SOLICITUD ANATOM&Iacute;A PATOL&Oacute;GICA
                                </a>
                            </li>
                            <?php if($row["ID_HISTO_ZONA"]=='8'){ ?>
                                <li>
                                    <a class="dropdown-item" href="javascript:js_pdf_informe_final(<?php echo $row["ID_SOLICITUD"];?>);">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF INFORME FINAL
                                    </a>
                                </li>
                                <?php if($row["IND_CONF_CANCER"]=='1'){ ?>
                                    <li>
                                        <a class="dropdown-item" href="javascript:pdf_notificacion_cancer_ok(<?php echo $row["ID_SOLICITUD"];?>);">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF NOTIFICACI&Oacute;N DE CANCER
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php 
                $array_post     =   [];
                array_push($array_post,"id_anatomia=".$row["ID_SOLICITUD"]);
                array_push($array_post,"empresa=".$this->session->userdata("COD_ESTAB"));
                $rul_for_qr     =   (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/ssan_libro_notificacancer?ind_externo=true&".join("&",$array_post);
                //echo $rul_for_qr;
            ?>
        <?php }  ?>
        <?php } else { ?>
            <tr>
                <th scope="row" colspan="7" style="text-align:center;height:40px;">SIN INFORMACI&Oacute;N</th>
            </tr>
        <?php  } ?>
        </tbody>
    </table>
</div>