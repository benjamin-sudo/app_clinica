<?php

class Ssan_bdu_creareditarpaciente extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('output');
    }

    public function index(){
        $data = [];
        #$this->output->set_template("frontend");
        #$this->output->set_template('frontend')->set($data);
        #$data['css_files']     =   ['assets/ssan_bdu_creareditarpaciente/css/styles.css'];
        #$data['js_files']      =   ['assets/ssan_bdu_creareditarpaciente/js/javascript.js'];
        #$data['css_files']     =   '<link rel="stylesheet" href="path/to/your/css.css">';
        #$data['js_files']      =   '<script src="path/to/your/script.js"></script>';
        $this->load->js("assets/ssan_bdu_creareditarpaciente/js/javascript.js");
        $this->load->css("assets/ssan_bdu_creareditarpaciente/css/styles.css");
        $this->load->view('ssan_bdu_creareditarpaciente/Ssan_bdu_creareditarpaciente_view', $data);
    }
    
}
