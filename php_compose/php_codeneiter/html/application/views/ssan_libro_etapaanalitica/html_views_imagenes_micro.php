<div class="grid_panel_imagenesxap">
    <div class="grid_panel_imagenesxap1"> 
        <div class="card" style="margin-bottom:0px;padding:8px;" id="imagen_sala_macroscopia">
            <div style="background-color:transparent !important; text-align:center"><div class="font_15"><b class="class_txt_macroscopia">SUBIR</b></div></div>
            <hr style="margin-top:10px;margin-bottom:10px">
            <div class="flex_box_center">
                <label class="custom-file-label pointer" for="imagen_macroscopia_<?php echo $num_anatomia;?>">
                    <i class="fa fa-cloud-upload fa-4x class_txt_macroscopia" aria-hidden="true"></i>
                </label>
                <input 
                    type            =   "file" 
                    class           =   "grupo_descipcion_general" 
                    data-get_sala   =   "salamacroscopia" 
                    id              =   "imagen_macroscopia_<?php echo $num_anatomia;?>" 
                    onchange        =   "main_js_adjunto_ap(<?php echo $num_anatomia;?>,this.files)"/>
            </div>
        </div>
        <hr>
        <div style="text-align:center">
            <button type="button" class="btn btn-primary btn-fill" id="btn_update_img" onclick="js_update_img(<?php echo $num_anatomia;?>)">
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="grid_panel_imagenesxap2 update_img_microscopia">
        <?php echo $this->load->view("ssan_libro_etapaanalitica/html_views_imagenes_carrusel",[],true); ?>
    </div>
    <div class="grid_panel_imagenesxap3">&nbsp;</div>
</div>
                                              