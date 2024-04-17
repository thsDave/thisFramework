<?php require_once APP."/views/master/header.php"; ?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION[USER_SESSION]['level']}_nav.php"; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fa-solid fa-clipboard-list fa-xs"></i> <?= LANG['log_title'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['log_title'] ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-12">
            <table id="datable" class="table table-striped">
              <thead class="bg-dark">
                <tr>
                  <td>No</td>
                  <td><?= LANG['field_name'] ?></td>
                  <td><?= LANG['field_email'] ?></td>
                  <td><?= LANG['field_action'] ?></td>
                  <td><?= LANG['field_desc'] ?></td>
                  <td><?= LANG['field_timestamp'] ?></td>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </section>

  </div>
</div>

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/datatable.js"></script>

<script src="dist/js/tbl_logs.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>