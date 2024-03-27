<?php 
    $arr_medicos = array();
    $arr_enfermeros = array();
    $arr_tns = array();
    if(count($bd[":C_RESULT_RRHH"])>0){
        foreach ($bd[":C_RESULT_RRHH"] as $aux => $row){
            if($row['HTML_OUT'] == "slc_medico")       { array_push($arr_medicos,$row); }
            if($row['HTML_OUT'] == "slc_enfermeria")   { array_push($arr_enfermeros,$row); }
            if($row['HTML_OUT'] == "slc_tecpara")      { array_push($arr_tns,$row); }
        }
    }
?>
<ul class="nav nav-tabs" id="recurso_humano_dialisis" role="tablist" style="margin-top: 10px;">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="ind_medicos-tab" data-bs-toggle="tab" data-bs-target="#ind_medicos" type="button" role="tab" aria-controls="ind_medicos" aria-selected="true">MEDICOS</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="ind_enfermero-tab" data-bs-toggle="tab" data-bs-target="#ind_enfermero" type="button" role="tab" aria-controls="ind_enfermero" aria-selected="false">ENFERMEROS</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="ind_tns-tab" data-bs-toggle="tab" data-bs-target="#ind_tns" type="button" role="tab" aria-controls="ind_tns" aria-selected="false">TECNICOS PARAMEDICOS</button>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">&nbsp;&nbsp;ACTUALIZACI&Oacute;N</a>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="javascript:js_busqueda_rrhh(2)">
                    <i class="bi bi-wrench-adjustable"></i>&nbsp;&nbsp;ACTUALIZACI&Oacute;N&nbsp;LISTA
                </a>
            </li>
        </ul>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="ind_medicos" role="tabpanel" aria-labelledby="ind_medicos-tab" tabindex="0">
        <h4 style="margin-top: 8px;"><b>LISTADO MEDICOS DE DI&Aacute;LISIS</b></h4>
        <table class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th class="subtitulo_formulario2" width="10%">N&deg;</th>
                    <th class="subtitulo_formulario2" width="15%">RUN</th>
                    <th class="subtitulo_formulario2" width="30%">NOMBRE PROFESIONAL</th>
                    <th class="subtitulo_formulario2" width="30%">ESPECIALIDAD</th>
                    <th class="subtitulo_formulario2" width="15%">OPCI&Oacute;N</th>
                </tr>
            </thead>
            <tbody id="lista_medicos_dialisis">
                <?php
                    if (count($arr_medicos)>0){
                        foreach ($arr_medicos as $aux => $row){ ?>
                            <tr style="height: 40px">
                                <td><?php echo $aux+1;?></td>
                                <td><?php echo $row["COD_RUTPRO"]."-".$row["COD_DIGVER"];?></td>
                                <td><?php echo $row["NOM_PROFE"]?></td>
                                <td><?php echo $row["DES_TIPOATENCION"]?></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-xs" id="BTN_UPDATE_PANEL_1" onclick="delete_profesional(<?php echo $row['COD_RUTPRO'];?>)">
                                        <i class="bi bi-person-fill-x" aria-hidden="true"></i>&nbsp;&nbsp;ELIMINAR PROFESIONAL
                                    </button>
                                </td>
                            </tr>
                       <?php }
                    } else {    ?>
                        <tr><td colspan="5" style="text-align: center;height:40px"><b>SIN INFORMACI&Oacute;N</b></td></tr>
                    <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="ind_enfermero" role="tabpanel" aria-labelledby="ind_enfermero-tab" tabindex="0">
        <h4 style="margin-top: 8px;"><b>LISTADO ENFERMEROS DE DI&Aacute;LISIS</b></h4>
        <table class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th class="subtitulo_formulario2" width="10%">N&deg;</th>
                    <th class="subtitulo_formulario2" width="15%">RUN</th>
                    <th class="subtitulo_formulario2" width="30%">NOMBRE PROFESIONAL</th>
                    <th class="subtitulo_formulario2" width="30%">ESPECIALIDAD</th>
                    <th class="subtitulo_formulario2" width="15%">OPCI&Oacute;N</th>
                </tr>
            </thead>
            <tbody id="lista_medicos_dialisis">
                <?php
                    if (count($arr_enfermeros)>0){
                        foreach ($arr_enfermeros as $aux => $row){ ?>
                            <tr style="height: 40px">
                                <td><?php echo $aux+1;?></td>
                                <td><?php echo $row["COD_RUTPRO"]."-".$row["COD_DIGVER"];?></td>
                                <td><?php echo $row["NOM_PROFE"]?></td>
                                <td><?php echo $row["DES_TIPOATENCION"]?></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-xs" id="BTN_UPDATE_PANEL_1" onclick="delete_profesional(<?php echo $row['COD_RUTPRO'];?>)">
                                        <i class="bi bi-person-fill-x" aria-hidden="true"></i>&nbsp;&nbsp;ELIMINAR PROFESIONAL
                                    </button>
                                </td>
                            </tr>
                       <?php }
                    } else {    ?>
                        <tr><td colspan="5" style="text-align: center;height:40px">SIN INFORMACI&Oacute;N</td></tr>
                    <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="ind_tns" role="tabpanel" aria-labelledby="ind_tns-tab" tabindex="0">
        <h4 style="margin-top: 8px;"><b>LISTADO TECNICO PARAMEDICOS DE DI&Aacute;LISIS</b></h4>
        <table class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th class="subtitulo_formulario2" width="10%">N&deg;</th>
                    <th class="subtitulo_formulario2" width="15%">RUN</th>
                    <th class="subtitulo_formulario2" width="30%">NOMBRE PROFESIONAL</th>
                    <th class="subtitulo_formulario2" width="30%">ESPECIALIDAD</th>
                    <th class="subtitulo_formulario2" width="15%">OPCI&Oacute;N</th>
                </tr>
            </thead>
            <tbody id="lista_medicos_dialisis">
                <?php
                    if (count($arr_tns)>0){
                        foreach ($arr_tns as $aux => $row){ ?>
                            <tr style="height:40px">
                                <td><?php echo $aux+1;?></td>
                                <td><?php echo $row["COD_RUTPRO"]."-".$row["COD_DIGVER"];?></td>
                                <td><?php echo $row["NOM_PROFE"]?></td>
                                <td><?php echo $row["DES_TIPOATENCION"]?></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-xs" id="BTN_UPDATE_PANEL_1" onclick="delete_profesional(<?php echo $row['COD_RUTPRO'];?>)">
                                        <i class="bi bi-person-fill-x" aria-hidden="true"></i>&nbsp;&nbsp;ELIMINAR PROFESIONAL
                                    </button>
                                </td>
                            </tr>
                       <?php }
                    } else {    ?>
                        <tr><td colspan="5" style="text-align: center;height:40px">SIN INFORMACI&Oacute;N</td></tr>
                    <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>