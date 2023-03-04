<?php $email = (isset($_COOKIE['user_token'])) ? $model->get_cookie_token($_COOKIE['user_token']) : null; ?>
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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/thistyle.css">
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

  <div class="card">
    <div class="card-body login-card-body">
      <h5 class="login-box-msg">Iniciar sesion</h5>

      <?php if (LC_LOGIN == true): ?>

      <?php if (!isset($_COOKIE['user_token'])): ?>

      <form id="login_form">
        <div class="input-group mb-3">
          <input type="email" name="user" id="user" class="form-control" placeholder="email" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="pwd" id="pwd" class="form-control" placeholder="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="icheck-primary">
              <input type="checkbox" name="remember" id="remember" value="1">
              <label for="remember">
                Recuerdame
              </label>
            </div>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
          </div>
        </div>
      </form>

      <?php else: ?>

      <form id="cookie_form">
        <div class="input-group mb-3">
          <input type="text" name="user" id="user" class="form-control" value="<?= $email ?>" disabled>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="icheck-primary">
              <p class="mb-1">
                <a href="<?= URL ?>?action=sessiondel" class="text-secondary">Olvidar sesión</a>
              </p>
            </div>
          </div>
          <div class="col-6">
            <input type="hidden" name="token_login" value="<?= $_COOKIE['user_token'] ?>">
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
          </div>
        </div>
      </form>

      <?php endif ?>

      <?php endif ?>

      <?php if (FB_LOGIN == true || GL_LOGIN == true || TW_LOGIN == true || MS_LOGIN == true || GH_LOGIN == true): ?>

      <div class="social-auth-links text-center mb-3">

        <?php if (LC_LOGIN == true): ?>
        <p>- O Puedes -</p>
        <?php endif ?>

        <?php if (FB_LOGIN == true): ?>
        <a href="#" class="btn btn-facebook btn-block btn-flat" id="fb">
          <i class="fab fa-facebook-f mr-2"></i> Login with Facebook
        </a>
        <?php endif ?>

        <?php if (GL_LOGIN == true): ?>
        <a href="#" class="btn btn-google btn-block btn-flat" id="gl">
          <i class="fab fa-google mr-2"></i> Login with Google
        </a>
        <?php endif ?>

        <?php if (MS_LOGIN == true): ?>
        <button class="btn btn-dark btn-block btn-flat" id="ms">
          <i class="fab fa-windows mr-2"></i> Login with Microsoft
        </button>
        <?php endif ?>

        <?php if (TW_LOGIN == true): ?>
        <a href="#" class="btn btn-twitter btn-block btn-flat" id="tw">
          <i class="fab fa-twitter mr-2"></i> Login with Twitter
        </a>
        <?php endif ?>

        <?php if (GH_LOGIN == true): ?>
        <a href="#" class="btn btn-dark btn-block btn-flat" id="gh">
          <i class="fab fa-github mr-2"></i> Login with github
        </a>
        <?php endif ?>

      </div>

      <?php endif ?>

      <?php if (LC_LOGIN == true): ?>

      <p class="mb-1">
        <a href="<?= URL ?>?action=forgot">Perdí mi contraseña</a>
      </p>

      <?php endif ?>

      <p class="mb-0">
        <a href="<?= URL ?>?action=register">Regístrate</a>
      </p>

    </div>

  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (LC_LOGIN == true): ?>
  <?php if (!isset($_COOKIE['user_token'])): ?>
    <script src="dist/js/login.js"></script>
  <?php else: ?>
    <script src="dist/js/cookielogin.js"></script>
  <?php endif ?>
<?php endif ?>
<?php if (FB_LOGIN == true || GL_LOGIN == true || TW_LOGIN == true || MS_LOGIN == true || GH_LOGIN == true): ?>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-auth.js"></script>
<script src="dist/js/sociallogin.js" type="module"></script>
<?php endif ?>

</body>
</html>