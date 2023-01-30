<?php require_once APP."/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['session_appname']['level']}_nav.php"; ?>

<?php $fotos = $model->thumbnail_profile(); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-money-check-edit fa-xs"></i> <?= LANG['newuser_title'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['newuser_title'] ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-6">
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title"><?= LANG['newuser_header'] ?></h3>
              </div>
              <form id="register-form">
                <div class="card-body">
                  <div class="form-group">
                    <img class="profile-user-img img-fluid img-circle" src="data:image/png;base64,<?= $fotos['pic'][0] ?>" alt="User profile picture">
                  </div>
                  <div class="form-group">
                    <label for="name"><?= LANG['newuser_name'] ?></label>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" name="name" id="name" placeholder="<?= LANG['newuser_name'] ?>" required autofocus>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-user"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email"><?= LANG['newuser_email'] ?></label>
                    <div class="input-group mb-3">
                      <input type="email" class="form-control" name="email" id="email" placeholder="<?= LANG['newuser_email'] ?>" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email2"><?= LANG['newuser_email2'] ?></label>
                    <div class="input-group mb-3">
                      <input type="email" class="form-control" name="email2" id="email2" placeholder="<?= LANG['newuser_email2'] ?>" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="country"><?= LANG['newuser_country'] ?></label>
                    <div class="input-group mb-3">
                      <select name="country" id="country" class="form-control select2" required>
                        <?php $countries = $model->countries_list(); ?>
                        <option value="" selected disabled><?= LANG['select_item'] ?></option>
                        <?php foreach ($countries['idcountry'] as $key => $val): ?>
                        <option value="<?= $val ?>"><?= $countries['country'][$key] ?></option>
                        <?php endforeach ?>
                      </select>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-globe-americas"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="from-group">
                    <label for="lang"><?= LANG['newuser_lang'] ?></label>
                    <div class="input-group mb-3">
                      <select name="lang" id="lang" class="form-control select2" required>
                        <?php $langs = $model->language_list(); ?>
                        <option value="" selected disabled><?= LANG['select_item'] ?></option>
                        <?php foreach ($langs['idlang'] as $key => $val): ?>
                        <option value="<?= $val ?>"><?= $langs['language'][$key] ?></option>
                        <?php endforeach ?>
                      </select>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-language"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="from-group">
                    <label for="level"><?= LANG['newuser_level'] ?></label>
                    <div class="input-group mb-3">
                      <select name="level" id="level" class="form-control select2">
                        <?php $levels = $model->level_list(); ?>
                        <option value="" selected disabled><?= LANG['select_item'] ?></option>
                        <?php foreach ($levels['id'] as $key => $val): ?>
                        <?php if ($_SESSION['session_appname']['idlvl'] == 1): ?>
                          <option value="<?= $val ?>"><?= $levels['alias'][$key] ?></option>
                        <?php else: ?>
                          <?php if ($val != 1): ?>
                            <option value="<?= $val ?>"><?= $levels['alias'][$key] ?></option>
                          <?php endif ?>
                        <?php endif ?>
                        <?php endforeach ?>
                      </select>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="fa-solid fa-users-viewfinder"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="pass1"><?= LANG['newuser_pass'] ?></label>
                    <div class="input-group mb-3">
                      <input type="password" class="form-control" name="pass1" id="pass1" placeholder="<?= LANG['newuser_pass'] ?>" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="fa-solid fa-key"></i>
                        </div>
                      </div>
                    </div>
                    <small id="mnsj" class="form-text text-muted" style="margin-top: -10px;"><?= LANG['pass_mnsj'] ?></small>
                  </div>
                  <div class="form-group">
                    <label for="pass2"><?= LANG['newuser_pass2'] ?></label>
                    <div class="input-group mb-3">
                      <input type="password" class="form-control" name="pass2" id="pass2" placeholder="<?= LANG['newuser_pass2'] ?>" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="fa-solid fa-key"></i>
                        </div>
                      </div>
                    </div>
                    <small id="mnsj2" class="form-text text-muted" style="margin-top: -10px;"><?= LANG['pass_mnsj'] ?></small>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row mb-3">
                    <div class="col-12">
                      <button type="submit" id="btn_register" class="btn btn-info btn-block" disabled><?= LANG['newuser_button'] ?></button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</div>


<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="dist/js/new_user.js" type="module"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>
