<style>
    .grid_codigo_confitmacion               {
        display                             :  grid;
        grid-template-columns               :  1fr auto 1fr;
        gap                                 :  8px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="form-group" style="text-align: center;">
            <label for="inputPass">Ingrese c&oacute;digo de confirmaci&oacute;n</label>
            <input type="text" class="form-control" id="codVerif" name="codVerif" required="true" placeholder="CODIGO" style="text-transform: none;text-align: center;font-size: 20px;" value="">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center" style="padding: 10px;">
        Tiempo de expiraci&oacute;n 
        <b id="timeEx"><span id="minute">00</span>:<span id="second">00</span></b>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center" style="padding: 10px;">
        <a href="javascript:cambiaFirma()" class="btn btn-simple btn-facebook btn-sm"><i class="fa fa-send"></i> Volver a enviar correo de verificaci&oacute;n</a>
    </div>
    <input type="hidden" id="firmaNew1" name="firmaNew1" value="<?php echo $firma;?>"/>
</div>
<div class="grid_codigo_confitmacion">
    <div class="grid_codigo_confitmacion1">&nbsp;</div>
    <div class="grid_codigo_confitmacion1">
        <div class="input-group">
            <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
            <button type="button" class="btn btn-success btn-fill" onclick="confirmCambioF()"><i class="fa fa-check"></i>&nbsp;Confirmar</button>
        </div>
    </div>
    <div class="grid_codigo_confitmacion1">&nbsp;</div>
</div>