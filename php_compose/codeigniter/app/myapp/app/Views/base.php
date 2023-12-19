<!DOCTYPE html>
<html lang="es">
<head>
    <title>CL&Iacute;NICA C&Oacute;DIGO LIBRE</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <meta name="viewport" content="width=device-width, initial-scale=3">
    <meta name="resource-type" content="document" />
    <meta name="robots" content="all, index, follow"/>
    <meta name="googlebot" content="all, index, follow" />
    <link type="image/x-icon" rel="shortcut icon" href="assets/themes/img/iconAdmin.png" />
    <!-- NUEVOS RECURSOS -->
    <!-- NUEVO OLD -->
    <link rel="stylesheet" type="text/css" href="recursos/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="recursos/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- jAlert... -->
    <link rel="stylesheet" type="text/css" href="assets/themes/css/jquery.alerts.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    <?php if (isset($css)): ?>
        <?php foreach ($css as $cssFile): ?>
            <link rel="stylesheet" href="<?= 'assets/' . $cssFile; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
<!-- bg-dark -->
<div class="card" style="margin:15px;">
  <div class="card-body">
    <?php $this->renderSection('content');?>
  </div>
</div>
<section>
    <div class="modal bg-dark fade" id="loadFade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Cargando ...</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body" style="text-align: center;">
                <div class="spinner-grow text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-border text-secondary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-border text-danger" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-border text-info" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>
<script type="text/javascript" src="recursos/js/bootstrap/dist/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="recursos/js/socket/4_6_1/socket.io.js"></script>
<script type="text/javascript" src="recursos/js/jquery/1_12_4/jquery.min.js"></script>
<script type="text/javascript" src="assets/themes/js/jquery-ui.js"></script>
<!-- VALIDADOR RUT -->
<script type="text/javascript" src="assets/themes/js/jquery.Rut.js" ></script>
<script type="text/javascript" src="assets/themes/js/jquery.Rut.min.js"></script>
<script type="text/javascript" src="assets/themes/js/jquery.alerts.mod.js"></script>
<script type="text/javascript" src="assets/themes/js/jquery.easy-autocomplete.min.js"></script>
<script type="text/javascript" src="assets/themes/js/funciones.js" ></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/themes/lightboot/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="assets/themes/js/javaGlobal.js"></script>
<!--
  <script src="https://https://cdn.jsdelivr.net/npm/bootstrap-notify@3.1.3/bootstrap-notify.min.js"></script>
-->
<script type="text/javascript">
   var type = ['',
                'info', 
                'success', 
                'warning', 
                'danger', 
                'primary'
              ];
  function showNotification(from, align, txt, color, icono, width) {
    $.notify({
        icono       :   icono,
        message     :   txt
    },{
        type        :   type[color],
        timer       :   4000,
        placement   :   {
            from    :   from,
            align   :   align
        }
    });
    $('.alert').css('z-index','9999');
    if (width != '') {
      $('.alert').css('width', width);
      $('.message').css('width', width);
    }
}
</script>

<?php if (isset($js)): ?>
  <?php foreach ($js as $jsFile): ?>
    <script src="<?= 'assets/'.$jsFile; ?>"></script>
  <?php endforeach; ?>
<?php endif; ?>
</body>
</html>