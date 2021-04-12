<?php $info = (isset($_COOKIE['MONSTER'])) ? $model->getCookieToken($_COOKIE['MONSTER']) : null; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icono.ico">

  <title><?= APP_NAME ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/thistyle.css">
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
      <p class="login-box-msg">Iniciar sesion</p>

      <?php if (LC_LOGIN == true): ?>

      <div class="input-group mb-3">
        <?php $email = (!is_null($info)) ? $info['user'] : ''; ?>
        <input type="email" id="user" class="form-control" placeholder="Email" value="<?= $email ?>" required autofocus>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <?php $password = (!is_null($info)) ? $info['pass'] : ''; ?>
        <input type="password" id="pwd" class="form-control" placeholder="Password" value="<?= $password ?>" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <div class="icheck-primary">
          <?php if (isset($_COOKIE['MONSTER'])): ?>
            <p class="mb-1">
              <a href="<?= URL ?>?action=delPass" class="text-secondary">Dejar de recordar</a>
            </p>
          <?php else: ?>
            <input type="checkbox" name="remember" id="remember" value="1">
            <label for="remember">
              Recuerdame
            </label>
          <?php endif ?>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-6">
          <button type="submit" id="login" class="btn btn-primary btn-block">Iniciar sesión</button>
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
          <i class="fab fa-facebook-f mr-2"></i> Login with Facebook
        </a>
        <?php endif ?>

        <?php if (GL_LOGIN == true): ?>
        <a href="#" class="btn btn-google btn-block btn-flat" id="gl">
          <i class="fab fa-google mr-2"></i> Login with Google
        </a>
        <?php endif ?>

        <?php if (MS_LOGIN == true): ?>
        <a href="#" class="btn btn-microsoft btn-block btn-flat" id="ms">
          <i class="fab fa-windows mr-2"></i> Login with Microsoft
        </a>
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
      <!-- /.social-auth-links -->

      <?php endif ?>

      <?php if (LC_LOGIN == true): ?>

      <p class="mb-1">
        <a href="<?= URL ?>?action=forgot">Perdí mi contraseña</a>
      </p>

      <?php endif ?>

      <p class="mb-0">
        <a href="<?= URL ?>?action=register">Registrate en <?= APP_NAME ?></a>
      </p>

    </div>
    <!-- /.login-card-body -->

  </div>
</div>
<!-- /.login-box -->

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<?php if (LC_LOGIN == true): ?>
<script src="dist/js/localogin.js"></script>
<?php endif ?>
<?php if (FB_LOGIN == true || GL_LOGIN == true || TW_LOGIN == true || MS_LOGIN == true || GH_LOGIN == true): ?>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-auth.js"></script>
<script src="dist/js/sociallogin.js" type="module"></script>
<?php endif ?>
</body>
</html>