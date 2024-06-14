<?php

class Ssan_libro_notificacancer extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pdf');
        $this->load->model("Ssan_libro_notificacancer_model");
        $this->load->model("Ssan_libro_biopsias_usuarioext_model");
        $this->load->model("Ssan_libro_etapaanalitica_model");
    }

    public function index(){
        $this->output->set_template('blank');
        $data = [];
        #$this->load->js("assets/ssan_libro_notificacancer/js/liberia_qr/qrcode.js");
        $this->load->css("assets/Ssan_libro_notificacancer/css/styles.css");
        $this->load->js("assets/ssan_libro_notificacancer/js/javascript.js");
        $this->load->view('ssan_libro_notificacancer/ssan_libro_notificacancer_view',$data);
    }

    public function get_busqueda_solicitudes_ap_cancer(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $busq                           =   $this->input->post('tipo_busqueda');
        $txt_busqueda                   =   $this->input->post('phrase');
        $ind_template                   =   $this->input->post('template');
        $arr_data_out                   =   [];
        $return_data                    =   $this->Ssan_libro_notificacancer_model->busqueda_solicitudes_ap(array(
                                                'arr_ids_anatomia'  =>  '',
                                                'txt_bus'           =>  $txt_busqueda,
                                                'busq'              =>  $busq,
                                                'cod_empresa'       =>  $this->session->userdata("COD_ESTAB"),
                                                'ind_template'      =>  $ind_template,
                                            ));
        if(count($return_data['C_LISTA_ANATOMIA_BUS'])>0){
            $aux                            =   0;
            foreach ($return_data['C_LISTA_ANATOMIA_BUS'] as $i => $row){
                $arr_n_biosia               =  [];
                $row['NUM_INTERNO_AP']      == '' ? '' : array_push($arr_n_biosia,'N&deg;&nbsp;'.$row['NUM_INTERNO_AP']."-".$row['YEAR_TOMA_MUESTRA']);
                $row['NUM_CO_CITOLOGIA']    == '' ? '' : array_push($arr_n_biosia,'N&deg;&nbsp;'.$row['NUM_CO_CITOLOGIA']."-".$row['YEAR_TOMA_MUESTRA']);
                $row['NUM_CO_PAP']          == '' ? '' : array_push($arr_n_biosia,'N&deg;&nbsp;'.$row['NUM_CO_PAP']."-".$row['YEAR_TOMA_MUESTRA']);
                $aux++;
                //$row["TXT_ESTADO_CANCER"]
                $txt_nbiopsias              =   implode(",",$arr_n_biosia);
                $txt_estado_cancer          =   $row['TXT_ESTADO_CANCER'];
                //$txt_color                =   $txt_estado_cancer == 'SIN DIAGNOSTICO DE CANCER' ? '#FF0000' : $txt_estado_cancer == 'NOTIFICADO' ? '#87CB16' : '#f0ad4e' ;
                array_push($arr_data_out,array(
                    'html'              =>  '',
                    'id_anatomia'       =>  $row['ID_ANATOMIA'],
                    'name'              =>  $row['TXTPRIMERNOMBREAPELLIDO'],
                    'type'              =>  '<br>'.$row['TIPO_DE_BIOPSIA'].'<br>'.$txt_nbiopsias .'<br><font size=2 color="'.$row['COLOR_ESTADO_CANCER'].'"><b>'.$txt_estado_cancer.'</b></font>',
                    'tipo_biosia'       =>  $txt_nbiopsias,
                    'icon'              =>  '<i class="fas fa-edit"></i>',
                    '_busqueda'         =>  $busq,
                    'n_muestras'        =>  $row['N_MUESTRAS_TOTAL'],
                    'not_cancer'        =>  $row['NUM_NOF_CANCER'],
                    'cod_establref'     =>  $row['COD_ESTABLREF'],
                    'ind_notificado'    =>  $row['TXT_ESTADO_CANCER'],
                ));
            }
        }
        $this->output->set_output(json_encode($arr_data_out));
    }
   
    public function get_busqueda_solicitudes_ap_edicion(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $busq                           =   $this->input->post('tipo_busqueda');
        $txt_busqueda                   =   $this->input->post('phrase');
        $ind_template                   =   $this->input->post('template');
        $arr_data_out                   =   [];
        $return_data                    =   $this->Ssan_libro_notificacancer_model->busqueda_solicitudes_ap(array(
                                                'arr_ids_anatomia'  =>  '',
                                                'txt_bus'           =>  $txt_busqueda,
                                                'busq'              =>  $busq,
                                                'cod_empresa'       =>  $this->session->userdata("COD_ESTAB"),
                                                'ind_template'      =>  $ind_template,
                                            ));

        //var_dump($return_data["C_HISTORIAL_M_BUSQUEDA"]);
        if(count($return_data['C_LISTA_ANATOMIA_BUS'])>0){
            $aux                            =   0;
            foreach ($return_data['C_LISTA_ANATOMIA_BUS'] as $i => $row){
                $arr_n_biosia               =  [];
                $row['NUM_INTERNO_AP']      == '' ? '' : array_push($arr_n_biosia,'N&deg;&nbsp;'.$row['NUM_INTERNO_AP']."-".$row['YEAR_TOMA_MUESTRA']);
                $row['NUM_CO_CITOLOGIA']    == '' ? '' : array_push($arr_n_biosia,'N&deg;&nbsp;'.$row['NUM_CO_CITOLOGIA']."-".$row['YEAR_TOMA_MUESTRA']);
                $row['NUM_CO_PAP']          == '' ? '' : array_push($arr_n_biosia,'N&deg;&nbsp;'.$row['NUM_CO_PAP']."-".$row['YEAR_TOMA_MUESTRA']);
                $aux++;
                $txt_nbiopsias              =   implode(",",$arr_n_biosia);
                $txt_solicitud_editada      =   $row['IND_SOLICITUD_EDITADA'] == '1' ? '<font size=2 color="#007bff"><b>EDITADA</b></font>' : '<font size=2 color="#ffc107"><b>NO EDITADA</b></font>';
                array_push($arr_data_out,array(
                    'html'              =>  '',
                    'id_anatomia'       =>  $row['ID_ANATOMIA'],
                    'name'              =>  $row['TXTPRIMERNOMBREAPELLIDO'],
                    'type'              =>  '<br>'.$row['TIPO_DE_BIOPSIA'].'<br>'.$txt_nbiopsias .'<br>'.$txt_solicitud_editada,
                    'tipo_biosia'       =>  $txt_nbiopsias,
                    'icon'              =>  '<i class="fas fa-edit"></i>',
                    '_busqueda'         =>  $busq,
                    'n_muestras'        =>  $row['N_MUESTRAS_TOTAL'],
                    'not_cancer'        =>  $row['NUM_NOF_CANCER'],
                    'cod_establref'     =>  $row['COD_ESTABLREF'],
                    'ind_notificado'    =>  $row['TXT_ESTADO_CANCER'],
                ));
            }
        }
        $this->output->set_output(json_encode($arr_data_out));
    }
    
    public function load_lista_anatomiapatologica(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $v_ids_anatomia                     =   $this->input->post('v_ids_anatomia');
        $v_tipo_de_busqueda                 =   $this->input->post('v_tipo_de_busqueda');
        $v_get_sala                         =   $this->input->post('v_get_sala');
        $v_filtro_consulta                  =   $this->input->post('v_filtro_consulta');
        $return_data                        =   $this->Ssan_libro_notificacancer_model->load_lista_anatomiapatologica_model(array(
            'cod_empresa'                   =>  $this->session->userdata("COD_ESTAB"),
            'usr_session'                   =>  explode("-",$this->session->userdata("USERNAME"))[0],
            'v_ids_anatomia'                =>  $v_ids_anatomia,
            'v_tipo_de_busqueda'            =>  $v_tipo_de_busqueda,
            'v_get_sala'                    =>  $v_get_sala,
            'v_filtro_consulta'             =>  $v_filtro_consulta,
        ));
        #OUT VIEWS
        $this->output->set_output(json_encode(array(
            #'arr_ids_anatomia'             =>  $arr_ids_anatomia,
            'userdata'                      =>  $this->session->userdata,
            'return_data'                   =>  $return_data,
            'v_ids_anatomia'                =>  $v_ids_anatomia,
            'v_tipo_de_busqueda'            =>  $v_tipo_de_busqueda,
            'v_get_sala'                    =>  $v_get_sala,
            'v_filtro_consulta'             =>  $v_filtro_consulta,
        )));
    }
 
    public function html_notificar_a_ususario(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                             =   true;
        $return_data                        =   $this->Ssan_libro_notificacancer_model->load_gestion_notificacion_cancer(array(
            'cod_empresa'                   =>  $this->session->userdata("COD_ESTAB")
        ));
        $this->output->set_output(json_encode(array(
            #'arr_ids_anatomia'             =>  $arr_ids_anatomia,
            'return_data'                   =>  $return_data,
            'status'                        =>  $status
        )));
    }
    
    #CONFIRMA NOTIFICACION 
    public function confirma_notificacion_cancer(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa                            =   $this->session->userdata('COD_ESTAB');
        $id_anatomia                        =   $this->input->post('id_anatomia');
        $usuarioh                           =   explode("-",$this->session->userdata("USERNAME"));
        #$num_memo_notificacion             =   true;
        $TXT_ERROR                          =   '';
        $DATA                               =   '';
        #$valida                            =   '';
        $STATUS                             =   true;
        $arr_errores                        =   array();
        $arr_password                       =   $this->input->post('pass');
        $valida                             =	$this->Ssan_libro_biopsias_usuarioext_model->sqlValidaClave_doble($arr_password);
        count($valida['user_1'])>0?'':array_push($arr_errores,"Error en la firma del funcionario que notifica");
        count($valida['user_2'])>0?'':array_push($arr_errores,"Error en la firma del funcionario que recibe notificaci&oacute;n");
        if(count($arr_errores)>0){
            $TXT_ERROR                      =   implode("<br>",$arr_errores);
            $STATUS                         =   false;
        } else {
            $DATA                           =   $this->Ssan_libro_notificacancer_model->get_valida_notificacion_conjunta([ 
                                                    "COD_EMPRESA"   => $empresa,
                                                    "SESSION"       => $usuarioh[0], 
                                                    "ID_ANATOMIA"   => $id_anatomia,
                                                    "DATA_FIRMA"    => $valida
                                                ]);
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
    
    public function informa_x_correo(){
        if(!$this->input->is_ajax_request()){  show_404(); }
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $id_tabla                       =   $this->input->post('id');
        $DATA                           =   $this->ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        //$DATA                         =   null;
        require_once APPPATH            .   '/third_party/mpdf/mpdf.php';
        $txt_name_pdf                   =   'RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA:'.$id_tabla.'.pdf';
        #verical 
        //$dompdf                       =   new mPDF('','',0,'',15,15,16,16,9,9,'L');
        #horizontal
        $dompdf                         =   new mPDF("en-GB-x","Letter-L","","",10,10,10,10,6,3);
        $dompdf->AddPage();
        $dompdf->WriteHTML($this->load->view("ssan_libro_biopsias_listagespab/pdf_recepcion_conforme",array('DATA'=>$DATA,"empresa"=>$empresa),true));
        $dompdf->SetHTMLFooter('RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA');
        $out                            =   $dompdf->Output($txt_name_pdf,'S');
        $base64_pdf                     =   base64_encode($out);
        $userEmail                      =   'benjamin.castillo@araucanianorte.cl,benjamin.castillo03@gmail.com'; 
        #$userEmail                     =   'benjamin.castillo03@gmail.com'; 
        $subject                        =   'NUEVA RECEPCION';
        $config                         =   array(
                                                'protocol'          =>  'sendmail',
                                                'smtp_host'         =>  'your domain SMTP host',
                                                'smtp_port'         =>   25,
                                                'smtp_user'         =>  'SMTP Username',
                                                'smtp_pass'         =>  'SMTP Password',
                                                'smtp_timeout'      =>  '4',
                                                'mailtype'          =>  'html',
                                                'charset'           =>  'iso-8859-1'
                                            );
        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        $this->email->from('noresponder@araucanianorte.cl','SISTEMA DE ANATOM&Iacute;A PATOL&Oacute;GICA - NUEVA RECEPCI&Oacute;N');//no borrar (correo remitente)
        $data                           =   array('NUM_ANATOMICO' => $id_tabla);
        $this->email->to($userEmail);
        $this->email->subject($subject); // replace it with relevant subject 
        $body                           =   $this->load->view('ssan_libro_biopsias_ii_fase/email_test.php',$data,TRUE);
        $this->email->message($body);
        #$this->email->attach($dompdf->Output($txt_name_pdf,'S'));
        $this->email->attach($out,'attachment','INFORME DE CANCER- '.$id_tabla.'.pdf','application/pdf');
        $this->email->send();
        //**********************************************************************
        $TABLA["IND_MAIL"]              =   $userEmail;
        $TABLA["IND_TEMPLATE"]          =   1;
        $TABLA["PDF_MODEL"]             =   $base64_pdf;
        $TABLA["PDF_MODEL_DATA"]        =   $base64_pdf;
        $TABLA["STATUS"]                =   true;
        $TABLA["DATA_RETURN"]           =   $DATA;
        $TABLA["ID_RETURN"]             =   $id_tabla;
        $this->output->set_output(json_encode($TABLA));
    }
    
    #PDF NOTIFICACION CANCER
    public function pdf_notificacion_cancer_ok(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_tabla = $this->input->post('id');
        $qr_to_base64 = $this->input->post('qr_to_base64');
        $DATA = $this->Ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_tabla));
        $txt_name_pdf = 'RECEPCI&Oacute;N DE ANATOM&Iacute;A PATOL&Oacute;GICA:'.$id_tabla.'.pdf';
        $dompdf = new mPDF("en-GB-x","Letter-L","","",10,10,10,10,6,3);
        $dompdf->AddPage();
        $dompdf->WriteHTML($this->load->view("ssan_libro_notificacancer/pdf_notificacion_cancer",array(
                    'DATA' => $DATA,
                    "empresa" =>  $empresa,
                    "qr_to_base64" =>  $qr_to_base64,
                ),true));
        $dompdf->SetHTMLFooter('NOTIFICACI&Oacute;N DE CANCER - ANATOM&Iacute;A PATOL&Oacute;GICA');
        $out = $dompdf->Output($txt_name_pdf,'S');
        $base64_pdf = base64_encode($out);
        $TABLA["IND_TEMPLATE"] = 1;
        $TABLA["PDF_MODEL"] = $base64_pdf;
        $TABLA["PDF_MODEL_DATA"] = $base64_pdf;
        $TABLA["STATUS"] = true;
        $TABLA["DATA_RETURN"] = $DATA;
        $TABLA["ID_RETURN"] = $id_tabla;
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function html_gestion_numero_biopsia(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $id_biopsia = $this->input->post('id_biopsia');
        $empresa = $this->session->userdata("COD_ESTAB");
        $DATA = $this->Ssan_libro_biopsias_usuarioext_model->LOAD_ANATOMIAPATOLOGICA_PDF(array("COD_EMPRESA"=>$empresa,"ID_HISTO"=>$id_biopsia));
        $this->output->set_output(json_encode(array(
            'html_out' =>  $this->load->view("ssan_libro_notificacancer/html_edicion_numero_biopsia",array('cursor'=>$DATA),true),
            'status' =>  $status
        )));
    }
    
    public function get_cambio_numero_biopsia(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $txt_error = '';
        $ind_tipo_biopsia = $this->input->post('ind_tipo_biopsia');
        $id_biopsia = $this->input->post('id_biopsia');
        $new_num_interno = $this->input->post('new_num_interno');
        $pass = $this->input->post('pass'); 
        $ind_cambio = $this->input->post('ind_cambio'); 
        $arr_user = $this->Ssan_libro_etapaanalitica_model->sqlvalidaclave($pass);
        if (count($arr_user)>0){
            $return_data = $this->Ssan_libro_notificacancer_model->update_numero_biopsias([
                'cod_empresa' =>  $this->session->userdata("COD_ESTAB"),
                'pass' =>  $pass,
                'ind_tipo_biopsia' => $ind_tipo_biopsia,
                'id_biopsia' =>  $id_biopsia,
                'new_num_interno' => $new_num_interno,
                'ind_cambio' => $ind_cambio,
            ]);
            }
            if (count($return_data['data_bd'][':C_STATUS'])>0){
                $status = false;
                $txt_error = $return_data['data_bd'][':C_STATUS'][0]['TXT_ERROR'];
            }
        } else {
            $status = false;
            $txt_error = 'Error en la firma simple';
        }
        $this->output->set_output(json_encode(array(
            'status' => $status,
            'return' => $return_data,
            'txt_error' => $txt_error,
            'nun_biopsia' => $new_num_interno,
            'ind_cambio' => $ind_cambio,
        )));
    }
    
    public function load_notificacion_cancer_por_year(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                         =   true;
        $ind_year                       =   $this->input->post('ind_year');
        $empresa                        =   $this->session->userdata("COD_ESTAB");
        $v_date_inicio                  =   '01-01-'.$ind_year;
        $v_date_final                   =   '31-12-'.$ind_year;
        $return_data                    =   $this->Ssan_libro_notificacancer_model->listado_notificado_cancer(array(
            'cod_empresa'               =>  $empresa,
            'ind_year'                  =>  $ind_year,
            'ind_opcion'                =>  1,
            'date_fecha_inicio'         =>  $v_date_inicio,
            'date_fecha_final'          =>  $v_date_final,
        ));
        $v_html                         =   $this->load->view("ssan_libro_notificacancer/html_tabla_listcancer_xyear",array(
                                                'cursor'    =>  $return_data,
                                                'ind_year'  =>  $ind_year
                                            ),true);
        $this->output->set_output(json_encode(array(
            'html'                      =>  $v_html,
            'status'                    =>  $status,
            'data_bd'                   =>  $return_data,
        )));
    }
    
    public function load_edicion_fechas(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                         =   true;
        $id_biopsia                     =   $this->input->post('id_biopsia');
        $ind_opcion                     =   $this->input->post('ind_opcion');
        $txt_fecha_diag                 =   $this->input->post('txt_fecha_diag');
        $txt_hora_diagnostico           =   $this->input->post('txt_hora_diagnostico');
        $arr_info                       =   $this->input->post('arr_info');
        $v_html                         =   $this->load->view("ssan_libro_notificacancer/html_edicion_fecha",array(
                                                'id_biopsia'            =>  $id_biopsia,
                                                'ind_opcion'            =>  $ind_opcion,
                                                'txt_fecha_diag'        =>  $txt_fecha_diag,
                                                'txt_hora_diagnostico'  =>  $txt_hora_diagnostico,
                                                'arr_info'              =>  $arr_info,
                                            ),true);
        $this->output->set_output(json_encode(array(
            'html'                      =>  $v_html,
            'status'                    =>  $status,
        )));
    }
    
    public function record_fecha_diagnostico(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                         =   true;
        $txt_error                      =   '';
        $return_data                    =   $this->Ssan_libro_notificacancer_model->model_update_fecha_diagnostico(array(
            'cod_empresa'               =>  $this->session->userdata("COD_ESTAB"),
            'constrasena'               =>  $this->input->post('constrasena'),
            'id_biopsia'                =>  $this->input->post('id_biopsia'),
            'new_fecha_diagnostico'     =>  $this->input->post('new_fecha_diagnostico'), 
            'new_hora_diagnostico'      =>  $this->input->post('new_hora_diagnostico'),  
        ));
        if(count($return_data['data_bd'][':C_STATUS'])>0){
            $status                     =   false;
            $txt_error                  =   $return_data['data_bd'][':C_STATUS'][0]['TXT_ERROR'];
        }
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return'                    =>  $return_data,
            'txt_error'                 =>  $txt_error,
        )));
    }
    
    public function record_fecha_notificacancer(){
        if(!$this->input->is_ajax_request()){   show_404();  }
        $status                         =   true;
        $txt_error                      =   '';
        $return_data                    =   $this->Ssan_libro_notificacancer_model->model_update_date_notificacancer(array(
            'cod_empresa'               =>  $this->session->userdata("COD_ESTAB"),
            'constrasena'               =>  $this->input->post('constrasena'),
            'id_biopsia'                =>  $this->input->post('id_biopsia'),
            'new_fecha_notifica_cancer' =>  $this->input->post('new_fecha_notifica_cancer'), 
            'new_hora_notifica_cancer'  =>  $this->input->post('new_hora_notifica_cancer'),  
        ));
        if(count($return_data['data_bd'][':C_STATUS'])>0){
            $status                     =   false;
            $txt_error                  =   $return_data['data_bd'][':C_STATUS'][0]['TXT_ERROR'];
        }
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return'                    =>  $return_data,
            'txt_error'                 =>  $txt_error,
        )));
    }

    public function record_elimina_definitivamente(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status                         =   true;
        $txt_error                      =   '';
        $return_data                    =   $this->Ssan_libro_notificacancer_model->model_record_elimina_definitivamente(array(
            'cod_empresa'               =>  $this->session->userdata("COD_ESTAB"),
            'constrasena'               =>  $this->input->post('constrasena'),
            'id_biopsia'                =>  $this->input->post('id_biopsia'),
            'new_fecha_diagnostico'     =>  $this->input->post('new_fecha_diagnostico'), 
            'new_hora_diagnostico'      =>  $this->input->post('new_hora_diagnostico'),  
        ));
        if(count($return_data['data_bd'][':C_STATUS'])>0){
            $status                     =   false;
            $txt_error                  =   $return_data['data_bd'][':C_STATUS'][0]['TXT_ERROR'];
        }
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return'                    =>  $return_data,
            'txt_error'                 =>  $txt_error,
        )));
    }

    public function record_fecha_toma_muestra(){
        if(!$this->input->is_ajax_request()){   show_404();  }
        $status                         =   true;
        $txt_error                      =   '';
        $return_data                    =   $this->Ssan_libro_notificacancer_model->model_record_fecha_toma_muestra(array(
            'cod_empresa'               =>  $this->session->userdata("COD_ESTAB"),
            'constrasena'               =>  $this->input->post('constrasena'),
            'id_biopsia'                =>  $this->input->post('id_biopsia'),
            'fecha_solicitud'           =>  $this->input->post('fecha_solicitud'), 
            'hora_solicitud'            =>  $this->input->post('hora_solicitud'),  
        ));
        if(count($return_data['data_bd'][':C_STATUS'])>0){
            $status                     =   false;
            $txt_error                  =   $return_data['data_bd'][':C_STATUS'][0]['TXT_ERROR'];
        }
        $this->output->set_output(json_encode(array(
            'status'                    =>  $status,
            'return'                    =>  $return_data,
            'txt_error'                 =>  $txt_error,
        )));
    }    


    


}
?>