<?php

class Ssan_bdu_creareditarpaciente extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        #$this->load->model("ssan_bdu_creareditarpaciente_model");
    }

    public function index(){
        $this->output->set_template('blank');
        $data = [
            'USERNAME'  =>  $this->session->userdata('USERNAME'),
            'COD_ESTAB' =>  $this->session->userdata('COD_ESTAB'),
        ];
        $this->load->css("assets/ssan_bdu_creareditarpaciente/css/styles.css");
        $this->load->js("assets/ssan_bdu_creareditarpaciente/js/javascript.js");
        $this->load->view('ssan_bdu_creareditarpaciente/Ssan_bdu_creareditarpaciente_view',$data);
    }

    public function buscarPac(){
        if (!$this->input->is_ajax_request()) {  show_404(); }
	    $codEmpresa         =    $this->session->userdata("COD_ESTAB")==''?$this->input->post("COD_ESTAB"):$this->session->userdata("COD_ESTAB");
        $html               =    '';
        $NUM_COUNT          =    '';
        $isNal              =    '';
        $data               =    '';
        $rut                =    $this->input->post("rut");
        $numFichae          =    $this->input->post("numFichae");
        $nombre             =    $this->input->post("nombre");
        $apellidoP          =    $this->input->post("apellidoP");
        $apellidoM          =    $this->input->post("apellidoM");
        $tipoPac            =    $this->input->post("tipoPac");
        $LIM_INI            =    $this->input->post("LIM_INI");
        $OP                 =    $this->input->post("OP");
        $templete           =    $this->input->post("templete");

        if ($tipoPac        == 0) {
            $isnal          =    '1';
            $identifier     =    $rut;
            $pasaporte      =    '';
            $tipoEx         =    '';
        } else {
            $isnal          =    '0';
            $identifier     =    $rut;
            $pasaporte      =    $this->input->post("pasaporte");
            $tipoEx         =    $this->input->post("tipoEx");
        }

        if (is_null($codEmpresa)) {
            //$aDatos[]	    =	array('id_html'=>'respuesta','opcion'=>'console','contenido'=>"-------------------------------------");
            //$aDatos[]	    =	array('id_html'=>'respuesta','opcion'=>'console','contenido'=>$codEmpresa);
            //$aDatos[]	    =	array('id_html'=>'respuesta','opcion'=>'console','contenido'=>"-------------------------------------");
            $script        =    '<script type="text/javascript">jAlert(" - SU SESI&Oacute;N A EXPIRADO", "Listado de Errores - e-EISSAN", function(){';
            if ($this->session->userdata("SISTYPO") != 1) {
                //$script	    .=		'window.location = "../../inicio"';
            }
            $script        .=    '});</script>';
            $aDatos[]        =    array('id_html' => 'respuesta', 'opcion' => 'append', 'contenido' => $script);
            $this->output->set_output(json_encode($aDatos));
            return false;
        }

        //$aDatos[]         =	array(""=>"", "opcion" => "console", "contenido"  => "TYPO -> ".$this->session->userdata("SISTYPO"));
        $aDataPaciente      =    $this->ssan_bdu_creareditarpaciente_model->getPacientes($numFichae, $identifier, $codEmpresa, $isnal, $pasaporte, $tipoEx, strtoupper($nombre), strtoupper($apellidoP), strtoupper($apellidoM), $LIM_INI, $templete);
        $aDatos[]           =    array('id_html' => 'result', 'opcion' => 'hide', 'contenido' => '');
        $aDatos[]           =    array('id_html' => 'resultados', 'opcion' => 'html', 'contenido' => '');
        if (count($aDataPaciente) > 0) {
            foreach ($aDataPaciente as $i => $row) {
                $aDatos[]       = array('id_html' => 'resultados', 'opcion' => 'console', 'contenido' => $aDataPaciente);
                /*
                $p          = 0;
                $nFicha     = 'N/A';
                if(!empty($row['FLOCAL'])) {  $nFicha = $row['FLOCAL'];  }
                $pasport    = ' - ';
                if(!empty($row['NUM_IDENTIFICACION'])) {  $pasport = $row['NUM_IDENTIFICACION'];  $p++;  }
                if($p == 0) {  $extranjero = 'N/A';   } else {    $extranjero = $pasport;   }
                $rut        = 'N/A';
                if(!empty($row['RUTPAC'])) {  $rut = $row['RUTPAC'] . '-' . strtoupper($row['DIGVERPAC']);  }
                
                $row['ID_EXTRANJERO'];
                $row['IND_TIPOIDENTIFICA'];
                $row['IND_EXTRANJERO'];
                $row['IND_EXTRANJERO'];
                $row['NUM_IDENTIFICACION'];
                $row['FEC_VENCEPASPORT'];     
                */
                $IND_EXTRANJERO        =    $row['IND_EXTRANJERO'];

                if (($row['COD_PAIS'] == 'CL') || ($row['IND_EXTRANJERO'] == '0')) {
                    $EXTRAN = '';
                } else if ($row['IND_EXTRANJERO'] == '1') {
                    $EXTRAN = $row['NUM_IDENTIFICACION'] . " (" . $row['FEC_VENCEPASPORT'] . ")";
                } else {
                    $EXTRAN = '';
                }

                if ($row['NUM_NFICHA'] == '') {
                    $numFichaL           =  '<span class="label label-danger">N/A</span>';
                } else {
                    $numFichaL           =  $row['NUM_NFICHA'];
                }

                $html = '<tr>
                            <td>' . $row['RNUM'] . '</td>
                            <td>' . $row['COD_RUTPAC'] . '-' . $row['COD_DIGVER'] . '</td>
                            <td>' . strtoupper($EXTRAN) . '</td>
                            <td>' . $numFichaL . '</td>   
                            <td>' . strtoupper($row['NOM_NOMBRE']) . '</td>
                            <td>' . strtoupper($row['NOM_APEPAT']) . '</td>
                            <td>' . strtoupper($row['NOM_APEMAT']) . '</td>
                            <td>' . $row['FEC_NACIMI'] . '</td>
                            <td>';
                if (($row['COD_PAIS'] == 'CL') || ($row['IND_EXTRANJERO'] == '0')) {
                    $html .= '<img class="shadow" src="assets/ssan_bdu_creareditarpaciente/img/bchile.jpg">';
                    $isNal  = 1;
                } else if ($row['IND_EXTRANJERO'] == '1') {
                    $html .= '<img class="shadow" src="assets/ssan_bdu_creareditarpaciente/img/bInter.jpg">';
                    $isNal  = 0;
                } else {
                    $html .= '';
                }
                $html .= '</td>';

                $html .= '<td align="center">';
                if ($row['FALLECIDO'] == '') {
                    if ($templete == '1') { //todo el power
                        $html .= '
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:FormModal(' . $isNal . ',' . $row['NUM_FICHAE'] . ')"> <i class="fa fa-id-card-o" aria-hidden="true"></i>&nbsp;EDITAR</a></li>';
                        if ($IND_EXTRANJERO == '1') {
                            $html .= '<li><a href="javascript:CertificadoExtranjero(' . $row['NUM_FICHAE'] . ')"><i class="fa fa-barcode" aria-hidden="true"></i>&nbsp;C.EXTRANJERO</a></li>';
                            if($row['COD_RUTPAC'] == ''){
                                $html .= '<li><a href="javascript:editor_extranjero(' . $row['NUM_FICHAE'] . ')"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;RUN DEFINITIVO</a></li>';
                            }
                           
                            
                        }
                        $html .= '</ul></div>';
                    } else if ($templete == '2') { //Edita ficha local
                        $html .= '<a class="btn btn-info" href="javascript:FormModal(' . $isNal . ',' . $row['NUM_FICHAE'] . ')"><i class="fa fa-cog" aria-hidden="true"></i></a>';
                    }

                    //Nuevo 13.11.2018
                    else if ($templete == '3') {
                        $html .= '<a 
                                            class="btn btn-info" 
                                            href="javascript:FormModal2(' . $isNal . ',' . $row['NUM_FICHAE'] . ',\'' . $row['COD_RUTPAC'] . '\',\'' . $row['NUM_IDENTIFICACION'] . '\')"
                                            >
                                            <i class="fa fa-cog" aria-hidden="true"></i>
                                        </a>';
                    }


                    //NUEVO PARA EL GESTION DE CITACION 06-08-2019 // NO SUBIDO

                    else if ($templete == '5') {
                        $JSON2                    =   htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                        if (is_numeric($numFichaL)) {
                            $html .= '
					    <button 
						class				=   "btn btn-success btn-xs btn-fill" 
						type				=   "button"
						id				=   "DATA_' . $row['NUM_FICHAE'] . '"
						data-ROW			=   "' . $JSON2 . '"
						onclick				=   "busqueda_comp(' . $row['NUM_FICHAE'] . ')"
						>
						<i class="fa fa-plus-square-o" aria-hidden="true"></i>
					    </button>
					    ';
                        } else {
                            $html  .= ' <button 
						class				=   "btn btn-DEFAULT btn-xs btn-fill" 
						type				=   "button"
						id				=   "DATA_' . $row['NUM_FICHAE'] . '"
						data-ROW			=   "' . $JSON2 . '"
						onclick				=   "SINFICHALOCAL(' . $row['NUM_FICHAE'] . ');"
						>
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
					    </button>';
                        }
                    }
                } else {
                    $html .= '<span class="fa-stack fa-lg hint hint--left" data-hint="PACIENTE FALLECIDO"><i class="fa fa-user-o fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
                }

                $html .= '</td>
                    </tr>
                    ';
                //$html.='<li role="presentation" class="divider"></li> <li><a href="javascript:solover('.$row['NUM_FICHAE'].','.$isNal.')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;VER</a></li>';
                //$html.='<li><a href="javascript:Add_Agenda('.$row['NUM_FICHAE'].')"> <i class="fa fa-id-card-o" aria-hidden="true"></i>&nbsp;SELECIONE</a></li>';
                $aDatos[]       = array('id_html' => 'resultados', 'opcion' => 'append', 'contenido' => $html);
                if ($OP == 0 and $LIM_INI == '1') {
                    $NUM_COUNT      =   (int)$row['RESULT_COUNT'];
                    $PageN          =   ceil($NUM_COUNT / 10);
                    
                    
                    $aDatos[]       = array('id_html' => 'nresultados', 'opcion' => 'html', 'contenido' => $NUM_COUNT);
                    $data           .= '<script>$("#new_paginacion").bootpag({total:' . round($PageN) . ',page:1,maxVisible: 10});</script>';
                    $data           .= '<script>$("#new_paginacion").show("fast");</script>';
                    $aDatos[]       = array("id_html" => "respuesta", "opcion" => "append", "contenido"  => $data);
                }
            }
        } else {

            $aDatos[]   = array('id_html' => 'nresultados', 'opcion' => 'html', 'contenido' => '');
            $aDatos[]   = array('id_html' => 'nresultados', 'opcion' => 'html', 'contenido' => '0');
            $aDatos[]   = array('id_html' => 'new_paginacion', 'opcion' => 'hide', 'contenido' => '');
            if ($templete == '1') {
                $html .=    '<tr id="mensajeSinresultados_1">
                                <td colspan="12" style="text-align:center">   <b><i> NO SE HAN ENCONTRADO RESULTADOS </i></b>
                                    <br>
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <b>AGREGAR/EDITAR PACIENTE</b>
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                          <li><a href="javascript:FormModal(1,null)"> <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;PACIENTE NACIONAL</a></li>
                                          <li><a href="javascript:FormModal(0,null)"> <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;PACIENTE EXTRANJERO</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>';
            } else if ($templete == '2') {
                $html .= '<tr id="mensajeSinresultados_1"><td colspan="12" style="text-align:center"><b><i> NO SE HAN ENCONTRADO RESULTADOS.</i></b></td></tr>';
            }
            $aDatos[]   = array('id_html' => 'resultados', 'opcion' => 'append', 'contenido' => $html);
        }
        //**********************************************************************
        $aDatos[]   = array('id_html' => 'result',    'opcion' => 'show',   'contenido' => '');
        $this->output->set_output(json_encode($aDatos));
    }


    

}
