<style>
    .table {
        border-collapse :   collapse;
    }
</style>

<table class="table" style="border: none;">
    <tr>
        <td width="10%" style="text-align: center; vertical-align: top;">
            <?php echo $this->load->view('ssan_libro_biopsias_usuarioext/PDF_PROTOCOLOS/img64logo',[],true);?>
            <br>
        </td>
        <td width="35%" style="padding-left: 10px;">
            <h4 style="margin: 0; font-size: 16px;">DR. BOLIVAR LEE OLMOS</h4>
            <h4 style="margin: 0; font-size: 14px;">CENTRO MEDICO SIRESA</h4>
            <address style="font-size: 12px; line-height: 1.5;">
                FONO: PRAT 1130, 98244337
                <br>
                VICTORIA, REGI&Oacute;N DE LA ARAUCANIA - CHILE
                <br>
            </address>
        </td>
        <td width="30%" style="vertical-align: top; text-align: left; padding-left: 10px;"> 
            <h4 style="margin: 0; font-size: 16px;">INFORME DE CANCER</h4>
        </td>
        <td width="25%" style="vertical-align: top; text-align: left; padding-left: 10px;"> 
            <address style="font-size: 12px; line-height: 1.5;">
                <b>MEMO.:</b>&nbsp;N&deg; <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_NOF_CANCER'];?><br>
                <?php echo $empresa=='100'?'<b>ANGOL</b>':'<b>VICTORIA</b>'?>,<?php echo  $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FECHA_IMREPSION_INFORME'];?>
                <br>
                N&deg; DE PAGINA: <b><?php echo $num_page;?></b>
            </address>
        </td>
    </tr>
</table>

<table style="width: 100%">
    <tr>
        <td style="width: 50%">
            <table style="width: 100%">
                <tr>
                    <td style="width: 10%" valign="top"><b><p>DE</p></b></td>
                    <td style="width: 5%"  valign="top">:</td>
                    <td style="width: 85%">
                        <p><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_USER_PATOLOGO'];?></p>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><b><p>A</p></b></td>
                    <td valign="top">:</td>
                    <td>
                        <p> <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['PROFESIONAL'];?> </p>
                    </td>
                </tr>    
            </table>
        </td>
        <td style="width: 50%">&nbsp;</td>
    </tr>
</table>
<br>
<table style="width: 100%">
    <tr>
        <td style="width: 100%">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Junto con saludarle, comunico a Ud. que el paciente que se indica a continuaci&oacute;n tiene un diagn&oacute;stico de c&aacute;ncer, 
            por lo que solicito sea citado/a, a control para comunicarle el diagn&oacute;stico y tenga a la brevedad el tratamiento correspondiente</p>
        </td>
    </tr>
</table>
<br>
<table style="width: 100%;">
    <tr>
        <td>
            <p><b>
                <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NOMBRE_COMPLETO'];?>,
                <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_INTERNO_AP']=='0'?'':'N&deg; BIOPSIA: '.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_INTERNO_AP'];?> 
                <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] == 4?'-':'';?> 
                <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_CO_CITOLOGIA']==''?'':'N&deg; CITOL&Oacute;GICO: '.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_CO_CITOLOGIA'];?> 
                <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_CO_PAP']==''?'':'N&deg; PAP: '.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_CO_PAP'];?> 
                , Presenta un Diagn&oacute;stico de: <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIADNOSTICO_AP'];?>
                <?php if($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIAG_CITOLOGIA'] != ''){
                     echo ", ".$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIAG_CITOLOGIA'];
                    
                } ?>
            </b></p>
        </td>
    </tr>
</table>
<br>
<table style="width:100%">
    <tr>
        <td style="width: 50%">
            <p style="margin: 0px">Sin otro particular, saluda atentamente a Ud.</p> 
        </td>
        <td style="width: 50%">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <p style="margin: 0px">
            <b><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_USER_PATOLOGO'];?><br>
            <!--
            HOSPITAL&nbsp; <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_HOSPITAL_ETI'];?></b>
            -->
            <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_HOSPDERIVADO'];?>
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p style="margin: 0px">
                DISTRIBUCI&Oacute;N<br>
                <div style="margin-left: 10px">
                    - La Indicada<br>
                    - Archivo Anatom&iacute;a Patol&oacute;gica
                </div>
            </p>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>   