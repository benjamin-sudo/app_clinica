<div class="grid_firma_patologo_body">
    <div class="grid_firma_patologo_body1">
        <h4 style="margin: 0px 0px 0px 0px">Subir imagen firma</h4>
        <hr>
        <input 
            type            =   "file" 
            class           =   "form-control input-sm" 
            name            =   "adjunto_firma" 
            id              =   "adjunto_firma" 
            style           =   "cursor:pointer;display:block"  
            onchange        =   "js_adjunto_firma(this.files)">
    </div>
    <div class="grid_firma_patologo_body3 img_gestion" style="text-align: -webkit-center;">
       <div class="card" style="margin-bottom:0px;padding:8px;width:200px" id="imagen_sala_macroscopia">
            <div style="background-color:transparent !important; text-align:center">
                <div class="font_15"><b class="class_txt_macroscopia">IMAGEN NO CARGADA</b></div>
            </div>
            <hr style="margin-top:10px;margin-bottom:10px">
            <div class="flex_box_center">
                <label class="custom-file-label pointer" for="imagen_macroscopia_804">
                    <i class="fa fa-file-image-o fa-4x class_txt_macroscopia" aria-hidden="true"></i>
                </label>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        <?php echo isset($C_DATA_FIRMA[0]["IMG_DATA"])?"js_img_data('".$C_DATA_FIRMA[0]["IMG_DATA"]."');":"js_img_default();";?>
    });
</script>
