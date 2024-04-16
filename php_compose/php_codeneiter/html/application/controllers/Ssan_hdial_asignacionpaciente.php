<?php

class Ssan_hdial_asignacionpaciente extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Ssan_hdial_hojatratamiento_model");
        $this->load->model("Ssan_hdial_asignacionpaciente_model");
        $this->load->model("Ssan_hdial_eliminacionhojadiara_model");
        $this->load->model("Ssan_hdial_ingresoegresopaciente_model");
    }

    public function index() {
        $this->output->set_template('blank');
        $this->load->js("assets/ssan_hdial_asignacionpaciente/js/javascript.js");
        $this->load->js("assets/ssan_hdial_hojatratamiento/js/javascript_hd.js");
        $this->load->css("assets/ssan_hdial_asignacionpaciente/css/styles.css");
        $v_out = [];
        #$v_out['arr_maquinas']  = $this->Ssan_hdial_asignacionpaciente_model->ListadoMaquinasDialisis($empresa,$estados);
        $this->load->view("ssan_hdial_asignacionpaciente/ssan_hdial_asignacionpaciente_view",$v_out);
    }

    //***************************************************************************
    public function cargaEXAMENESanteriores(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        $empresa        =   $this->session->userdata("COD_ESTAB");
        $html           =   '';
        $num_fichae     =   $this->input->post("num_fichae");
        $nuevo          =   $this->input->post("nuevo");
        $imes           =   '';
        $year           =   '';
        $titulo         =   '';
        //BUSQUEDA SOLO DE GRANFO PACTADO
        $TABLA[]        =   array("id_html"   =>  "BODY_EXM_ANTERIORES",    "opcion"   =>  "html", "contenido"=> ''); 
        $TABLA[]        =   array("id_html"   =>  "TITULO_EXM_ANTERIORES",  "opcion"   =>  "html", "contenido"=> '');
        if($nuevo       == '1'){
            $mes        =   date("n"); 
            $rango      =   0; 
            $select     =   '';
            for($i=$mes; $i<=$mes+$rango; $i++){ 
                $mesano     =   "01-".date('m-Y',mktime(0,0,0,$i,1,date("Y")));
                $meses      =   date('m',        mktime(0,0,0,$i,1,date("Y")));
                $ano        =   date('Y',        mktime(0,0,0,$i,1,date("Y")));
                $select     .=  "<option value='01-12-2017'> MES: 12 / A&Ntilde;O: 2017</option><option value='$mesano' selected> MES: $meses / A&Ntilde;O: $ano</option>"; 
            } 
            $opcion	    =   '';
        //$fechamas	    =   strtotime('+17 month', strtotime('01-08-2019'));
        //$fechamas	    =   date('Y-m-j', $fechamas);
        $day	    =   date("d");
        $month	    =   date("m");
        $year	    =   date("Y");
        $fechamas	    =   date('Y-m-d');
        $fechamen	    =   '2016-12-01';
        for($i = $fechamen; $i <= $fechamas; $i = date("Y-m-d",strtotime($i."+ 1 months"))) {
        $selected   =	'';
        $fechae	    =	explode("-",$i);
        $mesano	    =	"01-" . date('m-Y', mktime(0, 0, 0, $fechae[1], 1, $fechae[0]));
        $meses	    =	date('m',mktime(0,0,0,$fechae[1],1,$fechae[0]));
        $ano	    =	date('Y',mktime(0,0,0,$fechae[1],1,$fechae[0]));
        if($month == $meses && $year == $ano){ $selected = 'selected'; }
        $opcion	    .=	"<option value='$mesano' $selected > MES: $meses / A&Ntilde;O: $ano</option>";
        }
            //******************************************************************
            //$select   =   '<b>SELECCIONE MES:<b> ';
            $select     =   '<div class="container">
                                <div class="col-lg-6" class="row justify-content-md-center">
                                    <div class="input-group my-group"> 
                                        <span class="input-group-btn">
                                            <button class="btn btn-default my-group-button" type="submit"><B>SELECCIONE MES</B></button>
                                        </span>
                                        <select style="width:200px;height:38px;" name="sel_busquedaMes" id="sel_busquedaMes" class="form-control input-sm" onchange="cargaCalendarioExamenes('.$num_fichae.')">'.$opcion.'</select>
                                    </div>
                                </div>
                            <div>';
                    
            $TABLA[]    =   array("id_html"=>"busquedaMes_EXM",  "opcion" => "append",  "contenido"=> $select); 
            $day        =   '01';
            $imes       =   date("m");
            $year       =   date("Y");
        } else {
            $MesWork    =   explode("-",$this->input->post("fecha"));
            $day        =   $MesWork[0];
            $imes       =   $MesWork[1];
            $year       =   $MesWork[2];
        }
        //**********************************************************************
        //$TABLA[]      =   array("id_html"=>"",  "opcion" => "console",  "contenido"=> $imes); 
        //$TABLA[]      =   array("id_html"=>"",  "opcion" => "console",  "contenido"=> $year); 
        $fecha          =   new DateTime($year."-".$imes."-".$day);
        $fecha->modify('last day of this month');
        $fechafin       =   $fecha->format('d-m-Y'); 
        $fecha->modify('first day of this month');
        $fechaini       =   $fecha->format('d-m-Y');
        $dias           =   array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
        $meses          =   array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha          =   $meses[$imes-1]. " del ".$year ;
        //$html.=
        //**********************************************************************
        $html           .=      '<div class="container">
                                    <ul role="tablist" class="nav nav-tabs">
                                        <li role="presentation" class="active">                 <a href="#CALENDARIO" data-toggle="tab">CALENDARIO</a></li>
                                        <li id="li_hoja_finalizadas2" style="display:none">     <a href="#CALENDARIO_PDF" data-toggle="tab">PDF</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="CALENDARIO" class="tab-pane active">
                                            <div id="TITULO_EXM_ANTERIORES"></div>
                                            <hr>
                                            '.$this->html_calendario($imes,$year).'
                                        </div>
                                        <div id="CALENDARIO_PDF" class="tab-pane">
                                            <div id="div_TERMINO_HOJADIARIAS"></div>
                                        </div>
                                    </div>
                                </div>';
        //**********************************************************************
        $TABLA[]            =   array("id_html"=>"BODY_EXM_ANTERIORES","opcion" =>"append","contenido"=> $html); 
        $titulo             =   '<div class="header">  <h4 class="title"><b>'.$fecha.'</b></h4>   <p class="category">Resumen de examenes solicitados por mes</p>  </div>';
        $TABLA[]            =   array("id_html"=>"TITULO_EXM_ANTERIORES","opcion" => "append","contenido"=>$titulo);
        $array              =   $this->ssan_hdial_asignacionpaciente_model->getbusquedaExamenes($fechaini,$fechafin,$empresa,$num_fichae); 
        //**********************************************************************
        if(count($array)>0){
            foreach ($array as $row){
                $onclick    =   'onclick="js_solicitudEXM(this.id,\''.$num_fichae.'\',\''.$row["FECHA"].'\')"';   
                $BTN        =   '<button type="button" id="btn_'.$row["FECHA"].'" class="btn btn-sm  btn-success btn-fill btn-wd"  data-placement="left"  data-toggle="popover" title="EXM FECHA '.$row["FECHA"].'" data-content="" '.$onclick.'>'
                                . '&nbsp;'.$row["FECHA"].'&nbsp;'
                                    . '<span class="badge">'
                                        . '<div id="num_'.$row["FECHA"].'">'.$row["NUM_EXAMENES"].'</i></div>'
                                    . '</span>'
                                . '</button>';
                $TABLA[]    = array("id_html" => "div_".$row["FECHA"],  "opcion" => "html",         "contenido"  => $BTN); 
            }
        }
        $this->output->set_output(json_encode($TABLA));
    }

public function verEXAMENESanteriores(){
    if(!$this->input->is_ajax_request()) { show_404();   }
    $empresa    = $this->session->userdata("COD_ESTAB");
    $HTML       ='';
    $numfichae  = $this->input->post('numfichae');
    $fecha      = $this->input->post('fecha');
    $array      = $this->ssan_hdial_asignacionpaciente_model->sqlbusquedanombreexamen($fecha,$fecha,$empresa,$numfichae);
    $HTML.='
        <table class="table table-sm">
            <thead class="thead-inverse">
                <tr>
                  <th>#</th>
                  <th>NOMBRE EXAMENE (CODIGO)</th>
                  <th>ID</th>
                  <th>-</th>
                </tr>
            </thead><tbody>';
    if (count($array)>0){
        foreach ($array as $i => $r){
            $HTML.='<tr>
                    <th scope="row">'.($i+1).'</th>
                        <td>'.$r['DES_EXAMEN'].' '.$r['COD_EXAM_CSBT'].' </td>
                        <td>'.$r['EI_ID_ESTINDI'].'</td>
                        <td>-</td>
                    </tr>
            ';
        }
    } else {
      $HTML.='</tbody>
            <tbody>
                <tr>
                    <th scope="row" colspan="3"> SIN INFORMACI&Oacute;N</th>
                </tr>       
            </tbody>
        </table>'; 
    }     
    $this->output->set_output($HTML);
}

public function cargaHDanteriores(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $empresa        =   $this->session->userdata("COD_ESTAB");
    $num_fichae     =   $this->input->post("num_fichae");
    $nuevo          =   $this->input->post("nuevo");
    $html           =   '';
    $imes           =   '';
    $year           =   '';
    $titulo         =   '';
    #BUSQUEDA SOLO DE GRANFO PACTADO
    $TABLA[]        =   array("id_html"   =>  "BODY_HD_ANTERIORES",    "opcion"   =>  "html", "contenido"=> ''); 
    $TABLA[]        =   array("id_html"   =>  "TITULO_HD_ANTERIORES",  "opcion"   =>  "html", "contenido"=> '');
    if($nuevo      == '1'){
        $mes        =   date("n"); 
        $rango      =   0; 
        $select     =   '';
        for($i=$mes; $i<=$mes+$rango; $i++){ 
            $mesano  =  "01-".date('m-Y',mktime(0,0,0,$i,1,date("Y")));
            $meses   =  date('m',        mktime(0,0,0,$i,1,date("Y")));
            $ano     =  date('Y',        mktime(0,0,0,$i,1,date("Y")));
            $select.=   "<option value='01-12-2017'> MES: 12 / A&Ntilde;O: 2017</option><option value='$mesano' selected> MES: $meses / A&Ntilde;O: $ano</option>"; 
        } 
        //$select   = '<b>SELECCIONE MES:<b> ';
        
    $opcion	        =   '';
    #$fechamas	    =   strtotime('+17 month', strtotime('01-08-2019'));
    #$fechamas	    =   date('Y-m-j', $fechamas);
    $day	        =   date("d");
    $month	        =   date("m");
    $year	        =   date("Y");
    $fechamas	    =   date('Y-m-d');
    $fechamen	    =   '2016-12-01';
    for($i = $fechamen; $i <= $fechamas; $i = date("Y-m-d",strtotime($i."+ 1 months"))) {
    $selected       =	'';
    $fechae	        =	explode("-",$i);
    $mesano	        =	"01-" . date('m-Y', mktime(0, 0, 0, $fechae[1], 1, $fechae[0]));
    $meses	        =	date('m',mktime(0,0,0,$fechae[1],1,$fechae[0]));
    $ano	        =	date('Y',mktime(0,0,0,$fechae[1],1,$fechae[0]));

    if($month == $meses && $year == $ano){ $selected = 'selected'; }
        $opcion	    .=	"<option value='$mesano' $selected > MES: $meses / A&Ntilde;O: $ano</option>";
    }
    
        $select      = '<div class="container">
                            <div class="col-lg-6" class="row justify-content-md-center">
                                <div class="input-group my-group"> 
                                    <span class="input-group-btn">
                                        <button class="btn btn-default my-group-button" type="submit"><B>SELECCIONE MES</B></button>
                                    </span>
                                    <select style="width: 200px;height: 38px;" name="sel_busquedaMes" id="sel_busquedaMes" class="form-control input-sm" onchange="cargaCalendario('.$num_fichae.')">'.$opcion.'</select>
                                </div>
                            </div>
                        <div>';
        
        $TABLA[]    = array("id_html"=>"busquedaMes",  "opcion" => "append",  "contenido"=> $select); 
        $day        = '01';
        $imes       = date("m");
        $year       = date("Y");
    } else {
        $MesWork    = explode("-",$this->input->post("fecha"));
        $day        = $MesWork[0];
        $imes       = $MesWork[1];
        $year       = $MesWork[2];
    }
    //$TABLA[]      = array("id_html"=>"",  "opcion" => "console",  "contenido"=> $imes); 
    //$TABLA[]      = array("id_html"=>"",  "opcion" => "console",  "contenido"=> $year); 
    $fecha          =   new DateTime($year."-".$imes."-".$day);
    $fecha->modify('last day of this month');
    $fechafin       =   $fecha->format('d-m-Y'); 
    $fecha->modify('first day of this month');
    $fechaini       =   $fecha->format('d-m-Y');
    $dias           =   array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
    $meses          =   array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha          =   $meses[$imes-1]. " del ".$year ;
    //$html.=
    
    $html.='
            <div class="container">
                <ul role="tablist" class="nav nav-tabs">
                    <li role="presentation" class="active">
                        <a href="#CALENDARIO" data-toggle="tab">CALENDARIO</a>
                    </li>
                    <li id="li_hoja_finalizadas2" style="display:none">
                        <a href="#CALENDARIO_PDF" data-toggle="tab">PDF</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="CALENDARIO" class="tab-pane active">
                        <div id="TITULO_HD_ANTERIORES"></div>
                        <hr>
                        '.$this->html_calendario($imes,$year).'
                    </div>
                    <div id="CALENDARIO_PDF" class="tab-pane">
                        <div id="div_TERMINO_HOJADIARIAS"></div>
                    </div>
                </div>
            </div>
            ';
    $TABLA[]            = array("id_html"=>"BODY_HD_ANTERIORES",        "opcion" => "append",  "contenido"=> $html); 
    $titulo             = '<div class="header">
                                <h4 class="title"><b>'.$fecha.'</b></h4>
                                <p class="category">Resumen de hojas diarias de hemodi&aacute;lisis</p>
                            </div>';
    
    $TABLA[]            = array("id_html"=>"TITULO_HD_ANTERIORES","opcion" => "append","contenido"=>$titulo);
    $array              = $this->ssan_hdial_asignacionpaciente_model->getbusquedadecuposporagendahd($fechaini,$fechafin,$empresa,$num_fichae); 
    if(count($array)>0){
        foreach ($array as $row){
            $onclick    =   'onclick="js_pdfHTML2(\''.$row["ID_TDHOJADIARIA"].'\')"';   /* "onclick='js_irdia(\''".$row["FECHA"]."'\')"; */ 
            $BTN        =   '<button class="btn btn-sm btn-success btn-fill btn-wd" type="button" id="btn_'.$row["FECHA"].'" '.$onclick.'>'
                            . '&nbsp;'.$row["FECHA"].'&nbsp;'
                                . '<span class="badge">'
                                    . '<div id="num_'.$row["FECHA"].'"><i class="fa fa-wpforms" aria-hidden="true"></i></div>'
                                . '</span>'
                            . '</button>';
            $TABLA[]    = array("id_html" => "div_".$row["FECHA"],  "opcion" => "html",         "contenido"  => $BTN); 
        }
    }
    $this->output->set_output(json_encode($TABLA));
}

public function cargaHDanteriores2(){
    if (!$this->input->is_ajax_request()) { show_404(); }
    $TABLA[]            = array("id_html" => "HTML_CALENDARIO",  "opcion" => "html" , "contenido"  => ''); 
    $MesWork            = explode("-",$this->input->post("fecha"));
    $views              = $this->input->post("views");
    $html               = '';
    $BTN                = '';
    $onclick            = '';
    $day                = $MesWork[0];
    $month              = $MesWork[1];
    $year               = $MesWork[2];
    $array              = [];
    $fecha              = new DateTime($year."-".$month."-".$day);
    $fecha->modify('last day of this month');
    $fechafin           =  $fecha->format('d-m-Y'); 
    $fecha->modify('first day of this month');
    $fechaini           = $fecha->format('d-m-Y');
    $dias               = array("Domingo",  "Lunes",    "Martes",   "Miercoles",    "Jueves",   "Viernes",  "Sabado");
    $meses              = array("Enero",    "Febrero",  "Marzo",    "Abril",        "Mayo",     "Junio",    "Julio",    "Agosto",   "Septiembre",   "Octubre",  "Noviembre",    "Diciembre");
    $fecha              = $meses[$month-1]. " del ".$year ;
    $html.='<h3><b>'.$fecha.'</b></h3>';
    $html.='<hr>';
    $html.=$this->draw_calendar2($month,$year,'','','');
    $html.='<hr>';
    $TABLA[]            = array("id_html" => "HTML_CALENDARIO",  "opcion" => "append" , "contenido"  => $html); 
    $empresa            = $this->session->userdata("COD_ESTAB");
    $array              = $this->ssan_spab_listaprotocoloqx_model->getbusquedadecuposporagenda($fechaini,$fechafin,$empresa); 
    if(count($array)>0){
        foreach ($array as $row){
            if ($views == '2'){
                $onclick    = 'onclick="js_irdia(\''.$row["FECHA"].'\','.$row["NUM_ACTIVIDAS"].')"';   /* "onclick='js_irdia(\''".$row["FECHA"]."'\')"; */ 
            } else {
                $onclick    = 'onclick="js_irdia(\''.$row["FECHA"].'\','.$row["NUM_ACTIVIDAS"].')"';   /* "onclick='js_irdia(\''".$row["FECHA"]."'\')"; */ 
            }
            $BTN            =   '<button class="btn btn-success" type="button" id="btn_'.$row["FECHA"].'" '.$onclick.'>'
                                . '&nbsp;'.$row["FECHA"].'&nbsp;'
                                    . '<span class="badge">'
                                        . '<div id="num_'.$row["FECHA"].'">'.$row["NUM_ACTIVIDAS"].'</div>'
                                    . '</span>'
                                . '</button>';
            $TABLA[]        = array("id_html" => "div_".$row["FECHA"],  "opcion" => "html",         "contenido"  => $BTN); 
        }
    }
    $this->output->set_output(json_encode($TABLA));
}

function html_calendario($month,$year){
    $headings           = array('<b>DOMINGO</b>','<b>LUNES</b>','<b>MARTES</b>','<b>MIERCOLES</b>','<b>JUEVES</b>','<b>VIERNES</b>','<b>SABADO</b>');
    $strto_hoy          = strtotime(date("d-m-Y"));
    $calendar           = '';
    if($month<10)       { $month = sprintf("%02d", $month); } 
    $running_day        = date('w',mktime(0,0,0,$month,1,$year));
$days_in_month      = date('t',mktime(0,0,0,$month,1,$year));
    $days_in_this_week  = 1;
$day_counter        = 0;

    $calendar.='<div class="container-fluid">';
    $calendar.='<div class="card">';
    $calendar.='<table class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" style="width:100%;height:100%">';
    $calendar.='<tr class="calendar-row"><td class="success" style="width:14%;text-align:center">'.implode('</td><td class="success" style="width:14%;text-align:center">',$headings).'</td></tr>';
    $calendar.='</table>';
    //$calendar.='<hr>';
    $calendar.='<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0" style="width:100%;height:100%">';
    $calendar.='<tr class="calendar-row">';
    for($x = 0; $x < $running_day; $x++){  
            $calendar.='<td class="calendar-day-np"></td>';  
            $days_in_this_week++; 
    }
    
    for($list_day = 1; $list_day <= $days_in_month; $list_day++){
            $calendar.='<td class="calendar-day" style="width:14%;height: 44px;text-align:center">';
        //$calendar.='<div class="day-number">'.$list_day.'</div>';
        if($list_day<10){ $list_day = sprintf("%02d", $list_day);  }
            $fecha          = $list_day."-".$month."-".$year;
            $stone_cale     = strtotime($fecha);
                  $calendar.='<div id="div_'.$fecha.'"><b>'.$fecha.'</b></div>';    
            $calendar.= '</td>';
        if($running_day == 6){
            $calendar.= '</tr>';
            if(($day_counter+1) != $days_in_month){ 
            $calendar.= '<tr class="calendar-row">'; 
            }
            $running_day        =-1;
            $days_in_this_week  = 0;
        }
        $days_in_this_week++; 
        $running_day++; 
        $day_counter++;
    }
    
    $calendar.= '';
    if($days_in_this_week<8){   for($x=1;$x<=(8-$days_in_this_week);$x++){ $calendar.= '<td class="calendar-day-np"> </td>';  }  }
    $calendar.='</tr>';
$calendar.='</table>';
    $calendar.='</div>';/* card */
    $calendar.='</div>';/* conteiner */
return $calendar;
}

