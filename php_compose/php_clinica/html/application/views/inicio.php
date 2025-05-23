<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CL&Iacute;NICA&nbsp;LIBRE</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/plugins/template/css/adminlte.min.css">
  <style>
  .toast-centrado {
    left: 50% !important;
    transform: translateX(-50%) !important;
    top: 20px !important;
    right: auto !important;
  }
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>CL&Iacute;NICA</b>&nbsp;LIBRE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Ingrese <b>RUN</b> y contrase&ntilde;a para inicio de sesi&oacute;n</p>
      <form action="../../index3.html" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="RUN" id="rut_profesional">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-credit-card" style="width:30px;"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" id="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock" style="width: 30px;"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="button" id="btn_inicio" class="btn btn-primary btn-block" onclick="js_inicio()">INGRESAR</button>   
          </div>
        </div>
      </form>
      <p class="mb-0" style="margin-top: 10px;">
        <a href="#" class="text-center" data-toggle="modal" data-target="#recuperarModal">&iquest;Olvidaste tu contrase&ntilde;a?  </a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<div class="modal fade" id="recuperarModal" tabindex="-1" role="dialog" aria-labelledby="recuperarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/enviar-enlace-recuperacion" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="recuperarModalLabel">Recuperar contrase&ntilde;a</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Ingrese su correo electr&oacute;nico asociado a la cuenta <b>CL&Iacute;NICA&nbsp;LIBRE</b></p>
          <input type="email" name="email" class="form-control" required placeholder="correo@ejemplo.cl">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enviar enlace</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- /.login-box -->
<!-- jQuery -->
<script type="text/javascript" src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="assets/plugins/template/js/adminlte.min.js"></script>
<!-- RUN  -->
<script type="text/javascript" src="assets/recursos/js/jquery.Rut.js"></script>
<script type="text/javascript" src="assets/recursos/js/jquery.Rut.min.js"></script>
<script>
    $(document).ready(function(){
      $("#rut_profesional").Rut({
        on_error : function()  {   
          alert('El RUN ingresado es incorrecto. '+$("#rut_profesional").val(), 'Rut Incorrecto'); 
          $("#rut_profesional").css('border-color','red'); 
          $("#rut_profesional").val('');
          console.log($("#rut_profesional").val());  
        },
        on_success : function() {   
          $("#rut_profesional").css('border-color','');   
        },
        format_on : 'keyup'
      });
    document.getElementById("rut_profesional").focus();
  });
  document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener("keypress", function(event) {
      if (event.keyCode === 13 || event.which === 13) {
        let v_run = $("#rut_profesional").val();
        let v_pass = $("#password").val();
        if (v_run != '' &&  v_pass != '' ){
          js_inicio();
        }
      }
    });
  });
function js_inicio(){
    let error = [];
    let v_run = $("#rut_profesional").val();
    let v_pass = $("#password").val();
    let access = null;
    $("#rut_profesional").css('border-color','');   
    if (v_pass == ''){
        error.push("RUN Vacio");
        $("#rut_profesional").css('border-color','red');   
    }
    $("#password").css('border-color','');   
    if (v_pass == ''){
        error.push("Contrase&ntilde;a vac&iacute;a");
        $("#password").css('border-color','red');   
    }
    if (error.length > 0){
        //https://adminlte.io/docs/3.2/javascript/iframe.html
        $('body').Toasts('create', {
            position : 'topRight',
            imageHeight : '130px',
            title : 'Cl&iacute;nica libre',
            icon : 'fas fa-exclamation-triangle',
            autohide : true,
            delay : 3000,
            body : error.join("<br>"),
        });
        setTimeout(() => { $('.toasts-top-right').addClass('toast-centrado'); }, 10);
        return;
    } else {
      $.ajax({ 
        type : "POST",
        url : "Constructor/login",
        dataType : "json",
        beforeSend : function(xhr) { $("#btn_inicio").prop("disabled",true); },
        data : {  
          user : v_run,
          password : v_pass,
          access : access,
        },
        error : function(errro) {  
          console.log(errro);
          console.log(errro.responseText); 
          alert("Error General, Consulte Al Administrador"); 
          $("#btn_inicio").prop("disabled",false);
        },
        success :  function(aData) {  
          //console.log("aData   -> ",aData);
          if (aData.status){
            window.location = aData.redirect;
          } else {
            $("#btn_inicio").prop("disabled",false);
            $('body').Toasts('create', {
              position : 'topRight',
              imageHeight : '130px',
              title : 'Cl&iacute;nica libre',
              icon : 'fas fa-exclamation-triangle',
              autohide : true,
              delay : 3000,
              body : 'Error en las credenciales',
            });
            setTimeout(() => { $('.toasts-top-right').addClass('toast-centrado'); }, 10);
            return;
          }
        }, 
      });
    }
  }
</script>
<?php if ($this->session->flashdata('msg')): ?>
  <script>
    $(document).ready(function () {
      $('body').Toasts('create', {
        title: 'Clínica Libre',
        body: '<?= $this->session->flashdata('msg') ?>',
        icon: 'fas fa-check-circle',
        class: 'bg-success',
        position: 'topRight',
        autohide: true,
        delay: 3000
      });
    });
    setTimeout(() => { $('.toasts-top-right').addClass('toast-centrado'); }, 10);
  </script>
<?php endif; ?>
</body>
</html>