<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recuperar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        #$this->load->model('Usuario_model');
        $this->load->helper('url');
        $this->load->library('email');
    }

    public function enviar_enlace_recuperacion() {
        $email = $this->input->post('email');
        $this->session->set_flashdata('msg', 'Correo no registrado.');
        redirect('/');
    }

    public function resetear($token) {
        // Aquí mostrar el formulario de nueva contraseña, validando el token
    }

    public function actualizar_contrasena() {
        // Aquí recibes el token + nueva contraseña y actualizas en BD
    }
}
