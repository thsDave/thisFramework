<?php require_once APP."/views/master/header.php"; ?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION['session_appname']['level']}_nav.php"; ?>

<?php $countries = $model->countries_list(); ?>

<?php
  $active1 = ''; $active2 = '';

  if (isset($_SESSION['tab_selected']))
  {
    switch ($_SESSION['tab_selected']) {
      case 'countries-list':
        $active1 = 'active';
      break;

      case 'new-countries':
        $active2 = 'active';
      break;

      default:
        $active1 = 'active';
      break;
    }
  }
  else
  {
    $active1 = 'active';
  }
?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fa-solid fa-earth-americas fa-xs"></i> <?= LANG['countries_title'] ?></h1>
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
          <div class="col-md-12">
            <div class="card card-dark card-outline">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link <?= $active1 ?>" href="#countries-list" id="tab-countries-list" data-toggle="tab" onclick="selecttab('countries-list');"><?= LANG['tab_records'] ?></a></li>
                  <li class="nav-item"><a class="nav-link <?= $active2 ?> " href="#new-countries" id="tab-new-countries" data-toggle="tab" onclick="selecttab('new-countries');"><?= LANG['tab_new'] ?></a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="<?= $active1 ?> tab-pane" id="countries-list">
                    <div class="row">
                      <div class="col-12">
                        <table class="table table-striped datable_es">
                          <thead class="bg-dark">
                            <tr>
                              <td>No</td>
                              <td><?= LANG['field_country'] ?></td>
                              <td><?= LANG['field_badge'] ?></td>
                              <td><?= LANG['field_iso'] ?></td>
                              <td><?= LANG['field_status'] ?></td>
                              <td><?= LANG['field_status'] ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($countries)): ?>
                            <?php $n = 1; ?>
                            <?php foreach ($countries['idcountry'] as $i => $id): ?>
                            <tr>
                              <td><?= $n ?></td>
                              <td><?= $countries['country'][$i] ?></td>
                              <td><?= $countries['badge'][$i] ?></td>
                              <td><?= $countries['isocode'][$i] ?></td>
                              <td>
                                <?php if ($countries['idstatus'][$i] == 2): ?>
                                <span class="badge badge-pill badge-danger"><?= $countries['status'][$i] ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-success"><?= $countries['status'][$i] ?></span>
                                <?php endif ?>
                              </td>
                              <td>
                                <button type="button" class="btn btn-sm btn-info" onclick="edit(<?= $id ?>);" data-toggle="tooltip" data-bs-placement="top" title="Editar registro">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <?php $btn = ($countries['idstatus'][$i] == 1) ? ['btn-warning', LANG['countries_deactivate']] : ['btn-success', LANG['countries_activate']]; ?>
                                <button type="button" class="btn btn-sm <?= $btn[0] ?>" onclick="change(<?= $id ?>, <?= $countries['idstatus'][$i] ?>);" data-toggle="tooltip" data-bs-placement="top" title="<?= $btn[1] ?>">
                                  <i class="fa-solid fa-rotate"></i>
                                </button>
                              </td>
                            </tr>
                            <?php $n++; ?>
                            <?php endforeach ?>
                            <?php endif ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="<?= $active2 ?> tab-pane" id="new-countries">
                    <div class="row">
                      <div class="col-12">
                        <div class="card card-dark">
                          <div class="card-header">
                            <h3 class="card-title"><?= LANG['countries_new'] ?></h3>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-12">
                                <form id="new_form">
                                  <div class="form-row">
                                    <div class="col-12">
                                      <div class="form-group">
                                        <label for="new-countries"><?= LANG['countries_name'] ?></label>
                                        <div class="input-group">
                                          <input type="text" class="form-control" id="new-countries" name="country" placeholder="<?= LANG['countries_name'] ?>" required autofocus>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="col-12">
                                      <div class="form-group">
                                        <label for="new-divisa"><?= LANG['countries_badge'] ?></label>
                                        <div class="input-group">
                                          <input type="text" class="form-control" id="new-divisa" name="badge" placeholder="<?= LANG['countries_badge'] ?>" required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="col-12">
                                      <div class="form-group">
                                        <label for="new-code"><?= LANG['countries_iso'] ?></label>
                                        <div class="input-group">
                                          <input type="text" class="form-control" id="new-code" name="code" placeholder="<?= LANG['countries_iso'] ?>" required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-row mt-4">
                                    <div class="col-12">
                                      <button type="submit" class="btn btn-sm btn-success" id="btn_newcountries">
                                        <i class="fa-solid fa-floppy-disk"></i> <?= LANG['save_button'] ?>
                                      </button>
                                      <button type="reset" class="btn btn-sm btn-danger" id="btn_cancel">
                                        <i class="fa-solid fa-ban"></i> <?= LANG['cancel_button'] ?>
                                      </button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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

<div class="modal fade" id="edit-countries">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= LANG['countries_edit'] ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit_form" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="editname"><?= LANG['countries_name'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="editname" name="editname" placeholder="<?= LANG['countries_name'] ?>" required autofocus>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="editbadge"><?= LANG['countries_badge'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="editbadge" name="editbadge" placeholder="<?= LANG['countries_badge'] ?>" required>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="editcode"><?= LANG['countries_iso'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="editcode" name="editcode" placeholder="<?= LANG['countries_iso'] ?>" required>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row mt-4">
            <div class="col-12 col-sm-6 col-md-12">
              <button type="button" class="btn btn-sm btn-dark float-left" data-dismiss="modal"><?= LANG['close_button'] ?></button>
              <button type="button" class="btn btn-sm btn-info float-right" id="btn_editcountry">
                <?= LANG['edit_button'] ?> <i class="fa-solid fa-angle-right"></i>
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

<script src="dist/js/crud_countries.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>