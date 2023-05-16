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

  <title><?= APP_NAME ?> | Registration Page</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/thistyle.css">
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <style>
    body {
      background: transparent url("dist/img/index_background.png") no-repeat fixed 0px 0px / cover !important;
    }
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="login-logo mb-3">
    <img src="dist/img/logo.png" class="w-50">
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Nuevo registro en <?= APP_NAME ?></p>

      <?php if (LC_LOGIN == true): ?>

      <form id="register-form">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" id="name" placeholder="Nombre completo" required autofocus>
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
        <div class="input-group mb-3">
          <select name="country" class="form-control select2">
            <?php $countries = $model->countries_list(); ?>
            <option value="" selected disabled>Seleccionar</option>
            <?php foreach ($countries['idcountry'] as $key => $val): ?>
            <option value="<?= $val ?>"><?= $countries['country'][$key] ?></option>
            <?php endforeach ?>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-globe-americas"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <select name="lang" class="form-control select2">
            <?php $langs = $model->language_list(); ?>
            <option value="" selected disabled>Seleccionar</option>
            <?php foreach ($langs['idlang'] as $key => $val): ?>
            <option value="<?= $val ?>"><?= $langs['language'][$key] ?></option>
            <?php endforeach ?>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-language"></span>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12">
            <button type="submit" id="btn_register" class="btn btn-info btn-block">Registrarse</button>
          </div>
        </div>
      </form>

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
        <a href="#" class="btn btn-educo btn-block btn-flat" id="ms">
          <i class="fab fa-windows mr-2"></i> Registrate con educo.org
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

      <?php endif ?>

      <p align="center">
        ¿Ya te encuentras registrado?<br><a href="<?= URL ?>?action=login" class="text-center"> Inicia sesión aquí</a>
      </p>

    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (LC_LOGIN == true): ?>
<script src="dist/js/register.js" type="module"></script>
<?php endif ?>
<?php if (FB_LOGIN == true || GL_LOGIN == true || TW_LOGIN == true || MS_LOGIN == true || GH_LOGIN == true): ?>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-auth.js"></script>
<script src="dist/js/socialregister.js" type="module"></script>
<?php endif ?>

<script src="plugins/select2/js/select2.full.min.js"></script>

<script>
  $(document).ready(function () { $('.select2').select2({ theme: 'bootstrap4' }); });
</script>

</body>
</html>