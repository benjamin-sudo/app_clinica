<div class="row">
    <div class="col-md-12">
        <div class="form-group" style="text-align: center;">
            <label for="inputPass">Ingrese código de confirmación</label>
            <input type="text" class="form-control" id="codVerif" name="codVerif" required="true" placeholder="CÓDIGO" style="text-transform: none;text-align: center;font-size: 20px;" value="">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center" style="padding: 10px;">
        Tiempo de expiración 
        <b id="timeEx"><span id="minute">4</span>:<span id="second">08</span></b>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center" style="padding: 10px;">
        <a href="javascript:cambiaFirma()" class="btn btn-simple btn-facebook btn-sm"><i class="fa fa-send"></i> Volver a enviar correo de verificación</a>
    </div>
</div>

<div class="row">
    <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
    <button type="button" class="btn btn-success btn-fill" onclick="confirmCambioF()"><i class="fa fa-check"></i> Confirmar</button>
</div>
