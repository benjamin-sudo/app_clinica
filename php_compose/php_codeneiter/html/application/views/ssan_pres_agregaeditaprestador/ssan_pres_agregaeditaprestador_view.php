<div class="grid_titulo_presta">
    <div class="grid_titulo_presta1"> 
        <h4 class="title" style="color:#e34f49;margin:0px;margin-left:12px;">
            <i class="fa fa-address-book" aria-hidden="true"></i>&nbsp;<b>AGREGA EDITA PRESTADOR | VERIFICAR EN P&Aacute;GINA RNPI SUPER DE SALUD</b>
        </h4>
    </div>
    <div class="grid_titulo_presta2">&nbsp;</div>
</div>

<div class="content">
    <form id="" action="" method="">
        <input type="hidden" id="username"  name="username" value="<?php echo $usu_ario;?>">
        <input type="hidden" id="token"     name="token"    value="<?php echo $tok_G;?>">
        <input type="hidden" id="codemp"    name="codemp"   value="<?php echo $em_presa;?>">
        <div>
            <div id="respuesta1" class="form-group"></div>
            <table class="table table-responsive">
                <tr>
                    <td>
                        <div class="form-group">
                            <span style="color: #FF9800;">* </span> <label class="control-label">RUN</label>
                            <input type="text" name="rutPac" id="rutPac" class="form-control" onkeyup="return NumGuion();" maxlength="12" required>
                        </div>
                    </td>
                    <td valign="bottom">
                        <a href="javascript:buscar_prestador(); " class="btn btn-primary btn-fill" style="margin-top:30px;">
                            <i class="fa fa-search"></i>&nbsp;BUSCAR&nbsp;PRESTADOR
                        </a>
                    </td>
                    <td>
                        <a href="https://rnpi.superdesalud.gob.cl/#" target="_blank" class="btn btn-info btn-fill" style="margin-top:30px;">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;VISITAR RNPI SUPER DE SALUD
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <span style="color: #FF9800;">* </span><label class="control-label">NOMBRES</label>
                            <input type="text" class="form-control" style="text-transform: uppercase;" id="nombres" onkeypress="return soloLetras(event);" name="nombres" type="text" required>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <span style="color: #FF9800;">* </span> <label class="control-label">APELLIDO PATERNO</label>
                            <input class="form-control" style="text-transform: uppercase;" name="appat" onkeypress="return soloLetras(event);" id="appat" maxlength="12" type="text" required>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <span style="color: #FF9800;">* </span> <label class="control-label">APELLIDO MATERNO</label>
                            <input class="form-control" style="text-transform: uppercase;" name="apmat" onkeypress="return soloLetras(event);" id="apmat" type="text" required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="respuesta" class="form-group">
                            <span style="color: #FF9800;">* </span><label class="control-label">TIPO PROFESIONAL</label>
                            <select class="form-control" name="tprof" id="tprof" onchange="CARGAPROF();" required>
                            <option>SELECCIONE EL TIPO DE PROFESIONAL</option>
                            <?php
                                if (count($arr_tipos)>0){
                                    foreach ($arr_tipos as $i => $val) {
                                        echo '<option value="' . $val['IND_TIPOATENCION'] . '"> ' . $val['DES_TIPOATENCION'] . '</option>';
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="form-group">
                            <span style="color: #FF9800;">* </span><label class="control-label">PROFESIONAL</label>
                            <select class="form-control" name="prof" id="prof" onchange="" required></select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <span style="color: #FF9800;">* </span> <label class="control-label">CORREO ELECTR&Oacute;NICO</label>
                            <input class="form-control minusc" style="text-transform: uppercase;" name="email" onkeypress="return soloEmail(event);" id="email" type="email" required>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <span style="color: #FF9800;">* </span> <label class="control-label">TELEFONO</label>
                            <input class="form-control" style="text-transform: uppercase;" name="telefono" onkeypress="return soloNumeros(event);" id="telefono" type="text" maxlength="12" required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:center;">
                        <a href="javascript:limpiar()" class="btn btn-danger btn-fill"><i class="fa fa-eraser"></i> Limpiar</a>
                        <a href="javascript:prestador()" class="btn btn-success btn-fill"><i class="fa fa-user-plus"></i> Grabar Prestador</a>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>

<section>
    <div class="modal fade" id="modalSuper" tabindex="-1" style="text-align: center;">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #e34f49;">Superintendencia de Salud</h5>
                </div>
                <div class="modal-body" id="respSuper"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</section>
