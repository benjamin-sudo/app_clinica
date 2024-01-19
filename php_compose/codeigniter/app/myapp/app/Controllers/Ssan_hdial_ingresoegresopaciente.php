<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel; 

class ssan_hdial_ingresoegresopaciente extends Controller {

   var $empresa;

   function __construct() {
       parent::__construct();
   }

   public function index() {
       echo view("ssan_hdial_ingresoegresopaciente/ssan_hdial_ingresoegresopaciente_view");
   }

}
