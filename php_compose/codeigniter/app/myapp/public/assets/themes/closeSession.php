<script>
    if (window.jQuery) {
        if ($("#closeSessDialog").length > 0) {
            $('#closeSessDialog').dialog('open');
        } else if ($("#closeSession").length > 0) {
            $('#closeSession').modal('show');
        } else {
            alert('Su sesión en el sistema a expirado, Favor Vuelva a inciar sessión nuevamente');
            window.location = "../../inicio";
        }
    } else {
        window.location = "../../inicio";
    }
</script>