<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();              # Primero, llama al constructor del padre.
        $this->load->library('session');    # Después, carga las bibliotecas y otros recursos.
        $this->load->helper('url');         #
        $this->load->model('modelinicio');  # Consultas MYSQL
    }

    public function index(){
        $MENUARRFR = [];
        if(!$this->session->userdata('ID_UID')){
            redirect('/'); // Asegúrate de reemplazar 'ruta/a/login' con la ruta real a tu página de inicio de sesión.
        }
        $MENUARRFR = $this->session->userdata('MENUARRFR');
        $this->load->view('Dashboard/view_escritorio',['menu'=>$MENUARRFR]);
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('/'); // Reemplaza 'ruta/a/login' con la ruta real a tu página de inicio de sesión.
    }

    public function configuracion_micuenta(){
        $status = true;
        $html_card_firmaunica = '';
        if(!$this->input->is_ajax_request()){ show_404(); }
        $username = $this->session->userdata('USERNAME');
        $data_user = $this->modelinicio->model_consultaporusuario($username);
        $html = $this->load->view('Dashboard/html_perfil_usuario',['username'=>$username, 'data_user'=>$data_user],true);


        $v_firma_simple = $data_user[0]['TX_INTRANETSSAN_CLAVEUNICA'];
        if(is_null($v_firma_simple)){
            $html_card_firmaunica = $this->load->view('Dashboard/html_sin_firmaunica',[],true);
        } else {
            $html_card_firmaunica = '';
        }
        
        $this->output->set_output(json_encode([
            'status' =>  $status,
            'data_user' => $data_user,
            'html' =>  $html,
            'html_card_firmaunica' => $html_card_firmaunica,
        ]));
    }

    //
    public function solicitudNuevaFirma() {
        if(!$this->input->is_ajax_request()){ show_404(); return; }
        $html           =   ''; 
        $html_codigo    =   '';
        
        $status         =   true; 
        $firma          =   $this->input->post('firma');
        $username       =   strtoupper($this->input->post('USERNAME'));
        $userEmail      =   'benjamin.castillo03@gmail.com'; 
        $subject        =   'TEST';
        
        $config = [
            'smtp_user'     => 'clinicalibrechile@gmail.com',
            'smtp_pass'     => 'hdmbkfrxxrleunqu',
            'protocol'      => 'smtp',
            'smtp_host'     => 'smtp.gmail.com',
            #'smtp_port'    => 465,
            #'smtp_crypto'  => 'ssl', 
            'smtp_port'     => 587,
            'smtp_crypto'   => 'tls', 
            'mailtype'      => 'html',
            'starttls'      => true,
            'newline'       => "\r\n",
        ];

        $this->load->library('email', $config);
        $this->email->from('clinicalibrechile@gmail.com','Clinica Libre Chile - Firma Unica Digital');
        $this->email->to($userEmail);
        $this->email->subject($subject);
        $html_mensaje   =   'Scorpions - Still Loving You';
        $this->email->message($html_mensaje);
        if ($this->email->send()){
            $html       =   'Correo enviado con éxito.';
            #$html_codigo  =   $this->load->view('Dashboard/html_perfil_usuario',[],true);
        } else {
            $status     =   false;
            $html       =   'Error al enviar el correo. ' . $this->email->print_debugger(['headers']);
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode([
            'status' => $status,
            'html' => $html
        ]));
    }

    function sumarMinutosFecha($FechaStr, $MinASumar)  {
        $FechaStr       =   str_replace("-", " ", $FechaStr);
        $FechaStr       =   str_replace(":", " ", $FechaStr);
        $FechaOrigen    =   explode(" ", $FechaStr);
        $Dia            =   $FechaOrigen[2];
        $Mes            =   $FechaOrigen[1];
        $Ano            =   $FechaOrigen[0];
        $Horas          =   $FechaOrigen[3];
        $Minutos        =   $FechaOrigen[4];
        $Segundos       =   $FechaOrigen[5];
        // Sumo los minutos
        $Minutos        =   ((int) $Minutos) + ((int) $MinASumar);
        // Asigno la fecha modificada a una nueva variable
        $FechaNueva     = date("Y-m-d H:i:s", mktime($Horas, $Minutos, $Segundos, $Mes, $Dia, $Ano));
        return $FechaNueva;
    }
}