<?php
 namespace App\Models;

 use CodeIgniter\Model;

 class tomademuestrausuarios_model extends Model {

   var $own    = "ADMIN";
   var $ownGu  = "GUADMIN";

   public function __construct() {

       parent::__construct();

   }

}
