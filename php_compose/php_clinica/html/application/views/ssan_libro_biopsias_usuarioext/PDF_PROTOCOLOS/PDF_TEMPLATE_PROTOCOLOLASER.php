<?php
    $tablaop                            =   $DATA["ALL_CIRUGIAS"][0];
    $VAR_PROFESIONAL_ACARGO             =   '';
    //**************************************************************************
    //**************************** GESTOR HHRR EN LI LO ************************
    $PrimerCirujano                     =   '';
    $RUN_CIRUJANO                       =   '';
    $nomAnes                            =   'NO INFORMADO';
    $nomCitu2                           =   'NO INFORMADO';
    $nomCitu3                           =   'NO INFORMADO';
    $matrones                           =   '';
    $pediatras                          =   '';
    $enfermeros                         =   '';
    $tec_medico                         =   '';
    $auxiliar_anestesia                 =   '';
    $arsenalera                         =   '';
    $pabellonera                        =   '';
    $equipo_trabajo                     =   '';
    $TNS_PARTO                          =   '';
    $TNS_RNI                            =   '';
    $listaRRHH                          =   $DATA['ALL_RRHH'];	
    if (count($listaRRHH)>0){
        foreach($listaRRHH as $i => $hhrr) {
                if($hhrr['ID_FUNCION_PB']           ==  '0'){
                    if ($hhrr['ID_TIPO_RRHH']       ==  1) {
                        $PrimerCirujano             =   $hhrr['TXTNOMBRE'];
                        $RUN_CIRUJANO               =   $hhrr['RUT_COMPLETO'];
                        $VAR_PROFESIONAL_ACARGO     =   $hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE'];
                } else if ($hhrr['ID_TIPO_RRHH'] == 2){
                        $nomCitu2                   =   $hhrr['RUT_COMPLETO'].' /  &bsol;'.$hhrr['TXTNOMBRE'];
                } else if ($hhrr['ID_TIPO_RRHH'] == 3){
                    $nomCitu3                       =   $hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE'];
                } else if ($hhrr['ID_TIPO_RRHH'] == 4){
                    $nomAnes                        =   $hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE'];
                } else if ($hhrr['ID_TIPO_RRHH'] == 6){
                    $enfermeros                     .=  "<li>".$hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE']."</li>";
                } else if ($hhrr['ID_TIPO_RRHH'] == 7){
                    $matrones                       .=  "<li>".$hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE']."</li>";
                } else if ($hhrr['ID_TIPO_RRHH'] == 8){
                    $pediatras                      .=  "<li>".$hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE']."</li>";
                } else if ($hhrr['ID_TIPO_RRHH'] == 9){
                    $equipo_trabajo                 .=  "<li>".$hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE']."</li>";
                } else if ($hhrr['ID_TIPO_RRHH'] == 13){
                    $equipo_tecnologomed            .=  "<li>".$hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE']."</li>"; //NEW TECNOLOGO MEDICO
                } 
            } else {
                       if ($hhrr['ID_FUNCION_PB'] == 1) {
                    $auxiliar_anestesia             .=  "<li>".$hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE']."</li>";
                } else if ($hhrr['ID_FUNCION_PB'] == 2) {
                    $arsenalera                     .=  "<li>".$hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE']."</li>";
                } else if ($hhrr['ID_FUNCION_PB'] == 3) {
                    $pabellonera                    .=  "<li>".$hhrr['RUT_COMPLETO'].' / '.$hhrr['TXTNOMBRE']."</li>";
                }
            }
        }
    }
    
    //**************************************************************************
    if($tec_medico                          =='') {   $tec_medico           = "";   }       
    if($matrones                            =='') {   $matrones             = "";   }               
    if($pediatras                           =='') {   $pediatras            = "";   }     
    if($enfermeros                          =='') {   $enfermeros           = "";   }    
    if($auxiliar_anestesia                  =='') {   $auxiliar_anestesia   = "";   }     
    if($arsenalera                          =='') {   $arsenalera           = "";   }     
    if($pabellonera                         =='') {   $pabellonera          = "";   }  
    if($TNS_PARTO                           =='') {   $TNS_PARTO            = "";   }     
    if($TNS_RNI                             =='') {   $TNS_RNI              = "";   }
    //**************************************************************************
    //**************************** RECURSO HUMANO ******************************
    //**************************************************************************
    //**************************** ANESTESIA OFTAMOLOGIA ***********************
    //**************************************************************************
    $OFTA_ANEST                             =   $DATA["P_INFO_ANESTESIAOFTA"];
    $_LI_PANFOTOCOAGULACION                 =   '';
    $_LI_CAPSULOTOMIA                       =   '';
    if(count($OFTA_ANEST)>0){
        foreach($OFTA_ANEST as $i => $row){
            if($row['IND_TIPOTRATAMIENTO']  == 1){
                $_LI_PANFOTOCOAGULACION     .=  '<li>'.$row['TXT_ANESTESIA'].'</li>';
            } else {
                $_LI_CAPSULOTOMIA           .=  '<li>'.$row['TXT_ANESTESIA'].'</li>';
            }
        }
    } else {
        $_LI_PANFOTOCOAGULACION             =   '<li>SIN INFORMACI&Oacute;N</li>';
        $_LI_CAPSULOTOMIA                   =   '<li>SIN INFORMACI&Oacute;N</li>';
    }
    //**************************************************************************
    
    
     //************************************** LICITACION LE **************************************** 
    $val_licitacion_le                      =   $tablaop['ID_TIPO_OP']=='2'?'<br><b>LICITACI&Oacute;N LE</b>':'';
    //************************************** LICITACION LE **************************************** 
    
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>PROTOCOLO DE LASER</title>
        <meta charset="utf-8"></meta>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"></meta>
        <link href="<?php echo base_url();?>/assets/themes/inicio/css/boobtstrap.css" rel="stylesheet"></link>
        <style type="text/css">
            body,html               {
                margin              :   0;
                padding             :   0;
                height              :   100%;
            }
            .table th,.table td     {
                padding-top         :   1px;
                padding-bottom      :   1px;
                padding-right       :   2px;
                border-top          :   0px solid #dddddd;
            }
            .table                  {
                margin-bottom       :   2px;
            }
            div.container           {
                width               :   100%;
                border              :   1px solid gray;
            }
            .border                 {
                border-width        :   thin;
                border-spacing      :   2px;
                border-style        :   none;
                border-color        :   black;
            }
            .TD_TH                  {
                border              :   1px solid black;
            }
            .table_2                {
                border-collapse     :   collapse;
            }
            
            .table_2                {
                border-collapse     :   collapse;
            }
            .newstile tr:nth-child(even){
                background          :   #ECF1F1;
                color               :   #ffffff;
            }
        </style>
    
    </head>
    <body>
        <table class="table" style="border: none;" width="100%">
            <tr>
                <td width="5%" style="width:10%;text-align:center"> 
                    <img class="img-thumbnail" title="" alt="" style="width:100px;height:90px" src="data:image/jpeg;base64,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" /> 
                </td>
                <td width="1%" style="width:1%"></td>
                <td width="94%" style="width:89%;text-align:right">
                    <h4><?php echo $tablaop["TXT_HOSPITAL"]; ?> - PROTOCOLO LASER</h4>
                    <address>
                        NOMBRE PROTOCOLO :<b><?php echo $tablaop['DES_ESTADO'];?>&nbsp;(<?php echo $tablaop['ID_ESTADO_TQ'];?>)</b><br>
                        SERVICIO QUIR&Uacute;RGICO :<b><?php echo $tablaop['NOMBRE_SERVICIO'];?></b><br>    
                        TIPO DE CIRUG&Iacute;A :<b><?php echo $tablaop['TIPO_OP'];?></b><br>
                        FECHA DE IMPRESI&Oacute;N :<b><?php echo $tablaop["FEC_EMISION"];?></b><br>
                        N&deg; PROTOCOLO : <b><?php echo $tablaop['ID'];?></b>
                        <?php echo $val_licitacion_le;?>
                    </address>
                </td>
            </tr>
        </table>

        <table width="100%" class="table_2"> 
            <tr>
                 <!-- BARRA LATERAL IZQUIERDA -->    
                <td width="35%" valign="top">
                    
                    <!-- 1. INFO DEL PACIENTE -->
                    <table width="100%" style="margin-bottom: 8px">
                        <tr>
                            <td width="100%">
                                <ul>
                                    <h5><?php echo $tablaop['NOMBRE_COMPLETO'];?></h5>
                                    <li>&nbsp;R.U.N                 :   <b><?php echo $tablaop['RUTPACIENTE'];?></b></li>   
                                    <li>&nbsp;EDAD                  :   <b><?php echo $tablaop['EDAD'];?>&nbsp;A&Ntilde;OS</b></li>
                                    <li>&nbsp;PREVISI&Oacute;N      :   <b><?php echo $tablaop['TXT_PREVISION'];?></b></li>
                                    <li>&nbsp;FICHA                 :   <b><?php echo $tablaop['FICHAL'];?></b></li>
                                    <li>&nbsp;NACIONALIDAD          :   <b><?php echo $tablaop['TXT_NACIONALIDAD'];?></b></li>
                                    <li>&nbsp;ETNIA                 :   <b><?php echo $tablaop['TXT_ETNIA'];?></b></li>
                                    <li>&nbsp;COMUNA                :   <b><?php echo $tablaop['TXT_COMUNA'];?></b></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                    
                    <!-- 5. INFO DEL OPERACION -->
                    <h5>&#8226;&nbsp;INFORMACI&Oacute;N QUIR&Uacute;RGICA<small></small></h5>
                    <table width="100%" style="margin-bottom: 8px">
                        <tbody>
                            <tr>
                                <td width="100%"> 
                                    <ul>
                                        <li>&nbsp;PABELL&Oacute;N                           : <b><?php echo $tablaop['SALA_DESCRIPCION'];?></b></li>   
                                        <!-- PROTOCOLO LASER NO SE OCUPA BIOPSIA -->
                                        <!--
                                        <li>&nbsp;BIOPSIA                                   : <b><?php echo $tablaop['BIOPSIA'];?></b></li>
                                        -->
                                        <li>&nbsp;ALUMNO INTERNO                            : <b><?php echo $tablaop['TXTINFOALUMNO'];?></b></li>
                                        <?php if($tablaop['TXTINFOALUMNO']!='NO'){ ?>
                                        <li>&nbsp;NOMBRE ALUMNO                             : <b><?php echo $tablaop['TXT_ALUMNO']; ?></b></li>
                                        <?php } ?>
                                        <li>&nbsp;DERIVACI&Oacute;N                         : <b><?php echo $tablaop['DERIVACION']; ?></b></li>
                                        <!--
                                        <li>&nbsp;RECUENTO DE COMPRESAS                     : <b><?php echo $tablaop['TXT_RECUENTO_COMPRESAS']; ?></b></li>
                                        <li>&nbsp;TIPO DE HERIDA                            : <b><?php echo $tablaop['HERIDAS']; ?></b></li>
                                        <li>&nbsp;INCLUYE ELEMENTO DE OSTEOSINTESIS         : <b><?php echo $tablaop['TXT_OSTEOSINTESIS']; ?></b></li>
                                        <li>&nbsp;CULTIVOS                                  : <b><?php echo $tablaop['CULTIVOS']; ?></b></li>
                                        <li>&nbsp;PROFILAXIS ANTIBI&Oacute;TICA             : <b><?php echo $tablaop['PROFILAXIS']; ?></b></li>
                                        -->
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    
                    <h5>&#8226;&nbsp;CIRUG&Iacute;A REALIZADA<small></small></h5>
                    <table width="100%" style="margin-bottom: 8px">
                        <tbody>
                            <tr>
                                <td width="100%">
                                    <?php 
                                        if(count($DATA["COD_MAI"])>0){
                                            foreach ($DATA["COD_MAI"] as $i => $row){
                                                echo '<li><b>('.$row["NUM_CODIGO"].')</b> - '.$row["NOM_INTERVENCION"].'</li>';
                                            }
                                        } else {
                                            echo "<li>SIN INFORMACI&Oacute;N</li>";
                                        }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    
                    <!-- 3. RESTO DEL RRHH-->
                    <h5>&#8226;&nbsp;RRHH</h5>
                    <table width="100%" style="margin-bottom:8px; display:none">
                        <tbody>
                            <tr>
                                <td width="100%">
                                    &nbsp;<label>&nbsp;&nbsp;<font size=3><b>&#8226;&nbsp;PROFESIONAL A CARGO</b></font></label><br>
                                    <?php echo $VAR_PROFESIONAL_ACARGO;?>
                                </td>
                            </tr>
                            <tr>   
                                <?php if($equipo_tecnologomed!=''){ ?>
                                <td width="100%">
                                    <ul>
                                        <label>&nbsp;&nbsp;&nbsp;<font size=3><b>TECNOLOGO MEDICO</b></font></label>
                                        <?php echo $equipo_tecnologomed;?>
                                    </ul>
                                </td> 
                                <?php } ?>
                            </tr>
                            <tr>   
                                <?php if($equipo_trabajo!=''){ ?>
                                <td width="100%">
                                    <ul>
                                        <label>&nbsp;&nbsp;&nbsp;<font size=3><b>EQUIPO DE TRABAJO</b></font></label>
                                        <?php echo $equipo_trabajo;?>
                                    </ul>
                                </td> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if($enfermeros!=''){ ?>
                                <td width="100%">
                                    <ul>
                                        <label>&nbsp;&nbsp;&nbsp;<font size=3><b>ENFERMERO</b></font></label>
                                        <?php echo $enfermeros;?>
                                    </ul>
                                </td> 
                            </tr>
                            <tr>   
                                <?php } ?>
                                <?php if($matrones!=''){ ?>
                                <td width="100%">
                                    <ul>
                                        <label>&nbsp;&nbsp;&nbsp;<font size=3><b>MATRONES</b></font></label>
                                        <?php echo $matrones;?>
                                    </ul>
                                </td> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if($auxiliar_anestesia!=''){ ?>
                                <td width="100%">
                                    <ul>
                                        <label>&nbsp;&nbsp;&nbsp;<font size=3><b>AUX DE ANESTESIA</b></font></label>
                                        <?php echo $auxiliar_anestesia;?>
                                    </ul>
                                </td> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if($arsenalera!=''){ ?>
                                <td width="100%">
                                    <ul>
                                        <label>&nbsp;&nbsp;&nbsp;<font size=3><b>ARSENALERAS</b></font></label>
                                        <?php echo $arsenalera;?>
                                    </ul>
                                </td> 
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if($pabellonera!=''){ ?>
                                <td width="100%">
                                    <ul>
                                        <label>&nbsp;&nbsp;&nbsp;<font size=3><b>PABELLONERA</b></font></label>
                                        <?php echo $pabellonera;?>
                                    </ul>
                                </td> 
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                    
                    <!-- 6. TIEMPOS DE PABELLON -->
                    <h5>&#8226;&nbsp;TIEMPOS DE PABELL&Oacute;N<small></small></h5>
                    <table width="100%" style="margin-bottom: 8px">
                        <tbody>
                            <tr>
                                <td width="100%" > 
                                    <ul>
                                        <li>&nbsp;FECHA/HORA INICIO QX :<b><?php echo $tablaop['FECHAHORASOLICITUD'];?></b></li>
                                        <li>&nbsp;FECHA/HRS FINAL QX :<b><?php echo $tablaop['FECHAHORAFINAL'];?></b></li>
                                    </ul>
                                </td>
                            </tr>    
                        </tbody>
                    </table>
                </td>
                <!-- MAIN PRINCIPAL -->
                <td width="65%" valign=top>
                    
                    <!-- 2.1 DIAGNOSTICOS -->
                    <table width="100%" style="margin-bottom: 8px;border: none;" class="table table-sm newstile">
                        <thead>
                            <tr>
                                <td width="100%"><h5>&#8226;&nbsp;DIAG. PRE-OPERATORIO&nbsp;<small></small></h5></td>
                            </tr>
                            <tr>
                                <td width="100%">&nbsp;<?php echo $tablaop['TXTDIAGNOSTICO'];?></td> 
                            </tr>
                            <tr>
                                <td width="100%"><h5>&#8226;&nbsp;DIAG. POST-OPERATORIO&nbsp;<small></small></h5></td>
                            </tr>
                            <tr>
                                <td width="100%">&nbsp;<?php echo $tablaop['TXTDIAGNOPOST'];?></td>
                            </tr>
                        </thead>
                    </table>
                    
                    <?php if ($tablaop['ID_ESTADO_TQ'] == '48'){ ?>
                    <h5>&#8226;&nbsp;&nbsp;&nbsp;PANFOTOCOAGULACI&Oacute;N<small></small></h5>
                    <table class="table table-sm subtitulo_formulario2 newstile" style="width:100%;border: none;margin-bottom:15px;"> 
                        <thead>
                            <tr class="subtitulo_formulario2">
                                <td colspan="1" class="subtitulo_formulario2" ><b>DIAGNOSTICO</b></td>
                                <td colspan="3" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_PANFOTO_DIAGNOSTICO'];?></td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td colspan="1" class="subtitulo_formulario2" ><b>PROCEDIMIENTO REALIZADO</b></td>
                                <td colspan="3" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_PANFOTO_PROCEDIMIENTO'];?></td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td colspan="1" class="subtitulo_formulario2" valign="top"><b>ANESTESIA</b></td>
                                <td colspan="3" class="subtitulo_formulario2" ><ul><?php echo $_LI_PANFOTOCOAGULACION; ?></ul></td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td width="40%" class="subtitulo_formulario2" ><b>OJO DERECHO</b></td>
                                <td width="20%" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_PANFOTO_OD'];?></td>
                                <td width="20%" class="subtitulo_formulario2" ><b>OJO IZQUIERDO</b></td>
                                <td width="20%" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_PANFOTO_OI'];?></td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2" ><b>N&deg; DE DISPAROS</b></td>
                                <td class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['NUM_PANFOTO_DISPAROS'];?></td>
                                <td class="subtitulo_formulario2" ><b>PATRON</b></td>
                                <td class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TEXTO_IND_PANFOTO_PATRON'];?></td>
                            </tr>
                            <?php if ($DATA["P_INFO_OFTAMOLOGIA"][0]['TEXTO_IND_PANFOTO_PATRON'] == 'SI') { ?>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2"><b>OBSERVACI&Oacute;N (PATRON)</b></td>
                                <td class="subtitulo_formulario2" colspan="3"><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_PANFOTO_PATRON'];?></td>
                            </tr>
                            <?php } ?>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2" ><b>PODER</b></td>
                                <td class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['NUM_PANFOTO_PODER'];?>&nbsp;mW</td>
                                <td class="subtitulo_formulario2" ><b>DURACI&Oacute;N</b></td>
                                <td class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['NUM_PANFOTO_DURACION'];?>&nbsp;ms</td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2" ><b>TAMA&Ntilde;O</b></td>
                                <td class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['NUM_PANFOTO_TAMANO'];?>&nbsp;&micro;M</td>
                                <td class="subtitulo_formulario2" ><b>N&deg; SESION</b></td>
                                <td class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['NUM_PANFOTO_SESION'];?></td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2"><b>SECTOR</b></td>
                                <td class="subtitulo_formulario2" colspan="3"><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_PANFOTO_SERCTOR'];?></td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2" ><b>OBSERVACIONES</b></td>
                                <td class="subtitulo_formulario2" colspan="3"><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_PANFOTO_OBSERVACIONES'];?></td>
                            </tr>
                        </thead>
                    </table>
                    <?php } if ($tablaop['ID_ESTADO_TQ'] == '52'){ ?>
                    <h5>&#8226;&nbsp;&nbsp;&nbsp;IRIDOTOM&Iacute;A<small></small></h5>
                    <!--
                    <table class="table table-sm subtitulo_formulario2 newstile" style="width:100%;border:none;margin-bottom:15px;"> 
                        <thead>
                            <tr class="subtitulo_formulario2">
                                <td colspan="1" class="subtitulo_formulario2" ><b>DIAGNOSTICO</b></td>
                                <td colspan="3" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_CAPSULO_DIAGNOSTICO'];?></td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td colspan="1" class="subtitulo_formulario2" ><b>PROCEDIMIENTO REALIZADO</b></td>
                                <td colspan="3" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_CAPSULO_PROCEDIMIENTO'];?></td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td colspan="1" class="subtitulo_formulario2" valign="top"><b>ANESTESIA</b></td>
                                <td colspan="3" class="subtitulo_formulario2" > <ul><?php echo $_LI_CAPSULOTOMIA; ?></ul> </td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td width="40%" class="subtitulo_formulario2" ><b>OJO DERECHO</b></td>
                                <td width="20%" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_CAPSULO_OD'];?></td>
                                <td width="20%" class="subtitulo_formulario2" ><b>OJO IZQUIERDO</b></td>
                                <td width="20%" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_CAPSULO_OI'];?></td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2" ><b>N&deg; DE DISPAROS</b></td>
                                <td class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['NUM_CAPSULO_DISPAROS'];?></td>
                                <td class="subtitulo_formulario2" ><b>PATRON</b></td>
                                <td class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TEXTO_IND_CAPSULO_PATRON'];?></td>
                            </tr>
                            <?php if ($DATA["P_INFO_OFTAMOLOGIA"][0]['TEXTO_IND_CAPSULO_PATRON'] == 'SI') { ?>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2" ><b>OBSERVACI&Oacute;N (PATRON)</b></td>
                                <td class="subtitulo_formulario2" colspan="3"><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_CAPSULO_PATRON'];?></td>
                            </tr>
                            <?php } ?>
                            <tr class="subtitulo_formulario2">
                                <td width="40%" class="subtitulo_formulario2" ><b>PODER</b></td>
                                <td width="20%" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['NUM_CAPSULO_PODER'];?> mJ</td>
                                <td width="20%" class="subtitulo_formulario2" ><b>FOCO</b></td>
                                <td width="20%" class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['NUM_CAPSULO_FOCO'];?> &micro;m</td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2" ><b>N&deg; SESION</b></td>
                                <td class="subtitulo_formulario2" ><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['NUM_CAPSULO_SESION'];?></td>
                                <td class="subtitulo_formulario2">&nbsp;</td>
                                <td class="subtitulo_formulario2">&nbsp;</td>
                            </tr>
                            <tr class="subtitulo_formulario2">
                                <td class="subtitulo_formulario2" ><b>OBSERVACIONES</b></td>
                                <td class="subtitulo_formulario2" colspan="3"><?php echo $DATA["P_INFO_OFTAMOLOGIA"][0]['TXT_CAPSULO_OBSERVACIONES'];?></td>
                            </tr>
                        </thead>
                    </table>
                    -->
                    
                    <?php } if ($tablaop['ID_ESTADO_TQ'] == '53'){ ?>
                    <h5>&#8226;&nbsp;&nbsp;&nbsp;TRABECULOPLASTIA STL<small></small></h5>
                    
                    
                    
                    
                    <?php }  ?>
                    
                    
                    <div id="DIV_INTERVENCION_QX" style="display: none">
                        <h5>&#8226;&nbsp;DESCRIPCI&Oacute;N DE INTERVENCI&Oacute;N</h5>
                        <table class="table_2" style="border: none;" width="100%">
                            <thead>
                                <tr>
                                    <td width="100%">&nbsp;<?php echo $tablaop['TXT_DESCRIPCION_QX'];?></td>
                                </tr>
                                <tr>
                                    <td width="100%">&nbsp;<?php echo $tablaop['DESCRIPCION_QX_AYUDANTE'];?></td>
                                </tr>
                            </thead>
                        </table> 
                    </div> 
                </td>
            </tr>
        </table>
    </body>
</html>