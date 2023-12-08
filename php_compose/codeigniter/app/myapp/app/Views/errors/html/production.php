<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <title><?= lang('Errors.whoops') ?></title>
    <style>
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="headline" style="margin-top: 1px;"><?= lang('Errors.whoops') ?></h1>
        <p class="lead"><?= lang('Errors.weHitASnag') ?></p>
        <hr>
        <?php
            // En tu archivo production.php
            $fecha = date('Y-m-d'); // Obtiene la fecha actual
            $archivoLog = WRITEPATH . 'logs/log-' . $fecha . '.log'; // Construye la ruta del archivo de log
            if (file_exists($archivoLog)) {
                $contenido = file_get_contents($archivoLog); // Lee el contenido del archivo
                echo nl2br($contenido); // Muestra el contenido, convirtiendo saltos de línea en <br>
            } else {
                echo "No hay log para esta fecha.";
            }
        ?>
    </div>
</body>
</html>
