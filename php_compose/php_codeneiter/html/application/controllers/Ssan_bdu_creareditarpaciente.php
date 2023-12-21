<?php

class Ssan_bdu_creareditarpaciente extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        //$this->output->set_template("frontend");
        $this->load->js("assets/ssan_bdu_creareditarpaciente/js/javascript.js");
        $this->load->css("assets/ssan_bdu_creareditarpaciente/css/styles.css");
        $this->load->view('ssan_bdu_creareditarpaciente/Ssan_bdu_creareditarpaciente_view',[]);
    }
}

