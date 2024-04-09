<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Ssan_hdial_ingresoegresopaciente_model extends CI_Model {

    var $tableSpace = "ADMIN";
    var $own        = "ADMIN";
    var $ownGu      = "GUADMIN";

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('oracle_conteiner',true);
        $this->load->model("sql_class/sqlclass_archivo");
    }

    public function load_busqueda_rrhhdialisis($data_controller) {
        $this->db->trans_start();
        $param              =   array(
                                    #variable
                                    array( 
                                        'name'      =>  ':V_COD_EMPRESA',//codigo de empresa
                                        'value'     =>  $data_controller["empresa"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    array( 
                                        'name'      =>  ':V_FIRST',//si es la primera pasada 
                                        'value'     =>  $data_controller["ind_opcion"],
                                        'length'    =>  20,
                                        'type'      =>  SQLT_CHR 
                                    ),
                                    #CURSORES
                                    array( 
                                        'name'      =>  ':C_RESULT_RRHH',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    array( 
                                        'name'      =>  ':C_LOGS',//status
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                );
        #$result                                  =   [];
        $result                                   =   $this->db->stored_procedure_multicursor($this->own.'.PROCE_GESTION_DIALISIS','LOAD_DATA_LISTA_RRHH',$param);
        $this->db->trans_complete();
        return array(
            'return_bd'                           =>  $result,
            'html_out'                            =>  $this->load->view("ssan_hdial_ingresoegresopaciente/html_lista_rrhhdialisis",array('bd'=>$result),true),
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
                                        'name'      =>  ':P_RETURN_LOGS',
                                        'value'     =>  $this->db->get_cursor(),
                                        'length'    =>  -1,
                                        'type'      =>  OCI_B_CURSOR
                                    ),
                                    
                                );
        #$result           =    [];
        $result            =    $this->db->stored_procedure_multicursor($this->own.'.PROCE_GESTION_DIALISIS','DATA_VALIDA_PROFESIONAL',$param);
        $this->db->trans_complete();
        return array(
            'STATUS'	   =>	$this->db->trans_status(),
            'DATA'         =>   $result,
        );
    }
    
    public function model_elimina_rrhh($data){
        $this->db->trans_start();
        $this->db->where('COD_RUTPRO',$data['cod_rutpro']); 
        $this->db->update($this->own.'.HD_RRHHDIALISIS',array('IND_ESTADO'=>'0','FEC_AUDITA'=>'SYSDATE','COD_AUDITA'=>$data['session']));
        $this->db->trans_complete();
        return array(
            'STATUS'        =>	$this->db->trans_status(),
            'DATA'          =>  $data,
        );
    }
    
    public function model_record_rotulos_por_usuario($data){
        $this->db->trans_start();
        $COD_RUTPRO         =   $data['ind_proesional']['COD_RUTPRO'];
        $ID_PRO             =   $data['ind_proesional']['ID_PRO'];
        $array              =   $this->db->query("SELECT H.ID_RRHH FROM ADMIN.HD_RRHHDIALISIS H WHERE  H.COD_EMPRESA IN (".$data['empresa'].") AND H.COD_RUTPRO IN (".$COD_RUTPRO.") ")->result_array();
        if(count($array)>0){
            $this->db->where('ID_RRHH',$array[0]['ID_RRHH']); 
            $this->db->update($this->own.'.HD_RRHHDIALISIS',array('IND_ESTADO'=>'1','FEC_AUDITA'=>'SYSDATE','COD_AUDITA'=>$data['session']));
        } else {
            $dataPreg1                      =   array(
                "ID_RRHH"                   =>  $this->db->sequence($this->own,'SEQ_RRHH_DIALISIS'),
                "COD_EMPRESA"               =>  $data['empresa'],
                "ID_PROFESIONAL"            =>  $ID_PRO,
                "COD_RUTPRO"                =>  $COD_RUTPRO,
                "IND_ESTADO"                =>  1,
                "COD_USERCREA"              =>  $data['session'],
                "DATE_CREA"                 =>  'SYSDATE'
            );
            $this->db->insert($this->own.'.HD_RRHHDIALISIS', $dataPreg1);
        }
        $this->db->trans_complete();
        return array(
            'STATUS'                        =>	$this->db->trans_status(),
            'DATA'                          =>  $data,
        );
    }
    
    //**************************************************************************
    //code old
    //Forma de realizar una consulta SQL
    //**************************************************************************
    public function TraeUDingres() {
        $query = $this->db->first_query("SELECT 
            FOLIO_ORIGEN
            FROM 
            ADMIN.AP_TPACXPROGRAMA
            WHERE     
                NUM_FICHAE = 74666
            AND ID_PROGRAMA = 17
            AND FOLIO_ORIGEN = (SELECT MAX (FOLIO_ORIGEN)  FROM ADMIN.AP_TPACXPROGRAMA  WHERE NUM_FICHAE = 74666 AND ID_PROGRAMA = 17)");
        return $query->result_array();
    }

    public function Cons_ingresoPac($rut, $empresa) {
        $query = $this->db->query("
                SELECT 
                    H.ID_NUMINGRESO                                         AS ID_INGRESO, 
                    H.NUM_FICHAE                                            AS NUM_FICHAE, 
                    H.ID_SIC,
                    H.COD_EMPRESA, 
                    H.COD_USRCREA, 
                    H.FEC_CREA,
                    H.IND_ESTADO,
                    H.DATE_EGRESO,
                    H.ID_ESTADOHD,
                    H.ID_EGRESO,
                    TO_CHAR(H.FEC_INGRESO, 'DD-MM-YYYY')                    AS FINGRESO,
                    ''                                                      AS FINGRESO_HISTO,
                    DECODE(H.IND_ESTADO,
                                        '1','VIGENTE',
                                        '2','ELIMINADO',
                                        '3','EGRESADO',
                                        'NO INFORMADO')                     AS TXTESTADO,

                    G.COD_RUTPAC||'-'||G.COD_DIGVER                         AS RUTPAC,
                    TRUNC(MONTHS_BETWEEN(SYSDATE,G.FEC_NACIMI)/12)          AS TXTEDAD,
                    G.NUM_CELULAR                                           AS CELULAR,
                    G.NOM_APEPAT||' '||G.NOM_APEMAT||' '||G.NOM_NOMBRE      AS NOM_APELLIDO,
                    G.NOM_NOMBRE||' '||G.NOM_APEPAT||' '||G.NOM_APEMAT      AS NOM_COMPLETO
                FROM 
                    ADMIN.HD_TINGRESO      H, 
                    ADMIN.GG_TGPACTE       G
                WHERE
                    G.COD_RUTPAC        =   '$rut'
                AND G.NUM_FICHAE        =   H.NUM_FICHAE
                AND H.ID_NUMINGRESO     =   (SELECT MAX(HSS.ID_NUMINGRESO) FROM ADMIN.HD_TINGRESO HSS WHERE HSS.NUM_FICHAE=H.NUM_FICHAE) 
                
            ");
        return $query->result_array();// H.COD_EMPRESA   = '$empresa'
    }

    public function TraeREspxProg($numfichae, $empresa) {

        $query = $this->db->query("
                SELECT 
                RP.RESULTADO,
                RP.ID_CAMPXPROG,RP.COD_DIAGNO,
                DD.COD_DIAGNO_CIE, dd.DESCRIPCION,
                GUA.NOM_NOMBRE FIRST_NAME,
                GUA.NOM_APEPAT MIDDLE_NAME,
                GUA.NOM_APEMAT LAST_NAME,
                GUA.COD_RUTPRO || '-' || GUA.COD_DIGVER USERNAME,
                TO_CHAR (PA.FEC_NACIMI, 'dd/mm/yyyy') AS FEC_NACIMI,
                PA. NOM_NOMBRE,
                PA.NOM_APEPAT,
                PA.NOM_APEMAT,
                PA.COD_RUTPAC,
                PA.COD_DIGVER,
                BSS.NUM_RUTINS,
                ASS.IND_PREVIS,
                ASS.NOM_PREVIS, 
                DSS.NOM_INSEMP,
                ESTAB.NOM_ESTABL
            FROM
                ADMIN.AP_TPACXPROGRAMA          PR,
                ADMIN.AP_TRESULTXPROG           RP,
                ADMIN.TGCD_CIE_DIAGNOSTICOS     DD,
                ADMIN.GG_TPROFESIONAL           GUA,
                ADMIN.GG_TGPACTE                PA,
                ADMIN.SO_TTITUL                 BSS,
                ADMIN.GG_TDATPREV               ASS,
                ADMIN.GG_TINSEMP                DSS,
                ADMIN.GG_TESTABL                ESTAB
            WHERE
                PR.NUM_FICHAE   =$numfichae
                AND PR.ID_PACXPROG=RP.ID_PACXPROG
                AND PR.IND_ESTADO=1
                AND RP.COD_DIAGNO=dd.id (+)
                AND PR.FOLIO_ORIGEN=(SELECT FOLIO_ORIGEN
                FROM ADMIN.AP_TPACXPROGRAMA PP
                WHERE     
                    PP.NUM_FICHAE   = $numfichae
                AND PP.ID_PROGRAMA  = 17          
                AND PP.IND_ESTADO   =1
                AND 
                    PP.FOLIO_ORIGEN = (
                    SELECT MAX(AA.FOLIO_ORIGEN)
                    FROM 
                        ADMIN.AP_TPACXPROGRAMA AA
                    WHERE 
                        AA.NUM_FICHAE = $numfichae 
                        AND 
                        AA.ID_PROGRAMA = 17 
                        AND 
                        AA.IND_ESTADO = 1) 
                    )
                AND PR.PROF_INGRESO     =   GUA.COD_RUTPRO (+)
                AND PR.NUM_FICHAE       =   PA.NUM_FICHAE
                AND PA.COD_RUTTIT       =   BSS.COD_RUTTIT (+) 
                AND BSS.IND_PREVIS      =   ASS.IND_PREVIS(+) 
                AND BSS.NUM_RUTINS      =   DSS.COD_RUTINS (+)      
                AND PR.COD_EMPRESA      =   ESTAB.COD_ESTABL ");
        return $query->result_array();//  AND PR.COD_EMPRESA=$empresa
    }

//    public function INSERT_GuardaDatos($usuario,$empresa,$RUTFir,$DIGFir,$nombrefir,$fic_e,$ind_ing,$Resp_IngEnf_Dial,$Cie10Agrupados){
//            $this->db->trans_start();
//            $CITA_ADMISION=$ind_ing;
//             $SEQ_ID_PACXPROG = $this->db->sequence($this->own, 'SEQ_AP_TPACXPROGRAMA');    
//        $dataPreg1 = array(            
//            'ID_PACXPROG' => $SEQ_ID_PACXPROG,
//            'ID_PROGRAMA' => 17,
//            'NUM_FICHAE' => $fic_e,
//            'FECH_INGRESO' => "SYSDATE",//SOLO POR PRIMERA VEZ
//            'ORIGENSISTEMA' => 60,
//            'FECH_EGRESO' => "",
//            'IND_ESTADOPROG' => 1,//cuando??
//            'PROF_INGRESO' => $RUTFir,//puede cambiar  segun profesional OK
//            'COD_USRCREA' => $usuario,//solo la primera vez
//            'FEC_USRCREA' => "SYSDATE",
//            'IND_ESTADO' => 1,
//            'COD_EMPRESA' => $empresa,
//            'FOLIO_ORIGEN'  => $CITA_ADMISION
//        );       
//         $this->db->insert($this->own.'.AP_TPACXPROGRAMA', $dataPreg1);
//         
//         /////////////respuestas______________________________________________________________________
//          for ($i = 0; $i < count($Resp_IngEnf_Dial); $i++) { //For que recorre las reguntas                 
//        $idpregunta = $Resp_IngEnf_Dial[$i]["h"];
//        $Resp = $Resp_IngEnf_Dial[$i]["Resp_IngEnf_Dial_"];
//        
//        if($idpregunta==546 && $Resp==1){//diagnostico cie10 Y AEMAS CONTIENE DIAGNOSTICOS??
//            
//            
//             for ($x = 0; $x < count($Cie10Agrupados); $x++) { //For que recorre las reguntas                 
//       // $idpregunta = $Cie10Agrupados[$x]["h"];
//        $Resp = $Cie10Agrupados[$x]["RespCie"];
//         $SEQ_ID_RESXCAMP = $this->db->sequence($this->own, 'SEQ_AP_TRESULTXPROG');               
//        $dataPreg2[] = array(            
//            'ID_RESXCAMP' => $SEQ_ID_RESXCAMP,
//            'ID_CAMPXPROG' => 546,
//            'ID_PACXPROG' => $SEQ_ID_PACXPROG,            
//            'RESULTADO' => $Resp,
//            'FEC_INGRESO' => "SYSDATE",
//            'COD_USRCREA' => $RUTFir,
//            'FEC_USRCREA' => "SYSDATE",
//            'AD_ID_ADMISION' => $CITA_ADMISION 
//        );
//        
//        }
//            
//            
//        }else{
//            
//            
//             $SEQ_ID_RESXCAMP = $this->db->sequence($this->own, 'SEQ_AP_TRESULTXPROG');               
//        $dataPreg2[] = array(            
//            'ID_RESXCAMP' => $SEQ_ID_RESXCAMP,
//            'ID_CAMPXPROG' => $idpregunta,
//            'ID_PACXPROG' => $SEQ_ID_PACXPROG,            
//            'RESULTADO' => $Resp,
//            'FEC_INGRESO' => "SYSDATE",
//            'COD_USRCREA' => $RUTFir,
//            'FEC_USRCREA' => "SYSDATE",
//            'AD_ID_ADMISION' => $CITA_ADMISION 
//        );
//        
//        }
//        }
//        
//        
//             $this->db->insert_batch($this->own.'.AP_TRESULTXPROG', $dataPreg2); //para cualquier caso 
//              $this->db->trans_complete();        
//             return $this->db->trans_status();
//        
//        
//    }


    public function ModelNuevoPacienteIngreso($ed,$usuario, $empresa, $RUTFir, $DIGFir, $nombrefir, $fic_e, $Resp_IngEnf_Dial, $Cie10Agrupados, $fecha_histo) {
       $this->db->trans_start();
        if($ed!=''){//esta editando ultimo registro
            $CITA_ADMISION=$ed;//numero cita (id ingreso)
            
              $dataFun = array(           
            'IND_ESTADO' => 0,
            'COD_USREDIT' =>$RUTFir,
            'FEC_USREDIT' => "SYSDATE"
        );
        $this->db->where('FOLIO_ORIGEN',$CITA_ADMISION); 
         $this->db->where('IND_ESTADO',1); 
        $this->db->update($this->own . '.AP_TPACXPROGRAMA', $dataFun); 
            
            
        }else{//esta creando un nuevo ingresoa tratamiento
              $ID_HDIAL = $this->db->sequence($this->own, 'SEQ_HDIAL_PACIENTEDIALISIS');
        $dataIngreso = array(
            'ID_NUMINGRESO' => $ID_HDIAL,
            'NUM_FICHAE' => $fic_e,
            'ID_SIC' => '',
            'COD_EMPRESA' => $empresa,
            'COD_USRCREA' => $RUTFir,
            'FEC_INGRESO' => 'SYSDATE',
            'FEC_CREA' => 'SYSDATE',
            'IND_ESTADO' => '1',
            'DATE_HISTOINGRESO' => "TO_DATE('" . $fecha_histo . "', 'DD-MM-YYYY')",
        );
        $this->db->insert($this->own . '.HD_TINGRESO', $dataIngreso);
          $CITA_ADMISION= $ID_HDIAL; 
        }
       
        $SEQ_ID_PACXPROG = $this->db->sequence($this->own, 'SEQ_AP_TPACXPROGRAMA');
        $dataPreg1 = array(
            'ID_PACXPROG' => $SEQ_ID_PACXPROG,
            'ID_PROGRAMA' => 17,
            'NUM_FICHAE' => $fic_e,
            'FECH_INGRESO' => "SYSDATE", //SOLO POR PRIMERA VEZ
            'ORIGENSISTEMA' => 60,
            'FECH_EGRESO' => "",
            'IND_ESTADOPROG' => 1, //cuando??
            'PROF_INGRESO' => $RUTFir, //puede cambiar  segun profesional OK
            'COD_USRCREA' => $usuario, //solo la primera vez
            'FEC_USRCREA' => "SYSDATE",
            'IND_ESTADO' => 1,
            'COD_EMPRESA' => $empresa,
            'FOLIO_ORIGEN' => $CITA_ADMISION
        );
        $this->db->insert($this->own . '.AP_TPACXPROGRAMA', $dataPreg1);

        /////////////respuestas______________________________________________________________________
        for ($i = 0; $i < count($Resp_IngEnf_Dial); $i++) { //For que recorre las reguntas                 
            $idpregunta = $Resp_IngEnf_Dial[$i]["h"];
            $Resp = $Resp_IngEnf_Dial[$i]["Resp_IngEnf_Dial_"];

            if ($idpregunta == 546 ) {//diagnostico cie10 Y AEMAS CONTIENE DIAGNOSTICOS??///&& $Resp == 1
                for ($x = 0; $x < count($Cie10Agrupados); $x++) { //For que recorre las reguntas                 
                    //$idpregunta = $Cie10Agrupados[$x]["h"];
                    
                    if( $Cie10Agrupados[$x]["RespCie"]!=''){
                        $Resp = $Cie10Agrupados[$x]["RespCie"];
                    $SEQ_ID_RESXCAMP = $this->db->sequence($this->own, 'SEQ_AP_TRESULTXPROG');
                    $dataPreg2[] = array(
                        'ID_RESXCAMP' => $SEQ_ID_RESXCAMP,
                        'ID_CAMPXPROG' => 546,
                        'ID_PACXPROG' => $SEQ_ID_PACXPROG,
                        'COD_DIAGNO' => $Resp,
                        'RESULTADO' => "",
                        'FEC_INGRESO' => "SYSDATE",
                        'COD_USRCREA' => $RUTFir,
                        'FEC_USRCREA' => "SYSDATE",
                        'AD_ID_ADMISION' => $CITA_ADMISION
                    );  
                    }
                  
                }
            } else {
                if(is_numeric($idpregunta)){
                    //Esto es por que por alguna razon el sistema trae algunos camos 560  como 560-error
                    $SEQ_ID_RESXCAMP = $this->db->sequence($this->own, 'SEQ_AP_TRESULTXPROG');
                    $dataPreg2[] = array(
                        'ID_RESXCAMP' => $SEQ_ID_RESXCAMP,
                        'ID_CAMPXPROG' => $idpregunta,
                        'ID_PACXPROG' => $SEQ_ID_PACXPROG,
                        'RESULTADO' => $Resp,
                        'COD_DIAGNO' => "",
                        'FEC_INGRESO' => "SYSDATE",
                        'COD_USRCREA' => $RUTFir,
                        'FEC_USRCREA' => "SYSDATE",
                        'AD_ID_ADMISION' => $CITA_ADMISION
                    );
                    
                }
            }
        }
        $this->db->insert_batch($this->own . '.AP_TRESULTXPROG', $dataPreg2); //para cualquier caso 
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    function mdl_TraeDatosProgpxPaciente($nfichae, $empresa) {
        //trae ultimo formulario aplicado al paciente
        $query = $this->db->query("SELECT 
        ID_PACXPROG,
        ID_PROGRAMA,
        NUM_FICHAE,
        FECH_INGRESO,
        ORIGENSISTEMA,
        FECH_EGRESO,
        IND_ESTADOPROG,
        PROF_INGRESO,
        COD_USRCREA,
        FEC_USRCREA,
        IND_ESTADO,
        COD_EMPRESA
        FROM 
        $this->own.AP_TPACXPROGRAMA 
        WHERE 
        NUM_FICHAE = '$nfichae' AND IND_ESTADO = 1
        AND ID_PROGRAMA=16  order by ID_PACXPROG desc");
        return $query->result_array();
    }
    
    function mdl_TraeTextoDiag($cod){    
        $query = $this->db->query("SELECT
                                    COD_DIAGNO_CIE,
                                    DESCRIPCION
                                    FROM
                                    $this->own.TGCD_CIE_DIAGNOSTICOS
                                    WHERE
                                    ID=$cod");
        return $query->result_array();     
    }

    public function validaClave($clave){
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

}
