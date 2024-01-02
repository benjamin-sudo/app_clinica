<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Constructor extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('modelinicio');
    }

    public function index(){
        $_valor         =   [];
        $_valor         =   $this->modelinicio->_index();
        $this->load->view('inicio',['return'=>$_valor]);
    }

    public function login(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $user           =   strtoupper(str_replace(".","",$this->input->post('user')));
        $password       =   $this->input->post('password');
        $access         =   $this->input->post('access');
        $userL          =   [];
        $redirect       =   '';
        $user           =   $this->modelinicio->login_modelo($user,$password);
        $status         =   $user['status'];
        if($user['status']){   
            $userL                      =   $user['row'];
            $unique                     =   str_replace('-','', $userL->USERNAME).$this->getRandomCode();
            
            $_SESSION["IP"]             =   $this->input->ip_address();
            $_SESSION["ID_UID"]         =   $userL->ID_UID;
            $_SESSION["unique"]         =   $unique;
            $_SESSION["USERNAME"]       =   $userL->USERNAME;
            $_SESSION["NAMESESSION"]    =   $userL->NAME;
            $_SESSION["FONOSESSION"]    =   $userL->TELEPHONE;
            $_SESSION["loginFr"]        =   'si';
            $_SESSION["COD_ESTAB"]      =   '100';
            $newdata            =   array(
                'unique'        =>  $unique,
                'ID_UID'        =>  $userL->ID_UID,
                'USERNAME'      =>  $userL->USERNAME,
                'NAMESESSION'   =>  $userL->NAME,
                'FONOSESSION'   =>  $userL->TELEPHONE,
                'LASTLOGIN'     =>  $userL->LASTLOGIN,
                'loginFr'       =>  'si',
                'MENUARRFR'     =>  $user['menu'],
                'COD_ESTAB'     =>  '',
            );
            $this->session->set_userdata($newdata);
            $redirect = 'Dashboard';
        }
        $this->output->set_output(json_encode([
            'status'    =>  $status,
            'redirect'  =>  $redirect,
            'userL'     =>  $user,
        ]));
    }

    public function login0(){
        #if (!$this->input->is_ajax_request()) {  show_404(); }
        $this->output->set_output(json_encode([
            'opcion'=> 'login 2',
            'status' => true
        ]));
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('Login');
    }
    
    public function getRandomCode() {
        $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $su = strlen($an) - 1;
        return substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1);
    }
}
?>
