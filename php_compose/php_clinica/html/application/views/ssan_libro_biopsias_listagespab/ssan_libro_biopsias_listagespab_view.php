<script>$("#loadFade").modal("show");</script>

<input type="hidden" id="NUM_FASE"          name="NUM_FASE"         value="1"/>
<input type="hidden" id="IND_FROM"          name="IND_FROM"         value="GESPAB"/>
<input type="hidden" id="empresa"           name="empresa"          value="<?php echo $this->session->userdata("COD_ESTAB");?>"/>
<input type="hidden" id="TIPO_PABELLON"     name="TIPO_PABELLON"    value="1"/>
<input type="hidden" id="ZONA_PABELLON"     name="ZONA_PABELLON"    value="CE"/>

<div class="header" style="padding-top:0;">
    <h4 class="title" style="color:#e34f49;margin-bottom:10px;">
        <b>GESTI&Oacute;N DE SOLICITUD DE ANATOM&Iacute;A PATOL&Oacute;GICA -  PABELL&Oacute;N CENTRAL - TNS</b>
    </h4>
</div>

<hr style="margin:0px 0px 0px 0px">

<div id="panel_central" class="CSS_GRID_HEARD">
    <div class="CSS_GRID_HEARD_ROW1">&nbsp;</div>
    
    <div class="row_calendar2">
        <!-- style="position:absolute;left:50%;" -->
        <div class="form-group _CENTER">
            <fieldset class="fieldset_local">
                <legend class="legend">FECHA</legend>
                <div id="date_tabla" class="input-group row_calendar" style="width:140px;padding:6px;">
                    <input type="text" class="form-control input-sm" value="<?php echo $DATE_DESDE;?>" id="numFecha" name="numFecha"/>
                    <span class="input-group-addon" style="cursor:pointer;"><span class="fa fa-calendar"></span></span>
                </div>
            </fieldset>
        </div>
    </div>
    
    <div class="row10 _CENTER">
        <fieldset class="fieldset_local">
            <legend class="legend" style="margin-left:8px;">ESC&Aacute;NER C&Oacute;DIGO DE BARRAS</legend>
            <div id="date_tabla2" class="input-group center-block" style="width:200px;padding:6px;">
                <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                <input type="text" class="form-control input-sm" id="get_etiqueta" name="get_etiqueta"  value=""/>
                <span class="input-group-addon" >
                    <a href="javascript:busqueda_etiquera(0,'')" style="opacity:0.5;color:#000;">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </a>
                </span>
            </div>
        </fieldset>
    </div>
    <div class="row5 " style="margin-right: 11px;text-align: -webkit-right;">
        <fieldset class="fieldset_local">
            <legend class="legend">OPCIONES</legend>
            <div class="btn-group" style="padding:6px;">
                <button type="button" class="btn btn-success btn-fill" id="BTN_DELETE_AP_GESPAB" onclick="UPDATE_MAIN()">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-info btn-fill" id="BTN_recepcion_custodia_masiva" onclick="recepcion_custodia_masiva()">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;CUSTODIA/TRASPORTE
                </button>
                <button type="button" class="btn btn-primary btn-fill" id="BTN_CONFIG" onclick="js_test_eqtiqueta()">
                    <i class="fa fa-wrench" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-warning btn-fill" id="BTN_" onclick="js_ver_info()">
                    <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-danger btn-fill" id="btn_" onclick="js_permiso_zebra()">
                    <i class="fa fa-code" aria-hidden="true"></i>
                </button>
            </div>
        </fieldset>
    </div>
</div>

<div class="modal fade" id="MODAL_FORM_ANATOMIA_PATOLOGICA">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="title" style="color:#e34f49">
                    <b>FORMULARIO ANATOM&Iacute;A PATOL&Oacute;GICA</b>
                </h4>
            </div>
            <div class="modal-body" id="HTML_ANATOMIA_PATOLOGICA"></div>
            <div class="modal-footer" style="text-align:end;">
                <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>
      
