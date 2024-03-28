<div class="card">
    <div class="card-header">
        <b>INGRESO DE ENFERMERIA</b>
        <br>
        <i>Unidad de Hemodiálisis</i>
    </div>
    <div class="card-body">
        <div class="grid_ingreso_enfermeria">
            <div class="card-header featured-header" style="margin-top:-15px;">
                <b>1. ANTECEDENTES PERSONALES</b>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Antecedentes Quirúrgicos:
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_antecedente_qx" value="" required="">
            </div>
            <div class="grid_ingreso_enfermeria1">
                Antecedentes Al&eacute;rgicos:
            </div>
            <div class="grid_ingreso_enfermeria2">
                <select class="form-select" aria-label="Seleccione ..." id="ingreso_enfe_antenecentealergia" onclick="js_cambio_atencedentes()">
                    <option value="">Seleccione ... </option>
                    <option value="1">Si</option>
                    <option value="2">No</option>
                    <option value="3">No Sabe</option>
                </select>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Alimentos
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_alimento_alergia"  required="" disabled value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Medicamentos
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_medicamento_alergia"  required="" disabled value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Otros
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_otro_alergia"  required="" disabled value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Diagnóstico de ingreso:
            </div>
            <div class="grid_ingreso_enfermeria2">
                <b>PENDIENTE (UNO A MUCHO)</b>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Establecimiento al que se deriva en caso de urgencia	
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_persona_urgencia" required="" disabled value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Grupo sanguíneo:
            </div>
            <div class="grid_ingreso_enfermeria2">
                <select name="cboGrupoSangre" id="cboGrupoSangre" class="form-select">
                    <option value="">SELECCIONE...</option>
                    <option value="NS">NO SABE</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Grupo sanguíneo:
            </div>
            <div class="grid_ingreso_enfermeria2">
                <select name="cboGrupoSangre" id="cboGrupoSangre" class="form-select">
                    <option value="">SELECCIONE...</option>
                    <option value="NS">NO SABE</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Factor Sangre	
            </div>
            <div class="grid_ingreso_enfermeria2">
                <select name="cboFactorSangre" id="cboFactorSangre" class="form-select">
                    <option value="">SELECCIONE...</option>
                    <option value="NS">NO SABE</option>
                    <option value="1">RH(+)</option>
                    <option value="0">RH(-)</option>
                </select>
            </div>
            <div class="card-header featured-header" style="margin-top:-5px;">
                <b>2. EXAMEN FISICO GENERAL</b>
            </div>
            <div class="featured-header">
                <div class="grid_unoxcuatro">
                    <div class="grid_unoxcuatro1">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Peso</span>
                            <input type="text" class="form-control" placeholder="kg" aria-label="kg" id="num_kilogramos" >
                        </div>
                    </div>
                    <div class="grid_unoxcuatro2">
                        <div class="input-group mb-3">
                            <span class="input-group-text">FC</span>
                            <input type="text" class="form-control" placeholder="mn" aria-label="mn" id="num_frecuenciacardiaca">
                        </div>
                    </div>
                    <div class="grid_unoxcuatro3">
                        <div class="input-group mb-3">
                            <span class="input-group-text">P/A</span>
                            <input type="text" class="form-control" placeholder="D" aria-label="D" id="nun_presiondistolica">
                            <span class="input-group-text">/</span>
                            <input type="text" class="form-control" placeholder="S" aria-label="S" id="num_presionsistolica">
                        </div>
                    </div>
                    <div class="grid_unoxcuatro4">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Talla</span>
                            <input type="text" class="form-control" placeholder="kg" aria-label="kg">
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid_ingreso_enfermeria1">
                Movilidad	
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_movilidad" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Nutrici&oacute;n	
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_nutricion" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Grado de conciencia 
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_gradoconciencia" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Estado de la piel
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_estadodelapiel" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Conjuntivas
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_conjuntivas" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Yugulares
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_yugulares" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Yugulares
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_yugulares" required value=""> 
            </div>
            <div class="grid_ingreso_enfermeria1">
                Extremidades
            </div>
            <div class="grid_ingreso_enfermeria2">
                <input type="text" class="form-control" id="txt_ef_extremidades" required value=""> 
            </div>



            <div class="card-header featured-header" style="margin-top:-5px;">
                <b>2. EXAMEN FISICO GENERAL</b>
            </div>



            


        </div>
    </div>
</div>

<style>
    .grid_ingreso_enfermeria                {
        display                             :   grid;
        grid-template-columns               :   1fr 2fr;
        gap                                 :   8px;
    }

    .grid_unoxcuatro                        {
        display                             :   grid;
        grid-template-columns               :   1fr 1fr 2fr 1fr;
        gap                                 :   8px;
    }

    .featured-header                        {
        grid-column                         :   1 / span 2;
    }
</style>
