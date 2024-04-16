<?php

class Ssan_hdial_hojatratamiento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_hdial_hojatratamiento_model");
    }
    
    public function index() {
        $this->output->set_template('blank');
        $data = [];
        #$this->load->js("assets/themes/wsocket_io/2_3_0/socket.io.dev.js");
        #$this->load->js("assets/ssan_crearinterconsulta/js/funciones.js");
        $this->load->css("assets/Ssan_hdial_hojatratamiento/css/styles.css");
        $this->load->js("assets/ssan_hdial_hojatratamiento/js/javascript_hd.js");
        $this->load->js("assets/Ssan_hdial_hojatratamiento/js/javascript.js");
        $this->load->view('Ssan_hdial_hojatratamiento/Ssan_hdial_hojatratamiento_view',$data);
    }


    public function cargaPacientesHD() {
        if(!$this->input->is_ajax_request()) { show_404(); }
        $empresa                    =   $this->session->userdata("COD_ESTAB");
        $HTML                       =   '';
        $estados                    =   '1';
        $numFichae                  =   '';
        $rutPac                     =   '';
        $num_Maquina                =   '1';
        $fecha_desde                =   $this->input->post('fecha_busqueda');
        $fecha_hasta                =   $this->input->post('fecha_busqueda');
        //**********************************************************************
        $aMaquinas                  =   $this->ssan_hdial_asignacionpaciente_model->ModelbusquedaMaquinas($empresa);
        if(count($aMaquinas)){
            foreach ($aMaquinas as $row){
                $aData              =   $this->ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDialxMaquina($empresa,$estados,$numFichae,$rutPac,$row["ID"],$fecha_desde,$fecha_hasta);
                $TABLA[]            =   array("id_html"=>"maquina_1","opcion" => "console","contenido"=> $aData);
                /* foreach ($aData as $pac){  $TABLA[]= array("id_html"=>"maquina_1","opcion" => "console","contenido"=> $pac["NOMPAC"]); } */
                $TABLA[]            =   array("id_html"=>"maquina_1","opcion" => "console","contenido"=> $row["ID"]);
            }
        } else {
            
        }
        
        /*
        $TABLA[]                    = array("id_html"=>"maquina_1","opcion" => "console","contenido"=> $aData); 
        if (count($aData)>0){
            foreach ($aData as $row){
                $HTML='<tr>
                            <td>'.$row['HRS_INICIO'].'</td>
                            <td class="td-name">Things that all designers do</td>
                            <td>Most beautiful agenda for the office.</td>
                            <td class="td-number">30/08/2015</td>
                            <td class="td-number">1,225</td>
                            <td></td>
                        </tr>';
                $TABLA[]                    = array("id_html"=>"maquina_1", "opcion" => "append","contenido"=> $HTML); 
            }
        }  else {
                $HTML = '<tr><td colespan="6"> SIN PACIENTES</td></tr>';
                $TABLA[]                    = array("id_html"=>"maquina_1", "opcion" => "append","contenido"=> $HTML); 
        }
        */
        $this->output->set_output(json_encode($TABLA));
    }
    
    public function autocompletar() {
        //llamada info dejamos pasar
        $html = '';
        if ($this->input->is_ajax_request() && $this->input->post('value')) {
            $abuscar        = strtoupper($this->security->xss_clean($this->input->post("value")));
            $sexo           = $this->input->post('value');
            $sqlfrecuencia  = 'N';
            $search         = $this->ssan_crearinterconsulta_model->buscaDiagnostico($sexo, $sqlfrecuencia, $abuscar);
            //si search es distinto de false significa que hay resultados
            //y los mostramos con un loop foreach
            $html .= '<a class="autocomplete-jquery-item autocomplete-jquery-mark" onclick="$(\'.autocomplete-jquery-results\').hide()" data-id="0"><b>CODIGO - DESCRIPCION DIAGNOSTICA ( CERRAR VENTANA  [X])</b></a>';
            if ($search) {
                $i = 0;
                foreach ($search as $fila){
                    $i++;
                    if($fila['IND_GES'] == '0'){
                        $html .= '<a class="autocomplete-jquery-item" onclick="onClickDiagnostico(\'' . $fila['COD_DIAGNO_CIE'] . '\',\'' . $fila['DESCRIPCION'] . '\')" data-id="' . $i . '">' . $fila['COD_DIAGNO_CIE'] . ' - ' . $fila['DESCRIPCION'] . '</a>';
                    }else if($fila['IND_GES'] == '1'){
                        $html .= '<a class="autocomplete-jquery-item" onclick="habGes('.$fila['COD'].'); onClickDiagnostico(\'' . $fila['COD_DIAGNO_CIE'] . '\',\'' . $fila['DESCRIPCION'] . '\');" data-id="' . $i . ')">' . $fila['COD_DIAGNO_CIE'] . ' - ' . $fila['DESCRIPCION'] . ' <img style="width: 30px;padding-bottom: 3px;" src="assets/ssan_seleccionarinterconsulta/img/ges.png"></a>';
                    }
                }
            }
        }
        $this->output->set_output($html);
    }








}
