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
            <div class="card-header"><b>INFORMACI&Oacute;N PERSONAL</b></div>
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
                            <div class="input-group-addon" style="margin-top:7px;margin-right:4px;">+56 9</div>
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
            <div class="card-header"><b>CAMBIO DE CONTRASE&Ntilde;A</b></div>
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
                <div class="alert alert-warning" role="alert" style="margin: 0; margin-bottom: 9px; color: white;">
                    <i class="fa fa-info-circle" style="font-size: 22px; color: white;" aria-hidden="true"></i>
                    &nbsp;&nbsp;&nbsp; Debe generar su firma &uacute;nica digital para actualizar la informaci&oacute;n previamente asignada
                    <br>
                    La firma debe tener un largo minimo de 6 caracteres y contener números y letras.
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
                <button type="button" class="btn btn-success btn-fill" id="btnFS" onclick="cambiaFirma()"><i class="fa fa-save" aria-hidden="true"></i> 
                    Confirmar
                </button>
            </div>
        </div>
    </div>
    <div class="grid_perfil_usuario4">&nbsp;

        <i class="bi bi-google"></i>
        <br>
        
        <i class="bi bi-microsoft"></i>
        <br>



    </div>
</div>

<!-- ZONA DE VARIABLE -->
<input type="hidden" id="exFirm"    name="exFirm"       value="0">
<input type="hidden" id="username"  name="username"     value="<?php echo $username;?>">