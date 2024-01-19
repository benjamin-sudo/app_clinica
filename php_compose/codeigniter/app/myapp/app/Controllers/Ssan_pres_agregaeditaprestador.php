<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel; 

class ssan_pres_agregaeditaprestador extends Controller {

   var $empresa;

   function __construct() {
       parent::__construct();
   }

   public function index() {
       echo view("ssan_pres_agregaeditaprestador/ssan_pres_agregaeditaprestador_view");
   }

}