<div class="modal fade" id="MODAL_INFORMACION_ETIQUETA">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="title" style="color:#e34f49">
                    <b>INFORMACI&Oacute;N DE ETIQUETA</b>
                </h4>
            </div>
            <div class="modal-body" id="HTML_INFORMACION_ETIQUETA"></div>
            <div class="modal-footer" style="text-align:end;">
                <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="MODAL_INFO_APLICATIVO">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="title" style="color:#e34f49">
                    <b>INFORMACI&Oacute;N GENERAL</b>
                </h4>
            </div>
            <div class="modal-body" id="HTML_INFO_APLICATIVO">
                <?php echo  $this->load->view("ssan_libro_biopsias_listagespabme/html_configuracion_frasco",[],true); ?>
            </div>
            <div class="modal-footer" style="text-align:end;">
                <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="MODAL_TEST_ETIQUETA">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="title" style="color:#e34f49">
                    <b>PRUEBA ETIQUETAS | ZEBRA ZD420</b>
                </h4>
            </div>
            <div class="modal-body" id="HTML_TEST_ETIQUETA">
                <div class="GRID_CONF_EQUIQUETA">
                    <div class="GRID_CONF_EQUIQUETA1">
                        <div class="card" style="margin: 0px 0px 0px 0px;">
                            <div class="header">
                                <h4 class="title"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;<b>MEDIANA</b></h4>
                                <p></p>
                            </div>
                            <div class="content" style="display: flex;justify-content: center;">
                                <div style="overflow:hidden;">
                                    <div class="form-group d-flex justify-content-center">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <a href="javascript:imprimirEtiqueta2(1)" style="opacity:0.5;color:#000;">
                                                        <i class="fa fa-barcode fa-4x" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="_CENTER3">
                                                        <b>MEDIANA&nbsp;(1)</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="GRID_CONF_EQUIQUETA2">
                        <div class="card" style="margin: 0px 0px 0px 0px;">
                            <div class="header">
                                <h4 class="title"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;<b>PEQUE&Ntilde;A</b></h4>
                                <p></p>
                            </div>
                            <div class="content">
                                <div style="overflow:hidden;">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="">
                                                    <!--
                                                        <a href="javascript:imprimirEtiqueta2(2)" style="opacity:0.5;color:#000;">
                                                            <i class="fa fa-barcode fa-4x" aria-hidden="true"></i>
                                                        </a> 
                                                    -->
                                                    <button type="button" class="btn btn-default btn-fill" id="test_equiqueta_left" style="height: 60px;width: 96px;" onclick="imprimirEtiqueta2(2)">
                                                        <i class="fa fa-barcode fa-4x" style="margin-left:-65px;" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                                <div class="">
                                                    <b>PEQUE&Ntilde;A&nbsp;(LEFT)</b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="">
                                                    <!--
                                                        <a href="javascript:imprimirEtiqueta2(3)" style="opacity:0.5;color:#000;">
                                                            <i class="fa fa-barcode fa-4x" aria-hidden="true"></i>
                                                        </a>
                                                    -->
                                                    <button type="button" class="btn btn-default btn-fill" id="test_equiqueta_left" style="height: 60px;width: 96px;" onclick="imprimirEtiqueta2(3)">
                                                        <i class="fa fa-barcode fa-4x"  style="margin-left:-30px;" aria-hidden="true"></i>
                                                    </button>
                                                    <div class="">
                                                        <b>PEQUE&Ntilde;A&nbsp;(CENTER)</b> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="modal-footer" style="text-align:end;">
                <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="DIV_MAIN"><?php echo $HTML;?></div>
<div id="RETURN"></div>
<div id="JSON_RETURN"></div>

