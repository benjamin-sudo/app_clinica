<div class="alert alert-warning" role="alert" style="margin: 0; margin-bottom: 9px; color: white;">
    <i class="fa fa-info-circle" style="font-size: 22px; color: white;" aria-hidden="true"></i>
    &nbsp;&nbsp;Debe generar su firma &uacute;nica digital para actualizar la informaci&oacute;n previamente asignada<br>
    La firma debe tener un largo minimo de 6 caracteres y contener n&uacute;meros y letras.
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="inputPass">NUEVA FIRMA</label>
        <input type="password" class="form-control" onblur="validaExFirm()" id="firmaNew1" name="firmaNew1" required="true" placeholder="NUEVA FIRMA" style="text-transform: none;" value="" maxlength="8">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="inputPass">REPETIR NUEVA FIRMA</label>
        <input type="password" class="form-control" id="firmaNew2" name="firmaNew2" required="true" placeholder="REPETIR NUEVA FIRMA" style="text-transform: none;" value="" maxlength="8">
    </div>
</div>
<div class="col-md-12" style="text-align: -webkit-center;">
    <button type="button" class="btn btn-success btn-fill" id="btnFS" onclick="cambiaFirma()">
        <i class="fa fa-save" aria-hidden="true"></i>&nbsp;Confirmar
    </button>
</div>