public function cargaMaquinas(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $empresa            =   $this->session->userdata("COD_ESTAB");
    $html               =   '';
    $estados            =   1;
    //104 - traguen
    //107 - curacautin
    $select             =   '';
    if($empresa         ==  '100'){
        $TABLA[]        =   array("id_html"=>"fecha_especial","opcion" =>"show","contenido"=>""); 
        $select         =   '<option value="">SELECCIONE ... </option><option value="10-11-2018"> 10-11-2018</option> ';
        //$TABLA[]      =   array("id_html"=>"op_fecha_especial","opcion" =>"append","contenido"=>$select); 
    }
    $aData      = $this->ssan_hdial_asignacionpaciente_model->ListadoMaquinasDialisis($empresa, $estados);
    if(count($aData)>0){
        foreach ($aData as $row){
            $html       =   '<option value="'.$row['ID'].'"> '.$row['NOMDIAL'].' </option>';
            $TABLA[]    =   array("id_html"=>"num_Maquina",  "opcion" => "append",  "contenido"=> $html); 
        }
    } else {
        $html           .=  '<option value="0"> SIN MAQUINAS ...</option>';
        $TABLA[]        =   array("id_html"=>"num_Maquina",  "opcion" => "append",  "contenido"=> $html); 
    }
    $TABLA[]            =  array("id_html"=>"num_Maquina",  "opcion" => "console",  "contenido"=> $empresa); 
    $this->output->set_output(json_encode($TABLA));
}

public function HtmlNuevoPaciente(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $empresa            =   $this->session->userdata("COD_ESTAB");
    $fecha_lb           =   '';
    $hrsStar            =   '';
    $hrsEnd             =   '';
    $fecha1             =   '';
    $fecha2             =   '';
    $fechaHrs           =   '';
    $numFichae          =   '';
    $rutPac             =   '';
    $type               =   $this->input->post("type");
    $MesWork            =   explode("#",$this->input->post("MesWork"));
    
    //$TABLA[]          =   array("id_html"=>"PDF_DIALISIS","opcion" => "console","contenido"=> $type); 
    if($type == 'month'){
        $fecha1         =   explode("-",$this->input->post("start"));
        $fecha_lb       =   $fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0];
      //$TABLA[]        =   array("id_html"=>"PDF_DIALISIS","opcion" => "console","contenido"=> $fecha_lb); 
    } else {
        /*
        $fechaHrs       = explode("T",$this->input->post("start"));
        $fecha1         = explode("-",$fechaHrs[0]);
        $fechaHrs2      = explode("T",$this->input->post("end"));
        $hrsStar        = explode(":",$fechaHrs2[0]);
        $hrsEnd         = explode(":",$fechaHrs2[1]);
        */
    }
    
    //$TABLA[]          = array("id_html"=>"PDF_DIALISIS","opcion" => "console","contenido"=> "MES ->".$MesWork[0]); 
    //$TABLA[]          = array("id_html"=>"PDF_DIALISIS","opcion" => "console","contenido"=> $MesWork[1]); 
    
    $estados            = '1';
    $aData              = $this->ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDial($empresa,$estados,$numFichae,$rutPac);
    //Busqueda de pacientes que no tengan cita en el dia....
    $html ='    <form method="get" action="#" class="form-horizontal" id="nuevoDialisis" name="nuevoDialisis" >
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">NOMBRE DEL PACIENTE</label>
                            <div class="col-sm-8">
                                <select id="idPaciente" name="idPaciente" class="form-control">
                                    <option value="0"> Seleccione ...</option>';
                                    if (count($aData)>0){
                                        foreach ($aData as $row){
                                            $html.='<option value="'.$row['ID_INGRESO'].'#'.$row['NUM_FICHAE'].'"> '.$row['NOM_APELLIDO'].' </option>';
                                        }
                                    } else {
                                        $html.='<option value="0">  SIN PACIENTES ...</option>';
                                    }
    $html.='                    </select>   
                            </div>
                        </div>
                    </fieldset>
                    <hr>';
    $html.=$this->draw_calendar2($MesWork[0],$MesWork[1],'','','');
    $html.='        <hr>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">HORA INICIO</label>
                            <div class="col-sm-8">
                                <input type="time" class="form-control" id="hr_inicio" name="hr_inicio" style="width: 28%;" value="'.$hrsStar.'">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">HORA FINAL</label>
                            <div class="col-sm-8">
                                <input type="time" class="form-control" id="hr_final" name="hr_final" style="width: 28%;" value="'.$hrsEnd.'">
                            </div>
                        </div>
                    </fieldset>
                </form>
                ';
    $TABLA[]    = array("id_html"=>"PDF_DIALISIS","opcion" => "append","contenido"=> $html); 
    $this->output->set_output(json_encode($TABLA));
}

function draw_calendar2($month,$year,$act,$numCale,$cod_rutpro){
    $headings           = array('<b>DOMINGO</b>','<b>LUNES</b>','<b>MARTES</b>','<b>MIERCOLES</b>','<b>JUEVES</b>','<b>VIERNES</b>','<b>SABADO</b>');
    $strto_hoy          = strtotime(date("d-m-Y"));
    $calendar           = '';
    if($month<10)       { $month = sprintf("%02d", $month);  } 
    $running_day        = date('w',mktime(0,0,0,$month,1,$year));
    $days_in_month      = date('t',mktime(0,0,0,$month,1,$year));
    $days_in_this_week  = 1;
    $day_counter        = 0;
    //**********************************************************************************************
    $calendar.='<div class="container-fluid">';
    $calendar.='<div class="card">';
    $calendar.='<table cellpadding="0" cellspacing="0" class="calendar" style="width:100%;height:100%">';
    $calendar.='<tr class="calendar-row"><td class="calendar-day-head" style="width:14%;text-align:center">'.implode('</td><td class="calendar-day-head" style="width:14%;text-align:center">',$headings).'</td></tr>';
    $calendar.='</table>';
    $calendar.='<hr>';
    $calendar.='<table cellpadding="0" cellspacing="0" class="calendar" style="width:100%;height:100%">';
    $calendar.='<tr class="calendar-row">';
    for($x = 0; $x < $running_day; $x++){  $calendar.='<td class="calendar-day-np"> </td>';  $days_in_this_week++;  }
    for($list_day = 1; $list_day <= $days_in_month; $list_day++){
        $calendar.='<td class="calendar-day" style="text-align:center">';
        //$calendar.='<div class="day-number">'.$list_day.'</div>';
        if ($list_day<10){ $list_day = sprintf("%02d", $list_day);  }
        $fecha          = $list_day."-".$month."-".$year;
        $stone_cale     = strtotime($fecha);
        if ($strto_hoy<$stone_cale){
        $calendar.='<div class="card">'
                    . '<input type="checkbox" id="f_'.$fecha.'" name="f_'.$fecha.'" value="'.$fecha.'" onClick="js_modificaCitas()"><label for="f_'.$fecha.'"><span></span></label> '
                    . '<br>'
                    . '<span class="label label-primary">'.$fecha.'</span>'
                    . '</div>';
        } else {
        $calendar.='<div class="card">'
                    . '<input type="checkbox" id="n_'.$fecha.'" name="n_'.$fecha.'" value="'.$fecha.'" disabled><label for="ns_'.$fecha.'"><span></span></label> '
                    . '<br>'
                    . '<span class="label label-danger">'.$fecha.'</span>'
                    . '</div>';
        }
        $calendar.= '</td>';
        if($running_day == 6){
                $calendar.= '</tr>';
            if(($day_counter+1)!= $days_in_month){ $calendar.= '<tr class="calendar-row">'; }
            $running_day        =-1;
            $days_in_this_week  = 0;
        }
        $days_in_this_week++; 
        $running_day++; 
        $day_counter++;
    }
    $calendar.= '';
    if($days_in_this_week<8){ for($x=1;$x<=(8-$days_in_this_week);$x++){ $calendar.= '<td class="calendar-day-np"> </td>';  }  }
    $calendar.='</tr>';
$calendar.='</table>';
    $calendar.='</div>';/* card */
    $calendar.='</div>';/* conteiner */
return $calendar;
}

public function cargaCalendarioPacientes() {
    if (!$this->input->is_ajax_request()) { show_404(); }
    $empresa                        = $this->session->userdata("COD_ESTAB");
    $EVENTOS                        = '';
    $numFichae                      = '';
    $rutPac                         = '';
    $month                          = '';
    $year                           = '';
    $running_day                    = '';
    $days_in_month                  = '';
    //$ind_template                 = ;
    $num_Maquina                    = $this->input->post("num_Maquina");
    if(!$this->input->post("ind_template") =='1'){
        $MesWork                    = explode("#",$this->input->post("MesWork"));
        $month                      = $MesWork[0];
        $year                       = $MesWork[1];
        $running_day                = date('w',mktime('0','0','0',$month,'1',$year));
        $days_in_month              = date('t',mktime('0','0','0',$month,'1',$year));
        $fecha_desde                = '01-10-2017';    
        $fecha_hasta                = $days_in_month.'-10-2017'; 
    } else {
        $fecha_desde                = $this->input->post("fecha");
        $fecha_hasta                = $this->input->post("fecha");
    } 
    $estados                        = '1';
    $aData                          = $this->ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDialxMaquina($empresa,$estados,$numFichae,$rutPac,$num_Maquina,$fecha_desde,$fecha_hasta);
    if(count($aData)>0){
        foreach ($aData as $row){
            $EVENTOS[]              = array(
                "id"                => $row["NUM_BLOQUE"],
                "title"             => $row["NOMPAC"],
                "start"             => $row["TXTFULLCALENDARINICIO"],
                "end"               => $row["TXTFULLCALENDARFINAL"],
                "className"         => "event-green",
            );
        }   
        $this->output->set_output(json_encode($EVENTOS));
    } else{
        $this->output->set_output(json_encode([]));   
    }
}

public function cargaCalendarioPacientesHT() {
    if (!$this->input->is_ajax_request()) { show_404(); }
    $empresa                        =   $this->session->userdata("COD_ESTAB");
    $EVENTOS                        =   '';
    $numFichae                      =   '';
    $rutPac                         =   '';
    $month                          =   '';
    $year                           =   '';
    $running_day                    =   '';
    $days_in_month                  =   '';
    $numVisitas                     =   '0';
  //$ind_template                   =   '';
    $num_Maquina                    =   $this->input->post("num_Maquina");
    $date                           =   explode("-",$this->input->post("fecha"));
    $fechaBusqueda                  =   $this->input->post("fecha");
    $templete                       =   $this->input->post("templete");
    if(!$this->input->post("ind_template")=='1'){
        $MesWork                    =   explode("#",$this->input->post("MesWork"));
        $month                      =   $MesWork[0];
        $year                       =   $MesWork[1];
        $running_day                =   date('w',mktime('0','0','0',$month,'1',$year));
        $days_in_month              =   date('t',mktime('0','0','0',$month,'1',$year));
        $fecha_desde                =   '01-12-2017';    
        $fecha_hasta                =   $days_in_month.'-12-2017'; 
    } else {
        $fecha_desde                =   $this->input->post("fecha");
        $fecha_hasta                =   $this->input->post("fecha");
    } 
    $TABLA[]                        =   array("id_html"=>"maquina_1","opcion" => "html","contenido"=> "");
    
   //$estados                       =   '1';
   //$aData                         =   $this->ssan_hdial_asignacionpaciente_model->ModelbusquedaListadoPacienteHDialxMaquina($empresa,$estados,$numFichae,$rutPac,$num_Maquina,$fecha_desde,$fecha_hasta);
   //$aData                         =   $this->ssan_hdial_asignacionpaciente_model->getbusquedaListadoPacienteHDxMaquinaCAdmision($empresa,$num_Maquina,$fechaBusqueda);
   //$aData                         =   $this->ssan_hdial_asignacionpaciente_model->proBusquedaHoradiaria($empresa,$fecha_hasta,$num_Maquina); 
    $aData                          =   $this->ssan_hdial_asignacionpaciente_model->proBusquedaHoradiaria_profActvNuevaAgenda($empresa,$fecha_hasta,$num_Maquina);
    if(count($aData)>0){
        foreach($aData as $row){
            $btn                    =   '';
            $msj                    =   '';
            $input                  =   '';
            $txtHr                  =   $row['HRS_INICIO'];
            $AD_ID_ADMISION         =   $row['AD_ADMISION']; 
            $ID_TDHOJADIARIA        =   $row['ID_TDHOJADIARIA']; 
            $AD_CIERRE              =   $row['AD_CIERRE']; 
            $NUM_FICHAE             =   $row['NUMFICHAE']; 
            $HD_ESTADO              =   $row['CIERREHD'];
            //$F_LOCAL              =   $row['F_LOCAL'];  
            if($AD_ID_ADMISION  == ''){
                    //  cambio 04.04.2020
                    if ($templete == '1' or $templete == '3'){
                        $btn.='<span class="badge bg-primary">               <i class="fa fa-times" aria-hidden="true"></i> NO INICIADO</span>';
                    } else {
                        $btn.='<button class="btn btn-primary btn-fill btn-wd"  onclick="js_primeraDatosProgramacion('.$row["NUMFICHAE"].')"> INICIO <br> PROGRAMACI&Oacute;N </button>';
                    }
                        $msj = '<span class="badge bg-primary">              <i class="fa fa-times" aria-hidden="true"></i> NO INICIADO</span>';
            } else {
                //cambio 04.04.2020
                if ($templete == '3'){
                    if ($AD_CIERRE== ''){
                        $msj                 =   '<span class="label label-info">      <i class="fa fa-cog" aria-hidden="true"></i>EN PROCESO</span>';
                    } else {
                        if(($HD_ESTADO == 1)or($HD_ESTADO == '')){
                            $msj             =   '<span class="label label-success">   <i class="fa fa-check" aria-hidden="true"></i>FINALIZADO</span>';  
                        } else {
                            $msj             =   '<span class="label label-warning">   <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>FALTA CIERRE MEDICO</span>'; 
                        }
                    }
                    $btn                    .=  '<button class="btn btn-danger btn-fill btn-wd"   onclick="js_eliminahoja('.$row["NUMFICHAE"].','.$AD_ID_ADMISION.','.$ID_TDHOJADIARIA.')"> ELIMINAR HOJA <br> HEMODI&Aacute;LISIS</button>';
                } else {
                    if ($AD_CIERRE== ''){
                        $btn.='<button class="btn btn-info btn-fill btn-wd"         onclick="js_inicioProgama('.$row["NUMFICHAE"].','.$AD_ID_ADMISION.','.$ID_TDHOJADIARIA.',0)"> HOJA TRAT.<br> HEMODI&Aacute;LISIS</button>';
                        $msj                = '<span class="label label-info">      <i class="fa fa-cog" aria-hidden="true"></i> EN PROCESO</span>';
                        $input              = '';
                    } else {
                        if(($HD_ESTADO == 1)or($HD_ESTADO == '')){
                        $msj                = '<span class="label label-success">   <i class="fa fa-check" aria-hidden="true"></i> FINALIZADO</span>';  
                        $btn                .='<button class="btn btn-danger btn-fill btn-wd"       onclick="js_pdfHTML('.$ID_TDHOJADIARIA.')"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF <br> HEMODIALISIS</button>';
                        } else {
                        $msj                = '<span class="label label-warning">   <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>FALTA CIERRE MEDICO</span>'; 
                            if ($templete == '1'){
                                $btn        .='<button class="btn btn-info btn-fill btn-wd"     onclick="js_inicioProgama('.$row["NUMFICHAE"].','.$AD_ID_ADMISION.','.$ID_TDHOJADIARIA.',3)">HOJA TRAT.<br> HEMODIALISIS</button>';    
                            } else {
                                $btn        .='<button class="btn btn-danger btn-fill btn-wd"   onclick="js_pdfHTML('.$ID_TDHOJADIARIA.')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF <br> HEMODIALISIS</button>';    
                            }
                        }
                    }
                }
            }
    
            #########################################################################
            $arr_row        =   htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');
            $txt_cumpleanos =   $row["IND_AYER"] == 1 ?'<br><span class="label label-warning"><i class="fa fa-birthday-cake" aria-hidden="true"></i>&nbsp;FELIZ CUMPEA&Ntilde;OS</span>':''; 
            $html           =   '  
                                <tr 
                                    id              =   "hd_'.$ID_TDHOJADIARIA.'" 
                                    style           =   "height:90px;" 
                                    >
                                    <td scope="row" class="text-center">
                                        '.$txtHr.'
                                        <input type="hidden" id="AD_ID_ADMISION"            name="AD_ID_ADMISION"               value="'.$AD_ID_ADMISION.'"/>
                                        <input type="hidden" id="AD_CIERRE"                 name="AD_CIERRE"                    value="'.$AD_CIERRE.'"/>
                                        <input type="hidden" id="name_'.$ID_TDHOJADIARIA.'" name="name_'.$ID_TDHOJADIARIA.'"    value="'.$row["NOMPAC"].'"/> 
                                        <div class="hoja_'.$ID_TDHOJADIARIA.' num_fichae_'.$row["NUMFICHAE"].'" data-row="'.$arr_row.'"></div>
                                    </td>
                                    <td>
                                        '.$row["NOMPAC"].'&nbsp;<b>('.$row["RUTPAC"].')</b>&nbsp; 
                                        '.$input.'
                                    </td>
                                    <td>
                                        '.$row["NACIMIENTO"].' '.$txt_cumpleanos.'
                                    </td>
                                    <td class="text-center">'.$ID_TDHOJADIARIA.'</td>
                                    <td>'.$msj.'</td>
                                    <td class="text-center"><div class="content">'.$btn.'</div></td>
                                </tr>
                                ';
            $TABLA[]        =   array("id_html"=>"maquina_1","opcion" => "append",    "contenido"=> $html);   
        }
    } else{
            $txtMenjaje=    '<div class="alert alert-danger">
                                <strong>  <i class="fa fa-user-times" aria-hidden="true"></i> SIN PACIENTE </strong> No se han encontrados pacientes en el turno y m&aacute;quina para el d&iacute;a seleccionado 
                            </div> 
                            ';
            $TABLA[]        = array("id_html"=>"maquina_1","opcion"=>"append","contenido"=>"<tr><td colspan='6'>$txtMenjaje</td></tr>");   
    }
    $this->output->set_output(json_encode($TABLA));
}

public function busquedaNuevosVitales(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $IDHOJADIARIA           = $this->input->post("IDHOJADIARIA");
    $dataVit                = $this->ssan_hdial_asignacionpaciente_model->getDatosSignosVitales($IDHOJADIARIA,'');
    $htmlVit                = '';
    $TABLA[]                = array("id_html"=>"htmlSignosvitales","html" => "append","contenido"=> ''); 
    if(count($dataVit)>0){
        foreach ($dataVit as $row){
            $htmlVit    ='<tr id="txtPulso" style="height: 40px;">
                            <td scope="row">'.$row['HORA'].'</td>
                            <td style="text-align:center">'.$row['NUM_PARTERIAL'].'</td>
                            <td style="text-align:center">'.$row['NUM_PULSO'].'</td>
                            <td style="text-align:center">'.$row['NUM_TMONITOR'].'</td>
                            <td style="text-align:center">'.$row['NUM_TPACIENTE'].'</td>    
                            <td style="text-align:center">'.$row['NUM_QBPROG'].'</td>
                            <td style="text-align:center">'.$row['NUM_QBEFEC'].'</td>
                            <td style="text-align:center">'.$row['NUM_PA'].'</td>
                            <td style="text-align:center">'.$row['NUM_PV'].'</td>
                            <td style="text-align:center">'.$row['NUM_PTM'].'</td>
                            <td style="text-align:center">'.$row['NUM_COND'].'</td>
                            <td style="text-align:center">'.$row['NUM_UFH'].'</td>
                            <td style="text-align:center">'.$row['NUM_UFACOMULADA'].'</td>
                            <td ><font size="0.5px">'.$row['TXT_INGRESO'].'</font></td>
                            <td ><font size="0.5px">'.$row['TXTOBSERVACIONES'].'</font></td>';
            if($row['IND_TOMASIGNO'] == '2'){
             $htmlVit.='<td> <button type="button" class="btn btn-default btn-xs" onclick="js_eliminaSV('.$row['ID'].','.$IDHOJADIARIA.')"> <i class="fa fa-ban" aria-hidden="true"></i></button> </td>';
            } else {
             $htmlVit.='<td></td>';
            }
            $htmlVit.='</tr>'; 
            $TABLA[]    = array("id_html"=>"htmlSignosvitales","opcion" => "append","contenido"=> $htmlVit); 
        }
    } else {
        $htmlVit        ='<tr><th scope="row">SIN DATOS</th>';
        $TABLA[]        = array("id_html"=>"htmlSignosvitales","opcion" => "append","contenido"=> $htmlVit); 
    }
    $this->output->set_output(json_encode($TABLA)); 
}


