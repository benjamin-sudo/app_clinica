<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesi&oacute;n Clinica Libre</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .login-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 300px;
            }
            .login-container h2 {
                text-align: center;
                margin-bottom: 20px;
            }
            .login-container label {
                display: block;
                margin-bottom: 5px;
            }
            .login-container input[type="text"], .login-container input[type="password"] {
                width: 100%;
                padding: 0px;
                height: 31px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            .login-container button {
                width: 100%;
                padding: 10px;
                background-color: #007BFF;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .login-container button:hover   {
                background-color : #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h2 style="margin: 0px;">Iniciar Sesi&oacute;n</h2>
            <form action="<?= base_url('ruta_login');?>" method="POST">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Contrase&ntilde;a:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Ingresar</button>
            </form>
        </div>
    </body>
</html>