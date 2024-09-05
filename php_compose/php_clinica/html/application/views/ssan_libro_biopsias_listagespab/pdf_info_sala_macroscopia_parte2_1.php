<?php
    $txt_muestras                       =   [];
    $IND_USOCASSETTE                    =   '0';
    $P_ANATOMIA_PATOLOGICA_MUESTRAS     =   $DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS']; 
    $P_AP_MUESTRAS_CITOLOGIA            =   $DATA['P_AP_MUESTRAS_CITOLOGIA']; 
    #variables
    $style_muestras                     =   '0';
    $html_muestras                      =   '';
    $arr_info_muestras                  =   [];
    $arr_html_muestras                  =   [];
    $arr_info_cito                      =   [];
    if(count($DATA['P_ANATOMIA_PATOLOGICA_MAIN'])>0){
        $style_muestras                 =   '1'; 
        $IND_USOCASSETTE                =   $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_USOCASSETTE'];
        if($IND_USOCASSETTE == '1'){
            $ARR_CASETE_ORD             =   [];
            $txt_muestras               =   [];
            foreach($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ 
                $ARR_CASETE_ORD[$row['ID_CASETE']][] = $row; 
                array_push($arr_info_muestras,'C:'.$row['NUM_CASSETTE'].'-'.$row["TXT_MUESTRA"]); 
            }
            foreach($ARR_CASETE_ORD as $_num => $row_all){
                foreach($row_all as $x => $row_casete){
                    $n_muestras         =   $x+1;
                    if ($row_casete["TXT_DESC_MICROSCOPICA"] != ''){
                        array_push($arr_html_muestras,'<li class"class_li"><p><b>MUESTRA : '.$row_casete['NUM_CASSETTE'].'/'.$n_muestras.' ('.$row_casete['TXT_MUESTRA'].')</b> : '.$row_casete["TXT_DESC_MICROSCOPICA"].'<p></li>'); 
                        /*
                        $html_muestras      .=  '
                                                <tr>
                                                    <td style="width:15%" valign="top">
                                                        <b>CASETE : '.$row_casete['NUM_CASSETTE'].' /'.$n_muestras.'|'.$row_casete['ID_CASETE'].'</b>
                                                    </td>
                                                    <td style="width:85%" valign="top">
                                                        '.$row_casete["TXT_DESC_MICROSCOPICA"].'
                                                    </td>
                                                </tr>
                                            ';
                        */
                    }
                }
            }
        } else {
            foreach($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'] as $i => $row){
                $aux_muestras           =   ($i+1);
                array_push($arr_info_muestras,$aux_muestras.".-".$row["TXT_MUESTRA"] ." <b>(".$row["ID_NMUESTRA"].")</b>");
                if($row["TXT_DESC_MICROSCOPICA"] != ''){
                    array_push($arr_html_muestras,'<li class"class_li"><p><b>MUESTRA '.$aux_muestras.' ('.$row["TXT_MUESTRA"].')</b>: '.$row["TXT_DESC_MICROSCOPICA"].'<p></li>'); 
                    /*
                    $html_muestras          .=  '
                                                <tr>
                                                    <td style="width:100%;height:50px;" valign="top">
                                                        <b>MUESTRA '.$aux_muestras.' ('.$row["TXT_MUESTRA"].')</b>: '.$row["TXT_DESC_MICROSCOPICA"].' 
                                                    </td>
                                                </tr>
                                            ';
                    */
                }
            }
        }
    }
    #informacion citologia
    $style_citologia                    =   '';
    $html_citologica                    =   '';
    $arr_html_li_citologico             =   [];
    if(count($DATA['P_AP_MUESTRAS_CITOLOGIA'])>0){
        $style_citologia                =   '1';
        $aux_cito                       =   1;
        foreach($DATA['P_AP_MUESTRAS_CITOLOGIA'] as $i => $row){
            array_push($arr_info_cito,$aux_cito.".- ".$row["TXT_MUESTRA"]." <b>(".$row["ID_NMUESTRA"].")</b>");
            if($row["TXT_DESC_MICROSCOPICA"] != ''){
                array_push($arr_html_li_citologico,'<li class"class_li"><p><b>MUESTRA '.$aux_cito.' ('.$row["TXT_MUESTRA"].')</b>: '.$row["TXT_DESC_MICROSCOPICA"].'<p></li>'); 
                /*
                $html_citologica            .=  '
                                                <tr>
                                                    <td style="width:100%;height:50px;" valign="top">
                                                        <b>MUESTRA '.$aux_cito.' ('.$row["TXT_MUESTRA"].')</b>: '.$row["TXT_DESC_MICROSCOPICA"].' 
                                                    </td>
                                                </tr>
                                            '; 
                */
            }
            $aux_cito++;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo base_url();?>assets/themes/inicio/css/boobtstrap.css" rel="stylesheet"></link>
        <title>INFORME MICROSCOPIA</title>
        <style>
            @page {
                margin-top : 0.5cm;
                margin-bottom : 3cm;
                margin-left : 0.5cm;
                margin-right : 0.5cm;
            }
            p                       {     
                font-size : 15px; 
                margin-bottom : 2px;
            }
            .class_ul               {
                margin-bottom : 10px;
                margin-top : 10px;
                margin-left : 15px;
                margin-right : 0px;
            }
            .class_li {
               margin : 20px 0px 0px 0px;
            }
        </style>
    </head>
    
    <body>

        <table class="table" style="border: none;" width="100%">
            <tr>
                <td width="10%" style="width:10%;text-align:center"> 
                    <?php echo $this->load->view('ssan_libro_biopsias_usuarioext/PDF_PROTOCOLOS/img64logo',[],true);?>
                    <br>
                </td>
                <td width="1%"> - </td>
                <td width="45%">
                    <h4>DR. BOLIVAR LEE OLMOS</h4>
                    <h4>CENTRO MEDICO SIRESA</h4>
                    <address>
                        FONO: PRAT 1130, 98244337
                        <br>
                        VICTORIA, REGION DE LA ARAUCANIA - CHILE
                        <br>
                    </address>
                </td>
                <td width="44%">
                    <h4>
                        <b>
                            <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_INTERNO_AP']=='0'?'':'N&deg; BIOPSIA: '.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_INTERNO_AP'];?> 
                            <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] == 4?'-':'';?> 
                            <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_CO_CITOLOGIA']==''?'':'N&deg; CITOL&Oacute;GICO: '.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_CO_CITOLOGIA'];?> 
                            <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_CO_PAP']==''?'':'N&deg; PAP: '.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_CO_PAP'];?> 
                            - 
                            <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FECHA_YEAR_RECEPCION'];?>
                        </b>
                    </h4>
                    N&deg; SOLICITUD:&nbsp;<b><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?></b>
                    <br>
                    N&deg; DE PAGINA:&nbsp;:<b><?php echo $num_page;?></b>
                </td>
            </tr>
        </table>

        

        <?php  if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] === '5' || $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] === '6') { ?>
            <table style="width:100%;margin: 0px 0px 0px 0px;font-size:15px" >
            <tbody>
                <tr>
                    <td style="width:25%"><b>NOMBRE</b></td>
                    <td style="width:1%">&nbsp;:</td>
                    <td style="width:47%">&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NOMBRE_COMPLETO'];?></td>
                </tr>
                <tr>
                    <td><b>EDAD</b></td>
                    <td>&nbsp;:</td>
                    <td>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['EDAD'];?>&nbsp;A&Ntilde;OS</td>
                </tr>
                <tr>
                    <td><b>RUN</b></td>
                    <td>&nbsp;:</td>
                    <td>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['RUTPACIENTE'];?>&nbsp;</td>
                </tr>
                <tr>
                    <td><b>N&deg; FICHA CL&Iacute;NICA</b></td>
                    <td>&nbsp;:</td>
                    <td>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FICHAL'];?>&nbsp;</td>
                </tr>
                
                <tr>
                    <td valign="top"><b>MUESTRAS</b></td>
                    <td valign="top">&nbsp;:</td>
                    <td valign="top" style="padding-left: 5px;">
                        <?php 
                            #echo count($arr_info_muestras)>0?implode("<br>",$arr_info_muestras):'';
                            if(count($arr_info_muestras)>0){
                                echo    count($arr_info_muestras)==1?
                                        explode(".-",$arr_info_muestras[0])[1]:
                                        join($arr_info_muestras,"<br>");
                            }
                        ?>
                        <?php 
                            //echo count($arr_info_cito)>0?implode("<br>",$arr_info_cito):''
                        ?>
                        <?php
                        if(count($arr_info_cito)>0){
                            if(count($arr_info_cito)==1){
                                $arr_muestras   =   explode(".-",$arr_info_cito[0]);
                                echo $arr_muestras[1];
                            } else {
                                echo implode("<br>",$arr_info_cito);
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                   <td><b>EXAMEN SOLICITADO</b></td>
                   <td>&nbsp;</td>
                   <td><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['MEDI'] === 'MATR'?'':'DR(A)';?>:
                        <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['PROFESIONAL_2'];?>
                   </td>
                </tr>
            </tbody>
        </table>
        <br> 
        <table style="width:100%;margin: 0px 0px 0px 0px;font-size:15px">
            <tbody>
                <tr>
                    <td style="width:100%;text-align:center"><u><b>
                        <?php  if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] === '5'){ ?>
                            INFORME CITOL&Oacute;GICO
                        <?php } else { ?>
                            INFORME ANATOMO - PATOLOGICO
                        <?php } ?> 
                        </b></u>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php   }   ?>
        <?php   if (count($arr_html_muestras)>0)        {   echo    "<ul class='class_ul'>".implode("",$arr_html_muestras)."</ul>"; } ?>    
        <?php   if (count($arr_html_li_citologico)>0)   {   echo    "<ul class='class_ul'>".implode("",$arr_html_li_citologico)."</ul>"; } ?>
        <?php   if (($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] == 5 || $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] == 6)  && $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA']!='' ){ ?>
            <h5 style="margin-bottom:0px;"><u><b style="margin-bottom: 10px">DESCRIPCI&Oacute;N MACROSC&Oacute;PICA</b></u></h5>
            <p>
            <font size=10>
                <?php echo 
                    $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA']==''?'':str_replace("\n","<br>",$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA']);
                ?>
            </font>
            </p>
        <?php }   ?>
        
        <?php if ( $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_CITOLOGICO'] != ''){ ?>
            <h5 style="margin-bottom:0px;"><u><b style="margin-bottom: 10px">DESCRIPCI&Oacute;N CITOL&Oacute;GICO</b></u></h5>
            <p>
            <font size=10>
                <?php echo 
                    $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_CITOLOGICO']==''?'':str_replace("\n","<br>",$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_CITOLOGICO']);
                ?>
            </font>
            </p>
        <?php } ?>
            
        <h5 style="margin-bottom:0px;"><u><b style="margin-bottom: 10px">DIAGN&Oacute;STICO 
            <?php if ( $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] == 5  ){ ?>
                    CITOL&Oacute;GICO
            <?php } else if ( $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_TIPO_BIOPSIA'] == 6  ){ ?>      

            <?php } else { ?>
                    ANATOMO PATOLOGIA
            <?php }   ?>  </b> </u>  
        </h5>    
        <p>
            <font size=10>
                <?php echo 
                    $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIADNOSTICO_AP']==''?'':str_replace("\n","<br>",$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIADNOSTICO_AP']);
                ?>
            </font>
        </p>
        <p>
            <font size=10>
                <?php echo 
                    $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIAG_CITOLOGIA']==''?'':str_replace("\n","<br>",$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIAG_CITOLOGIA']);
                ?>
            </font>
        </p>
    </body>
</html>