public function cargahtmlcarga(){
    if(!$this->input->is_ajax_request()){ show_404();}
    $empresa                    =   $this->session->userdata("COD_ESTAB");
    $numfichae                  =   $this->input->post("NUMFICHAE");
    #PREGUNTAR SI TIENE YA YIENE UNA HOJA ACTIVA
    $date                       =   date("d-m-Y");
    $DATA_HOJA                  =   $this->Ssan_hdial_eliminacionhojadiara_model->al_dia_hojaactiva($numfichae,$date);
    if(count($DATA_HOJA)>0){
        $TABLA[]                =   array("id_html"=>'',  "opcion" => "console",  "contenido"=> "SI TIENE HOJA EL DIA DE HOY");
        $ADMISION_ACTIVA        =   false;
        foreach ($DATA_HOJA as $i => $row){
            if ($row['ADMISION_ACTIVA']!=''){
                $ADMISION_ACTIVA        =   true;
                $TABLA[]                =   array("id_html"=>'',  "opcion" => "jAlert",  "contenido"=> "El paciente ya se realiz&oacute; inicio de programaci&oacute;n");
                $this->output->set_output(json_encode(array(
                                'STATUS'    =>  false,
                                'TABLA'     =>  $TABLA,
                            ))); 
                return false;
            }
        }
    } else {
        $TABLA[]                =   array("id_html"=>'',  "opcion" => "console",  "contenido"=> "NOOO -> al_dia_hojaactiva");
    }

    //**********************************************************************
    $NUM_PESOSECO               =   '';
    $aData                      =   $this->Ssan_hdial_asignacionpaciente_model->sqlInformacionComplementariaPesoSeco($empresa,$numfichae);  
    if(count($aData)>0){    
    $NUM_PESOSECO               =   $aData[0]["NUM_PESOSECO"];  }
    $TABLA[]                    =   array("id_html"=>"HTML_INICIODEDIALISIS","opcion" => "html","contenido"=>$this->htmlINICIOPROGRAMACION($NUM_PESOSECO));
    #$aData                      =   $this->ssan_hdial_asignacionpaciente_model->profActvNuevaAgenda($empresa);
    $aData                      =   $this->Ssan_hdial_asignacionpaciente_model->profActvNuevaAgenda_por_mantenedor($empresa);
    if(count($aData)>0){
        foreach ($aData as $row){
            $id_HTML            =   '';
                    if ($row['IND_TIPOATENCION'] == '01' || $row['IND_TIPOATENCION'] == '15'){
                $id_HTML        = 'slc_medico';
            } else  if ($row['IND_TIPOATENCION'] == '02'){
                $id_HTML        = 'slc_enfermeria';
            } else  if ($row['IND_TIPOATENCION'] == '12'){
                $id_HTML        = 'slc_tecpara';
            }
            $html               =   '<option value="'.$row['COD_RUTPRO'].'"> '.$row['NOM_PROFE'].' </option>';
            $TABLA[]            =   array("id_html"=>$id_HTML,  "opcion" => "append",  "contenido"=> $html);
        }
    }
    
    $this->output->set_output(json_encode(array(
        'STATUS'    =>  true,
        'TABLA'     =>  $TABLA,
    ))); 
}





public function htmlINICIOPROGRAMACION($NUM_PESOSECO){
    #onKeyPress="return num_coma(event, this)"
    #a la tade 16.04.2024

    $html ='
        <div class="grid_primera_programacion">
            <div class=" card grid_primera_programacion1" style="margin-bottom: 0px">
                <div class="" style="margin-bottom: 0px">

                    <div class="header"  style="margin: 12px 0px 0px 12px;">
                        <h4 class="title"><b>HORA, DATOS DE PROGRAMACI&Oacute;N</b></h4>
                        <p class="category"> (*) Informaci&oacute;n no obligatoria</p>
                    </div>

                    <form id="formulario_histo" name="formulario_histo">
                        <div class="contenedor">
                            <div class="form-group">
                                <label for="txtHoraIngresoPre"><b>HR CONEXI&Oacute;N</b></label>
                                <input type="time" class="form-control" id="txtHoraIngresoPre" name="txtHoraIngresoPre" style="width:auto;">
                            </div>
                            <div class="form-group">
                                <label for="input_pesoSeco"><b>PESO SECO</b></label>
                                <div class="input-group mb-3">
                                    <input type="number" placeholder="KG" class="form-control input-sm" id="input_pesoSeco" name="input_pesoSeco" style="width:70px;" size="6" max="6" maxlength="6" value="'.$NUM_PESOSECO.'"/>
                                    <span class="input-group-text">KG</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hd_anterior"><b>PESO HD ANTERIOR(*)</b></label>
                                <input type="text"  placeholder="-" class="form-control input-sm" id="hd_anterior" name="hd_anterior" style="width: 90px;" onkeypress="return soloNumeros(event,this.id);" size="6" maxlength="6"/>
                            </div>
                            <div class="form-group">
                                <label for="pesopredialisis"><b>PESO PRE DI&Aacute;LISIS</b></label>
                                <input type="text"  placeholder="-" class="form-control input-sm" id="pesopredialisis" name="pesopredialisis" style="width: 90px;" onkeypress="return soloNumeros(event,this.id);" size="6" maxlength="6"/>
                            </div>
                            <div class="form-group">
                                <label for="alza_interdialisis"><b>ALZA INTERDIALISIS</b></label>
                                <input type="text"  placeholder="-" class="form-control input-sm" id="alza_interdialisis" name="alza_interdialisis" style="width: 90px;" onkeypress="return soloNumeros(event,this.id);" size="6" maxlength="6" />
                            </div>
                            <div class="form-group">
                                <label for="from_ufprograma"><b>UF PROGRAMADA</b></label>
                                <div class="input-group">
                                     <input type="text"  placeholder="-" class="form-control input-sm" id="ufprograma" name="ufprograma" style="width: 90px;" onkeypress="return num_coma(event,this)" size="6" maxlength="6"/>
                                    <select id="ufprograma_um" name="ufprograma_um" class="form-control input-sm" style="width:68px;">
                                        <option value="0">ML</option>
                                        <option value="1">L</option>
                                    </select>
                                </div>
                            </div>
                            <!--
                            <div class="form-group">
                                <label for="prsopostdialisis"><b>PESO POST-DI&Aacute;LISIS(*)</b></label>
                                <input type="number"  placeholder="-" class="form-control input-sm" id="prsopostdialisis" name="prsopostdialisis" style="width: 90px;" onkeypress="return num_coma(event, this)"/>
                            </div>
                            <div class="form-group">
                                <label for="txtperdidasdepeso"><b>PERDIDA DE PESO INTERDIALISIS(*)</b></label>
                                <input type="number"  placeholder="-" class="form-control input-sm" id="txtperdidasdepeso" name="txtperdidasdepeso"  style="width: 90px;" onkeypress="return num_coma(event, this)"/>
                            </div>
                            -->
                        </div>
                    </form>
                </div>
            </div>
            <div class=" card grid_primera_programacion2"  style="margin-bottom: 0px">
                <form method="get" action="#" class="form-horizontal" id="rrhhConexion" name="rrhhConexion" >
                    <div class="" style="margin: 12px 0px 0px 12px;"
                        <div class="header"  style="margin: 12px 0px 0px 12px;">
                            <h4 class="title"><b>PROFESIONALES CONEXI&Oacute;N</b></h4>
                            <p class="category">Informaci&oacute;n RRHH di&aacute;lisis</p>
                        </div>
                        <div class="content">
                            <div class="grid_lista_profesionales_conexion">
                                <div class="grid_lista_profesionales_conexion1"><i class="fa fa-user-circle" aria-hidden="true"></i>ENFERMERO</div>
                                <div class="grid_lista_profesionales_conexion2">
                                    <select id="slc_enfermeria" name="slc_enfermeria" data-width="100%" class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true"></select>
                                </div>
                                <div class="grid_lista_profesionales_conexion3"><i class="fa fa-user-circle-o" aria-hidden="true"></i> TEC. ENFERMERIA</div>
                                <div class="grid_lista_profesionales_conexion4">
                                    <select id="slc_tecpara" name="slc_tecpara" data-width="100%" class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true"></select>
                                </div>
                                <div class="grid_lista_profesionales_conexion5"><i class="fa fa-user-md" aria-hidden="true"></i> MEDICO</div>
                                <div class="grid_lista_profesionales_conexion6">
                                    <select id="slc_medico" name="slc_medico" data-width="100%" class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true"></select>
                                </div>
                            </div>
                        </div>
                    </div> 
                </form>
            </div>
        </div>
        <div class="grid_segunda_programacion2">
            <div class="card" style="margin-bottom: 0px">
                <div class="header">
                    <h4 class="title" style="margin: 12px 0px 0px 25px;"><b>SIGNOS VITALES PRE-DIALISIS</b></h4>
                    <p class="category" style="margin-left: 27px;">ingrese signos vitales antes de la conexi&oacute;n de la m&aacute;quina - (*) datos no obligatorio</p>
                </div>'.$this->htmlTomaSisnos(1).'
            </div>
        </div>
        ';
    return $html;
}

#finaliza manana 28.06.2022

public function HtmlCierrehemodialisis(){
    if(!$this->input->is_ajax_request()){ show_404(); }
    $empresa    =   $this->session->userdata("COD_ESTAB");
    $html       =   '
                    <div class="grid_body_cierrehermo">
                        <div class=" card grid_body_cierrehermo1" style="margin-bottom:0px;">
                            <div class="" style="margin: 12px 0px 0px 12px;">
                                <div class="header">
                                     <h4 class="title"><b>DATOS DEL PACIENTE</b></h4>
                                     <p class="category">Informaci&oacute;n Basica</p>
                                 </div>
                                <div class="content">
                                    <div class="grid_datos_paiente">
                                        <div class="grid_datos_paiente1"><i class="fa fa-user-circle" aria-hidden="true"></i></div>
                                        <div class="grid_datos_paiente2"><div id="txtnombre">&nbsp;'.$this->input->post("name").'</div></div>
                                        <div class="grid_datos_paiente3"><i class="fa fa-id-card-o" aria-hidden="true"></i></div>
                                        <div class="grid_datos_paiente4"><div id="txtrut">&nbsp;'.$this->input->post("rut").'</div></div>
                                        <div class="grid_datos_paiente5"><i class="fa fa-mobile" aria-hidden="true"></i></div>
                                        <div class="grid_datos_paiente6"><div id="txtnumfono">&nbsp;'.$this->input->post("fono").'</div></div>
                                        <div class="grid_datos_paiente7"><i class="fa fa-birthday-cake" aria-hidden="true"></i></div>
                                        <div class="grid_datos_paiente8"><div id="txtxhappybirthday">&nbsp;'.$this->input->post("cump").'</div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card grid_body_cierrehermo2" style="margin-bottom:0px;">
                            <div class="" style="margin: 12px 0px 0px 12px;">
                                <div class="header">
                                    <h4 class="title"><b>FINAL PROGRAMACI&Oacute;N</b></h4>
                                    <p class="category">Informaci&oacute;n Basica</p>
                                </div>
                                <div class="contenedor">
                                    <div class="grid_programacion_final">
                                        <div class="grid_programacion_final1">
                                            <label for="prsopostdialisis"><b class="plomo">PESO POST-DI&Aacute;LISIS</b></label>
                                        </div>
                                        <div class="grid_programacion_fina2">
                                            <label for="txtperdidasdepeso"><b class="plomo">P&Eacute;RDIDA DE PESO INTERDIALISIS</b></label>
                                        </div>
                                        <div class="grid_programacion_final3">
                                            <input type="text"  placeholder="-" class="form-control input-sm" id="prsopostdialisis_term"    name="prsopostdialisis_term"   style="width: 90px;" onkeypress="return soloNumeros(event,this.id);" size="6" maxlength="6"/>
                                        </div>
                                        <div class="grid_programacion_final4">
                                            <input type="text"  placeholder="-" class="form-control input-sm" id="txtperdidasdepeso_term"   name="txtperdidasdepeso_term"  style="width: 90px;" onkeypress="return soloNumeros(event,this.id);" size="6" maxlength="6"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card grid_body_cierrehermo3" style="margin-bottom:0px;">
                            <form method="get" action="#" class="form-horizontal" id="terminoDialisis" name="terminoDialisis" >    
                                <div class="" style="margin: 12px 0px 0px 12px;">
                                    <div class="header">
                                        <h4 class="title"><b>PROFESIONALES DECONEXI&Oacute;N</b></h4>
                                        <p class="category">Informaci&oacute;n Basica</p>
                                    </div>
                                    <div class="content">
                                        <div class="grid_lista_profesionales_conexion">
                                            <div class="grid_lista_profesionales_conexion1"><i class="fa fa-user-circle" aria-hidden="true"></i>ENFERMERO</div>
                                            <div class="grid_lista_profesionales_conexion2"><select id="slc_enfermeria" name="slc_enfermeria" style="width: 100%;"  class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true"></select></div>
                                            <div class="grid_lista_profesionales_conexion3"><i class="fa fa-user-circle-o" aria-hidden="true"></i> TEC. ENFERMERIA</div>
                                            <div class="grid_lista_profesionales_conexion4"><select id="slc_tecpara" name="slc_tecpara" style="width: 100%;"        class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true"></select></div>
                                            <div class="grid_lista_profesionales_conexion5"><i class="fa fa-user-md" aria-hidden="true"></i> MEDICO</div>
                                            <div class="grid_lista_profesionales_conexion6"><select id="slc_medico" name="slc_medico" style="width: 100%;"          class="selectpicker" data-selected-text-format="count" data-size="8" data-live-search="true"></select></div>
                                        </div>
                                    </div>
                                </div> 
                            </form>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 6px;">
                        <div class="col-md-12">
                            <div class="card" style="margin: 12px 0px 0px 12px;">
                                <div class="header">
                                    <h4 class="title"><b>DATOS DE DECONEXI&Oacute;N</b></h4>
                                    <p class="category">Informaci&oacute;n Basica</p>
                                </div>
                                <div class="contenedor">
                                    <div class="form-group">
                                        <label for="txtHoraIngresoPre"><b>HORA DESCONEXI&Oacute;N</b></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                            <input type="time" class="form-control input-sm" id="txtHoraEgreso" name="txtHoraEgreso" style="width:90px;height:31px" >
                                         </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="form_txttotalufconseguida"><b>TOTAL UF CONSEGUIDA</b></label>
                                        <div class="input-group">
                                            <input type="text"  placeholder="-" class="form-control input-sm" id="txttotalufconseguida" name="txttotalufconseguida" style="width: 90px;" onkeypress="return num_coma(event, this)"/>
                                            <select id="txttotalufconseguida_um" name="txttotalufconseguida_um" class="form-control input-sm" style="width:68px;">
                                                <option value="0">ML</option>
                                                <option value="1">L</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ufprograma"><b>VOL. DE SANGRE ACOMULADO</b></label>
                                        <input type="text"  placeholder="-" class="form-control input-sm" id="volsangreacomulado" name="volsangreacomulado" style="width: 90px;" onkeypress="return num_coma(event, this)"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtHoraIngresoPre"><b>DESINFECCCI&Oacute;N DE LA MAQUINA</b></label>
                                        <div class="input-group">
                                            <select id="SL_DESIFCACCIONMAQUINA" name="SL_DESIFCACCIONMAQUINA" class="form-control input-sm" style="width: 120px;">
                                                <option value="1">SI</option> 
                                                <option value="0">NO</option> 
                                            </select>
                                         </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtHoraIngresoPre"><b>DIALIZADOR POST DI&Aacute;LISIS</b></label>
                                        <div class="input-group">
                                           <select id="SL_DIALIZADORDIAL" name="SL_DIALIZADORDIAL" class="form-control input-sm" style="width: 220px;">
                                                <option value="1">LIMPIO</option> 
                                                <option value="2">SUCIO</option> 
                                                <option value="3">ROTO</option> 
                                                <option value="4">MUCHAS FIBRAS COAGULADAS</option> 
                                            </select>
                                         </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="for_num_kt_b"><b>Kt/V</b></label>
                                        <input type="text"  placeholder="-" class="form-control input-sm" id="num_kt_b" name="num_kt_b" style="width: 90px;" onkeypress="return num_coma(event,this)"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="margin: 12px 0px 0px 12px;">
                                <div class="header">
                                    <h4 class="title"><b>* SIGNOS VITALES POST-DIALISIS</b></h4>
                                    <p class="category">Ingrese Signos vitales posterior de la conexi&oacute;n de la m&aacute;quina - (*) Datos no obligatorio</p>
                                </div>
                                    '.$this->htmlTomaSisnos(3).'
                            </div>
                        </div>
                    </div>
                ';
    
    
    $TABLA[]        = array("id_html"=>"BODY_CIERREHERMO","opcion" => "append","contenido"=> $html);  
    #$aData          = $this->ssan_hdial_asignacionpaciente_model->profActvNuevaAgenda($empresa);
    $aData                      =   $this->ssan_hdial_asignacionpaciente_model->profActvNuevaAgenda_por_mantenedor($empresa);
    
    if (count($aData)>0){
        foreach ($aData as $row){
            $id_HTML    = '';
                    if ($row['IND_TIPOATENCION'] == '01' || $row['IND_TIPOATENCION'] == '15'){
                        $id_HTML    = 'slc_medico';
            } else  if ($row['IND_TIPOATENCION'] == '02'){
                        $id_HTML    = 'slc_enfermeria';
            } else  if ($row['IND_TIPOATENCION'] == '12'){
                        $id_HTML    = 'slc_tecpara';
            }
            $html       ='<option value="'.$row['COD_RUTPRO'].'"> '.$row['NOM_PROFE'].' </option>';
            $TABLA[]    = array("id_html"=>$id_HTML,  "opcion" => "append",  "contenido"=> $html);
        }
    }
    $this->output->set_output(json_encode($TABLA)); 
}

public function htmlTomaSisnos($val){
    $html= '
    <form id="formulario_histo_pre" name="formulario_histo_pre">    
        <div class="contenedor">
            <div class="form-group">
                <label for="txtHoraIngresoPre"><b>HORA</b></label>
                <input type="time" class="form-control input-sm" id="txtHoraIngreso" name="txtHoraIngreso" style="width:90px;" >
            </div>
            <div class="form-group">
                <label for="txtpresionalterial"><b>P.ARTERIAL(MM/HG)</b></label>
                <div class="input-group">
                    <input type="text"  placeholder="S" class="form-control input-sm" id="txtpresionalterial_s" name="txtpresionalterial_s" style="width: 45px;" min="1" max="5"/>
                     <span class="input-group-addon">/</span>
                    <input type="text"  placeholder="D" class="form-control input-sm" id="txtpresionalterial_d" name="txtpresionalterial_d" style="width: 45px;" min="1" max="5"/>
                </div>
            </div>
            <div class="form-group">
                <label for="txtpulso"><b>F.C</b></label>
                <input type="text"  placeholder="15-300" class="form-control input-sm" id="txtpulso" name="txtpulso" onKeyPress="return num(event)" style="width: 90px;"/>
            </div>
            <div class="form-group">
                <label for="txttpaciente"><b>T&deg; PACIENTE(*) <i class="fa fa-child" aria-hidden="true"></i></b></label>
                <input type="text"  placeholder="T PACIENTE" name="txttpaciente" id="txttpaciente"  class="form-control input-sm" onKeyPress="return num_coma(event, this)" size="6" maxlength="5" style="width: 90px;" value="" />
            </div>
            <div class="form-group">
                <label for="txttemmonitor"><b>T&deg; MONI(*)</b></label>
                <input type="text"  placeholder="T MONITOR" name="txttemmonitor" id="txttemmonitor"  class="form-control input-sm" onKeyPress="return num_coma(event, this)" size="6" maxlength="5" style="width: 90px;" value="" />
            </div>
            <div class="form-group">
                <label for="Q_B_PROG"><b>Q.B PROG(*)</b></label>
                <input type="text"  placeholder="Q.B PROG" class="form-control input-sm" id="Q_B_PROG" name="Q_B_PROG" onKeyPress="return num(event)" style="width: 90px;"/>
            </div>
            <div class="form-group">
                <label for="Q_B_EFEC"><b>Q.B EFEC(*)</b></label>
                <input type="text"  placeholder="Q.B EFEC" class="form-control input-sm" id="Q_B_EFEC" name="Q_B_EFEC" onKeyPress="return num(event)" style="width: 90px;"/>
            </div>
            <div class="form-group">
                <label for="TXTPA"><b>PA(-300-60)(*)</b></label>
                <div class="input-group mb-3">
                    <input type="number"  placeholder="PA" class="form-control input-sm" id="TXTPA" name="TXTPA" onKeyPress="return num(event)" style="width: 70px;"/>
                    <span class="input-group-text">mmHg</span>
                </div>
            </div>
            <div class="form-group">
                <label for="TXTPV"><b>PV(*)</b></label>
                <input type="text"  placeholder="PV" class="form-control input-sm" id="TXTPV" name="TXTPV" onKeyPress="return num(event)" style="width: 90px;"/>
            </div>
            <div class="form-group">
                <label for="TXTPTM"><b>PTM(*)</b></label>
                <input type="text"  placeholder="PTM" class="form-control input-sm" id="TXTPTM" name="TXTPTM" onKeyPress="return num(event)" style="width: 90px;"/>
            </div>
            <div class="form-group">
                <label for="TXTCOND"><b>COND(*)<!--<kbd>,</kbd>--></b></label>
                <input type="text"  placeholder="COND." class="form-control input-sm" id="TXTCOND" name="TXTCOND" onkeypress="return num_coma(event, this)" style="width: 90px;" size="4" maxlength="4"/>
            </div>
            <div class="form-group">
                <label for="TXTUFH"><b>UFH(ml/Hr)(*)</b></label>
                <input type="number " placeholder="UFH." class="form-control input-sm" id="TXTUFH" name="TXTUFH" onKeyPress="return num(event)" style="width: 90px;" />
            </div>
            <div class="form-group">
                <!--
                    <span class="input-group-addon">ML/HR</span>
                -->
                <label for="TXTUFACUMILADA"><b>UF ACUMULADA(*)</b></label>
                <div class="input-group">
                    <input type="text"  placeholder="UF ACUMULADA" class="form-control input-sm" id="TXTUFACOMULADA" name="TXTUFACOMULADA" onKeyPress="return num(event)" style="width: 90px;" size="6" maxlength="6"/>
                    <select id="TXTUFACOMULADA_UM" name="TXTUFACOMULADA_UM" class="form-control input-sm" style="width: 90px;">
                        <option value="0">ML/HR</option>
                        <option value="1">L/HR</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="TXTINGRESO"><b>INGRESOS</b></label>
                <input type="text"  placeholder="INGRESOS" class="form-control input-sm" id="TXTINGRESO" name="TXTINGRESO"/>
            </div>
            <div class="form-group">
                <label for="TXTOBSERVACIONES"><b>OBSERVACIONES</b></label>
                <input type="text"  placeholder="OBSERVACIONES" class="form-control input-sm" id="TXTOBSERVACIONES" name="TXTOBSERVACIONES" style="width: 350px;" size="250" maxlength="250">
            </div>
            <input type="hidden" name="ind_tomadesigno" id="ind_tomadesigno" value="'.$val.'"/>
        </div>
    </form>';
    return $html;
}

