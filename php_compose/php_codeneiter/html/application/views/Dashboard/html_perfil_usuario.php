<style>
    .grid_perfil_usuario                    {
        display                             :  grid;
        grid-template-columns               :  65% 35%;
        gap                                 :  8px;
    }
    .grid_datos_personales                  {
        display                             :  grid;
        grid-template-columns               :  1fr 1fr 1fr;
        gap                                 :  8px;
    }

    .grid_datos_personales_2                {
        display                             :  grid;
        grid-template-columns               :  1fr 2fr;
        gap                                 :  8px;
    }
</style>

<div class="grid_perfil_usuario">
    <div class="grid_perfil_usuario1">
        <div class="card">
            <div class="card-header"><b>INFORMACI&Oacute;N PERSONAL</b>/div>
            <div class="card-body">
                <div class="form-group">
                    <label>RUT</label>
                    <input type="text" class="form-control" id="txtRut" disabled="" placeholder="RUT" style="width: 140px;" value="">
                </div>
                <div class="grid_datos_personales">
                    <div class="grid_datos_personales1"> 
                        <div class="form-group">
                            <label>NOMBRES</label>
                            <input type="text" class="form-control" id="txtNombresUsu" required="true" placeholder="NOMBRES" value="">
                        </div>
                    </div>
                    <div class="grid_datos_personales4">
                        <div class="form-group">
                            <label>APELLIDO PATERNO</label>
                            <input type="text" class="form-control" id="txtApellidoP" required="true" placeholder="APELLIDO PATERNO" value="">
                        </div>
                    </div>
                    <div class="grid_datos_personales5"> 
                        <div class="form-group">
                            <label>APELLIDO MATERNO</label>
                            <input type="text" class="form-control" id="txtApellidoM" required="true" placeholder="APELLIDO MATERNO" value="">
                        </div>
                    </div>
                </div>
                <div class="grid_datos_personales_2">
                    <div class="grid_datos_personales2"> 
                        <label>TELEFONO</label>
                        <div class="input-group">
                            <div class="input-group-addon">+56 9</div>
                            <input type="text" class="form-control" id="txtFono" required="true" placeholder="TELEFONO" value="">
                        </div>
                    </div>
                    <div class="grid_datos_personales3"> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">E-MAIL</label>
                            <input type="email" class="form-control" id="txtCorreo" required="true" placeholder="EMAIL" style="text-transform: none;" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid_perfil_usuario2">
        <div class="card">
            <div class="card-header"><b>CAMBIO DE CONTRASE&Ntilde;A</b>div>
            <div class="card-body">
                <div class="form-group">
                    <label for="inputPass">CONTRASE&Ntilde;A ANTERIOR</label>
                    <input type="password" class="form-control" id="passOld" name="passOld" required="true" placeholder="PASSWORD ANTERIOR" style="text-transform: none;" value="">
                </div>
                <div class="form-group">
                    <label for="inputPass">NUEVA CONTRASE&Ntilde;A</label>
                    <input type="password" class="form-control" id="passNew1" name="passNew1" onblur="validaPassSegura()" required="true" placeholder="PASSWORD NUEVA" style="text-transform: none;" value="">
                    <input type="hidden" id="nivContr" value="Pobre">
                    <div id="meter1" style="display:none;">
                        <div class="entropizer-track"><div class="entropizer-bar" style="background-color: rgb(238, 17, 51); width: 0%;"></div><div class="entropizer-text">Pobre (0 bits)</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="grid_perfil_usuario">
    <div class="grid_perfil_usuario4">
        <div class="card">
            <div class="card-header"><b>FIRMA UNICA DIGITAL</b></div>
            <div class="card-body">
                <div class="col-md-12 text-center" id="miFirma">
                    Debe generar su Firma Digital Simple
                    <br>
                    <button type="button" class="btn btn-success btn-fill" onclick="nuevaFirma()">
                    <i class="fa fa-random" aria-hidden="true"></i> Generar Firma</button>                        
                </div>
            </div>
        </div>
    </div>
    <div class="grid_perfil_usuario4">&nbsp;</div>
</div>