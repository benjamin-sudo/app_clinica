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
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $html_card_firmaunica = '';
        $username = $this->session->userdata('USERNAME');
        $data_user = $this->modelinicio->model_consultaporusuario($username);
        $html = $this->load->view('Dashboard/html_perfil_usuario',['username'=>$username, 'data_user'=>$data_user],true);
        $this->output->set_output(json_encode([
            'status' =>  $status,
            'data_user' => $data_user,
            'html' =>  $html,
        ]));
    }

    //
    public function solicitudNuevaFirma() {
        if(!$this->input->is_ajax_request()){ show_404(); return; }
        $html           =   ''; 
        $html_codigo    =   '';
        $status         =   true; 
        $firma          =   $this->input->post('firma');
        $username       =   $this->session->userdata('USERNAME');
        $data_user      =   $this->modelinicio->model_consultaporusuario($username);

        $fechaAhora     =   $this->sumarMinutosFecha(date('Y-m-d H:i:s'), 5);
        $datetime       =   strtotime($fechaAhora);

        if(count($data_user)>0){
            $userEmail      =   $data_user[0]['EMAIL'];
            $subject        =   'CONFIGURACI&Oacute;N FIRMA UNICA';
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

            $codigo = $this->generateCodigo();
            $return = $this->modelinicio->creaCodigoFirma($username, $codigo, $firma, $datetime);

            $body   =   '<div style="margin:0 auto; width:300px;">
                            Estimado Usuario.<br> 
                            Se ha generado una solicitud de cambio de Firma Digital Simple en el sistema e-SISSAN.<br><br>
                            <div style="border:solid 1px #ccc;padding:5px;">
                                Su código de verificación es el siguiente:
                                <div style="font-size:18px"><b>' . $codigo . '</b></div>
                                Este código tiene una duración de 5 minutos.
                            </div><br>
                            <b>Si usted no ha generado esta solicitud favor responder a correo : clinicalibrechile@gmail.com </b>
                        </div>';

            $this->email->message($body);

            if ($this->email->send()){
                $html = 'Correo enviado con exito.';
                $html_codigo = $this->load->view('Dashboard/html_confirmafirmaunica',[],true);
            } else {
                $status = false;
                $html = 'Error al enviar el correo. ' . $this->email->print_debugger(['headers']);
            }
        } else {
            $status = false;
            $html = 'Usuario no encontrado';
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode([
            'html_codigo' => $html_codigo,
            'status' => $status,
            'html' => $html
        ]));
    }
    #perfilUsuario

    function generateCodigo($strength = 8){
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
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