<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Constructor extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('modelinicio');
    }

    public function index(){
        $_valor         =   [];
        $_valor         =   $this->modelinicio->_index();
        $this->load->view('inicio',['return'=>$_valor]);
    }

    public function login(){
        if(!$this->input->is_ajax_request()) {  show_404(); }
        $user           =   strtoupper(str_replace(".","",$this->input->post('user')));
        $password       =   $this->input->post('password');
        $access         =   $this->input->post('access');
        $user           =   $this->modelinicio->login_modelo($user,$password);
        $status         =   $user['status'];
       
        if($user['status']){
     
            $unique                     =   str_replace('-', '', $userL[0]["USERNAME"]) . $this->getRandomCode();
            $_SESSION["IP"]             =   $this->input->ip_address();
            $_SESSION["loginFr"]        =   'si';
            $_SESSION["USERNAME"]       =   $userL[0]["USERNAME"];
            $_SESSION["NAMESESSION"]    =   $userL[0]["NAME"];
            $_SESSION["FONOSESSION"]    =   $userL[0]["TELEPHONE"];
            $_SESSION["ID_UID"]         =   $iuid;
            $_SESSION["unique"]         =   $unique;

            $newdata            =   array(
                'ID_UID'        =>  $iuid,
                'USERNAME'      =>  $userL[0]["USERNAME"],
                'uniq ue'       =>  $unique,
                'NAMESESSION'   =>  $userL[0]["NAME"],
                'FONOSESSION'   =>  $userL[0]["TELEPHONE"],
                'LASTLOGIN'     =>  $userL[0]["LASTLOGIN"],
                'loginFr'       =>  'si'
            );
            $this->session->set_userdata($newdata);

        }

        #########################
        #   CPU Ryzen 7 7700X   #
        #########################
        
        $this->output->set_output(json_encode([
            'status'    =>  true,
            'userL'     =>  $user,
        ]));
    }
    
    function getRandomCode() {
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

    public function login0(){
        #if (!$this->input->is_ajax_request()) {  show_404(); }
        $this->output->set_output(json_encode([
            'opcion'=> 'login 2',
            'status' => true
        ]));
    }
}
?>