public function busca_informacion_hojadiaria(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $IDHOJADIARIA           =   $this->input->post("id_hojadiaria");
    $dataPro                =   $this->ssan_hdial_asignacionpaciente_model->getDatosGeneralesxDial($IDHOJADIARIA);
    $this->output->set_output(json_encode(array(
        'out_data'          =>  $dataPro
    )));
}

public function cargahtmlHojaDiaria(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    //**********************************************************************
    $empresa                =   $this->session->userdata("COD_ESTAB");
    $NUM_CITA               =   $this->input->post("NUM_CITA");
    $NUMFICHAE              =   $this->input->post("NUMFICHAE");
    $num_Maquina            =   $this->input->post("num_Maquina");
    $IDHOJADIARIA           =   $this->input->post("IDHOJADIARIA");
    $name                   =   $this->input->post("namePaciente");
    $templete               =   $this->input->post("templete");
    $OPMEDIC                =   $this->input->post("OPMEDIC");
    $fechaHD                =   explode("-",$this->input->post("fechaHD")); 
    //**********************************************************************
    //$DATA_HOJA            =   $this->ssan_hdial_eliminacionhojadiara_model->al_dia_hojaactiva($NUMFICHAE,$this->input->post("fechaHD"));
    /*
    $TABLA[]                =   array("id_html" => "",                      "opcion" => "console",      "contenido"  => "NUMFICHAE      ->".$NUMFICHAE);
    $TABLA[]                =   array("id_html" => "",                      "opcion" => "console",      "contenido"  => "fechaHD        ->".$this->input->post("fechaHD"));
    $TABLA[]                =   array("id_html" => "",                      "opcion" => "console",      "contenido"  => "DATA_HOJA      ->".$DATA_HOJA);
    */
    //**********************************************************************
    $TABLA[]                =   array("id_html"=>"","opcion" => "console","contenido"=>$templete); 
  //$TABLA[]                =   array("id_html"=>"","opcion" => "console","contenido"=> date("w",mktime(0,0,0,$fechaHD[1],$fechaHD[0],$fechaHD[2])) ); 
    $dataPro                =   $this->Ssan_hdial_asignacionpaciente_model->getDatosGeneralesxDial($IDHOJADIARIA);
    if($dataPro[0]['ADMISION_ACTIVA'] == ''){
        $TABLA[]            =   array("id_html"=>"",            "opcion" => "jError",   "contenido"=>"Hoja diaria ha cambiado de estado");
        $TABLA[]            =   array("id_html"=>"respuesta",   "opcion" => "append",   "contenido"=>"<script>eventosBuscar($num_Maquina)</script>");
        $this->output->set_output(json_encode($TABLA)); 
        return false;
    }
    $RUTPAC                 =   $dataPro[0]['RUTPAC'];
    $RUTPAC_ARRAY           =   explode("-",$RUTPAC);
    //**********************************************************************
    $dias                   =   array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
    $meses                  =   array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha                  =   $dias[date("w",mktime(0,0,0,$fechaHD[1],$fechaHD[0],$fechaHD[2]))]." ".$fechaHD[0]." de ".$meses[$fechaHD[1]-1]. " del ".$fechaHD[2];
    $dataVit                =   $this->Ssan_hdial_asignacionpaciente_model->getDatosSignosVitales($IDHOJADIARIA,'');
    $htmlVit                =   '';
    $NUM_HDPESOANTERIOR     =   '';
    $NUM_PESOPOSTDIALISIS   =   '';
    //**********************************************************************
    //if($dataPro[0]['NUM_PESOPOSTDIALISIS'] == ''){ $NUM_PESOPOSTDIALISIS = 'NO INGRESADO';   }
    //if($dataPro[0]['NUM_HDPESOANTERIOR']   == ''){ $NUM_HDPESOANTERIOR   = 'NO INGRESADO';   }
    //**********************************************************************
    if(count($dataVit)>0){
        foreach ($dataVit as $row){
            $htmlVit.='<tr id="'.$row['ID'].'"  style="height:40px;">
                        <td style="text-align:center">'.$row['HORA'].'</td>
                        <td style="text-align:center">'.$row['NUM_PARTERIAL'].'</td>
                        <td style="text-align:center">'.$row['NUM_PULSO'].'</td>
                        <td style="text-align:center">'.$row['NUM_TMONITOR'].'</td>
                        <td style="text-align:center">'.$row['NUM_TPACIENTE'].'</td>
                        <td style="text-align:center">'.$row['NUM_QBPROG'].'</td>
                        <td style="text-align:center">'.$row['NUM_QBEFEC'].'</td>
                        <td style="text-align:center">'.$row['NUM_PA'].'</td>
                        <td style="text-align:center">'.$row['NUM_PV'].'</td>
                        <td style="text-align:center">'.$row['NUM_PTM'].'</td>
                        <td style="text-align:center">'.$row['NUM_COND'].'</td>
                        <td style="text-align:center">'.$row['NUM_UFH'].'</td>
                        <td style="text-align:center">'.$row['NUM_UFACOMULADA'].'</td>
                        <td ><font size="1px">'.$row['TXT_INGRESO'].'</font></td>
                        <td ><font size="1px">'.$row['TXTOBSERVACIONES'].'</font></td>';
            if($row['IND_TOMASIGNO'] == '2'){
                $htmlVit    .=  '<td><button type="button" class="btn btn-default btn-xs" onclick="js_eliminaSV('.$row['ID'].','.$IDHOJADIARIA.')"><i class="fa fa-ban" aria-hidden="true"></i></button> </td>';
            } else {
                $htmlVit    .=  '<td>-</td>';
            }
            $htmlVit    .=  '</tr>';   
        }
    } else {
        $htmlVit='<tr><td colpan="15">SIN DATOS</td></tr>';
    }
    //**********************************************************************
    if($dataPro[0]['NUM_PESOPOSTDIALISIS'] == ''){
        $NUM_PESOPOSTDIALISIS       =   'EN ESPERA - AL CIERRE';
    } else {
        $NUM_PESOPOSTDIALISIS       =   $dataPro[0]['NUM_PESOPOSTDIALISIS'];
    }
    //**********************************************************************
        $NUM_PESOINTERDIALISIS      =   '';
    if ($dataPro[0]['NUM_PESOINTERDIALISIS'] == ''){
        $NUM_PESOINTERDIALISIS      =   'EN ESPERA - AL CIERRE';
    } else {
        $NUM_PESOINTERDIALISIS      =   $dataPro[0]['NUM_PESOINTERDIALISIS'];
    }
    
    //**********************************************************************
    $html ='
        <ul role="tablist" class="nav nav-tabs">
            <li role="presentation" class="active">
                <a href="#HOJA_DIARIA" data-toggle="tab">HOJA DIARIA</a>
            </li>
            <li id="li_REACIONESADVERSAS">
                <a href="#REACIONESADVERSAS" data-toggle="tab">REACCIONES ADVERSAS </a>
            </li>
            <li id="li_SOLICITUDDEEXAMENES">
                <a href="#SOLICITUDDEEXAMENES" data-toggle="tab">EXAMENES DE LABORATORIO</a>
            </li>';
    #solo medicos
    if($templete == '1'){
        $html .='        
            <li id="li_receta_medica" onclick="js_views_receta_hd('.$IDHOJADIARIA.','.$NUMFICHAE.')">
                <a href="#RECETA_MEDICA" data-toggle="tab">RECETA MEDICA (NUEVO)</a>
            </li>';
    }
    $html .='           
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">OPCIONES<span class="caret"></span></a>
                <ul class="dropdown-menu">';
                    if($templete == '2'){
                $html.='<li><a href="javascript:js_guardadoPrevio('.$IDHOJADIARIA.',0)"><i class="fa fa-floppy-o" aria-hidden="true"></i></i> GRABADO PREVIO</a></li>';
                $html.='<li><a href="javascript:js_grdCierre('.$IDHOJADIARIA.',1)"><i class="fa fa-check-circle" aria-hidden="true"></i> TERMINO DIALISIS</a></li>';
            } else  if($templete == '1'){
                $html.='<li><a href="javascript:js_guardadoPrevio('.$IDHOJADIARIA.',3)"><i class="fa fa-floppy-o" aria-hidden="true"></i></i> GRABADO MEDICO</a></li>';
            } else  if($templete == '3'){
                $html.='<li><a href="javascript:js_guardaCorrecion('.$IDHOJADIARIA.',1)"><i class="fa fa-floppy-o" aria-hidden="true"></i></i> GUARDA CORRECCI&Oacute;N</a></li>';
            }
            $html.='<li><a href="javascript:js_cierramodal()"><i class="fa fa-window-close-o" aria-hidden="true"></i> CERRAR (NO GRABA)</a></li>
                    <li class="divider"></li>
                    <li><a href="javascript:js_pdfHTML('.$IDHOJADIARIA.')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF H.DIARIA ACTUAL</a></li>
                    <li><a href="javascript:js_cBUSQUEDAHANTERIOR('.$NUMFICHAE.',1)"><i class="fa fa-file-archive-o" aria-hidden="true"></i> PDF H.DIARIA ANTERIORES</a></li>
                    <li><a href="javascript:js_cSOLICITUDEEXAMENES('.$NUMFICHAE.',1)"><i class="fa fa-calendar" aria-hidden="true"></i> SOLICITUD DE EXAMENES</a></li>   
                </ul>
            </li>
        </ul>
        

        
        <div class="tab-content">
            <div id="RECETA_MEDICA" class="tab-pane">
                <div class="pabel_recetas_iframe">--</div>
            </div>
            <div id="HOJA_DIARIA" class="tab-pane active">
                <div class="blog-header">
                    <div class="container">
                        <div class="grid_hoja_diaria_titulo">
                            <div class="grid_hoja_diaria_titulo1"> 
                                <h3 class="blog-title" style="margin-top:0px;">
                                <b>HOJA DE TRATAMIENTO DIARIO DE HEMODI&Aacute;LISIS</b></h3> 
                                <p class="lead blog-description"> '.$fecha.' <!-- N&deg; CITA 1 --> </p>
                                <input type="hidden" id="idAdmision_'.$IDHOJADIARIA.'" name="idAdmision_'.$IDHOJADIARIA.'" value="'.$NUM_CITA.'"/>
                            </div>
                            <div class="grid_hoja_diaria_titulo2" style="    text-align: -webkit-right;"> 
                                <p class="category">FECHA CREACI&Oacute;N</p>
                                <b>'.$dataPro[0]['TXT_FEC_CREA'].'</b>
                                <br>
                                <p class="category">ULTIMA ACTUALIZACI&Oacute;N</p>
                                <b id="fecha_ultima_actualizacion">'.$dataPro[0]['TXT_FEC_AUDITA'].'</b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                    <div class="col-sm-8 blog-main">
                    <div class="blog-post">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b> DATOS DE PROGRAMACI&Oacute;N</b></h4>
                                <p class="category">Informaci&oacute;n Complementaria</p>
                            </div>
                        <div class="content">
                            <div class="contenedor">
                                <div class="form-group">
                                    <label for="input_pesoSeco"><b>Peso Seco</b></label>
                                    <input type="text"  placeholder="INGRESE PESO SECO" class="form-control input-sm" id="input_pesoSeco" name="input_pesoSeco" disabled value="'.str_replace(",",".", $dataPro[0]['NUM_PESOSECO']).'"> 
                                </div>
                                <div class="form-group">
                                    <label for="hd_anterior"><b>PESO HD ANTERIOR</b></label>
                                    <input type="number"  placeholder="PESO HD ANTERIOR" class="form-control input-sm" id="hd_anterior" name="hd_anterior" disabled value="'.str_replace(",",".",$dataPro[0]['NUM_HDPESOANTERIOR']) .'"> 
                                </div>
                                <div class="form-group">
                                    <label for="pesopredialisis"><b>PESO PRE DI&Aacute;LISIS</b></label>
                                    <input type="number"  placeholder="PESO PRE DIALISIS" class="form-control input-sm" id="pesopredialisis" name="pesopredialisis" disabled value="'.str_replace(",",".",$dataPro[0]['NUM_PESOPREDIALISIS']).'"> 
                                </div>
                                <div class="form-group">
                                    <label for="altaintensidad"><b>ALZA INTERDIALISIS</b></label>
                                    <input type="number"  placeholder="ALZA INTERDIALISIS" class="form-control input-sm" id="altaintensidad" name="altaintensidad"disabled value="'.str_replace(",",".",$dataPro[0]['NUM_INTERDIALISIS']).'"> 
                                </div>
                                <div class="form-group">
                                    <label for="predialisis"><b>UF PROGRAMADA</b></label>
                                    <input type="number"  placeholder="UF PROGRAMADA" class="form-control input-sm" id="predialisis" name="predialisis" disabled value="'.str_replace(",",".",$dataPro[0]['NUM_UFPROGRAMADA']).'"> 
                                </div>
                                <div class="form-group">
                                    <label for="prsopostdialisis"><b>PESO POST DIALISIS</b></label>
                                    <input type="number"  placeholder="PESO POST DIALISIS" class="form-control input-sm" id="prsopostdialisis" name="prsopostdialisis" disabled value="'.$NUM_PESOPOSTDIALISIS.'"> 
                                </div>
                                <div class="form-group">
                                    <label for="txtperdidasdepeso"><b>PERDIDA DE PERSO INTERDIALISIS</b></label>
                                    <input type="number"  placeholder="PERDIDA DE PERSO INTERDIALISIS" class="form-control input-sm" id="txtperdidasdepeso" name="txtperdidasdepeso" disabled value="'.$NUM_PESOINTERDIALISIS.'"> 
                                </div>
                            </div>
                        </div>
                    </div> 
                     
                    <hr>
                    
                    <div id="tabs"> <!-- Nav tabs -->
                        <ul class="nav nav-pills  nav-justified" role="tablist">
                            <li role="presentation" class="active" id="TB_ENFERMERIA">
                                <a href="#IND_ENFERMERIA"   aria-controls="IND_ENFERMERIA" role="tab" data-toggle="tab">
                                    <i class="fa fa-stethoscope" aria-hidden="true"></i> INDICACI&Oacute;NES ENFERMERA
                                </a>
                            </li>
                            <li role="presentation" id="TB_MEDICO"> 
                                <a href="#IND_MEDICO" aria-controls="IND_MEDICO" role="tab" data-toggle="tab"> 
                                    <i class="fa fa-user-md" aria-hidden="true"></i>INDICACI&Oacute;NES MEDICA
                                </a>
                            </li>
                        </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="IND_ENFERMERIA">
                            <form id="FORM_ENFERMERIA" name="FORM_ENFERMERIA">
                            
                                    <div class="card" >
                                        <div class="row">
                                            <div class="col-md-6">
                                                 <div class="header">
                                                    <h4 class="title"><b> TOMA DE SIGNOS VITALES </b></h4>
                                                    <p class="category">Informaci&oacute;n Complementaria</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6"  style="text-align: -webkit-center;">
                                                <br>
                                                <button type="button" class="btn btn-info btn-fill btn-wd" 
                                                    id          =   "ind_hoja_diaria_'.$IDHOJADIARIA.'"
                                                    onclick     =   "js_indicacionENFE('.$IDHOJADIARIA.','.$NUMFICHAE.','.$NUM_CITA.')"
                                                    >
                                                    <i class="fa fa-file-text-o" aria-hidden="true"></i> NUEVA TOMA DE SIGNOS VITALES
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-plain" style="margin-bottom: 0px;">
                                                    <div class="content table-responsive table-full-width" style="padding-bottom: 0px;">
                                                        <table class="table table-hover table-striped table-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>HORA</th>
                                                                    <th>PAS/PAD</th>
                                                                    <th>F.C</th>
                                                                    <th>T&deg; MONI</th>
                                                                    <th>T&deg; PAC</th>
                                                                    <th>Q.B PROG</th>
                                                                    <th>Q.B EFEC</th>
                                                                    <th>PA</th>
                                                                    <th>PV</th>
                                                                    <th>PTM</th>
                                                                    <th>COND</th>
                                                                    <th>UFH</th>
                                                                    <th>UF ACUM</th>
                                                                    <th>INGRESO</th>
                                                                    <th>OBSERVACIONES</th>
                                                                    <th>&nbsp;</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="htmlSignosvitales">'.$htmlVit.'</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="content">
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th width="4%"  >HORA</th>
                                                            <th width="6%"  >PAS/PAD</th>
                                                            <th width="6%"  >F.C</th>
                                                            <th width="6%"  >T&deg; MONI</th>
                                                            <th width="4%"  >T&deg; PAC</th>
                                                            <th width="6%"  >Q.B PROG</th>
                                                            <th width="6%"  >Q.B EFEC</th>
                                                            <th width="4%"  >PA</th>
                                                            <th width="4%"  >PV</th>
                                                            <th width="4%"  >PTM</th>
                                                            <th width="4%"  >COND</th>
                                                            <th width="6%"  >UFH</th>
                                                            <th width="6%"  >UF ACUMULADA</th>
                                                            <th width="12%" >INGRESO</th>
                                                            <th width="20%" >OBSERVACIONES</th>
                                                            <th width="1%"  ><i class="fa fa-cogs" aria-hidden="true"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="htmlSignosvitales">'.$htmlVit.'</tbody>
                                                </table>
                                            </div>
                                        </div>
                                        -->
                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-5">

                                            </div>
                                        </div>
                                    </div> <!-- end card -->
                                    <div class="card" style="PADDING:1PX;">
                                        <div class="header">
                                            <h4 class="title"><b> OBSERVACIONES DE ENFERMER&Iacute;A </b></h4>
                                            <p class="category">Informaci&oacute;n Complementaria</p>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="5" id="OBS_ENFERMERIA" name="OBS_ENFERMERIA">'.$dataPro[0]['TXT_ENFERMERIA'].'</textarea>
                                        </div>
                                    </div> <!-- end card -->
                                    </form>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="IND_MEDICO"> 
                                    <form id="FORM_MEDICO" name="FORM_MEDICO">
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="header">
                                                        <h4 class="title"><b> INDICACIONES MEDICAS  </b></h4>
                                                        <p class="category">Informaci&oacute;n Complementaria</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="text-align:-webkit-center;">
                                                    <br>
                                                    <div id="div_optionAN">
                                                        <div class="form-group">
                                                            <label for="input_pesoSeco"><b>PENDIENTE PERFIL MEDICO </b></label>
                                                            <div class="input-group">
                                                                <input type="checkbox" name="optionA" id="optionAN" value="0" onclick="checkA(this.id,this.value);">
                                                                <label for="optionAN"><span></span>&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="content">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">ACCESO VASCULAR 1</label>
                                                        <div class="col-sm-5"><input type="text" class="form-control input-sm"  id="TXT_ACCESOVAS_1"   name="TXT_ACCESOVAS_1" value="'.$dataPro[0]['TXTACCESOVAS_1'].'"></div>
                                                        <label class="col-sm-1 control-label"><div id="txtdia_1"> FECHA 1</div></label>
                                                        <div class="col-sm-2"><input type="text" class="form-control input-sm"  id="FEC_DIAS_1"   name="FEC_DIAS_1" value="'.$dataPro[0]['FEC_DIASVAS_1'].'" STYLE="WIDTH: 95PX;" onblur="cal_fecha(this.value,1)" ></div>
                                                        <label class="col-sm-1 control-label"><div id="num_dias_1">'.$dataPro[0]['NUM_DIASVAS_1'].'</div></label>
                                                        <script>
                                                        $("#FEC_DIAS_1").datetimepicker({
                                                            format          :   "DD-MM-YYYY",
                                                            maxDate         :   new Date(),
                                                            locale          :   "es-us",
                                                            icons           : 
                                                                {
                                                                    time        : "fa fa-clock-o"       ,
                                                                    date        : "fa fa-calendar"      ,
                                                                    up          : "fa fa-chevron-up"    ,
                                                                    down        : "fa fa-chevron-down"  ,
                                                                    previous    : "fa fa-chevron-left"  ,
                                                                    next        : "fa fa-chevron-right" ,
                                                                    today       : "fa fa-screenshot"    ,
                                                                    clear       : "fa fa-trash"         ,
                                                                    close       : "fa fa-remove"        ,
                                                                }
                                                        });
                                                        </script>
                                                    </div>
                                               </fieldset>

                                               <fieldset>
                                                   <div class="form-group">
                                                       <label class="col-sm-3 control-label">ACCESO VASCULAR 2</label>
                                                       <div class="col-sm-5"><input type="text" class="form-control input-sm"  id="TXT_ACCESOVAS_2"   name="TXT_ACCESOVAS_2" value="'.$dataPro[0]['TXTACCESOVAS_2'].'"></div>
                                                       <label class="col-sm-1 control-label">FECHA 2:</label>
                                                       <div class="col-sm-2"><input type="text" class="form-control input-sm"  id="FEC_DIAS_2"   name="FEC_DIAS_2" value="'.$dataPro[0]['FEC_DIASVAS_2'].'" STYLE="WIDTH: 95PX;" onblur="cal_fecha(this.value,2)"></div>
                                                       <label class="col-sm-1 control-label"><div id="num_dias_2">'.$dataPro[0]['NUM_DIASVAS_2'].'</div></label>
                                                       <script>
                                                       $("#FEC_DIAS_2").datetimepicker({
                                                           format          : "DD-MM-YYYY",
                                                           maxDate         : new Date(),
                                                           locale          : "es-us",
                                                           icons           :    {
                                                                                    time        : "fa fa-clock-o"       ,
                                                                                    date        : "fa fa-calendar"      ,
                                                                                    up          : "fa fa-chevron-up"    ,
                                                                                    down        : "fa fa-chevron-down"  ,
                                                                                    previous    : "fa fa-chevron-left"  ,
                                                                                    next        : "fa fa-chevron-right" ,
                                                                                    today       : "fa fa-screenshot"    ,
                                                                                    clear       : "fa fa-trash"         ,
                                                                                    close       : "fa fa-remove"        ,
                                                                                }
                                                       });
                                                       </script>     
                                                   </div>
                                               </fieldset>
                                        </div>
                                        <hr>  
                                        <div class="content">
                                            <div class="contenedor">
                                                <div class="form-group">
                                                    <label for="TROCAR"><b>TROCAR <br>(ARTERIAL)</b></label>
                                                    <input type="text"  placeholder="ARTERIAL" class="form-control input-sm"    id="NUM_ARTERIAL" name="NUM_ARTERIAL"   STYLE="WIDTH: 90PX;"  value="'.$dataPro[0]['NUM_TROCAR_ARTERIAL'].'"  onKeyPress="return num(event)" style="width: 90px;"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="VENOSO"><b>TROCAR <br>(VENOSO)</b></label>
                                                    <input type="text"  placeholder="VENOSO" class="form-control input-sm"      id="NUM_VENOSO"   name="NUM_VENOSO"     STYLE="WIDTH: 90PX;" value="'.$dataPro[0]['NUM_TROCAR_VENOSO'].'"  onKeyPress="return num(event)" style="width: 90px;"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="HEPARINA"><b>HEPARINA <br>(I)</b></label>
                                                    <input type="text"  placeholder="INICIO" class="form-control input-sm"      id="NUM_INICIO" name="NUM_INICIO"   STYLE="WIDTH: 90PX;" value="'.$dataPro[0]['NUM_HEPARINA_INICIO'].'"  onKeyPress="return num(event)" style="width: 90px;"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="HEPARINA2"><b>HEPARINA <br>(M)</b></label>
                                                    <input type="text"  placeholder="VENOSO" class="form-control input-sm"      id="NUM_MANTENCION"   name="NUM_MANTENCION"     STYLE="WIDTH: 90PX;" value="'.$dataPro[0]['NUM_HEPARINA_MAN'].'"  onKeyPress="return num(event)" style="width: 90px;"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="QT"><br><b>QT</b></label>
                                                    <input type="text"  placeholder="QT" class="form-control input-sm"          id="NUM_QT" name="NUM_QT" STYLE="WIDTH: 75PX;" value="'.$dataPro[0]['NUM_QT'].'"  onKeyPress="return num_coma(event, this)" style="width: 90px;"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="QB"><br><b>QB</b></label>
                                                    <input type="text"  placeholder="QB" class="form-control input-sm"          id="NUM_QB" name="NUM_QB" STYLE="WIDTH: 75PX;" value="'.$dataPro[0]['NUM_QB'].'"  onKeyPress="return num(event)" style="width: 90px;"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="QD"><br><b>QD</b></label>
                                                    <input type="text"  placeholder="QD" class="form-control input-sm"          id="NUM_QD" name="NUM_QD" STYLE="WIDTH: 75PX;" value="'.$dataPro[0]['NUM_QD'].'"  onKeyPress="return num(event)" style="width: 90px;"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="MAX"><br><b>UF MAX.</b></label>
                                                    <div class="input-group">
                                                        <input type="text"  placeholder="UF MAX" class="form-control input-sm"      id="NUM_UFMAX" name="NUM_UFMAX" STYLE="WIDTH: 75PX;" value="'.$dataPro[0]['NUM_UFMAX'].'"  onKeyPress="return num(event)" style="width: 90px;"/>
                                                        <select id="NUM_UFMAX_UM" name="NUM_UFMAX_UM" class="form-control input-sm" style="width:68px;">
                                                            <option value="0" >ML</option>
                                                            <option value="1" >L</option>
                                                        </select>
                                                    </div>
                                                    <script>$("#NUM_UFMAX_UM").val('.$dataPro[0]['NUM_UFMAX_UM'].');</script>
                                                </div>
                                                <div class="form-group">
                                                    <label for="K"><br><b>K.</b></label>
                                                    <input type="text"  placeholder="K" class="form-control input-sm"           id="NUM_K" name="NUM_K" STYLE="WIDTH: 75PX;" value="'.$dataPro[0]['NUM_K'].'"  onKeyPress="return num_coma(event, this)" style="width: 90px;"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Na"><br><b>Na.</b></label>
                                                    <input type="text"  placeholder="Na" class="form-control input-sm"          id="NUM_NA" name="NUM_NA" STYLE="WIDTH: 75PX;" value="'.$dataPro[0]['NUM_NA'].'"  onKeyPress="return num(event)" style="width: 90px;"/> 
                                                </div>
                                                <div class="form-group">
                                                    <label for="CONCENTRADO"><br><b>CONCENTRADO.</b></label>
                                                    <input type="text"  placeholder="CONCENTRADO" class="form-control input-sm" id="NUM_CONCENTRADO" name="NUM_CONCENTRADO" STYLE="WIDTH: 120PX;" value="'.$dataPro[0]['NUM_CONCENTRADO'].'" /> 
                                                </div>
                                            </div>    
                                        </div>
                                    </div> <!-- end card -->
                                    <div class="card" >
                                        <div class="header">
                                            <h4 class="title"><B>OBSERVACIONES MEDICAS</B></h4>
                                            <p class="category">Informaci&oacute;n Complementaria</p>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="4" id="OBS_MEDICAS" name="OBS_MEDICAS">'.$dataPro[0]['TXT_OBSMEDICAS'].'</textarea>
                                            <BR>
                                        </div>
                                    </div> <!-- end card -->
                                </div>
                            </form>
                        </div>
                     </div>  
                    
                    <hr>
                        <input type="hidden" id="cod_empresa" name="cod_empresa" value="'.$empresa.'"/>
                    <hr>

                    <div id="tabs_complementario" style="display:none;">
                      <!-- Nav tabs -->
                       <ul class="nav nav-pills  nav-justified" role="tablist">
                         <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">LISTADO MEDICAMENTOS</a></li>
                         <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">RESPONSABLES DEL TRATAMIENTO</a></li>
                       </ul>
                       <!-- Tab panes -->
                       <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="profile">
                                     <!--
                                     <div class="titleAnten">###NUM1###.- 
                                            Registro de Medicamentos e Insumos - <span style="color: #0096a5;font-size: 11px;"><i class="icon-info-sign"></i> 
                                            Se Recomienda Registrar los Insumos o Medicamentos al Final del Proceso.</span></div>
                                            <div id="INSUMOS" class="contenTi">
                                                ###INSUMOS###
                                            </div>
                                     -->
                                     <div class="content">
                                         <input type="hidden" id="codDiagnostico" value="">
                                         <input type="text" name="autocompletar" id="nomcie10" onkeypress="return alfanumericoSpace(event);" data-source="ssan_crearinterconsulta/autocompletar" onpaste="return false" class="autocompletar" style="width:97%;margin-bottom: 0;" placeholder="INDIQUE MEDICAMENTOS">
                                         <div class="autocomplete-jquery-results" id="muestralista" style="display:none;"></div>
                                     </div><!-- content -->  
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="messages">... 2 </div>
                                </div>
                             </div>
                            </div><!-- /.Final CuerpoPagina -->
                        <!--  Pie De Pagina -->
                    </div><!-- /.Fin Frontal  -->

                    <div class="col-sm-4 offset-sm-1 blog-sidebar"><!-- /.lateral  -->
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b>DATOS DEL PACIENTE</b></h4>
                                <p class="category">Informaci&oacute;n Basica</p>
                            </div>
                            <div class="content">
                                 <dl class="row">
                                    <dt class="col-sm-2"><i class="fa fa-user-circle" aria-hidden="true"></i></dt>
                                    <dd class="col-sm-10"><div id="txtnombre">&nbsp;'.$dataPro[0]['NOMPAC'].'</div></dd>
                                    <dt class="col-sm-2"><i class="fa fa-id-card-o" aria-hidden="true"></i></dt>
                                    <dd class="col-sm-10"><div id="txtrut">&nbsp;'.$dataPro[0]['RUTPAC'].'</div></dd>
                                    <dt class="col-sm-2"><i class="fa fa-mobile" aria-hidden="true"></i></dt>
                                    <dd class="col-sm-10"><div id="txtnumfono">&nbsp;'.$dataPro[0]['TELEFONOS'].'</div></dd>
                                    <dt class="col-sm-2"><i class="fa fa-birthday-cake" aria-hidden="true"></i></dt>
                                    <dd class="col-sm-10"><div id="txtxhappybirthday">&nbsp;'.$dataPro[0]['NACIMIENTO'].'</div></dd>
                                </dl>
                                <input type="hidden" id="txt_name_'.$IDHOJADIARIA.'"    name="txt_name_'.$IDHOJADIARIA.'"   value="'.$dataPro[0]['NOMPAC'].'" />
                                <input type="hidden" id="txt_run_'.$IDHOJADIARIA.'"     name="txt_run_'.$IDHOJADIARIA.'"    value="'.$dataPro[0]['RUTPAC'].'" />
                                <input type="hidden" id="txt_fono_'.$IDHOJADIARIA.'"    name="txt_fono_'.$IDHOJADIARIA.'"   value="'.$dataPro[0]['TELEFONOS'].'" />
                                <input type="hidden" id="txt_nac_'.$IDHOJADIARIA.'"     name="txt_nac_'.$IDHOJADIARIA.'"    value="'.$dataPro[0]['NACIMIENTO'].'" />
                            </div>
                        </div>
                        <hr>

                        <h5 class="title text-center">Informacion Complementaria</h5>
                        <div class="nav-container">
                            <ul class="nav nav-icons" role="tablist">
                                <li class="active">
                                    <a href="#description-logo" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-address-card-o" aria-hidden="true"></i><br> P.Seguridad</a>
                                </li>
                                <li class="">
                                    <a href="#map-logo" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br> E. Circuito</a>
                                </li>
                                <li class="">
                                    <a href="#filtro" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-thermometer-full" aria-hidden="true"></i><br> Filtro</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane active" id="description-logo">
                                <div class="card" style="margin-bottom:0px;">
                                    <div class="header">
                                        <h4 class="title"><b>PAUSA DE SEGURIDAD</b></h4>
                                        <p class="category">Informaci&oacute;n Complementaria</p>
                                    </div>
                                    <div class="content">
                                        <form id="FORM_PAUSASEGURIDAD" name="FORM_PAUSASEGURIDAD">
                                            <table class="table table-striped" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td style="width:60%" scope="row">
                                                        <p class="category">IND. DEL PACIENTE:</p>
                                                        <p class="category"><b>('.$name.')</b></p>
                                                    </td>
                                                    <td style="text-align:center;width:40%">
                                                        <select id="PAUSAS_PACIENTE_CORRECTO" name="PAUSAS_PACIENTE_CORRECTO" class="form-control input-sm">
                                                            <option value="1">SI</option> 
                                                            <option value="0">NO</option> 
                                                        </select> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td scope="row"><p class="category">C. Circuito Extracorp&oacute;reo <b>Lineas</b></p></td>
                                                    <td style="text-align:center">
                                                        <select id="PAUSAS_CIRCUITO_LINEAS" name="PAUSAS_CIRCUITO_LINEAS" class="form-control input-sm">
                                                            <option value="1">SI</option> 
                                                            <option value="0">NO</option> 
                                                        </select> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td scope="row"><p class="category">C. Circuito Extracorp&oacute;reo <b>Filtro</b></p></td>
                                                    <td style="text-align:center">
                                                        <select id="PAUSAS_CIRCUITO_FILTRO" name="PAUSAS_CIRCUITO_FILTRO" class="form-control input-sm">
                                                            <option value="1">SI</option> 
                                                            <option value="0">NO</option> 
                                                        </select> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td scope="row"><p class="category">T&deg; Monitor(&deg;C)<i class="fa fa-thermometer-empty" aria-hidden="true"></i></p></td>
                                                    <td style="text-align:center">
                                                        <input type="text"  placeholder="" class="form-control input-sm" id="NUM_T_MONITOR" name="NUM_T_MONITOR" onkeypress="return num_coma(event, this)" style="width: 90px;" size="5" maxlength="5" value="'.$dataPro[0]['NUM_T_MONITOR'].'" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td scope="row"><p class="category">Conductividad (US)</p></td>
                                                    <td style="text-align:center">
                                                        <input type="text"  placeholder="" class="form-control input-sm" id="NUM_CONDUCTIVIDAD" name="NUM_CONDUCTIVIDAD" onkeypress="return num_coma(event, this)" style="width: 90px;" size="5" maxlength="5" value="'.$dataPro[0]['NUM_CONDUCTIVIDAD'].'"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td scope="row"><p class="category">Test De Residuos (PPM)</p></td>
                                                    <td style="text-align:center">
                                                        <select id="NUM_TEST_RESIDUOS" name="NUM_TEST_RESIDUOS" class="form-control input-sm">
                                                            <option value="0">NO REACTIVO</OPCION>
                                                            <option value="1">REACTIVO</OPCION>     
                                                        </select>
                                                    </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $("#NUM_TEST_RESIDUOS").val('.$dataPro[0]['ID_TEST_RESIDUOS'].');
                                $("#PAUSAS_PACIENTE_CORRECTO").val('.$dataPro[0]['IND_PACIENTE_CORRECTO'].');
                                $("#PAUSAS_CIRCUITO_LINEAS").val('.$dataPro[0]['IND_CLINEAS'].');
                                $("#PAUSAS_CIRCUITO_FILTRO").val('.$dataPro[0]['IND_CFILTRO'].');
                            </script>
                            <div class="tab-pane" id="map-logo">
                                <div class="card" style="margin-bottom:0px;">
                                    <div class="header">
                                        <h4 class="title"><b>Estado Circuitos</b></h4>
                                        <p class="category">Informaci&oacute;n Complementaria</p>
                                    </div>
                                    <div class="content">
                                        <form id="FORM_ECIRCUITO" name="FORM_ECIRCUITO">
                                            <table id="table" class="table table-striped" width="100%">
                                                <tbody>
                                                  <tr>
                                                    <td data-title="ID">1.-</td>
                                                    <td data-title="Name">FILTRO</td>
                                                    <td data-title="Link"> 
                                                          <select id="SLT_FILTO" name="SLT_FILTO" class="form-control input-sm">
                                                              <option value="1">L</option> 
                                                              <option value="2">R</option> 
                                                              <option value="3">S</option>      
                                                          </select> 
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td data-title="ID">2.-</td>
                                                    <td data-title="Name">L. ARTERIAL</td>
                                                    <td data-title="Link"> 
                                                          <select id="SLT_ARTERIAL" name="SLT_ARTERIAL" class="form-control input-sm">
                                                              <option value="1">L</option> 
                                                              <option value="2">R</option> 
                                                              <option value="3">S</option>      
                                                          </select> 
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td data-title="ID">3.-</td>
                                                    <td data-title="Name">L. VENOSA</td>
                                                    <td data-title="Link">
                                                          <select id="SLT_VENOSA" name="SLT_VENOSA" class="form-control input-sm">
                                                              <option value="1">L</option> 
                                                              <option value="2">R</option> 
                                                              <option value="3">S</option>      
                                                          </select>
                                                     </td>
                                                  </tr>
                                                  </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>    
                        <script>
                            $("#SLT_FILTO").val('.$dataPro[0]['NUM_CI_FILTRO'].');
                            $("#SLT_ARTERIAL").val('.$dataPro[0]['NUM_CI_ARTERIAL'].');
                            $("#SLT_VENOSA").val('.$dataPro[0]['NUM_CI_VENOSA'].');
                        </script>
                            <div class="tab-pane" id="filtro">
                                    <div class="card" style="margin-bottom:0px;">
                                        <div class="header">
                                            <h4 class="title"><b>Filtro</b></h4>
                                            <p class="category">Informaci&oacute;n Complementaria</p>
                                        </div>
                                        <div class="content">
                                        <form id="FORM_FILTRO" name="FORM_FILTRO">
                                            <table id="table" class="table table-striped" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td data-title="ID">1.-</td>
                                                        <td data-title="Name">N&deg; USO FILTRO</td>
                                                        <td data-title="Link">
                                                            <input type="text" class="form-control input-sm" id="n_uso" name="n_uso"  onKeyPress="return num(event)" value="'.$dataPro[0]['NUM_USO_FILTRO'].'" size="8" maxlength="8">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td data-title="ID">2.-</td>
                                                        <td data-title="Name">V. RESIDUAL</td>
                                                        <td data-title="Link">
                                                            <input type="text" class="form-control input-sm" id="v_residual" name="v_residual" onKeyPress="return num_coma(event, this)" value="'.$dataPro[0]['NUM_V_RESIDUAL'].'" size="8" maxlength="8">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td data-title="ID">3.-</td>
                                                        <td data-title="Name">USO L ARTERIAL</td>
                                                        <td data-title="Link">
                                                            <input type="text" class="form-control input-sm" id="uso_l_arterial" name="uso_l_arterial" onKeyPress="return num(event)" value="'.$dataPro[0]['NUM_V_ARTERIAL'].'" size="8" maxlength="8">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td data-title="ID">4.-</td>
                                                        <td data-title="Name">USO L VENOSA</td>
                                                        <td data-title="Link"> 
                                                            <input type="text" class="form-control input-sm" id="uso_l_venosa" name="uso_l_venosa" onKeyPress="return num(event)" value="'.$dataPro[0]['NUM_V_VENOSA'].'" size="8" maxlength="8">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td data-title="ID">5.-</td>
                                                        <td data-title="Name">RUPTURA DE FIBRAS</td>
                                                        <td data-title="Link">
                                                            <select id="SLT_R_RFIBRAS" name="SLT_R_RFIBRAS" class="form-control input-sm">
                                                                <option value="0">NO</option> 
                                                                <option value="1">SI</option> 
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td data-title="ID">6.-</td>
                                                        <td data-title="Name">COAGULACI&Oacute;N DE FIBRAS</td> 
                                                        <td data-title="Link">
                                                            <select id="SLT_C_RFIBRAS" name="SLT_C_RFIBRAS" class="form-control input-sm">
                                                                <option value="0">NO</option> 
                                                                <option value="1">SI</option> 
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td data-title="ID">7.-</td>
                                                        <td data-title="Name">REACCI&Oacute;N A PIR&Oacute;GENOS</td>
                                                        <td data-title="Link"> 
                                                            <select id="SLT_R_PIROGENOS" name="SLT_R_PIROGENOS" class="form-control input-sm">
                                                                <option value="0">NO</option> 
                                                                <option value="1">SI</option> 
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>    
                            </div>
                        </div>
                        <script>
                            $("#SLT_R_RFIBRAS").val('.$dataPro[0]['IND_R_RFIBRAS'].');
                            $("#SLT_C_RFIBRAS").val('.$dataPro[0]['IND_C_RFIBRAS'].');
                            $("#SLT_R_PIROGENOS").val('.$dataPro[0]['IND_R_PIROGENOS'].');
                        </script>
                        <div class="list-group">
                            <a class="list-group-item" href="javascript:js_cSOLICITUDEEXAMENES('.$NUMFICHAE.',1)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></i>&nbsp; F. RESUMEN MENSUAL</a>
                            <a class="list-group-item" href="javascript:js_cBUSQUEDAHANTERIOR('.$NUMFICHAE.',1)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></i>&nbsp; H. DIARIA ANTERIORES MENSUAL</a>
                        </div>
                        <!--
                        <div class="sidebar-module">
                            <h4>Responsables Tratamiento</h4>
                            <ol class="list-unstyled">
                              <li><a href="#">Enfermera</a></li>
                              <li><a href="#">Medico</a></li>
                            </ol>
                        </div>
                        -->
                    </div><!-- /.blog-sidebar -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div>
                    
        <div id="REACIONESADVERSAS" class="tab-pane">
            <form id="FORM_RADVERSAS" name="FORM_RADVERSAS">
               '.$this->cargahtmlRelacionesAdversas($IDHOJADIARIA).'
            </form>
        </div>
        
        <div id="REGISTRO_ELECTRONICO" class="tab-pane">
            <button type="button" id="btn_registroclinico" class="btn btn-info btn-fill btn-wd" onclick="js_HistorialClinico('.$NUMFICHAE.','.$IDHOJADIARIA.','.$RUTPAC_ARRAY[0].')">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> VER REGISTRO CL&Iacute;NICO PACIENTE -> 
            </button>
            <hr>
            <div id="IFRAME_REGCLINICO"></div>
        </div>

        <script>
            $("#TipoViaDial").val('.$dataPro[0]['NUM_ID_TIPOVIA'].');
           
            $("#Sl_Hipo_sion1").val('.$dataPro[0]['IND_HIPOTENSION'].');
            $("#Sl_Ca_frio").val('.$dataPro[0]['IND_CALOFRIO'].');
            $("#Sl_F_bre").val('.$dataPro[0]['IND_FIEBRE'].');
            $("#Sl_Inf_catt").val('.$dataPro[0]['IND_ICVASCULAR'].');
            $("#Sl_Bact_meia").val('.$dataPro[0]['IND_BACTEREMIA'].');
            $("#Sl_Hep_b").val('.$dataPro[0]['IND_HEPATITIS_B'].');
            $("#Sl_Hep_c").val('.$dataPro[0]['IND_HEPATITIS_C'].');
            $("#Sl_mrtes_pro").val('.$dataPro[0]['IND_MDPROCEDIMIENTO'].');
        </script>
        <div id="SOLICITUDDEEXAMENES" class="tab-pane">
            '.$this->cargaIframeSolicitudExamenes($IDHOJADIARIA,$NUMFICHAE,$RUTPAC).'
        </div>
    </div>';
    
    $html.="<script>";
    if($templete == '1'){
            $html.="$('#optionAN').attr('checked',true);"
                . "$('#txt_prohoja').html('HOJA DE TRATAMIENTO MEDICO');"
                . "js_disabled_medica(false);"
                . "$('#optionAN').attr('checked',true);"
                . "$('#div_optionAN').hide();"
                . "$('#IND_MEDICO').addClass('active');"
                . "$('#TB_MEDICO').addClass('active');"
                . "$('#IND_ENFERMERIA').removeClass('active');"
                . "$('#TB_ENFERMERIA').removeClass('active');"
                . "";  
    } else if($templete == '2'){
            $html.="$('#txt_prohoja').html('HOJA DE TRATAMIENTO ENFERMERA');";
            if($dataPro[0]['IND_HDESTADO']=='0'){ 
                $html.="js_disabled_medica(true);"
                     . "$('#optionAN').attr('checked',true);";
            }
    }
    $html.="</script>"; 
    $TABLA[]                    =   array("id_html"=>"HTML_TRATAMIENTO","opcion" => "append","contenido"=>$html); 
    //DATOSREACIONESADVERSAS
    $formReacionesAd            =   $this->Ssan_hdial_asignacionpaciente_model->getDatosReacionesAdversas($IDHOJADIARIA);
    if(count($formReacionesAd)>0){
        foreach ($formReacionesAd as $row){
            $TABLA[]            =   array("id_html"=>"sl_".$row["IDHTML"],      "opcion" => "val",          "contenido"=>'1');  
            $TABLA[]            =   array("id_html"=>"txt_".$row["IDHTML"],     "opcion" => "disabled",     "contenido"=>'');  
            $TABLA[]            =   array("id_html"=>"txt_".$row["IDHTML"],     "opcion" => "val",          "contenido"=>$row["TXTOBS"]);  
        }
    }
    
    $TABLA[] = array("id_html"=>"MODAL_HORADIARIA",        "opcion" => "modalShow",    "contenido"=>""); 

    $this->output->set_output(json_encode($TABLA));
}


