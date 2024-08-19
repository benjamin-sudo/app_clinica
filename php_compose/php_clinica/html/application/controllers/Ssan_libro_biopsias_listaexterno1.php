<?php

class Ssan_libro_biopsias_listaexterno1 extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_biopsias_listaexterno1_model");
        $this->load->model("Ssan_libro_biopsias_usuarioext_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data = [];
        $session = explode("-",$this->session->userdata("USERNAME"));
        $empresa = $this->session->userdata("COD_ESTAB");
        $origen_sol = 0;  #listado de origen de solicitudes - (DEFAULT 0 - ALL) 
        $pto_entrega = 0;  #listado de origen puntos de entrega descrita en la solicitud de anatomia - (DEFAULT 0 - ALL) 
        $ind_opcion = 0;  #0-MASTER | 1-PB_PROFESIONALXROTULO
        $return_data = $this->Ssan_libro_biopsias_usuarioext_model->model_busquedasolicitudes([
            "data_inicio" => date("d-m-Y"),
            "data_final" => date("d-m-Y"),
            "COD_EMPRESA" => $empresa,
            "usr_session" => $session[0],
            "ind_opcion" => $ind_opcion,
            "ind_first" => 1,
            "origen_sol" => $origen_sol,
            "pto_entrega" => $pto_entrega,
            "num_fase" =>  1,
            "ind_template" =>  "ssan_libro_biopsias_listaexterno1",
        ]);
        #ETIQUETA ZEBRA BROWSER PRINT
        #$this->load->js("assets/ssan_libro_biopsias_listagespab/js/BrowserPrint-1.0.4.min.js");
        #$this->load->js("assets/ssan_libro_biopsias_listagespab/js/etiqueta.js");
        #GESTOR GLOBAL AP
        $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/anatomia_patologica.js");      
        #BUSQUEDA  
        $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/javascript_trazabilidad.js");     
        $this->load->css("assets/ssan_libro_biopsias_listaexterno1/css/styles.css");
        #ADD ARRIBA
        #$this->load->css("assets/ssan_libro_biopsias_listagespab/css/styles.css");                  
        $this->load->js("assets/ssan_libro_biopsias_listaexterno1/js/javascript.js");
        $this->load->view('ssan_libro_biopsias_listaexterno1/ssan_libro_biopsias_listaexterno1_view',$return_data);
    }
    
    public function update_main(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $session = explode("-",$this->session->userdata("USERNAME"));
        $date_inicio = $this->input->post('fecha_inicio');
        $date_final = $this->input->post('fecha_final');
        #DATE INICIO TIEMPO
        /*
        $this->input->set_cookie(array(
            'name' => 'date_inicio',
            'value' =>  $date_inicio,
            'expire' =>  86500,
            'secure' =>  false
        ));
        #DATE INICIO TIEMPO
        $this->input->set_cookie(array(
            'name' => 'date_final',
            'value' =>  $date_final,
            'expire' =>  86500,
            'secure' =>  false
        ));
        */
        #SALIDA ARREGLO
        $aData = $this->Ssan_libro_biopsias_usuarioext_model->model_busquedasolicitudes(array(
            "data_inicio" => $date_inicio,
            "data_final" => $date_final,
            "usr_session" => $session[0],
            "ind_opcion" => $this->input->post('OPTION'),
            "ind_first" => 0,
            "origen_sol" => $this->input->post('origen_sol'),
            "pto_entrega" => $this->input->post('pto_entrega'),
            "COD_EMPRESA" => $this->session->userdata("COD_ESTAB"),
            "num_fase" => $this->input->post('NUM_FASE'),
            "ind_template" => $this->input->post('ind_template'),
        ));
        #OUT
        $this->output->set_output(json_encode(array(
            'STATUS'                =>  true,
            'adata'                 =>  $aData,
            'STATUS_OUT'            =>  $aData['html_externo'],
        )));
    }

    #editando para multriplice solicitudes sean procesadas
    public function informacion_x_muestra_grupal(){
        if (!$this->input->is_ajax_request()){  show_404(); }
        $empresa = $this->session->userdata('COD_ESTAB');
        $html = '';
        #$from = $this->input->post('from');
        #$opcion = $this->input->post('opcion');
        $ARR_CASETE_ORD = [];
        $data_main = [];
        $get_etiqueta = $this->input->post('get_etiqueta');
        $vista = $this->input->post('vista');
        $NUM_FASE = $this->input->post('NUM_FASE');
        $IND_MODAL = $this->input->post('MODAL');
        $array_data = $this->input->post('array_data');
        #LEYENDA
        $data_return = '';
        #editando         
        $ARR_DATA = 'null';
        
        if (isset($array_data["array_anatomia"]) && is_array($array_data["array_anatomia"]) && count($array_data["array_anatomia"]) > 0) {
            $ARR_DATA = implode(",", $array_data["array_anatomia"]);
        }

        $DATA = $this->Ssan_libro_biopsias_usuarioext_model->LOAD_INFOXMUESTRAANATOMIACA(array(
            "COD_EMPRESA" =>  $empresa,
            "TXTMUESTRA" =>  $get_etiqueta,
            "NUM_FASE" =>  $NUM_FASE,
            "ARR_DATA" =>  $ARR_DATA,
        ));
        
        ###
        $ARR_GENTIONMSJ = [];
        if (count($DATA["P_ANATOMIA_PATOLOGICA_MAIN"])>0){
            $arr_muestra_muestras = [];
            $arr_muestras_citologia = [];
            $arr_info_linea_tiempo = [];
            
            if (count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"])>0){
                foreach ($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $arr_muestras_anatomica_row)  {
                    $arr_muestra_muestras[$arr_muestras_anatomica_row['ID_SOLICITUD_HISTO']][] =   $arr_muestras_anatomica_row;
                }
            }
            
            if (count($DATA["P_AP_MUESTRAS_CITOLOGIA"])>0){
                foreach ($DATA["P_AP_MUESTRAS_CITOLOGIA"] as $i => $arr_muestras_citologica_row) {
                    $arr_muestras_citologia[$arr_muestras_citologica_row['ID_SOLICITUD_HISTO']][] =   $arr_muestras_citologica_row;
                } 
            }

            #ordena data para templetate template_logs_anatomia
            $log_adverso                                                                                =   [];
            if (count($DATA['P_INFO_LOG_ADVERSOS'])>0){
                foreach($DATA['P_INFO_LOG_ADVERSOS'] as $i => $log_adv){ 
                    $log_adverso[$log_adv['ID_NUM_CARGA'].'_'.$log_adv['ID_NMUESTRA']]                  =   $log_adv;
                }
            }

            if(count($DATA["P_AP_INFORMACION_ADICIONAL"])>0){
                foreach ($DATA["P_AP_INFORMACION_ADICIONAL"] as $i => $arr_linea_tiempo_logs_row)       {
                    $ID_SOLICITUD_HISTO                                                                 =   $arr_linea_tiempo_logs_row['ID_SOLICITUD_HISTO'];
                    $ID_NUM_CARGA                                                                       =   $arr_linea_tiempo_logs_row['ID_NUM_CARGA'];
                    $ID_NMUESTRA                                                                        =   $arr_linea_tiempo_logs_row['ID_CASETE']==''?$arr_linea_tiempo_logs_row['TXT_BACODE']:$arr_linea_tiempo_logs_row['ID_CASETE'];
                    $id_compuesta                                                                       =   $ID_NUM_CARGA.'_'.$ID_NMUESTRA;
                    $data_main[]                                                                        =   $arr_linea_tiempo_logs_row;
                    $arr_info_linea_tiempo[$ID_SOLICITUD_HISTO][$ID_NUM_CARGA][$ID_NMUESTRA][]          =   array(
                                                                                                                    'MAIN'          =>  $arr_linea_tiempo_logs_row ,
                                                                                                                    'ERROR_LOG'     =>  array_key_exists($id_compuesta,$log_adverso)?$log_adverso[$id_compuesta]:[]
                                                                                                                );
                }
            }

            #falta los log 
            foreach($DATA["P_ANATOMIA_PATOLOGICA_MAIN"] as $i => $row){
                $id_anatomia =   $row["ID_SOLICITUD"];
                $html =   $this->load->view("ssan_libro_biopsias_listagespab/ssan_libro_biopsias_listagespab_view_pre_all",array(
                                                    "VIEWS"                             =>  $vista,
                                                    "DATA"                              =>  $row,
                                                    "FIRST"                             =>  $get_etiqueta,
                                                    "FASE"                              =>  $NUM_FASE,
                                                    "P_ANATOMIA_PATOLOGICA_MUESTRAS"    =>  empty($arr_muestra_muestras[$id_anatomia])?[]:$arr_muestra_muestras[$id_anatomia],
                                                    "P_AP_MUESTRAS_CITOLOGIA"           =>  empty($arr_muestras_citologia[$id_anatomia])?[]:$arr_muestras_citologia[$id_anatomia],
                                                    //"P_AP_INFORMACION_ADICIONAL"      =>  empty($arr_info_linea_tiempo[$id_anatomia])?[]:$arr_info_linea_tiempo[$id_anatomia],
                                                    #"HTML_LOGS"                        =>  $this->load->view("Ssan_libro_etapaanalitica/template_logs_anatomia",array("ID_SOLICITUD"=>$id_anatomia,'P_AP_INFORMACION_ADICIONAL'=>empty($arr_info_linea_tiempo[$id_anatomia])?[]:$arr_info_linea_tiempo[$id_anatomia]),true),
                                                    "HTML_LOGS"                         => '',
                                                ),true);
                
                $ARR_GENTIONMSJ[]           =   array(
                    'ID_AP'                 =>  $id_anatomia,
                    'ID_TABS'               =>  'TABS_'.$id_anatomia,
                    'TXT_TITULO'            =>  'N&deg;&nbsp;<b>'.$id_anatomia.'</b>',
                    'HTML'                  =>  $html,
                );
            }
        }
        
        #ID_SOLICITUD
        $NUM_ANATOMIA                       =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];
        if($IND_MODAL){
            $TXT_GO_BACODE                  =   $NUM_FASE==1?'TRASPORTE | CUSTODIA':$NUM_FASE==2?'PARA RECEPCI&Oacute;N':'VISUALIZACI&Oacute;N';
            
            $TABS_HTML                      =   '
                <script>
                    $(document).ready(function(){
                        $("#get_etiqueta_modal").keypress(function(e){if(e.which==13){ 
                            busqueda_etiquera_modal(0); 
                        }});
                        $("#UL_TABS_MUESTRA").on("shown.bs.tab",function(e){
                            //console.log("target -> ",e.target);
                            //console.log("target -> ",e.relatedTarget);
                            $(".popover").popover("hide");
                        });
                        document.getElementById("get_etiqueta_modal").focus();
                        $("#UL_TABS_MUESTRA li:first-child a").tab("show");
                        console.log("------------------------------------------------");
                        console.log("la arrogancia          ->  '.$TXT_GO_BACODE.'   ");
                        console.log("buscar la etiqueta     ->                       ");
                        console.log("------------------------------------------------");
                    });
                </script>
                
                <!--
                    '.$TXT_GO_BACODE.' | F:'.$NUM_FASE.'
                -->
                
                <div class="CSS_GRID_ETIQUETA_HEARD" style=" margin-bottom:15px;">
                    <div class="CSS_GRID_ETIQUETA_HEARD1 FLEX_CENTER" style="display:none">

                        <fieldset class="fieldset_local">
                            <legend class="legend"><i class="fa fa-search" aria-hidden="true"></i> ETIQUETAS</legend>
                            <div id="date_tabla2" class="input-group" style="width:200px;padding:8px;">
                                <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                                <input type="text" class="form-control input-sm" id="get_etiqueta_modal" name="get_etiqueta_modal"  value=""/>
                                <span class="input-group-addon" >
                                    <a href="javascript:busqueda_etiquera_modal(2)" style="opacity:0.5;color:#000;">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </a>
                                </span>
                             </div>
                             <script>document.getElementById("get_etiqueta_modal").focus();</script>
                        </fieldset>

                    </div>
                    <div class="CSS_GRID_ETIQUETA_HEARD2 FLEX_CENTER" style="text-align:end">';  
                    #
                    switch($NUM_FASE){
                        case 0:
                            $TABS_HTML  .=  '   <i class="fa fa-eye" aria-hidden="true"></i>    ';
                            break;
                        case 1:
                            #<!--&nbsp;TRASPORTE MASIVO-->
                            #<!--&nbsp;CUSTODIA MASIVO-->  
                            $TABS_HTML  .=  '
                                                <div class="btn-group-vertical" id="btn_masivo" style="display:none">
                                                    <a class="btn btn-fill btn-primary" style="text-align:end;" href="javascript:confirma_custodia_all(1)">
                                                        TODO - CUSTODIA MASIVO&nbsp;<i class="fa fa-inbox" aria-hidden="true"></i>
                                                    </a>
                                                    <a class="btn btn-fill btn-success" style="text-align:end;" href="javascript:confirma_trasporte_all(1)">
                                                        TODO - TRASPORTE MASIVO&nbsp;<i class="fa fa-truck" aria-hidden="true"></i>
                                                    </a> 
                                                </div>
                                            ';
                           break;
                        case 2:
                           $TABS_HTML   .=  '   
                                                <div class="btn-group" id="btn_masivo" style="display:none">
                                                    <button class="btn btn-xs btn-fill btn-success" onclick="confirma_recepcion_all(1)" style="width:auto;height:35px;">
                                                        <i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;RECEPCI&Oacute;N MASIVA
                                                    </button>
                                                </div>     
                                            ';
                            break;
                    }
            $TABS_HTML .=   '</div>
                </div>';
            #GESTOR DE TABS
            $TABS_HTML                  .=   ' <div id="MAIN_TABS_MUESTRA">';
            if(count($ARR_GENTIONMSJ)>0){
                $HTML_MENSAJE_LU        =   '';
                $HTML_MENSAJE_DIV       =   '';
                foreach($ARR_GENTIONMSJ as $i => $row){
                    $ID_INICO           =   $row['ID_TABS'];
                    $class_active       =   $i==0?'active':'';
                    $HTML_MENSAJE_LU    .=  '<li class="nav-item '.$class_active.' all_solicitudes_custodia all_solicitudes_trasporte all_solicitudes_recepcion li_histo_'.$row['ID_AP'].' " id="'.$row['ID_AP'].'">
                                                <a class="nav-link" data-toggle="tab" href="#'.$ID_INICO.'" role="tab">'.$row['TXT_TITULO'].'</b></a>
                                            </li>';
                    $HTML_MENSAJE_DIV  .=  '<div class="tab-pane '.$class_active.' tab_histo_'.$row['ID_AP'].'"  id="'.$ID_INICO.'" role="tabpanel">'.$row['HTML'].'</div>';
                }
                $TABS_HTML              .=  '<ul class="nav nav-tabs" role="tablist" id="UL_TABS_MUESTRA">'.$HTML_MENSAJE_LU.'</ul>';
                $TABS_HTML              .=  '<div class="tab-content" id="TABS_TAB_PANEL">'.$HTML_MENSAJE_DIV.'</div>';
            } 
            $TABS_HTML                  .=   '</div>';
        } else {
            $TABS_HTML                  =   $html;
        }
        
        #out json 
        $this->output->set_output(json_encode(array(
            'STATUS' => true,
            'DATA' =>  $DATA,
            'NUM_ANAT' => $NUM_ANATOMIA,
            'IND_MODAL' =>  $IND_MODAL,
            'RETURN' =>  $data_return,
            'BUSQ' =>  $get_etiqueta,
            'EMPRESA' =>  $empresa,
            'HTML_VIWE' =>  $html,
            'HTML_OUT' =>  $TABS_HTML,
            'DATA_GET' =>  $array_data,
            'data_main' =>  $data_main,
            'ARR_CASETE_ORD' =>  $ARR_CASETE_ORD,
            'P_AP_INFORMACION_ADICIONAL' =>  $DATA["P_AP_INFORMACION_ADICIONAL"],
        )));
    }
    ########################################################################
    #LEYENDA
    ########################################################################
    #CONTEMPOREANA          :   2
    #DIFERIDA               :   3
    #BIOPSIA + CITOLOGIA    :   4   =   V_LAST_NUMERO     
    ########################################################################
    #BIOPSIA + CITOLIGIA    :   4                 
    #CITOLOGIA              :   5   =   NUM_CO_CITOLOGIA  
    ########################################################################
    #PAP                    :   6   =   NUM_CO_PAP 
    ########################################################################
    public function ultimo_numero_disponible(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status = true;
        $empresa = $this->session->userdata("COD_ESTAB");
        $ind_tipo_biopsia = $this->input->post('tipo_biopsia'); 
        $data_number = $this->Ssan_libro_biopsias_usuarioext_model->model_ultimo_numero_disponible(array(
            "val_empresa" => $empresa,
            "ind_tipo_biopsia" => $ind_tipo_biopsia,
        ));
        $this->output->set_output(json_encode(array(
            'status' => $status,
            'data_numero' => $data_number,
        )));
    }
    
    public function ultimo_numero_disponible_citologia(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status =   true;
        $empresa =   $this->session->userdata("COD_ESTAB");
        $ind_tipo_biopsia =   $this->input->post('tipo_biopsia'); 
        $data_number =   $this->Ssan_libro_biopsias_usuarioext_model->model_ultimo_numero_disponible_citologia(array(
            "val_empresa" =>  $empresa,
            "ind_tipo_biopsia" =>  $ind_tipo_biopsia,
        ));
        $this->output->set_output(json_encode(array(
            'status' =>  $status,
            'data_numero' =>  $data_number,
        )));
    }

    public function ver_valida_firma_simple(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $contrasena =   $this->input->post('contrasena');
        $valida =   $this->Ssan_libro_biopsias_usuarioext_model->validaClave($contrasena);
        $status =   count($valida)>0?true:false;
        $this->output->set_output(json_encode(array(
            'contrasena' =>  $contrasena,
            'status' =>  $status,
            'valida' =>  $valida,
        )));
    }

    public function confirma_recepcion(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa = $this->session->userdata('COD_ESTAB');
        $id_anatomia = $this->input->post('id_anatomia');
        $array_muestras = $this->input->post('array_muestras');
        $n_interno = $this->input->post('n_interno');
        $n_interno_2 = $this->input->post('n_interno_2');
        $ind_tipo_biopsia =   $this->input->post('ind_tipo_biopsia'); 
        $usuarioh = explode("-",$this->session->userdata("USERNAME"));
        #$num_memo_notificacion             =   true;
        $TXT_ERROR = '';
        $DATA = '';
        #$valida                            =   '';
        $STATUS = true;
        $arr_errores = array();
        $arr_password = $this->input->post('pass');
        $valida =	$this->Ssan_libro_biopsias_usuarioext_model->sqlValidaClave_doble($arr_password);
        count($valida['user_1'])>0?'':array_push($arr_errores,"Error en la firma del usuario de trasporte");
        count($valida['user_2'])>0?'':array_push($arr_errores,"Error en la firma del usuario de recepci&oacute;n");
        if(count($arr_errores)>0){
            $TXT_ERROR = implode("<br>",$arr_errores);
            $STATUS = false;
        } else {
            $DATA = $this->Ssan_libro_biopsias_usuarioext_model->get_confirma_recepcion(array(
                        "COD_EMPRESA"       =>  $empresa,
                        "SESSION"           =>  $usuarioh[0], 
                        "ID_ANATOMIA"       =>  $id_anatomia,
                        "ARRAY"             =>  $array_muestras,
                        "DATA_FIRMA"        =>  $valida,
                        "n_interno"         =>  $n_interno,
                        "n_interno_2"       =>  $n_interno_2,
                        "ind_tipo_biopsia"  =>  $ind_tipo_biopsia,
                    ));
        }

        $this->output->set_output(json_encode(array(
            'ERRORES'       =>  $arr_errores,
            'PASS'          =>  $arr_password,
            'GET_BD'        =>  $DATA,
            'DATA_FIRMA'    =>  $valida,
            'RETURN'        =>  $STATUS,
            'TXT_ERROR'     =>  $TXT_ERROR,
            'STATUS'        =>  $STATUS,
        )));
    }

}

?>