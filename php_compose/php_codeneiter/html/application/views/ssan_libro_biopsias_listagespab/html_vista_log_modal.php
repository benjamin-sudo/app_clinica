<!--
<?php
    var_dump($data_crud);
?>
<?php
    var_dump($rn_ordenado);
?>
-->

<ul class="list-group" style="margin-bottom: 0px;">
    <?php
        if (count($rn_ordenado)>0){
            foreach ($rn_ordenado as  $aux => $row){ ?>
                <li class="list-group-item">  
                    <div class="grid_log_gespab">
                        <div class="grid_log_gespab1"><span class="label label-<?php echo $row["IND_COLOR"];?>"><?php echo $row["TXT_FASE"];?></span></div>
                        <div class="grid_log_gespab2">
                            <?php echo $row["TXT_EDITA"];?>
                            -
                            <?php echo $row["TXT_USER"];?>
                        </div>
                        <div class="grid_log_gespab3" style="text-align:end"><?php echo $row["FECHA_CREACION_LOG"];?></div>
                    </div>
                </li>
            <?php 
            }
        }
    ?>
</ul>