<?php
 namespace App\Models;

 use CodeIgniter\Model;

 class ssan_libro_salaproceso_model extends Model {

   var $own    = "ADMIN";
   var $ownGu  = "GUADMIN";

   public function __construct() {

       parent::__construct();

   }

}
