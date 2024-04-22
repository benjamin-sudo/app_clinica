<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class ssan_libro_biopsias_usuarioext_model extends CI_Model {

    var $tableSpace =   "ADMIN";
    var $own        =   "ADMIN";
    var $ownGu      =   "GUADMIN";

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('oracle_conteiner',true);
    }

    public function data_pre_nuevasoliciud_anatomia($DATA){
        $this->db->trans_start();
        $param                      =   array(
                                            array( 
                                                'name'      =>  ':V_COD_EMPRESA',
                                                'value'     =>  $DATA["COD_EMPRESA"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':V_USR_SESSION',
                                                'value'     =>  $DATA["USR_SESSION"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':C_LISTADOSERVICIOS',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':C_LISTADOMEDICOS',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':C_ESPECIALIDADES',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                        );
        $result                             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','GET_INFOPRESOLICITUD',$param);
        $this->db->trans_complete();
        $this->db->trans_status();
        return array(
            'STATUS'                        =>  true,
            'C_LISTADOSERVICIOS'            =>  empty($result[':C_LISTADOSERVICIOS'])?null:$result[':C_LISTADOSERVICIOS'],
            'C_ESPECIALIDADES'              =>  empty($result[':C_ESPECIALIDADES'])?null:$result[':C_ESPECIALIDADES'],
            'C_LISTADOMEDICOS'              =>  empty($result[':C_LISTADOMEDICOS'])?null:$result[':C_LISTADOMEDICOS'],
        );
    }
    

    public function load_info_ap($data_controller){
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_TOKEN',
                                    'value'     =>  $data_controller['token'],
                                    'length'    =>  100,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':C_MAIN_AP',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':P_ANATOMIA_PATOLOGICA_MUESTRAS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':P_AP_MUESTRAS_CITOLOGIA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_CUSTODIA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_TRASPORTE',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_RECEPCION',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_TERMINOINFO',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_TERMINOINFO_CITO',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),

                                array( 
                                    'name'      =>  ':C_TECNICASAPLICADAS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),

                                array( 
                                    'name'      =>  ':C_NOTIFICACANCER',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_INFOPABELLON',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_RCECLINICO',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_LOGS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_INFO_ANATOMIA',$param);
        $this->db->trans_complete();
        return array(
            'html_out'                          =>  '',
            'return_bd'                         =>  $result,
        );
    }
     
    public function carga_lista_rotulos_x_user($data_controller){
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $data_controller["COD_EMPRESA"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #rut del usuario
                                array( 
                                    'name'      =>  ':V_USR_SESSION',
                                    'value'     =>  $data_controller["usr_session"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #no me acuerdo
                                array( 
                                    'name'      =>  ':V_OPCION', 
                                    'value'     =>  $data_controller["ind_opcion"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es la primera vez 
                                array( 
                                    'name'      =>  ':V_IND_FIRST',
                                    'value'     =>  $data_controller["ind_first"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo inicio
                                array( 
                                    'name'      =>  ':VAL_FECHA_INICIO',
                                    'value'     =>  $data_controller["data_inicio"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo final
                                array( 
                                    'name'      =>  ':VAL_FECHA_FINAL',
                                    'value'     =>  $data_controller["data_final"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es de rce - externo - gespab
                                array( 
                                    'name'      =>  ':VAL_IND_ORIGEN_SIS',
                                    'value'     =>  0,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #punto de entrega default 0|-1
                                array( 
                                    'name'      =>  ':VAL_IND_PUNTO_ENT',
                                    'value'     =>  0,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #SI
                                array( 
                                    'name'      =>  ':VAL_TXT_TEMPLATE',
                                    'value'     =>  2,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #array principal
                                array( 
                                    'name'      =>  ':C_RESULT_LISTA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array puntos de entrega
                                array( 
                                    'name'      =>  ':C_DATA_PUNTOS_ENTREGA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array origen del sistema
                                array( 
                                    'name'      =>  ':C_DATA_ORIGEN_SIS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #status
                                array( 
                                    'name'      =>  ':C_RETURN_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        
        #var_dump(print_r($param));
        #lista filtrada por | punto de entrega | origen solicitud
        #llamada desde
        #$result                                =   [];
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_LISTA_AP_USERXROTULO_NEW',$param);
        $this->db->trans_complete();
        return array(
            'html_externo'                      =>  $this->html_externo_rce(array("data_controller"=>$data_controller,"data"=>$result)),
            'return_bd'                         =>  $result,
            'userdata'                          =>  $this->session->userdata,
            'date_inicio'                       =>  $data_controller["data_inicio"],
            'date_final'                        =>  $data_controller["data_final"],
            'ind_opcion'                        =>  $data_controller["ind_opcion"], 
            'ind_template'                      =>  $data_controller["ind_template"]
        );
    }
    
    public function carga_lista_rotulos_x_user_update($data_controller) {
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $data_controller["COD_EMPRESA"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #rut del usuario
                                array( 
                                    'name'      =>  ':V_USR_SESSION',
                                    'value'     =>  $data_controller["usr_session"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #no me acuerdo
                                array( 
                                    'name'      =>  ':V_OPCION', 
                                    'value'     =>  $data_controller["ind_opcion"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es la primera vez 
                                array( 
                                    'name'      =>  ':V_IND_FIRST',
                                    'value'     =>  $data_controller["ind_first"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo inicio
                                array( 
                                    'name'      =>  ':VAL_FECHA_INICIO',
                                    'value'     =>  $data_controller["data_inicio"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo final
                                array( 
                                    'name'      =>  ':VAL_FECHA_FINAL',
                                    'value'     =>  $data_controller["data_final"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es de rce - externo - gespab
                                array( 
                                    'name'      =>  ':VAL_IND_ORIGEN_SIS',
                                    'value'     =>  0,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #punto de entrega default 0|-1
                                array( 
                                    'name'      =>  ':VAL_IND_PUNTO_ENT',
                                    'value'     =>  0,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #SI
                                array( 
                                    'name'      =>  ':VAL_TXT_TEMPLATE',
                                    'value'     =>  2,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #array principal
                                array( 
                                    'name'      =>  ':C_RESULT_LISTA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array puntos de entrega
                                array( 
                                    'name'      =>  ':C_DATA_PUNTOS_ENTREGA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array origen del sistema
                                array( 
                                    'name'      =>  ':C_DATA_ORIGEN_SIS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #status
                                array( 
                                    'name'      =>  ':C_RETURN_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        #var_dump(print_r($param));
        #lista filtrada por | punto de entrega | origen solicitud
        #llamada desde
        #$result                                =   [];
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_LISTA_AP_USERXROTULO',$param);
        $this->db->trans_complete();
        return array(
            'html_externo'                      =>  $this->html_externo_rce(array("data_controller"=>$data_controller,"data"=>$result)),
            'return_bd'                         =>  $result,
            'date_inicio'                       =>  $data_controller["data_inicio"],
            'date_final'                        =>  $data_controller["data_final"],
            'ind_opcion'                        =>  $data_controller["ind_opcion"], 
            'ind_template'                      =>  $data_controller["ind_template"],
            #'param'                            =>  $param,
        );
    }
    
    #update
    public function carga_lista_rce_externo_ap($data_controller) {
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $data_controller["COD_EMPRESA"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #rut del usuario
                                array( 
                                    'name'      =>  ':V_USR_SESSION',
                                    'value'     =>  $data_controller["usr_session"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #no me acuerdo
                                array( 
                                    'name'      =>  ':V_OPCION', 
                                    'value'     =>  $data_controller["ind_opcion"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es la primera vez 
                                array( 
                                    'name'      =>  ':V_IND_FIRST',
                                    'value'     =>  $data_controller["ind_first"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo inicio
                                array( 
                                    'name'      =>  ':VAL_FECHA_INICIO',
                                    'value'     =>  $data_controller["data_inicio"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #tiempo final
                                array( 
                                    'name'      =>  ':VAL_FECHA_FINAL',
                                    'value'     =>  $data_controller["data_final"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #si es de rce - externo - gespab
                                array( 
                                    'name'      =>  ':VAL_IND_ORIGEN_SIS',
                                    'value'     =>  $data_controller["origen_sol"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #punto de entrega default 0|-1
                                array( 
                                    'name'      =>  ':VAL_IND_PUNTO_ENT',
                                    'value'     =>  $data_controller["pto_entrega"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #SI
                                array( 
                                    'name'      =>  ':VAL_TXT_TEMPLATE',
                                    'value'     =>  $data_controller["ind_template"]=='ssan_libro_biopsias_listaexterno1'?1:2,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #array principal
                                array( 
                                    'name'      =>  ':C_RESULT_LISTA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array puntos de entrega
                                array( 
                                    'name'      =>  ':C_DATA_PUNTOS_ENTREGA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #array origen del sistema
                                array( 
                                    'name'      =>  ':C_DATA_ORIGEN_SIS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #status
                                array( 
                                    'name'      =>  ':C_RETURN_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        #lista filtrada por | punto de entrega | origen solicitud
        #llamada desde
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_LISTA_AP_EXTERNO_RCE',$param);
        $this->db->trans_complete();
        return array(
            'html_externo'                      =>  $data_controller["ind_template"] == 'ssan_libro_biopsias_listaexterno1'  ||  $data_controller["ind_template"] == 'ssan_libro_biopsias_listaxusuarios'
                                                        ?   $this->html_externo_rce(array("data_controller"=>$data_controller,"data"=>$result))
                                                        :   $this->LI_RESULTADOS_ANATOMIA($result[":C_RESULT_LISTA"],$data_controller["num_fase"]),
            'return_bd'                         =>  $result,
            'userdata'                          =>  $this->session->userdata,
            'ind_opcion'                        =>  $data_controller["ind_opcion"], 
            'ind_template'                      =>  $data_controller["ind_template"],
            'date_inicio'                       =>  $data_controller["data_inicio"],
            'date_final'                        =>  $data_controller["data_final"],
        );
    }
    
    #llamada de externo 
    public function html_externo_rce($data){
        $html                   =   '';
        $btn_traza_visible      =   $data["data_controller"]["ind_template"] == "ssan_libro_biopsias_listaexterno1"?true:false;
        //var_dump($btn_traza_visible);
        if(count($data["data"][":C_RESULT_LISTA"])>0){
            foreach($data["data"][":C_RESULT_LISTA"] as $i => $row){
                $style_li               =   '';
                $cirujano1              =   '';
                $ARR_ANATOMIA           =   $row['ID_SOLICITUD'];
                $html_tooltip2          =   '';
                if($row['ID_HISTO_ESTADO']!=1){
                    //error
                    $html_tooltip2      =   '<div class="grid_tooltip">
                                                <div class="grid_11">'.$row['TXT_HISTO_ESTADO'].'</div>
                                                <div class="grid_12">'.$row['TXT_NAMEAUDITA'].'</div>
                                                <div class="grid_13">RUT</div>
                                                <div class="grid_14">'.$row['LAST_USR_AUDITA'].'</div>
                                                <div class="grid_15">FECHA/HORA</div>
                                                <div class="grid_16">'.$row['LAST_DATE_AUDITA'].'</div>
                                             </div>';
                }
                $INFORMACION        =   '';
                        if($row['ID_HISTO_ESTADO'] == 1){
                            #('.$row['ID_HISTO_ESTADO'].')
                    $INFORMACION    =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;margin-top: 10px;">';       
                    $INFORMACION    .=   '<button class="btn btn-xs btn-fill cssmain btn-default parpadea"       style="width: 100%;margin:-10px 0px 0px 0px;"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;NUEVA SOLICITUD&nbsp;</button>';
                    $INFORMACION    .=   '</div>';
                } else  if($row['ID_HISTO_ESTADO'] == 2){
                    $INFORMACION    =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;margin-top: 10px;">';
                    $INFORMACION    .=   '<button class="btn btn-xs btn-fill cssmain btn-warning"               style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;" data-toggle="tooltip" data-placement="bottom" title=\''.$html_tooltip2.'\' data-html="true"><i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;CUSTODIA</button>';
                    $color_estado       =   $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado         =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check"              aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION    .=   '<button class="btn btn-xs btn-fill cssmain btn-'.$color_estado.'"     style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;">'.$txt_estado.'</button>';
                    $INFORMACION    .=   '</div>';
                } else  if($row['ID_HISTO_ESTADO'] == 3){
                    $INFORMACION    =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;margin-top: 10px;">';
                    $INFORMACION    .=   '<button class="btn btn-xs btn-fill cssmain btn-info parpadea"         style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;" data-toggle="tooltip" data-placement="bottom" title=\''.$html_tooltip2.'\' data-html="true"><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;EN TRASPORTE</button>';
                    $color_estado       =   $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado         =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check"              aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION    .=   '<button class="btn btn-xs btn-fill cssmain btn-'.$color_estado.'"     style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;">'.$txt_estado.'</button>';
                    $INFORMACION    .=   '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 4){
                    $INFORMACION    =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;margin-top: 10px;">';
                    $INFORMACION    .=   '<button class="btn btn-xs btn-fill cssmain btn-success"               style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;" data-toggle="tooltip" data-placement="bottom" title=\''.$html_tooltip2.'\' data-html="true"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;RECEPCIONADA</button>';
                    $color_estado       =   $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado         =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check"              aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION    .=   '<button class="btn btn-xs btn-fill cssmain btn-'.$color_estado.'"     style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;">'.$txt_estado.'</button>';
                    $INFORMACION    .=   '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 5){
                    $INFORMACION    =   '<button class="btn btn-xs btn-fill cssmain btn-danger"                 style="width: 100%;margin:-10px 0px 0px 0px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;RECHAZADA | '.$row['ID_HISTO_ESTADO'].'</button>';
                } else {
                    $INFORMACION    =   '<button class="btn btn-xs btn-fill cssmain btn-danger"                 style="width: 100%;margin:-10px 0px 0px 0px;"><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;SIN INFORMACI&Oacute;N | '.$row['ID_HISTO_ESTADO'].'</button>';
                }
                
                $disabled           =   '';
                $ID_MAIN_AP         =   $row['ID_SOLICITUD'];
                ################################################
                $btn_trazabilidad   =   '';
                if ($btn_traza_visible) {
                    #13.07.2023
                    $btn_trazabilidad   .=      '
                                        <button 
                                            type                =   "button" 
                                            data-toggle         =   "popover"
                                            data-placement      =   "left"
                                            class               =   "'.$disabled.' btn btn-xs btn-fill btn-danger class_htrazabilidad '.$ID_MAIN_AP.'"
                                            id                  =   "btn_trabilidad_'.$ID_MAIN_AP.'"';
                    $btn_trazabilidad       .=  $ID_MAIN_AP!=''?'onclick    =   "js_htraxabilidad('.$ID_MAIN_AP.')"':'';
                    $btn_trazabilidad       .=      '>
                                        <i class="fa fa-database" aria-hidden="true"></i>
                                    </button>';
                }
                $html               .=  '
                                                <li class="gespab_group list-group-item list-group-item-'.$style_li.'  rotulo_'.$row['ID_ROTULADO'].' li_lista_externo_rce">
                                                    <div class="CSS_GRID_PUNTO_ENTREGA_EXT" 
                                                            id              =   "DATA_'.$row['ID_SOLICITUD'].'"
                                                            data-paciente   =   "'.htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8').'"
                                                        >
                                                        <div class="text-center">'.$row['INICIOHORAMIN'].'</div>
                                                        <div class="cirugia_row text-center">'.$row['FICHAL'].'</div>
                                                        <div class="text-center">'.$row['RUTPACIENTE'].'</div>
                                                        <div class="">'.$row['NOMBRE_COMPLETO'].'</div>
                                                        <div class="">'.$row['TXT_DIAGNOSTICO'].'</div>
                                                        <div class="">'.$row['NOM_PROFE_CORTO'].'</div>';
                                    $html      .=       '<div class="">'.$row['TIPO_DE_BIOPSIA'].'</div>';
                                    $html      .=       '<div class="text-center">'.$INFORMACION.'</div>';


                                    #BOTON SOLICITUD DE ANATOMIA PATOLOGICA
                                    $html       .=      '<div class="text-center">';
                                        $html       .=      $btn_trazabilidad;
                                    $html       .=      '</div>';
                                    #BOTON IMPRIME ETIQUETAS INDIVIDUAL
                                    $html       .=      '<div class="text-center">';
                                        $html       .=      '
                                                            <button 
                                                                type                    =   "button" 
                                                                data-toggle             =   "popover"
                                                                data-placement          =   "left"
                                                                class                   =   "'.$disabled.' btn btn-xs btn-success btn-fill BTN_IMPRIME_ETIQUETA_ANATOMIA_'.$ID_MAIN_AP.'"
                                                                id                      =   "BTN_IMPRIME_ETIQUETA_ANATOMIA_'.$ID_MAIN_AP.'"';
                                        $html       .=  $ID_MAIN_AP!=''?'onclick        =   "popover_etiquetas(this.id,'.$ID_MAIN_AP.')"':'';
                                        $html       .=      '';
                                        $html       .=      '>
                                                                <i class="fa fa-archive" aria-hidden="true"></i>
                                                            </button>
                                                            ';
                                    $html           .=  '</div>';
                                    #BOTON IMPRIME ETIQUETAS
                                    $html       .=      '<div class="text-center">';
                                    #$html       .=      '-';
                                        $html       .=      '<button 
                                                                type                    =   "button" 
                                                                class                   =   "'.$disabled.' btn btn-xs btn-info btn-fill"
                                                                id                      =   "BTN_IMPRIME_ETIQUETA_ANATOMIA"';
                                        $html   .=  $ID_MAIN_AP!=''?'onclick            =   "IMPRIME_ETIQUETA_ANATOMIA('.$ID_MAIN_AP.')"':'';
                                        $html       .=          ' 
                                                                data-toggle             =   "tooltip" 
                                                                data-placement          =   "bottom" 
                                                                title                   =   "Impresi&oacute;n total de etiquetas" 
                                                                data-html               =   "true"
                                                                ';
                                        $html       .=          '>';
                                        $html       .=          '<i class="fa fa-print" aria-hidden="true"></i>
                                                            </button>';
                                    $html       .=      '</div>';
                                    #PDF SOLO ANATOMICO
                                    $html       .=      '<div class="text-center">
                                                            <button 
                                                                type                    =   "button" 
                                                                class                   =   "btn btn-xs btn-warning btn-fill '.$disabled.'" 
                                                                id                      =   "PRE_GET_PDF_ANATOMIA_PRE"';
                                    #if($disabled!='disabled'){
                                    $html       .=             'onclick                 =   "PRE_GET_PDF_ANATOMIA('.$ID_MAIN_AP.')"';
                                    #}
                                    $html       .=          ' 
                                                                data-toggle             =   "tooltip" 
                                                                data-placement          =   "left" 
                                                                title                   =   "PDF anatom&iacute;a patol&oacute;gica" 
                                                                data-html               =   "true"
                                                                ';
                                    
                                    
                                    $html       .=         '><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                        ';
                                    #CHECKBOX ELIMINAR ANATOMIA
                                    $html       .=      '<div class="text-center">';
                                    //solo nueva solicitud y en custoria
                                    if ($row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2){
                                        //if($row['IND_DERIVACION_IC'] == 0){
                                            $html   .=      '<input 
                                                                type        ="checkbox" 
                                                                class       ="form-check-input marcado_custoria_trasporte checkbox_'.$ID_MAIN_AP.'" 
                                                                id          ="CHEK_'.$ID_MAIN_AP.'" 
                                                                style       ="display:block;cursor:pointer;margin-left:16px;margin-bottom: 3px;" 
                                                                onchange    ="js_muestra_indivual('.$ID_MAIN_AP.');" value="'.$ID_MAIN_AP.'">';
                                        //} else {
                                           //$html       .=  'IC';
                                        //}
                                    } else {
                                      

                                    }

                                    #$html       .=      $row['ID_HISTO_ZONA'];
                                    #ID_HISTO_ZONA
                                    #if($row['ID_HISTO_ZONA'] == 8){ }
                                    $html       .=      '</div>';
                                    $html       .='</div>
                                            </li>';
            }
        } else {
            $html               =   '<li class="gespab_group NO_INFORMACION list-group-item">
                                        <div class="GRID_NO_INFOPANEL"> 
                                            <div class="GRID_NO_INFOPANEL1">
                                                <i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b> SIN SOLICITUDES | '.$data["data_controller"]["data_inicio"].'</b>   
                                            </div>
                                        </div>
                                    </li>';
        }
        return array(
            'html_exteno'       =>  $html,
            'html_exteno2'      =>  $html,
        );
    }
    
    public function main_form_anatomiapatologica($DATA){
        $this->db->trans_start();
        $CALL_FASE      =   isset($DATA['CALL_FASE'])?$DATA['CALL_FASE']:-1;
        $ID_SERDEP      =   isset($DATA['ID_SERDEP'])?$DATA['ID_SERDEP']:-1;
        #var_dump($DATA);
        #return false;
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["COD_EMPRESA"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_CALL_FASE',
                                    'value'     =>  $CALL_FASE,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_IND_SISTEMA',
                                    'value'     =>  $DATA["V_IND_SISTEMA"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_IND_GESPAB',
                                    'value'     =>  $DATA["IND_GESPAB"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_ZONA_PAB',
                                    'value'     =>  $DATA["ZONA_PAB"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_IND_ADMISION',
                                    'value'     =>  $DATA["IND_ADMISION"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':PA_ID_PROCARCH',
                                    'value'     =>  $DATA["PA_ID_PROCARCH"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':VAL_ID_SERDEP',
                                    'value'     =>  $ID_SERDEP,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #OUT
                                array( 
                                    'name'      =>  ':C_DATA_ROTULADO',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_DATA_ROTULADO_SUB',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_AUTOCOMPLETE_MUESTRAS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_GETDATAACTIVE',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_RETURN_ESTADOS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #SI TIENE RESULTADO EL EXTERNO
                                array( 
                                    'name'      =>  ':P_ANATOMIA_PATOLOGICA_MAIN',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':P_ANATOMIA_PATOLOGICA_MUESTRAS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':P_AP_MUESTRAS_CITOLOGIA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':P_LOGS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','FORM_START_HISPATOLOGICO',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                                =>  true,
            'ID_SERDEP_MODEL'                       =>  $ID_SERDEP,
            'DATA_ROTULADO'                         =>  empty($result[':C_DATA_ROTULADO'])?null:$result[':C_DATA_ROTULADO'],
            'DATA_AUTOCOMPLETE'                     =>  empty($result[':C_AUTOCOMPLETE_MUESTRAS'])?null:$result[':C_AUTOCOMPLETE_MUESTRAS'],
            'C_RETURN_ESTADOS'                      =>  empty($result[':C_RETURN_ESTADOS'])?null:$result[':C_RETURN_ESTADOS'],
            'P_ANATOMIA_PATOLOGICA_MAIN'            =>	empty($result[':P_ANATOMIA_PATOLOGICA_MAIN'])?null:$result[':P_ANATOMIA_PATOLOGICA_MAIN'],
            'P_ANATOMIA_PATOLOGICA_MUESTRAS'        =>	empty($result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'])?null:$result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'],
            'P_AP_MUESTRAS_CITOLOGIA'               =>	empty($result[':P_AP_MUESTRAS_CITOLOGIA'])?null:$result[':P_AP_MUESTRAS_CITOLOGIA'],
            'C_DATA_ROTULADO_SUB'                   =>  empty($result[':C_DATA_ROTULADO_SUB'])?null:$result[':C_DATA_ROTULADO_SUB'], 
            'P_LOGS'                                =>	empty($result[':P_LOGS'])?null:$result[':P_LOGS'],
            'PA_ID_PROCARCH_MODEL'                  =>  $DATA["PA_ID_PROCARCH"],
        );
    }
    
    public function get_indrotulado_forgespab($DATA){
        return $this->db->query("SELECT 
                                    P.ID_ROTULADO, 
                                    P.COD_EMPRESA, 
                                    P.TXT_OBSERVACION, 
                                    P.IND_ESTADO, 
                                    P.IND_GESPAB, 
                                    P.IND_ZONA_GESPAB
                                FROM 
                                    PABELLON.PB_INFOROTULADO P
                                WHERE
                                        P.COD_EMPRESA IN (".$DATA['COD_EMPRESA'].")
                                    AND 
                                        P.IND_ESTADO IN (1)
                                    AND
                                        P.IND_GESPAB IN (1)
                                    AND
                                        P.IND_ZONA_GESPAB IN ('".$DATA['IND_ZONAGESPAB']."')
                                ")->result_array();
    }
    
    public function get_indrotulado_general($DATA){
        return $this->db->query("
            SELECT 
                P.ID_ROTULADO, 
                P.COD_EMPRESA, 
                P.TXT_OBSERVACION, 
                P.IND_ESTADO, 
                P.IND_GESPAB, 
                P.IND_ZONA_GESPAB
            FROM 
                PABELLON.PB_INFOROTULADO P
            WHERE
                P.COD_EMPRESA IN (".$DATA['COD_EMPRESA'].")
                AND 
                P.IND_ESTADO IN (1)
                AND
                P.IND_GESPAB IN (0)
            ")->result_array();
    }
    
    public function sqlValidaClave_doble($arr_password){
        $clave1	    =   strtolower($arr_password[0]["pass1"]);
        $SQL1       =   "
            SELECT 
                ID_UID,
                USERNAME,
                NAME,
                MIDDLE_NAME,
                LAST_NAME 
            FROM 
               $this->ownGu.FE_USERS 
            WHERE 
            TO_CHAR(TX_INTRANETSSAN_CLAVEUNICA) IN ('$clave1') ";
        
        $clave2	    =   strtolower($arr_password[0]["pass2"]);
        $SQL2       =   "
                    SELECT 
                        ID_UID,
                        USERNAME,
                        NAME,
                        MIDDLE_NAME,
                        LAST_NAME 
                    FROM 
                       $this->ownGu.FE_USERS 
                    WHERE 
                    TO_CHAR(TX_INTRANETSSAN_CLAVEUNICA) IN ('$clave2') ";
        
        return array(
            'user_1'    =>  $this->db->query($SQL1)->row(),
            'user_2'    =>  $this->db->query($SQL2)->row(),
        );
    }
    
    public function sqlValidaClave($clave){
        $clave	    =   strtolower($clave);
        $SQL        =   "
            SELECT 
                ID_UID,
                USERNAME,
                NAME,
                MIDDLE_NAME,
                LAST_NAME 
            FROM 
               $this->ownGu.FE_USERS 
            WHERE 
            TO_CHAR(TX_INTRANETSSAN_CLAVEUNICA) IN ('$clave')";
        return $this->db->query($SQL)->row();
    }
    
    
    ###################################
    #MAIN ANATOMIA PATOLOGICA PRINCIPAL 
    #LISTA POR CLIENTES
    ###################
    public function CARGA_LISTA_MISSOLICITUDES_ANATOMIA($DATA){
        $this->db->trans_start();
        $CALL_FASE          =   isset($DATA['CALL_FASE'])?$DATA['CALL_FASE']:-1;
        $LODA_X_SISTEMAS    =   isset($DATA['LODA_X_SISTEMAS'])?$DATA['LODA_X_SISTEMAS']:0;
        $param              =   array(
                                    array( 
                                        'name'      =>  ':V_COD_EMPRESA',
                                        'value'     =>  $DATA["COD_EMPRESA"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_USR_SESSION',
                                        'value'     =>  $DATA["USR_SESSION"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_LOADXZONA',
                                        'value'     =>  $LODA_X_SISTEMAS,
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':VAL_FECHA_INICIO',
                                        'value'     =>  $DATA["DATE_FROM"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':VAL_FECHA_FINAL',
                                        'value'     =>  $DATA["DATE_TO"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':C_RESULT_LISTA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':C_HISTORIAL_M',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                );
        
        #RESULTADOS_ANATOMIA -> RECEPCION DE MUESTRAS
        
        $result                                     =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','GET_LISTA_ANOTOMIAPATOLOGICA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                                =>  true,
            'ARRAY_RESULT'                          =>  empty($result[':C_RESULT_LISTA'])?null:$result[':C_RESULT_LISTA'],
            'HTML_SOLICITUDEAP'                     =>  $this->RESULTADOS_ANATOMIA($result[":C_RESULT_LISTA"]),//table 
            'HTML_LI'                               =>  $this->LI_RESULTADOS_ANATOMIA($result[":C_RESULT_LISTA"],$CALL_FASE),//en li
            'DATE_FROM'                             =>  $DATA["DATE_FROM"],
            'DATE_TO'                               =>  $DATA["DATE_TO"],
        );
    }
    
    ############################
    #ssan_libro_biopsias_ii_fase
    #MAIN ANATOMIA PATOLOGICA PRINCIPAL
    #MAIN MODULO SIN CITA
    ############################
    public function LI_RESULTADOS_ANATOMIA($ARRAY,$CALL_FASE){
        $HTML                   =   '';
        if(count($ARRAY)>0){
            foreach($ARRAY as $i => $row){
                $num            =   ($i+1);
                $BTN            =   '';
                $BTN           .=   ' <div class="btn-group">
                                        <a class="btn btn-fill btn-info dropdown-toggle dropdown-menu-right" data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog" aria-hidden="true"></i>
                                            <span class="fa fa-caret-down" title="Men&uacute; de anatom&iacute;a patol&oacute;gica"></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right" style="margin-top:0px;min-width:240px;">';
                    if ($CALL_FASE == 1){
                        //******************************************************
                        if ($row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2){
                            $BTN                .=      '<li><a href="javascript:pre_busqueda(3,'.$row['ID_SOLICITUD'].')"><i class="fa fa-chevron-right"></i>EN CUSTODIA / TRASPORTE</a></li>';
                            $BTN                .=      '<li class="divider"></li>';
                        }
                        if ($row['ID_HISTO_ESTADO'] == 2){
                            //historial
                            //$BTN              .=      '<li class="historial"><a href="javascript:viws_historial('.$row['ID_SOLICITUD'].')"><i class="fa fa-database" aria-hidden="true"></i>HISTORIAL DE MUESTRAS</a></li>';
                            //$BTN              .=      '<li class="divider"></li>';
                        }
                        //******************************************************
                    }   else if ($CALL_FASE == 2){
                        if($row['ID_HISTO_ESTADO'] == 3){
                            $BTN                .=      '<li><a href="javascript:pre_busqueda(3,'.$row['ID_SOLICITUD'].')"><i class="fa fa-chevron-right"></i>RECEPCI&Oacute;N</a></li>';
                            $BTN                .=      '<li class="divider"></li>';
                        } else if($row['ID_HISTO_ESTADO'] == 4){
                            //IND_ESTADO_MUESTRAS
                            if ($row['IND_ESTADO_MUESTRAS']!=1){
                                $BTN            .=      '<li><a href="javascript:pre_busqueda(3,'.$row['ID_SOLICITUD'].')"><i class="fa fa-chevron-right"></i>RECEPCI&Oacute;N REZAGADAS</a></li>';
                                //$BTN          .=      '<li class="divider"></li>';
                                $BTN            .=      '<li><a href="javascript:pdf_rechazomuestra('.$row['ID_SOLICITUD'].')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>INFORME DE RECHAZO</a></li>';
                                //$BTN          .=      '<li class="divider"></li>';
                            } else {
                                $BTN            .=      '<li><a href="javascript:pdf_recepcion_ok('.$row['ID_SOLICITUD'].')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF RECEPCI&Oacute;N</a></li>';
                                $BTN            .=      '<li><a href="javascript:informar_x_correo('.$row['ID_SOLICITUD'].')"><i class="fa fa-envelope-open" aria-hidden="true"></i>INFORMAR POR CORREO</a></li>';
                                //$BTN          .=      '<li class="divider"></li>';
                            }
                            //historial
                            //$BTN              .=      '<li class="historial"><a href="javascript:viws_historial('.$row['ID_SOLICITUD'].')"><i class="fa fa-database" aria-hidden="true"></i>HISTORIAL DE MUESTRAS</a></li>';
                        } else if($row['ID_HISTO_ESTADO'] == 5){
                            $BTN                .=      '<li><a href="javascript:pdf_rechazomuestra('.$row['ID_SOLICITUD'].')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF RECHAZADA</a></li>';
                        }
                    } else {
                        $BTN                    .=  '';
                    }
                    $BTN                        .=  '<li><a href="javascript:GET_PDF_ANATOMIA_PANEL('.$row['ID_SOLICITUD'].')"><i class="fa fa-file-pdf-o"></i>PDF ANATOM&Iacute;A PATOL&Oacute;GICA</a></li>
                                    </ul>
                                </div>
                                    ';
                #ID_HISTO_ESTADO
                $html_tooltip2          =   '';
                if($row['ID_HISTO_ESTADO']!=1){
                    $html_tooltip2      =   '<div class="grid_tooltip">
                                                <div class="grid_11">'.$row['TXT_HISTO_ESTADO'].'</div>
                                                <div class="grid_12">'.$row['TXT_NAMEAUDITA'].'</div>
                                                <div class="grid_13">RUT</div>
                                                <div class="grid_14">'.$row['LAST_USR_AUDITA'].'</div>
                                                <div class="grid_15">FECHA/HORA</div>
                                                <div class="grid_16">'.$row['LAST_DATE_AUDITA'].'</div>
                                             </div>';
                } 
                $INFORMACION            =   '';
                       if($row['ID_HISTO_ESTADO'] == 1){
                    #('.$row['ID_HISTO_ESTADO'].')
                    $INFORMACION        =   '<button class="btn btn-xs btn-fill cssmain btn-default parpadea"       style="width: 100%;margin:-10px 0px 0px 0px;"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;NUEVA SOLICITUD&nbsp;</button>';
                } else if($row['ID_HISTO_ESTADO'] == 2){
                    $INFORMACION        =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;">';
                    $INFORMACION        .=   '<button class="btn btn-xs btn-fill cssmain btn-warning"               style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;" data-toggle="tooltip" data-placement="bottom" title=\''.$html_tooltip2.'\' data-html="true"><i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;CUSTODIA</button>';
                    $color_estado           =   $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado             =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check"              aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION        .=   '<button class="btn btn-xs btn-fill cssmain btn-'.$color_estado.'"     style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;">'.$txt_estado.'</button>';
                    $INFORMACION        .=   '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 3){
                    $INFORMACION        =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;">';
                    $INFORMACION        .=   '<button class="btn btn-xs btn-fill cssmain btn-info parpadea"         style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;" data-toggle="tooltip" data-placement="bottom" title=\''.$html_tooltip2.'\' data-html="true"><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;EN TRASPORTE</button>';
                    $color_estado           =   $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado             =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check"              aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION        .=   '<button class="btn btn-xs btn-fill cssmain btn-'.$color_estado.'"     style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;">'.$txt_estado.'</button>';
                    $INFORMACION        .=   '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 4){
                    $INFORMACION        =    '<div class="btn-group" style="display:flex;justify-content:center;flex-flow: initial;">';
                    $INFORMACION        .=   '<button class="btn btn-xs btn-fill cssmain btn-success"               style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;" data-toggle="tooltip" data-placement="bottom" title=\''.$html_tooltip2.'\' data-html="true"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;RECEPCIONADA</button>';
                    $color_estado           =   $row['IND_ESTADO_MUESTRAS']==1?'success':'danger';
                    $txt_estado             =   $row['IND_ESTADO_MUESTRAS']==1?'<i class="fa fa-check"              aria-hidden="true"></i>&nbsp;COMPLETA':'<i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;INCOMPLETA';
                    $INFORMACION        .=   '<button class="btn btn-xs btn-fill cssmain btn-'.$color_estado.'"     style="width: -webkit-fill-available;margin:-10px 0px 0px 0px;">'.$txt_estado.'</button>';
                    $INFORMACION        .=   '</div>';
                } else if($row['ID_HISTO_ESTADO'] == 5){
                    $INFORMACION        =   '<button class="btn btn-xs btn-fill cssmain btn-danger"                 style="width: 100%;margin:-10px 0px 0px 0px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;RECHAZADA</button>';
                } else {
                    $INFORMACION        =   '<button class="btn btn-xs btn-fill cssmain btn-danger"                 style="width: 100%;margin:-10px 0px 0px 0px;"><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;SIN INFORMACI&Oacute;N</button>';
                }
                
                $v_txt_derivado         =   $row['TXT_EMPRESA_DERIVADO']==''?'':'<span class="label label-warning">'.$row['TXT_EMPRESA_DERIVADO'].'</span> | ';
                #html li
                $HTML                   .=      '
                                        <li class="gespab_group list-group-item LISTA_BODY_'.$CALL_FASE.'" >
                                            <div class="CSS_GRID_CIRUGIA_FASE_1" 
                                                id                      =   "DATA_'.$row['ID_SOLICITUD'].'"
                                                data-paciente           =   "'.htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8').'"
                                                >
                                                <div class="text-center">'.$num.'</div>
                                                <div >
                                                    '.$row['NOMBRE_COMPLETO'].'<hr style="margin: 0px 0px 0px 0px;">
                                                    '.$row['RUTPACIENTE'].'<hr style="margin: 0px 0px 0px 0px;">
                                                    N&deg; Ficha: '.$row['FICHAL'].'
                                                    <!--    
                                                        &nbsp;|&nbsp; PA_ID_PROCARCH    =   '.$row['PA_ID_PROCARCH'].'<br>
                                                        &nbsp;|&nbsp; ID_HISTO_ESTADO   =   '.$row['ID_HISTO_ESTADO'].'<br>
                                                        &nbsp;|&nbsp; CALL_FASE         =   '.$CALL_FASE.'
                                                    -->    
                                                 </div>
                                                <div >'.$row['PROFESIONAL'].'<hr style="margin: 0px 0px 0px 0px;">'.$row['RUT_PROFESIOAL'].'</div>
                                                <div style="text-align : initial;">
                                                    '.$row['TIPO_DE_BIOPSIA'].'
                                                    <hr style="margin: 0px 0px 4px 0px;">
                                                    '.$row['TXT_PROCEDENCIA'].'
                                                    <hr style="margin: 0px 0px 4px 0px;">
                                                    '.$row['NOMBRE_SERVICIO'].'&nbsp;|&nbsp;'.$row['ID_SERVICIO'].'
                                                </div>
                                                <div style="text-align : initial;">
                                                    '.$INFORMACION.'
                                                    <hr style="margin: 0px 0px 4px 0px;"> 
                                                    <div class="text-center">'.$row['FECHA_SOLICITUD'].'</div>
                                                    <hr style="margin: 0px 0px 4px 0px;"> 
                                                    <div class="text-center">
                                                    '.$v_txt_derivado.' <b>N&deg;:'.$row['ID_SOLICITUD'].'</b> 
                                                    <!--
                                                        <hr> 
                                                        CALL_FASE               :&nbsp;|&nbsp;'.$CALL_FASE.'
                                                        <hr> 
                                                        ID_HISTO_ESTADO         :&nbsp;|&nbsp;'.$row['ID_HISTO_ESTADO'].'
                                                        <hr> 
                                                        IND_ESTADO_MUESTRAS     :&nbsp;|&nbsp;'.$row['IND_ESTADO_MUESTRAS'].'
                                                    -->
                                                    </div> 
                                                </div>
                                                
                                                <div>
                                                    <div class="grid_lista_gestion_masivo_li">
                                                        <div class="grid_lista_gestion_masivo_li1">'.$BTN.'</div>
                                                        <div class="grid_lista_gestion_masivo_li2"></div>
                                                        <div class="grid_lista_gestion_masivo_li2">';
                                                        if ($row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2 || $row['ID_HISTO_ESTADO'] == 3 ){
                                                            $style_display_none         =   $CALL_FASE==2&&$row['ID_HISTO_ESTADO']==3?'':'display:none;';
                                                            $HTML       .=      '
                                                                                    <input 
                                                                                    type        =   "checkbox" 
                                                                                    class       =   "form-check-input marcado_custoria_trasporte  marcado_recepcion_masiva checkbox_'.$row['ID_SOLICITUD'].'" 
                                                                                    id          =   "CHEK_'.$row['ID_SOLICITUD'].'" 
                                                                                    style       =   "display:block;cursor:pointer;margin:0px;'.$style_display_none.' " 
                                                                                    onchange    =   "js_muestra_indivual('.$row['ID_SOLICITUD'].');" value="'.$row['ID_SOLICITUD'].'">';
                                                            
                                                            
                                                        } else {
                                                            $HTML       .=      '';
                                                        }
                
                    $HTML           .=                  '</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    ';
            }
        } else {
            $HTML           .=      '
                                    <li class="gespab_group NO_INFORMACION list-group-item">
                                        <div class="GRID_NO_INFOPANEL"> 
                                            <div class="GRID_NO_INFOPANEL1">
                                                <i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b>SIN INFORMACI&Oacute;N</b>   
                                            </div>
                                        </div>
                                    </li>
                                    ';
        }
        return $HTML;
    }
    ######################################
    #LISTA DEL USUARIO QUE ENVIA SOLCITIUD
    #DE TODOS LADOS
    ######################################
    public function RESULTADOS_ANATOMIA($ARRAY){
        $HTML                               =   '';
        $txt_estado                         =   '';
        if(count($ARRAY)>0){
           foreach ($ARRAY as $i => $row){
                #$row['ID_SERVICIO'];
                #$row['ID_SOLICITUD'];
                $HTML       .=      '
                                    <tr 
                                            id              =   "DATA_'.$row['ID_SOLICITUD'].'"
                                            data-paciente   =   "'.htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8').'"
                                        >
                                        <td style="vertical-align: initial;text-align: center;height: 40px"><b>'.($i+1).'</b></td>
                                        <td style="vertical-align: initial;">'.$row['NOMBRE_COMPLETO'].'<br> <i>Ficha:'.$row['FICHAL'].' | '.$row['RUTPACIENTE'].'</i></td>
                                        <td style="vertical-align: initial;">'.$row['PROFESIONAL'].'<br>'.$row['RUT_PROFESIOAL'].'</td>
                                        <td>
                                            <div class="grid_vista_resumen">
                                                <div class="grid_vista_resumen1"> '.$row['TIPO_DE_BIOPSIA'].'</div>
                                                <div class="grid_vista_resumen2"> '.$row['TXT_PROCEDENCIA'].'</div>
                                                <div class="grid_vista_resumen3"> '.$row['NOMBRE_SERVICIO'].'</div>
                                            </div>
                                        </td>
                                        

                                        <td style="text-align: center;">';
                        #etiqueta estado
                        if ($row['ID_HISTO_ESTADO'] == 5){
                    $txt_estado     =   '<span class="label label-danger"><i class="fa fa-times" aria-hidden="true"></i>'.$row['TXT_HISTO_ESTADO'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                } else  if ($row['ID_HISTO_ESTADO'] == 4){
                    $txt_estado     =   '<span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i>'.$row['TXT_HISTO_ESTADO'].'</span>';
                } else {
                    $txt_estado     =   '<span class="label label-default">'.$row['TXT_HISTO_ESTADO'].'</span>';
                }
                $HTML           .=  $txt_estado.'</td>
                                        <td style="text-align: center;">';
                                        if( $row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2 || $row['ID_HISTO_ESTADO'] == 3 ){
                                            $HTML   .= '<a href="javascript:js_cambio_fecha('.$row['ID_SOLICITUD'].')">'.$row['FECHA_TOMA_MUESTRA'].'</a>';
                                        } else {
                                            $HTML   .= $row['FECHA_TOMA_MUESTRA'];
                                        }
                                        $HTML   .='  
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-fill btn-xs" id="pdf_anatomia_patologica" onclick="GET_PDF_ANATOMIA_PANEL('.$row['ID_SOLICITUD'].')">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                        <td>';

                #EN TRASPORTE - #CUSTODIA
                if( $row['ID_HISTO_ESTADO'] == 1 || $row['ID_HISTO_ESTADO'] == 2 || $row['ID_HISTO_ESTADO'] == 3 ){
                     $HTML       .=         '<button type="button" class="btn btn-danger btn-fill btn-xs" id="pdf_anatomia_patologica" onclick="btn_delete_ap_externo('.$row['ID_SOLICITUD'].')">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>';

                #RECHAZADA     
                } else if($row['ID_HISTO_ESTADO'] == 5){     
                    $HTML       .=          '<button type="button" class="btn btn-danger btn-fill btn-xs" id="pdf_anatomia_patologica" onclick="local_pdf_rechazomuestra('.$row['ID_SOLICITUD'].')">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </button>';
                #YA RECEPCIONADA    
                } else if($row['ID_HISTO_ESTADO'] == 4){   
                    $HTML       .=          '<button type="button" class="btn btn-success btn-fill btn-xs" id="pdf_anatomia_patologica" onclick="pdf_recepcion_ok('.$row['ID_SOLICITUD'].')">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </button>';
                } else {
                    $HTML       .=          '-';
                }
                $HTML       .=      '
                                        </td>
                                    </tr>
                                    ';
            }
        } else {
                $HTML  =            '<tr style="text-align: center;">
                                        <td colspan="11" style="text-align: center;height: 40px"><b>SIN RESULTADOS</b></td>
                                    </tr>';
        }
        $HTML2          =           '<tr style="text-align: center;">
                                        <td colspan="11" style="text-align: center;height: 40px"><b>SIN RESULTADOS</b></td>
                                    </tr>';
        return array(
            'NUEVAS_SOLICITUDES'    =>  $HTML,
            'VISTA_SOLICITUDES'     =>  $HTML2,
        );
    }
    
    public function LOAD_INFOXMUESTRAANATOMIACA($DATA){
        $this->db->trans_start();
        $param                  =       array(
                                            array( 
                                                'name'      =>  ':V_TXTMUESTRA',
                                                'value'     =>  $DATA["TXTMUESTRA"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':V_COD_EMPRESA',
                                                'value'     =>  $DATA["COD_EMPRESA"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':V_NUM_FASE',
                                                'value'     =>  isset($DATA["NUM_FASE"])?0:$DATA["NUM_FASE"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':V_ARR_DATA',
                                                'value'     =>  $DATA["ARR_DATA"],
                                                'length'    =>  4000,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':P_ANATOMIA_PATOLOGICA_MAIN',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_ANATOMIA_PATOLOGICA_MUESTRAS',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_AP_MUESTRAS_CITOLOGIA',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_AP_INFORMACION_ADICIONAL',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_INFO_LOG_ADVERSOS',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_STATUS',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_ERROR',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                        );
        $result                                             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_INFOXMUESTRAANATOMIACA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                                        =>	$this->db->trans_status(),
            'P_STATUS'                                      =>  empty($result[':P_STATUS'])?null:$result[':P_STATUS'],
            'P_ERROR'                                       =>  empty($result[':P_ERROR'])?null:$result[':P_ERROR'],
            'P_ANATOMIA_PATOLOGICA_MAIN'                    =>	empty($result[':P_ANATOMIA_PATOLOGICA_MAIN'])?null:$result[':P_ANATOMIA_PATOLOGICA_MAIN'],
            'P_ANATOMIA_PATOLOGICA_MUESTRAS'                =>	empty($result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'])?null:$result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'],
            'P_AP_MUESTRAS_CITOLOGIA'                       =>	empty($result[':P_AP_MUESTRAS_CITOLOGIA'])?null:$result[':P_AP_MUESTRAS_CITOLOGIA'],
            'P_AP_INFORMACION_ADICIONAL'                    =>	empty($result[':P_AP_INFORMACION_ADICIONAL'])?null:$result[':P_AP_INFORMACION_ADICIONAL'],
            'P_INFO_LOG_ADVERSOS'                           =>	empty($result[':P_INFO_LOG_ADVERSOS'])?null:$result[':P_INFO_LOG_ADVERSOS'],
        );
        
    }
    
    #FALTA LOGICA
    #IND_ESTADO               =   1  |   0
    #ID_HISTO_ESTADO          =   1  |   NUEVA SOLICITUD | 2 = EN CUSTODIA | 3 = TRASPORTE | 4 = RECEPCIONADA 
    public function get_confirma_custodia($DATA){
        $this->db->trans_start();
        $mivariable                 =   true;
        $arr_histo_ok               =   [];
        if(count($DATA['ARRAY'])>0){
            foreach($DATA['ARRAY'] as $i => $fila){
                foreach($fila as $x => $row){
                    //NUMERO DE CARGA
                    $ID_CARGA_AP                            =   $this->db->sequence($this->ownPab,'SEQ_NUM_CARGA_AP');
                    if(count($row["ARRAY_NMUESTRAS"])>0){
                        foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus){
                            $ID_LINETIME_HISTO              =   $this->db->sequence($this->ownPab,'SEQ_NUM_LINETIME_HISTO');
                            $ID_ANATOMIA                    =   $DATA["ID_ANATOMIA"];
                            $IND_CASETE                     =   $mus['IND_CASETE'];
                            $ID_MUESTRA                     =   $mus['ID_NMUESTRA'];
                            $arr_linea_tiempo               =   array(
                                "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                "ID_SOLICITUD_HISTO"        =>  $row["NUM_HISTO"],
                                //"ID_NMUESTRA"             =>  substr($mus['ID_NMUESTRA'],1),
                                "TXT_BACODE"                =>  $mus['ID_NMUESTRA'],
                                "NUM_FASE"                  =>  1,//EN CUSTODIA
                                "IND_CHECKED"               =>  $mus['IN_CHECKED'],
                                "USR_CREA"                  =>  $DATA["SESSION"],
                                "FEC_CREA"                  =>  'SYSDATE',
                                "IND_ESTADO"                =>  1,
                                "ID_UID"                    =>  $DATA["DATA_FIRMA"]->ID_UID,
                                "TXT_MUESTRA"               =>  $mus['TXT_MUESTRA']==''?'NO INFORMADO':$mus['TXT_MUESTRA'],
                            );
                            $arr_linea_tiempo               =   array_merge($arr_linea_tiempo,array($IND_CASETE==1?"ID_CASETE":"ID_NMUESTRA"=>$ID_MUESTRA)); 
                            $this->db->insert($this->ownPab.'.PB_LINETIME_HISTO',$arr_linea_tiempo);
                            //**************************************************
                            
                            //*****************************************************
                            //ACTUALIZA ESTADO DE LA MUESTRA CON EL ULTIMO LINETIME
                            $this->db->where($IND_CASETE==1?'ID_CASETE':'ID_NMUESTRA',$ID_MUESTRA);
                            $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array(
                                "IND_ESTADO_CU"             =>  $mus['IN_CHECKED'],
                                "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                "USR_AUDITA"                =>  $DATA["SESSION"],
                                "DATE_AUDITA"               =>  'SYSDATE'
                            ));
                            //***************************
                            //ARRAY ANTECEDENTES ADVERSOS
                            if(isset($mus["ARR_EVENTOS_ADVERSOS"])){
                                foreach($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv){
                                    $this->db->insert($this->ownPab.'.PB_ANTECEDENTES_HISTO',array(
                                        "ID_ANTECEDENTES_HISTO"     =>  $this->db->sequence($this->own,'SEQ_NUM_ANTECEDENTE_HISTO'),
                                        "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                        "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                        "ID_SOLICITUD_HISTO"        =>  $ID_ANATOMIA,
                                        "ID_NMUESTRA"               =>  $ID_MUESTRA,
                                        "ID_MOTIVO_DESAC"           =>  $adv["IND_MOTIVO"],
                                        "TXT_EVENTO_OBSERVACION"    =>  $adv["TXT_OBSERVACION"],
                                        "IND_ESTADO"                =>  1
                                    ));
                                }
                            }
                        }
                    }
                    
                    //**********************************************************
                    //ACTUALIZA EL ESTADO DE LA SOLCIITUD PRINCIPAL
                    array_push($arr_histo_ok,$row["NUM_HISTO"]);
                    $this->db->where('ID_SOLICITUD_HISTO',$row["NUM_HISTO"]); 
                    $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',
                    array(  
                        "ID_HISTO_ESTADO"               =>  2,
                        "IND_ESTADO_MUESTRAS"           =>  $row["NUM_OK_SAMPLES"],
                        "ID_NUM_CARGA"                  =>  $ID_CARGA_AP,
                        "LAST_USR_AUDITA"               =>  $DATA["DATA_FIRMA"]->USERNAME,
                        "LAST_DATE_AUDITA"              =>  'SYSDATE',
                        
                        "ID_UID_CUSTODIA"               =>  $DATA["DATA_FIRMA"]->ID_UID,
                        "DATE_LAST_CUSTODIA"            =>  'SYSDATE',
                        
                        "ID_UID"                        =>  $DATA["DATA_FIRMA"]->ID_UID,
                        "TXT_NAMEAUDITA"                =>  $DATA["DATA_FIRMA"]->NAME." ".$DATA["DATA_FIRMA"]->MIDDLE_NAME
                    ));
                    //**********************************************************
                }
            }
        }
        return array(
            'STATUS'        =>  $mivariable,
            'HISTO_OK'      =>  $arr_histo_ok,
            'STATUS_BD'     =>  $this->db->trans_complete(),  
        );
    }
    
    #SOLO TRASPORTE + DERIVACION POR CODIGO
    public function get_confirma_trasporte($DATA){
        ########################################################################
        $this->db->trans_start();
        $mivariable                                 =   true;
        $arr_histo_ok                               =   [];
        #DERIVACION ENTRE EMPRESAS
        $_val_establecimiento_referencia            =   '';
        if($DATA['COD_EMPRESA'] == '100' || $DATA['COD_EMPRESA'] == '106' || $DATA['COD_EMPRESA'] == '029'){
            $_val_establecimiento_referencia        =   ''; 
        } else {
            $v_cod_empresa                          =   $DATA['COD_EMPRESA'];
        /*            
        #HOSPITAL ANGOL             –   RECIBE SOLICITUD DE:
            CSF ALEMANIA            -   303
            CSF HUEQUEN             -   301
            PIEDRA DE AGUILA        -   304
            CSF RENAICO             -   300 
            H COLLIPULLI            -   103
            H PUREN                 -   101
            CSF LOS SAUCES          -   102
            CSF LUMACO              -   105
        #HOSPITAL VICTORIA
            CSF VICTORIA            -   318
            H TRAGUIEN              -   104
            H LONQUIMAY             -   108
            H CURACAUTÍN            -   107
            CSF ERCILLA             –   302
        */
            #$_arr_establecimiento_referencia       =   $this->db->query(" SELECT P.COD_ESTABLREF FROM PABELLON.PB_RED_MAPA_AP P WHERE P.COD_EMPRESA IN ($v_cod_empresa)  AND P.IND_ESTADO IN (1) ")->result_array();
            #$_val_establecimiento_referencia       =   $_arr_establecimiento_referencia[0]["COD_ESTABLREF"];
            
            if  (   $v_cod_empresa  == '303'   || 
                    $v_cod_empresa  == '301'   || 
                    $v_cod_empresa  == '304'   || 
                    $v_cod_empresa  == '300'   || 
                    $v_cod_empresa  == '103'   || 
                    $v_cod_empresa  == '101'   || 
                    $v_cod_empresa  == '102'   ||
                    $v_cod_empresa  == '105'   
                ){
                $_val_establecimiento_referencia    =   '100';
            }
            if  (   $v_cod_empresa  == '318'   || 
                    $v_cod_empresa  == '104'   || 
                    $v_cod_empresa  == '108'   || 
                    $v_cod_empresa  == '107'   || 
                    $v_cod_empresa  == '302'    
                ){
                $_val_establecimiento_referencia    =   '106';
            }
        }
        
        if(count($DATA['ARRAY'])>0){
            foreach($DATA['ARRAY'] as $i => $fila){
                foreach($fila as $x => $row){
                    //NUMERO DE CARGA
                    $ID_CARGA_AP                            =   $this->db->sequence($this->ownPab,'SEQ_NUM_CARGA_AP');
                    if(count($row["ARRAY_NMUESTRAS"])>0){
                        foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus){
                            $ID_LINETIME_HISTO              =   $this->db->sequence($this->ownPab,'SEQ_NUM_LINETIME_HISTO');
                            $ID_ANATOMIA                    =   $DATA["ID_ANATOMIA"];
                            $IND_CASETE                     =   $mus['IND_CASETE'];
                            $ID_MUESTRA                     =   $mus['ID_NMUESTRA'];
                            $arr_linea_tiempo               =   array(
                                "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                "ID_SOLICITUD_HISTO"        =>  $row["NUM_HISTO"],
                                //"ID_NMUESTRA"             =>  substr($mus['ID_NMUESTRA'],1),
                                "TXT_BACODE"                =>  $mus['ID_NMUESTRA'],
                                "NUM_FASE"                  =>  2,//EN TRASPORTE
                                "IND_CHECKED"               =>  $mus['IN_CHECKED'],
                                "USR_CREA"                  =>  $DATA["SESSION"],
                                "FEC_CREA"                  =>  'SYSDATE',
                                "IND_ESTADO"                =>  1,
                                "ID_UID"                    =>  $DATA["DATA_FIRMA"]->ID_UID,
                                "TXT_MUESTRA"               =>  $mus['TXT_MUESTRA']==''?'NO INFORMADO':$mus['TXT_MUESTRA'],
                            );
                            
                            $arr_linea_tiempo               =   array_merge($arr_linea_tiempo,array($IND_CASETE==1?"ID_CASETE":"ID_NMUESTRA"=>$ID_MUESTRA)); 
                            $this->db->insert($this->ownPab.'.PB_LINETIME_HISTO',$arr_linea_tiempo);
                            //CAMBIA ESTADO DE MUESTRAS
                            $this->db->where($IND_CASETE==1?'ID_CASETE':'ID_NMUESTRA',$ID_MUESTRA);
                            $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array(
                                "IND_ESTADO_CU"             =>  $mus['IN_CHECKED'],
                                "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                "USR_AUDITA"                =>  $DATA["SESSION"],
                                "DATE_AUDITA"               =>  'SYSDATE'
                            ));
                            if(isset($mus["ARR_EVENTOS_ADVERSOS"])){
                                foreach($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv){
                                    $this->db->insert($this->ownPab.'.PB_ANTECEDENTES_HISTO',array(
                                        "ID_ANTECEDENTES_HISTO"     =>  $this->db->sequence($this->own,'SEQ_NUM_ANTECEDENTE_HISTO'),
                                        "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                        "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                        "ID_SOLICITUD_HISTO"        =>  $ID_ANATOMIA,
                                        "ID_NMUESTRA"               =>  $ID_MUESTRA,
                                        "ID_MOTIVO_DESAC"           =>  $adv["IND_MOTIVO"],
                                        "TXT_EVENTO_OBSERVACION"    =>  $adv["TXT_OBSERVACION"],
                                        "IND_ESTADO"                =>  1
                                    ));
                                }
                            }
                            
                        }
                    }
                    
                    ############################################################
                    array_push($arr_histo_ok,$row["NUM_HISTO"]);
                    $this->db->where('ID_SOLICITUD_HISTO',$row["NUM_HISTO"]);
                    $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',array(
                        
                        "ID_HISTO_ESTADO"           =>  3,
                        
                        "DATE_TRASLADO"             =>  'SYSDATE',
                        "ID_UID_TRASLADO"           =>  $DATA["DATA_FIRMA"]->ID_UID,
                        
                        "ID_USER_TRASLADO"          =>  $DATA["SESSION"],
                        "IND_ESTADO_MUESTRAS"       =>  $row["NUM_OK_SAMPLES"],
                        "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                        "LAST_USR_AUDITA"           =>  $DATA["DATA_FIRMA"]->USERNAME,
                        "LAST_DATE_AUDITA"          =>  'SYSDATE',
                        "ID_UID"                    =>  $DATA["DATA_FIRMA"]->ID_UID,
                        "TXT_NAMEAUDITA"            =>  $DATA["DATA_FIRMA"]->NAME." ".$DATA["DATA_FIRMA"]->MIDDLE_NAME,
                        "COD_ESTABLREF"             =>  $_val_establecimiento_referencia
                    ));
                }
            }
        }
        
        return array(
            'STATUS'        =>  $mivariable,
            'HISTO_OK'      =>  $arr_histo_ok,
            'STATUS_BD'     =>  $this->db->trans_complete(),  
            ''
        );
    }
    
    #RECEPCION
    public function get_confirma_recepcion($DATA){
        $this->db->trans_start();
        $status                                     =   true;
        $arr_histo_ok                               =   [];
        $arr_linea_tiempo                           =   [];
        $num_interno                                =   $DATA["n_interno"];
        $n_interno_2                                =   $DATA["n_interno_2"];
        $cod_empresa                                =   $DATA["COD_EMPRESA"];
        $ID_ANATOMIA                                =   $DATA["ID_ANATOMIA"];
        $IND_TIPO_BIOPSIA                           =   $DATA["ind_tipo_biopsia"];
        #LOAD
        #BIOPSIA - CITOLOGIA
        if ($IND_TIPO_BIOPSIA == 4){
            $data_num_interno                       =   $this->db->query(" SELECT P.NUM_INTERNO_AP FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.NUM_INTERNO_AP IN ($num_interno)  AND P.COD_EMPRESA IN ($cod_empresa)  AND TO_CHAR(P.DATE_INICIOREGISTRO,'YYYY') = TO_CHAR(SYSDATE,'YYYY') AND P.IND_TIPO_BIOPSIA IN (2,3,4)")->result_array();
            $data_num_citologia                     =   $this->db->query(" SELECT P.NUM_CO_CITOLOGIA FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.NUM_CO_CITOLOGIA IN ($n_interno_2)  AND P.COD_EMPRESA IN ($cod_empresa)  AND TO_CHAR(P.DATE_INICIOREGISTRO,'YYYY') = TO_CHAR(SYSDATE,'YYYY') AND P.IND_TIPO_BIOPSIA IN (4,5)")->result_array();
            if(count($data_num_interno)>0 || count($data_num_citologia)>0){
                return array(
                    'STATUS'                        =>  false,
                    'TXT_ERROR'                     =>  'N&deg; meno notificaci&oacute;n ya existe',
                    'HISTO_OK'                      =>  null,
                    'STATUS_BD'                     =>  false,
                    'error_memo'                    =>  1,
                    'close_modal'                   =>  0,
                    'count_interno'                 =>  count($data_num_interno),
                    'count_cotologia'               =>  count($data_num_citologia),
                );
            }
        } else {
            if( $IND_TIPO_BIOPSIA == 2 || $IND_TIPO_BIOPSIA == 3 ){  #CONTEMPORANEA Y DIFERIDA
                $data_num_interno                   =   $this->db->query(" SELECT P.NUM_INTERNO_AP FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.NUM_INTERNO_AP IN ($num_interno)  AND P.COD_EMPRESA IN ($cod_empresa)  AND TO_CHAR(P.DATE_INICIOREGISTRO,'YYYY') = TO_CHAR(SYSDATE,'YYYY') AND P.IND_TIPO_BIOPSIA IN (2,3,4)")->result_array();
            } else if ($IND_TIPO_BIOPSIA == 5)      {   #SOLO CITOLOGIA
                $data_num_interno                   =   $this->db->query(" SELECT P.NUM_CO_CITOLOGIA FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.NUM_CO_CITOLOGIA IN ($num_interno)  AND P.COD_EMPRESA IN ($cod_empresa)  AND TO_CHAR(P.DATE_INICIOREGISTRO,'YYYY') = TO_CHAR(SYSDATE,'YYYY') AND P.IND_TIPO_BIOPSIA IN (5)")->result_array();
            } else if ($IND_TIPO_BIOPSIA == 6)      {   #PAP
                $data_num_interno                   =   $this->db->query(" SELECT P.NUM_CO_PAP FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.NUM_CO_PAP IN ($num_interno)  AND P.COD_EMPRESA IN ($cod_empresa)  AND TO_CHAR(P.DATE_INICIOREGISTRO,'YYYY') = TO_CHAR(SYSDATE,'YYYY') AND P.IND_TIPO_BIOPSIA IN (6)")->result_array();
            }
            if(count($data_num_interno)>0){
                return array(
                    'STATUS'                        =>  false,
                    'TXT_ERROR'                     =>  'N&deg; meno notificaci&oacute;n ya existe',
                    'HISTO_OK'                      =>  null,
                    'STATUS_BD'                     =>  false,
                    'error_memo'                    =>  1,
                    'close_modal'                   =>  0,
                    'count_interno'                 =>  count($data_num_interno),
                    'count_cotologia'               =>  0,
                );
            }
        }
        #######################################################################
        $data_identifica_estado                     =   $this->db->query("SELECT P.ID_HISTO_ESTADO FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.ID_SOLICITUD_HISTO IN ($ID_ANATOMIA) AND P.IND_ESTADO IN (1) AND P.ID_HISTO_ESTADO IN (3)")->result_array();
        if (count($data_identifica_estado)>0){
            if(count($DATA['ARRAY'])>0){
                foreach($DATA['ARRAY'] as $i => $fila){
                    foreach($fila as $x => $row){
                        #NUMERO DE CARGA DE LA TIME LINE
                        $ID_CARGA_AP                                    =   $this->db->sequence($this->ownPab,'SEQ_NUM_CARGA_AP');
                        #GESTION DE LAS MUESTAS Y CASET DE ANATOMIA
                        if(count($row["ARRAY_NMUESTRAS"])>0){
                            foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus){
                                #AGREGA AL HISTORIAL DE LA MUESTRA
                                $ID_LINETIME_HISTO                      =   $this->db->sequence($this->ownPab,'SEQ_NUM_LINETIME_HISTO');
                                $ID_ANATOMIA                            =   $DATA["ID_ANATOMIA"];
                                $IND_CASETE                             =   $mus['IND_CASETE'];
                                $ID_MUESTRA                             =   $mus['ID_NMUESTRA'];
                                $arr_linea_tiempo                       =   array(
                                    "ID_LINETIMEHISTO"                  =>  $ID_LINETIME_HISTO,
                                    "ID_NUM_CARGA"                      =>  $ID_CARGA_AP,
                                    "ID_SOLICITUD_HISTO"                =>  $row["NUM_HISTO"],
                                    //"ID_NMUESTRA"                     =>  substr($mus['ID_NMUESTRA'],1),
                                    "TXT_BACODE"                        =>  $mus['ID_NMUESTRA'],
                                    "NUM_FASE"                          =>  3,//RECEPCION
                                    "IND_CHECKED"                       =>  $mus['IN_CHECKED'],
                                    "USR_CREA"                          =>  $DATA["SESSION"],
                                    "FEC_CREA"                          =>  'SYSDATE',
                                    "IND_ESTADO"                        =>  1,
                                    "ID_UID"                            =>  $DATA["DATA_FIRMA"]["user_1"]->ID_UID,
                                    "TXT_MUESTRA"                       =>  $mus['TXT_MUESTRA']==''?'NO INFORMADO':$mus['TXT_MUESTRA'],
                                );
                                array_merge($arr_linea_tiempo,array($IND_CASETE==1?"ID_CASETE":"ID_NMUESTRA"=>$ID_MUESTRA)); 
                                $this->db->insert($this->ownPab.'.PB_LINETIME_HISTO',$arr_linea_tiempo);
                                #CAMBIA ESTADO DE MUESTRAS
                                $this->db->where($IND_CASETE==1?'ID_CASETE':'ID_NMUESTRA',$ID_MUESTRA);
                                $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array(
                                    "IND_ESTADO_CU"                     =>  $mus['IN_CHECKED'],
                                    "ID_NUM_CARGA"                      =>  $ID_CARGA_AP,
                                    "USR_AUDITA"                        =>  $DATA["SESSION"],
                                    "DATE_AUDITA"                       =>  'SYSDATE',
                                ));
                                #ADD EVENTOS ADVERSOS
                                if(isset($mus["ARR_EVENTOS_ADVERSOS"])){
                                    foreach($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv){
                                        $this->db->insert($this->ownPab.'.PB_ANTECEDENTES_HISTO',array(
                                            "ID_ANTECEDENTES_HISTO"     =>  $this->db->sequence($this->own,'SEQ_NUM_ANTECEDENTE_HISTO'),
                                            "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                            "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                            "ID_SOLICITUD_HISTO"        =>  $ID_ANATOMIA,
                                            "ID_NMUESTRA"               =>  $ID_MUESTRA,
                                            "ID_MOTIVO_DESAC"           =>  $adv["IND_MOTIVO"],
                                            "TXT_EVENTO_OBSERVACION"    =>  $adv["TXT_OBSERVACION"],
                                            "IND_ESTADO"                =>  1,
                                        ));
                                    }
                                }
                            }
                        }

                        #CONSULTA SI ESTA EN PABELLON
                        #CITOLOGIA Y CITOLOGIA PAP -> GO TO 
                        $result                         =   $this->db->query("SELECT P.IND_TIPO_BIOPSIA FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.ID_SOLICITUD_HISTO IN (".$row['NUM_HISTO'].")")->result_array();
                        $ind_zona                       =   $result[0]['IND_TIPO_BIOPSIA']=='6'||$result[0]['IND_TIPO_BIOPSIA']=='5'?'4':'0';
                        #NUMEROS DE ANATOMIA RESUELTOS
                        array_push($arr_histo_ok,$row["NUM_HISTO"]);
                        #MAIN - RECEPCION OK 
                        $this->db->where('ID_SOLICITUD_HISTO',$row["NUM_HISTO"]);
                        $arr_update                     =   array(  
                            "ID_HISTO_ESTADO"           =>  4,//RECEPCION OK
                            "ID_HISTO_ZONA"             =>  $ind_zona,
                            "IND_ESTADO_MUESTRAS"       =>  $row["NUM_OK_SAMPLES"],
                            "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                            //"LAST_USR_AUDITA"         =>  $DATA["DATA_FIRMA"]["user_1"]->USERNAME,
                            //"LAST_DATE_AUDITA"        =>  'SYSDATE',
                            //"ID_UID"                  =>  $DATA["DATA_FIRMA"]["user_1"]->ID_UID,
                            //"TXT_NAMEAUDITA"          =>  $DATA["DATA_FIRMA"]["user_1"]->NAME." ".$DATA["DATA_FIRMA"]["user_1"]->MIDDLE_NAME." ".$DATA["DATA_FIRMA"]["user_1"]->LAST_NAME,
                            "FEC_USRCREA_RECEP"         =>  'SYSDATE',
                            "COD_USRCREA_RECEP"         =>  $DATA["SESSION"],
                            "COD_SESSION_RECEPCIONA"    =>  $DATA["SESSION"],
                            "ID_UID_TRASPORTE_OK"       =>  $DATA["DATA_FIRMA"]["user_1"]->ID_UID,
                            "ID_UID_RECEPCIONA_OK"      =>  $DATA["DATA_FIRMA"]["user_2"]->ID_UID,
                            "LAST_USR_AUDITA"           =>  $DATA["SESSION"],
                            "LAST_DATE_AUDITA"          =>  "SYSDATE",
                            //"NUM_INTERNO_AP"          =>  $DATA["n_interno"],
                        ); 
                        
                        #ADD
                        if ($IND_TIPO_BIOPSIA           ==  4){
                            $arr_update                 =   array_merge($arr_update, array('NUM_INTERNO_AP'         => $DATA["n_interno"]));
                            $arr_update                 =   array_merge($arr_update, array('NUM_CO_CITOLOGIA'       => $DATA["n_interno_2"]));
                        } else {
                            if( $IND_TIPO_BIOPSIA == 2 || $IND_TIPO_BIOPSIA == 3 ){
                                $arr_update             =   array_merge($arr_update, array('NUM_INTERNO_AP'         => $DATA["n_interno"]));
                            } else if ($IND_TIPO_BIOPSIA    == 5 ){ 
                                $arr_update             =   array_merge($arr_update, array('NUM_CO_CITOLOGIA'       => $DATA["n_interno"]));
                            } else if ($IND_TIPO_BIOPSIA    == 6 ){
                                $arr_update             =   array_merge($arr_update, array('NUM_CO_PAP'             => $DATA["n_interno"]));

                            } 
                        }
                        $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',$arr_update);
                    }
                }
            }
            return array(
                'STATUS'                        =>  $status,
                'TXT_ERROR'                     =>  '',
                'HISTO_OK'                      =>  $arr_histo_ok,
                'STATUS_BD'                     =>  $this->db->trans_complete(),  
            );
        } else {
            return array(
                'STATUS'                        =>  false,
                'TXT_ERROR'                     =>  'La solicitud ha cambiado de estado',
                'HISTO_OK'                      =>  null,
                'STATUS_BD'                     =>  false,
                'error_memo'                    =>  1,
                'close_modal'                   =>  1,
            );
        }
    }
    
    #rechazo
    public function model_confirma_rechazo_muestras($DATA){
        $this->db->trans_start();
        $mivariable                     =   true;
        $arr_histo_ok                   =   [];
        $txt_observacion_glob           =   $DATA['TXT_GLOBAL'];
        $ID_UID                         =   $DATA['DATA_FIRMA']->ID_UID;
        $ID_ANATOMIA                    =   $DATA['ID_ANATOMIA']; 
        
        #LOAD
        if(count($DATA['ARRAY'])>0){
            foreach($DATA['ARRAY'] as $i => $fila){
                foreach($fila as $x => $row){
                    
                    #NUMERO DE CARGA DE LA TIME LINE
                    $ID_CARGA_AP                            =   $this->db->sequence($this->ownPab,'SEQ_NUM_CARGA_AP');
                    
                    #GESTION DE LAS MUESTAS Y CASET DE ANATOMIA
                    if(count($row["ARRAY_NMUESTRAS"])>0){
                        foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus){
                            
                            #AGREGA AL HISTORIAL DE LA MUESTRA
                            $ID_LINETIME_HISTO              =   $this->db->sequence($this->ownPab,'SEQ_NUM_LINETIME_HISTO');
                            $ID_ANATOMIA                    =   $DATA["ID_ANATOMIA"];
                            $IND_CASETE                     =   $mus['IND_CASETE'];
                            $ID_MUESTRA                     =   $mus['ID_NMUESTRA'];
                            $arr_linea_tiempo               =   array(
                                "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                "ID_SOLICITUD_HISTO"        =>  $row["NUM_HISTO"],
                                //"ID_NMUESTRA"             =>  substr($mus['ID_NMUESTRA'],1),
                                "TXT_BACODE"                =>  $mus['ID_NMUESTRA'],
                                "NUM_FASE"                  =>  4,//RECHAZO
                                "IND_CHECKED"               =>  $mus['IN_CHECKED'],
                                "USR_CREA"                  =>  $DATA["SESSION"],
                                "FEC_CREA"                  =>  'SYSDATE',
                                "IND_ESTADO"                =>  1,
                                "ID_UID"                    =>  $ID_UID,
                                "TXT_MUESTRA"               =>  $mus['TXT_MUESTRA']==''?'NO INFORMADO':$mus['TXT_MUESTRA'],
                            );
                            
                            #IDENTIFICA SI ES MUESTA O CASETE
                            array_merge($arr_linea_tiempo,array($IND_CASETE==1?"ID_CASETE":"ID_NMUESTRA"=>$ID_MUESTRA)); 
                            $this->db->insert($this->ownPab.'.PB_LINETIME_HISTO',$arr_linea_tiempo);

                            #CAMBIA ESTADO DE MUESTRAS
                            #IDENTIFICA SI ES CASETE O MUESTRA INDIVIDUAL
                            $this->db->where($IND_CASETE==1?'ID_CASETE':'ID_NMUESTRA',$ID_MUESTRA);
                            $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array(
                                "IND_ESTADO_CU"             =>  $mus['IN_CHECKED'],
                                "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                "USR_AUDITA"                =>  $DATA["SESSION"],
                                "DATE_AUDITA"               =>  'SYSDATE',
                            ));
                            
                            //var_dump($row["NUM_HISTO"]);
                            
                            #ADD EVENTOS ADVERSOS
                            if(isset($mus["ARR_EVENTOS_ADVERSOS"])){
                                foreach($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv){
                                    $this->db->insert($this->ownPab.'.PB_ANTECEDENTES_HISTO',array(
                                        "ID_ANTECEDENTES_HISTO"     =>  $this->db->sequence($this->own,'SEQ_NUM_ANTECEDENTE_HISTO'),
                                        "ID_SOLICITUD_HISTO"        =>  $row["NUM_HISTO"],
                                        "ID_LINETIMEHISTO"          =>  $ID_LINETIME_HISTO,
                                        "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                                        "ID_NMUESTRA"               =>  $ID_MUESTRA,
                                        "ID_MOTIVO_DESAC"           =>  $adv["IND_MOTIVO"],
                                        "TXT_EVENTO_OBSERVACION"    =>  $adv["TXT_OBSERVACION"],
                                        "IND_ESTADO"                =>  1,
                                    ));
                                }
                            }
                            #END
                            
                            #ADD ARRAY MUESTRAS
                        }
                    }
                    
                    #CONSULTA SI ESTA EN PABELLON
                    //$result                         =   $this->db->query("SELECT P.IND_TIPO_BIOPSIA FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.ID_SOLICITUD_HISTO IN (".$row['NUM_HISTO'].")")->result_array();
                    //$ind_zona                       =   $result[0]['IND_TIPO_BIOPSIA']=='6'?'4':'0';
                    
                    #NUMEROS DE ANATOMIA RESUELTOS
                    array_push($arr_histo_ok,$row["NUM_HISTO"]);
                    
                    #MAIN - RECHAZO 
                    $this->db->where('ID_SOLICITUD_HISTO',$row["NUM_HISTO"]); 
                    $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',array(
                        "FEC_REVISION"              =>  "SYSDATE",
                        "ID_HISTO_ESTADO"           =>  5,#RECHAZO  
                        //"ID_HISTO_ZONA"           =>  $ind_zona,
                        "IND_ESTADO_MUESTRAS"       =>  $row["NUM_OK_SAMPLES"],
                        "ID_NUM_CARGA"              =>  $ID_CARGA_AP,
                        "ID_UID_RECHAZA"            =>  $ID_UID,
                        "TXT_OBS_RECHAZA"           =>  $txt_observacion_glob,
                        "LAST_USR_AUDITA"           =>  $DATA["SESSION"],
                        "LAST_DATE_AUDITA"          =>  "SYSDATE",
                    ));
                    
                }
            }
        }
        return array(
            'STATUS'        =>  $mivariable,
            'HISTO_OK'      =>  $arr_histo_ok,
            'STATUS_BD'     =>  $this->db->trans_complete(),  
        );
    }
    
    public function busqueda_historial($DATA){
        return $this->db->query("SELECT 
            P.ID_LINETIMEHISTO, 
            P.ID_NUM_CARGA, 
            P.ID_SOLICITUD_HISTO, 
            P.TXT_BACODE, 
            P.NUM_FASE, 
            P.IND_CHECKED, 
            P.USR_CREA, 
            P.FEC_CREA, 
            P.IND_ESTADO, 
            P.ID_NMUESTRA, 
            P.ID_UID
        FROM 
            PABELLON.PB_LINETIME_HISTO P
        WHERE
            P.ID_SOLICITUD_HISTO = ".$DATA["ID_ANATOMIA"]."
        ORDER BY 
            P.FEC_CREA")->result_array();
    }
    
    public function LOAD_BUSQUEDA_INFO($DATA){
        return $this->db->query(" SELECT 
                P.ID_SOLICITUD_HISTO, 
                P.NUM_FICHAE, 
                P.COD_USRCREA, 
                P.FEC_USRCREA, 
                P.COD_EMPRESA, 
                P.DES_SITIOEXT, 
                P.DES_UBICACION, 
                P.DES_TAMANNO, 
                P.ID_TIPO_LESION, 
                P.ID_ASPECTO, 
                P.ID_ANT_PREVIOS, 
                P.NUM_ANTECEDENTES, 
                P.DES_BIPSIA, 
                P.DES_CITOLOGIA, 
                P.DES_OBSERVACIONES, 
                P.IND_ESTADO, 
                P.FEC_REVISION, 
                P.ID_TABLA, 
                P.DES_TIPOMUESTRA, 
                P.NUM_SUBNUMERACION, 
                P.COD_USRCREA_TO_MUE, 
                P.FEC_USRCREA_TO_MUE, 
                P.COD_USRCREA_ENV, 
                P.FEC_USRCREA_ENV, 
                P.COD_USRCREA_RECEP, 
                P.FEC_USRCREA_RECEP, 
                P.COD_EMPRESA_RECEP, 
                P.COD_USRCREA_INFORMADA, 
                P.FEC_USRCREA_INFORMADA, 
                P.COD_EMPRESA_INFORMADA, 
                P.ID_ARCHIVO_SUBIDO, 
                P.COD_USRCREA_RECH, 
                P.FEC_USRCREA_RECH, 
                P.COD_EMPRESA_RECH, 
                P.TIPO_RECHAZO, 
                P.OBS_RECHAZO, 
                P.ID_HISTO_ESTADO, 
                P.AD_ID_ADMISION, 
                P.ID_SERDEP, 
                P.PA_ID_PROCARCH, 
                P.IND_TIPO_BIOPSIA, 
                P.IND_TEMPLATE, 
                P.DATE_INICIOREGISTRO, 
                P.COD_RUTPRO, 
                P.TXT_DIAGNOSTICO, 
                P.NUM_PLANTILLA, 
                P.IND_USOCASSETTE, 
                P.IND_INFOPOST
            FROM 
                PABELLON.PB_SOLICITUD_HISTO P
            WHERE
                P.ID_SOLICITUD_HISTO IN (".$DATA['NUM_HISTO'].") ")->result_array();
    }
    
    #PDF_GLOBAL
    public function LOAD_ANATOMIAPATOLOGICA_PDF($DATA){
        $this->db->trans_start();
        //$this->db->trans_begin();
        $param                  =       array(
                                            #IN
                                            array( 
                                                'name'      =>  ':V_COD_EMPRESA',
                                                'value'     =>  $DATA["COD_EMPRESA"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':V_ID_HISTO',
                                                'value'     =>  $DATA["ID_HISTO"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            #OUT
                                            array( 
                                                'name'      =>  ':P_ANATOMIA_PATOLOGICA_MAIN',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_ANATOMIA_PATOLOGICA_MUESTRAS',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_AP_MUESTRAS_CITOLOGIA',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            #BLOB
                                            array( 
                                                'name'      =>  ':C_IMAGENES_BLOB',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':C_IMAGENES_BLOB_MUESTRAS',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                        );
        $result                                             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_ANATOMIAPATOLOGICA_PDF',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                                        =>	$this->db->trans_status(),
            'ID_HISTO'                                      =>	$DATA["ID_HISTO"],
            'COD_EMPRESA'                                   =>	$DATA["COD_EMPRESA"],
            'HTML_QR'                                       =>  $this->load->view("ssan_spab_coordepabellonenfe_new/PDF_PROTOCOLOS/html_gr_infoanatomia",array('id_histo'=>$DATA["ID_HISTO"]),true),
            'P_ANATOMIA_PATOLOGICA_MAIN'                    =>	empty($result[':P_ANATOMIA_PATOLOGICA_MAIN'])?null:$result[':P_ANATOMIA_PATOLOGICA_MAIN'],
            'P_ANATOMIA_PATOLOGICA_MUESTRAS'                =>	empty($result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'])?null:$result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'],
            'P_AP_MUESTRAS_CITOLOGIA'                       =>	empty($result[':P_AP_MUESTRAS_CITOLOGIA'])?null:$result[':P_AP_MUESTRAS_CITOLOGIA'],
            'C_IMAGENES_BLOB'                               =>	empty($result[':C_IMAGENES_BLOB'])?null:$result[':C_IMAGENES_BLOB'],
            'C_IMAGENES_BLOB_MUESTRAS'                      =>	empty($result[':C_IMAGENES_BLOB_MUESTRAS'])?null:$result[':C_IMAGENES_BLOB_MUESTRAS'],
        );  
    }
    #PDF RECHAZO
    public function load_info_rechazo($DATA){
        $this->db->trans_start();
        $param                  =       array(
                                            array( 
                                                'name'      =>  ':V_COD_EMPRESA',
                                                'value'     =>  $DATA["COD_EMPRESA"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':V_ID_HISTO',
                                                'value'     =>  $DATA["ID_HISTO"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':P_ANATOMIA_PATOLOGICA_MAIN',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_ANATOMIA_PATOLOGICA_MUESTRAS',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_AP_MUESTRAS_CITOLOGIA',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                            array( 
                                                'name'      =>  ':P_INFO_LOG_ADVERSOS',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                        );
        $result = $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_ANATOMIAPATOLOGICA_RECHAZ',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                                        =>	$this->db->trans_status(),
            'ID_HISTO'                                      =>	$DATA["ID_HISTO"],
            'COD_EMPRESA'                                   =>	$DATA["COD_EMPRESA"],
            'P_ANATOMIA_PATOLOGICA_MAIN'                    =>	empty($result[':P_ANATOMIA_PATOLOGICA_MAIN'])?null:$result[':P_ANATOMIA_PATOLOGICA_MAIN'],
            'P_ANATOMIA_PATOLOGICA_MUESTRAS'                =>	empty($result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'])?null:$result[':P_ANATOMIA_PATOLOGICA_MUESTRAS'],
            'P_AP_MUESTRAS_CITOLOGIA'                       =>	empty($result[':P_AP_MUESTRAS_CITOLOGIA'])?null:$result[':P_AP_MUESTRAS_CITOLOGIA'],
            'P_INFO_LOG_ADVERSOS'                           =>	empty($result[':P_INFO_LOG_ADVERSOS'])?null:$result[':P_INFO_LOG_ADVERSOS'],          
        );
    }
    
    #USUARIO EXTERNO + RCE
    public function MODEL_RECORD_ANATOMIA_PATOLOGICA_EXT($session,$accesdata){
        $this->db->trans_start();
        $PLZ_ETIQUETA_MEDIANA               =   [];
        $DATA_TEMPLATE                      =   $accesdata["DATA_TEMPLATE"][0]["DATA"];
        $ID_GESPAB                          =   $DATA_TEMPLATE["ID_GESPAB"];
        $numfichae                          =   $DATA_TEMPLATE["TEMPLATE_NUMFICHAE"];
        //$TEMPLATE_RUTPAC                  =   $DATA_TEMPLATE["TEMPLATE_RUTPAC"]; ;
        //$TEMPLATE_ID_PROFESIONAL          =   $DATA_TEMPLATE["TEMPLATE_ID_PROFESIONAL"];
        //$TEMPLATE_CALL_FROM               =   $DATA_TEMPLATE["TEMPLATE_CALL_FROM"];
        $empresa                            =   $DATA_TEMPLATE["TEMPLATE_EMPRESA"]===''?$this->session->userdata("COD_ESTAB"):$DATA_TEMPLATE["TEMPLATE_EMPRESA"];  
        $TEMPLATE_RUT_PROFESIONAL           =   $DATA_TEMPLATE["TEMPLATE_RUT_PROFESIONAL"];
        $TEMPLATE_IND_TIPO_BIOPSIA          =   $DATA_TEMPLATE["TEMPLATE_IND_TIPO_BIOPSIA"];
        $TEMPLATE_IND_ESPECIALIDAD          =   $DATA_TEMPLATE["TEMPLATE_IND_ESPECIALIDAD"];
        $TEMPLATE_PA_ID_PROCARCH            =   $DATA_TEMPLATE["TEMPLATE_PA_ID_PROCARCH"];
        $TEMPLATE_AD_ID_ADMISION            =   $DATA_TEMPLATE["TEMPLATE_AD_ID_ADMISION"];
        $TXT_DIAGNOSTICO                    =   $DATA_TEMPLATE["TXT_DIAGNOSTICO"];
        $TEMPLATE_PLANTILLA                 =   $DATA_TEMPLATE["TEMPLATE_PLANTILLA"];
        $V_BOOLEANO_CASSETTE                =   $DATA_TEMPLATE["TEMPLATE_USODECASSETTE"];
        $FORM_POST                          =   $DATA_TEMPLATE["TEMPLATE_INFOPOST"]; 
        $TEMPLATE_IND_ROTULADO              =   $DATA_TEMPLATE["TEMPLATE_IND_ROTULADO"];

        $TEMPLATE_IND_ROTULADO_SUB          =   $DATA_TEMPLATE["TEMPLATE_IND_ROTULADO_SUB"];
        

        $DATE_SOLICITUD                     =   $DATA_TEMPLATE["TEMPLATE_DATE_DMYHM"];   
        $TEMPLATE_DATE_SOLICITUD            =   $DATA_TEMPLATE["TEMPLATE_DATE_SOLICITUD"];
        $TEMPLATE_HRS_SOLICITUD             =   $DATA_TEMPLATE["TEMPLATE_HRS_SOLICITUD"];
        
        $template_ind_derivacion            =   $DATA_TEMPLATE["TEMPLATE_IND_DERIVACION"];
        $template_ind_sic                   =   $DATA_TEMPLATE["TEMPLATE_IND_ID_SIC"];
        
        
        #GESTION DE HORA
        /*
        if ($TEMPLATE_PA_ID_PROCARCH        == '63'){
            $arr_citacion                   =   $this->db->query("SELECT TO_CHAR(CI_FECCITACION,'DD-MM-YYYY HH24:MI') AS FEC_CITA FROM ADMIN.AE_TCITACION WHERE CI_ID_CITACION = ".$TEMPLATE_AD_ID_ADMISION);
            if(count($arr_citacion)>0){
                $DATE_SOLICITUD             =   $arr_citacion[0]["FEC_CITA"];
            } else {
                $DATE_SOLICITUD             =   date("d-m-Y H:i");
            }
        }
        */
        
        #DESDE FUERA CON LA HORA QUE SE REGISTRO
        if ($TEMPLATE_PA_ID_PROCARCH        == '65'){
            $DATE_SOLICITUD                 =   date("d-m-Y H:i");
        } else {
            $DATE_SOLICITUD                 =   date("d-m-Y H:i");
        }
        
        /*
        $AD_ID_ADMISION                     =   empty($DATA_TEMPLATE["AD_ID_ADMISION"])?'':$DATA_TEMPLATE["AD_ID_ADMISION"];
        $IND_TIPO_BIOPSIA                   =   $DATA_TEMPLATE["IND_TIPO_BIOPSIA"];
        $DATE_SOLICITUD                     =   $DATA_TEMPLATE["DATE_SOLICITUD"];
        $ID_SERDEP                          =   $DATA_TEMPLATE["ID_SERDEP"];
        $empresa                            =   $DATA_TEMPLATE["COD_EMPRESA"];
        */
        
        foreach($accesdata as $infObject => $Object){
            if($infObject == 'examenHispatologico'){
                //if(count($hispatologico)>0){
                    $dataSolicitud = array(
                     #'ID_SOLICITUD_HISTO'          =>  $ID_BIOPSIA,
                     #'ID_TABLA'                    =>  $id,
                        'NUM_FICHAE'                =>  $numfichae,
                        'COD_USRCREA'               =>  $session,
                        'FEC_USRCREA'               =>  'SYSDATE',
                        'COD_EMPRESA'               =>  $empresa,
                        'COD_RUTPRO'                =>  $TEMPLATE_RUT_PROFESIONAL,
                        'IND_ESTADO'                =>  1,//SOLICITUD VALIDA
                        'ID_HISTO_ESTADO'           =>  1,//SOLICITUD DE ENTRADA
                        //'DATE_INICIOREGISTRO'     =>  "TO_DATE('".$TEMPLATE_DATE_SOLICITUD.' '.$TEMPLATE_HRS_SOLICITUD."','DD-MM-YYYY hh24:mi')",
                        'DATE_INICIOREGISTRO'       =>  "TO_DATE('".$DATE_SOLICITUD."','DD-MM-YYYY hh24:mi')",
                        'IND_TEMPLATE'              =>  1,
                        'IND_TIPO_BIOPSIA'          =>  $TEMPLATE_IND_TIPO_BIOPSIA,
                        'PA_ID_PROCARCH'            =>  $TEMPLATE_PA_ID_PROCARCH,
                        'ID_SERDEP'                 =>  $TEMPLATE_IND_ESPECIALIDAD,
                        'AD_ID_ADMISION'            =>  $TEMPLATE_AD_ID_ADMISION,
                        'TXT_DIAGNOSTICO'           =>  $TXT_DIAGNOSTICO,
                        'NUM_PLANTILLA'             =>  $TEMPLATE_PLANTILLA,
                        'IND_USOCASSETTE'           =>  $V_BOOLEANO_CASSETTE,
                        'IND_INFOPOST'              =>  $FORM_POST,
                        'ID_ROTULADO'               =>  $TEMPLATE_IND_ROTULADO,
                        'ID_ROTULADO_SUB'           =>  $TEMPLATE_IND_ROTULADO_SUB
                    );
                    
                    
                    #RESUELVE INTERCONSULTA
                    if ($template_ind_derivacion    ==  1){
                        $dataSolicitud              =   array_merge($dataSolicitud,array(
                            "IND_DERIVACION_IC"     =>  1,
                            "ID_SIC"                =>  $template_ind_sic,
                        )); 
                        #CAMBIAR ESTADO DE LA INTERCONSULTAS
                        
                        
                        
                        
                    }
                    if($ID_GESPAB!=''){
                        $dataSolicitud                                          =   array_merge($dataSolicitud,array("ID_TABLA"=>$ID_GESPAB)); 
                    }
                    //**************************************************************************************************************************************************
                    #IDENTIFICAR QUE TEMPLATE ES                               :   IND_TEMPLATE                :   0 Y 1 // DEFAULT 0 //
                    #TIPO DE MUESTRA DE BIOPSIA                                :   IND_TIPO_BIOPSIA            :   
                    #FECHA DE SOLICITUD                                        :   DATE_INICIOREGISTRO         :   TABLA A PARTE CON HISTORIAL DE CADA MOVIMIENTO Y PROFESIONAL A CARGO.
                    #********** LOS FK ********************************************************************************************************************************
                    #COD_RUTPRO (GG_TPROFESIONAL)
                    #ID_PROFESIONAL (GG_TPROFESIONAL)                          :   ID_PROFESIONAL              :   
                    #CODIGO SISTEMA (SS_TSISTEMAS)                             :   PA_ID_PROCARCH              :   (SIDRA ANATOMIA PATOLOGICA : 65) (PABELLON : 31)
                    #SERVICIO DE LA SOLICITUD (GG_TSERVICIO)                   :   ID_SERDEP                   :   DEFAULT PABELLON
                    #REGISTRO ELECTRONICO (SO_TECITAS)                         :   NUM_CORREL + COD_EMPRESA    :   
                    //**************************************************************************************************************************************************
                    if(isset($Object[0]['listadoHISPATO'])){
                        $hispatologico                                               =   $Object[0]['listadoHISPATO'];
                        foreach ($hispatologico as $i => $datos){
                            if ($datos['name']=='slc_ind_cancer')                    {   $dataSolicitud    =     array_merge($dataSolicitud,array("IND_NOTIF_CANCER"      =>  quotes_to_entities($datos['value']))); }
                            if ($datos['name']=='bio_extraInput')                    {   $dataSolicitud    =     array_merge($dataSolicitud,array("DES_SITIOEXT"          =>  quotes_to_entities($datos['value']))); }
                            if ($datos['name']=='bio_ubicaInput')                    {   $dataSolicitud    =     array_merge($dataSolicitud,array("DES_UBICACION"         =>  quotes_to_entities($datos['value']))); }
                            if ($datos['name']=='bio_tamannoInput')                  {   $dataSolicitud    =     array_merge($dataSolicitud,array("DES_TAMANNO"           =>  quotes_to_entities($datos['value']))); }
                            //P.ID_TIPO_LESION,ID_ASPECTO,P.ID_ANT_PREVIOS,P.NUM_ANTECEDENTES,
                            if ($datos['name']=='bio_lesionSelect')                  {   $dataSolicitud    =     array_merge($dataSolicitud,array("ID_TIPO_LESION"        =>  $datos['value'])); }
                            if ($datos['name']=='bio_aspectoSelect')                 {   $dataSolicitud    =     array_merge($dataSolicitud,array("ID_ASPECTO"            =>  $datos['value'])); }
                            // falta agregar al formulario
                            if ($datos['name']=='bio_ant_previosSelect')             {   $dataSolicitud    =     array_merge($dataSolicitud,array("ID_ANT_PREVIOS"        =>  $datos['value'])); }
                            if ($datos['name']=='bio_ant_nMuestasSelect')            {   $dataSolicitud    =     array_merge($dataSolicitud,array("NUM_ANTECEDENTES"      =>  $datos['value'])); }
                            // fin falta agregar al formulario
                            if ($datos['name']=='bio_des_BiopsiaInput')              {   $dataSolicitud    =     array_merge($dataSolicitud,array("DES_BIPSIA"            =>  quotes_to_entities($datos['value']))); }
                            if ($datos['name']=='bio_des_CitologiaInput')            {   $dataSolicitud    =     array_merge($dataSolicitud,array("DES_CITOLOGIA"         =>  quotes_to_entities($datos['value']))); }
                            if ($datos['name']=='bio_observTextarea')                {   $dataSolicitud    =     array_merge($dataSolicitud,array("DES_OBSERVACIONES"     =>  quotes_to_entities($datos['value']))); }
                            if ($datos['name']=='bio_des_tipodemuestra')             {   $dataSolicitud    =     array_merge($dataSolicitud,array("DES_TIPOMUESTRA"       =>  quotes_to_entities($datos['value']))); }
                            if ($datos['name']=='bio_subnumeracion')                 {   $dataSolicitud    =     array_merge($dataSolicitud,array("NUM_SUBNUMERACION"     =>  $datos['value'])); }
                            //if ($datos['name']=='fechaHoraFinal')                  {   $fecha_sol        =     "TO_DATE('".$From['value']."', 'DD-MM-YYYY hh24:mi')"; }
                            //if ($datos['name']=='profesional')                     {   $cod_respo        =     $datos['value']; }
                       }
                    }
                    
                    //**********************************************************
                    //SOLO GESPAB
                    if($TEMPLATE_PA_ID_PROCARCH == '31' || $TEMPLATE_PA_ID_PROCARCH == '36'){
                        //admision?
                        $arr_data                                               =   $ID_GESPAB==''?[]:$this->db->query("SELECT AP.ID_SOLICITUD_HISTO FROM PABELLON.PB_SOLICITUD_HISTO AP WHERE AP.ID_TABLA=".$ID_GESPAB." ORDER BY AP.ID_SOLICITUD_HISTO")->result_array();
                        if(count($arr_data)>0){
                            $ID_BIOPSIA                                         =   $arr_data[0]["ID_SOLICITUD_HISTO"];
                            $this->db->where('ID_SOLICITUD_HISTO',$ID_BIOPSIA); 
                            $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',$dataSolicitud);
                        } else {
                            $ID_BIOPSIA                                         =   $this->db->sequence($this->ownPab,'SEQ_SOLICITUD_HISTO');
                            $dataSolicitud                                      =   array_merge($dataSolicitud,array("ID_SOLICITUD_HISTO"=>$ID_BIOPSIA)); 
                            $this->db->insert($this->ownPab.'.PB_SOLICITUD_HISTO',$dataSolicitud);  
                        }
                    } else {
                        $arr_data                                               =   $TEMPLATE_AD_ID_ADMISION==''?[]:$this->db->query("SELECT AP.ID_SOLICITUD_HISTO FROM PABELLON.PB_SOLICITUD_HISTO AP WHERE AP.AD_ID_ADMISION=".$TEMPLATE_AD_ID_ADMISION." ORDER BY AP.ID_SOLICITUD_HISTO")->result_array();
                        if(count($arr_data)>0){
                            $ID_BIOPSIA                                         =   $arr_data[0]["ID_SOLICITUD_HISTO"];
                            $this->db->where('ID_SOLICITUD_HISTO',$ID_BIOPSIA); 
                            $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',$dataSolicitud);
                        } else {
                            $ID_BIOPSIA                                         =   $this->db->sequence($this->ownPab,'SEQ_SOLICITUD_HISTO');
                            $dataSolicitud                                      =   array_merge($dataSolicitud,array("ID_SOLICITUD_HISTO"=>$ID_BIOPSIA)); 
                            $this->db->insert($this->ownPab.'.PB_SOLICITUD_HISTO',$dataSolicitud);  
                        }
                    }
                    //**********************************************************
                    
                    
                    //*************MUESTARS A CERO******************************
                    $this->db->where('ID_SOLICITUD_HISTO',$ID_BIOPSIA); 
                    $this->db->where_in('IND_TIPOMUESTRA',array('1','2')); 
                    $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array('IND_ESTADO'=> '0','USR_AUDITA'=> $session,'USR_AUDITA'=>'SYSDATE'));
                    //*************MUESTARS A CERO******************************
                    
                    if(isset($Object[0]['numero_muestas'])){
                        //************ NUMEROS DE MUESTRAS *********************
                        /*
                        $array_MUESTRAS_0                           =   array('IND_ESTADO'=> '0','USR_AUDITA'=> $session,'USR_AUDITA'=>'SYSDATE');
                        $this->db->where('ID_SOLICITUD_HISTO',$ID_BIOPSIA); 
                        $this->db->where('IND_TIPOMUESTRA',1); 
                        $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',$array_MUESTRAS_0);
                        */
                        //************ NUMEROS DE MUESTRAS *********************
                        $numero_muestas                             =   $Object[0]['numero_muestas'];
                        if(count($numero_muestas)>0){
                            foreach($numero_muestas as $i => $row){
                                $ARR_MUESTRA                        =   is_null($row['N_MUESTRA'])?$i+1:$row['N_MUESTRA'];
                                $NUMERO_MUESTRA                     =   array(
                                    'N_MUESTRA'                     =>  $ARR_MUESTRA,
                                    'TXT_MUESTRA'                   =>  substr($row['TXT_MUESTRA'],0,51),
                                    'IND_ESTADO'                    =>  '1',
                                    'IND_ETIQUETA'                  =>  $row['IND_ETIQUETA'],
                                    'NUM_CASSETTE'                  =>  $row['IND_NUMCASSETTE'],
                                    'IND_TIPOMUESTRA'               =>  1,
                                );
                                //***********************************************************************************
                                //********** $ID_BIOPSIA ************************************************************
                                //********** $ID_NMUESTA_AP *********************************************************
                                //********** $row['IND_NUMCASSETTE'] ************************************************
                                //********** $ID_CASETE = $this->db->sequence($this->ownPab,'SEQ_NUM_AP_CASETE'); ***
                                //***********************************************************************************
                                if($V_BOOLEANO_CASSETTE     ==  1){
                                    $id_casete                      =   $this->db->query("
                                                                                            SELECT 
                                                                                                AP.ID_CASETE AS ID_CASETE
                                                                                            FROM 
                                                                                                PABELLON.PB_HISTO_NMUESTRAS AP 
                                                                                            WHERE 
                                                                                                AP.NUM_CASSETTE       = ".$row['IND_NUMCASSETTE']." 
                                                                                            AND 
                                                                                                AP.ID_SOLICITUD_HISTO = ".$ID_BIOPSIA." 
                                                                                            AND 
                                                                                                AP.ID_CASETE IS NOT NULL 
                                                                                            ORDER BY 
                                                                                                AP.ID_SOLICITUD_HISTO
                                                                                        ")->result_array();
                                    $ID_CASETE                      =   count($id_casete)>0?$id_casete[0]['ID_CASETE']:$this->db->sequence($this->ownPab,'SEQ_NUM_AP_CASETE');
                                } else {
                                    $ID_CASETE                      =   0;
                                }
                                
                                if(($row['ID_NMUESTRA']=='')||($row['ID_NMUESTRA']==null)){
                                    $ID_NMUESTA_AP              =   $this->db->sequence($this->ownPab,'SEQ_HISTO_NUMNUESTRAS');
                                    $NUMERO_MUESTRA             =   array_merge($NUMERO_MUESTRA,array(
                                        "ID_NMUESTRA"           =>  $ID_NMUESTA_AP,
                                        'ID_SOLICITUD_HISTO'    =>  $ID_BIOPSIA,
                                        'USR_CREA'              =>  $session,
                                        'DATE_CREA'             =>  'SYSDATE',
                                        'ID_CASETE'             =>  $ID_CASETE,
                                    ));
                                    $this->db->insert($this->ownPab.'.PB_HISTO_NMUESTRAS',$NUMERO_MUESTRA);
                                } else {
                                    $NUMERO_MUESTRA             =   array_merge($NUMERO_MUESTRA,array(
                                        'USR_AUDITA'            =>  $session,
                                        'DATE_AUDITA'           =>  'SYSDATE',
                                        'ID_CASETE'             =>  $ID_CASETE,
                                    )); 
                                    $this->db->where('ID_NMUESTRA',$row['ID_NMUESTRA']); 
                                    $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',$NUMERO_MUESTRA);
                                }
                            }
                        }
                    }
                    //**********************************************************
                    if(isset($Object[0]['arr_citologia'])){
                        //**************** NUMEROS DE MUESTRAS *****************
                        /*
                        $array_MUESTRAS_0 = array('IND_ESTADO'=>'0','USR_AUDITA'=> $session,'USR_AUDITA'=>'SYSDATE');
                        $this->db->where('ID_SOLICITUD_HISTO',$ID_BIOPSIA); 
                        $this->db->where('IND_TIPOMUESTRA',2); 
                        $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',$array_MUESTRAS_0);
                        */
                        //**************** NUMEROS DE MUESTRAS *****************
                        $arr_citologia                          =   $Object[0]['arr_citologia'];
                        if(count($arr_citologia)>0){
                            foreach ($arr_citologia as $i => $row){
                                $NUMERO_CITOLGIA                =   array(
                                    'N_MUESTRA'                 =>  $row['N_MUESTRA'],
                                    'TXT_MUESTRA'               =>  substr($row['TXT_MUESTRA'], 0, 51),
                                    'IND_ESTADO'                =>  '1',
                                    'IND_ETIQUETA'              =>  $row['IND_ETIQUETA'],
                                    'NUM_ML'                    =>  str_replace('.',',',$row['NUM_ML']),
                                    'IND_TIPOMUESTRA'           =>  2,
                                    'ID_SOLICITUD_HISTO'        =>  $ID_BIOPSIA,
                                );
                                $ID_NMUESTA_AP                  =   '';
                                if($row['ID_NMUESTRA']!=null){
                                    $ID_NMUESTA_AP              =   $row['ID_NMUESTRA'];
                                    $NUMERO_CITOLGIA            =   array_merge($NUMERO_CITOLGIA,array("USR_AUDITA"=>$session,"DATE_AUDITA"=>'SYSDATE')); 
                                    $this->db->where('ID_NMUESTRA',$row['ID_NMUESTRA']); 
                                    $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',$NUMERO_CITOLGIA);
                                } else {
                                    $ID_NMUESTA_AP              =   $this->db->sequence($this->ownPab,'SEQ_HISTO_NUMNUESTRAS');
                                    $NUMERO_CITOLGIA            =   array_merge($NUMERO_CITOLGIA,array("ID_NMUESTRA"    =>  $ID_NMUESTA_AP)); 
                                    $NUMERO_CITOLGIA            =   array_merge($NUMERO_CITOLGIA,array("USR_CREA"       =>  $session)); 
                                    $NUMERO_CITOLGIA            =   array_merge($NUMERO_CITOLGIA,array("DATE_CREA"      =>  'SYSDATE')); 
                                    $this->db->insert($this->ownPab.'.PB_HISTO_NMUESTRAS',$NUMERO_CITOLGIA);
                                }
                            }
                        }  
                    }
                //}
            }
        }
        $this->db->trans_complete();
        return array(
            'STATUS'                        =>  true,
            'ID_ANATOMIA'                   =>  $ID_BIOPSIA,
            'GET_PLZ'                       =>  $PLZ_ETIQUETA_MEDIANA,
        );
    }
    
    public function zpl_nuemero_muestra($ID_NMUESTA_AP){
        $VAL_ZPL                                =   'HTML ->'.$ID_NMUESTA_AP;
        return $VAL_ZPL;
    }

    public function get_hoja_faph($valiable){
        $this->db->trans_start();
        $param  =   array(
                            array( 
                                'name'	=>  ':VAL_FAP_IDCORREL',
                                'value'	=>  $valiable,
                                'length'=>  20,
                                'type'	=>  SQLT_CHR 
                            ),
                            array( 
                                'name'	=>  ':P_RETURN_DATA',
                                'value'	=>  $this->db->get_cursor(),
                                'length'=>  -1,
                                'type'	=>  OCI_B_CURSOR
                            ),
                            array( 
                                'name'	=>  ':P_HISTORIAL',
                                'value'	=>  $this->db->get_cursor(),
                                'length'=>  -1,
                                'type'	=>  OCI_B_CURSOR
                            ),
                            array( 
                                'name'	=>  ':P_STATUS',
                                'value'	=>  $this->db->get_cursor(),
                                'length'=>  -1,
                                'type'	=>  OCI_B_CURSOR
                            ),
                        );
        try { 
	    $result     =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_HOJA_FAPH','CONSULTA_HOJA',$param);
	    if(empty($result)) {
		//throw new Exception('sin datos devueltos');
		$result =   null;
	    }
	} catch (Exception $e) {
	    $return['INFO_RESUL']	    =   false;
	    $return['MSJ_ERROR']	    =   var_dump($e->getMessage());
	    return $return;
	}
	$this->db->trans_complete();
        return array(
			'STATUS'	    =>	$this->db->trans_status(),
			'P_RETURN_DATA'     =>	$result[':P_RETURN_DATA'],
                        'P_HISTORIAL'       =>	$result[':P_HISTORIAL'],
                        'P_STATUS'          =>	$result[':P_STATUS'],
    		    );
    }
    
    public function model_ultimo_numero_disponible($valiable){
        $this->db->trans_start();
        $param  =   array(
                            array( 
                                'name'      =>  ':V_COD_EMPRESA',
                                'value'     =>  $valiable["val_empresa"],
                                'length'    =>  20,
                                'type'      =>  SQLT_CHR 
                            ),
                            array( 
                                'name'      =>  ':IND_TIPO_BIOPSIA',
                                'value'     =>  $valiable["ind_tipo_biopsia"],
                                'length'    =>  20,
                                'type'      =>  SQLT_CHR 
                            ),
                            array( 
                                'name'      =>  ':P_ULTIMO_NUMERO',
                                'value'     =>  $this->db->get_cursor(),
                                'length'    =>  -1,
                                'type'      =>  OCI_B_CURSOR
                            ),
                            array( 
                                'name'      =>  ':P_STATUS',
                                'value'     =>  $this->db->get_cursor(),
                                'length'    =>  -1,
                                'type'      =>  OCI_B_CURSOR
                            ),
                        );
        $result             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_LAST_NUMERO3',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'	    =>	$this->db->trans_status(),
            'DATA'          =>  $result,
            'DATA_NUMBER'   =>  $result[':P_ULTIMO_NUMERO'],
            'P_STATUS'      =>  $result[':P_STATUS'],
        );
    }
    
    
    public function model_ultimo_numero_disponible_citologia($valiable){
        $this->db->trans_start();
        $param          =   array(
                            array( 
                                'name'      =>  ':V_COD_EMPRESA',
                                'value'     =>  $valiable["val_empresa"],
                                'length'    =>  20,
                                'type'      =>  SQLT_CHR 
                            ),
                            array( 
                                'name'      =>  ':IND_TIPO_BIOPSIA',
                                'value'     =>  $valiable["ind_tipo_biopsia"],
                                'length'    =>  20,
                                'type'      =>  SQLT_CHR 
                            ),
                            array( 
                                'name'      =>  ':P_ULTIMO_NUMERO',
                                'value'     =>  $this->db->get_cursor(),
                                'length'    =>  -1,
                                'type'      =>  OCI_B_CURSOR
                            ),
                            array( 
                                'name'      =>  ':P_STATUS',
                                'value'     =>  $this->db->get_cursor(),
                                'length'    =>  -1,
                                'type'      =>  OCI_B_CURSOR
                            ),
                        );
        $result             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_LAST_NUMERO_CITOLOGIA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'	    =>	$this->db->trans_status(),
            'DATA'          =>  $result,
            'DATA_NUMBER'   =>  $result[':P_ULTIMO_NUMERO'],
            'P_STATUS'      =>  $result[':P_STATUS'],
        );
    }
    
    
    public function model_gestion_tomamuestraxuser($valiable){
        $this->db->trans_start();
        $param              =   array(
                                    array( 
                                        'name'      =>  ':V_COD_EMPRESA',
                                        'value'     =>  $valiable["val_empresa"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':P_ALL_TOMAS_MUESTRA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_STATUS',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                );
        $result             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_USERXTOMAMUESTRA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'	    =>	$this->db->trans_status(),
            'DATA'          =>  $result,
        );
    }
    
    
    public function model_asignacion_muestra_x_user($valiable){
        $this->db->trans_start();
        $param              =   array(
                                    array( 
                                        'name'      =>  ':V_COD_EMPRESA',
                                        'value'     =>  $valiable["val_empresa"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_RUT_PROFESIONAL',
                                        'value'     =>  $valiable["rut_profesional"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':P_INFO_PROFESIONAL',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_ALL_TOMAS_MUESTRA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_USER_TOMA_MUESTRA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_STATUS',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                );
        $result             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_GESTION_USERXANATOMIA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'	    =>	$this->db->trans_status(),
            'DATA'          =>  $result,
        );
    }
    

    public function model_record_rotulos_por_usuario($data){
        $this->db->trans_start();
        $COD_RUTPRO         =   $data['ind_proesional']['COD_RUTPRO'];
        $ID_PRO             =   $data['ind_proesional']['ID_PRO'];
        //all cero
        $this->db->where('COD_RUTPRO',$COD_RUTPRO); 
        $this->db->update($this->ownPab.'.PB_ROTULOXPROFESIONAL',array('IND_ESTADO'=>'0','DATE_AUDITA'=>'SYSDATE','USER_AUDITA'=>$data['session']));
        if(count($data["ind_servicios"])>0){
            foreach($data["ind_servicios"] as $i => $row){
                $array      =   $this->db->query("SELECT P.ID_ROTULOXPROFESIONAL FROM PABELLON.PB_ROTULOXPROFESIONAL P WHERE P.ID_ROTULADO IN ($row) AND P.COD_RUTPRO IN ($COD_RUTPRO) ")->result_array();
                if(count($array)>0){
                    $this->db->where('ID_ROTULOXPROFESIONAL',$array[0]['ID_ROTULOXPROFESIONAL']); 
                    $this->db->update($this->ownPab.'.PB_ROTULOXPROFESIONAL',array('IND_ESTADO'=>'1','DATE_AUDITA'=>'SYSDATE','USER_AUDITA'=>$data['session']));
                } else {
                    $dataPreg1                      =   array(
                        "ID_ROTULOXPROFESIONAL"     =>  $this->db->sequence($this->ownPab,'SEQ_TOMA_MUESTRA_X_USUARIO'),
                        "ID_ROTULADO"               =>  $row,
                        "ID_PROFESIONAL"            =>  $ID_PRO,
                        "COD_RUTPRO"                =>  $COD_RUTPRO,
                        "IND_ESTADO"                =>  1,
                        "USER_CREA"                 =>  $data['session'],
                        "DATE_CREA"                 =>  'SYSDATE'
                    );
                    $this->db->insert($this->ownPab.'.PB_ROTULOXPROFESIONAL', $dataPreg1);
                }
            }
        }
        $this->db->trans_complete();
        return array(
            'STATUS'	    =>	$this->db->trans_status(),
            'DATA'          =>  $data,
        );
    }

   
    #GET      
    public function get_html_anatomia(){
        $sQuery = "
            SELECT 
                IND_TIPOATENCION, 
                DES_TIPOATENCION 
            FROM 
                ADMIN.AP_TTIPOATENCION 
            WHERE 
                IND_ESTADO  IN  ('V')  ";
            $var        =   '';
            $var        .=  '<span style="color: #FF9800;">* </span><label class="control-label">TIPO PROFESIONAL</label>';
            $var        .=  '<select class="form-control" name="tprof" id="tprof" onchange="CARGAPROF();" required>';
            $var        .=  '<option>SELECCIONE EL TIPO DE PROFESIONAL</option>';
            $array      =   $this->db->query($sQuery)->result_array();
            if (count($array)>0){
                foreach ($array as $val) {
                    $var .= '<option value="' . $val['IND_TIPOATENCION'] . '"> ' . $val['DES_TIPOATENCION'] . '</option>';
                }
            }
            $var .= "</select>";
            return $var;
    }
    
    #LIBRO DE BIOPSIA
    /*
    $dataPreg1                                  =   array(     
        //'LB_ID'                               =>  $SEQ_BS_LIBRO_BIOPSIA,
        'ID_SOLICITUD_HISTO'                    =>  $ID_BIOPSIA,
        'NUM_FICHAE'                            =>  $numfichae,
        //'ID_TABLA'                            =>  $id,
        //'LB_N_MUESTRAS'                       =>  $SL_cant_muestras,
        //'LB_TIPOMUESTRA'                      =>  $SL_tipo_muestra,
        'LB_FECHA_TOMAMUESTRA'                  =>  "TO_DATE('".$DATA_SOLICITUD_ANATOMIA."', 'DD-MM-YYYY hh24:mi')",//fecha de la operacion 
        //'LB_POLIPECTOMIA'                     =>  $SL_polipectomia,
        //'LB_EDA_EDB'                          =>  $sl_EDAEDB,
        'LB_RUT_MED_TRATANTE'                   =>  $cod_respo,//rut del primer cirijano
        //'LB_RUT_PABELLONERA'                  =>  $RUT_TENS_RESPONSABLE_0,//LB_RUT_TENS_RESPONSABLE
        //'LB_FECHA_ALMACENAMIENTO'             =>  $txt_fec_ALMACENAMIENTO,
        //'LB_RUT_PROF_ALMACENA'                =>  $RUT_PROF_ALMACENA_0,               
        //'LB_PROF_TRASLADA'                    =>  $RUT_PROF_TRASLADA_0,
        'LB_IND_ESTADO'                         =>  1,
        'LB_FEC_CREA'                           =>  'SYSDATE',
        'LB_USRCREA'                            =>  $session,
        'LB_EMPRESA'                            =>  $empresa,
        'LB_NOTAS'                              =>  '',
        'PA_ID_PROCARCH'                        =>  '31',
    );
    $query2                                     =   $this->db->query("SELECT B.LB_ID AS ID_LBIOP FROM ADMIN.BS_LIBRO_BIOPSIA B WHERE ID_SOLICITUD_HISTO=".$ID_BIOPSIA);
    $arr_lib                                    =   $query2->result_array();
    if(count($arr_lib)>0){
        $this->db->where('LB_ID',$arr_lib[0]['ID_LBIOP']); 
        $this->db->update($this->own.'.BS_LIBRO_BIOPSIA',$dataPreg1);
    } else {
        $dataPreg1                          =   array_merge($dataPreg1, array("LB_ID" => $this->db->sequence($this->own,'SEQ_BS_LIBRO_BIOPSIA') )); 
        $this->db->insert($this->own.'.BS_LIBRO_BIOPSIA', $dataPreg1);
    }
    */
    
    /*
     * if(($row['ID_NMUESTRA']=='')||($row['ID_NMUESTRA']==null)){
                                    $ID_NMUESTA_AP              =   $this->db->sequence($this->ownPab,'SEQ_HISTO_NUMNUESTRAS');
                                    $NUMERO_MUESTRA             =   array_merge($NUMERO_MUESTRA,array(
                                        "ID_NMUESTRA"           =>  $ID_NMUESTA_AP,
                                        'ID_SOLICITUD_HISTO'    =>  $ID_BIOPSIA,
                                        'USR_CREA'              =>  $session,
                                        'DATE_CREA'             =>  'SYSDATE',
                                        'ID_CASETE'             =>  $ID_CASETE,
                                    ));
                                    $this->db->insert($this->ownPab.'.PB_HISTO_NMUESTRAS',$NUMERO_MUESTRA);
                                } else {
                                    $NUMERO_MUESTRA             =   array_merge($NUMERO_MUESTRA,array(
                                        'USR_AUDITA'            =>  $session,
                                        'DATE_AUDITA'           =>  'SYSDATE',
                                        'ID_CASETE'             =>  $ID_CASETE,
                                    )); 
                                    $this->db->where('ID_NMUESTRA',$row['ID_NMUESTRA']); 
                                    $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',$NUMERO_MUESTRA);
                                }
    */

    public function valida_cuenta_esissan_anatomia($data_controller){
        $this->db->trans_start();
        $param          =   array(
                                #IN 
                                array( 
                                    'name'      =>  ':V_OPCION',
                                    'value'     =>  $data_controller['ind_opcion'],
                                    'length'    =>  50,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_EMPRESA',
                                    'value'     =>  $data_controller['empresa'],
                                    'length'    =>  50,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_RUN',
                                    'value'     =>  $data_controller['run'],
                                    'length'    =>  50,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_DV',
                                    'value'     =>  $data_controller['dv'],
                                    'length'    =>  50,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':C_GETUSERS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                #out cursores
                                array( 
                                    'name'      =>  ':C_PRIVILEGIOS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_PRIVILEGIOS_USER',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_ESTABLECIMIENTOS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_ESTABLECIMIENTOS_USER',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_PTO_ENREGA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_PTO_ENREGA_USER',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_LOGS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_CUENTAS_ESISSAN','LOAD_GESTION_USUARIOS',$param);
        $this->db->trans_complete();
        return array(
            'return_bd'                         =>  $result,
        );
    }
    
    public function grabaUsu($user,$nombres,$apepate,$apemate,$email,$pass,$arrPrivilegios,$arrEmpresas,$uID,$changePw,$activo,$superUser,$actualiza_pass,$arr_fe_user) {
        $this->db->trans_start();
        
        $rut            =   explode('-', $user);
        $rutS           =   $rut[0];
        $rutDV          =   $rut[1];
        $name           =   $nombres . ' ' . $apepate . ' ' . $apemate;


        $query0         =   $this->db->query("select USERNAME FROM $this->ownGu.FE_USERS WHERE ID_UID = ".$uID);
        $query0         =   $query0->result_array();

        if ($query0) {
            //Edita si Existe el Usuario
            $dataUp     =   array(
                'FIRST_NAME'            =>  $nombres,
                'MIDDLE_NAME'           =>  $apepate,
                'LAST_NAME'             =>  $apemate,
                'EMAIL'                 =>  $email,
                'NAME'                  =>  $name,
                'DISABLE'               =>  $activo,
                'STATUS'                =>  $superUser,
                'TX_INTRANETSSAN_RUN'   =>  $rutS,
                'TX_INTRANETSSAN_DV'    =>  $rutDV
            );
            if ($actualiza_pass == 1) {
                $this->db->set('PASSWORD', $pass);
                $this->db->set('LOCKTODOMAIN', $pass);
                $this->db->set('DAYLIGHT', 1);
            }
            $this->db->where('ID_UID', $uID);
            $this->db->update($this->ownGu . '.FE_USERS', $dataUp);

        } else {
            //Crea nuevo Usuario


            $uID                        =   $this->db->sequence($this->ownGu, 'SEQ_FE_USERS');
            $dataUs                     =   array(
                'ID_UID'                =>  $uID,
                'USERNAME'              =>  strtoupper($user),
                'FIRST_NAME'            =>  $nombres,
                'MIDDLE_NAME'           =>  $apepate,
                'LAST_NAME'             =>  $apemate,
                'EMAIL'                 =>  $email,
                'TELEPHONE'             =>  0,
                'PASSWORD'              =>  $pass,
                'LOCKTODOMAIN'          =>  $pass,
                'DISABLE'               =>  $activo,
                'NAME'                  =>  $name,
                'STATUS'                =>  $superUser,
                'TX_INTRANETSSAN_RUN'   =>  $rutS,
                'TX_INTRANETSSAN_DV'    =>  $rutDV,
                'DAYLIGHT'              =>  1
            );
            $this->db->insert($this->ownGu . '.FE_USERS', $dataUs);

            
        }


        $this->db->set('IND_ESTADO',0);
        $this->db->where('ID_UID',$uID);
        $this->db->update($this->ownGu.'.GU_TUSUTIENEPER');

        
        for ($i = 0; $i < count($arrPrivilegios); $i++) {
            $idPer      =   $arrPrivilegios[$i]["vDestino"];
            $queryRes   =   $this->db->query("SELECT ID_UTP FROM $this->ownGu.GU_TUSUTIENEPER WHERE PER_ID IN (".$idPer.") AND ID_UID  = ".$uID);
            $queryRes   =   $queryRes->result_array();
            if ($queryRes){
                //Edita Privilegios Existentes
                $this->db->set('IND_ESTADO', 1);
                $this->db->where('ID_UTP', $queryRes[0]['ID_UTP']);
                $this->db->update($this->ownGu . '.GU_TUSUTIENEPER');
            } else {
                //Inserta Nuevos Privilegios 
                $idSeqPriv = $this->db->sequence($this->ownGu, 'SEQ_GU_TUSUTIENEPER');
                $dataUsuPer[$i]     =   array(
                    'ID_UTP'        =>  $idSeqPriv,
                    'ID_UID'        =>  $uID,
                    'PER_ID'        =>  $arrPrivilegios[$i]["vDestino"],
                    'IND_ESTADO'    =>  1,
                );
                $this->db->insert($this->ownGu . '.GU_TUSUTIENEPER', $dataUsuPer[$i]);
            }
        }

        //Actualiza o Agrega Nuevas Empresas al Usuario
        $this->db->set('IND_ESTADO', 0);
        $this->db->where('ID_UID', $uID);
        $this->db->update($this->ownGu . '.GU_TUSUXEMPRESA');
        for ($i = 0; $i < count($arrEmpresas); $i++) {
            $idEmp          =   $arrEmpresas[$i]["vDestinoEstab"];
            $queryResD      =   $this->db->query("SELECT ID_UXE FROM $this->ownGu.GU_TUSUXEMPRESA WHERE COD_ESTABL IN (".$idEmp.") AND ID_UID = ".$uID);
            $queryResD      =   $queryResD->result_array();
            if ($queryResD) {
                //Edita Establecimientos Existentes
                $this->db->set('IND_ESTADO', 1);
                $this->db->where('ID_UXE', $queryResD[0]['ID_UXE']);
                $this->db->update($this->ownGu . '.GU_TUSUXEMPRESA');
            } else {
                //Inserta Nuevos Establecimientos 
                $idSeqEmp = $this->db->sequence($this->ownGu, 'SEQ_GU_TUSUXEMPRESA');
                $dataUsuEmpr[$i]    =   array(
                    'ID_UXE'        =>  $idSeqEmp,
                    'ID_UID'        =>  $uID,
                    'COD_ESTABL'    =>  $arrEmpresas[$i]["vDestinoEstab"],
                    'IND_ESTADO'    =>  1
                );
                $this->db->insert($this->ownGu . '.GU_TUSUXEMPRESA', $dataUsuEmpr[$i]);
            }
        }
        
        /*
        #HISTORIAL
        $data_histo                 =   array(
            'ID_HISUSER'            =>  $this->db->sequence($this->ownGu, 'SEQ_FE_HISUSER'),
            'DATE_CREA'             =>  'SYSDATE',
            'IND_ESTADO'            =>  '1',
            'USERNAME_SESION'       =>  $this->session->userdata("USERNAME"),
            'COD_ESTAB'             =>  $this->session->userdata("COD_ESTAB"),
            'ID_UID_EDITADO'        =>  $uID,
            'ID_UID_FIRMA'          =>  $arr_fe_user->ID_UID,
        );
        $this->db->insert($this->ownGu . '.FE_HISUSER', $data_histo);
        */

        $this->db->trans_complete();
        return $this->db->trans_status();
    }


    public function get_cambio_fecha($DATA){
        $this->db->trans_start();
        $param          =   array(
                                #DATA IN
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["cod_empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_PASS',
                                    'value'     =>  $DATA["pass"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_ID',
                                    'value'     =>  $DATA["id"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_NEWFECHA',
                                    'value'     =>  $DATA["fecha"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_SESSION',
                                    'value'     =>  explode("-",$this->session->userdata("USERNAME"))[0],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #CURSORES OUT
                                array( 
                                    'name'      =>  ':C_HISTO_LOGS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','UPDATE_FECHA_TOMADA',$param);
        $this->db->trans_complete();
        return array(
            'status'                            =>  true,
            'data_bd'                           =>  $result,
        );
    }


    public function record_newsubpunto_tomamuestra($aData){
        $this->db->trans_start();
        $id_unico = $this->db->sequence($this->own,'SEQ_INFOROTULADO_SUB');
        $this->db->insert($this->ownPab.'.PB_INFOROTULADO_SUB',array(
            'ID_ROTULADO_SUB'   =>  $id_unico,
            'ID_ROTULADO'       =>  $aData['ID_ROTULADO'],
            'COD_EMPRESA'       =>  $aData['empresa'],
            'TXT_OBSERVACION'   =>  $aData['txt_nombresubtuoi'],
            'IND_ESTADO'        =>  "1",
            'DATE_CREA'         =>  "SYSDATE",
            'ID_UID'            =>  $aData['uid']->ID_UID,
        ));
        $this->db->trans_complete();
        return array(
            'status' => $this->db->trans_status(),
        );
    }

    public function busqueda_lista_sub($aData){
        $empresa = $aData['empresa'];
        $ID_ROTULADO = $aData['ID_ROTULADO']; 
        return $this->db->query("SELECT 
                                    S.*,
                                    TO_CHAR(S.DATE_CREA,'DD-MM-YYYY hh24:mi') AS DATE_CREACION 
                                FROM 
                                    PABELLON.PB_INFOROTULADO_SUB S 
                                WHERE  
                                    S.ID_ROTULADO IN ($ID_ROTULADO) AND 
                                    S.IND_ESTADO IN (1) AND 
                                    S.COD_EMPRESA IN ($empresa) 
                                ")->result_array();
    }

    public function delete_sub_punto($aData){
        $this->db->trans_start();
        $empresa = $aData['empresa'];
        $id_sub_grupo = $aData['id_sub_grupo']; 
        $this->db->where('ID_ROTULADO_SUB',$id_sub_grupo);
        $this->db->update($this->ownPab.'.PB_INFOROTULADO_SUB',array(
            "IND_ESTADO"        =>  0,
            "DATE_AUDITA"       =>  'SYSDATE',
            'ID_UID_AUDITA'     =>  $aData['uid']->ID_UID,
        ));
        $this->db->trans_complete();
        return array(
            'status' => $this->db->trans_status(),
        );
    }

    public function model_marca_pto_toma_muestra($aData){
        $this->db->trans_start();
        $this->db->where('ID_ROTULADO',$aData['id_toma_muestras']);
        $this->db->update($this->ownPab.'.PB_INFOROTULADO',array(
            "IND_ESTADISTICA"   =>  $aData['ind_marca'],
            //"DATE_AUDITA"     =>  'SYSDATE',
            //"ID_UID_AUDITA"   =>  $aData['uid']->ID_UID,
        ));
        $this->db->trans_complete();
        return array(
            'status' => $this->db->trans_status(),
        );
    }

    public function model_update_nombre_pto($aData){
        $this->db->trans_start();
        $this->db->where('ID_ROTULADO',$aData['id']);
        $this->db->update($this->ownPab.'.PB_INFOROTULADO',array("TXT_OBSERVACION"=>$aData['nombre']));
        $this->db->trans_complete();
        return array(
            'status' => $this->db->trans_status(),
        );
    }
}
