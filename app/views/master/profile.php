<?php require_once APP . "/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['log']['level']}-nav.php"; ?>

<?php $disabled = (isset($_SESSION['updateInfoUser'])) ? '' : 'disabled'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Mi usuario</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= URL ?>?req=home">Inicio</a></li>
            <li class="breadcrumb-item active">Mi usuario</li>
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
          <div class="card card-dark card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="data:image/png;base64,<?= $_SESSION['log']['pic'] ?>" alt="User profile picture">
              </div>

              <h3 class="profile-username text-center"><?= $_SESSION['log']['name'] ?></h3>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Cargo</b> <br>
                  <a class="float-left"><?= $_SESSION['log']['position'] ?></a>
                </li>
                <li class="list-group-item">
                  <b>Tipo de acceso</b> <br>
                  <a class="float-left"><?= $_SESSION['log']['level'] ?></a>
                </li>
              </ul>
              <?php if (!isset($_SESSION['updateInfoUser'])) : ?>
                <a href="<?= URL ?>?event=upInfo&val=on" class="btn btn-dark btn-block">Actualizar información</a>
              <?php else : ?>
                <a href="<?= URL ?>?event=upInfo&val=off" class="btn btn-danger btn-block">Finalizar edición</a>
              <?php endif ?>
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
                  <form class="form-horizontal">
                    <div class="form-group row">
                      <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name" value="<?= $_SESSION['log']['name'] ?>" placeholder="Ingresa aquí tu primer nombre" <?= $disabled ?> autofocus>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="position" class="col-sm-2 col-form-label">Cargo</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="position" id="position" value="<?= $_SESSION['log']['position'] ?>" placeholder="Cargo" <?= $disabled ?>>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="customFile" class="col-sm-2 col-form-label">Imagen de perfil</label>
                      <div class="col-sm-10">
                        <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#picProfile"> Seleccionar imagen</button>
                        <?php if (isset($_SESSION['updateInfoUser'])) : ?>
                          <button type="button" id="updtUser" class="btn btn-success float-right">Guardar cambios</button>
                        <?php endif ?>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /. Settings -->

                <div class="tab-pane" id="access">
                  <form class="form-horizontal">
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Cuenta</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputName" value="<?= $_SESSION['log']['email'] ?>" disabled="true">
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
            <label for="currentPass">Contraseña actual</label>
            <input type="password" class="form-control" id="currentPass" placeholder="Password" required autofocus>
          </div>
          <div class="form-group">
            <label for="pass1">Nueva contraseña</label>
            <input type="password" class="form-control" id="pass1" placeholder="Password" onkeyup="validapass1()" required>
            <small id="mnsj" class="form-text text-muted"></small>
          </div>
          <div class="form-group">
            <label for="pass2">Repita su contraseña</label>
            <input type="password" class="form-control" id="pass2" placeholder="Password" onkeyup="validapass2()" required>
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

<?= $objHome->profilepics(); ?>

<!-- REQUIRED SCRIPTS -->

<?php require_once APP . "/views/master/footer_js.php"; ?>

<script src="dist/js/pwdvalidate.js"></script>
<script src="dist/js/updtpwd.js"></script>
<script>
<?php $objController->sweetAlert('updtUser', ['name', 'position'], 'Información actualizada', 'Usuario no actualizado', 'internal'); ?>
</script>


<?php require_once APP . "/views/master/footer_end.php"; ?>
