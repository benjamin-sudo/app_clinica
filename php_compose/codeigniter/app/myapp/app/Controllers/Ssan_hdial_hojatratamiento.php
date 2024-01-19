<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel; 

class ssan_hdial_hojatratamiento extends Controller {

   var $empresa;

   function __construct() {
       parent::__construct();
   }

   public function index() {
       echo view("ssan_hdial_hojatratamiento/ssan_hdial_hojatratamiento_view");
   }

}
