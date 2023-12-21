<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();              # Primero, llama al constructor del padre.
        $this->load->library('session');    # Después, carga las bibliotecas y otros recursos.
        $this->load->helper('url');         # 
    }

    public function index(){
        
        $MENUARRFR = '';
        $MENUARRFR = $this->session->userdata('MENUARRFR');
        $this->load->view('Dashboard/view_escritorio',['return'=>$MENUARRFR ]);


    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('/'); // Reemplaza 'ruta/a/login' con la ruta real a tu página de inicio de sesión.
    }

}