<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo base_url();?>assets/themes/inicio/css/boobtstrap.css" rel="stylesheet"></link>
        <title>INFORME MACROSCOPIA - IMAGENES</title>
        <style>
            @page {
                margin      :   0px 0px 0px 0px !important;
                padding     :   0px 0px 0px 0px !important;
            }
        </style>
    </head>
    <body>
        
        <?php
            if(count($DATA['C_IMAGENES_BLOB'])>0){
                foreach ($DATA['C_IMAGENES_BLOB'] as $i => $row){
                    echo $row['IMG_DATA'].'<br>';
        ?>            
                
        
        <?php
                }
            }
        ?>
        
    <!--
        <p><?php echo $DATA["P_GESTOR_OBJECT_ADJUNTO"][$NUM_PAG]["NAME_IMG"]; ?></p>
        <img src="<?php echo $DATA["P_GESTOR_OBJECT_ADJUNTO"][$NUM_PAG]["IMG_DATA"]?>" alt="Red dot" />
    -->            
        
    </body>
</html>