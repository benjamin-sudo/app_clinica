<style>
    .grid_perfil_usuario                    {
        display                             :  grid;
        grid-template-columns               :  65% 34%;
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
                    <label>RUN</label>
                    <input type="text" class="form-control" id="txtRut" disabled="" placeholder="RUN" style="width: 105px;" value="<?php echo $data_user[0]['USERNAME'];?>">
                </div>
                <div class="grid_datos_personales">
                    <div class="grid_datos_personales1"> 
                        <div class="form-group">
                            <label>NOMBRES</label>
                            <input type="text" class="form-control" id="txtNombresUsu" required="true" placeholder="NOMBRES" value="<?php echo $data_user[0]['FIRST_NAME'];?>">
                        </div>
                    </div>
                    <div class="grid_datos_personales4">
                        <div class="form-group">
                            <label>APELLIDO PATERNO</label>
                            <input type="text" class="form-control" id="txtApellidoP" required="true" placeholder="APELLIDO PATERNO" value="<?php echo $data_user[0]['MIDDLE_NAME'];?>">
                        </div>
                    </div>
                    <div class="grid_datos_personales5"> 
                        <div class="form-group">
                            <label>APELLIDO MATERNO</label>
                            <input type="text" class="form-control" id="txtApellidoM" required="true" placeholder="APELLIDO MATERNO" value="<?php echo $data_user[0]['LAST_NAME'];?>">
                        </div>
                    </div>
                </div>
                <div class="grid_datos_personales_2">
                    <div class="grid_datos_personales2"> 
                        <label>TELEFONO</label>
                        <div class="input-group">
                            <div class="input-group-addon" style="margin-top:7px;margin-right:4px;">+56 9</div>
                            <input type="text" class="form-control" id="txtFono" required="true" placeholder="TELEFONO" value="<?php echo $data_user[0]['TELEPHONE'];?>">
                        </div>
                    </div>
                    <div class="grid_datos_personales3"> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">E-MAIL</label>
                            <input type="email" class="form-control" id="txtCorreo" required="true" placeholder="EMAIL" style="text-transform: none;" value="<?php echo $data_user[0]['EMAIL'];?>">
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
            <div class="card-body class_card_firmaunica">
                <?php
                    $v_firma_simple = $data_user[0]['TX_INTRANETSSAN_CLAVEUNICA'];
                    if(is_null($v_firma_simple) or $v_firma_simple == ''){
                        echo $html_card_firmaunica = $this->load->view('Dashboard/html_sin_firmaunica',[],true);
                    } else {
                        echo $html_card_firmaunica = $this->load->view('Dashboard/html_firmaunica',['firma'=>$v_firma_simple],true);
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="grid_perfil_usuario4">&nbsp;
        <!--
            <i class="bi bi-google"></i>
            <br>
            <i class="bi bi-microsoft"></i>
        -->
    </div>
</div>


<!-- ZONA DE VARIABLE -->
<div class="info_userdata" data-userdata="<?php echo htmlspecialchars(json_encode($data_user),ENT_QUOTES,'UTF-8');?>"></div>
<input type="hidden" id="exFirm"    name="exFirm"       value="0">
<input type="hidden" id="username"  name="username"     value="<?php echo $username;?>">