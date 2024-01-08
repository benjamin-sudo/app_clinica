<?php

class Ssan_bdu_creareditarpaciente extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("ssan_bdu_creareditarpaciente_model");
    }

    public function index(){
        $this->output->set_template('blank');
        $data       =   [
                            'USERNAME'  =>  $this->session->userdata('USERNAME'),
                            'COD_ESTAB' =>  $this->session->userdata('COD_ESTAB')
                        ];
        $this->load->css("assets/ssan_bdu_creareditarpaciente/css/styles.css");
        $this->load->js("assets/ssan_bdu_creareditarpaciente/js/javascript.js");
        $this->load->view('ssan_bdu_creareditarpaciente/Ssan_bdu_creareditarpaciente_view',$data);
    }

    public function function_test(){
        if (!$this->input->is_ajax_request()) {  show_404();  }
        $return_data        =   $this->ssan_bdu_creareditarpaciente_model->test();
        $this->output->set_output(json_encode([
            'return_data'   =>  $return_data,
            'status'        =>  true,
        ]));
    }
    
    public function CreaEditaPaciente(){
        if (!$this->input->is_ajax_request()) {  show_404();  }
        $codEmpresa     =   $this->session->userdata("COD_ESTAB");
        $numFichae      =   $this->input->post("numFichae");
        $isNal          =   $this->input->post("isNal");
        $templete       =   $this->input->post("template");
        $edad           =   $this->input->post("Numedad");

        $value_sex      =   '';
        $dateGenero     =   $this->ssan_bdu_creareditarpaciente_model->getTraeGenero();
        if (count($dateGenero) > 0) {
            foreach ($dateGenero as $sex) {
                $value_sex  .= "<option value='" . $sex['IND_SEXO'] . "'>" . $sex['NOM_SEXO'] . "</option>";
            }
        }
 
        $value_etn     =    '';
        $dateEtnia     =    $this->ssan_bdu_creareditarpaciente_model->getTraeEtnia();
        if (count($dateEtnia) > 0) {
            $value_etn .= "<option value=''>SELECCIONE...</option>";
            foreach ($dateEtnia as $etn) {
                $value_etn .= "<option value='" . $etn['IND_ETN'] . "'>" . $etn['NOM_ETN'] . "</option>";
            }
        }

        $value_civ     =    '';
        $dateCivil     =    $this->ssan_bdu_creareditarpaciente_model->getTraeEstadoCivil();
        if (count($dateCivil) > 0) {
            $value_civ .= "<option value=''>SELECCIONE...</option>";
            foreach ($dateCivil as $civ) {
                $value_civ .= "<option value='" . $civ['COD_ESTCIV'] . "'>" . $civ['NOM_ESTCIV'] . "</option>";
            }
        }

        $value_pais    =    '';
        $datePais      =    $this->ssan_bdu_creareditarpaciente_model->getTraePais();
        if (count($datePais) > 0) {
            $value_pais .= "<option value=''>SELECCIONE...</option>";
            foreach ($datePais as $civ) {
                $value_pais .= "<option value='" . $civ['COD_PAIS'] . "'>" . $civ['NOM_PAIS'] . "</option>";
            }
        }

        $value_region    =  '';
        $dateregion      =  $this->ssan_bdu_creareditarpaciente_model->getTraeRegionXCodigo();
        if (count($dateregion) > 0) {
            $value_region .= "<option value=''>SELECCIONE...</option>";
            foreach ($dateregion as $civ) {
                $value_region .= "<option value='" . $civ['COD_REGION'] . "'>" . $civ['NOM_REGION'] . "</option>";
            }
        }

        $value_Gsangre  =   '';
        $Gsangre        =   $this->ssan_bdu_creareditarpaciente_model->getTraeGrupoSangre();
        if (count($Gsangre) > 0) {
            $value_Gsangre .= "<option value=''>SELECCIONE...</option>";
            foreach ($Gsangre as $civ) {
                $value_Gsangre .= "<option value='" . $civ['IND_GRUSAN'] . "'>" . $civ['NOM_GRUSAN'] . "</option>";
            }
        }

        $value_fsangre      = '';
        $Fsangre        = $this->ssan_bdu_creareditarpaciente_model->getTraeFactorSangre();
        if (count($Fsangre) > 0) {
            $value_fsangre .= "<option value=''>SELECCIONE...</option>";
            foreach ($Fsangre as $civ) {
                $value_fsangre .= "<option value='" . $civ['IND_FACSAN'] . "'>" . $civ['NOM_FACSAN'] . "</option>";
            }
        }

        $value_fprevi       = '';
        $Fprevision         = $this->ssan_bdu_creareditarpaciente_model->getTraePrevision('');
        if (count($Fprevision) > 0) {
            $value_fprevi .= "<option value=''>SELECCIONE...</option>";
            foreach ($Fprevision as $civ) {
                $value_fprevi .= "<option value='" . $civ['IND_PREVIS'] . "'>" . $civ['NOM_PREVIS'] . "</option>";
            }
        }

        $value_previEmp     = '';
        $FsangreEmp         = $this->ssan_bdu_creareditarpaciente_model->getTraeEmpresa();
        if (count($FsangreEmp) > 0) {
            $value_previEmp .= "<option value=''>SELECCIONE...</option>";
            if ($isNal == 0) {
                $value_previEmp .= "<option value='61603000'>E.EXTRANJERO</option>";
            } else {
                foreach ($FsangreEmp as $civ) {
                    $value_previEmp .= "<option value='" . $civ['COD_RUTINS'] . "'>" . $civ['NOM_INSEMP'] . "</option>";
                }
            }
        }





        $html = '
            <table border="0" cellspacing="0"  class="table-sm">
                <theard>
            ';
        if ($isNal == 0) {
            $html .= '<tr>
                    <td width="35%" style="text-align:center"> 
                        <select name="cboNumIdentifica" id="cboNumIdentifica" class="spetit" onchange="js_cambiaNID(this.id,this.value)" style="width: 100%;">
                            <option value="1" >N&deg; PASAPORTE VIGENTE/(DNI)</option>
                            <option value="2" >N&deg; PROVISORIO FONASA</option>
                            <option value="4" >N&deg; EXTRANJERO SSAN (SOLO BUSQUEDA) </option>
                        </select>
                    </td> 
                    <td width="5%" style="text-align:center">
                        <div id="txtMenjajefonasa" style="display:none">
                            <button class="btn btn-default hint hint--left" type="button" style="height:auto;width:40px" data-hint="N&Uacute;MERO ATENCION PROVISORIO">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </button>
                        </div>
                    </td>
                    <td width="30%" style="text-align:center">
                        <div id="numExtranjero" style="text-align:left">
                            <input name="txtNumIdentiExtra" type="text" id="txtNumIdentiExtra" style="TEXT-TRANSFORM: uppercase;" value="" size="30">
                        </div>
                        <div id="numFonasa" style="display:none" style="text-align:center">
                            <input type="text" class="form-control" name="txtBuscarFonasa" id="txtBuscarFonasa" size="8" maxlength="8" style="width:70px" onkeypress="return soloNumeros(event)"> 
                            - 
                            <input type="text" class="form-control" name="txtDvFoonasa"    id="txtDvFoonasa"    size="1" maxlength="1" style="width:15px">
                        </div>
                    </td> 
                    <td width="30%" style="text-align:left">
                        <button type="button" class="btn btn-success" onclick="validaNumeroExtranjero(0,null);" id="btnNumExtranjero"> 
                        <i class="fa fa-check-circle" aria-hidden="true"></i> VALIDAR N&deg; DE IDENTIFICACI&Oacute;N </button>
                    </td>
                </tr> 
                ';
        } else if ($isNal == 1) {
            $html .= '
                <tr class="info">
                    <td class="info" width="40%" style="text-align:right"><b>RUN</b>:</td> 
                    <td class="info" width="20%" style="text-align:center">
                        <div class="grid_div_run">
                            <div class="grid_div_run1">
                                <input type="text" class="form-control" name="txtBuscar" id="txtBuscar" size="8" maxlength="8" onkeypress="return soloNumeros(event)"> 
                            </div>
                            <div class="grid_div_run2">-</div>
                            <div class="grid_div_run3">
                                <input type="text" class="form-control" name="txtDv" id="txtDv" size="1" maxlength="1">
                            </div>
                        </div>
                    </td> 
                    <td class="info" width="40%" style="text-align:left">
                        <a class="btn btn-small btn-success" onclick="validaRutChileno(1,null);" id="btn_rut">
                        <i class="fa fa-search" aria-hidden="true"></i> VALIDAR RUN</a>
                    </td> 
                </tr>
                ';
        } else if ($isNal == 3) {
            $html .= '
                <tr class="info">
                    <td class="info" width="33%" style="text-align:right"><b>RUT MADRE</b>:</td> 
                    <td class="info" width="33%" style="text-align:center">
                        <input type="text" class="form-control" name="txtBuscar" id="txtBuscar" size="8" maxlength="8" style="width:70px" onkeypress="return soloNumeros(event)"> 
                        - 
                        <input type="text" class="form-control" name="txtDv" id="txtDv" size="1" maxlength="1" style="width:15px">
                    </td> 
                    <td class="info" width="33%" style="text-align:left">
                        <a class="btn btn-small btn-info" onclick="validaRutmadre(1,null);" id="btn_rut">
                        <i class="fa fa-search" aria-hidden="true"></i> VALIDAR RUT RN</a>
                    </td> 
                </tr>
                ';
        }
        $html .= '</theard></table>';


        $html .= '
        <div id="formularioUsuario">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
               <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#datos_generales" type="button" role="tab" aria-controls="home" aria-selected="true">DATOS GENERALES</button>
                </li>
                <li class="nav-item" id="tabs_datoslocales">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">DATOS LOCALES</button>
                </li>';
        if ($isNal != 3) {
            $html .=    '<li class="nav-item" id="tabs_datosprevisionales">
                           <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">DATOS PREVISIONALES</button>
                        </li>';
        }
        
        if ($isNal == 0) { /* Solo Extranjeros */
            $html .=    '<li class="nav-item" id="tabs_datosextranjero">
   
                            <button class="nav-link" id="datos_extranjero-tab" data-bs-toggle="tab" data-bs-target="#datos_extranjero" type="button" role="tab" aria-controls="datos_extranjero" aria-selected="false">DATOS PREVISIONALES</button>

                        </li>';
        }

       
        $html .= '<li class="nav-item" id="tabs_datosinscrito" style="display:none">
	                <button class="nav-link" id="datos_inscrito-tab" data-bs-toggle="tab" data-bs-target="#datos_inscrito" type="button" role="tab" aria-controls="datos_inscrito" aria-selected="false">DATOS PREVISIONALES</button>
                </li>';
       

        $html .= '
            <li class="dropdown" id="dropdown_opciones" style="display:none">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;INFORMACI&Oacute;N 
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" id="btn_percapita" >
                <li>
                    <a href="javascript:ver_infopercapita()" id="a_ver_percapita" style="white-space: normal;">
                    <i class="fa fa fa-info-circle" aria-hidden="true"></i>&nbsp;INFO PERCAPITA
                    </a>
                </li>
                </ul>
            </li>
		';
      
        $html .= '</ul>
        <div class="tab-content">
	        <!-- ************** NUEVO 18-12-2019 *************** -->
            <div class="tab-pane" id="datos_inscrito" role="tabpanel"> 
                ...
            </div>

            <div class="tab-pane fade show active" id="datos_generales" role="tabpanel" aria-labelledby="home-tab">

                <form action="#" method="post" id="fromDatosGenerales" name="fromDatosGenerales">
                    <table width="100%" border="0" cellspacing="0"  class="table-sm table-striped">
                        <tr class="formulario" id="recienNacido"> 
                            <td width="30%" height="45pxpx">&#191;Recien nacido&#63;</td>
                            <td width="70%" style="display:flex;margin-top:6px;">
                                S&iacute;&nbsp;<input type="radio" name="rdoRecNacido" class="input" value="1">
                                No&nbsp;<input type="radio"  name="rdoRecNacido" class="input" value="0" checked="checked">
                                &nbsp;<font color="#339999" class="Estilo2">*</font>
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>Nombres
                                <input type="hidden" id="numFichae" name="numFichae" value="">
                                <input type="hidden" id="isNewPac"  name="isNewPac"  value="">
                            </td>
                            <td style="display:flex;">
                            <input type="text"  class="form-control" id="txtNombre" name="txtNombre" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="25"  oninput="copiarnombre()">
                            <font color="#339999" class="Estilo2">*</font></td>
                        </tr>
                        
                        <tr class="formulario">
                            <td>  Nombre Social</td>
                            <td style="display:flex;">
                                <input type="text" class="form-control" d="txtNombreSocial" name="txtNombreSocial" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="25">
                            </td>
                        </tr>

                        <tr class="formulario">
                            <td>Apellido Paterno</td>
                            <td style="display:flex;">
                                <input type="text" class="form-control" id="txtApellidoPaterno" name="txtApellidoPaterno" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="20" oninput="copiaapellidopaterno()">
                                <font color="#339999" class="Estilo2">*</font>
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>Apellido Materno</td>
                            <td style="display:flex;">
                                <input type="text" class="form-control" id="txtApellidoMaterno" name="txtApellidoMaterno" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="20" oninput="copiaapellidomaterno()">
                                <font color="#339999" class="Estilo2">*</font>
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>Fecha de nacimiento</td>
                            <td style="display:flex;">
                                <input 
                                    type        =   "date" 
                                    class       =   "form-control" 
                                    style       =   "width:140px" 
                                    id          =   "txtFechaNacimineto" 
                                    name        =   "txtFechaNacimineto" 
                                    maxlength   =   "10" 
                                    max         =   "'. date('Y-m-d').'"  
                                    min         =   "'. date('Y-m-d',strtotime('-120 years')).'"
                                    />
                                    <font color="#339999" class="Estilo2">*</font> (dd/mm/aaaa)
                                    <!-- disabled -->
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td> Sexo</td>
                            <td style="display:flex;">
                                <select class="form-select" name="cboGenero" id="cboGenero" onchange="" class="" style="width: 64%;">
                                    '.$value_sex.'
                                </select>
                                <font color="#339999" class="Estilo2">*</font>
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td> Etnia</td>
                            <td style="display:flex;">
                                <select class="form-select" name="cboEtnia1" id="cboEtnia1" onchange="" class="" style="width: 64%;">
                                ' . $value_etn . '
                                </select>
                                <font color="#339999" class="Estilo2">*</font>
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td> Percepci&oacute;n Etnia</td>
                            <td style="display:flex;">
                                <select class="form-select" name="cboEtnia2" id="cboEtnia2" onchange="" class="" style="width: 64%;">
                                ' . $value_etn . '
                                </select>
                                <font color="#339999" class="Estilo2">*</font>
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>Estado Civil</td>
                            <td style="display:flex;">
                                <select class="form-select" name="cboEstadoCivil" id="cboEstadoCivil" onchange="" class="" style="width: 64%;">
                                ' . $value_civ . '
                                </select>
                                <font color="#339999" class="Estilo2">*</font>
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td> Nombre Pareja</td>
                            <td style="display:flex;">
                                <input class="form-control" name="txtPareja" type="text" id="txtPareja" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="10">
                            </td>
                        </tr>
                        <tr class="formulario">
                            <td>Nombre Padre</td>
                            <td><input class="form-control" name="txtPadre" type="text" id="txtPadre" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="10"> </td>
                        </tr>
                        <tr class="formulario">
                            <td>Nombre Madre</td>
                            <td><input class="form-control" name="txtMadre" type="text" id="txtMadre" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="10"></td>
                        </tr>
                        <tr class="formulario" >
                            <td height="28px">Pais</td>
                            <td>
                                <select class="form-select" name="cboPais" id="cboPais" onchange="" class="" style="width: 64%;">' . $value_pais . '<select>
                            </td>    
                ';
                /*
                if ($isNal == 0){
                    $html.='';
                } else {
                    $html.='<input  name="cboPais" id="cboPais" type="hidden" value="CL"> <b>CHILENO/A</b>';
                    $html.='<font color="#339999" class="Estilo2">*</font></td>
                    ';
                }
                */
        $html .= '</tr>';

        //Nacionalidad solo extranjeros
        $html   .= ' 
                    <tr class="formulario" >
                        <td height="28px">Nacionalidad</td>
                        <td>
                            <select class="form-select" name="cboNacionalidad" id="cboNacionalidad" onchange="" style="width: 64%;">
                                '.$value_pais.'
                            <select>
                        </td>   
                    </tr>
                ';

        $html .=    '<tr class="formulario">
                        <td> Regi&oacute;n </td>
                        <td style="display:flex;">
                            <select class="form-select" name="cboRegion" id="cboRegion" onchange="buscaCiudades(this.value,\'cboCiudad\',\'\');buscaComunas(this.value,\'cboComuna\',\'\')" class="" style="width: 64%;">
                                '.$value_region.'
                            </select>
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>

                    <tr class="formulario">
                        <td>Ciudad</td>
                        <td style="display:flex;">
                            <select class="form-select" name="cboCiudad" id="cboCiudad" onchange="" class="" style="width: 64%;">
                                <option value="">SELECCIONE...</option>
                            </select>
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td>Comuna:</td>
                        <td style="display:flex;">
                            <select class="form-select" name="cboComuna" id="cboComuna" onchange="" class="" style="width: 64%;">
                                <option value="">SELECCIONE...</option>
                            </select>
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td> V&iacute;a Direcci&oacute;n</td>
                        <td style="display:flex;">
                            <select class="form-select" name="cboviadire" id="cboviadire" class="spetit" style="width: 64%;">
                                <option value="C">CALLE</option>
                                <option value="P">PASAJE</option>
                                <option value="A">AVENIDA</option>
                                <option value="O">OTRO</option>
                            </select>
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td> Direcci&oacute;n</td>
                        <td style="display:flex;">
                            <input type="text" class="form-control" name="txtDireccion"  id="txtDireccion" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="100">
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td>N&deg;</td>
                        <td style="display:flex;">
                            <input name="txtNum_dire" type="text" class="form-control" id="txtNum_dire" onkeypress="return IsNumber(event);" style="width: 64%;" maxlength="6" onblur="pastePacNo(1)">
                            <font color="#339999" class="Estilo2">*</font>0 para "s/n". 
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td> Resto Direcci&oacute;n </td>
                        <td>
                            <input name="txtdire_resto" type="text" class="form-control" id="txtdire_resto" style="TEXT-TRANSFORM: uppercase;width: 64%;"maxlength="300">
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td>Procedencia</td>
                        <td style="display:flex;">
                            <select class="form-select" name="cboProcedencia" id="cboProcedencia" class="spetit" style="width: 64%;">
                                <option value="U">URBANA</option>
                                <option value="R">RURAL</option>
                            </select> 
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td> Tel&eacute;fono</td>
                        <td style="display:flex;">
                            <input name="txtTelefono" type="text"  class="form-control" id="txtTelefono" onkeypress="return IsNumber(event);" style="width: 64%;" maxlength="6">
                             NO ingresar c&oacute;digo de &aacute;rea 
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td> Celular </td>
                        <td style="display:flex;">
                            <input name="txtCelular" type="text"  class="form-control" id="txtCelular" onkeypress="return IsNumber(event);" style="width: 64%;" maxlength="12">
                            <font color="#339999" class="Estilo2">*</font> NO anteponer 09  
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td>Correo Electr&oacute;nico</td>
                        <td>
                            <input name="txtEmail" type="text" class="form-control" id="txtEmail" style="width: 64%;" maxlength="40">
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td>Grupo Sangre</td>
                        <td style="display:flex;">
                            <select class="form-select" name="cboGrupoSangre" id="cboGrupoSangre" onchange="" class="" style="width: 64%;">' . $value_Gsangre . '</select>
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td> Factor Sangre</td>
                        <td style="display:flex;">
                            <select class="form-select" name="cboFactorSangre" id="cboFactorSangre" onchange="" class="" style="width: 64%;">' . $value_fsangre . '</select>
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                    <tr class="formulario">
                        <td>Calidad Previsional</td>
                        <td style="display:flex;">
                            <select name="cboTippac" id="cboTippac" class="form-select" onchange="revisaTitular()" style="width: 64%;">
                                <option value="" selected="selected">SELECCIONE...</option>
                            ';
        if ($isNal == 0) {
            $html .= '<option value="E">EXTRANJERO</option>';
        } else {
            $html .= '<option value="T">TITULAR</option>'
                . '<option value="D">DEPENDIENTE O CARGA</option>';
        }
        $html .= '</select> 
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                    
                    <tr class="formulario" style="height: 45px;">
                        <td>Condici&oacute;n PRAIS</td>
                        <td style="display:flex;" style="height: 45px;">
                            S&iacute;   <input type="radio" name="rdoprais" id="rdoprais_1" class="input" value="1"> 
                            No          <input type="radio" name="rdoprais" id="rdoprais_0" class="input" value="0" checked="checked">
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                    <tr class="formulario" style="height: 45px;">
                        <td>Trans</td>
                        <td style="display:flex;" style="height: 45px;">
                            S&iacute;   <input type="radio" name="rdotrans" id="rdotrans_1" class="input" value="1" > 
                            No          <input type="radio" name="rdotrans" id="rdotrans_0" class="input" value="0" checked="checked">
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                </tbody>
                ';

        $html .= '<tbody id="id_editarFicha">
                    <tr class="formulario" id="tr_ocupacion">
                        <td height="28px">Ocupaci&oacute;n</td>
                        <td><input type="text"  name="txtOcupacion" id="txtOcupacion" class="form-control" style="width: 64%;" maxlength="100"></td>
                    </tr>
                    <tr class="formulario" id="representateLegal">
                        <td height="28px">Representante Legal</td>
                        <td style="display:flex;">
                            <input type="text"  name="txtRepLegal"id="txtRepLegal" class="form-control" style="width: 64%;" maxlength="100"> * Menores de 18 a&ntilde;os
                        </td>
                    </tr>
                </tbody>';

        
        $html .= '<tbody id="id_nuevo_20092021">
                    <tr class="formulario" id="tr_ocupacion">
                        <td height="28px">Nivel educacioanal</td>
                        <td style="display:flex;">
                            <select class="form-select" name="ind_nivel_educacional" id="ind_nivel_educacional" class="spetit" style="width: 64%;">
                                <option value="">SELECCIONE ...</option>
                                <option value="0">SIN EDUCACI&Oacute;N</option>
                                <option value="1">EDUCACI&Oacute;N PRE-ESCOLAR</option>
                                <option value="2">EDUCACI&Oacute;N BASICA</option>
                                <option value="3">EDUCACI&Oacute;N MEDIA</option>
                                <option value="4">NIVEL SUPERIOR</option>
                            </select>
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>

                    <tr class="formulario" id="representateLegal">
                        <td height="28px">Poblaci&oacute;n Migrante</td>
                        <td style="display:flex;">
                            <select class="form-select" name="ind_poblacion_migrante" id="ind_poblacion_migrante" class="spetit" style="width: 64%;">
                                <option value="">SELECCIONE ...</option>
                                <option value="1">SI</option>
                                <option value="0">NO</option>
                            </select>
                            <font color="#339999" class="Estilo2">*</font>
                        </td>
                    </tr>
                </tbody>';
        
        
        $html .= '</table>
        </form>
    </div>';


    if ($isNal != 3) { //Omite Cuando Es Recien Nacinado //Hasta nuevo aviso

        $html .= '
    <div class="tab-pane" id="profile" role="tabpanel"> 
        <form action="#" method="post" id="from_datos_locales" name="from_datos_locales">
        <table width="100%" border="0" cellspacing="0" class="table-sm table-striped">
            <tbody id="id_formLocal">
                <tr class="formulario">
                    <td>Ficha F&iacute;sica Local</td>
                    <td>
                        <div id="txt_nficha"></div>
                        <div class="input-group" id="group_nueva_fichalocal">
                            <div class="input-group-text" style="width: 45px;">
                                <input type="checkbox" class="form-check-input mt-0" name="newFichaL" id="newFichaL" onclick="nuevafichalocal()" style="margin-left:2px;" value="" aria-label="Nueva ficha local">
                            </div>
                            <label class="input-group-text" for="inputGroupFile01">GENERAR NUEVA FICHA LOCAL</label>
                            <input type="text" id="txtFichaFisicaLocal" name="txtFichaFisicaLocal" size="10" class="form-control" onkeypress="return IsNumber(event);" onblur="validarFL();" value="">
                        </div>
                        <input type="hidden" id="tieneDatosLocales" name="tieneDatosLocales" value="0"/>
                    </td>
                </tr>
                <tr class="formulario">
                    <td width="30%" height="35px">RUN</td>
                    <td width="70%">
                        <label id="RutLabel"></label></b> 
                        <div id="cargaPaciente" style="display: initial"></div>
                    </td>
                </tr>
                <tr class="formulario">
                    <td height="35px"> Nombre Completo </td>
                    <td><label id="nombreLabel"></label> </td>
                </tr>
                <tr class="formulario" style="">
                    <td height="35px">C&oacute;digo Familia  </td>
                    <td><span id="txtCodFamilia"></span>  </td>
                </tr>
                <tr class="formulario" style="">
                    <td height="35px">  Sector  </td>
                    <td><span id="txtSector"></span></td>
                </tr>
                <tr class="formulario">
                    <td> Regi&oacute;n</td>
                    <td style="display:flex;">
                        <select class="form-select" name="cboRegionLocal" id="cboRegionLocal" onchange="buscaCiudades(this.value,\'cboCiudadLocal\',\'\');buscaComunas(this.value,\'cboComunaLocal\',\'\')" style="width: 64%;">
                            ' . $value_region . '
                        </select>
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr class="formulario">
                    <td>Ciudad</td>
                    <td style="display:flex;">
                        <select class="form-select" name="cboCiudadLocal" id="cboCiudadLocal" style="width: 64%;">
                            <option value="">SELECCIONE...</option>
                        </select>
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr class="formulario">
                    <td>Comuna:</td>
                    <td style="display:flex;">
                        <select class="form-select" name="cboComunaLocal" id="cboComunaLocal" style="width: 64%;">
                            <option value="">SELECCIONE...</option>
                        </select>
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr class="formulario">
                    <td>  V&iacute;a Direcci&oacute;n Local </td>
                    <td style="display:flex;">
                        <select class="form-select" name="cboviadireLocal" id="cboviadireLocal" class="spetit" style="width: 64%;">
                            <option value="C">CALLE</option>
                            <option value="P">PASAJE</option>
                            <option value="A">AVENIDA</option>
                            <option value="O">OTRO</option>
                        </select>
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr class="formulario">
                    <td>Direcci&oacute;n Local</td>
                    <td style="display:flex;">
                        <input class="form-control" name="txtDireccionLocal" type="text" id="txtDireccionLocal" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="100">
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr class="formulario">
                    <td> Tel&eacute;fono Local</td>
                    <td style="display:flex;">
                        <input class="form-control" name="txtTelefonoLocal" type="text" id="txtTelefonoLocal" onkeypress="return IsNumber(event);"  style="width: 64%;" maxlength="7">
                        NO ingresar c&oacute;digo de &aacute;rea 
                    </td>
                </tr>
                <tr class="formulario">
                    <td>Celular Local </td>
                    <td style="display:flex;">
                        <input class="form-control" name="txtCelularLocal" type="text" id="txtCelularLocal" onkeypress="return IsNumber(event);" style="width: 64%;" maxlength="8">
                        <font color="#339999" class="Estilo2">*</font> NO anteponer 09  
                    </td>
                </tr>
                <tr class="formulario">
                    <td>Nombre Contacto  </td>
                    <td style="display:flex;">
                        <input class="form-control" type="text" id="txtNombreContacto" name="txtNombreContacto" style="TEXT-TRANSFORM: uppercase;width: 64%;" maxlength="10">
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr class="formulario">
                    <td>Direcci&oacute;n Contacto</td>
                    <td style="display:flex;">
                        <input class="form-control" name="txtDireccionContacto" type="text" id="txtDireccionContacto"  style="width: 64%;" maxlength="100">
                        <font color="#339999" class="Estilo2">*</font> 
                    </td>
                </tr>
                <tr class="formulario">
                    <td> N&deg; Direcci&oacute;n Contacto </td>
                    <td style="display:flex;">
                        <input class="form-control" name="txtNum_direContacto" type="text" id="txtNum_direContacto" onkeypress="return IsNumber(event);" style="width: 64%;" maxlength="6">
                        <font color="#339999" class="Estilo2">*</font> digite un 0 para "s/n".
                    </td>
                </tr>
                <tr class="formulario">
                    <td> Tel&eacute;fono Contacto</td>
                    <td style="display:flex;">
                        <input class="form-control" name="txtTelefonoContacto" type="text" id="txtTelefonoContacto" onkeypress="return IsNumber(event);" style="width: 64%;" maxlength="7">
                        NO ingresar c&oacute;digo de &aacute;rea 
                    </td>
                </tr>
                <tr class="formulario">
                    <td> Celular Contacto</td>
                    <td style="display:flex;">
                        <input  class="form-control" name="txtCelularContacto" type="text" id="txtCelularContacto"  onkeypress="return IsNumber(event);" style="width: 64%;" maxlength="8">
                        <font color="#339999" class="Estilo2">*</font> NO anteponer 09  
                    </td>
                </tr>
            </tbody>
         ';

            //Solo para ficha local- Para editar Datos Locales
            if ($templete == '2') {
                $html .= '
                <tbody id="id_editarFichaL">
                    <tr class="formulario" id="tr_ocupacionL">
                        <td height="28px">Ocupaci&oacute;n</td>
                        <td>
                            <input  class="form-control" name="txtOcupacionL" type="text" id="txtOcupacionL" style="width: 64%;" maxlength="100">
                        </td>
                    </tr>
                    <tr class="formulario" id="representateLegalL">
                        <td height="28px">Representante Legal</td>
                        <td>
                            <input class="form-control" name="txtRepLegalL" type="text" id="txtRepLegalL" style="width: 64%;" maxlength="100"> * Menores de 18 a&ntilde;os
                        </td>
                    </tr>
                </tbody>
                ';
            }
            $html .= '</table>
            
       </form>
    </div> 
    ';
        }

        $html .= '<div class="tab-pane" id="contact" role="tabpanel">

        <form action="#" method="post" id="From_datos_previsiones" name="From_datos_previsiones">
            <table width="100%" border="0" cellspacing="0" class="table-sm table-striped">';
        if ($isNal == 0) {
            $html .= '
            <tbody id="soloExnjerosFonasa">      
                 <tr class="formulario">
                     <td width="30%">SOLO EXTRANJEROS </td>
                     <td width="70%">
                         <div class="has-error">
                             <div class="radio">
                                 <label>
                                     <input type="radio" name="tienePreviExtra" id="PreviExtr_0" value="0" onchange="js_cambia(this.id,this.value)" checked>
                                     <b>PACIENTE EXTRANJERO NO CUENTA CON RUT PROVISORIO DE FONASA (EN TRAMITE)</b>
                                 </label>
                             </div>
                         </div>
                         <div class="has-success">
                             <div class="radio">
                                 <label>
                                     <input type="radio" name="tienePreviExtra" id="PreviExtr_1" value="1" onchange="js_cambia(this.id,this.value)">
                                     <b>PACIENTE EXTRANJERO CUENTA CON RUT PROVISORIO DE FONASA </b>
                                 </label>
                             </div>
                         </div>
                     </td>
                 </tr>
             </tbody>
            ';
        } else {
            $html .= '<input type="hidden" name="tienePreviExtra" id="tienePreviExtra" value="1">';
        }

        if ($isNal == 0) {
            $style = ' style="display:none"';
        } else {
            $style = ' ';
        }
        $html .= '
            <tbody id="formulario_provisionales" ' . $style . '>      
                <tr class="formulario">
                    <td width="30%"> RUN</td>
                    <td width="70%">
                        <div class="grid_div_run_previ">
                            <div class="grid_div_run1">
                                <input type="text" class="form-control" name="txtRuttit" id="txtRuttit" onkeypress="return IsNumber(event);" size="8" maxlength="8" value=""> 
                            </div>
                            <div class="grid_div_run2" style="text-align: center;">-</div>
                            <div class="grid_div_run3">
                                <input type="text" class="form-control" name="txtDvtit"  id="txtDvtit"  onkeypress="return IsDigitoVerificador(event);" size="1" maxlength="1" value=""> 
                            </div>
                            <div class="grid_div_run4" style="text-align: center;">
                                <font color="#339999" class="Estilo2">*</font>
                            </div>
                            <div class="grid_div_run5">
                                <button type="button" name="btnConsultarPacientePrevisionales" id="btnConsultarPacientePrevisionales" class="btn btn-small btn-info" onclick="buscaTitular(1);"  style="display:none;">  
                                    <i class="fa fa-database" aria-hidden="true"></i>&nbsp; INFORMACI&Oacute;N FONASA 
                                </button>
                            </div>
                        </div>
                        ';
        $html .= '</td>
                </tr>
                <tr>
                    <td>Nombres</td>
                    <td style="display:flex;">
                        <input type="text" class="form-control" id="txtNombretit" name="txtNombretit" style="TEXT-TRANSFORM: uppercase;width: 64%;">
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr>
                    <td>Apellido paterno</td>
                    <td style="display:flex;">
                        <input type="text" class="form-control" id="txtApellidoPaternotit" name="txtApellidoPaternotit" style="TEXT-TRANSFORM: uppercase;width: 64%;">
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr>
                    <td>Apellido Materno</td>
                    <td  style="display:flex;">
                        <input type="text" class="form-control" id="txtApellidoMaternotit" name="txtApellidoMaternotit" style="TEXT-TRANSFORM: uppercase;width: 64%;">
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr>
                    <td>Previsi&oacute;n</td>
                    <td  style="display:flex;">
                        <select class="form-select" name="cboPrevision" id="cboPrevision" onchange="" class="" style="width: 64%;">' . $value_fprevi . '</select>
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
                <tr>
                    <td>Empresa</td>
                    <td style="display:flex;">
                        <select class="form-select" name="cboEmpresaPrevision" id="cboEmpresaPrevision" onchange="" class="" style="width: 64%;">' . $value_previEmp . '</select>
                        <font color="#339999" class="Estilo2">*</font>
                    </td>
                </tr>
            </table>
        </tbody> 
    </form>  
   
    <div class="grid_panel_buscando" id="buscando_fonasa"  style="display:none">
        <div class="grid_panel_buscando1"></div>
        <div class="grid_panel_buscando2">
            <b>BUSCANDO INFORMACI&Oacute;N</b>
        </div>
        <div class="grid_panel_buscando3">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw" style="color: #28a745"></i>
            <span class="sr-only"> CARGANDO ... </span>
        </div>
        <div class="grid_panel_buscando4"></div>
    </div>
  
    <div class="alert alert-info alert-dismissible fade in" role="alert" id="msjFonasa" style="display:none" > 
        <h4 style="text-align: center;"> RESULTADO:</h4> 
        <p id="txtFonasa" style="text-align: center;"> </p> 
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">VER INFORMACION <i class="fa fa-eye" aria-hidden="true"></i></a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body" id="tableFonasa"></div>
                </div>
              </div>
        </div>
        </div>
    </div>
    
    ';

        if ($isNal == 0) {
            $html .=   '
            <div class="tab-pane" id="datos_extranjero" role="tabpanel">
                <form action="#" method="post" id="Form_datos_extranjero" name="Form_datos_extranjero">
                    <table width="100%" border="0" cellspacing="0">
                       <tbody>
                        <tr class="formulario" id="extranjero3">
                            <td width="30%"> Fecha Vencimiento Documento:(Pasaporte)</td>
                            <td width="70%" class="formulario">
                                <input type="text" name="txtFecvencePasport" id="txtFecvencePasport" size="10" value=""/> <b><font size="-2">(dd/mm/aaaa)</font></b> 
                            </td>
                        </tr>
                        
                        <tr class="formulario" id="extranjero3">
                            <td width="30%"> Fecha Vencimiento Identificador Provisorio</td>
                            <td width="70%" class="formulario">
                                <input type="text" name="txtFecvence_fonasa" id="txtFecvence_fonasa" size="10" value=""/> <b><font size="-2">(dd/mm/aaaa)</font></b> 
                            </td>
                        </tr>
                        
                    </table>
                </form>  
            </div> 
            <script>

            </script>
        </div>  
        ';
        }

        $html .= '</div>
        </div> 
        ';


        $aDatos[] = array('id_html' => 'HTML_DIALOGO', 'opcion' => 'html', 'contenido' => $html);


        if ($isNal == 1) {
            $aDatos[] = array(
                "id_html"   => "titulo_bdu",
                "opcion"    => "html",
                "contenido" => "<i class='fa fa-user-circle'   aria-hidden='true'></i>&nbsp;<b>GRABA/EDITA PACIENTE</b>"
            );
            /*
            $aDatos[] = array(
                               "id_html"   => "",    
                               "opcion"    => "console",    
                               "contenido" => "----------->".$templete
                           ); 
            */
            if ($templete == 1) {
                $aDatos[] = array(
                    "id_html"   => "txt_bdu",
                    "opcion"    => "html",
                    "contenido" => "<i class='fa fa-id-card-o'     aria-hidden='true'></i>&nbsp;<b>CREACI&Oacute;N/EDICI&Oacute;N PACIENTE</b>"
                );
            } else if ($templete == 2) {
                $aDatos[] = array(
                    "id_html"   => "txt_bdu",
                    "opcion"    => "html",
                    "contenido" => "<i class='fa fa-id-card-o'     aria-hidden='true'></i>&nbsp;<b>EDICI&Oacute;N FICHA LOCAL</b>"
                );
            }

            $aDatos[] = array(
                "id_html"   => "txt_bdu",
                "opcion"    => "html",
                "contenido" => "<i class='fa fa-id-card-o'     aria-hidden='true'></i>&nbsp;<b>CREACI&Oacute;N/EDICI&Oacute;N PACIENTE</b>"
            );

            if ($numFichae != '') {
                $aDatos[] = array(
                    "id_html"   => "respuesta",
                    "opcion"    => "html",
                    "contenido" => "<script>validaRutChileno(1,$numFichae)</script>"
                );
            }
        } else if ($isNal == 0) { //EXTRANJERO
            $aDatos[]       = array(
                'id_html'   => 'cboPais',
                'opcion'    => 'find_rm',
                'contenido' => 'CL'
            );
            $aDatos[]       = array(
                "id_html"   => "titulo_bdu",
                "opcion"    => "html",
                "contenido" => "<i class='fa fa-user-circle'   aria-hidden='true'></i>&nbsp;<b>GRABA/EDITA PACIENTE EXTRANJERO</b>"
            );
            $aDatos[]       = array(
                "id_html"   => "txt_bdu",
                "opcion"    => "html",
                "contenido" => "<i class='fa fa-id-card-o'     aria-hidden='true'></i>&nbsp;<b>CREACI&Oacute;N/EDICI&Oacute;N PACIENTE EXTRANJERO</b>"
            );
            if ($numFichae != '') {
                $aDatos[]   = array(
                    "id_html"   => "respuesta",
                    "opcion"    => "html",
                    "contenido" => "<script>validaNumeroExtranjero(0,$numFichae)</script>"
                );
            }
        } else if ($isNal == 3) { //Datos del recien nacido
            
            //RN
            //$aDatos[]     = array('id_html'=>'cboPais' ,'opcion'=>'find_rm','contenido'=>'CL');
            $aDatos[]       = array(
                "id_html"   => "titulo_bdu",
                "opcion"    => "html",
                "contenido" => "<i class='fa fa-user-circle'   aria-hidden='true'></i>&nbsp;<b>GRABA/EDITA PACIENTE RECIEN NACIDO</b>"
            );
            $aDatos[]       = array(
                "id_html"   => "txt_bdu",
                "opcion"    => "html",
                "contenido" => "<i class='fa fa-id-card-o'     aria-hidden='true'></i>&nbsp;<b>CREACI&Oacute;N/EDICI&Oacute;N RECIEN NACIDO</b>"
            );
            if ($numFichae != '') {
                $aDatos[]   = array(
                    "id_html"   => "respuesta",
                    "opcion"    => "html",
                    "contenido" => "<script>validaNumeroRN(0,$numFichae)</script>"
                );
            }

        }

        $this->output->set_output(json_encode($aDatos));
    }

    public function buscarPac(){
        if (!$this->input->is_ajax_request()) {  show_404();  }
        //  $codEmpresa         =    $this->session->userdata("COD_ESTAB");
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
                //$script   .=  'window.location = "../../inicio"';
            }
            $script        .=    '});</script>';
            $aDatos[]       =    array('id_html' => 'respuesta', 'opcion' => 'append', 'contenido' => $script);
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
                    $html       .= 'Chile';
                    $isNal      = 1;
                } else if ($row['IND_EXTRANJERO'] == '1') {
                    $html       .=  'Extranjero';
                    $isNal      =   0;
                } else {
                    $html       .=  '';
                }
                $html           .=  '</td>';

                $html .= '<td align="center">';
                if ($row['FALLECIDO'] == '') {
                    if ($templete == '1') { //todo el power
                        $html .= '
                            <div class="dropdown" id="btn_gestion">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-item"><a href="javascript:FormModal('.$isNal.','.$row['NUM_FICHAE'].')">&nbsp;EDITAR</a></li>';
                        if ($IND_EXTRANJERO == '1') {
                                $html .= '<li><a href="javascript:CertificadoExtranjero('.$row['NUM_FICHAE'].')"><i class="fa fa-barcode" aria-hidden="true"></i>&nbsp;C.EXTRANJERO</a></li>';
                            if($row['COD_RUTPAC'] == ''){
                                $html .= '<li><a href="javascript:editor_extranjero('.$row['NUM_FICHAE'].')"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;RUN DEFINITIVO</a></li>';
                            }
                        }
                        $html .= '</div>';
                    } else if ($templete == '2') { //Edita ficha local
                        $html   .=  '<a class="btn btn-info" href="javascript:FormModal(' . $isNal . ',' . $row['NUM_FICHAE'] . ')"><i class="fa fa-cog" aria-hidden="true"></i></a>';
                    }

                    //Nuevo 13.11.2018
                    else if ($templete == '3') {
                        $html .= '<a 
                                    class   =   "btn btn-info" 
                                    href    =   "javascript:FormModal2('.$isNal.','.$row['NUM_FICHAE'].',\''.$row['COD_RUTPAC'].'\',\''.$row['NUM_IDENTIFICACION'].'\')"
                                    >
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                </a>';
                    }

                    //NUEVO PARA EL GESTION DE CITACION 06-08-2019 // NO SUBIDO
                    else if ($templete == '5') {
                        $JSON2                    =   htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                        if (is_numeric($numFichaL)) {
                            $html .=    '<button 
                                            class       =   "btn btn-success btn-xs btn-fill" 
                                            type		=   "button"
                                            id			=   "DATA_'.$row['NUM_FICHAE'] . '"
                                            data-ROW	=   "'.$JSON2.'"
                                            onclick		=   "busqueda_comp('.$row['NUM_FICHAE'].')"
                                            >
                                            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        </button>
					    ';
                        } else {
                            $html  .= ' <button 
                                            class		=   "btn btn-DEFAULT btn-xs btn-fill" 
                                            type		=   "button"
                                            id			=   "DATA_'.$row['NUM_FICHAE'] . '"
                                            data-ROW	=   "'.$JSON2.'"
                                            onclick		=   "SINFICHALOCAL('.$row['NUM_FICHAE'].');"
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
                    $aDatos[]       =   array('id_html' => 'nresultados', 'opcion' => 'html', 'contenido' => $NUM_COUNT);
                    $data           .=  '<script>$("#new_paginacion").bootpag({total:' . round($PageN) . ',page:1,maxVisible: 10});</script>';
                    $data           .=  '<script>$("#new_paginacion").show("fast");</script>';
                    $aDatos[]       =   array("id_html" => "respuesta", "opcion" => "append", "contenido"  => $data);
                }
            }
        } else {

            $aDatos[]   = array('id_html' => 'nresultados',     'opcion' => 'html', 'contenido' => '');
            $aDatos[]   = array('id_html' => 'nresultados',     'opcion' => 'html', 'contenido' => '0');
            $aDatos[]   = array('id_html' => 'new_paginacion',  'opcion' => 'hide', 'contenido' => '');

            if ($templete == '1') {
                $html   .=  '<tr id="mensajeSinresultados_1">
                                <td colspan="12" style="text-align:center">
                                    <i class="fa fa-times" aria-hidden="true"></i>&nbsp;<b><i>NO SE HAN ENCONTRADO RESULTADOS</i></b>
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
    
    public function buscarPac_resumido(){
        if(!$this->input->is_ajax_request()){ show_404(); }
        //$codEmpresa       =    $this->session->userdata("COD_ESTAB");
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
        if($tipoPac         ==   0){
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
        if(is_null($codEmpresa)){
            //$aDatos[]	    =	array('id_html'=>'respuesta','opcion'=>'console','contenido'=>"-------------------------------------");
            //$aDatos[]	    =	array('id_html'=>'respuesta','opcion'=>'console','contenido'=>$codEmpresa);
            //$aDatos[]	    =	array('id_html'=>'respuesta','opcion'=>'console','contenido'=>"-------------------------------------");
            $script         =    '<script type="text/javascript">jAlert(" - SU SESI&Oacute;N A EXPIRADO", "Listado de Errores - e-EISSAN", function(){';
            if ($this->session->userdata("SISTYPO") != 1) {
                //$script	    .=		'window.location = "../../inicio"';
            }
            $script        .=    '});</script>';
            $aDatos[]       =    array('id_html' => 'respuesta', 'opcion' => 'append', 'contenido' => $script);
            $this->output->set_output(json_encode($aDatos));
            return false;
        }
        //$aDatos[]             =   array(""=>"", "opcion" => "console", "contenido"  => "TYPO -> ".$this->session->userdata("SISTYPO"));
        $aDataPaciente          =   $this->ssan_bdu_creareditarpaciente_model->getPacientes($numFichae, $identifier, $codEmpresa, $isnal, $pasaporte, $tipoEx, strtoupper($nombre), strtoupper($apellidoP), strtoupper($apellidoM), $LIM_INI, $templete);
        $aDatos[]               =   array('id_html' => 'result',        'opcion' => 'hide',     'contenido' => '');
        $aDatos[]               =   array('id_html' => 'resultados',    'opcion' => 'html',     'contenido' => '');
        if (count($aDataPaciente) > 0) {
            foreach ($aDataPaciente as $i => $row) {
                //$aDatos[]       =   array('id_html' => 'resultados', 'opcion' => 'console', 'contenido' => $aDataPaciente);
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
                
                $IND_EXTRANJERO         =    $row['IND_EXTRANJERO'];
                if (($row['COD_PAIS'] == 'CL') || ($row['IND_EXTRANJERO'] == '0')) {
                    $EXTRAN             =   '';
                } else if ($row['IND_EXTRANJERO'] == '1') {
                    $EXTRAN             =   $row['NUM_IDENTIFICACION'] . " (" . $row['FEC_VENCEPASPORT'] . ")";
                } else {
                    $EXTRAN             =   '';
                }

                if ($row['NUM_NFICHA'] == '') {
                    $numFichaL           =  '<span class="label label-danger">N/A</span>';
                } else {
                    $numFichaL           =  $row['NUM_NFICHA'];
                }

                $html = '<tr>
                            <td style="height: 40px;">' . $row['RNUM'] . '</td>
                            <td>' . $row['COD_RUTPAC'] . '-' . $row['COD_DIGVER'] . '</td>
                            <td>' . $numFichaL . '</td>   
                            <td>' . strtoupper($row['NOM_NOMBRE']) . ' ' . strtoupper($row['NOM_APEPAT']) . ' ' . strtoupper($row['NOM_APEMAT']) . '</td>
                            <td>' . $row['FEC_NACIMI'] . '</td>';

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

                    // NUEVO PARA EL GESTION DE CITACION 06-08-2019 
                    // NO SUBIDO
                    //
                    else if ($templete == '6') {
                        $JSON2                    =   htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');
                        $html   .='
                                    <label class="radio" data-BLOQUE="'.$JSON2.'" onclick="selecionapaciente(this)" id="DATA_'.$row['NUM_FICHAE'].'">
                                        <span class="icons">
                                            <span class="first-icon fa fa-circle-o"></span>
                                            <span class="second-icon fa fa-dot-circle-o"></span>
                                        </span>
                                        <input type="radio" data-toggle="radio" name="SELECCIONA_PACIENTE" id="ID_'.$row['NUM_FICHAE'].'" value="'.$row['NUM_FICHAE'].'">
                                        <div id="TXT_PACIENTE_'.$row['NUM_FICHAE'].'" style="position: inherit;top: 2px;"></div>
                                    </label>
                                ';
                    }
                    
                    //ACTIVIDADES GRUPALES 
                    else if ($templete == '7') {
                        $JSON2                    =   htmlspecialchars(json_encode($row),ENT_QUOTES,'UTF-8');
                        $html   .='
                                    <a class="btn btn-fill btn-info" data-paciente="'.$JSON2.'" id="pac_'.$row['NUM_FICHAE'].'" onclick="paciente_en_lista_ordenanda('.$row['NUM_FICHAE'].');"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                                ';
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
                    $NUM_COUNT      =   (int) $row['RESULT_COUNT'];
                    $PageN          =   ceil($NUM_COUNT / 10);
                    $aDatos[]       =   array('id_html' => 'nresultados', 'opcion' => 'html', 'contenido' => $NUM_COUNT);
                    $data           .=  '<script>$("#new_paginacion").bootpag({total:' . round($PageN) . ',page:1,maxVisible: 10});</script>';
                    $data           .=  '<script>$("#new_paginacion").show("fast");</script>';
                    $aDatos[]       =   array("id_html" => "respuesta", "opcion" => "append", "contenido"  => $data);
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

    public function validaPacienteBDU(){
        if (!$this->input->is_ajax_request()) {   show_404();  }
        $codEmpresa                 =    $this->session->userdata("COD_ESTAB");
        $isNal                      =    $this->input->post("isNal");
        $numFichae                  =    $this->input->post("numFichae");
        $rut                        =    $this->input->post("rut");
        $dv                         =    $this->input->post("dv");
        $templete                   =    $this->input->post("templete");
        $pasaporte                  =    '';
        $tipoEx                     =    '';
        $isRN                       =    0;
        $adataPersonas              =    $this->ssan_bdu_creareditarpaciente_model->getPacientesUnico($numFichae, $rut, $codEmpresa, $isNal, $pasaporte, $tipoEx);
        /*
            $aDatos[]   =	array(""=>"", "opcion"=>"console", "contenido"=>"------------------------------------");
            $aDatos[]   =	array(""=>"", "opcion"=>"console", "contenido"=>$adataPersonas);
            $aDatos[]   =   array(""=>"", "opcion"=>"console", "contenido"=>"------------------------------------");
        */
        #**************** agregado 18.12.2019 *************************
        if (count($adataPersonas) > 0) {
            #INICIO DATOS GENERALES
            if ($isNal == 0) {
                $aDatos[]    =   array("id_html" => "cboNumIdentifica",  "opcion" => "val",    "contenido"  => $adataPersonas[0]["TIP_IDENTIFICACION"]); //cboviadireLocal  
                if ($adataPersonas[0]["TIP_IDENTIFICACION"] == '2') {
                    $aDatos[]    =   array("id_html" => "txtBuscarFonasa",   "opcion" => "val",    "contenido"  => $adataPersonas[0]["COD_RUTPAC"]);
                    $aDatos[]    =   array("id_html" => "txtDvFoonasa",      "opcion" => "val",    "contenido"  => $adataPersonas[0]["COD_DIGVER"]);
                    $aDatos[]    =   array("id_html" => "numFonasa",         "opcion" => "show",   "contenido"  => "");
                    $aDatos[]    =   array("id_html" => "numExtranjero",     "opcion" => "hide",   "contenido"  => "");
                    $aDatos[]    =   array("id_html" => "txtMenjajefonasa",  "opcion" => "show",   "contenido"  => "");
                } else {
                    $aDatos[]    =   array("id_html" => "txtNumIdentiExtra", "opcion" => "val",    "contenido"  => $adataPersonas[0]["NUM_IDENTIFICACION"]);
                }

                //************* INFORMACION ***************** 
                //$adataPersonas[0]["TIP_IDENTIFICACION"]   = 1 //PASAPORTE
                //$adataPersonas[0]["TIP_IDENTIFICACION"]   = 2 //DNI 
                //$adataPersonas[0]["TIP_IDENTIFICACION"]   = 3 //ID FONASA
                //$adataPersonas[0]["TIP_IDENTIFICACION"]   = 4 //SSANUNICO

            } else {
                if ($numFichae != '') {
                    $aDatos[]    =   array("id_html" => "txtBuscar",                 "opcion" => "val",    "contenido"  => $adataPersonas[0]["COD_RUTPAC"]);
                    $aDatos[]    =   array("id_html" => "txtDv",                     "opcion" => "val",    "contenido"  => $adataPersonas[0]["COD_DIGVER"]);
                }
            }

            //$aDatos[] = array("id_html" => "txtBuscar",             "opcion" => "console","contenido"  => "Desde =".$desdeEXT);
            //$aDatos[] = array("id_html" => "txtBuscar",             "opcion" => "console","contenido"  => "NFiche=".$numFichae);

            if ($adataPersonas[0]["NUM_FICHAE"] == '') {
                $aDatos[]   =    array("id_html" => "numFichae",                     "opcion" => "val",    "contenido"  => "0");
            } else {
                $aDatos[]   =    array("id_html" => "numFichae",                     "opcion" => "val",    "contenido"  => $adataPersonas[0]["NUM_FICHAE"]);
            }

            if ($isNal == '0' and $adataPersonas[0]["COD_RUTPAC"] != '') {
                $aDatos[]   =    array("id_html" => "formulario_provisionales",      "opcion" => "show",         "contenido"  => "");
                $aDatos[]   =    array("id_html" => "soloExnjerosFonasa",            "opcion" => "hide",         "contenido"  => "");
                $aDatos[]   =    array("id_html" => "respuesta",                     "opcion" => "append",       "contenido"  => "<script>$('#PreviExtr_0').prop('checked', false);</script>");
                $aDatos[]   =    array("id_html" => "respuesta",                     "opcion" => "append",       "contenido"  => "<script>$('#PreviExtr_1').prop('checked', true);</script>");
            }

            $aDatos[] = array("id_html" => "txtNombre",             "opcion" => "val",      "contenido"  => $adataPersonas[0]["NOMBREPAC"]);
            $aDatos[] = array("id_html" => "txtNombreSocial",       "opcion" => "val",      "contenido"  => $adataPersonas[0]["NOM_SOCIAL"]);
            $aDatos[] = array("id_html" => "txtApellidoPaterno",    "opcion" => "val",      "contenido"  => $adataPersonas[0]["APEPATPAC"]);
            $aDatos[] = array("id_html" => "txtApellidoMaterno",    "opcion" => "val",      "contenido"  => $adataPersonas[0]["APEMATPAC"]);
            $aDatos[] = array("id_html" => "txtFechaNacimineto",    "opcion" => "val",      "contenido"  => $adataPersonas[0]["FECHANACTO"]);
            $aDatos[] = array("id_html" => "cboGenero",             "opcion" => "val",      "contenido"  => $adataPersonas[0]["IND_TISEXO"]);
            $aDatos[] = array("id_html" => "cboEtnia1",             "opcion" => "val",      "contenido"  => $adataPersonas[0]["IND_ETN"]);
            $aDatos[] = array("id_html" => "cboEtnia2",             "opcion" => "val",      "contenido"  => $adataPersonas[0]["IND_PERCETN"]);
            $aDatos[] = array("id_html" => "cboEstadoCivil",        "opcion" => "val",      "contenido"  => $adataPersonas[0]["IND_ESTCIV"]);
            $aDatos[] = array("id_html" => "txtPareja",             "opcion" => "val",      "contenido"  => $adataPersonas[0]["NOM_PAREJA"]);
            $aDatos[] = array("id_html" => "txtPadre",              "opcion" => "val",      "contenido"  => $adataPersonas[0]["NOM_NPADRE"]);
            $aDatos[] = array("id_html" => "txtMadre",              "opcion" => "val",      "contenido"  => $adataPersonas[0]["NOM_NMADRE"]);
            $aDatos[] = array("id_html" => "cboPais",               "opcion" => "val",      "contenido"  => $adataPersonas[0]["COD_PAIS"]);
            //agregado 25.06.2018
            $aDatos[] = array("id_html" => "cboNacionalidad",       "opcion" => "val",      "contenido"  => $adataPersonas[0]["COD_NACIONALIDAD"]);
            //agregado 25.06.2018

            $region   = $adataPersonas[0]["REGION"];
            $aDatos[] = array("id_html" => "cboRegion",             "opcion" => "val",      "contenido"  => $adataPersonas[0]["REGION"]);
            $aDatos[] = array("id_html" => "respuesta",             "opcion" => "append",   "contenido"  => "<script>buscaComunas('" . $region . "','cboComuna','" . $adataPersonas[0]["COD_COMUNA"] . "');</script>");
            $aDatos[] = array("id_html" => "respuesta",             "opcion" => "append",   "contenido"  => "<script>buscaCiudades('" . $region . "','cboCiudad','" . $adataPersonas[0]["COD_CIUDAD"] . "');</script>");

            $aDatos[] = array("id_html" => "cboviadire",            "opcion" => "val",      "contenido"  => $adataPersonas[0]["COD_VIADIRECCION"]);
            $aDatos[] = array("id_html" => "txtDireccion",          "opcion" => "val",      "contenido"  => $adataPersonas[0]["NOM_DIRECC"]);
            $aDatos[] = array("id_html" => "txtNum_dire",           "opcion" => "val",      "contenido"  => $adataPersonas[0]["NCASAL"]);
            $aDatos[] = array("id_html" => "txtdire_resto",         "opcion" => "val",      "contenido"  => $adataPersonas[0]["NOM_RESTODIRECC"]);
            $aDatos[] = array("id_html" => "cboProcedencia",        "opcion" => "val",      "contenido"  => $adataPersonas[0]["IND_URBRUR"]);
            $aDatos[] = array("id_html" => "txtTelefono",           "opcion" => "val",      "contenido"  => $adataPersonas[0]["FONO1"]);
            $aDatos[] = array("id_html" => "txtCelular",            "opcion" => "val",      "contenido"  => $adataPersonas[0]["NUM_CELULAR"]);
            $aDatos[] = array("id_html" => "txtEmail",              "opcion" => "val",      "contenido"  => $adataPersonas[0]["EMAIL"]);
            $aDatos[] = array("id_html" => "cboGrupoSangre",        "opcion" => "val",      "contenido"  => $adataPersonas[0]["COD_GRUSAN"]);
            $aDatos[] = array("id_html" => "cboFactorSangre",       "opcion" => "val",      "contenido"  => $adataPersonas[0]["COD_FACSAN"]);
            $aDatos[] = array("id_html" => "cboTippac",             "opcion" => "val",      "contenido"  => $adataPersonas[0]["IND_TIPPAC"]);

            $aDatos[] = array("id_html" => "txtRepLegal",           "opcion" => "val",      "contenido"  => $adataPersonas[0]["REP_LEGAL"]);
            $aDatos[] = array("id_html" => "txtOcupacion",          "opcion" => "val",      "contenido"  => $adataPersonas[0]["OCUPACION"]);

            $aDatos[] = array("id_html" => "ind_nivel_educacional",     "opcion" => "val",      "contenido"  => $adataPersonas[0]["IND_NIVEL_EDUCACIONAL"]);
            $aDatos[] = array("id_html" => "ind_poblacion_migrante",    "opcion" => "val",      "contenido"  => $adataPersonas[0]["IND_POBLACION_MIGRANTE"]);

            $aDatos[] = array("id_html" => "respuesta",                 "opcion" => "append",   "contenido"  => "<script>$('#rdoprais_" . $adataPersonas[0]["IND_CONDPRAIS"] . "').prop('checked', true);</script>");
            $aDatos[] = array("id_html" => "respuesta",                 "opcion" => "append",   "contenido"  => "<script>$('#rdotrans_" . $adataPersonas[0]["IND_TRANS"] . "').prop('checked', true);</script>");

            if ($templete == '2') { //Solo Local
                $aDatos[] = array("id_html" => "txtRepLegalL",          "opcion" => "val",      "contenido"  => $adataPersonas[0]["REP_LEGAL"]);
                $aDatos[] = array("id_html" => "txtOcupacionL",         "opcion" => "val",      "contenido"  => $adataPersonas[0]["OCUPACION"]);
            } else if ($templete == '1') { //General
                $aDatos[] = array("id_html" => "txtRepLegal",           "opcion" => "console",  "contenido"  => $adataPersonas[0]["REP_LEGAL"]);
                $aDatos[] = array("id_html" => "txtOcupacion",          "opcion" => "console",  "contenido"  => $adataPersonas[0]["OCUPACION"]);
            }

            //INICIO DATOS LOCALES
            $adataDLocales = $this->ssan_bdu_creareditarpaciente_model->getTraeDatosLocalesPac($adataPersonas[0]["NUM_FICHAEPACTE"], $codEmpresa);
            //$aDatos[] = array("id_html" => "",                              "opcion" => "console",      "contenido"  => $adataDLocales);
            $aDatos[]       = array("id_html" => "RutLabel",                "opcion" => "html", "contenido"  => $adataPersonas[0]["RUTPAC"] . "-" . $adataPersonas[0]["DIGVERPAC"]);
            $aDatos[]       = array("id_html" => "nombreLabel",             "opcion" => "html", "contenido"  => $adataPersonas[0]["NOMBREPAC"] . " " . $adataPersonas[0]["APEPATPAC"] . " " . $adataPersonas[0]["APEMATPAC"]);
            if (count($adataDLocales) > 0) {
                //$aDatos[] = array("id_html" => "txtNum_direLocal",              "opcion" => "val",  "contenido"  => $adataDLocales[0]["LNCASA"]);
                
                $aDatos[] = array("id_html" => "",              "opcion" => "console",  "contenido"  => "templete       ->".$templete);       
                $aDatos[] = array("id_html" => "",              "opcion" => "console",  "contenido"  => "codEmpresa     ->".$codEmpresa);       
                $boorean_tieneficha = $adataDLocales[0]["NUM_NFICHA"]==''?false:true;
                $aDatos[] = array("id_html" => "",              "opcion" => "console",  "contenido"  => "tiene ficha    ->".$boorean_tieneficha);
                
                if($codEmpresa == '100' || $codEmpresa == '106' || $codEmpresa == '029'  || $adataPersonas[0]["RUTPAC"] == '18284358' ){
                    //************** 100 106 **********
                    if ($adataPersonas[0]["RUTPAC"]=='18284358'){
                        
                    } else {
                        $aDatos[] = array("id_html" => "group_nueva_fichalocal",                "opcion" => "hide",  "contenido"  => "");
                        $aDatos[] = array("id_html" => "txt_nficha",                            "opcion" => "html",  "contenido"  =>  "<h5><b>".$adataDLocales[0]["NUM_NFICHA"]."</b></h5>");
                    }
                } else {
                    
                }

                
                $aDatos[]       = array("id_html" => "txtFichaFisicaLocal",     "opcion" => "val",      "contenido"  => $adataDLocales[0]["NUM_NFICHA"]);
                $aDatos[]       = array("id_html" => "hdnNLocal",               "opcion" => "val",      "contenido"  => $adataDLocales[0]["NUM_NFICHA"]);

                if (isset($adataDLocales[0]["SECTOR"])) {
                    $aDatos[]   = array("id_html" => "txtSector",               "opcion" => "html",     "contenido"  => $adataDLocales[0]["SECTOR"]);
                } else {
                    $aDatos[]   = array("id_html" => "txtSector",               "opcion" => "html",     "contenido"  => "<b>SIN INFORMACION</b>");
                }

                if (isset($adataDLocales[0]["COD_FAMILIA"])) {
                    $aDatos[]   = array("id_html" => "txtCodFamilia",           "opcion" => "html",     "contenido"  => $adataDLocales[0]["COD_FAMILIA"]);
                } else {
                    $aDatos[]   = array("id_html" => "txtCodFamilia",           "opcion" => "html",     "contenido"  => "<b>SIN INFORMACION</b>");
                }

                if ($adataDLocales[0]["COD_REGIONL"] == '') {
                    $aDatos[]   = array("id_html" => "cboRegionLocal",          "opcion" => "val",      "contenido"  => $region);
                    $regionl    = $region;
                } else {
                    $aDatos[]   = array("id_html" => "cboRegionLocal",          "opcion" => "val",      "contenido"  => $adataDLocales[0]["COD_REGIONL"]);
                    $regionl    = $adataDLocales[0]["COD_REGIONL"];
                }

                //$aDatos[]     = array("id_html" => "respuesta",                       "opcion" => "append",   "contenido"  => "<script>console.log('".$region."','cboCiudadLocal','".$adataDLocales[0]["COD_COMUNAL"]."');</script>");
                //$aDatos[]     = array("id_html" => "respuesta",                       "opcion" => "append",   "contenido"  => "<script>console.log('".$region."','cboComunaLocal','".$adataDLocales[0]["COD_CIUDADL"]."');</script>");

                $aDatos[]       = array("id_html" => "respuesta",                       "opcion" => "append",   "contenido"  => "<script>buscaComunas('" . $regionl . "','cboComunaLocal','" . $adataDLocales[0]["COD_COMUNAL"] . "');</script>");
                $aDatos[]       = array("id_html" => "respuesta",                       "opcion" => "append",   "contenido"  => "<script>buscaCiudades('" . $regionl . "','cboCiudadLocal','" . $adataDLocales[0]["COD_CIUDADL"] . "');</script>");

                $aDatos[]       = array("id_html" => "txtDireccionLocal",               "opcion" => "val",      "contenido"  => $adataDLocales[0]["DIRECLOCAL"]);
                $aDatos[]       = array("id_html" => "txtTelefonoLocal",                "opcion" => "val",      "contenido"  => $adataDLocales[0]["FONO2"]);
                $aDatos[]       = array("id_html" => "txtCelularLocal",                 "opcion" => "val",      "contenido"  => $adataDLocales[0]["CELLOCAL"]);
                $aDatos[]       = array("id_html" => "txtNombreContacto",               "opcion" => "val",      "contenido"  => $adataDLocales[0]["NOM_CONTACTO"]);
                $aDatos[]       = array("id_html" => "txtDireccionContacto",            "opcion" => "val",      "contenido"  => $adataDLocales[0]["DIRECC_CONTACTO"]);
                $aDatos[]       = array("id_html" => "txtNum_direContacto",             "opcion" => "val",      "contenido"  => $adataDLocales[0]["NCASA"]);
                $aDatos[]       = array("id_html" => "txtTelefonoContacto",             "opcion" => "val",      "contenido"  => $adataDLocales[0]["TELEFO_CONTACTO"]);
                $aDatos[]       = array("id_html" => "txtCelularContacto",              "opcion" => "val",      "contenido"  => $adataDLocales[0]["CELCONTACTO"]);
                $aDatos[]       = array("id_html" => "tieneDatosLocales",               "opcion" => "val",      "contenido"  => "1");
            } else {
                
                $aDatos[]       = array("id_html" => "txtFichaLocal",                   "opcion" => "html",     "contenido"  => "<b>SIN INFORMACI&Oacute;N</b>");
                $aDatos[]       = array("id_html" => "txtCodFamilia",                   "opcion" => "html",     "contenido"  => "<b>SIN INFORMACI&Oacute;N</b>");
                $aDatos[]       = array("id_html" => "txtSector",                       "opcion" => "html",     "contenido"  => "<b>SIN INFORMACI&Oacute;N</b>");
                $aDatos[]       = array("id_html" => "hdnNLocal",                       "opcion" => "disabled", "contenido"  => "");
                $aDatos[]       = array("id_html" => "tieneDatosLocales",               "opcion" => "val",      "contenido"  => "0");
                
            }

            //BuscaInformacionTitular
            if (isset($adataPersonas[0]["COD_RUTPAC"])) {
                $titular = $this->ssan_bdu_creareditarpaciente_model->traeDatosTitularxRut($adataPersonas[0]["COD_RUTPAC"]);
                //$titular = $this->ssan_bdu_creareditarpaciente_model->getTraePrevisionPacienteNfichaE($adataPersonas[0]["NUM_FICHAEPACTE"]);
                //$aDatos[] = array("id_html" => "txtRuttit",                     "opcion" => "console",  "contenido"  => $titular);
                //INICIO DATOS PREVISIONALES 
                if (count($titular) > 0) {
                    $aDatos[] = array("id_html" => "txtRuttit",                 "opcion" => "val",  "contenido"  => $titular[0]["COD_RUTTIT"]);
                    $aDatos[] = array("id_html" => "txtDvtit",                  "opcion" => "val",  "contenido"  => $titular[0]["COD_DIGVER"]);
                    $aDatos[] = array("id_html" => "txtNombretit",              "opcion" => "val",  "contenido"  => $titular[0]["NOM_NOMBRE"]);
                    $aDatos[] = array("id_html" => "txtApellidoPaternotit",     "opcion" => "val",  "contenido"  => $titular[0]["NOM_APEPAT"]);
                    $aDatos[] = array("id_html" => "txtApellidoMaternotit",     "opcion" => "val",  "contenido"  => $titular[0]["NOM_APEMAT"]);
                    $aDatos[] = array("id_html" => "cboPrevision",              "opcion" => "val",  "contenido"  => $titular[0]["IND_PREVIS"]);
                    $aDatos[] = array("id_html" => "cboEmpresaPrevision",       "opcion" => "val",  "contenido"  => $titular[0]["NUM_RUTINS"]);
                } else {
                    //$aDatos[] = array("id_html" => "txtRuttit",               "opcion" => "console",  "contenido"  => "buscar api fonasa");
                    $aDatos[] = array("id_html" => "txtRuttit",                 "opcion" => "val",  "contenido"  => $adataPersonas[0]["RUTPAC"]);
                    $aDatos[] = array("id_html" => "txtDvtit",                  "opcion" => "val",  "contenido"  => $adataPersonas[0]["DIGVERPAC"]);
                    $aDatos[] = array("id_html" => "txtNombretit",              "opcion" => "val",  "contenido"  => $adataPersonas[0]["NOMBREPAC"]);
                    $aDatos[] = array("id_html" => "txtApellidoPaternotit",     "opcion" => "val",  "contenido"  => $adataPersonas[0]["APEPATPAC"]);
                    $aDatos[] = array("id_html" => "txtApellidoMaternotit",     "opcion" => "val",  "contenido"  => $adataPersonas[0]["APEMATPAC"]);
                }
            } else {
                //INICIO DATOS PREVISIONALES   
                $aDatos[] = array("id_html" => "txtRuttit",                     "opcion" => "val",  "contenido"  => $adataPersonas[0]["RUTPAC"]);
                $aDatos[] = array("id_html" => "txtDvtit",                      "opcion" => "val",  "contenido"  => $adataPersonas[0]["DIGVERPAC"]);
                $aDatos[] = array("id_html" => "txtNombretit",                  "opcion" => "val",  "contenido"  => $adataPersonas[0]["NOMBREPAC"]);
                $aDatos[] = array("id_html" => "txtApellidoPaternotit",         "opcion" => "val",  "contenido"  => $adataPersonas[0]["APEPATPAC"]);
                $aDatos[] = array("id_html" => "txtApellidoMaternotit",         "opcion" => "val",  "contenido"  => $adataPersonas[0]["APEMATPAC"]);
                $aDatos[] = array("id_html" => "cboPrevision",                  "opcion" => "val",  "contenido"  => $adataPersonas[0]["IND_PREVIS"]);
                //$aDatos[] = array("id_html" => "cboEmpresaPrevision",         "opcion" => "val",  "contenido"  => $adataPersonas[0]["APEMATPAC"]);
                $aDatos[] = array("id_html" => "formulario_provisionales",      "opcion" => "hide", "contenido"  => '');
                //FINAL  DATOS PREVISIONALES  
            }

            if ($isRN == 0) {
                //NO SE RECIEN NACIDO
                $aDatos[] = array("id_html" => "Btn_bdu",                   "opcion" => "onclick",  "contenido"  => "editapaciente($isNal,0," . $adataPersonas[0]["NUM_FICHAE"] . ")");
                $aDatos[] = array("id_html" => "isNewPac",                  "opcion" => "val",      "contenido"  => "0");

                if ($templete == '1') {
                } else  if ($templete == '2') {
                    //Solo estamoes editando los datos locales //AHORA TABS
                    $aDatos[] = array("id_html" => "tabs_datosgenerales",       "opcion" => "remove",  "contenido"  => "");
                    $aDatos[] = array("id_html" => "tabs_datosprevisionales",   "opcion" => "remove",  "contenido"  => "");
                    $aDatos[] = array("id_html" => "tabs_datosextranjero",      "opcion" => "remove",  "contenido"  => "");
                    $aDatos[] = array("id_html" => "datos_generales",           "opcion" => "remove",  "contenido"  => "");
                    $aDatos[] = array("id_html" => "tabs_datosprevisionales",   "opcion" => "remove",  "contenido"  => "");
                    $aDatos[] = array("id_html" => "tabs_datosextranjero",      "opcion" => "remove",  "contenido"  => "");
                    //$aDatos[] = array("id_html" => "respuesta",                 "opcion" => "append",  "contenido"  => "<scrtip><scrtip>");
                }

                if ($isNal == 0) {
                    $aDatos[] = array("id_html" => "txtFecvencePasport",        "opcion" => "val",      "contenido"  => $adataPersonas[0]["FECVENCEPASPORT"]);
                    $aDatos[] = array("id_html" => "txtFecvence_fonasa",        "opcion" => "val",      "contenido"  => $adataPersonas[0]["FEC_IDFONASA"]);
                }
            } else {
                $aDatos[] = array("id_html" => "Btn_bdu",                   "opcion" => "onclick",  "contenido"  => "creaRN($isNal,0," . $adataPersonas[0]["NUM_FICHAE"] . ")");
            }


            if (($adataPersonas[0]["COD_RUTPAC"] != '') && ($adataPersonas[0]["COD_DIGVER"] != '')) {
                //*************** 10.02.2020 INFORMACION PERCAPITA  ****************
                $aDatos[]        =   array("id_html"    =>  "dropdown_opciones",      "opcion" => "show",        "contenido"  => "");
                //$SCRIPT		=   'a = document.getElementById("a_ver_percapita");  a.setAttribute("href", "javascript:ver_infopercapita('.$adataPersonas[0]["COD_RUTPAC"].',\''.$adataPersonas[0]["COD_DIGVER"].'\')");';
                $SCRIPT            =   'a = document.getElementById("a_ver_percapita");  a.setAttribute("href", "javascript:ver_infopercapita(\'' . $adataPersonas[0]["COD_RUTPAC"] . "-" . $adataPersonas[0]["COD_DIGVER"] . '\')");';
                $aDatos[]        =   array("id_html"    =>  "respuesta",                "opcion" => "append",        "contenido"  => "<script>$SCRIPT</script>");
                //*************** 10.02.2020 INFORMACION PERCAPITA  ****************
            }
        } else {
            #*************** 10.02.2020 INFORMACION PERCAPITA  ****************
            #$aDatos[]   =   array("id_html"    =>  "dropdown_opciones",        "opcion" => "show",         "contenido"  => "");
            #$SCRIPT     =   'a = document.getElementById("a_ver_percapita");  a.setAttribute("href",       "javascript:ver_infopercapita(\'' . $rut . "-" . $dv . '\')");';
            #$aDatos[]   =   array("id_html"    =>  "respuesta",                "opcion" => "append",       "contenido"  => "<script>$SCRIPT</script>");
            #$aDatos[]  =   array("id_html"	    =>  "respuesta",                "opcion" => "append",	    "contenido"  => "<script>cargaInfoFonasa('$rut','$dv')</script>");
            $aDatos[]   =   array("id_html"    =>  "respuesta",                "opcion" => "append",        "contenido"  => "<script>cargaInfoApi('$rut','$dv')</script>");
            $aDatos[]   =   array("id_html"    =>  "Btn_bdu",                  "opcion" => "onclick",       "contenido"  => "NuevoPacienteChileno(1,$isRN)");
            $aDatos[]   =   array("id_html"    =>  "isNewPac",                 "opcion" => "val",           "contenido"  => "1");
            $aDatos[]   =   array("id_html"    =>  "numFichae",                "opcion" => "val",           "contenido"  => "0");

        }
        $this->output->set_output(json_encode($aDatos));
    }

    public function cont_buscaCiudades() {
        if (!$this->input->is_ajax_request()) { show_404();  }
        $codEmpresa         = $this->session->userdata("COD_ESTAB");
        $Region             = $this->input->post("Region");
        $select             = $this->input->post("select");
        $idSelect           = $this->input->post("idSelect");
        $Fciudades          = $this->ssan_bdu_creareditarpaciente_model->getTraeCiudadAll($Region);
        //$Fciudades        = $this->ssan_bdu_creareditarpaciente_model->sqlTraeCodigoComuna($Region);
        if (count($Fciudades) > 0) {
            foreach ($Fciudades as $ciu) {
                $aDatos[]   = array("id_html" => $select,  "opcion" => "append", "contenido"  => "<option value='" . $ciu['CODIGO'] . "'>" . $ciu['CIUDAD'] . " (" . $ciu['CODIGO'] . ")</option>");
            }
            if ($idSelect   == 'undefined' or $idSelect == '') {
                //$aDatos[]   = array("id_html" => 'cboComuna', "opcion" => "append",     "contenido"  => '<option value="" selected="">SELECCIONE ... </option>');
            } else {
                $aDatos[]   = array("id_html" => $select, "opcion" => "val",      "contenido"  => $idSelect);
            }
        } else {
            $aDatos[]   = array("id_html" => $select, "opcion" => "append", "contenido"  => "<option selected value='0'> NO ESPECIFICADA... </option>");
        }
        $this->output->set_output(json_encode($aDatos));
    }
    

    public function Cont_buscaComunas()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $codEmpresa         = $this->session->userdata("COD_ESTAB");
        $Region             = $this->input->post("Region");
        $select             = $this->input->post("select");
        $idSelect           = $this->input->post("idSelect");
        $Fciudades          = $this->ssan_bdu_creareditarpaciente_model->sqlTraeCodigoComuna($Region);
        //$Fciudades        = $this->ssan_bdu_creareditarpaciente_model->getTraeCiudadAll($Region);
        if (count($Fciudades) > 0) {
            foreach ($Fciudades as $ciu) {
                $aDatos[] = array("id_html" => $select,     "opcion" => "append",  "contenido"  => "<option value='" . $ciu['CODIGO'] . "'> " . $ciu['CIUDAD'] . " (" . $ciu['CODIGO'] . ")</option>");
            }
            if ($idSelect == 'undefined' or $idSelect == '') {
                //$aDatos[] = array("id_html" => 'cboComuna', "opcion" => "append",  "contenido"  => '<option value="" selected="">SELECCIONE ... </option>');
            } else {
                $aDatos[] = array("id_html" => $select,    "opcion" => "val",     "contenido"  => $idSelect);
            }
        } else {
            $aDatos[] = array("id_html" => $select,    "opcion" => "append",  "contenido"  => "<option value='0'> NO ESPECIFICADA... </option>");
        }
        $this->output->set_output(json_encode($aDatos));
    }

    public function buscaPacienteExtranjero()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $codEmpresa         =    $this->session->userdata("COD_ESTAB");
        $IDselect           =    $this->input->post("IDselect");
        $txtNumero          =    trim($this->input->post("txtNumero"));
        $numFichae          =    $this->input->post("numfichae");
        $esChileno          =    '0';
        $adataPersonas      =    '';
        $NumFonasa          =    $this->input->post("NumFonasa");
        $DvFonasa           =    $this->input->post("DvFonasa");
        $validaExtranjero   =    array();
        $rutFonasa          =    null;
        $datePasaporte      =    '';
        if ($numFichae == null || $numFichae == '') {
            if ($IDselect    == '1') { //(DIN)
                $validaExtranjero    = $this->ssan_bdu_creareditarpaciente_model->getValidaDNI_PASAPORTE($codEmpresa, $txtNumero, 1);
            } else if ($IDselect    == '2') { //(RUT PROVISIORIO FONASA)
                //que no sea otoro chileno
                $adataPersonas      = $this->ssan_bdu_creareditarpaciente_model->getPacientesUnico('', $NumFonasa, $codEmpresa, 1, '', '');
                if (count($adataPersonas) > 0) {
                    $esChileno          = '1';
                } else {
                    $validaExtranjero   = $this->ssan_bdu_creareditarpaciente_model->getValidaRutFonasa($codEmpresa, $NumFonasa);
                }
            } else if ($IDselect == '3') { //PASAPORTE
                $validaExtranjero   = $this->ssan_bdu_creareditarpaciente_model->getValidaDNI_PASAPORTE($codEmpresa, $txtNumero, 2);
            } else if ($IDselect == '4') { //UNICO SSAN
                $txtNumero          = substr($txtNumero, 5);
                //$aDatos[]         = array("id_html" => 'respuesta', "opcion" => "console","contenido"=>"NUM E--->".$txtNumero);  
                $validaExtranjero   = $this->ssan_bdu_creareditarpaciente_model->getValidaIdUnico($codEmpresa, $txtNumero);
            } else {
                $validaExtranjero   = null;
            }

            ///$aDatos[]   = array("id_html" => 'respuesta',           "opcion" => "console",  "contenido"  => $esChileno);
            if ($esChileno == 1) {
                $aDatos[]   = array("id_html"    => 'respuesta',            "opcion" => "jError",  "contenido"  => "Rut Corresponde a Chileno Inscrito");
                $aDatos[]   = array("id_html"    => 'respuesta',            "opcion" => "append",  "contenido"  => "<script>$('#modalPaciente').modal('hide')</script>");
            }
            if (count($validaExtranjero) > 0) {
                $numFichae2 = $validaExtranjero[0]['NUMFICHAE'];
                $aDatos[]   = array("id_html"   => 'respuesta',                 "opcion" => "append",   "contenido"  => "<script>validExtrangero(0," . $numFichae2 . ")</script>");
                $aDatos[]   = array("id_html"   => 'isNewPac',                  "opcion" => "val",      "contenido"  => "0");
                $aDatos[]   = array("id_html"   => 'numFichae',                 "opcion" => "val",      "contenido"  => $validaExtranjero[0]['NUMFICHAE']);
            } else {
                $aDatos[]   = array("id_html"   => 'numFichae',                 "opcion" => "val",      "contenido"  => '0');
                if ($IDselect   == '4') {
                    $aDatos[]   = array("id_html"   => 'respuesta',                 "opcion" => "jError",   "contenido"  => "No Se encontro numero SSAN");
                    $aDatos[]   = array("id_html"   => 'respuesta',                 "opcion" => "append",   "contenido"  => "<script>buscaOtroSSAN(1)</script>");
                } else {
                    $aDatos[]   = array("id_html"   => 'txtFechaNacimineto',        "opcion" => "val",      "contenido"  => date("d/m/Y"));
                    $aDatos[]   = array("id_html"   => 'respuesta',                 "opcion" => "append",   "contenido"  => $datePasaporte);
                    $aDatos[]   = array("id_html"   => 'txtFecvencePasport',        "opcion" => "val",      "contenido"  => date("d/m/Y"));

                    $aDatos[]   = array("id_html"   => 'txtFecvence_fonasa',        "opcion" => "val",      "contenido"  => date("d/m/Y"));

                    $aDatos[]   = array("id_html"   => 'isNewPac',                  "opcion" => "val",      "contenido"  => "1");
                    $aDatos[]   = array("id_html"   => "Btn_bdu",                   "opcion" => "onclick",  "contenido"  => "nuevoExtranjero('$IDselect','$NumFonasa')");
                    if ($IDselect    == '2') {
                        $aDatos[]   = array("id_html"   => 'txtRuttit',                 "opcion" => "val",      "contenido"  => $NumFonasa);
                        $aDatos[]   = array("id_html"   => 'txtDvtit',                  "opcion" => "val",      "contenido"  => $DvFonasa);
                        $aDatos[]   = array("id_html"   => "formulario_provisionales",  "opcion" => "show",     "contenido"  => "");
                        $aDatos[]   = array("id_html"   => "soloExnjerosFonasa",        "opcion" => "hide",     "contenido"  => "");
                        $aDatos[]   = array("id_html"   => "respuesta",                 "opcion" => "append",   "contenido"  => "<script>$('#PreviExtr_0').prop('checked', false);</script>");
                        $aDatos[]   = array("id_html"   => "respuesta",                 "opcion" => "append",   "contenido"  => "<script>$('#PreviExtr_1').prop('checked', true);</script>");
                    }
                }
            }
        } else {
            $aDatos[]   = array("id_html" => 'respuesta',                   "opcion" => "append",  "contenido"  => "<script>validExtrangero(1," . $numFichae . ")</script>");
            $aDatos[]   = array("id_html" => 'isNewPac',                    "opcion" => "val",     "contenido"  => "0");
        }
        $this->output->set_output(json_encode($aDatos));
    }

    public function validaFichaLocal(){
        if (!$this->input->is_ajax_request()){  show_404();   }
        $codEmpresa         =   $this->session->userdata("COD_ESTAB")==''?$this->input->post("COD_ESTAB"):$this->session->userdata("COD_ESTAB");
        #$codEmpresa        =   $this->session->userdata("COD_ESTAB");
        $val                =   $this->input->post("val");
        $fLPaciente         =   $this->input->post("fLPaciente");
        $nfichaE            =   $this->input->post("nfichaE");
        $aDatos             =   [];
        $DatosPaciente      =   $this->ssan_bdu_creareditarpaciente_model->ConsultaFicLoal($fLPaciente,$codEmpresa);
        if (count($DatosPaciente) > 0) {
            if ($DatosPaciente[0]['NUM_FICHAE']  == $nfichaE) {
                $aDatos[]               =   array("id_html" => 'respuesta',           "opcion" => "console",  "contenido"  => 'LA MISMA FICHA');
            } else {
                $nombrePaciente_own     =   $DatosPaciente[0]['NOM_NOMBRE'] . " " . $DatosPaciente[0]['NOM_APEPAT'] . " " . $DatosPaciente[0]['NOM_APEMAT'];
                $rutPaciente_own        =   $DatosPaciente[0]['COD_DIGVER'] . " " . $DatosPaciente[0]['COD_RUTPAC'];
                $html                   =   "<h1>Sr. Usuario</h1><p>EL n&uacute;mero de Ficha ingresado se encuentra asignado al Paciente " . $nombrePaciente_own . " RUT: " . $rutPaciente_own . "  en el Establecimiento.<br/>No es posible realizar la asignaci&oacute;n.<br/><br/>Administrador del Sistema.</p>";
                $aDatos[]               =   array("id_html" => 'respuesta',           "opcion" => "jAlert",   "contenido"  => $html);
                $aDatos[]               =   array("id_html" => 'txtFichaFisicaLocal', "opcion" => "val",      "contenido"  => '');
            }
        } else {
            //$aDatos[]               =   array("id_html" => 'respuesta', "opcion" => "console",  "contenido"  => 'SIN FICHA');
        }
        //$aDatos[]       = array("id_html" => 'respuesta', "opcion" => "console",  "contenido"  => $DatosPaciente);
        $this->output->set_output(json_encode($aDatos));
    }

    function buscaArrayFonasa()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $aDatos         = '';
        $txtRuttit      = $this->session->userdata("rut");
        $txtDvtit       = $this->input->post("dv");
        $respuesta      = $this->ssan_bdu_creareditarpaciente_model->getbusquedaCertificadoFONASA($txtRuttit, $txtDvtit);
        //$aDatos[]     = array("id_html" => "respuesta", "opcion" => "console",  "contenido"  => $respuesta);
        $this->output->set_output(json_encode($aDatos));
    }


    //***************************** nuevo 20.01.2020 ***************************
    public function api_personas(){
        $this->load->library('api_minsal');
        $codEmpresa             =   $this->session->userdata("COD_ESTAB");
        $txtRuttit              =   $this->input->post("txtRuttit");
        $txtDvtit               =   $this->input->post("txtDvtit");
        $aDatos[]               =   array("id_html" => "", "opcion" => "console", "contenido"  => $txtRuttit);
        $aDatos[]               =   array("id_html" => "", "opcion" => "console", "contenido"  => $txtDvtit);
        //$txtRuttit		    =   '17745477';
        //$txtDvtit		        =   'K';
        $urlApi                 =   'https://apiqa.minsal.cl/v2/personas/datos/basicos/run?';
        $data                   =   array(
            'runPersona'    =>  $txtRuttit,
            'dvPersona'     =>  $txtDvtit
        );

        $return            =   $this->api_minsal->getRecurso($data, $urlApi);
        $aData            =   $return['data'];
        if ($aData->estado->codigo == 'NOK') { // Descripcion del error
            $aDatos[]        =   array("id_html" => "",  "opcion" => "console",  "contenido"  => $aData->estado->descripcion);
            $aDatos[]        =   array("id_html" => "",  "opcion" => "console",  "contenido"  => $aData->observaciones[0]->descripcion);
            $aDatos[]        =   array("id_html" => "",  "opcion" => "jAlert",   "contenido"  => "Paciente no encontrado Base de datos API Minsal, Ingresar datos del paciente manualmente");
        } else {
            //$aDatos[]		=   array("id_html" => "",  "opcion" => "jAlert",   "contenido"  => "PACIENTE ENCONTRADO");
            $aData2        =   $aData->resultado;
            $aDatos[]        =   array("id_html" => "",  "opcion" => "console",  "contenido"  => "---------------");
            $aDatos[]        =   array("id_html" => "",  "opcion" => "console",  "contenido"  => $aData2);
            $aDatos[]        =   array("id_html" => "",  "opcion" => "console",  "contenido"  => "---------------");
            if (isset($aData2->nombresPersona)) {
                $aDatos[]    =   array("id_html" => "txtNombre",            "opcion" => "val",    "contenido"  =>  $aData2->nombresPersona);
            }
            if (isset($aData2->primerApellidoPersona)) {
                $aDatos[]    =   array("id_html" => "txtApellidoPaterno",        "opcion" => "val",    "contenido"  =>  $aData2->primerApellidoPersona);
            }
            if (isset($aData2->segundoApellidoPersona)) {
                $aDatos[]    =   array("id_html" => "txtApellidoMaterno",        "opcion" => "val",    "contenido"  =>  $aData2->segundoApellidoPersona);
            }
            if (isset($aData2->fechaNacimiento)) {
                $aDatos[]    =   array("id_html" => "txtFechaNacimineto",        "opcion" => "val",    "contenido"  =>   $aData2->fechaNacimiento);
            }
            if (isset($aData2->codSexo)) {
                if ($aData2->codSexo == '02') {
                    $aDatos[]    =   array("id_html" => "cboGenero",            "opcion" => "val",    "contenido"  =>  'F');
                } else if ($aData2->codSexo == '01') {
                    $aDatos[]    =   array("id_html" => "cboGenero",            "opcion" => "val",    "contenido"  =>  'M');
                } else {
                    $aDatos[]    =   array("id_html" => "cboGenero",            "opcion" => "val",    "contenido"  =>  'D');
                }
            }
            if (isset($aData2->codPaisOrigen)) {
                if ($aData2->codPaisOrigen == '152') {
                    $aDatos[]    =   array("id_html" => "cboPais",            "opcion" => "val",    "contenido"  =>  'CL');
                    $aDatos[]    =   array("id_html" => "cboNacionalidad",        "opcion" => "val",    "contenido"  =>  'CL');
                }
            }
        }
        $this->output->set_output(json_encode($aDatos));
    }

    
    public function buscarPrevision()  {
        if (!$this->input->is_ajax_request()) { show_404();   }
        $codEmpresa             =   $this->session->userdata("COD_ESTAB");
        $txtRuttit              =   $this->input->post("txtRuttit");
        $txtDvtit               =   $this->input->post("txtDvtit");
        $ind_actualizo_fonasa   =   0;
        $ind_load_datosXws      =   1;
        $respuesta              =   [];
        $return_act_previ       =   false;
        $actualiza_pregunta     =   1;
        $respuesta              =   $this->ssan_bdu_creareditarpaciente_model->getbusquedaCertificadoFONASA($txtRuttit, $txtDvtit);
        //$respuesta            =   [];
        if (count($respuesta) > 0) {
            $ind_load_datosXws      =   1;
             
            if($respuesta['update_prevision'] == 1){
                $ind_actualizo_fonasa                   =   1;
                $session_arr                            =   explode("-",$this->session->userdata('USERNAME'));
                $session                                =   $session_arr[0];
                $return_act_previ                       =   $this->ssan_bdu_creareditarpaciente_model->get_ActualizaFonasa($txtRuttit,$txtDvtit,$respuesta['datosXws'],$session);
            }
            
            $aDatos[]                                   =   array("id_html" => "msjFonasa",             "opcion" => "show",     "contenido"  => '');
            if ($this->input->post("msjFonasa") == '1') {
                $aDatos[]                               =   array("id_html" => "txtFonasa",             "opcion" => "html",     "contenido"  => $respuesta['titulof']);
            }
            if ($this->input->post("tabFonasa") == '1') {
                $aDatos[]                               =   array("id_html" => "tableFonasa",           "opcion" => "html",     "contenido"  => $respuesta['tablaFon']);
            }
            if ($this->input->post("cDataGen")  == '1') {
                $aData                                  =     $respuesta['datosXws'];
                if (count($aData) > 0) {
                    /*
                    if (isset($aData->AfiliadoNombres)){
                       $aDatos[] = array("id_html" => "txtNombre",              "opcion" => "val",    "contenido"  =>  $aData->AfiliadoNombres);
                    }
                    if (isset($aData->AfiliadoApell1)){
                        $aDatos[] = array("id_html" => "txtApellidoPaterno",    "opcion" => "val",    "contenido"  =>  $aData->AfiliadoApell1);
                    }
                    if (isset($aData->AfiliadoApell2)){
                        $aDatos[] = array("id_html" => "txtApellidoMaterno",    "opcion" => "val",    "contenido"  =>  $aData->AfiliadoApell2);
                    }
                    if (isset($aData->Afiliadofecnac)){
                        $aDatos[] = array("id_html" => "txtFechaNacimineto",    "opcion" => "val",    "contenido"  =>  $aData->Afiliadofecnac);
                    }
                    if (isset($aData->AfiliadoSexo)){
                        $aDatos[] = array("id_html" => "cboGenero",             "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                    }  
		    */

                    if (isset($aData->AfiliadoNombres)) {
                        $aDatos[] = array("id_html" => "txtNombre",              "opcion" => "val",    "contenido"  =>  $aData->bTONombres);
                    }
                    if (isset($aData->AfiliadoNombres)) {
                        $aDatos[] = array("id_html" => "txtApellidoPaterno",     "opcion" => "val",    "contenido"  =>  $aData->bTOApell1);
                    }
                    if (isset($aData->AfiliadoApell1)) {
                        $aDatos[] = array("id_html" => "txtApellidoMaterno",    "opcion" => "val",    "contenido"  =>  $aData->bTOApell2);
                    }
                    if (isset($aData->bTOFecNacimi)) {
                        $aDatos[] = array("id_html" => "txtFechaNacimineto",    "opcion" => "val",    "contenido"  =>  date('d-m-Y',strtotime($aData->bTOFecNacimi)));
                    }
                    if (isset($aData->bTOSexo)) {
                        if ($aData->bTOSexo == 'Femenino') {
                            $aDatos[] = array("id_html" => "cboGenero",         "opcion" => "val",    "contenido"  =>  'F');
                        } else if ($aData->bTOSexo == 'Masculino') {
                            $aDatos[] = array("id_html" => "cboGenero",         "opcion" => "val",    "contenido"  =>  'M');
                        } else {
                            $aDatos[] = array("id_html" => "cboGenero",         "opcion" => "val",    "contenido"  =>  'D');
                        }
                    }
                    if (isset($aData->bTONacionalidad)) {
                        if ($aData->bTONacionalidad == 'CHILE') {
                            $aDatos[] = array("id_html" => "cboPais",           "opcion" => "val",    "contenido"  =>  'CL');
                            $aDatos[] = array("id_html" => "cboNacionalidad",   "opcion" => "val",    "contenido"  =>  'CL');
                        }
                    }
                }
                //$aDatos[] = array("id_html" => "cboEtnia1",             "opcion" => "val",    "contenido"  =>  $aData->AfiliadoApell2);
                //$aDatos[] = array("id_html" => "cboEtnia2",             "opcion" => "val",    "contenido"  =>  $aData->AfiliadoApell2);
                //$aDatos[] = array("id_html" => "cboEstadoCivil",        "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "txtPareja",             "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "txtPadre",              "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "txtMadre",              "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "cboPais",               "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "cboRegion",             "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);

                if (isset($aData->bTODireccion)) {
                    $aDatos[] = array("id_html" => "cboviadire",            "opcion" => "val",    "contenido"  =>  $aData->bTODireccion);
                }

                //$aDatos[] = array("id_html" => "txtDireccion",          "opcion" => "val",    "contenido"  =>  $aData->bTODireccion);
                //$aDatos[] = array("id_html" => "txtNum_dire",           "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "txtdire_resto",         "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "cboProcedencia",        "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "txtTelefono",           "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "txtCelular",            "opcion" => "val",    "contenido"  =>  $aData->bTOTelefono);
                //$aDatos[] = array("id_html" => "txtEmail",              "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "cboGrupoSangre",        "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);
                //$aDatos[] = array("id_html" => "cboFactorSangre",       "opcion" => "val",    "contenido"  =>  $aData->AfiliadoSexo);

                if ($aData->AfiliadoRut != $txtRuttit) {
                    $aDatos[]   = array("id_html" => "cboTippac",               "opcion" => "val",    "contenido"  => "D");
                    //$objResponse->addScript('$(\'#cboTippac\').val(\'D\')');
                    //$objResponse->addScript('revisaTitular();');
                } else {
                    $aDatos[]   = array("id_html" => "cboTippac",               "opcion" => "val",    "contenido"  => "T");
                    //$objResponse->addScript('revisaTitular();');
                }
                //$aDatos[]       = array("id_html" => "",                      "opcion" => "console",   "contenido"  => $respuesta['datosXws']);
            }

            if ($this->input->post("cDataPrv")  == '1') {
                if (isset($aData->AfiliadoRut)) {
                    $aDatos[] = array("id_html" => "txtRuttit",                 "opcion" => "val",    "contenido"  =>  $aData->AfiliadoRut);
                }

                if (isset($aData->AfiliadoRutDv)) {
                    $aDatos[] = array("id_html" => "txtDvtit",                  "opcion" => "val",    "contenido"  =>  $aData->AfiliadoRutDv);
                }

                if (isset($aData->AfiliadoNombres)) {
                    $aDatos[] = array("id_html" => "txtNombretit",              "opcion" => "val",    "contenido"  =>  utf8_encode($aData->AfiliadoNombres));
                }

                if (isset($aData->AfiliadoApell1)) {
                    $aDatos[] = array("id_html" => "txtApellidoPaternotit",     "opcion" => "val",    "contenido"  =>  utf8_encode($aData->AfiliadoApell1));
                }
                if (isset($aData->AfiliadoApell2)) {
                    $aDatos[] = array("id_html" => "txtApellidoMaternotit",     "opcion" => "val",    "contenido"  =>  utf8_encode($aData->AfiliadoApell2));
                }
                if (isset($aData->AfiliadoRut)) {
                    if ($aData->AfiliadoTramo != '') {
                        $aDatos[] = array("id_html" => "cboPrevision",          "opcion" => "val",    "contenido"  =>  $aData->AfiliadoTramo);
                    } else {
                        $aDatos[] = array("id_html" => "cboPrevision",          "opcion" => "val",    "contenido"  =>  "V");
                    }
                }
            }
            
            $aDatos[]               =   array("id_html" => "respuesta", "opcion" => "console",  "contenido"  => $respuesta['resultado']);
            $aDatos[]               =   array("id_html" => "respuesta", "opcion" => "console",  "contenido"  => $respuesta['datosXws']);
            $aDatos[]               =   array("id_html" => "respuesta", "opcion" => "console",  "contenido"  => $respuesta['update_prevision']);
            $aDatos[]               =   array("id_html" => "respuesta", "opcion" => "console",  "contenido"  => $respuesta['respuesta']);
            $aDatos[]               =   array("id_html" => "respuesta", "opcion" => "console",  "contenido"  => $respuesta['ruttit']);
            $aDatos[]               =   array("id_html" => "respuesta", "opcion" => "console",  "contenido"  => $respuesta['ruttitfo']);
            $aDatos[]               =   array("id_html" => "respuesta", "opcion" => "console",  "contenido"  => $respuesta['titulof']);
            
        } else {
            $ind_load_datosXws      =   0;
            $aDatos[]               =   array("id_html" => "respuesta",   "opcion" => "jAlert",   "contenido"  => "SIN INFORMACI&Oacute;N DE FONASA");
            $aDatos[]               =   array("id_html" => "msjFonasa",   "opcion" => "hide",     "contenido"  => '');
        }
        
        $this->output->set_output(json_encode(array(
            "ind_load_datosXws"     =>  $ind_load_datosXws,
            "arr_out"               =>  $aDatos,
            "actualiza_previ"       =>  $return_act_previ,
            "ind_actualizo_fonasa"  =>  $ind_actualizo_fonasa,
            "update_prevision"      =>  $ind_load_datosXws==1?$respuesta['update_prevision']:[],
            "pac_fallecido"         =>  $ind_actualizo_fonasa==1?$return_act_previ['ind_fallecido']:0,
            'datosXws'              =>  $ind_load_datosXws==1?$respuesta['datosXws']:[],
        )));
    }

    

    public function CreaCOOKEE()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $codEmpresa     = $this->session->userdata("COD_ESTAB");
        $numFichae      = $this->input->post('numFichae');
        //**********************************************
        $this->load->helper('cookie');

        $cookie = array(
            'name'      => 'the_cookie',
            'value'     => $numFichae,
            'expire'    => '15000000',
            'domain'    => 'http://10.5.183.123',
            'path'      => '/',
            'secure' => TRUE
        );
        $this->input->set_cookie($cookie);

        $cookie2 = array(
            'name'      => 'the_cookie2',
            'value'     => $numFichae,
            'expire'    => '15000000',
            'domain'    => '10.5.183.210',
            'path'      => '/',
        );
        $this->input->set_cookie($cookie2);
        // set the expiration date to one hour ago
        setcookie("TestCookie1", "", time() - 3600);
        setcookie("TestCookie2", "", time() - 3600, "/", "http://10.5.183.123", 1);
        setrawcookie("TestCookie3", "", time() - 3600, "/", "http://10.5.183.123", 1);

        //**********************************************
        $aDatos[]       = array('id_html' => 'resultados', 'opcion' => 'swal', 'contenido' => $numFichae . $codEmpresa);
        //$aDatos[]       = array('id_html'=>'resultados','opcion'=>'console','contenido'=>$numFichae.$codEmpresa);
        $this->output->set_output(json_encode($aDatos));
    }

    public function EditaPaciente()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $aDatos         = '';
        $codEmpresa     = $this->session->userdata("COD_ESTAB");
        $numFichae      = $this->input->post('numFichae');
        $isNal          = $this->input->post('isNal');
        //$aDatos[]       = array('id_html'=>'resultados','opcion'=>'console','contenido'=>$codEmpresa);
        $this->output->set_output(json_encode($aDatos));
    }

    public function guardaInformacionBDU(){
        if (!$this->input->is_ajax_request()){  show_404();  }
        $codEmpresa     =    $this->session->userdata("COD_ESTAB")==''?$this->input->post("COD_ESTAB"):$this->session->userdata("COD_ESTAB");
        $transaccion    =   '';
        $accesdata      =   '';
        $id             =   '';
        $isNew          =   $this->input->post('isNew');
        $isNal          =   $this->input->post('isNal');
        $RN             =   $this->input->post('RN');
        $numFichae      =   $this->input->post('numFichae');
        $IDselect       =   $this->input->post('IDselect');
        $txtNumero      =   $this->input->post('txtNumero');
        $RutMon         =   $this->input->post('RutMon');
        $FORM           =   $this->input->post('FORM');
        $rutTitul       =   $this->input->post('rutTitul');
        $Previ          =   $this->input->post('Previ');
        $password       =   $this->input->post('contrasena');
        $nuevaNFicha    =   $this->input->post('nuevaNFicha');

        if ($this->session->userdata("SISTYPO") == '1') {
            //**********************************typo3**************************************
            $valida     =   $this->ssan_his_historialclinico_model->validaClave($password, '61');
        } else {
            //*********************************codineiter*******************************
            #$valida     =   $this->ssan_spab_listaprotocoloqx_model->validaClave($password);
            $valida     =   true;
        }

        if ($valida) {
            $usuarioh   =   explode("-", $this->session->userdata("USERNAME"));
            $session    =   $usuarioh[0];
            $responde   =   $this->ssan_bdu_creareditarpaciente_model->GestorDatosBDU($codEmpresa, $session, $isNew, $isNal, $RN, $numFichae, $IDselect, $txtNumero, $RutMon, $FORM, $rutTitul, $Previ, $nuevaNFicha);
            $obj        =   explode("#", $responde);
            if ($obj[0]) {
                $return =   true;
                $id     =   $obj[1];
            } else {
                $return =   false;
                $id     =   null;
            }
        } else {
            $return     =   false;
        }

        $TABLA[0]       =   array("validez"     => $return);
        $TABLA[1]       =   array("transaccion" => $transaccion);
        $TABLA[3]       =   array("sql"         => $accesdata);
        $TABLA[4]       =   array("id"          => $id);
        $this->output->set_output(json_encode($TABLA));
    }

     public function editaextranjero(){
        if (!$this->input->is_ajax_request()) {  show_404();   }
        $codEmpresa     =   $this->session->userdata("COD_ESTAB");
        $numfichae      =   $this->input->post('numfichae');
        $html           =   '';
        $html           =   '<table width="100%" border="0" cellspacing="0" class="table-sm table-striped">
                                <tbody id="id_formLocal">
                                    <tr>
                                        <td width="50%">RUN</td>
                                        <td width="50%">
                                            <input type="text" id="new_busq_rut" name="new_busq_rut" class="form-control input-sm" style="width:101px;">
                                        </td>
                                        <script>
                                            $("#new_busq_rut").Rut({
                                                on_error    :   function(){ jAlert("El Rut ingresado es Incorrecto","Rut Incorrecto");  $("#new_busq_rut").css("border-color","red"); $("#new_busq_rut").val("") },
                                                on_success  :   function(){ 
                                                    console.log("comprobar que el rut no exista ->",$("#new_busq_rut").val() );
                                                },
                                                format_on   :   "keyup"
                                            });
                                        </script>    
                                    </tr> 
                                    <tr>
                                        <td  colspan="2"style="text-align: center;">
                                            <button type="button" class="btn btn-small btn-primary" onclick="agregar_rut_ext('.$numfichae.');" id="btn_buscageneral">
                                            &nbsp;AGREGAR R.U.T&nbsp;
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>';

        $TABLA[]        =   array("id_html" => "HTML_PDF", "opcion" => "html", "contenido" => $html);
        $this->output->set_output(json_encode($TABLA));
    }

    
    
    public function get_editaextranjero(){
        if (!$this->input->is_ajax_request()) {  show_404();   }
        $numfichae      =   $this->input->post('numfichae');
        $rut            =   $this->input->post('rut');
        $dv             =   $this->input->post('dv');
        
        $responde             = $this->ssan_bdu_creareditarpaciente_model->graba_rut_extranjero($numfichae,$rut,$dv);
        
        $TABLA["return"]        = true;
        $this->output->set_output(json_encode($TABLA));
    }
    
    
    


    public function encontrarPacienteExterno()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $codEmpresa         =  $this->session->userdata("COD_ESTAB");
        $vista              =  $this->input->post("vista");

        $html               =   '
        <table class="table table-striped"  width="100%">
            <tr class="success">
                <td style="width:40%;text-align: right;">
                    <div id="titulo_nombre"><b>BUSCAR PACIENTE/EDITA</b></div>
                </td>
                <td style="width:60%">
                
                </td>
            </tr>
            <tr id="trTipo">
                <td style="width:186px;text-align: right;">Tipo de Paciente:</td>
                <td>
                    <input type="radio" name="tipPac" value="0" id="checkReNacido"  onclick="cambiaTip(0)" checked/>
                    <label style="cursor:pointer" for="checkReNacido"><img class="shadow" src="assets/ssan_bdu_creareditarpaciente/img/bchile.jpg"></label> 
                    -    
                    <input type="radio" name="tipPac" value="1" id="checkExtranjero" onclick="cambiaTip(1)">
                    <label style="cursor:pointer" for="checkExtranjero"><img class="shadow" src="assets/ssan_bdu_creareditarpaciente/img/bInter.jpg"></label> 
                </td>
            </tr>
            <tr id="trEx" style="display: none;" >
                <td style="text-align: right;">Tipo Documento :</td>
                <td>
                    <select id="tipoEx" onchange="cambiaDoc(this.value);" style="width:210px">
                        <option value="1">Pasaporte/DNI Pa&iacute;s Origen</option>
                        <option value="2">ID Provisorio Fonasa</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td id="nameType" style="text-align: right;">RUN:</td>
                <td><input type="text" id="rut"><input type="text" id="dni" style="display: none;" maxlength="20"></td>
            </tr>
            <tr>
                <td style="text-align: right;">Nombre:</td>
                <td><input type="text" id="name"></td>
            </tr>
            <tr>
                <td style="text-align: right;">Apellido Paterno:</td>
                <td><input type="text" id="apellidoP"></td>
            </tr>
            <tr>
                <td style="text-align: right;">Apellido Materno:</td>
                <td><input type="text" id="apellidoM"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    <button type="button" class="btn btn-small btn-primary" onclick="buscar(0,1);" id="btn_buscageneral"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR</button>
                    &nbsp; 
                    <button type="button" class="btn btn-small btn-danger" onclick="limpiar(1);" id="btn_limpiageneral"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;LIMPAR</button>
                    &nbsp; 
                </td>
            </tr>
        </table>


        <div id="result" style="display:none;">
             <table class="table table-striped" width="100%">
                <thead>
                    <tr class="info">
                        <td colspan="6" > Informaci&oacute;n de Pacientes</td>
                        <td colspan="4"> Total Resultados <span class="badge" id="nresultados"></span></td>
                    </tr>
                </thead>
                <thead class="thead-inverse">
                     <tr class="info">
                        <td width="1%"   >N&deg;</td>
                        <td width="15%"  >Run/ID Fonasa</td>
                        <td width="10%"  >DNI/Pasaporte</td>
                        <td width="8%"   >F.Local</td>
                        <td width="15%"  >Nombres</td>
                        <td width="15%"  >Apellido Paterno</td>
                        <td width="15%"  >Apellido Materno</td>
                        <td width="9%"   >Nacimiento</td>
                        <td width="5%"   >PAIS</td>
                        <td width="7%"   style="width: 10%;text-align: center">Opci&oacute;n</td>
                    </tr>
                </thead>    
                <tbody id="resultados"></tbody>
            </table>
            <div class="row">
                <div class="col-12">
                    <center>
                        <div style="text-align:center;" align="center">  
                            <div id="new_paginacion" style="display: none;"></div>
                        </div>
                    </center>
                </div>
            </div>
        </div>

        <input type="hidden" id="indTemplateNum" name="indTemplateNum" value="3"/>
        
        <input type="hidden" id="paginacion" name="paginacion" value="0"/>

        
        ';

        $script2  = ' 
        
        <script type="text/javascript">
            
            $("#rut").Rut({
                on_error    : function(){ jAlert("El Rut ingresado es Incorrecto. ", "Rut Incorrecto"); $("#rut").css("border-color","red"); $("#rut").val("") },
                on_success  : function(){ $("#rut").css("border-color","red");},
                format_on   : "keyup"
            });
         
            function paginacion(){
                $("#new_paginacion").on("click","li",function (){
                    if(!isNaN($(this).text())){ buscar(1,$(this).text()); }
                });
            }
            
            function buscar(OP,LIM_INI){
               
                if($("#paginacion").val()== 0){ paginacion(); $("#paginacion").val(1) }

                $("#resultados").html(\'\');
                $("#resultados").append(\'<tr id="msj_load"><td style="text-align:center" colspan="11"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><b>BUSCANDO...</b></td></tr>\');
                $("#rut").css("border-color","");
                $("#dni").css("border-color","");
                $("#name").css("border-color","");
                $("#apellidoP").css("border-color","");
                $("#apellidoM").css("border-color","");
                
                var rut_array   = $("#rut").val().split("-");
                var rut2        = rut_array[0].replace(".","");
                var rut         = rut2.replace(".","");
                var dv          = rut_array[1];
                
                var pasaporte   = $("#dni").val();
                var nombre      = $("#name").val();
                var apellidoP   = $("#apellidoP").val();
                var apellidoM   = $("#apellidoM").val();
                var tipoPac     = $("input:radio[name=tipPac]:checked").val();
                var tipoEx      = $("#tipoEx").val();
                var numxpag     = 10;

                var valida      = 0;
                if ((rut!= \'\' || nombre != \'\' || apellidoP != \'\' || apellidoM != \'\') && (tipoPac == 0)) {
                    valida      = 1;
                } else if ((rut != \'\' || pasaporte != \'\' || nombre != \'\' || apellidoP != \'\' || apellidoM != \'\') && (tipoPac == 1)){
                    valida      = 1;
                }

                if (valida == 0){
                    jError("Debe Ingresar a lo menos un parametro para la busqueda", "Restricci\u00f3n");
                    $("#rut").css("border-color","red");
                    $("#dni").css("border-color","red");
                    $("#name").css("border-color","red");
                    $("#apellidoP").css("border-color","red");
                    $("#apellidoM").css("border-color","red");
                    $("#resultados").html(\'\');
                    $("#result").hide();
                    document.getElementById("btn_buscageneral").disabled = false;
                } else {
                    $("#icoSe").hide();
                    $("#respuesta").hide();
                    $("#icoLoa").css("display","inline-block");
                    $("#txBusc").html("Buscando");
                    $.ajax({ 
                        type            : "POST",
                        url             : "ssan_bdu_creareditarpaciente/buscarPac",
                        dataType        : "json",
                        data            : 
                                            { 
                                                numFichae   : \'\',
                                                rut         : rut,
                                                tipoEx      : tipoEx,
                                                tipoPac     : tipoPac,
                                                pasaporte   : pasaporte,
                                                nombre      : nombre,
                                                apellidoP   : apellidoP,
                                                apellidoM   : apellidoM,
                                                LIM_INI     : LIM_INI,
                                                numxpag     : numxpag,
                                                OP          : OP,
                                                templete    : $("#indTemplateNum").val(),
                                            },
                        error           : function(errro){  console.log(errro.responseText); console.log(errro); $("#resultados").html(""); document.getElementById("btn_buscageneral").disabled = false; jAlert("Error General, Consulte Al Administrador"); },
                        success         : function(aData){ $("#resultados").html(""); document.getElementById("btn_buscageneral").disabled = false; AjaxExtJsonAll(aData); }, 
                    });
                    $("#resultados").html("");
                }
            }
        </script>  
        ';

        $TABLA[]            =   array("id_html" => "HTML_BUSQUEDAPAC", "opcion" => "append", "contenido" => $html);
        $TABLA[]            =   array("id_html" => "HTML_BUSQUEDAPAC", "opcion" => "append", "contenido" => $script2);

        $this->output->set_output(json_encode($TABLA));
    }



    //*************** 10.02.2020 *********************************************** 
    public function apipercapita()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $codEmpresa            =   $this->session->userdata("COD_ESTAB");
        $html                =    '';
        $aDatos[]            =   array("id_html" => "", "opcion" => "console",    "contenido"  => "----------------apipercapita->----$codEmpresa-------------------");
        $txtRuttit            =    explode("-", $this->input->post("rutPac"));
        $aDatos[]            =   array("id_html" => "", "opcion" => "console",    "contenido"  => $txtRuttit);
        $this->load->library('api_minsal');
        $urlApi                =   'https://apiqa.minsal.cl/v1/fonasa/percapita?';
        $data                =   array('runPersona' => $txtRuttit[0], 'dvPersona' => $txtRuttit[1]);
        //$data			    =   array('runPersona' => 16869726, 'dvPersona' => 0); 
        //$data			    =	array('runPersona' => 5478917,  'dvPersona' => 3);
        $return                =   $this->api_minsal->getRecurso($data, $urlApi);
        $aDatos[]            =   array("id_html" => "", "opcion" => "console",    "contenido"  => "---------------------------");
        $aDatos[]            =   array("id_html" => "", "opcion" => "console",    "contenido"  => $data);
        $aDatos[]            =   array("id_html" => "", "opcion" => "console",    "contenido"  => $return);
        if ($return['status']) {
            $arr_aData            =    $return['data']->resultado;
            $aDatos[]            =   array("id_html" => "", "opcion" => "console",    "contenido"  => "---------------------------");
            $aDatos[]            =   array("id_html" => "", "opcion" => "console",    "contenido"  => $arr_aData->codigoMensaje);
            if ($arr_aData->codigoMensaje == 1) {
                $dataC            =    $return['data']->resultado->InscripcionPercapita->InformacionInscripcion;
                $info            =    $dataC[0];
                //$aDatos[]	    =   array("id_html" => "", "opcion" => "console",    "contenido"  => "---------------------------");
                //$aDatos[]	    =   array("id_html" => "", "opcion" => "console",    "contenido"  => $info);
                $html            =    '   <table class="table table-striped">
						<tbody>
						    <tr>
							<td style="width:25%;"><b>RUN</b></td>
							<td style="width:25%;">' . $info->runBenePer . '-' . $info->dvBenePer . '</td>
							<td style="width:25%;"><b>FECHA INSCRIPCI&Oacute;N</b></td>
							<td style="width:25%;">' . $info->fechaInscripcion . '</td>
						    </tr>
						    <tr>
							<td><b>CODIGO CENTRO ATENCI&Oacute;N</b></td>
							<td>' . $info->codigoCentroAtencion . '</td>
							<td><b>NOMBRE CENTRO DE ATENCI&Oacute;N</b></td>
							<td>' . $info->codigoCentroAtencion . '</td>
						    </tr>
						    <tr>
							<td><b>NOMBRE COMUNA</b></td>
							<td>' . $info->nombreComuna . '</td>
							<td><b>C&Oacute;DIGO COMUNA</b></td>
							<td>' . $info->codigoComuna . '</td>
						    </tr>
						    <tr>
							<td><b>NOMBRE PROVINCIA</b></td>
							<td>' . $info->nombreProvincia . '</td>
							<td><b>C&Oacute;DIGO PROVINCIA</b></td>
							<td>' . $info->codigoProvincia . '</td>
						    </tr>
						    <tr>
							<td><b>NOMBRE REGI&OacuteN</b></td>
							<td>' . $info->nombreRegion . '</td>
							<td><b>C&Oacute;DIGO REGI&OacuteN</b></td>
							<td>' . $info->codigoRegion . '</td>
						    </tr
						    <tr>
							<td><b>NOMBRE SERVICIO DE SALUD</b></td>
							<td>' . $info->nombreServicioSalud . '</td>
							<td><b>C&Oacute;DIGO SERVICIO DE SALUD</b></td>
							<td>' . $info->codigoServicioSalud . '</td>
						    </tr>
						</tbody>
					    </table>
					    ';

                $aDatos[]            =   array("id_html" => "modal_percapita",    "opcion" => "modalShow",    "contenido"        =>    "");
                //$aDatos[]		    =   array("id_html" => "",			"opcion" => "console",	    "contenido"	    =>	$html);
                $aDatos[]            =   array("id_html" => "HTML_PERCAPITA",    "opcion" => "html",        "contenido"        =>    $html);
            } else {
                $aDatos[]            =   array("id_html" => "",            "opcion" => "console",        "contenido"        =>    "-------------");
                $aDatos[]            =   array("id_html" => "",            "opcion" => "console",        "contenido"        =>    $arr_aData);
                $aDatos[]            =   array("id_html" => "",            "opcion" => "jAlert",        "contenido"        =>    $arr_aData->mensaje);
            }
        } else {
            $aDatos[]                =   array("id_html" => "",            "opcion" => "jAlert",        "contenido"        =>    "Sin informaci&oacute;n de percapita");
            $aDatos[]                =   array("id_html" => "",            "opcion" => "modalShow",    "contenido"        =>    "");
        }
        $this->output->set_output(json_encode($aDatos));
    }
    //*************** 10.02.2020 *********************************************** 
}
