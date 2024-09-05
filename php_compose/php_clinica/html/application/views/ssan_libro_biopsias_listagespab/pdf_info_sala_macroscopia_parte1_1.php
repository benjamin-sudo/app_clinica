<?php
    $txt_muestras                       =   [];
    $IND_USOCASSETTE                    =   '0';
    $P_ANATOMIA_PATOLOGICA_MUESTRAS     =   $DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS']; 
    $P_AP_MUESTRAS_CITOLOGIA            =   $DATA['P_AP_MUESTRAS_CITOLOGIA']; 
    $style_muestras                     =   '0';
    $html_muestras                      =   '';
    $arr_info_muestras                  =   [];
    $arr_info_cito = [];
    $arr_html_muestras = [];
    if(count($DATA['P_ANATOMIA_PATOLOGICA_MAIN'])>0){
        $style_muestras = '1'; 
        $IND_USOCASSETTE = $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['IND_USOCASSETTE'];
        if($IND_USOCASSETTE == '1'){
            $ARR_CASETE_ORD = [];
            $txt_muestras = [];
            foreach($DATA["P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ 
                $ARR_CASETE_ORD[$row['ID_CASETE']][] = $row; 
                array_push($arr_info_muestras,'C:'.$row['NUM_CASSETTE'].'-'.$row["TXT_MUESTRA"]." <b>(".$row["ID_NMUESTRA"].")</b>"); 
            }
            foreach($ARR_CASETE_ORD as $_num => $row_all){
                foreach($row_all as $x => $row_casete){
                    $n_muestras = $x+1;
                    array_push($arr_html_muestras,'<li class"class_li"><p><b>MUESTRA '.$row_casete['NUM_CASSETTE'].'/'.$n_muestras.' ('.$row_casete['TXT_MUESTRA'].')</b> : '.$row_casete["TXT_DESC_MACROSCOPICA"].'<p></li>'); 
                }
            }
        } else {
            foreach($DATA['P_ANATOMIA_PATOLOGICA_MUESTRAS'] as $i => $row){
                $aux_muestras = ($i+1);
                array_push($arr_info_muestras,$aux_muestras.".- ".$row["TXT_MUESTRA"]." <b>(".$row["ID_NMUESTRA"].")</b>");
                array_push($arr_html_muestras,'<li class"class_li"><p><b>MUESTRA '.$aux_muestras.' ('.$row["TXT_MUESTRA"].')</b>: '.$row["TXT_DESC_MACROSCOPICA"].'<p></li>'); 
            }
        }
    }
    
    $style_citologia = '';
    $html_citologica = '';
    $arr_li_muestras_cito = [];
    if(count($DATA['P_AP_MUESTRAS_CITOLOGIA'])>0){
        $aux_cito = 1;
        $style_citologia = '1';
        $v_sin_texto = '';
        foreach($DATA['P_AP_MUESTRAS_CITOLOGIA'] as $i => $row){
            if($row["TXT_DESC_MACROSCOPICA"] == ''){
                if ($row["TXT_DESC_MACROSCOPICA"] != ''){
                    array_push($arr_li_muestras_cito,'<li class"class_li"><p><b>MUESTRA '.$aux_cito.' ('.$row["TXT_MUESTRA"].')</b>: '.$row["TXT_DESC_MACROSCOPICA"].' <p></li>'); 
                }
                $html_citologica .=  '
                                        <tr>
                                            <td style="width:100%;height:25px;" valign="top">
                                                <b>MUESTRA '.$aux_cito.' ('.$row["TXT_MUESTRA"].')</b>: '.$row["TXT_DESC_MACROSCOPICA"].' 
                                            </td>
                                        </tr>
                                    ';
                $aux_cito++;
                
            } else {
                $v_sin_texto = '<b style="font-size:8px">&nbsp;SIN DESCRIPCI&Oacute;N</b>';
            }
            array_push($arr_info_cito,$aux_cito.".- ".$row["TXT_MUESTRA"] ." <b>(".$row["ID_NMUESTRA"].")</b>". $v_sin_texto);
        }
    }
    $ind_histo_mas_cito = count($DATA['P_AP_MUESTRAS_CITOLOGIA'])>0&&count($DATA['P_ANATOMIA_PATOLOGICA_MAIN'])>0?'1':'0';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo base_url();?>assets/themes/inicio/css/boobtstrap.css" rel="stylesheet"></link>
        <title>INFORME MACROSCOPIA PARTE 1.1</title>
       <style>
           @page {
                margin-top : 0.5cm;
                margin-bottom : 3cm;
                margin-left : 0.5cm;
                margin-right : 0.5cm;
            }
            p {     
                font-size : 15px; 
                margin-bottom : 2px;
            }
            .class_ul {
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


    <table class="table" style="border: none;">
        <tr>
            <td width="10%" style="text-align: center; vertical-align: top;">
                <?php echo $this->load->view('ssan_libro_biopsias_usuarioext/PDF_PROTOCOLOS/img64logo',[],true);?>
                <br>
            </td>
            <td width="40%" style="padding-left: 10px;">
                <h4 style="margin: 0; font-size: 16px;">DR. BOLIVAR LEE OLMOS</h4>
                <h4 style="margin: 0; font-size: 14px;">CENTRO MEDICO SIRESA</h4>
                <address style="font-size: 12px; line-height: 1.5;">
                    FONO: PRAT 1130, 98244337
                    <br>
                    VICTORIA, REGI&Oacute;N DE LA ARAUCANIA - CHILE
                    <br>
                </address>
            </td>
            <td width="50%" style="vertical-align: top; text-align: left; padding-left: 10px;">
                <h4 style="margin: 0; font-size: 14px;">
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
                N&deg; DE PAGINA:&nbsp;<b><?php echo $num_page;?></b>
            </td>
        </tr>
    </table>
            
        

        <table style="width:100%;margin-bottom:15px;font-size:15px" >
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
                    <td>&nbsp;<?php echo $DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["COD_RUTPAC"]."-".$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["COD_DIGVER"]." ".$DATA["P_ANATOMIA_PATOLOGICA_MAIN"][0]["NUM_IDENTIFICACION"];?>&nbsp;</td>
                </tr>
                <tr>
                    <td><b>N&deg; FICHA CL&Iacute;NICA</b></td>
                    <td>&nbsp;:</td>
                    <td>&nbsp;<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FICHAL']==""?'NO INFORMADO':$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['FICHAL'];?>&nbsp;</td>
                </tr>
                
                <tr>
                    <td valign="top"><b>MUESTRAS</b></td>
                    <td valign="top">&nbsp;:</td>
                    <td valign="top" style="padding-left:5px;">
                        <?php
                            if(count($arr_info_muestras)>0){
                                if($ind_histo_mas_cito == 1){
                                    /*
                                    echo    "<label size=2><b>";
                                    echo        $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_INTERNO_AP']=='0'?
                                                'N&deg; PAP: '.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_CO_PAP']:
                                                'N&deg; BIOPSIA: '.$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['NUM_INTERNO_AP'];
                                    echo    "</label></b><br>";
                                    */
                                }
                                echo count($arr_info_muestras)==1?explode(".-",$arr_info_muestras[0])[1]:join($arr_info_muestras,"<br>");
                            }
                        ?>
                        <?php #echo count($arr_info_muestras)>0?join($arr_info_muestras,"<br>"):''?>
                        <?php
                        $ind_histo_mas_cito == 1 ?'':'';
                            echo count($arr_info_muestras)>0?'<br>':'';
                            if(count($arr_info_cito)>0){
                                echo count($arr_info_cito)==1?explode(".-",$arr_info_cito[0])[1]:join($arr_info_cito,"<br>");
                            }
                        ?>
                        <?php #echo count($arr_info_cito)>0?"<br>".join($arr_info_cito,"<br>"):''?>
                    </td>
                </tr>
                <tr>
                   <td><b>EXAMEN SOLICITADO</b></td>
                   <td>&nbsp;</td>
                   <td><?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['MEDI'] === ''?'':'DR(A)';?>:
                        <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['PROFESIONAL_2'];?>
                   </td>
                </tr>
            </tbody>
        </table>
        <table style="width:100%;margin-bottom:15px;font-size:15px">
            <tbody>
                <tr>
                    <td style="width:100%;text-align:center">&nbsp;<u><b>INFORME ANATOMO PATOLOGICO</b></u></td>
                </tr>
            </tbody>
        </table>
        <?php   if($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA']!=''){ ?>
            <table style="width:100%;margin-bottom:15px;font-size:15px;">
                <tbody>
                    <tr>
                        <td style="width:50%;">&nbsp;<u><b style="margin-bottom: 10px">DESCRIPCI&Oacute;N MACROSC&Oacute;PICA</b></u></td>
                        <td style="width:50%;">
                            <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA']==''?'NO INFORMADO':$DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_DESC_MACROSCOPICA'];?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php   } ?>
        <?php   if (count($arr_html_muestras)>0)        {   echo "<ul class='class_ul'>".implode("",$arr_html_muestras)."</ul>"; } ?>   
        <?php   if (count($arr_li_muestras_cito)>0)     {   echo "<ul class='class_ul'>".implode("",$arr_li_muestras_cito)."</ul>"; } ?>
        <!--
        <?php   
        if(count($DATA['C_IMAGENES_BLOB'])>0){
            foreach ($DATA['C_IMAGENES_BLOB'] as $i => $row){
                echo $row['NAME_IMG'].'<br>'; ?>
                <img src="<?php echo $row["IMG_DATA"]?>" alt="Red dot" style="width:64px;height:64px;" />
                <br>
            <?php
            }
        } ?>
        <?php   
        if(count($DATA['C_IMAGENES_BLOB_MUESTRAS'])>0){
            foreach ($DATA['C_IMAGENES_BLOB_MUESTRAS'] as $i => $row){
                echo $row['NAME_IMG'].'<br>';  ?>
                <img src="<?php echo $row["IMG_DATA"]?>" alt="Red dot" style="width:64px;height:64px;" />
                <br>
            <?php
            }
        } ?>
        -->   
    </body>
</html>
