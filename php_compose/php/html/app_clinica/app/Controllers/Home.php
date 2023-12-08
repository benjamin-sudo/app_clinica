<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ModelLogin;

class Home extends BaseController {

    public function __construct() {
        $this->ModelLogin = new ModelLogin();
    }

    public function index(): string {
        $return     =   [];
        #$return    =   $this->ModelLogin->test();
        #$return    =   $this->ModelLogin->isDbConnected();;
        return view('login',['return'=>$return]);
    }

}