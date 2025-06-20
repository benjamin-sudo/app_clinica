<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Ssan_libro_biopsias_ii_fase_model extends CI_Model {

    var $tableSpace = "ADMIN";
    var $own = "ADMIN";
    var $ownPab = "ADMIN";
    var $ownGu = "GUADMIN";

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('session',true);
        date_default_timezone_set('America/Santiago');
    }
    
    #rechazo
    public function model_confirma_rechazo_muestras($DATA){
        $this->db->trans_start(); 
        $status = true;
        $arr_histo_ok = [];
        $txt_observacion_glob = $DATA['TXT_GLOBAL'];
        $ID_UID = $DATA['DATA_FIRMA'][0]['ID_UID'];
        $ID_ANATOMIA = $DATA['ID_ANATOMIA']; 
        $STATUS_MUESTRAS = $DATA['STATUS_MUESTRAS'];
        $row = $this->db ->select_max('ID_NUM_CARGA','max_carga')->get($this->ownPab .'.PB_LINETIME_HISTO')->row();
        $ID_CARGA_AP = ($row->max_carga ?? 0) + 1;
        if (count($DATA['ARRAY']) > 0) {
            foreach ($DATA['ARRAY'] as $i => $fila) {
                foreach ($fila as $x => $row) {
                    if (count($row["ARRAY_NMUESTRAS"]) > 0) {
                        foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus) {
                            $ID_ANATOMIA = $DATA["ID_ANATOMIA"];
                            $IND_CASETE = $mus['IND_CASETE'];
                            $ID_MUESTRA = $mus['ID_NMUESTRA'];
                            $arr_linea_tiempo = array(
                                // "ID_LINETIMEHISTO" => el ID se generará automáticamente,
                                "ID_NUM_CARGA" => $ID_CARGA_AP,
                                "ID_SOLICITUD_HISTO" => $ID_ANATOMIA,
                                "TXT_BACODE" => $mus['ID_NMUESTRA'],
                                "NUM_FASE" => 2, // EN TRASPORTE
                                "IND_CHECKED" => $mus['IN_CHECKED'],
                                "USR_CREA" => $DATA["SESSION"],
                                "FEC_CREA" => date('Y-m-d H:i:s'),
                                "IND_ESTADO" => 1,
                                "ID_UID" => $DATA["DATA_FIRMA"][0]['ID_UID'],
                                "TXT_MUESTRA" => $mus['TXT_MUESTRA'] == '' ? 'NO INFORMADO' : $mus['TXT_MUESTRA'],
                            );
                            $arr_linea_tiempo[$IND_CASETE == 1 ? "ID_CASETE" : "ID_NMUESTRA"] = $ID_MUESTRA;
                            $this->db->insert($this->ownPab . '.PB_LINETIME_HISTO', $arr_linea_tiempo);
                            // CAMBIA ESTADO DE MUESTRAS
                            $this->db->where($IND_CASETE == 1 ? 'ID_CASETE' : 'ID_NMUESTRA', $ID_MUESTRA);
                            $this->db->update($this->ownPab . '.PB_HISTO_NMUESTRAS', array(
                                "IND_ESTADO_CU" => $mus['IN_CHECKED'],
                                "ID_NUM_CARGA" => $ID_CARGA_AP,
                                "USR_AUDITA" => $DATA["SESSION"],
                                "DATE_AUDITA" => date('Y-m-d H:i:s')
                            ));
                            if (isset($mus["ARR_EVENTOS_ADVERSOS"])) {
                                foreach ($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv) {
                                    $this->db->insert($this->ownPab . '.PB_ANTECEDENTES_HISTO', array(
                                        "ID_ANTECEDENTES_HISTO" => $this->generate_unique_id($this->ownPab.'.PB_ANTECEDENTES_HISTO'), // Función para generar IDs únicos en MySQL
                                        "ID_LINETIMEHISTO" => $ID_LINETIME_HISTO,
                                        "ID_NUM_CARGA" => $ID_CARGA_AP,
                                        "ID_SOLICITUD_HISTO" => $ID_ANATOMIA,
                                        "ID_NMUESTRA" => $ID_MUESTRA,
                                        "ID_MOTIVO_DESAC" => $adv["IND_MOTIVO"],
                                        "TXT_EVENTO_OBSERVACION" => $adv["TXT_OBSERVACION"],
                                        "IND_ESTADO" => 1
                                    ));
                                }
                            }
                        }
                    }
                    array_push($arr_histo_ok, $row["NUM_HISTO"]);
                }
            }
        }
        #$this->db->where('ID_SOLICITUD_HISTO',$row["NUM_HISTO"]); 
        $arr_histo_ok = array_values(array_unique($arr_histo_ok));
        $this->db->where_in('ID_SOLICITUD_HISTO',$arr_histo_ok);
        $this->db->update($this->ownPab.'.PB_SOLICITUD_HISTO',array(
            "FEC_REVISION" => date('Y-m-d H:i:s'),
            "ID_HISTO_ESTADO" => 5,#RECHAZO  
            #"ID_HISTO_ZONA" => $ind_zona,
            "IND_ESTADO_MUESTRAS" => $row["NUM_OK_SAMPLES"],
            #"ID_NUM_CARGA" => $ID_CARGA_AP,
            "ID_UID_RECHAZA" => $ID_UID,
            "TXT_OBS_RECHAZA" => $txt_observacion_glob,
            "LAST_USR_AUDITA" => $DATA["SESSION"],
            "LAST_DATE_AUDITA" => date('Y-m-d H:i:s'),
        ));
        return [
            'STATUS' => $status,
            'HISTO_OK' => $arr_histo_ok,
            'STATUS_BD' => $this->db->trans_complete(),  
        ];
    }

    private function generate_unique_id($table) {
        $this->db->select_max('ID_ANTECEDENTES_HISTO');
        $query = $this->db->get($table);
        $row = $query->row_array();
        log_message('debug', 'DEBUG $miVariable: ' . print_r($row['ID_ANTECEDENTES_HISTO'], TRUE));
        return $row['ID_ANTECEDENTES_HISTO'] + 1;
    }

}
#LOAD
/*
if(count($DATA['ARRAY'])>0){
    foreach($DATA['ARRAY'] as $i => $fila) {
        log_message('debug', "Contenido de \$fila[$i]:\n" . print_r($fila, TRUE));
        foreach($fila as $x => $row){
            log_message('debug', "Contenido de \$row en \$fila[$i][$x]:\n" . print_r($row, TRUE));
            #NUMERO DE CARGA DE LA TIME LINE
            #$ID_CARGA_AP = $this->db->sequence($this->ownPab,'SEQ_NUM_CARGA_AP');
            #GESTION DE LAS MUESTAS Y CASET DE ANATOMIA
            if(count($row["ARRAY_NMUESTRAS"])>0){
                foreach ($row["ARRAY_NMUESTRAS"] as $i => $mus){
                    #AGREGA AL HISTORIAL DE LA MUESTRA
                    $ID_LINETIME_HISTO = $this->db->sequence($this->ownPab,'SEQ_NUM_LINETIME_HISTO');
                    $ID_ANATOMIA = $DATA["ID_ANATOMIA"];
                    $IND_CASETE = $mus['IND_CASETE'];
                    $ID_MUESTRA = $mus['ID_NMUESTRA'];
                    $arr_linea_tiempo = array(
                        "ID_LINETIMEHISTO" => $ID_LINETIME_HISTO,
                        "ID_NUM_CARGA" => $ID_CARGA_AP,
                        "ID_SOLICITUD_HISTO" => $row["NUM_HISTO"],
                        //"ID_NMUESTRA" => substr($mus['ID_NMUESTRA'],1),
                        "TXT_BACODE" => $mus['ID_NMUESTRA'],
                        "NUM_FASE" => 4,//RECHAZO
                        "IND_CHECKED" => $mus['IN_CHECKED'],
                        "USR_CREA" => $DATA["SESSION"],
                        "FEC_CREA" => 'SYSDATE',
                        "IND_ESTADO" => 1,
                        "ID_UID" =>  $ID_UID,
                        "TXT_MUESTRA" =>  $mus['TXT_MUESTRA']==''?'NO INFORMADO':$mus['TXT_MUESTRA'],
                    );
                    #IDENTIFICA SI ES MUESTA O CASETE
                    array_merge($arr_linea_tiempo,array($IND_CASETE==1?"ID_CASETE":"ID_NMUESTRA"=>$ID_MUESTRA)); 
                    $this->db->insert($this->ownPab.'.PB_LINETIME_HISTO',$arr_linea_tiempo);
                    #CAMBIA ESTADO DE MUESTRAS
                    #IDENTIFICA SI ES CASETE O MUESTRA INDIVIDUAL
                    $this->db->where($IND_CASETE==1?'ID_CASETE':'ID_NMUESTRA',$ID_MUESTRA);
                    $this->db->update($this->ownPab.'.PB_HISTO_NMUESTRAS',array(
                        "IND_ESTADO_CU" => $mus['IN_CHECKED'],
                        "ID_NUM_CARGA" => $ID_CARGA_AP,
                        "USR_AUDITA" => $DATA["SESSION"],
                        "DATE_AUDITA" => 'SYSDATE',
                    ));
                    #var_dump($row["NUM_HISTO"]);
                    #ADD EVENTOS ADVERSOS
                    if(isset($mus["ARR_EVENTOS_ADVERSOS"])){
                        foreach($mus["ARR_EVENTOS_ADVERSOS"] as $i => $adv){
                            $this->db->insert($this->ownPab.'.PB_ANTECEDENTES_HISTO',array(
                                "ID_ANTECEDENTES_HISTO" => $this->db->sequence($this->own,'SEQ_NUM_ANTECEDENTE_HISTO'),
                                "ID_SOLICITUD_HISTO" => $row["NUM_HISTO"],
                                "ID_LINETIMEHISTO" => $ID_LINETIME_HISTO,
                                "ID_NUM_CARGA" => $ID_CARGA_AP,
                                "ID_NMUESTRA" => $ID_MUESTRA,
                                "ID_MOTIVO_DESAC" => $adv["IND_MOTIVO"],
                                "TXT_EVENTO_OBSERVACION" => $adv["TXT_OBSERVACION"],
                                "IND_ESTADO" => 1,
                            ));
                        }
                    }
                    #END
                    #ADD ARRAY MUESTRAS
                }
            }
            #CONSULTA SI ESTA EN PABELLON
            #$result = $this->db->query("SELECT P.IND_TIPO_BIOPSIA FROM PABELLON.PB_SOLICITUD_HISTO P WHERE P.ID_SOLICITUD_HISTO IN (".$row['NUM_HISTO'].")")->result_array();
            #$ind_zona = $result[0]['IND_TIPO_BIOPSIA']=='6'?'4':'0';
            #NUMEROS DE ANATOMIA RESUELTOS
            array_push($arr_histo_ok,$row["NUM_HISTO"]);
            #MAIN - RECHAZO 
        }
    }
}
*/

