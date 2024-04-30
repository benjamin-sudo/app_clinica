<?php

class Ssan_libro_biopsias_ii_fase extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('pdf');
        $this->load->library('session');
        $this->load->model("Ssan_libro_biopsias_ii_fase_model");
        $this->load->model("Ssan_libro_biopsias_usuarioext_model");
        $this->load->model("Ssan_libro_biopsias_listaexterno1_model");
        #$this->load->model("ssan_pre_gestionarprestador_model");
    }

    #load
    public function index_old(){
        $this->output->set_template('blank');
        //$this->load->js("assets/ssan_libro_biopsias_ii_fase/js/javascript.js");
        //$this->load->css("assets/ssan_libro_biopsias_ii_fase/css/styles.css");
        $this->load->js("assets/ssan_libro_biopsias_i_fase/js/javascript.js");
        $this->load->css("assets/ssan_libro_biopsias_i_fase/css/styles.css");
        #GESTOR ANATOMIA PATOLOGICA 
        $this->load->css("assets/ssan_libro_biopsias_listagespab/css/styles.css");
        $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/anatomia_patologica.js");
        #WEBSOCKET
        #$this->load->js("assets/themes/wsocket_io/2_3_0/socket.io.dev.js");
        #$this->load->js("assets/ssan_libro_biopsias_listaexterno1/js/ws_anatomiap_envio_a_recepcion.js");
        #VISTA MAIN ANATOMIA PATOLOGICA
        $origen_sol                         =   0;//LISTADO DE ORIGEN DE SOLICITUDES                                            -   DEFAULT 0   - ALL 
        $pto_entrega                        =   0;//LISTADO DE ORIGEN PUNTOS DE ENTREGA DESCRITA EN LA SOLICITUD DE ANATOMIA    -   DEFAULT 0   - ALL
        #COOKIE TIEMPO BUSQUEDA
        if(!isset($_COOKIE['date_inicio']) && !isset($_COOKIE['date_final'])){
            #DATE DEFAULT
            $date_inicio                    =   date("d-m-Y");
            $date_final                     =   date("d-m-Y");
            #DATE INICIO TIEMPO
            $this->input->set_cookie(array(
                'name'                      =>  'date_inicio',
                'value'                     =>  $date_inicio,
                'expire'                    =>  86500,
                'secure'                    =>  false
            ));
            #DATE INICIO TIEMPO
            $this->input->set_cookie(array(
                'name'                      =>  'date_final',
                'value'                     =>  $date_final,
                'expire'                    =>  86500,
                'secure'                    =>  false
            ));
            #var_dump("SIN COOKIE           =>  ",$_COOKIE['date_inicio']);
            #var_dump("SIN COOKIE           =>  ",$_COOKIE['date_final']);
        } else {
            #DATE COOKIE
            $date_inicio                    =   $_COOKIE['date_inicio'];
            $date_final                     =   $_COOKIE['date_final'];
            #var_dump("CON COOKIE           =>  " ,$date_inicio);
            #var_dump("CON COOKIE           =>  " ,$date_final);
        }
        #LOAD
        $return_data                        =   $this->Ssan_libro_biopsias_usuarioext_model->carga_lista_rce_externo_ap(array(
            "data_inicio"                   =>  $date_inicio,
            "data_final"                    =>  $date_final,
            "usr_session"                   =>  explode("-",$this->session->userdata("USERNAME"))[0],
            "ind_opcion"                    =>  0,
            "ind_first"                     =>  1,
            "origen_sol"                    =>  $origen_sol,
            "pto_entrega"                   =>  $pto_entrega,
            "COD_EMPRESA"                   =>  $this->session->userdata("COD_ESTAB"),
            "num_fase"                      =>  2,
            "ind_template"                  =>  "ssan_libro_biopsias_ii_fase",
        ));
        $this->load->view("ssan_libro_biopsias_ii_fase/ssan_libro_biopsias_ii_fase_view",$return_data);
    }

    public function index(){
        $this->output->set_template('blank');
        $return_data = [];

        $origen_sol                         =   0;//LISTADO DE ORIGEN DE SOLICITUDES                                            -   DEFAULT 0   - ALL 
        $pto_entrega                        =   0;//LISTADO DE ORIGEN PUNTOS DE ENTREGA DESCRITA EN LA SOLICITUD DE ANATOMIA    -   DEFAULT 0   - ALL
        #COOKIE TIEMPO BUSQUEDA
        if(!isset($_COOKIE['date_inicio']) && !isset($_COOKIE['date_final'])){
            #DATE DEFAULT
            $date_inicio                    =   date("d-m-Y");
            $date_final                     =   date("d-m-Y");
            #DATE INICIO TIEMPO
            $this->input->set_cookie(array(
                'name'                      =>  'date_inicio',
                'value'                     =>  $date_inicio,
                'expire'                    =>  86500,
                'secure'                    =>  false
            ));
            #DATE INICIO TIEMPO
            $this->input->set_cookie(array(
                'name'                      =>  'date_final',
                'value'                     =>  $date_final,
                'expire'                    =>  86500,
                'secure'                    =>  false
            ));
            #var_dump("SIN COOKIE           =>  ",$_COOKIE['date_inicio']);
            #var_dump("SIN COOKIE           =>  ",$_COOKIE['date_final']);
        } else {
            #DATE COOKIE
            $date_inicio                    =   $_COOKIE['date_inicio'];
            $date_final                     =   $_COOKIE['date_final'];
            #var_dump("CON COOKIE           =>  " ,$date_inicio);
            #var_dump("CON COOKIE           =>  " ,$date_final);
        }
        #LOAD
        $return_data                        =   $this->Ssan_libro_biopsias_usuarioext_model->carga_lista_rce_externo_ap(array(
            "data_inicio"                   =>  $date_inicio,
            "data_final"                    =>  $date_final,
            "usr_session"                   =>  explode("-",$this->session->userdata("USERNAME"))[0],
            "ind_opcion"                    =>  0,
            "ind_first"                     =>  1,
            "origen_sol"                    =>  $origen_sol,
            "pto_entrega"                   =>  $pto_entrega,
            "COD_EMPRESA"                   =>  $this->session->userdata("COD_ESTAB"),
            "num_fase"                      =>  2,
            "ind_template"                  =>  "ssan_libro_biopsias_ii_fase",
        ));
        $this->load->css("assets/Ssan_libro_biopsias_ii_fase/css/styles.css");
        $this->load->js("assets/Ssan_libro_biopsias_ii_fase/js/javascript.js");
        $this->load->js("assets/ssan_libro_biopsias_usuarioext/js/anatomia_patologica.js");
        $this->load->view("ssan_libro_biopsias_ii_fase/ssan_libro_biopsias_ii_fase_view",$return_data);
    }

    #PERMITE BUSCAR PRESTADOR
    public function buscar() {
        $rut        =   $this->input->post('rutPac');
        $rutm       =   explode(".", $rut);
        $rutUs      =   $rutm[0] . '' . $rutm[1] . '' . $rutm[2];
        $rutsin     =   explode("-", $rutUs);
        $rutfin     =   $rutsin[0];
        $retor      =   $this->ssan_pre_gestionarprestador_model->buscar($rutfin);
        $html       =   "<script>console.log('hello, i love');</script>";
        //var_dump($retor);
        if ($retor) {
            $html   =   '<script>setTimeout(function(){CARGAPROF("' . $retor[0]['COD_TPROFE'] . '");},200)</script>';
            $html   .=  '<script>
                            $("#nombres").val("' . $retor[0]['NOM_NOMBRE'] . '");
                            $("#appat").val("' . $retor[0]['NOM_APEPAT'] . '");
                            $("#apmat").val("' . $retor[0]['NOM_APEMAT'] . '");
                            $("#email").val("' . $retor[0]['EMAILMED'] . '");
                            $("#telefono").val("' . $retor[0]['NUM_TELEFOMED'] . '");
                            $("#tprof").val("' . $retor[0]['IND_TIPOATENCION'] . '");' . 'setTimeout(function(){
                            $("#prof").val("' . $retor[0]['COD_TPROFE'] . '");},500)</script>';
        } else {
            $html   = "<script></script>";
        }
        
        $html       .= '<script>$("#loadFade").modal("hide");$(".main-panel").perfectScrollbar("destroy");document.getElementById("modal_info_html").style.overflowY = "auto";</script>';
        $this->output->set_output($html);
    }

    public function consultaprofxestab(){
        $var        =   "";
        $rut        =   $this->input->post('rutPac');
        $codemp     =   $this->input->post('codemp');
        $rutm       =   explode(".", $rut);
        $rutUs      =   $rutm[0] . '' . $rutm[1] . '' . $rutm[2];
        $rutsin     =   explode("-", $rutUs);
        $rutfin     =   $rutsin[0];
        $retor      =   $this->ssan_pre_gestionarprestador_model->consultaprofxestab($rutfin, $codemp);
        if ($retor) {
        } else {
            $var    =   '<div class="alert alert-warning">';
            $var    .=  '<button type="button" aria-hidden="true" class="close">×</button>';
            $var    .=  '<span><b> Alerta - </b> El profesional no se encuentra registrado en el establecimiento, favor grabar al profesional.</span></div>';
        }
        $var        .= '<script> $("#btnSuper").hide();</script>';
        $this->output->set_output($var);
    }

    public function cargatipo(){
        if (!$this->input->is_ajax_request()) { show_404(); }
        $html_get =  $this->ssan_libro_biopsias_usuarioext_model->get_html_anatomia();
        $this->output->set_output($html_get);
    }

    public function cargaprof()  {
        $id             =   $this->input->post('tprof');
        $retor          =   $this->ssan_pre_gestionarprestador_model->cargaprof($id);
        $var            =   '<option>SELECCIONE UNA PROFESI&Oacute;N</option>';
        if ($retor) {
            foreach ($retor as $row) {
                $var    .=  '<option value="' . $row['COD_TPROFE'] . '"> ' . $row['NOM_TPROFE'] . '</option>';
            }
            if (count($retor) == 1) {
                $var    .=  '<script>$("select#prof").prop("selectedIndex", 1);</script>';
            }
        }
        $this->output->set_output($var);
    }

    public function PrestadorController(){
        if(!$this->input->is_ajax_request()) {  show_404();  }
        $rut            =   $this->input->post('rut');
        $rutm           =   explode(".", $rut);
        $rutUs          =   $rutm[0] . '' . $rutm[1] . '' . $rutm[2];
        $rutsin         =   explode("-", $rutUs);
        $rutfin         =   $rutsin[0];
        $digrut         =   $rutsin[1];
        $nombres        =   $this->input->post('nombres');
        $appat          =   $this->input->post('appat');
        $apmat          =   $this->input->post('apmat');
        $tprof          =   $this->input->post('tprof');
        $prof           =   $this->input->post('prof');
        $email          =   $this->input->post('email');
        $telefono       =   $this->input->post('telefono');
        $clave          =   $this->input->post("clave");
        $iniciales      =   substr($nombres,0,1);
        $iniciales      .=  substr($appat,0,1);
        $iniciales      .=  substr($apmat,0,1);
        $codemp         =   $this->input->post('codemp');
        $valida         =   $this->ssan_pre_gestionarprestador_model->validaClave($clave);
        /*
        if (empty($token)) {
        } else {
            $valida = $this->ssan_pre_gestionarprestador_model->validaClaveTypo($clave);
        }
        */
        if ($valida) {
            $rutClave           =   $valida[0]['USERNAME'];
            $rutmClave          =   explode("-", $rutClave);
            $rutUsClave         =   $rutmClave[0];
            //INSERTO
            $inicial            =   $iniciales;
            $consultainicial    =   $this->ssan_pre_gestionarprestador_model->consultaIniciales(strtoupper($iniciales));
            if ($consultainicial) {
                $numero = $consultainicial[0]['NUMERO'];
                if ($numero == 0) {
                    $inicial = $iniciales;
                } elseif ($numero > 9) {

                    $inicial    =   substr($iniciales, 0, -1);
                    $inicial    .=  $numero + 1;
                } else {
                    $inicial    =   $iniciales;
                    $inicial    .=  $numero + 1;
                }
            }
            $ingresoPrestador = $this->ssan_pre_gestionarprestador_model->guardarPrestador($rutfin, $digrut, $nombres, $appat, $apmat, $tprof, $prof, $email, $telefono, $inicial, $rutUsClave, $codemp);
            if ($ingresoPrestador) {
                //$html = '<script>showNotification("bottom", "right", "Prestador ingresado con exito.", 2, "fa fa-check");</script>';
                $html = '<script>swal("CONFIRMACI&Oacute;N","PROCESO REALIZADO CON &Eacute;XITO", "success");</script>';
                $html .= '<script>limpiar();</script>';
                $html .= '<script>$("#respuesta1").hide();</script>';
                $html .= '<script>$("#modal_info_html").modal("hide");</script>';
            } else {
                $html = '<script>swal("Error","Error al Grabar", "error");</script>';
            }
            $this->output->set_output($html);
        } else {
            $html = '<script>showNotification("top", "right", "Error - Firma simple incorrecta.", 4, "fa fa-times");</script>';
            $this->output->set_output($html);
        }
    }

