<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icono.ico">

  <title><?= APP_NAME ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <script src="https://kit.fontawesome.com/76dbbc43b7.js" crossorigin="anonymous"></script>
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
<div class="register-box" id="registerbox">
  <div class="login-logo">
    <img src="dist/img/logo.gif" class="w-50">
  </div>
  <div class="card">
    <div class="card-body register-card-body">

      <div class="row">
        <div class="col-12">
          <h5 class="text-center">Información complementaria</h5>
        </div>
        <div class="col-12">
          <hr>
        </div>
      </div>

      <form id="update-form">
        <div class="row">
          <div class="col-12">
              <div class="form-group mb-3">
                <label for="name">Nombre completo</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Nombre completo" required>
              </div>
              <div class="form-group mb-3">
                <label for="country">País</label>
                <?php $countries = $model->countries_list(); ?>
                <select class="form-control" name="country" id="country">
                  <option value="" selected disabled>Seleccionar</option>
                  <?php foreach ($countries['idcountry'] as $i => $id): ?>
                    <option value="<?= $id ?>"><?= $countries['country'][$i] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="office">Idioma</label>
                <select name="lang" class="form-control">
                  <?php $langs = $model->language_list(); ?>
                  <option value="" selected disabled>Seleccionar</option>
                  <?php foreach ($langs['idlang'] as $key => $val): ?>
                  <option value="<?= $val ?>"><?= $langs['language'][$key] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-12">
            <button type="submit" id="btn_register" class="btn btn-info btn-block">
              <i class="fa-solid fa-rotate fa-xs"></i> Actualizar información
            </button>
            <a href="<?= URL ?>?event=logout" class="btn btn-danger btn-block">
              <i class="fa-solid fa-arrow-right-from-bracket fa-xs"></i> <?= LANG['logout'] ?>
            </a>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>

<script src="dist/js/updateinfo.js"></script>

<script>
  $(document).ready(function () {
    $('.select2').select2({ theme: 'bootstrap4' });
  });
</script>

</body>
</html>