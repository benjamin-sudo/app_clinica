<?php

class Ssan_libro_biopsias_ii_fase extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('pdf');
        $this->load->library('session');
        #$this->load->model("Ssan_libro_biopsias_ii_fase_model");
    }

    public function index(){
        $this->output->set_template('blank');
        $v_out = [];
        $this->load->css("assets/Ssan_libro_biopsias_ii_fase/css/styles.css");
        $this->load->js("assets/Ssan_libro_biopsias_ii_fase/js/javascript.js");
        $this->load->view('Ssan_libro_biopsias_ii_fase/ssan_libro_biopsias_ii_fase_view',$v_out);
    }
}
?>