<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icono.ico">

  <title><?= APP_NAME ?>  | Reset Pass</title>

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
    <a href="<?= URL ?>?action=login"><?= APP_NAME ?></a>
  </div>
  <!-- /.login-logo -->
  <div class="card" id="restore-card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Restablecer contraseña</p>
      <div class="card-body">
        <div class="form-group">
          <label for="pass1">Ingrese su nueva contraseña</label>
          <input type="password" class="form-control" id="pass1" placeholder="Password" onkeyup="validapass1()" required autofocus>
          <small id="mnsj" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
          <label for="pass2">Repita su contraseña</label>
          <input type="password" class="form-control" id="pass2" placeholder="Password" onkeyup="validapass2()" required>
          <small id="mnsj2" class="form-text text-muted"></small>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" id="btn_pass" class="btn btn-primary">Restablecer contraseña</button>
          </div>
        </div>
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/pwdvalidate.js"></script>
<script src="dist/js/restorepwd.js" type="module"></script>

</body>
</html>