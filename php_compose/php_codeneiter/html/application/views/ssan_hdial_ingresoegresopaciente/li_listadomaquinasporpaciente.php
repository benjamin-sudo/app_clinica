<a href="#" class="list-group-item list-group-item-action">
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


            hojas dialrias salidas



        </div>
        <div class="grid_listadomaquixpac4" style="text-align: end;">
            <div class="btn-group dropstart">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    OPCIONES
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                    <li><button class="dropdown-item" type="button">HOJAS HEMODIALISIS X MAQUINA</button></li>
                </ul>
            </div>
        </div>
    </div>
</a>