#############################################################################
public function motivos_rechazos(){
    $data                               =   "<option value=''>Seleccione...</option>";
    $mu_estras                          =   $this->ssan_libro_biopsias_ii_fase_model->CargaMOTIVO_RECHAZO();
    if(count($mu_estras)>0){
        foreach ($mu_estras as &$row_ms) {
            $ID_MOTIVO_DESAC            =   $row_ms['ID_MOTIVO_DESAC'];
            $MOTIVO_TXT                 =   $row_ms['MOTIVO_TXT'];
            $data                      .=   "<option value='$ID_MOTIVO_DESAC'>$MOTIVO_TXT</option>";       
        }
    }
    return $data;
}

public function Tipomuestra_txt($id) {//TANTO PARA MUESTRAS COMO PARA SOLICITUD COMPLETA
    //Recupera variables pasadas por Ajax
    $data='--';
    if($id==1){  $data='MUESTRA ANATOMIA';}
    if($id==2){  $data='MUESTRA CITOLOGIA';}
    return $data;
}

public function Estado__txt($id) {//TANTO PARA MUESTRAS COMO PARA SOLICITUD COMPLETA
    //Recupera variables pasadas por Ajax
    $data='EN SOLICITUD.';
    if($id==1){     $data   =   'EN SOLICITUD';}
    if($id==2){     $data   =   'RECEPCIONADA HORARIO NO HABIL';}
    if($id==3){     $data   =   '<span style="color:red">NO RECEPCIONADA HORARIO NO HABIL</span>';}
    if($id==4){     $data   =   'RECEPCIONADA POR PERSONAL QUE TRASLADA (EN TRASLADO)';}
    if($id==5){     $data   =   '<span style="color:red">NO RECEPCIONADA POR PERSONAL QUE TRASLADA</span>';}
    if($id==6){     $data   =   'RECEPCIONADA EN ANATOMIA PATOLOGICA';}
    if($id==7){     $data   =   '<span style="color:red">NO RECEPCIONADA EN ANATOMIA PATOLOGICA</span>';}  
    if($id==8){     $data   =   'ROTULADO';}
    if($id==9){     $data   =   '<span style="color:red">NO ROTULADA???????</span>';}
    if($id==10){    $data   =   'RECEPCIONADA HORARIO HABIL';}
    if($id==11){    $data   =   '<span style="color:red">NO RECEPCIONADA HORARIO HABIL</span>';}
    if($id==100){   $data   =   '<span style="color: #76b706;">REACTIVADA</span>';}
    return $data;
}

public function MOTIVO_RECH_txt($id) {
    //TANTO PARA MUESTRAS COMO PARA SOLICITUD COMPLETA
    //Recupera variables pasadas por Ajax
    $data           =   '';
    $mu_estras      =   $this->ssan_libro_biopsias_ii_fase_model->CargaMOTIVO_RECHAZO($id);
    if($mu_estras){
        foreach ($mu_estras as &$row_ms) {     
            $MOTIVO_TXT     =   $row_ms['MOTIVO_TXT'];
            $data           .=  $MOTIVO_TXT;       
        }
    }
    return $data;
}

