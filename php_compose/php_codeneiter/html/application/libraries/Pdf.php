<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'/third_party/mpdf/mpdf.php';

class Pdf extends \Mpdf\Mpdf {
    
    public function __construct($params = [])
    {
        parent::__construct($params);
    }
}
