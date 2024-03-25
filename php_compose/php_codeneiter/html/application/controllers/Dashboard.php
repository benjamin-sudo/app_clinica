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
    public function solicitudNuevaFirma() {
        // Verificar si la solicitud es AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
    
        $status = true; // Estado inicial de la operación
        $html = ''; // Mensaje a devolver
    
        // Recuperar datos enviados por POST
        $firma = $this->input->post('firma');
        $username = strtoupper($this->input->post('username')); // Convertir a mayúsculas
        $userEmail = 'benjamin.castillo03@gmail.com'; // Email del destinatario
        $subject = 'TEST'; // Asunto del correo
    
        // Configuración del correo electrónico
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            #'smtp_port' => 465,
            'smtp_port' => 587,
            'smtp_user' => 'clinicalibrechile@gmail.com',
            'smtp_pass' => 'hdmbkfrxxrleunqu',
            #'smtp_crypto' => 'ssl', // Cambiado a 'ssl' para el puerto 465
            'smtp_crypto' => 'tls', // Cambiado a 'ssl' para el puerto 465
            'mailtype' => 'html',
            'starttls' => true,
            'newline' => "\r\n",
        ];
    
        // Cargar la librería de email con la configuración especificada
        $this->load->library('email', $config);
    
        // Configurar detalles del correo
        $this->email->from('clinicalibrechile@gmail.com', 'e-SISSAN');
        $this->email->to($userEmail);
        $this->email->subject($subject);
        $this->email->message("Scorpions - Still Loving You");
    
        // Intentar enviar el correo y establecer el estado y mensaje basado en el resultado
        if ($this->email->send()) {
            $html = 'Correo enviado con éxito.';
        } else {
            $status = false;
            $html = 'Error al enviar el correo. ' . $this->email->print_debugger(['headers']);
        }
    
        // Devolver respuesta en formato JSON
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