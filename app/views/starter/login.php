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

  <title><?= APP_NAME ?></title>

  <link rel="stylesheet" href="plugins/flag-icon-css/css/flag-icon.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="plugins/fontawesome-free-6.5.1-web/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/thistyle.css">
  <style>
    body {
      /*background: transparent url("dist/img/index_background.png") no-repeat fixed 0px 0px / cover !important;*/
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">

  <div class="login-logo mb-3">
    <img src="dist/img/logo2.png" class="w-25">
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="login-box-msg">Iniciar sesión en <?= APP_NAME ?></h5>

      <?php if (LC_LOGIN == true): ?>

      <form id="login_form">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
          </div>
          <input type="email" name="user" id="user" class="form-control" placeholder="Usuario" autocomplete="off" required autofocus>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
          </div>
          <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Contraseña" autocomplete="off" required>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-dark btn-block">Iniciar sesión</button>
          </div>
        </div>
      </form>

      <?php endif ?>

      <?php if (FB_LOGIN == true || GL_LOGIN == true || TW_LOGIN == true || MS_LOGIN == true || GH_LOGIN == true || LC_SIGNU == true): ?>

      <div class="social-auth-links text-center mb-3">

        <?php if (LC_LOGIN == true): ?>
        <p>- O -</p>
        <?php endif ?>

        <?php if (FB_LOGIN == true): ?>
        <button type="button" class="btn btn-facebook btn-block btn-flat" id="fb">
          <i class="fab fa-facebook-f mr-2"></i> Sign in with Facebook
        </button>
        <?php endif ?>

        <?php if (GL_LOGIN == true): ?>
        <button type="button" class="btn btn-google btn-block btn-flat" id="gl">
          <i class="fab fa-google mr-2"></i> Sign in with Google
        </button>
        <?php endif ?>

        <?php if (MS_LOGIN == true): ?>
        <button type="button" class="btn btn-dark btn-block btn-flat" id="ms">
          <i class="fab fa-windows mr-2"></i> Sign in with Microsoft
        </button>
        <?php endif ?>

        <?php if (TW_LOGIN == true): ?>
        <button type="button" class="btn btn-twitter btn-block btn-flat" id="tw">
          <i class="fa-brands fa-x-twitter"></i> Sign in with Twitter
        </button>
        <?php endif ?>

        <?php if (GH_LOGIN == true): ?>
        <button type="button" class="btn btn-dark btn-block btn-flat" id="gh">
          <i class="fab fa-github mr-2"></i> Sign in with github
        </button>
        <?php endif ?>

        <?php if (LC_SIGNU == true): ?>
        <a href="<?= URL ?>?action=register" class="btn btn-info btn-block btn-flat">
          Únete
        </a>
        <?php endif ?>

      </div>

      <?php endif ?>

      <?php if (LC_LOGIN == true): ?>

      <p class="mt-2 mb-1">
        <a href="<?= URL ?>?action=forgot">¿Olvidó su contraseña?</a>
      </p>

      <?php endif ?>

    </div>

  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (LC_LOGIN == true): ?>
  <script src="dist/js/login.js"></script>
<?php endif ?>
<?php if (FB_LOGIN == true || GL_LOGIN == true || TW_LOGIN == true || MS_LOGIN == true || GH_LOGIN == true): ?>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-auth.js"></script>
<script src="dist/js/sociallogin.js" type="module"></script>
<?php endif ?>

</body>
</html>