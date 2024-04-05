<!DOCTYPE html>
<html lang="es-SV">
<head>
  <meta charset="utf-8">
  <meta property="og:url" content="<?= URL ?>">
  <meta property="og:site_name" content="skeleton">
  <meta property="og:description" content="Aquí va una breve descripción del sistema">
  <meta property="og:image" content="<?= URL ?>dist/img/logo.png">
  <meta name="author" content="Devop name">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icon.ico">

  <title><?= APP_NAME ?> | Cancelar registro</title>

  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="plugins/fontawesome-free-6.5.1-web/css/all.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
      <h6 class="login-box-msg">
        Tu solicitud de <?= $_SESSION['tipo_gestion'] ?> ha sido cancelada exitosamente
      </h6>
      <p class="mt-3 mb-1">
        <a href="<?= URL ?>?action=login" class="btn btn-dark btn-block">Iniciar sesión</a>
      </p>
    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
