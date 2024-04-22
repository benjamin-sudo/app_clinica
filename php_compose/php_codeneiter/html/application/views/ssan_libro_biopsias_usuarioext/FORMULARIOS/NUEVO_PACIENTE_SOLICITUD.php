<style>
    .PANEL_BUSQUEDAPACIENTE         {
        display                     :   grid;
        grid-template-columns       :   32.5% 35% 32.5%;
        grid-column-gap             :   5px;
        grid-row-gap                :   20px;
        margin-top                  :   0px;
        margin-bottom               :   0px;
    }

    .pagination                     {
        margin                      :   12px 0px;
    }
</style>

<input type="hidden" id="PA_ID_PROCARCH" name="PA_ID_PROCARCH" value="">




<div class="container">
    <div id="myWizard" class="wizard">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="nav-item">
                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Paso 1" class="nav-link active">
                        <span class="round-tab">1</span>
                    </a>
                </li>
                <li role="presentation" class="nav-item">
                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Paso 2" class="nav-link">
                        <span class="round-tab">2</span>
                    </a>
                </li>
                <li role="presentation" class="nav-item">
                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Paso 3" class="nav-link">
                        <span class="round-tab">3</span>
                    </a>
                </li>
            </ul>
        </div>

        <form role="form">
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <h4>Paso 1</h4>
                    <p>Aquí van los detalles del paso 1.</p>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-primary next-step">Siguiente</button></li>
                    </ul>
                </div>
                <div class="tab-pane" role="tabpanel" id="step2">
                    <h4>Paso 2</h4>
                    <p>Aquí van los detalles del paso 2.</p>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-default prev-step">Anterior</button></li>
                        <li><button type="button" class="btn btn-primary next-step">Siguiente</button></li>
                    </ul>
                </div>
                <div class="tab-pane" role="tabpanel" id="step3">
                    <h4>Paso 3</h4>
                    <p>Aquí van los detalles del paso 3.</p>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-default prev-step">Anterior</button></li>
                        <li><button type="button" class="btn btn-default next-step">Finalizar</button></li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
$(document).ready(function () {
    // Initialize the wizard
    $('#myWizard').bootstrapWizard();
});
</script>