public function trae_muestras_x_solicitud() {
    //fondos transferidos   
    if(!$this->input->is_ajax_request()) {  show_404();   }  
    $ID_SOLICITUD_HISTO     =   $this->input->post('comenzar_nsolicitud_pistola');
    $accion                 =   $this->input->post('Sl_accion_a_realizar');
    $ID_MUESTRA             =   $this->input->post('comenzar_nmuestra_pistola');
    $html                   =   "";   
    $ctts                   =   0; 
    $mu_estras              =   $this->ssan_libro_biopsias_ii_fase_model->Carga_ENCAB_SOLICITUD($ID_SOLICITUD_HISTO);
    
    if($mu_estras){
        foreach ($mu_estras as &$row_ms) {
            $RUT_PACIENTE           =   $row_ms['RUT_PACIENTE'];
            $NOM_PACIENTE           =   $row_ms['NOM_PACIENTE'];
            $ID_HISTO_ESTADO        =   $row_ms['ID_HISTO_ESTADO'];
            $ID_TABLA               =   $row_ms['ID_TABLA'];
            $ID_HISTO_ESTADO_txt    =   $this->Estado__txt($ID_HISTO_ESTADO);
            $html.="<table class='table'>";
            $html.="<tr>
                        <td style='width: 140px;'><b>N&deg; SOLICITUD</b></td>
                        <td>$ID_SOLICITUD_HISTO
                            <button type='button' class='btn btn-danger btn-fill btn-xs' id='pdf_pase' onclick='GET_PDF_ANATOMIA_PANEL($ID_SOLICITUD_HISTO)'>
                                <i class='fa fa-file-pdf-o' aria-hidden='true'></i>
                            </button>
                        </td>
                        <td></td>
                    </tr>";
            //$html.="<tr>
            //<td style='    width: 140px;'><b>ESTADO </b></td><td colspan='2'>$ID_HISTO_ESTADO_txt</td>
            //</tr>";
            $html.="<tr>
            <td><b>PACIENTE</b></td><td  colspan='2'>$RUT_PACIENTE $NOM_PACIENTE</td>
            </tr>";
            $html.="<tr>
            <td colspan='3' style='text-align:center'><b>DETALLE DE MUESTRAS</b></td>
            </tr>";
            $html.="</table>";
        }
    }

            $html.="<table class='table'>";
            $html.="<tr style='background-color: #23ccef;' >  
            <td><b>N&deg; MUESTRA</b></td> 
            <td><b>TIPO MUESTRA</b></td>
            <td><b>NOMBRE MUESTRA</b></td> 
            <td><b>ESTADO ACTUAL</b></td>";
            if($accion!=100){//MODO CONSULTA O PARA SUBIR IMAGENES ETC         
            $html.=" <td><b>OBSERVACION</b></td> <td><b>MOTIVO PARA DESACTIVAR</b></td>   <td><b>OPCION</b></td>";
            }

        $html.="<td><b>INFO</b></td></tr>";

        $mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_Listadomuestras_originales($ID_SOLICITUD_HISTO);
            if($mu_estras){
                foreach ($mu_estras as &$row_ms) {
                    $TXT_MUESTRA            =   $row_ms['TXT_MUESTRA'];
                    $NUM_FICHAE             =   $row_ms['NUM_FICHAE'];
                    $RUT_PACIENTE           =   $row_ms['RUT_PACIENTE'];
                    $NOM_PACIENTE           =   $row_ms['NOM_PACIENTE'];
                    $IDMUESTRA              =   $row_ms['ID_NMUESTRA'];
                    $IND_TIPOMUESTRA        =   $row_ms['IND_TIPOMUESTRA'];
                    $IND_TIPOMUESTRA_TXT    =   $this->Tipomuestra_txt($IND_TIPOMUESTRA);
                    $MOTIVO_RECHAZO         =   $row_ms['MOTIVO_RECHAZO'];
            if($MOTIVO_RECHAZO!=''){
              $MOTIVO_RECHAZO_TXT= $this->MOTIVO_RECH_txt($MOTIVO_RECHAZO);
            }else{
              $MOTIVO_RECHAZO_TXT='';
            }
            $IND_ESTADO_REG         =   $row_ms['IND_ESTADO_REG'];
            $IND_ESTADO_REG_TXT     =   $this->Estado__txt($IND_ESTADO_REG);





    $SOLICITUD_REALIZADA= $row_ms['SOLICITUD_REALIZADA'];//trae id del rechazooo
    $BTN_SOLICITUD=" 
    <textarea id='text_obs_".$IDMUESTRA."' class='form-control' ></textarea></td>
    <td>
    <a class='btn btn-success btn-fill btn-sm' style='padding: 1px;margin-top: 2px;' id='btn_solicita_activ_$IDMUESTRA' href='javascript:Solicitar_activacion($IDMUESTRA)' data-toggle='tooltip' data-placement='top' title='' data-original-title=''>
    SOLICITAR ACTIVACIÓN</a>

    <a class='btn btn-default btn-fill btn-sm' style='padding: 1px;margin-top: 2px;display:none' id='OKbtn_solicita_activ_$IDMUESTRA' href='#' data-toggle='tooltip' data-placement='top' title='' data-original-title=''>
    SOLICITUD EN PROCESO???</a>
    ";


    if($SOLICITUD_REALIZADA!='' ){
    $SOLICITUD_REALIZADA_txt='';
    $NR_OBS_SOLICI_ACTIV='';
    $NR_FEC_ING_CORRECCION='';

    $mu_estras_solicit = $this->ssan_libro_biopsias_ii_fase_model->consulta_estadosolicitudreinteg($SOLICITUD_REALIZADA);
    if($mu_estras_solicit){
       foreach ($mu_estras_solicit as &$row_mssolici) {
         $NR_OBS_SOLICI_ACTIV= $row_mssolici['NR_OBS_SOLICI_ACTIV'];
         $NR_FEC_ING_CORRECCION= $row_mssolici['NR_FEC_ING_CORRECCION'];
     }
    }

    //debo consultar si esta soiicitud cuenta con fecha de reingreso
    if($NR_FEC_ING_CORRECCION==''){
      $BTN_SOLICITUD=" 
      <textarea id='text_obs_".$IDMUESTRA."' class='form-control' ></textarea></td>
      <td>
        <a class='btn btn-success btn-fill btn-sm' style='padding: 1px;margin-top: 2px;' id='btn_solicita_activ_$IDMUESTRA' href='javascript:Solicitar_activacion($IDMUESTRA)' data-toggle='tooltip' data-placement='top' title='' data-original-title=''>
      SOLICITAR ACTIVACIÓN</a>

      <a class='btn btn-default btn-fill btn-sm' style='padding: 1px;margin-top: 2px;display:none' id='OKbtn_solicita_activ_$IDMUESTRA' href='#' data-toggle='tooltip' data-placement='top' title='' data-original-title=''>
      SOLICITUD EN PROCESO</a>
      ";

      /*
      $BTN_SOLICITUD=" 
      <textarea id='text_obs_".$IDMUESTRA."' class='form-control' disabled >$NR_FEC_ING_CORRECCION</textarea></td>
      <td>
      <a class='btn btn-default btn-fill btn-sm' style='padding: 1px;margin-top: 2px;' id='OKbtn_solicita_activ_$IDMUESTRA' href='#' data-toggle='tooltip' data-placement='top' title='' data-original-title=''>
      SOLICITUD EN PROCESO</a>
      ";*/

    }else{//teniauna solicitud pero ya se reintegro

      //se supone ke $BTN_SOLICITUD keda nulo y mas abajo no lo concidero.. ya que la muestra no se encuentra en estado 7(no recepcionada)
      $BTN_SOLICITUD=" 
      <textarea id='text_obs_".$IDMUESTRA."' class='form-control' disabled >$NR_FEC_ING_CORRECCION</textarea></td>
      <td>
      <a class='btn btn-default btn-fill btn-sm' style='padding: 1px;margin-top: 2px;' id='OKbtn_solicita_activ_$IDMUESTRA' href='#' data-toggle='tooltip' data-placement='top' title='' data-original-title=''>
      SOLICITUD EN PROCESO</a>
      ";

    }
}

/*
    fase1
    if($id==1){  $data='EN SOLICITUD';}
    if($id==8){  $data='ROTULADO';}
    if($id==9){  $data='<span style="color:red">NO ROTULADA???????</span>';}
    if($id==10){  $data='RECEPCIONADA HORARIO HABIL';}
    if($id==11){  $data='<span style="color:red">NO RECEPCIONADA HORARIO HABIL</span>';}
    if($id==2){  $data='RECEPCIONADA HORARIO NO HABIL';}
    if($id==3){  $data='<span style="color:red">NO RECEPCIONADA HORARIO NO HABIL</span>';}
    if($id==4){  $data='RECEPCIONADA POR PERSONAL QUE TRASLADA (EN TRASLADO)';}
    if($id==5){  $data='<span style="color:red">NO RECEPCIONADA POR PERSONAL QUE TRASLADA</span>';}
    fase2
    if($id==6){  $data='RECEPCIONADA EN ANATOMIA PATOLOGICA';}
    if($id==7){  $data='<span style="color:red">NO RECEPCIONADA EN ANATOMIA PATOLOGICA</span>';}  
*/
     
$bloqueado='';

$titulo_tr='';
if($IND_ESTADO_REG==3 || $IND_ESTADO_REG==5  || $IND_ESTADO_REG==11   || $IND_ESTADO_REG==7   || $IND_ESTADO_REG==9){//DEBO IR AGREGANDO TODOS LOS NEGATIVOS
    //es por que las rechazadas no deben contarse en el foreach
    $titulo_tr='NO';
    $bloqueado='bloqueado';
}

$verde='';
$plomo='rojo';
if($ID_MUESTRA==$IDMUESTRA){//si el idmuestra que marque con pistola..es igual al id muestra ke estoy mistrandoi en el detalle entonmces lo dejo marcado
  $verde='success verde'; $plomo='';
}

$html.="<tr id='".$titulo_tr."tr_data_de_muestra_".$ID_SOLICITUD_HISTO."_".$IDMUESTRA."' class='trs_muestras ".$plomo." ".$verde." '
    data-id_solicitud='$ID_SOLICITUD_HISTO'
    data-id_muestra='$IDMUESTRA'
    data-num_fichae='$NUM_FICHAE'
    data-estado_actual='$IND_ESTADO_REG'

    data-rutpac='$RUT_PACIENTE'
    data-nompac='$NOM_PACIENTE'
    data-tipomuestra='$IND_TIPOMUESTRA_TXT'

  >";


     $html.="<td>$IDMUESTRA</td>";
     $html.="<td>$IND_TIPOMUESTRA_TXT</td>";
     $html.="<td>$TXT_MUESTRA</td>";
     $html.="<td>$IND_ESTADO_REG_TXT ($IND_ESTADO_REG)<br><span style='color:red;'>$MOTIVO_RECHAZO_TXT</span></td>";

     if($accion==100){//MODO CONSULTA O PARA SUBIR IMAGENES ETC         
      //  $html.="<td></td><td></td>";
       }else{
           if($bloqueado!=''){
        


            $html.="<td>";               
            $html.=$BTN_SOLICITUD   ;
            $html.="</td>";
            $html.="<td></td>";



           }else{//todo bien
            $html.="<td>";
            $html.=" <textarea id='text_obs_".$IDMUESTRA."' class='form-control' ></textarea>";
            $html.="</td>";
            $html.="<td>";


            $BLOC_MOTIVO='';
            if($ID_MUESTRA==$IDMUESTRA){//si el idmuestra que marque con pistola..es igual al id muestra ke estoy mistrandoi en el detalle entonmces lo dejo marcado
              $BLOC_MOTIVO='disabled';

            }

            $html.=" <select id='sl_mot_rech_".$IDMUESTRA."' class='form-control' $BLOC_MOTIVO >";
            $html.=$this->motivos_rechazos();              
            $html."</select>";
            $html.="</td>";
            $marcar='';
            if($ID_MUESTRA==$IDMUESTRA){//si el idmuestra que marque con pistola..es igual al id muestra ke estoy mistrandoi en el detalle entonmces lo dejo marcado
              $marcar='checked';
            }
            $html.='<td style="    text-align: center;"  ><input '.$marcar.' type="checkbox"  id="ch_muestra_'.$ID_SOLICITUD_HISTO.'_'.$IDMUESTRA.'" onclick="marcar_check('.$ID_SOLICITUD_HISTO.','.$IDMUESTRA.')" class="check_masi" data-toggle="tooltip" data-placement="top" title="" data-original-title=""  >';
            $html.='<label  for="ch_muestra_'.$ID_SOLICITUD_HISTO.'_'.$IDMUESTRA.'"><span></span></label></td>';
           }

       }
   

///VE SI SUBIO IMAGEN y ver hisotrial
$html.="<td>";
$html.="<a class='btn btn-default btn-fill btn-sm' style='width: 98px;padding: 1px;margin-top: 2px;' href='javascript:Ver_historial_muestra(".$ID_SOLICITUD_HISTO.",".$IDMUESTRA.")' data-toggle='tooltip' data-placement='top' title='' data-original-title='trae información.'>
<i class='fa fa-search' aria-hidden='true'></i> INFO</a>";

//_______________

     $html.="</td>";
     $html.="</tr>";   

}} 

/*
if($accion!=100){//MODO CONSULTA O PARA SUBIR IMAGENES ETcc   
$html.="<tr id='tr_btn_guardar_1'>";      
$html.=' <td colspan="7" >
<center><a class="btn btn-success btn-fill btn-sm" style="width: 300px;padding: 1px;margin-top: 2px;" href="javascript:Guardar_proceso('.$ID_SOLICITUD_HISTO.',0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="">
<i class="fa fa-save" aria-hidden="true"></i> FINALIZAR PROCESO</a></center>
</td>';
$html.="</tr>";  

$html.="<tr id='cls_preg_2' style='display:none'>";      
$html.=' <td colspan="7" style="text-align:center">
<h3>Estimado usuario veo que tiene muestras sin marcar. Que desea hacer?</h3>
<div style="margin-bottom:20px;"><br>-Al indicar la opción (1) el sistema procesara las muestras marcadas y las no marcadas las dejara rechazadas.
<br>-Al indicar la opción (2) el sistema indicara la solicitud como rechazada.
<center>
</div>
<a class="btn btn-success btn-fill btn-sm" style="width: 300px;padding: 1px;margin-top: 2px;" href="javascript:Guardar_proceso('.$ID_SOLICITUD_HISTO.',1)" data-toggle="tooltip" data-placement="top" title="" data-original-title="">
<i class="fa fa-check" aria-hidden="true"></i>(1) PROCESAR SOLICITUD</a>
<a class="btn btn-danger btn-fill btn-sm" style="width: 300px;padding: 1px;margin-top: 2px;" href="javascript:Guardar_proceso('.$ID_SOLICITUD_HISTO.',2)" data-toggle="tooltip" data-placement="top" title="" data-original-title="">
<i class="fa fa-times" aria-hidden="true"></i>(2) RECHAZAR SOLICITUD COMPLETA</a>
</center>
</td>';
$html.="</tr>";  
  }
*/

$html.="</table>";

$this->output->set_output($html);
}


