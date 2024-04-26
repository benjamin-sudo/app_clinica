<table style="width:100%;margin-bottom:15px;font-size:15px" >
    <tbody>
        <tr>
            <td style="width:25%">&nbsp;<b>NOMBRE</b></td>
            <td style="width:1%">&nbsp;:</td>
            <td style="width:47%">&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NOMBRE_COMPLETO'];?></td>
        </tr>
        <tr>
            <td>&nbsp;<b>EDAD</b></td>
            <td>&nbsp;:</td>
            <td>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['EDAD'];?>&nbsp;A&Ntilde;OS</td>
        </tr>
        <tr>
            <td>&nbsp;<b>RUN</b></td>
            <td>&nbsp;:</td>
            <td>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['RUTPACIENTE'];?>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;<b>N&deg; FICHA CLINICA</b></td>
            <td>&nbsp;:</td>
            <td>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FICHAL'];?>&nbsp;</td>
        </tr>
        <tr>
            <td valign="top">&nbsp;<b>MUESTRAS</b></td>
            <td valign="top">&nbsp;:</td>
            <td valign="top" style="padding-left: 5px;">
                <?php echo count($arr_info_muestras)>0?join("<br>",$arr_info_muestras):''?>
                <?php echo count($arr_info_cito)>0?"<br>".join("<br>",$arr_info_cito):''?>
            </td>
        </tr>
        <tr>
           <td>&nbsp;<b>EXAMEN SOLICITADO</b></td>
           <td>&nbsp;:</td>
           <td>&nbsp;<?php echo "DR(A): ".$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['PROFESIONAL_2'];?>&nbsp;</td>
        </tr>
    </tbody>
</table>