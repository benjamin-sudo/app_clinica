<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CL&Iacute;NICA LIBRE</title>
    <link type="text/css" rel="stylesheet" href="../../assets/dist/css/bootstrap.min.css" />
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
            <div class="card-header text-center"><b>CAMBIO DE CONTRASE&Ntilde;A&nbsp;/&nbsp;CLINICA LIBRE</b></div>
            <div class="card-body">
                <form id="formCambiarPass" action="<?= base_url('recuperar/actualizar') ?>" method="post">
                    <div class="form-group">
                        <label for="passNew1">NUEVA CONTRASE&Ntilde;A</label>
                        <input type="password" class="form-control" id="passNew1" name="passNew1" required placeholder="Nueva contrase&ntilde;a" onkeyup="compararPasswords()">
                        <small class="text-muted">Mínimo 8 caracteres, al menos una letra y un número.</small>
                    </div>
                    <div class="form-group">
                        <label for="passNew2">CONFIRMA CONTRASE&Ntilde;A</label>
                        <input type="password" class="form-control" id="passNew2" name="passNew2" required placeholder="Confirma la contrase&ntilde;a" onkeyup="compararPasswords()">
                        <small id="mensajeError" class="text-danger" style="display:none;">Las contrase&ntilde;as no coinciden.</small>
                        <small id="seguridadError" class="text-danger" style="display:none;">Debe tener al menos 8 caracteres, una letra y un número.</small>
                    </div>
                    <div class="text-right">
                        <button type="button" id="btnCambiar" class="btn btn-success" disabled>
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Cambiar Contrase&ntilde;a
                        </button>
                    </div>
                    <input type="hidden" id="token" name="token" value="<?= $token ?>">
                </form>
            </div>
        </div>
    </div>

    <script>
        function compararPasswords() {
            const pass1 = document.getElementById('passNew1').value;
            const pass2 = document.getElementById('passNew2').value;
            const errorCoinciden = document.getElementById('mensajeError');
            const errorSeguridad = document.getElementById('seguridadError');
            const boton = document.getElementById('btnCambiar');
            const esSegura = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d.]{8,}$/.test(pass1);
            if (pass1 && pass2) {
                if (pass1 !== pass2) {
                    errorCoinciden.style.display = 'block';
                    errorSeguridad.style.display = 'none';
                    boton.disabled = true;
                    boton.removeAttribute('onclick');
                } else if (!esSegura) {
                    errorCoinciden.style.display = 'none';
                    errorSeguridad.style.display = 'block';
                    boton.disabled = true;
                    boton.removeAttribute('onclick');
                } else {
                    errorCoinciden.style.display = 'none';
                    errorSeguridad.style.display = 'none';
                    boton.disabled = false;
                    boton.setAttribute('onclick', 'enviarFormulario()');
                }
            } else {
                errorCoinciden.style.display = 'none';
                errorSeguridad.style.display = 'none';
                boton.disabled = true;
                boton.removeAttribute('onclick');
            }
        }
        function enviarFormulario() {
            document.getElementById('formCambiarPass').submit();
        }
    </script>
</body>
</html>