public function historial_recepciones_nohabil_x_muestra() {
//fondos transferidos   
 if (!$this->input->is_ajax_request()) {
  show_404();
}
//falta consulta a base de datos.. y besta pantañlla
$html='';
$ID_SOLICITUD_HISTO = $this->input->post('ID_SOLICITUD_HISTO');
$idmuestra = $this->input->post('idmuestra');


$html.="<table class='table' border style='width:100%'>"; 
$html.="<tr style='cursor:pointer;'>";  
$html.="<td  onclick='desplega_td(1)'><i class='fa fa-play' aria-hidden='true'></i><b>DOCUMENTOS ADJUNTOS</b>";  
$html.=" <a class='btn btn-default btn-fill btn-sm' style='width: 98px;padding: 1px;margin-top: 2px;' href='javascript:Adjunta_img(".$ID_SOLICITUD_HISTO.",".$idmuestra.")' data-toggle='tooltip' data-placement='top' title='' data-original-title='Adjuntar Imagen Muestra.'>
<i class='fa fa-file-image-o' aria-hidden='true'></i> NUEVO</a>";
$html.=" </td>";  
$html.="</tr>";  
$html.="<tr>";  
$html.="<td  id='td_contenido_archivos'>";//inicio td principal1

$html.="<table class='table' border  style='width:100%'>"; 

$html.="<tr style='background-color: #beffbb;'>";  
$html.="<td><b>FECHA SUBIDA</b></td>";  
$html.="<td><b>PROFESIONAL</b></td>";  
$html.="<td><b>LINK</b></td>";  
$html.="</tr>"; 

$IMAGENES_X_MUESTRAS = $this->ssan_libro_biopsias_ii_fase_model->trae_archivos_subidos_x_muestra($idmuestra);
if($IMAGENES_X_MUESTRAS){
 foreach ($IMAGENES_X_MUESTRAS as &$row_IMG) {

  $LBD_ID_CORRDOC= $row_IMG['LBD_ID_CORRDOC'];
  $ID_SOLICITUD_HISTO= $row_IMG['ID_SOLICITUD_HISTO'];
  $ID_MUESTRA= $row_IMG['ID_MUESTRA'];
  $LBD_NOMARCHIVO= $row_IMG['LBD_NOMARCHIVO'];
  $LBD_USRCREA= $row_IMG['LBD_USRCREA'];
  $LBD_FEC_CREA= $row_IMG['LBD_FEC_CREA'];
  $LBD_IND_ESTADO= $row_IMG['LBD_IND_ESTADO'];
  $LBD_COD_EMPRESA= $row_IMG['LBD_COD_EMPRESA'];

  $PROFESIONAL= $row_IMG['PROFESIONAL'];

  $LBD_NOMARCHIVO_TXT= $row_IMG['LBD_NOMARCHIVO_TXT'];

  
  
  

  $html.="<tr >";  
  $html.="<td><b>".$LBD_FEC_CREA."</b></td>";  
  $html.="<td><b>".$PROFESIONAL."</b></td>";  
  $html.="<td><a href='#' onclick='Ver_documentos_adjuntos($ID_SOLICITUD_HISTO,$ID_MUESTRA,\"$LBD_NOMARCHIVO\")'> <i class='fa fa-eye icon-large'></i> ver archivo ".$LBD_NOMARCHIVO_TXT."</a></td>";  
  $html.="</tr>"; 
  
}} 

$html.="</table>"; 

$html.="</td>"; ///fin td principal 1
$html.="</tr>";  
$html.="<tr style='cursor:pointer;'>";  
$html.="<td onclick='desplega_td(2)'><i class='fa fa-play' aria-hidden='true'></i><b>EVENTOS ASOCIADOS A LA MUESTRA</b></td>";  
$html.="</tr>";  
$html.="<tr>";  
$html.="<td style='display:none' id='td_contenido_historial'>";//inicio td principal2



$html.="<table class='table' border  style='width:100%'>";  

$html.="<tr style='background-color: #beffbb;'>";  
$html.="<td><b>ID REGISTRO HIST</b></td>";  
$html.="<td><b>N° MUESTRA</b></td>";  
$html.="<td><b>NOMBRE MUESTRA</b></td>";  
$html.="<td><b>ESTADO</b></td>";  
$html.="<td><b>PROFESIONAL</b></td>";  
$html.="<td><b>ESTABLECIMIENTO</b></td>";  
$html.="<td><b>FECHA</b></td>";  
$html.="<td><b>OBSERVACIÓN</b></td>";  
$html.="<td><b>SOLICITUD DE ACTIVACIÓN</b></td>";  
$html.="</tr>"; 

$mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_Historial_muestra($idmuestra);
if($mu_estras){
 foreach ($mu_estras as &$row_ms) {

 

  $ID_HISTORIAL_NMUESTRA= $row_ms['ID_HISTORIAL_NMUESTRA'];
  $ID_NMUESTRA= $row_ms['ID_NMUESTRA'];
  $TXT_MUESTRA= $row_ms['TXT_MUESTRA'];    
  $ESTADO_REG= $row_ms['ESTADO_REG'];
  $PROFESIONAL= $row_ms['PROFESIONAL'];
  $FECHA_CREA= $row_ms['FECHA_CREA'];
  $NOM_ESTABL= $row_ms['NOM_ESTABL'];
  $OBS_HIST_MUESTRA= $row_ms['OBS_HIST_MUESTRA'];
  $MOTIVO_RECHAZO= $row_ms['MOTIVO_RECHAZO'];
  
if($MOTIVO_RECHAZO!=''){
$MOTIVO_RECHAZO_TXT= $this->MOTIVO_RECH_txt($MOTIVO_RECHAZO);
}else{
$MOTIVO_RECHAZO_TXT='';
}



  
  $IND_ESTADO_REG_TXT=$this->Estado__txt($ESTADO_REG);




  $NR_USR_SOLICI_ACTIV= $row_ms['NR_USR_SOLICI_ACTIV'];
  $NR_FEC_SOLICI_ACTIV= $row_ms['NR_FEC_SOLICI_ACTIV'];
  $NR_OBS_SOLICI_ACTIV= $row_ms['NR_OBS_SOLICI_ACTIV'];
  $NR_FEC_ING_CORRECCION= $row_ms['NR_FEC_ING_CORRECCION'];
  $USR_ING_CORRECCION= $row_ms['USR_ING_CORRECCION'];
$txt_activación="";
if($NR_USR_SOLICI_ACTIV!=''){//cuenta con una solicitud de activacion
$txt_activación.="<b>Fecha solicitud:</b> $NR_FEC_SOLICI_ACTIV
<br><b>Por:</b> $NR_USR_SOLICI_ACTIV
<br><b>Obs:</b> $NR_OBS_SOLICI_ACTIV
    ";
}

if($NR_FEC_ING_CORRECCION!=''){//cuenta con una integracion (activacion de la muestra)
$txt_activación.="<br><b>Fecha reintegro:</b> $NR_FEC_ING_CORRECCION
<br><b>Por:</b> $USR_ING_CORRECCION 
    ";
}



  $html.="<tr>";  
$html.="<td>$ID_HISTORIAL_NMUESTRA</td>";  
$html.="<td>$ID_NMUESTRA</td>";  
$html.="<td>$TXT_MUESTRA</td>";  
$html.="<td>$IND_ESTADO_REG_TXT<br><span style='color:red;'>$MOTIVO_RECHAZO_TXT</span></td>";  
$html.="<td>$PROFESIONAL</td>";  
$html.="<td>$NOM_ESTABL</td>";  
$html.="<td>$FECHA_CREA</td>";  
$html.="<td>$OBS_HIST_MUESTRA</td>";  
$html.="<td>$txt_activación</td>";  
$html.="</tr>"; 
  
}} 

$html.="</table>"; 

$html.="</td>"; ///fin td principal 2
$html.="</tr>"; 

$this->output->set_output($html);
}






public function Adjunta_img(){
if (!$this->input->is_ajax_request()) {
  show_404();
}    
$html='';
$rand=rand(1, 1000000);

$ID_SOLICITUD_HISTO = $this->input->post('ID_SOLICITUD_HISTO');
$idmuestra = $this->input->post('idmuestra');

$html.='<div> 
<div style="    margin-bottom: 10px;">
 <b>Nombre archivo<b>
 <input type="text" id="nombre_archivo_asubir_img" name="nombre_archivo_asubir_img" class="form-control" maxlength="300">
  </b></b></div>  
</div>';


$html.='<div id="dv_adjuntarOtroDocRESPUESTA" style="background-color: #68ff73;">
        <b>Adjuntar Archivo</b>
<form enctype="multipart/form-data" class="formularioIMGmuestra">
<input type="file" name="archivoMUESTRA" id="imagenPerfilOTRODOC" title="Subir">
<input type="hidden" name="idCorrelMUESTRA" id="idCorrelMUESTRA" value="'.$ID_SOLICITUD_HISTO.'_'.$idmuestra.'" >
    <input type="hidden" name="idCorrelMUESTRA_idreg" id="idCorrelMUESTRA_idreg" value="" >
 
</form>  
  
</div>';
$html.='<div id="dv_Mensaje_SUBIDAS_msj2"></div>   <div style="text-align:center"><a id="id_btn_subirdoc" class="btn btn-info btn-fill btn-sm" style="width: 98px;padding: 1px;margin-top:10px;" href="javascript:subirImgsOtroArchivo(\'formularioIMGmuestra\',\''.$ID_SOLICITUD_HISTO.'_'.$idmuestra.'\','.$ID_SOLICITUD_HISTO.','.$idmuestra.')"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar Cambios."    >Guardar</a></div>';


         $this->output->set_output($html);
}



function GuardaSubidaOtroArch() {
//NO BOIRRAR
if (!$this->input->is_ajax_request()) {
    show_404();
}
$html_out = '';

$message = $this->input->post('message'); //nom archivo
$id_reg = $this->input->post('id_reg');//196_247   (ID_SOLICITUD_HISTO)

$ID_SOLICITUD_HISTO = $this->input->post('ID_SOLICITUD_HISTO');
$id_muestra = $this->input->post('id_muestra');
$nomarchivo = $this->input->post('nomarchivo');

$returnINSERTFuncion = $this->ssan_libro_biopsias_ii_fase_model->INSERT_SubidaOtroDoc($message, $this->usuario, $this->empresa, $id_reg,$ID_SOLICITUD_HISTO,$id_muestra,$nomarchivo);
if ($returnINSERTFuncion) {
    $html_out .= "<script>showNotification('top', 'center', 'Registro Agregado con exito', 2, 'fa fa-check'); $('#Adjuntaimg_modal').modal('hide'); Ver_historial_muestra(".$ID_SOLICITUD_HISTO.",".$id_muestra.");</script>";
} else {
    $html_out .= "<script>showNotification('top', 'center', 'Archivo No guardado', 3, 'fa fa-times');</script>";
}
$html_out .= "<script> $('#id_btn_subirdoc').show();</script>";

$this->output->set_output($html_out);
}







function guardar_proceso() {
//NO BOIRRAR
if (!$this->input->is_ajax_request()) {
    show_404();
}
$html_out = '';

$Datos_ENC = $this->input->post('Datos_ENC');//TRAE ESTADO DEL ENCABEZADO
$Datos_MUESTRA = $this->input->post('Datos_MUESTRA');//196_247   (ID_SOLICITUD_HISTO)
$Sl_accion_a_realizar = $this->input->post('Sl_accion_a_realizar'); //nom archivo
$op = $this->input->post('op');//

$PRIMERA_FIRMA = $this->input->post('PRIMERA_FIRMA');//




    
$Clave = $this->input->post('Clave'); // firma simple 
    
$valida = $this->ssan_libro_biopsias_ii_fase_model->validaClave($Clave);      
if ($valida) {//si esta todo ok puedo grabar
 
$rut = $valida->USERNAME;
$rutm = explode("-", $rut);
$RUTFir = $rutm[0];
$DIGFir = $rutm[1];
$nombrefir = $valida->NAME . ' ' . $valida->MIDDLE_NAME . ' ' . $valida->LAST_NAME;


$returnINSERTFuncion = $this->ssan_libro_biopsias_ii_fase_model->INSERT_guardar_proceso($RUTFir, $this->empresa,$Datos_MUESTRA,$Sl_accion_a_realizar,$op,$Datos_ENC,$PRIMERA_FIRMA);

if ($returnINSERTFuncion['trans'])  {
  $PDF_ING=$returnINSERTFuncion['CORREL_ING'];
    $html_out .= "<script> $('#PRIMERA_FIRMA').val();    showNotification('top', 'center', 'Registro Procesado con exito.', 2, 'fa fa-check'); $('#modal_comenzar').modal('hide'); ";

    if($PDF_ING!=''){
      $html_out .= "  PDF_INGRESO($PDF_ING);";
    }

    $html_out .= " </script>";
} else {
    $html_out .= "<script>showNotification('top', 'center', 'Error al procesar las muestras.', 3, 'fa fa-times');</script>";
}


} else {//error en la firma
$html_out .= '<script>jAlert("Firma Incorrecta", "Restricci\u00f3n");</script>';
}
















$this->output->set_output($html_out);
}







