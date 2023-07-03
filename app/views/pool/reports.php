<?php require_once APP."/views/master/header.php"; ?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION[USER_SESSION]['level']}_nav.php"; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="nav-icon fas fa-file-invoice fa-xs"></i> <?= LANG['reports_title'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['reports_title'] ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h3><?= LANG['reports_subtitle'] ?></h3>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12 col-md-4">
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fa-solid fa-users"></i> <?= LANG['reports_card1'] ?>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <h5><?= LANG['report_card1_title'] ?></h5>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-12">
                    <form action="print_report" method="post">
                      <div class="form-group">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="hr_users" name="side">
                          <label for="hr_users" class="custom-control-label"><?= LANG['report_hr_report'] ?></label>
                        </div>
                      </div>
                      <input type="hidden" name="report" value="users_list">
                      <button type="submit" class="btn btn-sm btn-success" id="xls1" name="print" value="xls"><?= LANG['report_print_xls'] ?></button>
                      <button type="submit" class="btn btn-sm btn-danger" id="pdf1" name="print" value="pdf"><?= LANG['report_print_pdf'] ?></button>
                    </form>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <hr class="bg-dark">
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <h5><?= LANG['report_card1_title2'] ?></h5>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-12">
                    <form action="print_report" method="post">
                      <input type="hidden" name="report" value="support_list">
                      <button type="submit" class="btn btn-sm btn-success" id="xls2" name="print" value="xls"><?= LANG['report_print_xls'] ?></button>
                      <button type="submit" class="btn btn-sm btn-danger" id="pdf2" name="print" value="pdf"><?= LANG['report_print_pdf'] ?></button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
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

<script src="dist/js/reports.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>

