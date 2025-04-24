<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel; 

class ssan_bdu_creareditarpaciente extends Controller {
    var $empresa;
    function __construct() {
        parent::__construct();
    }
    public function index() {
        echo view("ssan_bdu_creareditarpaciente/ssan_bdu_creareditarpaciente_view");
    }
}
