<?php
    $VAR_ANATOMIA_PATALOGICA = '';
    $VAR_NOMBRE_PACIENTE = '';
    $VAR_IDENTIFICADOR_PAC = '';
    $FICHAL = '';
    $EDAD = '';
    $NACIMIENTO = '';
    $TXT_PREVISION = '';
    $VAR_PROFESIONAL_ACARGO = '';
    $NOMBRE_ESTALECIMIENTO = '';
    $VAR_FECHA_SOLICITUD = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_SOLICITUD"];
    if(isset($DATA["ALL_CIRUGIAS"][0])){
        $VAR_ANATOMIA_PATALOGICA = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_HISTO"];
        $VAR_NOMBRE_PACIENTE = $DATA["ALL_CIRUGIAS"][0]["NOMBRE_COMPLETO"];
        $VAR_IDENTIFICADOR_PAC = $DATA["ALL_CIRUGIAS"][0]["RUTPACIENTE"];
        $FICHAL = $DATA["ALL_CIRUGIAS"][0]["FICHAL"];
        $NACIMIENTO = $DATA["ALL_CIRUGIAS"][0]["NACIMIENTO"];
        $EDAD = $DATA["ALL_CIRUGIAS"][0]["EDAD"];
        $TXT_PREVISION = $DATA["ALL_CIRUGIAS"][0]["TXT_PREVISION"];
        $listaRRHH = $DATA['ALL_RRHH'];	
        if (count($listaRRHH) > 0) {
            foreach($listaRRHH as $i => $hhrr) {
                if ($hhrr['ID_FUNCION_PB'] == '0') {
                    if ($hhrr['ID_TIPO_RRHH'] == 1) {
                        $VAR_PROFESIONAL_ACARGO     = "" . $hhrr['TXTNOMBRE']." ".$hhrr['RUT_COMPLETO'];
                    } 
                }
            }
        }
    } else {
        $VAR_ANATOMIA_PATALOGICA = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];
        $VAR_NOMBRE_PACIENTE = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['NOMBRE_COMPLETO'];
        $VAR_IDENTIFICADOR_PAC = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['COD_RUTPAC']."-".$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['COD_DIGVER'];
        $FICHAL = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['FICHAL'];
        $NACIMIENTO = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['NACIMIENTO'];
        $EDAD = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['EDAD'];
        $TXT_PREVISION = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_PREVISION'];
        $VAR_PROFESIONAL_ACARGO = $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['PROFESIONAL'].', <b>'.$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['RUT_PROFESIOAL']."</b>";
    }
    $GET_MAIN = $VAR_ANATOMIA_PATALOGICA.'&nbsp;1';
    $get = 'text='.$GET_MAIN;
    $PROFESION = '';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>REPORTE DE SOLICITUD ANATOM&Iacute;A PATOLOG&Iacute;A</title>
        
        <link href="<?php echo base_url();?>/assets/themes/inicio/css/boobtstrap.css" rel="stylesheet"></link>

        <style>
            div.container               {
                width                   :   100%;
                border                  :   1px solid gray;
            }
            .barcode                    {
                padding                 :   1.5mm;
                margin                  :   0;
                vertical-align          :   top;
                color                   :   #000044;
            }
            .barcodecell                {
                text-align              :   center;
                vertical-align          :   top;
            }
            .border                     {
                border-width            :   thin;
                border-spacing          :   2px;
                border-style            :   none;
                border-color            :   black;
            }
            .TD_TH                      {
                border                  :   1px solid black;
            }
            .table_2                    {
                border-collapse         :   collapse;
            }
            .subtitulo_formulario2      {
                font-size               :   14px;
                font-family             :   arial;
                padding                 :   0;
                vertical-align          :   baseline;
                padding                 :   2px;
                border-width            :   1px;
                border-style            :   solid;
                border-color            :   #ADC9E4;
                padding-left            :   10px;
                padding-right           :   10px;
                height                  :   18px;
            }

            .table_etiquetas            {
                border                  :   1px solid black;
                margin-bottom           :   2px;
                width                   :   100%;
            }

            .table_bottom               {
                border-bottom           :   1px solid black;
                margin-bottom           :   2px;
            }

            .border_bottom              {
                border-bottom-width     :   2px;
                border-top-width        :   0px;
                border-left-width       :   0px;
                border-right-width      :   0px;
                border-style            :   solid;
                padding-left: 5px;
            }

            .border_bottom_left         {
                border-bottom-width     :   2px;
                border-top-width        :   2px;
                border-left-width       :   0px;
                border-right-width      :   2px;
                border-style            :   solid;
                padding-left            :   5px;
            }

            .border_bottom_right        {
                border-bottom-width     :   2px;
                border-top-width        :   2px;
                border-left-width       :   0px;
                border-right-width      :   2px;
                border-style            :   solid;
                padding-left            :   5px;
            }

            .size_9                     {
                font-size               :   9px;
            } 

            .size_2                     {
                font-size               :   2px;
            }

            .size_1                     {
                font-size               :   1px;
            }

            .border_firma {
                border-bottom-width : 2px;
                border-top-width : 2px;
                border-left-width : 0px;
                border-right-width : 2px;
                border-style : solid;
                padding-left : 5px;
            }
            
            footer {
                position : absolute;
                bottom : 0;
                height : 60px;
                width : 100%;
            }
        </style>
    </head>

    <!--
    <?php echo $FIRMA;?>
    -->
    <!--
    <?php
        #echo $DATA['HTML_QR'];
        $array_post = [];
        array_push($array_post,"externo=true");
        array_push($array_post,"tk=".md5($VAR_ANATOMIA_PATALOGICA));
        $rul_for_qr = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/ssan_libro_biopsias_usuarioext?".join("&",$array_post);
    ?>
    <div class="barcodecell">
        <barcode type="QR" class="barcode" code="<?php echo $rul_for_qr;?>" height="1" text="1" size="1"/>
    </div>
    -->

    <body>
        <table tabindex="2" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="15%" valign="top" style="text-align:center;">
                    <br>
                    <?php echo  $this->load->view('ssan_libro_biopsias_usuarioext/PDF_PROTOCOLOS/img64logo',[],true);?>
                </td>
                <td width="5%" valign="top">&nbsp;</td>
                <td width="80%" valign="top">
                    <br>
                    <h2 style="margin: 0px 0px 0px 0px;color:#9b9b9b;">
                        <b>PATOLOGIA LABS LIMITADA</b>
                    </h2>
                    <h6 style="margin: 0px 0px 0px 0px;color:#9b9b9b;">
                        <b>CENTRO DE DIAGN&Oacute;TICO PATOL&Oacute;GICO - PRESTACIONES M&Eacute;DICAS AMBULATORIAS</b>
                    </h6>
                    <h6 style="margin: 0px 0px 0px 0px;color:#9b9b9b;">
                        <b>bolivarleeo@hotmail.com</b>
                    </h6>
                    <h6 style="margin: 0px 0px 0px 0px;color:#9b9b9b;">
                        <b>Av. PRAT 1130 - VICTORIA - FONO 45 284650 - CELULAR 9 98244337 - RUT 76.134.511-7</b>
                    </h6>
                </td>
            </tr>
        </table>
        
        <table tabindex="2" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="20%">  </td>
                <td>
                    <p class="h6" style="margin-top:0px;">FECHA TOMA DE MUESTRA</p>
                    <b><?php echo $VAR_FECHA_SOLICITUD;?></b>
                </td>
                <td>
                    <p class="h6" style="margin:0;">FECHA IMPRESI&Oacute;N</p>
                    <b><?php echo date("d-m-Y H:i:s");?></b>
                </td>
                <td>
                    <p class="h6" style="margin:0;">ESTABLECIMIENTO</p>
                    <b><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_HOSPITAL_ETI'];?></b>
                </td>
                <td>
                    <p class="h6" style="margin:0;">N&deg; UNICO: <b><?php echo $VAR_ANATOMIA_PATALOGICA;?></b></p>
                </td>
            </tr>
        </table>

        <br>

        <table tabindex="2" width="100%" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:8px;"> 
            <thead>
                <tr class="subtitulo_formulario2" >
                    <td colspan="2" class="subtitulo_formulario2" bgcolor="#ECF1F1"><b>DATOS PACIENTE:</b></td>
                </tr>
                <tr>
                    <td width="50%" class="subtitulo_formulario2" >NOMBRE DEL PACIENTE:</td>
                    <td width="50%" class="subtitulo_formulario2" ><?php echo $VAR_NOMBRE_PACIENTE;?></td>
                </tr>
                <tr class="subtitulo_formulario2">
                    <td class="subtitulo_formulario2"> RUN</td>
                    <td class="subtitulo_formulario2"><?php echo $VAR_IDENTIFICADOR_PAC; ?></td>
                </tr>
                <tr class="subtitulo_formulario2">
                    <td class="subtitulo_formulario2"> N&deg; FICHA:</td>
                    <td class="subtitulo_formulario2"><?php echo $FICHAL; ?></td>
                </tr>
                <tr class="subtitulo_formulario2">
                    <td class="subtitulo_formulario2"> FECHA NACIMIENTO (EDAD):</td>
                    <td class="subtitulo_formulario2"><?php echo $NACIMIENTO; ?> (<?php echo $EDAD; ?> A&Ntilde;OS)</td>
                </tr>
                <tr class="subtitulo_formulario2">
                    <td class="subtitulo_formulario2"> PREVISI&Oacute;N:</td>
                    <td class="subtitulo_formulario2"> <?php echo $TXT_PREVISION; ?></td>
                </tr>
            </thead>    
        </table>
        
        <table tabindex="2" width="100%" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:8px;"> 
            <thead>
                <tr class="subtitulo_formulario2">
                    <td class="subtitulo_formulario2" colspan="2" bgcolor="#ECF1F1"><b>DETALLE DE LA SOLICITUD:</b></td>
                </tr>
                <tr>
                    <td class="subtitulo_formulario2"               >
                        <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['MEDI'] === 'MATR'?'MATRON':'MEDICO';?>:
                    </td>
                    <td class="subtitulo_formulario2"               ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['PROFESIONAL'];?> | <?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['RUT_PROFESIOAL'];?></td>
                </tr>
                <?php #falta especialidad desde el sql;?>
                <tr>
                    <td class="subtitulo_formulario2" width="50%" >PROCEDENCIA SOLICITUD:</td>
                    <td class="subtitulo_formulario2" width="50%" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_PROCEDENCIA'];?></td>
                </tr>
                <tr>
                    <td class="subtitulo_formulario2" >SERVICIO/UNIDAD PROCEDENCIA:</td>
                    <td class="subtitulo_formulario2" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['NOMBRE_SERVICIO'];?> <?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_SUBDIVISION'];?></td>
                </tr>
                <tr>
                    <td class="subtitulo_formulario2" >TIPO DE BIOPSIA:</td>
                    <td class="subtitulo_formulario2" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TIPO_DE_BIOPSIA'];?></td>
                </tr>
                <tr>
                    <td class="subtitulo_formulario2" >DIAGN&Oacute;STICO CL&Iacute;NICO:</td>
                    <td class="subtitulo_formulario2" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_DIAGNOSTICO'];?></td>
                </tr>
            </thead>
        </table>
        
        <table tabindex="2" width="100%" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:8px;"> 
            <tbody>
                <tr>
                    <td colspan="4" class="subtitulo_formulario2"  bgcolor="#ECF1F1">&nbsp;<b>DETALLE FORMULARIO DE ANATOMIA:</b></td>
                </tr>
                <tr>
                    <td colspan="2"  class="subtitulo_formulario2" > SITIO DE EXTRACCI&Oacute;N:</td>
                    <td colspan="2"  class="subtitulo_formulario2" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_SITIOEXT"]; ?></td>
                </tr>
                <tr>
                    <td colspan="2"  class="subtitulo_formulario2" > UBICACI&Oacute;N:</td>
                    <td colspan="2"  class="subtitulo_formulario2" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_UBICACION"]; ?></td>
                </tr>
                <tr>
                    <td colspan="2"  class="subtitulo_formulario2" > TAMA&Ntilde;O:</td>
                    <td colspan="2"  class="subtitulo_formulario2" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_TAMANNO"];?></td>
                </tr>
                <tr>
                    <td width="25%"  class="subtitulo_formulario2" > TIPO DE LESI&Oacute;N:</td>
                    <td width="25%"  class="subtitulo_formulario2" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_TIPOSESION"]; ?></td>
                    <td width="25%"  class="subtitulo_formulario2" > ASPECTO:</td>
                    <td width="25%"  class="subtitulo_formulario2" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_ASPECTO"]; ?></td>
                </tr>
                <tr>
                    <td width="25%"  class="subtitulo_formulario2" > ANT. PREVIOS:</td>
                    <td width="25%"  class="subtitulo_formulario2" ><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_ANT_PREVIOS"]; ?></td>
                    <td width="25%"  class="subtitulo_formulario2" ></td>
                    <td width="25%"  class="subtitulo_formulario2" ></td>
                </tr>
                <tr>
                    <td colspan="2"  class="subtitulo_formulario2" > DESC. BIOPSIA:</td>
                    <td colspan="2"  class="subtitulo_formulario2" ><?php if($DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_BIPSIA"]==''){ echo "<b>NO INFORMADO</b>";}else{ echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_BIPSIA"];}; ?></td> 
                </tr>
                <tr>
                    <td colspan="2"  class="subtitulo_formulario2" > DESC. CITOLOG&Iacute;A:</td>
                    <td colspan="2"  class="subtitulo_formulario2" ><?php if($DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_CITOLOGIA"]==''){ echo "<b>NO INFORMADO</b>";}else{ echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_CITOLOGIA"];}; ?></td> 
                </tr>
                <tr>
                    <td colspan="2"  class="subtitulo_formulario2" > TIPO DE MUESTRA:</td>
                    <td colspan="2"  class="subtitulo_formulario2" ><?php if($DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_TIPOMUESTRA"]==''){ echo "<b>NO INFORMADO</b>";}else{ echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_TIPOMUESTRA"];}; ?></td>
                </tr>
                <tr>
                    <td colspan="2"  class="subtitulo_formulario2" > NUMERACI&Oacute;N DE MUESTRAS:</td>
                    <td colspan="2"  class="subtitulo_formulario2" ><?php if($DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_SUBNUMERACION"]==''){ echo "<b>NO INFORMADO</b>";}else{ echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_SUBNUMERACION"];}; ?></td> 
                </tr>
                <tr>
                    <td colspan="2"  class="subtitulo_formulario2" > OBSERVACIONES:</td>
                    <td colspan="2"  class="subtitulo_formulario2" ><?php if($DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_OBSERVACIONES"]==''){ echo "<b>NO INFORMADO</b>";}else{ echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["DES_OBSERVACIONES"];}; ?></td> 
                </tr>
            </tbody>
        </table>
        
        <?php $TOTAL_MUESTRAS     =   count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"]); ?>
        
        <table tabindex="2" width="100%" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:8px;"> 
            <thead>
                <tr class="subtitulo_formulario2">
                    <td colspan="3" class="subtitulo_formulario2"   bgcolor="#ECF1F1">
                        <b>INFORMACI&Oacute;N MUESTRAS HISPATOLOGICAS: N&deg; <?php echo $TOTAL_MUESTRAS; ?></b>
                        /
                        <?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_USOCASSETTE"]=='SI'?'<b>USO CASETE: SI</b>':'';?>
                        /
                        <?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_PLANTILLA"]=='DEFAULT'?'':'<b>'.$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_PLANTILLA"].'</b>';?>
                    </td>
                </tr>
                <tr class="subtitulo_formulario2">
                    <td class="subtitulo_formulario2"   bgcolor="#ECF1F1"><b>N&deg;</b></td>
                    <td class="subtitulo_formulario2"   bgcolor="#ECF1F1" style="text-align: center"><b># UNICO</b></td>
                    <td class="subtitulo_formulario2"   bgcolor="#ECF1F1"><b>OBSERVACI&Oacute;N</b></td>
                </tr>
            </thead>  
            <?php 
                $DATA_CASETE    = [];
                if(count($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"])>0){
                    foreach($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row_muestras){ 
                    #var_dump();
                    $DATA_CASETE[$row_muestras['NUM_CASSETTE']][] =  ['TXT_MUESTRA'=>$row_muestras['TXT_MUESTRA'],'ID_CASETE' => $row_muestras["ID_CASETE"] ];
                ?>
                <tr>
                   <td width="10%" class="subtitulo_formulario2"><?php echo $row_muestras['N_MUESTRA']; ?></td>
                   <td width="20%" class="subtitulo_formulario2" style="text-align: center"><?php echo $row_muestras['ID_NMUESTRA']; ?></td>
                   <td width="70%" class="subtitulo_formulario2"><?php echo $row_muestras['TXT_MUESTRA'];?>&nbsp;(<?php echo $row_muestras['NUM_CASSETTE'];?>)</td>
                </tr>
            <?php 
                    } 
                } else {
                    echo "MUESTRAS NO ENCONTRADAS";
                }
            ?>
        </table>
      
        <div style="page-break-after:always;"></div>
        
        <?php if ($DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["TXT_USOCASSETTE"]=='SI'){ ?>
            <?php 
                $COUNT_DATA_CASETE_2        =   count($DATA_CASETE);
                for($i=1; $i<=$COUNT_DATA_CASETE_2; $i++){
                    $TXT_MUESTRAS           =   '';
                    $ID_CASETE              =   '';
                    if(count($DATA_CASETE[$i])>0){
                        foreach ($DATA_CASETE[$i] as $x => $row){
                            if ($x == 0) {$ID_CASETE = $row["ID_CASETE"];}
                            $TXT_MUESTRAS       .=  ($x+1)." - ".$row['TXT_MUESTRA']."<br>";
                        }
                    }
                ?>
                    <table class="" width="527px" cellpadding="0" cellspacing="0" style="margin-bottom:8px;"> 
                        <thead>
                            <tr>
                                <td class="" colspan="3">
                                    <b><?php echo $row_muestras["TXT_HOSPITAL_ETI"]; ?>&nbsp;/&nbsp;<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_PROCEDENCIA'];?></b>
                                </td>     
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <td class="border_bottom_right" width="50%" valign="top">
                                    <label><font size=2>NOMBRE PACIENTE</font></label><br>
                                    <b><?php echo $VAR_NOMBRE_PACIENTE;?></b><br>
                                    <label><font size=2>R.U.N/DNI</font></label><br>   
                                    <b><?php echo $VAR_IDENTIFICADOR_PAC;?></b><br>
                                    <label><font size=2>FECHA NAC:</font></label><br>       
                                    <b><?php echo $NACIMIENTO; ?></b><br>
                                    <label><font size=2>N&deg; FICHA:</font></label><br>    
                                    <b><?php echo $FICHAL;?></b><br> 
                                    <label><font size=2>N&deg; CASETE:</font></label><br>    
                                    <b><?php echo $i;?></b>
                                </td>
                                <td class="border_bottom_left" width="50%" valign="top">
                                   <?php echo $TXT_MUESTRAS; ?>
                                </td>
                                <td style="padding: 8px;text-align: right" >
                                    <barcode code="C<?php echo $ID_CASETE;?>" type="C128A" height="0.66" text="CASETE" />
                                    <br/>
                                    <center>
                                         <b>C<?php echo $ID_CASETE;?></b>
                                    </center>
                                </td>
                            </tr>
                        </thead>
                    </table>
        
            <?php
                }
            ?>
        
        <?php } else { ?>
            
                <?php if($TOTAL_MUESTRAS>0){ ?>
                    <?php $ID_HISTO         =   $VAR_ANATOMIA_PATALOGICA; ?>
                    <?php foreach ($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row_muestras ){ 
                        if ($row_muestras["IND_ETIQUETA"]==2){  ?>
                                <?php
                                    $GET_CODIGO             =   'A'.$row_muestras["ID_NMUESTRA"];
                                    
                                ?>
                                <table class="" width="527px" cellpadding="0" cellspacing="0" style="margin-bottom:8px;"> 
                                    <thead>
                                        <tr>
                                            <td class="" colspan="3">
                                                <b><?php echo $row_muestras["TXT_HOSPITAL_ETI"]; ?>&nbsp;/&nbsp;<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_PROCEDENCIA']; ?> </b>
                                            </td>     
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <td class="border_bottom_right" width="50%" valign="top">
                                                <label><font size=2>NOMBRE PACIENTE</font></label><br>
                                                <b><?php echo $VAR_NOMBRE_PACIENTE; ?></b><br>
                                                <label><font size=2>R.U.N/DNI</font></label><br>    
                                                <b><?php echo $VAR_IDENTIFICADOR_PAC;?></b><br>
                                                <label><font size=2>FECHA NAC:</font></label><br>       
                                                <b><?php echo $NACIMIENTO; ?></b><br>
                                                <label><font size=2>N&deg; FICHA:</font></label><br>    
                                                <b><?php echo $FICHAL; ?></b>
                                            </td>
                                            <td class="border_bottom_left" width="50%" valign="top">
                                                <label><font size=2>N&deg; SOLICITUD:</font></label><br> 
                                                <b><?php echo $VAR_ANATOMIA_PATALOGICA; ?></b><br>
                                                <label><font size=2>N&deg; DE MUESTRA:</font></label><br>     
                                                <b><?php echo $row_muestras["N_MUESTRA"].'/'.$TOTAL_MUESTRAS;?></b><br>
                                                <label><font size=2>IDENTIFICADOR MUESTRA:</font></label><br>     
                                                <b><?php echo $row_muestras["ID_NMUESTRA"]; ?></b><br>
                                                <label><font size=2>OBSERVACI&Oacute;N:</font></label><br>     
                                                <b><?php echo $row_muestras["TXT_MUESTRA"]; ?></b>
                                            </td>
                                            <td style="padding: 8px;">
                                                <barcode code="<?php echo $GET_CODIGO;?>" type="C128A" height="0.66" text="CASETE"/>
                                            </td>
                                        </tr>
                                    </thead>
                            </table>

                             <?php echo "<br>"; ?>

                        <?php } else { ?>

                        <?php 
                        $GET_CODIGO           =   'A'.$row_muestras["ID_NMUESTRA"];
                       
                        ?>
                        <table class="" width="100px" cellpadding="0" cellspacing="0" style="margin-bottom:8px;"> 
                                <thead>
                                    <tr style="display: none">
                                        <td class="" style="padding-bottom:5px">
                                            <barcode code="<?php echo $GET_CODIGO;?>" type="C128A" height="0.66" text="CASETE" />
                                        </td>
                                    </tr> 

                                    <tr>    
                                        <td class="border_bottom_right">
                                            <table width="100%" style="margin: 0px 0px 0px -1px;">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label class="size_9">PACIENTE</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <p style="margin: -4px 0px -3px -3px;">
                                                                <b><?php echo $VAR_NOMBRE_PACIENTE; ?></b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 50%">
                                                            <p style="margin: -4px 0px -3px -3px;">
                                                                <label class="size_9">R.U.N/DNI</label><br>    
                                                                <b class="size_9"><?php echo $VAR_IDENTIFICADOR_PAC; ?></b>
                                                            </p>
                                                        </td>
                                                        <td style="width: 50%">
                                                            <p style="margin: -4px 0px -3px -3px;">
                                                                <label class="size_9">NACIMIENTO</label><br>       
                                                                <b class="size_9"><?php echo $NACIMIENTO; ?></b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p style="margin: -4px 0px -3px -3px;">
                                                                <label class="size_9">N&deg; FICHA</label><br>    
                                                                <b class="size_9"><?php echo $FICHAL; ?></b>
                                                            </p>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>   
                                        </td>
                                    </tr> 

                                    <tr style="display:none">
                                        <td class="border_bottom_left">
                                            <table width="100%" style="margin: 0px 0px 0px -1px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 50%">
                                                            <p style="margin: -4px 0px -3px -3px;">
                                                                <label class="size_9">N&deg;&nbsp;SOLI.</label><br>    
                                                                <b class="size_9"><?php echo $ID_HISTO; ?></b>
                                                            </p>
                                                        </td>
                                                        <td style="width: 50%">
                                                            <p style="margin: -4px 0px -3px -3px;">
                                                                <label class="size_9">#</label><br>       
                                                                <b class="size_9"><?php echo $row_muestras["N_MUESTRA"].'/'.$TOTAL_MUESTRAS;?></b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p style="margin: -4px 0px -3px -3px;">
                                                                <label class="size_9">N&deg;&nbsp;UNICO</label><br>    
                                                                <b class="size_9"><?php echo $row_muestras["ID_NMUESTRA"]; ?></b>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p style="margin: -4px 0px -3px -3px;">
                                                                <label class="size_9"></label><br>    
                                                                <b class="size_9"></b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p style="margin: -4px 0px -3px -3px;">
                                                               <label class="size_9">OBS.</label><br>    
                                                               <b class="size_9"><?php echo $row_muestras["TXT_MUESTRA"]; ?></b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>   
                                        </td>
                                    </tr>
                                </thead>
                            </table>    

                        <?php } ?> <!-- ELSE TAMANO ETIQUETA -->

                    <?php  ; } ?>
                <?php  } ?>
        
        <?php } ?> <!-- USO DE CASETE -->
                        
    </body>
</html> 