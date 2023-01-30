<?php require_once APP."/views/master/header.php"; ?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION['session_appname']['level']}_nav.php"; ?>

<?php $language = $model->language_list(); ?>

<?php
  $active1 = ''; $active2 = '';

  if (isset($_SESSION['tab_selected']))
  {
    switch ($_SESSION['tab_selected']) {
      case 'language-list':
        $active1 = 'active';
      break;

      case 'new-language':
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
            <h1><i class="fa-solid fa-language fa-xs"></i> <?= LANG['lang_title'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['lang_title'] ?></li>
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
                  <li class="nav-item"><a class="nav-link <?= $active1 ?>" href="#language-list" id="tab-language-list" data-toggle="tab" onclick="selecttab('language-list');"><?= LANG['tab_records'] ?></a></li>
                  <li class="nav-item"><a class="nav-link <?= $active2 ?> " href="#new-language" id="tab-new-language" data-toggle="tab" onclick="selecttab('new-language');"><?= LANG['tab_new'] ?></a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="<?= $active1 ?> tab-pane" id="language-list">
                    <div class="row">
                      <div class="col-12">
                        <table class="table table-striped datable_es">
                          <thead class="bg-dark">
                            <tr>
                              <td>No</td>
                              <td><?= LANG['field_lang'] ?></td>
                              <td><?= LANG['field_code'] ?></td>
                              <td><?= LANG['field_icon'] ?></td>
                              <td><?= LANG['field_status'] ?></td>
                              <td><?= LANG['field_actions'] ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($language)): ?>
                            <?php $n = 1; ?>
                            <?php foreach ($language['idlang'] as $i => $id): ?>
                            <tr>
                              <td><?= $n ?></td>
                              <td><?= $language['language'][$i] ?></td>
                              <td><?= $language['lancode'][$i] ?></td>
                              <td><?= $language['lanicon'][$i] ?></td>
                              <td>
                                <?php if ($language['idstatus'][$i] == 2): ?>
                                <span class="badge badge-pill badge-danger"><?= $language['status'][$i] ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-success"><?= $language['status'][$i] ?></span>
                                <?php endif ?>
                              </td>
                              <td>
                                <button type="button" class="btn btn-sm btn-info" onclick="edit(<?= $id ?>);" data-toggle="tooltip" data-bs-placement="top" title="Editar registro">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <?php $btn = ($language['idstatus'][$i] == 1) ? ['btn-warning', LANG['lang_deactivate']] : ['btn-success', LANG['lang_activate']]; ?>
                                <button type="button" class="btn btn-sm <?= $btn[0] ?>" onclick="change(<?= $id ?>, <?= $language['idstatus'][$i] ?>);" data-toggle="tooltip" data-bs-placement="top" title="<?= $btn[1] ?>">
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
                  <div class="<?= $active2 ?> tab-pane" id="new-language">
                    <div class="row">
                      <div class="col-12">
                        <div class="card card-dark">
                          <div class="card-header">
                            <h3 class="card-title"><?= LANG['lang_new'] ?></h3>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-12">
                                <form id="new_form">
                                  <div class="form-row">
                                    <div class="col-12">
                                      <div class="form-group">
                                        <label for="new-language"><?= LANG['lang_name'] ?></label>
                                        <div class="input-group">
                                          <input type="text" class="form-control" id="new-language" name="language" placeholder="<?= LANG['lang_name'] ?>" required autofocus>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="col-12">
                                      <div class="form-group">
                                        <label for="new-codigo"><?= LANG['lang_code'] ?></label>
                                        <div class="input-group">
                                          <input type="text" class="form-control" id="new-codigo" name="lancode" placeholder="<?= LANG['lang_code'] ?>" required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="col-12">
                                      <div class="form-group">
                                        <label for="new-icono"><?= LANG['lang_icon'] ?></label>
                                        <div class="input-group">
                                          <input type="text" class="form-control" id="new-icono" name="lanicon" placeholder="<?= LANG['lang_icon'] ?>" required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-row mt-4">
                                    <div class="col-12">
                                      <button type="submit" class="btn btn-sm btn-success" id="btn_newlanguage">
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

<div class="modal fade" id="edit-language">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= LANG['lang_edit'] ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit_form" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="editname"><?= LANG['lang_name'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="editname" name="editname" placeholder="<?= LANG['lang_name'] ?>" required autofocus>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="editlancode"><?= LANG['lang_code'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="editlancode" name="editlancode" placeholder="<?= LANG['lang_code'] ?>" required autofocus>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-12">
              <div class="form-group">
                <label for="editlanicon"><?= LANG['lang_icon'] ?></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="editlanicon" name="editlanicon" placeholder="<?= LANG['lang_icon'] ?>" required autofocus>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row mt-4">
            <div class="col-12 col-sm-6 col-md-12">
              <button type="button" class="btn btn-sm btn-dark float-left" data-dismiss="modal"><?= LANG['close_button'] ?></button>
              <button type="button" class="btn btn-sm btn-info float-right" id="btn_editlanguage">
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

<script src="dist/js/crud_languages.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>