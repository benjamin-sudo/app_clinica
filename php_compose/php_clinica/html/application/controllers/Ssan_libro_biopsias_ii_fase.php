<?php

class Ssan_libro_biopsias_ii_fase extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('pdf');
        $this->load->library('session');
        #$this->load->model("Ssan_libro_biopsias_listaexterno1_model");
        #$this->load->model("ssan_pre_gestionarprestador_model");
        $this->load->model("Ssan_libro_biopsias_usuarioext_model");
        $this->load->model("Ssan_libro_biopsias_ii_fase_model");
    }

    public function index(){
        $this->output->set_template('blank');
        $return_data = [];
        $origen_sol = 0; //LISTADO DE ORIGEN DE SOLICITUDES - DEFAULT 0 - ALL 
        $pto_entrega = 0; //LISTADO DE ORIGEN PUNTOS DE ENTREGA DESCRITA EN LA SOLICITUD DE ANATOMIA - DEFAULT 0 - ALL
        #COOKIE TIEMPO BUSQUEDA
        if(!isset($_COOKIE['date_inicio']) && !isset($_COOKIE['date_final'])){
            #DATE DEFAULT
            $date_inicio = date("d-m-Y");
            $date_final = date("d-m-Y");
            #DATE INICIO TIEMPO
            $this->input->set_cookie(['name' => 'date_inicio', 'value' => $date_inicio, 'expire' => 86500, 'secure' => false]);
            #DATE INICIO TIEMPO
            $this->input->set_cookie(['name' => 'date_final', 'value' => $date_final, 'expire' => 86500, 'secure' => false]);
        } else {
            #DATE COOKIE
            $date_inicio = $_COOKIE['date_inicio'];
            $date_final = $_COOKIE['date_final'];
        }
        #LOAD
        $return_data = $this->Ssan_libro_biopsias_usuarioext_model->model_busquedasolicitudes_recepcion(array(
            "data_inicio" => $date_inicio,
            "data_final" => $date_final,
            "usr_session" => explode("-",$this->session->userdata("USERNAME"))[0],
            "ind_opcion" => 0,
            "ind_first" => 1,
            "origen_sol" => $origen_sol,
            "pto_entrega" => $pto_entrega,
            "COD_EMPRESA" => $this->session->userdata("COD_ESTAB"),
            "num_fase" =>  2,
            "ind_template" => "ssan_libro_biopsias_ii_fase",
        ));
        $this->load->css("assets/ssan_libro_biopsias_ii_fase/css/styles.css");
        $this->load->js("assets/ssan_libro_biopsias_ii_fase/js/javascript.js");
        $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/anatomia_patologica.js");
        $this->load->view("ssan_libro_biopsias_ii_fase/ssan_libro_biopsias_ii_fase_view",$return_data);
    }

    public function get_confirma_rechazo_muestras(){
        if(!$this->input->is_ajax_request()){   show_404(); }
        $status = true;
        $data_produccion = [];
        $contrasena = $this->input->post('contrasena'); 
        $valida = $this->Ssan_libro_biopsias_usuarioext_model->validaClave($contrasena);
        $empresa = $this->session->userdata("COD_ESTAB");
        $id_anatomia = $this->input->post('id_anatomia');
        $usuarioh = explode("-",$this->session->userdata("USERNAME"));
        $array_muestras = $this->input->post('array_muestras'); 
        $STATUS_MUESTRAS = $this->input->post('STATUS_MUESTRAS');  
        $TXT_GLOBAL = $this->input->post('TXT_GLOBAL');
        if(count($valida)>0){
            $data_produccion = $this->Ssan_libro_biopsias_ii_fase_model->model_confirma_rechazo_muestras(array(
                "ID_ANATOMIA" => $id_anatomia,
                "COD_EMPRESA" => $empresa,
                "SESSION" => $usuarioh[0], 
                "ARRAY" => $array_muestras,
                "DATA_FIRMA" => $valida,
                "TXT_GLOBAL" => $TXT_GLOBAL,
                "STATUS_MUESTRAS" => $STATUS_MUESTRAS
            ));
        } else {
            $status = false;
        }
        $this->output->set_output(json_encode([
            'valida' => $valida,
            'status' => $status,
            'data_produccion' => $data_produccion,
            'post_' => $_POST,
        ]));
    }
    
}
?>