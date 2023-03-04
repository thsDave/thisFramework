<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta property="og:url" content="<?= URL ?>">
  <meta property="og:site_name" content="skeleton">
  <meta property="og:description" content="Aquí va una breve descripción del sistema">
  <meta property="og:image" content="<?= URL ?>dist/img/logo.png">
  <meta name="author" content="Devop name">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icono.ico">

  <title><?= APP_NAME ?>  | Reset Pass</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    body {
      background: transparent url("dist/img/index_background.png") no-repeat fixed 0px 0px / cover !important;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">

  <div class="login-logo mb-3">
    <img src="dist/img/logo.gif" class="w-25"><br>
    <a href="<?= URL ?>"><?= APP_NAME ?></a>
  </div>

  <div class="card" id="restore-card">
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <h5 class="text-center">Actualización de contraseña</h5>
        </div>
        <div class="col-12">
          <hr>
        </div>
        <div class="col-12">
          <p class="text-center">
            <strong><span id="username"></span></strong>
            <br><span id="usermail"></span>
          </p>
        </div>
      </div>
      <div class="card-body">
        <form id="restorepass">
          <div class="form-group">
            <label for="pass1">Ingrese su nueva contraseña</label>
            <input type="password" class="form-control" name="pass1" id="pass1" placeholder="Password" onkeyup="validapass1()" required autofocus>
            <small id="mnsj" class="form-text text-muted"></small>
          </div>
          <div class="form-group">
            <label for="pass2">Repita su contraseña</label>
            <input type="password" class="form-control" name="pass2" id="pass2" placeholder="Password" onkeyup="validapass2()" required>
            <small id="mnsj2" class="form-text text-muted"></small>
          </div>
          <div class="row mt-4">
            <div class="col-12">
              <button type="submit" id="btn_pass" class="btn btn-primary btn-block">Actualizar contraseña</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/pwdvalidate.js"></script>

</body>
</html>