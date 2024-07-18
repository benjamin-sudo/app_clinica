<a href="javascript:void(0);" class="list-group-item" id="li_<?php echo $num;?>" >
    <div class="grid_listadomaquixpac">
        <div class="grid_listadomaquixpac1"><?php echo $num;?></div>
        <div class="grid_listadomaquixpac2">
            <h5 class="mb-1"><?php echo $row['NOMDIAL'];?></h5>
            <p class="mb-1"><b><?php echo $row['SERIE'];?>, <?php echo $row['NUM_LORE'];?></b></p>
        </div>
        <div class="grid_listadomaquixpac3">
            <span class="badge bg-success" style="padding: 10px;"><?php echo $row['TXTESTADO'];?></span>
        </div>
        <div class="grid_listadomaquixpac3" style="text-align: center;">
            <button type="button" class="btn btn-primary position-relative" style="display:none"  id="num_pacientes_<?php echo $num;?>">N&deg; DE PACIENTES EN MAQUINA
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="txt_pacientes_<?php echo $num;?>">0
                <span class="visually-hidden"></span></span>
            </button>
        </div>
        <div class="grid_listadomaquixpac4" style="text-align: end;">
            <div class="btn-group dropstart">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">OPCIONES</button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                    <b class="dropdown-item"  data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $num;?>" aria-expanded="false" aria-controls="collapse_<?php echo $num;?>">
                        GESTI&Oacute;N CUPOS DE PACIENTES POR MAQUINA
                    </b>
                </ul>
            </div>
        </div>
    </div>
    <div class="collapse" id="collapse_<?php echo $num;?>">
        <div class="card card-body" style="margin-bottom: 0px;">
            <?php $MKN = $row['ID']; ?>
            <table class="table table-striped table-sm" style="width:100%">
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align:center"> 
                            <i class="fa fa-wheelchair" aria-hidden="true"></i><b>- GRUPO 1 (LUNES - MIERCOLES - VIERNES)</b>
                            &nbsp;
                            <input type="hidden" id="MKN_<?php echo $MKN;?>_1" name="MKN_<?php echo $MKN;?>_1" value="0"/>
                            <input type="hidden" id="MKN_<?php echo $MKN;?>_1" name="MKN_<?php echo $MKN;?>_1" value="2"/>
                            <input type="hidden" id="MKN_<?php echo $MKN;?>_1" name="MKN_<?php echo $MKN;?>_1" value="4"/>
                        </td>
                        <td colspan="2" style="text-align:center"> 
                            <i class="fa fa-wheelchair" aria-hidden="true"></i><b>- GRUPO 2 (MARTES - JUEVES - SABADO)</b>
                            &nbsp;
                            <input type="hidden" id="MKN_<?php echo $MKN;?>_2" name="MKN_<?php echo $MKN;?>_2" value="1"/>
                            <input type="hidden" id="MKN_<?php echo $MKN;?>_2" name="MKN_<?php echo $MKN;?>_2" value="3"/>
                            <input type="hidden" id="MKN_<?php echo $MKN;?>_2" name="MKN_<?php echo $MKN;?>_2" value="5"/>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:10%;text-align:center"><b>-HOJA 1</b></td>
                        <td style="width:40%;text-align:left">
                            <div id="CUPO_<?php echo $MKN;?>_1">
                                <a class="btn btn-success " href="javascript:asigarCupo(<?php echo $MKN;?>,1,1)" style="width: -webkit-fill-available;">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 1
                                </a>
                            </div>
                        </td>
                        <td style="width:10%;text-align:center"><b>-HOJA 1</b></td>
                        <td style="width:40%;text-align:left">
                            <div id="CUPO_<?php echo $MKN;?>_4">
                                <a class="btn btn-success " href="javascript:asigarCupo(<?php echo $MKN;?>,4,2)" style="width: -webkit-fill-available;">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 1
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center"><b>-HOJA 2</b></td>
                        <td style="text-align:left">
                            <div id="CUPO_<?php echo $MKN;?>_2">
                                <a class="btn btn-success " href="javascript:asigarCupo(<?php echo $MKN;?>,2,1)" style="width: -webkit-fill-available;">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 2 
                                </a>
                            </div>    
                        </td>
                        <td style="text-align:center"><b>-HOJA 2</b></td>
                        <td style="text-align:left">
                            <div id="CUPO_<?php echo $MKN;?>_5">
                                <a class="btn btn-success" href="javascript:asigarCupo(<?php echo $MKN;?>,5,2)" style="width: -webkit-fill-available;">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 2
                                </a>
                            </div>    
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center"><b>-HOJA 3</b></td>
                        <td style="text-align:left">
                            <div id="CUPO_<?php echo $MKN;?>_3">
                                <a class="btn btn-success" href="javascript:asigarCupo(<?php echo $MKN;?>,3,1)" style="width: -webkit-fill-available;">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 3 
                                </a>
                            </div>
                        </td>
                        <td style="text-align:center"><b>-HOJA 3</b></td>
                        <td style="text-align:left">
                            <div id="CUPO_<?php echo $MKN;?>_6">
                                <a class="btn btn-success" href="javascript:asigarCupo(<?php echo $MKN;?>,6,2)" style="width: -webkit-fill-available;">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 3 
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center"><b>-HOJA 4</b></td>
                        <td style="text-align:left">
                            <div id="CUPO_<?php echo $MKN;?>_7">
                                <a class="btn btn-success" href="javascript:asigarCupo(<?php echo $MKN;?>,7,1)" style="width: -webkit-fill-available;">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 4 
                                </a>
                            </div>
                        </td>
                        <td style="text-align:center"><b>-HOJA 4</b></td>
                        <td style="text-align:left">
                            <div id="CUPO_<?php echo $MKN;?>_8">
                                <a class="btn btn-success" href="javascript:asigarCupo(<?php echo $MKN;?>,8,2)" style="width: -webkit-fill-available;">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 4 
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php
            if (count($pac)>0){
                $aux = 0;
                echo "<script>$('#num_pacientes_$num').show();";
                foreach($pac as $i => $row){
                    echo "$('#".$row['value']."').html(`".$row['html']."`);";
                    $aux++;
                }
                echo "$('#txt_pacientes_$num').html('$aux')</script>";
            }
            ?>
        </div>
    </div>
</a>