public function cargahtmlHojaDiaria_new(){
    if(!$this->input->is_ajax_request()){   show_404();     }



    $html   =    $this->load->view("ssan_hdial_hojatratamiento/html_hojatratamientodialisis",[],true);


    $this->output->set_output(json_encode([
        'html' => $html,
    ]));
}







public function iframeHistorialClinico(){
    if(!$this->input->is_ajax_request()){   show_404();     }
        $clave          =   $this->input->post("contrasena");          
        $valida         =   $this->ssan_spab_actexamen_model->validaClave($clave);
    if($valida){
        $RUT_PAC        =   $this->input->post("RUT_PAC");
        $NUM_FICHAE     =   $this->input->post("fichae");
        $idcita         =   $this->input->post("id");
        $TOKEN          =   $this->input->post("TOKEN"); 
        
        $rut            =   $valida->USERNAME;
        $NAME           =   $valida->NAME;
        $rutm           =   explode("-",$rut);
        $firmado_por    =   $rutm[0];   
        $sistema        =   '17';//QUE SISTEMA ES DIALISIS
        $token1         =   md5(rand(20,1000));
        $token          =   $idcita.$token1;
        //$valida       =   $this->ssan_spab_listaprotocoloqx_model->sqlRegistraConsultaHistorialClinico($NAME,$firmado_por,$NUM_FICHAE,$sistema,$idcita,$token,$RUT_PAC);
        $return         =   $this->ssan_hdial_eliminacionhojadiara_model->new_get_busquedatoken($sistema,$NUM_FICHAE,$firmado_por);
        
        $TABLA[]        =   array("id_html" => "contenido", "opcion" => "console", "contenido" => "--------------SERVER_ADDR--------------------"); 
        $TABLA[]        =   array("id_html" => "contenido", "opcion" => "console", "contenido" => $_SERVER['SERVER_ADDR']);
        $TABLA[]        =   array("id_html" => "contenido", "opcion" => "console", "contenido" => "---------------------------------------------");        
                
        if($return['STATUS']){
            if($_SERVER['SERVER_ADDR'] == '10.5.183.210'){
                //$IFRAME       =   '<iframe src="http://10.5.183.210/ssan_his_historialclinico?m=135&token='.$token.'"  style="overflow:hidden;height: 500px;width:100%;" width="100%"></iframe>'; 
                //$IFRAME       =   '<iframe src="http://10.5.183.210/ssan_his_historialclinico_new?m=135&token='.$token.'"  style="overflow:hidden;height: 500px;width:100%;" width="100%"></iframe>'; 
                $IFRAME         =   '<iframe src="http://10.5.183.210/ssan_his_historialclinico_new?m=135&'.$return['TOKEN_SESSION'].'&acc=1"  style="overflow:hidden;height: 500px;width:100%;" width="100%"></iframe>'; 
            } else if($_SERVER['SERVER_ADDR'] == '10.5.183.184'){ 
                //$IFRAME       =   '<iframe src="https://qa.esissan.cl/ssan_his_historialclinico?m=135&token='.$token.'" style="overflow:hidden;height: 500px;width:100%;" width="100%"></iframe>';  
                //$IFRAME       =   '<iframe src="https://qa.esissan.cl/ssan_his_historialclinico_new?m=135&?m=135&token='.$token.'" style="overflow:hidden;height: 500px;width:100%;" width="100%"></iframe>';  
                $IFRAME         =   '<iframe src="https://qa.esissan.cl/ssan_his_historialclinico_new?m=135&'.$return['TOKEN_SESSION'].'&acc=1" style="overflow:hidden;height: 500px;width:100%;" width="100%"></iframe>';  
            } else { 
                //$IFRAME       =   '<iframe src="https://www.esissan.cl/ssan_his_historialclinico?m=135&token='.$token.'" style="overflow:hidden;height: 500px;width:100%;" width="100%"></iframe>';  
                //$IFRAME       =   '<iframe src="https://www.esissan.cl/ssan_his_historialclinico_new?m=135&?m=135&token='.$token.'" style="overflow:hidden;height: 500px;width:100%;" width="100%"></iframe>';  
                $IFRAME         =   '<iframe src="https://www.esissan.cl/ssan_his_historialclinico_new?m=135&'.$return['TOKEN_SESSION'].'&acc=1" style="overflow:hidden;height: 500px;width:100%;" width="100%"></iframe>';  
            }
            $TABLA[]        =   array("id_html" => "btn_registroclinico",   "opcion" => "hide",         "contenido" => '');
            $TABLA[]        =   array("id_html" => "",                      "opcion" => "console",      "contenido" => $IFRAME);
            $TABLA[]        =   array("id_html" => "IFRAME_REGCLINICO",     "opcion" => "html",         "contenido" => $IFRAME);
        } else {
            $TABLA[]        =   array("id_html" => "contenido",             "opcion" => "jError",       "contenido" => 'Error De transacci&oacute;n');
        }
    } else {
        $TABLA[]        =   array("id_html" => "contenido",                 "opcion" => "jError",       "contenido" => 'Firma Incorrecta');
    }
    $this->output->set_output(json_encode($TABLA));
}


