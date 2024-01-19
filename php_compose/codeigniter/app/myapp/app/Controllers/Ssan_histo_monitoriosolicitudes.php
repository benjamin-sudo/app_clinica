<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel; 

class ssan_histo_monitoriosolicitudes extends Controller {

   var $empresa;

   function __construct() {
       parent::__construct();
   }

   public function index() {
       echo view("ssan_histo_monitoriosolicitudes/ssan_histo_monitoriosolicitudes_view");
   }

}
