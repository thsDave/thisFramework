<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icono.ico">

  <title><?= APP_NAME ?> | Registration Page</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/thistyle.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="login-logo">
    <img src="dist/img/logo.png" class="h-50 w-50"><br>
    <a href="<?= URL ?>"><?= APP_NAME ?></a>
  </div>
  <!-- /.login-logo -->

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Registrate en <?= APP_NAME ?></p>

      <?php if (LC_LOGIN == true): ?>

      <div class="input-group mb-3">
        <input type="text" class="form-control" name="name" id="name" placeholder="Nombre completo" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-user"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="position" id="position" placeholder="Cargo en la empresa">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-user"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="email" class="form-control" name="email" id="email" placeholder="Correo electrónico" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="email" class="form-control" name="email2" id="email2" placeholder="Repita su correo electrónico" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button type="button" id="newregister" class="btn btn-success btn-block">Registrarse</button>
        </div>
        <!-- /.col -->
      </div>

      <?php endif ?>

      <?php if (FB_LOGIN == true || GL_LOGIN == true || TW_LOGIN == true || MS_LOGIN == true || GH_LOGIN == true): ?>

      <div class="social-auth-links text-center mb-3">

        <?php if (LC_LOGIN == true): ?>
        <p>- O Puedes -</p>
        <?php endif ?>

        <?php if (FB_LOGIN == true): ?>
        <a href="#" class="btn btn-facebook btn-block btn-flat" id="fb">
          <i class="fab fa-facebook-f mr-2"></i> Sign up with Facebook
        </a>
        <?php endif ?>

        <?php if (GL_LOGIN == true): ?>
        <a href="#" class="btn btn-google btn-block btn-flat" id="gl">
          <i class="fab fa-google mr-2"></i> Sign up with Google
        </a>
        <?php endif ?>

        <?php if (MS_LOGIN == true): ?>
        <a href="#" class="btn btn-microsoft btn-block btn-flat" id="ms">
          <i class="fab fa-windows mr-2"></i> Sign up with Microsoft
        </a>
        <?php endif ?>

        <?php if (TW_LOGIN == true): ?>
        <a href="#" class="btn btn-twitter btn-block btn-flat" id="tw">
          <i class="fab fa-twitter mr-2"></i> Sign up with Twitter
        </a>
        <?php endif ?>

        <?php if (GH_LOGIN == true): ?>
        <a href="#" class="btn btn-dark btn-block btn-flat" id="gh">
          <i class="fab fa-github mr-2"></i> Sign up with github
        </a>
        <?php endif ?>

      </div>
      <!-- /.social-auth-links -->

      <?php endif ?>

      ¿Ya te encuentras registrado?<a href="<?= URL ?>?action=login" class="text-center"> Inicia sesión aquí</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<?php if (LC_LOGIN == true): ?>
<script src="dist/js/register.js"></script>
<?php endif ?>
<?php if (FB_LOGIN == true || GL_LOGIN == true || TW_LOGIN == true || MS_LOGIN == true || GH_LOGIN == true): ?>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-auth.js"></script>
<script src="dist/js/socialregister.js" type="module"></script>
<?php endif ?>

</body>
</html>