<?php

class Ssan_libro_biopsias_ii_fase extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('pdf');
        $this->load->library('session');
        #$this->load->model("Ssan_libro_biopsias_ii_fase_model");
        $this->load->model("Ssan_libro_biopsias_usuarioext_model");
        $this->load->model("Ssan_libro_biopsias_listaexterno1_model");
        #$this->load->model("ssan_pre_gestionarprestador_model");
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
            $this->input->set_cookie(array(
                'name' => 'date_inicio',
                'value' => $date_inicio,
                'expire' => 86500,
                'secure' => false
            ));
            #DATE INICIO TIEMPO
            $this->input->set_cookie(array(
                'name' => 'date_final',
                'value' => $date_final,
                'expire' => 86500,
                'secure' => false
            ));
        } else {
            #DATE COOKIE
            $date_inicio = $_COOKIE['date_inicio'];
            $date_final = $_COOKIE['date_final'];
        }
        #LOAD
        $return_data = $this->Ssan_libro_biopsias_usuarioext_model->model_busquedasolicitudes(array(
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
}
?>