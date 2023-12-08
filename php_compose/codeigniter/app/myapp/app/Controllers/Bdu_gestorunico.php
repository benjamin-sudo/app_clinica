<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel; 

class bdu_gestorunico extends Controller {

   var $empresa;

   function __construct() {
       parent::__construct();
   }

   public function index() {
       echo view("bdu_gestorunico/bdu_gestorunico_view");
   }

}
