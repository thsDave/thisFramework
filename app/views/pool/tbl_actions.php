<?php require_once APP."/views/master/header.php"; ?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION[USER_SESSION]['level']}_nav.php"; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fa-solid fa-list-check fa-xs"></i> <?= LANG['action_title'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['action_title'] ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <button type="button" class="btn btn-sm btn-success" id="add_action" data-toggle="modal" data-target="#modal_action">
              <i class="fa-solid fa-circle-plus"></i> <?= LANG['tab_new'] ?>
            </button>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12">
            <table id="datable" class="table table-striped">
              <thead class="bg-dark">
                <tr>
                  <td>No</td>
                  <td><?= LANG['field_action'] ?></td>
                  <td><?= LANG['field_btbadge'] ?></td>
                  <td><?= LANG['field_showing'] ?></td>
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

<div class="modal fade" id="modal_action" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="action_form" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="action"><?= LANG['action_name'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="action" name="action" maxlength="50" placeholder="<?= LANG['action_name'] ?>" required autofocus>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="btbadge"><?= LANG['action_showing'] ?></label>
                <div class="input-group">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="success" name="btbadge" value="success">
                    <label class="custom-control-label" for="success"><span class="badge badge-success">success</span></label>
                  </div>
                </div>
                <div class="input-group">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="danger" name="btbadge" value="danger">
                    <label class="custom-control-label" for="danger"><span class="badge badge-danger">danger</span></label>
                  </div>
                </div>
                <div class="input-group">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="primary" name="btbadge" value="primary">
                    <label class="custom-control-label" for="primary"><span class="badge badge-primary">primary</span></label>
                  </div>
                </div>
                <div class="input-group">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="info" name="btbadge" value="info">
                    <label class="custom-control-label" for="info"><span class="badge badge-info">info</span></label>
                  </div>
                </div>
                <div class="input-group">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="warning" name="btbadge" value="warning">
                    <label class="custom-control-label" for="warning"><span class="badge badge-warning">warning</span></label>
                  </div>
                </div>
                <div class="input-group">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="dark" name="btbadge" value="dark">
                    <label class="custom-control-label" for="dark"><span class="badge badge-dark">dark</span></label>
                  </div>
                </div>
                <div class="input-group">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="secondary" name="btbadge" value="secondary">
                    <label class="custom-control-label" for="secondary"><span class="badge badge-secondary">secondary</span></label>
                  </div>
                </div>
                <div class="input-group">
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="light" name="btbadge" value="light">
                    <label class="custom-control-label" for="light"><span class="badge badge-light">light</span></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="text"><?= LANG['action_namebadge'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="text" name="text" maxlength="50" placeholder="<?= LANG['action_badge'] ?>" required>
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

<script src="dist/js/tbl_actions.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>