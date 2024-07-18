<?php   if ($DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['CLOB_FIRMA'] == ''){ ?>
    <table style="width:100%;margin-bottom:15px">
       <tbody>
           <tr>
               <td style="width:100%;text-align: center"><h4>DR: <?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_USER_PATOLOGO'];?></h4></td>
           </tr>
           <tr>
               <td style="width:100%;text-align: center"><h4>ANATOMO PATOLOGO</h4></td>
           </tr>
       </tbody>
    </table>
<?php   }   else    {   ?>
    <table style="width:100%;margin-bottom:0px;" >
        <tbody>
            <tr>
                <td style="width: 10%;text-align: right;"> 
                    <img 
                        alt                     =   "64x64" 
                        class                   =   "img-thumbnail" 
                        data-src                =   "64x64" 
                        src                     =   "/assets/ssan_libro_biopsias_usuarioext/img/logo_<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['COD_EMPRESA_DERIVADA'];?>.png" 
                        data-holder-rendered    =   "true" 
                        style                   =   "width:90px;height:90px;margin:0px 0px 0px 0px">
                </td>
                <td style="width: 40%;text-align: center">
                    <img 
                        alt                     =   "200x110" 
                        class                   =   "img-thumbnail" 
                        data-src                =   "200x110" 
                        src                     =   "<?php echo $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['CLOB_FIRMA'];?>" 
                        data-holder-rendered    =   "true" 
                        style                   =   "width:200px;height:75px;">
                   
                </td>
                <td style="width: 40%;text-align: center">
                    <table style="width:100%">
                        <tr>
                            <td style="width:30%;">
                                <barcode type="QR" class="barcode" code="https://www.esissan.cl/validador?p=<?php echo $code_doc_patologo?>"  size="0.5" text="0.5" />
                            </td>
                            <td style="width:70%;vertical-align:top;text-align:left;;">
                                <b style="font-size:13px;">FIRMA DIGITAL DE:</b>
                                <br>    
                                <span style="font-size:13px;">
                                    <?php echo $cadenaModificada = str_replace("#","<br>", $DATA['P_ANATOMIA_PATOLOGICA_MAIN'][0]['TXT_USER_PATOLOGO']);?>
                                </span>
                            </td> 
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
     </table>
<?php   }   ?>

