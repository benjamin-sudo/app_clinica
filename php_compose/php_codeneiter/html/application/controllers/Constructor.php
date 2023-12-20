<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Constructor extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('modelinicio');
    }

    public function index(){
        $this->load->view('inicio');
    }

    public function login(){
        if(!$this->input->is_ajax_request()) {  show_404(); }
        $status         =   true;
        $user           =   strtoupper(str_replace(".","",$this->input->post('user')));
        $password       =   $this->input->post('password');
        $access         =   $this->input->post('access');
        $userL          =   $this->modelinicio->trae_login($user,$password,$access);




        $this->output->set_output(json_encode([
            'status'    => true,
            'post'      => $user,
        ]));
    }

    public function login0(){
       // if (!$this->input->is_ajax_request()) {  show_404(); }

        $this->output->set_output(json_encode([
            'opcion'=> 'login 2',
            'status' => true
        ]));
    }
}
?>







