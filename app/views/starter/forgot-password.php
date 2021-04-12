<!DOCTYPE html>
<html lang="es-SV">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icon.ico">

  <title><?= APP_NAME ?> | Forgot Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="dist/img/logo.png" class="h-50 w-50"><br>
    <a href="<?= URL ?>"><?= APP_NAME ?></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Escribe tu cuenta de correo<br>Te enviaremos una nueva contraseña.</p>

      <form action="<?= URL ?>" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="reset-pass" class="btn btn-primary btn-block">Recuperar contraseña</button>
          </div>
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="<?= URL ?>?action=login">Login</a>
      </p>
    </div>
  </div>
</div>
<!-- /.login-box -->

<?php if (isset($_SESSION['progressBar']) && $_SESSION['progressBar'] == 1): ?>

<!-- Modal success -->
<div class="modal fade" id="waitmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p>
          Por favor espere mientras restablecemos su contraseña...
        </p>
        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /. Modal success -->

<meta http-equiv="refresh" content="0.5;URL=<?= URL ?>?action=resetpass">

<?php endif ?>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function()
  {
    $("#waitmodal").modal("show");
  });
</script>

<?php if (isset($_SESSION['progressBar']) && $_SESSION['progressBar'] == 0): ?>

<meta http-equiv="refresh" content="3;URL=<?= URL ?>?action=delresetpass">

<script>
  var Toast = Swal.mixin({
    toast: false,
    position: 'center',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
  });

  Toast.fire({
    icon: 'error',
    title: 'Error en la solicitud.',
    text: 'Por favor ingrese un correo electrónico válido.'
  });
</script>

<?php endif ?>

<?php if (isset($_SESSION['resetpass']) && $_SESSION['resetpass'] == true): ?>

<script>
  var Toast = Swal.mixin({
    toast: false,
    position: 'center',
    showConfirmButton: true
  });

  Toast.fire({
    icon: 'success',
    title: '😃 Success!! 🥳',
    text: 'Por favor revisa tu correo y sigue las instrucciones.',
    confirmButtonText: `De acuerdo 👍`
  }).then(()=>{
    window.open('<?= URL ?>?action=delresetpass','_self');
  });
</script>

<?php elseif (isset($_SESSION['resetpass']) && $_SESSION['resetpass'] == false): ?>

<script>
  var Toast = Swal.mixin({
    toast: false,
    position: 'center',
    showConfirmButton: true
  });

  Toast.fire({
    icon: 'success',
    title: '😃 Error! 🥳',
    text: 'Ingresa un correo electrónico válido',
    confirmButtonText: `De acuerdo 👍`
  }).then(()=>{
    window.open('<?= URL ?>?action=delresetpass','_self');
  });
</script>

<?php endif ?>

</body>
</html>
