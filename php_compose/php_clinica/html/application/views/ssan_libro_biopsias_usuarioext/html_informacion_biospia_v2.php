<style>
     .grid_cabecera_histo            {
        display                     :   grid;
        grid-template-columns       :   1fr;
        text-align                  :   center;
    }
    
    .grid_visualiza_simple          {
        display                     :   grid;
        grid-template-columns       :   1fr;
        gap                         :   5px;
        margin-left                 :   8px;
    }
    
    .grid_mas_icon          {
        display                     :   grid;
        grid-template-columns       :   auto 1fr;
        gap                         :   5px;
        margin-left                 :   8px;
    }
    
    .grid_visualizacion             {
        display                     :   grid;
        grid-template-columns       :   40px 1fr  1fr 40px;
        grid-column-gap             :   5px;
        grid-row-gap                :   5px;
        justify-items               :   stretch;
    }
    
    .grid_card                      {
        display                     :   grid;
        grid-template-columns       :   1fr 1fr;
        grid-column-gap             :   5px;
        grid-row-gap                :   5px;
        justify-items               :   stretch;
    }
    
    .card                           {
        border-radius               :   4px;
        box-shadow                  :   0 1px 2px rgb(0 0 0 / 5%), 0 0 0 1px rgb(63 63 68 / 10%);
        background-color            :   #FFFFFF;
        margin-bottom               :   0px;
        padding                     :   8px;
        min-width                   :   190px;
    }
    
    .grid_li_muestras               {
        display                     :   grid;
        grid-template-columns       :   auto 1fr;
        gap                         :   15px;
    }


    .grid_li_muestras_auto               {
        display                     :   grid;
        grid-template-columns       :   auto 1fr;
        gap                         :   15px;
    }

    .row {
        width                       :   100%;
        margin                      :   auto auto;
    }
    
    .sin_padding                    {
        padding                     :   5px;
    }

    .grid_small                     {
        display                     :   grid;
        grid-template-columns       :   auto  1fr;
        gap                         :   15px;
    }
    
    .grid_container                 {
        display                     :   grid;
        grid-template-columns       :   repeat(auto-fit,minmax(100%, 1fr));
        gap                         :   10px;
    }

    .grid_comunas_trazabilidada     {
        display                     :   grid;
        grid-template-columns       :   1fr 1fr;
        gap                         :   6px;
    }

    .grid_li_muestras_end           {
        text-align                  :   end;
    }

    @media (max-width: 950px)       {
        .grid_comunas_trazabilidada {
            grid-template-columns   :   1fr;
        }
    }

    .card_display_none              {
        display                     :   none;
    }

    .content                        {
        padding-top                 :   0px;
    }
</style>

<?php #count($cursor[":C_TECNICASAPLICADAS"])>0?var_dump($cursor[":C_TECNICASAPLICADAS"]):'';?>

