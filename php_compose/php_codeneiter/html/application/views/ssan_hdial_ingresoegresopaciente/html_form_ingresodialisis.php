<div class="card">
    <div class="card-header">
        <b>INGRESO DE ENFERMERIA</b>
        <br>
        Unidad de Hemodiálisis
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
                    <option value="">Seleccione ...</option>
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
                    <div class="grid_unoxcuatro">Peso</div>
                    <div class="grid_unoxcuatro">FC</div>
                    <div class="grid_unoxcuatro">P/A</div>
                    <div class="grid_unoxcuatro">Talla</div>
                </div>
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
        grid-template-columns               :   1fr 1fr 1fr 1fr;
        gap                                 :   8px;
    }

    .featured-header                        {
        grid-column                         :   1 / span 2;
    }
</style>