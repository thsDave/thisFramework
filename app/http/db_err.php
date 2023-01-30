<?php require_once '../config/config.php'; ?>
<?php $message = (isset($_GET['val'])) ? $_GET['val'] : 'No hay errores registrados'; ?>

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
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icono.ico">

  <title><?= APP_NAME ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <script src="https://kit.fontawesome.com/76dbbc43b7.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/thistyle.css">

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DB Error Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DB Error Page</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="error-page">
        <h2 class="headline text-danger"> <i class="fas fa-database"></i></h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-danger"></i> ¡Ups! Algo salió mal.</h3>

          <p>
            Por el momento <strong> No hay conexión con la base de datos</strong>, trabajaremos para solucionarlo de inmediato.
          </p>
          <p>
            Código de error: <strong><?= $message ?></strong> |
            <span data-toggle="modal" data-target="#mnsj" style="cursor:pointer;" id="mnsj">
              <i class="fa-solid fa-paper-plane"></i> Informar error
            </span>
          </p>
          <p>
            <a href="<?= URL ?>?req=home" class="btn btn-sm btn-danger">
              <i class="fa-solid fa-house"></i> Ir a inicio
            </a>
          </p>
        </div>
      </div>
    </section>
  </div>

</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $('#mnsj').click(() => {
    let arr_data = new FormData();
    arr_data.append('err_db_mnsj', true);
    fetch('external_data', {
      method: 'POST',
      body: arr_data
    })
    .then(res => res.json())
    .then(data => {
      if (data) {
        Swal.fire({
          icon: 'success',
          title: 'Notificación enviada',
          text: 'Gracias por notificarnos el problema.',
          confirmButtonText: `Ok! 👍`
        }).then(()=>{
          location.reload();
        });
      }else {
        Swal.fire({
          icon: 'error',
          title: 'Mensaje no enviado',
          html: `<p>Hubo un problema al enviar la notificación 😐</p><p>Escribenos a <strong><a href="mailto:developers@educo.org">developers@educo.org</a></strong> y reportanos el problema, será de gran ayuda tu colaboración.</p>`,
          confirmButtonText: `De acuerdo! 👍`
        }).then(()=>{
          location.reload();
        });
      }
    });
  });
</script>

</body>
</html>