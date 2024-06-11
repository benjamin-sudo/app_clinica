h4 class="title" style="color:#e34f49;margin-left:13px;margin-bottom:10px">
    <b>INFORMACI&Oacute;N ANATOM&Iacute;A PATOL&Oacute;GICA | ADMINISTRATIVO</b>
</h4>
<hr style="margin: 0px 0px 0px 0px">
<div class="grid_main_panel">
    <div class="grid_main_panel1">
        <ul role="tablist" class="nav nav-tabs tabs_filtro_busqueda" role="menu">
            <li role="presentation" style="cursor:pointer;">
                <a data-toggle="tab" href="#_panel_por_fecha"   class="_panel_por_fecha" data-titulo="B&Uacute;SQUEDA POR RANGO DE FECHAS" data-zona_li="busqueda_por_fecha"><i class="fa fa-calendar" aria-hidden="true"></i></a>
            </li>
            <li role="presentation" style="cursor:pointer;">
                <a data-toggle="tab" href="#_panel_por_gestion" class="_panel_por_gestion" data-titulo="B&Uacute;SQUEDA POR GESTI&Oacute;N" data-zona_li="busqueda_por_gestion"><i class="fa fa-th-list" aria-hidden="true"></i></a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="_panel_por_fecha" class="tab-pane fade" style="padding: 6px;">
                <div class="card" style="margin-bottom:6px;">
                    <div class="header" style="margin-bottom:15px;">
                        <h5 class="title">
                            <h5 class="title">
                                <i class="fa fa-calendar" style="color:#888888;" aria-hidden="true"></i>&nbsp;
                                <b style="color:#888888;">FECHA INICIO</b>
                            </h5>
                        </h5>
                    </div>
                    <div class="content" style="margin-top:-18px;"> 
                        <div style="overflow:hidden;">
                            <div class="form-group d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom:-20px;">
                                        <div id="fecha_out"></div>
                                    </div>
                                    <div class="col-md-12 LOAD_CALENDARIO" id="LOAD_CALENDARIO">
                                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                                        <span class="sr-only">Cargando ...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="margin-bottom: 0px;">
                    <div class="header" style="margin-bottom: 15px;">
                        <h5 class="title">
                            <i class="fa fa-calendar" style="color:#888888;" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">FECHA FIN</b>
                        </h5>
                    </div>
                    <div class="content" style="margin-top:-18px;"> 
                        <div style="overflow:hidden;">
                            <div class="form-group d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom:-20px;">
                                        <div id="fecha_out2"></div>
                                    </div>
                                    <div class="col-md-12 LOAD_CALENDARIO" id="LOAD_CALENDARIO2">
                                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="_panel_por_gestion" class="tab-pane fade">
                <ul class="list-group list-group-flush ">
                    <li class="list-group-item active" role="button" data-toggle="collapse" data-parent="#panel_altrapriopidad" href="#panel_altrapriopidad" aria-expanded="true" aria-controls="collapseOne">
                        <div class="grid_li_panel_central">
                            <div class="grid_li_panel_central1">Finalizadas</div> 
                            <div class="grid_li_panel_central2" style="text-align:end">
                                <i id="icono_panel_altrapriopidad" class="fa fa-sort-desc" aria-hidden="true" style="cursor:pointer;color:#fff;"></i>
                            </div> 
                        </div>
                    </li>
                    <div id="panel_altrapriopidad" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <li class="list-group-item" style="cursor:pointer;">
                            <div class="grid_li_panel_central">
                                <div class="grid_li_panel_central1">Rechazadas</div>
                                <div class="grid_li_panel_central2" style="text-align: -webkit-right;">
                                    <input type="checkbox" id="cbox1" value="first_checkbox" style="display:block;" checked>
                                </div>
                            </div>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </div>
    <div class="grid_main_panel2">
        <b>LISTADO PANEL PRINCIPAL</b> 
    </div>
</div>
<div 
    class               =   "info_userdata" 
    data-fecha_inicio   =   "<?php echo date("m/d/Y",$date_inicio);?>"
    data-fecha_final    =   "<?php echo date("m/d/Y",$date_final);?>"
    data-userdata       =   "<?php echo htmlspecialchars(json_encode($this->session->userdata),ENT_QUOTES,'UTF-8');?>"
></div>