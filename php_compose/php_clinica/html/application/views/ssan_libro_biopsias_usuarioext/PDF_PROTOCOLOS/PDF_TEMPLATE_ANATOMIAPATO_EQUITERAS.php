<?php
    $VAR_ANATOMIA_PATALOGICA            =   '';
    $VAR_NOMBRE_PACIENTE                =   '';
    $VAR_IDENTIFICADOR_PAC              =   '';
    $FICHAL                             =   '';
    $EDAD                               =   '';
    $NACIMIENTO                         =   '';
    $TXT_PREVISION                      =   '';
    $VAR_PROFESIONAL_ACARGO             =   '';
    $NOMBRE_ESTALECIMIENTO              =   '';
    $VAR_FECHA_SOLICITUD                =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["FECHA_SOLICITUD"];
    if(isset($DATA["ALL_CIRUGIAS"][0])){
        $VAR_ANATOMIA_PATALOGICA        =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_HISTO"];
        $VAR_NOMBRE_PACIENTE            =   $DATA["ALL_CIRUGIAS"][0]["NOMBRE_COMPLETO"];
        $VAR_IDENTIFICADOR_PAC          =   $DATA["ALL_CIRUGIAS"][0]["RUTPACIENTE"];
        $FICHAL                         =   $DATA["ALL_CIRUGIAS"][0]["FICHAL"];
        $NACIMIENTO                     =   $DATA["ALL_CIRUGIAS"][0]["NACIMIENTO"];
        $EDAD                           =   $DATA["ALL_CIRUGIAS"][0]["EDAD"];
        $TXT_PREVISION                  =   $DATA["ALL_CIRUGIAS"][0]["TXT_PREVISION"];
        $listaRRHH                      =   $DATA['ALL_RRHH'];	
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
        $VAR_ANATOMIA_PATALOGICA        =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["ID_SOLICITUD"];
        $VAR_NOMBRE_PACIENTE            =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['NOMBRE_COMPLETO'];
        $VAR_IDENTIFICADOR_PAC          =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['COD_RUTPAC']."-".$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['COD_DIGVER'];
        $FICHAL                         =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['FICHAL'];
        $NACIMIENTO                     =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['NACIMIENTO'];
        $EDAD                           =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['EDAD'];
        $TXT_PREVISION                  =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_PREVISION'];
        $VAR_PROFESIONAL_ACARGO         =   $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['PROFESIONAL'].', <b>'.$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['RUT_PROFESIOAL']."</b>";
    }
    $GET_MAIN                           =   $VAR_ANATOMIA_PATALOGICA.'&nbsp;1';
    $get                                =   'text='.$GET_MAIN;
    $PROFESION                          =   '';
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

            .border_firma               {
                border-bottom-width     :   2px;
                border-top-width        :   2px;
                border-left-width       :   0px;
                border-right-width      :   2px;
                border-style            :   solid;
                padding-left            :   5px;
            }
            
            footer                      {
                position                :   absolute;
                bottom                  :   0;
                height                  :   60px;
                width                   :   100%;
            }
        </style>
    </head>
    <body>
        <h2 style="margin: 0px 0px 0px 0px;color:#e34f49;">
            <b>SOLICITUD ANATOM&Iacute;A PATOL&Oacute;GICA</b>
        </h2>
        <table tabindex="2" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="15%" valign="top" style="text-align:center;">
                    <br>
                    <img class="img-thumbnail" style="width:95px;height:90px;vertical-align:top;margin-top:0px;" src="data:image/jpeg;base64,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" /> 
                </td>
                <td width="25%" valign="top">
                    <br>
                    <p class="h6" style="margin-top:0px;">FECHA TOMA DE MUESTRA</p>
                    <b><?php echo $VAR_FECHA_SOLICITUD;?></b>
                    <p class="h6" style="margin:0;">FECHA IMPRESI&Oacute;N</p>
                    <b><?php echo date("d-m-Y H:i:s");?></b>
                    <p class="h6" style="margin:0;">ESTABLECIMIENTO</p>
                    <b><?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]['TXT_HOSPITAL_ETI'];?></b>
                    <p class="h6" style="margin:0;">N&deg; UNICO: <b><?php echo $VAR_ANATOMIA_PATALOGICA;?></b></p>
                </td>
                <td width="45%" valign="top">
                    <?php echo $FIRMA;?>
                </td>
                <td width="15%" valign="top">
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