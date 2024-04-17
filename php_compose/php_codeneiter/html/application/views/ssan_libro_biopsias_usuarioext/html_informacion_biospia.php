<?php 
    /*
        echo $this->input->get("externo");
        echo "<br>";
        echo $this->input->get("tk");
        echo "<br>";
        echo $this->input->get("id_anatomia");
        echo "<br>";
        echo $this->input->get("empresa");
    */
   #var_dump($cursor[':C_LOGS']);
?>
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
        grid-template-columns       :   1fr auto 1fr;
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
</style>

<?php if (count($cursor[':C_STATUS'])>0){ ?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Error en la solicitud</h4>
        <p>La petici&oacute;n de solicitud de anatom&iacute;a patol&oacute;gica no existe en los registros de SSAN. Si cree que existe alg&uacute;n error por favor comunicarse con departamento de inform&aacute;tica del servicios de salud Araucania Norte.</p>
        <hr>
        <p class="mb-0">Departamento de informatica <?php echo date("Y");?></p>
    </div>
<?php } else { ?>
    <?php
    $ind_habilitado     =   $cursor[':C_MAIN_AP'][0]["IND_ESTADO"];
    $ind_color          =   $ind_habilitado=="1"?"#87CB16":"#FB404B";
    ?>
    <div class="grid_cabecera_histo">
        <div class="grid_cabecera_histo1">
            <h4 style="margin: 0px 0px 0px0px;color:#e34f49;">
                <b>HISTORIAL DE SOLICITUD DE ANATOM&Iacute;A PATOL&Oacute;GICA</b>
            </h4>
        </div>
    </div>
    <div class="grid_visualizacion">
        <div class="grid_visualizacion1">&nbsp;</div>
        <div class="grid_visualizacion2">
            <div class="grid_card">
                
                <div class="grid_card1 card" style="">
                    <h6 class="title" style="margin: 0px 0px 0px 0px;padding:7px;">
                        <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">ESTADO SOLICITUD</b>
                    </h6>
                    <div class="grid_mas_icon">
                        <div class="grid_mas_icon1"><i class="<?php echo $ind_habilitado=="1"?"fa fa-check":"fa fa-times"?>"  style="color:<?php echo $ind_color;?>;" aria-hidden="true"></i></div>
                        <div class="grid_mas_icon2" style="text-align: justify;"><b style="color:<?php echo $ind_color;?>;"><?php echo $cursor[':C_MAIN_AP'][0]["TXT_ESTADO"];?></b></div>
                    </div>
                </div>
                
                <div class="grid_card2 card" style="">
                    <h6 class="title" style="margin: 0px 0px 0px 0px;padding:7px;">
                        <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">ULTIMA ACTUALIZACI&Oacute;N</b>
                    </h6>
                    <div class="grid_visualiza_simple">
                        <div class="grid_visualiza_simple1" style="text-align: justify;"><b style="color:#888888;"><?php echo $cursor[':C_MAIN_AP'][0]["LAST_DATE_AUDITA"]==''?'<b>SIN INFORMACI&Oacute;N</b>':$cursor[':C_MAIN_AP'][0]["LAST_DATE_AUDITA"];?></b></div>
                    </div>
                </div>
                
                <div class="grid_card3 card" style="<?php echo $ind_habilitado=="1"?"":"display:none";?>">
                    <h6 class="title" style="margin: 0px 0px 0px 0px;padding:7px;">
                        <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                        <b style="color:#888888;">ESTADO MUESTRAS</b>
                    </h6>
                    <div class="grid_visualiza_simple">
                        <div class="grid_visualiza_simple1" style="text-align: center;">
                            <h5>
                                <b style="color:#888888;"><?php echo $cursor[':C_MAIN_AP'][0]["TXT_HISTO_ESTADO"];?></b>
                            </h5>
                        </div>
                    </div>
                </div>
                
                <?php if(count($cursor[':C_CUSTODIA'])>0){ ?>
                    <div class="grid_card4 card" style="">
                        <h6 class="title" style="margin: 0px 0px 0px 0px;padding:7px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">USUARIO CUSDTODIA</b>
                        </h6>
                        <div class="grid_visualiza_simple">
                            <div class="grid_visualiza_simple1">
                                <b style="color:#888888;"><?php echo $cursor[':C_CUSTODIA'][0]["LAST_USERCUSTODIA"];?></b>
                            </div>
                            <div class="grid_visualiza_simple1" style="text-align: justify;">
                                <i><?php echo $cursor[':C_CUSTODIA'][0]["DATE_LAST_CUSTODIA"];?></i>
                            </div>
                        </div>
                    </div>
                <?php   } else { 
                    #echo "SIN CUSTODIA"; 
                }   ?>
                
                
                <?php   if(count($cursor[':C_TRASPORTE'])>0){ ?>
                    <div class="grid_card4 card" style="">
                        <h6 class="title" style="margin: 0px 0px 0px 0px;padding:7px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">USUARIO TRASPORTE</b>
                        </h6>
                        <div class="grid_visualiza_simple">
                            <div class="grid_visualiza_simple1"><b style="color:#888888;"><?php echo $cursor[':C_TRASPORTE'][0]["LAST_TRASPORTE"];?></b></div>
                            <div class="grid_visualiza_simple1" style="text-align: justify;">
                                <p style="margin:0px;">
                                    <i><?php echo $cursor[':C_TRASPORTE'][0]["DATE_LAST_TRASPORTE"];?></i>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php   } else {     
                    #echo "SIN TRASPORTE"; 
                }   ?>
                
                <?php if(count($cursor[':C_RECEPCION'])>0){ 
                    #echo "CON RECEPCION" 
                    ?>
                    <div class="grid_card4 card" style="">
                        <h6 class="title" style="margin: 0px 0px 0px 0px;padding:7px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">RECEPCI&Oacute;N</b>
                        </h6>
                        <div class="grid_visualiza_simple">
                            <div class="grid_visualiza_simple1">
                                <b style="color:#888888;"><?php echo $cursor[':C_RECEPCION'][0]["NAME_CONF_TRAS"];?></b>
                            </div>
                            <div class="grid_visualiza_simple1" style="text-align: justify;">
                                <i><?php echo $cursor[':C_RECEPCION'][0]["DATE_RECEPCION"];?></i>
                            </div>
                        </div>
                    </div>
                <?php   } else {     
                    #echo "SIN RECEPCION"; 
                }   ?>
                
                <?php if(count($cursor[':C_TERMINOINFO'])>0){ 
                    #echo "CON TERMINO" ;
                    ?>
                    <div class="grid_card5 card" style="">
                        <h6 class="title" style="margin: 0px 0px 0px 0px;padding:7px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">INFORME BIOPSIA</b>
                        </h6>
                        <div class="grid_visualiza_simple">
                            <div class="grid_visualiza_simple1">
                                <b style="color:#888888;"><?php echo $cursor[':C_TERMINOINFO'][0]["NAME_PATOLOGO"];?></b>
                            </div>
                            <div class="grid_visualiza_simple1" style="text-align: justify;">
                                <i><?php echo $cursor[':C_TERMINOINFO'][0]["DATE_FECHA_DIAGNOSTICO"];?></i>
                            </div>
                        </div>
                    </div>
                <?php  }  else {
                    #echo "SIN TERMINO"; 
                }?>
                
                <?php if(count($cursor[':C_TERMINOINFO_CITO'])>0){ 
                    #echo "CON TERMINO" ;
                    ?>
                    <div class="grid_card5 card" style="">
                        <h6 class="title" style="margin: 0px 0px 0px 0px;padding:7px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">INFORME CITOLOG&Iacute;CO</b>
                        </h6>
                        <div class="grid_visualiza_simple">
                            <div class="grid_visualiza_simple1">
                                <b style="color:#888888;"><?php echo $cursor[':C_TERMINOINFO_CITO'][0]["NAME_PATOLOGO_CITO"];?></b>
                            </div>
                            <div class="grid_visualiza_simple1" style="text-align: justify;">
                                <i><?php echo $cursor[':C_TERMINOINFO_CITO'][0]["DATE_FECHA_DIAGNOSTICO"];?></i>
                            </div>
                        </div>
                    </div>
                <?php  }  else {
                    #echo "SIN TERMINO"; 
                }?>
                
                <?php if(count($cursor[':C_NOTIFICACANCER'])>0){ 
                    #echo "CON CANCER TERMINO" ;
                    ?>
                    <div class="grid_card5 card" style="">
                        <h6 class="title" style="margin: 0px 0px 0px 0px;padding:7px;">
                            <i style="color:#888888;" class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;
                            <b style="color:#888888;">NOTIFICACI&Oacute;N CANCER</b>
                        </h6>
                        <div class="grid_visualiza_simple">
                            <div class="grid_visualiza_simple1">
                                <b style="color:#888888;">N&deg; MEMO : <i><?php echo $cursor[':C_NOTIFICACANCER'][0]['NUM_NOF_CANCER'];?></i></b>
                            </div>
                        </div>
                            <?php if ($cursor[':C_NOTIFICACANCER'][0]['IND_NOTIFICACANCER'] == '0') { ?>
                                <div class="grid_mas_icon">
                                    <div class="grid_mas_icon1"><i class="fa fa-times"  style="color:#FB404B;" aria-hidden="true"></i></div>
                                    <div class="grid_mas_icon2" style="text-align: justify;"><b style="color:#FB404B">NO NOTIFICADO</b></div>
                                </div>
                            <?php } else { ?>
                                <div class="grid_visualiza_simple">
                                    <div class="grid_visualiza_simple1">
                                        <b style="color:#888888;"><?php echo $cursor[':C_NOTIFICACANCER'][0]["NAME_NOTIFICADO"];?></b>
                                    </div>
                                    <div class="grid_visualiza_simple1" style="text-align: justify;">
                                        <i><?php echo $cursor[':C_NOTIFICACANCER'][0]["DATE_NOTIFICACANCER"];?></i>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php  }  else {
                    #echo "SIN CANCER "; 
                } ?>
            </div>
        </div> 
        <div class="grid_visualizacion3">&nbsp;</div> 
    </div>
<?php } ?>
