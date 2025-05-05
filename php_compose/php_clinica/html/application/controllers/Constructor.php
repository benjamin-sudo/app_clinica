<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Constructor extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->model('Modelinicio');
        #$this->load->model('Testmodel');
        #echo $this->Testmodel->test();
    }

    public function enviar_enlace_recuperacion(){
        $email = $this->input->post('email');
        $usuario = $this->Modelinicio->obtener_por_correo($email);
        if ($usuario) {
            $token = bin2hex(random_bytes(32));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->Modelinicio->guardar_token_recuperacion($usuario->ID_UID, $token, $expira);
            if ($_SERVER['HTTP_HOST'] == 'localhost:9025') {
                $base = 'http://localhost:9025/';
            } else {
                $base = 'https://www.clinicalibre.cl/';
            }
            $enlace = $base . "recuperar/resetear/$token";
            $this->email->initialize([
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_user' => 'clinicalibrechile@gmail.com',
                'smtp_pass' => 'ficdkbpjmjgybloy',
                'smtp_port' => 587,
                'smtp_crypto' => 'tls',
                'mailtype' => 'html',
                'newline' => "\r\n",
            ]);
            $this->email->from('clinicalibrechile@gmail.com', 'Clínica Libre Chile');
            $this->email->to($email);
            $this->email->subject('Recuperación de contraseña');
            $mensaje = "
                <p>Hola, has solicitado recuperar tu acceso.</p>
                <p>Haz clic en el siguiente enlace para continuar:</p>
                <p><a href='$enlace'>$enlace</a></p>
                <p>Este enlace expirará en 1 hora.</p>";
            $this->email->message($mensaje);
            $this->email->send();

            $this->session->set_flashdata('msg', 'Se envi&oacute; correo para recuperaci&oacute;n a : '.$email);
            $data['mensaje'] = $this->session->flashdata('msg');
        } else {
            $this->session->set_flashdata('msg', 'Correo no registrado : '.$email);
            $data['mensaje'] = $this->session->flashdata('msg');
        }
        $this->load->view('inicio', $data);
    }

    public function resetear($token) {
        $tokenData = $this->Modelinicio->verificar_token($token);
        if ($tokenData && $tokenData->USADO == 0 && strtotime($tokenData->EXPIRA) > time()) {
            $data['token'] = $token;
            $data['row'] = $tokenData;
            $this->load->view('Dashboard/html_resetear_contrasena', $data);
        } else {
            echo "Enlace inválido o expirado.";
        }
    }
  
    public function actualizar_contrasena(){
        $token = $this->input->post('token');
        $nueva_pass = $this->input->post('passNew1');
        $tokenData = $this->Modelinicio->verificar_token_actualiza_borratoken($token, $nueva_pass);
        if ($tokenData) {
            $this->session->set_flashdata('msg', 'Contraseña actualizada con éxito.');
        } else {
            $this->session->set_flashdata('msg', 'Token inválido o expirado.');
        }
        redirect('/');
    }

    public function index(){
        $_valor = [];
        $_valor = $this->Modelinicio->_index();
        $this->load->view('inicio',['return'=>$_valor]);
    }

    public function login(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $user = strtoupper(str_replace(".","",$this->input->post('user')));
        $password = $this->input->post('password');
        $access = $this->input->post('access');
        $userL = [];
        $redirect = '';
        $user = $this->Modelinicio->login_modelo($user,$password);
        $status = $user['status'];
        if($user['status']){
            $userL = $user['row'];
            $unique = str_replace('-','',$userL->USERNAME).$this->getRandomCode();
            $empresas = $user['cod_empresa_default'];
            $txt_empresa = $user['txt_empresa_default'];
            $_SESSION["IP"] = $this->input->ip_address();
            $_SESSION["ID_UID"] = $userL->ID_UID;
            $_SESSION["unique"] = $unique;
            $_SESSION["USERNAME"] = $userL->USERNAME;
            $_SESSION["NAMESESSION"] = $userL->NAME;
            $_SESSION["FONOSESSION"] = $userL->TELEPHONE;
            $_SESSION["loginFr"] = 'si';
            $_SESSION["COD_ESTAB"] = $empresas;
            $_SESSION["NOM_ESTAB"] = $txt_empresa;
            $_SESSION["COUNT_EMPRESAS"] = $user['v_multiple_empresa'];
            $this->session->set_userdata([
                'unique' => $unique,
                'ID_UID' => $userL->ID_UID,
                'USERNAME' => $userL->USERNAME,
                'NAMESESSION' => $userL->NAME,
                'FONOSESSION' => $userL->TELEPHONE,
                'LASTLOGIN' => $userL->LASTLOGIN,
                'loginFr' => 'si',
                'MENUARRFR' => $user['menu'],
                'COD_ESTAB' => $empresas,
                'NOM_ESTAB' => $txt_empresa,
                'COUNT_EMPRESAS' =>  $user['v_multiple_empresa'],
            ]);
            $redirect = 'Dashboard';
        }
        $this->output->set_output(json_encode([
            'status' => $status,
            'redirect' => $redirect,
            'userL' => $user,
        ]));
    }

    public function get_cambioempresa_all(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $data_empresas = [];
        $v_txt_empresas = $this->input->post('v_txt_empresas');
        $v_selectedText = $this->input->post('v_selectedText');
        $_SESSION["COD_ESTAB"] = $v_txt_empresas;
        $_SESSION["NOM_ESTAB"] = $v_selectedText;
        $this->session->set_userdata([
            'COD_ESTAB' => $v_txt_empresas,
            'NOM_ESTAB' => $v_selectedText,
        ]);
        $this->output->set_output(json_encode([
            'status' => $status,
            'data_empresas' => $data_empresas,
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
        return  substr($an, rand(0, $su), 1) .
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

    #$this->load->view('inicio', $data);
    #log_message('info', '###############################################################');
    #log_message('info', 'Intentando actualizar contraseña con token: ' . $token);
    #log_message('info', '###############################################################');
    #return view('inicio', $data);

}
?>
