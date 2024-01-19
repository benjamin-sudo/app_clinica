<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel; 

class ssan_libro_biopsias_usuarioext extends Controller {

   var $empresa;

   function __construct() {
       parent::__construct();
   }

   public function index() {
       echo view("ssan_libro_biopsias_usuarioext/ssan_libro_biopsias_usuarioext_view");
   }

}
