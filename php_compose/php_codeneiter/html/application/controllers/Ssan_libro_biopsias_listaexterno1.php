<?php

class Ssan_libro_biopsias_listaexterno1 extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_libro_biopsias_listaexterno1_model");
        $this->load->model("Ssan_libro_biopsias_usuarioext_model");
    }
    
    public function index(){
        $this->output->set_template('blank');
        $data               =   [];
        $session            =   explode("-",$this->session->userdata("USERNAME"));
        $empresa            =   $this->session->userdata("COD_ESTAB");
        $origen_sol         =   0;  #listado de origen de solicitudes - (DEFAULT 0 - ALL) 
        $pto_entrega        =   0;  #listado de origen puntos de entrega descrita en la solicitud de anatomia - (DEFAULT 0 - ALL) 
        $ind_opcion         =   0;  #0-MASTER | 1-PB_PROFESIONALXROTULO
        $return_data        =   $this->Ssan_libro_biopsias_usuarioext_model->carga_lista_rce_externo_ap(array(
                                    "data_inicio"       =>  date("d-m-Y"),
                                    "data_final"        =>  date("d-m-Y"),
                                    "usr_session"       =>  $session[0],
                                    "ind_opcion"        =>  $ind_opcion,
                                    "ind_first"         =>  1,
                                    "origen_sol"        =>  $origen_sol,
                                    "pto_entrega"       =>  $pto_entrega,
                                    "COD_EMPRESA"       =>  $empresa,
                                    "num_fase"          =>  1,
                                    "ind_template"      =>  "ssan_libro_biopsias_listaexterno1",
                                ));
        #ETIQUETA ZEBRA BROWSER PRINT
        #$this->load->js("assets/ssan_libro_biopsias_listagespab/js/BrowserPrint-1.0.4.min.js");
        #$this->load->js("assets/ssan_libro_biopsias_listagespab/js/etiqueta.js");
        #GESTOR GLOBAL AP
        $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/anatomia_patologica.js");      
        #BUSQUEDA  
        $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/javascript_trazabilidad.js");     
        $this->load->css("assets/Ssan_libro_biopsias_listaexterno1/css/styles.css");
        #ADD ARRIBA
        #$this->load->css("assets/ssan_libro_biopsias_listagespab/css/styles.css");                  
        $this->load->js("assets/Ssan_libro_biopsias_listaexterno1/js/javascript.js");
        $this->load->view('Ssan_libro_biopsias_listaexterno1/Ssan_libro_biopsias_listaexterno1_view',$return_data);
    }


    
    public function update_main(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $session                    =   explode("-",$this->session->userdata("USERNAME"));
        $date_inicio                =   $this->input->post('fecha_inicio');
        $date_final                 =   $this->input->post('fecha_final');
        #DATE INICIO TIEMPO
        $this->input->set_cookie(array(
            'name'                  =>  'date_inicio',
            'value'                 =>  $date_inicio,
            'expire'                =>  86500,
            'secure'                =>  false
        ));
        #DATE INICIO TIEMPO
        $this->input->set_cookie(array(
            'name'                  =>  'date_final',
            'value'                 =>  $date_final,
            'expire'                =>  86500,
            'secure'                =>  false
        ));
        #SALIDA ARREGLO
        $aData                      =   $this->Ssan_libro_biopsias_usuarioext_model->carga_lista_rce_externo_ap(array(
            "data_inicio"           =>  $date_inicio,
            "data_final"            =>  $date_final,
            "usr_session"           =>  $session[0],
            "ind_opcion"            =>  $this->input->post('OPTION'),
            "ind_first"             =>  0,
            "origen_sol"            =>  $this->input->post('origen_sol'),
            "pto_entrega"           =>  $this->input->post('pto_entrega'),
            "COD_EMPRESA"           =>  $this->session->userdata("COD_ESTAB"),
            "num_fase"              =>  $this->input->post('NUM_FASE'),
            "ind_template"          =>  $this->input->post('ind_template'),
        ));
        #OUT
        $this->output->set_output(json_encode(array(
            'STATUS'                =>  true,
            'adata'                 =>  $aData,
            'STATUS_OUT'            =>  $aData['html_externo'],
        )));
    }
}
?>