public function buscar_buscador() {//en rpocesososo   
if (!$this->input->is_ajax_request()) {
 show_404();
}


$num_solicitud = $this->input->post('num_solicitud');
$busq_nummuestra = $this->input->post('busq_nummuestra');
$busq_rutpac = $this->input->post('busq_rutpac');
$html='';
$html_ENC='';
$ID_SOLICITUD='';


$ctts=0; 





$html .= '<table class="table ths_tables"  id="tbody_buscar_buscador" style="text-align: center"><thead><tr >';



$html.="<tr style='background-color: #23ccef;' >";
if($busq_rutpac!=''){
$html.="  <th data-field='xxx1' data-sortable='true' style='color:white;'>ID SOLICITUD</th>  ";
}
$html.="<th data-field='xxx2' data-sortable='true' style='color:white;'>N° MUESTRA</th>
<th data-field='xxx2' data-sortable='true' style='color:white;'>TIPO_MUESTRA</th>
<th data-field='xxx3' data-sortable='true' style='color:white;'>NOMBRE MUESTRA</th>
<th data-field='xxx4' data-sortable='true' style='color:white;'>ESTADO ACTUAL</th>
<th data-field='xxx5' data-sortable='true' style='color:white;'>INFO</th></tr></thead> <tbody> 
";



$mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_Listadomuestras_originales('','',$num_solicitud,$busq_nummuestra,$busq_rutpac);
if($mu_estras){
foreach ($mu_estras as &$row_ms) {
    $ID_SOLICITUD=  $row_ms['ID_SOLICITUD_HISTO'];
   $TXT_MUESTRA= $row_ms['TXT_MUESTRA'];
     $NUM_FICHAE= $row_ms['NUM_FICHAE'];
   $RUT_PACIENTE= $row_ms['RUT_PACIENTE'];
   $NOM_PACIENTE= $row_ms['NOM_PACIENTE'];
   $IDMUESTRA= $row_ms['ID_NMUESTRA'];
   $IND_TIPOMUESTRA= $row_ms['IND_TIPOMUESTRA'];
$IND_TIPOMUESTRA_TXT=$this->Tipomuestra_txt($IND_TIPOMUESTRA);

$MOTIVO_RECHAZO= $row_ms['MOTIVO_RECHAZO'];

if($MOTIVO_RECHAZO!=''){
$MOTIVO_RECHAZO_TXT= $this->MOTIVO_RECH_txt($MOTIVO_RECHAZO);
}else{
$MOTIVO_RECHAZO_TXT='';
}



 

   $IND_ESTADO_REG= $row_ms['IND_ESTADO_REG'];
$IND_ESTADO_REG_TXT=$this->Estado__txt($IND_ESTADO_REG);



$html.="<tr>";
if($busq_rutpac!=''){
$html.="<td>$ID_SOLICITUD</td> ";
}

   $html.="<td>$IDMUESTRA</td>";
   $html.="<td>$IND_TIPOMUESTRA_TXT</td>";
   $html.="<td>$TXT_MUESTRA</td>";
   $html.="<td>$IND_ESTADO_REG_TXT ($IND_ESTADO_REG)<br><span style='color:red;'>$MOTIVO_RECHAZO_TXT</span></td>";

 //  $html.="<td colspan='2'></td>";
 

///VE SI SUBIO IMAGEN y ver hisotrial
$html.="<td>";
$html.="<a class='btn btn-default btn-fill btn-sm' style='width: 98px;padding: 1px;margin-top: 2px;' href='javascript:Ver_historial_muestra(".$ID_SOLICITUD.",".$IDMUESTRA.")' data-toggle='tooltip' data-placement='top' title='' data-original-title='trae información.'>
<i class='fa fa-search' aria-hidden='true'></i> INFO</a>";

//_______________

   $html.="</td>";
   $html.="</tr>";  

}}   
$html.=" </tbody> </table>";
$html .= '<script> var $tabla_bootstrap = $(\'#tbody_buscar_buscador\'); ' 
. $this->tabla_bootstrap . '   tooltip();   </script>';



//ENCABEZADO
$mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_ENCAB_SOLICITUD($ID_SOLICITUD);
if($mu_estras){
foreach ($mu_estras as &$row_ms) {
    $RUT_PACIENTE= $row_ms['RUT_PACIENTE'];
    $NOM_PACIENTE= $row_ms['NOM_PACIENTE'];
    $ID_HISTO_ESTADO= $row_ms['ID_HISTO_ESTADO'];
   
    $ID_HISTO_ESTADO_txt=$this->Estado__txt($ID_HISTO_ESTADO);
    
    $html_ENC.="<table class='table' style='margin-top:20px;'>";
    if($busq_rutpac==''){
        $html_ENC.="<tr>
    <td style='    width: 140px;'><b>N° SOLICITUD</b></td><td>$ID_SOLICITUD</td>        
    <td>

    <button type='button' class='btn btn-danger btn-fill btn-xs' id='pdf_pase' onclick='GET_PDF_ANATOMIA_PANEL($ID_SOLICITUD)'>
    <i class='fa fa-file-pdf-o' aria-hidden='true'></i>
</button>

    </td>
    </tr>";
    $html_ENC.="<tr>
    <td style='    width: 140px;'><b>ESTADO </b></td><td colspan='2'>$ID_HISTO_ESTADO_txt</td>
    </tr>";
    }       
   
    $html_ENC.="<tr>
    <td><b>PACIENTE</b></td><td  colspan='2'>$RUT_PACIENTE $NOM_PACIENTE</td>
    </tr>";
  
    $html_ENC.="</table>";


}}





$this->output->set_output($html_ENC.$html);
}









public function Carga_listado_pabellon() {//en rpocesososo   
if (!$this->input->is_ajax_request()) {
show_404();
}


$txt_fec_inicio = $this->input->post('txt_fec_inicio');
$txt_fec_fin = $this->input->post('txt_fec_fin');

$html='';

                                


$html.="<table class='table'>
<tr style='background-color: #23ccef;' >
<td><b>N°</b></td> 
<td><b>PACIENTE</b></td> 
<td><b>R.U.N</b></td> 
<td><b>N° FICHA</b></td>
<td><b>NOMBRE MEDICO</b></td> 
<td><b>R.U.N MEDICO</b></td>
<td><b>DATOS SOLICITUD</b></td>  
<td><b>ESTADO</b></td> 
<td><b>FECHA</b></td>
<td>.</td>  
<td>..</td>  
</tr>";


$mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_listado_pabellon($txt_fec_inicio,$txt_fec_fin);
if($mu_estras){
foreach ($mu_estras as &$row_ms) {
  $ID_SOLICITUD_HISTO=  $row_ms['ID_SOLICITUD_HISTO'];
  $ID_TABLA=  $row_ms['ID_TABLA'];
  $NUM_FICHAE=  $row_ms['NUM_FICHAE'];
  $RUTPACIENTE=  $row_ms['RUTPACIENTE'];
  $NOM_NOMBRE=  $row_ms['NOM_NOMBRE'];
  $NOM_APEMAT=  $row_ms['NOM_APEMAT'];
  $NOM_PREVIS=  $row_ms['NOM_PREVIS'];
  $PABELLONERA=  $row_ms['PABELLONERA'];
  $NMUESTRAS_PABELLON=  $row_ms['NMUESTRAS_PABELLON'];
  
  
  



$html.="<tr>";


 $html.="<td>$ID_SOLICITUD_HISTO</td>";
 $html.="<td>$ID_TABLA</td>";
 $html.="<td>$RUTPACIENTE<br>$NOM_NOMBRE $NOM_APEMAT</td>";
 $html.="<td>$NOM_PREVIS</td>";
 $html.="<td>$PABELLONERA</td>";
 $html.="<td>$NMUESTRAS_PABELLON</td>";



///VE SI SUBIO IMAGEN y ver hisotrial
$html.="<td>";
$html.="<a class='btn btn-default btn-fill btn-sm' style='width: 98px;padding: 1px;margin-top: 2px;' href='' data-toggle='tooltip' data-placement='top' title='' data-original-title='trae información.'>
<i class='fa fa-search' aria-hidden='true'></i> INFO</a>";

//_______________

 $html.="</td>";
 $html.="</tr>";  

}}   
$html.="</table>";


$this->output->set_output($html);
}







public function Carga_listado_recep_ap() {//en rpocesososo   
if (!$this->input->is_ajax_request()) {
show_404();
}


$txt_fec_inicio = $this->input->post('txt_fec_inicio_recepc_ap');
$txt_fec_fin = $this->input->post('txt_fec_fin_recepc_ap');



$html='';

                                


$html.="<table class='table'>
<tr style='background-color: #23ccef;' >
<td><b>N°</b></td> 
<td><b>N° FICHA</b></td> 
<td><b>R.U.N</b></td>
<td><b>PACIENTE</b></td>  
<td><b>FECHA SOLICITUD</b></td> 
<td><b>TIPO MUJESTRA</b></td>
<td><b>N DE MEUESTRAS</b></td>

<td><b>PROFESIONAL ENTREGA AP</b></td> 
<td><b>PROFESIONAL RECEPCIONA AP</b></td> 
<td><b>FECHA RECEPCION</b></td>   

</tr>";


$mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_LISTADO_RECEPCIONES_AP('',$txt_fec_inicio,$txt_fec_fin);
if($mu_estras){
foreach ($mu_estras as &$row_ms) {
  $CORRELATIVO_INGRESOS=  $row_ms['CORRELATIVO_INGRESOS'];
  $FEC_INICIO_SOLICITUD=  $row_ms['FEC_INICIO_SOLICITUD'];
  $NOM_PACIENTE=  $row_ms['NOM_PACIENTE'].' '.$row_ms['APEPAT_PACIENTE'].' '.$row_ms['APEMAT_PACIENTE'];
  $RUT_PAC=  $row_ms['RUT_PAC'];      
  $NUM_FICHAE=  $row_ms['NUM_FICHAE'];   
  $USUARIO_ENTREGA=  $row_ms['USUARIO_ENTREGA'];
  $NOM_RECEPCIONA=  $row_ms['NOM_RECEPCIONA'];
  $FEC_CREA=  $row_ms['FEC_CREA'];

  $IND_TIPOMUESTRA=  $row_ms['IND_TIPOMUESTRA'];
  $IND_TIPOMUESTRA_txt=  $this->Tipomuestra_txt($IND_TIPOMUESTRA);


$html.="<tr>
 <tr>                            
 <td style='vertical-align:top'> $CORRELATIVO_INGRESOS</td>";
 $html.="<td>$NUM_FICHAE</td>";
 $html.="<td style='vertical-align:top'>$RUT_PAC</td>       
 <td style='vertical-align:top'>$NOM_PACIENTE </td>       
 <td style='vertical-align:top'>$FEC_INICIO_SOLICITUD</td>       

 <td style='vertical-align:top'>$IND_TIPOMUESTRA_txt</td>
 <td style='vertical-align:top'>1</td>


 <td style='vertical-align:top'> $USUARIO_ENTREGA</td>"; 
 $html.="<td>$FEC_CREA</td>";
 $html.="<td>$NOM_RECEPCIONA</td>
                                                      

</tr>";




}}   
$html.="</table>";


$this->output->set_output($html);
}









