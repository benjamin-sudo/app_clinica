<?php
    function tapa_firma($firmaNew){
        $longitud = strlen($firmaNew); 
        if ($longitud > 3) {
            $ultimosTres = substr($firmaNew, -3);
            $asteriscos = str_repeat("*", $longitud - 3); 
            $firmaNew = $asteriscos . $ultimosTres; 
        } else {
            $firmaNew = $firmaNew;
        }
        return $firmaNew;
    }
    $firmaProcesada = tapa_firma($firma);
?>
<div class="row">
    <div class="col-md-12 text-center" id="miFirma">
        SU FIRMA UNICA ES : 
        <div style="font-size: 20px;font-weight: bold;">
            <b><?php echo $firmaProcesada;?></b>       
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="text-align:justify">
        FAVOR MANTENER SU FIRMA DIGITAL UNICA EN FORMA CONFIDENCIAL DEBIDO A QUE SU USO TIENE IMPLICANCIA LEGAL.
    </div>
</div>
<!--  style="display:none" -->
<div class="col-md-12" id="btnsFirma" style="text-align:-webkit-center;margin-top:10px;">
    <button type="button" class="btn btn-success  pull-left" onclick="confirmEnvioRecuperacion()"><i class="fa fa-envelope"></i> Recuperar</button>
    <button type="button" class="btn btn-info  pull-right" onclick="nuevaFirma()"><i class="fa fa-random"></i> Generar Nueva</button>
</div>