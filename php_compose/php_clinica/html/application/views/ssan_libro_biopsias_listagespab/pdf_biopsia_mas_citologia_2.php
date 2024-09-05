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
        if($IND_USOCASSETTE             ==  '1'){
            $ARR_CASETE_ORD             =   [];
            $txt_muestras               =   [];
            foreach($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ 
                $ARR_CASETE_ORD[$row['ID_CASETE']][] = $row; 
                array_push($arr_info_muestras,'C:'.$row['NUM_CASSETTE'].'-'.$row["TXT_MUESTRA"]." <b>(".$row["ID_NMUESTRA"].")</b>"); 
            }
            foreach($ARR_CASETE_ORD as $_num => $row_all){
                foreach($row_all as $x => $row_casete){
                    $n_muestras         =   $x+1;
                    if ($row_casete["TXT_DESC_MICROSCOPICA"] != ''){
                        array_push($arr_html_muestras,'<li class"class_li"><p><b>CASETE : '.$row_casete['NUM_CASSETTE'].'/'.$n_muestras.' ('.$row_casete['TXT_MUESTRA'].')</b> '.$row_casete["TXT_DESC_MICROSCOPICA"].'<p></li>'); 
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
                array_push($arr_info_muestras,$aux_muestras." ".$row["TXT_MUESTRA"]." <b>(".$row["ID_NMUESTRA"].")</b>");
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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo base_url();?>assets/themes/inicio/css/boobtstrap.css" rel="stylesheet"></link>
        <title>INFORME ANATOMIA</title>
        <style>
            @page                   {
                 padding            :   30px !important;
                 font-size          :   8px;
            }
            p                       {     
                font-size           :   15px; 
                margin-bottom       :   2px;
            }
            .class_ul               {
                margin-bottom       :   10px;
                margin-top          :   10px;
                margin-left         :   15px;
                margin-right        :   0px;
            }
            
            .class_li               {
               margin               :   20px 0px 0px 0px;
            }
        </style>
    </head>
    <body>
        <table style="width:100%;margin-bottom:15px">
            <tr>
                <td style="width:20%" valign="top">
                    <br>
                    <?php echo  $this->load->view('ssan_libro_biopsias_usuarioext/PDF_PROTOCOLOS/img64logo',[],true);?>
                </td>
                <td style="width:60%;text-align:center">
                    <h5>
                        <b>UNIDAD DE ANATOM&Iacute;A PATOL&Oacute;GICA</b><br> 
                        <b><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_HOSPDERIVADO'];?></b><br>
                        <?php echo $this->session->userdata("COD_ESTAB") == '100'? '<b>GENERAL BONILLA # 695 FONO 45-2601542</b><br><b>ANGOL</b>':'<b>SERVICIO DE SALUD ARAUCANIA NORTE</b>';?>
                    </h5> 
                </td>
                <td style="width:20%;text-align:right;" valign="top">
                   left 
                </td>
            </tr>
        </table>
        
        <table style="width:100%;margin-bottom:15px">
            <tr>
                <td style="width:40%">&nbsp;</td>
                <td style="width:60%;text-align:right">
                    
                    N&deg; SOLICITUD:&nbsp;<b><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['ID_SOLICITUD'];?></b>
                    <br>
                    N&deg; DE PAGINA: <b><?php echo $num_page;?></b>

                    <h4>
                        <b>
                        <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_INTERNO_AP']=='0'?'':'N&deg; BIOPSIA: '.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_INTERNO_AP'];?> 
                        - 
                        <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FECHA_YEAR_RECEPCION'];?>
                        </b>
                    </h4>
                </td>
            </tr>
        </table>
        <table style="width:100%;margin: 0px 0px 0px 0px;font-size:15px" >
            <tbody>
                <tr>
                    <td style="width:25%"><b>NOMBRES </b></td>
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
                    <td><b>N&deg; FICHA CLINICA</b></td>
                    <td>&nbsp;:</td>
                    <td>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FICHAL'];?>&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top"><b>MUESTRAS</b></td>
                    <td valign="top">&nbsp;:</td>
                    <td valign="top" style="padding-left: 5px;">
                        <?php 
                            if (count($arr_info_muestras)==1){
                                echo substr($arr_info_muestras[0],1);
                            } else {
                                echo implode("<br>",$arr_info_muestras);
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                   <td><b>EXAMEN SOLICITADO</b></td>
                   <td>&nbsp;</td>
                   <td>
                       <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['MEDI'] === 'MATR'?'':'DR(A)';?>:
                       <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['PROFESIONAL_2'];?>
                   </td>
                </tr>
            </tbody>
        </table>
        <table style="width:100%;margin: 0px 0px 0px 0px;font-size:15px" >
            <tbody>
                <tr>
                    <td style="width:100%;text-align:center"><u><b>INFORME ANATOMO - PATOLOGICO</b></u></td>
                </tr>
            </tbody>
        </table>
        <?php   if  ($style_muestras === '1') { echo "<ul class='class_ul'>".implode("",$arr_html_muestras)."</ul>"; } ?>
        <?php   if  ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA']!='' ){ ?>
        <h5 style="margin-bottom:0px;"><u><b style="margin-bottom: 10px">DESCRIPCI&Oacute;N MACROSC&Oacute;PICA</b></u></h5>     
        <p>
           <font SIZE=15px>
                <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA']==''?'NO INFORMADO':str_replace("\n","<br>",$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA']);?>
           </font>
        </p>
        <?php }   ?>
        <h5 style="margin-bottom:0px;"> <u><b style="margin-bottom: 10px">DIAGN&Oacute;STICO ANATOMO PATOLOGIA</b></u></h5>     
        <p>
           <font SIZE=15px>
                <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIADNOSTICO_AP']==''?'NO INFORMADO':str_replace("\n","<br>",$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DIADNOSTICO_AP']);?>
           </font>
        </p>
    </body>
</html>