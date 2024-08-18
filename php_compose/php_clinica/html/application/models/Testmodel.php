<?php
class Testmodel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function test() {
        return "Test success!";
    }
}
