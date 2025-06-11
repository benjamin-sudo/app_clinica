<!-- EDICION DE MUESTRAS -->
<?php if($CALL_FROM==5 || $CALL_FROM==1){  ?>
    <script src="assets/ssan_libro_biopsias_usuarioext/js/anatomia_patologica.js" type="text/javascript"></script>
    <!--<link rel="stylesheet" href="assets/ssan_libro_biopsias_usuarioext/css/styles_gespab.css"/>-->
<?php   }   else    { ?>

<?php   }   ?>

<div id="data_get" data-get="<?php echo htmlspecialchars(json_encode(isset($ARRAY_GET)?$ARRAY_GET:[]),ENT_QUOTES,'UTF-8');?>"></div>
<div id="data_bd" data-bd="<?php echo htmlspecialchars(json_encode($ARRAY_BD),ENT_QUOTES,'UTF-8');?>"></div>
<div id="data_autocomplete" data-autocomplete="<?php echo htmlspecialchars(json_encode($ARRAY_AUTOCOMPLETE),ENT_QUOTES,'UTF-8');?>"></div>
<div id="tabla_biopsia"></div>
<div id="HTML_ANATOMIA_PATOLOGICA"></div>
<div id="DIV_FORMULARIO_ANATOMIAPATOLOGICA_EXT">

    <?php
        #**************************************************************************
        #FROM_APATOLOGICA_EXT 
        #leyenda
        #LEGEND =   0   
        #$CALL_FROM = 1 #LLAMADA EXTERNA | RCE + ADMISION
        #$CALL_FROM = 2 #LLAMA DESDE GESPAB - MODULO TNS - CENTRAL O MENOR - ETIQUETADO
        #$CALL_FROM = 5 #LLAMA DESDE GESPAB - PROTOCOLOS DE INS - PRV - URG - CX-MENOR
        #TEMPLATE_PA_ID_PROCARCH
        #PA_ID_PROCARCH = 36   #ERROR - SISTEMA DE VALORADAS
        #29-09-2021 = #NOTIFICACION CANCER 
        #07-09-2021
        #**************************************************************************         
    ?>
    <style>
        .PANEL_FORMULARIO_MAIN {
            display : grid;
            grid-template-columns : 60% 40%;
            grid-column-gap : 5px;
            justify-items : stretch;
            align-items : center;
            margin-bottom : 50px;
            margin-top : 10px;
        }
        .PANEL_MAIN {
            display : grid;
            grid-template-columns : 70% 30%;
            grid-column-gap : 5px;
            grid-row-gap : 20px;
            margin-top : 0px;
            margin-bottom : 0px;
        }
        .PANEL_PRINCIPAL {
            display : grid;
            grid-template-columns : 99% 1%;
            grid-column-gap : 5px;
            grid-row-gap : 20px;
            margin-top : 0px;
            margin-bottom : 0px;
        }
    </style>
    
    <!-- AUTOCOMPLETE -->
    
    <!-- LEGEND -->
    <input type="hidden"      id="TEMPLATE_NUMFICHAE"                   name="TEMPLATE_NUMFICHAE"                       value="<?php echo $NUM_FICHAE;?>"/>
    <input type="hidden"      id="TEMPLATE_RUTPAC"                      name="TEMPLATE_RUTPAC"                          value="<?php echo $RUT_PACIENTE;?>"/>
    <input type="hidden"      id="TEMPLATE_ID_PROFESIONAL"              name="TEMPLATE_ID_PROFESIONAL"                  value="<?php echo $ID_MEDICO;?>"/>
    <input type="hidden"      id="TEMPLATE_RUT_PROFESIONAL"             name="TEMPLATE_RUT_PROFESIONAL"                 value="<?php echo $RUT_MEDICO;?>"/>
    <input type="hidden"      id="TEMPLATE_IND_TIPO_BIOPSIA"            name="TEMPLATE_IND_TIPO_BIOPSIA"                value="<?php echo $IND_TIPO_BIOPSIA;?>"/>
    <input type="hidden"      id="TEMPLATE_IND_ESPECIALIDAD"            name="TEMPLATE_IND_ESPECIALIDAD"                value="<?php echo $IND_ESPECIALIDAD;?>"/>
    <!-- LEGEND INFO  -->
    <input type="hidden"      id="TEMPLATE_DATE_SOLICITUD"              name="TEMPLATE_DATE_SOLICITUD"                  value="<?php echo date("d-m-Y");?>"/>
    <input type="hidden"      id="TEMPLATE_HRS_SOLICITUD"               name="TEMPLATE_HRS_SOLICITUD"                   value="<?php echo date("H:i");?>"/>
    <input type="hidden"      id="TEMPLATE_CALL_FROM"                   name="TEMPLATE_CALL_FROM"                       value="<?php echo $CALL_FROM;?>"/>
    <input type="hidden"      id="TEMPLATE_EMPRESA"                     name="TEMPLATE_EMPRESA"                         value="<?php echo $COD_ESTAB;?>"/>
    <!-- NUMERO DE DOCUMENTO ASOCIADO -->
    <input type="hidden"      id="TEMPLATE_PA_ID_PROCARCH"              name="TEMPLATE_PA_ID_PROCARCH"                  value="<?php echo $PA_ID_PROCARCH;?>"/>
    <input type="hidden"      id="TEMPLATE_AD_ID_ADMISION"              name="TEMPLATE_AD_ID_ADMISION"                  value="<?php echo $AD_ID_ADMISION;?>"/>
    <input type="hidden"      id="ID_GESPAB"                            name="ID_GESPAB"                                value="<?php echo isset($ID_GESPAB)?$ID_GESPAB:'';?>"/>
    <input type="hidden"      id="IND_IFRAME"                           name="IND_IFRAME"                               value="<?php echo $IND_FRAME;?>"/>
    <input type="hidden"      id="DATE_SISTEMA"                         name="DATE_SISTEMA"                             value="<?php echo date("d-m-Y h:m")?>"/>

    <div class="card contenedor_form" style="margin-top: 12px; width:100%; min-height:<?php echo $CALL_FROM==1 ? '770px' : '600px'; ?>; padding:<?php echo $CALL_FROM==2 ? '0px' : '4px'; ?> 4px 4px 4px;" id="TABS_ANATOMIA_PATOLOGICA" >
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="TABS_MAIN_ANATOMIA-tab" data-bs-toggle="tab" data-bs-target="#TABS_MAIN_ANATOMIA" type="button" role="tab" aria-controls="TABS_MAIN_ANATOMIA" aria-selected="true">&nbsp;FORMULARIO</button>
            </li>
            <?php
                if  (    
                    $IND_TIPO_BIOPSIA   ==  '2'     //CONTEMPORANEA
                ||  $IND_TIPO_BIOPSIA   ==  '3'     //DIFERIDA
                ||  $IND_TIPO_BIOPSIA   ==  '4'     //BIOPSIA + CITOLOGÍA
                ||  $IND_TIPO_BIOPSIA   ==  '6'     //PAP
                ){
            ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="TABS_ETIQUETAS_ANATOMIA-tab" data-bs-toggle="tab" data-bs-target="#TABS_ETIQUETAS_ANATOMIA" type="button" role="tab" aria-controls="TABS_ETIQUETAS_ANATOMIA" aria-selected="false">MUESTRAS ANATOMIA</button>
            </li>
            <?php } 
            if  (
                        $IND_TIPO_BIOPSIA   ==  '4'     //BIOPSIA + CITOLOGOA
                    ||  $IND_TIPO_BIOPSIA   ==  '5'     //CITOLOGIA
                ){
            ?>  
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="TABS_ETIQUETAS_CITOLOGIA-tab" data-bs-toggle="tab" data-bs-target="#TABS_ETIQUETAS_CITOLOGIA" type="button" role="tab" aria-controls="TABS_ETIQUETAS_CITOLOGIA" aria-selected="false">MUESTRAS CITOLOG&Iacute;A</button>
            </li>
            <?php } ?>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="TABS_MAIN_ANATOMIA" role="tabpanel" aria-labelledby="TABS_MAIN_ANATOMIA-tab">
                <div class="PANEL_FORMULARIO_MAIN">
                    <div class="PANEL_FORMULARIO_MAIN1">
                        <h5 class="title" style="color:#e34f49;margin-left:18px;">
                            <b>EXAMEN HISTOPATOL&Oacute;GICO</b>
                            <p class="category"><?php echo $TXT_TIPO_BIOPSIA;?> <b>|</b> <?php echo $IND_TIPO_BIOPSIA;?></p>
                        </h5>
                    </div>
                    <div class="PANEL_FORMULARIO_MAIN2">
                        <?php if ($IND_FRAME == 1) {
                            echo "N&deg; DE ADMISI&Oacute;N&nbsp;:&nbsp;".$AD_ID_ADMISION;
                            echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'])?"<br> N&deg; DE SOLICITUD ".$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD']:"";  
                            echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_HISTO_ESTADO'])?"<br> ESTADO : ".$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_HISTO_ESTADO']."|".$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_HISTO_ESTADO']:"";  
                        } else { ?>
                            <?php if ($CALL_FROM == 5 || $CALL_FROM == 0 ){ ?>
                                <div style="display: none" id="last_name">
                                    <b>LLAMADA DESDE GESPAB - PROTOCOLO INSTITUCIONAL</b>
                                </div>
                            <?php } else {  ?>
                                <div id="date_tabla2" class="input-group center-block">
                                    <span class="input-group-addon"><b>INFORMACI&Oacute;N POSTERIOR</b></span>
                                    <span class="input-group-addon" >
                                        <input type="checkbox" class="form-check-input" id="form_pospuesto" onchange="js_from_ap_pospuesto(this.id)" value="1" style="display:inline-block;cursor:pointer;">
                                    </span>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                    
                <form id="formulario_histo" name="formulario_histo" >
                    <table class="table table-striped" style="width:100%;margin-bottom:3px;margin-top:-33px;">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <label class="control-label">&nbsp;PUNTO DE ENTREGA&nbsp;<star>*</star></label>
                                    <select id="ind_zona" name="ind_zona" class="form-control input-sm">
                                        <?php
                                            if($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_ROTULADO']!=''){
                                                echo '<option value="'.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_ROTULADO'].'">'.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_ROTULO'].'</option>';
                                            }
                                            if(count($ARRAY_ROTULADO)>0){
                                                foreach ($ARRAY_ROTULADO as $i => $puntos){
                                                    echo '<option value="'.$puntos["value"].'">'.$puntos["name"].'</option>';
                                                }
                                            } else {
                                                echo '<option value="0">SIN ASIGNAR</option>';
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <?php if (count($ARRAY_BD['C_DATA_ROTULADO_SUB'])>0){ ?>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label">&nbsp;SUB DIVISI&Oacute;N&nbsp;<star>*</star></label>
                                        <select id="sub_ind_zona" name="sub_ind_zona" class="form-control input-sm">
                                        <?php foreach($ARRAY_BD['C_DATA_ROTULADO_SUB'] as $i => $row){
                                                echo '<option value="'.$row["ID_ROTULADO_SUB"].'">'.$row["TXT_OBSERVACION"].'</option>';
                                        } ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php } else {?>
                                <select id="sub_ind_zona" name="sub_ind_zona" class="form-control input-sm" style="display:none"></select>
                            <?php } ?>

                            
                            <?php if($CALL_FROM!=5){?>
                            <tr>
                                <td colspan="2">
                                    <div class="td_1">
                                        <label class="control-label">&nbsp;DIAGN&Oacute;STICO CL&Iacute;NICO&nbsp;<star>*</star></label>
                                        <input type="text" class="form-control input-sm" name="TXT_DIAGNOSTICO" id="TXT_DIAGNOSTICO" size="459" maxlength="459" 
                                                value="<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIAGNOSTICO'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIAGNOSTICO']:'';?>">
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                            
                            
                            
                            <tr>
                                <td colspan="2">
                                    <div class="td_2">
                                        <label class="control-label">&nbsp;SITIO DE EXTRACCI&Oacute;N&nbsp;&nbsp;-&nbsp;(TIPO DE MUESTRA)<star>*</star></label>
                                        <input type="text" class="form-control input-sm" name="bio_extraInput" id="bio_extraInput" size="60" maxlength="200" 
                                                value="<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_SITIOEXT'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_SITIOEXT']:'';?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="td_3">
                                        <label class="control-label">&nbsp;UBICACI&Oacute;N&nbsp;&nbsp;<star>*</star></label>
                                        <input type="text" class="form-control input-sm" name="bio_ubicaInput" id="bio_ubicaInput" size="60" 
                                                value="<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_UBICACION'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_UBICACION']:'';?>"><!--  DES_UBICACION -->
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="td_3">
                                        <label class="control-label">&nbsp;TAMA&Ntilde;O&nbsp;&nbsp;<star>*</star></label>
                                        <input type="text" class="form-control input-sm" name="bio_tamannoInput"  id="bio_tamannoInput" size="60" maxlength="200" 
                                                value="<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_TAMANNO'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_TAMANNO']:'';?>"> <!--  DES_TAMANNO -->
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <div class="td_4">
                                        <label class="control-label">&nbsp;TIPO DE LESI&Oacute;N:&nbsp;<star>*</star></label>
                                        <select class="form-control input-sm" name="bio_lesionSelect" id="bio_lesionSelect">
                                            <option value="">SELECCIONE...</option>
                                            <option value="1" >LIQUIDO</option>
                                            <option value="2" >&Oacute;RGANO</option>
                                            <option value="3" >TEJIDO</option>
                                        </select>
                                    </div>
                                </td>
                                <td width="50%">
                                    <div class="td_5">
                                        <label class="control-label">&nbsp;ASPECTO:&nbsp;<star>*</star></label>
                                        <select class="form-control input-sm" name="bio_aspectoSelect" id="bio_aspectoSelect">
                                            <option value="">SELECCIONE...</option>
                                            <option value="1" >INFLAMATORIA</option>
                                            <option value="2" >BENIGNA</option>
                                            <option value="3" >NEOPL&Aacute;SICA</option>
                                        </select>
                                    </div>
                                </td>
                            </td>    
                            <tr>
                                <td colspan="2">
                                    <div class="td_6">
                                        <label class="control-label">&nbsp;ANT. PREVIOS&nbsp;<star>*</star></label>
                                        <select class="form-control input-sm" name="bio_ant_previosSelect" id="bio_ant_previosSelect">
                                            <option value="">SELECCIONE...</option>
                                            <option value="1"  >NO</option>
                                            <option value="2"  >BIOPSIA </option>
                                            <option value="3"  >CITOLOG&Iacute;A</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="td_7">
                                        <label class="control-label">&nbsp;DESC. BIOPSIA&nbsp;</label>
                                        <input type="text" class="form-control input-sm" name="bio_des_BiopsiaInput" id="bio_des_BiopsiaInput" size="60" maxlength="200" 
                                                value="<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_BIPSIA'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_BIPSIA']:'';?>"> <!-- DES_BIPSIA -->
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="td_8">
                                        <label class="control-label">&nbsp;DESC. CITOLOG&Iacute;A&nbsp;</label>
                                        <input type="text" class="form-control input-sm" name="bio_des_CitologiaInput"  id="bio_des_CitologiaInput" size="60" maxlength="200" 
                                                value="<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_CITOLOGIA'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_CITOLOGIA']:'';?>"> <!-- DES_CITOLOGIA -->
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="td_9">
                                        <label class="control-label">&nbsp;OBSERVACIONES&nbsp;</label>
                                        <!-- width:517px;-->
                                        <textarea class="form-control input-sm" id="bio_observTextarea" name="bio_observTextarea" cols="4" rows="2" style="margin: 0px;  height: 91px;" 
                                                maxlength="500"><?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_OBSERVACIONES'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['DES_OBSERVACIONES']:'';?></textarea> <!-- DES_OBSERVACIONES -->
                                    </div>
                                </td>
                            </tr>
                            
                            <tr style="display:none">
                                <td colspan="2">
                                    <div class="td_2">
                                        <label class="control-label">&nbsp;NOTIFICACI&Oacute;N CANCER&nbsp;<star>*</star></label>
                                        <select class="form-control input-sm" name="slc_ind_cancer" id="slc_ind_cancer">
                                            <option value="0" >NO</option>
                                            <option value="1" >SI</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>  
                </form>

                <script>
                    $("#slc_ind_cancer").val('<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_NOTIF_CANCER'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_NOTIF_CANCER']:'0';?>');//NOTIFICACION CANCER
                    $("#bio_lesionSelect").val('<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_TIPO_LESION'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_TIPO_LESION']:'';?>');//ID_TIPO_LESION
                    $("#bio_aspectoSelect").val('<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_ASPECTO'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_ASPECTO']:'';?>');//ID_ASPECTO
                    $("#bio_ant_previosSelect").val('<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_ANT_PREVIOS'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_ANT_PREVIOS']:'';?>');//ID_ANT_PREVIOS
                    $("#IND_PLANTILLA_ANATOMIA").val('<?php echo isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_PLANTILLA'])?$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_PLANTILLA']:'0';?>');//NUM_PLANTILLA
                </script>
            </div>
            
            <?php if($IND_TIPO_BIOPSIA == '2' || $IND_TIPO_BIOPSIA == '3'  || $IND_TIPO_BIOPSIA == '4' || $IND_TIPO_BIOPSIA == '6' ){ ?>    
                <div class="tab-pane fade" id="TABS_ETIQUETAS_ANATOMIA" role="tabpanel" aria-labelledby="TABS_ETIQUETAS_ANATOMIA-tab">

                    <table class="table table-borderless" style="width:100%;margin-bottom:0px;">
                        <thead>
                            <tr>
                                <td style="width: 50%;height: 50px;">
                                    <?php echo $IND_TIPO_BIOPSIA   ==  '6' ? '<b>N&deg; DE LAMINAS:</b>' : '<b>N&deg; DE MUESTRAS:</b>'; ?>
                                </td>
                                <td style="width: 50%">
                                    <select class="form-control input-sm" name="bio_ant_nMuestasSelect" id="bio_ant_nMuestasSelect" onchange="js_htmlnummuestra(this.id,this.value)">
                                        <option value="1" selected="">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                    </select>
                                </td>
                            </tr>
                            <tr style="height:50px;<?php echo $IND_TIPO_BIOPSIA=='6'?'display:none;':'';?>">
                                <td><b>PLANTILLA:</b></td>
                                <td>
                                    <select style="width:300px;" class="form-control input-sm" name="IND_PLANTILLA_ANATOMIA" id="IND_PLANTILLA_ANATOMIA" onchange="PLANTILLA_MANATOMIA(this.id,this.value)">
                                        <option value="0">DEFAULT</option>
                                        <option value="1">PROTOCOLO SYDNEY</option>
                                        <option value="2">ESTUDIO SERIADO COLON</option>
                                    </select>
                                </td> 
                            </tr>
                            <tr style="height:63px;<?php echo $IND_TIPO_BIOPSIA=='6'?'display:none;':'';?>">
                                <td><b>CASETE</b><td>
                                    <input type="checkbox" class="form-check-input" id="AP_USO_CASSETE" style="cursor:pointer;" onchange="js_usocassete(this.id)" value="1"/>
                                    <script>$("#AP_USO_CASSETE").show();</script>
                                </td>
                            </tr>   
                        </thead>
                    </table>
                    
                    <hr style="margin: 0px">
                    
                    <form id="form_anatomia_nmuestras" name="form_anatomia_nmuestras">
                        <table class="table table-striped" style="width:100%;margin-bottom:0px;margin-top:-2px;">
                            <thead>
                                <tr id="head_nbipsia" style="height: 40px;">
                                    <th style="width:5%; text-align:center; height:30px;"><b>N&deg;</b></th>
                                    <th style="width:50%; text-align:center;"><b>TIPO DE MUESTRA</b></th>
                                    <th style="width:30%; text-align:center;"><b>ETIQUETA</b></th>
                                    <th style="width:5%; text-align:center;display:none" class="row_cassete"><b>N&deg; C</b></th>
                                    <th style="width:5%; text-align:center;"><i class="fa fa-cog" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody id="TBODY_NUM_MUESTRAS"></tbody>
                        </table>
                    </form>

                    <?php if(empty($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"])){ ?>        
                        <script>
                            //$("#tabla_biopsia").data({arr_muestra:[],arr_citologia:[]});
                            document.getElementById("AP_USO_CASSETE").checked = false;
                            document.getElementById("AP_USO_CASSETE").disabled = true;
                            js_htmlnummuestra("bio_ant_nMuestasSelect",1);
                        </script>
                    <?php  } else {  ?>  
                        <?php 
                            $arr = array();
                            $aux_anatomia = 0;
                            foreach($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ ?>
                                <?php  
                                $arr[] = array(
                                    "ID_NMUESTRA" =>  $row["ID_NMUESTRA"],
                                    "N_MUESTRA" =>  $row["N_MUESTRA"],
                                    "TXT_MUESTRA" =>  $row["TXT_MUESTRA"],
                                    "IND_ETIQUETA" =>  $row["IND_ETIQUETA"],
                                    "NUM_CASSETTE" =>  $row["NUM_CASSETTE"],
                                    "DATA" =>  $row,
                                );
                                $aux_anatomia++;
                            } ?>
                        <script>
                            $("#tabla_biopsia").data({arr_muestra:<?php echo json_encode($arr);?>,arr_citologia:[]});
                            $("#bio_ant_nMuestasSelect").val(<?php echo $aux_anatomia;?>);
                            js_htmlnummuestra('',<?php echo $aux_anatomia;?>);
                        </script>
                        <?php if($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_USOCASSETTE'] == 1){  ?>
                            <script>
                                document.getElementById("AP_USO_CASSETE").checked = true;
                                js_usocassete("AP_USO_CASSETE");
                            </script>
                        <?php } else { ?>
                            <?php if($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"][0]["IND_ETIQUETA"] ==  2){ ?>
                                <script>
                                    document.getElementById("AP_USO_CASSETE").checked = false;
                                    document.getElementById("AP_USO_CASSETE").disabled = true; 
                                </script>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>


                </div>
            <?php } ?>

            <?php  if ($IND_TIPO_BIOPSIA == '4' || $IND_TIPO_BIOPSIA == '5'){ ?>
                <div class="tab-pane fade" id="TABS_ETIQUETAS_CITOLOGIA" role="tabpanel" aria-labelledby="TABS_ETIQUETAS_CITOLOGIA-tab">
                 
                    <table class="table table-borderless" style="width:100%;margin-bottom:0px;">
                        <thead>
                            <tr>
                                <td style="width:50%"><b>N&deg; DE MUESTRAS:</b></td>
                                <td style="width:50%">
                                    <select  class="form-control input-sm" name="bio_ant_nCitologia" id="bio_ant_nCitologia" onchange="ap_js_htmlcitologia(this.id,this.value)"> 
                                        <option value="1" selected="">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                    </select>
                                </td>  
                            </tr>    
                        <thead>
                    </table>       
                    <form id="form_muestras_citologia" name="form_muestras_citologia">
                        <table class="table table-striped" style="width:100%;margin-bottom:0px;">
                            <thead>
                                <tr id="head_nbipsia2" style="height: 40px;">
                                    <th width="10%" style="height:30px;text-align:center;"><b>N&deg</b></th>
                                    <th width="40%" style="text-align:center;"><b>OBSERVACI&Oacute;N</b></th>
                                    <th width="10%" style="text-align:center;"><b>ML</b></th>
                                    <th width="30%" style="text-align:center;"><b>EQUIQUETA</b></th>
                                    <th width="10%" style="text-align:center;"><i class="fa fa-cog" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody id="TBODY_MUESTRAS_CITOLOGIA"> </tbody>
                        </table>
                    </form>

                    <?php if(count($DATA["P_AP_MUESTRAS_CITOLOGIA"])>0){ 
                        $cit =   array();
                        $aux_citologia =   0;
                        foreach($DATA["P_AP_MUESTRAS_CITOLOGIA"] as $i => $row){ ?>
                            <?php  
                            $cit[] = array(
                                "NUM_MUESTRA" => $row["N_MUESTRA"],
                                "TXT_OBSERVACION" => $row["TXT_MUESTRA"],
                                "IND_ETIQUETA" => $row["IND_ETIQUETA"],
                                "DATA" => $row,
                            );
                            $aux_citologia++;
                        } 
                        ?>
                        <script>
                            $("#tabla_biopsia").data({arr_muestra:[],arr_citologia:<?php echo json_encode($cit);?>});
                            $("#bio_ant_nCitologia").val(<?php echo $aux_citologia;?>);
                            ap_js_htmlcitologia('',<?php echo $aux_citologia;?>);
                        </script>
                    <?php } else { ?>
                        <script>
                            //$("#tabla_biopsia").data({arr_muestra:[],arr_citologia:[]});
                            //console.log("P_AP_MUESTRAS_CITOLOGIA -> null");
                            ap_js_htmlcitologia("bio_ant_nCitologia",1);
                        </script>
                    <?php } ?>

                </div>
            <?php } ?>
        </div>
    </div>
    <?php if ($CALL_FROM == 1 || $CALL_FROM == 2){ ?>   
        <style>
            #PANEL_FINAL {
                display : grid;
                grid-template-columns : 1fr;
                grid-column-gap : 5px;
                grid-row-gap : 20px;
                margin-top : 0px;
                margin-bottom : 0px;
            }
        </style>
        <div id="btn-back"></div>
        <div id="btn-finish"></div>
        <div id="PANEL_FINAL">
            <div class="DIV_2 text-center">
                <?php  if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'] == '' || $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_HISTO_ESTADO'] == '1' || $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_HISTO_ESTADO']=='2' ){ ?>
                    <button 
                        type = "button" 
                        id = "btn-finish" 
                        class = "btn btn-info btn-back  btn-fill btn-wd  pull-center" 
                        onclick = "JS_GUARDAANATOMIA_EXTERNO(<?php echo $CALL_FROM;?>)" 
                        style = "display:inline-block;">
                     <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                     <?php if ($CALL_FROM     ==  1){
                         echo "ENVIAR SOLICITUD ANATOM&Iacute;A PATOL&Oacute;GICA";
                     } else if ($CALL_FROM    ==  2){//GESPAB
                         echo "A&Ntilde;ADIR SOLICITUD DE ANATOM&Iacute;A PATOL&Oacute;GICA A CIRUG&Iacute;A <b>N&deg;:".$ID_GESPAB."</b>";
                     } else {
                         echo "ENVIAR SOLICITUD ANATOM&Iacute;A PATOL&Oacute;GICA";
                     } ?>
                    </button>
                <?php }  ?>
                <?php  if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'] != ''){ ?>
                    <button 
                        type = "button" 
                        id = "btn-finish" 
                        class = "btn btn-danger btn-back  btn-fill btn-wd  pull-center" 
                        onclick = "GET_PDF_ANATOMIA(<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?>);hide_from();"> PDF</button>
                    
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <!--
            <?php echo "LLAMADA DESDE GESPAB ->".$CALL_FROM; ?>
        -->
    <?php } ?>

    <?php if (isset($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_INFOPOST'])) { ?>
        <?php if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_INFOPOST'] == 1){ ?>
            <script>
                $("#form_pospuesto").prop("checked",true);  
                js_from_ap_pospuesto("form_pospuesto");
            </script>
        <?php } ?>
    <?php } ?>
</div>

<div id="HTML_SOLICITUD_ANATOMIA"></div>

<script>
    $(document).ready(function(){
        //console.log("me gusta los problemas ");
        $(".btn_envia_form").prop('disabled', false);
        document.getElementById("AP_USO_CASSETE").checked = false;
        document.getElementById("AP_USO_CASSETE").disabled = false;
    });

    function hide_from(){
        $("#DIV_FORMULARIO_ANATOMIAPATOLOGICA_EXT").hide();
    }
    
    function star_form_anatomia(){
        var IND_TIPO_BIOPSIA = <?php echo $IND_TIPO_BIOPSIA;?>;
        /*
        console.log("------------data_bd------------------------------------------------------------------------");
        console.log("               ->",$("#data_bd").data('bd'),"<-                                            ");
        console.log("-------------------------------------------------------------------------------------------");
        console.log("   IND_TIPO_BIOPSIA                ->  ",IND_TIPO_BIOPSIA); 
        console.log("   P_ANATOMIA_PATOLOGICA_MAIN      ->  ",$("#data_bd").data('bd').P_ANATOMIA_PATOLOGICA_MAIN); 
        console.log("   P_ANATOMIA_PATOLOGICA_MUESTRAS  ->  ",$("#data_bd").data('bd').P_ANATOMIA_PATOLOGICA_MUESTRAS); 
        console.log("   P_AP_MUESTRAS_CITOLOGIA         ->  ",$("#data_bd").data('bd').P_AP_MUESTRAS_CITOLOGIA); 
        console.log("-------------------------------------------------------------------------------------------");
        */
        js_htmlnummuestra("bio_ant_nMuestasSelect",1);
        js_htmlnummuestra("bio_ant_nCitologia",1);
    }
</script>    