<div class="modal fade" id="Dv_verdocumentos" style=" z-index: 1602;overflow-y: scroll;" data-backdrop="static">  
    <div class="modal-dialog modal-xl3" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header"> <button type="button" class="close" data-dismiss="modal"  aria-hidden="true">&times;</button>
                <h3 class="modal-title"><b>PDF DOCUMENTOS</b></h3>
            </div>
            <div class="modal-body" id="PDF_VERDOC"></div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-fill btn-sm" data-dismiss="modal">CIERRA VENTANA</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_info_muestras" style=" z-index: 1602;overflow-y: scroll;" data-backdrop="static">  
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"> <button type="button" class="close" data-dismiss="modal"  aria-hidden="true">&times;</button>
                <h3 class="modal-title"><b style="color:#e34f49;">INFORMACI&Oacute;N MUESTRAS</b></h3>
            </div>
            <div class="modal-body" id="html_info_muestras"></div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-fill btn-sm" data-dismiss="modal">CIERRA VENTANA</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_vista_zpl_to_pdf">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="title" style="color:#e34f49"><b>ETIQUETA EN PDF</b></h4>
            </div>
            <div class="modal-body" id="html_vista_zpl_to_pdf">
                <ul class="nav nav-tabs" role="tablist" id="ul_nav_tabs"></ul>
                <div class="tab-content" id="tabs_tab_panel"></div>
            </div>
            <div class="modal-footer" style="text-align:end;">
                <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<style>
    @media(min-width    :   900px){
        .modal_xl_traza   {
            width       :   98%;
            height      :   85%;
            max-width   :   90%;
        }
    }
</style>

<div class="modal fade" id="modal_trazabilidad_biopsias">
    <div class="modal-dialog modal_xl_traza">
	    <div class="modal-content">
	        <div class="modal-header">
             	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	            <h4 class="title" style="color:#e34f49"><i class="fa fa-database" aria-hidden="true"></i>&nbsp;<b>TRAZABILIDAD DE BIOPSIAS</b></h4>
            </div>
            <div class="modal-body" id="html_trazabilidad_biopsias"></div>
            <div class="modal-footer" style="text-align:end;">
                <button type="button" class="btn btn-fill btn-danger btn-xs" data-dismiss="modal">
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<!--
<h1>h1. Bootstrap heading</h1>
<h2>h2. Bootstrap heading</h2>
<h3>h3. Bootstrap heading</h3>
<h4>h4. Bootstrap heading</h4>
<h5>h5. Bootstrap heading</h5>
<h6>h6. Bootstrap heading</h6>
-->
<!--
<hr>
<p class="h1">h1. Bootstrap heading</p>
<p class="h2">h2. Bootstrap heading</p>
<p class="h3">h3. Bootstrap heading</p>
<p class="h4">h4. Bootstrap heading</p>
<p class="h5">h5. Bootstrap heading</p>
<p class="h6">h6. Bootstrap heading</p>
-->
<!--
<h3>Fancy display heading <small class="text-muted">With faded secondary text</small></h3>
<hr>
<h1 class="display-1">Display 1</h1>
<h1 class="display-2">Display 2</h1>
<h1 class="display-3">Display 3</h1>
<h1 class="display-4">Display 4</h1>
<h1 class="display-5">Display 5</h1>
<h1 class="display-6">Display 6</h1>
-->
<!--
<li class="gespab_group list-group-item list-group-item-primary">primary</li>
<li class="gespab_group list-group-item list-group-item-secondary">secondary</li>
<li class="gespab_group list-group-item list-group-item-success">success</li>
<li class="gespab_group list-group-item list-group-item-danger">danger</li>
<li class="gespab_group list-group-item list-group-item-warning">warning</li>
<li class="gespab_group list-group-item list-group-item-info">info</li>
<li class="gespab_group list-group-item list-group-item-light">light</li>
<li class="gespab_group list-group-item disabled">disabled</li>
<li class="gespab_group list-group-item list-group-item-dark">dark</li>
-->
                 