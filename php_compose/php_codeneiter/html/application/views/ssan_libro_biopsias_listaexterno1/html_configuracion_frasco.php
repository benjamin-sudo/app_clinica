<style>
    .grid_fila_columna_etiqueta             {
        display                             :   grid;
        grid-template-columns               :   1fr 1fr;
        gap                                 :   0px 8px;
    }
</style>

ETIQUETADORA&nbsp;:&nbsp;<b>ZEBRA ZD420 - ZEBRA GC420 - ZEBRA GC420t</b>
<hr style="margin:0px 0px;">

TIPO DE ETIQUETA:<b>PEQUE&Ntilde;A - FRASCO</b>
<hr style="margin:0px 0px;">

CONFIGURACI&Oacute;N
<select class="form-control input-sm" name="CONFIG_FRASCO" id="CONFIG_FRASCO" onchange="change_loalstrange(this.value)">
    <option value="0">CONFIG 0 - FRASCO 0px - 0px</option>
    <option value="1">CONFIG 1 - FRASCO +15px</option>
    <option value="2">CONFIG 2 - FRASCO</option>
    <option value="4">CONFIG 4 - FRASCO</option>
    <option value="5">CONFIG 5 - FRASCO</option>
    <option value="6">CONFIG 6 - MODELO ZEBRA-GC420T - VICTORIA - GASTRO</option>
    <option value="7">CONFIG 7 - ANGOL - ENDOSCOPIA</option>
    <option value="8">CONFIG 8 - CON VARIABLES</option>
</select>
<br>
<div class="grid_fila_columna_etiqueta">
    <div class="grid_fila_columna_etiqueta1"><b>EJE Y</b></div>
    <div class="grid_fila_columna_etiqueta2"><b>EJE X</b></div>
    <div class="grid_fila_columna_etiqueta1">
        <input type="number" id="num_comuna" name="num_comuna"  class="form-control" value="<?php echo isset($_COOKIE['num_comuna'])?$_COOKIE['num_comuna']:'20';?>"/>
    </div>
    <div class="grid_fila_columna_etiqueta2">
        <input type="number" id="num_fila" name="num_fila"      class="form-control" value="<?php echo isset($_COOKIE['num_fila'])?$_COOKIE['num_fila']:'175';?>"/>
    </div>
</div>