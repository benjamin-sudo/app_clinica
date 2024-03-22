<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();              # Primero, llama al constructor del padre.
        $this->load->library('session');    # Después, carga las bibliotecas y otros recursos.
        $this->load->helper('url');         # 
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
        if(!$this->input->is_ajax_request()){ show_404(); }
        $username =  $this->session->userdata('USERNAME');


        $html = $this->load->view('Dashboard/html_perfil_usuario',['username'=>$username],true);
        $this->output->set_output(json_encode([
            'status' => $status,
            'html' => $html
        ]));
    }

    public function solicitudNuevaFirma(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $html           =   '';
        $status         =   true;
        $firma          =   $this->input->post('firma');
        $username       =   strtoupper($this->input->post('username'));

        /*
        $consulta       =   $this->model_frontend->tradatos_usuFirmaS1($username);
        if ($consulta) {
            $userEmail          =   $consulta[0]["EMAIL"];
            $subject            =   'Solicitud - Cambio de Firma Digital Simple';
            $config = array(
                'protocol'      =>  'sendmail',
                'smtp_port'     =>  25,
                'smtp_timeout'  =>  '4',
                'mailtype'      =>  'html',
                'charset'       =>  'utf-8'
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('noresponder@araucanianorte.cl', 'e-SISSAN');
            $this->email->to($userEmail);  // replace it with receiver mail id                
            $this->email->subject($subject); // replace it with relevant subject   

            $fechaAhora     =   $this->sumarMinutosFecha(date('Y-m-d H:i:s'), 5);
            $datetime       =   strtotime($fechaAhora);
            $codigo         =   $this->generateCodigo();

            $body = '<div style="margin:0 auto; width:300px;">
                            Estimado Usuario.<br> 
                            Se ha generado una solicitud de cambio de Firma Digital Simple en el sistema e-SISSAN.<br><br>
                            <div style="border:solid 1px #ccc;padding:5px;">
                                Su código de verificación es el siguiente:
                                <div style="font-size:18px"><b>' . $codigo . '</b></div>
                                Este código tiene una duración de 5 minutos.
                            </div><br>
                            <b>Si usted no ha generado esta solicitud favor comunicarce con el Departamento de Informática del Servicio de Salud Araucania Norte.</b>
                            </div>';

            $this->email->message($body);

            $return = $this->model_frontend->creaCodigoFirma($username, $codigo, $firma, $datetime);


            if ($return) {
                $this->email->send();
                $html .= "<script>jMessage('Estimado Usuario, se ha enviado el codigo de validación a su correo electronico $userEmail', 'Confirmación',function(){ stratVerif() });</script>";
            }
        } else {
            $html .= '<script>jWarning("Datos de funcionario no encontrados","Información");</script>';
        }
        */
        
        $this->output->set_output(json_encode([
            'status'    =>  $status,
            'html'      =>  $html
        ]));
    }
}