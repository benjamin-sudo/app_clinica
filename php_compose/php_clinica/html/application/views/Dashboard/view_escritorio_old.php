<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
  <meta name="viewport" content="width=device-width, initial-scale=3">
  <meta name="resource-type" content="document" />
  <meta name="robots" content="all, index, follow"/>
  <meta name="googlebot" content="all, index, follow">
  <title>Clinica Libre</title>
  <!-- Bootstrap 5.2 -->
  <!--
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  -->
  <link href="assets/recursos/bootstrap_5/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons v1.11.2 -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Font Awesome -->
  <!--
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  -->
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- 
    https://adminlte.io/docs/3.2/javascript/iframe.html
  -->
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- jalert css -->
  <link href="assets/recursos/jalert/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
  <!-- select min  -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
  <!-- ui | 1.12.1 --> 
  <!-- autocomplete -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css">
  -->

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <style>
    .nav-link.activo{ }
    #loadFade { z-index: 10500 !important; }
  </style>
</head>
<body data-scrollbar-auto-hide="n">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index.html" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:js_confimicuenta();" class="nav-link">Configuraci&oacute;n</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo site_url('dashboard/logout');?>" class="nav-link" style="color:red;">Cerrar Sesi&oacute;n</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
      <span class="brand-text font-weight-light">CLINICA LIBRE</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Nombre Establecimiento</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column menu_principal" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">Listado sistema</li>
        <?php
          if (count($menu)>0){
            foreach ($menu as $mainId => $mainItem) {
                // Menú principal
                echo '<li class="nav-item">';
                echo '<a href="#" class="nav-link">';
                echo '<i class="nav-icon ' . $mainItem['data']['main_icon'] . '"></i>';
                echo '<p>' . $mainItem['data']['main_nombre'];
                  if (!empty($mainItem['submenus'])) {
                    echo '<i class="right fas fa-angle-left"></i>';
                  }
                echo '</p>';
                echo '</a>';
                // Submenús
                if (!empty($mainItem['submenus'])){
                    echo '<ul class="nav nav-treeview">';
                    foreach ($mainItem['submenus'] as $subId => $subItem) {
                        echo '<li class="nav-item">';
                        echo '<a href="' . $subItem['data']['sub_ruta'] . '" class="nav-link" id="menu-' . $mainId . '-sub-' . $subId . '">';
                        echo '<i class="far fa-circle nav-icon"></i>';
                        echo '<p>' . $subItem['data']['sub_nombre'];
                        if (!empty($subItem['extensions'])) {
                            echo '<i class="right fas fa-angle-left"></i>';
                        }
                        echo '</p>';
                        echo '</a>';
                        // Extensiones
                        if (!empty($subItem['extensions'])) {
                            echo '<ul class="nav nav-treeview">';
                            foreach ($subItem['extensions'] as $extId => $extItem) {
                              echo '<li class="nav-item">';
                              echo '<a href="' . $extItem['ext_ruta'] . '" class="nav-link load-in-frame" id="menu-' . $mainId . '-sub-' . $subId . '-ext-' . $extId . '">';
                              echo '<i class="far fa-dot-circle nav-icon"></i>';
                              echo '<p>' . $extItem['ext_nombre'] . '</p>';
                              echo '</a>';
                              echo '</li>';
                          }
                            echo '</ul>';  // Fin de las extensiones
                        }
                        echo '</li>';
                    }
                    echo '</ul>';  // Fin de los submenús
                }
              echo '</li>';
            }
          }
        ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
      <div class="page_frame container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pagina Bienvenida</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Pagina inicio</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version CLinica libre</b> 1.0.0
    </div>
    <strong>Clinica libre&copy;<?php echo date('m-Y');?> <a href="#">#</a></strong> Todos los derechos reservados
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

  <div id="respuesta"></div>
  <!-- jQuery v3.6.0 -->
  <script type="text/javascript" src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI - v1.12.0-rc.2  -->
  <script type="text/javascript" src="assets/recursos/js/jquery-ui.js"></script>
  <!-- Bootstrap 5.2.3
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
  <!-- Bootstrap 5.0.1 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  <!-- AdminLTE App -->
  <script type="text/javascript" src="assets/dist/js/adminlte.min.js"></script>
  <!-- Validador rut -->
  <script type="text/javascript" src="assets/recursos/js/jquery.Rut.js" ></script>
  <script type="text/javascript" src="assets/recursos/js/jquery.Rut.min.js"></script>
  <!-- jalert y otro -->
  <script type="text/javascript" src="assets/recursos/js/jquery.alerts.mod.js"></script>
  <!-- shownotificacion -->
  <script type="text/javascript" src="assets/recursos/js/bootstrap-notify.js"></script>
  <!-- web socket -->
  <script type="text/javascript" src="assets/recursos/wsocket_io/4_6_0/socket.io.min.js" ></script>
  <!-- personalizable --> 
  <script type="text/javascript" src="assets/recursos/js/funciones.js" ></script>
  <!-- moment.min.js -->
  <!-- moment.js -->
  <!-- bootstrap-datetimejs -->  
  <script type="text/javascript" src="assets/recursos/js/moment.min.js"></script>
  <script type="text/javascript" src="assets/recursos/js/moment.js"></script>
  <!--
  <script type="text/javascript" src="assets/recursos/js/bootstrap-datetimepicker.js"></script>
  -->
  <!--
  <script src="https://cdn.jsdelivr.net/npm/moment@latest/min/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
  -->

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <section>
      <div class="modal bg-dark fade" id="loadFade" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" style="color:black;" id="exampleModalLabel">Cargando ...</h1>
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
      
      <div class="modal fade" id="modal_perfil_usuario">
          <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title"><i class="bi bi-gear-fill"></i>&nbsp;&nbsp;<b>CONFIGURACI&Oacute;N CUENTA DE USUARIO</b></h3>
                      <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body" id="html_perfil_usuario"></div>
                  <div class="modal-footer">
                      <div class="btn-group">
                          <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">
                              <i class="bi bi-x-square-fill"></i>&nbsp;&nbsp;CERRAR VENTANA
                          </button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
  </body>
</html>