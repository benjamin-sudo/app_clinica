<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambio de Contraseña</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .container-center {
            display: grid;
            place-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .card {
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .text-danger {
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container-center">
        <div class="card">
            <div class="card-header text-center"><b>CAMBIO DE CONTRASE&Ntilde;A / CLINICA LIBRE</b></div>
            <div class="card-body">
                <form id="formCambiarPass" method="post" action="<?= base_url('recuperar/actualizar') ?>">
                    <div class="form-group">
                        <label for="passNew1">NUEVA CONTRASE&Ntilde;A</label>
                        <input type="password" class="form-control" id="passNew1" name="passNew1" required placeholder="Nueva contraseña">
                    </div>
                    <div class="form-group">
                        <label for="passNew2">CONFIRMA CONTRASE&Ntilde;A</label>
                        <input type="password" class="form-control" id="passNew2" name="passNew2" required placeholder="Confirma la contraseña" onkeyup="compararPasswords()">
                        <small id="mensajeError" class="text-danger" style="display:none;">Las contraseñas no coinciden.</small>
                    </div>
                    <div class="text-right">
                        <button type="button" id="btnCambiar" class="btn btn-success" disabled>
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Cambiar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" name="token" value="<?= $token ?>">
    <script>
        function compararPasswords() {
            const pass1 = document.getElementById('passNew1').value;
            const pass2 = document.getElementById('passNew2').value;
            const errorMsg = document.getElementById('mensajeError');
            const boton = document.getElementById('btnCambiar');
            if (pass1 && pass2 && pass1 === pass2) {
                errorMsg.style.display = 'none';
                boton.disabled = false;
                boton.setAttribute('onclick', 'enviarFormulario()');
            } else {
                errorMsg.style.display = 'block';
                boton.disabled = true;
                boton.removeAttribute('onclick');
            }
        }

        function enviarFormulario() {
            // Aquí puedes enviar el formulario o hacer lo que necesites
            document.getElementById('formCambiarPass').submit();
        }
    </script>
</body>
</html>
