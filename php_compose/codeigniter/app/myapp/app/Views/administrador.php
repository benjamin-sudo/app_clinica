<?= $this->extend('base');?>
<?= $this->section('content');?>

<div class="grid_cabecera">
    <div class="grid_cabecera1">
        <h4 class="title" style="color:#e34f49;">
            <i class="fa fa-tag" aria-hidden="true"></i>&nbsp;&nbsp;<b>ADMINISTRADOR APP CLINICA </b>
        </h4>
    </div>
    <div class="grid_cabecera2">
        <!--
        <button type="button" class="btn btn-success" onclick="test(0)">
            <i class="fa fa-database" aria-hidden="true"></i> TEST 1
        </button>
        <button type="button" class="btn btn-success" onclick="test(1)">
            <i class="fa fa-database" aria-hidden="true"></i> VALIDACION DE PACIENTE
        </button>
        -->
    </div>
</div>

<div class="content">
    <ul class="nav nav-tabs menu_principal" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="bi bi-1-circle-fill"></i>&nbsp;INICIO</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="bi bi-2-circle-fill"></i>&nbsp;GESTI&Oacute;N DE EXTENSIONES</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="bi bi-3-circle-fill"></i>&nbsp;GESTI&Oacute;N DE PRIVELIGIOS</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#gusuarios" type="button" role="tab" aria-controls="gusuarios" aria-selected="false"><i class="bi bi-4-circle-fill"></i>&nbsp;GESTI&Oacute;N DE USUARIOS</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h4 class="title" style="color:#e34f49;margin-top:10px;">  <i class="fa fa-cog" aria-hidden="true"></i><b>&nbsp;INICIO</b></h4>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <h4 class="title" style="color:#e34f49;margin-top:10px;">
                <i class="fa fa-cog" aria-hidden="true"></i><b>&nbsp;GESTI&Oacute;N DE EXTENSIONES</b>
            </h4>

            <div class="grid_body_extensiones">
                <div class=" grid_body_extensiones1">
                    <?php echo $respuesta['html']; ?>
                </div>
                <div class="grid_body_extensiones1 card">
                    <table class="table table-striped" style="margin-bottom: 0px;">
                        <tr>
                            <td width="250px"><b>NOMBRE DEL MEN&Uacute;</b></td>
                            <td>
                                <div class="div_2">
                                    <div class="div_21"><input type="text" id="nomExt" onkeypress="return soloLetras(event)" class="form-control form-control-sm;" style="text-transform: inherit;width: 220px;" onblur="validaExt()"> </div>
                                    <div class="div_21">
                                    <input type="checkbox" id="habilitado" name="habilitado" value="1" checked style="display: inline;"> Menú Habilitado </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="200px"><b>NOMBRE EXTENSI&Oacute;N</b> </td>
                            <td>
                                <input type="text" id="nomArch" class="form-control form-control-sm;" onkeypress="return alfanumericoRuta(event)" style="text-transform: lowercase;width: 220px;" onblur="buscaExtArch();">
                                <input type="hidden" id="existeExt" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td><b>EXTENSI&Oacute;N PRINCIPAL O PADRE</b> </td>
                            <td>
                                <?php
                                    echo view("html_administrador", ['menu_principal' => $respuesta['menu_principal']]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>PERMISOS</b></td>
                            <td>
                                <ul class="list-group">
                                    <?php if (count($respuesta['roles_creados'])>0){ 
                                        foreach ($respuesta['roles_creados'] as $i => $row){ ?>
                                        <li class="list-group-item  ">
                                            <div class="grid_li_permisos">
                                                <div class="grid_li_permisos2">
                                                    <input 
                                                        type    = "checkbox" 
                                                        class   = "form-check-input checked_id"
                                                        id      = "ck_permiso_<?php echo $row->PER_ID;?>" 
                                                        name    = "ck_permiso"
                                                        style   = "display: block;cursor: pointer;margin-top: 0px;margin-bottom: -1px;"
                                                        value   = "<?php echo $row->PER_ID;?>">
                                                </div>   
                                                <div class="grid_li_permisos1">
                                                    <?php echo $row->PER_NOMBRE;?>
                                                </div>   
                                            </div>   
                                        </li>
                                    <?php } }?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center">
                                <a class="btn btn-small btn-success btn-fill" href="#" id="grabarExt" onclick="grabarExt(0);" style="color:#fff;"><i class="fa fa-save fa-large" id="iconBtn"></i><span id="nomBTN">&nbsp;CREAR EXTENSI&Oacute;N</span></a>
                                &nbsp;&nbsp;
                                <a class="btn btn-small btn-danger btn-fill" href="javascript:js_limpia_panel()" style="color:#fff;"><i class="fa fa-times fa-large" id="iconBtn"></i> <span id="nomBTN">CANCELAR</span></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <h4 class="title" style="color:#e34f49;margin-top:10px;">
                <i class="fa fa-cog" aria-hidden="true"></i><b>&nbsp;GESTI&Oacute;N DE PRIVILEGIOS</b>
            </h4>
            <hr style="margin: 8px 8px 8px 0px;">
            <div class="grid_body_privilegios">
                <div class="grid_body_privilegios1"> 
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Crear Privilegios</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Nombre Nuevo Privilegio:</h6>
                            <input type="text" id="nomProv" class="form-control" style="margin-bottom:10px;"> 
                            <button type="button" class="btn btn-primary btn-sm" onclick="crearPriv();">
                                <i class="fa-solid fa-floppy-disk"></i> Crear Privilegio
                            </button>
                        </div>
                    </div>
                </div>
                <div class="grid_body_privilegios2"> 

                    <ul class="list-group">
                        <?php if (count($respuesta['roles_creados'])>0){ 
                            foreach ($respuesta['roles_creados'] as $i => $row){ ?>
                            <li class="list-group-item  ">
                                <div class="grid_li_permisos2">
                                    <div class="grid_li_permisos_1">
                                        <p class="h6"><?php echo $i+1;?></p>
                                    </div>   
                                    <div class="grid_li_permisos_2">
                                        <p class="lead"><?php echo $row->PER_NOMBRE;?></p>    
                                    </div>
                                    <div class="grid_li_permisos_3">
                                        <i class="bi bi-2-circle-fill"></i>
                                    </div>
                                    <div class="grid_li_permisos_4">
                                        <div class="form-check form-switch">
                                            <input 
                                                type    =   "checkbox" 
                                                role    =   "switch" 
                                                class   =   "form-check-input" 
                                                style   =   "width: 4em;height: 2em;" 
                                                id      =   "<?php echo $row->PER_ID;?>"
                                                onclick =   "js_estado_r(this.id)"
                                                <?php echo $row->PER_ESTADO==0?'':'checked';?>>
                                            <label class="form-check-label" for="sw_<?php echo $row->PER_ID;?>">
                                                <p style="margin-left: 10px;" class="h6">DESACTIVADO/ACTIVADO</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>   
                            </li>
                        <?php } }?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="gusuarios" role="tabpanel" aria-labelledby="contact-tab">

            <h4 class="title" style="color:#e34f49;margin-top:10px;margin-bottom:12px;">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <b>&nbsp;GESTI&Oacute;N DE USUARIOS</b>
            </h4>

            <div class="grid_body_gestionususarios">
                <div class="grid_body_gestionususarios1"> 
                    <div class="card grid_clave_esissan" style="width:30em">
                        <div class="grid_clave_esissan3">
                            <h5 class="card-title"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<b>RUN USUARIO</b></h5>
                        </div>
                        <div class="grid_clave_esissan3">&nbsp;</div>
                        <div class="grid_clave_esissan3">&nbsp;</div>
                        <div class="grid_clave_esissan1"> 
                            <input type="text" id="run_esissan" name="run_esissan" class="form-control" style="width:auto;" onkeypress="validar(event)">
                        </div>
                        <div class="grid_clave_esissan2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm" id="btn_valida_profesional" onclick="valida_run_esissan(0)">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-smclass_input_cuenta" id="btn_volver_atras">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="grid_clave_esissan3">&nbsp;</div>
                    </div>

                    <table class="card table table-striped" style="width:100%;">
                       <tbody>
                            <tr style="height: 36px;">
                                <th scope="col" colspan="2">
                                    <div class="grid_info_usuarios">
                                        <div class="grid_info_usuarios1">Datos del Usuario</div>
                                        <div class="grid_info_usuarios5 class_superusuario" style="display:none">&nbsp;Super Usuario&nbsp;</div>
                                        <div class="grid_info_usuarios4 class_superusuario" style="display:none"><input type="checkbox" id="checkTipo" class="class_checkbox" style="display: block;margin-top: 0px;" disabled></div>
                                        <div class="grid_info_usuarios3">&nbsp;Habilitado&nbsp;</div>
                                        <div class="grid_info_usuarios2"><input type="checkbox" id="CheckboxUsu" class="class_checkbox" style="display: block;margin-top: 0px;" disabled> </div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th style="width: 54%;" scope="row" >Nombres</th>
                                <td style="width: 50%;"><input type="text" id="txtNombres" onkeypress="return soloLetras(event);" class="form-control input-sm class_input_cuenta"></td>
                            </tr>
                            <tr>
                                <th scope="row">Apellido Paterno</th>
                                <td><input type="text" id="txtApePate" onkeypress="return soloLetras(event);" class="form-control input-sm class_input_cuenta"></td>
                            </tr>
                            <tr>
                                <th scope="row">Apellido Materno</th>
                                <td><input type="text" id="txtApeMate" onkeypress="return soloLetras(event);" class="form-control input-sm class_input_cuenta"></td>
                            </tr>
                            <tr>
                                <th scope="row">Correo Electr&oacute;nico</th>
                                <td><input type="text" id="txtEmail" onkeypress="return soloEmail(event);"  class="form-control input-sm class_input_cuenta" style="text-transform: none;"></td>
                            </tr>
                            <tr style="height: 36px;">
                                <th scope="col" colspan="2">
                                    <div class="grid_nueva_contraena">
                                        <div class="grid_nueva_contraena1">Contrase&ntilde;a de Acceso</div>
                                        <div class="grid_nueva_contraena2">
                                            <label style="margin-bottom: 0px;" for="ind_actualiza_pass" id="txt_acceso_contraena">Reiniciar contrase&ntilde;a</label>
                                        </div>
                                        <div class="grid_nueva_contraena3 check_contrasena">
                                            <input type="checkbox" id="ind_actualiza_pass" name="ind_actualiza_pass" class="class_checkbox" style="display: block;margin-top: 0px;" disabled>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th scope="row">Nueva Contrase&ntilde;a:</th>
                                <td><input type="password" id="txtPass" onkeypress="return alfanumerico(event);" onblur="validaPass()" class="form-control input-sm class_input_pass"></td>
                            </tr>
                            <tr>
                                <th scope="row">Repetir Contrase&ntilde;a:</th>
                                <td><input type="password" id="txtPassRep" onkeypress="return alfanumerico(event);" onblur="validaPass2()" class="form-control input-sm class_input_pass"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <div class="grid_body_gestionususarios2">
                    <div class="card" style="margin-bottom: 10px;">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-hashtag" aria-hidden="true"></i>&nbsp;<b>B&Uacute;SQUEDA DE PRIVILEGIOS&nbsp;</b></h5>
                            <select class="selectpicker" name="destinoPriv" id="destinoPriv" data-width="100%" data-container="body" data-selected-text-format="count" data-live-search="true" multiple  title="Seleccione privilegios..." onchange="js_reload_previlegios(this)">
                                <?php if (count($respuesta['roles_creados'])>0){ 
                                foreach ($respuesta['roles_creados'] as $i => $row){ ?>
                                    <option value="<?php echo $row->PER_ID;?>"><?php echo $row->PER_NOMBRE;?></option>
                                <?php } }?>
                            </select>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom: 10px;">
                        <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa fa-hashtag" aria-hidden="true"></i>&nbsp;<b>PRIVILEGIOS ASIGNADOS AL USUARIO&nbsp;</b>
                            <br>
                            <small class="text-muted">With faded secondary text</small>
                        </h5>
                        
                                    
                            <ol class="list-group list-group-numbered">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                    <div class="fw-bold">Subheading</div>
                                        Cras justo odio
                                    </div>
                                    <span class="badge bg-primary rounded-pill">3</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                    <div class="fw-bold">Subheading</div>
                                        Cras justo odio
                                    </div>
                                    <span class="badge bg-primary rounded-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                    <div class="fw-bold">Subheading</div>
                                        Cras justo odio
                                    </div>
                                    <span class="badge bg-primary rounded-pill">0</span>
                                </li>
                            </ol>


                        </div>
                    </div>    
                </div>  
                <div class="grid_body_gestionususarios3"> 
                    <div class="card" style="margin-bottom: 10px;">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<b>ESTABLECIMIENOS ASIGNADOS&nbsp;</b></h5>
                            <select class="selectpicker" name="establecimiento" id="establecimiento" data-width="100%" data-container="body" data-selected-text-format="count" data-live-search="true" multiple  title="Seleccione establecimientos..." onchange="js_reload_previlegios(this)">
                                <?php if (count($respuesta['arr_empresas'])>0){ 
                                foreach ($respuesta['arr_empresas'] as $i => $row){ ?>
                                    <option value="<?php echo $row['COD_EMPRESA'];?>"><?php echo $row['NOM_RAZSOC'];?></option>
                                <?php } }?>
                            </select>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</div>

<?php
    #var_dump($respuesta['arr_empresas']);
?>

<?php
    /*
    echo current_url();
    echo "<br>";
    echo $_SERVER['REQUEST_URI'];
    echo "<br>";
    echo $_SERVER['PHP_SELF'];
    */
    //echo "<br>";
    /*
    echo APPPATH;
    echo "<br>";
    echo __DIR__;
    echo "<br>";
    echo __FILE__;
    echo "<br>";
    echo APPPATH."Controllers";
    echo "<br>";
    */
    //$parentPath = dirname(APPPATH);
    //echo $parentPath;
?>
<?php
/*
if (file_exists(APPPATH."Controllers")) {
    echo "Existe";
} else {
    echo "No existe";
}
*/
?>
<?= $this->endSection() ?>