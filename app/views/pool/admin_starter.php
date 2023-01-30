<?php require_once APP."/views/master/header.php"; ?>

<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION['session_appname']['level']}_nav.php"; ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= LANG['starter1'] ?> <?= $_SESSION['session_appname']['starter_name'] ?>!</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><?= LANG['starter2'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['starter3'] ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
      </div>
    </section>

  </div>
</div>

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/datatable.js"></script>

<script src="dist/js/welcome.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>