<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'/third_party/mpdf/mpdf.php'; // Asegúrate de que esta ruta sea correcta

class Pdf {

    public $param;
    public $pdf;

    public function __construct($params = array())
    {
        $this->param = $params;
        
        if ($this->param == null) {
            $this->param = '"en-GB-x","A4","","",10,10,10,10,6,3'; // Parámetros por defecto
        }
        $this->pdf = new mPDF($this->param);
    }
}
