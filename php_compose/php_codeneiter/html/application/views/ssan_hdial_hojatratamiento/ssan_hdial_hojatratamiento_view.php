
<?php echo $ID_MAQUINA; ?>

<div class="grid_body_cabecera">
    <div class="grid_body_cabecera1">
        <h4 class="title" style="color:#e34f49;margin-left:20px;margin-bottom:10px;margin-left:30px;">
            <b>HOJA DE TRATAMIENTO HEMODI&Aacute;LISIS</b>
        </h4>
    </div>
    <div class="grid_body_cabecera2" style="text-align: -webkit-right;">
        <button type="button" class="btn btn-danger btn-fill" id="BTN_UPDATE_PANEL_2" onclick="test_ws()" style="display: none">
            WS
        </button>
        <button type="button" class="btn btn-success btn-fill" id="BTN_UPDATE_PANEL_3" onclick="UPDATE_PANEL()" style="margin-right: 24px;">
            <i class="bi bi-arrow-up-square-fill"></i>
        </button>
    </div>
</div>
<div class="grid_heard_hoja_tratamiento">
    <div class="grid_heard_hoja_tratamiento1">
        <div class="card" style="margin-bottom:0px;padding:11px;">
            <div class="header">
                <h4 class="title"><b class="plomo">FECHA DE HEMODI&Aacute;LISIS</b></h4>
            </div>
            <div class="content">
                <div class="contenedor">
                    <input type="date" class="form-control" id="numFecha" name="numFecha" value="<?php echo date("Y-m-d");?>" min="<?php echo date("Y-m-d", strtotime("-30 years"));?>" max="<?php echo date("Y-m-d");?>" style="width: 134px;">
                </div>
            </div>
        </div>
    </div>
    <div class="grid_heard_hoja_tratamiento2">
        <div class="card" style="margin-bottom:0px;padding:11px;">
            <div class="header">
                <h4 class="title"><b class="plomo">MAQUINA HEMODI&Aacute;LISIS</b></h4>
            </div>
            <div class="content">
                <div class="contenedor">
                    <select id="num_Maquina" name="num_Maquina" class="form-control input-sm" onchange="eventosBuscar(this.value)">
                        <?php
                            if (count($arr_maquinas)>0){
                                foreach($arr_maquinas  as $i => $row){
                                    echo '<option value="'.$row['ID'].'"> '.$row['NOMDIAL'].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="grid_heard_hoja_tratamiento3">
        <div class="card" style="margin-bottom:0px;padding:11px; display:none;">
            <div class="header">
                <h4 class="title"><b class="plomo">FECHA ESPECIAL</b></h4>
            </div>
            <div class="content">
                <div class="contenedor">
                <select id="op_fecha_especial" name="op_fecha_especial" class="form-control input-sm" style="width: 300px" onchange="cargaPacientes(this.value)">
                        </select> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid_contenedor_hojas">
    <div class="grid_contenedor_hojas1">
        <div class="card" style="margin-bottom:0px">
            <div class="card-header">
                <div class="header">
                    <div class="grid_panel_hojasdiarias">
                        <div class="grid_panel_hojasdiarias1">
                            <h4 class="title"><b class="plomo"> <i class="bi bi-person-square"></i>&nbsp;&nbsp;HOJA/S DIARIAS DISPONIBLES</b></h4>
                        </div>
                        <div class="grid_panel_hojasdiarias2">
                           <div id="fecha_busqueda"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <table class="table table-hover table-striped" style="margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th>HORA</th>
                            <th>PACIENTE</th>
                            <th>F.NACIMIENTO</th>
                            <th>N&deg; INGRESO</th>
                            <th>ESTADO</th>
                            <th class="text-center">OPCIONES</th>
                        </tr>
                    </thead>
                    <tbody id="maquina_1">
                        <tr>
                            <td colspan="6">
                                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only"></span>&nbsp;&nbsp;<b>CARGANDO PACIENTE ...</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<section>

   

    <div class="modal fade" id="TURNO_REACIONESADVERSAS">
        <div class="modal-dialog modal-xl3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><b>FORMULARIO DE REACIONES ADVERSAS</b></h4>
                </div>
                <div class="modal-body" id="BODY_ADVERSAS"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm btn-fill btn-wd" data-dismiss="modal"> <i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA (NO GRABA)</button>
                </div>
            </div>
        </div>
    </div>

   

    <div class="modal fade" id="MODAL_PDF">
        <div class="modal-dialog class_modal_pdf">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><b>PDF</b></h3>
                </div>
                <div class="modal-body" id="PDF_HTML"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm btn-fill btn-wd" data-dismiss="modal"> <i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_TOMADESIGNO">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><b>TOMA DE SIGNOS</b></h3>
                </div>
                <div class="modal-body" id="BODY_TOMASIGNO"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm btn-fill btn-wd" data-dismiss="modal"> <i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA </button>
                    <button type="button" class="btn btn-info btn-sm btn-fill btn-wd" id="BTN_GSIGNOS"> <i class="fa fa-check-square-o" aria-hidden="true"></i> GUARDAR SIGNOS VITALES </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_CIERREHERMO">
        <div class="modal-dialog modal_PREINICIO">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><b>CIERRE HEMODIALISIS</b></h3>
                </div>
                <div class="modal-body" id="BODY_CIERREHERMO"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm btn-fill btn-wd" data-dismiss="modal"> <i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA </button>
                    <button type="button" class="btn btn-success btn-sm btn-fill btn-wd" id="BTN_CIERREHERMO"> <i class="fa fa-floppy-o" aria-hidden="true"></i> TERMINO HERMODIALISIS </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_HD_ANTERIORES">
        <div class="modal-dialog modal_ANTERIORES">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-title"><b>- HIST&Oacute;RICO DE HOJA DIARIA </b></h3></div>
                <div class="modal-body" id="BODY_HD_ANTERIORES"></div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="busquedaMes"c></div>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-danger btn-sm btn-fill btn-wd" data-dismiss="modal"> <i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MODAL_EXM_ANTERIORES">
        <div class="modal-dialog modal_ANTERIORES">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-title"><b>- RESUMEN SOLICITUD DE EXAMENES</b></h3></div>
                <div class="modal-body" id="BODY_EXM_ANTERIORES"></div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="busquedaMes_EXM"></div>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-danger btn-sm btn-fill btn-wd" data-dismiss="modal"> <i class="fa fa-window-close-o" aria-hidden="true"></i> CIERRA VENTANA </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal deputado -->
    <div class="modal fade" id="MODAL_INICIODIALIS">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">INICIO TRATAMIENTO</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="HTML_INICIODEDIALISIS"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;</button>
                    <button type="button" class="btn btn-primary btn-fill btn-wd" id="BTN_INICIO"><i class="bi bi-floppy"></i>&nbsp;GUARDAR INFORMACI&Oacute;N</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="MODAL_HORADIARIA" data-hojaactiva="">
        <div class="modal-dialog modal-95">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><b style="color:#e34f49">HOJA DE TRATAMIENTO</b></h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="HTML_TRATAMIENTO"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i>&nbsp;&nbsp;CERRAR&nbsp;VENTANA&nbsp;</button>
                </div>
            </div>
        </div>
    </div>
    <!--  ZONA INPUT HOJA DE TRATAMIENTO -->
    <input type="hidden" name="id_templete" id="id_templete" value="2"/>
    <input type="hidden" id="TOKEN_PDF" name="TOKEN_PDF" value="<?php echo $TOKEN_SESSION;?>"/>
    <input type="hidden" id="TOKEN_ONE" name="TOKEN_ONE" value="<?php echo $TOKEN_ONE;?>"/>
    <input type="hidden" id="empresa" name="empresa" value="<?php echo $this->session->userdata("COD_ESTAB");?>">
    <input type="hidden" id="cod_empresa" name="cod_empresa" value="<?php echo $this->session->userdata("COD_ESTAB");?>">
    <div class= "info_userdata" data-userdata="<?php echo htmlspecialchars(json_encode($this->session->userdata),ENT_QUOTES,'UTF-8');?>"></div>
    <form id="actualizacion_hoja_diaria" method="post" action="#"></form>

</section>
