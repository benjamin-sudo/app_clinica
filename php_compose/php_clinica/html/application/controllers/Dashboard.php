<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('modelinicio');
    }

    public function index(){
        $MENUARRFR = [];
        if(!$this->session->userdata('ID_UID')){ redirect('/'); }
        $MENUARRFR = $this->session->userdata('MENUARRFR');
        $this->load->view('Dashboard/view_escritorio',['menu'=>$MENUARRFR]);
    }

    public function cambioempresa(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $V_ID_UID = $this->session->userdata('ID_UID');
        $data_empresas = $this->modelinicio->model_busqueempesas($V_ID_UID);
        $this->output->set_output(json_encode([
            'status' => $status,
            'data_empresas' => $data_empresas,
        ]));
    }
   
    public function logout(){
        $this->session->sess_destroy();
        redirect('/');
    }

    public function configuracion_micuenta(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $html_card_firmaunica = '';
        $username = $this->session->userdata('USERNAME');
        $data_user = $this->modelinicio->model_consultaporusuario($username);
        $html = $this->load->view('Dashboard/html_perfil_usuario',['username'=>$username, 'data_user'=>$data_user],true);
        $this->output->set_output(json_encode([
            'status' => $status,
            'data_user' => $data_user,
            'html' =>  $html,
        ]));
    }

    public function solicitudNuevaFirma() {
        if(!$this->input->is_ajax_request()){ show_404(); return; }
        $html = ''; 
        $html_codigo = '';
        $status = true; 
        $firma = $this->input->post('firma');
        $username = $this->session->userdata('USERNAME');
        $fechaAhora = $this->sumarMinutosFecha(date('Y-m-d H:i:s'),5);
        $datetime = strtotime($fechaAhora);
        $data_user = $this->modelinicio->model_consultaporusuario($username);
        if(count($data_user)>0){
            $userEmail = $data_user[0]['EMAIL'];
            $subject = 'CONFIGURACIÓN FIRMA UNICA';
            $config = [
                'smtp_user' => 'clinicalibrechile@gmail.com',
                'smtp_pass' => 'ficdkbpjmjgybloy',
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                #'smtp_port' => 465,
                #'smtp_crypto' => 'ssl', 
                'smtp_port' => 587,
                'smtp_crypto' => 'tls', 
                'mailtype' => 'html',
                'starttls' => true,
                'newline' => "\r\n",
            ];
            $this->load->library('email', $config);
            $this->email->from('clinicalibrechile@gmail.com','Clinica Libre Chile - Firma Unica Digital');
            $this->email->to($userEmail);
            $this->email->subject($subject);
            $codigo = $this->generateCodigo();
            $return = $this->modelinicio->creaCodigoFirma($username, $codigo, $firma, $datetime);
            $body = '<div style="margin:0 auto; width:300px;">
                        Estimado Usuario.<br> 
                        Se ha generado una solicitud de cambio de Firma Digital unica en el sistema <b>Clinica libre Chile</b>
                        <br>
                        <br>
                        <div style="border:solid 1px #ccc;padding:5px;">
                            Su código de verificación es el siguiente:
                            <div style="font-size:18px">
                                <b>'.$codigo.'</b>
                            </div>
                            Este código tiene una duración de 5 minutos.
                        </div>
                        <br>
                        Si usted no ha generado esta solicitud favor responder a correo 
                        <br>
                        <b>clinicalibrechile@gmail.com</b>
                    </div>';
            $this->email->message($body);
            if ($this->email->send()){
                $html = 'Correo enviado con exito.';
                $html_codigo = $this->load->view('Dashboard/html_confirmafirmaunica',['firma'=>$firma],true);
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

    public function validaFirmaExist(){
        if (!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $passNew = $this->input->post('firma');
        $username = $this->input->post('username');
        $valida = $this->modelinicio->Consultaexistefirma($passNew,$username);
        if (count($valida)>0){ $status = false; }
        $this->output->set_output(json_encode([
            'status' => $status,
        ]));
    }

    public function confirmCambioFirma() {
        if (!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $codVerif = $this->input->post('codVerif');
        $firmaNew = $this->input->post('firmaNew');
        $username = strtoupper($this->input->post('username'));
        $html_firmaunica = '';
        $valida = $this->modelinicio->getValidaCodigo($codVerif,$username);
        if (count($valida)>0){
            $fechaSis = $valida[0]['FH_HOY'];
            $fechaAhora = strtotime(date('Y-m-d H:i:s'));
            $confirm = $this->modelinicio->confirmaCambioFirma($username);
            $html_firmaunica = $this->load->view('Dashboard/html_firmaunica',['firma'=>$firmaNew],true);
        } else {
            $status = false;
        }
        $this->output->set_output(json_encode([
            'valida' => $valida,
            'status' => $status,
            'html_firmaunica' => $html_firmaunica
        ]));
    }

    public function html_nuevafirma() {
        if (!$this->input->is_ajax_request()){ show_404(); }
        $this->output->set_output(json_encode([
            'html' => $this->load->view('Dashboard/html_sin_firmaunica',[],true),
        ]));
    }

    public function confirmEnvioRecuperacion() {
        if (!$this->input->is_ajax_request()){ show_404(); }
        $status = true;
        $this->output->set_output(json_encode([
            'status' => $status
        ]));
    }

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
        $FechaStr = str_replace("-", " ", $FechaStr);
        $FechaStr = str_replace(":", " ", $FechaStr);
        $FechaOrigen = explode(" ", $FechaStr);
        $Dia = $FechaOrigen[2];
        $Mes = $FechaOrigen[1];
        $Ano = $FechaOrigen[0];
        $Horas = $FechaOrigen[3];
        $Minutos = $FechaOrigen[4];
        $Segundos = $FechaOrigen[5];
        $Minutos = ((int) $Minutos) + ((int) $MinASumar);
        $FechaNueva = date("Y-m-d H:i:s", mktime($Horas, $Minutos, $Segundos, $Mes, $Dia, $Ano));
        return $FechaNueva;
    }

    public function RecuerdaContrasena(){
        if (!$this->input->is_ajax_request()) { show_404(); }
        $status = true;
        $html = '';
        $iuid = $this->session->userdata('ID_UID');
        $consulta = $this->modelinicio->tradatos_usu($iuid);
        if(count($consulta)>0){
            $passCla = $consulta[0]["TX_INTRANETSSAN_CLAVEUNICA"];
            $userEmail = $consulta[0]["EMAIL"];
            $subject = 'Solicitud de recuperación de firma digital';
            $subject = 'RECUPERACIÓN FIRMA UNICA';
            $config = [
                'smtp_user' => 'clinicalibrechile@gmail.com',
                'smtp_pass' => 'ficdkbpjmjgybloy',
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                #'smtp_port' => 465,
                #'smtp_crypto' => 'ssl', 
                'smtp_port' => 587,
                'smtp_crypto' => 'tls', 
                'mailtype' => 'html',
                'starttls' => true,
                'newline' => "\r\n",
            ];
            $this->load->library('email',$config);
            $this->email->from('clinicalibrechile@gmail.com','Clinica Libre Chile - Firma Unica Digital');
            $this->email->to($userEmail);
            $this->email->subject($subject);
            $body = '<div style="margin:0 auto; width:300px;">Estimado Usuario.<br> 
                        Se ha generado una solicitud de recuperaci&oacute;n de firma digital unica en el sistema . Clinica libre
                        <br> 
                        <br>                            
                        <div style="border:solid 1px #ccc;padding:5px;font-size:18px">
                            Su firma digital unica es la siguiente:<br><b>'.$passCla.'</b>
                        </div>
                        <br>
                        <b>Si usted no ha generado esta solicitud favor comunicarce con el Sub-Departamento de Clinica libre Chile.</b>
                        <br>Correo : <b>clinicalibrechile@gmail.com</b>
                    </div>';
            $this->email->message($body);
            if ($this->email->send()){
                $html = 'Correo enviado con &eacute;xito.';
                $html_codigo = $this->load->view('Dashboard/html_confirmafirmaunica',['firma'=>$firma],true);
            } else {
                $status = false;
                $html = 'Error al enviar el correo. ' . $this->email->print_debugger(['headers']);
            }
        } else {
            $status = false;
            $html = 'Usuario no encontrado.';
        }
        $this->output->set_output(json_encode([
            'status' => $status,
            'html' => $html
        ]));
    }
}