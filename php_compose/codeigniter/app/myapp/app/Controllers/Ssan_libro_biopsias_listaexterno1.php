<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel; 

class ssan_libro_biopsias_listaexterno1 extends Controller {

   var $empresa;

   function __construct() {
       parent::__construct();
   }

   public function index() {
       echo view("ssan_libro_biopsias_listaexterno1/ssan_libro_biopsias_listaexterno1_view");
   }

}
