<?php require_once APP."/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION[USER_SESSION]['level']}_nav.php"; ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= LANG['starter1'] ?> <?= $_SESSION[USER_SESSION]['starter_name'] ?>!</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><?= LANG['starter2'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['starter3'] ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
      </div>
    </section>

  </div>
</div>

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="dist/js/welcome.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>