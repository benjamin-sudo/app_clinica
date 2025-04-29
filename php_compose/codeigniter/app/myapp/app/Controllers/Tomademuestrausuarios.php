<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel; 

class tomademuestrausuarios extends Controller {

    var $empresa;

    function __construct() {
        parent::__construct();
    }

    public function index() {
        echo view("tomademuestrausuarios/tomademuestrausuarios_view");
    }
}