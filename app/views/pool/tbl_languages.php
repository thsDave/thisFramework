<?php require_once APP."/views/master/header.php"; ?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION['session_appname']['level']}_nav.php"; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fa-solid fa-earth-americas fa-xs"></i> <?= LANG['lang_title'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['countries_title'] ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <button type="button" class="btn btn-sm btn-success" id="add_lang" data-toggle="modal" data-target="#modal_lang">
              <i class="fa-solid fa-circle-plus"></i> Nuevo
            </button>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12">
            <table id="datable" class="table table-striped">
              <thead class="bg-dark">
                <tr>
                  <td>No</td>
                  <td><?= LANG['field_lang'] ?></td>
                  <td><?= LANG['field_code'] ?></td>
                  <td><?= LANG['field_icon'] ?></td>
                  <td><?= LANG['field_status'] ?></td>
                  <td><?= LANG['field_timestamp'] ?></td>
                  <td><?= LANG['field_actions'] ?></td>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </section>

  </div>
</div>

<div class="modal fade" id="modal_lang" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="lang_form" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="language"><?= LANG['lang_name'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="language" name="language" placeholder="<?= LANG['lang_name'] ?>" required autofocus>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="lancode"><?= LANG['lang_code'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="lancode" name="lancode" placeholder="<?= LANG['lang_code'] ?>" required>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="lanicon"><?= LANG['lang_icon'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="lanicon" name="lanicon" placeholder="<?= LANG['lang_icon'] ?>" required>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row mt-4">
            <div class="col-12 col-sm-6 col-md-12">
              <button type="button" class="btn btn-sm btn-dark float-left" data-dismiss="modal"><?= LANG['close_button'] ?></button>
              <button type="submit" class="btn btn-sm btn-primary float-right">
                <?= LANG['save_button'] ?> <i class="fa-solid fa-angle-right"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-dark">
      </div>
    </div>
  </div>
</div>

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/datatable.js"></script>

<script src="dist/js/tbl_languages.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>