<div class="grid_comunas_trazabilidada">
    <div class="grid_comunas_trazabilidada1">
            <!-- info pac -->
            <div class="card grid_item" id="card_informacio_paciente" style="margin-bottom: 6px;">
                <h5 class="title" style="margin: 0px;">&nbsp;<b style="color:#888888;">PACIENTE</b></h5>
                <div class="content card-body">
                    <table class="table table-striped"  style="margin-bottom: 2px;margin-top: 2px;">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <small><b style="color:#888888;">NOMBRE DEL PACIENTE</b></small><br>
                                    <small class="text-muted" id="nombreLabel"><?php echo $cursor[":C_MAIN_AP"][0]["NOMBRE_COMPLETO"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small><b style="color:#888888;">RUN</b></small><br>
                                    <small class="text-muted" id="rutLabel"><?php echo $cursor[":C_MAIN_AP"][0]["RUTPACIENTE"];?></small>
                                </td>
                                <td>
                                    <small><b style="color:#888888;">SEXO</b></small><br>
                                    <small class="text-muted" id="sexoLabel"><?php echo $cursor[":C_MAIN_AP"][0]["IND_TISEXO"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <small><b style="color:#888888;">F.&nbsp;NACIMIENTO</b></small><br>
                                    <small class="text-muted" id="edadLabel"><?php echo $cursor[":C_MAIN_AP"][0]["NACIMIENTO"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <small><b style="color:#888888;">N&deg;&nbsp;FICHA LOCAL</b></small><br>
                                    <small class="text-muted" id="FichaLabel"><?php echo $cursor[":C_MAIN_AP"][0]["FICHAL"];?></small>
                                </td>
                            </tr>
                            <tr> 
                                <td colspan="2">
                                    <small><b style="color:#888888;">PREVISI&Oacute;N</b></small><br>
                                    <small class="text-muted" id="previsionLabel"><?php echo $cursor[":C_MAIN_AP"][0]["TXT_PREVISION"];?></small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end info pac -->



               <!-- star TRAZABILIDAD MUESTRAS -->
               <div class="card grid_item" id="card_tiempos_anatomia_patologica" style="margin-bottom:5px">
                <h5 class="title" style=" margin:0px;">&nbsp;<b style="color:#888888;">TRAZABILIDAD MUESTRAS</b></h5>
                <div class="content card-body">
                    <?php
                        $_bol_pasaatrasporte    =   false;
                        $_bol_pasaarecepcion    =   false;
                        $_bol_terminoinforme    =   false;
                    ?>
                    <div class="grid_small">
                        <div class="grid_small1"><small><b style="color:#888888;">CUSTODIA</b></small></div>
                        <div class="grid_small2">&nbsp;</div>
                    </div>
                    <?php   if(count($cursor[":C_CUSTODIA"])>0){    ?>
                        <ul class="list-group" style="margin-bottom:0px;">
                            <?php   $_arr_custodia = $cursor[":C_CUSTODIA"];
                                    foreach($_arr_custodia as $i => $row){ $aux = $i+1; ?>
                                <li class="list-group-item">
                                    <div class="grid_li_muestras_auto">
                                        <div class="grid_li_muestras1"><?php echo $aux." - ".$row['LAST_USERCUSTODIA'];?></div>
                                        <div class="grid_li_muestras_end"><?php echo $row['DATE_LAST_CUSTODIA'];?></div>
                                    </div>
                                </li>
                            <?php   }   ?>
                        </ul>
                    <?php   }   else    {    ?>
                        <h6 style="margin: 0px;"><b style="color:#888888;">SIN GESTI&Oacute;N CUSTODIA<b></h6>
                    <?php   }   ?>

                    <div class="grid_small">
                        <div class="grid_small1"><small><b style="color:#888888;">TRASPORTE</b></small></div>
                        <div class="grid_small2">&nbsp;</div>
                    </div>
                    <?php  
                        $_arr_trasporte             =   $cursor[":C_TRASPORTE"];  
                        if(count($_arr_trasporte)>0){ 
                            $_bol_pasaatrasporte    =   true;
                        ?>
                        <ul class="list-group" style="margin-bottom: 0px;">
                            <?php  foreach($_arr_trasporte as $i => $row){ $aux = $i+1; ?>
                                <li class="list-group-item">
                                    <div class="grid_li_muestras_auto">
                                        <div class="grid_li_muestras1"><?php echo $aux." - ".$row['LAST_TRASPORTE'];?></div>
                                        <div class="grid_li_muestras_end" ><?php echo $row['DATE_LAST_TRASPORTE'];?></div>
                                    </div>
                                </li>
                            <?php   }   ?>
                        </ul>
                    <?php               ?>    
                    <?php   }   else    {    ?>
                        <h6 style="margin: 0px;"><b style="color:#888888;">SIN GESTI&Oacute;N TRASPORTE<b></h6>
                    <?php   }   ?>
                    <?php   if($_bol_pasaatrasporte){   ?>
                        <div class="grid_small">
                            <div class="grid_small1"><small><b style="color:#888888;">ACTA RECEPCI&Oacute;N DE MUESTRAS</b></small></div>
                            <div class="grid_small2">&nbsp;</div>
                        </div>
                        <?php
                            $_arr_recepcion = $cursor[":C_RECEPCION"];     
                            if(count($_arr_recepcion)>0){ ?>
                            <ul class="list-group" style="margin-bottom: 0px;">
                                <?php  foreach($_arr_recepcion as $i => $row){ $aux = $i+1; ?>
                                    <li class="list-group-item">
                                        <div class="grid_li_muestras_auto">
                                            <div class="grid_li_muestras1"><?php echo " - ".$row['NAME_CONF_TRAS']."<br> - ".$row['NAME_RECEPCION'];?></div>
                                            <div class="grid_li_muestras_end"><?php echo $row['DATE_RECEPCION'];?></div>
                                        </div>
                                    </li>
                                <?php   }   ?>
                            </ul>
                            <?php  $_bol_terminoinforme =  true;    ?>        
                        <?php   }   else    {   ?>
                            <h6 style="margin: 0px;"><b style="color:#888888;">SIN GESTI&Oacute;N RECEPCI&Oacute;N<b></h6>
                        <?php   }   ?>

                    <?php   }   ?>
                </div>
            </div>
            <!-- end TRAZABILIDAD MUESTRAS -->  
            

            <!-- ini GESTION DE ANATOMIA -->
            <div class="card grid_item <?php echo $_bol_terminoinforme?'':'card_display_none';?>" id="card_infopabellon" style="margin-bottom:5px;">
                <h5 class="title" style="margin:0px;">&nbsp;<b style="color:#888888;">GESTI&Oacute;N DE ANATOMIA</b></h5>
                <div class="content card-body">
                    <table class="table table-striped"  style="margin-bottom: 2px;margin-top: 2px;">
                        <tbody id="tabla_biopsia">
                            <tr>
                                <td width="50%">
                                    <small><b style="color:#888888;">FECHA DE CORTE</b></small><br>
                                    <small class="text-muted" id="nombreLabel6">
                                        <?php echo $cursor[":C_MAIN_AP"][0]["FECHA_FECHA_CORTE"]==''?'NO INFORMADO':$cursor[":C_MAIN_AP"][0]["FECHA_FECHA_CORTE"];?>
                                    </small>
                                </td>
                                <td width="50%">
                                    <small><b style="color:#888888;">TERMINO INFORME</b></small><br>
                                    <small class="text-muted" id="nombreLabel3">
                                        <?php
                                            $_arr_terminoinfo = $cursor[":C_TERMINOINFO"];
                                            echo count($_arr_terminoinfo)>0?"TERMINADO INFORMADO":"NO INFORMADO";
                                        ?>
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small><b style="color:#888888;">PATOLOGO</b></small><br>
                                    <small class="text-muted" id="nombreLabel3">
                                        <?php echo count($_arr_terminoinfo)>0?$_arr_terminoinfo[0]['NAME_PATOLOGO']:"NO INFORMADO"; ?>
                                    </small>
                                </td>
                                <td>
                                    <small><b style="color:#888888;">FECHA DE TERMINO</b></small><br>
                                    <small class="text-muted" id="nombreLabel3"><?php echo count($_arr_terminoinfo)>0?$_arr_terminoinfo[0]['DATE_FECHA_DIAGNOSTICO']:"NO INFORMADO"; ?></small>
                                </td>
                            <tr>
                            <tr style="<?php echo $cursor[":C_MAIN_AP"][0]['NUM_NOF_CANCER']==="1"?'':'display:none;';?>">
                                <td>
                                    <small><b style="color:#888888;">NOTIFICACI&Oacute;N</b></small><br>
                                    <small class="text-muted" id="txt_notificacionc"><?php echo $cursor[":C_MAIN_AP"][0]['IND_NOTF_CANCER']==1?'SI':'NO';?></small>
                                </td>
                                <td>
                                    <small><b style="color:#888888;">FECHA NOTIFICACI&Oacute;N</b></small><br>
                                    <small class="text-muted" id="date_notificacionc"><?php echo $cursor[":C_MAIN_AP"][0]['DATE_CANCER']==''?'SIN INFORMACI&Oacute;N':$cursor[":C_MAIN_AP"][0]['DATE_CANCER'];?></small>
                                </td>
                            <tr>
                        </tbody>
                    </table>
                </div>
            </div>    
            <!-- end GESTION DE ANATOMIA  --> 
    </div>

    <div class="grid_comunas_trazabilidada2">

            <!-- INFO GENERAL -->
            <div class="card grid_item" id="card_tiempos_anatomia_patologica" style="margin-bottom:5px">
                <h5 class="title" style=" margin: 0px;">&nbsp;<b style="color:#888888;">SOLICITUD</b></h5>
                <div class="content card-body">
                    <table class="table table-striped"  style="margin-bottom: 2px;margin-top: 2px;">
                        <tbody id="tabla_biopsia">
                            <tr>
                                <td width="100%">
                                    <small><b style="color:#888888;">TIPO DE BIOPSIA</b></small><br>
                                    <small class="text-muted" id="nombreLabel_1"><?php echo $cursor[":C_MAIN_AP"][0]["TIPO_DE_BIOPSIA"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%">
                                    <small><b style="color:#888888;">FECHA TOMA MUESTRA</b></small><br>
                                    <small class="text-muted" id="nombreLabel_0"><?php echo $cursor[":C_MAIN_AP"][0]["FECHA_TOMA_MUESTRA"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%">
                                    <small><b style="color:#888888;">SOLICITANTE</b></small>
                                    <br>
                                    <small class="text-muted" id="nombreLabel_3"><?php echo $cursor[":C_MAIN_AP"][0]["TXT_PROFESIONAL"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%">
                                    <small><b style="color:#888888;">SERVICIO</b></small><br>
                                    <small class="text-muted" id="nombreLabel_4"><?php echo $cursor[":C_MAIN_AP"][0]["NOMBRE_SERVICIO"];?></small>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%">
                                    <small><b style="color:#888888;">ORIGEN SISTEMA</b></small><br>
                                    <small class="text-muted" id="nombreLabel_5"><?php echo $cursor[":C_MAIN_AP"][0]["TXT_PROCEDENCIA"];?></<small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END INFO GENERAL -->

            <?php   if (count($cursor[":C_INFOPABELLON"])>0){ ?>
            <!-- ini GESTION DE ANATOMIA -->
                <div class="card grid_item" id="card_infopabellon" style="margin-bottom:5px">
                    <h5 class="title" style=" margin:0px;">&nbsp;<b style="color:#888888;">INFORMACI&Oacute;N DE PABELL&Oacute;N</b></h5>
                    <div class="content card-body">
                        ... WORKING 2 ... C_INFOPABELLON ... 
                    </div>
                </div>    
            <!-- end GESTION DE ANATOMIA  --> 
            <?php   }   ?>    

            <?php   if (count($cursor[":C_RCECLINICO"])>0){ ?>
                <div class="card grid_item" id="card_inforce" style="margin-bottom:5px">
                    <h5 class="title" style=" margin:0px;">&nbsp;<b style="color:#888888;">INFORMACI&Oacute;N DE AGENDA ESPECIALIDADES</b></h5>
                    <div class="content card-body">
                        ... WORKING 3 ... C_RCECLINICO ... 
                    </div>
                </div>
            <?php   }   ?>  

            <!-- LISTADO DE LAS MUESTRAS --> 
            <?php   if(count($cursor[":P_ANATOMIA_PATOLOGICA_MUESTRAS"])>0){ ?>
                <div class="card grid_item" id="card_tiempos_anatomia_patologica" style="margin-bottom:5px">
                    <h5 class="title" style=" margin: 0px;">
                        &nbsp;<b style="color:#888888;">MUESTRAS 
                        <?php if ($cursor[":C_MAIN_AP"][0]["IND_TIPO_BIOPSIA"] == '4'){
                            echo "BIOPSIA";
                        } else {  
                            echo $cursor[":C_MAIN_AP"][0]["TIPO_DE_BIOPSIA"]; } 
                        ?></b>
                    </h5>
                    <div class="grid_li_muestras">
                        <div class="grid_li_muestras1"><small><b style="color:#888888;">N&deg;&nbsp;UNICO</b></small><br></div>
                        <div class="grid_li_muestras3"><small><b style="color:#888888;">OBSERVACI&Oacute;N</b></small><br></div>
                    </div>
                    <ul class="list-group" style="margin-bottom: 0px;">
                        <?php foreach ($cursor[":P_ANATOMIA_PATOLOGICA_MUESTRAS"] as $i => $row){ ?>
                            <li class="list-group-item">
                                <div class="grid_li_muestras">
                                    <div class="grid_li_muestras1"><?php echo $row['ID_NMUESTRA'];?></div>
                                    <div class="grid_li_muestras3"><?php echo $row['TXT_MUESTRA'];?></div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php   }   ?>

            <!-- LISTADO DE LAS MUESTRAS --> 
            <?php   if(count($cursor[":P_AP_MUESTRAS_CITOLOGIA"])>0){  ?>
                <div class="card grid_item" id="card_tiempos_anatomia_patologica" style="margin-bottom:5px">
                    <h5 class="title" style=" margin: 0px;">&nbsp;<b style="color:#888888;">MUESTRAS CITOLOGICAS</b></h5>
                    <div class="grid_li_muestras">
                        <div class="grid_li_muestras1"><small><b style="color:#888888;">N&deg;&nbsp;UNICO</b></small><br></div>
                        <div class="grid_li_muestras3"><small><b style="color:#888888;">OBSERVACI&Oacute;N</b></small><br></div>
                    </div>
                    <ul class="list-group" style="margin-bottom: 0px;">
                        <?php foreach($cursor[":P_AP_MUESTRAS_CITOLOGIA"] as $i => $row){ ?>
                            <li class="list-group-item">
                                <div class="grid_li_muestras">
                                    <div class="grid_li_muestras1"><?php echo $row['ID_NMUESTRA'];?></div>
                                    <div class="grid_li_muestras3"><?php echo $row['TXT_MUESTRA'];?></div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php   }   ?>
            <!-- end LISTADO DE LAS MUESTRAS -->
    </div>
</div>