public function cargahtmlRelacionesAdversas(){
    if (!$this->input->is_ajax_request()) { show_404(); }
    $html='
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <div class="header">
                            <h4 class="title"><b> FORMULARIO DE REACCIONES ADVERSAS </b></h4>
                            <p class="category">Informaci&oacute;n Complementaria</p>
                        </div>
                    </div>
                    <div class="col-md-6"  style="text-align: -webkit-center;">
                         <div class="content">
                            <div class="contenedor">
                                <div class="form-group">
                                    <label for="input_FISTULACATETER"><b>FISTULA/CATETER</b></label>
                                    <select id="TipoViaDial" name="TipoViaDial" style="width:250px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                        <option value="0">FISTULA ARTERIOVENOSOS</option>
                                        <option value="1">CATETER VENOSO CENTRAL</option>
                                        <option value="2">FISTULA PROTESICA</option>
                                    </select> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-striped table-responsive">
                    <thead class="thead-inverse">
                      <tr>
                        <th>#</th>
                        <th>NOMBRE</th>
                        <th>SI/NO</th>
                        <th>OBSERVACI&Oacute;N</th>
                      </tr>
                    </thead>
                  <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>EMBOLIA A&Eacute;REA</td>
                        <td>
                            <select id="sl_emboleaaerea" name="sl_emboleaaerea" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input type="text" class="form-control form-control-sm"  placeholder="" id="txt_emboleaaerea" name="txt_emboleaaerea" size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>REACCI&Oacute;N A PIR&Oacute;GENO</td>
                        <td>
                            <select id="sl_recperitoneo" name="sl_recperitoneo" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_recperitoneo" name="txt_recperitoneo" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>CEFALEA</td>
                        <td>
                            <select id="sl_cefalea" name="sl_cefalea" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_cefalea" name="txt_cefalea" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                      <th scope="row">4</th>
                      <td>ARRITMIAS</td>
                        <td>
                            <select id="sl_arritmias" name="sl_arritmias" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_arritmias" name="txt_arritmias" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>HEMORRAGIA</td>
                        <td>
                            <select id="sl_homorragia" name="sl_homorragia" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_homorragia" name="txt_homorragia" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">6</th>
                        <td>SALIDA DE TROCAR</td>
                        <td>
                            <select id="sl_strocar" name="sl_strocar" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_strocar" name="txt_strocar" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">7</th>
                        <td>V&Oacute;MITOS</td>
                        <td>
                            <select id="sl_vomitos" name="sl_vomitos" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_vomitos" name="txt_vomitos" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">8</th>
                        <td>DOLOR ABDOMINAL</td>
                        <td>
                            <select id="sl_dabdominal" name="sl_dabdominal" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_dabdominal" name="txt_dabdominal" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">9</th>
                        <td>DOLOR PRECORDIAL</td>
                        <td>
                            <select id="sl_dprecardial" name="sl_dprecardial" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_dprecardial" name="txt_dprecardial" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">10</th>
                        <td>NAUSEAS</td>
                        <td>
                            <select id="sl_nauseas" name="sl_nauseas" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_nauseas" name="txt_nauseas" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">11</th>
                        <td>PARA CARDIO-RESPIRATORIO</td>
                        <td>
                            <select id="sl_parocardio" name="sl_parocardio" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_parocardio" name="txt_parocardio" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">12</th>
                        <td>PRURITO</td>
                        <td>
                            <select id="sl_prurito" name="sl_prurito" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_prurito" name="txt_prurito" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    
                    <!-- NUEVAS REACIONES ADVERSAS -->
                    <tr>
                        <th scope="row">13</th>
                        <td>HIPOTENSI&Oacute;N</td>
                        <td>
                            <select id="sl_hipotension" name="sl_hipotension" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_hipotension" name="txt_hipotension" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">14</th>
                        <td>REACCI&Oacute;N A &Aacute;CIDO PERACETICO</td>
                        <td>
                            <select id="sl_racidoperacetico" name="sl_racidoperacetico" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_racidoperacetico" name="txt_racidoperacetico" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">15</th>
                        <td>INFECCI&Oacute;N EN SITIO DE INSERCI&Oacute;N DEL CATETERISMO VASCULAR</td>
                        <td>
                            <select id="sl_infeccionsitiocavas" name="sl_infeccionsitiocavas" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_infeccionsitiocavas" name="txt_infeccionsitiocavas" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">16</th>
                        <td>ESCALOSFRIO</td>
                        <td>
                            <select id="sl_escalofrio" name="sl_escalofrio" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_escalofrio" name="txt_escalofrio" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <tr>
                        <th scope="row">17</th>
                        <td>FIEBRE</td>
                        <td>
                            <select id="sl_rfiebre" name="sl_rfiebre" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_rfiebre" name="txt_rfiebre" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    
                    <tr>
                        <th scope="row">18</th>
                        <td>BACTEREMIA</td>
                        <td>
                            <select id="sl_rbacteremia" name="sl_rbacteremia" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_rbacteremia" name="txt_rbacteremia" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    
                    <tr>
                        <th scope="row">19</th>
                        <td>HEPATITIS B</td>
                        <td>
                            <select id="sl_rhepatitib" name="sl_rhepatitib" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_rhepatitib" name="txt_rhepatitib" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    
                    <tr>
                        <th scope="row">20</th>
                        <td>HEPATITIS C</td>
                        <td>
                            <select id="sl_rhepatitic" name="sl_rhepatitic" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_rhepatitic" name="txt_rhepatitic" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    
                    <tr>
                        <th scope="row">21</th>
                        <td>MUERTE EN PROCEDIMIENTO</td>
                        <td>
                            <select id="sl_mprocedimiento" name="sl_mprocedimiento" style="width: 75px;" class="form-control input-sm" onchange="js_atcreacionesad(this.id,this.value)">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>    
                        </td>
                        <td><input id="txt_mprocedimiento" name="txt_mprocedimiento" type="text" class="form-control form-control-sm"  placeholder=""  size="10" maxlength="20" disabled value="" ></td>
                    </tr>
                    <!-- FIN REACIONES ADVERSAS -->


                  </tbody>
                </table>
               
            </div> 
        ';
    return $html;
}
    
public function cargahtmlRelacionesAdversas2(){
    if (!$this->input->is_ajax_request()) { show_404(); }
    $html='
    <div class="card">
        <table class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th scope="col" style="width:50%">EFECTOS</th>
                    <th scope="col" style="width:50%">
                        <select id="TipoViaDial" name="TipoViaDial" class="form-control">
                            <option value="1">FISTULA ARTERIOVENOSOS</option>
                            <option value="2">CATETER VENOSO CENTRAL</option>
                            <option value="3">FISTULA PROTESICA</option>            
                        </select>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><span style="border-right: #e3e3e3 solid 1px;">Hipotensi&oacute;n</span></th>
                    <td>
                        <span class="form-group col-md-6">
                            <select class="form-control" id="Sl_Hipo_sion1" name="Sl_Hipo_sion1">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </span>
                    </td>
                </tr>
                <tr>
                  <th scope="row"><span style="border-right: #e3e3e3 solid 1px;">Calofr&iacute;o</span></th>
                  <td>
                    <span class="form-group col-md-6">
                        <select name="Sl_Ca_frio" class="form-control" id="Sl_Ca_frio">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select>
                    </span>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><span style="border-right: #e3e3e3 solid 1px;">Fiebre</span></th>
                  <td><span class="form-group col-md-6">
                        <select name="Sl_F_bre" class="form-control" id="Sl_F_bre">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select>
                  </span></td>
                </tr>
                <tr>
                  <th scope="row"><span style="border-right: #e3e3e3 solid 1px;">Infecci&oacute;n en sitio de inserci&oacute;n del cateterismo vascular</span></th>
                    <td>
                        <span class="form-group col-md-6">
                            <select name="Sl_Inf_catt" class="form-control" id="Sl_Inf_catt">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </span>
                    </td>
                </tr>
                <tr>
                  <th scope="row"><span style="border-right: #e3e3e3 solid 1px;">Bacteremia</span></th>
                  <td>
                    <span class="form-group col-md-6">
                        <select name="Sl_Bact_meia" class="form-control" id="Sl_Bact_meia">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select>
                    </span>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><span style="border-right: #e3e3e3 solid 1px;">Hepatitis B</span></th>
                  <td>
                    <span class="form-group col-md-6">
                        <select name="Sl_Hep_b" class="form-control" id="Sl_Hep_b">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select>
                    </span>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><span style="border-right: #e3e3e3 solid 1px;">Hepatitis C</span></th>
                  <td><span class="form-group col-md-6">
                    <select name="Sl_Hep_c" class="form-control" id="Sl_Hep_c">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                    </select>
                  </span></td>
                </tr>
                <tr>
                  <th scope="row"><span style="border-right: #e3e3e3 solid 1px;">Muertes durante el procedimiento</span></th>
                  <td><div class="form-group col-md-6">
                    <select name="Sl_mrtes_pro" class="form-control" id="Sl_mrtes_pro">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                    </select>
                  </div></td>
                </tr>
            </tbody>
        </table>
    </div>        
    ';
    return $html;
}

public function HTML_addSignosVitales(){
    if (!$this->input->is_ajax_request()) { show_404(); }
    $this->output->set_output($this->htmlTomaSisnos(2)); 
}

public function guardaNuevoPacienteDeHermo(){
    if (!$this->input->is_ajax_request()) { show_404(); }
    $transaccion        =   '';
    $empresa            =   $this->session->userdata("COD_ESTAB");
    $password           =   $this->input->post('contrasena');
    $Fechas             =   $this->input->post('Fechas');
    $NUMINGRESO         =   $this->input->post('NUMINGRESO');
    $NUM_FICHAE         =   $this->input->post('NUM_FICHAE');
    $HR_INICIO          =   $this->input->post('HR_INICIO');
    $HR_FINAL           =   $this->input->post('HR_FINAL');
    $numRecurso         =   $this->input->post('numRecurso');
    $MesWork            =   explode("#",$this->input->post("MesWork"));
    $valida             =   $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
    if ($valida){
        $return         =   true;
        $usuarioh       =   explode("-",$valida->USERNAME);  
        $session        =   $usuarioh[0];
        $transaccion    =   $this->Ssan_hdial_asignacionpaciente_model->ModelconfirmaNuevoPaciente($empresa,$session,$Fechas,$NUMINGRESO,$NUM_FICHAE,$HR_INICIO,$HR_FINAL,$MesWork[0],$MesWork[1],$numRecurso); 
    } else {
        $return         =   false;        
    }
    $TABLA[0]           =   array("validez"         => $return); 
    $TABLA[1]           =   array("transaccion"     => $transaccion); 
    $TABLA[3]           =   array("sql"             => $Fechas); 
    $this->output->set_output(json_encode($TABLA)); 
}

public function guardaInfdormacionDialisis(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $transaccion        =   '';
    $empresa            =   $this->session->userdata("COD_ESTAB");
    $HrsIngreso         =   $this->input->post('HrsIngreso'); 
    $password           =   $this->input->post('contrasena');
    $NUMCITA            =   $this->input->post('NUM_CITA');
    $NUMFICHAE          =   $this->input->post('NUMFICHAE');
    $num_Maquina        =   $this->input->post('num_Maquina');
    $fechaHerno         =   $this->input->post('fechaHerno'); 
    $datosDialisis      =   $this->input->post('datosDialisis');//ARRAY
    $hojatra            =   $this->input->post('hojatra');
    $valida             =   $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
    if ($valida){
        $return         =   true;
        $usuarioh       =   explode("-",$valida->USERNAME);  
        $session        =   $usuarioh[0];
        $name           =   $valida->NAME;
        $transaccion    =   $this->Ssan_hdial_asignacionpaciente_model->ModelhoraTratamiento($empresa,$session,$NUMCITA,$NUMFICHAE,$num_Maquina,$datosDialisis,$hojatra,$name,$HrsIngreso,$fechaHerno); 
    } else {
        $return         =   false;        
    }
    $TABLA[0]           =   array("validez"         => $return); 
    $TABLA[1]           =   array("transaccion"     => $transaccion); 
    $TABLA[3]           =   array("sql"             => $valida); 
    $this->output->set_output(json_encode($TABLA)); 
}

public function guardaInformacionPrevio(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $transaccion        = '';
    $empresa            = $this->session->userdata("COD_ESTAB");
    $password           = $this->input->post('contrasena');
    $IDHOJADIARIA       = $this->input->post('IDHOJADIARIA');
    $datosDialisis      = $this->input->post('CreacionDialisis');//ARRAY
    $opcion             = $this->input->post('opcion');
    $fecha_aplicado     = $this->input->post('fecha_aplicado');
    #$valida             = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
    $valida             = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
    if($valida){
        $return         = true;
        $usuarioh       = explode("-",$_SESSION['USERNAME']);  
        $session        = $usuarioh[0];
        $transaccion    = $this->ssan_hdial_asignacionpaciente_model->ModelhoraTratamientoGuardadoGeneral($empresa,$session,$IDHOJADIARIA,$datosDialisis,$opcion,$fecha_aplicado); 
    } else {
        $return         = false;        
    }
    $TABLA[0]           = array("validez"         => $return); 
    $TABLA[1]           = array("transaccion"     => $transaccion); 
    $TABLA[3]           = array("sql"             => $valida); 
    $this->output->set_output(json_encode($TABLA)); 
}

