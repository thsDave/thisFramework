<?php require_once APP . "/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION[USER_SESSION]['level']}_nav.php"; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fa-solid fa-circle-question fa-xs"></i> <?= LANG['support_title'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?req=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['support_title'] ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title"><?= LANG['support_title'] ?></h3>
              </div>
              <form id="support-form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="subject"><?= LANG['support_subject'] ?></label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="<?= LANG['support_subject'] ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="mssg"><?= LANG['support_mnsj'] ?></label>
                    <textarea class="form-control" id="mssg" name="mssg" rows="3" placeholder="<?= LANG['support_mnsj'] ?>." required></textarea>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-dark"><?= LANG['support_send'] ?></button>
                </div>
              </form>
            </div>

          </div>

          <div class="col-md-8">
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title"><?= LANG['support_history'] ?></h3>
            </div>
            <div class="direct-chat-messages" style="height: 320px !important;">
            <?= $objHome->historysupportreq($_SESSION[USER_SESSION]['id']); ?>
            </div>
          </div>
        </div>

        </div>
      </div>
    </section>
  </div>



<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="dist/js/supportreq.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>