public function Carga_listado_recep_ap_HOJAS() {//en rpocesososo   
if (!$this->input->is_ajax_request()) {
show_404();
}


$txt_fec_inicio = $this->input->post('txt_fec_inicio_recepc_ap');
$txt_fec_fin = $this->input->post('txt_fec_fin_recepc_ap');



$html='';

                                


$html.="<table class='table'>
<tr style='background-color: #23ccef;' >
<td><b>N°</b></td> 
<td><b>FUNCIONARIO QUE RECEPCIONA</b></td> 
<td><b>FECHA RECEPCIÓN</b></td>
<td><b>ESTABLECIMIENTO</b></td>  
<td><b>VER</b></td>  

</tr>";





$mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_LISTADO_RECEPCIONES_AP_HOJAS($txt_fec_inicio,$txt_fec_fin);
if($mu_estras){
foreach ($mu_estras as &$row_ms) {

$CORRELATIVO_INGRESOS=  $row_ms['CORRELATIVO_INGRESOS'];
$NOM_RECEPCIONA=  $row_ms['NOM_RECEPCIONA'];
$FEC_RECEPCION=  $row_ms['FEC_RECEPCION'];
$NOM_ESTABLECIMIENTO=  $row_ms['NOM_ESTABLECIMIENTO'];


$html.="
 <tr>                            
 <td style='vertical-align:top'> $CORRELATIVO_INGRESOS</td>
 <td style='vertical-align:top'> $NOM_RECEPCIONA</td>
 <td style='vertical-align:top'> $FEC_RECEPCION</td>
 <td style='vertical-align:top'> $NOM_ESTABLECIMIENTO</td>
 <td style='vertical-align:top'>  
 <a class='btn btn-info btn-fill btn-sm' style='width: 125px;padding: 1px;margin-top: 2px;' href='javascript:PDF_INGRESO($CORRELATIVO_INGRESOS)' data-toggle='tooltip' data-placement='top'  data-original-title=''>
<i class='fa fa-file-pdf-o' aria-hidden='true'></i> PDF</a>
   </td>
     ";
 $html.="</tr>";




}}   
$html.="</table>";


$this->output->set_output($html);
}




public function Carga_listado_NOrecep() {
if (!$this->input->is_ajax_request()) {
show_404();
}


$txt_fec_inicio = $this->input->post('txt_fec_inicio_NOrecepc');
$txt_fec_fin = $this->input->post('txt_fec_fin_NOrecepc');

$html='';

                                


$html.="<table class='table'>
<tr style='background-color: #23ccef;' >
<td><b>N° ORDINARIO NOTIFICACION</b></td> 
<td><b>N° BIOPSIA</b></td> 
<td><b>R.U.N</b></td>
<td><b>PACIENTE</b></td>  
<td><b>FECHA SOLICITUD</b></td> 
<td><b>TIPO MUESTRA</b></td>
<td><b>ESTABLECIMIENTO - SERVICIO</b></td>
<td><b>FECHA RECHAZO</b></td> 
<td><b>FECHA INGRESO CON CORRECCIÓN</b></td> 
<td><b>MOTIVO DEL RECHAZO</b></td>   
<td><b>OPCIÓN</b></td>   
</tr>";

//trabajando en estaaaa
$mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_LISTADO_NO_RECEPCIONADAS('',$txt_fec_inicio,$txt_fec_fin);
if($mu_estras){
foreach ($mu_estras as &$row_ms) {


$ID_NR_RECEPCION_AP=  $row_ms['ID_NR_RECEPCION_AP'];

   $CORRELATIVO_NRECEPCION=  $row_ms['CORRELATIVO_NRECEPCION'];

$ID_NMUESTRA=  $row_ms['ID_NMUESTRA'];
$RUT_PAC= $row_ms['RUT_PAC'];
$NOM_PACIENTE=  $row_ms['NOM_PACIENTE'];
$APEPAT_PACIENTE=  $row_ms['APEPAT_PACIENTE'];
$APEMAT_PACIENTE=  $row_ms['APEMAT_PACIENTE'];
$FEC_INICIO_SOLICITUD=  $row_ms['FEC_INICIO_SOLICITUD'];
$IND_TIPOMUESTRA=  $row_ms['IND_TIPOMUESTRA'];
$IND_TIPOMUESTRA_txt=  $this->Tipomuestra_txt($IND_TIPOMUESTRA);



$ESTABLECIMIENTI="??SOLICITA O REALIZA RECHAZO???";//  $row_ms['xxx'];
$FEC_ACCION_RECHAZO=  $row_ms['FEC_ACCION'];

$MOTIVO_RECHAZO=  $row_ms['MOTIVO_RECHAZO'];

if($MOTIVO_RECHAZO!=''){
$MOTIVO_RECHAZO_TXT= $this->MOTIVO_RECH_txt($MOTIVO_RECHAZO);
}else{
$MOTIVO_RECHAZO_TXT='';
}



$OBS_HIST_MUESTRA_TXT=  $row_ms['OBS_HIST_MUESTRA'];


$NR_FEC_ING_CORRECCION=  $row_ms['NR_FEC_ING_CORRECCION'];

$NR_USR_SOLICI_ACTIV=  $row_ms['NR_USR_SOLICI_ACTIV'];
$NR_FEC_SOLICI_ACTIV=  $row_ms['NR_FEC_SOLICI_ACTIV'];
$NR_OBS_SOLICI_ACTIV=  $row_ms['NR_OBS_SOLICI_ACTIV'];




$btn="";
if($NR_USR_SOLICI_ACTIV!=''  && $NR_FEC_ING_CORRECCION==''){//solo tiene solicitud de actiuvacioonm 

$btn.="

<a class='btn btn-info btn-fill btn-xs' href='javascript:vER_motiv_activ($ID_NMUESTRA,$ID_NR_RECEPCION_AP)' data-toggle='tooltip' data-placement='top' title='' data-original-title='trae información.'>
 <i class='fa fa-eye' aria-hidden='true'></i></a>

<a class='btn btn-warning btn-fill btn-xs' href='javascript:activar_muestra($ID_NMUESTRA,$ID_NR_RECEPCION_AP)' data-toggle='tooltip' data-placement='top' title='' data-original-title='Activar Muestra'>
<i class='fa fa-upload' aria-hidden='true'></i></a>";
}


if($NR_USR_SOLICI_ACTIV!=''  && $NR_FEC_ING_CORRECCION!=''){//la muestra ya fue activada

$btn.="

<a class='btn btn-info btn-fill btn-xs' href='javascript:vER_motiv_activ($ID_NMUESTRA,$ID_NR_RECEPCION_AP)' data-toggle='tooltip' data-placement='top' title='' data-original-title='trae información.'>
 <i class='fa fa-eye' aria-hidden='true'></i></a>

<a class='btn btn-success btn-fill btn-xs' href='#' data-toggle='tooltip' data-placement='top' title='' data-original-title='Muestra activa.'>
 <i class='fa fa-upload' aria-hidden='true'></i></a>";
}
/*
else{
//nuevoo
$btn.="
<a class='btn btn-success btn-fill btn-sm' style='padding: 1px;margin-top: 2px;' id='btn_solicita_activ_$ID_NMUESTRA' href='javascript:Solicitar_activacion($ID_NMUESTRA)' data-toggle='tooltip' data-placement='top' title='' data-original-title=''>
SOLICITAR ACTIVACIÓN</a>

<a class='btn btn-default btn-fill btn-sm' style='padding: 1px;margin-top: 2px;display:none' id='OKbtn_solicita_activ_$ID_NMUESTRA' href='#' data-toggle='tooltip' data-placement='top' title='' data-original-title=''>
SOLICITUD EN PROCESO</a>
";


}
*/


$html.="<tr>";
                       
 $html.="<td style='vertical-align:top'> $CORRELATIVO_NRECEPCION</td>";
 $html.="<td style='vertical-align:top'> $ID_NMUESTRA</td>";
 $html.="<td style='vertical-align:top'> $RUT_PAC</td>";
 $html.="<td style='vertical-align:top'> $NOM_PACIENTE $APEPAT_PACIENTE $APEMAT_PACIENTE</td>";
 $html.="<td style='vertical-align:top'> $FEC_INICIO_SOLICITUD</td>";
 $html.="<td style='vertical-align:top'> $IND_TIPOMUESTRA_txt</td>";
 $html.="<td style='vertical-align:top'> $ESTABLECIMIENTI</td>";
 $html.="<td style='vertical-align:top'> $FEC_ACCION_RECHAZO</td>";
 $html.="<td style='vertical-align:top'> $NR_FEC_ING_CORRECCION</td>";
 $html.="<td style='vertical-align:top'> ($MOTIVO_RECHAZO_TXT) -  $OBS_HIST_MUESTRA_TXT</td>";

 $html.="<td style='vertical-align:top'>";


 $html.="
 
                                        $btn

                                        ";
 

 
$html.="</td>";
                   

$html.=" </tr>";




}}   
$html.="</table>   <script>  tooltip();</script>";


$this->output->set_output($html);
}








public function Carga_listado_NOrecep_HOJAS() {//en rpocesososo   
if (!$this->input->is_ajax_request()) {
show_404();
}


$txt_fec_inicio = $this->input->post('txt_fec_inicio_NOrecepc');
$txt_fec_fin = $this->input->post('txt_fec_fin_NOrecepc');



$html='';

                                


$html.="<table class='table'>
<tr style='background-color: #23ccef;' >
<td><b>N°</b></td> 
<td><b>FUNCIONARIO QUE RECHAZA</b></td> 
<td><b>FECHA REGISTRO</b></td>
<td><b>ESTABLECIMIENTO</b></td>  
<td><b>VER</b></td>  

</tr>";





$mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_LISTADO_NORECEPCIONES_HOJAS($txt_fec_inicio,$txt_fec_fin);
if($mu_estras){
foreach ($mu_estras as &$row_ms) {

$CORRELATIVO_NRECEPCION=  $row_ms['CORRELATIVO_NRECEPCION'];
$NOM_RECEPCIONA=  $row_ms['NOM_RECEPCIONA'];
$FEC_RECEPCION=  $row_ms['FEC_RECEPCION'];
$NOM_ESTABLECIMIENTO=  $row_ms['NOM_ESTABLECIMIENTO'];


$html.="
 <tr>                            
 <td style='vertical-align:top'> $CORRELATIVO_NRECEPCION</td>
 <td style='vertical-align:top'> $NOM_RECEPCIONA</td>
 <td style='vertical-align:top'> $FEC_RECEPCION</td>
 <td style='vertical-align:top'> $NOM_ESTABLECIMIENTO</td>

 <td style='vertical-align:top'>
 <a class='btn btn-info btn-fill btn-sm' style='width: 125px;padding: 1px;margin-top: 2px;' href='javascript:PDF_NORECEP($CORRELATIVO_NRECEPCION)' data-toggle='tooltip' data-placement='top'  data-original-title=''>
 <i class='fa fa-file-pdf-o' aria-hidden='true'></i> PDF</a>
 </td>

     ";
 $html.="</tr>";




}}   
$html.="</table>";


$this->output->set_output($html);
}


