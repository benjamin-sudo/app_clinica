<?php
    $v_year_star    = 2021;
    $v_year_actual  = date('Y');
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="row" style="height: 40px;" colspan="4">
                <h5 style="margin: 0px 0px 0px 0px;">
                    <b style="color:#888888;">LISTADO NOTIFICADO</b>
                    <span class="badge n_resultados_panel" style="background-color:dodgerblue;margin-bottom: 2PX;"><?php echo count($cursor['data_bd'][':C_LISTADO_CANCER']);?></span>
                </h5> 
            </th>
            <th scope="row" style="height: 40px;" colspan="3">
                <select id="ind_year_cancer" name="ind_year_cancer" class="form-control input-sm" onchange="listado_notifica_cancer(this.value)">
                    <?php 
                    for ($i = $v_year_star; $i <= $v_year_actual; $i++) {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                    ?>
                </select>
            </th>
        </tr>
        <tr>
            <th scope="col" style="height: 40px;">#</th>
            <th scope="col">Informaci&oacute;n del paciente</th>
            <th scope="col">Informaci&oacute;n solicitante</th>
            <th scope="col">Tipo biopsia</th>
            <th scope="col" style="text-align:center"><i class="fa fa-info-circle" aria-hidden="true"></i></th>
            <th scope="col" style="text-align:center" style="width: 60px;"><i class="fa fa-cog" aria-hidden="true"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($cursor['data_bd'][':C_LISTADO_CANCER']>0)){  
                foreach($cursor['data_bd'][':C_LISTADO_CANCER'] as $i => $row){ $aux = $i +1; ?>
                <tr>
                    <td style="height: 40px"><?php echo $aux;?></td> 
                    <td><?php echo $row['NOMBRE_COMPLETO'];?></td> 
                    <td><?php echo $row['PROFESIONAL'];?></td> 
                    <td><?php echo $row['TIPO_DE_BIOPSIA'];?><br>N&deg;: <?php echo $row['NUM_NOF_CANCER'];?>  </td> 
                    <td style="text-align:center"><?php 
                        echo $row['IND_NOTIFICACANCER'] == 1 ? 
                            '<span class="label label-success" style="padding: 5px;"><i class="fa fa-check" aria-hidden="true"></i></span>':
                            '<span class="label label-danger" style="padding: 5px;"><i class="fa fa-times" aria-hidden="true"></i></span>';
                    ?></td> 
                    <td style="text-align:center">
                        <div class="btn-group">
                            <a class="btn btn-fill btn-xs btn-primary dropdown-toggle dropdown-menu-right" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                <span class="fa fa-angle-down" title="" aria-hidden="true"></span>
                                <span class="sr-only"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" style="margin-top:0px;min-width:240px;">
                                <?php if ($row["IND_NOTIFICACANCER"] == 0) { ?>
                                    <li class="lista_notificacion_cancer">
                                        <a href="javascript:js_notificar_cancer(<?php echo $row["ID_SOLICITUD"];?>)">
                                        <i class="fa fa-users" aria-hidden="true"></i>INICIO NOTIFICACI&Oacute;N DE CANCER</a>
                                    </li>
                                <?php }  ?>
                                <li>
                                    <a href="javascript:GET_PDF_ANATOMIA_PANEL(<?php echo $row["ID_SOLICITUD"];?>)">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF SOLICITUD ANATOM&Iacute;A PATOL&Oacute;GICA</a>
                                </li>
                                <li>
                                    <a href="javascript:js_pdf_microscopica(<?php echo $row["ID_SOLICITUD"];?>)">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF INFORME ANATOMIA PATOLOGIA</a>
                                </li>
                                <?php if ($row["IND_NOTIFICACANCER"] == 1) { ?>
                                <li>
                                    <a href="javascript:pdf_notificacion_cancer_ok(<?php echo $row["ID_SOLICITUD"];?>)">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF NOTIFICACI&Oacute;N DE CANCER</a>
                                </li>
                                <?php  }  ?>
                            </ul>
                        </div>
                    </td> 
                </tr>
            <?php }?>
        <?php   } else { ?>
            <tr>
                <td colspan="7" style="height: 40px">
                    <b>SIN RESULTADOS A&Ntilde;O <?php echo $ind_year?></b>
                </td>
            </tr>
        <?php   }   ?>
    </tbody>
</table>
<script>$("#ind_year_cancer").val(<?php echo $ind_year?>);</script>