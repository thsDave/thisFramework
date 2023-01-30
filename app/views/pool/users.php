<?php require_once APP."/views/master/header.php"; ?>

<?php $users = $model->user_list(); ?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION['session_appname']['level']}_nav.php"; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fa-solid fa-people-group fa-xs"></i> <?= LANG['users_title'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['users_title'] ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <table class="table table-striped <?= LANG['datable'] ?>">
              <thead class="bg-dark">
                <tr>
                  <td>No.</td>
                  <td><?= LANG['field_name'] ?></td>
                  <td><?= LANG['field_email'] ?></td>
                  <td><?= LANG['field_level'] ?></td>
                  <td><?= LANG['field_country'] ?></td>
                  <td><?= LANG['field_status'] ?></td>
                  <td><?= LANG['field_actions'] ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($users): ?>
                  <?php $no = 1; ?>
                  <?php foreach ($users['id'] as $i => $val): ?>
                    <?php if ($users['idcountry'][$i] == $_SESSION['session_appname']['idcountry'] && $_SESSION['session_appname']['idlvl'] != 1): ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= $users['name'][$i] ?></td>
                        <td><?= $users['email'][$i] ?></td>
                        <td><?= $users['level'][$i] ?></td>
                        <td><?= $users['country'][$i] ?></td>
                        <td>
                          <?php if ($users['status'][$i] == 'Activo'): ?>
                            <span class="description-text badge badge-success"><?= LANG['field_active'] ?></span>
                          <?php else: ?>
                            <span class="description-text badge badge-danger"><?= LANG['field_inactive'] ?></span>
                          <?php endif ?>
                        </td>
                        <td>
                          <a href="<?= URL ?>?req=user_profile&val=<?= $val ?>" class="btn btn-sm btn-dark">
                            <?= LANG['users_profile_button'] ?>
                          </a>
                        </td>
                      </tr>
                    <?php else: ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $users['name'][$i] ?></td>
                      <td><?= $users['email'][$i] ?></td>
                      <td><?= $users['level'][$i] ?></td>
                      <td><?= $users['country'][$i] ?></td>
                      <td>
                        <?php if ($users['status'][$i] == 'Activo'): ?>
                          <span class="description-text badge badge-success"><?= LANG['field_active'] ?></span>
                        <?php else: ?>
                          <span class="description-text badge badge-danger"><?= LANG['field_inactive'] ?></span>
                        <?php endif ?>
                      </td>
                      <td>
                        <a href="<?= URL ?>?req=user_profile&val=<?= $val ?>" class="btn btn-sm btn-dark">
                          <?= LANG['users_profile_button'] ?>
                        </a>
                      </td>
                    </tr>
                    <?php endif ?>
                  <?php $no++; ?>
                  <?php endforeach ?>
                <?php endif ?>
              </tbody>
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

<?php require_once APP."/views/master/footer_end.php"; ?>
