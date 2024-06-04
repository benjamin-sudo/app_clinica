<?php
    #generador codigo qr para ver la solicitud
    #$this->load->library('Codeqr');
    $array_post                         =   [];
    $raw2                               =   '';
    array_push($array_post,"externo=true");
    array_push($array_post,"tk=".md5($id_histo));
    $rul_for_qr                         =   (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/ssan_libro_biopsias_usuarioext?".join("&",$array_post);
?>
<div class="barcodecell">
    <barcode  class="barcode" code="<?php echo $rul_for_qr;?>" type="QR" height="0.5" text="1"  size="1.7"/>
</div>

