<?php require_once APP . "/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['log']['level']}-nav.php"; ?>

<?php $disabled = (isset($_SESSION['updateInfoUser'])) ? '' : 'disabled'; ?>

<?php $user = $model->infoUsuario($_SESSION['val']); ?>
<?php $lvl = $sudo_m->lvlist(); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Perfil de usuario</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= URL ?>?req=home">Inicio</a></li>
            <li class="breadcrumb-item active">Perfil de usuario</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="data:image/png;base64,<?= $user['pic'] ?>" alt="User profile picture">
              </div>

              <h3 class="profile-username text-center"><?= $user['name'] ?></h3>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Cargo</b> <br>
                  <a class="float-left"><?= $user['position'] ?></a>
                </li>
                <li class="list-group-item">
                  <b>Tipo de acceso</b> <br>
                  <a class="float-left"><?= $user['level'] ?></a>
                </li>
                <li class="list-group-item">
                  <?php if (!isset($_SESSION['updateInfoUser'])) : ?>
                  <a href="<?= URL ?>?event=upInfo&val=on" class="btn btn-primary btn-block">Actualizar información</a>
                  <a href="<?= URL ?>?req=users" class="btn btn-dark btn-block">Volver</a>
                  <?php else : ?>
                  <a href="<?= URL ?>?event=upInfo&val=off" class="btn btn-warning btn-block">Finalizar edición</a>
                  <?php endif ?>
                </li>
                <li class="list-group-item">
                  <?php if (!isset($_SESSION['updateInfoUser'])): ?>
                  <button type="button" class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#modal_del">Eliminar usuario</button>
                  <?php endif ?>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Información</a></li>
                <li class="nav-item"><a class="nav-link" href="#access" data-toggle="tab">Acceso</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="settings">
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Nombre Completo</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="name" value="<?= $user['name'] ?>" placeholder="Ingresa aquí tu primer nombre" <?= $disabled ?> autofocus>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="position" class="col-sm-2 col-form-label">Cargo</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="position" value="<?= $user['position'] ?>" placeholder="Cargo" <?= $disabled ?>>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="level" class="col-sm-2 col-form-label">Nivel de usuario</label>
                    <div class="col-sm-10">
                      <select id="level" class="form-control" <?= $disabled ?>>
                        <?php foreach ($lvl['id'] as $i => $val): ?>
                        <?php if ($lvl['level'][$i] == $user['level']): ?>
                        <option value="<?= $val ?>" selected><?= $lvl['level'][$i] ?></option>
                        <?php else: ?>
                        <option value="<?= $val ?>"><?= $lvl['level'][$i] ?></option>
                        <?php endif ?>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="state" class="col-sm-2 col-form-label">Estado del usuario</label>
                    <div class="col-sm-10">
                      <?php $stts = ['Activo', 'Inactivo']; ?>
                      <select id="state" class="form-control" <?= $disabled ?>>
                        <?php foreach ($stts as $i => $val): ?>
                        <?php if ($val == $user['state']): ?>
                        <option value="<?= $i+1 ?>" selected><?= $val ?></option>
                        <?php else: ?>
                        <option value="<?= $i+1 ?>"><?= $val ?></option>
                        <?php endif ?>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <?php if (isset($_SESSION['updateInfoUser'])) : ?>
                  <div class="form-group row">
                    <label for="customFile" class="col-sm-2 col-form-label">Actualizar info</label>
                    <div class="col-sm-10">
                      <button type="button" id="updtinfousr" class="btn btn-success">Actualizar datos</button>
                    </div>
                  </div>
                  <?php endif ?>
                </div>
                <!-- /. Settings -->

                <div class="tab-pane" id="access">
                  <form class="form-horizontal">
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Cuenta</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputName" value="<?= $user['email'] ?>" disabled="true">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_pwd">
                          <i class="fas fa-key"></i> Actualizar contraseña
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal_pwd">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fas fa-key"></i> Actualizar contraseña</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="form-group">
            <label for="pass1">Nueva contraseña</label>
            <input type="password" name="pass" class="form-control" id="pass1" placeholder="Password" onkeyup="validapass1()" required>
            <small id="mnsj" class="form-text text-muted"></small>
          </div>
          <div class="form-group">
            <label for="pass2">Repita su contraseña</label>
            <input type="password" name="password" class="form-control" id="pass2" placeholder="Password" onkeyup="validapass2()" required>
            <small id="mnsj2" class="form-text text-muted"></small>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn btn-default float-left" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-dark float-right" value="updtpwd" id="btn_pass">Restablecer contraseña</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-dark justify-content-between">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_del">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-danger"><i class="fas fa-trash-alt"></i> Eliminar usuario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-danger">
        <div class="jumbotron">
          <p>¿Estás COMPLETAMENTE seguro de eliminar la cuenta <strong><?= $user['email'] ?></strong>? Recuerda que esta acción eliminará todas las acciones registradas por este usuario.</p><p>Si estás completamente seguro, escribe la siguiente frase de seguridad y presiona el botón <strong>eliminar usuario</strong></p>
          <p>Frase de seguridad: <span class="badge badge-light text-dark">delete.<?= $sudo_c->getmailusr($user['email']); ?></span></p>
          <div class="form-group">
            <input type="text" name="phrase" id="delphrase" class="form-control" required>
          </div>
          <div class="form-group">
            <button type="button" id="userdel" class="btn btn-xs btn-danger">
              <i class="fas fa-trash-alt"></i> Eliminar usuario
            </button>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-danger justify-content-between"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP . "/views/master/footer_js.php"; ?>

<script src="dist/js/pwdvalidate.js"></script>
<script src="dist/js/delusrprofile.js"></script>
<script src="dist/js/updtpwd.js"></script>
<script src="dist/js/updtusr.js"></script>

<?php require_once APP . "/views/master/footer_end.php"; ?>
