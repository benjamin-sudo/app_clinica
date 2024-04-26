<?php
$arr_li         =   array();
$arr_img        =   array();
$arr_media      =   array();
if(count($data_bd[":C_IMAGENES_BLOB"])>0){
    foreach($data_bd[":C_IMAGENES_BLOB"] as $i => $row){
        $class_act      =   $i==0?'class="active"':'';
        $arr_li[]       =   '<li data-target="#carousel_example_generic_analitica" data-slide-to="'.$i.'" '.$class_act.'></li>';
        $class          =   $i==0?'active':'';
        $arr_img[]      =   '<div class="item '.$class.' d-flex justify-content-center">'
                                .   '<div class="grid_img_btn">'
                                    .   '<div class="grid_img_btn1">'
                                        .   '<img src="'.$row["IMG_DATA"].'" alt="'.$i.'" class="d-block w-100 img-thumbnail">'
                                        .   '<div class="carousel-caption">'.$row["NAME_IMG"].'</div>'
                                    .   '</div>'
                                    .   '<div class="grid_img_btn2">
                                            <button type="button" class="btn btn-xs btn-danger btn-fill" id="btn_exel_final" onclick="delete_img_x_main({img:'.$row["ID_UNICO_IMAGEN"].',id:'.$num_anatomia.'})">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>'
                                    .   '</div>'
                                .   '</div>'
                        .   '</div>';
    }
    ?>
    <div class="grid_visualiza_img_analitica_botones">
        <div class="grid_visualiza_img_analitica_botones1">
            <div class="btn-group">
                <button type="button" class="btn btn-info btn-fill " id="btn_img_previus" onclick="$(&quot;#carousel_example_generic_analitica&quot;).carousel(&quot;prev&quot;);">
                    <i class="fa fa-backward" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-default btn-fill " id="btn_img_pause" onclick="$(&quot;#carousel_example_generic_analitica&quot;).carousel(&quot;pause&quot;);">
                    <i class="fa fa-pause" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-primary btn-fill " id="btn_img_play" onclick="$(&quot;#carousel_example_generic_analitica&quot;).carousel(&quot;cycle&quot;);">
                    <i class="fa fa-play" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-info btn-fill " id="btn_img_next" onclick="$(&quot;#carousel_example_generic_analitica&quot;).carousel(&quot;next&quot;);">
                   <i class="fa fa-forward" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="grid_visualiza_img_analitica">
        <div class="grid_visualiza_img_analitica1"></div>
        <div class="grid_visualiza_img_analitica2 carousel slide" id="carousel_example_generic_analitica" data-ride="carousel">
            <ol class="carousel-indicators"><?php echo implode("",$arr_li);?></ol>
            <div class="carousel-inner" role="listbox"><?php echo implode("",$arr_img);?></div>
        </div>
        <div class="grid_visualiza_img_analitica3"></div>
    </div>
<?php } else {?>
    <div id="sin_img" style="text-align:center;">
        <i class="fa fa-times" aria-hidden="true" style="color:#888888;"></i>&nbsp;<b style="color:#888888;">SIN IMAGENES CARGADAS</b>
    </div>
<?php } ?>

<script>
    $('#carousel_example_generic_analitica').carousel({interval:2000});
    $('#carousel_example_generic_analitica').on('slide.bs.carousel',function(){
        //console.log("do something   ->  ",this);
    });
</script>    