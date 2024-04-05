<?php require_once APP."/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION[USER_SESSION]['level']}_nav.php"; ?>

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
          <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-6">
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
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control" name="name" id="name" placeholder="<?= LANG['newuser_name'] ?>" required autofocus>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email"><?= LANG['newuser_email'] ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                      </div>
                      <input type="email" class="form-control" name="email" id="email" placeholder="<?= LANG['newuser_email'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email2"><?= LANG['newuser_email2'] ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                      </div>
                      <input type="email" class="form-control" name="email2" id="email2" placeholder="<?= LANG['newuser_email2'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="country"><?= LANG['newuser_country'] ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa-solid fa-earth-americas"></i></span>
                      </div>
                      <select name="country" id="country" class="form-control select2" required>
                        <?php $countries = $model->countries_list(); ?>
                        <option value="" selected disabled><?= LANG['select_item'] ?></option>
                        <?php foreach ($countries['idcountry'] as $key => $val): ?>
                        <option value="<?= $val ?>"><?= $countries['country'][$key] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="from-group">
                    <label for="lang"><?= LANG['newuser_lang'] ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa-solid fa-language"></i></span>
                      </div>
                      <select name="lang" id="lang" class="form-control select2" required>
                        <?php $langs = $model->language_list(); ?>
                        <option value="" selected disabled><?= LANG['select_item'] ?></option>
                        <?php foreach ($langs['idlang'] as $key => $val): ?>
                        <option value="<?= $val ?>"><?= $langs['language'][$key] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="from-group">
                    <label for="level"><?= LANG['newuser_level'] ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa-solid fa-users-viewfinder"></i></span>
                      </div>
                      <select name="level" id="level" class="form-control select2">
                        <?php $levels = $model->level_list(); ?>
                        <option value="" selected disabled><?= LANG['select_item'] ?></option>
                        <?php foreach ($levels['id'] as $key => $val): ?>
                        <?php if ($_SESSION[USER_SESSION]['idlvl'] == 1): ?>
                          <option value="<?= $val ?>"><?= $levels['alias'][$key] ?></option>
                        <?php else: ?>
                          <?php if ($val != 1): ?>
                            <option value="<?= $val ?>"><?= $levels['alias'][$key] ?></option>
                          <?php endif ?>
                        <?php endif ?>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="pass1"><?= LANG['newuser_pass'] ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                      </div>
                      <input type="password" class="form-control" name="pass1" id="pass1" placeholder="<?= LANG['newuser_pass'] ?>" required>
                    </div>
                    <small id="mnsj" class="form-text text-muted" style="margin-top: -10px;"><?= LANG['pass_mnsj'] ?></small>
                  </div>
                  <div class="form-group">
                    <label for="pass2"><?= LANG['newuser_pass2'] ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                      </div>
                      <input type="password" class="form-control" name="pass2" id="pass2" placeholder="<?= LANG['newuser_pass2'] ?>" required>
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
