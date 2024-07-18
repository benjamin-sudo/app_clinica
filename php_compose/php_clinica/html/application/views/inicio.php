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
        <a href="register.html" class="text-center">¿Olvidaste tu contraseña?</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
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
        on_error    :   function()  {   
                                      alert('El RUN ingresado es incorrecto. '+$("#rut_profesional").val(), 'Rut Incorrecto'); 
                                      console.log($("#rut_profesional").val());  
                                      $("#rut_profesional").css('border-color','red'); 
                                      $("#rut_profesional").val('');
                                    },
        on_success  :   function()  {   
                                      $("#rut_profesional").css('border-color','');   
                                    },
        format_on   : 'keyup'
      });
    document.getElementById("rut_profesional").focus();
  });

  document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener("keypress", function(event) {
      if (event.keyCode === 13 || event.which === 13) {
        let v_run   =   $("#rut_profesional").val();
        let v_pass  =   $("#password").val();
        if (v_run != '' &&  v_pass != '' ){
          js_inicio();
        }
      }
    });
  });

function js_inicio(){
    let error   =   [];
    let v_run   =   $("#rut_profesional").val();
    let v_pass  =   $("#password").val();
    let access  =   null;
    $("#rut_profesional").css('border-color','');   
    if (v_pass == ''){
        error.push("RUN Vacio");
        $("#rut_profesional").css('border-color','red');   
    }
    //**************************************/
    $("#password").css('border-color','');   
    if (v_pass == ''){
        error.push("Contraseña vacia");
        $("#password").css('border-color','red');   
    }
    //**************************************/
    if (error.length > 0){
        //https://adminlte.io/docs/3.2/javascript/iframe.html
        $('body').Toasts('create', {
            position    : 'bottomRight',
            imageHeight : '130px',
            title       : 'Clinica libre',
            icon        : 'fas fa-exclamation-triangle',
            autohide    : true,
            delay       : 3000,
            body        : error.join("<br>"),
        });
    } else {
      $.ajax({ 
        type : "POST",
        url : "Constructor/login",
        dataType : "json",
        beforeSend : function(xhr) { $("#btn_inicio").prop("disabled",true); },
        data : {  
                  user      : v_run,
                  password  : v_pass,
                  access    : access,
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
                                          position    : 'bottomRight',
                                          imageHeight : '130px',
                                          title       : 'Clinica libre',
                                          icon        : 'fas fa-exclamation-triangle',
                                          autohide    : true,
                                          delay       : 3000,
                                          body        : 'Error en las credenciales',
                                        });
                                      }
                                    }, 
      });
    }
  }
</script>
</body>
</html>