<?php

class Ssan_libro_etapaanalitica extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pdf');
        $this->get_sala = 'analitica';
        $this->txt_titulo = 'ETAPA ANALITICA';
        $this->load->model("Ssan_libro_etapaanalitica_model");
        $this->load->model("Ssan_libro_biopsias_usuarioext_model");
    }
    
    public function index_old(){
        $this->output->set_template('blank');
        $data = [];
        $this->load->css("assets/Ssan_libro_etapaanalitica/css/styles.css");
        $this->load->js("assets/Ssan_libro_etapaanalitica/js/javascript.js");
        $this->load->view('ssan_libro_etapaanalitica/ssan_libro_etapaanalitica_view',$data);
    }

    public function index(){
        $this->output->set_template('blank');
        $arr_ids_anatomia = '';
        $arr_estados_filtro = '0';
        $var_fecha_inicio = date("d-m-Y");
        $var_fecha_final = date("d-m-Y");
        /*
        if(isset($_COOKIE['target']))   {
            $tipo_busqueda              =   $_COOKIE['target'];
            if($tipo_busqueda           === '#_panel_por_fecha'){
                $arr_estados_filtro     =   isset($_COOKIE['data_filtro_fechas_estados'])?$_COOKIE['data_filtro_fechas_estados']:'0';
                if(isset($_COOKIE['data'])){
                    //var_dump(1);
                    $conf_cookie        =   json_decode($this->input->cookie('data',false));
                    $var_fecha_inicio   =   $conf_cookie->fecha_inicio;
                    $var_fecha_final    =   strtotime($conf_cookie->fecha_final)>strtotime($conf_cookie->fecha_inicio)?$conf_cookie->fecha_final:$conf_cookie->fecha_inicio;
                } else {
                    //var_dump(2);
                    $var_fecha_inicio   =   date("d-m-Y");
                    $var_fecha_final    =   date("d-m-Y");
                }
            } else  if($tipo_busqueda   === '#_panel_por_gestion'){
                #$arr_ids_anatomia      =   isset($_COOKIE['id_anatomia'])?$_COOKIE['id_anatomia']:'';
                $arr_ids_anatomia       =   '';
                #elimina cokkie 
                #unset($_COOKIE['id_anatomia']); 
                #setcookie('id_anatomia',null,-1,'/'); 
            } else  if($tipo_busqueda   === '#_busqueda_xpersona'){
                $arr_ids_anatomia       =   [];
            } else  if($tipo_busqueda   === '#_busqueda_bacode'){
                $arr_ids_anatomia       =   [];
            }
        } else {
            #target por defecto
            $tipo_busqueda              =   '#_panel_por_fecha';
            $arr_ids_anatomia           =   [];
            $var_fecha_inicio           =   date("d-m-Y");
            $var_fecha_final            =   date("d-m-Y");
        }
        */
        $arr_ids_anatomia = [];
        $tipo_busqueda = '#_panel_por_fecha';
        #LOAD_ETAPA_ANALITICA
        $return_data = $this->Ssan_libro_etapaanalitica_model->new_load_analitica_paginado(array(
            "cod_empresa" => $this->session->userdata("COD_ESTAB"),
            "usr_session" => explode("-",$this->session->userdata("USERNAME"))[0],
            "ind_opcion" => $tipo_busqueda,
            "ind_first" => 1,
            "data_inicio" => $var_fecha_inicio,
            "data_final" => $var_fecha_final,
            "num_fase" => 4,
            "ind_template" => "ssan_libro_etapaanalitica",
            "arr_ids_anatomia" => $arr_ids_anatomia,
            "get_sala" => $this->get_sala,
            "txt_titulo" => $this->txt_titulo,
            "ind_filtros_ap" => $arr_estados_filtro,
            "ind_order_by" => "0",
        ));
        #API VOZ
        #$this->load->js("assets/ssan_libro_etapaanalitica/js/apivoz_multiple.js");
        #ARC LOCALES
        $this->load->css("assets/ssan_libro_etapaanalitica/css/styles.css");
        $this->load->js("assets/ssan_libro_etapaanalitica/js/javascript.js");
        #WEB SOCKET
        #$this->load->js("assets/themes/wsocket_io/2_3_0/socket.io.dev.js");
        $this->load->js("assets/ssan_libro_etapaanalitica/js/ws_anatomiap_envio_a_recepcion.js");
        #AUTOSIZE BETA
        $this->load->js("assets/ssan_libro_etapaanalitica/js/autosize.js");
        #HTML OUT
        $this->load->view("ssan_libro_etapaanalitica/ssan_libro_etapaanalitica_view",$return_data);
    }

    public function update_lista_etapaanalitica_pagina(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $tipo_busqueda = $this->input->post('tabs');
        $fecha_inicio = $this->input->post('date_inicio');
        $fecha_final = $this->input->post('date_final');
        $txt_sala = $this->input->post('txt_sala');
        $txt_ids_anatomia = $this->input->post('txt_ids_anatomia');
        $_post_filtro_xfechas = $this->input->post('ind_filtro_busqueda_xfechas');
        $v_page_num = $this->input->post('v_page_num');
        $v_page_size = $this->input->post('v_page_size');
        #TIENE QUE SABER QUE target 
        #_INICIO BUSCADOR DEL FILTRO
        /*
        $val_filtro_estaso = '';
        $arr_ids_anatomia = '';
        $cookie_target = array(
                                'name' => 'target',
                                'value' => $tipo_busqueda,
                                'expire' => 86500,
                                'secure' => false
                            );
        
        $this->input->set_cookie($cookie_target);
        if($tipo_busqueda === '#_panel_por_fecha') {   #_panel_por_fecha   
            #BUSCAR REPETIDOS
            #cookie para los estados
            $cookie_filtros =   array(
                                    'name' =>  'data_filtro_fechas_estados',
                                    'value' =>  $_post_filtro_xfechas,
                                    'expire' =>  86500,
                                    'secure' =>  false
                                );
            $this->input->set_cookie($cookie_filtros);
            #get_filtro_x_fecha
            $val_filtro_estaso = $_post_filtro_xfechas;
            #CONFIRMA CAMBIO
            #COOKIE DATOS DE LA BUSQUEDA
            $cookie_time = array(
                                    'name' =>  'data',
                                    'value' =>  json_encode(array(
                                                    'tipo_busqueda'     =>  'por_fecha',
                                                    'fecha_inicio'      =>  $fecha_inicio,
                                                    'fecha_final'       =>  $fecha_final,
                                                )),
                                    'expire' =>  86500,
                                    'secure' =>  false
                                );
            $this->input->set_cookie($cookie_time);
        } else if($tipo_busqueda === '#_panel_por_gestion') { #_panel_por_gestion
            $arr_ids_anatomia = $txt_ids_anatomia;
        } else  if($tipo_busqueda === '#_busqueda_xpersona'){
            $arr_ids_anatomia = 'null';
        } else  if($tipo_busqueda === '#_busqueda_bacode'){
            $arr_ids_anatomia = 'null';
        }
        */
        $arr_ids_anatomia = [];
        $tipo_busqueda = '#_panel_por_fecha';
        $return_data =   $this->Ssan_libro_etapaanalitica_model->new_load_analitica_paginado(array(
            "cod_empresa" =>  $this->session->userdata("COD_ESTAB"),
            "usr_session" =>  explode("-",$this->session->userdata("USERNAME"))[0],
            "ind_opcion" =>  $tipo_busqueda,
            "ind_first" =>  0,
            "data_inicio" =>  $fecha_inicio,
            "data_final" =>  $fecha_final,
            "num_fase" =>  4,//etapa analitica
            "ind_template" =>  "ssan_libro_etapaanalitica",
            "arr_ids_anatomia" =>  $arr_ids_anatomia,
            "get_sala" =>  $txt_sala,
            "txt_titulo" =>  'ETAPA ANALITICA',
            "ind_filtros_ap" =>  $val_filtro_estaso,
            "ind_order_by" =>  $this->input->post('ind_order_by'),
            "v_page_num" =>  $v_page_num,
            "v_page_size" =>  $v_page_size,
        ));
        #OUT VIEWS
        $this->output->set_output(json_encode(array(
            'date_inicio' => $fecha_inicio,
            'date_final' => $fecha_final,
            #'arr_ids_anatomia' => $arr_ids_anatomia,
            'userdata' => $this->session->userdata,
            'id_html_out' => substr($tipo_busqueda,1),
            'out_html' => $return_data["HTML_LI"],
            'return' => $return_data,
        )));
    }

    public function update_lista_etapaanalitica(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $tipo_busqueda = $this->input->post('tabs');
        $fecha_inicio = $this->input->post('date_inicio');
        $fecha_final = $this->input->post('date_final');
        $txt_sala = $this->input->post('txt_sala');
        $txt_ids_anatomia = $this->input->post('txt_ids_anatomia');
        $_post_filtro_xfechas = $this->input->post('ind_filtro_busqueda_xfechas');
        ########################################################################
        #TIENE QUE SABER QUE target 
        #_INICIO BUSCADOR DEL FILTRO
        $val_filtro_estaso = '';
        $arr_ids_anatomia = '';
        ########################################################################
        #COOKIE TIPO DE BUSQUEDA
        $cookie_target =   array(
                                    'name' =>  'target',
                                    'value' =>  $tipo_busqueda,
                                    'expire' =>  86500,
                                    'secure' =>  false
                                );
        
        $this->input->set_cookie($cookie_target);
        if($tipo_busqueda === '#_panel_por_fecha') {   #_panel_por_fecha   
            #BUSCAR REPETIDOS
            #cookie para los estados
            $cookie_filtros = array(
                                    'name'      =>  'data_filtro_fechas_estados',
                                    'value'     =>  $_post_filtro_xfechas,
                                    'expire'    =>  86500,
                                    'secure'    =>  false
                                );
            $this->input->set_cookie($cookie_filtros);
            
            #get_filtro_x_fecha
            $val_filtro_estaso              =   $_post_filtro_xfechas;
            #CONFIRMA CAMBIO
            #COOKIE DATOS DE LA BUSQUEDA
            $cookie_time                    =   array(
                                                    'name'      =>  'data',
                                                    'value'     =>  json_encode(array(
                                                                        'tipo_busqueda'     =>  'por_fecha',
                                                                        'fecha_inicio'      =>  $fecha_inicio,
                                                                        'fecha_final'       =>  $fecha_final,
                                                                    )),
                                                    'expire'    =>  86500,
                                                    'secure'    =>  false
                                                );
            $this->input->set_cookie($cookie_time);
        } else if($tipo_busqueda            === '#_panel_por_gestion')          {   #_panel_por_gestion
            /*
            $arrs_anatomia                  =   [];
            if(isset($_COOKIE['id_anatomia'])){
                #to string a array
                $arrs_anatomia              =   explode(",",$txt_ids_anatomia);
                #elimina los repetidos
                $new_array_anatomia         =   array_unique($arrs_anatomia);
                #elimiar cookie 
                delete_cookie('id_anatomia');
            }  else {
                $new_array_anatomia         =   array($txt_ids_anatomia);
            }
            #arrat to string
            $string_id_anatomia             =   implode(",",$new_array_anatomia);
            #new cookie
            $cookie_ids_ap                  =   array(
                                                    'name'      =>  'id_anatomia',
                                                    'value'     =>  $string_id_anatomia,
                                                    'expire'    =>  86500,
                                                    'secure'    =>  false
                                                );
            $this->input->set_cookie($cookie_ids_ap);
            */
            $arr_ids_anatomia               =   $txt_ids_anatomia;
        } else  if($tipo_busqueda           === '#_busqueda_xpersona'){
            $arr_ids_anatomia               =   'null';
        } else  if($tipo_busqueda           === '#_busqueda_bacode'){
            $arr_ids_anatomia               =   'null';
        }
        #################################################
        ########### LOAD ALL ETAPA ANALITICA ############
        ########### GO_TO -> LOAD_ETAPA_ANALITICA #######
        #################################################
        $return_data                        =   $this->Ssan_libro_etapaanalitica_model->load_etapa_analiticaap(array(
            "cod_empresa"                   =>  $this->session->userdata("COD_ESTAB"),
            "usr_session"                   =>  explode("-",$this->session->userdata("USERNAME"))[0],
            "ind_opcion"                    =>  $tipo_busqueda,
            "ind_first"                     =>  0,
            "data_inicio"                   =>  $fecha_inicio,
            "data_final"                    =>  $fecha_final,
            "num_fase"                      =>  4,//etapa analitica
            "ind_template"                  =>  "ssan_libro_etapaanalitica",
            "arr_ids_anatomia"              =>  $arr_ids_anatomia,
            "get_sala"                      =>  $txt_sala,
            "txt_titulo"                    =>  'ETAPA ANALITICA',
            "ind_filtros_ap"                =>  $val_filtro_estaso,
            "ind_order_by"                  =>  $this->input->post('ind_order_by'),
        ));
        #OUT VIEWS
        $this->output->set_output(json_encode(array(
            'date_inicio'                   =>  $fecha_inicio,
            'date_final'                    =>  $fecha_final,
            #'arr_ids_anatomia'              =>  $arr_ids_anatomia,
            'userdata'                      =>  $this->session->userdata,
            'id_html_out'                   =>  substr($tipo_busqueda,1),
            'out_html'                      =>  $return_data["HTML_LI"],
            'return'                        =>  $return_data,
        )));
    }

    public function gestion_firma_patologo(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                             =   true;
        //$aData                            =   [];
        $empresa                            =   $this->session->userdata("COD_ESTAB");
        $aData                              =   $this->Ssan_libro_etapaanalitica_model->load_firma_doctores_informe(array(
            'empresa'                       =>  $empresa,
            'session'                       =>  explode("-",$this->session->userdata("USERNAME"))[0],
        ));
        $html                               =   $this->load->view("ssan_libro_etapaanalitica/template_gestionfirmaxpatologo",$aData,true);
        $this->output->set_output(json_encode(array(
            'status'                        =>  $status,
            'html'                          =>  $html
        )));
    }
    
    //gestion_de subida 
    public function return_ima_firma_patologo(){
        //if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                            =   $this->session->userdata("COD_ESTAB");
        $status                             =   true;
        //$return_data                      =   [];
        $return_data                        =   $this->Ssan_libro_etapaanalitica_model->gestion_imagenes_firma(array(
            'empresa'                       =>  $empresa,
            'session'                       =>  explode("-",$this->session->userdata("USERNAME"))[0],
        ));
        $this->output->set_output(json_encode(array(
            "status"                        =>  $status,
            "return_bd"                     =>  $return_data,
            "FILES"                         =>  $_FILES,
        )));
    }
   
    public function get_elimina_cookie_paciente(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        delete_cookie('id_anatomia');
        $this->output->set_output(json_encode(array(
            'status'                        =>  true,
        )));
    }
    
    public function get_busqueda_solicitudes_ap(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $busq                               =   $this->input->post('tipo_busqueda');
        $txt_busqueda                       =   $this->input->post('phrase');
        $arr_data_out                       =   [];

        $return_data                        =   $this->Ssan_libro_etapaanalitica_model->busqueda_solicitudes_ap(array(
                                                    'arr_ids_anatomia'  =>  '',
                                                    'txt_bus'           =>  $txt_busqueda,
                                                    'busq'              =>  $busq,
                                                    'cod_empresa'       =>  $this->session->userdata("COD_ESTAB"),
                                                ));

        if(count($return_data['C_LISTA_ANATOMIA_BUS'])>0 ){
            foreach ($return_data['C_LISTA_ANATOMIA_BUS'] as $i => $row){
                $arr_n_biosia               =  [];
                $row['NUM_INTERNO_AP']      == '' ? '' : array_push($arr_n_biosia,'N&deg;&nbsp;'.$row['NUM_INTERNO_AP']."-".$row['YEAR_TOMA_MUESTRA']);
                $row['NUM_CO_CITOLOGIA']    == '' ? '' : array_push($arr_n_biosia,'N&deg;&nbsp;'.$row['NUM_CO_CITOLOGIA']."-".$row['YEAR_TOMA_MUESTRA']);
                $row['NUM_CO_PAP']          == '' ? '' : array_push($arr_n_biosia,'N&deg;&nbsp;'.$row['NUM_CO_PAP']."-".$row['YEAR_TOMA_MUESTRA']);
                array_push($arr_data_out,array(
                    'html'              =>  '',
                    'id_anatomia'       =>  $row['ID_ANATOMIA'],
                    'name'              =>  $row['TXTPRIMERNOMBREAPELLIDO'],
                    'tipo_biosia'       =>  implode(",",$arr_n_biosia),
                    'type'              =>  '<br>'.$row['TIPO_DE_BIOPSIA']. ' | '. implode(",",$arr_n_biosia),
                    'icon'              =>  '<i class="fa fa-battery-quarter" aria-hidden="true"></i>',
                    '_busqueda'         =>  $busq,
                    'n_muestras'        =>  $row['N_MUESTRAS_TOTAL'],
                    'not_cancer'        =>  $row['NUM_NOF_CANCER'],
                    'cod_establref'     =>  $row['COD_ESTABLREF'],
                    #'ind_notificado'   =>  $row['TXT_ESTADO_CANCER'],
                    #'post'             =>  $_POST,
                    #'get'              =>  $_GET,
                ));
            }
        }
        $this->output->set_output(json_encode($arr_data_out));
    }
    
    public function gestion_cookie_porfiltros(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $data_for_cookie                =   $this->input->post('data_for_cookie');
        
        $cookie_target                  =   array(
                                                'name'      =>  'target',
                                                'value'     =>  '#_panel_por_fecha',
                                                'expire'    =>  86500,
                                                'secure'    =>  false
                                            );
        $this->input->set_cookie($cookie_target);
        $cookie_filtros                 =   array(
                                                'name'      =>  'data_filtro_fechas_estados',
                                                'value'     =>  implode(",",$data_for_cookie),
                                                'expire'    =>  86500,
                                                'secure'    =>  false
                                            );
        $this->input->set_cookie($cookie_filtros);
        $this->output->set_output(json_encode(array(
            'STATUS'    =>  true,
            'return'    =>  $data_for_cookie,
            'cookie'    =>  $_COOKIE,
        )));
    }
    
    public function pdf_test_anatomia(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        $out_code_pdf                   =   '';
        $txt_name_pdf                   =   '-.-';
        #imagenes main
        $arr_img_zone                   =   [];
        #imagenes x muestras
        #$arr_img_zone_muestras         =   [];
        #LOAD_ANATOMIAPATOLOGICA_PDF 
        $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $dompdf                         =   new mPDF('','',0,'',7,7,7,7,0,0,'L');
        $html_biopsia_citologia1       .=  $this->load->view("ssan_libro_etapaanalitica/pdf_new_notificacioncancer2",array('DATA'=>$DATA,"empresa"=>$empresa),true);
        $dompdf->WriteHTML($html_biopsia_citologia1);
        #out
        $base64_pdf                     =   base64_encode($dompdf->Output($txt_name_pdf,'S'));
        $TABLA["OUT_HTML"]              =   '';
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $TABLA["IMGXZONE"]              =   $arr_img_zone;
        $this->output->set_output(json_encode($TABLA));
    }

    
    public function pdf_macroscopia_parte2(){
        if($this->session->userdata("COD_ESTAB")!=''){
            $empresa                    =   $this->session->userdata("COD_ESTAB");
        } else {
            $empresa                    =   $this->input->post('empresa');
        }
        $id_tabla                       =   $this->input->post('id');
        $html_footer                    =   '';
        $html_firma_ap                  =   '';
        #$IND_TIPO_BIOPSIA              =   '';
        $html_biopsia_citologia2        =   '';
        $html_macro1                    =   '';
        $html_micro2                    =   '';
        $html_notificacion_cancer       =   '';
        $html_conf_resumen              =   '';
        #LEYENDA
        #2.- CONTEMPORANEA
        #3.- DIFERIDA
        #4.- BIOPSIA + CITOLOGIA
        #5.- CITOLOGIA
        #6.- PAP
        $DATA                                       =   $this->Ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        $txt_name_pdf                               =   'INFORME MICROSCOPIA DE ANATOM&Iacute;A PATOL&Oacute;GICA:'.$id_tabla.'.pdf';
        #verical 
        $dompdf                                     =   new mPDF('','',0,'',7,7,7,7,0,0,'L');
        #MICROSCOPIA
        #DOBLE INFORME - BIOPSIA + CITOLOGIA
        $AUX_PAGE                                   =   1;
        $IND_TIPO_BIOPSIA                           =   $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'];
        $code_doc_patologo                          =   "";
        /*
        if ($DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_USER_PATOLOGO'] != ''){
            $partes                                 =   explode("<br>",$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_USER_PATOLOGO']);
            $subPartes                              =   explode("-", $partes[1]);
            $code_doc_patologo                      =   $this->validaciones->encodeNumber($subPartes[0].'&'.$empresa);
        }
        */
        $code_doc_patologo_citologico               =   "";
        /*
        if ($DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_USER_PATOLOGO_CITOLOGICO'] != ''){
            $partes2                                =   explode("<br>",$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_USER_PATOLOGO_CITOLOGICO']);
            $subPartes2                             =   explode("-", $partes2[1]);
            $code_doc_patologo_citologico           =   $this->validaciones->encodeNumber($subPartes2[0].'&'.$empresa);
        }
        */
        #4.- BIOPSIA + CITOLOGIA
        if($IND_TIPO_BIOPSIA                        === '4'){
            #INFORME DE BIOSIA
            $html_biopsia_citologia2                .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_biopsia_mas_citologia_2",array('DATA'=>$DATA,"empresa"=>$empresa,"num_page"=>$AUX_PAGE),true);
            $AUX_PAGE++;
            $dompdf->WriteHTML($html_biopsia_citologia2);
            $html_footer                            .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_html_footer_analitica",array('DATA'=>$DATA,"empresa"=>$empresa),true);
            $html_firma_ap                          .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_firma_patologo",array('DATA'=>$DATA,"empresa"=>$empresa,"code_doc_patologo"=>$code_doc_patologo),true);
            $dompdf->SetHTMLFooter($html_firma_ap.$html_footer);
            $dompdf->AddPage();
            #INFOME DE CITOLOGIA
            $html_biopsia_citologia1                .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_biopsia_mas_citologia_1",array('DATA'=>$DATA,"empresa"=>$empresa,"num_page"=>$AUX_PAGE),true);
            $AUX_PAGE++;
            $dompdf->WriteHTML($html_biopsia_citologia1);
            $html_firma_ap_cito                     .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_firma_patologo_citologico",array('DATA'=>$DATA,"empresa"=>$empresa,"code_doc_patologo_citologico"=>$code_doc_patologo_citologico),true);
            $dompdf->SetHTMLFooter($html_firma_ap_cito.$html_footer);
            
        } else {
            
            if($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_CONF_PAG'] == 0){
                if($IND_TIPO_BIOPSIA === '5' || $IND_TIPO_BIOPSIA === '6' ){

                } else {
                    $html_macro1                     .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_info_sala_macroscopia_parte1_1",array('DATA'=>$DATA,"empresa"=>$empresa,"num_page"=>$AUX_PAGE),true);
                    $AUX_PAGE++;
                    $dompdf->WriteHTML($html_macro1);
                    $dompdf->AddPage();
                    #$dompdf->SetHTMLFooter($html_footer);
                }
                #MACROSCOPIA
                $html_micro2                         .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_info_sala_macroscopia_parte2_1",array('DATA'=>$DATA,"empresa"=>$empresa,"num_page"=>$AUX_PAGE),true);
                $AUX_PAGE++;
                $dompdf->WriteHTML($html_micro2);
            }  else {
                $html_conf_resumen                   .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_informe_final_resumen_1",array('DATA'=>$DATA,"empresa"=>$empresa,"num_page"=>$AUX_PAGE),true);
                $AUX_PAGE++;
                $dompdf->WriteHTML($html_conf_resumen);
            }
            $html_firma_ap                           .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_firma_patologo",array('DATA'=>$DATA,"empresa"=>$empresa,"code_doc_patologo"=>$code_doc_patologo),true);
            $html_footer                             .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_html_footer_analitica",array('DATA'=>$DATA,"empresa"=>$empresa),true);
            $dompdf->SetHTMLFooter($html_firma_ap.$html_footer);
        }

        #NOTIFICACION DE CANCER
        if($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_CONF_CANCER']==1){
            $dompdf->AddPage();
            $html_notificacion_cancer               .=  $this->load->view("ssan_libro_etapaanalitica/pdf_new_notificacioncancer2",array('DATA'=>$DATA,"empresa"=>$empresa,"num_page"=>$AUX_PAGE),true);
            $AUX_PAGE++;
            $dompdf->WriteHTML($html_notificacion_cancer);        
            $html_firma_ap2                         .=  $this->load->view("ssan_libro_biopsias_listagespab/pdf_firma_patologo",array('DATA'=>$DATA,"empresa"=>$empresa),true);
            //$dompdf->WriteHTML($html_firma_ap2);
            $dompdf->SetHTMLFooter($html_firma_ap2);
        }
        
        #VISUALIAZCION DE IMAGENES X MAIN
        if(count($DATA['C_IMAGENES_BLOB'])>0){
            $dompdf->AddPage();
            $dompdf->WriteHTML($this->load->view("ssan_libro_biopsias_listagespab/pdf_info_img_x_main",array('DATA'=>$DATA,"empresa"=>$empresa),true));
        }
        $base64_pdf                     =   base64_encode($dompdf->Output($txt_name_pdf,'S'));
        $TABLA["OUT_HTML"]              =   '';
        $TABLA["EMPRESA"]               =   $empresa;
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $TABLA["GET_HTML1"]             =   $html_macro1;
        $TABLA["GET_HTML2"]             =   $html_micro2;
        $TABLA["TIPO_DE_BIOPSIA"]       =   $IND_TIPO_BIOPSIA;
        $TABLA["HTML_TEST"]             =   $html_biopsia_citologia2;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function pdf_macroscopia_parte1(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        #$html_macro                    =   '';
        #$html_micro                    =   '';
        $html_footer                    =   '';
        $html_firma_ap                  =   '';
        #$IND_TIPO_BIOPSIA              =   '';
        $html_biopsia_citologia2        =   '';
        $html_macro1                    =   '';
        $html_micro2                    =   '';
        $html_notificacion_cancer       =   '';
        $html_conf_resumen              =   '';
        $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf                   =   'INFORME MICROSCOPIA DE ANATOM&Iacute;A PATOL&Oacute;GICA:'.$id_tabla.'.pdf';
        $IND_TIPO_BIOPSIA               =   $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'];
        $dompdf                         =   new mPDF('','',0,'',7,7,7,7,0,0,'L');
        $html_notificacion_cancer      .=   $this->load->view("ssan_libro_biopsias_listagespab/pdf_info_sala_macroscopia_parte1_1",array('DATA'=>$DATA,"empresa"=>$empresa),true);
        $dompdf->WriteHTML($html_notificacion_cancer);
        $base64_pdf                     =   base64_encode($dompdf->Output($txt_name_pdf,'S'));
        $TABLA["OUT_HTML"]              =   '';
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $TABLA["GET_HTML1"]             =   $html_macro1;
        $TABLA["GET_HTML2"]             =   $html_micro2;
        $TABLA["TIPO_DE_BIOPSIA"]       =   $IND_TIPO_BIOPSIA;
        $TABLA["HTML_TEST"]             =   $html_biopsia_citologia2;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function js_compueba_tiempo(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $this->output->set_output(json_encode(array(
            'date_inicio'               =>  date("d-m-Y H:i:s",$this->input->post('v_date_inicio2'))  ,
            'date_final'                =>  date("d-m-Y H:i:s",$this->input->post('v_date_final2'))  ,
        )));
    }
   
    public function ver_gestion_cookie(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $this->output->set_output(json_encode(array(
            'STATUS'                        =>  true,
            'cookie'                        =>  $_COOKIE,
            'date'                          =>  date('d-m-Y'),
            '_COOKIE_id_anatomia'           =>  ($_COOKIE['id_anatomia']),
            '_COOKIE_id_anatomia strlen'    =>  strlen($_COOKIE['id_anatomia']),
        )));
    }
    
    public function fn_delete_cookie(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        if(isset($_COOKIE['target']))       {   
            #delete_cookie('target');      
            unset($_COOKIE['target']); 
            setcookie('target', null, -1, '/'); 
        }
        if(isset($_COOKIE['data']))         {   
            #delete_cookie('data');  
            unset($_COOKIE['data']); 
            setcookie('data', null, -1, '/'); 
        }
        if(isset($_COOKIE['id_anatomia']))  { 
            #delete_cookie('id_anatomia'); 
            unset($_COOKIE['id_anatomia']); 
            setcookie('id_anatomia', null, -1, '/'); 
        }
        $this->output->set_output(json_encode(array(
            'STATUS' => true,
            'cookie' => $_COOKIE,
            'date' => date('d-m-Y')
        )));
    }

    public function gestion_cookie(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $target                             =   $this->input->post('target');
        $date_inicio                        =   $this->input->post('date_inicio');
        $date_final                         =   $this->input->post('date_final');
        $cookie_target                      =   array(
                                                    'name'      =>  'target',
                                                    'value'     =>  $target,
                                                    'expire'    =>  86500,
                                                    'secure'    =>  false
                                                );
        $this->input->set_cookie($cookie_target);
        $cookie                             =   array(
                                                    'name'      =>  'data',
                                                    'value'     =>  json_encode(array(
                                                                        'tipo_busqueda'     =>  'por_fecha',
                                                                        'fecha_inicio'      =>  $date_inicio,
                                                                        'fecha_final'       =>  $date_final,
                                                                    )),
                                                    'expire'    =>  86500,
                                                    'secure'    =>  false
                                                );
        $this->input->set_cookie($cookie);
        $this->output->set_output(json_encode(array(
            'STATUS'    =>  true,
            'target'    =>  $target,
            'cookie'    =>  $_COOKIE,
        )));
    }
    
    public function busqueda_individual_etapa_analitica(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa                            =   $this->session->userdata('COD_ESTAB');
        $html                               =   '';
        $class_active                       =   '';
        $txt_error                          =   '';
        $ARR_CASETE_ORD                     =   [];
        $data_main                          =   [];
        $arr_waring                         =   [];
        $arr_li_html                        =   [];
        $ids_anatomia                       =   array();
        $status                             =   true;
        $get_etiqueta                       =   $this->input->post('get_etiqueta');
        $NUM_FASE                           =   $this->input->post('NUM_FASE');
        $array_data                         =   $this->input->post('array_data');
        /*
        $from                               =   $this->input->post('from');
        $opcion                             =   $this->input->post('opcion');
        $vista                              =   $this->input->post('vista');
        $IND_MODAL                          =   $this->input->post('MODAL');
        */
        $data_return                        =   '';
        $DATA                               =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_INFOXMUESTRAANATOMIACA(
                                                array(
                                                    "COD_EMPRESA"       =>  $empresa,
                                                    "TXTMUESTRA"        =>  $get_etiqueta,
                                                    "NUM_FASE"          =>  $NUM_FASE,
                                                    "ARR_DATA"          =>  count($array_data["array_anatomia"])>0?implode(",",$array_data["array_anatomia"]):'null', 
                                                ));
        //preguntar si el id de anatomia se encuentra en la cookie
        if(count($DATA["P_ANATOMIA_PATOLOGICA_MAIN"])>0){
            //trasforma en cookie (string) - a array
            if(isset($_COOKIE['id_anatomia'])){
                $arr_ids_bacode             =   json_decode($_COOKIE['id_anatomia']) ;
                if (count($arr_ids_bacode)>0){
                    foreach($arr_ids_bacode as $i => $ids){
                        array_push($ids_anatomia,$ids);  
                    } 
                } 
            }
            foreach($DATA["P_ANATOMIA_PATOLOGICA_MAIN"] as $i => $row){
                    $html               =   '';
                if(in_array($row["ID_SOLICITUD"],$ids_anatomia)) {
                    //$status           =   false;
                    $arr_waring[]       =   'Muestra '.$get_etiqueta.' Ya se encuentra registrada';
                } else {
                    $class_active       =   '';
                    $n_image_views      =   $row["N_IMAGE_VIEWS"]==0?'disabled':'onclick="ver_imagenes('.$row["ID_SOLICITUD"].')"';
                    //$en_proceso       =   $i==0?'<i class="fa fa-circle parpadea" style="color:#00EAE5" aria-hidden="true"></i>&nbsp;<b>EN PROCESO</b>':'';
                    $html               .=  '<a href="#" class="list-group-item list-group-item-action '.$class_active.'" style="PADDING: 0PX;" >
                                                <div class="grid_a_rce_anatomiapatologica">
                                                    <div class="grid_a_rce_anatomiapatologica1"><b>'.($i+1).'</b></div>
                                                    <div class="grid_a_rce_anatomiapatologica2">
                                                        <i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;<b>'.$row["RUTPACIENTE"].'</b>&nbsp;<br>
                                                        <i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;<b>'.$row["NOMBRE_COMPLETO"].'</b>&nbsp;<br>
                                                        <i class="fa fa-birthday-cake" aria-hidden="true"></i>&nbsp;<b>'.$row["NACIMIENTO"].'</b> 
                                                    </div>
                                                    <div class="grid_a_rce_anatomiapatologica3">
                                                        <i class="fa fa-address-card" aria-hidden="true"></i><b>'.$row["COD_RUTPRO"].'-'.$row["DV"].'</b>
                                                        <br>
                                                        <i class="fa fa-user-md" aria-hidden="true"></i><b>'.$row["NOM_PROFE_CORTO"].'</b>
                                                        <br>
                                                    </div>
                                                    <div class="grid_a_rce_anatomiapatologica4" style="text-align: end;">
                                                        <b>'.$row["TIPO_DE_BIOPSIA"].'</b><br>
                                                        <b>N&deg; DE  MUESTRAS : '.$row["N_MUESTRAS_TOTAL"].'</b><br>
                                                        <b>'.$row["DATE_FECHA_REALIZACION"].'</b>
                                                    </div>
                                                    <div class="grid_a_rce_anatomiapatologica6" style="text-align: end;">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info btn-fill" id="btn_gestion_analitica" onclick="star_analitica('.$row["ID_SOLICITUD"].')">
                                                                <i class="fa fa-stethoscope" aria-hidden="true"></i>
                                                            </button>
                                                            <!--
                                                            <button type="button" class="btn btn-warning btn-fill" id="btn_info_analitica" onclick="pop_informacion('.$row["ID_SOLICITUD"].')">
                                                                <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                                            </button>
                                                            -->
                                                            <button type="button" class="btn btn-warning btn-fill ver_imagenes_central" id="vista_'.$row["ID_SOLICITUD"].'" '.$n_image_views.' data-visualizaimg="false">
                                                               <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                        <br>';

                                                    $txt_day    =   $row["LAST_DATE_AUDITA_MOMENT"]===date("Ymd")?'hours':'day';
                                                    $html       .=  '
                                                                    <small><i class="fa fa-refresh" aria-hidden="true"></i></small>
                                                                    <small id="txt_moment_'.$row["ID_SOLICITUD"].'"></small> 
                                                                    <script>
                                                                        setTimeout(function(){
                                                                            $("#txt_moment_'.$row["ID_SOLICITUD"].'").html(moment("'.$row["LAST_DATE_AUDITA"].'","DD-MM-YYYY HH:mm").startOf("'.$txt_day.'").fromNow());
                                                                        },1000);
                                                                    </script>
                                                                    ';

                                                    $html       .='
                                                    </div>
                                                </div>
                                            </a>    
                                            ';
                    array_push($ids_anatomia,$row["ID_SOLICITUD"]);
                    array_push($arr_li_html,$html);                        
                }
            }
            if (count($ids_anatomia)>0){
                $this->input->set_cookie(array(
                    'name'      =>  'id_anatomia',
                    'value'     =>  json_encode($ids_anatomia),
                    'expire'    =>  86500,
                    'secure'    =>  false
                ));
            }
        } else {
            $txt_error                      =   'Muestra no encontrada';
            $status                         =   false;
        }
        #out json
        $this->output->set_output(json_encode(array(
            'status' =>  $status,
            'P_ANATOMIA_PATOLOGICA_MAIN' =>  $DATA["P_ANATOMIA_PATOLOGICA_MAIN"],
            'txt_error' =>  $txt_error,
            'HTML_VIWE' =>  $html,
            'arr_li_html' =>  $arr_li_html,
            'arr_waring' =>  $arr_waring,
            'ids_x_bacode' =>  $ids_anatomia,
            'RETURN' =>  $data_return,
            'BUSQ' =>  $get_etiqueta,
            'EMPRESA' =>  $empresa,
            'DATA_GET' =>  $array_data,
            'data_main' =>  $data_main,
            'ARR_CASETE_ORD' =>  $ARR_CASETE_ORD,
        )));
    }
    
    public function get_update_img_etapas(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $id_anatomia                    =   $this->input->post('id_anatomia');
        $return_data                    =   $this->Ssan_libro_etapaanalitica_model->busqueda_img_clob($id_anatomia);
        $html                           =   $this->load->view("ssan_libro_etapaanalitica/html_views_imagenes_carrusel",$return_data,true);
        $this->output->set_output(json_encode(array(
            'return_data'               =>  $return_data,
            'html'                      =>  $html,
        )));
    }
    
    public function visualiza_carrusel(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $html                           =   '';
        $id_anatomia                    =   $this->input->post('id_anatomia');
        $return_data                    =   $this->Ssan_libro_etapaanalitica_model->busqueda_img_clob($id_anatomia);
        $v_count_img_main               =   count($return_data['data_bd'][':C_IMAGENES_BLOB']);
        $v_count_img_muestra            =   count($return_data['data_bd'][':C_IMAGENES_BLOB_MUESTRAS']);
        $v_img_total                    =   ($v_count_img_main+$v_count_img_muestra);
        $aux_global                     =   0;
        if($v_img_total>0){
            $arr_li                     =   array();
            $arr_img                    =   array();
            if($v_count_img_main > 0){
                foreach($return_data['data_bd'][':C_IMAGENES_BLOB'] as $i => $row){
                    $class_act          =   $aux_global==0?'class="active"':'';
                    $class              =   $aux_global==0?'active':'';
                    $arr_li[]           =   '<li data-target="#carousel_example_generic" data-slide-to="'.$i.'" '.$class_act.'></li>';
                    $arr_img[]          =   '<div class="item '.$class.' d-flex justify-content-center"><img src="'.$row["IMG_DATA"].'" alt="'.$i.'"><div class="carousel-caption">'.$row["NAME_IMG"].'</div></div>';
                    $aux_global++;
                }
            }
            if($v_count_img_muestra > 0){
                foreach($return_data['data_bd'][':C_IMAGENES_BLOB_MUESTRAS'] as $i => $row){
                    $class_act          =   $aux_global==0?'class="active"':'';
                    $class              =   $aux_global==0?'active':'';
                    $arr_li[]           =   '<li data-target="#carousel_example_generic" data-slide-to="'.$i.'" '.$class_act.'></li>';
                    $arr_img[]          =   '<div class="item '.$class.' d-flex justify-content-center"><img src="'.$row["IMG_DATA"].'" alt="'.$i.'"><div class="carousel-caption">'.$row["NAME_IMG"].'</div></div>';
                    $aux_global++;
                }
            }
            $html                       =   '
                                                <div class="row">
                                                   <div class="col col-lg-12" style="padding:10px;">
                                                       <div id="carousel_example_generic" class="carousel slide" data-ride="carousel" style="padding:20px;">
                                                            <ol class="carousel-indicators">'.implode(" ",$arr_li).'</ol>
                                                            <div class="carousel-inner" role="listbox">'.implode(" ",$arr_img).'</div>
                                                            <a class="left carousel-control" href="#carousel_example_generic" role="button" data-slide="prev">
                                                               <span class="fa fa-fast-backward" aria-hidden="true"></span>
                                                               <span class="sr-only">Previos</span>
                                                            </a>
                                                            <a class="right carousel-control" href="#carousel_example_generic" role="button" data-slide="next">
                                                               <span class="fa fa-fast-forward" aria-hidden="true"></span>
                                                               <span class="sr-only">Pr&oacute;ximo</span>
                                                            </a>
                                                       </div>
                                                   </div>
                                               </div>
                                            ';
        }
        $this->output->set_output(json_encode(array(
            'return_data'               =>  $return_data,
            'html'                      =>  $html,
        )));
    }
    
    public function html_nueva_plantilla(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $get_sala                       =   $this->input->post('get_sala');
        //$return_data                  =   [];
        //$html                         =   '';
        /*
        $ID_ANATOMIA                    =   $this->input->post('ID_ANATOMIA');
        $get_sala                       =   $this->input->post('get_sala');
        $return_data                    =   $this->Ssan_libro_etapaanalitica_model->ap_subir_imagenprotoclo_ap($empresa,$ID_ANATOMIA,$get_sala);
        */
        $html                           =    $this->load->view("ssan_libro_etapaanalitica/html_new_plantilla",[],true);
        $this->output->set_output(json_encode(array(
            "status_session"            =>  true,
            "html"                      =>  $html,
        )));
    }
    
    public function star_gestor_plantillas(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $get_sala                       =   $this->input->post('get_sala');
        $opcion                         =   $this->input->post('opcion');
        $num_muestras                   =   $this->input->post('num_muestras');
        $txt_muestra                    =   $this->input->post('txt_muestra');
        
        $DATA                           =   $this->Ssan_libro_etapaanalitica_model->load_data_plantillas_anatomia(array(
                                                "cod_empresa"       =>  $empresa,
                                                "num_muestras"      =>  $num_muestras,
                                                "session"           =>  $this->session->userdata("USERNAME"),
                                                "id_uid"            =>  $this->session->userdata("ID_UID"), 
                                                "txt_muestra"       =>  $txt_muestra,
                                            ));
        if ($opcion == 1 || $opcion == 0){
            $html                       =    $this->load->view("ssan_libro_etapaanalitica/html_gestor_plantillas",$DATA,true);
        } else {
            $html                       =    $this->load->view("ssan_libro_etapaanalitica/html_gestor_li_plantillas",$DATA,true);
        }
        $this->output->set_output(json_encode(array(
            "status_session"            =>  true,
            "html"                      =>  $html,
        )));
    }
    
    public function get_elimina_plantilla(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $num_plantilla                  =   $this->input->post('num_plantilla');
        $contrasena                     =   $this->input->post('contrasena');     
        $status_firma                   =   true;
        $return                         =   '';
        $arr_user                       =   $this->Ssan_libro_etapaanalitica_model->sqlvalidaclave($contrasena);
        if(count($arr_user)>0){
            $return                     =   $this->Ssan_libro_etapaanalitica_model->get_elimina_plantilla(array( 
                'empresa'               =>  $empresa,
                'num_plantilla'         =>  $num_plantilla,
                'data_firma'            =>  $arr_user,
                'session'               =>  $this->session->userdata("USERNAME"),
            ));
        } else {
            $status_firma               =  false;
        }
        $this->output->set_output(json_encode(array(
            "status_contrasena"         =>  $status_firma,
        )));
    }
    
    public function get_graba_nueva_plantilla(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status_contrasena = true;
        $html = '';
        $return = [];
        $empresa = $this->session->userdata("COD_ESTAB");
        $get_sala = $this->input->post('get_sala');
        $txt_titulo = $this->input->post('txt_titulo'); 
        $txt_cuerpo = $this->input->post('txt_cuerpo');  
        $contrasena = $this->input->post('contrasena');  
        $arr_user = $this->Ssan_libro_etapaanalitica_model->sqlvalidaclave($contrasena);
        if(count($arr_user)>0){
            $return = $this->Ssan_libro_etapaanalitica_model->graba_nueva_plantilla(array( 
                'empresa' => $empresa,
                'get_sala' => $get_sala,
                'txt_titulo' => $txt_titulo,
                'txt_cuerpo' => $txt_cuerpo,
                'data_firma' => $arr_user,
                'session' => $this->session->userdata("USERNAME"),
            ));
        } else {
            $status_contrasena = false;
        }
        $this->output->set_output(json_encode(array(
            "status_contrasena" => $status_contrasena,
            "status_session" => true,
            "html" => $html,
            "return" => $return,
        )));
    }
    
    #up 
    public function new_gestiondeimagenes_fetch_json(){
        $empresa = $this->session->userdata("COD_ESTAB");
        $return_data = [];
        $ID_ANATOMIA = $this->input->post('ID_ANATOMIA');
        $get_sala = $this->input->post('get_sala');
        $return_data = $this->Ssan_libro_etapaanalitica_model->ap_subir_imagenprotoclo_ap($empresa,$ID_ANATOMIA,$get_sala);
        $this->output->set_output(json_encode(array(
            "ID_IMAGEN" =>  $return_data,
            "FILES" =>  $_FILES,
            "ID_AP" =>  $ID_ANATOMIA,
            "txt_sala" =>  $get_sala,
        )));
    }

    public function gestor_imagenes_x_muestras(){
        $empresa = $this->session->userdata("COD_ESTAB");
        $ID_ANATOMIA = $this->input->post('ID_ANATOMIA');
        $return_data = $this->Ssan_libro_etapaanalitica_model->subir_imagenprotoclo_ap_x_muestra([
            'empresa' => $empresa,
            'id_anatomia' => $ID_ANATOMIA,
            'id_muestra' =>  $this->input->post('id_muestra'),  
            'id_casete' =>  $this->input->post('id_casete'),
            'ind_zona' =>  $this->input->post('ind_zona'),
            'tipo_muestra' =>  $this->input->post('tipo_muestra'),
        ]);
        $RETURN["ID_IMAGEN"] = $return_data;
        $RETURN["FILES"] = $_FILES;
        $RETURN["ID_AP"] = $ID_ANATOMIA;
        $this->output->set_output(json_encode($RETURN));
    }
    
    public function actualiza_chat_all(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $option = $this->input->post('option'); 
        $id_anatomia = $this->input->post('id_anatomia');
        $txt_mensaje = $this->input->post('txt_mensaje');
        $return_data = $this->Ssan_libro_etapaanalitica_model->graba_chat_anatomia(
        array(
            "id_anatomia" => $id_anatomia,
            "txt_mensaje" => $txt_mensaje,
            "option" => $option,
        ));
        $this->output->set_output(json_encode(array(
            'txt_anatomia' => $this->input->post('txt_mensaje'),
            'out_bd' => $return_data,
            'userdata' => $this->session->userdata,
            'id_anatomia' => $id_anatomia,
            'user' =>  $this->session->userdata["NAMESESSION"],
            'ip' =>  $this->session->userdata["IP"],
        )));
    }
    
    #rce patologo
    public function formulario_main_analitico(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $cod_empresa = $this->session->userdata("COD_ESTAB");
        $get_sala = $this->input->post('get_sala');
        $html = '';
        $_issesion = true;
        if($cod_empresa == ''){
            $_issesion = false;
        } else {
            $DATA_CURSOR = $this->Ssan_libro_etapaanalitica_model->load_informacion_rce_patologico_new(array(
                "cod_empresa" => $this->session->userdata("COD_ESTAB"),
                "usr_session" => explode("-",$this->session->userdata("USERNAME"))[0],
                "ind_opcion" => 0,
                "ind_first" => 0,
                "id_anatomia" => $this->input->post('id_anatomia'),
                "num_fase" => 4,
                "ind_template" => "ssan_libro_etapaanalitica",
                "get_sala" => $get_sala,
            ));
            $html = $this->load->view("ssan_libro_etapaanalitica/template_default_analitica",$DATA_CURSOR,true);
        }
        $this->output->set_output(json_encode(array(
            'status_session' => $_issesion,
            'info_bd' => $DATA_CURSOR,
            'out_html' => $html
        )));
    }

    public function ultimo_numero_disponible_cancer(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status = true;
        $empresa = $this->session->userdata("COD_ESTAB");
        $ind_tipo_biopsia = $this->input->post('tipo_biopsia'); 
        $data_number = $this->Ssan_libro_etapaanalitica_model->ultimo_numero_disponible_cancer(array(
            "val_empresa" => $empresa,
            "ind_tipo_biopsia" => $ind_tipo_biopsia,
        ));
        $this->output->set_output(json_encode(array(
            'status' => $status,
            'data_numero' => $data_number,
        )));
    }
    
    public function gestion_perfil_administrativo(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $cod_empresa                    =   $this->session->userdata("COD_ESTAB");
        $get_sala                       =   $this->input->post('get_sala');
        $html                           =   '';
        $_issesion                      =   true;
        if ($cod_empresa                ==  ''){
            $_issesion                  =   false;
        } else {
            $DATA_CURSOR                =   $this->Ssan_libro_etapaanalitica_model->load_informacion_rce_patologico(
            array(
                "cod_empresa"           =>  $this->session->userdata("COD_ESTAB"),
                "usr_session"           =>  explode("-",$this->session->userdata("USERNAME"))[0],
                "ind_opcion"            =>  0,
                "ind_first"             =>  0,
                "id_anatomia"           =>  $this->input->post('id_anatomia'),
                "num_fase"              =>  4,
                "ind_template"          =>  "ssan_libro_etapaanalitica",
                "get_sala"              =>  $get_sala,
            ));
            $html                       =   $this->load->view("ssan_libro_etapaanalitica/template_default_analitica",$DATA_CURSOR,true);
        }
        $this->output->set_output(json_encode(array(
            'status_session'            =>  $_issesion,
            'info_bd'                   =>  $DATA_CURSOR,
            'out_html'                  =>  $html
        )));
    }
    public function star_descripcion_anatomia(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $cod_empresa = $this->session->userdata("COD_ESTAB");
        $get_sala = $this->input->post('get_sala');
        $html = '';
        $_issesion = true;
        $DATA_CURSOR = [];
        if ($cod_empresa == ''){
            $_issesion = false;
        } else {
            #PROCE =  LOAD_RCE_ANATOMIA_PATOLOGICA
            $DATA_CURSOR =   $this->Ssan_libro_etapaanalitica_model->load_informacion_rce_patologico_new(array(
                "cod_empresa" =>  $this->session->userdata("COD_ESTAB"),
                "usr_session" =>  explode("-",$this->session->userdata("USERNAME"))[0],
                "ind_opcion" =>  0,
                "ind_first" =>  0,
                "id_anatomia" =>  $this->input->post('id_anatomia'),
                "num_fase" =>  4,
                "ind_template" =>  "ssan_libro_etapaanalitica",
                "get_sala" =>  $get_sala,
            ));
            $html = $this->load->view("ssan_libro_etapaanalitica/template_default_analitica",$DATA_CURSOR,true);
        }
        $this->output->set_output(json_encode(array(
            'status_session' => $_issesion,
            'info_bd' => $DATA_CURSOR,
            'out_html' => $html
        )));
    }
    
    
    public function update_li_chat(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $status                         =   true;
        $id_anatomia                    =   $this->input->post('id_anatomia');
        $return                         =   $this->Ssan_libro_etapaanalitica_model->update_li_chat(array('id_anatomia'=>$id_anatomia));
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return'                    =>  $return,
        )));
    }
    
    public function delete_img(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $status                         =   true;
        $ID_IMG                         =   $this->input->post('ID_IMG');
        $return                         =   $this->Ssan_libro_etapaanalitica_model->delete_img(array( 
            'ID_IMG'                    =>  $ID_IMG,
            'session'                   =>  explode("-",$this->session->userdata("USERNAME"))[0],
        ));
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return'                    =>  $return,
        )));
    }
    
    public function delete_img_x_muestra(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $status                         =   true;
        $ID_IMG                         =   $this->input->post('ID_IMG');
        $ID_MUESTRA                     =   $this->input->post('ID_MUESTRA');
        $ID_SOLICITUD                   =   $this->input->post('ID_SOLICITUD');
        $return                         =   $this->Ssan_libro_etapaanalitica_model->delete_img_x_muestra(
                                            array( 
                                                'ID_IMG'                        =>  $ID_IMG,
                                                'session'                       =>  explode("-",$this->session->userdata("USERNAME"))[0],
                                            ));
        $json_config                    =   htmlspecialchars(json_encode([
                        'return_div'    =>  'card_img_'.$ID_MUESTRA,
                        'return_div2'   =>  'vista_x_muestra_'.$ID_MUESTRA,
                        'txt_zona'      =>  'salamacroscopia',
                        'ind_zona'      =>  '1',
                        'tipo_muestra'  =>  'anatomica',
                        'id_anatomia'   =>  $ID_SOLICITUD,
                        'id_muestra'    =>  $ID_MUESTRA,
                        'id_casete'     =>  null,
                    ]),ENT_QUOTES,'UTF-8');
        $html                           =   '<div class="card" style="margin-bottom:0px;text-align:-webkit-center;padding:6px;">
                                                    <div style="background-color: transparent !important; text-align: center">
                                                        <div class="font_15"><b>SUBIR</b></div>
                                                    </div>
                                                    <hr style="margin-top:10px;margin-bottom:10px">
                                                    <div class="text-center">
                                                        <div class="custom-file" style="cursor:pointer;">
                                                            <label for="img_macro_a_'.$ID_MUESTRA.'">
                                                                <i class="fa fa-file-image-o fa-4x" aria-hidden="true" style=" width:100px;"></i>
                                                            </label>
                                                            <input 
                                                                type            =   "file" 
                                                                data-config     =   "'.$json_config.'" 
                                                                id              =   "img_macro_a_'.$ID_MUESTRA.'" 
                                                                name            =   "img_macro_a_'.$ID_MUESTRA.'" 
                                                                onchange        =   "js_adjunto_ap_multiple(this.id,this.files);" 
                                                                accept          =   "image/png,image/jpeg">
                                                        </div>
                                                    </div>
                                                </div>';
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return'                    =>  $return,
            'html'                      =>  $html,
        )));
    }
    
    public function guardado_previo_anatomiapatologica(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $status = true;
        $accesdata = $this->input->post('accesdata');
        $id_anatomia = $this->input->post('id_anatomia');
        $id_salida = $this->input->post('id_salida');
        $return = $this->Ssan_libro_etapaanalitica_model->guardado_anatomia_patologica(array( 
            'accesdata' => $accesdata,
            'id_anatomia' => $id_anatomia,
            'session' => explode("-",$this->session->userdata("USERNAME"))[0],
            'id_salida' =>  $id_salida,
        ));
        $this->output->set_output(json_encode(array(
            'status' => $status,
            'return' => $return,
        )));
    }

    #finalizacion de rce
    public function finaliza_reporte_anatomia_patologica(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $status_contrasena              =   true;
        $status                         =   true;
        $return                         =   [];
        $accesdata                      =   $this->input->post('accesdata');
        $id_anatomia                    =   $this->input->post('id_anatomia');
        $id_salida                      =   $this->input->post('id_salida');
        $contrasena                     =   $this->input->post('contrasena'); 
        $arr_user                       =   $this->Ssan_libro_etapaanalitica_model->sqlvalidaclave($contrasena);
        if(count($arr_user)>0)  {
            $return             =   $this->Ssan_libro_etapaanalitica_model->guardado_anatomia_patologica(array( 
                'accesdata'     =>  $accesdata,
                'id_anatomia'   =>  $id_anatomia,
                'session'       =>  explode("-",$this->session->userdata("USERNAME"))[0],
                'id_salida'     =>  $id_salida,
            ));
        } else {
            $status_contrasena  =   false;
        }
        $this->output->set_output(json_encode(array(
            'status_pass'               =>  $status_contrasena,
            'status'                    =>  $status,
            'return'                    =>  $return,
        )));
    }
    
    public function guardado_perfil_administrativo() {
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $status                         =   true;
        $status_firma                   =   true;
        $return                         =   [];
        $contrasena                     =   $this->input->post('contrasena'); 
        $accesdata                      =   $this->input->post('accesdata');
        $id_anatomia                    =   $this->input->post('id_anatomia');
        $arr_user                       =   $this->Ssan_libro_etapaanalitica_model->sqlvalidaclave($contrasena);
        if(count($arr_user)>0){
            $return                     =   $this->Ssan_libro_etapaanalitica_model->guarda_informacion_perfil_administrativo(array( 
                'accesdata'             =>  $accesdata,
                'id_anatomia'           =>  $id_anatomia,
                'session'               =>  explode("-",$this->session->userdata("USERNAME"))[0],
                'data_firma'            =>  $arr_user,
            ));
        } else {
            $status_firma               =   false;
        }
        $this->output->set_output(json_encode(array(
            'status_firma'              =>  $status_firma,
            'status'                    =>  $status,
            'return'                    =>  $return,
            'arr_user'                  =>  $arr_user,
        )));
    }
    
    public function get_informr_macroscopica(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $return = '';
        $status = true;
        $contrasena = $this->input->post('contrasena'); 
        $accesdata = $this->input->post('accesdata');
        $array_main = $this->input->post('array_main');
        $id_anatomia = $this->input->post('id_anatomia');
        $arr_user = $this->Ssan_libro_etapaanalitica_model->sqlvalidaclave($contrasena);
        if(count($arr_user)>0){
            $return = $this->Ssan_libro_etapaanalitica_model->get_informe_macroscopica(array( 
                'array_main' =>  $array_main,
                'accesdata' => $accesdata,
                'id_anatomia' => $id_anatomia,
                'session' => explode("-",$this->session->userdata("USERNAME"))[0],
            ));
        } else {
            $status = false;
        }
        $this->output->set_output(json_encode(array(
            'status' => $status,
            'return' => $return,
        )));
    }


    public function elimina_imagen(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $status                         =   true;
        $img                            =   $this->input->post('img'); 
        $return                         =   $this->Ssan_libro_etapaanalitica_model->get_elimina_imagen(array( 
                                                'img' =>  $img,
                                                'session' =>  explode("-",$this->session->userdata("USERNAME"))[0],
                                            ));
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return'                    =>  $return,
        )));
    }
    
    public function load_excel_final(){
        $this->load->library('excel');
        $date_fecha_inicio              =   $this->input->get('date_inicio');
        $date_fecha_final               =   $this->input->get('date_final');
        $txt_meses                      =   array(1=>'Ene',     2=>'Feb',       3=>'Mar',   4=>'Abr',   5=>'May',   6=>'Jun',   7=>'Jul',   8=>'Ago',   9=>'Sep',       10=>'Oct',      11=>'Nov',      12=>'Dic');
        $txt_meses_2                    =   array(1=>'ENERO',   2=>'FEBRERO',   3=>'MARZO', 4=>'ABRIL', 5=>'MAYO',  6=>'JUNIO', 7=>'JULIO', 8=>'AGOSTO',9=>'SEPTIEMBRE',10=>'OCTUBRE',  11=>'NOVIEMBRE',12=>'DICIEMBRE');
        //************************************************************************************************************  
        #FFFF00                         =   amarillo;
        #0004FF                         =   azul;
        #000000                         =   negro
        #FFFFFF                         =   blanco
        $objPHPExcel                    =   new PHPExcel();
        $ExcelInstit                    =   $objPHPExcel->setActiveSheetIndex(0);
        #COLORES A LA PRIMERA FILA
        #A1:AR1
        $ExcelInstit->getStyle('A1:AR1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('A1:AR1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('A1:AR1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'0004FF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFF00')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #AS:AU
        $ExcelInstit->getStyle('AS1:AU1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('AS1:AU1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('AS1:AU1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'4682b4')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #AV:AW
        $ExcelInstit->getStyle('AV1:AW1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('AV1:AW1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('AV1:AW1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'000000'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'d9b076')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #AX:AZ
        $ExcelInstit->getStyle('AX1:AZ1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('AX1:AZ1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('AX1:AZ1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'ff1493')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BA:BE
        $ExcelInstit->getStyle('BA1:BE1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BA1:BE1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BA1:BE1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'000000'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'f29186')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BF:BG
        $ExcelInstit->getStyle('BF1:BG1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BF1:BG1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BF1:BG1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'000000'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'ffff00')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BH:BI
        $ExcelInstit->getStyle('BH1:BI1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BH1:BI1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BH1:BI1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'0000ff')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BJ
        $ExcelInstit->getStyle('BJ1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BJ1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BJ1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'ff0500')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BK
        $ExcelInstit->getStyle('BK1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BK1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BK1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'ff00ff')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BL:BM
        $ExcelInstit->getStyle('BL1:BM1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BL1:BM1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BL1:BM1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'0000ff')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BN:BO
        $ExcelInstit->getStyle('BN1:BO1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BN1:BO1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BN1:BO1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'0000ff')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        
        #BP
        $ExcelInstit->getStyle('BP1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BP1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BP1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'0d6e79')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BQ
        $ExcelInstit->getStyle('BQ1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BQ1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BQ1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'0000ff')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BR
        $ExcelInstit->getStyle('BR1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BR1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BR1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'0000ff')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        
        #BR
        $ExcelInstit->getStyle('BR1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BR1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BR1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'000000'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'00ff00')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        
        #BS
        $ExcelInstit->getStyle('BS1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BS1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BS1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'000000'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'00ff00')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BT
        $ExcelInstit->getStyle('BT1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BT1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BT1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'000000'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'00ff00')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BU:BW
        $ExcelInstit->getStyle('BU1:BW1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BU1:BW1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BU1:BW1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'0004FF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFF00')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BX:CA
        $ExcelInstit->getStyle('BX1:CA1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BX1:CA1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BX1:CA1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'c6a664')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #BX:CA
        $ExcelInstit->getStyle('BU1:BW1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('BU1:BW1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('BU1:BW1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'000000'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'f29186')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #CB
        $ExcelInstit->getStyle('CB1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('CB1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('CB1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'000000'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'eb636b')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        #CC
        $ExcelInstit->getStyle('CC1')->getFont()->setBold(true);
        $ExcelInstit->getStyle('CC1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $ExcelInstit->getStyle('CC1')->applyFromArray(array(
                                                                'font'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                                                'fill'      =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'6576b4')),//cell
                                                                'borders'   =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                                            ));
        
        $ExcelInstit->setTitle('PRODUCCIÓN ANATOMÍA PATOLÓGICA');
        $ExcelInstit->setCellValue('A1','N° BIOPSIA')
                    ->setCellValue('B1','NOMBRE 1')
                    ->setCellValue('C1','NOMBRE 2')
                    ->setCellValue('D1','APELLIDO 1')
                    ->setCellValue('E1','APELLIDO 2')
                    ->setCellValue('F1','RUT')
                    ->setCellValue('G1','N° DE FICHA')
                    ->setCellValue('H1','--')
                    ->setCellValue('I1','N° MEMO NOTIFICACIÓN')    
                    ->setCellValue('J1','INFORME REALIZADO POR')
                    ->setCellValue('K1','--')
                    ->setCellValue('L1','--')
                    ->setCellValue('M1','ARCHIVADA EN FICHA')
                    ->setCellValue('N1','REVISIÓN INFORME')
                    ->setCellValue('O1','REVISIÓN BASE DATOS')
                    ->setCellValue('P1','--')
                    ->setCellValue('Q1','--')
                    ->setCellValue('R1','CHEQUEO SISTEMA SOME')
                    ->setCellValue('S1','FECHA TOMA DE MUESTRA')  
                    ->setCellValue('T1','MES')          
                    ->setCellValue('U1','FECHA RECEPCIÓN')  
                    ->setCellValue('V1','HORA DE RECEPCIÓN')
                    ->setCellValue('W1','MEDICO')
                    ->setCellValue('X1','ESTABLECIMIENTO')
                    ->setCellValue('Y1','SERVICIO') 
                    ->setCellValue('Z1','TIPO DE MUESTRA')
                    ->setCellValue('AA1','N° DE MUESTRAS')
                    ->setCellValue('AB1','N° BENEFICIARIOS')
                    ->setCellValue('AC1','UBICACIÓN')
                    ->setCellValue('AD1','PIEZA QUIRURGICA')
                    ->setCellValue('AE1','DIAGNOSTICO CLINICO')
                    ->setCellValue('AF1','DIAGNOSTICO DE CANCER')
                    ->setCellValue('AG1','NOMBRE FUNCIONARIO QUE TRASLADA LA MUESTRA')
                    ->setCellValue('AH1','NOMBRE FUNCIONARIO QUE RECIBE LA MUESTRA')
                    ->setCellValue('AI1','EDAD')
                    ->setCellValue('AJ1','PREVISIÓN')
                    ->setCellValue('AK1','N° BIOPSIA')
                    ->setCellValue('AL1','MES CRITICO')
                    ->setCellValue('AM1','FECHA DE DIAGNOSTICO')
                    ->setCellValue('AN1','FECHA DE IMPRESIÓN INFORME')
                    ->setCellValue('AO1','FECHA ENTREGA INFORME')
                    ->setCellValue('AP1','HORA DE ENTREGA')
                    ->setCellValue('AQ1','NOMBRE FUNCIONARIO QUE ENTREGA INFORME')
                    ->setCellValue('AR1','NOMBRE FUNCIONARIO QUE RECIBE INFORME')
                    ->setCellValue('AS1','DÍAS DE ENTREGA (FECHA DE RECEPCIÓN DE BIOPSIA - FECHA DE ENTREGA DE INFORME)')
                    ->setCellValue('AT1','CUMPLE/NO CUMPLE')
                    ->setCellValue('AU1','PLAZO BIOPSIAS (DÍAS)')
                    ->setCellValue('AV1','DÍAS DE ENTREGA (FECHA DE EMISIÓN INFORME A FECHA ENTREGA)')
                    ->setCellValue('AW1','CUMPLIMIENTO BP DIFERIDA (7 DÍAS HABILES)')
                    #CANCER
                    ->setCellValue('AX1','CUMPLIMIENTO BP DG CLÍNICO DE CÁNCER')
                    ->setCellValue('AY1','CUMPLE / NO CUMPLE - BP CRITICAS')
                    ->setCellValue('AZ1','PLAZO ENTREGA BIOPSIAS CRITICAS (DÍAS)')
                    ->setCellValue('BA1','INICIO HORA CUMPLIMIENTO BP DG CLÍNICO DE CÁNCER')
                    ->setCellValue('BB1','TERMINO HORA BP CRITICAS')
                    ->setCellValue('BC1','HORAS TRASCURRIDAS')
                    ->setCellValue('BD1','CUMPLE / NO CUMPLE')
                    ->setCellValue('BE1','HORAS ASIGNADAS')
                    #LOS OTROS
                    ->setCellValue('BF1','ESTADIO OLGA')
                    ->setCellValue('BG1','DIAGNOSTICO')
                    ->setCellValue('BH1','FECHA DE MACRO')
                    ->setCellValue('BI1','FECHA DE CORTE')
                    ->setCellValue('BJ1','MES')
                    ->setCellValue('BK1','N° BIOPSIA')
                    ->setCellValue('BL1','HOSPITAL/CESFAM')
                    ->setCellValue('BM1','SERVICIO')
                    ->setCellValue('BN1','COLOR DE TACO')
                    ->setCellValue('BO1','INTERCONSULTA')
                    ->setCellValue('BP1','COPIA INTERC')
                    ->setCellValue('BQ1','N° BENEFICIARIOS')
                    ->setCellValue('BR1','NUMERO DE FRAGMENTOS')
                    ->setCellValue('BS1','ORGANO O TEJIDO')
                    ->setCellValue('BT1','N° DE MUESTRAS')
                    ->setCellValue('BU1','N° CASSETT')
                    ->setCellValue('BV1','N° TACOS CORTADOS')
                    ->setCellValue('BW1','N° EXTENDIDOS')
                    ->setCellValue('BX1','AZUL ALCIAN SERIADA')
                    ->setCellValue('BY1','PAS SERIADA')
                    ->setCellValue('BZ1','DIFF 3 SERIADA')
                    ->setCellValue('CA1','H/E SERIADA')
                    ->setCellValue('CB1','TOTAL, LÁMINAS SERIADAS')
                    ->setCellValue('CC1','H/E RÁPIDA');
        
        #setAutoSize_hasta_el_momento
        for($i='A';$i!=$objPHPExcel->getActiveSheet()->getHighestColumn();$i++){
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        
        #GET CONSULTA
        $data_produccion                =   $this->Ssan_libro_etapaanalitica_model->load_info_excel_produccion(array(
            "cod_empresa"               =>  $this->session->userdata("COD_ESTAB"),
            "date_fecha_inicio"         =>  $date_fecha_inicio,
            "date_fecha_final"          =>  $date_fecha_final,
        ));
        
        if(count($data_produccion["data_main"][":P_PROD_ANATOMIAPATOLOGICA"])>0){
            foreach ($data_produccion["data_main"][":P_PROD_ANATOMIAPATOLOGICA"] as $aux => $row){
                $aux_star               =   $aux+2;
                $n_biopsia              =   $aux+1;
                $v_nombre_arr           =   explode(" ",$row["PAC_SOLO_NOMBRE"]);
                $v_nombre_1             =   $v_nombre_arr[0];
                array_shift($v_nombre_arr);
                $v_nombre_2             =   count($v_nombre_arr)>0?implode(" ",$v_nombre_arr):'';
                $ExcelInstit
                    ->setCellValue('A'.$aux_star,$n_biopsia)
                    ->setCellValue('B'.$aux_star,$v_nombre_1)
                    ->setCellValue('C'.$aux_star,$v_nombre_2)
                    ->setCellValue('D'.$aux_star,$row["PAC_APELLIDO_PAT"])
                    ->setCellValue('E'.$aux_star,$row["PAC_APELLIDO_MAT"])
                    ->setCellValue('F'.$aux_star,$row["RUTPACIENTE"])
                    ->setCellValue('G'.$aux_star,$row["FICHAL"])
                    ->setCellValue('H'.$aux_star,'')
                    ->setCellValue('I'.$aux_star,$row["NUM_NOTIFICACION"])
                    ->setCellValue('J'.$aux_star,$row["PROFESIONAL_ACARGO"])
                    ->setCellValue('K'.$aux_star,'')
                    ->setCellValue('L'.$aux_star,'')
                    ->setCellValue('M'.$aux_star,$row["DATE_ARCHIVADA_EN_FICHA"])   
                    ->setCellValue('N'.$aux_star,$row["DATE_REVISION_INFORME"])
                    ->setCellValue('O'.$aux_star,$row["DATE_REVISION_BD"])
                    ->setCellValue('P'.$aux_star,'')
                    ->setCellValue('Q'.$aux_star,'')
                    ->setCellValue('R'.$aux_star,$row["DATE_CHEQUEO_SOME"])
                    ->setCellValue('S'.$aux_star,$row["FECHA_TOMA_MUESTRA"])
                    #->setCellValue('T'.$aux_star,$txt_meses[$row["MES_SOLICITUD"]])
                        
                    ->setCellValue('T'.$aux_star,$row["MES_SOLICITUD"])
                        
                    ->setCellValue('U'.$aux_star,$row["FECHA_RECEPCION"])  
                    ->setCellValue('V'.$aux_star,$row["HORA_RECEPCION"])
                    ->setCellValue('W'.$aux_star,$row["NOM_PROFE"])
                    ->setCellValue('X'.$aux_star,$row["TXT_EMPRESA"])
                    ->setCellValue('Y'.$aux_star,$row["NOMBRE_SERVICIO"]) 
                    ->setCellValue('Z'.$aux_star,substr($row["ARR_TEXTO_ANATOMIA"],0,-2))
                    ->setCellValue('AA'.$aux_star,$row["TOTAL_MUESTRAS"])
                    ->setCellValue('AB'.$aux_star,$row["N_BENEFICIARIOS"])
                    ->setCellValue('AC'.$aux_star,$row["DES_UBICACION"])
                    ->setCellValue('AD'.$aux_star,$row["TXT_PIEZA_QUIRUGICA"])
                    ->setCellValue('AE'.$aux_star,$row["TXT_DIAGNOSTICO"])
                    ->setCellValue('AF'.$aux_star,$row["TXT_NOTIF_CANCER"])
                    ->setCellValue('AG'.$aux_star,$row["TXT_TRASPORTE"])
                    ->setCellValue('AH'.$aux_star,$row["TXT_RECIBE"])
                    ->setCellValue('AI'.$aux_star,$row["EDAD"])
                    ->setCellValue('AJ'.$aux_star,$row["TXT_PREVISION"])
                    ->setCellValue('AK'.$aux_star,$row["ID_SOLICITUD"])
                    ->setCellValue('AL'.$aux_star,$row["TXT_MES_CRITICO"])
                    ->setCellValue('AM'.$aux_star,$row["FECHA_TOMA_MUESTRA"]);
                ################################################################        
                #INFORME GENERAL 
                $ExcelInstit
                    ->setCellValue('AN'.$aux_star,$row["DATE_IMPRESION_INFORME"]        ==''?'--':$row["DATE_IMPRESION_INFORME"])         #FECHA DE IMPRESION INFORME 
                    ->setCellValue('AO'.$aux_star,$row["DATE_FECHA_ENTREGA_INFORME"]    ==''?'--':$row["DATE_FECHA_ENTREGA_INFORME"])     #FECHA ENTREGA INFORME
                    ->setCellValue('AP'.$aux_star,$row["DATE_HORA_ENTREGA_INFORME"]     ==''?'--':$row["DATE_HORA_ENTREGA_INFORME"])      #HORA ENTREGA INFORME
                    ->setCellValue('AQ'.$aux_star,$row["TXT_PROFESIONAL_RECIBE"])
                    ->setCellValue('AR'.$aux_star,$row["TXT_PROFESIONAL_ENTREGA"]);
                $ExcelInstit
                    ->setCellValue('AS'.$aux_star,$row["N_DIAS_ENTREGA_INFORME"])
                    ->setCellValue('AT'.$aux_star,$row["TXT_CUMPLIIENTO_ENTREGA"]);
                
                if ($row["TXT_CUMPLIIENTO_ENTREGA"]!=''){
                $ExcelInstit
                    ->getStyle('AT'.$aux_star)->applyFromArray(array(
                        'font'          =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                        'fill'          =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>$row["TXT_CUMPLIIENTO_ENTREGA"]=='CUMPLE'?'00b347':'FB404B')),//cell
                        //'borders'     =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                    ));
                }
                $ExcelInstit       
                    ->setCellValue('AU'.$aux_star,$row["NUM_PLAZO_BIOPSIA"]);
                $ExcelInstit
                    ->setCellValue('AV'.$aux_star,$row["N_DIAS_EMISION_ENTREGA"])
                    ->setCellValue('AW'.$aux_star,$row["TXT_CUMPLE_ENTREGA_HABIL"]);
                if ($row["TXT_CUMPLE_ENTREGA_HABIL"]!=''){
                $ExcelInstit
                    ->getStyle('AW'.$aux_star)->applyFromArray(array(
                        'font'          =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'FFFFFF'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                        'fill'          =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>$row["TXT_CUMPLE_ENTREGA_HABIL"]=='CUMPLE'?'00b347':'FB404B')),//cell
                        //'borders'     =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                    ));
                }
                
        #***********************************************************************
        #DATA GESTION DEL CANTER            
        if($row["IND_NOTIF_CANCER"] == 1){
            #YES CANCER
            $diff                       =   strtotime($row["DATE_FINAL_CANCER"])-strtotime($row["DATE_INICIO_CANCER"]);
            $cumple_vacio               =   $row["NUM_DIAS_ENTCANCER"]==''||$row["DAY_CUMP_CLI_CANCER"]==''?false:true;
            $diff_pb_criticas           =   $cumple_vacio?$row["NUM_DIAS_ENTCANCER"]>=$row["DAY_CUMP_CLI_CANCER"]?'CUMPLE':'NO CUMPLE':'';
            $ExcelInstit->setCellValue('AX'.$aux_star,$row["DAY_CUMP_CLI_CANCER"])
                        ->setCellValue('AY'.$aux_star,$diff_pb_criticas)
                        ->setCellValue('AZ'.$aux_star,$row["NUM_DIAS_ENTCANCER"]);
            
            $ExcelInstit->setCellValue('BA'.$aux_star,$row["DATE_INICIO_CANCER"])
                        ->setCellValue('BB'.$aux_star,$row["DATE_FINAL_CANCER"])
                        ->setCellValue('BC'.$aux_star,$this->conversorSegundosHoras($diff)) 
                        ->setCellValue('BD'.$aux_star,$row["NUM_ASIGNACION96HRS"]>=$diff?'CUMPLE':'NO CUMPLE')
                        ->setCellValue('BE'.$aux_star,$this->conversorSegundosHoras($row["NUM_ASIGNACION96HRS"]));
            
        } else {
            #NO CANCER
            $ExcelInstit->setCellValue('AX'.$aux_star,'NO DISPONIBLE')->getStyle('AX'.$aux_star)->getFont()->setBold(true);
            $ExcelInstit->mergeCells('AX'.$aux_star.':BE'.$aux_star)->getStyle('AX'.$aux_star.':BE'.$aux_star)->getFont()->setBold(true);
            $ExcelInstit->getStyle('AX'.$aux_star.':BE'.$aux_star)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $ExcelInstit->getStyle('AX'.$aux_star.':BE'.$aux_star)->applyFromArray(array(
                                        'font'          =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'9b9b9b'),'size'=>9,'name'=>'Calibri','bold'=>true),// text
                                        'fill'          =>  array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb'=>'dddddd')),//cell
                                        //'borders'     =>  array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'),))//border   
                                    ));
        }
        #***********************************************************************
        
        $ExcelInstit->setCellValue('BF'.$aux_star,$row["TXT_ESTADIO_OLGA"]);
        $ExcelInstit->setCellValue('BG'.$aux_star,str_replace("\n"," ",trim($row["TXT_DIADNOSTICO_AP"])))
                    ->setCellValue('BH'.$aux_star,$row["DATE_FECHA_MACRO"])  
                    ->setCellValue('BI'.$aux_star,$row["DATE_FECHA_CORTE"])  
                    #->setCellValue('BJ'.$aux_star,$txt_meses_2[])
                    ->setCellValue('BJ'.$aux_star,$row["MES_SOLICITUD"])
                    ->setCellValue('BK'.$aux_star,$n_biopsia)   
                    ->setCellValue('BL'.$aux_star,$row["TXT_EMPRESA"])
                    ->setCellValue('BM'.$aux_star,$row["NOMBRE_SERVICIO"])
                    ->setCellValue('BN'.$aux_star,$row["TXT_COLOR_TACO"])
                    ->setCellValue('BO'.$aux_star,$row["DATE_INTERCONSULTA"])
                    ->setCellValue('BP'.$aux_star,$row["NUM_CP_INTERCONSULTA"])
                    ->setCellValue('BQ'.$aux_star,$row["N_BENEFICIARIOS"])
                    ->setCellValue('BR'.$aux_star,$row["NUM_FRAGMENTOS"])
                    ->setCellValue('BS'.$aux_star,substr($row["ARR_TEXTO_ANATOMIA"],0,-2))
                    ->setCellValue('BT'.$aux_star,$row["N_MUESTRAS_TOTAL"])
                    ->setCellValue('BU'.$aux_star,$row["TXT_USOCASSETTE"])
                    ->setCellValue('BV'.$aux_star,$row["NUM_TACOS_CORTADOS"])
                    ->setCellValue('BW'.$aux_star,$row["NUM_EXTENDIDOS"])
                    ->setCellValue('BX'.$aux_star,$row["NUM_FRAGMENTOS"]) 
                    ->setCellValue('BY'.$aux_star,$row["NUM_PAS_SERIADA"])   
                    ->setCellValue('BZ'.$aux_star,$row["NUM_DIFF_SERIADA"])    
                    ->setCellValue('CA'.$aux_star,$row["NUM_HE_SERIADA"])       
                    ->setCellValue('CB'.$aux_star,$row["NUM_LAMINAS_SERIADAS"])   
                    ->setCellValue('CC'.$aux_star,$row["NUM_HE_RAPIDA"]);  
                
                $ExcelInstit->getStyle('A'.$aux_star.':Y'.$aux_star)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //TIPO DE MUESTRA
                $ExcelInstit->getStyle('AA'.$aux_star.':BF'.$aux_star)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //DIAGNOSTICO
                $ExcelInstit->getStyle('BI'.$aux_star.':BR'.$aux_star)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //ORGANO O TEJIDO
                $ExcelInstit->getStyle('BT'.$aux_star.':CC'.$aux_star)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        } else {
            $ExcelInstit->setCellValue('A2','SIN INFORMACIÓN - '.$date_fecha_inicio." ".$date_fecha_final.' ');
            $ExcelInstit->getStyle('A2')->getFont()->setSize(16)->setBold(true);
            $ExcelInstit->mergeCells('A2:CC2');
        }  
        
        header('Content-Type:application/vnd.ms-excel');         
        header('Content-Disposition:attachment;filename="PRODUCCIÓN '.$date_fecha_inicio.'-'.$date_fecha_final.'.xls"');
        header('Cache-Control:max-age=0');   
        $objWriter      =   PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
    }
   
    function conversorSegundosHoras($tiempo_en_segundos) {
        $horas = floor($tiempo_en_segundos/3600);
        $minutos = floor(($tiempo_en_segundos-($horas*3600))/60);
        $segundos = $tiempo_en_segundos-($horas*3600)-($minutos*60);
        return substr(str_repeat(0,2).$horas,-2).":".substr(str_repeat(0,2).$minutos,-2).":".substr(str_repeat(0,2).$segundos,-2); 
    }
    
    public function get_star_sala_proceso(){
        if(!$this->input->is_ajax_request()){ show_404(); }  
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_anatomia = $this->input->post('id_anatomia');
        $get_sala = $this->input->post('get_sala');
        $opcion = $this->input->post('opcion');
        $DATA_CURSOR = $this->Ssan_libro_etapaanalitica_model->load_informacion_rce_patologico_new(array(
            "cod_empresa" => $empresa,
            "usr_session" => explode("-",$this->session->userdata("USERNAME"))[0],
            "ind_opcion" => 0,
            "ind_first" => 0,
            "id_anatomia" => $this->input->post('id_anatomia'),
            "num_fase" =>  4,
            "ind_template" => "ssan_libro_etapaanalitica",
            "get_sala" => $get_sala,
        ));
        $html = $this->load->view("ssan_libro_etapaanalitica/template_default_analitica",$DATA_CURSOR,true);
        $this->output->set_output(json_encode([
            'html' =>  $html,
            'info_bd' => $id_anatomia,
            'get_sala' => $get_sala,
            'out_cursores' => $DATA_CURSOR,
            'id_zona' => $DATA_CURSOR["data_bd"][":P_ANATOMIA_PATOLOGICA_MAIN"][0]["VAL_HISTO_ZONA"],
            'ind_proceso' => $DATA_CURSOR["data_bd"][":P_ANATOMIA_PATOLOGICA_MAIN"][0]["IND_TIPO_PROCESO"],
        ]));
    }

    public function get_guardar_info_sala_proceso(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $empresa = $this->session->userdata("COD_ESTAB");
        $contrasena = $this->input->post('contrasena');
        $id_anatomia = $this->input->post('id_anatomia');
        $accesdata = $this->input->post('accesdata');
        $opcion = $this->input->post('opcion');
        $arr_user = $this->Ssan_libro_etapaanalitica_model->sqlvalidaclave($contrasena);
        if (count($arr_user)>0){
            $return = $this->Ssan_libro_etapaanalitica_model->get_star_sala_proceso([
                'empresa' => $empresa,
                'opcion' => $opcion,
                'accesdata' => $accesdata,
                'id_anatomia' => $id_anatomia,
                'user_firma' => $arr_user,
                'session' => explode("-",$this->session->userdata("USERNAME"))[0],
            ]);
        } else {
            $status = false;
        }
        #validar que este en ese estado
        #$return_data = $this->Ssan_libro_etapaanalitica_model->load_sala_proceso(array("empresa"=>$empresa,"opcion"=>$opcion));
        $this->output->set_output(json_encode(array(
            'return_bd' => isset($return)?$return:null,
            'contrasena' =>  $contrasena,
            'arr_user' =>  $arr_user,
            'id_anatomia' =>  $id_anatomia,
            'status' =>  $status,
        )));
    }
    
    public function get_guardar_final_sala_proceso(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $contrasena = $this->input->post('contrasena');
        $id_anatomia = $this->input->post('id_anatomia');
        $accesdata = $this->input->post('accesdata');
        $opcion = $this->input->post('opcion');
        $return = '';
        $status_fecha = true;
        $v_txt_error = '';
        $status = true;
        $arr_user = $this->Ssan_libro_etapaanalitica_model->sqlvalidaclave($contrasena);
        if (count($arr_user)>0){
            $return =    $this->Ssan_libro_etapaanalitica_model->get_final_sala_proceso(array( 
                            'empresa' =>  $empresa,
                            'opcion' =>  $opcion,
                            'accesdata' =>  $accesdata,
                            'id_anatomia' =>  $id_anatomia,
                            'user_firma' =>  $arr_user,
                            'session' =>  explode("-",$this->session->userdata("USERNAME"))[0],
                        ));
            
        } else {
            $status = false;
        }
        $this->output->set_output(json_encode(array(
            'return_bd' =>  isset($return)?$return:null,
            'contrasena' =>  $contrasena,
            'arr_user' =>  $arr_user,
            'id_anatomia' =>  $id_anatomia,
            'status' =>  $status,
            'status_fecha' =>  $status_fecha,
            'v_txt_error' =>  $v_txt_error,
        )));
    }
   
    public function consulta(){
        $date_fecha_inicio              =   $this->input->post('fecha_1');
        $date_fecha_final               =   $this->input->post('fecha_2');
        $data_produccion                =   $this->Ssan_libro_etapaanalitica_model->load_info_excel_produccion(
            array(
                "cod_empresa"           =>  $this->session->userdata("COD_ESTAB"),
                "date_fecha_inicio"     =>  $date_fecha_inicio,
                "date_fecha_final"      =>  $date_fecha_final,
            ));
            //$v_nombre_arr             =   explode(" ",$data_produccion["data_main"][":P_PROD_ANATOMIAPATOLOGICA"][0]["PAC_SOLO_NOMBRE"]);
            //$v_nombre_1               =   $v_nombre_arr[0];
            //$v_nombre_2               =   $v_nombre_arr[1];
        $txt_meses                      =   array(1=>'ene',2=>'feb',3=>'mar',4=>'abr',5=>'may',6=>'jun',7=>'jul',8=>'ago',9=>'sep',10=>'oct',11=>'nov',12=>'dic');
        $this->output->set_output(json_encode(array(
            'info_bd'                   =>  $data_produccion,
            'meses'                     =>  $txt_meses[1],
            //'v_nombre_2'              =>  $v_nombre_2
        )));
    }
    
    public function consulta2(){
        //$empresa = $this->session->userdata("COD_ESTAB");
        $data_produccion = $this->Ssan_libro_etapaanalitica_model->load_familia_evolucion(
            array(
                "cod_empresa" => $this->session->userdata("COD_ESTAB"),
                "rut" => '12527143',
            ));
        $html = $this->load->view("ssan_ag_evol_pacientes/template_evol_paciente",array('data_produccion'=>$data_produccion),true);
        $this->output->set_output(json_encode(array(
            'bd' => $data_produccion,
            'html' => $html,
            //'ind_sexo' =>  $data_produccion["data_main"][":P_GETDATOPCIENTE"]>0?$data_produccion["data_main"][":P_GETDATOPCIENTE"][0]["IND_TISEXO"]:'DATOS DEL PACIENTE NO ENCONTRADO',
            //'data_familia' =>  $data_produccion["data_main"][":P_GETFAMILIA"]>0?$data_produccion["data_main"][":P_GETFAMILIA"]:'NO ENCONTRADO',
        )));
    }
     
    public function gestion_cancer_panel(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_anatomia = $this->input->post('id_anatomia');
        $opcion = $this->input->post('opcion');
        $DATA_CURSOR = $this->Ssan_libro_etapaanalitica_model->load_gestion_cancer(array( 
                        'empresa' =>  $empresa,
                        'opcion' =>  $opcion,
                        'id_anatomia' =>  $id_anatomia,
                        'session' =>  explode("-",$this->session->userdata("USERNAME"))[0],
                    ));
        $this->output->set_output(json_encode(array(
            'bd' => $DATA_CURSOR,
            'status' => true,
            'opcion' => $opcion,
        )));
    }
    
    #sala tecnologo
    public function gestion_sala_tecnicas(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        #$opcion = 1;
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_anatomia = $this->input->post('id_anatomia');
        $status = true;
        $get_sala = $this->input->post('get_sala');
        $DATA_CURSOR = $this->Ssan_libro_etapaanalitica_model->load_informacion_rce_patologico_new(array(
            "cod_empresa" => $empresa,
            "usr_session" => explode("-",$this->session->userdata("USERNAME"))[0],
            "ind_opcion" => 0,
            "ind_first" => 0,
            "id_anatomia" => $this->input->post('id_anatomia'),
            "num_fase" => 4,
            "ind_template" => "ssan_libro_etapaanalitica",
            "get_sala" => $get_sala,
        ));
        $html = $this->load->view("ssan_libro_etapaanalitica/template_default_analitica",$DATA_CURSOR,true);
        $this->output->set_output(json_encode(array(
            'out_html' => $html,
            'status' => $status,
            'id_anatomia' => $id_anatomia,
            'bd' => $DATA_CURSOR,
        )));
    }
    
    public function get_record_tec_tecnologo(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $data_produccion = [];
        $status = true;
        $status_firma = true;
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_anatomia = $this->input->post('id_anatomia');
        $lis_checked = $this->input->post('lis_checked'); 
        $val_cierre = $this->input->post('val_cierre'); 
        $accesdata = $this->input->post('accesdata');
        $contrasena = $this->input->post('contrasena');
        $op = $this->input->post('op'); 
        $arr_user = $this->Ssan_libro_etapaanalitica_model->sqlvalidaclave($contrasena);
        if(count($arr_user)>0) {
            $data_produccion = $this->Ssan_libro_etapaanalitica_model->get_record_tec_tecnologo(array(
                "cod_empresa" => $this->session->userdata("COD_ESTAB"),
                "session" =>  explode("-",$this->session->userdata("USERNAME"))[0],
                "id_anatomia" => $id_anatomia,
                "lis_checked" => $lis_checked,
                "val_cierre" => $val_cierre,
                "accesdata" => $accesdata,
                "empresa" => $empresa,
                "op" =>  $op,
            ));
        } else {
            $status_firma = false;
        }
        $this->output->set_output(json_encode(array(
            'status' => $status,
            'return_bd' => $data_produccion,
            'id_anatomia' => $id_anatomia,
            'status_firma' => $status_firma,
        )));
    }
    
    public function get_guardadoprevio_tec_tecnologo(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        //$data_produccion = [];
        $status = true;
        $status_firma = true;
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_anatomia = $this->input->post('id_anatomia');
        $lis_checked = $this->input->post('lis_checked'); 
        $val_cierre = $this->input->post('val_cierre'); 
        $accesdata = $this->input->post('accesdata');
        $op = $this->input->post('op'); 
        $data_produccion = $this->Ssan_libro_etapaanalitica_model->get_record_tec_tecnologo(array(
            "cod_empresa" => $this->session->userdata("COD_ESTAB"),
            "session" =>  explode("-",$this->session->userdata("USERNAME"))[0],
            "id_anatomia" => $id_anatomia,
            "lis_checked" => $lis_checked,
            "val_cierre" => $val_cierre,
            "accesdata" => $accesdata,
            "empresa" => $empresa,
            "op" => $op,
        ));
        $this->output->set_output(json_encode(array(
            'status' => $status,
            'return_bd' => $data_produccion,
            'id_anatomia' => $id_anatomia,
            'status_firma' => $status_firma,
        )));
    }
    
    public function load_line_pdf_vista(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                         =   true;
        $id_anatomia                    =   $this->input->post('id_anatomia');
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'id_anatomia'               =>  $id_anatomia,
        )));
    }
    
    public function viws_historial_clinico() {
        if(!$this->input->is_ajax_request()) {  show_404();  }
        $html                           =   'HOLA';
        $transaccion                    =   '';
        $numFichaE                      =   $this->input->post('numfichae');
        $return                         =   $this->Ssan_libro_etapaanalitica_model->new_get_busquedatoken(17,$numFichaE);
        #https://10.5.183.210/ssan_his_historialclinico_new?m=135&token=6009b73b97b1967523bdcd6eb7860cda5bafdaa3&acc=1
        #https://www.esissan.cl/ssan_his_historialclinico_new?m=135&token=ea94a681f1224094b8dd9b0eddfcb139fda848d8&acc=1
        #$i_frame                       =   'https://10.5.183.210/ssan_his_historialclinico_new?m=135&'.$return['TOKEN_SESSION'].'&acc=1';
        $i_frame                        =   'https://www.esissan.cl/ssan_his_historialclinico_new?m=135&'.$return['TOKEN_SESSION'].'&acc=1';
        $TABLA["IFRAME"]                =   $i_frame;
        $TABLA["TOKEN"]                 =   $return;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function get_update_txt_macroscopica(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                         =   true;
        $num_muestra                    =   $this->input->post('num_muestra');
        $txt_update                     =   $this->input->post('txt_update'); 
        $data_produccion                =   $this->Ssan_libro_etapaanalitica_model->get_update_txt_macroscopica(array(
            "cod_empresa"               =>  $this->session->userdata("COD_ESTAB"),
            "session"                   =>  explode("-",$this->session->userdata("USERNAME"))[0],
            "num_muestra"               =>  $num_muestra,
            "txt_update"                =>  $txt_update,
        ));
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            '$data_produccion'          =>  $data_produccion,
        )));
    }

    
    #BLOB PDF DE ANATOMIA PATOLOGICA EXTERNO
    public function BLOB_PDF_ANATOMIA_PATOLOGICA(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        $HTML_BIOPSIAS                  =   '';
        $HTML_CITOLOGIA                 =   '';
        $DATA                           =   $this->Ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array(
                                                "ID_HISTO"      =>  $id_tabla,
                                                "COD_EMPRESA"   =>  $empresa,
                                            ));
        $DATA_FIRST                     =   false;
        
        /*
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf                   =   'SOLICITUD DE ANATOMIA.pdf';
        $dompdf                         =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        #firma digital
        $rutUsuario                     =   explode("-",$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['RUT_PROFESIOAL']);
        $codeContents                   =   'https://www.esissan.cl/validador?p=' . $this->validaciones->encodeNumber($rutUsuario[0] . '&' . $empresa);
        #firma digital
        $rutUsuario                     =   explode("-",$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['RUT_PROFESIOAL']);
        $rutProfesional                 =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['RUT_PROFESIOAL'];
        $profesional                    =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['PROFESIONAL'];
        $profesion                      =   '-';
        $html_firma                     =   '<table>
                                                <tr>
                                                    <td valign="top">
                                                        <barcode class="barcode" code="'.$codeContents.'" type="QR" height="0" text="1" size="1"/>
                                                    </td>
                                                    <td valign="top">
                                                        <br>
                                                        <b>FIRMADO DIGITALMENTE</b>
                                                        <p style="margin-top:20px;display: inline-block;">' . strtoupper($rutProfesional) . '</p>
                                                        <p style="margin-bottom:0px;display: inline-block;">' . strtoupper($profesional) . '</p>
                                                        <p style="margin-bottom:0px;display: inline-block;">' . strtoupper($profesion) . '</p>
                                                    </td>
                                                </tr>
                                            </table>';

        if(count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"][0])>0){
            $DATA_FIRST                 =   true;
            $HTML_BIOPSIAS              =   $this->load->view("ssan_spab_coordepabellonenfe_new/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS",array('DATA'=>$DATA,'FIRMA'=>$html_firma),true);
            $dompdf->WriteHTML($HTML_BIOPSIAS);
            $dompdf->SetHTMLFooter('SOLICITUD DE ANATOMIA PATOLOGICA - M.ANATOMICA');
        }

        if(count($DATA["P_AP_MUESTRAS_CITOLOGIA"][0])>0){
            $dompdf->AddPage();
            $HTML_CITOLOGIA             =   $this->load->view("ssan_spab_coordepabellonenfe_new/PDF_PROTOCOLOS/PDF_TEMPLATE_ANATOMIAPATO_EQUITERAS_CITO",array('DATA'=>$DATA,'FIRMA'=>$html_firma),true);
            $dompdf->WriteHTML($HTML_CITOLOGIA);
            $dompdf->SetHTMLFooter('SOLICITUD DE ANATOMIA PATOLOGICA - M.CITOLOGIA');
        }


        */

        $base64_pdf                     =   base64_encode($dompdf->Output('SOLICITUD DE ANATOMIA.pdf','S'));
        #$TABLA["codeContents"]          =   $html_firma;
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $TABLA["HTML_BIOPSIAS"]         =   $HTML_BIOPSIAS;
        $this->output->set_output(json_encode($TABLA));
    }




}
?>