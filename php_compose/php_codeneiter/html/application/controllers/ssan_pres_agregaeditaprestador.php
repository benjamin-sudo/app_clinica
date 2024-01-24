<?php

class Ssan_pres_agregaeditaprestador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_pres_agregaeditaprestador_model");
    }

    public function index(){
        $this->output->set_template('blank');
        $data       =   [];
        $data       =   $this->Ssan_pres_agregaeditaprestador_model->cargatipo();
        $this->load->css("assets/ssan_pres_agregaeditaprestador/css/styles.css");
        $this->load->js("assets/ssan_pres_agregaeditaprestador/js/javascript.js");
        $this->load->view('ssan_pres_agregaeditaprestador/ssan_pres_agregaeditaprestador_view',$data);
    }

    //PERMITE BUSCAR PRESTADOR.
    public function buscar(){
        $status_busqueda    =   true;
        $rut                =   $this->input->post('rutPac');
        $rutm               =   explode(".", $rut);
        $rutUs              =   $rutm[0] . '' . $rutm[1] . '' . $rutm[2];
        $rutsin             =   explode("-", $rutUs);
        $rutfin             =   $rutsin[0];
        $arr                =   $this->Ssan_pres_agregaeditaprestador_model->buscar($rutfin);
        if(count($arr['prestador'])>0)    {

            $retor          =   $arr['prestador'];
            /*
            $html           =   '<script>setTimeout(function(){ CARGAPROF("' . $retor[0]['COD_TPROFE'] . '");},200)</script>';
            $html          .=   '<script>
                                    $("#nombres").val("' . $retor[0]['NOM_NOMBRE'] . '");
                                    $("#appat").val("' . $retor[0]['NOM_APEPAT'] . '");
                                    $("#apmat").val("' . $retor[0]['NOM_APEMAT'] . '");
                                    $("#email").val("' . $retor[0]['EMAILMED'] . '");
                                    $("#telefono").val("' . $retor[0]['NUM_TELEFOMED'] . '");
                                    $("#tprof").val("' . $retor[0]['IND_TIPOATENCION'] . '");' . 'setTimeout(function(){
                                    $("#prof").val("' . $retor[0]['COD_TPROFE'] . '");},500);
                                </script>';
            */

        } else {
            $status_busqueda    =   false;
            $html               =   "<script></script>";
        }
       
        $this->output->set_output(json_encode([
            'html'      =>  $html,
            'status'    =>  $status_busqueda,
            'arr'       =>  $arr
        ]));
    }


    //CARGA LA EL TIPO DE PROFESION
    public function cargatipo() {
        $var = "";   
        $retor = $this->Ssan_pres_agregaeditaprestador_model->cargatipo();
        if ($retor) {
            $var .= '<span style="color: #FF9800;">* </span><label class="control-label">TIPO PROFESIONAL</label>';
            $var .= '<select class="form-control" name="tprof" id="tprof" onchange="CARGAPROF();" required>';
            $var .= '<option>SELECCIONE EL TIPO DE PROFESIONAL</option>';
            foreach ($retor as $val) {
                $var .= '<option value="' . $val['IND_TIPOATENCION'] . '"> ' . $val['DES_TIPOATENCION'] . '</option>';
            }
            $var .= "</select>";
        }
        return $var;
    }

    //CARGA LA PROFESION DEPENDIENDO DEL TIPO DE PROFESIONAL
    public function cargaprof(){
        if (!$this->input->is_ajax_request()) {  show_404();  }
        $id             =   $this->input->post('tprof');
        $arr_return     =   $this->Ssan_pres_agregaeditaprestador_model->cargaprof($id);
        $this->output->set_output(json_encode(['arr_return'=>$arr_return]));
    }
    
    //consulta si el profesional esta registrado en la tabla profxestab
    public function consultaprofxestab(){
        if (!$this->input->is_ajax_request()) {  show_404();  }
        $var        =   "";
        $rut        =   $this->input->post('rutPac');
        $codemp     =   $this->input->post('codemp');
        $rutm       =   explode(".", $rut);
        $rutUs      =   $rutm[0] . '' . $rutm[1] . '' . $rutm[2];
        $rutsin     =   explode("-", $rutUs);
        $rutfin     =   $rutsin[0];
        $retor      =   $this->Ssan_pres_agregaeditaprestador_model->consultaprofxestab($rutfin, $codemp);
        if ($retor) {
        } else {
            $var = '<div class="alert alert-warning">';
            $var .= '<button type="button" aria-hidden="true" class="close">×</button>';
            $var .= '<span><b> Alerta - </b> El profesional no se encuentra registrado en el establecimiento, favor grabar al profesional.</span></div>';
        }
        $this->output->set_output($var);
    }

    public function PrestadorController(){
        if (!$this->input->is_ajax_request()) {  show_404();  }
        $rut         =   $this->input->post('rut');
        //$rutm      =   explode(".", $rut);
        //$rutUs     =   $rutm[0] . '' . $rutm[1] . '' . $rutm[2];
        //$rutsin    =   explode("-", $rutUs);
        $rutfin      =   $this->input->post('v_run');
        $digrut      =   $this->input->post('v_dv');
        
        $nombres     =   $this->input->post('nombres');
        $appat       =   $this->input->post('appat');
        $apmat       =   $this->input->post('apmat');
        $tprof       =   $this->input->post('tprof');
        $prof        =   $this->input->post('prof');
        $email       =   $this->input->post('email');
        $telefono    =   $this->input->post('telefono');
        $clave       =   $this->input->post("clave");
        $iniciales   =   substr($nombres, 0, 1);
        $iniciales  .=   substr($appat, 0, 1);
        $iniciales  .=   substr($apmat, 0, 1);
        $codemp      =   $this->input->post('codemp');
        $valida      =   true;
        /*
        if (empty($token)) {
            $valida = $this->Ssan_pres_agregaeditaprestador_model->validaClave($clave);
        } else {
            $valida             = $this->Ssan_pres_agregaeditaprestador_model->validaClaveTypo($clave);
        }
        */
        if ($valida) {
            $rutClave           =   $valida[0]['USERNAME'];
            $rutmClave          =   explode("-", $rutClave);
            $rutUsClave         =   $rutmClave[0];
            //INSERTO
            $inicial            =   $iniciales;
            $consultainicial    =   $this->Ssan_pres_agregaeditaprestador_model->consultaIniciales(strtoupper($iniciales));
            if ($consultainicial){
                $numero         =   $consultainicial[0]['NUMERO'];
                if ($numero == 0) {
                    $inicial    =   $iniciales;
                } elseif ($numero > 9) {
                    $inicial    =   substr($iniciales, 0, -1);
                    $inicial    .=  $numero + 1;
                } else {
                    $inicial    =   $iniciales;
                    $inicial    .=  $numero + 1;
                }
            }

            $ingresoPrestador   =   $this->Ssan_pres_agregaeditaprestador_model->guardarPrestador($rutfin, $digrut, $nombres, $appat, $apmat, $tprof, $prof, $email, $telefono, $inicial, $rutUsClave, $codemp);
            if ($ingresoPrestador){
                //$html = '<script>showNotification("bottom", "right", "Prestador ingresado con exito.", 2, "fa fa-check");</script>';
                $html   =   '<script>swal("CONFIRMACIÓN","PROCESO REALIZADO CON EXITO", "success");</script>';
                $html   .=  '<script>limpiar();</script>';
                $html   .=  '<script>$("#respuesta1").hide();</script>';
            } else {
                $html   =   '<script>swal("Error","Error al Grabar", "error");</script>';
            }

            #$this->output->set_output($html);
            #$this->output->set_output(json_encode(['html'=>$html]));
        } else {
            $html = '<script>showNotification("top", "right", "Error - Firma simple incorrecta.", 4, "fa fa-times");</script>';
            #$this->output->set_output($html);
            #$this->output->set_output(json_encode(['html'=>$html]));
        }
        
        $this->output->set_output(json_encode([
            'status' => true
        ]));
    }


    public function buscaFuncSuper() {
        $this->load->library('api_minsal');
        $rut        =   $this->input->post('rutProf');
        $rutm       =   explode(".", $rut);
        $rutUs      =   $rutm[0] . '' . $rutm[1] . '' . $rutm[2];
        $rutsin     =   explode("-", $rutUs);
        $return     =   $this->api_minsal->getPrestSuper($rutsin[0]);
        $html       =   '';
        if ($return['status']) {
            $data = $return['data'];
            $html .= '<table class="table table-striped">';
            $html .= '<tr>';
            $html .= '<td>Nº Registro<td><td>' . $data->nro_registro . '<td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Nombre<td><td>' . $data->nombres . ' ' . $data->apellido_paterno . ' ' . $data->apellido_materno . '<td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Fecha Nacimiento<td><td>' . $data->fecha_nacimiento . '<td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Fecha Registro<td><td>' . $data->fecha_registro . '<td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Nacionalidad<td><td>' . $data->nacionalidad . '<td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Profesión<td><td>' . $data->codigo_busqueda . '<td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Universidad<td><td>' . $data->universidad . '<td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Fecha Carga<td><td>' . $data->fecha_carga . '<td>';
            $html .= '</tr>';
            $html .= '</table>';

            $html .= "<script>$('#modalSuper').modal('show');</script>";
        } else {
            $msj = $return['data'];
            $html .= '<script>swal("Aviso", "' . $msj . '", "info");</script>';
        }
        $html .= "<script>$('#loadFade').modal('hide');</script>";
        $this->output->set_output($html);
    }


}

?>
