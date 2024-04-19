<?php require_once APP."/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION[USER_SESSION]['level']}_nav.php"; ?>

<?php $disabled = (isset($_SESSION['updateInfoUser'])) ? '' : 'disabled'; ?>
<?php $fotos = $model->thumbnail_profile(); ?>
<?php $lvl = $model->level_list(); ?>
<?php $countries = $model->countries_list(); ?>
<?php $langs = $model->language_list(); ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fa-solid fa-child-reaching fa-xs"></i> <?= LANG['profile_myuser'] ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= URL ?>?req=home"><?= LANG['home'] ?></a></li>
            <li class="breadcrumb-item active"><?= LANG['profile_myuser'] ?></li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <div class="card card-dark card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="data:image/png;base64,<?= $_SESSION[USER_SESSION]['pic'] ?>" alt="User profile picture" data-toggle="modal" data-target="#picProfile" style="cursor: pointer;">
              </div>

              <h3 class="profile-username text-center"><?= $_SESSION[USER_SESSION]['name'] ?></h3>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b><?= LANG['profile_email'] ?></b><br>
                  <a class="float-left"><?= $_SESSION[USER_SESSION]['email'] ?></a>
                </li>
                <li class="list-group-item">
                  <b><?= LANG['profile_level'] ?></b><br>
                  <a class="float-left"><?= $_SESSION[USER_SESSION]['alias'] ?></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="card card-dark card-outline">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="#info" id="profile-info-tab" data-toggle="tab"><?= LANG['profile_tab_info'] ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#access" id="profile-access-tab" data-toggle="tab"><?= LANG['profile_tab_access'] ?></a></li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="info">

                  <form id="profile_form">
                    <div class="form-group row">
                      <label for="name" class="col-sm-2 col-form-label"><?= LANG['profile_name'] ?></label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $_SESSION[USER_SESSION]['name'] ?>" placeholder="<?= LANG['profile_name'] ?>" <?= $disabled ?> autofocus>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="country" class="col-sm-2 col-form-label"><?= LANG['profile_country'] ?></label>
                      <div class="col-sm-10">
                        <select name="country" id="region" class="form-control select2" <?= $disabled ?>>
                          <?php foreach ($countries['idcountry'] as $key => $val): ?>
                            <?php $selected = ($countries['idcountry'][$key] == $_SESSION[USER_SESSION]['idcountry']) ? 'selected' : ''; ?>
                            <option value="<?= $val ?>" <?= $selected ?>><?= $countries['country'][$key] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="language" class="col-sm-2 col-form-label"><?= LANG['profile_lang'] ?></label>
                      <div class="col-sm-10">
                        <select id="language" name="language" class="form-control select2" <?= $disabled ?>>
                          <?php foreach ($langs['idlang'] as $i => $val): ?>
                            <?php $selected = ($val == $_SESSION[USER_SESSION]['idlang']) ? 'selected' : ''; ?>
                            <option value="<?= $val ?>" <?= $selected ?>><?= $langs['language'][$i] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row mt-4">
                      <div class="col-12">
                        <?php if (isset($_SESSION['updateInfoUser'])) : ?>
                          <button type="submit" class="btn btn-sm btn-success"><?= LANG['profile_update_button'] ?></button>
                          <a href="<?= URL ?>?event=upInfo&val=off" class="btn btn-sm btn-danger float-right"><?= LANG['profile_finish_button'] ?></a>
                        <?php else: ?>
                          <a href="<?= URL ?>?event=upInfo&val=on" class="btn btn-sm btn-info"><?= LANG['profile_update_button'] ?></a>
                        <?php endif ?>
                      </div>
                    </div>
                  </form>

                </div>

                <div class="tab-pane" id="access">

                  <div class="row">
                    <div class="col-12">
                      <form class="form-horizontal">
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label"><?= LANG['profile_account'] ?></label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputName" value="<?= $_SESSION[USER_SESSION]['email'] ?>" disabled="true">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_pwd">
                        <i class="fas fa-key"></i> <?= LANG['profile_update_button'] ?>
                      </button>
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

<div class="modal fade" id="modal_pwd">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fas fa-key"></i> <?= LANG['profile_pass_title'] ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <form id="password-form">
            <div class="form-group">
              <label for="curpass"><?= LANG['profile_curpass'] ?></label>
              <input type="password" class="form-control" name="curpass" id="curpass" placeholder="Contraseña actual" required>
              <small id="mnsj" class="form-text text-muted"><?= LANG['pass_mnsj'] ?></small>
            </div>
            <div class="form-group">
              <label for="pass1"><?= LANG['newuser_pass'] ?></label>
              <input type="password" class="form-control" name="pass1" id="pass1" placeholder="<?= LANG['newuser_pass'] ?>" required>
              <small id="mnsj1" class="form-text text-muted"></small>
            </div>
            <div class="form-group">
              <label for="pass2"><?= LANG['newuser_pass2'] ?></label>
              <input type="password" class="form-control" name="pass2" id="pass2" placeholder="<?= LANG['newuser_pass2'] ?>" required>
              <small id="mnsj2" class="form-text text-muted"></small>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="button" class="btn btn-default float-left" data-dismiss="modal"><?= LANG['close_button'] ?></button>
                <button type="submit" class="btn btn-dark float-right" id="btn_pass"><?= LANG['profile_uppass_button'] ?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer bg-dark justify-content-between">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="picProfile">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fas fa-users"></i> <?= LANG['profile_select_image'] ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tbody>
            <?php $r = round(count($fotos['id']) / 4); $y = 3; $x = 0; ?>
            <?php for ($i = 0; $i <= $r; $i++): ?>
              <tr>
              <?php for ($j = $x; $j <= $y; $j++): ?>
                <?php if ($j != count($fotos['id'])): ?>
                <td>
                  <a href="<?= URL ?>?event=profilepic&val=<?= $fotos['id'][$j] ?>">
                    <img src="data:image/png;base64,<?= $fotos['pic'][$j] ?>" class="w-75 imgProfile">
                  </a>
                </td>
                <?php else: ?>
                <?php break; ?>
                <?php endif ?>
              <?php endfor ?>
              </tr>
              <?php $x = $j; $y += ($i == $r) ? 3 : 4; ?>
            <?php endfor ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer bg-dark justify-content-between">
      </div>
    </div>
  </div>
</div>


<?php require_once APP . "/views/master/footer_js.php"; ?>

<script src="dist/js/profile.js" type="module"></script>

<?php require_once APP . "/views/master/footer_end.php"; ?>