public function excel_recepcionadas_ap() {//CUALQUIER MODIFICACION SE DEBE MODIFICAR EL QUE ESTA EN MODULO (MIS SOLICITUDESS)
//la unica diferencia con el real es que se agrega el rut del usuario $this->usuario

//load our new PHPExcel library
$this->load->library('excel');


$txtFechDe = $this->input->get("txtFechDe"); //30/05/2017
$txtFechhasta = $this->input->get("txtFechhasta"); //30/05/2017


$PER_ID_SOLOVER='';





//        $dia = $this->input->get("idform");

//        $fecha = $dia . '/' . $mes . '/' . $ano;
$date = date('d-m-Y / H:i:s');


$DOSborder__style = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => 'FFF'),)));
$BORDERDOSborder_style = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => array('argb' => 'FFF'),)));
$border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFF'),)));
$background_style = array('background-color' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFF'),)));       

$style_titulos = array('font'  => array('bold'  => true,'color' => array('rgb' => '333'),'size'  => 20,'name'  => 'Verdana'));




        
         $index=1; 
         $TIPO='';
         $ESTADO_REG='';

$index++;   

$this->excel->setActiveSheetIndex(0);
$this->excel->getActiveSheet()->setTitle('RECEPCION AP');
 $this->excel->getActiveSheet()->setCellValue('A1', 'Reporte creado: '.$date);
 $this->excel->getActiveSheet()->mergeCells('A1:D1');
 $this->excel->getActiveSheet()->setCellValue('A' . $index, 'RECEPCION AP - PERIODO ('.$txtFechDe.' - '.$txtFechhasta.')  ');
   $this->excel->getActiveSheet()->mergeCells('A'.$index.':J'. $index);
  $this->excel->getActiveSheet()->getStyle('A'. $index)->applyFromArray($style_titulos);
 $index++;
 $TIPO='';
  $ESTADO_REG='';



$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);






      
//CONSOLIDADO


      
     
