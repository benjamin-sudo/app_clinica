<table class="table" style="width:100%">
    <tbody>
        <tr>
            <td style="width:20%;padding:0px">
                <small>&nbsp;FECHA DE TOMA MUESTRA</small>
                <br style="margin:0px;">
                <b>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FECHA_SOLICITUD'];?></b>
            </td>
            <td style="width:20%;padding:0px">
                <small>FECHA DE RECEPCI&Oacute;N</small>
                <br style="margin:0px;">
                <b><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FECHA_RECEPCION'];?> - <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['HORA_RECEPCION'];?></b>
            </td>
            <td style="width:20%;padding:0px;text-align: end;">
                <small>FECHA DIAGN&Oacute;STICO</small>
                <br style="margin:0px;">
                <b><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DATE_FECHA_DIAGNOSTICO']==''?'NO INFORMADO':$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DATE_FECHA_DIAGNOSTICO'];?></b>
            </td>
            <td style="width:25%;padding:0px;text-align: end;">
                <small>FECHA IMPRESI&Oacute;N DE INFORME</small>
                <br style="margin:0px;">
                <b><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FECHA_IMREPSION_INFORME']==''?'NO INFORMADO':$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FECHA_IMREPSION_INFORME'];?></b>
            </td>
        </tr>
        <tr>
            <td style="padding:0px">
                <small>&nbsp;PREVISI&Oacute;N</small>
                <br style="margin:0px;">
                <b>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_PREVISION'];?></b>
            </td>
            <td style="padding:0px">
                <small>&nbsp;PROCEDENCIA</small>
                <br style="margin:0px;">
                <?php if($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['PA_ID_PROCARCH'] == "31"){ ?>
                    <b>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_PROCEDENCIA'];?></b>
                <?php  } else { ?>
                    <b>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NOMBRE_SERVICIO'];?></b>
                <?php } ?>
            </td>
            <td style="padding:0px">
                <?php if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_EMPRESA_DERIVADA'] != ''){ ?>
                    <small>&nbsp;ESTABLECIMIENTO DE ORIGEN</small>
                    <br style="margin:0px;">
                    <b>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_EMPRESA_DERIVADA'];?></b>
                <?php } ?>
            </td>
            <td style="padding:0px">&nbsp;</td>
        </tr>
    </tbody>
</table>