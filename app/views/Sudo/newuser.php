<?php require_once APP."/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['log']['level']}-nav.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Nuevo usuario</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home">Inicio</a></li>
              <li class="breadcrumb-item active">Nuevo usuario</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Nuevo registro de usuario</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Nombre completo</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nombre completo" autofocus required>
                </div>
                <div class="form-group">
                  <label for="position">Cargo</label>
                  <input type="text" class="form-control" id="position" name="position" placeholder="Cargo">
                </div>
                <div class="form-group">
                  <label for="email">Correo electrónico</label>
                  <input type="email" class="form-control" id="email" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                  <label for="email2">Repita su correo electrónico</label>
                  <input type="email" class="form-control" id="email2" placeholder="Repita su correo electrónico" required>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" id="newregister" class="btn btn-primary btn-block">Registrar usuario</button>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="dist/js/newuser.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>
