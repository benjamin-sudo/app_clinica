<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class ssan_hdial_asignacionpaciente_model extends CI_Model {

    var $own            = "ADMIN";
    var $ownGu          = "GUADMIN";
    var $ownHd          = "ADMIN";

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('oracle_conteiner',true);
        $this->load->model("sql_class/sql_class_hdial");
        $this->load->model("sql_class/sql_class_pabellon");
    }

    public function buscar_diagnosticos($query){
        $queryUpper = strtoupper($query);
        $this->db->like('DESCRIPCION', $queryUpper);                # Asume que buscas coincidencias en la columna 'DESCRIPCION'
        $this->db->or_like('CODIGO_DG_BASE', $queryUpper);          # Asume que también quieres buscar en la columna 'CODIGO_DG_BASE'
        $this->db->limit(10);                                       # Limita los resultados a los primeros 10
        $query = $this->db->get('ADMIN.TGCD_CIE_DIAGNOSTICOS');     # Asume que tu tabla se llama 'TGCD_CIE_DIAGNOSTICOS'
        return $query->num_rows() > 0 ? $query->result_array() : [];
    }

    public function sql_busquedaEstadoAdmision($AD_ID_ADMISION){
        $query = $this->db->query($this->sql_class_hdial->sql_busquedaEstadoAdmision($AD_ID_ADMISION));
        return $query->result_array();
    }
    
    public function getDatosGeneralesxDial($IDHOJADIARIA){
        $query = $this->db->query($this->sql_class_hdial->sqlDatosGeneralesxDial($IDHOJADIARIA));
        return $query->result_array();
    }
    
    public function sql_FechaEgreso($AD_ID_ADMISION){
        $query = $this->db->query($this->sql_class_hdial->sql_FechaEgreso($AD_ID_ADMISION));
        return $query->result_array();
    }
    
    public function ListadoMaquinasDialisis($empresa,$estados){
        $query = $this->db->query($this->sql_class_hdial->sqlListadoMaquinasDialisis($empresa,$estados));
        return $query->result_array();
    }
    
    public function ModelbusquedaListadoPacienteHDial($empresa,$estados,$numFichae,$rutPac,$conIngresoC){
        $query = $this->db->query($this->sql_class_hdial->sqlbusquedaListadoPacienteHDial($empresa,$estados,$numFichae,$rutPac,$conIngresoC));
        return $query->result_array();
    }
    
    public function ModelbusquedaMaquinas($empresa){
        $query = $this->db->query($this->sql_class_hdial->sqlgetbusquedaTabsMes($empresa,'1'));
        return $query->result_array();
    }
    
    public function sqlTraePrevisionPacienteNfichaE($numfichae){
        $query = $this->db->query($this->sql_class_pabellon->sqlTraePrevisionPacienteNfichaE($numfichae));
        return $query->result_array();
    }
    
    public function sqlFichalocal($numfichae,$empresa){
        $query = $this->db->query($this->sql_class_hdial->sqlFichalocal($numfichae,$empresa));
        return $query->result_array();
    }
    
    public function getDatosSignosVitales($IDHOJADIARIA,$ETAPA){
        $query = $this->db->query($this->sql_class_hdial->sqlDatosSignosVitales($IDHOJADIARIA,$ETAPA));
        return $query->result_array();
    }
    
    public function getListadoTurnosxDiasG(){
        $query = $this->db->query($this->sql_class_hdial->sqlListadoTurnosxDiasG());
        return $query->result_array();
    }
    
    public function GetPacientesxCupo($empresa){
        $query = $this->db->query($this->sql_class_hdial->sqlPacientesxCupo($empresa));
        return $query->result_array();
    }
    
    public function ModelbusquedaListadoPacienteHDialxMaquina($empresa,$estados,$numFichae,$rutPac,$num_Maquina,$fecha_desde,$fecha_hasta){
        $query = $this->db->query($this->sql_class_hdial->sqlbusquedaListadoPacienteHDialxMaquina($empresa,$estados,$numFichae,$rutPac,$num_Maquina,$fecha_desde,$fecha_hasta));
        return $query->result_array();
    }
    
    public function getbusquedaListadoPacienteHDxMaquinaCAdmision($empresa,$num_Maquina,$fechaBusqueda){
        $query = $this->db->query($this->sql_class_hdial->sqlbusquedaListadoPacienteHDxMaquinaCAdmision($empresa,$num_Maquina,$fechaBusqueda));
        return $query->result_array();
    }
    
    public function getPacientesxCupoxDia($empresa,$fecha,$num_Maquina){
        $query = $this->db->query($this->sql_class_hdial->sqlPacientesxCupoxDia($empresa,$fecha,$num_Maquina));
        return $query->result_array();
    }
    
    public function proBusquedaHoradiaria($empresa,$fecha,$num_Maquina){
        $query = $this->db->query($this->sql_class_hdial->proBusquedaHoradiaria($empresa,$fecha,$num_Maquina));
        return $query->result_array();
    }
    
    public function proBusquedaHoradiaria_profActvNuevaAgenda($empresa,$fecha,$num_Maquina){
        $query = $this->db->query($this->sql_class_hdial->proBusquedaHoradiaria_profActvNuevaAgenda($empresa,$fecha,$num_Maquina));
        return $query->result_array();
    }
    
    public function proBuscaHojaDiaria($empresa,$fecha,$num_Maquina,$HD){
        $query = $this->db->query($this->sql_class_hdial->proBuscaHojaDiaria($empresa,$fecha,$num_Maquina,$HD));
        return $query->result_array();
    }
    
    public function proBuscaHojaDiaria_HD($HD){
        $query = $this->db->query($this->sql_class_hdial->proBuscaHojaDiaria_HD($HD));
        return $query->result_array();
    }
    
    public function profActvNuevaAgenda($empresa){
        $query = $this->db->query($this->sql_class_hdial->profActvNuevaAgenda($empresa));
        return $query->result_array();
    }
    
    public function profActvNuevaAgenda_por_mantenedor($empresa){
         $query = "SELECT 
                    A.COD_RUTPRO,  
                    A.ID_PROFESIONAL                                                                   AS ID_PRO,
                    A.COD_DIGVER                                                                       AS COD_DIGVER,
                    DECODE (C.IND_TIPOATENCION,
                    '01','slc_medico','15','slc_medico',
                    '02','slc_enfermeria',
                    '12','slc_tecpara','no_info')                                                      AS HTML_OUT,
                    UPPER(A.NOM_APEPAT)||' ' ||UPPER(A.NOM_APEMAT)||' ' ||UPPER(A.NOM_NOMBRE)          AS NOM_PROFE,
                    C.DES_TIPOATENCION                                                                 AS DES_TIPOATENCION,
                    B.COD_TPROFE                                                                       AS COD_TPROFE,
                    B.NOM_TPROFE                                                                       AS NOM_TPROFE,
                    C.IND_TIPOATENCION                                                                 AS IND_TIPOATENCION
                FROM 
                    ADMIN.GG_TPROFESIONAL           A,
                    ADMIN.GG_TPROFESION             B,
                    ADMIN.AP_TTIPOATENCION          C,
                    ADMIN.AP_TPROFXESTABL           D,
                    ADMIN.HD_RRHHDIALISIS           H
                WHERE 
                    A.IND_ESTADO                    =   'V'
                    AND D.IND_ESTADO                =   'V'
                    AND A.COD_TPROFE                =   B.COD_TPROFE
                    AND B.IND_TIPOATENCION          =   C.IND_TIPOATENCION
                    AND A.COD_RUTPRO                =   D.COD_RUTPRO
                    AND D.COD_EMPRESA               IN  ($empresa)
                    AND H.COD_RUTPRO                =   A.COD_RUTPRO
                    AND H.IND_ESTADO                IN  (1)
                ORDER BY C.IND_TIPOATENCION, A.NOM_APEPAT ";
            return  $this->db->query($query)->result_array();
    }
    
    public function getbusquedadecuposporagendahd($fechaini,$fechafin,$empresa,$numfichae) {
        $query = $this->db->query($this->sql_class_hdial->getbusquedadecuposporagendahd($fechaini,$fechafin,$empresa,$numfichae));
        return $query->result_array();
    }
    
    public function sql_BusquedaRRHHHD($HD,$OP){
        $query = $this->db->query($this->sql_class_hdial->sql_BusquedaRRHHHD($HD,$OP));
        return $query->result_array();
    }
    
    public function ModelInformacionComplementaria($empresa,$numfichae){
        $query = $this->db->query($this->sql_class_hdial->sqlInformacionComplementaria($empresa,$numfichae));
        return $query->result_array();
    }
 
    public function sqlInformacionComplementariaPesoSeco($empresa,$numfichae){
        $query = $this->db->query($this->sql_class_hdial->sqlInformacionComplementariaPesoSeco($empresa,$numfichae));
        return $query->result_array();
    }
    
    public function getDatosReacionesAdversas($hojadiaria){
        $query = $this->db->query($this->sql_class_hdial->sqlDatosReacionesAdversas($hojadiaria));
        return $query->result_array();
    }
    
    public function getbusquedaExamenes($fechaini,$fechafin,$empresa,$num_fichae){
        $query = $this->db->query($this->sql_class_hdial->sqlbusquedaExamenes($fechaini,$fechafin,$empresa,$num_fichae));
        return $query->result_array();
    }
    
    public function sqlbusquedanombreexamen($fechaini,$fechafin,$empresa,$num_fichae){
        $query = $this->db->query($this->sql_class_hdial->sqlbusquedanombreexamen($fechaini,$fechafin,$empresa,$num_fichae));
        return $query->result_array();
    }
    
    public function sql_reacionesAdversas($id){
        $query = $this->db->query($this->sql_class_hdial->sql_reacionesAdversas($id));
        return $query->result_array();
    }
    
    public function ModelbuscaInfoLLave($id){
        $query = $this->db->query($this->sql_class_hdial->ModelbuscaInfoLLave($id));
        return $query->result_array();
    }
    
    public function ModelguardaInformacionimedico($empresa,$session,$numfichae,$form){
        $this->db->trans_start();
        //$numcupoxpaciente     =   $this->db->sequence($this->own,'SEQ_HDIAL_IMEDICO');
        $UpdTurno               =   array('IND_ESTADO'=> 0,'COD_USRAUDITA' => $session,'FEC_USRAUDITA'=>'SYSDATE');
        $this->db->where('NUM_FICHAE', $numfichae);
        $this->db->update($this->own.'.HD_IMEDICO', $UpdTurno);
        $ID_MEDICO              =   $this->db->sequence($this->own,'SEQ_HDIAL_IMEDICO');
        $dataIngreso            =   array('COD_USRCREA'=> $session,'FEC_USRCREA'=> 'SYSDATE' , 'ID_IMEDICO' => $ID_MEDICO ,  'NUM_FICHAE' => $numfichae ,'IND_ESTADO'=>1);
        if (count($form)>0){
            foreach($form as $From){
                if($From['name'] == 'TXT_ACCESOVAS_1')  { $dataIngreso = array_merge($dataIngreso, array('TXTACCESOVAS_1'           => $From['value']));}
                //if($From['name'] == 'NUM_DIAS_1')       { $dataIngreso = array_merge($dataIngreso, array('NUM_DIASVAS_1'            => $From['value']));}
                if($From['name'] == 'TXT_ACCESOVAS_2')  { $dataIngreso = array_merge($dataIngreso, array('TXTACCESOVAS_2'           => $From['value']));}
                //if($From['name'] == 'NUM_DIAS_2')       { $dataIngreso = array_merge($dataIngreso, array('NUM_DIASVAS_2'            => $From['value']));}
                
                if($From['name'] == 'FEC_DIAS_1')       { $dataIngreso = array_merge($dataIngreso, array('FEC_DIASVAS_1'            => "TO_DATE('".$From['value']."', 'DD-MM-YYYY')",  ));}
                if($From['name'] == 'FEC_DIAS_2' && $From['value'] != ''){ 
                                                          $dataIngreso = array_merge($dataIngreso, array('FEC_DIASVAS_2'            => "TO_DATE('".$From['value']."', 'DD-MM-YYYY')",  ));
                                                        } else { error_log("------------------NO FEC_DIAS_2>"); }
                
                if($From['name'] == 'NUM_ARTERIAL')     { $dataIngreso = array_merge($dataIngreso, array('NUM_TROCAR_ARTERIAL'      => $From['value']));}
                if($From['name'] == 'NUM_VENOSO')       { $dataIngreso = array_merge($dataIngreso, array('NUM_TROCAR_VENOSO'        => $From['value']));}

                if($From['name'] == 'NUM_INICIO')       { $dataIngreso = array_merge($dataIngreso, array('NUM_HEPARINA_INICIO'      => $From['value']));}
                if($From['name'] == 'NUM_MANTENCION')   { $dataIngreso = array_merge($dataIngreso, array('NUM_HEPARINA_MAN'         => $From['value']));}

                if($From['name'] == 'NUM_QT')           { $dataIngreso = array_merge($dataIngreso, array('NUM_QT'                   => $From['value']));}
                if($From['name'] == 'NUM_QB')           { $dataIngreso = array_merge($dataIngreso, array('NUM_QB'                   => $From['value']));}
                if($From['name'] == 'NUM_QD')           { $dataIngreso = array_merge($dataIngreso, array('NUM_QD'                   => $From['value']));}

                if($From['name'] == 'NUM_UFMAX')        { $dataIngreso = array_merge($dataIngreso, array('NUM_UFMAX'                => $From['value']));}
                if($From['name'] == 'NUM_UFMAX_UM')     { $dataIngreso = array_merge($dataIngreso, array('NUM_UFMAX_UM'             => $From['value']));}
                
                if($From['name'] == 'NUM_K')            { $dataIngreso = array_merge($dataIngreso, array('NUM_K'                    => $From['value']));}
                if($From['name'] == 'NUM_NA')           { $dataIngreso = array_merge($dataIngreso, array('NUM_NA'                   => $From['value']));}
                if($From['name'] == 'NUM_CONCENTRADO')  { $dataIngreso = array_merge($dataIngreso, array('NUM_CONCENTRADO'          => $From['value']));}
                
                if($From['name'] == 'input_pesoSeco')   { $dataIngreso = array_merge($dataIngreso, array('NUM_PESOSECO'             => $From['value']));}
            }
        }
        
        $this->db->insert($this->own.'.HD_IMEDICO', $dataIngreso); 
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function ModelguardaInformacionimedico_2($aData){
        $empresa        =   $aData['empresa'];
        $session        =   $aData['session'];
        $numfichae      =   $aData['numfichae'];
        $form           =   $aData['form'];
        $this->db->trans_start();
        $this->db->where('NUM_FICHAE', $numfichae);
        $this->db->update($this->own.'.HD_IMEDICO', ['IND_ESTADO'=> 0,'COD_USRAUDITA' => $session,'FEC_USRAUDITA'=>'SYSDATE']);
        $ID_MEDICO      =   $this->db->sequence($this->own,'SEQ_HDIAL_IMEDICO');
        $dataIngreso    =   array('COD_USRCREA'=> $session,'FEC_USRCREA'=> 'SYSDATE' , 'ID_IMEDICO' => $ID_MEDICO ,  'NUM_FICHAE' => $numfichae ,'IND_ESTADO'=>1);
        if (count($form)>0){
            foreach($form as $From){
                if($From['name'] == 'TXT_ACCESOVAS_1')  { $dataIngreso = array_merge($dataIngreso, array('TXTACCESOVAS_1'           => $From['value']));}
                //if($From['name'] == 'NUM_DIAS_1')       { $dataIngreso = array_merge($dataIngreso, array('NUM_DIASVAS_1'            => $From['value']));}
                if($From['name'] == 'TXT_ACCESOVAS_2')  { $dataIngreso = array_merge($dataIngreso, array('TXTACCESOVAS_2'           => $From['value']));}
                //if($From['name'] == 'NUM_DIAS_2')       { $dataIngreso = array_merge($dataIngreso, array('NUM_DIASVAS_2'            => $From['value']));}
                
                if($From['name'] == 'FEC_DIAS_1')       { $dataIngreso = array_merge($dataIngreso, array('FEC_DIASVAS_1'            => "TO_DATE('".$From['value']."', 'YYYY-MM-DD')",  ));}
                if($From['name'] == 'FEC_DIAS_2' && $From['value'] != ''){ 
                                                          $dataIngreso = array_merge($dataIngreso, array('FEC_DIASVAS_2'            => "TO_DATE('".$From['value']."', 'YYYY-MM-DD')",  ));
                                                        } else { error_log(" - NO FEC_DIAS_2 - "); }
                
                if($From['name'] == 'NUM_ARTERIAL')     { $dataIngreso = array_merge($dataIngreso, array('NUM_TROCAR_ARTERIAL'      => $From['value']));}
                if($From['name'] == 'NUM_VENOSO')       { $dataIngreso = array_merge($dataIngreso, array('NUM_TROCAR_VENOSO'        => $From['value']));}

                if($From['name'] == 'NUM_INICIO')       { $dataIngreso = array_merge($dataIngreso, array('NUM_HEPARINA_INICIO'      => $From['value']));}
                if($From['name'] == 'NUM_MANTENCION')   { $dataIngreso = array_merge($dataIngreso, array('NUM_HEPARINA_MAN'         => $From['value']));}

                if($From['name'] == 'NUM_QT')           { $dataIngreso = array_merge($dataIngreso, array('NUM_QT'                   => $From['value']));}
                if($From['name'] == 'NUM_QB')           { $dataIngreso = array_merge($dataIngreso, array('NUM_QB'                   => $From['value']));}
                if($From['name'] == 'NUM_QD')           { $dataIngreso = array_merge($dataIngreso, array('NUM_QD'                   => $From['value']));}

                if($From['name'] == 'NUM_UFMAX')        { $dataIngreso = array_merge($dataIngreso, array('NUM_UFMAX'                => $From['value']));}
                if($From['name'] == 'NUM_UFMAX_UM')     { $dataIngreso = array_merge($dataIngreso, array('NUM_UFMAX_UM'             => $From['value']));}
                
                if($From['name'] == 'NUM_K')            { $dataIngreso = array_merge($dataIngreso, array('NUM_K'                    => $From['value']));}
                if($From['name'] == 'NUM_NA')           { $dataIngreso = array_merge($dataIngreso, array('NUM_NA'                   => $From['value']));}
                if($From['name'] == 'NUM_CONCENTRADO')  { $dataIngreso = array_merge($dataIngreso, array('NUM_CONCENTRADO'          => $From['value']));}
                
                if($From['name'] == 'input_pesoSeco')   { $dataIngreso = array_merge($dataIngreso, array('NUM_PESOSECO'             => $From['value']));}
            }
        }
        $this->db->insert($this->own.'.HD_IMEDICO', $dataIngreso); 
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function sqlRegistraConsultaHistorialExamenes($NAME,$firmado_por,$NUM_FICHAE,$sistema,$idcita,$token,$RUT_PAC,$TIPO_ACCESS){
        $this->db->trans_start();
        //if($rut_firma     ==''){ $rut_firma = 0;  }
                if(!empty($_SERVER['HTTP_CLIENT_IP'])){  //check ip from share internet
           $ipcliente       = $_SERVER['HTTP_CLIENT_IP'];
        } else  if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ //to check ip is pass from proxy
           $ipcliente       = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
           $ipcliente       = $_SERVER['REMOTE_ADDR'];
        }
        $IND_REV_REGCLI     = $this->db->sequence($this->own,'SEQ_AP_TREV_REGCLI');
        $HISTORIAL_CLINICO  = array(
                                'IND_REV_REGCLI'        => $IND_REV_REGCLI,
                                'COD_RUT_PRES_CON'      => $firmado_por,
                                'COD_RUT_PAC'           => $RUT_PAC,
                                'FECHA'                 => date("d-m-Y"),
                                'HORA'                  => date("G:i"),
                                'COD_EMPRESA'           => $this->session->userdata("COD_ESTAB"),
                                'FIRMADO_POR'           => $firmado_por,
                                'IP_CONSULTA'           => $ipcliente,
                                'FEC_CONSULTA'          => 'SYSDATE',
                                'NUM_FICHAE'            => $NUM_FICHAE,
                                'OA_ID_ORIGENATE'       => $sistema,
                                'RG_FOLIOORIGEN'        => $idcita,
                                'FIRMADO_POR_NOM'       => $NAME,
                                'TOKEN'                 => $token,
                                'TIPO_ACCESS'           => $TIPO_ACCESS,
                            );
        
        $this->db->insert($this->own.'.AP_TREV_REGCLI', $HISTORIAL_CLINICO);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function ModelNuevoPacientexCupo($empresa,$session,$numfichae,$numingreso,$MKN,$GRP,$DIAS){
        $this->db->trans_start();
            $numcupoxpaciente           = $this->db->sequence($this->own,'SEQ_HDIAL_NPACIENTEXCUPO');
            $dataAngenda                = array(
                'ID_CUPOXPACIENTE'		=> $numcupoxpaciente,
                'COD_EMPRESA'			=> $empresa,
                'NUM_FICHAE'			=> $numfichae,
                'NUM_INGRESO'			=> $numingreso,
                'ID_RMDIALISIS'			=> $MKN,
                'ID_TURNOSXDIAS'		=> $GRP,
                'COD_USRCREA'			=> $session,
                'DATE_CREA'			=> 'SYSDATE',
                'IND_ESTADO'			=> '1',
            );
            $this->db->insert($this->own.'.HD_NPACIENTEXCUPO',$dataAngenda); 
            if(count($DIAS)>0){
                foreach ($DIAS as $num){
                    $TURNODIALISIS              = $this->db->sequence($this->own,'SEQ_HDIAL_TURNODIALISIS');
                    $data[] = array(
                            'ID_TURNODIALISIS'  => $TURNODIALISIS,
                            'ID_TURNOSXDIAS'    => $GRP,
                            'ID_NDIA'           => $num["txtdia"],
                            'IND_ESTADO'        => 1,
                            'ID_RMDIALISIS'     => $MKN,
                            'COD_USRCREA'       => $session,
                            'DATE_CREA'         => 'SYSDATE',
                            'COD_EMPRESA'       => $empresa,
                        );
                }
                $this->db->insert_batch($this->own.'.HD_TURNODIALISIS', $data);
            }
            $this->db->trans_complete();
        return $this->db->trans_status();  
    }
    
    public function ModeleliminaPacientexCupo($empresa, $session, $ID_CUPO, $MKN , $TRN){
        $this->db->trans_start();
            $UpdAngenda             = array(
                'IND_ESTADO'        => 0,
                'COD_AUDITA'        => $session,
                'FEC_AUDITA'        => 'SYSDATE'
            );
            $this->db->where('ID_CUPOXPACIENTE',$ID_CUPO); 
            $this->db->update($this->own.'.HD_NPACIENTEXCUPO', $UpdAngenda);
            //******************************************************************
            $UpdTurno               = array(
                'IND_ESTADO'        => 0,
                'COD_AUDITA'        => $session,
                'DATE_AUDITA'       => 'SYSDATE'
            );
            $this->db->where('ID_TURNOSXDIAS', $TRN);
            $this->db->where('ID_RMDIALISIS', $MKN);
            $this->db->update($this->own.'.HD_TURNODIALISIS', $UpdTurno);
            $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function ModelEgresaPaciente($empresa, $session, $numIgreso ,$id_egreso , $numfichae){
        $this->db->trans_start();
        $query          = $this->db->query($this->sql_class_hdial->sqlNumDialEgresos($empresa,$numIgreso, $numfichae));
        $INDDATOS       = $query->result_array();
	    if (count($INDDATOS)>0){
            $UpdTurno   =   array(
                                'IND_ESTADO'        => 0,
                                'COD_AUDITA'        => $session,
                                'DATE_AUDITA'       => 'SYSDATE'
                            );
            $this->db->where('ID_TURNOSXDIAS', $INDDATOS[0]['ID_TURNOSXDIAS']);
            $this->db->where('ID_RMDIALISIS', $INDDATOS[0]['ID_RMDIALISIS']);
            $this->db->update($this->own.'.HD_TURNODIALISIS', $UpdTurno);
	    }
        $dataEgreso    =  array(
                                'ID_EGRESO'     => $id_egreso,  
                                'FEC_AUDITA'    => 'SYSDATE', 
                                'COD_AUDITA'    => $session, 
                                'IND_ESTADO'    => '0' 
                            );
        $this->db->where('ID_NUMINGRESO', $numIgreso);
        $this->db->update($this->own.'.HD_TINGRESO', $dataEgreso);
        $UpdIngreso     =   array(
                                'IND_ESTADO'        => 0,
                                'COD_AUDITA'        => $session,
                                'FEC_AUDITA'        => 'SYSDATE'
                            );
        $this->db->where('NUM_INGRESO', $numIgreso);
        $this->db->update($this->own.'.HD_NPACIENTEXCUPO', $UpdIngreso);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    
    public function ModelborraSignoVital($empresa,$session,$id){
        $this->db->trans_start();
        $UpdTurno               = array(
                'IND_ESTADO'        => 0,
                'COD_AUDITA'        => $session,
                'DATE_AUDITA'       => 'SYSDATE'
        );
        $this->db->where('ID_TDSIGNOSVITALES', $id);
        $this->db->update($this->own.'.HD_TDSIGNOSVITALES', $UpdTurno);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function ModelNuevoPacienteIngreso($empresa,$session,$numFichaE){
        $this->db->trans_start();
        $ID_HDIAL               = $this->db->sequence($this->own,'SEQ_HDIAL_PACIENTEDIALISIS');
        $dataIngreso            =  array(
                                    'ID_NUMINGRESO' => $ID_HDIAL, 
                                    'NUM_FICHAE'    => $numFichaE, 
                                    'ID_SIC'        => '', 
                                    'COD_EMPRESA'   => $empresa, 
                                    'COD_USRCREA'   => $session,  
                                    'FEC_INGRESO'   => 'SYSDATE', 
                                    'FEC_CREA'      => 'SYSDATE', 
                                    'IND_ESTADO'    => '1' 
                                );
        $this->db->insert($this->own.'.HD_TINGRESO',$dataIngreso); 
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function ModelhoraTratamiento($empresa,$session,$NUMCITA,$NUMFICHAE,$num_Maquina,$datosDialisis,$hojatra,$name,$HrsIngreso,$fechaHerno){
        $this->db->trans_start();
        if($hojatra == ''){
                $COD_ACTIVIDAD                  = '289';//Hermodialisis
                $COD_TRAZADORA                  = '16'; //Procedimiento
                $PA_ID_PROCARCH                 = '17'; //ID_SISTEMA DE DIALISIS
                $idSistema                      = '17'; //ID_SISTEMA DE DIALISIS
                
                if(!isset($observacion)         || $observacion         == "")  { $observacion          = "SIN OBSERVACIONES";  }
                if(!isset($aCompan)             || $aCompan             == "")  { $aCompan              = "SIN ACOMPA&Ntilde;ANTE"; }
                if(!isset($aCompfono)           || $aCompfono           == "")  { $aCompfono            = "0"; }
                if(!isset($tipoAtencion)        || $tipoAtencion        == "")  { $tipoAtencion         = "1"; }  
                if(!isset($tipoProcedencia)     || $tipoProcedencia     == "")  { if($idSistema == 59)  { $tipoProcedencia  = 14;   } } else { $tipoProcedencia = 0;  }   
                if(!isset($transporte)          || $transporte          == "")  { if($idSistema == 59)  { $transporte       = 12;   }   else if($idSistema == 58){  $transporte   = 11;   } else { $transporte    = 10; }  }
                if(!isset($accidente)           || $accidente           == "")  { if($idSistema == 59)  { $accidente        = 10;   }   else if($idSistema == 58){  $accidente    = 9;    } else { $accidente     = 8;  }  }
                if(!isset($nombreProfesional)   || $nombreProfesional   == "")  { $nombreProfesional    = "SN";                     }
                if(!isset($fechaRegistro)       || $fechaRegistro       == "")  { $fechaRegistro        = @date("Y-m-d H:i:s");     }
                
                $idAdmision                     = $this->db->sequence($this->own,'SEQ_URG_TADMISION');
                
		        $query                          = $this->db->query($this->sql_class_hdial->sqlNextValFolio($this->own,$empresa,$PA_ID_PROCARCH));
                $AD_NUMFOLIO                    = $query->result_array();
                $AD_FHADMISION                  = explode("-",$fechaHerno);
                $dataCitas                      = array(
                    'AD_ID_ADMISION'            => $idAdmision,
                    'COD_EMPRESA'               => $empresa,
                    'AD_NUMFOLIO'		        => $AD_NUMFOLIO[0]['NFOLIO'],
                    //'AD_NUMFOLIO'             => $this->own.'.SEQ_URG_TADMISION_FOLIO_$cod_empresa.nextval', 
                    'AD_PROCEDENCIA'            => $PA_ID_PROCARCH,
                    'COD_TRANSPORTE'            => '0',   
                    'COD_PROCED'                => '0',  
                    'ES_ID_ESTAPROC'            => '0',      
                    'AD_FHADMISION'             => $AD_FHADMISION[0]."/".$AD_FHADMISION[1]."/".$AD_FHADMISION[2]." ".$HrsIngreso.":00,000000",      
                    'AD_ACOMPA'                 => $aCompan, 
                    'AD_FONOACOMP'              => '1', 
                    'AD_MOTIVOCONSUL'           => 'HEMODIALISIS', 
                    'PR_PROFREG'                => $session, 
                    //'PR_PROFEDIT'             => '', 
                    'PR_NOMBREPROFREG'          => $name, 
                    'PR_NOMBREPROFEDIT'         => $name, 
                    'AD_FHREGISTRO'             => @date("d-m-Y H:i:s"), 
                    'AD_FHEDIT'                 => @date("d-m-Y H:i:s"), 
                    'AD_FHCREACION'             => @date("d-m-Y H:i:s"), 
                    'ES_ID_ESTADO'              => '1', 
                    'TA_ID_TIPATENCION'         => '1', 
                    //'AD_PREVISION'            => '', 
                    'COD_RUTPRO'                => $session,
                    'TI_ID_TIPINGRESO'          => '1', 
                    'TA_ID_TIPACCIDENTE'        => '8', 
                    'AD_ID_ESTADOATENCION'      => '1', 
                    'AD_ACTIVA'                 => '1', 
                    'IND_ESTADODERIVA'          => '0', 
                    'AD_HIPODIAGNO'             => 'HEMODIALISIS', 
                    'NUM_FICHAE'                => $NUMFICHAE, 
                );
                $this->db->insert($this->own.'.URG_TADMISION',$dataCitas);
                
                /*
                    $idAdmisionHisto            = parent::executeSequence($this->own.".SEQ_URG_THISTADMISION");
                    $dataCitasHisto             = array(
                    'HA_ID_HISTADMISION'        => $idAdmisionHisto, 
                    'AD_ID_ADMISION'            => $idAdmision, 
                    'COD_TRANSPORTE'            => '',
                    'TA_ID_TIPATENCION'         => $tipoAtencion, 
                    'COD_PROCED'                => $tipoProcedencia, 
                    'ES_ID_ESTAPROC'            => '', 
                    'AD_FHREGISTRO'             => '', 
                    'AD_ACOMPA'                 => $aCompan , 
                    'AD_FONOACOMP'              => $aCompfono, 
                    'AD_MOTIVOCONSUL'           => $observacion, //ok
                    'PR_PROFREG'                => '', 
                    'PR_NOMBREPROFREG'          => '', 
                    );      
                    $this->db->insert($this->own.'.URG_THISTADMISION',$dataCitasHisto);        
                */        
             
            $TXTACCESOVAS_1             = '';
            $NUM_DIASVAS_1              = '';
            $TXTACCESOVAS_2             = '';
            $NUM_DIASVAS_2              = '';
            $NUM_TROCAR_ARTERIAL        = '';
            $NUM_TROCAR_VENOSO          = '';
            $NUM_HEPARINA_INICIO        = '';
            $NUM_HEPARINA_MAN           = '';
            $NUM_QT                     = '';
            $NUM_QB                     = '';
            $NUM_QD                     = '';
            $NUM_UFMAX                  = '';
            $NUM_K                      = '';
            $NUM_NA                     = '';
            $NUM_CONCENTRADO            = '';
            $FEC_DIASVAS_1              = '';
            $FEC_DIASVAS_2              = '';
        
            $query                      = $this->db->query($this->sql_class_hdial->sqlInformacionComplementaria($empresa,$NUMFICHAE));    
            $aData                      = $query->result_array();
            
            if(count($aData)>0){
                $TXTACCESOVAS_1         = $aData[0]['TXTACCESOVAS_1'];
                $NUM_DIASVAS_1          = $aData[0]['NUM_DIASVAS_1'];
                $TXTACCESOVAS_2         = $aData[0]['TXTACCESOVAS_2'];
                $NUM_DIASVAS_2          = $aData[0]['NUM_DIASVAS_2'];
                $FEC_DIASVAS_1          = $aData[0]['FEC_DIASVAS_1'];
                $FEC_DIASVAS_2          = $aData[0]['FEC_DIASVAS_2'];
                $NUM_TROCAR_ARTERIAL    = $aData[0]['NUM_TROCAR_ARTERIAL'];
                $NUM_TROCAR_VENOSO      = $aData[0]['NUM_TROCAR_VENOSO'];
                $NUM_HEPARINA_INICIO    = $aData[0]['NUM_HEPARINA_INICIO'];
                $NUM_HEPARINA_MAN       = $aData[0]['NUM_HEPARINA_MAN'];
                $NUM_QT                 = $aData[0]['NUM_QT'];
                $NUM_QB                 = $aData[0]['NUM_QB'];
                $NUM_QD                 = $aData[0]['NUM_QD']; 
                $NUM_UFMAX              = $aData[0]['NUM_UFMAX']; 
                $NUM_K                  = $aData[0]['NUM_K']; 
                $NUM_NA                 = $aData[0]['NUM_NA']; 
                $NUM_CONCENTRADO        = $aData[0]['NUM_CONCENTRADO']; 
            }
            
            $ID_HTRATA                  = $this->db->sequence($this->own,'SEQ_HDIAL_NUMHOJATRATAMIENTO');//num_tratatamiento unico
            $dataIngreso                = array(
                                            'ID_TDHOJADIARIA'       => $ID_HTRATA, 
                                            'NUM_FICHAE'            => $NUMFICHAE,
                                            'USR_CREA'              => $session, 
                                            'FEC_CREA'              => 'SYSDATE', 
                                            'AD_ID_ADMISION'        => $idAdmision,
                                            'ID_RMDIALISIS'         => $num_Maquina,
                                            'DATE_REALIZAHD'        => "TO_DATE('".$fechaHerno." ".$HrsIngreso."', 'DD-MM-YYYY hh24:mi')", 

                                            'TXTACCESOVAS_1'        => $TXTACCESOVAS_1,
                                            'NUM_DIASVAS_1'         => $NUM_DIASVAS_1,
                                            'TXTACCESOVAS_2'        => $TXTACCESOVAS_2,
                                            'NUM_DIASVAS_2'         => $NUM_DIASVAS_2,
                                            
                                            'FEC_DIASVAS_1'         => "TO_DATE('".$FEC_DIASVAS_1."', 'DD-MM-YYYY')", 
                                            
                                            'NUM_TROCAR_ARTERIAL'   => $NUM_TROCAR_ARTERIAL,
                                            'NUM_TROCAR_VENOSO'     => $NUM_TROCAR_VENOSO,
                                            'NUM_HEPARINA_INICIO'   => $NUM_HEPARINA_INICIO,
                                            'NUM_HEPARINA_MAN'      => $NUM_HEPARINA_MAN,

                                            'NUM_QT'                => $NUM_QT,
                                            'NUM_QB'                => $NUM_QB,
                                            'NUM_QD'                => $NUM_QD,
                                            'NUM_UFMAX'             => $NUM_UFMAX,
                                            'NUM_K'                 => $NUM_K,
                                            'NUM_NA'                => $NUM_NA,
                                            'NUM_CONCENTRADO'       => $NUM_CONCENTRADO,
                                        );
                 
                    if ($FEC_DIASVAS_2 != ''){
                            $dataIngreso = array_merge($dataIngreso, array('FEC_DIASVAS_2'=> "TO_DATE('".$FEC_DIASVAS_2."', 'DD-MM-YYYY')"));
                    }
             
        } else {
                $dataIngreso        = array(
                                        'USR_AUDITA'        => $session, 
                                        'FEC_AUDITA'        => 'SYSDATE', 
                                    );
                $this->db->where('ID_TDHOJADIARIA', $hojatra); 
                $this->db->update($this->own.'.HD_TDHOJADIARIA', $dataIngreso);
                $ID_HTRATA          = $hojatra;
        }
        
        //**********************************************************************
        foreach($datosDialisis as $infObject => $Object){
                if($infObject == 'datosProgramacion'){
                    $FormProgramacion = $Object[0]['FormProgramacion'];
                        foreach ($FormProgramacion as $From){
                            if($From['name'] == 'input_pesoSeco')       { $dataIngreso = array_merge($dataIngreso, array('NUM_PESOSECO'             => str_replace(".", ",", $From['value'])));}
                            if($From['name'] == 'hd_anterior')          { $dataIngreso = array_merge($dataIngreso, array('NUM_HDPESOANTERIOR'       => str_replace(".", ",", $From['value'])));}
                            if($From['name'] == 'pesopredialisis')      { $dataIngreso = array_merge($dataIngreso, array('NUM_PESOPREDIALISIS'      => str_replace(".", ",", $From['value'])));}
                            if($From['name'] == 'alza_interdialisis')   { $dataIngreso = array_merge($dataIngreso, array('NUM_INTERDIALISIS'        => str_replace(".", ",", $From['value'])));}
                            if($From['name'] == 'altainterdialisis')    { $dataIngreso = array_merge($dataIngreso, array('NUM_PESOINTERDIALISIS'    => str_replace(".", ",", $From['value'])));}
                            
                            
                            if($From['name'] == 'ufprograma')           { $dataIngreso = array_merge($dataIngreso, array('NUM_UFPROGRAMADA'         => str_replace(".", ",", $From['value'])));}
                            if($From['name'] == 'ufprograma_um')        { $dataIngreso = array_merge($dataIngreso, array('NUM_UFPROGRAMADA_UM'      => str_replace(".",",",$From['value']))); }
                            
                            
                            if($From['name'] == 'prsopostdialisis')     { $dataIngreso = array_merge($dataIngreso, array('NUM_PESOPOSTDIALISIS'     => str_replace(".", ",", $From['value'])));}
                            if($From['name'] == 'txtperdidasdepeso')    { $dataIngreso = array_merge($dataIngreso, array('NUM_PESOINTERDIALISIS'    => str_replace(".", ",", $From['value'])));}
                        }
                    $this->db->insert($this->own.'.HD_TDHOJADIARIA',$dataIngreso); 
            } else if($infObject == 'datosPresion'){
                    $FormdatosPresion = $Object[0]['FormdatosPresion'];    
                    $ID_NUMSIGVITALES       = $this->db->sequence($this->own,'SEQ_HDIAL_TDSIGNOSVITALES');//num_tratatamiento unico
                    $datasSingnoVital       = array(
                                                'ID_TDSIGNOSVITALES'    => $ID_NUMSIGVITALES, 
                                                'ID_TDHOJADIARIA'       => $ID_HTRATA,
                                                'IND_ESTADO'            => '1',
                                                'USR_CREA'              => $session,
                                                'DATE_CREA'             => 'SYSDATE'
                                            );
                    foreach($FormdatosPresion as $From){
                        if($From['name'] == 'txtHoraIngreso')           { $datasSingnoVital = array_merge($datasSingnoVital, array('DATE_HORA'          => "TO_DATE('".date("d-m-Y")." ".$From['value']."', 'DD-MM-YYYY hh24:mi')"));}
                        //if($From['name'] == 'txtpresionalterial')     { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PARTERIAL'      => $From['value']));}
                        if($From['name'] == 'txtpresionalterial_s')     { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PARTERIAL_S'    => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'txtpresionalterial_d')     { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PARTERIAL_D'    => str_replace(".", ",", $From['value'])));}
                        
                        if($From['name'] == 'txttpaciente')             { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_TPACIENTE'      => str_replace(".", ",", $From['value'])));}
                        
                        if($From['name'] == 'txtpulso')                 { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PULSO'          => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'txttemmonitor')            { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_TMONITOR'       => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'Q_B_PROG')                 { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_QBPROG'         => str_replace(".", ",", $From['value'])));}

                        if($From['name'] == 'Q_B_EFEC')                 { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_QBEFEC'         => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTPA')                    { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PA'             => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTPV')                    { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PV'             => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTPTM')                   { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PTM'            => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTCOND')                  { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_COND'           => str_replace(".", ",", $From['value'])));}

                        if($From['name'] == 'TXTUFH')                   { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_UFH'            => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTTAZAUFH')               { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_TAZAUFH'        => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTINGRESO')               { $datasSingnoVital = array_merge($datasSingnoVital, array('TXT_INGRESO'        => str_replace(".", ",", $From['value'])));}
                        
                        
                        if($From['name'] == 'TXTUFACOMULADA')           { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_UFACOMULADA'    => str_replace(".", ",", $From['value'])));}
                        //new
                        if($From['name'] == 'TXTUFACOMULADA_UM')        { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_UFACOMULADA_UM'  => str_replace(".", ",", $From['value'])));}
                        
                        
                        if($From['name'] == 'TXTOBSERVACIONES')         { $datasSingnoVital = array_merge($datasSingnoVital, array('TXTOBSERVACIONES'   => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'ind_tomadesigno')          { $datasSingnoVital = array_merge($datasSingnoVital, array('IND_TOMASIGNO'      => str_replace(".", ",", $From['value'])));}
                    }
                $this->db->insert($this->own.'.HD_TDSIGNOSVITALES',$datasSingnoVital); 

            } else if($infObject == 'rrhh_conexion'){
                $FormdatosPresion   = $Object[0]['FormdrrhhConexion'];   
                $rrhhDiario         = array('USR_CREA'=>$session,'DATE_CREA'=>'SYSDATE','ID_TDHOJADIARIA'=>$ID_HTRATA,'IND_ESTADO'=>1);
                foreach ($FormdatosPresion as $From){
                    if($From['name'] == 'slc_enfermeria'){ $rrhhDiario       = array_merge($rrhhDiario, array('COD_RUTPAC'=>$From['value'] ,'IND_HDESTAPA'=> '1'));  $this->db->insert($this->own.'.HD_RHERMOPROFE',$rrhhDiario); }
                    if($From['name'] == 'slc_tecpara')   { $rrhhDiario       = array_merge($rrhhDiario, array('COD_RUTPAC'=>$From['value'] ,'IND_HDESTAPA'=> '1'));  $this->db->insert($this->own.'.HD_RHERMOPROFE',$rrhhDiario); }
                    if($From['name'] == 'slc_medico')    { $rrhhDiario       = array_merge($rrhhDiario, array('COD_RUTPAC'=>$From['value'] ,'IND_HDESTAPA'=> '1'));  $this->db->insert($this->own.'.HD_RHERMOPROFE',$rrhhDiario); }
                }
            }
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function ModelhoraTratamientoGuardadoGeneral($empresa,$session,$IDHOJADIARIA,$datosDialisis,$opcion,$fecha_aplicado){
        $this->db->trans_start();
        $FormProgramacion       = '';
        $formteminodialisis     = '';
        $etapa                  = '';
        foreach($datosDialisis as $infObject => $Object){
            if($infObject == 'datosProgramacion'){
                $FormProgramacion           = $Object[0]['Form_Programacion'];
                if(count($FormProgramacion)>0){
                    //$dataIngreso            = '';
                    $dataIngreso            = array('USR_AUDITA'=> $session,'FEC_AUDITA'=> 'SYSDATE');
                    foreach ($FormProgramacion as $From){
                        //INICIO FECHA
                        if($From['name'] == 'TXT_ACCESOVAS_1')          {   $dataIngreso = array_merge($dataIngreso, array('TXTACCESOVAS_1'           => $From['value']));}
                        if($From['name'] == 'NUM_DIAS_1')               {   $dataIngreso = array_merge($dataIngreso, array('NUM_DIASVAS_1'            => $From['value']));}
                        if($From['name'] == 'TXT_ACCESOVAS_2')          {   $dataIngreso = array_merge($dataIngreso, array('TXTACCESOVAS_2'           => $From['value']));}
                        if($From['name'] == 'NUM_DIAS_2')               {   $dataIngreso = array_merge($dataIngreso, array('NUM_DIASVAS_2'            => $From['value']));}
                        if($From['name'] == 'FEC_DIAS_1')               {   $dataIngreso = array_merge($dataIngreso, array('FEC_DIASVAS_1'            => "TO_DATE('".$From['value']."', 'DD-MM-YYYY')",  ));}
                        if($From['name'] == 'FEC_DIAS_2' && $From['value'] != ''){ 
                                                                            $dataIngreso = array_merge($dataIngreso, array('FEC_DIASVAS_2'          => "TO_DATE('".$From['value']."', 'DD-MM-YYYY')",  ));
                                                                        } else { 
                                                                            error_log("-- noooo FEC_DIAS_2"); 
                                                                        }
                        //FINAL FECHA
                        if($From['name'] == 'NUM_ARTERIAL')             {   $dataIngreso = array_merge($dataIngreso, array('NUM_TROCAR_ARTERIAL'      => $From['value']));}
                        if($From['name'] == 'NUM_VENOSO')               {   $dataIngreso = array_merge($dataIngreso, array('NUM_TROCAR_VENOSO'        => $From['value']));}

                        if($From['name'] == 'NUM_INICIO')               {   $dataIngreso = array_merge($dataIngreso, array('NUM_HEPARINA_INICIO'      => $From['value']));}
                        if($From['name'] == 'NUM_MANTENCION')           {   $dataIngreso = array_merge($dataIngreso, array('NUM_HEPARINA_MAN'         => $From['value']));}

                        if($From['name'] == 'NUM_QT')                   {   $dataIngreso = array_merge($dataIngreso, array('NUM_QT'                   => $From['value']));}
                        if($From['name'] == 'NUM_QB')                   {   $dataIngreso = array_merge($dataIngreso, array('NUM_QB'                   => $From['value']));}
                        if($From['name'] == 'NUM_QD')                   {   $dataIngreso = array_merge($dataIngreso, array('NUM_QD'                   => $From['value']));}

                        if($From['name'] == 'NUM_UFMAX')                {   $dataIngreso = array_merge($dataIngreso, array('NUM_UFMAX'                => $From['value']));}
                        if($From['name'] == 'NUM_UFMAX_UM')             {   $dataIngreso = array_merge($dataIngreso, array('NUM_UFMAX_UM'             => $From['value']));}
                        
                        if($From['name'] == 'NUM_K')                    {   $dataIngreso = array_merge($dataIngreso, array('NUM_K'                    => $From['value']));}
                        if($From['name'] == 'NUM_NA')                   {   $dataIngreso = array_merge($dataIngreso, array('NUM_NA'                   => $From['value']));}
                        if($From['name'] == 'NUM_CONCENTRADO')          {   $dataIngreso = array_merge($dataIngreso, array('NUM_CONCENTRADO'          => $From['value']));}

                        if($From['name'] == 'OBS_MEDICAS')              {   $dataIngreso = array_merge($dataIngreso, array('TXT_OBSMEDICAS'           => $From['value']));}
                        if($From['name'] == 'OBS_ENFERMERIA')           {   $dataIngreso = array_merge($dataIngreso, array('TXT_ENFERMERIA'           => $From['value']));}

                        if($From['name'] == 'SLT_FILTO')                {   $dataIngreso = array_merge($dataIngreso, array('NUM_CI_FILTRO'            => $From['value']));}
                        if($From['name'] == 'SLT_ARTERIAL')             {   $dataIngreso = array_merge($dataIngreso, array('NUM_CI_ARTERIAL'          => $From['value']));}
                        if($From['name'] == 'SLT_VENOSA')               {   $dataIngreso = array_merge($dataIngreso, array('NUM_CI_VENOSA'            => $From['value']));}
                        
                        /*
                        if($From['name'] == 'PAUSAS_FCORRECTO')         { $dataIngreso = array_merge($dataIngreso, array('NUM_PS_FILTRO'            => $From['value']));}
                        if($From['name'] == 'PAUSAS_LARTERIAL')         { $dataIngreso = array_merge($dataIngreso, array('NUM_PS_ARTERIAL'          => $From['value']));}
                        if($From['name'] == 'PAUSAS_LVENOSO')           { $dataIngreso = array_merge($dataIngreso, array('NUM_PS_VENOSO'            => $From['value']));}
                        if($From['name'] == 'txt_testpotencia')         { $dataIngreso = array_merge($dataIngreso, array('TXT_TESTPOTENCIA'         => $From['value']));}
                        */
                        
                        /* INICIO PAUSAS SEGURIDAD */
                        if($From['name'] == 'PAUSAS_PACIENTE_CORRECTO') {   $dataIngreso = array_merge($dataIngreso, array('IND_PACIENTE_CORRECTO'    => $From['value']));}
                        if($From['name'] == 'PAUSAS_CIRCUITO_LINEAS')   {   $dataIngreso = array_merge($dataIngreso, array('IND_CLINEAS'              => $From['value']));}
                        if($From['name'] == 'PAUSAS_CIRCUITO_FILTRO')   {   $dataIngreso = array_merge($dataIngreso, array('IND_CFILTRO'              => $From['value']));}
                        if($From['name'] == 'NUM_T_MONITOR')            {   $dataIngreso = array_merge($dataIngreso, array('NUM_T_MONITOR'            => $From['value']));}
                        if($From['name'] == 'NUM_CONDUCTIVIDAD')        {   $dataIngreso = array_merge($dataIngreso, array('NUM_CONDUCTIVIDAD'        => $From['value']));}
                        if($From['name'] == 'NUM_TEST_RESIDUOS')        {   $dataIngreso = array_merge($dataIngreso, array('NUM_TEST_RESIDUOS'        => $From['value']));}
                        /* FIN PAUSAS SEGURIDAD */
                      
                        /* INICIO REACIONES ADVERSAS */
                        if($From['name'] == 'TipoViaDial')              {   $dataIngreso = array_merge($dataIngreso, array('ID_TIPOVIA'               => $From['value']));}
                        /*
                        if($From['name'] == 'Sl_Hipo_sion1')            { $dataIngreso = array_merge($dataIngreso, array('IND_HIPOTENSION'          => $From['value']));}
                        if($From['name'] == 'Sl_Ca_frio')               { $dataIngreso = array_merge($dataIngreso, array('IND_CALOFRIO'             => $From['value']));}
                        if($From['name'] == 'Sl_F_bre')                 { $dataIngreso = array_merge($dataIngreso, array('IND_FIEBRE'               => $From['value']));}
                        if($From['name'] == 'Sl_Inf_catt')              { $dataIngreso = array_merge($dataIngreso, array('IND_ICVASCULAR'           => $From['value']));}
                        if($From['name'] == 'Sl_Bact_meia')             { $dataIngreso = array_merge($dataIngreso, array('IND_BACTEREMIA'           => $From['value']));}
                        if($From['name'] == 'Sl_Hep_b')                 { $dataIngreso = array_merge($dataIngreso, array('IND_HEPATITIS_B'          => $From['value']));}
                        if($From['name'] == 'Sl_Hep_c')                 { $dataIngreso = array_merge($dataIngreso, array('IND_HEPATITIS_C'          => $From['value']));}
                        if($From['name'] == 'Sl_mrtes_pro')             { $dataIngreso = array_merge($dataIngreso, array('IND_MDPROCEDIMIENTO'      => $From['value']));}
                        */
                        
                        /* FIN REACIONES ADVERSAS */
                        if($From['name'] == 'n_uso')                    {   $dataIngreso = array_merge($dataIngreso, array('NUM_USO_FILTRO'           => $From['value']));}
                        if($From['name'] == 'SLT_R_RFIBRAS')            {   $dataIngreso = array_merge($dataIngreso, array('IND_R_RFIBRAS'            => $From['value']));}
                        if($From['name'] == 'SLT_C_RFIBRAS')            {   $dataIngreso = array_merge($dataIngreso, array('IND_C_RFIBRAS'            => $From['value']));}
                        if($From['name'] == 'SLT_R_PIROGENOS')          {   $dataIngreso = array_merge($dataIngreso, array('IND_R_PIROGENOS'          => $From['value']));}
                        
                        //INI DE FILTROS 
                        if($From['name'] == 'v_residual')               {   $dataIngreso = array_merge($dataIngreso, array('NUM_V_RESIDUAL'           => $From['value']));}
                        if($From['name'] == 'uso_l_arterial')           {   $dataIngreso = array_merge($dataIngreso, array('NUM_V_ARTERIAL'           => $From['value']));}
                        if($From['name'] == 'uso_l_venosa')             {   $dataIngreso = array_merge($dataIngreso, array('NUM_V_VENOSA'             => $From['value']));}
                        //FINAL DE FILTROS 
                        
                        //INI PROGRAMACION 
                        if($From['name'] == 'prsopostdialisis_term')    {   $dataIngreso = array_merge($dataIngreso, array('NUM_PESOPOSTDIALISIS'     => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'txtperdidasdepeso_term')   {   $dataIngreso = array_merge($dataIngreso, array('NUM_PESOINTERDIALISIS'    => str_replace(".", ",", $From['value'])));}
                        //FINAL PROGRAMACION 
                        
                        //NUEVOS DATOS 
                        if($From['name'] == 'txttotalufconseguida')     {   $dataIngreso = array_merge($dataIngreso, array('NUM_TOTALUFCONSEGIDA'     => $From['value']));}
                        //NUEVOS DATOS 
                        if($From['name'] == 'txttotalufconseguida_um')  {   $dataIngreso = array_merge($dataIngreso, array('NUM_TOTALUFCONSEGIDA_UM'     => $From['value']));}
                        
                        if($From['name'] == 'volsangreacomulado')       {   $dataIngreso = array_merge($dataIngreso, array('NUM_VOLSANGREACOMULADA'   => $From['value']));}
                        if($From['name'] == 'SL_DESIFCACCIONMAQUINA')   {   $dataIngreso = array_merge($dataIngreso, array('IND_DESIFCACCIONMAQUINA'  => $From['value']));}
                        if($From['name'] == 'SL_DIALIZADORDIAL')        {   $dataIngreso = array_merge($dataIngreso, array('IND_DIALIZADORDIAL'       => $From['value']));}
                        if($From['name'] == 'num_kt_b')                 {   $dataIngreso = array_merge($dataIngreso, array('NUM_KT_V'                 => $From['value']));}
                        //NUEVOS DATOS 
                        if($From['name'] == 'ind_pmedico')              {   $dataIngreso = array_merge($dataIngreso, array('IND_HDESTADO'             => $From['value']));}
                    }
                    //GUARDADO GENERAL
                    $this->db->where('ID_TDHOJADIARIA',$IDHOJADIARIA); 
                    $this->db->update($this->own.'.HD_TDHOJADIARIA', $dataIngreso); 
                }
            } else if($infObject == 'finalizacionHemodialisis'){
                    $formteminodialisis         = $Object[0]['form_teminodialisis'];
                    $etapa                      = $Object[0]['form_etapa'];
                    $rrhhDiario                 = array('USR_CREA'=>$session,'DATE_CREA'=>'SYSDATE','ID_TDHOJADIARIA'=>$IDHOJADIARIA,'IND_ESTADO'=>1);
                        foreach ($formteminodialisis as $From){
                            if($From['name'] == 'slc_enfermeria'){ $rrhhDiario       = array_merge($rrhhDiario, array('COD_RUTPAC'=>$From['value'] ,'IND_HDESTAPA'=> $etapa));  $this->db->insert($this->own.'.HD_RHERMOPROFE',$rrhhDiario);  $PROFREG = $From['value'];}
                            if($From['name'] == 'slc_tecpara')   { $rrhhDiario       = array_merge($rrhhDiario, array('COD_RUTPAC'=>$From['value'] ,'IND_HDESTAPA'=> $etapa));  $this->db->insert($this->own.'.HD_RHERMOPROFE',$rrhhDiario); }
                            if($From['name'] == 'slc_medico')    { $rrhhDiario       = array_merge($rrhhDiario, array('COD_RUTPAC'=>$From['value'] ,'IND_HDESTAPA'=> $etapa));  $this->db->insert($this->own.'.HD_RHERMOPROFE',$rrhhDiario); }
                            if($From['name'] == 'txtHoraEgreso') { $txtHoraEgreso    = $From['value']; }
                            if($From['name'] == 'idAdmision')    { $idAdmision       = $From['value']; }
                            if($From['name'] == 'txtPCargo')     { $NOMBREPROFREG    = $From['value']; }
                        }
                        if($etapa == '3'){
                            $dataIngreso2 = array('DATE_FHEGRESO'=> "TO_DATE('".$fecha_aplicado." ".$txtHoraEgreso.":00', 'DD-MM-YYYY hh24:mi:ss')");
                            $this->db->where('ID_TDHOJADIARIA',$IDHOJADIARIA); 
                            $this->db->update($this->own.'.HD_TDHOJADIARIA', $dataIngreso2); 
                            
                            $query              = $this->db->query($this->sql_class_hdial->sqlExisteCierrexAdmision($idAdmision));
                            $ExisteCierre       = $query->result_array();
                            if(count($ExisteCierre)>0){
                                $dataEgreso         = array(
                                                        'CI_FHEGRESO'           => "TO_DATE('".$fecha_aplicado." ".$txtHoraEgreso.":00', 'DD-MM-YYYY hh24:mi:ss')",
                                                        'CI_TIEMPOCONTROL'      => '0',
                                                        'CI_FHCIERRE'           => 'SYSDATE',
                                                        'CI_FHREGISTRO'         => 'SYSDATE',
                                                        'PR_PROFREG'            => $PROFREG,
                                                        'PR_NOMBREPROFREG'      => $NOMBREPROFREG,
                                                    );
                                $this->db->where('CI_ID_CIERRE',$ExisteCierre[0]['CI_ID_CIERRE']); 
                                $this->db->update($this->own.'.URG_TCIERRE', $dataIngreso); 
                                
                            } else {
                                $dataEgreso         = array(
                                                        'CI_ID_CIERRE'          => $this->db->sequence($this->own,'SEQ_URG_TCIERRE'),
                                                        'AD_ID_ADMISION'        => $idAdmision,
                                                        'TD_ID_TIPDERICIERRE'   => '1',
                                                        'CI_FHEGRESO'           => "TO_DATE('".$fecha_aplicado." ".$txtHoraEgreso.":00', 'DD-MM-YYYY hh24:mi:ss')",
                                                        'CI_TIEMPOCONTROL'      => '0',
                                                        'TE_ID_TIPEGRESO'       => '1',
                                                        'CI_INDIEGRESO'         => '-',
                                                        'CI_FHCIERRE'           => 'SYSDATE',
                                                        'CI_FHREGISTRO'         => 'SYSDATE',
                                                        'PR_PROFREG'            => $PROFREG,
                                                        'PR_NOMBREPROFREG'      => $NOMBREPROFREG,
                                                    );
                                $this->db->insert($this->own.'.URG_TCIERRE', $dataEgreso);
                            } 
                        }
            } else if($infObject == 'datosPresion'){
                    $FormdatosPresion       = $Object[0]['FormdatosPresion'];    
                    $ID_NUMSIGVITALES       = $this->db->sequence($this->own,'SEQ_HDIAL_TDSIGNOSVITALES');//num_tratatamiento unico
                    $datasSingnoVital       = array(
                                                        'ID_TDSIGNOSVITALES'    => $ID_NUMSIGVITALES, 
                                                        'ID_TDHOJADIARIA'       => $IDHOJADIARIA,
                                                        'IND_ESTADO'            => '1',
                                                        'USR_CREA'              => $session,
                                                        'DATE_CREA'             => 'SYSDATE'
                                                    );
                    foreach($FormdatosPresion as $From){
                        if($From['name'] == 'txtHoraIngreso')           { $datasSingnoVital = array_merge($datasSingnoVital, array('DATE_HORA'          => "TO_DATE('".date("d-m-Y")." ".$From['value']."', 'DD-MM-YYYY hh24:mi')"));}
                      //if($From['name'] == 'txtpresionalterial')       { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PARTERIAL'    => $From['value']));}
                        if($From['name'] == 'txtpresionalterial_s')     { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PARTERIAL_S'    => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'txtpresionalterial_d')     { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PARTERIAL_D'    => str_replace(".", ",", $From['value'])));}
                        
                        if($From['name'] == 'txttpaciente')             { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_TPACIENTE'      => str_replace(".", ",", $From['value'])));}
                        
                        if($From['name'] == 'txtpulso')                 { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PULSO'          => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'txttemmonitor')            { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_TMONITOR'       => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'Q_B_PROG')                 { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_QBPROG'         => str_replace(".", ",", $From['value'])));}

                        if($From['name'] == 'Q_B_EFEC')                 { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_QBEFEC'         => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTPA')                    { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PA'             => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTPV')                    { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PV'             => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTPTM')                   { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_PTM'            => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTCOND')                  { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_COND'           => str_replace(".", ",", $From['value'])));}

                        if($From['name'] == 'TXTUFH')                   { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_UFH'            => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTTAZAUFH')               { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_TAZAUFH'        => str_replace(".", ",", $From['value'])));}
                        if($From['name'] == 'TXTINGRESO')               { $datasSingnoVital = array_merge($datasSingnoVital, array('TXT_INGRESO'        => str_replace(".", ",", $From['value'])));}
                        
                        if($From['name'] == 'TXTUFACOMULADA')           { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_UFACOMULADA'    => str_replace(".", ",", $From['value'])));}
                        //new
                        if($From['name'] == 'TXTUFACOMULADA_UM')        { $datasSingnoVital = array_merge($datasSingnoVital, array('NUM_UFACOMULADA_UM' => str_replace(".", ",", $From['value'])));}
                        
                        
                        if($From['name'] == 'TXTOBSERVACIONES')         { $datasSingnoVital = array_merge($datasSingnoVital, array('TXTOBSERVACIONES'   => $From['value']));}
                        if($From['name'] == 'ind_tomadesigno')          { $datasSingnoVital = array_merge($datasSingnoVital, array('IND_TOMASIGNO'      => $From['value']));}
                    }
                $this->db->insert($this->own.'.HD_TDSIGNOSVITALES',$datasSingnoVital); 
            } else if($infObject == 'reacionesAdversas'){
                $Form_ReacionesAd       = $Object[0]['Form_ReacionesAd'];    
                
                $UpdReacionesAdversas   = array('IND_ESTADO'=> 0,'COD_USRAUDITA' => $session,'FEC_USRAUDITA'=>'SYSDATE');
                $this->db->where('IDHOJADIARIA', $IDHOJADIARIA);
                $this->db->update($this->own.'.HD_FREACIONESAD', $UpdReacionesAdversas);
                
                if(count($Form_ReacionesAd)>0){
                    foreach($Form_ReacionesAd as $From){
                        if($From['name'] == 'txt_emboleaaerea')         { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(1, $From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_recperitoneo')         { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(2, $From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_cefalea')              { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(3, $From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_arritmias')            { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(4, $From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_homorragia')           { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(5, $From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_strocar')              { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(6, $From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_vomitos')              { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(7, $From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_dabdominal')           { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(8, $From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_dprecardial')          { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(9, $From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_nauseas')              { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(10,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_parocardio')           { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(11,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_prurito')              { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(12,$From['value'],$session,$IDHOJADIARIA));  }
                        
                        if($From['name'] == 'txt_hipotension')          { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(13,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_racidoperacetico')     { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(14,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_infeccionsitiocavas')  { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(15,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_escalofrio')           { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(16,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_rfiebre')              { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(17,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_rbacteremia')          { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(18,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_rhepatitib')           { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(19,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_rhepatitic')           { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(20,$From['value'],$session,$IDHOJADIARIA));  }
                        if($From['name'] == 'txt_mprocedimiento')       { $this->db->insert($this->own.'.HD_FREACIONESAD',$this->arrayRadversas(21,$From['value'],$session,$IDHOJADIARIA));  }
                        
                        
                    }
                }
            }
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
     
    public function arrayRadversas($val,$value,$session,$IDHOJADIARIA){
        return $datasreacionesA = array(
            'ID_FREACION'       => $this->db->sequence($this->own,'SEQ_HDIAL_FREACIONESAD'),
            'ID_RADVERSA'       => $val,
            'IDHOJADIARIA'      => $IDHOJADIARIA,
            'TXT_OBSERVACIONES' => $value ,
            'IND_ESTADO'        => '1',
            'COD_USRCREA'       => $session,
            'FEC_USRFEC'        => 'SYSDATE',
        );
    }

    public function ModelconfirmaNuevoPaciente($empresa,$session,$Fechas,$NUMINGRESO,$NUM_FICHAE,$HR_INICIO,$HR_FINAL,$MES,$YEAR,$numRecurso){
            $this->db->trans_start();
            //SI EXISTE PLANIFICACION MENSUAL
            $COD_ACTIVIDAD                  = '289';//Hermodialisis
            $COD_TRAZADORA                  = '16'; //Procedimiento
            $PA_ID_PROCARCH                 = '17';
            $idSistema                      = '17';
            $idAdmision                     = '';
            $FechaAlrevez                   = '';   
            $sec_numRecurso                 = '';
            $sec_numAgenda                  = '';
            //INI preguntar si tiene agenda
                $sec_numAgenda              = $this->db->sequence($this->own,'SEQ_AP_NEWAGENDA_BLOQUES');
                $sec_numRecurso             = $this->db->sequence($this->own,'SEQ_AP_RECURSOSXAGENDA');
                $dataAngenda                = array(
                    'ID_NUMAGENDA'          => $sec_numAgenda,
                    'FEC_INICIOAGENDA'      => "TO_DATE('01-12-2017 00:00', 'DD-MM-YYYY hh24:mi')",
                    'FEC_FINALAGENDA'       => "TO_DATE('30-12-2017 23:59', 'DD-MM-YYYY hh24:mi')",
                    'ID_TIPOAGENDA'         => '2',//AGENDA MENSUAL,
                    'ID_TIPORECURSO'        => '2',//ES MAQUINA 
                    'ID_COD_RECURSO'        => $sec_numRecurso,
                    'COD_EMPRESA'           => $empresa,
                    'IND_ESTADO'            => '1',
                    'COD_USRCREA'           => $session,
                    'FEC_USRCREA'           => 'SYSDATE',
                );
                $this->db->insert($this->own.'.AP_BLOQUEAGENDA',$dataAngenda);  
                $dataRecurso                = array(
                    'ID_COD_RECURSO'        => $sec_numRecurso,
                    'NUM_RECURSO'           => $numRecurso,//ES MAQUINA 
                    'IND_ESTADO'            => '1',
                    'COD_USRCREA'           => $session,
                    'DATE_AUDITA'           => 'SYSDATE',
                );
                $this->db->insert($this->own.'.AP_TAGENDA_RECURSO',$dataRecurso);  
            //FIN preguntar si tiene agenda    
                
        foreach ($Fechas as $i => $date){
            //error_log("------------------>".$date);
            /*    
            error_log("------------------>".$date);
            $decodeFECHA                    = explode("-",$Fechas);
            $FechaAlrevez                   = $decodeFECHA[2]."-".$decodeFECHA[1]." ".$decodeFECHA[0];
            if(!isset($observacion)         || $observacion == "")      { $observacion      = "SIN OBSERVACIONES";  }
            if(!isset($aCompan)             || $aCompan == "")          { $aCompan          = "SIN ACOMPA&Ntilde;ANTE"; }
            if(!isset($aCompfono)           || $aCompfono == "")        { $aCompfono        = "0"; }
            if(!isset($tipoAtencion)        || $tipoAtencion == "")     { $tipoAtencion     = "1"; }  
            if(!isset($tipoProcedencia)     || $tipoProcedencia == "")  { if($idSistema   == '59'){ $tipoProcedencia= 14; //   }else{ $tipoProcedencia = 0;//urgencia   }   }
            if(!isset($transporte)          || $transporte == "")       { if($idSistema== 59){ $transporte= 12;  }else if($idSistema== 58){  $transporte= 11;   }else{  $transporte = 10;  }  }
            if(!isset($accidente)           || $accidente == "")        { if($idSistema== 59){  $accidente= 10;  }else if($idSistema== 58){  $accidente= 9;  }else{   $accidente = 8;  }  }
            if(!isset($nombreProfesional)   || $nombreProfesional == ""){ $nombreProfesional = "SN"; }
            if(!isset($fechaRegistro)       || $fechaRegistro == "")    {  $fechaRegistro = @date("Y-m-d H:i:s");   }
                
            //Graba Citacion    
            do{
                $idAdmision                 = parent::executeSequence($this->own.".SEQ_URG_TADMISION");
                $dataCitas                  = array(
                'AD_ID_ADMISION'            => $idAdmision,
                'COD_EMPRESA'               => $empresa,
                'AD_PROCEDENCIA'            => $PA_ID_PROCARCH,
                'COD_TRANSPORTE'            => '',   
                'COD_PROCED'                => $tipoProcedencia,  
                'ES_ID_ESTAPROC'            => '11',      
                'AD_FHADMISION'             => $FechaAlrevez." ".$HR_INICIO,      
                'AD_ACOMPA'                 => $aCompan, 
                'AD_FONOACOMP'              => '1', 
                'AD_MOTIVOCONSUL'           => $observacion, 
                'PR_PROFREG'                => '', 
                'PR_PROFEDIT'               => '', 
                'PR_NOMBREPROFREG'          => '', 
                'PR_NOMBREPROFEDIT'         => '', 
                'AD_FHREGISTRO'             => @date("Y-m-d H:i:s"), 
                'AD_FHEDIT'                 => '', 
                'AD_FHCREACION'             => '', 
                'ES_ID_ESTADO'              => '', 
                'TA_ID_TIPATENCION'         => $tipoAtencion, 
                'AD_PREVISION'              => '', 
                'PR_PROFREG'                => '', 
                'TI_ID_TIPINGRESO'          => '', 
                'TA_ID_TIPACCIDENTE'        => '', 
                'AD_ID_ESTADOATENCION'      => '', 
                'NUM_FICHAE'                => $NUM_FICHAE, 
                );

                $idAdmisionHisto            = parent::executeSequence($this->own.".SEQ_URG_THISTADMISION");
                $dataCitasHisto             = array(
                'HA_ID_HISTADMISION'        => $idAdmisionHisto, 
                'AD_ID_ADMISION'            => $idAdmision, 
                'COD_TRANSPORTE'            => '',
                'TA_ID_TIPATENCION'         => $tipoAtencion, 
                'COD_PROCED'                => $tipoProcedencia, 
                'ES_ID_ESTAPROC'            => '', 
                'AD_FHREGISTRO'             => '', 
                'AD_ACOMPA'                 => $aCompan , 
                'AD_FONOACOMP'              => $aCompfono, 
                'AD_MOTIVOCONSUL'           => $observacion, //ok
                'PR_PROFREG'                => '', 
                'PR_NOMBREPROFREG'          => '', 
                );      

            } while(($this->db->insert($this->own.'.URG_TADMISION',$dataCitas))&&($this->db->insert($this->own.'.URG_THISTADMISION',$dataCitasHisto)));
            */
            $num_id_citas               = $this->db->sequence($this->own,'SEQ_AP_NEWCITASAGENDAS_AG_CITA');
            $dataCitas[]                = array(
                'NUM_CITACION'          => $num_id_citas,
                'NUM_FICHAE'            => $NUM_FICHAE,
                'COD_EMPRESA'           => $empresa,
                'IND_ESTADO'            => '1',
                'COD_SISTEMA'           => $PA_ID_PROCARCH,
                'COD_USRCREA'           => $session,
                'FEC_USRCREA'           => 'SYSDATE',
                'IND_CSERVICIO'         => '0',
                'IND_VSERVICIO'         => '0',
                'IND_PROCEDENCIA'       => '11',
                'AD_ID_ADMISION'        => $idAdmision,
            );
            $dataBloque[]               = array(
                'DATE_AGENDAINICIO'     => "TO_DATE('".$date." ".$HR_INICIO."', 'DD-MM-YYYY hh24:mi')",
                'DATE_AGENDAFINAL'      => "TO_DATE('".$date." ".$HR_FINAL."', 'DD-MM-YYYY hh24:mi')",
                'COD_ACTIVIDAD'         => $COD_ACTIVIDAD,//HERMODIALISIS
                'IND_ESTADO'            => '1',
                'IND_TIPOCITA'          => $COD_TRAZADORA,
                'NUM_CITACION'          => $num_id_citas,
                'COD_USRCREA'           => $session,
                'DATE_CREA'             => 'SYSDATE',
                'COD_EMPRESA'           => $empresa,
                'ID_ACTIVIDADAGENDA'    => '1',
                'DES_OBSERVACION'       => '',
                'IND_SOBRECUPO'         => '0',
                'ID_COD_RECURSO'        => $sec_numRecurso,
                'ID_NUMAGENDA'          => $sec_numAgenda,
            );
        }
        
                $this->db->insert_batch($this->own.'.AP_TAGENDA_BLOQUE',$dataBloque);
                $this->db->insert_batch($this->own.'.AP_TCITAXPACIENTE',$dataCitas);
                $this->db->trans_complete();
        return  $this->db->trans_status();  
    }
    
    
    //***************************** CORECCION DE HOJA DIARIA *****************************//
    public function Modelguardacorrecionhd($empresa,$session,$HD,$OP,$ID_ADMISION,$form,$fec_dial,$hora_dial,$IDCORRECION,$KEY){
        $this->db->trans_start();
            //********************** FINAL guarda historia HOJA DIARIA************************************************************************************************//
            //$numHisto         = $this->db->sequence($this->ownPab,'SEQ_PB_HISTOTABLAOPERATORIA'); 
            //$NAMESESSION      = $this->session->userdata("NAMESESSION");
            //$unique           = $this->session->userdata("unique");
            
        
            $return             = '';
            if(!$histoIC        = $this->db->query($this->sql_class_hdial->sql_guardaHistorial_HD($HD,$session,$_SERVER["REMOTE_ADDR"]))){
                //error_log("****************************************************-> ERROR AL GRABAR   <-********************************************************");
            } else {
                //error_log("****************************************************-> GRABADO HISTORIAL <-************************************************");
            }
            //********************** INICIO guarda historia HOJA DIARIA************************************************************************************************//
                $data_HD        = array('USR_AUDITA'                            => $session, 'FEC_AUDITA'   => 'SYSDATE');
                $data_SV        = array('ID_TDSIGNOSVITALES'                    => $this->db->sequence($this->own,'SEQ_HDIAL_TDSIGNOSVITALES'), 
                                        'ID_TDHOJADIARIA'                       => $HD,
                                        'IND_ESTADO'                            => '1',
                                        'IND_TOMASIGNO'                         => $OP,
                                        'USR_CREA'                              => $session,
                                        'DATE_CREA'                             => 'SYSDATE'
                                    );
                
                foreach($form as $infObject => $Object){
                        if($infObject == 'datosProgramacion'){
                        $FormProgramacion   = $Object[0]['Form_Programacion'];
                        if(count($FormProgramacion)>0){
                            foreach ($FormProgramacion as $From){
                                if($From['name'] == 'txtHoraIngresoPre')        { $data_HD = array_merge($data_HD, array('DATE_REALIZAHD'           => "TO_DATE('".$fec_dial." ".$From['value']."', 'DD/MM/YYYY hh24:mi')")); $hora_dial2 = $From['value'];}
                                
                                if($From['name'] == 'input_pesoSeco')           { $data_HD = array_merge($data_HD, array('NUM_PESOSECO'             => str_replace(".",",",$From['value']))); }
                                if($From['name'] == 'hd_anterior')              { $data_HD = array_merge($data_HD, array('NUM_HDPESOANTERIOR'       => str_replace(".",",",$From['value']))); }
                                if($From['name'] == 'pesopredialisis')          { $data_HD = array_merge($data_HD, array('NUM_PESOPREDIALISIS'      => str_replace(".",",",$From['value']))); }
                                if($From['name'] == 'alza_interdialisis')       { $data_HD = array_merge($data_HD, array('NUM_INTERDIALISIS'        => str_replace(".",",",$From['value']))); }
                                if($From['name'] == 'altainterdialisis')        { $data_HD = array_merge($data_HD, array('NUM_PESOINTERDIALISIS'    => str_replace(".",",",$From['value']))); }
                                
                                //NEW
                                if($From['name'] == 'ufprograma')               { $data_HD = array_merge($data_HD, array('NUM_UFPROGRAMADA'         => str_replace(".",",",$From['value']))); }
                                if($From['name'] == 'ufprograma_um')            { $data_HD = array_merge($data_HD, array('NUM_UFPROGRAMADA_UM'      => str_replace(".",",",$From['value']))); }
                                
                                if($From['name'] == 'prsopostdialisis')         { $data_HD = array_merge($data_HD, array('NUM_PESOPOSTDIALISIS'     => str_replace(".",",",$From['value']))); }
                                if($From['name'] == 'txtperdidasdepeso')        { $data_HD = array_merge($data_HD, array('NUM_PESOINTERDIALISIS'    => str_replace(".",",",$From['value']))); }
                            }
                        } 
                        //******** Inicio actualiza la hora en la admision ****//
                        $AD_FHADMISION                  = explode("-",$fec_dial);
                        $upAdmision                     = array(
                            'AD_FHADMISION'             => $AD_FHADMISION[0]."/".$AD_FHADMISION[1]."/".$AD_FHADMISION[2]." ".$hora_dial2.":00,000000",      
                            'PR_PROFEDIT'               => $session, 
                            'AD_FHEDIT'                 => 'SYSDATE', 
                        );
                        $this->db->where('AD_ID_ADMISION',$ID_ADMISION);
                        $this->db->update($this->own.'.URG_TADMISION',$upAdmision);
                        
                        //******** Final actualiza la hora en la admision ****//
                    } else  if($infObject == 'datosdesconexion'){
                        $Form_datosdesconexion          = $Object[0]['Form_datosdesconexion'];
                        if(count($Form_datosdesconexion)>0){
                            foreach($Form_datosdesconexion as $From){
                                if($From['name'] == 'txtHoraEgreso')            { $data_HD = array_merge($data_HD, array('DATE_FHEGRESO'            => "TO_DATE('".$fec_dial." ".$From['value']."', 'DD/MM/YYYY hh24:mi')"));}
                                if($From['name'] == 'prsopostdialisis_term')    { $data_HD = array_merge($data_HD, array('NUM_PESOPOSTDIALISIS'     => str_replace(".",",", $From['value'])));}
                                if($From['name'] == 'txtperdidasdepeso_term')   { $data_HD = array_merge($data_HD, array('NUM_PESOINTERDIALISIS'    => str_replace(".",",", $From['value'])));}
                                if($From['name'] == 'txttotalufconseguida')     { $data_HD = array_merge($data_HD, array('NUM_TOTALUFCONSEGIDA'     => $From['value']));}
                                if($From['name'] == 'txttotalufconseguida_um')     { $data_HD = array_merge($data_HD, array('NUM_TOTALUFCONSEGIDA_UM'     => $From['value']));}
                                
                                
                                if($From['name'] == 'volsangreacomulado')       { $data_HD = array_merge($data_HD, array('NUM_VOLSANGREACOMULADA'   => $From['value']));}
                                if($From['name'] == 'SL_DESIFCACCIONMAQUINA')   { $data_HD = array_merge($data_HD, array('IND_DESIFCACCIONMAQUINA'  => $From['value']));}
                                if($From['name'] == 'SL_DIALIZADORDIAL')        { $data_HD = array_merge($data_HD, array('IND_DIALIZADORDIAL'       => $From['value']));}
                                if($From['name'] == 'num_kt_b')                 { $data_HD = array_merge($data_HD, array('NUM_KT_V'                 => $From['value']));}
                            }
                        } 
                    } else  if($infObject == 'datosPresion'){
                        $Form_datosPresion           = $Object[0]['Form_datosPresion'];
                        //VOLVER EL ULTMIMO INACTIVO
                        $this->db->where('IND_TOMASIGNO',$OP);
                        $this->db->where('ID_TDHOJADIARIA',$HD);
                        $this->db->update($this->own.'.HD_TDSIGNOSVITALES',array('IND_ESTADO'=>'0','COD_AUDITA'=>$session,'DATE_AUDITA'=>'SYSDATE'));
                        
                        //VOLVER EL ULTMIMO INACTIVO
                        if(count($Form_datosPresion)>0){
                            foreach($Form_datosPresion as $From){
                                if($From['name'] == 'txtHoraIngreso')           { $data_SV = array_merge($data_SV, array('DATE_HORA'                => "TO_DATE('".date("d-m-Y")." ".$From['value']."', 'DD-MM-YYYY hh24:mi')"));}
                              //if($From['name'] == 'txtpresionalterial')       { $data_SV = array_merge($data_SV, array('NUM_PARTERIAL'            => $From['value']));}
                                if($From['name'] == 'txtpresionalterial_s')     { $data_SV = array_merge($data_SV, array('NUM_PARTERIAL_S'          => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'txtpresionalterial_d')     { $data_SV = array_merge($data_SV, array('NUM_PARTERIAL_D'          => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'txttpaciente')             { $data_SV = array_merge($data_SV, array('NUM_TPACIENTE'            => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'txtpulso')                 { $data_SV = array_merge($data_SV, array('NUM_PULSO'                => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'txttemmonitor')            { $data_SV = array_merge($data_SV, array('NUM_TMONITOR'             => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'Q_B_PROG')                 { $data_SV = array_merge($data_SV, array('NUM_QBPROG'               => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'Q_B_EFEC')                 { $data_SV = array_merge($data_SV, array('NUM_QBEFEC'               => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'TXTPA')                    { $data_SV = array_merge($data_SV, array('NUM_PA'                   => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'TXTPV')                    { $data_SV = array_merge($data_SV, array('NUM_PV'                   => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'TXTPTM')                   { $data_SV = array_merge($data_SV, array('NUM_PTM'                  => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'TXTCOND')                  { $data_SV = array_merge($data_SV, array('NUM_COND'                 => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'TXTUFH')                   { $data_SV = array_merge($data_SV, array('NUM_UFH'                  => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'TXTTAZAUFH')               { $data_SV = array_merge($data_SV, array('NUM_TAZAUFH'              => str_replace(".", ",", $From['value'])));}
                                if($From['name'] == 'TXTINGRESO')               { $data_SV = array_merge($data_SV, array('TXT_INGRESO'              => str_replace(".", ",", $From['value'])));}
                                
                                if($From['name'] == 'TXTUFACOMULADA')           { $data_SV = array_merge($data_SV, array('NUM_UFACOMULADA'          => str_replace(".", ",", $From['value'])));}
                                //NEW
                                if($From['name'] == 'TXTUFACOMULADA_UM')        { $data_SV = array_merge($data_SV, array('NUM_UFACOMULADA_UM'       => $From['value']));}
                                
                                
                                if($From['name'] == 'TXTOBSERVACIONES')         { $data_SV = array_merge($data_SV, array('TXTOBSERVACIONES'         => $From['value']));}
                                if($From['name'] == 'ind_tomadesigno')          { $data_SV = array_merge($data_SV, array('IND_TOMASIGNO'            => $From['value']));}
                            }
                        }
                        $this->db->insert($this->own.'.HD_TDSIGNOSVITALES',$data_SV); 
                        
                    } else  if($infObject == 'rrhh_conexion'){
                        $Form_rrhhConexion           = $Object[0]['Form_rrhhConexion'];
                        if(count($Form_rrhhConexion)>0){
                            $this->db->where('IND_HDESTAPA',$OP);
                            $this->db->where('ID_TDHOJADIARIA',$HD);
                            $this->db->update($this->own.'.HD_RHERMOPROFE',array('IND_ESTADO'=>'0','USR_AUDITA'=>$session,'DATE_AUDTITA'=>'SYSDATE'));
                            foreach($Form_rrhhConexion as $From){
                                $RUTPRO             = $From['value'];
                                $query          = $this->db->query($this->sql_class_hdial->sqlExisteFuncion($RUTPRO,$OP,$HD));
                                $extistRRHH     = $query->result_array();
                                
                                if (count($extistRRHH)>0){
                                    $this->db->where('ID_RPROFE',$extistRRHH[0]["ID_RPROFE"]);
                                    $this->db->update($this->own.'.HD_RHERMOPROFE',array('IND_ESTADO'=>'1'));
                                } else {
                                    $rrhhDiario     = array('COD_RUTPAC'=>$From['value'],'IND_HDESTAPA'=>$OP,'USR_CREA'=>$session,'DATE_CREA'=>'SYSDATE','ID_TDHOJADIARIA'=>$HD,'IND_ESTADO'=>1);
                                    $this->db->insert($this->own.'.HD_RHERMOPROFE',$rrhhDiario);
                                }
                            }
                        }
                    }
                }
                
                $this->db->where('ID_TDHOJADIARIA',$HD);
                $this->db->update($this->own.'.HD_TDHOJADIARIA', $data_HD);
                
                $this->db->where('ID_PEDICION',$IDCORRECION);
                $this->db->update($this->own.'.HD_REGEDICION', array('IND_ESTADO'=>'0','ID_TDHOJADIARIA'=>$HD));
                
                $query          = $this->db->query($this->sql_class_hdial->sql_ListadopremisosxHD($empresa,$HD,$KEY,$IDCORRECION));
                $extisMASPER    = $query->result_array();
                if(count($extisMASPER)>1){
                    $this->db->where('ID_TCORECION',$extisMASPER[0]["CORRECION"]);
                    $this->db->update($this->own.'.HD_TSISCORECION',array('COD_AUDITA'=>$session,'FEC_AUDITA'=>'SYSDATE'));  
                    $return = 0;  
                } else {
                    $this->db->where('ID_TCORECION',$extisMASPER[0]["CORRECION"]);
                    $this->db->update($this->own.'.HD_TSISCORECION',array('COD_AUDITA'=>$session,'FEC_AUDITA'=>'SYSDATE','IND_ESTADO'=>'0'));
                    //error_log("--------------------------------coutn-----------------------------------------");
                    //error_log("----------------------------->".$extisMASPER["CORRECION"]."--------------------------------");
                    //error_log("-------------------------------------------------------------------------");
                    $return = 1;
                }
                
                $this->db->trans_complete();
                $this->db->trans_status(); 
                
        return  $return;
    }
   
    public function getActualizaPermiso($session,$HD){
        $this->db->trans_start();
        $this->db->where('ID_PEDICION',$HD);
        $this->db->update($this->own.'.HD_REGEDICION', array('IND_ESTADO'=>'0'));
        $this->db->trans_complete();
        return $this->db->trans_status(); 
    }
    
    public function Modeldesabilitahd($empresa,$session,$IDHOJADIARIA,$AD_ID_ADMISION,$ID_TE){
        $this->db->trans_start(); 
            if(!$histoIC    =   $this->db->query($this->sql_class_hdial->sql_guardaHistorial_HD($IDHOJADIARIA,$session,$_SERVER["REMOTE_ADDR"]))){
                error_log("***********************-> ERROR AL GRABAR   Modeldesabilitahd <-************************************************");
            } else {
                error_log("***********************-> GRABADO HISTORIAL Modeldesabilitahd <-************************************************");
            }
            $this->db->where('ID_PEDICION',$ID_TE);
            $this->db->update($this->own.'.HD_REGEDICION', array('IND_ESTADO'=>'0','ID_TDHOJADIARIA'=>$IDHOJADIARIA));
            $this->db->where('AD_ID_ADMISION',$AD_ID_ADMISION);
            $this->db->update($this->own.'.URG_TADMISION', array('AD_ACTIVA'=>'0'));
            //$this->db->affected_rows()
        $this->db->trans_complete();
        return $this->db->trans_status(); 
    }

    public function model_ingreso_paciente($aData){
        $user_respon                =   $aData['user_respon'][0];
        $status_trasaccion          =   true;
        $v_num_fichae               =   $aData['v_num_fichae'];
        $session                    =   $user_respon['USERNAME'];
        $date_fecha_ingreso         =   $aData['arr_envio']['fecha_ingreso'];
        $v_empresa                  =   $aData['empresa'];
        $arr_codcie10               =   $aData['arr_codcie10'];  
        #var_dump($arr_codcie10);
        #return false;
        $id_formulario_unico        =   $this->db->sequence($this->own,'SEQ_FORMULARIOINGRESO');
        $data_insert                =   [
            'ID_INGRESOHD'          =>  $id_formulario_unico,
            'NUM_FICHAE'            =>  $v_num_fichae,
            'TXT_NAME'              =>  $user_respon['NAME'],
            'COD_CREA'              =>  $session,
            'DATE_CREA'             =>  'SYSDATE',
            'IND_ESTADO'            =>  1,
            'COD_EMPRESA'           =>  $v_empresa,

            'TXT_ANTECEDENTESQX'    =>  $aData['arr_envio']['txt_antecedente_qx'],
            'IND_ANTALERGICOS'      =>  $aData['arr_envio']['ingreso_enfe_antenecentealergia'],
            'TXT_ALIMENTOS'         =>  $aData['arr_envio']['txt_alimento_alergia'],
            'TXT_MEDICAMENTOS'      =>  $aData['arr_envio']['txt_medicamento_alergia'],
            'TXT_OTROS'             =>  $aData['arr_envio']['txt_otro_alergia'],
            'TXT_LLAMAR_URGENCIA'   =>  $aData['arr_envio']['txt_persona_urgencia'],
            'IND_GRUPO_SANGUINEO'   =>  $aData['arr_envio']['cboGrupoSangre'],
            'IND_FACTOR_SANGRE'     =>  $aData['arr_envio']['cboFactorSangre'],

            'TXT_KILOGRAMOS'        =>  $aData['arr_envio']['num_kilogramos'], 
            'TXT_FRECUENCIAC'       =>  $aData['arr_envio']['num_frecuenciacardiaca'], 
            'TXT_PDISTOLICA'        =>  $aData['arr_envio']['nun_presiondistolica'], 
            'TXT_PSISTOLICA'        =>  $aData['arr_envio']['num_presionsistolica'], 
            'TXT_TALLA'             =>  $aData['arr_envio']['txt_talla'], 

            'TXT_MOVILIDAD'         =>  $aData['arr_envio']['txt_ef_movilidad'],  
            'TXT_NUTRICION'         =>  $aData['arr_envio']['txt_ef_nutricion'],
            'TXT_GRADOCONCIENCIA'   =>  $aData['arr_envio']['txt_ef_gradoconciencia'],

            'TXT_ESTADOPIEL'        =>  $aData['arr_envio']['txt_ef_estadodelapiel'], 
            'TXT_CONJUNTIVAS'       =>  $aData['arr_envio']['txt_ef_conjuntivas'],  
            'TXT_YUGULARES'         =>  $aData['arr_envio']['txt_ef_yugulares'], 
            'TXT_EXTREMIDADES'      =>  $aData['arr_envio']['txt_ef_extremidades'],  

            'TXT_FAV'               =>  $aData['arr_envio']['txt_fav'], 
            'DATE_FAV'              =>  "TO_DATE('".$aData['arr_envio']['fecha_fav']."','DD-MM-YYYY')",
            'TXT_GOROTEX'           =>  $aData['arr_envio']['txt_gorotex'],
            'DATE_GOROTEX'          =>  "TO_DATE('".$aData['arr_envio']['fecha_gorotex']."','DD-MM-YYYY')",
            'TXT_CATETER'           =>  $aData['arr_envio']['txt_cateter'],
            'DATE_CATETER'          =>  "TO_DATE('".$aData['arr_envio']['fecha_cateter']."','DD-MM-YYYY')",
            'IND_DIURESIS'          =>  $aData['arr_envio']['slc_diuresis'],  
            'DATE_DIURESIS'         =>  "TO_DATE('".$aData['arr_envio']['fecha_diuresis']."','DD-MM-YYYY')",

            'TXT_HVC'               =>  $aData['arr_envio']['txt_hvc'],
            'DATE_HVC'              =>  "TO_DATE('".$aData['arr_envio']['fecha_hvc']."','DD-MM-YYYY')",
            'TXT_HIV'               =>  $aData['arr_envio']['txt_hiv'],
            'DATE_HIV'              =>  "TO_DATE('".$aData['arr_envio']['fecha_hiv']."','DD-MM-YYYY')",
            'TXT_HBSAG'             =>  $aData['arr_envio']['txt_hbsag'],
            'DATE_HBSAG'            =>  "TO_DATE('".$aData['arr_envio']['fecha_hbsag']."','DD-MM-YYYY')",

            'TXT_QB'                =>  $aData['arr_envio']['txt_antecenteshermo_qb'], 
            'TXT_HEPARINA_I'        =>  $aData['arr_envio']['txt_hepatina_i'], 
            'TXT_HEPARINA_M'        =>  $aData['arr_envio']['txt_hepatina_m'], 
            'TXT_1RA_DOSIS_HVB'     =>  $aData['arr_envio']['txt_dosisi_hvb'], 

            'TXT_QD'                =>  $aData['arr_envio']['txt_antecenteshermo_qd'], 
            'TXT_BANO_KNA'          =>  $aData['arr_envio']['txt_bano_kna'],
            'TXT_2DA_DOSIS_HVB'     =>  $aData['arr_envio']['txt_2da_dosis_hvb'],

            'TXT_PESOSECO'          =>  $aData['arr_envio']['txt_antecenteshermo_pesoseco'],
            'TXT_CONCENTRADO'       =>  $aData['arr_envio']['txt_antecenteshermo_concentrado'],
            'TXT_3DA_DOSIS_HVB'     =>  $aData['arr_envio']['txt_3da_dosis_hvb'],
            'TXT_REFUERZO_HVB'      =>  $aData['arr_envio']['txt_dosis_refuerzo_hvb'],
            'TXT_OBSERVACIONES'     =>  $aData['arr_envio']['txt_observaciones_finales'], 
        ];

        $ID_HDIAL                   =   $this->db->sequence($this->own,'SEQ_HDIAL_PACIENTEDIALISIS');
        $dataIngreso                =   [
                                            'ID_NUMINGRESO' =>  $ID_HDIAL, 
                                            'NUM_FICHAE'    =>  $v_num_fichae, 
                                            'ID_SIC'        =>  '', 
                                            'COD_EMPRESA'   =>  $v_empresa, 
                                            'COD_USRCREA'   =>  $session,  
                                            'FEC_INGRESO'   =>  'SYSDATE', 
                                            'FEC_CREA'      =>  'SYSDATE', 
                                            'IND_ESTADO'    =>  '1',
                                            'ID_INGRESOHD'  =>  $id_formulario_unico,
                                        ];
        $this->db->trans_start();
        if (count($arr_codcie10)>0)     {
            foreach($arr_codcie10 as $row) {
                $data_relacion  = [
                    'ID_RELACION'       =>  $this->db->sequence($this->own,'SEQ_CIE10XINGRESODIAL'),
                    'ID_INGRESO'        =>  $ID_HDIAL,          #Asume que este es el ID del ingreso recién insertado
                    'ID_DIAGNOSTICO'    =>  $row,
                    'FECHA_DIAGNOSTICO' =>  'SYSDATE',          #Asume que tienes una fecha específica para cada diagnóstico
                    'IND_ESTADO'        =>  1,                  #o cualquier otro valor relevante para el estado
                ];
                $this->db->insert($this->own.'.TGCD_INGRESO_CIE_REL', $data_relacion);
            }
        }
        $this->db->insert($this->own.'.HD_FORMULARIOINGRESO', $data_insert); 
        $this->db->insert($this->own.'.HD_TINGRESO', $dataIngreso); 
        $this->db->trans_complete();
        return [
            'status'                =>  $this->db->trans_status(),
            'data_inser'            =>  $data_inser,
            'status_trasaccion'     =>  $status_trasaccion,
            'id_formulario_unico'   =>  $id_formulario_unico,
            'id_ingreso_dialisis'   =>  $ID_HDIAL,
        ];
    }

    public function busqueda_paciente_ingresos($aData){
        $v_sql =    "SELECT 
                        TO_CHAR(I.FEC_INGRESO,'DD-MM-YYYY'),
                        I.COD_EMPRESA
                    FROM
                        $this->own.HD_TINGRESO I
                    WHERE
                        I.IND_ESTADO IN (1)
                    AND 
                        I.NUM_FICHAE IN (".$aData['num_fichae'].")    
                    ";
        return $this->db->query($v_sql)->result_array();
    }

    public function informacio_formularioingreso($aData){
        $ID_FORMULARIO  =   $aData['ID_FORMULARIO'];
        $ID_INGRESO     =   $aData['ID_INGRESO'];

        $v_sql = "SELECT 
                    UPPER(G.NOM_NOMBRE||' '||G.NOM_APEPAT||' '||G.NOM_APEMAT)   AS NOMPAC,
                    G.COD_RUTPAC||'-'||G.COD_DIGVER                             AS RUTPAC,
                    TO_CHAR(G.FEC_NACIMI,'DD-MM-YYYY')                          AS NACIMIENTO,
                    FLOOR(MONTHS_BETWEEN(SYSDATE, G.FEC_NACIMI) / 12) AS NUM_YEAR,
                    FLOOR(MOD(MONTHS_BETWEEN(SYSDATE, G.FEC_NACIMI), 12)) AS MESES,
                    FLOOR(SYSDATE - ADD_MONTHS(G.FEC_NACIMI, FLOOR(MONTHS_BETWEEN(SYSDATE, G.FEC_NACIMI)))) AS DIAS,
                    C.ID_INGRESOHD,
                    C.NUM_FICHAE,
                    C.TXT_NAME,
                    C.COD_CREA,
                    C.TXT_NOMBRECREA,
                    C.DATE_CREA,
                    C.IND_ESTADO,
                    C.COD_EMPRESA,

                    C.TXT_ANTECEDENTESQX,
                    C.IND_ANTALERGICOS,
                    DECODE (C.IND_ANTALERGICOS,
                        '1','SI',
                        '0','NO',
                        '2','NO SABE','NO INFORMADO')                                                   AS TXT_ANTALERGICOS,
                    CASE WHEN C.IND_ANTALERGICOS = 1 THEN C.TXT_ALIMENTOS ELSE 'No informado' END       AS TXT_ALIMENTOS,
                    CASE WHEN C.IND_ANTALERGICOS = 1 THEN C.TXT_MEDICAMENTOS ELSE 'No informado' END    AS TXT_MEDICAMENTOS,
                    CASE WHEN C.IND_ANTALERGICOS = 1 THEN C.TXT_OTROS ELSE 'No informado' END           AS TXT_OTROS,
                    C.TXT_LLAMAR_URGENCIA,
                    C.IND_GRUPO_SANGUINEO, 
                    C.IND_FACTOR_SANGRE, 
                    DECODE (C.IND_ANTALERGICOS,
                        '1','RH(+)',
                        '0','RH(-)',
                        'NS','NO SABE','NO INFORMADO')                                                   AS TXT_FACTOR_SANGRE,
                    C.TXT_KILOGRAMOS, 
                    C.TXT_FRECUENCIAC, 
                    C.TXT_PDISTOLICA, 
                    C.TXT_PSISTOLICA, 
                    C.TXT_TALLA,
                    C.TXT_MOVILIDAD, 
                    C.TXT_NUTRICION,
                    'SUBIR A BD' AS TXT_GRADOCONCIENCIA,
                    C.TXT_ESTADOPIEL, 
                    C.TXT_CONJUNTIVAS, 
                    C.TXT_YUGULARES, 
                    C.TXT_EXTREMIDADES, 
                    C.TXT_FAV, 
                    TO_CHAR(C.DATE_FAV,'DD-MM-YYYY')        AS DATE_FAV,
                    C.TXT_GOROTEX, 
                    TO_CHAR(C.DATE_GOROTEX,'DD-MM-YYYY')    AS DATE_GOROTEX,
                    C.TXT_CATETER, 
                    TO_CHAR(C.DATE_CATETER,'DD-MM-YYYY')    AS DATE_CATETER,
                    DECODE (C.IND_DIURESIS,
                        '1','SI',
                        '0','NO','NO INFORMADO')            AS TXT_DIURESIS,
                    TO_CHAR(C.DATE_DIURESIS,'DD-MM-YYYY')   AS DATE_DIURESIS,
                    C.TXT_HVC, 
                    TO_CHAR(C.DATE_HVC,'DD-MM-YYYY')        AS DATE_HVC,
                    C.TXT_HIV, 
                    TO_CHAR(C.DATE_HIV,'DD-MM-YYYY')        AS DATE_HIV,
                    C.TXT_HBSAG, 
                    TO_CHAR(C.DATE_HBSAG,'DD-MM-YYYY')      AS DATE_HBSAG,

                    C.TXT_QB, 
                    C.TXT_HEPARINA_I, 
                    C.TXT_HEPARINA_M,
                    C.TXT_1RA_DOSIS_HVB,

                    C.TXT_QD, 
                    C.TXT_BANO_KNA, 
                    C.TXT_2DA_DOSIS_HVB, 
                    C.TXT_PESOSECO, 
                    C.TXT_CONCENTRADO, 
                    C.TXT_3DA_DOSIS_HVB, 
                    C.TXT_REFUERZO_HVB, 
                    C.TXT_OBSERVACIONES,
                    C.TXT_NAME_AUDITA,
                    C.COD_AUDITA,
                    C.DATE_AUDITA
                FROM 
                    ADMIN.HD_FORMULARIOINGRESO C,
                    ADMIN.GG_TGPACTE G
                WHERE 
                    C.ID_INGRESOHD = $ID_FORMULARIO AND 
                    G.NUM_FICHAE = C.NUM_FICHAE AND 
                    C.IND_ESTADO IN (1)
                ";

        $sql_v = "SELECT
                    IC.ID_RELACION,
                    IC.ID_INGRESO,
                    IC.ID_DIAGNOSTICO,
                    IC.FECHA_DIAGNOSTICO,
                    IC.IND_ESTADO,
                    CD.CODIGO_DG_BASE,
                    CD.DESCRIPCION,
                    CD.IND_GES,
                    CD.IND_SEXO,
                    CD.IND_CRONICANOT,
                    CD.PRIORIDAD_ID
                FROM
                    ADMIN.TGCD_INGRESO_CIE_REL IC
                JOIN
                    ADMIN.TGCD_CIE_DIAGNOSTICOS CD ON IC.ID_DIAGNOSTICO = CD.ID
                WHERE
                    IC.ID_INGRESO = $ID_INGRESO -- Aquí sustituyes :ID_INGRESO por el valor real del ID de ingreso.
        ";            
        return [
            'arr_formulario'    =>  $this->db->query($v_sql)->result_array(),
            'arr_cie10'         =>  $this->db->query($sql_v)->result_array(),
        ];
    }

}