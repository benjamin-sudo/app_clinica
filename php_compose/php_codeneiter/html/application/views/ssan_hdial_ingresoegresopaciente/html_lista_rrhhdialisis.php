<?php 
    #var_dump($bd[":C_RESULT_RRHH"])
    $arr_medicos        =   array();
    $arr_enfermeros     =   array();
    $arr_tns            =   array();
    if(count($bd[":C_RESULT_RRHH"])>0){
        foreach ($bd[":C_RESULT_RRHH"] as $aux => $row){
            if($row['HTML_OUT']     ==  "slc_medico")       {   array_push($arr_medicos,$row);      }
            if($row['HTML_OUT']     ==  "slc_enfermeria")   {   array_push($arr_enfermeros,$row);   }
            if($row['HTML_OUT']     ==  "slc_tecpara")      {   array_push($arr_tns,$row);          }
        }
    }
?>










<ul class="nav nav-tabs" id="myTab2" role="tablist">
    <li role="presentation" class="active"><a data-toggle="tab" href="#ind_medicos">MEDICOS</a></li>
    <li role="presentation"><a data-toggle="tab" href="#ind_enfermero">ENFERMEROS</a></li>
    <li role="presentation"><a data-toggle="tab" href="#ind_tns">TECNICOS PARAMEDICOS</a></li>
    <li role="presentation" class="dropdown" id="dropdown_opcionesgen">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;<span class="caret"></span></a>
        <ul class="dropdown-menu pull-center">
            <li class="dropdown-header" style="border-left:1px solid #ececec;">&nbsp;</li>
            <li class="dropdown-header" style="border-left:1px solid #ececec;">&nbsp;ACCI&Oacute;N DE AGENDA APS</li>
            <li class="dropdown-header" style="border-left:1px solid #ececec;"><a href="javascript:js_busqueda_rrhh(2)"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;ACTUALIZACI&Oacute;N RRHH</a></li>
        </ul>
    </li>
</ul>

<div class="tab-content">
    <div id="ind_medicos" class="tab-pane fade in active">
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
                                    <button type="button" class="btn btn-danger btn-fill" id="BTN_UPDATE_PANEL_1" onclick="delete_profesional(<?php echo $row["COD_RUTPRO"];?>)">
                                       <i class="fa fa-user-times" aria-hidden="true"></i>
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
    <div id="ind_enfermero" class="tab-pane fade">
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
                                    <button type="button" class="btn btn-danger btn-fill" id="BTN_UPDATE_PANEL_1" onclick="delete_profesional(<?php echo $row["COD_RUTPRO"];?>)">
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
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
    <div id="ind_tns" class="tab-pane fade">
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
                            <tr style="height: 40px">
                                <td><?php echo $aux+1;?></td>
                                <td><?php echo $row["COD_RUTPRO"]."-".$row["COD_DIGVER"];?></td>
                                <td><?php echo $row["NOM_PROFE"]?></td>
                                <td><?php echo $row["DES_TIPOATENCION"]?></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-fill" id="BTN_UPDATE_PANEL_1" onclick="delete_profesional(<?php echo $row["COD_RUTPRO"];?>)">
                                        <i class="fa fa-user-times" aria-hidden="true"></i>
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