$this->excel->getActiveSheet()->getStyle("A$index:L$index")->applyFromArray($border_style);
$this->excel->getActiveSheet()->getStyle('A'.$index.':L'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('#FFDBE2F1'); 
$this->excel->getActiveSheet()->getStyle('A'.$index.':L'.$index.'')->getFont()->setBold(true);

$this->excel->getActiveSheet()->setCellValue('A' . $index, 'N°   ');
$this->excel->getActiveSheet()->setCellValue('B' . $index, 'N° FICHA');
$this->excel->getActiveSheet()->setCellValue('C' . $index, 'R.U.N');
$this->excel->getActiveSheet()->setCellValue('D' . $index, 'PACIENTE');
$this->excel->getActiveSheet()->setCellValue('E' . $index, 'FECHA SOLICITUD');
$this->excel->getActiveSheet()->setCellValue('F' . $index, 'TIPO MUESTRA');
$this->excel->getActiveSheet()->setCellValue('G' . $index, 'N DE MEUESTRAS');
$this->excel->getActiveSheet()->setCellValue('H' . $index, 'PROFESIONAL ENTREGA AP');
$this->excel->getActiveSheet()->setCellValue('I' . $index, 'FECHA ENTREGA');
$this->excel->getActiveSheet()->setCellValue('J' . $index, 'PROFESIONAL RECEPCIONA AP');
$this->excel->getActiveSheet()->setCellValue('K' . $index, 'EDAD');
$this->excel->getActiveSheet()->setCellValue('L' . $index, 'PREVISION');

  
          // $this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
          //$this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode('#,##');
         
     
                                                   
$consulta1 = $this->ssan_libro_biopsias_ii_fase_model->Carga_LISTADO_RECEPCIONES_AP('',$txtFechDe,$txtFechhasta);
if ($consulta1) {//consulto si vienen datos 
  foreach ($consulta1 as &$row_ms) {
$index++; 


  $CORRELATIVO_INGRESOS=  $row_ms['CORRELATIVO_INGRESOS'];
  $FEC_INICIO_SOLICITUD=  $row_ms['FEC_INICIO_SOLICITUD'];
  $NOM_PACIENTE=  $row_ms['NOM_PACIENTE'].' '.$row_ms['APEPAT_PACIENTE'].' '.$row_ms['APEMAT_PACIENTE'];
  $RUT_PAC=  $row_ms['RUT_PAC'];      
  $NUM_FICHAE=  $row_ms['NUM_FICHAE'];
  $FEC_NACI_PAC=  $row_ms['FEC_NACI_PAC'];
  $FECHA_HOY=  $row_ms['FECHA_HOY'];

  $NOM_PREVIS=  $row_ms['NOM_PREVIS'];

  

    ////_____________Edad_____________x            
    $edad_anios='0';  $edad_meses='0';  $edad_semanas='0';  $edad_dias='0'; $edad_horas='0';             
  
   
    $fecha_nacimiento = $FEC_NACI_PAC;         
   $dataFech = $this->validaciones->calculaEdadporSeccion($fecha_nacimiento,$FECHA_HOY);
  
      if(!empty($dataFech['años'])){   $edad_anios  =$dataFech['años'];  }
       if(!empty($dataFech['meses'])){  $edad_meses  =$dataFech['meses'];  }
       if(!empty($dataFech['semanas'])){  $edad_semanas =$dataFech['semanas']; }
      if(!empty($dataFech['dias'])){  $edad_dias  =$dataFech['dias']; }
    
 ////_____________Edad_____________  

  
  
  


  $USUARIO_ENTREGA=  $row_ms['USUARIO_ENTREGA'];
  $NOM_RECEPCIONA=  $row_ms['NOM_RECEPCIONA'];
  $FEC_CREA=  $row_ms['FEC_CREA'];

  $IND_TIPOMUESTRA=  $row_ms['IND_TIPOMUESTRA'];
  $IND_TIPOMUESTRA_txt=  $this->Tipomuestra_txt($IND_TIPOMUESTRA);



      
$this->excel->getActiveSheet()->getStyle("A$index:K$index")->applyFromArray($border_style);                
//$index = 6;
//$this->excel->getActiveSheet()->getStyle("B" . $index1 . ":J" . $index)->applyFromArray($border_style);
$this->excel->getActiveSheet()->setCellValue('A' . $index, $CORRELATIVO_INGRESOS);
$this->excel->getActiveSheet()->setCellValue('B' . $index, $NUM_FICHAE);
$this->excel->getActiveSheet()->setCellValue('C' . $index, $RUT_PAC);
$this->excel->getActiveSheet()->setCellValue('D' . $index, $NOM_PACIENTE);
$this->excel->getActiveSheet()->setCellValue('E' . $index, $FEC_INICIO_SOLICITUD);
$this->excel->getActiveSheet()->setCellValue('F' . $index, $IND_TIPOMUESTRA_txt);
$this->excel->getActiveSheet()->setCellValue('G' . $index, '1');
$this->excel->getActiveSheet()->setCellValue('H' . $index, $USUARIO_ENTREGA);
$this->excel->getActiveSheet()->setCellValue('I' . $index, $FEC_CREA);
$this->excel->getActiveSheet()->setCellValue('J' . $index, $NOM_RECEPCIONA);
$this->excel->getActiveSheet()->setCellValue('K' . $index, $edad_anios);
$this->excel->getActiveSheet()->setCellValue('L' . $index, $NOM_PREVIS);




     
     
 
 
            //    $this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
          //$this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode('#,##');

      }   
        $index++;
        // $this->excel->getActiveSheet()->getStyle("A$index:J$index")->applyFromArray($border_style);     
        //$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('#bcdeaa');         
        //        $this->excel->getActiveSheet()->setCellValue('J' . $index, 'Total');
        //      $this->excel->getActiveSheet()->getStyle('I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('#fff495');      
        //    $this->excel->getActiveSheet()->setCellValue('I' . $index, '=SUM(I4:I'.($index-1).')');
        //   $this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        //  $this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode('#,##');
  }





    $this->excel->setActiveSheetIndex(0);
    $nombre = 'RECEP AP '.$date;
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="' . $nombre . '.xls"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache
    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}










    public function excel_NOrecepcionadas_ap() {//CUALQUIER MODIFICACION SE DEBE MODIFICAR EL QUE ESTA EN MODULO (MIS SOLICITUDESS)
        //la unica diferencia con el real es que se agrega el rut del usuario $this->usuario
        //load our new PHPExcel library
        $this->load->library('excel');
        $txtFechDe = $this->input->get("txtFechDe"); //30/05/2017
        $txtFechhasta = $this->input->get("txtFechhasta"); //30/05/2017
        $PER_ID_SOLOVER='';
        //        $dia = $this->input->get("idform");
        //        $fecha = $dia . '/' . $mes . '/' . $ano;
        $date = date('d-m-Y / H:i:s');
        $DOSborder__style = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => 'FFF'),)));
        $BORDERDOSborder_style = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => array('argb' => 'FFF'),)));
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFF'),)));
        $background_style = array('background-color' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFF'),)));       
        $style_titulos = array('font'  => array('bold'  => true,'color' => array('rgb' => '333'),'size'  => 20,'name'  => 'Verdana'));

        
        $index=1; 
        $TIPO='';
        $ESTADO_REG='';

        $index++;   

        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('NO RECEPCIONADOS');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Reporte creado: '.$date);
        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        $this->excel->getActiveSheet()->setCellValue('A' . $index, 'NO RECEPCIONADOS - PERIODO ('.$txtFechDe.' - '.$txtFechhasta.')  ');
        $this->excel->getActiveSheet()->mergeCells('A'.$index.':J'. $index);
        $this->excel->getActiveSheet()->getStyle('A'. $index)->applyFromArray($style_titulos);
        $index++;
        $TIPO='';
        $ESTADO_REG='';



        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

        //CONSOLIDADO

        $this->excel->getActiveSheet()->getStyle("A$index:J$index")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('#FFDBE2F1'); 
        $this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index.'')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->setCellValue('A' . $index, 'N° ORDINARIO NOTIFICACION');
        $this->excel->getActiveSheet()->setCellValue('B' . $index, 'N° BIOPSIA');
        $this->excel->getActiveSheet()->setCellValue('C' . $index, 'R.U.N');
        $this->excel->getActiveSheet()->setCellValue('D' . $index, 'PACIENTE');
        $this->excel->getActiveSheet()->setCellValue('E' . $index, 'FECHA SOLICITUD');
        $this->excel->getActiveSheet()->setCellValue('F' . $index, 'TIPO MUESTRA');
        $this->excel->getActiveSheet()->setCellValue('G' . $index, 'ESTABLECIMIENTO - SERVICIO');
        $this->excel->getActiveSheet()->setCellValue('H' . $index, 'FECHA RECHAZO');
        $this->excel->getActiveSheet()->setCellValue('I' . $index, 'FECHA INGRESO CON CORRECCIÓN');
        $this->excel->getActiveSheet()->setCellValue('J' . $index, 'MOTIVO DEL RECHAZO');
        // $this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        //$this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode('#,##');
        $consulta1 = $this->ssan_libro_biopsias_ii_fase_model->Carga_LISTADO_NO_RECEPCIONADAS('',$txtFechDe,$txtFechhasta);
        if ($consulta1) {//consulto si vienen datos 
        foreach ($consulta1 as &$row_ms) {
        $index++; 
        $CORRELATIVO_NRECEPCION=  $row_ms['CORRELATIVO_NRECEPCION'];
        $ID_NMUESTRA=  $row_ms['ID_NMUESTRA'];
        $RUT_PAC= $row_ms['RUT_PAC'];
        $NOM_PACIENTE=  $row_ms['NOM_PACIENTE'];
        $APEPAT_PACIENTE=  $row_ms['APEPAT_PACIENTE'];
        $APEMAT_PACIENTE=  $row_ms['APEMAT_PACIENTE'];
        $FEC_INICIO_SOLICITUD=  $row_ms['FEC_INICIO_SOLICITUD'];
        $IND_TIPOMUESTRA=  $row_ms['IND_TIPOMUESTRA'];
        $IND_TIPOMUESTRA_txt=  $this->Tipomuestra_txt($IND_TIPOMUESTRA);
        $ESTABLECIMIENTI="?ESTAB SOLICITA O QUE REALIZA EL RECHAZO??";//  $row_ms['xxx'];
        $FEC_ACCION_RECHAZO=  $row_ms['FEC_ACCION'];

        $MOTIVO_RECHAZO=  $row_ms['MOTIVO_RECHAZO'];

        if($MOTIVO_RECHAZO!=''){
            $MOTIVO_RECHAZO_TXT= $this->MOTIVO_RECH_txt($MOTIVO_RECHAZO);
        }else{
            $MOTIVO_RECHAZO_TXT='';
        }

        $OBS_HIST_MUESTRA_TXT=  $row_ms['OBS_HIST_MUESTRA'];
        $NR_FEC_ING_CORRECCION=  $row_ms['NR_FEC_ING_CORRECCION'];
        $this->excel->getActiveSheet()->getStyle("A$index:j$index")->applyFromArray($border_style);                
        //$index = 6;
        //$this->excel->getActiveSheet()->getStyle("B" . $index1 . ":J" . $index)->applyFromArray($border_style);
        $this->excel->getActiveSheet()->setCellValue('A' . $index, $CORRELATIVO_NRECEPCION);
        $this->excel->getActiveSheet()->setCellValue('B' . $index, $ID_NMUESTRA   );
        $this->excel->getActiveSheet()->setCellValue('C' . $index, $RUT_PAC   );
        $this->excel->getActiveSheet()->setCellValue('D' . $index, $NOM_PACIENTE.' '.$APEPAT_PACIENTE.' '.$APEMAT_PACIENTE);
        $this->excel->getActiveSheet()->setCellValue('E' . $index, $FEC_INICIO_SOLICITUD);
        $this->excel->getActiveSheet()->setCellValue('F' . $index, $IND_TIPOMUESTRA_txt);
        $this->excel->getActiveSheet()->setCellValue('G' . $index, $ESTABLECIMIENTI);
        $this->excel->getActiveSheet()->setCellValue('H' . $index, $FEC_ACCION_RECHAZO);
        $this->excel->getActiveSheet()->setCellValue('I' . $index, $NR_FEC_ING_CORRECCION);
        $this->excel->getActiveSheet()->setCellValue('J' . $index, '('.$MOTIVO_RECHAZO_TXT.') - '.$OBS_HIST_MUESTRA_TXT  );
            //    $this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            //$this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode('#,##');

        }   
        $index++;
        // $this->excel->getActiveSheet()->getStyle("A$index:J$index")->applyFromArray($border_style);     
        //$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('#bcdeaa');         
        //        $this->excel->getActiveSheet()->setCellValue('J' . $index, 'Total');
        //      $this->excel->getActiveSheet()->getStyle('I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('#fff495');      
        //    $this->excel->getActiveSheet()->setCellValue('I' . $index, '=SUM(I4:I'.($index-1).')');
        //   $this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        //  $this->excel->getActiveSheet()->getStyle('I'.$index)->getNumberFormat()->setFormatCode('#,##');
    }





    $this->excel->setActiveSheetIndex(0);
        $nombre = 'NO RECEP '.$date;
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $nombre . '.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }


    function firma_entrega() {
        //NO BOIRRAR
        if (!$this->input->is_ajax_request()) { show_404(); }
        $html_out = '';
        $Datos_ENC = $this->input->post('Datos_ENC');//TRAE ESTADO DEL ENCABEZADO
        $Datos_MUESTRA = $this->input->post('Datos_MUESTRA');//196_247   (ID_SOLICITUD_HISTO)
        $Sl_accion_a_realizar = $this->input->post('Sl_accion_a_realizar'); //nom archivo
        $op = $this->input->post('op');//
        $Clave = $this->input->post('Clave'); // firma simple 
        $valida = $this->ssan_libro_biopsias_ii_fase_model->validaClave($Clave);      
        if ($valida) {//si esta todo ok puedo grabar
        $rut = $valida->USERNAME;
        $rutm = explode("-", $rut);
        $RUTFir = $rutm[0];
        $DIGFir = $rutm[1];
        $nombrefir = $valida->NAME . ' ' . $valida->MIDDLE_NAME . ' ' . $valida->LAST_NAME;
        $html_out .= '<script>$("#PRIMERA_FIRMA").val("'.$RUTFir.'"); Guardar_proceso(1);</script>';
        } else {//error en la firma
        $html_out .= '<script>jAlert("Firma Incorrecta", "Restricci\u00f3n");</script>';
        $html_out .= '<script>$("#PRIMERA_FIRMA").val("");</script>';
        }
        $this->output->set_output($html_out);
    }

    function activar_muestra() {
        //NO BOIRRAR
        if (!$this->input->is_ajax_request()) {  show_404();   }
            $html_out = '';
            $idmu = $this->input->post('idmu'); //nom archivo
            $idcorr = $this->input->post('idcorr'); //nom archivo
            $Clave = $this->input->post('Clave'); // firma simple 
            $valida = $this->ssan_libro_biopsias_ii_fase_model->validaClave($Clave);      
            if ($valida) {//si esta todo ok puedo grabar
            $rut = $valida->USERNAME;
            $rutm = explode("-", $rut);
            $RUTFir = $rutm[0];
            $DIGFir = $rutm[1];
            $nombrefir = $valida->NAME . ' ' . $valida->MIDDLE_NAME . ' ' . $valida->LAST_NAME;
            $returnINSERTFuncion = $this->ssan_libro_biopsias_ii_fase_model->INSERT_ACTIV_MUESTRA($RUTFir, $this->empresa,$idmu,$idcorr);
        if ($returnINSERTFuncion) {
            $html_out .= "<script>    showNotification('top', 'center', 'Muestra activada correctamente', 2, 'fa fa-check');  Carga_listado_NOrecep();    </script>";
        } else {
            $html_out .= "<script>showNotification('top', 'center', Problemas al activar la muestra', 3, 'fa fa-times');</script>";
        }
        } else {//error en la firma
        $html_out .= '<script>jAlert("Firma Incorrecta", "Restricci\u00f3n");</script>';
        }
        $this->output->set_output($html_out);
    }

    public function vER_motiv_activ() {
        //fondos transferidos   
        if (!$this->input->is_ajax_request()) { show_404(); }

        //falta consulta a base de datos.. y besta pantañlla
        $html='';
        $idmuest = $this->input->post('idmuest');
        $idcorr = $this->input->post('idcorr');

        $html.="<table class='table' border style='width:100%'>"; 
        $html.="<tr style='cursor:pointer;'>";  
        $html.="<td colspan='2' ><i class='fa fa-play' aria-hidden='true'></i><b>INFORMACIÓN SOLICITUD DE ACTIVACIÓN MUESTRA N° $idmuest</b>";  

        $html.=" </td>";  
        $html.="</tr>";  

        $html.="<tr style='background-color: #beffbb;'>";  
        $html.="<td><b>SOLICITUD ACTIVACIÓN</b></td>";  
        $html.="<td><b>ACTIVACIÓN</b></td>";
        $html.="</tr>"; 

        $mu_estras = $this->ssan_libro_biopsias_ii_fase_model->Carga_Historial_muestra($idmuest,$idcorr);
        if($mu_estras){
        foreach ($mu_estras as &$row_ms) {

        $ID_HISTORIAL_NMUESTRA= $row_ms['ID_HISTORIAL_NMUESTRA'];
        $ID_NMUESTRA= $row_ms['ID_NMUESTRA'];
        $TXT_MUESTRA= $row_ms['TXT_MUESTRA'];    
        $ESTADO_REG= $row_ms['ESTADO_REG'];
        $PROFESIONAL= $row_ms['PROFESIONAL'];
        $FECHA_CREA= $row_ms['FECHA_CREA'];
        $NOM_ESTABL= $row_ms['NOM_ESTABL'];
        $OBS_HIST_MUESTRA= $row_ms['OBS_HIST_MUESTRA'];
        $MOTIVO_RECHAZO= $row_ms['MOTIVO_RECHAZO'];

        if($MOTIVO_RECHAZO!=''){
        $MOTIVO_RECHAZO_TXT= $this->MOTIVO_RECH_txt($MOTIVO_RECHAZO);
        }else{
        $MOTIVO_RECHAZO_TXT='';
        }

        $IND_ESTADO_REG_TXT=$this->Estado__txt($ESTADO_REG);

        $NR_USR_SOLICI_ACTIV= $row_ms['NR_USR_SOLICI_ACTIV'];
        $NR_FEC_SOLICI_ACTIV= $row_ms['NR_FEC_SOLICI_ACTIV'];
        $NR_OBS_SOLICI_ACTIV= $row_ms['NR_OBS_SOLICI_ACTIV'];
        $NR_FEC_ING_CORRECCION= $row_ms['NR_FEC_ING_CORRECCION'];
        $USR_ING_CORRECCION= $row_ms['USR_ING_CORRECCION'];
        $ID_NR_RECEPCION_AP= $row_ms['ID_NR_RECEPCION_AP'];

        $txt_activación="";
        $txt_SOLICITUDactivación='';
        if($NR_USR_SOLICI_ACTIV!=''){//cuenta con una solicitud de activacion
            $txt_SOLICITUDactivación.="<b>Fecha solicitud:</b> $NR_FEC_SOLICI_ACTIV
            <br><b>Profesional solicita:</b> $NR_USR_SOLICI_ACTIV
            <br><b>Observación:</b> $NR_OBS_SOLICI_ACTIV
            ";
        }

        if($NR_FEC_ING_CORRECCION!=''){//cuenta con una integracion (activacion de la muestra)
            $txt_activación.="<b>Fecha reintegro:</b> $NR_FEC_ING_CORRECCION
            <br><b>Profesional autoriza:</b> $USR_ING_CORRECCION 
            ";
        }
        $html.="<tr>";  
        $html.="<td style='vertical-align: top;'>$txt_SOLICITUDactivación</td>";  
        $html.="<td style='vertical-align: top;'>$txt_activación</td>"; 
        $html.="</tr>"; 
        }} 
        $html.="</table>"; 
        $this->output->set_output($html);
    }




}
?>