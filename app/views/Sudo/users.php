<?php require_once APP."/views/master/header.php"; ?>

<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION['log']['level']}-nav.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de usuarios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home">Inicio</a></li>
              <li class="breadcrumb-item active">Lista de usuarios</li>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de usuarios</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped datable">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nombre</th>
                      <th>E-mail</th>
                      <th>Cargo</th>
                      <th>Nivel</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $users = $model->userlist(); ?>
                    <?php if ($users): ?>
                      <?php $no = 1; ?>
                      <?php foreach ($users['id'] as $i => $val): ?>
                        <?php if ($val != $_SESSION['log']['id']): ?>
                        <tr>
                          <td><?= $no ?></td>
                          <td><?= $users['name'][$i] ?></td>
                          <td><?= $users['email'][$i] ?></td>
                          <td><?= $users['position'][$i] ?></td>
                          <td><?= $users['level'][$i] ?></td>
                          <td><?= $users['state'][$i] ?></td>
                          <td>
                            <a href="<?= URL ?>?req=userprofile&val=<?= $val ?>" class="btn btn-sm btn-primary">
                              Ver perfil
                            </a>
                          </td>
                        </tr>
                        <?php $no++; ?>
                        <?php endif ?>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/datatable.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>
