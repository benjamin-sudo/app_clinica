<style>
    .grid_bdu_infomacion                {
        display                             :   grid;
        grid-template-columns               :   1fr;
        gap                                 :   8px;
    }
</style>
<div class="card">
    <div class="card-header">
        <b>PACIENTE HEMODI&Aacute;LISIS</b>
        <br>
        <i>Informaci&oacute;n b&aacute;sica</i>
    </div>
    <div class="card-body" style="padding: 5px;">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td colspan="2">
                        <small><b style="color:#888888;">NOMBRE DEL PACIENTE</b></small><br>
                        <small class="text-muted" id="nombreLabel"><?php echo $info_bdu[0]['NOMBREPAC'].' '.$info_bdu[0]['APEPATPAC'].' '.$info_bdu[0]['APEMATPAC'] ;?></small>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small><b style="color:#888888;">RUN</b></small><br>
                        <small class="text-muted" id="rutLabel"><?php echo $info_bdu[0]['RUTPAC'].' '.$info_bdu[0]['COD_DIGVER'];?></small>
                    </td>
                    <td>
                        <small><b style="color:#888888;">SEXO</b></small><br>
                        <small class="text-muted" id="rutLabel"><?php echo $info_bdu[0]['TIPO_SEXO'];?></small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <small><b style="color:#888888;">F.&nbsp;NACIMIENTO</b></small><br>
                        <small class="text-muted" id="rutLabel"><?php echo $info_bdu[0]['FECHANACTO'];?></small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <small><b style="color:#888888;">N°&nbsp;FICHA LOCAL</b></small><br>
                        <small class="text-muted" id="rutLabel">0</small>
                    </td>
                </tr>
                <tr> 
                    <td colspan="2">
                        <small><b style="color:#888888;">PREVISI&Oacute;N</b></small><br>
                        <small class="text-muted" id="rutLabel">NO INFORMADO</small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<input type="hidden"  id="num_fichae" name="num_fichae" value="<?php echo $info_bdu[0]['NUM_FICHAEPACTE'];?>"/>

<!-- NUM_FICHAE -->
