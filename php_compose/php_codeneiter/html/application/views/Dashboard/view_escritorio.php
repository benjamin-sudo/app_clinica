<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clinica Libre</title>
    <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">

  <style>
    .nav-link.activo {
      background-color: #f0f0f0;
      color: #333;
    }
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
        <a href="#" class="nav-link">Configuraci&oacute;n</a>
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
      <span class="brand-text font-weight-light">Mi Clinica Libre</span>
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
  <!-- jQuery -->
  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!--
  <script src="assets/dist/js/demo.js"></script>
  -->
  <script>
    $(document).ready(function(){
      $('.load-in-frame').click(function(e){
          e.preventDefault();                   // Evitar que el navegador siga el enlace
          let url = $(this).attr('href');       // Obtener la URL del enlace
          $.ajax({
            url     : url,                           // Ruta al método del controlador
            type    : 'POST',                       // Método HTTP deseado, POST es común para envío de datos
            data    : { },
            error   : function(xhr,status,error) {
                                                    //Manejo de errores
                                                    console.error(error);
                                                  },

            success : function(response) {
                                          // Aquí manejas lo que sucede después de recibir la respuesta del servidor
                                          console.log(response);
                                          $('.page_frame').html(response);
                                        },
           
          });
      });
      
      // Asignar evento de clic al menú principal
      js_gestion_menu();
    });

    function js_gestion_menu(){

            console.log("js_gestion_menu ini() ");

            document.addEventListener('DOMContentLoaded', function() {
              // Define una función para actualizar el estado activo del menú
              function actualizarEstadoActivo(id) {
                  // Elimina la clase activo de todos los elementos
                  document.querySelectorAll('.menu_principal div').forEach(function(el) {
                      el.classList.remove('activo');
                  });
                  // Añade la clase activo al elemento correcto
                  var elementoActivo = document.getElementById(id);
                  if (elementoActivo) {
                      elementoActivo.classList.add('activo');
                  }
              }

              // Captura clics en los enlaces del menú y extensiones
              document.querySelectorAll('.nav-link').forEach(function(link) {
                  link.addEventListener('click', function() {
                      localStorage.setItem('ultimaPosicionMenu', this.id);
                  });
              });

              // Restaurar el estado activo del último enlace seleccionado
              var ultimaPosicion = localStorage.getItem('ultimaPosicionMenu');
              if (ultimaPosicion) {
                  actualizarEstadoActivo(ultimaPosicion);
              }

              // Evento de clic para el menú principal
              document.querySelector('.menu_principal').addEventListener('click', function(event) {

                  console.log("click - menu_principal");

                  // Asegúrate de que el clic fue en un elemento del menú
                  if (event.target.id) {
                      // Guardar la posición del menú en localStorage
                      localStorage.setItem('ultimaPosicionMenu', event.target.id);
                      // Actualizar visualmente el menú activo
                      actualizarEstadoActivo(event.target.id);
                  }
              });

              // Al cargar la página, verifica si hay una posición guardada y actúa en consecuencia
              var ultimaPosicion            = localStorage.getItem('ultimaPosicionMenu');
              console.log("ultimaPosicion   = ",ultimaPosicion);
              if (ultimaPosicion) {
                  var elementoActivo = document.getElementById(ultimaPosicion);
                  if (elementoActivo) {
                    if (elementoActivo) {
                        elementoActivo.classList.add('activo');
                    }
                  }
              }
        });

  }
  </script>
</body>
</html>
