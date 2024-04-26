<div class="grid_panel_plantillas">
    <div class="grid_panel_plantillas1">
        <div class="card" style="padding:8px;">
            <i class="fa fa-list" style="color:#888888;" aria-hidden="true"></i>
            <b style="color:#888888;">&nbsp;N&deg;&nbsp;PLANTILLAS</b>
            <br>
            <div style="padding:0px;">
                <ul class="list-group" style="padding:0px;margin-bottom: 0px;" id="ul_resultado_plantillas">
                    <?php echo $this->load->view("ssan_libro_etapaanalitica/html_gestor_li_plantillas",[],true);?>
                </ul>
            </div>
        </div>
    </div> 
    <div class="grid_panel_plantillas2">
        <div class="card" style="padding:8px;">
            <b style="color:#888888;">&nbsp;N&deg; MUESTRA</b>
            <br>
            <textarea 
                class               =   "form-control input-sm " 
                name                =   "txt_descipcion_enplantilla" 
                id                  =   "txt_descipcion_enplantilla" 
                maxlength           =   "4000" 
                oninput             =   "js_auto_grow(this)"
                onkeyup             =   ""><?php echo $txt_muestra;?></textarea>
        </div>
    </div> 
</div>

<script>
    $(document).ready(function(){
        setTimeout(function(){ 
            autosize($('#txt_descipcion_enplantilla'));  
        },500);
    });
</script>