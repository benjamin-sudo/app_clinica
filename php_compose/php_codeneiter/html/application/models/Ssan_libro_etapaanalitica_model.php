<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Ssan_libro_etapaanalitica_model extends CI_Model {

    var $tableSpace     =   "ADMIN";
    var $own            =   "ADMIN";
    var $ownGu          =   "ADMIN";
    var $ownPab         =   "ADMIN";

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('oracle_conteiner',true);
    }

    public function load_etapa_analiticaap_paginado($DATA) {
        $this->db->trans_start();
        $_boreano_out = true;
        if ($DATA["ind_opcion"] == '#_panel_por_gestion') {
            if ($DATA["arr_ids_anatomia"] == '' || is_null($DATA["arr_ids_anatomia"])) {
                $_boreano_out = false;
            } else {
                $DATA["arr_ids_anatomia"] = implode(",", array_unique(explode(",", $DATA["arr_ids_anatomia"])));
            }
        }
        if ($DATA["ind_opcion"] == '#_panel_por_fecha') {
            // Código específico para panel por fecha, si es necesario
        }
        if (!$_boreano_out) {
            return array(
                'HTML_LI'       =>  $this->li_lista_estapaanalitica([], $DATA["ind_opcion"], $DATA["ind_first"], $DATA["get_sala"]),
                'n_resultado'   =>  '0',
                'STATUS'        =>  false,
                'BD'            =>  null,
                'status_bd'     =>  false,
                'ind_opcion'    =>  $DATA["ind_opcion"],
                'date_inicio'   =>  strtotime(date("d-m-Y")),
                'date_final'    =>  strtotime(date("d-m-Y")),
                'cookie'        =>  isset($_COOKIE['target']) ? '<span class="label label-success">CON COOKIE</span>' : '<span class="label label-warning">SIN COOKIE</span>',
                'ind_busqueda'  =>  isset($_COOKIE['target']) ? '<span class="label label-warning" id="span_tipo_busqueda">' . $_COOKIE['target'] . '</span>' : '<span class="label label-info" id="span_tipo_busqueda">#_panel_por_fecha</span>',
                'fechas'        =>  isset($_COOKIE['data']) ? $_COOKIE['data'] : 'null',
                'ids_anatomia'  =>  isset($_COOKIE['id_anatomia']) ? json_decode($_COOKIE['id_anatomia']) : 'null',
                'txt_sala'      =>  $DATA["get_sala"],
                'txt_titulo'    =>  $DATA["txt_titulo"],
                '_cookie'       =>  $_COOKIE,
                'V_DATA'        =>  [],
            );
        }
        $param = $DATA["ind_opcion"] == '#_panel_por_gestion' ?  array(
            array('name' => ':V_COD_EMPRESA', 'value' =>  $DATA["cod_empresa"], 'length' =>  20,'type' => SQLT_CHR),
            array('name' => ':V_USR_SESSION', 'value' =>  $DATA["usr_session"], 'length' =>  20,'type' => SQLT_CHR),
            array('name' => ':V_OPCION', 'value' =>  $DATA["ind_order_by"], 'length' =>  20,'type' => SQLT_CHR),
            array('name' => ':V_IND_FIRST', 'value' =>  $DATA["ind_first"], 'length' =>  20,'type' => SQLT_CHR),
            array('name' => ':VAL_FECHA_INICIO', 'value' => $DATA["data_inicio"],  'length' =>  20, 'type' => SQLT_CHR),
            array('name' => ':VAL_FECHA_FINAL', 'value' => $DATA["data_final"],  'length' => 20,  'type' => SQLT_CHR),
            array('name' => ':V_ARR_DATA',  'value' =>  $DATA["ind_opcion"]=='#_panel_por_gestion'?$DATA["arr_ids_anatomia"]:$DATA["ind_filtros_ap"],'length' =>  1000,'type'      =>  SQLT_CHR ),
            array('name' => ':C_LISTA_ANATOMIA', 'value' => $this->db->get_cursor(), 'length' => -1, 'type' => OCI_B_CURSOR),
            array('name' => ':C_HISTORIAL_M', 'value' => $this->db->get_cursor(), 'length' =>  -1, 'type' => OCI_B_CURSOR),
            array('name' => ':C_STATUS', 'value' => $this->db->get_cursor(), 'length' =>  -1, 'type' => OCI_B_CURSOR),
        ) : array(
            array('name' => ':V_COD_EMPRESA', 'value' => $DATA["cod_empresa"], 'length' => 20, 'type' => SQLT_CHR),
            array('name' => ':V_USR_SESSION', 'value' => $DATA["usr_session"], 'length' => 20, 'type' => SQLT_CHR),
            array('name' => ':V_OPCION', 'value' => $DATA["ind_order_by"], 'length' => 20, 'type' => SQLT_CHR),
            array('name' => ':V_IND_FIRST', 'value' => $DATA["ind_first"], 'length' => 20, 'type' => SQLT_CHR),
            array('name' => ':VAL_FECHA_INICIO', 'value' => $DATA["data_inicio"], 'length' => 20, 'type' => SQLT_CHR),
            array('name' => ':VAL_FECHA_FINAL', 'value' => $DATA["data_final"], 'length' => 20, 'type' => SQLT_CHR),
            array('name' => ':V_ARR_DATA', 'value' => $DATA["ind_opcion"] == '#_panel_por_gestion' ? $DATA["arr_ids_anatomia"] : $DATA["ind_filtros_ap"], 'length' => 1000, 'type' => SQLT_CHR),
            array('name' => ':V_PAGE_NUM', 'value' => $DATA["v_page_num"], 'length' => 20, 'type' => OCI_B_INT),
            array('name' => ':V_PAGE_SIZE', 'value' => $DATA["v_page_size"], 'length' => 20, 'type' => OCI_B_INT),
            array('name' => ':C_LISTA_ANATOMIA', 'value' => $this->db->get_cursor(), 'length' => -1, 'type' => OCI_B_CURSOR),
            array('name' => ':C_NUM_RESULTADOS', 'value' => $this->db->get_cursor(), 'length' => -1, 'type' => OCI_B_CURSOR),
            array('name' => ':C_STATUS', 'value' => $this->db->get_cursor(), 'length' => -1, 'type' => OCI_B_CURSOR),
        );
        $_txt_proce_anatomia = $DATA["ind_opcion"] == '#_panel_por_gestion' ? 'LOAD_ETAPA_ANALITICA_IDSAP' : 'LOAD_ANALITICA_PAGINADO';
        $result = $this->db->stored_procedure_multicursor($this->own . '.PROCE_ANATOMIA_PATOLOGIA', $_txt_proce_anatomia, $param);
        $this->db->trans_complete();
        return array(
            'BD' =>  $result,
            'STATUS' => true,
            'status_bd' => true,
            'HTML_LI' =>  $this->li_lista_estapaanalitica_paginado($result, $DATA["ind_opcion"], $DATA["ind_first"], $DATA["get_sala"]),
            'n_resultado' => $DATA["ind_opcion"] == '#_panel_por_gestion' ? 1 : $result[":C_NUM_RESULTADOS"][0]["V_TOTAL_COUNT"],
            'n_pagina' =>  $DATA["ind_opcion"] == '#_panel_por_gestion' ? 2 : $result[":C_NUM_RESULTADOS"][0]["V_NUM_PAGINAS"],
            'ind_opcion' =>  $DATA["ind_opcion"],
            'date_inicio' => strtotime($DATA["data_inicio"]),
            'date_final' => strtotime($DATA["data_final"]),
            'cookie' => isset($_COOKIE['target']) ? '<span class="badge bg-dark">CON COOKIE</span>' : '<span class="badge bg-primary">SIN COOKIE</span>',
            'ind_busqueda' =>  isset($_COOKIE['target']) ? '<span class="badge badge-warning" id="span_tipo_busqueda">'.$_COOKIE['target'].'</span>':'<span class="badge badge-info" id="span_tipo_busqueda">#_panel_por_fecha</span>',
            'fechas' =>  isset($_COOKIE['data']) ? $_COOKIE['data'] : 'null',
            'ids_anatomia' =>  isset($_COOKIE['id_anatomia']) ? json_decode($_COOKIE['id_anatomia']) : 'null',
            'txt_sala' =>  $DATA["get_sala"],
            'txt_titulo' =>  $DATA["txt_titulo"],
            '_cookie' =>  $_COOKIE,
            'V_DATA' =>  $DATA,
        );
    }

    public function li_lista_estapaanalitica_paginado($result, $ind_opcion, $ind_first, $get_sala) {
        $html = '';
        $v_num_registro = 0;
        if (isset($result[":C_LISTA_ANATOMIA"])) {
            if(count($result[":C_LISTA_ANATOMIA"]) > 0) {
                foreach ($result[":C_LISTA_ANATOMIA"] as $i => $row) {
                    $html .=    $this->load->view("ssan_libro_etapaanalitica/html_li_resul_anatomiaap", array(
                                    'aux'           =>  ($i + 1),
                                    'row'           =>  $row,
                                    'ind_opcion'    =>  $ind_opcion,
                                    'ind_first'     =>  $ind_first,
                                    'get_sala'      =>  $get_sala
                                ), true);
                    
                    //$html .= '<li class="list-group-item">And a fifth one -> <b>'.$row['RNUM'].'/'.$row['TOTAL_COUNT'].'</b> </li>';     
                }
            } else {
                $html .= $this->sin_resultados(substr($ind_opcion, 1));
            }

            if ($ind_first == 1) {
                return array(
                    'return_html' => $ind_opcion === '#_panel_por_fecha' ? $html : $this->sin_resultados('_panel_por_fecha'),
                    'return_por_gestion' => $ind_opcion === '#_panel_por_gestion' ? $html : $this->sin_resultados('_panel_por_gestion'),
                    'return_por_codigo' => $ind_opcion === '#_busqueda_bacode' ? $html : $this->sin_resultados('_busqueda_bacode'),
                    'return_por_persona' => $ind_opcion === '#_busqueda_xpersona' ? $html : $this->sin_resultados('_busqueda_xpersona'),
                );
            } else {
                return array(
                    'return_html' => $html // se encarga el js de agregar
                );
            }
        } else {
            return array(
                'return_html' => $this->sin_resultados('_panel_por_fecha'),
                'return_por_gestion' => $this->sin_resultados('_panel_por_gestion'),
                'return_por_codigo' => $this->sin_resultados('_busqueda_bacode'),
                'return_por_persona' => $this->sin_resultados('_busqueda_xpersona'),
            );
        }
    }

    public function load_etapa_analiticaap($DATA){
        $this->db->trans_start();
        $_boreano_out                           =   true;
        #_panel_por_fecha
        if($DATA["ind_opcion"]                  ==  '#_panel_por_gestion'){
            #_panel_por_gestion
            #$_boreano_out                      =   is_null($DATA["arr_ids_anatomia"])?false:true;
            if ($DATA["arr_ids_anatomia"] == '' ||  is_null($DATA["arr_ids_anatomia"])){
                $_boreano_out                   =   false;
            } else {
                $DATA["arr_ids_anatomia"]       =   implode(",", array_unique(explode(",",$DATA["arr_ids_anatomia"]))) ;
                #var_dump();
            }
        }
        #_panel_por_gestion
        if($DATA["ind_opcion"]                   ==  '#_panel_por_fecha'){
            #_panel_por_fecha
            #$$_boreano_out                      =   false;
        }
        #var_dump($DATA["ind_opcion"]);
        #var_dump($DATA["arr_ids_anatomia"]);
        #$DATA["arr_ids_anatomia"]
        if(!$_boreano_out){
            return array(
                'HTML_LI'                        =>  $this->li_lista_estapaanalitica([],$DATA["ind_opcion"],$DATA["ind_first"],$DATA["get_sala"]),
                'n_resultado'                    =>  '0',
                'STATUS'                         =>  false,
                'BD'                             =>  null,
                'STATUS'                         =>  false,
                'ind_opcion'                     =>  $DATA["ind_opcion"],
                'date_inicio'                    =>  strtotime(date("d-m-Y")),
                'date_final'                     =>  strtotime(date("d-m-Y")),
                'cookie'                         =>  isset($_COOKIE['target'])?'<span class="label label-success">CON COOKIE</span>':'<span class="label label-warning">SIN COOKIE</span>',
                'ind_busqueda'                   =>  isset($_COOKIE['target'])?'<span class="label label-warning" id="span_tipo_busqueda">'.$_COOKIE['target'].'</span>':'<span class="label label-info" id="span_tipo_busqueda">#_panel_por_fecha</span>',
                'fechas'                         =>  isset($_COOKIE['data'])?$_COOKIE['data']:'null',
                'ids_anatomia'                   =>  isset($_COOKIE['id_anatomia'])?json_decode($_COOKIE['id_anatomia']):'null',
                'txt_sala'                       =>  $DATA["get_sala"],
                'txt_titulo'                     =>  $DATA["txt_titulo"],
                '_cookie'                        =>  $_COOKIE,
                'ind_estados'                    =>  $DATA["ind_filtros_ap"],
                'V_DATA'                         =>  [],
            ); 
        }
        
        #INICIO EN LA CONSULTA
        $param          =   array(
                                #DATA IN
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["cod_empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_USR_SESSION',
                                    'value'     =>  $DATA["usr_session"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_OPCION',
                                    'value'     =>  $DATA["ind_order_by"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_IND_FIRST',
                                    'value'     =>  $DATA["ind_first"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':VAL_FECHA_INICIO',
                                    'value'     =>  $DATA["data_inicio"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':VAL_FECHA_FINAL',
                                    'value'     =>  $DATA["data_final"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #FILTROS O IDS A BUSCAR
                                array( 
                                    'name'      =>  ':V_ARR_DATA',
                                    'value'     =>  $DATA["ind_opcion"]=='#_panel_por_gestion'?$DATA["arr_ids_anatomia"]:$DATA["ind_filtros_ap"],
                                    #'value'    =>  '0',
                                    'length'    =>  1000,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #CURSORES OUT
                                array( 
                                    'name'      =>  ':C_LISTA_ANATOMIA',
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
                                array( 
                                    'name'      =>  ':C_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $_txt_proce_anatomia                    =   $DATA["ind_opcion"]=='#_panel_por_gestion'?'LOAD_ETAPA_ANALITICA_IDSAP':'LOAD_ETAPA_ANALITICA_FECHAS';
        #'LOAD_ETAPA_ANALITICA',
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA',$_txt_proce_anatomia,$param);
        $this->db->trans_complete();
        return array (
            'HTML_LI'                           =>  $this->li_lista_estapaanalitica($result,$DATA["ind_opcion"],$DATA["ind_first"],$DATA["get_sala"]),
            #'HTML_LI'                          =>  '',
            'n_resultado'                       =>  count($result[":C_LISTA_ANATOMIA"]),
            'BD'                                =>  $result,
            'STATUS'                            =>  true,
            'status_bd'                         =>  true,
            'ind_opcion'                        =>  $DATA["ind_opcion"],
            'date_inicio'                       =>  strtotime($DATA["data_inicio"]),
            'date_final'                        =>  strtotime($DATA["data_final"]),
            'cookie'                            =>  isset($_COOKIE['target'])?'<span class="badge bg-success">CON COOKIE</span>':'<span class="badge bg-warning">SIN COOKIE</span>',
            'ind_busqueda'                      =>  isset($_COOKIE['target'])?'<span class="badge bg-primary" id="span_tipo_busqueda">'.$_COOKIE['target'].'</span>':'<span class="badge bg-primary" id="span_tipo_busqueda">#_panel_por_fecha</span>',
            'fechas'                            =>  isset($_COOKIE['data'])?$_COOKIE['data']:'null',
            'ids_anatomia'                      =>  isset($_COOKIE['id_anatomia'])?json_decode($_COOKIE['id_anatomia']):'null',
            'txt_sala'                          =>  $DATA["get_sala"],
            'txt_titulo'                        =>  $DATA["txt_titulo"],
            '_cookie'                           =>  $_COOKIE,
            'V_DATA'                            =>  $DATA,
        );
    }

    public function load_firma_doctores_informe($aData){
        $this->db->trans_start();
        $param          =   array(
                                #DATA IN
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $aData["empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_RUN_PROFESIONAL',
                                    'value'     =>  $aData["session"],
                                    'length'    =>  4000,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #CURSORES OUT
                                array( 
                                    'name'      =>  ':C_DATA_FIRMA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_FIRMA_DOCTOR',$param);
        $this->db->trans_complete();
        return [
            'status'                            =>  true,
            'data_bd'                           =>  $result,
            'C_DATA_FIRMA'                      =>  $result[":C_DATA_FIRMA"]
        ];
    }
    
    public function gestion_imagenes_firma($aData){
        $this->db->trans_start();
        $blob               =   oci_new_descriptor($this->db->conn_id,OCI_D_LOB);
        $blob->writeTemporary(file_get_contents($_FILES["img_firma_get"]["tmp_name"]));
        $param              =   array(
            #data in
            array( 
                'name'      =>  ':VAL_COD_EMPRESA',
                'value'     =>  $aData["empresa"],
                'length'    =>  20,
                'type'      =>  SQLT_CHR 
            ),
            array( 
                'name'      =>  ':VAL_ID_PROFESIONAL',
                'value'     =>  'null',
                'length'    =>  4000,
                'type'      =>  SQLT_CHR 
            ),
            array( 
                'name'      =>  ':VAL_RUN_PROFESIONAL',
                'value'     =>  $aData["session"],
                'length'    =>  4000,
                'type'      =>  SQLT_CHR 
            ),
            array( 
                'name'      =>  ':VAL_NAME_IMG',
                'value'     =>  $_FILES["img_firma_get"]["name"],
                'length'    =>  256,
                'type'      =>  SQLT_CHR 
            ),
            array( 
                'name'      =>  ':VAL_SIZE_IMG',
                'value'     =>  $_FILES["img_firma_get"]["type"],
                'length'    =>  256,
                'type'      =>  SQLT_CHR 
            ),
            array( 
                'name'      =>  ':VAL_SIZE_TYPE',
                'value'     =>  $_FILES["img_firma_get"]["size"],
                'length'    =>  256,
                'type'      =>  SQLT_CHR 
            ),
            array( 
                'name'      =>  ':P_CLOB_DATA',
                'value'     =>  $blob,
                'length'    =>  -1,
                'type'      =>  SQLT_CLOB
            ),
            #data out
            array( 
                'name'      =>  ':RETURN_CURSOR',
                'value'     =>  $this->db->get_cursor(),
                'length'    =>  -1,
                'type'      =>  OCI_B_CURSOR
            ),
        );
        $result             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','GESTION_FIRMA_X_PROFE',$param);
        $this->db->trans_complete();
        return array(
            'status'        =>  true,
            'data_bd'       =>  $result,
            'RETURN_CURSOR' =>  $result[":RETURN_CURSOR"]
        );
    } 
    
    public function subir_imagenprotoclo($cod_empresa){
        $context                    =   stream_context_create(array(
            'http'                  =>  array(
                                            'ignore_errors'     =>  true,
                                            'header'            =>  "User-Agent:MyAgent/1.0\r\n"
                                        )));
        $blob                       =   oci_new_descriptor($this->db->conn_id,OCI_D_LOB);
        $blob->writeTemporary(file_get_contents($_FILES["IMG_PROTOCOLO"]["tmp_name"]));
        //$ID_IMAGEN                =   $this->db->sequence($this->ownPab,'SEQ_BLOB_IMG_BD');
        $ID_IMAGEN                  =   '';
        
        $param                      =   array(
                                            array( 
                                                'name'      =>  ':SEG_IMAGEN',
                                                'value'     =>  $ID_IMAGEN,
                                                'length'    =>  1000,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':ID_TABLA',
                                                'value'     =>  NULL,
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_COD_EMPRESA',
                                                'value'     =>  $cod_empresa,
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_NAME_IMG',
                                                'value'     =>  $_FILES["IMG_PROTOCOLO"]["name"],
                                                //'value'   =>  0,
                                                'length'    =>  256,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_SIZE_IMG',
                                                'value'     =>  $_FILES["IMG_PROTOCOLO"]["type"],
                                                //'value'   =>  0,
                                                'length'    =>  256,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_SIZE_TYPE',
                                                'value'     =>  $_FILES["IMG_PROTOCOLO"]["size"],
                                                //'value'     =>  0,
                                                'length'    =>  256,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            /*
                                            array( 
                                                'name'      =>  ':P_BLOB_DATA',
                                                'value'     =>  $blob,
                                                'length'    =>  -1,
                                                'type'      =>  SQLT_BLOB
                                            ),
                                            */
                                            array( 
                                                'name'      =>  ':P_CLOB_DATA',
                                                'value'     =>  $blob,
                                                'length'    =>  -1,
                                                'type'      =>  SQLT_CLOB
                                            ),
                                            array( 
                                                'name'      =>  ':RETURN_CURSOR',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                        );
        $result = $this->db->stored_procedure_multicursor($this->own.'.PROCE_PABELLON_PDF','GET_BLOB_DATA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                => true,
            'RETURN_CURSOR'         =>	empty($result[':RETURN_CURSOR'])?null:$result[':RETURN_CURSOR'],
        );
    }
    
    public function busqueda_solicitudes_ap($DATA){
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
                                    'name'      =>  ':V_TXT',
                                    'value'     =>  $DATA["busq"],
                                    'length'    =>  4000,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_IND_BUSQUEDA',
                                    'value'     =>  $DATA["txt_bus"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #FILTROS O IDS A BUSCAR
                                array( 
                                    'name'      =>  ':V_ARR_DATA',
                                    'value'     =>  $DATA["arr_ids_anatomia"],
                                    'length'    =>  1000,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #CURSORES OUT
                                array( 
                                    'name'      =>  ':C_LISTA_ANATOMIA_BUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':C_HISTORIAL_M_BUSQUEDA',
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
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_BUSQX_PARAMETROS',$param);
        $this->db->trans_complete();
        return array(
            'status'                            =>  true,
            'data_bd'                           =>  $result,
            'C_LISTA_ANATOMIA_BUS'              =>  $result[":C_LISTA_ANATOMIA_BUS"],
            'C_HISTORIAL_M_BUSQUEDA'            =>  $result[":C_HISTORIAL_M_BUSQUEDA"]
        );
        
    }
     
    public function li_lista_estapaanalitica($result,$ind_opcion,$ind_first,$get_sala){
        $html   =   '';
        if (isset($result[":C_LISTA_ANATOMIA"])){
            if(count($result[":C_LISTA_ANATOMIA"])>0){
                foreach($result[":C_LISTA_ANATOMIA"] as $i => $row){
                    $html   .=   $this->load->view("ssan_libro_etapaanalitica/html_li_resul_anatomiaap",[
                                    'aux'           =>  ($i+1),
                                    'row'           =>  $row,
                                    'ind_opcion'    =>  $ind_opcion,
                                    'ind_first'     =>  $ind_first,
                                    'get_sala'      =>  $get_sala
                                ],true);
                }
            } else {
                    $html   .=  $this->sin_resultados(substr($ind_opcion,1));
            }
            if($ind_first == 1){
                return array(
                    'return_html'                   =>  $ind_opcion === '#_panel_por_fecha'   ? $html : $this->sin_resultados('_panel_por_fecha'),
                    'return_por_gestion'            =>  $ind_opcion === '#_panel_por_gestion' ? $html : $this->sin_resultados('_panel_por_gestion'),
                    'return_por_codigo'             =>  $ind_opcion === '#_busqueda_bacode'   ? $html : $this->sin_resultados('_busqueda_bacode'),
                    'return_por_persona'            =>  $ind_opcion === '#_busqueda_xpersona' ? $html : $this->sin_resultados('_busqueda_xpersona'),
                );
            } else {
                return array(
                    //se encarga el js de agregar
                    'return_html'                   =>  $html
                );
            }
        } else {
            return array(
                'return_html'                       =>  $this->sin_resultados('_panel_por_fecha'),
                'return_por_gestion'                =>  $this->sin_resultados('_panel_por_gestion'),
                'return_por_codigo'                 =>  $this->sin_resultados('_busqueda_bacode'),
                'return_por_persona'                =>  $this->sin_resultados('_busqueda_xpersona'),
            );
        }
    }
    
    public function sin_resultados($txt_li){
        $html           =   '
                                <li class="list-group-item lista_analitica sin_resultados'.$txt_li.'"> 
                                    <div class="grid_sin_informacion">
                                        <div class="grid_sin_informacion1"></div>
                                        <div class="grid_sin_informacion2"><b>SIN INFORMACI&Oacute;N</b></div>
                                        <div class="grid_sin_informacion3"></div>
                                    </div>
                                </li>
                            ';
        return          $html;
    }
    
    public function busqueda_img_clob($id_anatomia){
        $this->db->trans_start();
        $param          =   array(
                                #DATA IN
                                array( 
                                    'name'      =>  ':V_ID_ANATOMIA',
                                    'value'     =>  $id_anatomia,
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #CURSORES OUT
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
                                array( 
                                    'name'      =>  ':C_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_IMG_VIEWS',$param);
        $this->db->trans_complete();
        return array(
            'num_anatomia'                      =>  $id_anatomia,
            'status'                            =>  true,
            'data_bd'                           =>  $result,
        );
    }
    
    function calcular_edad($fecha){
        $fecha_nac          =   new DateTime(date('d-m-Y',strtotime(str_replace('/','-',$fecha)))); // Creo un objeto DateTime de la fecha ingresada
        $fecha_hoy          =   new DateTime(date('d-m-Y',time()));                                 // Creo un objeto DateTime de la fecha de hoy
        $edad               =   date_diff($fecha_hoy,$fecha_nac);                                   // La funcion ayuda a calcular la diferencia, esto seria un objeto
        return $edad;
    }

    #main principal de las hojas de anatomia
    public function load_informacion_rce_patologico($DATA){
        $this->db->trans_start();
        $param              =   array(
                                    #DATA IN
                                    array( 
                                        'name'      =>  ':V_COD_EMPRESA',
                                        'value'     =>  $DATA["cod_empresa"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_USR_SESSION',
                                        'value'     =>  $DATA["usr_session"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_OPCION',
                                        'value'     =>  $DATA["ind_opcion"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_IND_FIRST',
                                        'value'     =>  $DATA["ind_first"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_ID_ANATOMIA',
                                        'value'     =>  $DATA["id_anatomia"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_GET_SALA',
                                        'value'     =>  $DATA["get_sala"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    #CURSORES OUT
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
                                        'name'      =>  ':P_LISTA_PATOLOGOS',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_LISTA_FRAGMENTOS',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    #SOLO RCE PATOLOGO
                                    array( 
                                        'name'      =>  ':P_LISTA_PRESTACIONES',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_LIS_CODORGANO',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_LIS_CODPATOLOGIA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_LIS_COD_MAI',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_LIS_MAI_PROCEDIMIENTO',
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
                                    array( 
                                        'name'      =>  ':C_CHAT_ANATOMIA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
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
                                    #SALA DE INCLUSION 
                                    array( 
                                        'name'      =>  ':P_TECNICAS_APLICADAS',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':P_TECNICAS_APLICADASXMUESTRA',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    #SALA DE PROCESO
                                    array( 
                                        'name'      =>  ':P_SALA_PROCESO',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    #STATUS SOLICITUD
                                    array( 
                                        'name'      =>  ':C_STATUS',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':C_EXCEPCION',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                );
        
        $result = $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_RCE_ANATOMIA_PATOLOGICA',$param);
        $this->db->trans_complete();
        $arr_info_linea_tiempo                                                                  =   [];
        #ordena data para templetate template_logs_anatomia
        $log_adverso                                                                            =   [];
        if(count($result[':P_INFO_LOG_ADVERSOS'])>0){
            foreach($result[':P_INFO_LOG_ADVERSOS'] as $i => $log_adv){ 
                $log_adverso[$log_adv['ID_NUM_CARGA'].'_'.$log_adv['ID_NMUESTRA']]              =   $log_adv;
            }
        }
        if(count($result[":P_AP_INFORMACION_ADICIONAL"])>0){
            foreach ($result[":P_AP_INFORMACION_ADICIONAL"] as $i => $arr_linea_tiempo_logs_row){
                $ID_SOLICITUD_HISTO                                                             =   $arr_linea_tiempo_logs_row['ID_SOLICITUD_HISTO'];
                $ID_NUM_CARGA                                                                   =   $arr_linea_tiempo_logs_row['ID_NUM_CARGA'];
                $ID_NMUESTRA                                                                    =   $arr_linea_tiempo_logs_row['ID_CASETE']==''?$arr_linea_tiempo_logs_row['TXT_BACODE']:$arr_linea_tiempo_logs_row['ID_CASETE'];
                $id_compuesta                                                                   =   $ID_NUM_CARGA.'_'.$ID_NMUESTRA;
                $arr_info_linea_tiempo[$ID_SOLICITUD_HISTO][$ID_NUM_CARGA][$ID_NMUESTRA][]      =   array(
                                                                                                        'MAIN'          =>  $arr_linea_tiempo_logs_row ,
                                                                                                        'ERROR_LOG'     =>  array_key_exists($id_compuesta,$log_adverso)?$log_adverso[$id_compuesta]:[]
                                                                                                    );
            }
        }
        return array(
            'STATUS'        =>  true,
            'num_anatomia'  =>  $DATA["id_anatomia"],
            'linea_time'    =>  $arr_info_linea_tiempo,
            'data_bd'       =>  $result,
            'html_log'      =>  $this->load->view("ssan_libro_etapaanalitica/template_logs_anatomia",array("ID_SOLICITUD"=>$DATA["id_anatomia"],'P_AP_INFORMACION_ADICIONAL'=>empty($arr_info_linea_tiempo[$DATA["id_anatomia"]])?[]:$arr_info_linea_tiempo[$DATA["id_anatomia"]]),true),
            'html_main'     =>  '',
            'get_sala'      =>  $DATA['get_sala'],
        );
    }
    
    ####################
    #BUSQUEDA DE FAMILIA
    ####################
    public function load_familia_evolucion($DATA){
        $this->db->trans_start();
        $param          =   array(
                                #IN
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["cod_empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':V_RUT_PAC',
                                    'value'     =>  $DATA["rut"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                #OUT
                                array( 
                                    'name'      =>  ':P_GETDATOPCIENTE',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                                array( 
                                    'name'      =>  ':P_GETFAMILIA',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ACTIVIDADES_GRUPALES','LOAD_BUSQ_FAMILIA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                            =>  true,
            'data_main'                         =>  $result,
        );
    }
    
    public function load_info_excel_produccion($DATA){
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["cod_empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':VAL_FECHA_INICIO',
                                    'value'     =>  $DATA["date_fecha_inicio"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':VAL_FECHA_FINAL',
                                    'value'     =>  $DATA["date_fecha_final"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':P_PROD_ANATOMIAPATOLOGICA',
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
                                array( 
                                    'name'      =>  ':P_STATUS',
                                    'value'     =>  $this->db->get_cursor(),
                                    'length'    =>  -1,
                                    'type'      =>  OCI_B_CURSOR
                                ),
                            );
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_EXCEL_ANATOMIA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                            =>  true,
            'data_main'                         =>  $result,
        );
    }
    
    public function delete_img($aData){
        $this->db->trans_start();
        $this->db->where('ID_MAIN',$aData['ID_IMG']); 
        $this->db->update($this->ownPab.'.PB_MAIN_BLG_ANATOMIA',array("IND_ESTADO"=>0,"USR_AUDITA"=>$aData['session'],"DATE_AUDITA"=>"SYSDATE"));
        $this->db->trans_complete();
        return array(
            'STATUS'                            =>  true,
        );
    }
    
    public function graba_nueva_plantilla($aData){
        $this->db->trans_start();
        $id_tprestacionesxanatomia      =    $this->db->sequence($this->ownPab,'SEQ_PLANTILLA_ANATOMIA');
        $new_pestacion                  =    array(
                                                    'ID_TPLANTILLA'         =>  $id_tprestacionesxanatomia,
                                                    'DATE_CREA'             =>  'SYSDATE',
                                                    'ID_UID'                =>  $aData['data_firma'][0]['ID_UID'],
                                                    'IND_ESTADO'            =>  '1',
                                                    'TXT_TITULO'            =>  quotes_to_entities($aData['txt_titulo']),
                                                    'TXT_CUERPO'            =>  quotes_to_entities($aData['txt_cuerpo']),
                                                    'USER_SESSION'          =>  $aData['session'],
                                                    'COD_EMPRESA'           =>  $aData['empresa']
                                            );
        $this->db->insert($this->ownPab.'.PB_TPLANTILLANATOMIA',$new_pestacion); 
        $this->db->trans_complete();
        return array(
            'status'                    =>  true,
            'n_plantilla'               =>  $id_tprestacionesxanatomia,
        );
    }

    public function load_data_plantillas_anatomia($DATA){
        $this->db->trans_start();
        $param          =   array(
                                array( 
                                    'name'      =>  ':V_COD_EMPRESA',
                                    'value'     =>  $DATA["cod_empresa"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':VAL_SESSION',
                                    'value'     =>  $DATA["session"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':VAL_ID_UID',
                                    'value'     =>  $DATA["id_uid"],
                                    'length'    =>  20,
                                    'type'      =>  SQLT_CHR 
                                ),
                                array( 
                                    'name'      =>  ':P_LISTA_PLANTILLAS',
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
        $result                                 =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_PLANTILLAS_ANATOMIA',$param);
        $this->db->trans_complete();
        return array(
            'num_muestra'                       =>  $DATA['num_muestras'],
            'txt_muestra'                       =>  $DATA['txt_muestra'],
            'status'                            =>  true,
            'data_main'                         =>  $result,
        );
    }
    
    public function new_get_busquedatoken($origen_,$numfichae){
	    $this->load->library("autentificacion");
        $COD_ESTABL_G           =   $this->session->userdata("COD_ESTAB");
        $USARNAME_G             =   explode("-",$this->session->userdata("USERNAME"));
        $origen                 =   $origen_;//NUM
        $return                 =   $this->autentificacion->getToken($COD_ESTABL_G,$USARNAME_G[0],$origen,'',$numfichae);
        $TOKEN_SESSION          =   '';
        $TOKEN_ONE              =   '';
        if($return->status){
            $TOKEN_SESSION      =   '&token='.''.$return->access_token;
            $TOKEN_ONE          =   $return->access_token; 
        } 
	    return array(
            'TOKEN_SESSION'     =>  $TOKEN_SESSION,
            'TOKEN_ONE'         =>  $TOKEN_ONE
        );
    }
    
    public function get_elimina_plantilla($aData){
        $this->db->trans_start();
        $this->db->where('ID_TPLANTILLA',$aData['num_plantilla']); 
        $this->db->update($this->ownPab.'.PB_TPLANTILLANATOMIA',array("IND_ESTADO"=>0,"USR_AUDITA"=>$aData['session'],"DATE_AUDITA"=>"SYSDATE"));
        $this->db->trans_complete();
        return array('status'=>true);
    }
    
    public function delete_img_x_muestra($aData){
        $this->db->trans_start();
        $this->db->where('ID_MAIN',$aData['ID_IMG']); 
        $this->db->update($this->ownPab.'.PB_IMG_APMUESTRAS',array("IND_ESTADO"=>0,"USR_AUDITA"=>$aData['session'],"DATE_AUDITA"=>"SYSDATE"));
        $this->db->trans_complete();
        return array(
            'STATUS'                            =>  true,
        );
    }
    
    public function guarda_informacion_perfil_administrativo($aData){
        $this->db->trans_start();
        $id_anatomia                            =   $aData["id_anatomia"];    
        $session                                =   $aData["session"];
        $dataSolicitud                          =   array(
                                                        'FEC_AUDITA'                =>  'SYSDATE',
                                                        'USR_AUDITA'                =>  $session,
                                                        "LAST_USR_AUDITA"           =>  $aData["session"],
                                                        "LAST_DATE_AUDITA"          =>  "SYSDATE",
                                                    );
        $hispatologico                          =   $aData["accesdata"];
        if(count($hispatologico["formulario_administrativo"])>0){
           foreach ($hispatologico["formulario_administrativo"] as $i => $datos){
                if(isset($datos["ind_profesional_acargo"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("ID_PROFESIONAL"                 =>  $datos["ind_profesional_acargo"] ) );
                }
                if(isset($datos["ind_profesional_acargo_citologico"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("ID_PROFESIONAL_CITOLOGICO"      =>  $datos["ind_profesional_acargo_citologico"] ) );
                }
                if(isset($datos["num_beneficiarios"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_BENEFICIARIOS"              =>  $datos["num_beneficiarios"]));
                }
                if(isset($datos["ind_mes_critico"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_MES_CRITICO"                =>  $datos["ind_mes_critico"]));
                }
                if(isset($datos["date_impresion_informe"]) && $datos["date_impresion_informe"]!=''){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_IMPRESION_INFORME"         =>  "TO_DATE('".$datos["date_impresion_informe"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["date_hora_fecha_entrga_informe"]) && $datos["date_hora_fecha_entrga_informe"]!=' '){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_ENTREGA_INFORME"           =>  "TO_DATE('".$datos["date_hora_fecha_entrga_informe"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["ind_profesional_entrega_informe"]) && $datos["ind_profesional_entrega_informe"]!=''){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("ID_PROFESIONAL_ENTREGA_INFO"    =>  $datos["ind_profesional_entrega_informe"]));
                }
                if(isset($datos["ind_profesional_recibe_informe"]) && $datos["ind_profesional_recibe_informe"]!=''){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("ID_PROFESIONAL_RECIBE_INFO"     =>  $datos["ind_profesional_recibe_informe"]));
                }
                if(isset($datos["n_notificacion"    ])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_NOTIFICACION"               =>  $datos["n_notificacion"]));
                }
                if(isset($datos["date_chequeo_some"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_CHEQUEO_SOME"              =>  "TO_DATE('".$datos["date_chequeo_some"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["date_revision_bd"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_REVISION_BD"               =>  "TO_DATE('".$datos["date_revision_bd"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["date_revision_informe"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_REVISION_INFORME"          =>  "TO_DATE('".$datos["date_revision_informe"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["date_archivada_en_ficha"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_ARCHIVADA_EN_FICHA"        =>  "TO_DATE('".$datos["date_archivada_en_ficha"]."','DD-MM-YYYY hh24:mi')"));
                }
            }
        }
        #ADD CAMPOS EN PERFIL
        $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_GEST_ADMINISTRATIVO"            =>  1));
        $dataSolicitud                  =     array_merge($dataSolicitud,array("ID_UID_ADMINISTRATIVO"              =>  $aData['data_firma'][0]['ID_UID']));
        $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_AUDITA_ADMINISTRATIVO"         =>  'SYSDATE'));
        $this->db->where('ID_SOLICITUD_HISTO',$id_anatomia); 
        $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',$dataSolicitud);
        $this->db->trans_complete();
        return array('status'=>true);
    }
    
    public function guardado_anatomia_patologica($aData){
        $this->db->trans_start();
        $id_anatomia        =   $aData["id_anatomia"];    
        $session            =   $aData["session"];
        $dataSolicitud      =   array('FEC_AUDITA'=>'SYSDATE','USR_AUDITA'=>$session);
        $hispatologico      =   $aData["accesdata"];
        
        #DESC PATOLOGO
        if(isset($hispatologico["arr_info_microscopia"])){
            if(count($hispatologico["arr_info_microscopia"])>0){
                foreach( $hispatologico["arr_info_microscopia"] as $aux_m  => $row_muestra){
                    $this->db->where('ID_NMUESTRA',$row_muestra["num"]); 
                    $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array(
                        "IND_ESTADO"                =>  1,
                        #"USR_AUDITA"               =>  $aData['session'],
                        #"DATE_AUDITA"              =>  "SYSDATE",
                        "USR_AUDITA_ANALITICO"      =>  $aData['session'],
                        "DATE_AUDITA_ANALITICO"     =>  "SYSDATE",
                        "TXT_DESC_MICROSCOPICA"     =>  quotes_to_entities($row_muestra["txt"])
                    ));
                }
            }
        }
        
        #IMAGENES DE MACRO
        if (isset($hispatologico["arr_data_img"])){
            if(count($hispatologico["arr_data_img"][0])>0){
                foreach($hispatologico["arr_data_img"][0] as $i => $datos){
                    $this->db->where('ID_MAIN',$datos['id']); 
                    $this->db->update($this->ownPab.'.PB_MAIN_BLG_ANATOMIA',array("TXT_OBSERVACIONES"=>$datos['txt'],"USR_AUDITA"=>$session,"DATE_AUDITA"=>"SYSDATE"));
                }
            }
        }
        #FORMULARIO PRINCIPAL
        if(count($hispatologico["formulario_main"][0])>0){
           foreach($hispatologico["formulario_main"][0] as $i => $datos){
                if(isset($datos["num_plazo_biopsias"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_PLAZO_BIOPSIA"              =>  $datos["num_plazo_biopsias"]));
                }
                if(isset($datos["num_entrega_cancercritico"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_DIAS_ENTCANCER"             =>  $datos["num_entrega_cancercritico"]));
                }
                
                if(isset($datos["ind_asignadas96horas"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_ASIGNACION96HRS"            =>  $datos["ind_asignadas96horas"]));
                }
                
                if(isset($datos["date_hora_fecha_inicio_cancer"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_INICIO_CANCER"             =>  "TO_DATE('".$datos["date_hora_fecha_inicio_cancer"]."','DD-MM-YYYY hh24:mi')"));
                }
                
                if(isset($datos["date_hora_fecha_final_cancer"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_FINAL_CANCER"              =>  "TO_DATE('".$datos["date_hora_fecha_final_cancer"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["ind_estado_olga"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_ESTADIO_OLGA"               =>  $datos["ind_estado_olga"]));
                }
                if(isset($datos["txt_diagnostico_ap"])){
                    //$dataSolicitud                =     array_merge($dataSolicitud,array("TXT_DIADNOSTICO_AP_"            =>  quotes_to_entities(substr(0,1000,trim($datos["txt_diagnostico_ap"])))));//DEFINIR LIMITE
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("TXT_DIADNOSTICO_AP"             =>  trim($datos["txt_diagnostico_ap"]) ));
                }
                if(isset($datos["ind_cancer"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_CONF_CANCER"                =>  $datos["ind_cancer"]));
                }
                
                if(isset($datos["num_ind_cancer"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_NOF_CANCER"                 =>  $datos["num_ind_cancer"]));
                }
                if(isset($datos["ind_conf_informepdf"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_CONF_PAG"                   =>  $datos["ind_conf_informepdf"]));
                }
                if(isset($datos["txt_macroscopia"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("TXT_DESC_MACROSCOPICA"          =>  trim($datos["txt_macroscopia"]) )); 
                }
                if(isset($datos["txt_citologico"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("TXT_CITOLOGICO"                 =>  trim($datos["txt_citologico"]) )); 
                }
                if(isset($datos["txt_citologico"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("TXT_DIAG_CITOLOGIA"             =>  trim($datos["txt_diagnostico_citologico"]) )); 
                }
            }
        }
        
        if(count($hispatologico["formulario_administrativo"])>0){
           foreach ($hispatologico["formulario_administrativo"] as $i => $datos){
                if(isset($datos["ind_profesional_acargo"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("ID_PROFESIONAL"                 =>  $datos["ind_profesional_acargo"] ) );
                }
                if(isset($datos["ind_profesional_acargo_citologico"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("ID_PROFESIONAL_CITOLOGICO"      =>  $datos["ind_profesional_acargo_citologico"] ) );
                }
                if(isset($datos["num_beneficiarios"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_BENEFICIARIOS"              =>  $datos["num_beneficiarios"]));
                }
                if(isset($datos["ind_mes_critico"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_MES_CRITICO"                =>  $datos["ind_mes_critico"]));
                }
                if(isset($datos["date_impresion_informe"]) && $datos["date_impresion_informe"]!=''){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_IMPRESION_INFORME"         =>  "TO_DATE('".$datos["date_impresion_informe"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["date_hora_fecha_entrga_informe"]) && $datos["date_hora_fecha_entrga_informe"]!=' '){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_ENTREGA_INFORME"           =>  "TO_DATE('".$datos["date_hora_fecha_entrga_informe"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["ind_profesional_entrega_informe"]) && $datos["ind_profesional_entrega_informe"]!=''){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("ID_PROFESIONAL_ENTREGA_INFO"    =>  $datos["ind_profesional_entrega_informe"]));
                }
                if(isset($datos["ind_profesional_recibe_informe"]) && $datos["ind_profesional_recibe_informe"]!=''){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("ID_PROFESIONAL_RECIBE_INFO"     =>  $datos["ind_profesional_recibe_informe"]));
                }
                if(isset($datos["n_notificacion"    ])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_NOTIFICACION"               =>  $datos["n_notificacion"]));
                }
                if(isset($datos["date_chequeo_some"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_CHEQUEO_SOME"              =>  "TO_DATE('".$datos["date_chequeo_some"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["date_revision_bd"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_REVISION_BD"               =>  "TO_DATE('".$datos["date_revision_bd"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["date_revision_informe"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_REVISION_INFORME"          =>  "TO_DATE('".$datos["date_revision_informe"]."','DD-MM-YYYY hh24:mi')"));
                }
                if(isset($datos["date_archivada_en_ficha"])){
                    $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_ARCHIVADA_EN_FICHA"        =>  "TO_DATE('".$datos["date_archivada_en_ficha"]."','DD-MM-YYYY hh24:mi')"));
                }
            }
            
            if(count($hispatologico["formulario_tecnologo_med"])>0){
                foreach ($hispatologico["formulario_tecnologo_med"] as $i => $datos){
                    # INFORMACION COMPLEMENTARIA
                    if(isset($datos["date_fecha_macro"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_FECHA_MACRO"               =>  "TO_DATE('".$datos["date_fecha_macro"]."','DD-MM-YYYY')"));
                    }
                    if(isset($datos["date_fecha_corte"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_FECHA_CORTE"               =>  "TO_DATE('".$datos["date_fecha_corte"]."','DD-MM-YYYY')"));
                    }
                    if(isset($datos["ind_color_taco"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_COLOR_TACO"                 =>  $datos["ind_color_taco"]));
                    }
                    if(isset($datos["ind_estado_olga"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_ESTADO_OLGA"                =>  $datos["ind_estado_olga"]));
                    }
                    if(isset($datos["date_interconsulta_ap"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_INTERCONSULTA"             =>  "TO_DATE('".$datos["date_fecha_corte"]."','DD-MM-YYYY')"));
                    }
                    if(isset($datos["num_copia_inerconsulta"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_CP_INTERCONSULTA"           =>  $datos["num_copia_inerconsulta"]));
                    }
                    if(isset($datos["num_fragmentos"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_FRAGMENTOS"                 =>  $datos["num_fragmentos"]));
                    }
                    if(isset($datos["num_tacos_cortados"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_TACOS_CORTADOS"             =>  $datos["num_tacos_cortados"]));
                    }
                    if(isset($datos["num_extendidos"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_EXTENDIDOS"                 =>  $datos["num_extendidos"]));
                    }
                    # INFORMACION ADICIONAL
                    if(isset($datos["num_azul_alcian_seriada"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_AZUK_ALCIAN_S"              =>  $datos["num_azul_alcian_seriada"]));
                    }
                    if(isset($datos["num_pas_seriada"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_PAS_SERIADA"                =>  $datos["num_pas_seriada"]));
                    }
                    if(isset($datos["num_diff_seriada"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_DIFF_SERIADA"               =>  $datos["num_diff_seriada"]));
                    }
                    if(isset($datos["num_he_seriada"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_HE_SERIADA"                 =>  $datos["num_he_seriada"]));
                    }
                    if(isset($datos["num_all_laminas_seriadas"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_LAMINAS_SERIADAS"           =>  $datos["num_all_laminas_seriadas"]));
                    }
                    if(isset($datos["num_he_rapida"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_HE_RAPIDA"                  =>  $datos["num_he_rapida"]));
                    }
                }
            }
        }
        
        #VULVE A CERO
        $this->db->where('ID_SOLICITUD_HISTO',$id_anatomia); 
        $this->db->update($this->ownPab.'.PB_TPRESTAXANATOMIA',array("IND_ESTADO"=>0,"USR_AUDITA"=>$session,"DATE_AUDITA"=>"SYSDATE"));
        if(isset($hispatologico["arr_prestaciones"])){
            foreach($hispatologico["arr_prestaciones"][0] as $i => $row_prestaciones){
                $arr_return      =   $this->db->query("SELECT A.ID_TPRESTAXANATOMIA FROM $this->ownPab.PB_TPRESTAXANATOMIA A WHERE A.COD_PRESTA IN('".$row_prestaciones."') AND A.ID_SOLICITUD_HISTO IN ($id_anatomia)")->result_array();
                if(count($arr_return)>0){
                    $this->db->where('ID_TPRESTAXANATOMIA',$arr_return[0]["ID_TPRESTAXANATOMIA"]); 
                    $this->db->update($this->ownPab.'.PB_TPRESTAXANATOMIA',array("IND_ESTADO"=>1,"USR_AUDITA"=>$session,"DATE_AUDITA"=>"SYSDATE"));
                } else {
                    $id_tprestacionesxanatomia     =    $this->db->sequence($this->ownPab,'SEQ_TPRESTAXANATOMIA');
                    $new_pestacion                 =    array(
                                                            'DATE_CREA'             =>  'SYSDATE',
                                                            'USR_CREA'              =>  $session,
                                                            'IND_ESTADO'            =>  '1',
                                                            'COD_PRESTA'            =>  $row_prestaciones,
                                                            'ID_SOLICITUD_HISTO'    =>  $id_anatomia,
                                                            'ID_TPRESTAXANATOMIA'   =>  $id_tprestacionesxanatomia,
                                                        );
                    $this->db->insert($this->ownPab.'.PB_TPRESTAXANATOMIA',$new_pestacion); 
                }
            }
        }
        #
        $this->db->where('ID_SOLICITUD_HISTO',$id_anatomia); 
        $this->db->update($this->ownPab.'.PB_TORGANOXANATOMIA',array("IND_ESTADO"=>0,"USR_AUDITA"=>$session,"DATE_AUDITA"=>"SYSDATE"));
        if(isset($hispatologico["arr_organos"])){
            foreach($hispatologico["arr_organos"][0] as $i => $arr_organos){
                $arr_return                         =   $this->db->query("SELECT A.ID_TORGANOXANATOMIA FROM $this->ownPab.PB_TORGANOXANATOMIA A WHERE A.ID_ORGANO_AP IN($arr_organos) AND A.ID_SOLICITUD_HISTO IN ($id_anatomia)")->result_array();
                if(count($arr_return)>0){
                    $this->db->where('ID_TORGANOXANATOMIA',$arr_return[0]["ID_TORGANOXANATOMIA"]); 
                    $this->db->update($this->ownPab.'.PB_TORGANOXANATOMIA',array("IND_ESTADO"=>1,"USR_AUDITA"=>$session,"DATE_AUDITA"=>"SYSDATE"));
                } else {
                    $new_pestacion                  =   array(
                                                            'DATE_CREA'             =>  'SYSDATE',
                                                            'USR_CREA'              =>  $session,
                                                            'IND_ESTADO'            =>  '1',
                                                            'ID_ORGANO_AP'          =>  $arr_organos,
                                                            'ID_SOLICITUD_HISTO'    =>  $id_anatomia,
                                                            'ID_TORGANOXANATOMIA'   =>  $this->db->sequence($this->ownPab,'SEQ_TORGANOXANATOMIA'),
                                                        );
                    $this->db->insert($this->ownPab.'.PB_TORGANOXANATOMIA',$new_pestacion); 
                }
            }
        }
        #
        $this->db->where('ID_SOLICITUD_HISTO',$id_anatomia); 
        $this->db->update($this->ownPab.'.PB_TPATOLOGIAXANATOMIA',array("IND_ESTADO"=>0,"USR_AUDITA"=>$session,"DATE_AUDITA"=>"SYSDATE"));
        if(isset($hispatologico["arr_patologias"])){
            foreach($hispatologico["arr_patologias"][0] as $i => $arr_patologia){
                $arr_return                         =   $this->db->query("SELECT A.ID_TPATOLOGIAXANATOMIA FROM $this->ownPab.PB_TPATOLOGIAXANATOMIA A WHERE A.ID_PATOLOGIA_AP IN ($arr_patologia) AND A.ID_SOLICITUD_HISTO IN ($id_anatomia)")->result_array();
                if(count($arr_return)>0){
                    $this->db->where('ID_TPATOLOGIAXANATOMIA',$arr_return[0]["ID_TPATOLOGIAXANATOMIA"]); 
                    $this->db->update($this->ownPab.'.PB_TPATOLOGIAXANATOMIA',array("IND_ESTADO"=>1,"USR_AUDITA"=>$session,"DATE_AUDITA"=>"SYSDATE"));
                } else {
                    $new_pestacion          =   array(
                                                    'DATE_CREA'             =>  'SYSDATE',
                                                    'USR_CREA'              =>  $session,
                                                    'IND_ESTADO'            =>  '1',
                                                    'ID_PATOLOGIA_AP'       =>  $arr_patologia,
                                                    'ID_SOLICITUD_HISTO'    =>  $id_anatomia,
                                                    'ID_TPATOLOGIAXANATOMIA'=>  $this->db->sequence($this->ownPab,'SEQ_TPATOLOGIAXANATOMIA'),
                                                );
                    $this->db->insert($this->ownPab.'.PB_TPATOLOGIAXANATOMIA',$new_pestacion); 
                }
            }
        }
        
        #FONASA MAI
        $this->db->where('ID_SOLICITUD_HISTO',$id_anatomia); 
        $this->db->update($this->ownPab.'.PB_TPRESTACIONXANATOMIA',array("IND_ESTADO"=>0,"USR_AUDITA"=>$session,"DATE_AUDITA"=>"SYSDATE"));
        if(isset($hispatologico["arr_fonasa"])){
            foreach($hispatologico["arr_fonasa"][0] as $i => $arr_fonasa){
                $arr_return     =   $this->db->query("SELECT A.ID_TPRESTACIONXANATOMIA FROM $this->ownPab.PB_TPRESTACIONXANATOMIA A WHERE A.COD_PRESTACION IN ($arr_fonasa) AND A.ID_SOLICITUD_HISTO IN ($id_anatomia)")->result_array();
                if(count($arr_return)>0){
                    $this->db->where('ID_TPRESTACIONXANATOMIA',$arr_return[0]["ID_TPRESTACIONXANATOMIA"]); 
                    $this->db->update($this->ownPab.'.PB_TPRESTACIONXANATOMIA',array("IND_ESTADO"=>1,"USR_AUDITA"=>$session,"DATE_AUDITA"=>"SYSDATE"));
                } else {
                    $new_pestacion          =   array(
                                                    'ID_TPRESTACIONXANATOMIA'   =>  $this->db->sequence($this->ownPab,'SEQ_TPRESTACIONXANATOMIA'),
                                                    'COD_PRESTACION'            =>  $arr_fonasa,
                                                    'DATE_CREA'                 =>  'SYSDATE',
                                                    'USR_CREA'                  =>  $session,
                                                    'IND_ESTADO'                =>  '1',
                                                    'ID_SOLICITUD_HISTO'        =>  $id_anatomia,
                                                );
                    $this->db->insert($this->ownPab.'.PB_TPRESTACIONXANATOMIA',$new_pestacion); 
                }
            }
        }
        
        
        
        $date_hoy                           =   date("d-m-Y");
        if($aData['id_salida']  ==  2){
            $dataSolicitud                  =   array_merge($dataSolicitud,array(
                "ID_HISTO_ZONA"             =>  8,#EN SALA DE PROCESO
                "DATE_FECHA_DIAGNOSTICO"    =>  "SYSDATE",
                #"DATE_IMPRESION_INFORME"   =>  "TO_DATE('".$date_hoy."','DD-MM-YYYY hh24:mi')", 
                "LAST_USR_AUDITA"           =>  $aData["session"],
                "LAST_DATE_AUDITA"          =>  "SYSDATE",
                #"USR_AUDITA"               =>  $aData["session"],
                #"DATE_AUDITA"              =>  "SYSDATE",
            ));
        }
        $this->db->where('ID_SOLICITUD_HISTO',$id_anatomia); 
        $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',$dataSolicitud);
        
        $this->db->trans_complete();
        return array('status'=>true,'date_cierre'=>$date_hoy);
    }
    
    public function update_li_chat($aData){
        $this->db->trans_start();
        $arr_return      =   $this->db->query("
            SELECT 
                P.ID_TCHATANATOMIA, 
                G.FIRST_NAME||' '||G.MIDDLE_NAME||' '||G.LAST_NAME              AS TXT_USER,
                P.DATE_CREA, 
                P.USR_CREA, 
                P.IND_ESTADO, 
                P.TXT_CHAT_ANATOMIA, 
                TO_CHAR(P.DATE_CREA,'DD-MM-YYYY hh24:mi')                       AS CHAR_DATE_CREA,  
                P.ID_SOLICITUD_HISTO, 
                P.ID_UID
            FROM 
                $this->ownPab.PB_TCHATANATOMIA       P,
                GUADMIN.FE_USERS                G
            WHERE 
                P.ID_SOLICITUD_HISTO IN (".$aData["id_anatomia"].") 
                AND
                G.ID_UID = P.ID_UID
                AND
                P.IND_ESTADO IN (1)
                ORDER BY 
                P.DATE_CREA
                ")->result_array();
        $this->db->trans_complete();
        return array(
                    'status'        =>  true,
                    'return_data'   =>  $arr_return
                );
    }
    
    public function ap_subir_imagenprotoclo_ap($cod_empresa,$ID_ANATOMIA,$GET_SALA){
        #$context                   =   stream_context_create(array('http'=>array('ignore_errors'=>true,'header'=>"User-Agent:MyAgent/1.0\r\n")));
        $result                     =   [];
        #$blob                       =   oci_new_descriptor($this->db->conn_id,OCI_D_LOB);
        #$blob->writeTemporary(file_get_contents($_FILES["IMG_PROTOCOLO"]["tmp_name"]));
        $base64_string = $_POST['IMG_PROTOCOLO_BASE64'];  // Recuperar la cadena base64
        #$image_data = explode(',', $base64_string)[1];  // Separar la información de encabezado
        #$blob_data = base64_decode($image_data);  // Decodificar la cadena base64
        $blob = oci_new_descriptor($this->db->conn_id, OCI_D_LOB);
        $blob->writeTemporary($base64_string);  // Escribir los datos decodificados en un descriptor LOB
        #var_dump("GET_SALA  ->  ",$GET_SALA);
        $ID_IMAGEN                  =   '';
        $param                      =   array(
                                            array( 
                                                'name'      =>  ':ID_HISTO_ZONA',
                                                'value'     =>  $GET_SALA,
                                                'length'    =>  50,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':ID_TABLA',
                                                'value'     =>  $ID_ANATOMIA,
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_SESSION',
                                                'value'     =>  explode("-",$this->session->userdata("USERNAME"))[0],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_ID_UID',
                                                'value'     =>  $this->session->userdata["ID_UID"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_COD_EMPRESA',
                                                'value'     =>  $cod_empresa,
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_NAME_IMG',
                                                'value'     =>  $_FILES["IMG_PROTOCOLO"]["name"],
                                                //'value'   =>  0,
                                                'length'    =>  256,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_SIZE_IMG',
                                                'value'     =>  $_FILES["IMG_PROTOCOLO"]["type"],
                                                //'value'   =>  0,
                                                'length'    =>  256,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_SIZE_TYPE',
                                                'value'     =>  $_FILES["IMG_PROTOCOLO"]["size"],
                                                //'value'   =>  0,
                                                'length'    =>  256,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':P_CLOB_DATA',
                                                'value'     =>  $blob,
                                                'length'    =>  -1,
                                                'type'      =>  SQLT_CLOB
                                            ),
                                            array( 
                                                'name'      =>  ':RETURN_CURSOR',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                        );
        $result                         =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','GET_BLOB_DATA',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                    =>  $this->db->trans_status(),
            'RETURN_CURSOR'             =>  empty($result[':RETURN_CURSOR'])?null:$result[':RETURN_CURSOR'],
        );
    }
    
    public function subir_imagenprotoclo_ap_x_muestra($aData){
        $base64_string = $_POST['IMG_PROTOCOLO_BASE64'];    // Recuperar la cadena base64
        $blob = oci_new_descriptor($this->db->conn_id, OCI_D_LOB);
        $blob->writeTemporary($base64_string);              // Escribir los datos decodificados en un descriptor LOB
        $ID_IMAGEN                  =   '';
        $param                      =   array(
                                            array( 
                                                'name'      =>  ':VAL_ID_IMAGEN',
                                                'value'     =>  null,
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_ID_SOLICITUD',
                                                'value'     =>  $aData['id_anatomia'],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_ID_MUESTRA',
                                                'value'     =>  $aData['id_muestra'],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_ID_CASETE',
                                                'value'     =>  '',
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_IND_ZONA',
                                                'value'     =>  $aData['ind_zona'],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_SESSION',
                                                'value'     =>  explode("-",$this->session->userdata("USERNAME"))[0],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_ID_UID',
                                                'value'     =>  $this->session->userdata["ID_UID"],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_COD_EMPRESA',
                                                'value'     =>  $aData['empresa'],
                                                'length'    =>  20,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_NAME_IMG',
                                                'value'     =>  $_FILES["IMG_PROTOCOLO"]["name"],
                                                //'value'   =>  0,
                                                'length'    =>  256,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_SIZE_IMG',
                                                'value'     =>  $_FILES["IMG_PROTOCOLO"]["type"],
                                                //'value'   =>  0,
                                                'length'    =>  256,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':VAL_SIZE_TYPE',
                                                'value'     =>  $_FILES["IMG_PROTOCOLO"]["size"],
                                                //'value'   =>  0,
                                                'length'    =>  256,
                                                'type'      =>  SQLT_CHR 
                                            ),
                                            array( 
                                                'name'      =>  ':P_CLOB_DATA',
                                                'value'     =>  $blob,
                                                'length'    =>  -1,
                                                'type'      =>  SQLT_CLOB
                                            ),
                                            array( 
                                                'name'      =>  ':RETURN_CURSOR',
                                                'value'     =>  $this->db->get_cursor(),
                                                'length'    =>  -1,
                                                'type'      =>  OCI_B_CURSOR
                                            ),
                                        );
        $result = $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','ANATOMIA_IMG_X_MUESTRAS',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'        =>  true,
            'RETURN_CURSOR' =>  empty($result[':RETURN_CURSOR'])?null:$result[':RETURN_CURSOR'],
        );
    }

    
    public function graba_chat_anatomia($DATA){
        $this->db->trans_start();
        $param  =   array(
                        array( 
                            'name'      =>  ':V_ID_ANATOMIA',
                            'value'     =>  $DATA['id_anatomia'],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':TXT_CHAT_ANATOMIA',
                            'value'     =>  $DATA['txt_mensaje'],
                            'length'    =>  256,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':ID_UID',
                            'value'     =>  $this->session->userdata["ID_UID"],
                            'length'    =>  256,
                            'type'      =>  SQLT_CHR,
                        ),
                        array( 
                            'name'      =>  ':USR_CREA',
                            'value'     =>  explode("-",$this->session->userdata("USERNAME"))[0],
                            'length'    =>  256,
                            'type'      =>  SQLT_CHR,
                        ),
                        array( 
                            'name'      =>  ':IND_OPCION',
                            'value'     =>  $DATA['option'],
                            'length'    =>  256,
                            'type'      =>  SQLT_CHR,
                        ),
                        array( 
                            'name'      =>  ':C_CHAT_ANATOMIA',
                            'value'     =>  $this->db->get_cursor(),
                            'length'    =>  -1,
                            'type'      =>  OCI_B_CURSOR
                        ),
                        array( 
                            'name'      =>  ':LOG_CHAT',
                            'value'     =>  $this->db->get_cursor(),
                            'length'    =>  -1,
                            'type'      =>  OCI_B_CURSOR
                        ),
                    );
        $result =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','AP_GESTION_CHATXHOJA',$param);
        /*
        $session                        =   explode("-",$this->session->userdata("USERNAME"))[0];
        $id_chat                        =   $this->db->sequence($this->ownPab,'SEQ_CHAT_ANATOMIA_AP');
        $new_pestacion                  =   array(
                                            'ID_TCHATANATOMIA'      =>  $id_chat,
                                            'DATE_CREA'             =>  'SYSDATE',
                                            'USR_CREA'              =>  $session,
                                            'IND_ESTADO'            =>  '1',
                                            'TXT_CHAT_ANATOMIA'     =>  $DATA['txt_mensaje'],
                                            'ID_SOLICITUD_HISTO'    =>  $DATA['id_anatomia'],
                                            'ID_UID'                =>  $this->session->userdata["ID_UID"],
                                        );
        $this->db->insert($this->ownPab.'.PB_TCHATANATOMIA',$new_pestacion); 
        */
        $this->db->trans_complete();
        return array(
            'STATUS'                    =>  true,
            'BD'                        =>  $result,
            'C_CHAT_ANATOMIA'           =>  $result[":C_CHAT_ANATOMIA"],
        );
    }
    
    public function get_informe_macroscopica($DATA){
        $this->db->trans_start();
        if(count($DATA["accesdata"])>0){
            foreach($DATA["accesdata"] as $i => $row){
                #$this->db->where($row['tipo']=='muestra'?'ID_NMUESTRA':'ID_CASETE',$row['id']); 
                $this->db->where('ID_NMUESTRA',$row['id']); 
                $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array(
                    "IND_ESTADO"            =>  1,
                    "USR_AUDITA"            =>  $DATA['session'],
                    "DATE_AUDITA"           =>  "SYSDATE",
                    "TXT_DESC_MACROSCOPICA" =>  $row['txt'],
                    "DATE_MACROSCOPIA"      =>  "SYSDATE",
                    "USER_MACROSCOPICA"     =>  $DATA['session']
                ));
            }
            #PASA A SALA DE PROCESO = ID_HISTO_ZONA = 1
            $this->db->where('ID_SOLICITUD_HISTO',$DATA["id_anatomia"]); 
            $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',array(
                "ID_HISTO_ZONA"             =>  1,#AVANZA DE ZONA
                "TXT_DESC_MACROSCOPICA"     =>  $DATA["array_main"][0]["txt"],
                "DATE_MACROSCOPIA"          =>  "SYSDATE",
                "USER_MACROSCOPICA"         =>  $DATA['session']
            ));
        }
        $this->db->trans_complete();
        return array('status' => true);
    }
    
    public function get_elimina_imagen($DATA){
        $this->db->trans_start();
        $this->db->where('ID_MAIN',$DATA["img"]); 
        $this->db->update($this->ownPab.'.PB_MAIN_BLG_ANATOMIA',array(
            "IND_ESTADO"                =>  '0',
            "USR_AUDITA"                =>  $DATA["session"],#AVANZA DE ZONA
            "DATE_AUDITA"               =>  'SYSDATE',
        ));
        $this->db->trans_complete();
        return array('status' => true);
    }
    
    
    public function sqlvalidaclave($clave){
        $this->dbSession = $this->load->database('session', true); 
        $sql = "SELECT
                    ID_UID,
                    USERNAME,
                    NAME,
                    MIDDLE_NAME,
                    LAST_NAME,
                    TELEPHONE,
                    EMAIL
                FROM 
                    ADMIN.FE_USERS
                WHERE 
                    TX_INTRANETSSAN_CLAVEUNICA = ? AND DISABLE = 0";
        $query = $this->dbSession->query($sql,array($clave));
        return $query->result_array();
    }

    
    public function load_sala_proceso($data){
        $this->db->trans_start();
        $param          =   
                    array(
                        array( 
                            'name'      =>  ':V_COD_EMPRESA',
                            'value'     =>  $data["empresa"],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':VAL_OPCION',
                            'value'     =>  $data["opcion"],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':VAL_ID_ANATOMIA',
                            'value'     =>  $data["id_anatomia"],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':P_SALA_PROCESO',
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
                        array( 
                            'name'      =>  ':P_STATUS',
                            'value'     =>  $this->db->get_cursor(),
                            'length'    =>  -1,
                            'type'      =>  OCI_B_CURSOR
                        ),
                    );
        $result                         =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_SALA_PROCESO',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'                    =>  true,
            'bd'                        =>  $result,
            'opcion'                    =>  $data['opcion'],
        );
    }
    
    public function get_star_sala_proceso($data){
        $this->db->trans_start();
        $date                           =   $data["accesdata"]["form_star_sala_proceso"][0]["date_fecha_star_salaproceso"];
        $ind_tipo_proceso               =   $data["accesdata"]["form_star_sala_proceso"][0]["ind_proceso_sala"];
        $this->db->where('ID_SOLICITUD_HISTO',$data["id_anatomia"]); 
        $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',array(
            "ID_HISTO_ZONA"             =>  5,#EN SALA DE PROCESO
            "IND_ESTADO"                =>  1,
            "ID_UID_INICIO_SPROCESO"    =>  $data["user_firma"][0]["ID_UID"],
            "DATE_STAR_SALA_PROCESO"    =>  "TO_DATE('".$date."','DD-MM-YYYY hh24:mi')",
            "LAST_USR_AUDITA"           =>  $data["session"],
            "LAST_DATE_AUDITA"          =>  "SYSDATE",
            "IND_TIPO_PROCESO"          =>  $ind_tipo_proceso,
        ));
        $this->db->trans_complete();
        $this->db->trans_status();
        return array(
            'status'                    =>  true,
            'return_bd'                 =>  $data["user_firma"][0]["ID_UID"],
        );
    }
     
    public function get_final_sala_proceso($data){
        $this->db->trans_start();
        $date                           =   $data["accesdata"]["form_star_sala_proceso"][0]["date_fecha_final_salaproceso"];
        $this->db->where('ID_SOLICITUD_HISTO',$data["id_anatomia"]); 
        $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',array(
            "ID_HISTO_ZONA"             =>  6,#SALA DE TECNICAS
            "IND_ESTADO"                =>  1,
            "LAST_USR_AUDITA"           =>  $data["session"],
            "LAST_DATE_AUDITA"          =>  "SYSDATE",
            "ID_UID_FINAL_SPROCESO"     =>  $data["user_firma"][0]["ID_UID"],
            "DATE_END_SALA_PROCESO"     =>  "TO_DATE('".$date."','DD-MM-YYYY hh24:mi')",
            "IND_SALA_PROCESO"          =>  1,
        ));
        $this->db->trans_complete();
        $this->db->trans_status();
        return array(
            'status'                    =>  true,
            'return_bd'                 =>  $data["user_firma"][0]["ID_UID"],
        );
    }
    
    public function load_sala_inclusion($data){
        $this->db->trans_start();
        $param          =   
                    array(
                        #IN
                        array( 
                            'name'      =>  ':V_COD_EMPRESA',
                            'value'     =>  $data["empresa"],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':VAL_OPCION',
                            'value'     =>  $data["opcion"],
                            'length'    =>  20,
                            'type'      =>  SQLT_CHR 
                        ),
                        array( 
                            'name'      =>  ':VAL_ID_ANATOMIA',
                            'value'     =>  $data["id_anatomia"],
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
                        array( 
                            'name'      =>  ':P_TECNICAS_APLICADAS',
                            'value'     =>  $this->db->get_cursor(),
                            'length'    =>  -1,
                            'type'      =>  OCI_B_CURSOR
                        ),
                        array( 
                            'name'      =>  ':P_TECNICAS_APLICADASXMUESTRA',
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
                        array( 
                            'name'      =>  ':P_STATUS',
                            'value'     =>  $this->db->get_cursor(),
                            'length'    =>  -1,
                            'type'      =>  OCI_B_CURSOR
                        ),
                    );
        $result                         =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','LOAD_SALA_INCLUSION',$param);
        $this->db->trans_complete();
        $this->db->trans_commit();
        return array(
            'STATUS'                    =>  true,
            'data_bd'                   =>  $result,
            'opcion'                    =>  $data['opcion'],
        );
    }
    
    public function get_record_tec_tecnologo($data){
        $this->db->trans_start();
        $status                                     =   true;
        if(count($data["lis_checked"])>0){
            $this->db->where('ID_SOLICITUD_HISTO',$data["id_anatomia"]); 
            $this->db->update($this->ownPab.'.PB_MUESTRAXTECNICA',array("IND_ESTADO"=>0,"USR_AUDITA"=>$data["session"],"DATE_AUDITA"=>"SYSDATE"));
            foreach($data["lis_checked"] as $i => $row){
                $id_anatomia                        =   $row["ap"];
                $id_muestra                         =   $row["id"];
                foreach($row["txt"] as $x => $id_tecnica){
                    $arr_return                     =   $this->db->query("SELECT A.ID_TECNICAXMUES FROM $this->ownPab.PB_MUESTRAXTECNICA A WHERE A.ID_NMUESTRA IN($id_muestra) AND A.ID_TECNICA_AP IN ($id_tecnica)")->result_array();
                    if(count($arr_return)>0){
                        $this->db->where('ID_TECNICAXMUES',$arr_return[0]['ID_TECNICAXMUES']); 
                        $this->db->update($this->ownPab.'.PB_MUESTRAXTECNICA',array("IND_ESTADO"=>1,"USR_AUDITA"=>$data["session"],"DATE_AUDITA"=>"SYSDATE"));
                    } else {
                        $new_tecnica                =   array(
                            'ID_TECNICAXMUES'       =>  $this->db->sequence($this->ownPab,'SEQ_TECNICAXMUESTRA'),
                            'ID_TECNICA_AP'         =>  $id_tecnica,
                            'ID_NMUESTRA'           =>  $id_muestra,
                            'DATE_CREA'             =>  'SYSDATE',
                            'USR_CREA'              =>  $data["session"],
                            'IND_ESTADO'            =>  '1',
                            'ID_SOLICITUD_HISTO'    =>  $id_anatomia,
                        );
                        $this->db->insert($this->ownPab.'.PB_MUESTRAXTECNICA',$new_tecnica); 
                    }
                }
            }
        }
        #UPDATE MAIN DE ANATOMIA PATOLOGICA
        $dataSolicitud      =   array(
                                //"IND_ALL_TECNICAS"    =>  1,
                                "LAST_USR_AUDITA"       =>  $data["session"],
                                "LAST_DATE_AUDITA"      =>  "SYSDATE",
                            );
        $hispatologico                                  =   $data["accesdata"];
        if(count($hispatologico)>0)                     {
            if(count($hispatologico["formulario_sala_tecnica"][0])>0){
                foreach($hispatologico["formulario_sala_tecnica"][0] as $i => $datos){
                    #INFORMACION DE TECNOLOGO MEDICO
                    if(isset($datos["date_fecha_macro"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_FECHA_MACRO"               =>  "TO_DATE('".$datos["date_fecha_macro"]."','DD-MM-YYYY')"));
                    }
                    if(isset($datos["date_fecha_corte"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_FECHA_CORTE"               =>  "TO_DATE('".$datos["date_fecha_corte"]."','DD-MM-YYYY')"));
                    }
                    if(isset($datos["ind_color_taco"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_COLOR_TACO"                 =>  $datos["ind_color_taco"]));
                    }
                    if(isset($datos["ind_estado_olga"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_ESTADO_OLGA"                =>  $datos["ind_estado_olga"]));
                        #$dataSolicitud                 =     array_merge($dataSolicitud,array("IND_ESTADO_OLGA_TEC"            =>  $datos["ind_estado_olga"]));
                    }
                    if(isset($datos["date_interconsulta_ap"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("DATE_INTERCONSULTA"             =>  "TO_DATE('".$datos["date_fecha_corte"]."','DD-MM-YYYY')"));
                    }
                    if(isset($datos["num_copia_inerconsulta"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_CP_INTERCONSULTA"           =>  $datos["num_copia_inerconsulta"]));
                    }
                    if(isset($datos["num_fragmentos"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_FRAGMENTOS"                 =>  $datos["num_fragmentos"]));
                    }
                    if(isset($datos["num_tacos_cortados"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_TACOS_CORTADOS"             =>  $datos["num_tacos_cortados"]));
                    }
                    if(isset($datos["num_extendidos"])){
                        $dataSolicitud                  =     array_merge($dataSolicitud,array("NUM_EXTENDIDOS"                 =>  $datos["num_extendidos"]));
                    }
                    
                    #TECNICAS DEL TECNOLOGO -> INFO PASO A RCE PATOLOGIA -> 
                    #TECNICA INCLUSION
                    if(isset($datos["checked_inclusion"])){
                        if ($datos["checked_tincion"] === 'true'){
                            $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_TEC_INCLUCION"              =>1));
                        } else {
                            $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_TEC_INCLUCION"              =>0));
                        }
                    }
                    #TECNICA INCLUSION
                    if(isset($datos["checked_corte"])){
                        if ($datos["checked_tincion"] === 'true'){
                            $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_TEC_CORTE"                  =>1));
                        } else {
                            $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_TEC_CORTE"                  =>0));
                        }
                    }
                    #TECNICA TINCION
                    if(isset($datos["checked_tincion"])){
                        if ($datos["checked_tincion"] === 'true'){
                            $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_TEC_TINCION"                =>1));
                        } else {
                            $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_TEC_TINCION"                =>0));
                        }
                    }
                    #FINALIZACION
                    if(isset($datos["checked_tenicas_all"])){
                        //$dataSolicitud                      =     array_merge($dataSolicitud,array("IND_ALL_TECNICAS"               =>  $datos["checked_tenicas_all"]?1:0));
                        if ($datos["checked_tincion"] === 'true'){
                            $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_TEC_TINCION"                    =>1));
                        } else {
                            $dataSolicitud                  =     array_merge($dataSolicitud,array("IND_TEC_TINCION"                    =>0));
                        }
                    }
                }
            }
        }
        
        #AVANZA DE ZONA - PATOLOGO 
        if($data["val_cierre"]      ==  1){
            $dataSolicitud          =   array_merge($dataSolicitud,array(
                "ID_HISTO_ZONA"     =>  '7',
                "ID_UID_TECNICAS"   =>  $this->session->userdata["ID_UID"],
                "USR_TECNICAS"      =>  $data["session"],
                "DATE_TECNICAS"     =>  "SYSDATE",
            ));
        }
        
        $this->db->where('ID_SOLICITUD_HISTO',$data["id_anatomia"]);
        $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',$dataSolicitud);
        $this->db->trans_complete();
        $this->db->trans_commit();
        return array('status'=>$status);
    }
    
    public function load_gestion_cancer($DATA){
        $this->db->trans_start();
        $this->db->where('ID_SOLICITUD_HISTO',$DATA["id_anatomia"]); 
        if($DATA["opcion"] == 1 ){
            $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',array(
                "IND_NOTIF_CANCER"          =>  0,
            ));
        } else {
            $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',array(
                "IND_NOTIF_CANCER"          =>  1,
            ));
        }
        $this->db->trans_complete();
        $this->db->trans_commit();
        return array('status'=>true);
    }
    
    public function get_update_txt_macroscopica($DATA){
        $this->db->trans_start();
        $this->db->where('ID_NMUESTRA',$DATA['num_muestra']); 
        $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array(
            "TXT_DESC_MACROSCOPICA"=>$DATA['txt_update']
        ));
        $this->db->trans_complete();
        $this->db->trans_commit();
        return array('status'=>true);
    }
    
    public function ultimo_numero_disponible_cancer($valiable){
        $this->db->trans_start();
        $param              =   array(
                                    array( 
                                        'name'      =>  ':V_COD_EMPRESA',
                                        'value'     =>  $valiable["val_empresa"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_ID_ANATOMIA',
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
        $result             =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_ANATOMIA_PATOLOGIA','DATA_LAST_NUMERO_CANCER',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'	    =>	$this->db->trans_status(),
            'DATA'          =>  $result,
            'DATA_NUMBER'   =>  $result[':P_ULTIMO_NUMERO'],
            'P_STATUS'      =>  $result[':P_STATUS'],
        );
    }

    
}