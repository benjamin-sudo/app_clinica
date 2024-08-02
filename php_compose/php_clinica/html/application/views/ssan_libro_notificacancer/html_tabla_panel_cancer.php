<table class="table table-striped">
    <thead>
        <tr>
            <th scope="row" style="height: 40px;" colspan="4">
                <h5 style="margin: 0px 0px 0px 0px;">
                    <b style="color:#888888;">RESULTADOS, NOTIFICACI&Oacute;N DE CANCER</b>
                    <span class="badge n_resultados_panel" style="background-color:dodgerblue;margin-bottom:2PX;"><?php echo count($cursor[":C_LISTA_ANATOMIA"]);?></span></h5> 
                </h5>
            </th>
        </tr>
        <tr>
            <th scope="col" style="height: 40px;">#</th>
            <th scope="col" >Paciente</th>
            <th scope="col" >Profesional</th>
            <th scope="col" >Estado notificaci&oacute;n cancer</th>
            <th scope="col" ><i class="fa fa-cog" aria-hidden="true"></i></th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($cursor[":C_LISTA_ANATOMIA"])){ 
        foreach ($cursor[":C_LISTA_ANATOMIA"] as $i => $row){ $numero = ($i+1); $ID_SOLICITUD = $row["ID_SOLICITUD"]; ?>
        <tr>
            <th scope="row" style="height: 40px;">
                <?php echo $numero++;?>
                <div style="display: none" id="qrcode_<?php echo $row["ID_SOLICITUD"];?>" ></div>
            </th>
            <td><?php echo $row["NOMBRE_COMPLETO"];?></td>
            <td><?php echo $row["PROFESIONAL"];?></td>
            <td>
                <?php echo $row["TXT_ESTADO_CANCER"]=='NOTIFICADO'?'<span class="badge bg-success"><i class="fa fa-check" aria-hidden="true"></i> NOTIFICADO</span>':$row["TXT_ESTADO_CANCER"];?>
            </td>
            <td style="text-align:center">
                <div class="btn-group">
                    <?php if ($row["IND_CONF_CANCER"] == 1 && $row["IND_NOTIFICACANCER"] == 0  ){ ?>
                        <button type="button" class="btn btn-primary btn-fill" id="btn_exel_closew" onclick="js_notificar_cancer(<?php echo $ID_SOLICITUD;?>)">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </button>
                    <?php }  ?>
                    <?php if ($row["IND_NOTIFICACANCER"] == 1  ){ ?>
                        <button type="button" class="btn btn-danger btn-fill" id="btn_exel_closew" onclick="pdf_notificacion_cancer_ok(<?php echo $ID_SOLICITUD;?>)">
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                        </button>
                    <?php }  ?>
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
        <script>
            /*
            var qrcodjs = new QRCode("qrcode_<?php echo $row["ID_SOLICITUD"];?>", {
                text: "<?php echo $rul_for_qr;?>",
                width: 128,
                height: 128,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            */
        </script>
    <?php }  ?>
    <?php } else { ?>
        <tr>
            <th scope="row" colspan="7" style="text-align:center;height:40px;">SIN INFORMACI&Oacute;N</th>
        </tr>
    <?php  } ?>
    </tbody>
</table>