public function cargaIframeSolicitudExamenes($IDHOJADIARIA,$NUMFICHAE,$RUT_PAC){
    $RUTPAC_ARE         =   explode("-",$RUT_PAC);
    $iframe             =   '';
    $NUM_FICHAE         =   $NUMFICHAE;
    $rut                =   $_SESSION['USERNAME'];
    $NAME               =   '--';
    $rutm               =   explode("-",$rut);
    $firmado_por        =   $rutm[0];  
    $sistema            =   '56';
    $token1             =   md5(rand(20,1000));
    $token              =   $IDHOJADIARIA.$token1.date("dmymis");
    $TIPO_ACCESS        =   0;
    $valida             =   [];
    #$valida            =   $this->Ssan_hdial_asignacionpaciente_model->sqlRegistraConsultaHistorialExamenes($NAME,$firmado_por,$NUM_FICHAE,$sistema,$IDHOJADIARIA,$token,$RUTPAC_ARE[0],$TIPO_ACCESS);
    if ($valida){
        //$iframe       =   '<iframe src="https://www.esissan.cl/solicituddeexamenes?token='.$token.'" style="overflow:hidden;height:500px;width:100%;" width="100%"></iframe>'; 
        //$iframe       =   '<iframe src="http://10.5.183.210/solicituddeexamenes?token='.$token.'" style="overflow:hidden;height:500px;width:100%;" width="100%"></iframe>'; 
    } else {
        $iframe         =   '<b>PROBLEMAS AL CARGAR</b>';
    }
    return $iframe;
}

public function iMedico_PesoSeco() {
    if(!$this->input->is_ajax_request()) {  show_404();  }
    $empresa                    = $this->session->userdata("COD_ESTAB");
    $numfichae                  = $this->input->post('numfichae');
    $html                       = '';
    
    $TXTACCESOVAS_2             = '';
    $TXTACCESOVAS_1             = '';
    
    $NUM_DIASVAS_1              = '';
    $NUM_DIASVAS_2              = '';
    
    $FEC_DIASVAS_1              = '';
    $FEC_DIASVAS_2              = '';
    
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
    $NUM_PESOSECO               = '';
    $SCRIPT                     = '';
   
    $aData                      = $this->ssan_hdial_asignacionpaciente_model->ModelInformacionComplementaria($empresa,$numfichae);    
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
        //INICIO
        $NUM_PESOSECO           = $aData[0]['NUM_PESOSECO']; 
        
        /*
        if($FEC_DIASVAS_1=='')  { }
        if($FEC_DIASVAS_2=='')  { }
        $SCRIPT                 = 'cal_fecha('.$FEC_DIASVAS_1.',1);cal_fecha('.$FEC_DIASVAS_2.',2);'
        */
    }
    
    $html.='
        <form id="Formimedico" name="Formimedico">
            <div class="card">
                    <div class="header">
                        <h4 class="title"><b> INDICACIONES MEDICAS </b></h4>
                        <p class="category">Informaci&oacute;n Complementaria</p>
                    </div>
                    <div class="content">
                       <fieldset>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">ACCESO VASCULAR 1</label>
                            <div class="col-sm-5"><input type="text" class="form-control input-sm"  id="TXT_ACCESOVAS_1"   name="TXT_ACCESOVAS_1" value="'.$TXTACCESOVAS_1.'"></div>
                            <label class="col-sm-1 control-label"><div id="txtdia_1"> FECHA 1</div></label>
                            <div class="col-sm-2"><input type="text" class="form-control input-sm"  id="FEC_DIAS_1"   name="FEC_DIAS_1" value="'.$FEC_DIASVAS_1.'" STYLE="WIDTH: 95PX;" onblur="cal_fecha(this.value,1)" ></div>
                            <label class="col-sm-1 control-label"><div id="num_dias_1">'.$NUM_DIASVAS_1.'</div></label>
                            <script>
                            $("#FEC_DIAS_1").datetimepicker({
                                format          : "DD-MM-YYYY",
                                maxDate         : new Date(),
                                locale          : "es-us",
                                icons           : 
                                                {
                                                    time        : "fa fa-clock-o"       ,
                                                    date        : "fa fa-calendar"      ,
                                                    up          : "fa fa-chevron-up"    ,
                                                    down        : "fa fa-chevron-down"  ,
                                                    previous    : "fa fa-chevron-left"  ,
                                                    next        : "fa fa-chevron-right" ,
                                                    today       : "fa fa-screenshot"    ,
                                                    clear       : "fa fa-trash"         ,
                                                    close       : "fa fa-remove"        ,
                                                }
                            });
                            </script>
                            <!--
                            <div class="col-sm-2"><input type="text" class="form-control input-sm"  id="NUM_DIAS_1"   name="NUM_DIAS_1" value="'.$NUM_DIASVAS_1.'"></div>
                            -->
                         </div>
                    </fieldset>
                    
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">ACCESO VASCULAR 2</label>
                            <div class="col-sm-5"><input type="text" class="form-control input-sm"  id="TXT_ACCESOVAS_2"   name="TXT_ACCESOVAS_2" value="'.$TXTACCESOVAS_2.'"></div>
                            <label class="col-sm-1 control-label">FECHA 2:</label>
                            <div class="col-sm-2"><input type="text" class="form-control input-sm"  id="FEC_DIAS_2"   name="FEC_DIAS_2" value="'.$FEC_DIASVAS_2.'" STYLE="WIDTH: 95PX;" onblur="cal_fecha(this.value,2)"></div>
                            <label class="col-sm-1 control-label"><div id="num_dias_2">'.$NUM_DIASVAS_2.'</div></label>
                            <script>
                            $("#FEC_DIAS_2").datetimepicker({
                                format          : "DD-MM-YYYY",
                                maxDate         : new Date(),
                                locale          : "es-us",
                                icons           : 
                                                {
                                                    time        : "fa fa-clock-o"       ,
                                                    date        : "fa fa-calendar"      ,
                                                    up          : "fa fa-chevron-up"    ,
                                                    down        : "fa fa-chevron-down"  ,
                                                    previous    : "fa fa-chevron-left"  ,
                                                    next        : "fa fa-chevron-right" ,
                                                    today       : "fa fa-screenshot"    ,
                                                    clear       : "fa fa-trash"         ,
                                                    close       : "fa fa-remove"        ,
                                                }
                            });
                            </script>     
                            <!--
                            <div class="col-sm-2"><input type="text" class="form-control input-sm"  id="NUM_DIAS_1"   name="NUM_DIAS_1" value="'.$NUM_DIASVAS_1.'"></div>
                            -->
                        </div>
                    </fieldset>
                   </div>
                   
                <hr>  
                <div class="content">
                    <div class="contenedor">
                        <div class="form-group">
                            <label for="QT"><b>TROCAR <br>(ARTERIAL)</b></label>
                            <input type="text"  placeholder="ARTERIAL" class="form-control input-sm"    id="NUM_ARTERIAL" name="NUM_ARTERIAL"   STYLE="WIDTH: 90PX;"  value="'.$NUM_TROCAR_ARTERIAL.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                        </div>
                        <div class="form-group">
                            <label for="QT"><b>TROCAR <br>(VENOSO)</b></label>
                            <input type="text"  placeholder="VENOSO" class="form-control input-sm"      id="NUM_VENOSO"   name="NUM_VENOSO"     STYLE="WIDTH: 90PX;" value="'.$NUM_TROCAR_VENOSO.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                        </div>
                        <div class="form-group">
                            <label for="QT"><b>HEPARINA <br>(I)</b></label>
                            <input type="text"  placeholder="INICIO" class="form-control input-sm"      id="NUM_INICIO" name="NUM_INICIO"   STYLE="WIDTH: 90PX;" value="'.$NUM_HEPARINA_INICIO.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                        </div>
                        <div class="form-group">
                            <label for="QT"><b>HEPARINA <br>(M)</b></label>
                            <input type="text"  placeholder="VENOSO" class="form-control input-sm"      id="NUM_MANTENCION"   name="NUM_MANTENCION"     STYLE="WIDTH: 90PX;" value="'.$NUM_HEPARINA_MAN.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                        </div>
                        <div class="form-group">
                            <label for="QT"><br><b>QT</b></label>
                            <input type="text"  placeholder="QT" class="form-control input-sm"          id="NUM_QT" name="NUM_QT" STYLE="WIDTH: 75PX;" value="'.$NUM_QT.'"  onKeyPress="return num_coma(event, this)" style="width: 90px;"/>
                        </div>
                        <div class="form-group">
                            <label for="QB"><br><b>QB</b></label>
                            <input type="text"  placeholder="QB" class="form-control input-sm"          id="NUM_QB" name="NUM_QB" STYLE="WIDTH: 75PX;" value="'.$NUM_QB.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                        </div>
                        <div class="form-group">
                            <label for="QD"><br><b>QD</b></label>
                            <input type="text"  placeholder="QD" class="form-control input-sm"          id="NUM_QD" name="NUM_QD" STYLE="WIDTH: 75PX;" value="'.$NUM_QD.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                        </div>
                        <div class="form-group">
                            <label for="MAX"><br><b>UF MAX</b></label>
                            <input type="text"  placeholder="UF MAX" class="form-control input-sm"      id="NUM_UFMAX" name="NUM_UFMAX" STYLE="WIDTH: 75PX;" value="'.$NUM_UFMAX.'"  onKeyPress="return num(event)" style="width: 90px;"/>
                        </div>
                        <div class="form-group">
                            <label for="K"><br><b>K</b></label>
                            <input type="text"  placeholder="K" class="form-control input-sm"           id="NUM_K" name="NUM_K" STYLE="WIDTH: 75PX;" value="'.$NUM_K.'"  onKeyPress="return num_coma(event, this)" style="width: 90px;"/>
                        </div>
                        <div class="form-group">
                            <label for="Na"><br><b>Na</b></label>
                            <input type="text"  placeholder="Na" class="form-control input-sm"          id="NUM_NA" name="NUM_NA" STYLE="WIDTH: 75PX;" value="'.$NUM_NA.'"  onKeyPress="return num(event)" style="width: 90px;"/> 
                        </div>
                        <div class="form-group">
                            <label for="CONCENTRADO"><br><b>CONCENTRADO</b></label>
                            <input type="text"  placeholder="CONCENTRADO" class="form-control input-sm" id="NUM_CONCENTRADO" name="NUM_CONCENTRADO" STYLE="WIDTH: 120PX;" value="'.$NUM_CONCENTRADO.'" /> 
                        </div>
                        <div class="form-group">
                            <label for="Na"><br><b>Peso Seco(gr)</b></label>
                            <input type="text"  placeholder="-" class="form-control input-sm"           id="input_pesoSeco" name="input_pesoSeco" STYLE="WIDTH: 75PX;" value="'.$NUM_PESOSECO.'"  onKeyPress="return num_coma(event, this)" style="width: 90px;"/> 
                        </div>
                    </div>    
                </div>
            </div>
        </form>
        ';     
    $TABLA[] = array("id_html" => "BODY_INFOHOJADIARIA", "opcion" => "append", "contenido" => $html);
    $this->output->set_output(json_encode($TABLA));
}  

public function borraSignosVitales(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $transaccion        = '';
    $empresa            = $this->session->userdata("COD_ESTAB");
    $password           = $this->input->post('contrasena');
    $id                 = $this->input->post('id');
    #$valida            = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
    $valida             = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
    if($valida){
        $return         = true;
        $usuarioh       = explode("-",$valida->USERNAME);  
        $session        = $usuarioh[0];
        $transaccion    = $this->ssan_hdial_asignacionpaciente_model->ModelborraSignoVital($empresa,$session,$id); 
    } else {
        $return         = false;        
    }
    $TABLA[0]           = array("validez"         => $return); 
    $TABLA[1]           = array("transaccion"     => $transaccion); 
    $TABLA[3]           = array("sql"             => $valida); 
    $this->output->set_output(json_encode($TABLA)); 
}

public function guardaInformacionimedico(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $transaccion        = '';
    $empresa            = $this->session->userdata("COD_ESTAB");
    $password           = $this->input->post('password');
    $numfichae          = $this->input->post('numfichae');
    $form               = $this->input->post('form');//ARRAY
    #$valida             = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
    $valida             = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
    if($valida){
        $return         = true;
        $usuarioh       = explode("-",$valida->USERNAME);  
        $session        = $usuarioh[0];
        $transaccion    = $this->ssan_hdial_asignacionpaciente_model->ModelguardaInformacionimedico($empresa,$session,$numfichae,$form); 
    } else {
        $return         = false;        
    }
    $TABLA[0]           = array("validez"       => $return); 
    $TABLA[1]           = array("transaccion"   => $transaccion); 
    $TABLA[3]           = array("sql"           => $valida); 
    $this->output->set_output(json_encode($TABLA)); 
}

//********************************************  NUEVO HTML ***************************//
public function controller_cargaHojasdiarias(){
    if (!$this->input->is_ajax_request())   { show_404(); }
    $empresa                                = $this->session->userdata("COD_ESTAB");
    $EVENTOS                                = '';
    $numFichae                              = '';
    $rutPac                                 = '';
    $month                                  = '';
    $year                                   = '';
    $running_day                            = '';
    $days_in_month                          = '';
    $numVisitas                             = '0';
    //$ind_template                         = '';
    $num_Maquina                            = $this->input->post("num_Maquina");
    $date                                   = explode("-",$this->input->post("fecha"));
    $fechaBusqueda                          = $this->input->post("fecha");
    $templete                               = $this->input->post("templete");
    $HD                                     = $this->input->post("HD");
    $KEY                                    = $this->input->post("val");
    
    //Lista de permisos
    $TABLA[]                                = array("id_html"=>"maquina_1","opcion" => "html","contenido"=> "");
    $aData                                  = $this->ssan_hdial_asignacionpaciente_model->proBuscaHojaDiaria_HD($HD);
    if(count($aData)>0){
        foreach($aData as $row){
            $btn                            = '';
            $msj                            = '';
            $input                          = '';
            $liPer                          = '';
            $msj_termino                    = '';
            $txtHr                          = $row['HRS_INICIO'];
            $AD_ID_ADMISION                 = $row['AD_ADMISION']; 
            $ID_TDHOJADIARIA                = $row['ID_TDHOJADIARIA']; 
            $AD_CIERRE                      = $row['AD_CIERRE']; 
            $NUM_FICHAE                     = $row['NUMFICHAE']; 
            $HD_ESTADO                      = $row['CIERREHD'];
          //$F_LOCAL                        = $row['F_LOCAL'];  
            $aPermisos                      = $this->ssan_hdial_generadorcodigo_model->Listadopremisos($empresa,$KEY,1);  
            
            if (count($aPermisos)){
                foreach ($aPermisos as $i => $per){
                            if ($per['IND']== '1'){
                    $liPer.='<li><a href="javascript:js_ingreso_egresopac('.$ID_TDHOJADIARIA.',1,'.$AD_ID_ADMISION.','.$per['ID'].')">'
                            . '<i class="fa fa-arrow-right" aria-hidden="true"></i><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;&nbsp;INGRESO PACIENTE</a></li>';    
                    } else  if ($per['IND']== '3'){
                    $liPer.='<li><a href="javascript:js_ingreso_egresopac('.$ID_TDHOJADIARIA.',3,'.$AD_ID_ADMISION.','.$per['ID'].')">'
                            . '<i class="fa fa-arrow-left" aria-hidden="true"></i><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;&nbsp;EGRESO PACIENTE</a></li>';        
                    } else  if ($per['IND']== '2'){
                    $liPer.='<li><a href="javascript:js_inicioProgama('.$row["NUMFICHAE"].','.$AD_ID_ADMISION.','.$ID_TDHOJADIARIA.',0,'.$per['ID'].')"><i class="fa fa-address-card-o" aria-hidden="true"></i> CORRECION HOJA DIARIA</a></li>';    
                    } else  if ($per['IND']== '4'){
                    $liPer.='<li><a href="javascript:js_eliminia_hdiaria('.$ID_TDHOJADIARIA.','.$AD_ID_ADMISION.','.$per['ID'].')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ELIMINA HOJA DIARIA</a></li>';          
                    }
                }
            } else {
                    $liPer.='<li><a href="#"><i class="fa fa-address-card-o" aria-hidden="true"></i> SIN INFORMACION </a></li>  ';    
            }
    
            if ($row ['CIERREHD']== ''){
                $msj_termino='<span class="label label-info"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;EN PROCESO</span>';
            } else {
                $msj_termino='<span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;FINALIZADO</span>';
            }
            
            $html   ='
                    <tr id="hd_'.$ID_TDHOJADIARIA.'">
                        <td scope="row" class="text-center">
                            '.$txtHr.'
                            <input type="hidden" id="AD_ID_ADMISION_'.$ID_TDHOJADIARIA.'"   name="AD_ID_ADMISION_'.$ID_TDHOJADIARIA.'"  value="'.$AD_ID_ADMISION.'"/>
                            <input type="hidden" id="AD_CIERRE_'.$ID_TDHOJADIARIA.'"        name="AD_CIERRE_'.$ID_TDHOJADIARIA.'"       value="'.$AD_CIERRE.'"/>
                            <input type="hidden" id="name_'.$ID_TDHOJADIARIA.'"             name="name_'.$ID_TDHOJADIARIA.'"            value="'.$row["NOMPAC"].'"/>
                        </td>
                        <td>'.$row["NOMPAC"].' <b>('.$row["RUTPAC"].')</b>'.$input.'</td>
                        <td>'.$row["NACIMIENTO"].'</td>
                        <td class="text-center">'.$ID_TDHOJADIARIA.'</td>
                        <td>'.$msj_termino.'</td>
                        <td class="text-center">
                            <div class="content">
                                <div class="dropdown">
                                    <button class="btn btn-info btn-fill dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-user-circle" aria-hidden="true"></i><span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">'.$liPer.'</ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    ';
            $TABLA[]    = array("id_html"=>"maquina_1","opcion" => "append",    "contenido"=> $html);   
        }  
    } else {
            $txtMenjaje=    '
                            <div class="alert alert-danger">
                                <strong><i class="fa fa-user-times" aria-hidden="true"></i>SIN HOJA DIRARIA</strong> 
                                No se han encontrados <b>H.D.</b> en el turno y m&aacute;quina seleccionado 
                            </div> 
                            ';
            $TABLA[]        = array("id_html"=>"maquina_1","opcion"=>"append","contenido"=>"<tr><td colspan='6'>$txtMenjaje</td></tr>");   
    }
    
    /*
    <li><a href="javascript:js_ingreso_egresopac('.$ID_TDHOJADIARIA.',1,'.$AD_ID_ADMISION.')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> INGRESO PACIENTE</a></li>
    <li><a href="javascript:js_ingreso_egresopac('.$ID_TDHOJADIARIA.',3,'.$AD_ID_ADMISION.')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EGRESO PACIENTE</a></li>
    <li><a href="javascript:js_eliminia_hdiaria('.$ID_TDHOJADIARIA.',3,'.$AD_ID_ADMISION.')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ELIMINA HOJA DIARIA</a></li>
    <li><a href="javascript:js_inicioProgama('.$row["NUMFICHAE"].','.$AD_ID_ADMISION.','.$ID_TDHOJADIARIA.',0)">  <i class="fa fa-address-card-o" aria-hidden="true"></i> CORRECION HOJA DIARIA</a></li>  
    */ 
    $this->output->set_output(json_encode($TABLA));
}

