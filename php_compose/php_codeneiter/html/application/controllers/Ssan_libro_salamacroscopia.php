<?php

class Ssan_libro_salamacroscopia extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->get_sala = 'salamacroscopia';
        $this->txt_titulo = 'MACROSC&Oacute;PIA';
        $this->load->model("ssan_libro_etapaanalitica_model");
        $this->load->model("ssan_libro_biopsias_usuarioext_model");
        #$this->load->model("Ssan_libro_salamacroscopia_model");
    }
    
    public function index(){
        $this->output->set_template("blank");
        $arr_ids_anatomia = '';
        $arr_estados_filtro = '0';
        $var_fecha_inicio = date("d-m-Y");
        $var_fecha_final = date("d-m-Y");
        if(isset($_COOKIE['target']))   {
            $tipo_busqueda              =   $_COOKIE['target'];
            if($tipo_busqueda           === '#_panel_por_fecha'){
                $arr_estados_filtro     =   isset($_COOKIE['data_filtro_fechas_estados'])?$_COOKIE['data_filtro_fechas_estados']:'0';
                if(isset($_COOKIE['data'])){
                    //var_dump(1);
                    $conf_cookie        =   json_decode($this->input->cookie('data',false));
                    $var_fecha_inicio   =   $conf_cookie->fecha_inicio;
                    $var_fecha_final    =   strtotime($conf_cookie->fecha_final)>strtotime($conf_cookie->fecha_inicio)?$conf_cookie->fecha_final:$conf_cookie->fecha_inicio;
                } else {
                    //var_dump(2);
                    $var_fecha_inicio   =   date("d-m-Y");
                    $var_fecha_final    =   date("d-m-Y");
                }
            } else  if($tipo_busqueda   === '#_panel_por_gestion'){
                #$arr_ids_anatomia      =   isset($_COOKIE['id_anatomia'])?$_COOKIE['id_anatomia']:'';
                $arr_ids_anatomia       =   '';
                #elimina cokkie 
                #unset($_COOKIE['id_anatomia']); 
                #setcookie('id_anatomia',null,-1,'/'); 
            } else  if($tipo_busqueda   === '#_busqueda_xpersona'){
                $arr_ids_anatomia       =   [];
            } else  if($tipo_busqueda   === '#_busqueda_bacode'){
                $arr_ids_anatomia       =   [];
            }
        } else {
           
        }
        
        #target por defecto
        /*
        $tipo_busqueda                  =   '#_panel_por_fecha';
        $arr_ids_anatomia               =   [];
        $var_fecha_inicio               =   date("d-m-Y");
        $var_fecha_final                =   date("d-m-Y");
        */
        #LOAD_ETAPA_ANALITICA
        $return_data                    =   $this->ssan_libro_etapaanalitica_model->load_etapa_analiticaap_paginado(array(
            "cod_empresa"               =>  $this->session->userdata("COD_ESTAB"),
            "usr_session"               =>  explode("-",$this->session->userdata("USERNAME"))[0],
            "ind_opcion"                =>  $tipo_busqueda,
            "ind_first"                 =>  1,
            "data_inicio"               =>  $var_fecha_inicio,
            "data_final"                =>  $var_fecha_final,
            "num_fase"                  =>  4,
            "ind_template"              =>  "ssan_libro_etapaanalitica",
            "arr_ids_anatomia"          =>  $arr_ids_anatomia,
            "get_sala"                  =>  $this->get_sala,
            "txt_titulo"                =>  $this->txt_titulo,
            "ind_filtros_ap"            =>  $arr_estados_filtro,
            "ind_order_by"              =>  "0",
            "v_page_num"                =>  1,      
            "v_page_size"               =>  10,     
        ));
        #API VOZ
        $this->load->js("assets/ssan_libro_etapaanalitica/js/apivoz_multiple.js");
        #ARC LOCALES
        $this->load->css("assets/ssan_libro_etapaanalitica/css/styles.css");
        $this->load->js("assets/ssan_libro_etapaanalitica/js/javascript.js");
        #WEB SOCKET
        #$this->load->js("assets/themes/wsocket_io/2_3_0/socket.io.dev.js");
        #$this->load->js("assets/ssan_libro_biopsias_listaexterno1/js/ws_anatomiap_envio_a_recepcion.js");
        #AUTOSIZE BETA
        $this->load->js("assets/ssan_libro_etapaanalitica/js/autosize.js");
        #HTML OUT
        $this->load->view("ssan_libro_etapaanalitica/ssan_libro_etapaanalitica_view",$return_data);
    }

}
?>