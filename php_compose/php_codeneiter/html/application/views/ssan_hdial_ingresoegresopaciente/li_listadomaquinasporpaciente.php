<a href="#" class="list-group-item list-group-item-action" id="li_<?php echo $num;?>">
    <div class="grid_listadomaquixpac">
        <div class="grid_listadomaquixpac1"><?php echo $num;?></div>
        <div class="grid_listadomaquixpac2">
            <h5 class="mb-1"><?php echo $row['NOMDIAL'];?></h5>
            <p class="mb-1"><b><?php echo $row['SERIE'];?></b></p>
            <small class="text-muted"><?php echo $row['NUM_LORE'];?></small>
        </div>
        <div class="grid_listadomaquixpac3">
            <?php echo $row['TXTESTADO'];?>
        </div>
        <div class="grid_listadomaquixpac3" style="text-align: center;">
            <b>LISTADO DE PACIENTES ASIGNADO A MAQUINA</b>
            <div class="grid_gestor_cupos">
                <div class="grid_gestor_cupos1">&nbsp;</div>
                <div class="grid_gestor_cupos2">&nbsp;</div>
            </div>
        </div>
        <div class="grid_listadomaquixpac4" style="text-align: end;">
            <div class="btn-group dropstart">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    OPCIONES
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                    <b class="dropdown-item"  data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $num;?>" aria-expanded="false" aria-controls="collapse_<?php echo $num;?>">
                        HOJAS HEMODIALISIS X MAQUINA
                    </b>
                </ul>
            </div>
        </div>
    </div>
</a>
<div class="collapse" id="collapse_<?php echo $num;?>">
    <div class="card card-body no-top-border-radius">
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
                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(<?php echo $MKN;?>,1,1)" style="width: 340px;">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 1
                            </a>
                        </div>
                    </td>
                    <td style="width:10%;text-align:center"><b>-HOJA 1</b></td>
                    <td style="width:40%;text-align:left">
                        <div id="CUPO_<?php echo $MKN;?>_4">
                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(<?php echo $MKN;?>,4,2)" style="width: 340px;">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 1
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center"><b>-HOJA 2</b></td>
                    <td style="text-align:left">
                        <div id="CUPO_<?php echo $MKN;?>_2">
                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(<?php echo $MKN;?>,2,1)" style="width: 340px;">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 2 
                            </a>
                        </div>    
                    </td>
                    <td style="text-align:center"><b>-HOJA 2</b></td>
                    <td style="text-align:left">
                        <div id="CUPO_<?php echo $MKN;?>_5">
                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(<?php echo $MKN;?>,5,2)" style="width: 340px;">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 2
                            </a>
                        </div>    
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center"><b>-HOJA 3</b></td>
                    <td style="text-align:left">
                        <div id="CUPO_<?php echo $MKN;?>_3">
                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(<?php echo $MKN;?>,3,1)" style="width: 340px;">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 3 
                            </a>
                        </div>
                    </td>
                    <td style="text-align:center"><b>-HOJA 3</b></td>
                    <td style="text-align:left">
                        <div id="CUPO_<?php echo $MKN;?>_6">
                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(<?php echo $MKN;?>,6,2)" style="width: 340px;">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 3 
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center"><b>-HOJA 4</b></td>
                    <td style="text-align:left">
                        <div id="CUPO_<?php echo $MKN;?>_7">
                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(<?php echo $MKN;?>,7,1)" style="width: 340px;">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 4 
                            </a>
                        </div>
                    </td>
                    <td style="text-align:center"><b>-HOJA 4</b></td>
                    <td style="text-align:left">
                        <div id="CUPO_<?php echo $MKN;?>_8">
                            <a class="btn btn-success btn-sm btn-fill btn-wd" href="javascript:asigarCupo(<?php echo $MKN;?>,8,2)" style="width: 340px;">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> AGREGAR PACIENTE TURNO 4 
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>



    </div>
</div>