public function correcion_ingreso_egreso(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $empresa            = $this->session->userdata("COD_ESTAB");
    $NUM_PESOSECO       = '';
    $HD                 = $this->input->post("HD");
    $OP                 = $this->input->post("OP"); 
    $ID_ADMISION        = $this->input->post("ID_ADMISION"); 
    $DATA               = $this->ssan_hdial_asignacionpaciente_model->getDatosGeneralesxDial($HD);
    
    //***********************************************************************************************
    //**********************************************************************************************
    //**********************************************************************************************
    //**********************************************************************************************
    
            if ($OP==1){
        $TABLA[]        = array("id_html"=>"HTML_INICIODEDIALISIS","opcion" => "append","contenido"=> $this->htmlINICIOPROGRAMACION($NUM_PESOSECO));    
    } else  if ($OP==3){
        $html           = '
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="header">
                                         <h4 class="title"><b>DATOS DEL PACIENTE</b></h4>
                                         <p class="category">Informaci&oacute;n Basica</p>
                                     </div>
                                    <div class="content">
                                         <dl class="row">
                                           <dt class="col-sm-2"><i class="fa fa-user-circle" aria-hidden="true"></i></dt>
                                           <dd class="col-sm-10"><div id="txtnombre">&nbsp;'.$DATA[0]['NOMPAC'].'  </div></dd>
                                           <dt class="col-sm-2"><i class="fa fa-id-card-o" aria-hidden="true"></i></dt>
                                           <dd class="col-sm-10"><div id="txtrut">&nbsp;'.$DATA[0]['RUTPAC'].'  </div></dd>
                                           <dt class="col-sm-2"><i class="fa fa-mobile" aria-hidden="true"></i></dt>
                                           <dd class="col-sm-10"><div id="txtnumfono">&nbsp;'.$DATA[0]['TELEFONOS'].' </div></dd>
                                           <dt class="col-sm-2"><i class="fa fa-birthday-cake" aria-hidden="true"></i></dt>
                                           <dd class="col-sm-10"><div id="txtxhappybirthday">&nbsp;'.$DATA[0]['NACIMIENTO'].' </div></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title"><b>FINAL PROGRAMACI&Oacute;N</b></h4>
                                        <p class="category">Informaci&oacute;n Basica</p>
                                    </div>
                                    <div class="contenedor">
                                        <div class="form-group">
                                            <label for="prsopostdialisis"><b>PESO POST-DI&Aacute;LISIS</b></label>
                                            <input type="text"  placeholder="-" class="form-control input-sm" id="prsopostdialisis_term"    name="prsopostdialisis_term"   style="width: 90px;" onkeypress="return soloNumeros(event,this.id);" size="6" maxlength="6"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtperdidasdepeso"><b>PERDIDA DE PESO INTERDIALISIS</b></label>
                                            <input type="text"  placeholder="-" class="form-control input-sm" id="txtperdidasdepeso_term"   name="txtperdidasdepeso_term"  style="width: 90px;" onkeypress="return soloNumeros(event,this.id);" size="6" maxlength="6"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <form method="get" action="#" class="form-horizontal" id="terminoDialisis" name="terminoDialisis" >    
                                    <div class="card">
                                        <div class="header">
                                            <h4 class="title"><b>PROFESIONALES DECONEXI&Oacute;N</b></h4>
                                            <p class="category">Informaci&oacute;n Basica</p>
                                        </div>
                                        <div class="content">
                                             <dl class="row">
                                                <dt class="col-sm-4"><i class="fa fa-user-circle" aria-hidden="true""></i>ENFERMERO</dt>
                                                <dd class="col-sm-8"><select id="slc_enfermeria" name="slc_enfermeria" style="width: 100%;" class="form-control input-sm"></select></dd>
                                                <dt class="col-sm-4"><i class="fa fa-user-circle-o" aria-hidden="true"></i> TEC. ENFERMERIA</dt>
                                                <dd class="col-sm-8"><select id="slc_tecpara" name="slc_tecpara" style="width: 100%;" class="form-control input-sm"></select></dd>
                                                <dt class="col-sm-4"><i class="fa fa-user-md" aria-hidden="true"></i> MEDICO</dt>
                                                <dd class="col-sm-8"><select id="slc_medico" name="slc_medico" style="width: 100%;" class="form-control input-sm"></select></dd>
                                            </dl>
                                        </div>
                                    </div> 
                                </form>
                            </div>
                            
                        </div>  
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title"><b>DATOS DE DECONEXI&Oacute;N</b></h4>
                                        <p class="category">Informaci&oacute;n Basica</p>
                                    </div>
                                    <div class="contenedor">
                                        <div class="form-group">
                                            <label for="txtHoraIngresoPre"><b>HORA DESCONEXI&Oacute;N</b></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                                <input type="time" class="form-control input-sm" id="txtHoraEgreso" name="txtHoraEgreso" style="width:100px;height:31px" >
                                             </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="form_txttotalufconseguida"><b>TOTAL UF CONSEGUIDA</b></label>
                                            <div class="input-group">
                                                <input type="text"  placeholder="-" class="form-control input-sm" id="txttotalufconseguida" name="txttotalufconseguida" style="width: 90px;" onkeypress="return num_coma(event, this)"/>
                                                <select id="txttotalufconseguida_um" name="txttotalufconseguida_um" class="form-control input-sm" style="width:68px;">
                                                    <option value="0">ML</option>
                                                    <option value="1">L</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="form_volsangreacomulado"><b>VOL. DE SANGRE ACOMULADO</b></label>
                                            <input type="text"  placeholder="-" class="form-control input-sm" id="volsangreacomulado" name="volsangreacomulado" style="width: 90px;" onkeypress="return num_coma(event, this)"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtHoraIngresoPre"><b>DESINFECCCI&Oacute;N DE LA MAQUINA</b></label>
                                            <div class="input-group">
                                                <select id="SL_DESIFCACCIONMAQUINA" name="SL_DESIFCACCIONMAQUINA" class="form-control input-sm" style="width: 120px;">
                                                    <option value="1">SI</option> 
                                                    <option value="0">NO</option> 
                                                </select>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtHoraIngresoPre"><b>DIALIZADOR POST DI&Aacute;LISIS</b></label>
                                            <div class="input-group">
                                               <select id="SL_DIALIZADORDIAL" name="SL_DIALIZADORDIAL" class="form-control input-sm" style="width: 220px;">
                                                    <option value="1">LIMPIO</option> 
                                                    <option value="2">SUCIO</option> 
                                                    <option value="3">ROTO</option> 
                                                    <option value="4">MUCHAS FIBRAS COAGULADAS</option> 
                                                </select>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="for_num_kt_b"><b>Kt/V</b></label>
                                            <input type="text"  placeholder="-" class="form-control input-sm" id="num_kt_b" name="num_kt_b" style="width: 90px;" onkeypress="return num_coma(event,this)"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title"><b>* SIGNOS VITALES POST-DIALISIS</b></h4>
                                        <p class="category">Ingrese Signos vitales posterior de la conexi&oacute;n de la maquina - (*) Datos no obligatorio</p>
                                    </div>
                                    '.$this->htmlTomaSisnos(3).'
                                </div>
                            </div>
                        </div>
                    ';
        $TABLA[]    = array("id_html"=>"HTML_INICIODEDIALISIS","opcion" => "append","contenido"=> $html); 
    }
    
    //***************************************************************************************************
    #$aData              = $this->ssan_hdial_asignacionpaciente_model->profActvNuevaAgenda($empresa);
    
    $aData              = $this->ssan_hdial_asignacionpaciente_model->profActvNuevaAgenda_por_mantenedor($empresa);
    
    if (count($aData)>0){
        foreach ($aData as $row){
            $id_HTML    = '';
                    
                    if ($row['IND_TIPOATENCION'] == '01' || $row['IND_TIPOATENCION'] == '15'){         
                        $id_HTML    = 'slc_medico';
            } else  if ($row['IND_TIPOATENCION'] == '02'){                  
                        $id_HTML    = 'slc_enfermeria';
            } else  if ($row['IND_TIPOATENCION'] == '12'){                  
                        $id_HTML    = 'slc_tecpara';
            }
            $TABLA[]    = array("id_html"=>$id_HTML,  "opcion" => "append",  "contenido"=> '<option value="'.$row['COD_RUTPRO'].'"> '.$row['NOM_PROFE'].' </option>');
        }
    }
    
    //INICIO DEVUELVE DATOS RRHH
    $hhrr               = $this->ssan_hdial_asignacionpaciente_model->sql_BusquedaRRHHHD($HD,$OP);
    if(count($hhrr)>0){
        foreach($hhrr as $i => $row){
                    if ($row['COD_TPROFE'] == 'ENFE'){
            $TABLA[]    = array("id_html"=>"slc_enfermeria",                "opcion"    => "val",  "contenido"=> $row['COD_RUTPRO']);    
            } else  if ($row['COD_TPROFE'] == 'TPAR'){
            $TABLA[]    = array("id_html"=>"slc_tecpara",                   "opcion"    => "val",  "contenido"=> $row['COD_RUTPRO']);    
            } else {
            $TABLA[]    = array("id_html"=>"slc_medico",                    "opcion"    => "val",  "contenido"=> $row['COD_RUTPRO']);    
            }
        }
    }
    //FINAL DEVUELVE DATOS RRHH
    
    
    
    $SIGV               = $this->ssan_hdial_asignacionpaciente_model->getDatosSignosVitales($HD,$OP);
    if(count($SIGV)>0){
        
            $TABLA[]    = array("id_html"=>"txtHoraIngreso",                "opcion" => "val",  "contenido"=> $SIGV[0]['HORA']);   
            $TABLA[]    = array("id_html"=>"txtpresionalterial_s",          "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_PARTERIAL_S']);   
            $TABLA[]    = array("id_html"=>"txtpresionalterial_d",          "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_PARTERIAL_D']); 
            $TABLA[]    = array("id_html"=>"txtpulso",                      "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_PULSO']); 

            $TABLA[]    = array("id_html"=>"txttpaciente",                  "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_TPACIENTE']); 
            $TABLA[]    = array("id_html"=>"txttemmonitor",                 "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_TMONITOR']); 

            $TABLA[]    = array("id_html"=>"Q_B_PROG",                      "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_QBPROG']); 
            $TABLA[]    = array("id_html"=>"Q_B_EFEC",                      "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_QBEFEC']); 
            $TABLA[]    = array("id_html"=>"TXTPA",                         "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_PA']); 
            $TABLA[]    = array("id_html"=>"TXTPV",                         "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_PV']); 
            $TABLA[]    = array("id_html"=>"TXTPTM",                        "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_PTM']); 

            $TABLA[]    = array("id_html"=>"TXTCOND",                       "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_COND']); 
            $TABLA[]    = array("id_html"=>"TXTUFH",                        "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_UFH']); 
            $TABLA[]    = array("id_html"=>"TXTUFACOMULADA",                "opcion" => "val",  "contenido"=> $SIGV[0]['NUM_UFACOMULADA']); 
            $TABLA[]    = array("id_html"=>"TXTINGRESO",                    "opcion" => "val",  "contenido"=> $SIGV[0]['TXT_INGRESO']); 
            $TABLA[]    = array("id_html"=>"TXTOBSERVACIONES",              "opcion" => "val",  "contenido"=> $SIGV[0]['TXTOBSERVACIONES']); 

            
                    if($OP==1)  {
            
            $ADMISION   = $this->ssan_hdial_asignacionpaciente_model->sql_busquedaEstadoAdmision($ID_ADMISION);  

            $TABLA[]    = array("id_html"=>"txtHoraIngresoPre",             "opcion" => "val",  "contenido"=> $ADMISION[0]['HR_ADMISION']);   
            $TABLA[]    = array("id_html"=>"input_pesoSeco",                "opcion" => "val",  "contenido"=> $DATA[0]['NUM_PESOSECO']);   
            $TABLA[]    = array("id_html"=>"hd_anterior",                   "opcion" => "val",  "contenido"=> $DATA[0]['NUM_HDPESOANTERIOR']);   
            $TABLA[]    = array("id_html"=>"pesopredialisis",               "opcion" => "val",  "contenido"=> $DATA[0]['NUM_PESOPREDIALISIS']);   
            $TABLA[]    = array("id_html"=>"alza_interdialisis",            "opcion" => "val",  "contenido"=> $DATA[0]['NUM_INTERDIALISIS']); 
            $TABLA[]    = array("id_html"=>"ufprograma",                    "opcion" => "val",  "contenido"=> $DATA[0]['NUM_UFPROGRAMADA']); 

        } else      if($OP==3){
            
          //$FEC        = $this->ssan_hdial_asignacionpaciente_model->sql_FechaEgreso($HD);
            
            $TABLA[]    = array("id_html"=>"txtHoraEgreso",                 "opcion" => "val",  "contenido"=> $DATA[0]['HORA_DESCONEXION']); 
            
            $TABLA[]    = array("id_html"=>"prsopostdialisis_term",         "opcion" => "val",  "contenido"=> $DATA[0]['NUM_PESOPOSTDIALISIS']); 
            $TABLA[]    = array("id_html"=>"txtperdidasdepeso_term",        "opcion" => "val",  "contenido"=> $DATA[0]['NUM_PESOINTERDIALISIS']);   
            $TABLA[]    = array("id_html"=>"txttotalufconseguida",          "opcion" => "val",  "contenido"=> $DATA[0]['NUM_TOTALUFCONSEGIDA']); 
            $TABLA[]    = array("id_html"=>"volsangreacomulado",            "opcion" => "val",  "contenido"=> $DATA[0]['NUM_VOLSANGREACOMULADA']);   
            $TABLA[]    = array("id_html"=>"SL_DESIFCACCIONMAQUINA",        "opcion" => "val",  "contenido"=> $DATA[0]['IND_DESIFCACCIONMAQUINA']);   
            $TABLA[]    = array("id_html"=>"SL_DIALIZADORDIAL",             "opcion" => "val",  "contenido"=> $DATA[0]['IND_DIALIZADORDIAL']);   
            $TABLA[]    = array("id_html"=>"num_kt_b",                      "opcion" => "val",  "contenido"=> $DATA[0]['NUM_KT_V']); 
        }
        
    } else {
            $TABLA[]    = array("id_html"=>"respuesta",                     "opcion" => "html",       "contenido"=> "<script>msj_null($OP)</script>"); 
    }
    
    $this->output->set_output(json_encode($TABLA));
}

public function guardacorrecionhd(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    
    $transaccion            = '';
    $transaccion2           = '';
    $empresa                = $this->session->userdata("COD_ESTAB");
    $password               = $this->input->post('contrasena');
    $HD                     = $this->input->post('HD');
    $OP                     = $this->input->post('OP');
    $ID_ADMISION            = $this->input->post('ID_ADMISION');
    $fec_dial               = $this->input->post('fec_dial'); 
    $hora_dial              = $this->input->post('hora_dial'); 
    $form                   = $this->input->post('datosDialisis');//ARRAY
    $IDCORRECION            = $this->input->post('IDCORRECION'); 
    $KEY                    = $this->input->post('KEY'); 
    #$valida                 = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
    $valida             = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
    if($valida){
        $return             = true;
        $usuarioh           = explode("-",$valida->USERNAME);  
        $session            = $usuarioh[0];
        $transaccion        = $this->ssan_hdial_asignacionpaciente_model->Modelguardacorrecionhd($empresa,$session,$HD,$OP,$ID_ADMISION,$form,$fec_dial,$hora_dial,$IDCORRECION,$KEY); 
    } else {
        $return             = false;        
    }
    $TABLA[0]               = array("validez"       => $return); 
    $TABLA[1]               = array("transaccion"   => $transaccion); 
    $TABLA[3]               = array("sql"           => $valida); 
    $TABLA[4]               = array("respuesta"     => $transaccion); 
    $TABLA[5]               = array("KEY"           => $this->session->userdata("M5")); 
    $this->output->set_output(json_encode($TABLA)); 
}

public function validaCodigo(){
    if(!$this->input->is_ajax_request()){ show_404(); }
    $empresa                = $this->session->userdata("COD_ESTAB");
    $transaccion            = '';
    $md5                    = '';
    $error                  = '';
    $estados                = '';
    $return                 = '';
    $TIMERANGE              = '';
    $date                   = '';
    $password               = $this->input->post('contrasena');
    $KEY                    = $this->input->post('NCORREC');
    $this->session->unset_userdata('HD');
    $this->session->unset_userdata('SY');
    $this->session->unset_userdata('M5');
    #$valida                 = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
    $valida                 = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
    //IND_ESTADO
    if($valida){
        $return             = true;
        $usuarioh           = explode("-",$valida->USERNAME);  
        $session            = $usuarioh[0];
        $aData              = $this->ssan_hdial_generadorcodigo_model->ListadoCodigosGenerados($empresa,$estados,$KEY); 
        //$aData[0]['NUM_REDICION']
        if(count($aData)>0){
            $TIMERANGE      = $aData[0]['TIMERANGE'];
                    if($session != $aData[0]['RUTPRO']){//llave con la firma simple
                $error      = '2';
            } else  if($TIMERANGE == '0'){//la LLave dentro del range
                $error      = '3';
            } else  if($empresa != $aData[0]['COD_CORRECEMP']){//la LLave dentro de empresa de logeo
                $error      = '5';
            } else  if($aData[0]['ESTADO']!='1'){//la LLave Se uso
                $error      = '6';
            } else  if($aData[0]['NUM_REDICION'] == '0'){//la LLave Se uso 2
                $error      = '6';
            } else {
                //$md5      = md5(time()."#".$aData[0]['HD']);
                $md5        = md5(time());
                $aUpda      = $this->ssan_hdial_generadorcodigo_model->uPdateKey($empresa,$session,$aData[0]['ID'],$md5); 
                if(count($aUpda)>0){
                $this->session->set_userdata('HD',$aData[0]['HD']);
                $this->session->set_userdata('SY','1'); 
                $this->session->set_userdata('M5',$md5);     
                } else {
                $error      = '4';       
                }
            }
        } else {
                $error      = '1';//llave no existe!
                $return     = true;
        }
    } else {
                $return     = false;        
    }
    $TABLA[0]               = array("validez"       => $return); 
    $TABLA[1]               = array("transaccion"   => $transaccion); 
    $TABLA[2]               = array("id_error"      => $error); 
    $TABLA[3]               = array("sql"           => md5(time())); 
    $TABLA[4]               = array("sql"           => md5(time())); 
    $TABLA[5]               = array("cod"           => $md5); 
    $this->output->set_output(json_encode($TABLA)); 
}

public function desabilitahd(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $empresa                = $this->session->userdata("COD_ESTAB");
    $password               = $this->input->post('contrasena');
    $IDHOJADIARIA           = $this->input->post('IDHOJADIARIA');
    $AD_ID_ADMISION         = $this->input->post('AD_ID_ADMISION');
    $ID_TE                  = $this->input->post('ID_TE');
    #$valida                 = $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
    $valida             = $this->Ssan_hdial_ingresoegresopaciente_model->validaClave($password);
    if($valida){
        $return             = true;
        $usuarioh           = explode("-",$valida->USERNAME);  
        $session            = $usuarioh[0];
        $transaccion        = $this->ssan_hdial_asignacionpaciente_model->Modeldesabilitahd($empresa,$session,$IDHOJADIARIA,$AD_ID_ADMISION,$ID_TE); 
    } else {
        $return             = false;        
    }
    $TABLA[0]               = array("validez"       => $return); 
    $TABLA[1]               = array("transaccion"   => $transaccion); 
    $TABLA[3]               = array("sql"           => $valida); 
    $TABLA[4]               = array("respuesta"     => $transaccion); 
    $TABLA[5]               = array("KEY"           => ''); 
    $this->output->set_output(json_encode($TABLA)); 
    
}

public function validaHD(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $empresa                = $this->session->userdata("COD_ESTAB");
    $key                    = $this->input->post('val');
    $codKey                 = $this->input->post('val2');
    $M5                     = $this->session->userdata("M5");
    if($key === $M5)    {
        $HD                 = $this->session->userdata("HD");
        $TABLA[]            = array("id_html"=>"", "opcion" => "console", "contenido"=> $HD);  
        $DATA               = $this->ssan_hdial_asignacionpaciente_model->getDatosGeneralesxDial($HD);
        if(count($DATA)>0){
        $TABLA[]            = array("id_html"=>"numFecha",      "opcion" => "val",      "contenido"=> $DATA[0]['FECHA_HEMODIALISIS']);     
        $TABLA[]            = array("id_html"=>"num_Maquina",   "opcion" => "val",      "contenido"=> $DATA[0]['NOM_RMDIALISIS']);  
        $TABLA[]            = array("id_html"=>"maquina_2",     "opcion" => "hide",     "contenido"=> '');  
        $TABLA[]            = array("id_html"=>"respuesta",     "opcion" => "append",   "contenido"=>'<script>cargaHojasDiarias(null,'.$HD.');</script>'); 
        //actualiza lista de permisos
        $TABLA[]            = array("id_html"=>"lista_premisos",  "opcion" => "html",     "contenido"=> '');  
        $aData              = $this->ssan_hdial_generadorcodigo_model->Listadopremisos($empresa,$codKey,'');    
        $ol                 = '';
        if(count($aData)>0){  foreach ($aData as $row){ $ol.= ' <li>'.$row['TXT_PERMISO'].' ('.$row['TXT_ESTADO2'].')</li>';  }
        }
        $TABLA[]            = array("id_html"=>"lista_premisos",  "opcion" => "append",     "contenido"=> $ol); 
        //actualiza lista de permisos
        } else {
        $TABLA[]            = array("id_html"=>"", "opcion" => "jAlert", "contenido"=> ' NO EXISTE INFORMACI&Oacute;N DE LA HOJA DIR&Iacute;A');      
        }
    } else {
        $TABLA[]            = array("id_html"=>"", "opcion" => "jAlert", "contenido"=> 'ERROR');    
    }
    $this->output->set_output(json_encode($TABLA)); 
}

public function cargaPermisos_hd(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $key                    = $this->input->post('ID');
    $DATA                   = $this->ssan_hdial_asignacionpaciente_model->getActualizaPermiso($_SESSION['USERNAME'],$key);
    if ($DATA){
        $TABLA[]            = array("id_html" => "", "opcion" => "console", "contenido" => 'SI');
    } else {
        $TABLA[]            = array("id_html" => "", "opcion" => "console", "contenido" => 'NO');
    }
    //$TABLA[]              = array("id_html" => "num_correcionhd", "opcion" => "val", "contenido" => '');
    $this->output->set_output(json_encode($TABLA)); 
}

public function ver_sessiones(){
    if(!$this->input->is_ajax_request()) { show_404(); }
    $TABLA[]                = array("id_html"=>"", "opcion" => "console", "contenido"=> $this->session->userdata("HD")); 
    $TABLA[]                = array("id_html"=>"", "opcion" => "console", "contenido"=> $this->session->userdata("SY")); 
    $TABLA[]                = array("id_html"=>"", "opcion" => "console", "contenido"=> $this->session->userdata("M5")); 
    $this->output->set_output(json_encode($TABLA)); 
}

function check_in_range($start_date, $end_date, $date_from_user) {
            $start_ts   = strtotime($start_date);
            $end_ts     = strtotime($end_date);
            $user_ts    = strtotime($date_from_user);
    return (($user_ts>=$start_ts)&&($user_ts<=$end_ts));
}



}

