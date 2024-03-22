<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();              # Primero, llama al constructor del padre.
        $this->load->library('session');    # Después, carga las bibliotecas y otros recursos.
        $this->load->helper('url');         #
        $this->load->model('modelinicio');   
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
        $status     = true;
        if(!$this->input->is_ajax_request()){ show_404(); }
        $username   = $this->session->userdata('USERNAME');
        $html       = $this->load->view('Dashboard/html_perfil_usuario',['username'=>$username],true);
        $this->output->set_output(json_encode([
            'status'    =>  $status,
            'html'      =>  $html
        ]));
    }


    //
    public function solicitudNuevaFirma(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $html           =   '';
        $status         =   true;
        $firma          =   $this->input->post('firma');
        $username       =   strtoupper($this->input->post('username'));

        $userEmail      =   'benjamin.castillo03@gmail.com';
        $subject        =   'TEST';

        $config['protocol']         =   'smtp';                             # Puedes usar 'smtp' o 'sendmail', dependiendo de tus preferencias.
        #$config['smtp_host']       =   'smtp.office365.com';               # Por ejemplo: smtp.gmail.com si usas Gmail.
        $config['smtp_host']        =   'smtp.gmail.com'; 
        #$config['smtp_port']       =   '587';                              # Por ejemplo: 587 para TLS o 465 para SSL si usas Gmail.
        $config['smtp_port']        =   '465';                              # Por ejemplo: 587 para TLS o 465 para SSL si usas Gmail.
        #$config['smtp_user']       =   'noresponder@araucanianorte.cl';    # Tu direcion de correo electeronico
        #$config['smtp_pass']       =   'Esissan.0023';                     # Tu pass de correo electronico
        $config['smtp_user']        =   'clinicalibrechile@gmail.com';      # Tu direcion de correo electeronico
        $config['smtp_pass']        =   'clinica.libre2023';                # Tu pass de correo electronico

        $config['smtp_crypto']      =   'tls';                              # Puedes usar 'tls' o 'ssl' segÃºn el puerto que estÃ©s utilizando.
        $config['mailtype']         =   'html';                             # Puedes usar 'html' o 'text', dependiendo del contenido del correo.
        $config['starttls']         =   true;

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('noresponder@araucanianorte.cl', 'e-SISSAN');
        $this->email->to($userEmail);                                       # replace it with receiver mail id                
        $this->email->subject($subject);                                    # replace it with relevant subject   

        $fechaAhora                 =   $this->sumarMinutosFecha(date('Y-m-d H:i:s'), 5);
        $datetime                   =   strtotime($fechaAhora);
        $this->email->message("Scorpions - Still Loving You");

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