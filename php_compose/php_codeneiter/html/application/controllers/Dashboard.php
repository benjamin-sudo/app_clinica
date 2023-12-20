<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct(){
        $this->load->is_session();
        parent::__construct();
    }

    public function index(){
        //echo "Pasa";
        $this->load->view('Dashboard/view_escritorio',['return'=>[]]);
    }

}