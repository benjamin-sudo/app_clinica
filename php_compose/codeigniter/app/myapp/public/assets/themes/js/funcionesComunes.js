function AjaxExtJsonAll(datos) {
    $.each(datos, function (i, item) {
        if (item.opcion == 'hide') {
            $('#' + item.id_html).hide();
        } else if (item.opcion == 'after') {
            $('#' + item.id_html).after(item.contenido);
        } else if (item.opcion == 'show') {
            $('#' + item.id_html).show();
        } else if (item.opcion == 'append') {
            $('#' + item.id_html).append(item.contenido);
        } else if (item.opcion == 'prepend') {
            $('#' + item.id_html).prepend(item.contenido);
        } else if (item.opcion == 'last') {
            $('#' + item.id_html).last(item.contenido);
        } else if (item.opcion == 'html') {
            $('#' + item.id_html).html(item.contenido);
        } else if (item.opcion == 'val') {
            $('#' + item.id_html).val(item.contenido);
        } else if (item.opcion == 'text') {
            $('#' + item.id_html).text(item.contenido);
        } else if (item.opcion == 'remove') {
            $('#' + item.id_html).remove();
        } else if (item.opcion == 'attrSelect') {
            $('#' + item.id_html + ' option[value="' + item.contenido + '"]').attr('selected', 'selected');
        } else if (item.opcion == 'jAlert') {
            jAlert(item.contenido, "SSAN - e-SISSAN");
        } else if (item.opcion == 'jConfirm') {
            jConfirm(item.contenido, 'Confirmation Dialog', function (r) {
                location.reload();
            });
        } else if (item.opcion == 'rmvSelect') {
            $("select#" + item.id_html + " option[value='" + item.contenido + "']").remove();
        } else if (item.opcion == 'console') {
            console.log(item.contenido);
        } else if (item.opcion == 'dialogClose') {
            $("#" + item.contenido).dialog('close');
        } else if (item.opcion == 'location') {
            location.reload();
        } else if (item.opcion == 'script') {
            item.contenido;
        } else if (item.opcion == 'jAlertOK') {
            jAlert(item.contenido, 'E-SISSAN', function (r) {
                location.reload();
            });
        } else if (item.opcion == 'jAlertDiagC') {
            jAlert(item.contenido, 'E-SISSAN', function (r) {
                $('#' + item.id_html).dialog('close');
            });
        } else if (item.opcion == 'swalOK') {
            swal("Se ha realizado con éxito", item.contenido, "success", function (r) { });
        } else if (item.opcion == 'modalClose') {
            $('#' + item.id_html).modal('hide');
        } else if (item.opcion == 'chosenUpd') {
            $('#' + item.id_html).trigger("chosen:updated").chosen({width: "100%"});
        } else if (item.opcion == 'find_rm') {
            $('#' + item.id_html).find("option[value='" + item.contenido + "']").remove();
        } else if (item.opcion == 'jError') {
            jError(item.contenido, 'ERROR - E-SISSAN', function (r) { });
        } else if (item.opcion == 'onclick') {
            $('#' + item.id_html).attr('onClick', item.contenido);
        } else if (item.opcion == 'outonclick') {
            $('#' + item.id_html).attr('onClick', "");
        } else if (item.opcion == 'onchange') {
            document.getElementById(item.id_html).onchange();
        } else if (item.opcion == 'disabled') {
            $('#' + item.id_html).prop('disabled', false);
        } else if (item.opcion == 'swal-success') {
            swal('Realizado correctamente', "'" + item.contenido + "'", 'success');
        } else if (item.opcion == 'modalShow') {
            $('#' + item.id_html).modal('show');
        } else if (item.opcion == 'change_panel') {
            $('#' + item.id_html).removeClass("panel panel-default").addClass(item.contenido);
        } else if (item.opcion == 'addClass') {
            $('#' + item.id_html).addClass(item.contenido);
        } else if (item.opcion == 'removeClass') {
            $('#' + item.id_html).removeClass(item.contenido);
        } 
    });
    return true;
}

function validateFormatHora(id){
    var validaHora = ($("#"+id).val()).split(":");
    //console.log(validaHora);
           if(validaHora[0].length != 2){
            return 1;
    } else if(validaHora[1].length != 2){
           return 1;
    } else if(validaHora[1] > 59 || validaHora[1] < 0) {
           return 2;
    } else if(!$.isNumeric(validaHora[1]) || !$.isNumeric(validaHora[1])){
           return 3;
    } else if(validaHora[0] > 23 || validaHora[0] < 0){
           return 4;
    } else {
           return 0;
    }
}


